@extends('layouts.dashboard')

@section('template_title')
    Idiomas empleado
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_empleado')}}" class="breadcrumb">Lista de empleados</a>
    <a href="{{url('idiomas_empleado/create')}}" class="breadcrumb">Agregar empleado</a>
@endsection

@section('content')


<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'idiomas.idiomas_empleado.store', 'method' => 'POST']) !!}
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
                        <select id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
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
                      {!! Form::text('empCurp', NULL, array('id' => 'empCurp', 'class' => 'validate','required')) !!}
                      {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                      {!! Form::label('empCurp', 'Curp * (min 18 caracteres)', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empRfc', NULL, array('id' => 'empRfc', 'class' => 'validate','required','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'13')) !!}
                      {!! Form::label('empRfc', 'Rfc * (min 13 caracteres)', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empHorasCon', NULL, array('id' => 'empHorasCon', 'class' => 'validate','required','min'=>'0','max'=>'99999999999','onKeyPress="if(this.value.length==11) return false;"')) !!}
                      {!! Form::label('empHorasCon', 'Horas *', array('class' => '')); !!}
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
                      {!! Form::text('empDirCalle', NULL, array('id' => 'empDirCalle', 'class' => 'validate','required','maxlength'=>'25')) !!}
                      {!! Form::label('empDirCalle', 'Calle *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('empDirNumExt', NULL, array('id' => 'empDirNumExt', 'class' => 'validate','required','maxlength'=>'6')) !!}
                        {!! Form::label('empDirNumExt', 'Número *', array('class' => '')); !!}
                        </div>
                    </div>
                  {{--  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empDirNumInt', NULL, array('id' => 'empDirNumInt', 'class' => 'validate','maxlength'=>'6')) !!}
                      {!! Form::label('empDirNumInt', 'Número interior', array('class' => '')); !!}
                      </div>
                  </div>  --}}
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      {!! Form::label('paisId', 'País *', array('class' => '')); !!}
                      <select id="paisId" data-pais-id="{{old('paisId')}}" class="browser-default validate select2" required name="paisId" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                          @foreach($paises as $pais)
                              <option value="{{$pais->id}}">{{$pais->paisNombre}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('estado_id', 'Estado *', array('class' => '')); !!}
                      <select id="estado_id" data-estado-id="{{old('estado_id')}}" class="browser-default validate select2" required name="estado_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('municipio_id', 'Municipio *', array('class' => '')); !!}
                      <select id="municipio_id" data-municipio-id="{{old('municipio_id')}}" class="browser-default validate select2" required name="municipio_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empDirColonia', NULL, array('id' => 'empDirColonia', 'class' => 'validate','required','maxlength'=>'60')) !!}
                      {!! Form::label('empDirColonia', 'Colonia *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empDirCP', NULL, array('id' => 'empDirCP', 'class' => 'validate','required','min'=>'0','max'=>'99999','onKeyPress="if(this.value.length==5) return false;"')) !!}
                      {!! Form::label('empDirCP', 'Código Postal *', array('class' => '')); !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::select('empSexo', array('M' => 'Hombre', 'F' => 'Mujer')); !!}
                      {!! Form::label('empSexo', 'Sexo *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('empFechaNac', 'Fecha de nacimiento *', array('class' => '')); !!}
                      {!! Form::date('empFechaNac', NULL, array('id' => 'empFechaNac', 'class' => ' validate','required')) !!}
                  </div>
              </div>


              <div class="row">
                  {{--  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empTelefono1', NULL, array('id' => 'empTelefono1', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                      {!! Form::label('empTelefono1', 'Teléfono fijo', array('class' => '')); !!}
                      </div>
                  </div>  --}}
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empTelefono2', NULL, array('id' => 'empTelefono2', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                      {!! Form::label('empTelefono2', 'Teléfono móvil', array('class' => '')); !!}
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
 @include('idiomas.scripts.funcionesAuxiliares')

    <script>

        var curp = $("#empCurp").val()
        var esCurpValida = curpValida(curp);
        $("#esCurpValida").val(esCurpValida);

        $("#empCurp").on('change', function(e) {
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
              empCurp: 'CURP'
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
                url: base_url + '/api_idiomas_empleado/verificar_persona',
                data: $('form').serialize(),
                //dataType: 'json',
                success: function(data) {
                    if(data.empleado){
                        var empleado = data.empleado;
                        var persona = empleado.persona;
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
                url: base_url+'/idiomas_empleado/reactivar_empleado/'+empleado_id,
                data:{empleado_id: empleado_id, '_token':'{{csrf_token()}}'},
                dataType:'json',
                success: function(empleado) {
                    window.location = base_url+'/idiomas_empleado/'+empleado.id+'/edit';
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    console.log(errorMessage);
                }
            });
        }//rehabilitarAlumno.

        function alumno_crearEmpleado(alumno_id) {
            $.ajax({
                type:'POST',
                url: base_url+'/idiomas_empleado/registrar_alumno/'+alumno_id,
                data: $('form').serialize(),
                dataType:'json',
                success: function (empleado) {
                    window.location = base_url+'/idiomas_empleado/'+empleado.id+'/edit';
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    console.log(errorMessage);
                }
            });
        }//empleado_crearAlumno.

    </script>



    @include('idiomas.scripts.preferencias')
    @include('idiomas.scripts.departamentos')
    @include('idiomas.scripts.escuelas')
    @include('idiomas.scripts.estados')
    @include('idiomas.scripts.municipios')
@endsection