@extends('layouts.principal')
@section('css')
    <link rel="stylesheet" href="/assets/css/modelo.css">
    <link rel="stylesheet" href="/assets/css/carrousel.css">

@endsection

@section('content')
    @include('layouts.components.models', ['model'=>'2c'])
<section class="contents">
    @include('layouts.components.galery', ['model'=>'2c'])
    <div class="description">
        <div class="types duo" style="display: none;">
            <a href="#" class="active">MT</a><a href="#" class="">CTV</a>
        </div>
        <div class="title">
            <div class="name"><h2>TIGGO</h2></div>
            <div class="version"><h2>2</h2></div>
            <div class="values">
                <h3>CONFORT</h3>
                <p>2022</p>
            </div>
        </div>
        <div class="prices">
            <div class="price">
                <h4>PRECIO DESDE</h4>
                <div class="arrow"><img src="/assets/img/modelos/arrow_rigth.png" alt="Flecha_derecha"></div>
                <p class="data">15.800<span>$us</span></p>
            </div>
            <div class="mensual">
                <h4>CUOTA MENSUAL</h4>
                <p class="data">241<span>$us</span></p>
            </div>
        </div>
        <div class="desc">
            <p>Motor 1500cc, caja mecánica, AC, 2 airbags frontales, frenos ABS, control de audio al volante audio, radio + Bluetooth + aros de aleación.</p>
        </div>
        <div class="certificate">
            <img src="/assets/img/modelos/certificate.png" alt="">
        </div>
    </div>
</section>
@include('layouts.components.colors', ['model' => '2c'])
{{-- @include('layouts.components.360', ['model' => '2c', 'dir' => '']) --}}
<div class="dt">
    <div class="title">
        <div style="width: 10rem;"></div>
        <h2>Detalles <span>Técnicos</span></h2>
        <a href="{{asset('assets/pdf/tiggo-2con.pdf')}}" target="_blank"> Descarga ficha técnica</a>
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
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Válvula 16 VVT</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Desplazamiento 1.497 (cc)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Numero de cilindros y disposición (4 en línea)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alimentación inyección multipunto</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Encendido electrónico integrado con la inyección</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Potencia máxima 105 / 6000 (hp / RPM)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Emisión Euro V</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Torque máximo 135 / 2750 (Nm / RPM)</p></li>
            </ul>

            <ul id="ei" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tapiz de tela</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Aire acondicionado</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Volante regulable en altura</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Radio AM FM con puerto USB controlada desde el volante + Bluetooth</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Espejo retrovisor central antireflejo</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Regulador de altura de faros</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Control de velocidad crucero en el volante</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Luz delantera para lectura de mapas</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Apoya brazo delantero (3 en línea)</p></li>
            </ul>

            <ul id="tr" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tipo Mecánica: 5 velocidades y reversa</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tracción Delantera 4x2</p></li>
            </ul>

            <ul id="fr" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sistema Circuíto cruzado con ABS + EBD</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Delanteros Disco ventilado</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Traseros Disco</p></li>
            </ul>

            <ul id="ee" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Neumáticos – 205 / 55 R16</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Aros de aleación</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Guiñador en espejos retrovisores</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cierre centralizado</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cierre con comando a distancia</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Faros halógenos</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Luz led diurna</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Neblineros traseros</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Spoiler</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Barras portaequipaje</p></li>
            </ul>

            <ul id="dcp" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de plazas 5</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Número de puertas 5</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Largo / ancho / alto (mm) 4200 / 1760 / 1570</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Distancia entre ejes (mm) 2555</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Capacidad de maleta (L) 341</p></li>
            </ul>

            <ul id="su" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Delantera Independiente tipo McPershon, con barra estabilizadora, resorte helicoidal y
                    amortiguador doble acción </p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Trasera Semi-independiente tipo eje de torsión, con resortes helicoidales y
                    amortiguador de doble acción</p></li>
            </ul>

            <ul id="di" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Tipo Piñón y cremallera</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Asistencia Hidraúlica</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Radio de giro (m) 5,5</p></li>
            </ul>

            <ul id="se" class="">
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Airbags delanteros para conductor y pasajero</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sistema antirrobo (llave codificada)</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alarma de exceso de velocidad</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Barras de acero laterales en puertas</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Carrocería con zona de deformación programada</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Cinturones traseros de tres puntas</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Luz indicador del no uso del cinturón de seguridad del conductor</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Columna de dirección colapsable</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Jaula de seguridad en habitáculo</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Parachoques con sistema de absorción de impacto</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Alarma de apertura de puerta en movimiento</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sensor de retro</p></li>
                <li><img src="/assets/img/modelos/arrow_rigth.png" alt=""><p>Sensor de luz crepuscular</p></li>
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
