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
                {!! Form::label('socAmigos', '¿Hace amigos con facilidad? (comunicativo, poco comunicativo, participa en grupo)', array('class' => '')); !!}
                {!! Form::text('socAmigos', $social->socAmigos, array('id' => 'socAmigos', 'class' => 'validate','maxlength'=>'150')) !!}
            </div>
        </div>

        {{--  ¿Qué actitud asume en el juego?  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('socActitud', '¿Qué actitud asume en el juego?', array('class' => '')); !!}
            <select id="socActitud" class="browser-default" name="socActitud" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="LÍDER" {{ $social->socActitud == "LÍDER" ? 'selected="selected"' : '' }}>Líder</option>
                <option value="COLABORADOR" {{ $social->socActitud == "COLABORADOR" ? 'selected="selected"' : '' }}>Colaborador</option>
                <option value="TENDENCIA A AISLARSE" {{ $social->socActitud == "TENDENCIA A AISLARSE" ? 'selected="selected"' : '' }}>Tendencia a aislarse</option>
                <option value="AGRESIVO" {{ $social->socActitud == "AGRESIVO" ? 'selected="selected"' : '' }}>Agresivo</option>
            </select>
        </div>
    </div>

    <div class="row">
        {{--  ¿Tiene oportunidad de jugar con niños de su edad?  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('socNinioEdad', '¿Tiene oportunidad de jugar con niños de su edad?',
            array('class' =>
            '')); !!}
            <select id="socNinioEdad" class="browser-default" name="socNinioEdad" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $social->socNinioEdad == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $social->socNinioEdad == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Razón  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('socNinioRazon', 'Razón', array('class' => '')); !!}
                {!! Form::text('socNinioRazon', $social->socNinioRazon, array('id' => 'socNinioRazon', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  ¿Realiza alguna actividad extraescolar?  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('socActividadExtraescolar', '¿Realiza alguna actividad extraescolar?', array('class' => '')); !!}
            <select id="socActividadExtraescolar" class="browser-default" name="socActividadExtraescolar" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $social->socActividadExtraescolar == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $social->socActividadExtraescolar == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Razón  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('socActividadRazon', '¿Cúal?', array('class' => '')); !!}
                {!! Form::text('socActividadRazon', $social->socActividadRazon, array('id' => 'socActividadRazon', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{--  ¿Tiene dificultades para separarse de sus padres?  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('socSeparacion', '¿Tiene dificultades para separarse de sus padres?', array('class' => '')); !!}
            <select id="socSeparacion" class="browser-default" name="socSeparacion" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $social->socSeparacion == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $social->socSeparacion == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{-- Razón --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('socSeparacionRazon', '¿Cúal?', array('class' => '')); !!}
                {!! Form::text('socSeparacionRazon',  $social->socSeparacionRazon, array('id' => 'socSeparacionRazon', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        
        {{--  ¿Cómo se lleva con los miembros de la familia?  --}}
                <div class="col s12 m6 l12">
            <div class="input-field">
                {!! Form::label('socRelacionFamilia', '¿Cómo se lleva con los miembros de la familia?', array('class' => '')); !!}
                {!! Form::text('socRelacionFamilia', $social->socRelacionFamilia, array('id' => 'socRelacionFamilia', 'class' => 'validate','maxlength'=>'80')) !!}
            </div>
        </div>
    </div>

    <br>
</div> 

<script>
    $("select[name=socNinioEdad]").change(function(){
        if($('select[name=socNinioEdad]').val() == "SI"){
            $("#socNinioRazon").prop('required', false);
  
           
        }else{
            $("#socNinioRazon").prop('required', false);
    
        }
    });

    {{--  socActividadExtraescolar  --}}
    $("select[name=socActividadExtraescolar]").change(function(){
        if($('select[name=socActividadExtraescolar]').val() == "SI"){
            $("#socActividadRazon").prop('required', false);
 
           
        }else{
            $("#socActividadRazon").prop('required', false);
    
        }
    });

    {{--  socSeparacion  --}}
    $("select[name=socSeparacion]").change(function(){
        if($('select[name=socSeparacion]').val() == "SI"){
            $("#socSeparacionRazon").prop('required', false);

           
        }else{
            $("#socSeparacionRazon").prop('required', false);
    
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