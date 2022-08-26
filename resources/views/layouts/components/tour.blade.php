<!DOCTYPE html>
<html>

<head>
  <title>Chery - Tour Virtual 360°</title>
  <meta charset="utf-8">
  <meta name="viewport"
    content="target-densitydpi=device-dpi, width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui" />
  <style>
    @-ms-viewport {
      width: device-width;
    }
  </style>
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
  <link rel="stylesheet" href="/vendor/reset.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/tour.css">
</head>

<body class="multiple-scenes ">
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
  <div id="pano"></div>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        document.getElementById('loader').classList.add('hidden');
    });

</script>
  <header>
    <div class="title">
      <div class="icon" onclick="menuToggle()"><img src="/assets/icons/i_burger.png" alt=""></div>
      <h1>Tour Virtual 360°</h1>
    </div>
    <a href="/" class="logo"><img src="/assets/logo4.png" alt=""></a>
    <div onclick="rotateToggle()" class="icon"><img src="/assets/icons/i_rotate.png" alt=""></div>
  </header>
  <div id="places" class="places"></div>
    <div id="sceneList">
      <ul class="scenes">
        @yield('list')


      </ul>
    </div>
  <section style="display: none;">

    <div id="titleBar">
      <h1 class="sceneName"></h1>
    </div>

    <a href="javascript:void(0)" id="autorotateToggle">
    </a>

    <a href="javascript:void(0)" id="fullscreenToggle">
    </a>

    <a href="javascript:void(0)" id="sceneListToggle">
    </a>

    <a href="javascript:void(0)" id="viewUp" class="viewControlButton viewControlButton-1">
    </a>
    <a href="javascript:void(0)" id="viewDown" class="viewControlButton viewControlButton-2">
    </a>
    <a href="javascript:void(0)" id="viewLeft" class="viewControlButton viewControlButton-3">
    </a>
    <a href="javascript:void(0)" id="viewRight" class="viewControlButton viewControlButton-4">
    </a>
    <a href="javascript:void(0)" id="viewIn" class="viewControlButton viewControlButton-5">
    </a>
    <a href="javascript:void(0)" id="viewOut" class="viewControlButton viewControlButton-6">
    </a>
  </section>

  <script>
    // self executing function here
    (function() {
        let spinner = document.getElementById("loader");
        // console.log(spinner)
        spinner.classList.toggle("hidden");
    })();
</script>

  <script src="/vendor/screenfull.min.js"></script>
  <script src="/vendor/bowser.min.js"></script>
  <script src="/vendor/marzipano.js"></script>
  @yield('data')
  <script src="/tour.js"></script>
  <script>
    menuToggle();
    function menuToggle(){
      document.getElementById("sceneList").classList.toggle("enabled");
    }
    function rotateToggle(){
      document.getElementById('autorotateToggle').click()
    }
  </script>

</body>

</html>
