@extends('layouts.dashboard')

@section('template_title')
    Puesto
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('puestos')}}" class="breadcrumb">Lista de Puestos</a>
    <label class="breadcrumb">Ver puesto</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">PUESTO #{{$puesto->id}}</span>

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
                            <label for="puesNombre">Nombre del Puesto</label>
                            <input type="text" name="puesNombre" value="{{$puesto->puesNombre}}" readonly>
                        </div>
                    </div>
                </div>

          </div>
        </div>
    </div>
  </div>

@endsection
