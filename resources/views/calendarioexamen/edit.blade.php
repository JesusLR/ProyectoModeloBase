@extends('layouts.dashboard')

@section('template_title')
    Calendario de Examen
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('calendarioexamen')}}" class="breadcrumb">Lista de Calendarios</a>
    <a href="{{url('calendarioexamen/'.$calendario->id.'/edit')}}" class="breadcrumb">Editar Calendario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['calendarioexamen.update', $calendario->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR CALENDARIO #{{$calendario->id}}</span>

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
                            <input type="date" value="{{old('calexInicioParcial1') ?: $calendario->calexInicioParcial1}}" name="calexInicioParcial1" id="calexInicioParcial1">
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinParcial1', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexFinParcial1') ?: $calendario->calexFinParcial1}}" name="calexFinParcial1" id="calexFinParcial1">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">2do. Parcial</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioParcial2', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexInicioParcial2') ?: $calendario->calexInicioParcial2}}" name="calexInicioParcial2" id="calexInicioParcial2">
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinParcial2', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexFinParcial2') ?: $calendario->calexFinParcial2}}" name="calexFinParcial2" id="calexFinParcial2">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">3er. Parcial</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioParcial3', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexInicioParcial3') ?: $calendario->calexInicioParcial3}}" name="calexInicioParcial3" id="calexInicioParcial3">
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinParcial3', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexFinParcial3') ?: $calendario->calexFinParcial3}}" name="calexFinParcial3" id="calexFinParcial3">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">Ordinario</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioOrdinario', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexInicioOrdinario') ?: $calendario->calexInicioOrdinario}}" name="calexInicioOrdinario" id="calexInicioOrdinario">
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinOrdinario', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexFinOrdinario') ?: $calendario->calexFinOrdinario}}" name="calexFinOrdinario" id="calexFinOrdinario">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">Período Extraordinarios 1</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioExtraordinario', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexInicioExtraordinario') ?: $calendario->calexInicioExtraordinario}}" name="calexInicioExtraordinario" id="calexInicioExtraordinario">
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinExtraordinario', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexFinExtraordinario') ?: $calendario->calexFinExtraordinario}}" name="calexFinExtraordinario" id="calexFinExtraordinario">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="row" style="background-color:#ECECEC;margin-right:3px;">
                            <p style="text-align: center;">Período Extraordinarios 2</p>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexInicioExtraordinario2', 'Fecha inicial', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexInicioExtraordinario2') ?: $calendario->calexInicioExtraordinario2}}" name="calexInicioExtraordinario2" id="calexInicioExtraordinario2" value="{{old('calexInicioExtraordinario2')}}">
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('calexFinExtraordinario2', 'Fecha final', array('class'=>'')) !!}
                            <input type="date" value="{{old('calexFinExtraordinario2') ?: $calendario->calexFinExtraordinario2}}" name="calexFinExtraordinario2" id="calexFinExtraordinario2" value="{{old('calexFinExtraordinario2')}}">
                        </div>
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