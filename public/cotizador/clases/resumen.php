<?php
include_once("mysql.class.php");
include("excelwriter.php");
class resumen{

	
	//---------------------------------------------------------------------------------------------------------
	// Listar incidentes usuario
	function ListarIncidentes($anio, $mes){
		$db = new MySQL();
		
		if ($db->Error()) $db->Kill();
		$consulta="select sistema, sum(abierto) as abierto, sum(cerrado) as cerrado, sum(proceso) as proceso, sum(espera) as espera, sum(abierto+cerrado+proceso+espera) as total
from (
SELECT s.descripcion as sistema, case when codEstado=1 then 1 else 0 end as abierto, case when codEstado=2 then 1 else 0 end as cerrado, case when codEstado=3 then 1 else 0 end as proceso, case when codEstado=4 then 1 else 0 end as espera 
FROM incidente as i

left join tipoincidente as t on t.codTipoIncidente=i.codTipoIncidente
left join sistema as s on s.codSistema=t.codSistema
where year(fecapertura)=$anio and month(fecapertura)=$mes    
) as tab group by sistema order by  sum(abierto+cerrado+proceso+espera) desc
 ";

//echo $consulta."<br>";
		$ttotal=0;
		$tabiertos=0;
		$tenproceso=0;
		$tpendientes=0;
		$tcerrados=0;

		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();		
		$tipo="even";
		while (! $db->EndOfSeek()) {
			if ($tipo=="even"){
				$tipo="odd";
			}else{
				$tipo="even";
			}

			$row = $db->Row();

			echo "<tr class='".$tipo."'>";
			echo "<td>".$row->sistema."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->total."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->abierto."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->proceso."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->espera."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->cerrado."</td>";
			echo "</tr>";
			
			$ttotal=$ttotal+$row->total;
			$tabiertos=$tabiertos+$row->abierto;
			$tenproceso=$tenproceso+$row->proceso;
			$tpendientes=$tpendientes+$row->espera;
			$tcerrados=$tcerrados+$row->cerrado;
		}
		echo '
		<tr>
		<th style="vertical-align:middle; text-align:left">Total</th>
		<th style="vertical-align:middle; text-align:right">'.$ttotal.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tabiertos.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tenproceso.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tpendientes.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tcerrados.'</th>
      	</tr>';
		
		
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Listar incidentes usuario
	function ListarIncidentesUsuario($anio, $mes, $codsoporte){
		$db = new MySQL();
		
		if ($db->Error()) $db->Kill();
		$consulta="select sistema, sum(abierto) as abierto, sum(cerrado) as cerrado, sum(proceso) as proceso, sum(espera) as espera, sum(abierto+cerrado+proceso+espera) as total
from (
SELECT s.descripcion as sistema, case when codEstado=1 then 1 else 0 end as abierto, case when codEstado=2 then 1 else 0 end as cerrado, case when codEstado=3 then 1 else 0 end as proceso, case when codEstado=4 then 1 else 0 end as espera 
FROM incidente as i
left join tipoincidente as t on t.codTipoIncidente=i.codTipoIncidente
left join sistema as s on s.codSistema=t.codSistema
where year(fecapertura)=$anio and month(fecapertura)=$mes and i.codSoporte=$codsoporte    
) as tab group by sistema order by  sum(abierto+cerrado+proceso+espera) desc
 ";

//echo $consulta."<br>";
		$ttotal=0;
		$tabiertos=0;
		$tenproceso=0;
		$tpendientes=0;
		$tcerrados=0;

		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();		
		$tipo="even";
		while (! $db->EndOfSeek()) {
			if ($tipo=="even"){
				$tipo="odd";
			}else{
				$tipo="even";
			}

			$row = $db->Row();

			echo "<tr class='".$tipo."'>";
			echo "<td>".$row->sistema."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->total."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->abierto."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->proceso."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->espera."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->cerrado."</td>";
			echo "</tr>";
			
			$ttotal=$ttotal+$row->total;
			$tabiertos=$tabiertos+$row->abierto;
			$tenproceso=$tenproceso+$row->proceso;
			$tpendientes=$tpendientes+$row->espera;
			$tcerrados=$tcerrados+$row->cerrado;
		}
		echo '
		<tr>
		<th style="vertical-align:middle; text-align:left">Total</th>
		<th style="vertical-align:middle; text-align:right">'.$ttotal.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tabiertos.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tenproceso.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tpendientes.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tcerrados.'</th>
      	</tr>';
		
		
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Listar incidentes usuario
	function ListarIncidentesPersona($anio, $mes){
		$db = new MySQL();
		
		if ($db->Error()) $db->Kill();
		$consulta="select usuario, sum(abierto) as abierto, sum(cerrado) as cerrado, sum(proceso) as proceso, sum(espera) as espera, sum(abierto+cerrado+proceso+espera) as total
from (
SELECT CONCAT(p.nombre, ' ', p.paterno) as usuario, case when codEstado=1 then 1 else 0 end as abierto, case when codEstado=2 then 1 else 0 end as cerrado, case when codEstado=3 then 1 else 0 end as proceso, case when codEstado=4 then 1 else 0 end as espera 
FROM incidente as i

left join tipoincidente as t on t.codTipoIncidente=i.codTipoIncidente
left join sistema as s on s.codSistema=t.codSistema
left join usuario as u on u.codUsuario=i.codUsuario
left join persona as p on p.codPersona=u.codPersona
where year(fecapertura)=$anio and month(fecapertura)=$mes    
) as tab group by usuario order by sum(abierto+cerrado+proceso+espera) desc
 ";

//echo $consulta."<br>";
		$ttotal=0;
		$tabiertos=0;
		$tenproceso=0;
		$tpendientes=0;
		$tcerrados=0;
		

		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();		
		$tipo="even";
		while (! $db->EndOfSeek()) {
			if ($tipo=="even"){
				$tipo="odd";
			}else{
				$tipo="even";
			}

			$row = $db->Row();

			echo "<tr class='".$tipo."'>";
			echo "<td>".$row->usuario."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->total."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->abierto."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->proceso."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->espera."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->cerrado."</td>";
			echo "</tr>";
			
			$ttotal=$ttotal+$row->total;
			$tabiertos=$tabiertos+$row->abierto;
			$tenproceso=$tenproceso+$row->proceso;
			$tpendientes=$tpendientes+$row->espera;
			$tcerrados=$tcerrados+$row->cerrado;
		}
		
		echo '
		<tr>
		<th style="vertical-align:middle; text-align:left">Total</th>
		<th style="vertical-align:middle; text-align:right">'.$ttotal.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tabiertos.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tenproceso.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tpendientes.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tcerrados.'</th>
      	</tr>';
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Listar incidentes usuario
	function ListarIncidentesPersonaUsuario($anio, $mes, $codsoporte){
		$db = new MySQL();
		
		if ($db->Error()) $db->Kill();
		$consulta="select usuario, sum(abierto) as abierto, sum(cerrado) as cerrado, sum(proceso) as proceso, sum(espera) as espera, sum(abierto+cerrado+proceso+espera) as total
from (
SELECT CONCAT(p.nombre, ' ', p.paterno) as usuario, case when codEstado=1 then 1 else 0 end as abierto, case when codEstado=2 then 1 else 0 end as cerrado, case when codEstado=3 then 1 else 0 end as proceso, case when codEstado=4 then 1 else 0 end as espera 
FROM incidente as i
left join tipoincidente as t on t.codTipoIncidente=i.codTipoIncidente
left join sistema as s on s.codSistema=t.codSistema
left join usuario as u on u.codUsuario=i.codUsuario
left join persona as p on p.codPersona=u.codPersona
where year(fecapertura)=$anio and month(fecapertura)=$mes  and i.codSoporte=$codsoporte   
) as tab group by usuario order by sum(abierto+cerrado+proceso+espera) desc
 ";

//echo $consulta."<br>";
		$ttotal=0;
		$tabiertos=0;
		$tenproceso=0;
		$tpendientes=0;
		$tcerrados=0;
		

		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();		
		$tipo="even";
		while (! $db->EndOfSeek()) {
			if ($tipo=="even"){
				$tipo="odd";
			}else{
				$tipo="even";
			}

			$row = $db->Row();

			echo "<tr class='".$tipo."'>";
			echo "<td>".$row->usuario."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->total."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->abierto."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->proceso."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->espera."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->cerrado."</td>";
			echo "</tr>";
			
			$ttotal=$ttotal+$row->total;
			$tabiertos=$tabiertos+$row->abierto;
			$tenproceso=$tenproceso+$row->proceso;
			$tpendientes=$tpendientes+$row->espera;
			$tcerrados=$tcerrados+$row->cerrado;
		}
		
		echo '
		<tr>
		<th style="vertical-align:middle; text-align:left">Total</th>
		<th style="vertical-align:middle; text-align:right">'.$ttotal.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tabiertos.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tenproceso.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tpendientes.'</th>
        <th style="vertical-align:middle; text-align:right">'.$tcerrados.'</th>
      	</tr>';
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Listar incidentes usuario
	public function Total(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT count(*) as total FROM incidente ")) $db->Kill();
		$db->MoveFirst();
		
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo $row->total;						
		}
				
	}
	
	//---------------------------------------------------------------------------------------------------------
	// Listar incidentes usuario
	function DetalleIncidentesSistema($anio, $mes){
		$db = new MySQL();
		
		if ($db->Error()) $db->Kill();
		$consulta="
select * from (		
SELECT s.descripcion as sistema, t.descripcion as tipo, count(*) as total, 
( 
    select count(*) from incidente as i2 
    left join tipoincidente as t2 on t2.codTipoIncidente=i2.codTipoIncidente
    where t2.codSistema=t.codSistema and year(fecapertura)=$anio and month(fecapertura)=$mes limit 1 
)     as acumulado
FROM incidente as i
left join tipoincidente as t on t.codTipoIncidente=i.codTipoIncidente
left join sistema as s on s.codSistema=t.codSistema
where year(fecapertura)=$anio and month(fecapertura)=$mes  
group by 
s.descripcion , t.descripcion 
) as t order by acumulado desc, sistema desc, total desc
";

//echo $consulta."<br>";
		$anterior="nulo";

		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();		
		$tipo="even";
		$contador=0;
		while (! $db->EndOfSeek()) {
			if ($tipo=="even"){
				$tipo="odd";
			}else{
				$tipo="even";
			}

			$row = $db->Row();
			if (($anterior!="nulo")&&($anterior!=$row->sistema)){
			echo '
			</tbody>
			
      		<thead>
			<tr>
				<th colspan="2" style="vertical-align:middle; text-align:left">Subtotal '.$anterior.'</th>
				<th style="vertical-align:middle; text-align:right">'.$contador.'</th>
			</tr>
			</thead>
			';
			$contador=0;
			}
			echo "<tr class='".$tipo."'>";
			echo "<td>".$row->sistema."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->tipo."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->total."</td>";
			
			echo "</tr>";
			$contador=$contador+$row->total;
			$anterior=$row->sistema;
		}
		echo '
			</tbody>
			
      		<thead>
			<tr>
				<th colspan="2" style="vertical-align:middle; text-align:left">Subtotal '.$anterior.'</th>
				<th style="vertical-align:middle; text-align:right">'.$contador.'</th>
			</tr>
			</thead>
			';
	}
	//---------------------------------------------------------------------------------------------------------
	// Listar incidentes usuario
	function DetalleIncidentesPersona($anio, $mes){
		$db = new MySQL();		
		if ($db->Error()) $db->Kill();
		$consulta="
select * from (	
SELECT CONCAT(p.nombre,' ',p.paterno) as nombre, s.descripcion as sistema, t.descripcion as tipo, count(*) as total,
( 
    select count(*) from incidente as i2 
    where i2.codUsuario=i.codUsuario and year(fecapertura)=$anio and month(fecapertura)=$mes limit 1 
)     as acumulado
FROM incidente as i
left join tipoincidente as t on t.codTipoIncidente=i.codTipoIncidente
left join sistema as s on s.codSistema=t.codSistema
left join usuario as u on u.codUsuario=i.codUsuario
left join persona as p on p.codPersona=u.codPersona
where year(fecapertura)=$anio and month(fecapertura)=$mes    
group by CONCAT(p.paterno,' ',p.nombre), s.descripcion , t.descripcion 
) as t order by acumulado desc, nombre desc, total desc
 ";

//echo $consulta."<br>";
		$anterior="nulo";

		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();		
		$tipo="even";
		$contador=0;
		while (! $db->EndOfSeek()) {
			if ($tipo=="even"){
				$tipo="odd";
			}else{
				$tipo="even";
			}

			$row = $db->Row();
			if (($anterior!="nulo")&&($anterior!=$row->nombre)){
			echo '
			</tbody>
			
      		<thead>
			<tr>
				<th colspan="3" style="vertical-align:middle; text-align:left">Subtotal '.$anterior.'</th>
				<th style="vertical-align:middle; text-align:right">'.$contador.'</th>
			</tr>
			</thead>
			';
			$contador=0;
			}
			echo "<tr class='".$tipo."'>";
			echo "<td>".$row->nombre."</td>";
			echo "<td>".$row->sistema."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->tipo."</td>";
			echo "<td style='text-align:right; padding-right:10px;'>".$row->total."</td>";
			
			echo "</tr>";
			$contador=$contador+$row->total;
			
			$anterior=$row->nombre;
		}
		echo '
			</tbody>
			
      		<thead>
			<tr>
				<th colspan="3" style="vertical-align:middle; text-align:left">Subtotal '.$anterior.'</th>
				<th style="vertical-align:middle; text-align:right">'.$contador.'</th>
			</tr>
			</thead>
			';
	}
	//---------------------------------------------------------------------------------------------------------------------
	// descargar reporte anual a excel
	function ArchivoAnual($anno){
	
		$db = new MySQL();		
		if ($db->Error()) $db->Kill();
		
		$consulta="			
			SELECT codIncidente, DATE_FORMAT( fecapertura,  '%d/%m/%Y %H:%i:%s' ) AS fechaApertura, 
			DATE_FORMAT( fecAsignacion,  '%d/%m/%Y %H:%i:%s' ) AS fechaAsignacion, 
			DATE_FORMAT( fecCompromiso, '%d/%m/%Y %H:%i:%s' ) AS fechaCompromiso,
			DATE_FORMAT( fecCerrado,  '%d/%m/%Y %H:%i:%s' ) AS fechaCerrado, i.descripcion, 
			CASE WHEN cerrado =1 THEN  'cerrado' ELSE  'abierto' END AS cerrado,  
			CONCAT( pu.nombre,  ' ', pu.paterno ) AS usuario,
			CONCAT( ps.nombre,  ' ', ps.paterno ) AS soporte, e.descripcion AS estado, 
			NULLIF(t.descripcion,'') AS tipoincidente, 
			sis.descripcion AS sistema
			FROM incidente AS i
			LEFT JOIN usuario AS u ON u.codUsuario = i.codusuario
			LEFT JOIN persona AS pu ON pu.codPersona = u.codPersona
			LEFT JOIN soporte AS s ON s.codSoporte = i.codSoporte
			LEFT JOIN persona AS ps ON ps.codPersona = s.codPersona
			LEFT JOIN tipoincidente AS t ON t.codTipoIncidente = i.codTipoIncidente
			LEFT JOIN sistema AS sis ON sis.codSistema = t.codSistema
			LEFT JOIN estado AS e ON e.codEstado = i.codEstado
			WHERE YEAR( i.fecapertura ) =".$anno."
			LIMIT 0 , 30
		";
		
		$xls = new ExcelWriter();
		
		$xls_int = array('type'=>'int');
		$xls_date = array('type'=>'string');
		
		// obtengo los datos en un array
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();		
		
		// preparo los encabezados de la tabla
		$arr = array('Cod Incidente','Fecha Apertura','Fecha Asignacion','Fecha Compromiso','Fecha Cierre','Descripcion','Cerrado','Usuario','Soporte','Estado','Tipo Incidente','Sistema');
		// Agrego los encabezados a la tabla
		$xls->OpenRow();
		foreach($arr as $cod=>$val)	$xls->NewCell($val,false,array('bold'=>true));
		$xls->CloseRow();
		// inserto los datos fila por fila
		while (!$db->EndOfSeek()) {
			$row = $db->Row();			
			$xls->OpenRow();				
				$xls->NewCell($row->codIncidente, false, $xls_int);
				$xls->NewCell($row->fechaApertura,false,$xls_date);
				$xls->NewCell($row->fechaAsignacion,false,$xls_date);
				$xls->NewCell($row->fechaCompromiso,false,$xls_date);
				$xls->NewCell($row->fechaCerrado,false,$xls_date);
				$xls->NewCell($row->descripcion,false); //Auto alineado
				$xls->NewCell($row->cerrado,false); //Auto alineado
				$xls->NewCell($row->usuario,false); //Auto alineado
				$xls->NewCell($row->soporte,false); //Auto alineado
				$xls->NewCell($row->estado,false); //Auto alineado
				$xls->NewCell($row->tipoincidente,false); //Auto alineado
				$xls->NewCell($row->sistema,false); //Auto alineado 
			$xls->CloseRow();
		}
		$xls->GetXLS();
	}
	
}
?>