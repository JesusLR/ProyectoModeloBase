<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var gpoGrado = $("#gpoGrado").val();
            $("#gpoGrado").val("").trigger( "change" );


            $("#grupo_origen_id").empty();
            $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

 

            $("#grupo_origen_id").empty();
            $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            
            $.get(base_url+`/bachiller_copiar_inscritos/api/ObtenerGrupoOrigen/${event.target.value}/${periodo_id}/${gpoGrado}`,function(res,sta){
                if(res.grupoOrigen.length > 0){
                    $("#grupo_origen_id").empty();
                    $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

                    if(elementGrupoOrigen.gpoMatComplementaria != null){
                        var gpoMatComplementaria = ` - ${elementGrupoOrigen.gpoMatComplementaria}`;
                    }else{
                        var gpoMatComplementaria = "";
                    }

                    if(elementGrupoOrigen.empApellido1 != null){
                        var empApellido1 = elementGrupoOrigen.empApellido1;
                    }else{
                        var empApellido1 = "";
                    }
                    if(elementGrupoOrigen.empApellido2 != null){
                        var empApellido2 = elementGrupoOrigen.empApellido2;
                    }else{
                        var empApellido2 = "";
                    }
                    if(elementGrupoOrigen.empNombre != null){
                        var empNombre = elementGrupoOrigen.empNombre;
                    }else{
                        var empNombre = "";
                    }
                    res.grupoOrigen.forEach(elementGrupoOrigen => {
                        $("#grupo_origen_id").append(`<option value=${elementGrupoOrigen.id}>${elementGrupoOrigen.gpoGrado}${elementGrupoOrigen.gpoClave} - ${elementGrupoOrigen.matClave} ${elementGrupoOrigen.matNombre} ${gpoMatComplementaria} - ${empApellido1} ${empApellido2} ${empNombre}</option>`);
                    });

                                  
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

            //$("#grupo_id_destino").empty();
            //$("#grupo_id_destino").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
          
            
            $.get(base_url+`/bachiller_copiar_inscritos/api/ObtenerGrupoOrigen/${plan_id}/${event.target.value}/${gpoGrado}`,function(res,sta){
                if(res.grupoOrigen.length > 0){
                    $("#grupo_origen_id").empty();
                    $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    res.grupoOrigen.forEach(elementGrupoOrigen => {
                        if(elementGrupoOrigen.gpoMatComplementaria != null){
                            var gpoMatComplementaria = ` - ${elementGrupoOrigen.gpoMatComplementaria}`;
                        }else{
                            var gpoMatComplementaria = "";
                        }

                        if(elementGrupoOrigen.empApellido1 != null){
                            var empApellido1 = elementGrupoOrigen.empApellido1;
                        }else{
                            var empApellido1 = "";
                        }
                        if(elementGrupoOrigen.empApellido2 != null){
                            var empApellido2 = elementGrupoOrigen.empApellido2;
                        }else{
                            var empApellido2 = "";
                        }
                        if(elementGrupoOrigen.empNombre != null){
                            var empNombre = elementGrupoOrigen.empNombre;
                        }else{
                            var empNombre = "";
                        }

                        $("#grupo_origen_id").append(`<option value=${elementGrupoOrigen.id}>${elementGrupoOrigen.gpoGrado}${elementGrupoOrigen.gpoClave} - ${elementGrupoOrigen.matClave} ${elementGrupoOrigen.matNombre} ${gpoMatComplementaria} - ${empApellido1} ${empApellido2} ${empNombre}</option>`);
                    });

                               
                }

                        
            });
        });

        // OBTENER POR GRADO
        $("#gpoGrado").change( event => {
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();       
            
            var gradoDestino = parseInt(event.target.value) + 1;

            $.get(base_url+`/bachiller_copiar_inscritos/api/ObtenerGrupoOrigen/${plan_id}/${periodo_id}/${event.target.value}`,function(res,sta){
                if(res.grupoOrigen.length > 0){
                    $("#grupo_origen_id").empty();
                    $("#grupo_origen_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                    res.grupoOrigen.forEach(elementGrupoOrigen => {
                        if(elementGrupoOrigen.gpoMatComplementaria != null){
                            var gpoMatComplementaria = ` - ${elementGrupoOrigen.gpoMatComplementaria}`;
                        }else{
                            var gpoMatComplementaria = "";
                        }

                        if(elementGrupoOrigen.empApellido1 != null){
                            var empApellido1 = elementGrupoOrigen.empApellido1;
                        }else{
                            var empApellido1 = "";
                        }
                        if(elementGrupoOrigen.empApellido2 != null){
                            var empApellido2 = elementGrupoOrigen.empApellido2;
                        }else{
                            var empApellido2 = "";
                        }
                        if(elementGrupoOrigen.empNombre != null){
                            var empNombre = elementGrupoOrigen.empNombre;
                        }else{
                            var empNombre = "";
                        }

                        $("#grupo_origen_id").append(`<option value=${elementGrupoOrigen.id}>${elementGrupoOrigen.gpoGrado}${elementGrupoOrigen.gpoClave} - ${elementGrupoOrigen.matClave} ${elementGrupoOrigen.matNombre} ${gpoMatComplementaria} - ${empApellido1} ${empApellido2} ${empNombre}</option>`);
                    });

                                 
                }

                                   

            });
        });


     });
</script>