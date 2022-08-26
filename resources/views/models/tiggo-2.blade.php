@extends('layouts.principal')
@section('css')
    <link rel="stylesheet" href="/assets/css/modelo.css">
    <link rel="stylesheet" href="/assets/css/carrousel.css">

@endsection

@section('content')
@include('layouts.components.models', ['model'=>'2p'])
<section class="contents">
    @include('layouts.components.galery', ['model'=>'2p'])
    <div class="description">
        <div class="types">
            <a href="#" onclick="chageType('mt')" id="mt" class="active-type">MT</a>
            <a href="#" onclick="chageType('ctv')" id="ctv"  class="">CTV</a>
        </div>
        <div class="title">
            <div class="name"><h2>TIGGO</h2></div>
            <div class="version"><h2>2</h2></div>
            <div class="values">
                <h3>PRO</h3>
                <p>2023</p>
            </div>
        </div>
        <div class="prices">
            <div class="price">
                <h4>PRECIO DESDE</h4>
                <div class="arrow"><img src="/assets/img/modelos/arrow_rigth.png" alt="Flecha_derecha"></div>
                <p class="data">17.800<span>$us</span></p>
            </div>
            <div class="mensual">
                <h4>CUOTA MENSUAL</h4>
                <p class="data">265<span>$us</span></p>
            </div>
        </div>
        <div class="desc mt" id="txt">
            <p class="txt-mt"> Motor 1500cc, caja mecánica, AC, 2 airbags frontales,
                frenos ABS, control de audio al volante audio, radio +
                pantalla táctil de 7" + bluetoth + sistema mirror link +
                cámara de retro, aros de aleación</p>
            <p class="txt-ctv"> Motor 1500cc, caja mecánica, AC, 2 airbags frontales,
                frenos ABS, control de audio al volante audio, radio +
                pantalla táctil de 7" + bluetoth + sistema mirror link +
                cámara de retro, aros de aleación.</p>
        </div>
        <div class="certificate">
            <img src="/assets/img/modelos/certificate.png" alt="">
        </div>
    </div>
</section>
@include('layouts.components.colors', ['model' => '2p'])
@include('layouts.components.360', ['model' => '2p'])
<div class="dt">
    <div class="title">
        <div style="width: 10rem;"></div>
        <h2>Detalles <span>Técnicos</span></h2>
        <a href="{{asset('assets/pdf/tiggo-2pro.pdf')}}" target="_blank"> Descarga ficha técnica</a>
    </div>
    <div id="data" class="data mt">
        <div class="options ">
            <div id="h_mt" class="option active-hdata" onclick="chageData('motor', 'h_mt')"><img src="/assets/img/modelos/icon/motor.png" alt=""><p>MOTOR</p></div>
            <div id="h_ei" class="option" onclick="chageData('ei', 'h_ei')"><img src="/assets/img/modelos/icon/eqp.png" alt=""><p>EQUIPAMINETO INTERIOR</p></div>
            <div id="h_tr" class="option" onclick="chageData('tr', 'h_tr')"><img src="/assets/img/modelos/icon/trns.png" alt=""><p>TRANSMISION</p></div>
            <div id="h_fr" class="option" onclick="chageData('fr', 'h_fr')"><img src="/assets/img/modelos/icon/frenos.png" alt=""><p>FRENOS</p></div>
            <div id="h_ee" class="option" onclick="chageData('ee', 'h_ee')"><img src="/assets/img/modelos/icon/externo.png" alt=""><p>EQUIPAMINETO EXTERNO</p></div>
            <div id="h_dcp" class="option" onclick="chageData('dcp', 'h_dcp')"><img src="/assets/img/modelos/icon/dimenciones.png" alt=""><p>DIMENSIONES CAPACIDADES Y PESOS</p></div>
            <div id="h_su" class="option" onclick="chageData('su', 'h_su')"><img src="/assets/img/modelos/icon/suspension.png" alt=""><p>SUSPENCION</p></div>
            <div id="h_di" class="option" onclick="chageData('di', 'h_di')"><img src="/assets/img/modelos/icon/direccion.png" alt=""><p>DIRECCION</p></div>
            <div id="h_se" class="option" onclick="chageData('se', 'h_se')"><img src="/assets/img/modelos/icon/seguridad.png" alt=""><p>SEGURIDAD</p></div>
        </div>
        <div class="list">
            <ul id="motor" class="active-data">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Combustible Gasolina</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Válvula 16 VVT</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Desplazamiento 1.497 (cc)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Relación de comprensión 10.5 : 1</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de cilindros y disposición (4 en línea)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alimentación multipunto</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Encendido electrónico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Potencia máxima 105 / 6000 (hp / RPM)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Emisión Euro Vlb</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Torque máximo 135 / 3000 (Nm / RPM)</p></li>
            </ul>

            <ul id="ei" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Aire acondicionado eléctrico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alzavidrios eléctrico delanteros y traseros</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Ventanas con apertura de un toque</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Espejo retrovisor con regulado eléctrico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asiento del conductor regulable en altura</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Volante con ecocuero regulable en altura</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Control de audio y control crucero en el volante</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tapizado de asientos ecocuero y tela</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Computadora a bordo / Aviso mantenimiento</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Pantalla touch 9" con 4 parlantes</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Radio + USB + Bluetooth + MP3</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Apple Car Play + Android QD Link</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Puerto de 12 V</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cubre maletero</p></li>
            </ul>

            <ul id="tr" class="mt">
                <li class="duo aut"><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tipo CVT</p></li>
                <li class="duo mt"><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tipo Mecánica 5 velocidades y reversa</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tracción Delantera 4x2</p></li>
            </ul>

            <ul id="fr" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sistema Sistema de control de estabilidad (ESP)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Delanteros Disco ventilado</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Traseros Disco</p></li>
            </ul>

            <ul id="ee" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Neumáticos – 205 / 60 R16</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Luz LED diurnas</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Luces traseras LED</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Faroles con nivelación de altura</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Faroles de encendido automatico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Barra porta equipaje</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Regulador de altura de faroles</p></li>
            </ul>

            <ul id="dcp" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de plazas 5</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de puertas 5</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Largo / ancho / alto (mm) 4200 / 1760 / 1570</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Distancia entre ejes (mm) 2555</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Capacidad de combustible (L) 50</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Capacidad de maleta (L) 341</p></li>
                <li class="duo mt"><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Peso vacío (kg) 1229</p></li>
                <li class="duo aut"><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Peso vacío (kg)  1260</p></li>
            </ul>

            <ul id="su" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Delantera independiente tipo McPherson, con barra estabilizadora, resorte helicoidal y amortiguadores de doble acción</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Trasera Semi-independiente tipo eje de torsión, con resortes helicoidales y amortiguador de doble acción.</p></li>
            </ul>

            <ul id="di" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tipo Piñón y cremallera</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asistencia Hidráulica</p></li>
            </ul>

            <ul id="se" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alarma contra robo</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Llave codificada con bloqueo de motor</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Llave con comando a distancia</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>2 Airbags frontales (Conductor y acompañante)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Enganche ISO FIX</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Seguro de niños en puertas traseras</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Programa de control de estabilidad (ESP)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asistente de partida en pendiente (HAC)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Distribución electrónica de la fuerza de frenado (EBD)</p></li>
            </ul>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
crossorigin="/anonymous"></script>
<script src="https://kit.fontawesome.com/230beef275.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
crossorigin="/anonymous"></script>
<script>
function chageColor(id) {
    let childs = document.getElementsByClassName('active-color')[0];
    let element = document.getElementById(id);
    childs.classList.remove("active-color");
    element.classList.add("active-color");
}
    function chageData(id, hid) {
        let head = document.getElementsByClassName('active-hdata')[0];
        let childs = document.getElementsByClassName('active-data')[0];
        let element = document.getElementById(id);
        let nhead = document.getElementById(hid);

        childs.classList.remove("active-data");
        element.classList.add("active-data");
        head.classList.remove("active-hdata");
        nhead.classList.add("active-hdata");
    }
    function chageType(id) {
        let childs = document.getElementsByClassName('active-type')[0];
        let element = document.getElementById(id);
        let txt = document.getElementById('txt');
        let data = document.getElementById('data');

        childs.classList.remove("active-type");
        element.classList.add("active-type");
        data.classList.remove("mt");
        data.classList.remove("ctv");
        txt.classList.remove("mt");
        txt.classList.remove("ctv");
        txt.classList.add(id);
        data.classList.add(id);
    }
</script>
@endsection
