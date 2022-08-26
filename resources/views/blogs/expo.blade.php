<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/blog.css">
    <title>Chery Bolivia</title>
</head>
<body>
    @include('layouts.components.header')
    <main>
        <div class="title"><h1>EXPERIENCIA <span>CHERY</span></h1></div>
        <div class="content">
            <div class="resource">
                <div class="video">
                    <video src="{{asset('assets/video/expo.mp4')}}" controls></video>
                </div>
            </div>
            <div class="blog">
                <h2>CHERY BOLIVIA EN EXPOCRUZ 2021</h2>
                <div class="text">
                    <p>“DISEÑADO PARA EL FUTURO Y SU FAMILIA”…. Chery Bolivia esta presente en Expocruz 2021, mostrando a sus visitantes su tecnología de punta, elegancia, confort y seguridad para la familia boliviana.
                        Entre las más visitadas y deseadas, podemos destacar  la TIGOO 7 PRO con todas sus características:
                    </p>
                    <ul>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Llave inteligente y comando a distancia </p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p> Alarma contra robo.</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Encendido a motor.</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>6 airbags frontales, laterales y de cortina.</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asistente de partida y descenso en pendiente.</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sistema de asistencia de frenado de emergencias.</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cámara HD 360.</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Climatizador automático en el interior.</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Apple Car Play + Android QD Link</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cooler enfriador de bebidas.</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Techo solar panorámico.</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Faroles delanteros con luz LED</p></li>
                        <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Reconocimiento de llave para el acceso.</p></li>
                    </ul>
                    <p><br> Por otra parte, las hermosas modelos estuvieron recibiendo al público junto a los ejecutivos comerciales brindando toda la información necesaria.
                       <br><br> “Expocruz 2021 viene siendo todo un éxito, y es una  alegría para nosotros ver como el público ha respondido ante este gran evento cruceño y boliviano”, fueron las palabras de Fernando Arrien, Gerente General de Chery Bolivia.

                    </p>

                </div>
            </div>
        </div>
    </main>
    @include('layouts.components.footer')

    <div class="float-button"><a href="https://wa.link/xh0uqv"><img src="/assets/img/float-wpp.png" alt=""></a></div>
    <script src="https://kit.fontawesome.com/230beef275.js" crossorigin="anonymous"></script>
</body>
</html>
