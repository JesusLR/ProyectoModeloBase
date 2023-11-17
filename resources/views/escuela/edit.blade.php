@extends('layouts.dashboard')

@section('template_title')
    Escuela
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('escuela')}}" class="breadcrumb">Lista de escuelas</a>
    <label class="breadcrumb">Editar escuela</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {{ Form::open(array('method'=>'PUT','route' => ['escuela.update', $escuela->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR ESCUELA #{{$escuela->id}}</span>

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
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$escuela->departamento->ubicacion_id}}" selected >{{$escuela->departamento->ubicacion->ubiClave}}-{{$escuela->departamento->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$escuela->departamento_id}}" selected >{{$escuela->departamento->depClave}}-{{$escuela->departamento->depNombre}}</option>
                        </select>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('empleado_id', 'Director *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" data-empleado-id="{{old('empleado_id') ?: $escuela->empleado_id}}" required name="empleado_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}">{{$empleado->id}} - {{$empleado->persona->nombreCompleto()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('academico_empleado_id', 'Coordinador Académico *', array('class' => '')); !!}
                        <select id="academico_empleado_id" class="browser-default validate select2" data-academico_empleado-id="{{old('academico_empleado_id') ?: $escuela->academico_empleado_id}}" required name="academico_empleado_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}">{{$empleado->id}} - {{$empleado->persona->nombreCompleto()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('administrativo_empleado_id', 'Coordinador Administrativo *', array('class' => '')); !!}
                        <select id="administrativo_empleado_id" class="browser-default validate select2" data-administrativo_empleado-id="{{old('administrativo_empleado_id') ?: $escuela->administrativo_empleado_id}}" required name="administrativo_empleado_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}">{{$empleado->id}} - {{$empleado->persona->nombreCompleto()}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escClave', old('escClave') ?: $escuela->escClave, array('id' => 'escClave', 'class' => 'validate','required','readonly','maxlength'=>'3')) !!}
                            {!! Form::label('escClave', 'Clave escuela *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escNombre', old('escNombre') ?: $escuela->escNombre, array('id' => 'escNombre', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('escNombre', 'Nombre escuela *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escNombreCorto', old('escNombreCorto') ?: $escuela->escNombreCorto, array('id' => 'escNombreCorto', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('escNombreCorto', 'Nombre corto * (15 carateres)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('escPorcExaPar', old('escPorcExaPar') ?: $escuela->escPorcExaPar, array('id' => 'escPorcExaPar', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                            {!! Form::label('escPorcExaPar', '% Exa Parciales *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('escPorcExaOrd', old('escPorcExaOrd') ?: $escuela->escPorcExaOrd, array('id' => 'escPorcExaOrd', 'class' => 'validate','min'=>'0','max'=>'999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                            {!! Form::label('escPorcExaOrd', '% Exa Ordinario *', array('class' => '')); !!}
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

  <script type="text/javascript" src={{asset('js/funcionesAuxiliares.js')}}></script>

@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            apply_data_to_select('empleado_id', 'empleado-id');
            apply_data_to_select('academico_empleado_id', 'academico_empleado-id');
            apply_data_to_select('administrativo_empleado_id', 'administrativo_empleado-id');
        });
    </script>
@endsection