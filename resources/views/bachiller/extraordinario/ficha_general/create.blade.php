@extends('layouts.dashboard')

@section('template_title')
    Bachiller referencia de pago recuperativo
@endsection

@section('head')
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('solicitudes/bachiller_recuperativos')}}" class="breadcrumb">Lista de solicitudes</a>
    <a href="{{url('bachiller_solicitud/pagos/ficha_general')}}" class="breadcrumb">Referencia de pago</a>
@endsection

@section('content')
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_recuperativos.storePagoExtra', 'method' => 'POST',  "target" => "_blank"]) !!}
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
                <input id="elPerAnioPago" name="elPerAnioPago" value="" type="hidden" />
                <div class="col s12 l3">
                    {!! Form::label('cuoFecha', 'Fecha del día de hoy *', ['class' => '']); !!}
                    <input id="cuoFecha" name="cuoFecha" class="validate" type="date" required value="<?= date("Y-m-d"); ?>">
                </div>
                <div class="col s12 l2">
                    <div class="input-field">
                    {!! Form::text('aluClave', NULL, array('id' => 'aluClave', 'class' => 'validate')) !!}
                    {!! Form::label('aluClave', 'Clave de alumno *', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 l2">
                    <div class="input-field">
                    {!! Form::number('cuoAnio', NULL, array('id' => 'cuoAnio', 'class' => 'validate','maxLength' => '4','required')) !!}
                    {!! Form::label('cuoAnio', 'Año de inicio de curso *', ['class' => '']); !!}
                    </div>
                </div>

                <div class="col s12 l2">
                    <div class="input-field">
                    {!! Form::number('perNumero2', NULL, array('id' => 'perNumero2', 'class' => 'validate','maxLength' => '1','required')) !!}
                    {!! Form::label('perNumero2', 'Período *', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 l3">
                    {!! Form::button('<i class="material-icons left">search</i> Buscar', ['id'=>'buscarAlumno','class' => 'btn-large waves-effect  darken-3']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('ubiNombre', NULL, array('id' => 'ubiNombre', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('ubiNombre', 'Ubicación (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('perNumero', 'Periodo (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="input-field">
                    {!! Form::text('aluNombre', NULL, array('id' => 'aluNombre', 'class' => 'validate','readonly')) !!}
                    {!! Form::label('aluNombre', 'Nombre de alumno (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>


            <div class="row" id="Tabla">
                    <div class="col s12">
                        <table class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    {{--  <th style="display: none;" class="">ID</th>  --}}
                                    <th class="">FOLIO</th>
                                    <th scope="col">PERIODO</th>
                                    <th class="">CLAVE MATERIA</th>
                                    <th scope="col">MATERIA <p></p></th>
                                    <th scope="col">PAGO</th>
                                    <th scope="col">SELECCIONE</p></th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                            </tbody>
                        </table>
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
                    {!! Form::text('nomConcepto', NULL, array('id' => 'nomConcepto', 'class' => 'validate','readonly', 'required')) !!}
                    {!! Form::label('nomConcepto', 'Nombre de concepto (solo lectura)', ['class' => '']); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l3">
                    <div class="input-field">
                    {!! Form::text('importeNormal', 0, array('id' => 'importeNormal', 'class' => 'validate','required')) !!}
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
        {!! Form::button('<i class="material-icons left">save</i> Generar', ['class' => 'btn-large waves-effect btn-generar-ficha darken-3','type' => 'submit']) !!}
        </div>
    </div>
    {!! Form::close() !!}


    <style>
        table tbody tr:nth-child(odd) {
            background: #F7F8F9;
        }
        table tbody tr:nth-child(even) {
            background: #F1F1F1;
        }
        table th {
          background: #01579B;
          color: #fff;

        }
        table {
          border-collapse: collapse;
          width: 100%;
        }
    </style>
@endsection

@section('footer_scripts')

<script type="text/javascript">

    if($("#nomConcepto").val() == ""){
        $(".btn-generar-ficha").hide();
    }else{
        $(".btn-generar-ficha").show();
    }

   $(document).on('click', '#buscarAlumno', function (e) {

       var aluClave = $('#aluClave').val();
       var cuoAnio = $('#cuoAnio').val();
       var perNumero2 = $('#perNumero2').val();

       $("#tableBody").html("");
       $("#importeNormal").val(0);



        $.get(base_url+`/bachiller_extraordinario/api/curso/alumno/${aluClave}/${cuoAnio}`, function(res,sta) {
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
                //$('#perNumero2').val(res.cgt.periodo.perNumero)
                Materialize.updateTextFields();


                var perAnioPago = res.cgt.periodo.perAnio;
                var clave_pago = res.alumno.aluClave;
                $('#elPerAnioPago').val(res.cgt.periodo.perAnioPago);
                if(perNumero2 == ""){
                    swal("Upss", "No se ha cargado la lista de los recuperativos donde el alumno se encuentra inscrito. Por favor ingrese el período que desea encontrar", "info");

                }else{
                    $.get(base_url+`/bachiller_recuperativos/getDebeRecuperativos/${clave_pago}/${perAnioPago}/${perNumero2}`, function(ress,sta) {

                        console.log(ress)
                        //Creamos tabla cuando haya evidencias capturadas
                        if(ress.length > 0){

                            $("#Tabla").show();

                            const cuerpoTabla = document.querySelector("#tableBody");

                            ress.forEach(function (element, i) {


                                // Crear un <tr>
                                const tr = document.createElement("tr");


                                // Creamos el <td> de nombre y lo adjuntamos a tr


                                /*let id = document.createElement("td");
                                id.textContent = `${element.id}`;
                                tr.appendChild(id);*/


                                let extraordinario_id = document.createElement("td");
                                extraordinario_id.textContent = `${element.extraordinario_id}`;
                                tr.appendChild(extraordinario_id);//

                                let perNumero = document.createElement("td");
                                perNumero.textContent = `${element.perNumero}`;
                                tr.appendChild(perNumero);//

                                let matClave = document.createElement("td");
                                matClave.textContent = `${element.matClave}`;
                                tr.appendChild(matClave);//

                                if(element.matNombre != null){
                                    let matNombre = document.createElement("td");
                                    matNombre.textContent = `${element.matNombre}`;
                                    tr.appendChild(matNombre);//
                                }else{
                                    let matNombre = document.createElement("td");
                                    matNombre.textContent = ``;
                                    tr.appendChild(matNombre);//
                                }



                                let extPago = document.createElement("td");
                                extPago.textContent = `${element.extPago}`;
                                tr.appendChild(extPago);//


                                let checked = document.createElement("td");
                                checked.innerHTML = `<input type='checkbox' value='${element.extPago}' name='costo[${element.id}]' id='${element.id}'><label for='${element.id}'></label>`;
                                tr.appendChild(checked);//



                                // Finalmente agregamos el <tr> al cuerpo de la tabla
                                cuerpoTabla.appendChild(tr);
                                // Y el ciclo se repite hasta que se termina de recorrer todo el arreglo




                                //Ocultamos columnas
                                $(".ocultar").hide();



                            });

                        }else{
                            $("#Tabla").hide();
                            $("#tableBody").html("");

                            swal("Upss", "El alumno que esta buscando no se encuenta registrado en ningun curso recuperativo", "info");

                            $(".btn-generar-ficha").hide();


                        }
                    });
                }


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

        $(".btn-generar-ficha").show();
      });

    });


    $(document).on('change','input[type="checkbox"]' ,function(e) {
        var importeNormal = $("#importeNormal").val();

            if(this.checked) $("#importeNormal").val(parseFloat(importeNormal) + parseFloat(this.value));
            else $("#importeNormal").val(parseFloat(importeNormal) - parseFloat(this.value));

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
                    //$("#importeNormal").val(importe);
                    $('#importeNormal').prop('readonly', true);
                    $('#cuoFechaVenc').prop('readonly', false);
                    Materialize.updateTextFields();
                }

            });
        }else{

            $('#eliminarClass').addClass("input-field");
            $('#importeNormal').prop('readonly', true);
            // $("#importeNormal").val("");

            $('#cuoFechaVenc').prop('readonly', false);
            $("#cuoFechaVenc").val("");

        }
    });

</script>
@endsection
