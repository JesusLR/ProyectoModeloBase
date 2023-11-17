<script type="text/javascript">

    $(document).ready(function() {
   
        
      
        //Grupos origen
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var gpoGrado = $("#gpoGrado").val();       
            var grupo_origen_id = $("#grupo_origen_id").val();       


            $.get(base_url+`/bachiller_copiar_inscritos/api/getGrupoDestino/${plan_id}/${event.target.value}/${gpoGrado}/${grupo_origen_id}`,function(res,sta){
                           
                
                //CARGAR LOS DESTINO
                $("#grupo_id_destino").empty();
                $("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                res.grupoDestino.forEach(elementGrupoDestino => {

                    if(elementGrupoDestino.gpoMatComplementaria){
                        var gpoMatComplementaria = ` - ${elementGrupoDestino.gpoMatComplementaria}`;
                    }else{
                        var gpoMatComplementaria = "";
                    }

                    if(elementGrupoDestino.empApellido1 != null){
                        var empApellido1 = elementGrupoDestino.empApellido1;
                    }else{
                        var empApellido1 = "";
                    }
                    if(elementGrupoDestino.empApellido2 != null){
                        var empApellido2 = elementGrupoDestino.empApellido2;
                    }else{
                        var empApellido2 = "";
                    }
                    if(elementGrupoDestino.empNombre != null){
                        var empNombre = elementGrupoDestino.empNombre;
                    }else{
                        var empNombre = "";
                    }

                    $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoGrado}-${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.matClave} ${elementGrupoDestino.matNombre} ${gpoMatComplementaria} - ${empApellido1} ${empApellido2} ${empNombre}</option>`);
                });      
            });
        });



        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var gpoGrado = $("#gpoGrado").val();     
            var grupo_origen_id = $("#grupo_origen_id").val();       



            $.get(base_url+`/bachiller_copiar_inscritos/api/getGrupoDestino/${event.target.value}/${periodo_id}/${gpoGrado}/${grupo_origen_id}`,function(res,sta){
                           
                
                //CARGAR LOS DESTINO
                $("#grupo_id_destino").empty();
                $("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                res.grupoDestino.forEach(elementGrupoDestino => {

                    if(elementGrupoDestino.gpoMatComplementaria){
                        var gpoMatComplementaria = ` - ${elementGrupoDestino.gpoMatComplementaria}`;
                    }else{
                        var gpoMatComplementaria = "";
                    }

                    if(elementGrupoDestino.empApellido1 != null){
                        var empApellido1 = elementGrupoDestino.empApellido1;
                    }else{
                        var empApellido1 = "";
                    }
                    if(elementGrupoDestino.empApellido2 != null){
                        var empApellido2 = elementGrupoDestino.empApellido2;
                    }else{
                        var empApellido2 = "";
                    }
                    if(elementGrupoDestino.empNombre != null){
                        var empNombre = elementGrupoDestino.empNombre;
                    }else{
                        var empNombre = "";
                    }

                    $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoGrado}-${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.matClave} ${elementGrupoDestino.matNombre} ${gpoMatComplementaria} - ${empApellido1} ${empApellido2} ${empNombre}</option>`);
                });      
            });
        });


        $("#gpoGrado").change( event => {
            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();       
            var grupo_origen_id = $("#grupo_origen_id").val();       


            $.get(base_url+`/bachiller_copiar_inscritos/api/getGrupoDestino/${plan_id}/${periodo_id}/${event.target.value}/${grupo_origen_id}`,function(res,sta){
                           
                
                //CARGAR LOS DESTINO
                $("#grupo_id_destino").empty();
                $("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                res.grupoDestino.forEach(elementGrupoDestino => {

                    if(elementGrupoDestino.gpoMatComplementaria){
                        var gpoMatComplementaria = ` - ${elementGrupoDestino.gpoMatComplementaria}`;
                    }else{
                        var gpoMatComplementaria = "";
                    }

                    if(elementGrupoDestino.empApellido1 != null){
                        var empApellido1 = elementGrupoDestino.empApellido1;
                    }else{
                        var empApellido1 = "";
                    }
                    if(elementGrupoDestino.empApellido2 != null){
                        var empApellido2 = elementGrupoDestino.empApellido2;
                    }else{
                        var empApellido2 = "";
                    }
                    if(elementGrupoDestino.empNombre != null){
                        var empNombre = elementGrupoDestino.empNombre;
                    }else{
                        var empNombre = "";
                    }


                    $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoGrado}-${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.matClave} ${elementGrupoDestino.matNombre} ${gpoMatComplementaria} - ${empApellido1} ${empApellido2} ${empNombre}</option>`);
                });      
            });
        });

        $("#grupo_origen_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();       
            var gpoGrado = $("#gpoGrado").val();       


            $.get(base_url+`/bachiller_copiar_inscritos/api/getGrupoDestino/${plan_id}/${periodo_id}/${gpoGrado}/${event.target.value}`,function(res,sta){
                           
                
                //CARGAR LOS DESTINO
                $("#grupo_id_destino").empty();
                $("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`); 
                res.grupoDestino.forEach(elementGrupoDestino => {

                    if(elementGrupoDestino.gpoMatComplementaria){
                        var gpoMatComplementaria = ` - ${elementGrupoDestino.gpoMatComplementaria}`;
                    }else{
                        var gpoMatComplementaria = "";
                    }

                    if(elementGrupoDestino.empApellido1 != null){
                        var empApellido1 = elementGrupoDestino.empApellido1;
                    }else{
                        var empApellido1 = "";
                    }
                    if(elementGrupoDestino.empApellido2 != null){
                        var empApellido2 = elementGrupoDestino.empApellido2;
                    }else{
                        var empApellido2 = "";
                    }
                    if(elementGrupoDestino.empNombre != null){
                        var empNombre = elementGrupoDestino.empNombre;
                    }else{
                        var empNombre = "";
                    }

                    $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoGrado}-${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.matClave} ${elementGrupoDestino.matNombre} ${gpoMatComplementaria} - ${empApellido1} ${empApellido2} ${empNombre}</option>`);
                });      
            });
        });

     });
</script>