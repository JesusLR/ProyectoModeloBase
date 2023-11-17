@extends('layouts.dashboard')

@section('template_title')
    Alumno
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('natacion_alumno')}}" class="breadcrumb">Lista de alumnos</a>
    <a href="{{url('natacion_alumno/'.$alumno->id.'/edit')}}" class="breadcrumb">Editar alumno</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['natacion_alumno.update', $alumno->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR. Clave del Alumno #{{$alumno->aluClave}}</span>

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
                        {!! Form::text('perNombre', $alumno->persona->perNombre, array('id' => 'perNombre', 'class' => 'validate','required','maxlength'=>'40')) !!}
                        {!! Form::label('perNombre', 'Nombre(s) *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perApellido1', $alumno->persona->perApellido1, array('id' => 'perApellido1', 'class' => 'validate','required','maxlength'=>'30')) !!}
                        {!! Form::label('perApellido1', 'Primer apellido *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perApellido2', $alumno->persona->perApellido2, array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30')) !!}
                        {!! Form::label('perApellido2', 'Segundo apellido', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perCurp', $alumno->persona->perCurp, array('id' => 'perCurp', 'class' => 'validate','required')) !!}
                        {!! Form::hidden('perCurpOld', $alumno->persona->perCurp, ['id' => 'perCurpOld']) !!}
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
                                <input type="checkbox" name="esExtranjero" id="esExtranjero" value="S">
                                <label for="esExtranjero"> No soy Mexicano y aún no tengo el CURP</label>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="col s12 m7 l7">
                            {!! Form::label('aluNivelIngr', 'Nivel de ingreso', array('class' => '')); !!}
                            @foreach($departamentos as $departamento)
                                {!! Form::text(
                                        'aluNivelIngr',
                                        $departamento->depClave.' - '.$departamento->depNombre,
                                        array(
                                            'id' => 'aluNivelIngr',
                                            'readonly' => 'true'
                                        )
                                    ) !!}
                            @endforeach
                        </div>
                        <div class="col s12 m3 l3">
                            {!! Form::label('aluGradoIngr', 'Grado Ingreso', array('class' => '')); !!}
                            {!! Form::text('aluGradoIngr', 9, array('id' => 'aluGradoIngr','readonly' => 'true')) !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="col s12 m6 l6">
                            {!! Form::label('perSexo', 'Sexo *', array('class' => '')); !!}
                            <select id="perSexo" class="browser-default validate select2" required name="perSexo" style="width: 100%;">
                                <option value="M" @if($alumno->persona->perSexo == "M") {{ 'selected' }} @endif>HOMBRE</option>
                                <option value="F" @if($alumno->persona->perSexo == "F") {{ 'selected' }} @endif>MUJER</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('perFechaNac', 'Fecha de nacimiento *', array('class' => '')); !!}
                            {!! Form::date('perFechaNac', $alumno->persona->perFechaNac, array('id' => 'perFechaNac', 'class' => ' validate','required')) !!}
                        </div>
                    </div>
                </div>

            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  {{-- Script de funciones auxiliares  --}}
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}
  {{-- funciones de módulo CRUD --}}
  {!! HTML::script(asset('js/alumnos/crud-alumnos.js'), array('type' => 'text/javascript')) !!}
  {{-- Funciones para Modelo Persona --}}
  {!! HTML::script(asset('js/personas/personas.js'), array('type' => 'text/javascript'))!!}

@endsection

@section('footer_scripts')
    <script>
        /*
        * VALIDACIÓN DE CURP
        */
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

            /*
            * PERSONA LUGAR DE NACIMIENTO.
            */
        
            var pais_id = $('#paisId').val();
            pais_id && getEstados(pais_id, 'estado_id');
            $("#paisId").on('change', function() {
                pais_id = $('#paisId').val();
                pais_id && getEstados(pais_id, 'estado_id');
            });


            var estado_id = $('#estado_id').val();
            estado_id && getMunicipios(estado_id, 'municipio_id');
            $("#estado_id").on('change', function() {
                estado_id = $('#estado_id').val();
                estado_id && getMunicipios(estado_id, 'municipio_id');
            });

            /*
            * PREPARATORIA DE PROCEDENCIA.
            */

            var prepa_pais_id = $('#paisPrepaId').val();
            prepa_pais_id && getEstados(prepa_pais_id, 'estado_prepa_id');
            $("#paisPrepaId").on('change', function() {
                prepa_pais_id = $('#paisPrepaId').val();
                prepa_pais_id && getEstados(prepa_pais_id, 'estado_prepa_id');
            });

            var prepa_estado_id = $('#estado_prepa_id').val();
            prepa_estado_id && getMunicipios(prepa_estado_id, 'municipio_prepa_id');
            $("#estado_prepa_id").on('change', function() {
                prepa_estado_id = $('#estado_prepa_id').val();
                prepa_estado_id && getMunicipios(prepa_estado_id, 'municipio_prepa_id');
            });

            var prepa_municipio_id = $('#municipio_prepa_id').val();
            prepa_municipio_id && getPreparatorias(prepa_municipio_id, 'preparatoria_id');
            $("#municipio_prepa_id").on('change', function() {
                prepa_municipio_id = $('#municipio_prepa_id').val();
                prepa_municipio_id && getPreparatorias(prepa_municipio_id, 'preparatoria_id');
            });


            // CHECKBOX  "Soy Extranjero".
            $('#esExtranjero').on('click', function() {
                var esExtranjero = $(this);
                if(esExtranjero.is(':checked')) {
                    $("#perCurp").removeAttr('required');
                    $("#perCurp").attr('disabled', true);
                    $("#perCurp").removeClass('invalid');
                    $('#paisId').val(0).select2();
                    $('#paisId option[value="1"]').attr('disabled', true).select2()
                    resetSelect('estado_id');
                    resetSelect('municipio_id');
                    Materialize.updateTextFields();
                } else {
                    $("#perCurp").attr('required', true);
                    $("#perCurp").removeAttr('disabled');
                    $('#paisId option[value="1"]').removeAttr('disabled').select2();
                }
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

    {{-- El siguiente Script solo afecta al apartado de TUTORES --}}
    <script type="text/javascript">

        $(document).ready(function () {

            var alumno = {!!json_encode($alumno)!!};
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

            llenar_tabla_tutores(alumno.id);

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
        });

        
    </script>

@endsection