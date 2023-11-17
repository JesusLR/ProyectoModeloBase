@extends('layouts.dashboard')

@section('template_title')
    Preescolar actividad inscrito
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('preescolar.preescolar_actividades_inscritos.index')}}" class="breadcrumb">Lista de actividades inscritos</a>
    <a href="{{url('preescolar_actividades_inscritos/'.$actividad_inscrito->id)}}" class="breadcrumb">Ver actividad inscrito</a>
@endsection

@section('content')
@php
use App\Models\User;
@endphp

<div class="row">
    <div class="col s12 ">
      <div class="card ">
          <div class="card-content ">
            <span class="card-title">ACTIVIDAD INSCRITO #{{$actividad_inscrito->id}}</span>

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
                        {!! Form::label('ubicacion_id', 'Ubicación', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad_inscrito->ubiClave ."-". $actividad_inscrito->ubiNombre}}">
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad_inscrito->depClave ."-". $actividad_inscrito->depNombre}}">                        
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad_inscrito->escClave ."-". $actividad_inscrito->escNombre}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::label('período_id', 'Periodo', array('class' => '')); !!}
                            <input type="text" readonly value="{{$actividad_inscrito->perNumero ."-". $actividad_inscrito->perAnioPago}}">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', $actividad_inscrito->perFechaInicial, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', $actividad_inscrito->perFechaFinal, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad_inscrito->progClave.'-'.$actividad_inscrito->progNombre}}">
                    </div>      
                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('actividad_id', 'Actividad', array('class' => '')); !!}
                        @if ($actividad_inscrito->perApellido1 != "")
                            <input type="text" readonly value="{{$actividad_inscrito->actGrupo.' - '.$actividad_inscrito->actDescripcion.' Instructor: '.$actividad_inscrito->empApellido1.' '.$actividad_inscrito->empApellido2. ' '.$actividad_inscrito->empNombre}}">
                        @else
                        <input type="text" readonly value="{{$actividad_inscrito->actGrupo.' - '.$actividad_inscrito->actDescripcion}}">
                        @endif
                        

                      
                    </div>     
                    
                </div>

               

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('alumno_id', 'Alumno', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad_inscrito->aluClave}} - {{$actividad_inscrito->perApellido1.' '.$actividad_inscrito->perApellido2.' '.$actividad_inscrito->perNombre}}" name="" id="">
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('aeiTipoBeca', 'Beca', array('class' => '')); !!}
                        <input type="text" readonly value="{{$becas->bcaNombre}}">
                    </div> 

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" readonly name="aeiPorcentajeBeca" id="aeiPorcentajeBeca" value="{{$actividad_inscrito->aeiPorcentajeBeca}}" min="0" max="100">
                        {!! Form::label('aeiPorcentajeBeca', 'Porcentaje beca', ['class' => '']); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            <input type="text" readonly maxlength="255" name="aeiObservacionesBeca" id="aeiObservacionesBeca" value="{{$actividad_inscrito->aeiObservacionesBeca}}">
                            {!! Form::label('aeiObservacionesBeca', 'Observación beca', ['class' => '']); !!}
                        </div>
                    </div>
                </div>



            </div>

          </div>
          
        </div>
    </div>
  </div>

@endsection

@section('footer_scripts')


@endsection
