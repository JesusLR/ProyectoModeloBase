@extends('layouts.dashboard')

@section('template_title')
    Secundaria fecha de captura calificaciones
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('secundaria.secundaria_fecha_publicacion_calificacion_alumno.index')}}" class="breadcrumb">Lista fechas de captura calificaciones</a>
    <a href="{{route('secundaria.secundaria_fecha_publicacion_calificacion_alumno.create')}}" class="breadcrumb">Agregar fechas de captura calificaciones</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'secundaria.secundaria_fecha_publicacion_calificacion_alumno.store','method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">AGREGAR FECHA DE CAPTURA DE CALIFICACIONES ALUMNO</span>

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

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                            <select id="ubicacion_id" class="browser-default validate select2" required
                                name="ubicacion_id" style="width: 100%;">
                                {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                                @foreach($ubicaciones as $ubicacion)
                                    @php
                                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                    #$selected = '';
                                    #if (!isset($campus)) {
                                        #if($ubicacion->id == $ubicacion_id){
                                        # $selected = 'selected';
                                        #}
                                    #}
                                    #$selected = (isset($campus) && $campus == $ubicacion->id) ? "selected": "";

                                    @endphp
                                    <option value="{{$ubicacion->id}}" {{ old('ubicacion_id') == $ubicacion->id ? 'selected' : '' }}>{{$ubicacion->ubiNombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id" class="browser-default validate select2" required
                                name="departamento_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id" class="browser-default validate select2" required name="escuela_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" required name="periodo_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                            <select id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" required
                                name="programa_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" required name="plan_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>       
                        
                        <div class="col s12 m6 l4">
                            {!! Form::label('secundaria_mes_evaluaciones_id', 'Mes evaluación *', array('class' => '')); !!}
                            <select id="secundaria_mes_evaluaciones_id" data-plan-id="{{old('secundaria_mes_evaluaciones_id')}}" class="browser-default validate select2" required name="secundaria_mes_evaluaciones_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                {{--  @foreach ($secundaria_mes_evaluaciones as $mes_evaluacion)
                                    <option value="{{$mes_evaluacion->id}}" {{ old('secundaria_mes_evaluaciones_id') == $mes_evaluacion->id ? 'selected' : '' }}>{{$mes_evaluacion->mes}}</option>
                                @endforeach  --}}
                            </select>
                        </div>  
                    </div>
                    
                    <br>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('calPublicacion', 'Fecha publicación calificación *', ['class' => '']); !!}
                            {!! Form::date('calPublicacion', old('calPublicacion'), array('id' => 'calPublicacion', 'class' => 'validate')) !!}
                        </div>
                        
                    </div>

                </div>

                
            </div>

            

            <div class="card-action">
                {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Guardando datos...";this.form.submit();','class' =>
                'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('footer_scripts')

@include('secundaria.scripts.planes')
@include('secundaria.scripts.periodos')
@include('secundaria.scripts.cgts')
@include('secundaria.scripts.cursos')
@include('secundaria.scripts.programas')
@include('secundaria.scripts.departamentos')
@include('secundaria.scripts.escuelas')
@include('secundaria.fecha_publicacion_docente.getMesEvidenciaJs')


@endsection
