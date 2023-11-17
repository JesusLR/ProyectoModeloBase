<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var gpoSemestreC = $("#gpoSemestreC").val();

            $("#cgt_id2").empty();
            $("#cgt_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_asignar_grupo/cgts_destino/${event.target.value}/${periodo_id}/${gpoSemestreC}`,function(res,sta){
                res.forEach(element => {
                    $("#cgt_id2").append(`<option value=${element.id}>${element.cgtGradoSemestre}-${element.cgtGrupo}-${element.cgtTurno}</option>`);
                });
            });
        });

        // OBTENER CGTS POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var gpoSemestreC = $("#gpoSemestreC").val();
            $("#cgt_id2").empty();
            $("#cgt_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_asignar_grupo/cgts_destino/${plan_id}/${event.target.value}/${gpoSemestreC}`,function(res,sta){
                res.forEach(element => {
                    $("#cgt_id2").append(`<option value=${element.id}>${element.cgtGradoSemestre}-${element.cgtGrupo}-${element.cgtTurno}</option>`);
                });
            });
        });

         // OBTENER CGTS POR PERIODO
         $("#gpoSemestreC").change( event => {            
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            $("#cgt_id2").empty();
            $("#cgt_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_asignar_grupo/cgts_destino/${plan_id}/${periodo_id}/${event.target.value}`,function(res,sta){
                
                res.forEach(element => {
                    $("#cgt_id2").append(`<option value=${element.id}>${element.cgtGradoSemestre}-${element.cgtGrupo}-${element.cgtTurno}</option>`);
                });
            });
        });

        // OBTENER CGTS POR PERIODO
        $("#cgt_id2").change( event => {
            $("#tablePrint").html("");
            $("#tablePrintOptativa").html("");
            $("#tablePrintOcupacionales").html("");
            $("#tablePrintComplementaria").html("");
            $("#tablePrintExtras").html("");
        });
     });
</script>