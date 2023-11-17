@extends('layouts.dashboard')

@section('template_title')
    Alumnos Restringidos
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('alumno_restringido')}}" class="breadcrumb">Lista de Alumnos restringidos</a>
    <a href="{{url('alumno_restringido/create')}}" class="breadcrumb">Agregar Alumno Restringido</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'alumno_restringido.store', 'method' => 'POST']) !!}
      <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR ALUMNO RESTRINGIDO</span>

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
                    $username = Auth::user()->username;
                @endphp

                <div class="row">
                    <div class="col s12 m6 l4">
                        <br>
                        <div class="input-field col s12 m6 14">
                          {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0','required')) !!}
                          {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                        </div>
                        <div class="input-field col s12 m6 14">
                          <a name="buscarAlumno" id="buscarAlumno" class="waves-effect btn-large tooltipped" data-position="right" data-tooltip="Buscar alumno por su clave">
                            <i class=material-icons>search</i>
                          </a>
                        </div>
                      </div>
                </div>
                <br>
                <div class="row">
                    <div class="input-field col s12 m6 l4">
                        {!! Form::text('nombreCompleto', NULL, array('id' => 'nombreCompleto', 'class' => 'validate')) !!}
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
                        {!! Form::text('lnRazon', NULL, array('id' => 'lnRazon', 'class' => 'validate', 'maxlength'=>'255')) !!}
                        {!! Form::label('lnRazon', 'Razón de bloqueo', array('class' => '')); !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('lnFecha', 'Fecha de Registro', array('class'=>'')) !!}
                        <input type="date" name="lnFecha" id="lnFecha" value="{{$fechaActual->format('Y-m-d')}}" required readonly>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        {!! Form::text('username', $username, array('id' => 'username', 'class' => 'validate', 'readonly')) !!}
                        {!! Form::label('username', 'Clave de usuario', array('class' => '')); !!}
                    </div>
                </div>
                
            </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', [ 'id'=>'btn-guardar','class' => 'btn-large waves-effect  darken-3']) !!}
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
        var old_lnNivel = {!! json_encode(old('lnNivel')) !!};
        old_lnNivel && $('#lnNivel').val(old_lnNivel).select2();

        $('#buscarAlumno').on('click', function() {
            var aluClave = $('#aluClave').val();
            aluClave ? getAlumnoByClave(aluClave) : swal_aluClaveRequerida();
        });

        $('#btn-guardar').on('click', function () {
            var requeridosIdentidad = {
                aluClave: 'Clave de pago',
                lnNivel: 'Nivel de bloqueo'
            };

            var camposFaltantes = validate_formFields(requeridosIdentidad);
            if(jQuery.isEmptyObject(camposFaltantes)) {
                $('form').submit();
            }else{    
                showRequiredFields(camposFaltantes);
            }
        });


    });

    function getAlumnoByClave(aluClave) {
        $.ajax({
            type: 'GET',
            url: base_url + '/api/alumno_restringido/buscar/' + aluClave,
            dataType: 'json',
            data: {aluClave: aluClave},
            success: function(alumno) {
                if(alumno) {
                    console.log(alumno);
                    var persona = alumno.persona;
                    var nombreCompleto = persona.perNombre+' '+persona.perApellido1+' '+persona.perApellido2;
                    $('#nombreCompleto').val(nombreCompleto);
                    Materialize.updateTextFields();
                } else {
                    swal_noExisteAlumno(aluClave);
                }
            },
            error: function(Xhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });
    } //getAlumnoByClave.

    function swal_aluClaveRequerida() {
        swal({
            type: 'warning',
            title: 'Campo requerido',
            text: 'Requerimos que ingrese una Clave de pago, para realizar la búsqueda.'
        });
    }//swal_aluClaveRequerida.

    function swal_noExisteAlumno(aluClave) {
        swal({
            type: 'warning',
            title: 'Sin datos',
            text: 'No se encuentra ningún alumno con la clave ' + aluClave +'. \n'
                + 'Favor de verificar e intentar de nuevo'
        });
    }//swal_noExisteAlumno.

    


</script>

@endsection