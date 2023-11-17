@extends('layouts.dashboard')

@section('template_title')
    Idiomas nivel
@endsection


@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_nivel')}}" class="breadcrumb">Lista de niveles</a>
    <label class="breadcrumb">Ver de nivel</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">NIVEL #{{$nivel->id}}</span>

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
                            {!! Form::text('programa_id', $nivel->progClave, array('readonly' => 'true')) !!}
                            {!! Form::label('programa_id', 'Clave de programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('plan_id', $nivel->planClave, array('readonly' => 'true')) !!}
                            {!! Form::label('plan_id', 'Clave del programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivGrado', $nivel->nivGrado, array('readonly' => 'true')) !!}
                            {!! Form::label('nivGrado', 'Número de nivel', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivDescripcion', $nivel->nivDescripcion.' '.$nivel->empApellido1.' '.$nivel->empApellido2, array('readonly' => 'true')) !!}
                            {!! Form::label('nivDescripcion', 'Descripción de nivel', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte1', $nivel->nivPorcentajeReporte1, array('readonly' => 'true')) !!}
                            {!! Form::label('nivPorcentajeReporte1', 'Reporte 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte2', $nivel->nivPorcentajeReporte2, array('readonly' => 'true')) !!}
                            {!! Form::label('nivPorcentajeReporte2', 'Reporte 2', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeMidterm', $nivel->nivPorcentajeMidterm, array('readonly' => 'true')) !!}
                            {!! Form::label('nivPorcentajeMidterm', 'Ex.Mid.Term.', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeProyecto1', $nivel->nivPorcentajeProyecto1, array('readonly' => 'true')) !!}
                            {!! Form::label('nivPorcentajeProyecto1', 'Proyecto 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte3', $nivel->nivPorcentajeReporte3, array('readonly' => 'true')) !!}
                            {!! Form::label('nivPorcentajeReporte3', 'Reporte 3', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('nivPorcentajeReporte4', $nivel->nivPorcentajeReporte4, array('readonly' => 'true')) !!}
                            {!! Form::label('nivPorcentajeReporte4', 'Reporte 4', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeFinal', $nivel->nivPorcentajeFinal, array('readonly' => 'true')) !!}
                            {!! Form::label('nivPorcentajeFinal', 'Final Ex.', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12  m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeProyecto2', $nivel->nivPorcentajeProyecto2, array('readonly' => 'true')) !!}
                            {!! Form::label('nivPorcentajeProyecto2', 'Proyecto 2', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection
