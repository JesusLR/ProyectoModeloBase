@extends('layouts.dashboard')

@section('template_title')
  Historico
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('historico')}}" class="breadcrumb">Listado historico de calificaciones</a>
    <label class="breadcrumb">Editar historico</label>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {{ Form::open(array('method'=>'PUT','route' => ['historico.update', $historico->id])) }}
        {!! Form::hidden('alumno_id', $historico->alumno_id, ['id' => 'alumno_id']) !!}
        {!! Form::hidden('plan_id', $historico->plan_id, ['id' => 'plan_id']) !!}
        {!! Form::hidden('periodo_id', $historico->periodo_id, ['id' => 'periodo_id']) !!}


        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR HISTORICO #{{$historico->id}}</span>
            
            <p>
              ({{$historico->alumno->aluClave}})
              {{$historico->alumno->persona->perNombre}}
              {{$historico->alumno->persona->perApellido1}}
              {{$historico->alumno->persona->perApellido2}}
            </p>
            <p>
              Período: {{$historico->periodo->perNumero}}-{{$historico->periodo->perAnio}}
            </p>
            <p>
              ({{$historico->plan->planClave}}) {{$historico->plan->programa->progClave}} {{$historico->plan->programa->progNombre}}
            </p>

            <p>
              Materia: ({{$historico->materia->matClave}}) {{$historico->materia->matNombre}}
            </p>



            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended" style="margin-top: 20px;">
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
                  <div class="input-field">
                    {!! Form::text('histComplementoNombre', $historico->histComplementoNombre, ['id' => 'histComplementoNombre', 'class' => 'validate']) !!}
                    {!! Form::label('histComplementoNombre', 'Complemento de nombre', ['class' => '']); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                    {!! Form::label('histPeriodoAcreditacion', 'Período acreditación *', ['class' => '']); !!}
                    <select name="histPeriodoAcreditacion" id="histPeriodoAcreditacion" class="browser-default validate select2" style="width: 100%;" required>
                      <option value="PN" {{$historico->histPeriodoAcreditacion == "PN" ? "selected": "" }}>Período normal</option>
                      <option value="CV" {{$historico->histPeriodoAcreditacion == "CV" ? "selected": "" }}>Curso de Verano</option>
                      <option value="EX" {{$historico->histPeriodoAcreditacion == "EX" ? "selected": "" }}>Examen Extraordinario</option>
                      <option value="CE" {{$historico->histPeriodoAcreditacion == "CE" ? "selected": "" }}>Curso Especial</option>
                      <option value="EG" {{$historico->histPeriodoAcreditacion == "EG" ? "selected": "" }}>Examen Global</option>
                      <option value="RV" {{$historico->histPeriodoAcreditacion == "RV" ? "selected": "" }}>Revalidación</option>
                      <option value="RC" {{$historico->histPeriodoAcreditacion == "RC" ? "selected": "" }}>Recursamiento</option>
                      <option value="CP" {{$historico->histPeriodoAcreditacion == "CP" ? "selected": "" }}>Certificado Parcial</option>
                    </select>
                    {{-- $historico->histPeriodoAcreditacion --}}

                </div>
      
                <div class="col s12 m6 l4">
                    {!! Form::label('histTipoAcreditacion', 'Tipo acreditación *', ['class' => '']); !!}
                    <select name="histTipoAcreditacion" id="histTipoAcreditacion" class="browser-default validate select2" style="width: 100%;" required>
                      <option value="CI" {{$historico->histTipoAcreditacion == "CI" ? "selected": ""}}>Curso Inicial</option>
                      <option value="CR" {{$historico->histTipoAcreditacion == "CR" ? "selected": ""}}>Curso Repetición</option>
                      <option value="X1" {{$historico->histTipoAcreditacion == "X1" ? "selected": ""}}>Extraordinario 1</option>
                      <option value="X2" {{$historico->histTipoAcreditacion == "X2" ? "selected": ""}}>Extraordinario 2</option>
                      <option value="X3" {{$historico->histTipoAcreditacion == "X3" ? "selected": ""}}>Extraordinario 3</option>
                      <option value="X4" {{$historico->histTipoAcreditacion == "X4" ? "selected": ""}}>Extraordinario 4</option>
                      <option value="X5" {{$historico->histTipoAcreditacion == "X5" ? "selected": ""}}>Extraordinario 5</option>
                      <option value="EE" {{$historico->histTipoAcreditacion == "EE" ? "selected": ""}}>Curso Especial</option>
                      <option value="RV" {{$historico->histTipoAcreditacion == "RV" ? "selected": ""}}>Revalidación</option>
                      <option value="RC" {{$historico->histTipoAcreditacion == "RC" ? "selected": ""}}>Recursamiento</option>
                      <option value="CP" {{$historico->histTipoAcreditacion == "CP" ? "selected": ""}}>Certificado Parcial</option>
                    </select>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('histFechaExamen', $historico->histFechaExamen, ['id' => 'histFechaExamen', 'class' => 'validate', 'required']) !!}
                    {!! Form::label('histFechaExamen', 'Fecha de examen *', ['class' => '']); !!}
                  </div>
                </div>
                
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('histCalificacion', $historico->histCalificacion, ['id' => 'histCalificacion', 'class' => 'validate']) !!}
                    {!! Form::label('histCalificacion', 'Calificación', ['class' => '']); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('histNombreOficial', $historico->histNombreOficial, ['id' => 'histNombreOficial', 'class' => 'validate']) !!}
                    {!! Form::label('histNombreOficial', 'Nombre oficial', ['class' => '']); !!}
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

@endsection