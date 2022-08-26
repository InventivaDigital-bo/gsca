<?php
include_once("mysql.class.php");

class TalonarioFact{
	//------------------------------------------------------------------------------------------------
	// Registrar un nuevo talonario
	function NuevoTalonario($empresa,$oficina,$autorizacion,$dosificacion,$limite,$usuario){
		$consulta=" insert into talonario_facturacion (
					`codOficina`,`fecRegistro`,`codUsuario`,`codEmpresa`,`numAutorizacion`,
					`llaveDosificacion`,`fecLimiteEmision`,`numerador`,`fecUltimaFactura`,`baja` )
					values ('$oficina', SYSDATE(), '$usuario', '$empresa', '$autorizacion', '$dosificacion', '$limite',1, NULL,'0')";
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		if (! $db->TransactionBegin()) $db->Kill();
		$success = true;
		$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			// Commit the transaction and save these records to the database
			$codincidente= $db->GetLastInsertID();
			if (! $db->TransactionEnd()) {
				$db->Kill();
			}		
			return true;		
		} else { 	
			// Rollback our transaction
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return false;
	}
	//------------------------------------------------------------------------------------------------
	// Registrar un nuevo talonario
	function ModificarTalonario($codtalonario, $empresa,$oficina,$autorizacion,$dosificacion,$limite,$usuario, $baja, $numerador){
		$consulta=" update talonario_facturacion set
					`codOficina`='$oficina',`fecRegistro`=SYSDATE(),`codUsuario`='$usuario',`codEmpresa`='$empresa',`numAutorizacion`='$autorizacion',
					`llaveDosificacion`='$dosificacion',`fecLimiteEmision`='$limite',`baja`='$baja'  where codTalonario=$codtalonario";
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		if (! $db->TransactionBegin()) $db->Kill();
		$success = true;
		$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			// Commit the transaction and save these records to the database
			$codincidente= $db->GetLastInsertID();
			if (! $db->TransactionEnd()) {
				$db->Kill();
			}		
			return true;		
		} else { 	
			// Rollback our transaction
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return false;
	}
	//------------------------------------------------------------------------------------------------
	// incrementa el autoumerico de facturas
	function IncrementarNumerador($codtalonario){
		$consulta=" update talonario_facturacion set numerador=numerador+1 and fecUltimaFactura=SYSDATE() where codTalonario=$codtalonario";
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		if (! $db->TransactionBegin()) $db->Kill();
		$success = true;
		$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			// Commit the transaction and save these records to the database
			$codincidente= $db->GetLastInsertID();
			if (! $db->TransactionEnd()) {
				$db->Kill();
			}		
			return true;		
		} else { 	
			// Rollback our transaction
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return false;
	}
	
	//-----------------------------------------------------------------------------------------------------------------------------------------
	public function ListarTalonarios(){
	
		$consulta="
		SELECT codTalonario, o.descripcion AS Oficina, fecRegistro, u.usuario, e.descripcion AS Empresa, numAutorizacion, llaveDosificacion, DATE_FORMAT(  `fecLimiteEmision` ,  '%Y-%m-%d' ) as  fecLimiteEmision, numerador, fecUltimaFactura, t.baja as vbaja,  IF(t.baja = '0', 'Activo', 'Baja') as baja
		FROM talonario_facturacion AS t
		LEFT JOIN oficina AS o ON o.codoficina = t.codoficina
		LEFT JOIN empresa AS e ON e.codempresa = t.codempresa
		LEFT JOIN usuario AS u ON u.codusuario = t.codusuario
		order by codTalonario desc
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
	//--------------------------------------------------------------------------------------------------------------------------------------
	public function MostrarTalonario($codTalonario){
	
		$consulta="
		SELECT codTalonario, o.descripcion AS Oficina, t.codOficina, fecRegistro, u.usuario, t.codUsuario,  e.descripcion AS Empresa, t.codEmpresa, numAutorizacion, llaveDosificacion, DATE_FORMAT(  `fecLimiteEmision` ,  '%Y-%m-%d' ) as fecLimiteEmision, numerador, fecUltimaFactura, IF(t.baja= '0', 'Activo', 'Baja') as baja, t.baja as vbaja  
		FROM talonario_facturacion AS t
		LEFT JOIN oficina AS o ON o.codoficina = t.codoficina
		LEFT JOIN empresa AS e ON e.codempresa = t.codempresa
		LEFT JOIN usuario AS u ON u.codusuario = t.codusuario
		where t.codTalonario=$codTalonario
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
				$row = $db->Row();
				return $row;
			}
		}
	}
	//--------------------------------------------------------------------------------------------------------------------------------------
	public function BuscarTalonario($codoficina){
		$consulta="SELECT codTalonario, DATE_FORMAT(  `fecLimiteEmision` ,  '%Y-%m-%d' ) as fecLimiteEmision, DATEDIFF(fecLimiteEmision, sysdate()) as vigencia FROM `talonario_facturacion` WHERE `fecLimiteEmision`>sysdate() and baja='0' and codoficina=$codoficina";
		$db = new MySQL();
		if ($db->Error()){ 
			$db->Kill();
			return "vacio";
		}else{
			if (! $db->Query($consulta)) {
				$db->Kill();
				return "vacio";
			}else{
				if ($db->RowCount()==0) return "vacio";
					
				$db->MoveFirst();
				$row = $db->Row();
				return $row;
			}
		}
		
	}
}
?>