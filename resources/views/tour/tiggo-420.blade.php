@extends('layouts.components.tour')

@section('list')
<a href="javascript:void(0)" class="scene ena" data-id="0-42pfc">
    <li class="text">Vista Frontal</li>
  </a>

  <a href="javascript:void(0)" class="scene" data-id="1-42pfa">
    <li class="text">42pfa</li>
  </a>

  <a href="javascript:void(0)" class="scene ena" data-id="2-42ptc">
    <li class="text">Vista Trasera</li>
  </a>

  <a href="javascript:void(0)" class="scene" data-id="3-42pta">
    <li class="text">42pta</li>
  </a>

  <a href="javascript:void(0)" class="scene" data-id="4-42pda">
    <li class="text">42pda</li>
  </a>

  <a href="javascript:void(0)" class="scene ena" data-id="5-42pdc">
    <li class="text">Vista Lateral Derecha</li>
  </a>

  <a href="javascript:void(0)" class="scene" data-id="6-42pia">
    <li class="text">42pia</li>
  </a>

  <a href="javascript:void(0)" class="scene ena" data-id="7-42pic">
    <li class="text">Vista Lateral Izquierda</li>
  </a>

  <a href="javascript:void(0)" class="scene ena" data-id="8-42pid">
    <li class="text">Vista Interior</li>
  </a>

  <a href="javascript:void(0)" class="scene" data-id="9-42pit">
    <li class="text">42pit</li>
  </a>
@endsection


@section('data')
<script src="/data/42p.js"></script>
@endsection
