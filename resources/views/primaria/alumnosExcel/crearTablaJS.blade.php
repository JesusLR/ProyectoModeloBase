<script type="text/javascript">
    $(document).ready(function() {

        function obtenerAlumnoExcel(periodo_id) {
            $.get(base_url+`/reporte/primaria_alumnos_excel/getAlumnosCursos/${periodo_id}`, function(res,sta) {

                
                if(res.length > 0){
                    
                    //creamos la tabla
                    let myTable= "<table style='font-size:10px;'><tr><td style='color: #000;'><strong>Clave Pago</strong></td>";
                     
                        myTable+="<td style='color: #000;'><strong>Apellido Paterno</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Apellido Materno</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Nombre(s)</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Curp</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Año</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Grado</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Grupo</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Beca Clave</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Beca Descripción</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Beca Porcentaje</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Teléfono</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Celular</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Correo</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Nombre Tutor</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Celular Contacto</strong></td>";
                        myTable+="<td style='color: #000;'><strong>Edo. Curso</strong></td>";

                        myTable+="</tr>";
        
                        for (let i = 0; i < res.length; i++) {
                                
                            myTable+="<tr><td style=''>"+res[i].aluClave+"</td>";        
                            
                            myTable+="<td style=''>"+res[i].perApellido1+"</td>";        

                            myTable+="<td style=''>"+res[i].perApellido2 + "</td>";        

                            myTable+="<td style='text-align: center;'>"+res[i].perNombre+"</td>";        

                            myTable+="<td style='text-align: center;'>"+res[i].perCurp +"</td>";   

                            myTable+="<td style=''>"+res[i].perAnioPago+"</td>";        
                            myTable+="<td style=''>"+res[i].cgtGradoSemestre+"</td>";        


                            myTable+="<td style=''>"+res[i].cgtGrupo+"</td>";        

                            myTable+="<td style=''>"+res[i].curTipoBeca+"</td>";        

                            myTable+="<td style=''>"+res[i].curObservacionesBeca+"</td>";        

                            myTable+="<td style=''>"+res[i].curPorcentajeBeca+"</td>";        

                            myTable+="<td style=''>"+res[i].perTelefono1+"</td>";        
                            myTable+="<td style=''>"+res[i].perTelefono2+"</td>";        
                            myTable+="<td style=''>"+res[i].perCorreo1+"</td>";        
                            myTable+="<td style=''>"+res[i].tutorResponsable+"</td>";        
                            myTable+="<td style=''>"+res[i].celularTutor+"</td>";        
                            myTable+="<td style=''>"+res[i].curEstado+"</td>";        


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
                }
              
            });
           
        }
        
        obtenerAlumnoExcel($("#periodo_id").val())
        $("#periodo_id").change( eventPerido => {
            obtenerAlumnoExcel(eventPerido.target.value)
        });

        
     });


</script>


