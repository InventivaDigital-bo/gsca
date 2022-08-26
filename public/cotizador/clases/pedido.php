<?php

require_once "../clases/mysql.class.php";
require_once "../clases/mail.php";

class Pedido{

    //obtener tipo de usuario
    function ObtenerTipoUsuario($codigo)
    {
        $consulta ="select u.codUsuario, u.codTipoUsuario
                    FROM usuario u
                    WHERE u.codUsuario='$codigo' and baja=00";

      $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
         $db->Query($consulta);
        return $db;
    }
	//***************************************************************************
    function ObtenerCliente($codigo){
        $consulta="select * from tp_cliente_sap where codClienteSAP='".$codigo."' and baja ='0' ";
        $db= new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "0";
		}
		$jsondata = array();
		$nombre="no existe";
		$cod="0";
        $db->Query($consulta);
        if ($db->RowCount()>0){
            $db->MoveFirst();
            $dato=$db->Row();
            $nombre= $dato->nombre;
            $cod= $dato->codCliente;

        }

		$jsondata['nombre'] = $nombre;
        $jsondata['codigo'] = $cod;
        return $jsondata;
    }
	//***************************************************************************
	function ObtenerPedido($codigo="", $usuario="", $codCliente="", $txcodsap="", $nombre="", $monto="", $fecha="",  $estado="", $oficina="", $grupo=""){
		$condicion="";
		if($codigo!=""){ $condicion.=" and pe.codPedido='$codigo'  ";}
		if($usuario!=""){ $condicion.=" and pe.codUsuario='$usuario'  ";}
		if($codCliente!=""){ $condicion.=" and pe.codCliente='$codCliente'  ";}

		if($txcodsap!=""){ $condicion.=" and cli.codClienteSAP='$txcodsap'  ";}
		if($nombre!=""){ $condicion.=" and cli.nombre like '%$nombre%'  ";}
		if($monto!=""){ $condicion.=" and pe.total='$monto' ";}
		if($fecha!=""){ $condicion.=" and pr.fechaPedido like '$fecha%'  ";}
		if(($estado!="")&&($estado!="0")){ $condicion.=" and pe.estadopedido='$estado'  ";}
		if($oficina!=""){ $condicion.=" and usr.codOficina='$oficina'  ";}

        $consulta="select pe.codPedido, pe.fechaPedido, pe.estadopedido, pe.baja, 
CONCAT(per.nombre,' ', per.apePat) as usuario, usr.cargo, pe.total, 
pe.codCliente, cli.nombre as cliente, est.descripcion as estado,
cli.codClienteSAP, pe.latitud, pe.longitud, ofi.descripcion as oficina,
pe.nit, pe.nombrenit, pe.formaPago, pe.observaciones, ofi.direccion, ofi.telefono, ofi.ciudad, per.telefono as telefonoP, per.correo, usr.mail_asistente
from tp_pedidos as pe
left join usuario as usr on usr.codUsuario=pe.codUsuario
left join persona as per on per.codPersona=usr.codPersona
left join tp_cliente_sap as cli on cli.codCliente=pe.codCliente
left join tp_estado as est on est.codEstado=pe.estadopedido
left join oficina as ofi on ofi.codOficina=usr.codOficina
where 1=1 $condicion order by pe.codPedido desc";
		//echo $consulta;
        $db= new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "0";
		}

        $db->Query($consulta);
        if(($db->RowCount()>0)||($codCliente!="")){
			if(($codigo!="")&&($grupo!="1")){
				$db->MoveFirst();
				$dato=$db->Row();
				return $dato;
			}else{
				return $db;
			}
        }

		return $db;
    }
	//***************************************************************************
	//Esta función es para el envió de correo de cierre de pedidos
	function ObtenerUsuarioYPedido($codPedido)
	{
		$consulta="select pe.codPedido, pe.fechaPedido, pe.estadopedido, pe.baja, 
CONCAT(per.nombre,' ', per.apePat) as usuario, usr.cargo, pe.total, 
pe.codCliente, cli.nombre as cliente, est.descripcion as estado,
cli.codClienteSAP, pe.latitud, pe.longitud, ofi.descripcion as oficina,
pe.nit, pe.nombrenit, pe.formaPago, pe.observaciones, ofi.direccion, ofi.telefono, ofi.ciudad, per.telefono as telefonoP, per.correo, usr.mail_asistente
from tp_pedidos as pe
left join usuario as usr on usr.codUsuario=pe.codUsuario
left join persona as per on per.codPersona=usr.codPersona
left join tp_cliente_sap as cli on cli.codCliente=pe.codCliente
left join tp_estado as est on est.codEstado=pe.estadopedido
left join oficina as ofi on ofi.codOficina=usr.codOficina
where pe.codPedido='$codPedido' order by pe.codPedido desc";
		//echo $consulta;
        $db= new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "0";
		}

        $db->Query($consulta);
        if ($db->RowCount()>0){
			if($codigo!=""){
				$db->MoveFirst();
				$dato=$db->Row();
				return $dato;
			}else{
				return $db;
			}
        }

		return $db;
	}



	//***************************************************************************
	function CrearPedido($codUsuario, $codCliente, $fecha, $codVisita, $latitud, $longitud, $nit, $nombrenit, $formapago, $observaciones){
		// Preparo la consulta con las condiciones
        $consulta="INSERT INTO tp_pedidos (codUsuario, codCliente, fechaPedido, estadopedido, baja, latitud, longitud, nit, nombrenit, formaPago, observaciones) VALUES
		('$codUsuario', '$codCliente', '$fecha', '1', '0', '$latitud', '$longitud', '$nit', '$nombrenit', '$formapago', '$observaciones' ) ";
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $success = true;
        $sql = $consulta;

        if (!$db->Query($sql)){
            $success = false;
        }

        if ($success){
			$consulta=" update tp_cliente_sap set codUltimoPedido='".$db->GetLastInsertID()."' where codCliente='$codCliente' ";
			$db->Query($consulta);
			$codtemp= $db->GetLastInsertID();
			if($codVisita!=""){
				$consulta="update tp_visitas set codPedido='$codtemp', fechaEstado=SYSDATE(), codEstado='7' where codVisita='$codVisita' ";
				$db->Query($consulta);
			}
			return $codtemp;
		}
        return false;
    }

    //******************************************************************************
    function ModificarPedido($codPedido, $nit, $nombrenit, $formapago, $observaciones)
    {
    	$consulta = "update tp_pedidos set nit='$nit', nombrenit='$nombrenit', formaPago='$formapago', observaciones='$observaciones' where codPedido='$codPedido'";
    	 $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
 		 $success = true;
        $sql = $consulta;

        if (!$db->Query($sql)){
            $success = false;
        }


        return $success;

    }
function editarUbicacionCliente($codCliente, $latitud, $longitud){
	$consulta = "update tp_cliente_sap set latitud='$latitud', longitud='$longitud' where codCliente='$codCliente'";
    	 $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
 		 $success = true;
        $sql = $consulta;

        if (!$db->Query($sql)){
            $success = false;
        }


        return $success;
}

	//***************************************************************************
	function CrearVisita($codCliente, $fecha){
		// Preparo la consulta con las condiciones
        $consulta="INSERT INTO tp_visitas (fecha, codCliente, codUsuario, baja) VALUES ('$fecha', '$codCliente', (select IFNULL(codUsuarioAsignado,1) from tp_cliente_sap where codCliente='$codCliente' limit 1 ) , '0') ";
        // Creo una nueva conexion

		//die($consulta);
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $success = true;
        $sql = $consulta;

        if (!$db->Query($sql)){
            $success = false;
        }


        return $success;
    }
    
    function GuardarClienteTR4($codClienteSAP, $cliente, $tipo, $grupo)
    {
    	$consulta="insert into tp_cliente_sinc(codClienteSAP, nombre, tipoCliente, grupo) VALUES ('$codClienteSAP', '$cliente', '$tipo', '$grupo')";

    	$db = new MySQL();
    	if ($db->Error()){
    		$db->Kill();
    		return "0";
    	}


    	$success = true;
    	$sql = $consulta;

    	if(!$db->Query($sql)){
    		$success = false;
    	}


    	return $success;
    }
    
    function DeleteClienteTR4()
    {
    	$consulta="DELETE FROM tp_cliente_sinc WHERE 1";
    	$db = new MySQL();
    	if ($db->Error()){
    		$db->Kill();
    		return "0";
    	}
    	$success = true;
    	$sql = $consulta;

    	if(!$db->Query($sql)){
    		$success = false;
    	}

        $consulta="TRUNCATE TABLE tp_cliente_sinc";
        $db = new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $success = true;
        $sql = $consulta;

        if(!$db->Query($sql)){
            $success = false;
        }

    	return $success;
    }
    function AgregarClientesSinc(){
             $consulta="insert into tp_cliente_sap(codClienteSAP, nombre, baja) 
                    SELECT cs.codClienteSAP, cs.nombre, cs.baja
                    FROM tp_cliente_sinc cs
                    LEFT JOIN tp_cliente_sap cb on cs.codClienteSAP= cb.codClienteSAP
                    WHERE cb.codClienteSAP is null";

        $db = new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }


        $success = true;
        $sql = $consulta;

        if(!$db->Query($sql)){
            $success = false;
        }

        $consulta="update  tp_cliente_sap as cli
                    LEFT JOIN tp_cliente_sinc as clis on cli.codClienteSAP= clis.codClienteSAP
                    LEFT JOIN usuario as u on clis.grupo= u.grupo
                    set cli.codUsuarioAsignado=u.codUsuario
                    WHERE clis.grupo= u.grupo";

        $db = new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }


        $success = true;
        $sql = $consulta;

        if(!$db->Query($sql)){
            $success = false;
        }

        if ($success== true)
        {
            $iCorreo= new Correo();
            $iCorreo->SincronizacionCliente();
        }
        

        return $success;
    }
    
    function GuardarPreciosSinc(){
         $consulta="delete from tp_precio; TRUNCATE table tp_precio;
insert into tp_precio ( codProducto, codSAP, codOficina, cantidad, baja) 
SELECT prod.codProducto, sinc.ITEMID as codSAP,  ofi.codOficina,  sinc.PRECIO_DE_VENTA as cantidad, '0' as baja
FROM tmp_sinc  as sinc
inner join oficina as ofi on ofi.axCodigo=INVENTLOCATIONID
inner join tp_producto_sap as prod on prod.codSAP=sinc.ITEMID";
       
        $db = new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }


        $success = true;
        $sql = $consulta;

        if(!$db->Query($sql)){
            $success = false;
        }
         return $success;
    }


    function SincronizarResponsable(){
        $consulta="update  tp_cliente_sap as cli
                    LEFT JOIN tp_cliente_sinc as clis on cli.codClienteSAP= clis.codClienteSAP
                    LEFT JOIN usuario as u on clis.grupo= u.grupo
                    set cli.codUsuarioAsignado=u.codUsuario
                    WHERE clis.grupo= u.grupo";

        $db = new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }


        $success = true;
        $sql = $consulta;

        if(!$db->Query($sql)){
            $success = false;
        }


        return $success;
    }
	//***************************************************************************
	function ObtenerClientes($codigo="", $usuario="", $bsq="", $codSAP="", $codUsuario="", $codOficina="", $tipoclientes="", $zona=""){
		$condicion="";
		if($codigo!=""){ $condicion.=" and cli.codCliente='$codigo'  ";}
		if($bsq!=""){ $condicion.=" and ( cli.nombre like '%$bsq%' or cli.codClienteSAP='$bsq' )"; }
		if($codSAP!=""){ $condicion.=" and  cli.codClienteSAP='$codSAP' "; }
		if($tipoclientes!=""){ $condicion.=" and  cli.codTipoCliente='$tipoclientes' "; }
		if($zona!=""){ $condicion.=" and  cli.codZona='$zona' "; }
		if($codUsuario!=""){ $condicion.=" and cli.codUsuarioAsignado='$codUsuario' "; }
		if($codOficina!=""){ $condicion.=" and cli.codUsuarioAsignado in ( select distinct codUsuario from usuario where codoficina='$codOficina') "; }
        $consulta="select cli.codCliente, cli.codClienteSAP, cli.nombre as cliente,
cli.telefono, ped.codPedido, ped.fechaPedido, ped.total,
cli.codTipoCliente ,tc.descripcion as tipocliente,
CONCAT(per.nombre,' ',per.apePat) as usuario,
cli.codZona, zn.descripcion as zona, cli.latitud, cli.longitud,
CONCAT(uas.nombre,' ',uas.apePat) as asignado, usr.codUsuario as codUsuarioAsignado, cli.baja,
ci, fechaNac,  cargoInstitucional, telefonoFijo, telefonoCelPersonal, telefonoCelCorp,
telefonoFijoOficina, correoPersonal, correoLaboral, sitioweb, cli.direccion, facebook, linkedin,
totalCompras, palabrasClave, esempresa, cli.nit,
cli.codTituloAcademico, titulo.nombre as titulo,
cli.codNivelInstruccion, nivel.nombre as nivel,
cli.codEstadoCivil, estciv.nombre as estadoCivil,
cli.codGenero, genero.nombre as genero,
cli.codRubro, rubro.nombre as rubro,
cli.codClasificacion, clasif.nombre as clasificacion,
ped.nit, ped.nombrenit, ped.observaciones as obs,
cli.nit as nitcli, cli.razonsocial as nombrenitcli,
case when ped.nit is null then cli.nit else ped.nit end as nitusar,
case when ped.nombrenit is null then cli.razonsocial else ped.nombrenit end as razonsocialusar,
ped.formaPago
from tp_cliente_sap as cli
left join tp_pedidos as ped on ped.codPedido=cli.codUltimoPedido
left join usuario as u on u.codUsuario=ped.codUsuario
left join persona as per on per.codPersona=u.codPersona
left join tipo_cliente as tc on tc.codTipoCliente=cli.codTipoCliente
left join zona as zn on zn.codZona=cli.codZona
left join usuario as usr on usr.codUsuario=cli.codUsuarioAsignado
left join persona as uas on uas.codPersona=usr.codPersona
left join parametros as titulo on titulo.codParametro=cli.codTituloAcademico
left join parametros as nivel on nivel.codParametro=cli.codNivelInstruccion
left join parametros as estciv on estciv.codParametro=cli.codEstadoCivil
left join parametros as genero on genero.codParametro=cli.codGenero
left join parametros as rubro on rubro.codParametro=cli.codRubro
left join parametros as clasif on clasif.codParametro=cli.codClasificacion
where 1 and codUsuarioAsignado is not null $condicion order by ped.fechaPedido desc, cli.nombre limit 1000 ";
		//echo ($consulta);
        $db= new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "0";
		}

        $db->Query($consulta);
        if ($db->RowCount()>0){
			if($codigo!=""){
				$db->MoveFirst();
				$dato=$db->Row();
				return $dato;
			}else{
				return $db;
			}
        }

		return $db;
    }
	//***************************************************************************

function ObtenerResponsables($codCliente){
	 $db = new MySQL();


        // Defino que tabla utilizaremos


        if ($db->Error()) $db->Kill();
	$consulta="select rc.codResponsable, per.codPersona,
CONCAT(per.nombre,' ',per.apePat) as responsable, rc.fechaIni, rc.fechaFin
FROM responsable_cliente as rc
left JOIN usuario as us on rc.codResponsable=us.codUsuario
LEFT JOIN persona  as per on per.codPersona=us.codPersona
WHERE rc.codCliente='$codCliente'";

 if (! $db->Query($consulta)) $db->Kill();
        return $db;


}

//*************************************************************************************
function AsignarResponsable($codAsignado, $codCliente, $codResponsable){
	   $consulta="insert INTO responsable_cliente(codCliente,codResponsable, fechaIni) VALUES ('$codCliente','$codResponsable',SYSDATE())";
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $success = true;
        $sql = $consulta;

        if (!$db->Query($sql)){
            $success = false;
        }

        if ($success){
			$consulta="update responsable_cliente SET fechaFin=SYSDATE() WHERE codCliente='$codCliente' and codResponsable='$codAsignado' and fechaFin is null";
			$db->Query($consulta);

				$consulta="update tp_cliente_sap set codUsuarioAsignado='$codResponsable' WHERE codCliente='$codCliente'";
				$db->Query($consulta);

				$consulta="update tp_visitas set codUsuario='$codResponsable' WHERE codCliente='$codCliente'";
				$db->Query($consulta);
			
			return $success;
		}
        return false;
}
	//******************************************************************************
	function ObtenerVisitas($codigo){

        $consulta="select vi.*, es.descripcion as estado, mt.descripcion as motivo
from tp_visitas as vi
left join tp_estado as es on es.codEstado=vi.codEstado
left join motivo_suspension as mt on mt.codMotivoSuspension=vi.codMotivoSuspension
where vi.codCliente='$codigo' ";

        $db= new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "0";
		}

        $db->Query($consulta);
		return $db;
    }
	//**********************************************************************************************
	//**********************************************************************************************
	//**********************************************************************************************
	public function Atrasados($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $consulta="
select codCliente, codClienteSAP, nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, codVisita from (
select p.codCliente, p.codClienteSAP, p.nombre,  s.codUsuario, s.codVisita,
e.descripcion estado, s.fecha as fecha, DATEDIFF(SYSDATE(), s.fecha) as dias
from tp_cliente_sap as p
left join tp_visitas as s on s.codCliente=p.codCliente
left join tp_estado as e on e.codEstado=s.codEstado
where s.codEstado=1 and s.codUsuario=$codUsuario
) as consulta
where dias>0 order by dias desc
";
		//echo $consulta;
		if (! $db->Query($consulta)) $db->Kill();
		return $db;

	}
//***********************************************************************************
    public function Hoy($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $consulta="
select codCliente, codClienteSAP, nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, codVisita from (
select p.codCliente, p.codClienteSAP, p.nombre, s.codUsuario, s.codVisita,
e.descripcion estado, s.fecha as fecha, DATEDIFF(SYSDATE(), s.fecha) as dias
from tp_cliente_sap as p
left join tp_visitas as s on s.codCliente=p.codCliente
left join tp_estado as e on e.codEstado=s.codEstado
where s.codEstado=1 and s.codUsuario=$codUsuario
) as consulta
where dias=0
";
		if (! $db->Query($consulta)) $db->Kill();
		return $db;

	}
//***********************************************************************************
     public function Proximos($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $consulta="
select codCliente, codClienteSAP, nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, codVisita from (
select p.codCliente, p.codClienteSAP, p.nombre, s.codUsuario, s.codVisita,
e.descripcion estado, s.fecha as fecha, DATEDIFF(SYSDATE(), s.fecha) as dias
from tp_cliente_sap as p
left join tp_visitas as s on s.codCliente=p.codCliente
left join tp_estado as e on e.codEstado=s.codEstado
where s.codEstado=1 and s.codUsuario=$codUsuario
) as consulta
where dias<0 order by dias asc
";
		if (! $db->Query($consulta)) $db->Kill();
		return $db;

	}
//***********************************************************************************
     public function SinSeguimiento($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $consulta="
select codCliente, codClienteSAP, nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias from (
select p.codCliente, p.codClienteSAP, p.nombre, s.codUsuario, s.codEstado,
e.descripcion estado, s.fecha as fecha, DATEDIFF(SYSDATE(), s.fecha) as dias
from tp_cliente_sap as p
left join tp_visitas as s on s.codCliente=p.codCliente
left join tp_estado as e on e.codEstado=s.codEstado
where s.codEstado=1 and s.codUsuario=$codUsuario
) as consulta
where codEstado=4 and dias>3 order by dias desc
";
		if (! $db->Query($consulta)) $db->Kill();
		return $db;

	}
    //***********************************************************************************
    public function TotalProspectos($codUsuario){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="
select count(p.codVisita) as total
from tp_visitas as p
where codEstado=1 and codUsuario=$codUsuario

";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }
	//**********************************************************************************
	function Calendario($codUsuario, $perfil, $tipo="", $codClienteSAP="",  $responsable, $oficina, $tipocliente, $zona, $estado){
        $condicion=" ";
        if($perfil=="Usuario"){
            $condicion.=" and seg.codUsuario='$codUsuario' ";
        }

        if("Pendientes"==$tipo){
            $condicion.=" and seg.codEstado =1 ";
        }

        if(($codClienteSAP!="")){
            $condicion.=" and pro.codClienteSAP='$codClienteSAP' ";
        }

        if(($responsable!="")&&($responsable!="0")){
            $condicion.=" and seg.codUsuario='$responsable' ";
        }

		if(($oficina!="")&&($oficina!="0")){
			$condicion.=" and usr.codOficina='$oficina' ";
		}

		if(($oficina!="")&&($oficina!="0")){
			$condicion.=" and usr.codOficina='$oficina' ";
		}

		if($tipocliente!=""){
			$condicion.=" and  pro.codTipoCliente='$tipocliente' ";
		}

		if($zona!=""){
			$condicion.=" and  pro.codZona='$zona' ";
		}

		if(($estado!="")&&($estado!="0")){
			$condicion.=" and seg.codEstado='$estado' ";
		}


        $consulta="
select fecha, tipo, estado, ejecutivo, tipocliente, zona, count(*) as total,
DATEDIFF(SYSDATE(), fecha) as dias from (
	select tab.* from (
		select 'Prospecto' control, date_format(seg.fecha,'%Y-%m-%d')as fecha, seg.codCliente as codigo,
		pro.codClienteSAP, 'Visita Prog.' as tipo, pro.nombre as nombre, e.descripcion as estado,
		CONCAT(per.nombre,' ',per.apePat) as ejecutivo, tc.descripcion as tipocliente,
		zn.descripcion as zona
		from tp_visitas as seg
		left join tp_cliente_sap as pro on pro.codCliente =seg.codCliente
		left join usuario as usr on usr.codUsuario=seg.codUsuario
		left join persona as per on per.codPersona=usr.codPersona
		left join tp_estado as e on e.codEstado=seg.codEstado
		left join tipo_cliente as tc on tc.codTipoCliente=pro.codTipoCliente
		left join zona as zn on zn.codZona=pro.codZona
		where 1 $condicion
	) as tab order by tab.fecha
) as tab2 group by fecha, tipo, estado, ejecutivo, tipocliente, zona";
        //echo $consulta;
        $db = new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "vacio";
        }else{
            if (! $db->Query($consulta)) {
                $db->Kill();
                return "vacio";
            }else{
                return $db;
            }
        }
    }
	//**********************************************************************************
	function ObtenerClientesCalendario($fecha, $tipo, $estado, $ejecutivo, $tipocliente, $zona){
        $consulta="select tab.* from (
		select 'Prospecto' control, date_format(seg.fecha,'%Y-%m-%d')as fecha, seg.codCliente as codigo,
		pro.codClienteSAP, 'Visita Prog.' as tipo, pro.nombre as nombre, e.descripcion as estado,
		CONCAT(per.nombre,' ',per.apePat) as ejecutivo, tc.descripcion as tipocliente,
		zn.descripcion as zona
		from tp_visitas as seg
		left join tp_cliente_sap as pro on pro.codCliente =seg.codCliente
		left join usuario as usr on usr.codUsuario=seg.codUsuario
		left join persona as per on per.codPersona=usr.codPersona
		left join tp_estado as e on e.codEstado=seg.codEstado
		left join tipo_cliente as tc on tc.codTipoCliente=pro.codTipoCliente
		left join zona as zn on zn.codZona=pro.codZona

	) as tab where  fecha='$fecha' and tipo='$tipo' and estado='$estado'
		and ejecutivo='$ejecutivo' and tipocliente='$tipocliente' and zona='$zona' order by tab.fecha
	";
        // echo $consulta;
        $db = new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "vacio";
        }else{
            if (! $db->Query($consulta)) {
                $db->Kill();
                return "vacio";
            }else{
                return $db;
            }
        }
    }
	//****************************************************************************************************
	function PuntosVisitas($codUsuario, $vdesde, $vendedor){

		$condicion="";
        if ($vdesde!=""){
        	$condicion.=" and p.fecha like '$vdesde%' ";
        }

        if (($codUsuario!="")){
            $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $perfil= $iUsuario->obtenerPerfil();
            if (($perfil=="Vendedor")||($perfil=="Operaciones")){
                $condicion.=" and p.codUsuario=$codUsuario ";
            }
            if ($perfil=="Jefatura"){
                $condicion.=" and p.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codUsuario')) ";
            }
        }else{
             $condicion.=" and p.codUsuario=0";
            //echo "perfil usuario ".$codUsuario."<hr>";
        }


        if($vendedor!=""){
            $condicion.=" and p.codUsuario=$vendedor ";
        }


		$consulta="
select codCliente, nombre, codClienteSAP, latitud, longitud, ejecutivo, count(*) as visitas from (
select tp.*
from (
SELECT p.codCliente, cli.nombre, cli.codClienteSAP,  cli.latitud, cli.longitud,
CONCAT( pe.nombre ,' ', pe.apePat ) as ejecutivo,
e.descripcion as estado, DATE_FORMAT(p.fecha,'%d-%m-%Y') as fecha
from tp_visitas  as p
left join tp_cliente_sap as cli on cli.codCliente=p.codCliente
left join usuario as u on u.codUsuario=p.codUsuario
left  join persona as pe on pe.codPersona=u.codPersona
left join tp_estado as e on e.codEstado=p.codEstado
where cli.latitud is not null and cli.longitud is not null
$condicion
) as tp
) as tab group by codCliente, nombre, codClienteSAP, latitud, longitud, ejecutivo
		";

		//echo $consulta."<hr>";
        $db = new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "vacio";
		}else{
			if (! $db->Query($consulta)) {
				$db->Kill();
				return false;
			}else{

				return $db;

			}
		}
        return false;
	}
	//****************************************************************************************************
	function PuntosHistorico($codUsuario, $vdesde, $vendedor){
		$condicion2="";
		$condicion="";
        if ($vdesde!=""){
        	$condicion.=" and vi.fecha like '$vdesde%' ";
        	$condicion2.=" and pe.fechaPedido like '$vdesde%' ";
        }

        if (($codUsuario!="")){
            $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $perfil= $iUsuario->obtenerPerfil();
            if (($perfil=="Vendedor")||($perfil=="Operaciones")){
                $condicion.=" and vi.codUsuario=$codUsuario ";
                $condicion2.=" and pe.codUsuario=$codUsuario ";
            }
            if ($perfil=="Jefatura"){
                $condicion.=" and vi.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codUsuario')) ";
                $condicion2.=" and pe.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codUsuario')) ";
            }
        }else{
             $condicion.=" and vi.codUsuario=0";
             $condicion2.=" and pe.codUsuario=0";
            //echo "perfil usuario ".$codUsuario."<hr>";
        }


        if($vendedor!=""){
            $condicion.=" and vi.codUsuario=$vendedor ";
            $condicion2.=" and pe.codUsuario=$vendedor ";
        }

		$consulta="select latitud, longitud, es.descripcion as estado, 'visita' as tipo,
CONCAT(per.nombre,' ',per.apePat) as ejecutivo, vi.codCliente, vi.fecha
from tp_visitas as vi
left join tp_estado as es on es.codEstado=vi.codEstado
left join usuario as usr on usr.codUsuario=vi.codUsuario
left join persona as per on per.codPersona=usr.codPersona
where 1=1  and vi.latitud is not null and vi.longitud is not null
and vi.latitud!='' and vi.longitud!='' $condicion

union all

select pe.latitud, pe.longitud, est.descripcion as estado,
'toma pedido' as tipo, CONCAT(per.nombre,' ',per.apePat) as ejecutivo,
pe.codCliente, pe.fechaPedido as fecha
from tp_pedidos as pe
left join tp_estado as est on est.codEstado=pe.estadopedido
left join usuario as usr on usr.codUsuario=pe.codUsuario
left join persona as per on per.codPersona=usr.codPersona
where 1=1 and pe.latitud is not null and pe.longitud is not null
and pe.latitud!='' and pe.longitud!='' $condicion2
";

       //echo $consulta."<hr>";
        $db = new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "vacio";
		}else{
			if (!$db->Query($consulta)) {
				$db->Kill();
				return false;
			}else{

				return $db;

			}
		}
        return false;
	}
	//***************************************************************************
	function CerrarVisita($codVisita, $lat, $long, $motivo, $observaciones){
		$db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="update tp_visitas set codEstado='6', codMotivoSuspension='$motivo', fechaEstado=SYSDATE(), latitud='$lat', longitud='$long', observaciones='$observaciones' where codVisita='$codVisita' ";

        if (! $db->Query($consulta)) {
			$db->Kill();
			return false;
		}
        return true;

    }
	//***************************************************************************
	function EliminarVisita($codVisita, $lat, $long){
		$db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="update tp_visitas set codEstado='2', fechaEstado=SYSDATE(), latitud='$lat', longitud='$long' where codVisita='$codVisita' ";

        if (! $db->Query($consulta)) {
			$db->Kill();
			return false;
		}
        return true;

    }

	function ListarProductos($codcab="", $codigousuario="", $bsq=""){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $condicion="";
        if($codcab!=""){
            //$condicion =" and dc.codProducto is null ";
        }
        if($bsq!=""){
            $condicion =" and (p.descripcion like '%$bsq%' or p.codSAP like '%$bsq%')  ";
        }
        $consulta="select distinct p.codProducto, p.codSAP, p.descripcion, p.codUnidInv, of.axCodigo, of.codOficina,
        u.descripcion as unidad, p.codGrupo, g.descripcion as grupo,
        p.codTipoArt, t.descripcion as Tipo, p.codSubTipo, s.descripcion as Subtipo,
        p.codUEN, p.codUEN1, p.codUEN2, st.cantidad as stock, pr.cantidad  as precio
        from tp_producto_sap as p
        left join tp_unidad_inventario as u on u.codUnidInv=p.codUnidInv
        left join tp_grupo as g on g.codGrupo=p.codgrupo
        left join tp_tipo_articulo as t on t.codTipoArticulo=p.codTipoArt
        left join tp_subtipo_articulo as s on s.codSubtipoArticulo=p.codSubTipo
        left join tp_stock as st on st.codproducto=p.codproducto and st.baja='0'
        and st.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
        left join tp_precio as pr on pr.codproducto=p.codproducto and pr.baja='0'
        and pr.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
        LEFT JOIN oficina of on pr.codOficina=of.codOficina 
        where 1=1 $condicion group by p.codSAP ";
        //echo $consulta; die();
        $db->Query($consulta);
        return $db;
    }
function ListarProductos2($codcab="", $codigousuario="", $bsq=""){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $condicion="";
        if($codcab!=""){
            //$condicion =" and dc.codProducto is null ";
        }
        if($bsq!=""){
            $condicion =" and (p.descripcion like '%$bsq%' or p.codSAP like '%$bsq%')  ";
        }
        $consulta="select distinct p.codProducto, p.codSAP, p.descripcion, p.codUnidInv, of.axCodigo, of.codOficina,
        u.descripcion as unidad, p.codGrupo, g.descripcion as grupo,
        p.codTipoArt, t.descripcion as Tipo, p.codSubTipo, s.descripcion as Subtipo,
        p.codUEN, p.codUEN1, p.codUEN2, st.cantidad as stock, pr.cantidad  as precio
        from tp_producto_sap as p
        left join tp_unidad_inventario as u on u.codUnidInv=p.codUnidInv
        left join tp_grupo as g on g.codGrupo=p.codgrupo
        left join tp_tipo_articulo as t on t.codTipoArticulo=p.codTipoArt
        left join tp_subtipo_articulo as s on s.codSubtipoArticulo=p.codSubTipo
        left join tp_stock as st on st.codproducto=p.codproducto and st.baja='0'
        and st.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
        left join tp_precio as pr on pr.codproducto=p.codproducto and pr.baja='0'
        and pr.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
        LEFT JOIN oficina of on pr.codOficina=of.codOficina 
        where 1=1 $condicion and pr.cantidad is not null group by p.codSAP ";
        //echo $consulta; die();
        $db->Query($consulta);
        return $db;
    }

    function ObtenerHistoricoPedido($codCliente, $desde, $hasta){
    	 $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
	$consulta="select pe.codPedido,pro.descripcion as Producto, inv.descripcion as UniMedida, cli.codClienteSAP, pe.fechaPedido,det.cantidad, est.descripcion as Estado
from tp_pedidos as pe 
left join usuario as usr on usr.codUsuario=pe.codUsuario 
left join persona as per on per.codPersona=usr.codPersona 
left join tp_cliente_sap as cli on cli.codCliente=pe.codCliente 
left join tp_estado as est on est.codEstado=pe.estadopedido 
left join oficina as ofi on ofi.codOficina=usr.codOficina 
LEFT JOIN tp_pedidos_detalle det on det.codPedido=pe.codPedido 
LEFT JOIN tp_producto_sap pro on pro.codProducto=det.codProducto 
left JOIN tp_unidad_inventario inv on inv.codUnidInv=pro.codUnidInv
where pe.codCliente='$codCliente' and pe.estadopedido='8' and date(pe.fechaPedido)>='$desde' and date(pe.fechaPedido)<='$hasta'  order by det.cantidad desc";

	$db->Query($consulta);
	return $db;

}
    function ListarFrecuentes($codigousuario="", $bsq=""){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $condicion="";

        if($bsq!=""){
            $condicion =" and (p.descripcion like '%$bsq%' or p.codSAP like '%$bsq%')  ";
        }
        $consulta="select distinct p.codProducto, p.codSAP, p.descripcion, p.codUnidInv,
        u.descripcion as unidad, p.codGrupo, g.descripcion as grupo, frec.iFrec_id,
        p.codTipoArt, t.descripcion as Tipo, p.codSubTipo, s.descripcion as Subtipo,
        p.codUEN, p.codUEN1, p.codUEN2, st.cantidad as stock, pr.cantidad  as precio
        from tp_producto_sap as p
        left join tp_producto_frecuentometro as frec ON frec.codProducto = p.codProducto
        left join tp_unidad_inventario as u on u.codUnidInv=p.codUnidInv
        left join tp_grupo as g on g.codGrupo=p.codgrupo
        left join tp_tipo_articulo as t on t.codTipoArticulo=p.codTipoArt
        left join tp_subtipo_articulo as s on s.codSubtipoArticulo=p.codSubTipo
        left join tp_stock as st on st.codproducto=p.codproducto and st.baja='0'
        and st.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
        left join tp_precio as pr on pr.codproducto=p.codproducto and pr.baja='0'
        and pr.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
        where 1=1 $condicion and frec.iStatus_fl = '1' and p.codSAP in ( SELECT distinct codSAP FROM tmp_sinc where categoria like 'VG%' or categoria like 'EP%' )
        ";
        //echo $consulta; die();
        $db->Query($consulta);
        return $db;
    }
	//***************************************************************************

  function addFrecuente($iFrec_id, $pedido, $oficina) {
		$db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }

        $producto = 'SELECT p.codProducto, p.codSAP, p.descripcion as producto, pre.cantidad as precio, fre.iFrec_Cantidad as cantidad, fre.iFrec_descuento as descuento FROM tp_producto_frecuentometro as fre LEFT JOIN tp_producto_sap as p ON p.codProducto = fre.codProducto LEFT JOIN tp_precio as pre ON pre.codProducto = p.codProducto WHERE pre.codOficina = \''.$oficina.'\' AND fre.iFrec_id = \''.$iFrec_id.'\'';

       	if ($db->HasRecords($producto)) {
       		$db->Query($producto);
       		$pro = $db->Row();
       		$db->Query('INSERT INTO tp_pedidos_detalle (codPedido, cantidad, precioUnit, descuento, codProducto, total, baja) VALUES (\''.$pedido.'\', \''.$pro->cantidad.'\', \''.$pro->precio.'\', \''.$pro->descuento.'\', \''.$pro->codProducto.'\', \''.($pro->cantidad * $pro->precio).'\', \'0\')');
       		$pro->pedido = $db->GetLastInsertID();
       		return $pro;
       	}
	}

  function addProducto($codProducto, $pedido, $oficina) {
		$db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }

        $producto = 'SELECT p.codProducto, p.codSAP, p.descripcion as producto, pre.cantidad as precio FROM tp_producto_sap as p LEFT JOIN tp_precio as pre ON pre.codProducto = p.codProducto WHERE pre.codOficina = \''.$oficina.'\' AND p.codProducto = \''.$codProducto.'\'';

       	if ($db->HasRecords($producto)) {
       		$db->Query($producto);
       		$pro = $db->Row();
       		$db->Query('INSERT INTO tp_pedidos_detalle (codPedido, cantidad, precioUnit, descuento, codProducto, total, baja) VALUES (\''.$pedido.'\', \'1.00\', \''.$pro->precio.'\', \'0.00\', \''.$pro->codProducto.'\', \''.($pro->precio).'\', \'0\')');
       		$pro->pedido = $db->GetLastInsertID();
       		return $pro;
       	}
	}

  function removeProductosPedido($codPedido, $codProducto) {
      $db= new MySQL();
          if ($db->Error()){
              $db->Kill();
              return "0";
          }

          $consulta = 'UPDATE tp_pedidos_detalle SET baja = \'1\' WHERE codPedidoDetalle = \''.$codProducto.'\' AND codPedido = \''.$codPedido.'\'';

         	if ($db->Query($consulta)) {
         		$db->Query('INSERT INTO tp_pedidos_detalle (codPedido, cantidad, precioUnit, descuento, codProducto, total, baja) VALUES (\''.$pedido.'\', \'0.00\', \''.$pro->precio.'\', \'0.00\', \''.$pro->codProducto.'\', \''.($pro->precio).'\', \'0\')');
         		$pro->pedido = $db->GetLastInsertID();
         		return true;
         	} else {
            return false;
          }
  }

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
		$productos = explode(",", $codProductos);
		foreach($productos as $key => $val) {
            $consulta="insert into tp_pedidos_detalle ( codPedido, cantidad, precioUnit, descuento, codProducto, total, baja)
	select $codCotizacion, 0, IFNULL(pr.cantidad,0), 0,  ps.codProducto, 0, '0'
	from tp_producto_sap as ps
	left join tp_precio as pr on pr.codProducto=ps.codProducto and pr.baja='0' and pr.codOficina=(
		SELECT distinct usr.codOficina FROM tp_pedidos as pe
left join usuario as usr on usr.codUsuario=pe.codUsuario where codPedido='$codCotizacion'
	)
	where ps.codProducto = '".$productos[$key]." '
	";

			if (! $db->Query($consulta)){
				$success = false;
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
	//***************************************************************************
	function ObtenerDetalle($codcotizacion="", $codigousuario){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $consulta="
select det.codPedidoDetalle, det.cantidad,
det.precioUnit, det.descuento, det.codProducto, det.total, p.codSAP,
p.descripcion as producto, u.descripcion as unidadInv, st.cantidad as stock,
det.observacion, sti.descripcion as subtipo, pr.cantidad as precioOri
from tp_pedidos_detalle as det
inner join tp_producto_sap as p on p.codProducto=det.codProducto
left join tp_subtipo_articulo as sti on sti.codSubtipoArticulo=p.codSubTipo
inner join tp_unidad_inventario as u on u.codUnidInv=p.codUnidInv
left join tp_stock as st on st.codproducto=p.codproducto and st.baja='0' and st.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
left join tp_precio as pr on pr.codProducto=p.codProducto and pr.baja='0' and pr.codOficina=(
		SELECT distinct usr.codOficina FROM tp_pedidos as pe
left join usuario as usr on usr.codUsuario=pe.codUsuario where codPedido='$codcotizacion'
	)
where det.codPedido='$codcotizacion' and det.baja='0' GROUP by p.codSAP order by det.codPedidoDetalle DESC";
        //echo $consulta;
        $db->Query($consulta);
        return $db;
    }
	//***************************************************************************
	
	
	function ObtenerDetallePDF($codcotizacion="", $codigousuario="" ){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $consulta="
select det.codPedidoDetalle, det.cantidad,
det.precioUnit, det.descuento, det.codProducto, det.total, p.codSAP,
p.descripcion as producto, u.descripcion as unidadInv, st.cantidad as stock,
det.observacion, sti.descripcion as subtipo, pr.cantidad as precioOri
from tp_pedidos_detalle as det
inner join tp_producto_sap as p on p.codProducto=det.codProducto
left join tp_subtipo_articulo as sti on sti.codSubtipoArticulo=p.codSubTipo
inner join tp_unidad_inventario as u on u.codUnidInv=p.codUnidInv
left join tp_stock as st on st.codproducto=p.codproducto and st.baja='0' and st.codOficina in (select codOficina from usuario where codUsuario ='$codigousuario')
left join tp_precio as pr on pr.codProducto=p.codProducto and pr.baja='0' and pr.codOficina=(
		SELECT distinct usr.codOficina FROM tp_pedidos as pe
left join usuario as usr on usr.codUsuario=pe.codUsuario where codPedido='$codcotizacion'
	)
where det.codPedido='$codcotizacion' and det.baja='0' group by p.codSAP order by det.codPedidoDetalle DESC ";
        //echo $consulta;
        $db->Query($consulta);
        return $db;
    }
	
	
	//*******************************************************************************
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
        $consulta="update tp_pedidos_detalle set baja='1' where codPedidoDetalle in ($codDetalle) and codPedido='$codCotizacion' ";
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
	//***************************************************************************
	function CerrarPedido($codPedido){
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
        $consulta="update tp_pedidos set estadopedido='4' where codPedido ='$codPedido' ";
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
	//***************************************************************************
	function EliminarPedido($codPedido, $motivo){
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
        $consulta="update tp_pedidos set estadopedido='2', codMotivoSuspension='$motivo' where codPedido ='$codPedido' ";
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
	//***************************************************************************
	function Modificar($codCotizacion, $total, $detallesArray){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        // Preparo los valores a ser insertados
        $total=$db->SQLFix($total);
        // Habilito excepciones
        $db->ThrowExceptions = true;
        if (! $db->TransactionBegin()) $db->Kill();

        $success = true;

        $consulta="update tp_pedidos set total='$total' where codPedido='$codCotizacion'";
		//die($consulta);
        if (! $db->Query($consulta)){
            $success = false;
        }else{
            // modifico el detalle
            for($i = 0; $i < count($detallesArray); $i++) {
                $item=$detallesArray[$i];
                if($item[4]!=((($item[1]*$item[2])*(100-$item[3]))/100)){
                    $item[4]=((($item[1]*$item[2])*(100-$item[3]))/100);
                }
                $consulta="update tp_pedidos_detalle set cantidad='".$item[1]."', precioUnit='".$item[2]."', descuento='".$item[3]."', total='".$item[4]."', observacion='".$item[5]."'  where codPedidoDetalle='".$item[0]."' ";

				//echo $consulta."<hr>";
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
	//***************************************************************************
}
