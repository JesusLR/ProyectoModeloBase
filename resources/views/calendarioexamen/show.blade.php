@extends('layouts.dashboard')

@section('template_title')
    Calendario de Examen
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('calendarioexamen')}}" class="breadcrumb">Lista de Calendarios</a>
    <a href="{{url('calendarioexamen/'.$calendario->id)}}" class="breadcrumb">Ver Calendario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CALENDARIO #{{$calendario->id}}</span>

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
                    $ubicacion = $calendario->periodo->departamento->ubicacion;
                    $departamento = $calendario->periodo->departamento;
                    $periodo = $calendario->periodo;
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
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;" disabled>
                            <option value="{{$periodo->id}}" selected>
                                {{$periodo->perNumero}}-{{$periodo->perAnio}}
                            </option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">Semestre</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('perFechaInicial', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{$periodo->perFechaInicial}}" name="perFechaInicial" id="perFechaInicial" readonly>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('perFechaFinal', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{$periodo->perFechaFinal}}" name="perFechaFinal" id="perFechaFinal" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">1er. Parcial</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioParcial1', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{$calendario->calexInicioParcial1}}" name="calexInicioParcial1" id="calexInicioParcial1" readonly>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinParcial1', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" value="{{$calendario->calexFinParcial1}}" name="calexFinParcial1" id="calexFinParcial1" readonly>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">2do. Parcial</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioParcial2', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{$calendario->calexInicioParcial2}}" name="calexInicioParcial2" id="calexInicioParcial2" readonly>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinParcial2', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" value="{{$calendario->calexFinParcial2}}" name="calexFinParcial2" id="calexFinParcial2" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">3er. Parcial</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioParcial3', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{$calendario->calexInicioParcial3}}" name="calexInicioParcial3" id="calexInicioParcial3" readonly>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinParcial3', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" value="{{$calendario->calexFinParcial3}}" name="calexFinParcial3" id="calexFinParcial3" readonly>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">Ordinario</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioOrdinario', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{$calendario->calexInicioOrdinario}}" name="calexInicioOrdinario" id="calexInicioOrdinario" readonly>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinOrdinario', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" value="{{$calendario->calexFinOrdinario}}" name="calexFinOrdinario" id="calexFinOrdinario" readonly>
                        </div>
                    </div>
                </div>

                
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection
