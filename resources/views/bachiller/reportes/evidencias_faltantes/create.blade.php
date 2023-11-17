@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Reporte de evidencias faltantes</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_evidencias_faltantes.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">REPORTE DE EVIDENCIAS FALTANTES</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="filtros">

                @php
                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                @endphp

                

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('curEstado', 'Ubicación*', ['class' => '']); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @php
                                    $selected = '';
      
                                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                    if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                                        echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                    } else {
                                        if ($ubicacion->id == old("ubicacion_id")) {
                                            $selected = 'selected';
                                        }
      
                                        echo '<option value="'.$ubicacion->id.'" '. $selected .'>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                    }
                                @endphp
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="departamento_id">Departamento*</label>
                        <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="escuela_id">Escuela *</label>
                        <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>                    
                </div>

                <div class="row">                    
                    <div class="col s12 m6 l4">
                        <label for="programa_id">Programa *</label>
                        <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="plan_id">Plan *</label>
                        <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="periodo_id">Período *</label>
                        <select name="periodo_id" id="periodo_id" data-escuela-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {{--  <div class="input-field col s12 m6 l6">
                            {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' => 'validate','min'=>'0')) !!}
                            {!! Form::label('cgtGradoSemestre', 'Semestre', array('class' => '')); !!}
                        </div>  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('cgtGradoSemestreBuscar', 'Semestre', array('class' => '')); !!}
                            <select id="cgtGradoSemestreBuscar" data-gposemestre-id="{{old('cgtGradoSemestreBuscar')}}"
                                class="browser-default validate select2" name="cgtGradoSemestreBuscar" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate', 'maxlength'=>2)) !!}
                            {!! Form::label('cgtGrupo', 'Grupo', array('class' => '')); !!}
                        </div>
                    </div>

                    {{--  <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate')) !!}
                            {!! Form::label('matClave', 'Clave materia', array('class' => '')); !!}
                        </div>
                    </div>  --}}

                    <div class="col s12 m6 l4">
                        <label for="matClave">Materia</label>
                        <select class="browser-default validate select2" data-plan-id="{{old('matClave')}}" name="matClave" id="matClave" style="width:100%;">
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('docente_id', NULL, array('id' => 'docente_id', 'class' => 'validate')) !!}
                            {!! Form::label('docente_id', 'Clave empleado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                

            
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>


@endsection


@section('footer_scripts')
@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_periodos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')

<script type="text/javascript">
    $(document).ready(function() {
        // OBTENER PLANES
        $("#periodo_id").change(event => {
    
            $("#cgtGradoSemestreBuscar").empty();
            $("#cgtGradoSemestreBuscar").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
    
    
            $.get(base_url + `/bachiller_api/obtenerNumerosSemestre/${event.target.value}`, function(res, sta) {
                //seleccionar el post preservado
                var semestreOld = $("#cgtGradoSemestreBuscar").data("cgtGradoSemestreBuscar-id")
    
                res.forEach(element => {
                    var selected = "";
                    if (element.semestre === semestreOld) {
                        selected = "selected";
                    }
    
    
                    $("#cgtGradoSemestreBuscar").append(`<option value="${element.semestre}" ${selected}>${element.semestre}</option>`);
                });
    
            });
        });
    
    
    });
</script>


<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var cgtGradoSemestreBuscar = $("#cgtGradoSemestreBuscar").val();

            $.get(base_url+`/api/reporte/bachiller_evidencias_faltantes/${periodo_id}/${event.target.value}/${cgtGradoSemestreBuscar}`,function(res,sta){

                if(res.length > 0){
                    $("#matClave").empty();
                    $("#matClave").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {
                        $("#matClave").append(`<option value="${element.matClave}">${element.matClave}-${element.matNombre}</option>`);
                    });
                }else{
                    $("#matClave").empty();
                    $("#matClave").append(`<option value="">AUN NO HAY MATERIAS CARGADAS PARA EL PERIODO SELECCIONADO</option>`);
                }
                
            });

            
        });

        // OBTENER CGTS POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var cgtGradoSemestreBuscar = $("#cgtGradoSemestreBuscar").val();

            $.get(base_url+`/api/reporte/bachiller_evidencias_faltantes/${event.target.value}/${plan_id}/${cgtGradoSemestreBuscar}`,function(res,sta){
                if(res.length > 0){
                    $("#matClave").empty();
                    $("#matClave").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {
                        $("#matClave").append(`<option value="${element.matClave}">${element.matClave}-${element.matNombre}</option>`);
                    });
                }else{
                    $("#matClave").empty();
                    $("#matClave").append(`<option value="">AUN NO HAY MATERIAS CARGADAS PARA EL PERIODO SELECCIONADO</option>`);
                }
            });
            
            
        });

        $("#cgtGradoSemestreBuscar").change( event => {
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            
            $.get(base_url+`/api/reporte/bachiller_evidencias_faltantes/${periodo_id}/${plan_id}/${event.target.value}`,function(res,sta){
                if(res.length > 0){
                    $("#matClave").empty();
                    $("#matClave").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {
                        $("#matClave").append(`<option value="${element.matClave}">${element.matClave}-${element.matNombre}</option>`);
                    });
                }else{
                    $("#matClave").empty();
                    $("#matClave").append(`<option value="">AUN NO HAY MATERIAS CARGADAS PARA EL PERIODO SELECCIONADO</option>`);
                }
            });
        });

     });
</script>
@endsection