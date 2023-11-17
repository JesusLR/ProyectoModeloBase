@extends('layouts.dashboard')

@section('template_title')
    Procesos
@endsection

@section('head')
    <!--dropify-->
    {!! HTML::style(asset('vendors/dropify/css/dropify.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
    {!! HTML::style(asset('vendors/flag-icon/css/flag-icon.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('proceso/pago')}}" class="breadcrumb">Aplica pagos</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'proceso/pago/aplicar','files'=>'true','enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">APLICA PAGOS</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#filtros">Subir archivo</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="filtros">
                <div class="row">
                    <div class="col s12">
                        <input type="file" name="filePagos" id="input-file-now" class="dropify" />
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>Nota: El archivo es en formato (.exp)</p>
                        <div class="preloader"></div>
                    </div>
                </div>
          </div>
          <div class="card-action">
              @if($aplicar)
                <input type="submit" name="submit" id="submit" value="APLICAR PAGOS" class="btn-large waves-effect  darken-3"/>
              @else
                <input type="submit" name="upload" id="upload" value="SUBIR ARCHIVO" class="btn-large waves-effect  darken-3"/>
              @endif
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
  @if (isset($leidos))
    <div class="col s12 ">
      <h5>Registros leidos del archivo de pagos : {{$leidos + $descar}}</h5>
      <h5>Registros descartados por no ser pagos: {{$descar}}</h5>
      <h5>Registros de pagos a procesar         : {{$leidos}}</h5>
      <h5>Registros previamente procesados      : {{$yaproc}}</h5>
      <h5>Registros procesados                  : {{$leidos - $yaproc}}</h5>
      <hr>
      <h5>Registros de pagos correctos          : {{$buenos}}</h5>
      <h5>Registros de pagos invalidos          : {{$invalid}}</h5>
      <h5>Registros de pagos aplicados          : {{$aplicad}}</h5>
      <h5>Registros pagos repetidos             : {{$repetid}}</h5>
    </div>
  @endif
</div>


@endsection

@section('footer_scripts')
<!-- dropify -->
{!! HTML::script(asset('/vendors/dropify/js/dropify.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/form-file-uploads.js'), array('type' => 'text/javascript')) !!}

<script type="text/javascript">
$("#upload").click(function() {
    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');});
    $('.preloader').append('<h5><font color="red">Subiendo archivo...Espere por favor...</font></h5>');
});
$("#submit").click(function() {
    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');});
    $('.preloader').append('<h5><font color="red">Aplicando pagos...Espere por favor...</font></h5>');
});
</script>
@endsection