<script type="text/javascript">
    $(document).ready(function() {

        function obtenerMaterias(periodo_id, programa_id,plan_id, cgt_id) {

            document.getElementById('tablePrint').innerHTML = "";

            $.get(base_url+`/primaria_cgt_materias/obtenerMaterias/${periodo_id}/${programa_id}/${plan_id}/${cgt_id}`, function(res,sta) {

                
                        if(res.length > 0){
                            //creamos la tabla
                            let myTable= "<table class='hoverTable'><tr><th style='display: none;'></th>";
                                myTable+="<th style='display: none;'></th>";
                                myTable+="<th style='display: none;'></th>";
                                myTable+="<th style='display: none;'></th>";
                                myTable+="<th style=''><strong>Núm</strong></th>";
                                myTable+="<th style=''><strong>Clave</strong></th>";
                                myTable+="<th style=''><strong>Materia</strong></th>";
                                myTable+="<th style=''><strong>Asignar</strong></th>";
                                myTable+="</tr>";
                
                                for (let i = 0; i < res.length; i++) {
                                        
                                    let num = [i+1];
                                

                                    myTable+="<tr><td style='display: none;'><input name='materia_id[]' type='text' value='"+res[i].id+"'></td>";        
                                    
                                    myTable+="<td style='display: none;'><input name='cgtGrupo' id='cgtGrupo' type='text' value='"+res[i].cgtGrupo+"'></td>";        
                                        
                                    myTable+="<td style='display: none;'><input name='cgtTurno' id='cgtTurno' type='text' value='"+res[i].cgtTurno+"'></td>";  
                                    
                                    myTable+="<td style='display: none;'><input name='matSemestre' id='matSemestre' type='text' value='"+res[i].matSemestre+"'></td>";        


                                    myTable+="<td style=''>"+num+"</td>";        
    
                                    myTable+="<td style=''>"+res[i].matClave+"</td>";        

                                    myTable+="<td style=''>"+res[i].matNombre+"</td>";        
                                    
                                    myTable+="<td><div  class='form-check checkbox-warning-filled'><input class='micheckbox filled-in' type='checkbox' checked name='primaria_materia[]' value='"+res[i].id+"' id='"+res[i].id+"'><label for='"+res[i].id+"'></label></div></td>";

                                    myTable+="</tr>";
                                    
                                       
                                    
                                }
                                
                                
                                myTable+="</table>";
                                //pintamos la tabla 
                                document.getElementById('tablePrint').innerHTML = myTable;
                                $("#boton-guardar").show();

                                //muestra el boton guardar
                                //$("#boton-guardar").show();
                        }else{
                            document.getElementById('tablePrint').innerHTML = "";
                            $("#boton-guardar").hide();
                        }
                   
            });
        }
        
        obtenerMaterias($("#periodo_id").val(),$("#programa_id").val(),$("#plan_id").val(),$("#cgt_id").val())        
        $("#periodo_id").change( eventPerido => {
            $("#programa_id").change( eventPrograma => {
                $("#plan_id").change( eventPlan => {
                    $("#cgt_id").change( event => {
                        obtenerMaterias(eventPerido.target.value, eventPrograma.target.value, eventPlan.target.value, event.target.value)
                    });
                });
            });
        });
     });

</script>


