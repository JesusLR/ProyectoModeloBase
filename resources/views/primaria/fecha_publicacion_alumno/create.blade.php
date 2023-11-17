@extends('layouts.dashboard')

@section('template_title')
    Primaria fecha de captura calificaciones
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_fecha_publicacion_calificacion_alumno.index')}}" class="breadcrumb">Lista fechas de captura calificaciones</a>
    <a href="{{route('primaria.primaria_fecha_publicacion_calificacion_alumno.create')}}" class="breadcrumb">Agregar fechas de captura calificaciones</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'primaria.primaria_fecha_publicacion_calificacion_alumno.store','method' => 'POST']) !!}
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
                            {!! Form::label('primaria_mes_evaluaciones_id', 'Mes evaluación *', array('class' => '')); !!}
                            <select id="primaria_mes_evaluaciones_id" data-plan-id="{{old('primaria_mes_evaluaciones_id')}}" class="browser-default validate select2" required name="primaria_mes_evaluaciones_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                {{--  @foreach ($primaria_mes_evaluaciones as $mes_evaluacion)
                                    <option value="{{$mes_evaluacion->id}}" {{ old('primaria_mes_evaluaciones_id') == $mes_evaluacion->id ? 'selected' : '' }}>{{$mes_evaluacion->mes}}</option>
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

@include('primaria.scripts.planes')
@include('primaria.scripts.periodos')
@include('primaria.scripts.cgts')
@include('primaria.scripts.cursos')
@include('primaria.scripts.programas')
@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas')


<script type="text/javascript">

    $(document).ready(function() {

        $("#departamento_id").change( event => {
            
            $("#primaria_mes_evaluaciones_id").empty();
            $("#primaria_mes_evaluaciones_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/primaria_fecha_publicacion_calificacion_docente/getMesEvaluacion/${event.target.value}`,function(res,sta){

                var primaria_mes_evaluaciones = $("#primaria_mes_evaluaciones_id").data("primaria_mes_evaluaciones-id")

                res.forEach(element => {
                    var selected = "";
                    if (element.id === primaria_mes_evaluaciones) {
                        selected = "selected";
                    }

                    $("#primaria_mes_evaluaciones_id").append(`<option value="${element.id}" ${selected}>${element.mes}</option>`);
                });

                
            });
        });

        

     });
</script>

@endsection
