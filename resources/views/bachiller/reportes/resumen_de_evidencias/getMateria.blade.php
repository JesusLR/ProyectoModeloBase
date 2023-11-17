<script type="text/javascript">

    $(document).ready(function() {

        //Por plan
        $("#plan_id").change( event => {

            var matSemestre = $("#matSemestreBuscar").val();

            $("#bachiller_materia_id").empty();
            $("#bachiller_materia_id").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);

            $.get(base_url+`/reporte/bachiller_detalle_evidencia/${event.target.value}/${matSemestreBuscar}`,function(res,sta){
                res.forEach(element => {
                    $("#bachiller_materia_id").append(`<option value=${element.id}>${element.matClave} - ${element.matNombre}</option>`);
                });
            });
        });

        //Por Grado
        $("#matSemestreBuscar").change( event => {

            var plan_id = $("#plan_id").val();


            $("#bachiller_materia_id").empty();
            $("#bachiller_materia_id").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);

            $.get(base_url+`/reporte/bachiller_detalle_evidencia/${plan_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#bachiller_materia_id").append(`<option value=${element.id}>${element.matClave} - ${element.matNombre}</option>`);
                });
            });
        });


     });
</script>