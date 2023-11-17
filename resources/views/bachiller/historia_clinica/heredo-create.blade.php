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
            <select id="herEpilepsia" class="browser-default" name="herEpilepsia" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('herEpilepsia') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('herEpilepsia') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="herEpilepsiaGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herEpilepsiaGrado', old('herEpilepsiaGrado'), array('id' => 'herEpilepsiaGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Diabetes  --}}
        <div class="col s12 m6 l6">
            <label for="herDiabetes"><strong style="color: #000; font-size: 16px;">Diabetes</strong></label>
            <select id="herDiabetes" class="browser-default" name="herDiabetes" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('herDiabetes') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('herDiabetes') == "NO" ? 'selected' : '' }}>NO</option>  
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="herDiabetesGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herDiabetesGrado', old('herDiabetesGrado'), array('id' => 'herDiabetesGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Hipertensión  --}}
        <div class="col s12 m6 l6">
            <label for="herHipertension"><strong style="color: #000; font-size: 16px;">Hipertensión</strong></label>
            <select id="herHipertension" class="browser-default" name="herHipertension" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('herHipertension') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('herHipertension') == "NO" ? 'selected' : '' }}>NO</option>  
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="herHipertensionGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herHipertensionGrado', old('herHipertensionGrado'), array('id' => 'herHipertensionGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Cáncer  --}}
        <div class="col s12 m6 l6">
            <label for="herCancer"><strong style="color: #000; font-size: 16px;">Cáncer</strong></label>
            <select id="herCancer" class="browser-default" name="herCancer" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('herCancer') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('herCancer') == "NO" ? 'selected' : '' }}>NO</option>  
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="herCancerGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herCancerGrado', old('herCancerGrado'), array('id' => 'herCancerGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Neurológicos  --}}
        <div class="col s12 m6 l6">
            <label for="herNeurologicos"><strong style="color: #000; font-size: 16px;">Neurológicos</strong></label>
            <select id="herNeurologicos" class="browser-default" name="herNeurologicos" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('herNeurologicos') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('herNeurologicos') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="herNeurologicosGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herNeurologicosGrado', old('herNeurologicosGrado'), array('id' => 'herNeurologicosGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Psicológicos  --}}
        <div class="col s12 m6 l6">
            <label for="herPsicologicos"><strong style="color: #000; font-size: 16px;">Psicológicos</strong></label>
            <select id="desLateralidad" class="browser-default" name="herPsicologicos" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('herPsicologicos') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('herPsicologicos') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="herPsicologicosGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herPsicologicosGrado', old('herPsicologicosGrado'), array('id' => 'herPsicologicosGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Problemas de lenguaje  --}}
        <div class="col s12 m6 l6">
            <label for="herLenguaje"><strong style="color: #000; font-size: 16px;">Problemas de lenguaje</strong></label>
            <select id="herLenguaje" class="browser-default" name="herLenguaje" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('herLenguaje') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('herLenguaje') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="herLenguajeGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herLenguajeGrado', old('herLenguajeGrado'), array('id' => 'herLenguajeGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Adicciones  --}}
        <div class="col s12 m6 l6">
            <label for="herAdicciones"><strong style="color: #000; font-size: 16px;">Adicciones</strong></label>
            <select id="herAdicciones" class="browser-default" name="herAdicciones" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('herAdicciones') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('herAdicciones') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="herAdiccionesGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herAdiccionesGrado', old('herAdiccionesGrado'), array('id' => 'herAdiccionesGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  OTRO  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="herOtro"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                {!! Form::text('herOtro', old('herOtro'), array('id' => 'herOtro', 'class' => 'validate','maxlength'=>'40')) !!}
            </div>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="herOtroGrado"><strong style="color: #000; font-size: 16px;">Grado de parentesco con el niño</strong></label>
                {!! Form::text('herOtroGrado', old('herOtroGrado'), array('id' => 'herOtroGrado', 'class' => 'validate','maxlength'=>'255')) !!}
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