<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        $("#departamento_id").change( event => {
            $("#bachiller_mes_evaluaciones_id").empty();
            $("#bachiller_mes_evaluaciones_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_fecha_publicacion_calificacion_docente/getMesEvaluaciones/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#bachiller_mes_evaluaciones_id").append(`<option value=${element.id}>${element.mes}</option>`);
                });
            });
        });

     });
</script>