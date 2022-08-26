<?php 
require_once '../clases/prospectoAuto.php';

$iProspecto= new Prospecto;
$nombre= @$_POST['nombre'];
$apellido= @$_POST['apellido'];
$correo= @$_POST['correo'];
$telefono= @$_POST['telefono'];
$origen= @$_POST['origen'];
$nota= @$_POST['nota'];


$resultado=$iProspecto->NuevoProspectoAutoPlaza($nombre,$apellido,$correo,$telefono,$origen,$nota);
echo 'OK';
	// if (is_numeric($resultado)) {
	// 	echo 'OK';
	// }
	// else
	// {
	// 	var_dump($resultado);
	// }
?>