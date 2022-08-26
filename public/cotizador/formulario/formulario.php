<?php 
require_once '../clases/prospecto.php';

$auxiliar=@$_GET['aux'];

if ($auxiliar==1) {
	$iProspecto= new Prospecto;
$nombre= @$_POST['nombre'];
$apellido= @$_POST['apellido'];
$correo= @$_POST['correo'];
$telefono= @$_POST['telefono'];
$origen= @$_POST['origen'];
$nota= @$_POST['nota'];
$marca= @$_POST['marca'];

$resultado=$iProspecto->NuevoProspectoAutoPlaza($nombre,$apellido,$correo,$telefono,$origen,$nota,$marca);

echo $resultado;

}


if ($auxiliar==2) {
	
		$iProspecto= new Prospecto;
$nombre= @$_POST['nombre'];
$apellido= @$_POST['apellido'];
$telefono= @$_POST['telefono'];
$ciudad= @$_POST['ciudad'];
$nota= @$_POST['nota'];
$origen= @$_POST['origen'];
$correo= @$_POST['correo'];
$pago= @$_POST['pago'];

$codMarca= @$_POST['codMarca'];
$codModelo= @$_POST['codModelo'];

$marca= @$_POST['marca'];
$modelo= @$_POST['modelo'];

$codTipo= @$_POST['codTipo'];
$codSubTipo= @$_POST['codSubTipo'];


$ingreso= @$_POST['ingreso'];
$tipotrabajo= @$_POST['tipotrabajo'];





$resultado=$iProspecto->NuevoProspectoAutoPlazaPorModelo($nombre,$apellido,$telefono,$ciudad,$nota,$origen,$correo,$pago,$codMarca,$codModelo,$marca,$modelo,$codTipo,$codSubTipo,$ingreso,$tipotrabajo);
echo $resultado;
//echo 'asd';

}

if ($auxiliar==3) {
	
		$iProspecto= new Prospecto;
$nombre= @$_POST['nombre'];
$apellido= @$_POST['apellido'];
$telefono= @$_POST['telefono'];
$ciudad= @$_POST['ciudad'];
$nota= @$_POST['nota'];
$origen= @$_POST['origen'];
$correo= @$_POST['correo'];
$pago= @$_POST['pago'];

$codMarca= @$_POST['codMarca'];
$codModelo= @$_POST['codModelo'];

$marca= @$_POST['marca'];
$modelo= @$_POST['modelo'];

$codTipo= @$_POST['codTipo'];
$codSubTipo= @$_POST['codSubTipo'];


$ingreso= @$_POST['ingreso'];
$tipotrabajo= @$_POST['tipotrabajo'];



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://chery.grt.center/api/rest/prospectos/");
//curl_setopt($ch, CURLOPT_URL,"http://grt.com.bo/dev/sgcautomotriz/api/rest/medios/");
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, "nombre=".$nombre."&apellido=".$apellido."&telefono=".$telefono."&ciudad=".$ciudad."&nota=".$nota."&origen=".$origen."&correo=".$correo."&pago=".$pago."&codMarca=".$codMarca."&codModelo=".$codModelo."&marca=".$marca."&modelo=".$modelo."&codTipo=".$codTipo."&codSubTipo=".$codSubTipo."&ingreso=".$ingreso."&tipotrabajo=".$tipotrabajo."");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec ($ch);
curl_close ($ch);
$res=$result;

echo $res;

//echo 'asd';

}




?>