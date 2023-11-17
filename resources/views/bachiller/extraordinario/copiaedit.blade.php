@extends('layouts.dashboard')

@section('template_title')
    Bachiller extraordinario
@endsection

@section('head')
    {!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_recuperativos')}}" class="breadcrumb">Lista de extraordinario</a>
    <label class="breadcrumb">Editar extraordinario</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['bachiller_recuperativos.update', $extraordinario->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR EXTRAORDINARIO #{{$extraordinario->id}}</span>

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
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                             <option value="{{$extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->id}}">{{$extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->plan->programa->escuela->departamento->id}}">
                                {{$extraordinario->bachiller_materia->plan->programa->escuela->departamento->depClave}}
                                {{"-"}}
                                {{$extraordinario->bachiller_materia->plan->programa->escuela->departamento->depNombre}}
                            </option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->plan->programa->escuela->id}}">{{$extraordinario->bachiller_materia->plan->programa->escuela->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                                <option value="{{$extraordinario->periodo->id}}">{{$extraordinario->periodo->perNumero}}-{{$extraordinario->periodo->perAnio}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perFechaInicial', $extraordinario->periodo->perFechaInicial, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perFechaFinal', $extraordinario->periodo->perFechaFinal, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->plan->programa->id}}">{{$extraordinario->bachiller_materia->plan->programa->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->plan->id}}">{{$extraordinario->bachiller_materia->plan->planClave}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoSemestre', 'Semestre *', array('class' => '')); !!}
                        <select id="gpoSemestre" class="browser-default validate select2" required name="gpoSemestre" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->matSemestre}}">{{$extraordinario->bachiller_materia->matSemestre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('extGrupo', $extraordinario->extGrupo, array('id' => 'extGrupo', 'class' => 'validate','maxlength' => '3')) !!}
                        {!! Form::label('extGrupo', 'Clave grupo', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('materia_id', 'Materia *', array('class' => '')); !!}
                        <select id="materia_id" class="browser-default validate select2" required name="materia_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->id}}">{{$extraordinario->bachiller_materia->matClave}}-{{$extraordinario->bachiller_materia->matNombre}}</option>
                        </select>
                    </div>
                    {{--  <div class="col s12 m6">
                            {!! Form::label('aula_id', 'Aula', array('class' => '')); !!}
                            <select id="aula_id" class="browser-default validate select2" name="aula_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($aulas as $aula)
                                    <option value="{{$aula->id}}" @if($extraordinario->aula_id == $aula->id) {{ 'selected' }} @endif>{{$aula->aulaClave}}</option>
                                @endforeach
                            </select>
                        </div>  --}}
                </div>
                {{--  <div id="seccion_optativa" class="row">
                    <div class="col s12 ">
                        {!! Form::label('optativa_id', 'Optativa', array('class' => '')); !!}
                        <select id="optativa_id" class="browser-default validate select2" name="optativa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @if($extraordinario->optativa)
                                <option value="{{$extraordinario->optativa->id}}" selected>{{$extraordinario->optativa->optNombre}}</option>
                            @endif
                        </select>
                    </div>
                </div>  --}}
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFecha', 'Fecha examen', array('class' => '')); !!}
                        {!! Form::date('extFecha', $extraordinario->extFecha, array('id' => 'extFecha', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHora', 'Hora examen', array('class' => '')); !!}
                        {!! Form::time('extHora', $extraordinario->extHora, array('id' => 'extHora', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extPago', $extraordinario->extPago, array('id' => 'extPago', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==8) return false;"')) !!}
                        {!! Form::label('extPago', 'Costo Examen', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('empleado_id', 'Docente *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if($extraordinario->bachiller_empleado_id == $empleado->id) {{ 'selected' }} @endif>{{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col s12 m6">
                        {!! Form::label('empleado_sinodal_id', 'Sinodal', array('class' => '')); !!}
                        <select id="empleado_sinodal_id" class="browser-default validate select2" name="empleado_sinodal_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if($extraordinario->bachiller_empleado_sinodal != NULL && $extraordinario->bachiller_empleado_sinodal->id == $empleado->id) {{ 'selected' }} @endif>
                                    {{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}
                                </option>
                            @endforeach
                        </select>
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

@endsection

@section('footer_scripts')

{{--  @include('scripts.aulas')  --}}

@endsection