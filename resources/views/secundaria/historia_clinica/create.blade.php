@extends('layouts.dashboard')

@section('template_title')
Secundaria historial clinica
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{url('secundaria_historia_clinica')}}" class="breadcrumb">Lista de expedientes</a>
<a href="{{url('secundaria_historia_clinica/create')}}" class="breadcrumb">Agregar expediente</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'secundaria.secundaria_historia_clinica.store', 'method' => 'POST']) !!}

        <div class="card ">
            <div class="card-content ">
                <span class="card-title">AGREGAR DATOS DE ENTREVISTA INICIAL</span>

                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#general">General</a></li>
                            <li class="tab"><a href="#familiares">Familiares</a></li>
                            <li class="tab"><a href="#embarazo">Embarazo</a></li>
                            <li class="tab"><a href="#medica">Medica</a></li>
                            <li class="tab"><a href="#habitos">Hábitos</a></li>
                            <li class="tab"><a href="#desarrollo">Desarrollo</a></li>
                            <li class="tab"><a href="#heredo">Heredo</a></li>
                            <li class="tab"><a href="#social">Social</a></li>
                            <li class="tab"><a href="#conducta">Conducta</a></li>
                            <li class="tab"><a href="#actividades">Actividades</a></li>
                        </ul>
                    </div>
                </nav>

                @php
                use Carbon\Carbon;
                $fechaActual = Carbon::now('CDT')->format('Y-m-d');
                @endphp

                {{-- GENERAL BAR--}}
                <div id="general">


                    <div class="row">                        
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perNombre', old('perNombre'), array('id' => 'perNombre', 'class' => 'validate','required','maxlength'=>'40')) !!}
                                <label for="perNombre"><strong style="color: #000; font-size: 16px;">Nombre(s) *</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perApellido1', old('perApellido1'), array('id' => 'perApellido1', 'class' => 'validate','required','maxlength'=>'30')) !!}
                            <label for="perApellido1"><strong style="color: #000; font-size: 16px;">Primer apellido *</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perApellido2', old('perApellido2'), array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30'))!!}
                            <label for="perApellido2"><strong style="color: #000; font-size: 16px;">Segundo apellido</strong></label>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perCurp', old('perCurp'), array('id' => 'perCurp', 'class' => 'validate', 'required', 'maxlength'=>'18')) !!}
                                {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                                <label for="perCurp"><strong style="color: #000; font-size: 16px;">Curp *</strong></label>
                            </div>
                            <div class="row">
                                <div class="col s12 m6 l6">
                                    <a class="waves-effect waves-light btn" href="https://www.gob.mx/curp/" target="_blank">
                                        Verificar Curp
                                    </a>
                                </div>
                                <div class="col s12 m6 l6" style="margin-top:5px;">
                                    <div style="position:relative;">
                                        <input type="checkbox" name="esExtranjero" id="esExtranjero" value="1" {{ (! empty(old('esExtranjero')) ? 'checked' : '') }}>
                                        <label for="esExtranjero"><strong style="color: #000; font-size: 16px;">No soy Mexicano y aún no tengo el CURP</strong></label>  
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="col s12 m6 l4">
                            <div class="col s12 m6 l6">
                                    <label for="aluNivelIngr"><strong style="color: #000; font-size: 16px;">Nivel de ingreso *</strong></label>
                                    <div style="position:relative;">
                                        <select id="aluNivelIngr" class="browser-default validate select2" required name="aluNivelIngr" style="width: 100%;">
                                            <option value="" disabled>SELECCIONE UNA OPCIÓN</option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{$departamento->depNivel}}"
                                                    
                                                    @if(old('aluNivelIngr') == $departamento->depNivel) {{ 'selected' }} @endif>
    
                                                    {{$departamento->depClave}} -
                                                    @if ($departamento->depClave == "SUP") Superior @endif
                                                    @if ($departamento->depClave == "POS") Posgrado @endif
                                                    @if ($departamento->depClave == "DIP") Educacion Continua @endif
                                                    @if ($departamento->depClave == "PRE") Prescolar @endif
                                                    @if ($departamento->depClave == "PRI") Primaria @endif
                                                    @if ($departamento->depClave == "SEC") Secundaria @endif
    
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                {!! Form::number('aluGradoIngr', old('aluGradoIngr'), array('id' => 'aluGradoIngr', 'class' => 'validate','required','min'=>'1','max'=>'3','onKeyPress="if(this.value.length>1) return false;"')) !!}
                                <label for="aluNivelIngr"><strong style="color: #000; font-size: 16px;">Grado Ingreso *</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            {{-- COLUMNA --}}
                            <div class="col s12 m6 l6">
                                <label for="aluNivelIngr"><strong style="color: #000; font-size: 16px;">Sexo *</strong></label>
                                <div style="position:relative;">
                                    <select id="perSexo" class="browser-default validate select2" required name="perSexo" style="width: 100%;">
                                        <option value="M" {{ old('perSexo') == "M" ? 'selected' : '' }}>HOMBRE</option>
                                        <option value="F" {{ old('perSexo') == "F" ? 'selected' : '' }}>MUJER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col s12 m6 l6">
                                <label for="perFechaNac"><strong style="color: #000; font-size: 16px;">Fecha de nacimiento *</strong></label>
                                {!! Form::date('perFechaNac',  old('perFechaNac'), array('id' => 'perFechaNac', 'class' => ' validate','required')) !!}
                            </div>
                        </div>
                    </div>
    
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                      <p style="text-align: center;font-size:1.2em;">Escuela anterior</p>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="sec_tipo_escuela"><strong style="color: #000; font-size: 16px;">Tipo de escuela</strong></label>
                            <select id="sec_tipo_escuela" class="browser-default validate select2" name="sec_tipo_escuela"
                                style="width: 100%;">
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                                <option value="PRIVADA" {{ old('sec_tipo_escuela') == "PRIVADA" ? 'selected' : '' }}>PRIVADA</option>
                                <option value="PÚBLICA" {{ old('sec_tipo_escuela') == "PÚBLICA" ? 'selected' : '' }}>PÚBLICA</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('sec_nombre_ex_escuela', old('sec_nombre_ex_escuela'), array('id' => 'sec_nombre_ex_escuela', 'class' => 'validate','maxlength'=>'255')) !!}
                                <label for="sec_nombre_ex_escuela"><strong style="color: #000; font-size: 16px;">Nombre escuela anterior</strong></label>
                            </div>
                        </div>                    
                    </div>
    
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                      <p style="text-align: center;font-size:1.2em;">Lugar de Nacimiento</p>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="paisId"><strong style="color: #000; font-size: 16px;">País *</strong></label>
                            <div style="position:relative">
                                <select id="paisId"
                                    data-pais-id="{{old('paisId')}}"
                                    class="browser-default validate select2" required name="paisId" style="width: 100%;" {{isset($candidato) ? "readonly": ""}}>
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    @foreach($paises as $pais)
                                        @php
                                            $selected = '';
                                            if (isset($candidato)) {
                                                if ($municipio->estado->pais->id == $pais->id) {
                                                    $selected = 'selected';
                                                }
                                            }
    
                                            if ($pais->id == old("paisId")) {
                                                $selected = 'selected';
                                            }
                                        @endphp
                                        <option value="{{$pais->id}}" {{$selected}}>{{$pais->paisNombre}}</option>
                                    @endforeach
                                </select>
                                @if (isset($candidato))
                                    <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                @endif
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                                <label for="estado_id"><strong style="color: #000; font-size: 16px;">Estado *</strong></label>
                                <div style="position:relative">
                                    <select id="estado_id"
                                        {{isset($candidato) ? "readonly": ""}}
                                        data-estado-id="{{old('estado_id')}}"
                                        class="browser-default validate select2" required name="estado_id" style="width: 100%;">
                                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    </select>
                                    @if (isset($candidato))
                                        <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                    @endif
                                </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="municipio_id"><strong style="color: #000; font-size: 16px;">Municipio *</strong></label>

                            <div style="position:relative">
                                <select id="municipio_id"
                                    {{isset($candidato) ? "readonly": ""}}
                                    data-municipio-id="{{old('municipio_id')}}"
                                    class="browser-default validate select2" required name="municipio_id" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                </select>
                                @if (isset($candidato))
                                    <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                      <p style="text-align: center;font-size:1.2em;">Datos de Contacto</p>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::number('perTelefono2', old('perTelefono2'),
                                array('id' => 'perTelefono2', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                            <label for="perTelefono2"><strong style="color: #000; font-size: 16px;">Teléfono móvil </strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            <label for="perCorreo1"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                            {!! Form::email('perCorreo1', old('perCorreo1'),
                                ['id' => 'perCorreo1', 'class' => 'validate', 'maxlength' => '60']) !!}
                            </div>
                        </div>
                    </div>
    {{--  
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                      <p style="text-align: center;font-size:1.2em;">Domicilio</p>
                    </div>  --}}
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perDirCalle', NULL, array('id' => 'perDirCalle', 'class' => 'validate','maxlength'=>'25')) !!}
                                <label for="perDirCalle"><strong style="color: #000; font-size: 16px;">Calle</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perDirNumExt', NULL, array('id' => 'perDirNumExt', 'class' => 'validate','maxlength'=>'6')) !!}
                                <label for="perDirNumExt"><strong style="color: #000; font-size: 16px;">Número exterior</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perDirNumInt', NULL, array('id' => 'perDirNumInt', 'class' => 'validate','maxlength'=>'6')) !!}
                            <label for="perDirNumInt"><strong style="color: #000; font-size: 16px;">Número interior</strong></label>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perDirColonia', NULL, array('id' => 'perDirColonia', 'class' => 'validate','maxlength'=>'60')) !!}
                                <label for="perDirColonia"><strong style="color: #000; font-size: 16px;">Colonia</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('perDirCP', NULL, array('id' => 'perDirCP', 'class' => 'validate','min'=>'0','max'=>'99999','onKeyPress="if(this.value.length==5) return false;"')) !!}
                                <label for="perDirCP"><strong style="color: #000; font-size: 16px;">Código Postal</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::number('perTelefono1', NULL, array('id' => 'perTelefono1', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                            <label for="perTelefono1"><strong style="color: #000; font-size: 16px;">Teléfono fijo </strong></label>
                            </div>
                        </div>
                    </div>


                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">DATOS GENERALES DEL ALUMNO (A)</p>
                    </div>
                    <br>
                    <div class="row">
                        {{--  /* ----------------------------- tipo de sangre ----------------------------- */  --}}                        
                        <div class="col s12 m6 l4">
                            <label for="hisTipoSangre"><strong style="color: #000; font-size: 16px;">Tipo de sangre</strong></label>
                            <select id="hisTipoSangre" class="browser-default validate" name="hisTipoSangre" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="O NEGATIVO" {{ old('hisTipoSangre') == "O NEGATIVO" ? 'selected' : '' }}>O negativo</option>
                                <option value="O POSITIVO" {{ old('hisTipoSangre') == "O POSITIVO" ? 'selected' : '' }}>O positivo</option>
                                <option value="A NEGATIVO" {{ old('hisTipoSangre') == "A NEGATIVO" ? 'selected' : '' }}>A negativo</option>
                                <option value="A POSITIVO" {{ old('hisTipoSangre') == "A POSITIVO" ? 'selected' : '' }}>A positivo</option>
                                <option value="B NEGATIVO" {{ old('hisTipoSangre') == "B NEGATIVO" ? 'selected' : '' }}>B negativo</option>
                                <option value="B POSITIVO" {{ old('hisTipoSangre') == "B POSITIVO" ? 'selected' : '' }}>B positivo</option>
                                <option value="AB NEGATIVO" {{ old('hisTipoSangre') == "AB NEGATIVO" ? 'selected' : '' }}>AB negativo</option>
                                <option value="AB POSITIVO" {{ old('hisTipoSangre') == "AB POSITIVO" ? 'selected' : '' }}>AB positivo</option>                           
                            </select>
                        </div>

                        {{--  /* -------------------------------- alergias -------------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="hisAlergias"><strong style="color: #000; font-size: 16px;">Alergias</strong></label>
                                {!! Form::text('hisAlergias', old('hisAlergias'), array('id' => 'hisAlergias', 'class' => '')) !!}
                            </div>
                        </div>
                        {{--  /* ------------------------- escuela de procendencia ------------------------ */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="hisEscuelaProcedencia"><strong style="color: #000; font-size: 16px;">Escuela de procedencia</strong></label>
                                {!! Form::text('hisEscuelaProcedencia', old('hisEscuelaProcedencia'), array('id' => 'hisEscuelaProcedencia', 'class' => 'validate', 'maxlength'=>'80')) !!}
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        {{--  /* -------------------------- Último grado cursado -------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="hisUltimoGrado"><strong style="color: #000; font-size: 16px;">Último grado cursado</strong></label>
                                {!! Form::text('hisUltimoGrado', old('hisUltimoGrado'), array('id' => 'hisUltimoGrado', 'class' => 'validate', 'maxlength'=>'20')) !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <label for="hisIngresoSecundaria"><strong style="color: #000; font-size: 16px;">Grado al que se inscribe (primer ingreso a Secundaria)</strong></label>
                            <select id="hisIngresoSecundaria" class="browser-default" name="hisIngresoSecundaria" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="1" {{ old('hisIngresoSecundaria') == "1" ? 'selected="selected"' : '' }}>1</option>
                                <option value="2" {{ old('hisIngresoSecundaria') == "2" ? 'selected="selected"' : '' }}>2</option>
                                <option value="3" {{ old('hisIngresoSecundaria') == "3" ? 'selected="selected"' : '' }}>3</option>

                            </select>
                        </div>

                        {{--  /* -------------- ¿Ha recursado algún año o se lo han sugerido? ------------- */  --}}
                        <div class="col s12 m6 l4">
                            <label for="hisRecursado"><strong style="color: #000; font-size: 16px;">¿Ha recursado algún año o se lo han sugerido?</strong></label>
                            <select id="hisRecursado" class="browser-default" name="hisRecursado" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ old('hisRecursado') == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ old('hisRecursado') == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l12">
                            <div id="detalleRecursamiento" class="input-field" style="display: none">                         
                                <label for="hisRecursadoDetalle"><strong style="color: #000; font-size: 16px;">Detalle de año cursado</strong></label>
                                {!! Form::text('hisRecursadoDetalle', old('hisRecursadoDetalle'), array('id' => 'hisRecursadoDetalle', 'class' => 'validate')) !!}
                            </div>
                        </div>                       
                    </div>

                </div>

                {{-- FAMILIARES BAR --}}
                @include('secundaria.historia_clinica.familiares-create')
                
                {{--  EMBARAZO Y NACIMIENTO   --}}
                @include('secundaria.historia_clinica.embarazo-create')

                {{--  HISTORIA MEDICA   --}}
                @include('secundaria.historia_clinica.medica-create')

                {{--  HÁBITOS E HIGIENE  --}}
                @include('secundaria.historia_clinica.habitos-create')

                {{--  HISTORIA DEL DESARROLLO  --}}
                @include('secundaria.historia_clinica.desarrollo-create')

                {{--  ANTECEDENTES HEREDO FAMILIARES  --}}
                @include('secundaria.historia_clinica.heredo-create')

                {{--  RELACIONES SOCIALES  --}}
                @include('secundaria.historia_clinica.sociales-create')

                {{-- CONDUCTA  --}}
                @include('secundaria.historia_clinica.conducta-create')

                {{-- ACTIVIDADES QUE REALIZA  --}}
                @include('secundaria.historia_clinica.actividades-create')

                


            </div>
            <input type="hidden" name="empleado_id" id="empleado_id" value="">
            <div class="card-action">
                {!! Form::button('<i class=" material-icons left validar-campos">save</i> Guardar', ['class' => 'btn-guardar-alumno-secundaria btn-large waves-effect  darken-3','id'=>'btn-guardar-alumno-secundaria']) !!}

            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

 
{{-- funciones de módulos CRUD --}}
{!! HTML::script(asset('js/alumnos/crud-alumnos.js'), array('type' => 'text/javascript')) !!}
{{-- Funciones para Modelo Persona --}}
{!! HTML::script(asset('js/personas/personas.js'), array('type' => 'text/javascript'))!!}



@endsection

@section('footer_scripts')
{{-- Script de funciones auxiliares  --}}
@include('secundaria.scripts.funcionesAuxiliares')


<script>
    // var instance = M.Tabs.getInstance($(".tabs"));
    // instance.select('personal');

    $(document).on("click", ".btn-guardar-alumno-secundaria", function(e) {


        if ((!$("#perDirCalle").val()    || !$("#perDirNumExt").val()
            || !$("#paisId").val()       || !$("#estado_id").val()
            || !$("#municipio_id").val() || !$("#perDirColonia").val()
            || !$("#perDirCP").val()     || !$("#perSexo").val()
            || !$("#perFechaNac").val()  || !$("#perTelefono2").val()
            || !$("#perCorreo1").val())
            && $("#general").hasClass("active")
            && $("#perNombre").val()
            && $("#perApellido1").val()
            && $("#perCurp").val()
            && $("#aluNivelIngr").val()
            && $("#aluGradoIngr").val()) {

            $('ul.tabs').tabs("select_tab", "personal");

            return;
        }



        $(this).submit()
    })



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

        // PERSONA - LUGAR DE NACIMIENTO - SELECTS

        var pais_id = $('#paisId').val();
        pais_id ? getEstados(pais_id, 'estado_id',
        {{ (isset($candidato) && $municipio) ? $municipio->estado->id : null}}) : resetSelect('estado_id');
        $('#paisId').on('change', function() {
            var pais_id = $(this).val();
            pais_id ? getEstados(pais_id, 'estado_id',
            {{ (isset($candidato) && $municipio)? $municipio->estado->id : null}}) : resetSelect('estado_id');
        });

        var estado_id = $('#estado_id').val();
        estado_id ? getMunicipios(estado_id, 'municipio_id',
        {{ (isset($candidato) && $municipio)? $municipio->id : null}}) : resetSelect('municipio_id');
        $('#estado_id').on('change', function() {
            var estado_id = $(this).val();
            estado_id ? getMunicipios(estado_id, 'municipio_id',
            {{ (isset($candidato) && $municipio)? $municipio->id : null}}) : resetSelect('municipio_id');
        });


        //Lugar nacimiento madre 
        var paisMadre_Id = $('#paisMadre_Id').val();
        paisMadre_Id ? getEstados(paisMadre_Id, 'estadoMadre_id',
        {{ (isset($candidato) && $municipio) ? $municipio->estado->id : null}}) : resetSelect('estadoMadre_id');
        $('#paisMadre_Id').on('change', function() {
            var paisMadre_Id = $(this).val();
            paisMadre_Id ? getEstados(paisMadre_Id, 'estadoMadre_id',
            {{ (isset($candidato) && $municipio)? $municipio->estado->id : null}}) : resetSelect('estadoMadre_id');
        });

        var estadoMadre_id = $('#estadoMadre_id').val();
        estadoMadre_id ? getMunicipios(estadoMadre_id, 'municipioMadre_id',
        {{ (isset($candidato) && $municipio)? $municipio->id : null}}) : resetSelect('municipioMadre_id');
        $('#estadoMadre_id').on('change', function() {
            var estadoMadre_id = $(this).val();
            estadoMadre_id ? getMunicipios(estadoMadre_id, 'municipioMadre_id',
            {{ (isset($candidato) && $municipio)? $municipio->id : null}}) : resetSelect('municipioMadre_id');
        });

        //Lugar nacimiento padre 
        var paisPadre_Id = $('#paisPadre_Id').val();
        paisPadre_Id ? getEstados(paisPadre_Id, 'estadoPadre_id',
        {{ (isset($candidato) && $municipio) ? $municipio->estado->id : null}}) : resetSelect('estadoPadre_id');
        $('#paisPadre_Id').on('change', function() {
            var paisPadre_Id = $(this).val();
            paisPadre_Id ? getEstados(paisPadre_Id, 'estadoPadre_id',
            {{ (isset($candidato) && $municipio)? $municipio->estado->id : null}}) : resetSelect('estadoPadre_id');
        });

        var estadoPadre_id = $('#estadoPadre_id').val();
        estadoPadre_id ? getMunicipios(estadoPadre_id, 'municipioPadre_id',
        {{ (isset($candidato) && $municipio)? $municipio->id : null}}) : resetSelect('municipioPadre_id');
        $('#estadoPadre_id').on('change', function() {
            var estadoPadre_id = $(this).val();
            estadoPadre_id ? getMunicipios(estadoPadre_id, 'municipioPadre_id',
            {{ (isset($candidato) && $municipio)? $municipio->id : null}}) : resetSelect('municipioPadre_id');
        });



        // PREPARATORIA DE PROCEDENCIA - SELECTS

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
                url: base_url + '/secundaria_alumno/tutores/nuevo_tutor',
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

        $('#btn-guardar-alumno-secundaria').on('click', function () {
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
        console.log("verificar persona")

        $.ajax({
            type:'GET',
            url: base_url + '/secundaria_alumno/verificar_persona',
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
                disabled.attr('disabled','disabled');

                console.log(errorMessage);
            },
        });
    }//verificarPersona.

    function rehabilitarAlumno(alumno_id) {
        $.ajax({
            type:'POST',
            url: base_url+'/secundaria_alumno/rehabilitar_alumno/'+alumno_id,
            data:{alumno_id: alumno_id, '_token':'{{csrf_token()}}'},
            dataType:'json',
            success: function(alumno) {
                window.location = base_url+'/secundaria_alumno/'+alumno.id+'/edit';
            },
            error: function(jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });
    }//rehabilitarAlumno.

    function empleado_crearAlumno(empleado_id) {


        $.ajax({
            type:'POST',
            url: base_url+'/secundaria_alumno/registrar_empleado/'+empleado_id,
            data: $('form').serialize(),
            dataType:'json',
            success: function (alumno) {
                window.location = base_url+'/secundaria_alumno/'+alumno.id+'/edit';
            },
            error: function(jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });
    }//empleado_crearAlumno.

</script>



<script>


    if($('select[name=hisRecursado]').val() == "SI"){
        $("#detalleRecursamiento").show(); 
        $("#hisRecursadoDetalle").attr('required', '');
    }else{
        $("#hisRecursadoDetalle").removeAttr('required');
        $("#detalleRecursamiento").hide();         
    }

    {{--  muestra el input para agregar detalle de año cursado si la respuesta es SI  --}}
    $("select[name=hisRecursado]").change(function(){
        if($('select[name=hisRecursado]').val() === "SI"){
            $("#detalleRecursamiento").show();            
            $("#hisRecursadoDetalle").attr('required', '');     
        }else{
            $("#hisRecursadoDetalle").removeAttr('required'); 
            $("#detalleRecursamiento").hide();         
            $("#hisRecursadoDetalle").val("");   

        }
    });

    $("select[name=famRelacionMadre]").change(function(){
        if($('select[name=famRelacionMadre]').val() != ""){
            $("#divFrecuencia").show();            
        }else{
            $("#divFrecuencia").hide();          

        }
    });

    $("select[name=famRelacionPadre]").change(function(){
        if($('select[name=famRelacionPadre]').val() != ""){
            $("#divFrecuenciaPadre").show();            
        }else{
            $("#divFrecuenciaPadre").hide();          

        }
    });

    $("select[name=famEstadoCivilPadres]").change(function(){
        if($('select[name=famEstadoCivilPadres]').val() == "DIVORCIADOS"){
            $("#divSeparado").show(); 
            $("#famSeparado").attr('required', '');     
           
        }else{
            $("#famSeparado").removeAttr('required');
            $("#divSeparado").hide();  
            $("#famSeparado").val("");       

        }
    });
    
    $("select[name=nacComplicacionesEmbarazo]").change(function(){
        if($('select[name=nacComplicacionesEmbarazo]').val() == "SI"){
            $("#divEmbarazo").show(); 
            $("#nacCualesEmbarazo").attr('required', '');     
           
        }else{
            $("#nacCualesEmbarazo").removeAttr('required');
            $("#divEmbarazo").hide();    
        }
    });

    $("select[name=nacComplicacionesParto]").change(function(){
        if($('select[name=nacComplicacionesParto]').val() == "SI"){
            $("#divParto").show(); 
            $("#nacCualesParto").attr('required', '');     
           
        }else{
            $("#nacCualesParto").removeAttr('required');
            $("#divParto").hide();    
            $("#nacCualesParto").val("");     

        }
    });

    $("select[name=nacComplicacionDespues]").change(function(){
        if($('select[name=nacComplicacionDespues]').val() == "SI"){
            $("#divDespues").show(); 
            $("#nacCualesDespues").attr('required', '');     
           
        }else{
            $("#nacCualesDespues").removeAttr('required');
            $("#divDespues").hide();      
            $("#nacCualesDespues").val("");   

        }
    });

    

    $("select[name=nacLactancia]").change(function(){
        if($('select[name=nacLactancia]').val() != "MATERNA"){          
                       
            $("#divLactancia").show(); 
            $("#nacActualmente").attr('required', ''); 
        }else{                     
            
            $("#nacActualmente").removeAttr('required');
            $("#divLactancia").hide();
            $("#nacActualmente").val("");
        }
    });
    
 
  
        $("select[name=famRelacionMadre]").change(function(){
            if($('select[name=famRelacionMadre]').val() != ""){          
                           
                $("#divFrecuencia").show(); 
            }else{                    
                
                $("#divFrecuencia").hide();
            }
        });
</script>


@endsection