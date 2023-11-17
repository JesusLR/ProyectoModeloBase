@extends('layouts.dashboard')

@section('template_title')
    Secundaria cambio grupo ACD
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('secundaria.secundaria_cambio_grupo_acd.index')}}" class="breadcrumb">Cambiar grupo ACD</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'secundaria.secundaria_cambio_grupo_acd.index', 'method' => 'POST']) !!}
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
                            <div class="input-field col s12 m6 l6">
                                {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                                {!! Form::label('aluClave', 'Clave Pago', ['class' => '']); !!}
                            </div>
                            <div class="input-field col s12 m6 l6">                
                                <button type="button" id="buscar-grupos-acd" class="btn-large btn-save waves-effect darken-3">
                                    <i class="material-icons left">search</i>Buscar</button>
                            </div>
                        </div>   
                    </div>

                    <div class="row">                   

                        <div class="col s12 m6 l4">
                            <div id="quitarClass" class="input-field">
                                {!! Form::label('alumno_id', 'Alumno (Resultado de la búsqueda)', ['class' => '']); !!}
                                {!! Form::text('alumno_id', NULL, array('id' => 'alumno_id', 'class' => 'validate','readonly')) !!}

                            </div>
                        </div>
                    </div>

                    <div class="row">  
                        <div class="col s12 m6 l6">                        
                            {!! Form::label('grupo_id_origen', 'Grupo ACD origen *', array('class' => '')); !!}
                            <select id="grupo_id_origen" role="treeitem" aria-disabled="true" class="browser-default validate select2" disabled required name="grupo_id_origen" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>

                        <div class="col s12 m6 l6">                        
                            {!! Form::label('grupo_id_destino', 'Grupo ACD destino *', array('class' => '')); !!}
                            <select id="grupo_id_destino" role="treeitem" aria-disabled="true" class="browser-default validate select2" disabled required name="grupo_id_destino "
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>

                    <div class="row" style="display: none;">
                        <div class="col s12 m6 l4">
                            <div class="col s12 m6 l6">
                                {!! Form::label('curso_id', 'Curso Id', ['class' => '']); !!}
                                {!! Form::text('curso_id', NULL, array('id' => 'curso_id', 'class' => 'validate')) !!}
                            </div>                            
                        </div>   
                    </div>

               
                </div>

                
            </div>


            <div class="card-action" style="display: none" id="boton-guardar">

                <button type="button" id="ejecutar_el_cambio" class="btn-large btn-save waves-effect darken-3"><i class="material-icons left">save</i> Guardar</button>
              
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
@include('secundaria.cambio_grupo_acd.comboGrupoACDActual')
@include('secundaria.cambio_grupo_acd.ejecutarElCambio')





@endsection
