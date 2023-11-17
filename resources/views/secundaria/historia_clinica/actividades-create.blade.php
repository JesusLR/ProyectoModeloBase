<div id="actividades">
    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">ACTIVIDADES QUE REALIZA </p>
    </div>

    <div class="row">
        {{-- ¿Ordena los juguetes? --}}
        <div class="col s12 m6 l4">
            <label for="actJuguete"><strong style="color: #000; font-size: 16px;">¿Ordena los juguetes?</strong></label>
            <select id="actJuguete" class="browser-default" name="actJuguete" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('actJuguete') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('actJuguete') == "NO" ? 'selected' : '' }}>NO</option>      
                <option value="SOLO SI SE LE PIDE" {{ old('actJuguete') == "SOLO SI SE LE PIDE" ? 'selected' : '' }}>Solo si se le pide</option>         
            </select>
        </div>
        {{-- ¿Le gustan los cuentos? --}}
        <div class="col s12 m6 l4">
            <label for="actCuento"><strong style="color: #000; font-size: 16px;">¿Le gustan los cuentos?</strong></label>
            <select id="actCuento" class="browser-default" name="actCuento" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('actCuento') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('actCuento') == "NO" ? 'selected' : '' }}>NO</option>          
            </select>
        </div>
        {{-- ¿Le gustan las películas? --}}
        <div class="col s12 m6 l4">
            <label for="actPelicula"><strong style="color: #000; font-size: 16px;">¿Le gustan las películas?</strong></label>
            <select id="actPelicula" class="browser-default" name="actPelicula" style="width: 100%;" required>
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ old('actPelicula') == "SI" ? 'selected' : '' }}>SI</option>
                <option value="NO" {{ old('actPelicula') == "NO" ? 'selected' : '' }}>NO</option>      
            </select>
        </div>
    </div>

    <div class="row">
        {{-- ¿Cuántas horas al día ve televisión? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="actHorasTelevision"><strong style="color: #000; font-size: 16px;">¿Cuántas horas al día ve televisión?</strong></label>
                {!! Form::text('actHorasTelevision', old('actHorasTelevision'), array('id' => 'actHorasTelevision', 'class' =>
                'validate','maxlength'=>'20')) !!}
            </div>
        </div>
        {{-- ¿Utiliza tablet, celular o consola de videojuegos? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="actTenologia"><strong style="color: #000; font-size: 16px;">¿Utiliza tablet, celular o consola de videojuegos?</strong></label>
                {!! Form::text('actTenologia', old('actTenologia'), array('id' => 'actTenologia', 'class' =>
                'validate','maxlength'=>'80', 'required')) !!}
            </div>
        </div>
        {{-- ¿Qué tipo de juguetes, juegos o temáticas disfruta? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="actTipoJuguetes"><strong style="color: #000; font-size: 16px;">¿Qué tipo de juguetes, juegos o temáticas disfruta?</strong></label>
                {!! Form::text('actTipoJuguetes', old('actTipoJuguetes'), array('id' => 'actTipoJuguetes', 'class' =>
                'validate','maxlength'=>'80', 'required')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ¿Quién apoya o apoyaría a su hijo en las tareas? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="actApoyoTarea"><strong style="color: #000; font-size: 16px;">¿Quién apoya o apoyaría a su hijo en las tareas?</strong></label>
                {!! Form::text('actApoyoTarea', old('actApoyoTarea'), array('id' => 'actApoyoTarea', 'class' =>
                'validate','maxlength'=>'80', 'required')) !!}
            </div>
        </div>
        {{-- ¿Quién está a cargo de su cuidado en las tardes? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="actCuidado"><strong style="color: #000; font-size: 16px;">¿Quién está a cargo de su cuidado en las tardes?</strong></label>
                {!! Form::text('actCuidado', old('actCuidado'), array('id' => 'actCuidado', 'class' =>
                'validate','maxlength'=>'80', 'required')) !!}
            </div>
        </div>
    </div>

    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">INFORMACIÓN ADICIONAL Y ACUERDOS</p>
    </div>
    <div class="row">
        {{-- Alguna observación que le gustaría dar a conocer: --}}
        <div class="col s12 m6 l12">
            <div class="input-field">
                <label for="actObservacionExtra"><strong style="color: #000; font-size: 16px;">Alguna observación que le gustaría dar a conocer</strong></label>
                {!! Form::text('actObservacionExtra', old('actObservacionExtra'), array('id' => 'actObservacionExtra', 'class' =>
                'validate')) !!}
            </div>
        </div>
    </div>

    <br><br>
    <div class="row">
        {{-- Grado sugerido --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="actGradoSugerido"><strong style="color: #000; font-size: 16px;">Grado sugerido</strong></label>
                {!! Form::text('actGradoSugerido', old('actGradoSugerido'), array('id' => 'actGradoSugerido', 'class' =>
                'validate','maxlength'=>'15', 'required')) !!}
            </div>
        </div>
        {{-- Grado elegido --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="actGradoElegido"><strong style="color: #000; font-size: 16px;">Grado elegido</strong></label>
                {!! Form::text('actGradoElegido', old('actGradoElegido'), array('id' => 'actGradoElegido', 'class' =>
                'validate','maxlength'=>'15', 'required')) !!}
            </div>
        </div>
        {{-- Nombre de quién realizó la entrevista --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                <label for="actNombreEntrevista"><strong style="color: #000; font-size: 16px;">Nombre de quién realizó la entrevista</strong></label>
                {!! Form::text('actNombreEntrevista', $nombreEntrevistador, 
                array('id' => 'actNombreEntrevista', 'class' =>
                'validate','maxlength'=>'120', 'required', 'readonly')) !!}
            </div>
        </div>
    </div>
</div>