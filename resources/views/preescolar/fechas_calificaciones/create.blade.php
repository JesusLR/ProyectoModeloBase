@extends('layouts.dashboard')

@section('template_title')
   Preescolar fechas de calificaciones
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preescolar_fecha_de_calificaciones')}}" class="breadcrumb">Lista de fechas de calificaciones</a>
    <label class="breadcrumb">Agregar fecha de calificaciones</label>
@endsection

@section('content')
@php
use App\Models\User;
@endphp

<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'preescolar.preescolar_fecha_de_calificaciones.store', 'method' => 'POST']) !!}
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">AGREGAR FECHA DE CALIFICACIONES</span>

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
                                {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                                <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4">
                                <div class="">
                                {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                                {!! Form::date('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                                </div>
                            </div>
                            <div class="col s12 m6 l4">
                                <div class="">
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                                {!! Form::date('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
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
                                {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                                <select id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2"  name="plan_id" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                </select>
                            </div>                         
                        </div>
               

                        <br>
                        <div class="row" style="background-color:#ECECEC;">
                            <p style="text-align: center;font-size:1.2em;">TRIMESTRE 1</p>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre1_docente_inicio', 'Fecha de inicio *', array('class' => '')); !!}
                                {!! Form::date('trimestre1_docente_inicio', old('trimestre1_docente_inicio'), array('id' => 'trimestre1_docente_inicio', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>                
                            
                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre1_docente_fin', 'Fecha de fin *', array('class' => '')); !!}
                                {!! Form::date('trimestre1_docente_fin', old('trimestre1_docente_fin'), array('id' => 'trimestre1_docente_fin', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre1_administrativo_edicion', 'Fecha de edición administrativa *', array('class' => '')); !!}
                                {!! Form::date('trimestre1_administrativo_edicion', old('trimestre1_administrativo_edicion'), array('id' => 'trimestre1_administrativo_edicion', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre1_alumnos_publicacion', 'Fecha de publicación para alumnos *', array('class' => '')); !!}
                                {!! Form::date('trimestre1_alumnos_publicacion', old('trimestre1_alumnos_publicacion'), array('id' => 'trimestre1_alumnos_publicacion', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>
                        </div>


                        <br>
                        <div class="row" style="background-color:#ECECEC;">
                            <p style="text-align: center;font-size:1.2em;">TRIMESTRE 2</p>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre2_docente_inicio', 'Fecha de inicio *', array('class' => '')); !!}
                                {!! Form::date('trimestre2_docente_inicio', old('trimestre2_docente_inicio'), array('id' => 'trimestre2_docente_inicio', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>                
                            
                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre2_docente_fin', 'Fecha de fin *', array('class' => '')); !!}
                                {!! Form::date('trimestre2_docente_fin', old('trimestre2_docente_fin'), array('id' => 'trimestre2_docente_fin', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre2_administrativo_edicion', 'Fecha de edición administrativa *', array('class' => '')); !!}
                                {!! Form::date('trimestre2_administrativo_edicion', old('trimestre2_administrativo_edicion'), array('id' => 'trimestre2_administrativo_edicion', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre2_alumnos_publicacion', 'Fecha de publicación para alumnos *', array('class' => '')); !!}
                                {!! Form::date('trimestre2_alumnos_publicacion', old('trimestre2_alumnos_publicacion'), array('id' => 'trimestre2_alumnos_publicacion', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>
                        </div>

                        <br>
                        <div class="row" style="background-color:#ECECEC;">
                            <p style="text-align: center;font-size:1.2em;">TRIMESTRE 3</p>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre3_docente_inicio', 'Fecha de inicio *', array('class' => '')); !!}
                                {!! Form::date('trimestre3_docente_inicio', old('trimestre3_docente_inicio'), array('id' => 'trimestre3_docente_inicio', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>                
                            
                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre3_docente_fin', 'Fecha de fin *', array('class' => '')); !!}
                                {!! Form::date('trimestre3_docente_fin', old('trimestre3_docente_fin'), array('id' => 'trimestre3_docente_fin', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre3_administrativo_edicion', 'Fecha de edición administrativa *', array('class' => '')); !!}
                                {!! Form::date('trimestre3_administrativo_edicion', old('trimestre3_administrativo_edicion'), array('id' => 'trimestre3_administrativo_edicion', 'class' => 'validate','required','maxlength'=>'255')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre3_alumnos_publicacion', 'Fecha de publicación para alumnos *', array('class' => '')); !!}
                                {!! Form::date('trimestre3_alumnos_publicacion', old('trimestre3_alumnos_publicacion'), array('id' => 'trimestre3_alumnos_publicacion', 'class' => 'validate','required','maxlength'=>'255')) !!}
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

{{--  @include('preescolar.scripts.preferencias')  --}}
@include('preescolar.scripts.departamentos')
@include('preescolar.scripts.escuelas')
@include('preescolar.scripts.programas')
@include('preescolar.scripts.planes')
@include('preescolar.scripts.periodos')


@endsection
