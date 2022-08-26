<section class="color">
    <div id="img-cars" class="content-image">
        <img id="rojo" class="active-color" src="{{asset('assets/img/modelos/'.$model.'/colors/r.jpg')}}" alt="">
        <img id="blanco" class="" src="{{asset('assets/img/modelos/'.$model.'/colors/b.jpg')}}" alt="">
        <img id="gris" class="" src="{{asset('assets/img/modelos/'.$model.'/colors/g.jpg')}}" alt="">
        @if ($model == "420p")
        <img id="azul" class="" src="{{asset('assets/img/modelos/'.$model.'/colors/a.jpg')}}" alt="">
        @else
        <img id="negro" class="" src="{{asset('assets/img/modelos/'.$model.'/colors/n.jpg')}}" alt="">
        @endif
        @if ($model == "2c")
        <img id="naranja" class="" src="{{asset('assets/img/modelos/'.$model.'/colors/na.jpg')}}" alt="">
        @endif

    </div>
    <div class="colors">
        <a onclick="chageColor('rojo')" class="color1"></a>
        <a onclick="chageColor('blanco')" class="color2"></a>
        <a onclick="chageColor('gris')" class="color3"></a>
        @if ($model == "420p")
            <a onclick="chageColor('azul')" class="color5"></a>
        @else
            <a onclick="chageColor('negro')" class="color4"></a>
        @endif
        @if ($model == "2c")
            <a onclick="chageColor('naranja')" class="color6"></a>
        @endif
        
    </div>
</section>
