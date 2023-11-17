<div id="embarazo">

    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">HISTORIAL DEL EMBARAZO Y DEL NACIMIENTO</p>
    </div>
    <div class="row">
        {{--  Embarazo número   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('nacNumEmbarazo', old('nacNumEmbarazo'), array('id' => 'nacNumEmbarazo', 'class' => 'validate',
                'required','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==4) return false;"')) !!}
                <label for="nacNumEmbarazo"><strong style="color: #000; font-size: 16px;">Embarazo número</strong></label>
            </div>
        </div>

        {{--  Embarazo planeado   --}}
        <div class="col s12 m6 l4">
            <label for="nacEmbarazoPlaneado"><strong style="color: #000; font-size: 16px;">Embarazo planeado</strong></label>
            <select id="nacEmbarazoPlaneado" required class="browser-default" name="nacEmbarazoPlaneado"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('nacEmbarazoPlaneado') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('nacEmbarazoPlaneado') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>

        {{--  Embarazo a término   --}}
        <div class="col s12 m6 l4">
            <label for="nacEmbarazoTermino"><strong style="color: #000; font-size: 16px;">Embarazo a término</strong></label>
            <select id="nacEmbarazoTermino" required class="browser-default" name="nacEmbarazoTermino"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('nacEmbarazoTermino') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('nacEmbarazoTermino') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>
    </div>

    <div class="row">
        {{--  Duración del embarazo   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
            <label for="nacEmbarazoDuracion"><strong style="color: #000; font-size: 16px;">Duración del embarazo</strong></label>
            {!! Form::text('nacEmbarazoDuracion', old('nacEmbarazoDuracion'), array('id' => 'nacEmbarazoDuracion', 'class' =>
            'validate','required', 'maxlength'=>'40')) !!}
            </div>
        </div>

        {{--  Parto   --}}
        <div class="col s12 m6 l4">
            <label for="NacParto"><strong style="color: #000; font-size: 16px;">Parto</strong></label>
            <select id="NacParto" class="browser-default validate select2" required name="NacParto"
                style="width: 100%;">
                <option value="" disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="NATURAL" {{ old('NacParto') == "NATURAL" ? 'selected' : '' }}>Natural</option>
                <option value="CESÁREA" {{ old('NacParto') == "CESÁREA" ? 'selected' : '' }}>Cesárea</option>
                <option value="FÓRCEPS" {{ old('NacParto') == "FÓRCEPS" ? 'selected' : '' }}>Fórceps</option>              

            </select>
        </div>

        {{--  peso al nacer   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('nacPeso', old('nacPeso'), array('id' => 'nacPeso', 'class' =>
                'validate','required','maxlength'=>'20')) !!}
                <label for="nacPeso"><strong style="color: #000; font-size: 16px;">Peso al nacer</strong></label>
            </div>
        </div>
    </div>


    <div class="row">
        {{--  medida al nacer   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('nacMedia', old('nacMedia'), array('id' => 'nacMedia', 'class' =>
                'validate','maxlength'=>'20', 'required')) !!}
                <label for="nacMedia"><strong style="color: #000; font-size: 16px;">Medida al nacer</strong></label>
            </div>
        </div>

        {{--  APGAR  --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('nacApgar', old('nacApgar'), array('id' => 'nacApgar', 'class' =>
                'validate','maxlength'=>'255', 'required')) !!}
                <label for="nacApgar"><strong style="color: #000; font-size: 16px;">APGAR</strong></label>
            </div>
        </div>
    </div>

    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">Complicaciones</p>
    </div>
    <div class="row">
        {{--  durante el embarazo   --}}
        <div class="col s12 m6 l4">
            <label for="nacComplicacionesEmbarazo"><strong style="color: #000; font-size: 16px;">Durante el embarazo</strong></label>
            <select id="nacComplicacionesEmbarazo" required class="browser-default" name="nacComplicacionesEmbarazo"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('nacComplicacionesEmbarazo') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('nacComplicacionesEmbarazo') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>

        {{--  cuales durante el embarazo  --}}
        <div class="col s12 m6 l8" id="divEmbarazo" style="display: none;">
            <div class="input-field">
                {!! Form::text('nacCualesEmbarazo', old('nacCualesEmbarazo'), array('id' => 'nacCualesEmbarazo', 'class' =>
                'validate','maxlength'=>'255')) !!}
                <label for="nacCualesEmbarazo"><strong style="color: #000; font-size: 16px;">¿Cuáles durante el embarazo?</strong></label>
            </div>
        </div>       
    </div>

    <div class="row">
        {{--  durante el parto   --}}
        <div class="col s12 m6 l4">
            <label for="nacComplicacionesParto"><strong style="color: #000; font-size: 16px;">Durante el parto</strong></label>
            <select id="nacComplicacionesParto" required class="browser-default" name="nacComplicacionesParto"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('nacComplicacionesParto') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('nacComplicacionesParto') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>

        {{--  cuales durante el parto  --}}
        <div class="col s12 m6 l8" id="divParto" style="display: none;">
            <div class="input-field">
                {!! Form::text('nacCualesParto', old('nacCualesParto'), array('id' => 'nacCualesParto', 'class' =>
                'validate','maxlength'=>'255')) !!}
                <label for="nacCualesParto"><strong style="color: #000; font-size: 16px;">¿Cuáles durante el parto?</strong></label>
            </div>
        </div>       
    </div>

    <div class="row">
        {{--  despues del nacimiento   --}}
        <div class="col s12 m6 l4">
            <label for="nacComplicacionDespues"><strong style="color: #000; font-size: 16px;">Después del nacimiento</strong></label>
            <select id="nacComplicacionDespues" required class="browser-default" name="nacComplicacionDespues"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('nacComplicacionDespues') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('nacComplicacionDespues') == "NO" ? 'selected' : '' }}>NO</option>
            </select>
        </div>

        {{--  despues del nacimiento cuales  --}}
        <div class="col s12 m6 l8" id="divDespues" style="display: none;">
            <div class="input-field">
                {!! Form::text('nacCualesDespues', old('nacCualesDespues'), array('id' => 'nacCualesDespues', 'class' =>
                'validate','maxlength'=>'255')) !!}
                <label for="nacCualesDespues"><strong style="color: #000; font-size: 16px;">¿Cuáles después del nacimiento?</strong></label>
            </div>
        </div>       
    </div>

    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">Lactancia</p>
    </div>
    <div class="row">
        {{--  Lactancia   --}}
        <div class="col s12 m6 l4">
            <label for="nacLactancia"><strong style="color: #000; font-size: 16px;">Tipo de leche</strong></label>
            <select id="nacLactancia" required class="browser-default" name="nacLactancia"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="FÓRMULA" {{ old('nacLactancia') == "FÓRMULA" ? 'selected' : '' }}>Fórmula</option>
                <option value="MATERNA" {{ old('nacLactancia') == "MATERNA" ? 'selected' : '' }}>Materna</option>
                <option value="MIXTA" {{ old('nacLactancia') == "MIXTA" ? 'selected' : '' }}>Mixta</option>
            </select>
        </div>

        {{--  despues del nacimiento cuales  --}}
        <div class="col s12 m6 l8" id="divLactancia" style="display: none;">
            <div class="input-field">
                {!! Form::text('nacActualmente', old('nacActualmente'), array('id' => 'nacActualmente', 'class' =>
                'validate','maxlength'=>'255')) !!}
                <label for="nacActualmente"><strong style="color: #000; font-size: 16px;">¿Cuál?</strong></label>
            </div>
        </div>       
    </div>



</div> 
<script>
    if($('select[name=nacComplicacionesEmbarazo]').val() == "SI"){
        $("#divEmbarazo").show(); 
        $("#nacCualesEmbarazo").attr('required', '');
    }else{
        $("#nacCualesEmbarazo").removeAttr('required');
        $("#divEmbarazo").hide();         
    }

    if($('select[name=nacComplicacionesParto]').val() == "SI"){
        $("#divParto").show(); 
        $("#nacCualesParto").attr('required', '');
    }else{
        $("#nacCualesParto").removeAttr('required');
        $("#divParto").hide();         
    }


    if($('select[name=nacComplicacionDespues]').val() == "SI"){
        $("#divDespues").show(); 
        $("#nacCualesDespues").attr('required', '');
    }else{
        $("#nacCualesDespues").removeAttr('required');
        $("#divDespues").hide();         
    }

    if($('select[name=nacLactancia]').val() != "MATERNA"){
        $("#divLactancia").show(); 
        $("#nacActualmente").attr('required', '');
    }else{
        $("#nacActualmente").removeAttr('required');
        $("#divLactancia").hide();         
    }
</script>