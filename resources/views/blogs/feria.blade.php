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
                    <img style="height: 40rem; object-fit: cover" src="{{asset('assets/video/feria.jpg')}}">
                </div>
            </div>
            <div class="blog">
                <h2>CHERY BOLIVIA EN LA FERIA SOBRE RUEDAS 2021</h2>
                <div class="text">
                    <p>“IMPACTANTE MOVIMIENTO”…. Chery Bolivia estuvo presente en la FERIA SOBRE RUEDAS 2021 en la ciudad de La Paz, sus visitantes pudieron ver el gran diseño en todos sus modelos.
                        <br><br>
                        El mercado paceño sigue siendo uno de los más importantes del país, y junto a ello las exigencias del mercado y sus clientes. <br><br>
                        CHERY presentó todos sus modelos, en donde el público presente notó el gran diseño y modernidad que muestran los vehículos  TIGOO PRO FAMILY.

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
