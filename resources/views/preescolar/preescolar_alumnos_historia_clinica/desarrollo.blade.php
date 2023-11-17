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
            {!! Form::label('desMotricesGruesas', 'Habilidades motrices gruesas (caminar, saltar, etc)', array('class' => '')); !!}
            <select id="desMotricesGruesas" class="browser-default" name="desMotricesGruesas" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $desarrollo->desMotricesGruesas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $desarrollo->desMotricesGruesas == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  ¿Cúal? --}}
        <div class="col s12 m6 l3" id="divMotricesGru" style="display: none">
            <div class="input-field">
                {!! Form::label('desMotricesGruCual', '¿Cuál?*', array('class' => '')); !!}
                {!! Form::text('desMotricesGruCual', $desarrollo->desMotricesGruCual, array('id' => 'desMotricesGruCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>

        

        {{--  Habilidades motrices finas (dibujar, tomar cosas, etc)   --}}
        <div class="col s12 m6 l3">
            {!! Form::label('desMotricesFinas', 'Habilidades motrices finas (dibujar, tomar cosas, etc)', array('class' => '')); !!}
            <select id="desMotricesFinas" class="browser-default" name="desMotricesFinas" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $desarrollo->desMotricesFinas == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $desarrollo->desMotricesFinas == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        <div class="col s12 m6 l3" id="divMotricesFin" style="display: none">
            <div class="input-field">
                {!! Form::label('desMotricesFinCual', '¿Cuál?*', array('class' => '')); !!}
                {!! Form::text('desMotricesFinCual', $desarrollo->desMotricesFinCual, array('id' => 'desMotricesFinCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    

    <div class="row">
        {{--  Hiperactividad  --}}
        <div class="col s12 m6 l3">
            {!! Form::label('desHiperactividad', 'Hiperactividad', array('class' => '')); !!}
            <select id="desHiperactividad" class="browser-default" name="desHiperactividad" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $desarrollo->desHiperactividad == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $desarrollo->desHiperactividad == "NO" ? 'selected="selected"' : '' }}>NO</option>
            
            </select>
        </div>
        {{--  ¿Cúal? --}}
        <div class="col s12 m6 l3" id="divHiperactividad" style="display: none">
            <div class="input-field">
                {!! Form::label('desHiperactividadCual', '¿Cuál?', array('class' => '')); !!}
                {!! Form::text('desHiperactividadCual', $desarrollo->desHiperactividadCual, array('id' => 'desHiperactividadCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
       

        {{--  Socialización  --}}
        <div class="col s12 m6 l3">
            {!! Form::label('desSocializacion', 'Socialización',
            array('class' =>
            '')); !!}
            <select id="desSocializacion" class="browser-default" name="desSocializacion" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $desarrollo->desSocializacion == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $desarrollo->desSocializacion == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        <div class="col s12 m6 l3" id="divSocializacion" style="display: none">
            <div class="input-field">
                {!! Form::label('desSocializacionCual', '¿Cuál?', array('class' => '')); !!}
                {!! Form::text('desSocializacionCual', $desarrollo->desSocializacionCual, array('id' => 'desSocializacionCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>
    

    <div class="row">
        {{--  Lenguaje  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('desLenguaje', 'Lenguaje',  array('class' => '')); !!}
            <select id="desLenguaje" class="browser-default" name="desLenguaje" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $desarrollo->desLenguaje == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $desarrollo->desLenguaje == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  ¿Cúal? --}}
        <div class="col s12 m6 l6" id="divLenguaje" style="display: none">
            <div class="input-field">
                {!! Form::label('desLenguajeCual', '¿Cuál?', array('class' => '')); !!}
                {!! Form::text('desLenguajeCual', $desarrollo->desLenguajeCual, array('id' => 'desLenguajeCual', 'class' =>
                'validate','maxlength'=>'255')) !!}
            </div>
        </div>
    </div>

    
   
    <p>Edad en que:</p>
    <div class="row">
        {{--  Dijo sus primeras palabras  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('desPrimPalabra', 'Dijo sus primeras palabras', array('class' => '')); !!}
                {!! Form::text('desPrimPalabra', $desarrollo->desPrimPalabra, array('id' => 'desPrimPalabra', 'class' =>
                'validate','maxlength'=>'30')) !!}
            </div>
        </div>

        <div class="col s12 m6 l6">
            {{--  Dijo su nombre  --}}
            <div class="input-field">
                {!! Form::label('desEdadNombre', 'Dijo su nombre', array('class' => '')); !!}
                {!! Form::text('desEdadNombre', $desarrollo->desEdadNombre, array('id' => 'desEdadNombre', 'class' =>
                'validate','maxlength'=>'30')) !!}
            </div>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col s12 m6 l6">
            {!! Form::label('desLateralidad', 'Lateralidad', array('class' => '')); !!}
            <select id="desLateralidad" class="browser-default" name="desLateralidad" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="DIESTRO" {{ $desarrollo->desLateralidad == "DIESTRO" ? 'selected="selected"' : '' }}>Diestro</option>
                <option value="ZURDO" {{ $desarrollo->desLateralidad == "ZURDO" ? 'selected="selected"' : '' }}>Zurdo</option>
                <option value="DERECHO" {{ $desarrollo->desLateralidad == "DERECHO" ? 'selected="selected"' : '' }}>Derecho</option>   
                <option value="NO DEFINIDO" {{ $desarrollo->desLateralidad == "NO DEFINIDO" ? 'selected="selected"' : '' }}>No definido</option> 
                <option value="PREDOMINANCIA A DERECHO" {{ $desarrollo->desLateralidad == "PREDOMINANCIA A DERECHO" ? 'selected="selected"' : '' }}>Predominancia a derecho</option>
                <option value="PREDOMINANCIA A ZURDO" {{ $desarrollo->desLateralidad == "PREDOMINANCIA A ZURDO" ? 'selected="selected"' : '' }}>Predominancia a zurdo</option>

            </select>
        </div>
    </div>
      <br>
</div> 


<script>

  

$("select[name=desMotricesGruesas]").change(function(){
    if($('select[name=desMotricesGruesas]').val() == "SI"){
        $("#divMotricesGru").show(); 
        $("#desMotricesGruCual").prop('required', false);
       
    }else{
        $("#desMotricesGruCual").prop('required', false);
        $("#divMotricesGru").hide();    
        $("#desMotricesGruCual").val("");     

    }
});

$("select[name=desMotricesFinas]").change(function(){
    if($('select[name=desMotricesFinas]').val() == "SI"){
        $("#divMotricesFin").show(); 
        $("#desMotricesFinCual").prop('required', false);
 
       
    }else{
        $("#desMotricesFinCual").prop('required', false);
        $("#divMotricesFin").hide();  
        $("#desMotricesFinCual").val("");       

    }
});

$("select[name=desHiperactividad]").change(function(){
    if($('select[name=desHiperactividad]').val() == "SI"){
        $("#divHiperactividad").show(); 
        $("#desHiperactividadCual").prop('required', false);
   
       
    }else{
        $("#desHiperactividadCual").prop('required', false);
        $("#divHiperactividad").hide();      
        $("#desHiperactividadCual").val("");   

    }
});

$("select[name=desSocializacion]").change(function(){
    if($('select[name=desSocializacion]').val() == "SI"){
        $("#divSocializacion").show(); 
        $("#desSocializacionCual").prop('required', false);
 
       
    }else{
        $("#desSocializacionCual").prop('required', false);
        $("#divSocializacion").hide();   
        $("#desSocializacionCual").val("");      

    }
});

$("select[name=desLenguaje]").change(function(){
    if($('select[name=desLenguaje]').val() == "SI"){
        $("#divLenguaje").show(); 
        $("#desLenguajeCual").prop('required', false);

       
    }else{
        $("#desLenguajeCual").prop('required', false);
        $("#divLenguaje").hide();       
        $("#desLenguajeCual").val("");  

    }
});

if($('select[name=desMotricesGruesas]').val() == "SI"){
    $("#divMotricesGru").show(); 
    $("#desMotricesGruCual").prop('required', false);

}else{
    $("#desMotricesGruCual").prop('required', false);
    $("#divMotricesGru").hide();         
}

if($('select[name=desMotricesFinas]').val() == "SI"){
    $("#divMotricesFin").show(); 
    $("#desMotricesFinCual").prop('required', false);

}else{
    $("#desMotricesFinCual").prop('required', false);
    $("#divMotricesFin").hide();         
}

if($('select[name=desHiperactividad]').val() == "SI"){
    $("#divHiperactividad").show(); 
    $("#desHiperactividadCual").prop('required', false);

}else{
    $("#desHiperactividadCual").prop('required', false);
    $("#divHiperactividad").hide();         
}

if($('select[name=desSocializacion]').val() == "SI"){
    $("#divSocializacion").show(); 
    $("#desSocializacionCual").prop('required', false);

}else{
    $("#desSocializacionCual").prop('required', false);
    $("#divSocializacion").hide();         
}


if($('select[name=desLenguaje]').val() == "SI"){
    $("#divLenguaje").show(); 
    $("#desLenguajeCual").prop('required', false);

}else{
    $("#desLenguajeCual").prop('required', false);    
    $("#divLenguaje").hide();         
}
</script>