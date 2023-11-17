@extends('layouts.dashboard')

@section('template_title')
    Alumno
@endsection

@section('head')
    
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('gimnasio_alumno')}}" class="breadcrumb">Lista de alumnos</a>
    <a href="{{url('gimnasio_alumno/create')}}" class="breadcrumb">Agregar alumno</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'gimnasio_alumno.store', 'method' => 'POST']) !!}

        @if (isset($candidato))
            <input type="hidden" name="candidato_id" value="{{$candidato->id}}" />
        @endif
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR ALUMNO</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>

            @php
             use Carbon\Carbon;
             $fechaActual = Carbon::now('CDT')->format('Y-m-d');
            @endphp

            {{-- GENERAL BAR--}}
            <div id="general">
                <input type="hidden" name="campus" value={{isset($candidato) ? $campus: null}} />
                <input type="hidden" name="departamento" value={{isset($candidato) ? $departamento: null}} />
                <input type="hidden" name="programa" value={{isset($candidato) ? $programa: null}} />

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perNombre', isset($candidato) ? $candidato->perNombre: null,
                            array('id' => 'perNombre', 'class' => 'validate','required','maxlength'=>'40', isset($candidato) ? "readonly": "")) !!}
                        {!! Form::label('perNombre', 'Nombre(s) *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perApellido1', isset($candidato) ? $candidato->perApellido1: null,
                        array('id' => 'perApellido1', 'class' => 'validate','required','maxlength'=>'30',isset($candidato) ? "readonly": "")) !!}
                        {!! Form::label('perApellido1', 'Primer apellido *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perApellido2', isset($candidato) ? $candidato->perApellido2: null,
                        array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30', isset($candidato) ? "readonly": ""))!!}
                        {!! Form::label('perApellido2', 'Segundo apellido', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perCurp', isset($candidato) ? $candidato->perCurp: null,
                                array('id' => 'perCurp', 'class' => 'validate', 'required', 'maxlength'=>'18', isset($candidato) ? "readonly": "")) !!}
                            {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                            {!! Form::label('perCurp', 'Curp *', array('class' => '')); !!}
                        </div>
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <a class="waves-effect waves-light btn" href="https://www.gob.mx/curp/" target="_blank">
                                    Verificar Curp
                                </a>
                            </div>
                            <div class="col s12 m6 l6" style="margin-top:5px;">
                                <div style="position:relative;">
                                    <input type="checkbox" name="esExtranjero" id="esExtranjero" value="" {{(isset($candidato) && $candidato->esExtranjero) ? "checked": ""}} {{isset($candidato) ? "readonly": ""}}>
                                    <label for="esExtranjero"> No soy Mexicano y aún no tengo el CURP</label>
                                    @if (isset($candidato))
                                        <div style="width: 100%; height: 100%; position: absolute; top: 0;"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="col s12 m6 l6">
                                {!! Form::label('aluNivelIngr', 'Nivel de ingreso *', array('class' => '')); !!}
                                <div style="position:relative;">
                                    <select id="aluNivelIngr" class="browser-default validate select2" required name="aluNivelIngr" style="width: 100%;" {{isset($candidato) ? "readonly": ""}}>
                                        <option value="" disabled>SELECCIONE UNA OPCIÓN</option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{$departamento->depNivel}}"
                                                {{ (isset($candidato) && $departamento->depClave == "SUP") ? "selected": ""}}
                                                {{ (!isset($candidato) && !old('aluNivelIngr') && $departamento->depClave == "SUP") ? "selected": ""}}
                                                @if(old('aluNivelIngr') == $departamento->depNivel) {{ 'selected' }} @endif>
                                                
                                                {{$departamento->depClave}} - {{ $departamento->depNombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if (isset($candidato))
                                        <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                    @endif
                                </div>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('aluGradoIngr', 'Grado Ingreso *', array('class' => '')); !!}
                            <select class="browser-default validate select2" data-grado-ingreso="{{old('aluGradoIngr') ?: 9}}" id="aluGradoIngr" name="aluGradoIngr" style="width:100%;">
                                <option value="9">9</option>
                            </select>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- COLUMNA --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('perSexo', 'Sexo *', array('class' => '')); !!}
                            <div style="position:relative;">
                                <select id="perSexo" class="browser-default validate select2" required name="perSexo" style="width: 100%;" {{isset($candidato) ? "readonly": ""}}>
                                    <option
                                        value="M"
                                        {{ (old("perSexo") == "M") ? "selected": ""}}
                                        {{ (isset($candidato) && $candidato->perSexo == "M") ? "selected": ""}}>
                                        HOMBRE
                                    </option>
                                    <option
                                        value="F"
                                        {{ (old("perSexo") == "F") ? "selected": ""}}
                                        {{ (isset($candidato) && $candidato->perSexo == "F") ? "selected": ""}}>
                                        MUJER
                                    </option>
                                </select>
                                @if (isset($candidato))
                                    <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                @endif
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('perFechaNac', 'Fecha de nacimiento *', array('class' => '')); !!}
                            {!! Form::date('perFechaNac',  isset($candidato) ? $candidato->perFechaNac: NULL, 
                            array('id' => 'perFechaNac', 'class' => ' validate','required', 'max'=>$fechaActual, isset($candidato) ? "readonly": "")) !!}
                        </div>
                    </div>
                </div>

            </div>

          </div>
          <input type="hidden" name="empleado_id" id="empleado_id" value="">
          <div class="card-action">
            {!! Form::button('<i class=" material-icons left validar-campos">save</i> Guardar', ['class' => 'btn-guardar btn-large waves-effect  darken-3','id'=>'btn-guardar']) !!}
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

@endsection

@section('footer_scripts')

    <script>
        // var instance = M.Tabs.getInstance($(".tabs"));
        // instance.select('personal');

        // $(document).on("click", ".btn-guardar", function(e) {


        //     if ((!$("#perDirCalle").val()    || !$("#perDirNumExt").val()
        //         || !$("#paisId").val()       || !$("#estado_id").val()
        //         || !$("#municipio_id").val() || !$("#perDirColonia").val() 
        //         || !$("#perDirCP").val()     || !$("#perSexo").val()
        //         || !$("#perFechaNac").val()  || !$("#perTelefono2").val()
        //         || !$("#perCorreo1").val())
        //         && $("#general").hasClass("active")
        //         && $("#perNombre").val()
        //         && $("#perApellido1").val()
        //         && $("#perCurp").val()
        //         && $("#aluNivelIngr").val()
        //         && $("#aluGradoIngr").val()) {

        //         $('ul.tabs').tabs("select_tab", "personal");

        //         return;
        //     }



        //     //
        // })



        var curp = $("#perCurp").val()
        var esCurpValida = curpValida(curp);
        $("#esCurpValida").val(esCurpValida);

        $("#perCurp").on('change', function(e) {
            var curp = e.target.value
            var esCurpValida = curpValida(curp);
            $("#esCurpValida").val(esCurpValida);
        });


    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            avoidSpecialCharacters('perNombre');
            avoidSpecialCharacters('perApellido1');
            avoidSpecialCharacters('perApellido2');

            apply_data_to_select('aluGradoIngr', 'grado-ingreso');

            // PERSONA - LUGAR DE NACIMIENTO - SELECTS
            apply_data_to_select('paisId', 'pais-id', "0");
            var pais_id = $('#paisId').val();
            pais_id ? getEstados(pais_id) : resetSelect('estado_id');
            $('#paisId').on('change', function() {
                var pais_id = $(this).val();
                pais_id ? getEstados(pais_id) : resetSelect('estado_id');
            });

            $('#estado_id').on('change', function() {
                var estado_id = $(this).val();
                estado_id ? getMunicipios(estado_id) : resetSelect('municipio_id');
            });



            // PREPARATORIA DE PROCEDENCIA - SELECTS
            apply_data_to_select('paisPrepaId', 'pais-id', "0");
            $('#paisPrepaId').val() ? getEstados($('#paisPrepaId').val(), 'estado_prepa_id') : resetSelect('estado_prepa_id');
            $('#paisPrepaId').on('change', function() {
                this.value ? getEstados(this.value, 'estado_prepa_id') : resetSelect('estado_prepa_id');
            });

            $('#estado_prepa_id').on('change', function() {
                var prepa_estado_id = $(this).val();
                prepa_estado_id ? getMunicipios(prepa_estado_id, 'municipio_prepa_id') : resetSelect('municipio_prepa_id');
            });

            $('#municipio_prepa_id').on('change', function() {
                var prepa_municipio_id = $(this).val();
                prepa_municipio_id ? getPreparatorias(prepa_municipio_id, 'preparatoria_id') : resetSelect('preparatoria_id');
            });

            function esExtranjero (inputEsExtranjero) {
                if(inputEsExtranjero.is(':checked')) {
                    $("#perCurp").removeAttr('required');
                    $("#perCurp").attr('disabled', true);
                    $("#perCurp").removeClass('invalid').val('');
                    if ($('#paisId').val() == 1) {
                        $('#paisId').val(0).select2();
                        resetSelect('estado_id');
                        resetSelect('municipio_id');
                    }
                    $('#paisId option[value="1"]').attr('disabled', true).select2();
                    
                    Materialize.updateTextFields();
                } else {
                    $("#perCurp").attr('required', true);
                    $("#perCurp").removeAttr('disabled');
                    $('#paisId option[value="1"]').removeAttr('disabled').select2();
                }
            }
            // CHECKBOX  "Soy Extranjero".
            esExtranjero($('#esExtranjero'));
            $('#esExtranjero').on('click', function() {
                var inputEsExtranjero = $(this)
                esExtranjero(inputEsExtranjero);
            });

            //CHECKBOX "Definir preparatoria después"
            $('#prepaPorDefinir').on('click', function() {
                var prepaPorDefinir = $(this);
                if(prepaPorDefinir.is(':checked')) {
                    $("#paisPrepaId").attr('disabled', true).val(0).select2();
                    $("#estado_prepa_id").empty().append(new Option('SELECCIONE UNA OPCIÓN', '')).attr('disabled', true).select2();
                    $("#municipio_prepa_id").empty().append(new Option('SELECCIONE UNA OPCIÓN', '')).attr('disabled', true).select2();
                    $('#preparatoria_id').empty()
                    .append(new Option('* POR DEFINIR', 0));
                } else {
                    $('#paisPrepaId').removeAttr('disabled').select2();
                    $('#estado_prepa_id').removeAttr('disabled').select2();
                    $('#municipio_prepa_id').removeAttr('disabled').select2();
                    $('#preparatoria_id').empty()
                    .append(new Option('SELECCIONE UNA OPCIÓN', ''));
                }
            });



        });
    </script>

    <script type="text/javascript">

        /* 
        * El siguiente código solo interviene en el apartado tutores. 
        */
        $(document).ready(function(){

            var elementos = [
                'tutNombre',
                'tutCalle',
                'tutColonia',
                'tutCodigoPostal',
                'tutPoblacion',
                'tutEstado',
                'tutTelefono',
                'tutCorreo',
                'tutCorreo'
            ];

            var elemRequeridos = [
                'tutNombre',
                'tutTelefono'
            ];

            $.each(elemRequeridos, function(key, value) {
                $('#' + value).on('change', function() {
                    $('#vincularTutor').attr('disabled', true);
                })
            });

            $.each(elementos, function (key, value) {
                $('#' + value).change(function () {
                    if_haveValue_setRequired(elementos, elemRequeridos);
                });
            });

            //Acciones del botón buscar tutor. -------------------------------
            $('#buscarTutor').on('click', function () {
                var tutNombre = $('#tutNombre').val();
                var tutTelefono = $('#tutTelefono').val();
                if(tutNombre && tutTelefono){
                    buscarTutor(tutNombre, tutTelefono);
                }else{
                    swal({
                        title: 'Requiere llenar estos campos:',
                        text: '- Nombre del tutor \n - Teléfono de tutor',
                    });
                }
            });


            //acciones del botón vincular tutor. -----------------------------
            $('#vincularTutor').on('click', function () {
                var tutNombre = $('#tutNombre').val();
                var tutTelefono = $('#tutTelefono').val();
                if(tutNombre && tutTelefono){
                    addRow_tutor(tutNombre, tutTelefono);
                    emptyElements(elementos);
                    unsetRequired(elemRequeridos);
                }else{
                    swal({
                        title: 'Requiere llenar estos campos:',
                        text: '- Nombre del tutor \n - Teléfono de tutor \n'+
                            '\n Así como verificar si el tutor existe',
                    });
                }
            });

            //Acción de botón crear tutor. ---------------------------------
            $('#crearTutor').on('click', function () {
                var datos = objectBy(elementos);
                console.log(datos);
                $.ajax({
                    type: 'POST',
                    url: base_url + '/alumno/tutores/nuevo_tutor',
                    data: {datos: datos, '_token':'{{csrf_token()}}'}, 
                    dataType: 'json',
                    success: function (data) {
                        if(data){
                            var tutor = data;
                            addRow_tutor(tutor.tutNombre, tutor.tutTelefono);
                            emptyElements(elementos);
                            unsetRequired(elemRequeridos);
                        }else{
                            swal({
                                title: 'Ya existe registro.',
                                text: 'Ya existe un tutor con estos datos, ' +
                                'Puede obtener sus datos presionando el botón de búsqueda.'
                            });
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                    }
                });
            });

            $('#tbl-tutores').on('click','.desvincular', function () {
                $(this).closest('tr').remove();
            });

            $('#btn-guardar').on('click', function () {
                var requeridosIdentidad = {
                    perNombre: 'Nombre',
                    perApellido1: 'Primer Apellido',
                    perCurp: 'CURP'
                };
                if($('#esExtranjero').is(':checked')) {
                    delete requeridosIdentidad.perCurp;
                }

                var camposFaltantes = validate_formFields(requeridosIdentidad);
                if(jQuery.isEmptyObject(camposFaltantes)) {
                    verificarPersona();
                }else{    
                    showRequiredFields(camposFaltantes);
                }
            });


        });

        function verificarPersona() {

            $.ajax({
                type:'GET',
                url: base_url + '/api/gimnasio_alumno/verificar_persona',
                data: $('form').serialize(),
                dataType: 'json',
                success: function(data) {
                    if(data.alumno){
                        var alumno = data.alumno;
                        var persona = alumno.persona;
                        swal({
                            title: 'Ya existe el Alumno',
                            text: 'Se encontró un alumno con los siguientes datos: \n' +
                                  '\n Clave de Alumno: '+alumno.aluClave+' \n'+
                                  'Nombre: '+persona.perNombre+' '+persona.perApellido1+' '+persona.perApellido2+' \n'+
                                  'CURP: '+persona.perCurp+' \n'+
                                  '\n No se puede duplicar el alumno. ¿Desea utilizar este registro?',
                            showCancelButton: true,
                            cancelButtonText: 'No, cancelar',
                            confirmButtonText: 'Habilitar'
                        },function() {
                            rehabilitarAlumno(alumno.id);
                        });
                    }else if(data.empleado) {
                        var empleado = data.empleado;
                        var persona = empleado.persona;
                        swal({
                            title: 'Ya existe la persona',
                            text: 'Se encontró un empleado con los siguientes datos: \n' +
                                  '\n Clave: '+empleado.id+' \n'+
                                  'Nombre: '+persona.perNombre+' '+persona.perApellido1+' '+persona.perApellido2+' \n'+
                                  'CURP: '+persona.perCurp+' \n'+
                                  '\n No se pueden duplicar estos datos. ¿Desea registrar este empleado como alumno?',
                            showCancelButton: true,
                            cancelButtonText: 'No, cancelar',
                            confirmButtonText: 'Sí, registrar como alumno'
                        }, function() {
                            empleado_crearAlumno(empleado.id);
                        });
                    }else{
                        $('form').submit();
                    }
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    // disabled.attr('disabled','disabled');

                    console.log(errorMessage);
                },
            });
        }//verificarPersona.

        function rehabilitarAlumno(alumno_id) {
            $.ajax({
                type:'POST',
                url: base_url+'/api/alumno/rehabilitar_alumno/'+alumno_id,
                data:{alumno_id: alumno_id, '_token':'{{csrf_token()}}'},
                dataType:'json',
                success: function(alumno) {
                    window.location = base_url+'/alumno/'+alumno.id+'/edit';
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    console.log(errorMessage);
                }
            });
        }//rehabilitarAlumno.

        function empleado_crearAlumno(empleado_id) {

            
            $.ajax({
                type:'POST',
                url: base_url+'/api/alumno/registrar_empleado/'+empleado_id,
                data: $('form').serialize(),
                dataType:'json',
                success: function (alumno) {
                    window.location = base_url+'/alumno/'+alumno.id+'/edit';
                },
                error: function(jqXhr, textStatus, errorMessage) {
                    console.log(errorMessage);
                }
            });
        }//empleado_crearAlumno.

    </script>


    <script>                     


            $("select[name=aluNivelIngr]").change(function(){
                if($('select[name=aluNivelIngr]').val() == 1){    
                    
                    $("#paisPrepaId").attr('disabled', true).val(0).select2();
                    $("#estado_prepa_id").empty().append(new Option('SELECCIONE UNA OPCIÓN', '')).attr('disabled', true).select2();
                    $("#municipio_prepa_id").empty().append(new Option('SELECCIONE UNA OPCIÓN', '')).attr('disabled', true).select2();
                    $('#preparatoria_id').empty()
                    .append(new Option('* POR DEFINIR', 0));   

                    $("#prepaPorDefinir").prop("checked", true);
                    $('#prepaPorDefinir').prop('disabled', true);

                    {{--  ocultar los div de los datos de la Prepa cuando se selecciona Prescolar   --}}
                    $("#prepDefinir").hide();
                    $("#prepDefinir2").hide();
                    $("#prepDefinir2").hide();

                               

                }else{
                    $("#prepaPorDefinir").prop("checked", false);
                    $('#prepaPorDefinir').prop('disabled', false);
                    $('#paisPrepaId').removeAttr('disabled').select2();
                    $('#estado_prepa_id').removeAttr('disabled').select2();
                    $('#municipio_prepa_id').removeAttr('disabled').select2();
                    $('#preparatoria_id').empty()
                    .append(new Option('SELECCIONE UNA OPCIÓN', ''));

                    $("#prepDefinir").show();
                    $("#prepDefinir2").show();
                    $("#prepDefinir2").show();
                }
            });                
   
    </script>

@endsection