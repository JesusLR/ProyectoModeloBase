@extends('layouts.dashboard')

@section('template_title')
    Curso
@endsection

@section('head')
@endsection

@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Lista de Preinscripción</a>
    <a href="{{url('idiomas_curso/'.$curso->id.'/edit')}}" class="breadcrumb">Editar preinscripción</a>
@endsection

@section('content')
@php
    use App\Models\User;
@endphp

<div class="row">
    <div class="col s12 ">
        {{ Form::open(['enctype' => 'multipart/form-data', 'method'=>'PUT','route' => ['curso_idiomas.update', $curso->id]]) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR PREINSCRIPCIÓN #{{$curso->id}} <span style="color:#3F6D9F;">{{ $esAlumnoMensaje }}</span></span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                    <li class="tab"><a class="active" href="#general">General</a></li>
                    <li class="tab"><a href="#cuotas">Cuotas</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Campus *', ['class' => '']); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$curso->ubicacion_id}}" selected >{{$curso->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', ['class' => '']); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$curso->departamento_id}}" selected >{{$curso->depNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', ['class' => '']); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$curso->escuela_id}}" selected >{{$curso->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', ['class' => '']); !!}
                        <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="{{$curso->perNumero.'-'.$curso->perAnio}}">{{$curso->perNumero ." - ".$curso->perAnio}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', $curso->perFechaInicial, ['id' => 'perFechaInicial', 'class' => 'validate','readonly']) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', $curso->perFechaFinal, ['id' => 'perFechaFinal', 'class' => 'validate','readonly']) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', ['class' => '']); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$curso->programa_id }}">{{$curso->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', ['class' => '']); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$curso->plan_id}}">{{$curso->planClave}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cgt_id', 'Grupos *', ['class' => '']); !!}
                        <select id="cgt_id" class="browser-default validate select2" required name="cgt_id" style="width: 100%;">
                            <option value="{{$curso->gpoGrado.'-'.$curso->gpoClave.'-'.$curso->gpoDescripcion}}">
                                {{$curso->gpoGrado.'-'.$curso->gpoClave.'-'.$curso->gpoDescripcion}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m8">
                        {!! Form::label('alumno_id', 'Alumno *', ['class' => '']); !!}
                        <select id="alumno_id" class="browser-default validate select2" required name="alumno_id" style="width: 100%;">
                            <option value="{{$curso->alumno_id}}">
                                {{$curso->perNombre}}
                                {{$curso->perApellido1}}
                                {{$curso->perApellido2}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('curEstado', 'Estado del curso *', ['class' => '']); !!}
                        <select name="curEstado" id="curEstado" required class="browser-default validate select2" style="width: 100%;">
                            @foreach($estadoCurso as $key => $value)
                                <option value="{{$key}}" @if($curso->curEstado == $key) {{ 'selected' }} @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- CUOTAS BAR--}}
            <div id="cuotas">
                <div class="row">
                <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('curImporteInscripcion', $curso->curImporteInscripcion, ['id' => 'curImporteInscripcion', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"']) !!}
                        {!! Form::label('curImporteInscripcion', 'Importe inscripción', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('curImporteMensualidad', $curso->curImporteMensualidad, ['id' => 'curImporteMensualidad', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"']) !!}
                        {!! Form::label('curImporteMensualidad', 'Importe mensual', ['class' => '']); !!}
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



@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $("#ubicacion_id").change( event => {
            $("#departamento_id").empty();
            $("#escuela_id").empty();
            $("#periodo_id").empty();
            $("#programa_id").empty();
            $("#plan_id").empty();
            $("#cgt_id").empty();
            $("#materia_id").empty();
            $("#departamento_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#periodo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

            $("#perFechaInicial").val('');
            $("#perFechaFinal").val('');
            $.get(base_url+`/api/departamentos/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#departamento_id").append(`<option value=${element.id}>${element.depClave}-${element.depNombre}</option>`);
                });
            });
        });
     });
</script>


<script type="text/javascript">
    $(document).ready(function() {

        $("#departamento_id").change( event => {
            $("#escuela_id").empty();
            $("#periodo_id").empty();
            $("#programa_id").empty();
            $("#plan_id").empty();
            $("#cgt_id").empty();
            $("#materia_id").empty();
            $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#periodo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#perFechaInicial").val('');
            $("#perFechaFinal").val('');
            $.get(base_url+`/api/escuelas/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#escuela_id").append(`<option value=${element.id}>${element.escClave}-${element.escNombre}</option>`);
                });
            });
            $.get(base_url+`/api/periodos/${event.target.value}`,function(res2,sta){
                var perSeleccionado;
                res2.forEach(element => {
                    $("#periodo_id").append(`<option value=${element.id}>${element.perNumero}-${element.perAnio}</option>`);
                });
                //OBTENER FECHA INICIAL Y FINAL DEL PERIODO SELECCIONADO
                $.get(base_url+`/api/periodo/${perSeleccionado}`,function(res3,sta){
                    $("#perFechaInicial").val(res3.perFechaInicial);
                    $("#perFechaFinal").val(res3.perFechaFinal);
                    Materialize.updateTextFields();
                });
            });//TERMINA PERIODO
        });

     });
</script>

<script type="text/javascript">

    $(document).ready(function() {

        $("#escuela_id").change( event => {
            $("#programa_id").empty();
            $("#plan_id").empty();
            $("#cgt_id").empty();
            $("#materia_id").empty();
            $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/api/programas/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#programa_id").append(`<option value=${element.id}>${element.progNombre}</option>`);
                });
            });
        });

     });
</script>

<script>
    $(document).on('click', '#agregarPrograma', function (e) {
        var programa_id = $("#programa_id").val();
        if(programa_id != "" && programa_id != null){
            if(recorrerProgramas(programa_id)){
                $.get(base_url+`/api/programa/${programa_id}`,function(res,sta){
                $("#seccion-programas").show();
                $('#tbl-programas> tbody:last-child').append(`<tr id="programa${res.id}">
                        <td>${res.escuela.escNombre}</td>
                        <td>${res.progClave}</td>
                        <td>${res.progNombre}</td>
                        <td><input name="programas[${res.id}]" type="hidden" value="${res.id}" readonly="true"/>
                        <a href="javascript:;" onclick="eliminarPrograma(${res.id})" class="button button--icon js-button js-ripple-effect" title="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                        </td>
                    </tr>`);
                });
            }else{
                swal({
                    title: "Ups...",
                    text: "El programa ya se encuentra agregado",
                    type: "warning",
                    confirmButtonText: "Ok",
                    confirmButtonColor: '#3085d6',
                    showCancelButton: false
                });
            }
        }else{
            swal({
                title: "Ups...",
                text: "Debes seleccionar al menos un programa",
                type: "warning",
                confirmButtonText: "Ok",
                confirmButtonColor: '#3085d6',
                showCancelButton: false
            });
        }
    });

    function recorrerProgramas(id){
        encontro = true;
        $('#tbl-programas tr').each(function() {
            if(this.id == 'programa'+id){
                encontro = false;
                return false;
            }
        });
        return encontro;
    }

    function eliminarPrograma(id){
        $('#programa'+id).remove();
    }
</script>

<script type="text/javascript">

    $(document).ready(function() {
        // OBTENER PLANES
        $("#programa_id").change( event => {
            $("#plan_id").empty();
            $("#cgt_id").empty();
            $("#materia_id").empty();
            $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/api/planes/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#plan_id").append(`<option value=${element.id}>${element.planClave}</option>`);
                });
            });
        });

     });
</script>

<script type="text/javascript">

    $(document).ready(function() {

        //OBTENER FECHA PERIODO
        $("#periodo_id").change( event => {
            $("#perFechaInicial").val('');
            $("#perFechaFinal").val('');
            //INSCRITOS
            $("#curso_id").empty();
            $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#grupo_id").empty();
            $("#grupo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            Materialize.updateTextFields();
            $.get(base_url+`/api/periodo/${event.target.value}`,function(res,sta){
                $("#perFechaInicial").val(res.perFechaInicial);
                $("#perFechaFinal").val(res.perFechaFinal);
                Materialize.updateTextFields();
            });
        });

     });
</script>

<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            $("#cgt_id").empty();
            $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/api/cgts/${event.target.value}/${periodo_id}`,function(res,sta){
                res.forEach(element => {
                    $("#cgt_id").append(`<option value=${element.id}>${element.cgtGradoSemestre}-${element.cgtGrupo}-${element.cgtTurno}</option>`);
                });
            });
        });

        // OBTENER CGTS POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            $("#cgt_id").empty();
            $("#materia_id").empty();
            $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/api/cgts/${plan_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#cgt_id").append(`<option value=${element.id}>${element.cgtGradoSemestre}-${element.cgtGrupo}-${element.cgtTurno}</option>`);
                });
            });
        });

     });
</script>

<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER MATERIAS POR SEMESTRE SELECCIONADO
        $("#gpoSemestre").change( event => {
            var plan_id = $("#plan_id").val();
            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/api/materias/${event.target.value}/${plan_id}`,function(res,sta){
                res.forEach(element => {
                    $("#materia_id").append(`<option value=${element.id}>${element.matClave}-${element.matNombre}</option>`);
                });
            });
        });

     });
</script>


@endsection
