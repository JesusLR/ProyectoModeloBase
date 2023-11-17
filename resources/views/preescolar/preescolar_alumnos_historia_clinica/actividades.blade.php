<div id="actividades">
    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">ACTIVIDADES QUE REALIZA </p>
    </div>

    <div class="row">
        {{-- ¿Ordena los juguetes? --}}
        <div class="col s12 m6 l4">
            {!! Form::label('actJuguete', '¿Ordena los juguetes?', array('class' => '')); !!}
            <select id="actJuguete" class="browser-default" name="actJuguete" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $actividad->actJuguete == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $actividad->actJuguete == "NO" ? 'selected="selected"' : '' }}>NO</option>      
                <option value="SOLO SI SE LE PIDE" {{ $actividad->actJuguete == "SOLO SI SE LE PIDE" ? 'selected="selected"' : '' }}>Solo si se le pide</option>         
            </select>
        </div>
        {{-- ¿Le gustan los cuentos? --}}
        <div class="col s12 m6 l4">
            {!! Form::label('actCuento', '¿Le gustan los cuentos?', array('class' => '')); !!}
            <select id="actCuento" class="browser-default" name="actCuento" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $actividad->actCuento == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $actividad->actCuento == "NO" ? 'selected="selected"' : '' }}>NO</option>          
            </select>
        </div>
        {{-- ¿Le gustan las películas? --}}
        <div class="col s12 m6 l4">
            {!! Form::label('actPelicula', '¿Le gustan las películas?', array('class' => '')); !!}
            <select id="actPelicula" class="browser-default" name="actPelicula" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $actividad->actPelicula == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $actividad->actPelicula == "NO" ? 'selected="selected"' : '' }}>NO</option>      
            </select>
        </div>
    </div>

    <div class="row">
        {{-- ¿Cuántas horas al día ve televisión? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::label('actHorasTelevision', '¿Cuántas horas al día ve televisión?', array('class' => '')); !!}
                {!! Form::text('actHorasTelevision', $actividad->actHorasTelevision, array('id' => 'actHorasTelevision', 'class' =>
                'validate','maxlength'=>'20')) !!}
            </div>
        </div>
        {{-- ¿Utiliza tablet, celular o consola de videojuegos? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::label('actTenologia', '¿Utiliza tablet, celular o consola de videojuegos?', array('class' => '')); !!}
                {!! Form::text('actTenologia', $actividad->actTenologia, array('id' => 'actTenologia', 'class' =>
                'validate','maxlength'=>'80')) !!}
            </div>
        </div>
        {{-- ¿Qué tipo de juguetes, juegos o temáticas disfruta? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::label('actTipoJuguetes', '¿Qué tipo de juguetes, juegos o temáticas disfruta?', array('class' => '')); !!}
                {!! Form::text('actTipoJuguetes', $actividad->actTipoJuguetes, array('id' => 'actTipoJuguetes', 'class' =>
                'validate','maxlength'=>'80')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ¿Quién apoya o apoyaría a su hijo en las tareas? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::label('actApoyoTarea', '¿Quién apoya o apoyaría a su hijo en las tareas?', array('class' => '')); !!}
                {!! Form::text('actApoyoTarea', $actividad->actApoyoTarea, array('id' => 'actApoyoTarea', 'class' =>
                'validate','maxlength'=>'80')) !!}
            </div>
        </div>
        {{-- ¿Quién está a cargo de su cuidado en las tardes? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::label('actCuidado', '¿Quién está a cargo de su cuidado en las tardes?', array('class' => '')); !!}
                {!! Form::text('actCuidado', $actividad->actCuidado, array('id' => 'actCuidado', 'class' =>
                'validate','maxlength'=>'80')) !!}
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
                {!! Form::label('actObservacionExtra', 'Alguna observación que le gustaría dar a conocer', array('class' => '')); !!}
                {!! Form::text('actObservacionExtra', $actividad->actObservacionExtra, array('id' => 'actObservacionExtra', 'class' =>
                'validate')) !!}
            </div>
        </div>
    </div>

    <br><br>
    <div class="row">
        {{-- Grado sugerido --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::label('actGradoSugerido', 'Grado sugerido*', array('class' => '')); !!}
                {!! Form::text('actGradoSugerido', $actividad->actGradoSugerido, array('id' => 'actGradoSugerido', 'class' =>
                'validate','maxlength'=>'15')) !!}
            </div>
        </div>
        {{-- Grado elegido --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::label('actGradoElegido', 'Grado elegido*', array('class' => '')); !!}
                {!! Form::text('actGradoElegido', $actividad->actGradoElegido, array('id' => 'actGradoElegido', 'class' =>
                'validate','maxlength'=>'15')) !!}
            </div>
        </div>
        {{-- Nombre de quién realizó la entrevista --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                {!! Form::label('actNombreEntrevista', 'Nombre de quién realizó la entrevista*', array('class' => '')); !!}
                {!! Form::text('actNombreEntrevista', $actividad->actNombreEntrevista, array('id' => 'actNombreEntrevista', 'class' =>
                'validate','maxlength'=>'140')) !!}
            </div>
        </div>
    </div>
</div>