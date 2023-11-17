@extends('layouts.dashboard')

@section('template_title')
    Optativa
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('optativa')}}" class="breadcrumb">Lista de optativas</a>
    <label class="breadcrumb">Editar optativa</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['optativa.update', $optativa->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR OPTATIVA #{{$optativa->id}}</span>

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
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$optativa->materia->plan->programa->escuela->departamento->ubicacion_id}}" selected >{{$optativa->materia->plan->programa->escuela->departamento->ubicacion->ubiClave}}-{{$optativa->materia->plan->programa->escuela->departamento->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" data-departamento-id="{{$optativa->materia->plan->programa->escuela->departamento_id}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" data-escuela-id="{{$optativa->materia->plan->programa->escuela_id}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-id="{{$optativa->materia->plan->programa_id}}"
                            class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option  selected >{{$optativa->materia->plan->programa->progClave}}-{{$optativa->materia->plan->programa->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', ['class' => '']); !!}
                        <select id="plan_id" class="browser-default validate select2"
                            data-plan-id="{{$optativa->materia->plan_id}}"
                            required name="plan_id" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 ">
                        {!! Form::label('materia_id', 'Materia *', array('class' => '')); !!}
                        <select id="materia_id"
                            data-materia-id="{{$optativa->materia->id}}"
                            class="browser-default validate select2" required name="materia_id" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('optNumero', $optativa->optNumero, array('id' => 'optNumero', 'class' => 'validate','required','min'=>'0','max'=>'99','onKeyPress="if(this.value.length==2) return false;"')) !!}
                            {!! Form::label('optNumero', 'Número de Optativa *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m8">
                        <div class="input-field">
                            {!! Form::text('optNombre', $optativa->optNombre, array('id' => 'optNombre', 'class' => 'validate','required','maxlength'=>'78')) !!}
                            {!! Form::label('optNombre', 'Nombre optativa *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('optClaveEspecifica', $optativa->optClaveEspecifica, array('id' => 'optClaveEspecifica', 'class' => 'validate','required','maxlength'=>'25')) !!}
                            {!! Form::label('optClaveEspecifica', 'Clave específica *', array('class' => '')); !!}
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
        function obtenerDepartamentos(ubicacionId) {
            $("#departamento_id").empty();
            $("#escuela_id").empty();
            $("#programa_id").empty();
            $("#plan_id").empty();
            $("#cgt_id").empty();
            $("#materia_id").empty();
            $("#departamento_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);


            $.get(base_url+`/api/departamentos/${ubicacionId}`, function(res,sta) {

                //seleccionar el post preservado
                var departamentoId = $("#departamento_id").data("departamento-id")
                $("#departamento_id").empty()
                res.forEach(element => {
                    var selected = "";
                    if (element.id === departamentoId) {
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


<script type="text/javascript">
    $(document).ready(function() {
        function obtenerEscuelas (departamentoId) {

            $("#escuela_id").empty();
            $("#programa_id").empty();
            $("#plan_id").empty();
            $("#materia_id").empty();
            $("#escuela_id").append(`<option value="" selected  disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#programa_id").append(`<option value="" selected  disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#plan_id").append(`<option value="" selected  disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected  disabled>SELECCIONE UNA OPCIÓN</option>`);
            

            $.get(base_url+`/api/escuelas/${departamentoId}`,function(res,sta){
                //seleccionar el post preservado
                var escuelaId = $("#escuela_id").data("escuela-id")
                $("#escuela_id").empty()

                res.forEach(element => {
                    var selected = "";
                    if (element.id === escuelaId) {

                        selected = "selected";
                    }

                    $("#escuela_id").append(`<option value=${element.id} ${selected}>${element.escClave}-${element.escNombre}</option>`);
                });

                $('#escuela_id').trigger('change'); // Notify only Select2 of changes
            });
        }


        $("#departamento_id").change( event => {
            obtenerEscuelas(event.target.value)
        });
     });
</script>

<script type="text/javascript">

    $(document).ready(function() {

        $("#escuela_id").change( event => {
            $("#programa_id").empty();
            $("#plan_id").empty();
            $("#materia_id").empty();
            $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        
            $.get(base_url+`/api/programas/${event.target.value}`,function(res,sta){
                //seleccionar el post preservado
                var programaId = $("#programa_id").data("programa-id")
                $("#programa_id").empty()

                res.forEach(element => {
                    var selected = "";
                    if (element.id === programaId) {
                        selected = "selected";
                    }

                    $("#programa_id").append(`<option value=${element.id} ${selected}>${element.progNombre}</option>`);
                });

                $('#programa_id').trigger('change'); // Notify only Select2 of changes
            });
        });

     });
</script>

<script type="text/javascript">

    $(document).ready(function() {
        // OBTENER PLANES
        $("#programa_id").change( event => {
            $("#plan_id").empty();
            $("#materia_id").empty();
            $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

            
            $.get(base_url+`/api/planes/${event.target.value}`,function(res,sta){
                //seleccionar el post preservado
                var planId = $("#plan_id").data("plan-id")
                $("#plan_id").empty()
                
                res.forEach(element => {
                    var selected = "";
                    if (element.id === planId) {
                        console.log("SELECCIONADO")
                        console.log(element.id)
                        selected = "selected";
                    }

                    $("#plan_id").append(`<option value=${element.id} ${selected}>${element.planClave}</option>`);
                });

                $('#plan_id').trigger('change'); // Notify only Select2 of changes
            });
        });

     });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        // OBTENER MATERIAS OPTATIVAS POR CGT
        $("#plan_id").change( event => {
            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

            var materiaId = $("#materia_id").data("materia-id")
            $.get(base_url + `/api/materiasOptativas/${event.target.value}`, function(res, sta) {
                res.forEach(element => {
                    var selected = "";
                    if (element.id === materiaId) {
                        console.log(element.matNombre)
                        selected = "selected";
                    }
                    $("#materia_id").append(`<option value=${element.id} ${selected}>${element.matClave} - ${element.matNombre}</option>`);
                });
            });
        });

    });
</script>

@endsection