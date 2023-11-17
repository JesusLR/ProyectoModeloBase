<script type="text/javascript">
  $(document).ready(function() {
      $("#tipoPdf").change(function(e) {
        e.preventDefault()


        console.log(e.target.value === "E");

        if (e.target.value === "E" || e.target.value === "ECA" ) {
          $("#escClave").prop("required", true).addClass("validate");

          $("#perNumero").prop("required", false).removeClass("validate").removeClass("invalid");
          $("#perAnio").prop("required", false).removeClass("validate").removeClass("invalid");
          $("#progClave").prop("required", false).removeClass("validate").removeClass("invalid");
        } else {
          $("#escClave").prop("required", false).removeClass("validate").removeClass("invalid");

          $("#perNumero").prop("required", true).addClass("validate");
          $("#perAnio").prop("required", true).addClass("validate");
          $("#progClave").prop("required", true).addClass("validate");
        }
        
      })
  });
</script>