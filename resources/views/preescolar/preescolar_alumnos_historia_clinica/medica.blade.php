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
                {!! Form::label('medIntervencionQuirurgicas', 'Intervenciones quirúrgicas', array('class' => '')); !!}
                {!! Form::text('medIntervencionQuirurgicas', $medica->medIntervencionQuirurgicas, array('id' => 'medIntervencionQuirurgicas', 'class' => 'validate','maxlength'=>'255')) !!}
            </div>
        </div>
        {{--  Tratamientos/ medicamentos  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('medMedicamentos', 'Tratamientos/ medicamentos', array('class' => '')); !!}
                {!! Form::text('medMedicamentos', $medica->medMedicamentos, array('id' => 'medMedicamentos', 'class' =>
                'validate')) !!}
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
                <input type="checkbox" name="medConvulsiones" id="medConvulsiones" value="">
                <label for="medConvulsiones"> Convulsiones</label>
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
                <input type="checkbox" name="medAudicion" id="medAudicion" value="">
                <label for="medAudicion"> Problemas de audición</label>
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
                <input type="checkbox" name="medFiebres" id="medFiebres" value="">
                <label for="medFiebres"> Fiebres altas</label>
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
                <input type="checkbox" name="medProblemasCorazon" id="medProblemasCorazon" value="">
                <label for="medProblemasCorazon"> Problemas de corazón</label>
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
                <input type="checkbox" name="medDeficiencia" id="medDeficiencia" value="">
                <label for="medDeficiencia"> Deficiencia pulmonar y bronquial</label>
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
                <input type="checkbox" name="medAsma" id="medAsma" value="">
                <label for="medAsma"> Asma</label>
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
                <input type="checkbox" name="medDiabetes" id="medDiabetes" value="">
                <label for="medDiabetes"> Diabetes</label>
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
                <input type="checkbox" name="medGastrointestinales" id="medGastrointestinales" value="">
                <label for="medGastrointestinales"> Problemas gastrointestinales</label>
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
                <input type="checkbox" name="medAccidentes" id="medAccidentes" value="">
                <label for="medAccidentes"> Accidentes</label>
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
                <input type="checkbox" name="medEpilepsia" id="medEpilepsia" value="">
                <label for="medEpilepsia"> Epilepsia</label>
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
                <input type="checkbox" name="medRinion" id="medRinion" value="">
                <label for="medRinion"> Problemas de riñón</label>
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
                <input type="checkbox" name="medPiel" id="medPiel" value="">
                <label for="medPiel"> Problemas de la piel</label>
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
                <input type="checkbox" name="medCoordinacionMotriz" id="medCoordinacionMotriz" value="">
                <label for="medCoordinacionMotriz"> Falta de coordinación motriz</label>
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
                <input type="checkbox" name="medEstrenimiento" id="medEstrenimiento" value="">
                <label for="medEstrenimiento"> Estreñimiento</label>
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
                <input type="checkbox" name="medDificultadesSuenio" id="medDificultadesSuenio" value="">
                <label for="medDificultadesSuenio"> Dificultades durante el sueño</label>
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
                <input type="checkbox" name="medAlergias" id="medAlergias" value="">
                <label for="medAlergias"> Alergias</label>
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
                {!! Form::label('medEspesificar', 'Especifique las alergias', array('class' => '')); !!}
                {!! Form::text('medEspesificar', $medica->medEspesificar, array('id' => 'medEspesificar', 'class' =>
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
                {!! Form::label('medOtro', 'Otro', array('class' => '')); !!}
                {!! Form::text('medOtro', $medica->medOtro, array('id' => 'medOtro', 'class' =>
                'validate','maxlength'=>'255')) !!}
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
            {!! Form::label('medGastoMedico', 'Cuenta con seguro de gastos médicos', array('class' => '')); !!}
            <select id="medGastoMedico" class="browser-default" name="medGastoMedico" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $medica->medGastoMedico == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $medica->medGastoMedico == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  Nombre de la aseguradora  --}}
        <div class="col s12 m6 l6" id="divAseguradora" style="display: none">
            <div class="input-field">
                {!! Form::label('medNombreAsegurador', 'Nombre de la aseguradora', array('class' => '')); !!}
                {!! Form::text('medNombreAsegurador', $medica->medNombreAsegurador, array('id' => 'medNombreAsegurador', 'class' =>
                'validate','maxlength'=>'200')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Cuenta con todas las vacunas correspondientes:  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('medVacunas', 'Cuenta con todas las vacunas correspondientes', array('class' => '')); !!}
            <select id="medVacunas" class="browser-default" name="medVacunas" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $medica->medVacunas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $medica->medVacunas == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  ¿Ha recibido algún tratamiento?  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('medTramiento', '¿Ha recibido algún tratamiento?',
            array('class' =>
            '')); !!}
            <select id="medTramiento" class="browser-default" name="medTramiento" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="NO" {{ $medica->medTramiento == "NO" ? 'selected="selected"' : '' }}>No</option>
                <option value="MÉDICO" {{ $medica->medTramiento == "MÉDICO" ? 'selected="selected"' : '' }}>Médico</option>
                <option value="NEUROLÓGICO" {{ $medica->medTramiento == "NEUROLÓGICO" ? 'selected="selected"' : '' }}>Neurológico</option>
                <option value="PSICOLÍGICO" {{ $medica->medTramiento == "PSICOLÍGICO" ? 'selected="selected"' : '' }}>Psicológico</option>
            </select>
        </div>
    </div>

    {{--  Asiste o asistió en cierto momento a algún tipo de terapia  --}}
    <div class="row">
        <div class="col s12 m6 l6">
            {!! Form::label('medTerapia', 'Asiste o asistió en cierto momento a algún tipo de terapia', array('class' =>'')); !!}
            <select id="medTerapia" class="browser-default" name="medTerapia" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $medica->medTerapia == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $medica->medTerapia == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  ¿Por qué motivo la terapia?  --}}
        <div class="col s12 m6 l6" id="divTerapiaMotivo" style="display: none">
            <div class="input-field">
                {!! Form::label('medMotivoTerapia', '¿Por qué motivo?', array('class' => '')); !!}
                {!! Form::text('medMotivoTerapia', $medica->medMotivoTerapia, array('id' => 'medMotivoTerapia', 'class' =>
                'validate')) !!}
            </div>
        </div>

       
    </div>

    <div class="row">
        {{--  Estado de salud física actual  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('medSaludFisicaAct', 'Estado de salud física actual', array('class' => '')); !!}
                {!! Form::text('medSaludFisicaAct', $medica->medSaludFisicaAct, array('id' => 'medSaludFisicaAct', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
        {{--  Estado emocional actual  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('medSaludEmocialAct', 'Estado emocional actual', array('class' => '')); !!}
                {!! Form::text('medSaludEmocialAct', $medica->medSaludEmocialAct, array('id' => 'medSaludEmocialAct', 'class' =>
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

    } else {
        $("#divEspecificar").hide();
    }
});

$("select[name=medGastoMedico]").change(function(){
    if($('select[name=medGastoMedico]').val() == "SI"){
        $("#divAseguradora").show(); 
        $("#medNombreAsegurador").prop('required', false);
       
    }else{
        $("#medNombreAsegurador").prop('required', false);
        $("#divAseguradora").hide();   
        $("#medNombreAsegurador").val("");      

    }
});

$("select[name=medTerapia]").change(function(){
    if($('select[name=medTerapia]').val() == "SI"){
        $("#divTerapiaMotivo").show(); 
        $("#medMotivoTerapia").prop('required', false);

       
    }else{
        $("#medMotivoTerapia").prop('required', false);
        $("#divTerapiaMotivo").hide();         

    }
});

if($('select[name=medGastoMedico]').val() == "SI"){
    $("#divAseguradora").show(); 
    $("#medNombreAsegurador").prop('required', false);

}else{
    $("#medNombreAsegurador").prop('required', false);
    $("#divAseguradora").hide();         
}


if($('select[name=medTerapia]').val() == "SI"){
    $("#divTerapiaMotivo").show(); 
    $("#medMotivoTerapia").prop('required', false);

}else{
    $("#medMotivoTerapia").prop('required', false);
    $("#divTerapiaMotivo").hide();         
}
</script>