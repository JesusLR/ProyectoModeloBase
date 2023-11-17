@extends('layouts.dashboard')

@section('template_title')
    Primaria migrar inscritos ACD
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_migrar_inscritos_acd.store')}}" class="breadcrumb">Migrar inscritos ACD</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'primaria.primaria_migrar_inscritos_acd.store', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">MIGRAR INSCRITOS ACD</span>

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
                                <option value="{{$ubicacion->ubiClave}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
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
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>                  
                    </div>


                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('gpoGrado', 'Grado *', array('class' => '')); !!}
                            <select id="gpoGrado" class="browser-default validate select2" required name="gpoGrado" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        
                    </div>

                </div>
                
            </div>

            

            <div class="card-action">             
                {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-guardar-migracion-acd btn-large waves-effect  darken-3']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

  <style>
    * {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    
    body {
        font-size: 16px;
        background: #fff;
        font-family: "Roboto";
    }
    
    .wrap {
        width: 90%;
        max-width: 1000px;
        margin: 0 20px;
        /*margin: auto;*/
    }
    
    .formulario h2 {
        font-size: 16px;
        color: #001F3F;
        margin-bottom: 20px;
        margin-left: 20px;
    }
    
    .formulario > div {
        padding: 20px 0;
        border-bottom: 1px solid #ccc;
    }
  </style>
@endsection

@section('footer_scripts')


@include('primaria.scripts.migrarinscritosACD')
@include('primaria.scripts.programas')
@include('primaria.scripts.planes')
@include('primaria.scripts.cursos')
@include('primaria.migrarIncritosACD.guardadoDeMigracion')




@endsection
