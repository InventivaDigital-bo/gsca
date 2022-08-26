<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/header.css">
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P6TQ7C2');</script>
<!-- End Google Tag Manager -->
    <title>Chery Bolivia</title>

    @yield('css')

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6TQ7C2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <style>
        .loader {
            background: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10000;
        }
        .loader.hidden{
            display: none;
        }
        .car__body {
            animation: shake 0.2s ease-in-out infinite alternate;
        }
        .car__line {
            transform-origin: center right;
            stroke-dasharray: 22;
            animation: line 0.8s ease-in-out infinite;
            animation-fill-mode: both;
        }
        .car__line--top {
            animation-delay: 0s;
        }
        .car__line--middle {
            animation-delay: 0.2s;
        }
        .car__line--bottom {
            animation-delay: 0.4s;
        }
        @keyframes shake {
            0% {
                transform: translateY(-1%);
            }
            100% {
                transform: translateY(3%);
            }
        }
        @keyframes line {
            0% {
                stroke-dashoffset: 22;
            }
            25% {
                stroke-dashoffset: 22;
            }
            50% {
                stroke-dashoffset: 0;
            }
            51% {
                stroke-dashoffset: 0;
            }
            80% {
                stroke-dashoffset: -22;
            }
            100% {
                stroke-dashoffset: -22;
            }
        }
    </style>
    <div id="loader" class="loader">
        <svg class="car" width="102" height="40"  xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(2 1)" stroke="#C30010" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
                <path class="car__body" d="M47.293 2.375C52.927.792 54.017.805 54.017.805c2.613-.445 6.838-.337 9.42.237l8.381 1.863c2.59.576 6.164 2.606 7.98 4.531l6.348 6.732 6.245 1.877c3.098.508 5.609 3.431 5.609 6.507v4.206c0 .29-2.536 4.189-5.687 4.189H36.808c-2.655 0-4.34-2.1-3.688-4.67 0 0 3.71-19.944 14.173-23.902zM36.5 15.5h54.01" stroke-width="3"/>
                <ellipse class="car__wheel--left" stroke-width="3.2" fill="#FFF" cx="83.493" cy="30.25" rx="6.922" ry="6.808"/>
                <ellipse class="car__wheel--right" stroke-width="3.2" fill="#FFF" cx="46.511" cy="30.25" rx="6.922" ry="6.808"/>
                <path class="car__line car__line--top" d="M22.5 16.5H2.475" stroke-width="3"/>
                <path class="car__line car__line--middle" d="M20.5 23.5H.4755" stroke-width="3"/>
                <path class="car__line car__line--bottom" d="M25.5 9.5h-19" stroke-width="3"/>
            </g>
        </svg>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            document.getElementById('loader').classList.add('hidden');
        });

    </script>
    <header>
        <a href="{{route('index')}}" class="logo" style="padding-top: 0;"><img src="/assets/img/logo_2.jpg" alt=""></a>
        <div class="menu">
            <div class="top">
                <div class="border"></div>
                <div class="content">
                    <a href="{{route('concesionario')}}" class="buttom">
                        <img src="/assets/img/icon/i_concessionaire.png" alt="i_concessionaire">
                        <p>Concesionarios</p>
                    </a>
                    <a href="{{route('servicio')}}" class="buttom">
                        <img src="/assets/img/icon/i_service.png" alt="i_service">
                        <p>Servicio Técnico</p>
                    </a>
                </div>
            </div>
            <div class="bot">
                <a href="{{route('index')}}" class="button">
                    <p>INICIO</p>
                </a>
                <a href="{{route('chery')}}" class="button">
                    <p>POR QUÉ CHERY</p>
                </a>
                <li class="button active">
                    <p>MODELOS</p>
                    <ul>
                        <!--<li><a href="{{route('modelo', 'tiggo-2-confort')}}">TIGGO 2 CONFORT</a></li>
                        <li><a href="{{route('modelo', 'tiggo-2-pro')}}">TIGGO 2 PRO</a></li>
                        <li><a href="{{route('modelo', 'tiggo-4-20-pro')}}">TIGGO 4 PRO 2.0</a></li>-->
                       <li><a href="{{route('modelo', 'tiggo-2-pro')}}"> TIGGO 2 PRO</a></li>
                        <li><a href="{{route('modelo', 'tiggo-2-premium')}}">TIGGO 2 PREMIUM</a></li>
                        <li><a href="{{route('modelo', 'new-tiggo-4-15')}}">NEW TIGGO 4 PRO 1.5</a></li>
                        <li><a href="{{route('modelo', 'new-tiggo-4-20')}}">NEW TIGGO 4 PRO 2.0</a></li>
                        <li><a href="{{route('modelo', 'tiggo-7-pro')}}">TIGGO 7 PRO</a></li>
                    </ul>
                </li>
                <a href="{{route('experiencia')}}" class="button">
                    <p>EXPERIENCIA CHERY</p>
                </a>
                <a href="{{route('contacto')}}" class="button">
                    <p>CONTACTO</p>

                </a>
                <a href="{{route('tour', 'show-room')}}" class="button">
                    <p>TOUR VIRTUAL</p>
                </a>
            </div>
        </div>
    </header>
    @yield('content')

    @include('layouts.components.footer')

</body>

</html>
