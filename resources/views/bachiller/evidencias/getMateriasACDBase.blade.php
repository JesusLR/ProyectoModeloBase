<script type="text/javascript">

    $(document).ready(function() {

        //POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var materia_id = $("#materia_id").val();
            var MateriaSemestre = $("#MateriaSemestre").val();
            var contadorRestantes = $("#contadorRestantes").val();

            
            $.get(base_url+`/bachiller_evidencias/getMateriasACD/${event.target.value}/${plan_id}/${materia_id}`,function(res,sta){
                if(res.length > 0){
                    res.forEach(function (element, i) {

                            
                        $("#materia_acd_id").empty();
                        $("#materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);
    
                        res.forEach(element => {
                            $("#materia_acd_id_label").html("Materia asignatura destino *");
                            $("#materia_acd_id").prop('disabled', false);
                            $("#materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                            $("#materia_acd_id").prop('required', true);
                        });

                    });
                }else{
                    $("#materia_acd_id_label").html("Materia asignatura destino *");
                    $("#materia_acd_id").prop('disabled', true);
                    $("#materia_acd_id").append(`<option value=''>NO HAY MATERIAS ASIGNATURAS CAPTURADAS</option>`);
                    $("#materia_acd_id").prop('required', true);
                }            
            });
        });

        //POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var materia_id = $("#materia_id").val();

            
            $.get(base_url+`/bachiller_evidencias/getMateriasACD/${periodo_id}/${event.target.value}/${materia_id}`,function(res,sta){
                if(res.length > 0){
                    res.forEach(function (element, i) {

                            
                        $("#materia_acd_id").empty();
                        $("#materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);
    
                        res.forEach(element => {
                            $("#materia_acd_id_label").html("Materia asignatura destino *");
                            $("#materia_acd_id").prop('disabled', false);
                            $("#materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                            $("#materia_acd_id").prop('required', true);
                        });

                    });
                }else{
                    $("#materia_acd_id_label").html("Materia asignatura destino *");
                    $("#materia_acd_id").prop('disabled', true);
                    $("#materia_acd_id").append(`<option value=''>NO HAY MATERIAS ASIGNATURAS CAPTURADAS</option>`);
                    $("#materia_acd_id").prop('required', true);
                }       
            });
        });

        //POR MATERIA
        $("#materia_id").change( event => {
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            var MateriaSemestre = $("#MateriaSemestre").val();
            var contadorRestantes = $("#contadorRestantes").val();

            
            $.get(base_url+`/bachiller_evidencias/getMateriasACD/${periodo_id}/${plan_id}/${event.target.value}`,function(res,sta){
                if(res.length > 0){
                    res.forEach(function (element, i) {

                            
                        $("#materia_acd_id").empty();
                        $("#materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);
    
                        res.forEach(element => {
                            $("#materia_acd_id_label").html("Materia asignatura destino *");
                            $("#materia_acd_id").prop('disabled', false);
                            $("#materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                            $("#materia_acd_id").prop('required', true);
                        });

                    });
                }else{
                    $("#materia_acd_id_label").html("Materia asignatura destino *");
                    $("#materia_acd_id").prop('disabled', true);
                    $("#materia_acd_id").append(`<option value=''>NO HAY MATERIAS ASIGNATURAS CAPTURADAS</option>`);
                    $("#materia_acd_id").prop('required', true);
                }       
            });
        });
       

        //POR SEMESTRE
        $("#MateriaSemestre").change( event => {
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            var materia_id = $("#materia_id").val();
            var contadorRestantes = $("#contadorRestantes").val();

            
            $.get(base_url+`/bachiller_evidencias/getMateriasACD/${periodo_id}/${plan_id}/${event.target.value}`,function(res,sta){
                if(res.length > 0){
                    res.forEach(function (element, i) {

                            
                        $("#materia_acd_id").empty();
                        $("#materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);
    
                        res.forEach(element => {
                            $("#materia_acd_id_label").html("Materia asignatura destino *");
                            $("#materia_acd_id").prop('disabled', false);
                            $("#materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                            $("#materia_acd_id").prop('required', true);
                        });

                    });
                }else{
                    $("#materia_acd_id_label").html("Materia asignatura destino *");
                    $("#materia_acd_id").prop('disabled', true);
                    $("#materia_acd_id").append(`<option value=''>NO HAY MATERIAS ASIGNATURAS CAPTURADAS</option>`);
                    $("#materia_acd_id").prop('required', true);
                }       
            });
        });
     });
</script>