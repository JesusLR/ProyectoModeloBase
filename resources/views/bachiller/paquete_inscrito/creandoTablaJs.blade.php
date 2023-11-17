<script type="text/javascript">
    $(document).ready(function() {




        // OBTENER POR PERIODO
        $("#cgt_id").change(event => {
            var periodo_id = $("#periodo_id").val();
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();



            $.get(base_url+`/bachiller_inscrito_paquete/obtenerListaAlumnosCurso/${periodo_id}/${programa_id}/${plan_id}/${event.target.value}`, function(alumnos,sta) {
                
                document.getElementById('tablePrint').innerHTML = "";
                //console.log(alumnos)
    
                //funcion para mostrar los paquetes creados
                $.get(base_url+`/bachiller_inscrito_paquete/obtenerPaquetes/${periodo_id}/${plan_id}/${event.target.value}`, function(paquetes,sta) {   
              
                    

                    if (alumnos.length > 0) {

                        //creamos la tabla
                        var myTable = "<table>";
        
                            myTable += "<th><strong>Núm</strong></th>";
                            myTable += "<th><strong>Clave Pago</strong></th>";
                            myTable += "<th><strong>Alumno</strong></th>";
                            myTable += "<th><strong>Seleccione Paquete</strong></th>";

                            myTable += "</tr>";
                           
                            alumnos.forEach(function (element_alumno, i) {   
                                
                                 
                                myTable += "<tr id='"+element_alumno.id+"'>";

                                    myTable += `<td>${i+1}</td>`;
                                    myTable += `<td>${element_alumno.aluClave}</td>`;
                                    myTable += `<td>${element_alumno.apellido_paterno} ${element_alumno.apellido_materno} ${element_alumno.nombres}</td>`;
    
                                    myTable += "<td>";
                                        paquetes.forEach(function (element_paquete, x) {   
                                            myTable += `<input onclick='docheck(this);' style='position:relative;' type='radio' name='paquete_id[${element_alumno.aluClave}]' value='${element_paquete.id}' id='${element_alumno.aluClave}_${element_paquete.consecutivo}'><label style='color: #000' for='${element_alumno.aluClave}_${element_paquete.consecutivo}'>${element_paquete.consecutivo}</label>`;
                                        });
                                    myTable += "</td>";
            
    
                                    myTable += "</tr>";
                                
                                /*
                                $.get(base_url+`/bachiller_inscrito_paquete/validarSiExisteInscrito/${element_alumno.id}`, function(inscrito,sta) {
            
                                                
                                    inscrito.forEach(function (element_inscrito, v) {   
                                        // $("#"+element_inscrito.curso_id).remove();       
                                        
                                    });

                                    
        
                                }); 

                                */ 

                                
                            });


                        myTable += "</table>";



                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;
                        $("#boton-guardar").show();
                    }
                
               
                });  
            });
        });
    
    });
</script>


