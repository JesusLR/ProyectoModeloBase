@extends('layouts.dashboard')

@section('template_title')
    Empleado
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    @if (session('dynamicRedirect'))
    <a href="{{url(session('dynamicRedirect'))}}" class="breadcrumb">Lista de empleados</a>
    @else
    <a href="{{url($dynamicRedirect)}}" class="breadcrumb">Lista de empleados</a>
    @endif
    <a href="{{url('empleado/'.$empleado->id.'/edit')}}" class="breadcrumb">Editar empleado</a>
@endsection

@section('content')

@php
  $escuela = $empleado->escuela;
  $departamento = $escuela->departamento;
  $ubicacion_id = $departamento->ubicacion->id;

  $municipio = $empleado->persona->municipio;
  $estado = $municipio->estado;
  $pais = $estado->pais;
@endphp

<div class="row">
  <div class="col s12 ">
    {{ Form::open(array('method'=>'PUT','route' => ['empleado.update', $empleado->id])) }}
    @if (session('dynamicRedirect'))
    <input type="hidden" name="dynamicRedirect" data-test="test" value="{{session('dynamicRedirect')}}">
    @else
    <input type="hidden" name="dynamicRedirect" value="{{$dynamicRedirect}}">
    @endif
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">EDITAR EMPLEADO #{{$empleado->id}}</span>

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
                      {!! Form::text('perNombre', $empleado->persona->perNombre, array('id' => 'perNombre', 'class' => 'validate','required','maxlength'=>'40')) !!}
                      {!! Form::label('perNombre', 'Nombre(s) *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perApellido1', $empleado->persona->perApellido1, array('id' => 'perApellido1', 'class' => 'validate','required','maxlength'=>'30')) !!}
                      {!! Form::label('perApellido1', 'Primer apellido *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perApellido2', $empleado->persona->perApellido2, array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30')) !!}
                      {!! Form::label('perApellido2', 'Segundo apellido', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" required name="ubicacion_id" style="width: 100%;">
                            @foreach($ubicaciones as $ubicacion)
                              <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select
                            id="departamento_id" data-departamento-id="{{old('departamento_id') ?: $departamento->id}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" data-escuela-id="{{old('escuela_id') ?: $escuela->id}}" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empCredencial', $empleado->empCredencial, array('id' => 'empCredencial', 'class' => 'validate','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'8')) !!}
                      {!! Form::hidden('empCredencialAnterior', $empleado->empCredencial, array('id' => 'empCredencialAnterior', 'class' => 'validate','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'8')) !!}
                      {!! Form::label('empCredencial', 'Clave credencial', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empNomina', $empleado->empNomina, array('id' => 'empNomina', 'class' => 'validate','min'=>'0','max'=>'99999999999','onKeyPress="if(this.value.length==11) return false;"')) !!}
                      {!! Form::hidden('empNominaAnterior', $empleado->empNomina, array('id' => 'empNominaAnterior', 'class' => 'validate','min'=>'0','max'=>'99999999999','onKeyPress="if(this.value.length==11) return false;"')) !!}
                      {!! Form::label('empNomina', 'Clave nomina', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empImss', $empleado->empImss, array('id' => 'empImss', 'class' => 'validate','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'11')) !!}
                      {!! Form::label('empImss', 'Clave imss', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perCurp', $empleado->persona->perCurp, array('id' => 'perCurp', 'class' => 'validate','required')) !!}
                      {!! Form::hidden('perCurpOld', $empleado->persona->perCurp, ['id' => 'perCurpOld']) !!}
                      {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                      {!! Form::label('perCurp', 'Curp * (min 18 caracteres)', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empRfc', $empleado->empRfc, array('id' => 'empRfc', 'class' => 'validate','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'13')) !!}
                      {!! Form::hidden('empRfcAnterior', $empleado->empRfc, array('id' => 'empRfcAnterior', 'class' => 'validate','pattern' => '[A-Z,a-z,0-9]*','maxlength'=>'13')) !!}
                      {!! Form::label('empRfc', 'Rfc * (min 13 caracteres)', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empHorasCon', $empleado->empHorasCon, array('id' => 'empHorasCon', 'class' => 'validate','readonly','min'=>'0','max'=>'99999999999','onKeyPress="if(this.value.length==11) return false;"')) !!}
                      {!! Form::label('empHorasCon', 'Horas *', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col s12 m6 l4">
                    <label for="puesto_id">Puesto</label>
                    <select class="browser-default validate select2" data-puesto-id="{{old('puesto_id') ?: $empleado->puesto_id}}" id="puesto_id" name="puesto_id" style="width:100%;">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      @foreach($puestos as $puesto)
                        <option value="{{$puesto->id}}">{{$puesto->puesNombre}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    {!! Form::label('empEstado', 'Estatus de Empleado *', array('class' => '')); !!}
                    <select id="empEstado" name="empEstado" data-emp-estado="{{old('empEstado') ?: $empleado->empEstado}}" class="browser-default validate select2" required style="width:100%;">
                      <option value="A">ALTA</option>
                      @if($puedeDarseDeBaja)
                        <option value="B">BAJA</option>
                      @endif
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field col s12 m6 l6">
                        <input type="password" class="validate noUpperCase" id="password" name="password" value="{{old('password')}}" maxlength="191">
                        <label for="password">Contraseña docente</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="password" class="validate noUpperCase" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}" maxlength="191">
                        <label for="password_confirmation">Confirmar contraseña</label>
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="">
                    <label for="created_at">Fecha de registro</label>
                    <input type="date" name="created_at" id="created_at" value="{{$empleado->empFechaRegistro}}" readonly>
                  </div>
                </div>
              </div>
          </div>

          {{-- PERSONAL BAR--}}
          <div id="personal">

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perDirCalle', $empleado->persona->perDirCalle, array('id' => 'perDirCalle', 'class' => 'validate','required','maxlength'=>'25')) !!}
                      {!! Form::label('perDirCalle', 'Calle *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perDirNumExt', $empleado->persona->perDirNumExt, array('id' => 'perDirNumExt', 'class' => 'validate','required','maxlength'=>'6')) !!}
                        {!! Form::label('perDirNumExt', 'Número exterior *', array('class' => '')); !!}
                        </div>
                    </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perDirNumInt', $empleado->persona->perDirNumInt, array('id' => 'perDirNumInt', 'class' => 'validate','maxlength'=>'6')) !!}
                      {!! Form::label('perDirNumInt', 'Número interior', array('class' => '')); !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      {!! Form::label('pais_id', 'País *', array('class' => '')); !!}
                      <select id="pais_id" class="browser-default validate select2" data-pais-id="{{old('pais_id') ?: $pais->id}}" required name="pais_id" style="width: 100%;">
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                          @foreach($paises as $pais)
                            <option value="{{$pais->id}}">{{$pais->paisNombre}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('estado_id', 'Estado *', array('class' => '')); !!}
                      <select id="estado_id" class="browser-default validate select2" data-estado-id="{{old('estado_id') ?: $estado->id}}" required name="estado_id" style="width: 100%;">
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('municipio_id', 'Municipio *', array('class' => '')); !!}
                      <select id="municipio_id" class="browser-default validate select2" data-municipio-id="{{old('municipio_id') ?: $municipio->id}}" required name="municipio_id" style="width: 100%;">
                          <option value="">SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perDirColonia', $empleado->persona->perDirColonia, array('id' => 'perDirColonia', 'class' => 'validate','required','maxlength'=>'60')) !!}
                      {!! Form::label('perDirColonia', 'Colonia *', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('perDirCP', $empleado->persona->perDirCP, array('id' => 'perDirCP', 'class' => 'validate','required', 'pattern' => '[A-Z,a-z,0-9]*','min'=>'0','max'=>'99999','onKeyPress="if(this.value.length==5) return false;"')) !!}
                      {!! Form::label('perDirCP', 'Código Postal *', array('class' => '')); !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                    {!! Form::label('perSexo', 'Sexo *', array('class' => '')); !!}
                    <select id="perSexo" class="browser-default validate select2" required name="perSexo" style="width: 100%;">
                        <option value="M" @if($empleado->persona->perSexo == "M") {{ 'selected' }} @endif>HOMBRE</option>
                        <option value="F" @if($empleado->persona->perSexo == "F") {{ 'selected' }} @endif>MUJER</option>
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('perFechaNac', 'Fecha de nacimiento *', array('class' => '')); !!}
                      {!! Form::date('perFechaNac', $empleado->persona->perFechaNac, array('id' => 'perFechaNac', 'class' => ' validate','required')) !!}
                  </div>
              </div>


              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('perTelefono1', $empleado->persona->perTelefono1, array('id' => 'perTelefono1', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                      {!! Form::label('perTelefono1', 'Teléfono fijo', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('perTelefono2', $empleado->persona->perTelefono2, array('id' => 'perTelefono2', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                      {!! Form::label('perTelefono2', 'Teléfono móvil', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::email('perCorreo1', $empleado->persona->perCorreo1, array('id' => 'perCorreo1', 'class' => 'validate','maxlength'=>'60')) !!}
                      {!! Form::label('perCorreo1', 'Correo', array('class' => '')); !!}
                      </div>
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
  {{-- Funciones Auxiliares --}}
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
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

          let ubicacion = $('#ubicacion_id');
          let departamento = $('#departamento_id');
          let pais = $('#pais_id');
          let estado = $('#estado_id');

          avoidSpecialCharacters('perNombre');
          avoidSpecialCharacters('perApellido1');
          avoidSpecialCharacters('perApellido2');

          apply_data_to_select('ubicacion_id', 'ubicacion-id');
          apply_data_to_select('pais_id', 'pais-id');
          apply_data_to_select('puesto_id', 'puesto-id');
          apply_data_to_select('empEstado', 'emp-estado');

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
    </script>
@endsection