@extends('layouts.dashboard')

@section('template_title')
    Gimnasio usuario
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('gimnasio_usuario')}}" class="breadcrumb">Lista de usuarios del gimnasio</a>
    <a href="{{url('gimnasio_usuario/create')}}" class="breadcrumb">Agregar usuario de gimnasio</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'gimnasio.gimnasio_usuario.store', 'method' => 'POST', 'id' => 'form_usuagim']) !!}
      <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR USUARIO DE GIMNASIO</span>

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
                    <!-- <div class="col s12 m6 l4">
                        <label>Es alumno, ex-alumno o padre o tutor ?</label>
                        <select name="es_alumno" id="es_alumno" class="browser-default validate select2" style="width:100%;">
                            <option value="">No</option>
                            <option value="SI">SI</option>
                        </select>
                        <small style="color:#3F6D9F;" id="small_es_alumno"><b>Verifique que existe alumno...</b></small>
                    </div> -->
                    <div class="col s12 m6 l8">
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="aluClave">Clave de pago</label>
                                <input type="number" name="aluClave" id="aluClave" class="validate" required>
                            </div>
                            <small style="color:#3F6D9F;" id="busqueda_cargando"><b>Espere...</b></small>
                            <input type="hidden" name="alumno_id" id="alumno_id" value="">
                        </div>
                        <div class="input-field col s12 m6 16">
                            <a name="btn_buscar" id="btn_buscar" class="waves-effect btn-large tooltipped" data-position="right" data-tooltip="Buscar alumno por su clave">
                                <i class=material-icons>search</i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <label for="gimTipo">Tipo de usuario</label>
                        <select name="gimTipo" id="gimTipo" class="browser-default validate select2" style="width:100%;" required>
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                            @foreach($tipos as $tipo)
                                <option value="{{$tipo->tugClave}}">{{$tipo->tugClave}} - {{$tipo->tugDescripcion}} - ${{$tipo->tugImporte}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l8">
                        <div class="input-field col s12 m4 l4">
                            <input type="text" name="gimId" id="gimId" class="validate" value="{{old('gimId')}}" required>
                            <label for="gimId">Identificador *</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input type="text" name="gimApellidoPaterno" id="gimApellidoPaterno" class="validate" value="{{old('gimApellidoPaterno')}}" required>
                            <label for="gimApellidoPaterno">Apellido Paterno *</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input type="text" name="gimApellidoMaterno" id="gimApellidoMaterno" class="validate" value="{{old('gimApellidoMaterno')}}">
                            <label for="gimApellidoMaterno">Apellido Materno</label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="text" name="gimNombre" id="gimNombre" class="validate" value="{{old('gimNombre')}}" required>
                            <label for="gimNombre">Nombre *</label>
                        </div>
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
        let aluClave = $('#aluClave');
        let es_alumno = $('#es_alumno');
        let small_es_alumno = $('#small_es_alumno');
        let busqueda_alumno = $('#busqueda_alumno');
        let gimTipoSelect =  $('#gimTipo');
        let gimTipo = {!! json_encode(old('gimTipo')) !!};

        $('#busqueda_cargando').hide();

        if(es_alumno.val()) {
            busqueda_alumno.show();
            small_es_alumno.show();
        } else {
            busqueda_alumno.hide();
            small_es_alumno.hide();
        }

        es_alumno.on('change', function() {
            if(this.value) {
                busqueda_alumno.show();
                small_es_alumno.show();
            } else {
                busqueda_alumno.hide();
                small_es_alumno.hide();
                emptyElements(['alumno_id', 'aluClave']);
            }
        });

        $('#btn_buscar').on('click', function() {
            if(aluClave.val()) {
                getAlumnoByClave(aluClave.val());
            } else {
                swal_aluClaveRequerida();
            }
        });

        gimTipo && gimTipoSelect.val(gimTipo).select2();


        $('#btn-guardar').on('click', function() {
            if(es_alumno.val() && !$('#alumno_id').val()) {
                swal({
                    type:'warning',
                    title: 'No se puede proceder',
                    text: 'Si selecciona que es alumno, ex-alumno o tutor, debe verificar la existencia del alumno. \n' +
                        'Por favor ingrese la clave del alumno, y presione el botón de búsqueda.'
                });
            } else {
                $('#form_usuagim').submit();
            }
        });
        



    });




    function getAlumnoByClave(aluClave) {
        $.ajax({
            type: 'GET',
            url: base_url + '/api/gimnasio_usuario/buscar_clave/' + aluClave,
            dataType: 'json',
            data: {aluClave: aluClave},
            beforeSend: function() {
                $('#busqueda_cargando').show();
                emptyElements(['alumno_id']);
            },
            success: function(alumno) {
                $('#busqueda_cargando').hide();
                if(!jQuery.isEmptyObject(alumno)) {
                    var persona = alumno.persona;
                    $('#gimNombre').val(persona.perNombre);
                    $('#gimApellidoPaterno').val(persona.perApellido1);
                    $('#gimApellidoMaterno').val(persona.perApellido2);
                    $('#alumno_id').val(alumno.id);
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