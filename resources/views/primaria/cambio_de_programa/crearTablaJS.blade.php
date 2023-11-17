<script type="text/javascript">
    $(document).ready(function() {

        function obtenerAlumnoPrograma(periodo_id, programa_id, plan_id, cgt_id, aluClave) {
            $.get(base_url+`/primaria_cambio_programa/getAlumnoPrograma/api/${periodo_id}/${programa_id}/${plan_id}/${cgt_id}/${aluClave}`, function(res,sta) {

                console.log(res)


                if(res.length > 0){
                    //creamos la tabla
                    let myTable= "<table class='hoverTable'><tr><td style='display: none;'></td>";
                     
                        myTable+="<th style=''><strong>Núm</strong></th>";
                        myTable+="<th style=''><strong>Nombre del alumno</strong></th>";
                        myTable+="<th style=' text-align: center;'><strong>Estado del curso</strong></th>";
                        myTable+="<th style=' text-align: center;'><strong>Grado y grupo</strong></th>";
                        myTable+="<th style=''><strong>Programa actual</strong></th>";
                        myTable+="<th style=''><strong>Materia</strong></th>";

                        myTable+="</tr>";
        
                        for (let i = 0; i < res.length; i++) {
                                
                            let num = [i+1];
                        

                            myTable+="<tr><td style='display: none;'><input name='curso_id' id='curso_id' type='hidden' value='"+res[i].id+"'></td>";        
                            
                            myTable+="<td style=''>"+num+"</td>";        

                            myTable+="<td style=''>"+res[i].perApellido1+' '+ res[i].perApellido2 + ' ' + res[i].perNombre + "</td>";        

                            myTable+="<td style='text-align: center;'>"+res[i].curEstado+"</td>";        

                            myTable+="<td style='text-align: center;'>"+res[i].cgtGradoSemestre+'-'+ res[i].cgtGrupo +"</td>";   

                            myTable+="<td style=''>"+res[i].progClave+ '-' + res[i].progNombre+"</td>";        

                            if(res[i].matNombre != null){
                                myTable+="<td style=''>"+res[i].matNombre+"</td>";
                            }else{
                                myTable+="<td style=''></td>";
                            }

                            myTable+="<td style='display: none;'><input type='hidden' name='alumnoSeleccionado' id='alumnoSeleccionado' value='"+res[i].perApellido1+' '+ res[i].perApellido2 + ' ' + res[i].perNombre + "'></td>";        

                            myTable+="<td style='display: none;'><input type='hidden' name='aluClave' id='aluClave' value='"+res[i].aluClave+"'></td>";        

                            myTable+="<td style='display: none;'><input type='hidden' name='programaActual' id='programaActual' value='"+res[i].progClave+ '-' + res[i].progNombre+ "'></td>";        



                            myTable+="</tr>";
                            
                               
                            
                        }
                        
                        
                        myTable+="</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;
                        $("#boton-guardar").show();
                        //$("#empleado_visible").show();
                        $("#sinResultado").html("");
                        $("#combosDestino").show();


                       
                }else{
                    document.getElementById('tablePrint').innerHTML = "";
                    $("#boton-guardar").hide();
                    //$("#empleado_visible").hide();
                    $("#sinResultado").html("Sin resultados");
                    $("#combosDestino").hide();




                }
                   
            });
        }
        
        obtenerAlumnoPrograma($("#periodo_id").val(),$("#programa_id").val(),$("#plan_id").val(),$("#cgt_id").val(),$("#aluClave").val())        
        $("#periodo_id").change( eventPerido => {
            $("#programa_id").change( eventPro => {
                $("#plan_id").change( eventPlan => {
                    $("#cgt_id").change( eventCgt => {
                        $("#aluClave").blur(eventCla => {
                            obtenerAlumnoPrograma(eventPerido.target.value, eventPro.target.value, eventPlan.target.value, eventCgt.target.value, eventCla.target.value)
                        });
                    });
                });
            });
        });


        $(document).on("click", ".btn-guardar-grupo-buscar-2", function(e) {

            $(function() {
                $('#aluClave').keydown();
                $('#aluClave').keypress();
                $('#aluClave').keyup();
                $('#aluClave').blur();
            });
        });
     });


     function obtenerNombrePrograma(programa_id2) {
        $.get(base_url+`/primaria_cambio_programa/getANombrePrograma/api/${programa_id2}`, function(res,sta) {

            $("#programaNuevo").val(res[0].progClave + '-' +res[0].progNombre);


        });
    }
    
    obtenerNombrePrograma($("#programa_id2").val())        
    $("#programa_id2").change( eventPro => {
        obtenerNombrePrograma(eventPro.target.value)
    });
</script>


