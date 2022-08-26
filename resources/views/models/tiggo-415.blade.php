@extends('layouts.principal')
@section('css')
    <link rel="stylesheet" href="/assets/css/modelo.css">
    <link rel="stylesheet" href="/assets/css/carrousel.css">

@endsection

@section('content')
@include('layouts.components.models', ['model'=>'415p'])
<section class="contents">
    @include('layouts.components.galery', ['model'=>'415p'])
    <div class="description">
        <div class="types" style="display: none;">
            <a href="#" class="active-type">MT</a><a href="#" class="">CTV</a>
        </div>
        <div class="title">
            <div class="name"><h2>TIGGO</h2></div>
            <div class="version"><h2>4</h2></div>
            <div class="values">
                <h3>NEW 1.5</h3>
                <p>2023</p>
            </div>
        </div>
        <div class="prices">
            <div class="price">
                <h4>PRECIO DESDE</h4>
                <div class="arrow"><img src="/assets/img/modelos/arrow_rigth.png" alt="Flecha_derecha"></div>
                <p class="data">18.800<span>$us</span></p>
            </div>
            <div class="mensual">
                <h4>CUOTA MENSUAL</h4>
                <p class="data">294<span>$us</span></p>
            </div>
        </div>
        <div class="desc">
            <p>Motor 1500 cc, caja mecánica, AC, 2 airbags frontales, frenos ABS, pantalla táctil LCD 9", cámara de retro, control de audio al volante, velocidad crucero.</p>
        </div>
        <div class="certificate">
            <img src="/assets/img/modelos/certificate.png" alt="">
        </div>
    </div>
</section>
@include('layouts.components.colors', ['model' => '415p'])
@include('layouts.components.360', ['model' => '415p'])
<div class="dt">
    <div class="title">
        <div style="width: 10rem;"></div>
        <h2>Detalles <span>Técnicos</span></h2>
        <a href="{{asset('assets/pdf/tiggo-415.pdf')}}" target="_blank"> Descarga ficha técnica</a>
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
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Válvula 16 / DOHC DVVT</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Desplazamiento 1.500 (cc)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Relación de comprensión 9.5 : 1</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de cilindros y disposición (4 en línea)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alimentación inyección multipunto</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Encendido electrónico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Potencia máxima 114 / 6150 (hp / RPM)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Emisión Euro V</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Torque máximo 141 / 3800 (Nm / RPM)</p></li>
            </ul>

            <ul id="ei" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Aire acondicionado eléctrico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alzavidrios eléctrico delanteros y trasero</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Ventanas con apertura de un toque</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Espejo retrovisor con regulado eléctrico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Espejo retrovisor con plegado eléctrico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asiento del conductor regulable en altura</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Volante con ecocuero regulable en altura</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Control de audio y control crucero en el volante</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tapizado de asientos ecocuero</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tablero de instrumentos con pantalla LCD</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Volante con ecocuero regulable en altura</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Computadora a bordo / Aviso mantenimiento</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>2 puertos USB + Sistema de audio de 2 parlantes y 2 tweeter</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Pantalla touch LCD 9 pulgadas</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Bluetooth + MP3</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Mirror link Android + Apple Car Play ®</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cubre maletero</p></li>
            </ul>

            <ul id="tr" class="mt">
                <li class="aut"><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tipo Mecánica 5 velocidades</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tracción Delantera 4x2</p></li>
            </ul>

            <ul id="fr" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sistema Sistema de control de estabilidad (ESP)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Delanteros Disco ventilado</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Traseros Disco</p></li>
            </ul>

            <ul id="ee" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Neumáticos – 215/60 R17</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Aros de aleación de aluminio</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Luz LED diurna</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Faroles con nivelación de altura</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Neblineros traseros</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Limpiaparabrisas trasero con desempañador</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Barra porta equipaje</p></li>
            </ul>

            <ul id="dcp" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de plazas 5</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de puertas 5</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Largo / ancho / alto (mm) 4298 / 1830 / 1670</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Distancia entre ejes (mm) 2630</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Capacidad de combustible (L) 51</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Peso vacío (kg) 1360</p></li>
            </ul>

            <ul id="su" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Delantera independiente tipo McPherson con barra estabilizadora y
                    resorte helicoidal cónico. Amortiguador de doble acción</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Trasera Semindependiente con barra de torsión y resorte helicoidal.
                    Amortiguador de doble acción</p></li>
            </ul>

            <ul id="di" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tipo Electrónica (EPS)</p></li>
            </ul>

            <ul id="se" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alarma contra robo</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Llave inteligente y comando a distancia</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Encendido de motor por botón</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>2 Airbags frontales (Conductor y acompañante)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cinturones de tres puntos (5)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Seguro de niños en puertas traserasa</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Enganche ISO FIX</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Columna de dirección colapsable</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cabina tipo jaula de seguridad</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asistente de partida en pendiente (HHC)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asistente de descenso de pendiente (HDC)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Aviso de presión y temperatura de llantas (TPMS)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cámara de reversa</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alarma de velocidad programable (120 km/h)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sensor de reversa</p></li>
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
