@extends('layouts.dashboard')

@section('template_title')
    Grupo
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('grupo')}}" class="breadcrumb">Lista de Grupo</a>
    <a href="{{url('grupo/create')}}" class="breadcrumb">Agregar Grupo</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'grupo.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR GRUPO</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  <li class="tab"><a href="#equivalente">Equivalente</a></li>
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
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-idold="{{old('plan_id')}}"
                            class="browser-default validate select2"
                            required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoSemestre', 'Semestre *', array('class' => '')); !!}
                        <input class="gpoSemestreOld" type="hidden" data-gpoSemestre-idold="{{old('gpoSemestre')}}">
                        <select id="gpoSemestre"
                            data-gpoSemestre-idold="{{old('gpoSemestre')}}"
                            class="browser-default validate select2"
                            required name="gpoSemestre" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoClave', NULL, array( 'id' => 'gpoClave',
                            'class' => 'validate','required','maxlength' => '3',
                            'value' => old("gpoClave") ? old("gpoClave"): "" )) !!}
                        {!! Form::label('gpoClave', 'Clave grupo *', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoTurno', 'Turno *', array('class' => '')); !!}
                        <select id="gpoTurno" class="browser-default validate select2" required name="gpoTurno" style="width: 100%;">
                            <option value="M" {{old('gpoTurno') == "M" ? "selected": ""}}>MATUTINO</option>
                            <option value="V" {{old('gpoTurno') == "V" ? "selected": ""}}>VESPERTINO</option>
                            <option value="X" {{old('gpoTurno') == "X" ? "selected": ""}}>MIXTO</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 ">
                        {!! Form::label('materia_id', 'Materia *', array('class' => '')); !!}
                        <select id="materia_id" class="browser-default validate select2" required name="materia_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div id="seccion_optativa" class="row" hidden>
                    <div class="col s12 ">
                        {!! Form::label('optativa_id', 'Optativa', array('class' => '')); !!}
                        <select id="optativa_id" class="browser-default validate select2" name="optativa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('gpoCupo', NULL, array('id' => 'gpoCupo', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('gpoCupo', 'Cupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoFechaExamenOrdinario', 'Fecha examen ordinario', array('class' => '')); !!}
                        {!! Form::date('gpoFechaExamenOrdinario', NULL, array('id' => 'gpoFechaExamenOrdinario', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoHoraExamenOrdinario', 'Hora examen ordinario', array('class' => '')); !!}
                        {!! Form::time('gpoHoraExamenOrdinario', NULL, array('id' => 'gpoHoraExamenOrdinario', 'class' => 'validate')) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('empleado_id', 'Maestro *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if(old('empleado_id') == $empleado->id) {{ 'selected' }} @endif>{{$empleado->id ." - ".$empleado->persona->perNombre ." ". $empleado->persona->perApellido1." ".$empleado->persona->perApellido2}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6">
                        {!! Form::label('empleado_sinodal_id', 'Sinodal o Firmante', array('class' => '')); !!}
                        <select id="empleado_sinodal_id" class="browser-default validate select2" name="empleado_sinodal_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if(old('empleado_sinodal_id') == $empleado->id) {{ 'selected' }} @endif>{{$empleado->id ." - ".$empleado->persona->perNombre ." ". $empleado->persona->perApellido1." ".$empleado->persona->perApellido2}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoNumeroFolio', NULL, array('id' => 'gpoNumeroFolio', 'class' => 'validate','maxlength'=>'6')) !!}
                        {!! Form::label('gpoNumeroFolio', 'Folio', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoNumeroActa', NULL, array('id' => 'gpoNumeroActa', 'class' => 'validate','maxlength'=>'6')) !!}
                        {!! Form::label('gpoNumeroActa', 'Acta', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('gpoNumeroLibro', NULL, array('id' => 'gpoNumeroLibro', 'class' => 'validate','maxlength'=>'6')) !!}
                        {!! Form::label('gpoNumeroLibro', 'Libro', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- EQUIVALENTE BAR--}}
            <div id="equivalente">
                <div class="row">
                    <input id="grupo_equivalente_id" name="grupo_equivalente_id" type="hidden"  value="">
                    <div class="col s12 m6">
                        <div class="input-field">
                        {!! Form::text('programa_equivalente', NULL, array('id' => 'programa_equivalente', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('programa_equivalente', 'Programa', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::button('<i class="material-icons left">search</i> Buscar', ['class' => 'btn-modal-grupos-equivalentes btn-large waves-effect modal-trigger','data-target' => 'modalEquivalente']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field">
                            {!! Form::text('materia_equivalente', NULL, array('id' => 'materia_equivalente', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('materia_equivalente', 'Materia', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::button('Cancelar', ['id'=>'cancelar_seleccionado','class' => 'btn-large red darken-3','onclick'=>'cancelarSeleccionado()','style'=>'display:none']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('plan_equivalente', NULL, array('id' => 'plan_equivalente', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('plan_equivalente', 'Plan', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cgt_equivalente', NULL, array('id' => 'cgt_equivalente', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('cgt_equivalente', 'Grado-Grupo-Turno', ['class' => '']); !!}
                        </div>
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

@include('modales.equivalentes')

@endsection

@section('footer_scripts')

@include('scripts.preferencias')
@include('scripts.departamentos')
@include('scripts.escuelas')
@include('scripts.programas')
@include('scripts.planes')
@include('scripts.periodos')
@include('scripts.semestres')
@include('scripts.materias')
@include('scripts.grupos')
@include('scripts.optativas')

@endsection