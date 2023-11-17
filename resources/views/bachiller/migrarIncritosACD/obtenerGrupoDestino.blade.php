<script type="text/javascript">

    $(document).ready(function() {
   
        
      
        //Grupos origen
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var gpoGrado = $("#gpoGrado").val();       
           

            $.get(base_url+`/bachiller_migrar_inscritos_acd/api/getGrupoDestino/${plan_id}/${event.target.value}/${gpoGrado}`,function(res,sta){
                           
                
                //CARGAR LOS DESTINO
                $("#grupo_id_destino").empty();
                $("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                res.grupoDestino.forEach(elementGrupoDestino => {

                    if(elementGrupoDestino.gpoMatComplementaria){
                        var gpoMatComplementaria = ` - ${elementGrupoDestino.gpoMatComplementaria}`;
                    }else{
                        var gpoMatComplementaria = "";
                    }
                    $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoGrado}${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.matClave} ${elementGrupoDestino.matNombre} ${gpoMatComplementaria}</option>`);
                });      
            });
        });



        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var gpoGrado = $("#gpoGrado").val();       


            $.get(base_url+`/bachiller_migrar_inscritos_acd/api/getGrupoDestino/${event.target.value}/${periodo_id}/${gpoGrado}`,function(res,sta){
                           
                
                //CARGAR LOS DESTINO
                $("#grupo_id_destino").empty();
                $("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                res.grupoDestino.forEach(elementGrupoDestino => {

                    if(elementGrupoDestino.gpoMatComplementaria){
                        var gpoMatComplementaria = ` - ${elementGrupoDestino.gpoMatComplementaria}`;
                    }else{
                        var gpoMatComplementaria = "";
                    }
                    $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoGrado}${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.matClave} ${elementGrupoDestino.matNombre} ${gpoMatComplementaria}</option>`);
                });      
            });
        });


        $("#gpoGrado").change( event => {
            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();       


            $.get(base_url+`/bachiller_migrar_inscritos_acd/api/getGrupoDestino/${plan_id}/${periodo_id}/${event.target.value}`,function(res,sta){
                           
                
                //CARGAR LOS DESTINO
                $("#grupo_id_destino").empty();
                $("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                res.grupoDestino.forEach(elementGrupoDestino => {

                    if(elementGrupoDestino.gpoMatComplementaria){
                        var gpoMatComplementaria = ` - ${elementGrupoDestino.gpoMatComplementaria}`;
                    }else{
                        var gpoMatComplementaria = "";
                    }
                    $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoGrado}${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.matClave} ${elementGrupoDestino.matNombre} ${gpoMatComplementaria}</option>`);
                });      
            });
        });

     });
</script>