<div id="desarrollo">
    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">HISTORIAL DEL DESARROLLO</p>
    </div>
    <br>
    <p>Presenta o presentó dificultades en las siguientes habilidades, en comparación con otros niños de su edad:</p>
    <div class="row">
        {{--  Habilidades motrices gruesas (caminar, saltar, etc)  --}}
        <div class="col s12 m6 l3">
            <label for="desMotricesGruesas"><strong style="color: #000; font-size: 16px;">Habilidades motrices gruesas (caminar, saltar, etc)</strong></label>
            <select id="desMotricesGruesas" class="browser-default" name="desMotricesGruesas" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('desMotricesGruesas') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('desMotricesGruesas') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  ¿Cúal? --}}
        <div class="col s12 m6 l3" id="divMotricesGru" style="display: none">
            <div class="input-field">
                <label for="desMotricesGruCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                {!! Form::text('desMotricesGruCual', old('desMotricesGruCual'), array('id' => 'desMotricesGruCual', 'class' => 'validate','maxlength'=>'255')) !!}
            </div>
        </div>

        

        {{--  Habilidades motrices finas (dibujar, tomar cosas, etc)   --}}
        <div class="col s12 m6 l3">
            <label for="desMotricesFinas"><strong style="color: #000; font-size: 16px;">Habilidades motrices finas (dibujar, tomar cosas, etc)</strong></label>
            <select id="desMotricesFinas" class="browser-default" name="desMotricesFinas" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('desMotricesFinas') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('desMotricesFinas') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>

        <div class="col s12 m6 l3" id="divMotricesFin" style="display: none">
            <div class="input-field">
                <label for="desMotricesFinCual"><strong style="color: #000; font-size: 16px;">¿Cuál?*</strong></label>
                {!! Form::text('desMotricesFinCual', old('desMotricesFinCual'), array('id' => 'desMotricesFinCual', 'class' => 'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    

    <div class="row">
        {{--  Hiperactividad  --}}
        <div class="col s12 m6 l3">
            <label for="desHiperactividad"><strong style="color: #000; font-size: 16px;">Hiperactividad</strong></label>
            <select id="desHiperactividad" class="browser-default" name="desHiperactividad" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('desHiperactividad') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('desHiperactividad') == "NO" ? 'selected' : '' }}>NO</option>
            
            </select>
        </div>
        {{--  ¿Cúal? --}}
        <div class="col s12 m6 l3" id="divHiperactividad" style="display: none">
            <div class="input-field">
                <label for="desHiperactividadCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                {!! Form::text('desHiperactividadCual', old('desHiperactividadCual'), array('id' => 'desHiperactividadCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
       

        {{--  Socialización  --}}
        <div class="col s12 m6 l3">
            <label for="desSocializacion"><strong style="color: #000; font-size: 16px;">Socialización</strong></label>
            <select id="desSocializacion" class="browser-default" name="desSocializacion" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('desSocializacion') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('desSocializacion') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>

        <div class="col s12 m6 l3" id="divSocializacion" style="display: none">
            <div class="input-field">
                <label for="desSocializacionCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                {!! Form::text('desSocializacionCual', old('desSocializacionCual'), array('id' => 'desSocializacionCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>
    

    <div class="row">
        {{--  Lenguaje  --}}
        <div class="col s12 m6 l6">
            <label for="desLenguaje"><strong style="color: #000; font-size: 16px;">Lenguaje</strong></label>
            <select id="desLenguaje" class="browser-default" name="desLenguaje" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('desLenguaje') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('desLenguaje') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  ¿Cúal? --}}
        <div class="col s12 m6 l6" id="divLenguaje" style="display: none">
            <div class="input-field">
                <label for="desLenguajeCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                {!! Form::text('desLenguajeCual', old('desLenguajeCual'), array('id' => 'desLenguajeCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    
   
    <p>Edad en que:</p>
    <div class="row">
        {{--  Dijo sus primeras palabras  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="desPrimPalabra"><strong style="color: #000; font-size: 16px;">Dijo sus primeras palabras</strong></label>
                {!! Form::text('desPrimPalabra', old('desPrimPalabra'), array('id' => 'desPrimPalabra', 'class' =>
                'validate','maxlength'=>'30', 'required')) !!}
            </div>
        </div>

        <div class="col s12 m6 l6">
            {{--  Dijo su nombre  --}}
            <div class="input-field">
                <label for="desEdadNombre"><strong style="color: #000; font-size: 16px;">Dijo su nombre</strong></label>
                {!! Form::text('desEdadNombre', old('desEdadNombre'), array('id' => 'desEdadNombre', 'class' =>
                'validate','maxlength'=>'30', 'required')) !!}
            </div>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col s12 m6 l6">
            <label for="desLateralidad"><strong style="color: #000; font-size: 16px;">Lateralidad</strong></label>
            <select id="desLateralidad" class="browser-default" name="desLateralidad" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="DIESTRO" {{ old('desLateralidad') == "DIESTRO" ? 'selected' : '' }}>Diestro</option>
                <option value="ZURDO" {{ old('desLateralidad') == "ZURDO" ? 'selected' : '' }}>Zurdo</option>
                <option value="DERECHO" {{ old('desLateralidad') == "DERECHO" ? 'selected' : '' }}>Derecho</option>   
                <option value="NO DEFINIDO" {{ old('desLateralidad') == "NO DEFINIDO" ? 'selected' : '' }}>No definido</option> 
                <option value="PREDOMINANCIA A DERECHO" {{ old('desLateralidad') == "PREDOMINANCIA A DERECHO" ? 'selected' : '' }}>Predominancia a derecho</option>
                <option value="PREDOMINANCIA A ZURDO" {{ old('desLateralidad') == "PREDOMINANCIA A ZURDO" ? 'selected' : '' }}>Predominancia a zurdo</option>

            </select>
        </div>
    </div>
      <br>
</div> 


<script>

  

$("select[name=desMotricesGruesas]").change(function(){
    if($('select[name=desMotricesGruesas]').val() == "SI"){
        $("#divMotricesGru").show(); 
        $("#desMotricesGruCual").attr('required', '');     
       
    }else{
        $("#desMotricesGruCual").removeAttr('required');
        $("#divMotricesGru").hide();    
        $("#desMotricesGruCual").val("");     

    }
});

$("select[name=desMotricesFinas]").change(function(){
    if($('select[name=desMotricesFinas]').val() == "SI"){
        $("#divMotricesFin").show(); 
        $("#desMotricesFinCual").attr('required', '');     
       
    }else{
        $("#desMotricesFinCual").removeAttr('required');
        $("#divMotricesFin").hide();  
        $("#desMotricesFinCual").val("");       

    }
});

$("select[name=desHiperactividad]").change(function(){
    if($('select[name=desHiperactividad]').val() == "SI"){
        $("#divHiperactividad").show(); 
        $("#desHiperactividadCual").attr('required', '');     
       
    }else{
        $("#desHiperactividadCual").removeAttr('required');
        $("#divHiperactividad").hide();      
        $("#desHiperactividadCual").val("");   

    }
});

$("select[name=desSocializacion]").change(function(){
    if($('select[name=desSocializacion]').val() == "SI"){
        $("#divSocializacion").show(); 
        $("#desSocializacionCual").attr('required', '');     
       
    }else{
        $("#desSocializacionCual").removeAttr('required');
        $("#divSocializacion").hide();   
        $("#desSocializacionCual").val("");      

    }
});

$("select[name=desLenguaje]").change(function(){
    if($('select[name=desLenguaje]').val() == "SI"){
        $("#divLenguaje").show(); 
        $("#desLenguajeCual").attr('required', '');     
       
    }else{
        $("#desLenguajeCual").removeAttr('required');
        $("#divLenguaje").hide();       
        $("#desLenguajeCual").val("");  

    }
});

if($('select[name=desMotricesGruesas]').val() == "SI"){
    $("#divMotricesGru").show(); 
    $("#desMotricesGruCual").attr('required', '');
}else{
    $("#desMotricesGruCual").removeAttr('required');
    $("#divMotricesGru").hide();         
}

if($('select[name=desMotricesFinas]').val() == "SI"){
    $("#divMotricesFin").show(); 
    $("#desMotricesFinCual").attr('required', '');
}else{
    $("#desMotricesFinCual").removeAttr('required');
    $("#divMotricesFin").hide();         
}

if($('select[name=desHiperactividad]').val() == "SI"){
    $("#divHiperactividad").show(); 
    $("#desHiperactividadCual").attr('required', '');
}else{
    $("#desHiperactividadCual").removeAttr('required');
    $("#divHiperactividad").hide();         
}

if($('select[name=desSocializacion]').val() == "SI"){
    $("#divSocializacion").show(); 
    $("#desSocializacionCual").attr('required', '');
}else{
    $("#desSocializacionCual").removeAttr('required');
    $("#divSocializacion").hide();         
}


if($('select[name=desLenguaje]').val() == "SI"){
    $("#divLenguaje").show(); 
    $("#desLenguajeCual").attr('required', '');
}else{
    $("#desLenguajeCual").removeAttr('required');
    $("#divLenguaje").hide();         
}
</script>