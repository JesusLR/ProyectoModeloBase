@extends('layouts.dashboard')

@section('template_title')
    Bachiller cambiar CGT - Grupo
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    {{--  <a href="{{route('bachiller_asignar_grupo.index')}}" class="breadcrumb">Lista de Inscritos</a>  --}}
    <a href="{{route('bachiller.bachiller_cambiar_cgt_yucatan.edit')}}" class="breadcrumb">Cambiar CGT</a>
    <a href="{{route('bachiller.bachiller_cambiar_cgt_yucatan.edit')}}" class="breadcrumb">Cambiar CGT - Grupo </a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_cambiar_cgt_yucatan.update', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">CAMBIAR CGT - GRUPO</span>

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
                            {!! Form::label('cgt_id', 'CGT *', array('class' => '')); !!}
                            <select id="cgt_id" class="browser-default validate select2" required name="cgt_id"
                                style="width: 100%;">
                                {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            </select>
                        </div>
                    </div>

                </div>

                <br><br>
                <div class="row" id="Tabla">
                    <div class="col s12">
                        <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
                        </div>
                    </div>
                </div>
            </div>

            





            <div class="card-action" style="display: none" id="boton-guardar">
                {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Cargando datos...";this.form.submit();','class' =>
                'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<style>
    table tbody tr:nth-child(odd) {
        background: #F3F4F7;
    }

    table tbody tr:nth-child(even) {
        background: #DFDCDB;
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


@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_periodos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
@include('bachiller.scripts.periodos')
@include('bachiller.scripts.cgts_sin_grupo_N')
@include('bachiller.scripts.cursos')
@include('bachiller.cambiar_cgt_yuc.crearTablaJs')




@endsection
