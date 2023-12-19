<script type="text/javascript">
    $(document).ready(function() {

      $("#programa_id").change( event => {

          var plan_id = $("#plan_id").val();
          var grado = $("#grado").val();

          

      
          $.get(base_url+`/primaria_campos_formativos_materias/obtenerMaterias/${event.target.value}/${plan_id}/${grado}`,function(res,sta){
              //seleccionar el post preservado
              var materiaSeleccionadoOld = $("#primaria_materia_id").data("primaria-materia-id")
              $("#primaria_materia_id").empty();
              $("#primaria_materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

              res.forEach(element => {
                  var selected = "";
                  if (element.id === materiaSeleccionadoOld) {
                      console.log("entra")
                      console.log(element.id)
                      selected = "selected";
                  }

                  $("#primaria_materia_id").append(`<option value=${element.id} ${selected}>${element.matClave}-${element.matNombre}</option>`);
              });

              $('#primaria_materia_id').trigger('change'); // Notify only Select2 of changes
          });
      });

   });
</script>


<script type="text/javascript">
    $(document).ready(function() {

      $("#plan_id").change( event => {
          var programa_id = $("#programa_id").val();
          var grado = $("#grado").val();

      
          $.get(base_url+`/primaria_campos_formativos_materias/obtenerMaterias/${programa_id}/${event.target.value}/${grado}`,function(res,sta){
              //seleccionar el post preservado
              var materiaSeleccionadoOld = $("#primaria_materia_id").data("primaria-materia-id")
              $("#primaria_materia_id").empty();
              $("#primaria_materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

              res.forEach(element => {
                  var selected = "";
                  if (element.id === materiaSeleccionadoOld) {
                      console.log("entra")
                      console.log(element.id)
                      selected = "selected";
                  }

                  $("#primaria_materia_id").append(`<option value=${element.id} ${selected}>${element.matClave}-${element.matNombre}</option>`);
              });

              $('#primaria_materia_id').trigger('change'); // Notify only Select2 of changes
          });
      });

   });
</script>

<script type="text/javascript">
    $(document).ready(function() {

      $("#grado").change( event => {
          var programa_id = $("#programa_id").val();
          var plan_id = $("#plan_id").val();

      
          $.get(base_url+`/primaria_campos_formativos_materias/obtenerMaterias/${programa_id}/${plan_id}/${event.target.value}`,function(res,sta){
              //seleccionar el post preservado
              var materiaSeleccionadoOld = $("#primaria_materia_id").data("primaria-materia-id")
              $("#primaria_materia_id").empty();
              $("#primaria_materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

              res.forEach(element => {
                  var selected = "";
                  if (element.id === materiaSeleccionadoOld) {
                      console.log("entra")
                      console.log(element.id)
                      selected = "selected";
                  }

                  $("#primaria_materia_id").append(`<option value=${element.id} ${selected}>${element.matClave}-${element.matNombre}</option>`);
              });

              $('#primaria_materia_id').trigger('change'); // Notify only Select2 of changes
          });
      });

   });
</script>



<script>
    var grado = $("#grado").val();
    var programa_id = $("#programa_id").val();
          var plan_id = $("#plan_id").val();

      
          $.get(base_url+`/primaria_campos_formativos_materias/obtenerMaterias/${programa_id}/${plan_id}/${grado}`,function(res,sta){
              //seleccionar el post preservado
              var materiaSeleccionadoOld = $("#primaria_materia_id").data("primaria-materia-id")
              $("#primaria_materia_id").empty();
              //$("#primaria_materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

              res.forEach(element => {
                  var selected = "";
                  if (element.id == materiaSeleccionadoOld) {
                      console.log("entra")
                      console.log(element.id)
                      selected = "selected";
                  }

                  $("#primaria_materia_id").append(`<option value="${element.id}" ${selected}>${element.matClave}-${element.matNombre}</option>`);
              });

              $('#primaria_materia_id').trigger('change'); // Notify only Select2 of changes
          });
</script>