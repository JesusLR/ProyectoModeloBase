<script type="text/javascript">

    $(document).ready(function() {

        $("#programa_id").change( event => {
            var plan_id = $("#plan_id").val();
            $("#preescolar_materia_id").empty();
            $("#preescolar_materia_id").append(`<option value="" selected>TODOS</option>`);
            $.get(base_url+`/reporte/getMaterias/${event.target.value}/${plan_id}`,function(res,sta){
                res.forEach(element => {
                    $("#preescolar_materia_id").append(`<option value=${element.id}>${element.matNombre}</option>`);
                });
            });
        });

        $("#plan_id").change( event => {
            var programa_id = $("#programa_id").val();
            $("#preescolar_materia_id").empty();
            $("#preescolar_materia_id").append(`<option value="" selected>TODOS</option>`);
            $.get(base_url+`/reporte/getMaterias/${programa_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#preescolar_materia_id").append(`<option value=${element.id}>${element.matNombre}</option>`);
                });
            });
        });
     });
</script>