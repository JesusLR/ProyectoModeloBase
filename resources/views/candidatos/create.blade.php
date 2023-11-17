@extends('layouts.dashboard')

@section('template_title')
    Candidato
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('candidatos_primer_ingreso')}}" class="breadcrumb">Lista de candidatos</a>
    <a href="{{url('candidatos_primer_ingreso/create')}}" class="breadcrumb">Agregar candidato</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['enctype' => 'multipart/form-data', 'onKeypress' => 'return disableEnterKey(event)','route' => 'candidatos_primer_ingreso.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CANDIDATO</span>


            {{-- GENERAL BAR--}}
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perNombre', NULL, array('id' => 'perNombre', 'class' => 'validate','required','maxlength'=>'40')) !!}
                    {!! Form::label('perNombre', 'Nombre(s) *', array('class' => '')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perApellido1', NULL, array('id' => 'perApellido1', 'class' => 'validate','required','maxlength'=>'30')) !!}
                    {!! Form::label('perApellido1', 'Primer apellido *', array('class' => '')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perApellido2', NULL, array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30'))!!}
                    {!! Form::label('perApellido2', 'Segundo apellido', array('class' => '')); !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m4 l4">
                    <div class="input-field">
                        {!! Form::text('perCurp', NULL, array('id' => 'perCurp', 'class' => 'validate', 'required')) !!}
                        {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                        {!! Form::label('perCurp', 'Curp *', array('class' => '')); !!}
                    </div>
                    <a style="display:inline-block; FLOAT" class="waves-effect waves-light btn" href="https://www.gob.mx/curp/" target="_blank">
                        Verifica la curp
                    </a>
                </div>
                <div class="col s12 m6 l6">
                    <div class="custom-control custom-checkbox" style="margin-top: 30px;">
                        <input type="checkbox" class="custom-control-input" value="true" name="noSoyMexicano" id="noSoyMexicano">
                        <label class="custom-control-label" for="noSoyMexicano">No soy mexicano</label>
                    </div>
                </div>

            </div>

            <div class="row">


                {{-- <div class="col s12 m6 l4"> --}}
                    {{-- {!! Form::label('aluNivelIngr', 'Nivel de ingreso *', array('class' => '')); !!}
                    <select id="aluNivelIngr" class="browser-default validate select2" required name="aluNivelIngr" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{$departamento->id}}">
                                {{$departamento->depClave}} -
                                @if ($departamento->depClave == "SUP") Superior @endif
                                @if ($departamento->depClave == "POS") Posgrado @endif
                            </option>
                        @endforeach
                    </select> --}}
                    {{-- <div class="input-field col s12 m6 l6">
                        {!! Form::number('aluGradoIngr', NULL, array('id' => 'aluGradoIngr', 'class' => 'validate','required','min'=>'0','max'=>'9999','onKeyPress="if(this.value.length==4) return false;"')) !!}
                        {!! Form::label('aluGradoIngr', 'Grado Ingreso *', array('class' => '')); !!}
                    </div> --}}
                {{-- </div> --}}
                <div class="col s12 m6 l4">
                    {{-- COLUMNA --}}
                    {!! Form::label('perSexo', 'Sexo *', array('class' => '')); !!}
                    <select id="perSexo" class="browser-default validate select2" required name="perSexo" style="width: 100%;">
                        <option value="M" {{old("perSexo") == "M" ? "selected": ""}}>HOMBRE</option>
                        <option value="F" {{old("perSexo") == "F" ? "selected": ""}}>MUJER</option>
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('perFechaNac', 'Fecha de nacimiento *', array('class' => '')); !!}
                    {!! Form::date('perFechaNac', NULL, array('id' => 'perFechaNac', 'class' => ' validate','required', "style" => "margin-top: -10px;")) !!}
                </div>
            </div>

            <br>
            <div class="row" style="background-color:#ECECEC;">
                <p style="text-align: center;font-size:1.2em;">Lugar de Nacimiento</p>
            </div>

            <div class="row">
                <div class="col s12 m6 l4">
                    {!! Form::label('paisId', 'País *', array('class' => '')); !!}
                    <select id="paisId"
                        data-paisId-old="{{old('paisId')}}"
                        class="browser-default validate select2" required name="paisId" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        @foreach($paises as $pais)
                            @php
                                $selected = '';
                                if ($pais->id == old("paisId")) {
                                    $selected = 'selected';
                                }
                            @endphp

                            <option value="{{$pais->id}}" {{$selected}}>{{$pais->paisNombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('estado_id', 'Estado *', array('class' => '')); !!}
                    <select id="estado_id"
                        data-estado-idold="{{old('estado_id')}}"
                        class="browser-default validate select2" required name="estado_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('municipio_id', 'Municipio *', array('class' => '')); !!}
                    <select id="municipio_id"
                        data-municipio-idold="{{old('municipio_id')}}"
                        class="browser-default validate select2" required name="municipio_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
            </div>



            <br>
            <div class="row" style="background-color:#ECECEC;">
                <p style="text-align: center;font-size:1.2em;">Datos de Contacto</p>
            </div>

            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::number('perTelefono1', NULL, array('id' => 'perTelefono1', 'class' => 'validate','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"', 'required')) !!}
                    {!! Form::label('perTelefono1', 'Teléfono *', array('class' => '')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::email('perCorreo1', NULL, ['id' => 'perCorreo1', 'class' => 'validate', 'maxlength' => '60', 'required']) !!}
                    {!! Form::label('perCorreo1', 'Correo *', ['class' => '', ]) !!}
                    </div>
                </div>

                {{-- <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('perDirColonia', NULL, array('id' => 'perDirColonia', 'class' => 'validate','maxlength'=>'60', 'required')) !!}
                        {!! Form::label('perDirColonia', 'Colonia *', array('class' => '')); !!}
                    </div>
                </div> --}}
            </div>

            <br>
            {{-- <div class="row" style="background-color:#ECECEC;">
                <p style="text-align: center;font-size:1.2em;">Domicilio</p>
            </div>

            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perDirCalle', NULL, array('id' => 'perDirCalle', 'class' => 'validate','required','maxlength'=>'25')) !!}
                    {!! Form::label('perDirCalle', 'Calle *', array('class' => '')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perDirNumExt', NULL, array('id' => 'perDirNumExt', 'class' => 'validate','required','maxlength'=>'6')) !!}
                    {!! Form::label('perDirNumExt', 'Número exterior *', array('class' => '')); !!}
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="input-field">
                    {!! Form::text('perDirNumInt', NULL, array('id' => 'perDirNumInt', 'class' => 'validate','maxlength'=>'6')) !!}
                    {!! Form::label('perDirNumInt', 'Número interior', array('class' => '')); !!}
                    </div>
                </div>
            </div> --}}

            {{-- <div class="row">

                <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::number('perDirCP', NULL, array('id' => 'perDirCP', 'class' => 'validate','required','min'=>'0','max'=>'99999','onKeyPress="if(this.value.length==5) return false;"')) !!}
                        {!! Form::label('perDirCP', 'Código Postal *', array('class' => '')); !!}
                    </div>
                </div>

            </div> --}}


            <br>
            <div class="row" style="background-color:#ECECEC;">
                <p style="text-align: center;font-size:1.2em;">Preparatoria de procedencia</p>
            </div>

            <div class="row">
                <div class="col s12 m6 l4">
                    {!! Form::label('paisPrepaId', 'País preparatoria', array('class' => '')); !!}
                    <select id="paisPrepaId"
                        data-paisPrepaId-old="{{old('paisPrepaId')}}"
                        class="browser-default validate select2" name="paisPrepaId" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        @foreach($paises as $pais)
                            @php
                                $selected = '';
                                if ($pais->id == old("paisPrepaId")) {
                                    $selected = 'selected';
                                }
                            @endphp

                            <option value="{{$pais->id}}" {{$selected}}>{{$pais->paisNombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('estado_prepa_id', 'Estado preparatoria', array('class' => '')); !!}
                    <select id="estado_prepa_id"
                        data-estadoPrepa-idold="{{old('estado_prepa_id')}}"
                        class="browser-default validate select2" name="estado_prepa_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('municipio_prepa_id', 'Municipio preparatoria', array('class' => '')); !!}
                    <select id="municipio_prepa_id"
                        data-municipioPrepa-idold="{{old('municipio_prepa_id')}}"
                        class="browser-default validate select2" name="municipio_prepa_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>

            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    {!! Form::label('preparatoria_id', 'Preparatoria de procedencia', array('class' => '')); !!}
                    <select id="preparatoria_id"
                        data-preparatoria-idold="{{old('preparatoria_id')}}"
                        class="browser-default validate select2"  name="preparatoria_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                </div>

                <div class="col s12 m6 l4">
                    <div class="col s12 m12 l12">
                        <div class="custom-control custom-checkbox" style="margin-top:25px;">
                            <input type="checkbox" class="custom-control-input" value="true" name="noEncuentraPrepa" id="noEncuentraPrepa">
                            <label class="custom-control-label" for="noEncuentraPrepa">No encuentro mi prepa de preferencia</label>
                          </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4">
                    <div class="input-field">
                        <input id="curExani" class="validate"  min="900" max="1300" name="curExani" type="number"
                            value="{{old('curExani')}}"
                               oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "4"/>
                        <label for="curExani" class="">Resultado Calificaci&oacute;n Exani</label>
                        {{--
                        {!! Form::number('curExani', NULL, array('id' => 'curExani', 'class' => 'validate','', 'min' => '950', 'max' => '1300')) !!}
                        {!! Form::label('curExani', 'Resultado Calificación Exani', ['class' => '']); !!}
                        --}}
                    </div>
                </div>


                <div class="col s12 m6 l8">
                    <div class="file-field input-field">
                        <div class="btn">
                          <span>Foto exani</span>
                          <input value="" type="file" name="image">
                        </div>
                        <div class="file-path-wrapper">
                          <input class="file-path validate"  type="text">
                        </div>
                    </div>
                </div>
            </div>





            <br>
            <div class="row" style="background-color:#ECECEC;">
                <p style="text-align: center;font-size:1.2em;">Carreras</p>
            </div>

            <div class="row">
                <div class="col s12 m12 12">
                  <p style="font-weight: bold;">¿CUÁL ES LA CARRERA DE SU PREFERENCIA?</p>
                </div>
                <div class="col s12 m6 l4">
                    {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                    <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                        <option value="" selected >SELECCIONE UNA OPCIÓN</option>
                        @foreach($ubicaciones as $ubicacion)
                            @php
                                $selected = '';
                                if (old("ubicacion_id") == $ubicacion->id) {
                                    $selected = "selected";
                                }

                                if ($ubicacion->id == 1) {
                                  echo '<option '.$selected.' value="'.$ubicacion->id.'">'.$ubicacion->ubiNombre.'</option>';
                                }
                            @endphp
                        @endforeach
                    </select>
                </div>
                <div class="col s12 m6 l8">
                  {!! Form::label('programa_id', 'Carrera *', array('class' => '')); !!}
                  <select id="programa_id"
                    data-programa-idold="{{old("programa_id")}}"
                      class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                      <option value="" selected >SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
            </div>


            <div class="row">
                <div class="col s12 m6 l6">
                    <div class="input-field">
                        {!! Form::text('passwordEscuela', NULL, array('id' => 'passwordEscuela', 'class' => 'validate','required','maxlength'=>'15')) !!}
                        {!! Form::label('passwordEscuela', 'Contraseña proporcionada por la escuela *', array('class' => '')); !!}
                    </div>
                </div>

            </div>

            {{-- TUTORES BAR --}}

          </div>
          <input type="hidden" name="empleado_id" id="empleado_id" value="">
          <div class="card-action">
            <p>
                <a href="http://www.unimodelo.edu.mx/aviso-de-privacidad" style="text-transform: lowercase;">
                    <span style="text-transform: capitalize;">aviso</span> de <span style="text-transform: capitalize;">privacidad</span>
                </a>
            </p>

            <button type="submit" class="btn btn-success">
                <i class=" material-icons left validar-campos">save</i> Guardar
            </button>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}
  {{-- funciones de módulos CRUD --}}
  {!! HTML::script(asset('js/alumnos/crud-alumnos.js'), array('type' => 'text/javascript')) !!}
  {{-- Funciones para Modelo Persona --}}
  {!! HTML::script(asset('js/personas/personas.js'), array('type' => 'text/javascript'))!!}
  {{-- {!! HTML::script(asset('js/lodash.core.min.js'), array('type' => 'text/javascript')) !!} --}}

@endsection



@section('footer_scripts')
{{-- @include('scripts.departamentos') --}}



    <script type="text/javascript">

        // $(document).on("click", ".btn-guardar", function(e) {
        //     $(this).submit()
        // })



        function validarNoSoyMexicano() {
            if ($("#noSoyMexicano").is(':checked')) {
                $("#perCurp").removeAttr('required');
                $("#perCurp").attr('disabled', true);
                $("#perCurp").removeClass('invalid');
                $("#perCurp").removeClass('valid');
                $("#perCurp").val("");
                if ($('#paisId').val()) {
                    $('#paisId').val(0).select2();
                    resetSelect('estado_id');
                    resetSelect('municipio_id');
                }
                
                $('#paisId option[value="1"]').attr('disabled', true).select2();

                $('#paisId').trigger('change'); // Notify only Select2 of changes


                Materialize.updateTextFields();
            } else {
                $("#perCurp").attr('required', true);
                $("#perCurp").removeAttr('disabled');

                $('#paisId option[value="1"]').removeAttr('disabled').select2();

            }
        }

        validarNoSoyMexicano()
        $(document).on("click", "#noSoyMexicano", function (e) {
            validarNoSoyMexicano()
        })

        $(document).ready(function() {
            avoidSpecialCharacters('perNombre');
            avoidSpecialCharacters('perApellido1');
            avoidSpecialCharacters('perApellido2');
        });

    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            function getProgramas (ubicacion_id) {
                $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

                $.get(base_url+`/api/programaByCampus/${ubicacion_id}`,function(res,sta){


                    //seleccionar el post preservado
                    var programaSeleccionadoOld = $("#programa_id").data("programa-idold")
                    $("#programa_id").empty()


                    for (let key in res) {
                        if (res.hasOwnProperty(key)) {

                            var selected = "";
                            var element = res[key];
                            if (element.id == programaSeleccionadoOld) {
                                console.log("entra")
                                console.log(element.id)
                                selected = "selected";
                            }

                            $("#programa_id").append(`<option value=${element.id} ${selected}>${element.progNombre}</option>`);
                        }
                    }


                    $('#programa_id').trigger('change'); // Notify only Select2 of changes
                });
            }
            if ($("#ubicacion_id").val()) {
                getProgramas($("#ubicacion_id").val())
            }
            $("#ubicacion_id").change( event => {
                var ubicacionId = event.target.value
                getProgramas(ubicacionId)
            });
      });
    </script>



    <script>


        function curpValida(curp) {

            // return true
            var curp = curp.toUpperCase();

            var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0\d|1[0-2])(?:[0-2]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
                validado = curp.match(re);

            if (!validado)  //Coincide con el formato general?
                return false;

            //Validar que coincida el dígito verificador
            function digitoVerificador(curp17) {
                //Fuente https://consultas.curp.gob.mx/CurpSP/
                var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
                    lngSuma      = 0.0,
                    lngDigito    = 0.0;
                for(var i=0; i<17; i++)
                    lngSuma= lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
                lngDigito = 10 - lngSuma % 10;
                if(lngDigito == 10)
                    return 0;
                return lngDigito;
            }
            if (validado[2] != digitoVerificador(validado[1]))
                return false;

            return true; //Validado
        }//curpValida.





        var curp = $("#perCurp").val()
        var esCurpValida = curpValida(curp);
        console.log("escurpvalida", esCurpValida)
        $("#esCurpValida").val(esCurpValida);

        $("#perCurp").on('change', function(e) {
            var curp = e.target.value
            var esCurpValida = curpValida(curp);
            console.log("escurpvalida", esCurpValida)
            $("#esCurpValida").val(esCurpValida);
        });


    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            function obtenerEstados(paisId) {
                $("#estado_id").empty();
                $("#municipio_id").empty();

                $("#estado_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                $("#municipio_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

                $.get(base_url+`/api/estados/${paisId}`, function(res,sta) {

                    //seleccionar el post preservado
                    var estadoSeleccionadoOld = $("#estado_id").data("estado-idold")
                    $("#estado_id").empty()

                    res.forEach(element => {
                        var selected = "";
                        if (element.id === estadoSeleccionadoOld) {
                            console.log("entra")
                            console.log(element.id)
                            selected = "selected";
                        }

                        $("#estado_id").append(`<option value=${element.id} ${selected}>${element.edoNombre}</option>`);
                    });
                    $('#estado_id').trigger('change'); // Notify only Select2 of changes
                });
            }

            obtenerEstados($("#paisId").val())
            $("#paisId").change( event => {

                obtenerEstados(event.target.value)
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {



            function obtenerMunicipios(estadoId) {
                $("#municipio_id").empty();

                $("#municipio_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

                $.get(base_url+`/api/municipios/${estadoId}`, function(res,sta) {

                    //seleccionar el post preservado
                    var municipioSeleccionadoOld = $("#municipio_id").data("municipio-idold")

                    $("#municipio_id").empty()

                    res.forEach(element => {
                        var selected = "";
                        if (element.id == municipioSeleccionadoOld) {
                            selected = "selected";
                        }

                        $("#municipio_id").append(`<option value=${element.id} ${selected}>${element.munNombre}</option>`);
                    });
                    $('#municipio_id').trigger('change'); // Notify only Select2 of changes
                });
            }

            obtenerMunicipios($("#estado_id").val())
            $("#estado_id").change( event => {
                obtenerMunicipios(event.target.value)
            });
        });
    </script>















    <script type="text/javascript">
        $(document).ready(function() {
            function obtenerEstadosPrepa(paisId) {
                $("#estado_prepa_id").empty();
                $("#municipio_prepa_id").empty();

                $("#estado_prepa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                $("#municipio_prepa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

                $.get(base_url+`/api/estados/${paisId}`, function(res,sta) {

                    //seleccionar el post preservado
                    var estadoSeleccionadoOld = "{{old('estado_prepa_id')}}";

                    console.log(estadoSeleccionadoOld, "estadoSeleccionadoOld")
                    $("#estado_prepa_id").empty()

                    res.forEach(element => {
                        var selected = "";
                        if (element.id == estadoSeleccionadoOld) {
                            console.log("entra")
                            console.log(element.id)
                            selected = "selected";
                        }

                        $("#estado_prepa_id").append(`<option value=${element.id} ${selected}>${element.edoNombre}</option>`);
                    });
                    $('#estado_prepa_id').trigger('change'); // Notify only Select2 of changes
                });
            }

            obtenerEstadosPrepa($("#paisPrepaId").val())
            $("#paisPrepaId").change( event => {

                obtenerEstadosPrepa(event.target.value)
            });
        });
    </script>
    {{-- <script type="text/javascript">
        $(document).ready(function() {

            function obtenerEstadosPrepa(estadoId) {
                $("#municipio_prepa_id").empty();

                $("#municipio_prepa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

                $.get(base_url+`/api/municipios/${estadoId}`, function(res,sta) {

                    //seleccionar el post preservado
                    var municipioSeleccionadoOld = $("#municipio_prepa_id").data("municipioPrepa-idold")
                    $("#municipio_prepa_id").empty()

                    res.forEach(element => {
                        var selected = "";
                        if (element.id === municipioSeleccionadoOld) {
                            selected = "selected";
                        }

                        $("#municipio_prepa_id").append(`<option value=${element.id} ${selected}>${element.munNombre}</option>`);
                    });
                    $('#municipio_prepa_id').trigger('change'); // Notify only Select2 of changes
                });
            }

            obtenerEstadosPrepa($("#estado_prepa_id").val())
            $("#estado_prepa_id").change( event => {
                obtenerEstadosPrepa(event.target.value)
            });
        });
    </script> --}}
    <script type="text/javascript">
        $(document).ready(function() {

            function obtenerMunicipiosPrepa(estadoId) {
                $("#municipio_prepa_id").empty();

                $("#municipio_prepa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

                $.get(base_url+`/api/municipios/${estadoId}`, function(res,sta) {

                    //seleccionar el post preservado
                    var municipioSeleccionadoOld = "{{old('municipio_prepa_id')}}"
                    console.log(municipioSeleccionadoOld, "municipioSeleccionadoOld")
                    $("#municipio_prepa_id").empty()

                    res.forEach(element => {
                        var selected = "";
                        if (element.id == municipioSeleccionadoOld) {
                            selected = "selected";
                        }

                        $("#municipio_prepa_id").append(`<option value=${element.id} ${selected}>${element.munNombre}</option>`);
                    });
                    $('#municipio_prepa_id').trigger('change'); // Notify only Select2 of changes
                });
            }

            obtenerMunicipiosPrepa($("#estado_prepa_id").val())
            $("#estado_prepa_id").change( event => {
                obtenerMunicipiosPrepa(event.target.value)
            });
        });






        $(document).ready(function() {

            function obtenerPreparatorias(municipioId) {
                $("#preparatoria_id").empty();

                $("#preparatoria_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

                $.get(base_url + `/api/preparatoriaProcedenciaCandidatos/${municipioId}`, function(res,sta) {

                    //seleccionar el post preservado
                    var prepaSeleccionadoOld ={{old('preparatoria_id')}} 
                    console.log(prepaSeleccionadoOld, "prepaSeleccionadoOld")
                    $("#preparatoria_id").empty()

                    res.forEach(element => {
                        var selected = "";
                        if (element.id == prepaSeleccionadoOld) {
                            selected = "selected";
                        }

                        $("#preparatoria_id").append(`<option value=${element.id} ${selected}>${element.prepNombre}</option>`);
                    });
                    $('#preparatoria_id').trigger('change'); // Notify only Select2 of changes
                });
            }

            obtenerPreparatorias($("#municipio_prepa_id").val())
            $("#municipio_prepa_id").change( event => {
                obtenerPreparatorias(event.target.value)
            });
        });







    </script>







@endsection
