<?php
require_once "../clases/mysql.class.php";

class SistConst {

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

    public function listAll($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM tp_sistema_constructivo WHERE baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW sistConstList AS '.$generalView.'');
                $data = 'SELECT * FROM sistConstList';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('sistConstList');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllProductos($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM tp_producto_sap WHERE baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW productosList AS '.$generalView.'');
                $data = 'SELECT * FROM productosList';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('productosList');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllProductSistConst($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM tp_sistema_producto WHERE baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW sisProdList AS '.$generalView.'');
                $data = 'SELECT * FROM sisProdList';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('sisProdList');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllClasificacion($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM tp_clase_sistema WHERE baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW claseSists AS '.$generalView.'');
                $data = 'SELECT * FROM claseSists';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('claseSists');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllTipo($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM tp_subtipo_sistema WHERE baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW tipoList AS '.$generalView.'');
                $data = 'SELECT * FROM tipoList';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('tipoList');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllRelacionesCount($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT codSistema, COUNT(*) as count FROM tp_sistema_producto WHERE baja = \'0\''.$conditions.' GROUP BY codSistema';

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW relacionList AS '.$generalView.'');
                $data = 'SELECT * FROM relacionList';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('relacionList');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllUnidFam($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM tp_unidad_familia WHERE baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW unidFamList AS '.$generalView.'');
                $data = 'SELECT * FROM unidFamList';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('unidFamList');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllUnidInv($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM tp_unidad_inventario WHERE baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW unidInvList AS '.$generalView.'');
                $data = 'SELECT * FROM unidInvList';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('unidInvList');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllGrupos($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM tp_grupo WHERE baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW grupoList AS '.$generalView.'');
                $data = 'SELECT * FROM grupoList';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('grupoList');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllTipoArt($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM tp_tipo_articulo WHERE baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW tipoArtList AS '.$generalView.'');
                $data = 'SELECT * FROM tipoArtList';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('tipoArtList');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function listAllSubTipo($conditions = '') {
        $db = new MySQL();

        $generalView = 'SELECT * FROM tp_subtipo_articulo WHERE baja = \'0\''.$conditions;

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if ($db->HasRecords($generalView)) {
                $db->Query('CREATE OR REPLACE VIEW subtipoArtList AS '.$generalView.'');
                $data = 'SELECT * FROM subtipoArtList';
                if ($db->HasRecords($data)) {
                    $db->Query($data);
                    $this->deleteView('subtipoArtList');
                    return $db;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function insertSistConst($codClaseSistema, $codSubtipoSistema, $descripcion) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            $db->Query('INSERT INTO tp_sistema_constructivo(codClaseSistema,codSubtipoSistema,descripcion,baja) VALUES (\''.$codClaseSistema.'\',\''.$codSubtipoSistema.'\',\''.$descripcion.'\', \'0\')');
            $id = $db->GetLastInsertID();
            $data = 'SELECT * FROM tp_sistema_constructivo WHERE codSistema = \''.$id.'\' AND baja = \'0\'';
            if ($db->HasRecords($data)) {
                $db->Query($data);
                return $db;
            } else {
                return false;
            }
        }
    }

    public function insertRelacion($codSistema, $codProducto) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            $orden = 0;
            $db->Query('SELECT * FROM tp_sistema_producto WHERE codSistema = \''.$codSistema.'\' ORDER BY orden DESC LIMIT 1');
            $lastCount = $db->Row();
            $orden = ($lastCount->orden+1);
            $db->Query('INSERT INTO tp_sistema_producto(codSistema, codProducto,orden,baja) VALUES (\''.$codSistema.'\',\''.$codProducto.'\',\''.$orden.'\', \'0\')');
            $id = $db->GetLastInsertID();
            $data = 'SELECT * FROM tp_sistema_producto WHERE codSistProducto = \''.$id.'\' AND baja = \'0\'';
            if ($db->HasRecords($data)) {
                $db->Query($data);
                return $db;
            } else {
                return false;
            }
        }
    }

    public function updateSistConst($id,$codClaseSistema, $codSubtipoSistema, $descripcion) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if (!$db->Query('UPDATE tp_sistema_constructivo SET codClaseSistema = \''.$codClaseSistema.'\', codSubtipoSistema = \''.$codSubtipoSistema.'\', descripcion = \''.$descripcion.'\' WHERE codSistema = \''.$id.'\'')) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function removeSistConst($codSistema) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if (!$db->Query('UPDATE tp_sistema_constructivo SET baja = \'1\' WHERE codSistema = \''.$codSistema.'\'')) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function removeSistProducto($codSistProducto) {
        $db = new MySQL();

        if ($db->Error()) {
            $db->Kill();
            return false;
        } else {
            if (!$db->Query('UPDATE tp_sistema_producto SET baja = \'1\' WHERE codSistProducto = \''.$codSistProducto.'\'')) {
                return false;
            } else {
                return true;
            }
        }
    }
}

?>
