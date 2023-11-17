@extends('layouts.dashboard')

@section('template_title')
    Bachiller fechas regularización
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_fechas_regularizacion')}}" class="breadcrumb">Lista de fechas de regularización</a>
    <label class="breadcrumb">Ver evidencia</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">FECHAS DE CALIFICACIONES #{{$bachiller_fechas_regularizacion->id}}</span>

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
                            <div class="input-field">
                                {!! Form::text('ubicacion_id', $bachiller_fechas_regularizacion->ubiClave.'-'.$bachiller_fechas_regularizacion->ubiNombre, array('readonly')) !!}
                                {!! Form::label('ubicacion_id', 'Campus', array('class' => '')); !!}
                            </div>                           
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('', $bachiller_fechas_regularizacion->depClave.'-'.$bachiller_fechas_regularizacion->depNombre, array('readonly')) !!}
                                {!! Form::label('', 'Departamento', array('class' => '')); !!}
                            </div>  
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('', $bachiller_fechas_regularizacion->escClave.'-'.$bachiller_fechas_regularizacion->escNombre, array('readonly')) !!}
                                {!! Form::label('', 'Escuela', array('class' => '')); !!}
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('', $bachiller_fechas_regularizacion->perNumero.'-'.$bachiller_fechas_regularizacion->perAnio, array('readonly')) !!}
                                {!! Form::label('', 'Período', array('class' => '')); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('', $bachiller_fechas_regularizacion->progClave.'-'.$bachiller_fechas_regularizacion->progNombre, array('readonly')) !!}
                                {!! Form::label('', 'Programa', array('class' => '')); !!}
                            </div> 
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('', $bachiller_fechas_regularizacion->planClave, array('readonly')) !!}
                                {!! Form::label('', 'Plan', array('class' => '')); !!}
                            </div>                           
                        </div>                  
                        
                    </div>              
    
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('frImporteAcomp', $bachiller_fechas_regularizacion->frImporteAcomp, array('id' => 'frImporteAcomp', 'class' => '', 'step'=>'0.01', 'readonly')) !!}
                                {!! Form::label('frImporteAcomp', 'Importe Acompañamiento', array('class' => '')); !!}
                            </div>
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('frImporteRecursamiento', $bachiller_fechas_regularizacion->frImporteRecursamiento, array('id' => 'frImporteRecursamiento', 'class' => '','step'=>'0.01', 'readonly')) !!}
                                {!! Form::label('frImporteRecursamiento', 'Importe Recursamiento', array('class' => '')); !!}
                            </div>
                        </div> 
    
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('frMaximoAcomp', $bachiller_fechas_regularizacion->frMaximoAcomp, array('id' => 'frMaximoAcomp', 'class' => '','maxlength'=>'15', 'readonly')) !!}
                                {!! Form::label('frMaximoAcomp', 'Maximo Acompañamiento', array('class' => '')); !!}
                            </div>
                        </div> 
     
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('frMaximoRecursamiento', $bachiller_fechas_regularizacion->frMaximoRecursamiento, array('id' => 'frMaximoRecursamiento', 'class' => '','maxlength'=>'15', 'readonly')) !!}
                                {!! Form::label('frMaximoRecursamiento', 'Maximo Recursamiento', array('class' => '')); !!}
                            </div>
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('frFechaInicioInscripcion', 'Fecha inicio inscripción', array('class' => '')); !!}
                                {!! Form::text('frFechaInicioInscripcion', $bachiller_fechas_regularizacion->frFechaInicioInscripcion, array('id' => 'frFechaInicioInscripcion', 'class' => '','maxlength'=>'15', 'readonly')) !!}
                            </div>
                        </div> 
    
    
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('frFechaFinInscripcion', 'Fecha fin inscripción', array('class' => '')); !!}
                                {!! Form::text('frFechaFinInscripcion', $bachiller_fechas_regularizacion->frFechaFinInscripcion, array('id' => 'frFechaFinInscripcion', 'class' => '','maxlength'=>'15', 'readonly')) !!}
                            </div>
                        </div> 
                       
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('frFechaInicioCursos', 'Fecha inicio curso', array('class' => '')); !!}
                                {!! Form::text('frFechaInicioCursos', $bachiller_fechas_regularizacion->frFechaInicioCursos, array('id' => 'frFechaInicioCursos', 'class' => '','maxlength'=>'15', 'readonly')) !!}
                            </div>
                        </div> 
    
    
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('frFechaFinCursos', 'Fecha fin curso *', array('class' => '')); !!}
                                {!! Form::text('frFechaFinCursos', $bachiller_fechas_regularizacion->frFechaFinCursos, array('id' => 'frFechaFinCursos', 'class' => '','maxlength'=>'15', 'readonly')) !!}
                            </div>
                        </div> 
    
    
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('frEstado', 'Estado', array('class' => '')); !!}
                                {!! Form::text('frEstado', $bachiller_fechas_regularizacion->frEstado, array('id' => 'frEstado', 'class' => '','maxlength'=>'15', 'readonly')) !!}
                            </div>
                        </div>
                       
                    </div>       
                            
                </div>               
            </div>
        </div>
    </div>

    @endsection

    @section('footer_scripts')


    @endsection