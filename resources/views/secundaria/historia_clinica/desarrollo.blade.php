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
            <select id="desMotricesGruesas" class="browser-default" name="desMotricesGruesas" style="width: 100%;">
                @php                                  
                    if(old('desMotricesGruesas') !== null){
                        $desMotricesGruesas = old('desMotricesGruesas'); 
                    }
                    else{ $desMotricesGruesas = $desarrollo->desMotricesGruesas; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $desMotricesGruesas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $desMotricesGruesas == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  ¿Cúal? --}}
        <div class="col s12 m6 l3" id="divMotricesGru" style="display: none">
            <div class="input-field">
                @php                                  
                    if(old('desMotricesGruCual') !== null){
                        $desMotricesGruCual = old('desMotricesGruCual'); 
                    }
                    else{ $desMotricesGruCual = $desarrollo->desMotricesGruCual; }
                @endphp
                <label for="desMotricesGruCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                {!! Form::text('desMotricesGruCual', $desMotricesGruCual, array('id' => 'desMotricesGruCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>

        

        {{--  Habilidades motrices finas (dibujar, tomar cosas, etc)   --}}
        <div class="col s12 m6 l3">
            <label for="desMotricesFinas"><strong style="color: #000; font-size: 16px;">Habilidades motrices finas (dibujar, tomar cosas, etc)</strong></label>
            <select id="desMotricesFinas" class="browser-default" name="desMotricesFinas" style="width: 100%;">
                @php                                  
                    if(old('desMotricesFinas') !== null){
                        $desMotricesFinas = old('desMotricesFinas'); 
                    }
                    else{ $desMotricesFinas = $desarrollo->desMotricesFinas; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $desMotricesFinas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $desMotricesFinas == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        <div class="col s12 m6 l3" id="divMotricesFin" style="display: none">
            <div class="input-field">
                @php                                  
                    if(old('desMotricesFinCual') !== null){
                        $desMotricesFinCual = old('desMotricesFinCual'); 
                    }
                    else{ $desMotricesFinCual = $desarrollo->desMotricesFinCual; }
                @endphp
                <label for="desMotricesFinCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                {!! Form::text('desMotricesFinCual', $desMotricesFinCual, array('id' => 'desMotricesFinCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    

    <div class="row">
        {{--  Hiperactividad  --}}
        <div class="col s12 m6 l3">
            <label for="desHiperactividad"><strong style="color: #000; font-size: 16px;">Hiperactividad</strong></label>
            <select id="desHiperactividad" class="browser-default" name="desHiperactividad" style="width: 100%;">
                @php                                  
                    if(old('desHiperactividad') !== null){
                        $desHiperactividad = old('desHiperactividad'); 
                    }
                    else{ $desHiperactividad = $desarrollo->desHiperactividad; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $desHiperactividad == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $desHiperactividad == "NO" ? 'selected="selected"' : '' }}>NO</option>
            
            </select>
        </div>
        {{--  ¿Cúal? --}}
        <div class="col s12 m6 l3" id="divHiperactividad" style="display: none">
            <div class="input-field">
                @php                                  
                    if(old('desHiperactividadCual') !== null){
                        $desHiperactividadCual = old('desHiperactividadCual'); 
                    }
                    else{ $desHiperactividadCual = $desarrollo->desHiperactividadCual; }
                @endphp
                <label for="desHiperactividadCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                {!! Form::text('desHiperactividadCual', $desHiperactividadCual, array('id' => 'desHiperactividadCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
       

        {{--  Socialización  --}}
        <div class="col s12 m6 l3">
            <label for="desSocializacion"><strong style="color: #000; font-size: 16px;">Socialización</strong></label>
            <select id="desSocializacion" class="browser-default" name="desSocializacion" style="width: 100%;">
                @php                                  
                    if(old('desSocializacion') !== null){
                        $desSocializacion = old('desSocializacion'); 
                    }
                    else{ $desSocializacion = $desarrollo->desSocializacion; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $desSocializacion == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $desSocializacion == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        <div class="col s12 m6 l3" id="divSocializacion" style="display: none">
            <div class="input-field">
                @php                                  
                    if(old('desSocializacionCual') !== null){
                        $desSocializacionCual = old('desSocializacionCual'); 
                    }
                    else{ $desSocializacionCual = $desarrollo->desSocializacionCual; }
                @endphp
                <label for="desSocializacionCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
                {!! Form::text('desSocializacionCual', $desSocializacionCual, array('id' => 'desSocializacionCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>
    

    <div class="row">
        {{--  Lenguaje  --}}
        <div class="col s12 m6 l6">
            <label for="desLenguaje"><strong style="color: #000; font-size: 16px;">Lenguaje</strong></strong></label>
            <select id="desLenguaje" class="browser-default" name="desLenguaje" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                @php                                  
                    if(old('desLenguaje') !== null){
                        $desLenguaje = old('desLenguaje'); 
                    }
                    else{ $desLenguaje = $desarrollo->desLenguaje; }
                @endphp
                <option value="SI" {{ $desLenguaje == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $desLenguaje == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  ¿Cúal? --}}
        <div class="col s12 m6 l6" id="divLenguaje" style="display: none">
            <div class="input-field">
                @php                                  
                    if(old('desLenguajeCual') !== null){
                        $desLenguajeCual = old('desLenguajeCual'); 
                    }
                    else{ $desLenguajeCual = $desarrollo->desLenguajeCual; }
                @endphp
                <label for="desLenguajeCual"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></strong></label>
                {!! Form::text('desLenguajeCual', $desLenguajeCual, array('id' => 'desLenguajeCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    
   
    <p>Edad en que:</p>
    <div class="row">
        {{--  Dijo sus primeras palabras  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('desPrimPalabra') !== null){
                        $desPrimPalabra = old('desPrimPalabra'); 
                    }
                    else{ $desPrimPalabra = $desarrollo->desPrimPalabra; }
                @endphp
                <label for="desPrimPalabra"><strong style="color: #000; font-size: 16px;">Dijo sus primeras palabras</strong></strong></label>
                {!! Form::text('desPrimPalabra', $desPrimPalabra, array('id' => 'desPrimPalabra', 'class' => 'validate','maxlength'=>'30')) !!}
            </div>
        </div>

        <div class="col s12 m6 l6">
            {{--  Dijo su nombre  --}}
            <div class="input-field">
                @php                                  
                    if(old('desEdadNombre') !== null){
                        $desEdadNombre = old('desEdadNombre'); 
                    }
                    else{ $desEdadNombre = $desarrollo->desEdadNombre; }
                @endphp
                <label for="desEdadNombre"><strong style="color: #000; font-size: 16px;">Dijo su nombre</strong></strong></label>
                {!! Form::text('desEdadNombre', $desEdadNombre, array('id' => 'desEdadNombre', 'class' =>
                'validate','maxlength'=>'30')) !!}
            </div>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col s12 m6 l6">
            <label for="desLateralidad"><strong style="color: #000; font-size: 16px;">Lateralidad</strong></strong></label>
            <select id="desLateralidad" class="browser-default" name="desLateralidad" style="width: 100%;">
                @php                                  
                    if(old('desLateralidad') !== null){
                        $desLateralidad = old('desLateralidad'); 
                    }
                    else{ $desLateralidad = $desarrollo->desLateralidad; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="DIESTRO" {{ $desLateralidad == "DIESTRO" ? 'selected="selected"' : '' }}>Diestro</option>
                <option value="ZURDO" {{ $desLateralidad == "ZURDO" ? 'selected="selected"' : '' }}>Zurdo</option>
                <option value="DERECHO" {{ $desLateralidad == "DERECHO" ? 'selected="selected"' : '' }}>Derecho</option>   
                <option value="NO DEFINIDO" {{ $desLateralidad == "NO DEFINIDO" ? 'selected="selected"' : '' }}>No definido</option> 
                <option value="PREDOMINANCIA A DERECHO" {{ $desLateralidad == "PREDOMINANCIA A DERECHO" ? 'selected="selected"' : '' }}>Predominancia a derecho</option>
                <option value="PREDOMINANCIA A ZURDO" {{ $desLateralidad == "PREDOMINANCIA A ZURDO" ? 'selected="selected"' : '' }}>Predominancia a zurdo</option>
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