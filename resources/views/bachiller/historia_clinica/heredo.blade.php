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
            <select id="herEpilepsia" class="browser-default" name="herEpilepsia" style="width: 100%;">
                @php                                  
                    if(old('herEpilepsia') !== null){
                        $herEpilepsia = old('herEpilepsia'); 
                    }
                    else{ $herEpilepsia = $heredo->herEpilepsia; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $herEpilepsia == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $herEpilepsia == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('herEpilepsiaGrado') !== null){
                        $herEpilepsiaGrado = old('herEpilepsiaGrado'); 
                    }
                    else{ $herEpilepsiaGrado = $heredo->herEpilepsiaGrado; }
                @endphp
                <label for="herEpilepsiaGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herEpilepsiaGrado', $herEpilepsiaGrado, array('id' => 'herEpilepsiaGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Diabetes  --}}
        <div class="col s12 m6 l6">
            <label for="herDiabetes"><strong style="color: #000; font-size: 16px;">Diabetes</strong></label>
            <select id="herDiabetes" class="browser-default" name="herDiabetes" style="width: 100%;">
                @php                                  
                    if(old('herDiabetes') !== null){
                        $herDiabetes = old('herDiabetes'); 
                    }
                    else{ $herDiabetes = $heredo->herDiabetes; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $herDiabetes == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $herDiabetes == "NO" ? 'selected="selected"' : '' }}>NO</option>  
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('herDiabetesGrado') !== null){
                        $herDiabetesGrado = old('herDiabetesGrado'); 
                    }
                    else{ $herDiabetesGrado = $heredo->herDiabetesGrado; }
                @endphp
                <label for="herDiabetesGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herDiabetesGrado', $herDiabetesGrado, array('id' => 'herDiabetesGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Hipertensión  --}}
        <div class="col s12 m6 l6">
            <label for="herHipertension"><strong style="color: #000; font-size: 16px;">Hipertensión</strong></label>
            <select id="herHipertension" class="browser-default" name="herHipertension" style="width: 100%;">
                @php                                  
                    if(old('herHipertension') !== null){
                        $herHipertension = old('herHipertension'); 
                    }
                    else{ $herHipertension = $heredo->herHipertension; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $herHipertension == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $herHipertension == "NO" ? 'selected="selected"' : '' }}>NO</option>  
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('herHipertensionGrado') !== null){
                        $herHipertensionGrado = old('herHipertensionGrado'); 
                    }
                    else{ $herHipertensionGrado = $heredo->herHipertensionGrado; }
                @endphp
                <label for="herHipertensionGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herHipertensionGrado', $herHipertensionGrado, array('id' => 'herHipertensionGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Cáncer  --}}
        <div class="col s12 m6 l6">
            <label for="herCancer"><strong style="color: #000; font-size: 16px;">Cáncer</strong></label>
            <select id="herCancer" class="browser-default" name="herCancer" style="width: 100%;">
                @php                                  
                    if(old('herCancer') !== null){
                        $herCancer = old('herCancer'); 
                    }
                    else{ $herCancer = $heredo->herCancer; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $herCancer == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $herCancer == "NO" ? 'selected="selected"' : '' }}>NO</option>  
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('herCancerGrado') !== null){
                        $herCancerGrado = old('herCancerGrado'); 
                    }
                    else{ $herCancerGrado = $heredo->herCancerGrado; }
                @endphp
                <label for="herCancerGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herCancerGrado', $herCancerGrado, array('id' => 'herCancerGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Neurológicos  --}}
        <div class="col s12 m6 l6">
            <label for="herNeurologicos"><strong style="color: #000; font-size: 16px;">Neurológicos</strong></label>
            <select id="herNeurologicos" class="browser-default" name="herNeurologicos" style="width: 100%;">
                @php                                  
                    if(old('herNeurologicos') !== null){
                        $herNeurologicos = old('herNeurologicos'); 
                    }
                    else{ $herNeurologicos = $heredo->herNeurologicos; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $herNeurologicos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $herNeurologicos == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('herNeurologicosGrado') !== null){
                        $herNeurologicosGrado = old('herNeurologicosGrado'); 
                    }
                    else{ $herNeurologicosGrado = $heredo->herNeurologicosGrado; }
                @endphp
                <label for="herNeurologicosGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herNeurologicosGrado', $herNeurologicosGrado, array('id' => 'herNeurologicosGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Psicológicos  --}}
        <div class="col s12 m6 l6">
            <label for="herPsicologicos"><strong style="color: #000; font-size: 16px;">Psicológicos</strong></label>
            <select id="herPsicologicos" class="browser-default" name="herPsicologicos" style="width: 100%;">
                @php                                  
                    if(old('herPsicologicos') !== null){
                        $herPsicologicos = old('herPsicologicos'); 
                    }
                    else{ $herPsicologicos = $heredo->herPsicologicos; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $herPsicologicos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $herPsicologicos == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('herPsicologicosGrado') !== null){
                        $herPsicologicosGrado = old('herPsicologicosGrado'); 
                    }
                    else{ $herPsicologicosGrado = $heredo->herPsicologicosGrado; }
                @endphp
                <label for="herPsicologicosGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herPsicologicosGrado', $herPsicologicosGrado, array('id' => 'herPsicologicosGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Problemas de lenguaje  --}}
        <div class="col s12 m6 l6">
            <label for="herLenguaje"><strong style="color: #000; font-size: 16px;">Problemas de lenguaje</strong></label>
            <select id="herLenguaje" class="browser-default" name="herLenguaje" style="width: 100%;">
                @php                                  
                    if(old('herLenguaje') !== null){
                        $herLenguaje = old('herLenguaje'); 
                    }
                    else{ $herLenguaje = $heredo->herLenguaje; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $herLenguaje == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $herLenguaje == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('herLenguajeGrado') !== null){
                        $herLenguajeGrado = old('herLenguajeGrado'); 
                    }
                    else{ $herLenguajeGrado = $heredo->herLenguajeGrado; }
                @endphp
                <label for="herLenguajeGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herLenguajeGrado', $herLenguajeGrado, array('id' => 'herLenguajeGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Adicciones  --}}
        <div class="col s12 m6 l6">
            <label for="herAdicciones"><strong style="color: #000; font-size: 16px;">Adicciones</strong></label>
            <select id="herAdicciones" class="browser-default" name="herAdicciones" style="width: 100%;">
                @php                                  
                    if(old('herAdicciones') !== null){
                        $herAdicciones = old('herAdicciones'); 
                    }
                    else{ $herAdicciones = $heredo->herAdicciones; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $herAdicciones == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $herAdicciones == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('herAdiccionesGrado') !== null){
                        $herAdiccionesGrado = old('herAdiccionesGrado'); 
                    }
                    else{ $herAdiccionesGrado = $heredo->herAdiccionesGrado; }
                @endphp
                <label for="herAdiccionesGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herAdiccionesGrado', $herAdiccionesGrado, array('id' => 'herAdiccionesGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  OTRO  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('herOtro') !== null){
                        $herOtro = old('herOtro'); 
                    }
                    else{ $herOtro = $heredo->herOtro; }
                @endphp
                <label for="herOtro"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                {!! Form::text('herOtro', $herOtro, array('id' => 'herOtro', 'class' => 'validate','maxlength'=>'40')) !!}
            </div>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('herOtroGrado') !== null){
                        $herOtroGrado = old('herOtroGrado'); 
                    }
                    else{ $herOtroGrado = $heredo->herOtroGrado; }
                @endphp
                <label for="herOtroGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herOtroGrado', $herOtroGrado, array('id' => 'herOtroGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>
    <br>
</div> 

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