<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/contacto.css">
    <title>Chery Bolivia</title>
</head>
<body>
    @include('layouts.components.header')
    <main>
        <section class="cabecera">
            <div class="title"><h2>Para más información de nuestros <br><span>productos y servicios</span></h2></div>
            <ul class="redes">
                <li><a href="#"><img src="assets/img/contacto/i_face.png" alt=""><p>@CheryBol</p></a></li>
                <li><a href="#"><img src="assets/img/contacto/i_instagram.png" alt=""><p>@CheryBol</p></a></li>
                <li><a href="#"><img src="assets/img/contacto/i_mail.png" alt=""><p>informaciones@gsca.com.bo</p></a></li>
                <li><a href="#"><img src="assets/img/contacto/i_wpp.png" alt=""><p>(591) 67701700</p></a></li>
            </ul>
        </section>
        <section class="form">
            <form action="#">
                <div class="group">
                    <div class="input-group"><label for="nombre">Nombre Completo</label><input type="text" placeholder="Nombre completo" id="nombre"></div>
                    <div class="input-group"><label for="telefono">Telefono</label><input type="text" placeholder="Telefono" id="telefono"></div>
                    <div class="input-group"><label for="correo">Correo</label><input type="text" placeholder="Correo" id="correo"></div>
                    <div class="input-group"><label for="carnet">Carnet de identidad</label><input type="text" placeholder="Carnet de identidad" id="carnet"></div>
                    <div class="input-group"><label for="horario">Horario para contactarnos</label><input type="text" placeholder="Horario para contactarnos" id="horario"></div>
                    <div class="input-group"><label for="ciudad">Ciudad de residencia</label><input type="text" placeholder="Ciudad de residencia" id="ciudad"></div>
                    <div class="input-group"><label for="contacto">¿Como te contactamos?</label><input type="text" placeholder="¿Como te contactamos?" id="contacto"></div>
                    <div class="input-group"><label for="ayuda">¿En que te podemos ayudar?</label><input type="text" placeholder="¿En que te podemos ayudar?" id="ayuda"></div>
                </div>
                <div class="btn"><button>Enviar</button></div>
            </form>
        </section>
    </main>
    @include('layouts.components.footer')
    <script src="https://kit.fontawesome.com/230beef275.js" crossorigin="anonymous"></script>

    <div class="float-button"><a href="https://wa.link/xh0uqv"><img src="/assets/img/float-wpp.png" alt=""></a></div>
</body>
</html>
