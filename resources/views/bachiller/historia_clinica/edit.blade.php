@extends('layouts.dashboard')

@section('template_title')
Bachiller historial clinica
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{url('bachiller_historia_clinica')}}" class="breadcrumb">Lista de expedientes</a>
<a href="{{url('bachiller_historia_clinica/'.$historia->id.'/edit')}}" class="breadcrumb">Editar expediente</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['bachiller.bachiller_historia_clinica.update', $historia->id])) }}
        {{--  @if (isset($candidato))
            <input type="hidden" name="candidato_id" value="{{$candidato->id}}" />
        @endif --}}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">EDITAR DATOS DE ENTREVISTA INICIAL #{{$historia->id}}</span>

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
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('aluClave', $alumno->aluClave, array('id' => 'aluClave', 'class' => 'validate','maxlength'=>'40','readonly')) !!}
                                <label for="aluClave"><strong style="color: #000; font-size: 16px;">Clave pago</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('perNombre', $persona->perNombre, array('id' => 'perNombre', 'class' => 'validate','maxlength'=>'40','readonly')) !!}
                                <label for="perNombre"><strong style="color: #000; font-size: 16px;">Nombre(s)</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('perApellido1', $persona->perApellido1, array('id' => 'perApellido1', 'class' => 'validate','maxlength'=>'30','readonly')) !!}
                                <label for="perApellido1"><strong style="color: #000; font-size: 16px;">Primer apellido</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('perApellido2', $persona->perApellido2, array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30', 'readonly'))!!}
                                <label for="perApellido2"><strong style="color: #000; font-size: 16px;">Segundo apellido</strong></label>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perCurp', $persona->perCurp, array('id' => 'perCurp', 'class' => 'validate', 'required', 'maxlength'=>'18', 'readonly')) !!}
                                {!! Form::hidden('perCurpOld', $alumno->persona->perCurp, ['id' => 'perCurpOld']) !!}
                                {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                                <label for="perCurp"><strong style="color: #000; font-size: 16px;">Curp</strong></label>
                            </div>
                            <div class="row">
                                <div class="col s12 m6 l6">
                                    <a class="waves-effect waves-light btn" href="https://www.gob.mx/curp/" target="_blank">
                                        Verificar Curp
                                    </a>
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
                                                    @if ($departamento->depClave == "BAC") Bachiller @endif

                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                {!! Form::number('aluGradoIngr', $alumno->aluGradoIngr, array('id' => 'aluGradoIngr', 'class' => 'validate','required','min'=>'1','max'=>'6','onKeyPress="if(this.value.length>1) return false;"', 'readonly')) !!}
                                <label for="aluGradoIngr"><strong style="color: #000; font-size: 16px;">Semestre Ingreso *</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            {{-- COLUMNA --}}
                            <div class="col s12 m6 l6">
                                <label for="perSexo"><strong style="color: #000; font-size: 16px;">Sexo *</strong></label>
                                <div style="position:relative;">
                                    <select id="perSexo" class="browser-default validate select2" required name="perSexo" style="width: 100%;">
                                        <option value="M" {{ $persona->perSexo == "M" ? 'selected' : '' }}>HOMBRE</option>
                                        <option value="F" {{ $persona->perSexo == "F" ? 'selected' : '' }}>MUJER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col s12 m6 l6">
                                <label for="perFechaNac"><strong style="color: #000; font-size: 16px;">Fecha de nacimiento</strong></label>
                                {!! Form::date('perFechaNac',  $persona->perFechaNac, array('id' => 'perFechaNac', 'class' => ' validate','required', 'readonly')) !!}
                            </div>
                        </div>
                    </div>
    
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                      <p style="text-align: center;font-size:1.2em;">Secundaria de procedencia</p>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <input type="checkbox" name="secunPorDefinir" id="secunPorDefinir" value="">
                            <label for="secunPorDefinir">Definir secundaria después</label>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('paisSecundariaId', 'País secundaria', array('class' => '')); !!}
                            <select id="paisSecundariaId" class="browser-default validate select2"  name="paisSecundariaId" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($paises as $pais)
                                    <option value="{{$pais->id}}" @if($secundaria_pais_id == $pais->id) {{ 'selected' }} @endif>{{$pais->paisNombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('estado_secundaria_id', 'Estado secundaria', array('class' => '')); !!}
                            <select id="estado_secundaria_id" data-estado-id="{{$secundaria_estado_id}}"
                                class="browser-default validate select2"
                                 name="estado_secundaria_id" style="width: 100%;">
                            </select>
                            <input type="hidden" class="fix-estado-prepa-id" value="{{$secundaria_estado_id}}">
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('municipio_secundaria_id', 'Municipio secundaria', ['class' => '']); !!}
                            <select id="municipio_secundaria_id" data-municipio-id="{{$secundaria_municipio_id}}"
                                class="browser-default validate select2"
                                required name="municipio_secundaria_id" style="width: 100%;">
                            </select>
                        </div>
                    </div>
    
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('secundaria_id', 'Secundaria de procedencia *', array('class' => '')); !!}
                            <select id="secundaria_id" data-secundaria-id="{{$alumno->secundaria_id}}"
                                class="browser-default validate select2"  name="secundaria_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <input type="hidden" id="secundaria_id_alumno" value="{{$alumno->secundaria_id}}" />
    
                        <div class="col s12 m6 l4">
                            {!! Form::label('sec_tipo_escuela', 'Tipo de escuela', array('class' => '')); !!}
                            <select id="sec_tipo_escuela" class="browser-default validate select2" name="sec_tipo_escuela"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="PRIVADA" {{ $alumno->sec_tipo_escuela == "PRIVADA" ? 'selected' : '' }}>PRIVADA</option>
                                <option value="PÚBLICA" {{ $alumno->sec_tipo_escuela == "PÚBLICA" ? 'selected' : '' }}>PÚBLICA</option>
                            </select>
                        </div>
                    </div>
    
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                      <p style="text-align: center;font-size:1.2em;">Preparatoria de procedencia</p>
                    </div>
        
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <input type="checkbox" name="prepaPorDefinir" id="prepaPorDefinir" value="">
                            <label for="prepaPorDefinir">Definir preparatoria después</label>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('paisPrepaId', 'País preparatoria', array('class' => '')); !!}
                            <select id="paisPrepaId" class="browser-default validate select2"  name="paisPrepaId" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($paises as $pais)
                                    <option value="{{$pais->id}}" @if($preparatoria_pais_id == $pais->id) {{ 'selected' }} @endif>{{$pais->paisNombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('estado_prepa_id', 'Estado preparatoria', array('class' => '')); !!}
                            <select id="estado_prepa_id" data-estado-id="{{$preparatoria_estado_id}}"
                                class="browser-default validate select2"
                                 name="estado_prepa_id" style="width: 100%;">
                            </select>
                            <input type="hidden" class="fix-estado-prepa-id" value="{{$preparatoria_estado_id}}">
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('municipios_prepa_id', 'Municipio preparatoria', ['class' => '']); !!}
                            <select id="municipios_prepa_id" data-municipio-id="{{$preparatoria_municipio_id}}"
                                class="browser-default validate select2"
                                required name="municipios_prepa_id" style="width: 100%;">
                            </select>
                            <input type="hidden" class="fix-municipio-prepa-id" value="{{$preparatoria_municipio_id}}">
                        </div>
                    </div>
        
        
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('preparatoria_id', 'Preparatoria de procedencia *', array('class' => '')); !!}
                            <select id="preparatoria_id" data-preparatoria-id="{{$alumno->preparatoria_id}}"
                                class="browser-default validate select2"  name="preparatoria_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <input type="hidden" id="preparatoria_id_alumno" value="{{$alumno->preparatoria_id}}" />
                    </div>

                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                      <p style="text-align: center;font-size:1.2em;">Lugar de Nacimiento</p>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="paisId"><strong style="color: #000; font-size: 16px;">País</strong></label>
                            <div style="position:relative">
                                <select id="paisId"
                                    data-pais-id="{{old('paisId')}}" class="browser-default validate select2" required name="paisId" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    @php                                  
                                        if(old('paisId') !== null){
                                            $pais_alumno = old('paisId'); 
                                        }
                                        else{ $pais_alumno = $pais_alumno->id; }
                                    @endphp
                                    @foreach ($paises as $pais)                                
                                        <option value="{{$pais->id}}" {{ $pais_alumno == $pais->id ? 'selected' : '' }}>{{$pais->paisNombre}}</option>
                                    @endforeach                                   
                                </select>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                                <label for="estado_id"><strong style="color: #000; font-size: 16px;">Estado</strong></label>
                                <div style="position:relative">
                                    <select id="estado_id" data-estado-id="{{old('estado_id')}}" class="browser-default validate select2" required name="estado_id" style="width: 100%;">
                                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                        @php                                  
                                            if(old('estado_id') !== null){
                                                $estado_alumno = old('estado_id'); 
                                            }
                                            else{ $estado_alumno = $estado_alumno->id; }
                                        @endphp
                                        @foreach ($estados as $estado)                                        
                                            <option value="{{$estado->id}}" {{ $estado_alumno == $estado->id ? 'selected' : '' }}>{{$estado->edoNombre}}</option>
                                        @endforeach
                                    </select>                                   
                                </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="municipio_id"><strong style="color: #000; font-size: 16px;">Municipio</strong></label>
                            <div style="position:relative">
                                <select id="municipio_id" data-municipio-id="{{old('municipio_id')}}"class="browser-default validate select2" required name="municipio_id" style="width: 100%;">
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    @php                                  
                                        if(old('municipio_id') !== null){
                                            $municipio_alumno = old('municipio_id'); 
                                        }
                                        else{ $municipio_alumno = $municipio_alumno->id; }
                                    @endphp
                                    @foreach ($municipios as $municipio)                                    
                                        <option value="{{$municipio->id}}" {{ $municipio_alumno == $municipio->id ? 'selected' : '' }}>{{$municipio->munNombre}}</option>
                                    @endforeach
                                </select>                               
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                      <p style="text-align: center;font-size:1.2em;">Datos de Contacto del alumno</p>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                @php                                  
                                if(old('perTelefono2') !== null){
                                    $perTelefono2 = old('perTelefono2'); 
                                }
                                else{ $perTelefono2 = $persona->perTelefono2; }
                                @endphp
                            {!! Form::number('perTelefono2', $perTelefono2,
                                array('id' => 'perTelefono2', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                            <label for="perTelefono2"><strong style="color: #000; font-size: 16px;">Teléfono móvil </strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                @php                                  
                                if(old('perCorreo1') !== null){
                                    $perCorreo1 = old('perCorreo1'); 
                                }
                                else{ $perCorreo1 = $persona->perCorreo1; }
                                @endphp
                            <label for="perCorreo1"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                            {!! Form::email('perCorreo1', $perCorreo1,
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
                                @php                                  
                                if(old('perDirCalle') !== null){
                                    $perDirCalle = old('perDirCalle'); 
                                }
                                else{ $perDirCalle = $persona->perDirCalle; }
                                @endphp
                                {!! Form::text('perDirCalle', $perDirCalle, array('id' => 'perDirCalle', 'class' => 'validate','maxlength'=>'25')) !!}
                                <label for="perDirCalle"><strong style="color: #000; font-size: 16px;">Calle</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                @php                                  
                                if(old('perDirNumExt') !== null){
                                    $perDirNumExt = old('perDirNumExt'); 
                                }
                                else{ $perDirNumExt = $persona->perDirNumExt; }
                                @endphp
                                {!! Form::text('perDirNumExt', $perDirNumExt, array('id' => 'perDirNumExt', 'class' => 'validate','maxlength'=>'6')) !!}
                                <label for="perDirNumExt"><strong style="color: #000; font-size: 16px;">Número exterior</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                @php                                  
                                if(old('perDirNumInt') !== null){
                                    $perDirNumInt = old('perDirNumInt'); 
                                }
                                else{ $perDirNumInt = $persona->perDirNumInt; }
                                @endphp
                            {!! Form::text('perDirNumInt', $perDirNumInt, array('id' => 'perDirNumInt', 'class' => 'validate','maxlength'=>'6')) !!}
                            <label for="perDirNumInt"><strong style="color: #000; font-size: 16px;">Número interior</strong></label>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                @php                                  
                                if(old('perDirColonia') !== null){
                                    $perDirColonia = old('perDirColonia'); 
                                }
                                else{ $perDirColonia = $persona->perDirColonia; }
                                @endphp
                                {!! Form::text('perDirColonia', $perDirColonia, array('id' => 'perDirColonia', 'class' => 'validate','maxlength'=>'60')) !!}
                                <label for="perDirColonia"><strong style="color: #000; font-size: 16px;">Colonia</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                @php                                  
                                if(old('perDirCP') !== null){
                                    $perDirCP = old('perDirCP'); 
                                }
                                else{ $perDirCP = $persona->perDirCP; }
                                @endphp
                                {!! Form::number('perDirCP', $perDirCP, array('id' => 'perDirCP', 'class' => 'validate','min'=>'0','max'=>'99999','onKeyPress="if(this.value.length==5) return false;"')) !!}
                                <label for="perDirCP"><strong style="color: #000; font-size: 16px;">Código Postal</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                @php                                  
                                if(old('perTelefono1') !== null){
                                    $perTelefono1 = old('perTelefono1'); 
                                }
                                else{ $perTelefono1 = $persona->perTelefono1; }
                                @endphp
                            {!! Form::number('perTelefono1', $perTelefono1, array('id' => 'perTelefono1', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                            <label for="perTelefono1"><strong style="color: #000; font-size: 16px;">Teléfono fijo </strong></label>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Datos de contacto del tutor titular</p>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('hisTutorOficial', $historia->hisTutorOficial, array('id' => 'hisTutorOficial', 'class' => 'validate','maxlength'=>'255', 'required')) !!}
                                <label for="hisTutorOficial"><strong style="color: #000; font-size: 16px;">Nombre de la persona autirizada o legalmente responsable *</strong></label>
                            </div>
                        </div>
        
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('hisParentescoTutor', $historia->hisParentescoTutor, array('id' => 'hisParentescoTutor', 'class' => 'validate','maxlength'=>'255', 'required')) !!}
                                <label for="hisParentescoTutor"><strong style="color: #000; font-size: 16px;">Parentesco legal *</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::number('hisCelularTutor', $historia->hisCelularTutor, array('id' => 'hisCelularTutor', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                            <label for="hisCelularTutor"><strong style="color: #000; font-size: 16px;">Celular </strong></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            <label for="hisCorreoTutor"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                            {!! Form::email('hisCorreoTutor', $historia->hisCorreoTutor, ['id' => 'hisCorreoTutor', 'class' => 'noUpperCase', 'maxlength' => '100']) !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('hisCalleTutor', $historia->hisCalleTutor, array('id' => 'hisCalleTutor', 'class' => 'validate','maxlength'=>'25')) !!}
                                <label for="hisCalleTutor"><strong style="color: #000; font-size: 16px;">Calle</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('hisNumeroExtTutor', $historia->hisNumeroExtTutor, array('id' => 'hisNumeroExtTutor', 'class' => 'validate','maxlength'=>'6')) !!}
                                <label for="hisNumeroExtTutor"><strong style="color: #000; font-size: 16px;">Número exterior</strong></label>
                            </div>
                        </div>
                    </div>
        
                    <div class="row">                   
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('hisNumeroIntTutor', $historia->hisNumeroIntTutor, array('id' => 'hisNumeroIntTutor', 'class' => 'validate','maxlength'=>'6')) !!}
                            <label for="hisNumeroIntTutor"><strong style="color: #000; font-size: 16px;">Número interior</strong></label>
                            </div>
                        </div>
        
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('hisColoniaTutor', $historia->hisColoniaTutor, array('id' => 'hisColoniaTutor', 'class' => 'validate','maxlength'=>'60')) !!}
                                <label for="hisColoniaTutor"><strong style="color: #000; font-size: 16px;">Colonia</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('hisCPTutor', $historia->hisCPTutor, array('id' => 'hisCPTutor', 'class' => 'validate','min'=>'0','max'=>'99999','onKeyPress="if(this.value.length==5) return false;"')) !!}
                                <label for="hisCPTutor"><strong style="color: #000; font-size: 16px;">Código Postal</strong></label>
                            </div>
                        </div>
                    </div>

                    <br>
                    @if (count($tutores) > 0)
                    <!-- TABLA DE TUTORES DEL ALUMNO. -->
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Padres de familia (Tutores)</p>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <table id="tbl-tutores" class="responsive-table display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nombre(s)</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tutores as $tutor)
                                    <tr>
                                        <td>{{$tutor['tutor']->tutNombre}}</td>
                                        <td>{{$tutor['tutor']->tutTelefono}}</td>
                                        <td>{{$tutor['tutor']->tutCorreo}}</td>

                                    </tr>                        
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
             
                    <br>
                    @else

                    @endif
                    
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">DATOS GENERALES DEL ALUMNO (A)</p>
                    </div>
                    <br>
                    <div class="row">
                        {{--  /* ----------------------------- tipo de sangre ----------------------------- */  --}}                        
                        <div class="col s12 m6 l4">
                            <label for="hisTipoSangre"><strong style="color: #000; font-size: 16px;">Tipo de sangre</strong></label>
                            <select id="hisTipoSangre" class="browser-default validate" name="hisTipoSangre" style="width: 100%;">
                                @php                                  
                                    if(old('hisTipoSangre') !== null){
                                        $hisTipoSangre = old('hisTipoSangre'); 
                                    }
                                    else{ $hisTipoSangre = $historia->hisTipoSangre; }
                                @endphp
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="O NEGATIVO" {{ $hisTipoSangre == "O NEGATIVO" ? 'selected="selected"' : '' }}>O negativo</option>
                                <option value="O POSITIVO" {{ $hisTipoSangre == "O POSITIVO" ? 'selected="selected"' : '' }}>O positivo</option>
                                <option value="A NEGATIVO" {{ $hisTipoSangre == "A NEGATIVO" ? 'selected="selected"' : '' }}>A negativo</option>
                                <option value="A POSITIVO" {{ $hisTipoSangre == "A POSITIVO" ? 'selected="selected"' : '' }}>A positivo</option>
                                <option value="B NEGATIVO" {{ $hisTipoSangre == "B NEGATIVO" ? 'selected="selected"' : '' }}>B negativo</option>
                                <option value="B POSITIVO" {{ $hisTipoSangre == "B POSITIVO" ? 'selected="selected"' : '' }}>B positivo</option>
                                <option value="AB NEGATIVO" {{ $hisTipoSangre == "AB NEGATIVO" ? 'selected="selected"' : '' }}>AB negativo</option>
                                <option value="AB POSITIVO" {{ $hisTipoSangre == "AB POSITIVO" ? 'selected="selected"' : '' }}>AB positivo</option>                           
                            </select>
                        </div>

                        {{--  /* -------------------------------- alergias -------------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="hisAlergias"><strong style="color: #000; font-size: 16px;">Alergias</strong></label>
                                @php                                  
                                    if(old('hisAlergias') !== null){
                                        $hisAlergias = old('hisAlergias'); 
                                    }
                                    else{ $hisAlergias = $historia->hisAlergias; }
                                @endphp
                                {!! Form::text('hisAlergias', $hisAlergias, array('id' => 'hisAlergias', 'class' => '')) !!}
                            </div>
                        </div>
                        {{--  /* ------------------------- escuela de procendencia ------------------------ */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                @php                                  
                                    if(old('hisEscuelaProcedencia') !== null){
                                        $hisEscuelaProcedencia = old('hisEscuelaProcedencia'); 
                                    }
                                    else{ $hisEscuelaProcedencia = $historia->hisEscuelaProcedencia; }
                                @endphp
                                <label for="hisEscuelaProcedencia"><strong style="color: #000; font-size: 16px;">Escuela de procedencia</strong></label>
                                {!! Form::text('hisEscuelaProcedencia', $hisEscuelaProcedencia, array('id' => 'hisEscuelaProcedencia', 'class' => 'validate', 'maxlength'=>'80')) !!}
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        {{--  /* -------------------------- Último grado cursado -------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                @php                                  
                                    if(old('hisUltimoGrado') !== null){
                                        $hisUltimoGrado = old('hisUltimoGrado'); 
                                    }
                                    else{ $hisUltimoGrado = $historia->hisUltimoGrado; }
                                @endphp
                                <label for="hisUltimoGrado"><strong style="color: #000; font-size: 16px;">Último grado cursado</strong></label>
                                {!! Form::text('hisUltimoGrado', $hisUltimoGrado, array('id' => 'hisUltimoGrado', 'class' => 'validate', 'maxlength'=>'20')) !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <label for="hisIngresoSecundaria"><strong style="color: #000; font-size: 16px;">Grado al que se inscribe (primer ingreso a Bachiller) *</strong></label>
                            <select id="hisIngresoSecundaria" class="browser-default" name="hisIngresoSecundaria" style="width: 100%;">
                                @php                                  
                                    if(old('hisIngresoSecundaria') !== null){
                                        $hisIngresoSecundaria = old('hisIngresoSecundaria'); 
                                    }
                                    else{ $hisIngresoSecundaria = $historia->hisIngresoSecundaria; }
                                @endphp
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="1" {{ $hisIngresoSecundaria == "1" ? 'selected="selected"' : '' }}>1</option>
                                <option value="2" {{ $hisIngresoSecundaria == "2" ? 'selected="selected"' : '' }}>2</option>
                                <option value="3" {{ $hisIngresoSecundaria == "3" ? 'selected="selected"' : '' }}>3</option>

                            </select>
                        </div>

                        {{--  /* -------------- ¿Ha recursado algún año o se lo han sugerido? ------------- */  --}}
                        <div class="col s12 m6 l4">
                            <label for="hisRecursado"><strong style="color: #000; font-size: 16px;">¿Ha recursado algún año o se lo han sugerido?</strong></label>
                            <select id="hisRecursado" class="browser-default" name="hisRecursado" style="width: 100%;">
                                @php                                  
                                    if(old('hisRecursado') !== null){
                                        $hisRecursado = old('hisRecursado'); 
                                    }
                                    else{ $hisRecursado = $historia->hisRecursado; }
                                @endphp
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $hisRecursado == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $hisRecursado == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l12">
                            <div id="detalleRecursamiento" class="input-field" style="display: none">        
                                @php                                  
                                    if(old('hisRecursadoDetalle') !== null){
                                        $hisRecursadoDetalle = old('hisRecursadoDetalle'); 
                                    }
                                    else{ $hisRecursadoDetalle = $historia->hisRecursadoDetalle; }
                                @endphp                 
                                <label for="hisRecursadoDetalle"><strong style="color: #000; font-size: 16px;">Detalle de año cursado</strong></label>
                                {!! Form::text('hisRecursadoDetalle', $hisRecursadoDetalle, array('id' => 'hisRecursadoDetalle', 'class' => 'validate')) !!}
                            </div>
                        </div>                       
                    </div>

                </div>

                {{-- FAMILIARES BAR --}}
                @include('bachiller.historia_clinica.familiares')
                
                {{--  EMBARAZO Y NACIMIENTO   --}}
                @include('bachiller.historia_clinica.embarazo')

                {{--  HISTORIA MEDICA   --}}
                @include('bachiller.historia_clinica.medica')

                {{--  HÁBITOS E HIGIENE  --}}
                @include('bachiller.historia_clinica.habitos')

                {{--  HISTORIA DEL DESARROLLO  --}}
                @include('bachiller.historia_clinica.desarrollo')

                {{--  ANTECEDENTES HEREDO FAMILIARES  --}}
                @include('bachiller.historia_clinica.heredo')

                {{--  RELACIONES SOCIALES  --}}
                @include('bachiller.historia_clinica.sociales')

                {{-- CONDUCTA  --}}
                @include('bachiller.historia_clinica.conducta')

                {{-- ACTIVIDADES QUE REALIZA  --}}
                @include('bachiller.historia_clinica.actividades')

                


            </div>
            <input type="hidden" name="empleado_id" id="empleado_id" value="">
            <div class="card-action">
                {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit', 'onclick' => 'this.form.submit(); this.disabled=true;']) !!}
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
@include('bachiller.scripts.funcionesAuxiliares')
@include('bachiller.scripts.municipios')
@include('bachiller.scripts.estados')

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


        /*
            * SECUNDARIA DE PROCEDENCIA.
            */

            var secundaria_pais_id = $('#paisSecundariaId').val();
            secundaria_pais_id && getEstados(secundaria_pais_id, 'estado_secundaria_id');
            $("#paisSecundariaId").on('change', function() {
                secundaria_pais_id = $('#paisSecundariaId').val();
                secundaria_pais_id && getEstados(secundaria_pais_id, 'estado_secundaria_id');
            });

            var secundaria_estado_id = $('#estado_secundaria_id').val();
            secundaria_estado_id && getMunicipios(secundaria_estado_id, 'municipio_secundaria_id');
            $("#estado_secundaria_id").on('change', function() {
                secundaria_estado_id = $('#estado_secundaria_id').val();
                secundaria_estado_id && getMunicipios(secundaria_estado_id, 'municipio_secundaria_id');
            });

            var secundaria_municipio_id = $('#municipio_secundaria_id').val();
            secundaria_municipio_id && getSecundaria(secundaria_municipio_id, 'secundaria_id');
            $("#municipio_secundaria_id").on('change', function() {
                secundaria_municipio_id = $('#municipio_secundaria_id').val();
                secundaria_municipio_id && getSecundaria(secundaria_municipio_id, 'secundaria_id');
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
            prepa_estado_id && getMunicipios(prepa_estado_id, 'municipios_prepa_id');
            $("#estado_prepa_id").on('change', function() {
                prepa_estado_id = $('#estado_prepa_id').val();
                prepa_estado_id && getMunicipios(prepa_estado_id, 'municipios_prepa_id');
            });

            var prepa_municipio_id = $('#municipios_prepa_id').val();
            prepa_municipio_id && getPreparatorias(prepa_municipio_id, 'preparatoria_id');
            $("#municipios_prepa_id").on('change', function() {
                prepa_municipio_id = $('#municipios_prepa_id').val();
                prepa_municipio_id && getPreparatorias(prepa_municipio_id, 'preparatoria_id');
            });

              //CHECKBOX "Definir secundaria después"
              $('#secunPorDefinir').on('click', function() {
                var secunPorDefinir = $(this);
                if(secunPorDefinir.is(':checked')) {
                    $("#paisSecundariaId").attr('disabled', true).val(0).select2();
                    $("#estado_secundaria_id").empty().append(new Option('SELECCIONE UNA OPCIÓN', '')).attr('disabled', true).select2();
                    $("#municipio_secundaria_id").empty().append(new Option('SELECCIONE UNA OPCIÓN', '')).attr('disabled', true).select2();
                    $('#secundaria_id').empty()
                    .append(new Option('* POR DEFINIR', 0));
                } else {
                    $('#paisSecundariaId').removeAttr('disabled').select2();
                    $('#estado_secundaria_id').removeAttr('disabled').select2();
                    $('#municipio_secundaria_id').removeAttr('disabled').select2();
                    $('#secundaria_id').empty()
                    .append(new Option('SELECCIONE UNA OPCIÓN', ''));
                }
            });


            //CHECKBOX "Definir preparatoria después"
            $('#prepaPorDefinir').on('click', function() {
                var prepaPorDefinir = $(this);
                if(prepaPorDefinir.is(':checked')) {
                    $("#paisPrepaId").attr('disabled', true).val(0).select2();
                    $("#estado_prepa_id").empty().append(new Option('SELECCIONE UNA OPCIÓN', '')).attr('disabled', true).select2();
                    $("#municipios_prepa_id").empty().append(new Option('SELECCIONE UNA OPCIÓN', '')).attr('disabled', true).select2();
                    $('#preparatoria_id').empty()
                    .append(new Option('* POR DEFINIR', 0));
                } else {
                    $('#paisPrepaId').removeAttr('disabled').select2();
                    $('#estado_prepa_id').removeAttr('disabled').select2();
                    $('#municipios_prepa_id').removeAttr('disabled').select2();
                    $('#preparatoria_id').empty()
                    .append(new Option('SELECCIONE UNA OPCIÓN', ''));
                }
            });

    });
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