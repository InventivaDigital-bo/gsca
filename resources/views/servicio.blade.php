<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/servicio.css">
    <title>Chery Bolivia</title>
</head>
<body>
    @include('layouts.components.header')
    <main>
        <section class="header">
            <div class="title"><h1>Servicio <span>Técnico</span></h1></div>
            <div class="options">
                <div class="text"><img src="assets/img/servicio/i_servicio.png" alt=""><p>Atención al cliente</p></div>
                <a href="#"><p>(591) 677-01700</p></a>
            </div>
        </section>
        <section class="locations">
            {{-- <div class="card">
                <div class="title"><h2>CASA MATRIZ</h2></div>
                <ul class="datas">
                    <li class="data">
                        <a href="#">
                            <img src="assets/img/servicio/i_location.png" alt="">
                            <p>Av. Centenario 4to anillo<br><span>TALLER AUTOPLAZA</span></p>
                        </a>
                    </li>
                    <li class="data">
                        <a target="_blank" href="https://api.whatsapp.com/send/?phone=59176578256&text=Hola Chery Bolivia">
                            <img src="assets/img/servicio/i_cellphone.png" alt="">
                            <p>(591) 765-78256</p>
                        </a>
                    </li>
                </ul>
            </div> --}}
            <div class="card">
                <div class="title"><h2>SANTA CRUZ</h2></div>
                <ul class="datas">
                    <li class="data">
                        <a href="#">
                            <img src="assets/img/servicio/i_location.png" alt="">
                            <p>Av. Grigotá 420 entre tercer y cuarto anillo</p>
                        </a>
                    </li>
                    <li class="data" style="display: flex; flex-direction: column; align-items: flex-start">
                        <a target="_blank" href="tel:33515002">
                            <p>
                                <img src="assets/img/servicio/i_cellphone.png" alt="">
                                <p>(591-3) 351-5002 int. 115 <br><br>
                            </p>
                        </a>
                        <a target="_blank" href="https://api.whatsapp.com/send/?phone=59172150096&text=Hola Chery Bolivia">
                            <p>
                                <img src="assets/img/servicio/i_cellphone.png" alt="">
                                (591) 721-50096 Servicio de Mantenimiento <br><br>
                            </p>
                        </a>
                        <a target="_blank" href="https://api.whatsapp.com/send/?phone=59172133245&text=Hola Chery Bolivia">
                            <p>
                                <img src="assets/img/servicio/i_cellphone.png" alt="">
                                (591) 721-33245 Venta de Repuestos
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="title"><h2>COCHABAMBA</h2></div>
                <ul class="datas">
                    <li class="data">
                        <a href="#">
                            <img src="assets/img/servicio/i_location.png" alt="">
                            <p>Av. Libertador Bolivar 1418<br><span>TALLER: Automundo Bolivia S.R.L.</span></p>
                        </a>
                    </li>
                    <li class="data">
                        <a target="_blank" href="https://api.whatsapp.com/send/?phone=59170758308&text=Hola Chery Bolivia">
                            <img src="assets/img/servicio/i_cellphone.png" alt="">
                            <p>(591) 4297001 <br><br>
                                (591) 707-58308
                            </p>
                        </a>
                    </li>
                    {{-- <li class="data">
                        <a href="#">
                            <img src="assets/img/servicio/i_location.png" alt="">
                            <p>Av. Grigotá 420 entre tercer y cuarto anillo</p>
                        </a>
                    </li> --}}
                </ul>
            </div>
            <div class="card">
                <div class="title"><h2>LA PAZ</h2></div>
                <ul class="datas">
                    <li class="data">
                        <a href="#">
                            <img src="assets/img/servicio/i_location.png" alt="">
                            <p><br><span>Taller de Gastón de Cota Cota</span></p>
                        </a>
                    </li>
                    <li class="data">
                        <a target="_blank" href="https://api.whatsapp.com/send/?phone=5912774477&text=Hola Chery Bolivia">
                            <img src="assets/img/servicio/i_cellphone.png" alt="">
                            <p>(591) 2110501 <br><br>
                                (591) 2774477
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="title"><h2>SUCRE</h2></div>
                <ul class="datas">
                    <li class="data">
                        <a href="#">
                            <img src="assets/img/servicio/i_location.png" alt="">
                            <p>Calle Eduardo Berdecio N°309<br><span>TALLER: Carro's Service</span></p>
                        </a>
                    </li>
                    <li class="data">
                        <a target="_blank" href="https://api.whatsapp.com/send/?phone=591703-12029&text=Hola Chery Bolivia">
                            <img src="assets/img/servicio/i_cellphone.png" alt="">
                            <p>(591) 6454926 <br><br>
                                (591) 703-12029
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="title"><h2>TARIJA</h2></div>
                <ul class="datas">
                    <li class="data">
                        <a href="#">
                            <img src="assets/img/servicio/i_location.png" alt="">
                            <p>Av. Héroes del Chaco<br><span>TALLER: Christian Magnan</span></p>
                        </a>
                    </li>
                    <li class="data">
                        <a target="_blank" href="https://api.whatsapp.com/send/?phone=59170312029&text=Hola Chery Bolivia">
                            <img src="assets/img/servicio/i_cellphone.png" alt="">
                            <p>(591) 6454926 <br><br>
                                (591) 703-12029
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            {{-- <div class="card">
                <div class="title"><h2>ORURO</h2></div>
                <ul class="datas">
                    <li class="data">
                        <a href="#">
                            <img src="assets/img/servicio/i_location.png" alt="">
                            <p>Calle Sucre #455 entre Potosí y 6 de Octubre<br><span>TALLER: Matisa Autos S.R.L.
                            </span></p>
                        </a>
                    </li>
                    <li class="data">
                        <a target="_blank" href="https://api.whatsapp.com/send/?phone=59170415175&text=Hola Chery Bolivia">
                            <img src="assets/img/servicio/i_cellphone.png" alt="">
                            <p>(591) 5280630<br><br>
                                (591) 704-15175
                            </p>
                        </a>
                    </li>
                </ul>
            </div> --}}
        </section>
    </main>
    @include('layouts.components.footer')
    <script src="https://kit.fontawesome.com/230beef275.js" crossorigin="anonymous"></script>

    <div class="float-button"><a href="https://wa.link/xh0uqv"><img src="/assets/img/float-wpp.png" alt=""></a></div>
</body>
</html>
