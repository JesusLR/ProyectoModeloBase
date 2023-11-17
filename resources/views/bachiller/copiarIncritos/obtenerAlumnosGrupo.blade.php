<script type="text/javascript">

    $(document).ready(function() {
   
        
      
        //Grupos origen
        $("#grupo_origen_id").change( event => {

            document.getElementById('tablePrint').innerHTML = "";
                      
            $.get(base_url+`/bachiller_copiar_inscritos/api/getAlumnosDelGrupo/${event.target.value}`,function(res,sta){
                           
                
                /*res.grupoDestino.forEach(elementGrupoDestino => {

                    if(elementGrupoDestino.gpoMatComplementaria){
                        var gpoMatComplementaria = ` - ${elementGrupoDestino.gpoMatComplementaria}`;
                    }else{
                        var gpoMatComplementaria = "";
                    }
                    $("#grupo_id_destino").append(`<option value=${elementGrupoDestino.id}>${elementGrupoDestino.gpoGrado}${elementGrupoDestino.gpoClave} - ${elementGrupoDestino.matClave} ${elementGrupoDestino.matNombre} ${gpoMatComplementaria}</option>`);
                });      */


                if(res.length > 0){
                    //creamos la tabla
                    let myTable= "<table><tr><th style=''><strong>Núm</strong></th>";
                        //myTable+="<th style=''><strong>Núm</strong></th>";
                        myTable+="<th style=''><strong>Clave Pago</strong></th>";
                        myTable+="<th style=''><strong>Alumno</strong></th>";
                        myTable+="<th style=''><strong>Seleccione</strong></th>";
                        myTable+="</tr>";
        
                     
                        res.forEach(function (element, i) {

                            myTable+=`<tr><td>${i+1}</td>`; 
                            myTable+=`<td>${element.aluClave}</td>`;  
                            myTable+=`<td>${element.perApellido1} ${element.perApellido2} ${element.perNombre}</td>`;  
                            myTable+=`<td><div class='form-check checkbox-warning-filled' style="position:relative;"><input type="checkbox" class="noUpperCase filled-in" name="inscritoacopiar[]" id="inscritoAcopiar${element.id}" value="${element.id}"><label style="color: #000" for="inscritoAcopiar${element.id}"></label></div></td>`;
                            
                            myTable+="</tr>";
                        });

                                             
                        
                        myTable+="</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;

                        //muestra el boton guardar
                        $("#boton-guardar").show();
                }else{
                    swal("Escuela Modelo", "No se han econtrado alumnos en el grupo de origen seleccionado", "info");                                      

                    document.getElementById('tablePrint').innerHTML = "<h3 style='color:red'>No se han econtrado alumnos en el grupo de origen seleccionado</h3>";


                }
            });
        });


     });
</script>