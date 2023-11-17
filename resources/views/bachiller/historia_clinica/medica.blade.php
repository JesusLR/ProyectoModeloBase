<div id="medica">
    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">HISTORIA MÉDICA</p>
    </div>
    <br>
    <div class="row">
        {{--  Intervenciones quirúrgicas  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('medIntervencionQuirurgicas') !== null){
                        $medIntervencionQuirurgicas = old('medIntervencionQuirurgicas'); 
                    }
                    else{ $medIntervencionQuirurgicas = $medica->medIntervencionQuirurgicas; }
                @endphp
                <label for="medIntervencionQuirurgicas"><strong style="color: #000; font-size: 16px;">Intervenciones quirúrgicas</strong></label>
                {!! Form::text('medIntervencionQuirurgicas', $medIntervencionQuirurgicas, array('id' => 'medIntervencionQuirurgicas', 'class' => 'validate','maxlength'=>'4000')) !!}
            </div>
        </div>
        {{--  Tratamientos/ medicamentos  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('medMedicamentos') !== null){
                        $medMedicamentos = old('medMedicamentos'); 
                    }
                    else{ $medMedicamentos = $medica->medMedicamentos; }
                @endphp
                <label for="medMedicamentos"><strong style="color: #000; font-size: 16px;">Tratamientos/ medicamentos</strong></label>
                {!! Form::text('medMedicamentos', $medMedicamentos, array('id' => 'medMedicamentos', 'class' => 'validate','maxlength'=>'4000')) !!}
            </div>
        </div>

    </div>

    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">Padecimientos que ha sufrido o sufre el niño</p>
    </div>
    <div class="row">
        {{--  Convulsiones  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medConvulsiones" id="medConvulsiones" value="" {{ (! empty(old('medConvulsiones')) ? 'checked' : '') }}>
                <label for="medConvulsiones"><strong style="color: #000; font-size: 16px;">Convulsiones</strong></label>
            </div>
        </div>
        <script>
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medConvulsiones}}' == 'CONVULSIONES'){
                $("#medConvulsiones").prop("checked", true);
                $("#medConvulsiones").val("CONVULSIONES");
            }else{
                $("#medConvulsiones").prop("checked", false);
            }
        </script>
        
        {{--  Problemas de audición  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medAudicion" id="medAudicion" value="" {{ (! empty(old('medAudicion')) ? 'checked' : '') }}>
                <label for="medAudicion"><strong style="color: #000; font-size: 16px;"> Problemas de audición</strong></label>
            </div>
        </div>

        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medAudicion}}' == 'PROBLEMAS DE AUDICIÓN'){
                $("#medAudicion").prop("checked", true);
                $("#medAudicion").val("PROBLEMAS DE AUDICIÓN");
            }else{
                $("#medAudicion").prop("checked", false);
            }
        </script>

        {{--  Fiebres altas  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medFiebres" id="medFiebres" value="" {{ (! empty(old('medFiebres')) ? 'checked' : '') }}>
                <label for="medFiebres"><strong style="color: #000; font-size: 16px;">Fiebres altas</strong></label>
            </div>
        </div>

        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medFiebres}}' == 'FIEBRES ALTAS'){
                $("#medFiebres").prop("checked", true);
                $("#medFiebres").val("FIEBRES ALTAS");
            }else{
                $("#medFiebres").prop("checked", false);
            }
        </script>

        {{--  Problemas de corazón  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medProblemasCorazon" id="medProblemasCorazon" value="" {{ (! empty(old('medProblemasCorazon')) ? 'checked' : '') }}>
                <label for="medProblemasCorazon"><strong style="color: #000; font-size: 16px;">Problemas de corazón</strong></label>
            </div>
        </div>

        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medProblemasCorazon}}' == 'PROBLEMAS DE CORAZÓN'){
                $("#medProblemasCorazon").prop("checked", true);
                $("#medProblemasCorazon").val("PROBLEMAS DE CORAZÓN");
            }else{
                $("#medProblemasCorazon").prop("checked", false);
            }
        </script>
    </div>


    <div class="row">
        {{--  Deficiencia pulmonar y bronquial  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medDeficiencia" id="medDeficiencia" value="" {{ (! empty(old('medDeficiencia')) ? 'checked' : '') }}>
                <label for="medDeficiencia"><strong style="color: #000; font-size: 16px;">Deficiencia pulmonar y bronquial</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medDeficiencia}}' == 'DEFICIENCIA PULMONAR Y BRONQUIAL'){
                $("#medDeficiencia").prop("checked", true);
                $("#medDeficiencia").val("DEFICIENCIA PULMONAR Y BRONQUIAL");
            }else{
                $("#medDeficiencia").prop("checked", false);
            }
        </script>

        {{--  Asma  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medAsma" id="medAsma" value="" {{ (! empty(old('medAsma')) ? 'checked' : '') }}>
                <label for="medAsma"><strong style="color: #000; font-size: 16px;">Asma</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medAsma}}' == 'ASMA'){
                $("#medAsma").prop("checked", true);
                $("#medAsma").val("ASMA");
            }else{
                $("#medAsma").prop("checked", false);
            }
        </script>

        {{--  Diabetes  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medDiabetes" id="medDiabetes" value="" {{ (! empty(old('medDiabetes')) ? 'checked' : '') }}>
                <label for="medDiabetes"><strong style="color: #000; font-size: 16px;">Diabetes</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medDiabetes}}' == 'DIABETES'){
                $("#medDiabetes").prop("checked", true);
                $("#medDiabetes").val("DIABETES");
            }else{
                $("#medDiabetes").prop("checked", false);
            }
        </script>

        {{--  Problemas gastrointestinales  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medGastrointestinales" id="medGastrointestinales" value="" {{ (! empty(old('medGastrointestinales')) ? 'checked' : '') }}>
                <label for="medGastrointestinales"><strong style="color: #000; font-size: 16px;">Problemas gastrointestinales</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medGastrointestinales}}' == 'PROBLEMAS GASTROINTESTINALES'){
                $("#medGastrointestinales").prop("checked", true);
                $("#medGastrointestinales").val("PROBLEMAS GASTROINTESTINALES");
            }else{
                $("#medGastrointestinales").prop("checked", false);
            }
        </script>
    </div>


    <div class="row">
        {{--  Accidentes  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medAccidentes" id="medAccidentes" value="" {{ (! empty(old('medAccidentes')) ? 'checked' : '') }}>
                <label for="medAccidentes"><strong style="color: #000; font-size: 16px;">Accidentes</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medAccidentes}}' == 'ACCIDENTES'){
                $("#medAccidentes").prop("checked", true);
                $("#medAccidentes").val("ACCIDENTES");
            }else{
                $("#medAccidentes").prop("checked", false);
            }
        </script>

        {{--  Epilepsia  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medEpilepsia" id="medEpilepsia" value="" {{ (! empty(old('medEpilepsia')) ? 'checked' : '') }}>
                <label for="medEpilepsia"><strong style="color: #000; font-size: 16px;">Epilepsia</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medEpilepsia}}' == 'EPILEPSIA'){
                $("#medEpilepsia").prop("checked", true);
                $("#medEpilepsia").val("EPILEPSIA");
            }else{
                $("#medEpilepsia").prop("checked", false);
            }
        </script>

        {{--  Problemas de riñón  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medRinion" id="medRinion" value="" {{ (! empty(old('medRinion')) ? 'checked' : '') }}>
                <label for="medRinion"><strong style="color: #000; font-size: 16px;">Problemas de riñón</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medRinion}}' == 'PROBLEMAS DE RIÑON'){
                $("#medRinion").prop("checked", true);
                $("#medRinion").val("PROBLEMAS DE RIÑON");
            }else{
                $("#medRinion").prop("checked", false);
            }
        </script>

        {{--  Problemas de la piel  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medPiel" id="medPiel" value="" {{ (! empty(old('medPiel')) ? 'checked' : '') }}>
                <label for="medPiel"><strong style="color: #000; font-size: 16px;">Problemas de la piel</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medPiel}}' == 'PROBLEMAS DE LA PIEL'){
                $("#medPiel").prop("checked", true);
                $("#medPiel").val("PROBLEMAS DE LA PIEL");
            }else{
                $("#medPiel").prop("checked", false);
            }
        </script>
    </div>

    <div class="row">
        {{--  Falta de coordinación motriz  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medCoordinacionMotriz" id="medCoordinacionMotriz" value="" {{ (! empty(old('medCoordinacionMotriz')) ? 'checked' : '') }}>
                <label for="medCoordinacionMotriz"><strong style="color: #000; font-size: 16px;">Falta de coordinación motriz</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medCoordinacionMotriz}}' == 'FALTA DE COORDINACIÓN MOTRIZ'){
                $("#medCoordinacionMotriz").prop("checked", true);
                $("#medCoordinacionMotriz").val("FALTA DE COORDINACIÓN MOTRIZ");
            }else{
                $("#medCoordinacionMotriz").prop("checked", false);
            }
        </script>

        {{--  Estreñimiento  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medEstrenimiento" id="medEstrenimiento" value="" {{ (! empty(old('medEstrenimiento')) ? 'checked' : '') }}>
                <label for="medEstrenimiento"><strong style="color: #000; font-size: 16px;">Estreñimiento</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medEstrenimiento}}' == 'ESTREÑIMIENTO'){
                $("#medEstrenimiento").prop("checked", true);
                $("#medEstrenimiento").val("ESTREÑIMIENTO");
            }else{
                $("#medEstrenimiento").prop("checked", false);
            }
        </script>

        {{--  Dificultades durante el sueño  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medDificultadesSuenio" id="medDificultadesSuenio" value="" {{ (! empty(old('medDificultadesSuenio')) ? 'checked' : '') }}>
                <label for="medDificultadesSuenio"><strong style="color: #000; font-size: 16px;">Dificultades durante el sueño</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medDificultadesSuenio}}' == 'DIFICULTADES DURANTE EL SUEÑO'){
                $("#medDificultadesSuenio").prop("checked", true);
                $("#medDificultadesSuenio").val("DIFICULTADES DURANTE EL SUEÑO");
            }else{
                $("#medDificultadesSuenio").prop("checked", false);
            }
        </script>

        {{--  Alergias  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medAlergias" id="medAlergias" value="" {{ (! empty(old('medAlergias')) ? 'checked' : '') }}>
                <label for="medAlergias"><strong style="color: #000; font-size: 16px;">Alergias</strong></label>
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medAlergias}}' == 'ALERGIAS'){
                $("#medAlergias").prop("checked", true);
                $("#medAlergias").val("ALERGIAS");
                
            }else{
                $("#medAlergias").prop("checked", false);
            }
        </script>
    </div>

    <div class="row">
        {{--  campo para especificar alergias   --}}
        <div class="col s12 m6 l6" id="divEspecificar" style="display: none">
            <div class="input-field">
                @php                                  
                    if(old('medEspesificar') !== null){
                        $medEspesificar = old('medEspesificar'); 
                    }
                    else{ $medEspesificar = $historia->medEspesificar; }
                @endphp
                <label for="medEspesificar"><strong style="color: #000; font-size: 16px;">Especifique las alergias</strong></label>
                {!! Form::text('medEspesificar', $medEspesificar, array('id' => 'medEspesificar', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
        <script>    
            {{-- retuna checked true si esta en la base  --}}
            if('{{$medica->medEspesificar}}' != ''){
                $("#divEspecificar").show();
                
            }else{
                $("#divEspecificar").hide();
            }
        </script>

        {{--  otro   --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('medOtro') !== null){
                        $medOtro = old('medOtro'); 
                    }
                    else{ $medOtro = $historia->medOtro; }
                @endphp
                <label for="medOtro"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                {!! Form::text('medOtro', $medOtro, array('id' => 'medOtro', 'class' => 'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">General</p>
    </div>


    <div class="row">
        {{--  Cuenta con seguro de gastos médicos  --}}
        <div class="col s12 m6 l6">
            <label for="medGastoMedico"><strong style="color: #000; font-size: 16px;">Cuenta con seguro de gastos médicos</strong></label>
            <select id="medGastoMedico" class="browser-default" name="medGastoMedico" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                @php                                  
                    if(old('medGastoMedico') !== null){
                        $medGastoMedico = old('medGastoMedico'); 
                    }
                    else{ $medGastoMedico = $historia->medGastoMedico; }
                @endphp
                <option value="SI" {{ $medGastoMedico == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $medGastoMedico == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  Nombre de la aseguradora  --}}
        <div class="col s12 m6 l6" id="divAseguradora" style="display: none">
            <div class="input-field">
                @php                                  
                    if(old('medNombreAsegurador') !== null){
                        $medNombreAsegurador = old('medNombreAsegurador'); 
                    }
                    else{ $medNombreAsegurador = $historia->medNombreAsegurador; }
                @endphp
                <label for="medNombreAsegurador"><strong style="color: #000; font-size: 16px;">Nombre de la aseguradora</strong></label>
                {!! Form::text('medNombreAsegurador', $medNombreAsegurador, array('id' => 'medNombreAsegurador', 'class' =>
                'validate','maxlength'=>'200')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Cuenta con todas las vacunas correspondientes:  --}}
        <div class="col s12 m6 l6">
            <label for="medVacunas"><strong style="color: #000; font-size: 16px;">Cuenta con todas las vacunas correspondientes</strong></label>
            <select id="medVacunas" class="browser-default" name="medVacunas" style="width: 100%;">
                @php                                  
                    if(old('medVacunas') !== null){
                        $medVacunas = old('medVacunas'); 
                    }
                    else{ $medVacunas = $historia->medVacunas; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $medVacunas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $medVacunas == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  ¿Ha recibido algún tratamiento?  --}}
        <div class="col s12 m6 l6">
            <label for="medTramiento"><strong style="color: #000; font-size: 16px;">¿Ha recibido algún tratamiento?</strong></label>
            <select id="medTramiento" class="browser-default" name="medTramiento" style="width: 100%;">
                @php                                  
                    if(old('medTramiento') !== null){
                        $medTramiento = old('medTramiento'); 
                    }
                    else{ $medTramiento = $historia->medTramiento; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="NO" {{ $medTramiento == "NO" ? 'selected="selected"' : '' }}>NO</option>
                <option value="MÉDICO" {{ $medTramiento == "MÉDICO" ? 'selected="selected"' : '' }}>Médico</option>
                <option value="NEUROLÓGICO" {{ $medTramiento == "NEUROLÓGICO" ? 'selected="selected"' : '' }}>Neurológico</option>
                <option value="PSICOLÍGICO" {{ $medTramiento == "PSICOLÍGICO" ? 'selected="selected"' : '' }}>Psicológico</option>
            </select>
        </div>
    </div>

    {{--  Asiste o asistió en cierto momento a algún tipo de terapia  --}}
    <div class="row">
        <div class="col s12 m6 l6">
            <label for="medTerapia"><strong style="color: #000; font-size: 16px;">Asiste o asistió en cierto momento a algún tipo de terapia</strong></label>
            <select id="medTerapia" class="browser-default" name="medTerapia" style="width: 100%;">
                @php                                  
                    if(old('medTerapia') !== null){
                        $medTerapia = old('medTerapia'); 
                    }
                    else{ $medTerapia = $historia->medTerapia; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $medTerapia == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $medTerapia == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  ¿Por qué motivo la terapia?  --}}
        <div class="col s12 m6 l6" id="divTerapiaMotivo" style="display: none">
            <div class="input-field">
                @php                                  
                    if(old('medMotivoTerapia') !== null){
                        $medMotivoTerapia = old('medMotivoTerapia'); 
                    }
                    else{ $medMotivoTerapia = $historia->medMotivoTerapia; }
                @endphp
                <label for="medMotivoTerapia"><strong style="color: #000; font-size: 16px;">¿Por qué motivo?</strong></label>
                {!! Form::text('medMotivoTerapia', $medMotivoTerapia, array('id' => 'medMotivoTerapia', 'class' =>
                'validate')) !!}
            </div>
        </div>

       
    </div>

    <div class="row">
        {{--  Estado de salud física actual  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('medSaludFisicaAct') !== null){
                        $medSaludFisicaAct = old('medSaludFisicaAct'); 
                    }
                    else{ $medSaludFisicaAct = $historia->medSaludFisicaAct; }
                @endphp
                <label for="medSaludFisicaAct"><strong style="color: #000; font-size: 16px;">Estado de salud física actual</strong></label>
                {!! Form::text('medSaludFisicaAct', $medSaludFisicaAct, array('id' => 'medSaludFisicaAct', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
        {{--  Estado emocional actual  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('medSaludEmocialAct') !== null){
                        $medSaludEmocialAct = old('medSaludEmocialAct'); 
                    }
                    else{ $medSaludEmocialAct = $historia->medSaludEmocialAct; }
                @endphp
                <label for="medSaludEmocialAct"><strong style="color: #000; font-size: 16px;">Estado emocional actual</strong></label>
                {!! Form::text('medSaludEmocialAct', $medSaludEmocialAct, array('id' => 'medSaludEmocialAct', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <br>
</div> <!-- tutoresForm -->


<script>
    {{--  alergias  --}}
    $("input[name=medAlergias]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medAlergias").val("ALERGIAS");
    
        } else {
            $("#medAlergias").val("");
        }
    });

    {{--  Convulsiones  --}}
    $("input[name=medConvulsiones]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medConvulsiones").val("CONVULSIONES");
    
        } else {
            $("#medConvulsiones").val("");
        }
    });

    

    {{--  Problemas de audición  --}}
    $("input[name=medAudicion]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medAudicion").val("PROBLEMAS DE AUDICIÓN");
    
        } else {
            $("#medAudicion").val("");
        }
    });
    

    {{--  Fiebres altas  --}}
    $("input[name=medFiebres]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medFiebres").val("FIEBRES ALTAS");
    
        } else {
            $("#medFiebres").val("");
        }
    });

    {{--  Problemas de corazón  --}}
    $("input[name=medProblemasCorazon]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medProblemasCorazon").val("PROBLEMAS DE CORAZÓN");
    
        } else {
            $("#medProblemasCorazon").val("");
        }
    });

    {{--  Deficiencia pulmonar y bronquial  --}}
    $("input[name=medDeficiencia]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medDeficiencia").val("DEFICIENCIA PULMONAR Y BRONQUIAL");
    
        } else {
            $("#medDeficiencia").val("");
        }
    });

    {{--  Asma  --}}
    $("input[name=medAsma]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medAsma").val("ASMA");
    
        } else {
            $("#medAsma").val("");
        }
    });

    {{--  Diabetes  --}}
    $("input[name=medDiabetes]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medDiabetes").val("DIABETES");
    
        } else {
            $("#medDiabetes").val("");
        }
    });
    {{--  Problemas gastrointestinales  --}}
    $("input[name=medGastrointestinales]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medGastrointestinales").val("PROBLEMAS GASTROINTESTINALES");
    
        } else {
            $("#medGastrointestinales").val("");
        }
    });

    {{--  Accidentes   --}}
    $("input[name=medAccidentes]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medAccidentes").val("ACCIDENTES");
    
        } else {
            $("#medAccidentes").val("");
        }
    });

    {{--  Epilepsia  --}}
    $("input[name=medEpilepsia]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medEpilepsia").val("EPILEPSIA");
    
        } else {
            $("#medEpilepsia").val("");
        }
    });
    {{--  Problemas de riñón  --}}
    $("input[name=medRinion]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medRinion").val("PROBLEMAS DE RIÑON");
    
        } else {
            $("#medRinion").val("");
        }
    });

    {{--  Problemas de la piel  --}}
    $("input[name=medPiel]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medPiel").val("PROBLEMAS DE LA PIEL");
    
        } else {
            $("#medPiel").val("");
        }
    });
    {{--  Falta de coordinación motriz  --}}
    $("input[name=medCoordinacionMotriz]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medCoordinacionMotriz").val("FALTA DE COORDINACIÓN MOTRIZ");
    
        } else {
            $("#medCoordinacionMotriz").val("");
        }
    });
    {{--  Estreñimiento  --}}
    $("input[name=medEstrenimiento]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medEstrenimiento").val("ESTREÑIMIENTO");
    
        } else {
            $("#medEstrenimiento").val("");
        }
    });
    {{--  Dificultades durante el sueño  --}}
    $("input[name=medDificultadesSuenio]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medDificultadesSuenio").val("DIFICULTADES DURANTE EL SUEÑO");
    
        } else {
            $("#medDificultadesSuenio").val("");
        }
    });

    
$("input[name=medAlergias]").change(function(){
    if ($(this).is(':checked') ) {
        
        $("#divEspecificar").show();
        $("#medEspesificar").attr('required', '');     


    } else {
        $("#divEspecificar").hide();
        $("#medEspesificar").removeAttr('required');
        $("#medEspesificar").val("");
    }
});

$("select[name=medGastoMedico]").change(function(){
    if($('select[name=medGastoMedico]').val() == "SI"){
        $("#divAseguradora").show(); 
        $("#medNombreAsegurador").attr('required', '');     
       
    }else{
        $("#medNombreAsegurador").removeAttr('required');
        $("#divAseguradora").hide();   
        $("#medNombreAsegurador").val("");      

    }
});

$("select[name=medTerapia]").change(function(){
    if($('select[name=medTerapia]').val() == "SI"){
        $("#divTerapiaMotivo").show(); 
        $("#medMotivoTerapia").attr('required', '');     
       
    }else{
        $("#medMotivoTerapia").removeAttr('required');
        $("#divTerapiaMotivo").hide();         

    }
});

if($('select[name=medGastoMedico]').val() == "SI"){
    $("#divAseguradora").show(); 
    $("#medNombreAsegurador").attr('required', '');
}else{
    $("#medNombreAsegurador").removeAttr('required');
    $("#divAseguradora").hide();         
}


if($('select[name=medTerapia]').val() == "SI"){
    $("#divTerapiaMotivo").show(); 
    $("#medMotivoTerapia").attr('required', '');
}else{
    $("#medMotivoTerapia").removeAttr('required');
    $("#divTerapiaMotivo").hide();         
}
</script>