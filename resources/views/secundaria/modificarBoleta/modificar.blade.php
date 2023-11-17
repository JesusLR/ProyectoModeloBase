@extends('layouts.dashboard')

@section('template_title')
Reporte boletas
@endsection

@section('breadcrumbs')
<a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="" class="breadcrumb">Modificar calificaciones</a>
@endsection

@section('content')

@php
$ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' =>
        'secundaria.secundaria_modificar_boleta.actualizar_calificaciones', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">MODIFICAR CALIFICACIONES</span>
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
                            <label for="ubicacion_id">Ubicación*</label>
                            <select id="ubicacion_id" class="browser-default validate select2" required
                                name="ubicacion_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($ubicaciones as $ubicacion)
                                @php
                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                $selected = '';
                                if($ubicacion->id == $ubicacion_id){
                                $selected = 'selected';
                                }
                                @endphp
                                <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="departamento_id">Departamento*</label>
                            <select name="departamento_id" id="departamento_id"
                                data-departamento-id="{{old('departamento_id')}}"
                                class="browser-default validate select2" style="width:100%;" required>
                                {{-- <option value="">SELECCIONE UNA OPCIÓN</option> --}}
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="escuela_id">Escuela*</label>
                            <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}"
                                class="browser-default validate select2" style="width:100%;" required>
                                {{-- <option value="">SELECCIONE UNA OPCIÓN</option> --}}
                            </select>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col s12 m6 l4">
                            <label for="programa_id">Programa*</label>
                            <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}"
                                class="browser-default validate select2" style="width:100%;" required>
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="plan_id">Plan</label>
                            <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}"
                                class="browser-default validate select2" style="width:100%;" required>
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="periodo_id">Periodo*</label>
                            <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id')}}"
                                class="browser-default validate select2" style="width:100%;" required>
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field col s12 m6 l6">
                                {!! Form::number('gpoGrado', old('gpoGrado'), array('id' => 'gpoGrado', 'class' =>
                                'validate','min'=>'0', "required")) !!}
                                {!! Form::label('gpoGrado', 'Grado*', array('class' => '')); !!}
                            </div>
                            <div class="input-field col s12 m6 l6">
                                {!! Form::number('aluClave', old('aluClave'), array('id' => 'aluClave', 'class' =>
                                'validate','min'=>'0', 'required')) !!}
                                {!! Form::label('aluClave', 'Clave alumno', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <label for="secundaria_mes_evaluacione_id">Mes *</label>
                            <select name="secundaria_mes_evaluacione_id" id="secundaria_mes_evaluacione_id"
                                data-periodo-id="{{old('secundaria_mes_evaluacione_id')}}"
                                class="browser-default validate select2" style="width:100%;" required>
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                                @foreach ($secundaria_mes_evaluaciones as $item)
                                    @if ($item->mes == "ENERO")
                                        <option value="{{$item->id}}">DICIEMBRE-ENERO</option>
                                    @else
                                    <option value="{{$item->id}}">{{$item->mes}}</option>
                                    @endif                                
                                @endforeach
                            </select>
                        </div>  
                        
                        <div class="row">
                            <div class="col s4 m4 l4">
                                <button id="btn-buscar-alumno" type="button" class="btn-large waves-effect darken-3"><i class="material-icons left">search</i>Buscar</button>
                            </div>
                        </div>
                    </div>

                    

                    <div class="row" id="Tabla">
                        <div class="col s12">
                            <h5 id="alumno_nombre"></h5>
                            <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="card-action" style="display: none;" id="mostrar-save">
                <button id="btn-guardar-calificacion" type="button" class="btn-large waves-effect darken-3"><i class="material-icons left">save</i>GUARDAR</button>                
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<style>
    table tbody tr:nth-child(odd) {
        background: #D8D5DB;
    }

    table tbody tr:nth-child(even) {
        background: #F1F1F1;
    }

    table th {
        background: #01579B;
        color: #fff;

    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    .checkbox-warning-filled [type="checkbox"][class*='filled-in']:checked+label:after {
        border-color: #01579B;
        background-color: #01579B;
      }  
</style>


@endsection

@section('footer_scripts')

@include('secundaria.scripts.preferencias')
@include('secundaria.scripts.departamentos')
@include('secundaria.scripts.escuelas')
@include('secundaria.scripts.programas')
@include('secundaria.scripts.planes')
@include('secundaria.scripts.periodos')
@include('secundaria.scripts.materias')
@include('secundaria.modificarBoleta.creandoTabla')
@include('secundaria.modificarBoleta.guardarCalificaciones')


@endsection