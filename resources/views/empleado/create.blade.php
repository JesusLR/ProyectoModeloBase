@extends('layouts.dashboard')

@section('template_title')
    Empleado
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('empleado')}}" class="breadcrumb">Lista de empleados</a>
    <a href="{{url('empleado/create')}}" class="breadcrumb">Agregar empleado</a>
@endsection

@section('content')

@php
  $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
@endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'empleado.store', 'method' => 'POST']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">AGREGAR EMPLEADO</span>

          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#general">General</a></li>
                <li class="tab"><a href="#personal">Personal</a></li>
              </ul>
            </div>
          </nav>

          {{-- GENERAL BAR--}}
          <div id="general">

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','required','maxlength'=>'40')) !!}
                      {!! Form::label('perNombre', 'Nombre(s) *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','required','maxlength'=>'30')) !!}
                      {!! Form::label('perApellido1', 'Primer apellido *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30')) !!}
                      {!! Form::label('perApellido2', 'Segundo apellido', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                              <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empCredencial', NULL, array('id' => 'empCredencial', 'class' => 'validate','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'8')) !!}
                      {!! Form::label('empCredencial', 'Clave credencial', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empNomina', NULL, array('id' => 'empNomina', 'class' => 'validate','min'=>'0','max'=>'99999999999','onKeyPress="if(this.value.length==11) return false;"')) !!}
                      {!! Form::label('empNomina', 'Clave nomina', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empImss', NULL, array('id' => 'empImss', 'class' => 'validate','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'11')) !!}
                      {!! Form::label('empImss', 'Clave imss', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perCurp', NULL, array('id' => 'perCurp', 'class' => 'validate','required')) !!}
                      {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                      {!! Form::label('perCurp', 'Curp * (min 18 caracteres)', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empRfc', NULL, array('id' => 'empRfc', 'class' => 'validate','required','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'13')) !!}
                      {!! Form::label('empRfc', 'Rfc * (min 13 caracteres)', array('class' => '')); !!}
                      </div>
                  </div>
                  {{--<div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empHorasCon', NULL, array('id' => 'empHorasCon', 'class' => 'validate','required','min'=>'0','max'=>'99999999999','onKeyPress="if(this.value.length==11) return false;"')) !!}
                      {!! Form::label('empHorasCon', 'Horas *', array('class' => '')); !!}
                      </div>
                  </div> --}}
              </div>
              <div class="row">
                  <div class="col s12 m6 l4">
                    <label for="puesto_id">Puesto</label>
                    <select class="browser-default validate select2" data-puesto-id="{{old('puesto_id') ?: 12}}" id="puesto_id" name="puesto_id" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      @foreach($puestos as $puesto)
                        <option value="{{$puesto->id}}">{{$puesto->puesNombre}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::password('password', NULL, array('id' => 'password', 'class' => 'validate','maxlength'=>'191')) !!}
                      {!! Form::label('password', 'Contraseña docente', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::password('password_confirmation', NULL, array('id' => 'password_confirmation', 'class' => 'validate','maxlength'=>'191')) !!}
                      {!! Form::label('password_confirmation', 'Confirmar contraseña', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
          </div>
          <div class="row">
            <div class="col s12 m6 l4">
              <div class="">
                <label for="created_at">Fecha de registro</label>
                <input type="date" name="created_at" id="created_at" value="{{\Carbon\Carbon::now('America/Merida')->format('Y-m-d')}}" readonly>
              </div>
            </div>
          </div>

          {{-- PERSONAL BAR--}}
          <div id="personal">

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perDirCalle', NULL, array('id' => 'perDirCalle', 'class' => 'validate','required','maxlength'=>'25')) !!}
                      {!! Form::label('perDirCalle', 'Calle *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perDirNumExt', NULL, array('id' => 'perDirNumExt', 'class' => 'validate','required','maxlength'=>'6')) !!}
                        {!! Form::label('perDirNumExt', 'Número exterior *', array('class' => '')); !!}
                        </div>
                    </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perDirNumInt', NULL, array('id' => 'perDirNumInt', 'class' => 'validate','maxlength'=>'6')) !!}
                      {!! Form::label('perDirNumInt', 'Número interior', array('class' => '')); !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      {!! Form::label('pais_id', 'País *', array('class' => '')); !!}
                      <select id="pais_id" class="browser-default validate select2" data-pais-id="{{old('pais_id')}}" required name="pais_id" style="width: 100%;">
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                          @foreach($paises as $pais)
                              <option value="{{$pais->id}}">{{$pais->paisNombre}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('estado_id', 'Estado *', array('class' => '')); !!}
                      <select id="estado_id" class="browser-default validate select2" data-estado-id="{{old('estado_id')}}" required name="estado_id" style="width: 100%;">
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('municipio_id', 'Municipio *', array('class' => '')); !!}
                      <select id="municipio_id" class="browser-default validate select2" data-municipio-id="{{old('municipio_id')}}" required name="municipio_id" style="width: 100%;">
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perDirColonia', NULL, array('id' => 'perDirColonia', 'class' => 'validate','required','maxlength'=>'60')) !!}
                      {!! Form::label('perDirColonia', 'Colonia *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('perDirCP', NULL, array('id' => 'perDirCP', 'class' => 'validate','required','min'=>'0','max'=>'99999','onKeyPress="if(this.value.length==5) return false;"')) !!}
                      {!! Form::label('perDirCP', 'Código Postal *', array('class' => '')); !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::select('perSexo', array('M' => 'Hombre', 'F' => 'Mujer')); !!}
                      {!! Form::label('perSexo', 'Sexo *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('perFechaNac', 'Fecha de nacimiento *', array('class' => '')); !!}
                      {!! Form::date('perFechaNac', NULL, array('id' => 'perFechaNac', 'class' => ' validate','required')) !!}
                  </div>
              </div>


              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('perTelefono1', NULL, array('id' => 'perTelefono1', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                      {!! Form::label('perTelefono1', 'Teléfono fijo', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('perTelefono2', NULL, array('id' => 'perTelefono2', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                      {!! Form::label('perTelefono2', 'Teléfono móvil', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::email('perCorreo1', NULL, array('id' => 'perCorreo1', 'class' => 'validate','maxlength'=>'60')) !!}
                      {!! Form::label('perCorreo1', 'Correo', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
          </div>

        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">save</i> Guardar', ['id'=>'btn-guardar','class' => 'btn-large waves-effect  darken-3']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>


  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}
  {{-- Funciones para Modelo Persona --}}
  {!! HTML::script(asset('js/personas/personas.js'), array('type' => 'text/javascript'))!!}

@endsection

@section('footer_scripts')

    <script>



        var curp = $("#perCurp").val()
        var esCurpValida = curpValida(curp);
        $("#esCurpValida").val(esCurpValida);

        $("#perCurp").on('change', function(e) {
            var curp = e.target.value
            var esCurpValida = curpValida(curp);
            $("#esCurpValida").val(esCurpValida);
        });

        $(document).ready(function() {
          let ubicacion = $('#ubicacion_id');
          let departamento = $('#departamento_id');
          let pais = $('#pais_id');
          let estado = $('#estado_id');
          let requeridosIdentidad = {
              perNombre: 'Nombre',
              perApellido1: 'Primer Apellido',
              perCurp: 'CURP'
          };

          $('#btn-guardar').on('click', function () {
              let camposFaltantes = validate_formFields(requeridosIdentidad);
              if(jQuery.isEmptyObject(camposFaltantes)) {
                  verificarPersona();
              }else{    
                  showRequiredFields(camposFaltantes);
              }
          });

          avoidSpecialCharacters('perNombre');
          avoidSpecialCharacters('perApellido1');
          avoidSpecialCharacters('perApellido2');

          apply_data_to_select('ubicacion_id', 'ubicacion-id');
          apply_data_to_select('pais_id', 'pais-id');
          apply_data_to_select('puesto_id', 'puesto-id');

          ubicacion.val() ? getDepartamentosListaCompleta(ubicacion.val()) : resetSelect('departamento_id');
          ubicacion.on('change', function() {
            this.value ? getDepartamentosListaCompleta(this.value) : resetSelect('departamento_id');
          });

          departamento.on('change', function() {
            this.value ? getEscuelasListaCompleta(this.value) : resetSelect('escuela_id');
          });

          pais.val() ? getEstados(pais.val()) : resetSelect('estado_id');
          pais.on('change', function() {
            this.value ? getEstados(this.value) : resetSelect('estado_id');
          });

          estado.on('change', function() {
            this.value ? getMunicipios(this.value) : resetSelect('municipio_id');
          });
          

        });



        function verificarPersona() {
            $.ajax({
                type:'GET',
                url: base_url + '/api/empleado/verificar_persona',
                data: $('form').serialize(),
                dataType: 'json',
                success: function(data) {
                    if(data.empleado){
                        var empleado = data.empleado;
                        var persona = empleado.persona;
                        swal({
                            title: 'Ya existe el Empleado',
                            text: 'Se encontró un empleado con los siguientes datos: \n' +
                                  '\n Clave: '+empleado.id+' \n'+
                                  'Nombre: '+persona.perNombre+' '+persona.perApellido1+' '+persona.perApellido2+' \n'+
                                  'CURP: '+persona.perCurp+' \n'+
                                  '\n No se puede duplicar el empleado. ¿Desea utilizar este registro?',
                            showCancelButton: true,
                            cancelButtonText: 'No, cancelar',
                            confirmButtonText: 'Sí'
                        },function() {
                            reactivarEmpleado(empleado.id);
                        });
                    }else if(data.alumno) {
                        var alumno = data.alumno;
                        var persona = alumno.persona;
                        swal({
                            title: 'Ya existe la persona',
                            text: 'Se encontró un alumno con los siguientes datos: \n' +
                                  '\n Clave: '+alumno.aluClave+' \n'+
                                  'Nombre: '+persona.perNombre+' '+persona.perApellido1+' '+persona.perApellido2+' \n'+
                                  'CURP: '+persona.perCurp+' \n'+
                                  '\n No se pueden duplicar estos datos. ¿Desea registrar este alumno como empleado?',
                            showCancelButton: true,
                            cancelButtonText: 'No',
                            confirmButtonText: 'Sí'
                        }, function() {
                            alumno_crearEmpleado(alumno.id);
                        });
                    }else{
                        $('form').submit();
                    }
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    console.log(errorMessage);
                },
            });
        }//verificarPersona.

        function reactivarEmpleado(empleado_id) {
            $.ajax({
                type:'POST',
                url: base_url+'/api/empleado/reactivar_empleado/'+empleado_id,
                data:{empleado_id: empleado_id, '_token':'{{csrf_token()}}'},
                dataType:'json',
                success: function(empleado) {
                    window.location = base_url+'/empleado/'+empleado.id+'/edit';
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    console.log(errorMessage);
                }
            });
        }//rehabilitarAlumno.

        function alumno_crearEmpleado(alumno_id) {
            $.ajax({
                type:'POST',
                url: base_url+'/api/empleado/registrar_alumno/'+alumno_id,
                data: $('form').serialize(),
                dataType:'json',
                success: function (empleado) {
                    window.location = base_url+'/empleado/'+empleado.id+'/edit';
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    console.log(errorMessage);
                }
            });
        }//empleado_crearAlumno.
    
    </script>
@endsection