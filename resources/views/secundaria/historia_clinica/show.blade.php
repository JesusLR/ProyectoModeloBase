@extends('layouts.dashboard')

@section('template_title')
Secundaria expediente
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{url('secundaria_historia_clinica')}}" class="breadcrumb">Lista de expedientes</a>
<a href="{{url('secundaria_historia_clinica/'.$historia->id)}}" class="breadcrumb">Ver expediente</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title"> DATOS DE ENTREVISTA INICIAL #{{$historia->id}}</span>

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
                    <br>
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
                                {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                                <label for="perCurp"><strong style="color: #000; font-size: 16px;">Curp</strong></label>
                            </div>                           
                        </div>
    
                        <div class="col s12 m6 l4">
                            <div class="col s12 m6 l6">
                                    <label for="aluNivelIngr"><strong style="color: #000; font-size: 16px;">Nivel de ingreso</strong></label>
                                    <div style="position:relative;">
                                        <select id="aluNivelIngr" disabled class="browser-default validate select2" required name="aluNivelIngr" style="width: 100%;">
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
                                {!! Form::number('aluGradoIngr', $alumno->aluGradoIngr, array('id' => 'aluGradoIngr', 'class' => 'validate','required','min'=>'1','max'=>'3','onKeyPress="if(this.value.length>1) return false;"', 'readonly')) !!}
                                <label for="aluGradoIngr"><strong style="color: #000; font-size: 16px;">Grado Ingreso</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            {{-- COLUMNA --}}
                            <div class="col s12 m6 l6">
                                <label for="perSexo"><strong style="color: #000; font-size: 16px;">Sexo</strong></label>
                                <input type="text" name="" id="" readonly @if($persona->perSexo == "M") value="HOMBRE" @else value="MUJER" @endif>                                
                            </div>
                            <div class="col s12 m6 l6">
                                <label for="perFechaNac"><strong style="color: #000; font-size: 16px;">Fecha de nacimiento</strong></label>
                                {!! Form::date('perFechaNac',  $persona->perFechaNac, array('id' => 'perFechaNac', 'class' => ' validate','required', 'readonly')) !!}
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
                            <input type="text" name="" id="" readonly value="{{$alumno->sec_tipo_escuela}}">
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('sec_nombre_ex_escuela', $alumno->sec_nombre_ex_escuela, array('id' => 'sec_nombre_ex_escuela', 'class' => 'validate','required','maxlength'=>'255', 'readonly')) !!}
                                <label for="sec_nombre_ex_escuela"><strong style="color: #000; font-size: 16px;">Nombre escuela anterior</strong></label>
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
                            {!! Form::number('perTelefono2', $persona->perTelefono2,
                                array('id' => 'perTelefono2', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"', 'readonly')) !!}
                            <label for="perTelefono2"><strong style="color: #000; font-size: 16px;">Teléfono móvil </strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">                            
                            <label for="perCorreo1"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                            {!! Form::email('perCorreo1', $persona->perCorreo1,
                                ['id' => 'perCorreo1', 'class' => 'validate', 'maxlength' => '60', 'readonly']) !!}
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
                                {!! Form::text('perDirCalle', $persona->perDirCalle, array('id' => 'perDirCalle', 'class' => 'validate','maxlength'=>'25','readonly')) !!}
                                <label for="perDirCalle"><strong style="color: #000; font-size: 16px;">Calle</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perDirNumExt', $persona->perDirNumExt, array('id' => 'perDirNumExt', 'class' => 'validate','maxlength'=>'6', 'readonly')) !!}
                                <label for="perDirNumExt"><strong style="color: #000; font-size: 16px;">Número exterior</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perDirNumInt', $persona->perDirNumInt, array('id' => 'perDirNumInt', 'class' => 'validate','maxlength'=>'6', 'readonly')) !!}
                            <label for="perDirNumInt"><strong style="color: #000; font-size: 16px;">Número interior</strong></label>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">                                
                                {!! Form::text('perDirColonia', $persona->perDirColonia, array('id' => 'perDirColonia', 'class' => 'validate','maxlength'=>'60', 'readonly')) !!}
                                <label for="perDirColonia"><strong style="color: #000; font-size: 16px;">Colonia</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('perDirCP', $persona->perDirCP, array('id' => 'perDirCP', 'class' => 'validate','min'=>'0','max'=>'99999','onKeyPress="if(this.value.length==5) return false;"', 'readonly')) !!}
                                <label for="perDirCP"><strong style="color: #000; font-size: 16px;">Código Postal</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::number('perTelefono1', $persona->perTelefono1, array('id' => 'perTelefono1', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"', 'readonly')) !!}
                            <label for="perTelefono1"><strong style="color: #000; font-size: 16px;">Teléfono fijo </strong></label>
                            </div>
                        </div>
                    </div>

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

                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">DATOS GENERALES DEL ALUMNO (A)</p>
                    </div>
                    <br>

                    <div class="row">
                        {{--  /* ----------------------------- tipo de sangre ----------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <label for="hisTipoSangre"><strong style="color: #000; font-size: 16px;">Tipo de sangre</strong></label>
                            {!! Form::text('hisIngresoSecundaria', $historia->hisTipoSangre, array('readonly' => 'true')) !!}                           
                        </div>

                        {{--  /* -------------------------------- alergias -------------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="hisAlergias"><strong style="color: #000; font-size: 16px;">Alergias</strong></label>
                                {!! Form::text('hisAlergias', $historia->hisAlergias, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{--  /* ------------------------- escuela de procendencia ------------------------ */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="hisEscuelaProcedencia"><strong style="color: #000; font-size: 16px;">Escuela de procedencia</strong></label>
                                {!! Form::text('hisEscuelaProcedencia', $historia->hisEscuelaProcedencia,
                                array('readonly' => 'true')) !!}
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        {{--  /* -------------------------- Último grado cursado -------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="hisUltimoGrado"><strong style="color: #000; font-size: 16px;">Último grado cursado</strong></label>
                                {!! Form::text('hisUltimoGrado', $historia->hisUltimoGrado, array('readonly' => 'true'))
                                !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <label for="hisIngresoSecundaria"><strong style="color: #000; font-size: 16px;">Grado al que se inscribe (primer ingreso a Secundaria)</strong></label>
                            {!! Form::text('hisIngresoSecundaria', $historia->hisIngresoSecundaria, array('readonly'
                                => 'true')) !!}
                        </div>

                        {{--  /* -------------- ¿Ha recursado algún año o se lo han sugerido? ------------- */  --}}
                        <div class="col s12 m6 l4">
                            <label for="hisRecursado"><strong style="color: #000; font-size: 16px;">¿Ha recursado algún año o se lo han sugerido?</strong></label>
                            {!! Form::text('hisIngresoSecundaria', $historia->hisRecursado, array('readonly'
                                => 'true')) !!}
                          
                        </div>
                        <div class="col s12 m6 l12">
                            <div id="detalleRecursamiento" class="input-field" style="display: none">
                                <label for="detalleRecursamiento"><strong style="color: #000; font-size: 16px;">Detalle de año cursado</strong></label>
                                {!! Form::text('hisRecursadoDetalle', $historia->hisRecursadoDetalle, array('readonly'
                                => 'true')) !!}
                            </div>
                        </div>
                    </div>

                </div>

                {{-- FAMILIARES BAR --}}
                <div id="familiares">
                    <br>
                    
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Datos de la madre</p>
                    </div>
                    <div class="row">
                        {{--  nombres de la madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famNombresMadre', $familia->famNombresMadre, array('readonly' => 'true')) !!}
                                <label for="famNombresMadre"><strong style="color: #000; font-size: 16px;">Nombre(s)</strong></label>
                            </div>
                        </div>
                
                        {{--  Apellido parterno madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famApellido1Madre', $familia->famApellido1Madre, array('readonly' => 'true')) !!}
                                <label for="famApellido1Madre"><strong style="color: #000; font-size: 16px;">Primer Apellido</strong></label>
                            </div>
                        </div>
                
                        {{--  apellido materno madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famApellido2Madre', $familia->famApellido2Madre, array('readonly' => 'true')) !!}
                                <label for="famApellido2Madre"><strong style="color: #000; font-size: 16px;">Segundo Apellido</strong></label>
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  fecha de nacimiento de la madre   --}}
                        <div class="col s12 m6 l4">
                            <label for="famFechaNacimientoMadre"><strong style="color: #000; font-size: 16px;">Fecha de nacimiento</strong></label>
                            {!! Form::date('famFechaNacimientoMadre', $familia->famFechaNacimientoMadre, array('readonly' => 'true')) !!}
                        </div>
                
                        <div class="col s12 m6 l4">
                            <label for="paisMadre_Id"><strong style="color: #000; font-size: 16px;">País</strong></label>
                            <select id="paisMadre_Id" class="browser-default validate" required name="paisMadre_Id" style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($paises as $pais)
                                <option value="{{$pais->id}}" {{ $pais->id == $paisMadre->id ? 'selected="selected"' : '' }}>
                                    {{$pais->paisNombre}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="estadoMadre_id"><strong style="color: #000; font-size: 16px;">Estado</strong></label>
                            <select id="estadoMadre_id" class="browser-default validate" required name="estadoMadre_id"
                                style="width: 100%; pointer-events: none" data-estado-id="{{$estadoMadre->id}}">
                              
                            </select>
                        </div>
                
                    </div>
                
                
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="municipioMadre_id"><strong style="color: #000; font-size: 16px;">Municipio</strong></label>
                            <select id="municipioMadre_id" class="browser-default validate" required name="municipioMadre_id"
                                style="width: 100%; pointer-events: none" data-municipio-id="{{$municipioMadre->id}}">
                            
                            </select>
                        </div>
                
                        {{--  ocupación madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famOcupacionMadre', $familia->famOcupacionMadre, array('readonly' => 'true')) !!}
                                <label for="famOcupacionMadre"><strong style="color: #000; font-size: 16px;">Ocupación</strong></label>
                            </div>
                        </div>
                        {{--  empresa donde labora la madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famEmpresaMadre', $familia->famEmpresaMadre, array('readonly' => 'true')) !!}
                                <label for="famEmpresaMadre"><strong style="color: #000; font-size: 16px;">Empresa donde labora</strong></label>
                            </div>
                        </div>
                
                    </div>
                
                    <div class="row">
                        {{--  Celular de la madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('famCelularMadre', $familia->famCelularMadre, array('readonly' => 'true')) !!}
                                <label for="famCelularMadre"><strong style="color: #000; font-size: 16px;">Celular</strong></label>
                            </div>
                        </div>
                
                        {{--  telefono madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('famTelefonoMadre', $familia->famTelefonoMadre, array('readonly' => 'true')) !!}                
                                <label for="famTelefonoMadre"><strong style="color: #000; font-size: 16px;">Télefono</strong></label>
                            </div>
                        </div>
                        {{--  correo de la madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="famEmailMadre"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                                {!! Form::email('famEmailMadre', $familia->famEmailMadre, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                    </div>
                
                    <div class="row">
                        {{--  relacion con el niño   --}}
                        <div class="col s12 m6 l4">
                            <label for="famRelacionMadre"><strong style="color: #000; font-size: 16px;">Relación con el niño</strong></label>
                            <select id="famRelacionMadre" class="browser-default" name="famRelacionMadre" style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="ESTABLE" {{ $familia->famRelacionMadre == "ESTABLE" ? 'selected="selected"' : '' }}>Estable</option>
                                <option value="INESTABLE" {{ $familia->famRelacionMadre == "INESTABLE" ? 'selected="selected"' : '' }}>Inestable</option>
                                <option value="CONFLICTIVA" {{ $familia->famRelacionMadre == "CONFLICTIVA" ? 'selected="selected"' : '' }}>Conflictiva</option>
                            </select>
                        </div>
                
                        {{--  frecuencia de la realcion madre  --}}
                        <div class="col s12 m6 l4" id="divFrecuencia">
                            <label for="famRelacionFrecuenciaMadre"><strong style="color: #000; font-size: 16px;">Frecuencia de la relación con el niño</strong></label>
                            <select id="famRelacionFrecuenciaMadre" class="browser-default" name="famRelacionFrecuenciaMadre"
                                style="width: 100%; pointer-events: none" required>
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="MUCHA" {{ $familia->famRelacionFrecuenciaMadre == "MUCHA" ? 'selected="selected"' : '' }}>Mucha</option>
                                <option value="POCA" {{ $familia->famRelacionFrecuenciaMadre == "POCA" ? 'selected="selected"' : '' }}>Poca</option>
                                <option value="NINGUNA COMUNICACIÓN" {{ $familia->famRelacionFrecuenciaMadre == "NINGUNA COMUNICACIÓN" ? 'selected="selected"' : '' }}>Ninguna comunicación</option>
                            </select>
                        </div>
                    </div>
                
                
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Datos del padre</p>
                    </div>
                    <div class="row">
                        {{--  nombres del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famNombresPadre', $familia->famNombresPadre, array('readonly' => 'true')) !!}
                                <label for="famNombresPadre"><strong style="color: #000; font-size: 16px;">Nombre(s)</strong></label>

                            </div>
                        </div>
                
                        {{--  Apellido parterno del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famApellido1Padre', $familia->famApellido1Padre, array('readonly' => 'true')) !!}
                                <label for="famApellido1Padre"><strong style="color: #000; font-size: 16px;">Primer Apellido</strong></label>
                            </div>
                        </div>
                
                        {{--  apellido materno del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famApellido2Padre', $familia->famApellido2Padre, array('readonly' => 'true')) !!}
                                <label for="famApellido2Padre"><strong style="color: #000; font-size: 16px;">Segundo Apellido</strong></label>
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  fecha de nacimiento del padre   --}}
                        <div class="col s12 m6 l4">
                            <label for="famFechaNacimientoPadre"><strong style="color: #000; font-size: 16px;">Fecha de nacimiento</strong></label>
                            {!! Form::date('famFechaNacimientoPadre', $familia->famFechaNacimientoPadre, array('readonly' => 'true')) !!}
                        </div>
                
                        <div class="col s12 m6 l4">
                            <label for="paisPadre_Id"><strong style="color: #000; font-size: 16px;">País</strong></label>
                            <select id="paisPadre_Id" class="browser-default validate" required name="paisPadre_Id" style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($paises as $pais)
                                <option value="{{$pais->id}}" {{ $pais->id == $paisPadre->id ? 'selected="selected"' : '' }}>
                                    {{$pais->paisNombre}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <label for="estadoPadre_id"><strong style="color: #000; font-size: 16px;">Estado</strong></label>
                            <select id="estadoPadre_id" class="browser-default validate" required name="estadoPadre_id"
                                style="width: 100%; pointer-events: none" data-estado-id="{{$estadoPadre->id}}">
                            </select>
                        </div>        
                    </div>
                
                
                    <div class="row">
                        {{--  municio del padre   --}}
                        <div class="col s12 m6 l4">
                            <label for="municipioPadre_id"><strong style="color: #000; font-size: 16px;">Municipio</strong></label>
                            <select id="municipioPadre_id" class="browser-default validate" required name="municipioPadre_id"
                                style="width: 100%; pointer-events: none" data-municipio-id="{{$municipioPadre->id}}">
                            </select>
                        </div>
                
                        {{--  ocupación del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famOcupacionPadre', $familia->famOcupacionPadre, array('readonly' => 'true')) !!}
                                <label for="famOcupacionPadre"><strong style="color: #000; font-size: 16px;">Ocupación</strong></label>
                            </div>
                        </div>
                        {{--  empresa donde labora el padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famEmpresaPadre', $familia->famEmpresaPadre, array('readonly' => 'true')) !!}
                                <label for="famEmpresaPadre"><strong style="color: #000; font-size: 16px;">Empresa donde labora</strong></label>
                            </div>
                        </div>        
                    </div>
                
                    <div class="row">
                        {{--  Celular del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('famCelularPadre', $familia->famCelularPadre, array('readonly' => 'true')) !!}
                                <label for="famCelularPadre"><strong style="color: #000; font-size: 16px;">Celular</strong></label>
                            </div>
                        </div>
                
                        {{--  telefono del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('famTelefonoPadre', $familia->famTelefonoPadre, array('readonly' => 'true')) !!}                
                                <label for="famTelefonoPadre"><strong style="color: #000; font-size: 16px;">Télefono</strong></label>
                            </div>
                        </div>
                        {{--  correo del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="famEmailPadre"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                                {!! Form::email('famEmailPadre', $familia->famEmailPadre, array('readonly' => 'true')) !!}
                            </div>
                        </div>        
                    </div>
                    <div class="row">
                        {{--  relacion con el niño   --}}
                        <div class="col s12 m6 l4">
                            <label for="famRelacionPadre"><strong style="color: #000; font-size: 16px;">Relación con el niño</strong></label>
                            <select id="famRelacionPadre" class="browser-default" name="famRelacionPadre" style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="ESTABLE" {{ $familia->famRelacionPadre == "ESTABLE" ? 'selected="selected"' : '' }}>Estable</option>
                                <option value="INESTABLE" {{ $familia->famRelacionPadre == "INESTABLE" ? 'selected="selected"' : '' }}>Inestable</option>
                                <option value="CONFLICTIVA" {{ $familia->famRelacionPadre == "CONFLICTIVA" ? 'selected="selected"' : '' }}>Conflictiva</option>
                            </select>
                        </div>
                
                        {{--  frecuencia de la realcion   --}}
                        <div class="col s12 m6 l4" id="divFrecuenciaPadre">
                            <label for="famRelacionFrecuenciaPadre"><strong style="color: #000; font-size: 16px;">Frecuencia de la relación con el niño</strong></label>
                            <select id="famRelacionFrecuenciaPadre" class="browser-default" name="famRelacionFrecuenciaPadre"
                                style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="MUCHA" {{ $familia->famRelacionFrecuenciaPadre == "MUCHA" ? 'selected="selected"' : '' }}>Mucha</option>
                                <option value="POCA" {{ $familia->famRelacionFrecuenciaPadre == "POCA" ? 'selected="selected"' : '' }}>Poca</option>
                                <option value="NINGUNA COMUNICACIÓN" {{ $familia->famRelacionFrecuenciaPadre == "NINGUNA COMUNICACIÓN" ? 'selected="selected"' : '' }}>Ninguna comunicación</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Datos generales</p>
                    </div>
                
                    <div class="row">
                        {{--  Estado civil de los padres  --}}
                        <div class="col s12 m6 l4">                            
                            <label for="famEstadoCivilPadres"><strong style="color: #000; font-size: 16px;">Estado civil de los padres</strong></label>
                            <select id="famEstadoCivilPadres" class="browser-default" name="famEstadoCivilPadres" style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="CASADOS" {{ $familia->famEstadoCivilPadres == "CASADOS" ? 'selected="selected"' : '' }}>Casados</option>
                                <option value="UNIÓN LIBRE" {{ $familia->famEstadoCivilPadres == "UNIÓN LIBRE" ? 'selected="selected"' : '' }}>Unión libre</option>
                                <option value="DIVORCIADOS" {{ $familia->famEstadoCivilPadres == "DIVORCIADOS" ? 'selected="selected"' : '' }}>Divorciados</option>
                                <option value="VIUDO/A" {{ $familia->famEstadoCivilPadres == "VIUDO/A" ? 'selected="selected"' : '' }}>Viudo/a</option>
                            </select>
                        </div>
                
                        {{--  donde vive el niño   --}}
                        <div class="col s12 m6 l4" id="divSeparado" style="display: none">
                            <div class="input-field">
                                {!! Form::text('famSeparado', $familia->famSeparado, array('readonly' => 'true')) !!}
                                <label for="famSeparado"><strong style="color: #000; font-size: 16px;">¿Con cuál de los padres vive el niño?</strong></label>
                            </div>
                        </div>
                        <script>
                            if($('select[name=famEstadoCivilPadres]').val() == "DIVORCIADOS"){
                                $("#divSeparado").show(); 
                                $("#famSeparado").attr('required', '');
                            }else{
                                $("#famSeparado").removeAttr('required');
                                $("#divSeparado").hide();         
                            }
                        </script>
                
                        {{--  religion   --}}
                        <div class="col s12 m6 l4" id="divReligion">
                            <div class="input-field">
                                {!! Form::text('famReligion', $familia->famReligion, array('readonly' => 'true')) !!}
                                <label for="famReligion"><strong style="color: #000; font-size: 16px;">Religion</strong></label>
                            </div>
                        </div>
                    </div>
                
                    <p>NOTA: En caso de que alguno de los padres; o bien ambos, tuvieran algún grado de restricción en su relación
                        con el alumno, será necesario presentar la notificación oficial y especificar del caso a la Dirección.</p>
                
                    <div class="row">
                        {{--  nombre de algun familiar o conocido   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famExtraNombre', $familia->famExtraNombre, array('readonly' => 'true')) !!}
                                <label for="famExtraNombre"><strong style="color: #000; font-size: 16px;">Nombre de algun familiar o conocido</strong></label>
                            </div>
                        </div>
                
                        {{--  telefono del familiar o conocido   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('famTelefonoExtra', $familia->famTelefonoExtra, array('readonly' => 'true')) !!}
                                <label for="famTelefonoExtra"><strong style="color: #000; font-size: 16px;">Télefono del familiar o conocido</strong></label>
                            </div>
                        </div>
                    </div>
                
                    <p>Nombre completo de personas autorizadas para recoger al alumno en la escuela:</p>
                    <div class="row">
                        {{--  persona autorizada 1   --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::text('famAutorizado1', $familia->famAutorizado1, array('readonly' => 'true')) !!}
                                <label for="famAutorizado1"><strong style="color: #000; font-size: 16px;">Persona autorizada 1</strong></label>
                            </div>
                        </div>
                        {{--  persona autorizada 2   --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::text('famAutorizado2', $familia->famAutorizado2, array('readonly' => 'true')) !!}
                                <label for="famAutorizado2"><strong style="color: #000; font-size: 16px;">Persona autorizada 2</strong></label>
                            </div>
                        </div>
                
                    </div>
                
                    <p>Integrantes de la familia:</p>
                
                    {{--  integrante 1   --}}
                    <div class="row">
                        {{--  nombre del integrante 1   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famIntegrante1', $familia->famIntegrante1, array('readonly' => 'true')) !!}
                                <label for="famIntegrante1"><strong style="color: #000; font-size: 16px;">Integrante 1</strong></label>
                            </div>
                        </div>
                
                        {{--  parentesco del integrante 1   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famParentesco1', $familia->famParentesco1, array('readonly' => 'true')) !!}
                                <label for="famParentesco1"><strong style="color: #000; font-size: 16px;">Parentesco</strong></label>
                            </div>
                        </div>
                
                        {{--  edad del integrante 1   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::number('famEdadIntegrante1', $familia->famEdadIntegrante1, array('readonly' => 'true')) !!}
                                <label for="famEdadIntegrante1"><strong style="color: #000; font-size: 16px;">Edad</strong></label>
                            </div>
                        </div>
                
                        {{--  escuela y grado del integrante 1   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famEscuelaGrado1', $familia->famEscuelaGrado1, array('readonly' => 'true')) !!}
                                <label for="famEscuelaGrado1"><strong style="color: #000; font-size: 16px;">Escuela y grado</strong></label>
                            </div>
                        </div>
                    </div>
                
                    {{--  integrante 2   --}}
                    <div class="row">
                        {{--  nombre del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famIntegrante2', $familia->famIntegrante2, array('readonly' => 'true')) !!}
                                <label for="famIntegrante2"><strong style="color: #000; font-size: 16px;">Integrante 1</strong></label>
                            </div>
                        </div>
                
                        {{--  parentesco del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famParentesco2', $familia->famParentesco2, array('readonly' => 'true')) !!}
                                <label for="famParentesco2"><strong style="color: #000; font-size: 16px;">Parentesco</strong></label>
                            </div>
                        </div>
                
                        {{--  edad del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::number('famEdadIntegrante2', $familia->famEdadIntegrante2, array('readonly' => 'true')) !!}
                                <label for="famEdadIntegrante2"><strong style="color: #000; font-size: 16px;">Edad</strong></label>
                            </div>
                        </div>
                
                        {{--  escuela y grado del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famEscuelaGrado2', $familia->famEscuelaGrado2, array('readonly' => 'true')) !!}
                                <label for="famEscuelaGrado2"><strong style="color: #000; font-size: 16px;">Escuela y grado</strong></label>
                            </div>
                        </div>
                    </div>
                
                    {{--  integrante 3   --}}
                    <div class="row">
                        {{--  nombre del integrante 3   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famIntregrante3', $familia->famIntregrante3, array('readonly' => 'true')) !!}
                                <label for="famIntregrante3"><strong style="color: #000; font-size: 16px;">Integrante 1</strong></label>
                            </div>
                        </div>
                
                        {{--  parentesco del integrante 3   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famParentesco3', $familia->famParentesco3, array('readonly' => 'true')) !!}
                                <label for="famParentesco3"><strong style="color: #000; font-size: 16px;">Parentesco</strong></label>
                            </div>
                        </div>
                
                        {{--  edad del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::number('famEdadIntregrante3', $familia->famEdadIntregrante3, array('readonly' => 'true')) !!}
                                <label for="famEdadIntregrante3"><strong style="color: #000; font-size: 16px;">Edad</strong></label>
                            </div>
                        </div>
                
                        {{--  escuela y grado del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famEscuelaGrado3', $familia->famEscuelaGrado3, array('readonly' => 'true')) !!}
                                <label for="famEscuelaGrado3"><strong style="color: #000; font-size: 16px;">Escuela y grado</strong></label>
                            </div>
                        </div>
                    </div>
                
                </div> 
                
                

                {{--  EMBARAZO Y NACIMIENTO   --}}
                <div id="embarazo">

                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">HISTORIAL DEL EMBARAZO Y DEL NACIMIENTO</p>
                    </div>
                    <div class="row">
                        {{--  Embarazo número   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('nacNumEmbarazo', $embarazo->nacNumEmbarazo, array('readonly' => 'true')) !!}
                                <label for="nacNumEmbarazo"><strong style="color: #000; font-size: 16px;">Embarazo número</strong></label>
                            </div>
                        </div>
                
                        {{--  Embarazo planeado   --}}
                        <div class="col s12 m6 l4">
                            <label for="nacEmbarazoPlaneado"><strong style="color: #000; font-size: 16px;">Embarazo planeado</strong></label>
                            <select id="nacEmbarazoPlaneado" required class="browser-default" name="nacEmbarazoPlaneado"
                                style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $embarazo->nacEmbarazoPlaneado == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $embarazo->nacEmbarazoPlaneado == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  Embarazo a término   --}}
                        <div class="col s12 m6 l4">
                            <label for="nacEmbarazoTermino"><strong style="color: #000; font-size: 16px;">Embarazo a término</strong></label>
                            <select id="nacEmbarazoTermino" required class="browser-default" name="nacEmbarazoTermino"
                                style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $embarazo->nacEmbarazoTermino == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $embarazo->nacEmbarazoTermino == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Duración del embarazo   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            <label for="nacEmbarazoDuracion"><strong style="color: #000; font-size: 16px;">Duración del embarazo</strong></label>
                            {!! Form::text('nacEmbarazoDuracion', $embarazo->nacEmbarazoDuracion, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        {{--  Parto   --}}
                        <div class="col s12 m6 l4">
                            <label for="NacParto"><strong style="color: #000; font-size: 16px;">Parto</strong></label>
                            <select id="NacParto" class="browser-default validate" required name="NacParto"
                                style="width: 100%; pointer-events: none">
                                <option value="" {{ $embarazo->NacParto == "" ? 'selected="selected"' : '' }} disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="NATURAL" {{ $embarazo->NacParto == "NATURAL" ? 'selected="selected"' : '' }}>Natural</option>
                                <option value="CESÁREA" {{ $embarazo->NacParto == "CESÁREA" ? 'selected="selected"' : '' }}>Cesárea</option>
                                <option value="FÓRCEPS" {{ $embarazo->NacParto == "FÓRCEPS" ? 'selected="selected"' : '' }}>Fórceps</option>              
                
                            </select>
                        </div>
                
                        {{--  peso al nacer   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('nacPeso', $embarazo->nacPeso, array('readonly' => 'true')) !!}
                                <label for="nacPeso"><strong style="color: #000; font-size: 16px;">Peso al nacer</strong></label>
                            </div>
                        </div>
                    </div>
                
                
                    <div class="row">
                        {{--  medida al nacer   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('nacMedia', $embarazo->nacMedia, array('readonly' => 'true')) !!}
                                <label for="nacMedia"><strong style="color: #000; font-size: 16px;">Medida al nacer</strong></label>
                            </div>
                        </div>
                
                        {{--  APGAR  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('nacApgar', $embarazo->nacApgar, array('readonly' => 'true')) !!}
                                <label for="nacApgar"><strong style="color: #000; font-size: 16px;">APGAR</strong></label>
                            </div>
                        </div>
                    </div>
                
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Complicaciones</p>
                    </div>
                    <div class="row">
                        {{--  durante el embarazo   --}}
                        <div class="col s12 m6 l4">
                            <label for="nacComplicacionesEmbarazo"><strong style="color: #000; font-size: 16px;">Durante el embarazo</strong></label>
                            <select id="nacComplicacionesEmbarazo" required class="browser-default" name="nacComplicacionesEmbarazo"
                                style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $embarazo->nacComplicacionesEmbarazo == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $embarazo->nacComplicacionesEmbarazo == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  cuales durante el embarazo  --}}
                        <div class="col s12 m6 l8" id="divEmbarazo" style="display: none;">
                            <div class="input-field">
                                {!! Form::text('nacCualesEmbarazo', $embarazo->nacCualesEmbarazo, array('readonly' => 'true')) !!}
                                <label for="nacCualesEmbarazo"><strong style="color: #000; font-size: 16px;">¿Cuáles durante el embarazo?</strong></label>
                            </div>
                        </div>       
                    </div>
                
                    <div class="row">
                        {{--  durante el parto   --}}
                        <div class="col s12 m6 l4">
                            <label for="nacComplicacionesParto"><strong style="color: #000; font-size: 16px;">Durante el parto</strong></label>
                            <select id="nacComplicacionesParto" required class="browser-default" name="nacComplicacionesParto"
                                style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $embarazo->nacComplicacionesParto == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $embarazo->nacComplicacionesParto == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  cuales durante el parto  --}}
                        <div class="col s12 m6 l8" id="divParto" style="display: none;">
                            <div class="input-field">
                                {!! Form::text('nacCualesParto', $embarazo->nacCualesParto, array('readonly' => 'true')) !!}
                                <label for="nacCualesParto"><strong style="color: #000; font-size: 16px;">¿Cuáles durante el parto?</strong></label>
                            </div>
                        </div>       
                    </div>
                
                    <div class="row">
                        {{--  despues del nacimiento   --}}
                        <div class="col s12 m6 l4">
                            <label for="nacComplicacionDespues"><strong style="color: #000; font-size: 16px;">Después del nacimiento</strong></label>
                            <select id="nacComplicacionDespues" required class="browser-default" name="nacComplicacionDespues"
                                style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $embarazo->nacComplicacionDespues == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $embarazo->nacComplicacionDespues == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  despues del nacimiento cuales  --}}
                        <div class="col s12 m6 l8" id="divDespues" style="display: none;">
                            <div class="input-field">
                                {!! Form::text('nacCualesDespues', $embarazo->nacCualesDespues, array('readonly' => 'true')) !!}
                                <label for="nacCualesDespues"><strong style="color: #000; font-size: 16px;">¿Cuáles después del nacimiento?</strong></label>
                            </div>
                        </div>       
                    </div>
                
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Lactancia</p>
                    </div>
                    <div class="row">
                        {{--  Lactancia   --}}
                        <div class="col s12 m6 l4">
                            <label for="nacLactancia"><strong style="color: #000; font-size: 16px;">Tipo de leche</strong></label>
                            <select id="nacLactancia" required class="browser-default" name="nacLactancia"
                                style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="FÓRMULA" {{ $embarazo->nacLactancia == "FÓRMULA" ? 'selected="selected"' : '' }}>Fórmula</option>
                                <option value="MATERNA" {{ $embarazo->nacLactancia == "MATERNA" ? 'selected="selected"' : '' }}>Materna</option>
                                <option value="MIXTA" {{ $embarazo->nacLactancia == "MIXTA" ? 'selected="selected"' : '' }}>Mixta</option>
                            </select>
                        </div>
                
                        {{--  despues del nacimiento cuales  --}}
                        <div class="col s12 m6 l8" id="divLactancia" style="display: none;">
                            <div class="input-field">
                                {!! Form::text('nacActualmente', $embarazo->nacActualmente, array('readonly' => 'true')) !!}
                                <label for="nacActualmente"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                            </div>
                        </div>       
                    </div>       
                </div> 

                {{--  HISTORIA MEDICA   --}}
                <div id="medica">
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">HISTORIA MÉDICA</p>
                    </div>
                    <br>
                    <div class="row">
                        {{--  Intervenciones quirúrgicas  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="medIntervencionQuirurgicas"><strong style="color: #000; font-size: 16px;">Intervenciones quirúrgicas</strong></label>
                                {!! Form::text('medIntervencionQuirurgicas', $medica->medIntervencionQuirurgicas, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{--  Tratamientos/ medicamentos  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="medMedicamentos"><strong style="color: #000; font-size: 16px;">Tratamientos/ medicamentos</strong></label>
                                {!! Form::text('medMedicamentos', $medica->medMedicamentos, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                    </div>
                
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Padecimientos que ha sufrido o sufre el niño</p>
                    </div>
                    <div class="row">
                        {{--  Convulsiones  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medConvulsiones" id="medConvulsiones" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Convulsiones</strong></label>
                            </div>
                        </div>
                        <script>
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medConvulsiones}}' == 'CONVULSIONES'){
                                $("#medConvulsiones").prop("checked", true);
                                $("#medConvulsiones").val("CONVULSIONES");
                            }else{
                                $("#medConvulsiones").prop("checked", false);
                            }
                        </script>                        
                        
                        {{--  Problemas de audición  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medAudicion" id="medAudicion" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Problemas de audición</strong></label>
                            </div>
                        </div>
                
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medAudicion}}' == 'PROBLEMAS DE AUDICIÓN'){
                                $("#medAudicion").prop("checked", true);
                                $("#medAudicion").val("PROBLEMAS DE AUDICIÓN");
                            }else{
                                $("#medAudicion").prop("checked", false);
                            }
                        </script>
                
                        {{--  Fiebres altas  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medFiebres" id="medFiebres" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Fiebres altas</strong></label>
                            </div>
                        </div>
                
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medFiebres}}' == 'FIEBRES ALTAS'){
                                $("#medFiebres").prop("checked", true);
                                $("#medFiebres").val("FIEBRES ALTAS");
                            }else{
                                $("#medFiebres").prop("checked", false);
                            }
                        </script>
                
                        {{--  Problemas de corazón  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medProblemasCorazon" id="medProblemasCorazon" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Problemas de corazón</strong></label>
                            </div>
                        </div>
                
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medProblemasCorazon}}' == 'PROBLEMAS DE CORAZÓN'){
                                $("#medProblemasCorazon").prop("checked", true);
                                $("#medProblemasCorazon").val("PROBLEMAS DE CORAZÓN");
                            }else{
                                $("#medProblemasCorazon").prop("checked", false);
                            }
                        </script>
                    </div>
                
                
                    <div class="row">
                        {{--  Deficiencia pulmonar y bronquial  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medDeficiencia" id="medDeficiencia" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Deficiencia pulmonar y bronquial</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medDeficiencia}}' == 'DEFICIENCIA PULMONAR Y BRONQUIAL'){
                                $("#medDeficiencia").prop("checked", true);
                                $("#medDeficiencia").val("DEFICIENCIA PULMONAR Y BRONQUIAL");
                            }else{
                                $("#medDeficiencia").prop("checked", false);
                            }
                        </script>
                
                        {{--  Asma  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medAsma" id="medAsma" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Asma</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medAsma}}' == 'ASMA'){
                                $("#medAsma").prop("checked", true);
                                $("#medAsma").val("ASMA");
                            }else{
                                $("#medAsma").prop("checked", false);
                            }
                        </script>
                
                        {{--  Diabetes  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medDiabetes" id="medDiabetes" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Diabetes</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medDiabetes}}' == 'DIABETES'){
                                $("#medDiabetes").prop("checked", true);
                                $("#medDiabetes").val("DIABETES");
                            }else{
                                $("#medDiabetes").prop("checked", false);
                            }
                        </script>
                
                        {{--  Problemas gastrointestinales  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medGastrointestinales" id="medGastrointestinales" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Problemas gastrointestinales</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medGastrointestinales}}' == 'PROBLEMAS GASTROINTESTINALES'){
                                $("#medGastrointestinales").prop("checked", true);
                                $("#medGastrointestinales").val("PROBLEMAS GASTROINTESTINALES");
                            }else{
                                $("#medGastrointestinales").prop("checked", false);
                            }
                        </script>
                    </div>
                
                
                    <div class="row">
                        {{--  Accidentes  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medAccidentes" id="medAccidentes" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Accidentes</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medAccidentes}}' == 'ACCIDENTES'){
                                $("#medAccidentes").prop("checked", true);
                                $("#medAccidentes").val("ACCIDENTES");
                            }else{
                                $("#medAccidentes").prop("checked", false);
                            }
                        </script>
                
                        {{--  Epilepsia  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medEpilepsia" id="medEpilepsia" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Epilepsia</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medEpilepsia}}' == 'EPILEPSIA'){
                                $("#medEpilepsia").prop("checked", true);
                                $("#medEpilepsia").val("EPILEPSIA");
                            }else{
                                $("#medEpilepsia").prop("checked", false);
                            }
                        </script>
                
                        {{--  Problemas de riñón  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medRinion" id="medRinion" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Problemas de riñón</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medRinion}}' == 'PROBLEMAS DE RIÑON'){
                                $("#medRinion").prop("checked", true);
                                $("#medRinion").val("PROBLEMAS DE RIÑON");
                            }else{
                                $("#medRinion").prop("checked", false);
                            }
                        </script>
                
                        {{--  Problemas de la piel  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medPiel" id="medPiel" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Problemas de la piel</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medPiel}}' == 'PROBLEMAS DE LA PIEL'){
                                $("#medPiel").prop("checked", true);
                                $("#medPiel").val("PROBLEMAS DE LA PIEL");
                            }else{
                                $("#medPiel").prop("checked", false);
                            }
                        </script>
                    </div>
                
                    <div class="row">
                        {{--  Falta de coordinación motriz  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medCoordinacionMotriz" id="medCoordinacionMotriz" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Falta de coordinación motriz</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medCoordinacionMotriz}}' == 'FALTA DE COORDINACIÓN MOTRIZ'){
                                $("#medCoordinacionMotriz").prop("checked", true);
                                $("#medCoordinacionMotriz").val("FALTA DE COORDINACIÓN MOTRIZ");
                            }else{
                                $("#medCoordinacionMotriz").prop("checked", false);
                            }
                        </script>
                
                        {{--  Estreñimiento  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medEstrenimiento" id="medEstrenimiento" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Estreñimiento</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medEstrenimiento}}' == 'ESTREÑIMIENTO'){
                                $("#medEstrenimiento").prop("checked", true);
                                $("#medEstrenimiento").val("ESTREÑIMIENTO");
                            }else{
                                $("#medEstrenimiento").prop("checked", false);
                            }
                        </script>
                
                        {{--  Dificultades durante el sueño  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medDificultadesSuenio" id="medDificultadesSuenio" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Dificultades durante el sueño</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medDificultadesSuenio}}' == 'DIFICULTADES DURANTE EL SUEÑO'){
                                $("#medDificultadesSuenio").prop("checked", true);
                                $("#medDificultadesSuenio").val("DIFICULTADES DURANTE EL SUEÑO");
                            }else{
                                $("#medDificultadesSuenio").prop("checked", false);
                            }
                        </script>
                
                        {{--  Alergias  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="medAlergias" id="medAlergias" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Alergias</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medAlergias}}' == 'ALERGIAS'){
                                $("#medAlergias").prop("checked", true);
                                $("#medAlergias").val("ALERGIAS");
                                
                            }else{
                                $("#medAlergias").prop("checked", false);
                            }
                        </script>
                    </div>
                
                    <div class="row">
                        {{--  campo para especificar alergias   --}}
                        <div class="col s12 m6 l6" id="divEspecificar" style="display: none">
                            <div class="input-field">
                                <label for="medEspesificar"><strong style="color: #000; font-size: 16px;">Especifique las alergias</strong></label>
                                {!! Form::text('medEspesificar', $medica->medEspesificar, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$medica->medEspesificar}}' != ''){
                                $("#divEspecificar").show();
                                
                            }else{
                                $("#divEspecificar").hide();
                            }
                        </script>
                
                        {{--  otro   --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="medOtro"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                                {!! Form::text('medOtro', $medica->medOtro, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">General</p>
                    </div>
                
                
                    <div class="row">
                        {{--  Cuenta con seguro de gastos médicos  --}}
                        <div class="col s12 m6 l6">
                            <label for="medGastoMedico"><strong style="color: #000; font-size: 16px;">Cuenta con seguro de gastos médicos</strong></label>
                            <select id="medGastoMedico" class="browser-default" name="medGastoMedico" style="width: 100%; pointer-events: none" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $medica->medGastoMedico == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $medica->medGastoMedico == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  Nombre de la aseguradora  --}}
                        <div class="col s12 m6 l6" id="divAseguradora" style="display: none">
                            <div class="input-field">                              
                                <label for="medNombreAsegurador"><strong style="color: #000; font-size: 16px;">Nombre de la aseguradora</strong></label>
                                {!! Form::text('medNombreAsegurador', $medica->medNombreAsegurador, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Cuenta con todas las vacunas correspondientes:  --}}
                        <div class="col s12 m6 l6">
                            <label for="medVacunas"><strong style="color: #000; font-size: 16px;">Cuenta con todas las vacunas correspondientes</strong></label>
                            <select id="medVacunas" class="browser-default" name="medVacunas" style="width: 100%; pointer-events: none" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $medica->medVacunas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $medica->medVacunas == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  ¿Ha recibido algún tratamiento?  --}}
                        <div class="col s12 m6 l6">
                            <label for="medTramiento"><strong style="color: #000; font-size: 16px;">¿Ha recibido algún tratamiento?</strong></label>
                            <select id="medTramiento" class="browser-default" name="medTramiento" style="width: 100%; pointer-events: none" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="NO" {{ $medica->medTramiento == "NO" ? 'selected="selected"' : '' }}>No</option>
                                <option value="MÉDICO" {{ $medica->medTramiento == "MÉDICO" ? 'selected="selected"' : '' }}>Médico</option>
                                <option value="NEUROLÓGICO" {{ $medica->medTramiento == "NEUROLÓGICO" ? 'selected="selected"' : '' }}>Neurológico</option>
                                <option value="PSICOLÍGICO" {{ $medica->medTramiento == "PSICOLÍGICO" ? 'selected="selected"' : '' }}>Psicológico</option>
                            </select>
                        </div>
                    </div>
                
                    {{--  Asiste o asistió en cierto momento a algún tipo de terapia  --}}
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <label for="medTerapia"><strong style="color: #000; font-size: 16px;">Asiste o asistió en cierto momento a algún tipo de terapia</strong></label>
                            <select id="medTerapia" class="browser-default" name="medTerapia" style="width: 100%; pointer-events: none" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $medica->medTerapia == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $medica->medTerapia == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  ¿Por qué motivo la terapia?  --}}
                        <div class="col s12 m6 l6" id="divTerapiaMotivo" style="display: none">
                            <div class="input-field">
                                <label for="medMotivoTerapia"><strong style="color: #000; font-size: 16px;">¿Por qué motivo?</strong></label>
                                {!! Form::text('medMotivoTerapia', $medica->medMotivoTerapia, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                       
                    </div>
                
                    <div class="row">
                        {{--  Estado de salud física actual  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="medSaludFisicaAct"><strong style="color: #000; font-size: 16px;">Estado de salud física actual</strong></label>
                                {!! Form::text('medSaludFisicaAct', $medica->medSaludFisicaAct, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{--  Estado emocional actual  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="medSaludEmocialAct"><strong style="color: #000; font-size: 16px;">Estado emocional actual</strong></label>
                                {!! Form::text('medSaludEmocialAct', $medica->medSaludEmocialAct, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <br>
                </div>

                {{--  HÁBITOS E HIGIENE  --}}
                <div id="habitos">
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">HÁBITOS E HIGIENE</p>
                    </div>
                    <br>
                    <div class="row">
                        {{--  Va al baño solo  --}}
                        <div class="col s12 m6 l4">
                            <label for="habBanio"><strong style="color: #000; font-size: 16px;">¿Va al baño solo?</strong></label>
                            <select id="habBanio" class="browser-default" name="habBanio" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $habitos->habBanio == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $habitos->habBanio == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Se viste solo o hace el intento  --}}
                        <div class="col s12 m6 l4">
                            <label for="habVestimenta"><strong style="color: #000; font-size: 16px;">Se viste solo o hace el intento</strong></label>
                            <select id="habVestimenta" class="browser-default" name="habVestimenta" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $habitos->habVestimenta == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $habitos->habVestimenta == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  Luz apagada al dormir  --}}
                        <div class="col s12 m6 l4">
                            <label for="habLuz"><strong style="color: #000; font-size: 16px;">Luz apagada al dormir</strong></label>
                            <select id="habLuz" class="browser-default" name="habLuz" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $habitos->habLuz == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $habitos->habLuz == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Se calza los zapatos solo  --}}
                        <div class="col s12 m6 l4">
                            <label for="habZapatos"><strong style="color: #000; font-size: 16px;">Se calza los zapatos solo</strong></label>
                            <select id="habZapatos" class="browser-default" name="habZapatos" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $habitos->habZapatos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $habitos->habZapatos == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Come solo  --}}
                        <div class="col s12 m6 l4">
                            <label for="habCome"><strong style="color: #000; font-size: 16px;">Come solo</strong></label>
                            <select id="habCome" class="browser-default" name="habCome" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $habitos->habCome == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $habitos->habCome == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                    </div>
                
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">General</p>
                    </div>
                
                
                    
                    <div class="row">
                        {{--  ¿A qué hora se acuesta a dormir?  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="habHoraDormir"><strong style="color: #000; font-size: 16px;">¿A qué hora se acuesta a dormir?</strong></label>
                                {!! Form::text('habHoraDormir', $habitos->habHoraDormir, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{--  ¿A qué hora se levanta?  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="habHoraDespertar"><strong style="color: #000; font-size: 16px;">¿A qué hora se levanta?</strong></label>
                                {!! Form::text('habHoraDespertar', $habitos->habHoraDespertar, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                
                    <div class="row">
                        {{--  Se levanta  --}}
                        <div class="col s12 m6 l6">
                            <label for="habEstadoLevantar"><strong style="color: #000; font-size: 16px;">Se levanta</strong></label>
                            <select id="habEstadoLevantar" class="browser-default" name="habEstadoLevantar" style="width: 100%; pointer-events:none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="MALHUMORADO" {{ $habitos->habEstadoLevantar == "MALHUMORADO" ? 'selected="selected"' : '' }}>Malhumorado</option>
                                <option value="ALEGRE" {{ $habitos->habEstadoLevantar == "ALEGRE" ? 'selected="selected"' : '' }}>Alegre</option>
                                <option value="RELAJADO" {{ $habitos->habEstadoLevantar == "RELAJADO" ? 'selected="selected"' : '' }}>Relajado</option>
                                <option value="CANDADO" {{ $habitos->habEstadoLevantar == "CANDADO" ? 'selected="selected"' : '' }}>Cansado</option>
                            </select>
                        </div>
                        {{--  Recipiente donde bebe agua o leche  --}}
                        <div class="col s12 m6 l6">
                            <label for="habRecipiente"><strong style="color: #000; font-size: 16px;">Recipiente donde bebe agua o leche</strong></label>
                            <select id="habRecipiente" class="browser-default" name="habRecipiente" style="width: 100%; pointer-events:none" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="BIBERÓN" {{ $habitos->habRecipiente == "BIBERÓN" ? 'selected="selected"' : '' }}>Biberón</option>
                                <option value="VASO ENTRENADOR" {{ $habitos->habRecipiente == "VASO ENTRENADOR" ? 'selected="selected"' : '' }}>Vaso entrenador</option>
                                <option value="VASO" {{ $habitos->habRecipiente == "VASO" ? 'selected="selected"' : '' }}>Vaso</option>
                            </select>
                        </div>
                    </div>
                
                
                
                    <br>
                </div> 
                

                {{--  HISTORIA DEL DESARROLLO  --}}
                <div id="desarrollo">
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">HISTORIAL DEL DESARROLLO</p>
                    </div>
                    <br>
                    <p>Presenta o presentó dificultades en las siguientes habilidades, en comparación con otros niños de su edad:</p>
                    <div class="row">
                        {{--  Habilidades motrices gruesas (caminar, saltar, etc)  --}}
                        <div class="col s12 m6 l3">
                            <label for="desMotricesGruesas"><strong style="color: #000; font-size: 16px;">Habilidades motrices gruesas (caminar, saltar, etc)</strong></label>
                            <select id="desMotricesGruesas" class="browser-default" name="desMotricesGruesas" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $desarrollo->desMotricesGruesas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $desarrollo->desMotricesGruesas == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  ¿Cúal? --}}
                        <div class="col s12 m6 l3" id="divMotricesGru" style="display: none">
                            <div class="input-field">
                                <label for="desMotricesGruCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                                {!! Form::text('desMotricesGruCual', $desarrollo->desMotricesGruCual, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        
                
                        {{--  Habilidades motrices finas (dibujar, tomar cosas, etc)   --}}
                        <div class="col s12 m6 l3">
                            <label for="desMotricesFinas"><strong style="color: #000; font-size: 16px;">Habilidades motrices finas (dibujar, tomar cosas, etc)</strong></label>
                            <select id="desMotricesFinas" class="browser-default" name="desMotricesFinas" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $desarrollo->desMotricesFinas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $desarrollo->desMotricesFinas == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        <div class="col s12 m6 l3" id="divMotricesFin" style="display: none">
                            <div class="input-field">
                                <label for="desMotricesFinCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                                {!! Form::text('desMotricesFinCual', $desarrollo->desMotricesFinCual, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    
                
                    <div class="row">
                        {{--  Hiperactividad  --}}
                        <div class="col s12 m6 l3">
                            <label for="desHiperactividad"><strong style="color: #000; font-size: 16px;">Hiperactividad</strong></label>
                            <select id="desHiperactividad" class="browser-default" name="desHiperactividad" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $desarrollo->desHiperactividad == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $desarrollo->desHiperactividad == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            
                            </select>
                        </div>
                        {{--  ¿Cúal? --}}
                        <div class="col s12 m6 l3" id="divHiperactividad" style="display: none">
                            <div class="input-field">
                                <label for="desHiperactividadCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                                {!! Form::text('desHiperactividadCual', $desarrollo->desHiperactividadCual, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                       
                
                        {{--  Socialización  --}}
                        <div class="col s12 m6 l3">
                            <label for="desSocializacion"><strong style="color: #000; font-size: 16px;">Socialización</strong></label>
                            <select id="desSocializacion" class="browser-default" name="desSocializacion" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $desarrollo->desSocializacion == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $desarrollo->desSocializacion == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        <div class="col s12 m6 l3" id="divSocializacion" style="display: none">
                            <div class="input-field">
                                <label for="desSocializacionCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                                {!! Form::text('desSocializacionCual', $desarrollo->desSocializacionCual, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                    
                
                    <div class="row">
                        {{--  Lenguaje  --}}
                        <div class="col s12 m6 l6">
                            <label for="desLenguaje"><strong style="color: #000; font-size: 16px;">Lenguaje</strong></label>
                            <select id="desLenguaje" class="browser-default" name="desLenguaje" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $desarrollo->desLenguaje == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $desarrollo->desLenguaje == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  ¿Cúal? --}}
                        <div class="col s12 m6 l6" id="divLenguaje" style="display: none">
                            <div class="input-field">
                                <label for="desLenguajeCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                                {!! Form::text('desLenguajeCual', $desarrollo->desLenguajeCual, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    
                   
                    <p>Edad en que:</p>
                    <div class="row">
                        {{--  Dijo sus primeras palabras  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="desPrimPalabra"><strong style="color: #000; font-size: 16px;">Dijo sus primeras palabras</strong></label>
                                {!! Form::text('desPrimPalabra', $desarrollo->desPrimPalabra, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        <div class="col s12 m6 l6">
                            {{--  Dijo su nombre  --}}
                            <div class="input-field">
                                <label for="desEdadNombre"><strong style="color: #000; font-size: 16px;">Dijo su nombre</strong></label>
                                {!! Form::text('desEdadNombre', $desarrollo->desEdadNombre, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <br>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <label for="desLateralidad"><strong style="color: #000; font-size: 16px;">Lateralidad</strong></label>
                            <select id="desLateralidad" class="browser-default" name="desLateralidad" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="DIESTRO" {{ $desarrollo->desLateralidad == "DIESTRO" ? 'selected="selected"' : '' }}>Diestro</option>
                                <option value="ZURDO" {{ $desarrollo->desLateralidad == "ZURDO" ? 'selected="selected"' : '' }}>Zurdo</option>
                                <option value="DERECHO" {{ $desarrollo->desLateralidad == "DERECHO" ? 'selected="selected"' : '' }}>Derecho</option>   
                                <option value="NO DEFINIDO" {{ $desarrollo->desLateralidad == "NO DEFINIDO" ? 'selected="selected"' : '' }}>No definido</option> 
                                <option value="PREDOMINANCIA A DERECHO" {{ $desarrollo->desLateralidad == "PREDOMINANCIA A DERECHO" ? 'selected="selected"' : '' }}>Predominancia a derecho</option>
                                <option value="PREDOMINANCIA A ZURDO" {{ $desarrollo->desLateralidad == "PREDOMINANCIA A ZURDO" ? 'selected="selected"' : '' }}>Predominancia a zurdo</option>
                
                            </select>
                        </div>
                    </div>
                      <br>
                </div> 

                {{--  ANTECEDENTES HEREDO FAMILIARES  --}}
                <div id="heredo">
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">ANTECEDENTES HEREDO FAMILIARES</p>
                    </div>
                    <br>
                    <div class="row">
                        {{--  Epilepsia  --}}
                        <div class="col s12 m6 l6">
                            <label for="herEpilepsia"><strong style="color: #000; font-size: 16px;">Epilepsia</strong></label>
                            <select id="herEpilepsia" class="browser-default" name="herEpilepsia" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herEpilepsia == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herEpilepsia == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="herEpilepsiaGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                                {!! Form::text('herEpilepsiaGrado', $heredo->herEpilepsiaGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Diabetes  --}}
                        <div class="col s12 m6 l6">
                            <label for="herDiabetes"><strong style="color: #000; font-size: 16px;">Diabetes</strong></label>
                            <select id="herDiabetes" class="browser-default" name="herDiabetes" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herDiabetes == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herDiabetes == "NO" ? 'selected="selected"' : '' }}>NO</option>  
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="herDiabetesGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                                {!! Form::text('herDiabetesGrado', $heredo->herDiabetesGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Hipertensión  --}}
                        <div class="col s12 m6 l6">
                            <label for="herHipertension"><strong style="color: #000; font-size: 16px;">Hipertensión</strong></label>
                            <select id="herHipertension" class="browser-default" name="herHipertension" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herHipertension == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herHipertension == "NO" ? 'selected="selected"' : '' }}>NO</option>  
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="herHipertensionGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                                {!! Form::text('herHipertensionGrado', $heredo->herHipertensionGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Cáncer  --}}
                        <div class="col s12 m6 l6">
                            <label for="herCancer"><strong style="color: #000; font-size: 16px;">Cáncer</strong></label>
                            <select id="herCancer" class="browser-default" name="herCancer" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herCancer == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herCancer == "NO" ? 'selected="selected"' : '' }}>NO</option>  
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="herCancerGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                                {!! Form::text('herCancerGrado', $heredo->herCancerGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Neurológicos  --}}
                        <div class="col s12 m6 l6">
                            <label for="herNeurologicos"><strong style="color: #000; font-size: 16px;">Neurológicos</strong></label>
                            <select id="herNeurologicos" class="browser-default" name="herNeurologicos" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herNeurologicos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herNeurologicos == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="herNeurologicosGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                                {!! Form::text('herNeurologicosGrado', $heredo->herNeurologicosGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Psicológicos  --}}
                        <div class="col s12 m6 l6">                           
                            <label for="herPsicologicos"><strong style="color: #000; font-size: 16px;">Psicológicos</strong></label>
                            <select id="herPsicologicos" class="browser-default" name="herPsicologicos" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herPsicologicos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herPsicologicos == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="herPsicologicosGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                                {!! Form::text('herPsicologicosGrado', $heredo->herPsicologicosGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Problemas de lenguaje  --}}
                        <div class="col s12 m6 l6">
                            <label for="herLenguaje"><strong style="color: #000; font-size: 16px;">Problemas de lenguaje</strong></label>
                            <select id="herLenguaje" class="browser-default" name="herLenguaje" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herLenguaje == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herLenguaje == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="herLenguajeGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                                {!! Form::text('herLenguajeGrado', $heredo->herLenguajeGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Adicciones  --}}
                        <div class="col s12 m6 l6">
                            <label for="herAdicciones"><strong style="color: #000; font-size: 16px;">Adicciones</strong></label>
                            <select id="herAdicciones" class="browser-default" name="herAdicciones" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herAdicciones == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herAdicciones == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="herAdiccionesGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                                {!! Form::text('herAdiccionesGrado', $heredo->herAdiccionesGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  OTRO  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="herOtro"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                                {!! Form::text('herOtro', $heredo->herOtro, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="herOtroGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                                {!! Form::text('herOtroGrado', $heredo->herOtroGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                    <br>
                </div> 

                {{--  RELACIONES SOCIALES  --}}
                <div id="social">
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">RELACIONES SOCIALES </p>
                    </div>
                    <br>
                    <div class="row">
                               {{--  ¿Hace amigos con facilidad?   --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="socAmigos"><strong style="color: #000; font-size: 16px;">¿Hace amigos con facilidad? (comunicativo, poco comunicativo, participa en grupo)</strong></label>
                                {!! Form::text('socAmigos', $social->socAmigos, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        {{--  ¿Qué actitud asume en el juego?  --}}
                        <div class="col s12 m6 l6">
                            <label for="socActitud"><strong style="color: #000; font-size: 16px;">¿Qué actitud asume en el juego?</strong></label>
                            <select id="socActitud" class="browser-default" name="socActitud" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="LÍDER" {{ $social->socActitud == "LÍDER" ? 'selected="selected"' : '' }}>Líder</option>
                                <option value="COLABORADOR" {{ $social->socActitud == "COLABORADOR" ? 'selected="selected"' : '' }}>Colaborador</option>
                                <option value="TENDENCIA A AISLARSE" {{ $social->socActitud == "TENDENCIA A AISLARSE" ? 'selected="selected"' : '' }}>Tendencia a aislarse</option>
                                <option value="AGRESIVO" {{ $social->socActitud == "AGRESIVO" ? 'selected="selected"' : '' }}>Agresivo</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  ¿Tiene oportunidad de jugar con niños de su edad?  --}}
                        <div class="col s12 m6 l6">
                            <label for="socNinioEdad"><strong style="color: #000; font-size: 16px;">¿Tiene oportunidad de jugar con niños de su edad?</strong></label>
                            <select id="socNinioEdad" class="browser-default" name="socNinioEdad" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $social->socNinioEdad == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $social->socNinioEdad == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Razón  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="socNinioRazon"><strong style="color: #000; font-size: 16px;">Razón</strong></label>
                                {!! Form::text('socNinioRazon', $social->socNinioRazon, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  ¿Realiza alguna actividad extraescolar?  --}}
                        <div class="col s12 m6 l6">
                            <label for="socActividadExtraescolar"><strong style="color: #000; font-size: 16px;">¿Realiza alguna actividad extraescolar?</strong></label>
                            <select id="socActividadExtraescolar" class="browser-default" name="socActividadExtraescolar" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $social->socActividadExtraescolar == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $social->socActividadExtraescolar == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Razón  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="socActividadRazon"><strong style="color: #000; font-size: 16px;">¿Cúal?</strong></label>
                                {!! Form::text('socActividadRazon', $social->socActividadRazon, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  ¿Tiene dificultades para separarse de sus padres?  --}}
                        <div class="col s12 m6 l6">
                            <label for="socSeparacion"><strong style="color: #000; font-size: 16px;">¿Tiene dificultades para separarse de sus padres?</strong></label>
                            <select id="socSeparacion" class="browser-default" name="socSeparacion" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $social->socSeparacion == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $social->socSeparacion == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{-- Razón --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <label for="socSeparacionRazon"><strong style="color: #000; font-size: 16px;">¿Cúal?</strong></label>
                                {!! Form::text('socSeparacionRazon',  $social->socSeparacionRazon, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        
                        {{--  ¿Cómo se lleva con los miembros de la familia?  --}}
                                <div class="col s12 m6 l12">
                            <div class="input-field">
                                <label for="socRelacionFamilia"><strong style="color: #000; font-size: 16px;">¿Cómo se lleva con los miembros de la familia?</strong></label>
                                {!! Form::text('socRelacionFamilia', $social->socRelacionFamilia, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <br>
                </div> 

                {{-- CONDUCTA  --}}
                <div id="conducta">
                    <br>
                    <p>A su juicio, ¿Cómo considera a su hijo?</p>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Nivel afectivo </p>
                    </div>
                    <div class="row">
                        {{--  Nervioso/Ansioso --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conAfectivoNervioso" id="conAfectivoNervioso" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Nervioso/Ansioso</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conAfectivoNervioso}}' == 'NERVIOSO/ANSIOSO'){
                                $("#conAfectivoNervioso").prop("checked", true);
                                $("#conAfectivoNervioso").val("NERVIOSO/ANSIOSO");
                            }else{
                                $("#conAfectivoNervioso").prop("checked", false);
                            }
                        </script>
                        
                        {{-- Distraído --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conAfectivoDestraido" id="conAfectivoDestraido" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Distraído</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conAfectivoDestraido}}' == 'DISTRAÍDO'){
                                $("#conAfectivoDestraido").prop("checked", true);
                                $("#conAfectivoDestraido").val("DISTRAÍDO");
                            }else{
                                $("#conAfectivoDestraido").prop("checked", false);
                            }
                        </script>
                
                        {{-- Sensible --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conAfectivoSensible" id="conAfectivoSensible" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Sensible</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conAfectivoSensible}}' == 'SENSIBLE'){
                                $("#conAfectivoSensible").prop("checked", true);
                                $("#conAfectivoSensible").val("SENSIBLE");
                            }else{
                                $("#conAfectivoSensible").prop("checked", false);
                            }
                        </script>
                
                        {{-- Amable --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conAfectivoAmable" id="conAfectivoAmable" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Amable</strong></label>
                            </div>
                        </div> 
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conAfectivoAmable}}' == 'AMABLE'){
                                $("#conAfectivoAmable").prop("checked", true);
                                $("#conAfectivoAmable").val("AMABLE");
                            }else{
                                $("#conAfectivoAmable").prop("checked", false);
                            }
                        </script>
                        
                    </div>
                
                    <div class="row">
                        {{-- Agresivo --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conAfectivoAgresivo" id="conAfectivoAgresivo" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Agresivo</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conAfectivoAgresivo}}' == 'AGRESIVO'){
                                $("#conAfectivoAgresivo").prop("checked", true);
                                $("#conAfectivoAgresivo").val("AGRESIVO");
                            }else{
                                $("#conAfectivoAgresivo").prop("checked", false);
                            }
                        </script>
                
                        {{-- Tímido --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conAfectivoTimido" id="conAfectivoTimido" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Tímido</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conAfectivoTimido}}' == 'TÍMIDO'){
                                $("#conAfectivoTimido").prop("checked", true);
                                $("#conAfectivoTimido").val("TÍMIDO");
                            }else{
                                $("#conAfectivoTimido").prop("checked", false);
                            }
                        </script>
                
                               {{-- Amistoso --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conAfectivoAmistoso" id="conAfectivoAmistoso" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Amistoso</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conAfectivoAmistoso}}' == 'AMISTOSO'){
                                $("#conAfectivoAmistoso").prop("checked", true);
                                $("#conAfectivoAmistoso").val("AMISTOSO");
                            }else{
                                $("#conAfectivoAmistoso").prop("checked", false);
                            }
                        </script>
                               
                    </div>
                    <div class="row">
                        {{-- Otro --}}
                        <div class="col s12 m6 l6" style="margin-top:5px;">
                            <div class="input-field">
                                <label for="conAfectivoOtro"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                                {!! Form::text('conAfectivoOtro', $consucta->conAfectivoOtro, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Nivel verbal </p>
                    </div>
                    <div class="row">
                        {{-- Renuente a contestar --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conVerbalRenuente" id="conVerbalRenuente" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Renuente a contestar</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conVerbalRenuente}}' == 'RENUENTE A CONTESTAR'){
                                $("#conVerbalRenuente").prop("checked", true);
                                $("#conVerbalRenuente").val("RENUENTE A CONTESTAR");
                            }else{
                                $("#conVerbalRenuente").prop("checked", false);
                            }
                        </script>
                
                        {{-- Verbalización excesiva --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conVerbalVerbalizacion" id="conVerbalVerbalizacion" value="" readonly tabindex=-1>
                                <label for="aluClave"><strong style="color: #000; font-size: 16px;">Verbalización excesiva</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conVerbalVerbalizacion}}' == 'VERBALIZACIÓN EXCESIVA'){
                                $("#conVerbalVerbalizacion").prop("checked", true);
                                $("#conVerbalVerbalizacion").val("VERBALIZACIÓN EXCESIVA");
                            }else{
                                $("#conVerbalVerbalizacion").prop("checked", false);
                            }
                        </script>
                
                               {{-- Silencioso --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conVerbalSilencioso" id="conVerbalSilencioso" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Silencioso</strong></label>
                            </div>
                        </div>  
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conVerbalSilencioso}}' == 'SILENCIOSO'){
                                $("#conVerbalSilencioso").prop("checked", true);
                                $("#conVerbalSilencioso").val("SILENCIOSO");
                            }else{
                                $("#conVerbalSilencioso").prop("checked", false);
                            }
                        </script>             
                    </div>
                    
                    <div class="row">
                        {{-- Tartamudez --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conVerbalTartamudez" id="conVerbalTartamudez" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Tartamudez</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conVerbalTartamudez}}' == 'TARTAMUDEZ'){
                                $("#conVerbalTartamudez").prop("checked", true);
                                $("#conVerbalTartamudez").val("TARTAMUDEZ");
                            }else{
                                $("#conVerbalTartamudez").prop("checked", false);
                            }
                        </script>  
                
                        {{-- Explícito --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conVerbalExplicito" id="conVerbalExplicito" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Explícito</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conVerbalExplicito}}' == 'EXPLÍCITO'){
                                $("#conVerbalExplicito").prop("checked", true);
                                $("#conVerbalExplicito").val("EXPLÍCITO");
                            }else{
                                $("#conVerbalExplicito").prop("checked", false);
                            }
                        </script> 
                
                               {{-- Repetitivo --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conVerbalRepetivo" id="conVerbalRepetivo" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Repetitivo</strong></label>
                            </div>
                        </div>   
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conVerbalRepetivo}}' == 'REPETITIVO'){
                                $("#conVerbalRepetivo").prop("checked", true);
                                $("#conVerbalRepetivo").val("REPETITIVO");
                            }else{
                                $("#conVerbalRepetivo").prop("checked", false);
                            }
                        </script>             
                    </div>
                
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">Nivel conductual </p>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                        <label for="conConductual"><strong style="color: #000; font-size: 16px;">Nivel conductual</strong></label>
                            <select id="conConductual" class="browser-default" name="conConductual" style="width: 100%;" required>
                                <option value="" readonly tabindex=-1 selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="ACTIVO (ESPERADO)" {{ $consucta->conConductual == "ACTIVO (ESPERADO)" ? 'selected="selected"' : '' }}>Activo (esperado)</option>
                                <option value="PASIVO" {{ $consucta->conConductual == "PASIVO" ? 'selected="selected"' : '' }}>Pasivo</option>
                                <option value="HIPERECTIVO" {{ $consucta->conConductual == "HIPERECTIVO" ? 'selected="selected"' : '' }}>Hiperactivo</option>
                            </select>
                        </div>
                    </div>
                
                    <br>
                    <P>El niño presenta algunas de las siguientes conductas:</P>
                    <div class="row">
                        {{--  Berrinches recurrentes --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conBerrinches" id="conBerrinches" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Berrinches recurrentes</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conBerrinches}}' == 'BERRINCHES RECURRENTES'){
                                $("#conBerrinches").prop("checked", true);
                                $("#conBerrinches").val("BERRINCHES RECURRENTES");
                            }else{
                                $("#conBerrinches").prop("checked", false);
                            }
                        </script> 
                        
                        {{-- Agresividad --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conAgresividad" id="conAgresividad" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Agresividad</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conAgresividad}}' == 'AGRESIVIDAD'){
                                $("#conAgresividad").prop("checked", true);
                                $("#conAgresividad").val("AGRESIVIDAD");
                            }else{
                                $("#conAgresividad").prop("checked", false);
                            }
                        </script> 
                
                        {{-- Masturbación --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conMasturbacion" id="conMasturbacion" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Masturbación</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conMasturbacion}}' == 'MASTURBACIÓN'){
                                $("#conMasturbacion").prop("checked", true);
                                $("#conMasturbacion").val("MASTURBACIÓN");
                            }else{
                                $("#conMasturbacion").prop("checked", false);
                            }
                        </script> 
                
                        {{-- Mentiras --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conMentiras" id="conMentiras" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Mentiras</strong></label>
                            </div>
                        </div>   
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conMentiras}}' == 'MENTIRAS'){
                                $("#conMentiras").prop("checked", true);
                                $("#conMentiras").val("MENTIRAS");
                            }else{
                                $("#conMentiras").prop("checked", false);
                            }
                        </script>       
                    </div>
                
                    <div class="row">
                        {{--  Robo --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conRobo" id="conRobo" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Robo</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conRobo}}' == 'ROBO'){
                                $("#conRobo").prop("checked", true);
                                $("#conRobo").val("ROBO");
                            }else{
                                $("#conRobo").prop("checked", false);
                            }
                        </script>
                        
                        {{-- Pesadillas --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conPesadillas" id="conPesadillas" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Pesadillas</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conPesadillas}}' == 'PESADILLAS'){
                                $("#conPesadillas").prop("checked", true);
                                $("#conPesadillas").val("PESADILLAS");
                            }else{
                                $("#conPesadillas").prop("checked", false);
                            }
                        </script>
                
                        {{-- Enuresis (Pérdida de orina) --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conEnuresis" id="conEnuresis" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Enuresis (Pérdida de orina)</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conEnuresis}}' == 'ENURESIS (PÉRDIDA DE ORINA)'){
                                $("#conEnuresis").prop("checked", true);
                                $("#conEnuresis").val("ENURESIS (PÉRDIDA DE ORINA)");
                            }else{
                                $("#conEnuresis").prop("checked", false);
                            }
                        </script>
                
                        {{-- Encopresis (Pérdida fecal) --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conEncopresis" id="conEncopresis" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Encopresis (Pérdida fecal)</strong></label>
                            </div>
                        </div>    
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conEncopresis}}' == 'ENCOPRESIS (PÉRDIDA FECAL)'){
                                $("#conEncopresis").prop("checked", true);
                                $("#conEncopresis").val("ENCOPRESIS (PÉRDIDA FECAL)");
                            }else{
                                $("#conEncopresis").prop("checked", false);
                            }
                        </script>     
                    </div>
                
                    <div class="row">
                        {{--  Exceso de alimentación --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conExcesoAlimentacion" id="conExcesoAlimentacion" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Exceso de alimentación</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conExcesoAlimentacion}}' == 'EXCESO DE ALIMENTACIÓN'){
                                $("#conExcesoAlimentacion").prop("checked", true);
                                $("#conExcesoAlimentacion").val("EXCESO DE ALIMENTACIÓN");
                            }else{
                                $("#conExcesoAlimentacion").prop("checked", false);
                            }
                        </script>
                        
                        {{-- Rechazo excesivo de alimentos --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conRechazoAlimentario" id="conRechazoAlimentario" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Rechazo excesivo de alimentos</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conRechazoAlimentario}}' == 'RECHAZO EXCESIVO DE ALIMENTOS'){
                                $("#conRechazoAlimentario").prop("checked", true);
                                $("#conRechazoAlimentario").val("RECHAZO EXCESIVO DE ALIMENTOS");
                            }else{
                                $("#conRechazoAlimentario").prop("checked", false);
                            }
                        </script>
                
                        {{-- Llanto excesivo --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conLlanto" id="conLlanto" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Llanto excesivo</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conLlanto}}' == 'LLANTO EXCESIVO'){
                                $("#conLlanto").prop("checked", true);
                                $("#conLlanto").val("LLANTO EXCESIVO");
                            }else{
                                $("#conLlanto").prop("checked", false);
                            }
                        </script>
                
                        {{-- Tricotilomanía (Arrancarse el cabello) --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conTricotilomania" id="conTricotilomania" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Tricotilomanía (Arrancarse el cabello)</strong></label>
                            </div>
                        </div>  
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conTricotilomania}}' == 'TRICOTILOMANÍA (ARRANCARSE EL CABELLO)'){
                                $("#conTricotilomania").prop("checked", true);
                                $("#conTricotilomania").val("TRICOTILOMANÍA (ARRANCARSE EL CABELLO)");
                            }else{
                                $("#conTricotilomania").prop("checked", false);
                            }
                        </script>       
                    </div>
                
                    <div class="row">
                        {{--  Onicofagia (Comerse las uñas)  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conOnicofagia" id="conOnicofagia" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Onicofagia (Comerse las uñas)</strong></label>
                            </div>
                        </div>  
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conOnicofagia}}' == 'ONICOFAGIA (COMERSE LAS UÑAS)'){
                                $("#conOnicofagia").prop("checked", true);
                                $("#conOnicofagia").val("ONICOFAGIA (COMERSE LAS UÑAS)");
                            }else{
                                $("#conOnicofagia").prop("checked", false);
                            }
                        </script>
                        {{--  conMorderUnias  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conMorderUnias" id="conMorderUnias" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Morderse las uñas</strong></label>
                            </div>
                        </div> 
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conMorderUnias}}' == 'MORDERSE LAS UÑAS'){
                                $("#conMorderUnias").prop("checked", true);
                                $("#conMorderUnias").val("MORDERSE LAS UÑAS");
                            }else{
                                $("#conMorderUnias").prop("checked", false);
                            }
                        </script>
                
                        {{--  conSuccionPulgar  --}}
                        <div class="col s12 m6 l3" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conSuccionPulgar" id="conSuccionPulgar" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Succión del pulgar</strong></label>
                            </div>
                        </div> 
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conSuccionPulgar}}' == 'SUCCIÓN DEL PULGAR'){
                                $("#conSuccionPulgar").prop("checked", true);
                                $("#conSuccionPulgar").val("SUCCIÓN DEL PULGAR");
                            }else{
                                $("#conSuccionPulgar").prop("checked", false);
                            }
                        </script>
                    </div>
                
                    <br>
                    <p>¿Cómo controlaron estas conductas o como aplican una consecuencia?</p>
                    <div class="row">
                        {{-- Explicaciones --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conExplicaciones" id="conExplicaciones" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Explicaciones</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conExplicaciones}}' == 'EXPLICACIONES'){
                                $("#conExplicaciones").prop("checked", true);
                                $("#conExplicaciones").val("EXPLICACIONES");
                            }else{
                                $("#conExplicaciones").prop("checked", false);
                            }
                        </script>
                
                        {{-- Privaciones --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conPrivaciones" id="conPrivaciones" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Privaciones</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conPrivaciones}}' == 'PRIVACIONES'){
                                $("#conPrivaciones").prop("checked", true);
                                $("#conPrivaciones").val("PRIVACIONES");
                            }else{
                                $("#conPrivaciones").prop("checked", false);
                            }
                        </script>
                
                        {{-- Corporal --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conCorporal" id="conCorporal" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Corporal</strong></label>
                            </div>
                        </div>    
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conCorporal}}' == 'CORPORAL'){
                                $("#conCorporal").prop("checked", true);
                                $("#conCorporal").val("CORPORAL");
                            }else{
                                $("#conCorporal").prop("checked", false);
                            }
                        </script>    
                    </div>
                    <div class="row">
                        {{-- Amenazas --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conAmenazas" id="conAmenazas" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Amenazas</strong></label>
                            </div>
                        </div>
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conAmenazas}}' == 'AMENAZAS'){
                                $("#conAmenazas").prop("checked", true);
                                $("#conAmenazas").val("AMENAZAS");
                            }else{
                                $("#conAmenazas").prop("checked", false);
                            }
                        </script> 
                
                        {{-- Tiempo fuera --}}
                        <div class="col s12 m6 l4" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="conTiempoFuera" id="conTiempoFuera" value="" readonly tabindex=-1>
                                <label for=""><strong style="color: #000; font-size: 16px;">Tiempo fuera</strong></label>
                            </div>
                        </div>   
                        <script>    
                            {{-- retuna checked true si esta en la base  --}}
                            if('{{$consucta->conTiempoFuera}}' == 'TIEMPO FUERA'){
                                $("#conTiempoFuera").prop("checked", true);
                                $("#conTiempoFuera").val("TIEMPO FUERA");
                            }else{
                                $("#conTiempoFuera").prop("checked", false);
                            }
                        </script>     
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="conOtros"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                                {!! Form::text('conOtros', $consucta->conOtros, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        {{-- ¿Quién las aplica? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="conAplica"><strong style="color: #000; font-size: 16px;">¿Quién las aplica?</strong></label>
                                {!! Form::text('conAplica', $consucta->conAplica, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        {{-- ¿Cuándo y cómo es recompensado? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="conRecompensa"><strong style="color: #000; font-size: 16px;">¿Cuándo y cómo es recompensado?</strong></label>
                                {!! Form::text('conRecompensa', $consucta->conRecompensa, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                </div>

                {{-- ACTIVIDADES QUE REALIZA  --}}
                <div id="actividades">
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">ACTIVIDADES QUE REALIZA </p>
                    </div>
                
                    <div class="row">
                        {{-- ¿Ordena los juguetes? --}}
                        <div class="col s12 m6 l4">
                            <label for="actJuguete"><strong style="color: #000; font-size: 16px;">¿Ordena los juguetes?</strong></label>
                            <select id="actJuguete" class="browser-default" name="actJuguete" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $actividad->actJuguete == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $actividad->actJuguete == "NO" ? 'selected="selected"' : '' }}>NO</option>      
                                <option value="SOLO SI SE LE PIDE" {{ $actividad->actJuguete == "SOLO SI SE LE PIDE" ? 'selected="selected"' : '' }}>Solo si se le pide</option>         
                            </select>
                        </div>
                        {{-- ¿Le gustan los cuentos? --}}
                        <div class="col s12 m6 l4">
                            <label for="actCuento"><strong style="color: #000; font-size: 16px;">¿Le gustan los cuentos?</strong></label>
                            <select id="actCuento" class="browser-default" name="actCuento" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $actividad->actCuento == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $actividad->actCuento == "NO" ? 'selected="selected"' : '' }}>NO</option>          
                            </select>
                        </div>
                        {{-- ¿Le gustan las películas? --}}
                        <div class="col s12 m6 l4">
                            <label for="actPelicula"><strong style="color: #000; font-size: 16px;">¿Le gustan las películas?</strong></label>
                            <select id="actPelicula" class="browser-default" name="actPelicula" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $actividad->actPelicula == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $actividad->actPelicula == "NO" ? 'selected="selected"' : '' }}>NO</option>      
                            </select>
                        </div>
                    </div>
                
                    <div class="row">
                        {{-- ¿Cuántas horas al día ve televisión? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="actHorasTelevision"><strong style="color: #000; font-size: 16px;">¿Cuántas horas al día ve televisión?</strong></label>
                                {!! Form::text('actHorasTelevision', $actividad->actHorasTelevision, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{-- ¿Utiliza tablet, celular o consola de videojuegos? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="actTenologia"><strong style="color: #000; font-size: 16px;">¿Utiliza tablet, celular o consola de videojuegos?</strong></label>
                                {!! Form::text('actTenologia', $actividad->actTenologia, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{-- ¿Qué tipo de juguetes, juegos o temáticas disfruta? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="actTipoJuguetes"><strong style="color: #000; font-size: 16px;">¿Qué tipo de juguetes, juegos o temáticas disfruta?</strong></label>
                                {!! Form::text('actTipoJuguetes', $actividad->actTipoJuguetes, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{-- ¿Quién apoya o apoyaría a su hijo en las tareas? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="actApoyoTarea"><strong style="color: #000; font-size: 16px;">¿Quién apoya o apoyaría a su hijo en las tareas?</strong></label>
                                {!! Form::text('actApoyoTarea', $actividad->actApoyoTarea, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{-- ¿Quién está a cargo de su cuidado en las tardes? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="actCuidado"><strong style="color: #000; font-size: 16px;">¿Quién está a cargo de su cuidado en las tardes?</strong></label>
                                {!! Form::text('actCuidado', $actividad->actCuidado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">INFORMACIÓN ADICIONAL Y ACUERDOS</p>
                    </div>
                    <div class="row">
                        {{-- Alguna observación que le gustaría dar a conocer: --}}
                        <div class="col s12 m6 l12">
                            <div class="input-field">
                                <label for="actObservacionExtra"><strong style="color: #000; font-size: 16px;">Alguna observación que le gustaría dar a conocer</strong></label>
                                {!! Form::text('actObservacionExtra', $actividad->actObservacionExtra, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <br><br>
                    <div class="row">
                        {{-- Grado sugerido --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="actGradoSugerido"><strong style="color: #000; font-size: 16px;">Grado sugerido</strong></label>
                                {!! Form::text('actGradoSugerido', $actividad->actGradoSugerido, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{-- Grado elegido --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="actGradoElegido"><strong style="color: #000; font-size: 16px;">Grado elegido</strong></label>
                                {!! Form::text('actGradoElegido', $actividad->actGradoElegido, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{-- Nombre de quién realizó la entrevista --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <label for="actNombreEntrevista"><strong style="color: #000; font-size: 16px;">Nombre de quién realizó la entrevista</strong></label>
                                {!! Form::text('actNombreEntrevista', $actividad->actNombreEntrevista, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>

{{-- Script de funciones auxiliares  --}}
{!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}

@endsection

@section('footer_scripts')

{{--  GENERAL   --}}
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
    
    
    {{-- ingresa los datos en el select de estados de la madre --}}
    var paisMadre_Id = $('#paisMadre_Id').val();
    paisMadre_Id ? getEstados(paisMadre_Id, 'estadoMadre_id',
    {{ (isset($candidato) && $municipio) ? $municipio->estado->id : null}}) : resetSelect('estadoMadre_id');
    $('#paisMadre_Id').on('change', function() {
        var paisMadre_Id = $(this).val();
        paisMadre_Id ? getEstados(paisMadre_Id, 'estadoMadre_id', 
        {{ (isset($candidato) && $municipio)? $municipio->estado->id : null}}) : resetSelect('estadoMadre_id');
    });

    {{-- ingresa los datos en el select de municipios de la madre --}}
    var estadoMadre_id = $('#estadoMadre_id').val();
    estadoMadre_id ? getMunicipios(estadoMadre_id, 'municipioMadre_id', 
    {{ (isset($candidato) && $municipio)? $municipio->id : null}}) : resetSelect('municipioMadre_id');
    $('#estadoMadre_id').on('change', function() {
    var estadoMadre_id = $(this).val();
    estadoMadre_id ? getMunicipios(estadoMadre_id, 'municipioMadre_id',  
    {{ (isset($candidato) && $municipio)? $municipio->id : null}}) : resetSelect('municipioMadre_id');
    });

        {{-- ingresa los datos en el select de estados del padre --}}
        var paisPadre_Id = $('#paisPadre_Id').val();
        paisPadre_Id ? getEstados(paisPadre_Id, 'estadoPadre_id',
        {{ (isset($candidato) && $municipio) ? $municipio->estado->id : null}}) : resetSelect('estadoPadre_id');
        $('#paisPadre_Id').on('change', function() {
            var paisPadre_Id = $(this).val();
            paisPadre_Id ? getEstados(paisPadre_Id, 'estadoPadre_id', 
            {{ (isset($candidato) && $municipio)? $municipio->estado->id : null}}) : resetSelect('estadoPadre_id');
        });
    
        {{-- ingresa los datos en el select de municipios del padre --}}
        var estadoPadre_id = $('#estadoPadre_id').val();
        estadoPadre_id ? getMunicipios(estadoPadre_id, 'municipioPadre_id', 
        {{ (isset($candidato) && $municipio)? $municipio->id : null}}) : resetSelect('municipioPadre_id');
        $('#estadoPadre_id').on('change', function() {
        var estadoPadre_id = $(this).val();
        estadoPadre_id ? getMunicipios(estadoPadre_id, 'municipioPadre_id',  
        {{ (isset($candidato) && $municipio)? $municipio->id : null}}) : resetSelect('municipioPadre_id');
        });


        $("select[name=famRelacionMadre]").change(function(){
            if($('select[name=famRelacionMadre]').val() != ""){          
                           
                $("#divFrecuencia").show(); 
            }else{                    
                
                $("#divFrecuencia").hide();
            }
        });
</script>

{{--  EMBARAZO   --}}
<script>
    if($('select[name=nacComplicacionesEmbarazo]').val() == "SI"){
        $("#divEmbarazo").show(); 
        $("#nacCualesEmbarazo").attr('required', '');
    }else{
        $("#nacCualesEmbarazo").removeAttr('required');
        $("#divEmbarazo").hide();         
    }

    if($('select[name=nacComplicacionesParto]').val() == "SI"){
        $("#divParto").show(); 
        $("#nacCualesParto").attr('required', '');
    }else{
        $("#nacCualesParto").removeAttr('required');
        $("#divParto").hide();         
    }


    if($('select[name=nacComplicacionDespues]').val() == "SI"){
        $("#divDespues").show(); 
        $("#nacCualesDespues").attr('required', '');
    }else{
        $("#nacCualesDespues").removeAttr('required');
        $("#divDespues").hide();         
    }

    if($('select[name=nacLactancia]').val() != "MATERNA"){
        $("#divLactancia").show(); 
        $("#nacActualmente").attr('required', '');
    }else{
        $("#nacActualmente").removeAttr('required');
        $("#divLactancia").hide();         
    }
</script>

{{--  MEDICA   --}}
<script>
        {{--  alergias  --}}
        $("input[name=medAlergias]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medAlergias").val("ALERGIAS");
        
            } else {
                $("#medAlergias").val("");
            }
        });

        {{--  Convulsiones  --}}
        $("input[name=medConvulsiones]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medConvulsiones").val("CONVULSIONES");
        
            } else {
                $("#medConvulsiones").val("");
            }
        });

        

        {{--  Problemas de audición  --}}
        $("input[name=medAudicion]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medAudicion").val("PROBLEMAS DE AUDICIÓN");
        
            } else {
                $("#medAudicion").val("");
            }
        });
        

        {{--  Fiebres altas  --}}
        $("input[name=medFiebres]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medFiebres").val("FIEBRES ALTAS");
        
            } else {
                $("#medFiebres").val("");
            }
        });

        {{--  Problemas de corazón  --}}
        $("input[name=medProblemasCorazon]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medProblemasCorazon").val("PROBLEMAS DE CORAZÓN");
        
            } else {
                $("#medProblemasCorazon").val("");
            }
        });

        {{--  Deficiencia pulmonar y bronquial  --}}
        $("input[name=medDeficiencia]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medDeficiencia").val("DEFICIENCIA PULMONAR Y BRONQUIAL");
        
            } else {
                $("#medDeficiencia").val("");
            }
        });

        {{--  Asma  --}}
        $("input[name=medAsma]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medAsma").val("ASMA");
        
            } else {
                $("#medAsma").val("");
            }
        });

        {{--  Diabetes  --}}
        $("input[name=medDiabetes]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medDiabetes").val("DIABETES");
        
            } else {
                $("#medDiabetes").val("");
            }
        });
        {{--  Problemas gastrointestinales  --}}
        $("input[name=medGastrointestinales]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medGastrointestinales").val("PROBLEMAS GASTROINTESTINALES");
        
            } else {
                $("#medGastrointestinales").val("");
            }
        });

        {{--  Accidentes   --}}
        $("input[name=medAccidentes]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medAccidentes").val("ACCIDENTES");
        
            } else {
                $("#medAccidentes").val("");
            }
        });

        {{--  Epilepsia  --}}
        $("input[name=medEpilepsia]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medEpilepsia").val("EPILEPSIA");
        
            } else {
                $("#medEpilepsia").val("");
            }
        });
        {{--  Problemas de riñón  --}}
        $("input[name=medRinion]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medRinion").val("PROBLEMAS DE RIÑON");
        
            } else {
                $("#medRinion").val("");
            }
        });

        {{--  Problemas de la piel  --}}
        $("input[name=medPiel]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medPiel").val("PROBLEMAS DE LA PIEL");
        
            } else {
                $("#medPiel").val("");
            }
        });
        {{--  Falta de coordinación motriz  --}}
        $("input[name=medCoordinacionMotriz]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medCoordinacionMotriz").val("FALTA DE COORDINACIÓN MOTRIZ");
        
            } else {
                $("#medCoordinacionMotriz").val("");
            }
        });
        {{--  Estreñimiento  --}}
        $("input[name=medEstrenimiento]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medEstrenimiento").val("ESTREÑIMIENTO");
        
            } else {
                $("#medEstrenimiento").val("");
            }
        });
        {{--  Dificultades durante el sueño  --}}
        $("input[name=medDificultadesSuenio]").change(function(){
            if ($(this).is(':checked') ) {
        
                $("#medDificultadesSuenio").val("DIFICULTADES DURANTE EL SUEÑO");
        
            } else {
                $("#medDificultadesSuenio").val("");
            }
        });

        
    $("input[name=medAlergias]").change(function(){
        if ($(this).is(':checked') ) {
            
            $("#divEspecificar").show();

        } else {
            $("#divEspecificar").hide();
        }
    });

    $("select[name=medGastoMedico]").change(function(){
        if($('select[name=medGastoMedico]').val() == "SI"){
            $("#divAseguradora").show(); 
            $("#medNombreAsegurador").attr('required', '');     
        
        }else{
            $("#medNombreAsegurador").removeAttr('required');
            $("#divAseguradora").hide();   
            $("#medNombreAsegurador").val("");      

        }
    });

    $("select[name=medTerapia]").change(function(){
        if($('select[name=medTerapia]').val() == "SI"){
            $("#divTerapiaMotivo").show(); 
            $("#medMotivoTerapia").attr('required', '');     
        
        }else{
            $("#medMotivoTerapia").removeAttr('required');
            $("#divTerapiaMotivo").hide();         

        }
    });

    if($('select[name=medGastoMedico]').val() == "SI"){
        $("#divAseguradora").show(); 
        $("#medNombreAsegurador").attr('required', '');
    }else{
        $("#medNombreAsegurador").removeAttr('required');
        $("#divAseguradora").hide();         
    }


    if($('select[name=medTerapia]').val() == "SI"){
        $("#divTerapiaMotivo").show(); 
        $("#medMotivoTerapia").attr('required', '');
    }else{
        $("#medMotivoTerapia").removeAttr('required');
        $("#divTerapiaMotivo").hide();         
    }
</script>

{{--  DESARROLLO   --}}
<script>

  

    $("select[name=desMotricesGruesas]").change(function(){
        if($('select[name=desMotricesGruesas]').val() == "SI"){
            $("#divMotricesGru").show(); 
            $("#desMotricesGruCual").attr('required', '');     
           
        }else{
            $("#desMotricesGruCual").removeAttr('required');
            $("#divMotricesGru").hide();    
            $("#desMotricesGruCual").val("");     
    
        }
    });
    
    $("select[name=desMotricesFinas]").change(function(){
        if($('select[name=desMotricesFinas]').val() == "SI"){
            $("#divMotricesFin").show(); 
            $("#desMotricesFinCual").attr('required', '');     
           
        }else{
            $("#desMotricesFinCual").removeAttr('required');
            $("#divMotricesFin").hide();  
            $("#desMotricesFinCual").val("");       
    
        }
    });
    
    $("select[name=desHiperactividad]").change(function(){
        if($('select[name=desHiperactividad]').val() == "SI"){
            $("#divHiperactividad").show(); 
            $("#desHiperactividadCual").attr('required', '');     
           
        }else{
            $("#desHiperactividadCual").removeAttr('required');
            $("#divHiperactividad").hide();      
            $("#desHiperactividadCual").val("");   
    
        }
    });
    
    $("select[name=desSocializacion]").change(function(){
        if($('select[name=desSocializacion]').val() == "SI"){
            $("#divSocializacion").show(); 
            $("#desSocializacionCual").attr('required', '');     
           
        }else{
            $("#desSocializacionCual").removeAttr('required');
            $("#divSocializacion").hide();   
            $("#desSocializacionCual").val("");      
    
        }
    });
    
    $("select[name=desLenguaje]").change(function(){
        if($('select[name=desLenguaje]').val() == "SI"){
            $("#divLenguaje").show(); 
            $("#desLenguajeCual").attr('required', '');     
           
        }else{
            $("#desLenguajeCual").removeAttr('required');
            $("#divLenguaje").hide();       
            $("#desLenguajeCual").val("");  
    
        }
    });
    
    if($('select[name=desMotricesGruesas]').val() == "SI"){
        $("#divMotricesGru").show(); 
        $("#desMotricesGruCual").attr('required', '');
    }else{
        $("#desMotricesGruCual").removeAttr('required');
        $("#divMotricesGru").hide();         
    }
    
    if($('select[name=desMotricesFinas]').val() == "SI"){
        $("#divMotricesFin").show(); 
        $("#desMotricesFinCual").attr('required', '');
    }else{
        $("#desMotricesFinCual").removeAttr('required');
        $("#divMotricesFin").hide();         
    }
    
    if($('select[name=desHiperactividad]').val() == "SI"){
        $("#divHiperactividad").show(); 
        $("#desHiperactividadCual").attr('required', '');
    }else{
        $("#desHiperactividadCual").removeAttr('required');
        $("#divHiperactividad").hide();         
    }
    
    if($('select[name=desSocializacion]').val() == "SI"){
        $("#divSocializacion").show(); 
        $("#desSocializacionCual").attr('required', '');
    }else{
        $("#desSocializacionCual").removeAttr('required');
        $("#divSocializacion").hide();         
    }
    
    
    if($('select[name=desLenguaje]').val() == "SI"){
        $("#divLenguaje").show(); 
        $("#desLenguajeCual").attr('required', '');
    }else{
        $("#desLenguajeCual").removeAttr('required');
        $("#divLenguaje").hide();         
    }
</script>

{{--  HEREDO   --}}
<script>
    $("select[name=herEpilepsia]").change(function(){
        if($('select[name=herEpilepsia]').val() == "SI"){
            $("#herEpilepsiaGrado").attr('required', '');     
           
        }else{
            $("#herEpilepsiaGrado").removeAttr('required');
    
        }
    });

    {{--  herDiabetes  --}}
    $("select[name=herDiabetes]").change(function(){
        if($('select[name=herDiabetes]').val() == "SI"){
            $("#herDiabetesGrado").attr('required', '');     
           
        }else{
            $("#herDiabetesGrado").removeAttr('required');
    
        }
    });

    {{--  herHipertension  --}}
    $("select[name=herHipertension]").change(function(){
        if($('select[name=herHipertension]').val() == "SI"){
            $("#herHipertensionGrado").attr('required', '');     
           
        }else{
            $("#herHipertensionGrado").removeAttr('required');
    
        }
    });

    {{--  herCancer  --}}
    $("select[name=herCancer]").change(function(){
        if($('select[name=herCancer]').val() == "SI"){
            $("#herCancerGrado").attr('required', '');     
           
        }else{
            $("#herCancerGrado").removeAttr('required');
    
        }
    });
    {{--  herNeurologicos  --}}
    $("select[name=herNeurologicos]").change(function(){
        if($('select[name=herNeurologicos]').val() == "SI"){
            $("#herNeurologicosGrado").attr('required', '');     
           
        }else{
            $("#herNeurologicosGrado").removeAttr('required');
    
        }
    });
    {{--  herPsicologicos  --}}
    $("select[name=herPsicologicos]").change(function(){
        if($('select[name=herPsicologicos]').val() == "SI"){
            $("#herPsicologicosGrado").attr('required', '');     
           
        }else{
            $("#herPsicologicosGrado").removeAttr('required');
    
        }
    });
    {{--  herLenguaje  --}}
    $("select[name=herLenguaje]").change(function(){
        if($('select[name=herLenguaje]').val() == "SI"){
            $("#herLenguajeGrado").attr('required', '');     
           
        }else{
            $("#herLenguajeGrado").removeAttr('required');
    
        }
    });

    {{--  herAdicciones  --}}
    $("select[name=herAdicciones]").change(function(){
        if($('select[name=herAdicciones]').val() == "SI"){
            $("#herAdiccionesGrado").attr('required', '');     
           
        }else{
            $("#herAdiccionesGrado").removeAttr('required');
    
        }
    });
</script>

{{--  SOCIAL   --}}
<script>
    $("select[name=socNinioEdad]").change(function(){
        if($('select[name=socNinioEdad]').val() == "SI"){
            $("#socNinioRazon").attr('required', '');     
           
        }else{
            $("#socNinioRazon").removeAttr('required');
    
        }
    });

    {{--  socActividadExtraescolar  --}}
    $("select[name=socActividadExtraescolar]").change(function(){
        if($('select[name=socActividadExtraescolar]').val() == "SI"){
            $("#socActividadRazon").attr('required', '');     
           
        }else{
            $("#socActividadRazon").removeAttr('required');
    
        }
    });

    {{--  socSeparacion  --}}
    $("select[name=socSeparacion]").change(function(){
        if($('select[name=socSeparacion]').val() == "SI"){
            $("#socSeparacionRazon").attr('required', '');     
           
        }else{
            $("#socSeparacionRazon").removeAttr('required');
    
        }
    });

    {{--  herCancer  --}}
    $("select[name=herCancer]").change(function(){
        if($('select[name=herCancer]').val() == "SI"){
            $("#herCancerGrado").attr('required', '');     
           
        }else{
            $("#herCancerGrado").removeAttr('required');
    
        }
    });
    {{--  herNeurologicos  --}}
    $("select[name=herNeurologicos]").change(function(){
        if($('select[name=herNeurologicos]').val() == "SI"){
            $("#herNeurologicosGrado").attr('required', '');     
           
        }else{
            $("#herNeurologicosGrado").removeAttr('required');
    
        }
    });
    {{--  herPsicologicos  --}}
    $("select[name=herPsicologicos]").change(function(){
        if($('select[name=herPsicologicos]').val() == "SI"){
            $("#herPsicologicosGrado").attr('required', '');     
           
        }else{
            $("#herPsicologicosGrado").removeAttr('required');
    
        }
    });
    {{--  herLenguaje  --}}
    $("select[name=herLenguaje]").change(function(){
        if($('select[name=herLenguaje]').val() == "SI"){
            $("#herLenguajeGrado").attr('required', '');     
           
        }else{
            $("#herLenguajeGrado").removeAttr('required');
    
        }
    });

    {{--  herAdicciones  --}}
    $("select[name=herAdicciones]").change(function(){
        if($('select[name=herAdicciones]').val() == "SI"){
            $("#herAdiccionesGrado").attr('required', '');     
           
        }else{
            $("#herAdiccionesGrado").removeAttr('required');
    
        }
    });
</script>

{{--  CONDUCTA   --}}
<script>

    /* ---------------------------- Nervioso/Ansioso ---------------------------- */
        $("input[name=conAfectivoNervioso]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conAfectivoNervioso").val("NERVIOSO/ANSIOSO");
        
            } else {
                $("#conAfectivoNervioso").val("");
            }
        });
    
    /* -------------------------------- Agresivo -------------------------------- */
        $("input[name=conAfectivoAgresivo]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conAfectivoAgresivo").val("AGRESIVO");
        
            } else {
                $("#conAfectivoAgresivo").val("");
            }
        });
    
    /* -------------------------------- Distraído ------------------------------- */
        $("input[name=conAfectivoDestraido]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conAfectivoDestraido").val("DISTRAÍDO");
        
            } else {
                $("#conAfectivoDestraido").val("");
            }
        });
    
    /* --------------------------------- Tímido --------------------------------- */
        $("input[name=conAfectivoTimido]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conAfectivoTimido").val("TÍMIDO");
        
            } else {
                $("#conAfectivoTimido").val("");
            }
        });
    
    /* -------------------------------- Sensible -------------------------------- */
        $("input[name=conAfectivoSensible]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conAfectivoSensible").val("SENSIBLE");
        
            } else {
                $("#conAfectivoSensible").val("");
            }
        });
    
    /* --------------------------- Amistoso -------------------------- */
        $("input[name=conAfectivoAmistoso]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conAfectivoAmistoso").val("AMISTOSO");
        
            } else {
                $("#conAfectivoAmistoso").val("");
            }
        });
    
    /* --------------------------------- Amable --------------------------------- */
        $("input[name=conAfectivoAmable]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conAfectivoAmable").val("AMABLE");
        
            } else {
                $("#conAfectivoAmable").val("");
            }
        });
    
    /* -------------------------- Renuente a contestar -------------------------- */
        $("input[name=conVerbalRenuente]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conVerbalRenuente").val("RENUENTE A CONTESTAR");
        
            } else {
                $("#conVerbalRenuente").val("");
            }
        });
    
    /* ------------------------------- Tartamudez ------------------------------- */
        $("input[name=conVerbalTartamudez]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conVerbalTartamudez").val("TARTAMUDEZ");
        
            } else {
                $("#conVerbalTartamudez").val("");
            }
        });
    
    /* ------------------------- Verbalización excesiva ------------------------- */
        $("input[name=conVerbalVerbalizacion]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conVerbalVerbalizacion").val("VERBALIZACIÓN EXCESIVA");
        
            } else {
                $("#conVerbalVerbalizacion").val("");
            }
        });
    
    /* -------------------------------- Explícito ------------------------------- */
        $("input[name=conVerbalExplicito]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conVerbalExplicito").val("EXPLÍCITO");
        
            } else {
                $("#conVerbalExplicito").val("");
            }
        });
    
    /* ------------------------------- Silencioso ------------------------------- */
        $("input[name=conVerbalSilencioso]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conVerbalSilencioso").val("SILENCIOSO");
        
            } else {
                $("#conVerbalSilencioso").val("");
            }
        });
    
    /* ------------------------------- Repetitivo ------------------------------- */
        $("input[name=conVerbalRepetivo]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conVerbalRepetivo").val("REPETITIVO");
        
            } else {
                $("#conVerbalRepetivo").val("");
            }
        });
    
    /* ------------------------- Berrinches recurrentes ------------------------- */
        $("input[name=conBerrinches]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conBerrinches").val("BERRINCHES RECURRENTES");
        
            } else {
                $("#conBerrinches").val("");
            }
        });
    
    /* ------------------------------- Agresividad ------------------------------ */
        $("input[name=conAgresividad]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conAgresividad").val("AGRESIVIDAD");
        
            } else {
                $("#conAgresividad").val("");
            }
        });
    
    /* ------------------------------ Masturbación ------------------------------ */
        $("input[name=conMasturbacion]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conMasturbacion").val("MASTURBACIÓN");
        
            } else {
                $("#conMasturbacion").val("");
            }
        });
    
    /* ------------------------------ Mentiras ------------------------------ */
        $("input[name=conMentiras]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conMentiras").val("MENTIRAS");
        
            } else {
                $("#conMentiras").val("");
            }
        });
    
    /* ---------------------------------- Robo ---------------------------------- */
        $("input[name=conRobo]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conRobo").val("ROBO");
        
            } else {
                $("#conRobo").val("");
            }
        });
    
    /* ------------------------------- Pesadillas ------------------------------- */
        $("input[name=conPesadillas]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conPesadillas").val("PESADILLAS");
        
            } else {
                $("#conPesadillas").val("");
            }
        });
    
    /* ----------------------- Enuresis (Pérdida de orina) ---------------------- */
        $("input[name=conEnuresis]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conEnuresis").val("ENURESIS (PÉRDIDA DE ORINA)");
        
            } else {
                $("#conEnuresis").val("");
            }
        });
    
    /* ----------------------- Encopresis (Pérdida fecal) ----------------------- */
        $("input[name=conEncopresis]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conEncopresis").val("ENCOPRESIS (PÉRDIDA FECAL)");
        
            } else {
                $("#conEncopresis").val("");
            }
        });
    
    /* ------------------------- Exceso de alimentación ------------------------- */
        $("input[name=conExcesoAlimentacion]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conExcesoAlimentacion").val("EXCESO DE ALIMENTACIÓN");
        
            } else {
                $("#conExcesoAlimentacion").val("");
            }
        });
    
    /* ---------------------- Rechazo excesivo de alimentos --------------------- */
        $("input[name=conRechazoAlimentario]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conRechazoAlimentario").val("RECHAZO EXCESIVO DE ALIMENTOS");
        
            } else {
                $("#conRechazoAlimentario").val("");
            }
        });
    
    /* ----------------------------- Llanto excesivo ---------------------------- */
        $("input[name=conLlanto]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conLlanto").val("LLANTO EXCESIVO");
        
            } else {
                $("#conLlanto").val("");
            }
        });
    
    /* ----------------- Tricotilomanía (Arrancarse el cabello) ----------------- */
        $("input[name=conTricotilomania]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conTricotilomania").val("TRICOTILOMANÍA (ARRANCARSE EL CABELLO)");
        
            } else {
                $("#conTricotilomania").val("");
            }
        });
    
    /* ---------------------- Onicofagia (Comerse las uñas) --------------------- */
        $("input[name=conOnicofagia]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conOnicofagia").val("ONICOFAGIA (COMERSE LAS UÑAS)");
        
            } else {
                $("#conOnicofagia").val("");
            }
        });
    
    /* ---------------------------- Morderse las uñas --------------------------- */
        $("input[name=conMorderUnias]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conMorderUnias").val("MORDERSE LAS UÑAS");
        
            } else {
                $("#conMorderUnias").val("");
            }
        });
    
    /* --------------------------- Succión del pulgar --------------------------- */
        $("input[name=conSuccionPulgar]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conSuccionPulgar").val("SUCCIÓN DEL PULGAR");
        
            } else {
                $("#conSuccionPulgar").val("");
            }
        });
    
    /* ------------------------------ Explicaciones ----------------------------- */
        $("input[name=conExplicaciones]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conExplicaciones").val("EXPLICACIONES");
        
            } else {
                $("#conExplicaciones").val("");
            }
        });
    
    /* ------------------------------- Privaciones ------------------------------ */
        $("input[name=conPrivaciones]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conPrivaciones").val("PRIVACIONES");
        
            } else {
                $("#conPrivaciones").val("");
            }
        });
    
    /* -------------------------------- Corporal -------------------------------- */
        $("input[name=conCorporal]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conCorporal").val("CORPORAL");
        
            } else {
                $("#conCorporal").val("");
            }
        });
    
    /* -------------------------------- Amenazas -------------------------------- */
        $("input[name=conAmenazas]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conAmenazas").val("AMENAZAS");
        
            } else {
                $("#conAmenazas").val("");
            }
        });
    
    /* ------------------------------ Tiempo fuera ------------------------------ */
        $("input[name=conTiempoFuera]").change(function(){
            if ($(this).is(':checked') ) {
         
                $("#conTiempoFuera").val("TIEMPO FUERA");
        
            } else {
                $("#conTiempoFuera").val("");
            }
        });
    
    
</script>

@endsection

<style>
    input[type="checkbox"][readonly] {
        pointer-events: none !important;
      }                             
    
</style>