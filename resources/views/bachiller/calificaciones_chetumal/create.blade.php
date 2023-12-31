@extends('layouts.dashboard')

@section('template_title')
Bachiller calficaciones
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{route('bachiller.bachiller_grupo_seq.index')}}" class="breadcrumb">Lista de grupos</a>
<a href="{{route('bachiller.bachiller_calificacion_seq.create')}}" class="breadcrumb">Agregar calificaciones</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['enctype' => 'multipart/form-data', 'onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_calificacion_seq.guardarCalificacion', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">CALIFICACIONES</span>

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
                            {!! Form::label('periodo_id2', 'Periodo *', ['class' => '']); !!}
                            <select name="periodo_id2" id="periodo_id2" class="browser-default validate select2"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach ($periodos as $periodo)
                                <option value="{{ $periodo->id }}" {{ old('grupo_id') == $periodo->id ? 'selected' : '' }}>{{ $periodo->perAnioPago }}-{{ $periodo->perNumero}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('grupo_id2', 'Grupo *', ['class' => '']); !!}
                            <select name="grupo_id2" id="grupo_id2"
                                class="browser-default validate select2" style="width: 100%;">

                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('materia_id2', 'Materia *', ['class' => '']); !!}
                            <select name="materia_id2" id="materia_id2" data-materia_id2="{{old('materia_id2')}}" class="browser-default validate select2"
                                style="width: 100%;">

                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('bachiller_grupo_evidencia_id', 'Mes de evaluación *', array('class' => '')); !!}
                            <select id="bachiller_grupo_evidencia_id" class="browser-default validate select2" required name="bachiller_grupo_evidencia_id" style="width: 100%;" data-mes-idold="bachiller_grupo_evidencia_id">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4" style="display: none">
                            {!! Form::label('mes', 'Mes de evaluación *', array('class' => '')); !!}
                            <select id="mes" class="browser-default validate select2" required name="mes" style="width: 100%;" data-mes-idold="mes">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('numero_evaluacion', 'Número de evaluación *', array('class' => '')); !!}
                            <select id="numero_evaluacion" class="browser-default validate select2" required name="numero_evaluacion" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                          </div>

                          <div class="col s12 m6 l4" style="margin-top: -9px">
                            <div class="input-field" id="input-field">
                                {!! Form::label('numero_evidencias', 'Total de evidencias a registrar *', array('class' => '')); !!}
                                <input type="text" readonly="true" name="numero_evidencias" id="numero_evidencias" required>
                            </div>
                        </div>
                    </div>


                    <div class="row" id="Tabla" style="display: none">
                        <div class="col s12">
                            <table class="responsive-table display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th scope="col">Nombre</p></th>
                                        <th class="classEvi1" scope="col"><p id="nombreEvidencia1"></p> <p> <label style="color:#fff" id="evi1"></label> <label style="color:#fff">%</label></p></th>
                                        <th class="classEvi2" scope="col"><p id="nombreEvidencia2"></p> <p> <label style="color:#fff" id="evi2"></label> <label style="color:#fff">%</label></p></th>
                                        <th class="classEvi3" scope="col"><p id="nombreEvidencia3"></p> <p> <label style="color:#fff" id="evi3"></label> <label style="color:#fff">%</label></p></th>
                                        <th class="classEvi4" scope="col"><p id="nombreEvidencia4"></p> <p> <label style="color:#fff" id="evi4"></label> <label style="color:#fff">%</label></p></th>
                                        <th class="classEvi5" scope="col"><p id="nombreEvidencia5"></p> <p> <label style="color:#fff" id="evi5"></label> <label style="color:#fff">%</label></p></th>
                                        <th class="classEvi6" scope="col"><p id="nombreEvidencia6"></p> <p> <label style="color:#fff" id="evi6"></label> <label style="color:#fff">%</label></p></th>
                                        <th class="classEvi7" scope="col"><p id="nombreEvidencia7"></p> <p> <label style="color:#fff" id="evi7"></label> <label style="color:#fff">%</label></p></th>
                                        <th class="classEvi8" scope="col"><p id="nombreEvidencia8"></p> <p> <label style="color:#fff" id="evi8"></label> <label style="color:#fff">%</label></p></th>
                                        <th class="classEvi9" scope="col"><p id="nombreEvidencia9"></p> <p> <label style="color:#fff" id="evi9"></label> <label style="color:#fff">%</label></p></th>
                                        <th class="classEvi10" scope="col"><p id="nombreEvidencia10"></p> <p> <label style="color:#fff" id="evi10"></label> <label style="color:#fff">%</label></p></th>
                                        <th class="classPromedioMes" scope="col">PROMEDIO<p>DEL MES</p></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="card-action">
                    <button onclick="click();" class="btn-large waves-effect darken-3" type="submit">Guardar<i class="material-icons left">save</i></button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>


    <style>
        .letraNormal {
            font-weight: normal;
        }
    </style>

    
 <style>
    table tbody tr:nth-child(odd) {
        background: #F7F8F9;
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

@include('bachiller.calificaciones_chetumal.funcionesJsParaCrear')

@endsection
