@extends('layouts.dashboard')

@section('template_title')
    Preinscrito Extraordinario
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preinscrito_extraordinario')}}" class="breadcrumb">Lista de Preisncritos a Extraordinarios</a>
    <a href="{{url('preinscrito_extraordinario/'.$preinscrito->id)}}" class="breadcrumb">Ver preinscrito</a>
@endsection

@section('content')

@php
    use App\Http\Helpers\Utils;
    $extFecha = Utils::fecha_string($preinscrito->extFecha, 'mesCorto');
@endphp

<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Preinscrito Clave de pago #{{$preinscrito->aluClave}}</span>

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

                <br>
                <div class="row" style="background-color:#ECECEC;">
                  <p style="text-align: center;font-size:1.2em;">Alumno</p>
                </div>
                
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 14">
                          {!! Form::number('aluClave', $preinscrito->aluClave, array('id' => 'aluClave', 'class' => 'validate','min'=>'0','required', 'readonly')) !!}
                          {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        {!! Form::text('aluNombre', $preinscrito->aluNombre, array('id' => 'aluNombre', 'class' => 'validate', 'readonly')) !!}
                        {!! Form::label('aluNombre', 'Nombre del Alumno', array('class' => '')); !!}
                    </div>
                </div>

                <br>
                <div class="row" style="background-color:#ECECEC;">
                  <p style="text-align: center;font-size:1.2em;">Extraordinario #{{$preinscrito->extraordinario_id}}</p>
                </div>

                <div class="row">
                    <div class="input-field col s12 m6 l4">
                        <input type="text" name="matClave" id="matClave" class="validate" value="{{$preinscrito->matClave}}" readonly>
                        <label for="matClave">Clave de Materia</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="text" name="matNombre" id="matNombre" class="validate" value="{{$preinscrito->matNombre}}" readonly>
                        <label for="matNombre">Materia</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="number" name="planClave" id="planClave" class="validate" value="{{$plan->planClave}}" readonly>
                        <label for="planClave">Plan</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m6 l4">
                        <input type="text" name="extFecha" id="extFecha" class="validate" value="{{$extFecha}}" readonly>
                        <label for="extFecha">Fecha de Examen</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="text" name="extHora" id="extHora" class="validate" value="{{$preinscrito->extHora}}" readonly>
                        <label for="extHora">Hora</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="number" name="extPago" id="extPago" class="validate" value="{{$preinscrito->extPago}}" readonly>
                        <label for="extPago">Costo</label>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12 m6 l4">
                        <input type="text" name="progClave" id="progClave" class="validate" value="{{$preinscrito->progClave}}" readonly>
                        <label for="progClave">Clave de carrera</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="text" name="progNombre" id="progNombre" class="validate" value="{{$preinscrito->progNombre}}" readonly>
                        <label for="progNombre">Nombre</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m6 l4">
                        <input type="text" name="ubiClave" id="ubiClave" class="validate" value="{{$preinscrito->ubiClave}}" readonly>
                        <label for="ubiClave">Clave de ubicación</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="text" name="ubiNombre" id="ubiNombre" class="validate" value="{{$preinscrito->ubiNombre}}" readonly>
                        <label for="ubiNombre">Ubicación</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="pexEstado">Estado</label>
                        <select name="pexEstado" id="pexEstado" class="default-browser validate select2" readonly>
                            @foreach($pexEstados as $key => $estado)
                                @if($key == $preinscrito->pexEstado)
                                    <option value="{{$key}}" selected>{{$estado}}</option>
                                @else
                                    <option value="{{$key}}">{{$estado}}</option>
                                @endif
                            @endforeach <!-- estado -->
                        </select>
                    </div>
                </div>

                
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection
