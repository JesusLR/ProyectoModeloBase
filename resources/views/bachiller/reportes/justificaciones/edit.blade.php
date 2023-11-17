@extends('layouts.dashboard')

@section('template_title')
    Bachiller Justificaciones
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_justificaciones.index')}}" class="breadcrumb">Lista justificaciones</a>
    <a href="" class="breadcrumb">Editar justificacion</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['bachiller.bachiller_justificaciones.update', $bachiller_justificacion->id])) }}        
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">JUSTIFICACION #{{ $bachiller_justificacion->id }}</span>

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

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('jusEstado', 'Justificación entregada *', ['class' => '']); !!}
                        <select id="jusEstado" class="browser-default validate select2" required name="jusEstado" style="width: 100%;">
                            <option value="NO" {{ $bachiller_justificacion->jusEstado == "NO" ? "selected" : "" }}>NO</option>
                            <option value="SI" {{ $bachiller_justificacion->jusEstado == "SI" ? "selected" : "" }}>SI</option>
                        </select>
                    </div>
                </div>
                <hr>
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('curEstado', 'Ubicación *', ['class' => '']); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{ $bachiller_justificacion->ubicacion_id }}">{{ $bachiller_justificacion->ubiClave.' '.$bachiller_justificacion->ubiNombre }}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="departamento_id">Departamento *</label>
                        <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="{{ $bachiller_justificacion->departamento_id }}">{{ $bachiller_justificacion->depClave.' '.$bachiller_justificacion->depNombre }}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="escuela_id">Escuela *</label>
                        <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="{{ $bachiller_justificacion->escuela_id }}">{{ $bachiller_justificacion->escClave.' '.$bachiller_justificacion->escNombre }}</option>

                        </select>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="periodo_id">Período *</label>
                        <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="{{ $bachiller_justificacion->periodo_id }}">{{ $bachiller_justificacion->perNumero.'-'.$bachiller_justificacion->perAnio }}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="programa_id">Programa *</label>
                        <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="{{ $bachiller_justificacion->programa_id }}">{{ $bachiller_justificacion->progClave.' '.$bachiller_justificacion->progNombre }}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="plan_id">Plan *</label>
                        <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;">
                            <option value="{{ $bachiller_justificacion->plan_id }}">{{ $bachiller_justificacion->planClave }}</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="curso_id">Alumno *</label>
                        <select name="curso_id" id="curso_id" data-curso-id="{{ $bachiller_justificacion->curso_id }}" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA ALUMNO</option>
                        </select>
                    </div>

                
                    <div class="col s12 m6 l4">
                        <label for="">Razón de la falta</label>
                        <br>
                        <div class="col s12 m6 l6">
                            <div style="position:relative;">
                                <input type="radio" class="noUpperCase" {{ $bachiller_justificacion->jusRazonFalta == "Enfermedad" ? 'selected="selected"' : '' }} name="razonFalta" id="enfermedad" value="Enfermedad">
                                <label for="enfermedad">Enfermedad</label>
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            <div style="position:relative;">
                                <input type="radio" class="noUpperCase" {{ $bachiller_justificacion->jusRazonFalta == "Motivos personales" ? 'selected="selected"' : '' }} name="razonFalta" id="motivosPersonales" value="Motivos personales">
                                <label for="motivosPersonales">Motivos personales</label>
                            </div>
                        </div>
                    </div>
                    <script>    
                        if('{{$bachiller_justificacion->jusRazonFalta}}' == 'Enfermedad'){
                            $("#enfermedad").prop("checked", true);
                            $("#enfermedad").val("Enfermedad");
                        }else{
                            $("#enfermedad").prop("checked", false);
                        }
                    </script>
                    <script>    
                        if('{{$bachiller_justificacion->jusRazonFalta}}' == 'Motivos personales'){
                            $("#motivosPersonales").prop("checked", true);
                            $("#motivosPersonales").val("Motivos personales");
                        }else{
                            $("#motivosPersonales").prop("checked", false);
                        }
                    </script>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="col s12 m6 l6">
                                {!! Form::label('fechaInicio', 'Fecha de inicio *', array('class' => '')); !!}
                                {!! Form::date('fechaInicio', $bachiller_justificacion->jusFechaInicio, array('id' => 'fechaInicio', 'class' => 'validate','min'=>'0', 'onchange' => 'recuperarFecha()', 'required')) !!}
                            </div>
                            <div class="col s12 m6 l6">
                                {!! Form::label('fechaFin', 'Fecha de fin *', array('class' => '')); !!}
                                {!! Form::date('fechaFin', $bachiller_justificacion->jusFechaInicio, array('id' => 'fechaFin', 'class' => 'validate', 'maxlength'=>2, 'required')) !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="col s12 m6 l6">
                                {!! Form::label('curso_id_viejo', 'curso_id_viejo', array('class' => '', 'style' => 'display:none;')); !!}
                                {!! Form::hidden('curso_id_viejo', $bachiller_justificacion->curso_id, array('id' => 'curso_id_viejo', 'class' => 'validate')) !!}
                            </div>
                        </div>
                    </div>
                </div>

            
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> GUARDAR', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
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

<script>
    function recuperarFecha() {

      $("#fechaFin").val($("#fechaInicio").val());
      $('#fechaFin').attr('min' , $("#fechaInicio").val());
    }
    </script>
<script type="text/javascript">

    $(document).ready(function() {

        var plan_id = $("#plan_id").val();
        var periodo_id = $("#periodo_id").val();


        $("#curso_id").empty();            
        $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);  
           
        var cursoData = $("#curso_id").data("curso-id")

            $.get(base_url+`/reporte/getAlumnosCurso/${periodo_id}/${plan_id}`,function(res,sta){
                res.forEach(element => {

                    var selected = "";
                    if (element.id === cursoData) {
                        console.log("entra")
                        console.log(element.id)
                        selected = "selected";
                    }

                    $("#curso_id").append(`<option value='${element.id}' ${selected}>${element.aluClave}-${element.perApellido1} ${element.perApellido2} ${element.perNombre}</option>`);
                });
            });       

     });
</script>



@endsection