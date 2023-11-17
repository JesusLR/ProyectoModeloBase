@extends('layouts.dashboard')

@section('template_title')
    bachiller preinscripcion automatica
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    {{--  <a href="{{route('bachiller_asignar_grupo.index')}}" class="breadcrumb">Lista de Inscritos</a>  --}}
    <a href="{{route('bachiller.bachiller_asignar_cgt.edit')}}" class="breadcrumb">Preinscripcion automatica</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_asignar_cgt.update', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">PREINSCRIPCIÓN AUTOMATICA</span>

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
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id"
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
                            <select id="programa_id" class="browser-default validate select2" required
                                name="programa_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id" class="browser-default validate select2" required name="plan_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('cgt_id', 'CGT *', array('class' => '')); !!}
                            <select id="cgt_id" class="browser-default validate select2" required name="cgt_id"
                                style="width: 100%;">
                                {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row" id="Tabla">
                    <div class="col s12">
                        <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
                        </div>
                    </div>
                </div>


                <div id="destino" style="display: none;">
                    <h5>Período destino</h5>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id2', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id2" class="browser-default validate select2" required name="periodo_id2"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaInicial2', NULL, array('id' => 'perFechaInicial2', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaInicial2', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaFinal2', NULL, array('id' => 'perFechaFinal2', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaFinal2', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('programa_id2', 'Programa *', array('class' => '')); !!}
                            <select id="programa_id2" class="browser-default validate select2" required
                                name="programa_id2" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id2', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id2" class="browser-default validate select2" required name="plan_id2"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('cgt_id2', 'CGT *', array('class' => '')); !!}
                            <select id="cgt_id2" class="browser-default validate select2" required name="cgt_id2"
                                style="width: 100%;">
                                {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            





            <div class="card-action" style="display: none" id="boton-guardar">
                {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Cargando datos...";this.form.submit();','class' =>
                'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

  <style>
    * {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    
    body {
        font-size: 16px;
        background: #fff;
        font-family: "Roboto";
    }
    
    .wrap {
        width: 90%;
        max-width: 1000px;
        margin: 0 20px;
        /*margin: auto;*/
    }
    
    .formulario h2 {
        font-size: 16px;
        color: #001F3F;
        margin-bottom: 20px;
        margin-left: 20px;
    }
    
    .formulario > div {
        padding: 20px 0;
        border-bottom: 1px solid #ccc;
    }
  </style>
@endsection

@section('footer_scripts')


@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
@include('bachiller.scripts.periodos')
@include('bachiller.scripts.cgts')
@include('bachiller.scripts.cursos')
@include('bachiller.preinscripcion_automatica.crearTablaJs')


{{--  para cargar datos sel periodo siguiente   --}}
<script type="text/javascript">
    $(document).ready(function() {
        function obtenerEscuelas (departamentoId) {

            console.log(departamentoId)
            
            $("#periodo_id2").empty();
            $("#programa_id2").empty();
            $("#plan_id2").empty();
            $("#cgt_id2").empty();
            $("#periodo_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#programa_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#plan_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#cgt_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            
            $("#perFechaInicial2").val('');
            $("#perFechaFinal2").val('');



            $.get(base_url+`/api/escuelas/${departamentoId}`,function(res,sta){

                //seleccionar el post preservado
                var escuelaSeleccionadoOld = $("#escuela_id").data("escuela-idold")
                $("#escuela_id").empty()

                res.forEach(element => {
                    var selected = "";
                    if (element.id === escuelaSeleccionadoOld) {
                        selected = "selected";
                    }

                    $("#escuela_id").append(`<option value=${element.id} ${selected}>${element.escClave}-${element.escNombre}</option>`);
                });

                $('#escuela_id').trigger('change'); // Notify only Select2 of changes

            });

            //OBTENER PERIODOS
            $.get(base_url+`/bachiller_periodo/api/periodos/${departamentoId}`,function(res2,sta){
                var perSeleccionado;


                var periodoSeleccionadoOld = $("#periodo_id2").data("periodo-idold")

                console.log(periodoSeleccionadoOld)
                $("#periodo_id2").empty()
                res2.forEach(element => {

                    var selected = "";
                    if (element.id === periodoSeleccionadoOld) {
                        console.log("entra")
                        console.log(element.id)
                        selected = "selected";
                    }

                    $("#periodo_id2").append(`<option value=${element.id} ${selected}>${element.perNumero}-${element.perAnio}</option>`);
                });
                //OBTENER FECHA INICIAL Y FINAL DEL PERIODO SELECCIONADO
                $.get(base_url+`/bachiller_periodo/api/periodo/${perSeleccionado}`,function(res3,sta){
                    $("#perFechaInicial").val(res3.perFechaInicial);
                    $("#perFechaFinal").val(res3.perFechaFinal);
                    Materialize.updateTextFields();
                });

                $('#periodo_id2').trigger('change'); // Notify only Select2 of changes
            });//TERMINA PERIODO
        }


        $("#departamento_id").change( event => {
            obtenerEscuelas(event.target.value)
        });
     });
</script>

<script type="text/javascript">

    $(document).ready(function() {

        $("#escuela_id").change( event => {
            $("#programa_id2").empty();

            $("#plan_id2").empty();
            $("#cgt_id2").empty();
            $("#programa_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#plan_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#cgt_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        
            $.get(base_url+`/bachiller_programa/api/programas/${event.target.value}`,function(res,sta){
                //seleccionar el post preservado
                var programaSeleccionadoOld = $("#programa_id2").data("programa-idold")
                $("#programa_id2").empty()

                res.forEach(element => {
                    var selected = "";
                    if (element.id === programaSeleccionadoOld) {
                        console.log("entra")
                        console.log(element.id)
                        selected = "selected";
                    }

                    $("#programa_id2").append(`<option value=${element.id} ${selected}>${element.progClave}-${element.progNombre}</option>`);
                });

                $('#programa_id2').trigger('change'); // Notify only Select2 of changes
            });
        });

     });
</script>

<script>
    $(document).on('click', '#agregarPrograma', function (e) {
        var programa_id2 = $("#programa_id2").val();
        if(programa_id2 != "" && programa_id2 != null){
            if(recorrerProgramas(programa_id2)){
                $.get(base_url+`/bachiller_programa/api/programa/${programa_id2}`,function(res,sta){
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

    function eliminarPrograma(id) {
        $('#programa' + id).remove();
    }
</script>

<script type="text/javascript">

    $(document).ready(function() {
        // OBTENER PLANES
        $("#programa_id2").change( event => {
            $("#plan_id2").empty();

        
            $("#cgt_id2").empty();
            $("#materia_id").empty();
            $("#plan_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#cgt_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

            console.log("event.target.value")
            console.log(event.target.value)
            
            $.get(base_url+`/bachiller_plan/api/planes/${event.target.value}`,function(res,sta){
                //seleccionar el post preservado
                var planSeleccionadoOld = $("#plan_id2").data("plan-idold")
                $("#plan_id2").empty()
                
                res.forEach(element => {
                    var selected = "";
                    if (element.id === planSeleccionadoOld) {
                        console.log("entra")
                        console.log(element.id)
                        selected = "selected";
                    }


                    $("#plan_id2").append(`<option value=${element.id} ${selected}>${element.planClave}</option>`);
                });

                $('#plan_id2').trigger('change'); // Notify only Select2 of changes
            });
        });

     });
</script>

<script type="text/javascript">

    $(document).ready(function() {

        //OBTENER FECHA PERIODO
        $("#periodo_id2").change( event => {
            $("#perFechaInicial2").val('');
            $("#perFechaFinal2").val('');
            //INSCRITOS
            $("#curso_id").empty();
            $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#grupo_id").empty();
            $("#grupo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            Materialize.updateTextFields();
            $.get(base_url+`/bachiller_periodo/api/periodo/${event.target.value}`,function(res,sta){
                $("#perFechaInicial2").val(res.perFechaInicial);
                $("#perFechaFinal2").val(res.perFechaFinal);
                Materialize.updateTextFields();
            });
        });

     });
</script>

<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        $("#plan_id2").change( event => {
            var periodo_id2 = $("#periodo_id2").val();
            $("#cgt_id2").empty();
            $("#cgt_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_cgt/api/cgts/${event.target.value}/${periodo_id2}`,function(res,sta){
                res.forEach(element => {
                    $("#cgt_id2").append(`<option value=${element.id}>${element.cgtGradoSemestre}-${element.cgtGrupo}-${element.cgtTurno}</option>`);
                });
            });
        });

        // OBTENER CGTS POR PERIODO
        $("#periodo_id2").change( event => {
            var plan_id2 = $("#plan_id2").val();
            $("#cgt_id2").empty();
            $("#materia_id").empty();
            $("#cgt_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_cgt/api/cgts/${plan_id2}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#cgt_id2").append(`<option value=${element.id}>${element.cgtGradoSemestre}-${element.cgtGrupo}-${element.cgtTurno}</option>`);
                });
            });
        });

     });
</script>
@endsection