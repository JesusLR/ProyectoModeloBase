@extends('layouts.dashboard')

@section('template_title')
    Solicitud extraordinario
@endsection

@section('head')
    {!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('extraordinario')}}" class="breadcrumb">Lista de extraordinario</a>
    <a href="{{url('solicitudes/extraordinario')}}" class="breadcrumb">Lista de solicitudes</a>
    <label class="breadcrumb">Ver solicitud extraordinario</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">SOLICITUD EXTRAORDINARIO#{{$solicitud->id}}</span>

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
                    <div class="col s12 m6">
                        <div class="input-field">
                            {!! Form::text('alumno_id', $solicitud->alumno_id, array('readonly' => 'true')) !!}
                            {!! Form::label('alumno_id', 'Alumno', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('extraordinario_id', $solicitud->extraordinario->id, array('readonly' => 'true')) !!}
                        {!! Form::label('extraordinario_id', 'Clave de examen', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('iexCalificacion', $solicitud->iexCalificacion, array('readonly' => 'true')) !!}
                        {!! Form::label('iexCalificacion', 'Calificación', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('iexFecha', $solicitud->iexFecha, array('readonly' => 'true')) !!}
                            {!! Form::label('iexFecha', 'Fecha de solicitud', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('iexEstado', 'Clave de examen', array('class' => '')); !!}
                        <select id="iexEstado" class="browser-default validate select2" name="iexEstado" style="width: 100%;">
                            @foreach($iexEstado as $key => $value)
                                @if($solicitud->iexEstado == $key)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <h3>Detalles de extraordinario</h3>
            <div class="row">
              <div class="col s12 m6 l4">
                  <div class="input-field">
                      {!! Form::text('ubiClave', $solicitud->extraordinario->materia->plan->programa->escuela->departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                      {!! Form::label('ubiClave', 'Ubicación', array('class' => '')); !!}
                  </div>
              </div>
              <div class="col s12 m6 l4">
                  <div class="input-field">
                      {!! Form::text('departamento_id', $solicitud->extraordinario->materia->plan->programa->escuela->departamento->depNombre, array('readonly' => 'true')) !!}
                      {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                  </div>
              </div>
              <div class="col s12 m6 l4">
                  <div class="input-field">
                      {!! Form::text('escuela_id', $solicitud->extraordinario->materia->plan->programa->escuela->escNombre, array('readonly' => 'true')) !!}
                      {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                  </div>
              </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('periodo_id', $solicitud->extraordinario->periodo->perNumero.'-'.$solicitud->extraordinario->periodo->perAnio, array('readonly' => 'true')) !!}
                        {!! Form::label('periodo_id', 'Periodo', array('class' => '')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perFechaInicial', $solicitud->extraordinario->periodo->perNumero.'-'.$solicitud->extraordinario->periodo->perFechaInicial, array('readonly' => 'true')) !!}
                    {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perFechaFinal', $solicitud->extraordinario->periodo->perNumero.'-'.$solicitud->extraordinario->periodo->perFechaFinal, array('readonly' => 'true')) !!}
                    {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        <input id="programa_id" type="hidden" value="{{$solicitud->extraordinario->materia->plan->programa_id}}" >
                        {!! Form::text('programa_nombre', $solicitud->extraordinario->materia->plan->programa->progNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('programa_nombre', 'Programa', array('class' => '')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('plan_id', $solicitud->extraordinario->materia->plan->planClave, array('readonly' => 'true')) !!}
                        {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('matSemestre', $solicitud->extraordinario->materia->matSemestre, array('readonly' => 'true')) !!}
                        {!! Form::label('matSemestre', 'Semestre', array('class' => '')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('extGrupo', $solicitud->extraordinario->extGrupo, array('readonly' => 'true')) !!}
                    {!! Form::label('extGrupo', 'Clave grupo', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col s12 m6">
                    <div class="input-field">
                    {!! Form::text('materia_id', $solicitud->extraordinario->materia->matNombre, array('readonly' => 'true')) !!}
                    {!! Form::label('materia_id', 'Materia', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="input-field">
                    {!! Form::text('aula_id', $solicitud->extraordinario->aula->aulaClave, array('readonly' => 'true')) !!}
                    {!! Form::label('aula_id', 'Aula', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="input-field">
                    {!! Form::text('optativa_id', ($solicitud->extraordinario->optativa) ? $solicitud->extraordinario->optativa->materia->matNombre : NULL, array('readonly' => 'true')) !!}
                    {!! Form::label('optativa_id', 'Optativa', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                      {!! Form::text('extFecha', $solicitud->extraordinario->extFecha, array('readonly' => 'true')) !!}
                      {!! Form::label('extFecha', 'Fecha examen', array('readonly' => 'true')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                      {!! Form::text('extHora', $solicitud->extraordinario->extHora, array('readonly' => 'true')) !!}
                      {!! Form::label('extHora', 'Hora examen', array('readonly' => 'true')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('extPago', $solicitud->extraordinario->extPago, array('readonly' => 'true')) !!}
                        {!! Form::label('extPago', 'Costo Examen', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <div class="input-field">
                        {!! Form::text('empleado_id',
                            $solicitud->extraordinario->empleado->persona->perNombre
                            .' '.$solicitud->extraordinario->empleado->persona->perApellido1
                            .' '.$solicitud->extraordinario->empleado->persona->perApellido2,
                        array('readonly' => 'true')) !!}
                        {!! Form::label('empleado_id', 'Docente', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="input-field">
                        {!! Form::text('empleado_sinodal_id', ($solicitud->extraordinario->empleadoSinodal)
                            ? $solicitud->extraordinario->empleadoSinodal->persona->perNombre
                                .' '.$solicitud->extraordinario->empleadoSinodal->persona->perApellido1
                                .' '.$solicitud->extraordinario->empleadoSinodal->persona->perApellido2
                            : NULL, array('readonly' => 'true')) !!}
                        {!! Form::label('empleado_sinodal_id', 'Sinodal', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            </div>

          </div>
        </div>
    </div>
  </div>

@endsection

@section('footer_scripts')

@endsection