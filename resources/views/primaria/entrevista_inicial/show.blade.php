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
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                        {!! Form::text('perNombre', $persona->perNombre,
                            array('id' => 'perNombre', 'class' => 'validate','required','maxlength'=>'40', 'readonly')) !!}
                        {!! Form::label('perNombre', 'Nombre(s) *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                        {!! Form::text('perApellido1', $persona->perApellido1,
                        array('id' => 'perApellido1', 'class' => 'validate','required','maxlength'=>'30', 'readonly')) !!}
                        {!! Form::label('perApellido1', 'Primer apellido *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                        {!! Form::text('perApellido2', $persona->perApellido2,
                        array('id' => 'perApellido2', 'class' => 'validate','maxlength'=>'30', 'readonly'))!!}
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
                                array('id' => 'perCurp', 'class' => 'validate', 'maxlength'=>'18', 'readonly')) !!}
                                {!! Form::hidden('perCurpOld', $alumno->perCurp, ['id' => 'perCurpOld']) !!}
                            {!! Form::hidden('esCurpValida', NULL, ['id' => 'esCurpValida']) !!}
                            {!! Form::label('perCurp', 'Curp *', array('class' => '')); !!}
                        </div>                        
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="col s12 m6 l6">
                            {!! Form::label('aluNivelIngr', 'Nivel de ingreso *', array('class' => '')); !!}
                            @foreach ($departamentos as $departamento)
                                <input type="text" @if ($departamento->depClave == "PRI") value="PRI-Primaria" @endif>
                            @endforeach
                        </div>
                        <div class="input-field col s12 m6 l6">
                            {!! Form::number('aluGradoIngr', $alumnoEntrevista->gradoInscrito, array('id' => 'aluGradoIngr', 'class' => 'validate','required','min'=>'1','max'=>'6','onKeyPress="if(this.value.length>1) return false;"', 'readonly')) !!}
                            {!! Form::label('aluGradoIngr', 'Grado Ingreso *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- COLUMNA --}}
                        <div class="col s12 m6 l6">
                            {!! Form::label('perSexo', 'Sexo *', array('class' => '')); !!}
                            <input type="text" readonly @if($persona->perSexo == "M") value="HOMBRE"  @else value="MUJER" @endif>
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
                        <input type="text" class="validate" value="{{$pais->paisNombre}}" readonly>                        
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('estado_id', 'Estado *', array('class' => '')); !!}
                        <input type="text" class="validate" value="{{$estado->edoNombre}}" readonly> 
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('municipio_id', 'Municipio *', array('class' => '')); !!}
                        <input type="text" class="validate" value="{{$municipio->munNombre}}" readonly>
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
                            {!! Form::text('tiempoResidencia', $tiempoResidencia, array('id' => 'tiempoResidencia', 'class' => 'validate', 'maxlength'=>'25', 'readonly')) !!}
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
                            {!! Form::text('nombrePadre', $alumnoEntrevista->nombrePadre, array('readonly' => 'true')) !!}
                            {!! Form::label('nombrePadre', 'Nombre(s)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('apellido1Padre', $alumnoEntrevista->apellido1Padre, array('readonly' => 'true')) !!}
                            {!! Form::label('apellido1Padre', 'Apellido 1 *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('apellido2Padre', $alumnoEntrevista->apellido2Padre, array('readonly' => 'true')) !!}
                            {!! Form::label('apellido2Padre', 'Apellido 2', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('curpPadre', $alumnoEntrevista->curpPadre, array('readonly' => 'true')) !!}
                            {!! Form::label('curpPadre', 'Curp', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('direccionPadre', $alumnoEntrevista->direccionPadre, array('readonly' => 'true')) !!}
                            {!! Form::label('direccionPadre', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('edadPadre', $alumnoEntrevista->edadPadre, array('readonly' => 'true')) !!}
                            {!! Form::label('edadPadre', 'Edad', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularPadre', $alumnoEntrevista->celularPadre, array('readonly' => 'true')) !!}
                            {!! Form::label('celularPadre', 'Celular', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ocupacionPadre', $alumnoEntrevista->ocupacionPadre,array('readonly' => 'true')) !!}
                            {!! Form::label('ocupacionPadre', 'Ocupación', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('empresaPadre', $alumnoEntrevista->empresaPadre, array('readonly' => 'true')) !!}
                            {!! Form::label('empresaPadre', 'Empresa', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::email('correoPadre', $alumnoEntrevista->correoPadre, array('readonly' => 'true')) !!}
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
                            {!! Form::text('nombreMadre', $alumnoEntrevista->nombreMadre, array('readonly' => 'true')) !!}
                            {!! Form::label('nombreMadre', 'Nombre(s)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('apellido1Madre', $alumnoEntrevista->apellido1Madre, array('readonly' => 'true')) !!}
                            {!! Form::label('apellido1Madre', 'Apellido 1 *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('apellido2Madre', $alumnoEntrevista->apellido2Madre, array('readonly' => 'true')) !!}
                            {!! Form::label('apellido2Madre', 'Apellido 2', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('curpMadre', $alumnoEntrevista->curpMadre, array('readonly' => 'true')) !!}
                            {!! Form::label('curpMadre', 'Curp', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('direccionMadre', $alumnoEntrevista->direccionMadre, array('readonly' => 'true')) !!}
                            {!! Form::label('direccionMadre', 'Dirección', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('edadMadre', $alumnoEntrevista->edadMadre, array('readonly' => 'true')) !!}
                            {!! Form::label('edadMadre', 'Edad', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularMadre', $alumnoEntrevista->celularMadre, array('readonly' => 'true')) !!}
                            {!! Form::label('celularMadre', 'Celular', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('ocupacionMadre', $alumnoEntrevista->ocupacionMadre, array('readonly' => 'true')) !!}
                            {!! Form::label('ocupacionMadre', 'Ocupación', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('empresaMadre', $alumnoEntrevista->empresaMadre, array('readonly' => 'true')) !!}
                            {!! Form::label('empresaMadre', 'Empresa', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::email('correoMadre', $alumnoEntrevista->correoMadre, array('readonly' => 'true')) !!}
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
                        {!! Form::text('estadoCivilPadres', $alumnoEntrevista->estadoCivilPadres, array('readonly' => 'true')) !!}
                    </div>
                   
                    {{-- ¿Tienen alguna religión? ¿Cuál? * --}}
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('religion', $alumnoEntrevista->religion, array('readonly' => 'true')) !!}
                            {!! Form::label('religion', 'Religión', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="input-field">
                            <textarea id="observaciones" name="observaciones" class="materialize-textarea" readonly="true">{{$alumnoEntrevista->observaciones}}</textarea>
                            {!! Form::label('observaciones', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>

                
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="input-field">
                            <textarea id="condicionFamiliar" name="condicionFamiliar" class="materialize-textarea" readonly="true">{{$alumnoEntrevista->condicionFamiliar}}</textarea>
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
                            {!! Form::text('tutorResponsable', $alumnoEntrevista->tutorResponsable, array('readonly' => 'true')) !!}
                            {!! Form::label('tutorResponsable', 'Padre o tutor responsable financiero *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularTutor', $alumnoEntrevista->celularTutor, array('readonly' => 'true')) !!}
                            {!! Form::label('celularTutor', 'Celular *', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('accidenteLlamar', $alumnoEntrevista->accidenteLlamar, array('readonly' => 'true')) !!}
                            {!! Form::label('accidenteLlamar', 'En caso de algún accidente se deberá llamar a *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularAccidente', $alumnoEntrevista->celularAccidente, array('readonly' => 'true')) !!}
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
                            {!! Form::text('perAutorizada1', $alumnoEntrevista->perAutorizada1, array('readonly' => 'true')) !!}
                            {!! Form::label('integrante1', 'Persona 1', array('class' => '')); !!}
                        </div>
                    </div>   
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('perAutorizada2', $alumnoEntrevista->perAutorizada2, array('readonly' => 'true')) !!}
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
                            {!! Form::text('integrante1', $alumnoEntrevista->integrante1, array('id' => 'integrante1', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante1', 'Integrante 1', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('relacionIntegrante1', $alumnoEntrevista->relacionIntegrante1, array('id' => 'relacionIntegrante1', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('relacionIntegrante1', 'Relación integrante 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('edadintegrante1', $alumnoEntrevista->edadintegrante1, array('id' => 'edadintegrante1', 'class' => 'validate', 'maxlength'=>'3')) !!}
                            {!! Form::label('edadintegrante1', 'Edad integrante 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('ocupacionIntegrante1', $alumnoEntrevista->ocupacionIntegrante1, array('id' => 'ocupacionIntegrante1', 'class' => 'validate', 'maxlength'=>'40')) !!}
                            {!! Form::label('ocupacionIntegrante1', 'Ocupación integrante 1', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('integrante2', $alumnoEntrevista->integrante2, array('readonly' => 'true')) !!}
                            {!! Form::label('integrante2', 'Integrante 2', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('relacionIntegrante2', $alumnoEntrevista->relacionIntegrante2, array('readonly' => 'true')) !!}
                            {!! Form::label('relacionIntegrante2', 'Relación integrante 2', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('edadintegrante2', $alumnoEntrevista->edadintegrante2, array('readonly' => 'true')) !!}
                            {!! Form::label('edadintegrante2', 'Edad integrante 2', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('ocupacionIntegrante2', $alumnoEntrevista->ocupacionIntegrante2, array('readonly' => 'true')) !!}
                            {!! Form::label('ocupacionIntegrante2', 'Ocupación integrante 2', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                {{--  integrante 3   --}}
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('integrante3', $alumnoEntrevista->integrante3, array('readonly' => 'true')) !!}
                            {!! Form::label('integrante3', 'Integrante 3', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('relacionIntegrante3', $alumnoEntrevista->relacionIntegrante3, array('readonly' => 'true')) !!}
                            {!! Form::label('relacionIntegrante3', 'Relación integrante 3', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('edadintegrante3', $alumnoEntrevista->edadintegrante3, array('readonly' => 'true')) !!}
                            {!! Form::label('edadintegrante3', 'Edad integrante 3', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('ocupacionIntegrante3', $alumnoEntrevista->ocupacionIntegrante3, array('readonly' => 'true')) !!}
                            {!! Form::label('ocupacionIntegrante3', 'Ocupación integrante 3', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                {{--  integrante 4   --}}
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('integrante4', $alumnoEntrevista->integrante4, array('readonly' => 'true')) !!}
                            {!! Form::label('integrante4', 'Integrante 4', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('relacionIntegrante4', $alumnoEntrevista->relacionIntegrante4, array('readonly' => 'true')) !!}
                            {!! Form::label('relacionIntegrante4', 'Relación integrante 4', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('edadintegrante4', $alumnoEntrevista->edadintegrante4, array('readonly' => 'true')) !!}
                            {!! Form::label('edadintegrante4', 'Edad integrante 4', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('ocupacionIntegrante4', $alumnoEntrevista->ocupacionIntegrante4, array('readonly' => 'true')) !!}
                            {!! Form::label('ocupacionIntegrante4', 'Ocupación integrante 4', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                {{--  integrante 5   --}}
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('integrante5', $alumnoEntrevista->integrante5, array('readonly' => 'true')) !!}
                            {!! Form::label('integrante5', 'Integrante 5', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('relacionIntegrante5', $alumnoEntrevista->relacionIntegrante5, array('readonly' => 'true')) !!}
                            {!! Form::label('relacionIntegrante5', 'Relación integrante 5', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('edadintegrante5', $alumnoEntrevista->edadintegrante5, array('readonly' => 'true')) !!}
                            {!! Form::label('edadintegrante5', 'Edad integrante 5', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('ocupacionIntegrante5', $alumnoEntrevista->ocupacionIntegrante5, array('readonly' => 'true')) !!}
                            {!! Form::label('ocupacionIntegrante5', 'Ocupación integrante 5', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                {{--  integrante 6   --}}
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('integrante6', $alumnoEntrevista->integrante6, array('readonly' => 'true')) !!}
                            {!! Form::label('integrante6', 'Integrante 6', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('relacionIntegrante6', $alumnoEntrevista->relacionIntegrante6, array('readonly' => 'true')) !!}
                            {!! Form::label('relacionIntegrante6', 'Relación integrante 6', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('edadintegrante6', $alumnoEntrevista->edadintegrante6,  array('readonly' => 'true')) !!}
                            {!! Form::label('edadintegrante6', 'Edad integrante 6', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('ocupacionIntegrante6', $alumnoEntrevista->ocupacionIntegrante6,  array('readonly' => 'true')) !!}
                            {!! Form::label('ocupacionIntegrante6', 'Ocupación integrante 6', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                 {{--  integrante 7   --}}
                 <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('integrante7', $alumnoEntrevista->integrante7, array('id' => 'integrante7', 'class' => 'validate','maxlength'=>'255')) !!}
                            {!! Form::label('integrante7', 'Integrante 7', array('class' => '')); !!}
                        </div>
                    </div>        
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('relacionIntegrante7', $alumnoEntrevista->relacionIntegrante7, array('readonly' => 'true')) !!}
                            {!! Form::label('relacionIntegrante7', 'Relación integrante 7', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::number('edadintegrante7', $alumnoEntrevista->edadintegrante7,  array('readonly' => 'true')) !!}
                            {!! Form::label('edadintegrante7', 'Edad integrante 7', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('ocupacionIntegrante7', $alumnoEntrevista->ocupacionIntegrante7,  array('readonly' => 'true')) !!}
                            {!! Form::label('ocupacionIntegrante7', 'Ocupación integrante 7', array('class' => '')); !!}
                        </div>
                    </div>            
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('conQuienViveAlumno', $alumnoEntrevista->conQuienViveAlumno,  array('readonly' => 'true')) !!}
                            {!! Form::label('conQuienViveAlumno', '¿Con quien vivi el alumno(a)? *', array('class' => '')); !!}
                        </div>
                    </div>  
                    <div class="col s12 m6 l3">
                        <div class="input-field">
                            {!! Form::text('direccionViviendaAlumno', $alumnoEntrevista->direccionViviendaAlumno,  array('readonly' => 'true')) !!}
                            {!! Form::label('direccionViviendaAlumno', 'Dirección donde vivie el alumno *', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 m12">
                        <div class="input-field">
                            <label for="situcionLegal">Situación legal: <b>*Entregar copia simple que avale el proceso en todos los casos de Guarda y
                                Custodia que ya haya tenido una sentencia definitiva o se encuentren en un proceso legal.</b></label>
                            <textarea id="situcionLegal" name="situcionLegal" class="materialize-textarea validate" readonly="true">{{$alumnoEntrevista->situcionLegal}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 m6">
                        <div class="input-field">
                            <label for="descripcionNinio">¿Cómo describen los padres al niño/a?</label>
                            <textarea id="descripcionNinio" name="descripcionNinio" class="materialize-textarea validate" readonly="true">{{$alumnoEntrevista->descripcionNinio}}</textarea>
                        </div>
                    </div>

                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('apoyoTarea', $alumnoEntrevista->apoyoTarea, array('readonly' => 'true')) !!}
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
                            {!! Form::text('escuelaAnterior', $alumnoEntrevista->escuelaAnterior, array('readonly' => 'true')) !!}
                            {!! Form::label('escuelaAnterior', 'Nombre de la escuela anterior', array('class' => '')); !!}
                        </div>
                    </div>  

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('aniosEstudiados', $alumnoEntrevista->aniosEstudiados, array('readonly' => 'true')) !!}
                            {!! Form::label('aniosEstudiados', 'Años estudiados en la escuela anterior', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('motivosCambioEscuela', $alumnoEntrevista->motivosCambioEscuela, array('readonly' => 'true')) !!}
                            {!! Form::label('motivosCambioEscuela', 'Motivos del cambio de escuela', array('class' => '')); !!}
                        </div>
                    </div>  
                </div>


                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('kinder', $alumnoEntrevista->kinder, array('readonly' => 'true')) !!}
                            {!! Form::label('kinder', 'Kínder', array('class' => '')); !!}
                        </div>
                    </div>  

                    <div class="col s12 m6 l6">
                        <label for="">Grados estudiados</label>                    
                        

                        <div style="margin-top: 12px;" class='form-check checkbox-warning-filled'>
                            <input class='filled-in' disabled type='checkbox' name='preescolar1' value='NO' {{ old('preescolar1') == 'SI' ? 'checked' : '' }} id='preescolar1'><label style="margin-right: 17px;" for='preescolar1'>1ro</label>
                            <input class='filled-in' disabled type='checkbox' name='preescolar2' value='NO' {{ old('preescolar2') == 'SI' ? 'checked' : '' }} id='preescolar2'><label style="margin-right: 17px;" for='preescolar2'>2do</label>
                            <input class='filled-in' disabled type='checkbox' name='preescolar3' value='NO' {{ old('preescolar3') == 'SI' ? 'checked' : '' }} id='preescolar3'><label style="margin-right: 17px;" for='preescolar3'>3do</label>
                        </div>

                        <script>
                            if('{{$alumnoEntrevista->preescolar1}}' == 'SI'){
                                $("#preescolar1").prop("checked", true);
                                $("#preescolar1").val("SI");
                            }else{
                                $("#preescolar1").prop("checked", false);
                                $("#preescolar1").val("NO");
                            }

                           
                            if('{{$alumnoEntrevista->preescolar2}}' == 'SI'){
                                $("#preescolar2").prop("checked", true);
                                $("#preescolar2").val("SI");
                            }else{
                                $("#preescolar2").prop("checked", false);
                                $("#preescolar2").val("NO");
                            }
                           

                            if('{{$alumnoEntrevista->preescolar3}}' == 'SI'){
                                $("#preescolar3").prop("checked", true);
                                $("#preescolar3").val("SI");
                            }else{
                                $("#preescolar3").prop("checked", false);
                                $("#preescolar3").val("NO");
                            }

                            
                        </script>

                        
                    </div>  
                    
                </div>
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('observacionEscolar', $alumnoEntrevista->observacionEscolar, array('readonly' => 'true')) !!}
                            {!! Form::label('observacionEscolar', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p>Primaria</p>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio1">Promedio en 1º</label>
                            <input type="number" name="promedio1" id="promedio1" max="10" min="0" step="0.0" value="{{$alumnoEntrevista->promedio1}}" readonly="true">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio2">Promedio en 2º</label>
                            <input type="number" name="promedio2" id="promedio2" max="10" min="0" step="0.0" value="{{$alumnoEntrevista->promedio2}}" readonly="true">
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio3">Promedio en 3º</label>
                            <input type="number" name="promedio3" id="promedio3" max="10" min="0" step="0.0" value="{{$alumnoEntrevista->promedio3}}" readonly="true">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio4">Promedio en 4º</label>
                            <input type="number" name="promedio4" id="promedio4" max="10" min="0" step="0.0" value="{{$alumnoEntrevista->promedio4}}" readonly="true">
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio5">Promedio en 5º</label>
                            <input type="number" name="promedio5" id="promedio5" max="10" min="0" step="0.0" value="{{$alumnoEntrevista->promedio5}}" readonly="true">
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="promedio6">Promedio en 6º</label>
                            <input type="number" name="promedio6" id="promedio6" max="10" min="0" step="0.0" value="{{$alumnoEntrevista->promedio6}}" readonly="true">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('recursamientoGrado', $alumnoEntrevista->recursamientoGrado, array('readonly' => 'true')) !!}
                            {!! Form::label('recursamientoGrado', 'Recursamiento de algún grado', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('deportes', $alumnoEntrevista->deportes, array('readonly' => 'true')) !!}
                            {!! Form::label('deportes', 'Deporte (s) o actividad cultural que practica', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('apoyoPedagogico', '¿Ha recibido su hijo(a) apoyo pedagógico en algún grado escolar? *', ['class' => '']); !!}
                        {!! Form::text('apoyoPedagogico', $alumnoEntrevista->apoyoPedagogico, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('obsPedagogico', $alumnoEntrevista->obsPedagogico, array('readonly' => 'true')) !!}
                            {!! Form::label('obsPedagogico', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('terapiaLenguaje', '¿Ha recibido su hijo(a) terapia de lenguaje en algún grado escolar? *', ['class' => '']); !!}
                        {!! Form::text('terapiaLenguaje', $alumnoEntrevista->terapiaLenguaje, array('readonly' => 'true')) !!}

                    </div>
                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('obsTerapiaLenguaje', $alumnoEntrevista->obsTerapiaLenguaje, array('readonly' => 'true')) !!}
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
                        {!! Form::text('tratamientoMedico', $alumnoEntrevista->tratamientoMedico, array('readonly' => 'true')) !!}

                    </div>
                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('obsTratamientoMedico', $alumnoEntrevista->obsTratamientoMedico, array('readonly' => 'true')) !!}
                            {!! Form::label('obsTratamientoMedico', 'Observaciones', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p>¿Actualmente presenta algún padecimiento?</p>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('hemofilia', 'Hemofilia *', ['class' => '']); !!}
                        {!! Form::text('hemofilia', $alumnoEntrevista->hemofilia, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsHemofilia', $alumnoEntrevista->obsHemofilia, array('readonly' => 'true')) !!}
                            {!! Form::label('obsHemofilia', 'Observaciones hemofilia *', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>
                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('epilepsia', 'Epilepsia *', ['class' => '']); !!}
                        {!! Form::text('epilepsia', $alumnoEntrevista->epilepsia, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsEpilepsia', $alumnoEntrevista->obsEpilepsia, array('readonly' => 'true')) !!}
                            {!! Form::label('obsEpilepsia', 'Observaciones epilepsia *', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('kawasaqui', 'Kawasaqui *', ['class' => '']); !!}
                        {!! Form::text('kawasaqui', $alumnoEntrevista->kawasaqui, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsKawasaqui', $alumnoEntrevista->obsKawasaqui, array('readonly' => 'true')) !!}
                            {!! Form::label('obsKawasaqui', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                      
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('asma', 'Asma *', ['class' => '']); !!}
                        {!! Form::text('asma', $alumnoEntrevista->asma, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsAsma', $alumnoEntrevista->obsAsma, array('readonly' => 'true')) !!}
                            {!! Form::label('obsAsma', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('diabetes', 'Diabetes *', ['class' => '']); !!}
                        {!! Form::text('diabetes', $alumnoEntrevista->diabetes, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsDiabetes', $alumnoEntrevista->obsDiabetes, array('readonly' => 'true')) !!}
                            {!! Form::label('obsDiabetes', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('alergias', 'Cardiaco *', ['class' => '']); !!}
                        {!! Form::text('cardiaco', $alumnoEntrevista->cardiaco, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsCardiaco', $alumnoEntrevista->obsCardiaco, array('readonly' => 'true')) !!}
                            {!! Form::label('obsCardiaco', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                      
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('dermatologico', 'Dermatológico *', ['class' => '']); !!}
                        {!! Form::text('cardiaco', $alumnoEntrevista->dermatologico, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('obsDermatologico', $alumnoEntrevista->obsDermatologico, array('readonly' => 'true')) !!}
                            {!! Form::label('obsDermatologico', 'Observaciones kawasaqui *', array('class' => '')); !!}
                        </div>
                    </div>                   
                </div>

                <div class="row">
                    <div class="col s12 m6 l3">
                        {!! Form::label('alergias', 'Alergias *', ['class' => '']); !!}
                        {!! Form::text('alergias', $alumnoEntrevista->alergias, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l9">
                        <div class="input-field">
                            {!! Form::text('tipoAlergias', $alumnoEntrevista->tipoAlergias, array('readonly' => 'true')) !!}
                            {!! Form::label('tipoAlergias', 'Observaciones alergias *', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('otroTratamiento',  $alumnoEntrevista->otroTratamiento,array('readonly' => 'true')) !!}
                            {!! Form::label('otroTratamiento', 'Otro tratamiento', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('tomaMedicamento', $alumnoEntrevista->tomaMedicamento, array('readonly' => 'true')) !!}
                            {!! Form::label('tomaMedicamento', '¿Toma algún medicamento?', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            {!! Form::text('tomaMedicamento', $alumnoEntrevista->tomaMedicamento, array('readonly' => 'true')) !!}
                            {!! Form::label('cuidadoEspecifico', '¿Requiere algún cuidado específico? ', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p>¿Ha recibido su hijo(a) tratamiento?</p>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('tratimientoNeurologico', 'Neurológico *', ['class' => '']); !!}
                        {!! Form::text('tratimientoNeurologico', $alumnoEntrevista->tratimientoNeurologico, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('obsTratimientoNeurologico', $alumnoEntrevista->obsTratimientoNeurologico, array('readonly' => 'true')) !!}
                            {!! Form::label('obsTratimientoNeurologico', 'Observaciones ', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('tratamientoPsicologico', 'Psicológico *', ['class' => '']); !!}
                        {!! Form::text('tratamientoPsicologico', $alumnoEntrevista->tratamientoPsicologico, array('readonly' => 'true')) !!}

                    </div>

                    <div class="col s12 m6 l8">
                        <div class="input-field">
                            {!! Form::text('obsTratimientoPsicologico', $alumnoEntrevista->obsTratimientoPsicologico, array('readonly' => 'true')) !!}
                            {!! Form::label('obsTratimientoPsicologico', 'Observaciones ', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('medicoTratante', $alumnoEntrevista->medicoTratante, array('readonly' => 'true')) !!}
                            {!! Form::label('medicoTratante', 'Médico tratante', array('class' => '')); !!}
                        </div>
                    </div> 

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::label('llevarAlNinio', 'En caso de no encontrar al tutor la escuela llevará al alumno(a) *', array('class' => '')); !!}
                            {!! Form::text('llevarAlNinio', $alumnoEntrevista->llevarAlNinio, array('readonly' => 'true')) !!}
                        </div>
                    </div>  
                </div>

                

                <p><b>*Entregar una copia simple del último diagnóstico y/o tratamiento de todo aquel niño que presente algún tipo de enfermedad, padecimiento o condición de salud. </b></p>

                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            {!! Form::text('motivoInscripcionEscuela', $alumnoEntrevista->motivoInscripcionEscuela, array('readonly' => 'true')) !!}
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
                            {!! Form::text('conocidoEscuela1', $alumnoEntrevista->conocidoEscuela1, array('readonly' => 'true')) !!}
                            {!! Form::label('conocidoEscuela1', 'Familiar o conocido 1', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('conocidoEscuela2', $alumnoEntrevista->conocidoEscuela2, array('readonly' => 'true')) !!}
                            {!! Form::label('conocidoEscuela2', 'Familiar o conocido 2', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('conocidoEscuela3', $alumnoEntrevista->conocidoEscuela3, array('readonly' => 'true')) !!}
                            {!! Form::label('conocidoEscuela3', 'Familiar o conocido 3', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <p>Nombre y teléfono de familiares o conocidos a quien se le pueda pedir referencia</p>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('referencia1', $alumnoEntrevista->referencia1, array('readonly' => 'true')) !!}
                            {!! Form::label('referencia1', 'Nombre completo referencia 1', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularReferencia1', $alumnoEntrevista->celularReferencia1, array('readonly' => 'true')) !!}
                            {!! Form::label('celularReferencia1', 'Celular referencia 1', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('referencia2', $alumnoEntrevista->referencia2, array('readonly' => 'true')) !!}
                            {!! Form::label('referencia2', 'Nombre completo referencia 2', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularReferencia2', $alumnoEntrevista->celularReferencia2, array('readonly' => 'true')) !!}
                            {!! Form::label('celularReferencia2', 'Celular referencia 2', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('referencia3', $alumnoEntrevista->referencia3, array('readonly' => 'true')) !!}
                            {!! Form::label('referencia3', 'Nombre completo referencia 3', array('class' => '')); !!}
                        </div>
                    </div> 
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('celularReferencia3',  $alumnoEntrevista->celularReferencia3, array('readonly' => 'true')) !!}
                            {!! Form::label('celularReferencia3', 'Celular referencia 3', array('class' => '')); !!}
                        </div>
                    </div>                     
                </div>

                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            {!! Form::text('obsGenerales', $alumnoEntrevista->obsGenerales, array('readonly' => 'true')) !!}
                            {!! Form::label('obsGenerales', 'OBSERVACIONES GENERALES', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                <br>
                <br>
                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            {!! Form::text('entrevistador', $alumnoEntrevista->entrevistador,array('readonly' => 'true')) !!}
                            {!! Form::label('entrevistador', 'ENTREVISTADOR', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

          </div>
          
        </div>
    </div>
  </div>


  <style>
    input[type="checkbox"][readonly] {
        pointer-events: none !important;
      }  
  </style>

@endsection

@section('footer_scripts')

@include('primaria.entrevista_inicial.traerDatos')

@endsection
