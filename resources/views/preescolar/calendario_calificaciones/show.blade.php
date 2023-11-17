@extends('layouts.dashboard')

@section('template_title')
   Preescolar fechas de calificaciones
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preescolar_fecha_de_calificaciones')}}" class="breadcrumb">Lista de fechas de calificaciones</a>
    <label class="breadcrumb">Ver fecha de calificaciones</label>
@endsection

@section('content')
@php
use App\Models\User;
@endphp

<div class="row">
    <div class="col s12 ">
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">FECHA DE CALIFICACIONES #{{$preescolar_calificaciones_fechas->id}}</span>

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
                                <input type="text" readonly value="{{$preescolar_calificaciones_fechas->ubiClave.'-'.$preescolar_calificaciones_fechas->ubiNombre}}">
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                                <input type="text" readonly value="{{$preescolar_calificaciones_fechas->depClave.'-'.$preescolar_calificaciones_fechas->depNombre}}">
                            </div>
                            <div class="col s12 m6 l4">
                                {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                                <input type="text" readonly value="{{$preescolar_calificaciones_fechas->escClave.'-'.$preescolar_calificaciones_fechas->escNombre}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m6 l4">
                                {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                                <input type="text" readonly value="{{$preescolar_calificaciones_fechas->perNumero.'-'.$preescolar_calificaciones_fechas->perAnioPago}}">
                            </div>
                            <div class="col s12 m6 l4">
                                <div class="">
                                {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                                {!! Form::date('perFechaInicial', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->perFechaInicial)->format('Y-m-d'), array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                                </div>
                            </div>
                            <div class="col s12 m6 l4">
                                <div class="">
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                                {!! Form::date('perFechaFinal', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->perFechaFinal)->format('Y-m-d'), array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m6 l4">
                                {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                                <input type="text" readonly value="{{$preescolar_calificaciones_fechas->progClave.'-'.$preescolar_calificaciones_fechas->progNombre}}">
                            </div>

                            <div class="col s12 m6 l4">
                                {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                                <input type="text" readonly value="{{$preescolar_calificaciones_fechas->planClave}}">
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
                                {!! Form::date('trimestre1_docente_inicio', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre1_docente_inicio)->format('Y-m-d'), array('id' => 'trimestre1_docente_inicio', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                            </div>                
                            
                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre1_docente_fin', 'Fecha de fin *', array('class' => '')); !!}
                                {!! Form::date('trimestre1_docente_fin', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre1_docente_fin)->format('Y-m-d'), array('id' => 'trimestre1_docente_fin', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre1_administrativo_edicion', 'Fecha de edición administrativa *', array('class' => '')); !!}
                                {!! Form::date('trimestre1_administrativo_edicion', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre1_administrativo_edicion)->format('Y-m-d'), array('id' => 'trimestre1_administrativo_edicion', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre1_alumnos_publicacion', 'Fecha de publicacón para alumnos *', array('class' => '')); !!}
                                {!! Form::date('trimestre1_alumnos_publicacion', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre1_alumnos_publicacion)->format('Y-m-d'), array('id' => 'trimestre1_alumnos_publicacion', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
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
                                {!! Form::date('trimestre2_docente_inicio', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre2_docente_inicio)->format('Y-m-d'), array('id' => 'trimestre2_docente_inicio', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                            </div>                
                            
                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre2_docente_fin', 'Fecha de fin *', array('class' => '')); !!}
                                {!! Form::date('trimestre2_docente_fin', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre2_docente_fin)->format('Y-m-d'), array('id' => 'trimestre2_docente_fin', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre2_administrativo_edicion', 'Fecha de edición administrativa *', array('class' => '')); !!}
                                {!! Form::date('trimestre2_administrativo_edicion', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre2_administrativo_edicion)->format('Y-m-d'), array('id' => 'trimestre2_administrativo_edicion', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre2_alumnos_publicacion', 'Fecha de publicacón para alumnos *', array('class' => '')); !!}
                                {!! Form::date('trimestre2_alumnos_publicacion', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre2_alumnos_publicacion)->format('Y-m-d'), array('id' => 'trimestre2_alumnos_publicacion', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
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
                                {!! Form::date('trimestre3_docente_inicio', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre3_docente_inicio)->format('Y-m-d'), array('id' => 'trimestre3_docente_inicio', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                            </div>                
                            
                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre3_docente_fin', 'Fecha de fin *', array('class' => '')); !!}
                                {!! Form::date('trimestre3_docente_fin', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre3_docente_fin)->format('Y-m-d'), array('id' => 'trimestre3_docente_fin', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre3_administrativo_edicion', 'Fecha de edición administrativa *', array('class' => '')); !!}
                                {!! Form::date('trimestre3_administrativo_edicion', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre3_administrativo_edicion)->format('Y-m-d'), array('id' => 'trimestre3_administrativo_edicion', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                            </div>

                            <div class="col s12 m6 l3">
                                {!! Form::label('trimestre3_alumnos_publicacion', 'Fecha de publicacón para alumnos *', array('class' => '')); !!}
                                {!! Form::date('trimestre3_alumnos_publicacion', \Carbon\Carbon::parse($preescolar_calificaciones_fechas->trimestre3_alumnos_publicacion)->format('Y-m-d'), array('id' => 'trimestre3_alumnos_publicacion', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                            </div>
                        </div>
                       
                    </div>
                </div>

                <div class="card-action">
                </div>
            </div>
    </div>
  </div>

@endsection

@section('footer_scripts')


@endsection
