@extends('layouts.dashboard')

@section('template_title')
    Idiomas materia
@endsection


@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_materia')}}" class="breadcrumb">Lista de materias</a>
    <label class="breadcrumb">Ver de materia</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">MATERIA #{{$materia->id}}</span>

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
                        <div class="input-field">
                            {!! Form::text('programa_id', $materia->progClave, array('readonly' => 'true')) !!}
                            {!! Form::label('programa_id', 'Clave de programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('plan_id', $materia->planClave, array('readonly' => 'true')) !!}
                            {!! Form::label('plan_id', 'Clave del programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matClave', $materia->matClave, array('readonly' => 'true')) !!}
                            {!! Form::label('matClave', 'Clave de la materia', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombre', $materia->matNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('matNombre', 'Nombre de la materia', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombreCorto', $materia->matNombreCorto, array('readonly' => 'true')) !!}
                            {!! Form::label('matNombreCorto', 'Nombre corto de la materia', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matSemestre', $materia->matSemestre, array('readonly' => 'true')) !!}
                            {!! Form::label('matSemestre', 'Semestre', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matCreditos', $materia->matCreditos, array('readonly' => 'true')) !!}
                            {!! Form::label('matCreditos', 'Créditos', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matClasificacion', $materia->matClasificacion, array('readonly' => 'true')) !!}
                            {!! Form::label('matClasificacion', 'Clasificación', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matTipoAcreditacion', $materia->matTipoAcreditacion, array('readonly' => 'true')) !!}
                            {!! Form::label('matTipoAcreditacion', 'Tipo de acreditación', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('matPorcentajeParcial', $materia->matPorcentajeParcial, array('readonly' => 'true')) !!}
                            {!! Form::label('matPorcentajeParcial', 'Parcial %', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matPorcentajeOrdinario', $materia->matPorcentajeOrdinario, array('readonly' => 'true')) !!}
                            {!! Form::label('matPorcentajeOrdinario', 'Ordinario %', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection
