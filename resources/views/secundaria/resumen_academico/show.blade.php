@extends('layouts.dashboard')

@section('template_title')
    Secundaria resumen académico
@endsection


@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('secundaria_resumen_academico')}}" class="breadcrumb">Lista de resumen académico</a>
    <label class="breadcrumb">Ver resumen académico</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">RESUMEN ACADÉMICO #{{$resumenAcademico->id}}</span>

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
                        <div class="input-field">
                            {!! Form::text('aluClave', $resumenAcademico->alumno->aluClave, array('readonly' => 'true')) !!}
                            {!! Form::label('aluClave', 'Clave de alumno', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ubiNombre', $resumenAcademico->plan->programa->escuela->departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiNombre', 'Ubicación', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombre', $resumenAcademico->plan->programa->escuela->departamento->depNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('depNombre', 'Departamento', array('class' => '')); !!}
                        </div>
                    </div>
                   
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escNombre', $resumenAcademico->plan->programa->escuela->escNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('escNombre', 'Escuela', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progNombre', $resumenAcademico->plan->programa->progNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('progNombre', 'Programa', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('planClave', $resumenAcademico->plan->planClave, array('readonly' => 'true')) !!}
                            {!! Form::label('planClave', 'Plan', array('class' => '')); !!}
                        </div>
                    </div>
                   
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perNombre', $resumenAcademico->alumno->persona->perNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('perNombre', 'Nombre', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perApellido1', $resumenAcademico->alumno->persona->perApellido1, array('readonly' => 'true')) !!}
                            {!! Form::label('perApellido1', 'Apellido paterno', array('class' => '')); !!}
                        </div>
                    </div>

                    @if ($resumenAcademico->alumno->persona->perApellido2 != "")
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perApellido2', $resumenAcademico->alumno->persona->perApellido2, array('readonly' => 'true')) !!}
                            {!! Form::label('perApellido2', 'Apellido materno', array('class' => '')); !!}
                        </div>
                    </div>
                    @endif
                   
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resClaveEspecialidad', $resumenAcademico->resClaveEspecialidad, array('readonly' => 'true')) !!}
                            {!! Form::label('resClaveEspecialidad', 'Clave especialidad', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resUltimoGrado', $resumenAcademico->periodoIngreso->perAnioPago, array('readonly' => 'true')) !!}
                            {!! Form::label('resPeriodoIngreso', 'Período de ingreso', array('class' => '')); !!}
                        </div>
                    </div>

                    @isset($resumenAcademico->periodoEgreso->perAnioPago)
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perAnioPagoEgreso', null, array('readonly' => 'true')) !!}
                            {!! Form::label('perAnioPagoEgreso', 'Período de egreso', array('class' => '')); !!}
                        </div>
                    </div>   
                    @endisset
                   
                                    
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perAnioPagoUltimo', $resumenAcademico->periodoUltimo->perAnioPago, array('readonly' => 'true')) !!}
                            {!! Form::label('perAnioPagoUltimo', 'Ultimo período', array('class' => '')); !!}
                        </div>
                    </div>  

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resUltimoGrado', $resumenAcademico->resUltimoGrado, array('readonly' => 'true')) !!}
                            {!! Form::label('resUltimoGrado', 'Ultimo grado', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resCreditosCursados', $resumenAcademico->resCreditosCursados, array('readonly' => 'true')) !!}
                            {!! Form::label('resCreditosCursados', 'Creditos cursados', array('class' => '')); !!}
                        </div>
                    </div>                   
                </div>
              

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resCreditosAprobados', $resumenAcademico->resCreditosAprobados, array('readonly' => 'true')) !!}
                            {!! Form::label('resCreditosAprobados', 'Creditos aprobados', array('class' => '')); !!}
                        </div>
                    </div>  

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resAvanceAcumulado', $resumenAcademico->resAvanceAcumulado, array('readonly' => 'true')) !!}
                            {!! Form::label('resAvanceAcumulado', 'Avance acomulado', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resPromedioAcumulado', $resumenAcademico->resPromedioAcumulado, array('readonly' => 'true')) !!}
                            {!! Form::label('resPromedioAcumulado', 'Promedio acomulado', array('class' => '')); !!}
                        </div>
                    </div>                   
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resEstado', $resumenAcademico->resEstado, array('readonly' => 'true')) !!}
                            {!! Form::label('resEstado', 'Estado', array('class' => '')); !!}
                        </div>
                    </div>  

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resFechaIngreso', \Carbon\Carbon::parse($resumenAcademico->resFechaIngreso)->format('d/m/Y'), array('readonly' => 'true')) !!}
                            {!! Form::label('resFechaIngreso', 'Fecha de ingreso', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resFechaEgreso', \Carbon\Carbon::parse($resumenAcademico->resFechaEgreso)->format('d/m/Y'), array('readonly' => 'true')) !!}
                            {!! Form::label('resFechaEgreso', 'Fecha de egreso', array('class' => '')); !!}
                        </div>
                    </div>                   
                </div>


                @if ($resumenAcademico->resEstado == "B")
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resFechaBaja', \Carbon\Carbon::parse($resumenAcademico->resFechaBaja)->format('d/m/Y'), array('readonly' => 'true')) !!}
                            {!! Form::label('resFechaBaja', 'Fecha de baja', array('class' => '')); !!}
                        </div>
                    </div>  

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resRazonBaja', $resumenAcademico->resRazonBaja, array('readonly' => 'true')) !!}
                            {!! Form::label('resRazonBaja', 'Razón de baja', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('resObservaciones', $resumenAcademico->resObservaciones, array('readonly' => 'true')) !!}
                            {!! Form::label('resObservaciones', 'Fecha de egreso', array('class' => '')); !!}
                        </div>
                    </div>                   
                </div>
                @endif
               
          </div>
        </div>
    </div>
  </div>

@endsection
