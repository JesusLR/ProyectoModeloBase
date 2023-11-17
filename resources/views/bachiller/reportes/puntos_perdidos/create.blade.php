@extends('layouts.dashboard')

@section('template_title')
    Reporte
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Reporte de puntos perdidos</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'bachiller.bachiller_puntos_perdidos.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">RESUMEN DE PUNTOS PERDIDOS</span>

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
                        {!! Form::label('matSemestreReporte', 'Grado *', array('class' => '')); !!}
                        <select id="matSemestreReporte"
                            data-gposemestre-id="{{old('matSemestreReporte')}}"
                            class="browser-default validate select2" required name="matSemestreReporte" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('claveGrupo', NULL, array('id' => 'claveGrupo', 'class' => 'validate','maxlength'=>'3', 'onkeypress' => 'sonLetrasSolamente')) !!}
                            {!! Form::label('claveGrupo', 'Grupo *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('vistaDelReporte', 'Materias a mostrar *', array('class' => '')); !!}
                        <select id="vistaDelReporte"
                            data-escuela-id="{{old('vistaDelReporte')}}"
                            class="browser-default validate select2" required name="vistaDelReporte" style="width: 100%;" required>
                            <option value="1">NO COMPLEMENTARIAS</option>
                            <option value="2">COMPLEMENTARIAS</option>
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
{{--  @include('bachiller.reportes.resumen_de_evidencias.getMateria')
@include('bachiller.reportes.resumen_de_evidencias.getMateriaACD')  --}}

<script type="text/javascript">
    $(document).ready(function() {
        // OBTENER PLANES
        $("#periodo_id").change(event => {
    
            $("#matSemestreReporte").empty();
            $("#matSemestreReporte").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
    
    
            $.get(base_url + `/bachiller_api/obtenerNumerosSemestre/${event.target.value}`, function(res, sta) {
                //seleccionar el post preservado
                var semestreOld = $("#matSemestreReporte").data("gposemestre-id")
    
                res.forEach(element => {
                    var selected = "";
                    if (element.semestre === semestreOld) {
                        selected = "selected";
                    }
    
    
                    $("#matSemestreReporte").append(`<option value=${element.semestre} ${selected}>${element.semestre}</option>`);
                });
    
            });
        });    
    });
</script>

<script type="text/javascript">

    $(document).ready(function() {
       
        //Para que solo permita letras 
        $('#claveGrupo').keypress(function (e) {
            var tecla = document.all ? tecla = e.keyCode : tecla = e.which;
            return !((tecla > 47 && tecla < 58) || tecla == 46);
        });

      
     });
</script>


@endsection