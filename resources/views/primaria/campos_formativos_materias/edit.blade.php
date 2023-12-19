@extends('layouts.dashboard')

@section('template_title')
Primaria campo formativo materia
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{route('primaria.primaria_campos_formativos_materias.index')}}" class="breadcrumb">Lista de campos formativos materias</a>
<label class="breadcrumb">Editar campo formativo materia</label>
@endsection

@section('content')


<div class="row">
  <div class="col s12 ">
    {{ Form::open(array('method'=>'PUT','route' => ['primaria.primaria_campos_formativos_materias.update',
    $primaria_campo_formativo_materias->id])) }}
    <div class="card ">
      <div class="card-content ">
        <span class="card-title">EDITAR CAMPO FORMATIVO MATERIA
          #{{$primaria_campo_formativo_materias->id}}</span>

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
                  <select id="ubicacion_id" class="browser-default validate select2" required
                      name="ubicacion_id" style="width: 100%;">
                      <option value="{{ $primaria_campo_formativo_materias->ubicacion_id }}">{{ $primaria_campo_formativo_materias->ubiClave.'-'.$primaria_campo_formativo_materias->ubiNombre }}</option>                      
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                  <select id="departamento_id" data-departamento-idold="{{old('departamento_id')}}"
                      class="browser-default validate select2" required name="departamento_id"
                      style="width: 100%;">
                      <option value="{{ $primaria_campo_formativo_materias->departamento_id }}">{{ $primaria_campo_formativo_materias->depClave.'-'.$primaria_campo_formativo_materias->depNombre }}</option>                      
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                  <select id="escuela_id" data-escuela-idold="{{old('escuela_id')}}"
                      class="browser-default validate select2" required name="escuela_id"
                      style="width: 100%;">
                      <option value="{{ $primaria_campo_formativo_materias->escuela_id }}">{{ $primaria_campo_formativo_materias->escClave.'-'.$primaria_campo_formativo_materias->escNombre }}</option>                      
                  </select>
              </div>
          </div>
          <div class="row">
              <div class="col s12 m6 l4">
                  {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                  <select id="programa_id" data-programa-idold="{{old('programa_id')}}"
                      class="browser-default validate select2" required name="programa_id"
                      style="width: 100%;">
                      <option value="{{ $primaria_campo_formativo_materias->programa_id }}">{{ $primaria_campo_formativo_materias->progClave.'-'.$primaria_campo_formativo_materias->progNombre }}</option>                      
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                  <select id="plan_id" data-plan-idold="{{old('plan_id')}}"
                      class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                      <option value="{{ $primaria_campo_formativo_materias->plan_id }}">{{ $primaria_campo_formativo_materias->planClave }}</option>                      
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('grado', 'Grado *', array('class' => '')); !!}
                  <select id="grado" data-grado-idold="{{old('grado')}}"
                      class="browser-default validate select2" required name="grado" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @for ($i = 1; $i < 7; $i++)                       
                        <option value="{{ $i }}" {{ $primaria_campo_formativo_materias->matSemestre == $i ? "selected":"" }}>{{ $i }} </option>
                      @endfor
                  </select>
              </div>
          </div>

          <div class="row">
              <div class="col s12 m6 l4">
                  {!! Form::label('primaria_campo_formativo_id', 'Campo Formativo *', array('class' => ''));
                  !!}
                  <select id="primaria_campo_formativo_id" class="browser-default validate select2" required
                      name="primaria_campo_formativo_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach ($primaria_campos_formativos as $item)
                      <option {{ $primaria_campo_formativo_materias->primaria_campo_formativo_id==$item->id ? "selected":"" }} value="{{
                          $item->id }}">{{ $item->camFormativos }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('primaria_materia_id', 'Materia *', array('class' => '')); !!}
                  <select id="primaria_materia_id" data-primaria-materia-id="{{ $primaria_campo_formativo_materias->primaria_materia_id }}"
                      class="browser-default validate select2" required name="primaria_materia_id"
                      style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
          </div>

      </div>

      </div>
      <div class="card-action">
        {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect
        darken-3','type' => 'submit']) !!}
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection

@section('footer_scripts')

@include('primaria.campos_formativos_materias.cargaMaterias')

@endsection