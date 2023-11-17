<script type="text/javascript">
    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        $("#departamento_id").change( event => {
            $("#secundaria_mes_evaluaciones_id").empty();
            $("#secundaria_mes_evaluaciones_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

            var mes_evaluacion = $("#secundaria_mes_evaluaciones_id").data("evaluacion-id");

            $.get(base_url+`/secundaria_fecha_publicacion_calificacion_docente/getMesEvaluaciones/${event.target.value}`,function(res,sta){
                
                res.forEach(element => {

                    var selected = "";
                    if (element.id === mes_evaluacion) {
                        selected = "selected";
                    }

                    $("#secundaria_mes_evaluaciones_id").append(`<option value=${element.id} ${selected}>${element.mes}</option>`);
                });
            });
        });

        var departamento_id = $("#departamento_id").val();

        $("#secundaria_mes_evaluaciones_id").empty();
            $("#secundaria_mes_evaluaciones_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            var mes_evaluacion = $("#secundaria_mes_evaluaciones_id").data("evaluacion-id");

            $.get(base_url+`/secundaria_fecha_publicacion_calificacion_docente/getMesEvaluaciones/${departamento_id}`,function(res,sta){

                res.forEach(element => {
                    var selected = "";
                    if (element.id === mes_evaluacion) {
                        selected = "selected";
                    }

                    $("#secundaria_mes_evaluaciones_id").append(`<option value=${element.id} ${selected}>${element.mes}</option>`);
                });
            });
     });
</script>