@extends('layouts.dashboard')

@section('template_title')
    Primaria entrevista inicial
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('primaria_entrevista_inicial')}}" class="breadcrumb">Listado de entrevista inicial</a>
    <a href="{{url('primaria_entrevista_inicial/'.$alumnoEntrevista->id.'/edit')}}" class="breadcrumb">Editar entrevista inicial</a>

@endsection

@section('content')

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
        {{ Form::open(array('method'=>'PUT','route' => ['primaria.primaria_entrevista_inicial.update', $alumnoEntrevista->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">ENTREVISTA INICIAL #{{$alumnoEntrevista->id}}</span>

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
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                        {!! Form::text('perNombre', $persona->perNombre,
                            array('id' => 'perNombre', 'class' => 'validate','required','maxlength'=>'40')) !!}
                        {!! Form::label('perNombre', 'Nombre(s) *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                        {!! Form::text('perApellido1', $persona->perApellido1,
                        array('id' => 'perApellido1', 'class' => 'validate','required','maxlength'=>'30')) !!}
                        {!! Form::label('perApellido1', 'Primer apellido *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                        {!! Form::text('perApellido2', $persona->perApellido2,
                        array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30'))!!}
                        {!! Form::label('perApellido2', 'Segundo apellido', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l3">
                        <div class="input-field">
                        {!! Form::text('aluClave', $alumno->aluClave,
                        array('id' => 'aluClave', 'class' => 'validate','maxlength'=>'30', 'readonly'))!!}
                        {!! Form::label('aluClave', 'Clave pago', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('perCurp', $persona->perCurp,
                                array('id' => 'perCurp', 'class' => 'validate', 'maxlength'=>'18')) !!}
                                {!! Form::hidden('perCurpOld', $persona->perCurp, ['id' => 'perCurpOld']) !!}
                            {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                            {!! Form::label('perCurp', 'Curp *', array('class' => '')); !!}
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
                                {!! Form::label('aluNivelIngr', 'Nivel de ingreso *', array('class' => '')); !!}
                                <div style="position:relative;">
                                    <select id="aluNivelIngr" disabled class="browser-default validate select2" required name="aluNivelIngr" style="width: 100%;">
                                        <option value="" disabled>SELECCIONE UNA OPCIÓN</option>
                                        @foreach($departamentos as $departamento)
                                                <option value="{{$departamento->depNivel}}" {{ $alumno->aluNivelIngr == $departamento->depNivel ? 'selected' : '' }}>
    
                                                    {{$departamento->depClave}} -
                                                    @if ($departamento->depClave == "SUP") Superior @endif
                                                    @if ($departamento->depClave == "POS") Posgrado @endif
                                                    @if ($departamento->depClave == "DIP") Educacion Continua @endif
                                                    @if ($departamento->depClave == "MAT") Maternal @endif
                                                    @if ($departamento->depClave == "PRE") Prescolar @endif
                                                    @if ($departamento->depClave == "PRI") Primaria @endif
                                                    @if ($departamento->depClave == "SEC") Secundaria @endif
                                                    @if ($departamento->depClave == "BAC") Bachiller @endif

    
                                                </option>
                                            @endforeach
                                    </select>
                                    @if (isset($candidato))
                                        <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                                    @endif
                                </div>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::number('aluGradoIngr', $alumno->aluNivelIngr, array('id' => 'aluGradoIngr', 'class' => 'validate','min'=>'1','max'=>'6','onKeyPress="if(this.value.length>1) return false;"', 'readonly')) !!}
                            {!! Form::label('aluGradoIngr', 'Grado Ingreso *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- COLUMNA --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('perSexo', 'Sexo *', array('class' => '')); !!}
                            <div style="position:relative;">
                                <select id="perSexo" class="browser-default validate select2" required name="perSexo" style="width: 100%;">
                                    @php                                  
                                    if(old('perSexo') !== null){
                                        $perSexo = old('perSexo'); 
                                    }
                                    else{ $perSexo = $persona->perSexo; }
                                    @endphp
                                    <option value="M" {{ $perSexo == "M" ? 'selected' : '' }}>HOMBRE</option>
                                    <option value="F" {{ $perSexo == "F" ? 'selected' : '' }}>MUJER</option>
                                </select>                               
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            {!! Form::label('perFechaNac', 'Fecha de nacimiento *', array('class' => '')); !!}
                            {!! Form::date('perFechaNac',  $persona->perFechaNac,
                            array('id' => 'perFechaNac', 'class' => ' validate','required', 'readonly')) !!}
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
                                class="browser-default validate select2" required name="paisId" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @php                                  
                                    if(old('paisId') !== null){
                                        $option_pais = old('paisId'); 
                                    }
                                    else{ $option_pais = $pais_alumno->pais_id; }
                                    @endphp
                                @foreach ($paises as $pais)
                                    <option value="{{$pais->id}}" @if($option_pais == $pais->id) {{ 'selected' }} @endif>{{$pais->paisNombre}}</option>                
                                @endforeach
                            </select>                           
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                            {!! Form::label('estado_id', 'Estado *', array('class' => '')); !!}
                            <div style="position:relative">
                                <select id="estado_id" data-estado-id="{{old('estado_id')}}" class="browser-default validate select2" required name="estado_id" style="width: 100%;">
                                    @php                                  
                                    if(old('estado_id') !== null){
                                        $option_esta = old('estado_id'); 
                                    }
                                    else{ $option_esta = $estado_alumno->estado_id; }
                                    @endphp
                                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                    @foreach($estados as $estado)
                                        <option value="{{$estado->id}}" @if($option_esta == $estado->id) {{ 'selected' }} @endif>{{$estado->edoNombre}}</option>
                                    @endforeach
                                </select>                               
                            </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('municipio_id', 'Municipio *', array('class' => '')); !!}
                        <div style="position:relative">
                            <select id="municipio_id" data-municipio-id="{{old('municipio_id')}}" class="browser-default validate select2" required name="municipio_id" style="width: 100%;">
                                @php                                  
                                if(old('municipio_id') !== null){
                                    $option_muni = old('municipio_id'); 
                                }
                                else{ $option_muni = $persona->municipio_id; }
                                @endphp
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($municipios as $municipio)
                                    <option value="{{$municipio->id}}" {{ $option_muni == $municipio->id ? 'selected' : '' }}>{{$municipio->munNombre}}</option>
                                @endforeach
                            </select>
                           
                        </div>
                    </div>
                </div>
                <div class="row">               
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            @php                                  
                            if(old('tiempoResidencia') !== null){
                                $tiempoResidencia = old('tiempoResidencia'); 
                            }
                            else{ $tiempoResidencia = $alumnoEntrevista->tiempoResidencia; }
                            @endphp
                            {!! Form::text('tiempoResidencia', $tiempoResidencia, array('id' => 'tiempoResidencia', 'class' => 'validate', 'maxlength'=>'25')) !!}
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
                            @php                                  
                            if(old('nombrePadre') !== null){
                                $nombrePadre = old('nombrePadre'); 
                            }
                            else{ $nombrePadre = $alumnoEntrevista->nombrePadre; }
                            @endphp
                            {!! Form::text('nombrePadre', $nombrePadre, array('id' => 'nombrePadre', 'class' => 'validate','maxlength'=>'80')) !!}
                            {!! Form::label('nombrePadre', 'Nombre(s)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('apellido1Padre') !== null){
                                $apellido1Padre = old('apellido1Padre'); 
                            }
                            else{ $apellido1Padre = $alumnoEntrevista->apellido1Padre; }
                            @endphp
                            {!! Form::text('apellido1Padre', $apellido1Padre, array('id' => 'apellido1Padre', 'class' => 'validate','maxlength'=>'40')) !!}
                            {!! Form::label('apellido1Padre', 'Apellido 1 *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('apellido2Padre') !== null){
                                $apellido2Padre = old('apellido2Padre'); 
                            }
                            else{ $apellido2Padre = $alumnoEntrevista->apellido2Padre; }
                            @endphp
                            {!! Form::text('apellido2Padre', $apellido2Padre, array('id' => 'apellido2Padre', 'class' => 'validate','maxlength'=>'40')) !!}
                            {!! Form::label('apellido2Padre', 'Apellido 2', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('curpPadre') !== null){
                                $curpPadre = old('curpPadre'); 
                            }
                            else{ $curpPadre = $alumnoEntrevista->curpPadre; }
                            @endphp

                            {!! Form::text('curpPadre', $curpPadre, array('id' => 'curpPadre', 'class' => 'validate', 'maxlength'=>'18')) !!}
                            {!! Form::hidden('curpPadreOld', $curpPadre, ['id' => 'curpPadreOld']) !!}
                            {!! Form::hidden('esCurpValidaPadre', NULL, ['id' => 'esCurpValidaPadre']) !!}
                            {!! Form::label('curpPadre', 'Curp', array('class' => '')); !!}

                        </div>

                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            @php                                  
                            if(old('direccionPadre') !== null){
                                $direccionPadre = old('direccionPadre'); 
                            }
                            else{ $direccionPadre = $alumnoEntrevista->direccionPadre; }
                            @endphp
                            {!! Form::text('direccionPadre', $direccionPadre, array('id' => 'direccionPadre', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('direccionPadre', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('edadPadre') !== null){
                                $edadPadre = old('edadPadre'); 
                            }
                            else{ $edadPadre = $alumnoEntrevista->edadPadre; }
                            @endphp
                            {!! Form::number('edadPadre', $edadPadre, array('id' => 'edadPadre', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadPadre', 'Edad', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('celularPadre') !== null){
                                $celularPadre = old('celularPadre'); 
                            }
                            else{ $celularPadre = $alumnoEntrevista->celularPadre; }
                            @endphp
                            {!! Form::number('celularPadre', $celularPadre, array('id' => 'celularPadre', 'class' => 'validate', 'maxlength'=>'80')) !!}
                            {!! Form::label('celularPadre', 'Celular *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('ocupacionPadre') !== null){
                                $ocupacionPadre = old('ocupacionPadre'); 
                            }
                            else{ $ocupacionPadre = $alumnoEntrevista->ocupacionPadre; }
                            @endphp
                            {!! Form::text('ocupacionPadre', $ocupacionPadre, array('id' => 'ocupacionPadre', 'class' => 'validate', 'maxlength'=>'100')) !!}
                            {!! Form::label('ocupacionPadre', 'Ocupación', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('empresaPadre') !== null){
                                $empresaPadre = old('empresaPadre'); 
                            }
                            else{ $empresaPadre = $alumnoEntrevista->empresaPadre; }
                            @endphp
                            {!! Form::text('empresaPadre', $empresaPadre, array('id' => 'empresaPadre', 'class' => 'validate', 'maxlength'=>'80')) !!}
                            {!! Form::label('empresaPadre', 'Empresa', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('correoPadre') !== null){
                                $correoPadre = old('correoPadre'); 
                            }
                            else{ $correoPadre = $alumnoEntrevista->correoPadre; }
                            @endphp
                            {!! Form::email('correoPadre', $correoPadre, array('id' => 'correoPadre', 'class' => 'validate noUpperCase', 'maxlength'=>'80')) !!}
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
                            @php                                  
                            if(old('nombreMadre') !== null){
                                $nombreMadre = old('nombreMadre'); 
                            }
                            else{ $nombreMadre = $alumnoEntrevista->nombreMadre; }
                            @endphp
                            {!! Form::text('nombreMadre', $nombreMadre, array('id' => 'nombreMadre', 'class' => 'validate','maxlength'=>'80')) !!}
                            {!! Form::label('nombreMadre', 'Nombre(s)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('apellido1Madre') !== null){
                                $apellido1Madre = old('apellido1Madre'); 
                            }
                            else{ $apellido1Madre = $alumnoEntrevista->apellido1Madre; }
                            @endphp
                            {!! Form::text('apellido1Madre', $apellido1Madre, array('id' => 'apellido1Madre', 'class' => 'validate','maxlength'=>'40')) !!}
                            {!! Form::label('apellido1Madre', 'Apellido 1 *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('apellido2Madre') !== null){
                                $apellido2Madre = old('apellido2Madre'); 
                            }
                            else{ $apellido2Madre = $alumnoEntrevista->apellido2Madre; }
                            @endphp
                            {!! Form::text('apellido2Madre', $apellido2Madre, array('id' => 'apellido2Madre', 'class' => 'validate','maxlength'=>'40')) !!}
                            {!! Form::label('apellido2Madre', 'Apellido 2', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('curpMadre') !== null){
                                $curpMadre = old('curpMadre'); 
                            }
                            else{ $curpMadre = $alumnoEntrevista->curpMadre; }
                            @endphp

                            {!! Form::text('curpMadre', $curpMadre, array('id' => 'curpMadre', 'class' => 'validate', 'maxlength'=>'18')) !!}
                            {!! Form::hidden('curpMadreOld', $curpMadre, ['id' => 'curpMadreOld']) !!}
                            {!! Form::hidden('esCurpValidaMadre', NULL, ['id' => 'esCurpValidaMadre']) !!}
                            {!! Form::label('curpMadre', 'Curp', array('class' => '')); !!}
                            
                        </div>
                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            @php                                  
                            if(old('direccionMadre') !== null){
                                $direccionMadre = old('direccionMadre'); 
                            }
                            else{ $direccionMadre = $alumnoEntrevista->direccionMadre; }
                            @endphp
                            {!! Form::text('direccionMadre', $direccionMadre, array('id' => 'direccionMadre', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('direccionMadre', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('edadMadre') !== null){
                                $edadMadre = old('edadMadre'); 
                            }
                            else{ $edadMadre = $alumnoEntrevista->edadMadre; }
                            @endphp
                            {!! Form::number('edadMadre', $edadMadre, array('id' => 'edadMadre', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadMadre', 'Edad', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('celularMadre') !== null){
                                $celularMadre = old('celularMadre'); 
                            }
                            else{ $celularMadre = $alumnoEntrevista->celularMadre; }
                            @endphp
                            {!! Form::number('celularMadre', $celularMadre, array('id' => 'celularMadre', 'class' => 'validate', 'maxlength'=>'80')) !!}
                            {!! Form::label('celularMadre', 'Celular *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('ocupacionMadre') !== null){
                                $ocupacionMadre = old('ocupacionMadre'); 
                            }
                            else{ $ocupacionMadre = $alumnoEntrevista->ocupacionMadre; }
                            @endphp
                            {!! Form::text('ocupacionMadre', $ocupacionMadre, array('id' => 'ocupacionMadre', 'class' => 'validate', 'maxlength'=>'100')) !!}
                            {!! Form::label('ocupacionMadre', 'Ocupación', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('empresaMadre') !== null){
                                $empresaMadre = old('empresaMadre'); 
                            }
                            else{ $empresaMadre = $alumnoEntrevista->empresaMadre; }
                            @endphp
                            {!! Form::text('empresaMadre', $empresaMadre, array('id' => 'empresaMadre', 'class' => 'validate', 'maxlength'=>'80')) !!}
                            {!! Form::label('empresaMadre', 'Empresa', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('correoMadre') !== null){
                                $correoMadre = old('correoMadre'); 
                            }
                            else{ $correoMadre = $alumnoEntrevista->correoMadre; }
                            @endphp
                            {!! Form::email('correoMadre', $correoMadre, array('id' => 'correoMadre', 'class' => 'validate noUpperCase', 'maxlength'=>'80')) !!}
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
                            @php                                  
                                if(old('estadoCivilPadres') !== null){
                                    $estadoCivil = old('estadoCivilPadres'); 
                                }
                                else{ $estadoCivil = $alumnoEntrevista->estadoCivilPadres; }
                            @endphp
                            <option value="UNION LIBRE" {{ $estadoCivil == "UNION LIBRE" ? 'selected' : '' }}>Unión Libre</option>
                            <option value="CASADOS" {{ $estadoCivil == "CASADOS" ? 'selected' : '' }}>Casados</option>
                            <option value="DIVORCIADOS" {{ $estadoCivil == "DIVORCIADOS" ? 'selected' : '' }}>Divorciados</option>
                            <option value="SEPARADOS" {{ $estadoCivil == "SEPARADOS" ? 'selected' : '' }}>Separados</option>
                        </select>
                    </div>
                   
                    {{-- ¿Tienen alguna religión? ¿Cuál? * --}}
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('religion') !== null){
                                $religion = old('religion'); 
                            }
                            else{ $religion = $alumnoEntrevista->religion; }
                            @endphp
                            {!! Form::text('religion', $religion, array('id' => 'religion', 'class' => 'validate','maxlength'=>'100')) !!}
                            {!! Form::label('religion', 'Religión', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="input-field">
                            @php                                  
                            if(old('observaciones') !== null){
                                $observaciones = old('observaciones'); 
                            }
                            else{ $observaciones = $alumnoEntrevista->observaciones; }
                            @endphp
                            <textarea id="observaciones" name="observaciones" class="materialize-textarea">{{$observaciones}}</textarea>
                            {!! Form::label('observaciones', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>

                
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="input-field">
                            @php                                  
                            if(old('condicionFamiliar') !== null){
                                $condicionFamiliar = old('condicionFamiliar'); 
                            }
                            else{ $condicionFamiliar = $alumnoEntrevista->condicionFamiliar; }
                            @endphp
                            <textarea id="condicionFamiliar" name="condicionFamiliar" class="materialize-textarea">{{$condicionFamiliar}}</textarea>
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
                            @php                                  
                            if(old('tutorResponsable') !== null){
                                $tutorResponsable = old('tutorResponsable'); 
                            }
                            else{ $tutorResponsable = $alumnoEntrevista->tutorResponsable; }
                            @endphp
                            {!! Form::text('tutorResponsable', $tutorResponsable, array('id' => 'tutorResponsable', 'class' => 'validate','maxlength'=>'80')) !!}
                            {!! Form::label('tutorResponsable', 'Padre o tutor responsable financiero *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('celularTutor') !== null){
                                $celularTutor = old('celularTutor'); 
                            }
                            else{ $celularTutor = $alumnoEntrevista->celularTutor; }
                            @endphp
                            {!! Form::number('celularTutor', $celularTutor, array('id' => 'celularTutor', 'class' => 'validate', 'maxlength'=>'10')) !!}
                            {!! Form::label('celularTutor', 'Celular *', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('accidenteLlamar') !== null){
                                $accidenteLlamar = old('accidenteLlamar'); 
                            }
                            else{ $accidenteLlamar = $alumnoEntrevista->accidenteLlamar; }
                            @endphp
                            {!! Form::text('accidenteLlamar', $accidenteLlamar, array('id' => 'accidenteLlamar', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('accidenteLlamar', 'En caso de algún accidente se deberá llamar a *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('celularAccidente') !== null){
                                $celularAccidente = old('celularAccidente'); 
                            }
                            else{ $celularAccidente = $alumnoEntrevista->celularAccidente; }
                            @endphp
                            {!! Form::number('celularAccidente', $celularAccidente, array('id' => 'celularAccidente', 'class' => 'validate', 'maxlength'=>'10')) !!}
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
                            @php                                  
                            if(old('perAutorizada1') !== null){
                                $perAutorizada1 = old('perAutorizada1'); 
                            }
                            else{ $perAutorizada1 = $alumnoEntrevista->perAutorizada1; }
                            @endphp
                            {!! Form::text('perAutorizada1', $perAutorizada1, array('id' => 'perAutorizada1', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante1', 'Persona 1', array('class' => '')); !!}
                        </div>
                    </div>   
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            @php                                  
                            if(old('perAutorizada2') !== null){
                                $perAutorizada2 = old('perAutorizada2'); 
                            }
                            else{ $perAutorizada2 = $alumnoEntrevista->perAutorizada2; }
                            @endphp
                            {!! Form::text('perAutorizada2', $perAutorizada2, array('id' => 'perAutorizada2', 'class' => 'validate','maxlength'=>'255')) !!}
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
                            @php                                  
                            if(old('integrante1') !== null){
                                $integrante1 = old('integrante1'); 
                            }
                            else{ $integrante1 = $alumnoEntrevista->integrante1; }
                            @endphp
                            {!! Form::text('integrante1', $integrante1, array('id' => 'integrante1', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante1', 'Integrante 1', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('relacionIntegrante1') !== null){
                                $relacionIntegrante1 = old('relacionIntegrante1'); 
                            }
                            else{ $relacionIntegrante1 = $alumnoEntrevista->relacionIntegrante1; }
                            @endphp
                            {!! Form::text('relacionIntegrante1', $relacionIntegrante1, array('id' => 'relacionIntegrante1', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('relacionIntegrante1', 'Relación integrante 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('edadintegrante1') !== null){
                                $edadintegrante1 = old('edadintegrante1'); 
                            }
                            else{ $edadintegrante1 = $alumnoEntrevista->edadintegrante1; }
                            @endphp
                            {!! Form::number('edadintegrante1', $edadintegrante1, array('id' => 'edadintegrante1', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadintegrante1', 'Edad integrante 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('ocupacionIntegrante1') !== null){
                                $ocupacionIntegrante1 = old('ocupacionIntegrante1'); 
                            }
                            else{ $ocupacionIntegrante1 = $alumnoEntrevista->ocupacionIntegrante1; }
                            @endphp
                            {!! Form::text('ocupacionIntegrante1', $ocupacionIntegrante1, array('id' => 'ocupacionIntegrante1', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('ocupacionIntegrante1', 'Ocupación integrante 1', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('integrante2') !== null){
                                $integrante2 = old('integrante2'); 
                            }
                            else{ $integrante2 = $alumnoEntrevista->integrante2; }
                            @endphp
                            {!! Form::text('integrante2', $integrante2, array('id' => 'integrante2', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante2', 'Integrante 2', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('relacionIntegrante2') !== null){
                                $relacionIntegrante2 = old('relacionIntegrante2'); 
                            }
                            else{ $relacionIntegrante2 = $alumnoEntrevista->relacionIntegrante2; }
                            @endphp
                            {!! Form::text('relacionIntegrante2', $relacionIntegrante2, array('id' => 'relacionIntegrante2', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('relacionIntegrante2', 'Relación integrante 2', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('edadintegrante2') !== null){
                                $edadintegrante2 = old('edadintegrante2'); 
                            }
                            else{ $edadintegrante2 = $alumnoEntrevista->edadintegrante2; }
                            @endphp
                            {!! Form::number('edadintegrante2', $edadintegrante2, array('id' => 'edadintegrante2', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadintegrante2', 'Edad integrante 2', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('ocupacionIntegrante2') !== null){
                                $ocupacionIntegrante2 = old('ocupacionIntegrante2'); 
                            }
                            else{ $ocupacionIntegrante2 = $alumnoEntrevista->ocupacionIntegrante2; }
                            @endphp
                            {!! Form::text('ocupacionIntegrante2', $ocupacionIntegrante2, array('id' => 'ocupacionIntegrante2', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('ocupacionIntegrante2', 'Ocupación integrante 2', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                {{--  integrante 3   --}}
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('integrante3') !== null){
                                $integrante3 = old('integrante3'); 
                            }
                            else{ $integrante3 = $alumnoEntrevista->integrante3; }
                            @endphp
                            {!! Form::text('integrante3', $integrante3, array('id' => 'integrante3', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante3', 'Integrante 3', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('relacionIntegrante3') !== null){
                                $relacionIntegrante3 = old('relacionIntegrante3'); 
                            }
                            else{ $relacionIntegrante3 = $alumnoEntrevista->relacionIntegrante3; }
                            @endphp
                            {!! Form::text('relacionIntegrante3', $relacionIntegrante3, array('id' => 'relacionIntegrante3', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('relacionIntegrante3', 'Relación integrante 3', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('edadintegrante3') !== null){
                                $edadintegrante3 = old('edadintegrante3'); 
                            }
                            else{ $edadintegrante3 = $alumnoEntrevista->edadintegrante3; }
                            @endphp
                            {!! Form::number('edadintegrante3', $edadintegrante3, array('id' => 'edadintegrante3', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadintegrante3', 'Edad integrante 3', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('ocupacionIntegrante3') !== null){
                                $ocupacionIntegrante3 = old('ocupacionIntegrante3'); 
                            }
                            else{ $ocupacionIntegrante3 = $alumnoEntrevista->ocupacionIntegrante3; }
                            @endphp
                            {!! Form::text('ocupacionIntegrante3', $ocupacionIntegrante3, array('id' => 'ocupacionIntegrante3', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('ocupacionIntegrante3', 'Ocupación integrante 3', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                {{--  integrante 4   --}}
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('integrante4') !== null){
                                $integrante4 = old('integrante4'); 
                            }
                            else{ $integrante4 = $alumnoEntrevista->integrante4; }
                            @endphp
                            {!! Form::text('integrante4', $integrante4, array('id' => 'integrante4', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante4', 'Integrante 4', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('relacionIntegrante4') !== null){
                                $relacionIntegrante4 = old('relacionIntegrante4'); 
                            }
                            else{ $relacionIntegrante4 = $alumnoEntrevista->relacionIntegrante4; }
                            @endphp
                            {!! Form::text('relacionIntegrante4', $relacionIntegrante4, array('id' => 'relacionIntegrante4', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('relacionIntegrante4', 'Relación integrante 4', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('edadintegrante4') !== null){
                                $edadintegrante4 = old('edadintegrante4'); 
                            }
                            else{ $edadintegrante4 = $alumnoEntrevista->edadintegrante4; }
                            @endphp
                            {!! Form::number('edadintegrante4', $edadintegrante4, array('id' => 'edadintegrante4', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadintegrante4', 'Edad integrante 4', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('ocupacionIntegrante4') !== null){
                                $ocupacionIntegrante4 = old('ocupacionIntegrante4'); 
                            }
                            else{ $ocupacionIntegrante4 = $alumnoEntrevista->ocupacionIntegrante4; }
                            @endphp
                            {!! Form::text('ocupacionIntegrante4', $ocupacionIntegrante4, array('id' => 'ocupacionIntegrante4', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('ocupacionIntegrante4', 'Ocupación integrante 4', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                {{--  integrante 5   --}}
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('integrante5') !== null){
                                $integrante5 = old('integrante5'); 
                            }
                            else{ $integrante5 = $alumnoEntrevista->integrante5; }
                            @endphp
                            {!! Form::text('integrante5', $integrante5, array('id' => 'integrante5', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante5', 'Integrante 5', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('relacionIntegrante5') !== null){
                                $relacionIntegrante5 = old('relacionIntegrante5'); 
                            }
                            else{ $relacionIntegrante5 = $alumnoEntrevista->relacionIntegrante5; }
                            @endphp
                            {!! Form::text('relacionIntegrante5', $relacionIntegrante5, array('id' => 'relacionIntegrante5', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('relacionIntegrante5', 'Relación integrante 5', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('edadintegrante5') !== null){
                                $edadintegrante5 = old('edadintegrante5'); 
                            }
                            else{ $edadintegrante5 = $alumnoEntrevista->edadintegrante5; }
                            @endphp
                            {!! Form::number('edadintegrante5', $edadintegrante5, array('id' => 'edadintegrante5', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadintegrante5', 'Edad integrante 5', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('ocupacionIntegrante5') !== null){
                                $ocupacionIntegrante5 = old('ocupacionIntegrante5'); 
                            }
                            else{ $ocupacionIntegrante5 = $alumnoEntrevista->ocupacionIntegrante5; }
                            @endphp
                            {!! Form::text('ocupacionIntegrante5', $ocupacionIntegrante5, array('id' => 'ocupacionIntegrante5', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('ocupacionIntegrante5', 'Ocupación integrante 5', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                {{--  integrante 6   --}}
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('integrante6') !== null){
                                $integrante6 = old('integrante6'); 
                            }
                            else{ $integrante6 = $alumnoEntrevista->integrante6; }
                            @endphp
                            {!! Form::text('integrante6', $integrante6, array('id' => 'integrante6', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante6', 'Integrante 6', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('relacionIntegrante6') !== null){
                                $relacionIntegrante6 = old('relacionIntegrante6'); 
                            }
                            else{ $relacionIntegrante6 = $alumnoEntrevista->relacionIntegrante6; }
                            @endphp
                            {!! Form::text('relacionIntegrante6', $relacionIntegrante6, array('id' => 'relacionIntegrante6', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('relacionIntegrante6', 'Relación integrante 6', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('edadintegrante6') !== null){
                                $edadintegrante6 = old('edadintegrante6'); 
                            }
                            else{ $edadintegrante6 = $alumnoEntrevista->edadintegrante6; }
                            @endphp
                            {!! Form::number('edadintegrante6', $alumnoEntrevista->edadintegrante6, array('id' => 'edadintegrante6', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadintegrante6', 'Edad integrante 6', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('ocupacionIntegrante6') !== null){
                                $ocupacionIntegrante6 = old('ocupacionIntegrante6'); 
                            }
                            else{ $ocupacionIntegrante6 = $alumnoEntrevista->ocupacionIntegrante6; }
                            @endphp
                            {!! Form::text('ocupacionIntegrante6', $ocupacionIntegrante6, array('id' => 'ocupacionIntegrante6', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('ocupacionIntegrante6', 'Ocupación integrante 6', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                 {{--  integrante 7   --}}
                 <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('integrante7') !== null){
                                $integrante7 = old('integrante7'); 
                            }
                            else{ $integrante7 = $alumnoEntrevista->integrante7; }
                            @endphp
                            {!! Form::text('integrante7', $integrante7, array('id' => 'integrante7', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante7', 'Integrante 7', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('relacionIntegrante7') !== null){
                                $relacionIntegrante7 = old('relacionIntegrante7'); 
                            }
                            else{ $relacionIntegrante7 = $alumnoEntrevista->relacionIntegrante7; }
                            @endphp
                            {!! Form::text('relacionIntegrante7', $relacionIntegrante7, array('id' => 'relacionIntegrante7', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('relacionIntegrante7', 'Relación integrante 7', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('edadintegrante7') !== null){
                                $edadintegrante7 = old('edadintegrante7'); 
                            }
                            else{ $edadintegrante7 = $alumnoEntrevista->edadintegrante7; }
                            @endphp
                            {!! Form::number('edadintegrante7', $edadintegrante7, array('id' => 'edadintegrante7', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadintegrante7', 'Edad integrante 7', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('ocupacionIntegrante7') !== null){
                                $ocupacionIntegrante7 = old('ocupacionIntegrante7'); 
                            }
                            else{ $ocupacionIntegrante7 = $alumnoEntrevista->ocupacionIntegrante7; }
                            @endphp
                            {!! Form::text('ocupacionIntegrante7', $ocupacionIntegrante7, array('id' => 'ocupacionIntegrante7', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('ocupacionIntegrante7', 'Ocupación integrante 7', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('conQuienViveAlumno') !== null){
                                $conQuienViveAlumno = old('conQuienViveAlumno'); 
                            }
                            else{ $conQuienViveAlumno = $alumnoEntrevista->conQuienViveAlumno; }
                            @endphp
                            {!! Form::text('conQuienViveAlumno', $conQuienViveAlumno, array('id' => 'conQuienViveAlumno', 'class' => 'validate', 'maxlength'=>'100')) !!}
                            {!! Form::label('conQuienViveAlumno', '¿Con quien vivi el alumno(a)? *', array('class' => '')); !!}
                        </div>
                    </div>  
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            @php                                  
                            if(old('direccionViviendaAlumno') !== null){
                                $direccionViviendaAlumno = old('direccionViviendaAlumno'); 
                            }
                            else{ $direccionViviendaAlumno = $alumnoEntrevista->direccionViviendaAlumno; }
                            @endphp
                            {!! Form::text('direccionViviendaAlumno', $direccionViviendaAlumno, array('id' => 'direccionViviendaAlumno', 'class' => 'validate', 'maxlength'=>'100')) !!}
                            {!! Form::label('direccionViviendaAlumno', 'Dirección donde vivie el alumno *', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 m12">
                        <div class="input-field">
                            <label for="situcionLegal">Situación legal: <b>*Entregar copia simple que avale el proceso en todos los casos de Guarda y
                                Custodia que ya haya tenido una sentencia definitiva o se encuentren en un proceso legal.</b></label>
                                @php                                  
                                if(old('situcionLegal') !== null){
                                    $situcionLegal = old('situcionLegal'); 
                                }
                                else{ $situcionLegal = $alumnoEntrevista->situcionLegal; }
                                @endphp
                            <textarea id="situcionLegal" name="situcionLegal" class="materialize-textarea validate">{{$situcionLegal}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 m6">
                        <div class="input-field">
                            <label for="descripcionNinio">¿Cómo describen los padres al niño/a?</label>
                            @php                                  
                            if(old('descripcionNinio') !== null){
                                $descripcionNinio = old('descripcionNinio'); 
                            }
                            else{ $descripcionNinio = $alumnoEntrevista->descripcionNinio; }
                            @endphp
                            <textarea id="descripcionNinio" name="descripcionNinio" class="materialize-textarea validate">{{$descripcionNinio}}</textarea>
                        </div>
                    </div>

                    <div class="col s12 m6 l6">
                        <div class="input-field">                            
                            @php                                  
                            if(old('apoyoTarea') !== null){
                                $apoyoTarea = old('apoyoTarea'); 
                            }
                            else{ $apoyoTarea = $alumnoEntrevista->apoyoTarea; }
                            @endphp
                            {!! Form::text('apoyoTarea', $apoyoTarea, array('id' => 'apoyoTarea', 'class' => 'validate', 'maxlength'=>'50')) !!}
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
                            @php                                  
                            if(old('escuelaAnterior') !== null){
                                $escuelaAnterior = old('escuelaAnterior'); 
                            }
                            else{ $escuelaAnterior = $alumnoEntrevista->escuelaAnterior; }
                            @endphp
                            {!! Form::text('escuelaAnterior', $escuelaAnterior, array('id' => 'escuelaAnterior', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('escuelaAnterior', 'Nombre de la escuela anterior', array('class' => '')); !!}
                        </div>
                    </div>  

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('aniosEstudiados') !== null){
                                $aniosEstudiados = old('aniosEstudiados'); 
                            }
                            else{ $aniosEstudiados = $alumnoEntrevista->aniosEstudiados; }
                            @endphp
                            {!! Form::number('aniosEstudiados', $aniosEstudiados, array('id' => 'aniosEstudiados', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('aniosEstudiados', 'Años estudiados en la escuela anterior', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('motivosCambioEscuela') !== null){
                                $motivosCambioEscuela = old('motivosCambioEscuela'); 
                            }
                            else{ $motivosCambioEscuela = $alumnoEntrevista->motivosCambioEscuela; }
                            @endphp
                            {!! Form::text('motivosCambioEscuela', $alumnoEntrevista->motivosCambioEscuela, array('id' => 'motivosCambioEscuela', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('motivosCambioEscuela', 'Motivos del cambio de escuela', array('class' => '')); !!}
                        </div>
                    </div>  
                </div>


                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            @php                                  
                            if(old('kinder') !== null){
                                $kinder = old('kinder'); 
                            }
                            else{ $kinder = $alumnoEntrevista->kinder; }
                            @endphp
                            {!! Form::text('kinder', $kinder, array('id' => 'kinder', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('kinder', 'Kínder', array('class' => '')); !!}
                        </div>
                    </div>  
                    <div class="col s12 m6 l6">
                        <label for="">Grados estudiados</label>                    
                        

                        <div style="margin-top: 12px;" class='form-check checkbox-warning-filled'>
                            <input class='filled-in' type='checkbox' name='preescolar1' value='' {{ old('preescolar1') == 'SI' ? 'checked' : '' }} id='preescolar1'><label style="margin-right: 17px;" for='preescolar1'>1ro</label>
                            <input class='filled-in' type='checkbox' name='preescolar2' value='' {{ old('preescolar2') == 'SI' ? 'checked' : '' }} id='preescolar2'><label style="margin-right: 17px;" for='preescolar2'>2do</label>
                            <input class='filled-in' type='checkbox' name='preescolar3' value='' {{ old('preescolar3') == 'SI' ? 'checked' : '' }} id='preescolar3'><label style="margin-right: 17px;" for='preescolar3'>3do</label>
                        </div>

                        <script>
                            if('{{$alumnoEntrevista->preescolar1}}' == 'SI'){
                                $("#preescolar1").prop("checked", true);
                                $("#preescolar1").val("SI");
                            }else{
                                $("#preescolar1").prop("checked", false);
                                $("#preescolar1").val("NO");
                            }

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

                            if('{{$alumnoEntrevista->preescolar2}}' == 'SI'){
                                $("#preescolar2").prop("checked", true);
                                $("#preescolar2").val("SI");
                            }else{
                                $("#preescolar2").prop("checked", false);
                                $("#preescolar2").val("NO");
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

                            if('{{$alumnoEntrevista->preescolar3}}' == 'SI'){
                                $("#preescolar3").prop("checked", true);
                                $("#preescolar3").val("SI");
                            }else{
                                $("#preescolar3").prop("checked", false);
                                $("#preescolar3").val("NO");
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
                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            @php                                  
                            if(old('observacionEscolar') !== null){
                                $observacionEscolar = old('observacionEscolar'); 
                            }
                            else{ $observacionEscolar = $alumnoEntrevista->observacionEscolar; }
                            @endphp
                            {!! Form::text('observacionEscolar', $observacionEscolar, array('id' => 'observacionEscolar', 'class' => 'validate', 'maxlength'=>'9000')) !!}
                            {!! Form::label('observacionEscolar', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p>Primaria</p>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio1">Promedio en 1º</label>
                            @php                                  
                            if(old('promedio1') !== null){
                                $promedio1 = old('promedio1'); 
                            }
                            else{ $promedio1 = $alumnoEntrevista->promedio1; }
                            @endphp
                            <input type="number" name="promedio1" id="promedio1" max="10" min="0" step="0.0" value="{{$promedio1}}">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio2">Promedio en 2º</label>
                            @php  
                            if(old('promedio2') !== null){
                                $promedio2 = old('promedio2'); 
                            }
                            else{ $promedio2 = $alumnoEntrevista->promedio2; }
                            @endphp
                            <input type="number" name="promedio2" id="promedio2" max="10" min="0" step="0.0" value="{{$promedio2}}">
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio3">Promedio en 3º</label>
                            @php                            
                            if(old('promedio3') !== null){
                                $promedio3 = old('promedio3'); 
                            }
                            else{ $promedio3 = $alumnoEntrevista->promedio3; }
                            @endphp
                            <input type="number" name="promedio3" id="promedio3" max="10" min="0" step="0.0" value="{{$promedio3}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio4">Promedio en 4º</label>
                            @php                            
                            if(old('promedio4') !== null){
                                $promedio4 = old('promedio4'); 
                            }
                            else{ $promedio4 = $alumnoEntrevista->promedio4; }
                            @endphp
                            <input type="number" name="promedio4" id="promedio4" max="10" min="0" step="0.0" value="{{$promedio4}}">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio5">Promedio en 5º</label>
                            @php                            
                            if(old('promedio5') !== null){
                                $promedio5 = old('promedio5'); 
                            }
                            else{ $promedio5 = $alumnoEntrevista->promedio5; }
                            @endphp
                            <input type="number" name="promedio5" id="promedio5" max="10" min="0" step="0.0" value="{{$promedio5}}">
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio6">Promedio en 6º</label>
                            @php                            
                            if(old('promedio6') !== null){
                                $promedio6 = old('promedio6'); 
                            }
                            else{ $promedio6 = $alumnoEntrevista->promedio6; }
                            @endphp
                            <input type="number" name="promedio6" id="promedio6" max="10" min="0" step="0.0" value="{{$promedio6}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            @php                                  
                            if(old('recursamientoGrado') !== null){
                                $recursamientoGrado = old('recursamientoGrado'); 
                            }
                            else{ $recursamientoGrado = $alumnoEntrevista->recursamientoGrado; }
                            @endphp
                            {!! Form::text('recursamientoGrado', $recursamientoGrado, array('id' => 'recursamientoGrado', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('recursamientoGrado', 'Recursamiento de algún grado', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            @php                                  
                            if(old('deportes') !== null){
                                $deportes = old('deportes'); 
                            }
                            else{ $deportes = $alumnoEntrevista->deportes; }
                            @endphp
                            {!! Form::text('deportes', $deportes, array('id' => 'deportes', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('deportes', 'Deporte (s) o actividad cultural que practica', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('apoyoPedagogico', '¿Ha recibido su hijo(a) apoyo pedagógico en algún grado escolar? *', ['class' => '']); !!}
                        <select name="apoyoPedagogico" id="apoyoPedagogico" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                                if(old('apoyoPedagogico') !== null){
                                    $apoyoPedagogico = old('apoyoPedagogico'); 
                                }
                                else{ $apoyoPedagogico = $alumnoEntrevista->apoyoPedagogico; }
                            @endphp
                            <option value="NO" {{ $apoyoPedagogico == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $apoyoPedagogico == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            @php                                  
                            if(old('obsPedagogico') !== null){
                                $obsPedagogico = old('obsPedagogico'); 
                            }
                            else{ $obsPedagogico = $alumnoEntrevista->obsPedagogico; }
                            @endphp
                            {!! Form::text('obsPedagogico', $obsPedagogico, array('id' => 'obsPedagogico', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('obsPedagogico', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('terapiaLenguaje', '¿Ha recibido su hijo(a) terapia de lenguaje en algún grado escolar? *', ['class' => '']); !!}
                        <select name="terapiaLenguaje" id="terapiaLenguaje" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('terapiaLenguaje') !== null){
                                $terapiaLenguaje = old('terapiaLenguaje'); 
                            }
                            else{ $terapiaLenguaje = $alumnoEntrevista->terapiaLenguaje; }
                            @endphp
                            <option value="NO" {{ $terapiaLenguaje == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $terapiaLenguaje == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            @php                                  
                            if(old('obsTerapiaLenguaje') !== null){
                                $obsTerapiaLenguaje = old('obsTerapiaLenguaje'); 
                            }
                            else{ $obsTerapiaLenguaje = $alumnoEntrevista->obsTerapiaLenguaje; }
                            @endphp
                            {!! Form::text('obsTerapiaLenguaje', $obsTerapiaLenguaje, array('id' => 'obsTerapiaLenguaje', 'class' => 'validate', 'maxlength'=>'255')) !!}
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
                        <select name="" id="tratamientoMedico" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('tratamientoMedico') !== null){
                                $tratamientoMedico = old('tratamientoMedico'); 
                            }
                            else{ $tratamientoMedico = $alumnoEntrevista->tratamientoMedico; }
                            @endphp
                            <option value="NO" {{ $tratamientoMedico == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $tratamientoMedico == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            @php                                  
                            if(old('obsTratamientoMedico') !== null){
                                $obsTratamientoMedico = old('obsTratamientoMedico'); 
                            }
                            else{ $obsTratamientoMedico = $alumnoEntrevista->obsTratamientoMedico; }
                            @endphp
                            {!! Form::text('obsTratamientoMedico', $obsTratamientoMedico, array('id' => 'obsTratamientoMedico', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('obsTratamientoMedico', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p>¿Actualmente presenta algún padecimiento?</p>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('hemofilia', 'Hemofilia *', ['class' => '']); !!}
                        <select name="hemofilia" id="hemofilia" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('hemofilia') !== null){
                                $hemofilia = old('hemofilia'); 
                            }
                            else{ $hemofilia = $alumnoEntrevista->hemofilia; }
                            @endphp
                            <option value="NO" {{ $hemofilia == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $hemofilia == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            @php                                  
                            if(old('obsHemofilia') !== null){
                                $obsHemofilia = old('obsHemofilia'); 
                            }
                            else{ $obsHemofilia = $alumnoEntrevista->obsHemofilia; }
                            @endphp
                            {!! Form::text('obsHemofilia', $obsHemofilia, array('id' => 'obsHemofilia', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsHemofilia', 'Observaciones hemofilia *', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>
                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('epilepsia', 'Epilepsia *', ['class' => '']); !!}
                        <select name="epilepsia" id="epilepsia" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('epilepsia') !== null){
                                $epilepsia = old('epilepsia'); 
                            }
                            else{ $epilepsia = $alumnoEntrevista->epilepsia; }
                            @endphp
                            <option value="NO" {{ $epilepsia == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $epilepsia == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            @php                                  
                            if(old('obsEpilepsia') !== null){
                                $obsEpilepsia = old('obsEpilepsia'); 
                            }
                            else{ $obsEpilepsia = $alumnoEntrevista->obsEpilepsia; }
                            @endphp
                            {!! Form::text('obsEpilepsia', $obsEpilepsia, array('id' => 'obsEpilepsia', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsEpilepsia', 'Observaciones epilepsia *', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('kawasaqui', 'Kawasaqui *', ['class' => '']); !!}
                        <select name="kawasaqui" id="kawasaqui" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('kawasaqui') !== null){
                                $kawasaqui = old('kawasaqui'); 
                            }
                            else{ $kawasaqui = $alumnoEntrevista->kawasaqui; }
                            @endphp
                            <option value="NO" {{ $kawasaqui == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $kawasaqui == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            @php                                  
                            if(old('obsKawasaqui') !== null){
                                $obsKawasaqui = old('obsKawasaqui'); 
                            }
                            else{ $obsKawasaqui = $alumnoEntrevista->obsKawasaqui; }
                            @endphp
                            {!! Form::text('obsKawasaqui', $obsKawasaqui, array('id' => 'obsKawasaqui', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsKawasaqui', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                      
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('asma', 'Asma *', ['class' => '']); !!}
                        <select name="asma" id="asma" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('asma') !== null){
                                $asma = old('asma'); 
                            }
                            else{ $asma = $alumnoEntrevista->asma; }
                            @endphp
                            <option value="NO" {{ $asma == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $asma == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            @php                                  
                            if(old('obsAsma') !== null){
                                $obsAsma = old('obsAsma'); 
                            }
                            else{ $obsAsma = $alumnoEntrevista->obsAsma; }
                            @endphp
                            {!! Form::text('obsAsma', $obsAsma, array('id' => 'obsAsma', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsAsma', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('diabetes', 'Diabetes *', ['class' => '']); !!}
                        <select name="diabetes" id="diabetes" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('diabetes') !== null){
                                $diabetes = old('diabetes'); 
                            }
                            else{ $diabetes = $alumnoEntrevista->diabetes; }
                            @endphp
                            <option value="NO" {{ $diabetes == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $diabetes == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            @php                                  
                            if(old('obsDiabetes') !== null){
                                $obsDiabetes = old('obsDiabetes'); 
                            }
                            else{ $obsDiabetes = $alumnoEntrevista->obsDiabetes; }
                            @endphp
                            {!! Form::text('obsDiabetes', $obsDiabetes, array('id' => 'obsDiabetes', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsDiabetes', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('cardiaco', 'Cardiaco *', ['class' => '']); !!}
                        <select name="cardiaco" id="cardiaco" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('cardiaco') !== null){
                                $cardiaco = old('cardiaco'); 
                            }
                            else{ $cardiaco = $alumnoEntrevista->cardiaco; }
                            @endphp
                            <option value="NO" {{ $cardiaco == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $cardiaco == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            @php                                  
                            if(old('obsCardiaco') !== null){
                                $obsCardiaco = old('obsCardiaco'); 
                            }
                            else{ $obsCardiaco = $alumnoEntrevista->obsCardiaco; }
                            @endphp
                            {!! Form::text('obsCardiaco', $obsCardiaco, array('id' => 'obsCardiaco', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsCardiaco', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                      
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('dermatologico', 'Dermatológico *', ['class' => '']); !!}
                        <select name="dermatologico" id="dermatologico" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('dermatologico') !== null){
                                $dermatologico = old('dermatologico'); 
                            }
                            else{ $dermatologico = $alumnoEntrevista->dermatologico; }
                            @endphp
                            <option value="NO" {{ $dermatologico == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $dermatologico == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            @php                                  
                            if(old('obsDermatologico') !== null){
                                $obsDermatologico = old('obsDermatologico'); 
                            }
                            else{ $obsDermatologico = $alumnoEntrevista->obsDermatologico; }
                            @endphp
                            {!! Form::text('obsDermatologico', $obsDermatologico, array('id' => 'obsDermatologico', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('obsDermatologico', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                   
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('alergias', 'Alergias *', ['class' => '']); !!}
                        <select name="alergias" id="alergias" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('alergias') !== null){
                                $alergias = old('alergias'); 
                            }
                            else{ $alergias = $alumnoEntrevista->alergias; }
                            @endphp
                            <option value="NO" {{ $alergias == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ $alergias == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            @php                                  
                            if(old('tipoAlergias') !== null){
                                $tipoAlergias = old('tipoAlergias'); 
                            }
                            else{ $tipoAlergias = $alumnoEntrevista->tipoAlergias; }
                            @endphp
                            {!! Form::text('tipoAlergias', $tipoAlergias, array('id' => 'tipoAlergias', 'class' => 'validate', 'maxlength'=>'255', 'disabled')) !!}
                            {!! Form::label('tipoAlergias', 'Observaciones alergias *', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            @php                                  
                            if(old('otroTratamiento') !== null){
                                $otroTratamiento = old('otroTratamiento'); 
                            }
                            else{ $otroTratamiento = $alumnoEntrevista->otroTratamiento; }
                            @endphp
                            {!! Form::text('otroTratamiento',  $otroTratamiento, array('id' => 'otroTratamiento', 'class' => 'validate', 'maxlength'=>'50')) !!}
                            {!! Form::label('otroTratamiento', 'Otro tratamiento', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            @php                                  
                            if(old('tomaMedicamento') !== null){
                                $tomaMedicamento = old('tomaMedicamento'); 
                            }
                            else{ $tomaMedicamento = $alumnoEntrevista->tomaMedicamento; }
                            @endphp
                            {!! Form::text('tomaMedicamento', $tomaMedicamento, array('id' => 'tomaMedicamento', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('tomaMedicamento', '¿Toma algún medicamento?', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            @php                                  
                            if(old('tomaMedicamento') !== null){
                                $tomaMedicamento = old('tomaMedicamento'); 
                            }
                            else{ $tomaMedicamento = $alumnoEntrevista->tomaMedicamento; }
                            @endphp
                            {!! Form::text('tomaMedicamento', $tomaMedicamento, array('id' => 'cuidadoEspecifico', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('cuidadoEspecifico', '¿Requiere algún cuidado específico? ', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p>¿Ha recibido su hijo(a) tratamiento?</p>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('tratimientoNeurologico', 'Neurológico *', ['class' => '']); !!}
                        <select name="tratimientoNeurologico" id="tratimientoNeurologico" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('tratimientoNeurologico') !== null){
                                $tratimientoNeurologico = old('tratimientoNeurologico'); 
                            }
                            else{ $tratimientoNeurologico = $alumnoEntrevista->tratimientoNeurologico; }
                            @endphp
                            <option value="NO" {{  $tratimientoNeurologico == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{  $tratimientoNeurologico == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            @php                                  
                            if(old('obsTratimientoNeurologico') !== null){
                                $obsTratimientoNeurologico = old('obsTratimientoNeurologico'); 
                            }
                            else{ $obsTratimientoNeurologico = $alumnoEntrevista->obsTratimientoNeurologico; }
                            @endphp
                            {!! Form::text('obsTratimientoNeurologico', $obsTratimientoNeurologico, array('id' => 'obsTratimientoNeurologico', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('obsTratimientoNeurologico', 'Observaciones ', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('tratamientoPsicologico', 'Psicológico *', ['class' => '']); !!}
                        <select name="tratamientoPsicologico" id="tratamientoPsicologico" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('tratamientoPsicologico') !== null){
                                $tratamientoPsicologico = old('tratamientoPsicologico'); 
                            }
                            else{ $tratamientoPsicologico = $alumnoEntrevista->tratamientoPsicologico; }
                            @endphp
                            <option value="NO" {{$tratamientoPsicologico == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{$tratamientoPsicologico == "SI" ? 'selected' : '' }}>SI</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            @php                                  
                            if(old('obsTratimientoPsicologico') !== null){
                                $obsTratimientoPsicologico = old('obsTratimientoPsicologico'); 
                            }
                            else{ $obsTratimientoPsicologico = $alumnoEntrevista->obsTratimientoPsicologico; }
                            @endphp
                            {!! Form::text('obsTratimientoPsicologico', $obsTratimientoPsicologico, array('id' => 'obsTratimientoPsicologico', 'class' => 'validate', 'maxlength'=>'255')) !!}
                            {!! Form::label('obsTratimientoPsicologico', 'Observaciones ', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('medicoTratante') !== null){
                                $medicoTratante = old('medicoTratante'); 
                            }
                            else{ $medicoTratante = $alumnoEntrevista->medicoTratante; }
                            @endphp
                            {!! Form::text('medicoTratante', $medicoTratante, array('id' => 'medicoTratante', 'class' => 'validate', 'maxlength'=>'100')) !!}
                            {!! Form::label('medicoTratante', 'Médico tratante', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l4">
                        {!! Form::label('llevarAlNinio', 'En caso de no encontrar al tutor la escuela llevará al alumno(a) *', array('class' => '')); !!}
                        <select name="llevarAlNinio" id="llevarAlNinio" class="browser-default validate select2" style="width: 100%;" required>
                            @php                                  
                            if(old('llevarAlNinio') !== null){
                                $llevarAlNinio = old('llevarAlNinio'); 
                            }
                            else{ $llevarAlNinio = $alumnoEntrevista->llevarAlNinio; }
                            @endphp
                            <option value="NO" {{$llevarAlNinio == "NO" ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{$llevarAlNinio == "SI" ? 'selected' : '' }}>SI</option>
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
                            @php                                  
                            if(old('motivoInscripcionEscuela') !== null){
                                $motivoInscripcionEscuela = old('motivoInscripcionEscuela'); 
                            }
                            else{ $motivoInscripcionEscuela = $alumnoEntrevista->motivoInscripcionEscuela; }
                            @endphp
                            {!! Form::text('motivoInscripcionEscuela', $motivoInscripcionEscuela, array('id' => 'motivoInscripcionEscuela', 'class' => 'validate', 'maxlength'=>'255')) !!}
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
                            @php                                  
                            if(old('conocidoEscuela1') !== null){
                                $conocidoEscuela1 = old('conocidoEscuela1'); 
                            }
                            else{ $conocidoEscuela1 = $alumnoEntrevista->conocidoEscuela1; }
                            @endphp
                            {!! Form::text('conocidoEscuela1', $conocidoEscuela1, array('id' => 'conocidoEscuela1', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('conocidoEscuela1', 'Familiar o conocido 1', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('conocidoEscuela2') !== null){
                                $conocidoEscuela2 = old('conocidoEscuela2'); 
                            }
                            else{ $conocidoEscuela2 = $alumnoEntrevista->conocidoEscuela2; }
                            @endphp
                            {!! Form::text('conocidoEscuela2', $conocidoEscuela2, array('id' => 'conocidoEscuela2', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('conocidoEscuela2', 'Familiar o conocido 2', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('conocidoEscuela3') !== null){
                                $conocidoEscuela3 = old('conocidoEscuela3'); 
                            }
                            else{ $conocidoEscuela3 = $alumnoEntrevista->conocidoEscuela3; }
                            @endphp
                            {!! Form::text('conocidoEscuela3', $conocidoEscuela3, array('id' => 'conocidoEscuela3', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('conocidoEscuela3', 'Familiar o conocido 3', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p>Nombre y teléfono de familiares o conocidos a quien se le pueda pedir referencia</p>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('referencia1') !== null){
                                $referencia1 = old('referencia1'); 
                            }
                            else{ $referencia1 = $alumnoEntrevista->referencia1; }
                            @endphp
                            {!! Form::text('referencia1', $referencia1, array('id' => 'referencia1', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('referencia1', 'Nombre completo referencia 1', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('celularReferencia1') !== null){
                                $celularReferencia1 = old('celularReferencia1'); 
                            }
                            else{ $celularReferencia1 = $alumnoEntrevista->celularReferencia1; }
                            @endphp
                            {!! Form::number('celularReferencia1', $celularReferencia1, array('id' => 'celularReferencia1', 'class' => 'validate', 'maxlength'=>'10')) !!}
                            {!! Form::label('celularReferencia1', 'Celular referencia 1', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('referencia2') !== null){
                                $referencia2 = old('referencia2'); 
                            }
                            else{ $referencia2 = $alumnoEntrevista->referencia2; }
                            @endphp
                            {!! Form::text('referencia2', $referencia2, array('id' => 'referencia2', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('referencia2', 'Nombre completo referencia 2', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('celularReferencia2') !== null){
                                $celularReferencia2 = old('celularReferencia2'); 
                            }
                            else{ $celularReferencia2 = $alumnoEntrevista->celularReferencia2; }
                            @endphp
                            {!! Form::number('celularReferencia2', $celularReferencia2, array('id' => 'celularReferencia2', 'class' => 'validate', 'maxlength'=>'10')) !!}
                            {!! Form::label('celularReferencia2', 'Celular referencia 2', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('referencia3') !== null){
                                $referencia3 = old('referencia3'); 
                            }
                            else{ $referencia3 = $alumnoEntrevista->referencia3; }
                            @endphp
                            {!! Form::text('referencia3', $referencia3, array('id' => 'referencia3', 'class' => 'validate', 'maxlength'=>'200')) !!}
                            {!! Form::label('referencia3', 'Nombre completo referencia 3', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            @php                                  
                            if(old('celularReferencia3') !== null){
                                $celularReferencia3 = old('celularReferencia3'); 
                            }
                            else{ $celularReferencia3 = $alumnoEntrevista->celularReferencia3; }
                            @endphp
                            {!! Form::number('celularReferencia3',  $celularReferencia3, array('id' => 'celularReferencia3', 'class' => 'validate', 'maxlength'=>'10')) !!}
                            {!! Form::label('celularReferencia3', 'Celular referencia 3', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            @php                                  
                            if(old('obsGenerales') !== null){
                                $obsGenerales = old('obsGenerales'); 
                            }
                            else{ $obsGenerales = $alumnoEntrevista->obsGenerales; }
                            @endphp
                            {!! Form::text('obsGenerales', $obsGenerales, array('id' => 'obsGenerales', 'class' => 'validate', 'maxlength'=>'600')) !!}
                            {!! Form::label('obsGenerales', 'OBSERVACIONES GENERALES', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <br>
                <br>
                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            @php                                  
                            if(old('entrevistador') !== null){
                                $entrevistador = old('entrevistador'); 
                            }
                            else{ $entrevistador = $alumnoEntrevista->entrevistador; }
                            @endphp
                            {!! Form::text('entrevistador', $entrevistador, array('id' => 'entrevistador', 'class' => 'validate', 'maxlength'=>'200', 'readonly')) !!}
                            <input type="hidden" value="{{$empleado}}" name="nombreEntrevistador">
                            {!! Form::label('entrevistador', 'ENTREVISTADOR', array('class' => '')); !!}
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


  {{-- funciones de módulo CRUD --}}
  {!! HTML::script(asset('js/alumnos/crud-alumnos.js'), array('type' => 'text/javascript')) !!}
  {{-- Funciones para Modelo Persona --}}
  {!! HTML::script(asset('js/personas/personas.js'), array('type' => 'text/javascript'))!!}
  
@endsection

@section('footer_scripts')

//@include('primaria.entrevista_inicial.traerDatos')

@include('primaria.scripts.municipios')
@include('primaria.scripts.estados')

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


    //Padre
    var curpPadre = $("#curpPadre").val()
    var esCurpValidaPadre = curpValidaPadre(curpPadre);
    $("#esCurpValidaPadre").val(esCurpValidaPadre);

    $("#curpPadre").on('change', function(e) {
        var curpPadre = e.target.value
        var esCurpValidaPadre = curpValidaPadre(curpPadre);
        $("#esCurpValidaPadre").val(esCurpValidaPadre);
    });

    //Madre
    var curpMadre = $("#curpMadre").val()
    var esCurpValidaMadre = curpValidaMadre(curpMadre);
    $("#esCurpValidaMadre").val(esCurpValidaMadre);

    $("#curpMadre").on('change', function(e) {
        var curpMadre = e.target.value
        var esCurpValidaMadre = curpValidaMadre(curpMadre);
        $("#esCurpValidaMadre").val(esCurpValidaMadre);
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

        if($("#alergias").val() == "SI"){
            $("#tipoAlergias").prop('disabled', false);
            $("#tipoAlergias").prop('required', true);
        }else{
            $("#tipoAlergias").prop('disabled', true);
            $("#tipoAlergias").prop('required', false);
        }
    
        $("select[name=hemofilia]").change(function(){
            if($('select[name=hemofilia]').val() == "SI"){
                $("#obsHemofilia").prop('disabled', false);
                $("#obsHemofilia").prop('required', true);            
            }else{
                $("#obsHemofilia").prop('disabled', true);
                $("#obsHemofilia").prop('required', false);
            }
        });
        if($("#hemofilia").val() == "SI"){
            $("#obsHemofilia").prop('disabled', false);
            $("#obsHemofilia").prop('required', true); 
        }else{
            $("#obsHemofilia").prop('disabled', true);
            $("#obsHemofilia").prop('required', false);
        }
    
        $("select[name=epilepsia]").change(function(){
            if($('select[name=epilepsia]').val() == "SI"){
                $("#obsEpilepsia").prop('disabled', false);
                $("#obsEpilepsia").prop('required', true);            
            }else{
                $("#obsEpilepsia").prop('disabled', true);
                $("#obsEpilepsia").prop('required', false);
            }
        });
        if($("#epilepsia").val() == "SI"){
            $("#obsEpilepsia").prop('disabled', false);
            $("#obsEpilepsia").prop('required', true);
        }else{
            $("#obsEpilepsia").prop('disabled', true);
            $("#obsEpilepsia").prop('required', false);
        }
    
        $("select[name=kawasaqui]").change(function(){
            if($('select[name=kawasaqui]').val() == "SI"){
                $("#obsKawasaqui").prop('disabled', false);
                $("#obsKawasaqui").prop('required', true);            
            }else{
                $("#obsKawasaqui").prop('disabled', true);
                $("#obsKawasaqui").prop('required', false);
            }
        });
        if($("#kawasaqui").val() == "SI"){
            $("#obsKawasaqui").prop('disabled', false);
            $("#obsKawasaqui").prop('required', true);
        }else{
            $("#obsKawasaqui").prop('disabled', true);
            $("#obsKawasaqui").prop('required', false);
        }
    
        $("select[name=asma]").change(function(){
            if($('select[name=asma]').val() == "SI"){
                $("#obsAsma").prop('disabled', false);
                $("#obsAsma").prop('required', true);            
            }else{
                $("#obsAsma").prop('disabled', true);
                $("#obsAsma").prop('required', false);
            }
        });
        if($("#asma").val() == "SI"){
            $("#obsAsma").prop('disabled', false);
            $("#obsAsma").prop('required', true);    
        }else{
            $("#obsAsma").prop('disabled', true);
            $("#obsAsma").prop('required', false);
        }
    
        $("select[name=diabetes]").change(function(){
            if($('select[name=diabetes]').val() == "SI"){
                $("#obsDiabetes").prop('disabled', false);
                $("#obsDiabetes").prop('required', true);            
            }else{
                $("#obsDiabetes").prop('disabled', true);
                $("#obsDiabetes").prop('required', false);
            }
        });
        if($("#diabetes").val() == "SI"){
            $("#obsDiabetes").prop('disabled', false);
            $("#obsDiabetes").prop('required', true); 
        }else{
            $("#obsDiabetes").prop('disabled', true);
            $("#obsDiabetes").prop('required', false);
        }
    
        $("select[name=cardiaco]").change(function(){
            if($('select[name=cardiaco]').val() == "SI"){
                $("#obsCardiaco").prop('disabled', false);
                $("#obsCardiaco").prop('required', true);            
            }else{
                $("#obsCardiaco").prop('disabled', true);
                $("#obsCardiaco").prop('required', false);
            }
        });
        if($("#cardiaco").val() == "SI"){
            $("#obsCardiaco").prop('disabled', false);
            $("#obsCardiaco").prop('required', true);  
        }else{
            $("#obsCardiaco").prop('disabled', true);
            $("#obsCardiaco").prop('required', false);
        }
    
        $("select[name=dermatologico]").change(function(){
            if($('select[name=dermatologico]').val() == "SI"){
                $("#obsDermatologico").prop('disabled', false);
                $("#obsDermatologico").prop('required', true);            
            }else{
                $("#obsDermatologico").prop('disabled', true);
                $("#obsDermatologico").prop('required', false);
            }
        });
        if($("#dermatologico").val() == "SI"){
            $("#obsDermatologico").prop('disabled', false);
            $("#obsDermatologico").prop('required', true);   
        }else{
            $("#obsDermatologico").prop('disabled', true);
            $("#obsDermatologico").prop('required', false);
        }

        /* ---------------------- mostrar el boton de impresion --------------------- */
        $("select[name=llevarAlNinio]").change(function(){
            if($('select[name=llevarAlNinio]').val() == "SI"){
               $("#formato_salida").show();           
            }else{
                $("#formato_salida").hide();
            }
        });

        if($('select[name=llevarAlNinio]').val() == "SI"){
            $("#formato_salida").show();           
         }else{
             $("#formato_salida").hide();
         }
        
    });
    </script>
@endsection
