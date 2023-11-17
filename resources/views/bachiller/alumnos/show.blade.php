@extends('layouts.dashboard')

@section('template_title')
    Bachiller alumno
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_alumno')}}" class="breadcrumb">Lista de alumnos</a>
    <a href="{{url('bachiller_alumno/'.$alumno->id)}}" class="breadcrumb">Ver alumno</a>
@endsection

@section('content')

@php
    $progNombre = $ultimoCurso ? $ultimoCurso->cgt->plan->programa->progNombre : 'No encontró último curso';
    $planClave = $ultimoCurso ? $ultimoCurso->cgt->plan->planClave : 'No encontró último curso';
    $curEstado = $ultimoCurso ? $ultimoCurso->curEstado : 'No encontró último curso';
@endphp
<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Clave del Alumno #{{$alumno->aluClave}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  <li class="tab"><a href="#personal">Personal</a></li>
                  <li class="tab"><a href="#tutor">Tutor titular</a></li>
                  <li class="tab"><a href="#padres">Datos de los padres</a></li>
                  <li class="tab"><a href="#autorizados">Personas Autorizadas</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perNombre', $alumno->persona->perNombre, array('readonly' => 'true')) !!}
                            <label for="perNombre"><strong style="color: #000; font-size: 16px;">Nombre(s)</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perApellido1', $alumno->persona->perApellido1, array('readonly' => 'true')) !!}
                            <label for="perApellido1"><strong style="color: #000; font-size: 16px;">Primer apellido</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perApellido2', $alumno->persona->perApellido2, array('readonly' => 'true')) !!}
                            <label for="perApellido2"><strong style="color: #000; font-size: 16px;">Segundo apellido</strong></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perCurp', $alumno->persona->perCurp, array('readonly' => 'true')) !!}
                        <label for="perCurp"><strong style="color: #000; font-size: 16px;">Curp</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @foreach($departamentos as $departamento)
                              @php
                                  if($departamento->depNivel == $alumno->aluNivelIngr){
                                    $aluNivelIngr = $departamento->depNombre;
                                  }
                              @endphp
                            @endforeach
                        {!! Form::text('aluNivelIngr', $aluNivelIngr, array('readonly' => 'true')) !!}
                        <label for="aluNivelIngr"><strong style="color: #000; font-size: 16px;">Nivel de ingreso</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('aluGradoIngr', $alumno->aluGradoIngr, array('readonly' => 'true')) !!}
                            <label for="aluGradoIngr"><strong style="color: #000; font-size: 16px;">Grado Ingreso</strong></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('progNombre', $progNombre, array('readonly' => 'true')) !!}
                            <label for="progNombre"><strong style="color: #000; font-size: 16px;">Programa</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('planClave', $planClave, array('readonly' => 'true')) !!}
                            <label for="planClave"><strong style="color: #000; font-size: 16px;">Plan</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('curEstado', $curEstado, array('readonly' => 'true')) !!}
                            <label for="curEstado"><strong style="color: #000; font-size: 16px;">Estado</strong></label>
                        </div>
                    </div>
                </div>

            </div>

            {{-- PERSONAL BAR--}}
            <div id="personal">               

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perDirCalle', $alumno->persona->perDirCalle, array('readonly' => 'true')) !!}
                            <label for="perDirCalle"><strong style="color: #000; font-size: 16px;">Calle</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perDirNumExt', $alumno->persona->perDirNumExt, array('readonly' => 'true')) !!}
                            <label for="perDirNumExt"><strong style="color: #000; font-size: 16px;">Número exterior</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perDirNumInt', $alumno->persona->perDirNumInt, array('readonly' => 'true')) !!}
                            <label for="perDirNumInt"><strong style="color: #000; font-size: 16px;">Número interior</strong></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('paisId', $alumno->persona->municipio->estado->pais->paisNombre, array('readonly' => 'true')) !!}
                            <label for="paisId"><strong style="color: #000; font-size: 16px;">País</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('estado_id', $alumno->persona->municipio->estado->edoNombre, array('readonly' => 'true')) !!}
                            <label for="estado_id"><strong style="color: #000; font-size: 16px;">Estado</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('municipio_id', $alumno->persona->municipio->munNombre, array('readonly' => 'true')) !!}
                            <label for="municipio_id"><strong style="color: #000; font-size: 16px;">Municipio</strong></label>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('paisId', $secundariaProcedencia->municipio->estado->pais->paisNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('paisId', 'Secundaria país', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('estado_id', $secundariaProcedencia->municipio->estado->edoNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('estado_id', 'Secundaria estado', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('municipio_id', $secundariaProcedencia->municipio->munNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('municipio_id', 'Secundaria municipio', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('secundaria_id', $secundariaProcedencia->secNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('secundaria_id', 'Secundaria procedencia', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perDirColonia', $alumno->persona->perDirColonia, array('readonly' => 'true')) !!}
                            <label for="perDirColonia"><strong style="color: #000; font-size: 16px;">Colonia</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perDirCP', $alumno->persona->perDirCP, array('readonly' => 'true')) !!}
                            <label for="perDirCP"><strong style="color: #000; font-size: 16px;">Código Postal</strong></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perSexo', $alumno->persona->perSexo, array('readonly' => 'true')); !!}
                            <label for="perSexo"><strong style="color: #000; font-size: 16px;">Sexo</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                            <label for="perFechaNac"><strong style="color: #000; font-size: 16px;">Fecha de nacimiento</strong></label>
                            {!! Form::date('perFechaNac', $alumno->persona->perFechaNac, array('readonly' => 'true')) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perTelefono1', $alumno->persona->perTelefono1, array('readonly' => 'true')) !!}
                            <label for="perTelefono1"><strong style="color: #000; font-size: 16px;">Teléfono fijo</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perTelefono2', $alumno->persona->perTelefono2, array('readonly' => 'true')) !!}
                            <label for="perTelefono2"><strong style="color: #000; font-size: 16px;">Teléfono móvil</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perCorreo1', $alumno->persona->perCorreo1, array('readonly' => 'true')) !!}
                            <label for="perCorreo1"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tutor">
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('hisTutorOficial', $hisTutorOficial, array('readonly' => 'true')) !!}
                            <label for="hisTutorOficial"><strong style="color: #000; font-size: 16px;">Nombre de la persona autirizada o legalmente responsable *</strong></label>
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('hisParentescoTutor', $hisParentescoTutor, array('readonly' => 'true')) !!}
                            <label for="hisParentescoTutor"><strong style="color: #000; font-size: 16px;">Parentesco legal *</strong></label>
                        </div>
                    </div><div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('hisCelularTutor', $hisCelularTutor, array('readonly' => 'true')) !!}
                        <label for="hisCelularTutor"><strong style="color: #000; font-size: 16px;">Celular </strong></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        <label for="hisCorreoTutor"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                        {!! Form::email('hisCorreoTutor', $hisCorreoTutor, array('readonly' => 'true')) !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('hisCalleTutor', $hisCalleTutor, array('readonly' => 'true')) !!}
                            <label for="hisCalleTutor"><strong style="color: #000; font-size: 16px;">Calle</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('hisNumeroExtTutor', $hisNumeroExtTutor, array('readonly' => 'true')) !!}
                            <label for="hisNumeroExtTutor"><strong style="color: #000; font-size: 16px;">Número exterior</strong></label>
                        </div>
                    </div>
                </div>
    
                <div class="row">                   
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('hisNumeroIntTutor', $hisNumeroIntTutor, array('readonly' => 'true')) !!}
                        <label for="hisNumeroIntTutor"><strong style="color: #000; font-size: 16px;">Número interior</strong></label>
                        </div>
                    </div>
    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('hisColoniaTutor', $hisColoniaTutor, array('readonly' => 'true')) !!}
                            <label for="hisColoniaTutor"><strong style="color: #000; font-size: 16px;">Colonia</strong></label>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('hisCPTutor', $hisCPTutor, array('readonly' => 'true')) !!}
                            <label for="hisCPTutor"><strong style="color: #000; font-size: 16px;">Código Postal</strong></label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="padres">
                <br>
                <div class="row">
                    <table class="centered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Celular</th>
                                <th>Correo</th>
                                <th>Curp</th>
                                <th>Ocupación</th>
                                <th>Calle</th>
                                <th>Colonia</th>
                                <th>CP</th>
                                <th>Población</th>
                                <th>Estado</th>                               
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($tutores as $item)
                            <tr>
                                <td>{{$item->tutNombre}}</td>
                                <td>{{$item->tutTelefono}}</td>
                                <td>{{$item->tutCorreo}}</td>
                                <td>{{$item->curpTutor}}</td>
                                <td>{{$item->ocupacionTutor}}</td>
                                <td>{{$item->tutCalle}}</td>
                                <td>{{$item->tutColonia}}</td>
                                <td>{{$item->tutCodigoPostal}}</td>
                                <td>{{$item->tutPoblacion}}</td>
                                <td>{{$item->tutEstado}}</td>
                            </tr>                               
                           @empty
                               
                           @endforelse                      
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="autorizados">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                        {!! Form::text('personaAutorizada1', $personaAutorizada1, array('readonly' => 'true')) !!}
                        {!! Form::label('personaAutorizada1', 'Persona 1 ', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                        {!! Form::text('personaAutorizada2', $personaAutorizada2, array('readonly' => 'true')) !!}
                        {!! Form::label('personaAutorizada2', 'Persona 2', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection
