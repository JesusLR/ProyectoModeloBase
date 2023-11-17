@extends('layouts.dashboard')

@section('template_title')
    Cambiar carrera o cgt
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('curso')}}" class="breadcrumb">Preinscritos</a>
    <label class="breadcrumb">Cambiar carrera o Cgt</label>
@endsection

@section('content')

@php
    $periodo = $curso->periodo;
    $departamento = $periodo->departamento;
    $ubicacion_id = $departamento->ubicacion->id;
    $cgt = $curso->cgt;
    $plan = $cgt->plan;
    $programa = $plan->programa;
    $escuela = $programa->escuela;
@endphp

<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => "cambiar_carrera/{$curso->id}/cambiar", 'method' => 'POST']) !!}
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">Cambiar de Carrera o Cgt</span>

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
                                <label for="ubicacion_id">Ubicacion*</label>
                                <select class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" id="ubicacion_id" name="ubicacion_id" style="width:100%;" required disabled>
                                    @foreach($ubicaciones as $ubicacion)
                                        <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="departamento_id">Departamento*</label>
                                <select class="browser-default validate select2" data-departamento-id="{{old('departamento_id') ?: $departamento->id}}" id="departamento_id" name="departamento_id" style="width:100%;" required disabled>
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="periodo_id">Periodo*</label>
                                <select class="browser-default validate select2 busqueda-cgt" data-periodo-id="{{old('periodo_id') ?: $periodo->id}}" id="periodo_id" name="periodo_id" style="width:100%;" required disabled>
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m6 l4">
                                <label for="escuela_id">Escuela*</label>
                                <select class="browser-default validate select2" data-escuela-id="{{old('escuela_id') ?: $escuela->id}}" id="escuela_id" name="escuela_id" style="width:100%;" required>
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <label for="programa_id">Programa*</label>
                                <select class="browser-default validate select2" data-programa-id="{{old('programa_id') ?: $programa->id}}" id="programa_id" name="programa_id" style="width:100%;" required>
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <div class="col s12 m6 l6">
                                    <label for="plan_id">Plan*</label>
                                    <select class="browser-default validate select2 busqueda-cgt" data-plan-id="{{old('plan_id') ?: $plan->id}}" id="plan_id" name="plan_id" style="width:100%;" required>
                                        <option value="">SELECCIONE UNA OPCIÓN</option>
                                    </select>
                                </div>
                                <div class="col s12 m6 l6">
                                    <label for="cgt_id">Cgt*</label>
                                    <select class="browser-default validate select2" data-cgt-id="{{old('cgt_id') ?: $cgt->id}}" id="cgt_id" name="cgt_id" style="width:100%;">
                                        <option value="">SELECCIONE UNA OPCIÓN</option>
                                    </select>
                                </div>
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

<script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>

@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {
        let ubicacion = $('#ubicacion_id');
        let departamento = $('#departamento_id');
        let periodo = $('#periodo_id');
        let escuela = $('#escuela_id');
        let programa = $('#programa_id');
        let plan = $('#plan_id');

        apply_data_to_select('ubicacion_id', 'ubicacion-id');
        apply_data_to_select('departamento_id', 'departamento-id');
        apply_data_to_select('periodo_id', 'periodo-id');
        apply_data_to_select('escuela_id', 'escuela-id');
        apply_data_to_select('programa_id', 'programa-id');
        apply_data_to_select('plan_id', 'plan-id');
        apply_data_to_select('cgt_id', 'cgt-id');

        ubicacion.val() && getDepartamentos(ubicacion.val());
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

        $('.busqueda-cgt').on('change', function() {
            plan.val() && periodo.val() ? getCgts_plan_periodo(plan.val(), periodo.val()) : resetSelect('cgt_id');
        });
    });
</script>
@endsection