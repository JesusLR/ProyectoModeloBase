@extends('layouts.dashboard')

@section('template_title')
    Escolaridad
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('escolaridad')}}" class="breadcrumb">Lista de escolaridades</a>
    <label class="breadcrumb">Ver escolaridad</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">ESCOLARIDAD #{{$escolaridad->id}}</span>

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
                    <div class="col s12">
                        <div class="input-field">
                            {!! Form::text('empleado_id', $escolaridad->empleado->id.' - '.$escolaridad->empleado->persona->perNombre.' '.$escolaridad->empleado->persona->perApellido1.' '.$escolaridad->empleado->persona->perApellido2, array('readonly' => 'true')) !!}
                            {!! Form::label('empleado_id', 'Empleado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                            {!! Form::text('profesion_id', strtoupper($escolaridad->profesion->id.' - '.$escolaridad->profesion->profNombre), array('readonly' => 'true')) !!}
                            {!! Form::label('profesion_id', 'Profesión', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                            {!! Form::text('profNivel', nivel_profesion($escolaridad->profesion->profNivel), array('readonly' => 'true')) !!}
                            {!! Form::label('profNivel', 'Nivel profesión', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                            {!! Form::text('abreviaturaTitulo_id', strtoupper($escolaridad->abreviatura->id.' - '.$escolaridad->abreviatura->abtDescripcion), array('readonly' => 'true')) !!}
                            {!! Form::label('abreviaturaTitulo_id', 'Abreviatura', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                            {!! Form::text('escoGraduado', sino($escolaridad->escoGraduado), array('readonly' => 'true')) !!}
                            {!! Form::label('escoGraduado', 'Graduado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                            {!! Form::text('abtDescripcion', documento($escolaridad->escoTipoDocumento), array('readonly' => 'true')) !!}
                            {!! Form::label('abtDescripcion', 'Tipo de documento', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escoFolio', $escolaridad->escoFolio, array('readonly' => 'true')) !!}
                            {!! Form::label('escoFolio', 'Folio documento', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escoFechaDocumento', $escolaridad->escoFechaDocumento, array('readonly' => 'true')) !!}
                            {!! Form::label('escoFechaDocumento', 'Fecha documento', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                            {!! Form::text('escoObservaciones', $escolaridad->escoObservaciones, array('readonly' => 'true')) !!}
                            {!! Form::label('escoObservaciones', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                            {!! Form::text('escoUltimoGrado', sino($escolaridad->escoUltimoGrado), array('readonly' => 'true')) !!}
                            {!! Form::label('escoUltimoGrado', 'Máximo grado', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          </div>
        </div>
    </div>
  </div>

@endsection

@php
    function nivel_profesion($valor){
        switch ($valor) {
            case 'L':
                return 'LICENCIATURA';
                break;
            case 'E':
                return 'ESPECIALIDAD';
                break;
            case 'M':
                return 'MAESTRIA';
                break;
            case 'D':
                return 'DOCTORADO';
                break;
            default:
                return 'NINGUNO';
        }
    }
    function sino($valor){
        switch ($valor) {
            case 'S':
                return 'SI';
                break;
            default:
                return 'NO';
        }
    }
    function documento($valor){
        switch ($valor) {
            case 'C':
                return 'CEDULA';
                break;
            case 'T':
                return 'TITULO';
                break;
            case 'A':
                return 'ACTA';
                break;
            case '0':
                return 'OTRO';
                break;
            default:
                return 'NINGUNO';
        }
    }
@endphp