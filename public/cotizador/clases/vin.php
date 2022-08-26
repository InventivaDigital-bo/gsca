<?php
require_once "../clases/mysql.class.php";
require_once "../clases/mail.php";

class Vin{
	
	public $mensaje="";
	
	//*****************************************************
	public function ListarSolicitudesAsignacion($marca, $vendedor){
        $condicion="";
        if ((is_numeric($marca))&&($marca>0)){
            $condicion=" and m.codMarca=$marca ";
        }
        if ((is_numeric($vendedor))&&($vendedor>0)){
            $condicion=" and p.codUsuario=$vendedor ";
        }
		$consulta="
select p.codProspecto, p.nombre, m.nombre as modelo, m.codModelo, c.nombre as color, c.codColor, s.*  , ma.descripcion as marca
from solicitud_asignacion  as s
left join vehiculo_prospecto as v on v.codVehiculoProspecto=s.codVehiculoProspecto
left join prospecto as p on p.codprospecto=v.codProspecto
left join estado_solicitud_asignacion as e on e.codEstadoSolicitudAsignacion=s.codEstadoSolicitudAsignacion
left join modelo as m on m.codModelo=v.codModelo
left join color as c on c.codColor=v.codColor
left join marca as ma on ma.codMarca=m.codMarca
where s.codEstadoSolicitudAsignacion = (select codEstadoSolicitudAsignacion from estado_solicitud_asignacion where descripcion='Pendiente' limit 1) $condicion
";		
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
	public function ListarSolicitudesDesasignacion(){
		$consulta="
select p.codProspecto, p.nombre, m.nombre as modelo, m.codModelo, c.nombre as color, c.codColor, s.*  , ma.descripcion as marca
from solicitud_desasignacion  as s
left join vehiculo_prospecto as v on v.codVehiculoProspecto=s.codVehiculoProspecto
left join prospecto as p on p.codprospecto=v.codProspecto
left join estado_solicitud_asignacion as e on e.codEstadoSolicitudAsignacion=s.codEstadoSolicitudDesasignacion
left join modelo as m on m.codModelo=v.codModelo
left join color as c on c.codColor=v.codColor
left join marca as ma on ma.codMarca=m.codMarca
where s.codEstadoSolicitudDesasignacion = (select codEstadoSolicitudAsignacion from estado_solicitud_asignacion where descripcion='Pendiente' limit 1)
";		
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
	public function DatosSolicitudAsignacion($cod){
		$consulta="
select p.codProspecto, p.nombre, m.nombre as modelo, m.codModelo, c.nombre as color, c.codColor, s.*, ma.descripcion as marca, 
per.correo, p.codUsuario
from solicitud_asignacion  as s
left join vehiculo_prospecto as v on v.codVehiculoProspecto=s.codVehiculoProspecto
left join prospecto as p on p.codprospecto=v.codProspecto
left join estado_solicitud_asignacion as e on e.codEstadoSolicitudAsignacion=s.codEstadoSolicitudAsignacion
left join modelo as m on m.codModelo=v.codModelo
left join color as c on c.codColor=v.codColor
left join marca as ma on ma.codMarca=m.codMarca
left join usuario as usr on usr.codUsuario=p.codUsuario
left join persona as per on per.codPersona=usr.codPersona
where s.codSolicitudAsignacion='$cod'
";		
		$db = new MySQL();
		if ($db->Error()){ 
			$db->Kill();
			return "vacio";
		}else{
			if (! $db->Query($consulta)) {
				$db->Kill();
				return "vacio";
			}else{
				$db->MoveFirst();
				return $db->Row();
			}
		}
	}
    //*****************************************************
	public function DatosSolicitudDesasignacion($cod){
		$consulta="
select p.codProspecto, p.nombre, m.nombre as modelo, m.codModelo, c.nombre as color, c.codColor, s.*, ma.descripcion as marca, 
per.correo, p.codUsuario  
from solicitud_desasignacion  as s
left join vehiculo_prospecto as v on v.codVehiculoProspecto=s.codVehiculoProspecto
left join prospecto as p on p.codprospecto=v.codProspecto
left join estado_solicitud_asignacion as e on e.codEstadoSolicitudAsignacion=s.codEstadoSolicitudDesasignacion
left join modelo as m on m.codModelo=v.codModelo
left join color as c on c.codColor=v.codColor
left join marca as ma on ma.codMarca=m.codMarca
left join usuario as usr on usr.codUsuario=p.codUsuario
left join persona as per on per.codPersona=usr.codPersona
where s.codSolicitudDesasignacion=$cod
";		
		$db = new MySQL();
		if ($db->Error()){ 
			$db->Kill();
			return "vacio";
		}else{
			if (! $db->Query($consulta)) {
				$db->Kill();
				return "vacio";
			}else{
				$db->MoveFirst();
				return $db->Row();
			}
		}
	}
	//******************************************************************************************************
	function RechazarSolicitud($codSolicitud, $motivo){
		// Creo una nueva conexion 
		$success = true;
		$db= new MySQL();
		
		if ($db->Error()){ 
			$db->Kill();
			$this->mensaje="NO DB";
			return "0";
		}
		
		$consulta="update solicitud_asignacion set codEstadoSolicitudAsignacion=(select codEstadoSolicitudAsignacion from estado_solicitud_asignacion where descripcion like '%Rechazada' limit 1), observaciones='$motivo' where codSolicitudAsignacion='$codSolicitud'";
        //echo $consulta."<hr>";
		$this->mensaje=$consulta;
		if (!$db->Query($consulta)){ 
			$success = false;
			$this->mensaje="ERROR: no se puede rechazar<hr>$consulta";
		}
		if ($success){
			$this->mensaje="todo ok";
			// Debo mandar correo solicitando asignacion
			//---------------------------------------------
			$codsolicitud=$db->GetLastInsertID();
			$iCorreo = new Correo();
			$iCorreo->RechazarAsignacion($codSolicitud);
			return true;
		}
		return $success;
	}
    //******************************************************************************************************
	function RechazarSolicitudDesasignacion($codSolicitud, $motivo){
		// Creo una nueva conexion 
		$success = true;
		$db= new MySQL();
		
		if ($db->Error()){ 
			$db->Kill();
			$this->mensaje="NO DB";
			return "0";
		}
		
		$consulta="update solicitud_desasignacion set codEstadoSolicitudDesasignacion=(select codEstadoSolicitudAsignacion from estado_solicitud_asignacion where descripcion like '%Rechazada' limit 1), observaciones='$motivo' where codSolicitudDesasignacion=$codSolicitud
		";
		$this->mensaje=$consulta;
		if (!$db->Query($consulta)){ 
			$success = false;
			$this->mensaje="ERROR: no se puede rechazar<hr>$consulta";
		}
		if ($success){
			$this->mensaje="todo ok";
			// Debo mandar correo solicitando asignacion
			//---------------------------------------------
			$codsolicitud=$db->GetLastInsertID();
			$iCorreo = new Correo();
			$iCorreo->RechazarDesasignacion($codSolicitud);
			return true;
		}
		return $success;
	}
	
	//*****************************************************
	public function Asignar($cod, $veh){
		$success=true;
		$db= new MySQL();
        $db->ThrowExceptions = true;
		if (! $db->TransactionBegin()) $db->Kill();
        
		$consulta="update solicitud_asignacion set codVehiculo=$veh , codEstadoSolicitudAsignacion=(select codEstadoSolicitudAsignacion from estado_solicitud_asignacion where descripcion='Aprobada' limit 1) where codSolicitudAsignacion=$cod and codVehiculo is null and codEstadoSolicitudAsignacion=(select codEstadoSolicitudAsignacion from estado_solicitud_asignacion where descripcion='Pendiente' limit 1)";
		if (! $db->Query($consulta)){ 
			$success = false;
			$this->mensaje="ERROR: no se puede asignar<hr>$consulta";
		}
	
		$consulta="
select s.codVehiculoProspecto from solicitud_asignacion as s 
where s.codSolicitudAsignacion=$cod";
		if (! $db->Query($consulta)){ 
			$success = false;
			$this->mensaje="ERROR: no se encuentra prospecto<hr>$consulta";
		}else{
			$db->MoveFirst();
			$Prospecto=$db->Row();
			$codVehiculo= $Prospecto->codVehiculoProspecto;
			if (is_numeric($codVehiculo)){
				$consulta="update vehiculo_prospecto set codVehiculo=$veh, fechaAsignacion=SYSDATE() where codVehiculoProspecto=".$codVehiculo." and codVehiculo is null";
				if (! $db->Query($consulta)){ 
					$success = false;
					$this->mensaje="ERROR: no se guardo la asignacion<hr>$consulta";
				}
                
                $consulta="update vehiculo set codEstadoCom= (select codEstadoCom from estado_com where nombre like '%RESERVADO%'), fechaAsignacion=SYSDATE() where codEstadoCom= (select codEstadoCom from estado_com where nombre like '%DISPONIBLE%') and codVehiculo=$veh";
				if (! $db->Query($consulta)){ 
					$success = false;
					$this->mensaje="ERROR: no se guardo la asignacion<hr>$consulta";
				}
                
			}else{
				$success = false;
				$this->mensaje="ERROR: no se guardo la asignacion<hr>$consulta";
			}
		}
		
		
		if ($success) {
			$db->TransactionEnd();
		}else{
			$db->TransactionRollback();
		}
		if ($success){
			// Debo mandar correo solicitando asignacion
			//---------------------------------------------
			$codsolicitud=$db->GetLastInsertID();
			$iCorreo = new Correo();
			$iCorreo->AprobacionAsignacion($cod);
		}
		return $success;
	}
    //*****************************************************
	public function Desasignar($cod, $veh){
		$success=true;
		$db= new MySQL();
        $db->ThrowExceptions = true;
		if (! $db->TransactionBegin()) $db->Kill();
        if($cod!="0"){
                $consulta="update solicitud_desasignacion set codEstadoSolicitudDesasignacion=(select codEstadoSolicitudAsignacion from estado_solicitud_asignacion where descripcion='Aprobada' limit 1) where codSolicitudDesasignacion=$cod and codEstadoSolicitudDesasignacion=(select codEstadoSolicitudAsignacion from estado_solicitud_asignacion where descripcion='Pendiente' limit 1)";
            
                if (!$db->Query($consulta)){ 
                    $success = false;
                    $this->mensaje="ERROR: no se puede desasignar<hr>";
                }

            $consulta="
    select s.codVehiculoProspecto from solicitud_desasignacion as s 
    where s.codSolicitudDesasignacion='$cod'";
            if (! $db->Query($consulta)){ 
                $success = false;
                $this->mensaje="ERROR: no se encuentra prospecto<hr>$consulta";
            }else{
                $db->MoveFirst();
                $Prospecto=$db->Row();
                $codVehiculo= $Prospecto->codVehiculoProspecto;
                if (is_numeric($codVehiculo)){
                    $consulta="update vehiculo_prospecto set codVehiculo=NULL where codVehiculoProspecto=".$codVehiculo." and codVehiculo=$veh";
                    if (! $db->Query($consulta)){ 
                        $success = false;
                        $this->mensaje="ERROR: no se guardo la desasignacion<hr>$consulta";
                    }

                    $consulta="update vehiculo set codEstadoCom= (select codEstadoCom from estado_com where nombre like '%DISPONIBLE%') where codEstadoCom= (select codEstadoCom from estado_com where nombre like '%RESERVADO%') and codVehiculo=$veh";
                    if (! $db->Query($consulta)){ 
                        $success = false;
                        $this->mensaje="ERROR: no se guardo la desasignacion<hr>$consulta";
                    }


                }else{
                    $success = false;
                    $this->mensaje="ERROR: no se guardo la asignacion<hr>$consulta";
                }
            }


            if ($success) {
                $db->TransactionEnd();
            }else{
                $db->TransactionRollback();
            }
            if ($success){
                // Debo mandar correo solicitando asignacion
                //---------------------------------------------
                $codsolicitud=$db->GetLastInsertID();
                $iCorreo = new Correo();
                $iCorreo->AprobacionDesasignacion($cod);
            }
            return $success;
        }else{
            $consulta="update vehiculo_prospecto set codVehiculo=NULL where codVehiculo=$veh";
            if (! $db->Query($consulta)){ 
                $success = false;
                $this->mensaje="ERROR: no se guardo la desasignacion<hr>$consulta";
            }

            $consulta="update vehiculo set codEstadoCom= (select codEstadoCom from estado_com where nombre like '%DISPONIBLE%') where codEstadoCom= (select codEstadoCom from estado_com where nombre like '%RESERVADO%') and codVehiculo=$veh";
            if (! $db->Query($consulta)){ 
                $success = false;
                $this->mensaje="ERROR: no se guardo la desasignacion<hr>$consulta";
            }
            if ($success) {
                $db->TransactionEnd();
            }else{
                $db->TransactionRollback();
            }
        
        }
	}
	//*****************************************************
	public function ListarVehiculosDisponibles($cod){
		$db = new MySQL();
		//obtener codigo de vehiculo
		$consulta="select codVehiculoProspecto from solicitud_asignacion where codSolicitudAsignacion=$cod";
		$db->Query($consulta);
		$db->MoveFirst();
		$dato=$db->Row();
		$codvehiculo=$dato->codVehiculoProspecto;
		$consulta="
SELECT ma.descripcion as marca, m.nombre as modelo, t.nombre as tipo, s.nombre as subtipo,  
v.anMod, v.chasis, col.nombre as color, coli.nombre as colorInt, u.nombre as ubicacion, d.nombre as departamento, v.codVehiculo, op.nombre as op, co.nombre as com, date_format(v.fechaLlegada,'%d-%m-%Y') as fechaLlegada, v.partida,
case when v.warrant='1' then 'Si' else 'No' end as warrant
FROM vehiculo  as v
inner join vehiculo_prospecto as vp on vp.codModelo=v.codModelo and vp.codTipo=v.codTipo 
and vp.codSubTipo=v.codSubTipo  and vp.codColor=v.codColor 
and vp.codColorInterior=v.codColorInt  and v.anMod=vp.anioComercial
inner join modelo as m on m.codModelo=v.codModelo
inner join marca as ma on ma.codMarca=m.codMarca
inner join tipo as t on t.codTipo=v.codTipo
inner join subtipo as s on s.codSubTipo=v.codSubTipo
inner join color as col on col.codColor=v.codColor
inner join color_int as coli on coli.codColorInt=v.codColorInt
inner join ubicacion as u on u.codUbicacion=v.codUbicacion
inner join departamento as d on d.codDepto=u.codDepto
inner join estado_op as op on op.codEstadoOp=v.codEstadoOp
inner join estado_com as co on co.codEstadoCom=v.codEstadoCom
where v.codEstadoCom=(SELECT codEstadoCom FROM estado_com where nombre like '%DISPONIBLE%' limit 1)
and vp.codVehiculoProspecto=$codvehiculo;
";		
		
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
    public function ListarVehiculosDisponiblesSimilares($cod){
		$db = new MySQL();
		//obtener codigo de vehiculo
		$consulta="select codVehiculoProspecto from solicitud_asignacion where codSolicitudAsignacion=$cod";
		$db->Query($consulta);
		$db->MoveFirst();
		$dato=$db->Row();
		$codvehiculo=$dato->codVehiculoProspecto;
		$consulta="
SELECT ma.descripcion as marca, m.nombre as modelo, t.nombre as tipo, s.nombre as subtipo,  
v.anMod, v.chasis, col.nombre as color, coli.nombre as colorInt, u.nombre as ubicacion, d.nombre as departamento, v.codVehiculo, op.nombre as op, co.nombre as com, date_format(v.fechaLlegada,'%d-%m-%Y') as fechaLlegada, v.partida
FROM vehiculo  as v
inner join vehiculo_prospecto as vp on vp.codModelo=v.codModelo and vp.codTipo=v.codTipo 
and vp.codSubTipo=v.codSubTipo  and v.anMod=vp.anioComercial
inner join modelo as m on m.codModelo=v.codModelo
inner join marca as ma on ma.codMarca=m.codMarca
inner join tipo as t on t.codTipo=v.codTipo
inner join subtipo as s on s.codSubTipo=v.codSubTipo
inner join color as col on col.codColor=v.codColor
inner join color_int as coli on coli.codColorInt=v.codColorInt
inner join ubicacion as u on u.codUbicacion=v.codUbicacion
inner join departamento as d on d.codDepto=u.codDepto
inner join estado_op as op on op.codEstadoOp=v.codEstadoOp
inner join estado_com as co on co.codEstadoCom=v.codEstadoCom
where v.codEstadoCom=(SELECT codEstadoCom FROM estado_com where nombre like '%DISPONIBLE%' limit 1)
and vp.codVehiculoProspecto=$codvehiculo";		
		
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
    public function ListarVehiculoSolicitado($cod){
		$db = new MySQL();
		//obtener codigo de vehiculo
		$consulta="select codVehiculoProspecto from solicitud_asignacion where codSolicitudAsignacion=$cod";
		$db->Query($consulta);
		$db->MoveFirst();
		$dato=$db->Row();
		$codvehiculo=$dato->codVehiculoProspecto;
		$consulta="
SELECT ma.descripcion as marca, m.nombre as modelo, t.nombre as tipo, s.nombre as subtipo,  
vp.anioComercial, col.nombre as color, coli.nombre as colorInt
from vehiculo_prospecto as vp 
left join modelo as m on m.codModelo=vp.codModelo
left join marca as ma on ma.codMarca=m.codMarca
left join tipo as t on t.codTipo=vp.codTipo
left join subtipo as s on s.codSubTipo=vp.codSubTipo
left join color as col on col.codColor=vp.codColor
left join color_int as coli on coli.codColorInt=vp.codColorInterior
where vp.codVehiculoProspecto=$codvehiculo
";		
		
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
	public function ListarVehiculoAsignado($cod){
		$db = new MySQL();
		//obtener codigo de vehiculo
		$consulta="select codVehiculoProspecto from solicitud_desasignacion where codSolicitudDesasignacion=$cod";
		$db->Query($consulta);
		$db->MoveFirst();
		$dato=$db->Row();
		$codvehiculo=$dato->codVehiculoProspecto;
		$consulta="
SELECT ma.descripcion as marca, m.nombre as modelo, t.nombre as tipo, s.nombre as subtipo,  
v.anMod, v.chasis, col.nombre as color, coli.nombre as colorInt, u.nombre as ubicacion, d.nombre as departamento, v.codVehiculo, op.nombre as op, co.nombre as com
FROM vehiculo  as v
inner join modelo as m on m.codModelo=v.codModelo
inner join marca as ma on ma.codMarca=m.codMarca
inner join tipo as t on t.codTipo=v.codTipo
inner join subtipo as s on s.codSubTipo=v.codSubTipo
inner join color as col on col.codColor=v.codColor
inner join color_int as coli on coli.codColorInt=v.codColorInt
inner join ubicacion as u on u.codUbicacion=v.codUbicacion
inner join departamento as d on d.codDepto=u.codDepto
inner join estado_op as op on op.codEstadoOp=v.codEstadoOp
inner join estado_com as co on co.codEstadoCom=v.codEstadoCom
where v.codEstadoCom=(SELECT codEstadoCom FROM estado_com where nombre like '%RESERVADO%' limit 1)
and v.codVehiculo= (select codVehiculo from vehiculo_prospecto where codVehiculoProspecto=$codvehiculo);
";		
		
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
	public function ValidarMarca($nombre){
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM marca where LTRIM(RTRIM(descripcion))=LTRIM(RTRIM('".$nombre."')) limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->codMarca;
		}
        return "0";
    }
	//*****************************************************
	public function ValidarModelo($nombre){
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM modelo where LTRIM(RTRIM(nombre))=LTRIM(RTRIM('".$nombre."')) limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->codModelo;
		}
        return "0";
    }
    //*****************************************************
	public function ValidarTipo($nombre, $codmodelo){
        if ($nombre=="") $nombre="POR DEFINIR";
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
        
		if (! $db->Query("SELECT * FROM tipo where LTRIM(RTRIM(nombre))=LTRIM(RTRIM('".$nombre."')) and codModelo='$codmodelo' limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->codTipo;
		}
        return "0";
    }
    //*****************************************************
	public function ValidarInterior($nombre, $codmodelo){
        if ($nombre=="") $nombre="POR DEFINIR";
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
        
		if (! $db->Query("SELECT * FROM interior where LTRIM(RTRIM(nombre))=LTRIM(RTRIM('".$nombre."')) and codModelo='$codmodelo' limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->codInterior;
		}
        return "0";
    }
    //*****************************************************
	public function ValidarSubtipo($nombre, $codTipo){
        if ($nombre=="") $nombre="POR DEFINIR";
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM subtipo where LTRIM(RTRIM(nombre))=LTRIM(RTRIM('".$nombre."')) and codTipo='$codTipo' limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->codSubTipo;
		}
        return "0";
    }
    //*****************************************************
	public function ValidarColor($nombre, $codModelo){
        if ($nombre=="") $nombre="POR DEFINIR";
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM color where LTRIM(RTRIM(nombre))=LTRIM(RTRIM('".$nombre."')) and codModelo='$codModelo' limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->codColor;
		}
        return "0";
    }
    //*****************************************************
	public function ValidarColorInt($nombre, $codModelo){
        if ($nombre=="") $nombre="POR DEFINIR";
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM color_int where LTRIM(RTRIM(nombre))=LTRIM(RTRIM('".$nombre."')) and codModelo='$codModelo' limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->codColorInt;
		}
        return "0";
    }
	//*****************************************************
    public function ValidarUbicacion($nombre){
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM ubicacion where LTRIM(RTRIM(nombre))=LTRIM(RTRIM('".$nombre."')) limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->codUbicacion;
		}
        return "0";
    }
    //*****************************************************
    public function ValidarEstadoCom($nombre){
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM estado_com where LTRIM(RTRIM(nombre))=LTRIM(RTRIM('".$nombre."')) limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->codEstadoCom;
		}
        return "0";
    }
    //*****************************************************
    public function ValidarEstadoOp($nombre){
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM estado_op where LTRIM(RTRIM(nombre))=LTRIM(RTRIM('".$nombre."')) limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->codEstadoOp;
		}
        return "0";
    }
}

?>