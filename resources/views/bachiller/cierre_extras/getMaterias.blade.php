<script type="text/javascript">

    $(document).ready(function() {

        //POR PLAN
        $("#plan_id").change( event => {
            var programa_id = $("#programa_id").val();

            $("#materia_id").empty();
            $("#materia_id").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_evidencias/getMateriasEvidencias/${event.target.value}/${programa_id}`,function(res,sta){

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

        //POR PROGRAMA
        $("#programa_id").change( event => {
            var plan_id = $("#plan_id").val();

            $("#materia_id").empty();
            $("#materia_id").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_evidencias/getMateriasEvidencias/${plan_id}/${event.target.value}`,function(res,sta){

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