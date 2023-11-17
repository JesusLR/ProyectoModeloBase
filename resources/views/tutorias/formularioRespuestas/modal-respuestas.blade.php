<div id="modalRespuestas" dismissible="true" class="modal modal-fixed-footer" style="max-width:30%;" >
    <div class="modal-content">
        <h4>Respuestas</h4>
        <p><strong id="nombrePregunta"></strong></p>

        <div id="respuestas"></div>

        <br>
        <br>
        <br>

        <p><strong id="notifications"></strong></p>

    </div>
    <div class="modal-footer">
        <button onclick="limpiar();" class="modal-close waves-effect waves-green btn-flat">Cerrar</button>
    </div>
</div>

<script>
    function limpiar(){
        document.getElementById("respuestas").innerHTML = "";
        document.getElementById("nombrePregunta").innerHTML = "";
      }

</script>

<style>
    .modal {
        max-height: 60%;
        max-width:35%;
      }
</style>