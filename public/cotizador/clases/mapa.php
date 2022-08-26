<?php
require_once "../clases/mysql.class.php";

class mapa{

	function PuntosProspectosByOficina($oficinas, $origen, $estado) {
		$db = new MySQL();
		$extra = '';
		$c = 0;
		if (sizeof($oficinas) > 0) {
			foreach ($oficinas as $codOficina) {
				$c++;
				if ($c == 1) {
					$extra .= 'WHERE u.codOficina in ('.$codOficina;
				} else {
					$extra .= ','.$codOficina;
				}
			}
			$extra .= ')';
		}

		if ($origen != NULL || $origen != '') {
			$c++;
			if ($c == 1) {
				$extra .= 'WHERE ';
			} else {
				$extra .= ' AND ';
			}
			$extra .= 'p.codOrigenProspecto = \''.$origen.'\'';
		}

		if ($estado != NULL || $estado != '') {
			$c++;
			if ($c == 1) {
				$extra .= 'WHERE ';
			} else {
				$extra .= ' AND ';
			}
			$extra .= 'p.estado = \''.$estado.'\'';
		}

		$generalView = 'SELECT p.codProspecto, p.nombre, p.latitud, p.longitud, p.estado, p.codUsuario, per.nombre as pnombre, per.apePat, per.apeMat, e.descripcion FROM prospecto as p LEFT JOIN usuario as u ON u.codUsuario = p.codUsuario LEFT JOIN persona as per ON per.codPersona = u.codPersona LEFT JOIN estado_prospecto as e ON e.codEstadoProspecto = p.estado LEFT JOIN origen_prospecto as o ON o.codOrigenProspecto = p.codOrigenProspecto '.$extra;

		if ($db->Error()) {
			$db->Kill();
			return false;
		} else {
			$db->Query($generalView);
			return $db;
		}
	}

	function PuntosProspectos2($codOrigenProspecto, $vendedor, $estado) {
		$db = new MySQL();
		$conditions = NULL;

		if ($estado != '') {
			$conditions['p.estado'] = $estado;
		}

        if ($vendedor != '') {
            $conditions['p.codUsuario'] = $vendedor;
        }

        if ($codOrigenProspecto != '') {
            $conditions['p.codOrigenProspecto'] = $codOrigenProspecto;
        }


        $extraQuery = '';
        $i = 1;
        foreach ($conditions as $column=>$value) {
            if ($i == 1) {
                $extraQuery .= 'WHERE '.$column.' = \''.$value.'\'';
            } else {
                $extraQuery .= ' AND '.$column.' = \''.$value.'\'';
            }
        }

        $generalView = 'SELECT p.codProspecto, p.nombre, p.latitud, p.longitud, p.estado, p.codUsuario, per.nombre as pnombre, per.apePat, per.apeMat, e.descripcion FROM prospecto as p LEFT JOIN usuario as u ON u.codUsuario = p.codUsuario LEFT JOIN persona as per ON per.codPersona = u.codPersona LEFT JOIN estado_prospecto as e ON e.codEstadoProspecto = p.estado LEFT JOIN origen_prospecto as o ON o.codOrigenProspecto = p.codOrigenProspecto '.$extraQuery;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
			$db->Query($generalView);
			return $db;
        }
	}
//*********************************************************************************

    function PuntosProductosVendidos($oficina,$canal,$equipo,$vendedor,$estado) {
        $db = new MySQL();
        $condicion = '';


             if($estado !='' && $estado!=3 && $estado!=2){
        $condicion.=" and ( producto_detalle.estado='$estado' )";
    }
    else
         {
            if($estado==3)
            {
             $condicion="and producto_detalle.estado is NULL";
            }
            else
                if($estado==2)
                {
                    $condicion="";
                }
         }
       

         if($oficina != '' && $oficina !=0){
        $condicion.=" and ( usuario.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( usuario.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (usuario.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (usuario.codUsuario='$ejecutivo')";
    }


        // $extraQuery = '';
        // $i = 1;
        // foreach ($conditions as $column=>$value) {
        //     if ($i == 1) {
        //         $extraQuery .= 'WHERE '.$column.' = \''.$value.'\'';
        //     } else {
        //         $extraQuery .= ' AND '.$column.' = \''.$value.'\'';
        //     }
        // }

        $generalView = "SELECT producto_detalle.codProductoDetalle as codigo, producto.nombre as nombre,producto_detalle.latitud as latitud,producto_detalle.longitud as longitud,producto_detalle.estado as estado,prospecto.codProspecto as codProspecto from producto_detalle LEFT JOIN prospecto on producto_detalle.codProspecto= prospecto.codProspecto LEFT JOIN usuario on usuario.codUsuario =prospecto.codUsuario LEFT JOIN Salon on usuario.codSalon = Salon.codSalon LEFT JOIN oficina on oficina.codOficina = usuario.codOficina LEFT JOIN producto on producto.codProducto=producto_detalle.codProducto WHERE producto_detalle.latitud !=''  $condicion";

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            $db->Query($generalView);
            return $db;
        }
    }


//***************************************************************************************
    function PuntosProspectos($codUsuario, $vdesde, $vhasta, $origen, $estado, $vendedor){

        if ($desde!=""){
		  $vdesde=$this->convertir_fecha1($desde);
        }

        if ($hasta!=""){
		  $vhasta=$this->convertir_fecha2($hasta);
        }

        $condicion="";
        if (@$vdesde!=""){

        }

        if (@$vhasta!=""){

        }
        if ($codUsuario!=""){
            $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $perfil= $iUsuario->obtenerPerfil();
            if (($perfil=="Vendedor")||($perfil=="Operaciones")){
                $condicion.=" and p.codUsuario=$codUsuario ";
            }
            if ($perfil=="Jefatura"){
                $condicion.=" and p.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codUsuario')) ";
            }

        }else{
             $condicion.=" and p.codUsuario=0";
            //echo "perfil usuario ".$codUsuario."<hr>";
        }
        if ($origen!=""){
            $condicion.=" and p.codOrigenProspecto=$origen ";
        }
        if ($estado!=""){
            $condicion.=" and p.estado=$estado ";

        }else{ //RAMS
            $condicion.=" and p.estado!='3' "; // 3 = ELIMINADO
        }
        if($vendedor!=""){
            $condicion.=" and p.codUsuario=$vendedor ";
        }


		$consulta="

select tp.*
from (
SELECT p.codProspecto, p.nombre, p.latitud, p.longitud,
case when pe.nombre is null then '' else pe.nombre end + ' ' +
case when pe.apePat is null then '' else pe.apePat end as ejecutivo,
e.descripcion as estado, DATE_FORMAT(p.fechaCreacion,'%d-%m-%Y') as fecha
from prospecto  as p
left join usuario as u on u.codUsuario=p.codUsuario
left  join persona as pe on pe.codPersona=u.codPersona
left join estado_prospecto as e on e.codEstadoProspecto=p.estado
where latitud is not null and longitud is not null
) as tp

		";
       //echo $consulta."<hr>";
        $db = new MySQL();
		if ($db->Error()){
			$db->Kill();
			return "vacio";
		}else{
			if (! $db->Query($consulta)) {
				$db->Kill();
				return false;
			}else{

				return $db;

			}
		}
        return false;
	}

//***************************************************************************************
    function convertir_fecha1($fecha)  // Convierte fecha de 31/12/2011 a 2011/12/31
    {
        $day=substr($fecha,0,2);
        $month=substr($fecha,3,2);
        $year=substr($fecha,6,4);
        $fechaval = $year."/".$month."/".$day." 00:00:00";
        return $fechaval;
    }
//***************************************************************************************
    function convertir_fecha2($fecha)  // Convierte fecha de 31/12/2011 a 2011/12/31
    {
        $day=substr($fecha,0,2);
        $month=substr($fecha,3,2);
        $year=substr($fecha,6,4);
        $fechaval = $year."/".$month."/".$day." 23:59:59";
        return $fechaval;
    }
//***************************************************************************************
    }
?>
