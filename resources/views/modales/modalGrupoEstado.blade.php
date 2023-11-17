{{-- MODAL GRUPO ESTADO --}}
<div id="modalGrupoEstado" class="modal">
  <div class="modal-content">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'grupo/estadoGrupo', 'method' => 'POST', 'class' => 'form-grupo-estado']) !!}
      <input type="hidden" value="" class="modalGrupoId" name="grupo_id">
      <div class="row">
        <div class="col s12 m12 l12">
          <h4>Cambiar estado del grupo</h4>
          <p style="font-weight: 700; margin-bottom: 0px;">(<span class="modalMateriaClave"></span>) <span class="modalMateriaNombre"></span></p>
          <p style="font-weight: 400; margin-bottom: 0px;">(<span class="modalProgClave"></span>) <span class="modalProgNombre"></span></p>
          <p style="font-weight: 400; margin-bottom: 0px;">Período <span class="modalPerNumero"></span>/<span class="modalPerAnio"></span></p>
          <p style="font-weight: 400; margin-bottom: 0px;">Estado Actual: <span class="modalEstado"></span></p>
        </div>
      </div>

      <div class="row">
        
        <!-- AQUI VA SELECT2 -->
        <div class="ol s12 m12 l12">
          {!! Form::label('estado_act', 'Nuevo estado del grupo', array('class' => '')); !!}
          <select id="estado_act" class="browser-default validate " required name="estado_act" style="width: 100%;" required>
              <option value="" selected>SELECCIONE UNA OPCIÓN</option>
              <option value="A">Abierto</option>
              <option value="B">Abierto con calificación</option>
              <option value="C">Cerrado</option>
          </select>
        </div>
      </div>
      
      <div class="row">
        <div class="col s12 m12 l12">
          {!! Form::button('<i class="material-icons left">save</i> GUARDAR', [
            'class' => 'btn-large waves-effect  darken-3 confirmar-grupo-estado','type' => 'submit'
          ]) !!}
        </div>
      </div>



    {!! Form::close() !!}
  </div>
  <div class="modal-footer">
      <button type="button" class="modal-close waves-effect waves-green btn-flat">Cerrar</button>
  </div>
</div>