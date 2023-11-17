@extends('layouts.dashboard')

@section('template_title')
    Empleado
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('empleado')}}" class="breadcrumb">Lista de empleados</a>
    <a href="{{url('empleado/'.$empleado->id)}}" class="breadcrumb">Ver empleado</a>
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
                      {!! Form::text('perNombre', $empleado->persona->perNombre, array('readonly' => 'true')) !!}
                      {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perApellido1', $empleado->persona->perApellido1, array('readonly' => 'true')) !!}
                      {!! Form::label('perApellido1', 'Primer apellido', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perApellido2', $empleado->persona->perApellido2, array('readonly' => 'true')) !!}
                      {!! Form::label('perApellido2', 'Segundo apellido', array('class' => '')); !!}
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
                      {!! Form::text('empImss', $empleado->empImss, array('readonly' => 'true')) !!}
                      {!! Form::label('empImss', 'Clave imss', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perCurp', $empleado->persona->perCurp, array('readonly' => 'true')) !!}
                      {!! Form::label('perCurp', 'Curp', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('empRfc', $empleado->empRfc, array('readonly' => 'true')) !!}
                      {!! Form::label('empRfc', 'Rfc', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('empHorasCon', $empleado->empHorasCon, array('readonly' => 'true')) !!}
                      {!! Form::label('empHorasCon', 'Horas', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <input type="text" name="puesNombre" id="puesNombre" value="{{$empleado->puesto->puesNombre}}">
                    <label for="puesNombre">Puesto</label>
                  </div>
                </div>
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
                      {!! Form::text('perDirCalle', $empleado->persona->perDirCalle, array('readonly' => 'true')) !!}
                      {!! Form::label('perDirCalle', 'Calle', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perDirNumExt', $empleado->persona->perDirNumExt, array('readonly' => 'true')) !!}
                        {!! Form::label('perDirNumExt', 'Número exterior', array('class' => '')); !!}
                        </div>
                    </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perDirNumInt', $empleado->persona->perDirNumInt, array('readonly' => 'true')) !!}
                      {!! Form::label('perDirNumInt', 'Número interior', array('class' => '')); !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('paisId', $empleado->persona->municipio->estado->pais->paisNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('paisId', 'País', array('class' => '')); !!}
                        </div>
                  </div>
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('estado_id', $empleado->persona->municipio->estado->edoNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('estado_id', 'Estado', array('class' => '')); !!}
                        </div>
                  </div>
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('municipio_id', $empleado->persona->municipio->munNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('municipio_id', 'Municipio', array('class' => '')); !!}
                        </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::text('perDirColonia', $empleado->persona->perDirColonia, array('readonly' => 'true')) !!}
                      {!! Form::label('perDirColonia', 'Colonia', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('perDirCP', $empleado->persona->perDirCP, array('readonly' => 'true')) !!}
                      {!! Form::label('perDirCP', 'Código Postal', array('class' => '')); !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perSexo', $empleado->persona->perSexo, array('readonly' => 'true')) !!}
                        {!! Form::label('perSexo', 'Sexo', array('class' => '')); !!}
                        </div>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('perFechaNac', 'Fecha de nacimiento ', array('class' => '')); !!}
                      {!! Form::date('perFechaNac', $empleado->persona->perFechaNac, array('readonly' => 'true')) !!}
                  </div>
              </div>


              <div class="row">
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('perTelefono1', $empleado->persona->perTelefono1, array('readonly' => 'true')) !!}
                      {!! Form::label('perTelefono1', 'Teléfono fijo', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::number('perTelefono2', $empleado->persona->perTelefono2, array('readonly' => 'true')) !!}
                      {!! Form::label('perTelefono2', 'Teléfono móvil', array('class' => '')); !!}
                      </div>
                  </div>
                  <div class="col s12 m6 l4">
                      <div class="input-field">
                      {!! Form::email('perCorreo1', $empleado->persona->perCorreo1, array('readonly' => 'true')) !!}
                      {!! Form::label('perCorreo1', 'Correo', array('class' => '')); !!}
                      </div>
                  </div>
              </div>
          </div>

        </div>
      </div>
  </div>
</div>

@endsection
