@extends('layouts.dashboard')

@section('template_title')
Reporte
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
<label class="breadcrumb">Materias aprobadas</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' =>
        'bachiller.bachiller_materias_aprobadas.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">REPORTE DE MATERIAS APROBADAS</span>

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
                            {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                            <select id="ubicacion_id" class="browser-default validate select2" required
                                name="ubicacion_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($ubicaciones as $ubicacion)
                                @php
                                $selected = '';

                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                                echo '<option value="'.$ubicacion->id.'" selected>
                                    '.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                } else {
                                if ($ubicacion->id == old("ubicacion_id")) {
                                $selected = 'selected';
                                }

                                echo '<option value="'.$ubicacion->id.'" '. $selected .'>
                                    '.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                }
                                @endphp
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
                            <div class="input-field">
                                <label for="">Clave Pago *</label>
                                <input type="number" id="aluClave" oninput="maxLengthCheck(this)" name="aluClave" required maxlength="8">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('tipoReporte', 'Vista del reporte *', array('class' => '')); !!}
                            <select id="tipoReporte" data-departamento-id="{{old('tipoReporte')}}" class="browser-default validate select2" required name="tipoReporte" style="width: 100%;">
                                <option value="1">MATERIAS APROBADAS</option>
                                <option value="2">MATERIAS REPROBADAS</option>
                                <option value="3">MATERIAS APROBADAS Y REPROBADAS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large
                    waves-effect darken-3 submit-button','type' => 'submit']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @endsection

    @section('footer_scripts')

    @include('bachiller.scripts.preferencias')
    @include('bachiller.scripts.departamentos')
    @include('bachiller.scripts.escuelas')
    @include('bachiller.scripts.programas')
    @include('bachiller.scripts.planes-espesificos')


    <script type="text/javascript">

        function maxLengthCheck(object)
        {
            if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
        }

        $(document).ready(function() {
        // OBTENER MATERIA SEMESTRE Y SEMESTRE CGT
        $("#plan_id").change( event => {
            $("#matSemestre").empty();
            $("#matSemestre").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);




            $.get(base_url + `/bachiller_plan/plan/semestre/${event.target.value}`, function(res,sta) {
                //seleccionar el post preservado
                var gpoSemestreSeleccionadoOld = $(".gpoSemestreOld").data("gposemestre-id")
                console.log(gpoSemestreSeleccionadoOld)

                $("#matSemestre").empty()
                //PARA PRIMARIA SON 6 GRADOS
                //for (i = 1; i <= res.planPeriodos; i++) {
                for (i = 1; i <= 6; i++) {    
                    var selected = "";
                    if (i === gpoSemestreSeleccionadoOld) {
                        selected = "selected";
                    }


                    $("#matSemestre").append(`<option value="${i}" ${selected}>${i}</option>`);
                }

                $('#matSemestre').trigger('change'); // Notify only Select2 of changes
            });
        });


     });
    </script>


    @endsection