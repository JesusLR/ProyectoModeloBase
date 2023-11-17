@extends('layouts.dashboard')

@section('template_title')
    Prefecteo Detalle
@endsection

@section('head')
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('prefecteo/'.$detalle->prefecteo_id.'/edit')}}" class="breadcrumb">Lista de Prefecteos</a>
    <a href="{{url('prefecteodetalle/'.$detalle->id.'/edit')}}" class="breadcrumb">Editar Prefecteo</a>
@endsection

@section('content')

    @php
      use Carbon\Carbon;
      $hora = new Carbon;
      $ghInicio = $hora->hour($detalle->ghInicio)->minute(0)->format('H:i');
      $ghFinal = $hora->hour($detalle->ghFinal + 1)->minute(0)->format('H:i');
    @endphp

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['prefecteodetalle.update', $detalle->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR Prefecteo Detalle #{{$detalle->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>


            {{-- GENERAL BAR--}}
            <div id="general">
                <br>
                <div class="row">
                  <div class="col s12 m6 l4">
                    <p class="center-align">Horario de clase</p>
                    <div class="input-field col s12 m6 l6">
                      <label>Inicio</label>
                      <input type="text" name="ghInicio" id="ghInicio" value="{{$ghInicio}}" readonly>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <label>Fin</label>
                      <input type="text" name="ghFinal" id="ghFinal" value="{{$ghFinal}}" readonly>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col s12 m4 14">
                      <div class="input-field">
                        <p style="text-align:center;">Fecha de revisión</p>
                        {!! Form::date('prefFecha', $detalle->prefecteo->prefFecha, array('id' => 'prefFecha', 'class' => 'validate', 'required', 'readonly')) !!}
                      </div>
                    </div>
                    <div class="col s12 m6 l4">
                      <div class="input-field">
                        <p>Hora de revisión</p>
                        <input type="time" name="prefHora" id="prefHora" class="validate" min="07:00" max="22:00" value="{{$detalle->prefHora}}">
                      </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col 12 m6 l4">
                    <label for="asistenciaEstado">Estado de asistencia</label>
                    <select name="asistenciaEstado" id="asistenciaEstado" class="browser-default validate select2" style="width:100%;" required>
                      <option value="A">Asistencia</option>
                      <option value="F">Falta</option>
                      <option value="J">Justificada</option>
                      <option value="X">No aplica</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s12 m6 l6">
                    <label for="asistenciaObservaciones">Observaciones</label>
                    <input type="text" name="asistenciaObservaciones" id="asistenciaObservaciones" value="{{$detalle->asistenciaObservaciones}}" class="validate" maxlength="200">
                  </div>
                </div>
                
            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(() => {
        console.log('Hola Mundo');

        var asistenciaEstado = {!! json_encode(old('asistenciaEstado')) !!} || {!! json_encode($detalle->asistenciaEstado) !!};

        $('#asistenciaEstado').val(asistenciaEstado).select2();
    });
</script>
@endsection