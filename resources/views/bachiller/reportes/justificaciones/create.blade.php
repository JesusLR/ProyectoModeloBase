@extends('layouts.dashboard')

@section('template_title')
    Bachiller Justificaciones
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_justificaciones.index')}}" class="breadcrumb">Lista justificaciones</a>
    <a href="" class="breadcrumb">Crear justificacion</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_justificaciones.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">JUSTIFICACIONES</span>

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
                        <label for="periodo_id">Período *</label>
                        <select name="periodo_id" id="periodo_id" data-escuela-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
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
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="curso_id">Alumno *</label>
                        <select name="curso_id" id="curso_id" data-escuela-id="{{old('curso_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA ALUMNO</option>
                        </select>
                    </div>

                
                    <div class="col s12 m6 l4">
                        <label for="">Razón de la falta</label>
                        <br>
                        <div class="col s12 m6 l6">
                            <div style="position:relative;">
                                <input type="radio" class="noUpperCase"  checked name="razonFalta" id="enfermedad" value="Enfermedad">
                                <label for="enfermedad">Enfermedad</label>
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            <div style="position:relative;">
                                <input type="radio" class="noUpperCase" name="razonFalta" id="motivosPersonales" value="Motivos personales">
                                <label for="motivosPersonales">Motivos personales</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="col s12 m6 l6">
                                {!! Form::label('fechaInicio', 'Fecha de inicio *', array('class' => '')); !!}
                                {!! Form::date('fechaInicio', NULL, array('id' => 'fechaInicio', 'class' => 'validate','min'=>'0', 'onchange' => 'recuperarFecha()', 'required')) !!}
                            </div>
                            <div class="col s12 m6 l6">
                                {!! Form::label('fechaFin', 'Fecha de fin *', array('class' => '')); !!}
                                {!! Form::date('fechaFin', NULL, array('id' => 'fechaFin', 'class' => 'validate', 'maxlength'=>2, 'required')) !!}
                            </div>
                        </div>
                    </div>
                </div>

            
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> GUARDAR', ['class' => 'btn-large btn-guardar waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}

        @if (\Session::has('success'))
            <input type="hidden" value="{!! Session::has('msg') ? Session::get("msg") : '' !!}" name="nuevo_id" id="nuevo_id">    
            
            
            <script>
                var nuevo_id = $("#nuevo_id").val();
                
            

                $.ajax({
                    url: "{{route('bachiller.bachiller_justificaciones.imprimir')}}",
                    method: "POST",
                    dataType: "json",
                    data: {
                        "_token": $("meta[name=csrf-token]").attr("content"),
                        nuevo_id: nuevo_id                            
                    },
                        
                    success: function(data){

                        console.log('si llega aqui ' +data.res)

                        var id = data.res;
                        window.open("/reporte/bachiller_justificaciones/imprimir/"+id,"_blank");
                                
                    
                    }
                });
            </script>

        @endif
    </div>
  </div>


@endsection


@section('footer_scripts')
@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
<script>
    function recuperarFecha() {

      $("#fechaFin").val($("#fechaInicio").val());
      $('#fechaFin').attr('min' , $("#fechaInicio").val());
    }
    </script>
<script type="text/javascript">

    $(document).ready(function() {

        $("#periodo_id").change( event => {

            var plan_id = $("#plan_id").val();

            $("#curso_id").empty();            
            $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);  
           

            $.get(base_url+`/reporte/getAlumnosCurso/${event.target.value}/${plan_id}`,function(res,sta){
                res.forEach(element => {
                    $("#curso_id").append(`<option value=${element.id}>${element.aluClave}-${element.perApellido1} ${element.perApellido2} ${element.perNombre}</option>`);
                });
            });
        });

        $("#plan_id").change( event => {

            var periodo_id = $("#periodo_id").val();

            $("#curso_id").empty();            
            $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);  
           

            $.get(base_url+`/reporte/getAlumnosCurso/${periodo_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#curso_id").append(`<option value=${element.id}>${element.aluClave}-${element.perApellido1} ${element.perApellido2} ${element.perNombre}</option>`);
                });
            });
        });


        $("#curso_id").change( event => {
         
           

            $.get(base_url+`/reporte/contarRegistros/${event.target.value}`,function(res,sta){
                
                if(res >= 3){
                    swal('Escuela Modelo', 'El alumno(a) seleccionado ya tiene 3 justificaciones solicitas', 'info');
                    //$(".btn-guardar").prop('disabled', true);
                }else{
                    $(".btn-guardar").prop('disabled', false);
                }
            });
        });

     });
</script>



@endsection