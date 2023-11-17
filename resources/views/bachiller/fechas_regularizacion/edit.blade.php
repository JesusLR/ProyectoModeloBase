@extends('layouts.dashboard')

@section('template_title')
    Bachiller fechas regularización
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_fechas_regularizacion')}}" class="breadcrumb">Lista de fechas de regularización</a>
    <label class="breadcrumb">Editar evidencia</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['bachiller.bachiller_fechas_regularizacion.update', $bachiller_fechas_regularizacion->id])) }}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">EDITAR FECHAS DE CALIFICACIONES #{{$bachiller_fechas_regularizacion->id}}</span>

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
                                <option value="{{$bachiller_fechas_regularizacion->ubicacion_id}}">{{$bachiller_fechas_regularizacion->ubiClave.'-'.$bachiller_fechas_regularizacion->ubiNombre}}</option>
                                
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id"
                                data-departamento-idold="{{old('departamento_id')}}"
                                class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                                <option value="{{$bachiller_fechas_regularizacion->departamento_id}}">{{$bachiller_fechas_regularizacion->depClave.'-'.$bachiller_fechas_regularizacion->depNombre}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id"
                                data-escuela-idold="{{old('escuela_id')}}"
                                class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                                <option value="{{$bachiller_fechas_regularizacion->escuela_id}}">{{$bachiller_fechas_regularizacion->escClave.'-'.$bachiller_fechas_regularizacion->escNombre}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Período *', array('class' => '')); !!}
                            <select id="periodo_id"
                                data-plan-idold="{{old('periodo_id')}}"
                                class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                                <option value="{{$bachiller_fechas_regularizacion->periodo_id}}">{{$bachiller_fechas_regularizacion->perNumero.'-'.$bachiller_fechas_regularizacion->perAnio}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                            <select id="programa_id"
                                data-programa-idold="{{old('programa_id')}}"
                                class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                                <option value="{{$bachiller_fechas_regularizacion->programa_id}}">{{$bachiller_fechas_regularizacion->progClave.'-'.$bachiller_fechas_regularizacion->progNombre}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id"
                                data-plan-idold="{{old('plan_id')}}"
                                class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                                <option value="{{$bachiller_fechas_regularizacion->plan_id}}">{{$bachiller_fechas_regularizacion->planClave}}</option>
                            </select>
                        </div>                  
                        
                    </div>              
    
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('frImporteAcomp', $bachiller_fechas_regularizacion->frImporteAcomp, array('id' => 'frImporteAcomp', 'class' => '', 'step'=>'0.01')) !!}
                                {!! Form::label('frImporteAcomp', 'Importe Acompañamiento *', array('class' => '')); !!}
                            </div>
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('frImporteRecursamiento', $bachiller_fechas_regularizacion->frImporteRecursamiento, array('id' => 'frImporteRecursamiento', 'class' => '','step'=>'0.01')) !!}
                                {!! Form::label('frImporteRecursamiento', 'Importe Recursamiento *', array('class' => '')); !!}
                            </div>
                        </div> 
    
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('frMaximoAcomp', $bachiller_fechas_regularizacion->frMaximoAcomp, array('id' => 'frMaximoAcomp', 'class' => '','maxlength'=>'15')) !!}
                                {!! Form::label('frMaximoAcomp', 'Maximo Acompañamiento *', array('class' => '')); !!}
                            </div>
                        </div> 
     
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('frMaximoRecursamiento', $bachiller_fechas_regularizacion->frMaximoRecursamiento, array('id' => 'frMaximoRecursamiento', 'class' => '','maxlength'=>'15')) !!}
                                {!! Form::label('frMaximoRecursamiento', 'Maximo Recursamiento *', array('class' => '')); !!}
                            </div>
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            {!! Form::label('frFechaInicioInscripcion', 'Fecha inicio inscripción *', array('class' => '')); !!}
                            {!! Form::date('frFechaInicioInscripcion', $bachiller_fechas_regularizacion->frFechaInicioInscripcion, array('id' => 'frFechaInicioInscripcion', 'class' => '','maxlength'=>'15')) !!}
                        </div> 
    
    
                        <div class="col s12 m6 l4">
                            {!! Form::label('frFechaFinInscripcion', 'Fecha fin inscripción *', array('class' => '')); !!}
                            {!! Form::date('frFechaFinInscripcion', $bachiller_fechas_regularizacion->frFechaFinInscripcion, array('id' => 'frFechaFinInscripcion', 'class' => '','maxlength'=>'15')) !!}
                        </div> 
                       
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('frFechaInicioCursos', 'Fecha inicio curso *', array('class' => '')); !!}
                            {!! Form::date('frFechaInicioCursos', $bachiller_fechas_regularizacion->frFechaInicioCursos, array('id' => 'frFechaInicioCursos', 'class' => '','maxlength'=>'15')) !!}
                        </div> 
    
    
                        <div class="col s12 m6 l4">
                            {!! Form::label('frFechaFinCursos', 'Fecha fin curso *', array('class' => '')); !!}
                            {!! Form::date('frFechaFinCursos', $bachiller_fechas_regularizacion->frFechaFinCursos, array('id' => 'frFechaFinCursos', 'class' => '','maxlength'=>'15')) !!}
                        </div> 
    
    
                        <div class="col s12 m6 l4">
                            {!! Form::label('frEstado', 'Estado *', array('class' => '')); !!}
                            <select id="frEstado" data-escuela-idold="{{old('frEstado')}}"
                                class="browser-default validate select2" required name="frEstado"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCION</option>
                                <option value="C" {{$bachiller_fechas_regularizacion->frEstado == 'C' ? 'selected' : ''}}>C</option>
                                <option value="A" {{$bachiller_fechas_regularizacion->frEstado == 'A' ? 'selected' : ''}}>A</option>
    
                            </select>
                        </div>
                       
                    </div>          
                              
                 
                  
                    
    
                </div>
                <div class="card-action">
                    {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @endsection

    @section('footer_scripts')


    @endsection