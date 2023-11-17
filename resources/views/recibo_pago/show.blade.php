@extends('layouts.dashboard')

@section('template_title')
    Recibo de pago
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('recibo_pago')}}" class="breadcrumb">Lista de recibos de pago</a>
    <label class="breadcrumb">Ver recibo de pago</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Recibo Folio #{{$reciboPago->id}}</span>

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
                            <label for="fecha">Fecha</label>
                            <input type="text" name="fecha" value="{{$reciboPago->fecha}}" readonly>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="aluClave">Clave del alumno</label>
                            <input type="text" name="aluClave" value="{{$reciboPago->aluClave}}" readonly>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="perApellido1">Apellido paterno</label>
                            <input type="text" name="perApellido1" value="{{$reciboPago->perApellido1}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="perApellido2">Apellido materno</label>
                            <input type="text" name="perApellido2" value="{{$reciboPago->perApellido2}}" readonly>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" value="{{$reciboPago->perNombre}}" readonly>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="conpClave">Clave</label>
                            <input type="text" name="conpClave" value="{{$reciboPago->conpClave}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="importe">Importe</label>
                            <input type="text" name="importe" value="{{$reciboPago->importe}}" readonly>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="reciboEstado">Estado del recibo</label>
                            <input type="text" name="reciboEstado" value="{{$reciboPago->reciboEstado}}" readonly>
                        </div>
                    </div>
                </div>

          </div>
        </div>
    </div>
  </div>

@endsection
