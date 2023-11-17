@extends('layouts.dashboard')

@section('template_title')
	Servicio Social
@endsection

@section('head')
@endsection

@section('breadcrumbs')
	<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
	<a href="{{url('serviciosocial')}}" class="breadcrumb">Lista de Servicio Social</a>
	<label class="breadcrumb">Editar Servicio Social</label>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['serviciosocial.update', $serviciosocial->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR SERVICIO SOCIAL #{{$serviciosocial->id}}</span>


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
                        <span>
                            {{$serviciosocial->alumno->persona->perNombre}}
                            {{$serviciosocial->alumno->persona->perApellido1}}
                            {{$serviciosocial->alumno->persona->perApellido2}}
                        </span>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('aluClave', $serviciosocial->alumno->aluClave, array('id' => 'aluClave', 'class' => 'validate','required','min'=>'0')) !!}
                            {!! Form::label('aluClave', 'Clave del Alumno *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progClave', $serviciosocial->progClave, array('id' => 'progClave', 'class' => 'validate','required','maxlength'=>'3')) !!}
                            {!! Form::label('progClave', 'Clave de Programa *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssLugar', $serviciosocial->ssLugar, array('id' => 'ssLugar', 'class' => 'validate','required')) !!}
                            {!! Form::label('ssLugar', 'Lugar *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col s12 m6 l4">
                        <label for="alcance_regional">Alcance regional*</label>
                        <select class="browser-default validate select2" name="alcance_regional" id="alcance_regional" data-alcance-regional="{{old('alcance_regional') ?: $serviciosocial->alcance_regional}}" style="width:100%;" required>
                            <option value="municipal">Municipal</option>
                            <option value="estatal">Estatal</option>
                            <option value="federal">Federal</option>
                        </select>
                    </div> --}}
                    <div class="col s12 m6 l4">
                        <br>
                        {!! Form::label('ssClasificacion', 'Clasificación *', array('class' => '')); !!}
                        <select id="ssClasificacion" class="browser-default validate select2" required name="ssClasificacion" style="width: 100%;">
                            @foreach($clasificacion as $key => $value)
                            @if($key == $serviciosocial->ssClasificacion)
                            <option value="{{$key}}" selected>{{$value}}</option>
                            @else
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                	<div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssDireccion', $serviciosocial->ssDireccion, array('id' => 'ssDireccion', 'class' => 'validate')) !!}
                            {!! Form::label('ssDireccion', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssTelefono', $serviciosocial->ssTelefono, array('id' => 'ssTelefono', 'class' => 'validate','maxlength' => '30')) !!}
                            {!! Form::label('ssTelefono', 'Telefono', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ssJefeSuperior', $serviciosocial->ssJefeSuperior, array('id' => 'ssJefeSuperior', 'class' => 'validate')) !!}
                            {!! Form::label('ssJefeSuperior', 'Jefe Superior', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                	<p style="text-align:center;">Horarios</p>
                	<br>
                	<div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioLunes', $serviciosocial->ssHorarioLunes, array('id' => 'ssHorarioLunes', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioLunes', 'Lunes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioMartes', $serviciosocial->ssHorarioMartes, array('id' => 'ssHorarioMartes', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioMartes', 'Martes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioMiercoles', $serviciosocial->ssHorarioMiercoles, array('id' => 'ssHorarioMiercoles', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioMiercoles', 'Miércoles', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioJueves', $serviciosocial->ssHorarioJueves, array('id' => 'ssHorarioJueves', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioJueves', 'Jueves', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioViernes', $serviciosocial->ssHorarioViernes, array('id' => 'ssHorarioViernes', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioViernes', 'Viernes', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioSabado', $serviciosocial->ssHorarioSabado, array('id' => 'ssHorarioSabado', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioSabado', 'Sábado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l4">
                            {!! Form::text('ssHorarioDomingo', $serviciosocial->ssHorarioDomingo, array('id' => 'ssHorarioDomingo', 'class' => 'validate','maxlength'=>'5')) !!}
                            {!! Form::label('ssHorarioDomingo', 'Domingo', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                
                <div class="row">
                	{{-- <div class="col s12 m6 l4">
                		<br>
                        {!! Form::label('ssClasificacion', 'Clasificación *', array('class' => '')); !!}
                        <select id="ssClasificacion" class="browser-default validate select2" required name="ssClasificacion" style="width: 100%;">
                            @foreach($clasificacion as $key => $value)
                            @if($key == $serviciosocial->ssClasificacion)
                            <option value="{{$key}}" selected>{{$value}}</option>
                            @else
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="col s12 m6 l4">
                    	<br>
                            {!! Form::label('ssFechaInicio', 'Fecha de Inicio', array('class' => '')); !!}
                            {!! Form::date('ssFechaInicio', $serviciosocial->ssFechaInicio, array('id' => 'ssFechaInicio', 'class' => 'validate','required')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                    	<p style="text-align:center;">Periodo de Inicio</p>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssNumeroPeriodoInicio', $serviciosocial->ssNumeroPeriodoInicio, array('id' => 'ssNumeroPeriodoInicio', 'class' => 'validate','required','min'=>'0','max'=>'3')) !!}
                            {!! Form::label('ssNumeroPeriodoInicio', 'Número *', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssAnioPeriodoInicio', $serviciosocial->ssAnioPeriodoInicio, array('id' => 'ssAnioPeriodoInicio', 'class' => 'validate','required','min'=>'1997','max'=>$anioActual+1)) !!}
                            {!! Form::label('ssAnioPeriodoInicio', 'Año *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col s12 m6 l4">
                		<br>
                        <div class="input-field">
                            {!! Form::text('ssNumeroAsignacion', $serviciosocial->ssNumeroAsignacion, array('id' => 'ssNumeroAsignacion', 'class' => 'validate','maxlength'=>'8')) !!}
                            {!! Form::label('ssNumeroAsignacion', 'Número de asignación ', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                            {!! Form::label('ssFechaLiberacion', 'Fecha de Liberación', array('class' => '')); !!}
                            {!! Form::date('ssFechaLiberacion', $serviciosocial->ssFechaLiberacion, array('id' => 'ssFechaLiberacion', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                    	<p style="text-align:center;">Periodo de Liberación</p>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssNumeroPeriodoLiberacion', $serviciosocial->ssNumeroPeriodoLiberacion, array('id' => 'ssNumeroPeriodoLiberacion', 'class' => 'validate','min'=>'0','max'=>'3')) !!}
                            {!! Form::label('ssNumeroPeriodoLiberacion', 'Número', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                            {!! Form::number('ssAnioPeriodoLiberacion', $serviciosocial->ssAnioPeriodoLiberacion, array('id' => 'ssAnioPeriodoLiberacion', 'class' => 'validate','min'=>'1997','max'=>$anioActual+1)) !!}
                            {!! Form::label('ssAnioPeriodoLiberacion', 'Año', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                		<br>
                        {!! Form::label('ssEstadoActual', 'Estado Actual *', array('class' => '')); !!}
                        <select id="ssEstadoActual" class="browser-default validate select2" required name="ssEstadoActual" style="width: 100%;">
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
                        <div class=" col s12 m6 14">
                            {!! Form::label('ssFechaReporte1', 'Reporte 1', array('class' => '')); !!}
                            {!! Form::date('ssFechaReporte1', $serviciosocial->ssFechaReporte1, array('id' => 'ssFechaReporte1', 'class' => 'validate')) !!}
                        </div>
                        <div class=" col s12 m6 14">
                            {!! Form::label('ssFechaReporte2', 'Reporte 2', array('class' => '')); !!}
                            {!! Form::date('ssFechaReporte2', $serviciosocial->ssFechaReporte2, array('id' => 'ssFechaReporte2', 'class' => 'validate')) !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                    	<br>
                        <div class=" col s12 m6 14">
                            {!! Form::label('ssFechaReporte3', 'Reporte 3', array('class' => '')); !!}
                            {!! Form::date('ssFechaReporte3', $serviciosocial->ssFechaReporte3, array('id' => 'ssFechaReporte3', 'class' => 'validate')) !!}
                        </div>
                        <div class="col s12 m6 14">
                            {!! Form::label('ssFechaReporte4', 'Reporte 4', array('class' => '')); !!}
                            {!! Form::date('ssFechaReporte4', $serviciosocial->ssFechaReporte4, array('id' => 'ssFechaReporte4', 'class' => 'validate')) !!}
                        </div>
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
</div>

    <script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {
        apply_data_to_select('alcance_regional', 'alcance-regional');
    });
</script>
	<!-- @include('scripts.alumnos') -->
@endsection