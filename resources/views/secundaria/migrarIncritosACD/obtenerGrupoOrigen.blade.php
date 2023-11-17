<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var gpoGrado = $("#gpoGrado").val();
            $("#gpoGrado").val("").trigger( "change" );


            $("#grupo_origen_id").empty();
            $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

            $("#gpoGrado_destino").empty();
            $("#gpoGrado_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

            $("#grupo_origen_id").empty();
            $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            
            $.get(base_url+`/secundaria_migrar_inscritos_acd/api/ObtenerGrupoOrigen/${event.target.value}/${periodo_id}/${gpoGrado}`,function(res,sta){
                if(res.grupoOrigen.length > 0){
                    $("#grupo_origen_id").empty();
                    $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    res.grupoOrigen.forEach(elementGrupoOrigen => {
                        $("#grupo_origen_id").append(`<option value=${elementGrupoOrigen.id}>${elementGrupoOrigen.gpoClave} - ${elementGrupoOrigen.gpoMatComplementaria}</option>`);
                    });

                    $("#gpoGrado_destino").empty();
                    $("#gpoGrado_destino").append(`<option selected value="${gradoDestino}">${gradoDestino}</option>`);


                    
                }

                if(res.periodo_destino.length > 0){
                    $("#periodo_id_destino").empty();
                    res.periodo_destino.forEach(elementPeriodoDestino => {
                        $("#periodo_id_destino").append(`<option value=${elementPeriodoDestino.id}>${elementPeriodoDestino.perNumero}-${elementPeriodoDestino.perAnio}</option>`);
                    });
                }else{
                    $("#periodo_id_destino").empty();
                    $("#periodo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                }

                             


                //CARGAR LOS DESTINO
                $("#grupo_id_destino").empty();
                $("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                if(res.grupoDestino != "false"){
                    res.grupoDestino.forEach(elementGrupoDestino => {
                        $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.gpoMatComplementaria}</option>`);
                    });
                    
                }else{
                    $("#grupo_id_destino").empty();
                    $("#grupo_id_destino").append(`<option value="" selected disabled>NO SE HAN ENCONTRADO GRUPOS</option>`); 
                }             
            });
        });

        // OBTENER POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var gpoGrado = $("#gpoGrado").val();
            $("#gpoGrado").val("").trigger( "change" );


            $("#grupo_origen_id").empty();
            $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

            $("#gpoGrado_destino").empty();
            $("#gpoGrado_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);


            $("#periodo_id_destino").empty();
            $("#periodo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

            $("#grupo_id_destino").empty();
            $("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          
            
            $.get(base_url+`/secundaria_migrar_inscritos_acd/api/ObtenerGrupoOrigen/${plan_id}/${event.target.value}/${gpoGrado}`,function(res,sta){
                if(res.grupoOrigen.length > 0){
                    $("#grupo_origen_id").empty();
                    $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    res.grupoOrigen.forEach(elementGrupoOrigen => {
                        $("#grupo_origen_id").append(`<option value=${elementGrupoOrigen.id}>${elementGrupoOrigen.gpoClave} - ${elementGrupoOrigen.gpoMatComplementaria}</option>`);
                    });

                    $("#gpoGrado_destino").empty();
                    $("#gpoGrado_destino").append(`<option selected value="${gradoDestino}">${gradoDestino}</option>`);


                    
                }

                if(res.periodo_destino.length > 0){
                    $("#periodo_id_destino").empty();
                    res.periodo_destino.forEach(elementPeriodoDestino => {
                        $("#periodo_id_destino").append(`<option value=${elementPeriodoDestino.id}>${elementPeriodoDestino.perNumero}-${elementPeriodoDestino.perAnio}</option>`);
                    });
                }else{
                    $("#periodo_id_destino").empty();
                    $("#periodo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                }

                             


                //CARGAR LOS DESTINO
                
                if(res.grupoDestino != "false"){
                    res.grupoDestino.forEach(elementGrupoDestino => {
                        $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.gpoMatComplementaria}</option>`);
                    });
                    
                }else{
                    $("#grupo_id_destino").empty();
                    $("#grupo_id_destino").append(`<option value="" selected disabled>NO SE HAN ENCONTRADO GRUPOS</option>`); 
                }           
            });
        });

        // OBTENER POR GRADO
        $("#gpoGrado").change( event => {
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();       
            
            var gradoDestino = parseInt(event.target.value) + 1;

            $.get(base_url+`/secundaria_migrar_inscritos_acd/api/ObtenerGrupoOrigen/${plan_id}/${periodo_id}/${event.target.value}`,function(res,sta){
                if(res.grupoOrigen.length > 0){
                    $("#grupo_origen_id").empty();
                    $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    res.grupoOrigen.forEach(elementGrupoOrigen => {
                        $("#grupo_origen_id").append(`<option value=${elementGrupoOrigen.id}>${elementGrupoOrigen.gpoClave} - ${elementGrupoOrigen.gpoMatComplementaria}</option>`);
                    });

                    $("#gpoGrado_destino").empty();
                    $("#gpoGrado_destino").append(`<option selected value="${gradoDestino}">${gradoDestino}</option>`);


                    
                }

                if(res.periodo_destino.length > 0){
                    $("#periodo_id_destino").empty();
                    res.periodo_destino.forEach(elementPeriodoDestino => {
                        $("#periodo_id_destino").append(`<option value=${elementPeriodoDestino.id}>${elementPeriodoDestino.perNumero}-${elementPeriodoDestino.perAnio}</option>`);
                    });
                }else{
                    $("#periodo_id_destino").empty();
                    $("#periodo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                }

                             


                //CARGAR LOS DESTINO
                $("#grupo_id_destino").empty();
                $("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                if(res.grupoDestino != "false"){
                    res.grupoDestino.forEach(elementGrupoDestino => {
                        $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.gpoMatComplementaria}</option>`);
                    });
                    
                }else{
                    $("#grupo_id_destino").empty();
                    $("#grupo_id_destino").append(`<option value="" selected disabled>NO SE HAN ENCONTRADO GRUPOS</option>`); 
                }       
            });
        });


     });
</script>