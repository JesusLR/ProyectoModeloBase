<script type="text/javascript">
    $(document).ready(function() {

        $("#ubicacion_id").change( event => {
            $("#aula_id").empty();
            $("#aula_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/api/aulas/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#aula_id").append(`<option value=${element.id}>${element.aulaClave}</option>`);
                });
            });
        });
     });
</script>