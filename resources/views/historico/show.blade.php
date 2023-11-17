@extends('layouts.dashboard')

@section('template_title')
  Historico
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('abreviatura')}}" class="breadcrumb">Listado historico de calificaciones</a>
    <label class="breadcrumb">Ver historico</label>
@endsection

@section('content')


<div class="row">
  <div class="col s12 ">
    <div class="card ">
      <div class="card-content ">
        <span class="card-title">HISTORICO</span>

        {{-- NAVIGATION BAR--}}
        <nav class="nav-extended">
          <div class="nav-content">
            <ul class="tabs tabs-transparent">
              <li class="tab"><a class="active" href="#general">General</a></li>
            </ul>
          </div>
        </nav>

          
      </div>
    </div>
  </div>
</div>

@endsection
