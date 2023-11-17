<script>
    $("#cgt_id").change( event => {
        var periodo_id = $("#periodo_id").val();
        var programa_id = $("#programa_id").val();
        //var cgt_id = $("#cgt_id").val();
        var plan_id = $("#plan_id").val();

        $.get(base_url+`/preescolar_asignar_cgt/getAlumnosGrado/${periodo_id}/${programa_id}/${plan_id}/${event.target.value}`, function(res,sta) {
            document.getElementById('tablePrint').innerHTML = "";
            $.get(base_url+`/preescolar_asignar_cgt/getGradoGrupo/${periodo_id}/${programa_id}/${plan_id}/${event.target.value}`, function(grupos,sta) {
                $.get(base_url+`/preescolar_asignar_cgt/getPreescolarInscritoCursos/${periodo_id}/${programa_id}/${plan_id}/${event.target.value}`, function(cursos,sta) {

                    

                    if(res.length > 0){
                        //creamos la tabla
                        let myTable= "<table><tr><td style='color: #000; display:none'></td>";
                            myTable+="<td style='color: #000;'><strong>Núm</strong></td>";

                            myTable+="<td style='color: #000;'><strong>Alumno</strong></td>";
                            myTable+="<td style='color: #000;'><strong>Grupos</strong></td>";
                            myTable+="</tr>";

                            if(cursos.length > 0){
                                for (let i = 0; i < res.length; i++) {

                                    let num = [i+1];

                                    let ID_curso = res[i].id;


                                    myTable+="<tr><td style=''><input name='curso_id[]' type='hidden' value='"+ res[i].id +"'></td>";

                                    myTable+="<tr><td style=''>"+ num +"</td>";

                                    myTable+="<td style=''>" + res[i].apellido_paterno + ' ' + res[i].apellido_materno + ' ' + res[i].nombres + "</td>";

                                    myTable+="<td><div class='radio'>"

                                    for(let c = 0; c < cursos.length; c++){
                                        if(res[i].id == cursos[c].curso_id){

                                            //recorremos los grupos que hay en el grado seleccionado
                                            for (let x = 0; x < grupos.length; x++) {

                                                if(res[i].cgtGrupo == grupos[x].cgtGrupo){
                                                                //checked el radio que corresponde al grupo seleccionado
                                                if(res[i].id == cursos[c].curso_id){
                                                    myTable+="<input checked type='radio' disabled style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

                                                    }else{
                                                        myTable+="<input checked type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

                                                    }

                                                }else{

                                                    if(res[i].id == cursos[c].curso_id){
                                                        myTable+="<input type='radio' disabled style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

                                                    }else{
                                                        myTable+="<input type='radio' style='position:relative;' value='"+grupos[x].id+"' name='grupo_perteneciente["+res[i].id+"]' id='"+res[i].id+'_'+grupos[x].cgtGrupo+"'><label style='margin-right: 5px' for='"+res[i].id+'_'+grupos[x].cgtGrupo+"'>"+grupos[x].cgtGrupo+"</label>";

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
                            }



                            myTable+="</table>";
                            //pintamos la tabla
                            document.getElementById('tablePrint').innerHTML = myTable;

                            //muestra el boton guardar
                            $("#boton-guardar").show();
                    }else{
                        swal('Escuela Modelo', 'El grupo seleccionado no contiene datos', 'info');
                        document.getElementById('tablePrint').innerHTML = "<h4>No hay datos registrados</h4>";
                        $("#boton-guardar").hide();

                    }
                });

            });

        });
        

    });
</script>