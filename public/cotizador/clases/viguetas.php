<?php
require_once "../clases/mysql.class.php";

class Viguetas {

    /* NEW VIGUETAS */

    public function listAllPDFsSimple($iCotVig_id) {
        $db = new MySQL();

        $generalView = 'SELECT * FROM v_viguetas_cotizacion_reportes WHERE iCotVig_id = \''.$iCotVig_id.'\'';

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW viguetas AS '.$generalView.'');
                $data = 'SELECT * FROM viguetas';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('viguetas');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function registrarPDFSimple($iCotVig_id, $iReporte_fl) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            $db->Query('INSERT INTO v_viguetas_cotizacion_reportes(iReporte_fl,iCotVig_id,dtReporte_fecha,iStatus_fl) VALUES (\''.$iReporte_fl.'\',\''.$iCotVig_id.'\',\''.(new \DateTime())->format('Y-m-d H:i:s').'\',\'0\')');
            $id = $db->GetLastInsertID();
            $data = 'SELECT * FROM v_viguetas_cotizacion_reportes WHERE iReporte_id = \''.$id.'\' AND iStatus_fl = \'0\'';
            if ($db->HasRecords($data)) {
                $db->Query($data);
                return $db;
            } else {
                return false;
            }
        }
    }

    public function listAllByCotVig($iCotVig_id, $conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM v_viguetas_cotizacion_items WHERE iCotVig_id = \''.$iCotVig_id.'\' AND iStatus_fl = \'1\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW items AS '.$generalView.'');
                $data = 'SELECT * FROM items';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('items');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

        public function cabeceraPDFCotVigSimple($iCotVig_id, $conditions = '') {
            $db = new MySQL();

            $generalView = 'SELECT u.codOficina as codOficina, pr.nombre, pr.telefono, pr.email, pr.telefonoContacto, CONCAT(per.nombre, \' \', per.apePat) as ejecutivo, o.descripcion as local, o.direccion as direccionlocal, o.ciudad as ciudad, o.telefono as telefonolocal, DATE_FORMAT(SYSDATE(), \'%d/%m/%Y\') as fecha, o.logo as imagenempresa, pr.codProspecto from v_viguetas_cotizacion as v left join prospecto as pr ON pr.codProspecto = v.codProspecto left join usuario as u ON u.codUsuario = pr.codUsuario left join persona as per ON per.codPersona = u.codPersona left join oficina as o ON o.codOficina = u.codOficina WHERE iCotVig_id = \''.$iCotVig_id.'\''.$conditions;

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                if ($db->HasRecords($generalView)) {
                    $db->Query('CREATE OR REPLACE VIEW viguetas AS '.$generalView.'');
                    $data = 'SELECT * FROM viguetas';
                    if ($db->HasRecords($data)) {
                        $db->Query($data);
                        $this->deleteView('viguetas');
                        return $db->Row();
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        public function removeComplemento($iRelacion_id) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                if ($db->Query('UPDATE v_viguetas_cotizacion_productos SET iStatus_fl = \'2\' WHERE iRelacion_id = \''.$iRelacion_id.'\'')) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function newProductoComplementario($iCotVig_id, $codProducto, $cantidad, $oficina) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                if ($db->Query('INSERT INTO v_viguetas_cotizacion_productos ( iCotVig_id, iProducto_id, iProducto_cantidad, iStatus_fl) VALUES ( \''.$iCotVig_id.'\', \''.$codProducto.'\', \''.$cantidad.'\', \'1\' )')) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function getAllComplementosByVigueta($iCotVig_id, $oficina) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT compl.iRelacion_id, pr.codSAP, pr.descripcion, p.cantidad as precio, compl.iProducto_cantidad as cantidad FROM v_viguetas_cotizacion_productos as compl LEFT JOIN tp_producto_sap as pr ON pr.codProducto = compl.iProducto_id LEFT JOIN tp_precio as p ON p.codProducto = compl.iProducto_id WHERE p.codOficina = \''.$oficina.'\' AND compl.iCotVig_id = \''.$iCotVig_id.'\' AND compl.iStatus_fl = \'1\'';
                if ($db->HasRecords($consulta)) {
                    $db->Query($consulta);
                    $array = NULL;
                    while(!$db->EndOfSeek()) {
                        $producto = $db->Row();
                        $array[] = $producto;
                    }
                    return $array;
                }

                return false;
            }
        }

        public function searchProductoByName($sProducto_nm) {
            $db= new MySQL();
            if ($db->Error()){
                $db->Kill();
                return "0";
            }

            $consulta = 'SELECT * FROM tp_producto_sap WHERE descripcion LIKE \'%'.$sProducto_nm.'%\' and baja = \'0\'';

            if ($db->HasRecords($consulta)) {
                $db->Query($consulta);
                $array = NULL;
                while(!$db->EndOfSeek()) {
                    $producto = $db->Row();
                    $array[] = $producto;
                }
                return $array;
            }

            return false;
        }

        public function newCotVigItem($iCotVig_id, $ftItem_Longitud, $ftItem_P1, $ftItem_P2, $ftItem_Ancho, $iItem_cantidad) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                if ($db->Query('INSERT INTO v_viguetas_cotizacion_items ( iCotVig_id, ftItem_Longitud, ftItem_P1, ftItem_P2, ftItem_Ancho, iItem_cantidad, iStatus_fl) VALUES ( \''.$iCotVig_id.'\', \''.str_replace(',', '.', $ftItem_Longitud).'\', \''.str_replace(',', '.', $ftItem_P1).'\', \''.str_replace(',', '.', $ftItem_P2).'\', \''.str_replace(',', '.', $ftItem_Ancho).'\', \''.$iItem_cantidad.'\', \'1\' )')) {
                    return $db->GetLastInsertID();
                } else {
                    return false;
                }
            }
        }

        public function getProductDataByCodSAP($codSAP, $codOficina) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT p.*, pr.cantidad as precio FROM tp_producto_sap as p LEFT JOIN tp_precio as pr ON pr.codProducto = p.codProducto WHERE pr.codOficina = \''.$codOficina.'\' AND p.codSAP = \''.$codSAP.'\' AND pr.baja = \'0\' AND p.baja = \'0\'';

                if ($db->HasRecords($consulta)) {
                    $db->Query($consulta);
                    return $db->Row();
                } else {
                    return false;
                }
            }
        }

        public function getCotVigItemData($iItem_id) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT * FROM v_viguetas_cotizacion_items WHERE iItem_id = \''.$iItem_id.'\' AND iStatus_fl = \'1\'';

                if ($db->HasRecords($consulta)) {
                    $db->Query($consulta);
                    return $db->Row();
                } else {
                    return false;
                }
            }
        }

        public function getCotVigItems($iCotVig_id) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT * FROM v_viguetas_cotizacion_items WHERE iCotVig_id = \''.$iCotVig_id.'\' AND iStatus_fl = \'1\'';

                if ($db->HasRecords($consulta)) {
                    $db->Query($consulta);
                    return $db;
                } else {
                    return false;
                }
            }
        }

        public function newCotVig($codProspecto, $ftAltura_Complemento, $ftCarpeta_Compresion, $ftSeparacion_Ejes, $iSobrecarga) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                if ($db->Query('INSERT INTO v_viguetas_cotizacion ( codProspecto, ftAltura_Complemento, ftCarpeta_Compresion, ftSeparacion_Ejes, iSobrecarga, dtCreacion_date, ftPrecio_Total, ftDescuento, iTipo_fl, iStatus_fl ) VALUES ( \''.$codProspecto.'\', \''.$ftAltura_Complemento.'\', \''.str_replace(',', '.', $ftCarpeta_Compresion).'\', \''.$ftSeparacion_Ejes.'\', \''.$iSobrecarga.'\', \''.date('Y-m-d H:i:s').'\', \'0.00\', \'0.00\', \'1\', \'1\' )')) {
                    return $db->GetLastInsertID();
                } else {
                    return false;
                }
            }
        }

        public function getCotVigData($iCotVig_id) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT * FROM v_viguetas_cotizacion WHERE iCotVig_id = \''.$iCotVig_id.'\'';
                if ($db->HasRecords($consulta)) {
                    $db->Query($consulta);
                    return $db->Row();
                } else {
                    return false;
                }
            }
        }

        public function getAllViguetasByProspecto($codProspecto) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT cotvig.dtConsolidado_date, cotvig.sConsolidado_doc, cotvig.dtCreacion_date as dtCreacion_date, cotvig.iCotVig_id as iCotVig_id, e.descripcion as estado, m.descripcion as motivoSuspension FROM v_viguetas_cotizacion as cotvig LEFT JOIN motivo_suspension as m ON m.codMotivoSuspension = cotvig.codMotivoSuspension LEFT JOIN tp_estado as e ON e.codEstado = cotvig.iStatus_fl WHERE cotvig.codProspecto = \''.$codProspecto.'\'';

                if ($db->HasRecords($consulta)) {
                    $db->Query($consulta);
                    return $db;
                } else {
                    return false;
                }
            }
        }

        public function changeCotVigStatus($iCotVig_id, $iStatus_fl, $codMotivoSuspension = NULL) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT * FROM v_viguetas_cotizacion WHERE iCotVig_id = \''.$iCotVig_id.'\'';

                if ($db->HasRecords($consulta)) {
                    if ($iStatus_fl == 2) {
                        $db->Query('UPDATE v_viguetas_cotizacion SET iStatus_fl = \''.$iStatus_fl.'\', codMotivoSuspension = \''.$codMotivoSuspension.'\' WHERE iCotVig_id = \''.$iCotVig_id.'\'');
                    } else {
                        $db->Query('UPDATE v_viguetas_cotizacion SET iStatus_fl = \''.$iStatus_fl.'\' WHERE iCotVig_id = \''.$iCotVig_id.'\'');
                    }
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function consolidarCotVig($iCotVig_id, $iStatus_fl, $ftPrecio_total, $ftDescuento, $sConsolidado_doc) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT * FROM v_viguetas_cotizacion WHERE iCotVig_id = \''.$iCotVig_id.'\'';

                if ($db->HasRecords($consulta)) {
                    $db->Query('UPDATE v_viguetas_cotizacion SET iStatus_fl = \''.$iStatus_fl.'\', ftPrecio_Total = \''.$ftPrecio_total.'\', ftDescuento = \''.$ftDescuento.'\', sConsolidado_doc = \''.$sConsolidado_doc.'\', dtConsolidado_date = \''.date('Y-m-d H:i:s').'\' WHERE iCotVig_id = \''.$iCotVig_id.'\'');
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function saveCotVig($iCotVig_id, $ftAltura_Complemento, $ftCarpeta_Compresion, $ftSeparacion_Ejes, $iSobrecarga, $ftPrecio_Total, $ftDescuento) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT * FROM v_viguetas_cotizacion WHERE iCotVig_id = \''.$iCotVig_id.'\'';

                if ($db->HasRecords($consulta)) {
                    $db->Query('UPDATE v_viguetas_cotizacion SET ftAltura_Complemento = \''.$ftAltura_Complemento.'\', ftCarpeta_Compresion = \''.$ftCarpeta_Compresion.'\', ftSeparacion_Ejes = \''.$ftSeparacion_Ejes.'\', iSobrecarga = \''.$iSobrecarga.'\', ftPrecio_Total = \''.$ftPrecio_Total.'\', ftDescuento = \''.$ftDescuento.'\' WHERE iCotVig_id = \''.$iCotVig_id.'\'');
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function changeItemStatus($iItem_id, $iStatus_fl) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT * FROM v_viguetas_cotizacion_items WHERE iItem_id = \''.$iItem_id.'\'';

                if ($db->HasRecords($consulta)) {
                    $db->Query('UPDATE v_viguetas_cotizacion_items SET iStatus_fl = \''.$iStatus_fl.'\' WHERE iItem_id = \''.$iItem_id.'\'');
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function saveItem($iItem_id, $ftItem_Longitud, $ftItem_P1, $ftItem_P2, $ftItem_Ancho, $iItem_cantidad) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT * FROM v_viguetas_cotizacion_items WHERE iItem_id = \''.$iItem_id.'\'';

                if ($db->HasRecords($consulta)) {
                    $db->Query('UPDATE v_viguetas_cotizacion_items SET ftItem_Longitud = \''.$ftItem_Longitud.'\', ftItem_P1 = \''.$ftItem_P1.'\', ftItem_P2 = \''.$ftItem_P2.'\', ftItem_Ancho = \''.$ftItem_Ancho.'\', iItem_cantidad = \''.$iItem_cantidad.'\' WHERE iItem_id = \''.$iItem_id.'\'');
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function changeTipoViguetas($iCotVig_id, $iTipo_fl) {
            $db = new MySQL();

            if ($db->Error()) {
                $db->Kill();
                return false;
            } else {
                $consulta = 'SELECT * FROM v_viguetas_cotizacion WHERE iCotVig_id = \''.$iCotVig_id.'\'';

                if ($db->HasRecords($consulta)) {
                    $db->Query('UPDATE v_viguetas_cotizacion SET iTipo_fl = \''.$iTipo_fl.'\' WHERE iCotVig_id = \''.$iCotVig_id.'\'');
                    return true;
                } else {
                    return false;
                }
            }
        }

    /* NEW VIGUETAS */

    public function deleteView($view) {
        $db = new MySQL();

        $q = 'DROP VIEW '.$view;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->Query($q)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function listAllByProspect($codProspecto, $conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT v_viguetas.*, tp_estado.descripcion as estado, motivo_suspension.descripcion as motivoSuspension FROM v_viguetas LEFT JOIN motivo_suspension ON motivo_suspension.codMotivoSuspension = v_viguetas.codMotivoSuspension LEFT JOIN tp_estado ON tp_estado.codEstado = v_viguetas.iStatus_fl WHERE codProspecto = \''.$codProspecto.'\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW viguetas AS '.$generalView.'');
                $data = 'SELECT * FROM viguetas';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('viguetas');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllPDFs($iVigueta_id) {
        $db = new MySQL();

        $generalView = 'SELECT * FROM v_viguetas_reportes WHERE iVigueta_id = \''.$iVigueta_id.'\'';

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW viguetas AS '.$generalView.'');
                $data = 'SELECT * FROM viguetas';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('viguetas');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllByVigueta($iVigueta_id, $conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM v_viguetas_items WHERE iVigueta_id = \''.$iVigueta_id.'\' AND iStatus_fl = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW items AS '.$generalView.'');
                $data = 'SELECT * FROM items';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('items');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function getViguetaData($iVigueta_id, $conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT v_viguetas.*, tp_estado.descripcion as estado FROM v_viguetas LEFT JOIN tp_estado ON v_viguetas.iStatus_fl = tp_estado.codEstado WHERE iVigueta_id = \''.$iVigueta_id.'\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW viguetas AS '.$generalView.'');
                $data = 'SELECT * FROM viguetas';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('viguetas');
                    return $db->Row();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function cabeceraPDF($iVigueta_id, $conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT u.codOficina as codOficina, pr.nombre, pr.telefono, pr.email, pr.telefonoContacto, CONCAT(per.nombre, \' \', per.apePat) as ejecutivo, o.descripcion as local, o.direccion as direccionlocal, o.ciudad as ciudad, o.telefono as telefonolocal, DATE_FORMAT(SYSDATE(), \'%d/%m/%Y\') as fecha, o.logo as imagenempresa, pr.codProspecto from v_viguetas as v left join prospecto as pr ON pr.codProspecto = v.codProspecto left join usuario as u ON u.codUsuario = pr.codUsuario left join persona as per ON per.codPersona = u.codPersona left join oficina as o ON o.codOficina = u.codOficina WHERE iVigueta_id = \''.$iVigueta_id.'\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW viguetas AS '.$generalView.'');
                $data = 'SELECT * FROM viguetas';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('viguetas');
                    return $db->Row();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function getProductoBySAP($codSAP, $codOficina, $conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT p.cantidad as precio, sap.descripcion as descripcion, unid.descripcion as unidInv FROM tp_precio p LEFT JOIN tp_producto_sap as sap ON sap.codProducto = p.codProducto LEFT JOIN tp_unidad_inventario as unid ON unid.codUnidInv = sap.codUnidInv WHERE p.codSAP = \''.$codSAP.'\' AND p.codOficina = \''.$codOficina.'\' AND p.baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW viguetas AS '.$generalView.'');
                $data = 'SELECT * FROM viguetas';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('viguetas');
                    return $db->Row();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function getItemData($iItem_id, $conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT v_viguetas_items.* FROM v_viguetas_items WHERE iItem_id = \''.$iItem_id.'\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW viguetas AS '.$generalView.'');
                $data = 'SELECT * FROM viguetas';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('viguetas');
                    return $db->Row();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function getPesoPropio($iAltura_total, $sTipo, $iEspacio_ejes) {
        $db = new MySQL();

        $generalView = 'SELECT * FROM v_viguetas_tablafija WHERE iAltura_total = \''.$iAltura_total.'\' AND sTipo = \''.$sTipo.'\' AND iEspacio_ejes = \''.$iEspacio_ejes.'\' AND iStatus_fl = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW viguetas AS '.$generalView.'');
                $data = 'SELECT * FROM viguetas';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('viguetas');
                    return $db->Row();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function getTipoVigueta($iAltura_complemento, $iSeparacion_ejes, $iMomento) {
        $db = new MySQL();

        $generalView = 'SELECT * FROM v_momento WHERE a = \''.$iAltura_complemento.'\' and b = \''.$iSeparacion_ejes.'\' and momento > \''.$iMomento.'\' ORDER BY momento ASC LIMIT 0,1';

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW viguetas AS '.$generalView.'');
                $data = 'SELECT * FROM viguetas';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('viguetas');
                    return $db->Row();
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function insertViguetaByProspect($codProspecto, $iAltura_complemento, $iCarpeta_compresion, $iSeparacion_ejes, $iSobrecarga) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            $db->Query('INSERT INTO v_viguetas(codProspecto,iAltura_complemento,iSeparacion_ejes,iSobrecarga, iCarpeta_compresion, dtCreated_date, iStatus_fl) VALUES (\''.$codProspecto.'\',\''.$iAltura_complemento.'\',\''.$iSeparacion_ejes.'\',\''.$iSobrecarga.'\',\''.$iCarpeta_compresion.'\', \''.(new \DateTime())->format('Y-m-d H:i:s').'\', \'1\')');
            $id = $db->GetLastInsertID();
            $data = 'SELECT * FROM v_viguetas WHERE iVigueta_id = \''.$id.'\' AND iStatus_fl = \'1\'';
            if ($db->HasRecords($data)) {
                $db->Query($data);
                return $db;
            } else {
                return false;
            }
        }
    }

    public function registrarPDF($iVigueta_id, $iReporte_tipo) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            $db->Query('INSERT INTO v_viguetas_reportes(iReporte_tipo,iVigueta_id,dtReporte_fecha,iStatus_fl) VALUES (\''.$iReporte_tipo.'\',\''.$iVigueta_id.'\',\''.(new \DateTime())->format('Y-m-d H:i:s').'\',\'0\')');
            $id = $db->GetLastInsertID();
            $data = 'SELECT * FROM v_viguetas_reportes WHERE iReporte_id = \''.$id.'\' AND iStatus_fl = \'0\'';
            if ($db->HasRecords($data)) {
                $db->Query($data);
                return $db;
            } else {
                return false;
            }
        }
    }

    public function insertItemByVigueta($iVigueta_id, $iLongitud, $iPestana1_longitud, $iPestana2_longitud, $iAncho) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            $db->Query('INSERT INTO v_viguetas_items(iVigueta_id,iLongitud,iPestana1_longitud, iPestana2_longitud, iAncho, iStatus_fl) VALUES (\''.$iVigueta_id.'\',\''.$iLongitud.'\',\''.$iPestana1_longitud.'\',\''.$iPestana2_longitud.'\',\''.$iAncho.'\', \'0\')');
            $id = $db->GetLastInsertID();
            $data = 'SELECT * FROM v_viguetas_items WHERE iItem_id = \''.$id.'\' AND iStatus_fl = \'0\'';
            if ($db->HasRecords($data)) {
                $db->Query($data);
                return $db;
            } else {
                return false;
            }
        }
    }

    public function removeViguetaById($iVigueta_id, $ddmotivobaja) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if (!$db->Query('UPDATE v_viguetas SET iStatus_fl = \'2\', codMotivoSuspension = \''.$ddmotivobaja.'\' WHERE iVigueta_id = \''.$iVigueta_id.'\'')) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function removeItemById($iItem_id) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if (!$db->Query('UPDATE v_viguetas_items SET iStatus_fl = \'2\' WHERE iItem_id = \''.$iItem_id.'\'')) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function consolidarVigueta($iVigueta_id) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if (!$db->Query('UPDATE v_viguetas SET iStatus_fl = \'4\' WHERE iVigueta_id = \''.$iVigueta_id.'\'')) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function editarVigueta($iVigueta_id, $iAltura_complemento, $iCarpeta_compresion, $iSeparacion_ejes, $iSobrecarga, $iTipo_Vigueta) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if (!$db->Query('UPDATE v_viguetas SET iAltura_complemento = \''.$iAltura_complemento.'\', iCarpeta_compresion = \''.$iCarpeta_compresion.'\', iSeparacion_ejes = \''.$iSeparacion_ejes.'\', iSobrecarga = \''.$iSobrecarga.'\', iTipo_Vigueta = \''.$iTipo_Vigueta.'\' WHERE iVigueta_id = \''.$iVigueta_id.'\'')) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function editarItem($iItem_id, $iLongitud, $iPestana1_longitud, $iPestana2_longitud, $iAncho) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if (!$db->Query('UPDATE v_viguetas_items SET iLongitud = \''.$iLongitud.'\', iPestana1_longitud = \''.$iPestana1_longitud.'\', iPestana2_longitud = \''.$iPestana2_longitud.'\', iAncho = \''.$iAncho.'\' WHERE iItem_id = \''.$iItem_id.'\'')) {
                return false;
            } else {
                return true;
            }
        }
    }

}

?>
