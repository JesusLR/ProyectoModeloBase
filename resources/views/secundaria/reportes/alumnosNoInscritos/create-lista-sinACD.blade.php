@extends('layouts.dashboard')

@section('template_title')
    Reporte alumnos no inscritos
@endsection

@section('breadcrumbs')
  <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Alumnos no inscritos a grupos materias</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'secundaria.secundaria_alumnos_no_inscritos_materias.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">LISTA DE ALUMNOS NO INSCRITOS A GRUPOS MATERIAS</span>
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
                  <select name="ubicacion_id" id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      @foreach($ubicaciones as $ubicacion)
                          <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}} - {{$ubicacion->ubiNombre}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="departamento_id">Departamento*</label>
                  <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%; pointer-events: none" required>
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
                  <label for="plan_id">Plan *</label>
                  <select name="plan_id" id="plan_id" data-programa-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;" required>
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
                <label for="gpoGrado">Grado</label>
                <select name="gpoGrado" id="gpoGrado" data-periodo-id="{{old('gpoGrado')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>                    
              </div>

              <div class="col s12 m6 l4">
                <label for="tipoVistaReporte">Reporte a generar</label>
                <select name="tipoVistaReporte" id="tipoVistaReporte" data-tipoVistaReporte-id="{{old('tipoVistaReporte')}}" class="browser-default validate select2" style="width:100%;" required>
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                  <option value="1">MATERIA-GRUPO ACD</option>
                  <option value="2">MATERIA DEL PLAN DE ESTUDIOS</option>
                </select>                    
              </div>

              <div class="col s12 m6 l4" style="display: none;" id="divACD">
                <label for="materiaACD_id">Materia ACD a consultar *</label>
                <select name="materiaACD_id" id="materiaACD_id" data-materiaACD_id-id="{{old('materiaACD_id')}}" class="browser-default validate select2" style="width:100%;">
                  <option value="">SELECCIONE UNA OPCIÓN</option>

                </select>                    
              </div>

              <div class="col s12 m6 l4" style="display: none;" id="divMateria">
                <label for="materia_id">Materia consultar *</label>
                <select name="materia_id" id="materia_id" data-materia_id-id="{{old('materia_id')}}" class="browser-default validate select2" style="width:100%;">
                  <option value="">SELECCIONE UNA OPCIÓN</option>

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

@include('secundaria.scripts.funcionesAuxiliares')
@include('secundaria.reportes.alumnosNoInscritos.cargarComboGruposACD')
@include('secundaria.reportes.alumnosNoInscritos.cargarComboGrupos')

<script type="text/javascript">
    $(document).ready(function() {
        var ubicacion = $('#ubicacion_id');
        var departamento = $('#departamento_id');
        var escuela = $('#escuela_id');
        var programa = $('#programa_id');

        var ubicacion_id = {!! json_encode(old('ubicacion_id')) !!} || {!! json_encode($ubicacion_id) !!};
        if(ubicacion_id) {
            ubicacion.val(ubicacion_id).select2();
            getDepartamentos(ubicacion_id);
        }

        ubicacion.on('change', function() {
            this.value ? getDepartamentos(this.value) : resetSelect('departamento_id');
        });

        departamento.on('change', function() {
            if(this.value) {
                getPeriodos(this.value);
                getEscuelas(this.value);
            } else {
                resetSelect('periodo_id');
                resetSelect('escuela_id');
            }
        });

        escuela.on('change', function() {
            this.value ? getProgramas(this.value) : resetSelect('programa_id');
        });

        programa.on('change', function() {
            this.value ? getPlanes(this.value) : resetSelect('plan_id');
        });

    });
</script>


<script>

$(document).ready(function(){

	$("#tipoVistaReporte").change(function(){
    if($('select[id=tipoVistaReporte]').val() == "1"){

      $("#divACD").show();
      $("#divMateria").hide();
      $("#materiaACD_id").prop('required', true);
      $("#materia_id").prop('required', false);

      $("#materia_id").val("").trigger( "change" );
      
   
    }

    if($('select[id=tipoVistaReporte]').val() == "2"){

      $("#divACD").hide();
      $("#divMateria").show();
      $("#materiaACD_id").prop('required', false);
      $("#materia_id").prop('required', true);
      $("#materiaACD_id").val("").trigger( "change" );        
    }
	});

});

</script>

@endsection
