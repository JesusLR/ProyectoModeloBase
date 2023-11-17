<div id="heredo">
    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">ANTECEDENTES HEREDO FAMILIARES</p>
    </div>
    <br>
    <div class="row">
        {{--  Epilepsia  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('herEpilepsia', 'Epilepsia', array('class' => '')); !!}
            <select id="herEpilepsia" class="browser-default" name="herEpilepsia" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $heredo->herEpilepsia == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $heredo->herEpilepsia == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('herEpilepsiaGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                {!! Form::text('herEpilepsiaGrado', $heredo->herEpilepsiaGrado, array('id' => 'herEpilepsiaGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Diabetes  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('herDiabetes', 'Diabetes',
            array('class' =>
            '')); !!}
            <select id="herDiabetes" class="browser-default" name="herDiabetes" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $heredo->herDiabetes == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $heredo->herDiabetes == "NO" ? 'selected="selected"' : '' }}>NO</option>  
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('herDiabetesGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                {!! Form::text('herDiabetesGrado', $heredo->herDiabetesGrado, array('id' => 'herDiabetesGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Hipertensión  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('herHipertension', 'Hipertensión', array('class' => '')); !!}
            <select id="herHipertension" class="browser-default" name="herHipertension" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $heredo->herHipertension == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $heredo->herHipertension == "NO" ? 'selected="selected"' : '' }}>NO</option>  
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('herHipertensionGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                {!! Form::text('herHipertensionGrado', $heredo->herHipertensionGrado, array('id' => 'herHipertensionGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Cáncer  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('herCancer', 'Cáncer', array('class' => '')); !!}
            <select id="herCancer" class="browser-default" name="herCancer" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $heredo->herCancer == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $heredo->herCancer == "NO" ? 'selected="selected"' : '' }}>NO</option>  
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('herCancerGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                {!! Form::text('herCancerGrado', $heredo->herCancerGrado, array('id' => 'herCancerGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Neurológicos  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('herNeurologicos', 'Neurológicos', array('class' => '')); !!}
            <select id="herNeurologicos" class="browser-default" name="herNeurologicos" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $heredo->herNeurologicos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $heredo->herNeurologicos == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('herNeurologicosGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                {!! Form::text('herNeurologicosGrado', $heredo->herNeurologicosGrado, array('id' => 'herNeurologicosGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Psicológicos  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('herPsicologicos', 'Psicológicos', array('class' => '')); !!}
            <select id="herPsicologicos" class="browser-default" name="herPsicologicos" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $heredo->herPsicologicos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $heredo->herPsicologicos == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('herPsicologicosGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                {!! Form::text('herPsicologicosGrado', $heredo->herPsicologicosGrado, array('id' => 'herPsicologicosGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Problemas de lenguaje  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('herLenguaje', 'Problemas de lenguaje', array('class' => '')); !!}
            <select id="herLenguaje" class="browser-default" name="herLenguaje" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $heredo->herLenguaje == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $heredo->herLenguaje == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('herLenguajeGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                {!! Form::text('herLenguajeGrado', $heredo->herLenguajeGrado, array('id' => 'herLenguajeGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Adicciones  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('herAdicciones', 'Adicciones', array('class' =>'')); !!}
            <select id="herAdicciones" class="browser-default" name="herAdicciones" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $heredo->herAdicciones == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $heredo->herAdicciones == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('herAdiccionesGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                {!! Form::text('herAdiccionesGrado', $heredo->herAdiccionesGrado, array('id' => 'herAdiccionesGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  OTRO  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('herOtro', 'Otro', array('class' => '')); !!}
                {!! Form::text('herOtro', $heredo->herOtro, array('id' => 'herOtro', 'class' => 'validate','maxlength'=>'40')) !!}
            </div>
        </div>
        {{--  Grado de parentesco con el niño  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('herOtroGrado', 'Grado de parentesco con el niño', array('class' => '')); !!}
                {!! Form::text('herOtroGrado', $heredo->herOtroGrado, array('id' => 'herOtroGrado', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>
    <br>
</div> 

<script>
    $("select[name=herEpilepsia]").change(function(){
        if($('select[name=herEpilepsia]').val() == "SI"){
            $("#herEpilepsiaGrado").prop('required', false);
           
        }else{
            $("#herEpilepsiaGrado").prop('required', false);
    
        }
    });

    {{--  herDiabetes  --}}
    $("select[name=herDiabetes]").change(function(){
        if($('select[name=herDiabetes]').val() == "SI"){
            $("#herDiabetesGrado").prop('required', false);
  
           
        }else{
            $("#herDiabetesGrado").prop('required', false);
    
        }
    });

    {{--  herHipertension  --}}
    $("select[name=herHipertension]").change(function(){
        if($('select[name=herHipertension]').val() == "SI"){
            $("#herHipertensionGrado").prop('required', false);
  
           
        }else{
            $("#herHipertensionGrado").prop('required', false);
    
        }
    });

    {{--  herCancer  --}}
    $("select[name=herCancer]").change(function(){
        if($('select[name=herCancer]').val() == "SI"){
            $("#herCancerGrado").prop('required', false);
     
           
        }else{
            $("#herCancerGrado").prop('required', false);
    
        }
    });
    {{--  herNeurologicos  --}}
    $("select[name=herNeurologicos]").change(function(){
        if($('select[name=herNeurologicos]').val() == "SI"){
            $("#herNeurologicosGrado").prop('required', false);
    
           
        }else{
            $("#herNeurologicosGrado").prop('required', false);
    
        }
    });
    {{--  herPsicologicos  --}}
    $("select[name=herPsicologicos]").change(function(){
        if($('select[name=herPsicologicos]').val() == "SI"){
            $("#herPsicologicosGrado").prop('required', false);
 
           
        }else{
            $("#herPsicologicosGrado").prop('required', false);
    
        }
    });
    {{--  herLenguaje  --}}
    $("select[name=herLenguaje]").change(function(){
        if($('select[name=herLenguaje]').val() == "SI"){
            $("#herLenguajeGrado").prop('required', false);
  
           
        }else{
            $("#herLenguajeGrado").prop('required', false);
    
        }
    });

    {{--  herAdicciones  --}}
    $("select[name=herAdicciones]").change(function(){
        if($('select[name=herAdicciones]').val() == "SI"){
            $("#herAdiccionesGrado").prop('required', false);
   
           
        }else{
            $("#herAdiccionesGrado").prop('required', false);
    
        }
    });
</script>