<script type="text/javascript">

    $(document).ready(function() {

        //POR PLAN
        $("#plan_id").change( event => {
            var programa_id = $("#programa_id").val();
            var gpoGrado = $("#gpoGrado").val();

            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_evidencias/getMateriasEvidencias/${event.target.value}/${programa_id}/${gpoGrado}`,function(res,sta){
                res.forEach(element => {
                    $("#materia_id").append(`<option value=${element.id}>${element.matClave}-${element.matNombre}</option>`);
                });
            });
        });

        //POR PROGRAMA
        $("#programa_id").change( event => {
            var plan_id = $("#plan_id").val();
            var gpoGrado = $("#gpoGrado").val();

            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_evidencias/getMateriasEvidencias/${plan_id}/${event.target.value}/${gpoGrado}`,function(res,sta){
                res.forEach(element => {
                    $("#materia_id").append(`<option value=${element.id}>${element.matClave}-${element.matNombre}</option>`);
                });
            });
        });

        //POR GRADO
        $("#gpoGrado").change( event => {
            var plan_id = $("#plan_id").val();
            var programa_id = $("#programa_id").val();

            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_evidencias/getMateriasEvidencias/${plan_id}/${programa_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#materia_id").append(`<option value=${element.id}>${element.matClave}-${element.matNombre}</option>`);
                });
            });
        });



     });
</script>