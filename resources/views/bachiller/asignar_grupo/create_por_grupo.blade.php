@extends('layouts.dashboard')

@section('template_title')
Bachiller inscrito materia
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{route('bachiller.bachiller_asignar_grupo.index')}}" class="breadcrumb">Lista de Inscritos</a>
<a href="{{route('bachiller.bachiller_asignar_grupo.create')}}" class="breadcrumb">Agregar Inscrito</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' =>
        'bachiller.bachiller_asignar_grupo.store_por_grupo', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">INSCRIBIR POR GRUPOS MATERIA</span>

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
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($ubicaciones as $ubicacion)
                                @php
                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                $selected = '';
                                if($ubicacion->id == $ubicacion_id){
                                $selected = 'selected';
                                }
                                @endphp
                                <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id" data-departamento-id="{{old('departamento_id')}}"
                                class="browser-default validate select2" required name="departamento_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id" data-escuela-id="{{old('escuela_id')}}"
                                class="browser-default validate select2" required name="escuela_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}"
                                class="browser-default validate select2" required name="periodo_id"
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
                            <select id="programa_id" data-programa-id="{{old('programa_id')}}"
                                class="browser-default validate select2" required name="programa_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id" data-plan-id="{{old('plan_id')}}"
                                class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('gpoSemestreC', 'Semestre *', array('class' => '')); !!}
                            <select id="gpoSemestreC" data-gpoSemestreC-id="{{old('gpoSemestreC')}}" class="browser-default validate select2"
                                required name="gpoSemestreC" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        
                    </div>

                    
                    <div class="row">
                        <div class="col s12 ">
                            {!! Form::label('curso_id', 'Alumno preinscrito *', array('class' => '')); !!}
                            <select id="curso_id" data-curso-id="{{old('curso_id')}}"
                                class="browser-default validate select2" required name="curso_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('cgt_id2', 'CGT destino (Materias básicas) *', array('class' => '')); !!}
                            <input type="hidden" name="cgt_actual" id="cgt_actual">
                            <select id="cgt_id2" data-cgt2-id="{{old('cgt_id2')}}" class="browser-default validate select2"
                                required name="cgt_id2" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>
                    {{--  <div class="row">
                        <div class="col s12 ">
                            {!! Form::label('grupo_id', 'Grupo-Materia *', array('class' => '')); !!}
                            <select id="grupo_id" data-grupo-id="{{old('grupo_id')}}"
                                class="browser-default validate select2" required name="grupo_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>  --}}

                    <div class="row" id="Tabla">                        
                        <div class="col s12">
                            <h5 style="color: red; display: none;" id="basica">MATERIAS BÁSICAS</h5>
                            <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="Tabla">                        
                        <div class="col s12">
                            <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrintAcd">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="Tabla">
                        <div class="col s12">
                            <h5 style="color: red; display: none;" id="optativa">MATERIAS OPTATIVAS</h5>
                            <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrintOptativa">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="Tabla">
                        <div class="col s12">
                            <h5 style="color: red; display: none;" id="ocupacional">MATERIAS OCUPACIONAL</h5>
                            <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrintOcupacionales">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="Tabla">
                        <div class="col s12">
                            <h5 style="color: red; display: none;" id="complementaria">MATERIAS COMPLEMENTARIA</h5>
                            <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrintComplementaria">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="Tabla">
                        <div class="col s12">
                            <h5 style="color: red; display: none;" id="extras">MATERIAS EXTRAS</h5>
                            <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrintExtras">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card-action">
                {{--  {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Cargando datos...";this.form.submit();','class' =>
                'btn-large waves-effect darken-3','type' => 'submit']) !!}  --}}

                <button id="btn_guardar_inscrito" class="btn-large waves-effect darken-3" type="button">Guardar<i class="material-icons left">save</i></button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<style>
    table tbody tr:nth-child(odd) {
        background: #D8D5DB;
    }

    table tbody tr:nth-child(even) {
        background: #F1F1F1;
    }

    table th {
        background: #01579B;
        color: #fff;

    }

    table {
        border-collapse: collapse;
        width: 100%;
    }
</style>
@endsection

@section('footer_scripts')

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_periodos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
@include('bachiller.scripts.periodos')
{{--  @include('bachiller.asignar_grupo.cgtDestino')  --}}
@include('bachiller.asignar_grupo.cursos')


<script type="text/javascript">
    $(document).ready(function() {
        // OBTENER PLANES

        $("#curso_id").change(event => {  
    
            $("#cgt_id2").empty();
            $("#cgt_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url + `/bachiller_asignar_grupo/cgt_actual/${event.target.value}`, function(res, sta) {

                var cgt_actual = res.cgt_actual;


                res.cgt.forEach(element => {
                    if (element.id === cgt_actual) {
                        selected = "selected";
                    }
                    $("#cgt_id2").append(`<option value=${element.id}>${element.cgtGradoSemestre}-${element.cgtGrupo}-${element.cgtTurno}</option>`);
                    
                });

                $("#cgt_id2").val(cgt_actual);

                @include('bachiller.asignar_grupo.pintaTabla2')

            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // OBTENER PLANES
        $("#periodo_id").change(event => {
    
            $("#gpoSemestreC").empty();
            $("#gpoSemestreC").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
    
    
            $.get(base_url + `/bachiller_api/obtenerNumerosSemestre/${event.target.value}`, function(res, sta) {
                //seleccionar el post preservado
                var semestreOld = $("#gpoSemestreC").data("gpoSemestreC-id")
    
                res.forEach(element => {
                    var selected = "";
                    if (element.semestre === semestreOld) {
                        selected = "selected";
                    }
    
    
                    $("#gpoSemestreC").append(`<option value=${element.semestre} ${selected}>${element.semestre}</option>`);
                });
    
            });
        });
    });
</script>


@include('bachiller.asignar_grupo.pintarTablas')

@include('bachiller.asignar_grupo.guardarJs')
@endsection