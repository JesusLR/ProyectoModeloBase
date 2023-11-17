@extends('layouts.dashboard')

@section('template_title')
Historial clinica
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{url('clinica')}}" class="breadcrumb">Lista de historial</a>
<a href="{{url('clinica/'.$historia->id)}}" class="breadcrumb">Ver historial</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">DETALLE HISTORIAL CLINICA</span>

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
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">DATOS GENERALES DEL ALUMNO (A)</p>
                    </div>
                    <div class="row">
                        {{--  /* --------------------------- Seleccionar alumno --------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('nombreAlumno', 'Nombre(s)*', array('class' =>
                                '')); !!}
                                {!! Form::text('nombreAlumno', $historia->perNombre, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('perApellido1', 'Apellido paterno*', array('class' =>
                                '')); !!}
                                {!! Form::text('perApellido1', $historia->perApellido1, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('perApellido2', 'Apellido materno*', array('class' =>
                                '')); !!}
                                {!! Form::text('perApellido2', $historia->perApellido2, array('readonly' => 'true')) !!}
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('perFechaNac', 'Fecha de nacimiento*', array('class' =>
                            '')); !!}
                            {!! Form::date('perFechaNac', $historia->perFechaNac, array('readonly' => 'true')) !!}

                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('paisAlumno', 'País *', array('class' => '')); !!}
                            <select id="paisAlumno" class="browser-default validate" name="paisAlumno"
                                style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($paises as $pais)
                                <option value="{{$pais->id}}"
                                    {{ $historia->pais_id == $pais->id ? 'selected="selected"' : '' }}>
                                    {{$pais->paisNombre}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('estadoAlumno_id', 'Estado *', array('class' => '')); !!}
                            <select id="estadoAlumno_id" class="browser-default validate" required
                                name="estadoAlumno_id" style="width: 100%; pointer-events: none">
                                <option value="">{{$historia->edoNombre}}</option>
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('municipioAlumno_id', 'Municipio *', ['class' => '']); !!}
                            <select id="municipioAlumno_id" class="browser-default validate" required
                                name="municipioAlumno_id" style="width: 100%; pointer-events: none">
                                <option value="">{{$historia->munNombre}}</option>

                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('perCurp', 'CURP*', array('class' =>
                                '')); !!}
                                {!! Form::text('perCurp', $historia->perCurp, array('readonly' => 'true')) !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('hisEdadActualMeses', 'Edad actual (Años y meses) *', array('class' =>
                                '')); !!}
                                {!! Form::text('hisEdadActualMeses', $historia->hisEdadActualMeses, array('readonly' =>
                                'true')) !!}
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        {{--  /* ----------------------------- tipo de sangre ----------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('hisTipoSangre', 'Tipo de sangre*', array('class' => '')); !!}
                            <select id="hisTipoSangre" class="browser-default validate" required
                                name="hisTipoSangre" style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="O NEGATIVO"
                                    {{ $historia->hisTipoSangre == "O NEGATIVO" ? 'selected="selected"' : '' }}>O
                                    negativo</option>
                                <option value="O POSITIVO"
                                    {{ $historia->hisTipoSangre == "O POSITIVO" ? 'selected="selected"' : '' }}>O
                                    positivo</option>
                                <option value="A NEGATIVO"
                                    {{ $historia->hisTipoSangre == "A NEGATIVO" ? 'selected="selected"' : '' }}>A
                                    negativo</option>
                                <option value="A POSITIVO"
                                    {{ $historia->hisTipoSangre == "A POSITIVO" ? 'selected="selected"' : '' }}>A
                                    positivo</option>
                                <option value="B NEGATIVO"
                                    {{ $historia->hisTipoSangre == "B NEGATIVO" ? 'selected="selected"' : '' }}>B
                                    negativo</option>
                                <option value="B POSITIVO"
                                    {{ $historia->hisTipoSangre == "B POSITIVO" ? 'selected="selected"' : '' }}>B
                                    positivo</option>
                                <option value="AB NEGATIVO"
                                    {{ $historia->hisTipoSangre == "AB NEGATIVO" ? 'selected="selected"' : '' }}>AB
                                    negativo</option>
                                <option value="AB POSITIVO"
                                    {{ $historia->hisTipoSangre == "AB POSITIVO" ? 'selected="selected"' : '' }}>AB
                                    positivo</option>
                            </select>
                        </div>

                        {{--  /* -------------------------------- alergias -------------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('hisAlergias', 'Alergias', array('class' => '')); !!}
                                {!! Form::text('hisAlergias', $historia->hisAlergias, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{--  /* ------------------------- escuela de procendencia ------------------------ */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('hisEscuelaProcedencia', 'Escuela de procedencia*', array('class' =>
                                '')); !!}
                                {!! Form::text('hisEscuelaProcedencia', $historia->hisEscuelaProcedencia,
                                array('readonly' => 'true')) !!}
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        {{--  /* -------------------------- Último grado cursado -------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('hisUltimoGrado', 'Último grado cursado*', array('class' =>
                                '')); !!}
                                {!! Form::text('hisUltimoGrado', $historia->hisUltimoGrado, array('readonly' => 'true'))
                                !!}
                            </div>
                        </div>

                        {{--  /* -------------- ¿Ha recursado algún año o se lo han sugerido? ------------- */  --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('hisRecursado', '¿Ha recursado algún año o se lo han sugerido?*',
                            array('class' =>
                            '')); !!}
                            <select id="hisRecursado" class="browser-default" name="hisRecursado"
                                style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $historia->hisRecursado == "SI" ? 'selected="selected"' : '' }}>SI
                                </option>
                                <option value="NO" {{ $historia->hisRecursado == "NO" ? 'selected="selected"' : '' }}>NO
                                </option>
                            </select>
                        </div>
                        <div class="col s12 m6 l12">
                            <div id="detalleRecursamiento" class="input-field" style="display: none">
                                {!! Form::label('hisRecursadoDetalle', 'Detalle de año cursado*', array('class' =>
                                '')); !!}
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
                                {!! Form::label('famNombresMadre', 'Nombre(s)', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  Apellido parterno madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famApellido1Madre', $familia->famApellido1Madre, array('readonly' => 'true')) !!}
                                {!! Form::label('famApellido1Madre', 'Apellido paterno*', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  apellido materno madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famApellido2Madre', $familia->famApellido2Madre, array('readonly' => 'true')) !!}
                                {!! Form::label('famApellido2Madre', 'Apellido materno*', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  fecha de nacimiento de la madre   --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('famFechaNacimientoMadre', 'Fecha de nacimiento*', array('class' => '')); !!}
                            {!! Form::date('famFechaNacimientoMadre', $familia->famFechaNacimientoMadre, array('readonly' => 'true')) !!}
                        </div>
                
                        <div class="col s12 m6 l4">
                            {!! Form::label('paisMadre_Id', 'País *', array('class' => '')); !!}
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
                            {!! Form::label('estadoMadre_id', 'Estado *', array('class' => '')); !!}
                            <select id="estadoMadre_id" class="browser-default validate" required name="estadoMadre_id"
                                style="width: 100%; pointer-events: none" data-estado-id="{{$estadoMadre->id}}">
                              
                            </select>
                        </div>
                
                    </div>
                
                
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('municipioMadre_id', 'Municipio *', ['class' => '']); !!}
                            <select id="municipioMadre_id" class="browser-default validate" required name="municipioMadre_id"
                                style="width: 100%; pointer-events: none" data-municipio-id="{{$municipioMadre->id}}">
                            
                            </select>
                        </div>
                
                        {{--  ocupación madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famOcupacionMadre', $familia->famOcupacionMadre, array('readonly' => 'true')) !!}
                                {!! Form::label('famOcupacionMadre', 'Ocupación*', array('class' => '')); !!}
                            </div>
                        </div>
                        {{--  empresa donde labora la madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famEmpresaMadre', $familia->famEmpresaMadre, array('readonly' => 'true')) !!}
                                {!! Form::label('famEmpresaMadre', 'Empresa donde labora', array('class' => '')); !!}
                            </div>
                        </div>
                
                    </div>
                
                    <div class="row">
                        {{--  Celular de la madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('famCelularMadre', $familia->famCelularMadre, array('readonly' => 'true')) !!}
                                {!! Form::label('famCelularMadre', 'Celular*', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  telefono madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('famTelefonoMadre', $familia->famTelefonoMadre, array('readonly' => 'true')) !!}                
                                {!! Form::label('famTelefonoMadre', 'Télefono', array('class' => '')); !!}
                            </div>
                        </div>
                        {{--  correo de la madre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('famEmailMadre', 'Correo *', ['class' => '', ]) !!}
                                {!! Form::email('famEmailMadre', $familia->famEmailMadre, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                    </div>
                
                    <div class="row">
                        {{--  relacion con el niño   --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('famRelacionMadre', 'Relación con el niño*', ['class' => '', ]) !!}
                            <select id="famRelacionMadre" class="browser-default" name="famRelacionMadre" style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="ESTABLE" {{ $familia->famRelacionMadre == "ESTABLE" ? 'selected="selected"' : '' }}>Estable</option>
                                <option value="INESTABLE" {{ $familia->famRelacionMadre == "INESTABLE" ? 'selected="selected"' : '' }}>Inestable</option>
                                <option value="CONFLICTIVA" {{ $familia->famRelacionMadre == "CONFLICTIVA" ? 'selected="selected"' : '' }}>Conflictiva</option>
                            </select>
                        </div>
                
                        {{--  frecuencia de la realcion madre  --}}
                        <div class="col s12 m6 l4" id="divFrecuencia">
                            {!! Form::label('famRelacionFrecuenciaMadre', 'Frecuencia de la relación con el niño*', ['class' => '', ])
                            !!}
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
                                {!! Form::label('famNombresPadre', 'Nombre(s)', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  Apellido parterno del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famApellido1Padre', $familia->famApellido1Padre, array('readonly' => 'true')) !!}
                                {!! Form::label('famApellido1Padre', 'Apellido paterno*', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  apellido materno del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famApellido2Padre', $familia->famApellido2Padre, array('readonly' => 'true')) !!}
                                {!! Form::label('famApellido2Padre', 'Apellido materno*', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  fecha de nacimiento del padre   --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('famFechaNacimientoPadre', 'Fecha de nacimiento*', array('class' => '')); !!}
                            {!! Form::date('famFechaNacimientoPadre', $familia->famFechaNacimientoPadre, array('readonly' => 'true')) !!}
                        </div>
                
                        <div class="col s12 m6 l4">
                            {!! Form::label('paisPadre_Id', 'País *', array('class' => '')); !!}
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
                            {!! Form::label('estadoPadre_id', 'Estado *', array('class' => '')); !!}
                            <select id="estadoPadre_id" class="browser-default validate" required name="estadoPadre_id"
                                style="width: 100%; pointer-events: none" data-estado-id="{{$estadoPadre->id}}">
                            </select>
                        </div>        
                    </div>
                
                
                    <div class="row">
                        {{--  municio del padre   --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('municipioPadre_id', 'Municipio *', ['class' => '']); !!}
                            <select id="municipioPadre_id" class="browser-default validate" required name="municipioPadre_id"
                                style="width: 100%; pointer-events: none" data-municipio-id="{{$municipioPadre->id}}">
                            </select>
                        </div>
                
                        {{--  ocupación del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famOcupacionPadre', $familia->famOcupacionPadre, array('readonly' => 'true')) !!}
                                {!! Form::label('famOcupacionPadre', 'Ocupación*', array('class' => '')); !!}
                            </div>
                        </div>
                        {{--  empresa donde labora el padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('famEmpresaPadre', $familia->famEmpresaPadre, array('readonly' => 'true')) !!}
                                {!! Form::label('famEmpresaPadre', 'Empresa donde labora', array('class' => '')); !!}
                            </div>
                        </div>        
                    </div>
                
                    <div class="row">
                        {{--  Celular del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('famCelularPadre', $familia->famCelularPadre, array('readonly' => 'true')) !!}
                                {!! Form::label('famCelularPadre', 'Celular*', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  telefono del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('famTelefonoPadre', $familia->famTelefonoPadre, array('readonly' => 'true')) !!}
                
                                {!! Form::label('famTelefonoPadre', 'Télefono', array('class' => '')); !!}
                            </div>
                        </div>
                        {{--  correo del padre   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('famEmailPadre', 'Correo *', ['class' => '', ]) !!}
                                {!! Form::email('famEmailPadre', $familia->famEmailPadre, array('readonly' => 'true')) !!}
                            </div>
                        </div>        
                    </div>
                    <div class="row">
                        {{--  relacion con el niño   --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('famRelacionPadre', 'Relación con el niño*', ['class' => '', ]) !!}
                            <select id="famRelacionPadre" class="browser-default" name="famRelacionPadre" style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="ESTABLE" {{ $familia->famRelacionPadre == "ESTABLE" ? 'selected="selected"' : '' }}>Estable</option>
                                <option value="INESTABLE" {{ $familia->famRelacionPadre == "INESTABLE" ? 'selected="selected"' : '' }}>Inestable</option>
                                <option value="CONFLICTIVA" {{ $familia->famRelacionPadre == "CONFLICTIVA" ? 'selected="selected"' : '' }}>Conflictiva</option>
                            </select>
                        </div>
                
                        {{--  frecuencia de la realcion   --}}
                        <div class="col s12 m6 l4" id="divFrecuenciaPadre">
                            {!! Form::label('famRelacionFrecuenciaPadre', 'Frecuencia de la relación con el niño*', ['class' => '', ])
                            !!}
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
                            {!! Form::label('famEstadoCivilPadres', 'Estado civil de los padres*', ['class' => '', ]) !!}
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
                                {!! Form::label('famSeparado', '¿Con cuál de los padres vive el niño?', array('class' => '')); !!}
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
                                {!! Form::label('famReligion', 'Religion', array('class' => '')); !!}
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
                                {!! Form::label('famExtraNombre', 'Nombre de algun familiar o conocido', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  telefono del familiar o conocido   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::number('famTelefonoExtra', $familia->famTelefonoExtra, array('readonly' => 'true')) !!}
                                {!! Form::label('famTelefonoExtra', 'Télefono del familiar o conocido', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                
                    <p>Nombre completo de personas autorizadas para recoger al alumno en la escuela:</p>
                    <div class="row">
                        {{--  persona autorizada 1   --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::text('famAutorizado1', $familia->famAutorizado1, array('readonly' => 'true')) !!}
                                {!! Form::label('famAutorizado1', 'Persona autorizada 1', array('class' => '')); !!}
                            </div>
                        </div>
                        {{--  persona autorizada 2   --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::text('famAutorizado2', $familia->famAutorizado2, array('readonly' => 'true')) !!}
                                {!! Form::label('famAutorizado2', 'Persona autorizada 2', array('class' => '')); !!}
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
                                {!! Form::label('famIntegrante1', 'Integrante 1', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  parentesco del integrante 1   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famParentesco1', $familia->famParentesco1, array('readonly' => 'true')) !!}
                                {!! Form::label('famParentesco1', 'Parentesco', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  edad del integrante 1   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::number('famEdadIntegrante1', $familia->famEdadIntegrante1, array('readonly' => 'true')) !!}
                                {!! Form::label('famEdadIntegrante1', 'Edad', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  escuela y grado del integrante 1   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famEscuelaGrado1', $familia->famEscuelaGrado1, array('readonly' => 'true')) !!}
                                {!! Form::label('famEscuelaGrado1', 'Escuela y grado', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                
                    {{--  integrante 2   --}}
                    <div class="row">
                        {{--  nombre del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famIntegrante2', $familia->famIntegrante2, array('readonly' => 'true')) !!}
                                {!! Form::label('famIntegrante2', 'Integrante 1', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  parentesco del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famParentesco2', $familia->famParentesco2, array('readonly' => 'true')) !!}
                                {!! Form::label('famParentesco2', 'Parentesco', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  edad del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::number('famEdadIntegrante2', $familia->famEdadIntegrante2, array('readonly' => 'true')) !!}
                                {!! Form::label('famEdadIntegrante2', 'Edad', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  escuela y grado del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famEscuelaGrado2', $familia->famEscuelaGrado2, array('readonly' => 'true')) !!}
                                {!! Form::label('famEscuelaGrado2', 'Escuela y grado', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                
                    {{--  integrante 3   --}}
                    <div class="row">
                        {{--  nombre del integrante 3   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famIntregrante3', $familia->famIntregrante3, array('readonly' => 'true')) !!}
                                {!! Form::label('famIntregrante3', 'Integrante 1', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  parentesco del integrante 3   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famParentesco3', $familia->famParentesco3, array('readonly' => 'true')) !!}
                                {!! Form::label('famParentesco3', 'Parentesco', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  edad del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::number('famEdadIntregrante3', $familia->famEdadIntregrante3, array('readonly' => 'true')) !!}
                                {!! Form::label('famEdadIntregrante3', 'Edad', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  escuela y grado del integrante 2   --}}
                        <div class="col s12 m6 l3">
                            <div class="input-field">
                                {!! Form::text('famEscuelaGrado3', $familia->famEscuelaGrado3, array('readonly' => 'true')) !!}
                                {!! Form::label('famEscuelaGrado3', 'Escuela y grado', array('class' => '')); !!}
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
                                {!! Form::label('nacNumEmbarazo', 'Embarazo número*', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  Embarazo planeado   --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('nacEmbarazoPlaneado', 'Embarazo planeado*',
                            array('class' =>
                            '')); !!}
                            <select id="nacEmbarazoPlaneado" required class="browser-default" name="nacEmbarazoPlaneado"
                                style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $embarazo->nacEmbarazoPlaneado == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $embarazo->nacEmbarazoPlaneado == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  Embarazo a término   --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('nacEmbarazoTermino', 'Embarazo a término*', array('class' => '')); !!}
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
                            {!! Form::label('nacEmbarazoDuracion', 'Duración del embarazo*', array('class' => '')); !!}
                            {!! Form::text('nacEmbarazoDuracion', $embarazo->nacEmbarazoDuracion, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        {{--  Parto   --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('NacParto', 'Parto*', array('class' => '')); !!}
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
                                {!! Form::label('nacPeso', 'Peso al nacer*', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                
                
                    <div class="row">
                        {{--  medida al nacer   --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('nacMedia', $embarazo->nacMedia, array('readonly' => 'true')) !!}
                                {!! Form::label('nacMedia', 'Medida al nacer*', array('class' => '')); !!}
                            </div>
                        </div>
                
                        {{--  APGAR  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('nacApgar', $embarazo->nacApgar, array('readonly' => 'true')) !!}
                                {!! Form::label('nacApgar', 'APGAR*', array('class' => '')); !!}
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
                            {!! Form::label('nacComplicacionesEmbarazo', 'Durante el embarazo*',
                            array('class' =>
                            '')); !!}
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
                                {!! Form::label('nacCualesEmbarazo', '¿Cuáles durante el embarazo?', array('class' => '')); !!}
                            </div>
                        </div>       
                    </div>
                
                    <div class="row">
                        {{--  durante el parto   --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('nacComplicacionesParto', 'Durante el parto*',
                            array('class' =>
                            '')); !!}
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
                                {!! Form::label('nacCualesParto', '¿Cuáles durante el parto?', array('class' => '')); !!}
                            </div>
                        </div>       
                    </div>
                
                    <div class="row">
                        {{--  despues del nacimiento   --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('nacComplicacionDespues', 'Después del nacimiento*',
                            array('class' =>
                            '')); !!}
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
                                {!! Form::label('nacCualesDespues', '¿Cuáles después del nacimiento?', array('class' => '')); !!}
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
                            {!! Form::label('nacLactancia', 'Tipo de leche*',
                            array('class' =>
                            '')); !!}
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
                                {!! Form::label('nacActualmente', '¿Cuál?', array('class' => '')); !!}
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
                                {!! Form::label('medIntervencionQuirurgicas', 'Intervenciones quirúrgicas*', array('class' => '')); !!}
                                {!! Form::text('medIntervencionQuirurgicas', $medica->medIntervencionQuirurgicas, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{--  Tratamientos/ medicamentos  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('medMedicamentos', 'Tratamientos/ medicamentos', array('class' => '')); !!}
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
                                <label for=""> Convulsiones</label>
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
                                <label for=""> Problemas de audición</label>
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
                                <label for=""> Fiebres altas</label>
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
                                <label for=""> Problemas de corazón</label>
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
                                <label for=""> Deficiencia pulmonar y bronquial</label>
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
                                <label for=""> Asma</label>
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
                                <label for=""> Diabetes</label>
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
                                <label for=""> Problemas gastrointestinales</label>
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
                                <label for=""> Accidentes</label>
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
                                <label for=""> Epilepsia</label>
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
                                <label for=""> Problemas de riñón</label>
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
                                <label for=""> Problemas de la piel</label>
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
                                <label for=""> Falta de coordinación motriz</label>
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
                                <label for=""> Estreñimiento</label>
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
                                <label for=""> Dificultades durante el sueño</label>
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
                                <label for=""> Alergias</label>
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
                                {!! Form::label('medEspesificar', 'Especifique las alergias*', array('class' => '')); !!}
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
                                {!! Form::label('medOtro', 'Otro', array('class' => '')); !!}
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
                            {!! Form::label('medGastoMedico', 'Cuenta con seguro de gastos médicos*',
                            array('class' =>
                            '')); !!}
                            <select id="medGastoMedico" class="browser-default" name="medGastoMedico" style="width: 100%; pointer-events: none" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $medica->medGastoMedico == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $medica->medGastoMedico == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  Nombre de la aseguradora  --}}
                        <div class="col s12 m6 l6" id="divAseguradora" style="display: none">
                            <div class="input-field">
                                {!! Form::label('medNombreAsegurador', 'Nombre de la aseguradora*', array('class' => '')); !!}
                                {!! Form::text('medNombreAsegurador', $medica->medNombreAsegurador, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Cuenta con todas las vacunas correspondientes:  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('medVacunas', 'Cuenta con todas las vacunas correspondientes*',
                            array('class' =>
                            '')); !!}
                            <select id="medVacunas" class="browser-default" name="medVacunas" style="width: 100%; pointer-events: none" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $medica->medVacunas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $medica->medVacunas == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  ¿Ha recibido algún tratamiento?  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('medTramiento', '¿Ha recibido algún tratamiento?*',
                            array('class' =>
                            '')); !!}
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
                            {!! Form::label('medTerapia', 'Asiste o asistió en cierto momento a algún tipo de terapia*',
                            array('class' =>
                            '')); !!}
                            <select id="medTerapia" class="browser-default" name="medTerapia" style="width: 100%; pointer-events: none" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $medica->medTerapia == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $medica->medTerapia == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  ¿Por qué motivo la terapia?  --}}
                        <div class="col s12 m6 l6" id="divTerapiaMotivo" style="display: none">
                            <div class="input-field">
                                {!! Form::label('medMotivoTerapia', '¿Por qué motivo?*', array('class' => '')); !!}
                                {!! Form::text('medMotivoTerapia', $medica->medMotivoTerapia, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                       
                    </div>
                
                    <div class="row">
                        {{--  Estado de salud física actual  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('medSaludFisicaAct', 'Estado de salud física actual*', array('class' => '')); !!}
                                {!! Form::text('medSaludFisicaAct', $medica->medSaludFisicaAct, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{--  Estado emocional actual  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('medSaludEmocialAct', 'Estado emocional actual*', array('class' => '')); !!}
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
                            {!! Form::label('habBanio', 'Va al baño solo*',
                            array('class' =>
                            '')); !!}
                            <select id="habBanio" class="browser-default" name="habBanio" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $habitos->habBanio == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $habitos->habBanio == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Se viste solo o hace el intento  --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('habVestimenta', 'Se viste solo o hace el intento*',
                            array('class' =>
                            '')); !!}
                            <select id="habVestimenta" class="browser-default" name="habVestimenta" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $habitos->habVestimenta == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $habitos->habVestimenta == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        {{--  Luz apagada al dormir  --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('habLuz', 'Luz apagada al dormir*',
                            array('class' =>
                            '')); !!}
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
                            {!! Form::label('habZapatos', 'Se calza los zapatos solo*',
                            array('class' =>
                            '')); !!}
                            <select id="habZapatos" class="browser-default" name="habZapatos" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $habitos->habZapatos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $habitos->habZapatos == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Come solo  --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('habCome', 'Come solo*',
                            array('class' =>
                            '')); !!}
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
                                {!! Form::label('habHoraDormir', '¿A qué hora se acuesta a dormir?*', array('class' => '')); !!}
                                {!! Form::text('habHoraDormir', $habitos->habHoraDormir, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{--  ¿A qué hora se levanta?  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('habHoraDespertar', '¿A qué hora se levanta?*', array('class' => '')); !!}
                                {!! Form::text('habHoraDespertar', $habitos->habHoraDespertar, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                
                    <div class="row">
                        {{--  Se levanta  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('habEstadoLevantar', 'Se levanta*', array('class' => '')); !!}
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
                            {!! Form::label('habRecipiente', 'Recipiente donde bebe agua o leche*', array('class' => '')); !!}
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
                            {!! Form::label('desMotricesGruesas', 'Habilidades motrices gruesas (caminar, saltar, etc)*',
                            array('class' =>
                            '')); !!}
                            <select id="desMotricesGruesas" class="browser-default" name="desMotricesGruesas" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $desarrollo->desMotricesGruesas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $desarrollo->desMotricesGruesas == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  ¿Cúal? --}}
                        <div class="col s12 m6 l3" id="divMotricesGru" style="display: none">
                            <div class="input-field">
                                {!! Form::label('desMotricesGruCual', '¿Cuál?*', array('class' => '')); !!}
                                {!! Form::text('desMotricesGruCual', $desarrollo->desMotricesGruCual, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        
                
                        {{--  Habilidades motrices finas (dibujar, tomar cosas, etc)   --}}
                        <div class="col s12 m6 l3">
                            {!! Form::label('desMotricesFinas', 'Habilidades motrices finas (dibujar, tomar cosas, etc)*',
                            array('class' =>
                            '')); !!}
                            <select id="desMotricesFinas" class="browser-default" name="desMotricesFinas" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $desarrollo->desMotricesFinas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $desarrollo->desMotricesFinas == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        <div class="col s12 m6 l3" id="divMotricesFin" style="display: none">
                            <div class="input-field">
                                {!! Form::label('desMotricesFinCual', '¿Cuál?*', array('class' => '')); !!}
                                {!! Form::text('desMotricesFinCual', $desarrollo->desMotricesFinCual, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    
                
                    <div class="row">
                        {{--  Hiperactividad  --}}
                        <div class="col s12 m6 l3">
                            {!! Form::label('desHiperactividad', 'Hiperactividad*',
                            array('class' =>
                            '')); !!}
                            <select id="desHiperactividad" class="browser-default" name="desHiperactividad" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $desarrollo->desHiperactividad == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $desarrollo->desHiperactividad == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            
                            </select>
                        </div>
                        {{--  ¿Cúal? --}}
                        <div class="col s12 m6 l3" id="divHiperactividad" style="display: none">
                            <div class="input-field">
                                {!! Form::label('desHiperactividadCual', '¿Cuál?*', array('class' => '')); !!}
                                {!! Form::text('desHiperactividadCual', $desarrollo->desHiperactividadCual, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                       
                
                        {{--  Socialización  --}}
                        <div class="col s12 m6 l3">
                            {!! Form::label('desSocializacion', 'Socialización*',
                            array('class' =>
                            '')); !!}
                            <select id="desSocializacion" class="browser-default" name="desSocializacion" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $desarrollo->desSocializacion == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $desarrollo->desSocializacion == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                
                        <div class="col s12 m6 l3" id="divSocializacion" style="display: none">
                            <div class="input-field">
                                {!! Form::label('desSocializacionCual', '¿Cuál?*', array('class' => '')); !!}
                                {!! Form::text('desSocializacionCual', $desarrollo->desSocializacionCual, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                    
                
                    <div class="row">
                        {{--  Lenguaje  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('desLenguaje', 'Lenguaje*',
                            array('class' =>
                            '')); !!}
                            <select id="desLenguaje" class="browser-default" name="desLenguaje" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $desarrollo->desLenguaje == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $desarrollo->desLenguaje == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  ¿Cúal? --}}
                        <div class="col s12 m6 l6" id="divLenguaje" style="display: none">
                            <div class="input-field">
                                {!! Form::label('desLenguajeCual', '¿Cuál?*', array('class' => '')); !!}
                                {!! Form::text('desLenguajeCual', $desarrollo->desLenguajeCual, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    
                   
                    <p>Edad en que:</p>
                    <div class="row">
                        {{--  Dijo sus primeras palabras  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('desPrimPalabra', 'Dijo sus primeras palabras*', array('class' => '')); !!}
                                {!! Form::text('desPrimPalabra', $desarrollo->desPrimPalabra, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        <div class="col s12 m6 l6">
                            {{--  Dijo su nombre  --}}
                            <div class="input-field">
                                {!! Form::label('desEdadNombre', 'Dijo su nombre*', array('class' => '')); !!}
                                {!! Form::text('desEdadNombre', $desarrollo->desEdadNombre, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <br>
                    <div class="row">
                        <div class="col s12 m6 l6">
                            {!! Form::label('desLateralidad', 'Lateralidad*',
                            array('class' =>
                            '')); !!}
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
                            {!! Form::label('herEpilepsia', 'Epilepsia*',
                            array('class' =>
                            '')); !!}
                            <select id="herEpilepsia" class="browser-default" name="herEpilepsia" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herEpilepsia == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herEpilepsia == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('herEpilepsiaGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                                {!! Form::text('herEpilepsiaGrado', $heredo->herEpilepsiaGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Diabetes  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('herDiabetes', 'Diabetes*',
                            array('class' =>
                            '')); !!}
                            <select id="herDiabetes" class="browser-default" name="herDiabetes" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herDiabetes == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herDiabetes == "NO" ? 'selected="selected"' : '' }}>NO</option>  
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('herDiabetesGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                                {!! Form::text('herDiabetesGrado', $heredo->herDiabetesGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Hipertensión  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('herHipertension', 'Hipertensión*',
                            array('class' =>
                            '')); !!}
                            <select id="herHipertension" class="browser-default" name="herHipertension" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herHipertension == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herHipertension == "NO" ? 'selected="selected"' : '' }}>NO</option>  
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('herHipertensionGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                                {!! Form::text('herHipertensionGrado', $heredo->herHipertensionGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Cáncer  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('herCancer', 'Cáncer*',
                            array('class' =>
                            '')); !!}
                            <select id="herCancer" class="browser-default" name="herCancer" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herCancer == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herCancer == "NO" ? 'selected="selected"' : '' }}>NO</option>  
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('herCancerGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                                {!! Form::text('herCancerGrado', $heredo->herCancerGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Neurológicos  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('herNeurologicos', 'Neurológicos*',
                            array('class' =>
                            '')); !!}
                            <select id="herNeurologicos" class="browser-default" name="herNeurologicos" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herNeurologicos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herNeurologicos == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('herNeurologicosGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                                {!! Form::text('herNeurologicosGrado', $heredo->herNeurologicosGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Psicológicos  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('herPsicologicos', 'Psicológicos*', array('class' => '')); !!}
                            <select id="herPsicologicos" class="browser-default" name="herPsicologicos" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herPsicologicos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herPsicologicos == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('herPsicologicosGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                                {!! Form::text('herPsicologicosGrado', $heredo->herPsicologicosGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Problemas de lenguaje  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('herLenguaje', 'Problemas de lenguaje*',
                            array('class' =>
                            '')); !!}
                            <select id="herLenguaje" class="browser-default" name="herLenguaje" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herLenguaje == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herLenguaje == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('herLenguajeGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                                {!! Form::text('herLenguajeGrado', $heredo->herLenguajeGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  Adicciones  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('herAdicciones', 'Adicciones*',
                            array('class' =>
                            '')); !!}
                            <select id="herAdicciones" class="browser-default" name="herAdicciones" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $heredo->herAdicciones == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $heredo->herAdicciones == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('herAdiccionesGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                                {!! Form::text('herAdiccionesGrado', $heredo->herAdiccionesGrado, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  OTRO  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('herOtro', 'Otro', array('class' => '')); !!}
                                {!! Form::text('herOtro', $heredo->herOtro, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{--  Grado de parentesco con el niño  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('herOtroGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
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
                                {!! Form::label('socAmigos', '¿Hace amigos con facilidad? (comunicativo, poco comunicativo, participa en grupo)*', array('class' => '')); !!}
                                {!! Form::text('socAmigos', $social->socAmigos, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        {{--  ¿Qué actitud asume en el juego?  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('socActitud', '¿Qué actitud asume en el juego?*', array('class' => '')); !!}
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
                            {!! Form::label('socNinioEdad', '¿Tiene oportunidad de jugar con niños de su edad?*',
                            array('class' =>
                            '')); !!}
                            <select id="socNinioEdad" class="browser-default" name="socNinioEdad" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $social->socNinioEdad == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $social->socNinioEdad == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Razón  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('socNinioRazon', 'Razón', array('class' => '')); !!}
                                {!! Form::text('socNinioRazon', $social->socNinioRazon, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  ¿Realiza alguna actividad extraescolar?  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('socActividadExtraescolar', '¿Realiza alguna actividad extraescolar?*',
                            array('class' =>
                            '')); !!}
                            <select id="socActividadExtraescolar" class="browser-default" name="socActividadExtraescolar" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $social->socActividadExtraescolar == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $social->socActividadExtraescolar == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{--  Razón  --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('socActividadRazon', '¿Cúal?', array('class' => '')); !!}
                                {!! Form::text('socActividadRazon', $social->socActividadRazon, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{--  ¿Tiene dificultades para separarse de sus padres?  --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('socSeparacion', '¿Tiene dificultades para separarse de sus padres?*',
                            array('class' =>
                            '')); !!}
                            <select id="socSeparacion" class="browser-default" name="socSeparacion" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $social->socSeparacion == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $social->socSeparacion == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        {{-- Razón --}}
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                {!! Form::label('socSeparacionRazon', '¿Cúal?', array('class' => '')); !!}
                                {!! Form::text('socSeparacionRazon',  $social->socSeparacionRazon, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        
                        {{--  ¿Cómo se lleva con los miembros de la familia?  --}}
                                <div class="col s12 m6 l12">
                            <div class="input-field">
                                {!! Form::label('socRelacionFamilia', '¿Cómo se lleva con los miembros de la familia?*', array('class' => '')); !!}
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
                                <label for=""> Nervioso/Ansioso</label>
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
                                <label for=""> Distraído</label>
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
                                <label for=""> Sensible</label>
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
                                <label for=""> Amable</label>
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
                                <label for=""> Agresivo</label>
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
                                <label for=""> Tímido</label>
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
                                <label for=""> Amistoso</label>
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
                                {!! Form::label('conAfectivoOtro', 'Otro', array('class' => '')); !!}
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
                                <label for=""> Renuente a contestar</label>
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
                                <label for=""> Verbalización excesiva</label>
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
                                <label for=""> Silencioso</label>
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
                                <label for=""> Tartamudez</label>
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
                                <label for=""> Explícito</label>
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
                                <label for=""> Repetitivo</label>
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
                        {!! Form::label('conConductual', 'Nivel conductual*', array('class' => '')); !!}
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
                                <label for=""> Berrinches recurrentes</label>
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
                                <label for=""> Agresividad</label>
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
                                <label for=""> Masturbación</label>
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
                                <label for=""> Mentiras</label>
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
                                <label for=""> Robo</label>
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
                                <label for=""> Pesadillas</label>
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
                                <label for=""> Enuresis (Pérdida de orina)</label>
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
                                <label for=""> Encopresis (Pérdida fecal)</label>
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
                                <label for=""> Exceso de alimentación</label>
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
                                <label for=""> Rechazo excesivo de alimentos</label>
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
                                <label for=""> Llanto excesivo</label>
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
                                <label for=""> Tricotilomanía (Arrancarse el cabello)</label>
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
                                <label for=""> Onicofagia (Comerse las uñas)</label>
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
                                <label for=""> Morderse las uñas</label>
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
                                <label for=""> Succión del pulgar</label>
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
                                <label for=""> Explicaciones</label>
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
                                <label for=""> Privaciones</label>
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
                                <label for=""> Corporal</label>
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
                                <label for=""> Amenazas</label>
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
                                <label for=""> Tiempo fuera</label>
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
                                {!! Form::label('conOtros', 'Otro', array('class' => '')); !!}
                                {!! Form::text('conOtros', $consucta->conOtros, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        {{-- ¿Quién las aplica? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('conAplica', '¿Quién las aplica?', array('class' => '')); !!}
                                {!! Form::text('conAplica', $consucta->conAplica, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                
                        {{-- ¿Cuándo y cómo es recompensado? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('conRecompensa', '¿Cuándo y cómo es recompensado?', array('class' => '')); !!}
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
                            {!! Form::label('actJuguete', '¿Ordena los juguetes?*', array('class' => '')); !!}
                            <select id="actJuguete" class="browser-default" name="actJuguete" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $actividad->actJuguete == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $actividad->actJuguete == "NO" ? 'selected="selected"' : '' }}>NO</option>      
                                <option value="SOLO SI SE LE PIDE" {{ $actividad->actJuguete == "SOLO SI SE LE PIDE" ? 'selected="selected"' : '' }}>Solo si se le pide</option>         
                            </select>
                        </div>
                        {{-- ¿Le gustan los cuentos? --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('actCuento', '¿Le gustan los cuentos?*', array('class' => '')); !!}
                            <select id="actCuento" class="browser-default" name="actCuento" style="width: 100%; pointer-events: none;" required>
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $actividad->actCuento == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $actividad->actCuento == "NO" ? 'selected="selected"' : '' }}>NO</option>          
                            </select>
                        </div>
                        {{-- ¿Le gustan las películas? --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('actPelicula', '¿Le gustan las películas?*', array('class' => '')); !!}
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
                                {!! Form::label('actHorasTelevision', '¿Cuántas horas al día ve televisión?', array('class' => '')); !!}
                                {!! Form::text('actHorasTelevision', $actividad->actHorasTelevision, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{-- ¿Utiliza tablet, celular o consola de videojuegos? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('actTenologia', '¿Utiliza tablet, celular o consola de videojuegos?', array('class' => '')); !!}
                                {!! Form::text('actTenologia', $actividad->actTenologia, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{-- ¿Qué tipo de juguetes, juegos o temáticas disfruta? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('actTipoJuguetes', '¿Qué tipo de juguetes, juegos o temáticas disfruta?', array('class' => '')); !!}
                                {!! Form::text('actTipoJuguetes', $actividad->actTipoJuguetes, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        {{-- ¿Quién apoya o apoyaría a su hijo en las tareas? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('actApoyoTarea', '¿Quién apoya o apoyaría a su hijo en las tareas?', array('class' => '')); !!}
                                {!! Form::text('actApoyoTarea', $actividad->actApoyoTarea, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{-- ¿Quién está a cargo de su cuidado en las tardes? --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('actCuidado', '¿Quién está a cargo de su cuidado en las tardes?', array('class' => '')); !!}
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
                                {!! Form::label('actObservacionExtra', 'Alguna observación que le gustaría dar a conocer', array('class' => '')); !!}
                                {!! Form::text('actObservacionExtra', $actividad->actObservacionExtra, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                
                    <br><br>
                    <div class="row">
                        {{-- Grado sugerido --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('actGradoSugerido', 'Grado sugerido*', array('class' => '')); !!}
                                {!! Form::text('actGradoSugerido', $actividad->actGradoSugerido, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{-- Grado elegido --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('actGradoElegido', 'Grado elegido*', array('class' => '')); !!}
                                {!! Form::text('actGradoElegido', $actividad->actGradoElegido, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        {{-- Nombre de quién realizó la entrevista --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('actNombreEntrevista', 'Nombre de quién realizó la entrevista*', array('class' => '')); !!}
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