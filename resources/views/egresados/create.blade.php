@extends('layouts.dashboard')

@section('template_title')
    Registro Manual
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Registro Manual de Egresado</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'egresados.store', 'method' => 'POST', 'target' => '_blank']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">REGISTRO MANUAL DE EGRESADO</span>
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
                <br>
                <div class="input-field col s12 m6 14">
                  {!! Form::number('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate','min'=>'0','required')) !!}
                  {!! Form::label('aluClave', 'Clave de pago', array('class' => '')); !!}
                </div>
                <div class="input-field col s12 m6 14">
                  <a name="buscarAlumno" id="buscarAlumno" class="waves-effect btn-large tooltipped" data-position="right" data-tooltip="Buscar alumno por su clave">
                    <i class=material-icons>search</i>
                  </a>
                </div>
              </div>
              <div class="col s12 m6 l4">
                <br>
                <div class="input-field col s12 m6 14">
                  <p style="text-align:center;">Ubicación</p>
                  <select name="ubiClave" id="ubiClave" class="browser-default validate select2" style="width:100%;" required>
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
        <div class="card-action">
          {!! Form::button('<i class="material-icons left">school</i> REGISTRAR', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection


@section('footer_scripts')

<script type="text/javascript">
  $(document).ready(function(){

    $('#seccionTitulacion').css('display','none');

    $('#buscarAlumno').on('click',function(){
      var aluClave = $('#aluClave').val();
      var progClave = $('#progClave').val();
      var planClave = $('#planClave').val();
      var ubiClave = $('#ubiClave').val();
      var depClave = $('#depClave').val();

      if(aluClave && progClave && planClave && ubiClave && depClave){
        $.ajax({
          processing : 'true',
          serverSide : 'true',
          url : base_url+'/egresados/buscar_alumno/' + aluClave,
          method : 'POST',
          data : {
            aluClave : aluClave,
            progClave : progClave,
            planClave : planClave,
            "_token":"{{csrf_token()}}"},
          dataType : "json",
          success : function(data){
            console.log(data);

            var alumno = data['alumno'];
            var persona = data['persona'];
            var resumen = data['resumen'];
            var departamento = data['departamento'];
            var ubicacion = data['ubicacion'];
            var plan = data['plan'];
            var programa = data['programa'];
            var egresado = data['egresado'];
            var ultimoCurso = data['ultimoCurso'];
            var mesPago = data['mesPago'];
            var anioPago = data['anioPago'];


            $('#perApellido1').val(persona.perApellido1);
            Materialize.updateTextFields();
            $('#perApellido2').val(persona.perApellido2);
            Materialize.updateTextFields();
            $('#perNombre').val(persona.perNombre);
            Materialize.updateTextFields();
            $('#perSexo').val(persona.perSexo);
            Materialize.updateTextFields();
            $('#progClave').val(programa.progClave);
            Materialize.updateTextFields();
            $('#planClave').val(plan.planClave);
            Materialize.updateTextFields();
            $('#totalCreditosPlan').val(plan.planNumCreditos);
            $('#totalCreditosAprobados').val(resumen.resCreditosAprobados);
            $('#perIngreso').val(resumen.resPeriodoIngreso).trigger('change');
            if(egresado && egresado.periodo_id){
              $('#perProceso').val(egresado.periodo_id).trigger('change');
            }
            if(resumen.resPeriodoUltimo){
              $('#perEgreso').val(resumen.resPeriodoUltimo).trigger('change');
            }
            if(ultimoCurso){
              $('#ultMesPago').val(mesPago).trigger('change');
              $('#ultAnioPago').val(anioPago).trigger('change');
              $('#perUltCurso').val(ultimoCurso.periodo_id).trigger('change');
              $('#cgtGradoSemestre').val(ultimoCurso.cgt.cgtGradoSemestre);
              Materialize.updateTextFields();
              $('#cgtGrupo').val(ultimoCurso.cgt.cgtGrupo);
              Materialize.updateTextFields();
              $('#progClaveUltCurso').val(ultimoCurso.cgt.plan.programa.progClave);
              Materialize.updateTextFields();
              $('#curEstadoUltCurso').val(ultimoCurso.curEstado);
              Materialize.updateTextFields();
            }

            $('#aluMatricula').val(alumno.aluMatricula);
            Materialize.updateTextFields();
            $('#claveSegey').val(programa.progClaveEgre);
            Materialize.updateTextFields();

            if(egresado){
              if(egresado.egrPeriodoTitulacion){
                $('#perTitulacion').val(egresado.egrPeriodoTitulacion).trigger('change');
              }
              if(egresado.egrFechaExamenProfesional){
                $('#fechaExamenProf').val(egresado.egrFechaExamenProfesional);
                Materialize.updateTextFields();
              }
              if(egresado.egrFechaExpedicionTitulo){
                $('#fechaExpedicionTitulo').val(egresado.egrFechaExpedicionTitulo);
              }
              if(egresado.egrOpcionTitulo){
                $('#opcionTitulo').val(egresado.egrOpcionTitulo).trigger('change');
              }
              if(egresado.egrModoTituloSegey){
                $('#modoTitulacionSegey').val(egresado.egrModoTituloSegey).trigger('change');
              } 
              if(egresado.egrTipoBecaSegey){
                $('#tipoBeca').val(egresado.egrTipoBecaSegey).trigger('change');
              }
              if(egresado.egrTipoDesempenioSegey){
                $('#tipoDesempenio').val(egresado.egrTipoDesempenioSegey).trigger('change');
              }
              if(egresado.egrDesempenioSegey){
                $('#desempenioProm').val(egresado.egrDesempenioSegey);
                Materialize.updateTextFields();
              }
            }

          }, error : function(){
            swal("No se encontraron registros con la información proporcionada."+
              "\n Favor de verificar.");
          }
        });
      }else{
        if(!progClave || !planClave || !aluClave || !ubiClave || !depClave){
          swal("Se requieren 5 campos para buscar alumno: \n"+
            "\n - Clave de alumno."+
            "\n - Ubicacion."+
            "\n - Departamento"+
            "\n - Programa."+
            "\n - Plan."+
            "\n \n Favor de Proporciona estos datos.");
        }
      }
    });

    /*
    * Mientras ubiClave tenga valor, se activa el select depClave.
    */
    $('#ubiClave').on('change',function(){
      var ubiClave = $(this).val();
      var depClave = null;

      if(ubiClave){
        $('#depClave').attr('disabled',false);
        depClave = $('#depClave').val();
        buscarPeriodos(ubiClave,depClave);
      }else{
        depClave = $('#depClave').val();
        $('#depClave').val('');
        $('#depClave').attr('disabled',true);
        $('#depClave').trigger('change');
      }



    });

    /*
    * Mientras depClave tenga valor, los selects de periodos estarán activados
    */
    $('#depClave').on('change',function(){
      var depClave = $(this).val();
      var ubiClave = $('#ubiClave').val();

      buscarPeriodos(ubiClave,depClave);

    });
    /*
    * Busca los periodos y los agrega a los select.
    * debe tener ambos parámetros para ejecutarse.
    */
    function buscarPeriodos(ubiClave,depClave){
      if(ubiClave && depClave){ //if_ubi_dep.
        $.ajax({
          processing : 'true',
          serverSide : 'true',
          url : base_url+"/departamento/periodos/"+ubiClave+"/"+depClave,
          method : "POST",
          data : {"ubiClave":ubiClave,"depClave":depClave,"_token":"{{csrf_token()}}"},
          dataType:"json",
          success:function(data){
            console.log(data);
            var periodos = data['periodos'];

            $('#perProceso').empty().attr('disabled',false)
                    .append(new Option('Seleccionar...',''));
            $('#perIngreso').empty().attr('disabled',false)
                    .append(new Option('Seleccionar...',''));
            $('#perEgreso').empty().attr('disabled',false)
                    .append(new Option('Seleccionar...',''));
            $('#perUltCurso').empty().attr('disabled',false)
                    .append(new Option('Seleccionar...',''));
            $('#perTitulacion').empty().attr('disabled',false)
                    .append(new Option('Seleccionar...',''));

            $.each(periodos,function(key,value){
              var perNumAnio = value.perNumero+'-'+value.perAnio;

              $('#perProceso').append('<option value="' +value.id+ '">' +perNumAnio+ '</option>');
              $('#perIngreso').append('<option value="' +value.id+ '">' +perNumAnio+ '</option>');
              $('#perEgreso').append('<option value="' +value.id+ '">' +perNumAnio+ '</option>');
              $('#perUltCurso').append('<option value="' +value.id+ '">' +perNumAnio+ '</option>');
              $('#perTitulacion').append('<option value="' +value.id+ '">' +perNumAnio+ '</option>');

            });

          },error: function(){
            console.log('nada');
          }

        });

      }else{
        $('#perProceso').empty().attr('disabled',true);
        $('#perIngreso').empty().attr('disabled',true);
        $('#perEgreso').empty().attr('disabled',true);
        $('#perUltCurso').empty().attr('disabled',true);
        $('#perTitulacion').empty().attr('disabled',true);
      }//if_ubi_dep.
    }//function buscarPeriodos.

  });
</script>

@endsection