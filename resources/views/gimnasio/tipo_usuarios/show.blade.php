@extends('layouts.dashboard')

@section('template_title')
    Gimnasio
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('gimnasio_usuario')}}" class="breadcrumb">Lista de usuarios de gimnasio</a>
    <a href="{{url('gimnasio_usuario/'.$tipo->id)}}" class="breadcrumb">Ver Usuario</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Usuario #{{$tipo->id}}</span>

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

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="tugClave">Clave</label>
                            <input type="text" name="tugClave" id="tugClave" class="validate" value="{{$tipo->tugClave}}" readonly>
                        </div>
                    </div>
                    <div class="col s12 m6 l8">
                        <div class="input-field col s12 m6 l4">
                            <input type="text" name="tugDescripcion" id="tugDescripcion" value="{{$tipo->tugDescripcion}}" class="validate" required readonly>
                            <label for="tugDescripcion">Descripción</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <input type="text" name="tugImporte" id="tugImporte" value="{{$tipo->tugImporte}}" class="validate" readonly>
                            <label for="tugImporte">Importe</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <input type="text" name="tugVigente" id="tugVigente" value="{{$tipo->tugVigente}}" class="validate" readonly>
                            <label for="tugVigente">Vigente</label>
                        </div>
                    </div>
                </div>

                
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection
