<?php
include_once ("mysql.class.php");

class Rol
{
    protected $permisos;
 
    protected function __construct() {
        $this->permissions = array();
    }
 
    // return a role object with associated permissions
    public static function getRolesPermisos($codrol) {
        $iRol = new Rol();
        $consulta = "SELECT t2.permiso FROM rol_permiso as t1
                JOIN permiso as t2 ON t1.codPermiso = t2.codPermiso
                WHERE t1.codRol ='".$codrol."'";
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
 		
       while (! $db->EndOfSeek()) {
			$row = $db->Row();
            $iRol->permisos[$row->permiso] = true;
        }
        return $iRol;
    }
 
    // check if a permission is set
    public function hasPerm($permisos) {
        return isset($this->permisos[$permisos]);
    }
	
	
}
?>