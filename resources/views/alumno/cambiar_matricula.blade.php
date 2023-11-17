@extends('layouts.dashboard')

@section('template_title')
    Alumno
@endsection

@section('head')

@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="{{url('alumno')}}" class="breadcrumb">Lista de alumnos</a>
  <a href="{{url('alumno/cambiar_matricula/' . $alumno->id)}}" class="breadcrumb">Cambiar matrícula alumno</a>
@endsection

@section('content')


  <div class="row">
    <div class="col s12 ">
      {!! Form::open(['url' => 'alumno/cambiar_matricula/edit', 'method' => 'POST']) !!}
        {!! Form::hidden('alumnoId', $alumno->id, ['id' => 'alumnoId']) !!}
      
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CAMBIAR MATRÍCULA ALUMNO #{{$alumno->id}}</span>

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
                  {!! Form::label('perNombre', 'Nombre', array('class' => '')); !!}
                  <p>{{$alumno->persona->perNombre}} {{$alumno->persona->perApellido1}} {{$alumno->persona->perApellido2}}</p>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('perCurp', 'Curp', array('class' => '')); !!}
                  <p>{{$alumno->persona->perCurp}}</p>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('aluNivelIngr', 'Nivel de ingreso', array('class' => '')); !!}
                  @php 
                    $dep = $departamentos->where("depNivel", "=", $alumno->aluNivelIngr)->first();
                  @endphp
                  <p>{{$dep ? $dep->depClave . "-" . $dep->depNombre: ""}}</p>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('perCurp', 'Grado de ingreso', array('class' => '')); !!}
                  <p>{{$alumno->aluGradoIngr}}</p>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('perCurp', 'Matrícula actual', array('class' => '')); !!}
                  <p>{{$alumno->aluMatricula ? $alumno->aluMatricula : "SIN MATRICULA ASIGNADA"}}</p>
                  {!! Form::hidden('matricAnterior', $alumno->aluMatricula, array('id' => 'matricAnterior', 'class' => 'validate','required','maxlength'=>'40')) !!}
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                  <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%; margin-top: 10px;">
                    <option value="" selected>SELECCIONE UNA OPCIÓN</option>
                    @foreach($planes as $plan)
                        <option value="{{$plan->id}}">({{$plan->cgt->plan->planClave}}) {{$plan->cgt->plan->programa->progClave}} - {{$plan->cgt->plan->programa->progNombre}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('aluMatricula', NULL, ['id' => 'aluMatricula', 'class' => 'validate', 'required', 'maxlength'=>'40']) !!}
                    {!! Form::label('aluMatricula', 'Matricula Nueva *', ['class' => '']); !!}
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
@endsection

@section('footer_scripts')
  @include('scripts.estados')
  @include('scripts.municipios')
@endsection