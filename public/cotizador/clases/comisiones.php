<?php

require_once "../clases/mysql.class.php";
require_once "../clases/usuario.php";
require_once "../clases/reportes.php";
class Comisiones{
    function OrdenarComision($cod, $orden){
        $db = new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }else{
            $consulta="update comision set orden='$orden' where codComision='$cod' ";
            if (! $db->Query($consulta)) {
                $db->Kill();
                return false;
            }else{
                return true;
            }
        }
        
    }
    
    function GuardarComision($cod, $cheque, $comprobante, $fecha){
        $db = new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }else{
            $consulta="update comision set nroCheque='$cheque', numComprobante='$comprobante', fechaPago='$fecha', pagada='1' where codComision='$cod' ";
            if (! $db->Query($consulta)) {
                $db->Kill();
                return false;
            }else{
                return true;
            }
        }
        
    }
    
    function ValidarCerradas($concesionario, $mes, $gestion, $codigo){
        $iReportes = new Reportes();
        $db=$iReportes->ComisionesGuardadas($concesionario, $mes, $gestion, $codigo, "1");
        if($db->RowCount()>0)return false;
        return true;
    }
    
    function Aporte($concesionario){
         $db = new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return "0";
        }else{
            $consulta="select aporte from empresa where codEmpresa='$concesionario' ";
            if (! $db->Query($consulta)) {
                $db->Kill();
                return "0";
            }else{
                if($db->RowCount()>0){
                    $db->MoveFirst();
                    $fila=$db->Row();
                    return $fila->aporte;
                }
            }
        }
        return false;
        
    }
    
    function ComisionesGuardadas($concesionario, $mes, $gestion, $codigo, $guardadas="", $mostrar=""){
        //--------------------------------------------------------------------------------
        $condicion="";
        if($concesionario!=""){
            $condicion.=" and emp.codEmpresa='$concesionario' ";
        }
        $iUsuario = new Usuario();
        $iUsuario->RecuperarSesionCod($codigo);
        $perfil= $iUsuario->obtenerPerfil();
        if ($perfil=="Jefatura"){
            $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
        }
        $condicion2="";
        if($guardadas=="1"){
            $condicion2=" where cerrado='1' ";
        }
        //--------------------------------------------------------------------------------

        $consulta="select tab.*, com.codComision,  
case when com.pagada='0' then 'No' else 'Si' end as pagada,
com.nroCheque, com.numComprobante, DATE_FORMAT(com.fechaPago,'%d-%m-%Y') as fechaPago, 
case when com.baja='0' then 'No' else 'Si' end as baja,
DATE_FORMAT(com.fechaFact,'%d-%m-%Y') as fechafact, com.TotalBs, com.TotalSus,
com.PrecioVenta as precioVenta, com.PrecioPiso as precioPiso, com.PrecioDealer as precioDealer,
com.ComTransporte as comTransporte, com.ComPlacas as comPlacas, com.ComOtros as comOtros, 
com.ComModelo as comModelo, com.ComModeloPre as comModeloPre,
com.SobrePiso, com.orden, case when com.esprecompra='1' then 'Si' else 'No' end as esprecompra, 
com.aporteInicial, com.aporteItem, com.aporteSaldo, case when com.cerrado='1' then 'Si' else 'No' end as cerrado,
com.comision
from (
select 
ofi.descripcion as oficina, vp.codProspecto, 
pro.nombre as nombreProspecto, m.codMarca,
m.descripcion as marca, mo.nombre as modelo, 
ti.nombre as tipo, st.nombre as subtipo, v.chasis,   
v.anFab, v.anMod,  
vp.codVehiculoProspecto, v.codVehiculo,
pro.fechaCreacion, pro.codUsuario,
ec.nombre as estadoCom, eo.nombre as estadoOp,
concat(per.nombre ,' ', per.apePat) as vendedor, emp.nombre as empresa,
ofi.codOficina
from vehiculo_prospecto as vp
left join vehiculo as v on vp.codVehiculo=v.codVehiculo
left join marca as m on m.codMarca=v.codMarca
left join modelo as mo on mo.codModelo=v.codModelo
left join tipo as ti on ti.codTipo=v.codTipo
left join subtipo as st on st.codSubTipo=v.codSubTipo
left join prospecto as pro on pro.codProspecto=vp.codProspecto
left join estado_op as eo on eo.codEstadoOp=v.codEstadoOp
left join estado_com as ec on ec.codEstadoCom=v.codEstadoCom
left join usuario as usr on usr.codUsuario=pro.codUsuario
left join oficina as ofi on ofi.codOficina=usr.codOficina
left join persona as per on per.codPersona=usr.codPersona
left join usuario as u on pro.codUsuario=u.codUsuario
inner join empresa as emp on emp.codEmpresa=ofi.codEmpresa and emp.baja='0' and emp.escomercial='1' and emp.esconcesionario='1'
where fechaFacturacion is not null
and year(fechaFacturacion )='$gestion' and month(fechaFacturacion)='$mes'
and vp.baja='0' and pro.estado=2 $condicion
) as tab
inner join comision as com on com.baja='0' and com.codProspecto=tab.codProspecto 
and com.codVehiculoProspecto=tab.codVehiculoProspecto and com.codVehiculo=tab.codvehiculo
$condicion2
order by oficina, vendedor, codProspecto";
       
        
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
   
    
//Consulta SQL - MF --------------------------------------------------------------------------------
    
function RepComisionesGuardadas( $mes, $gestion, $rep, $codigo, $guardadas="", $mostrar=""){
        //--------------------------------------------------------------------------------
        $condicion="";
        $iUsuario = new Usuario();
        $iUsuario->RecuperarSesionCod($codigo);
        $perfil= $iUsuario->obtenerPerfil();
        if ($perfil=="Jefatura"){
            $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
        }
        $condicion2="";
        if($guardadas=="1"){
            $condicion2=" where cerrado='1' ";
        }
        $condicion3="";
        if($rep=="rep2"){
            $condicion3=" order by tab.oficina, emp ";
        }else {
            $condicion3=" order by emp, tab.oficina ";
          }   
        //--------------------------------------------------------------------------------

        $consulta="select tab.empresa, tab.marca, sum(com.TotalSus) as totus, sum(com.TotalBs) as totbs, 
            case when com.pagada='0' then 'No' else 'Si' end as pagada, tab.oficina,
            case when tab.marca='FIAT' then 'Carrera SRL' else 'Rodaria SRL' end as emp

            from (
            select ofi.codOficina, ofi.descripcion as oficina, vp.codProspecto as codigoprospecto, m.codMarca, m.descripcion as marca, emp.nombre             as empresa, vp.codVehiculoProspecto as codveprosp
            from vehiculo_prospecto as vp 
            left join vehiculo as v on vp.codVehiculo=v.codVehiculo 
            left join prospecto as pro on pro.codProspecto=vp.codProspecto 
            left join marca as m on m.codMarca=v.codMarca   
            left join usuario as usr on usr.codUsuario=pro.codUsuario 
            left join oficina as ofi on ofi.codOficina=usr.codOficina 
            inner join empresa as emp on emp.codEmpresa=ofi.codEmpresa and emp.baja='0' and emp.escomercial='1' and emp.esconcesionario='1' where             year(fechaFacturacion )='$gestion' and month(fechaFacturacion)='$mes'
            and vp.baja='0' and pro.estado=2 $condicion
            ) as tab

            inner join comision as com on com.baja='0' and com.codVehiculoProspecto=tab.codveprosp
            $condicion2
            group by tab.oficina, pagada, marca
            $condicion3 ";
       
        
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
   
    function Repmensualcom( $gestion, $rep, $codigo, $guardadas="", $mostrar=""){
        //--------------------------------------------------------------------------------
        $condicion="";
        $iUsuario = new Usuario();
        $iUsuario->RecuperarSesionCod($codigo);
        $perfil= $iUsuario->obtenerPerfil();
        if ($perfil=="Jefatura"){
            $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
        }
        $condicion2="";
        if($guardadas=="1"){
            $condicion2=" where cerrado='1' ";
        }
        $condicion3="";
        if($rep=="rep3"){
            $condicion3=" group by emp, empresa, marca, pagada ";
        }else {
            $condicion3=" group by empresa, emp, marca, pagada ";
          }   
            $condicion4="";
        if($rep=="rep3"){
            $condicion4=" order by emp, empresa ";
        }else {
            $condicion4=" order by empresa, emp ";
          } 
        //--------------------------------------------------------------------------------

        $consulta="select empresa, emp, marca, pagada, sum(enero) as ene, sum(febrero) as feb, sum(marzo) as mar, sum(abril) as abr, 
            sum(mayo) as may, sum(junio) as jun, sum(julio) as jul, sum(agosto) as ago, sum(septiembre) as sep, 
            sum(octubre) as oct, sum(noviembre) as nov, sum(diciembre) as dic, sum(total) as total, oficina

            from(
            select empresa, 
            case when marca='FIAT' then 'Carrera SRL' else 'Rodaria SRL' end as emp, marca, pagada, oficina,
            case when mes=1 then totus else 0 end as enero,
            case when mes=2 then totus else 0 end as febrero,
            case when mes=3 then totus else 0 end as marzo,
            case when mes=4 then totus else 0 end as abril,
            case when mes=5 then totus else 0 end as mayo,
            case when mes=6 then totus else 0 end as junio,
            case when mes=7 then totus else 0 end as julio,
            case when mes=8 then totus else 0 end as agosto,
            case when mes=9 then totus else 0 end as septiembre,
            case when mes=10 then totus else 0 end as octubre,
            case when mes=11 then totus else 0 end as noviembre,
            case when mes=12 then totus else 0 end as diciembre,
            totus as total

                from(
                select  tab.mes, tab.empresa, tab.marca, sum(com.TotalSus) as totus, sum(com.TotalBs) as totbs,
                case when com.pagada='0' then 'No' else 'Si' end as pagada, tab.oficina

                    from (
			        select ofi.codOficina, ofi.descripcion as oficina, vp.codProspecto as codigoprospecto, m.codMarca,
                    m.descripcion as marca, emp.nombre as empresa, vp.codVehiculoProspecto as codveprosp, month(fechaFacturacion) as mes
                        from vehiculo_prospecto as vp 
                        left join vehiculo as v on vp.codVehiculo=v.codVehiculo 
                        left join prospecto as pro on pro.codProspecto=vp.codProspecto 
                        left join marca as m on m.codMarca=v.codMarca   
                        left join usuario as usr on usr.codUsuario=pro.codUsuario 
                        left join oficina as ofi on ofi.codOficina=usr.codOficina 
                        inner join empresa as emp on emp.codEmpresa=ofi.codEmpresa and emp.baja='0' and emp.escomercial='1' and                 
                        emp.esconcesionario='1' 
                        where  year(fechaFacturacion)='$gestion'
                        and vp.baja='0' and pro.estado=2 $condicion
                    )as tab
         
                    inner join comision as com on com.baja='0' and com.codVehiculoProspecto=tab.codveprosp
                    $condicion2
                    group by mes, tab.oficina, pagada, marca
  
                ) as tab2
            ) as tab3
            $condicion3
            $condicion4";           
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

//Final Consulta SQL - MF --------------------------------------------------------------------------------

}
?>