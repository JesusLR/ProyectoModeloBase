@extends('layouts.dashboard')

@section('template_title')
    Primaria entrevista inicial
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('primaria_entrevista_inicial')}}" class="breadcrumb">Listado de entrevista inicial</a>
    <a href="{{url('primaria_entrevista_inicial')}}" class="breadcrumb">Agregar entrevista inicial</a>
@endsection

@section('content')
@php
    use Carbon\Carbon;
    $fechaActual = Carbon::now('CDT')->format('Y-m-d');
@endphp
<style>
          
    .checkbox-warning-filled [type="checkbox"][class*='filled-in']:checked+label:after {
      border-color: #01579B;
      background-color: #01579B;
      
    }      

    .hoverTable{
      width:100%; 
      border-collapse:collapse; 
  }


  /* Define the hover highlight color for the table row */
  .hoverTable tr:hover {
        background-color: #BFC2C3;
  }
    
</style>
<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'primaria.primaria_entrevista_inicial.guardarEntrevista', 'method' => 'POST']) !!}
        @if (isset($candidato))
            <input type="hidden" name="candidato_id" value="{{$candidato->id}}" />
        @endif
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">ENTREVISTA INICIAL</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">DEPARTAMENTO DE PSICOPEDAGOGÍA - ENTREVISTA INICIAL A PADRES DE FAMILIA</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">
                <br>
                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">I. INFORMACIÓN PERSONAL Y FAMILIAR DEL ALUMNO</p>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perNombre', old('perNombre'),
                            array('id' => 'perNombre', 'class' => 'validate','required','maxlength'=>'40')) !!}
                        {!! Form::label('perNombre', 'Nombre(s) *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perApellido1', old('perApellido1'),
                        array('id' => 'perApellido1', 'class' => 'validate','required','maxlength'=>'30')) !!}
                        {!! Form::label('perApellido1', 'Primer apellido *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perApellido2', old('perApellido2'),
                        array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30'))!!}
                        {!! Form::label('perApellido2', 'Segundo apellido', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perCurp', old('perCurp'),
                                array('id' => 'perCurp', 'class' => 'validate', 'required', 'maxlength'=>'18')) !!}
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
                                    <input type="checkbox" name="esExtranjero" id="esExtranjero" value="1" {{ (! empty(old('esExtranjero')) ? 'checked' : '') }}>
                                    <label for="esExtranjero"> No soy Mexicano y aún no tengo el CURP</label>
                                    {{--  @if (isset($candidato))
                                        <div style="width: 100%; height: 100%; position: absolute; top: 0;"></div>
                                    @endif  --}}
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
                                                @if(old('aluNivelIngr') == $departamento->depNivel) {{ 'selected' }} @endif>

                                                {{$departamento->depClave}} -
                                                @if ($departamento->depClave == "SUP") Superior @endif
                                                @if ($departamento->depClave == "POS") Posgrado @endif
                                                @if ($departamento->depClave == "DIP") Educacion Continua @endif
                                                @if ($departamento->depClave == "PRE") Prescolar @endif
                                                @if ($departamento->depClave == "PRI") Primaria @endif

                                            </option>
                                        @endforeach
                                    </select>
                                    @if (isset($candidato))
                                        <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                    @endif
                                </div>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::number('aluGradoIngr', old('aluGradoIngr'), array('id' => 'aluGradoIngr', 'class' => 'validate','required','min'=>'1','max'=>'6','onKeyPress="if(this.value.length>1) return false;"')) !!}
                            {!! Form::label('aluGradoIngr', 'Grado Ingreso *', array('class' => '')); !!}
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
                            {!! Form::date('perFechaNac',  old('perFechaNac'),
                            array('id' => 'perFechaNac', 'class' => ' validate','required')) !!}
                        </div>
                    </div>
                </div>


                <br>
                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Lugar de Nacimiento</p>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('paisId', 'País *', array('class' => '')); !!}
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
                            {!! Form::label('estado_id', 'Estado *', array('class' => '')); !!}
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
                        {!! Form::label('municipio_id', 'Municipio *', array('class' => '')); !!}
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
                <div class="row">               
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('tiempoResidencia', old('tiempoResidencia'), array('id' => 'tiempoResidencia', 'class' => 'validate', 'maxlength'=>'25')) !!}
                            {!! Form::label('tiempoResidencia', 'Si proviene de otra ciudad ¿Cuánto tiempo tiene de residir en Mérida?', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>
                <br>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Datos del padre</p>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nombrePadre', old('nombrePadre'), array('id' => 'nombrePadre', 'class' => 'validate','maxlength'=>'80')) !!}
                            {!! Form::label('nombrePadre', 'Nombre(s)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('apellido1Padre', old('apellido1Padre'), array('id' => 'apellido1Padre', 'class' => 'validate','maxlength'=>'40')) !!}
                            {!! Form::label('apellido1Padre', 'Primer Apellido', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('apellido2Padre', old('apellido2Padre'), array('id' => 'apellido2Padre', 'class' => 'validate','maxlength'=>'40')) !!}
                            {!! Form::label('apellido2Padre', 'Segundo apellido', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('curpPadre', old('curpPadre'),
                                array('id' => 'curpPadre', 'class' => 'validate', 'maxlength'=>'18')) !!}
                            {!! Form::hidden('esCurpValidaPadre', NULL, ['id' => 'esCurpValidaPadre']) !!}
                            {!! Form::label('curpPadre', 'Curp', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('direccionPadre', old('direccionPadre'), array('id' => 'direccionPadre', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('direccionPadre', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('edadPadre', old('edadPadre'), array('id' => 'edadPadre', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadPadre', 'Edad', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularPadre', old('celularPadre'), array('id' => 'celularPadre', 'class' => 'validate', 'maxlength'=>'80')) !!}
                            {!! Form::label('celularPadre', 'Celular', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ocupacionPadre', old('ocupacionPadre'), array('id' => 'ocupacionPadre', 'class' => 'validate', 'maxlength'=>'100')) !!}
                            {!! Form::label('ocupacionPadre', 'Ocupación', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('empresaPadre', old('empresaPadre'), array('id' => 'empresaPadre', 'class' => 'validate', 'maxlength'=>'80')) !!}
                            {!! Form::label('empresaPadre', 'Empresa', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::email('correoPadre', old('correoPadre'), array('id' => 'correoPadre', 'class' => 'validate noUpperCase', 'maxlength'=>'80')) !!}
                            {!! Form::label('correoPadre', 'Correo', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

       

                <br>
                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Datos de la madre</p>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nombreMadre', old('nombreMadre'), array('id' => 'nombreMadre', 'class' => 'validate','maxlength'=>'80')) !!}
                            {!! Form::label('nombreMadre', 'Nombre(s)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('apellido1Madre', old('apellido1Madre'), array('id' => 'apellido1Madre', 'class' => 'validate','maxlength'=>'40')) !!}
                            {!! Form::label('apellido1Madre', 'Apellido 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('apellido2Madre', old('apellido2Madre'), array('id' => 'apellido2Madre', 'class' => 'validate','maxlength'=>'40')) !!}
                            {!! Form::label('apellido2Madre', 'Apellido 2', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('curpMadre', old('curpMadre'),
                                array('id' => 'curpMadre', 'class' => 'validate', 'maxlength'=>'18')) !!}
                            {!! Form::hidden('esCurpValidaMadre', NULL, ['id' => 'esCurpValidaMadre']) !!}
                            {!! Form::label('curpMadre', 'Curp', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('direccionMadre', old('direccionMadre'), array('id' => 'direccionMadre', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('direccionMadre', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('edadMadre', old('edadMadre'), array('id' => 'edadMadre', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadMadre', 'Edad', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularMadre', old('celularMadre'), array('id' => 'celularMadre', 'class' => 'validate', 'maxlength'=>'80')) !!}
                            {!! Form::label('celularMadre', 'Celular', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ocupacionMadre', old('ocupacionMadre'), array('id' => 'ocupacionMadre', 'class' => 'validate', 'maxlength'=>'100')) !!}
                            {!! Form::label('ocupacionMadre', 'Ocupación', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('empresaMadre', old('empresaMadre'), array('id' => 'empresaMadre', 'class' => 'validate', 'maxlength'=>'80')) !!}
                            {!! Form::label('empresaMadre', 'Empresa', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::email('correoMadre', old('correoMadre'), array('id' => 'correoMadre', 'class' => 'validate noUpperCase', 'maxlength'=>'80')) !!}
                            {!! Form::label('correoMadre', 'Correo', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <br>
                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Datos familiares</p>
                </div>

                <div class="row">
                    {{-- Estado civil de los padres * --}}
                    <div class="col s12 m6 l4">
                        {!! Form::label('estadoCivilPadres', 'Estado civil de los padres *', array('class' => '')); !!}
                        <select id="estadoCivilPadres" class="browser-default validate" name="estadoCivilPadres" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="UNION LIBRE" {{ old('estadoCivilPadres') == "UNION LIBRE" ? 'selected' : '' }}>Unión Libre</option>
                            <option value="CASADOS" {{ old('estadoCivilPadres') == "CASADOS" ? 'selected' : '' }}>Casados</option>
                            <option value="DIVORCIADOS" {{ old('estadoCivilPadres') == "DIVORCIADOS" ? 'selected' : '' }}>Divorciados</option>
                            <option value="SEPARADOS" {{ old('estadoCivilPadres') == "SEPARADOS" ? 'selected' : '' }}>Separados</option>
                        </select>
                    </div>
                   
                    {{-- ¿Tienen alguna religión? ¿Cuál? * --}}
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('religion', old('religion'), array('id' => 'religion', 'class' => 'validate','maxlength'=>'50')) !!}
                            {!! Form::label('religion', 'Religión', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="input-field">
                            <textarea id="observaciones" name="observaciones" class="materialize-textarea">{{old('observaciones')}}</textarea>
                            {!! Form::label('observaciones', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>

                
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="input-field">
                            <textarea id="condicionFamiliar" name="condicionFamiliar" class="materialize-textarea">{{old('condicionFamiliar')}}</textarea>
                            <label for="condicionFamiliar">Condición familiar: <b>*Comunicar por escrito la condición familiar especial, irregular o extraordinaria por 
                                la cual el niño, si así lo fuere, esté pasando.</b></label>
                        </div>
                    </div>  
                </div>
               

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Tutor</p>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('tutorResponsable', old('tutorResponsable'), array('id' => 'tutorResponsable', 'required', 'class' => 'validate','maxlength'=>'80')) !!}
                            {!! Form::label('tutorResponsable', 'Padre o tutor responsable financiero *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularTutor', old('celularTutor'), array('id' => 'celularTutor', 'class' => 'validate', 'required', 'maxlength'=>'10')) !!}
                            {!! Form::label('celularTutor', 'Celular *', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('accidenteLlamar', old('accidenteLlamar'), array('id' => 'accidenteLlamar', 'class' => 'validate', 'required', 'maxlength'=>'200')) !!}
                            {!! Form::label('accidenteLlamar', 'En caso de algún accidente se deberá llamar a *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularAccidente', old('celularAccidente'), array('id' => 'celularAccidente', 'class' => 'validate', 'required', 'maxlength'=>'10')) !!}
                            {!! Form::label('celularAccidente', 'Celular *', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Personas Autorizadas</p>
                </div>

                <p>Personas que pueden recibir información del alumno(a)</p>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('perAutorizada1', old('perAutorizada1'), array('id' => 'perAutorizada1', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante1', 'Persona 1', array('class' => '')); !!}
                        </div>
                    </div>   
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('perAutorizada2', old('perAutorizada2'), array('id' => 'perAutorizada2', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante1', 'Persona 2', array('class' => '')); !!}
                        </div>
                    </div>   
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Datos familiares generales</p>
                </div>
                <p>Breve descripción de su familia </p>

                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('integrante1', old('integrante1'), array('id' => 'integrante1', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante1', 'Integrante 1', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('relacionIntegrante1', old('relacionIntegrante1'), array('id' => 'relacionIntegrante1', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('relacionIntegrante1', 'Relación integrante 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('edadintegrante1', old('edadintegrante1'), array('id' => 'edadintegrante1', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadintegrante1', 'Edad integrante 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('ocupacionIntegrante1', old('ocupacionIntegrante1'), array('id' => 'ocupacionIntegrante1', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('ocupacionIntegrante1', 'Ocupación integrante 1', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('integrante2', old('integrante2'), array('id' => 'integrante2', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante2', 'Integrante 2', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('relacionIntegrante2', old('relacionIntegrante2'), array('id' => 'relacionIntegrante2', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('relacionIntegrante2', 'Relación integrante 2', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('edadintegrante2', old('edadintegrante2'), array('id' => 'edadintegrante2', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadintegrante2', 'Edad integrante 2', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('ocupacionIntegrante2', old('ocupacionIntegrante2'), array('id' => 'ocupacionIntegrante2', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('ocupacionIntegrante2', 'Ocupación integrante 2', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                                {{--  integrante 3   --}}
                                <div class="row">
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('integrante3', old('integrante3'), array('id' => 'integrante3', 'class' => 'validate','maxlength'=>'255')) !!}
                                            {!! Form::label('integrante3', 'Integrante 3', array('class' => '')); !!}
                                        </div>
                                    </div>        
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('relacionIntegrante3', old('relacionIntegrante3'), array('id' => 'relacionIntegrante3', 'class' => 'validate', 'maxlength'=>'40')) !!}
                                            {!! Form::label('relacionIntegrante3', 'Relación integrante 3', array('class' => '')); !!}
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::number('edadintegrante3', old('edadintegrante3'), array('id' => 'edadintegrante3', 'class' => 'validate', 'maxlength'=>'3')) !!}
                                            {!! Form::label('edadintegrante3', 'Edad integrante 3', array('class' => '')); !!}
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('ocupacionIntegrante3', old('ocupacionIntegrante3'), array('id' => 'ocupacionIntegrante3', 'class' => 'validate', 'maxlength'=>'40')) !!}
                                            {!! Form::label('ocupacionIntegrante3', 'Ocupación integrante 3', array('class' => '')); !!}
                                        </div>
                                    </div>            
                                </div>
                
                                {{--  integrante 4   --}}
                                <div class="row">
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('integrante4', old('integrante4'), array('id' => 'integrante4', 'class' => 'validate','maxlength'=>'255')) !!}
                                            {!! Form::label('integrante4', 'Integrante 4', array('class' => '')); !!}
                                        </div>
                                    </div>        
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('relacionIntegrante4', old('relacionIntegrante4'), array('id' => 'relacionIntegrante4', 'class' => 'validate', 'maxlength'=>'40')) !!}
                                            {!! Form::label('relacionIntegrante4', 'Relación integrante 4', array('class' => '')); !!}
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::number('edadintegrante4', old('edadintegrante4'), array('id' => 'edadintegrante4', 'class' => 'validate', 'maxlength'=>'3')) !!}
                                            {!! Form::label('edadintegrante4', 'Edad integrante 4', array('class' => '')); !!}
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('ocupacionIntegrante4', old('ocupacionIntegrante4'), array('id' => 'ocupacionIntegrante4', 'class' => 'validate', 'maxlength'=>'40')) !!}
                                            {!! Form::label('ocupacionIntegrante4', 'Ocupación integrante 4', array('class' => '')); !!}
                                        </div>
                                    </div>            
                                </div>
                
                                {{--  integrante 5   --}}
                                <div class="row">
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('integrante5', old('integrante5'), array('id' => 'integrante5', 'class' => 'validate','maxlength'=>'255')) !!}
                                            {!! Form::label('integrante5', 'Integrante 5', array('class' => '')); !!}
                                        </div>
                                    </div>        
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('relacionIntegrante5', old('relacionIntegrante5'), array('id' => 'relacionIntegrante5', 'class' => 'validate', 'maxlength'=>'40')) !!}
                                            {!! Form::label('relacionIntegrante5', 'Relación integrante 5', array('class' => '')); !!}
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::number('edadintegrante5', old('edadintegrante5'), array('id' => 'edadintegrante5', 'class' => 'validate', 'maxlength'=>'3')) !!}
                                            {!! Form::label('edadintegrante5', 'Edad integrante 5', array('class' => '')); !!}
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('ocupacionIntegrante5', old('ocupacionIntegrante5'), array('id' => 'ocupacionIntegrante5', 'class' => 'validate', 'maxlength'=>'40')) !!}
                                            {!! Form::label('ocupacionIntegrante5', 'Ocupación integrante 5', array('class' => '')); !!}
                                        </div>
                                    </div>            
                                </div>
                
                                {{--  integrante 6   --}}
                                <div class="row">
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('integrante6', old('integrante6'), array('id' => 'integrante6', 'class' => 'validate','maxlength'=>'255')) !!}
                                            {!! Form::label('integrante6', 'Integrante 6', array('class' => '')); !!}
                                        </div>
                                    </div>        
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('relacionIntegrante6', old('relacionIntegrante6'), array('id' => 'relacionIntegrante6', 'class' => 'validate', 'maxlength'=>'40')) !!}
                                            {!! Form::label('relacionIntegrante6', 'Relación integrante 6', array('class' => '')); !!}
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::number('edadintegrante6', old('edadintegrante6'), array('id' => 'edadintegrante6', 'class' => 'validate', 'maxlength'=>'3')) !!}
                                            {!! Form::label('edadintegrante6', 'Edad integrante 6', array('class' => '')); !!}
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('ocupacionIntegrante6', old('ocupacionIntegrante6'), array('id' => 'ocupacionIntegrante6', 'class' => 'validate', 'maxlength'=>'40')) !!}
                                            {!! Form::label('ocupacionIntegrante6', 'Ocupación integrante 6', array('class' => '')); !!}
                                        </div>
                                    </div>            
                                </div>
                
                                 {{--  integrante 7   --}}
                                 <div class="row">
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('integrante7', old('integrante7'), array('id' => 'integrante7', 'class' => 'validate','maxlength'=>'255')) !!}
                                            {!! Form::label('integrante7', 'Integrante 7', array('class' => '')); !!}
                                        </div>
                                    </div>        
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('relacionIntegrante7', old('relacionIntegrante7'), array('id' => 'relacionIntegrante7', 'class' => 'validate', 'maxlength'=>'40')) !!}
                                            {!! Form::label('relacionIntegrante7', 'Relación integrante 7', array('class' => '')); !!}
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::number('edadintegrante7', old('edadintegrante7'), array('id' => 'edadintegrante7', 'class' => 'validate', 'maxlength'=>'3')) !!}
                                            {!! Form::label('edadintegrante7', 'Edad integrante 7', array('class' => '')); !!}
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l3">
                                        <div class="input-field">
                                            {!! Form::text('ocupacionIntegrante7', old('ocupacionIntegrante7'), array('id' => 'ocupacionIntegrante7', 'class' => 'validate', 'maxlength'=>'40')) !!}
                                            {!! Form::label('ocupacionIntegrante7', 'Ocupación integrante 7', array('class' => '')); !!}
                                        </div>
                                    </div>            
                                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('conQuienViveAlumno', old('conQuienViveAlumno'), array('id' => 'conQuienViveAlumno', 'class' => 'validate', 'maxlength'=>'100', 'required')) !!}
                            {!! Form::label('conQuienViveAlumno', '¿Con quien vivi el alumno? *', array('class' => '')); !!}
                        </div>
                    </div>  
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('direccionViviendaAlumno', old('direccionViviendaAlumno'), array('id' => 'direccionViviendaAlumno', 'class' => 'validate', 'maxlength'=>'100', 'required')) !!}
                            {!! Form::label('direccionViviendaAlumno', 'Dirección donde vivie el alumno *', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 m12">
                        <div class="input-field">
                            <label for="situcionLegal">Situación legal: <b>*Entregar copia simple que avale el proceso en todos los casos de Guarda y
                                Custodia que ya haya tenido una sentencia definitiva o se encuentren en un proceso legal.</b></label>
                            <textarea id="situcionLegal" name="situcionLegal" class="materialize-textarea validate">{{old('situcionLegal')}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 m6">
                        <div class="input-field">
                            <label for="descripcionNinio">¿Cómo describen los padres al niño/a?</label>
                            <textarea id="descripcionNinio" name="descripcionNinio" class="materialize-textarea validate">{{old('descripcionNinio')}}</textarea>
                        </div>
                    </div>

                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('apoyoTarea', old('apoyoTarea'), array('id' => 'apoyoTarea', 'class' => 'validate', 'maxlength'=>'50')) !!}
                            {!! Form::label('apoyoTarea', '¿Quién apoya al niño(a) en las tareas para realizar en casa?: ', array('class' => '')); !!}
                        </div>
                    </div>  
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">II.	INFORMACIÓN ESCOLAR DEL ALUMNO </p>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escuelaAnterior', old('escuelaAnterior'), array('id' => 'escuelaAnterior', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('escuelaAnterior', 'Nombre de la escuela anterior', array('class' => '')); !!}
                        </div>
                    </div>  

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('aniosEstudiados', old('aniosEstudiados'), array('id' => 'aniosEstudiados', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('aniosEstudiados', 'Años estudiados en la escuela anterior', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('motivosCambioEscuela', old('motivosCambioEscuela'), array('id' => 'motivosCambioEscuela', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('motivosCambioEscuela', 'Motivos del cambio de escuela', array('class' => '')); !!}
                        </div>
                    </div>  
                </div>


                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('kinder', old('kinder'), array('id' => 'kinder', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('kinder', 'Kínder', array('class' => '')); !!}
                        </div>
                    </div>  

                    <div class="col s12 m6 l6">
                    
                        <label for="">Grados estudiados</label>
                        <div style="margin-top: 12px;" class='form-check checkbox-warning-filled'>
                            <input class='filled-in' type='checkbox' name='preescolar1' value='NO' {{ old('preescolar1') == 'SI' ? 'checked' : '' }} id='preescolar1'><label style="margin-right: 17px;" for='preescolar1'>1ro</label>
                            <input class='filled-in' type='checkbox' name='preescolar2' value='NO' {{ old('preescolar2') == 'SI' ? 'checked' : '' }} id='preescolar2'><label style="margin-right: 17px;" for='preescolar2'>2do</label>
                            <input class='filled-in' type='checkbox' name='preescolar3' value='NO' {{ old('preescolar3') == 'SI' ? 'checked' : '' }} id='preescolar3'><label style="margin-right: 17px;" for='preescolar3'>3do</label>
                        </div>
                    </div>  

                    
                    <script>
                        $( '#preescolar1' ).on( 'click', function() {
                            if( $(this).is(':checked') ){
                                $("#preescolar1").val("SI");                                    
                            } else {
                                $("#preescolar1").val("NO");                                    
                            }
                        });

                        if( $('#preescolar1').prop('checked') ) {
                            $("#preescolar1").val("SI");  
                        }else{
                            $("#preescolar1").val("NO");  
                        }

                        $( '#preescolar2' ).on( 'click', function() {
                            if( $(this).is(':checked') ){
                                $("#preescolar2").val("SI");                                    
                            } else {
                                $("#preescolar2").val("NO");                                    
                            }
                        });

                        if( $('#preescolar2').prop('checked') ) {
                            $("#preescolar2").val("SI");  
                        }else{
                            $("#preescolar2").val("NO");  
                        }

                        $( '#preescolar3' ).on( 'click', function() {
                            if( $(this).is(':checked') ){
                                $("#preescolar3").val("SI");                                    
                            } else {
                                $("#preescolar3").val("NO");                                    
                            }
                        });

                        if( $('#preescolar3').prop('checked') ) {
                            $("#preescolar3").val("SI");  
                        }else{
                            $("#preescolar3").val("NO");  
                        }
                    </script>


                </div>

                <dvi class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('observacionEscolar', old('observacionEscolar'), array('id' => 'observacionEscolar', 'class' => 'validate', 'maxlength'=>'9000')) !!}
                            {!! Form::label('observacionEscolar', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div> 
                </dvi>

                <p>Primaria</p>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio1">Promedio en 1º</label>
                            <input type="number" name="promedio1" id="promedio1" max="10" min="0" step="0.0" value="{{old('promedio1')}}">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio2">Promedio en 2º</label>
                            <input type="number" name="promedio2" id="promedio2" max="10" min="0" step="0.0" value="{{old('promedio2')}}">
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio3">Promedio en 3º</label>
                            <input type="number" name="promedio3" id="promedio3" max="10" min="0" step="0.0" value="{{old('promedio3')}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio4">Promedio en 4º</label>
                            <input type="number" name="promedio4" id="promedio4" max="10" min="0" step="0.0" value="{{old('promedio4')}}">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio5">Promedio en 5º</label>
                            <input type="number" name="promedio5" id="promedio5" max="10" min="0" step="0.0" value="{{old('promedio5')}}">
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio6">Promedio en 6º</label>
                            <input type="number" name="promedio6" id="promedio6" max="10" min="0" step="0.0" value="{{old('promedio6')}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('recursamientoGrado', old('recursamientoGrado'), array('id' => 'recursamientoGrado', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('recursamientoGrado', 'Recursamiento de algún grado', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('deportes', old('deportes'), array('id' => 'deportes', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('deportes', 'Deporte (s) o actividad cultural que practica', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('apoyoPedagogico', '¿Ha recibido su hijo(a) apoyo pedagógico en algún grado escolar? *', ['class' => '']); !!}
                        <select name="apoyoPedagogico" id="apoyoPedagogico" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('apoyoPedagogico') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('apoyoPedagogico') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('obsPedagogico', old('obsPedagogico'), array('id' => 'obsPedagogico', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('obsPedagogico', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('terapiaLenguaje', '¿Ha recibido su hijo(a) terapia de lenguaje en algún grado escolar? *', ['class' => '']); !!}
                        <select name="terapiaLenguaje" id="terapiaLenguaje" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('terapiaLenguaje') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('terapiaLenguaje') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('obsTerapiaLenguaje', old('obsTerapiaLenguaje'), array('id' => 'obsTerapiaLenguaje', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('obsTerapiaLenguaje', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">III.	INFORMACIÓN SOBRE LA CONDICIÓN DE SALUD O NECESIDADES ESPECÍFICAS DEL ALUMNO</p>
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('tratamientoMedico', '¿Ha recibido su hijo(a)  tratamiento médico? *', ['class' => '']); !!}
                        <select name="tratamientoMedico" id="tratamientoMedico" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('tratamientoMedico') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('tratamientoMedico') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('obsTratamientoMedico', old('obsTratamientoMedico'), array('id' => 'obsTratamientoMedico', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsTratamientoMedico', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p><b>¿Actualmente presenta algún padecimiento?</b></p>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('hemofilia', 'Hemofilia *', ['class' => '']); !!}
                        <select name="hemofilia" id="hemofilia" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('hemofilia') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('hemofilia') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsHemofilia', old('obsHemofilia'), array('id' => 'obsHemofilia', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsHemofilia', 'Observaciones hemofilia *', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('epilepsia', 'Epilepsia *', ['class' => '']); !!}
                        <select name="epilepsia" id="epilepsia" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('epilepsia') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('epilepsia') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsEpilepsia', old('obsEpilepsia'), array('id' => 'obsEpilepsia', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsEpilepsia', 'Observaciones epilepsia *', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('kawasaqui', 'Kawasaqui *', ['class' => '']); !!}
                        <select name="kawasaqui" id="kawasaqui" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('kawasaqui') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('kawasaqui') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsKawasaqui', old('obsKawasaqui'), array('id' => 'obsKawasaqui', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsKawasaqui', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('asma', 'Asma *', ['class' => '']); !!}
                        <select name="asma" id="asma" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('asma') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('asma') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsAsma', old('obsAsma'), array('id' => 'obsAsma', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsAsma', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('diabetes', 'Diabetes *', ['class' => '']); !!}
                        <select name="diabetes" id="diabetes" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('diabetes') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('diabetes') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsDiabetes', old('obsDiabetes'), array('id' => 'obsDiabetes', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsDiabetes', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('cardiaco', 'Cardiaco *', ['class' => '']); !!}
                        <select name="cardiaco" id="cardiaco" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('cardiaco') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('cardiaco') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsCardiaco', old('obsCardiaco'), array('id' => 'obsCardiaco', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsCardiaco', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('dermatologico', 'Dermatológico *', ['class' => '']); !!}
                        <select name="dermatologico" id="dermatologico" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('dermatologico') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('dermatologico') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsDermatologico', old('obsDermatologico'), array('id' => 'obsDermatologico', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsDermatologico', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('alergias', 'Alergias *', ['class' => '']); !!}
                        <select name="alergias" id="alergias" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('alergias') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('alergias') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('tipoAlergias', old('tipoAlergias'), array('id' => 'tipoAlergias', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('tipoAlergias', 'Observaciones alergias', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">                    
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('otroTratamiento', old('otroTratamiento'), array('id' => 'otroTratamiento', 'class' => 'validate', 'maxlength'=>'50')) !!}
                            {!! Form::label('otroTratamiento', 'Otro tratamiento', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('tomaMedicamento', old('tomaMedicamento'), array('id' => 'tomaMedicamento', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('tomaMedicamento', '¿Toma algún medicamento?', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('cuidadoEspecifico', old('cuidadoEspecifico'), array('id' => 'cuidadoEspecifico', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('cuidadoEspecifico', '¿Requiere algún cuidado específico? ', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p>¿Ha recibido su hijo(a) tratamiento?</p>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('tratimientoNeurologico', 'Neurológico *', ['class' => '']); !!}
                        <select name="tratimientoNeurologico" id="tratimientoNeurologico" class="browser-default validate select2" style="width: 100%;" required>                            
                            <option value="NO" {{ old('tratimientoNeurologico') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('tratimientoNeurologico') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('obsTratimientoNeurologico', old('obsTratimientoNeurologico'), array('id' => 'obsTratimientoNeurologico', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('obsTratimientoNeurologico', 'Observaciones ', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('tratamientoPsicologico', 'Psicológico *', ['class' => '']); !!}
                        <select name="tratamientoPsicologico" id="tratamientoPsicologico" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('tratamientoPsicologico') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('tratamientoPsicologico') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('obsTratimientoPsicologico', old('obsTratimientoPsicologico'), array('id' => 'obsTratimientoPsicologico', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('obsTratimientoPsicologico', 'Observaciones ', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('medicoTratante', old('medicoTratante'), array('id' => 'medicoTratante', 'class' => 'validate', 'maxlength'=>'100')) !!}
                            {!! Form::label('medicoTratante', 'Médico tratante', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l4">
                        {!! Form::label('llevarAlNinio', 'En caso de no encontrar al padre la escuela llevara al alumno(a)', array('class' => '')); !!}
                        <select name="llevarAlNinio" id="llevarAlNinio" class="browser-default validate select2" style="width: 100%;" required>
                            <option value="NO" {{ old('llevarAlNinio') == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('llevarAlNinio') == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div> 

                    <div class="col s12 m6 l4" style="display: none;" id="formato_salida">
                        <a href="{{route('primaria_entrevista_inicial.formato_de_salida.imprimir')}}" target="_blank" class="btn-large waves-effect darken-3">Imprimir formato de salida <i class=" material-icons left validar-campos">picture_as_pdf</i></a>
                    </div>
                </div>

                <p><b>*Entregar una copia simple del último diagnóstico y/o tratamiento de todo aquel niño que presente algún tipo de enfermedad, padecimiento o condición de salud. </b></p>

                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            {!! Form::text('motivoInscripcionEscuela', old('motivoInscripcionEscuela'), array('id' => 'motivoInscripcionEscuela', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('motivoInscripcionEscuela', 'Motivo por el que se solicita la inscripción en la Escuela Modelo ', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">IV.	REFERENCIAS</p>
                </div>

                <p>Nombre de familiares o conocidos que estudien o trabajen en la Escuela Modelo</p>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('conocidoEscuela1', old('conocidoEscuela1'), array('id' => 'conocidoEscuela1', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('conocidoEscuela1', 'Familiar o conocido 1', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('conocidoEscuela2', old('conocidoEscuela2'), array('id' => 'conocidoEscuela2', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('conocidoEscuela2', 'Familiar o conocido 2', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('conocidoEscuela3', old('conocidoEscuela3'), array('id' => 'conocidoEscuela3', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('conocidoEscuela3', 'Familiar o conocido 3', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p>Nombre y teléfono de familiares o conocidos a quien se le pueda pedir referencia</p>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('referencia1', old('referencia1'), array('id' => 'referencia1', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('referencia1', 'Nombre completo referencia 1', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularReferencia1', old('celularReferencia1'), array('id' => 'celularReferencia1', 'class' => 'validate', 'maxlength'=>'10')) !!}
                            {!! Form::label('celularReferencia1', 'Celular referencia 1', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('referencia2', old('referencia2'), array('id' => 'referencia2', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('referencia2', 'Nombre completo referencia 2', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularReferencia2', old('celularReferencia2'), array('id' => 'celularReferencia2', 'class' => 'validate', 'maxlength'=>'10')) !!}
                            {!! Form::label('celularReferencia2', 'Celular referencia 2', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('referencia3', old('referencia3'), array('id' => 'referencia3', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('referencia3', 'Nombre completo referencia 3', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularReferencia3', old('celularReferencia3'), array('id' => 'celularReferencia3', 'class' => 'validate', 'maxlength'=>'10')) !!}
                            {!! Form::label('celularReferencia3', 'Celular referencia 3', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            {!! Form::text('obsGenerales', old('obsGenerales'), array('id' => 'obsGenerales', 'class' => 'validate', 'maxlength'=>'600')) !!}
                            {!! Form::label('obsGenerales', 'OBSERVACIONES GENERALES', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <br>
                <br>
                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            {!! Form::text('entrevistador', $empleado, array('id' => 'entrevistador', 'class' => 'validate', 'maxlength'=>'200', 'readonly')) !!}
                            {!! Form::label('entrevistador', 'ENTREVISTADOR', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

          </div>
          <div class="card-action">
            {{--  {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-guardar-alumno btn-large waves-effect  darken-3','type' => 'submit']) !!}  --}}
            {!! Form::button('<i class=" material-icons left validar-campos">save</i> Guardar', ['class' => 'btn-guardar-alumno btn-large waves-effect  darken-3','id'=>'btn-guardar-alumno']) !!}

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
@include('primaria.scripts.funcionesAuxiliares')

<script>
    // var instance = M.Tabs.getInstance($(".tabs"));
    // instance.select('personal');

    $(document).on("click", ".btn-guardar-alumno", function(e) {


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



    var curp = $("#perCurp").val();
    var esCurpValida = curpValida(curp);
    $("#esCurpValida").val(esCurpValida);

    $("#perCurp").on('change', function(e) {
        var curp = e.target.value
        var esCurpValida = curpValida(curp);
        $("#esCurpValida").val(esCurpValida);
    });


    //Para CURP de la madre
    var curpMadre = $("#curpMadre").val();
    var esCurpValidaMadre = curpValidaMadre(curpMadre);
    $("#esCurpValidaMadre").val(esCurpValidaMadre);

    $("#curpMadre").on('change', function(e) {
        var curpMadre = e.target.value
        var esCurpValidaMadre = curpValidaMadre(curpMadre);
        $("#esCurpValidaMadre").val(esCurpValidaMadre);
    });

    //Para CURP de la padre
    var curpPadre = $("#curpPadre").val();
    var esCurpValidaPadre = curpValidaMadre(curpPadre);
    $("#esCurpValidaPadre").val(esCurpValidaPadre);

    $("#curpPadre").on('change', function(e) {
        var curpPadre = e.target.value
        var esCurpValidaPadre = curpValidaMadre(curpPadre);
        $("#esCurpValidaPadre").val(esCurpValidaPadre);
    });


</script>

//@include('primaria.entrevista_inicial.traerDatos')



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



        $('#btn-guardar-alumno').on('click', function () {
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
            url: base_url + '/primaria_alumno/verificar_persona',
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
            url: base_url+'/primaria_alumno/rehabilitar_alumno/'+alumno_id,
            data:{alumno_id: alumno_id, '_token':'{{csrf_token()}}'},
            dataType:'json',
            success: function(alumno) {
                window.location = base_url+'/primaria_alumno/'+alumno.id+'/edit';
            },
            error: function(jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });
    }//rehabilitarAlumno.

    function empleado_crearAlumno(empleado_id) {


        $.ajax({
            type:'POST',
            url: base_url+'/primaria_alumno/registrar_empleado/'+empleado_id,
            data: $('form').serialize(),
            dataType:'json',
            success: function (alumno) {
                window.location = base_url+'/primaria_alumno/'+alumno.id+'/edit';
            },
            error: function(jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });
    }//empleado_crearAlumno.

</script>


<script>
    $(document).ready(function(){
        $("select[name=alergias]").change(function(){
            if($('select[name=alergias]').val() == "SI"){
                $("#tipoAlergias").prop('disabled', false);
                $("#tipoAlergias").prop('required', true);
            }else{
                $("#tipoAlergias").prop('disabled', true);
                $("#tipoAlergias").prop('required', false);
            }
        });
    
        $("select[name=hemofilia]").change(function(){
            if($('select[name=hemofilia]').val() == "SI"){
                $("#obsHemofilia").prop('disabled', false);
                $("#obsHemofilia").prop('required', true);            
            }else{
                $("#obsHemofilia").prop('disabled', true);
                $("#obsHemofilia").prop('required', false);
            }
        });
    
        $("select[name=epilepsia]").change(function(){
            if($('select[name=epilepsia]').val() == "SI"){
                $("#obsEpilepsia").prop('disabled', false);
                $("#obsEpilepsia").prop('required', true);            
            }else{
                $("#obsEpilepsia").prop('disabled', true);
                $("#obsEpilepsia").prop('required', false);
            }
        });
    
        $("select[name=kawasaqui]").change(function(){
            if($('select[name=kawasaqui]').val() == "SI"){
                $("#obsKawasaqui").prop('disabled', false);
                $("#obsKawasaqui").prop('required', true);            
            }else{
                $("#obsKawasaqui").prop('disabled', true);
                $("#obsKawasaqui").prop('required', false);
            }
        });
    
        $("select[name=asma]").change(function(){
            if($('select[name=asma]').val() == "SI"){
                $("#obsAsma").prop('disabled', false);
                $("#obsAsma").prop('required', true);            
            }else{
                $("#obsAsma").prop('disabled', true);
                $("#obsAsma").prop('required', false);
            }
        });
    
        $("select[name=diabetes]").change(function(){
            if($('select[name=diabetes]').val() == "SI"){
                $("#obsDiabetes").prop('disabled', false);
                $("#obsDiabetes").prop('required', true);            
            }else{
                $("#obsDiabetes").prop('disabled', true);
                $("#obsDiabetes").prop('required', false);
            }
        });
    
        $("select[name=cardiaco]").change(function(){
            if($('select[name=cardiaco]').val() == "SI"){
                $("#obsCardiaco").prop('disabled', false);
                $("#obsCardiaco").prop('required', true);            
            }else{
                $("#obsCardiaco").prop('disabled', true);
                $("#obsCardiaco").prop('required', false);
            }
        });
    
        $("select[name=dermatologico]").change(function(){
            if($('select[name=dermatologico]').val() == "SI"){
                $("#obsDermatologico").prop('disabled', false);
                $("#obsDermatologico").prop('required', true);            
            }else{
                $("#obsDermatologico").prop('disabled', true);
                $("#obsDermatologico").prop('required', false);
            }
        });


        /* ---------------------- mostrar el boton de impresion --------------------- */
        $("select[name=llevarAlNinio]").change(function(){
            if($('select[name=llevarAlNinio]').val() == "SI"){
               $("#formato_salida").show();           
            }else{
                $("#formato_salida").hide();
            }
        });
        
    });
</script>
@endsection
