<?php
include_once("../clases/mysql.class.php");
require_once("../clases/mail.php");
require_once("../clases/usuario.php");

class PlanTrabajo{
//***********************************************************************************
    public function Atrasados($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();



		$iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $osiris= $iUsuario->obtenerOsiris();
          

        $consulta="
SELECT 'P' as TipoRenovacion,'Prospecto' as tipo, codProspecto, case when esEmpresa=0 then concat(PrimerNombre,' ',PrimerApellido) else nombre end as nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, contacto, sema, '' as poliza from (
select p.PrimerNombre,p.PrimerApellido,p.esEmpresa,p.codProspecto, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto, p.semaforo as sema,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias
from prospecto as p
left join (
	select codProspecto, max(codSeguimiento) as codSeguimiento
	from seguimiento
	where codProspecto in (
		select p.codProspecto from prospecto as p where estado=1
	)
	group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
where estado=1 and codUsuario=$codUsuario
) as consulta
where estado='Pendiente' and dias>0 

union all

select tab.codTipoRenovacion as TipoRenovacion,'Renovación' as tipo,  tab.codRenovacion,tab.nombreTomador,date_format(tab.fechaProxContacto,'%d-%m-%Y'),tab.dias,tab.descripcion,tab.interes,tab.poliza from (SELECT  ren.codTipoRenovacion,ren.codRenovacion,ren.nombreTomador,ren.poliza,tp.descripcion,seg.fechaProxContacto,DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias, DATEDIFF(date(ren.finVigencia),CURRENT_DATE) as interes  FROM seguimientoRenovacion seg left join renovacion ren on seg.codRenovacion = ren.codRenovacion left join persona per on ren.codigoIntermediario = per.sapSlpCode
 left join tipo_contacto tp on seg.codTipoContacto = tp.codTipoContacto  where ren.codEstadoProspecto=1 and ren.codigoIntermediario='".$osiris."' and seg.completado !=1 group by seg.codSeguimiento ) as tab  where tab.dias>0

 order by dias desc


";
		if (! $db->Query($consulta)) $db->Kill();
		return $db;
				
	}


	    public function Atrasados2($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $consulta="
select codProspecto, case when esEmpresa=0 then concat(PrimerNombre,' ',PrimerApellido) else nombre end as nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, contacto, sema from (
select p.PrimerNombre,p.PrimerApellido,p.esEmpresa,p.codProspecto, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto, p.semaforo as sema,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias
from prospecto as p
left join (
	select codProspecto, max(codSeguimiento) as codSeguimiento
	from seguimiento
	where codProspecto in (
		select p.codProspecto from prospecto as p where estado=1
	)
	group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
where estado=1 and codUsuario=$codUsuario
) as consulta
where estado='Pendiente' and dias>0 order by dias desc
";
		if (! $db->Query($consulta)) $db->Kill();
		return $db;
				
	}
//***********************************************************************************    
     public function Hoy($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();

		$iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $osiris= $iUsuario->obtenerOsiris();


        $consulta="
SELECT 'P' as TipoRenovacion,'Prospecto' as tipo, codProspecto, case when esEmpresa=0 then concat(PrimerNombre,' ',PrimerApellido) else nombre end as nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, contacto, sema, '' as poliza from (
select p.PrimerNombre,p.PrimerApellido,p.esEmpresa,p.codProspecto, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto, p.semaforo as sema,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias
from prospecto as p
left join (
	select codProspecto, max(codSeguimiento) as codSeguimiento
	from seguimiento
	where codProspecto in (
		select p.codProspecto from prospecto as p where estado=1
	)
	group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
where estado=1 and codUsuario=$codUsuario
) as consulta
where estado='Pendiente' and dias=0 

union all

select tab.codTipoRenovacion as TipoRenovacion,'Renovación' as tipo,  tab.codRenovacion,tab.nombreTomador,date_format(tab.fechaProxContacto,'%d-%m-%Y'),tab.dias,tab.descripcion,tab.interes,tab.poliza from (SELECT  ren.codTipoRenovacion,ren.codRenovacion,ren.poliza,ren.nombreTomador,tp.descripcion,seg.fechaProxContacto,DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias, DATEDIFF(date(ren.finVigencia),CURRENT_DATE) as interes FROM seguimientoRenovacion seg left join renovacion ren on seg.codRenovacion = ren.codRenovacion left join persona per on ren.codigoIntermediario = per.sapSlpCode
 left join tipo_contacto tp on seg.codTipoContacto = tp.codTipoContacto  where ren.codEstadoProspecto=1 and ren.codigoIntermediario='".$osiris."' and seg.completado !=1 group by seg.codSeguimiento ) as tab  where tab.dias=0

 order by dias desc

";
		if (! $db->Query($consulta)) $db->Kill();
		return $db;
				
	}



	     public function Hoy2($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $consulta="
select codProspecto, nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, contacto, sema from (
select p.codProspecto, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto, p.semaforo as sema,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias
from prospecto as p
left join (
	select codProspecto, max(codSeguimiento) as codSeguimiento
	from seguimiento
	where codProspecto in (
		select p.codProspecto from prospecto as p where estado=1
	)
	group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
where estado=1 and codUsuario=$codUsuario
) as consulta
where estado='Pendiente' and dias=0
";
		if (! $db->Query($consulta)) $db->Kill();
		return $db;
				
	}
//***********************************************************************************    
     public function Proximos($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();


			$iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $osiris= $iUsuario->obtenerOsiris();


        $consulta="
SELECT 'P' as TipoRenovacion,'Prospecto' as tipo, codProspecto, case when esEmpresa=0 then concat(PrimerNombre,' ',PrimerApellido) else nombre end as nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, contacto, sema, '' as poliza from (
select p.PrimerNombre,p.PrimerApellido,p.esEmpresa,p.codProspecto, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto, p.semaforo as sema,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias
from prospecto as p
left join (
	select codProspecto, max(codSeguimiento) as codSeguimiento
	from seguimiento
	where codProspecto in (
		select p.codProspecto from prospecto as p where estado=1
	)
	group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
where estado=1 and codUsuario=$codUsuario
) as consulta
where estado='Pendiente' and dias<0 

union all

select tab.codTipoRenovacion as TipoRenovacion,'Renovación' as tipo,  tab.codRenovacion,tab.nombreTomador,date_format(tab.fechaProxContacto,'%d-%m-%Y'),tab.dias,tab.descripcion,tab.interes,tab.poliza from (SELECT  ren.codTipoRenovacion,ren.codRenovacion,ren.poliza,ren.nombreTomador,tp.descripcion,seg.fechaProxContacto,DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias, DATEDIFF(date(ren.finVigencia),CURRENT_DATE) as interes FROM seguimientoRenovacion seg left join renovacion ren on seg.codRenovacion = ren.codRenovacion left join persona per on ren.codigoIntermediario = per.sapSlpCode
 left join tipo_contacto tp on seg.codTipoContacto = tp.codTipoContacto  where ren.codEstadoProspecto=1 and ren.codigoIntermediario='".$osiris."' and seg.completado !=1 group by seg.codSeguimiento ) as tab  where tab.dias<0

 order by dias desc

"; 
		if (! $db->Query($consulta)) $db->Kill();
		return $db;
				
	}

    public function Proximos2($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $consulta="
SELECT codProspecto, nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, contacto, sema from (
select p.codProspecto, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto, p.semaforo as sema,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias
from prospecto as p
left join (
	select codProspecto, max(codSeguimiento) as codSeguimiento
	from seguimiento
	where codProspecto in (
		select p.codProspecto from prospecto as p where estado=1
	)
	group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
where estado=1 and codUsuario=$codUsuario
) as consulta
where estado='Pendiente' and dias<0 order by dias asc
"; 
		if (! $db->Query($consulta)) $db->Kill();
		return $db;
				
	}


//***********************************************************************************    
     public function SinSeguimiento($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();


			$iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $osiris= $iUsuario->obtenerOsiris();


        $consulta="
SELECT 'P' as TipoRenovacion,'Prospecto' as tipo, codProspecto, case when esEmpresa=0 then concat(PrimerNombre,' ',PrimerApellido) else nombre end as nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, contacto, sema, '' as poliza from (
select p.PrimerNombre,p.PrimerApellido,p.esEmpresa,p.codProspecto, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto, p.semaforo as sema,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias
from prospecto as p
left join (
	select codProspecto, max(codSeguimiento) as codSeguimiento
	from seguimiento
	where codProspecto in (
		select p.codProspecto from prospecto as p where estado=1
	)
	group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
where estado=1 and codUsuario=$codUsuario
) as consulta
where estado='Finalizado' and dias>0 
UNION ALL
select tab.codTipoRenovacion as TipoRenovacion,'Renovación' as tipo,  tab.codRenovacion,tab.nombreTomador,date_format(tab.fechaFinContacto,'%d-%m-%Y'),tab.dias,tab.descripcion,tab.interes as interes,tab.poliza from (SELECT ren.codTipoRenovacion,ren.codRenovacion,ren.nombreTomador,ren.poliza,tp.descripcion,seg.fechaFinContacto,DATEDIFF(SYSDATE(), fechaFinContacto) as dias, DATEDIFF(date(ren.finVigencia),CURRENT_DATE) as interes  from seguimientoRenovacion seg left join renovacion ren on ren.codRenovacion= seg.codRenovacion left join tipo_contacto tp on seg.codTipoContacto=tp.codTipoContacto where ren.codEstadoProspecto=1 and ren.codigoIntermediario='".$osiris."'  and seg.completado=1 order by seg.codSeguimiento desc limit 1) as tab where tab.dias > 0
";
		if (! $db->Query($consulta)) $db->Kill();
		return $db;
				
	}

	     public function SinSeguimiento2($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $consulta="
select codProspecto, nombre, date_format(fecha,'%d-%m-%Y') as fecha, dias, contacto, sema from (
select p.codProspecto, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto, p.semaforo as sema,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias
from prospecto as p
left join (
	select codProspecto, max(codSeguimiento) as codSeguimiento
	from seguimiento
	where codProspecto in (
		select p.codProspecto from prospecto as p where estado=1
	)
	group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
where estado=1 and codUsuario=$codUsuario
) as consulta
where estado='Finalizado' and dias>3 order by dias desc
";
		if (! $db->Query($consulta)) $db->Kill();
		return $db;
				
	}
    //***********************************************************************************    
    public function TotalProspectosCopia($codUsuario){

    	$iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $osiris= $iUsuario->obtenerOsiris();
    	
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="
select sum(tab.total) as total from (select count(p.codProspecto) as total 
from prospecto as p
where estado=1 and codUsuario=$codUsuario
union ALL
select count(r.codRenovacion) as total from renovacion as r  inner join seguimientoRenovacion seg on r.codRenovacion=seg.codRenovacion where r.codigoIntermediario = '".$osiris."' and seg.completado != 1
union all

) as tab

";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }

    public function TotalProspectos($codUsuario){

    	$iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $osiris= $iUsuario->obtenerOsiris();
    	
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="
select sum(tab.total) as total from (select count(p.codProspecto) as total 
from prospecto as p
where estado=1 and codUsuario=$codUsuario
union ALL
select count(r.codRenovacion) as total from renovacion as r where r.codEstadoProspecto=1 and r.codigoIntermediario = '".$osiris."'
) as tab

";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }

    public function TotalProspectos2($codUsuario){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="
select count(p.codProspecto) as total 
from prospecto as p
where estado=1 and codUsuario=$codUsuario

";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }
}
?>