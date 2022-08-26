<?php



require_once '../clases/mysql.class.php';

require_once '../clases/mail.php';



class AbmUsuario{



function obtenerUsuariosPersona($canal,$equipo,$ejecutivo){

    if ($canal!="") {
        $condicion=" and u.codOficina='$canal' ";
    }
    if ($equipo!="") {
        $condicion=" and u.codSalon='$equipo' ";
    }
    if ($ejecutivo!="") {
        $condicion=" and u.codUsuario='$ejecutivo' ";
    }

	$consulta="SELECT p.codPersona, u.codUsuario, concat(p.nombre,' ',p.apePat, ' ', p.apeMat) as nombre, u.usuario, u.cargo, t.NivelUsuarioLBC as tipo, o.descripcion as oficina,

				p.telefono, p.correo, u.baja as estado, s.descripcion as salon, p.sapSlpCode as osiris, u.codCiudad, d.nombre as ciudad

				FROM persona p

				LEFT JOIN usuario u on u.codPersona=p.codPersona

				LEFT JOIN tipousuario t on t.codTipoUsuario= u.codTipoUsuario

				LEFT JOIN oficina o on o.codOficina=u.codOficina

                LEFT JOIN Salon s on s.codSalon=u.codSalon

                LEFT JOIN departamento d on d.codDepto = u.codCiudad 

                WHERE u.codTipoUsuario != 1 $condicion

			    order by p.nombre asc";

		      $db= new MySQL();

			if ($db->Error()){

				$db->Kill();

				return "0";

			}



	        $db->Query($consulta);

			return $db;

}



function obtenerUsuario($codUsuario, $codPersona){

    $consulta="SELECT p.codPersona, u.codUsuario, p.nombre, p.apePat, p.apeMat, u.usuario, u.cargo,t.codTipoUsuario, t.descripcion as tipo, o.descripcion as oficina,

                u.codOficina, p.telefono, p.correo, u.baja as estado, u.foto,u.abm, s.descripcion as salon, p.sapSlpCode as osiris, u.codSalon, u.codCiudad

                FROM persona p

                INNER JOIN usuario u on u.codPersona=p.codPersona

                INNER JOIN tipousuario t on t.codTipoUsuario= u.codTipoUsuario

                INNER JOIN oficina o on o.codOficina=u.codOficina

                LEFT JOIN Salon s on s.codSalon=u.codSalon

                WHERE u.baja ='0' and p.codPersona='$codPersona' and codUsuario='$codUsuario'";

              $db= new MySQL();

            if ($db->Error()){

                $db->Kill();

                return "0";

            }



           $db->Query($consulta);

        $db->MoveFirst();

        return $db->Row();

}







function AgregarPersonaUsuario($nombre, $apPaterno, $apMaterno, $correo, $telefono, $usuario, $pass, $cargo, $tipo, $oficina,$esadministrador, $area, $osiris, $ciudad){



    if ($esadministrador=="si") {

        $controlABM=1;

    }

    else

    {

        $controlABM=0;

    }

     

     $data = $this->ValidarUsuario($usuario);

     if($data == 0){

         $consulta="insert into persona (nombre, apePat, apeMat, telefono, codPais, correo, baja, sapSlpCode) 

                    values('$nombre', '$apPaterno', '$apMaterno','$telefono','4', '$correo','0', '$osiris')";



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

            $codPersona=$db->GetLastInsertID();

            $valor= $this->NuevoUsuario($usuario, $pass, $cargo, $tipo, $oficina, $codPersona,$controlABM, $area, $ciudad);

            if (! $db->TransactionEnd()) {

                $db->Kill();

            }

            return $valor;

        } else {

            if (! $db->TransactionRollback()) {

                $db->Kill();

            }

        }

        return "0";

     }

     else {

        return "¡El nombre de usuario ya se encuentra registrado en el sistema, por favor verifique los datos!";

     }







	



}



function NuevoUsuario($usuario, $pass, $cargo, $tipo, $oficina, $codPersona,$controlABM, $area, $ciudad){

    $consulta="insert into usuario(usuario, contrasenha, codTipoUsuario, codCiudad, codOficina, codPersona, baja, cargo, codSalon, abm)

                values('$usuario', '$pass','$tipo','$ciudad', '$oficina','$codPersona', '0', '$cargo', '$area', '$controlABM')";



     $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $success = true;

        $sql = $consulta;



        if (!$db->Query($sql)){

            $success = false;

        }

         if ($success) {

            $codUsuario=$db->GetLastInsertID();

            return $codUsuario;

            }



        return "0";



}

 function editarPersonaUsuario($codPersona, $codUsuario, $nombre, $apPaterno, $apMaterno, $correo, $telefono, $usuario, $cargo, $tipo,  $oficina,$esadministrador, $area, $osiris, $ciudad){



    $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }







        if ($esadministrador=="si") {

        $controlABM=1;

    }

    else

    {

        $controlABM=0;

    }

 // $data = $this->ValidarUsuario($usuario);

   //  if($data == 0){



    $consulta ="update persona set nombre ='$nombre',

                                   apePat='$apPaterno',

                                   apeMat='$apMaterno',

                                   correo ='$correo',

                                   telefono ='$telefono',

                                   sapSlpCode ='$osiris'

                                    WHERE codPersona='$codPersona'";

      

        $success = true;

        if (!$db->Query($consulta)){

            $success = false;

        }



        $consulta2 ="update usuario set usuario='$usuario',

                                       cargo='$cargo',

                                       codTipoUsuario='$tipo',

                                       abm = '$controlABM',

                                       codCiudad = '$ciudad',

                                       codOficina='$oficina',

                                       codSalon='$area' WHERE codUsuario='$codUsuario'";

      

      if (!$db->Query($consulta2)){

            $success = false;

        }



        return $success;

    // }



    //  else {

    //     $success=false;

    //     return $success;

    //  }

 }



function deshabilitarUsuario($codUsuario, $estado){

     $consulta ="update usuario set baja='$estado' WHERE codUsuario='$codUsuario'";

      $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $success = true;

        $sql = $consulta;



        if (!$db->Query($sql)){

            $success = false;

        }





        return $success;



}

function restablecerPass($codUsuario, $nueva){

    $consulta= "update usuario set contrasenha='$nueva' WHERE codUsuario='$codUsuario'";

     $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $success = true;

        $sql = $consulta;



        if (!$db->Query($sql)){

            $success = false;

        }



        return $success;

}



function GuardarFotoUsuario($codUsuario, $foto){

    $consulta ="update usuario set foto='$foto' WHERE codUsuario='$codUsuario'";

      $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $success = true;

        $sql = $consulta;



        if (!$db->Query($sql)){

            $success = false;

        }

        



        return "0";



}







function obtenerImagen($codUsuario){

      $db= new MySQL();

        if ($db->Error()){

            $db->Kill();

            return "0";

        }

        $consulta="SELECT u.codUsuario, u.codPersona, u.foto as nombre from usuario WHERE u.codUsuario='$codUsuario'";





      $db->Query($consulta);

        $db->MoveFirst();

        return $db->Row();

}



 function ValidarUsuario($usuario=""){

        // $usuario=trim($usuario);

        

        // $usuario= str_replace(" ","%", $usuario);

        $condicion="";



        $consulta="SELECT p.codPersona, u.codUsuario, concat(p.nombre,' ',p.apePat, ' ', p.apeMat) as nombre, u.usuario, u.cargo, t.descripcion as tipo, o.descripcion as oficina,

                p.telefono, p.correo, u.baja as estado

                FROM persona p

                INNER JOIN usuario u on u.codPersona=p.codPersona

                INNER JOIN tipousuario t on t.codTipoUsuario= u.codTipoUsuario

                INNER JOIN oficina o on o.codOficina=u.codOficina

                WHERE u.usuario='$usuario' ";



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

          

            $cont=$cont+1;

            $row = $db->Row();

            return $cont;



        }

        if ($cont==0){

              return $cont;

        }



        return $cont;

        //echo "</table>";

    }







}

?>