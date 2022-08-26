<?php

include_once ("mysql.class.php");
include_once ("rol.php");

class Usuario{
	private $user    = ""; 
	private $name    = ""; 
	private $contrasenha= ""; 
	private $oficina    = ""; 
	private $profile    = ""; 
	private $codigo = 0;
	private $codSalon = 0;
	private $osiris = "";
	private $salon = "";
	private $logueado = false;
	private $correo = "";
    private $foto = "";
    private $inicializado = "";

    private $abm = 0;
	private $roles= array();
	
	public function IniciarSesion($usuario, $contrasenha){
		
		//------------------------------------------------------------------
		/*$consulta="
		SELECT u.codUsuario, usuario, t.codTipoUsuario, t.descripcion as tipoUsuario, 
		CONCAT(nombre,' ', paterno) as nombre, correo, o.descripcion as oficina
		FROM  usuario as u
		left join persona as p on p.codPersona=u.codPersona
		left join tipousuario as t on t.codTipoUsuario=u.codTipousuario
		left join oficina as o on o.codOficina=u.codOficina
		where u.usuario='$usuario' and contrasenha='$contrasenha'
		LIMIT 0 , 30
		";
		*/

		$consulta="
		SELECT u.codUsuario, usuario, t.codTipoUsuario, t.descripcion as tipoUsuario, u.foto,u.inicializado,u.codSalon,
		CONCAT(p.nombre,' ', apePat) as nombre, o.descripcion as oficina, u.codoficina, u.contrasenha, p.correo,s.nombre as salon,p.sapSlpCode as osiris, u.abm
		FROM  usuario as u
		left join persona as p on p.codPersona=u.codPersona
		left join tipousuario as t on t.codTipoUsuario=u.codTipousuario
		left join oficina as o on o.codOficina=u.codOficina
        left join Salon as s on u.codSalon= s.codSalon
		where u.usuario='$usuario' and contrasenha='$contrasenha'
		LIMIT 0 , 30
		";
		
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			//echo "<option value='".$row->codSoporte."'>".$row->soporte."</option>";			
			$this->logueado=true;
			$this->name=$row->nombre;
			$this->user=$row->usuario;
			$this->oficina=$row->codoficina;
			$this->profile=$row->tipoUsuario;
			$this->codigo=$row->codUsuario;
			$this->correo=$row->correo;
            $this->foto=$row->foto;
			$this->contrasenha=$row->contrasenha;
			$this->inicializado=$row->inicializado;
			$this->codTipoUsuario=$row->codTipoUsuario;
			     $this->codSalon=$row->codSalon;
			     $this->salon=$row->salon;
			     $this->osiris=$row->osiris;
			     $this->abm=$row->abm;
			$this->initRoles();
			return true;			
		}
		return false;		
	}


		public function IniciarSesion2($usuario){
		
		//------------------------------------------------------------------
		/*$consulta="
		SELECT u.codUsuario, usuario, t.codTipoUsuario, t.descripcion as tipoUsuario, 
		CONCAT(nombre,' ', paterno) as nombre, correo, o.descripcion as oficina
		FROM  usuario as u
		left join persona as p on p.codPersona=u.codPersona
		left join tipousuario as t on t.codTipoUsuario=u.codTipousuario
		left join oficina as o on o.codOficina=u.codOficina
		where u.usuario='$usuario' and contrasenha='$contrasenha'
		LIMIT 0 , 30
		";
		*/

		$consulta="
		SELECT u.codUsuario, usuario, t.codTipoUsuario, t.descripcion as tipoUsuario, u.foto,u.inicializado,u.codSalon,
		CONCAT(p.nombre,' ', apePat) as nombre, o.descripcion as oficina, u.codoficina, u.contrasenha, p.correo,s.nombre as salon,p.sapSlpCode as osiris, u.abm
		FROM  usuario as u
		left join persona as p on p.codPersona=u.codPersona
		left join tipousuario as t on t.codTipoUsuario=u.codTipousuario
		left join oficina as o on o.codOficina=u.codOficina
        left join Salon as s on u.codSalon= s.codSalon
		where u.usuario='$usuario'
		LIMIT 0 , 30
		";
		
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			//echo "<option value='".$row->codSoporte."'>".$row->soporte."</option>";			
			$this->logueado=true;
			$this->name=$row->nombre;
			$this->user=$row->usuario;
			$this->oficina=$row->codoficina;
			$this->profile=$row->tipoUsuario;
			$this->codigo=$row->codUsuario;
			$this->correo=$row->correo;
            $this->foto=$row->foto;
			$this->contrasenha=$row->contrasenha;
			$this->inicializado=$row->inicializado;
			$this->codTipoUsuario=$row->codTipoUsuario;
			     $this->codSalon=$row->codSalon;
			     $this->salon=$row->salon;
			     $this->osiris=$row->osiris;
			     $this->abm=$row->abm;
			$this->initRoles();
			return true;			
		}
		return false;		
	}
	
	public function RecuperarSesion($usuario){

		$consulta="
		SELECT u.codUsuario, usuario, t.codTipoUsuario, t.descripcion as tipoUsuario, u.foto,u.inicializado,u.codSalon,
		CONCAT(p.nombre,' ', apePat) as nombre, o.descripcion as oficina, u.codoficina, u.contrasenha, p.correo,s.nombre as salon,p.sapSlpCode as osiris,u.abm
		FROM  usuario as u
		left join persona as p on p.codPersona=u.codPersona
		left join tipousuario as t on t.codTipoUsuario=u.codTipousuario
		left join oficina as o on o.codOficina=u.codOficina
        left join Salon as s on u.codSalon= s.codSalon
		where u.usuario='$usuario' 
		LIMIT 0 , 30
		";
		
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			//echo "<option value='".$row->codSoporte."'>".$row->soporte."</option>";			
			$this->logueado=true;
			$this->name=$row->nombre;
			$this->user=$row->usuario;
			$this->contrasenha=$row->contrasenha;
			$this->oficina=$row->codoficina;
			$this->profile=$row->tipoUsuario;
			$this->codigo=$row->codUsuario;
			$this->correo=$row->correo;
            $this->foto=$row->foto;
            $this->inicializado=$row->inicializado;
            $this->codTipoUsuario=$row->codTipoUsuario;
                 $this->codSalon=$row->codSalon;
                 $this->salon=$row->salon;
                 $this->osiris=$row->osiris;
                     $this->abm=$row->abm;
			$this->initRoles();
			return true;			
		}
		return false;		
	}
    //--------------------------------------------------------------------------------
    public function RecuperarSesionCod($codUsuario){
		
		//------------------------------------------------------------------
		/*$consulta="
		SELECT u.codUsuario, usuario, t.codTipoUsuario, t.descripcion as tipoUsuario, 
		CONCAT(nombre,' ', paterno) as nombre, correo, o.descripcion as oficina
		FROM  usuario as u
		left join persona as p on p.codPersona=u.codPersona
		left join tipousuario as t on t.codTipoUsuario=u.codTipousuario
		left join oficina as o on o.codOficina=u.codOficina
		where u.usuario='$usuario' and contrasenha='$contrasenha'
		LIMIT 0 , 30
		";
		*/

		$consulta="
		SELECT u.codUsuario, usuario, t.codTipoUsuario, t.descripcion as tipoUsuario, u.foto,u.inicializado,u.codSalon,
		CONCAT(p.nombre,' ', apePat) as nombre, o.descripcion as oficina, u.codoficina, u.contrasenha, p.correo,s.nombre as salon,p.sapSlpCode as osiris, u.abm
		FROM  usuario as u
		left join persona as p on p.codPersona=u.codPersona
		left join tipousuario as t on t.codTipoUsuario=u.codTipousuario
		left join oficina as o on o.codOficina=u.codOficina
        left join Salon as s on u.codSalon= s.codSalon
		where u.codUsuario='$codUsuario' 
		LIMIT 0 , 30
		";
		
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			//echo "<option value='".$row->codSoporte."'>".$row->soporte."</option>";			
			$this->logueado=true;
			$this->name=$row->nombre;
			$this->user=$row->usuario;
			$this->contrasenha=$row->contrasenha;
			$this->oficina=$row->codoficina;
			$this->profile=$row->tipoUsuario;
			$this->codigo=$row->codUsuario;
			$this->correo=$row->correo;
            $this->foto=$row->foto;
            $this->inicializado=$row->inicializado;
            $this->codTipoUsuario=$row->codTipoUsuario;
                 $this->codSalon=$row->codSalon;
                 $this->salon=$row->salon;
                 $this->osiris=$row->osiris;
                   $this->abm=$row->abm;
			$this->initRoles();
			return true;			
		}
		return false;		
	}
	
	public function EstaLogueado(){
		return $this->logueado;
	}
	
	public function obtenerUsuario(){
		return $this->user;
	}
	
	public function obtenerOficina(){
		return $this->oficina;
	}
	
	public function obtenerNombre(){
		return $this->name;
	}
	
	public function obtenerPerfil(){
		return $this->profile;
	}
	
	public function obtenerCodigo(){
		return $this->codigo;
	}
	public function obtenerCorreo(){
		return $this->correo;
	}
    public function obtenerFoto(){
		return $this->foto;
	}
	public function obtenerPassword(){
		return $this->contrasenha;
	}

	public function obtenerInicializado(){
		return $this->inicializado;
	}
	public function obtenercodTipoUsuario(){
		return $this->codTipoUsuario;
	}
	public function obtenercodSalon(){
		return $this->codSalon;
	}

	public function obtenerSalon(){
		return $this->salon;
	}
	public function obtenerOsiris(){
		return $this->osiris;
	}
	public function obtenerAbm(){
		return $this->abm;
	}
	//--------------------------------------------------------------------------------------------------------------
	function CambiarContrasenia($usuario, $contrasenia){
		$consulta="update usuario set contrasenha='".$contrasenia."' where usuario='$usuario'";	
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
	//-------------------------------------------------------------------------------------------------------------
	// populate roles with their associated permissions
    protected function initRoles() {
        $this->roles = array();
        $consulta = "SELECT t1.codRol, t2.rol FROM usuario_rol as t1
                JOIN rol as t2 ON t1.codRol= t2.codRol
                WHERE t1.codUsuario ='".$this->codigo."'";
       $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			$this->roles[$row->rol] =  Rol::getRolesPermisos($row->codRol);
        }
    }
	//------------------------------------------------------------------------------------------------------------
	// check if user has a specific privilege
    public function hasPrivilege($perm) {
        foreach ($this->roles as $rol) {
            if ($rol->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
    //---------------------------------------------------------------------    
    function CambiarContraseniaCod($usuario, $contrasenia){
		$consulta="update usuario set contrasenha='".$contrasenia."' where codUsuario='$usuario'";	
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
            //$iMail = new Correo;
            //$iMail->ModificacionCuenta($usuario);
			return true;		
		} else { 	
			if (! $db->TransactionRollback()) {
				$db->Kill();
				return false;
			}
		}
		return false;
	}


	 function ObtenerIntermediario($codUsuario){
		$db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            $data = 'SELECT persona.sapSlpCode as codigoIntermediario, concat(persona.nombre," ",persona.apePat," ",persona.apeMat) as nombreIntermediario FROM usuario left join persona on usuario.codPersona = persona.codPersona WHERE codUsuario = \''.$codUsuario.'\'';
            if ($db->HasRecords($data)) {
                $db->Query($data);
                $db->MoveFirst();
                return $db->Row();
            } else {
                return false;
            }
        }
	}

	public function getUserData($codUsuario) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            $data = 'SELECT * FROM usuario WHERE codUsuario = \''.$codUsuario.'\'';
            if ($db->HasRecords($data)) {
                $db->Query($data);
                return $db;
            } else {
                return false;
            }
        }
    }



    function RegistrarLogInicioSesion($codUsuario){
		$consulta="INSERT into bitacora_inicio (codUsuario, fechaLog, horaLog ) values ('$codUsuario',CURRENT_DATE(),NOW())";	
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



	//////////////ES consulta inicios por dia

	function ReporteLogInicioSesion($mes,$gestion,$codUsuario)
	{
		$consulta="SELECT day(fechas.fecha) as fecha,case when tabla2.total is null then 0 else tabla2.total end as total from fechas left join (select fechas.fecha, count(bitacora_inicio.fechaLog)as total from fechas left join bitacora_inicio on fechas.fecha=bitacora_inicio.fechaLog where YEAR(fechas.fecha)='$gestion' and month(fechas.fecha)='$mes' and bitacora_inicio.codUsuario='$codUsuario' group by fechas.fecha) as tabla2 on fechas.fecha=tabla2.fecha where YEAR(fechas.fecha)='$gestion' and month(fechas.fecha)='$mes'";	

		$db = new MySQL();
		$db->Query($consulta);

		return $db;
	}


		function totalIngresosMes($mes,$gestion,$codUsuario)
	{
		$consulta="SELECT sum(total)as total from (SELECT fechas.fecha,case when tabla2.total is null then 0 else tabla2.total end as total from fechas left join (select fechas.fecha, count(bitacora_inicio.fechaLog)as total from fechas left join bitacora_inicio on fechas.fecha=bitacora_inicio.fechaLog where YEAR(fechas.fecha)='$gestion' and month(fechas.fecha)='$mes' and bitacora_inicio.codUsuario='$codUsuario' group by fechas.fecha) as tabla2 on fechas.fecha=tabla2.fecha where YEAR(fechas.fecha)='$gestion' and month(fechas.fecha)='$mes' ) as tabla";	

		$db = new MySQL();
		$db->Query($consulta);

		return $db;
	}


		function TraerDatosUsuario($codUsuario)
	{
		$consulta="SELECT concat(fechaLog, ' ',horaLog ) as ultimoingreso,persona.nombre as nombre, persona.apePat as apellido,persona.telefono as telefono, persona.correo as email from bitacora_inicio left join usuario on bitacora_inicio.codUsuario=usuario.codUsuario left join persona on persona.codPersona=usuario.codPersona where bitacora_inicio.codUsuario='$codUsuario' order by bitacora_inicio.fechaLog desc,bitacora_inicio.horaLog desc limit 1";	

		$db = new MySQL();
		$db->Query($consulta);

		return $db;
	}


}
?>