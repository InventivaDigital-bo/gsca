<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/experiencia.css">
    <title>Chery Bolivia</title>
</head>
<body>
    @include('layouts.components.header')
    <main>
        <div class="title"><h1>EXPERIENCIA <span>CHERY</span></h1></div>
        <div class="cards">
            <div class="slideShow">
                <div class="card">
                <div class="portada"><img src="{{asset('assets/video/pcamara.jpg')}}" alt=""></div>
                <div class="contenido">
                    <div class="titulo"><h4>CÁMARA ESCONDIDA A CARLOS MARQUINA</h4></div>
                    {{-- <h6>8 de julio del 2021 / Autor</h6> --}}
                    <p>“DEL SUSTO A LA ALEGRÍA”…. Este jueves 19 de Agosto Carlos Marquina vivió una noche de emociones…. Pasaban las 20:30 hrs cuando grababan su programa de MOCO TV junto a Carlos Rocabado cuando al final de su programa se dan cuenta que le habían robado su auto…. Literalmente lo dejaron en toco y sin asientos.</p>
                    <div class="buttons"><a href="{{route('experienciaBlog', 'camara-escondida-a-carlos-marquina')}}" class="button">LEER MAS</a><a target="_blank" href="https://api.whatsapp.com/send/?phone&text=No te pierdas esta experiencia Chery: {{route('experienciaBlog', 'camara-escondida-a-carlos-marquina')}}" class="button secondary ">COMPARTIR</a></div>
                </div>
            </div>
            <div class="card">
                <div class="portada"><img src="{{asset('assets/video/pexpo.jpg')}}" alt=""></div>
                <div class="contenido">
                    <div class="titulo"><h4>CHERY BOLIVIA EN EXPOCRUZ 2021</h4></div>
                    {{-- <h6>8 de julio del 2021 / Autor</h6> --}}
                    <p>“DISEÑADO PARA EL FUTURO Y SU FAMILIA”…. Chery Bolivia esta presente en Expocruz 2021, mostrando a sus visitantes su tecnología de punta, elegancia, confort y seguridad para la familia boliviana.
                        Entre las más visitadas y deseadas, podemos destacar  la TIGOO 7 PRO con todas sus características:
                        </p>
                    <div class="buttons"><a href="{{route('experienciaBlog', 'chery-bolivia-expocruz-2021')}}" class="button">LEER MAS</a><a target="_blank" href="https://api.whatsapp.com/send/?phone&text=No te pierdas esta experiencia Chery: {{route('experienciaBlog', 'chery-bolivia-expocruz-2021')}}" class="button secondary ">COMPARTIR</a></div>
                </div>
            </div>
            <div class="card">
                <div class="portada"><img src="{{asset('assets/video/feria.jpg')}}" alt=""></div>
                <div class="contenido">
                    <div class="titulo"><h4>CHERY BOLIVIA EN LA FERIA SOBRE RUEDAS 2021</h4></div>
                    {{-- <h6>8 de julio del 2021 / Autor</h6> --}}
                    <p>“IMPACTANTE MOVIMIENTO”…. Chery Bolivia estuvo presente en la FERIA SOBRE RUEDAS 2021 en la ciudad de La Paz, sus visitantes pudieron ver el gran diseño en todos sus modelos</p>
                    <div class="buttons"><a href="{{route('experienciaBlog', 'chery-bolivia-en-la-feria-sobre-ruedas')}}" class="button">LEER MAS</a><a target="_blank" href="https://api.whatsapp.com/send/?phone&text=No te pierdas esta experiencia Chery: {{route('experienciaBlog', 'chery-bolivia-en-la-feria-sobre-ruedas')}}" class="button secondary ">COMPARTIR</a></div>
                </div>
            </div>
            </div>
            <div class="franja"></div>
        </div>
    </main>
    @include('layouts.components.footer')

    <div class="float-button"><a href="https://wa.link/xh0uqv"><img src="/assets/img/float-wpp.png" alt=""></a></div>
    <script src="https://kit.fontawesome.com/230beef275.js" crossorigin="anonymous"></script>
</body>
</html>
