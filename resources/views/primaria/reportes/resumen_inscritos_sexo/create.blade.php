@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de inscritos por género</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'primaria.primaria_inscritos_sexo.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de inscritos por género</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>

          {{-- GENERAL BAR--}}
          <div id="general">

            <div class="row">
                <div class="col s12 m6 l4">
                    {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                    <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        @foreach($ubicaciones as $ubicacion)
                            @php
                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;

                                $selected = '';
                                if ($ubicacion->id == $ubicacion_id) {
                                    $selected = 'selected';
                                }

                                if ($ubicacion->id == old("ubicacion_id")) {
                                    $selected = 'selected';
                                }
                            @endphp
                            <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiClave ."-". $ubicacion->ubiNombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                    <select id="departamento_id"
                        data-departamento-idold="{{old('departamento_id')}}"
                        class="browser-default validate select2"
                        required name="departamento_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                    <select id="escuela_id"
                        data-escuela-idold="{{old('escuela_id')}}"
                        class="browser-default validate select2"
                        required name="escuela_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                    <select id="periodo_id"
                        data-periodo-idold="{{old('periodo_id')}}"
                        class="browser-default validate select2"
                        required name="periodo_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                    <select id="programa_id"
                        data-programa-idold="{{old('programa_id')}}"
                        class="browser-default validate select2"
                        required name="programa_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                    <select id="plan_id"
                        data-plan-idold="{{old('plan_id')}}"
                        class="browser-default validate select2"
                        required name="plan_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
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
</div>
</div>
@endsection


@section('footer_scripts')
@include('primaria.scripts.preferencias')
@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas')
@include('primaria.scripts.programas')
@include('primaria.scripts.planes')
@include('primaria.scripts.periodos')

@endsection