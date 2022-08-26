<?php 
session_start();
include_once "../clases/stock.php";
include_once "../clases/pedido.php";
include_once "../clases/parametros.php";
$iParametros = new parametros();
$codUsuario=$_SESSION['codigousuario'];
$iMap = new Pedido();
$codvend=@$_POST["vendedor"];
$vhasta= @$_POST["hasta"];
$vdesde=@$_POST["desde"];

$marca=@$_POST["ddMarca"];
$origen=@$_POST["ddOrigen"];
$estado=@$_POST["ddEstado"];
$ddVendedor=$_POST["ddVendedor"];

$resultado=$iMap->PuntosVisitas($codUsuario, $vdesde, $vhasta, $marca, $origen, $estado, $ddVendedor);
$resultado2=$iMap->PuntosVisitas($codUsuario, $desde, $hasta, $marca, $origen, $estado, $ddVendedor);

$control=$resultado;

if ($control==false){
    echo "Error.";
}else{

    // Inicio el contenido de la pagina *****************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <script src="https://use.fonticons.com/ffe176a3.js"></script>
        <style type="text/css">
            #logo {position:absolute;z-index:999;opacity:0.8;bottom:30px; left:30px;}
            #pie {position:absolute;z-index:999; bottom:10px; left:250px; margin:5px; padding:5px; background-color:#fff; border-radius:25px;border:none; font-weight:bold;}
            #logo img {border-radius:25px;border:none;}
            html { height: 100% }
            body { height: 100%; margin: 0px; padding: 0px; background-color:#fff;  font-family: proxima-nova, 'Helvetica Neue', Helvetica, Arial, sans-serif; color#666;
                font-size: 12px;
                font-weight: 300;
                line-height: 14px; }
            #map_canvas { min-height: 100% }
            #menu{
                -webkit-background-clip: border-box;
                -webkit-background-origin: padding-box;
                -webkit-background-size: auto;
                -webkit-border-image: none;
                background-attachment: scroll;
                background-clip: border-box;
                background-color: transparent;
                background-image: url(collab.png);
                background-origin: padding-box;
                background-size: auto;
                border-bottom-color: white; border-bottom-style: solid; border-bottom-width: 0px;
                border-left-color: white; border-left-style: solid; border-left-width: 0px;
                border-right-color: white; border-right-style: none; border-right-width: 0px;
                border-top-color: white; border-top-style: solid; border-top-width: 0px;
                color: white;
                cursor: pointer;
                display: block;
                font-size: 14px;
                height: 102px;
                line-height: 20px;
                margin-bottom: 0px;
                margin-left: 0px;
                margin-right: 0px;
                margin-top: 0px;
                outline-color: white;
                outline-style: none;
                outline-width: 0px;
                overflow-x: hidden;
                overflow-y: hidden;
                padding-bottom: 0px;
                padding-left: 0px;
                padding-right: 0px;
                padding-top: 0px;
                position: fixed;
                right: 0%;
                text-decoration: none;
                text-indent: -100000px;
                top: 5%;
                vertical-align: baseline;
                width: 42px;
                z-index: 100000;
            }
            #menu_canvas{
                background-color:#fff;
                font:10px;
                height:100%; 
            }
            #menu a{
                text-decoration:none;
                color:#7b7b7b;	  
            }
            #menu a:hover{
                text-decoration:none;
                color:#000;	  
            }
            #reporte{
                padding-left:5px; 
                padding-right:5px; 
                padding-top: 5px; 
                padding-left:5px; 
                overflow:auto;
            }
            .tablad{
                width:100%;
                border:solid 1px #cecece;
            }
            .tablad tr th{
                background-color:#505050;
                color:#fff;
            }
            .letra{
                font-family: proxima-nova, 'Helvetica Neue', Helvetica, Arial, sans-serif;
                font-size: 12px;
                font-weight: 300;
                line-height: 14px;        
            }
            .mano{
                cursor:pointer;
            }
            .mayuscula{
                text-transform: capitalize;
            }
        </style>

        <script type="text/javascript"
                src="https://maps.google.com/maps/api/js?sensor=true&key=AIzaSyD6iC9_6gX5hUOgnbPqfRPEAxweAaZd6FE">
        </script>
        <script>
            //var script = '<script type="text/javascript" src="../template/js/markerclusterer';
            //var script = '<script type="text/javascript" src="../marker/src/markerclusterer';
            /*if (document.location.search.indexOf('compiled') !== -1) {
                script += '_compiled';
            }*/
            /*script += '.js"><' + '/script>';
            document.write(script);*/
        </script>
        <script type="text/javascript" src="../marker/src/markerclusterer.js"> </script> 
        <script type="text/javascript">
            //coleccion de puntos
            var collection = new Array();

            var mostrar="1";

            function Aumentar(tam){

            }
            function Mostrar(){
                var divmapa = document.getElementById('map_canvas');
                var divmenu = document.getElementById('menu_canvas');
                if (mostrar=="0"){
                    mostrar="1";
                    divmenu.style.minWidth ="";
                    $('menu_canvas').fade();
                    $('map_canvas').morph('width:100%;');
                    $('menu_canvas').morph('width:0%;');
                    $('menu').morph('right:0%;');

                }else{
                    mostrar="0";
                    var width = document.getElementById('map_canvas').offsetWidth;
                    var p1 =15;
                    var p2=84.8;
                    while ((p1*width/100) < 200) {
                        p1=p1+1;
                        p2=p2-1;
                    }

                    $('map_canvas').morph('width:'+p2+'%;', { duration: 1.0 });
                    $('menu_canvas').morph('width:'+p1+'%;', { duration: 1.0 });
                    $('menu').morph('right:'+p1+'%;', { duration: 1.0 });
                    //divmenu.style.minWidth ="200px";
                    $('menu_canvas').appear();
                    //Effect.Grow('menu_canvas');
                    //Effect.SlideUp('map_canvas');
                    //Effect.DropOut('map_canvas');


                }

            }
            function getUrlVars() {
                var vars = {};
                var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                    vars[key] = value;
                });
                return vars;
            }

            var map;
            var markers = [];
            var ubicacion;
            function pinSymbol(color) {
                return {
                    path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
                    fillColor: color,
                    fillOpacity: 1,
                    strokeColor: '#000',
                    strokeWeight: 2,
                    scale: 1,
                };
            }
            //------------------------------------------------------------------------------------------------------
            function addMarker(myloc) {
                var current;

                current = ubicacion;
                for (var i = 0; i < markers.length; i++)
                {
                    if (current.lat() === markers[i].position.lat() && current.lng() === markers[i].position.lng()) {
                        return;
                    }
                }
                markers.push(new google.maps.Marker({
                    map: map,
                    position: current,
                    title: myloc
                }));

                markers[markers.length - 1]['infowin'] = new google.maps.InfoWindow({
                    content: '<div>Esta es tu ubicacion</div>'
                });

                google.maps.event.addListener(markers[markers.length - 1], 'click', function() {
                    this['infowin'].open(map, this);
                });
            }
            //------------------------------------------------------------------------------------------------------
            function addMarker2(myloc2, vlat2, vlong2, cod, color) {
                var current;
                var ubicacion2
                //var image = 'flagcomo.png';
                ubicacion= new google.maps.LatLng(vlat2, vlong2);
                current = ubicacion;      
                markers.push(new google.maps.Marker({
                    map: map,
                    position: current,
                    text: myloc2,
                    draggable: false,
                    title:"Prospecto "+cod
                }));
                var txt=' <div style="width:300px">Prosp Nro '+cod+' &nbsp;&nbsp;&nbsp; <a href="../spc/prospecto.php?cod='+cod+'" target="_blank" style="color:#666"><i class="fa fa-search mano" ></i></a> &nbsp;&nbsp;<a href="../examples/prospecto.php?cod='+cod+'" target="_blank" style="color:#666"><i class="fa fa-file-pdf-o mano" ></i></a><hr>'+myloc2+'</div>  ';
                markers[markers.length - 1]['infowin'] = new google.maps.InfoWindow({
                    content: txt
                });

                google.maps.event.addListener(markers[markers.length - 1], 'click', function() {
                    this['infowin'].open(map, this);
                }); 
            }
            //------------------------------------------------------------------------------------------------------
            function addMarker1(myloc2, vlat2, vlong2) {
                var current;
                var ubicacion2
                //var image = 'flagque.png';
                ubicacion= new google.maps.LatLng(vlat2, vlong2);
                current = ubicacion;
                for (var i = 0; i < markers.length; i++)
                {
                    if (current.lat() === markers[i].position.lat() && current.lng() === markers[i].position.lng()) {
                        return;
                    }
                }
                markers.push(new google.maps.Marker({
                    map: map,
                    position: current,
                    title: myloc2,
                    draggable:true
                }));
                var txt=' <div>'+myloc2+'</div> ';
                markers[markers.length - 1]['infowin'] = new google.maps.InfoWindow({
                    content: txt
                });

                google.maps.event.addListener(markers[markers.length - 1], 'click', function() {
                    this['infowin'].open(map, this);
                }); 
            }
            //------------------------------------------------------------------------------------------------------
            function initialize() {
                //var vlong = getUrlVars()["long"];
                //var vlat = getUrlVars()["lat"];
                //if (vlong=="") vlong="-17.7569008";
                //if (vlat=="") vlat="-63.1947902";
                var vlat ="-17.7582436";
                var vlong ="-63.196385";

                var latlng = new google.maps.LatLng(vlat, vlong);
                ubicacion= new google.maps.LatLng(vlat, vlong);
                var myOptions = {
                    zoom: 8,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP	  
                };
                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                <?php	 

    $resultado->MoveFirst();
    while (! $resultado->EndOfSeek()) {
        $fila = $resultado->Row();
         if(($fila->latitud!="")&&($fila->latitud!="0")&&($fila->longitud!="")&&($fila->longitud!="0")){
        $vnombre ="<table ><tr><td>Nombre:</td><td>".$fila->nombre."</td></tr><tr><td>Ejecutivo: </td><td>".$fila->ejecutivo."</td></tr><tr><td>Producto:</td><td>".$fila->marca." ".$fila->modelo." ".$fila->tipo."</td></tr><tr><td>Total ".'$us'.":</td><td>".number_format($fila->precioVenta, 2, '.', ',')."</td></tr><tr><td>Estado:</td><td>".$fila->estado."</td></tr></table>";
        $vque=" que";
        $como=" como";
        $lat=$fila->latitud;
        $long=$fila->longitud;
        $codMarca=$fila->codMarca;

        echo "addMarker2('$vnombre','$lat','$long','".$fila->codProspecto."');";
        echo "
				"; 
         }
    }

                ?>
                var markerCluster = new MarkerClusterer(map, markers); 
            }
            //------------------------------------------------------------------------------------------------------
            function centrar(alat,along, cod){
                var punto = new google.maps.LatLng(alat,along);
                map.setCenter( punto );
                map.setZoom(8);
            }
            //------------------------------------------------------------------------------------------------------
            var oldpos=0;
            //------------------------------------------------------------------------------------------------------
            function toggleBounce(pos, element) {
                var x = document.getElementsByClassName("bounce").length;
                var el = document.getElementsByClassName("bounce");
                for (var i = 0; i < x; i++)
                {
                    //alert(el[i].id+' .:. '+ el[i].style.color);
                    el[i].style.color = "#505050";
                }


                if((oldpos!=pos)){
                    markers[oldpos].setAnimation(null);
                }
                if (markers[pos].getAnimation() != null) {
                    markers[pos].setAnimation(null);
                } else {
                    markers[pos].setAnimation(google.maps.Animation.BOUNCE);
                    element.style.color = "#f7584b";
                }
                oldpos=pos;
            }
            //------------------------------------------------------------------------------------------------------
        </script>

        <script src="../template/js/prototype.js" type="text/javascript"></script>
        <script src="../template/js/scriptaculous.js?load=effects" type="text/javascript"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="basicgrey.css">
        <title>Mapa</title>
    </head>
    <body onload="initialize()">
        <a id="logo" href="http://www.grt.com.bo"><img src="../logogrt.png" alt="GRT" style="width: 160px;"></a>
        <!-- <div id="menu" >
<a href="javascript:Mostrar();" id="lmenu">Mostrar</a>
</div>-->
        <a href="javascript:Mostrar();" id="menu">Mostrar</a>
        <div id="map_canvas" style="width:100%; height:100%; float:left"></div>
        <div id="menu_canvas" style="width:0%; min-height:100%; float:right; display:none; overflow:auto" >
            <form class="basic-grey" method="post">

                <table>
                    
                    <tr>
                        <td>Vendedor:</td>
                        <td>
                            <select id="ddVendedor" name="ddVendedor">
                                <?php 
    $iParametros = new Parametros();
    $iParametros->DropDownVendedoresFiltrado($_SESSION["codigousuario"], @$_POST["ddVendedor"]);
                                ?>
                            </select>  
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center">
                            <button type="submit" class="button">
                                <i class='fa fa-filter mano'></i> Filtrar
                            </button> 
                        </td>
                    </tr>
                </table>
            </form>
            <center><h2 style="margin: 15px 0 0 0;">Lista de Prospectos</h2></center>
            <div id="reporte">
                <table class="tablad" >
                    <tr><th>#</th><th>Nombre</th><th>Ctrl</th></tr>
                    <?php
    $i=0;
    $resultado2->MoveFirst();
    while (! $resultado2->EndOfSeek()) {
        $fila = $resultado2->Row();
        if(($fila->latitud!="")&&($fila->latitud!="0")&&($fila->longitud!="")&&($fila->longitud!="0")){
                
        $vnombre =$fila->nombre;
        $latitud=$fila->latitud;
        $longitud=$fila->longitud;
        $codigo=$fila->codCliente;
        $i=$i+1;
        echo "<tr><td>".$fila->fecha."</td><td >".$fila->codClienteSAP."<br>".mb_strtolower($vnombre,"UTF-8" )."</td><td>";
        echo "<i class='fa fa-search-plus fa-2x mano' style='color:#505050' onclick='javascript: centrar($latitud, $longitud, ".$codigo.");'></i>&nbsp;&nbsp;";
        echo "<i class='fa fa-map-marker fa-2x mano bounce' style='color:#505050' onclick='javascript:toggleBounce(".($i-1).", this);' id='bn$i'></i>";
        echo "</td></tr>";
        }

    }
                    ?>
                </table>
                <h5>Total prospectos en mapa: <?php echo $i; ?></h5>
            </div>
        </div>

        <style>
            div.floating-menu {
                position:fixed;
                padding:5px;
                z-index:100; 
                left:20px; 
                top: 75px;

                direction: ltr;
                color: rgb(0, 0, 0);
                font-family: Roboto, Arial, sans-serif;
                -webkit-user-select: none;
                font-size: 11px;
                padding: 8px;
                border-bottom-left-radius: 2px;
                border-top-left-radius: 2px;
                -webkit-background-clip: padding-box;
                box-shadow: rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px;
                min-width: 28px;
                font-weight: 500;
                background-color: rgb(255, 255, 255);
                background-clip: padding-box;
            }
            div.floating-menu a, div.floating-menu h3 {display:block;margin:0 0.5em;}
            .lmap{
                color: rgb(86, 86, 86); font-family: Roboto, Arial, sans-serif; font-size: 11px; font-weight: 500; text-decoration:none;
            }
            .lmap:hover{
                color: rgb(150, 150, 150);
            }
        </style><!--
        <div class="floating-menu">
            <center><h3 style="color: rgb(86, 86, 86); font-family: Roboto, Arial, sans-serif; font-size: 11px; font-weight: bold;">Mapas</h3></center>
            <a href="mapa.php" class="lmap">Individual</a>
            <a href="mapa2.php" class="lmap">Agrupado</a>
            <a href="mapa3.php" class="lmap">Calor</a>
        </div>-->
    </body>
</html>
<?php
}
?>