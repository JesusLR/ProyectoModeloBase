@extends('layouts.dashboard')

@section('template_title')
    Archivos SEP
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('archivo/inscripcion')}}" class="breadcrumb">Generar archivo inscripción</a>
@endsection

@section('content')

@php
	$ubicacion_id = auth()->user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
	<div class="col s12 ">
		{!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'archivo/inscripcion/descargar', 'method' => 'POST']) !!}
			<div class="card ">
				<div class="card-content">
					<span class="card-title">GENERAR ARCHIVO INSCRIPCIONES</span>

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
								{!! Form::label('ubicacion_id', 'Ubicación', array('class' => '')); !!}
								<select id="ubicacion_id" class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" name="ubicacion_id" style="width: 100%;">
									<option value="">SELECCIONE UNA OPCIÓN</option>
									@foreach($ubicaciones as $ubicacion)
										<option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
									@endforeach
								</select>
							</div>
							<div class="col s12 m6 l4">
								{!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
								<select id="departamento_id" class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" name="departamento_id" style="width: 100%;">
									<option value="">SELECCIONE UNA OPCIÓN</option>
								</select>
							</div>
							<div class="col s12 m6 l4">
								{!! Form::label('periodo_id', 'Periodo', array('class' => '')); !!}
								<select id="periodo_id" class="browser-default validate select2" data-periodo-id="{{old('periodo_id')}}" name="periodo_id" style="width: 100%;">
									<option value="">SELECCIONE UNA OPCIÓN</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col s12 m6 l4">
								<label for="escuela_id">Escuela</label>
								<select class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" id="escuela_id" name="escuela_id" style="width:100%;">
									<option value="">SELECCIONE UNA OPCIÓN</option>
								</select>
							</div>
							<div class="col s12 m6 l4">
								<label for="programa_id">Programa</label>
								<select class="browser-default validate select2" data-programa-id="{{old('programa_id')}}" id="programa_id" name="programa_id" style="width:100%;">
									<option value="">SELECCIONE UNA OPCIÓN</option>
								</select>
							</div>
							<div class="col s12 m6 l4">
								<label for="plan_id">Plan</label>
								<select class="browser-default validate select2" data-plan-id="{{old('plan_id')}}" id="plan_id" name="plan_id" style="width:100%;">
									<option value="">SELECCIONE UNA OPCIÓN</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col s12 m6 l4">
								{!! Form::label('tipo_ingreso', 'Tipo ingreso', array('class' => '')); !!}
								<select id="tipo_ingreso" class="browser-default validate select2" data-tipo-ingreso="{{old('tipo_ingreso')}}" name="tipo_ingreso" style="width: 100%;">
									<option value="PI">PREINSCRIPCION</option>
									<option value="RI">REINSCRIPCION</option>
								</select>
							</div>
							<div class="col s12 m6 l4">
								{!! Form::label('tipo_registro', 'Tipo de registro *', array('class' => '')); !!}
								<select id="tipo_registro" class="browser-default validate select2" required name="tipo_registro" style="width: 100%;">
									<option value="E">ESTATAL</option>
									<option value="F">FEDERAL</option>
								</select>
							</div>
						</div>
					</div>



				</div>
				<div class="card-action">
					{!! Form::button('<i class="material-icons left">note_add</i> GENERAR ARCHIVOS', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>

<script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection


@section('footer_scripts')
<script type="text/javascript">
	$(document).ready(function() {
		let ubicacion = $('#ubicacion_id');
		let departamento = $('#departamento_id');
		let escuela = $('#escuela_id');
		let programa = $('#programa_id');

		apply_data_to_select('ubicacion_id', 'ubicacion-id');
		apply_data_to_select('tipo_ingreso', 'tipo-ingreso');

		ubicacion.val() ? getDepartamentos(ubicacion.val()) : resetSelect('departamento_id');
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
@endsection