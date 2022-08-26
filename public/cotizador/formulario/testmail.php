<?php 
require_once ("../clases/PHPMailerAutoload.php");
require_once ("../clases/PHPMailer.php");
require_once ("../clases/SMTP.php");

$resultado= EnviarCorreoSMTP("jesandovalcab@gmail.com", "",'prueba correo smtp',"correo de prueba enviado desde http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
print_r($resultado);




 function EnviarCorreoSMTP($to, $copy="", $subject, $message){

        $Mail = new PHPMailer();
      $Mail->IsSMTP(); // Use SMTP
        $Mail->Host        = "smtp.gmail.com"; // Sets SMTP server
        $Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
        $Mail->SMTPAuth    = TRUE; // enable SMTP authentication
        $Mail->SMTPSecure  = "tls"; //Secure conection
        $Mail->Port        = 587; // set the SMTP port
        $Mail->Username    = 'spc_sistemas@grt.com.bo'; // SMTP account username
        $Mail->Password    = 'Rodaria2015!'; // SMTP account password
        $Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
        $Mail->CharSet     = 'UTF-8';
        $Mail->Encoding    = '8bit';
        $Mail->Subject     = $subject;
        $Mail->ContentType = 'text/html; charset=utf-8\r\n';
        $Mail->From        = 'spc_sistemas@grt.com.bo';
        $Mail->FromName    = 'SGC';
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
            return $Mail;
        }

    }

?>