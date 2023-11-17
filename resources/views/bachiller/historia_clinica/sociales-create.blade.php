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
                <label for="socAmigos"><strong style="color: #000; font-size: 16px;">¿Hace amigos con facilidad? (comunicativo, poco comunicativo, participa en grupo)</strong></label>
                {!! Form::text('socAmigos', old('socAmigos'), array('id' => 'socAmigos', 'class' =>
                'validate','maxlength'=>'150', 'required')) !!}
            </div>
        </div>

        {{--  ¿Qué actitud asume en el juego?  --}}
        <div class="col s12 m6 l6">
            <label for="socActitud"><strong style="color: #000; font-size: 16px;">¿Qué actitud asume en el juego?</strong></label>
            <select id="socActitud" class="browser-default" name="socActitud" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="LÍDER" {{ old('socActitud') == "LÍDER" ? 'selected' : '' }}>Líder</option>
                <option value="COLABORADOR" {{ old('socActitud') == "COLABORADOR" ? 'selected' : '' }}>Colaborador</option>
                <option value="TENDENCIA A AISLARSE" {{ old('socActitud') == "TENDENCIA A AISLARSE" ? 'selected' : '' }}>Tendencia a aislarse</option>
                <option value="AGRESIVO" {{ old('socActitud') == "AGRESIVO" ? 'selected' : '' }}>Agresivo</option>
            </select>
        </div>
    </div>

    <div class="row">
        {{--  ¿Tiene oportunidad de jugar con niños de su edad?  --}}
        <div class="col s12 m6 l6">
            <label for="socNinioEdad"><strong style="color: #000; font-size: 16px;">¿Tiene oportunidad de jugar con niños de su edad?</strong></label>
            <select id="socNinioEdad" class="browser-default" name="socNinioEdad" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('socNinioEdad') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('socNinioEdad') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  Razón  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="socNinioRazon"><strong style="color: #000; font-size: 16px;">Razón</strong></label>
                {!! Form::text('socNinioRazon', old('socNinioRazon'), array('id' => 'socNinioRazon', 'class' => 'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  ¿Realiza alguna actividad extraescolar?  --}}
        <div class="col s12 m6 l6">
            <label for="socActividadExtraescolar"><strong style="color: #000; font-size: 16px;">¿Realiza alguna actividad extraescolar?</strong></label>
            <select id="socActividadExtraescolar" class="browser-default" name="socActividadExtraescolar" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('socActividadExtraescolar') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('socActividadExtraescolar') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  Razón  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="socActividadRazon"><strong style="color: #000; font-size: 16px;">¿Cúal?</strong></label>
                {!! Form::text('socActividadRazon', old('socActividadRazon'), array('id' => 'socActividadRazon', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  ¿Tiene dificultades para separarse de sus padres?  --}}
        <div class="col s12 m6 l6">
            <label for="socSeparacion"><strong style="color: #000; font-size: 16px;">¿Tiene dificultades para separarse de sus padres?</strong></label>
            <select id="socSeparacion" class="browser-default" name="socSeparacion" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('socSeparacion') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('socSeparacion') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{-- Razón --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="socSeparacionRazon"><strong style="color: #000; font-size: 16px;">¿Cúal?</strong></label>
                {!! Form::text('socSeparacionRazon',  old('socSeparacionRazon'), array('id' => 'socSeparacionRazon', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        
        {{--  ¿Cómo se lleva con los miembros de la familia?  --}}
                <div class="col s12 m6 l12">
            <div class="input-field">
                <label for="socRelacionFamilia"><strong style="color: #000; font-size: 16px;">¿Cómo se lleva con los miembros de la familia?</strong></label>
                {!! Form::text('socRelacionFamilia', old('socRelacionFamilia'), array('id' => 'socRelacionFamilia', 'class' =>
                'validate','maxlength'=>'80', 'required')) !!}
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