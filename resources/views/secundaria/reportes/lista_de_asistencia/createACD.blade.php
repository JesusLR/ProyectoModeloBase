@extends('layouts.dashboard')

@section('template_title')
    Reportes lista de asistencia ACD
@endsection

@section('breadcrumbs')
  <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Lista de asistencia ACD</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
      $perActual = Auth::user()->empleado->escuela->departamento->perActual;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'secundaria_reporte.lista_de_asistencia_ACD.imprimirACD', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Lista de asistencia ACD</span>
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
                  <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>

              <div class="col s12 m6 l4">
                <label for="periodo_id">Periodo*</label>
                <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id', $perActual)}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>



            <div class="row">
              <div class="col s12 m6 l4">
                <label for="tipoReporte">Tipo de filtro</label>
                <select name="tipoReporte" id="tipoReporte" data-periodo-id="{{old('tipoReporte')}}" class="browser-default validate select2" style="width:100%;" required>
                  <option value="">SELECCIONE UNA OPCIÓN</option>
                  <option value="1">LISTA POR SOLO EL GRADO</option>
                  <option value="2">LISTA POR NOMBRE DE GRUPO</option>
                  <option value="3">LISTA POR GRADO-GRUPO SELECCIONADO</option>
                </select>                    
              </div>

                <div class="col s12 m6 l4" style="display: none;" id="divGpoGrado">
                  <label for="gpoGrado">Grado</label>
                  <select name="gpoGrado" id="gpoGrado" data-gpoGrado-id="{{old('gpoGrado')}}" class="browser-default validate select2" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                  </select>                    
                </div>


                <div class="col s12 m6 l4" style="display: none;" id="divGpoGrupo">
                  <label for="gpoGrupo">Grupo</label>
                  <select name="gpoGrupo" id="gpoGrupo" data-gpoGrupo-id="{{old('gpoGrupo')}}" class="browser-default validate select2" style="width:100%; pointer-events: none">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>

                <div class="col s12 m6 l4" style="display: none;" id="divGpoMatComplementaria">
                  <label for="gpoMatComplementaria">Grupo ACD</label>
                  <select name="gpoMatComplementaria" id="gpoMatComplementaria" data-gpoMatComplementaria-id="{{old('gpoMatComplementaria')}}" class="browser-default validate select2" style="width:100%; pointer-events: none">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
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

@include('secundaria.scripts.preferencias')
@include('secundaria.scripts.departamentos')
@include('secundaria.scripts.escuelas')
@include('secundaria.scripts.programas')
@include('secundaria.scripts.planes')
@include('secundaria.scripts.periodos')
@include('secundaria.reportes.lista_de_asistencia.funcionesJSdeFiltro')


@endsection
