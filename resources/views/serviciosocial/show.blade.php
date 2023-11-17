@extends('layouts.dashboard')

@section('template_title')
	Servicio Social
@endsection

@section('head')
@endsection

@section('breadcrumbs')
	<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
	<a href="{{url('serviciosocial')}}" class="breadcrumb">Lista de Servicio Social</a>
	<label class="breadcrumb">Ver Servicio Social</label>
@endsection

@section('content')
<div class="row">
	<div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => url('serviciosocial/imprimir_detalles'), 'method' => 'POST', 'target' => '_blank']) !!}

        <div class="card ">
          <div class="card-content ">
            
            <h5 style="display:inline-block;">Servicio Social #{{$serviciosocial->id}}                 &nbsp;</h5> 
            {!! Form::button('<i class="material-icons left">print</i> imprimir', ['class' => 'btn waves-effect','type' => 'submit']) !!}

            <br>
            <br>

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
                    <div class="col s12 m12 l12">
                        <div class="input-field">
                            {!! Form::hidden('serviciosocial_id', $serviciosocial->id, ['id' => 'serviciosocial_id']) !!}
                            {!! Form::label('serviciosocial_id', 'servicio #', array('class' => '', 'style' => 'color:#fff;')); !!}
                        </div>
                        <span>
                            {{$serviciosocial->alumno->persona->perNombre}}
                            {{$serviciosocial->alumno->persona->perApellido1}}
                            {{$serviciosocial->alumno->persona->perApellido2}}
                        </span>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('aluClave', $serviciosocial->alumno->aluClave, array('readonly'=>'true')) !!}
                            {!! Form::label('aluClave', 'Clave del Alumno', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progClave', $serviciosocial->progClave, array('readonly'=>'true')) !!}
                            {!! Form::label('progClave', 'Clave de Programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssLugar', $serviciosocial->ssLugar, array('readonly'=>'true')) !!}
                            {!! Form::label('ssLugar', 'Lugar', array('class' => '')); !!}
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="text" name="alcance_regional" id="alcance_regional" value="{{$serviciosocial->alcance_regional}}">
                            <label for="alcance_regional">Alcance regional*</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssDireccion', $serviciosocial->ssDireccion, array('readonly'=>'true')) !!}
                            {!! Form::label('ssDireccion', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssTelefono', $serviciosocial->ssTelefono, array('readonly'=>'true')) !!}
                            {!! Form::label('ssTelefono', 'Telefono', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssJefeSuperior', $serviciosocial->ssJefeSuperior, array('readonly'=>'true')) !!}
                            {!! Form::label('ssJefeSuperior', 'Jefe Superior', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                	<p style="text-align:center;">Horarios</p>
                	<br>
                	<div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioLunes', $serviciosocial->ssHorarioLunes, array('readonly'=>'true')) !!}
                            {!! Form::label('ssHorarioLunes', 'Lunes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioMartes', $serviciosocial->ssHorarioMartes, array('readonly'=>'true')) !!}
                            {!! Form::label('ssHorarioMartes', 'Martes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioMiercoles', $serviciosocial->ssHorarioMiercoles, array('readonly'=>'true')) !!}
                            {!! Form::label('ssHorarioMiercoles', 'Miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioJueves', $serviciosocial->ssHorarioJueves, array('readonly'=>'true')) !!}
                            {!! Form::label('ssHorarioJueves', 'Jueves', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioViernes', $serviciosocial->ssHorarioViernes, array('readonly'=>'true')) !!}
                            {!! Form::label('ssHorarioViernes', 'Viernes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioSabado', $serviciosocial->ssHorarioSabado, array('readonly'=>'true')) !!}
                            {!! Form::label('ssHorarioSabado', 'Sábado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioDomingo', $serviciosocial->ssHorarioDomingo, array('readonly'=>'true')) !!}
                            {!! Form::label('ssHorarioDomingo', 'Domingo', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                
                <div class="row">
                	<div class="col s12 m6 l4">
                		<br>
                        {!! Form::label('ssClasificacion', 'Clasificación', array('class' => '')); !!}
                        <select id="ssClasificacion" class="browser-default validate select2" required name="ssClasificacion" style="width: 100%;" disabled>
                            @foreach($clasificacion as $key => $value)
                            @if($key == $serviciosocial->ssClasificacion)
                            <option value="{{$key}}" selected>{{$value}}</option>
                            @else
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class="input-field">
                        	@php
                        	$ssFechaInicio = Carbon\Carbon::parse($serviciosocial->ssFechaInicio)
                        		->format('d/m/Y');
                        	@endphp
                            {!! Form::text('ssFechaInicio', $ssFechaInicio, array('readonly'=>'true')) !!}
                            {!! Form::label('ssFechaInicio', 'Fecha de Inicio', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<p style="text-align:center;">Periodo de Inicio</p>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssNumeroPeriodoInicio', $serviciosocial->ssNumeroPeriodoInicio, array('readonly'=>'true')) !!}
                            {!! Form::label('ssNumeroPeriodoInicio', 'Número', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssAnioPeriodoInicio', $serviciosocial->ssAnioPeriodoInicio, array('readonly'=>'true')) !!}
                            {!! Form::label('ssAnioPeriodoInicio', 'Año', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col s12 m6 l4">
                		<br>
                        <div class="input-field">
                            {!! Form::text('ssNumeroAsignacion', $serviciosocial->ssNumeroAsignacion, array('readonly'=>'true')) !!}
                            {!! Form::label('ssNumeroAsignacion', 'Número de asignación ', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class="input-field">
                        	@php
                        	$ssFechaLiberacion = null;
                        	$fecha = $serviciosocial->ssFechaLiberacion;
                        	if($fecha){
                        		$ssFechaLiberacion = Carbon\Carbon::parse($fecha)
                        		->format('d/m/Y');;
                        	}
                        	@endphp
                            {!! Form::text('ssFechaLiberacion', $ssFechaLiberacion, array('readonly'=>'true')) !!}
                            {!! Form::label('ssFechaLiberacion', 'Fecha de Liberación', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<p style="text-align:center;">Periodo de Liberación</p>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssNumeroPeriodoLiberacion', $serviciosocial->ssNumeroPeriodoLiberacion, array('readonly'=>'true')) !!}
                            {!! Form::label('ssNumeroPeriodoLiberacion', 'Número', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssAnioPeriodoLiberacion', $serviciosocial->ssAnioPeriodoLiberacion, array('readonly'=>'true')) !!}
                            {!! Form::label('ssAnioPeriodoLiberacion', 'Año', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                		<br>
                        {!! Form::label('ssEstadoActual', 'Estado Actual', array('class' => '')); !!}
                        <select id="ssEstadoActual" class="browser-default validate select2" required name="ssEstadoActual" style="width: 100%;" disabled>
                            @foreach($estadoActual as $key => $value)
                            @if($key == $serviciosocial->ssEstadoActual)
                            <option value="{{$key}}" selected>{{$value}}</option>
                            @else
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class="input-field col s12 m6 14">
                        	@php
                        	$ssFechaReporte1 = null;
                        	$fecha = $serviciosocial->ssFechaReporte1;
                        	if($fecha){
                        		$ssFechaReporte1 = Carbon\Carbon::parse($fecha)
                        		->format('d/m/Y');;
                        	}
                        	@endphp
                            {!! Form::text('ssFechaReporte1', $ssFechaReporte1, array('readonly'=>'true')) !!}
                            {!! Form::label('ssFechaReporte1', 'Reporte 1', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                        	@php
                        	$ssFechaReporte2 = null;
                        	$fecha = $serviciosocial->ssFechaReporte2;
                        	if($fecha){
                        		$ssFechaReporte2 = Carbon\Carbon::parse($fecha)
                        		->format('d/m/Y');;
                        	}
                        	@endphp
                            {!! Form::text('ssFechaReporte2', $ssFechaReporte2, array('readonly'=>'true')) !!}
                            {!! Form::label('ssFechaReporte2', 'Reporte 2', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class="input-field col s12 m6 14">
                        	@php
                        	$ssFechaReporte3 = null;
                        	$fecha = $serviciosocial->ssFechaReporte3;
                        	if($fecha){
                        		$ssFechaReporte3 = Carbon\Carbon::parse($fecha)
                        		->format('d/m/Y');;
                        	}
                        	@endphp
                            {!! Form::text('ssFechaReporte3', $ssFechaReporte3, array('readonly'=>'true')) !!}
                            {!! Form::label('ssFechaReporte3', 'Reporte 3', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                        	@php
                        	$ssFechaReporte4 = null;
                        	$fecha = $serviciosocial->ssFechaReporte4;
                        	if($fecha){
                        		$ssFechaReporte4 = Carbon\Carbon::parse($fecha)
                        		->format('d/m/Y');;
                        	}
                        	@endphp
                            {!! Form::text('ssFechaReporte4', $ssFechaReporte4, array('readonly'=>'true')) !!}
                            {!! Form::label('ssFechaReporte4', 'Reporte 4', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          </div>
            {!! Form::close() !!}
        </div>
    </div>
  </div>
</div>
@endsection