@extends('layouts.dashboard')

@section('template_title')
    Preescolar actividad
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('preescolar.preescolar_actividades.index')}}" class="breadcrumb">Lista de actividades</a>
    <a href="{{ route('preescolar.preescolar_actividades.create') }}" class="breadcrumb">Agregar actividad</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'preescolar.preescolar_actividades.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR ACTIVIDAD</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  {{-- <li class="tab"><a href="#equivalente">Equivalente</a></li> --}}
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @php
                                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;

                                    $selected = '';
                                    if ($ubicacion->id == $ubicacion_id) {
                                        $selected = 'selected';
                                    }

                                    if ($ubicacion->id == old("ubicacion_id")) {
                                        $selected = 'selected';
                                    }
                                @endphp
                                <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiClave ."-". $ubicacion->ubiNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-idold="{{old('departamento_id')}}"
                            class="browser-default validate select2"
                            required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-idold="{{old('escuela_id')}}"
                            class="browser-default validate select2"
                            required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id"
                            data-periodo-idold="{{old('periodo_id')}}"
                            class="browser-default validate select2"
                            required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-idold="{{old('programa_id')}}"
                            class="browser-default validate select2"
                            required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                  
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('actGrupo', NULL, array('id' => 'actGrupo', 'class' => 'validate','maxlength'=>'3', 'required')) !!}
                        {!! Form::label('actGrupo', 'Actividad *', array('class' => '')); !!}
                        </div>
                    </div>


                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('actDescripcion', NULL, array('id' => 'actDescripcion', 'class' => 'validate','maxlength'=>'255', 'required')) !!}
                        {!! Form::label('actDescripcion', 'Descripción actividad *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" name="actImporte" id="actImporte" step="0.1">
                            {!! Form::label('actImporte', 'Cantidad importe de cada pago (en M.N,) *', array('class' => '')); !!}
                        </div>
                    </div>
                  
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" name="actNumeroPagos" id="actNumeroPagos">
                        {!! Form::label('actNumeroPagos', 'Número de pagos durante el período *', array('class' => '')); !!}
                        </div>
                    </div>


                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" name="actCupo" id="actCupo">
                        {!! Form::label('actCupo', 'Cupo máximo de inscripciones *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
            

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('empleado_id', 'Instrucctor (a) *', array('class' => '')); !!}
                        <select id="empleado_id" data-programa-idold="{{old('empleado_id')}}" class="browser-default validate select2" name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach ($empleados as $empleado)
                                <option value="{{$empleado->id}}">{{$empleado->perApellido1.' '.$empleado->perApellido2.' '.$empleado->perNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
           
            </div>



          </div>
          <div class="card-action">
              <button type="submit" class="btn-guardar btn-large waves-effect  darken-3"><i class="material-icons left">save</i>Guardar</button>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
</div>



@endsection

@section('footer_scripts')
{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}

<script type="text/javascript">
    $(document).ready(function() {



       

        


    });
</script>


@include('preescolar.scripts.preferencias_aex')
@include('preescolar.scripts.departamentos_aex')
@include('preescolar.scripts.escuelas_aex')
@include('scripts.programas')
@include('scripts.periodos')


@endsection
