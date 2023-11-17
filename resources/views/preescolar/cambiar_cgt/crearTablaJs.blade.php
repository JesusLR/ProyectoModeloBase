<script type="text/javascript">
    $(document).ready(function() {

        // OBTENER CGTS POR PERIODO
        $("#periodo_id").change( event => {
            $("#tablePrint").html("");

            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var cgt_id = $("#cgt_id").val();
           
            $.get(base_url+`/preescolar_cambiar_cgt/getAlumnosGrado/${event.target.value}/${programa_id}/${plan_id}/${cgt_id}`,function(res,sta){
                $.get(base_url+`/preescolar_cambiar_cgt/getGradoGrupo/${event.target.value}/${programa_id}/${plan_id}/${cgt_id}`,function(grupos,sta){

                    if(res.length > 0){
                        //creamos la tabla
                        let myTable= "<table><tr><td style='display:none'></td>";
                            myTable+="<td style=''><strong>Núm</strong></td>";

                            myTable+="<td style=''><strong>Alumno</strong></td>";
                            myTable+="<td style=''><strong>Grupos</strong></td>";
                            myTable+="</tr>";
            
                         
                            for (let i = 0; i < res.length; i++) {
                                    
                                let num = [i+1];

                                let ID_curso = res[i].id;
                                    

                                myTable+="<tr><td style=''><input name='curso_id[]' type='hidden' value='"+ res[i].id +"'></td>";        
                                        
                                myTable+="<tr><td style=''>"+ num +"</td>";        

                                myTable+="<td style=''>" + res[i].apellido_paterno + ' ' + res[i].apellido_materno + ' ' + res[i].nombres + "</td>";        
                                
                                myTable+="<td><div class='radio'>"

                               
                                     //recorremos los grupos que hay en el grado seleccionado 
                                     for (let x = 0; x < grupos.length; x++) {
        
                                        if(res[i].cgtGrupo == grupos[x].cgtGrupo){
                                            
                                            //checked el radio que corresponde al grupo seleccionado
                                            myTable+="<input checked type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

    
                                        }else{    
                                            myTable+="<input type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";
   
                                        }
                                    }
    
                                    "</div></td>";  
        
                                     myTable+="</tr>";
                                   
                            }
                            
                            
                            myTable+="</table>";
                            //pintamos la tabla 
                            document.getElementById('tablePrint').innerHTML = myTable;

                            //muestra el boton guardar
                            $("#boton-guardar").show();
                    }else{
                        $("#tablePrint").html("");
                        swal("Escuela Modelo", "Sin resultados", "info");
                    }
                
                });
            });
        });

        // OBTENER CGTS POR PROGRAMA
        $("#programa_id").change( event => {
            $("#tablePrint").html("");

            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();
            var cgt_id = $("#cgt_id").val();
           
            $.get(base_url+`/preescolar_cambiar_cgt/getAlumnosGrado/${periodo_id}/${event.target.value}/${plan_id}/${cgt_id}`,function(res,sta){
                $.get(base_url+`/preescolar_cambiar_cgt/getGradoGrupo/${periodo_id}/${event.target.value}/${plan_id}/${cgt_id}`,function(grupos,sta){

                    if(res.length > 0){
                        //creamos la tabla
                        let myTable= "<table><tr><td style='display:none'></td>";
                            myTable+="<td style=''><strong>Núm</strong></td>";

                            myTable+="<td style=''><strong>Alumno</strong></td>";
                            myTable+="<td style=''><strong>Grupos</strong></td>";
                            myTable+="</tr>";
            
                         
                            for (let i = 0; i < res.length; i++) {
                                    
                                let num = [i+1];

                                let ID_curso = res[i].id;
                                    

                                myTable+="<tr><td style=''><input name='curso_id[]' type='hidden' value='"+ res[i].id +"'></td>";        
                                        
                                myTable+="<tr><td style=''>"+ num +"</td>";        

                                myTable+="<td style=''>" + res[i].apellido_paterno + ' ' + res[i].apellido_materno + ' ' + res[i].nombres + "</td>";        
                                
                                myTable+="<td><div class='radio'>"

                               
                                     //recorremos los grupos que hay en el grado seleccionado 
                                     for (let x = 0; x < grupos.length; x++) {
        
                                        if(res[i].cgtGrupo == grupos[x].cgtGrupo){
                                            
                                            //checked el radio que corresponde al grupo seleccionado
                                            myTable+="<input checked type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

    
                                        }else{    
                                            myTable+="<input type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";
   
                                        }
                                    }
    
                                    "</div></td>";  
        
                                     myTable+="</tr>";
                                   
                            }
                            
                            
                            myTable+="</table>";
                            //pintamos la tabla 
                            document.getElementById('tablePrint').innerHTML = myTable;

                            //muestra el boton guardar
                            $("#boton-guardar").show();
                    }else{
                        $("#tablePrint").html("");
                        swal("Escuela Modelo", "Sin resultados", "info");

                    }
                
                });
            });
        });

         // OBTENER CGTS POR PLAN
         $("#plan_id").change( event => {

            $("#tablePrint").html("");

            var periodo_id = $("#periodo_id").val();
            var programa_id = $("#programa_id").val();
            var cgt_id = $("#cgt_id").val();
           
            $.get(base_url+`/preescolar_cambiar_cgt/getAlumnosGrado/${periodo_id}/${programa_id}/${event.target.value}/${cgt_id}`,function(res,sta){
                $.get(base_url+`/preescolar_cambiar_cgt/getGradoGrupo/${periodo_id}/${programa_id}/${event.target.value}/${cgt_id}`,function(grupos,sta){

                    if(res.length > 0){
                        //creamos la tabla
                        let myTable= "<table><tr><td style=' display:none'></td>";
                            myTable+="<td style=''><strong>Núm</strong></td>";

                            myTable+="<td style=''><strong>Alumno</strong></td>";
                            myTable+="<td style=''><strong>Grupos</strong></td>";
                            myTable+="</tr>";
            
                         
                            for (let i = 0; i < res.length; i++) {
                                    
                                let num = [i+1];

                                let ID_curso = res[i].id;
                                    

                                myTable+="<tr><td style=''><input name='curso_id[]' type='hidden' value='"+ res[i].id +"'></td>";        
                                        
                                myTable+="<tr><td style=''>"+ num +"</td>";        

                                myTable+="<td style=''>" + res[i].apellido_paterno + ' ' + res[i].apellido_materno + ' ' + res[i].nombres + "</td>";        
                                
                                myTable+="<td><div class='radio'>"

                               
                                     //recorremos los grupos que hay en el grado seleccionado 
                                     for (let x = 0; x < grupos.length; x++) {
        
                                        if(res[i].cgtGrupo == grupos[x].cgtGrupo){
                                            
                                            //checked el radio que corresponde al grupo seleccionado
                                            myTable+="<input checked type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

    
                                        }else{    
                                            myTable+="<input type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";
   
                                        }
                                    }
    
                                    "</div></td>";  
        
                                     myTable+="</tr>";
                                   
                            }
                            
                            
                            myTable+="</table>";
                            //pintamos la tabla 
                            document.getElementById('tablePrint').innerHTML = myTable;

                            //muestra el boton guardar
                            $("#boton-guardar").show();
                    }else{
                        $("#tablePrint").html("");
                        swal("Escuela Modelo", "Sin resultados", "info");

                    }
                
                });
            });
        });

         // OBTENER CGTS POR CGT
         $("#cgt_id").change( event => {

            $("#tablePrint").html("");
            var periodo_id = $("#periodo_id").val();
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
           
            $.get(base_url+`/preescolar_cambiar_cgt/getAlumnosGrado/${periodo_id}/${programa_id}/${plan_id}/${event.target.value}`,function(res,sta){
                $.get(base_url+`/preescolar_cambiar_cgt/getGradoGrupo/${periodo_id}/${programa_id}/${plan_id}/${event.target.value}`,function(grupos,sta){

                    if(res.length > 0){
                        //creamos la tabla
                        let myTable= "<table><tr><th style='display:none'></th>";
                            myTable+="<th><strong>Núm</strong></th>";

                            myTable+="<th><strong>Alumno</strong></th>";
                            myTable+="<th><strong>Grupos</strong></th>";
                            myTable+="</tr>";
            
                         
                            for (let i = 0; i < res.length; i++) {
                                    
                                let num = [i+1];

                                let ID_curso = res[i].id;
                                    

                                myTable+="<tr><td style=''><input name='curso_id[]' type='hidden' value='"+ res[i].id +"'></td>";        
                                        
                                myTable+="<tr><td style=''>"+ num +"</td>";        

                                myTable+="<td style=''>" + res[i].apellido_paterno + ' ' + res[i].apellido_materno + ' ' + res[i].nombres + "</td>";        
                                
                                myTable+="<td><div class='radio'>"

                               
                                     //recorremos los grupos que hay en el grado seleccionado 
                                     for (let x = 0; x < grupos.length; x++) {
        
                                        if(res[i].cgtGrupo == grupos[x].cgtGrupo){
                                            
                                            //checked el radio que corresponde al grupo seleccionado
                                            myTable+="<input checked type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

    
                                        }else{    
                                            myTable+="<input type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px; color: #000' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";
   
                                        }
                                    }
    
                                    "</div></td>";  
        
                                     myTable+="</tr>";
                                   
                            }
                            
                            
                            myTable+="</table>";
                            //pintamos la tabla 
                            document.getElementById('tablePrint').innerHTML = myTable;

                            //muestra el boton guardar
                            $("#boton-guardar").show();
                    }else{
                        $("#tablePrint").html("");
                        swal("Escuela Modelo", "Sin resultados", "info");


                    }
                
                });
            });
        });
        
        
        
     });
</script>

