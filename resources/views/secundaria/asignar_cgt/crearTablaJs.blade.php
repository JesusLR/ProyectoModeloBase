<script type="text/javascript">
    $(document).ready(function() {

        function obtenerAlumnos(periodo_id, programa_id,plan_id, cgt_id) {

            document.getElementById('tablePrint').innerHTML = "";
            $.get(base_url+`/secundaria_asignar_cgt/getAlumnosGrado/${periodo_id}/${programa_id}/${plan_id}/${cgt_id}`, function(res,sta) {
                $.get(base_url+`/secundaria_asignar_cgt/getGradoGrupo/${periodo_id}/${programa_id}/${plan_id}/${cgt_id}`, function(grupos,sta) {
                    $.get(base_url+`/secundaria_asignar_cgt/getSecundariaInscritoCursos/${periodo_id}/${programa_id}/${plan_id}/${cgt_id}`, function(cursos,sta) {

                
                        if(res.length > 0){
                            //creamos la tabla
                            let myTable= "<table><tr><th style='display:none'></th>";
                                myTable+="<th><strong>Núm</strong></th>";
                                myTable+="<th><strong>Clave Pago</strong></th>";
                                myTable+="<th><strong>Alumno</strong></th>";
                                myTable+="<th><strong>Grupos</strong></th>";
                                myTable+="</tr>";
                
                                if(cursos.length > 0){
                                    for (let i = 0; i < res.length; i++) {
                                        
                                        let num = [i+1];
    
                                        let ID_curso = res[i].id;
                                            
        
                                        myTable+="<tr><td style='display:none'><input name='curso_id[]' type='text' value='"+ res[i].id +"'></td>";        
                                                
                                        myTable+="<td style=''>"+ num +"</td>";   
                                        
                                        myTable+="<td style=''>"+ res[i].aluClave +"</td>";
        
                                        myTable+="<td style=''>" + res[i].apellido_paterno + ' ' + res[i].apellido_materno + ' ' + res[i].nombres + "</td>";        
                                        
                                        myTable+="<td><div class='radio'>"

                                        for(let c = 0; c < cursos.length; c++){
                                            if(res[i].id == cursos[c].curso_id){
                    
                                                //recorremos los grupos que hay en el grado seleccionado 
                                                for (let x = 0; x < grupos.length; x++) {
                
                                                    if(res[i].cgtGrupo == grupos[x].cgtGrupo){
                                                        
                                                        //checked el radio que corresponde al grupo seleccionado
                                                        if(res[i].id == cursos[c].curso_id){
                                                            myTable+="<input checked type='radio' disabled style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";
                
                                                        }else{
                                                            myTable+="<input checked type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

                                                        }
                
                                                    }else{
                
                                                        if(res[i].id == cursos[c].curso_id){
                                                            myTable+="<input type='radio' disabled style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";
                
                                                        }else{
                                                            myTable+="<input type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";
                
                                                        }
                
                                                    }
                                                }
                
                                                "</div></td>";  
                    
                                                 myTable+="</tr>";
                                            }
                                        }
                                           
                                    }
                                }else{
                                    for (let i = 0; i < res.length; i++) {
                                        let num = [i+1];
    
                                        let ID_curso = res[i].id;
                                            
        
                                        myTable+="<tr><td style='display:none'><input name='curso_id[]' type='text' value='"+ res[i].id +"'></td>";        
                                                
                                        myTable+="<td style=''>"+ num +"</td>";      
                                        
                                        myTable+="<td style=''>"+ res[i].aluClave +"</td>";
        
                                        myTable+="<td style=''>" + res[i].apellido_paterno + ' ' + res[i].apellido_materno + ' ' + res[i].nombres + "</td>";        
                                        
                                        myTable+="<td><div class='radio'>"
                    
                                            //recorremos los grupos que hay en el grado seleccionado 
                                        for (let x = 0; x < grupos.length; x++) {
        
                                            if(res[i].cgtGrupo == grupos[x].cgtGrupo){
                                                //checked el radio que corresponde al grupo seleccionado
                                                myTable+="<input checked type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000;' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

        
                                            }else{
        
                                                myTable+="<input type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000;' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

        
                                            }
                                        }
        
                                        "</div></td>";  
        
                                        myTable+="</tr>";
                                    }
                                }
                            
                                
                                
                                myTable+="</table>";
                                //pintamos la tabla 
                                document.getElementById('tablePrint').innerHTML = myTable;

                                //muestra el boton guardar
                                $("#boton-guardar").show();
                        }else{
                            swal("Upss...", "Sin resultados para el grupo seleccionado", "info");
                            document.getElementById('tablePrint').innerHTML = "<h3>Sin resultados</h3>";

                        }
                    });
                                         
                });
                        
            });
        }
        
        obtenerAlumnos($("#periodo_id").val(),$("#programa_id").val(),$("#plan_id").val(),$("#cgt_id").val())        
        $("#periodo_id").change( eventPerido => {
            $("#programa_id").change( eventPrograma => {
                $("#plan_id").change( eventPlan => {
                    $("#cgt_id").change( event => {
                        obtenerAlumnos(eventPerido.target.value, eventPrograma.target.value, eventPlan.target.value, event.target.value)
                    });
                });
            });
        });
     });
</script>

