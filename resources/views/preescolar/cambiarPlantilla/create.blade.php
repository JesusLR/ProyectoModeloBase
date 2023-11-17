@extends('layouts.dashboard')

@section('template_title')
    Preescolar cambiar plantilla
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Cambiar plantilla (Calificaciones)</label>
@endsection

@section('content')
@php
use App\Models\User;
@endphp

<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'preescolar.preescolar_modificar_plantilla_calificaciones.actualizar_plantilla', 'method' => 'POST']) !!}
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">CAMBIAR PLANTILLA (CALIFICACIONES)</span>

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
                                {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                                <div style="position:relative">
                                    <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                                        {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                                        @foreach($ubicaciones as $ubicacion)
                                            @php
                                            $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                            $selected = '';
                                            if (!isset($campus)) {
                                                if($ubicacion->id == $ubicacion_id){
                                                    $selected = 'selected';
                                                }
                                            }
                                            $selected = (isset($campus) && $campus == $ubicacion->id) ? "selected": "";
        
                                            @endphp
                                            <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                                        @endforeach
                                    </select>
                                    @if (isset($candidato))
                                        <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                    @endif
                                </div>
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                                <div style="position:relative">
                                    <select id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                                        {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                                    </select>
                                    @if (isset($candidato))
                                        <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                    @endif
                                </div>
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                                <div style="position: relative;">
                                    <select id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    </select>
                                    @if (isset($candidato))
                                        <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col s12 m6 l4">
                                {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                                <div style="position:relative">
                                    <select id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    </select>
                                    @if (isset($candidato))
                                        <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                    @endif
                                </div>
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('grado', 'Grado *', array('class' => '')); !!}
                                <select id="grado" class="browser-default validate select2" required name="grado" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    <option value="1" {{ old('grado') == "1" ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ old('grado') == "2" ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ old('grado') == "3" ? 'selected' : '' }}>3</option>
                                </select>
                            </div>    
                            <div class="col s12 m6 l4">
                                {!! Form::label('trimestre', 'Trimestre *', array('class' => '')); !!}
                                <select id="trimestre" class="browser-default validate select2" name="trimestre" style="width: 100%;" required>
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    <option value="1" {{ old('trimestre') == "1" ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ old('trimestre') == "2" ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ old('trimestre') == "3" ? 'selected' : '' }}>3</option>
                                </select>
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

@endsection

@section('footer_scripts')

@include('preescolar.scripts.preferencias')
@include('preescolar.scripts.departamentos')
@include('preescolar.scripts.escuelas')
@include('preescolar.scripts.programas')
@include('preescolar.scripts.planes')


@endsection
