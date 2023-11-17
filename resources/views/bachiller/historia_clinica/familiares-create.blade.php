<div id="familiares">
    <br>
    
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">Datos de la madre</p>
    </div>
    <div class="row">
        {{--  nombres de la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famNombresMadre', old('famNombresMadre'), array('id' => 'famNombresMadre', 'class' => 'validate','required','maxlength'=>'100')) !!}
                <label for="famNombresMadre"><strong style="color: #000; font-size: 16px;">Nombre(s)</strong></label>
            </div>
        </div>

        {{--  Apellido parterno madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famApellido1Madre', old('famApellido1Madre'), array('id' => 'famApellido1Madre', 'class' =>
                'validate','required','maxlength'=>'40')) !!}
                <label for="famApellido1Madre"><strong style="color: #000; font-size: 16px;">Primer Apellido</strong></label>
            </div>
        </div>

        {{--  apellido materno madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famApellido2Madre', old('famApellido2Madre'), array('id' => 'famApellido2Madre', 'class' => 'validate','required','maxlength'=>'40')) !!}
                <label for="famApellido2Madre"><strong style="color: #000; font-size: 16px;">Segundo Apellido</strong></label>
            </div>
        </div>
    </div>

    <div class="row">
        {{--  fecha de nacimiento de la madre   --}}
        <div class="col s12 m6 l4">
            <label for="famFechaNacimientoMadre"><strong style="color: #000; font-size: 16px;">Fecha de nacimiento</strong></label>
            {!! Form::date('famFechaNacimientoMadre', old('famFechaNacimientoMadre'), array('id' => 'famFechaNacimientoMadre', 'class' => 'validate')) !!}
        </div>

       
        <div class="col s12 m6 l4">
            <label for="paisMadre_Id"><strong style="color: #000; font-size: 16px;">País</strong></label>
            <select id="paisMadre_Id" data-paisMadre-id="{{old('paisMadre_Id')}}" class="browser-default validate select2" required name="paisMadre_Id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>              
                @foreach ($paises as $pais)
                    <option value="{{$pais->id}}" {{ old('paisMadre_Id') == $pais->id ? 'selected' : '' }}>{{$pais->paisNombre}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col s12 m6 l4">
            <label for="estadoMadre_id"><strong style="color: #000; font-size: 16px;">Estado</strong></label>
            <select id="estadoMadre_id" data-estadoMadre-id="{{old('estadoMadre_id')}}" class="browser-default validate select2" required name="estadoMadre_id" style="width: 100%;">                
            </select>
        </div>

    </div>


    <div class="row">
 
        <div class="col s12 m6 l4">
            <label for="municipioMadre_id"><strong style="color: #000; font-size: 16px;">Municipio</strong></label>
            <select id="municipioMadre_id" data-municipioMadre-id="{{old('municipioMadre_id')}}" class="browser-default validate select2" required name="municipioMadre_id" style="width: 100%;">
            </select>
        </div>

        {{--  ocupación madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famOcupacionMadre', old('famOcupacionMadre'), array('id' => 'famOcupacionMadre', 'class' =>
                'validate','maxlength'=>'40')) !!}
                <label for="famOcupacionMadre"><strong style="color: #000; font-size: 16px;">Ocupación</strong></label>
            </div>
        </div>
        {{--  empresa donde labora la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famEmpresaMadre', old('famEmpresaMadre'), array('id' => 'famEmpresaMadre', 'class' =>
                'validate','maxlength'=>'150')) !!}
                <label for="famEmpresaMadre"><strong style="color: #000; font-size: 16px;">Empresa donde labora</strong></label>
            </div>
        </div>

    </div>

    <div class="row">
        {{--  Celular de la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('famCelularMadre', old('famCelularMadre'), array('id' => 'famCelularMadre', 'class' =>
                'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"',
                'required')) !!}
                <label for="famCelularMadre"><strong style="color: #000; font-size: 16px;">Celular</strong></label>
            </div>
        </div>

        {{--  telefono madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('famTelefonoMadre', old('famTelefonoMadre'), array('id' => 'famTelefonoMadre', 'class' =>
                'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                <label for="famTelefonoMadre"><strong style="color: #000; font-size: 16px;">Télefono</strong></label>
            </div>
        </div>
        {{--  correo de la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="famEmailMadre"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                {!! Form::email('famEmailMadre', old('famEmailMadre'), array('id' => 'famEmailMadre', 'class' =>
                'validate','required','maxlength'=>'80')) !!}
            </div>
        </div>

    </div>

    <div class="row">
        {{--  relacion con el niño   --}}
        <div class="col s12 m6 l4">
            <label for="famRelacionMadre"><strong style="color: #000; font-size: 16px;">Relación con el niño</strong></label>
            <select id="famRelacionMadre" class="browser-default" name="famRelacionMadre" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="ESTABLE" {{ old('famRelacionMadre') == "ESTABLE" ? 'selected' : '' }}>Estable</option>
                <option value="INESTABLE" {{ old('famRelacionMadre') == "INESTABLE" ? 'selected' : '' }}>Inestable</option>
                <option value="CONFLICTIVA" {{ old('famRelacionMadre') == "CONFLICTIVA" ? 'selected' : '' }}>Conflictiva</option>
            </select>
        </div>

        {{--  frecuencia de la realcion madre  --}}
        <div class="col s12 m6 l4" id="divFrecuencia">
            <label for="famRelacionFrecuenciaMadre"><strong style="color: #000; font-size: 16px;">Frecuencia de la relación con el niño</strong></label>
            <select id="famRelacionFrecuenciaMadre" class="browser-default" name="famRelacionFrecuenciaMadre"
                style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="MUCHA" {{ old('famRelacionFrecuenciaMadre') == "MUCHA" ? 'selected' : '' }}>Mucha</option>
                <option value="POCA" {{ old('famRelacionFrecuenciaMadre') == "POCA" ? 'selected' : '' }}>Poca</option>
                <option value="NINGUNA COMUNICACIÓN" {{ old('famRelacionFrecuenciaMadre') == "NINGUNA COMUNICACIÓN" ? 'selected' : '' }}>Ninguna comunicación</option>
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
                {!! Form::text('famNombresPadre', old('famNombresPadre'), array('id' => 'famNombresPadre', 'class' =>
                'validate','required','maxlength'=>'100')) !!}
                <label for="famNombresPadre"><strong style="color: #000; font-size: 16px;">Nombre(s)</strong></label>
            </div>
        </div>

        {{--  Apellido parterno del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famApellido1Padre', old('famApellido1Padre'), array('id' => 'famApellido1Padre', 'class' =>
                'validate','required','maxlength'=>'40')) !!}
                <label for="famApellido1Padre"><strong style="color: #000; font-size: 16px;">Primer Apellido</strong></label>
            </div>
        </div>

        {{--  apellido materno del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famApellido2Padre', old('famApellido2Padre'), array('id' => 'famApellido2Padre', 'class' =>
                'validate','maxlength'=>'40')) !!}
                <label for="famApellido2Padre"><strong style="color: #000; font-size: 16px;">Segundo Apellido</strong></label>
            </div>
        </div>
    </div>

    <div class="row">
        {{--  fecha de nacimiento del padre   --}}
        <div class="col s12 m6 l4">
            <label for="famFechaNacimientoPadre"><strong style="color: #000; font-size: 16px;">Fecha de nacimiento</strong></label>
            {!! Form::date('famFechaNacimientoPadre', old('famFechaNacimientoPadre'), array('id' => 'famFechaNacimientoPadre', 'class' =>
            'validate')) !!}
        </div>

        <div class="col s12 m6 l4">
            <label for="paisPadre_Id"><strong style="color: #000; font-size: 16px;">País</strong></label>
            <select id="paisPadre_Id" class="browser-default validate select2" required name="paisPadre_Id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              
                @foreach ($paises as $pais)
                    <option value="{{$pais->id}}" {{ old('paisPadre_Id') == $pais->id ? 'selected' : '' }}>{{$pais->paisNombre}}</option>
                @endforeach
            </select>
        </div>

        
        <div class="col s12 m6 l4">
            <label for="estadoPadre_id"><strong style="color: #000; font-size: 16px;">Estado</strong></label>
            <select id="estadoPadre_id" class="browser-default validate select2" required name="estadoPadre_id" style="width: 100%;">
            </select>
        </div>
      
    </div>


    
    <div class="row">
        {{--  municio del padre   --}}
        <div class="col s12 m6 l4">
            <label for="municipioPadre_id"><strong style="color: #000; font-size: 16px;">Municipio</strong></label>
            <select id="municipioPadre_id" class="browser-default validate select2" required name="municipioPadre_id" style="width: 100%;" >
            </select>
        </div>

        {{--  ocupación del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famOcupacionPadre', old('famOcupacionPadre'), array('id' => 'famOcupacionPadre', 'class' => 'validate','maxlength'=>'40')) !!}
                <label for="famOcupacionPadre"><strong style="color: #000; font-size: 16px;">Ocupación</strong></label>
            </div>
        </div>
        {{--  empresa donde labora el padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famEmpresaPadre', old('famEmpresaPadre'), array('id' => 'famEmpresaPadre', 'class' => 'validate','maxlength'=>'150')) !!}
                <label for="famEmpresaPadre"><strong style="color: #000; font-size: 16px;">Empresa donde labora</strong></label>
            </div>
        </div>        
    </div>

    <div class="row">
        {{--  Celular del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('famCelularPadre', old('famCelularPadre'), array('id' => 'famCelularPadre', 'class' =>
                'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"',
                'required')) !!}
                <label for="famCelularPadre"><strong style="color: #000; font-size: 16px;">Celular</strong></label>
            </div>
        </div>

        {{--  telefono del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('famTelefonoPadre', old('famTelefonoPadre'), array('id' => 'famTelefonoPadre', 'class' =>
                'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                <label for="famTelefonoPadre"><strong style="color: #000; font-size: 16px;">Télefono</strong></label>
            </div>
        </div>
        {{--  correo del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="famEmailPadre"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                {!! Form::email('famEmailPadre', old('famEmailPadre'), array('id' => 'famEmailPadre', 'class' =>
                'validate','required','maxlength'=>'80')) !!}
            </div>
        </div>        
    </div>
    <div class="row">
        {{--  relacion con el niño   --}}
        <div class="col s12 m6 l4">
            <label for="famRelacionPadre"><strong style="color: #000; font-size: 16px;">Relación con el niño</strong></label>
            <select id="famRelacionPadre" class="browser-default" name="famRelacionPadre" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="ESTABLE" {{ old('famRelacionPadre') == "ESTABLE" ? 'selected' : '' }}>Estable</option>
                <option value="INESTABLE" {{ old('famRelacionPadre') == "INESTABLE" ? 'selected' : '' }}>Inestable</option>
                <option value="CONFLICTIVA" {{ old('famRelacionPadre') == "CONFLICTIVA" ? 'selected' : '' }}>Conflictiva</option>
            </select>
        </div>

        {{--  frecuencia de la realcion   --}}
        <div class="col s12 m6 l4" id="divFrecuenciaPadre">
            <label for="famRelacionFrecuenciaPadre"><strong style="color: #000; font-size: 16px;">Frecuencia de la relación con el niño</strong></label>
            <select id="famRelacionFrecuenciaPadre" class="browser-default" name="famRelacionFrecuenciaPadre"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="MUCHA" {{ old('famRelacionFrecuenciaPadre') == "MUCHA" ? 'selected' : '' }}>Mucha</option>
                <option value="POCA" {{ old('famRelacionFrecuenciaPadre') == "POCA" ? 'selected' : '' }}>Poca</option>
                <option value="NINGUNA COMUNICACIÓN" {{ old('famRelacionFrecuenciaPadre') == "NINGUNA COMUNICACIÓN" ? 'selected' : '' }}>Ninguna comunicación</option>
            </select>
        </div>
    </div>

    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">Datos generales</p>
    </div>
    <br>

    <div class="row">
        {{--  Estado civil de los padres  --}}
        <div class="col s12 m6 l4">
            <label for="famEstadoCivilPadres"><strong style="color: #000; font-size: 16px;">Estado civil de los padres</strong></label>
            <select id="famEstadoCivilPadres" class="browser-default" name="famEstadoCivilPadres" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="CASADOS" {{ old('famEstadoCivilPadres') == "CASADOS" ? 'selected' : '' }}>Casados</option>
                <option value="UNIÓN LIBRE" {{ old('famEstadoCivilPadres') == "UNIÓN LIBRE" ? 'selected' : '' }}>Unión libre</option>
                <option value="DIVORCIADOS" {{ old('famEstadoCivilPadres') == "DIVORCIADOS" ? 'selected' : '' }}>Divorciados</option>
                <option value="VIUDO/A" {{ old('famEstadoCivilPadres') == "VIUDO/A" ? 'selected' : '' }}>Viudo/a</option>
            </select>
        </div>

        {{--  donde vive el niño   --}}
        <div class="col s12 m6 l4" id="divSeparado" style="display: none">
            <div class="input-field">
                {!! Form::text('famSeparado', old('famSeparado'), array('id' => 'famSeparado', 'class' => 'validate','maxlength'=>'30')) !!}
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
                {!! Form::text('famReligion', old('famReligion'), array('id' => 'famReligion', 'class' =>
                'validate','maxlength'=>'30')) !!}
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
                {!! Form::text('famExtraNombre', old('famExtraNombre'), array('id' => 'famExtraNombre', 'class' =>
                'validate','maxlength'=>'200')) !!}
                <label for="famExtraNombre"><strong style="color: #000; font-size: 16px;">Nombre de algun familiar o conocido</strong></label>
            </div>
        </div>

        {{--  telefono del familiar o conocido   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('famTelefonoExtra', old('famTelefonoExtra'), array('id' => 'famTelefonoExtra', 'class' =>
                'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                <label for="famTelefonoExtra"><strong style="color: #000; font-size: 16px;">Télefono del familiar o conocido</strong></label>
            </div>
        </div>
    </div>

    <p>Nombre completo de personas autorizadas para recoger al alumno en la escuela o recibir información:</p>
    <div class="row">
        {{--  persona autorizada 1   --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::text('famAutorizado1', old('famAutorizado1'), array('id' => 'famAutorizado1', 'class' =>
                'validate','maxlength'=>'200')) !!}
                <label for="famAutorizado1"><strong style="color: #000; font-size: 16px;">Persona autorizada 1</strong></label>
            </div>
        </div>
        {{--  persona autorizada 2   --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::text('famAutorizado2', old('famAutorizado2'), array('id' => 'famAutorizado2', 'class' =>
                'validate','maxlength'=>'200')) !!}
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
                {!! Form::text('famIntegrante1', old('famIntegrante1'), array('id' => 'famIntegrante1', 'class' =>
                'validate','maxlength'=>'200')) !!}
                <label for="famIntegrante1"><strong style="color: #000; font-size: 16px;">Integrante 1</strong></label>
            </div>
        </div>

        {{--  parentesco del integrante 1   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famParentesco1', old('famParentesco1'), array('id' => 'famParentesco1', 'class' =>
                'validate','maxlength'=>'20')) !!}
                <label for="famParentesco1"><strong style="color: #000; font-size: 16px;">Parentesco</strong></label>
            </div>
        </div>

        {{--  edad del integrante 1   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::number('famEdadIntegrante1', old('famEdadIntegrante1'), array('id' => 'famEdadIntegrante1', 'class' =>
                'validate','min'=>'0','max'=>'9999999999',
                'onKeyPress="if(this.value.length==4) return false;"')) !!}
                <label for="famEdadIntegrante1"><strong style="color: #000; font-size: 16px;">Edad</strong></label>
            </div>
        </div>

        {{--  escuela y grado del integrante 1   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famEscuelaGrado1', old('famEscuelaGrado1'), array('id' => 'famEscuelaGrado1', 'class' =>
                'validate','maxlength'=>'80')) !!}
                <label for="famEscuelaGrado1"><strong style="color: #000; font-size: 16px;">Escuela y grado</strong></label>
            </div>
        </div>
    </div>

    {{--  integrante 2   --}}
    <div class="row">
        {{--  nombre del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famIntegrante2', old('famIntegrante2'), array('id' => 'famIntegrante2', 'class' =>
                'validate','maxlength'=>'200')) !!}
                <label for="famIntegrante2"><strong style="color: #000; font-size: 16px;">Integrante 2</strong></label>
            </div>
        </div>

        {{--  parentesco del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famParentesco2', old('famParentesco2'), array('id' => 'famParentesco2', 'class' =>
                'validate','maxlength'=>'20')) !!}
                <label for="famParentesco2"><strong style="color: #000; font-size: 16px;">Parentesco</strong></label>
            </div>
        </div>

        {{--  edad del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::number('famEdadIntegrante2', old('famEdadIntegrante2'), array('id' => 'famEdadIntegrante2', 'class' =>
                'validate','min'=>'0','max'=>'9999999999',
                'onKeyPress="if(this.value.length==4) return false;"')) !!}
                <label for="famEdadIntegrante2"><strong style="color: #000; font-size: 16px;">Edad</strong></label>
            </div>
        </div>

        {{--  escuela y grado del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famEscuelaGrado2', old('famEscuelaGrado2'), array('id' => 'famEscuelaGrado2', 'class' =>
                'validate','maxlength'=>'80')) !!}
                <label for="famEscuelaGrado2"><strong style="color: #000; font-size: 16px;">Escuela y grado</strong></label>
            </div>
        </div>
    </div>

    {{--  integrante 3   --}}
    <div class="row">
        {{--  nombre del integrante 3   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famIntregrante3', old('famIntregrante3'), array('id' => 'famIntregrante3', 'class' =>
                'validate','maxlength'=>'200')) !!}
                <label for="famIntregrante3"><strong style="color: #000; font-size: 16px;">Integrante 3</strong></label>
            </div>
        </div>

        {{--  parentesco del integrante 3   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famParentesco3', old('famParentesco3'), array('id' => 'famParentesco3', 'class' =>
                'validate','maxlength'=>'20')) !!}
                <label for="famParentesco3"><strong style="color: #000; font-size: 16px;">Parentesco</strong></label>
            </div>
        </div>

        {{--  edad del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::number('famEdadIntregrante3', old('famEdadIntregrante3'), array('id' => 'famEdadIntregrante3', 'class' =>
                'validate','min'=>'0','max'=>'9999999999',
                'onKeyPress="if(this.value.length==4) return false;"')) !!}
                <label for="famEdadIntregrante3"><strong style="color: #000; font-size: 16px;">Edad</strong></label>
            </div>
        </div>

        {{--  escuela y grado del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famEscuelaGrado3', old('famEscuelaGrado3'), array('id' => 'famEscuelaGrado3', 'class' =>
                'validate','maxlength'=>'80')) !!}
                <label for="famEscuelaGrado3"><strong style="color: #000; font-size: 16px;">Escuela y grado</strong></label>
            </div>
        </div>
    </div>

    
</div> 
