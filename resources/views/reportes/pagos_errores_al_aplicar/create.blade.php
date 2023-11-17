@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Errores al aplicar</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/pagos_errores_al_aplicar/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">ERRORES AL APLICAR</span>

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
                      <br>
                      <label for="edoEstado">Tipo de error*</label>
                      <select name="edoEstado" id="edoEstado" class="browser-default validate select2" style="width:100%;" required>
                        <option value="R">Repetido</option>
                        <option value="N">Inválido</option>
                        <option value="D">Descartado</option>
                      </select>
                    </div>
                    <div class="col s12 m6 14">
                      <p class="center-align">Fechas de pago</p>
                      <div class="col s12 m6 l6">
                        <label for="fecha1">Desde: *</label>
                        <input type="date" name="fecha1" id="fecha1" class="validate" value="" required>
                      </div>
                      <div class="col s12 m6 l6">
                        <label for="fecha2">Hasta: *</label>
                        <input type="date" name="fecha2" id="fecha2" class="validate" value="" required>
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col s12 m6 l4">
                    <div class="input-field">
                      <input type="number" name="aluClave" id="aluClave" class="validate" value="{{old('aluClave')}}">
                      <label for="aluClave">Clave de alumno</label>
                    </div>
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
      let fechaActual = {!! json_encode($fechaActual->format('Y-m-d')) !!};
      let edoEstado = {!! json_encode(old('edoEstado')) !!};

      edoEstado && $('#edoEstado').val(edoEstado).select2();

      let fecha1 = {!! json_encode(old('fecha1')) !!} || fechaActual;
      let fecha2 = {!! json_encode(old('fecha2')) !!} || fechaActual;
      $('#fecha1').val(fecha1);
      $('#fecha2').val(fecha2);
    });
</script>
@endsection