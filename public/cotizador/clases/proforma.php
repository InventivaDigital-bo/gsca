<?php

require_once "../clases/mysql.class.php";
//require_once "../clases/mail.php";

class Proforma{
    function Cabecera($codigo){
        $consulta="select cot.descripcion AS cotizacio, pr.nombre, pr.telefono, pr.email, pr.telefonoContacto, 
CONCAT(per.nombre, ' ', per.apePat) as ejecutivo, o.descripcion as local,
o.direccion as direccionlocal, o.ciudad as ciudad, o.telefono as telefonolocal,
DATE_FORMAT(SYSDATE(), '%d/%m/%Y') as fecha, o.logo as imagenempresa, cot.superficie,
per.telefono as telfejecutivo, per.correo as correoejecutivo, cot.superficieMedida,
pr.codProspecto, cot.codCabCotiza, cot.total, cot.material, cot.manoobra, cot.otros, cot.codEstado
from prospecto as pr
left join usuario as u on u.codUsuario=pr.codUsuario
left join persona as per on per.codPersona=u.codPersona
left join oficina as o on o.codOficina=u.codOficina
left join tp_cabecera_cotizacion as cot on cot.codProspecto=pr.codProspecto
where cot.codCabCotiza=".$codigo;

        $db= new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "0";
		}

        $db->Query($consulta);
        if ($db->RowCount()>0){
            $db->MoveFirst();
            $dato=$db->Row();
            return $dato;
        }
        return "";
    }
    //************************************************************************************
    function Detalle($codigo){
        $consulta="SELECT et.* FROM especificacion_tecnica as et
inner join vehiculo_prospecto as vp on vp.codModelo=et.codModelo and vp.codTipo=et.codTipo and vp.codSubTipo=et.codSubTipo  and vp.anioComercial=et.gestion
where vp.codVehiculoProspecto=".$codigo." and et.baja='0' order by titulo, nombre";

        $db= new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "0";
		}

        $db->Query($consulta);
        return $db;
    }
    //***********************************************************************************
    function FormasPago($codigo){
        $consulta="select f.descripcion as formapago, fp.monto
from forma_pago_prospecto as fp
left join forma_pago as f on f.codFormaPago=fp.codFormaPago
where fp.codVehiculoProspecto=$codigo and fp.baja='0' and fp.monto>0";

        $db= new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "0";
		}

        $db->Query($consulta);
        return $db;
    }

}

?>
