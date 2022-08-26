@extends('layouts.principal')
@section('css')
    <link rel="stylesheet" href="/assets/css/modelo.css">
    <link rel="stylesheet" href="/assets/css/carrousel.css">

@endsection

@section('content')
@include('layouts.components.models', ['model'=>'7p'])
<section class="contents">
    @include('layouts.components.galery', ['model'=>'7p'])
    <div class="description">
        <div class="types duo" style="display: none;">
            <a href="#" class="active">MT</a><a href="#" class="">CTV</a>
        </div>
        <div class="title">
            <div class="name"><h2>TIGGO</h2></div>
            <div class="version"><h2>7</h2></div>
            <div class="values">
                <h3>PRO</h3>
                <p>2023</p>
            </div>
        </div>
        <div class="prices">
            <div class="price">
                <h4>PRECIO DESDE</h4>
                <div class="arrow"><img src="/assets/img/modelos/arrow_rigth.png" alt="Flecha_derecha"></div>
                <p class="data">26.900<span>$us</span></p>
            </div>
            <div class="mensual">
                <h4>CUOTA MENSUAL</h4>
                <p class="data">415<span>$us</span></p>
            </div>
        </div>
        <div class="desc">
            <p>Motor 1500 turbo, Caja CVT 9 velocidades, AC con climatizador dual, interior con luces ambientales, 6 airbags, frenos ABS, techo panorámico, pantalla LCD 10"+ screen mirroring + sistema android + cámara reversa, control de audio al volante, velocidad crucero, tapizado en cuero ecológico.</p>
        </div>
        <div class="certificate">
            <img src="/assets/img/modelos/certificate.png" alt="">
        </div>
    </div>
</section>
@include('layouts.components.colors', ['model' => '7p'])
@include('layouts.components.360', ['model' => '7p'])
<div class="dt">
    <div class="title">
        <div style="width: 10rem;"></div>
        <h2>Detalles <span>Técnicos</span></h2>
        <a href="{{asset('assets/pdf/tiggo-7pro.pdf')}}" target="_blank"> Descarga ficha técnica</a>
    </div>
    <div class="data">
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
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Desplazamiento 1498 (cc)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Accionamiento DVVT</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de cilindros y disposición (4 en línea)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alimentación Multipunto</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Relación de compresión 9.5:1</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Encendido electrónico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Potencia máxima 154/5500 (hp / RPM)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Emisión Euro Vlb</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Torque máximo 230/1750 - 4000 (Nm / RPM)</p></li>
            </ul>

            <ul id="ei" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Climatizador automático bi-zona</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Salidas de aire traseras</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Radio con pantalla Touch 10"</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>6 parlantes,Bluetooth + reproductor multimedia</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Apple Car Play + Android QD Links</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Puerto USB: 2 delanteros, 1 trasero</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alzavidrios eléctricos delanteros y traseros</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Ventanas con apertura y cierre de un toque</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Computadora a bordo / Aviso mantenimiento</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Volante con ecocuero regulable a la altura y profundidad</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asiento del conductor electrico, deslizable, reclinable y ajuste de altura</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asiento de acompañante electrico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Espejo retrovisor con anti-deslumbramientoebidas</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Control de audio y control crucero en el volante</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cobertor de equipaje</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Luz LED ambiental</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p> Cooler enfriador de bebidas</p></li>
            </ul>

            <ul id="tr" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tipo Automática CVT 9 velocidades</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tracción Delantera 4x2</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Modo de manejo Eco-Sport</p></li>
            </ul>

            <ul id="fr" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sistema Sistema de control de estabilidad (ESP)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Delanteros Disco ventilado</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Traseros Disco</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Freno de estacionamiento Eléctrico con sistema AUTOHOLD</p></li>
            </ul>

            <ul id="ee" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Neumáticos – 225/60 R18</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Aros de aleación</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Luz LED diurna</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Faroles delanteros con luz LED</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Encendido automatico de faroles</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Regulador de altura de faroles</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Neblineros traseros</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p> Espejos retrovisores con plegado eléctrico y desempañante</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Compuerta de maletero de apertura eléctrica con control remoto</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Techo solar panoramico</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Reconocimiento de llave para el acceso</p></li>
            </ul>

            <ul id="dcp" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de plazas 5</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de puertas 5</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Largo / ancho / alto (mm)  4500 / 1842 / 1705</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Distancia entre ejes (mm) 2670 </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Capacidad de combustible (L) 51</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Peso vacío (kg) 1465</p></li>
            </ul>

            <ul id="su" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Delantera Independiente tipo McPherson, con barra estabilizadora, resorte
                    helicoidal y amortiguadores de doble acción</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Trasera Independiente tipo Multilink , con resortes helicoidales y
                    amortiguador de doble acción</p></li>
            </ul>

            <ul id="di" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tipo Piñón y cremallera</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asistencia Electrónica (EPS)</p></li>
            </ul>

            <ul id="se" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alarma contra robo </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Llave inteligente y comando a distancia </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Encendido a motor </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>6 airbags: frontales, laterales y de cortina </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cinturones de seguridad delanteros con doble pretensionador </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Seguro de niños en puertas traseras </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Enganche ISO FIX </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Columna de dirección colapsable </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cabina tipo jaula de seguridad </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Programa de control de estabilidad (ESP) </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asistente de partida en pendiente (HAC)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asistente de descenso de pendiente (HDC)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Distribución electrónica de la fuerza de frenado (EBD)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sistema de asistencia de frenado de emergencia (BAS)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Aviso de presión y temperatura de llantas (TPMS)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sensores de proximidad traseros</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cámara HD de 360°</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Carrocería con sistema de absorción de impacto</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Barras de acero en puertas laterales</p></li>
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
