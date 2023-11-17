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
            <select id="habBanio" class="browser-default" name="habBanio" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('habBanio') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('habBanio') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  Se viste solo o hace el intento  --}}
        <div class="col s12 m6 l4">
            <label for="habVestimenta"><strong style="color: #000; font-size: 16px;">Se viste solo o hace el intento</strong></label>
            <select id="habVestimenta" class="browser-default" name="habVestimenta" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('habVestimenta') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('habVestimenta') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>

        {{--  Luz apagada al dormir  --}}
        <div class="col s12 m6 l4">
            <label for="habLuz"><strong style="color: #000; font-size: 16px;">Luz apagada al dormir</strong></label>
            <select id="habLuz" class="browser-default" name="habLuz" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('habLuz') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('habLuz') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
    </div>

    <div class="row">
        {{--  Se calza los zapatos solo  --}}
        <div class="col s12 m6 l4">
            <label for="habZapatos"><strong style="color: #000; font-size: 16px;">Se calza los zapatos solo</strong></label>
            <select id="habZapatos" class="browser-default" name="habZapatos" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('habZapatos') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('habZapatos') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
        {{--  Come solo  --}}
        <div class="col s12 m6 l4">
            <label for="habCome"><strong style="color: #000; font-size: 16px;">¿Come solo?</strong></label>
            <select id="habCome" class="browser-default" name="habCome" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('habCome') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('habCome') == "NO" ? 'selected' : '' }}>NO</option>
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
                <label for="habHoraDormir"><strong style="color: #000; font-size: 16px;">¿A qué hora se acuesta a dormir?</strong></label>
                {!! Form::text('habHoraDormir', old('habHoraDormir'), array('id' => 'habHoraDormir', 'class' =>
                'validate','maxlength'=>'40', 'required')) !!}
            </div>
        </div>
        {{--  ¿A qué hora se levanta?  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label for="habHoraDespertar"><strong style="color: #000; font-size: 16px;">¿A qué hora se levanta?</strong></label>
                {!! Form::text('habHoraDespertar', old('habHoraDespertar'), array('id' => 'habHoraDespertar', 'class' =>
                'validate','maxlength'=>'40', 'required')) !!}
            </div>
        </div>
    </div>


    <div class="row">
        {{--  Se levanta  --}}
        <div class="col s12 m6 l6">
            <label for="habEstadoLevantar"><strong style="color: #000; font-size: 16px;">Se levanta</strong></label>
            <select id="habEstadoLevantar" class="browser-default" name="habEstadoLevantar" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="MALHUMORADO" {{ old('habEstadoLevantar') == "MALHUMORADO" ? 'selected' : '' }}>Malhumorado</option>
                <option value="ALEGRE" {{ old('habEstadoLevantar') == "ALEGRE" ? 'selected' : '' }}>Alegre</option>
                <option value="RELAJADO" {{ old('habEstadoLevantar') == "RELAJADO" ? 'selected' : '' }}>Relajado</option>
                <option value="CANDADO" {{ old('habEstadoLevantar') == "CANDADO" ? 'selected' : '' }}>Cansado</option>
            </select>
        </div>
        {{--  Recipiente donde bebe agua o leche  --}}
        <div class="col s12 m6 l6">
            <label for="habRecipiente"><strong style="color: #000; font-size: 16px;">Recipiente donde bebe agua o leche</strong></label>
            <select id="habRecipiente" class="browser-default" name="habRecipiente" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="BIBERÓN" {{ old('habRecipiente') == "BIBERÓN" ? 'selected' : '' }}>Biberón</option>
                <option value="VASO ENTRENADOR" {{ old('habRecipiente') == "VASO ENTRENADOR" ? 'selected' : '' }}>Vaso entrenador</option>
                <option value="VASO" {{ old('habRecipiente') == "VASO" ? 'selected' : '' }}>Vaso</option>
            </select>
        </div>
    </div>



    <br>
</div> 
