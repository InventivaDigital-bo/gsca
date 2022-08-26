<?php 
include_once ("mysql.class.php");
require_once "../clases/mail.php";

class Seguridad{
	//-----------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------------------------------------------------------
	public function ListarUsuarios($busqueda="", $todos=""){
	    $condicion="";
        if ($busqueda!=""){
            $condicion=" where usuario like '%$busqueda%' or CONCAT(per.nombre,' ',per.apePat,' ',per.apeMat) like '%$busqueda%' or ofi.descripcion like '%$busqueda%' or usuario like '%$busqueda%' order by per.apePat ";
        }else{
            if ($todos!="todos"){
                $condicion =" order by per.apePat limit 10";
            }else{
                $condicion =" order by usr.codusuario";
            }
        }
		$consulta="
		select usr.codusuario, usuario, tipo.descripcion as tipousuario, ofi.descripcion as oficina, 
		CONCAT(per.nombre,' ',per.apePat,' ',per.apeMat) as nombre, 
        IF(usr.baja = '0', 'Activo', 'Baja') as baja, per.correo 
		from usuario as usr
		left join oficina as ofi on ofi.codOficina=usr.codOficina
		left join persona as per on per.codPersona=usr.codPersona
		left join tipousuario as tipo on tipo.codTipoUsuario=usr.codTipoUsuario
		$condicion
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
	public function ListarPersona($codusuario) {
		$consulta="
			select per.codPersona, dui, extdui, nombre, apePat, apeMat, pnatural, IF(pnatural = 'SI', 'Natural', 'Juridica') as tipo,  per.direccion, per.telefono, p.codPais, p.descripcion as pais, per.baja, usr.usuario, per.correo, usr.codOficina, ofi.descripcion as oficina, usr.codTipoUsuario
			from usuario as usr
			left join persona as per on per.codPersona=usr.codPersona
			left join pais as p on p.codPais=per.codPais
            left join oficina as ofi on ofi.codOficina=usr.codOficina
			where codUsuario=".$codusuario."
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
	
	//-----------------------------------------------------------------------------------------------------------------------------------------
	public function ListaUsuarios($codusuario){
	
		$consulta="
		select codusuario, usuario, tipo.descripcion as tipousuario, ofi.descripcion as oficina, 
		IF(usr.baja = '0', 'Activo', 'Baja') as baja 
		from usuario as usr
		left join oficina as ofi on ofi.codOficina=usr.codOficina
		left join persona as per on per.codPersona=usr.codPersona
		left join tipousuario as tipo on tipo.codTipoUsuario=usr.codTipoUsuario
		where per.codPersona in (select codPersona from usuario where codUsuario=".$codusuario.")
		order by per.apePat
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
	//-----------------------------------------------------------------------------------------------------------------------------------------
	public function ListaRoles($codusuario){
	
		$consulta="
		SELECT usuario, rol, IF( usr.baja =  '0',  'Activo',  'Baja' ) AS baja, rol.codrol
		FROM usuario AS usr
		LEFT JOIN usuario_rol AS usrrol ON usrrol.codusuario = usr.codusuario
		LEFT JOIN rol ON rol.codRol = usrrol.codRol
		WHERE usr.codPersona
		IN (
			SELECT codPersona FROM usuario WHERE codUsuario =".$codusuario."
		)
		AND rol.baja !=  '1'
		ORDER BY rol LIMIT 0 , 30
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
	//------------------------------------
	public function ListaPermisos($codusuario){
	
		$consulta="
		SELECT permiso.codPermiso, permiso, IF( rp.codPermiso!='','no','yes') as checked
		FROM `permiso` 
		left join rol_permiso as rp on rp.codPermiso=permiso.codPermiso and codrol=".$codusuario."
		where permiso.baja='0' 
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
	//------------------------------------
	public function RegistrarRol($codusuario, $codrol){
		$consulta="insert into usuario_rol(codUsuario, codRol) values ($codusuario, $codrol)";
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;		
		if (! $db->TransactionBegin()) $db->Kill();
			
			// We'll create a flag to check for any errors
		$success = true;
		$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
		if ($success) {
			// Commit the transaction and save these records to the database
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
		return true;
	}
	//------------------------------------
	public function CrearPersona($dui, $extdui, $nombre, $paterno, $materno, $tipo, $direccion, $telefono, $correo, $pais,  $usuario, $codoficina, &$seguimiento){
		$seguimiento.="";
		$consulta="SELECT * from persona where dui='$dui' and extdui='$extdui' ";
		$db = new MySQL();
		if ($db->Error()) {
			$db->Kill();
			return "no conecta";
		}
		$db->ThrowExceptions = false;
		try {
		/*///////////////////////	INICIO TRY ///////////////////////////////////////////////////////////////////////////////////////////*/		
			if (! $db->TransactionBegin()){ 
				$db->Kill();
				return "no transaccion";
			}
			//verifico si existe carnet y extension, si da error de consulta		
				if (! $db->Query($consulta)) {
					$db->Kill();
					$seguimiento="No se pudo ejecutar la consuta.";
					return "ERROR";
				}else{
					 // verifico que no exte registrado alguien con el mismo carnet y extension
					 if ($db->RowCount()>0){
						 //$seguimiento.="Ya existe mismo carnet<br>";
						 // si esta registrado verifico que sea la misma persona ------------------------------------------------------------------------------------------------------
						 $consulta="SELECT codPersona from persona where dui='$dui' and extdui='$extdui' and nombre='$nombre' and apePat='$paterno' and apeMat='$materno' and pnatural='$tipo' ";
						 if (! $db->Query($consulta)) {
							$db->Kill();
							$seguimiento="No se pudo ejecutar la consuta.";
							return "ERROR";
						}
						if ($db->RowCount()>0){ 
							//$seguimiento="El Ci y extension ya estan registrados, los puedo usar<br>";
							$db->MoveFirst();
							$row = $db->Row();
							$codpersona=$row->codPersona;
							//	creo al usuario		
							$consulta = "insert into usuario (usuario, contrasenha, codTipousuario, codOficina, codPersona) values ('$usuario', '".$this->getToken(5)."', 2, $codoficina, $codpersona)";
							$success = true;
						
							if (!$db->Query($consulta)) $success = false;
							//-----------------------------------------------------------------------
							// verifico que se haya insertado correctamente el usuario
							if (!$success) { 
								$seguimiento.="error al insertar<br>$consulta<hr>";	
								if (! $db->TransactionRollback()) {
									$db->Kill();
									$seguimiento.="<b>ERROR CRITICO! Transaccion incompleta, notificar a sistemas</b>";
									return "ERROR";
								}else{
									return "ERROR";
									$seguimiento.="<b>ERROR! No se pudo insertar el usuario.</b>";
								}
							}	
							$codusuario=$db->GetLastInsertID();
							$iMail = new Correo();
							$iMail->NuevaCuenta($usuario);
							//commmit datos persona y termina
							if (! $db->TransactionEnd()) {
								$db->Kill();
							}
							return $codusuario;
							
						}else{
							//$seguimiento="El Ci y extension estan registrados para otro nobre y apellidos. No los puedo usar.";
							return "ERROR";
							$seguimiento="Este CI y Extension (persona) estan registrados con otros datos, no se puede registrar duplicados de carnet.";
						}
					 }else{
						// $seguimiento.="no existe el mismo carnet, lo puedo registrar<br>";
						// No existe persona, la puedo crear ------------------------------------------------------------------------------------------------------------------------
						$consulta="insert into persona (dui, extdui, nombre, apePat, apeMat, pnatural, direccion, telefono, codPais, correo) values ( '$dui', '$extdui', '$nombre', '$paterno', '$materno', '$tipo', '$direccion', '$telefono', '$correo', '$pais');";
						
						$success = true;
						if (! $db->Query($consulta)) $success = false;
						// si insert con exito
						if ($success) {
							$seguimiento.="registre a la persona<br>";
							// obtener codigo de persona insertada
							$codpersona= $db->GetLastInsertID();						
							//----------------------------------------------------------------------------------------------------------------
							//	creo al usuario		
							$consulta = "insert into usuario (usuario, contrasenha, codTipousuario, codOficina, codPersona) values ('$usuario', '".$this->getToken(5)."', 2, $codoficina, $codpersona)"; 							if (! $db->Query($consulta)) $success = false;
							//-----------------------------------------------------------------------
							// verifico que se haya insertado correctamente el usuario
							if (!$success) { 
								$seguimiento.="error al insertar<br>$consulta<hr>";	
								if (! $db->TransactionRollback()) {
									$db->Kill();
									$seguimiento.="<b>ERROR CRITICO! Transaccion incompleta, notificar a sistemas</b>";
									return "ERROR";
								}else{
									return "ERROR";
									$seguimiento.="<b>ERROR! No se pudo insertar el usuario.</b>";
								}
							}	
							$codusuario=$db->GetLastInsertID();
							$iMail = new Correo();
							$iMail->NuevaCuenta($usuario);
							//commmit datos persona y termina
							if (! $db->TransactionEnd()) {
								$db->Kill();
							}
							return $codusuario;		
						} else { 
							$seguimiento.="error al insertar<br>$consulta<hr>";	
							if (! $db->TransactionRollback()) {
								$db->Kill();
								$seguimiento.="<b>ERROR CRITICO! Transaccion incompleta, notificar a sistemas</b>";
								return "ERROR";
							}
						}
						//---------------------------------------------------
					 }
				}
				/*///////////////////////	INICIO CATCH  ///////////////////////////////////////////////////////////////////////////////////////////*/	
		} catch(Exception $e) {
			// If an error occurs, rollback and show the error
			$db->TransactionRollback();
			$seguimiento=$e->getMessage();
			return "ERROR";
		
		}
	}
    public function CrearPersonaCorto($nombre, $paterno, $materno, $tipo, $telefono, $correo, $usuario, $codoficina, $usrcrea, &$seguimiento){
		$seguimiento.="";
		$db = new MySQL();
		if ($db->Error()) {
			$db->Kill();
			return "no conecta";
		}
		$db->ThrowExceptions = false;
		try {
		/*///////////////////////	INICIO TRY ///////////////////////////////////////////////////////////////////////////////////////////*/		
			if (! $db->TransactionBegin()){ 
				$db->Kill();
				return "no transaccion";
			}

						// $seguimiento.="no existe el mismo carnet, lo puedo registrar<br>";
						// No existe persona, la puedo crear ---------------------------------------------------------------------------------------------------------------------------------------------------------------
						$consulta="insert into persona (dui, extdui, nombre, apePat, apeMat, pnatural, direccion, telefono, codPais, correo) values ( '', '', '$nombre', '$paterno', '$materno', '$tipo', ' ', '$telefono', '', '$correo');";
						
						$success = true;
						if (! $db->Query($consulta)) $success = false;
						// si insert con exito
						if ($success) {
							$seguimiento.="registre a la persona<br>";
							// obtener codigo de persona insertada
							$codpersona= $db->GetLastInsertID();						
							//----------------------------------------------------------------------------------------------------------------
							//	creo al usuario		
							$consulta = "insert into usuario (usuario, contrasenha, codTipousuario, codOficina, codPersona) values ('$usuario', '".$this->getToken(5)."', 2, $codoficina, $codpersona)"; 							if (! $db->Query($consulta)) $success = false;
							//-----------------------------------------------------------------------
							// verifico que se haya insertado correctamente el usuario
							if (!$success) { 
								$seguimiento.="error al insertar<br>$consulta<hr>";	
								if (! $db->TransactionRollback()) {
									$db->Kill();
									$seguimiento.="<b>ERROR CRITICO! Transaccion incompleta, notificar a sistemas</b>";
									return "ERROR";
								}else{
									return "ERROR";
									$seguimiento.="<b>ERROR! No se pudo insertar el usuario.</b>";
								}
							}	
							$codusuario=$db->GetLastInsertID();
							$iMail = new Correo();
							$iMail->NuevaCuenta($usuario);
							//commmit datos persona y termina
							if (! $db->TransactionEnd()) {
								$db->Kill();
							}
							return $codusuario;		
						} else { 
							$seguimiento.="error al insertar<br>$consulta<hr>";	
							if (! $db->TransactionRollback()) {
								$db->Kill();
								$seguimiento.="<b>ERROR CRITICO! Transaccion incompleta, notificar a sistemas</b>";
								return "ERROR";
							}
						}
						//---------------------------------------------------
					
				
				/*///////////////////////	INICIO CATCH  ///////////////////////////////////////////////////////////////////////////////////////////*/	
		} catch(Exception $e) {
			// If an error occurs, rollback and show the error
			$db->TransactionRollback();
			$seguimiento=$e->getMessage();
			return "ERROR";
		
		}
	}
	//--------------------------------------------------
	function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
	}
	//--------------------------------------------------------------------
	function getToken($length){
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet.= "0123456789";
		for($i=0;$i<$length;$i++){
			$token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
		}
		return $token;
	}
    //---------------------------------------------------------------------
    //------------------------------------
	public function EditarPersona($cod, $txnombre, $txpaterno, $txmaterno, $ddtipousuario, $txtelefono , $txcorreo, $txusuario, $ddoficina, $codUser, $mensaje){
        $consulta="update usuario set usuario='".$txusuario."', codTipoUSuario='$ddtipousuario', codOficina=$ddoficina where codUsuario='$cod'";	
		//echo $consulta."br";
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$db->ThrowExceptions = true;
		
		if (! $db->TransactionBegin()) $db->Kill();
			$success = true;
			$sql = $consulta;
		if (! $db->Query($sql)) $success = false;
        $sql=" update persona set nombre='$txnombre', apePat='$txpaterno', apeMat='$txmaterno', telefono='$txtelefono', correo='$txcorreo' where codPersona in (select codPersona from usuario where codUsuario='$cod')";
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
    //-----------------------------------------------------------------------------------------------------------
    public function ListarOficinas($busqueda=""){
	    $condicion="";
        if ($busqueda!=""){
            $condicion=" where ofi.descripcion like '%$busqueda%' order by ofi.descripcion ";
        }else{
            $condicion =" order by ofi.descripcion";
        }
		$consulta="
		select ofi.codOficina, ofi.descripcion as oficina, ofi.direccion, ofi.ciudad, ofi.telefono, ofi.logo, 
        case when ofi.baja='0' then 'No' else 'Si' end as baja, ofi.comTransporte, ofi.comTransporteMediano, 
        ofi.comTransportePesado, ofi.comPlacas, ofi.comOtros, ofi.codEmpresa,
        emp.nombre as empresa
		from oficina as ofi 
        left join empresa as emp on emp.codEmpresa=ofi.codEmpresa
        $condicion
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
    //-----------------------------------------------------------------------------------------------------------
    public function ListarEmpresas($busqueda=""){
        $condicion="";
        if ($busqueda!=""){
            $condicion=" where emp.nombre like '%$busqueda%' order by emp.nombre ";
        }else{
            $condicion =" order by emp.nombre";
        }
        $consulta="select emp.codEmpresa, emp.nit, emp.nombre, emp.direccion, emp.telefono,
emp.codSAP, emp.codCiudad, case when baja='1' then 'Si' else 'No' end as baja,
case when escomercial='1' then 'Si' else 'No' end as escomercial, 
case when esconcesionario='1' then 'Si' else 'No' end as esconcesionario,
ciu.nombre as ciudad
from empresa as emp
left join ciudad as ciu on ciu.codCiudad=emp.codCiudad
        $condicion
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
    //----------------------------------------------------------------------------------------------------------
    public function EditarOficina($cod, $descripcion, $direccion, $ciudad, $telefono, $logo, $baja, $comt, $comtmediano, $comtpesado, $comp, $como, $empresa){
        if($comt==""){
            $comt="0";
        }
        if($comp==""){
            $comp="0";
        }
        if($como==""){
            $como="0";
        }
        $consulta="update oficina set descripcion='$descripcion', direccion='$direccion', ciudad='$ciudad', telefono='$telefono', logo='$logo', baja='$baja', comTransporte='$comt', comTransporteMediano='$comtmediano', comTransportePesado='$comtpesado', comPlacas='$comp', comOtros='$como', codEmpresa='$empresa' where codOficina='$cod'";	
        //echo $consulta."<hr>";
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
    //-------------------------------------
    public function AgregarEmpresa($txnombre, $txnit, $txdireccion, $txtelefono, $txcodsap, $sciudad, $sbaja, $scomercial, $sconcesionario){

        $consulta="insert into empresa(nit, nombre, direccion, telefono, codSAP, codCiudad, baja, escomercial, esconcesionario) values('$txnit', '$txnombre', '$txdireccion', '$txtelefono', '$txcodsap', '$sciudad', '$sbaja', '$scomercial', '$sconcesionario')";	
        //echo $consulta."<hr>";
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
    //-------------------------------------
    public function EditarEmpresa($codEmpresa, $txnombre, $txnit, $txdireccion, $txtelefono, $txcodsap, $sciudad, $sbaja, $scomercial, $sconcesionario){

        $consulta="update empresa set   
        nit='$txnit', nombre='$txnombre', direccion='$txdireccion', telefono='$txtelefono', codSAP='$txcodsap', codCiudad='$sciudad', baja='$sbaja', escomercial='$scomercial', esconcesionario='$sconcesionario' where codEmpresa=$codEmpresa ";	
        //echo $consulta."<hr>";
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
    //-------------------------------------
    public function AgregarOficina($descripcion, $direccion, $ciudad, $telefono, $logo, $baja, $comt, $comtmediano, $comtpesado, $comp, $como, $empresa){
        if($comt==""){
            $comt="0";
        }
        if($comp==""){
            $comp="0";
        }
        if($como==""){
            $como="0";
        }
        
        $consulta="insert into oficina(descripcion, direccion, ciudad, telefono, logo, baja, comTransporte, comTransporteMediano, comTransportePesado, comPlacas, comOtros, codEmpresa) values('$descripcion', '$direccion', '$ciudad', '$telefono', '$logo', '$baja', '$comt', '$comtmediano', '$comtpesado' , '$comp', '$como','$empresa')";	
//echo $consulta."<hr>";
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
    //-----------------------------------------------------------------------------------------------------------
    public function ListarMarcas($codUsuario){
        $consulta="
		select m.codMarca, m.descripcion from marca as m inner join UsuarioMarca as um on m.codMarca=um.codMarca 
        where codUsuario=$codUsuario and baja='0'		";

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
    //-----------------------------------------------------------------------------------------------------------
    public function ListarMarcasNoHabilitadas($codUsuario){
        $consulta="
		select m.codMarca, m.descripcion 
        FROM marca as m
        LEFT JOIN usuariomarca as um ON m.codMarca = um.codMarca and um.baja='0' and um.codUsuario=$codUsuario
        WHERE um.codMarca IS NULL  ";

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
    //-----------------------------------------------------------------------------------------------------------
    public function RegistrarMarca($codUsuario, $codMarca){
        $consulta="insert into usuariomarca (codUsuario, codMarca, baja) values ($codUsuario, $codMarca, '0')";
       
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $db->ThrowExceptions = true;		
        if (! $db->TransactionBegin()) $db->Kill();

        // We'll create a flag to check for any errors
        $success = true;
        $sql = $consulta;
        if (! $db->Query($sql)) $success = false;
        if ($success) {
            // Commit the transaction and save these records to the database
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
        return true;
    }
    //-----------------------------------------------------------------------------------------------------------
    public function EliminarMarca($codUsuario, $codMarca){
        $consulta="update usuariomarca set baja='1' where codUsuario=$codUsuario and codMarca=$codMarca";

        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $db->ThrowExceptions = true;		
        if (! $db->TransactionBegin()) $db->Kill();

        // We'll create a flag to check for any errors
        $success = true;
        $sql = $consulta;
        if (! $db->Query($sql)) $success = false;
        if ($success) {
            // Commit the transaction and save these records to the database
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
        return true;
    }
}	
?>