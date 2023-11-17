@extends('layouts.dashboard')

@section('template_title')
    Reporte resumen de calificaciones
@endsection

@section('breadcrumbs')
  <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Resumen de Calificaciones</a>
@endsection

@section('content')

  @php
      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
  @endphp

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'secundaria.secundaria_resumen_de_calificaciones.reporteResumenCalificacion', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">RESUMEN DE CALIFICACIONES</span>
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
            @php
            $periodo_actual = Auth::user()->empleado->escuela->departamento->perActual;
            @endphp

            <div class="row">
              <div class="col s12 m6 l4">
                  <label for="ubicacion_id">Ubicación*</label>
                  <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                            @php
                            $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                            $selected = '';
                            if($ubicacion->id == $ubicacion_id){
                            $selected = 'selected';
                            }
                            @endphp
                            <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                            @endforeach
                    </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="departamento_id">Departamento*</label>
                  <select name="departamento_id" id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      {{--  <option value="">SELECCIONE UNA OPCIÓN</option>  --}}
                  </select>
              </div>
              <div class="col s12 m6 l4">
                <label for="escuela_id">Escuela*</label>
                <select name="escuela_id" id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" style="width:100%;" required>
                    {{--  <option value="">SELECCIONE UNA OPCIÓN</option>  --}}
                </select>
              </div>
            </div>

            <div class="row">
              
              <div class="col s12 m6 l4">
                  <label for="programa_id">Programa*</label>
                  <select name="programa_id" id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                  <label for="plan_id">Plan</label>
                  <select name="plan_id" id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
              </div>
              <div class="col s12 m6 l4">
                <label for="periodo_id">Periodo*</label>
                <select name="periodo_id" id="periodo_id" data-periodo-id="{{old('periodo_id', $periodo_actual)}}" class="browser-default validate select2" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('gpoGrado', old('gpoGrado'), array('id' => 'gpoGrado', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('gpoGrado', 'Grado o Semestre*', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('gpoClave', old('gpoClave'), array('id' => 'gpoClave', 'class' => 'validate', "required")) !!}
                  {!! Form::label('gpoClave', 'Grupo*', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <label for="conceptos">Estado del curso *</label>
                <select required name="conceptos" id="conceptos" data-conceptos-id="{{old('conceptos')}}" class="browser-default validate select2" style="width:100%;">
                    {{-- <option value="">SELECCIONE UNA OPCIÓN</option> --}}
                    @foreach ($conceptos as $concepto)
                        <option value="{{$concepto->concClave}}" {{ old('conceptos') == $concepto->concClave ? 'selected' : '' }}>{{$concepto->concNombre}}</option>
                    @endforeach
                    <option value="T">TODOS</option>
                </select>
              </div>

              <div class="col s12 m6 l4">
                <label for="tipoReporte">Tipo de vista *</label>
                <select required name="tipoReporte" id="tipoReporte" data-tipoReporte-id="{{old('tipoReporte')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="porMes" {{ old('tipoReporte') == 'porMes' ? 'selected' : '' }}>POR MES</option>
                    <option value="porBimestre" {{ old('tipoReporte') == 'porBimestre' ? 'selected' : '' }}>POR BIMESTRE</option>
                    <option value="porTrimestre" {{ old('tipoReporte') == 'porTrimestre' ? 'selected' : '' }}>POR TRIMESTRE (ORDINARIO)</option>
                    <option value="califRecuperativos" {{ old('tipoReporte') == 'califRecuperativos' ? 'selected' : '' }}>POR TRIMESTRE (RECUPERATIVO)</option>
                    <option value="califFinales" {{ old('tipoReporte') == 'califFinales' ? 'selected' : '' }}>CALIFICACIONES FINALES</option>
                   
                </select>
              </div>

              
            </div>

            <div class="row">
              <div id="vistaPorMes" class="col s12 m6 l4" style="display: none;">
                <label for="mesEvaluar">Mes a consultar *</label>
                <select required name="mesEvaluar" id="mesEvaluar" data-mesEvaluar-id="{{old('mesEvaluar')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="Septiembre" {{ old('mesEvaluar') == 'Septiembre' ? 'selected' : '' }}>SEPTIEMBRE</option>
                    <option value="Octubre" {{ old('mesEvaluar') == 'Octubre' ? 'selected' : '' }}>OCTUBRE</option>
                    <option value="Noviembre" {{ old('mesEvaluar') == 'Noviembre' ? 'selected' : '' }}>NOVIEMBRE</option>
                    {{-- <option value="Diciembre" {{ old('mesEvaluar') == 'porBimestre' ? 'selected' : '' }}>DICIEMBRE</option> --}}
                    <option value="Enero" {{ old('mesEvaluar') == 'Enero' ? 'selected' : '' }}>DIEMBRE-ENERO</option>
                    <option value="Febrero" {{ old('mesEvaluar') == 'Febrero' ? 'selected' : '' }}>FEBRERO</option>
                    <option value="Marzo" {{ old('mesEvaluar') == 'Marzo' ? 'selected' : '' }}>MARZO</option>
                    <option value="Abril" {{ old('mesEvaluar') == 'Abril' ? 'selected' : '' }}>ABRIL</option>
                    <option value="Mayo" {{ old('mesEvaluar') == 'Mayo' ? 'selected' : '' }}>MAYO</option>
                    <option value="Junio" {{ old('mesEvaluar') == 'Junio' ? 'selected' : '' }}>JUNIO</option>
                  </select>
              </div>

              <div id="vistaPorBimestre" class="col s12 m6 l4" style="display: none;">
                <label for="bimestreEvaluar">Bimestre a consultar *</label>
                <select required name="bimestreEvaluar" id="bimestreEvaluar" data-bimestreEvaluar-id="{{old('bimestreEvaluar')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="BIMESTRE1" {{ old('bimestreEvaluar') == 'BIMESTRE1' ? 'selected' : '' }}>BIMESTRE 1</option>
                    <option value="BIMESTRE2" {{ old('bimestreEvaluar') == 'BIMESTRE2' ? 'selected' : '' }}>BIMESTRE 2</option>
                    <option value="BIMESTRE3" {{ old('bimestreEvaluar') == 'BIMESTRE3' ? 'selected' : '' }}>BIMESTRE 3</option>
                    <option value="BIMESTRE4" {{ old('bimestreEvaluar') == 'BIMESTRE4' ? 'selected' : '' }}>BIMESTRE 4</option>
                    <option value="BIMESTRE5" {{ old('bimestreEvaluar') == 'BIMESTRE5' ? 'selected' : '' }}>BIMESTRE 5</option>                    
                  </select>
              </div>

              <div id="vistaPorTrimestre" class="col s12 m6 l4" style="display: none;">
                <label for="trimestreEvaluar">Trimestre a consultar *</label>
                <select required name="trimestreEvaluar" id="trimestreEvaluar" data-trimestreEvaluar-id="{{old('trimestreEvaluar')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    <option value="TRIMESTRE1" {{ old('trimestreEvaluar') == 'TRIMESTRE1' ? 'selected' : '' }}>TRIMESTRE 1</option>
                    <option value="TRIMESTRE2" {{ old('trimestreEvaluar') == 'TRIMESTRE2' ? 'selected' : '' }}>TRIMESTRE 2</option>
                    <option value="TRIMESTRE3" {{ old('trimestreEvaluar') == 'TRIMESTRE3' ? 'selected' : '' }}>TRIMESTRE 3</option>                                       
                  </select>
              </div>

              <div id="vistaFinales" class="col s12 m6 l4" style="display: none;">
                <label for="tipoFinal">Calificación final a consultar *</label>
                <select required name="tipoFinal" id="tipoFinal" data-tipoFinal-id="{{old('tipoFinal')}}" class="browser-default validate select2" style="width:100%;">
                    {{--  <option value="finalAmbos" {{ old('tipoFinal') == 'finalAmbos' ? 'selected' : '' }}>CAL. FINAL AMBOS</option>                                         --}}
                    <option value="finaLModelo" {{ old('tipoFinal') == 'finaLModelo' ? 'selected' : '' }}>PROMEDIO MODELO</option>
                    <option value="finalSep" {{ old('tipoFinal') == 'finalSep' ? 'selected' : '' }}>PROMEDIO SEP</option>
                  </select>
              </div>

              <div id="vistaRecuperativos" class="col s12 m6 l4" style="display: none;">
                <label for="tipoRecuperativo">Calificación recuperativo a consultar *</label>
                <select required name="tipoRecuperativo" id="tipoRecuperativo" data-tipoRecuperativo-id="{{old('tipoRecuperativo')}}" class="browser-default validate select2" style="width:100%;">
                    <option value="recuperativosTrimestre1" {{ old('tipoRecuperativo') == 'recuperativosTrimestre1' ? 'selected' : '' }}>TRIMESTRE 1</option>                                       
                    <option value="recuperativosTrimestre2" {{ old('tipoRecuperativo') == 'recuperativosTrimestre2' ? 'selected' : '' }}>TRIMESTRE 2</option>                                       
                    <option value="recuperativosTrimestre3" {{ old('tipoRecuperativo') == 'recuperativosTrimestre3' ? 'selected' : '' }}>TRIMESTRE 3</option>           
                    {{--  <option value="recuperativosTrimestreTodos" {{ old('tipoRecuperativo') == 'recuperativosTrimestreTodos' ? 'selected' : '' }}>TODOS</option>                                         --}}
                            
                  </select>
              </div>

              <div class="col s12 m6 l4">
                <label for="tipoCalificacionVista">Tipo de Calificaciones *</label>
                <select required name="tipoCalificacionVista" id="tipoCalificacionVista" data-tipoCalificacionVista-id="{{old('tipoCalificacionVista')}}" class="browser-default validate select2" style="width:100%;">
                    {{-- <option value="">SELECCIONE UNA OPCIÓN</option> --}}
                    <option value="todasLasMaterias" {{ old('tipoCalificacionVista') == 'todasLasMaterias' ? 'selected' : '' }}>TODOS LOS GRUPOS MATERIAS</option>
                    <option value="matOficialesSep" {{ old('tipoCalificacionVista') == 'matOficialesSep' ? 'selected' : '' }}>MATERIAS OFICIALES SEP</option>
                  </select>
              </div>

              <div class="col s12 m6 l4">
                <label for="modoCalificacion">Modo de calificación *</label>
                <select required name="modoCalificacion" id="modoCalificacion" data-modoCalificacion-id="{{old('modoCalificacion')}}" class="browser-default validate select2" style="width:100%;">
                    {{-- <option value="">SELECCIONE UNA OPCIÓN</option> --}}
                    <option value="BASEDIEZ" {{ old('modoCalificacion') == 'BASEDIEZ' ? 'selected' : '' }}>BASE A 10</option>
                    <option value="BASEPORCENTAJE" {{ old('modoCalificacion') == 'BASEPORCENTAJE' ? 'selected' : '' }}>BASE PORCENTAJE APLICADO</option>
                  </select>
              </div>
            </div>
            {{--  <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluClave', 'Clave alumno', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate')) !!}
                  {!! Form::label('aluMatricula', 'Matricula alumno', array('class' => '')); !!}
                </div>
              </div>
            </div>  --}}

            {{--  <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perApellido1', 'Primer Apellido', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 l6">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perApellido2', 'Segundo Apellido', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('perNombre', 'Nombre(s)', array('class' => '')); !!}
                </div>
              </div>
            </div>  --}}

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

{{--  @include('secundaria.scripts.funcionesAuxiliares')  --}}
@include('secundaria.scripts.preferencias_espesificas')
@include('secundaria.scripts.departamentos')
@include('secundaria.scripts.escuelas')
@include('secundaria.scripts.programas')
@include('secundaria.scripts.planes')
@include('secundaria.scripts.periodos')
@include('secundaria.reportes.calificaciones_por_grupo.ComboBoxJs')

@endsection
