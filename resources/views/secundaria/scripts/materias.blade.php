<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER MATERIAS POR SEMESTRE SELECCIONADO
        $("#gpoSemestre").change( event => {
            var plan_id = $("#plan_id").val();
            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/secundaria_grupo/materias/${event.target.value}/${plan_id}`,function(res,sta){
                res.forEach(element => {
                    $("#materia_id").append(`<option value=${element.id}>${element.matClave}-${element.matNombre}</option>`);
                });
            });
        });

        $("#plan_id").change( event => {
            var gpoSemestre = $("#gpoSemestre").val();
            $("#materia_id").empty();
            $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/secundaria_grupo/materias/${gpoSemestre}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#materia_id").append(`<option value=${element.id}>${element.matClave}-${element.matNombre}</option>`);
                });
            });
        });

     });
</script>