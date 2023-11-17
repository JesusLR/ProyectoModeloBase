<div id="habitos">
    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">HÁBITOS E HIGIENE</p>
    </div>
    <br>
    <div class="row">
        {{--  Va al baño solo  --}}
        <div class="col s12 m6 l4">
            <label for="habBanio"><strong style="color: #000; font-size: 16px;">Va al baño solo</strong></label>
            <select id="habBanio" class="browser-default" name="habBanio" style="width: 100%;">
                @php                                  
                    if(old('habBanio') !== null){
                        $habBanio = old('habBanio'); 
                    }
                    else{ $habBanio = $habitos->habBanio; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $habBanio == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $habBanio == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Se viste solo o hace el intento  --}}
        <div class="col s12 m6 l4">
            <label for="habVestimenta"><strong style="color: #000; font-size: 16px;">Se viste solo o hace el intento</strong></label>
            <select id="habVestimenta" class="browser-default" name="habVestimenta" style="width: 100%;">
                @php                                  
                    if(old('habVestimenta') !== null){
                        $habVestimenta = old('habVestimenta'); 
                    }
                    else{ $habVestimenta = $habitos->habVestimenta; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $habVestimenta == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $habVestimenta == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  Luz apagada al dormir  --}}
        <div class="col s12 m6 l4">
            <label for="habLuz"><strong style="color: #000; font-size: 16px;">Luz apagada al dormir</strong></label>
            <select id="habLuz" class="browser-default" name="habLuz" style="width: 100%;">
                @php                                  
                    if(old('habLuz') !== null){
                        $habLuz = old('habLuz'); 
                    }
                    else{ $habLuz = $habitos->habLuz; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $habLuz == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $habLuz == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
    </div>

    <div class="row">
        {{--  Se calza los zapatos solo  --}}
        <div class="col s12 m6 l4">
            <label for="habZapatos"><strong style="color: #000; font-size: 16px;">Se calza los zapatos solo</strong></label>
            <select id="habZapatos" class="browser-default" name="habZapatos" style="width: 100%;">
                @php                                  
                    if(old('habZapatos') !== null){
                        $habZapatos = old('habZapatos'); 
                    }
                    else{ $habZapatos = $habitos->habZapatos; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $habZapatos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $habZapatos == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Come solo  --}}
        <div class="col s12 m6 l4">
            <label for="habCome"><strong style="color: #000; font-size: 16px;">¿Come solo?</strong></label>
            <select id="habCome" class="browser-default" name="habCome" style="width: 100%;">
                @php                                  
                    if(old('habCome') !== null){
                        $habCome = old('habCome'); 
                    }
                    else{ $habCome = $habitos->habCome; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $habCome == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $habCome == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
    </div>

    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">General</p>
    </div>


    
    <div class="row">
        {{--  ¿A qué hora se acuesta a dormir?  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('habHoraDormir') !== null){
                        $habHoraDormir = old('habHoraDormir'); 
                    }
                    else{ $habHoraDormir = $habitos->habHoraDormir; }
                @endphp
                <label for="habHoraDormir"><strong style="color: #000; font-size: 16px;">¿A qué hora se acuesta a dormir?</strong></label>
                {!! Form::text('habHoraDormir', $habHoraDormir, array('id' => 'habHoraDormir', 'class' =>
                'validate','maxlength'=>'40')) !!}
            </div>
        </div>
        {{--  ¿A qué hora se levanta?  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                @php                                  
                    if(old('habHoraDespertar') !== null){
                        $habHoraDespertar = old('habHoraDespertar'); 
                    }
                    else{ $habHoraDespertar = $habitos->habHoraDespertar; }
                @endphp
                <label for="habHoraDespertar"><strong style="color: #000; font-size: 16px;">¿A qué hora se levanta?</strong></label>
                {!! Form::text('habHoraDespertar', $habHoraDespertar, array('id' => 'habHoraDespertar', 'class' =>
                'validate','maxlength'=>'40')) !!}
            </div>
        </div>
    </div>


    <div class="row">
        {{--  Se levanta  --}}
        <div class="col s12 m6 l6">
            <label for="habEstadoLevantar"><strong style="color: #000; font-size: 16px;">¿Se levanta?</strong></label>
            <select id="habEstadoLevantar" class="browser-default" name="habEstadoLevantar" style="width: 100%;">
                @php                                  
                    if(old('habEstadoLevantar') !== null){
                        $habEstadoLevantar = old('habEstadoLevantar'); 
                    }
                    else{ $habEstadoLevantar = $habitos->habEstadoLevantar; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="MALHUMORADO" {{ $habEstadoLevantar == "MALHUMORADO" ? 'selected="selected"' : '' }}>Malhumorado</option>
                <option value="ALEGRE" {{ $habEstadoLevantar == "ALEGRE" ? 'selected="selected"' : '' }}>Alegre</option>
                <option value="RELAJADO" {{ $habEstadoLevantar == "RELAJADO" ? 'selected="selected"' : '' }}>Relajado</option>
                <option value="CANDADO" {{ $habEstadoLevantar == "CANDADO" ? 'selected="selected"' : '' }}>Cansado</option>
            </select>
        </div>
        {{--  Recipiente donde bebe agua o leche  --}}
        <div class="col s12 m6 l6">
            <label for="habRecipiente"><strong style="color: #000; font-size: 16px;">Recipiente donde bebe agua o leche</strong></label>
            <select id="habRecipiente" class="browser-default" name="habRecipiente" style="width: 100%;">
                @php                                  
                    if(old('habRecipiente') !== null){
                        $habRecipiente = old('habRecipiente'); 
                    }
                    else{ $habRecipiente = $habitos->habRecipiente; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="BIBERÓN" {{ $habRecipiente == "BIBERÓN" ? 'selected="selected"' : '' }}>Biberón</option>
                <option value="VASO ENTRENADOR" {{ $habRecipiente == "VASO ENTRENADOR" ? 'selected="selected"' : '' }}>Vaso entrenador</option>
                <option value="VASO" {{ $habRecipiente == "VASO" ? 'selected="selected"' : '' }}>Vaso</option>
            </select>
        </div>
    </div>



    <br>
</div> 
