@extends('layouts.dashboard')

@section('template_title')
    Gimnasio
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('usuariogim')}}" class="breadcrumb">Lista de usuarios de gimnasio</a>
    <a href="{{url('usuariogim/'.$usuariogim->id)}}" class="breadcrumb">Ver Usuario</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Usuario #{{$usuariogim->id}}</span>

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
                    $aluClave = $usuariogim->alumno ? $usuariogim->alumno->aluClave : '';
                @endphp
                
                <br>
                <div class="row">
                    <div class="col s12 m6 l6">
                        <label for="gimTipo">Tipo de usuario</label>
                        <select name="gimTipo" id="gimTipo" class="browser-default validate select2" style="width:100%;" required>
                            <option value="{{$usuariogim->gimTipo}}">{{$usuariogim->gimTipo}} - {{$usuariogim->tipo->tugDescripcion}} - ${{$usuariogim->tipo->tugImporte}}</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="aluClave">Clave de pago</label>
                            <input type="number" name="aluClave" id="aluClave" class="validate" value="{{$aluClave}}" readonly>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field col s12 m6 l6">
                            <input type="text" name="gimApellidoPaterno" id="gimApellidoPaterno" value="{{$usuariogim->gimApellidoPaterno}}" class="validate" required readonly>
                            <label for="gimApellidoPaterno">Apellido Paterno</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input type="text" name="gimApellidoMaterno" id="gimApellidoMaterno" value="{{$usuariogim->gimApellidoMaterno}}" class="validate" readonly>
                            <label for="gimApellidoMaterno">Apellido Materno</label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="text" name="gimNombre" id="gimNombre" value="{{$usuariogim->gimNombre}}" class="validate" required readonly>
                            <label for="gimNombre">Nombre</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="text" name="gimUltimoPago" id="gimUltimoPago" value="{{$gimUltimoPago}}" class="validate" readonly>
                            <label for="gimUltimoPago">Fecha último pago</label>
                        </div>
                    </div>
                </div>

                
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection
