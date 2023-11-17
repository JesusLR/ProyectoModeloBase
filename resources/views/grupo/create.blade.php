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
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoExtraCurr', 'Es Materia Extracurricular *', array('class' => '')); !!}
                        <select id="gpoExtraCurr"
                            class="browser-default validate select2"
                            required name="gpoExtraCurr" style="width: 100%;">
                            <option value="N" selected>NO</option>
                            <option value="S">SI</option>
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
                            'class' => 'validate','required','maxlength' => '2',
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
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('nombreAlternativo', NULL, array('id' => 'nombreAlternativo','onKeyPress="if(this.value.length==75) return false;"')) !!}
                        {!! Form::label('nombreAlternativo', 'Nombre Alternativo', array('class' => '')); !!}
                        </div>
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
                        {!! Form::date('gpoFechaExamenOrdinario', NULL, array('id' => 'gpoFechaExamenOrdinario', 'class' => 'validate', 'required')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoHoraExamenOrdinario', 'Hora examen ordinario', array('class' => '')); !!}
                        {!! Form::time('gpoHoraExamenOrdinario', NULL, array('id' => 'gpoHoraExamenOrdinario', 'class' => 'validate', 'required')) !!}
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
                            <option value="">SELECCIONE UNA OPCIÓN</option>
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
                    <input id="grupo_equivalente_id" name="grupo_equivalente_id" value="" type="hidden">
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
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-guardar btn-large waves-effect  darken-3']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
</div>



<div class="row form-horarios" style="display:none;">
    <div class="col s12 ">
        {!! Form::open(['class' => 'formAgregarHorario', 'onKeypress' => 'return disableEnterKey(event)','url' => 'grupo/agregarHorario', 'method' => 'POST']) !!}
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title" style="display:inline-block;">AGREGAR HORARIOS</span>
                    <span style="float:right;">
                        <label for="">Terminar horarios y continuar grupos:</label>
                        <button  class="cancelar-form-horarios waves-effect waves-light btn" >
                            <i class="material-icons">done</i>
                        </button>
                    </span>
                    {{-- GENERAL BAR--}}
                    <br>
                    <input id="grupo_creado_id" name="grupo_creado_id" type="hidden" >
                    <input id="empleado_creado_id" name="empleado_creado_id" type="hidden" >
                    
                    <div class="row">
                        <div class="col s12 m6">
                            {!! Form::label('aula_id', 'Aula', array('class' => '')); !!}
                            <select id="aula_id" class="browser-default validate select2" required name="aula_id" style="width: 100%;">
                                {{-- @foreach($aulas as $aula)
                                    <option value="{{$aula->id}}" @if(old('aula_id') == $aula->id) {{ 'selected' }} @endif>{{$aula->aulaClave}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col s12 m6">
                            {!! Form::label('ghDia', 'Día', array('class' => '')); !!}
                            <select id="ghDia" class="browser-default validate select2" required name="ghDia" style="width: 100%;">
                                @for($i=1;$i<=6;$i++)
                                    <option value="{{$i}}" @if(old('ghDia') == $i) {{ 'selected' }} @endif>{{App\Http\Helpers\Utils::diaSemana($i)}}</option>
                                @endFor
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m3">
                            {!! Form::label('ghInicio', 'Hora Inicio', array('class' => '')); !!}
                            <select id="ghInicio" class="browser-default validate select2" required name="ghInicio" style="width: 100%;">
                                @for($i=7;$i<=22;$i++)
                                    <option value="{{$i}}" @if(old('ghInicio') == $i) {{ 'selected' }} @endif>{{$i}}Hrs</option>
                                @endFor
                            </select>
                        </div>
                        <div class="col s12 m3">
                            {!! Form::label('gMinInicio', 'Minutos', array('class' => '')); !!}
                            <select id="gMinInicio" class="browser-default validate select2" required name="gMinInicio" style="width: 100%; margin-top: 10px;">
                                <option value="00">0 Min</option>
                                <option value="05">5 Min</option>
                                <option value="10">10 Min</option>
                                <option value="15">15 Min</option>
                                <option value="20">20 Min</option>
                                <option value="25">25 Min</option>
                                <option value="30">30 Min</option>
                                <option value="35">35 Min</option>
                                <option value="40">40 Min</option>
                                <option value="45">45 Min</option>
                                <option value="50">50 Min</option>
                                <option value="55">55 Min</option>
                            </select>
                        </div>
                        <div class="col s12 m3">
                            {!! Form::label('ghFinal', 'Hora Final', array('class' => '')); !!}
                            <select id="ghFinal" class="browser-default validate select2" required name="ghFinal" style="width: 100%;">
                                @for($i=7;$i<=22;$i++)
                                    <option value="{{$i}}" @if(old('ghFinal') == $i) {{ 'selected' }} @endif>{{$i}}Hrs</option>
                                @endFor
                            </select>
                        </div>
                        <div class="col s12 m3">
                            {!! Form::label('gMinFinal', 'Minutos', array('class' => '')); !!}
                            <select id="gMinFinal" class="browser-default validate select2" required name="gMinFinal" style="width: 100%; margin-top: 10px;">
                                <option value="00" selected>0 Min</option>
                                <option value="05">5 Min</option>
                                <option value="10">10 Min</option>
                                <option value="15">15 Min</option>
                                <option value="20">20 Min</option>
                                <option value="25">25 Min</option>
                                <option value="30">30 Min</option>
                                <option value="35">35 Min</option>
                                <option value="40">40 Min</option>
                                <option value="45">45 Min</option>
                                <option value="50">50 Min</option>
                                <option value="55">55 Min</option>
                            </select>
                        </div>
                    </div>

                    {!! Form::button('<i class="material-icons left">add</i> Agregar', ['class' => 'btnAgregarHorario btn-large waves-effect  darken-3', "style" => "display:block;"]) !!}
                    <div class="error-equivalente-hrs card-panel red darken-1 lighten-2" style="display:none;">
                        <p style="color: #fff;">No se puede modificar horarios de este grupo, porque pertenece a un grupo equivalente.</p>
                    </div>

                    <br><br>
                    <div class="row">
                        <div class="col l6 m12 s12">
                            <p><b>HORARIOS POR GRUPO</b></p>
                            <table id="tbl-horario" class="responsive-table display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Día</th>
                                        <th>Aula</th>
                                        <th>Hora Inicio</th>
                                        <th>Hora Final</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="col l6 m12 s12">
                            <p><b>HORARIOS ADMINISTRATIVOS</b></p>
                            <table id="tbl-horario-admivo" class="responsive-table display" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Día</th>
                                    <th>Hora Inicio</th>
                                    <th>Hora Final</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>



@include('modales.equivalentes')

@endsection

@section('footer_scripts')
{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}

<script type="text/javascript">
    $(document).ready(function() {

        $(document).on("click", ".cancelar-form-horarios", function(e) {
            e.preventDefault()

            $("#ubicacion_id").prop( "disabled", false  );
            $("#departamento_id").prop( "disabled", false  );
            $("#escuela_id").prop( "disabled", false  );
            $("#periodo_id").prop( "disabled", false  );
            $("#perFechaInicial").prop( "disabled", false  );
            $("#perFechaFinal").prop( "disabled", false  );
            $("#programa_id").prop( "disabled", false  );
            $("#plan_id").prop( "disabled", false  );
            $("#gpoSemestre").prop( "disabled", false  );
            $("#gpoClave").prop( "disabled", false  );
            $("#gpoTurno").prop( "disabled", false  );

            $(".form-horarios").hide()
            $(".btn-guardar").show();

            cancelarSeleccionado()

            if ($.fn.DataTable.isDataTable("#tbl-horario")) {
                $('#tbl-horario').DataTable().clear().destroy();
            }

            if ($.fn.DataTable.isDataTable("#tbl-horario-admivo")) {
                $('#tbl-horario-admivo').DataTable().clear().destroy();
            }

            $(".error-equivalente-hrs").hide();
            $(".btnAgregarHorario").show();

        })


        function crearTablaHorario () {
            var grupo_creado_id = $('#grupo_creado_id').val();
            var claveMaestro = $('#empleado_id').val();
            var periodoId = $('#periodo_id').val();

            if (grupo_creado_id != "" && grupo_creado_id != null) {

                if ($.fn.DataTable.isDataTable("#tbl-horario")) {
                    $('#tbl-horario').DataTable().clear().destroy();
                }
                $('#tbl-horario').dataTable({
                    "language":{"url":base_url+"/api/lang/javascript/datatables"},
                    "serverSide": true,
                    "dom": '"top"i',
                    // "pageLength": 5,
                    "bPaginate": false,

                    "ajax": {
                        "type" : "GET",
                        'url': base_url+"/api/grupo/horario/"+grupo_creado_id,
                        beforeSend: function () {
                            $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                        },
                        complete: function () {
                            $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                        },
                    },
                    "columns":[
                        {data: "dia"},
                        {data: "aula.aulaClave"},
                        {data: "horaInicio"},
                        {data: "horaFinal"},
                        {data: "action"}
                    ]
                });
            }
        }

        function crearTablaHorarioAdministrativo() {
            var grupo_creado_id = $('#grupo_creado_id').val();
            var claveMaestro = $('#empleado_creado_id').val();
            var periodoId = $('#periodo_id').val();

            if (claveMaestro !== "" && claveMaestro !== null && periodoId !== "" && periodoId !== null) {
                if ($.fn.DataTable.isDataTable("#tbl-horario-admivo")) {
                    $('#tbl-horario-admivo').DataTable().clear().destroy();
                }

                $('#tbl-horario-admivo').dataTable({
                    "language": {"url": base_url + "/api/lang/javascript/datatables"},
                    "serverSide": true,
                    "dom": '"top"i',
                    "bPaginate": false,
                    "ajax": {
                        "type" : "GET",
                        'url': base_url + "/api/grupo/horario_admin/" + claveMaestro + "/" + periodoId,
                        beforeSend: function () {
                            $('.preloader').fadeIn(200, function() {
                                $(this).append('<div id="preloader"></div>');
                            });
                        },
                        complete: function () {
                            $('.preloader').fadeOut(200, function() {
                                $('#preloader').remove();
                            });
                        },
                    },
                    "columns":[
                        {data: "dia"},
                        {data: "horaInicio"},
                        {data: "horaFinal"},
                    ]
                });
            }
        }
        
        $(document).on("click", ".btn-guardar", function(e) {
            e.preventDefault();
            swal({
                title: "Captura de grupo",
                text: "¿Está seguro que desea guardar a este grupo?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#0277bd',
                confirmButtonText: 'SI',
                cancelButtonText: "NO",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    postGuardarGrupo()
                    swal.close()
                } else {
                    swal.close()
                }
            });
        });

        function postGuardarGrupo () {
            $.ajax({
                data: {
                    "_token": $("meta[name=csrf-token]").attr("content"),
                    "ubicacion_id": $("#ubicacion_id").val(),
                    "departamento_id": $("#departamento_id").val(),
                    "escuela_id": $("#escuela_id").val(),
                    "periodo_id": $("#periodo_id").val(),
                    "perFechaInicial": $("#perFechaInicial").val(),
                    "perFechaFinal": $("#perFechaFinal").val(),
                    "programa_id": $("#programa_id").val(),
                    "plan_id": $("#plan_id").val(),
                    "gpoSemestre": $("#gpoSemestre").val(),
                    "gpoClave": $("#gpoClave").val(),
                    "gpoTurno": $("#gpoTurno").val(),
                    "materia_id": $("#materia_id").val(),
                    "optativa_id": $("#optativa_id").val(),
                    "gpoCupo": $("#gpoCupo").val(),
                    "gpoFechaExamenOrdinario": $("#gpoFechaExamenOrdinario").val(),
                    "gpoHoraExamenOrdinario": $("#gpoHoraExamenOrdinario").val(),
                    "empleado_id": $("#empleado_id").val(),
                    "empleado_sinodal_id": $("#empleado_sinodal_id").val(),
                    "gpoNumeroFolio": $("#gpoNumeroFolio").val(),
                    "gpoNumeroActa": $("#gpoNumeroActa").val(),
                    "gpoNumeroLibro": $("#gpoNumeroLibro").val(),
                    "programa_equivalente": $("#programa_equivalente").val(),
                    "materia_equivalente": $("#materia_equivalente").val(),
                    "plan_equivalente": $("#plan_equivalente").val(),
                    "cgt_equivalente": $("#cgt_equivalente").val(),
                    "grupo_equivalente_id": $("#grupo_equivalente_id").val(),
                    "gpoExtraCurr": $('#gpoExtraCurr').val()
                },
                type: "POST",
                dataType: "JSON",
                url: base_url + "/grupo",
            })
            .done(function( data, textStatus, jqXHR ) {
                if (data.res) {
                    $('#materia_id').val("");
                    $('#materia_id').select2().trigger('change');

                    $("#optativa_id").hide();
                    $('#optativa_id').val("");
                    $('#optativa_id').select2().trigger('change');

                    $('#gpoCupo').val("");
                    $('#gpoFechaExamenOrdinario').val("");
                    $('#gpoHoraExamenOrdinario').val("");
                    
                    $('#empleado_id').val("");
                    $('#empleado_id').select2().trigger('change');

                    $('#empleado_sinodal_id').val("");
                    $('#empleado_sinodal_id').select2().trigger('change');

                    $('#gpoNumeroFolio').val("");
                    $('#gpoNumeroActa').val("");
                    $('#gpoNumeroLibro').val("");


                    $("#grupo_creado_id").val(data.data.id);
                    $("#empleado_creado_id").val(data.data.empleado_id);
                    
                    cancelarSeleccionado()

                    
                    $("#ubicacion_id").prop( "disabled", true  );
                    $("#departamento_id").prop( "disabled", true  );
                    $("#escuela_id").prop( "disabled", true  );
                    $("#periodo_id").prop( "disabled", true  );
                    $("#perFechaInicial").prop( "disabled", true  );
                    $("#perFechaFinal").prop( "disabled", true  );
                    $("#programa_id").prop( "disabled", true  );
                    $("#plan_id").prop( "disabled", true  );
                    $("#gpoSemestre").prop( "disabled", true  );
                    $("#gpoClave").prop( "disabled", true  );
                    $("#gpoTurno").prop( "disabled", true  );


                    crearTablaHorario();
                    crearTablaHorarioAdministrativo();

                    if (data.data.grupo_equivalente_id) {
                        $(".error-equivalente-hrs").show();
                        $(".btnAgregarHorario").hide();
                    }


                    $(".form-horarios").show()
                    $(".btn-guardar").hide();

                }

                if (!data.res) {
                    console.log(data.msg)

                    if (data.existeGrupo) {
                        var html = "";
                        html += "<p style='text-align:left;'><b>GRUPO:</b> #" +  data.msg.id + "</p>"
                        html += "<p style='text-align:left;'><b>Grado-Grupo-Turno:</b> "
                            + data.msg.gpoSemestre +"-" +data.msg.gpoClave + "-" + data.msg.gpoTurno
                        + "</p>"
                        html += "<p style='text-align:left;'><b>Materia:</b>"
                            + " " + data.msg.materia.matNombre
                        + "</p>"
                        html += "<p style='text-align:left;'><b>Maestro:</b>"
                            + " " + data.msg.empleado.persona.perNombre 
                            + " " + data.msg.empleado.persona.perApellido1 
                            + " " + data.msg.empleado.persona.perApellido2
                        + "</p>"
                        html += "<p>" + "</p>"

                        swal({
                            html:true,
                            title: "El grupo ya existe", 
                            text: html,  
                            confirmButtonText: "Ok", 
                        })

                    } else {
                        var htmlErr = ""
                        $.each(data.msg, function( index, value ) {
                            htmlErr += "<p>" + value[0] + "</p>";
                        });
                        $("body").append('<div class="error message dismissible">'
                            + '<i class="material-icons status">&#xE645;</i>'
                            + '<h4>Error</h4>'
                            + htmlErr
                        +'</div>')
                        $(document).on("click", ".dismissible", function () {
                            $(this).remove()
                        })
                    }


                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                console.log(textStatus)
                console.log(jqXHR)
            });
        }





        var grupo_creado_id = $('#grupo_creado_id').val();
        var claveMaestro = $('#empleado_creado_id').val();
        var periodoId = $('#periodo_id').val();

        



        $('.btnAgregarHorario').on("click", function (e) {
            e.preventDefault()

            console.log($("#grupo_creado_id").val())
            console.log($("#empleado_creado_id").val())
            console.log($("#aula_id").val())
            console.log($("#ghDia").val())
            console.log($("#ghInicio").val())
            console.log($("#gMinInicio").val())
            console.log($("#ghFinal").val())
            console.log($("#gMinFinal").val())

            $.ajax({
                data: {
                    grupo_id: $("#grupo_creado_id").val(),
                    empleado_id: $("#empleado_creado_id").val(),
                    aula_id: $("#aula_id").val(),
                    ghDia: $("#ghDia").val(),
                    ghInicio: $("#ghInicio").val(),
                    gMinInicio: $("#gMinInicio").val(),
                    ghFinal: $("#ghFinal").val(),
                    gMinFinal: $("#gMinFinal").val(),
                    _token: $("meta[name=csrf-token]").attr("content")
                },
                type: "POST",
                dataType: "JSON",
                url: base_url + "/grupo/verificarHorasRepetidas",
            })
            .done(function( data, textStatus, jqXHR ) {
                console.log(data)
                console.log(textStatus)
                console.log(jqXHR)
                if (data.res) {
                    submitAgregarHorario()
                }
                if (!data.res) {
                    swal({
                        title: "Captura de horarios",
                        text: "El horario capturado ya existe",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#0277bd',
                        // confirmButtonText: 'SI',
                        // cancelButtonText: "NO",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    }, function(isConfirm) {
                        if (isConfirm) {
                            // submitAgregarHorario()
                            swal.close()
                        } else {
                            swal.close()
                        }
                    });
                }

            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                console.log(errorThrown)
                console.log(textStatus)
                console.log(jqXHR)
            });

        });


        function submitAgregarHorario() {
            $.ajax({
                data: {
                    grupo_id: $("#grupo_creado_id").val(),
                    aula_id: $("#aula_id").val(),
                    ghDia: $("#ghDia").val(),
                    ghInicio: $("#ghInicio").val(),
                    gMinInicio: $("#gMinInicio").val(),
                    ghFinal: $("#ghFinal").val(),
                    gMinFinal: $("#gMinFinal").val(),
                    _token: $("meta[name=csrf-token]").attr("content")
                },
                type: "POST",
                dataType: "JSON",
                url: base_url + "/grupo/agregarHorario"
            })
            .done(function( data, textStatus, jqXHR ) {
                console.log(data)
                console.log(textStatus)
                console.log(jqXHR)
                if (data.res) {
                    crearTablaHorario()
                }
                if (!data.res) {
                    crearTablaHorario()
                    swal({
                        title: "Captura de horarios",
                        text: data.msg,
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonColor: '#0277bd',
                        confirmButtonText: 'OK',
                        cancelButtonText: "NO",
                        closeOnConfirm: true,
                    });

                }
            })
            .fail(function( jqXHR, textStatus ) {
                console.log(textStatus)
                console.log(jqXHR)
            });
        }



        $(document).on("click", ".btn-delete-horario", function (e) {
            e.preventDefault()

            var horarioId = $(this).data("horario-id");
            var grupoId = $(this).data("grupo-id");

            $.get(base_url + `/grupo/eliminarHorario/${horarioId}/${grupoId}`, function(res,sta) {
                if (res.res) {
                    crearTablaHorario()
                }
            });
        })
    });
</script>



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