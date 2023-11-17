<div id="familiares">
    <br>
    
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">Datos de la madre</p>
    </div>
    <div class="row">
        {{--  nombres de la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famNombresMadre', $familia->famNombresMadre, array('id' => 'famNombresMadre', 'class' =>
                'validate','maxlength'=>'100')) !!}
                {!! Form::label('famNombresMadre', 'Nombre(s)', array('class' => '')); !!}
            </div>
        </div>

        {{--  Apellido parterno madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famApellido1Madre', $familia->famApellido1Madre, array('id' => 'famApellido1Madre', 'class' =>
                'validate', 'maxlength'=>'40')) !!}
                {!! Form::label('famApellido1Madre', 'Apellido paterno', array('class' => '')); !!}
            </div>
        </div>

        {{--  apellido materno madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famApellido2Madre', $familia->famApellido2Madre, array('id' => 'famApellido2Madre', 'class' =>
                'validate','maxlength'=>'40')) !!}
                {!! Form::label('famApellido2Madre', 'Apellido materno ', array('class' => '')); !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  fecha de nacimiento de la madre   --}}
        <div class="col s12 m6 l4">
            {!! Form::label('famFechaNacimientoMadre', 'Fecha de nacimiento', array('class' => '')); !!}
            {!! Form::date('famFechaNacimientoMadre', \Carbon\Carbon::parse($familia->famFechaNacimientoMadre)->format('Y-m-d'), array('id' => 'famFechaNacimientoMadre', 'class' =>
            'validate')) !!}
        </div>

        <div class="col s12 m6 l4">
            {!! Form::label('paisMadre_Id', 'País *', array('class' => '')); !!}
            <select id="paisMadre_Id" class="browser-default validate select2" name="paisMadre_Id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
              
                @foreach ($paises as $pais)
                    {{--  <option value="{{$pais->id}}">{{$pais->paisNombre}}</option>  --}}
                    <option value="{{$pais->id}}" @if($pais_madre_id->pais_id == $pais->id) {{ 'selected' }} @endif>{{$pais->paisNombre}}</option>

                @endforeach
            </select>
        </div>
        <div class="col s12 m6 l4">
            {!! Form::label('estadoMadre_id', 'Estado', array('class' => '')); !!}
            <select id="estadoMadre_id" class="browser-default validate select2" name="estadoMadre_id"
                style="width: 100%;">
                @foreach($estados as $estado)
                    <option value="{{$estado->id}}" @if($estado_id_madre->estado_id == $estado->id) {{ 'selected' }} @endif>{{$estado->edoNombre}}</option>
                @endforeach
            </select>
        </div>

    </div>


    <div class="row">
        <div class="col s12 m6 l4">
            {!! Form::label('municipioMadre_id', 'Municipio', ['class' => '']); !!}
            <select id="municipioMadre_id" class="browser-default validate select2" name="municipioMadre_id"
                style="width: 100%;">
                @foreach($municipios as $municipio)
                    <option value="{{$municipio->id}}" @if($municipio->id == $familia->municipioMadre_id) {{ 'selected' }} @endif>{{$municipio->munNombre}}</option>
                @endforeach
            </select>
        </div>

        {{--  ocupación madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famOcupacionMadre', $familia->famOcupacionMadre, array('id' => 'famOcupacionMadre', 'class' =>
                'validate','maxlength'=>'40')) !!}
                {!! Form::label('famOcupacionMadre', 'Ocupación', array('class' => '')); !!}
            </div>
        </div>
        {{--  empresa donde labora la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famEmpresaMadre', $familia->famEmpresaMadre, array('id' => 'famEmpresaMadre', 'class' =>
                'validate','maxlength'=>'150')) !!}
                {!! Form::label('famEmpresaMadre', 'Empresa donde labora', array('class' => '')); !!}
            </div>
        </div>

    </div>

    <div class="row">
        {{--  Celular de la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('famCelularMadre', $familia->famCelularMadre, array('id' => 'famCelularMadre', 'class' =>
                'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"', )) !!}
                {!! Form::label('famCelularMadre', 'Celular', array('class' => '')); !!}
            </div>
        </div>

        {{--  telefono madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('famTelefonoMadre', $familia->famTelefonoMadre, array('id' => 'famTelefonoMadre', 'class' =>
                'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}

                {!! Form::label('famTelefonoMadre', 'Télefono', array('class' => '')); !!}
            </div>
        </div>
        {{--  correo de la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::label('famEmailMadre', 'Correo ', ['class' => '', ]) !!}
                {!! Form::email('famEmailMadre', $familia->famEmailMadre, array('id' => 'famEmailMadre', 'class' =>
                'validate','maxlength'=>'80')) !!}
            </div>
        </div>

    </div>

    <div class="row">
        {{--  relacion con el niño   --}}
        <div class="col s12 m6 l4">
            {!! Form::label('famRelacionMadre', 'Relación con el niño', ['class' => '', ]) !!}
            <select id="famRelacionMadre" class="browser-default" name="famRelacionMadre" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="ESTABLE" {{ $familia->famRelacionMadre == "ESTABLE" ? 'selected="selected"' : '' }}>Estable</option>
                <option value="INESTABLE" {{ $familia->famRelacionMadre == "INESTABLE" ? 'selected="selected"' : '' }}>Inestable</option>
                <option value="CONFLICTIVA" {{ $familia->famRelacionMadre == "CONFLICTIVA" ? 'selected="selected"' : '' }}>Conflictiva</option>
            </select>
        </div>

        {{--  frecuencia de la realcion madre  --}}
        <div class="col s12 m6 l4" id="divFrecuencia">
            {!! Form::label('famRelacionFrecuenciaMadre', 'Frecuencia de la relación con el niño', ['class' => '', ])
            !!}
            <select id="famRelacionFrecuenciaMadre" class="browser-default" name="famRelacionFrecuenciaMadre"
                style="width: 100%;">
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
                {!! Form::text('famNombresPadre', $familia->famNombresPadre, array('id' => 'famNombresPadre', 'class' =>
                'validate','maxlength'=>'100')) !!}
                {!! Form::label('famNombresPadre', 'Nombre(s)', array('class' => '')); !!}
            </div>
        </div>

        {{--  Apellido parterno del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famApellido1Padre', $familia->famApellido1Padre, array('id' => 'famApellido1Padre', 'class' =>
                'validate','maxlength'=>'40')) !!}
                {!! Form::label('famApellido1Padre', 'Apellido paterno', array('class' => '')); !!}
            </div>
        </div>

        {{--  apellido materno del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famApellido2Padre', $familia->famApellido2Padre, array('id' => 'famApellido2Padre', 'class' =>
                'validate','maxlength'=>'40')) !!}
                {!! Form::label('famApellido2Padre', 'Apellido materno', array('class' => '')); !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  fecha de nacimiento del padre   --}}
        <div class="col s12 m6 l4">
            {!! Form::label('famFechaNacimientoPadre', 'Fecha de nacimiento', array('class' => '')); !!}
            {!! Form::date('famFechaNacimientoPadre', \Carbon\Carbon::parse($familia->famFechaNacimientoPadre)->format('Y-m-d'), array('id' => 'famFechaNacimientoPadre', 'class' =>
            'validate')) !!}
        </div>

        <div class="col s12 m6 l4">
            {!! Form::label('paisPadre_Id', 'País', array('class' => '')); !!}
            <select id="paisPadre_Id" class="browser-default validate select2" name="paisPadre_Id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                @foreach ($paises as $pais)
                    <option value="{{$pais->id}}" @if($pais_padre_id->pais_id == $pais->id) {{ 'selected' }} @endif>{{$pais->paisNombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col s12 m6 l4">
            {!! Form::label('estadoPadre_id', 'Estado', array('class' => '')); !!}
            <select id="estadoPadre_id" class="browser-default validate select2" name="estadoPadre_id"
                style="width: 100%;" >
                @foreach($estados as $estado)
                    <option value="{{$estado->id}}" @if($estado_id_padre->estado_id == $estado->id) {{ 'selected' }} @endif>{{$estado->edoNombre}}</option>
                @endforeach
            </select>
        </div>        
    </div>


    <div class="row">
        {{--  municio del padre   --}}
        <div class="col s12 m6 l4">
            {!! Form::label('municipioPadre_id', 'Municipio', ['class' => '']); !!}
            <select id="municipioPadre_id" class="browser-default validate select2" name="municipioPadre_id"
                style="width: 100%;" >
                @foreach($municipios as $municipio)
                    <option value="{{$municipio->id}}" @if($municipio->id == $familia->municipioPadre_id) {{ 'selected' }} @endif>{{$municipio->munNombre}}</option>
                @endforeach
            </select>
        </div>

        {{--  ocupación del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famOcupacionPadre', $familia->famOcupacionPadre, array('id' => 'famOcupacionPadre', 'class' => 'validate','maxlength'=>'40')) !!}
                {!! Form::label('famOcupacionPadre', 'Ocupación', array('class' => '')); !!}
            </div>
        </div>
        {{--  empresa donde labora el padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('famEmpresaPadre', $familia->famEmpresaPadre, array('id' => 'famEmpresaPadre', 'class' =>
                'validate','maxlength'=>'150')) !!}
                {!! Form::label('famEmpresaPadre', 'Empresa donde labora', array('class' => '')); !!}
            </div>
        </div>        
    </div>

    <div class="row">
        {{--  Celular del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('famCelularPadre', $familia->famCelularPadre, array('id' => 'famCelularPadre', 'class' =>
                'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                {!! Form::label('famCelularPadre', 'Celular', array('class' => '')); !!}
            </div>
        </div>

        {{--  telefono del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('famTelefonoPadre', $familia->famTelefonoPadre, array('id' => 'famTelefonoPadre', 'class' =>
                'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}

                {!! Form::label('famTelefonoPadre', 'Télefono', array('class' => '')); !!}
            </div>
        </div>
        {{--  correo del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::label('famEmailPadre', 'Correo', ['class' => '', ]) !!}
                {!! Form::email('famEmailPadre', $familia->famEmailPadre, array('id' => 'famEmailPadre', 'class' =>
                'validate','maxlength'=>'80')) !!}
            </div>
        </div>        
    </div>
    <div class="row">
        {{--  relacion con el niño   --}}
        <div class="col s12 m6 l4">
            {!! Form::label('famRelacionPadre', 'Relación con el niño', ['class' => '', ]) !!}
            <select id="famRelacionPadre" class="browser-default" name="famRelacionPadre" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="ESTABLE" {{ $familia->famRelacionPadre == "ESTABLE" ? 'selected="selected"' : '' }}>Estable</option>
                <option value="INESTABLE" {{ $familia->famRelacionPadre == "INESTABLE" ? 'selected="selected"' : '' }}>Inestable</option>
                <option value="CONFLICTIVA" {{ $familia->famRelacionPadre == "CONFLICTIVA" ? 'selected="selected"' : '' }}>Conflictiva</option>
            </select>
        </div>

        {{--  frecuencia de la realcion   --}}
        <div class="col s12 m6 l4" id="divFrecuenciaPadre">
            {!! Form::label('famRelacionFrecuenciaPadre', 'Frecuencia de la relación con el niño', ['class' => '', ]) !!}
            <select id="famRelacionFrecuenciaPadre" class="browser-default" name="famRelacionFrecuenciaPadre" style="width: 100%;">
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
            {!! Form::label('famEstadoCivilPadres', 'Estado civil de los padres', ['class' => '', ]) !!}
            <select id="famEstadoCivilPadres" class="browser-default" name="famEstadoCivilPadres" style="width: 100%;">
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
                {!! Form::text('famSeparado', $familia->famSeparado, array('id' => 'famSeparado', 'class' =>
                'validate','maxlength'=>'30')) !!}
                {!! Form::label('famSeparado', '¿Con cuál de los padres vive el niño?', array('class' => '')); !!}
            </div>
        </div>
        <script>
            if($('select[name=famEstadoCivilPadres]').val() == "DIVORCIADOS"){
                $("#divSeparado").show(); 
                $("#famSeparado").prop('required', false);
            }else{
                $("#famSeparado").prop('required', false);
                $("#divSeparado").hide();         
            }
        </script>

        {{--  religion   --}}
        <div class="col s12 m6 l4" id="divReligion">
            <div class="input-field">
                {!! Form::text('famReligion', $familia->famReligion, array('id' => 'famReligion', 'class' =>
                'validate','maxlength'=>'30')) !!}
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
                {!! Form::text('famExtraNombre', $familia->famExtraNombre, array('id' => 'famExtraNombre', 'class' =>
                'validate','maxlength'=>'200')) !!}
                {!! Form::label('famExtraNombre', 'Nombre de algun familiar o conocido', array('class' => '')); !!}
            </div>
        </div>

        {{--  telefono del familiar o conocido   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('famTelefonoExtra', $familia->famTelefonoExtra, array('id' => 'famTelefonoExtra', 'class' =>
                'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                {!! Form::label('famTelefonoExtra', 'Télefono del familiar o conocido', array('class' => '')); !!}
            </div>
        </div>
    </div>

    <p>Nombre completo de personas autorizadas para recoger al alumno en la escuela:</p>
    <div class="row">
        {{--  persona autorizada 1   --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::text('famAutorizado1', $familia->famAutorizado1, array('id' => 'famAutorizado1', 'class' =>
                'validate','maxlength'=>'200')) !!}
                {!! Form::label('famAutorizado1', 'Persona autorizada 1', array('class' => '')); !!}
            </div>
        </div>
        {{--  persona autorizada 2   --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::text('famAutorizado2', $familia->famAutorizado2, array('id' => 'famAutorizado2', 'class' =>
                'validate','maxlength'=>'200')) !!}
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
                {!! Form::text('famIntegrante1', $familia->famIntegrante1, array('id' => 'famIntegrante1', 'class' =>
                'validate','maxlength'=>'200')) !!}
                {!! Form::label('famIntegrante1', 'Integrante 1', array('class' => '')); !!}
            </div>
        </div>

        {{--  parentesco del integrante 1   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famParentesco1', $familia->famParentesco1, array('id' => 'famParentesco1', 'class' =>
                'validate','maxlength'=>'20')) !!}
                {!! Form::label('famParentesco1', 'Parentesco', array('class' => '')); !!}
            </div>
        </div>

        {{--  edad del integrante 1   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::number('famEdadIntegrante1', $familia->famEdadIntegrante1, array('id' => 'famEdadIntegrante1', 'class' =>
                'validate','min'=>'0','max'=>'9999999999',
                'onKeyPress="if(this.value.length==4) return false;"')) !!}
                {!! Form::label('famEdadIntegrante1', 'Edad', array('class' => '')); !!}
            </div>
        </div>

        {{--  escuela y grado del integrante 1   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famEscuelaGrado1', $familia->famEscuelaGrado1, array('id' => 'famEscuelaGrado1', 'class' =>
                'validate','maxlength'=>'80')) !!}
                {!! Form::label('famEscuelaGrado1', 'Escuela y grado', array('class' => '')); !!}
            </div>
        </div>
    </div>

    {{--  integrante 2   --}}
    <div class="row">
        {{--  nombre del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famIntegrante2', $familia->famIntegrante2, array('id' => 'famIntegrante2', 'class' =>
                'validate','maxlength'=>'200')) !!}
                {!! Form::label('famIntegrante2', 'Integrante 2', array('class' => '')); !!}
            </div>
        </div>

        {{--  parentesco del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famParentesco2', $familia->famParentesco2, array('id' => 'famParentesco2', 'class' =>
                'validate','maxlength'=>'20')) !!}
                {!! Form::label('famParentesco2', 'Parentesco', array('class' => '')); !!}
            </div>
        </div>

        {{--  edad del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::number('famEdadIntegrante2', $familia->famEdadIntegrante2, array('id' => 'famEdadIntegrante2', 'class' =>
                'validate','min'=>'0','max'=>'9999999999',
                'onKeyPress="if(this.value.length==4) return false;"')) !!}
                {!! Form::label('famEdadIntegrante2', 'Edad', array('class' => '')); !!}
            </div>
        </div>

        {{--  escuela y grado del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famEscuelaGrado2', $familia->famEscuelaGrado2, array('id' => 'famEscuelaGrado2', 'class' =>
                'validate','maxlength'=>'80')) !!}
                {!! Form::label('famEscuelaGrado2', 'Escuela y grado', array('class' => '')); !!}
            </div>
        </div>
    </div>

    {{--  integrante 3   --}}
    <div class="row">
        {{--  nombre del integrante 3   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famIntregrante3', $familia->famIntregrante3, array('id' => 'famIntregrante3', 'class' =>
                'validate','maxlength'=>'200')) !!}
                {!! Form::label('famIntregrante3', 'Integrante 3', array('class' => '')); !!}
            </div>
        </div>

        {{--  parentesco del integrante 3   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famParentesco3', $familia->famParentesco3, array('id' => 'famParentesco3', 'class' =>
                'validate','maxlength'=>'20')) !!}
                {!! Form::label('famParentesco3', 'Parentesco', array('class' => '')); !!}
            </div>
        </div>

        {{--  edad del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::number('famEdadIntregrante3', $familia->famEdadIntregrante3, array('id' => 'famEdadIntregrante3', 'class' =>
                'validate','min'=>'0','max'=>'9999999999',
                'onKeyPress="if(this.value.length==4) return false;"')) !!}
                {!! Form::label('famEdadIntregrante3', 'Edad', array('class' => '')); !!}
            </div>
        </div>

        {{--  escuela y grado del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                {!! Form::text('famEscuelaGrado3', $familia->famEscuelaGrado3, array('id' => 'famEscuelaGrado3', 'class' =>
                'validate','maxlength'=>'80')) !!}
                {!! Form::label('famEscuelaGrado3', 'Escuela y grado', array('class' => '')); !!}
            </div>
        </div>
    </div>

</div> 

