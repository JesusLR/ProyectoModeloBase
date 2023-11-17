<div id="actividades">
    <br>
    <div class="row" style="background-color:#ECECEC;">
        <p style="text-align: center;font-size:1.2em;">ACTIVIDADES QUE REALIZA </p>
    </div>

    <div class="row">
        {{-- ¿Ordena los juguetes? --}}
        <div class="col s12 m6 l4">
            <label for="actJuguete"><strong style="color: #000; font-size: 16px;">¿Ordena los juguetes?</strong></label>
            <select id="actJuguete" class="browser-default" name="actJuguete" style="width: 100%;">
                @php                                  
                    if(old('actJuguete') !== null){
                        $actJuguete = old('actJuguete'); 
                    }
                    else{ $actJuguete = $actividad->actJuguete; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $actividad->actJuguete == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $actividad->actJuguete == "NO" ? 'selected="selected"' : '' }}>NO</option>      
                <option value="SOLO SI SE LE PIDE" {{ $actJuguete == "SOLO SI SE LE PIDE" ? 'selected="selected"' : '' }}>Solo si se le pide</option>         
            </select>
        </div>
        {{-- ¿Le gustan los cuentos? --}}
        <div class="col s12 m6 l4">
            <label for="actCuento"><strong style="color: #000; font-size: 16px;">¿Le gustan los cuentos?</strong></label>
            <select id="actCuento" class="browser-default" name="actCuento" style="width: 100%;">
                @php                                  
                    if(old('actCuento') !== null){
                        $actCuento = old('actCuento'); 
                    }
                    else{ $actCuento = $actividad->actCuento; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $actCuento == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $actCuento == "NO" ? 'selected="selected"' : '' }}>NO</option>          
            </select>
        </div>
        {{-- ¿Le gustan las películas? --}}
        <div class="col s12 m6 l4">
            <label for="actPelicula"><strong style="color: #000; font-size: 16px;">¿Le gustan las películas?</strong></label>
            <select id="actPelicula" class="browser-default" name="actPelicula" style="width: 100%;">
                @php                                  
                    if(old('actPelicula') !== null){
                        $actPelicula = old('actPelicula'); 
                    }
                    else{ $actPelicula = $actividad->actPelicula; }
                @endphp
                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                <option value="SI" {{ $actPelicula == "SI" ? 'selected="selected"' : '' }}>SI</option>
                <option value="NO" {{ $actPelicula == "NO" ? 'selected="selected"' : '' }}>NO</option>      
            </select>
        </div>
    </div>

    <div class="row">
        {{-- ¿Cuántas horas al día ve televisión? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('actHorasTelevision') !== null){
                        $actHorasTelevision = old('actHorasTelevision'); 
                    }
                    else{ $actHorasTelevision = $actividad->actHorasTelevision; }
                @endphp
                <label for="actHorasTelevision"><strong style="color: #000; font-size: 16px;">¿Cuántas horas al día ve televisión?</strong></label>
                {!! Form::text('actHorasTelevision', $actHorasTelevision, array('id' => 'actHorasTelevision', 'class' =>
                'validate','maxlength'=>'20')) !!}
            </div>
        </div>
        {{-- ¿Utiliza tablet, celular o consola de videojuegos? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('actTenologia') !== null){
                        $actTenologia = old('actTenologia'); 
                    }
                    else{ $actTenologia = $actividad->actTenologia; }
                @endphp
                <label for="actTenologia"><strong style="color: #000; font-size: 16px;">¿Utiliza tablet, celular o consola de videojuegos?</strong></label>
                {!! Form::text('actTenologia', $actTenologia, array('id' => 'actTenologia', 'class' =>
                'validate','maxlength'=>'80')) !!}
            </div>
        </div>
        {{-- ¿Qué tipo de juguetes, juegos o temáticas disfruta? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('actTipoJuguetes') !== null){
                        $actTipoJuguetes = old('actTipoJuguetes'); 
                    }
                    else{ $actTipoJuguetes = $actividad->actTipoJuguetes; }
                @endphp
                <label for="actTipoJuguetes"><strong style="color: #000; font-size: 16px;">¿Qué tipo de juguetes, juegos o temáticas disfruta?</strong></label>
                {!! Form::text('actTipoJuguetes', $actTipoJuguetes, array('id' => 'actTipoJuguetes', 'class' =>
                'validate','maxlength'=>'80')) !!}
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ¿Quién apoya o apoyaría a su hijo en las tareas? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('actApoyoTarea') !== null){
                        $actApoyoTarea = old('actApoyoTarea'); 
                    }
                    else{ $actApoyoTarea = $actividad->actApoyoTarea; }
                @endphp
                <label for="actApoyoTarea"><strong style="color: #000; font-size: 16px;">¿Quién apoya o apoyaría a su hijo en las tareas?</strong></label>
                {!! Form::text('actApoyoTarea', $actApoyoTarea, array('id' => 'actApoyoTarea', 'class' =>
                'validate','maxlength'=>'80')) !!}
            </div>
        </div>
        {{-- ¿Quién está a cargo de su cuidado en las tardes? --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('actCuidado') !== null){
                        $actCuidado = old('actCuidado'); 
                    }
                    else{ $actCuidado = $actividad->actCuidado; }
                @endphp
                <label for="actCuidado"><strong style="color: #000; font-size: 16px;">¿Quién está a cargo de su cuidado en las tardes?</strong></label>
                {!! Form::text('actCuidado', $actCuidado, array('id' => 'actCuidado', 'class' =>
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
                @php                                  
                    if(old('actObservacionExtra') !== null){
                        $actObservacionExtra = old('actObservacionExtra'); 
                    }
                    else{ $actObservacionExtra = $actividad->actObservacionExtra; }
                @endphp
                <label for="actObservacionExtra"><strong style="color: #000; font-size: 16px;">Alguna observación que le gustaría dar a conocer</strong></label>
                {!! Form::text('actObservacionExtra', $actObservacionExtra, array('id' => 'actObservacionExtra', 'class' =>
                'validate')) !!}
            </div>
        </div>
    </div>

    <br><br>
    <div class="row">
        {{-- Grado sugerido --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('actGradoSugerido') !== null){
                        $actGradoSugerido = old('actGradoSugerido'); 
                    }
                    else{ $actGradoSugerido = $actividad->actGradoSugerido; }
                @endphp
                <label for="actGradoSugerido"><strong style="color: #000; font-size: 16px;">Grado sugerido</strong></label>
                {!! Form::text('actGradoSugerido', $actGradoSugerido, array('id' => 'actGradoSugerido', 'class' =>
                'validate','maxlength'=>'15')) !!}
            </div>
        </div>
        {{-- Grado elegido --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('actGradoElegido') !== null){
                        $actGradoElegido = old('actGradoElegido'); 
                    }
                    else{ $actGradoElegido = $actividad->actGradoElegido; }
                @endphp
                <label for="actGradoElegido"><strong style="color: #000; font-size: 16px;">Grado elegido</strong></label>

                {!! Form::text('actGradoElegido', $actGradoElegido, array('id' => 'actGradoElegido', 'class' =>
                'validate','maxlength'=>'15')) !!}
            </div>
        </div>
        {{-- Nombre de quién realizó la entrevista --}}
        <div class="col s12 m6 l4">
            <div class="input-field">
                @php                                  
                    if(old('actNombreEntrevista') !== null){
                        $actNombreEntrevista = old('actNombreEntrevista'); 
                    }
                    else{ $actNombreEntrevista = $actividad->actNombreEntrevista; }
                @endphp
                <label for="actNombreEntrevista"><strong style="color: #000; font-size: 16px;">Nombre de quién realizó la entrevista *</strong></label>
                {!! Form::text('actNombreEntrevista', $actNombreEntrevista, array('id' => 'actNombreEntrevista', 'class' =>
                'validate','maxlength'=>'120')) !!}
            </div>
        </div>
    </div>
</div>