<?php

require_once "../clases/mysql.class.php";

require_once "../clases/mail.php";

class Prospecto{

    public $mensaje = "";







    //******************************************************************************************************

    function NuevoProspecto($esempresa, $nombre, $telefono, $telefono2, $ci, $ext, $contacto, $telfcontacto, $codusuario, $codOrigen, $codMedio, $email, $nombreobra, $direccionobra, $tamanoobra, $codCliente, $semaforo,$direccion,$nit,$razonsocial,$primernombre,$primerapellido,$responsable,$correo,$domicilio,$codigoCGP,$extension,$codSecuenciaProspecto,$controlWS){

        $telefono= str_replace(" ","", $telefono);

        $telefono= str_replace("-","", $telefono);

        $telefono2= str_replace(" ","", $telefono2);

        $telefono2= str_replace("-","", $telefono2);

        $telefonocontacto= str_replace(" ","", $telfcontacto);

        $telefonocontacto= str_replace("-","", $telfcontacto);



       

        $email=strtolower($correo);

        // Preparo la consulta con las condiciones





        if ($controlWS=="CD") {

           $elcontrol='1';

        }

        else

        {

            $elcontrol='2';

        }

        

        if ($esempresa=="si") { 

            $esempresa=1;

        }

        else

        {

            $esempresa=0;

        }



         $nombre=strtoupper($razonsocial);

         $primNom=strtoupper($primernombre);

          $primApe=strtoupper($primerapellido);

         $elcontacto=strtoupper($responsable);

            

        $consulta="insert into prospecto (nombre, ci, expedicion, telefono, telefono2, esEmpresa, nombreContacto, telefonoContacto, estado, codUsuario, codOrigenProspecto, codMedio, fechaCreacion, email, nombreObra, direccionObra, tamanoObra, codCliente, codPersona, semaforo, nit, PrimerNombre, PrimerApellido,ext ,codSecuenciaProspecto,controlWS)

			values ('$razonsocial', '$ci', '$ext', '$telefono','$telefono2', '$esempresa', '$elcontacto', '$telfcontacto', (select codEstadoProspecto from estado_prospecto where descripcion like '%Nuevo Prospecto%'), '$codusuario', $codOrigen, $codMedio, SYSDATE(), '$email', '$nombreobra', '$domicilio', '$tamanoobra', '$codigoCGP', '$codusuario', '$semaforo', '$nit', '$primNom', '$primApe', '$extension' , '$codSecuenciaProspecto' , '$elcontrol' )

		";



        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        // Habilito excepciones

        $db->ThrowExceptions = true;

        if (! $db->TransactionBegin()) $db->Kill();

        $success = true;

        $sql = $consulta;



        if (! $db->Query($sql)){

            $success = false;

        }

        // Si hizo todo bien

        if ($success) {

            $codProspecto=$db->GetLastInsertID();

            $this->NuevoSeguimiento($codProspecto,"SYSDATE()","1");

            if (! $db->TransactionEnd()) {

                $db->Kill();

            }

            return $codProspecto;

        } else {

            if (! $db->TransactionRollback()) {

                $db->Kill();

            }

        }

        return "0";





















    }

    //******************************************************************************************************



    //******************************************************************************************************

    

    function NuevoProspecto2($nombre, $telefono,$ci, $ext, $codusuario, $codOrigen,$nota, $email){

        $telefono= str_replace(" ","", $telefono);

        $telefono= str_replace("-","", $telefono);

       



        $nombre=strtoupper($nombre);

    

        $email=strtolower($email);

      

            //************************************************************************ Traer Vendedor Random  *****************************************************

                                           function VerificarVendedoresRandom(){

                                    // Creo una nueva conexion

                                    $db= new MySQL();

                                    if ($db->Error()){

                                        $db->Kill();

                                        return "0";

                                    }

                                    $consulta="SELECT usuario.inicializado,usuario.estado,persona.codPersona,concat(persona.nombre,' ',persona.apePat,' ',persona.apeMat) as nombre,codTipoUsuario,cargo,usuario.codUsuario as elusuario from usuario inner join persona on usuario.codPersona=persona.codPersona where usuario.codTipoUsuario=2 and usuario.inicializado is null and usuario.estado=0 and usuario.baja=0";

                                    //echo $consulta;

                                    $db->Query($consulta);

                                    if($db->RowCount()>0)

                                    {



                                    }

                                    else

                                    {

                                        $consulta="UPDATE usuario set estado=0 where codTipoUsuario=2";

                                       $db->Query($consulta);   

                                    }

                                    

                                }



                                function ObtenerVendedorRandom(){

                                    // Creo una nueva conexion

                                    $db= new MySQL();

                                    if ($db->Error()){

                                        $db->Kill();

                                        return "0";

                                    }

                                    $consulta="SELECT usuario.inicializado,usuario.estado,persona.codPersona,concat(persona.nombre,' ',persona.apePat,' ',persona.apeMat) as nombre,codTipoUsuario,cargo,usuario.codUsuario as elusuario,persona.correo from usuario inner join persona on usuario.codPersona=persona.codPersona where usuario.codTipoUsuario=2 and usuario.inicializado is null and usuario.estado=0 and usuario.baja=0";

                                    //echo $consulta;

                                    $db->Query($consulta);

                                    return $db->Row();

                                }







                                function ActualizarVendedorAsignado($codigodelusuario){

                                    // Creo una nueva conexion

                                    $db= new MySQL();

                                    if ($db->Error()){

                                        $db->Kill();

                                        return "0";

                                    }

                                    $consulta="UPDATE usuario set estado=1 where codUsuario=$codigodelusuario";

                                    //echo $consulta;

                                    $db->Query($consulta);

                                    return $db->Row();

                                }

            //**********************************************************************************************************************************************************





        VerificarVendedoresRandom();

        $Vrandom= ObtenerVendedorRandom();

        $codVendedorRandom= $Vrandom->elusuario;

        $nombreVendedorRandom=$Vrandom->nombre;

        $codPersonaUsuarioRandom=$Vrandom->codPersona;

        if($nota==""||$nota==null)

        {

            $lanota="";

        }

        else

        {

            $lanota=date('Y-m-d').' '.$nota;

        }

        $consulta="insert into prospecto (nombre, ci, ext, telefono, estado, codUsuario, codOrigenProspecto, fechaCreacion, email,  codPersona, notas)

            values ('$nombre', '$ci', '$ext', '$telefono',(select codEstadoProspecto from estado_prospecto where descripcion like '%Nuevo Prospecto%'), '$codVendedorRandom', $codOrigen, SYSDATE(), '$email', $codusuario, '$lanota')";



        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        // Habilito excepciones

        $db->ThrowExceptions = true;

        if (! $db->TransactionBegin()) $db->Kill();

        $success = true;

        $sql = $consulta;



        if (! $db->Query($sql)){

            $success = false;

        }

        // Si hizo todo bien

        if ($success) {

            $codProspecto=$db->GetLastInsertID();

            $this->NuevoSeguimiento($codProspecto,"SYSDATE()","1");

            if (! $db->TransactionEnd()) {

                $db->Kill();

            }

            ActualizarVendedorAsignado($codVendedorRandom);

            $iCorreo= new Correo();

            $iCorreo->ProspectoReferencial($nombre,$ci,$ext,$telefono,$_SESSION['salon'],$email,$nota,$Vrandom->correo,$nombreVendedorRandom);

            return $codProspecto.';'.$nombreVendedorRandom;

        } else {

            if (! $db->TransactionRollback()) {

                $db->Kill();

            }

        }

        return "0";





















    }

    //******************************************************************************************************



  



    



    //*******************************************************************************************************

    function ModificarProspecto($nroprospecto, $esempresa, $ci, $complemento, $nombre,$apellido, $telefono, $telefono2, $contacto, $telfcontacto, $codusuario, $codOrigen, $codMedio, $correo="", $latitud="", $longitud="", $semaforo="",$sexo, $fecNacimiento,$expedicion){

        // Preparo la consulta con las condiciones

        if($ext=="")

        if ($esempresa=='1'){

            $esempresa='1';

            $elnombreEmpresa=$nombre;

            $elnombrePersona="";

            $elapellidoPersona="";

        }else{

            $esempresa='0';

            $elnombreEmpresa="";

            $elnombrePersona=$nombre;

            $elapellidoPersona=$apellido;

        }

        if($ext==""){

            $ext='0';

        }



        if ($fecNacimiento=="0000-00-00 00:00:00"){

            $fecNacimiento='';

        }

        $consulta="update prospecto set expedicion='$expedicion', email='$correo', nombre='$elnombreEmpresa',PrimerNombre='$elnombrePersona',PrimerApellido='$elapellidoPersona', ci='$ci', ext='$complemento', telefono='$telefono', telefono2='$telefono2' , esEmpresa='$esempresa', nombreContacto='$contacto', telefonoContacto='$telfcontacto', estado=(select codEstadoProspecto from estado_prospecto where descripcion like '%Nuevo Prospecto%'), codOrigenProspecto=$codOrigen, codMedio=$codMedio, latitud='$latitud', longitud='$longitud', semaforo='$semaforo', sexo='$sexo', fechaNacimiento=DATE_FORMAT(STR_TO_DATE('$fecNacimiento', '%d/%m/%Y'), '%Y-%m-%d') where codProspecto=$nroprospecto

		";



        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $success = true;

        $sql = $consulta;



        if (! $db->Query($sql)){

            $success = false;

        }

        if (!$success){

            $this->mensaje=$consulta;

        }

        return $success;

    }







     function ModificarProspectoRen($nroprospecto,$telefono, $telefono2){

        // Preparo la consulta con las condiciones

       

        $consulta="UPDATE renovacion set telefono1Tomador='$telefono', telefono2Tomador='$telefono2' where codRenovacion='$nroprospecto'

        ";



        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $success = true;

        $sql = $consulta;



        if (! $db->Query($sql)){

            $success = false;

        }

        if (!$success){

            $this->mensaje=$consulta;

        }

        return $success;

    }

    //******************************************************************************************************

    function ObtenerDetalle($codProspecto){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="

		select p.cerrador,p.controlWS,p.codCliente,p.codSecuenciaProspecto,p.expedicion,p.ext as complemento,p.nit,p.PrimerNombre,p.PrimerApellido,p.estadoReserva,p.tamanoObra, p.codProspecto, p.nombre, p.ci,  e.descripcion as extension, p.telefono, p.telefono2,p.MontoOportunidad,

		p.esEmpresa, p.nombreContacto, p.telefonoContacto, p.codUsuario, cli.codClienteSAP, p.fechaReserva, p.sexo, DATE_FORMAT(STR_TO_DATE(p.fechaNacimiento ,'%Y-%m-%d' ), '%d/%m/%Y') as fechaNacimiento, p.cantidadParqueo, p.nroDpto, p.montoReservaParq, p.montoReservaDpto, p.planPago, p.fechaPrimerCuota, p.latitudOf, p.longitudOf,

		o.descripcion as origen, m.descripcion as medio, t.descripcion as TipoMedio, p.notas, p.codPersona, (select completado from seguimiento where codProspecto=$codProspecto order by codSeguimiento desc limit 1) as completado,  (select codSeguimiento from seguimiento where codProspecto=$codProspecto order by codSeguimiento desc limit 1) as codSeguimiento, es.descripcion as estado, CONCAT(per.nombre, ' ', per.apePat) as vendedor,CONCAT(per2.nombre, ' ', per2.apePat,' - ', sal.nombre) as referencial, ms.descripcion as motivoSuspension, date_format(fechaCierre,'%d-%m-%Y') as fechaCierre, EXTRACT(HOUR from fechaCierre) as lahoracierre, EXTRACT(MINUTE from fechaCierre) as elminutocierre, date_format(fechaCreacion,'%d-%m-%Y') as fechaCreacion, p.email, e.codExtension, o.codOrigenProspecto, m.codTipoMedio, p.codMedio, p.latitud, p.longitud, p.nombreObra, p.codTipoObra, p.direccionObra, p.codTipoProyecto, tob.nombre as tipoObra, tp.nombre as tipoProyecto, p.semaforo, p.DescripcionBaja, p.sexo, date(p.fechaNacimiento), p.cantidadParqueo, p.parqueo1, p.parqueo2, p.parqueo3, p.parqueo4, p.montoReservaParq, p.montoReservaDpto, p.planPago, p.fechaPrimerCuota, p.nroDpto, p.latitudOf, p.longitudOf

		from prospecto as p

		left join extension as e on e.codLBC=p.expedicion

		left join estado_prospecto as es on es.codEstadoProspecto=p.estado

		left join medio as m on m.codMedio=p.codMedio

		left join tipo_medio as t on t.codTipoMedio=m.codTipoMedio

		left join origen_prospecto as o on o.codOrigenProspecto=p.codOrigenProspecto

        left join usuario as u on u.codUsuario=p.codUsuario

        left join persona as per on per.codPersona=u.codPersona

        left join usuario as u2 on u2.codUsuario=p.codPersona

    	left join persona as per2 on per2.codPersona=u2.codPersona

    	left join Salon as sal on sal.codSalon=u2.codSalon

        left join motivo_suspension as ms on ms.codMotivoSuspension=p.codMotivoSuspension

        left join tp_tipo_obra as tob on tob.codTipoObra=p.codTipoObra

        left join tp_tipo_proyecto as tp on tp.codTipoProyecto=p.codTipoProyecto

        LEFT JOIN tp_cliente_sap as cli on cli.codCliente= p.codCliente

		where p.codProspecto=$codProspecto

		";

        $db->Query($consulta);

        $db->MoveFirst();

        return $db->Row();

    }

    //******************************************************************************************************

    function ObtenerSeguimientos($codProspecto){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

		select registrador,registradorfin,codSeguimiento,  date_format(fechaProxContacto,'%d-%m-%Y') as fechaProxContacto, observacion, fechaCompletado as lafechafin,

		date_format(fechaFinContacto,'%d-%m-%Y') as fechaFinContacto, tc.descripcion as TipoContacto, completado, s.descripcion

		from seguimiento as s

		left join tipo_contacto as tc on tc.codTipoContacto=s.codTipoContacto

		where codProspecto=$codProspecto order by codSeguimiento desc

		";

        $db->Query($consulta);

        return $db;

    }





    function ObtenerSeguimientosRenovacion($codProspecto){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

        select registrador,registradorfin,codSeguimiento,  date_format(fechaProxContacto,'%d-%m-%Y') as fechaProxContacto, observacion, fechaCompletado as lafechafin,

        date_format(fechaFinContacto,'%d-%m-%Y') as fechaFinContacto, tc.descripcion as TipoContacto, completado, s.descripcion

        from seguimientoRenovacion as s

        left join tipo_contacto as tc on tc.codTipoContacto=s.codTipoContacto

        where codRenovacion=$codProspecto order by codSeguimiento desc

        ";

        $db->Query($consulta);

        return $db;

    }

    //******************************************************************************************************

    function CerrarSeguimiento($codSeguimiento, $detalle,$registrador){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

		update seguimiento set fechaFinContacto=SYSDATE(), completado='1', fechaCompletado=SYSDATE(), descripcion='$detalle',registradorfin='$registrador'

		where codSeguimiento=$codSeguimiento

		";

        if (! $db->Query($consulta)){

            $success = false;

        }

        return true;

    }





    function CerrarSeguimientoRenovacion($codSeguimiento, $detalle,$registrador){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }

        $consulta="
        update seguimientoRenovacion set fechaFinContacto=SYSDATE(), completado='1', fechaCompletado=SYSDATE(), descripcion='$detalle', registradorfin='$registrador'
        where codSeguimiento=$codSeguimiento
        ";
        if (! $db->Query($consulta)){
            $success = false;
        }
        return true;
    }

    //******************************************************************************************************

    function NuevoSeguimiento($cod, $fecha, $tipo, $observacion="",$registrador=""){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $condfecha="$fecha";

        if ($fecha!="SYSDATE()") $condfecha="'".$fecha."'";

        $consulta="insert into seguimiento(codProspecto, fechaAlta, fechaProxContacto, codTipoContacto, observacion,registrador) values ($cod, SYSDATE(), $condfecha, $tipo,'$observacion','$registrador')

		";

        if (! $db->Query($consulta)){

            $success = false;

        }

        return true;

    }



    function NuevoSeguimientoRenovacion($cod, $fecha, $tipo, $observacion="",$registrador){
        // Creo una nueva conexion
        $db= new MySQL();
        if ($db->Error()){
            $db->Kill();
            return "0";
        }
        $condfecha="$fecha";
        if ($fecha!="SYSDATE()") $condfecha="'".$fecha."'";
        $consulta="insert into seguimientoRenovacion(codRenovacion, fechaAlta, fechaProxContacto, codTipoContacto, observacion, registrador) values ($cod, SYSDATE(), $condfecha, $tipo,'$observacion', '$registrador')
        ";
        if (! $db->Query($consulta)){
            $success = false;
        }
        return true;
    }

    //******************************************************************************************************

    function NuevaNota($codProspecto, $nota){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

		update prospecto set notas=CONCAT(date_format(SYSDATE(),'%d-%m-%Y'),': ','$nota','<br>',IFNULL(notas,''))

		where codProspecto=$codProspecto

		";

        if (! $db->Query($consulta)){

            return false;

        }

        return true;

    }









    function NuevaNotaRenovacion($codProspecto, $nota){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

        update renovacion set notas=CONCAT(date_format(SYSDATE(),'%d-%m-%Y'),': ','$nota','<br>',IFNULL(notas,''))

        where codRenovacion=$codProspecto

        ";

        if (! $db->Query($consulta)){

            return false;

        }

        return true;

    }

    //******************************************************************************************************

    function ObtenerVehiculos($codProspecto){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

		select esa.descripcion as asignacion,vp.codVehiculoProspecto, vp.codProspecto, m.nombre as modelo,

        t.nombre as tipo, st.nombre as subtipo, ma.descripcion as marca, vp.anioComercial,

        c.nombre as color, cint.nombre as colorInterior,

		vp.precioVenta, ec.nombre as estadoCom, eo.nombre as estadoOp, v.chasis, v.codVehiculo,

        DATE_FORMAT(v.fechaFacturacion,'%Y-%m-%d')  as fechaFacturacion,

        DATE_FORMAT(v.fechaFacturacion,'%d-%m-%Y')  as fechaFacturacion2,

        DATE_FORMAT(v.fechaLlegada,'%d-%m-%Y') as fechaLlegada, ubi.codUbicacion, ubi.nombre as ubicacion,

        ent.nombre as lugarEntrega, ent.codUbicacion as codLugarEntrega, m.comModelo as comModeloOriginal,

        m.comModeloPre as comModeloPreOriginal, vp.ComModelo, vp.ComModelopre as ComModeloPre, vp.ComTransporte,

        vp.ComPlacas, vp.ComOtros, ofi.comTransporte as comTransporteOriginal, ofi.comPlacas as comPlacasOriginal,

        ofi.comOtros as comOtrosOriginal, vp.precioPiso

		from vehiculo_prospecto as vp

		left join subtipo as st on st.codSubTipo=vp.codSubTipo

		left join tipo as t on t.codTipo=st.codTipo

		left join modelo as m on m.codModelo = t.codModelo

		left join marca as ma on ma.codMarca=m.codMarca

		left join color as c on c.codColor=vp.codColor

		left join color_int as cint on cint.codColorInt=vp.codColorInterior

		left join vehiculo as v on v.codVehiculo=vp.codVehiculo

		left join estado_com as ec on ec.codEstadoCom=v.codEstadoCom

		left join estado_op as eo on eo.codEstadoOp=v.codEstadoOp

    	left join (

			select codVehiculoProspecto, codSolicitudAsignacion, codEstadoSolicitudAsignacion

            from solicitud_asignacion

            where codSolicitudAsignacion in (

                       select max(codSolicitudAsignacion) from solicitud_asignacion where  codVehiculoProspecto in (

                                  select codVehiculoProspecto from vehiculo_prospecto where codProspecto=$codProspecto

                       )

                       group by codVehiculoProspecto)

            group by codVehiculoProspecto

            order by codSolicitudAsignacion

		) as sa on sa.codVehiculoProspecto=vp.codVehiculoProspecto

    	left join estado_solicitud_asignacion as esa on esa.codEstadoSolicitudAsignacion=sa.codEstadoSolicitudAsignacion

        left join ubicacion as ent on ent.codUbicacion=vp.lugarEntrega

        left join ubicacion as ubi on ubi.codUbicacion=v.codUbicacion

        left join prospecto as p on p.codProspecto=vp.codProspecto

        left join usuario as u on u.codUsuario=p.codUsuario

        left join oficina as ofi on ofi.codOficina=u.codOficina

		where vp.baja='0' and vp.codProspecto=$codProspecto

		";

        $db->Query($consulta);

        return $db;

    }

    //******************************************************************************************************

    function NuevoVehiculo($cod, $ddmarca, $ddmodelo, $ddtipo, $ddsubtipo, $ddcolor, $ddcolorinterior, $precio, $ddAnioComercial, $cantidad){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        //Validaciones

        if (($precio=="")|| (is_numeric($precio)==false)){

            $this->mensaje="Debe ingresar un precio.";

            return false;

        }

        $consulta=" select precioMinimo, precioMaximo from precio_modelo where codMarca=$ddmarca and codModelo=$ddmodelo and codTipo=$ddtipo and codSubtipo=$ddsubtipo and gestion=$ddAnioComercial and baja='0' order by codPrecioModelo desc";

        $db->Query($consulta);

        if ($db->RowCount()>0){

            $db->MoveFirst();

            $dato=$db->Row();

            $precioMinimo=$dato->precioMinimo;

            $precioMaximo=$dato->precioMaximo;

        }else{

            $this->mensaje="No existe un precio definido para este modelo. Por favor contacte con el departamento de operaciones.";

            return false;

        }

        if (($precioMinimo>$precio)||($precioMaximo<$precio)){

            $this->mensaje="El precio ingresado no esta aprobado. minimo: ".number_format($precioMinimo, 2, '.', ',')." maximo: ".number_format($precioMaximo, 2, '.', ',');

            return false;

        }

        $consulta="insert into vehiculo_prospecto(codProspecto, codModelo, codTipo, codSubtipo, codColor, codColorInterior, precioVenta, precioPiso,  anioComercial) values ($cod, $ddmodelo, $ddtipo, $ddsubtipo, $ddcolor, $ddcolorinterior, $precio, $precioMinimo, $ddAnioComercial) ";

        if (! $db->Query($consulta)){

            return false;

        }

        return true;

    }

    //******************************************************************************************************

    function ModificarVehiculo($cod, $hcodVehiculo, $ddmarca, $ddmodelo, $ddtipo, $ddsubtipo, $ddcolor, $ddcolorinterior, $precio, $ddAnioComercial){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta=" select precioMinimo, precioMaximo from precio_modelo where codMarca=$ddmarca and codModelo=$ddmodelo and codTipo=$ddtipo and codSubtipo=$ddsubtipo and gestion=$ddAnioComercial and baja='0' order by codPrecioModelo desc";

        $db->Query($consulta);

        if ($db->RowCount()>0){

            $db->MoveFirst();

            $dato=$db->Row();

            $precioMinimo=$dato->precioMinimo;

            $precioMaximo=$dato->precioMaximo;

        }else{

            $precioMinimo=$precio;

            $precioMaximo=$precio;

        }

        if (($precioMinimo>$precio)||($precioMaximo<$precio)){

            $this->mensaje="El precio ingresado no esta aprobado. minimo: ".number_format($precioMinimo, 2, '.', ',')." maximo: ".number_format($precioMaximo, 2, '.', ',');

            return false;

        }

        $consulta="update vehiculo_prospecto set codModelo=$ddmodelo, codTipo=$ddtipo, codSubtipo=$ddsubtipo, codColor= $ddcolor, codColorInterior=$ddcolorinterior, precioVenta=$precio, anioComercial=$ddAnioComercial  where codVehiculoProspecto=".$hcodVehiculo." and codProspecto=$cod ";



        if (! $db->Query($consulta)){

            return false;

        }

        return true;

    }



    //******************************************************************************************************

    function QuitarVehiculo($cod, $hcodVehiculo){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="update vehiculo_prospecto set baja='1' where codVehiculoProspecto=$hcodVehiculo and codProspecto=$cod ";

        if (!$db->Query($consulta)){

            return false;

        }



        $consulta="update forma_pago_prospecto set baja='1' where codVehiculoProspecto=$hcodVehiculo and codProspecto=$cod ";

        if (!$db->Query($consulta)){

            return false;

        }



        return true;

    }

    //******************************************************************************************************

    function NuevaFormaPago($cod, $codFormaPago, $monto, $codVehiculoProspecto, $tasa="", $cuotas="", $periodicidad=""){



        if(trim($tasa)==""){ $tasa="0";}

        if(trim($cuotas)==""){ $cuotas="0";}

        if(trim($periodicidad)==""){ $periodicidad="0";}

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        //verifico si ya existe la forma de pago    1=0 por control negativo siempre

        $consulta=" select * from forma_pago_prospecto  where codProspecto='$cod' and codFormaPago=$codFormaPago and codVehiculoProspecto=$codVehiculoProspecto and (baja='0' or baja='3') and 1=0 order by codFormaPagoProspecto desc";

        //echo $consulta;

        $db->Query($consulta);

        $baja="'0'";

        /*if ($codFormaPago==4){

            $baja="'3'";

            $iMail = new Correo();

            $iMail->CreditoPropio($cod);

        }*/



        // si existe la forma de pago

        if ($db->RowCount()>0){

            $db->MoveFirst();

            $dato=$db->Row();

            $codFormaPagoProspecto=$dato->codFormaPagoProspecto;

            $consulta="update forma_pago_prospecto set monto=$monto, tasa='$tasa', cuotas='$cuotas', periodicidad='$periodicidad', baja=$baja  where codFormaPagoProspecto = $codFormaPagoProspecto";

            if (! $db->Query($consulta)){

                return false;

            }

        }else{

            $consulta="insert into forma_pago_prospecto(codProspecto, codFormaPago, monto, tasa, cuotas, periodicidad, codVehiculoProspecto, baja) values($cod, $codFormaPago, $monto, '$tasa', '$cuotas', '$periodicidad', $codVehiculoProspecto,$baja)";

            if (! $db->Query($consulta)){

                //echo "a<hr>$consulta <hr>";

                return false;

            }

        }

        return true;

    }

    //******************************************************************************************************

    function ActualizarFormaPago($cod, $monto, $tasa, $cuotas, $periodicidad, $estado){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        //verifico si ya existe la forma de pago

        $consulta=" select * from forma_pago_prospecto  where codFormaPagoProspecto=$cod ";

        $db->Query($consulta);

        // si existe la forma de pago

        if ($db->RowCount()>0){

            $db->MoveFirst();

            $dato=$db->Row();

            $codFormaPagoProspecto=$dato->codFormaPagoProspecto;

            $consulta="update forma_pago_prospecto set monto='$monto', tasa='$tasa', cuotas='$cuotas', periodicidad='$periodicidad', baja='$estado'  where codFormaPagoProspecto = $cod";

            if (! $db->Query($consulta)){

                return false;

            }

        }else{

            return false;

        }

        return true;

    }

    //******************************************************************************************************





    function TraerCorreoUsuario($cod){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

        $consulta="SELECT per.correo from persona as per inner join usuario as usu on per.codPersona=usu.codPersona where usu.codUsuario= '".$cod."'";

         $db->Query($consulta);

         if ($db->RowCount()>0) {

             $db->MoveFirst();

             $fila = $db->Row();

             return $fila->correo;

         }

         else

         {

            return "";

         }

         

    

        

    }



        //******************************************************************************************************

    function ActualizarCorreo($cod,$correo){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

      

        $consulta=" UPDATE persona AS per INNER JOIN usuario AS usu ON per.codPersona = usu.codPersona SET per.correo = '".$correo."' WHERE usu.codUsuario = '".$cod."' ";

        if (! $db->Query($consulta)){

                return false;

                 }

            else

            {

            return true;

        }

        

    }

    //******************************************************************************************************

    function ObtenerPagos($codProspecto){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

select FormaPago, sum(monto) as monto, sum(pago) as pago, sum(monto)-COALESCE(sum(pago),0) as saldo,

COALESCE(sum(pago),0)/sum(monto)*100 as avance, consulta.codFormaPago from (

            select fpp.codFormaPagoProspecto, fp.codFormaPago,  fp.descripcion as FormaPago, fpp.monto

            from forma_pago_prospecto as fpp

            left join forma_pago as fp on fp.codFormaPago=fpp.codFormaPago

			left join vehiculo_prospecto as vp on vp.codVehiculoProspecto=fpp.codVehiculoProspecto

            where fpp.baja='0' and fpp.monto>0 and fpp.codProspecto=$codProspecto and vp.baja='0'

) as consulta

left join (

	select sum(p.monto) as pago,  fp.codFormaPago, p.codFormaPagoProspecto

	from pago as p

	left join forma_pago_prospecto as fp on fp.codFormaPagoProspecto=p.codFormaPagoProspecto

	left join vehiculo_prospecto as v on v.codVehiculoProspecto=fp.codVehiculoProspecto

	where v.codProspecto=$codProspecto and v.baja='0'

	group by p.codFormaPagoProspecto

) as pagos on pagos.codFormaPagoProspecto=consulta.codFormaPagoProspecto

group by FormaPago, consulta.codFormaPago

		";

        $db->Query($consulta);

        return $db;

    }

    //******************************************************************************************************

    function ObtenerPago($codCotizacion){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

select consulta.codFormaPagoProspecto, FormaPago, sum(monto) as monto, sum(pago) as pago, sum(monto)-COALESCE(sum(pago),0) as saldo,

COALESCE(sum(pago),0)/sum(monto)*100 as avance, consulta.codFormaPago from (

            select fpp.codFormaPagoProspecto, fp.codFormaPago,  fp.descripcion as FormaPago, fpp.monto

            from forma_pago_prospecto as fpp

            left join forma_pago as fp on fp.codFormaPago=fpp.codFormaPago

			left join vehiculo_prospecto as vp on vp.codVehiculoProspecto=fpp.codVehiculoProspecto

            where fpp.baja='0' and fpp.monto>0 and fpp.codVehiculoProspecto=$codCotizacion

) as consulta

left join (

	select sum(p.monto) as pago,  fp.codFormaPago, p.codFormaPagoProspecto

	from pago as p

	left join forma_pago_prospecto as fp on fp.codFormaPagoProspecto=p.codFormaPagoProspecto

	where fp.codVehiculoProspecto=$codCotizacion and p.baja='0'

	group by p.codFormaPagoProspecto

) as pagos on pagos.codFormaPagoProspecto=consulta.codFormaPagoProspecto

group by consulta.codFormaPagoProspecto, FormaPago, consulta.codFormaPago

		";



        $db->Query($consulta);

        return $db;

    }

    //******************************************************************************************************

    function ObtenerDetalleFormaPago($codFormaPagoProspecto){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="select codPago, monto, estado, case when baja='0' then 'Activo' else 'Eliminado' end as activo, DATE_FORMAT(fechaPago,'%d/%m/%Y') as fechaPago from pago where codFormaPagoProspecto=$codFormaPagoProspecto";

        $db->Query($consulta);

        return $db;

    }

    //******************************************************************************************************

    function ObtenerPagosDetallados($codProspecto){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

 select *, coalesce(pagado,0)/monto * 100 as avance, monto-coalesce(pagado,0) as saldo from (

		select esa.descripcion as asignacion,vp.codVehiculoProspecto, vp.codProspecto, m.nombre as modelo, t.nombre as tipo, st.nombre as subtipo,

		ma.descripcion as marca, vp.precioVenta, vp.anioComercial, c.nombre as color, cint.nombre as colorInterior,

		ec.nombre as estadoCom, eo.nombre as estadoOp, v.chasis

		from vehiculo_prospecto as vp

		left join subtipo as st on st.codSubTipo=vp.codSubTipo

		left join tipo as t on t.codTipo=st.codTipo

		left join modelo as m on m.codModelo = t.codModelo

		left join marca as ma on ma.codMarca=m.codMarca

		left join color as c on c.codColor=vp.codColor

		left join color_int as cint on cint.codColorInt=vp.codColorInterior

		left join vehiculo as v on v.codVehiculo=vp.codVehiculo

		left join estado_com as ec on ec.codEstadoCom=v.codEstadoCom

		left join estado_op as eo on eo.codEstadoOp=v.codEstadoOp

    	left join (

			select codVehiculoProspecto, max(codSolicitudAsignacion) as codSolicitudAsignacion, codEstadoSolicitudAsignacion

			from solicitud_asignacion

			group by codVehiculoProspecto

		) as sa on sa.codVehiculoProspecto=vp.codVehiculoProspecto

    	left join estado_solicitud_asignacion as esa on esa.codEstadoSolicitudAsignacion=sa.codEstadoSolicitudAsignacion

		where vp.baja='0' and vp.codProspecto=$codProspecto

) as veh

left join (

		select fpp.codVehiculoProspecto as codVehiculoProspectop, fpp.codFormaPagoProspecto,  fp.descripcion as FormaPago, fpp.monto, case when fpp.baja='3' then 'Pendiente' else 'Aprobado' end as Aprobacion,

        fpp.tasa, fpp.cuotas, fpp.periodicidad

		from forma_pago_prospecto as fpp

		left join forma_pago as fp on fp.codFormaPago=fpp.codFormaPago

		where (fpp.baja='0' or fpp.baja='3' ) and fpp.monto>0 and fpp.codProspecto=$codProspecto

) as formapago on veh.codVehiculoProspecto=formapago.codVehiculoProspectop

left join (

select COALESCE(sum(pago.monto),0) as pagado, pago.codFormaPagoProspecto as codFormaPagoProspecto2 from pago left join forma_pago_prospecto as fp on fp.codFormaPagoProspecto=pago.codFormaPagoProspecto

where pago.baja='0' and fp.codProspecto=$codProspecto  group by pago.codFormaPagoProspecto

) as p on p.codFormaPagoProspecto2=formapago.codFormaPagoProspecto";

        $db->Query($consulta);

        return $db;

    }

    //******************************************************************************************************

    function ObtenerPagosDetalladosVehiculo($codVehiculo){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta = "select codProspecto from vehiculo_prospecto where codVehiculo=$codVehiculo";

        if (! $db->Query($consulta)){

            return false;

        }

        if ($db->RowCount()>0){

            $db->MoveFirst();

            $dato=$db->Row();

            $codProspecto=$dato->codProspecto;

            $consulta="

 select *, coalesce(pagado,0)/monto * 100 as avance, monto-coalesce(pagado,0) as saldo from (

		select esa.descripcion as asignacion,vp.codVehiculoProspecto, vp.codProspecto, m.nombre as modelo, t.nombre as tipo, st.nombre as subtipo,

		ma.descripcion as marca, vp.precioVenta, vp.anioComercial, c.nombre as color, cint.nombre as colorInterior,

		ec.nombre as estadoCom, eo.nombre as estadoOp, v.chasis

		from vehiculo_prospecto as vp

		left join subtipo as st on st.codSubTipo=vp.codSubTipo

		left join tipo as t on t.codTipo=st.codTipo

		left join modelo as m on m.codModelo = t.codModelo

		left join marca as ma on ma.codMarca=m.codMarca

		left join color as c on c.codColor=vp.codColor

		left join color_int as cint on cint.codColorInt=vp.codColorInterior

		left join vehiculo as v on v.codVehiculo=vp.codVehiculo

		left join estado_com as ec on ec.codEstadoCom=v.codEstadoCom

		left join estado_op as eo on eo.codEstadoOp=v.codEstadoOp

    	left join (

			select codVehiculoProspecto, max(codSolicitudAsignacion) as codSolicitudAsignacion, codEstadoSolicitudAsignacion

			from solicitud_asignacion

			group by codVehiculoProspecto

		) as sa on sa.codVehiculoProspecto=vp.codVehiculoProspecto

    	left join estado_solicitud_asignacion as esa on esa.codEstadoSolicitudAsignacion=sa.codEstadoSolicitudAsignacion

		where vp.baja='0' and vp.codProspecto=$codProspecto and vp.codVehiculo=$codVehiculo and vp.baja='0'

) as veh

left join (

		select fpp.codVehiculoProspecto as codVehiculoProspectop, fpp.codFormaPagoProspecto,  fp.descripcion as FormaPago, fpp.monto

		from forma_pago_prospecto as fpp

		left join forma_pago as fp on fp.codFormaPago=fpp.codFormaPago

		where fpp.baja='0' and fpp.monto>0 and fpp.codProspecto=$codProspecto

) as formapago on veh.codVehiculoProspecto=formapago.codVehiculoProspectop

left join (

select COALESCE(sum(pago.monto),0) as pagado, pago.codFormaPagoProspecto as codFormaPagoProspecto2 from pago left join forma_pago_prospecto as fp on fp.codFormaPagoProspecto=pago.codFormaPagoProspecto

where fp.codProspecto=$codProspecto  and pago.baja='0' group by pago.codFormaPagoProspecto

) as p on p.codFormaPagoProspecto2=formapago.codFormaPagoProspecto";

            $db->Query($consulta);

            return $db;

        }else{

            return "0";

        }

    }

    //******************************************************************************************************

    function SolicitarAsignacionVehiculo($cod, $hcodVehiculo){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        // Verifico las condiciones de solicitu de asignacion, como ser que no haya una solicitud pendiente para este vehiculo o ya se haya asignado un chasis

        $consulta="select * from solicitud_asignacion where codVehiculoProspecto=$hcodVehiculo and codEstadoSolicitudAsignacion in (SELECT codEstadoSolicitudAsignacion FROM estado_solicitud_asignacion where descripcion='Pendiente'  )";

        $db->Query($consulta);

        // Si cumple todas las condiciones registro una nueva solicitud

        if ( $db->RowCount() > 0 ){

            $this->mensaje="Ya existe una solicitud para este vehiculo. ";

            return false;

        }



        $consulta="insert into solicitud_asignacion (codEstadoSolicitudAsignacion, codVehiculoProspecto) values ((SELECT codEstadoSolicitudAsignacion FROM estado_solicitud_asignacion where descripcion='Pendiente'  limit 1), $hcodVehiculo) ";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        // Debo mandar correo solicitando asignacion

        //---------------------------------------------

        $codsolicitud=$db->GetLastInsertID();

        $iCorreo = new Correo();

        $iCorreo->SolicitarAsignacion($codsolicitud);

        return true;

    }

    //******************************************************************************************************

    function SolicitarDesasignacionVehiculo($cod, $hcodVehiculo){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        // Verifico las condiciones de solicitu de asignacion, como ser que no haya una solicitud pendiente para este vehiculo o ya se haya desasignado un chasis

        $consulta="select * from solicitud_desasignacion where codVehiculoProspecto=$hcodVehiculo and codEstadoSolicitudDesasignacion in (SELECT codEstadoSolicitudAsignacion FROM estado_solicitud_asignacion where descripcion='Pendiente'  )";

        $db->Query($consulta);

        // Si cumple todas las condiciones registro una nueva solicitud

        if ( $db->RowCount() > 0 ){

            $this->mensaje="Ya existe una solicitud para este vehiculo. ";

            return false;

        }



        $consulta="insert into solicitud_desasignacion (codEstadoSolicituddesasignacion, codVehiculoProspecto) values ((SELECT codEstadoSolicitudAsignacion FROM estado_solicitud_asignacion where descripcion='Pendiente'  limit 1), $hcodVehiculo) ";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        // Debo mandar correo solicitando asignacion

        //---------------------------------------------

        $codsolicitud=$db->GetLastInsertID();

        $iCorreo = new Correo();

        $iCorreo->SolicitarDesasignacion($codsolicitud);

        return true;

    }

    //******************************************************************************************************

    function ListarProspecto($nro, $nombre, $telefono, $ci, $codUsuario, $estado="", $origen="", $vendedor="", $oficina="", $tamanoobra="",$area="",$sucursal){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }





        $condicion="";

        if (is_numeric($nro)) $condicion.=" and p.codProspecto =".$nro;

        if ($nombre!="") $condicion.=" and ( p.nombre like '%".str_replace(" ","%",$nombre)."%' or concat(p.PrimerNombre,' ',p.PrimerApellido) like '%".str_replace(" ","%",$nombre)."%' )";

        if ($telefono!="") $condicion.=" and p.telefono like '%".str_replace(" ","%",$telefono)."%'";

        if ($ci!="") $condicion.=" and ( p.ci like '%".str_replace(" ","%",$ci)."%' or p.nit like '%".str_replace(" ","%",$ci)."%' )";

        if (($oficina!="")&&($oficina!="0")) $condicion.=" and u.codOficina='$oficina' ";

        if (is_numeric($estado)) $condicion.=" and p.estado='$estado' ";

        if (is_numeric($origen)) $condicion.=" and p.codOrigenProspecto='$origen' ";

        if (is_numeric($vendedor)) $condicion.=" and p.codUsuario='$vendedor' ";

        if (is_numeric($area)) $condicion.=" and u.codSalon='$area' ";

        if (($tamanoobra !="")&&($tamanoobra!="0")) $condicion=" and p.tamanoObra='$tamanoobra'";

        if ($codUsuario!=""){

            $iUsuario = new Usuario();

            $iUsuario->RecuperarSesionCod($codUsuario);

            $perfil= $iUsuario->obtenerPerfil();

            if ($perfil=="Vendedor"){

                $condicion.=" and p.codUsuario='$codUsuario' ";

            }



            if ($perfil=="Jefatura"){

                $condicion.=" and u.codTipoUsuario in (2,3,4) and p.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codUsuario')) ";

            }



        }







        if ($sucursal > 0) $condicion.=" and u.codCiudad='$sucursal' ";







        $consulta="

select tab.*, leftj.total from (

    select distinct p.*,concat(p.nombre,' ',p.primerNombre,' ',p.primerApellido) as elnombre, e.descripcion as estadoProspecto, CONCAT(per.nombre, ' ', per.apePat) as vendedor,CONCAT(per2.nombre, ' ', per2.apePat) as referencial,cli.codClienteSAP

    from prospecto as p

    left join estado_prospecto as e on e.codEstadoProspecto=p.estado

    left join usuario as u on u.codUsuario=p.codUsuario

    left join persona as per on per.codPersona=u.codPersona

    left join usuario as u2 on u2.codUsuario=p.codPersona

    left join persona as per2 on per2.codPersona=u2.codPersona

     LEFT JOIN tp_cliente_sap cli on cli.codCliente=p.codCliente

    where 1=1 $condicion order by p.codProspecto desc

) as tab

left join (

    select codProspecto, sum(total) as total

    from tp_cabecera_cotizacion

    where codEstado=1 or codEstado=4

    group by codProspecto

) as leftj on leftj.codProspecto=tab.codProspecto



";



//         if(($sistemacons!="")&&($sistemacons!="0")){

//             $consulta="

// select distinct c1.* from (

//     $consulta

// ) as c1

// inner join (

//     SELECT codProspecto, codSistProducto

//     FROM newsgc.tp_cabecera_cotizacion

// ) as c2 on c2.codProspecto=c1.codProspecto

// where c2.codSistProducto=$sistemacons

// limit 200 ";

//         }



        $db->Query($consulta);

        return $db;

    }












        function ListarProspectoCuarentena($nro, $nombre, $telefono, $ci, $codUsuario, $estado="", $origen="", $vendedor="", $oficina="", $tamanoobra="",$area="",$sucursal,$estadoCua){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }





        $condicion="";

        if (is_numeric($nro)) $condicion.=" and p.codProspecto =".$nro;

        if ($nombre!="") $condicion.=" and ( p.nombre like '%".str_replace(" ","%",$nombre)."%' or concat(p.PrimerNombre,' ',p.PrimerApellido) like '%".str_replace(" ","%",$nombre)."%' )";

        if ($telefono!="") $condicion.=" and p.telefono like '%".str_replace(" ","%",$telefono)."%'";

        if ($ci!="") $condicion.=" and ( p.ci like '%".str_replace(" ","%",$ci)."%' or p.nit like '%".str_replace(" ","%",$ci)."%' )";

        if (($oficina!="")&&($oficina!="0")) $condicion.=" and u.codOficina='$oficina' ";

        if (is_numeric($estado)) $condicion.=" and p.estado='$estado' ";

        if (is_numeric($origen)) $condicion.=" and p.codOrigenProspecto='$origen' ";

        if (is_numeric($vendedor)) $condicion.=" and p.codUsuario='$vendedor' ";

        if (is_numeric($area)) $condicion.=" and u.codSalon='$area' ";

        if (($tamanoobra !="")&&($tamanoobra!="0")) $condicion=" and p.tamanoObra='$tamanoobra'";

        if ($codUsuario!=""){

            $iUsuario = new Usuario();

            $iUsuario->RecuperarSesionCod($codUsuario);

            $perfil= $iUsuario->obtenerPerfil();

            if ($perfil=="Vendedor"){

                $condicion.=" and p.codUsuario='$codUsuario' ";

            }



            if ($perfil=="Jefatura"){

                $condicion.=" and u.codTipoUsuario in (2,3,4) and p.codUsuario in (select codUsuario from usuario where codOficina=(select codOficina from usuario where codusuario='$codUsuario')) ";

            }



        }







        if ($sucursal > 0) $condicion.=" and u.codCiudad='$sucursal' ";



        if ($estadoCua != "") $condicion.=" and cua.estado =".$estadoCua;



        $consulta="

select tab.*, leftj.total from (

    select distinct p.*,concat(per3.nombre,' ',per3.apePat,' ') as solicitante,cua.fechaSolicitud,cua.observacion,cua.estado as estadoCuarentena,cua.codCuarentena,cua.codSolicitante,concat(p.nombre,' ',p.primerNombre,' ',p.primerApellido) as elnombre, e.descripcion as estadoProspecto, CONCAT(per.nombre, ' ', per.apePat) as vendedor,CONCAT(per2.nombre, ' ', per2.apePat) as referencial,cli.codClienteSAP

    from Cuarentena as cua 
    left join prospecto as p on p.codProspecto = cua.codProspecto

    left join estado_prospecto as e on e.codEstadoProspecto=p.estado

    left join usuario as u on u.codUsuario=p.codUsuario

    left join persona as per on per.codPersona=u.codPersona

    left join usuario as u2 on u2.codUsuario=p.codPersona

    left join persona as per2 on per2.codPersona=u2.codPersona

     LEFT JOIN tp_cliente_sap cli on cli.codCliente=p.codCliente
     left join usuario as u3 on u3.codUsuario=cua.codSolicitante
     
     left join persona as per3 on u3.codPersona=per3.codPersona

    where 1=1 $condicion  order by p.codProspecto desc

) as tab

left join (

    select codProspecto, sum(total) as total

    from tp_cabecera_cotizacion

    where codEstado=1 or codEstado=4

    group by codProspecto

) as leftj on leftj.codProspecto=tab.codProspecto



";



//         if(($sistemacons!="")&&($sistemacons!="0")){

//             $consulta="

// select distinct c1.* from (

//     $consulta

// ) as c1

// inner join (

//     SELECT codProspecto, codSistProducto

//     FROM newsgc.tp_cabecera_cotizacion

// ) as c2 on c2.codProspecto=c1.codProspecto

// where c2.codSistProducto=$sistemacons

// limit 200 ";

//         }



        $db->Query($consulta);

        return $db;

    }


    //******************************************************************************************************

    function CuadroProspecto($nro){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        //------------------------------

        $consulta="

select *, ( cast(TotalOperacion as decimal (10,2)) - cast( PagosRecibidos as decimal (10,2)) ) as PagosPendientes from (

		select (

				select (sum(case when codVehiculo is null then 0 else 1 end)/count(*)*100*0.40) +

						(

						 (

						   (

							(

							SELECT IFNULL(sum(IFNULL(monto,0)),0) FROM forma_pago_prospecto

							where  baja='0' and codProspecto=vp.codProspecto

							) * 100

						   ) / IFNULL(sum(IFNULL(total,0)),0)

						 ) * 0.45

						) +

						(

						 case when (

									select e.descripcion from prospecto as p

									left join estado_prospecto as e on e.codEstadoProspecto=p.estado

									where p.codProspecto=vp.codProspecto limit 1

									)='Cerrado' then 15 else 0 end

						) as prcAvanceVenta

				from vehiculo_prospecto as vp2 where vp2.codProspecto=vp.codProspecto and vp2.baja='0'

		) as prcAvanceVenta,

		(

		 select case when completado='0' then

					case when codTipoContacto=1 then 0 else 50 end

				else 100 end as prcSeguimiento

		 from seguimiento where codProspecto=vp.codProspecto

		 order by codSeguimiento desc limit 1

		) as prcSeguimiento,

		(

		 (

		  (

		   (

			SELECT IFNULL(sum(IFNULL(monto,0)),0) FROM forma_pago_prospecto

			where  baja='0' and codProspecto=vp.codProspecto

		   ) * 100

          ) / sum(total)

		 )

		) as prcPagos,

		IFNULL(sum(IFNULL(total,0)),0) as TotalOperacion,

		(

			SELECT sum(fpp2.monto) FROM forma_pago_prospecto   as fpp2

			left join tp_cabecera_cotizacion  as vp2 on vp2.codCabCotiza=fpp2.codVehiculoProspecto

			where  fpp2.baja='0' and vp2.codEstado='1' and fpp2.codProspecto=vp.codProspecto

		) as PagosRecibidos

		from tp_cabecera_cotizacion as vp where codProspecto=$nro and vp.codEstado='1'

) as consulta

		";

        $db->Query($consulta);

        $db->MoveFirst();

        return $db->Row();

    }

    //******************************************************************************************************

    function ValidarProspecto($ci="", $telefono="", $nombre="", $telefono2="", $nombrecontacto="", $telefonocontacto=""){

        $ci=trim($ci);

        $telefono=trim($telefono);

        $telefono2=trim($telefono2);

        $nombre=trim($nombre);

        $nombrecontacto=trim($nombrecontacto);

        $telefonocontacto=trim($telefonocontacto);

        $ci= str_replace(" ","", $ci);

        $telefono= str_replace(" ","%", $telefono);

        $nombre= str_replace(" ","%", $nombre);

        $nombrecontacto= str_replace(" ","%", $nombrecontacto);

        $telefono= str_replace("-","%", $telefono);

        $telefono2= str_replace(" ","%", $telefono2);

        $telefono2= str_replace("-","%", $telefono2);

        $telefonocontacto= str_replace(" ","%", $telefonocontacto);

        $telefonocontacto= str_replace("-","%", $telefonocontacto);

        $condicion="";

        if (($ci!="")&&($ci!="0")){ $condicion.=" or p.ci = '".$ci."'";}

        if (($nombre!="")){ $condicion.=" or p.nombre like '%".$nombre."%'";}

        if (($nombre!="")){ $condicion.=" or p.nombreContacto like '%".$nombre."%'";}

        if (($nombrecontacto!="")){ $condicion.=" or p.nombre like '%".$nombrecontacto."%'";}

        if (($nombrecontacto!="")){ $condicion.=" or p.nombreContacto like '%".$nombrecontacto."%'";}



        if (($telefono!="")&&($telefono!="0")&&($telefono!="%")){ $condicion.=" or p.telefono like '%".$telefono."%'";}

        if (($telefono!="")&&($telefono!="0")&&($telefono!="%")){ $condicion.=" or p.telefono2 like '%".$telefono."%'";}

        if (($telefono!="")&&($telefono!="0")&&($telefono!="%")){ $condicion.=" or p.telefonoContacto like '%".$telefono."%'";}



        if (($telefono2!="")&&($telefono2!="0")&&($telefono2!="%")){ $condicion.=" or p.telefono like '%".$telefono2."%'";}

        if (($telefono2!="")&&($telefono2!="0")&&($telefono2!="%")){ $condicion.=" or p.telefono2 like '%".$telefono2."%'";}

        if (($telefono2!="")&&($telefono2!="0")&&($telefono2!="%")){ $condicion.=" or p.telefonoContacto like '%".$telefono2."%'";}



        if (($telefonocontacto!="")&&($telefonocontacto!="0")&&($telefonocontacto!="%")){ $condicion.=" or p.telefono like '%".$telefonocontacto."%'";}

        if (($telefonocontacto!="")&&($telefonocontacto!="0")&&($telefonocontacto!="%")){ $condicion.=" or p.telefono2 like '%".$telefonocontacto."%'";}

        if (($telefonocontacto!="")&&($telefonocontacto!="0")&&($telefonocontacto!="%")){ $condicion.=" or p.telefonoContacto like '%".$telefonocontacto."%'";}





        $consulta="SELECT p.codProspecto, p.nombre, p.ci, p.telefono, p.telefono2, p.codUsuario , CONCAT(per.nombre, ' ', per.apePat) as vendedor, ofi.descripcion as oficina, e.descripcion as estado, (select DATE_FORMAT(max(fechaFinContacto),'%d/%m/%Y')  from seguimiento where codProspecto=p.codProspecto) as contacto, p.nombreContacto, p.telefonoContacto, p.fechaCreacion

    FROM prospecto as p

    left join usuario as u on u.codUsuario=p.codUsuario

    left join persona as per on per.codPersona=u.codPersona

    left join oficina as ofi on ofi.codOficina=u.codOficina

    left join estado_prospecto as e on e.codEstadoProspecto=p.estado

    where  p.telefono = 'sintelefonooo' $condicion";



        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $db->Query($consulta);

        $db->MoveFirst();

        $cont=0;

        //echo "<table class='table table-striped table-bordered table-hover'>";

        while (! $db->EndOfSeek()) {

            /*if ($cont==0){

                echo "<tr><td colspan='6'><h5 style='color:#000'>Ya existen prospectos activos con esos datos.</h5></td></tr>";

                echo "<tr>";

                echo "<th>Codigo</td>";

                echo "<th>Nombre</td>";

                echo "<th>CI</td>";

                echo "<th>Nombre Contacto</td>";

                echo "<th>Telefono Contacto</td>";

                echo "<th>Telefono</td>";

                echo "<th>Telefono2</td>";

                echo "<th>Vendedor</td>";

                echo "<th>Oficina</td>";

                echo "<th>Estado</td>";

                echo "<th>Contacto</td>";

                echo "</tr>";

            }*/

            $cont=$cont+1;

            $row = $db->Row();

            //echo "<hr>123";

            /*echo "<tr>";

            echo "<td>".$row->codProspecto."</td>";

            echo "<td>".$row->nombre."</td>";

            echo "<td>".$row->ci."</td>";

            echo "<td>".$row->nombreContacto."</td>";

            echo "<td>".$row->telefonoContacto."</td>";

            echo "<td>".$row->telefono."</td>";

            echo "<td>".$row->telefono2."</td>";

            echo "<td>".$row->vendedor."</td>";

            echo "<td>".$row->oficina."</td>";

            echo "<td>".$row->estado."</td>";

            echo "<td>".$row->contacto."</td>";

            echo "</tr>";*/

            echo '

            <div class="row">

            <div class="col-md-12">

          <div class="box box-danger">

          <div class="direct-chat-info clearfix">

                    <span class="direct-chat-name pull-left">&nbsp;&nbsp;&nbsp;&nbsp;'.$row->nombre.' ('.$row->codProspecto.')</span>

                    <span class="direct-chat-timestamp pull-right">Creado por:&nbsp;&nbsp;'.$row->vendedor.'('.$row->oficina.')'.'&nbsp;&nbsp;&nbsp;&nbsp;</span>

                  </div>

            <div class="box-body">

             <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Creado: &nbsp;&nbsp;'.$row->fechaCreacion.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">CI: &nbsp;&nbsp;'.$row->ci.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">telefono: &nbsp;&nbsp;'.$row->telefono.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Telefono2: &nbsp;&nbsp;'.$row->telefono2.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Nombre contacto: &nbsp;&nbsp;'.$row->nombreContacto.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Telf. contacto: &nbsp;&nbsp;'.$row->telefonoContacto.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Estado: &nbsp;&nbsp;'.$row->estado.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Ultimo contacto: &nbsp;&nbsp;'.$row->contacto.'</span>



            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

            </div>

            ';

        }

        if ($cont==0){

            echo '

          <center><h5 class="box-title">No existen coincidencias</h5></center><br>



            ';

        }

        //echo "</table>";

    }





        //******************************************************************************************************

    function ValidarProspecto2($ci="", $telefono=""){

        $ci=trim($ci);

        $telefono=trim($telefono);

        $condicion="";

        if (($ci!="")&&($ci!="0")){ $condicion.=" or p.ci = '".$ci."'";}

        if (($telefono!="")&&($telefono!="0")&&($telefono!="%")){ $condicion.=" or p.telefono like '%".$telefono."%'";}

        

        if (($telefono!="")&&($telefono!="0")&&($telefono!="%")){ $condicion.=" or p.telefonoContacto like '%".$telefono."%'";}





        $consulta="SELECT p.codProspecto, p.nombre, p.ci, p.telefono, p.telefono2, p.codUsuario , CONCAT(per.nombre, ' ', per.apePat) as vendedor, ofi.descripcion as oficina, e.descripcion as estado, (select DATE_FORMAT(max(fechaFinContacto),'%d/%m/%Y')  from seguimiento where codProspecto=p.codProspecto) as contacto, p.nombreContacto, p.telefonoContacto, p.fechaCreacion

    FROM prospecto as p

    left join usuario as u on u.codUsuario=p.codUsuario

    left join persona as per on per.codPersona=u.codPersona

    left join oficina as ofi on ofi.codOficina=u.codOficina

    left join estado_prospecto as e on e.codEstadoProspecto=p.estado

    where  p.telefono = 'sintelefonooo' $condicion";



        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $db->Query($consulta);

        $db->MoveFirst();

        $cont=0;

        //echo "<table class='table table-striped table-bordered table-hover'>";

        while (! $db->EndOfSeek()) {

            /*if ($cont==0){

                echo "<tr><td colspan='6'><h5 style='color:#000'>Ya existen prospectos activos con esos datos.</h5></td></tr>";

                echo "<tr>";

                echo "<th>Codigo</td>";

                echo "<th>Nombre</td>";

                echo "<th>CI</td>";

                echo "<th>Nombre Contacto</td>";

                echo "<th>Telefono Contacto</td>";

                echo "<th>Telefono</td>";

                echo "<th>Telefono2</td>";

                echo "<th>Vendedor</td>";

                echo "<th>Oficina</td>";

                echo "<th>Estado</td>";

                echo "<th>Contacto</td>";

                echo "</tr>";

            }*/

            $cont=$cont+1;

            $row = $db->Row();

            //echo "<hr>123";

            /*echo "<tr>";

            echo "<td>".$row->codProspecto."</td>";

            echo "<td>".$row->nombre."</td>";

            echo "<td>".$row->ci."</td>";

            echo "<td>".$row->nombreContacto."</td>";

            echo "<td>".$row->telefonoContacto."</td>";

            echo "<td>".$row->telefono."</td>";

            echo "<td>".$row->telefono2."</td>";

            echo "<td>".$row->vendedor."</td>";

            echo "<td>".$row->oficina."</td>";

            echo "<td>".$row->estado."</td>";

            echo "<td>".$row->contacto."</td>";

            echo "</tr>";*/

            echo '

            <div class="row">

            <div class="col-md-12">

          <div class="box box-danger">

          <div class="direct-chat-info clearfix">

                    <span class="direct-chat-name pull-left">&nbsp;&nbsp;&nbsp;&nbsp;'.$row->nombre.' ('.$row->codProspecto.')</span>

                    <span class="direct-chat-timestamp pull-right">Creado por:&nbsp;&nbsp;'.$row->vendedor.'('.$row->oficina.')'.'&nbsp;&nbsp;&nbsp;&nbsp;</span>

                  </div>

            <div class="box-body">

             <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Creado: &nbsp;&nbsp;'.$row->fechaCreacion.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">CI: &nbsp;&nbsp;'.$row->ci.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">telefono: &nbsp;&nbsp;'.$row->telefono.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Telefono2: &nbsp;&nbsp;'.$row->telefono2.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Nombre contacto: &nbsp;&nbsp;'.$row->nombreContacto.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Telf. contacto: &nbsp;&nbsp;'.$row->telefonoContacto.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Estado: &nbsp;&nbsp;'.$row->estado.'</span>

              <span style="display: inline-block;padding: 0 15px 0 15px;width: 160px;">Ultimo contacto: &nbsp;&nbsp;'.$row->contacto.'</span>



            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

            </div>

            ';

        }

        if ($cont==0){

            echo '

          <center><h5 class="box-title">No existen coincidencias</h5></center><br>



            ';

        }

        //echo "</table>";

    }

    //******************************************************************************************************













        function ValidarCliente($ci=""){

        $ci=trim($ci);

     

        $condicion="";

        if (($ci!="")&&($ci!="0")){ $condicion.=" or p.ci = '".$ci."'";}

        $consulta="SELECT p.codProspecto, p.nombre, p.ci, p.telefono, p.telefono2, p.codUsuario , CONCAT(per.nombre, ' ', per.apePat) as vendedor, ofi.descripcion as oficina, e.descripcion as estado, (select DATE_FORMAT(max(fechaFinContacto),'%d/%m/%Y')  from seguimiento where codProspecto=p.codProspecto) as contacto, p.nombreContacto, p.telefonoContacto, p.fechaCreacion

    FROM prospecto as p

    left join usuario as u on u.codUsuario=p.codUsuario

    left join persona as per on per.codPersona=u.codPersona

    left join oficina as ofi on ofi.codOficina=u.codOficina

    left join estado_prospecto as e on e.codEstadoProspecto=p.estado

    where  p.telefono = 'sintelefonooo' $condicion";



        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $db->Query($consulta);

        if($db->RowCount()>0)

        {

            echo 'existe';

        }

        else

        {

            echo 'libre';

        }





    }





    ////////////////////////*////

    function RegistrarPago($codpagovehiculo, $monto){

        if (is_numeric($monto)==false){

            $this->mensaje="El monto ingresado para el pago no corresponde a un valor numerico valida.";

            return false;

        }

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        //obtengo el monto total de la forma de pago y los pagos que se hicieron hasta el momento.

        $consulta="select monto as pactado,

COALESCE((select sum(monto) as pagos from pago where baja='0' and codFormaPagoProspecto=fp.codFormaPagoProspecto),0) as pagos

from forma_pago_prospecto as fp where codFormaPagoProspecto=$codpagovehiculo";

        $db->Query($consulta);

        $pactado=0;

        $pagado=0;

        if ( $db->RowCount() > 0 ){

            $db->MoveFirst();

            $row = $db->Row();

            $pactado=$row->pactado;

            $pagado=$row->pagos;

        }

        // si el monto pagado + el pago actual no excede el total pactado acepto el pago, sino mensaje

        if ($pagado+$monto<=$pactado){

            $consulta="insert into pago (codFormaPagoProspecto, monto, fechaPago) values ('$codpagovehiculo','$monto', SYSDATE())";

            if (! $db->Query($consulta)){

                $this->mensaje=$consulta;

                return false;

            }

        }else{

            $saldo=$pactado-$pagado;

            $this->mensaje=" No se pudo registrar el pago. El monto total excederia el pactado. <ul><li>Pactado:".number_format($pactado, 2, '.', ',')."</li><li> Pagos:".number_format($pagado, 2, '.', ',')."</li><li> Saldo:".number_format($saldo, 2, '.', ',')."</li></ul>";

            return false;

        }

        return true;

    }

    //--------------------------------------------------------------------------------------------------------

    function EliminarPago($codpago){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update pago set baja='1' where codPago=$codpago";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        return true;

    }

    //--------------------------------------------------------------------------------------------------------

    function EliminarFormaPago($hcodpagovehiculo){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update forma_pago_prospecto set baja='1' where codFormaPagoProspecto=$hcodpagovehiculo";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        return true;

    }

    //--------------------------------------------------------------------------------------------------------

    function CerrarProspecto($codProspecto,$poliza,$prima,$certificado,$cerrador){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update prospecto set estado=(select codEstadoProspecto from estado_prospecto where descripcion='Cerrado' limit 1), fechaCierre=SYSDATE(),cerrador='$cerrador' where codProspecto=$codProspecto and estado=(select codEstadoProspecto from estado_prospecto where descripcion='Nuevo Prospecto')";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        // $consulta2="INSERT INTO cierre_prospecto (codProspecto,poliza,prima,certificado) values ('".$codProspecto."','".$poliza."','".$prima."','".$certificado."')";

        // if (! $db->Query($consulta2)){

        //     return false;



        // }

        return true;

        

    }

    //--------------------------------------------------------------------------------------------------------

     function rechazarProducto($codDetalle, $motivo, $submotivo, $descripcion,$nombreusuario){

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update producto_detalle set estado=1, fechaCierre=SYSDATE(), codMotivo='$motivo', codSubMotivo='$submotivo', descBaja='$descripcion',nombrecierre='$nombreusuario' where codProductoDetalle=$codDetalle ";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

    



      

        return true;

        

     }

      //--------------------------------------------------------------------------------------------------------

    function CerrarProducto($codDetalle,$poliza,$prima,$certificado,$nombreusuario){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update producto_detalle set estado=0, poliza='$poliza', primaFinal='$prima', nroDocumento='$certificado', fechaCierre=SYSDATE(),nombrecierre='$nombreusuario' where codProductoDetalle=$codDetalle ";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

           

      

        return true;

        

    }

    //--------------------------------------------------------------------------------------------------------





    function Facturar($codVehiculo){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta=" select codVehiculo from vehiculo_prospecto where codVehiculoProspecto='$codVehiculo'";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        if ($db->RowCount()>0){

            $db->MoveFirst();

            $vp= $db->Row();

            $codvp= $vp->codVehiculo;



            $consulta="update vehiculo set codEstadoCom='4', fechaFacturacion=SYSDATE() where codVehiculo='$codvp' and codEstadoCom='2' ";

            if (! $db->Query($consulta)){

                $this->mensaje=$consulta;

                return false;

            }

            return true;

        }

        return false;

    }

    //--------------------------------------------------------------------------------------------------------

    function ReaperturarProspecto($codProspecto){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update prospecto set estado=(select codEstadoProspecto from estado_prospecto where descripcion='Nuevo Prospecto' limit 1), fechaCierre=SYSDATE() where codProspecto=$codProspecto and estado=(select codEstadoProspecto from estado_prospecto where descripcion='Cerrado')";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        return true;

    }

    //--------------------------------------------------------------------------------------------------------

    function Reasignar($codProspecto, $codVendedor){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update prospecto set codUsuario=$codVendedor where codProspecto=$codProspecto ";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        return true;

    }





    function ReasignarRen($codProspecto, $codVendedor){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }



       $iUsuario = new Usuario();

            $usu= $iUsuario->ObtenerIntermediario($codVendedor);

            $nombre= $usu->nombreIntermediario;

            $codigo= $usu->codigoIntermediario;



        $consulta="update renovacion set codigoIntermediario='".$codigo."', nombreIntermediario='".$nombre."' where codRenovacion='$codProspecto' ";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        return true;

    }

    //--------------------------------------------------------------------------------------------------------

    function AgregarArchivo($vcod, $nuevonombre, $tipo,$tipodoc){



        $consulta="insert into archivos( codProspecto, nombre, codTipoArchivo, codTipoDoc, fecha, baja) values( '$vcod', '$nuevonombre','$tipo','$tipodoc', NOW(),'0')";

        $db = new MySQL();

        if ($db->Error()) $db->Kill();

        $db->ThrowExceptions = true;



        if (! $db->TransactionBegin()) $db->Kill();

        $success = true;

        $sql = $consulta;

        if (! $db->Query($sql)) $success = false;

        //Obtengo empresa del prospecto

        $consulta="select codProspecto, sum(Fiat) as Fiat, sum(NoFiat) as NoFiat from (

select vp.codProspecto, case when mo.codMarca=1 then 1 else 0 end as Fiat,

case when mo.codMarca<>1 then 1 else 0 end as NoFiat

from vehiculo_prospecto  as vp

left join modelo as mo on vp.codModelo=mo.codModelo

where codProspecto=$vcod and vp.baja='0'

) as tabla group by codProspecto";

        $fiat=false;

        $nofiat=false;

        if($success){

            $sql = $consulta;

            if (! $db->Query($sql)) $success = false;

            if($success){

                if($db->RowCount()>0){

                    $db->MoveFirst();

                    $control=$db->Row();

                    if ($control->Fiat!="0"){

                        $fiat=true;

                    }

                    if ($control->NoFiat!="0"){

                        $nofiat=true;

                    }

                }

            }

        }

        //Verifico si el tipo de archivo tiene mensaje

        $controlfiat="";

        $controlnofiat="";

        $tipoarchivo="";

        if($success){

            $consulta="select * from tipo_archivo where codTipoArchivo=$tipo";

            $sql = $consulta;

            if (!$db->Query($sql)) $success = false;

            if($success){

                if($db->RowCount()>0){

                    $db->MoveFirst();

                    $control=$db->Row();

                    if ($control->notificacionRodaria!=""){

                        $controlfiat=$control->notificacionRodaria;

                        $tipoarchivo=$control->descripcion;

                    }

                    if ($control->notificacionCarrera!=""){

                        $controlnofiat=$control->notificacionCarrera;

                        $tipoarchivo=$control->descripcion;

                    }

                }

            }

        }

        // Envio los correos respectivos

        if($success){

            if($fiat){

                //enviar correo a notificacionRodaria, con codprospecto y tipo de archivo

                $iCorreo = new Correo();

                $iCorreo->NuevoArchivo($vcod, $controlfiat, $tipoarchivo);

            }

            if($nofiat){

                //enviar correo a notificacionRodaria, con codprospecto y tipo de archivo

                $iCorreo = new Correo();

                $iCorreo->NuevoArchivo($vcod, $controlnofiat, $tipoarchivo);

            }

        }

        //Termino transaccion

        if ($success) {

            if (! $db->TransactionEnd()) {

                $db->Kill();

            }

            return true;

        } else {

            if (! $db->TransactionRollback()) {

                $db->Kill();

                return false;

            }

        }

        return true;

    }



  function AgregarArchivoRenovacion($vcod, $nuevonombre, $tipo,$tipodoc){



        $consulta="insert into archivosRenovacion( codRenovacion, nombre, codTipoArchivo, codTipoDoc, fecha, baja) values( '$vcod', '$nuevonombre','$tipo','$tipodoc', NOW(),'0')";

        $db = new MySQL();

        if ($db->Error()) $db->Kill();

        $db->ThrowExceptions = true;



        if (! $db->TransactionBegin()) $db->Kill();

        $success = true;

        $sql = $consulta;

        if (! $db->Query($sql)) $success = false;

        //Obtengo empresa del prospecto

        $consulta="select codProspecto, sum(Fiat) as Fiat, sum(NoFiat) as NoFiat from (

select vp.codProspecto, case when mo.codMarca=1 then 1 else 0 end as Fiat,

case when mo.codMarca<>1 then 1 else 0 end as NoFiat

from vehiculo_prospecto  as vp

left join modelo as mo on vp.codModelo=mo.codModelo

where codProspecto=$vcod and vp.baja='0'

) as tabla group by codProspecto";

        $fiat=false;

        $nofiat=false;

        if($success){

            $sql = $consulta;

            if (! $db->Query($sql)) $success = false;

            if($success){

                if($db->RowCount()>0){

                    $db->MoveFirst();

                    $control=$db->Row();

                    if ($control->Fiat!="0"){

                        $fiat=true;

                    }

                    if ($control->NoFiat!="0"){

                        $nofiat=true;

                    }

                }

            }

        }

        //Verifico si el tipo de archivo tiene mensaje

        $controlfiat="";

        $controlnofiat="";

        $tipoarchivo="";

        if($success){

            $consulta="select * from tipo_archivo where codTipoArchivo=$tipo";

            $sql = $consulta;

            if (!$db->Query($sql)) $success = false;

            if($success){

                if($db->RowCount()>0){

                    $db->MoveFirst();

                    $control=$db->Row();

                    if ($control->notificacionRodaria!=""){

                        $controlfiat=$control->notificacionRodaria;

                        $tipoarchivo=$control->descripcion;

                    }

                    if ($control->notificacionCarrera!=""){

                        $controlnofiat=$control->notificacionCarrera;

                        $tipoarchivo=$control->descripcion;

                    }

                }

            }

        }

        // Envio los correos respectivos

        if($success){

            if($fiat){

                //enviar correo a notificacionRodaria, con codprospecto y tipo de archivo

                $iCorreo = new Correo();

                $iCorreo->NuevoArchivo($vcod, $controlfiat, $tipoarchivo);

            }

            if($nofiat){

                //enviar correo a notificacionRodaria, con codprospecto y tipo de archivo

                $iCorreo = new Correo();

                $iCorreo->NuevoArchivo($vcod, $controlnofiat, $tipoarchivo);

            }

        }

        //Termino transaccion

        if ($success) {

            if (! $db->TransactionEnd()) {

                $db->Kill();

            }

            return true;

        } else {

            if (! $db->TransactionRollback()) {

                $db->Kill();

                return false;

            }

        }

        return true;

    }





        function AgregarArchivo2($vcod, $nuevonombre, $tipo){



        $consulta="insert into archivos( codProspecto, nombre, codTipoArchivo, fecha, baja) values( '$vcod', '$nuevonombre','$tipo', NOW(),'0')";

        $db = new MySQL();

        if ($db->Error()) $db->Kill();

        $sql = $consulta;

        if (! $db->Query($sql)) $success = false;

       

        return true;

    }



    function CambiarPrecio($cod, $monto, $commod, $commodpre,  $comtransp, $complacas, $comotros, $commodh, $commodpreh,  $comtransph, $complacash, $comotrosh){

        if (is_numeric($monto)){

            $consulta=" update vehiculo_prospecto set precioVenta='$monto'";



            if($comtransp==""){$comtransp="NULL";}else{$comtransp="'".$comtransp."'";}

            $consulta.=", ComTransporte=$comtransp";



            if($complacas==""){$complacas="NULL";}else{$complacas="'".$complacas."'";}

            $consulta.=", ComPlacas=$complacas";



            if($comotros==""){$comotros="NULL";}else{$comotros="'".$comotros."'";}

            $consulta.=", ComOtros=$comotros";



            if($commod==""){$commod="NULL";}else{$commod="'".$commod."'";}

            $consulta.=", ComModelo=$commod";



            if($commodpre==""){$commodpre="NULL";}else{$commodpre="'".$commodpre."'";}

            $consulta.=", ComModeloPre=$commodpre";



            if($comtransph==""){$comtransph="NULL";}else{$comtransph="'".$comtransph."'";}

            $consulta.=", ComTransporteH=$comtransph";



            if($complacash==""){$complacash="NULL";}else{$complacash="'".$complacash."'";}

            $consulta.=", ComPlacasH=$complacash";



            if($comotrosh==""){$comotrosh="NULL";}else{$comotrosh="'".$comotrosh."'";}

            $consulta.=", ComOtrosH=$comotrosh";



            if($commodh==""){$commodh="NULL";}else{$commodh="'".$commodh."'";}

            $consulta.=", ComModeloH=$commodh";



            if($commodpreh==""){$commodpreh="NULL";}else{$commodpreh="'".$commodpreh."'";}

            $consulta.=", ComModeloPreH=$commodpreh";



            $consulta.=" where codVehiculoProspecto='$cod' ";



            //echo $consulta;



            $db = new MySQL();

            if ($db->Error()) $db->Kill();

            $db->ThrowExceptions = true;



            if (! $db->TransactionBegin()) $db->Kill();

            $success = true;

            $sql = $consulta;

            if (! $db->Query($sql)) $success = false;

            if ($success) {

                if (! $db->TransactionEnd()) {

                    $db->Kill();

                }

                return true;

            } else {

                if (! $db->TransactionRollback()) {

                    $db->Kill();

                    return false;

                }

            }

            return true;

        }else{

            return true;

        }

    }

    //--------------------------------------------------------------------------------------------------------

    function ListarArchivos($cod){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $condicion="";

        if (is_numeric($nro)) $condicion.=" and codProspecto =".$nro;

        $consulta="

		select * from archivos where 1=1 and baja='0' $condicion

		";

        $db->Query($consulta);

        return $db;

    }

    //--------------------------------------------------------------------------------------------------------

    public function ListarImagenes($cod){

        $db = new MySQL();

        if ($db->Error()) $db->Kill();

        $consulta="SELECT a.*, ta.descripcion as tipoArchivo, case when a.baja='0' then 'Vigente' else 'Eliminado' end as estado FROM archivos as a left join tipo_archivo as ta on ta.codTipoArchivo=a.codTipoArchivo  where codProspecto=".$cod;

        if (! $db->Query($consulta)) $db->Kill();

        $db->MoveFirst();

        //echo "<table><tr><td>";

        echo "<table class='table table-striped table-bordered table-hover'><tr><th>Tipo</th><th>Nombre</th><th>Imagen</th><th>Estado</th><th></th></tr>";

        while (! $db->EndOfSeek()) {

            $row = $db->Row();

            $file=$row->nombre;

            $ext=substr($file, -4);

            $ext=strtolower($ext);

            $imagen='"../spc/upload/'.$row->nombre.'"';

            $imagen='"'.$row->nombre.'"';

            $img="";

            //echo "<div style='min-width:70px; float:left; display:block; padding:5px; '><center>";

            if (($ext==".jpg")||($ext==".gif")||($ext==".png")||($ext=="jpeg")){

                /*echo "<img  src='../spc/upload/".$row->nombre."'  style='height:50px; border-color:#cecece; border-width:1px; border-style:solid; padding:5px; cursor:pointer' onclick='MostrarPDF(".$imagen.")'/>";	*/

                $img="<img  src='../spc/upload/".$row->nombre."'  style='height:50px; padding:5px; cursor:pointer' onclick='MostrarPDF(".$imagen.",".$cod.")'/>";

            }else if(($ext=="pdf")||($ext=="PDF")){

                /*echo "<img  src='../images/pdf.png'  style='height:50px; border-color:#cecece; border-width:1px; border-style:solid; padding:5px; cursor:pointer' onclick='MostrarPDF(".$imagen.")'/>";	*/

                $img ="<img  src='../images/pdf.png'  style='height:50px; padding:5px; cursor:pointer' onclick='MostrarPDF(".$imagen.",".$cod.")'/>";

            }else{

                $img ="<img  src='../images/file.png'   style='height:50px; padding:5px; cursor:pointer' onclick='MostrarPDF(".$imagen.",".$cod.")'/>";

            }

            echo "<tr><th>".$row->tipoArchivo."</th><th>".$row->nombre."</th><th>".$img."</th><th>".$row->estado."</th><th></th></tr>";

            //echo "<br>".$row->nombre."</center></div>";

        }

        //echo "</td></tr></table>";

        echo "</table>";



    }

    //--------------------------------------------------------------------------------------------------------

    public function ListarImagenes2($cod){

        $db = new MySQL();

        if ($db->Error()) $db->Kill();

        $consulta="SELECT case when a.codTipoDoc=1 then 'COTIZACION' when a.codTipoDoc=2 then 'POLIZA' when a.codTipoDoc=3 then 'OTROS' end as tipodocumento,a.*, ta.descripcion as tipoArchivo, case when a.baja='0' then 'Vigente' else 'Eliminado' end as estado FROM archivos as a left join tipo_archivo as ta on ta.codTipoArchivo=a.codTipoArchivo  where codProspecto='$cod' ";

        if (! $db->Query($consulta)) $db->Kill();

        return $db;

    }



      public function ListarImagenesRenovacion($cod){

        $db = new MySQL();

        if ($db->Error()) $db->Kill();

        $consulta="SELECT case when a.codTipoDoc=1 then 'COTIZACION' when a.codTipoDoc=2 then 'POLIZA' when a.codTipoDoc=3 then 'OTROS' end as tipodocumento,a.*, ta.descripcion as tipoArchivo, case when a.baja='0' then 'Vigente' else 'Eliminado' end as estado FROM archivosRenovacion as a left join tipo_archivo as ta on ta.codTipoArchivo=a.codTipoArchivo  where codRenovacion='$cod' ";

        if (! $db->Query($consulta)) $db->Kill();

        return $db;

    }

    //------------------------------------------------------

    public function ObtenerJefes($codigo){

        $consulta="

select p.correo

from usuario as u

left join persona as p on p.codPersona = u.codPersona

where codTipoUsuario in (select codTipoUsuario from tipousuario where descripcion like '%Jefatura%')

and codOficina in (select codOficina from usuario where codUsuario='$codigo') and correo is not null and correo like '%@%'

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

    //------------------------------------------------------

    function Eliminar($codProspecto, $motivo, $descBaja,$submotivo){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update prospecto set estado=3, codMotivoSuspension=$motivo, DescripcionBaja='$descBaja' , codSubMotivoSuspencion=$submotivo where codProspecto=$codProspecto ";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        return true;

    }


       function Eliminar2($codProspecto){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update prospecto set estado=3 where codProspecto=$codProspecto ";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        return true;

    }





     function EliminarRen($codProspecto, $motivo, $descBaja,$submotivo){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update renovacion set codEstadoProspecto=3, codMotivoSuspension=$motivo, DescripcionBaja='$descBaja' , codSubMotivoSuspencion=$submotivo where codRenovacion=$codProspecto ";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        return true;

    }





    //------------------------------------------------------

    function Reactivar($codProspecto){

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        $consulta="update prospecto set estado=1 where codProspecto=$codProspecto ";

        if (! $db->Query($consulta)){

            $this->mensaje=$consulta;

            return false;

        }

        return true;

    }

    //------------------------------------------------------

    public function ObtenerDetallePago($codigo){

        $consulta="

SELECT f.descripcion as formaPago, ifnull(p.monto,0) as monto,

ifnull(p.tasa,0) as tasa, ifnull(p.cuotas,0) as cuotas,

ifnull(p.periodicidad,0) as periodicidad

FROM forma_pago_prospecto as p

left join forma_pago as f on f.codFormaPago=p.codFormaPago

where p.codFormaPagoProspecto=$codigo

";

        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "vacio";

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return "vacio";

            }else{

                $db->MoveFirst();

                return $db->Row();

            }

        }

    }

    //------------------------------------------------------

    public function Cerrable($codigo){

        $consulta="

SELECT  vp.* from vehiculo_prospecto as vp

left join vehiculo as v on v.codVehiculo=vp.codVehiculo

where vp.codProspecto=$codigo and v.codEstadoCom=4

";

        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return false;

            }else{

                if ($db->RowCount()>0){

                    return false;

                }else{

                    return true;

                }

            }

        }

    }

    //------------------------------------------------------

    public function Calendario($codigo){

        $consulta="

select t1.day as fecha, day(t1.day) as dia, month(t1.day) as mes,

year(t1.day) as anio, WEEKDAY(t1.day)+1 as dian,

IFNULL(t2.cantidad ,0) as cantidad

from (

SELECT  DATE_FORMAT(SYSDATE(),'%Y-%m-%d') + INTERVAL t.n - 1 DAY day

FROM tally t

WHERE t.n <= DATEDIFF(LAST_DAY(ADDDATE(SYSDATE(), INTERVAL 30 DAY)),  DATE_FORMAT(SYSDATE(),'%Y-%m-%d') ) + 1

) as t1

left join (

select DATE_FORMAT(fechaProxContacto,'%Y-%m-%d') as day, count(*) as cantidad

from seguimiento

left join prospecto as p on p.codProspecto=seguimiento.codProspecto

where completado='0' and fechaProxContacto>SYSDATE()  and p.codUsuario='$codigo'

group by DATE_FORMAT(fechaProxContacto,'%Y-%m-%d')

order by DATE_FORMAT(fechaProxContacto,'%Y-%m-%d') asc

limit 30

) as t2 on cast(t1.day as date)= cast(t2.day as date)

order by t1.day asc limit 30";

        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return false;

            }else{

                return $db;

            }

        }

    }

    //***************

    function CambiarFacturacion($cod, $fecha){

        $consulta="

update vehiculo set fechaFacturacion='$fecha' where codVehiculo='$cod' and codEstadoCom='4' and fechaFacturacion is not null";

        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return false;

            }else{

                return true;

            }

        }

    }

    //--------------------------------------------------------------------------------------------------------

    function Clonar($codProspecto){

        $consulta="insert into prospecto (nombre,primerNombre,primerApellido, ci, ext, telefono, telefono2, esEmpresa, nombreContacto, telefonoContacto,

 estado, codMotivoSuspension, codUsuario, codOrigenProspecto, codMedio,

notas, codPersona, fechaCreacion, fechaCierre, email)

select nombre,primerNombre,primerApellido, ci, ext, telefono, telefono2, esEmpresa, nombreContacto, telefonoContacto,

1 as estado, 0 as codMotivoSuspension, codUsuario, codOrigenProspecto, codMedio,

DATE_FORMAT(SYSDATE(),'%d-%m-%Y: Clonación prospecto $codProspecto <br>') as notas, codPersona,

SYSDATE() as fechaCreacion, NULL as fechaCierre, email

 from prospecto where codProspecto=$codProspecto;";



        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }

        // Habilito excepciones

        $db->ThrowExceptions = true;

        if (! $db->TransactionBegin()) $db->Kill();



        $success = true;

        $sql = $consulta;



        if (!$db->Query($sql)){

            $success = false;

        }



        $NcodProspecto=$db->GetLastInsertID();



        if ($success) {

            //clonar documentos

            $consulta="insert into archivos (codTipoArchivo, codProspecto, nombre, fecha, baja)

select a.codTipoArchivo, $NcodProspecto as codProspecto, a.nombre, SYSDATE() as fecha, a.baja

from archivos  as a

inner join tipo_archivo as t on t.codTipoArchivo=a.codTipoArchivo

where t.descripcion in ('Documento identidad cliente','Documento identidad conyugue',

'Formulario declaracion de bienes e ingresos','Fotos','NIT','Poder representante legal',

'Aviso de Cobranza de Luz/Agua','Otros Documentos')

and a.codProspecto=$codProspecto";

            $sql=$consulta;

            if (!$db->Query($sql)){

                $success = false;

            }

        }

        // Si hizo todo bien

        if ($success) {

            if (! $db->TransactionEnd()) {

                $db->Kill();

            }

            return $NcodProspecto;

        } else {

            if (! $db->TransactionRollback()) {

                $db->Kill();

            }

        }

        return false;

    }

    //-------------------------------------------------------------------------------------------------------------

    function CambiarLugarEntrega($codVpLugEntrega, $codentrega){

        $consulta="update vehiculo_prospecto  set lugarEntrega='$codentrega' where codVehiculoprospecto='$codVpLugEntrega' ";

        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return false;

            }else{

                return true;

            }

        }



    }

    //-------------------------------------------------------------------------------------------------------------

    function AgregarContacto($codprospecto, $nombre, $cargo, $telefono, $email){

        $consulta="insert into contactos(codProspecto, nombre, cargo, telefono, email, baja) values('$codprospecto', '$nombre', '$cargo', '$telefono', '$email', '0') ";

        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return false;

            }else{

                return true;

            }

        }



    }

    //-------------------------------------------------------------------------------------------------------------

    function EditarContacto($codcontacto, $nombre, $cargo, $telefono, $email){

        $consulta="update contactos set nombre='$nombre', cargo='$cargo', telefono='$telefono', email='$email' where codContacto='$codcontacto' ";



        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return false;

            }else{

                return true;

            }

        }



    }

    //-------------------------------------------------------------------------------------------------------------

    function EliminarContacto($codcontacto){

        $consulta="update contactos set baja='1' where codContacto='$codcontacto' ";



        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return false;

            }else{

                return true;

            }

        }



    }

    //-------------------------------------------------------------------------------------------------------------

    function ListarContactos($codProspecto){

        $consulta="select * from  contactos where baja='0' and codProspecto='$codProspecto' ";

        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return false;

            }else{

                return $db;

            }

        }

    }

    //------------------------------------------------------------------------------------------------------------

    function EditarInformacion($codProspecto, $nombreobra, $tipoobra, $direccion, $tamanoObra, $MontoOp, $reserva, $cantidadParq, $parqueo1, $parqueo2, $parqueo3, $parqueo4, $nroDpto, $montoReservaDpto, $montoReservaParq, $fechaCuota1, $plan){

        $consulta="update prospecto set tamanoObra='$tamanoObra', nombreObra='$nombreobra', codTipoObra='$tipoobra', direccionObra='$direccion', MontoOportunidad='$MontoOp',

        fechaReserva='$reserva', cantidadParqueo='$cantidadParq', parqueo1='$parqueo1', parqueo2='$parqueo2', parqueo3='$parqueo3', parqueo4='$parqueo4', nroDpto='$nroDpto', montoReservaDpto='$montoReservaDpto', montoReservaParq='$montoReservaParq', fechaPrimerCuota='$fechaCuota1', planPago='$plan'

        where codProspecto='$codProspecto' ";

        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return false;

            }else{

                return $db;

            }

        }

    }



        function AprobarReserva($codProspecto, $nombreobra, $tipoobra, $direccion, $tamanoObra, $MontoOp, $reserva){

        $consulta="UPDATE prospecto set tamanoObra='$tamanoObra', nombreObra='$nombreobra', codTipoObra='$tipoobra', direccionObra='$direccion', MontoOportunidad='$MontoOp',

        fechaReserva='$reserva', estadoReserva='1' where codProspecto='$codProspecto' ";

        $db = new MySQL();

        if ($db->Error()){

            $db->Kill();

            return false;

        }else{

            if (!$db->Query($consulta)){

                $db->Kill();

                return false;

            }else{

                return $db;

            }

        }

    }



    function getOficinaData($codOficina) {

        $db = new MySQL();



        if ($db->Error()) {

            $db->Kill();

            return false;

        } else {

            $data = 'SELECT * FROM oficina WHERE codOficina = \''.$codOficina.'\'';

            if ($db->HasRecords($data)) {

                $db->Query($data);

                return $db;

            } else {

                return false;

            }

        }

    }

    

        function TraerEjecutivos(){



        $consulta="SELECT Grupo.*, usuario.codUsuario,usuario.foto,persona.nombre,concat(persona.apePat,' ',persona.apeMat) as apellido,usuario.inicializado FROM usuario left join persona on usuario.codPersona = persona.codPersona inner join Horario on Horario.codUsuario=usuario.codUsuario inner join Grupo on Grupo.codGrupo=Horario.codGrupo where (CURRENT_TIME BETWEEN Grupo.PrimerTurnoEntrada and Grupo.PrimerTurnoSalida or CURRENT_TIME BETWEEN Grupo.SegundoTurnoEntrada and Grupo.SegundoTurnoSalida ) and Week(CURRENT_DATE)= Horario.semana AND Horario.codSalon=".$_SESSION['codSalon']." and usuario.codTipoUsuario=2 order by persona.apePat desc, persona.apeMat desc, persona.nombre desc";



        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $db->Query($consulta);

        $db->MoveFirst();

        $cont=0;

      

     

           while (! $db->EndOfSeek()) {

        

            $cont=$cont+1;

            $row = $db->Row();

            

            if($row->inicializado == null)

            {

                $tituloimagen='DESHABILITAR';

                $colorboton='primary';

            }

            else

            {

                $tituloimagen='HABILITAR';

                $colorboton='danger';

            }

                               echo '

               <div class="col-md-1">

     <div><span onclick="CambiarEstadoEjecutivo('.$row->codUsuario.','.$row->inicializado.');" ><img title="'.$tituloimagen.'" src="../dist/img/'.$row->foto.'" width="100%" style="cursor:pointer;"></span>

     <button type="button" title="'.$tituloimagen.'" class="btn btn-flat btn-'.$colorboton.' col-md-12 col-sm-12" onClick="CambiarEstadoEjecutivo('.$row->codUsuario.','.$row->inicializado.');" style="cursor:pointer;"> <p style="line-height: 0.5; font-size: 10px">'.$row->nombre.'</p><p style="line-height: 0.5; font-size: 10px">'.$row->apellido.'</p></button>



      </div>

</div>

            ';

        }





      

    }



    function CambiarEstadoEjecutivo($codigoUsuario,$estadoUsuario) {

        $db = new MySQL();



        if ($db->Error()) {

            $db->Kill();

            return false;

        } else {

            if($estadoUsuario==1)

            {

                 $data = 'UPDATE usuario set inicializado= 1 where codUsuario='.$codigoUsuario.'';

            }

            else

            {

                $data = 'UPDATE usuario set inicializado= null where codUsuario='.$codigoUsuario.'';

            }

            if ($db->Query($data)) {

                echo 'ok';

            } else {

                echo 'error';

            }

        }

    }







    function NuevaSemana($semana) {

        $db = new MySQL();

        if ($db->Error()) {

            $db->Kill();

            echo 'error bd';

        } else {

            

            $consulta="select * from Horario where semana =".$semana."";

                                    

                                    $db->Query($consulta);

                                    if($db->RowCount()>0)

                                    {

                                            echo 'hay';

                                    }

                                    else

                                    {   



                                        function InsertarSemEje($usuario,$sem)

                                        {

                                            $db2 = new MySQL();

                                             $consulta2="INSERT into Horario (codUsuario,semana) values (".$usuario.",".$sem.")";

                                             $db2->Query($consulta2);

                                        }

                                         $consulta="select * from usuario where codTipoUsuario=2";

                                         $db->Query($consulta);

                                         $db->MoveFirst();

                                         



                                            while (! $db->EndOfSeek()) {

                                            $row = $db->Row();

                                            InsertarSemEje($row->codUsuario,$semana);

                                            

                                           }

                                           

                                        echo $cont;



                                      

                                    }

        }

    }















    function TraerEjecutivosDisponibles($semana){



        $consulta="SELECT * FROM usuario left join Horario on Horario.codUsuario=usuario.codUsuario where Horario.semana=".$semana." and Horario.codGrupo is null";



        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $db->Query($consulta);

        $db->MoveFirst();

        $cont=0;

                     $respuesta='';

   



     

           while (! $db->EndOfSeek()) {



            $row = $db->Row();

            

                               $respuesta=$respuesta.'<option value='.$row->codUsuario.'>'.$row->usuario.'</option>';

        }

        $respuesta= $respuesta.'';

        echo $respuesta;

      

    }





        function TraerGrupo($codSalon){



        $consulta="SELECT * FROM Grupo where codSalon=".$codSalon."";



        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $db->Query($consulta);

        $db->MoveFirst();

        $cont=0;

                     $respuesta='';

   



     

           while (! $db->EndOfSeek()) {



            $row = $db->Row();

            

                               $respuesta=$respuesta.'<option value='.$row->codGrupo.'>'.$row->Grupo.'</option>';

        }

        $respuesta= $respuesta.'';

        echo $respuesta;

      

    }



         function TraerSalon(){



        $consulta="SELECT * FROM Salon";



        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $db->Query($consulta);

        $db->MoveFirst();

        $cont=0;

                     $respuesta='<option>seleccionar..</option>';

   



     

           while (! $db->EndOfSeek()) {



            $row = $db->Row();

            

                               $respuesta=$respuesta.'<option value='.$row->codSalon.'>'.$row->nombre.'</option>';

        }

        $respuesta= $respuesta.'';

        echo $respuesta;

      

    }





      function AsignarHorarios($codUsuario,$grupo,$salon,$semana){

        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        else

        {

         

                    $consulta="UPDATE Horario set codGrupo=".$grupo.",codSalon=".$salon." WHERE codUsuario=". $codUsuario." and semana=".$semana.""; 

                    $db->Query($consulta);

         

        }





      

    }



          function Traertodo(){

        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        else

        {

         

                    $consulta="SELECT Horario.semana,usuario.codUsuario, concat(persona.nombre,' ',persona.apePat,' ',persona.apeMat) as nombre, Salon.nombre as salon,Grupo.Grupo from usuario inner join Horario on usuario.codUsuario=Horario.codUsuario inner join persona on usuario.codPersona = persona.codPersona inner join Grupo on Horario.codGrupo=Grupo.codGrupo inner join Salon on Grupo.codSalon=Salon.codSalon where Horario.codGrupo is not null and Horario.codSalon is not null order by Horario.semana asc, persona.apePat asc"; 

                    $db->Query($consulta);

                    return $db;

         

        }





      

    }





    function EliminarDelHorario($codUsuario,$semana){

        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        else

        {

         

                    $consulta="UPDATE Horario set codGrupo= null,codSalon=null WHERE codUsuario=". $codUsuario." and semana=".$semana.""; 

                    $db->Query($consulta);

         

        }





      

    }

    

    function obtenerAutomotor($codProspecto){

       $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

         $consulta="SELECT a.*, m.descripcion as marca, tv.nombre as tipoVehiculo, d.nombre as plaza, a.prima, a.valorComercial 

                    FROM automotor a

                    LEFT JOIN tipo tv on tv.codTipo= a.codTipoVehiculo

                    LEFT JOIN marca m on m.codMarca = a.codMarca 

                    LEFT JOIN departamento d on d.codDepto = a.codPlaza where a.codProspecto='$codProspecto' ";

        $db->Query($consulta);

        // si existe la forma de pago

            $db->MoveFirst();

         return $db->Row();

            

      

    }



    function obtenerMultiriesgo($codProspecto)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT mr.*, d.nombre as dpto, CASE WHEN mr.area= 1 then 'CIUDAD' WHEN mr.area=2 THEN 'RURAL' END as DescArea,

                    CASE WHEN mr.tipoInmueble=1 then 'CASA' WHEN mr.tipoInmueble=2 then 'DEPARTAMENTO' END AS inmueble, 

                    CASE WHEn mr.modalidadVivienda = 1 THEN 'ALQUILER' WHEN mr.modalidadVivienda=2 THEN 'ANTICRETICO' WHEN mr.modalidadVivienda = 3 THEN 'PROPIA' end as modalidad

                    FROM multiriesgo mr

                    LEFT JOIN departamento d on d.codDepto = mr.codDepartamento where mr.codProspecto='$codProspecto' ";

        $db->Query($consulta);

        // si existe la forma de pago

            $db->MoveFirst();

         return $db->Row();

    }





     function obtenerVida($codProspecto)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT v.*, d.valor, s.descripcion as seguro, case WHEN v.genero='M' THEN 'MASCULINO' WHEN v.genero='F' THEN 'FEMENINO' end as gen

                    FROM vida v

                    LEFT JOIN duracion_seguro d on d.codDuracionSeguro = v.codDuracionSeguro 

                    LEFT JOIN tipo_seguro s on s.codTipoSeguro= v.codTipoSeguro

                     where v.codProspecto='$codProspecto' ";

        $db->Query($consulta);

        // si existe la forma de pago

            $db->MoveFirst();

         return $db->Row();

    }

   function obtenerDetalleVida($codProspecto)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT v.*, d.valor, s.descripcion as seguro, case WHEN v.genero='M' THEN 'MASCULINO' WHEN v.genero='F' THEN 'FEMENINO' end as gen

                    FROM vida v

                    LEFT JOIN duracion_seguro d on d.codDuracionSeguro = v.codDuracionSeguro 

                    LEFT JOIN tipo_seguro s on s.codTipoSeguro= v.codTipoSeguro

                     where v.codProspecto='$codProspecto' ";

        $db->Query($consulta);

        // si existe la forma de pago

           

         return $db;

    }







     function obtenerDetalleProductos($codProspecto)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT l.nombre as linea, r.nombre as ramo,pro.nombre as producto, p.*, pro.geo, ar.codArchivo,p.latitud as lati, p.estado, p.primaFinal,case when p.estado=0 then 'Poliza Emitida' when p.estado=1 then 'Venta Caida' when p.estado is null then 'En Proceso' end as elestadoproducto

        from producto_detalle p 

        left join lineaNegocio l on p.codLinea = l.codLinea 

        left join ramo r on p.codRamo=r.codRamo 

        left join producto pro on p.codProducto=pro.codProducto 

        LEFT JOIN archivos ar on ar.codProspecto=p.codProductoDetalle where p.codProspecto='$codProspecto' GROUP by p.codProductoDetalle";

        $db->Query($consulta);

        // si existe la forma de pago

           

         return $db;

    }





    function VerificarDocumentos($codProspecto)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT * FROM archivos left join producto_detalle on archivos.codProspecto=producto_detalle.codProductoDetalle left join prospecto on prospecto.codProspecto=producto_detalle.codProspecto where prospecto.codProspecto='$codProspecto'";

        $db->Query($consulta);

        // si existe la forma de pago

        if ($db->RowCount()>0) {

            return true;

        }

        else

        {

            return false;

        }

           

         

    }  



  function obtenerDetalleProductosUsuario($usuario)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT l.nombre as linea, r.nombre as ramo,pro.nombre as producto, p.* 

                        from producto_detalle p 

                        left join lineaNegocio l on p.codLinea = l.codLinea 

                        left join ramo r on p.codRamo=r.codRamo 

                        left join producto pro on p.codProducto=pro.codProducto 

                        LEFT JOIN prospecto pros on pros.codProspecto= p.codProspecto

                        LEFT JOIN usuario u on u.codUsuario=pros.codUsuario

                        where pros.codUsuario='$usuario'";

        $db->Query($consulta);

        // si existe la forma de pago

           

         return $db;

    } 



 function obtenerTotalProspectos($usuario)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT COUNT(*) as TotalProspectos FROM prospecto 

                   WHERE prospecto.codUsuario='$usuario'";

        $db->Query($consulta);

        // si existe la forma de pago

          $db->MoveFirst();

         return $db->Row();

    } 





    function obtenerProductoAP($codProspecto)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT p.*, a.descripcion as actividad FROM producto_ap p

                    LEFT JOIN actividad a on a.codActividad=p.codActividad

                    where p.codProspecto='$codProspecto' ";

        $db->Query($consulta);

        // si existe la forma de pago

            $db->MoveFirst();

         return $db->Row();

    }



   function obtenerRiesgo($codresumida)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT * FROM actividad_resumida WHERE codActividadResumida='$codresumida'";

        $db->Query($consulta);

        // si existe la forma de pago

            $db->MoveFirst();

         return $db->Row();

    }





    function obtenerCodActividadResumida($codActividad)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT * FROM actividad WHERE codActividad='$codActividad'";

        $db->Query($consulta);

        // si existe la forma de pago

            $db->MoveFirst();

         return $db->Row();

    }



    function ObtenerCorreoNivel2($codSalon)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT per.correo from usuario u left join persona per on per.codPersona=u.codPersona where u.codSalon='$codSalon' and u.codTipoUsuario in (3) ";

        $db->Query($consulta);

        $db->MoveFirst();

        $resultado=$db->Row();

         return $resultado->correo;

    }

      function ObtenerCorreoNivel3($codOfi)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT per.correo from usuario u left join persona per on per.codPersona=u.codPersona where u.codOficina='$codOfi' and u.codTipoUsuario in (4) ";

        $db->Query($consulta);

        $db->MoveFirst();

        $resultado=$db->Row();

         return $resultado->correo;

    }

      function ObtenerCorreoNivel4($codSalon)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT per.correo from usuario u left join persona per on per.codPersona=u.codPersona where u.codTipoUsuario in (5) ";

        $db->Query($consulta);

        $db->MoveFirst();

        $resultado=$db->Row();

         return $resultado->correo;

    }







 function obtenerDetalleAP($codProspecto)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT p.*, a.descripcion as actividad, r.descripcion as resumida, r.nivelRiesgo FROM producto_ap p

                    LEFT JOIN actividad a on a.codActividad=p.codActividad

                    LEFT JOIN actividad_resumida r on r.codActividadResumida= p.codActividadResumida 

                    where p.codProspecto='$codProspecto' ";

        $db->Query($consulta);

        // si existe la forma de pago

         

         return $db;

    }







    function obtenerCantidadProductos($codProspecto)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT count(p.codProductoDetalle) as cantidad FROM producto_detalle p

                    where p.codProspecto='$codProspecto' ";

        $db->Query($consulta);

        $db->MoveFirst();

        $resultado=$db->Row();

         return $resultado->cantidad;

    }

    function editarAutomotor($codProspecto, $tipoVehiculo, $valorComercial, $prima, $marca, $plaza, $codUsuario){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

        $consulta=" select * from automotor  where codProspecto=$codProspecto ";

        $db->Query($consulta);

        // si existe la forma de pago

        if ($db->RowCount()>0){

            $db->MoveFirst();

            $dato=$db->Row();

            

            $consulta="update automotor set codTipoVehiculo='$tipoVehiculo', valorComercial='$valorComercial', prima='$prima', codMarca='$marca', 

                       codPlaza='$plaza', codUsuario='$codUsuario', fechaModificacion=SYSDATE()  where codProspecto = '$codProspecto'";

            if (! $db->Query($consulta)){

                return false;

            }

        }else{

            $consulta="insert into automotor(codProspecto, codTipoVehiculo, valorComercial, prima, codMarca, codPlaza, baja, codUsuario, fechaModificacion) 

                       values ('$codProspecto', '$tipoVehiculo', '$valorComercial', '$prima', '$marca', '$plaza', '0', '$codUsuario', SYSDATE())";

                        if (! $db->Query($consulta)){

                            $success = false;

                        }

                        return true;

        }

        return true;   

    }

     function editarMultiriesgo($codProspecto, $valor, $codDpto, $area, $direccion, $zona, $latitud, $longitud, $inmueble, $modalidad, $prima, $codUsuario){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

        $consulta=" select * from multiriesgo  where codProspecto=$codProspecto ";

        $db->Query($consulta);

        // si existe la forma de pago

        if ($db->RowCount()>0){

            $db->MoveFirst();

            $dato=$db->Row();

           

            $consulta="update multiriesgo set valorAsegurado='$valor', codDepartamento='$codDpto',

                       area='$area', direccion='$direccion', zona='$zona', latitud='$latitud', longitud='$longitud', tipoInmueble='$inmueble',

                       modalidadVivienda='$modalidad', prima='$prima', codUsuario='$codUsuario', fechaModificacion=SYSDATE()  where codProspecto = '$codProspecto'";

            if (! $db->Query($consulta)){

                return false;

            }

        }else{

            $consulta="insert into multiriesgo(codProspecto, valorAsegurado, codDepartamento,area, direccion, zona, latitud, longitud, tipoInmueble, modalidadVivienda, prima, codUsuario, baja, fechaModificacion) 

                       values ('$codProspecto', '$valor', '$codDpto', '$area', '$direccion', '$zona', '$latitud', '$longitud','$inmueble',

                       '$modalidad','$prima', '$codUsuario', '0', SYSDATE())";

                        if (! $db->Query($consulta)){

                            $success = false;

                        }

                        return true;

        }

        return true;   

    }



    function editarVida($codProspecto, $personas,$capital, $duracion, $nombre, $genero, $tipoSeguro, $fecNacimiento, $prima, $codUsuario, $codVida){

        // Creo una nueva conexion



        if ($nombre == "") {

            return "nada";

        }

        else

        {

                $db= new MySQL();

                if ($db->Error()){

                    $db->Kill();

                    return "0";

                }

                

                $consulta="select * from vida  where codProspecto=$codProspecto and codVida='$codVida' ";

                $db->Query($consulta);

                // si existe un seguro de vida

                if ($db->RowCount()>0){

                    $db->MoveFirst();

                    $dato=$db->Row();

                   

                    $consulta="update vida set cantidadPersonas='$personas', capAsegurado='$capital', codDuracionSeguro='$duracion', nombre='$nombre', genero='$genero',

                    codTipoSeguro='$tipoSeguro', fechaNacimiento='$fecNacimiento', prima='$prima', baja='0', fechaModificacion=SYSDATE() , controlUpdate=1 where codProspecto = '$codProspecto' and codVida='$codVida'";

                    if (! $db->Query($consulta)){

                        return false;

                    }

                }else{

                    $consulta="insert into vida(codProspecto, cantidadPersonas, capAsegurado, codDuracionSeguro, nombre, genero, codTipoSeguro, fechaNacimiento , prima, baja, codUsuario, fechaModificacion, controlUpdate) 

                               values ('$codProspecto', '$personas','$capital', '$duracion', '$nombre', '$genero', '$tipoSeguro', '$fecNacimiento', '$prima','0',

                               '$codUsuario', SYSDATE(), 1)";

                                if (! $db->Query($consulta)){

                                    $success = false;

                                }

                                return true;

               }

                return true;   



    }



}

function ActualizarCantidadPersonasVida($cantPersonas, $codProspecto){

     $db= new MySQL();

                if ($db->Error()){

                    $db->Kill();

                    return "0";

                }



                $consult="DELETE FROM vida where codProspecto= '$codProspecto' and controlUpdate=0";

                  $db->Query($consult);



                  $consul="select count(codVida) as cantidad from vida where codProspecto= '$codProspecto'";

                  $db->Query($consul);

                  $db->MoveFirst();

                  $total=$db->Row();

                   

                    $consulta="update vida set cantidadPersonas=".$total->cantidad." where codProspecto = '$codProspecto'";

                    if (! $db->Query($consulta)){

                        return false;

                    }

    return true;

}

function ActualizarCantidadPersonasAP($cantPersonas, $codProspecto){

     $db= new MySQL();

                if ($db->Error()){

                    $db->Kill();

                    return "0";

                }

                 $consult="DELETE FROM producto_ap where codProspecto= '$codProspecto' and controlUpdate=0";

                  $db->Query($consult);



                  $consul="select count(codAP) as cantidad from producto_ap where codProspecto= '$codProspecto'";

                  $db->Query($consul);

                  $db->MoveFirst();

                  $total=$db->Row();

                   

                    $consulta="update producto_ap set cantidadPersonas=".$total->cantidad." where codProspecto = '$codProspecto'";

                    if (! $db->Query($consulta)){

                        return false;

                    }



    return true;

}





function ActualizarCantidadPersonasProductos($codProspecto){

     $db= new MySQL();

                if ($db->Error()){

                    $db->Kill();

                    return "0";

                }

                 $consult="DELETE FROM producto_detalle where codProspecto= '$codProspecto' and controlUpdate=0";

                  $db->Query($consult);



                  $consul="select count(codProductoDetalle) as cantidad from producto_detalle where codProspecto= '$codProspecto'";

                  $db->Query($consul);

                  $db->MoveFirst();

                  $total=$db->Row();

                   

                    $consulta="update producto_detalle set cantidadRegistros=".$total->cantidad." where codProspecto = '$codProspecto'";

                    if (! $db->Query($consulta)){

                        return false;

                    }



    return true;

}



function guardarGeoProducto($codDetalle, $latitud, $longitud){

     $db= new MySQL();

                if ($db->Error()){

                    $db->Kill();

                    return "0";

                }

                    $consulta="update producto_detalle set latitud='$latitud', longitud='$longitud' where codProductoDetalle='$codDetalle'";

                    if (! $db->Query($consulta)){

                        return false;

                    }



    return true;

}



function EliminarPersonasAP($codProspecto){

     $db= new MySQL();

                if ($db->Error()){

                    $db->Kill();

                    return "0";

                }

                  

                 

                   

                  

    return true;

}

     function editardatosAP($codProspecto, $personas, $capital, $actividad, $prima, $codUsuario, $codAP, $resumida){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

        if($capital != '' ){

             $consulta=" select * from producto_ap  where codProspecto=$codProspecto and codAP=$codAP";

        $db->Query($consulta);

        // si existe el AP

        if ($db->RowCount()>0){

            $db->MoveFirst();

            $dato=$db->Row();

           

            $consulta="update producto_ap set cantidadPersonas='$personas', controlUpdate=1, capitalAsegurado='$capital', codActividad='$actividad', prima='$prima', codActividadResumida='$resumida', fechaModificacion=SYSDATE()  where codProspecto = '$codProspecto' and codAP='$codAP'";

            if (! $db->Query($consulta)){

                return false;

            }

        }else{

            $consulta="insert into producto_ap(codProspecto, cantidadPersonas, capitalAsegurado, codActividad , prima,codUsuario, baja, fechaModificacion, codActividadResumida,controlUpdate) 

                       values ('$codProspecto', '$personas','$capital', '$actividad', '$prima', '$codUsuario', '0', SYSDATE(), '$resumida' , 1)";

                        if (! $db->Query($consulta)){

                            $success = false;

                        }

                        return true;

        }

        return true;   

        }

        else{

            return "nada";

        }



       

    }









      function EditarProducto($codProspecto, $codLinea,$codRamo,$codProducto,$cantidad,$valor,$prima,$codProductoDetalle){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

        if($codLinea != '' ){

             $consulta=" select * from producto_detalle  where codProspecto='$codProspecto' and codProductoDetalle='$codProductoDetalle'";

        $db->Query($consulta);

        // si existe el AP

        if ($db->RowCount()>0){

            $db->MoveFirst();

            $dato=$db->Row();

           

            $consulta="update producto_detalle set controlUpdate=1, codLinea='$codLinea', codRamo='$codRamo', codProducto='$codProducto', cantidad='$cantidad', valor='$valor', prima='$prima'  where codProspecto = '$codProspecto' and codProductoDetalle='$codProductoDetalle'";

            if (! $db->Query($consulta)){

                return false;

            }

        }else{

            $consulta="insert into producto_detalle(codProspecto, codLinea, codRamo , codProducto,cantidad, valor, prima, controlUpdate) 

                       values ('$codProspecto','$codLinea', '$codRamo', '$codProducto', '$cantidad', '$valor', '$prima', 1)";

                        if (! $db->Query($consulta)){

                            $success = false;

                        }

                        return true;

        }

        return true;   

        }

        else{

            return "nada";

        }



       

    }





         function PrepararUpdate($codProspecto){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

       

             $consulta="UPDATE producto_ap set controlUpdate=0  where codProspecto='$codProspecto' ";

            $db->Query($consulta);

       



       

    }







    function PrepararUpdateVida($codProspecto){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

       

             $consulta="UPDATE vida set controlUpdate=0  where codProspecto='$codProspecto' ";

            $db->Query($consulta);

       



       

    }







     function PrepararUpdateProductos($codProspecto){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

       

             $consulta="UPDATE producto_detalle set controlUpdate=0  where codProspecto='$codProspecto' ";

            $db->Query($consulta);

       



       

    }





    function VerificarExistencia($empresa,$control){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

        $consulta=" select * from cliente  where ci='$control' ";

        $db->Query($consulta);

       

        return $db;

    }





    function ObtenerDetalleRenovacion($codRenovacion){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

        $consulta=" SELECT usu.codUsuario,r.*,(select completado from seguimientoRenovacion where codRenovacion=$codRenovacion order by codSeguimiento desc limit 1) as completado,  (select codSeguimiento from seguimientoRenovacion where codRenovacion=$codRenovacion order by codSeguimiento desc limit 1) as codSeguimiento, DATEDIFF(date(r.finVigencia),CURRENT_DATE) as semaforo from renovacion r left join persona p on p.sapSlpCode=r.codigoIntermediario left join usuario usu on usu.codPersona=p.codPersona where r.codRenovacion='$codRenovacion'  ";

        $db->Query($consulta);

        $db->MoveFirst();

        $fila= $db->Row();

        return $fila;

    }



     function ListarRenovacion($codUsuario,$tipo,$oficina,$area,$vendedor,$estado){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



            $iUsuario = new Usuario();

            $iUsuario->RecuperarSesionCod($codUsuario);

            $perfil= $iUsuario->obtenerPerfil();

            $codOsiris= $iUsuario->obtenerOsiris();

            



            

                

            



             if (is_numeric($tipo)) {

            $condicion.=" and renovacion.codTipoRenovacion='$tipo' ";

            }

            if (is_numeric($oficina)) {

            $condicion.=" and usuario.codOficina='$oficina' ";

            }

            if (is_numeric($area)) {

            $condicion.=" and usuario.codSalon='$area' ";

            }

            if (is_numeric($vendedor)) {

            $condicion.=" and usuario.codUsuario='$vendedor' ";

            }

            if (is_numeric($estado)) {

            $condicion.=" and renovacion.codEstadoProspecto='$estado' ";

            }



        $consulta=" SELECT renovacion.* from renovacion left join persona on renovacion.codigoIntermediario = persona.sapSlpCode left join usuario on usuario.codPersona = persona.codPersona where 1=1 and renovacion.codEstadoProspecto in (1,2,3) $condicion group by renovacion.codRenovacion ";

        $db->Query($consulta);

        

        return $db;

    }





         function ListarPlanPagos($tipo,$oficina,$area,$vendedor){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



            



            

                

            



               if (is_numeric($tipo)) {

            $condicion.=" and produccion.codTipoRenovacion='$tipo' ";

            }

            if (is_numeric($oficina)) {

            $condicion.=" and usuario.codOficina='$oficina' ";

            }

            if (is_numeric($area)) {

            $condicion.=" and usuario.codSalon='$area' ";

            }

            if (is_numeric($vendedor)) {

            $condicion.=" and usuario.codUsuario='$vendedor' ";

            }

          

          



        $consulta=" SELECT produccion.* from produccion left join persona on persona.sapSlpCode=produccion.codigoIntermediario left join usuario on usuario.codPersona=persona.codPersona where 1=1 $condicion group by poliza  ";

        $db->Query($consulta);

        

        return $db;

    }





    function ActualizarGCPcliente($codProspecto,$codGCP,$codSecuenciaProspecto){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



           



        $consulta=" UPDATE prospecto set controlWS=1, codCliente= '".$codGCP."',codSecuenciaProspecto='".$codSecuenciaProspecto."' where codProspecto='".$codProspecto."' ";

        if($db->Query($consulta))

        {

            return "ok";

        }

        else

        {

            return "error al actualizar";

        }

        

        

    }





        function CerrarRenovacion($codRenovacion,$poliza,$prima,$certificado){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



           



        $consulta=" UPDATE renovacion set codEstadoProspecto= 2 where codRenovacion='".$codRenovacion."' ";

        $db->Query($consulta);

        $consulta2=" INSERT INTO cierre_renovacion (codRenovacion,poliza,prima,certificado) values ('".$codRenovacion."','".$poliza."','".$prima."','".$certificado."') ";

        $db->Query($consulta2);



        return "OK";

        

        

        

    }





     function CerrarDefinitivo($codProspecto,$observacion,$cerrador){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



           



        $consulta=" UPDATE prospecto set codEstadoProspecto= 2,observCompletados='$observacion',cerrador='$cerrador' where codProspecto='".$codProspecto."' ";

        $db->Query($consulta);

       



        return true;

        

        

        

    }



       function ListarOrigenesProspecto(){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



           



        $consulta=" SELECT * FROM origen_prospecto order by codOrigenProspecto asc";

        $db->Query($consulta);

       



        return $db;

        

        

        

    }



        function HabilitarOrigenProspecto($codOrigenProspecto){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



           



        $consulta=" UPDATE origen_prospecto set baja=0 where codOrigenProspecto='$codOrigenProspecto' ";

        $db->Query($consulta);

        

    }





        function DeshabilitarOrigenProspecto($codOrigenProspecto){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



           



        $consulta=" UPDATE origen_prospecto set baja=1 where codOrigenProspecto='$codOrigenProspecto' ";

        $db->Query($consulta);

        

    }







        function EditarOrigenProspecto($codOrigenProspecto,$descripcion,$tipoorigen){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        if ($tipoorigen=="si") {

         $consulta=" UPDATE origen_prospecto set descripcion='$descripcion',tipoorigen=1 where codOrigenProspecto='$codOrigenProspecto' ";

        }

        else

        {

           $consulta=" UPDATE origen_prospecto set descripcion='$descripcion',tipoorigen=null where codOrigenProspecto='$codOrigenProspecto' ";

        }



           



        

        $db->Query($consulta);

        

    }





     function CrearOrigenProspecto($descripcion,$tipoorigen){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        if ($tipoorigen=="si") {

         $consulta=" INSERT INTO origen_prospecto (descripcion,tipoorigen) values ('$descripcion',1) ";

        }

        else

        {

           $consulta=" INSERT INTO origen_prospecto (descripcion,tipoorigen) values ('$descripcion',null) ";

        }



           



        

        $db->Query($consulta);

        

    }





function verificarExistencia2($empresa, $nombre, $primerapellido, $telefono){

     $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        

        $condicion ='';

        if($empresa == 'si'){

            $condicion = " or prospecto.nombre='$nombre'";

             $case= " case when prospecto.telefono='$telefono' then 1 else 0 end as controlTelefono, case when prospecto.nombre='$nombre' then 1 else 0 end as controlNombre";





        }

        if($empresa =='no'){

            $condicion = " or (prospecto.PrimerNombre='$nombre' and prospecto.PrimerApellido='$primerapellido')";

            $case= " case when prospecto.telefono='$telefono' then 1 else 0 end as controlTelefono, case when (prospecto.PrimerNombre='$nombre' and prospecto.PrimerApellido = '$primerapellido' ) then 1 else 0 end as controlNombre";

        }



        $consulta="SELECT prospecto.codUsuario,prospecto.codProspecto,prospecto.codUsuario,concat(persona.nombre,' ',persona.apePat,' ',persona.apeMat) as ejecutivo, $case from prospecto left join usuario on prospecto.codUsuario=usuario.codUsuario left join persona on persona.codPersona = usuario.codPersona where  prospecto.telefono='$telefono' $condicion  ";

        $db->Query($consulta);

       

        return $db;

}







  function CrearSolicitudReasignacion($codProspecto,$codUsuario){



       $condicion="";        

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



            $consulta="SELECT * FROM solicitud_reasignacion where codProspecto='$codProspecto' and estado = 0 ";

            $db->Query($consulta);

                 if ($db->RowCount()>0) 

                {

                    $consulta=" UPDATE solicitud_reasignacion set codSolicitante='$codUsuario' where codProspecto='$codProspecto' and estado=0 ";

                            $db->Query($consulta);  

                }

                else

                {

                     $consulta=" INSERT INTO solicitud_reasignacion (codProspecto,codSolicitante) values ('$codProspecto','$codUsuario') ";

                     $db->Query($consulta);            

                }    

      

        

        

    }




     function TraerDetallePlanPago($certificado,$poliza)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT *,case when fechaPago < '1990-01-01' then '' else fechaPago end as fechaPago2 FROM planPago where poliza='".$poliza."' and certificado='".$certificado."' union all SELECT *,case when fechaPago < '1990-01-01' then '' else fechaPago end as fechaPago2 FROM planPagoPendiente where poliza='".$poliza."' and certificado='".$certificado."' order by fechaVencimiento asc ";

        $db->Query($consulta);

      

           

         return $db;

    }

     function TraerCertificadosbyPoliza($poliza)

    {

         $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT certificado FROM planPago where poliza='".$poliza."' group by certificado";

        $db->Query($consulta);

      

           

         return $db;

    }



function ReaperturaDeProducto($codProductoDetalle){

     $db= new MySQL();

                if ($db->Error()){

                    $db->Kill();

                    return "0";

                }

                    $consulta="update producto_detalle set estado=NULL where codProductoDetalle='$codProductoDetalle'";

                    if (! $db->Query($consulta)){

                        return false;

                    }



    return true;

}



function NuevoProductoSeguri($codProspecto, $valor, $prima){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

        INSERT into producto_detalle (codProspecto,codLinea,codRamo,codProducto,valor,prima) values ('$codProspecto',2,9,49,'$valor','$prima')

        ";

        if (! $db->Query($consulta)){

            return false;

        }

        return true;

    }




    function Cuarentena($codProspecto, $codUsuario){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }


            $consulta="
        SELECT * FROM Cuarentena where codProspecto= '$codProspecto' and estado=0
        ";

        $db->Query($consulta);



        if ($db->RowCount() > 0 ){

            echo "<br>El prospecto ya se encuentra en espera de una reasignación:.<br> Póngase en contacto con su Gerente Regional.";

        }
        else
        {
                         $consulta2="

                INSERT into Cuarentena (codProspecto,codSolicitante,estado,fechaSolicitud) values ('$codProspecto','$codUsuario',0,SYSDATE())

                ";

                if (! $db->Query($consulta2)){

                   echo $db;

                }
                else
                {
                    echo 'OK';
                }

        }

     


   

       // return true;

    }




    function AceptarReasignacion($codCuarentena,$codProspecto, $codUsuario,$nota){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

        UPDATE Cuarentena set estado=1, observacion='$nota' where codCuarentena='$codCuarentena' and codProspecto='$codProspecto' 

        ";

        if (! $db->Query($consulta)){

            return false;

        }
        else
        {

            $consulta2="

        UPDATE prospecto set codPersona=codUsuario, codUsuario='$codUsuario' ,controlCuarentena=1  where codProspecto='$codProspecto'  

        ";

        if (! $db->Query($consulta2)){

            return false;

        }
             return true;
        }

         return true;
       

    }


    function RechazarReasignacion($codCuarentena,$codProspecto, $codUsuario,$nota){

        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }



        $consulta="

        UPDATE Cuarentena set estado=2 , observacion= '$nota' where codCuarentena='$codCuarentena' and codProspecto='$codProspecto' 

        ";

        if (! $db->Query($consulta)){

            return false;

        }
      

         return true;
       

    }






     function NuevoProductoLBCH($nombre,$correo,$telefono,$origen,$valorAsegurado,$primaTotal,$codUsuario){


 
            

        $consulta="insert into prospecto (primerNombre, email, telefono, codOrigenProspecto,fechaCreacion,esEmpresa,estado,codUsuario,codPersona,controlWS)

            values ('$nombre', '$correo', '$telefono', '$origen',SYSDATE(),0,1,'$codUsuario','$codUsuario',1 )

        ";



        // Creo una nueva conexion

        $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        // Habilito excepciones

        $db->ThrowExceptions = true;

        if (! $db->TransactionBegin()) $db->Kill();

        $success = true;

        $sql = $consulta;



        if (! $db->Query($sql)){

            $success = false;

        }

        // Si hizo todo bien

        if ($success) {

            $codProspecto=$db->GetLastInsertID();

            $this->NuevoSeguimiento($codProspecto,"SYSDATE()","1");

            if (! $db->TransactionEnd()) {

                $db->Kill();

            }
            if ($this->NuevoProductoSeguri($codProspecto,$valorAsegurado,$primaTotal)) {
                return true;    
            }
            else
            {
                return false;
            }
            

        } else {

            if (! $db->TransactionRollback()) {

                $db->Kill();

            }

        }

        return "0";






    }









}

?>

