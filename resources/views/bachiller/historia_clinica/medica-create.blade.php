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
                <label for="medIntervencionQuirurgicas"><strong style="color: #000; font-size: 16px;">Intervenciones quirúrgicas</strong></label>
                {!! Form::text('medIntervencionQuirurgicas', old('medIntervencionQuirurgicas'), array('id' => 'medIntervencionQuirurgicas', 'class'
                =>
                'validate','required','maxlength'=>'4000')) !!}
            </div>
        </div>
        {{--  Tratamientos/ medicamentos  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="medMedicamentos"><strong style="color: #000; font-size: 16px;">Tratamientos/ medicamentos</strong></label>
                {!! Form::text('medMedicamentos', old('medMedicamentos'), array('id' => 'medMedicamentos', 'class' =>
                'validate','maxlength'=>'4000')) !!}
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
        
        {{--  Problemas de audición  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medAudicion" id="medAudicion" value="" {{ (! empty(old('medAudicion')) ? 'checked' : '') }}>
                <label for="medAudicion"><strong style="color: #000; font-size: 16px;">Problemas de audición</strong></label>
            </div>
        </div> 

        {{--  Fiebres altas  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medFiebres" id="medFiebres" value="" {{ (! empty(old('medFiebres')) ? 'checked' : '') }}>
                <label for="medFiebres"><strong style="color: #000; font-size: 16px;">Fiebres altas</strong></label>
            </div>
        </div>


        {{--  Problemas de corazón  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medProblemasCorazon" id="medProblemasCorazon" value="" {{ (! empty(old('medProblemasCorazon')) ? 'checked' : '') }}>
                <label for="medProblemasCorazon"><strong style="color: #000; font-size: 16px;">Problemas de corazón</strong></label>
            </div>
        </div>

    </div>


    <div class="row">
        {{--  Deficiencia pulmonar y bronquial  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medDeficiencia" id="medDeficiencia" value="" {{ (! empty(old('medDeficiencia')) ? 'checked' : '') }}>
                <label for="medDeficiencia"><strong style="color: #000; font-size: 16px;">Deficiencia pulmonar y bronquial</strong></label>
            </div>
        </div>
     
        {{--  Asma  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medAsma" id="medAsma" value="" {{ (! empty(old('medAsma')) ? 'checked' : '') }}>
                <label for="medAsma"><strong style="color: #000; font-size: 16px;">Asma</strong></label>
            </div>
        </div>
          {{--  Diabetes  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medDiabetes" id="medDiabetes" value="" {{ (! empty(old('medDiabetes')) ? 'checked' : '') }}>
                <label for="medDiabetes"><strong style="color: #000; font-size: 16px;">Diabetes</strong></label>
            </div>
        </div>

        {{--  Problemas gastrointestinales  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medGastrointestinales" id="medGastrointestinales" value=""{{ (! empty(old('medGastrointestinales')) ? 'checked' : '') }}>
                <label for="medGastrointestinales"><strong style="color: #000; font-size: 16px;">Problemas gastrointestinales</strong></label>
            </div>
        </div> 
    </div>


    <div class="row">
        {{--  Accidentes  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medAccidentes" id="medAccidentes" value="" {{ (! empty(old('medAccidentes')) ? 'checked' : '') }}>
                <label for="medAccidentes"><strong style="color: #000; font-size: 16px;">Accidentes</strong></label>
            </div>
        </div>
       
        {{--  Epilepsia  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medEpilepsia" id="medEpilepsia" value="" {{ (! empty(old('medEpilepsia')) ? 'checked' : '') }}>
                <label for="medEpilepsia"><strong style="color: #000; font-size: 16px;">Epilepsia</strong></label>
            </div>
        </div>
             {{--  Problemas de riñón  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medRinion" id="medRinion" value="" {{ (! empty(old('medRinion')) ? 'checked' : '') }}>
                <label for="medRinion"><strong style="color: #000; font-size: 16px;">Problemas de riñón</strong></label>
            </div>
        </div>
    
        {{--  Problemas de la piel  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medPiel" id="medPiel" value="" {{ (! empty(old('medPiel')) ? 'checked' : '') }}>
                <label for="medPiel"><strong style="color: #000; font-size: 16px;">Problemas de la piel</strong></label>
            </div>
        </div>     
    </div>

    <div class="row">
        {{--  Falta de coordinación motriz  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medCoordinacionMotriz" id="medCoordinacionMotriz" value="" {{ (! empty(old('medCoordinacionMotriz')) ? 'checked' : '') }}>
                <label for="medCoordinacionMotriz"><strong style="color: #000; font-size: 16px;">Falta de coordinación motriz</strong></label>
            </div>
        </div>
       
        {{--  Estreñimiento  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medEstrenimiento" id="medEstrenimiento" value="" {{ (! empty(old('medEstrenimiento')) ? 'checked' : '') }}>
                <label for="medEstrenimiento"><strong style="color: #000; font-size: 16px;">Estreñimiento</strong></label>
            </div>
        </div>
        
        {{--  Dificultades durante el sueño  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medDificultadesSuenio" id="medDificultadesSuenio" value="" {{ (! empty(old('medDificultadesSuenio')) ? 'checked' : '') }}>
                <label for="medDificultadesSuenio"><strong style="color: #000; font-size: 16px;"> Dificultades durante el sueño</strong></label>
            </div>
        </div>
           {{--  Alergias  --}}
        <div class="col s12 m6 l3" style="margin-top:5px;">
            <div style="position:relative;">
                <input type="checkbox" name="medAlergias" id="medAlergias" value="" {{ (! empty(old('medAlergias')) ? 'checked' : '') }}>
                <label for="medAlergias"><strong style="color: #000; font-size: 16px;">Alergias</strong></label>
            </div>
        </div>
       </div>

    <div class="row">
        {{--  campo para especificar alergias   --}}
        <div class="col s12 m6 l6" id="divEspecificar" style="display: none">
            <div class="input-field">
                <label for="medEspesificar"><strong style="color: #000; font-size: 16px;">Especifique las alergias</strong></label>
                {!! Form::text('medEspesificar', old('medEspesificar'), array('id' => 'medEspesificar', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
            {{--  otro   --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="medOtro"><strong style="color: #000; font-size: 16px;">Otro</strong></label>
                {!! Form::text('medOtro', old('medOtro'), array('id' => 'medOtro', 'class' =>
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
            <label for="medGastoMedico"><strong style="color: #000; font-size: 16px;">Cuenta con seguro de gastos médicos</strong></label>
            <select id="medGastoMedico" class="browser-default" name="medGastoMedico" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('medGastoMedico') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('medGastoMedico') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>

        {{--  Nombre de la aseguradora  --}}
        <div class="col s12 m6 l6" id="divAseguradora" style="display: none">
            <div class="input-field">
                <label for="medNombreAsegurador"><strong style="color: #000; font-size: 16px;">Nombre de la aseguradora</strong></label>
                {!! Form::text('medNombreAsegurador', old('medNombreAsegurador'), array('id' => 'medNombreAsegurador', 'class' =>
                'validate','maxlength'=>'200')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  Cuenta con todas las vacunas correspondientes:  --}}
        <div class="col s12 m6 l6">
            <label for="medVacunas"><strong style="color: #000; font-size: 16px;">Cuenta con todas las vacunas correspondientes</strong></label>
            <select id="medVacunas" class="browser-default" name="medVacunas" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('medVacunas') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('medVacunas') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>

        {{--  ¿Ha recibido algún tratamiento?  --}}
        <div class="col s12 m6 l6">
            <label for="medTramiento"><strong style="color: #000; font-size: 16px;">¿Ha recibido algún tratamiento?</strong></label>
            <select id="medTramiento" class="browser-default" name="medTramiento" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="NO" {{ old('medTramiento') == "NO" ? 'selected' : '' }}>No</option>
                <option value="MÉDICO" {{ old('medTramiento') == "MÉDICO" ? 'selected' : '' }}>Médico</option>
                <option value="NEUROLÓGICO" {{ old('medTramiento') == "NEUROLÓGICO" ? 'selected' : '' }}>Neurológico</option>
                <option value="PSICOLÍGICO" {{ old('medTramiento') == "PSICOLÍGICO" ? 'selected' : '' }}>Psicológico</option>
            </select>
        </div>
    </div>

    {{--  Asiste o asistió en cierto momento a algún tipo de terapia  --}}
    <div class="row">
        <div class="col s12 m6 l6">
            <label for="medTerapia"><strong style="color: #000; font-size: 16px;">Asiste o asistió en cierto momento a algún tipo de terapia</strong></label>
            <select id="medTerapia" class="browser-default" name="medTerapia" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('medTerapia') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('medTerapia') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>

        {{--  ¿Por qué motivo la terapia?  --}}
        <div class="col s12 m6 l6" id="divTerapiaMotivo" style="display: none">
            <div class="input-field">
                <label for="medMotivoTerapia"><strong style="color: #000; font-size: 16px;">¿Por qué motivo?</strong></label>
                {!! Form::text('medMotivoTerapia', old('medMotivoTerapia'), array('id' => 'medMotivoTerapia', 'class' =>
                'validate')) !!}
            </div>
        </div>

       
    </div>

    <div class="row">
        {{--  Estado de salud física actual  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="medSaludFisicaAct"><strong style="color: #000; font-size: 16px;">Estado de salud física actual</strong></label>
                {!! Form::text('medSaludFisicaAct', old('medSaludFisicaAct'), array('id' => 'medSaludFisicaAct', 'class' =>
                'validate','maxlength'=>'255', 'required')) !!}
            </div>
        </div>
        {{--  Estado emocional actual  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="medSaludEmocialAct"><strong style="color: #000; font-size: 16px;">Estado emocional actual</strong></label>
                {!! Form::text('medSaludEmocialAct', old('medSaludEmocialAct'), array('id' => 'medSaludEmocialAct', 'class' =>
                'validate','maxlength'=>'255', 'required')) !!}
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

    if($('#medAlergias').prop('checked') ) {
        $("#medAlergias").val("ALERGIAS");
    }else{
        $("#medAlergias").val("");
    }

    {{--  Convulsiones  --}}
    $("input[name=medConvulsiones]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medConvulsiones").val("CONVULSIONES");
    
        } else {
            $("#medConvulsiones").val("");
        }
    });

    if($('#medConvulsiones').prop('checked') ) {
        $("#medConvulsiones").val("CONVULSIONES");
    }else{
        $("#medConvulsiones").val("");
    }

    

    {{--  Problemas de audición  --}}
    $("input[name=medAudicion]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medAudicion").val("PROBLEMAS DE AUDICIÓN");
    
        } else {
            $("#medAudicion").val("");
        }
    });
    if($('#medAudicion').prop('checked') ) {
        $("#medAudicion").val("PROBLEMAS DE AUDICIÓN");
    }else{
        $("#medAudicion").val("");
    }
    

    {{--  Fiebres altas  --}}
    $("input[name=medFiebres]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medFiebres").val("FIEBRES ALTAS");
    
        } else {
            $("#medFiebres").val("");
        }
    });
    if($('#medFiebres').prop('checked') ) {
        $("#medFiebres").val("FIEBRES ALTAS");
    }else{
        $("#medFiebres").val("");
    }

    {{--  Problemas de corazón  --}}
    $("input[name=medProblemasCorazon]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medProblemasCorazon").val("PROBLEMAS DE CORAZÓN");
    
        } else {
            $("#medProblemasCorazon").val("");
        }
    });
    if($('#medProblemasCorazon').prop('checked') ) {
        $("#medProblemasCorazon").val("PROBLEMAS DE CORAZÓN");
    }else{
        $("#medProblemasCorazon").val("");
    }

    {{--  Deficiencia pulmonar y bronquial  --}}
    $("input[name=medDeficiencia]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medDeficiencia").val("DEFICIENCIA PULMONAR Y BRONQUIAL");
    
        } else {
            $("#medDeficiencia").val("");
        }
    });
    if($('#medDeficiencia').prop('checked') ) {
        $("#medDeficiencia").val("DEFICIENCIA PULMONAR Y BRONQUIAL");
    }else{
        $("#medDeficiencia").val("");
    }

    {{--  Asma  --}}
    $("input[name=medAsma]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medAsma").val("ASMA");
    
        } else {
            $("#medAsma").val("");
        }
    });
    if($('#medAsma').prop('checked') ) {
        $("#medAsma").val("ASMA");
    }else{
        $("#medAsma").val("");
    }

    {{--  Diabetes  --}}
    $("input[name=medDiabetes]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medDiabetes").val("DIABETES");
    
        } else {
            $("#medDiabetes").val("");
        }
    });
    if($('#medDiabetes').prop('checked') ) {
        $("#medDiabetes").val("DIABETES");
    }else{
        $("#medDiabetes").val("");
    }
    {{--  Problemas gastrointestinales  --}}
    $("input[name=medGastrointestinales]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medGastrointestinales").val("PROBLEMAS GASTROINTESTINALES");
    
        } else {
            $("#medGastrointestinales").val("");
        }
    });
    if($('#medGastrointestinales').prop('checked') ) {
        $("#medGastrointestinales").val("PROBLEMAS GASTROINTESTINALES");
    }else{
        $("#medGastrointestinales").val("");
    }

    {{--  Accidentes   --}}
    $("input[name=medAccidentes]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medAccidentes").val("ACCIDENTES");
    
        } else {
            $("#medAccidentes").val("");
        }
    });
    if($('#medAccidentes').prop('checked') ) {
        $("#medAccidentes").val("ACCIDENTES");
    }else{
        $("#medAccidentes").val("");
    }

    {{--  Epilepsia  --}}
    $("input[name=medEpilepsia]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medEpilepsia").val("EPILEPSIA");
    
        } else {
            $("#medEpilepsia").val("");
        }
    });
    if($('#medEpilepsia').prop('checked') ) {
        $("#medEpilepsia").val("EPILEPSIA");
    }else{
        $("#medEpilepsia").val("");
    }

    {{--  Problemas de riñón  --}}
    $("input[name=medRinion]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medRinion").val("PROBLEMAS DE RIÑON");
    
        } else {
            $("#medRinion").val("");
        }
    });
    if($('#medRinion').prop('checked') ) {
        $("#medRinion").val("PROBLEMAS DE RIÑON");
    }else{
        $("#medRinion").val("");
    }

    {{--  Problemas de la piel  --}}
    $("input[name=medPiel]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medPiel").val("PROBLEMAS DE LA PIEL");
    
        } else {
            $("#medPiel").val("");
        }
    });
    if($('#medPiel').prop('checked') ) {
        $("#medPiel").val("PROBLEMAS DE LA PIEL");
    }else{
        $("#medPiel").val("");
    }


    {{--  Falta de coordinación motriz  --}}
    $("input[name=medCoordinacionMotriz]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medCoordinacionMotriz").val("FALTA DE COORDINACIÓN MOTRIZ");
    
        } else {
            $("#medCoordinacionMotriz").val("");
        }
    });
    if($('#medCoordinacionMotriz').prop('checked') ) {
        $("#medCoordinacionMotriz").val("FALTA DE COORDINACIÓN MOTRIZ");
    }else{
        $("#medCoordinacionMotriz").val("");
    }


    {{--  Estreñimiento  --}}
    $("input[name=medEstrenimiento]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medEstrenimiento").val("ESTREÑIMIENTO");
    
        } else {
            $("#medEstrenimiento").val("");
        }
    });
    if($('#medEstrenimiento').prop('checked') ) {
        $("#medEstrenimiento").val("ESTREÑIMIENTO");
    }else{
        $("#medEstrenimiento").val("");
    }


    {{--  Dificultades durante el sueño  --}}
    $("input[name=medDificultadesSuenio]").change(function(){
        if ($(this).is(':checked') ) {
     
            $("#medDificultadesSuenio").val("DIFICULTADES DURANTE EL SUEÑO");
    
        } else {
            $("#medDificultadesSuenio").val("");
        }
    });
    if($('#medDificultadesSuenio').prop('checked') ) {
        $("#medDificultadesSuenio").val("DIFICULTADES DURANTE EL SUEÑO");
    }else{
        $("#medDificultadesSuenio").val("");
    }

    
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

if($('#medAlergias').prop('checked') ) {
    $("#divEspecificar").show();
    $("#medEspesificar").attr('required', '');   
}else{
    $("#divEspecificar").hide();
    $("#medEspesificar").removeAttr('required');
    $("#medEspesificar").val("");
}


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
if($('#medTerapia').prop('checked') ) {
    $("#divTerapiaMotivo").show(); 
        $("#medMotivoTerapia").attr('required', '');     
}else{
    $("#medMotivoTerapia").removeAttr('required');
        $("#divTerapiaMotivo").hide();      
}





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