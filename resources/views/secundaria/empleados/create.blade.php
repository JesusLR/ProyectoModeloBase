@extends('layouts.dashboard')

@section('template_title')
    Secundaria empleado
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('secundaria_empleado')}}" class="breadcrumb">Lista de empleados</a>
    <a href="{{url('secundaria_empleado/create')}}" class="breadcrumb">Agregar empleado</a>
@endsection

@section('content')


<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'secundaria.secundaria_empleado.store', 'method' => 'POST']) !!}
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
                      {!! Form::text('empNombre', NULL, array('id' => 'empNombre', 'class' => 'validate','required','maxlength'=>'40')) !!}
                      {!! Form::label('empNombre', 'Nombre(s) *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empApellido1', NULL, array('id' => 'empApellido1', 'class' => 'validate','required','maxlength'=>'30')) !!}
                      {!! Form::label('empApellido1', 'Primer apellido *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empApellido2', NULL, array('id' => 'empApellido2', 'class' => 'validate','maxlength'=>'30')) !!}
                      {!! Form::label('empApellido2', 'Segundo apellido', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @php
                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                if($ubicacion->id == $ubicacion_id){
                                    echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                }else{
                                    echo '<option value="'.$ubicacion->id.'">'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                }
                                @endphp
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
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
                      {!! Form::text('empNSS', NULL, array('id' => 'empNSS', 'class' => 'validate','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'11')) !!}
                      {!! Form::label('empNSS', 'Clave imss', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empCURP', NULL, array('id' => 'empCURP', 'class' => 'validate','required')) !!}
                      {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                      {!! Form::label('empCURP', 'Curp * (min 18 caracteres)', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empRFC', NULL, array('id' => 'empRFC', 'class' => 'validate','required','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'13')) !!}
                      {!! Form::label('empRFC', 'Rfc * (min 13 caracteres)', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empHoras', NULL, array('id' => 'empHoras', 'class' => 'validate','required','min'=>'0','max'=>'99999999999','onKeyPress="if(this.value.length==11) return false;"')) !!}
                      {!! Form::label('empHoras', 'Horas *', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
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

                  <div class="col s12 m6 l4">
                    {!! Form::label('empFechaIngreso', 'Fecha de ingreso *', array('class' => '')); !!}
                    {!! Form::date('empFechaIngreso', NULL, array('id' => 'empFechaIngreso', 'class' => 'validate','maxlength'=>'191', 'required')) !!}
                  </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                    {!! Form::label('puesto_id', 'Puesto del empleado *', array('class' => '')); !!}
                    <select id="puesto_id" class="browser-default validate select2" required name="puesto_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        @foreach ($puestos as $puesto)
                            <option value="{{$puesto->id}}">{{$puesto->puesNombre}}</option>
                        @endforeach
                    </select>
                </div>
              </div>
          </div>

          {{-- PERSONAL BAR--}}
          <div id="personal">

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empDireccionCalle', NULL, array('id' => 'empDireccionCalle', 'class' => 'validate','required','maxlength'=>'25')) !!}
                      {!! Form::label('empDireccionCalle', 'Calle *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('empDireccionNumero', NULL, array('id' => 'empDireccionNumero', 'class' => 'validate','required','maxlength'=>'6')) !!}
                        {!! Form::label('empDireccionNumero', 'Número *', array('class' => '')); !!}
                        </div>
                    </div>
                  {{--  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perDirNumInt', NULL, array('id' => 'perDirNumInt', 'class' => 'validate','maxlength'=>'6')) !!}
                      {!! Form::label('perDirNumInt', 'Número interior', array('class' => '')); !!}
                      </div>
                  </div>  --}}
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      {!! Form::label('paisId', 'País *', array('class' => '')); !!}
                      <select id="paisId" class="browser-default validate select2" required name="paisId" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                          @foreach($paises as $pais)
                              <option value="{{$pais->id}}">{{$pais->paisNombre}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('estado_id', 'Estado *', array('class' => '')); !!}
                      <select id="estado_id" class="browser-default validate select2" required name="estado_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('municipio_id', 'Municipio *', array('class' => '')); !!}
                      <select id="municipio_id" class="browser-default validate select2" required name="municipio_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empDireccionColonia', NULL, array('id' => 'empDireccionColonia', 'class' => 'validate','required','maxlength'=>'60')) !!}
                      {!! Form::label('empDireccionColonia', 'Colonia *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empDireccionCP', NULL, array('id' => 'empDireccionCP', 'class' => 'validate','required','min'=>'0','max'=>'99999','onKeyPress="if(this.value.length==5) return false;"')) !!}
                      {!! Form::label('empDireccionCP', 'Código Postal *', array('class' => '')); !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('empSexo', 'Sexo *', array('class' => '')); !!}
                        <select id="empSexo" class="browser-default validate select2" required name="empSexo" style="width: 100%;">
                            <option value="M">Hombre</option>
                            <option value="F">Mujer</option>
                        </select>
                    </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('empFechaNacimiento', 'Fecha de nacimiento *', array('class' => '')); !!}
                      {!! Form::date('empFechaNacimiento', NULL, array('id' => 'empFechaNacimiento', 'class' => ' validate','required')) !!}
                  </div>
              </div>


              <div class="row">
                  {{--  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('perTelefono1', NULL, array('id' => 'perTelefono1', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                      {!! Form::label('perTelefono1', 'Teléfono fijo', array('class' => '')); !!}
                      </div>
                  </div>  --}}
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empTelefono', NULL, array('id' => 'empTelefono', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                      {!! Form::label('empTelefono', 'Teléfono móvil', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::email('empCorreo1', NULL, array('id' => 'empCorreo1', 'class' => 'validate','maxlength'=>'60')) !!}
                      {!! Form::label('empCorreo1', 'Correo', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
          </div>

        </div>
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">save</i> Guardar', ['id'=>'btn-guardar-empleado-sec','class' => 'btn-large waves-effect  darken-3']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>


  
  {{-- Funciones para Modelo Persona --}}
  {!! HTML::script(asset('js/personas/personas.js'), array('type' => 'text/javascript'))!!}

@endsection

@section('footer_scripts')

 {{-- Script de funciones auxiliares  --}}
 @include('secundaria.scripts.funcionesAuxiliares')

    <script>

        var curp = $("#empCURP").val()
        var esCurpValida = curpValida(curp);
        $("#esCurpValida").val(esCurpValida);

        $("#empCURP").on('change', function(e) {
            var curp = e.target.value
            var esCurpValida = curpValida(curp);
            $("#esCurpValida").val(esCurpValida);
        });

        $(document).ready(function() {

          avoidSpecialCharacters('empNombre');
          avoidSpecialCharacters('empApellido1');
          avoidSpecialCharacters('empApellido2');

          var requeridosIdentidad = {
              empNombre: 'Nombre',
              empApellido1: 'Primer Apellido',
              empCURP: 'CURP'
          };

          $('#btn-guardar-empleado-sec').on('click', function () {
              var camposFaltantes = validate_formFields(requeridosIdentidad);
              if(jQuery.isEmptyObject(camposFaltantes)) {
                  verificarPersona();
              }else{
                  showRequiredFields(camposFaltantes);
              }
          });



        });



        function verificarPersona() {
            $.ajax({
                type:'GET',
                url: base_url + '/secundaria_empleado/verificar_persona',
                data: $('form').serialize(),
                //dataType: 'json',
                success: function(data) {
                    if(data.empleado){
                        var empleado = data.empleado;
                        var persona = empleado;
                        swal({
                            title: 'Ya existe el Empleado',
                            text: 'Se encontró un empleado con los siguientes datos: \n' +
                                  '\n Clave: '+empleado.id+' \n'+
                                  'Nombre: '+empleado.empNombre+' '+empleado.empApellido1+' '+empleado.empApellido2+' \n'+
                                  'CURP: '+empleado.empCURP+' \n'+
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
                                  'Nombre: '+persona.empNombre+' '+persona.empApellido1+' '+persona.empApellido2+' \n'+
                                  'CURP: '+persona.empCURP+' \n'+
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
                url: base_url+'/secundaria_empleado/reactivar_empleado/'+empleado_id,
                data:{empleado_id: empleado_id, '_token':'{{csrf_token()}}'},
                dataType:'json',
                success: function(empleado) {
                    window.location = base_url+'/secundaria_empleado/'+empleado.id+'/edit';
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    console.log(errorMessage);
                }
            });
        }//rehabilitarAlumno.

        function alumno_crearEmpleado(alumno_id) {
            $.ajax({
                type:'POST',
                url: base_url+'/secundaria_empleado/registrar_alumno/'+alumno_id,
                data: $('form').serialize(),
                dataType:'json',
                success: function (empleado) {
                    window.location = base_url+'/secundaria_empleado/'+empleado.id+'/edit';
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    console.log(errorMessage);
                }
            });
        }//empleado_crearAlumno.

    </script>



    @include('scripts.preferencias')
    @include('scripts.departamentos')
    @include('scripts.escuelas')
    @include('scripts.estados')
    @include('scripts.municipios')
@endsection
