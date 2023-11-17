@extends('layouts.dashboard')

@section('template_title')
    Departamento
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('departamento')}}" class="breadcrumb">Lista de departamentos</a>
    <label class="breadcrumb">Ver departamento</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">DEPARTAMENTO #{{$departamento->id}}</span>

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
                            {!! Form::text('ubicacion_id', $departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubicacion_id', 'Ubicación', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depClave', $departamento->depClave, array('readonly' => 'true')) !!}
                            {!! Form::label('depClave', 'Clave departamento', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombre', $departamento->depNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('depNombre', 'Nombre departamento', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombreCorto', $departamento->depNombreCorto, array('readonly' => 'true')) !!}
                            {!! Form::label('depNombreCorto', 'Nombre corto (15 carateres)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('depNivel', $departamento->depNivel, array('readonly' => 'true')) !!}
                            {!! Form::label('depNivel', 'Identificador (Prefijo nivel)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depClaveOficial', $departamento->depClaveOficial, array('readonly' => 'true')) !!}
                            {!! Form::label('depClaveOficial', 'Clave oficial (SEP)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombreOficial', $departamento->depNombreOficial, array('readonly' => 'true')) !!}
                            {!! Form::label('depNombreOficial', 'Nombre oficial (SEP)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perAnte', $departamento->perAnte, array('readonly' => 'true')) !!}
                            {!! Form::label('perAnte', 'Periodo anterior', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perActual', $departamento->perActual, array('readonly' => 'true')) !!}
                            {!! Form::label('perActual', 'Periodo actual', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perSig', $departamento->perSig, array('readonly' => 'true')) !!}
                            {!! Form::label('perSig', 'Periodo siguiente', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('depCalMinAprob', $departamento->depCalMinAprob, array('readonly' => 'true')) !!}
                            {!! Form::label('depCalMinAprob', 'Calif. Mínima', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('depCupoGpo', $departamento->depCupoGpo, array('readonly' => 'true')) !!}
                            {!! Form::label('depCupoGpo', 'Cupo de grupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depIncorporadoA', $departamento->depIncorporadoA, array('readonly' => 'true')) !!}
                            {!! Form::label('depIncorporadoA', 'Incorporado a:', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depTituloDoc', $departamento->depTituloDoc, array('readonly' => 'true')) !!}
                            {!! Form::label('depTituloDoc', 'Titulo firma', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombreDoc', $departamento->depNombreDoc, array('readonly' => 'true')) !!}
                            {!! Form::label('depNombreDoc', 'Nombre firma', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depPuestoDoc', $departamento->depPuestoDoc, array('readonly' => 'true')) !!}
                            {!! Form::label('depPuestoDoc', 'Puesto de quien firma', array('class' => '')); !!}
                        </div>
                    </div>
                </div>


          </div>
        </div>
    </div>
  </div>

@endsection
