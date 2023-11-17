@extends('layouts.dashboard')

@section('template_title')
    Responsable de registro / Certificación
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('registro')}}" class="breadcrumb">Lista de Responsables de registro</a>
    <a href="{{url('registro/'.$responsable->id)}}" class="breadcrumb">Ver Registro</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">REGISTRO #{{$responsable->id}}</span>

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


                @php
                    $departamento = $responsable->departamento;
                    $ubicacion = $departamento->ubicacion;
                @endphp
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;" disabled>
                            <option value="{{$ubicacion->id}}" selected>
                                {{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}
                            </option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"  class="browser-default validate select2" required name="departamento_id" style="width: 100%;" disabled>
                            <option value="{{$departamento->id}}" selected>
                                {{$departamento->depClave}}-{{$departamento->depNombre}}
                            </option>
                        </select>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('regFechaInicioVigencia', 'Fecha Inicio Vigencia', array('class'=>'')) !!}
                        <input type="date" name="regFechaInicioVigencia" id="regFechaInicioVigencia" value="{{$responsable->regFechaInicioVigencia}}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('regNombreResponsable', 'Nombre', array('class'=>'')) !!}
                        <input type="text" name="regNombreResponsable" id="regNombreResponsable" value="{{$responsable->regNombreResponsable}}" maxlength="100" class="validate" readonly>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('regCargoResponsable', 'Cargo', array('class'=>'')) !!}
                        <input type="text" name="regCargoResponsable" id="regCargoResponsable" value="{{$responsable->regCargoResponsable}}" maxlength="200" class="validate" readonly>
                    </div>
                </div>

                
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection
