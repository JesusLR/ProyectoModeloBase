@extends('layouts.dashboard')

@section('template_title')
    Bachiller pago certificado
@endsection

@section('breadcrumbs')
    <a href="{{ url('bachiller_curso') }}" class="breadcrumb">Inicio</a>
    <a href="{{ route('bachiller.bachiller_pago_certificado.index') }}" class="breadcrumb">Lista de certificados pagados</a>
    <a href="" class="breadcrumb">Editar Pago certificado</a>
@endsection

@section('content')
    <div class="row">
        <div class="col s12 ">
            {{ Form::open(['method' => 'PUT', 'route' => ['bachiller.bachiller_pago_certificado.update', $bachiller_pago_certificado->id]]) }}
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">PAGO DE CERTIFICADO</span>

                    {{-- NAVIGATION BAR --}}
                    <nav class="nav-extended">
                        <div class="nav-content">
                            <ul class="tabs tabs-transparent">
                                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
                            </ul>
                        </div>
                    </nav>

                    {{-- GENERAL BAR --}}
                    <div id="filtros">

                        @php
                            $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                        @endphp



                        <div class="row">
                            <div class="col s12 m6 l4">
                                {!! Form::label('curEstado', 'Ubicación*', ['class' => '']) !!}
                                <select id="ubicacion_id" class="browser-default validate select2" required
                                    name="ubicacion_id" style="width: 100%;">
                                    <option value="{{ $bachiller_pago_certificado->ubicacion_id }}">
                                        {{ $bachiller_pago_certificado->ubiClave . '-' . $bachiller_pago_certificado->ubiNombre }}
                                    </option>

                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="departamento_id">Departamento*</label>
                                <select name="departamento_id" id="departamento_id"
                                    data-departamento-id="{{ old('departamento_id') }}"
                                    class="browser-default validate select2" style="width:100%;" required>
                                    <option value="{{ $bachiller_pago_certificado->departamento_id }}">
                                        {{ $bachiller_pago_certificado->depClave . '-' . $bachiller_pago_certificado->depNombre }}
                                    </option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="escuela_id">Escuela *</label>
                                <select name="escuela_id" id="escuela_id" data-escuela-id="{{ old('escuela_id') }}"
                                    class="browser-default validate select2" style="width:100%;" required>
                                    <option value="{{ $bachiller_pago_certificado->escuela_id }}">
                                        {{ $bachiller_pago_certificado->escClave . '-' . $bachiller_pago_certificado->escNombre }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m6 l4">
                                <label for="periodo_id">Período *</label>
                                <select name="periodo_id" id="periodo_id" data-escuela-id="{{ old('periodo_id') }}"
                                    class="browser-default validate select2" style="width:100%;" required>
                                    <option value="{{ $bachiller_pago_certificado->periodo_id }}">
                                        {{ $bachiller_pago_certificado->perNumero . '-' . $bachiller_pago_certificado->perAnio }}
                                    </option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="programa_id">Programa *</label>
                                <select name="programa_id" id="programa_id" data-programa-id="{{ old('programa_id') }}"
                                    class="browser-default validate select2" style="width:100%;">
                                    <option value="{{ $bachiller_pago_certificado->programa_id }}">
                                        {{ $bachiller_pago_certificado->progClave . '-' . $bachiller_pago_certificado->progNombre }}
                                    </option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="plan_id">Plan *</label>
                                <select name="plan_id" id="plan_id" data-plan-id="{{ old('plan_id') }}"
                                    class="browser-default validate select2" style="width:100%;">
                                    <option value="{{ $bachiller_pago_certificado->plan_id }}">
                                        {{ $bachiller_pago_certificado->planClave }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m6 l4">
                                <label for="curso_id">Alumno *</label>
                                <select name="curso_id" id="curso_id"
                                    data-curso-id="{{ $bachiller_pago_certificado->curso_id }}"
                                    class="browser-default validate select2" style="width:100%;" required>
                                    <option value="">SELECCIONE UNA ALUMNO</option>
                                </select>
                            </div>


                            <div class="col s12 m6 l4">
                                <div class="col s12 m6 l6">
                                    <div style="position:relative;">
                                        <label for="concepto_pago">Concepto Pago (solo lectura)*</label>
                                        <input type="text" readonly value="CERTIFICADO" name="concepto_pago">                                        
                                    </div>
                                </div>
                                <div class="col s12 m6 l6">
                                    <div style="position:relative;">
                                        <label for="monto_pago">Monto Pago (solo lectura)*</label>
                                        <input type="text" readonly value="250" name="monto_pago">
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 m6 l4">
                                <label for="fecha_pago">Fecha Pago *</label>
                                <input type="date" name="fecha_pago" id="fecha_pago"
                                    value="{{ $bachiller_pago_certificado->fecha_pago }}">
                            </div>

                        </div>


                    </div>
                    <div class="card-action">
                        {!! Form::button('<i class="material-icons left">save</i> GUARDAR', [
                            'class' => 'btn-large waves-effect  darken-3',
                            'type' => 'submit',
                        ]) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    @endsection


    @section('footer_scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                $("#periodo_id").change(event => {

                    var plan_id = $("#plan_id").val();

                    $("#curso_id").empty();
                    $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);


                    $.get(base_url +
                        `/bachiller_pago_certificado/getAlumnosCurso/${event.target.value}/${plan_id}`,
                        function(res,
                            sta) {
                            res.forEach(element => {
                                $("#curso_id").append(
                                    `<option value=${element.id}>${element.aluClave}-${element.perApellido1} ${element.perApellido2} ${element.perNombre}</option>`
                                );
                            });
                        });
                });

                $("#plan_id").change(event => {

                    var periodo_id = $("#periodo_id").val();

                    $("#curso_id").empty();
                    $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);


                    $.get(base_url +
                        `/bachiller_pago_certificado/getAlumnosCurso/${periodo_id}/${event.target.value}`,
                        function(
                            res, sta) {
                            res.forEach(element => {
                                $("#curso_id").append(
                                    `<option value=${element.id}>${element.aluClave}-${element.perApellido1} ${element.perApellido2} ${element.perNombre}</option>`
                                );
                            });
                        });
                });

                var periodo_id = $("#periodo_id").val();
                var plan_id = $("#plan_id").val();

                $("#curso_id").empty();
                $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

                var cursoOld = $("#curso_id").data("curso-id")

                $.get(base_url +
                    `/bachiller_pago_certificado/getAlumnosCurso/${periodo_id}/${plan_id}`,
                    function(
                        res, sta) {
                        res.forEach(element => {

                            var selected = "";
                            if (element.id === cursoOld) {
                                selected = "selected";
                            }

                            $("#curso_id").append(
                                `<option value='${element.id}' ${selected}>${element.aluClave}-${element.perApellido1} ${element.perApellido2} ${element.perNombre}</option>`
                            );
                        });
                    });
            });
        </script>
    @endsection
