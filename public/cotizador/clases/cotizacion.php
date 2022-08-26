<?php
require_once "../clases/mysql.class.php";

class Cotizacion{
    public $mensaje = "";


    public function clonarCotizacion($codCabCotiza, $codProspecto) {
      $db= new MySQL();
      $queries = array();

      if ($db->Error()) {
          $db->Kill();
          return false;
      } else {
          $consulta = 'SELECT * FROM tp_cabecera_cotizacion AS cot WHERE cot.codCabCotiza = \''.$codCabCotiza.'\'';
          if ($db->HasRecords($consulta)) {
              $db->Query($consulta);
              $row = $db->Row();

              if ($db->Query('INSERT INTO tp_cabecera_cotizacion (codProspecto, codSistProducto, fecha, codTipoVenta, descripcion, superficie, superficieMedida, codCanal, codSegmento, codEstado, tipoCotizacion, material, manoobra, total) VALUES (\''.$codProspecto.'\', \''.$row->codSistProducto.'\', \''.date('Y-m-d H:i:s').'\', \''.$row->codTipoVenta.'\', \''.$row->descripcion.'\', \''.$row->superficie.'\', \''.$row->superficieMedida.'\', \''.$row->codCanal.'\', \''.$row->codSegmento.'\', \''.$row->codEstado.'\', \''.$row->tipoCotizacion.'\', \''.$row->material.'\', \''.$row->manoobra.'\', \''.$row->total.'\')')) {
                $newcotiza = $db->GetLastInsertID();
                $query = 'SELECT * FROM tp_detalle_cotizacion AS det WHERE det.codCabCotiza = \''.$codCabCotiza.'\' AND det.baja = \'0\'';
                if ($db->HasRecords($query)) {
                    $db->Query($query);
                    while(!$db->EndOfSeek()) {
                        $result = $db->Row();
                        $queries[] = 'INSERT INTO tp_detalle_cotizacion (codCabCotiza, dimension, codUnidInv, cantidad, precioUnit, descuento, codProducto, total, baja) VALUES (\''.$newcotiza.'\', \''.$result->dimension.'\', \''.$result->codUnidInv.'\', \''.$result->cantidad.'\', \''.$result->precioUnit.'\', \''.$result->descuento.'\', \''.$result->codProducto.'\', \''.$result->total.'\', \'0\')';
                    }
                    foreach($queries as $q) {
                      $db->Query($q);
                    }
                }
              } else {
                return false;
              }
          }

          return false;
      }
    }

    public function listCotizacionesCerradas($postData) {
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }

        $conditions = '';

        if (!empty($postData)) {
          foreach($postData as $key => $value) {
            if ($value != '') {
              if ($key == 'dtFiltro_fecha') {
                $values = explode(' - ', $value);
                $conditions .= ' AND cot.fechaDocCierre BETWEEN \''.date('Y-m-d', strtotime($values[0])).'\' AND \''.date('Y-m-d', strtotime($values[1])).'\'';
              } else if ($key == 'iVendedor_id') {
                $conditions .= ' AND p.codUsuario = \''.$value.'\'';
              } else if ($key == 'iOficina_id') {
                $conditions .= ' AND u.codOficina = \''.$value.'\'';
              }
            }
          }
        }

        $consulta = 'SELECT CONCAT(CONCAT(per.nombre, \' \', per.apePat), \' \', per.apeMat) AS vendedor, o.descripcion AS oficina, p.nombre, sc.descripcion AS sistConst, cot.codProspecto, cot.codCabCotiza, cot.descripcion, cot.fechaCierre, cot.total, cot.fechaDocCierre FROM tp_cabecera_cotizacion AS cot LEFT JOIN prospecto AS p ON p.codProspecto = cot.codProspecto LEFT JOIN tp_sistema_constructivo AS sc ON sc.codSistema = cot.codSistProducto LEFT JOIN usuario AS u ON u.codUsuario = p.codUsuario LEFT JOIN persona AS per ON per.codPersona = u.codPersona LEFT JOIN oficina AS o ON o.codOficina = u.codOficina WHERE cot.codEstado = \'4\''.$conditions.' ORDER BY cot.total DESC';

        if ($db->HasRecords($consulta)) {
            $db->Query($consulta);
            return $db;
        }

        return false;
    }

//******************************************************************************************************

      function NuevaOctubre($codprospecto, $tipo, $clase, $subtipo, $sistemasCons, $descripcion, $superficie, $superficie2, $tipoventa, $canal, $segmento, $obra, $distrito, $probcierre){
          $success = true;
          // Creo una nueva conexion
          $db= new MySQL();
          if ($db->Error()){
              $db->Kill();
              return "0";
          }

          $sistemacons = $sistemasCons;
          /*
          $c = 0;
          foreach($sistemasCons as $sistema) {
            $c++;
            if ($c == 1) {
              $sistemacons .= $sistema;
            } else {
              $sistemacons .= ','.$sistema;
            }
          }
          */

          // Valido los parametros de entrada
          if(($tipo!="sc")&&($tipo!="vg")){
              $success=false;
          }
          $descripcion=mb_strtoupper($descripcion,'utf-8');
          $descripcion=$db->SQLFix($descripcion);
          $superficie=$db->SQLFix($superficie);
          $obra=$db->SQLFix($obra);
          $distrito=$db->SQLFix($distrito);
          $consulta="insert into  tp_cabecera_cotizacion ( codProspecto ,  codSistProducto ,  fecha ,  codTipoVenta ,  descripcion ,  superficie, superficieMedida ,  codCanal ,  codSegmento ,  codEstado ,  codObra ,  distrito ,  tipoCotizacion, prob ) VALUES ('$codprospecto','$sistemacons', SYSDATE(),'$tipoventa','$descripcion','$superficie', '$superficie2' ,'$canal','$segmento','1','$obra','$distrito','$tipo', '".number_format($probcierre, 2, '.', '')."') ";
        // echo $consulta; die();
          // Habilito excepciones
          $db->ThrowExceptions = true;
          if (! $db->TransactionBegin()) $db->Kill();
          $sql = $consulta;
          if (!$db->Query($sql)){
              $success = false;
              $this->mensaje=" Error al crear cabecera.<br>";
          }else{
              $codCabCotiza=$db->GetLastInsertID();
              //inserto el detalle para esta cotización
              if($tipo=="sc"){
                  $consulta=" INSERT INTO tp_detalle_cotizacion (codCabCotiza,dimension, codUnidInv, cantidad, precioUnit, descuento, codProducto, total, baja)
      select '$codCabCotiza','1', p.codUnidInv, 0, IFNULL(pr.cantidad,0), 0, p.codProducto, 0, '0'
      from tp_producto_sap as p
      inner join tp_sistema_producto as s on s.codProducto=p.codProducto
      left join tp_precio as pr on pr.codProducto=p.codProducto and pr.baja='0' and pr.codOficina=(
      select usr.codOficina from prospecto as pr
      left join usuario as usr on usr.codUsuario=pr.codUsuario
      where pr.codProspecto='$codprospecto'
      )
      where codSistema='$sistemacons'";
                  if (!$db->Query($consulta)){
                      $success = false;
                      $this->mensaje=" Error al crear detalle.<br>";
                  }
              }else if($tipo="vg"){

              }else{

              }
          }
          // Si hizo todo bien
          if ($success) {
              if (!$db->TransactionEnd()) {
                  $db->Kill();
              }
              return $codCabCotiza;
          } else {
              if (! $db->TransactionRollback()) {
                  $db->Kill();
              }
          }
          return "0";
      }
    
//******************************************************************************************************

      function NuevaOctubreMF($codprospecto, $tipo, $clase, $subtipo, $sistemasCons, $descripcion, $superficie, $superficie2, $tipoventa, $canal, $segmento, $obra, $distrito, $probcierre){
          $success = true;
          // Creo una nueva conexion
          $db= new MySQL();
          if ($db->Error()){
              $db->Kill();
              return "0";
          }

          $sistemacons = $sistemasCons;
          /*
          $c = 0;
          foreach($sistemasCons as $sistema) {
            $c++;
            if ($c == 1) {
              $sistemacons .= $sistema;
            } else {
              $sistemacons .= ','.$sistema;
            }
          }
          */

          // Valido los parametros de entrada
          
          $descripcion=mb_strtoupper($descripcion,'utf-8');
          $descripcion=$db->SQLFix($descripcion);
          $superficie=$db->SQLFix($superficie);
          $obra=$db->SQLFix($obra);
          $distrito=$db->SQLFix($distrito);
          $consulta="insert into  tp_cabecera_cotizacion ( codProspecto ,  codSistProducto ,  fecha ,  codTipoVenta ,  descripcion ,  superficie, superficieMedida ,  codCanal ,  codSegmento ,  codEstado ,  codObra ,  distrito ,  tipoCotizacion, prob ) VALUES ('$codprospecto','$sistemacons', SYSDATE(),'$tipoventa','$descripcion','$superficie', '$superficie2' ,'$canal','$segmento','1','$obra','$distrito','$tipo', '".number_format($probcierre, 2, '.', '')."') ";
        //  echo $consulta; die();
          // Habilito excepciones
          $db->ThrowExceptions = true;
          if (! $db->TransactionBegin()) $db->Kill();
          $sql = $consulta;
          if (!$db->Query($sql)){
              $success = false;
              $this->mensaje=" Error al crear cabecera.<br>";
          }
          $codCabCotiza=$db->GetLastInsertID();
          // Si hizo todo bien
          if ($success) {
              if (!$db->TransactionEnd()) {
                  $db->Kill();
              }
              return $codCabCotiza;
          } else {
              if (! $db->TransactionRollback()) {
                  $db->Kill();
              }
          }
          return "fuck";
      }
    
//******************************************************************************************************

    function Nueva($codprospecto, $tipo, $clase, $subtipo, $sistemacons, $descripcion, $superficie, $superficie2, $tipoventa, $canal, $segmento, $obra, $distrito){
        $success = true;
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }

        // Valido los parametros de entrada
        if(($tipo!="sc")&&($tipo!="vg")){
            $success=false;
        }
        $descripcion=mb_strtoupper($descripcion,'utf-8');
        $descripcion=$db->SQLFix($descripcion);
        $superficie=$db->SQLFix($superficie);
        $obra=$db->SQLFix($obra);
        $distrito=$db->SQLFix($distrito);
        $consulta="insert into  tp_cabecera_cotizacion ( codProspecto ,  codSistProducto ,  fecha ,  codTipoVenta ,  descripcion ,  superficie, superficieMedida ,  codCanal ,  codSegmento ,  codEstado ,  codObra ,  distrito ,  tipoCotizacion ) VALUES ('$codprospecto','$sistemacons', SYSDATE(),'$tipoventa','$descripcion','$superficie', '$superficie2' ,'$canal','$segmento','1','$obra','$distrito','$tipo') ";

        // Habilito excepciones
        $db->ThrowExceptions = true;
        if (! $db->TransactionBegin()) $db->Kill();
        $sql = $consulta;
        if (!$db->Query($sql)){
            $success = false;
            $this->mensaje=" Error al crear cabecera.<br>";
        }else{
            $codCabCotiza=$db->GetLastInsertID();
            //inserto el detalle para esta cotización
            if($tipo=="sc"){
                $consulta=" INSERT INTO tp_detalle_cotizacion (codCabCotiza,dimension, codUnidInv, cantidad, precioUnit, descuento, codProducto, total, baja)
select '$codCabCotiza','1', p.codUnidInv, 0, IFNULL(pr.cantidad,0), 0, p.codProducto, 0, '0'
from tp_producto_sap as p
inner join tp_sistema_producto as s on s.codProducto=p.codProducto
left join tp_precio as pr on pr.codProducto=p.codProducto and pr.baja='0' and pr.codOficina=(
    select usr.codOficina from prospecto as pr
    left join usuario as usr on usr.codUsuario=pr.codUsuario
    where pr.codProspecto='$codprospecto'
)
where codSistema='$sistemacons'";

                if (!$db->Query($consulta)){
                    $success = false;
                    $this->mensaje=" Error al crear detalle.<br>";
                }

            }else if($tipo="vg"){

            }else{

            }
        }
        // Si hizo todo bien
        if ($success) {
            if (!$db->TransactionEnd()) {
                $db->Kill();
            }
            return $codCabCotiza;
        } else {
            if (! $db->TransactionRollback()) {
                $db->Kill();
            }
        }
        return "0";
    }
//******************************************************************************************************
    function ObtenerCotizaciones($codprospecto="", $codcotizacion=""){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $condicion="";
        if($codprospecto!=""){
            $condicion.=" and cab.codProspecto=$codprospecto";
        }
        if($codcotizacion!=""){
            $condicion.=" and cab.codCabCotiza='$codcotizacion'";
        }
        $consulta="
select cab.codCabCotiza, cab.codprospecto, cab.codSistProducto, sc.descripcion as sistemaConstructivo,
cab.fecha, cab.codTipoVenta, tv.descripcion as tipoVenta, cab.descripcion, cab.superficie, cab.codCanal,
can.descripcion as canal, cab.codSegmento, seg.descripcion as segmento, cab.codEstado,
es.descripcion as estado, cab.codObra, cab.distrito, cab.tipoCotizacion,
date_format(fecha,'%d-%m-%Y') as fecha2, cl.descripcion as clase, cl.codClaseSistema,
st.descripcion as subtipo, st.codSubtipoSistema, cab.material, cab.manoobra, cab.otros, cab.total,
(select sum(monto) as pactado from forma_pago_prospecto where baja='0' and codVehiculoProspecto=cab.codCabCotiza) as pactado,
date_format(cab.fechaDocCierre,'%d-%m-%Y') as fechaDocCierre, cab.nroDocCierre, cab.instalador,
cab.adicional, cab.observaciones, cab.prob, date_format(cab.fechaprob,'%d-%m-%Y') as fechaprob2, date_format(cab.fechaprob,'%Y-%m-%d') as fechaprob, cab.superficieMedida, ms.descripcion as motivoSuspension,
cab.total - (select sum(monto) as pactado from forma_pago_prospecto where baja='0' and codVehiculoProspecto=cab.codCabCotiza) as pendiente
from tp_cabecera_cotizacion as cab
left join tp_tipo_venta as tv on tv.codTipoVenta=cab.codTipoVenta
left join tp_canal as can on can.codCanal=cab.codCanal
left join tp_segmento as seg on seg.codSegmento=cab.codSegmento
left join tp_estado as es on es.codEstado=cab.codEstado
left join tp_sistema_constructivo as sc on sc.codSistema=cab.codSistProducto
left join tp_clase_sistema as cl on cl.codClaseSistema=sc.codClaseSistema
left join tp_subtipo_sistema as st on st.codSubtipoSistema = sc.codSubtipoSistema
left join motivo_suspension as ms on ms.codMotivoSuspension=cab.codMotivoSuspension
where 1 and cab.codEstado!=3  $condicion order by cab.codCabCotiza desc;
		";
        //echo $consulta;
        $db->Query($consulta);
        return $db;
    }
//******************************************************************************************************
    function ObtenerDetalle($codcotizacion="", $codigousuario){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $consulta="
select det.codDetalle, det.dimension, det.codUnidInv, det.cantidad,
det.precioUnit, det.descuento, det.codProducto, det.total, p.codSAP,
p.descripcion as producto, u.descripcion as unidadInv, st.cantidad as stock
from tp_detalle_cotizacion as det
inner join tp_producto_sap as p on p.codProducto=det.codProducto
inner join tp_unidad_inventario as u on u.codUnidInv=det.codUnidInv
left join tp_stock as st on st.codproducto=p.codproducto and st.baja='0' and st.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
where det.codCabCotiza='$codcotizacion' and det.baja='0' ";

        $db->Query($consulta);
        return $db;
    }
//******************************************************************************************************
    function Modificar($codCotizacion, $superficie, $material, $manoobra, $otros, $total, $detallesArray){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        // Preparo los valores a ser insertados
        $superficie=$db->SQLFix($superficie);
        $material=$db->SQLFix($material);
        $manoobra=$db->SQLFix($manoobra);
        $otros=$db->SQLFix($otros);
        $total=$db->SQLFix($total);
        // Habilito excepciones
        $db->ThrowExceptions = true;
        if (! $db->TransactionBegin()) $db->Kill();

        $success = true;
        // modifico la cabecera
        if($material+$manoobra+$otros!=$total){
            $total=$material+$manoobra+$otros;
        }
        $consulta="update tp_cabecera_cotizacion set superficie='$superficie', material='$material', manoobra='$manoobra', otros='$otros', total='$total' where codCabCotiza='$codCotizacion'";
        if (! $db->Query($consulta)){
            $success = false;
        }else{
            // modifico el detalle
            for($i = 0; $i < count($detallesArray); $i++) {
                $item=$detallesArray[$i];
                if($item[4]!=((($item[1]*$item[2])*(100-$item[3]))/100)){
                    $item[4]=((($item[1]*$item[2])*(100-$item[3]))/100);
                }
                $consulta="update tp_detalle_cotizacion set cantidad='".$item[1]."', precioUnit='".$item[2]."', descuento='".$item[3]."', total='".$item[4]."' where codDetalle='".$item[0]."' ";
                if (!$db->Query($consulta)){
                    $success = false;
                }
            }
        }
        // Si hizo todo bien
        if ($success) {
            if (! $db->TransactionEnd()) {
                $db->Kill();
            }
            return true;
        } else {
            if (! $db->TransactionRollback()) {
                $db->Kill();
            }
        }
        return false;
    }
//******************************************************************************************************
    function ListarProductos($codcab="", $codigousuario="", $bsq=""){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $condicion="";
        if($codcab!=""){
            $condicion =" and dc.codProducto is null ";
        }
        if($bsq!=""){
            $condicion =" and (p.descripcion like '%$bsq%' or p.codSAP like '%$bsq%')  ";
        }
        $consulta="select distinct p.codProducto, p.codSAP, p.descripcion, p.codUnidInv,
        u.descripcion as unidad, p.codGrupo, g.descripcion as grupo,
        p.codTipoArt, t.descripcion as Tipo, p.codSubTipo, s.descripcion as Subtipo,
        p.codUEN, p.codUEN1, p.codUEN2, st.cantidad as stock, pr.cantidad  as precio
        from tp_producto_sap as p
        left join tp_unidad_inventario as u on u.codUnidInv=p.codUnidInv
        left join tp_grupo as g on g.codGrupo=p.codgrupo
        left join tp_tipo_articulo as t on t.codTipoArticulo=p.codTipoArt
        left join tp_subtipo_articulo as s on s.codSubtipoArticulo=p.codSubTipo
        left join tp_detalle_cotizacion dc on dc.codCabCotiza='$codcab' and dc.codProducto=p.codProducto and dc.baja='0'
        left join tp_stock as st on st.codproducto=p.codproducto and st.baja='0'
        and st.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
        left join tp_precio as pr on pr.codproducto=p.codproducto and pr.baja='0'
        and pr.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
        where 1=1 $condicion
        ";
        //echo $consulta; die();
        $db->Query($consulta);
        return $db;
    }
    //****************************************************************************************************
    function EliminarProducto($codCotizacion, $codDetalle){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        // Preparo los valores a ser insertados
        $codCotizacion=$db->SQLFix($codCotizacion);
        $codDetalle=$db->SQLFix($codDetalle);
        // Habilito excepciones
        $db->ThrowExceptions = true;
        if (! $db->TransactionBegin()) $db->Kill();
        $success = true;
        $consulta="update tp_detalle_cotizacion set baja='1' where codDetalle in ($codDetalle) and codCabCotiza='$codCotizacion' ";
		//echo $consulta;
        if (! $db->Query($consulta)){
            $success = false;
        }
        // Si hizo todo bien
        if ($success) {
            if (! $db->TransactionEnd()) {
                $db->Kill();
            }
            return true;
        } else {
            if (! $db->TransactionRollback()){
                $db->Kill();
            }
        }
        return false;
    }
    //****************************************************************************************************
    function AgregarProductos($codCotizacion, $codProductos){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        // Preparo los valores a ser insertados
        $codCotizacion=$db->SQLFix($codCotizacion);
        $codProductos=$db->SQLFix($codProductos);
        // Habilito excepciones
        $db->ThrowExceptions = true;
        if (! $db->TransactionBegin()) $db->Kill();
        $success = true;
        $consulta="insert into tp_detalle_cotizacion ( codCabCotiza, dimension, codUnidInv, cantidad, precioUnit, descuento, codProducto, total, baja)
select $codCotizacion, 1, ps.codUnidInv, 0, IFNULL(pr.cantidad,0), 0,  ps.codProducto, 0, '0'
from tp_producto_sap as ps
left join tp_precio as pr on pr.codProducto=ps.codProducto and pr.baja='0' and pr.codOficina=(
    select distinct usr.codOficina
    from tp_cabecera_cotizacion as cab
    left join prospecto as pro on pro.codProspecto=cab.codProspecto
    left join usuario as usr on usr.codUsuario=pro.codUsuario
    where pro.codProspecto=(select codProspecto from tp_cabecera_cotizacion where codCabCotiza='$codCotizacion')
)
where ps.codProducto in ($codProductos) and ps.codProducto not in (select codProducto from tp_detalle_cotizacion where codCabCotiza='$codCotizacion' and baja='0')
";
		// echo $consulta;
        if (! $db->Query($consulta)){
            $success = false;
        }
        // Si hizo todo bien
        if ($success) {
            if (! $db->TransactionEnd()) {
                $db->Kill();
            }
            return true;
        } else {
            if (! $db->TransactionRollback()) {
                $db->Kill();
            }
        }
        return false;
    }
    //*****************************************************************************************************
    function EliminarCotizacion($codCotizacion, $codMotivo){
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
          // Preparo los valores a ser insertados
        $codCotizacion=$db->SQLFix($codCotizacion);
        // Habilito excepciones
        $db->ThrowExceptions = true;
        if (! $db->TransactionBegin()) $db->Kill();
        $success = true;
        $consulta="update tp_cabecera_cotizacion set codEstado='2', codMotivoSuspension='$codMotivo' where codCabCotiza='$codCotizacion'
";
        if (! $db->Query($consulta)){
            $success = false;
        }
        // Si hizo todo bien
        if ($success) {
            if (! $db->TransactionEnd()) {
                $db->Kill();
            }
            return true;
        } else {
            if (! $db->TransactionRollback()) {
                $db->Kill();
            }
        }
        return false;
    }

    //*****************************************************************************************************
    function ModificarCotizacion($codCotizacion, $desc, $tipo, $sup, $supMedida, $canal, $segmento, $obs, $adicional, $prob, $fecha){
         $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }

        if($adicional==""){
            $adicional="0";
        }

        // Preparo los valores a ser insertados
        $codCotizacion=$db->SQLFix($codCotizacion);
        // Habilito excepciones
        $db->ThrowExceptions = true;
        if (! $db->TransactionBegin()) $db->Kill();
        $success = true;
        $consulta="update tp_cabecera_cotizacion set descripcion='$desc', codTipoVenta='$tipo', superficie='$sup', superficieMedida='$supMedida', codCanal='$canal', codSegmento='$segmento', observaciones='$obs', adicional='$adicional', prob='$prob', fechaprob=case when year('$fecha')>2015 then  '$fecha' else NULL end where codCabCotiza='$codCotizacion' ";

        if(! $db->Query($consulta)){
            $success = false;
        }
        // Si hizo todo bien
        if($success){
            if(! $db->TransactionEnd()) {
                $db->Kill();
            }
            return true;
        }else{
            if (! $db->TransactionRollback()) {
                $db->Kill();
            }
        }
        return false;
    }
    //*****************************************************************************************************
    function CerrarCotizacion($codCotizacion, $numdoc, $feccierre, $instalador){
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
          // Preparo los valores a ser insertados
        $codCotizacion=$db->SQLFix($codCotizacion);
        // Habilito excepciones
        $db->ThrowExceptions = true;
        if (! $db->TransactionBegin()) $db->Kill();
        $success = true;
        $consulta="update tp_cabecera_cotizacion set codEstado='4', nroDocCierre='$numdoc', fechaDocCierre='$feccierre', fechaCierre=SYSDATE(), instalador='$instalador'  where codCabCotiza='$codCotizacion'";
        if (! $db->Query($consulta)){
            $success = false;
        }else{
            $consulta="update tp_detalle_cotizacion set baja='1' where (cantidad is null or cantidad='0' ) and codCabCotiza='$codCotizacion' ";
            if (! $db->Query($consulta)){
                $success = false;
            }
        }
        // Si hizo todo bien
        if ($success) {
            // verifico si no hay mas cotizaciones en estado Activa y cierro prospecto


                if (!$db->TransactionEnd()) {
                    $db->Kill();
                }
                return true;

        }else {
            if (! $db->TransactionRollback()) {
                $db->Kill();
            }
        }
        return false;
    }
    //******************************************************************************************************
    function TienePagos($codCotizacion){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $consulta="select * from forma_pago_prospecto where codVehiculoProspecto=$codCotizacion and baja='0'";
        //echo $consulta;
        $db->Query($consulta);
        if($db->RowCount()>0){
            return false;
        }
        return true;
    }
    //********************************************************************************************************
    function DefinirFormaPago($codprospecto,$codcotizacion, $total, $formapago){
        $array = str_split($formapago, 2);
        $monto= 0;

        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }

        // Habilito excepciones
        $db->ThrowExceptions = true;
        if (! $db->TransactionBegin()) $db->Kill();
        $success = true;
        foreach ($array as &$valor) {
            $monto = $valor * $total / 100;
            if((is_numeric($monto))&&($monto>0)){
                //insertar una forma de pago efectivo
                 $consulta="insert into forma_pago_prospecto
                 (codprospecto, codFormaPago, monto, tasa, cuotas, periodicidad, baja, codVehiculoprospecto)
                 values ('$codprospecto', '1', '$monto', '0', '0', '0', '0', '$codcotizacion')";
                if (!$db->Query($consulta)){
                    $success = false;
                }
            }
        }

        // Si hizo todo bien
        if ($success) {
            if (!$db->TransactionEnd()) {
                $db->Kill();
            }
            return true;
        }else {
            if (! $db->TransactionRollback()) {
                $db->Kill();
            }
        }
        return false;

    }
	//******************************************************************************************************
	function RegistrarPDF($codCot){
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $consulta="insert into tp_lista_cotizaciones (codCabCotiza, fechaPdf, baja) values ('$codCot', SYSDATE() , '0')";
		if(!$db->Query($consulta)){
			return "0";
		}
        return $db->GetLastInsertID();
	}
	//******************************************************************************************************
	function ListarPDFs($codCot){
		$db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return $db;
        }
        $consulta="select * from tp_lista_cotizaciones  where codCabCotiza='$codCot' ";
		if(!$db->Query($consulta)){
			return "0";
		}
        return $db;
	}
	//******************************************************************************************************
}
?>
