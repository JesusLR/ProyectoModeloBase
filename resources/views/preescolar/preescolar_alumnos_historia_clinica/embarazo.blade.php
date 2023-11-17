<div id="embarazo">

    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">HISTORIAL DEL EMBARAZO Y DEL NACIMIENTO</p>
    </div>
    <div class="row">
        {{--  Embarazo número   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::number('nacNumEmbarazo', $embarazo->nacNumEmbarazo, array('id' => 'nacNumEmbarazo', 'class' => 'validate'
                ,'min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==4) return false;"')) !!}
                {!! Form::label('nacNumEmbarazo', 'Embarazo número', array('class' => '')); !!}
            </div>
        </div>

        {{--  Embarazo planeado   --}}
        <div class="col s12 m6 l4">
            {!! Form::label('nacEmbarazoPlaneado', 'Embarazo planeado',
            array('class' =>
            '')); !!}
            <select id="nacEmbarazoPlaneado" class="browser-default" name="nacEmbarazoPlaneado"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $embarazo->nacEmbarazoPlaneado == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $embarazo->nacEmbarazoPlaneado == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  Embarazo a término   --}}
        <div class="col s12 m6 l4">
            {!! Form::label('nacEmbarazoTermino', 'Embarazo a término', array('class' => '')); !!}
            <select id="nacEmbarazoTermino" class="browser-default" name="nacEmbarazoTermino"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $embarazo->nacEmbarazoTermino == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $embarazo->nacEmbarazoTermino == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>
    </div>

    <div class="row">
        {{--  Duración del embarazo   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
            {!! Form::label('nacEmbarazoDuracion', 'Duración del embarazo', array('class' => '')); !!}
            {!! Form::text('nacEmbarazoDuracion', $embarazo->nacEmbarazoDuracion, array('id' => 'nacEmbarazoDuracion', 'class' =>
            'validate', 'maxlength'=>'40')) !!}
            </div>
        </div>

        {{--  Parto   --}}
        <div class="col s12 m6 l4">
            {!! Form::label('NacParto', 'Parto', array('class' => '')); !!}
            <select id="NacParto" class="browser-default validate select2" name="NacParto"
                style="width: 100%;">
                <option value="" disabled>SELECCIONE UNA OPCIÓN</option>
                <option value="NATURAL" {{ $embarazo->NacParto == "NATURAL" ? 'selected="selected"' : '' }}>Natural</option>
                <option value="CESÁREA" {{ $embarazo->NacParto == "CESÁREA" ? 'selected="selected"' : '' }}>Cesárea</option>
                <option value="FÓRCEPS" {{ $embarazo->NacParto == "FÓRCEPS" ? 'selected="selected"' : '' }}>Fórceps</option>              

            </select>
        </div>

        {{--  peso al nacer   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('nacPeso', $embarazo->nacPeso, array('id' => 'nacPeso', 'class' =>
                'validate','maxlength'=>'20')) !!}
                {!! Form::label('nacPeso', 'Peso al nacer', array('class' => '')); !!}
            </div>
        </div>
    </div>


    <div class="row">
        {{--  medida al nacer   --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('nacMedia', $embarazo->nacMedia, array('id' => 'nacMedia', 'class' =>
                'validate','maxlength'=>'20')) !!}
                {!! Form::label('nacMedia', 'Medida al nacer', array('class' => '')); !!}
            </div>
        </div>

        {{--  APGAR  --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::text('nacApgar', $embarazo->nacApgar, array('id' => 'nacApgar', 'class' =>
                'validate','maxlength'=>'255')) !!}
                {!! Form::label('nacApgar', 'APGAR', array('class' => '')); !!}
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
            {!! Form::label('nacComplicacionesEmbarazo', 'Durante el embarazo', array('class' => '')); !!}
            <select id="nacComplicacionesEmbarazo" class="browser-default" name="nacComplicacionesEmbarazo"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $embarazo->nacComplicacionesEmbarazo == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $embarazo->nacComplicacionesEmbarazo == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  cuales durante el embarazo  --}}
        <div class="col s12 m6 l8" id="divEmbarazo" style="display: none;">
            <div class="input-field">
                {!! Form::text('nacCualesEmbarazo', $embarazo->nacCualesEmbarazo, array('id' => 'nacCualesEmbarazo', 'class' =>
                'validate','maxlength'=>'255')) !!}
                {!! Form::label('nacCualesEmbarazo', '¿Cuáles durante el embarazo?', array('class' => '')); !!}
            </div>
        </div>       
    </div>

    <div class="row">
        {{--  durante el parto   --}}
        <div class="col s12 m6 l4">
            {!! Form::label('nacComplicacionesParto', 'Durante el parto*',
            array('class' =>
            '')); !!}
            <select id="nacComplicacionesParto" class="browser-default" name="nacComplicacionesParto" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $embarazo->nacComplicacionesParto == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $embarazo->nacComplicacionesParto == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  cuales durante el parto  --}}
        <div class="col s12 m6 l8" id="divParto" style="display: none;">
            <div class="input-field">
                {!! Form::text('nacCualesParto', $embarazo->nacCualesParto, array('id' => 'nacCualesParto', 'class' => 'validate','maxlength'=>'255')) !!}
                {!! Form::label('nacCualesParto', '¿Cuáles durante el parto?', array('class' => '')); !!}
            </div>
        </div>       
    </div>

    <div class="row">
        {{--  despues del nacimiento   --}}
        <div class="col s12 m6 l4">
            {!! Form::label('nacComplicacionDespues', 'Después del nacimiento*', array('class' => '')); !!}
            <select id="nacComplicacionDespues" class="browser-default" name="nacComplicacionDespues"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $embarazo->nacComplicacionDespues == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $embarazo->nacComplicacionDespues == "NO" ? 'selected="selected"' : '' }}>NO</option>
            </select>
        </div>

        {{--  despues del nacimiento cuales  --}}
        <div class="col s12 m6 l8" id="divDespues" style="display: none;">
            <div class="input-field">
                {!! Form::text('nacCualesDespues', $embarazo->nacCualesDespues, array('id' => 'nacCualesDespues', 'class' =>
                'validate','maxlength'=>'255')) !!}
                {!! Form::label('nacCualesDespues', '¿Cuáles después del nacimiento?', array('class' => '')); !!}
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
            {!! Form::label('nacLactancia', 'Tipo de leche', array('class' => '')); !!}
            <select id="nacLactancia" class="browser-default" name="nacLactancia"
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="FÓRMULA" {{ $embarazo->nacLactancia == "FÓRMULA" ? 'selected="selected"' : '' }}>Fórmula</option>
                <option value="MATERNA" {{ $embarazo->nacLactancia == "MATERNA" ? 'selected="selected"' : '' }}>Materna</option>
                <option value="MIXTA" {{ $embarazo->nacLactancia == "MIXTA" ? 'selected="selected"' : '' }}>Mixta</option>
            </select>
        </div>

        {{--  despues del nacimiento cuales  --}}
        <div class="col s12 m6 l8" id="divLactancia" style="display: none;">
            <div class="input-field">
                {!! Form::text('nacActualmente', $embarazo->nacActualmente, array('id' => 'nacActualmente', 'class' =>
                'validate','maxlength'=>'255')) !!}
                {!! Form::label('nacActualmente', '¿Cuál?', array('class' => '')); !!}
            </div>
        </div>       
    </div>



</div> 
<script>
    if($('select[name=nacComplicacionesEmbarazo]').val() == "SI"){
        $("#divEmbarazo").show(); 
        $("#nacCualesEmbarazo").prop('required', false);
    }else{
        $("#nacCualesEmbarazo").prop('required', false);
        $("#divEmbarazo").hide();         
    }

    if($('select[name=nacComplicacionesParto]').val() == "SI"){
        $("#divParto").show(); 
        $("#nacCualesParto").prop('required', false);

    }else{
        $("#nacCualesParto").prop('required', false);
        $("#divParto").hide();         
    }


    if($('select[name=nacComplicacionDespues]').val() == "SI"){
        $("#divDespues").show(); 
        $("#nacCualesDespues").prop('required', false);

    }else{
        $("#nacCualesDespues").prop('required', false);
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