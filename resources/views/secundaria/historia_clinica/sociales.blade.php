<div id="social">
    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">RELACIONES SOCIALES </p>
    </div>
    <br>
    <div class="row">
               {{--  ¿Hace amigos con facilidad?   --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('socAmigos') !== null){
                        $socAmigos = old('socAmigos'); 
                    }
                    else{ $socAmigos = $social->socAmigos; }
                @endphp
                <label for="socAmigos"><strong style="color: #000; font-size: 16px;">¿Hace amigos con facilidad? (comunicativo, poco comunicativo, participa en grupo)</strong></label>
                {!! Form::text('socAmigos', $socAmigos, array('id' => 'socAmigos', 'class' =>
                'validate','maxlength'=>'150')) !!}
            </div>
        </div>

        {{--  ¿Qué actitud asume en el juego?  --}}
        <div class="col s12 m6 l6">
            <label for="socActitud"><strong style="color: #000; font-size: 16px;">¿Qué actitud asume en el juego?</strong></label>
            <select id="socActitud" class="browser-default" name="socActitud" style="width: 100%;">
                @php                                  
                    if(old('socActitud') !== null){
                        $socActitud = old('socActitud'); 
                    }
                    else{ $socActitud = $social->socActitud; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="LÍDER" {{ $socActitud == "LÍDER" ? 'selected="selected"' : '' }}>Líder</option>
                <option value="COLABORADOR" {{ $socActitud == "COLABORADOR" ? 'selected="selected"' : '' }}>Colaborador</option>
                <option value="TENDENCIA A AISLARSE" {{ $socActitud == "TENDENCIA A AISLARSE" ? 'selected="selected"' : '' }}>Tendencia a aislarse</option>
                <option value="AGRESIVO" {{ $socActitud == "AGRESIVO" ? 'selected="selected"' : '' }}>Agresivo</option>
            </select>
        </div>
    </div>

    <div class="row">
        {{--  ¿Tiene oportunidad de jugar con niños de su edad?  --}}
        <div class="col s12 m6 l6">
            <label for="socNinioEdad"><strong style="color: #000; font-size: 16px;">¿Tiene oportunidad de jugar con niños de su edad?</strong></label>
            <select id="socNinioEdad" class="browser-default" name="socNinioEdad" style="width: 100%;">
                @php                                  
                    if(old('socNinioEdad') !== null){
                        $socNinioEdad = old('socNinioEdad'); 
                    }
                    else{ $socNinioEdad = $social->socNinioEdad; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $socNinioEdad == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $socNinioEdad == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Razón  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('socNinioRazon') !== null){
                        $socNinioRazon = old('socNinioRazon'); 
                    }
                    else{ $socNinioRazon = $social->socNinioRazon; }
                @endphp
                <label for="socNinioRazon"><strong style="color: #000; font-size: 16px;">Razón</strong></label>
                {!! Form::text('socNinioRazon', $socNinioRazon, array('id' => 'socNinioRazon', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  ¿Realiza alguna actividad extraescolar?  --}}
        <div class="col s12 m6 l6">
            <label for="socActividadExtraescolar"><strong style="color: #000; font-size: 16px;">¿Realiza alguna actividad extraescolar?</strong></label>
            <select id="socActividadExtraescolar" class="browser-default" name="socActividadExtraescolar" style="width: 100%;">
                @php                                  
                    if(old('socActividadExtraescolar') !== null){
                        $socActividadExtraescolar = old('socActividadExtraescolar'); 
                    }
                    else{ $socActividadExtraescolar = $social->socActividadExtraescolar; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $socActividadExtraescolar == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $socActividadExtraescolar == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Razón  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('socActividadRazon') !== null){
                        $socActividadRazon = old('socActividadRazon'); 
                    }
                    else{ $socActividadRazon = $social->socActividadRazon; }
                @endphp
                <label for="socActividadRazon"><strong style="color: #000; font-size: 16px;">¿Cúal?</strong></label>
                {!! Form::text('socActividadRazon', $socActividadRazon, array('id' => 'socActividadRazon', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  ¿Tiene dificultades para separarse de sus padres?  --}}
        <div class="col s12 m6 l6">
            <label for="socSeparacion"><strong style="color: #000; font-size: 16px;">¿Tiene dificultades para separarse de sus padres?</strong></label>
            <select id="socSeparacion" class="browser-default" name="socSeparacion" style="width: 100%;">
                @php                                  
                    if(old('socSeparacion') !== null){
                        $socSeparacion = old('socSeparacion'); 
                    }
                    else{ $socSeparacion = $social->socSeparacion; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $socSeparacion == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $socSeparacion == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{-- Razón --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('socSeparacionRazon') !== null){
                        $socSeparacionRazon = old('socSeparacionRazon'); 
                    }
                    else{ $socSeparacionRazon = $social->socSeparacionRazon; }
                @endphp
                <label for="socSeparacionRazon"><strong style="color: #000; font-size: 16px;">¿Cúal?</strong></label>
                {!! Form::text('socSeparacionRazon',  $socSeparacionRazon, array('id' => 'socSeparacionRazon', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">        
        {{--  ¿Cómo se lleva con los miembros de la familia?  --}}
        <div class="col s12 m6 l12">
            <div class="input-field">
                @php                                  
                    if(old('socRelacionFamilia') !== null){
                        $socRelacionFamilia = old('socRelacionFamilia'); 
                    }
                    else{ $socRelacionFamilia = $social->socRelacionFamilia; }
                @endphp
                <label for="socRelacionFamilia"><strong style="color: #000; font-size: 16px;">¿Cómo se lleva con los miembros de la familia?</strong></label>
                {!! Form::text('socRelacionFamilia', $socRelacionFamilia, array('id' => 'socRelacionFamilia', 'class' =>
                'validate','maxlength'=>'80')) !!}
            </div>
        </div>
    </div>

    <br>
</div> 

<script>
    $("select[name=socNinioEdad]").change(function(){
        if($('select[name=socNinioEdad]').val() == "SI"){
            $("#socNinioRazon").attr('required', '');     
           
        }else{
            $("#socNinioRazon").removeAttr('required');
    
        }
    });

    {{--  socActividadExtraescolar  --}}
    $("select[name=socActividadExtraescolar]").change(function(){
        if($('select[name=socActividadExtraescolar]').val() == "SI"){
            $("#socActividadRazon").attr('required', '');     
           
        }else{
            $("#socActividadRazon").removeAttr('required');
    
        }
    });

    {{--  socSeparacion  --}}
    $("select[name=socSeparacion]").change(function(){
        if($('select[name=socSeparacion]').val() == "SI"){
            $("#socSeparacionRazon").attr('required', '');     
           
        }else{
            $("#socSeparacionRazon").removeAttr('required');
    
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