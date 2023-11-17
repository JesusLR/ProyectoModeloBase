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
                <input type="checkbox" {{ (! empty(old('conAfectivoNervioso')) ? 'checked' : '') }} name="conAfectivoNervioso" id="conAfectivoNervioso" value="">
                <label for="conAfectivoNervioso"><strong style="color: #000; font-size: 16px;">Nervioso/Ansioso</strong></label>
            </div>
        </div>
            
        {{-- Distraído --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conAfectivoDestraido')) ? 'checked' : '') }} name="conAfectivoDestraido" id="conAfectivoDestraido" value="">
                <label for="conAfectivoDestraido"><strong style="color: #000; font-size: 16px;">Distraído</strong></label>
            </div>
        </div>
         

        {{-- Sensible --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conAfectivoSensible')) ? 'checked' : '') }} name="conAfectivoSensible" id="conAfectivoSensible" value="">
                <label for="conAfectivoSensible"><strong style="color: #000; font-size: 16px;">Sensible</strong></label>
            </div>
        </div>
  

        {{-- Amable --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conAfectivoAmable')) ? 'checked' : '') }} name="conAfectivoAmable" id="conAfectivoAmable" value="">
                <label for="conAfectivoAmable"><strong style="color: #000; font-size: 16px;">Amable</strong></label>
            </div>
        </div> 
          
    </div>

    <div class="row">
        {{-- Agresivo --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conAfectivoAgresivo')) ? 'checked' : '') }} name="conAfectivoAgresivo" id="conAfectivoAgresivo" value="">
                <label for="conAfectivoAgresivo"><strong style="color: #000; font-size: 16px;">Agresivo</strong></label>
            </div>
        </div>
      
        {{-- Tímido --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conAfectivoTimido')) ? 'checked' : '') }} name="conAfectivoTimido" id="conAfectivoTimido" value="">
                <label for="conAfectivoTimido"><strong style="color: #000; font-size: 16px;">Tímido</strong></label>
            </div>
        </div>
       

               {{-- Amistoso --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conAfectivoAmistoso')) ? 'checked' : '') }} name="conAfectivoAmistoso" id="conAfectivoAmistoso" value="">
                <label for="conAfectivoAmistoso"><strong style="color: #000; font-size: 16px;">Amistoso</strong></label>
            </div>
        </div>
                  
    </div>
    <div class="row">
        {{-- Otro --}}
        <div class="col s12 m6 l6" style="margin-top:5px;">
            <div class="input-field">
                <label for="conAfectivoOtro"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                {!! Form::text('conAfectivoOtro', old('conAfectivoOtro'), array('id' => 'conAfectivoOtro', 'class' =>
                'validate','maxlength'=>'40')) !!}
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
                <input type="checkbox" {{ (! empty(old('conVerbalRenuente')) ? 'checked' : '') }} name="conVerbalRenuente" id="conVerbalRenuente" value="">
                <label for="conVerbalRenuente"><strong style="color: #000; font-size: 16px;">Renuente a contestar</strong></label>
            </div>
        </div>
     
        {{-- Verbalización excesiva --}}
        <div class="col s12 m6 l4" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conVerbalVerbalizacion')) ? 'checked' : '') }} name="conVerbalVerbalizacion" id="conVerbalVerbalizacion" value="">
                <label for="conVerbalVerbalizacion"><strong style="color: #000; font-size: 16px;">Verbalización excesiva</strong></label>
            </div>
        </div>
       
               {{-- Silencioso --}}
        <div class="col s12 m6 l4" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conVerbalSilencioso')) ? 'checked' : '') }} name="conVerbalSilencioso" id="conVerbalSilencioso" value="">
                <label for="conVerbalSilencioso"><strong style="color: #000; font-size: 16px;">Silencioso</strong></label>
            </div>
        </div>  
               
    </div>
    
    <div class="row">
        {{-- Tartamudez --}}
        <div class="col s12 m6 l4" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conVerbalTartamudez')) ? 'checked' : '') }} name="conVerbalTartamudez" id="conVerbalTartamudez" value="">
                <label for="conVerbalTartamudez"><strong style="color: #000; font-size: 16px;">Tartamudez</strong></label>
            </div>
        </div>
       
        {{-- Explícito --}}
        <div class="col s12 m6 l4" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conVerbalExplicito')) ? 'checked' : '') }} name="conVerbalExplicito" id="conVerbalExplicito" value="">
                <label for="conVerbalExplicito"><strong style="color: #000; font-size: 16px;">Explícito</strong></label>
            </div>
        </div>
       
               {{-- Repetitivo --}}
        <div class="col s12 m6 l4" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conVerbalRepetivo')) ? 'checked' : '') }} name="conVerbalRepetivo" id="conVerbalRepetivo" value="">
                <label for="conVerbalRepetivo"><strong style="color: #000; font-size: 16px;">Repetitivo</strong></label>
            </div>
        </div>   
                
    </div>

    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">Nivel conductual </p>
    </div>
    <div class="row">
        <div class="col s12 m6 l4">
        <label for="conConductual"><strong style="color: #000; font-size: 16px;">Nivel conductual</strong></label>
            <select id="conConductual" class="browser-default" name="conConductual" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="ACTIVO (ESPERADO)" {{ old('conConductual') == "ACTIVO (ESPERADO)" ? 'selected' : '' }}>Activo (esperado)</option>
                <option value="PASIVO" {{ old('conConductual') == "PASIVO" ? 'selected' : '' }}>Pasivo</option>
                <option value="HIPERECTIVO" {{ old('conConductual') == "HIPERECTIVO" ? 'selected' : '' }}>Hiperactivo</option>
            </select>
        </div>
    </div>

    <br>
    <P>El niño presenta algunas de las siguientes conductas:</P>
    <div class="row">
        {{--  Berrinches recurrentes --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conBerrinches')) ? 'checked' : '') }} name="conBerrinches" id="conBerrinches" value="">
                <label for="conBerrinches"><strong style="color: #000; font-size: 16px;">Berrinches recurrentes</strong></label>
            </div>
        </div>
              
        {{-- Agresividad --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conAgresividad')) ? 'checked' : '') }} name="conAgresividad" id="conAgresividad" value="">
                <label for="conAgresividad"><strong style="color: #000; font-size: 16px;">Agresividad</strong></label>
            </div>
        </div>
    
        {{-- Masturbación --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conMasturbacion')) ? 'checked' : '') }} name="conMasturbacion" id="conMasturbacion" value="">
                <label for="conMasturbacion"><strong style="color: #000; font-size: 16px;">Masturbación</strong></label>
            </div>
        </div>
        
        {{-- Mentiras --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conMentiras')) ? 'checked' : '') }} name="conMentiras" id="conMentiras" value="">
                <label for="conMentiras"><strong style="color: #000; font-size: 16px;">Mentiras</strong></label>
            </div>
        </div>   
           
    </div>

    <div class="row">
        {{--  Robo --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conRobo')) ? 'checked' : '') }} name="conRobo" id="conRobo" value="">
                <label for="conRobo"><strong style="color: #000; font-size: 16px;">Robo</strong></label>
            </div>
        </div>
       
        {{-- Pesadillas --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conPesadillas')) ? 'checked' : '') }} name="conPesadillas" id="conPesadillas" value="">
                <label for="conPesadillas"><strong style="color: #000; font-size: 16px;">Pesadillas</strong></label>
            </div>
        </div>
     
        {{-- Enuresis (Pérdida de orina) --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conEnuresis')) ? 'checked' : '') }} name="conEnuresis" id="conEnuresis" value="">
                <label for="conEnuresis"><strong style="color: #000; font-size: 16px;">Enuresis (Pérdida de orina)</strong></label>
            </div>
        </div>
              {{-- Encopresis (Pérdida fecal) --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conEncopresis')) ? 'checked' : '') }} name="conEncopresis" id="conEncopresis" value="">
                <label for="conEncopresis"><strong style="color: #000; font-size: 16px;">Encopresis (Pérdida fecal)</strong></label>
            </div>
        </div>    
         
    </div>

    <div class="row">
        {{--  Exceso de alimentación --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conExcesoAlimentacion')) ? 'checked' : '') }} name="conExcesoAlimentacion" id="conExcesoAlimentacion" value="">
                <label for="conExcesoAlimentacion"><strong style="color: #000; font-size: 16px;">Exceso de alimentación</strong></label>
            </div>
        </div>
      
        {{-- Rechazo excesivo de alimentos --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conRechazoAlimentario')) ? 'checked' : '') }} name="conRechazoAlimentario" id="conRechazoAlimentario" value="">
                <label for="conRechazoAlimentario"><strong style="color: #000; font-size: 16px;">Rechazo excesivo de alimentos</strong></label>
            </div>
        </div>
    

        {{-- Llanto excesivo --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conLlanto')) ? 'checked' : '') }} name="conLlanto" id="conLlanto" value="">
                <label for="conLlanto"><strong style="color: #000; font-size: 16px;">Llanto excesivo</strong></label>
            </div>
        </div>
      
        {{-- Tricotilomanía (Arrancarse el cabello) --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conTricotilomania')) ? 'checked' : '') }} name="conTricotilomania" id="conTricotilomania" value="">
                <label for="conTricotilomania"><strong style="color: #000; font-size: 16px;">Tricotilomanía (Arrancarse el cabello)</strong></label>
            </div>
        </div>  
          
    </div>

    <div class="row">
        {{--  Onicofagia (Comerse las uñas)  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conOnicofagia')) ? 'checked' : '') }} name="conOnicofagia" id="conOnicofagia" value="">
                <label for="conOnicofagia"><strong style="color: #000; font-size: 16px;">Onicofagia (Comerse las uñas)</strong></label>
            </div>
        </div>  
       
        {{--  conMorderUnias  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conMorderUnias')) ? 'checked' : '') }} name="conMorderUnias" id="conMorderUnias" value="">
                <label for="conMorderUnias"><strong style="color: #000; font-size: 16px;">Morderse las uñas</strong></label>
            </div>
        </div> 
       

        {{--  conSuccionPulgar  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conSuccionPulgar')) ? 'checked' : '') }} name="conSuccionPulgar" id="conSuccionPulgar" value="">
                <label for="conSuccionPulgar"><strong style="color: #000; font-size: 16px;">Succión del pulgar</strong></label>
            </div>
        </div> 
       
    </div>

    <br>
    <p>¿Cómo controlaron estas conductas o como aplican una consecuencia?</p>
    <div class="row">
        {{-- Explicaciones --}}
        <div class="col s12 m6 l4" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conExplicaciones')) ? 'checked' : '') }} name="conExplicaciones" id="conExplicaciones" value="">
                <label for="conExplicaciones"><strong style="color: #000; font-size: 16px;">Explicaciones</strong></label>
            </div>
        </div>
     
        {{-- Privaciones --}}
        <div class="col s12 m6 l4" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conPrivaciones')) ? 'checked' : '') }} name="conPrivaciones" id="conPrivaciones" value="">
                <label for="conPrivaciones"><strong style="color: #000; font-size: 16px;">Privaciones</strong></label>
            </div>
        </div>
    

        {{-- Corporal --}}
        <div class="col s12 m6 l4" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conCorporal')) ? 'checked' : '') }} name="conCorporal" id="conCorporal" value="">
                <label for="conCorporal"><strong style="color: #000; font-size: 16px;">Corporal</strong></label>
            </div>
        </div>    
     
    </div>
    <div class="row">
        {{-- Amenazas --}}
        <div class="col s12 m6 l4" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conAmenazas')) ? 'checked' : '') }} name="conAmenazas" id="conAmenazas" value="">
                <label for="conAmenazas"><strong style="color: #000; font-size: 16px;">Amenazas</strong></label>
            </div>
        </div>
     

        {{-- Tiempo fuera --}}
        <div class="col s12 m6 l4" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" {{ (! empty(old('conTiempoFuera')) ? 'checked' : '') }} name="conTiempoFuera" id="conTiempoFuera" value="">
                <label for="conTiempoFuera"><strong style="color: #000; font-size: 16px;">Tiempo fuera</strong></label>
            </div>
        </div>   
          
    </div>
    <div class="row">
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="conOtros"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                {!! Form::text('conOtros', old('conOtros'), array('id' => 'conOtros', 'class' => 'validate','maxlength'=>'15')) !!}
            </div>
        </div>

        {{-- ¿Quién las aplica? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="conAplica"><strong style="color: #000; font-size: 16px;">¿Quién las aplica?</strong></label>
                {!! Form::text('conAplica', old('conAplica'), array('id' => 'conAplica', 'class' => 'validate','maxlength'=>'80', 'required')) !!}
            </div>
        </div>

        {{-- ¿Cuándo y cómo es recompensado? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="conRecompensa"><strong style="color: #000; font-size: 16px;">¿Cuándo y cómo es recompensado?</strong></label>
                {!! Form::text('conRecompensa', old('conRecompensa'), array('id' => 'conRecompensa', 'class' => 'validate','maxlength'=>'255', 'required')) !!}
            </div>
        </div>
    </div>

</div>

<script>

/* ---------------------------- Nervioso/Ansioso ---------------------------- */
    $("input[name=conAfectivoNervioso]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conAfectivoNervioso").val("NERVIOSO/ANSIOSO");
    
        } else {
            $("#conAfectivoNervioso").val("");
        }
    });
    if( $('#conAfectivoNervioso').prop('checked') ) {
        $("#conAfectivoNervioso").val("NERVIOSO/ANSIOSO");
    }else{
        $("#conAfectivoNervioso").val("");
    }

/* -------------------------------- Agresivo -------------------------------- */
    $("input[name=conAfectivoAgresivo]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conAfectivoAgresivo").val("AGRESIVO");
    
        } else {
            $("#conAfectivoAgresivo").val("");
        }
    });
    if( $('#conAfectivoAgresivo').prop('checked') ) {
        $("#conAfectivoAgresivo").val("AGRESIVO");
    }else{
        $("#conAfectivoAgresivo").val("");
    }

/* -------------------------------- Distraído ------------------------------- */
    $("input[name=conAfectivoDestraido]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conAfectivoDestraido").val("DISTRAÍDO");
    
        } else {
            $("#conAfectivoDestraido").val("");
        }
    });
    if( $('#conAfectivoDestraido').prop('checked') ) {
        $("#conAfectivoDestraido").val("DISTRAÍDO");
    }else{
        $("#conAfectivoDestraido").val("");
    }

/* --------------------------------- Tímido --------------------------------- */
    $("input[name=conAfectivoTimido]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conAfectivoTimido").val("TÍMIDO");
    
        } else {
            $("#conAfectivoTimido").val("");
        }
    });
    if( $('#conAfectivoTimido').prop('checked') ) {
        $("#conAfectivoTimido").val("TÍMIDO");
    }else{
        $("#conAfectivoTimido").val("");
    }

/* -------------------------------- Sensible -------------------------------- */
    $("input[name=conAfectivoSensible]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conAfectivoSensible").val("SENSIBLE");
    
        } else {
            $("#conAfectivoSensible").val("");
        }
    });
    if( $('#conAfectivoSensible').prop('checked') ) {
        $("#conAfectivoSensible").val("SENSIBLE");
    }else{
        $("#conAfectivoSensible").val("");
    }

/* --------------------------- Amistoso -------------------------- */
    $("input[name=conAfectivoAmistoso]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conAfectivoAmistoso").val("AMISTOSO");
    
        } else {
            $("#conAfectivoAmistoso").val("");
        }
    });
    if( $('#conAfectivoAmistoso').prop('checked') ) {
        $("#conAfectivoAmistoso").val("AMISTOSO");
    }else{
        $("#conAfectivoAmistoso").val("");
    }

/* --------------------------------- Amable --------------------------------- */
    $("input[name=conAfectivoAmable]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conAfectivoAmable").val("AMABLE");
    
        } else {
            $("#conAfectivoAmable").val("");
        }
    });
    if( $('#conAfectivoAmable').prop('checked') ) {
        $("#conAfectivoAmable").val("AMABLE");
    }else{
        $("#conAfectivoAmable").val("");
    }
/* -------------------------- Renuente a contestar -------------------------- */
    $("input[name=conVerbalRenuente]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conVerbalRenuente").val("RENUENTE A CONTESTAR");
    
        } else {
            $("#conVerbalRenuente").val("");
        }
    });
    if( $('#conVerbalRenuente').prop('checked') ) {
        $("#conVerbalRenuente").val("RENUENTE A CONTESTAR");
    }else{
        $("#conVerbalRenuente").val("");
    }

/* ------------------------------- Tartamudez ------------------------------- */
    $("input[name=conVerbalTartamudez]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conVerbalTartamudez").val("TARTAMUDEZ");
    
        } else {
            $("#conVerbalTartamudez").val("");
        }
    });
    if( $('#conVerbalTartamudez').prop('checked') ) {
        $("#conVerbalTartamudez").val("TARTAMUDEZ");
    }else{
        $("#conVerbalTartamudez").val("");
    }

/* ------------------------- Verbalización excesiva ------------------------- */
    $("input[name=conVerbalVerbalizacion]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conVerbalVerbalizacion").val("VERBALIZACIÓN EXCESIVA");
    
        } else {
            $("#conVerbalVerbalizacion").val("");
        }
    });
    if( $('#conVerbalVerbalizacion').prop('checked') ) {
        $("#conVerbalVerbalizacion").val("VERBALIZACIÓN EXCESIVA");
    }else{
        $("#conVerbalVerbalizacion").val("");
    }

/* -------------------------------- Explícito ------------------------------- */
    $("input[name=conVerbalExplicito]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conVerbalExplicito").val("EXPLÍCITO");
    
        } else {
            $("#conVerbalExplicito").val("");
        }
    });
    if( $('#conVerbalExplicito').prop('checked') ) {
        $("#conVerbalExplicito").val("EXPLÍCITO");
    }else{
        $("#conVerbalExplicito").val("");
    }

/* ------------------------------- Silencioso ------------------------------- */
    $("input[name=conVerbalSilencioso]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conVerbalSilencioso").val("SILENCIOSO");
    
        } else {
            $("#conVerbalSilencioso").val("");
        }
    });
    if( $('#conVerbalSilencioso').prop('checked') ) {
        $("#conVerbalSilencioso").val("SILENCIOSO");
    }else{
        $("#conVerbalSilencioso").val("");
    }

/* ------------------------------- Repetitivo ------------------------------- */
    $("input[name=conVerbalRepetivo]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conVerbalRepetivo").val("REPETITIVO");
    
        } else {
            $("#conVerbalRepetivo").val("");
        }
    });

    if( $('#conVerbalRepetivo').prop('checked') ) {
        $("#conVerbalRepetivo").val("REPETITIVO");
    }else{
        $("#conVerbalRepetivo").val("");
    }

/* ------------------------- Berrinches recurrentes ------------------------- */
    $("input[name=conBerrinches]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conBerrinches").val("BERRINCHES RECURRENTES");
    
        } else {
            $("#conBerrinches").val("");
        }
    });

    if( $('#conBerrinches').prop('checked') ) {
        $("#conBerrinches").val("BERRINCHES RECURRENTES");
    }else{
        $("#conBerrinches").val("");
    }

/* ------------------------------- Agresividad ------------------------------ */
    $("input[name=conAgresividad]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conAgresividad").val("AGRESIVIDAD");
    
        } else {
            $("#conAgresividad").val("");
        }
    });

    if( $('#conAgresividad').prop('checked') ) {
        $("#conAgresividad").val("AGRESIVIDAD");
    }else{
        $("#conAgresividad").val("");
    }

/* ------------------------------ Masturbación ------------------------------ */
    $("input[name=conMasturbacion]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conMasturbacion").val("MASTURBACIÓN");
    
        } else {
            $("#conMasturbacion").val("");
        }
    });

    if( $('#conMasturbacion').prop('checked') ) {
        $("#conMasturbacion").val("MASTURBACIÓN");
    }else{
        $("#conMasturbacion").val("");
    }

/* ------------------------------ Mentiras ------------------------------ */
    $("input[name=conMentiras]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conMentiras").val("MENTIRAS");
    
        } else {
            $("#conMentiras").val("");
        }
    });

    if( $('#conMentiras').prop('checked') ) {
        $("#conMentiras").val("MENTIRAS");
    }else{
        $("#conMentiras").val("");
    }

/* ---------------------------------- Robo ---------------------------------- */
    $("input[name=conRobo]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conRobo").val("ROBO");
    
        } else {
            $("#conRobo").val("");
        }
    });

    if( $('#conRobo').prop('checked') ) {
        $("#conRobo").val("ROBO");
    }else{
        $("#conRobo").val("");
    }

/* ------------------------------- Pesadillas ------------------------------- */
    $("input[name=conPesadillas]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conPesadillas").val("PESADILLAS");
    
        } else {
            $("#conPesadillas").val("");
        }
    });

    if( $('#conPesadillas').prop('checked') ) {
        $("#conPesadillas").val("PESADILLAS");
    }else{
        $("#conPesadillas").val("");
    }

/* ----------------------- Enuresis (Pérdida de orina) ---------------------- */
    $("input[name=conEnuresis]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conEnuresis").val("ENURESIS (PÉRDIDA DE ORINA)");
    
        } else {
            $("#conEnuresis").val("");
        }
    });

    if( $('#conEnuresis').prop('checked') ) {
        $("#conEnuresis").val("ENURESIS (PÉRDIDA DE ORINA)");
    }else{
        $("#conEnuresis").val("");
    }

/* ----------------------- Encopresis (Pérdida fecal) ----------------------- */
    $("input[name=conEncopresis]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conEncopresis").val("ENCOPRESIS (PÉRDIDA FECAL)");
    
        } else {
            $("#conEncopresis").val("");
        }
    });

    if( $('#conEncopresis').prop('checked') ) {
        $("#conEncopresis").val("ENCOPRESIS (PÉRDIDA FECAL)");
    }else{
        $("#conEncopresis").val("");
    }

/* ------------------------- Exceso de alimentación ------------------------- */
    $("input[name=conExcesoAlimentacion]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conExcesoAlimentacion").val("EXCESO DE ALIMENTACIÓN");
    
        } else {
            $("#conExcesoAlimentacion").val("");
        }
    });

    if( $('#conExcesoAlimentacion').prop('checked') ) {
        $("#conExcesoAlimentacion").val("EXCESO DE ALIMENTACIÓN");
    }else{
        $("#conExcesoAlimentacion").val("");
    }

/* ---------------------- Rechazo excesivo de alimentos --------------------- */
    $("input[name=conRechazoAlimentario]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conRechazoAlimentario").val("RECHAZO EXCESIVO DE ALIMENTOS");
    
        } else {
            $("#conRechazoAlimentario").val("");
        }
    });
    if( $('#conRechazoAlimentario').prop('checked') ) {
        $("#conRechazoAlimentario").val("RECHAZO EXCESIVO DE ALIMENTOS");
    }else{
        $("#conRechazoAlimentario").val("");
    }

/* ----------------------------- Llanto excesivo ---------------------------- */
    $("input[name=conLlanto]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conLlanto").val("LLANTO EXCESIVO");
    
        } else {
            $("#conLlanto").val("");
        }
    });

    if( $('#conLlanto').prop('checked') ) {
        $("#conLlanto").val("LLANTO EXCESIVO");
    }else{
        $("#conLlanto").val("");
    }

/* ----------------- Tricotilomanía (Arrancarse el cabello) ----------------- */
    $("input[name=conTricotilomania]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conTricotilomania").val("TRICOTILOMANÍA (ARRANCARSE EL CABELLO)");
    
        } else {
            $("#conTricotilomania").val("");
        }
    });
    if( $('#conTricotilomania').prop('checked') ) {
        $("#conTricotilomania").val("TRICOTILOMANÍA (ARRANCARSE EL CABELLO)");
    }else{
        $("#conTricotilomania").val("");
    }

/* ---------------------- Onicofagia (Comerse las uñas) --------------------- */
    $("input[name=conOnicofagia]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conOnicofagia").val("ONICOFAGIA (COMERSE LAS UÑAS)");
    
        } else {
            $("#conOnicofagia").val("");
        }
    });

    if( $('#conOnicofagia').prop('checked') ) {
        $("#conOnicofagia").val("ONICOFAGIA (COMERSE LAS UÑAS)");
    }else{
        $("#conOnicofagia").val("");
    }

/* ---------------------------- Morderse las uñas --------------------------- */
    $("input[name=conMorderUnias]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conMorderUnias").val("MORDERSE LAS UÑAS");
    
        } else {
            $("#conMorderUnias").val("");
        }
    });

    if( $('#conMorderUnias').prop('checked') ) {
        $("#conMorderUnias").val("MORDERSE LAS UÑAS");
    }else{
        $("#conMorderUnias").val("");
    }

/* --------------------------- Succión del pulgar --------------------------- */
    $("input[name=conSuccionPulgar]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conSuccionPulgar").val("SUCCIÓN DEL PULGAR");
    
        } else {
            $("#conSuccionPulgar").val("");
        }
    });

    if( $('#conSuccionPulgar').prop('checked') ) {
        $("#conSuccionPulgar").val("SUCCIÓN DEL PULGAR");
    }else{
        $("#conSuccionPulgar").val("");
    }

/* ------------------------------ Explicaciones ----------------------------- */
    $("input[name=conExplicaciones]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conExplicaciones").val("EXPLICACIONES");
    
        } else {
            $("#conExplicaciones").val("");
        }
    });

    if( $('#conExplicaciones').prop('checked') ) {
        $("#conExplicaciones").val("EXPLICACIONES");
    }else{
        $("#conExplicaciones").val("");
    }
/* ------------------------------- Privaciones ------------------------------ */
    $("input[name=conPrivaciones]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conPrivaciones").val("PRIVACIONES");
    
        } else {
            $("#conPrivaciones").val("");
        }
    });

    if( $('#conPrivaciones').prop('checked') ) {
        $("#conPrivaciones").val("PRIVACIONES");
    }else{
        $("#conPrivaciones").val("");
    }

/* -------------------------------- Corporal -------------------------------- */
    $("input[name=conCorporal]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conCorporal").val("CORPORAL");
    
        } else {
            $("#conCorporal").val("");
        }
    });
    if( $('#conCorporal').prop('checked') ) {
        $("#conCorporal").val("CORPORAL");
    }else{
        $("#conCorporal").val("");
    }

/* -------------------------------- Amenazas -------------------------------- */
    $("input[name=conAmenazas]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conAmenazas").val("AMENAZAS");
    
        } else {
            $("#conAmenazas").val("");
        }
    });
    if( $('#conAmenazas').prop('checked') ) {
        $("#conAmenazas").val("AMENAZAS");
    }else{
        $("#conAmenazas").val("");
    }

/* ------------------------------ Tiempo fuera ------------------------------ */
    $("input[name=conTiempoFuera]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#conTiempoFuera").val("TIEMPO FUERA");
    
        } else {
            $("#conTiempoFuera").val("");
        }
    });

    if( $('#conTiempoFuera').prop('checked') ) {
        $("#conTiempoFuera").val("TIEMPO FUERA");
    }else{
        $("#conTiempoFuera").val("");
    }


</script>