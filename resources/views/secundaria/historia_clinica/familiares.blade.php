<div id="familiares">
    <br>
    
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">Datos de la madre</p>
    </div>
    <div class="row">
        {{--  nombres de la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famNombresMadre') !== null){
                        $famNombresMadre = old('famNombresMadre'); 
                    }
                    else{ $famNombresMadre = $familia->famNombresMadre; }
                @endphp
                {!! Form::text('famNombresMadre', $famNombresMadre, array('id' => 'famNombresMadre', 'class' => 'validate','maxlength'=>'100')) !!}
                <label for="famNombresMadre"><strong style="color: #000; font-size: 16px;">Nombre(s)</strong></label>
            </div>
        </div>

        {{--  Apellido parterno madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famApellido1Madre') !== null){
                        $famApellido1Madre = old('famApellido1Madre'); 
                    }
                    else{ $famApellido1Madre = $familia->famApellido1Madre; }
                @endphp
                {!! Form::text('famApellido1Madre', $famApellido1Madre, array('id' => 'famApellido1Madre', 'class' => 'validate','maxlength'=>'40')) !!}
                <label for="famApellido1Madre"><strong style="color: #000; font-size: 16px;">Primer Apellido</strong></label>
            </div>
        </div>

        {{--  apellido materno madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famApellido2Madre') !== null){
                        $famApellido2Madre = old('famApellido2Madre'); 
                    }
                    else{ $famApellido2Madre = $familia->famApellido2Madre; }
                @endphp
                {!! Form::text('famApellido2Madre', $famApellido2Madre, array('id' => 'famApellido2Madre', 'class' => 'validate','maxlength'=>'40')) !!}
                <label for="famApellido2Madre"><strong style="color: #000; font-size: 16px;">Segundo Apellido</strong></label>
            </div>
        </div>
    </div>

    <div class="row">
        {{--  fecha de nacimiento de la madre   --}}
        <div class="col s12 m6 l4">
            @php                                  
                if(old('famFechaNacimientoMadre') !== null){
                    $famFechaNacimientoMadre = old('famFechaNacimientoMadre'); 
                }
                else{ $famFechaNacimientoMadre = $familia->famFechaNacimientoMadre; }
            @endphp
            <label for="famFechaNacimientoMadre"><strong style="color: #000; font-size: 16px;">Fecha de nacimiento</strong></label>
            {!! Form::date('famFechaNacimientoMadre', $famFechaNacimientoMadre, array('id' => 'famFechaNacimientoMadre', 'class' => 'validate')) !!}
        </div>

       
        <div class="col s12 m6 l4">
            <label for="paisMadre_Id"><strong style="color: #000; font-size: 16px;">País</strong></label>
            <select id="paisMadre_Id" class="browser-default validate select2" name="paisMadre_Id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>    
                @php                                  
                    if(old('paisMadre_Id') !== null){
                        $pais_madre_id = old('paisMadre_Id'); 
                    }
                    else{ $pais_madre_id = $pais_madre_id->pais_id; }
                @endphp          
                @foreach ($paises as $pais)
                    <option value="{{$pais->id}}" @if($pais_madre_id == $pais->id) {{ 'selected' }} @endif>{{$pais->paisNombre}}</option>
                @endforeach
            </select>
        </div>

        
        <div class="col s12 m6 l4">
            <label for="estadoMadre_id"><strong style="color: #000; font-size: 16px;">Estado</strong></label>
            <select id="estadoMadre_id" class="browser-default validate select2" name="estadoMadre_id" style="width: 100%;">     
                @php                                  
                    if(old('estadoMadre_id') !== null){
                        $estado_id_madre = old('estadoMadre_id'); 
                    }
                    else{ $estado_id_madre = $estado_id_madre->estado_id; }
                @endphp         
                @foreach($estados as $estado)
                    <option value="{{$estado->id}}" @if($estado_id_madre == $estado->id) {{ 'selected' }} @endif>{{$estado->edoNombre}}</option>
                @endforeach
            </select>
        </div>

    </div>


    <div class="row">
 
        <div class="col s12 m6 l4">
            <label for="municipioMadre_id"><strong style="color: #000; font-size: 16px;">Municipio</strong></label>
            <select id="municipioMadre_id" class="browser-default validate select2" name="municipioMadre_id" style="width: 100%;">
                @php                                  
                    if(old('municipioMadre_id') !== null){
                        $municipioMadre_id = old('municipioMadre_id'); 
                    }
                    else{ $municipioMadre_id = $familia->municipioMadre_id; }
                @endphp 
                @foreach($municipios as $municipio)
                    <option value="{{$municipio->id}}" @if($municipio->id == $municipioMadre_id) {{ 'selected' }} @endif>{{$municipio->munNombre}}</option>
                @endforeach
            </select>
        </div>

        {{--  ocupación madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famOcupacionMadre') !== null){
                        $famOcupacionMadre = old('famOcupacionMadre'); 
                    }
                    else{ $famOcupacionMadre = $familia->famOcupacionMadre; }
                @endphp 
                {!! Form::text('famOcupacionMadre', $famOcupacionMadre, array('id' => 'famOcupacionMadre', 'class' => 'validate','maxlength'=>'40')) !!}
                <label for="famOcupacionMadre"><strong style="color: #000; font-size: 16px;">Ocupación</strong></label>
            </div>
        </div>
        {{--  empresa donde labora la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famEmpresaMadre') !== null){
                        $famEmpresaMadre = old('famEmpresaMadre'); 
                    }
                    else{ $famEmpresaMadre = $familia->famEmpresaMadre; }
                @endphp 
                {!! Form::text('famEmpresaMadre', $famEmpresaMadre, array('id' => 'famEmpresaMadre', 'class' => 'validate','maxlength'=>'150')) !!}
                <label for="famEmpresaMadre"><strong style="color: #000; font-size: 16px;">Empresa donde labora</strong></label>
            </div>
        </div>

    </div>

    <div class="row">
        {{--  Celular de la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famCelularMadre') !== null){
                        $famCelularMadre = old('famCelularMadre'); 
                    }
                    else{ $famCelularMadre = $familia->famCelularMadre; }
                @endphp 
                {!! Form::number('famCelularMadre', $famCelularMadre, array('id' => 'famCelularMadre', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                <label for="famCelularMadre"><strong style="color: #000; font-size: 16px;">Celular</strong></label>
            </div>
        </div>

        {{--  telefono madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famTelefonoMadre') !== null){
                        $famTelefonoMadre = old('famTelefonoMadre'); 
                    }
                    else{ $famTelefonoMadre = $familia->famTelefonoMadre; }
                @endphp 
                {!! Form::number('famTelefonoMadre', $famTelefonoMadre, array('id' => 'famTelefonoMadre', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                <label for="famTelefonoMadre"><strong style="color: #000; font-size: 16px;">Télefono</strong></label>
            </div>
        </div>
        {{--  correo de la madre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famEmailMadre') !== null){
                        $famEmailMadre = old('famEmailMadre'); 
                    }
                    else{ $famEmailMadre = $familia->famEmailMadre; }
                @endphp
                <label for="famEmailMadre"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                {!! Form::email('famEmailMadre', $famEmailMadre, array('id' => 'famEmailMadre', 'class' => 'validate','maxlength'=>'80')) !!}
            </div>
        </div>

    </div>

    <div class="row">
        {{--  relacion con el niño   --}}
        <div class="col s12 m6 l4">
            <label for="famRelacionMadre"><strong style="color: #000; font-size: 16px;">Relación con el niño</strong></label>
            <select id="famRelacionMadre" class="browser-default" name="famRelacionMadre" style="width: 100%;">
                @php                                  
                    if(old('famRelacionMadre') !== null){
                        $famRelacionMadre = old('famRelacionMadre'); 
                    }
                    else{ $famRelacionMadre = $familia->famRelacionMadre; }
                @endphp
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="ESTABLE" {{ $famRelacionMadre == "ESTABLE" ? 'selected="selected"' : '' }}>Estable</option>
                <option value="INESTABLE" {{ $famRelacionMadre == "INESTABLE" ? 'selected="selected"' : '' }}>Inestable</option>
                <option value="CONFLICTIVA" {{ $famRelacionMadre == "CONFLICTIVA" ? 'selected="selected"' : '' }}>Conflictiva</option>
            </select>
        </div>

        {{--  frecuencia de la realcion madre  --}}
        <div class="col s12 m6 l4" id="divFrecuencia">
            <label for="famRelacionFrecuenciaMadre"><strong style="color: #000; font-size: 16px;">Frecuencia de la relación con el niño</strong></label>
            <select id="famRelacionFrecuenciaMadre" class="browser-default" name="famRelacionFrecuenciaMadre" style="width: 100%;">
                @php                                  
                    if(old('famRelacionFrecuenciaMadre') !== null){
                        $famRelacionFrecuenciaMadre = old('famRelacionFrecuenciaMadre'); 
                    }
                    else{ $famRelacionFrecuenciaMadre = $familia->famRelacionFrecuenciaMadre; }
                @endphp
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="MUCHA" {{ $famRelacionFrecuenciaMadre == "MUCHA" ? 'selected="selected"' : '' }}>Mucha</option>
                <option value="POCA" {{ $famRelacionFrecuenciaMadre == "POCA" ? 'selected="selected"' : '' }}>Poca</option>
                <option value="NINGUNA COMUNICACIÓN" {{ $famRelacionFrecuenciaMadre == "NINGUNA COMUNICACIÓN" ? 'selected="selected"' : '' }}>Ninguna comunicación</option>
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
                @php                                  
                    if(old('famNombresPadre') !== null){
                        $famNombresPadre = old('famNombresPadre'); 
                    }
                    else{ $famNombresPadre = $familia->famNombresPadre; }
                @endphp
                {!! Form::text('famNombresPadre', $famNombresPadre, array('id' => 'famNombresPadre', 'class' => 'validate','maxlength'=>'100')) !!}
                <label for="famNombresPadre"><strong style="color: #000; font-size: 16px;">Nombre(s)</strong></label>
            </div>
        </div>

        {{--  Apellido parterno del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famApellido1Padre') !== null){
                        $famApellido1Padre = old('famApellido1Padre'); 
                    }
                    else{ $famApellido1Padre = $familia->famApellido1Padre; }
                @endphp
                {!! Form::text('famApellido1Padre', $famApellido1Padre, array('id' => 'famApellido1Padre', 'class' => 'validate','maxlength'=>'40')) !!}
                <label for="famApellido1Padre"><strong style="color: #000; font-size: 16px;">Primer Apellido</strong></label>
            </div>
        </div>

        {{--  apellido materno del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famApellido2Padre') !== null){
                        $famApellido2Padre = old('famApellido2Padre'); 
                    }
                    else{ $famApellido2Padre = $familia->famApellido2Padre; }
                @endphp
                {!! Form::text('famApellido2Padre', $famApellido2Padre, array('id' => 'famApellido2Padre', 'class' => 'validate','maxlength'=>'40')) !!}
                <label for="famApellido2Padre"><strong style="color: #000; font-size: 16px;">Segundo Apellido</strong></label>
            </div>
        </div>
    </div>

    <div class="row">
        {{--  fecha de nacimiento del padre   --}}
        <div class="col s12 m6 l4">
            @php                                  
                    if(old('famFechaNacimientoPadre') !== null){
                        $famFechaNacimientoPadre = old('famFechaNacimientoPadre'); 
                    }
                    else{ $famFechaNacimientoPadre = $familia->famFechaNacimientoPadre; }
                @endphp
            <label for="famFechaNacimientoPadre"><strong style="color: #000; font-size: 16px;">Fecha de nacimiento</strong></label>
            {!! Form::date('famFechaNacimientoPadre', $famFechaNacimientoPadre, array('id' => 'famFechaNacimientoPadre', 'class' => 'validate')) !!}
        </div>

        <div class="col s12 m6 l4">
            <label for="paisPadre_Id"><strong style="color: #000; font-size: 16px;">País</strong></label>
            <select id="paisPadre_Id" class="browser-default validate select2" name="paisPadre_Id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>       
                @php                                  
                    if(old('paisPadre_Id') !== null){
                        $pais_padre_id = old('paisPadre_Id'); 
                    }
                    else{ $pais_padre_id = $pais_padre_id->pais_id; }
                @endphp       
                @foreach ($paises as $pais)
                    <option value="{{$pais->id}}" @if($pais_padre_id == $pais->id) {{ 'selected' }} @endif>{{$pais->paisNombre}}</option>
                @endforeach
            </select>
        </div>

        
        <div class="col s12 m6 l4">
            <label for="estadoPadre_id"><strong style="color: #000; font-size: 16px;">Estado</strong></label>
            <select id="estadoPadre_id" class="browser-default validate select2" name="estadoPadre_id" style="width: 100%;">
                @php                                  
                    if(old('estadoPadre_id') !== null){
                        $estado_id_padre = old('estadoPadre_id'); 
                    }
                    else{ $estado_id_padre = $estado_id_padre->estado_id; }
                @endphp  
                @foreach($estados as $estado)
                    <option value="{{$estado->id}}" @if($estado_id_padre == $estado->id) {{ 'selected' }} @endif>{{$estado->edoNombre}}</option>
                @endforeach
            </select>
        </div>
      
    </div>


    
    <div class="row">
        {{--  municio del padre   --}}
        <div class="col s12 m6 l4">
            <label for="municipioPadre_id"><strong style="color: #000; font-size: 16px;">Municipio</strong></label>
            <select id="municipioPadre_id" class="browser-default validate select2" name="municipioPadre_id" style="width: 100%;" >
                @php                                  
                    if(old('municipioPadre_id') !== null){
                        $municipioPadre_id = old('municipioPadre_id'); 
                    }
                    else{ $municipioPadre_id = $familia->municipioPadre_id; }
                @endphp 
                @foreach($municipios as $municipio)
                    <option value="{{$municipio->id}}" @if($municipio->id == $municipioPadre_id) {{ 'selected' }} @endif>{{$municipio->munNombre}}</option>
                @endforeach
            </select>
        </div>

        {{--  ocupación del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famOcupacionPadre') !== null){
                        $famOcupacionPadre = old('famOcupacionPadre'); 
                    }
                    else{ $famOcupacionPadre = $familia->famOcupacionPadre; }
                @endphp 
                {!! Form::text('famOcupacionPadre', $famOcupacionPadre, array('id' => 'famOcupacionPadre', 'class' => 'validate','maxlength'=>'40')) !!}
                <label for="famOcupacionPadre"><strong style="color: #000; font-size: 16px;">Ocupación</strong></label>
            </div>
        </div>
        {{--  empresa donde labora el padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famEmpresaPadre') !== null){
                        $famEmpresaPadre = old('famEmpresaPadre'); 
                    }
                    else{ $famEmpresaPadre = $familia->famEmpresaPadre; }
                @endphp
                {!! Form::text('famEmpresaPadre', $famEmpresaPadre, array('id' => 'famEmpresaPadre', 'class' => 'validate','maxlength'=>'150')) !!}
                <label for="famEmpresaPadre"><strong style="color: #000; font-size: 16px;">Empresa donde labora</strong></label>
            </div>
        </div>        
    </div>

    <div class="row">
        {{--  Celular del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famCelularPadre') !== null){
                        $famCelularPadre = old('famCelularPadre'); 
                    }
                    else{ $famCelularPadre = $familia->famCelularPadre; }
                @endphp
                {!! Form::number('famCelularPadre', $famCelularPadre, array('id' => 'famCelularPadre', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                <label for="famCelularPadre"><strong style="color: #000; font-size: 16px;">Celular</strong></label>
            </div>
        </div>

        {{--  telefono del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famTelefonoPadre') !== null){
                        $famTelefonoPadre = old('famTelefonoPadre'); 
                    }
                    else{ $famTelefonoPadre = $familia->famTelefonoPadre; }
                @endphp
                {!! Form::number('famTelefonoPadre', $famTelefonoPadre, array('id' => 'famTelefonoPadre', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                <label for="famTelefonoPadre"><strong style="color: #000; font-size: 16px;">Télefono</strong></label>
            </div>
        </div>
        {{--  correo del padre   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famEmailPadre') !== null){
                        $famEmailPadre = old('famEmailPadre'); 
                    }
                    else{ $famEmailPadre = $familia->famEmailPadre; }
                @endphp
                <label for="famEmailPadre"><strong style="color: #000; font-size: 16px;">Correo</strong></label>
                {!! Form::email('famEmailPadre', $famEmailPadre, array('id' => 'famEmailPadre', 'class' => 'validate','maxlength'=>'80')) !!}
            </div>
        </div>        
    </div>
    <div class="row">
        {{--  relacion con el niño   --}}
        <div class="col s12 m6 l4">
            <label for="famRelacionPadre"><strong style="color: #000; font-size: 16px;">Relación con el niño</strong></label>
            <select id="famRelacionPadre" class="browser-default" name="famRelacionPadre" style="width: 100%;">
                @php                                  
                    if(old('famRelacionPadre') !== null){
                        $famRelacionPadre = old('famRelacionPadre'); 
                    }
                    else{ $famRelacionPadre = $familia->famRelacionPadre; }
                @endphp
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="ESTABLE" {{ $famRelacionPadre == "ESTABLE" ? 'selected="selected"' : '' }}>Estable</option>
                <option value="INESTABLE" {{ $famRelacionPadre == "INESTABLE" ? 'selected="selected"' : '' }}>Inestable</option>
                <option value="CONFLICTIVA" {{ $famRelacionPadre == "CONFLICTIVA" ? 'selected="selected"' : '' }}>Conflictiva</option>
            </select>
        </div>

        {{--  frecuencia de la realcion   --}}
        <div class="col s12 m6 l4" id="divFrecuenciaPadre">
            <label for="famRelacionFrecuenciaPadre"><strong style="color: #000; font-size: 16px;">Frecuencia de la relación con el niño</strong></label>
            <select id="famRelacionFrecuenciaPadre" class="browser-default" name="famRelacionFrecuenciaPadre" style="width: 100%;">
                @php                                  
                    if(old('famRelacionFrecuenciaPadre') !== null){
                        $famRelacionFrecuenciaPadre = old('famRelacionFrecuenciaPadre'); 
                    }
                    else{ $famRelacionFrecuenciaPadre = $familia->famRelacionFrecuenciaPadre; }
                @endphp
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="MUCHA" {{ $famRelacionFrecuenciaPadre == "MUCHA" ? 'selected="selected"' : '' }}>Mucha</option>
                <option value="POCA" {{ $famRelacionFrecuenciaPadre == "POCA" ? 'selected="selected"' : '' }}>Poca</option>
                <option value="NINGUNA COMUNICACIÓN" {{ $famRelacionFrecuenciaPadre == "NINGUNA COMUNICACIÓN" ? 'selected="selected"' : '' }}>Ninguna comunicación</option>
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
            <select id="famEstadoCivilPadres" class="browser-default" name="famEstadoCivilPadres" style="width: 100%;">
                @php                                  
                    if(old('famEstadoCivilPadres') !== null){
                        $famEstadoCivilPadres = old('famEstadoCivilPadres'); 
                    }
                    else{ $famEstadoCivilPadres = $familia->famEstadoCivilPadres; }
                @endphp
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="CASADOS" {{ $famEstadoCivilPadres == "CASADOS" ? 'selected="selected"' : '' }}>Casados</option>
                <option value="UNIÓN LIBRE" {{ $famEstadoCivilPadres == "UNIÓN LIBRE" ? 'selected="selected"' : '' }}>Unión libre</option>
                <option value="DIVORCIADOS" {{ $famEstadoCivilPadres == "DIVORCIADOS" ? 'selected="selected"' : '' }}>Divorciados</option>
                <option value="VIUDO/A" {{ $famEstadoCivilPadres == "VIUDO/A" ? 'selected="selected"' : '' }}>Viudo/a</option>
            </select>
        </div>

        {{--  donde vive el niño   --}}
        <div class="col s12 m6 l4" id="divSeparado" style="display: none">
            <div class="input-field">
                @php                                  
                    if(old('famSeparado') !== null){
                        $famSeparado = old('famSeparado'); 
                    }
                    else{ $famSeparado = $familia->famSeparado; }
                @endphp
                {!! Form::text('famSeparado', $famSeparado, array('id' => 'famSeparado', 'class' => 'validate','maxlength'=>'30')) !!}
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
                @php                                  
                    if(old('famReligion') !== null){
                        $famReligion = old('famReligion'); 
                    }
                    else{ $famReligion = $familia->famReligion; }
                @endphp
                {!! Form::text('famReligion', $famReligion, array('id' => 'famReligion', 'class' => 'validate','maxlength'=>'30')) !!}
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
                @php                                  
                    if(old('famExtraNombre') !== null){
                        $famExtraNombre = old('famExtraNombre'); 
                    }
                    else{ $famExtraNombre = $familia->famExtraNombre; }
                @endphp
                {!! Form::text('famExtraNombre', $famExtraNombre, array('id' => 'famExtraNombre', 'class' => 'validate','maxlength'=>'200')) !!}
                <label for="famExtraNombre"><strong style="color: #000; font-size: 16px;">Nombre de algun familiar o conocido</strong></label>
            </div>
        </div>

        {{--  telefono del familiar o conocido   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('famTelefonoExtra') !== null){
                        $famTelefonoExtra = old('famTelefonoExtra'); 
                    }
                    else{ $famTelefonoExtra = $familia->famTelefonoExtra; }
                @endphp
                {!! Form::number('famTelefonoExtra', $famTelefonoExtra, array('id' => 'famTelefonoExtra', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                <label for="famTelefonoExtra"><strong style="color: #000; font-size: 16px;">Télefono del familiar o conocido</strong></label>
            </div>
        </div>
    </div>

    <p>Nombre completo de personas autorizadas para recoger al alumno en la escuela:</p>
    <div class="row">
        {{--  persona autorizada 1   --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('famAutorizado1') !== null){
                        $famAutorizado1 = old('famAutorizado1'); 
                    }
                    else{ $famAutorizado1 = $familia->famAutorizado1; }
                @endphp
                {!! Form::text('famAutorizado1', $famAutorizado1, array('id' => 'famAutorizado1', 'class' => 'validate','maxlength'=>'200')) !!}
                <label for="famAutorizado1"><strong style="color: #000; font-size: 16px;">Persona autorizada 1</strong></label>
            </div>
        </div>
        {{--  persona autorizada 2   --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('famAutorizado2') !== null){
                        $famAutorizado2 = old('famAutorizado2'); 
                    }
                    else{ $famAutorizado2 = $familia->famAutorizado2; }
                @endphp
                {!! Form::text('famAutorizado2', $famAutorizado2, array('id' => 'famAutorizado2', 'class' => 'validate','maxlength'=>'200')) !!}
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
                @php                                  
                    if(old('famIntegrante1') !== null){
                        $famIntegrante1 = old('famIntegrante1'); 
                    }
                    else{ $famIntegrante1 = $familia->famIntegrante1; }
                @endphp
                {!! Form::text('famIntegrante1', $famIntegrante1, array('id' => 'famIntegrante1', 'class' => 'validate','maxlength'=>'200')) !!}
                <label for="famIntegrante1"><strong style="color: #000; font-size: 16px;">Integrante 1</strong></label>
            </div>
        </div>

        {{--  parentesco del integrante 1   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famParentesco1') !== null){
                        $famParentesco1 = old('famParentesco1'); 
                    }
                    else{ $famParentesco1 = $familia->famParentesco1; }
                @endphp
                {!! Form::text('famParentesco1', $famParentesco1, array('id' => 'famParentesco1', 'class' => 'validate','maxlength'=>'20')) !!}
                <label for="famParentesco1"><strong style="color: #000; font-size: 16px;">Parentesco</strong></label>
            </div>
        </div>

        {{--  edad del integrante 1   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famEdadIntegrante1') !== null){
                        $famEdadIntegrante1 = old('famEdadIntegrante1'); 
                    }
                    else{ $famEdadIntegrante1 = $familia->famEdadIntegrante1; }
                @endphp
                {!! Form::number('famEdadIntegrante1', $famEdadIntegrante1, array('id' => 'famEdadIntegrante1', 'class' => 'validate','min'=>'0','max'=>'9999999999', 'onKeyPress="if(this.value.length==4) return false;"')) !!}
                <label for="famEdadIntegrante1"><strong style="color: #000; font-size: 16px;">Edad</strong></label>
            </div>
        </div>

        {{--  escuela y grado del integrante 1   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famEscuelaGrado1') !== null){
                        $famEscuelaGrado1 = old('famEscuelaGrado1'); 
                    }
                    else{ $famEscuelaGrado1 = $familia->famEscuelaGrado1; }
                @endphp
                {!! Form::text('famEscuelaGrado1', $famEscuelaGrado1, array('id' => 'famEscuelaGrado1', 'class' => 'validate','maxlength'=>'80')) !!}
                <label for="famEscuelaGrado1"><strong style="color: #000; font-size: 16px;">Escuela y grado</strong></label>
            </div>
        </div>
    </div>

    {{--  integrante 2   --}}
    <div class="row">
        {{--  nombre del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famIntegrante2') !== null){
                        $famIntegrante2 = old('famIntegrante2'); 
                    }
                    else{ $famIntegrante2 = $familia->famIntegrante2; }
                @endphp
                {!! Form::text('famIntegrante2', $famIntegrante2, array('id' => 'famIntegrante2', 'class' => 'validate','maxlength'=>'200')) !!}
                <label for="famIntegrante2"><strong style="color: #000; font-size: 16px;">Integrante 2</strong></label>
            </div>
        </div>

        {{--  parentesco del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famParentesco2') !== null){
                        $famParentesco2 = old('famParentesco2'); 
                    }
                    else{ $famParentesco2 = $familia->famParentesco2; }
                @endphp
                {!! Form::text('famParentesco2', $famParentesco2, array('id' => 'famParentesco2', 'class' => 'validate','maxlength'=>'20')) !!}
                <label for="famParentesco2"><strong style="color: #000; font-size: 16px;">Parentesco</strong></label>
            </div>
        </div>

        {{--  edad del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famEdadIntegrante2') !== null){
                        $famEdadIntegrante2 = old('famEdadIntegrante2'); 
                    }
                    else{ $famEdadIntegrante2 = $familia->famEdadIntegrante2; }
                @endphp
                {!! Form::number('famEdadIntegrante2', $famEdadIntegrante2, array('id' => 'famEdadIntegrante2', 'class' => 'validate','min'=>'0','max'=>'9999999999', 'onKeyPress="if(this.value.length==4) return false;"')) !!}
                <label for="famEdadIntegrante2"><strong style="color: #000; font-size: 16px;">Edad</strong></label>

            </div>
        </div>

        {{--  escuela y grado del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famEscuelaGrado2') !== null){
                        $famEscuelaGrado2 = old('famEscuelaGrado2'); 
                    }
                    else{ $famEscuelaGrado2 = $familia->famEscuelaGrado2; }
                @endphp
                {!! Form::text('famEscuelaGrado2', $famEscuelaGrado2, array('id' => 'famEscuelaGrado2', 'class' => 'validate','maxlength'=>'80')) !!}
                <label for="famEscuelaGrado2"><strong style="color: #000; font-size: 16px;">Escuela y grado</strong></label>
            </div>
        </div>
    </div>

    {{--  integrante 3   --}}
    <div class="row">
        {{--  nombre del integrante 3   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famIntregrante3') !== null){
                        $famIntregrante3 = old('famIntregrante3'); 
                    }
                    else{ $famIntregrante3 = $familia->famIntregrante3; }
                @endphp
                {!! Form::text('famIntregrante3', $famIntregrante3, array('id' => 'famIntregrante3', 'class' => 'validate','maxlength'=>'200')) !!}
                <label for="famIntregrante3"><strong style="color: #000; font-size: 16px;">Integrante 3</strong></label>
            </div>
        </div>

        {{--  parentesco del integrante 3   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famParentesco3') !== null){
                        $famParentesco3 = old('famParentesco3'); 
                    }
                    else{ $famParentesco3 = $familia->famParentesco3; }
                @endphp
                {!! Form::text('famParentesco3', $famParentesco3, array('id' => 'famParentesco3', 'class' => 'validate','maxlength'=>'20')) !!}
                <label for="famParentesco3"><strong style="color: #000; font-size: 16px;">Parentesco</strong></label>
            </div>
        </div>

        {{--  edad del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famEdadIntregrante3') !== null){
                        $famEdadIntregrante3 = old('famEdadIntregrante3'); 
                    }
                    else{ $famEdadIntregrante3 = $familia->famEdadIntregrante3; }
                @endphp
                {!! Form::number('famEdadIntregrante3', $famEdadIntregrante3, array('id' => 'famEdadIntregrante3', 'class' => 'validate','min'=>'0','max'=>'9999999999', 'onKeyPress="if(this.value.length==4) return false;"')) !!}
                <label for="famEdadIntregrante3"><strong style="color: #000; font-size: 16px;">Edad</strong></label>
            </div>
        </div>

        {{--  escuela y grado del integrante 2   --}}
        <div class="col s12 m6 l3">
            <div class="input-field">
                @php                                  
                    if(old('famEscuelaGrado3') !== null){
                        $famEscuelaGrado3 = old('famEscuelaGrado3'); 
                    }
                    else{ $famEscuelaGrado3 = $familia->famEscuelaGrado3; }
                @endphp
                {!! Form::text('famEscuelaGrado3', $famEscuelaGrado3, array('id' => 'famEscuelaGrado3', 'class' => 'validate','maxlength'=>'80')) !!}
                <label for="famEscuelaGrado3"><strong style="color: #000; font-size: 16px;">Escuela y grado</strong></label>
            </div>
        </div>
    </div>

    
</div> 
