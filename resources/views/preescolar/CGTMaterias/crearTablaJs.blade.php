<script type="text/javascript">
    $(document).ready(function() {

        console.log("hola kike")

        // OBTENER POR PERIODO
        $("#periodo_id").change( event => {
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var cgt_id = $("#cgt_id").val();

            document.getElementById('tablePrint').innerHTML = "";
            $("#boton-guardar").hide();

            $.get(base_url+`/preescolar_cgt_materias/obtenerMaterias/${event.target.value}/${programa_id}/${plan_id}/${cgt_id}`,function(res,sta){

                var grado = res.grado;
                var total = 1;

                if(res.materias.length > 0){
                    //creamos la tabla
                    let myTable= "<table><tr><th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th><strong>Núm</strong></th>";
                        myTable+="<th><strong>Clave</strong></th>";
                        myTable+="<th><strong>Materia</strong></th>";
                        myTable+="<th><strong>Asignar</strong></th>";
                        myTable+="</tr>";


                        res.materias.forEach(element => {
                            myTable+=`<tr><td style='display: none;'><input name='materia_id[]' type='text' value='${element.id}'></td>`;        
                                    
                            myTable+=`<td style='display: none;'><input name='cgtGrupo' id='cgtGrupo' type='text' value='${element.cgtGrupo}'></td>`;        
                                    
                            myTable+=`<td style='display: none;'><input name='cgtTurno' id='cgtTurno' type='text' value='${element.cgtTurno}'></td>`;  
                                
                            myTable+=`<td style='display: none;'><input name='matSemestre' id='matSemestre' type='text' value='${grado}'></td>`;        


                            myTable+=`<td style=''>${total++}</td>`;        

                            myTable+=`<td style=''>${element.matClave}</td>`;        

                            myTable+=`<td style=''>${element.matNombre}</td>`;        
                                
                            myTable+=`<td><div class='form-check checkbox-warning-filled'><input class='form-check-input filled-in micheckbox' type='checkbox' checked name='preescolar_materia[]' value='${element.id}' id='${element.id}'><label for='${element.id}'></label></div></td>`;

                            myTable+=`</tr>`;
                        });

                        myTable+="</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;

                        $("#boton-guardar").show();
                }else{
                    document.getElementById('tablePrint').innerHTML = "";
                    $("#boton-guardar").hide();
                }
            });
        });

        // OBTENER POR PROGRAMA
        $("#programa_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var cgt_id = $("#cgt_id").val();
            var plan_id = $("#plan_id").val();

            document.getElementById('tablePrint').innerHTML = "";
            $("#boton-guardar").hide();

            $.get(base_url+`/preescolar_cgt_materias/obtenerMaterias/${periodo_id}/${event.target.value}/${plan_id}/${cgt_id}`,function(res,sta){

                var grado = res.grado;
                var total = 1;

                if(res.materias.length > 0){
                    //creamos la tabla
                    let myTable= "<table><tr><th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th><strong>Núm</strong></th>";
                        myTable+="<th><strong>Clave</strong></th>";
                        myTable+="<th><strong>Materia</strong></th>";
                        myTable+="<th><strong>Asignar</strong></th>";
                        myTable+="</tr>";


                        res.materias.forEach(element => {
                            myTable+=`<tr><td style='display: none;'><input name='materia_id[]' type='text' value='${element.id}'></td>`;        
                                    
                            myTable+=`<td style='display: none;'><input name='cgtGrupo' id='cgtGrupo' type='text' value='${element.cgtGrupo}'></td>`;        
                                    
                            myTable+=`<td style='display: none;'><input name='cgtTurno' id='cgtTurno' type='text' value='${element.cgtTurno}'></td>`;  
                                
                            myTable+=`<td style='display: none;'><input name='matSemestre' id='matSemestre' type='text' value='${grado}'></td>`;        


                            myTable+=`<td style=''>${total++}</td>`;        

                            myTable+=`<td style=''>${element.matClave}</td>`;        

                            myTable+=`<td style=''>${element.matNombre}</td>`;        
                                
                            myTable+=`<td><div class='form-check checkbox-warning-filled'><input class='form-check-input filled-in micheckbox' type='checkbox' checked name='preescolar_materia[]' value='${element.id}' id='${element.id}'><label for='${element.id}'></label></div></td>`;

                            myTable+=`</tr>`;
                        });

                        myTable+="</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;

                        $("#boton-guardar").show();
                }else{
                    document.getElementById('tablePrint').innerHTML = "";
                    $("#boton-guardar").hide();
                }
            });
        });

        // OBTENER POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var cgt_id = $("#cgt_id").val();
            var programa_id = $("#programa_id").val();

            document.getElementById('tablePrint').innerHTML = "";
            $("#boton-guardar").hide();

            $.get(base_url+`/preescolar_cgt_materias/obtenerMaterias/${periodo_id}/${programa_id}/${event.target.value}/${cgt_id}`,function(res,sta){

                var grado = res.grado;
                var total = 1;

                if(res.materias.length > 0){
                    //creamos la tabla
                    let myTable= "<table><tr><th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th><strong>Núm</strong></th>";
                        myTable+="<th><strong>Clave</strong></th>";
                        myTable+="<th><strong>Materia</strong></th>";
                        myTable+="<th><strong>Asignar</strong></th>";
                        myTable+="</tr>";


                        res.materias.forEach(element => {
                            myTable+=`<tr><td style='display: none;'><input name='materia_id[]' type='text' value='${element.id}'></td>`;        
                                    
                            myTable+=`<td style='display: none;'><input name='cgtGrupo' id='cgtGrupo' type='text' value='${element.cgtGrupo}'></td>`;        
                                    
                            myTable+=`<td style='display: none;'><input name='cgtTurno' id='cgtTurno' type='text' value='${element.cgtTurno}'></td>`;  
                                
                            myTable+=`<td style='display: none;'><input name='matSemestre' id='matSemestre' type='text' value='${grado}'></td>`;        


                            myTable+=`<td style=''>${total++}</td>`;        

                            myTable+=`<td style=''>${element.matClave}</td>`;        

                            myTable+=`<td style=''>${element.matNombre}</td>`;        
                                
                            myTable+=`<td><div class='form-check checkbox-warning-filled'><input class='form-check-input filled-in micheckbox' type='checkbox' checked name='preescolar_materia[]' value='${element.id}' id='${element.id}'><label for='${element.id}'></label></div></td>`;

                            myTable+=`</tr>`;
                        });

                        myTable+="</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;

                        $("#boton-guardar").show();
                }else{
                    document.getElementById('tablePrint').innerHTML = "";
                    $("#boton-guardar").hide();
                }

            });
        });
        

        // OBTENER POR CGT
        $("#cgt_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();

            document.getElementById('tablePrint').innerHTML = "";
            $("#boton-guardar").hide();

            $.get(base_url+`/preescolar_cgt_materias/obtenerMaterias/${periodo_id}/${programa_id}/${plan_id}/${event.target.value}`,function(res,sta){

                var grado = res.grado;
                var total = 1;

                if(res.materias.length > 0){
                    //creamos la tabla
                    let myTable= "<table><tr><th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th style='display: none;'></th>";
                        myTable+="<th><strong>Núm</strong></th>";
                        myTable+="<th><strong>Clave</strong></th>";
                        myTable+="<th><strong>Materia</strong></th>";
                        myTable+="<th><strong>Asignar</strong></th>";
                        myTable+="</tr>";


                        res.materias.forEach(element => {
                            myTable+=`<tr><td style='display: none;'><input name='materia_id[]' type='text' value='${element.id}'></td>`;        
                                    
                            myTable+=`<td style='display: none;'><input name='cgtGrupo' id='cgtGrupo' type='text' value='${element.cgtGrupo}'></td>`;        
                                    
                            myTable+=`<td style='display: none;'><input name='cgtTurno' id='cgtTurno' type='text' value='${element.cgtTurno}'></td>`;  
                                
                            myTable+=`<td style='display: none;'><input name='matSemestre' id='matSemestre' type='text' value='${grado}'></td>`;  
                            
                            myTable+=`<td style='display: none;'><input name='depClave' id='depClave' type='text' value='${element.depClave}'></td>`;  



                            myTable+=`<td style=''>${total++}</td>`;        

                            myTable+=`<td style=''>${element.matClave}</td>`;        

                            myTable+=`<td style=''>${element.matNombre}</td>`;        
                                
                            myTable+=`<td><div class='form-check checkbox-warning-filled'><input class='form-check-input filled-in micheckbox' type='checkbox' checked name='preescolar_materia[]' value='${element.id}' id='${element.id}'><label for='${element.id}'></label></div></td>`;

                            myTable+=`</tr>`;
                        });

                        myTable+="</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;

                        $("#boton-guardar").show();
                }else{
                    document.getElementById('tablePrint').innerHTML = "";
                    $("#boton-guardar").hide();
                }
                
            });
        });
     });
</script>