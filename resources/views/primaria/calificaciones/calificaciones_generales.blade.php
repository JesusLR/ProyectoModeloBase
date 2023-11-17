@extends('layouts.dashboard')

@section('template_title')
    Primaria calificaciones generales
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_cambiar_cgt.edit')}}" class="breadcrumb">Calificaciones generales</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'primaria.primaria_calificacion_general.guardarCalificaciones', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">CALIFICACIONES GENERALES</span>

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
                            <select id="ubicacion_id" class="browser-default validate select2" required
                                name="ubicacion_id" style="width: 100%;" data-ubicacion-id="{{old('ubicacion_id')}}">
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
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id" class="browser-default validate select2" required
                                name="departamento_id" style="width: 100%;" data-departamento-id="{{old('departamento_id')}}">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id" class="browser-default validate select2" required name="escuela_id"
                                style="width: 100%;" data-escuela-id="{{old('escuela_id')}}">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id"
                                style="width: 100%;" data-periodo-id="{{old('periodo_id')}}">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                            <select id="programa_id" class="browser-default validate select2" required
                                name="programa_id" style="width: 100%;" data-programa-id="{{old('programa_id')}}">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id" class="browser-default validate select2" required name="plan_id"
                                style="width: 100%;" data-plan-id="{{old('plan_id')}}">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('cgt_id', 'CGT *', array('class' => '')); !!}
                            <select id="cgt_id" class="browser-default validate select2" required name="cgt_id"
                                style="width: 100%;" data-cgt-id="{{old('cgt_id')}}">
                                {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l8">
                            {!! Form::label('alumno_id', 'Alumno *', array('class' => '')); !!}
                            <select id="alumno_id" class="browser-default validate select2" required
                                name="alumno_id" style="width: 100%;" data-alumno-id="{{old('alumno_id')}}">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>

                </div>

                <br>
                <div class="row" style="display: none;" id="alerta-min-max-calif">
                    <div class="col s12 m6 l12">
                        <h6 style="color: red">
                            Nota:
                            <p>Calificación de captura mínima permitida es 5</p>
                            <p>Calificación de captura máxima permitida es 10</p>

                        </h6>                      
                    </div>
                </div>
                
                <div class="row" id="TablaCalificaciones" style="display: none;">
                    <div class="col s12">
                        <table class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Materia</th>   
                                    <th>Asignatura</th> 
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    {{-- <th>Dic</th> --}}
                                    <th>Dic-Ene</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Abr</th>
                                    <th>May</th>
                                    <th>Jun</th>                                
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                            </tbody>
                        </table>
                    </div>
                </div>

                
            </div>

            <div class="card-action" style="display: none" id="boton-guardar">
                {{--  {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Cargando datos...";this.form.submit();','class' =>
                'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}  --}}
                <button type="button" class="btn-large btn-save waves-effect darken-3" id="guardar_calificaciones"><i class="material-icons left">save</i>Guardar</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<style>
    table tbody tr:nth-child(odd) {
        background: #E0DEE2;
    }
    table tbody tr:nth-child(even) {
        background: #F1F1F1;
    }
    table thead {
      background: #01579B;
      color: #fff;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
</style>
@endsection

@section('footer_scripts')


@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas')
@include('primaria.scripts.programas')
@include('primaria.scripts.planes')
@include('primaria.scripts.periodos')
@include('primaria.scripts.cgtsSinGrupoN')
@include('primaria.scripts.cursos')
@include('primaria.calificaciones.getcalificacionesGenerales')




@endsection
