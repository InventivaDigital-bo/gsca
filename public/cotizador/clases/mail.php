<?php

include_once ("../clases/mysql.class.php");
require_once ("../clases/prospecto.php");
require_once ("../clases/PHPMailerAutoload.php");
require_once ("../clases/PHPMailer.php");
require_once ("../clases/SMTP.php");

class Correo{
    public function PruebaCorreo(){
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $this->EnviarCorreoSMTP("jesandovalcab@gmail.com", "", "Prueba correo grt crm en ferrotodo ","Este correo se envia desde ferrotodo ".$actual_link);

    }
   
//envia correo al momento de sincronizar
        public function SincronizacionCliente(){
       
        // multiple recipients
        $to  = "esandoval@sm.grt.com.bo;erico@grt.com.bo;mloza@grt.com.bo;nvargas@sm.grt.com.bo;mferrufino@grt.com.bo";

        // subject
        $subject = 'Nueva Sincronización de Clientes: '.date('Y-m-d').'';

        // message
        $message = '
        <html>
        <head>
          <title>Nueva Sincronización</title>
        </head>
        <body>
          <h3>Estimados:</h3>
          <p>La sincronización diaria de clientes fue realizada exitosamente!.</p>
        <hr style="color:#666"/>
        <span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
        <h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Administracion Sistema Ferrotodo SGC  </h6>
        <h5 style="font-family:Tahoma, Geneva, sans-serif">Ferrotodo SGC  es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
        </body>
        </html>
        ';

        $this->EnviarCorreoSMTP($to, "", $subject, $message);
    }


        public function SincronizacionPrecios(){
       
        // multiple recipients
        $to  = "esandoval@sm.grt.com.bo;erico@grt.com.bo;mloza@grt.com.bo;nvargas@sm.grt.com.bo;mferrufino@grt.com.bo";

        // subject
        $subject = 'Nueva Sincronización de Precios: '.date('Y-m-d').'';

        // message
        $message = '
        <html>
        <head>
          <title>Nueva Sincronización</title>
        </head>
        <body>
          <h3>Estimados:</h3>
          <p>La sincronización diaria de precios fue realizada exitosamente!.</p>
        <hr style="color:#666"/>
        <span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
        <h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Administracion Sistema Ferrotodo SGC  </h6>
        <h5 style="font-family:Tahoma, Geneva, sans-serif">Ferrotodo SGC es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
        </body>
        </html>
        ';

        $this->EnviarCorreoSMTP($to, "", $subject, $message);
    }

    //----------------------------------------------------------------------------------------------------------------------------


    public function ProspectoReferencial($nombre,$ci,$ext,$telefono,$tipovendedor,$email,$nota,$correo,$nombreejecutivo)
    {
        
        // multiple recipients

        $elcorreodelusuario= $this->TraerCorreoUsuario($_SESSION['codigousuario']);

        $laextension="";
        if($ext==1)
        {
            $laextension="SC";
        }
        if($ext==2)
        {
            $laextension="LP";
        }
        if($ext==3)
        {
            $laextension="CB";
        }
        if($ext==4)
        {
            $laextension="PO";
        }
        if($ext==5)
        {
            $laextension="CH";
        }
        if($ext==6)
        {
            $laextension="BE";
        }
        if($ext==7)
        {
            $laextension="TJ";
        }
        if($ext==8)
        {
            $laextension="OR";
        }
        if($ext==9)
        {
            $laextension="PA";
        }
        if($ext==10)
        {
            $laextension="EX";
        }
        $to  = "esandoval@sm.grt.com.bo;mferrufino@grt.com.bo";
        //$to  = "esandoval@sm.grt.com.bo";
        // subject
        $subject = 'Nuevo Prospecto Referencial: '.$nombre.'';

        // message
        $message = '
        <html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.ReadMsgBody
 {width:100%}
.ExternalClass
 {width:100%}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div
 {line-height:100%}
a
 {color:#003399;
 text-decoration:underline}
body
 {margin:0}
-->
</style>

</head>
<body bgcolor="#000000" style="margin:0 auto">
    <table border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td height="10"></td>
            </tr>
        </tbody>
    </table>

    <table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#000000">
    <tbody>
    <tr>
    <td><center>
        <table border="0" cellspacing="0" cellpadding="0" width="600" bgcolor="#fdfdfd" style="border-bottom:6px solid #02AEF7">
        <tbody>
        <tr>
        <td>
            <img src="http://grt.com.bo/nsc/images/correonsc.png" id="headerImage" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext>
            <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="588" align="left">
                        <table border="0">
                        <tbody>
                            <tr>
                                <td width="439" align="left" style="color:#202020 ; font-family:calibri,arial,sans-serif; font-size:20px; padding:12px 0 0 12px">
                            <b>NUEVO PROSPECTO CREADO POR REFERENCIA</b></td>
                            </tr>
                        </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            </table>
        </td>
        </tr>
        </tbody>
        </table>
<table border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td height="1"></td>
            </tr>
        </tbody>
    </table>

        <table  cellspacing="0" cellpadding="0" width="600" bgcolor="#fdfdfd" >
        <tbody>
            <tr>
            <td valign="top" style="border-top:1px solid #dfdfdf; border-right:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; border-top:1px solid #37A1CF">
                <center>
                <table border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                <td valign="top">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td style="color:#414141; font-family:calibri,arial,sans-serif; font-size:14px; font-weight:bold; padding:17px 0 13px 17px">Estimado(a) '.$nombreejecutivo.',<br>Se asignó el siguiente prospecto que ha sido creado por referencia de '.$tipovendedor.' a su persona:</td>
                            </tr>
                            <tr>
                                <td style="color:#333; font-family:calibri,arial,sans-serif; font-size:18px; padding:0 0 17px 17px">
                                <div style="margin-bottom: 10px; margin-right: 20px; padding-top:5px; padding-bottom:5px; border: solid 1px #02AEF7; border-radius: 9px; ">
                                    <center>
                                    <table style="width:90%; font-size:14px">
                                        <tr><td style="font-weight:bold">Nombre:</td><td>'.$nombre.'</td></tr>
                                        <tr><td style="font-weight:bold">Cédula de Identidad:</td><td>'.$ci.' '.$laextension.'</td></tr>
                                        <tr><td style="font-weight:bold">Teléfono:</td><td>'.$telefono.'</td></tr>
                                        <tr><td style="font-weight:bold">Correo:</td><td>'.$email.'</td></tr>
                                       
                                        <tr><td style="font-weight:bold">Ejecutivo '.$tipovendedor.':</td><td>'.$_SESSION["nombre"].'</td></tr>
                                        <tr><td style="font-weight:bold">Nota:</td><td>'.$nota.'</td></tr>
                                        
                                        <tr><td style="font-weight:bold">Destinatarios(hasta activar los correos para determinar a quienes enviar):</td><td>-----------------------</td></tr>
                                        <tr><td style="font-weight:bold">correo ejecutivo asignado:</td><td>'.$correo.'</td></tr>
                                        <tr><td style="font-weight:bold">correo vendedor referencial:</td><td>'.$elcorreodelusuario.'</td></tr>
                                        

                                    </table>
                                    </center>
                                </div>
                                    <span style="font-size:13px; color:#666"></span></td>
                            </tr>
                        
                           

                        </tbody>
                    </table>
                </td>
                </tr>
                </tbody>
                </table>
                </center>
            </td>
            </tr>
            <tr>
                <td valign="top" style="border-top:1px solid #F4F4F4; border-right:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; padding:0 0 5px 17px; font-family: calibri,arial,sans-serif;
    font-size: 11px;">
                Notificacion de correo automático. Si tiene alguna duda con respecto al motivo de la recepción del correo, por favor consultar con su encargado de cuenta GRT.<br>
                <span style="display:block; text-align:right; padding-right:10px">Este sistema es un producto de <a href="http://www.grt.com.bo">GRT SRL</a>.</span>
                </td>
            </tr>
        </tbody>
        </table>
</center>
    </td>
    </tr>
    </tbody>
    </table>
</body>
</html>
        ';

        $this->EnviarCorreoSMTP($to, "", $subject, $message);
    }
    // Envia correo a los helpdesk avisando que se registro un nuevoincidente


    

     public function TraerCorreoUsuario($cod){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="
        SELECT per.correo from persona as per inner join usuario as usu on per.codPersona=usu.codPersona where usu.codUsuario= '".$cod."'
        ";
        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        $listado="";
        $coma="";
        while (! $db->EndOfSeek()) { 
            $row = $db->Row();
            //if (($row->correohelpdesk!="victor.mendoza@estancias-espiritu.com")&&($row->correohelpdesk!="peter.elsner@estancias-espiritu.com")){
                $listado=$row->correo;    
               
           // }           
        }
        return $listado;
    }


    public function NuevoIncidente($codincidente){
        $iIncidente= new incidente();
        $datos=$iIncidente->DetalleIncidentes($codincidente);
        // multiple recipients
        $to  = $this->ListadoHelpDesk();

        // subject
        $subject = 'Incidente '.$codincidente.' registrado';

        // message
        $message = '
		<html>
		<head>
		  <title>Nuevo incidente</title>
		</head>
		<body>
		  <h3>Estimados Helpdesk:</h3>
		  <p>Se registro un nuevo incidente que requiere de su atencion!</p>
		  <table style="border:none">
		  	<tr style="border:none">
				<td style="border:none">Nro Incidente:</td><td style="border:none"><b>'.$codincidente.'</b></td>
				<td style="border:none">Sistema afectado:</td><td style="border:none"><b>'.$datos->sistema.'</b></td>
			</tr>
			<tr style="border:none">
				<td colspan="3" style="border:none">fecha registro:</td><td><b>'.$datos->fecApertura.'</b></td>
			</tr>
			<tr style="border:none">
			<td colspan="4" style="border:none"><blockquote>'.$datos->descripcion.'</blockquote></td>
			</tr>
		  </table>
		<hr style="color:#666"/>
<span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
		<h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Administracion Sistema SAI  </h6>
		<h5 style="font-family:Tahoma, Geneva, sans-serif">SAI es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
		</body>
		</html>
		';

        $this->EnviarCorreoSMTP($to, "", $subject, $message);
    }

    //----------------------------------------------------------------------------------------------------------------------------
    // Envia correo a los soporte avisando que tienen un nuevo incidente asignado
    public function AsignacionIncidente($codincidente){
        $iIncidente= new incidente();
        $datos=$iIncidente->DetalleIncidentes($codincidente);

        $to=$this->ListadoCorreosSoporte($codincidente);
        $cc=$this->ListadoCorreosUsuario($codincidente);
        // subject
        $subject = 'Incidente asignado '.$codincidente;
        // message
        $message = '
		<html>
		<head>
		  <title>Asignacion incidente</title>
		</head>
		<body>
		  <h3>Estimado Soporte Estancias Espiritu:</h3>
		  <p>Se le asigno un nuevo incidente que requiere de su atencion!</p>
		  <table style="border:none">
		  	<tr style="border:none">
				<td style="border:none">Nro Incidente:</td><td style="border:none"><b>'.$codincidente.'</b></td>
				<td style="border:none">Sistema afectado:</td><td style="border:none"><b>'.$datos->sistema.'</b></td>
			</tr>
			<tr style="border:none">
				<td colspan="3" style="border:none">fecha registro:</td><td><b>'.$datos->fecApertura.'</b></td>
			</tr>
			<tr style="border:none">
			<td colspan="4" style="border:none"><blockquote>'.$datos->descripcion.'</blockquote></td>
			</tr>
		  </table>
		<hr style="color:#666"/>
<span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
		<h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Administracion Sistema SAI  </h6>
		<h5 style="font-family:Tahoma, Geneva, sans-serif">SAI es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
		</body>
		</html>
		';

        $this->EnviarCorreoSMTP($to, $cc, $subject, $message);

    }

    //----------------------------------------------------------------------------------------------------------------------------
    // Envia correo al usuario avisando que se ingreso una solucion
    public function Solucionado($codincidente){
        $iIncidente= new incidente();
        $datos=$iIncidente->DetalleIncidentes($codincidente);
        //----------------------------------------------------------
        $to=$this->ListadoHelpDesk();
        // subject
        $subject = 'Solucion ingresada para el incidente '.$codincidente;

        // message
        $message = '
		<html>
		<head>
		  <title>Solucion ingresada</title>
		</head>
		<body>
		  <h3>Estimado Help Desk</h3>
		  <p>Se ingreso una nueva solucion por favor verificar la correcta resolucion del incidente y proceder al cierre del mismo.</p>

		<table style="border:none">
		  	<tr style="border:none">
				<td style="border:none">Nro Incidente:</td><td style="border:none"><b>'.$codincidente.'</b></td>
				<td style="border:none">Sistema afectado:</td><td style="border:none"><b>'.$datos->sistema.'</b></td>
			</tr>
			<tr style="border:none">
				<td colspan="3" style="border:none">fecha registro:</td><td><b>'.$datos->fecApertura.'</b></td>
			</tr>
			<tr style="border:none">
			<td colspan="4" style="border:none"><blockquote>'.$datos->descripcion.'</blockquote></td>
			</tr>
		  </table>

		  <hr style="color:#666"/>

<span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
		<h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Administracion Sistema SAI  </h6>
		<h5 style="font-family:Tahoma, Geneva, sans-serif">SAI es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
		</body>
		</html>
		';

        $this->EnviarCorreoSMTP($to, "", $subject, $message);
    }

    //----------------------------------------------------------------------------------------------------------------------------

    public function Cierre($codincidente){
        $iIncidente= new incidente();
        $datos=$iIncidente->DetalleIncidentes($codincidente);

        $to=$this->ListadoCorreosSoporte($codincidente);
        $cc=$this->ListadoCorreosUsuario($codincidente);
        // subject
        $subject = 'Cierre de incidente '.$codincidente;

        // message
        $message = '
		<html>
		<head>
		  <title>Cierre de incidente</title>
		</head>
		<body>
		  <h3>Estimado Usuario:</h3>
		  <p>Nos es grato informarle que uno de sus incidentes regustrados ha sido resuelto por '.$datos->soporte.'.</p>

		<table style="border:none">
		  	<tr style="border:none">
				<td style="border:none">Nro Incidente:</td><td style="border:none"><b>'.$codincidente.'</b></td>
				<td style="border:none">Sistema afectado:</td><td style="border:none"><b>'.$datos->sistema.'</b></td>
			</tr>
			<tr style="border:none">
				<td colspan="3" style="border:none">fecha registro:</td><td><b>'.$datos->fecApertura.'</b></td>
			</tr>
			<tr style="border:none">
			<td colspan="4" style="border:none"><blockquote>'.$datos->descripcion.'</blockquote></td>
			</tr>
		  </table>

		  <hr style="color:#666"/>
<span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
		<h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Administracion Sistema SAI  </h6>
		<h5 style="font-family:Tahoma, Geneva, sans-serif">SAI es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
		</body>
		</html>
		';
        $this->EnviarCorreoSMTP($to, $cc, $subject, $message);
    }
    //----------------------------------------------------------------------------------------------------------------------------
    // Envia correo a los usuarios avisando que se registro una nueva cuenta
    public function NuevaCuenta($codusuario){
        date_default_timezone_set("America/La_Paz");
        $iUsuario= new usuario();
        $iUsuario->RecuperarSesion($codusuario);
        // multiple recipients
        $to  = $iUsuario->obtenerCorreo();

        // subject
        $subject = 'Nuevo usuario registrado ('.$codusuario.')';

        // message
        $message = '
		<html>
		<head>
		  <title>Nuevo usuario registrado</title>
		</head>
		<body>
		  <h3>Estimado usuario:</h3>
		  <p>Se le ha asignado una nueva cuenta de acceso al sistema SGC!</p>
		  <table style="border:none">
		  	<tr style="border:none">
				<td style="border:none">Usuario:</td><td style="border:none"><b>'.$iUsuario->obtenerUsuario().'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
				<td style="border:none">Contrase&ntilde;a:</td><td style="border:none"><b>'.$iUsuario->obtenerPassword().'</b></td>
			</tr>
			<tr style="border:none">
				<td colspan="3" style="border:none">fecha registro:</td><td><b>'.date('d/m/Y').'</b></td>
			</tr>
            <tr>
                <td colspan="3" style="border:none">Para ingresar al sistema:</td>
                <td>Haga clic <a href="#">AQUI</a>.</td>
            </tr>
		  </table>
		<hr style="color:#666"/>
<span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
		<h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Sistema de GRT  </h6>
		<h5 style="font-family:Tahoma, Geneva, sans-serif">Este sistema  es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
		</body>
		</html>
		';

        return $this->EnviarCorreoSMTP($to, "", $subject, $message);
    }
    //****************************************************************************************************
    //-----------------------------------------------------------------------------------
    public function ModificacionCuenta($codusuario){ // cod usuario numerico
        date_default_timezone_set("America/La_Paz");
        $iUsuario= new usuario();
        $iUsuario->RecuperarSesionCod($codusuario);
        // multiple recipients
        $to  = $iUsuario->obtenerCorreo();

        // subject
        $subject = 'Datos Usuario actualizados ('.$codusuario.')';
        // message
        $message = '
		<html>
		<head>
		  <title>Datos usuario actualizados</title>
		</head>
		<body>
		  <h3>Estimados usuario:</h3>
		  <p>Se ha asignado nuevos datos a su cuenta de usuario!</p>
		  <table style="border:none">
		  	<tr style="border:none">
				<td style="border:none">Usuario:</td><td style="border:none"><b>'.$iUsuario->obtenerUsuario().'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
				<td style="border:none">Contrase&ntilde;a:</td><td style="border:none"><b>'.$iUsuario->obtenerPassword().'</b></td>
			</tr>
			<tr style="border:none">
				<td colspan="3" style="border:none">fecha modificacion:</td><td><b>'.date('d/m/Y').'</b></td>
			</tr>
            </tr>
            <tr>
                <td colspan="3" style="border:none">Para ingresar al sistema:</td>
                <td>Haga clic <a href="#">AQUI</a>.</td>
            </tr>

		  </table>
		<hr style="color:#666"/>
<span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
		<h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Sistema de GRT   </h6>
		<h5 style="font-family:Tahoma, Geneva, sans-serif">Este sistema  es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
		</body>
		</html>
		';

        return $this->EnviarCorreoSMTP($to, "", $subject, $message);
    }
    //****************************************************************************************************
    public function ListadoHelpDesk(){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="
		SELECT per.correo as correohelpdesk
		FROM  usuario as usr
		left join persona as per on per.codPersona=usr.codPersona
		where codTipoUsuario=1 and usr.usuario!='pelsner' and usr.usuario!='vmendoza' and  usr.usuario!='admin'
		";
        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        $listado="";
        $coma="";
        while (! $db->EndOfSeek()) {
            $row = $db->Row();
            if (($row->correohelpdesk!="victor.mendoza@estancias-espiritu.com")&&($row->correohelpdesk!="peter.elsner@estancias-espiritu.com")){
                $listado=$listado.$coma." ".$row->correohelpdesk;
                $coma=",";
            }
        }
        return $listado;
    }
    //****************************************************************************************************
    public function ListadoCorreosSoporte($codincidente){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="
		select i.codIncidente, i.codUsuario, i.codSoporte, sop.correo as correosoporte, u.correo as correousuario
		from incidente as i
		left join soporte as s on s.codSoporte=i.codSoporte
		left join persona as sop on sop.codPersona=s.codPersona
		left join usuario as usr on usr.codUsuario=i.codUsuario
		left join persona as u on u.codPersona=usr.codPersona
		where i.codIncidente=".$codincidente;

        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        $listado="";
        $coma="";
        while (! $db->EndOfSeek()) {
            $row = $db->Row();

            $listado=$listado.$coma." ".$row->correosoporte;
            $coma=",";
        }
        return $listado;
    }
    //-----------------------------------------------------------------------------
    public function ListadoCorreosUsuario($codincidente){
        $db = new MySQL();
        if ($db->Error()) $db->Kill();
        $consulta="
		select i.codIncidente, i.codUsuario, i.codSoporte, sop.correo as correosoporte, u.correo as correousuario
		from incidente as i
		left join soporte as s on s.codSoporte=i.codSoporte
		left join persona as sop on sop.codPersona=s.codPersona
		left join usuario as usr on usr.codUsuario=i.codUsuario
		left join persona as u on u.codPersona=usr.codPersona
		where i.codIncidente=".$codincidente;

        if (! $db->Query($consulta)) $db->Kill();
        $db->MoveFirst();
        $listado="";
        $coma="";
        while (! $db->EndOfSeek()) {
            $row = $db->Row();

            $listado=$listado.$coma." ".$row->correousuario;
            $coma=",";
        }
        return $listado;
    }
    //-----------------------------------------------------------------
    //----------------------------------------------------------------------------------------------------------------------------
    // Envia correo a los OPERACIONES avisando que tienen solicitud de asignacion por aprobar

    
    //***********************************************************************
    function EnviarCorreoSMTP($to, $copy="", $subject, $message){

        $Mail = new PHPMailer();
        $Mail->IsSMTP(); // Use SMTP
        $Mail->Host        = "192.168.254.4"; // Sets SMTP server
        $Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
        $Mail->SMTPAuth    = TRUE; // enable SMTP authentication
        $Mail->SMTPSecure  = "tls"; //Secure conection
        $Mail->Port        = 25; // set the SMTP port
        $Mail->Username    = 'lbc\lbccrm'; // SMTP account username
        $Mail->Password    = 'crm2019#'; // SMTP account password
        $Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
        $Mail->CharSet     = 'UTF-8';
        $Mail->Encoding    = '8bit';
        $Mail->Subject     = $subject;
        $Mail->ContentType = 'text/html; charset=utf-8\r\n';
        $Mail->From        = 'Lbccrm@lbc.bo';
        $Mail->FromName    = 'SGC LBC';
        $Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
        $options = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        //$Mail->AddAddress( $to ); // To:
        $to=str_replace(",",";",$to);
        $addresses = explode(';',$to);
        foreach ($addresses as $address) {
            $Mail->AddAddress($address);
        }

        if ($copy!=""){
            $copy=str_replace(",",";",$copy);
            $addresses = explode(';',$copy);
            foreach ($addresses as $address) {
                $Mail->AddAddress($address);
            }
            //$Mail->AddAddress($copy);
        }
        $Mail->isHTML( TRUE );
        $Mail->Body    = $message;
        $Mail->AltBody = $message;

        // Se habilita SOLO en ambiente de pruebas
        //$Mail->smtpConnect($options);
        
        $algo=$Mail->Send();
        $Mail->SmtpClose();

        if ( $Mail->IsError() ) {
            return false;
        }else{
            return true;
        }

    }
   //************************************************************************************************************
    public function CorreoCierrePedido($codPedido, $destinatario, $copia, $codCli, $cliente, $fechaPedido, $formaPago, $total, $usuario, $observaciones)
    {
         $to=$destinatario;
         $to2=$copia;
        //$to="mloza@grt.com.bo; mferrufino@grt.com.bo; manuel.loza@outlook.com";
        // subject
        $subject = 'FERROTODO : Se cerró el pedido Nro.: '.$codPedido;

        if($formaPago==''){
            $formaPago='Sin definir';
        }
        // message
        $message = '
        <html>
        <body>
          <h3>Estimados:</h3>
          <p>Se ha registrado un nuevo cierre de pedido por: '.$usuario.'.</p>
          
            <table style="border:1">
            <tr>
                <td>Cod. Cliente: </td><td style="border:none"><b>'.$codCli.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
            </tr><tr>
                <td>Cliente: </td><td style="border:none"><b>'.$cliente.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
            </tr>
            <tr>
            <td >Total: </td><td style="border:none"><b>'.$total.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
            </tr><tr>
            <td >Forma de Pago: </td><td style="border:none"><b>'.$formaPago.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
            </tr>
            <tr>
                <td>Fecha Pedido: </td><td><b>'.$fechaPedido.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
            </tr>
              <tr>
                <td>Observaciones: </td><td><b>'.$observaciones.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
            </tr>
              <tr>
                <td colspan="3" style="border:none">Para Generar el arhivo PDF:</td>
                <td>Haga clic <a href="https://crm.ferrotodo.com/sgc/examples/pedidopdf.php?cod='.$codPedido.'">AQUI</a>.</td>
            </tr>

          </table>

          <hr style="color:#666"/>
        <span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
        <h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Administracion Sistema  </h6>
        <h5 style="font-family:Tahoma, Geneva, sans-serif">Este sistema es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
        </body>
        </html>
        ';
        $this->EnviarCorreoSMTP($to, $to2, $subject, $message);
        return true;
    }
    //--------------------------------------------------------------------------------------------------------------
    // Envia correo a los OPERACIONES avisando que tienen solicitud de asignacion por aprobar

    public function SolicitarAyuda($codProspecto, $destinatario, $copia, $mensaje,$nivel3,$nivel4,$nivel5,$nivel6){
      
        $to=$destinatario.';'.$copia.';'.$nivel3.';'.$nivel4.';'.$nivel5.';'.$nivel6;
        //$to="mloza@grt.com.bo; mferrufino@grt.com.bo; manuel.loza@outlook.com";
        // subject
        $subject = 'La Boliviana Ciacruz : Solicitud de ayuda cierre prospecto Nro. '.$codProspecto;
        // message
        $message = '
		<html>
		<body>
		  <h3>Estimados:</h3>
		  <p>Se ha registrado una nueva solicitud de ayuda para  el prospecto '.$codProspecto.'.</p>
          <p><b>'.$mensaje.'</b></p>
          <p>Por favor atender la solicitud y comunicar al ejecutivo comercial.</p>
		  <hr style="color:#666"/>
<span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
		<h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Administracion Sistema  </h6>
		<h5 style="font-family:Tahoma, Geneva, sans-serif">Este sistema es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
		</body>
		</html>
		';
        $this->EnviarCorreoSMTP($to, '', $subject, $message);
        return true;
    }


       public function SolicitarAyudaRenovacion($codProspecto, $destinatario, $copia, $mensaje,$nivel3,$nivel4,$nivel5,$nivel6){
        $to=$destinatario.';'.$copia.';'.$nivel3.';'.$nivel4.';'.$nivel5.';'.$nivel6;
        //$to="esandoval@sm.grt.com.bo; mferrufino@grt.com.bo; nvargas@sm.grt.com.bo";
        // subject
        $subject = 'La Boliviana Ciacruz : Solicitud de ayuda para colocar Renovación Nro. '.$codProspecto;
        // message
        $message = '
        <html>
        <body>
          <h3>Estimados:</h3>
          <p>Se ha registrado una nueva solicitud de ayuda para  la Renovación '.$codProspecto.'.</p>
          <p><b>'.$mensaje.'</b></p>
          <p>Por favor atender la solicitud y comunicar al ejecutivo comercial.</p>
          <hr style="color:#666"/>
<span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span>
        <h6 style="font-family:Tahoma, Geneva, sans-serif"> Atte. Administracion Sistema  </h6>
        <h5 style="font-family:Tahoma, Geneva, sans-serif">Este sistema es un producto de <a href="www.grt.com.bo" style="text-decoration:none">GRT srl</a>.</h5>
        </body>
        </html>
        ';
        $this->EnviarCorreoSMTP($to, '', $subject, $message);
        return true;
    }
    //*******************************************************************************************************
    function EnviarProforma($hdocumento, $correoto, $correocc, $adicional, $codvp){
        require_once "../clases/proforma.php";
        $iProforma= new Proforma();
        $registro=$iProforma->Cabecera($codvp);
        $nroprof=str_pad($registro->codProspecto, 5, "0", STR_PAD_LEFT).'/'.str_pad($registro->codVehiculoProspecto, 4, "0", STR_PAD_LEFT);
        $subject='Cotización (PROFORMA NRO '.$nroprof.'): '.$registro->modelo.' '.$registro->tipo.' '.$registro->marca.' ';
        $message='Estimado(a) Sr(a). '.$registro->nombre.'<br>';
        if($adicional!=""){
            $message.=$adicional.'<br>';
        }
        $message.='Adjunto encuentra la cotización del '.$registro->modelo.' '.$registro->tipo.' '.$registro->marca.'.<br>
Seguros de contar con su preferencia.<br><br>
Cualquier inquietud, estamos para atenderlos.
<hr style="color:#666"/>
<span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span> ';

        $file="";
        $from="SPC";
        return $this->EnviarCorreoSMTP2($correoto, $correocc, $subject, $message, $hdocumento, $from);

    }
    //**********************************************************************************************************
    function NuevoArchivo($vcod, $controlnofiat, $tipoarchivo){
        require_once "../clases/proforma.php";
        $subject='Nuevo documento cargado ';
        $message='Estimado(a) <br>';
        $message.='Se ha cargado un nuevo documento al prospecto Nro. '.$vcod.'.<br><br>
        El documento cargado es del tipo: <ul><li>'.$tipoarchivo.' </li></ul>
        El documento esta listo para su revision en sistema.
<hr style="color:#666"/>
<span style="font-size:12px; color:#666; font-family:Tahoma, Geneva, sans-serif">Este es un correo automatico, por favor no lo responda.</span> ';

        $file="";
        $from="SPC";
        return $this->EnviarCorreoSMTP($controlnofiat, "", $subject, $message);

    }
    //**********************************************************************************************************

    function EnviarCorreoSMTP2($to, $copy="", $subject, $message, $file="", $from=""){
        if ($from==""){
            $from="SGP";
        }

        $Mail = new PHPMailer();
        $Mail->IsSMTP(); // Use SMTP
        $Mail->Host        = "192.168.0.3"; // Sets SMTP server
        $Mail->SMTPDebug   = 1; // 2 to enable SMTP debug information
        $Mail->SMTPAuth    = false; // enable SMTP authentication
        $Mail->SMTPSecure  = false; //Secure conection
        $Mail->Port        = 25; // set the SMTP port
        $Mail->Username    = 'notificaciones@ferrotodo.com'; // SMTP account username
        $Mail->Password    = 'notificaciones#1133@14'; // SMTP account password
        $Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
        
        $Mail->CharSet     = 'UTF-8';
        $Mail->Encoding    = '8bit';
        $Mail->Subject     = $subject;
        $Mail->ContentType = 'text/html; charset=utf-8\r\n';
        $Mail->From        = 'Ferrotodo';
        $Mail->FromName    = $from;
        $Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
        $options = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $addresses = explode(';',$to);
        foreach ($addresses as $address) {
            $Mail->AddAddress($address);
        }

        if ($copy!=""){
            $addresses = explode(';',$copy);
            foreach ($addresses as $address){
                $Mail->AddAddress($address);
            }
        }

        $Mail->isHTML( TRUE );
        $Mail->Body    = $message;
        $Mail->AltBody = $message;

        if ($file!=""){
            $Mail->AddAttachment($file,"Proforma");      // attachment
        }
        // Se habilita SOLO en ambiente de pruebas
        //$Mail->smtpConnect($options);
        $algo=$Mail->Send();
        $Mail->SmtpClose();

        if ( $Mail->IsError() ) {
            return false;
        }else{
            return true;
        }

    }
}

?>
