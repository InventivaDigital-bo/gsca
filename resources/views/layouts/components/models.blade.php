<section class="banner">
    <ul>
        <li class="@if ($model == '2c') active @endif "><a href="{{route('modelo', 'tiggo-2-premium')}}"><img src="/assets/img/modelos/t2p.png" alt=""></a></li>
        <li class="@if ($model == '2p') active @endif"><a href="{{route('modelo', 'tiggo-2-pro')}}"><img src="/assets/img/modelos/t2pr.png" alt=""></a></li>
        <li class="@if ($model == '415p') active @endif"><a href="{{route('modelo', 'new-tiggo-4-15')}}"><img src="/assets/img/modelos/t415.png" alt=""></a></li>
        <li class="@if ($model == '420p') active @endif"><a href="{{route('modelo', 'new-tiggo-4-20')}}"><img src="/assets/img/modelos/t420.png" alt=""></a></li>
        <li class="@if ($model == '7p') active @endif"><a href="{{route('modelo', 'tiggo-7-pro')}}"><img src="/assets/img/modelos/t7p.png" alt=""></a></li>
    </ul>
</section>


<!-- <style>
    .banner:hover ul:hover li.active:hover, .banner ul li.active, .banner ul li:hover {
        transform: scale(.6);
    }
    .banner:hover ul li.active, .banner:hover ul:hover li.active, .banner ul li{
        transform: scale(.51 );
    }
</style> -->