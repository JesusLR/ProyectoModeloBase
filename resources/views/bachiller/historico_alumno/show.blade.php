@extends('layouts.dashboard')

@section('template_title')
  Bachiller historico
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_historial_academico')}}" class="breadcrumb">Listado historico de calificaciones</a>
    <label class="breadcrumb">Ver historico</label>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      
        {!! Form::hidden('alumno_id', $historico->alumno_id, ['id' => 'alumno_id']) !!}
        {!! Form::hidden('plan_id', $historico->plan_id, ['id' => 'plan_id']) !!}
        {{--  {!! Form::hidden('periodo_id', $historico->periodo_id, ['id' => 'periodo_id']) !!}  --}}


        <div class="card ">
          <div class="card-content ">
            <span class="card-title">HISTORICO #{{$historico->id}}</span>
            
            <p>
              ({{$historico->aluClave}})
              {{$historico->perNombre}}
              {{$historico->perApellido1}}
              {{$historico->perApellido2}}
            </p>
            <p>
              Período: {{$historico->perNumero}}-{{$historico->perAnio}}
            </p>
            <p>
              ({{$historico->planClave}}) {{$historico->progClave}} {{$historico->progNombre}}
            </p>

            <p>
              Materia: ({{$historico->matClave}}) {{$historico->matNombre}}
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
                    {!! Form::text('histComplementoNombre', $historico->histComplementoNombre, ['id' => 'histComplementoNombre', 'class' => 'validate', 'readonly']) !!}
                    {!! Form::label('histComplementoNombre', 'Complemento de nombre', ['class' => '']); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                    {!! Form::label('histPeriodoAcreditacion', 'Período acreditación *', ['class' => '']); !!}
                    <input type="text" readonly name="histPeriodoAcreditacion" id="histPeriodoAcreditacion"
                    @if ($historico->histPeriodoAcreditacion == "PN")
                        value="Período normal"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "CV")
                        value="Curso de Verano"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "EX")
                        value="Examen Extraordinario"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "CE")
                        value="Curso Especial"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "EG")
                        value="Examen Global"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "RV")
                        value="Revalidación"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "RC")
                        value="Recursamiento"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "CP")
                        value="Certificado Parcial"
                    @endif
                    >
                    {{--  <select name="histPeriodoAcreditacion" id="histPeriodoAcreditacion" class="browser-default validate select2" style="width: 100%;" required>
                      <option value="PN" {{$historico->histPeriodoAcreditacion == "PN" ? "selected": "" }}>Período normal</option>
                      <option value="CV" {{$historico->histPeriodoAcreditacion == "CV" ? "selected": "" }}>Curso de Verano</option>
                      <option value="EX" {{$historico->histPeriodoAcreditacion == "EX" ? "selected": "" }}>Examen Extraordinario</option>
                      <option value="CE" {{$historico->histPeriodoAcreditacion == "CE" ? "selected": "" }}>Curso Especial</option>
                      <option value="EG" {{$historico->histPeriodoAcreditacion == "EG" ? "selected": "" }}>Examen Global</option>
                      <option value="RV" {{$historico->histPeriodoAcreditacion == "RV" ? "selected": "" }}>Revalidación</option>
                      <option value="RC" {{$historico->histPeriodoAcreditacion == "RC" ? "selected": "" }}>Recursamiento</option>
                      <option value="CP" {{$historico->histPeriodoAcreditacion == "CP" ? "selected": "" }}>Certificado Parcial</option>
                    </select>  --}}
                    {{-- $historico->histPeriodoAcreditacion --}}

                </div>
      
                <div class="col s12 m6 l4">
                    {!! Form::label('histTipoAcreditacion', 'Tipo acreditación *', ['class' => '']); !!}
                    {{--  <select name="histTipoAcreditacion" id="histTipoAcreditacion" class="browser-default validate select2" style="width: 100%;" required>
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
                    </select>  --}}
                    <input type="text" readonly name="histPeriodoAcreditacion" id="histPeriodoAcreditacion"
                    @if ($historico->histPeriodoAcreditacion == "CI")
                        value="Curso Inicial"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "CR")
                        value="Curso Repetición"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "X1")
                        value="Extraordinario 1"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "X2")
                        value="Extraordinario 2"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "X3")
                        value="Extraordinario 3"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "X4")
                        value="Extraordinario 4"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "X5")
                        value="Extraordinario 5"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "EE")
                        value="Curso Especial"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "RV")
                        value="Revalidación"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "RC")
                        value="Recursamiento"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "CP")
                        value="Certificado Parcial"
                    @endif
                    >
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('histFechaExamen', $historico->histFechaExamen, ['id' => 'histFechaExamen', 'class' => 'validate', 'required', 'readonly']) !!}
                    {!! Form::label('histFechaExamen', 'Fecha de examen *', ['class' => '']); !!}
                  </div>
                </div>
                
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('histCalificacion', $historico->histCalificacion, ['id' => 'histCalificacion', 'class' => 'validate', 'readonly']) !!}
                    {!! Form::label('histCalificacion', 'Calificación', ['class' => '']); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('histNombreOficial', $historico->histNombreOficial, ['id' => 'histNombreOficial', 'class' => 'validate', 'readonly']) !!}
                    {!! Form::label('histNombreOficial', 'Nombre oficial', ['class' => '']); !!}
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