 <?php
require_once "../clases/mysql.class.php";
require_once "../clases/usuario.php";

class Reportes{

  public function emailRetrasados() {
    $db = new MySQL();

    if ($db->Error()) {
        $db->Kill();
        return false;
    } else {
        $consulta = 'SELECT seg.codProspecto, per.*  FROM seguimiento AS seg LEFT JOIN prospecto AS p ON p.codProspecto = seg.codProspecto LEFT JOIN usuario AS u ON u.codUsuario = p.codUsuario LEFT JOIN persona AS per ON per.codPersona = u.codPersona WHERE p.estado = 1 AND seg.fechaProxContacto < \''.date('Y-m-d H:i:s').'\' AND seg.fechaFinContacto IS NULL AND seg.completado = 0 AND seg.codTIpoContacto != 1';

        if ($db->HasRecords($consulta)) {
            $db->Query($consulta);
            $array = NULL;
            while(!$db->EndOfSeek()) {
                $data = $db->Row();
                $row = array(
                  'codProspecto'  => $data->codProspecto,
                  'vendedor'      => $data->nombre.' '.$data->apePat.' '.$data->apeMat,
                  'email'         => $data->correo
                );
                $array[] = $row;
            }
            return $array;
        }

        return false;
    }

  }

	public function getAllProspectosCerrados($sProyecto_nm = NULL, $sCliente_nm = NULL, $dtStart_date = NULL, $dtEnd_date = NULL, $codUsuario = NULL, $codOficina = NULL) {
    $conditions = '';
    $join = '';

    if ($sProyecto_nm != NULL) {
      $conditions .= 'AND pr.nombreObra LIKE \'%'.$sProyecto_nm.'%\'';
    }

    if ($sCliente_nm != NULL) {
      $conditions .= 'AND pr.nombre LIKE \'%'.$sCliente_nm.'%\'';
    }

    if ($dtStart_date != NULL && $dtEnd_date != NULL) {
      if ($dtStart_date != '') {
        $dtStart_date = strtotime($dtStart_date);
        $dtEnd_date = strtotime($dtEnd_date);
        $dtStart_date = date('Y-m-d',$dtStart_date);
        $dtEnd_date = date('Y-m-d',$dtEnd_date);

        if ($dtStart_date == $dtEnd_date) {
          $conditions .= 'AND pr.fechaCreacion BETWEEN \''.$dtStart_date.' 00:00:00\' AND \''.$dtStart_date.' 23:59:59\'';
        } else {
          $conditions .= 'AND pr.fechaCreacion BETWEEN \''.$dtStart_date.'\' AND \''.$dtEnd_date.'\' ';
        }

        if ($dtEnd_date == '') {
          $conditions .= 'AND pr.fechaCreacion >= \''.$dtStart_date.'\' ';
        }
      }
    }

    if ($codUsuario != NULL) {
      $conditions .= 'AND pr.codUsuario = \''.$codUsuario.'\'';
    }

    if ($codOficina != NULL) {
      $conditions .= 'AND u.codOficina = \''.$codOficina.'\'';
    }

			$db = new MySQL();

			if ($db->Error()) {
					$db->Kill();
					return false;
			} else {
					$consulta = 'SELECT pr.*, SUM((cab.total / 6.96)) as total, CONCAT(p.nombre, \' \', p.apePat, \' \', p.apeMat) as asesor FROM prospecto as pr LEFT JOIN usuario as u ON u.codUsuario = pr.codUsuario LEFT JOIN persona as p ON p.codPersona = u.codPersona LEFT JOIN tp_cabecera_cotizacion as cab ON cab.codProspecto = pr.codProspecto AND codEstado = \'4\' WHERE pr.estado = \'2\' '.$conditions.' GROUP BY pr.codProspecto ORDER BY total ASC';

					if ($db->HasRecords($consulta)) {
							$db->Query($consulta);
							$array = NULL;
							while(!$db->EndOfSeek()) {
									$data = $db->Row();
									if ($data->total >= 1000 && $data->total <= 3000) {
										$group = 0;
										$title = 'Operaciones pequeñas (1.000 - 3.000)';
									} else if ($data->total > 3000 && $data->total <= 20000) {
										$group = 1;
										$title = 'Operaciones medianas (3.000 - 20.000)';
									} else if ($data->total > 20000 && $data->total <= 100000) {
										$group = 2;
										$title = 'Operaciones grandes (20.000 - 100.000)';
									} else if ($data->total > 100000) {
										$group = 3;
										$title = 'Mega Obras ( > 100.000)';
									} else {
										$group = NULL;
									}
									if ($group != NULL) {
										if ($array[$group]['title'] == NULL) {
											$array[$group]['title'] = $title;
										}
										$array[$group]['list'][] = $data;
									}
							}
							return $array;
					}

					return false;
			}
	}

	public function getAllVigentes($sProyecto_nm, $sCliente_nm, $ftProbabilidad, $iVendedor_id, $iOficina_id, $iSistConst_id) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
								$conditions = '';
								$conditions2 = '';

								if ($sProyecto_nm != NULL && $sProyecto_nm != '') {
									$conditions .= 'AND nombreObra LIKE \'%'.$sProyecto_nm.'%\' ';
									$conditions2 .= 'AND nombreObra LIKE \'%'.$sProyecto_nm.'%\' ';
								}

								if ($sCliente_nm != NULL && $sCliente_nm != '') {
									$conditions .= 'AND p.nombre LIKE \'%'.$sCliente_nm.'%\' ';
									$conditions2 .= 'AND p.nombre LIKE \'%'.$sCliente_nm.'%\' ';
								}

								if ($sCliente_nm != NULL && $sCliente_nm != '') {
									$conditions .= 'AND p.nombre LIKE \'%'.$sCliente_nm.'%\' ';
									$conditions2 .= 'AND p.nombre LIKE \'%'.$sCliente_nm.'%\' ';
								}

								if ($ftProbabilidad != NULL && $ftProbabilidad != '') {
									$conditions .= 'AND cot.prob = '.number_format($ftProbabilidad, 2).' ';
								}

								if ($iVendedor_id != NULL && $iVendedor_id != '') {
									$conditions .= 'AND p.codUsuario = \''.$iVendedor_id.'\' ';
									$conditions2 .= 'AND p.codUsuario = \''.$iVendedor_id.'\' ';
								}

								if ($iOficina_id != NULL && $iOficina_id != '') {
									$conditions .= 'AND u.codOficina = \''.$iOficina_id.'\' ';
									$conditions2 .= 'AND u.codOficina = \''.$iOficina_id.'\' ';
								}

								if ($iSistConst_id != NULL && $iSistConst_id != '') {
									$conditions .= 'AND cot.codSistProducto = \''.$iSistConst_id.'\' ';
								}

                $consulta = 'SELECT oficina, codProspecto, tamanoObra as tamano, direccionObra as direccion, UPPER(nombreObra) as nombreObra, codTipoVenta, sisc, prob as probabilidad, estado as obs, UPPER(cliente) as cliente, UPPER(vendedor) as vendedor, GROUP_CONCAT(UPPER(descripcion) SEPARATOR \', \') as descrip, (SUM(total)/6.96) as tot, SUM(superficie) as sup, GROUP_CONCAT(superficieMedida SEPARATOR \', \') as supmed, MontoOportunidad
                FROM (SELECT concat(( DATE_FORMAT(case when seg.completado=\'1\' then seg.fechaCompletado else seg.fechaProxContacto end ,\'%d/%m/%Y\')),\' - \', tc.descripcion, \' - \', case when seg.observacion=\'\' then (case when seg.descripcion=\'\' then \'SIN OBSERVACIONES\' else seg.descripcion end) else seg.observacion end) as estado, cot.prob, cot.codTipoVenta, p.codProspecto, p.nombre as cliente, CONCAT(per.nombre, \' \', per.apePat, \' \', per.apeMat) as vendedor, case when sc.descripcion is not null then GROUP_CONCAT(sc.descripcion SEPARATOR \', \') else GROUP_CONCAT(cot.descripcion SEPARATOR \', \') end as descripcion, GROUP_CONCAT(cot.codsistProducto SEPARATOR \', \') as sisc, SUM(cot.total) as total, SUM(cot.superficie) as superficie, GROUP_CONCAT(cot.superficieMedida SEPARATOR \', \') as superficieMedida, p.nombreObra as nombreObra, p.direccionObra, p.tamanoObra, of.descripcion as oficina, p.MontoOportunidad FROM tp_cabecera_cotizacion as cot LEFT JOIN tp_sistema_constructivo as sc ON sc.codSistema = cot.codSistProducto LEFT JOIN prospecto as p ON p.codProspecto = cot.codProspecto LEFT JOIN usuario as u ON u.codUsuario = p.codUsuario LEFT JOIN persona as per ON per.codPersona = u.codPersona LEFT JOIN oficina AS of ON of.codOficina = u.codOficina left join (select max(codSeguimiento) as codSeguimiento, c2.codProspecto from (select * from prospecto where estado=1) as c1 inner join seguimiento as c2 on c2.codProspecto=c1.codProspecto where completado=\'1\' or 1=1 group by codProspecto) as ctrl on ctrl.codProspecto=p.codProspecto left join seguimiento as seg on seg.codSeguimiento=ctrl.codSeguimiento left join tipo_contacto as tc on tc.codTipoContacto=seg.codTipoContacto WHERE cot.codEstado = 1 AND p.estado = 1 '.$conditions.'GROUP BY cot.codProspecto UNION ALL SELECT \'\' as sisc, \'\' as estado, \'\' as prob, \'\' as codTipoVenta, p.codProspecto, p.nombre as cliente, CONCAT(per.nombre, \' \', per.apePat, \' \', per.apeMat) as vendedor, \'COTIZACION VIGUETAS\' as descripcion, SUM(v.ftPrecio_Total) as total, 0.00 as superficie, \'m2\' as superficieMedida, p.nombreObra as nombreObra, p.tamanoObra, p.direccionObra, of.descripcion as oficina, p.MontoOportunidad FROM v_viguetas_cotizacion as v LEFT JOIN prospecto as p ON p.codProspecto = v.codProspecto LEFT JOIN usuario as u ON u.codUsuario = p.codUsuario LEFT JOIN persona as per ON per.codPersona = u.codPersona LEFT JOIN oficina AS of ON of.codOficina = u.codOficina WHERE v.iStatus_fl = \'1\' AND p.estado = \'1\' '.$conditions2.'GROUP BY v.codProspecto) as res group by codProspecto order by tot desc';

								if ($db->HasRecords($consulta)) {
                    $db->Query($consulta);
                    $array = NULL;
                    while(!$db->EndOfSeek()) {
                        $producto = $db->Row();
                        if ($producto->codTipoVenta == 1) {
                        	$producto->codTipoVenta = 'V';
                        } else if ($producto->codTipoVenta == 2) {
                        	$producto->codTipoVenta = 'O';
                        } else {
                        	$producto->codTipoVenta = 'N/A';
                        }
                        $array[] = $producto;
                    }
                    return $array;
                }

                return false;
            }
        }

	function getProspectosWithNoCotizaciones($in, $dtStart_date = NULL, $dtEnd_date = NULL, $iAsesor_id = NULL, $iOficina_id = NULL) {
		$conditions = 'prospecto.codProspecto NOT IN '.$in.' AND prospecto.estado NOT IN (3)';
		if ($dtStart_date != NULL && $dtEnd_date != NULL) {
        	if ($dtStart_date != '') {
        		$dtStart_date = strtotime($dtStart_date);
	        	$dtEnd_date = strtotime($dtEnd_date);
				$dtStart_date = date('Y-m-d',$dtStart_date);
				$dtEnd_date = date('Y-m-d',$dtEnd_date);
				if ($dtStart_date == $dtEnd_date) {
					if ($conditions != '') {
						$conditions .= 'AND ';
					}
					$conditions .= 'fechaCreacion BETWEEN \''.$dtStart_date.' 00:00:00\' AND \''.$dtStart_date.' 23:59:59\'';
				} else {
					if ($conditions != '') {
						$conditions .= 'AND ';
					}
					$conditions .= 'fechaCreacion BETWEEN \''.$dtStart_date.'\' AND \''.$dtEnd_date.'\' ';
				}

				if ($dtEnd_date == '') {
					if ($conditions != '') {
						$conditions .= 'AND ';
					}
					$conditions .= 'fechaCreacion >= \''.$dtStart_date.'\' ';
				}
        	}
        }

        if ($iAsesor_id != NULL) {
        	if ($conditions != '') {
						$conditions .= 'AND ';
					}
        	$conditions .= 'prospecto.codUsuario = \''.$iAsesor_id.'\' ';
        }

        if ($iOficina_id != NULL) {
        	if ($conditions != '') {
						$conditions .= 'AND ';
					}
        	$conditions .= 'usuario.codOficina = \''.$iOficina_id.'\' ';
        }

		$db = new MySQL();

        $generalView = 'SELECT prospecto.*, date_format(prospecto.fechaCreacion,\'%d-%m-%Y\') as fechaCreacion, CONCAT(persona.nombre, \' \', persona.apePat) as nombrePersona, estado_prospecto.descripcion as pEstado FROM prospecto LEFT JOIN usuario ON usuario.codUsuario = prospecto.codUsuario LEFT JOIN persona ON persona.codPersona = usuario.codPersona LEFT JOIN estado_prospecto ON estado_prospecto.codEstadoProspecto = prospecto.estado WHERE '.$conditions.' GROUP BY prospecto.codProspecto';

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query($generalView);
                return $db;
            } else {
                return false;
            }
        }
	}

	function listAllProspectByDates($dtStart_date = NULL, $dtEnd_date = NULL, $iAsesor_id = NULL, $iOficina_id = NULL) {
        $db = new MySQL();
        $conditions = 'WHERE prospecto.estadoReserva="1" ';
        if ($dtStart_date != NULL && $dtEnd_date != NULL) {
        	if ($dtStart_date != '') {
        		$dtStart_date = strtotime($dtStart_date);
	        	$dtEnd_date = strtotime($dtEnd_date);
				$dtStart_date = date('Y-m-d',$dtStart_date);
				$dtEnd_date = date('Y-m-d',$dtEnd_date);
				if ($dtStart_date == $dtEnd_date) {
					if ($conditions != '') {
						$conditions .= 'AND ';
					}
					$conditions .= 'fechaReserva BETWEEN \''.$dtStart_date.' 00:00:00\' AND \''.$dtStart_date.' 23:59:59\'';
				} else {
					if ($conditions != '') {
						$conditions .= 'AND ';
					}
					$conditions .= 'fechaReserva BETWEEN \''.$dtStart_date.'\' AND \''.$dtEnd_date.'\' ';
				}

				if ($dtEnd_date == '') {
					if ($conditions != '') {
						$conditions .= 'AND ';
					}
					$conditions .= 'fechaReserva >= \''.$dtStart_date.'\' ';
				}
        	}
        }

        if ($iAsesor_id != NULL) {
        	if ($conditions != '') {
						$conditions .= 'AND ';
					}
        	$conditions .= 'prospecto.codUsuario = \''.$iAsesor_id.'\' ';
        }

        if ($iOficina_id != NULL) { 
        	if ($conditions != '') {
						$conditions .= 'AND ';
					}
        	$conditions .= 'usuario.codOficina = \''.$iOficina_id.'\' ';
        }

        $data = 'SELECT prospecto.*, date_format(prospecto.fechaCreacion,\'%d-%m-%Y\') as fechaCreacion, date_format(prospecto.fechaReserva,\'%d-%m-%Y\') as fechaReserva, CONCAT(persona.nombre, \' \', persona.apePat) as nombrePersona 
        FROM prospecto 
        LEFT JOIN usuario ON usuario.codUsuario = prospecto.codUsuario 
        LEFT JOIN persona ON persona.codPersona = usuario.codPersona '.$conditions.' order by prospecto.fechaReserva desc'; 
     //  echo $data; die();
        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($data)) {
                $db->Query($data);
                return $db;
            } else {
                return false;
            }
        }
    }

    function Sucursales($gestion, $codigo){
        //--------------------------------------------------------------------------------
        $condicion="";
        $iUsuario = new Usuario();
        $iUsuario->RecuperarSesionCod($codigo);
        $perfil= $iUsuario->obtenerPerfil();
        if ($perfil=="Jefatura"){
                    $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
        }
        //--------------------------------------------------------------------------------
        $db = new MySQL();
		//obtener codigo de vehiculo
		$consulta="
select oficina, vendedor, marca, codVendedor, codMarca,
sum(abiertosEnero) as abiertosEnero, sum(asignadosEnero) as asignadosEnero,
sum(pendientesEnero) as pendientesEnero, sum(cerradosEnero) as cerradosEnero,
sum(abiertosFebrero) as abiertosFebrero, sum(asignadosFebrero) as asignadosFebrero,
sum(pendientesFebrero) as pendientesFebrero, sum(cerradosFebrero) as cerradosFebrero,
sum(abiertosMarzo) as abiertosMarzo, sum(asignadosMarzo) as asignadosMarzo,
sum(pendientesMarzo) as pendientesMarzo, sum(cerradosMarzo) as cerradosMarzo,
sum(abiertosAbril) as abiertosAbril, sum(asignadosAbril) as asignadosAbril,
sum(pendientesAbril) as pendientesAbril, sum(cerradosAbril) as cerradosAbril,
sum(abiertosMayo) as abiertosMayo, sum(asignadosMayo) as asignadosMayo,
sum(pendientesMayo) as pendientesMayo, sum(cerradosMayo) as cerradosMayo,
sum(abiertosJunio) as abiertosJunio, sum(asignadosJunio) as asignadosJunio,
sum(pendientesJunio) as pendientesJunio, sum(cerradosJunio) as cerradosJunio,
sum(abiertosJulio) as abiertosJulio, sum(asignadosJulio) as asignadosJulio,
sum(pendientesJulio) as pendientesJulio, sum(cerradosJulio) as cerradosJulio,
sum(abiertosAgosto) as abiertosAgosto, sum(asignadosAgosto) as asignadosAgosto,
sum(pendientesAgosto) as pendientesAgosto, sum(cerradosAgosto) as cerradosAgosto,
sum(abiertosSeptiembre) as abiertosSeptiembre, sum(asignadosSeptiembre) as asignadosSeptiembre,
sum(pendientesSeptiembre) as pendientesSeptiembre, sum(cerradosSeptiembre) as cerradosSeptiembre,
sum(abiertosOctubre) as abiertosOctubre, sum(asignadosOctubre) as asignadosOctubre,
sum(pendientesOctubre) as pendientesOctubre, sum(cerradosOctubre) as cerradosOctubre,
sum(abiertosNoviembre) as abiertosNoviembre, sum(asignadosNoviembre) as asignadosNoviembre,
sum(pendientesNoviembre) as pendientesNoviembre, sum(cerradosNoviembre) as cerradosNoviembre,
sum(abiertosDiciembre) as abiertosDiciembre, sum(asignadosDiciembre) as asignadosDiciembre,
sum(pendientesDiciembre) as pendientesDiciembre, sum(cerradosDiciembre) as cerradosDiciembre
from (
	select oficina, vendedor, marca,
	case when mes=1 then 1 else 0 end as abiertosEnero,
	case when codVehiculo is not null and mes=1 then 1 else 0 end as asignadosEnero,
    case when codVehiculo is not null and mes=1 and codEstado=2 then 1 else 0 end as cerradosEnero,
    case when codVehiculo is not null and mes=1 and codEstado=1 then 1 else 0 end as pendientesEnero,
	case when mes=2 then 1 else 0 end as abiertosFebrero,
	case when codVehiculo is not null and mes=2 then 1 else 0 end as asignadosFebrero ,
    case when codVehiculo is not null and mes=2 and codEstado=2 then 1 else 0 end as cerradosFebrero ,
    case when codVehiculo is not null and mes=2 and codEstado=1 then 1 else 0 end as pendientesFebrero ,
	case when mes=3 then 1 else 0 end as abiertosMarzo,
	case when codVehiculo is not null and mes=3 then 1 else 0 end as asignadosMarzo ,
    case when codVehiculo is not null and mes=3 and codEstado=2 then 1 else 0 end as cerradosMarzo ,
    case when codVehiculo is not null and mes=3 and codEstado=1 then 1 else 0 end as pendientesMarzo ,
	case when mes=4 then 1 else 0 end as abiertosAbril,
	case when codVehiculo is not null and mes=4 then 1 else 0 end as asignadosAbril,
    case when codVehiculo is not null and mes=4 and codEstado=2 then 1 else 0 end as cerradosAbril,
    case when codVehiculo is not null and mes=4 and codEstado=1 then 1 else 0 end as pendientesAbril,
	case when mes=5 then 1 else 0 end as abiertosMayo,
	case when codVehiculo is not null and mes=5 then 1 else 0 end as asignadosMayo,
    case when codVehiculo is not null and mes=5 and codEstado=2 then 1 else 0 end as cerradosMayo,
    case when codVehiculo is not null and mes=5 and codEstado=1 then 1 else 0 end as pendientesMayo,
	case when mes=6 then 1 else 0 end as abiertosJunio,
	case when codVehiculo is not null and mes=6 then 1 else 0 end as asignadosJunio,
    case when codVehiculo is not null and mes=6 and codEstado=2 then 1 else 0 end as cerradosJunio,
    case when codVehiculo is not null and mes=6 and codEstado=1 then 1 else 0 end as pendientesJunio,
	case when mes=7 then 1 else 0 end as abiertosJulio,
	case when codVehiculo is not null and mes=7 then 1 else 0 end as asignadosJulio,
    case when codVehiculo is not null and mes=7 and codEstado=2 then 1 else 0 end as cerradosJulio,
    case when codVehiculo is not null and mes=7 and codEstado=1 then 1 else 0 end as pendientesJulio,
	case when mes=8 then 1 else 0 end as abiertosAgosto,
	case when codVehiculo is not null and mes=8 then 1 else 0 end as asignadosAgosto,
    case when codVehiculo is not null and mes=8 and codEstado=2 then 1 else 0 end as cerradosAgosto,
    case when codVehiculo is not null and mes=8 and codEstado=1 then 1 else 0 end as pendientesAgosto,
	case when mes=9 then 1 else 0 end as abiertosSeptiembre,
	case when codVehiculo is not null and mes=9 then 1 else 0 end as asignadosSeptiembre,
    case when codVehiculo is not null and mes=9 and codEstado=2 then 1 else 0 end as cerradosSeptiembre,
    case when codVehiculo is not null and mes=9 and codEstado=1 then 1 else 0 end as pendientesSeptiembre,
	case when mes=10 then 1 else 0 end as abiertosOctubre,
	case when codVehiculo is not null and mes=10 then 1 else 0 end as asignadosOctubre,
    case when codVehiculo is not null and mes=10 and codEstado=2 then 1 else 0 end as cerradosOctubre,
    case when codVehiculo is not null and mes=10 and codEstado=1 then 1 else 0 end as pendientesOctubre,
	case when mes=11 then 1 else 0 end as abiertosNoviembre,
	case when codVehiculo is not null and mes=11 then 1 else 0 end as asignadosNoviembre,
    case when codVehiculo is not null and mes=11 and codEstado=2 then 1 else 0 end as cerradosNoviembre,
    case when codVehiculo is not null and mes=11 and codEstado=1 then 1 else 0 end as pendientesNoviembre,
	case when mes=12 then 1 else 0 end as abiertosDiciembre,
	case when codVehiculo is not null and mes=12 then 1 else 0 end as asignadosDiciembre,
    case when codVehiculo is not null and mes=12 and codEstado=2 then 1 else 0 end as cerradosDiciembre,
    case when codVehiculo is not null and mes=12 and codEstado=1 then 1 else 0 end as pendientesDiciembre,
    codVendedor, codMarca
	from (
		select   m.descripcion as marca,  month(fechaCreacion) as  mes, codVehiculoProspecto,
		CONCAT(per.nombre, ' ', apePat) as vendedor, o.ciudad as oficina, e.descripcion as estado,
		vp.codVehiculo, p.estado as codEstado,
		p.codUsuario as codVendedor, m.codMarca
		from prospecto as p
		left join vehiculo_prospecto as vp on vp.codProspecto=p.codProspecto
		left join usuario as u on u.codUsuario= p.codUsuario
		left join oficina as o on o.codOficina=u.codOficina
		left join persona as per on per.codPersona=u.codPersona
		left join modelo as mo on mo.codModelo=vp.codModelo
		left join marca as m on m.codMarca=mo.codMarca
		left join estado_prospecto as e on e.codEstadoProspecto=p.estado
		where codVehiculoProspecto>0 and Year(fechaCreacion)='$gestion' $condicion
	) as subreporte
) as reporte group by oficina, vendedor, marca, codVendedor, codMarca
order by oficina, vendedor, marca
";

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
//******************************************************************************************
    function DetalladoSucursales($estado, $mes, $gestion, $vendedor, $codMarca, $codigo){
        $db = new MySQL();
		//obtener codigo de vehiculo
        $condicion="";

        if($estado=="A"){ $condicion=" and codVehiculo is not null";}
        if($estado=="C"){ $condicion=" and codVehiculo is not null and p.estado=2";}
        if($estado=="P"){ $condicion=" and codVehiculo is not null and p.estado=1";}
		//--------------------------------------------------------------------------------
        $iUsuario = new Usuario();
        $iUsuario->RecuperarSesionCod($codigo);
        $perfil= $iUsuario->obtenerPerfil();
        if ($perfil=="Jefatura"){
                    $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
        }
        //--------------------------------------------------------------------------------
        $consulta="
        select   m.descripcion as marca,  month(fechaCreacion) as  mes, codVehiculoProspecto,
		CONCAT(per.nombre, ' ', apePat) as vendedor, o.ciudad as oficina, e.descripcion as estado,
		vp.codVehiculo, p.estado as codEstado,
		p.codUsuario as codVendedor, m.codMarca, p.codProspecto, p.nombre, mo.nombre as modelo, vp.precioVenta as precio
		from prospecto as p
		left join vehiculo_prospecto as vp on vp.codProspecto=p.codProspecto
		left join usuario as u on u.codUsuario= p.codUsuario
		left join oficina as o on o.codOficina=u.codOficina
		left join persona as per on per.codPersona=u.codPersona
		left join modelo as mo on mo.codModelo=vp.codModelo
		left join marca as m on m.codMarca=mo.codMarca
		left join estado_prospecto as e on e.codEstadoProspecto=p.estado
		where codVehiculoProspecto>0 and Year(fechaCreacion)='$gestion' and Month(fechaCreacion)='$mes' and p.codUsuario='$vendedor' and m.codMarca=$codMarca $condicion
";

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
//**********************************************************************************
    function SucursalesProspectos($gestion, $codigo){
        $db = new MySQL();
    //--------------------------------------------------------------------------------
    $condicion="";
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
                $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
    }
    //--------------------------------------------------------------------------------
		$consulta="
select oficina, vendedor, codVendedor,
sum(abiertosEnero) as abiertosEnero, sum(cerradosEnero) as cerradosEnero, sum(eliminadosEnero) as eliminadosEnero,
sum(abiertosFebrero) as abiertosFebrero, sum(cerradosFebrero) as cerradosFebrero, sum(eliminadosFebrero) as eliminadosFebrero,
sum(abiertosMarzo) as abiertosMarzo, sum(cerradosMarzo) as cerradosMarzo, sum(eliminadosMarzo) as eliminadosMarzo,
sum(abiertosAbril) as abiertosAbril, sum(cerradosAbril) as cerradosAbril, sum(eliminadosAbril) as eliminadosAbril,
sum(abiertosMayo) as abiertosMayo, sum(cerradosMayo) as cerradosMayo, sum(eliminadosMayo) as eliminadosMayo,
sum(abiertosJunio) as abiertosJunio, sum(cerradosJunio) as cerradosJunio, sum(eliminadosJunio) as eliminadosJunio,
sum(abiertosJulio) as abiertosJulio, sum(cerradosJulio) as cerradosJulio, sum(eliminadosJulio) as eliminadosJulio,
sum(abiertosAgosto) as abiertosAgosto, sum(cerradosAgosto) as cerradosAgosto, sum(eliminadosAgosto) as eliminadosAgosto,
sum(abiertosSeptiembre) as abiertosSeptiembre, sum(cerradosSeptiembre) as cerradosSeptiembre, sum(eliminadosSeptiembre) as eliminadosSeptiembre,
sum(abiertosOctubre) as abiertosOctubre, sum(cerradosOctubre) as cerradosOctubre, sum(eliminadosOctubre) as eliminadosOctubre,
sum(abiertosNoviembre) as abiertosNoviembre, sum(cerradosNoviembre) as cerradosNoviembre, sum(eliminadosNoviembre) as eliminadosNoviembre,
sum(abiertosDiciembre) as abiertosDiciembre, sum(cerradosDiciembre) as cerradosDiciembre, sum(eliminadosDiciembre) as eliminadosDiciembre
from (
	select oficina, vendedor,
	case when mes=1 then 1 else 0 end as abiertosEnero,
	case when estado='Cerrado' and mes=1 then 1 else 0 end as cerradosEnero ,
	case when estado='Eliminado' and mes=1 then 1 else 0 end as eliminadosEnero ,
	case when mes=2 then 1 else 0 end as abiertosFebrero,
	case when estado='Cerrado' and mes=2 then 1 else 0 end as cerradosFebrero ,
	case when estado='Eliminado' and mes=2 then 1 else 0 end as eliminadosFebrero ,
	case when mes=3 then 1 else 0 end as abiertosMarzo,
	case when estado='Cerrado' and mes=3 then 1 else 0 end as cerradosMarzo ,
	case when estado='Eliminado' and mes=3 then 1 else 0 end as eliminadosMarzo,
	case when mes=4 then 1 else 0 end as abiertosAbril,
	case when estado='Cerrado' and mes=4 then 1 else 0 end as cerradosAbril,
	case when estado='Eliminado' and mes=4 then 1 else 0 end as eliminadosAbril,
	case when mes=5 then 1 else 0 end as abiertosMayo,
	case when estado='Cerrado' and mes=5 then 1 else 0 end as cerradosMayo,
	case when estado='Eliminado' and mes=5 then 1 else 0 end as eliminadosMayo,
	case when mes=6 then 1 else 0 end as abiertosJunio,
	case when estado='Cerrado' and mes=6 then 1 else 0 end as cerradosJunio ,
	case when estado='Eliminado' and mes=6 then 1 else 0 end as eliminadosJunio,
	case when mes=7 then 1 else 0 end as abiertosJulio,
	case when estado='Cerrado' and mes=7 then 1 else 0 end as cerradosJulio ,
	case when estado='Eliminado' and mes=7 then 1 else 0 end as eliminadosJulio,
	case when mes=8 then 1 else 0 end as abiertosAgosto,
	case when estado='Cerrado' and mes=8 then 1 else 0 end as cerradosAgosto ,
	case when estado='Eliminado' and mes=8 then 1 else 0 end as eliminadosAgosto,
	case when mes=9 then 1 else 0 end as abiertosSeptiembre,
	case when estado='Cerrado' and mes=9 then 1 else 0 end as cerradosSeptiembre ,
	case when estado='Eliminado' and mes=9 then 1 else 0 end as eliminadosSeptiembre,
	case when mes=10 then 1 else 0 end as abiertosOctubre,
	case when estado='Cerrado' and mes=10 then 1 else 0 end as cerradosOctubre,
	case when estado='Eliminado' and mes=10 then 1 else 0 end as eliminadosOctubre,
	case when mes=11 then 1 else 0 end as abiertosNoviembre,
	case when estado='Cerrado' and mes=11 then 1 else 0 end as cerradosNoviembre,
	case when estado='Eliminado' and mes=11 then 1 else 0 end as eliminadosNoviembre,
	case when mes=12 then 1 else 0 end as abiertosDiciembre,
	case when estado='Cerrado' and mes=12 then 1 else 0 end as cerradosDiciembre,
	case when estado='Eliminado' and mes=12 then 1 else 0 end as eliminadosDiciembre,
    codVendedor
	from (
		select   month(fechaCreacion) as  mes,
		CONCAT(per.nombre, ' ', apePat) as vendedor, o.ciudad as oficina, e.descripcion as estado,
        p.codUsuario as codVendedor
		from prospecto as p
		left join usuario as u on u.codUsuario= p.codUsuario
		left join oficina as o on o.codOficina=u.codOficina
		left join persona as per on per.codPersona=u.codPersona
		left join estado_prospecto as e on e.codEstadoProspecto=p.estado
		where Year(fechaCreacion)='$gestion' $condicion
	) as subreporte
) as reporte group by oficina, vendedor
order by oficina, vendedor, codVendedor
";

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
    //******************************************************************************************
    function DetalladoSucursalesProspectos($estado, $mes, $gestion, $vendedor, $codigo){

        $db = new MySQL();
		//obtener codigo de vehiculo
        $condicion="";

        if($estado=="C"){ $condicion=" and p.estado=2";}
        if($estado=="E"){ $condicion=" and p.estado=3";}
        if($estado=="P"){ $condicion=" and p.estado=1";}

    //--------------------------------------------------------------------------------
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
                $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
    }
    //--------------------------------------------------------------------------------
		$consulta="
        select   month(fechaCreacion) as  mes,
		CONCAT(per.nombre, ' ', apePat) as vendedor, o.ciudad as oficina, e.descripcion as estado,
        p.codUsuario as codVendedor, p.nombre, p.codProspecto
		from prospecto as p
		left join usuario as u on u.codUsuario= p.codUsuario
		left join oficina as o on o.codOficina=u.codOficina
		left join persona as per on per.codPersona=u.codPersona
		left join estado_prospecto as e on e.codEstadoProspecto=p.estado
		where Year(fechaCreacion)='$gestion' and Month(fechaCreacion)='$mes' and p.codUsuario='$vendedor' $condicion
";

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
    //******************************************************************************************
    function PlanTrabajo($codigo){

    //--------------------------------------------------------------------------------
    $condicion="";
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
      if ($codigo == 94 || $codigo == 100) {
        $condicion .= ' and u.codUsuario in (select codUsuario from usuario where codOficina IN (3,4))';
      } else {
        $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
      }
    }

    if ($perfil=="Operaciones"){
        $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) and u.codSalon in (select codSalon from usuario where codSalon=(select codSalon from usuario where codUsuario='$codigo')) ";
    }
    
    //--------------------------------------------------------------------------------
    $consulta="
select codOficina, oficina, foto, codVendedor, vendedor, sum(atrasados) as atrasados,
sum(hoy) as hoy, sum(proximos) as proximos, sum(sinseguimiento) as sinseguimiento
from(
select codOficina, oficina, codVendedor, vendedor, foto,
case when estado='Pendiente' and dias>0 then 1 else 0 end as atrasados,
case when estado='Pendiente' and dias=0 then 1 else 0 end as hoy,
case when estado='Pendiente' and dias<0 then 1 else 0 end as proximos,
case when estado='Finalizado' and dias>0 then 1 else 0 end as sinseguimiento
from(
select p.codProspecto, CONCAT(per.nombre, ' ', apePat) as vendedor, p.codUsuario as codVendedor,
CONCAT(o.descripcion) as oficina, o.codOficina, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado, u.foto,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias
from prospecto as p
left join (
	select codProspecto, max(codSeguimiento) as codSeguimiento
	from seguimiento
	where codProspecto in (
		select p.codProspecto from prospecto as p where p.estado=1
	)
	group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
left join usuario as u on u.codUsuario= p.codUsuario
left join oficina as o on o.codOficina=u.codOficina
left join persona as per on per.codPersona=u.codPersona
where p.estado=1 and p.codUsuario != 0 $condicion
) as subconsulta
) as consulta
group by  codOficina, oficina, codVendedor, vendedor    ";
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

 function PlanTrabajo2($codigo){

    //--------------------------------------------------------------------------------
    $condicion="";
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
      if ($codigo == 94 || $codigo == 100) {
        $condicion .= ' and u.codUsuario in (select codUsuario from usuario where codOficina IN (3,4))';
      } else {
        $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
      }
    }
    if ($perfil=="Operaciones"){
        $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) and u.codSalon in (select codSalon from usuario where codSalon=(select codSalon from usuario where codUsuario='$codigo')) ";
    }
    //--------------------------------------------------------------------------------
    $consulta="
select codOficina, oficina, foto, codVendedor, vendedor, sum(atrasados) as atrasados,
sum(hoy) as hoy, sum(proximos) as proximos, sum(sinseguimiento) as sinseguimiento,SUM(AVerdes) as aVerde, SUM(ARojos) as aRojo, SUM(AAmarillos) as aAmarillo, SUM(aBlancos) as aBlanco,
SUM(pRojo) as pRojo, SUM(pAmarillo) as pAmarillo, SUM(pVerde) as pVerde, SUM(pBlanco) as pBlanco,
SUM(hRojo) as hRojo, SUM(hAmarillo) as hAmarillo, SUM(hVerde) as hVerde, SUM(hBlanco) as hBlanco,
SUM(ssRojo) as ssRojo, SUM(ssAmarillo) as ssAmarillo, SUM(ssVerde) as ssVerde, SUM(ssBlanco) as ssBlanco
from(
select codOficina, oficina, codVendedor, vendedor, foto, 
case when estado='Pendiente' and dias>0 then 1 else 0 end as atrasados,
case when estado='Pendiente' and dias>0 and Color='Rojo' then 1 else 0 end as ARojos,
    case when estado='Pendiente' and dias>0 and Color='Amarillo' then 1 else 0 end as AAmarillos,
    case when estado='Pendiente' and dias>0 and Color='Verde' then 1 else 0 end as AVerdes,
     case when estado='Pendiente' and dias>0 and Color='Blanco' then 1 else 0 end as ABlancos,
case when estado='Pendiente' and dias=0 then 1 else 0 end as hoy,
case when estado='Pendiente' and dias=0 and Color='Rojo' then 1 else 0 end as hRojo,
    case when estado='Pendiente' and dias=0 and Color='Amarillo' then 1 else 0 end as hAmarillo,
    case when estado='Pendiente' and dias=0 and Color='Verde' then 1 else 0 end as hVerde,
    case when estado='Pendiente' and dias=0 and Color='Blanco' then 1 else 0 end as hBlanco,
case when estado='Pendiente' and dias<0 then 1 else 0 end as proximos,
      case when estado='Pendiente' and dias<0 and Color='Rojo' then 1 else 0 end as pRojo,
    case when estado='Pendiente' and dias<0 and Color='Amarillo' then 1 else 0 end as pAmarillo,
    case when estado='Pendiente' and dias<0 and Color='Verde' then 1 else 0 end as pVerde,
     case when estado='Pendiente' and dias<0 and Color='Blanco' then 1 else 0 end as pBlanco,
case when estado='Finalizado' and dias>=0 then 1 else 0 end as sinseguimiento,
    case when estado='Finalizado' and dias>=0 AND Color='Rojo' then 1 else 0 end as ssRojo,
    case when estado='Finalizado' and dias>=0 AND Color='Amarillo' then 1 else 0 end as ssAmarillo,
    case when estado='Finalizado' and dias>=0 AND Color='Verde' then 1 else 0 end as ssVerde,
      case when estado='Finalizado' and dias>=0 AND Color='Blanco' then 1 else 0 end as ssBlanco 
from(
select p.codProspecto, CONCAT(per.nombre, ' ', apePat) as vendedor, p.codUsuario as codVendedor,
CONCAT(o.descripcion) as oficina, o.codOficina, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado, u.foto,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
case when p.semaforo = '1' THEN 'Rojo'
    WHEN p.semaforo='2' THEN 'Amarillo'
    WHEN p.semaforo='3' THEN 'Verde'
    ELSE 'Blanco' end as Color,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias, p.semaforo
from prospecto as p
left join (
    select codProspecto, max(codSeguimiento) as codSeguimiento
    from seguimiento
    where codProspecto in (
        select p.codProspecto from prospecto as p where p.estado=1
    )
    group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
left join usuario as u on u.codUsuario= p.codUsuario
left join oficina as o on o.codOficina=u.codOficina
left join persona as per on per.codPersona=u.codPersona
where p.estado=1 $condicion
) as subconsulta
) as consulta
group by  codOficina, oficina, codVendedor, vendedor    ";
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








     function PlanTrabajoR($codigo){

    //--------------------------------------------------------------------------------
    $condicion="";
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
      if ($codigo == 94 || $codigo == 100) {
        $condicion .= ' and u.codUsuario in (select codUsuario from usuario where codOficina IN (3,4))';
      } else {
        $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
      }
    }
    if ($perfil=="Operaciones"){
        $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) and u.codSalon in (select codSalon from usuario where codSalon=(select codSalon from usuario where codUsuario='$codigo')) ";
    }
    //--------------------------------------------------------------------------------
    $consulta="
select codOficina, oficina, foto, codVendedor, vendedor, sum(atrasados) as atrasados,
sum(hoy) as hoy, sum(proximos) as proximos, sum(sinseguimiento) as sinseguimiento,SUM(AVerdes) as aVerde, SUM(ARojos) as aRojo, SUM(AAmarillos) as aAmarillo, SUM(aBlancos) as aBlanco,
SUM(pRojo) as pRojo, SUM(pAmarillo) as pAmarillo, SUM(pVerde) as pVerde, SUM(pBlanco) as pBlanco,
SUM(hRojo) as hRojo, SUM(hAmarillo) as hAmarillo, SUM(hVerde) as hVerde, SUM(hBlanco) as hBlanco,
SUM(ssRojo) as ssRojo, SUM(ssAmarillo) as ssAmarillo, SUM(ssVerde) as ssVerde, SUM(ssBlanco) as ssBlanco
from(
select codOficina, oficina, codVendedor, vendedor, foto, 
case when estado='Pendiente' and dias>0 then 1 else 0 end as atrasados,
case when estado='Pendiente' and dias>0 and Color='Rojo' then 1 else 0 end as ARojos,
    case when estado='Pendiente' and dias>0 and Color='Amarillo' then 1 else 0 end as AAmarillos,
    case when estado='Pendiente' and dias>0 and Color='Verde' then 1 else 0 end as AVerdes,
     case when estado='Pendiente' and dias>0 and Color='Blanco' then 1 else 0 end as ABlancos,
case when estado='Pendiente' and dias=0 then 1 else 0 end as hoy,
case when estado='Pendiente' and dias=0 and Color='Rojo' then 1 else 0 end as hRojo,
    case when estado='Pendiente' and dias=0 and Color='Amarillo' then 1 else 0 end as hAmarillo,
    case when estado='Pendiente' and dias=0 and Color='Verde' then 1 else 0 end as hVerde,
    case when estado='Pendiente' and dias=0 and Color='Blanco' then 1 else 0 end as hBlanco,
case when estado='Pendiente' and dias<0 then 1 else 0 end as proximos,
      case when estado='Pendiente' and dias<0 and Color='Rojo' then 1 else 0 end as pRojo,
    case when estado='Pendiente' and dias<0 and Color='Amarillo' then 1 else 0 end as pAmarillo,
    case when estado='Pendiente' and dias<0 and Color='Verde' then 1 else 0 end as pVerde,
     case when estado='Pendiente' and dias<0 and Color='Blanco' then 1 else 0 end as pBlanco,
case when estado='Finalizado' and (dias>=0 or dias is null) then 1 else 0 end as sinseguimiento,
    case when estado='Finalizado' and (dias>=0 or dias is null)AND Color='Rojo' then 1 else 0 end as ssRojo,
    case when estado='Finalizado' and (dias>=0 or dias is null) AND Color='Amarillo' then 1 else 0 end as ssAmarillo,
    case when estado='Finalizado' and (dias>=0 or dias is null) AND Color='Verde' then 1 else 0 end as ssVerde,
      case when estado='Finalizado' and (dias>=0 or dias is null) AND Color='Blanco' then 1 else 0 end as ssBlanco 
from(
select p.codRenovacion, CONCAT(per.nombre, ' ', apePat) as vendedor, u.codUsuario as codVendedor,
CONCAT(o.descripcion) as oficina, o.codOficina, ms.codSeguimiento, u.codUsuario, t.descripcion as contacto,
case when (s.completado='1' or s.completado is null) then 'Finalizado' else 'Pendiente' end as estado, u.foto,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
case when DATEDIFF(date(p.finVigencia),CURRENT_DATE) <= 5 THEN 'Rojo'
    WHEN  ( DATEDIFF(date(p.finVigencia),CURRENT_DATE) >=6 and DATEDIFF(date(p.finVigencia),CURRENT_DATE) <=15 ) THEN 'Amarillo'
    WHEN DATEDIFF(date(p.finVigencia),CURRENT_DATE) >= 16 THEN 'Verde'
    ELSE 'Blanco' end as Color,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias, DATEDIFF(date(p.finVigencia),CURRENT_DATE) as semaforo,p.codigoIntermediario
from renovacion as p
left join (
    select codRenovacion, max(codSeguimiento) as codSeguimiento
    from seguimientoRenovacion
    where codrenovacion in (
        select p.codRenovacion from renovacion as p where p.codEstadoProspecto=1
    )
    group by codRenovacion
) as ms on ms.codRenovacion=p.codRenovacion
left join seguimientoRenovacion as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
left join persona as per on per.sapSlpCode=p.codigoIntermediario
left join usuario as u on u.codPersona= per.codPersona
left join oficina as o on o.codOficina=u.codOficina

where p.codEstadoProspecto=1 $condicion
) as subconsulta
) as consulta where codVendedor is not null
group by  codOficina, oficina, codVendedor, vendedor     ";
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

    //******************************************************************************************
    function DetallePlan($tipo, $vendedor, $codigo){
        $db = new MySQL();
		//obtener codigo de vehiculo
        $condicion="";

        if($tipo=="a"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>0 ";}
        if($tipo=="b"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))=0 ";}
        if($tipo=="c"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))<0 ";}
        if($tipo=="d"){ $condicion=" and s.completado='1' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>=0 ";}
    //--------------------------------------------------------------------------------
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
                $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
    }
    //--------------------------------------------------------------------------------
        $consulta="
select p.codProspecto, CONCAT(per.nombre, ' ', apePat) as vendedor, p.codUsuario as codVendedor,
o.ciudad as oficina, o.codOficina, concat(p.nombre,' ',p.primerNombre,' ',p.primerApellido) as nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias,
case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>0 then 'Atrasado' else
    case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))=0 then 'Hoy' else
        case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))<0 then 'Proximo' else
            case when s.completado='1' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>=0 then 'Sin Seguimiento' else 'Sin Seguimiento ' end
        end
    end
end as estado
from prospecto as p
left join (
	select codProspecto, max(codSeguimiento) as codSeguimiento
	from seguimiento
	where codProspecto in (
		select p.codProspecto from prospecto as p where p.estado=1
	)
	group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
left join usuario as u on u.codUsuario= p.codUsuario
left join oficina as o on o.codOficina=u.codOficina
left join persona as per on per.codPersona=u.codPersona
where p.estado=1 and p.codUsuario='$vendedor' $condicion
";

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



/////////////////////////
    function DetallePlanR($tipo, $vendedor, $codigo){
        $db = new MySQL();
        //obtener codigo de vehiculo
        $condicion="";

        if($tipo=="a"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>0 ";}
        if($tipo=="b"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))=0 ";}
        if($tipo=="c"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))<0 ";}
        if($tipo=="d"){ $condicion=" and (s.completado='1' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>=0 or s.completado is null) ";}
    //--------------------------------------------------------------------------------
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
                $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
    }
    //--------------------------------------------------------------------------------
        $consulta="
select p.poliza,p.codTipoRenovacion, p.codRenovacion, CONCAT(per.nombre, ' ', apePat) as vendedor, u.codUsuario as codVendedor,
o.descripcion as oficina, o.codOficina, ms.codSeguimiento, u.codUsuario, t.descripcion as contacto,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias,
case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>0 then 'Atrasado' else
    case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))=0 then 'Hoy' else
        case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))<0 then 'Proximo' else
            case when s.completado='1' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>=0 then 'Sin Seguimiento' else 'Sin Seguimiento' end
        end
    end
end as estado
from renovacion as p
left join (
    select codRenovacion, max(codSeguimiento) as codSeguimiento
    from seguimientoRenovacion
    where codRenovacion in (
        select p.codRenovacion from renovacion as p where p.codEstadoProspecto=1
    )
    group by codRenovacion
) as ms on ms.codRenovacion=p.codRenovacion
left join seguimientoRenovacion as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
left join persona as per on per.sapSlpCode=p.codigoIntermediario
left join usuario as u on u.codPersona= per.codPersona
left join oficina as o on o.codOficina=u.codOficina

where p.codEstadoProspecto=1 and u.codUsuario='$vendedor' $condicion
";

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



//******************************************************************************************
 function DetallePlanSemaforo($tipo, $vendedor, $codigo, $semaforo){
        $db = new MySQL();
        //obtener codigo de vehiculo
        $condicion="";

        if($tipo=="a"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>0 ";}
        if($tipo=="b"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))=0 ";}
        if($tipo=="c"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))<0 ";}
        if($tipo=="d"){ $condicion=" and s.completado='1' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>=0 ";}
    //--------------------------------------------------------------------------------
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
                $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
    }
    //--------------------------------------------------------------------------------
        $consulta="
select p.codProspecto, CONCAT(per.nombre, ' ', apePat) as vendedor, p.codUsuario as codVendedor,
o.ciudad as oficina, o.codOficina, concat (p.nombre,' ',p.primerNombre,' ',p.primerApellido) as nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias,
case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>0 then 'Atrasado' else
    case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))=0 then 'Hoy' else
        case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))<0 then 'Proximo' else
            case when s.completado='1' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>=0 then 'Sin Seguimiento' else 'Sin Seguimiento' end
        end
    end
end as estado,
CASE WHEN semaforo='1' then 'Rojo'
WHEN semaforo='2' THEN 'Amarillo'
WHEN semaforo='3' THEN 'Verde'
ELSE 'Sin Definir' end semaforo
from prospecto as p
left join (
    select codProspecto, max(codSeguimiento) as codSeguimiento
    from seguimiento
    where codProspecto in (
        select p.codProspecto from prospecto as p where p.estado=1
    )
    group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
left join usuario as u on u.codUsuario= p.codUsuario
left join oficina as o on o.codOficina=u.codOficina
left join persona as per on per.codPersona=u.codPersona
where p.estado=1 and p.codUsuario='$vendedor' $condicion and p.semaforo='$semaforo'
";

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

//******************************************************************************************************************************************************************************
    function DetallePlanSemaforoR($tipo, $vendedor, $codigo, $semaforo){
        $db = new MySQL();
        //obtener codigo de vehiculo
        $condicion="";

      if($tipo=="a"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>0 ";}
        if($tipo=="b"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))=0 ";}
        if($tipo=="c"){ $condicion=" and s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))<0 ";}
        if($tipo=="d"){ $condicion=" and (s.completado='1' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>=0 or s.completado is null) ";}
    //--------------------------------------------------------------------------------
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
                $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
    }
    //--------------------------------------------------------------------------------
        $consulta="
select p.poliza,p.codTipoRenovacion, p.codRenovacion, CONCAT(per.nombre, ' ', apePat) as vendedor, u.codUsuario as codVendedor,
o.descripcion as oficina, o.codOficina, ms.codSeguimiento, u.codUsuario, t.descripcion as contacto,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias,
case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>0 then 'Atrasado' else
    case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))=0 then 'Hoy' else
        case when s.completado='0' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))<0 then 'Proximo' else
            case when s.completado='1' and (DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end))>=0 then 'Sin Seguimiento' else 'Sin Seguimiento' end
        end
    end
end as estado,
case when DATEDIFF(date(p.finVigencia),CURRENT_DATE) <= 5 THEN 'Rojo'
    WHEN  ( DATEDIFF(date(p.finVigencia),CURRENT_DATE) >=6 and DATEDIFF(date(p.finVigencia),CURRENT_DATE) <=15 ) THEN 'Amarillo'
    WHEN DATEDIFF(date(p.finVigencia),CURRENT_DATE) >= 16 THEN 'Verde'
    ELSE 'Blanco' end as Color
from renovacion as p
left join (
    select codRenovacion, max(codSeguimiento) as codSeguimiento
    from seguimientoRenovacion
    where codRenovacion in (
        select p.codRenovacion from renovacion as p where p.codEstadoProspecto=1
    )
    group by codRenovacion
) as ms on ms.codRenovacion=p.codRenovacion
left join seguimientoRenovacion as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
left join persona as per on per.sapSlpCode=p.codigoIntermediario
left join usuario as u on u.codPersona= per.codPersona
left join oficina as o on o.codOficina=u.codOficina

where p.codEstadoProspecto=1 and u.codUsuario='$vendedor' $condicion and  DATEDIFF(date(p.finVigencia),CURRENT_DATE)<='$semaforo'
";

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

//** ****************************************************************************************
 function ProspectosxMes($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){
    $db = new mysql();
    
    $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
      if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }

    $consulta="SELECT pro.fechaCreacion, day(fec.fecha) as dia, COUNT(pro.fechaCreacion) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
                GROUP by day(fec.fecha)";
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

 //***********************************************************************************************
 function prospectosxRamo($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
     if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }

    $db= new MySQL();
    $consulta="SELECT CASE 
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                 WHEN r.nombre='ENTIDADES FINANCIERAS Y DELITOS FINANCIEROS' THEN 'ENT. Y DELITOS FINANCIEROS'
                ELSE r.nombre end as ramo ,  COUNT(pro.fechaCreacion) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and r.nombre is not null $condicion 
                GROUP by det.codRamo order by ramo asc";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }



 //**********************************************************************************************
function prospectosxRamovendidos($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
     if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }

    $db= new MySQL();
    $consulta="SELECT CASE 
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                 WHEN r.nombre='ENTIDADES FINANCIERAS Y DELITOS FINANCIEROS' THEN 'ENT. Y DELITOS FINANCIEROS'
                ELSE r.nombre end as ramo ,  COUNT(pro.fechaCreacion) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and r.nombre is not null and det.estado=0 $condicion 
                GROUP by det.codRamo order by ramo asc";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }

 //**********************************************************************************************
function prospectosxRamonovendidos($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
     if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }

    $db= new MySQL();
    $consulta="SELECT CASE 
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                 WHEN r.nombre='ENTIDADES FINANCIERAS Y DELITOS FINANCIEROS' THEN 'ENT. Y DELITOS FINANCIEROS'
                ELSE r.nombre end as ramo ,  COUNT(pro.fechaCreacion) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and r.nombre is not null and det.estado=1 $condicion 
                GROUP by det.codRamo order by ramo asc";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }


 //***********************************************************************************************
 function totalProspectosxRamo($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }

    $db= new MySQL();
    $consulta="SELECT SUM(total) as totProspectos FROM(
               SELECT CASE 
               WHEN r.nombre is null then 'SIN PRODUCTO'
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                ELSE r.nombre end as ramo ,  COUNT(pro.fechaCreacion) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and r.nombre is not null $condicion 
                GROUP by det.codRamo order by ramo asc) as tab";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }


//*************************************************************************************+

 function totalProspectosxRamovendidos($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }

    $db= new MySQL();
    $consulta="SELECT SUM(total) as totProspectos FROM(
               SELECT CASE 
               WHEN r.nombre is null then 'SIN PRODUCTO'
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                ELSE r.nombre end as ramo ,  COUNT(pro.fechaCreacion) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and r.nombre is not null and det.estado=0 $condicion 
                GROUP by det.codRamo order by ramo asc) as tab";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }

 //*************************************************************************************+

 function totalProspectosxRamonovendidos($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }

    $db= new MySQL();
    $consulta="SELECT SUM(total) as totProspectos FROM(
               SELECT CASE 
               WHEN r.nombre is null then 'SIN PRODUCTO'
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                ELSE r.nombre end as ramo ,  COUNT(pro.fechaCreacion) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and r.nombre is not null and det.estado=1 $condicion 
                GROUP by det.codRamo order by ramo asc) as tab";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }

 //***********************************************************************************************
 function ProspectoxProductos($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
    if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }

    $db= new MySQL();
    $consultaold="SELECT 'Sin Producto' as origen, COUNT(pro.codProspecto) as total from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and det.codProspecto is null and pro.codProspecto is not null $condicion
                UNION ALL
                SELECT 'Con Producto' as origen, SUM(tot) FROM(
				SELECT  '1' as tot, pro.codProspecto
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and det.codProspecto is not null $condicion
                group by det.codProspecto) as tabla";

    $consulta = "SELECT 'Sin Producto' as origen, (SIN*100/(SIN+CON)) as total from (select Sum(SIN) as 'SIN', sum(CON) as 'CON'  from (select case when origen='Sin Producto'  then total else 0 end as 'SIN' , case when origen='Con Producto' then total else 0 end as 'CON' from (SELECT 'Sin Producto' as origen, COUNT(pro.codProspecto) as total from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and det.codProspecto is null and pro.codProspecto is not null $condicion
                
                UNION ALL
                
                SELECT 'Con Producto' as origen, sum(tot) FROM(
                SELECT  '1' as tot, pro.codProspecto
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and det.codProspecto is not null $condicion
                group by det.codProspecto) as tabla) as tablota) as ta)as tabla3
                
                
                union ALL
                
                select 'Con Producto' as origen, (CON*100/(SIN+CON)) as total from (select Sum(SIN) as 'SIN', sum(CON) as 'CON'  from (select case when origen='Sin Producto'  then total else 0 end as 'SIN' , case when origen='Con Producto' then total else 0 end as 'CON' from (SELECT 'Sin Producto' as origen, COUNT(pro.codProspecto) as total from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and det.codProspecto is null and pro.codProspecto is not null $condicion
                
                UNION ALL
                
                SELECT 'Con Producto' as origen, sum(tot) FROM(
                SELECT  '1' as tot, pro.codProspecto
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and det.codProspecto is not null $condicion
                group by det.codProspecto) as tabla) as tablota) as ta)as tabla3 ";
                
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }









 //**************************************************************************************


function Motivos($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
    if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }

 $db= new MySQL();
 $consulta="SELECT motivo_baja.descripcion as descripcion,count(producto_detalle.codProductoDetalle) as total FROM producto_detalle left join motivo_baja on producto_detalle.codMotivo=motivo_baja.codMotivoBaja 
  LEFT JOIN prospecto pro on producto_detalle.codProspecto=pro.codProspecto
      LEFT JOIN fechas fec on fec.fecha= date(pro.fechaCreacion) 
       LEFT JOIN usuario u on u.codUsuario=pro.codUsuario where producto_detalle.estado=1 and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion group by codMotivo";

if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }

 //***********************************************************************************************

function renovacionesmotivo($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or renovacion.inicioVigencia is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or renovacion.inicioVigencia is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or renovacion.inicioVigencia is null)";
    }
     if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or renovacion.inicioVigencia is null)";
    }

    $db= new MySQL();
    $consulta="SELECT motivo_baja.descripcion as descripcion,COUNT(renovacion.codMotivoSuspension) as total 
                                from renovacion LEFT JOIN motivo_baja on motivo_baja.codMotivoBaja=renovacion.codMotivoSuspension 
 LEFT JOIN fechas fec on fec.fecha= date(renovacion.inicioVigencia) 
LEFT JOIN persona on persona.sapSlpCode=renovacion.codigoIntermediario
 LEFT JOIN usuario u on  u.codPersona = persona.codPersona 
 WHERE renovacion.codMotivoSuspension!=0  and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion GROUP BY motivo_baja.descripcion";


    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }




//***********************************************************************************************
 function prospectosPrimaxRamo($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    $db= new MySQL();
    $consulta="SELECT CASE 
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                 WHEN r.nombre='ENTIDADES FINANCIERAS Y DELITOS FINANCIEROS' THEN 'ENT. Y DELITOS FINANCIEROS'
                ELSE r.nombre end as ramo , sum(det.prima) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and pro.estado!=3 $condicion 
                GROUP by det.codRamo order by ramo asc";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }

 //***********************************************************************************************
 function prospectosPrimaxRamovendido($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    $db= new MySQL();
    $consulta="SELECT CASE 
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                 WHEN r.nombre='ENTIDADES FINANCIERAS Y DELITOS FINANCIEROS' THEN 'ENT. Y DELITOS FINANCIEROS'
                ELSE r.nombre end as ramo , sum(det.prima) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and pro.estado!=3 and det.estado=0 $condicion 
                GROUP by det.codRamo order by ramo asc";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }
//****************************************************************************

function mostrarjc($oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
      $seleccionar='';
      $agrupar='';

if ($ejecutivo != "" && $ejecutivo != 0) {

              $seleccionar="usuario.codUsuario,usuario.usuario as descripcion,";
    //$agrupar="group by prospecto.codUsuario";
    $condicion="and usuario.codUsuario ='$ejecutivo'";
    

 // $condicion="and usuario.codUsuario = (select codSalon from usuario where usuario.codUsuario='$ejecutivo')";
//$condicion=" agrupar por usuario y añadir condicion del salon del usuario seleccionado where codSalon= (select codSalon from usuario where usuario='$codUsuario')";
}
else
{
if ($equipo!="" && $equipo!= 0) {
    $agrupar="group by usuario.codUsuario";
    $seleccionar=" usuario.codUsuario,usuario.usuario as descripcion,";
$condicion.=" and (usuario.codSalon='$equipo')";


//$condicion = "agrupar por usuario y añadir condicion del salon seleccionado"
}
else
{
if ($canal!="" && $canal != 0) {
    $agrupar="group by Salon.codSalon";
   $condicion.=" and (usuario.codOficina='$canal')";
   $seleccionar="Salon.codSalon,Salon.nombre as descripcion,";


 //$condicion =" agrupar por salon poner condicion where canal seleccionado"
}
else
{

$agrupar="group by usuario.codOficina";
$seleccionar="oficina.descripcion as descripcion,";


 //$condicion = " agrupar por canal"
}
}
}
    $db= new MySQL();

    
        $consulta="SELECT ROUND(promedio) as promedio2, descripcion FROM( SELECT  $seleccionar AVG( datediff(fechaCierre,fechaCreacion)) as promedio from prospecto left join usuario on prospecto.codUsuario=usuario.codUsuario left join oficina on oficina.codOficina=usuario.codOficina left join Salon on Salon.codSalon=usuario.codSalon where YEAR(fechaCierre)='2019' $condicion $agrupar) as tab1";

    
         //  $consulta="SELECT Salon.codSalon,Salon.nombre, AVG( datediff(fechaCierre,fechaCreacion)),from prospecto left join usuario on prospecto.codUsuario=usuario.codUsuario left join oficina on oficina.codOficina=usuario.codOficina left join Salon on Salon.codSalon=usuario.codSalon where YEAR(fechaCierre)='2019' $condicion group by usuario.codsalon, Salon.codSalon";                       
  
         // $consulta="SELECT usuario.codUsuario,usuario.usuario, AVG( datediff(fechaCierre,fechaCreacion)) from prospecto left join usuario on prospecto.codUsuario=usuario.codUsuario left join oficina on oficina.codOficina=usuario.codOficina left join Salon on Salon.codSalon=usuario.codSalon where YEAR(fechaCierre) = 2019 and oficina.codOficina=1 and Salon.codSalon=2 group by prospecto.codUsuario";
    
    
        
    
    
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }






 //***********************************************************************************************
 function prospectosPrimaxRamonovendido($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    $db= new MySQL();
    $consulta="SELECT CASE 
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                 WHEN r.nombre='ENTIDADES FINANCIERAS Y DELITOS FINANCIEROS' THEN 'ENT. Y DELITOS FINANCIEROS'
                ELSE r.nombre end as ramo , sum(det.prima) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and pro.estado!=3 and det.estado=1 $condicion 
                GROUP by det.codRamo order by ramo asc";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }

 //***********************************************************************************************
 function totalPrimaxRamo($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    $db= new MySQL();
    $consulta="SELECT SUM(total) as totProspectos FROM(
               SELECT CASE 
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                ELSE r.nombre end as ramo , sum(det.prima) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion'  and pro.estado!=3 $condicion 
                GROUP by det.codRamo order by ramo asc) as tab";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }

//******************************************************************************
 function totalPrimaxRamovendidos($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    $db= new MySQL();
    $consulta="SELECT SUM(total) as totProspectos FROM(
               SELECT CASE 
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                ELSE r.nombre end as ramo , sum(det.prima) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion'  and pro.estado!=3 and det.estado=0 $condicion 
                GROUP by det.codRamo order by ramo asc) as tab";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }


//******************************************************************************
 function totalPrimaxRamonovendidos($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    $db= new MySQL();
    $consulta="SELECT SUM(total) as totProspectos FROM(
               SELECT CASE 
                WHEN r.nombre='RESPONSABILIDAD CIVIL RC Y D&O / PROFESIONAL' THEN 'RC y D&O'
                ELSE r.nombre end as ramo , sum(det.prima) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion'  and pro.estado!=3 and det.estado=1 $condicion 
                GROUP by det.codRamo order by ramo asc) as tab";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }



//***********************************************************************************************
 function totalsubmotivo($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo,$motivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    if($motivo != '' && $motivo !=0){
        $condicion.=" and ( producto_detalle.codMotivo='$motivo')";
    }

    $db= new MySQL();
    $consulta="SELECT SUM(total) as totalsubmotivo FROM(
SELECT subMotivo_baja.descripcion as submotivo,COUNT(producto_detalle.codProductoDetalle) as total FROM producto_detalle left join subMotivo_baja on subMotivo_baja.codSubMotivoBaja=producto_detalle.codSubMotivo 
    LEFT JOIN prospecto pro on producto_detalle.codProspecto=pro.codProspecto 
LEFT JOIN fechas fec on fec.fecha= date(pro.fechaCreacion)
  LEFT JOIN usuario u on u.codUsuario=pro.codUsuario
where producto_detalle.estado=1   and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
group by subMotivo_baja.codSubMotivoBaja ) as tab";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }


//***********************************************************************************************
 function totalmotivo($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
   

    $db= new MySQL();
    $consulta="SELECT SUM(total) as totalmotivo FROM(SELECT motivo_baja.descripcion as descripcion,count(producto_detalle.codProductoDetalle) as total FROM producto_detalle left join motivo_baja on producto_detalle.codMotivo=motivo_baja.codMotivoBaja 
  LEFT JOIN prospecto pro on producto_detalle.codProspecto=pro.codProspecto
      LEFT JOIN fechas fec on fec.fecha= date(pro.fechaCreacion) 
       LEFT JOIN usuario u on u.codUsuario=pro.codUsuario where producto_detalle.estado=1 and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion  group by codMotivo)as tab ";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }
 //***********************************************************************************************

function totalmotivosre($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
   

    $db= new MySQL();

       $consulta="SELECT SUM(total) as total from(SELECT motivo_baja.descripcion,COUNT(renovacion.codMotivoSuspension) as total 
                                from renovacion LEFT JOIN motivo_baja on motivo_baja.codMotivoBaja=renovacion.codMotivoSuspension 
 LEFT JOIN fechas fec on fec.fecha= date(renovacion.inicioVigencia) 
LEFT JOIN persona on persona.sapSlpCode=renovacion.codigoIntermediario
 LEFT JOIN usuario u on  u.codPersona = persona.codPersona 
 WHERE renovacion.codMotivoSuspension!=0  and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion  GROUP BY motivo_baja.descripcion)as tabla";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }
 //***********************************************************************************************
 function totalsubmotivosre($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo,$motivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
     if($motivo != '' && $motivo !=0){
        $condicion.=" and ( renovacion.codMotivoSuspension='$motivo')";
    }
   

    $db= new MySQL();

       $consulta="SELECT sum(total)as total from (SELECT motivo_baja.codMotivoBaja,motivo_baja.descripcion,COUNT(renovacion.codRenovacion) as total 
                                from renovacion LEFT JOIN motivo_baja on motivo_baja.codMotivoBaja=renovacion.codMotivoSuspension 
 LEFT JOIN fechas fec on fec.fecha= date(renovacion.inicioVigencia) 
LEFT JOIN persona on persona.sapSlpCode=renovacion.codigoIntermediario
 LEFT JOIN usuario u on  u.codPersona = persona.codPersona 
 WHERE renovacion.codMotivoSuspension!=0  and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion  GROUP BY motivo_baja.codMotivoBaja)as tab";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }

 //***********************************************************************************************

 function totalramosreno($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT SUM(total) as total from(SELECT renovacion.nombreRamo, Sum(renovacion.primaNeta) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
                GROUP by renovacion.nombreRamo )as tab";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }
 //***********************************************************************************************
 function totalramosrenovendido($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT SUM(total) as total from(SELECT renovacion.nombreRamo, Sum(renovacion.primaNeta) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and renovacion.codEstadoProspecto=2 $condicion
                GROUP by renovacion.nombreRamo )as tab";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }
 //***********************************************************************************************
 function totalramosrenonovendido($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT SUM(total) as total from(SELECT renovacion.nombreRamo, Sum(renovacion.primaNeta) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and renovacion.codEstadoProspecto=3 $condicion
                GROUP by renovacion.nombreRamo )as tab";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }


 //***********************************************************************************************
 function totalramosreno2($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT Sum(total) as total from(SELECT renovacion.nombreRamo, COUNT(renovacion.codRenovacion) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
                GROUP by renovacion.nombreRamo) as ta";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }

 //***********************************************************************************************
 function totalvendidoreno($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT Sum(total) as total from(SELECT renovacion.nombreRamo, COUNT(renovacion.codRenovacion) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and renovacion.codEstadoProspecto=2 $condicion
                GROUP by renovacion.nombreRamo) as ta";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }
 //***********************************************************************************************
 function totalnovendidoreno($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT Sum(total) as total from(SELECT renovacion.nombreRamo, COUNT(renovacion.codRenovacion) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and renovacion.codEstadoProspecto=3 $condicion
                GROUP by renovacion.nombreRamo) as ta";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }




 //***********************************************************************************************
function vendidoreno($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT renovacion.nombreRamo as nombre, COUNT(renovacion.codRenovacion) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and renovacion.codEstadoProspecto=2 $condicion
                GROUP by renovacion.nombreRamo";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }
 //***********************************************************************************************
 function novendidoreno($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT renovacion.nombreRamo as nombre, COUNT(renovacion.codRenovacion) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and renovacion.codEstadoProspecto=3 $condicion
                GROUP by renovacion.nombreRamo";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }
 //***********************************************************************************************

 function ramosreno($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT nombre, TRUNCATE(total,3) as total FROM(SELECT renovacion.nombreRamo as nombre, Sum(renovacion.primaNeta) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
                GROUP by renovacion.nombreRamo)as tab";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }
 //***********************************************************************************************
 function ramosrenovendido($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT nombre, TRUNCATE(total,3) as total FROM  (SELECT renovacion.nombreRamo as nombre, Sum(renovacion.primaNeta) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and renovacion.codEstadoProspecto=2 $condicion
                GROUP by renovacion.nombreRamo)AS TAB";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }
 //***********************************************************************************************
 function ramosrenonovendido($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();

       $consulta="SELECT nombre, TRUNCATE(total,3) as total FROM  (SELECT renovacion.nombreRamo as nombre, Sum(renovacion.primaNeta) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and renovacion.codEstadoProspecto=3 $condicion
                GROUP by renovacion.nombreRamo)AS TAB";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }


 //***********************************************************************************************

 function ramosreno2($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    
   

    $db= new MySQL();
    

       $consulta="SELECT CASE 
                WHEN  renovacion.nombreRamo='CUMPLIMIENTO DE CONTRATO DE SERVICIOS PARA ENT. PUBLICAS' THEN 'CUMPTO. DE CTO. DE SERVI. PARA ENT. PUBLICAS'
                 WHEN  renovacion.nombreRamo='ENTIDADES FINANCIERAS Y DELITOS FINANCIEROS' THEN 'ENT. Y DELITOS FINANCIEROS' 
                  else renovacion.nombreRamo end as nombre, COUNT(renovacion.codRenovacion) as total
                from fechas fec
                LEFT JOIN renovacion  on fec.fecha= date(renovacion.inicioVigencia) 
                LEFT JOIN persona on renovacion.codigoIntermediario=persona.sapSlpCode
                LEFT JOIN usuario u on u.codPersona=persona.codPersona 
                LEFT JOIN ramo r on r.codRamo = renovacion.codigoRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
                GROUP by renovacion.nombreRamo";

    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }




 //***********************************************************************************************
function totalprospectorigen($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
   

    $db= new MySQL();
    $consulta="SELECT SUM(total) as total from(SELECT ori.descripcion as origen, count(*) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion)
                INNER JOIN origen_prospecto ori on ori.codORigenProspecto=pro.codOrigenProspecto 
                LEFT JOIN usuario u on pro.codUsuario=u.codUsuario
               WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
                GROUP by ori.codOrigenProspecto) as tabla";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }

 //***********************************************************************************************
function totalprospectoproducto($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
   

    $db= new MySQL();
    $consulta="SELECT SUM(total) as total from(SELECT 'Sin Producto' as origen, COUNT(pro.codProspecto) as total from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and det.codProspecto is null and pro.codProspecto is not null $condicion 
                UNION ALL
                SELECT 'Con Producto' as origen, SUM(tot) FROM(
                SELECT  '1' as tot, pro.codProspecto
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                LEFT JOIN ramo r on r.codRamo = det.codRamo
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and det.codProspecto is not null  $condicion 
                group by det.codProspecto) as tabla ) as tabla2";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }





//***********************************************************************************************
 function submotivo($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo,$motivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    if($motivo != '' && $motivo !=0){
        $condicion.=" and ( producto_detalle.codMotivo='$motivo')";
    }

    $db= new MySQL();
    $consulta="SELECT subMotivo_baja.descripcion as descripcion,COUNT(producto_detalle.codProductoDetalle) as total FROM producto_detalle left join subMotivo_baja on subMotivo_baja.codSubMotivoBaja=producto_detalle.codSubMotivo 
    LEFT JOIN prospecto pro on producto_detalle.codProspecto=pro.codProspecto 
LEFT JOIN fechas fec on fec.fecha= date(pro.fechaCreacion)
  LEFT JOIN usuario u on u.codUsuario=pro.codUsuario
where producto_detalle.estado=1   and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
group by subMotivo_baja.codSubMotivoBaja";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }




function submotivoren($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo,$motivo){


      $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or renovacion.inicioVigencia is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or renovacion.inicioVigencia is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or renovacion.inicioVigencia is null)";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or renovacion.inicioVigencia is null)";
    }
    if($motivo != '' && $motivo !=0){
        $condicion.=" and ( renovacion.codMotivoSuspension='$motivo')";
    }


    $db= new MySQL();
    $consulta="SELECT subMotivo_baja.descripcion,COUNT(renovacion.codSubMotivoSuspencion) as total 
                                from renovacion LEFT JOIN subMotivo_baja on subMotivo_baja.codSubMotivoBaja=renovacion.codSubMotivoSuspencion 
 LEFT JOIN fechas fec on fec.fecha= date(renovacion.inicioVigencia) 
LEFT JOIN persona on persona.sapSlpCode=renovacion.codigoIntermediario
 LEFT JOIN usuario u on  u.codPersona = persona.codPersona 
 WHERE renovacion.codMotivoSuspension!=0  and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion  GROUP BY subMotivo_baja.descripcion";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }



//** ****************************************************************************************
 function RenovacionesxMes($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){
    $db = new mysql();
    
    $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or ren.inicioVigencia is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or ren.inicioVigencia is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or ren.inicioVigencia is null)";
    }
     
      if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or ren.inicioVigencia is null)";
    }

    $consulta="SELECT  ren.inicioVigencia,day(fec.fecha) as dia, case when count(ren.inicioVigencia) = null then 0 else count(ren.inicioVigencia) end  as total
                from fechas fec
                LEFT JOIN renovacion ren on fec.fecha= date(ren.inicioVigencia)
                left join persona per on ren.codigoIntermediario = per.sapSlpCode 
                left join usuario u on u.codPersona = per.codPersona 
                where 1=1 and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
                 group by day(fec.fecha)";
                

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

//****************************************************************************************
 function ProspectoxOrigenes($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){
    
    $db = new mysql();
    
   $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
    if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    $consulta="SELECT ori.descripcion as origen, (count(ori.codOrigenProspecto)*100)/(SELECT  COUNT(*) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion)
                INNER JOIN origen_prospecto ori on ori.codORigenProspecto=pro.codOrigenProspecto 
                LEFT JOIN usuario u on pro.codUsuario=u.codUsuario
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion ) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion)
                INNER JOIN origen_prospecto ori on ori.codORigenProspecto=pro.codOrigenProspecto 
                LEFT JOIN usuario u on pro.codUsuario=u.codUsuario
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
                GROUP by ori.codOrigenProspecto";
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

//****************************************************************************************
 function ProspectoxMotivoBaja($mes, $gestion, $oficina, $canal, $equipo){
    
    $db = new mysql();
    
   $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
    $consulta="SELECT ori.descripcion as origen, COUNT(*) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion)
                LEFT JOIN usuario u on pro.codUsuario=u.codUsuario 
                LEFT JOIN producto_detalle pd on pd.codProspecto=pro.codProspecto
                LEFT JOIN producto p on p.codProducto=pd.codProducto
                INNER JOIN motivo_baja ori on ori.codMotivoBaja= pd.codMotivo 
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
                GROUP by ori.codMotivoBaja";
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

//****************************************************************************************
 function ProspectoxSubmotivoBaja2($mes, $gestion, $oficina, $canal, $equipo, $codMotivo){
    
    $db = new mysql();
    
   $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
    $consulta="SELECT case when sub.descripcion ='Condiciones no aceptadas por Suscripción' THEN 'Cond. No Aceptadas'
                else sub.descripcion end as origen, COUNT(*) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion)
                LEFT JOIN usuario u on pro.codUsuario=u.codUsuario 
                LEFT JOIN producto_detalle pd on pd.codProspecto=pro.codProspecto
                LEFT JOIN producto p on p.codProducto=pd.codProducto
                INNER JOIN motivo_baja ori on ori.codMotivoBaja= pd.codMotivo 
                inner JOIN subMotivo_baja sub on sub.codMotivoBaja = ori.codMotivoBaja
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and pd.codMotivo ='$codMotivo'
                GROUP by sub.codSubMotivoBaja";
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
//****************************************************************************************
 function ProspectoxSubmotivoBaja($mes, $gestion, $oficina, $canal, $equipo, $codMotivo){
    
    $db = new mysql();
    
   $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
    $consulta="SELECT case when sm.descripcion ='Condiciones no aceptadas por Suscripción' THEN 'Cond. No Aceptadas'
                else sm.descripcion end as origen, COUNT(sm.codSubMotivoBaja) as total
                from fechas fec
                left JOIN producto_detalle pd on date(pd.fechaCierre)=fec.fecha  
                left JOIN producto p on p.codProducto =pd.codProductoDetalle
                left JOIN subMotivo_baja sm on sm.codSubMotivoBaja= pd.codSubMotivo
                LEFT JOIN prospecto pro on pro.codProspecto=pd.codProspecto 
                left JOIN usuario u on u.codUsuario=pro.codUsuario
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and pd.codMotivo='$codMotivo'
                GROUP by sm.codSubMotivoBaja";
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


//****************************************************************************************
 function prospectosPrimaxOrigen($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){
    
    $db = new mysql();
    
   $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
    if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    $consulta="SELECT ori.descripcion as origen, SUM(det.prima) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion)
                INNER JOIN origen_prospecto ori on ori.codORigenProspecto=pro.codOrigenProspecto 
                LEFT JOIN usuario u on pro.codUsuario=u.codUsuario
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and pro.estado!=3 $condicion
                GROUP by ori.codOrigenProspecto";
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
//****************************************************************************************
 function totalPrimaxOrigen($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo){
    
    $db = new mysql();
    
   $condicion ='';
    if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' or pro.fechaCreacion is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
    }
    if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo' or pro.fechaCreacion is null)";
    }
    $consulta=" SELECT SUM(total) as totProspectos FROM( 
                SELECT ori.descripcion as origen, SUM(det.prima) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion)
                INNER JOIN origen_prospecto ori on ori.codORigenProspecto=pro.codOrigenProspecto 
                LEFT JOIN usuario u on pro.codUsuario=u.codUsuario
                LEFT JOIN producto_detalle det on det.codProspecto = pro.codProspecto
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and pro.estado!=3 $condicion
                GROUP by ori.codOrigenProspecto) as tab";
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
//***********************************************************************************************
 function prospectosEliminadosxMes($mes, $gestion, $sucursal){
    $condicion="";
    if($sucursal!=0){
        $condicion.= " and u.codOficina='$sucursal'";
    }
    $db= new MySQL();
    $consulta="SELECT pro.fechaCreacion, day(fec.fecha) as dia, COUNT(pro.fechaCreacion) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                 LEFT JOIN usuario u on pro.codUsuario= u.codUsuario and pro.estado=3 
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and (u.codOficina='$sucursal' or pro.fechaCreacion is null)
                GROUP by day(fec.fecha)";
    if($db->Error()){
        $db->kill();
        return "vacio";
    }
    else{
        if(!$db->Query($consulta)){
            return "vacio";
        }
        else
        {
            return $db;
        }
    }
 }


 //**********************************************************************************************
  function ProspectosxMes2($mes, $gestion){
    $db = new mysql();

    $consulta="SELECT tablota.*, case when tablota.estadoReserva='1' then tablota.total else '0' end as total2 from (sELECT pro.fechaReserva as lafechareserva, day(fec.fecha) as dia, COUNT(pro.fechaReserva) as total,pro.estadoReserva
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaReserva)
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion'
                GROUP BY day(fec.fecha)
UNION DISTINCT                
                SELECT coalesce(pro.fechaReserva,day(fec.fecha)) as lafechareserva, day(fec.fecha) as dia, COUNT(pro.fechaReserva) as total,pro.estadoReserva
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaReserva)
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and pro.estadoReserva='1') tablota group by tablota.dia";
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
//******************************************************************************************
 function totalProspectoxMes($mes, $gestion, $sucursal, $canal, $equipo,$ejecutivo)
 {
      $db = new mysql();

         $condicion ='';
         $condicion2 ='';
    if($sucursal != '' && $sucursal !=0){
        $condicion.=" and ( u.codCiudad='$sucursal' or pro.fechaCreacion is null)";
        $condicion2.=" and ( u.codCiudad='$sucursal' or ren.inicioVigencia is null)";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' or pro.fechaCreacion is null)";
          $condicion2.=" and ( u.codOficina='$canal' or ren.inicioVigencia is null)";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' or pro.fechaCreacion is null)";
        $condicion2.=" and (u.codSalon='$equipo' or ren.inicioVigencia is null)";
    }
     if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
          $condicion2.=" and (u.codUsuario='$ejecutivo')";
    }
        
    
    $consulta="SELECT SUM(total) as totProspectos FROM(
               SELECT pro.fechaCreacion, day(fec.fecha) as dia, COUNT(pro.fechaCreacion) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u on u.codUsuario=pro.codUsuario 
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion
                GROUP by day(fec.fecha)) as tab";
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


//******************************************************************************************
 function totalrenovacionesjc($mes, $gestion, $sucursal, $canal, $equipo,$ejecutivo)
 {
      $db = new mysql();


         $condicion2 ='';
    if($sucursal != '' && $sucursal !=0){
      
        $condicion2.=" and ( u.codCiudad='$sucursal' or ren.inicioVigencia is null)";
    }
    if($canal !='' && $canal != 0){
        
          $condicion2.=" and ( u.codOficina='$canal' or ren.inicioVigencia is null)";
    }

    if($equipo != '' && $equipo !=0){
       
        $condicion2.=" and (u.codSalon='$equipo' or ren.inicioVigencia is null)";
    }
         if($ejecutivo != '' && $ejecutivo !=0){
        $condicion2.=" and (u.codUsuario='$ejecutivo')";
    }
    
    $consulta="SELECT SUM(total) as totalrenovaciones FROM(
    SELECT ren.inicioVigencia, day(fec.fecha) as dia, case when count(ren.inicioVigencia) = null then 0 else count(ren.inicioVigencia) end  as total
                from fechas fec
                LEFT JOIN renovacion ren on fec.fecha= date(ren.inicioVigencia)
                left join persona per on ren.codigoIntermediario = per.sapSlpCode 
                left join usuario u on u.codPersona = per.codPersona 
                where 1=1  and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion2 
                 group by day(fec.fecha)) as tab";
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


//***************************************************************************************************
 function totalpromediojc( $sucursal, $canal, $equipo,$ejecutivo)
 {
      $db = new mysql();

 $condicion ='';
      $seleccionar='';
      $agrupar='';

if ($ejecutivo != "" && $ejecutivo != 0) {

               $agrupar="group by usuario.codUsuario";
    $seleccionar=" usuario.codUsuario,usuario.usuario as descripcion,";
$condicion.=" and (usuario.codSalon='$equipo')";


//$condicion=" agrupar por usuario y añadir condicion del salon del usuario seleccionado where codSalon= (select codSalon from usuario where usuario='$codUsuario')";
}
else
{
if ($equipo!="" && $equipo!= 0) {
    $agrupar="group by usuario.codUsuario";
    $seleccionar=" usuario.codUsuario,usuario.usuario as descripcion,";
$condicion.=" and (usuario.codSalon='$equipo')";


//$condicion = "agrupar por usuario y añadir condicion del salon seleccionado"
}
else
{
if ($canal!="" && $canal != 0) {
    $agrupar="group by Salon.codSalon";
   $condicion.=" and (usuario.codOficina='$canal')";
   $seleccionar="Salon.codSalon,Salon.nombre as descripcion,";


 //$condicion =" agrupar por salon poner condicion where canal seleccionado"
}
else
{

$agrupar="group by usuario.codOficina";
$seleccionar="oficina.descripcion as descripcion,";


 //$condicion = " agrupar por canal"
}
}
}
    
    $consulta="SELECT ROUND(promedio2) as total2 FROM (SELECT AVG(promedio) as promedio2 FROM( SELECT  $seleccionar AVG( datediff(fechaCierre,fechaCreacion)) as promedio from prospecto left join usuario on prospecto.codUsuario=usuario.codUsuario left join oficina on oficina.codOficina=usuario.codOficina left join Salon on Salon.codSalon=usuario.codSalon where YEAR(fechaCierre)='2019' $condicion $agrupar) as tab1) as tab2";
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




//****************************************************************************************************
  function totalEliminadosxMes($mes, $gestion, $suc)
 {
     $condicion="";
    if($sucursal!=0){
        $condicion.= " and u.codOficina='$suc'";
    }
      $db = new mysql();

    $consulta="SELECT SUM(total) as totProspectos FROM(
                SELECT pro.fechaCreacion, day(fec.fecha) as dia, COUNT(pro.fechaCreacion) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                 LEFT JOIN usuario u on pro.codUsuario= u.codUsuario and pro.estado=3 
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and (u.codOficina='$suc' or pro.fechaCreacion is null)
                GROUP by day(fec.fecha)) as tab";
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

 //***************************************************************************************************
  function totalProspectoxMes2($mes, $gestion)
 {
      $db = new mysql();

    $consulta="SELECT SUM(total) as totProspectos FROM(
               SELECT pro.fechaReserva, day(fec.fecha) as dia, COUNT(pro.fechaReserva) as total
                from fechas fec
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaReserva)
                WHERE month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' and pro.estadoReserva='1'
                GROUP by day(fec.fecha)) as tab";
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

//******************************************************************************************
 function ProspectoAnual($gestion, $oficina)
 {
    $db = new mysql();
    $consulta ="SELECT pro.fechaCreacion, ELT(MONTH(fec.fecha), 'ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC') as mes, COUNT(pro.fechaCreacion) as total
                from fechas fec 
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u  on pro.codUsuario= u.codUsuario
                WHERE year(fec.fecha)='$gestion' and (u.codOficina='$oficina' or u.codOficina is null)
                GROUP by month(fec.fecha)";

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
 //****************************************************************************************
 function totalProspectoAnual($gestion, $oficina){
    $db = new mysql();
    $consulta="SELECT SUM(total) as totProspAnual FROM(
               SELECT pro.fechaCreacion, ELT(MONTH(fec.fecha), 'ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC') as mes, COUNT(pro.fechaCreacion) as total
                from fechas fec 
                LEFT JOIN prospecto pro on fec.fecha= date(pro.fechaCreacion) 
                LEFT JOIN usuario u  on pro.codUsuario= u.codUsuario
                WHERE year(fec.fecha)='$gestion' and (u.codOficina='$oficina' or u.codOficina is null)
                GROUP by month(fec.fecha)) as tab";
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
 

//******************************************************************************************
    function Vigentes($proyecto="", $nombre="", $probabilidad="", $sistema="",  $vendedor="", $oficina=""){
         $db = new MySQL();

        $condicion="";
        $proyecto=$db->SQLFix($proyecto);
        $proyecto=str_replace(" ","%", $proyecto);
        $nombre=$db->SQLFix($nombre);
        $nombre=str_replace(" ","%", $nombre);


        if($proyecto!=""){ $condicion.=" and cab.descripcion like '%$proyecto%' "; }
        if($nombre!=""){ $condicion.=" and p.nombre like '%$nombre%' "; }
        if(($probabilidad!="")&&($probabilidad!="0")){ $condicion.=" and cab.prob='$probabilidad' "; }
        if(($sistema!="")&&($sistema!="")){ $condicion.=" and cab.codSistProducto='$sistema' "; }
        if(($vendedor!="")&&($vendedor!="0")){ $condicion.=" and p.codUsuario='$vendedor' "; }
        if(($oficina!="")&&($oficina!="0")){ $condicion.=" and u.codOficina='$oficina' "; }


        $consulta="SELECT p.nombreObra as proyecto, case when codtipoVenta=1 then 'V' else
case when codtipoVenta=2 then 'O' else 'N/A' end end as tipoVO, p.nombre, cab.prob,
case when sc.descripcion is not null then GROUP_CONCAT(sc.descripcion SEPARATOR ', ') else GROUP_CONCAT(cab.descripcion SEPARATOR ', ') end  as material,
SUM(cab.superficie) as superficie, cab.superficieMedida, (IFNULL(sum(cab.total),0)/6.96) as total,
concat(per.nombre,' ',per.apePat) as asesor,
concat(
( DATE_FORMAT(case when completado='1' then seg.fechaCompletado else seg.fechaProxContacto end ,'%d/%m/%Y')),' - ', tc.descripcion, ' - ', case when seg.observacion='' then (case when seg.descripcion='' then 'SIN OBSERVACIONES' else seg.descripcion end) else seg.observacion end) as estado, p.codProspecto
FROM (
select * from prospecto where estado=1
) as p
left join  tp_cabecera_cotizacion as cab on p.codProspecto=cab.codProspecto and cab.codEstado=1
left join tp_sistema_constructivo as sc on sc.codSistema=cab.codSistProducto
left join usuario as u on u.codUsuario=p.codUsuario
left join persona as per on per.codPersona=u.codPersona
left join (
select max(codSeguimiento) as codSeguimiento, c2.codProspecto
from (select * from prospecto where estado=1) as c1
inner join seguimiento as c2 on c2.codProspecto=c1.codProspecto
 where completado='1' or 1=1
group by codProspecto
) as ctrl on ctrl.codProspecto=p.codProspecto
left join seguimiento as seg on seg.codSeguimiento=ctrl.codSeguimiento
left join tipo_contacto as tc on tc.codTipoContacto=seg.codTipoContacto
where cab.codProspecto  is not null  $condicion
and cab.total>=(1000*6.96) group by p.codProspecto
order by sum(cab.total) asc";



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
//******************************************************************************************
    function getEnProceso($sProyecto_nm = NULL, $sCliente_nm = NULL, $iAsesor_id = NULL, $iOficina_id = NULL){
    	$conditions = '';
    	if ($sProyecto_nm != NULL) {
    		$conditions .= 'AND p.nombreObra LIKE \'%'.$sProyecto_nm.'%\' ';
    	}
    	if ($sCliente_nm != NULL) {
    		$conditions .= 'AND p.nombre LIKE \'%'.$sCliente_nm.'%\' ';
    	}
    	if ($iAsesor_id != NULL) {
    		$conditions .= 'AND u.codUsuario = \''.$iAsesor_id.'\' ';
    	}
    	if ($iOficina_id != NULL) {
    		$conditions .= 'AND u.codOficina = \''.$iOficina_id.'\'';
    	}
        $db = new MySQL();
        $consulta="SELECT p.tamanoObra as tamano, p.direccionOBra as direccion, p.nombreObra as proyecto, case when codtipoVenta=1 then 'V' else
case when codtipoVenta=2 then 'O' else 'N/A' end
end as tipo, p.nombre, cab.prob, sc.descripcion as material,
cab.superficie, cab.superficieMedida, IFNULL(cab.total,0) as total,
concat(per.nombre,' ',per.apePat) as asesor,
concat(
( DATE_FORMAT(seg.fechaProxContacto,'%d/%m/%Y')),' - ',tipo.descripcion,' - ',
seg.observacion) as estado,
case when IFNULL(total,0)<=(3000*6.96) then 1 else
	case when IFNULL(total,0)<=(20000*6.96) then 2 else 3 end
end as tipo, p.codProspecto
FROM (
select * from prospecto where estado=1
) as p
left join  tp_cabecera_cotizacion as cab on p.codProspecto=cab.codProspecto
left join tp_sistema_constructivo as sc on sc.codSistema=cab.codSistProducto
left join usuario as u on u.codUsuario=p.codUsuario
left join persona as per on per.codPersona=u.codPersona
left join (
select max(codSeguimiento) as codSeguimiento, c2.codProspecto
from (select * from prospecto where estado=1) as c1
inner join seguimiento as c2 on c2.codProspecto=c1.codProspecto
 where completado='0'
group by codProspecto
) as ctrl on ctrl.codProspecto=p.codProspecto
left join seguimiento as seg on seg.codSeguimiento=ctrl.codSeguimiento
left join tipo_contacto as tipo on seg.codTipoContacto = tipo.codTipoContacto
where cab.codProspecto is null ".$conditions."
order by p.codProspecto ";

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
//******************************************************************************************
function Eliminadas ($sProyecto_nm = NULL, $sCliente_nm = NULL, $iAsesor_id = NULL, $iOficina_id = NULL, $iElimina_id = NULL, $dtStart_date = NULL, $dtEnd_date = NULL){
    	$conditions = '';
    	if ($sProyecto_nm != NULL) {
    		$conditions .= 'AND pr.nombreObra LIKE \'%'.$sProyecto_nm.'%\' ';
    	}
    	if ($sCliente_nm != NULL) {
    		$conditions .= 'AND pr.nombre LIKE \'%'.$sCliente_nm.'%\' ';
    	}
    	if ($iAsesor_id != NULL) {
    		$conditions .= 'AND usr.codUsuario = \''.$iAsesor_id.'\' ';
    	}
    	if ($iOficina_id != NULL) {
    		$conditions .= 'AND usr.codOficina = \''.$iOficina_id.'\'';
    	}
        if ($iElimina_id != NULL) {
    		$conditions .= 'AND pr.codMotivoSuspension = \''.$iElimina_id.'\'';
    	}

			if ($dtStart_date != NULL && $dtEnd_date != NULL) {
	        	if ($dtStart_date != '') {
	        		$dtStart_date = strtotime($dtStart_date);
		        	$dtEnd_date = strtotime($dtEnd_date);
					$dtStart_date = date('Y-m-d',$dtStart_date);
					$dtEnd_date = date('Y-m-d',$dtEnd_date);
					if ($dtStart_date == $dtEnd_date) {
						$conditions .= 'AND pr.fechaCreacion BETWEEN \''.$dtStart_date.' 00:00:00\' AND \''.$dtStart_date.' 23:59:59\'';
					} else {
						$conditions .= 'AND pr.fechaCreacion BETWEEN \''.$dtStart_date.'\' AND \''.$dtEnd_date.'\' ';
					}

					if ($dtEnd_date == '') {
						$conditions .= 'AND pr.fechaCreacion >= \''.$dtStart_date.'\' ';
					}
	        	}
	        }

        $db = new MySQL();
        $consulta="SELECT b.codProspecto, b.fecha, b.cliente, b.proyecto, b.codUsuario, b.asesor, b.codMotivoSuspension, b.estado, sum(b.total) as eltotal from

            (SELECT pr.codProspecto, date_format(pr.fechaCreacion,'%d-%m-%Y') as fecha, pr.nombre as cliente, pr.codUsuario, concat(per.nombre,' ',per.apePat) as asesor, pr.codMotivoSuspension, elim.descripcion as estado, IFNULL(cab.total,0) as total, pr.nombreObra as proyecto
            FROM prospecto as pr
            left join motivo_suspension as elim on elim.codMotivoSuspension=pr.codMotivoSuspension
            left join usuario as usr on usr.codUsuario=pr.codUsuario
            left join persona as per on per.codPersona=usr.codPersona
            left join tp_cabecera_cotizacion as cab on pr.codProspecto=cab.codProspecto
            where pr.estado='3' ".$conditions.") as b

            GROUP by b.codProspecto, b.fecha, b.proyecto, b.codUsuario, b.asesor, b.codMotivoSuspension, b.estado
            order by eltotal desc ";
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
function EnProceso(){
        $db = new MySQL();
        $consulta="SELECT p.nombreObra as proyecto, case when codtipoVenta=1 then 'V' else
case when codtipoVenta=2 then 'O' else 'N/A' end
end as tipo, p.nombre, cab.prob, sc.descripcion as material,
cab.superficie, cab.superficieMedida, IFNULL(cab.total,0) as total,
concat(per.nombre,' ',per.apePat) as asesor,
concat(
( DATE_FORMAT(seg.fechaCompletado,'%d/%m/%Y')),' ',
seg.descripcion) as estado,
case when IFNULL(total,0)<=(3000*6.96) then 1 else
	case when IFNULL(total,0)<=(20000*6.96) then 2 else 3 end
end as tipo, p.codProspecto
FROM (
select * from prospecto where estado=1
) as p
left join  tp_cabecera_cotizacion as cab on p.codProspecto=cab.codProspecto
left join tp_sistema_constructivo as sc on sc.codSistema=cab.codSistProducto
left join usuario as u on u.codUsuario=p.codUsuario
left join persona as per on per.codPersona=u.codPersona
left join (
select max(codSeguimiento) as codSeguimiento, c2.codProspecto
from (select * from prospecto where estado=1) as c1
inner join seguimiento as c2 on c2.codProspecto=c1.codProspecto
 where completado='1'
group by codProspecto
) as ctrl on ctrl.codProspecto=p.codProspecto
left join seguimiento as seg on seg.codSeguimiento=ctrl.codSeguimiento
where cab.codProspecto is null
order by p.codProspecto ";
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
//******************************************************************************************
    function PendientesCierre($sProyecto_nm = NULL, $sCliente_nm = NULL, $iAsesor_id = NULL, $iOficina_id = NULL){
    	$conditions = '';
    	if ($sProyecto_nm != NULL) {
    		$conditions .= 'AND nombreObra LIKE \'%'.$sProyecto_nm.'%\' ';
    	}

    	if ($sCliente_nm != NULL) {
    		$conditions .= 'AND pNombre LIKE \'%'.$sCliente_nm.'%\' ';
    	}

    	if ($iAsesor_id != NULL) {
    		$conditions .= 'AND pUsuario = \''.$iAsesor_id.'\' ';
    	}

    	if ($iOficina_id != NULL) {
    		$conditions .= 'AND u.codOficina = \''.$iOficina_id.'\' ';
    	}

        $db = new MySQL();
        $consulta="select CONCAT(per.nombre,' ',per.apePat) as vendedor, u.codOficina, pUsuario, codProspecto, pNombre, nombreObra,
sum(abierta) as abiertas, sum(cerrada) as cerradas
from(
SELECT p.codUsuario as pUsuario, p.codProspecto, p.nombre as pNombre, p.nombreObra,
case when cab.codEstado=1 then 1 else 0 end as abierta,
case when cab.codEstado=4 then 1 else 0 end as cerrada
FROM prospecto as p
left join tp_cabecera_cotizacion as cab on cab.codProspecto=p.codProspecto
where p.estado='1'
) as tab
LEFT JOIN usuario as u ON u.codUsuario = pUsuario
LEFT JOIN persona as per ON per.codPersona = u.codPersona
group by codProspecto, pNombre, nombreObra
having abiertas=0 and cerradas>0 ".$conditions;
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

//******************************************************************************************
    public function TotalProspectos($codOficina){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        if($codOficina!=""){
            $condicion=" and codOficina=$codOficina ";
        }
        $consulta="
select count(p.codProspecto) as total
from prospecto as p
left join usuario as u on u.codUsuario=p.codUsuario
where p.estado=1 $condicion
";

        //echo "<hr>".$consulta."<hr>";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }



     public function TotalProspectosR($codOficina){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        if($codOficina!=""){
            $condicion=" and codOficina=$codOficina ";
        }
        $consulta="
select count(p.codRenovacion) as total
from renovacion as p
left join persona per on per.sapSlpCode = p.codigoIntermediario
left join usuario as u on u.codPersona=per.codPersona
where p.codEstadoProspecto=1 $condicion
";

        //echo "<hr>".$consulta."<hr>";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }


        public function TotalProspectosSemaforo0($codOficina){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        if($codOficina!=""){
            $condicion=" and codOficina=$codOficina ";
        }
        $consulta="
select COUNT(p.codProspecto) as total from prospecto as p left join usuario as u on u.codUsuario=p.codUsuario where p.estado=1 and semaforo=0  $condicion
";

        //echo "<hr>".$consulta."<hr>";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }


    public function TotalProspectosSemaforo0R($codOficina){
       
        return "0";

    }

    public function TotalProspectosSemaforo1($codOficina){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        if($codOficina!=""){
            $condicion=" and codOficina=$codOficina ";
        }
        $consulta="
select COUNT(p.codProspecto) as total from prospecto as p left join usuario as u on u.codUsuario=p.codUsuario where p.estado=1 and semaforo=1  $condicion
";

        //echo "<hr>".$consulta."<hr>";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }

    public function TotalProspectosSemaforo1R($codOficina){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        if($codOficina!=""){
            $condicion=" and codOficina=$codOficina ";
        }
        $consulta="
select count(codRenovacion) as total from (select p.codRenovacion from renovacion as p left join persona as per on per.sapSlpCode = p.codigoIntermediario left join usuario as u on u.codPersona= per.codPersona left join seguimientoRenovacion s on s.codRenovacion=p.codRenovacion where p.codEstadoProspecto=1 and DATEDIFF(date(p.finVigencia),CURRENT_DATE)<=5 $condicion group by p.codRenovacion) as a 
";

        //echo "<hr>".$consulta."<hr>";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }
    public function TotalProspectosSemaforo2($codOficina){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        if($codOficina!=""){
            $condicion=" and codOficina=$codOficina ";
        }
        $consulta="
select COUNT(p.codProspecto) as total from prospecto as p left join usuario as u on u.codUsuario=p.codUsuario where p.estado=1 and semaforo=2  $condicion
";

        //echo "<hr>".$consulta."<hr>";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }





       public function TotalProspectosSemaforo2R($codOficina){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        if($codOficina!=""){
            $condicion=" and codOficina=$codOficina ";
        }
        $consulta="
  select count(codRenovacion) as total from (select p.codRenovacion from renovacion as p left join persona as per on per.sapSlpCode = p.codigoIntermediario left join usuario as u on u.codPersona= per.codPersona left join seguimientoRenovacion s on s.codRenovacion=p.codRenovacion where p.codEstadoProspecto=1 and (DATEDIFF(date(p.finVigencia),CURRENT_DATE)>=6 and DATEDIFF(date(p.finVigencia),CURRENT_DATE)<=15) $condicion group by p.codRenovacion) as a 
";

        //echo "<hr>".$consulta."<hr>";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }
    public function TotalProspectosSemaforo3($codOficina){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        if($codOficina!=""){
            $condicion=" and codOficina=$codOficina ";
        }
        $consulta="
select COUNT(p.codProspecto) as total from prospecto as p left join usuario as u on u.codUsuario=p.codUsuario where p.estado=1 and semaforo=3  $condicion
";

        //echo "<hr>".$consulta."<hr>";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }


        public function TotalProspectosSemaforo3R($codOficina){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        if($codOficina!=""){
            $condicion=" and codOficina=$codOficina ";
        }
        $consulta="
select count(codRenovacion) as total from (select p.codRenovacion from renovacion as p left join persona as per on per.sapSlpCode = p.codigoIntermediario left join usuario as u on u.codPersona= per.codPersona left join seguimientoRenovacion s on s.codRenovacion=p.codRenovacion where p.codEstadoProspecto=1 and DATEDIFF(date(p.finVigencia),CURRENT_DATE)>=16 $condicion group by p.codRenovacion) as a 

";

        //echo "<hr>".$consulta."<hr>";
        if (! $db->Query($consulta)) $db->Kill();
        if($db->RowCount()>0){
            $db->MoveFirst();
            $resgistro=$db->Row();
                return $resgistro->total;
        }
        return "0";

    }

//**********************************************************************************
	function Calendario($usuario="", $seg=""){
        //--------------------------------------------------------------------------------
        $condicion="";

     //   if($usuario!=""){
          $condicion=" and  usr.codUsuario='$usuario' ";
      //  }
          $vendedor=$_SESSION['codigousuario'];
          if($_SESSION['perfil']=='Vendedor'){
             $condicion=" and  usr.codUsuario='$vendedor' ";
          }
        $condicion2="";
        if($seg!=""){
            $condicion2=" and  seg.codTipoContacto='$seg' ";
        }

        if($seg==""){
            $condicion2=" and  seg.codTipoContacto!='1' ";
        }

        //--------------------------------------------------------------------------------
//completado!=1 and
        $consulta="

    select * from (
select date(fechaProxContacto) as fecha, seg.codProspecto as codigo, tc.descripcion as tipo,
pro.nombre as nombre, seg.completado, datediff(sysdate(), fechaFinContacto) as dias,
CONCAT(per.nombre, ' ', per.apePat) as odn
from seguimiento as seg
left join prospecto as pro on pro.codProspecto =seg.codProspecto
left join tipo_contacto as tc on tc.codTipoContacto=seg.codTipoContacto
left join usuario as usr on usr.codUsuario=pro.codUsuario
left join persona as per on per.codPersona=usr.codPersona

where  fechaProxContacto is not null and pro.estado != 3  $condicion $condicion2

) as tab order by fecha ";

    //   echo $consulta; die();
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

//****************************************************************************************************************************
   function planCreacionSemana($codigo, $gestion, $semana,$oficina, $canal, $equipo,$ejecutivo){

    //--------------------------------------------------------------------------------
    $condicion="";
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
      if ($codigo == 94 || $codigo == 100) {
        $condicion .= ' and u.codUsuario in (select codUsuario from usuario where codOficina IN (3,4))';
      } else {
        $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
      }
    }

     if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina' )";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }

    //--------------------------------------------------------------------------------
    $consulta="
SELECT codOficina, oficina, foto, codVendedor, vendedor, sum(lunes) as lunes,
sum(martes) as martes, sum(miercoles) as mier, sum(jueves) as jueves, sum(viernes) as viernes, SUM(sabado) as sabado, SUM(domingo) as domingo, count(*) as totalEjecutivo
from(
select p.codProspecto, CONCAT(per.nombre, ' ', apePat) as vendedor, p.codUsuario as codVendedor,p.estado as estadoprospecto,
CONCAT(o.descripcion) as oficina, o.codOficina, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado, u.foto,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias,
case when DAYNAME(p.fechaCreacion)='Monday' then 1 else 0 end as lunes,
case when DAYNAME(p.fechaCreacion)='Tuesday' then 1 else 0 end as martes,
    case when DAYNAME(p.fechaCreacion)='Wednesday' then 1 else 0 end as miercoles,
    case when DAYNAME(p.fechaCreacion)='Thursday' then 1 else 0 end as jueves,
    case when DAYNAME(p.fechaCreacion)='Friday' then 1 else 0 end as viernes,
    case when DAYNAME(p.fechaCreacion)='Saturday' then 1 else 0 end as sabado,
    case when DAYNAME(p.fechaCreacion)='Sunday' then 1 else 0 end as domingo
from prospecto as p
left join (
    select codProspecto, max(codSeguimiento) as codSeguimiento
    from seguimiento
    where codProspecto in (
        select p.codProspecto from prospecto as p
    )
    group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
left join usuario as u on u.codUsuario= p.codUsuario
left join oficina as o on o.codOficina=u.codOficina
left join persona as per on per.codPersona=u.codPersona
where p.codUsuario != 0 $condicion and YEAR(p.fechaCreacion)='$gestion' and WEEK(p.fechaCreacion)='$semana' and p.codPersona=p.codUsuario
) as consulta
group by  codOficina, oficina, codVendedor, vendedor order by codOficina ASC, totalEjecutivo DESC";
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

    //************************************************************************************************************


  function PlanTrabajoVMes($codigo, $mes, $gestion,$oficina, $canal, $equipo,$ejecutivo){

    //--------------------------------------------------------------------------------
    $condicion="";
    $iUsuario = new Usuario();
    $iUsuario->RecuperarSesionCod($codigo);
    $perfil= $iUsuario->obtenerPerfil();
    if ($perfil=="Jefatura"){
      if ($codigo == 94 || $codigo == 100) {
        $condicion .= ' and u.codUsuario in (select codUsuario from usuario where codOficina IN (3,4))';
      } else {
        $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codigo')) ";
      }
    }

     if($oficina != '' && $oficina !=0){
        $condicion.=" and ( u.codCiudad='$oficina')";
    }
    if($canal !='' && $canal != 0){
         $condicion.=" and ( u.codOficina='$canal' )";
    }

    if($equipo != '' && $equipo !=0){
        $condicion.=" and (u.codSalon='$equipo' )";
    }
if($ejecutivo != '' && $ejecutivo !=0){
        $condicion.=" and (u.codUsuario='$ejecutivo')";
    }
    //--------------------------------------------------------------------------------
    $consulta="
select codOficina, oficina, foto, codVendedor, vendedor, sum(atrasados) as atrasados,
sum(hoy) as hoy, sum(proximos) as proximos, sum(sinseguimiento) as sinseguimiento, sum(estadoprospecto) as vendidosmes
from(
select codOficina, oficina, codVendedor, vendedor, foto,
case when estado='Pendiente' and dias>0 then 1 else 0 end as atrasados,
case when estado='Pendiente' and dias=0 then 1 else 0 end as hoy,
case when estado='Pendiente' and dias<0 then 1 else 0 end as proximos,
case when estado='Finalizado' and dias>3 then 1 else 0 end as sinseguimiento,
case when estadoprospecto=2 then 1 else 0 end as estadoprospecto
from(
select p.codProspecto, CONCAT(per.nombre, ' ', apePat) as vendedor, p.codUsuario as codVendedor,p.estado as estadoprospecto,
CONCAT(o.descripcion) as oficina, o.codOficina, p.nombre, ms.codSeguimiento, p.codUsuario, t.descripcion as contacto,
case when s.completado='1' then 'Finalizado' else 'Pendiente' end as estado, u.foto,
case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end as fecha,
DATEDIFF(SYSDATE(), case when fechaFinContacto is null then fechaProxContacto else fechaFinContacto end) as dias
from prospecto as p
left join (
    select codProspecto, max(codSeguimiento) as codSeguimiento
    from seguimiento
    where codProspecto in (
        select p.codProspecto from prospecto as p where p.estado=1
    )
    group by codProspecto
) as ms on ms.codProspecto=p.codProspecto
left join seguimiento as s on s.codSeguimiento=ms.codSeguimiento
left join tipo_contacto as t on t.codTipoContacto=s.codTipoContacto
left join usuario as u on u.codUsuario= p.codUsuario
left join oficina as o on o.codOficina=u.codOficina
left join persona as per on per.codPersona=u.codPersona
where (p.estado=1 or p.estado=2) and p.codUsuario != 0 and (MONTH(p.fechaCierre)='$mes' or MONTH(p.fechaCierre) is null) and (YEAR(p.fechaCierre)='$gestion' or YEAR(p.fechaCierre) is null)  $condicion and u.baja=0
) as subconsulta
) as consulta
group by  codOficina, oficina, codVendedor, vendedor    ";
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

//******************************************************************************************************************

function Calendario2($usuario="", $seg="",$codUsuario,$oficina,$area){


    $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $osiris= $iUsuario->obtenerOsiris();
            $perfil= $iUsuario->obtenerPerfil();
            $sal= $iUsuario->obtenercodSalon();
            $ofi= $iUsuario->obtenerOficina();
        //--------------------------------------------------------------------------------
        $condicion="";
        $condicionRen="";

        if($usuario!=""){
          $condicion=" and  usr.codUsuario='$usuario' ";
          $iUsuario2 = new Usuario();
            $iUsuario2->RecuperarSesionCod($usuario);
            $osiris= $iUsuario2->obtenerOsiris();
            $condicionRen= "and  pro.codigoIntermediario='".$osiris."' ";
            
        }
        else
        {
          //$vendedor=$_SESSION['codigousuario'];
          if($_SESSION['perfil']=='Vendedor'){
             $condicion=" and  usr.codUsuario='$codUsuario' ";
               $condicionRen= "and  pro.codigoIntermediario='".$osiris."' ";
          }

                  
            if ($perfil=="Operaciones") {
               
                $condicionRen .= " and u.codSalon = '$sal' ";

                if ($oficina=="" && $area =="") {
                  $condicion.=" and usr.codSalon='$sal' and usr.codTipoUsuario in (2) ";
                }

                  if ($oficina!="") {
                    $condicion.=" and usr.codOficina='$oficina' and usr.codTipoUsuario in (2) ";
                }
                if ($area !="") {
                     $condicion.=" and usr.codSalon='$area' and usr.codTipoUsuario in (2) ";
                }

            }
            if ($perfil=="Jefatura" ) {

                if ($oficina=="" && $area =="") {
                  $condicion.=" and usr.codOficina='$ofi' and usr.codTipoUsuario in (2,3)";
                  $condicionRen .= " and u.codOficina = '$ofi' ";
                }
                if ($oficina!="") {
                    $condicionRen .= " and u.codOficina = '$oficina' ";
                    $condicion.=" and usr.codOficina='$oficina' and usr.codTipoUsuario in (2,3) ";
                }
               
                if ($area !="") {
                     $condicion.=" and usr.codSalon='$area' and usr.codTipoUsuario in (2,3) ";
                     $condicionRen .= " and u.codSalon = '$area' ";
                }
                else{

                }


                
               
            }
            if ($perfil=="Gerencia" ) {
                if ($oficina=="" && $area =="") {
                  $condicion.=" and usr.codOficina='$ofi' and usr.codTipoUsuario in (2,3)";
                   $condicionRen .= " and u.codOficina = '$ofi' ";
                }
                if ($oficina!="") {
                    $condicion.=" and usr.codOficina='$oficina' and usr.codTipoUsuario in (2,3) ";
                     $condicionRen .= " and u.codOficina = '$oficina' ";
                }
                if ($area !="") {
                     $condicion.=" and usr.codSalon='$area' and usr.codTipoUsuario in (2,3) ";
                      $condicionRen .= " and u.codSalon = '$area' ";
                }

                
               
            }

      }


     


        $condicion2="";
        if($seg!=""){
            $condicion2=" and  seg.codTipoContacto='$seg' ";
        }

        if($seg==""){
            //$condicion2=" and  seg.codTipoContacto!='1' ";
        }

        //--------------------------------------------------------------------------------
//completado!=1 and
        $consulta="

    SELECT 'P' as TipoProspecto,tab.* from (
select date(fechaProxContacto) as fecha, seg.codProspecto as codigo, tc.descripcion as tipo,
concat(pro.primerNombre,' ',pro.primerApellido,' ',pro.nombre) as nombre, seg.completado, datediff(sysdate(), fechaFinContacto) as dias,
CONCAT(per.nombre, ' ', per.apePat) as odn
from seguimiento as seg
left join prospecto as pro on pro.codProspecto =seg.codProspecto
left join tipo_contacto as tc on tc.codTipoContacto=seg.codTipoContacto
left join usuario as usr on usr.codUsuario=pro.codUsuario
left join persona as per on per.codPersona=usr.codPersona

where  fechaProxContacto is not null and pro.estado = 1  $condicion $condicion2 

) as tab 
union all 
SELECT * from (
select pro.codTipoRenovacion as TipoProspecto,date(fechaProxContacto) as fecha, seg.codRenovacion as codigo, tc.descripcion as tipo,
pro.poliza as nombre, seg.completado, datediff(sysdate(), fechaFinContacto) as dias,
CONCAT(per.nombre, ' ', per.apePat) as odn
from seguimientoRenovacion as seg
left join renovacion as pro on pro.codRenovacion =seg.codRenovacion
left join tipo_contacto as tc on tc.codTipoContacto=seg.codTipoContacto

left join persona as per on per.sapSlpCode=pro.codigoIntermediario
left join usuario as u on u.codPersona = per.codPersona

where fechaProxContacto is not null and pro.codEstadoProspecto = 1 $condicionRen $condicion2 

) as tab order by fecha";

    //   echo $consulta; die();
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









    //***********************************************************************************************

}


?>
