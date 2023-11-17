@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{ url('bachiller_curso') }}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Resumen de calificaciones por grupo</a>
@endsection

@section('content')
    <div class="row">
        <div class="col s12 ">
            {!! Form::open([
                'onKeypress' => 'return disableEnterKey(event)',
                'route' => 'bachiller.bachiller_resumen_calificaciones_grupo.imprimir',
                'method' => 'POST',
                'target' => '_blank',
            ]) !!}
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">RESUMEN DE CALIFICACIONES POR GRUPO</span>

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
                            $perActual = Auth::user()->empleado->escuela->departamento->perActual;
                        @endphp

                        <div class="row">
                            <div class="col s12 m6 l4">
                                <label for="tamanio">Tipo de hoja *</label>
                                <select name="tamanio" id="tamanio" data-departamento-id="{{ old('tamanio') }}"
                                    class="browser-default validate select2" style="width:100%;" required>
                                    <option value="carta">TAMAÑO CARTA</option>
                                    <option value="oficio">TAMAÑO OFICIO</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col s12 m6 l4">
                                {!! Form::label('curEstado', 'Ubicación*', ['class' => '']) !!}
                                <select id="ubicacion_id" class="browser-default validate select2" required
                                    name="ubicacion_id" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    @foreach ($ubicaciones as $ubicacion)
                                        @php
                                            $selected = '';
                                            
                                            $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                            if ($ubicacion->id == $ubicacion_id && !old('ubicacion_id')) {
                                                echo '<option value="' . $ubicacion->id . '" selected>' . $ubicacion->ubiClave . '-' . $ubicacion->ubiNombre . '</option>';
                                            } else {
                                                if ($ubicacion->id == old('ubicacion_id')) {
                                                    $selected = 'selected';
                                                }
                                            
                                                echo '<option value="' . $ubicacion->id . '" ' . $selected . '>' . $ubicacion->ubiClave . '-' . $ubicacion->ubiNombre . '</option>';
                                            }
                                        @endphp
                                    @endforeach
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="departamento_id">Departamento*</label>
                                <select name="departamento_id" id="departamento_id"
                                    data-departamento-id="{{ old('departamento_id') }}"
                                    class="browser-default validate select2" style="width:100%;" required>
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="escuela_id">Escuela *</label>
                                <select name="escuela_id" id="escuela_id" data-escuela-id="{{ old('escuela_id') }}"
                                    class="browser-default validate select2" style="width:100%;" required>
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m6 l4">
                                <label for="periodo_id">Período *</label>
                                <select name="periodo_id" id="periodo_id" data-escuela-id="{{ old('periodo_id') }}"
                                    class="browser-default validate select2" style="width:100%;" required>
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="programa_id">Programa *</label>
                                <select name="programa_id" id="programa_id" data-programa-id="{{ old('programa_id') }}"
                                    class="browser-default validate select2" style="width:100%;">
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="plan_id">Plan *</label>
                                <select name="plan_id" id="plan_id" data-plan-id="{{ old('plan_id') }}"
                                    class="browser-default validate select2" style="width:100%;">
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            {{-- <div class="col s12 m6 l4">
                                <label for="TipoMateria">Materia(s) *</label>
                                <select name="TipoMateria" id="TipoMateria" data-TipoMateria-id="{{ old('TipoMateria') }}"
                                    class="browser-default validate select2" style="width:100%;">
                                    <option value="">TODOS</option>
                                    <option value="BASICA" {{ old('TipoMateria') == 'BASICA' ? 'selected' : '' }}>BÁSICA
                                    </option>
                                    <option value="OPTATIVA" {{ old('TipoMateria') == 'OPTATIVA' ? 'selected' : '' }}>
                                        OPTATIVA</option>
                                    <option value="OCUPACIONAL" {{ old('TipoMateria') == 'OCUPACIONAL' ? 'selected' : '' }}>
                                        OCUPACIONAL</option>
                                    <option value="EXTRA" {{ old('TipoMateria') == 'EXTRA' ? 'selected' : '' }}>
                                        EXTRAOFICIAL</option>
                                    <option value="COMPLEMENTARIA"
                                        {{ old('TipoMateria') == 'COMPLEMENTARIA' ? 'selected' : '' }}>COMPLEMENTARIA
                                    </option>
                                    <option value="BASICA INGLES"
                                        {{ old('TipoMateria') == 'BASICA INGLES' ? 'selected' : '' }}>BÁSICA INGLES</option>
                                </select>
                            </div> --}}
                            <div class="col s12 m6 l4">
                                <div class="col s12 m6 l6">
                                    {{--  {!! Form::number('cgtGradoSemestreBuscar', NULL, array('id' => 'cgtGradoSemestreBuscar', 'class' => 'validate','min'=>'0', 'required')) !!}
                            {!! Form::label('cgtGradoSemestreBuscar', 'Semestre *', array('class' => '')); !!}  --}}

                                    {!! Form::label('cgtGradoSemestreBuscar', 'Semestre *', ['class' => '']) !!}
                                    <select id="cgtGradoSemestreBuscar"
                                        data-cgtGradoSemestreBuscar-id="{{ old('cgtGradoSemestreBuscar') }}"
                                        class="browser-default validate select2" required name="cgtGradoSemestreBuscar"
                                        style="width: 100%;">
                                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    </select>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    {!! Form::text('cgtGrupo', null, ['id' => 'cgtGrupo', 'class' => 'validate', 'maxlength' => 2, 'required']) !!}
                                    {!! Form::label('cgtGrupo', 'Grupo *', ['class' => '']) !!}
                                </div>
                            </div>
                            <div class="col s12 m6 l4">
                                <div class="input-field">
                                    {!! Form::number('aluClave', null, ['id' => 'aluClave', 'class' => 'validate', 'min' => '0']) !!}
                                    {!! Form::label('aluClave', 'Clave alumno', ['class' => '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m6 l4">
                                <div class="input-field col s12 m6 l6">
                                    {!! Form::text('perApellido1', null, ['id' => 'perApellido1', 'class' => 'validate', 'min' => '0']) !!}
                                    {!! Form::label('perApellido1', 'Primer Apellido', ['class' => '']) !!}
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    {!! Form::text('perApellido2', null, ['id' => 'perApellido2', 'class' => 'validate', 'min' => '0']) !!}
                                    {!! Form::label('perApellido2', 'Segundo Apellido', ['class' => '']) !!}
                                </div>
                            </div>
                            <div class="col s12 m6 l4">
                                <div class="input-field">
                                    {!! Form::text('perNombre', null, ['id' => 'perNombre', 'class' => 'validate', 'min' => '0']) !!}
                                    {!! Form::label('perNombre', 'Nombre(s)', ['class' => '']) !!}
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-action">
                        {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', [
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
        @include('bachiller.scripts.preferencias')
        @include('bachiller.scripts.departamentos')
        @include('bachiller.scripts.escuelas_todos')
        @include('bachiller.scripts.programas')
        @include('bachiller.scripts.planes-espesificos')

        <script type="text/javascript">
            $(document).ready(function() {
                // OBTENER PLANES
                $("#periodo_id").change(event => {

                    $("#cgtGradoSemestreBuscar").empty();
                    $("#cgtGradoSemestreBuscar").append(
                        `<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);


                    $.get(base_url + `/bachiller_api/obtenerNumerosSemestre/${event.target.value}`, function(
                        res, sta) {
                        //seleccionar el post preservado
                        var semestreOld = $("#cgtGradoSemestreBuscar").data("cgtGradoSemestreBuscar-id")

                        res.forEach(element => {
                            var selected = "";
                            if (element.semestre === semestreOld) {
                                selected = "selected";
                            }


                            $("#cgtGradoSemestreBuscar").append(
                                `<option value=${element.semestre} ${selected}>${element.semestre}</option>`
                            );
                        });

                    });
                });
            });
        </script>
    @endsection
