<div id="addEvento" class="modal modal-fixed-footer">
    <div class="modal-content" >
        <h4 id="titulo"></h4>
        <h6 id="creador"></h6>
        <input type="text" style="display: none" id="id_evento" name="id_evento">   
        <div class="row">
            <div class="col s12 m6 l12">
                <div id="classTitle" class="input-field">
                    {!! Form::label('title', 'Título del evento*', array('class' => '')); !!}
                    {!! Form::text('title', NULL, array('id' => 'title', 'class' =>
                    'validate','required','maxlength'=>'255')) !!}
                </div>
            </div>
            <div class="col s12 m6 l12">
                <div id="classDescription" class="input-field">
                    {!! Form::label('description', 'Descripción del evento*', array('class' => '')); !!}
                    {!! Form::textarea('description', NULL, array('id' => 'description', 'class' =>
                    'materialize-textarea validate', 'validate','required', 'rows'=>'5', 'maxlength'=>'15000')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m6 l12">
                {!! Form::label('lugarEvento', 'Lugar/Aula del evento *', array('class' => '')); !!}
                {!! Form::text('lugarEvento', NULL, array('id' => 'lugarEvento', 'class' => 'validate','required','maxlength'=>'255')) !!}
            </div>
        </div>

        <div class="row">
            <div class="col s12 m6 l3">
                {!! Form::label('start', 'Fecha de inicio *', array('class' => '')); !!}
                {!! Form::date('start', NULL, array('id' => 'start', 'class' => ' validate','required')) !!}
            </div>
            <div class="col s12 m6 l3">
                {!! Form::label('hora-inicio', 'Hora de inicio *', array('class' => '')); !!}
                {!! Form::time('hora-inicio', NULL, array('id' => 'hora-inicio', 'class' => ' validate','required')) !!}
            </div>
            <div class="col s12 m6 l3">
                {!! Form::label('end', 'Fecha de termino *', array('class' => '')); !!}
                {!! Form::date('end', NULL, array('id' => 'end', 'class' => 'validate','required')) !!}
            </div>
            <div class="col s12 m6 l3">
                {!! Form::label('hora-fin', 'Hora final *', array('class' => '')); !!}
                {!! Form::time('hora-fin', NULL, array('id' => 'hora-fin', 'class' => ' validate','required')) !!}
            </div>
        </div>

        <div class="row">
            <div class="col s12 l4">
                <h6>Docentes que asistiran</h6>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l4">                
                {!! Form::label('primaria_empleado_id1', 'Docente 1 *', array('class' => '')); !!}
                <select id="primaria_empleado_id1"  class="browser-default validate select2" required name="primaria_empleado_id1"
                    style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach ($primaria_empleados as $primaria_empleado)
                        <option value="{{$primaria_empleado->id}}" {{ old('primaria_empleado_id1') == $primaria_empleado->id ? 'selected' : '' }}>{{$primaria_empleado->empApellido1.' '.$primaria_empleado->empApellido2.' '.$primaria_empleado->empNombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col s12 m6 l4">
                {!! Form::label('primaria_empleado_id2', 'Docente 2', array('class' => '')); !!}
                <select id="primaria_empleado_id2" class="browser-default validate select2" required name="primaria_empleado_id2"
                    style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach ($primaria_empleados as $primaria_empleado)
                        <option value="{{$primaria_empleado->id}}" {{ old('primaria_empleado_id2') == $primaria_empleado->id ? 'selected' : '' }}>{{$primaria_empleado->empApellido1.' '.$primaria_empleado->empApellido2.' '.$primaria_empleado->empNombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col s12 m6 l4">
                {!! Form::label('primaria_empleado_id3', 'Docente 3', array('class' => '')); !!}
                <select id="primaria_empleado_id3" class="browser-default validate select2" required name="primaria_empleado_id3"
                    style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach ($primaria_empleados as $primaria_empleado)
                        <option value="{{$primaria_empleado->id}}" {{ old('primaria_empleado_id3') == $primaria_empleado->id ? 'selected' : '' }}>{{$primaria_empleado->empApellido1.' '.$primaria_empleado->empApellido2.' '.$primaria_empleado->empNombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="height: 75px">
        <button id="btnCancelar" class="modal-action modal-close waves-effect waves-red btn-flat">Cancelar</button>
        {!! Form::button('<i class="material-icons left">save</i> Guardar', ['id'=>'btnAgregar','class' => 'btn-large
        waves-effect darken-3']) !!}
        {!! Form::button('<i class="material-icons left">save</i> Guardar', ['id'=>'btnEditar','class' => 'btn-large
        waves-effect darken-3']) !!}
        {!! Form::button('<i class="material-icons left">delete</i> Eliminar', ['id'=>'btnDelete','class' => 'btn-large
        waves-effect darken-3']) !!}

    </div>
    <br>
</div>

<script>
    $(document).ready(function(){
        $('.modal').modal();
    });
</script>