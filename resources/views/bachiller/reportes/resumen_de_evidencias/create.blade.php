@extends('layouts.dashboard')

@section('template_title')
    Reporte
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Reporte de evidencias</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'bachiller.bachiller_resumen_evidencias.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">REPORTE DE EVIDENCIAS</span>

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
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Período *', array('class' => '')); !!}
                        <select id="periodo_id"
                            data-plan-id="{{old('periodo_id')}}"
                            class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>

                <div class="row">                  
                    <div class="col s12 m6 l4">
                        {!! Form::label('matSemestreBuscar', 'Semestre *', array('class' => '')); !!}
                        <select id="matSemestreBuscar"
                            data-gposemestre-id="{{old('matSemestreBuscar')}}"
                            class="browser-default validate select2" required name="matSemestreBuscar" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('tipoDevista', 'Tipo de vista *', array('class' => '')); !!}
                        <select id="tipoDevista"
                            data-tipoDevista-id="{{old('tipoDevista')}}"
                            class="browser-default validate select2" required name="tipoDevista" style="width: 100%;">
                            <option value="1">RESUMEN DE EVIDENCIAS POR MATERIA</option>
                            <option value="2">DETALLE DE EVIDENCIA POR MATERIA</option>
                            <option value="3">PUNTOS FALTANTES A MATERIAS</option>


                        </select>
                    </div>

                    <div class="col s12 m6 l4" style="display: none;" id="materiaHidden">
                        {!! Form::label('bachiller_materia_id', 'Materia', array('class' => '')); !!}
                        <select id="bachiller_materia_id"
                            data-bachiller_materia_id-id="{{old('bachiller_materia_id')}}"
                            class="browser-default validate select2" name="bachiller_materia_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4" style="display: none;" id="materiaACDHidden">
                        {!! Form::label('bachiller_sin_con_acd', 'Materia (ACD)', array('class' => '')); !!}
                        <select id="bachiller_sin_con_acd"
                            data-bachiller_sin_con_acd-id="{{old('bachiller_sin_con_acd')}}"
                            class="browser-default validate select2" name="bachiller_sin_con_acd" style="width: 100%;">
                            <option value="SIN">SOLO MATERIAS SIN ACD</option>
                            <option value="CON">SOLO MATERIAS CON ACD</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l4" style="display: none;" id="bachiller_materiaACDHidden">
                        {!! Form::label('materia_acd_id_label', 'Materia complementaria', array('class' => '')); !!}
                        <select id="bachiller_materia_acd_id"
                            data-bachiller_materia_acd_id-id="{{old('bachiller_materia_acd_id')}}"
                            class="browser-default validate select2" name="bachiller_materia_acd_id" style="width: 100%;">
                        </select>
                    </div>
                </div>



          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR PDF', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
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
@include('bachiller.reportes.resumen_de_evidencias.getMateria')
@include('bachiller.reportes.resumen_de_evidencias.getMateriaACD')

<script type="text/javascript">
    $(document).ready(function() {
        // OBTENER PLANES
        $("#periodo_id").change(event => {
    
            $("#matSemestreBuscar").empty();
            $("#matSemestreBuscar").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
    
    
            $.get(base_url + `/bachiller_api/obtenerNumerosSemestre/${event.target.value}`, function(res, sta) {
                //seleccionar el post preservado
                var semestreOld = $("#matSemestreBuscar").data("gposemestre-id")
    
                res.forEach(element => {
                    var selected = "";
                    if (element.semestre === semestreOld) {
                        selected = "selected";
                    }
    
    
                    $("#matSemestreBuscar").append(`<option value=${element.semestre} ${selected}>${element.semestre}</option>`);
                });
    
            });
        });
    
    
    });
</script>

<script type="text/javascript">

    $(document).ready(function() {
       

        $("#tipoDevista").change(function(){
            if($('select[id=tipoDevista]').val() == "1"){
                $("#materiaHidden").hide();
                $("#materiaACDHidden").hide();
                $("#bachiller_materiaACDHidden").hide();
            }
            if($('select[id=tipoDevista]').val() == "2"){
                $("#materiaHidden").show();
                $("#materiaACDHidden").show();
            }

            if($('select[id=tipoDevista]').val() == "3"){
                $("#materiaHidden").hide();
                $("#materiaACDHidden").hide();
                $("#bachiller_materiaACDHidden").hide();
            }
	    });


        $("#bachiller_materia_id").change(function(){
            if($('select[id=bachiller_materia_id]').val() != ""){                
                $("#materiaACDHidden").hide();
                $("#bachiller_materiaACDHidden").show();
            }else{
                $("#materiaACDHidden").show();
                $("#bachiller_materiaACDHidden").hide();
            }
            
	    });
     });
</script>


@endsection