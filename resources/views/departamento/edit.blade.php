@extends('layouts.dashboard')

@section('template_title')
    Departamento
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('departamento')}}" class="breadcrumb">Lista de departamentos</a>
    <label class="breadcrumb">Editar departamento</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['departamento.update', $departamento->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR DEPARTAMENTO #{{$departamento->id}}</span>

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
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$departamento->ubicacion_id}}" selected>{{$departamento->ubicacion->ubiClave}}-{{$departamento->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depClave', $departamento->depClave, array('id' => 'depClave', 'class' => 'validate','required','readonly','maxlength'=>'3')) !!}
                            {!! Form::label('depClave', 'Clave departamento *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombre', $departamento->depNombre, array('id' => 'depNombre', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('depNombre', 'Nombre departamento *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombreCorto', $departamento->depNombreCorto, array('id' => 'depNombreCorto', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('depNombreCorto', 'Nombre corto * (15 carateres)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('depNivel', $departamento->depNivel, array('id' => 'depNivel', 'class' => 'validate','required','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                            {!! Form::label('depNivel', 'Identificador * (Prefijo nivel)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depClaveOficial', $departamento->depClaveOficial, array('id' => 'depClaveOficial', 'class' => 'validate','maxlength'=>'20')) !!}
                            {!! Form::label('depClaveOficial', 'Clave oficial (SEP)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombreOficial', $departamento->depNombreOficial, array('id' => 'depNombreOficial', 'class' => 'validate','maxlength'=>'50')) !!}
                            {!! Form::label('depNombreOficial', 'Nombre oficial (SEP)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('perAnte', 'Periodo anterior', array('class' => '')); !!}
                        <select id="perAnte" class="browser-default validate select2" name="perAnte" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($periodos as $periodo)
                                <option value="{{$periodo->id}}" @if($departamento->perAnte == $periodo->id) {{ 'selected' }} @endif>{{$periodo->departamento->depClave}}-{{$periodo->perNumero}}-{{$periodo->perAnio}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('perActual', 'Periodo actual', array('class' => '')); !!}
                        <select id="perActual" class="browser-default validate select2" name="perActual" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($periodos as $periodo)
                                <option value="{{$periodo->id}}" @if($departamento->perActual == $periodo->id) {{ 'selected' }} @endif>{{$periodo->departamento->depClave}}-{{$periodo->perNumero}}-{{$periodo->perAnio}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('perSig', 'Periodo siguiente', array('class' => '')); !!}
                        <select id="perSig" class="browser-default validate select2" name="perSig" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($periodos as $periodo)
                                <option value="{{$periodo->id}}" @if($departamento->perSig == $periodo->id) {{ 'selected' }} @endif>{{$periodo->departamento->depClave}}-{{$periodo->perNumero}}-{{$periodo->perAnio}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                                {!! Form::number('depCalMinAprob', $departamento->depCalMinAprob, array('id' => 'depCalMinAprob', 'class' => 'validate','min'=>'0','max'=>'999','onKeyPress="if(this.value.length==3) return false;"')) !!}
                                {!! Form::label('depCalMinAprob', 'Calif. Mínima', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('depCupoGpo', $departamento->depCupoGpo, array('id' => 'depCupoGpo', 'class' => 'validate','min'=>'0','max'=>'999','onKeyPress="if(this.value.length==3) return false;"')) !!}
                            {!! Form::label('depCupoGpo', 'Cupo de grupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depIncorporadoA', $departamento->depIncorporadoA, array('id' => 'depIncorporadoA', 'class' => 'validate','maxlength'=>'70')) !!}
                            {!! Form::label('depIncorporadoA', 'Incorporado a:', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depTituloDoc', $departamento->depTituloDoc, array('id' => 'depTituloDoc', 'class' => 'validate','maxlength'=>'60')) !!}
                            {!! Form::label('depTituloDoc', 'Titulo firma', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombreDoc', $departamento->depNombreDoc, array('id' => 'depNombreDoc', 'class' => 'validate','maxlength'=>'60')) !!}
                            {!! Form::label('depNombreDoc', 'Nombre firma', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depPuestoDoc', $departamento->depPuestoDoc, array('id' => 'depPuestoDoc', 'class' => 'validate','maxlength'=>'60')) !!}
                            {!! Form::label('depPuestoDoc', 'Puesto de quien firma', array('class' => '')); !!}
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

@section('footer_scripts')


@endsection