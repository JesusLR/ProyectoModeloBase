@extends('layouts.dashboard')

@section('template_title')
Secundaria historial clinica
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{url('secundaria_historia_clinica')}}" class="breadcrumb">Lista de expedientes</a>
<a href="{{url('secundaria_historia_clinica/'.$historia->id.'/edit')}}" class="breadcrumb">Editar expediente</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['secundaria.secundaria_historia_clinica.update', $historia->id])) }}
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
                                {!! Form::text('perNombre', $persona->perNombre, array('id' => 'perNombre', 'class' => 'validate','maxlength'=>'40')) !!}
                                <label for="perNombre"><strong style="color: #000; font-size: 16px;">Nombre(s)</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('perApellido1', $persona->perApellido1, array('id' => 'perApellido1', 'class' => 'validate','maxlength'=>'30')) !!}
                                <label for="perApellido1"><strong style="color: #000; font-size: 16px;">Primer apellido</strong></label>
                            </div>
                        </div>
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('perApellido2', $persona->perApellido2, array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30'))!!}
                                <label for="perApellido2"><strong style="color: #000; font-size: 16px;">Segundo apellido</strong></label>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perCurp', $persona->perCurp, array('id' => 'perCurp', 'class' => 'validate', 'required', 'maxlength'=>'18')) !!}
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
                                        <select id="aluNivelIngr" disabled class="browser-default validate select2" required name="aluNivelIngr" style="width: 100%;">
                                            <option value="" disabled>SELECCIONE UNA OPCIÓN</option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{$departamento->depNivel}}" {{ $alumno->aluNivelIngr == $departamento->depNivel ? 'selected' : '' }}>
    
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
                                {!! Form::number('aluGradoIngr', $alumno->aluGradoIngr, array('id' => 'aluGradoIngr', 'class' => 'validate','readonly','min'=>'1','onKeyPress="if(this.value.length>1) return false;"')) !!}
                                <label for="aluGradoIngr"><strong style="color: #000; font-size: 16px;">Grado Ingreso *</strong></label>
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
                      <p style="text-align: center;font-size:1.2em;">Escuela anterior</p>
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="sec_tipo_escuela"><strong style="color: #000; font-size: 16px;">Tipo de escuela</strong></label>
                            <select id="sec_tipo_escuela" class="browser-default validate select2" name="sec_tipo_escuela" style="width: 100%;">
                                @php                                  
                                if(old('sec_tipo_escuela') !== null){
                                    $sec_tipo_escuela = old('sec_tipo_escuela'); 
                                }
                                else{ $sec_tipo_escuela = $alumno->sec_tipo_escuela; }
                                @endphp
                                <option value="">SELECCIONE UNA OPCIÓN</option>
                                <option value="PRIVADA" {{ $sec_tipo_escuela == "PRIVADA" ? 'selected' : '' }}>PRIVADA</option>
                                <option value="PÚBLICA" {{ $sec_tipo_escuela == "PÚBLICA" ? 'selected' : '' }}>PÚBLICA</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                @php                                  
                                if(old('sec_nombre_ex_escuela') !== null){
                                    $sec_nombre_ex_escuela = old('sec_nombre_ex_escuela'); 
                                }
                                else{ $sec_nombre_ex_escuela = $alumno->sec_nombre_ex_escuela; }
                                @endphp
                                {!! Form::text('sec_nombre_ex_escuela', $sec_nombre_ex_escuela, array('id' => 'sec_nombre_ex_escuela', 'class' => 'validate','maxlength'=>'255')) !!}
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
                      <p style="text-align: center;font-size:1.2em;">Datos de Contacto</p>
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
                            <label for="hisIngresoSecundaria"><strong style="color: #000; font-size: 16px;">Grado al que se inscribe (primer ingreso a Secundaria) *</strong></label>
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
                @include('secundaria.historia_clinica.familiares')
                
                {{--  EMBARAZO Y NACIMIENTO   --}}
                @include('secundaria.historia_clinica.embarazo')

                {{--  HISTORIA MEDICA   --}}
                @include('secundaria.historia_clinica.medica')

                {{--  HÁBITOS E HIGIENE  --}}
                @include('secundaria.historia_clinica.habitos')

                {{--  HISTORIA DEL DESARROLLO  --}}
                @include('secundaria.historia_clinica.desarrollo')

                {{--  ANTECEDENTES HEREDO FAMILIARES  --}}
                @include('secundaria.historia_clinica.heredo')

                {{--  RELACIONES SOCIALES  --}}
                @include('secundaria.historia_clinica.sociales')

                {{-- CONDUCTA  --}}
                @include('secundaria.historia_clinica.conducta')

                {{-- ACTIVIDADES QUE REALIZA  --}}
                @include('secundaria.historia_clinica.actividades')

                


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
@include('secundaria.scripts.funcionesAuxiliares')
@include('secundaria.scripts.municipios')
@include('secundaria.scripts.estados')

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