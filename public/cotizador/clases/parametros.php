<?php

include_once ("../clases/mysql.class.php");
include_once ("../clases/usuario.php");

class parametros{

	public $mensaje="";


    public function DropDownTipoObra($codTipoObra){
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM tp_tipo_obra where baja='0' ")) $db->Kill();
		$db->MoveFirst();
		while (! $db->EndOfSeek()){
			$row = $db->Row();
            if($codTipoObra==$row->codTipoObra){
                $select="selected";
            }else{
                $select="";
            }
			echo "<option value='".$row->codTipoObra."' $select>".$row->nombre."</option>";
		}
    }
    //***********************************************************************************************
    public function DropDownTipoProyecto($codTipoProyecto){
        $db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM tp_tipo_proyecto where baja='0' ")) $db->Kill();
		$db->MoveFirst();
		while (! $db->EndOfSeek()){
			$row = $db->Row();
            if($codTipoProyecto==$row->codTipoObra){
                $select="selected";
            }else{
                $select="";
            }
			echo "<option value='".$row->codTipoProyecto."'>".$row->nombre."</option>";
		}
    }
    //***********************************************************************************************
	public function DropDownSistemas(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM sistema where baja='0' ")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codSistema."'>".$row->descripcion."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownSoporte(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT sop.codSoporte, CONCAT(per.nombre, ' ', per.paterno ) as soporte FROM soporte sop left join persona  per on per.codPersona=sop.codPersona")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codSoporte."'>".$row->soporte."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownExtensiones($ext=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM extension ")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			if ($ext==$row->descripcion){
                echo "<option value='".$row->codExtension."' selected>".$row->descripcion."</option>";
            }else{
                echo "<option value='".$row->codExtension."'>".$row->descripcion."</option>";
            }
		}
	}


	public function DropDownExtensionesLBC($codExp){
			$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM extension ")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			if ($codExp==$row->codLBC){
                echo "<option value='".$row->codLBC."' selected>".$row->descripcion."</option>";
            }else{
                echo "<option value='".$row->codLBC."'>".$row->descripcion."</option>";
            }
		}
	}
	//***********************************************************************************************

	//***********************************************************************************************
	public function DropDownEstados(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM estado where baja='0' ")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codEstado."'>".$row->descripcion."</option>";
		}

	}
    //***********************************************************************************************
	public function DropDownEstadosProspectos($codestado){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM estado_prospecto where activo='1' ")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            $selected="";
            if ($codestado==$row->codEstadoProspecto) $selected="selected";
			echo "<option value='".$row->codEstadoProspecto."' $selected >".$row->descripcion."</option>";
		}

	}
    //***********************************************************************************************
	public function DropDownEstadoCom($estado="", $codigo=""){
		$db = new MySQL();
        echo "<option value='0'>Seleccionar</option>";

		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM estado_com where baja='0' ")) $db->Kill();
		$db->MoveFirst();
		$selected="";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if (($estado==$row->nombre)||($codigo==$row->codEstadoCom)){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codEstadoCom."' $selected>".$row->nombre."</option>";
		}

	}
    //***********************************************************************************************
	public function DropDownUbicaciones($ubicacion="", $codUbicacion=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM ubicacion where baja='0' ")) $db->Kill();
		$db->MoveFirst();
		$selected="";
        echo "<option value='0'>Seleccionar</option>";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if (($ubicacion==$row->nombre)||($codUbicacion==$row->codUbicacion)){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codUbicacion."' $selected>".$row->nombre."</option>";
		}

	}
    //***********************************************************************************************
	public function DropDownEstadoOp($estado=""){
		$db = new MySQL();
        echo "<option value='0'>Seleccionar</option>";

		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM estado_op where baja='0' ")) $db->Kill();
		$db->MoveFirst();
		$selected="";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($estado==$row->nombre){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codEstadoOp."' $selected>".$row->nombre."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownTipoSolucion(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM tiposolucion where baja='0' ")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codTipoSolucion."'>".$row->descripcion."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownPais(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM pais ")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codPais."'>".$row->descripcion."</option>";
		}

	}
    //***********************************************************************************************
    public function DropDownProveedor(){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        if (! $db->Query("SELECT pro.codProveedor, emp.nombre as proveedor
        FROM proveedor as pro left join empresa as emp on emp.codEmpresa=pro.codEmpresa ")) $db->Kill();
        $db->MoveFirst();

        while (! $db->EndOfSeek()) {
            $row = $db->Row();
            echo "<option value='".$row->codProveedor."'>".$row->proveedor."</option>";
        }

    }

	//***********************************************************************************************
	public function DropDownTipoIncidente($codSistema){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM tipoincidente where baja='0' and codSistema=$codSistema ")) $db->Kill();
		$db->MoveFirst();
		$cont=0;
		echo "<option value='0'>Seleccionar</option>";
		while (! $db->EndOfSeek()) {
			$cont=$con+1;
			$row = $db->Row();
			//echo "<hr>123";
			echo "<option value='".$row->codTipoIncidente."'>".$row->descripcion."</option>";
			//echo "456";
		}

		//echo "SELECT * FROM tipoincidente where baja='0' and codSistema=$codSistema ";

	}
	//***********************************************************************************************
	public function DropDownOficina($codOficina=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM oficina where baja='0' ")) $db->Kill();
		$db->MoveFirst();
		$cont=0;
		echo "<option value='0'>Seleccionar</option>";
		while (! $db->EndOfSeek()) {
            $selected="";
			$cont=$con+1;
			$row = $db->Row();
			if ($row->codOficina==$codOficina) $selected="selected";
			echo "<option value='".$row->codOficina."' $selected>".$row->descripcion."</option>";
		}

		//echo "SELECT * FROM tipoincidente where baja='0' and codSistema=$codSistema ";

	}
    //***********************************************************************************************
	public function DropDownOficinaFiltrado($codVendedor,$codOficina=""){
			$db = new MySQL();
		if ($db->Error()) $db->Kill();
        //--------------------------------------------------------------------------------
            $condicion="";
            $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codVendedor);
            $perfil= $iUsuario->obtenerPerfil();
            if (($perfil!="Gerencia")&&($perfil!="Superusuario") &&($perfil!="Comunity Manager")){
               $condicion.=" and o.codOficina in (select distinct codOficina from usuario where codUsuario='$codVendedor')";
            }
        //--------------------------------------------------------------------------------
        $consulta=" select o.codOficina, o.descripcion as oficina from oficina as o where 1=1 ".$condicion." order by o.descripcion ";
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="";
        if (($perfil=="Gerencia")||($perfil=="Superusuario") || ($perfil=="Comunity Manager")){
            echo "<option value=''>Todos</option>";
        }else{
            //echo "<option value=''>".$perfil."</option>";
        }
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codOficina==$row->codOficina){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codOficina."' $selected>".ucwords(strtolower($row->oficina))."</option>";
		}

	}


	//***********************************************************************************************
	public function DropDownOrigenProspectos($origen="", $codorigen=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM origen_prospecto where baja=0 and tipoorigen is null  order by codOrigenProspecto asc")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if (($origen==$row->descripcion)||($codorigen==$row->codOrigenProspecto)){
                echo "<option value='".$row->codOrigenProspecto."' selected>".$row->descripcion."</option>";
            }else{
                echo "<option value='".$row->codOrigenProspecto."'>".$row->descripcion."</option>";
            }

		}

	}



		public function DropDownOrigenProspectos3($origen="", $codorigen=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM origen_prospecto where baja=0 ")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if (($origen==$row->descripcion)||($codorigen==$row->codOrigenProspecto)){
                echo "<option value='".$row->codOrigenProspecto."' selected>".$row->descripcion."</option>";
            }else{
                echo "<option value='".$row->codOrigenProspecto."'>".$row->descripcion."</option>";
            }

		}

	}


	public function DropDownOrigenProspectosLBC($codOficina,$usuario){
		if ($codOficina=='5') {
			$condicion=" and tipoorigen is not null";
		}
		else
		{
			$condicion=" and tipoorigen is null";
		}


			$iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($usuario);
            $ofic= $iUsuario->obtenerOficina();
            
            $condicionadicional="";

            if ($ofic!=3) {
            	$condicionadicional=" and codOrigenProspecto not in (5)";
            }
		

		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM origen_prospecto where baja=0 $condicion $condicionadicional order by codOrigenProspecto asc")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if (($origen==$row->descripcion)||($codorigen==$row->codOrigenProspecto)){
                echo "<option value='".$row->codOrigenProspecto."' selected>".$row->descripcion."</option>";
            }else{
                echo "<option value='".$row->codOrigenProspecto."'>".$row->descripcion."</option>";
            }

		}

	}
	public function DropDownOrigenProspectos2($salon){

		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM origen_prospecto where tipoorigen is not null and descripcion='$salon' order by descripcion desc")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if (($origen==$row->descripcion)||($codorigen==$row->codOrigenProspecto)){
                echo "<option value='".$row->codOrigenProspecto."' selected>".$row->descripcion."</option>";
            }else{
                echo "<option value='".$row->codOrigenProspecto."'>".$row->descripcion."</option>";
            }

		}

	}
	//***********************************************************************************************
	public function DropDownTipoMedio($tipo=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM tipo_medio")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($tipo==$row->descripcion){
                echo "<option value='".$row->codTipoMedio."' selected >".$row->descripcion."</option>";
            }else{
                echo "<option value='".$row->codTipoMedio."'>".$row->descripcion."</option>";
            }

		}

	}
	//***********************************************************************************************
	public function DropDownMedio($codtipo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM medio where codTipoMedio=$codtipo order by descripcion")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codMedio."'>".$row->descripcion."</option>";
		}

	}
	//***********************************************************************************************
	
	public function DropDownMedio2($medio=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM medio where codTipoMedio=(select codTipoMedio from medio where descripcion='$medio' limit 1) order by descripcion")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($medio==$row->descripcion){
                echo "<option value='".$row->codMedio."' selected>".$row->descripcion."</option>";
            }else{
                echo "<option value='".$row->codMedio."'>".$row->descripcion."</option>";
            }

		}

	}
	//***********************************************************************************************
	public function DropDownTipoContacto(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("select * from tipo_contacto where baja='0'")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codTipoContacto."'>".$row->descripcion."</option>";
		}

	}
    //***********************************************************************************************
	public function DropDownTipoArchivo(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("select * from tipo_archivo where baja='0'")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codTipoArchivo."'>".$row->descripcion."</option>";
		}

	}

	public function DropDownTipoArchivoProspecto($codTipoDocumento){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("select * from tipo_archivo where baja='0' and notificacionCarrera is null and codTipoDocumento='$codTipoDocumento' ")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codTipoArchivo."'>".$row->descripcion."</option>";
		}

	}

	public function DropDownTipoArchivoRenovacion($codTipoDocumento){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("select * from tipo_archivo where baja='0' and codTipoDocumento='$codTipoDocumento' ")) $db->Kill();
		$db->MoveFirst();

		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codTipoArchivo."'>".$row->descripcion."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownMarca($marca="", $codmar="", $codUsuario=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $logico=false;
        $db->Query("SELECT * FROM usuariomarca where codUsuario=$codUsuario and baja='0' ");
        $consulta="select * from marca ";
        if($db->rowCount()>0){
            $logico=true;
            $consulta="select m.* from marca as m inner join usuariomarca as um on um.codMarca=m.codMarca where um.codUsuario=$codUsuario and um.baja='0' ";
        }

		if (!$db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if (($marca==$row->descripcion)||($codmar==$row->codMarca)){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codMarca."' $selected>".$row->descripcion."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownModelo($codmarca, $modelo="", $codmod=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        $consulta="SELECT * FROM modelo where codMarca='$codmarca' order by nombre";
        $this->mensaje=$consulta;
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
        $selected="";
		echo "<option value='0'>Seleccionar</option>";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if (($modelo==$row->nombre)||($codmod==$row->codModelo)){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codModelo."' $selected >".$row->nombre."</option>";
		}

	}
    //***********************************************************************************************
    public function DropDownCiudad($codCiudad=""){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        echo "<option value='0'>Seleccionar</option>";

        if (! $db->Query("select * from ciudad order by nombre")) $db->Kill();
        $db->MoveFirst();
        $selected="";
        while (! $db->EndOfSeek()) {
            $row = $db->Row();
            if ($codCiudad==$row->codCiudad){
                $selected="selected";
            }else{
                $selected="";
            }
            echo "<option value='".$row->codCiudad."' $selected>".$row->nombre."</option>";
        }

    }
	//***********************************************************************************************
	
	public function DropDownColor($codmodelo, $codcolor=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		echo "<option value='0'>Seleccionar</option>";

        if (! $db->Query("SELECT * FROM color where codModelo='$codmodelo' order by nombre")) $db->Kill();
		$db->MoveFirst();
		$selected="";
        while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codcolor==$row->codColor){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codColor."' $selected>".$row->nombre."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownColorInterno($codmodelo, $codcolorinterior){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM color_int where codModelo=$codmodelo order by nombre")) $db->Kill();
		$db->MoveFirst();
		echo "<option value='0'>Seleccionar</option>";
		$selected="";
        while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codcolorinterior==$row->codColorInt){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codColorInt."' $selected>".$row->nombre."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownTipo($codmodelo, $codTipo=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM tipo where codModelo='$codmodelo' order by nombre")) $db->Kill();
		$db->MoveFirst();
		echo "<option value='0'>Seleccionar</option>";
        $selected="";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codTipo==$row->codTipo){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codTipo."' $selected>".$row->nombre."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownSubTipo($codtipo, $codSubTipo=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM subtipo where codTipo=$codtipo order by nombre")) $db->Kill();
		$db->MoveFirst();
		echo "<option value='0'>Seleccionar</option>";
        $selected="";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
             if ($codSubTipo==$row->codSubTipo){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codSubTipo."' $selected>".$row->nombre."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownAnioComercial($codmodelo="", $anio=""){
		$db = new MySQL();
        $condicion="";
		if ($db->Error()) $db->Kill();
        if ($codmodelo!=""){
            $condicion=" and codModelo=$codmodelo";
        }
        $consulta="select distinct anMod from vehiculo where 1=1 $condicion union select distinct anFab from vehiculo where '1'='1' $condicion union select year(SYSDATE()) union select year(SYSDATE()) + 1  order by anMod desc ";
        //echo $consulta;
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		echo "<option value='0'>Seleccionar</option>";
        $selected="";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($anio==$row->anMod){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->anMod."' $selected>".$row->anMod."</option>";
		}

	}
    //***********************************************************************************************
    public function DropDownGestiones($gestion=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("select distinct anio from (
SELECT distinct anMod anio from vehiculo union all SELECT distinct anFab anio from vehiculo union all select Year(SYSDATE()) as anio union all select Year(SYSDATE()) + 1 as anio union all select Year(SYSDATE()) -1 as anio ) as tabla order by anio desc ")) $db->Kill();
		$db->MoveFirst();
		while (! $db->EndOfSeek()) {
			$selected="";
            $row = $db->Row();
            if ($row->anio==$gestion) $selected="selected";
			echo "<option value='".$row->anio."' $selected>".$row->anio."</option>";
		}

	}
	//***********************************************************************************************
	public function DropDownFormaPago(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM forma_pago where baja='0' order by descripcion")) $db->Kill();
		$db->MoveFirst();
		echo "<option value='0'>Seleccionar</option>";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<option value='".$row->codFormaPago."'>".$row->descripcion."</option>";
		}

	}
	//*************************************************************************************************************************
	//																								******************************
	//	AQUI EMPIEZAN LAS LISTAS																	***********************************
	//																								****************************************
	//*******************************************************************************************************************************************
	public function listarColegios(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM colegio")) $db->Kill();
		$db->MoveFirst();
		echo "<table class='tablesorter table table-bordered hasFilters tablesorter-bootstrap'>";
		echo "<tr class='tablesorter-headerRow'>";
		echo "<th class='tablesorter-header bootstrap-header'><div class='tablesorter-wrapper' style='position:relative;height:100%;width:100%'><div class='tablesorter-header-inner'>
Codigo <i class='tablesorter-icon bootstrap-icon-unsorted'></i></div></div></th>";
		echo "<th class='tablesorter-header bootstrap-header'><div class='tablesorter-wrapper' style='position:relative;height:100%;width:100%'><div class='tablesorter-header-inner'>
Nombre colegio <i class='tablesorter-icon bootstrap-icon-unsorted'></i></div></div></th>";
		echo "<th class='tablesorter-header bootstrap-header'><div class='tablesorter-wrapper' style='position:relative;height:100%;width:100%'><div class='tablesorter-header-inner'>
Estado <i class='tablesorter-icon bootstrap-icon-unsorted'></i></div></div></th>";
		echo "</tr>";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			echo "<tr class='odd'>";
			echo "<td>".$row->codColegio. "</td>";
			echo "<td>".$row->descripcion. "</td>";
			if ($row->baja=="0"){
				echo "<td>Activo</td>";
			}else{
				echo "<td>Eliminado</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}

	//*****************************************************
	public function ObtenerSistema($codSistema){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM sistema where codSistema='".$codSistema."' ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->descripcion;
		}
	}
	//*****************************************************
	public function ObtenerEstado($codEstado){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM estado where codEstado='".$codEstado."' ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->descripcion;
		}

	}

	//*****************************************************
	public function ObtenerTipo($codTipo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM tipoincidente where codTipoIncidente='".$codTipo."' ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->descripcion;
		}

	}
	//*****************************************************
	public function ObtenerProductoxDesc($desc){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM producto where codigo='".$desc."' limit 1 ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->descripcion;
		}

	}
	//*****************************************************
	public function ObtenerFecha(){
		$today = getdate();
		$dia=$today["mday"];
		$mes=$this->ConvertirMes($today["mon"]);
		$anio=$today["year"];
		echo "$dia de $mes $anio";
	}
	//*****************************************************
	public function ObtenerOficina($codOficina){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM oficina where codoficina='".$codOficina."' ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->descripcion;
		}

	}
		//*****************************************************
	public function ActualizarEstadoEjecutivo($codEjecutivo,$estado){
		if(is_numeric($estado))
		{
			$consulta="UPDATE usuario set inicializado = NULL where codUsuario='$codEjecutivo'";
			
		}
		else
		{
			$consulta="UPDATE usuario set inicializado=1 where codUsuario='$codEjecutivo'";
		}
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query($consulta)) $db->Kill();
	}


	//*****************************************************
	public function ConvertirMes($nummes){
		switch ($nummes) {
			case "1":
				return "Enero";
			case "2":
				return "Febrero";
			case "3":
				return "Marzo";
			case "4":
				return "Abril";
			case "5":
				return "Mayo";
			case "6":
				return "Junio";
			case "7":
				return "Julio";
			case "8":
				return "Agosto";
			case "9":
				return "Septiembre";
			case "10":
				return "Octubre";
			case "11":
				return "Noviembre";
			case "12":
				return "Diciembre";
			default:
				return "Mes no encontrado:".$nummes.".";
		}
	}
	//*****************************************************
	public function ListarEmpresas(){
		$consulta="select * from empresa where baja='0'";
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
	//*****************************************************
	public function ListarOficinas(){
		$consulta="select * from oficina where baja='0' ";
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
	//*****************************************************
	public function ListarRoles(){
		$consulta="
		select * from rol
		";

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

	//-----------------------------------------------------------------------------------------------------------------------------------------

	public function resultadoAlerta($mensaje){
		return "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Alerta!</strong> ".$mensaje."</div>";
	}
	public function resultadoError($mensaje){
		return "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error!</strong> ".$mensaje."</div>";
	}
	public function resultadoOk($mensaje){
		return "<div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Correcto!</strong> ".$mensaje."</div>";
	}

    //**********************************************
   public function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE)
    {
        $source = 'abcdefghijklmnopqrstuvwxyz';
        if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($n==1) $source .= '1234567890';
        if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
        if($length>0){
            $rstr = "";
            $source = str_split($source,1);
            for($i=1; $i<=$length; $i++){
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,count($source));
                $rstr .= $source[$num-1];
            }

        }
        return $rstr;
    }
//***********************************************************************************************
	public function DropDownVendedores($codVendedor=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT u.codUsuario, u.usuario, CONCAT(nombre,' ', apePat) as nombre
from usuario as u left join persona as p on p.codPersona=u.codPersona where u.codTipoUsuario=2  order by nombre ")) $db->Kill();
		$db->MoveFirst();
		$selected="";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codVendedor==$row->codUsuario){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codUsuario."' $selected>".strtolower($row->nombre)." - ".strtolower($row->usuario)."</option>";
		}

	}


		public function DropDownVendedoresES($codVendedor="",$equipo){
			$condicion="";

			if ($equipo != "" && $equipo != 0) {
				$condicion = " and u.codSalon='$equipo' ";
			}
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT u.codUsuario, u.usuario, CONCAT(nombre,' ', apePat) as nombre
from usuario as u left join persona as p on p.codPersona=u.codPersona where 1 $condicion  order by nombre ")) $db->Kill();
		$db->MoveFirst();
		$selected="";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codVendedor==$row->codUsuario){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codUsuario."' $selected>".strtolower($row->nombre)." - ".strtolower($row->usuario)."</option>";
		}

	}




		//**********************************************************************


	public function DropDownVendedoresxGrupo($codGrupo,$usuario,$oficina){
			 $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($usuario);
            $ofic= $iUsuario->obtenerOficina();
            $perfil= $iUsuario->obtenerPerfil();
	
		if ($codGrupo=='') {

			if ($perfil=="Gerencia")  {
				 if ($oficina!="") {
				 	$condicion= ' and u.codOficina= "'.$oficina.'" ';
				 }
				 else{
				 	$condicion=' and 1=1';	
				 }
				 
			}
			if( $perfil=="Jefatura")
			{
				$condicion= " and (u.codTipoUsuario=2 or u.codTipoUsuario=3 or u.codTipoUsuario=4) and u.codOficina=(select codOficina from usuario where codUsuario='$usuario') ";
			}

			if( $perfil=="Operaciones")
			{
				$condicion= " and (u.codTipoUsuario=2 or u.codTipoUsuario=3) ";
			}
            
		}
		else
		{
			$condicion= 'and u.codSalon='.$codGrupo.'';
		}
		
		 	
	     	
	   
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query(" select u.codUsuario, u.usuario, CONCAT(nombre,' ', apePat) as nombre
from usuario as u left join persona as p on p.codPersona=u.codPersona where u.baja!='1'  ".$condicion." order by CONCAT(nombre,' ', apePat) ")) $db->Kill();
		if ($db->rowCount()>0) {

					$db->MoveFirst();
		$selected="";
		  echo "<option value=''>Todos</option>";
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if (2==1){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codUsuario."' $selected>".strtolower($row->nombre)." - ".strtolower($row->usuario)."</option>";
		}
			
		}
		else
		{
			echo "<option value='0'>vacio</option>";
		}


	}



//***********************************************************************************************
	public function DropDownVendedoresFiltrado($codVendedor, $seleccionado,$eq){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        //--------------------------------------------------------------------------------
            $condicion="";
            $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codVendedor);
            $perfil= $iUsuario->obtenerPerfil();
            $sal= $iUsuario->obtenercodSalon();
            if ($eq=="") {
            	
            }
            else
            {
            if ($perfil=="Gerencia" || ($perfil=="Comunity Manager")){
               $condicion.=" and u.codSalon='$eq'";
            }
        }
            
            if ($perfil=="Jefatura"){
               $condicion.=" and u.codSalon='$eq'";
            }
            if ($perfil=="Vendedor" || $perfil== "Operaciones"){
               $condicion.=" and u.codSalon='$eq'";
            }
        //--------------------------------------------------------------------------------
        $consulta=" select u.codUsuario, u.usuario, CONCAT(nombre,' ', apePat) as nombre
from usuario u left join persona as p on p.codPersona=u.codPersona where u.baja!='1'  ".$condicion." order by CONCAT(nombre,' ', apePat)";
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="";
        if (($perfil!="Vendedor")){
            echo "<option value=''>Todos</option>";
        }
        $contador=0;
		while (! $db->EndOfSeek()) {
			$contador++;
			$row = $db->Row();
            if ($seleccionado==$row->codUsuario){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codUsuario."' $selected>".strtolower($row->nombre)." (".strtolower($row->usuario).")</option>";
		}



	}



//**************************************************************************
public function DropDownVendedoresFiltradojc($codVendedor, $seleccionado,$eq){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        //--------------------------------------------------------------------------------
            $condicion="";
            $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codVendedor);
            $perfil= $iUsuario->obtenerPerfil();
            $sal= $iUsuario->obtenercodSalon();
            if ($eq=="") {
            	
            }
            else
            {
            if ($perfil=="Gerencia" || ($perfil=="Comunity Manager")){
               $condicion.=" and u.codSalon='$eq'";
            }
        }
            
            if ($perfil=="Jefatura"){
               $condicion.=" and u.codSalon='$eq'";
            }
            if ($perfil=="Vendedor" || $perfil== "Operaciones"){
               $condicion.=" and u.codSalon='$eq'";
            }
        //--------------------------------------------------------------------------------
        $consulta=" SELECT  codigousuario,nombre,descripcion FROM( SELECT codigousuario,nombre, ROUND(promedio) as promedio2, descripcion FROM( SELECT  usuario.codUsuario as codigousuario ,  CONCAT(p.nombre,' ', p.apePat) as nombre,usuario.usuario as descripcion, AVG( datediff(fechaCierre,fechaCreacion)) as promedio from prospecto left join usuario on prospecto.codUsuario=usuario.codUsuario left join oficina on oficina.codOficina=usuario.codOficina left join Salon on Salon.codSalon=usuario.codSalon  left join persona as p on p.codPersona=usuario.codPersona where YEAR(fechaCierre)='2019' and usuario.codSalon='1' group by usuario.codUsuario) as tab1) as tab2";
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="";
        if (($perfil!="Vendedor")){
            echo "<option value=''>Todos</option>";
        }
        $contador=0;
		while (! $db->EndOfSeek()) {
			$contador++;
			$row = $db->Row();
            if ($seleccionado==$row->codigousuario){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codigousuario."' $selected>".strtolower($row->nombre)." (".strtolower($row->descripcion).")</option>";
		}



	}





	public function DropDownVendedoresFiltrado2($codVendedor, $seleccionado){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        //--------------------------------------------------------------------------------
            $condicion="";
            $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codVendedor);
            $perfil= $iUsuario->obtenerPerfil();
            $sal= $iUsuario->obtenercodSalon();
            if (($perfil=="Vendedor")){
                $condicion.=" and u.codUsuario='$codVendedor' ";
            }
            if ($perfil=="Jefatura"){
                $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codVendedor')) and u.codTipoUsuario in (2,3,4) ";
            }
            if ($perfil=="Operaciones") {
            	$condicion.=" and u.codSalon='$sal' and u.codTipoUsuario in (2,3) ";
            }
        //--------------------------------------------------------------------------------
        $consulta=" select u.codUsuario, u.usuario, CONCAT(nombre,' ', apePat) as nombre
from usuario as u left join persona as p on p.codPersona=u.codPersona where u.baja!='1'  ".$condicion." order by CONCAT(nombre,' ', apePat)";
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="";
        if (($perfil!="Vendedor")){
            echo "<option value=''>Todos</option>";
        }
        $contador=0;
		while (! $db->EndOfSeek()) {
			$contador++;
			$row = $db->Row();
            if ($seleccionado==$row->codUsuario){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codUsuario."' $selected>".strtolower($row->nombre)." (".strtolower($row->usuario).")</option>";
		}



	}



	public function DropDownVendedoresFiltradoBroker($codVendedor, $seleccionado){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
        //--------------------------------------------------------------------------------
            $condicion="";
            $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codVendedor);
            $perfil= $iUsuario->obtenerPerfil();
            $sal= $iUsuario->obtenercodSalon();
            if (($perfil=="Vendedor")){
                $condicion.=" and u.codSalon='$sal' and u.codTipoUsuario = 2 ";
            }
            if ($perfil=="Jefatura"){
                $condicion.=" and u.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codVendedor')) and u.codTipoUsuario in (2,3,4) ";
            }
            if ($perfil=="Operaciones") {
            	$condicion.=" and u.codSalon='$sal' and u.codTipoUsuario in (2,3) ";
            }
        //--------------------------------------------------------------------------------
        $consulta=" select u.codUsuario, u.usuario, CONCAT(nombre,' ', apePat) as nombre
from usuario as u left join persona as p on p.codPersona=u.codPersona where u.baja!='1'  ".$condicion." order by CONCAT(nombre,' ', apePat)";
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="";
        if (($perfil!="Vendedor")){
            echo "<option value=''>Todos</option>";
        }
        $contador=0;
		while (! $db->EndOfSeek()) {
			$contador++;
			$row = $db->Row();
            if ($seleccionado==$row->codUsuario){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codUsuario."' $selected>".strtolower($row->nombre)." (".strtolower($row->usuario).")</option>";
		}



	}
//**********************************************************************************************
	public function DropDownResponsable($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("select u.codUsuario, u.usuario, CONCAT(nombre,' ', apePat) as nombre, u.codTipoUsuario
from usuario as u left join persona as p on p.codPersona=u.codPersona 
where u.baja!='1' and u.codTipoUsuario=2 order by CONCAT(nombre,' ', apePat)")) $db->Kill();
		$db->MoveFirst();
		while (! $db->EndOfSeek()) {
			$selected="";
            $row = $db->Row();
            if ($row->codUsuario==$codUsuario) $selected="selected";
			echo "<option value='".$row->codUsuario."' $selected >".$row->nombre."</option>";
		}
	}

//***********************************************************************************************
public function DropDownSucursal($cod){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT of.codOficina, of.descripcion FROM oficina of
						 where of.codOficina != 3 AND of.baja!=1")) $db->Kill();
		$db->MoveFirst();
		while (! $db->EndOfSeek()) {
			$selected="";
            $row = $db->Row();
            if ($row->codOficina==$cod) $selected="selected";
			echo "<option value='".$row->codOficina."' $selected >".$row->descripcion."</option>";
		}
	}

//***********************************************************************************************
	public function DropDownTipoUsuario($codTipoUsuario=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM tipousuario where baja='0' and codTipoUsuario!=1")) $db->Kill();
		$db->MoveFirst();
		while (! $db->EndOfSeek()) {
			$selected="";
            $row = $db->Row();
            if ($row->codTipoUsuario==$codTipoUsuario) $selected="selected";
			echo "<option value='".$row->codTipoUsuario."' $selected >".$row->descripcion."</option>";
		}

	}

	public function DropDownTipoUsuarioxNivel($codTipoUsuario=""){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM tipousuario where baja='0' and codTipoUsuario!=1 and NivelUsuarioLBC !='' ")) $db->Kill();
		$db->MoveFirst();
		while (! $db->EndOfSeek()) {
			$selected="";
            $row = $db->Row();
            if ($row->codTipoUsuario==$codTipoUsuario) $selected="selected";
			echo "<option value='".$row->codTipoUsuario."' $selected >".$row->NivelUsuarioLBC."</option>";
		}

	}
    //***********************************************************************************************
    public function DropDownEmpresa($codEmpresa=""){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        if (! $db->Query("SELECT * FROM empresa where baja='0' ")) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($row->codEmpresa==$codEmpresa) $selected="selected";
            echo "<option value='".$row->codEmpresa."' $selected >".$row->nombre."</option>";
        }

    }
    //***********************************************************************************************
    public function DropDownEmpConcesionario($codEmpresa="", $codigousuario=""){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        //---------------------------------------------
        $iUsuario = new Usuario();
        $iUsuario->RecuperarSesionCod($codigousuario);
        $perfil= $iUsuario->obtenerPerfil();
       $condicion="";
        if ($perfil=="Jefatura"){
            $condicion.=" and codEmpresa in (
select codEmpresa from oficina where codOficina in (select codOficina from usuario where codUsuario='$codigousuario')
)";
        }
        //---------------------------------------------
        if (! $db->Query("SELECT * FROM empresa where baja='0' and escomercial='1' and esconcesionario='1' $condicion")) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($row->codEmpresa==$codEmpresa) $selected="selected";
            echo "<option value='".$row->codEmpresa."' $selected >".$row->nombre."</option>";
        }

    }
//***********************************************************************************************
public function DropDownMotivoBaja($id = NULL){
	$db = new MySQL();
	if ($db->Error()) $db->Kill();
	if (! $db->Query("SELECT * FROM motivo_suspension where baja='0' ")) $db->Kill();
	$db->MoveFirst();
    echo "<option value=''>Todos</option>";
	while (! $db->EndOfSeek()) {
		$selected="";
					$row = $db->Row();
					if ($id != NULL) {
						if ($row->codMotivoSuspension == $id) {
							$selected = 'selected';
						}
					}
		echo "<option value='".$row->codMotivoSuspension."' $selected >".$row->descripcion."</option>";
	}
}


public function DropDownMotivoBajaLBC(){
	$db = new MySQL();
	if ($db->Error()) $db->Kill();
	if (! $db->Query("SELECT * FROM motivo_baja where baja='0'  ")) $db->Kill();
	$db->MoveFirst();
   // echo "<option value=''>Todos</option>";
	while (! $db->EndOfSeek()) {
		$selected="";
					$row = $db->Row();
					if ($id != NULL) {
						if ($row->codMotivoSuspension == $id) {
							$selected = 'selected';
						}
					}
		echo "<option value='".$row->codMotivoBaja."' $selected >".$row->descripcion."</option>";
	}
}



public function DropDownMotivoBajaLBCjc($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo, $codMotivo){

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

	$db = new MySQL();
	if ($db->Error()) $db->Kill();
	if (! $db->Query("SELECT motivo_baja.codMotivoBaja,motivo_baja.descripcion as descripcion,count(producto_detalle.codProductoDetalle) as total FROM producto_detalle left join motivo_baja on producto_detalle.codMotivo=motivo_baja.codMotivoBaja 
  LEFT JOIN prospecto pro on producto_detalle.codProspecto=pro.codProspecto
      LEFT JOIN fechas fec on fec.fecha= date(pro.fechaCreacion) 
       LEFT JOIN usuario u on u.codUsuario=pro.codUsuario where producto_detalle.estado=1 and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion group by codMotivo")) $db->Kill();
	$db->MoveFirst();
   // echo "<option value=''>Todos</option>";
	while (! $db->EndOfSeek()) {
		$selected="";
					$row = $db->Row();
					if ($codMotivo != NULL) {
						if ($row->codMotivoBaja == $codMotivo) {
							$selected = 'selected';
						}
						else
							$selected="";
					}
		echo "<option value='".$row->codMotivoBaja."' $selected >".$row->descripcion."</option>";
	}
}


public function DropDownMotivoBajaLBCreno($mes, $gestion, $oficina, $canal, $equipo,$ejecutivo, $codMotivo){

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

	$db = new MySQL();
	if ($db->Error()) $db->Kill();
	if (! $db->Query("SELECT motivo_baja.codMotivoBaja,motivo_baja.descripcion,COUNT(renovacion.codRenovacion) as total 
                                from renovacion LEFT JOIN motivo_baja on motivo_baja.codMotivoBaja=renovacion.codMotivoSuspension 
 LEFT JOIN fechas fec on fec.fecha= date(renovacion.inicioVigencia) 
LEFT JOIN persona on persona.sapSlpCode=renovacion.codigoIntermediario
 LEFT JOIN usuario u on  u.codPersona = persona.codPersona 
 WHERE renovacion.codMotivoSuspension!=0  and month(fec.fecha)='$mes' and year(fec.fecha)='$gestion' $condicion GROUP BY motivo_baja.codMotivoBaja")) $db->Kill();
	$db->MoveFirst();
   // echo "<option value=''>Todos</option>";
	while (! $db->EndOfSeek()) {
		$selected="";
					$row = $db->Row();
					if ($codMotivo != NULL) {
						if ($row->codMotivoBaja == $codMotivo) {
							$selected = 'selected';
						}
						else
							$selected="";
					}
		echo "<option value='".$row->codMotivoBaja."' $selected >".$row->descripcion."</option>";
	}
}




public function DropDownSubMotivoBajaLBC($id = NULL){
	$db = new MySQL();
	if ($db->Error()) $db->Kill();
	if (! $db->Query("SELECT * FROM subMotivo_baja where baja='0' and controlRenovacion='0' and codMotivoBaja='$id' ")) $db->Kill();
	$db->MoveFirst();
    echo "<option value='0'>Todos</option>";
	while (! $db->EndOfSeek()) {
		
					$row = $db->Row();

		echo "<option value='".$row->codSubMotivoBaja."'  >".$row->descripcion."</option>";
	}
}


public function DropDownSubMotivoBajaLBCrenovacion($id = NULL){
	$db = new MySQL();
	if ($db->Error()) $db->Kill();
	if (! $db->Query("SELECT * FROM subMotivo_baja where baja='0' and codMotivoBaja='$id' ")) $db->Kill();
	$db->MoveFirst();
    echo "<option value='0'>Todos</option>";
	while (! $db->EndOfSeek()) {
		
					$row = $db->Row();

		echo "<option value='".$row->codSubMotivoBaja."'  >".$row->descripcion."</option>";
	}
}

public function DropDownMotivoBajaTPM(){
	$db = new MySQL();
	if ($db->Error()) $db->Kill();
	if (! $db->Query("SELECT * FROM motivo_suspension where baja= 0x40 ")) $db->Kill();
	$db->MoveFirst();
	while (! $db->EndOfSeek()) {
		$selected="";
					$row = $db->Row();
		echo "<option value='".$row->codMotivoSuspension."' $selected >".$row->descripcion."</option>";
	}
}
//***********************************************************************************************
    public function DropDownClaseSistemaConstructivo($codClaseSistema){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        if (! $db->Query("SELECT * FROM `tp_clase_sistema` where baja='0' ")) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($row->codClaseSistema==$codClaseSistema) $selected="selected";
            echo "<option value='".$row->codClaseSistema."' $selected >".$row->descripcion."</option>";
        }
    }
    //***********************************************************************************************
    public function DropDownSubtipoSistemaConstructivo($codSubtipoSistema=""){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        if (! $db->Query("SELECT * FROM tp_subtipo_sistema where baja='0' ")) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();

            if ($row->codSubtipoSistema==$codSubtipoSistema){ $selected="selected";}

            echo "<option value='".$row->codSubtipoSistema."' $selected >".$row->descripcion."</option>";
        }
    }
    //***********************************************************************************************
    public function DropDownSistemaConstructivo($clasesc, $tiposc, $codSistema=""){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        if(($clasesc!="")&&($clasesc!="null")){
            $condicion.=" and codClaseSistema='$clasesc' ";
        }
        if(($tiposc!="")&&($tiposc!="null")){
            $condicion.=" and codSubtipoSistema='$tiposc' ";
        }
        $consulta="SELECT * FROM tp_sistema_constructivo where baja='0' $condicion order by descripcion ";
        //echo $consulta."<hr>";
        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($row->codSistema==$codSistema) $selected="selected";
            echo "<option value='".$row->codSistema."' $selected >".$row->descripcion."</option>";
        }
    }
    //***********************************************************************************************
    public function DropDownSegmentoSC($codSegmento=""){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        $consulta="SELECT * FROM tp_segmento where baja='0' $condicion ";
        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($row->codSegmento==$codSegmento) $selected="selected";
            echo "<option value='".$row->codSegmento."' $selected >".$row->descripcion."</option>";
        }
    }
    //***********************************************************************************************
    public function DropDownCanalSC($codCanal=""){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        $consulta="SELECT * FROM tp_canal where baja='0' $condicion ";
        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($row->codCanal==$codCanal) $selected="selected";
            echo "<option value='".$row->codCanal."' $selected >".$row->descripcion."</option>";
        }
    }
    //***********************************************************************************************
    public function DropDownTipoVenta($codTipoVenta=""){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        $consulta="SELECT * FROM tp_tipo_venta where baja='0' $condicion ";
        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($row->codTipoVenta==$codTipoVenta) $selected="selected";
            echo "<option value='".$row->codTipoVenta."' $selected >".$row->descripcion."</option>";
        }
    }

//*****************************************************
	public function ObtenerVendedor($codUsuario){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT CONCAT(p.nombre, ' ', p.apePat) as vendedor FROM usuario as u left join persona as p on p.codPersona= u.codPersona where u.codUsuario='".$codUsuario."' ")) $db->Kill();
		$db->MoveFirst();
		if (!$db->EndOfSeek()) {
			$row = $db->Row();
			return $row->vendedor;
		}
	}
//*****************************************************
    function ObtenerMes($val){
        switch($val)
        {
            case '1';
                return "Enero";
            case '2';
                return "Febrero";
            case '3';
                return "Marzo";
            case '4';
                return "Abril";
            case '5';
                return "Mayo";
            case '6';
                return "Junio";
            case '7';
                return "Julio";
            case '8';
                return "Agosto";
            case '9';
                return "Septiembre";
            case '10';
                return "Octubre";
            case '11';
                return "Noviembre";
            case '12';
                return "Diciembre";
            default;
                return 'No hay mes';
                break;
        }
}
//*****************************************
	function DropDownTipoCliente($codTipoCliente){
		 $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        $consulta="SELECT * FROM tipo_cliente where baja='0' $condicion ";
        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($row->codTipoCliente==$codTipoCliente) $selected="selected";
            echo "<option value='".$row->codTipoCliente."' $selected >".$row->descripcion."</option>";
        }
	}

	function DropDownZona($codZona){
		 $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        $consulta="SELECT * FROM zona where baja='0' $condicion ";
        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($row->codZona==$codZona) $selected="selected";
            echo "<option value='".$row->codZona."' $selected >".$row->descripcion."</option>";
        }
	}
	function DropDownEstadoPedido($codEstado){
		 $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $condicion="";
        $consulta="SELECT * FROM tp_estado where baja='0' $condicion ";
        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        while (! $db->EndOfSeek()) {
            $selected="";
            $row = $db->Row();
            if ($row->codEstado==$codEstado) $selected="selected";
            echo "<option value='".$row->codEstado."' $selected >".$row->descripcion."</option>";
        }
	}
	//***********************************************************************************************
	public function DropDownTipoContactoFiltrado($tipocon){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("select * from tipo_contacto where 1")) $db->Kill();
		$db->MoveFirst();
		$selected="";


            echo "<option value=''>Todos</option>";

		while (! $db->EndOfSeek()) {

			$row = $db->Row();

			if ($tipocon==$row->codTipoContacto) {
			$selected="selected";
		}
		else
		{
			$selected="";
		}
			echo "<option value='".$row->codTipoContacto."' $selected>".$row->descripcion."</option>";
		}

	}
//***********************************************************************************************
    public function DropDownDepartamento($codCiudad=""){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        echo "<option value='0'>Seleccionar</option>";

        if (! $db->Query("select * from departamento where baja='0' order by nombre ")) $db->Kill();
        $db->MoveFirst();
        $selected="";
        while (! $db->EndOfSeek()) {
            $row = $db->Row();
            if ($codCiudad==$row->codDepto){
                $selected="selected";
            }else{
                $selected="";
            }
            echo "<option value='".$row->codDepto."' $selected>".$row->nombre."</option>";
        }

    }


    public function DropDownDepartamento2($codUsuario,$codCiudad=""){



    	 $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codUsuario);
            $perfil= $iUsuario->obtenerPerfil();
            $ofi= $iUsuario->obtenerOficina();
           	

            $condicion = " and codDepto = (select codCiudad from oficina where codOficina = '$ofi' )";

            if ($perfil == "Gerencia" || $perfil == "Superusuario") {
            	$condicion = "and 1 = 1 "; 
            }

        $db = new MySQL();
        if ($db->Error()) $db->Kill();
          if ($perfil == "Gerencia" || $perfil == "Superusuario") {
        	echo "<option value='0'>Seleccionar</option>";
            }
        

        if (! $db->Query("select * from departamento where baja='0' $condicion order by codDepto ")) $db->Kill();
        $db->MoveFirst();
        $selected="";
        while (! $db->EndOfSeek()) {
            $row = $db->Row();
            if ($codCiudad==$row->codDepto){
                $selected="selected";
            }else{
                $selected="";
            }
            echo "<option value='".$row->codDepto."' $selected>".$row->nombre."</option>";
        }

    }

	//***********************************************************************************************
		public function DropDownMarca2($codMarca){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		if (! $db->Query("SELECT * FROM marca where baja='0' order by descripcion")) $db->Kill();
		$db->MoveFirst();
		$selected ='';
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
			if($codMarca==$row->codMarca){
				$selected="selected";
			}
			else{
				$selected="";
			}
			echo "<option value='".$row->codMarca."' $selected>".$row->descripcion."</option>";
		}

	}
    //***********************************************************************************************
	public function DropDownTipoVehiculo($codigo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta= "SELECT * FROM tipo where baja='0' order by nombre";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
        while (! $db->EndOfSeek()) {
           
            $row = $db->Row();
            if ($codigo==$row->codTipo) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }

			echo "<option value='".$row->codTipo."' $selected>".$row->nombre."</option>";
		}

	}

    //***********************************************************************************************
    //***********************************************************************************************
	public function DropDownDuracionSeguro($codigo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta="SELECT * FROM duracion_seguro WHERE baja ='0' ORDER by valor ASC";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
        while (! $db->EndOfSeek()) {
            $row = $db->Row();
              if ($codigo==$row->codDuracionSeguro) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
            
			echo '<option value="'.$row->codDuracionSeguro.'" '.$selected.'>'.$row->valor.'</option>';
		}

	}
    //***********************************************************************************************
	public function DropDownTipoSeguro($codigo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta="SELECT * FROM tipo_seguro WHERE baja='0' order by descripcion ASC";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
        while (! $db->EndOfSeek()) { 
             $row = $db->Row();
              if ($codigo==$row->codTipoSeguro) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
			echo '<option value="'.$row->codTipoSeguro.'" $selected>'.$row->descripcion.'</option>';
		}

	}
	//***********************************************************************************************
	public function DropDownTipoSeguro2($codigo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta="SELECT * FROM tipo_seguro WHERE baja='0' order by descripcion ASC";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
         echo '<select name="ddTipoSeguro[]" class="form-control ddTipoSeguro"><option value="0" selected>Seleccionar</option>';
        while (! $db->EndOfSeek()) { 
             $row = $db->Row();
              if ($codigo==$row->codTipoSeguro) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
			echo '<option value="'.$row->codTipoSeguro.'" '.$selected.'>'.$row->descripcion.'</option>';
		}
        echo '</select>';
	}

	
	public function DropDownDuracionSeguro2($codigo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
	$consulta="SELECT * FROM duracion_seguro WHERE baja ='0' ORDER by valor ASC";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
         echo '<select name="ddTiempo[]" class="form-control ddTiempo"> <option value="0" selected>Seleccionar</option>';
        while (! $db->EndOfSeek()) {
            $row = $db->Row();
              if ($codigo==$row->codDuracionSeguro) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
            
			echo '<option value="'.$row->codDuracionSeguro.'" '.$selected.'>'.$row->valor.'</option>';
		}

		echo '</select>';

	}
    //***********************************************************************************************
	public function DropDownActividad($codigo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta = "SELECT * FROM actividad WHERE baja='0'";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
        while (! $db->EndOfSeek()) { 
             $row = $db->Row();
              if ($codigo==$row->codActividad) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
			echo '<option value="'.$row->codActividad.'" $selected>'.$row->descripcion.'</option>';
		}

	}

	public function DropDownLineaDeNegocio(){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta = "SELECT * FROM lineaNegocio ";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        echo '<option value="">seleccionar</option>';
         $selected="";
        while (! $db->EndOfSeek()) { 
        	 $row = $db->Row();
             
        	 echo '<option value="'.$row->codLinea.'" $selected>'.$row->nombre.'</option>';
        	
        }
            
             
			
		

	}




	public function DropDownRamo($codLinea){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta = "SELECT * FROM ramo where codLinea='$codLinea' ";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
          echo '<option value="">seleccionar</option>';
         $selected="";
        while (! $db->EndOfSeek()) { 
             $row = $db->Row();
             
			echo '<option value="'.$row->codRamo.'" >'.$row->nombre.'</option>';
		}

	}




	public function DropDownProducto($codRamo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta = "SELECT * FROM producto where codRamo='$codRamo' ";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
        while (! $db->EndOfSeek()) { 
             $row = $db->Row();
             
			echo '<option value="'.$row->codProducto.'" >'.$row->nombre.'</option>';
		}

	}




	 //***********************************************************************************************
	public function DropDownActividad2($codigo,$cont){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta = "SELECT * FROM actividad WHERE baja='0'";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
        
         echo '<select name="ddActividad[]" class="form-control" id="ddActividad'.$cont.'" onClick="DarFormatoInicial('.$cont.')" onChange="CambiarActividadResumida('.$cont.');"><option value="0">Seleccionar</option>';
        while (! $db->EndOfSeek()) { 
        	
             $row = $db->Row();
              if ($codigo==$row->codActividad) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
			echo '<option value="'.$row->codActividad.'" '.$selected.'>'.$row->descripcion.'</option>';
		}
		echo '</select>';

	}


//***********************************************************************************************
	public function DropDownActividadResumida($codigo){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta = "SELECT * FROM actividad_resumida WHERE baja='0'";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
        while (! $db->EndOfSeek()) { 
             $row = $db->Row();
              if ($codigo==$row->codActividadResumida) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
			echo '<option value="'.$row->codActividadResumida.'" $selected>'.$row->descripcion.'</option>';
		}

	}

	 //***********************************************************************************************
	public function DropDownActividadResumida2($codigo,$cont){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta = "SELECT * FROM actividad_resumida WHERE baja='0'";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
        
         echo '<select name="ddresumida[]" class="form-control" id="ddresumida'.$cont.'" onchange="CambiarNivelRiesgo('.$cont.');"><option value="0">Seleccionar</option>';
        while (! $db->EndOfSeek()) { 
        	
             $row = $db->Row();
              if ($codigo==$row->codActividadResumida) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
			echo '<option value="'.$row->codActividadResumida.'" '.$selected.'>'.$row->descripcion.'</option>';
		}
		echo '</select>';
		
	}




	public function DropDownLineaDeNegocioInicial($codLinea,$cont, $estado){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();


		if(is_numeric($estado)){
			$condicion = " and codLinea='$codLinea'";
		}
		else{
			$seleccionar = '<option value="0">Seleccionar</option>';
		}
		
		$consulta = "SELECT * FROM lineaNegocio WHERE baja='0' $condicion";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
        
         echo '<select style="width:100%;" name="ddLinea[]" id="ddLinea'.$cont.'" onChange="TraerRamo('.$cont.')" class="form-control" >'.$seleccionar;
        while (! $db->EndOfSeek()) { 
        	
             $row = $db->Row();
              if ($codLinea==$row->codLinea) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
			echo '<option value="'.$row->codLinea.'" '.$selected.'>'.$row->nombre.'</option>';
		}
		echo '</select>';
		
	}

public function DropDownLineaDeNegocioInicial2($codLinea,$cont, $deshabilitar){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();
		$consulta = "SELECT * FROM lineaNegocio WHERE baja='0'";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
         $disabled="";
         if($deshabilitar=='si'){
         	$disabled= "disabled";
         }
         else{
         	$disabled="enabled";
         }

         echo '<select style="width:100%;" name="ddLinea[]" id="ddLinea'.$cont.'" onChange="TraerRamo('.$cont.')" class="form-control" ><option value="0">Seleccionar</option>';
        while (! $db->EndOfSeek()) { 
        	
             $row = $db->Row();
              if ($codLinea==$row->codLinea) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
			echo '<option value="'.$row->codLinea.'" '.$selected.' '.$disabled.'>'.$row->nombre.'</option>';
		}
		echo '</select>';
		
	}


	public function DropDownRamoInicial($codLinea,$codRamo,$cont, $estado){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();

		if(is_numeric($estado)){
			$condicion = " and codRamo='$codRamo'";
		}
		


		$consulta = "SELECT * FROM ramo WHERE codLinea='$codLinea' and baja='0' $condicion";
		if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
         $selected="";
        
         echo '<select style="width:100%;" name="ddramo[]" id="ddramo'.$cont.'" onChange="TraerProducto('.$cont.')" class="form-control" >';
        while (! $db->EndOfSeek()) { 
        	
             $row = $db->Row();
              if ($codRamo==$row->codRamo) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
			echo '<option value="'.$row->codRamo.'" '.$selected.'>'.$row->nombre.'</option>';
		}
		echo '</select>';
		
	}

	public function DropDownProductoInicial($codRamo,$codProducto,$cont, $estado){
		$db = new MySQL();
		if ($db->Error()) $db->Kill();

        if(is_numeric($estado)){
			$condicion = " and codProducto='$codProducto'";
		}
		

		$consulta = "SELECT * FROM producto WHERE codRamo='$codRamo' and baja='0' $condicion";
		if (! $db->Query($consulta)) $db->Kill();

		

        $db->MoveFirst();
         $selected="";
        
         echo '<select style="width:100%;" name="ddproducto[]" id="ddproducto'.$cont.'"  class="form-control" >';
        while (! $db->EndOfSeek()) { 
        	
             $row = $db->Row();
              if ($codProducto==$row->codProducto) {
            	$selected="selected";
            }
            else{
            	 $selected="";
            }
			echo '<option value="'.$row->codProducto.'" '.$selected.'>'.$row->nombre.'</option>';
		}
		echo '</select>';
		
	}





		public function DropDownAreaFiltrado($codVendedor,$codOficina=""){
			$db = new MySQL();
		if ($db->Error()) $db->Kill();
        //--------------------------------------------------------------------------------
            $condicion="";
            $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codVendedor);
            $perfil= $iUsuario->obtenerPerfil();
            $ofi= $iUsuario->obtenerOficina();
            $salo=$iUsuario->obtenercodSalon();
            //if (($perfil!="Gerencia")&&($perfil!="Superusuario")){
               //$condicion.=" and o.codOficina in (select distinct codOficina from usuario where codUsuario='$codVendedor')";
           // }
            
            if ($perfil=="Jefatura"){
               $condicion.=" and usuario.codOficina='$ofi'";
            }
            if ($perfil=="Vendedor" || $perfil== "Operaciones"){
               $condicion.=" and usuario.codSalon='$salo'";
            }

        //--------------------------------------------------------------------------------
        $consulta=" select Salon.codSalon, Salon.descripcion from Salon left join usuario on usuario.codSalon=Salon.codSalon where 1=1 ".$condicion." group by Salon.codSalon ";
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="";
        if (($perfil=="Gerencia")||($perfil=="Superusuario") ||($perfil=="Jefatura")||($perfil=="Comunity Manager")){
            echo "<option value=''>Todos</option>";
        }else{
            //echo "<option value=''>".$perfil."</option>";
        }
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codOficina==$row->codSalon){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codSalon."' $selected>".$row->descripcion."</option>";
		}

	}


	public function DropDownArea($codOficina=""){
			$db = new MySQL();
		if ($db->Error()) $db->Kill();
        //--------------------------------------------------------------------------------
            $condicion="";
      
            //if (($perfil!="Gerencia")&&($perfil!="Superusuario")){
               //$condicion.=" and o.codOficina in (select distinct codOficina from usuario where codUsuario='$codVendedor')";
           // }
            
        if ($codOficina != "") {
        	$condicion = " and codigoOfi = '$codOficina' ";
        }

        //--------------------------------------------------------------------------------
        $consulta=" select * from Salon where 1=1 $condicion ";
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="";
       
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codOficina==$row->codSalon){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codSalon."' $selected>".$row->descripcion."</option>";
		}

	}

	public function DropDownAreaFiltradoxOficina($codOficina="",$codVendedor){
			$db = new MySQL();
		if ($db->Error()) $db->Kill();
        //--------------------------------------------------------------------------------
            $condicion="";
            $iUsuario = new Usuario();
            $iUsuario->RecuperarSesionCod($codVendedor);
            $perfil= $iUsuario->obtenerPerfil();
            $ofi= $iUsuario->obtenerOficina();
            $salo=$iUsuario->obtenercodSalon();
            //if (($perfil!="Gerencia")&&($perfil!="Superusuario")){
               //$condicion.=" and o.codOficina in (select distinct codOficina from usuario where codUsuario='$codVendedor')";
           // }
            if ($codOficina=="") {
            	
            }
            else
            {
            if ($perfil=="Gerencia" || ($perfil=="Comunity Manager")){
               $condicion.=" and Salon.codigoOfi='$codOficina'";
            }
        }
            
            if ($perfil=="Jefatura"){
               $condicion.=" and usuario.codOficina='$ofi'";
            }
            if ($perfil=="Vendedor" || $perfil== "Operaciones"){
               $condicion.=" and usuario.codSalon='$salo'";
            }

        //--------------------------------------------------------------------------------
        $consulta=" select Salon.codSalon, Salon.nombre from Salon left join usuario on usuario.codSalon=Salon.codSalon where 1=1 ".$condicion." group by Salon.codSalon ";
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="";
        if (($perfil=="Gerencia")||($perfil=="Superusuario")){
            echo "<option value=''>Todos</option>";
        }else{
            //echo "<option value=''>".$perfil."</option>";
        }
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codOficina==$row->codSalon){
            	if (1==2) {
            		   $selected="selected";
            	}
             
            }else{
                $selected="";
            }
			echo "<option value='".$row->codSalon."' $selected>".$row->nombre."</option>";
		}

	}


	public function DropDownAreaFiltradoxOficina2($codOficina=""){
			$db = new MySQL();
		if ($db->Error()) $db->Kill();
        //--------------------------------------------------------------------------------
          

        $consulta="SELECT * FROM Salon WHERE codigoOfi='$codOficina'";
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="selected";
       
            echo "<option value=''>Seleccionar</option>";
      
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codOficina==$row->codSalon){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codSalon."' $selected>".$row->nombre."</option>";
		}

	}


		public function DropDownTipoDocumento($codTipoDocumento=""){
			$db = new MySQL();
		if ($db->Error()) $db->Kill();
        //--------------------------------------------------------------------------------
          

        $consulta="SELECT * FROM tipo_documento where baja=0 ";
		if (! $db->Query($consulta)) $db->Kill();
		$db->MoveFirst();
		$selected="selected";
       
            echo "<option value=''>Seleccionar</option>";
      
		while (! $db->EndOfSeek()) {
			$row = $db->Row();
            if ($codTipoDocumento==$row->codTipoDocumento){
                $selected="selected";
            }else{
                $selected="";
            }
			echo "<option value='".$row->codTipoDocumento."' $selected>".$row->descripcion."</option>";
		}

	}











}
?>
