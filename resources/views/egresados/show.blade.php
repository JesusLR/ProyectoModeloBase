@extends('layouts.dashboard')

@section('template_title')
	Egresados
@endsection

@section('head')
@endsection

@section('breadcrumbs')
	<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
	<a href="{{url('egresados')}}" class="breadcrumb">Lista de Egresados</a>
	<label class="breadcrumb">Ver Egresado</label>
@endsection

@section('content')
<div class="row">
	<div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">Egresado #{{$egresado->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
          <div id="filtros">

            <div class="row">
              <div class="col s12 m6 l4">
                <br>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0','required','readonly'=>'true')) !!}
                  {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <br>
                <div class="input-field col s12 m6 14">
                  <p style="text-align:center;">Ubicación</p>
                  <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width:100%;" required disabled>
                    <option value="">Seleccionar...</option>
                    @foreach($ubicaciones as $key => $ubicacion)
                      <option value="{{$key}}">{{$ubicacion}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-field col s12 m6 14">
                  <p style="text-align:center;">Departamento</p>
                  <select name="depClave" id="depClave" class="browser-default validate select2" style="width:100%;" disabled required>
                    <option value="">Seleccionar...</option>
                    @foreach($departamentos as $key => $departamento)
                     <option value="{{$key}}">{{$departamento}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <br>
                <p style="text-align:center;">Periodo de Proceso de Egreso</p>
                <div class="input-field">
                  <select name="perProceso" id="perProceso" class="browser-default validate select2" style="width:100%;" disabled required>
                    <option value="">Selecciona...</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido1', 'Apellido Paterno', array('class' => '')); !!}
                </div>
                <div class="input-field col s1 m6 14">
                  {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate')) !!}
                  {!! Form::label('perApellido2', 'Apellido Materno', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate')) !!}
                  {!! Form::label('perNombre', 'Nombre', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::text('perSexo', NULL, array('id' => 'perSexo', 'class' => 'validate','maxlength'=>'1')) !!}
                  {!! Form::label('perSexo', 'Sexo (F, M)', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate','min'=>'0','required')) !!}
                  {!! Form::label('progClave', 'Clave de programa', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                   {!! Form::text('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0','required')) !!}
                   {!! Form::label('planClave', 'Clave de Plan', array('class' => '')); !!}
                </div>
              </div>
              
              
            </div>



            <div class="row">
              <div class="col s12 m6 l4">
                <br>
                <p style="text-align:center;">Periodo de Ingreso</p>
                <div class="input-field">
                  <select name="perIngreso" id="perIngreso" class="browser-default validate select2" style="width:100%;" disabled>
                    <option value="">Selecciona...</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <br>
                <p style="text-align:center;">Periodo de Egreso</p>
                <div class="input-field">
                  <select name="perEgreso" id="perEgreso" class="browser-default validate select2" style="width:100%;" disabled>
                    <option value="">Selecciona...</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <br>
                <p style="text-align:center;">Ult. mes de pago</p>
                <div class="input-field col s12 m6 14">
                  <select name="ultMesPago" id="ultMesPago" class="browser-default validate select2" style="width:100%;">
                    <option value="">Seleccionar mes</option>
                    @foreach($meses as $key => $mes)
                      <option value="{{$key}}">{{$mes}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-field col s12 m6 14">
                  <select name="ultAnioPago" id="ultAnioPago" class="browser-default validate select2" style="width:100%;">
                    <option value="">Seleccionar Año</option>
                    @for($a = $fechaActual->year; $a > 1997; $a--)
                      <option value="{{$a}}">{{$a}}</option>
                    @endfor
                  </select>
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::label('totalCreditosPlan', 'Total Créditos Plan', array('class' => '')); !!}
                  {!! Form::number('totalCreditosPlan', NULL, array('id' => 'totalCreditosPlan', 'class' => 'validate','min'=>'1','step'=>'1')) !!}
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::label('totalCreditosAprobados', 'Total Créditos Aprobados', array('class' => '')); !!}
                  {!! Form::number('totalCreditosAprobados', NULL, array('id' => 'totalCreditosAprobados', 'class' => 'validate','min'=>'1','step'=>'1')) !!}
                </div>
              </div>
            </div>

            <div class="row" style="background-color:#ECECEC;">
              <p style="text-align: center;font-size:1.2em;">Último curso</p>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <br>
                <p style="text-align:center;">Periodo</p>
                <div class="input-field">
                  <select name="perUltCurso" id="perUltCurso" class="browser-default validate select2" style="width:100%;" disabled>
                    <option value="">Selecciona...</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <p style="text-align:center;">Semestre</p>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('cgtGradoSemestre', NULL, array('id' => 'cgtGradoSemestre', 'class' => 'validate','min'=>'0','max'=>'12')) !!}
                  {!! Form::label('cgtGradoSemestre', 'Grado', array('class' => '')); !!}
                </div> 
                <div class="input-field col s12 m6 14">
                  {!! Form::text('cgtGrupo', NULL, array('id' => 'cgtGrupo', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('cgtGrupo','Grupo', array('class' => '')); !!}
                </div> 
              </div>
              <div class="col s12 m6 l4">
                <br>
                <div class="input-field col s12 m6 14">
                  {!! Form::text('progClaveUltCurso', NULL, array('id' => 'progClaveUltCurso', 'class' => 'validate','maxlength'=>'3')) !!}
                  {!! Form::label('progClaveUltCurso', 'Clave de programa', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                   {!! Form::text('curEstadoUltCurso', NULL, array('id' => 'curEstadoUltCurso', 'class' => 'validate','maxlength'=>'1')) !!}
                   {!! Form::label('curEstadoUltCurso', 'Estado del curso', array('class' => '')); !!}
                </div>
              </div>
            </div>

            <!-- SECCION DE TITULACIÓN -->
            <div name="seccionTitulacion" id="seccionTitulacion">
            <div class="row" style="background-color:#ECECEC;">
              <p style="text-align: center;font-size:1.2em;">Titulación</p>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <br>
                <p style="text-align:center;">Periodo</p>
                <div class="input-field">
                  <select name="perTitulacion" id="perTitulacion" class="browser-default validate select2" style="width:100%;" disabled>
                    <option value="">Selecciona...</option>
                  </select>
                </div>
              </div>
              <div class="col s12 m4 14">
                <div class="input-field col s12 m6 14">
                  <p style="text-align:center;">Fecha examen profesional</p>
                  {!! Form::date('fechaExamenProf', NULL, array('id' => 'fechaExamenProf', 'class' => 'validate', 'required')) !!}
                </div>
                <div class="input-field col s12 m6 14">
                  <p style="text-align:center;">Fecha expedición de título</p>
                  {!! Form::date('fechaExpedicionTitulo', NULL, array('id' => 'fechaExpedicionTitulo', 'class' => 'validate', 'required')) !!}
                </div>
              </div>
              <div class="col s12 m4 14">
                <div class="input-field">
                  <p style="text-align:center;">Opción de titulación</p>
                  <br>
                  <select name="opcionTitulo" id="opcionTitulo" class="browser-default validate select2" style="width:100%;">
                    <option value="">Selecciona...</option>
                    @foreach($conceptos_titulacion as  $key => $concepto)
                      <option value="{{$key}}">{{$concepto}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field col s12 m6 14">
                  {!! Form::number('aluMatricula', NULL, array('id' => 'aluMatricula', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('aluMatricula', 'Clave Sep (Mat)', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::text('claveSegey', NULL, array('id' => 'claveSegey', 'class' => 'validate')) !!}
                  {!! Form::label('claveSegey', 'Clave Segey', array('class' => '')); !!}
                </div>
              </div>
              <div class="col s12 m4 14">
                <div class="input-field col s12 m6 14">
                  <p style="text-align:center;">Modo Titulación Segey</p>
                  <select name="modoTitulacionSegey" id="modoTitulacionSegey" class="browser-default validate select2" style="width:100%;">
                    <option value="">Selecciona...</option>
                    @foreach($modos_titulacion as $key => $modo)
                    <option value="{{$key}}">{{$modo}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-field col s12 m6 14">
                  <p style="text-align:center;">Tipo de beca</p>
                  <select name="tipoBeca" id="tipoBeca" class="browser-default validate select2" style="width:100%;">
                    <option value="">Selecciona...</option>
                    @foreach($tipos_becas as $key => $beca)
                      <option value="{{$key}}">{{$beca}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col s12 m4 14">
                <div class="input-field col s12 m6 14">
                  <p style="text-align:center;">Tipo de Desempeño</p>
                  <select name="tipoDesempenio" id="tipoDesempenio" class="browser-default validate select2" style="width:100%;">
                    <option value="">Selecciona...</option>
                    @foreach($tipos_desempenio as $key => $desempenio)
                      <option value="{{$key}}">{{$desempenio}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="input-field col s12 m6 14">
                  {!! Form::label('desempenioProm', 'Desempeño(Promedio)', array('class' => '')); !!}
                  {!! Form::number('desempenioProm', NULL, array('id' => 'desempenioProm', 'class' => 'validate','min'=>'0','max'=>'100','step'=>'0.01')) !!}
                </div>
              </div>
            </div>
            </div> <!-- seccionTitulacion -->
          </div>
        </div>
    </div>
  </div>
</div>
@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {

        const datos = {!!json_encode($data)!!};
        const ubicacion = datos.ubicacion;
        const departamento = datos.departamento;
        var ubiClave = ubicacion.ubiClave;
        var depClave = departamento.depClave;

        const selectItems = [
                    'perProceso',
                    'perIngreso',
                    'perEgreso',
                    // 'perUltCurso',
                    'perTitulacion',
                ];

        var fillableForm = {
            ubiClave: ubiClave,
            depClave: depClave,
            aluClave: datos.alumno.aluClave,
            perApellido1: datos.persona.perApellido1,
            perApellido2: datos.persona.perApellido2,
            perNombre: datos.persona.perNombre,
            perSexo: datos.persona.perSexo,
            progClave: datos.programa.progClave,
            planClave: datos.plan.planClave,
            // perProceso: datos.egresado.periodo_id,
            // perIngreso: datos.egresado.egrPrimerPeriodo,
            // perEgreso: datos.egresado.egrUltimoPeriodo,
            ultMesPago: datos.mesPago,
            ultAnioPago: datos.anioPago,
            totalCreditosPlan: datos.plan.planNumCreditos,
            totalCreditosAprobados: datos.egresado.egrCreditosCursados, // resumen.resCreditosAprobados
            // perUltCurso: datos.ultimoCurso.periodo_id,
            cgtGradoSemestre: datos.ultimoCurso.cgt.cgtGradoSemestre,
            cgtGrupo: datos.ultimoCurso.cgt.cgtGrupo,
            progClaveUltCurso: datos.ultimoCurso.cgt.plan.programa.progClave,
            curEstadoUltCurso: datos.ultimoCurso.curEstado,
            // perTitulacion: datos.egresado.egrPeriodoTitulacion,
            fechaExamenProf: datos.egresado.egrFechaExamenProfesional,
            fechaExpedicionTitulo: datos.egresado.egrFechaExpedicionTitulo,
            opcionTitulo: datos.egresado.egrOpcionTitulo,
            modoTitulacionSegey: datos.egresado.egrModoTituloSegey,
            tipoBeca: datos.egresado.egrTipoBecaSegey,
            tipoDesempenio: datos.egresado.egrTipoDesempenioSegey,
            desempenioProm: datos.egresado.egrDesempenioSegey
        }

        var periodosSelects = {
          perProceso: datos.egresado.periodo_id,
          perIngreso: datos.egresado.egrPrimerPeriodo,
          perEgreso: datos.egresado.egrUltimoPeriodo,
          // perUltCurso: datos.ultimoCurso.periodo_id,
          perTitulacion: datos.egresado.egrPeriodoTitulacion,
      }

        buscarPeriodos(ubiClave, depClave, selectItems, periodosSelects);
        fillFormElements(fillableForm);
        disableElements(fillableForm);

        var perUltCurso = $('#perUltCurso').val();
        if(!perUltCurso) {
          var ultCurso_perNumAnio = datos.ultimoCurso.periodo.perNumero+'-'+datos.ultimoCurso.periodo.perAnio
                +' ('+datos.ultimoCurso.periodo.departamento.depClave+')';
          var option = new Option(ultCurso_perNumAnio, datos.ultimoCurso.periodo.id);
          $('#perUltCurso').append(option);
          $('#perUltCurso').val(datos.ultimoCurso.periodo_id);
        }


    });
@include('scripts.egresados')
</script>


@endsection