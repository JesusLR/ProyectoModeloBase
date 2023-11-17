<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        $("#programa_id").change( event => {
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
         
            $.get(base_url+`/secundaria_reporte/calificacion_por_materia/getGrupos/${event.target.value}/${plan_id}/${periodo_id}`, function(res,sta) {

                //seleccionar el post preservado
                var grupoSeleccionadoOld = $("#grupo_id").data("grupo_id-id")
                $("#grupo_id").empty()
                res.forEach(element => {
                    var selected = "";
                    if (element.id === grupoSeleccionadoOld) {
                        console.log("entra")
                        console.log(element.grupo_id)
                        selected = "selected";
                    }

                    if(element.gpoMatComplementaria == null){
                        $("#grupo_id").append(`<option value=${element.id} ${selected}>${element.gpoGrado}-${element.gpoClave}, Materia: ${element.matNombre}</option>`);
                    }else{
                        $("#grupo_id").append(`<option value=${element.id} ${selected}>${element.gpoGrado}-${element.gpoClave}, Materia: ${element.matNombre}, Grupo ACD: ${element.gpoMatComplementaria}</option>`);

                    }
                    
                });
            });
        });

        // OBTENER CGTS POR PLAN
        $("#plan_id").change( event => {
            var programa_id = $("#programa_id").val();
            var periodo_id = $("#periodo_id").val();
         
            $.get(base_url+`/secundaria_reporte/calificacion_por_materia/getGrupos/${programa_id}/${event.target.value}/${periodo_id}`, function(res,sta) {

                //seleccionar el post preservado
                var grupoSeleccionadoOld = $("#grupo_id").data("grupo_id-id")
                $("#grupo_id").empty()
                res.forEach(element => {
                    var selected = "";
                    if (element.id === grupoSeleccionadoOld) {
                        console.log("entra")
                        console.log(element.grupo_id)
                        selected = "selected";
                    }

                    if(element.gpoMatComplementaria == null){
                        $("#grupo_id").append(`<option value=${element.id} ${selected}>${element.gpoGrado}-${element.gpoClave}, Materia: ${element.matNombre}</option>`);
                    }else{
                        $("#grupo_id").append(`<option value=${element.id} ${selected}>${element.gpoGrado}-${element.gpoClave}, Materia: ${element.matNombre}, Grupo ACD: ${element.gpoMatComplementaria}</option>`);

                    }
                    
                });
            });
        });

        // OBTENER CGTS POR PLAN
        $("#periodo_id").change( event => {
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
        
            $.get(base_url+`/secundaria_reporte/calificacion_por_materia/getGrupos/${programa_id}/${periodo_id}/${event.target.value}`, function(res,sta) {

                //seleccionar el post preservado
                var grupoSeleccionadoOld = $("#grupo_id").data("grupo_id-id")
                $("#grupo_id").empty()
                res.forEach(element => {
                    var selected = "";
                    if (element.id === grupoSeleccionadoOld) {
                        console.log("entra")
                        console.log(element.grupo_id)
                        selected = "selected";
                    }

                    if(element.gpoMatComplementaria == null){
                        $("#grupo_id").append(`<option value=${element.id} ${selected}>${element.gpoGrado}-${element.gpoClave}, Materia: ${element.matNombre}</option>`);
                    }else{
                        $("#grupo_id").append(`<option value=${element.id} ${selected}>${element.gpoGrado}-${element.gpoClave}, Materia: ${element.matNombre}, Grupo ACD: ${element.gpoMatComplementaria}</option>`);

                    }
                    
                });
            });
        });

     });
</script>
<script type="text/javascript">

   

    $("select[name=tipoReporte]").change(function(){
       if($('select[name=tipoReporte]').val() == "porMes"){
           $("#vistaPorMes").show();
           $("#vistaPorBimestre").hide();
           $("#vistaPorTrimestre").hide();

           $('#mesEvaluar').prop("required", true);
            $("#bimestreEvaluar").removeAttr("required");
            $("#trimestreEvaluar").removeAttr("required");
           
       }

       if($('select[name=tipoReporte]').val() == "porBimestre"){
            $("#vistaPorMes").hide();
            $("#vistaPorBimestre").show();
            $("#vistaPorTrimestre").hide();

            $('#bimestreEvaluar').prop("required", true);
            $("#mesEvaluar").removeAttr("required");
            $("#trimestreEvaluar").removeAttr("required");

       }

       if($('select[name=tipoReporte]').val() == "porTrimestre"){
        
            $("#vistaPorMes").hide();
            $("#vistaPorBimestre").hide();
            $("#vistaPorTrimestre").show();

            $('#trimestreEvaluar').prop("required", true);
            $("#mesEvaluar").removeAttr("required");
            $("#bimestreEvaluar").removeAttr("required");
       }
    });
</script>