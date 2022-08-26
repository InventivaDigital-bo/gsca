<?php
include_once("../clases/mysql.class.php");
require_once("../clases/mail.php");

class incidente{

	private $codigo="0";
	
	//---------------------------------------------------------------------------------------------------------
	// Crear nuevo incidente
	
	function CrearIncidente($vcodusuario, $vtipoincidente, $vdescripcion){
		$consulta="insert into incidente( codUsuario, fecApertura, codTipoIncidente, descripcion, codEstado, cerrado ) values( '$vcodusuario', NOW(), '$vtipoincidente', '$vdescripcion', '1', '0')";	
		
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		
		if (! $db->TransactionBegin()) $db->Kill();
			
			// We'll create a flag to check for any errors
		$success = true;
			
		$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			//echo "<br>entra 2";
			// Commit the transaction and save these records to the database
			$codincidente= $db->GetLastInsertID();
			$this->codigo=$codincidente;
			
			if (! $db->TransactionEnd()) {
				$db->Kill();
				//echo "<br>entra3";							
			}		
			$iMail= new Correo;
			$iMail->NuevoIncidente($codincidente);
			return true;		
		} else { 	
			//echo "<br>error 2";
			// Rollback our transaction
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
			
		return true;
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Obtener codigo insertado
	
	function ObtenerCodigoIncidente(){
		return $this->codigo;
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Listar incidentes usuario
	
	function ListarIncidentes($codusuario, $vEstado, $vSistema, $vIncidente, $vDescripcion, $vCodIndicente){
		$db = new MySQL();
		$condicion = " and ( ";
		$logico=false;
		
		if ($vEstado!="0"){
			$condicion=$condicion." ic.codEstado='".$vEstado."'";
			$logico=true;
		}
		
		if (($vSistema!="0")&&($vSistema!="")){
			if ($logico==true) {$condicion=$condicion." and ";}
			$condicion=$condicion." ti.codSistema='".$vSistema."'";
			$logico=true;
		}
		
		if (($vIncidente!="0")&&($vIncidente!="")){
			if ($logico==true) {$condicion=$condicion." and ";}
			$condicion=$condicion." ic.codTipoIncidente='".$vIncidente."'";
			$logico=true;
		}
		
		if ($vDescripcion!=""){
			if ($logico==true) {$condicion=$condicion." and ";}
			$condicion=$condicion." ic.descripcion like '%".$vDescripcion."%'";
			$logico=true;
		}
		
		if ($vCodIndicente!=""){
			if ($logico==true) {$condicion=$condicion." and ";}
			$condicion=$condicion." ic.codIncidente like '%".$vCodIndicente."%'";
			$logico=true;
		}
		
		if ($logico==false) {$condicion=$condicion." ic.codEstado<>2 ";}
		$condicion=$condicion." ) ";
		
		if ($db->Error()) $db->Kill();
		$consulta="SELECT ic.codIncidente, date_format(fecApertura,'%d-%m-%Y')fecApertura ,ti.descripcion as TipoIncidente, `fecAsignacion`, `fecCompromiso`, CONCAT(pe.paterno,' ',pe.nombre) as Soporte, ic.`descripcion`, es.descripcion as Estado, case when `cerrado`='0' then 'No' else 'Si' end  as Cerrado , sis.Descripcion as Sistema
FROM `incidente`  as ic
left join tipoincidente as ti on ti.codTipoIncidente=ic.codTipoIncidente
left join soporte as so on so.codSoporte=ic.codSoporte
left join persona as pe on pe.codPersona=so.codPersona
left join estado as es on es.codEstado=ic.codEstado 
left join sistema as sis on sis.codSistema=ti.codSistema
where ic.codUsuario='$codusuario' $condicion ";

//echo $consulta."<br>";


		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		
		
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			$vartemp='"ficha.php?cod='.$row->codIncidente.'"';
			//echo "<option value='".$row->codSistema."'>".$row->descripcion."</option>";						
			echo "<tr>";
			echo "<td>".$row->codIncidente."</td>";
			echo "<td>".$row->fecApertura."</td>";
			echo "<td>".$row->TipoIncidente."</td>";
			echo "<td>".$row->Sistema."</td>";
			
			$color="";			
			if($row->Estado=="ABIERTO")
			$color='style="background-color:#456b0d; color:#fff"';
			if($row->Estado=="EN PROCESO")
			$color='style="background-color:#fee304; color:#fff"';
			if($row->Estado=="CERRADO")
			$color='style="background-color:#7d8278; color:#fff"';
			if($row->Estado=="EN ESPERA DE APROBACION")
			$color='style="background-color:#ff5105; color:#fff"';
			
			echo "<td $color>".$row->Estado."</td>";
			echo "<td>".$row->Cerrado."</td>";
			echo "<td>".$row->descripcion."</td>";
			echo "<td style='text-align:right; padding-right:10px'><input class='btn btn-primary ui-button ui-widget ui-state-default ui-corner-all' id='button1' name='button1' type='button' value='Abrir' role='button' aria-disabled='false' onclick='navegar($vartemp);'></td>";
			echo "</tr>";
		}
		
		
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Listar incidentes usuario
	
	function ListarIncidentesAdminP( $vEstado, $vSistema, $vIncidente, $vDescripcion, $tipoUsuario, $codUsuario, $codIncidente, $Usuario){
		$db = new MySQL();
		$condicion = " and ( ";
		$logico=false;
		
		if (($vEstado!="0")&&($vEstado!="")){
			$condicion=$condicion." ic.codEstado='".$vEstado."'";
			$logico=true;
		}
		
		if (($vSistema!="0")&&($vSistema!="")){
			if ($logico==true) {$condicion=$condicion." and ";}
			$condicion=$condicion." ti.codSistema='".$vSistema."'";
			$logico=true;
		}
		
		if (($vIncidente!="0")&&($vIncidente!="")){
			if ($logico==true) {$condicion=$condicion." and ";}
			$condicion=$condicion." ic.codTipoIncidente='".$vIncidente."'";
			$logico=true;
		}
		
		if ($vDescripcion!=""){
			if ($logico==true) {$condicion=$condicion." and ";}
			$condicion=$condicion." ic.descripcion like '%".$vDescripcion."%'";
			$logico=true;
		}
		
		if ($codIncidente!=""){
			if ($logico==true) {$condicion=$condicion." and ";}
			$condicion=$condicion." ic.codIncidente = '".$codIncidente."'";
			$logico=true;
		}
		
		if ($Usuario!=""){
			if ($logico==true) {$condicion=$condicion." and ";}
			$condicion=$condicion."CONCAT(nus.nombre,' ',nus.paterno) like '%".$Usuario."%'";
			$logico=true;
		}
		
		if ($logico==false) {$condicion=$condicion." ic.codEstado<>2 ";}
		$condicion=$condicion." ) ";
		
		$controlusuario="";
		if ($tipoUsuario=="soporte"){
			$controlusuario=" and us2.codUsuario=".$codUsuario;
		}
		
		if ($db->Error()) $db->Kill();
		$consulta="SELECT ic.codIncidente, date_format(fecApertura,'%d-%m-%Y')fecApertura ,ti.descripcion as TipoIncidente, `fecAsignacion`, `fecCompromiso`, CONCAT(pe.paterno,' ',pe.nombre) as Soporte, ic.`descripcion`, es.descripcion as Estado, case when `cerrado`='0' then 'No' else 'Si' end  as Cerrado , sis.Descripcion as Sistema, CONCAT(nus.nombre,' ',nus.paterno) as Usuario
FROM `incidente`  as ic
left join tipoincidente as ti on ti.codTipoIncidente=ic.codTipoIncidente
left join soporte as so on so.codSoporte=ic.codSoporte
left join persona as pe on pe.codPersona=so.codPersona
left join usuario as us on us.codUsuario=ic.codUsuario
left join persona as nus on nus.codPersona=us.codPersona
left join estado as es on es.codEstado=ic.codEstado 
left join sistema as sis on sis.codSistema=ti.codSistema
left join usuario as us2 on us2.codPersona=so.codPersona
where 1=1 $condicion ".$controlusuario." order by es.descripcion";

//echo "<hr>".$consulta."<hr>";

		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		
		
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			//echo "<option value='".$row->codSistema."'>".$row->descripcion."</option>";						
			$vartemp='"ficha.php?cod='.$row->codIncidente.'"';
			
			echo "<tr>";
			echo "<td>".$row->codIncidente."</td>";
			echo "<td>".$row->Usuario."</td>";
			echo "<td>".$row->fecApertura."</td>";
			echo "<td>".$row->TipoIncidente."</td>";
			echo "<td>".$row->Sistema."</td>";
			$color="";			
			if($row->Estado=="ABIERTO")
			$color='style="background-color:#456b0d; color:#fff"';
			if($row->Estado=="EN PROCESO")
			$color='style="background-color:#fee304; color:#fff"';
			if($row->Estado=="CERRADO")
			$color='style="background-color:#7d8278; color:#fff"';
			if($row->Estado=="EN ESPERA DE APROBACION")
			$color='style="background-color:#ff5105; color:#fff"';
			
			echo "<td $color>".$row->Estado."</td>";
			echo "<td>".$row->Cerrado."</td>";
			echo "<td>".$row->descripcion."</td>";
			echo "<td style='text-align:right; padding-right:10px'><input class='btn btn-primary ui-button ui-widget ui-state-default ui-corner-all' id='button1' name='button1' type='button' value='Abrir' role='button' aria-disabled='false' onclick='navegar($vartemp);'></td>";
			echo "</tr>";
		}
		
		
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Obtener codigo insertado
	
	function ListarIncidentesAdmin(){
		$db = new MySQL();		
		
		if ($db->Error()) $db->Kill();
		$consulta="SELECT ic.codIncidente, date_format(fecApertura,'%d-%m-%Y')fecApertura ,ti.descripcion as TipoIncidente, `fecAsignacion`, `fecCompromiso`, CONCAT(pe.paterno,' ',pe.nombre) as Soporte, ic.`descripcion`, es.descripcion as Estado, case when `cerrado`='0' then 'No' else 'Si' end  as Cerrado , sis.Descripcion as Sistema, CONCAT(nus.nombre,' ',nus.paterno) as Usuario
FROM `incidente`  as ic
left join tipoincidente as ti on ti.codTipoIncidente=ic.codTipoIncidente
left join soporte as so on so.codSoporte=ic.codSoporte
left join persona as pe on pe.codPersona=so.codPersona
left join usuario as us on us.codUsuario=ic.codUsuario
left join persona as nus on nus.codPersona=us.codPersona
left join estado as es on es.codEstado=ic.codEstado 
left join sistema as sis on sis.codSistema=ti.codSistema
where ic.codEstado=1  ";

//echo $consulta."<br>";


		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		
		
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			//echo "<option value='".$row->codSistema."'>".$row->descripcion."</option>";
			$varTemp='"'.$row->codIncidente.'"';						
			echo "<tr>";
			echo "<td>".$row->codIncidente."</td>";
			echo "<td>".$row->Usuario."</td>";
			echo "<td>".$row->fecApertura."</td>";
			echo "<td>".$row->TipoIncidente."</td>";
			echo "<td>".$row->Sistema."</td>";
			echo "<td>".$row->Estado."</td>";
			echo "<td>".$row->Cerrado."</td>";
			echo "<td>".$row->descripcion."</td>";
			echo "<td style='text-align:right; padding-right:10px'><input class='btn btn-primary ui-button ui-widget ui-state-default ui-corner-all' id='button1' name='button1' type='submit' value='Asignar' role='button' onclick='Asignar(".$varTemp.")' aria-disabled='false'></td>";
			echo "</tr>";
		}
		
		
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Obtener codigo insertado
	
	function AgregarArchivo($codIncidente, $nombre){
		$consulta="insert into upload(codIncidente, fecha, nombre) values( '$codIncidente', NOW(), '$nombre')";	
		
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		
		if (! $db->TransactionBegin()) $db->Kill();
			$success = true;
			$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			if (! $db->TransactionEnd()) {
				$db->Kill();
			}		
			return true;		
		} else { 	
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return true;
	}
	
function DetalleIncidentes($codIncidente){
		$db = new MySQL();
		
		if ($db->Error()) $db->Kill();
		$consulta="SELECT inc.codIncidente, inc.codUsuario, inc.fecApertura, inc.codTipoIncidente, inc.fecAsignacion, inc.fecCompromiso, inc.codSoporte, inc.descripcion, inc.codEstado, inc.cerrado, inc.fecCerrado, CONCAT(per.nombre,' ',per.paterno) usuario, per.codPersona, ofi.descripcion as oficina, tip.descripcion as tipoIncidente, sis.descripcion as sistema, sis.codSistema, CONCAT(per2.nombre,' ', per2.paterno) soporte, est.descripcion as estado 
FROM incidente as inc
left join usuario as usr on usr.codUsuario=inc.codUsuario
left join persona as per on per.codPersona=usr.codPersona
left join oficina as ofi on ofi.codOficina=usr.codOficina
left join tipoincidente as tip on tip.codTipoIncidente=inc.codTipoIncidente
left join sistema as sis on sis.codSistema=tip.codSistema
left join soporte as sop on sop.codSoporte=inc.codSoporte
left join persona as per2 on per2.codPersona=sop.codPersona
left join estado as est on est.codEstado=inc.codEstado
where inc.codIncidente=$codIncidente";

//echo $consulta."<br>";


		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();		
		$row="";
		if (! $db->EndOfSeek()) {
			$row = $db->Row();
			
		}
		return $row;		
	}		  

function SolucionIncidentes($codIncidente){
		$db = new MySQL();
		
		if ($db->Error()) $db->Kill();
		$consulta="
		SELECT sol.*, tip.descripcion as solucion, CONCAT(per.nombre, ' ', per.paterno) as  usuario
		from solucion as sol
		left join tiposolucion as tip on tip.codTipoSolucion = sol.codTipoSolucion
		left join usuario as usr on usr.codUsuario=sol.codUsuario
		left join persona as per on per.codPersona=usr.codPersona
		where sol.codIncidente=".$codIncidente." order by sol.codSolucion desc";

//echo $consulta."<br>";


		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();		
		$row="";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			//echo "<option value='".$row->codSistema."'>".$row->descripcion."</option>";						
			echo "<tr>";
			echo "<td>".$row->fecSolucion."</td>";
			echo "<td>".$row->solucion."</td>";
			echo "<td>".$row->descripcion."</td>";
			echo "<td>".$row->usuario."</td>";
			echo "</tr>";
		}
		
		return $row;		
	}		  

//--------------------------------------------------------------------------------------------------------------

function AgregarSolucion($codIncidente, $solucion, $tipo, $usuario){
		$consulta="insert into solucion(codIncidente, codTipoSolucion, descripcion, codUsuario, fecSolucion) values( '$codIncidente', $tipo, '$solucion', $usuario,  NOW())";	
		
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		
		if (! $db->TransactionBegin()) $db->Kill();
			$success = true;
			$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			if (! $db->TransactionEnd()) {
				$db->Kill();
			}		
			$varTemp=$this->EnEspera($codIncidente);
			$iMail= new Correo;
			$iMail->Solucionado($codIncidente);
			return $varTemp;		
		} else { 	
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return true;
	}
//--------------------------------------------------------------------------------------------------------------

function Asignar($codIncidente, $codSoporte){
		$consulta="update incidente set codSoporte=$codSoporte, codEstado=3, fecAsignacion=NOW() where codIncidente=$codIncidente";	
		
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		
		if (! $db->TransactionBegin()) $db->Kill();
			$success = true;
			$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			if (! $db->TransactionEnd()) {
				$db->Kill();
			}	
			$iMail= new Correo;
			$iMail->AsignacionIncidente($codIncidente);	
			return true;		
		} else { 	
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return true;
	}
//--------------------------------------------------------------------------------------------------------------
	
function EnEspera($codIncidente){
		$consulta="update incidente set codEstado=4 where codIncidente=$codIncidente";	
		
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		
		if (! $db->TransactionBegin()) $db->Kill();
			$success = true;
			$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			if (! $db->TransactionEnd()) {
				$db->Kill();
			}		
			return true;		
		} else { 	
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return true;
	}	
//--------------------------------------------------------------------------------------------------------------

function CerrarIncidente($codIncidente){
		$consulta="update incidente set fecCerrado=NOW() , cerrado='1', codEstado=2 where codIncidente=$codIncidente";	
		//echo $consulta;
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		
		if (! $db->TransactionBegin()) $db->Kill();
			$success = true;
			$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			if (! $db->TransactionEnd()) {
				$db->Kill();
			}		
			$iMail= new Correo;
			$iMail->Cierre($codIncidente);
			return true;		
		} else { 	
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return true;
	}	
//**************************************************************************************************************
public function ListarImagenes($codIncidente){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta="SELECT * FROM upload where codIncidente=".$codIncidente;
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			$file=$row->nombre;
			$ext=substr($file, -3);    
			$imagen='"../usuario/upload/'.$row->nombre.'"';
			if (($ext!="pdf")&&($ext!="PDF")){
				echo "<img  src='../usuario/upload/".$row->nombre."'  style='height:50px; border-color:#cecece; border-width:1px; border-style:solid; padding:5px; cursor:pointer' onclick='MostrarImagen(".$imagen.")'/>";	
			}else{
				echo "<img  src='../images/pdf.png'  style='height:50px; border-color:#cecece; border-width:1px; border-style:solid; padding:5px; cursor:pointer' onclick='MostrarPDF(".$imagen.")'/>";	
			}
		}
				
	}
	
//--------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------

function AsignarFecha($codIncidente, $fecha){
		$consulta="update incidente set fecCompromiso='".$fecha."' where codIncidente=$codIncidente";	
		//echo $consulta."br";
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		
		if (! $db->TransactionBegin()) $db->Kill();
			$success = true;
			$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			if (! $db->TransactionEnd()) {
				$db->Kill();
			}		
			return true;		
		} else { 	
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return true;
	}
//--------------------------------------------------------------------------------------------------------------
function CambiarTipo($codIncidente, $tipo){
		$consulta="update incidente set codTipoIncidente=".$tipo." where codIncidente=$codIncidente";	
		
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		
		if (! $db->TransactionBegin()) $db->Kill();
			$success = true;
			$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			if (! $db->TransactionEnd()) {
				$db->Kill();
			}		
			return true;		
		} else { 	
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return true;
	}	

}
?>