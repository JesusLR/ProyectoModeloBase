@extends('layouts.dashboard')

@section('template_title')
    Bachiller fechas de regularización
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_fechas_regularizacion')}}" class="breadcrumb">Lista de fechas de regularización</a>
    <label class="breadcrumb">Agregar fechas de regularización</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_fechas_regularizacion.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR FECHAS DE REGULARIZACIÓN</span>

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
                            data-periodo-id="{{old('periodo_id')}}"
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
                        <div class="input-field">
                            {!! Form::number('frImporteAcomp', NULL, array('id' => 'frImporteAcomp', 'class' => '', 'step'=>'0.01')) !!}
                            {!! Form::label('frImporteAcomp', 'Importe Acompañamiento *', array('class' => '')); !!}
                        </div>
                    </div>        
                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('frImporteRecursamiento', NULL, array('id' => 'frImporteRecursamiento', 'class' => '','step'=>'0.01')) !!}
                            {!! Form::label('frImporteRecursamiento', 'Importe Recursamiento *', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('frMaximoAcomp', NULL, array('id' => 'frMaximoAcomp', 'class' => '','maxlength'=>'15')) !!}
                            {!! Form::label('frMaximoAcomp', 'Maximo Acompañamiento *', array('class' => '')); !!}
                        </div>
                    </div> 
 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('frMaximoRecursamiento', NULL, array('id' => 'frMaximoRecursamiento', 'class' => '','maxlength'=>'15')) !!}
                            {!! Form::label('frMaximoRecursamiento', 'Maximo Recursamiento *', array('class' => '')); !!}
                        </div>
                    </div>        
                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('frFechaInicioInscripcion', 'Fecha inicio inscripción *', array('class' => '')); !!}
                        {!! Form::date('frFechaInicioInscripcion', NULL, array('id' => 'frFechaInicioInscripcion', 'class' => '','maxlength'=>'15')) !!}
                    </div> 


                    <div class="col s12 m6 l4">
                        {!! Form::label('frFechaFinInscripcion', 'Fecha fin inscripción *', array('class' => '')); !!}
                        {!! Form::date('frFechaFinInscripcion', NULL, array('id' => 'frFechaFinInscripcion', 'class' => '','maxlength'=>'15')) !!}
                    </div> 
                   
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('frFechaInicioCursos', 'Fecha inicio curso *', array('class' => '')); !!}
                        {!! Form::date('frFechaInicioCursos', NULL, array('id' => 'frFechaInicioCursos', 'class' => '','maxlength'=>'15')) !!}
                    </div> 


                    <div class="col s12 m6 l4">
                        {!! Form::label('frFechaFinCursos', 'Fecha fin curso *', array('class' => '')); !!}
                        {!! Form::date('frFechaFinCursos', NULL, array('id' => 'frFechaFinCursos', 'class' => '','maxlength'=>'15')) !!}
                    </div> 


                    <div class="col s12 m6 l4">
                        {!! Form::label('frEstado', 'Estado *', array('class' => '')); !!}
                        <select id="frEstado" data-frEstado-id="{{old('frEstado')}}"
                            class="browser-default validate select2" required name="frEstado"
                            style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCION</option>
                            <option value="C" {{ old('frEstado') == 'C' ? 'selected' : '' }}>C</option>
                            <option value="A" {{ old('frEstado') == 'A' ? 'selected' : '' }}>A</option>

                        </select>
                    </div>
                   
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

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_periodos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')




@endsection