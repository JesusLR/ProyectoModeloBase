@extends('layouts.dashboard')

@section('template_title')
    Bachiller evidencia
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_evidencias')}}" class="breadcrumb">Lista de evidencias</a>
    <label class="breadcrumb">Agregar evidencia</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_evidencias.storeCopiarSemestre', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR EVIDENCIA</span>

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
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-id="{{old('departamento_id')}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-id="{{old('escuela_id')}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Período *', array('class' => '')); !!}
                        <select id="periodo_id"
                            data-plan-id="{{old('periodo_id')}}"
                            class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-id="{{old('programa_id')}}"
                            class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-id="{{old('plan_id')}}"
                            class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>                  
                    
                </div>

                <div class="row">                  
                    <div class="col s12 m6 l4">
                        {!! Form::label('MateriaSemestre', 'Semestre *', array('class' => '')); !!}
                        <select id="MateriaSemestre" class="browser-default validate select2" required name="MateriaSemestre" style="width: 100%;">
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                         
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('materia_id', 'Materia *', array('class' => '')); !!}
                        <select id="materia_id"
                            data-plan-id="{{old('materia_id')}}"
                            class="browser-default validate select2" required name="materia_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        <label for="materia_acd_id" id="materia_acd_id_label">Materia asignatura</label>
                        <select id="materia_acd_id" disabled data-materia-acd-id="{{old('materia_acd_id')}}"
                            class="browser-default validate select2" name="materia_acd_id" style="width: 100%;">                            
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="materia_acd_id_destino" id="materia_acd_id_destino_label">Materia asignatura destino</label>
                        <select multiple id="materia_acd_id_destino" disabled data-materia-acd-destino-id="{{old('materia_acd_id_destino')}}"
                            class="browser-default validate select2" name="materia_acd_id_destino[]" required>                            
                        </select>
                    </div>
                </div>

               {{--  <div class="row">
                <div class="col s12 m6 l4">
                    <select multiple>
                      <option value="" disabled selected>Choose your option</option>
                      <option value="1">Option 1</option>
                      <option value="2">Option 2</option>
                      <option value="3">Option 3</option>
                    </select>
                    <label>Materialize Multiple Select</label>
                  </div>
               </div>  --}}


          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
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
@include('bachiller.evidencias.getMateriasBase')
@include('bachiller.evidencias.getMateriasACDBase')
@include('bachiller.evidencias.getMateriasACDDestino')

<script type="text/javascript">
    $(document).ready(function() {
        // OBTENER PLANES
        $("#periodo_id").change(event => {
    
            $("#MateriaSemestre").empty();
            $("#MateriaSemestre").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
    
    
            $.get(base_url + `/bachiller_api/obtenerNumerosSemestre/${event.target.value}`, function(res, sta) {
                //seleccionar el post preservado
                var semestreOld = $("#MateriaSemestre").data("MateriaSemestre-id")
    
                res.forEach(element => {
                    var selected = "";
                    if (element.semestre === semestreOld) {
                        selected = "selected";
                    }
    
    
                    $("#MateriaSemestre").append(`<option value=${element.semestre} ${selected}>${element.semestre}</option>`);
                });
    
            });
        });
    });
</script>



@endsection