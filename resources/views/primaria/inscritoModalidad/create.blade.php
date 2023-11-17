@extends('layouts.dashboard')

@section('template_title')
    Primaria inscrito modalidad
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria.primaria_inscrito_modalidad.index')}}" class="breadcrumb">Inscrito modalidad</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'primaria.primaria.primaria_inscrito_modalidad.guardarInscritosModalidad', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">CAMBIAR INSCRITO MODALIDAD</span>

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
                            {!! Form::label('primaria_grupo_id', 'Grupo materia asignatura *', array('class' => '')); !!}
                            <select id="primaria_grupo_id" class="browser-default validate select2" required name="primaria_grupo_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col s12 m6 l12">
                            <button type="button" id="buscarInscritosMaterias" class="btn-large waves-effect  darken-3"><i class="material-icons left">search</i> Buscar</button>
                        </div>
                    </div>

                </div>

                <div class="row" id="Tabla">
                    <div class="col s12">
                        <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4" style="display: none;" id="divEmpleado">
                        {!! Form::label('inscEmpleadoIdDocente', 'Docente *', array('class' => '')); !!}
                        <select id="inscEmpleadoIdDocente" class="browser-default validate select2" required name="inscEmpleadoIdDocente" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach ($empleados as $empleado)
                                <option value="{{$empleado->id}}">{{$empleado->empApellido1.' '.$empleado->empApellido2.' '.$empleado->empNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            

            <div class="card-action" style="display: none" id="boton-guardar">
                <button onclick="alerta();" id="btn-guardar-inscritos-modalidad" class="btn-large btn-save waves-effect darken-3" type="submit"><i class="material-icons left">save</i> Guardar</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<style>
    table tbody tr:nth-child(odd) {
        background: #F7F8F9;
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

    .checkbox-warning-filled [type="checkbox"][class*='filled-in']:checked+label:after {
        border-color: #01579B;
        background-color: #01579B;
        position:absolute;
      }  

    .hoverTable{
        width:100%; 
        border-collapse:collapse; 
    }
  
  
    /* Define the hover highlight color for the table row */
    .hoverTable tr:hover {
          background-color: #BFC2C3;
    }
</style>
@endsection

@section('footer_scripts')

<script>
    function alerta(){

        if($("#inscEmpleadoIdDocente").val() == ""){
            swal("Seleccione el docente ha asignar", "warning");
        }else{
            $.ajax({type: 'POST', url: "{{route('primaria.primaria.primaria_inscrito_modalidad.guardarInscritosModalidad')}}",
            beforeSend: function (xhr) {
    
                if(xhr){
                    var html = "";
                    html += "<div class='preloader-wrapper big active'>"+
                        "<div class='spinner-layer spinner-blue-only'>"+
                          "<div class='circle-clipper left'>"+
                            "<div class='circle'></div>"+
                          "</div><div class='gap-patch'>"+
                            "<div class='circle'></div>"+
                          "</div><div class='circle-clipper right'>"+
                            "<div class='circle'></div>"+
                          "</div>"+
                        "</div>"+
                      "</div>";
        
                    html += "<p>" + "</p>"
        
                    swal({
                        html:true,
                        title: "Guardando...",
                        text: html,
                        showConfirmButton: false
                        //confirmButtonText: "Ok",
                    })
                }
                
            },
            success: function (data, textStatus, jqXHR) {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //en caso de error
            }
        }        
    });
    }
</script>


@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas')
@include('primaria.scripts.programas')
@include('primaria.scripts.planes')
@include('primaria.scripts.periodos')
@include('primaria.scripts.obtenerMateriasAsignaturas')
@include('primaria.scripts.cursos')
@include('primaria.inscritoModalidad.createTable')


@endsection
