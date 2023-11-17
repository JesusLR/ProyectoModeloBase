@extends('layouts.dashboard')

@section('template_title')
    Reporte ficha técnica
@endsection

@section('breadcrumbs')
  <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Ficha técnica</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp
 
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'primaria_reporte.ficha_tecnica.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">FICHA DE TÉCNICA DE ALUMNOS</span>          

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
                  <label for="ubicacion_id">Ubicación*</label>
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
                  <label for="departamento_id">Departamento*</label>
                  <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      {{--  <option value="">SELECCIONE UNA OPCIÓN</option>  --}}
                  </select>
              </div>

              <div class="col s12 m6 l4">
                <label for="escuela_id">Escuela*</label>
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                </select>
              </div>              
            </div>

            <div class="row">             
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa*</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="plan_id">Plan</label>
                  <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="periodo_id">Periodo*</label>
                  <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('gpoGrado', old('gpoGrado'), array('id' => 'gpoGrado', 'class' => 'validate','min'=>'0', 'max'=>'6', "required")) !!}
                  {!! Form::label('gpoGrado', 'Grado *', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('gpoClave', old('gpoClave'), array('id' => 'gpoClave', 'class' => 'validate', "required")) !!}
                  {!! Form::label('gpoClave', 'Grupo*', array('class' => '')); !!}
                </div>
              </div>
              {{--  <div class="col s12 m6 l4">
                <label for="conceptos">Concepto estado *</label>
                <select required name="conceptos" id="conceptos" data-conceptos-id="{{old('conceptos')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach ($conceptos as $concepto)
                        <option value="{{$concepto->concClave}}">{{$concepto->concNombre}}</option>
                    @endforeach
                </select>
              </div>  --}}
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('aluClave', old('aluClave'), array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave alumno (un solo registro)', array('class' => '')); !!}
                </div>                
              </div>

              <div class="col s12 m6 l4">
                <label for="tipoReporte">Tipo de vista *</label>
                <select required name="tipoReporte" id="tipoReporte" data-tipoReporte-id="{{old('tipoReporte')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="1">FICHA TÉCNICA CON DATOS</option>
                    <option value="2">FICHA TÉCNICA EN BLANCO</option>  
                </select>
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

@include('primaria.scripts.preferencias')
@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas_todos')
@include('primaria.scripts.programas')
@include('primaria.scripts.planes')
@include('primaria.scripts.periodos')

<script>
  function required(){
    
  }

  $("select[name=tipoReporte]").change(function(){
    if($('select[name=tipoReporte]').val() == 3){
      $("#departamento_id").removeAttr("required");    
      $("#periodo_id").removeAttr("required");
      $("#gpoGrado").removeAttr("required");
      $("#gpoClave").removeAttr("required");
      //$("#conceptos").removeAttr("required");
    }else{
      $('#departamento_id').prop("required", true);
      $('#periodo_id').prop("required", true);
      $('#gpoGrado').prop("required", true);
      $('#gpoClave').prop("required", true);
      //$('#conceptos').prop("required", true);
    }
  });
</script>



<script>
    $("select[name=tipoReporte]").change(function(){
        if($('select[name=tipoReporte]').val() == "2"){
            $("#gpoGrado").prop('required', false);   
            $("#gpoClave").prop('required', false);  

        }else{
            $("#obsCardiaco").prop('required', true);
            $("#gpoClave").prop('required', true);
        }
    });
</script>

@endsection