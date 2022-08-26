<?php
require_once ("mysql.class.php");


class  Stock{
    public $mensaje="";
//***********************************************************************************************   
    public function DropDownGestion($gestion=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("select distinct anio from (
SELECT distinct anMod anio from vehiculo union all SELECT distinct anFab anio from vehiculo union all select Year(SYSDATE()) as anio union all select Year(SYSDATE()) + 1 as anio union all select Year(SYSDATE()) -1 as anio ) as tabla order by anio desc ")) $db->Kill();
		$db->MoveFirst();
		while (! $db->EndOfSeek()) {
			$selected="";
            $row = $db->Row();
            if ($row->anio==$gestion) $selected="selected";
			echo "<option value='".$row->anio."' $selected>".$row->anio."</option>";						
		}
				
	}
    
//***********************************************************************************************
	public function ObtenerChasis($codVehiculo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM vehiculo where codVehiculo=$codVehiculo")) $db->Kill();
		$db->MoveFirst();
		
		if (! $db->EndOfSeek()) {
			$row = $db->Row();
			return $row->chasis;						
		}
				
	}
//***********************************************************************************************
	public function DropDownMarcas($codMarca="", $codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $logico=false;
        $db->Query("SELECT * FROM usuariomarca where codUsuario=$codUsuario and baja='0' ");
        if($db->rowCount()>0){
            $logico=true;
        }
        $consulta="SELECT * FROM marca order by descripcion";
        if($logico){
            $consulta="select m.* from marca as m inner join usuariomarca as um on um.codMarca=m.codMarca where um.baja='0' and um.codUsuario=$codUsuario ";
        }

		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		while (! $db->EndOfSeek()) {
			$selected="";
            $row = $db->Row();
            if ($row->codMarca==$codMarca) $selected="selected";
			echo "<option value='".$row->codMarca."' $selected>".$row->descripcion."</option>";						
		}
				
	}
//***********************************************************************************************
	public function DropDownModelos($codmarca, $codmodelo=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM modelo where codMarca='$codmarca' order by nombre")) $db->Kill();
		$db->MoveFirst();
		echo "<option value=''>Todos</option>";
		while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($codmodelo==$row->codModelo) {$selected="selected";}
			echo "<option value='".$row->codModelo."' $selected >".$row->nombre."</option>";						
		}				
	}	
//***********************************************************************************************
	public function DropDownColores($codmodelo, $codcolor=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM color where codModelo='$codmodelo' order by nombre")) $db->Kill();
		$db->MoveFirst();
		echo "<option value=''>Todos</option>";
		while (! $db->EndOfSeek()) {
            $selected="";
			$row = $db->Row();
            if ($codcolor==$row->codColor) {$selected="selected";}
			echo "<option value='".$row->codColor."' $selected>".$row->nombre."</option>";						
		}
				
	}	
//***********************************************************************************************
    public function DropDownEstadoOperacional($estado){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM estado_op order by nombre")) $db->Kill();
		$db->MoveFirst();
        $selected="";
        echo "<option value=''>Todos</option>";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            $selected="";
            if($row->codEstadoOp==$estado){
                $selected="selected";
            }
            echo "<option value='".$row->codEstadoOp."' $selected>".$row->nombre."</option>";						
		}
				
	}
//***********************************************************************************************
	public function DropDownEstadoComercial($estado){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM estado_com order by nombre")) $db->Kill();
		$db->MoveFirst();
        $selected="";
		echo "<option value=''>Todos</option>";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            $selected="";
            if($row->codEstadoCom==$estado){
                $selected="selected";
            }
			echo "<option value='".$row->codEstadoCom."' $selected>".$row->nombre."</option>";						
		}
				
	}	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//*****************************************************
    public function ListarStock($codmarca, $codmodelo, $codcolor, $estadoop, $estadocom, $partida="", $chasis="", $tipo="", $subtipo="", $anmod="", $codubicacion="", $codUsuario){
		
		
		$condicion=" where codvehiculo>0 ";
		if (is_numeric($codmarca)&&($codmarca!="0")) $condicion.=  "  and v.codmarca='$codmarca'";
		if (is_numeric($codmodelo)) $condicion.= "  and v.codmodelo='$codmodelo'";
		if (is_numeric($codcolor)) $condicion.=  "  and v.codcolor='$codcolor'";
		if (is_numeric($estadoop)) $condicion.=  "  and v.codEstadoOp='$estadoop'";
		if (is_numeric($estadocom)) $condicion.= "  and v.codEstadoCom='$estadocom'";
        if (is_numeric($anmod)&&($anmod!="0"))  $condicion.= "  and v.anMod='$anmod'";
        
        if (is_numeric($tipo)&&($tipo!="0")) $condicion.=  "  and v.codTipo='$tipo'";
        if (is_numeric($subtipo)&&($subtipo!="0")) $condicion.=  "  and v.codSubTipo='$subtipo'";
        //if ($partida!="") $condicion.= "  and 1=1 ";
        if ($chasis!="") $condicion.= "  and v.chasis like '%$chasis%'";
        if ((is_numeric($codubicacion))&&($codubicacion<>"0")) $condicion.= "  and v.codUbicacion='$codubicacion'";
        
		$consulta="
		select v.codMarca, m.descripcion as Marca, mo.codModelo, mo.nombre as Modelo, co.codColor, co.nombre as Color, 
		ec.codEstadoCom, ec.nombre as EstadoCom, eo.codEstadoOp, eo.nombre as EstadoOp, count(*)  as Cantidad,
        t.codTipo, t.nombre as Tipo, s.codSubTipo, s.nombre as Subtipo, v.anMod
		from vehiculo as v 
		left join marca as m on m.codMarca=v.codMarca
		left join modelo as mo on mo.codModelo=v.codModelo
		left join color as co on co.codColor=v.codColor
		left join estado_com as ec on ec.codEstadoCom=v.codEstadoCom
		left join estado_op as eo on eo.codEstadoOp=v.codEstadoOp
        left join tipo as t on t.codTipo=v.codTipo
        left join subtipo as s on s.codSubTipo=v.codSubTipo
		$condicion
		group by 
		v.codMarca, m.descripcion , mo.codModelo, mo.nombre, co.codColor, co.nombre , 
		ec.codEstadoCom, ec.nombre , eo.codEstadoOp, eo.nombre, t.codTipo, t.nombre,
        s.codSubTipo, s.nombre, v.anMod
		";
		//$this->mensaje=$consulta;
        
		$db = new MySQL();
		if ($db->Error()){ 
			$db->Kill();
			return "vacio";
		}else{
            $logico=false;
            $db->Query("SELECT * FROM usuariomarca where codUsuario=$codUsuario and baja='0' ");
            if($db->rowCount()>0){
                $logico=true;
            }
            $condicion2="";
            if($logico){
                $condicion2=" and m.codMarca in (SELECT codMarca FROM usuariomarca where codUsuario=$codUsuario and baja='0') ";
                $consulta="
		select v.codMarca, m.descripcion as Marca, mo.codModelo, mo.nombre as Modelo, co.codColor, co.nombre as Color, 
		ec.codEstadoCom, ec.nombre as EstadoCom, eo.codEstadoOp, eo.nombre as EstadoOp, count(*)  as Cantidad,
        t.codTipo, t.nombre as Tipo, s.codSubTipo, s.nombre as Subtipo, v.anMod
		from vehiculo as v 
		left join marca as m on m.codMarca=v.codMarca
		left join modelo as mo on mo.codModelo=v.codModelo
		left join color as co on co.codColor=v.codColor
		left join estado_com as ec on ec.codEstadoCom=v.codEstadoCom
		left join estado_op as eo on eo.codEstadoOp=v.codEstadoOp
        left join tipo as t on t.codTipo=v.codTipo
        left join subtipo as s on s.codSubTipo=v.codSubTipo
		$condicion $condicion2
		group by 
		v.codMarca, m.descripcion , mo.codModelo, mo.nombre, co.codColor, co.nombre , 
		ec.codEstadoCom, ec.nombre , eo.codEstadoOp, eo.nombre, t.codTipo, t.nombre,
        s.codSubTipo, s.nombre, v.anMod
		";
            }
			if (! $db->Query($consulta)) {
				$db->Kill();
				return "vacio";
			}else{
                
				return $db;
			}
		}
	}	
    //*****************************************************
	public function ListarStockDetallado($codmarca, $codmodelo, $codcolor, $estadoop, $estadocom, $partida="", $chasis="", $codubicacion="", $tipo="", $subtipo="", $anmod=""){ //RAMS
		
		
		$condicion=" where codvehiculo>0 ";
		if ((is_numeric($codmarca))&&($codmarca<>"0")) $condicion.=  "  and v.codmarca='$codmarca'";
		if ((is_numeric($codmodelo))&&($codmodelo<>"0")) $condicion.= "  and v.codmodelo='$codmodelo'";
		if ((is_numeric($codcolor))&&($codcolor<>"0")) $condicion.=  "  and v.codcolor='$codcolor'";
		if ((is_numeric($estadoop))&&($estadoop<>"0")) $condicion.=  "  and v.codEstadoOp='$estadoop'";
		if ((is_numeric($estadocom))&&($estadocom<>"0")) $condicion.= "  and v.codEstadoCom='$estadocom'";
        if ((is_numeric($codubicacion))&&($codubicacion<>"0")) $condicion.= "  and v.codUbicacion='$codubicacion'";
        if ($partida!="") $condicion.= "  and v.partida='$partida' ";
        if ($chasis!="") $condicion.= "  and v.chasis like '%$chasis%'";
        if (is_numeric($tipo)&&($tipo!="0")) $condicion.=  "  and v.codTipo='$tipo'"; //RAMS
        if (is_numeric($subtipo)&&($subtipo!="0")) $condicion.=  "  and v.codSubTipo='$subtipo'"; //RAMS
        if (is_numeric($anmod)&&($anmod!="0"))  $condicion.= "  and v.anMod='$anmod'"; //RAMS
		
		$consulta="
		select v.codMarca, m.descripcion as Marca, mo.codModelo, mo.nombre as Modelo, ti.nombre as Tipo, st.nombre as SubTipo, co.codColor, 
        co.nombre as Color, ec.codEstadoCom, ec.nombre as EstadoCom, eo.codEstadoOp, eo.nombre as EstadoOp, v.codVehiculo, v.chasis, v.anFab, v.anMod, 
        v.fechaLlegada, ubi.abreviatura as ubicacioncorto, ubi.nombre as ubicacion
		from vehiculo as v 
		left join marca as m on m.codMarca=v.codMarca
		left join modelo as mo on mo.codModelo=v.codModelo
        left join tipo as ti on ti.codTipo=v.codTipo
        left join subtipo as st on st.codSubTipo=v.codSubTipo
		left join color as co on co.codColor=v.codColor
		left join estado_com as ec on ec.codEstadoCom=v.codEstadoCom
		left join estado_op as eo on eo.codEstadoOp=v.codEstadoOp
        left join ubicacion as ubi on ubi.codUbicacion=v.codUbicacion
		$condicion
		";
		$this->mensaje=$consulta;
        
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
//*****************************************************
    public function ListarStockDetalle($codmodelo, $codcolor, $estadoop, $estadocom, $tipo="", $subtipo="", $anmod="", $codubicacion=""){
		
		
		$condicion=" where codvehiculo>0 ";

		if (is_numeric($codmodelo)) $condicion.= "  and v.codmodelo='$codmodelo'";
        if (is_numeric($anmod)) $condicion.= "  and v.anMod='$anmod'";
		if (is_numeric($codcolor)) $condicion.=  "  and v.codcolor='$codcolor'";
		if (is_numeric($estadoop)) $condicion.=  "  and v.codEstadoOp='$estadoop'";
		if (is_numeric($estadocom)) $condicion.= "  and v.codEstadoCom='$estadocom'";
		if (is_numeric($tipo)&&($tipo!="0")) $condicion.=  "  and v.codTipo='$tipo'";
        if (is_numeric($subtipo)&&($subtipo!="0")) $condicion.=  "  and v.codSubTipo='$subtipo'";
        if ((is_numeric($codubicacion))&&($codubicacion<>"0")) $condicion.= "  and v.codUbicacion='$codubicacion'";
        
		$consulta="
		select v.codMarca, m.descripcion as Marca, mo.codModelo, mo.nombre as Modelo, co.codColor, co.nombre as Color, 
		ec.codEstadoCom, ec.nombre as EstadoCom, eo.codEstadoOp, eo.nombre as EstadoOp, u.nombre as Ubicacion, 
        t.nombre as Tipo, s.nombre as Subtipo ,count(*)  as Cantidad, coi.nombre as ColorInt, v.anMod, 
        IFNULL(DATE_FORMAT(v.fechaLlegada,'%d-%m-%Y'),'No Disponible') as fechaLlegada, IFNULL(v.warrant,'No') as warrant
		from vehiculo as v 
		left join marca as m on m.codMarca=v.codMarca
		left join modelo as mo on mo.codModelo=v.codModelo
		left join color as co on co.codColor=v.codColor
        left join color_int as coi on coi.codColorInt=v.codColorInt
		left join estado_com as ec on ec.codEstadoCom=v.codEstadoCom
		left join estado_op as eo on eo.codEstadoOp=v.codEstadoOp
		left join ubicacion as u on u.codUbicacion=v.codUbicacion
        left join tipo as t on t.codTipo=v.codTipo
        left join subtipo as s on s.codSubTipo=v.codSubTipo
		$condicion
		group by 
		v.codMarca, m.descripcion , mo.codModelo, mo.nombre, co.codColor, co.nombre , 
		ec.codEstadoCom, ec.nombre , eo.codEstadoOp, eo.nombre , u.nombre, t.nombre, s.nombre, coi.nombre, v.anMod,
        DATE_FORMAT(v.fechaLlegada,'%d-%m-%Y'), v.warrant
		";
		//echo "$consulta";
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
//*****************************************************
	public function DetalleVehiculo($codVehiculo){
		$consulta="
		select v.codMarca, m.descripcion as Marca, mo.codModelo, mo.nombre as Modelo, co.codColor, co.nombre as Color, coi.codColorInt, coi.nombre as ColorInt, ec.codEstadoCom, ec.nombre as EstadoCom, eo.codEstadoOp, 
eo.nombre as EstadoOp, u.abreviatura as Ubi, u.nombre as Ubicacion, 1  as Cantidad, 
v.anFab, v.anMod, v.chasis, v.motor, v.codOCSAP, v.codPedido, venta.prospecto, venta.codProspecto, 
DATE_FORMAT(venta.fechaCreacion,'%d-%m-%Y') as fechaCreacion, venta.vendedor, venta.precioVenta,  ti.codTipo, sti.codSubTipo, ti.nombre as Tipo, sti.nombre as Subtipo, DATE_FORMAT(  v.fechaLlegada ,  '%d-%m-%Y' ) as fechaLlegada, v.warrant, case when v.warrant='1' then 'Si' else 'No' end as vwarrant, DATE_FORMAT(  v.fechaLlegada ,  '%Y-%m-%d' )  as vfechaLlegada, v.partida, v.poliza
from vehiculo as v 
left join marca as m on m.codMarca=v.codMarca
left join modelo as mo on mo.codModelo=v.codModelo
left join tipo as ti on ti.codTipo=v.codTipo
left join subtipo as sti on sti.codSubTipo=v.codSubTipo
left join color as co on co.codColor=v.codColor
left join color_int as coi on coi.codColorInt=v.codColorInt
left join estado_com as ec on ec.codEstadoCom=v.codEstadoCom
left join estado_op as eo on eo.codEstadoOp=v.codEstadoOp
left join ubicacion as u on u.codUbicacion=v.codUbicacion
left join (
	select p.nombre as prospecto, p.codProspecto, p.fechaCreacion, 
	CONCAT(per.nombre, ' ', per.apePat, ' ', per.apeMat) as vendedor, vp.precioVenta,
	vp.codVehiculo
	from vehiculo_prospecto as vp 
	left join prospecto as p on p.codProspecto=vp.codProspecto
	left join usuario as u on u.codUsuario=p.codUsuario
	left join persona as per on per.codPersona=u.codPersona
	where vp.codVehiculo=$codVehiculo
) as venta on venta.codVehiculo=v.codVehiculo
where v.codVehiculo=$codVehiculo
		";
		//echo "$consulta";
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
//************************************************************
//******************************************************************************************************
function ModificarVehiculo($hcodVehiculo,$ddmarca, $ddmodelo, $ddtipo, $ddsubtipo, $ddcolor, $ddcolorinterior, $ddAnioComercial, $ddAnioFabrica, $ddEstadoCom, $ddEstadoOp, $ddUbicacion, $ddSubTipo, $chasis, $motor, $warrant, $fecLlegada){
		// Creo una nueva conexion 
		$db= new MySQL();
		if ($db->Error()){ 
			$db->Kill();
			return false;
		}		
    if ($fecLlegada==""){
        $fecLlegada=NULL;
    }else{
        $fecLlegada="'".$fecLlegada."'";
    }
		$consulta="update vehiculo set codMarca=$ddmarca, codModelo=$ddmodelo, codTipo=$ddtipo, codSubTipo=$ddsubtipo, codColor=$ddcolor, codColorInt=$ddcolorinterior, anMod='$ddAnioComercial', anFab='$ddAnioFabrica', codEstadoCom=$ddEstadoCom, codEstadoOp=$ddEstadoOp, codUbicacion=$ddUbicacion, codSubtipo=$ddSubTipo, chasis='$chasis', motor='$motor', warrant='$warrant', fechaLlegada=$fecLlegada  where codVehiculo=$hcodVehiculo ";
		
		if (! $db->Query($consulta)){ 
			$this->mensaje=$consulta;
            return false;
		}
    //$this->mensaje=$consulta;
		return true;
	}
    //******************************************************************************************************
function ModificarVehiculo2($hcodVehiculo,$ddmarca, $ddmodelo, $ddtipo, $ddsubtipo, $ddcolor, $ddcolorinterior, $ddAnioComercial, $ddAnioFabrica, $ddEstadoCom, $ddEstadoOp, $ddUbicacion, $ddSubTipo, $chasis, $motor,$ddWarrant, $fecLlegada){
		// Creo una nueva conexion 
		$db= new MySQL();
		if ($db->Error()){ 
			$db->Kill();
			return false;
		}		
        $bandera=false;
		$consulta="update vehiculo set ";
        if (($ddmarca!="")&&($ddmarca!="0")){
            $consulta.=" codMarca=$ddmarca";
            $bandera=true;
        }
        if (($ddmodelo!="")&&($ddmodelo!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" codModelo=$ddmodelo";
            $bandera=true;
        }
      
        if (($ddtipo!="")&&($ddtipo!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" codTipo=$ddtipo";
            $bandera=true;
        }
        
        if (($ddsubtipo!="")&&($ddsubtipo!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" codSubTipo=$ddsubtipo";
            $bandera=true;
        }
        
        if (($ddcolor!="")&&($ddcolor!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" codColor=$ddcolor";
            $bandera=true;
        }
        if (($ddcolorinterior!="")&&($ddcolorinterior!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" codColorInt=$ddcolorinterior";
            $bandera=true;
        }
    
        if (($ddAnioComercial!="")&&($ddAnioComercial!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" anMod='$ddAnioComercial'";
            $bandera=true;
        }
    
        if (($ddAnioFabrica!="")&&($ddAnioFabrica!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" anFab='$ddAnioFabrica'";
            $bandera=true;
        }
    
        if (($ddEstadoCom!="")&&($ddEstadoCom!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" codEstadoCom=$ddEstadoCom";
            $bandera=true;
        }
    
        if (($ddEstadoOp!="")&&($ddEstadoOp!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" codEstadoOp=$ddEstadoOp";
            $bandera=true;
        }
    
        if (($ddUbicacion!="")&&($ddUbicacion!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" codUbicacion=$ddUbicacion";
            $bandera=true;
        }
        
        if (($ddSubTipo!="")&&($ddSubTipo!="0")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" codSubtipo=$ddSubTipo";
            $bandera=true;
        }
    
        if (($ddWarrant!="")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" warrant='$ddWarrant'";
            $bandera=true;
        }
    
        if (($fecLlegada!="")){
            if($bandera){
                $consulta.=" , ";
            }
            $consulta.=" fechaLlegada='$fecLlegada'";
            $bandera=true;
        }
        
        $consulta.="  where codVehiculo=$hcodVehiculo ";
        
		if (! $db->Query($consulta)){ 
			$this->mensaje=$consulta;
            return false;
		}
    //$this->mensaje=$consulta;
		return true;
	}
 //******************************************************************************************************    
function ListarPrecios($marca, $modelo, $gestion, $tipo, $subtipo){
    $condicion="";
    if ((is_numeric($marca))&&($marca>"0")){
        $condicion.=" and m.codMarca='$marca' ";
    }
    if ((is_numeric($modelo))&&($modelo>"0")){
        $condicion.=" and mo.codModelo='$modelo' ";
    }
    if ((is_numeric($gestion))&&($gestion>"0")){
        $condicion.=" and pm.gestion='$gestion' ";
    }
    if ((is_numeric($tipo))&&($tipo>"0")){
        $condicion.=" and pm.codTipo='$tipo' ";
    }
    if ((is_numeric($subtipo))&&($subtipo>"0")){
        $condicion.=" and pm.codSubtipo='$subtipo' ";
    }
    $db = new MySQL();
		if ($db->Error()) $db->Kill();
    $consulta="
    select pm.*, m.descripcion as Marca, mo.nombre as Modelo, t.nombre as Tipo, st.nombre as Subtipo, pm.gestion
    from precio_modelo as pm
    left join marca as m on m.codMarca=pm.codMarca
    left join modelo as mo on mo.codModelo=pm.codModelo
    left join tipo as t on t.codTipo=pm.codTipo
    left join subtipo as st on st.codSubTipo=pm.codSubTipo
    where pm.baja='0' $condicion 
    order by m.descripcion, mo.nombre, t.nombre, st.nombre, pm.gestion desc";
		if (! $db->Query($consulta)) $db->Kill();
		return $db;
}
//********************************************************************    
 function ListarSinProforma(){    
    $db = new MySQL();
    if ($db->Error()) $db->Kill();
   $consulta="
    select m.descripcion as marca, mo.nombre as modelo, t.nombre as tipo, s.nombre as subtipo, tab.anMod
    from (
    select distinct v.codMarca, v.codModelo, v.codTipo, v.codSubtipo, v.anMod, 
    min(codEspecificacionTecnica) as especificacion
    from vehiculo as v
    left join especificacion_tecnica as e on e.codModelo=v.codModelo and e.codTipo=v.codTipo and e.gestion=v.anMod
    and e.codSubTipo=v.codSubTipo and e.baja='0'
    group by v.codMarca, v.codModelo, v.codTipo, v.codSubtipo, v.anMod
    ) as tab
    left join marca as m on m.codMarca=tab.codMarca
    left join modelo as mo on mo.codModelo=tab.codModelo
    left join tipo as t on t.codTipo=tab.codTipo
    left join subtipo as s on s.codSubTipo=tab.codSubTipo
    where tab.especificacion is null
    order by tab.codMarca, tab.codModelo, tab.codTipo, tab.codSubTipo, tab.anMod";
    
    if (! $db->Query($consulta)) $db->Kill();
    return $db;
     
 }
//********************************************************************    
 function ListarSinImagen(){    
    $db = new MySQL();
    if ($db->Error()) $db->Kill();
   $consulta="
select distinct marca, modelo, anMod, CONCAT(codModelo, '_', codTipo , '_', codSubTipo, '_', anMod,'.jpg') as archivo, 
'670px' as ancho,  '350px' as alto, tipo, subtipo from (
select ma.descripcion as marca, m.codModelo, m.nombre as modelo, c.anMod, t.codTipo, s.codSubTipo,
t.nombre as tipo, s.nombre as subtipo
from modelo as m
left join marca as ma on ma.codMarca=m.codMarca
left join tipo as t on t.codModelo = m.codModelo
left join subtipo as s on s.codTipo = t.codTipo
left join ( select distinct anMod, codModelo from vehiculo) as c on c.codModelo=m.codModelo
) as tabla 
order by marca, modelo, anMod desc";
    
    if (! $db->Query($consulta)) $db->Kill();
    return $db;
     
 }
    //********************************************************************    
    function ListarSinPoliza(){    
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="
select ma.descripcion as marca, m.codModelo, m.nombre as modelo, v.anMod, t.codTipo, s.codSubTipo,
t.nombre as tipo, s.nombre as subtipo, v.chasis, v.fechaLlegada
from vehiculo as v
inner join modelo as m on m.codModelo=v.codModelo
inner join marca as ma on ma.codMarca=v.codMarca
inner join tipo as t on t.codTipo = v.codTipo
inner join subtipo as s on s.codSubTipo = v.codSubTipo
where poliza is null or poliza=''
order by codVehiculo desc limit 100 ";

        if (! $db->Query($consulta)) $db->Kill();
        return $db;

    }
//********************************************************************    
function StockExcel($codmarca, $codmodelo, $codcolor, $estadoop, $estadocom, $partida, $chasis, $ubicacion, $tipo, $subtipo, $anmod){ //RAMS
    $db = new MySQL();
    if ($db->Error()) $db->Kill();
    
    $condicion=" where codvehiculo>0 ";
		if ((is_numeric($codmarca))&&($codmarca<>"0")) $condicion.=  "  and v.codmarca='$codmarca'";
		if ((is_numeric($codmodelo))&&($codmodelo<>"0")) $condicion.= "  and v.codmodelo='$codmodelo'";
		if ((is_numeric($codcolor))&&($codcolor<>"0")) $condicion.=  "  and v.codcolor='$codcolor'";
		if ((is_numeric($estadoop))&&($estadoop<>"0")) $condicion.=  "  and v.codEstadoOp='$estadoop'";
		if ((is_numeric($estadocom))&&($estadocom<>"0")) $condicion.= "  and v.codEstadoCom='$estadocom'";
        if ((is_numeric($ubicacion))&&($ubicacion<>"0")) $condicion.= "  and u.codUbicacion='$ubicacion'";
        
        if (is_numeric($tipo)&&($tipo!="0")) $condicion.=  "  and v.codTipo='$tipo'";//RAMS
        if (is_numeric($subtipo)&&($subtipo!="0")) $condicion.=  "  and v.codSubTipo='$subtipo'";//RAMS
        if (is_numeric($anmod)&&($anmod!="0"))  $condicion.= "  and v.anMod='$anmod'";//RAMS
        
        //if ($partida!="") $condicion.= "  and 1=1 ";
        if ($chasis!="") $condicion.= "  and v.chasis like '%$chasis%'";

    $consulta="
		select v.codMarca, m.descripcion as Marca, mo.codModelo, mo.nombre as Modelo, co.codColor, 
        co.nombre as Color, v.anFab, v.anMod,
		ec.codEstadoCom, ec.nombre as EstadoCom, eo.codEstadoOp, eo.nombre as EstadoOp, v.codVehiculo, v.chasis,
        ti.codTipo, sti.codSubTipo, ti.nombre as Tipo, sti.nombre as Subtipo,
        coi.codColorInt, coi.nombre as ColorInt, u.nombre as Ubicacion,
        v.codOCSAP, v.codPedido, IFNULL(DATE_FORMAT(v.fechaLlegada,'%d-%m-%Y'),'No Disponible') as fechaLlegada
		from vehiculo as v 
		left join marca as m on m.codMarca=v.codMarca
		left join modelo as mo on mo.codModelo=v.codModelo
		left join color as co on co.codColor=v.codColor
		left join estado_com as ec on ec.codEstadoCom=v.codEstadoCom
		left join estado_op as eo on eo.codEstadoOp=v.codEstadoOp
        left join tipo as ti on ti.codTipo=v.codTipo
        left join subtipo as sti on sti.codSubTipo=v.codSubTipo
        left join color_int as coi on coi.codColorInt=v.codColorInt
        left join ubicacion as u on u.codUbicacion=v.codUbicacion
		$condicion
		";
    if (! $db->Query($consulta)) $db->Kill();
    return $db;
}
    //******************************************************************************************************
    function CargarPoliza($chasis){
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
        if ($fecLlegada==""){
            $fecLlegada=NULL;
        }else{
            $fecLlegada="'".$fecLlegada."'";
        }
        $consulta="update vehiculo set poliza='1'  where chasis='$chasis' ";
//echo "<hr>".$consulta;
        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }

//-MF-*****************************************************
    public function ListarMarcas(){


        $consulta="select ma.codMarca, ma.abreviatura, ma.descripcion
from marca as ma ";
        
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
//******************************************************************************************************

//*****************************************************
    public function ListarModelos($codMarca){


        $consulta="select mo.codModelo, mo.codMarca, mo.abreviatura, mo.nombre, mo.codPais, mo.codProveedor,
ma.descripcion as marca, p.descripcion as pais, emp.nombre as empresa, emp.codEmpresa,
mo.comModelo, mo.comModeloPre
from modelo as mo
left join marca as ma on ma.codMarca=mo.codMarca
left join pais as p on p.codPais=mo.codPais
left join proveedor as pro on pro.codProveedor=mo.codProveedor
left join empresa as emp on emp.codEmpresa=pro.codEmpresa
where mo.codMarca='$codMarca'	";
        
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

//*MF*****************************************************
    public function ListarTipos($codModelo){

        if (($codModelo=="0")||($codModelo=="")) {
            return "vacio"; 
        
        }
        $consulta="select ti.codTipo, ti.codModelo, ti.abreviatura, ti.nombre,
        mo.nombre as modelname
        from tipo as ti
        left join modelo as mo on mo.codModelo=ti.codModelo
        where ti.codModelo='$codModelo'";
       
        
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

//*MF*****************************************************
    public function ListarSubTipos($codTipo){

        if (($codTipo=="0")||($codTipo=="")) {
            return "vacio"; 
        
        }
        $consulta="select st.codSubTipo, st.codTipo, st.abreviatura, st.nombre,
        ti.nombre as tiponame
        from subtipo as st
        left join tipo as ti on ti.codTipo=st.codTipo
        where st.codTipo='$codTipo'";
       
        
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

//*MF*****************************************************
    public function ListarColores($codModelo){

        if (($codModelo=="0")||($codModelo=="")) {
            return "vacio"; 
        
        }
        $consulta="select co.codColor, co.codModelo, co.abreviatura, co.nombre,
        mo.nombre as modelname
        from color as co
        left join modelo as mo on co.codModelo=mo.codModelo
        where co.codModelo='$codModelo'";
       
        
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
    
//*MF*****************************************************
    public function ListarColoresInt($codModelo){

        if (($codModelo=="0")||($codModelo=="")) {
            return "vacio"; 
        
        }
        $consulta="select co.codColorInt, co.codModelo, co.abreviatura, co.nombre,
        mo.nombre as modelname
        from color_int as co
        left join modelo as mo on co.codModelo=mo.codModelo
        where co.codModelo='$codModelo'";
       
        
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
    
//*MF*****************************************************************************************************
    function CrearMarca($abreviatura, $descripcion){
        // if(($codMarca=="0")||($codMarca=="")){return false;}
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
       
        $consulta="insert into marca(abreviatura, descripcion) values ('$abreviatura', '$descripcion')";
        
        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }

    
//-MF********************************************************************    
    function EditarMarca($codMarca, $abreviatura, $descripcion){
        if(($codMarca=="0")||($codMarca=="")){return false;}
        
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
        
        $consulta="update marca set abreviatura='$abreviatura', descripcion='$descripcion'
        where codMarca=$codMarca";

        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }
   
    
//******************************************************************************************************
    function CrearModelo($codMarca, $abreviatura, $nombre, $codPais, $codProveedor, $comModelo, $comModeloPre){
        if(($codMarca=="0")||($codMarca=="")){return false;}
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
       
        $consulta="insert into modelo(codMarca, abreviatura, nombre, codPais, codProveedor, codUsuario, comModelo, comModeloPre, baja) values ($codMarca, '$abreviatura', '$nombre', $codPais, $codProveedor, 0, '$comModelo', '$comModeloPre', '0')";
        
        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }
//********************************************************************    
    function EditarModelo($codMarca, $abreviatura, $nombre, $codPais, $codProveedor, $comModelo, $comModeloPre, $codModelo){
        if(($codMarca=="0")||($codMarca=="")){return false;}
        
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
        
        $consulta="update modelo set codMarca='$codMarca', abreviatura='$abreviatura', nombre='$nombre', codPais='$codPais', codProveedor='$codProveedor', comModelo='$comModelo', comModeloPre='$comModeloPre' where codModelo='$codModelo' ";

        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }
   

//*MF*****************************************************************************************************

    function CrearTipo($codModelo, $abreviatura, $nombre){
        // if(($codMarca=="0")||($codMarca=="")){return false;}
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
       
        $consulta="insert into tipo(codModelo, abreviatura, nombre) values ('$codModelo', '$abreviatura', '$nombre')";
        
            
        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }
    
//-MF********************************************************************    
    function EditarTipo($codTipo, $codModelo, $abreviatura, $nombre){
        //if(($codMarca=="0")||($codMarca=="")){return false;}
        
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
        
        $consulta="update tipo set abreviatura='$abreviatura', nombre='$nombre'
        where codTipo=$codTipo";
       

        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }
    
//*MF*****************************************************************************************************

    function CrearSubTipo($codTipo, $abreviatura, $nombre){
        // if(($codMarca=="0")||($codMarca=="")){return false;}
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
       
        $consulta="insert into subtipo(codTipo, abreviatura, nombre) values ('$codTipo', '$abreviatura', '$nombre')";
                    
        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }
    
    



//-MF********************************************************************  

    function EditarSubTipo($codSubTipo, $codTipo, $abreviatura, $nombre){
        //if(($codMarca=="0")||($codMarca=="")){return false;}
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
        
        $consulta="update subtipo set abreviatura='$abreviatura', nombre='$nombre'
        where codSubTipo=$codSubTipo";
      
        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }
    
//*MF*****************************************************************************************************

    function CrearColor($codModelo, $abreviatura, $nombre){
        // if(($codMarca=="0")||($codMarca=="")){return false;}
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
       
        $consulta="insert into color(codModelo, abreviatura, nombre) values ('$codModelo', '$abreviatura', '$nombre')";
        
            
        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }
    
//-MF********************************************************************    
    
    function EditarColor($codColor, $codModelo, $abreviatura, $nombre){
        //if(($codMarca=="0")||($codMarca=="")){return false;}
        
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
        
        $consulta="update color set abreviatura='$abreviatura', nombre='$nombre'
        where codColor=$codColor";
       

        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }    

    //*MF*****************************************************************************************************

    function CrearColorInt($codModelo, $abreviatura, $nombre){
        // if(($codMarca=="0")||($codMarca=="")){return false;}
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
       
        $consulta="insert into color_int(codModelo, abreviatura, nombre) values ('$codModelo', '$abreviatura', '$nombre')";
        
            
        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }
    
//-MF********************************************************************    
    
    function EditarColorInt($codColorInt, $codModelo, $abreviatura, $nombre){
        //if(($codMarca=="0")||($codMarca=="")){return false;}
        
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
        
        $consulta="update color_int set abreviatura='$abreviatura', nombre='$nombre'
        where codColorInt=$codColorInt";
       

        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }



//-MF********************************************************************    
    
    function EditarChasis($codVehiculo, $chasis){
        //if(($codMarca=="0")||($codMarca=="")){return false;}
        
        // Creo una nueva conexion 
        $db= new MySQL();
        if ($db->Error()){ 
            $db->Kill();
            return false;
        }		
        
        $consulta="update vehiculo set chasis='$chasis'
        where codVehiculo=$codVehiculo";

        if (! $db->Query($consulta)){ 
            $this->mensaje=$consulta;
            return false;
        }
        //$this->mensaje=$consulta;
        return true;
    }

}

?>