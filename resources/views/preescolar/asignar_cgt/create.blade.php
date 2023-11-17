@extends('layouts.dashboard')

@section('template_title')
    Preescolar asignar CGT
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{route('curso_preescolar.index')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('preescolar.preescolar_asignar_cgt.index')}}" class="breadcrumb">Asignar CGT</a>
@endsection

@section('content')
@php
use App\Models\User;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['enctype' => 'multipart/form-data', 'onKeypress' => 'return disableEnterKey(event)','route' => 'preescolar.preescolar_asignar_cgt.update', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Asignar CGT</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  @if (User::permiso("curso") != "P")
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  @endif
                  {{-- @if (User::permiso("curso") == "A" || User::permiso("curso") == "E" || User::permiso("curso") == "P")
                  <li class="tab"><a href="#cuotas">Cuotas</a></li>
                  <li class="tab"><a href="#becas">Becas</a></li>
                  @endif --}}
                </ul>
              </div>
            </nav>
            @if (User::permiso("curso") != "P")
            {{-- GENERAL BAR--}}
            <div id="general">


                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <div style="position:relative">
                            <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                                {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                                @foreach($ubicaciones as $ubicacion)
                                    @php
                                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                    $selected = '';
                                    if (!isset($campus)) {
                                        if($ubicacion->id == $ubicacion_id){
                                            $selected = 'selected';
                                        }
                                    }
                                    $selected = (isset($campus) && $campus == $ubicacion->id) ? "selected": "";

                                    @endphp
                                    <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                                @endforeach
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <div style="position:relative">
                            <select id="departamento_id" data-departamento-id="{{(isset($departamento)) ? $departamento:""}}" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                                {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <div style="position: relative;">
                            <select id="escuela_id" data-escuela-id="{{(isset($escuela)) ? $escuela:""}}" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" data-periodo-id="" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="">
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        {!! Form::date('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="">
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        {!! Form::date('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <div style="position:relative">
                            <select id="programa_id" data-programa-id="{{(isset($programa)) ? $programa:""}}" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" data-plan-id="" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cgt_id', 'CGT *', array('class' => '')); !!}
                        <select id="cgt_id" data-cgt-id="" class="browser-default validate select2" required name="cgt_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>


                <div class="row" id="Tabla">
                    <div class="col s12">
                        <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
                        </div>
                    </div>
                </div>
         

            </div>
            @endif

            

          </div>
            <div class="card-action" style="display: none" id="boton-guardar">
                {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Cargando datos...";this.form.submit();','class' =>
                'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}
            </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>


  {{-- Script de funciones auxiliares  --}}
  {{--
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}
  --}}

@endsection

@section('footer_scripts')


{{--  @include('secundaria.scripts.preferencias')  --}}
@include('preescolar.scripts.departamentos')
@include('preescolar.scripts.escuelas')
@include('preescolar.scripts.periodos')
@include('preescolar.scripts.programas')
@include('preescolar.scripts.planes')
@include('preescolar.scripts.getCGT_con_grupos_N')


@include('preescolar.asignar_cgt.crearTablaJs')

@endsection
