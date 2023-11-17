<div id="embarazo">

    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">HISTORIAL DEL EMBARAZO Y DEL NACIMIENTO</p>
    </div>
    <div class="row">
        {{--  Embarazo número   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('nacNumEmbarazo') !== null){
                        $nacNumEmbarazo = old('nacNumEmbarazo'); 
                    }
                    else{ $nacNumEmbarazo = $embarazo->nacNumEmbarazo; }
                @endphp
                {!! Form::number('nacNumEmbarazo', $nacNumEmbarazo, array('id' => 'nacNumEmbarazo', 'class' => 'validate','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==4) return false;"')) !!}
                <label for="nacNumEmbarazo"><strong style="color: #000; font-size: 16px;">Embarazo número</strong></label>
            </div>
        </div>

        {{--  Embarazo planeado   --}}
        <div class="col s12 m6 l4">
            <label for="nacEmbarazoPlaneado"><strong style="color: #000; font-size: 16px;">Embarazo planeado</strong></label>
            <select id="nacEmbarazoPlaneado" class="browser-default" name="nacEmbarazoPlaneado" style="width: 100%;">
                @php                                  
                    if(old('nacEmbarazoPlaneado') !== null){
                        $nacEmbarazoPlaneado = old('nacEmbarazoPlaneado'); 
                    }
                    else{ $nacEmbarazoPlaneado = $embarazo->nacEmbarazoPlaneado; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $nacEmbarazoPlaneado == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $nacEmbarazoPlaneado == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  Embarazo a término   --}}
        <div class="col s12 m6 l4">
            <label for="nacEmbarazoTermino"><strong style="color: #000; font-size: 16px;">Embarazo a término</strong></label>
            <select id="nacEmbarazoTermino" class="browser-default" name="nacEmbarazoTermino" style="width: 100%;">
                @php                                  
                    if(old('nacEmbarazoTermino') !== null){
                        $nacEmbarazoTermino = old('nacEmbarazoTermino'); 
                    }
                    else{ $nacEmbarazoTermino = $embarazo->nacEmbarazoTermino; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $nacEmbarazoTermino == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $nacEmbarazoTermino == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
    </div>

    <div class="row">
        {{--  Duración del embarazo   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('nacEmbarazoDuracion') !== null){
                        $nacEmbarazoDuracion = old('nacEmbarazoDuracion'); 
                    }
                    else{ $nacEmbarazoDuracion = $embarazo->nacEmbarazoDuracion; }
                @endphp
            <label for="nacEmbarazoDuracion"><strong style="color: #000; font-size: 16px;">Duración del embarazo</strong></label>
            {!! Form::text('nacEmbarazoDuracion', $nacEmbarazoDuracion, array('id' => 'nacEmbarazoDuracion', 'class' => 'validate', 'maxlength'=>'40')) !!}
            </div>
        </div>

        {{--  Parto   --}}
        <div class="col s12 m6 l4">
            <label for="NacParto"><strong style="color: #000; font-size: 16px;">Parto</strong></label>
            <select id="NacParto" class="browser-default validate select2" name="NacParto" style="width: 100%;">
                @php                                  
                    if(old('NacParto') !== null){
                        $NacParto = old('NacParto'); 
                    }
                    else{ $NacParto = $embarazo->NacParto; }
                @endphp
                <option value="" disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="NATURAL" {{ $NacParto == "NATURAL" ? 'selected="selected"' : '' }}>Natural</option>
                <option value="CESÁREA" {{ $NacParto == "CESÁREA" ? 'selected="selected"' : '' }}>Cesárea</option>
                <option value="FÓRCEPS" {{ $NacParto == "FÓRCEPS" ? 'selected="selected"' : '' }}>Fórceps</option>              

            </select>
        </div>

        {{--  peso al nacer   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('nacPeso') !== null){
                        $nacPeso = old('nacPeso'); 
                    }
                    else{ $nacPeso = $embarazo->nacPeso; }
                @endphp
                {!! Form::text('nacPeso', $nacPeso, array('id' => 'nacPeso', 'class' => 'validate','maxlength'=>'20')) !!}
                <label for="nacPeso"><strong style="color: #000; font-size: 16px;">Peso al nacer</strong></label>
            </div>
        </div>
    </div>


    <div class="row">
        {{--  medida al nacer   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('nacMedia') !== null){
                        $nacMedia = old('nacMedia'); 
                    }
                    else{ $nacMedia = $embarazo->nacMedia; }
                @endphp
                {!! Form::text('nacMedia', $nacMedia, array('id' => 'nacMedia', 'class' => 'validate','maxlength'=>'20')) !!}
                <label for="nacMedia"><strong style="color: #000; font-size: 16px;">Medida al nacer</strong></label>
            </div>
        </div>

        {{--  APGAR  --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('nacApgar') !== null){
                        $nacApgar = old('nacApgar'); 
                    }
                    else{ $nacApgar = $embarazo->nacApgar; }
                @endphp
                {!! Form::text('nacApgar', $nacApgar, array('id' => 'nacApgar', 'class' => 'validate','maxlength'=>'255')) !!}
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
            <select id="nacComplicacionesEmbarazo" class="browser-default" name="nacComplicacionesEmbarazo" style="width: 100%;">
                @php                                  
                    if(old('nacComplicacionesEmbarazo') !== null){
                        $nacComplicacionesEmbarazo = old('nacComplicacionesEmbarazo'); 
                    }
                    else{ $nacComplicacionesEmbarazo = $embarazo->nacComplicacionesEmbarazo; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $nacComplicacionesEmbarazo == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $nacComplicacionesEmbarazo == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  cuales durante el embarazo  --}}
        <div class="col s12 m6 l8" id="divEmbarazo" style="display: none;">
            <div class="input-field">
                @php                                  
                    if(old('nacCualesEmbarazo') !== null){
                        $nacCualesEmbarazo = old('nacCualesEmbarazo'); 
                    }
                    else{ $nacCualesEmbarazo = $embarazo->nacCualesEmbarazo; }
                @endphp
                {!! Form::text('nacCualesEmbarazo', $nacCualesEmbarazo, array('id' => 'nacCualesEmbarazo', 'class' => 'validate','maxlength'=>'255')) !!}
                <label for="nacCualesEmbarazo"><strong style="color: #000; font-size: 16px;">¿Cuáles durante el embarazo?</strong></label>
            </div>
        </div>       
    </div>

    <div class="row">
        {{--  durante el parto   --}}
        <div class="col s12 m6 l4">
            <label for="nacComplicacionesParto"><strong style="color: #000; font-size: 16px;">Durante el parto</strong></label>
            <select id="nacComplicacionesParto" class="browser-default" name="nacComplicacionesParto" style="width: 100%;">
                @php                                  
                    if(old('nacComplicacionesParto') !== null){
                        $nacComplicacionesParto = old('nacComplicacionesParto'); 
                    }
                    else{ $nacComplicacionesParto = $embarazo->nacComplicacionesParto; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $nacComplicacionesParto == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $nacComplicacionesParto == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  cuales durante el parto  --}}
        <div class="col s12 m6 l8" id="divParto" style="display: none;">
            <div class="input-field">
                @php                                  
                    if(old('nacCualesParto') !== null){
                        $nacCualesParto = old('nacCualesParto'); 
                    }
                    else{ $nacCualesParto = $embarazo->nacCualesParto; }
                @endphp
                {!! Form::text('nacCualesParto', $nacCualesParto, array('id' => 'nacCualesParto', 'class' => 'validate','maxlength'=>'255')) !!}
                <label for="nacCualesParto"><strong style="color: #000; font-size: 16px;">¿Cuáles durante el parto?</strong></label>
            </div>
        </div>       
    </div>

    <div class="row">
        {{--  despues del nacimiento   --}}
        <div class="col s12 m6 l4">
            <label for="nacComplicacionDespues"><strong style="color: #000; font-size: 16px;">Después del nacimiento</strong></label>
            <select id="nacComplicacionDespues" class="browser-default" name="nacComplicacionDespues" style="width: 100%;">
                @php                                  
                    if(old('nacComplicacionDespues') !== null){
                        $nacComplicacionDespues = old('nacComplicacionDespues'); 
                    }
                    else{ $nacComplicacionDespues = $embarazo->nacComplicacionDespues; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $nacComplicacionDespues == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $nacComplicacionDespues == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  despues del nacimiento cuales  --}}
        <div class="col s12 m6 l8" id="divDespues" style="display: none;">
            <div class="input-field">
                @php                                  
                    if(old('nacCualesDespues') !== null){
                        $nacCualesDespues = old('nacCualesDespues'); 
                    }
                    else{ $nacCualesDespues = $embarazo->nacCualesDespues; }
                @endphp
                {!! Form::text('nacCualesDespues', $embarazo->nacCualesDespues, array('id' => 'nacCualesDespues', 'class' => 'validate','maxlength'=>'255')) !!}
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
            <select id="nacLactancia" class="browser-default" name="nacLactancia" style="width: 100%;">
                @php                                  
                    if(old('nacLactancia') !== null){
                        $nacLactancia = old('nacLactancia'); 
                    }
                    else{ $nacLactancia = $embarazo->nacLactancia; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="FÓRMULA" {{ $nacLactancia == "FÓRMULA" ? 'selected="selected"' : '' }}>Fórmula</option>
                <option value="MATERNA" {{ $nacLactancia == "MATERNA" ? 'selected="selected"' : '' }}>Materna</option>
                <option value="MIXTA" {{ $nacLactancia == "MIXTA" ? 'selected="selected"' : '' }}>Mixta</option>
            </select>
        </div>

        {{--  despues del nacimiento cuales  --}}
        <div class="col s12 m6 l8" id="divLactancia" style="display: none;">
            <div class="input-field">
                @php                                  
                    if(old('nacActualmente') !== null){
                        $nacActualmente = old('nacActualmente'); 
                    }
                    else{ $nacActualmente = $embarazo->nacActualmente; }
                @endphp
                {!! Form::text('nacActualmente', $nacActualmente, array('id' => 'nacActualmente', 'class' => 'validate','maxlength'=>'255')) !!}
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
        $("#nacActualmente").prop('required', false);
    }else{
        $("#nacActualmente").prop('required', false);
        $("#divLactancia").hide();         
    }
</script>