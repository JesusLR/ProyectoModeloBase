@extends('layouts.dashboard')

@section('template_title')
Primaria observacion campo formativo
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{route('primaria.primaria_campos_formativos_materias.index')}}" class="breadcrumb">Lista de observaciones
    campos formativos</a>
<label class="breadcrumb">Agregar campos formativos</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' =>
        'primaria.primaria_campos_formativos_materias.store', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">AGREGAR OBSERVACION CAMPOS FORMATIVOS</span>

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
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($ubicaciones as $ubicacion)
                                @php
                                $selected = '';

                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                                echo '<option value="'.$ubicacion->id.'" selected>
                                    '.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                } else {
                                if ($ubicacion->id == old("ubicacion_id")) {
                                $selected = 'selected';
                                }

                                echo '<option value="'.$ubicacion->id.'" '. $selected .'>
                                    '.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                }
                                @endphp
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id" data-departamento-idold="{{old('departamento_id')}}"
                                class="browser-default validate select2" required name="departamento_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id" data-escuela-idold="{{old('escuela_id')}}"
                                class="browser-default validate select2" required name="escuela_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                            <select id="programa_id" data-programa-idold="{{old('programa_id')}}"
                                class="browser-default validate select2" required name="programa_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id" data-plan-idold="{{old('plan_id')}}"
                                class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('grado', 'Grado *', array('class' => '')); !!}
                            <select id="grado" data-grado-idold="{{old('grado')}}"
                                class="browser-default validate select2" required name="grado" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @for ($i = 1; $i < 7; $i++) <option>{{ $i }}</option>
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
                                <option {{ old("primaria_campo_formativo_id")==$item->id ? "selected":"" }} value="{{
                                    $item->id }}">{{ $item->camFormativos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('primaria_materia_id', 'Materia *', array('class' => '')); !!}
                            <select id="primaria_materia_id" data-primaria_materia-id="{{old('primaria_materia_id')}}"
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
                darken-3 submit-button','type' => 'submit']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('footer_scripts')
@include('primaria.scripts.preferencias')
@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas')
@include('primaria.scripts.programas')
@include('primaria.scripts.planes')
@include('primaria.campos_formativos_materias.cargaMaterias')




@endsection