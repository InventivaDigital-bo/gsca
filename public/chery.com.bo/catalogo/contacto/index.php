<?php
include_once __DIR__ . '/db.php';


if( isset($_POST['submit']) ){
	$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
	$telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
	$ciudad = filter_var($_POST['ciudad'], FILTER_SANITIZE_STRING);
	$correo = filter_var($_POST['correo'], FILTER_SANITIZE_STRING);
	$auto = filter_var($_POST['auto'], FILTER_SANITIZE_STRING);
	$precio = filter_var($_POST['precio'], FILTER_SANITIZE_STRING);
	$texto = filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING);
	$fecha = date("Y-m-d H:i:s");

	$sql = "INSERT INTO be_contacto(nombre, telefono, correo, mensaje, ciudad, vehiculo, precio, created_at, updated_at) values(
		'".$nombre."',
		'".$telefono."',
		'".$correo."',
		'".$texto."',
		'".$ciudad."',
		'".$auto."',
		'".$precio."',
		'".$fecha."',
		'".$fecha."')";
	$mysqli->query($sql)or die($mysqli->error);
	$idContacto = $mysqli->insert_id;



	$email = 'jpittari@gsca.com.bo';
	$para  = $email . ', ';
	$titulo = 'Solicitud de información - Catalogo Web';
	$mensaje = '
	<html>
	<head>
	  <title>Catalogo - Chery</title>
	</head>
	<body>
	<br>
	============================== 	<br>
	**SOLICITUD DE INFORMACIÓN** 	<br>
	==============================	<br><br>
	<br>
	<p><b>Nombre:</b> '.$nombre.' </p>
	<p><b>Teléfono:</b> '.$telefono.' </p>
	<p><b>Email:</b> '.$correo.' </p>
	<p><b>Ciudad:</b> '.$ciudad.' </p>
	<p><b>Vehículo:</b> '.$auto.' </p>
	<p><b>Precio:</b> '.$precio.' </p>
	<p><b>Mensaje:</b> '.$texto.' </p>
	<br><br>
	<div style="font-size:10px; font-weight:bold;color:#333;">
	CHERY - BOLIVIA <br>
	'. $fecha .'
	<br><br>
	</div>
	</body>
	</html>
	';

	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

	// Cabeceras adicionales
	$cabeceras .= 'To: Info <$email>' . "\r\n";
	$cabeceras .= 'From: Catalogo <info@chery.com.bo>' . "\r\n";
	// $cabeceras .= 'Cc: lf.deiby@hotmail.com' . "\r\n";

	mail($para, $titulo, $mensaje, $cabeceras);

	$response = array(
		'status'=>'ok',
	);
	header('Content-type: application/json');
	echo json_encode($response);
	exit();
}

header("Location: /404/");
exit();

?>