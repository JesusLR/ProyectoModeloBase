<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER MATERIAS POR SEMESTRE SELECCIONADO
        $("#gpoSemestre").change( event => {
            var plan_id = $("#plan_id").val();
            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_grupo_uady/materias/${event.target.value}/${plan_id}`,function(res,sta){
                var materiaSeleccionadoOld = $("#materia_id").data("materia-id");

                res.forEach(element => {
                        var selected = "";
                        if (element.id === materiaSeleccionadoOld) {
                            selected = "selected";
                        }
                    $("#materia_id").append(`<option value=${element.id} ${selected}>${element.matClave}-${element.matNombre}</option>`);
                });
            });
        });

        $("#plan_id").change( event => {
            var gpoSemestre = $("#gpoSemestre").val();
            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_grupo_uady/materias/${gpoSemestre}/${event.target.value}`,function(res,sta){
                var materiaSeleccionadoOld = $("#materia_id").data("materia-id");

                res.forEach(element => {
                    var selected = "";
                        if (element.id === materiaSeleccionadoOld) {
                            selected = "selected";
                        }
                    $("#materia_id").append(`<option value=${element.id} ${selected}>${element.matClave}-${element.matNombre}</option>`);
                });
            });
        });

     });
</script>