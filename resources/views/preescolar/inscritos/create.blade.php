@extends('layouts.dashboard')

@section('template_title')
    Inscrito
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('PreescolarInscritos.index')}}" class="breadcrumb">Lista de Inscritos</a>
    <a href="{{route('PreescolarInscritos.create')}}" class="breadcrumb">Agregar Inscrito</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'PreescolarInscritos.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">INSCRIBIR POR MATERIA</span>

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
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
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
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
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
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cgt_id', 'CGT *', array('class' => '')); !!}
                        <select id="cgt_id" class="browser-default validate select2" required name="cgt_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 ">
                        {!! Form::label('curso_id', 'Alumno preinscrito *', array('class' => '')); !!}
                        <select id="curso_id" class="browser-default validate select2" required name="curso_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 ">
                        {!! Form::label('grupo_id', 'Grupo-Materia *', array('class' => '')); !!}
                        <select id="grupo_id" class="browser-default validate select2" required name="grupo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
            </div>
          </div>


          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['onclick'=>'this.disabled=true;this.innerText="Cargando datos...";this.form.submit();','class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

@include('scripts.preferencias')
{{--  @include('scripts.departamentos')  --}}
@include('scripts.escuelas')
@include('scripts.programas')
@include('scripts.planes')
@include('scripts.periodos')
@include('scripts.cgts')
@include('scripts.cursos')
{{--  @include('scripts.inscritos')  --}}

<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER GRUPOS POR ALUMNO PREINSCRITO SELECCIONADO
        $("#curso_id").change( event => {
            $("#grupo_id").empty();
            $("#grupo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/inscritosMateria/grupos/${event.target.value}`, function(res, sta) {

                res.forEach(element => {
                    if (!element.optNombre) {
                     
                        $("#grupo_id").append(`<option value=${element.id}>
                            Grupo: ${element.gpoGrado}-${element.gpoClave}-${element.gpoTurno}
                            Materia: ${element.matClave}-${element.matNombre}
                            Maestro:${element.empleadoId}-${element.perNombre} ${element.perApellido1} ${element.perApellido2}
                        </option>`);
                    }

                    if (element.optNombre) {
                   
                        $("#grupo_id").append(`<option value=${element.id}>
                            Grupo: ${element.gpoGrado}-${element.gpoClave}-${element.gpoTurno}
                            Materia: ${element.matClave}-${element.matNombre}-${element.optNombre}
                            Maestro:${element.empleadoId}-${element.perNombre} ${element.perApellido1} ${element.perApellido2}
                        </option>`);
                    }

                });
            });
        });

     });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        function obtenerDepartamentos(ubicacionId) {
            console.log(ubicacionId);

            console.log("aqui")

            //$("#departamento_id option[value='"13"']").attr("selected",true);


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

            $.get(base_url+`/api/departamentos/${ubicacionId}`, function(res,sta) {

                //seleccionar el post preservado
                //var departamentoSeleccionadoOld = $("#departamento_id").data("departamento-idold")
                $("#departamento_id").empty()
                res.forEach(element => {
                    var selected = "";
                    if (element.id === 13) {
                        console.log("entra")
                        console.log(element.id)
                        selected = "selected";
                    }

                    $("#departamento_id").append(`<option value=${element.id} ${selected}>${element.depClave}-${element.depNombre}</option>`);
                });
                $('#departamento_id').trigger('change'); // Notify only Select2 of changes
            });
        }
        
        obtenerDepartamentos($("#ubicacion_id").val())
        $("#ubicacion_id").change( event => {
            obtenerDepartamentos(event.target.value)
        });
     });
</script>

@endsection