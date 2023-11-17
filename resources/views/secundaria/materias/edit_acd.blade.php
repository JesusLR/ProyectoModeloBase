@extends('layouts.dashboard')

@section('template_title')
    Secundaria materia
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('secundaria_materia')}}" class="breadcrumb">Lista de materias</a>
    <a href="{{route('secundaria.secundaria_materia.index_acd', ['materia_id' => $materia_acd->secundaria_materia_id, 'plan_id' => $materia_acd->plan_id])}}" class="breadcrumb">Lista de materias complementarias</a>
    <label class="breadcrumb">Editar materia complementaria</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['secundaria.secundaria_materia_acd.update_acd', $materia_acd->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR MATERIA COMPLEMENTARIA #{{$materia_acd->id}} DE LA MATERIA: <b>{{$materia_acd->matClave.'-'.$materia_acd->matNombre}}</b></span>

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
                            <option value="{{$materia_acd->ubicacion_id}}}">{{$materia_acd->ubiClave.'-'.$materia_acd->ubiNombre}}</option>                            
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-id="{{old('departamento_id')}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$materia_acd->departamento_id}}}">{{$materia_acd->depClave.'-'.$materia_acd->depNombre}}</option> 
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-id="{{old('escuela_id')}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$materia_acd->escuela_id}}}">{{$materia_acd->escClave.'-'.$materia_acd->escNombre}}</option> 
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Período *', array('class' => '')); !!}
                        <select id="periodo_id"
                            data-periodo-id="{{$materia_acd->periodo_id}}"
                            class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="{{$materia_acd->periodo_id}}">{{$materia_acd->perNumero.'-'.$materia_acd->perAnioPago}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-id="{{old('programa_id')}}"
                            class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$materia_acd->programa_id}}}">{{$materia_acd->progClave.'-'.$materia_acd->progNombre}}</option> 
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-id="{{old('plan_id')}}"
                            class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$materia_acd->plan_id}}">{{$materia_acd->planClave}}</option> 
                        </select>
                    </div>

                    <input type="hidden" name="secundaria_materia_id" id="secundaria_materia_id" value="{{$materia_acd->secundaria_materia_id}}">
                    <input type="hidden" name="gpoGrado" id="gpoGrado" value="{{$materia_acd->matSemestre}}">
                    <input type="hidden" name="secundaria_matClave" id="secundaria_matClave" value="{{$materia_acd->matClave}}">


                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoMatComplementaria', $materia_acd->gpoMatComplementaria, array('id' => 'gpoMatComplementaria', 'class' => '','maxlength'=>'60')) !!}
                            {!! Form::label('gpoMatComplementaria', 'Nombre materia *', array('class' => '')); !!}
                        </div>
                    </div>

                    {{--  <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('secundaria_matPorcentajeCalificacion', $materia_acd->secundaria_matPorcentajeCalificacion, array('id' => 'secundaria_matPorcentajeCalificacion', 'class' => '','maxlength'=>'60')) !!}
                            {!! Form::label('secundaria_matPorcentajeCalificacion', 'Porcentaje *', array('class' => '')); !!}
                        </div>
                    </div>  --}}
                    {{--  <div class="col s12 m6 l4">
                        {!! Form::label('matVigentePlanPeriodoActual', 'Materia activa', array('class' => '')); !!}
                        <select id="matVigentePlanPeriodoActual" class="browser-default validate select2" name="matVigentePlanPeriodoActual" style="width: 100%;">
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>   --}}
                </div>
               
              
                

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



@endsection