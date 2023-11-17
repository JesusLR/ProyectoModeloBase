<script type="text/javascript">

    $(document).ready(function() {

        //Obtener por Plan
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var gpoGrado = $("#gpoGrado").val();

            $("#materiaACD_id").empty();
            $("#materiaACD_id").append(`<option value="" >SELECCIONE UNA OPCIÓN</option>`);
            
            $.get(base_url+`/reporte/secundaria_alumnos_no_inscritos_materias/getGrupoACDFiltro/${event.target.value}/${periodo_id}/${gpoGrado}`,function(res,sta){
                res.forEach(element => {
                    $("#materiaACD_id").append(`<option value=${element.secundaria_materia_id}>${element.matNombre}</option>`);
                });
            });
        });

        //Obtener por Periodo
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var gpoGrado = $("#gpoGrado").val();

            $("#materiaACD_id").empty();
            $("#materiaACD_id").append(`<option value="" >SELECCIONE UNA OPCIÓN</option>`);
            
            $.get(base_url+`/reporte/secundaria_alumnos_no_inscritos_materias/getGrupoACDFiltro/${plan_id}/${event.target.value}/${gpoGrado}`,function(res,sta){
                res.forEach(element => {
                    $("#materiaACD_id").append(`<option value=${element.secundaria_materia_id}>${element.matNombre}</option>`);
                });
            });
        });

        //Obtener por Grado
        $("#gpoGrado").change( event => {
            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();

            $("#materiaACD_id").empty();
            $("#materiaACD_id").append(`<option value="" >SELECCIONE UNA OPCIÓN</option>`);
            
            $.get(base_url+`/reporte/secundaria_alumnos_no_inscritos_materias/getGrupoACDFiltro/${plan_id}/${periodo_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#materiaACD_id").append(`<option value=${element.secundaria_materia_id}>${element.matNombre}</option>`);
                });
            });
        });
       
     });


</script>