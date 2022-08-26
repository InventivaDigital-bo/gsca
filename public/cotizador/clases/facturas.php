<?php
include_once("mysql.class.php");
include_once("verhoeff.php");


class facturas{
	
//---------------------------------------------------------------------------------------------------------------------------------------------
// Algoritmo Alleged RC4
function rc4($str, $key) {
	$estado = array();
	for ($i = 0; $i < 256; $i++) {
		$estado[$i] = $i;
	}
	
	$index2 = 0;
	$index1=0;
	
	for ($i = 0; $i < 256; $i++) {
		$index2 = ($index2 + $estado[$i] + ord($key[$index1])) % 256;
		$x = $estado[$i];
		$estado[$i] = $estado[$index2];
		$estado[$index2] = $x;
		$index1=($index1+1) % strlen($key);
	}

	$x = 0;
	$y = 0;
	$mensajecifrado = '';
	$nmen=0;
	
	for ($i = 0; $i < strlen($str); $i++) {
		$x = ($x + 1) % 256;
		$y = ($y + $estado[$x]) % 256;
		$xx = $estado[$x];
		$estado[$x] = $estado[$y];
		$estado[$y] = $xx;
		$nmen=ord($str[$i]) ^ $estado[($estado[$x]+$estado[$y])%256];
		$mensajecifrado=$mensajecifrado.'-'.$this->Hexa($nmen); 
	}
	return substr($mensajecifrado,1,strlen($mensajecifrado)-1);
}

function Hexa($valor){
//convierte a hexa y rellena a cero
$temp=dechex($valor);
if (strlen($temp)==1){
	return strtoupper("0".$temp);
	}else{
	return strtoupper($temp);
	}
}

//---------------------------------------------------------------------------------------------------------------------------------------------
// Algoritmo base 64
	function base64($numero){

		$diccionario= array('0','1','2','3','4','5','6','7','8','9',
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	    'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	    '+','/');
		
		$cociente=1;
		$resto;
		$palabra="";
		while  (intval($cociente)>0){
			$cociente=$numero/64;
			$resto=$numero%64;
			$palabra=$diccionario[$resto].$palabra;
			$numero=$cociente;
		}
	return $palabra;
	}
//---------------------------------------------------------------------------------------------------------------------------------------------
// Algoritmo Verhoeff
	function verhoeff($cadena){
		$iVerh = new cVerhoeff();
		return $iVerh->calc($cadena);
	}	
//----------------------------------------------------------------------------------------------------------------------------------------------
// Generar Codigo de Control	
	function GenerarCodigoControl($numfactura, $llavedosif,$numautorizacion,$nitcliente,$fechafact,$monto){
	
		// Obtengo 2 digitos verhoeff para generar nuevo numero de factura
		$nnumfactura= $this->verhoeff($numfactura);
		$nnumfactura2= $this->verhoeff($numfactura.$nnumfactura);
		$tnumfactura=$numfactura.$nnumfactura.$nnumfactura2;
		//----------------------------------------------------
		
		// Obtengo 2 digitos verhoeff para generar nuevo ci cliente
		$nnitcliente= $this->verhoeff($nitcliente);
		$nnitcliente2= $this->verhoeff($nitcliente.$nnitcliente);
		$tnitcliente=$nitcliente.$nnitcliente.$nnitcliente2;
		//----------------------------------------------------
		
		// Obtengo 2 digitos verhoeff para generar nueva fecha transaccion
		$nfechafact= $this->verhoeff($fechafact);
		$nfechafact2= $this->verhoeff($fechafact.$nfechafact);
		$tfechafact=$fechafact.$nfechafact.$nfechafact2;
		//----------------------------------------------------
		
		// Obtengo 2 digitos verhoeff para monto
		$monto=str_replace(",",".",$monto);
		//$decimal=$monto%1.00;
		$monto=round($monto,0, PHP_ROUND_HALF_UP);
		$nmonto= $this->verhoeff($monto);
		$nmonto2= $this->verhoeff($monto.$nmonto);
		$tmonto=$monto.$nmonto.$nmonto2;
		//----------------------------------------------------
		
		// Suma todos los totales y le saca 5 digitos verhoeff
		$tsuma=$tnumfactura+$tnitcliente+$tfechafact+$tmonto;
		$tsuma1= $this->verhoeff($tsuma);
		$tsuma2= $this->verhoeff($tsuma.$tsuma1);
		$tsuma3= $this->verhoeff($tsuma.$tsuma1.$tsuma2);
		$tsuma4= $this->verhoeff($tsuma.$tsuma1.$tsuma2.$tsuma3);
		$tsuma5= $this->verhoeff($tsuma.$tsuma1.$tsuma2.$tsuma3.$tsuma4);
		
		//Obtengo 5 cadenas de la llave de dosificacion
		$cadena1=substr($llavedosif,0,$tsuma1+1);
		$cadena2=substr($llavedosif,$tsuma1+1,$tsuma2+1);
		$cadena3=substr($llavedosif,$tsuma1+$tsuma2+2,$tsuma3+1);
		$cadena4=substr($llavedosif,$tsuma1+$tsuma2+$tsuma3+3,$tsuma4+1);
		$cadena5=substr($llavedosif,$tsuma1+$tsuma2+$tsuma3+$tsuma4+4,$tsuma5+1);
		
		//Obtengo nuevos valores  a ser concatenados
		$nnumeroautorizacion=$numautorizacion.$cadena1;
		$tnumfactura=$tnumfactura.$cadena2;
		$tnitcliente=$tnitcliente.$cadena3;
		$tfechafact=$tfechafact.$cadena4;
		$tmonto=$tmonto.$cadena5;
		
		$digitos=$tsuma1.$tsuma2.$tsuma3.$tsuma4.$tsuma5;
		$cadenaconcatenada=$nnumeroautorizacion.$tnumfactura.$tnitcliente.$tfechafact.$tmonto;
		$llavecifrado=$llavedosif.$digitos;
		$resultado=$this->rc4($cadenaconcatenada,$llavecifrado);
		$resultado=str_replace("-","",$resultado);
		
		//Obtengo suma de valores ascii de la cadena obtenida con el rc4
		$st=0;
		$sp1=0;
		$sp2=0;
		$sp3=0;
		$sp4=0;
		$sp5=0;
		
		for ($i=0; $i<strlen($resultado); $i++){
			$st=$st+ord($resultado[$i]);
		}
		for ($i=0; $i<strlen($resultado); $i=$i+5){
			$sp1=$sp1+ord($resultado[$i]);
		}
		for ($i=1; $i<strlen($resultado); $i=$i+5){
			$sp2=$sp2+ord($resultado[$i]);
		}
		for ($i=2; $i<strlen($resultado); $i=$i+5){
			$sp3=$sp3+ord($resultado[$i]);
		}
		for ($i=3; $i<strlen($resultado); $i=$i+5){
			$sp4=$sp4+ord($resultado[$i]);
		}
		for ($i=4; $i<strlen($resultado); $i=$i+5){
			$sp5=$sp5+ord($resultado[$i]);
		}
		
		//Calculo resultado con parciales
		$t1=intval(($st*$sp1)/($tsuma1+1));
		$t2=intval(($st*$sp2)/($tsuma2+1));
		$t3=intval(($st*$sp3)/($tsuma3+1));
		$t4=intval(($st*$sp4)/($tsuma4+1));
		$t5=intval(($st*$sp5)/($tsuma5+1));
		
		//Sumo los resultados parciales
		$tt=$t1+$t2+$t3+$t4+$t5;
		$btt=$this->base64($tt);
		
		//Obtengo nueva llave de cifrado
		$llavecifrado2=$llavedosif.$tsuma1.$tsuma2.$tsuma3.$tsuma4.$tsuma5;
		//Obtengo codigo de control
		$codigo=$this->rc4($btt,$llavecifrado2);
		return $codigo;
	}
		//---------------------------------------------------------------------------------------------------------------------------------------------
		function DatosFactura($codigo){
			$consulta="
			select e.descripcion as empresa,e.nit, o.descripcion as oficina, o.direccion, o.ciudad,
			DATE_FORMAT(  fecFactura ,  '%d-%m-%Y' ) as fecFactura, nroFactura,  nroControl, nroAutorizacion, nombre, f.nit as nitcliente, montoBs, descuento, totalBs, impresa, 
			DATE_FORMAT(  `fecLimiteEmision` ,  '%d-%m-%Y' ) as fechaLimite, estado, usuario, codVendedor
			from factura_pos_cab as f
			left join talonario_facturacion as t on t.codTalonario=f.codTalonario
			left join empresa as e on e.codEmpresa=t.codEmpresa
			left join oficina as o on o.codOficina=t.codOficina
			where codFacPos	= $codigo";
			
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
		//---------------------------------------------------------------------------------------------------------------------------------------------
		function DetalleFactura($codigo){
			$consulta="
			select descripcion, cant, precioBs, totalBs
			from factura_pos_linea f
			where codFac= $codigo";
			
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
}
?>