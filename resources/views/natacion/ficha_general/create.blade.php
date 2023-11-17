@extends('layouts.dashboard')

@section('template_title')
    Referencia de pago
@endsection

@section('head')
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('natacion_ficha_pago')}}" class="breadcrumb">Referencia de pago</a>
@endsection

@section('content')
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'natacion.storeFichaGeneral', 'method' => 'POST',  "target" => "_blank"]) !!}
    <div class="card ">
        <div class="card-content ">
        <span class="card-title">GENERAR REFERENCIA DE PAGO</span>

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
                <input id="curso_id" name="curso_id" value="" type="hidden" />
                <input id="cursoAlumno" name="cursoAlumno" value="" type="hidden" />
                <div class="col s12 l3">
                    {!! Form::label('cuoFecha', 'Fecha del día de hoy *', ['class' => '']); !!}
                    <input id="cuoFecha" name="cuoFecha" class="validate" type="date" required value="<?= date("Y-m-d"); ?>" readonly>
                </div>
                <div class="col s12 l3">
                    <div class="input-field">
                    {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                    {!! Form::label('aluClave', 'Clave de alumno *', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 l3">
                    <div class="input-field">
                    {!! Form::number('cuoAnio', NULL, array('id' => 'cuoAnio', 'class' => 'validate','maxLength' => '4','required')) !!}
                    {!! Form::label('cuoAnio', 'Año de inicio de curso *', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 l3">
                    {!! Form::button('<i class="material-icons left">search</i> Buscar', ['id'=>'buscarAlumno','class' => 'btn-large waves-effect  darken-3']) !!}
                </div>
            </div>
            <div>
                <div class="col s12">
                    <div class="input-field">
                    {!! Form::text('aluNombre', NULL, array('id' => 'aluNombre', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('aluNombre', 'Nombre de alumno (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col s12 m6 l3">

                    {!! Form::label('cuoConcepto', 'Concepto *', ['class' => '']); !!}
                    <select id="cuoConcepto" class="browser-default validate select2" required name="cuoConcepto" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        @foreach($conceptosPago as $concepto)
                            <option value="{{$concepto->conpClave}}">{{$concepto->conpClave}} {{$concepto->conpNombre}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col s12 l3">
                    {!! Form::button('<i class="material-icons left">search</i> Buscar', ['id'=>'buscarConcepto','class' => 'btn-large waves-effect  darken-3']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <div class="input-field">
                    {!! Form::text('nomConcepto', NULL, array('id' => 'nomConcepto', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('nomConcepto', 'Nombre de concepto (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l3">
                    <div class="input-field">
                    {!! Form::text('importeNormal', NULL, array('id' => 'importeNormal', 'class' => 'validate','required')) !!}
                    {!! Form::label('importeNormal', 'Importe pago normal *', ['class' => '']); !!}
                    </div>
                </div>

                <div class="col s12 l3">
                    {!! Form::label('cuoFechaVenc', 'Fecha de vencimiento (opcional)', ['class' => '']); !!}
                    <input id="cuoFechaVenc" name="cuoFechaVenc" class="validate" type="date" value="">
                </div>


            </div>

            <div class="row">
                <div class="col s12 m6 l3">
                    {!! Form::label('banco', 'Banco *', array('class' => 'required')); !!}
                    <select id="banco" class="browser-default validate select2" name="banco" style="width: 100%;">
                        <option value="BBVA">BBVA</option>
                        <option value="HSBC">HSBC</option>
                    </select>
                </div>

                {{--
                <div class="col s12 m6 l3">

                    {!! Form::label('conReferenciaPago', 'Referencia Ubicación de Pago (HSBC) *', ['class' => 'required']); !!}
                    <select id="conReferenciaPago" class="browser-default validate select2" required name="conReferenciaPago" style="width: 100%;">
                        @foreach($conceptosReferencia as $conceptoR)
                            <option value="{{$conceptoR->conpRefClave}}">{{$conceptoR->conpRefClave}} - {{$conceptoR->ubiClave}} {{$conceptoR->depClave}} {{$conceptoR->conpNombre}}</option>
                        @endforeach
                    </select>

                </div>
                --}}
            </div>


        </div>

        </div>
        <div class="card-action">
        {!! Form::button('<i class="material-icons left">save</i> Generar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('footer_scripts')
<script type="text/javascript">

   $(document).on('click', '#buscarAlumno', function (e) {
       var aluClave = $('#aluClave').val();
       var cuoAnio = $('#cuoAnio').val();
        $.get(base_url+`/natacion_ficha_pago/getCursoAlumno/${aluClave}/${cuoAnio}`, function(res,sta) {
            if(jQuery.isEmptyObject(res)){
                swal({
                    title: "Ups...",
                    text: "No se encontro el alumno",
                    type: "warning",
                    confirmButtonText: "Ok",
                    confirmButtonColor: '#3085d6',
                    showCancelButton: false
                });
            }else{

                $("#cursoAlumno").val(JSON.stringify(res))

                $('#curso_id').val(res.id);
                $('#ubiNombre').val(res.cgt.periodo.departamento.ubicacion.ubiNombre);
                $('#perNumero').val(res.cgt.cgtGradoSemestre + ' DE ' + res.cgt.plan.programa.progNombre);
                $('#aluNombre').val(res.alumno.persona.perNombre + ' ' + res.alumno.persona.perApellido1 + ' ' + res.alumno.persona.perApellido2);
                Materialize.updateTextFields();
            }
        });
    });


    $(document).on('click', '#buscarConcepto', function (e) {
      var cuoConcepto = $('#cuoConcepto').val();

      $.get(base_url + `/pagos/ficha_general/obtenerCuotaConcepto/${cuoConcepto}`, function(res, sta) {
        var concepto = JSON.parse(res)


        var cursoAlumno = $("#cursoAlumno").val()
        cursoAlumno = JSON.parse(cursoAlumno)


        var perAnioPago = cursoAlumno.cgt.periodo.perAnioPago;
        if (parseInt(concepto.conpClave) >= 5 && cuoConcepto != 99) {
            perAnioPago = parseInt(cursoAlumno.cgt.periodo.perAnioPago) + 1;
        }

        if ([1,2,3,4].includes(parseInt(concepto.conpClave))) {
            perAnioPago = cursoAlumno.cgt.periodo.perAnioPago
        }


        if (!(cuoConcepto >= 1 && cuoConcepto <= 12)) {
            perAnioPago = ""
        }



        if (jQuery.isEmptyObject(concepto)) {
          swal({
              title: "Ups...",
              text: "No se encontro el concepto",
              type: "warning",
              confirmButtonText: "Ok",
              confirmButtonColor: '#3085d6',
              showCancelButton: false
          });
          return;
        }

        $("#nomConcepto").val(concepto.conpNombre + " " + perAnioPago)
        Materialize.updateTextFields();
      });
 
    });

</script>
<script type="text/javascript">

    $("#cuoConcepto").change(function(){
        if($('select[id=cuoConcepto]').val() == "40"){

            var aluClave2 = $("#aluClave").val();
            var cuoAnio2 = $("#cuoAnio").val();

            $.get(base_url + `/pagos/ficha_general/obtenerAnualidadImporte/${aluClave2}/${cuoAnio2}`, function(result, sta) {
                var importe = result;       

                if(importe == "-1" || importe == "0"){
                    swal("Escuela Modelo", " No se puede cobrar anualidad porque ya tiene pagos cargados o es un deudor", "info");
                }else{
                    $("#importeNormal").val(importe);
                    $('#importeNormal').prop('readonly', true);
                    $('#cuoFechaVenc').prop('readonly', false);
                    Materialize.updateTextFields();
                }       

            });
        }else{
            
            $('#eliminarClass').addClass("input-field");
            $('#importeNormal').prop('readonly', false);
            $("#importeNormal").val("");

            $('#cuoFechaVenc').prop('readonly', false);
            $("#cuoFechaVenc").val("");

        }
    });

</script>
@endsection
