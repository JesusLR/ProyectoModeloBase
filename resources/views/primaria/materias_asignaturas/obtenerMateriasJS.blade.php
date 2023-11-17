<script>
    //Mostrar por Plan
    $("#plan_id").change( event => {
        var matSemestre = $("#matSemestre").val();
        $("#primaria_materia_id").empty();
        $("#primaria_materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
        $.get(base_url+`/primaria_materias_asignaturas/getMateriasConAsignatura/${event.target.value}/${matSemestre}`,function(res,sta){
            res.forEach(element => {
                $("#primaria_materia_id").append(`<option value=${element.id}>${element.matClave}-${element.matNombre}</option>`);
            });
        });
    });

    //Mostrar por Grado
    $("#matSemestre").change( event => {
        var plan_id = $("#plan_id").val();
        $("#primaria_materia_id").empty();
        $("#primaria_materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
        $.get(base_url+`/primaria_materias_asignaturas/getMateriasConAsignatura/${plan_id}/${event.target.value}`,function(res,sta){
            res.forEach(element => {
                $("#primaria_materia_id").append(`<option value=${element.id}>${element.matClave}-${element.matNombre}</option>`);
            });
        });
    });
</script>