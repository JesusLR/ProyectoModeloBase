<div id="habitos">
    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">HÁBITOS E HIGIENE</p>
    </div>
    <br>
    <div class="row">
        {{--  Va al baño solo  --}}
        <div class="col s12 m6 l4">
            {!! Form::label('habBanio', 'Va al baño solo', array('class' => '')); !!}
            <select id="habBanio" class="browser-default" name="habBanio" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $habitos->habBanio == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $habitos->habBanio == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Se viste solo o hace el intento  --}}
        <div class="col s12 m6 l4">
            {!! Form::label('habVestimenta', 'Se viste solo o hace el intento', array('class' => '')); !!}
            <select id="habVestimenta" class="browser-default" name="habVestimenta" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $habitos->habVestimenta == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $habitos->habVestimenta == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  Luz apagada al dormir  --}}
        <div class="col s12 m6 l4">
            {!! Form::label('habLuz', 'Luz apagada al dormir', array('class' => '')); !!}
            <select id="habLuz" class="browser-default" name="habLuz" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $habitos->habLuz == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $habitos->habLuz == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
    </div>

    <div class="row">
        {{--  Se calza los zapatos solo  --}}
        <div class="col s12 m6 l4">
            {!! Form::label('habZapatos', 'Se calza los zapatos solo', array('class' => '')); !!}
            <select id="habZapatos" class="browser-default" name="habZapatos" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $habitos->habZapatos == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $habitos->habZapatos == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
        {{--  Come solo  --}}
        <div class="col s12 m6 l4">
            {!! Form::label('habCome', 'Come solo', array('class' => '')); !!}
            <select id="habCome" class="browser-default" name="habCome" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $habitos->habCome == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $habitos->habCome == "NO" ? 'selected="selected"' : '' }}>NO</option>
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
                {!! Form::label('habHoraDormir', '¿A qué hora se acuesta a dormir?', array('class' => '')); !!}
                {!! Form::text('habHoraDormir', $habitos->habHoraDormir, array('id' => 'habHoraDormir', 'class' =>
                'validate','maxlength'=>'40')) !!}
            </div>
        </div>
        {{--  ¿A qué hora se levanta?  --}}
        <div class="col s12 m6 l6">
            <div class="input-field">
                {!! Form::label('habHoraDespertar', '¿A qué hora se levanta?', array('class' => '')); !!}
                {!! Form::text('habHoraDespertar', $habitos->habHoraDespertar, array('id' => 'habHoraDespertar', 'class' =>
                'validate','maxlength'=>'40')) !!}
            </div>
        </div>
    </div>


    <div class="row">
        {{--  Se levanta  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('habEstadoLevantar', 'Se levanta', array('class' => '')); !!}
            <select id="habEstadoLevantar" class="browser-default" name="habEstadoLevantar" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="MALHUMORADO" {{ $habitos->habEstadoLevantar == "MALHUMORADO" ? 'selected="selected"' : '' }}>Malhumorado</option>
                <option value="ALEGRE" {{ $habitos->habEstadoLevantar == "ALEGRE" ? 'selected="selected"' : '' }}>Alegre</option>
                <option value="RELAJADO" {{ $habitos->habEstadoLevantar == "RELAJADO" ? 'selected="selected"' : '' }}>Relajado</option>
                <option value="CANDADO" {{ $habitos->habEstadoLevantar == "CANDADO" ? 'selected="selected"' : '' }}>Cansado</option>
            </select>
        </div>
        {{--  Recipiente donde bebe agua o leche  --}}
        <div class="col s12 m6 l6">
            {!! Form::label('habRecipiente', 'Recipiente donde bebe agua o leche', array('class' => '')); !!}
            <select id="habRecipiente" class="browser-default" name="habRecipiente" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="BIBERÓN" {{ $habitos->habRecipiente == "BIBERÓN" ? 'selected="selected"' : '' }}>Biberón</option>
                <option value="VASO ENTRENADOR" {{ $habitos->habRecipiente == "VASO ENTRENADOR" ? 'selected="selected"' : '' }}>Vaso entrenador</option>
                <option value="VASO" {{ $habitos->habRecipiente == "VASO" ? 'selected="selected"' : '' }}>Vaso</option>
            </select>
        </div>
    </div>



    <br>
</div> 
