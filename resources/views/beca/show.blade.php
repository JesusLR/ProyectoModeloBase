@extends('layouts.dashboard')

@section('template_title')
    Beca
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('beca')}}" class="breadcrumb">Lista de Becas</a>
    <label class="breadcrumb">Ver beca</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Beca #{{$beca->id}}</span>

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
                    {!! Form::text('id', $beca->id, array('readonly' => 'true')) !!}
                    {!! Form::label('id', 'Número', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('bcaClave', $beca->bcaClave, array('readonly' => 'true')) !!}
                    {!! Form::label('bcaClave', 'cLAVE', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('bcaNombre', $beca->bcaNombre, array('readonly' => 'true')) !!}
                    {!! Form::label('bcaNombre', 'Nombre', array('class' => '')); !!}
                  </div>
                </div>
              </div>

              
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('bcaNombreCorto', $beca->bcaNombreCorto, array('readonly' => 'true')) !!}
                    {!! Form::label('bcaNombreCorto', 'Nombre corto', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('bcaVigencia', $beca->bcaVigencia, array('readonly' => 'true')) !!}
                    {!! Form::label('bcaVigencia', 'Vigencia', array('class' => '')); !!}
                  </div>
                </div>
              </div>
          </div>
        </div>
    </div>
  </div>

@endsection
