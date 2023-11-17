@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Resumen pronto pago</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/resumen_pronto_pago/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">RESUMEN PRONTO PAGO</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
                </ul>
              </div>
            </nav>
            {{-- GENERAL BAR--}}
            <div id="filtros">

              <div class="row">
                <div class="col s12 m6 l4">
                  <label for="depClave">Departamento*</label>
                  <select name="depClave" id="depClave" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach($departamentos as $key => $departamento)
                      <option value="{{$key}}">{{$key}}-{{$departamento}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <label for="pagAnioPer">Año de curso*</label>
                  <select name="pagAnioPer" id="pagAnioPer" class="browser-default validate select2" style="width:100%;" required>
                    @for($i = $fechaActual->year; $i >= 1999; $i--)
                      <option value="{{$i}}">{{$i}}</option>
                    @endfor
                  </select>
                </div>
              </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  <div class="preloader">
      <div id=""></div>
  </div>

  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}

@endsection


@section('footer_scripts')


<script type="text/javascript">
    $(document).ready(function() {
      let pagAnioPer = {!! json_encode(old('pagAnioPer')) !!};
      let depClave = {!! json_encode(old('depClave')) !!};
      
      pagAnioPer && $('#pagAnioPer').val(pagAnioPer).select2();
      depClave && $('#depClave').val(depClave).select2();
    });
</script>
@endsection