@extends('layouts.dashboard')

@section('template_title')
    Alumnos Restringidos
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('alumno_restringido')}}" class="breadcrumb">Lista de Alumnos restringidos</a>
    <a href="{{url('alumno_restringido/'.$restringido->id.'/edit')}}" class="breadcrumb">Editar Alumno</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['alumno_restringido.update', $restringido->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR Alumno restringido #{{$restringido->id}}</span>

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
                    $aluClave = $restringido->alumno->aluClave;
                    $persona = $restringido->alumno->persona;
                    $nombreCompleto = $persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2;
                @endphp
                
                <div class="row">
                    <div class="col s12 m6 l4">
                        <br>
                        <div class="input-field col s12 m6 14">
                          {!! Form::number('aluClave', $aluClave, array('id' => 'aluClave', 'class' => 'validate','min'=>'0','required', 'readonly')) !!}
                          {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="input-field col s12 m6 l4">
                        {!! Form::text('nombreCompleto', $nombreCompleto, array('id' => 'nombreCompleto', 'class' => 'validate', 'readonly')) !!}
                        {!! Form::label('nombreCompleto', 'Nombre del Alumno', array('class' => '')); !!}
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('lnNivel', 'Nivel de bloqueo', array('class'=>'')) !!}
                        <select id="lnNivel" name="lnNivel" class="browser-default validate select2" style="width: 100%;" required>
                            @foreach($niveles as $nivel)
                                <option value="{{$nivel->id}}">{{$nivel->nlnDescripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        {!! Form::text('lnRazon', $restringido->lnRazon, array('id' => 'lnRazon', 'class' => 'validate', 'maxlength'=>'255')) !!}
                        {!! Form::label('lnRazon', 'Razón de bloqueo', array('class' => '')); !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('lnFecha', 'Fecha de Registro', array('class'=>'')) !!}
                        <input type="date" name="lnFecha" id="lnFecha" value="{{$restringido->lnFecha}}" required readonly>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        {!! Form::text('username', $user->username, array('id' => 'username', 'class' => 'validate', 'readonly')) !!}
                        {!! Form::label('username', 'Clave de usuario', array('class' => '')); !!}
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

  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}


@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {

        console.log('Hola Mundo!');

        var lnNivel = {!! json_encode(old('lnNivel')) !!} || {!! json_encode($restringido->lnNivel) !!};
        lnNivel && $('#lnNivel').val(lnNivel).select2();


    });
</script>
@endsection