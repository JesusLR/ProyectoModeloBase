@extends('layouts.dashboard')

@section('template_title')
    Reportes
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="" class="breadcrumb">Relación de alumnos por programa</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/rel_aluprog_educontinua/imprimir', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">RELACIÓN DE ALUMNOS POR PROGRAMA</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="filtros">
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'1')) !!}
                    {!! Form::label('perNumero', 'Número de periodo', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('perAnio', 'Año de periodo', array('class' => '')); !!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('ubiClave', 'Campus', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('escClave', NULL, array('id' => 'escClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('escClave', 'Clave escuela', array('class' => '')); !!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('progId', NULL, array('id' => 'progId', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('progId', 'Num. id prog', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ecClave', NULL, array('id' => 'ecClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('ecClave', 'Clave prog.', array('class' => '')); !!}
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('nombreAlumno', NULL, array('id' => 'nombreAlumno', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('nombreAlumno', 'Nombre alumno', array('class' => '')); !!}
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('tipoprograma_id', 'Tipo programa', ['class' => '']); !!}
                  <select name="tipoprograma_id" id="tipoprograma_id" class="browser-default validate select2" style="width: 100%;">
                    <option value="">Seleccionar</option>
                    @foreach($tiposPrograma as $key => $item)
                      <option value="{{$item->id}}">{{$item->tpNombre}}</option>
                    @endforeach
                  </select>
                </div>
                
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('ecNombre', NULL, array('id' => 'ecNombre', 'class' => 'validate','min'=>'0')) !!}
                    {!! Form::label('ecNombre', 'Nombre del programa', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('ecFechaRegistro', 'Fecha registro', array('class' => '')); !!}
                  {!! Form::date('ecFechaRegistro', NULL, array('id' => 'ecFechaRegistro', 'class' => 'validate','min'=>'0')) !!}
                </div>
              </div>



                <div class="row">
                  <div class="col s12 m6 l4">
                    {!! Form::label('ecCoordinador_empleado_id', 'Coordinador', array('class' => '')); !!}
                    <select id="ecCoordinador_empleado_id" class="browser-default validate select2" name="ecCoordinador_empleado_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($empleados as $empleado)
                          <option value="{{$empleado->id}}" >{{$empleado->persona->perNombre ." ". $empleado->persona->perApellido1." ".$empleado->persona->perApellido2}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    {!! Form::label('ecInstructor1_empleado_id', 'Instructor 1', array('class' => '')); !!}
                    <select id="ecInstructor1_empleado_id" class="browser-default validate select2" name="ecInstructor1_empleado_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($empleados as $empleado)
                          <option value="{{$empleado->id}}" >{{$empleado->persona->perNombre ." ". $empleado->persona->perApellido1." ".$empleado->persona->perApellido2}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col s12 m6 l4">
                    {!! Form::label('ecInstructor2_empleado_id', 'Instructor 2', array('class' => '')); !!}
                    <select id="ecInstructor2_empleado_id" class="browser-default validate select2" name="ecInstructor2_empleado_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($empleados as $empleado)
                          <option value="{{$empleado->id}}" >{{$empleado->persona->perNombre ." ". $empleado->persona->perApellido1." ".$empleado->persona->perApellido2}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col s12 m6 l4">
                    {!! Form::label('ecEstado', 'Estado', array('class' => '')); !!}
                    <select name="ecEstado" id="ecEstado" class="browser-default validate select2" style="width: 100%;">
                        <option value="">SELECCIONAR</option>
                        <option value="A">ABIERTO</option>
                        <option value="C">CERRADO</option>
                    </select>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">picture_as_pdf</i> GENERAR REPORTE', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection


@section('footer_scripts')

@endsection