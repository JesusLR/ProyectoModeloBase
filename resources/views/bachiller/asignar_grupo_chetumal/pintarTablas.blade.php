<script type="text/javascript">
    $(document).ready(function() {

        $("#cgt_id2").change( event => {

            $("#tablePrint").html("");
            $.get(base_url+`/bachiller_asignar_grupo_seq/obtener_grupos_materias/${event.target.value}`, function(res, sta) {

                if(res.length > 0){

                    $("#basica").show();
                    var myTable = "<table id='tbl-paquetes' cellspacing='0' width='100%'><tr>";
                        myTable += "<th><strong>Grupo</strong></th>";
                        myTable += "<th><strong>Materia</strong></th>";
                        myTable += "<th><strong>Materia complementaria</strong></th>";
                        myTable += "<th><strong>Clasificación materia</strong></th>";
                        myTable += "<th><strong>Docente</strong></th>";
                        myTable += "<th><strong>Seleccionar</strong></th>";            
                        myTable += "</tr>";
    
                    res.forEach(element => {
    
                    
                        var nombre="";
                        var apellido1="";
                        var apellido2="";
                        var acd="";
    
                        if(element.empNombre == null){
                            nombre = "";
                        }else{
                            nombre = element.empNombre;
                        }
    
                        if(element.empApellido1 == null){
                            apellido1 = "";
                        }else{
                            apellido1 = element.empApellido1;
                        }
    
                        if(element.empApellido2 == null){
                            apellido2 = "";
                        }else{
                            apellido2 = element.empApellido2;
                        }
    
                        if(element.gpoMatComplementaria == null){
                            acd = "";
                        }else{
                            acd = element.gpoMatComplementaria;
                        }
    
                       
                        myTable += `<tr id="grupo${element.id}">`;
                            myTable += `<td>${element.gpoGrado}-${element.gpoClave}-${element.gpoTurno}</td>`;
    
                            myTable += `<td>${element.matClave}-${element.matNombre}</td>`;
                            if(element.gpoMatComplementaria != null){
                                myTable += `<td>${element.gpoMatComplementaria}</td>`;
                            }else{
                                myTable += `<td></td>`;
                            }
    
                            myTable += `<td>${element.matTipoGrupoMateria}</td>`;
                            
                            myTable += `<td>${nombre} ${apellido1} ${apellido2}</td>`;
                            myTable += `<td><div class='form-check checkbox-warning-filled'><input type='checkbox' class='form-check-input filled-in' checked id='grupo_${element.id}' value='${element.id}' name='grupo_id[]'><label for='grupo_${element.id}'></label></div></td>`;
                            myTable += "</tr>";
                        
    
                    });
    
                    myTable += "</table>";
                    //pintamos la tabla 
                    document.getElementById('tablePrint').innerHTML = myTable;
                }else{
                    $("#tablePrint").html("");
                    $("#basica").hide();
                }
                
            });


            $("#tablePrintExtras").html("");
            $.get(base_url+`/bachiller_asignar_grupo_seq/obtener_grupos_materias_extra/${event.target.value}`, function(res, sta) {

                if(res.length > 0){
                    $("#extras").show();
                    var myTable = "<table id='tbl-paquetes' cellspacing='0' width='100%'><tr>";
                        myTable += "<th><strong>Grupo</strong></th>";
                        myTable += "<th><strong>Materia</strong></th>";
                        myTable += "<th><strong>Materia complementaria</strong></th>";
                        myTable += "<th><strong>Clasificación materia</strong></th>";
                        myTable += "<th><strong>Docente</strong></th>";
                        myTable += "<th><strong>Seleccionar</strong></th>";            
                        myTable += "</tr>";
    
                    res.forEach(element => {
    
                    
                        var nombre="";
                        var apellido1="";
                        var apellido2="";
                        var acd="";
    
                        if(element.empNombre == null){
                            nombre = "";
                        }else{
                            nombre = element.empNombre;
                        }
    
                        if(element.empApellido1 == null){
                            apellido1 = "";
                        }else{
                            apellido1 = element.empApellido1;
                        }
    
                        if(element.empApellido2 == null){
                            apellido2 = "";
                        }else{
                            apellido2 = element.empApellido2;
                        }
    
                        if(element.gpoMatComplementaria == null){
                            acd = "";
                        }else{
                            acd = element.gpoMatComplementaria;
                        }
    
                       
                        myTable += `<tr id="grupo${element.id}">`;
                            myTable += `<td>${element.gpoGrado}-${element.gpoClave}-${element.gpoTurno}</td>`;
    
                            myTable += `<td>${element.matClave}-${element.matNombre}</td>`;
                            if(element.gpoMatComplementaria != null){
                                myTable += `<td>${element.gpoMatComplementaria}</td>`;
                            }else{
                                myTable += `<td></td>`;
                            }
    
                            myTable += `<td>${element.matTipoGrupoMateria}</td>`;
                            
                            myTable += `<td>${nombre} ${apellido1} ${apellido2}</td>`;
                            myTable += `<td><div class='form-check checkbox-warning-filled'><input type='checkbox' class='form-check-input filled-in' id='grupo_${element.id}' value='${element.id}' name='grupo_id[]'><label for='grupo_${element.id}'></label></div></td>`;
                            myTable += "</tr>";
                        
    
                    });
    
                    myTable += "</table>";
                    document.getElementById('tablePrintExtras').innerHTML = myTable;
                    //pintamos la tabla 
                    
                }else{
                    document.getElementById('tablePrintExtras').innerHTML = "";
                    $("#extras").hide();
                }

                
            });

            $("#tablePrintCompetencias").html("");
            $.get(base_url+`/bachiller_asignar_grupo_seq/obtener_grupos_materias_competencias/${event.target.value}`, function(res, sta) {

                if(res.length > 0){
                    $("#competencias").show();
                    var myTable = "<table id='tbl-paquetes' cellspacing='0' width='100%'><tr>";
                        myTable += "<th><strong>Grupo</strong></th>";
                        myTable += "<th><strong>Materia</strong></th>";
                        myTable += "<th><strong>Materia complementaria</strong></th>";
                        myTable += "<th><strong>Clasificación materia</strong></th>";
                        myTable += "<th><strong>Docente</strong></th>";
                        myTable += "<th><strong>Seleccionar</strong></th>";            
                        myTable += "</tr>";
    
                    res.forEach(element => {
    
                    
                        var nombre="";
                        var apellido1="";
                        var apellido2="";
                        var acd="";
    
                        if(element.empNombre == null){
                            nombre = "";
                        }else{
                            nombre = element.empNombre;
                        }
    
                        if(element.empApellido1 == null){
                            apellido1 = "";
                        }else{
                            apellido1 = element.empApellido1;
                        }
    
                        if(element.empApellido2 == null){
                            apellido2 = "";
                        }else{
                            apellido2 = element.empApellido2;
                        }
    
                        if(element.gpoMatComplementaria == null){
                            acd = "";
                        }else{
                            acd = element.gpoMatComplementaria;
                        }
    
                       
                        myTable += `<tr id="grupo${element.id}">`;
                            myTable += `<td>${element.gpoGrado}-${element.gpoClave}-${element.gpoTurno}</td>`;
    
                            myTable += `<td>${element.matClave}-${element.matNombre}</td>`;
                            if(element.gpoMatComplementaria != null){
                                myTable += `<td>${element.gpoMatComplementaria}</td>`;
                            }else{
                                myTable += `<td></td>`;
                            }
    
                            myTable += `<td>${element.matTipoGrupoMateria}</td>`;
                            
                            myTable += `<td>${nombre} ${apellido1} ${apellido2}</td>`;
                            myTable += `<td><div class='form-check checkbox-warning-filled'><input type='checkbox' class='form-check-input filled-in' id='grupo_${element.id}' value='${element.id}' name='grupo_id[]'><label for='grupo_${element.id}'></label></div></td>`;
                            myTable += "</tr>";
                        
    
                    });
    
                    myTable += "</table>";
                    //pintamos la tabla 
                    document.getElementById('tablePrintCompetencias').innerHTML = myTable;
                    
                }else{
                    document.getElementById('tablePrintCompetencias').innerHTML = "";
                    $("#competencias").hide();
                }

                
            });

            $("#tablePrintEscialidad").html("");
            $.get(base_url+`/bachiller_asignar_grupo_seq/obtener_grupos_materias_especialidad/${event.target.value}`, function(res, sta) {

                if(res.length > 0){
                    $("#especialidad").show();
                    var myTable = "<table id='tbl-paquetes' cellspacing='0' width='100%'><tr>";
                        myTable += "<th><strong>Grupo</strong></th>";
                        myTable += "<th><strong>Materia</strong></th>";
                        myTable += "<th><strong>Materia complementaria</strong></th>";
                        myTable += "<th><strong>Clasificación materia</strong></th>";
                        myTable += "<th><strong>Docente</strong></th>";
                        myTable += "<th><strong>Seleccionar</strong></th>";            
                        myTable += "</tr>";
    
                    res.forEach(element => {
    
                    
                        var nombre="";
                        var apellido1="";
                        var apellido2="";
                        var acd="";
    
                        if(element.empNombre == null){
                            nombre = "";
                        }else{
                            nombre = element.empNombre;
                        }
    
                        if(element.empApellido1 == null){
                            apellido1 = "";
                        }else{
                            apellido1 = element.empApellido1;
                        }
    
                        if(element.empApellido2 == null){
                            apellido2 = "";
                        }else{
                            apellido2 = element.empApellido2;
                        }
    
                        if(element.gpoMatComplementaria == null){
                            acd = "";
                        }else{
                            acd = element.gpoMatComplementaria;
                        }
    
                       
                        myTable += `<tr id="grupo${element.id}">`;
                            myTable += `<td>${element.gpoGrado}-${element.gpoClave}-${element.gpoTurno}</td>`;
    
                            myTable += `<td>${element.matClave}-${element.matNombre}</td>`;
                            if(element.gpoMatComplementaria != null){
                                myTable += `<td>${element.gpoMatComplementaria}</td>`;
                            }else{
                                myTable += `<td></td>`;
                            }
    
                            myTable += `<td>${element.matTipoGrupoMateria}</td>`;
                            
                            myTable += `<td>${nombre} ${apellido1} ${apellido2}</td>`;
                            myTable += `<td><div class='form-check checkbox-warning-filled'><input type='checkbox' class='form-check-input filled-in' id='grupo_${element.id}' value='${element.id}' name='grupo_id[]'><label for='grupo_${element.id}'></label></div></td>`;
                            myTable += "</tr>";
                        
    
                    });
    
                    myTable += "</table>";
                    //pintamos la tabla 
                    document.getElementById('tablePrintEscialidad').innerHTML = myTable;
                    
                }else{
                    document.getElementById('tablePrintEscialidad').innerHTML = "";
                    $("#especialidad").hide();
                }

                
            });
        });


        
        
     });
</script>