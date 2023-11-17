@extends('layouts.dashboard')

@section('template_title')
    Secundaria cambio grupo ACD
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('secundaria.secundaria_lista_de_interasados.index')}}" class="breadcrumb">Cambiar grupo ACD</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'secundaria.secundaria_lista_de_interasados.imprimir', 'method' => 'POST', 'target' => '_blank']) !!}

        <div class="card ">
            <div class="card-content ">
                <span class="card-title">CAMBIAR GRUPO ACD</span>

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
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id" class="browser-default validate select2" required
                                name="departamento_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id" class="browser-default validate select2" required name="escuela_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id"
                                style="width: 100%;">
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
                                name="programa_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id" class="browser-default validate select2" required name="plan_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>                          
                         
                        <div class="col s12 m6 l4">
                            {!! Form::label('reporte_a_generar', 'Reporte a generar *', array('class' => '')); !!}
                            <select id="reporte_a_generar" class="browser-default validate select2" required name="reporte_a_generar"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="1">ALUMNOS PREINSCRITOS</option>
                                <option value="2">ALUMNOS INTERESADOS</option>
                            </select>
                        </div>  
                    </div>
               

               
                </div>

                
            </div>


            <div class="card-action">

                <button type="submit" id="ejecutar_el_cambio" class="btn-large btn-save waves-effect darken-3"><i class="material-icons left">save</i> Guardar</button>
              
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>


@endsection

@section('footer_scripts')


@include('secundaria.scripts.departamentos')
@include('secundaria.scripts.escuelas')
@include('secundaria.scripts.programas')
@include('secundaria.scripts.planes')
@include('secundaria.scripts.periodos')





@endsection
