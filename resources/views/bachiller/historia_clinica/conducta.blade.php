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
                <input type="checkbox" name="conAfectivoNervioso" id="conAfectivoNervioso" value="" {{ (! empty(old('conAfectivoNervioso')) ? 'checked' : '') }}>
                <label for="conAfectivoNervioso"><strong style="color: #000; font-size: 16px;">Nervioso/Ansioso</strong></label>
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
                <input type="checkbox" name="conAfectivoDestraido" id="conAfectivoDestraido" value="" {{ (! empty(old('conAfectivoDestraido')) ? 'checked' : '') }}>
                <label for="conAfectivoDestraido"><strong style="color: #000; font-size: 16px;">Distraído</strong></label>
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
                <input type="checkbox" name="conAfectivoSensible" id="conAfectivoSensible" value="" {{ (! empty(old('conAfectivoSensible')) ? 'checked' : '') }}>
                <label for="conAfectivoSensible"><strong style="color: #000; font-size: 16px;">Sensible</strong></label>
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
                <input type="checkbox" name="conAfectivoAmable" id="conAfectivoAmable" value="" {{ (! empty(old('conAfectivoAmable')) ? 'checked' : '') }}>
                <label for="conAfectivoAmable"><strong style="color: #000; font-size: 16px;">Amable</strong></label>
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
                <input type="checkbox" name="conAfectivoAgresivo" id="conAfectivoAgresivo" value="" {{ (! empty(old('conAfectivoAgresivo')) ? 'checked' : '') }}>
                <label for="conAfectivoAgresivo"><strong style="color: #000; font-size: 16px;">Agresivo</strong></label>
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
                <input type="checkbox" name="conAfectivoTimido" id="conAfectivoTimido" value="" {{ (! empty(old('conAfectivoTimido')) ? 'checked' : '') }}>
                <label for="conAfectivoTimido"><strong style="color: #000; font-size: 16px;">Tímido</strong></label>
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
                <input type="checkbox" name="conAfectivoAmistoso" id="conAfectivoAmistoso" value="" {{ (! empty(old('conAfectivoAmistoso')) ? 'checked' : '') }}>
                <label for="conAfectivoAmistoso"><strong style="color: #000; font-size: 16px;">Amistoso</strong></label>
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
                @php                                  
                    if(old('conAfectivoOtro') !== null){
                        $conAfectivoOtro = old('conAfectivoOtro'); 
                    }
                    else{ $conAfectivoOtro = $consucta->conAfectivoOtro; }
                @endphp
                <label for="conAfectivoOtro"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                {!! Form::text('conAfectivoOtro', $consucta->conAfectivoOtro, array('id' => 'conAfectivoOtro', 'class' =>
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
                <input type="checkbox" name="conVerbalRenuente" id="conVerbalRenuente" value="" {{ (! empty(old('conVerbalRenuente')) ? 'checked' : '') }}>
                <label for="conVerbalRenuente"><strong style="color: #000; font-size: 16px;">Renuente a contestar</strong></label>
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
                <input type="checkbox" name="conVerbalVerbalizacion" id="conVerbalVerbalizacion" value="" {{ (! empty(old('conVerbalVerbalizacion')) ? 'checked' : '') }}>
                <label for="conVerbalVerbalizacion"><strong style="color: #000; font-size: 16px;">Verbalización excesiva</strong></label>
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
                <input type="checkbox" name="conVerbalSilencioso" id="conVerbalSilencioso" value="" {{ (! empty(old('conVerbalSilencioso')) ? 'checked' : '') }}>
                <label for="conVerbalSilencioso"><strong style="color: #000; font-size: 16px;">Silencioso</strong></label>
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
                <input type="checkbox" name="conVerbalTartamudez" id="conVerbalTartamudez" value="" {{ (! empty(old('conVerbalTartamudez')) ? 'checked' : '') }}>
                <label for="conVerbalTartamudez"><strong style="color: #000; font-size: 16px;">Tartamudez</strong></label>
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
                <input type="checkbox" name="conVerbalExplicito" id="conVerbalExplicito" value="" {{ (! empty(old('conVerbalExplicito')) ? 'checked' : '') }}>
                <label for="conVerbalExplicito"><strong style="color: #000; font-size: 16px;">Explícito</strong></label>
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
                <input type="checkbox" name="conVerbalRepetivo" id="conVerbalRepetivo" value="" {{ (! empty(old('conVerbalRepetivo')) ? 'checked' : '') }}>
                <label for="conVerbalRepetivo"><strong style="color: #000; font-size: 16px;">Repetitivo</strong></label>
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
        <label for="conConductual"><strong style="color: #000; font-size: 16px;">Nivel conductual</strong></label>
            <select id="conConductual" class="browser-default" name="conConductual" style="width: 100%;">
                @php                                  
                   if(old('conConductual') !== null){
                        $conConductual = old('conConductual'); 
                    }
                    else{ $conConductual = $consucta->conConductual; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="ACTIVO (ESPERADO)" {{ $conConductual == "ACTIVO (ESPERADO)" ? 'selected="selected"' : '' }}>Activo (esperado)</option>
                <option value="PASIVO" {{ $conConductual == "PASIVO" ? 'selected="selected"' : '' }}>Pasivo</option>
                <option value="HIPERECTIVO" {{ $conConductual == "HIPERECTIVO" ? 'selected="selected"' : '' }}>Hiperactivo</option>
            </select>
        </div>
    </div>

    <br>
    <P>El niño presenta algunas de las siguientes conductas:</P>
    <div class="row">
        {{--  Berrinches recurrentes --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="conBerrinches" id="conBerrinches" value="" {{ (! empty(old('conBerrinches')) ? 'checked' : '') }}>
                <label for="conBerrinches"><strong style="color: #000; font-size: 16px;">Berrinches recurrentes</strong></label>
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
                <input type="checkbox" name="conAgresividad" id="conAgresividad" value="" {{ (! empty(old('conAgresividad')) ? 'checked' : '') }}>
                <label for="conAgresividad"><strong style="color: #000; font-size: 16px;">Agresividad</strong></label>
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
                <input type="checkbox" name="conMasturbacion" id="conMasturbacion" value="" {{ (! empty(old('conMasturbacion')) ? 'checked' : '') }}>
                <label for="conMasturbacion"><strong style="color: #000; font-size: 16px;">Masturbación</strong></label>
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
                <input type="checkbox" name="conMentiras" id="conMentiras" value="" {{ (! empty(old('conMentiras')) ? 'checked' : '') }}>
                <label for="conMentiras"><strong style="color: #000; font-size: 16px;">Mentiras</strong></label>
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
                <input type="checkbox" name="conRobo" id="conRobo" value="" {{ (! empty(old('conRobo')) ? 'checked' : '') }}>
                <label for="conRobo"><strong style="color: #000; font-size: 16px;">Robo</strong></label>
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
                <input type="checkbox" name="conPesadillas" id="conPesadillas" value="" value="" {{ (! empty(old('conPesadillas')) ? 'checked' : '') }}>
                <label for="conPesadillas"><strong style="color: #000; font-size: 16px;">Pesadillas</strong></label>
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
                <input type="checkbox" name="conEnuresis" id="conEnuresis" value="" {{ (! empty(old('conEnuresis')) ? 'checked' : '') }}>
                <label for="conEnuresis"><strong style="color: #000; font-size: 16px;"> Enuresis (Pérdida de orina)</strong></label>
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
                <input type="checkbox" name="conEncopresis" id="conEncopresis" value="" {{ (! empty(old('conEncopresis')) ? 'checked' : '') }}>
                <label for="conEncopresis"><strong style="color: #000; font-size: 16px;">Encopresis (Pérdida fecal)</strong></label>
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
                <input type="checkbox" name="conExcesoAlimentacion" id="conExcesoAlimentacion" value="" {{ (! empty(old('conExcesoAlimentacion')) ? 'checked' : '') }}>
                <label for="conExcesoAlimentacion"><strong style="color: #000; font-size: 16px;">Exceso de alimentación</strong></label>

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
                <input type="checkbox" name="conRechazoAlimentario" id="conRechazoAlimentario" value="" {{ (! empty(old('conRechazoAlimentario')) ? 'checked' : '') }}>
                <label for="conRechazoAlimentario"><strong style="color: #000; font-size: 16px;">Rechazo excesivo de alimentos</strong></label>
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
                <input type="checkbox" name="conLlanto" id="conLlanto" value="" {{ (! empty(old('conLlanto')) ? 'checked' : '') }}>
                <label for="conLlanto"><strong style="color: #000; font-size: 16px;">Llanto excesivo</strong></label>
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
                <input type="checkbox" name="conTricotilomania" id="conTricotilomania" value="" {{ (! empty(old('conTricotilomania')) ? 'checked' : '') }}>
                <label for="conTricotilomania"><strong style="color: #000; font-size: 16px;">Tricotilomanía (Arrancarse el cabello)</strong></label>
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
                <input type="checkbox" name="conOnicofagia" id="conOnicofagia" value="" {{ (! empty(old('conOnicofagia')) ? 'checked' : '') }}>
                <label for="conOnicofagia"><strong style="color: #000; font-size: 16px;">Onicofagia (Comerse las uñas)</strong></label>
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
                <input type="checkbox" name="conMorderUnias" id="conMorderUnias" value="" {{ (! empty(old('conMorderUnias')) ? 'checked' : '') }}>
                <label for="conMorderUnias"><strong style="color: #000; font-size: 16px;">Morderse las uñas</strong></label>
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
                <input type="checkbox" name="conSuccionPulgar" id="conSuccionPulgar" value="" {{ (! empty(old('conSuccionPulgar')) ? 'checked' : '') }}>
                <label for="conSuccionPulgar"><strong style="color: #000; font-size: 16px;">Succión del pulgar</strong></label>
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
                <input type="checkbox" name="conExplicaciones" id="conExplicaciones" value="" {{ (! empty(old('conExplicaciones')) ? 'checked' : '') }}>
                <label for="conExplicaciones"><strong style="color: #000; font-size: 16px;">Explicaciones</strong></label>
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
                <input type="checkbox" name="conPrivaciones" id="conPrivaciones" value="" {{ (! empty(old('conPrivaciones')) ? 'checked' : '') }}>
                <label for="conPrivaciones"><strong style="color: #000; font-size: 16px;">Privaciones</strong></label>
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
                <input type="checkbox" name="conCorporal" id="conCorporal" value="" {{ (! empty(old('conCorporal')) ? 'checked' : '') }}>
                <label for="conCorporal"><strong style="color: #000; font-size: 16px;">Corporal</strong></label>
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
                <input type="checkbox" name="conAmenazas" id="conAmenazas" value="" {{ (! empty(old('conAmenazas')) ? 'checked' : '') }}>
                <label for="conAmenazas"><strong style="color: #000; font-size: 16px;">Amenazas</strong></label>
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
                <input type="checkbox" name="conTiempoFuera" id="conTiempoFuera" value="" {{ (! empty(old('conTiempoFuera')) ? 'checked' : '') }}>
                <label for="conTiempoFuera"><strong style="color: #000; font-size: 16px;">Tiempo fuera</strong></label>
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
                @php                                  
                    if(old('conOtros') !== null){
                        $conOtros = old('conOtros'); 
                    }
                    else{ $conOtros = $consucta->conOtros; }
                @endphp
                <label for="conOtros"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                {!! Form::text('conOtros', $conOtros, array('id' => 'conOtros', 'class' => 'validate','maxlength'=>'15')) !!}
            </div>
        </div>

        {{-- ¿Quién las aplica? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('conAplica') !== null){
                        $conAplica = old('conAplica'); 
                    }
                    else{ $conAplica = $consucta->conAplica; }
                @endphp
                <label for="conAplica"><strong style="color: #000; font-size: 16px;">¿Quién las aplica?</strong></label>
                {!! Form::text('conAplica', $conAplica, array('id' => 'conAplica', 'class' => 'validate','maxlength'=>'80')) !!}
            </div>
        </div>

        {{-- ¿Cuándo y cómo es recompensado? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('conRecompensa') !== null){
                        $conRecompensa = old('conRecompensa'); 
                    }
                    else{ $conRecompensa = $consucta->conRecompensa; }
                @endphp
                <label for="conRecompensa"><strong style="color: #000; font-size: 16px;">¿Cuándo y cómo es recompensado?</strong></label>
                {!! Form::text('conRecompensa', $conRecompensa, array('id' => 'conRecompensa', 'class' => 'validate','maxlength'=>'255')) !!}
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