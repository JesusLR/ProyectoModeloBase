

<script type="text/javascript">
    $(document).ready(function() {
       //POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var bachiller_materia_id = $("#bachiller_materia_id").val();

            //$periodo_id, $plan_id, $bachiller_materia_id
            $.get(base_url+`/reporte/bachiller_detalle_evidencia/bachiller_evidencias/getMateriasACD/${periodo_id}/${event.target.value}/${bachiller_materia_id}`,function(res,sta){
                if(res.length < 1){
                    $("#materia_acd_id_label").html("Materia complementaria");
                    $("#bachiller_materia_acd_id").empty();
                    $("#bachiller_materia_acd_id").append(`<option value="NULL">SELECCIONE UNA OPCIÓN</option>`);
                    $("#bachiller_materia_acd_id").prop('disabled', true);
                    $("#bachiller_materia_acd_id").prop('required', false);
                }else{
                    $("#bachiller_materia_acd_id").empty();
                    $("#bachiller_materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {
                        $("#materia_acd_id_label").html("Materia complementaria *");
                        $("#bachiller_materia_acd_id").prop('disabled', false);
                        $("#bachiller_materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                        $("#bachiller_materia_acd_id").prop('required', true);
                    });
                }
            });
        });



        //POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var bachiller_materia_id = $("#bachiller_materia_id").val();

            //$periodo_id, $plan_id, $bachiller_materia_id
            $.get(base_url+`/reporte/bachiller_detalle_evidencia/bachiller_evidencias/getMateriasACD/${event.target.value}/${plan_id}/${bachiller_materia_id}`,function(res,sta){
                if(res.length < 1){
                    $("#materia_acd_id_label").html("Materia complementaria");
                    $("#bachiller_materia_acd_id").empty();
                    $("#bachiller_materia_acd_id").append(`<option value="NULL">SELECCIONE UNA OPCIÓN</option>`);
                    $("#bachiller_materia_acd_id").prop('disabled', true);
                    $("#bachiller_materia_acd_id").prop('required', false);
                }else{
                    $("#bachiller_materia_acd_id").empty();
                    $("#bachiller_materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {
                        $("#materia_acd_id_label").html("Materia complementaria *");
                        $("#bachiller_materia_acd_id").prop('disabled', false);
                        $("#bachiller_materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                        $("#bachiller_materia_acd_id").prop('required', true);
                    });
                }
            });
        });

         //POR MATERIA
        $("#bachiller_materia_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();

            //$periodo_id, $plan_id, $bachiller_materia_id
            $.get(base_url+`/reporte/bachiller_detalle_evidencia/getMateriasACD/${periodo_id}/${plan_id}/${event.target.value}`,function(res,sta){
                if(res.length < 1){
                    $("#materia_acd_id_label").html("Materia complementaria");
                    $("#bachiller_materia_acd_id").empty();
                    $("#bachiller_materia_acd_id").append(`<option value="NULL">SELECCIONE UNA OPCIÓN</option>`);
                    $("#bachiller_materia_acd_id").prop('disabled', true);
                    $("#bachiller_materia_acd_id").prop('required', false);
                }else{
                    $("#bachiller_materia_acd_id").empty();
                    $("#bachiller_materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {
                        $("#materia_acd_id_label").html("Materia complementaria *");
                        $("#bachiller_materia_acd_id").prop('disabled', false);
                        $("#bachiller_materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                        $("#bachiller_materia_acd_id").prop('required', true);
                    });
                }
            });
        });
    });
  </script>