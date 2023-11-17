@extends('layouts.dashboard')

@section('template_title')
    Idiomas empleado
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_empleado')}}" class="breadcrumb">Lista de empleados</a>
    <a href="{{url('idiomas_empleado/'.$empleado->id)}}" class="breadcrumb">Ver empleado</a>
@endsection

@section('content')


<div class="row">
  <div class="col s12 ">
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">EMPLEADO #{{$empleado->id}}</span>

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
                      {!! Form::text('empNombre', $empleado->empNombre, array('readonly' => 'true')) !!}
                      {!! Form::label('empNombre', 'Nombre(s)', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empApellido1', $empleado->empApellido1, array('readonly' => 'true')) !!}
                      {!! Form::label('empApellido1', 'Primer apellido', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empApellido2', $empleado->empApellido2, array('readonly' => 'true')) !!}
                      {!! Form::label('empApellido2', 'Segundo apellido', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ubicacion_id', $empleado->escuela->departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubicacion_id', 'Campus', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('departamento_id', $empleado->escuela->departamento->depNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escuela_id', $empleado->escuela->escNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empCredencial', $empleado->empCredencial, array('readonly' => 'true')) !!}
                      {!! Form::label('empCredencial', 'Clave credencial', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empNomina', $empleado->empNomina, array('readonly' => 'true')) !!}
                      {!! Form::label('empNomina', 'Clave nomina', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empNSS', $empleado->empNSS, array('readonly' => 'true')) !!}
                      {!! Form::label('empNSS', 'Clave imss', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empCURP', $empleado->empCURP, array('readonly' => 'true')) !!}
                      {!! Form::label('empCURP', 'Curp', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empRFC', $empleado->empRFC, array('readonly' => 'true')) !!}
                      {!! Form::label('empRFC', 'Rfc', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empHoras', $empleado->empHoras, array('readonly' => 'true')) !!}
                      {!! Form::label('empHoras', 'Horas', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <input type="text" name="puesNombre" id="puesNombre" value="{{$empleado->puesNombre}}">
                    <label for="puesNombre">Puesto</label>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    <label for="created_at">Fecha de registro</label>
                    <input type="date" name="created_at" id="created_at" value="{{$empleado->empFechaIngreso}}" readonly>
                  </div>
                </div>
              </div>
          </div>

          {{-- PERSONAL BAR--}}
          <div id="personal">

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empDireccionCalle', $empleado->empDireccionCalle, array('readonly' => 'true')) !!}
                      {!! Form::label('empDireccionCalle', 'Calle', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('empDireccionNumero', $empleado->empDireccionNumero, array('readonly' => 'true')) !!}
                        {!! Form::label('empDireccionNumero', 'Número exterior', array('class' => '')); !!}
                        </div>
                    </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empDireccionNumero', $empleado->empDireccionNumero, array('readonly' => 'true')) !!}
                      {!! Form::label('empDireccionNumero', 'Número interior', array('class' => '')); !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('paisId', $empleado->municipio->estado->pais->paisNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('paisId', 'País', array('class' => '')); !!}
                        </div>
                  </div>
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('estado_id', $empleado->municipio->estado->edoNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('estado_id', 'Estado', array('class' => '')); !!}
                        </div>
                  </div>
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('municipio_id', $empleado->municipio->munNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('municipio_id', 'Municipio', array('class' => '')); !!}
                        </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empDireccionColonia', $empleado->empDireccionColonia, array('readonly' => 'true')) !!}
                      {!! Form::label('empDireccionColonia', 'Colonia', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empDireccionCP', $empleado->empDireccionCP, array('readonly' => 'true')) !!}
                      {!! Form::label('empDireccionCP', 'Código Postal', array('class' => '')); !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('empSexo', $empleado->empSexo, array('readonly' => 'true')) !!}
                        {!! Form::label('empSexo', 'Sexo', array('class' => '')); !!}
                        </div>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('empFechaNacimiento', 'Fecha de nacimiento ', array('class' => '')); !!}
                      {!! Form::date('empFechaNacimiento', $empleado->empFechaNacimiento, array('readonly' => 'true')) !!}
                  </div>
              </div>


              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empTelefono', $empleado->empTelefono, array('readonly' => 'true')) !!}
                      {!! Form::label('empTelefono', 'Teléfono fijo', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empTelefono', $empleado->empTelefono, array('readonly' => 'true')) !!}
                      {!! Form::label('empTelefono', 'Teléfono móvil', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::email('empCorreo1', $empleado->empCorreo1, array('readonly' => 'true')) !!}
                      {!! Form::label('empCorreo1', 'Correo', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
          </div>

        </div>
      </div>
  </div>
</div>

@endsection
