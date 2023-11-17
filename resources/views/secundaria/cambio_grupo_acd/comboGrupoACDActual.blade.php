<script>
    $(document).ready(function() {        
        $(document).on("click", "#buscar-grupos-acd", function(e) {
            $("#alumno_id").val("").trigger( "change" ); 


            var periodo_id = $("#periodo_id").val();
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var aluClave = $("#aluClave").val();

            if(aluClave == ""){
                swal("Escuela Modelo", "No ha ingresado la clave de pago del alumno a buscar", "info");

                $("#grupo_id_origen").val("").trigger( "change" ); 
                $("#grupo_id_destino").val("").trigger( "change" ); 

                $("#grupo_id_origen").prop("disabled", true);
                $("#grupo_id_destino").prop("disabled", true);
            }
                  
            //$("#grupo_id_origen").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/secundaria_cambio_grupo_acd/cargar_grupos_actuales/${periodo_id}/${programa_id}/${plan_id}/${aluClave}`,function(res,sta){

                //datos actuales del alumno
                var valores_actuales = res.datos;

                //Datos del grupo destino
                var valores_destino = res.grupo_destino;



                //Solo si es mayor a cero entra
                if(valores_actuales.length > 0){

                    //Enviamos el curso id al input
                    $("#curso_id").val(valores_actuales[0].curso_id);

                    //Quitamos la clase
                    $("#quitarClass").removeClass('input-field');
                    $("#alumno_id").val(`${valores_actuales[0].aluClave} - ${valores_actuales[0].perNombre} ${valores_actuales[0].perApellido1} ${valores_actuales[0].perApellido2}`);



                    valores_actuales.forEach(element => {
                        $("#grupo_id_origen").prop("disabled", false);

                        $("#grupo_id_origen").append(`<option value=${element.secundaria_grupo_id}>Grupo: ${element.gpoGrado}-${element.gpoClave}-${element.gpoTurno} 
                            ${element.gpoMatComplementaria} Materia: ${element.matClave}-${element.matNombre} 
                            Maestro: ${element.empNombre} ${element.empApellido1} ${element.empApellido2}</option>`);

                    });

                    if(valores_destino.length > 0){
                        valores_destino.forEach(elemento => {
                            $("#grupo_id_destino").prop("disabled", false);
    
                            if(elemento.gpoTurno != null){
                                $("#grupo_id_destino").append(`<option value=${elemento.secundaria_grupo_id}>Grupo: ${elemento.gpoGrado}-${elemento.gpoClave}-${elemento.gpoTurno} 
                                    ${elemento.gpoMatComplementaria} Materia: ${elemento.matClave}-${elemento.matNombre} 
                                    Maestro: ${elemento.empNombre} ${elemento.empApellido1} ${elemento.empApellido2}</option>`);
                            }else{
                                $("#grupo_id_destino").append(`<option value=${elemento.secundaria_grupo_id}>Grupo: ${elemento.gpoGrado}-${elemento.gpoClave} 
                                    ${elemento.gpoMatComplementaria} Materia: ${elemento.matClave}-${elemento.matNombre} 
                                    Maestro: ${elemento.empNombre} ${elemento.empApellido1} ${elemento.empApellido2}</option>`);
                            }
                            
    
                        });
                    }else{
                        $("#grupo_id_destino").prop("disabled", true);
                        $("#grupo_id_destino").val("").trigger( "change" ); 


                        $("#grupo_id_destino").append(`<option value= >NO HAY GRUPOS DESTINOS DIPONIBLES</option>`);

                        swal("Escuela Modelo", "Sin grupos destino", "info");
                        
                    }
                }else{
                    $("#grupo_id_origen").prop("disabled", true);
                    $("#grupo_id_origen").val("").trigger( "change" ); 

                    $("#grupo_id_destino").prop("disabled", true);
                    $("#grupo_id_destino").val("").trigger( "change" ); 



                    $("#grupo_id_origen").append(`<option value= >NO HAY GRUPOS CARGADOS PARA EL ALUMNO</option>`);

                    swal("Escuela Modelo", "Sin resultados", "info");

                    //Enviamos el curso id al input
                    $("#curso_id").val("");
                }
                
            });   
            
            
        });


        //Se muestra o oculta segun el select
        if($("#grupo_id_destino").val() != null){
            $("#boton-guardar").show();
        }else{
            $("#boton-guardar").hide();
        }

        $("#grupo_id_destino").change(function(){
            if($("#grupo_id_destino").val() != null){
                $("#boton-guardar").show();
            }else{
                $("#boton-guardar").hide();
            }
	    });

        //Cuando cambie de ubicacion reseteamos los select de grupo origen y destino
        $("#ubicacion_id").change(function(){
            $("#grupo_id_origen").val("").trigger( "change" ); 
            $("#grupo_id_destino").val("").trigger( "change" ); 

            $("#grupo_id_origen").prop("disabled", true);
            $("#grupo_id_destino").prop("disabled", true);
	    });
    });
</script>