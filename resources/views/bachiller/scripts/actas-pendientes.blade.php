<script type="text/javascript">
  $(document).ready(function() {
      $("#actasPendientes").change(function(e) {
        e.preventDefault()

        if (e.target.value === "pendientesCapturar") {
          $(".chck-incluir-pendientes").hide()
          $(".chckincluirpendientes").prop('checked', false); 
        }
        if (e.target.value === "pendientesCerrar") {
          $(".chck-incluir-pendientes").show()
        
        }
        if (e.target.value === "cerradas") {
          $(".chck-incluir-pendientes").hide()
          $(".chckincluirpendientes").prop('checked', false); 
        }
      })
  });
</script>