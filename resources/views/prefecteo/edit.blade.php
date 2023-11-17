@extends('layouts.dashboard')

@section('template_title')
    Prefecteo
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('prefecteo')}}" class="breadcrumb">Lista de Prefecteos</a>
    <a href="{{url('prefecteo/'.$prefecteo->id.'/edit')}}" class="breadcrumb">Editar Prefecteo</a>
@endsection

@section('content')

    @php
      use Carbon\Carbon;
      $hora = new Carbon;
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
      $horaInicio = $hora->hour($prefecteo->prefHoraInicio)->minute(0)->format('H:i');
      $horaFin = $hora->hour($prefecteo->prefHoraInicio + 1)->minute(0)->format('H:i');
    @endphp

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['prefecteo.update', $prefecteo->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR Prefecteo #{{$prefecteo->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  <li class="tab"><a href="#detalles">Pagos</a></li>
                </ul>
              </div>
            </nav>


            {{-- GENERAL BAR--}}
            <div id="general">

                @php
                    $periodo = $prefecteo->periodo;
                    $departamento = $periodo->departamento;
                    $ubicacion = $departamento->ubicacion;
                @endphp

                <div class="row">
                  <div class="col s12 m6 l4">
                      <label for="ubicacion_id">Ubicación</label>
                      <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" style="width:100%;" required readonly>
                          <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}} - {{$ubicacion->ubiNombre}}</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      <label for="departamento_id">Departamento</label>
                      <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required readonly>
                          <option value="{{$departamento->id}}">{{$departamento->depClave}} - {{$departamento->depNombre}}</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      <label for="periodo_id">Periodo</label>
                      <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required readonly>
                          <option value="{{$periodo->id}}">{{$periodo->perNumero}}-{{$periodo->perAnio}}</option>
                      </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col s12 m12 l6">
                    <div class="card-panel amber lighten-5">
                      Este prefecteo abarca el horario de {{$horaInicio}} a {{$horaFin}}
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col s12 m4 14">
                      <div class="input-field">
                        <p style="text-align:center;">Fecha de revisión</p>
                        {!! Form::date('prefFecha', $prefecteo->prefFecha, array('id' => 'prefFecha', 'class' => 'validate', 'required', 'readonly')) !!}
                      </div>
                    </div>
                    <div class="col s12 m6 l4">
                      <div class="input-field">
                        <p>Hora de cierre</p>
                        <input type="time" name="prefHoraFinal" id="prefHoraFinal" class="validate" min="07:00" max="22:00" value="{{$prefecteo->prefHoraFinal}}">
                      </div>
                    </div>
                </div>
                
            </div>

            <div id="detalles">
                @include('prefecteo/detalles.datatable')
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
        let horaFinal = {!! json_encode($prefecteo->prefHoraFinal) !!};
        console.log(horaFinal);
    });
</script>
@endsection