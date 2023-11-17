<script type="text/javascript">
    $(document).ready(function() {

        //variables globales
        var primaria_inscrito_id = [];
        var tipo_asistencia = [];


        $(document).on("click", "#buscarInscritosMaterias", function(e) {

            var primaria_grupo_id = $("#primaria_grupo_id").val();
            
            
            $.ajax({
                url: "{{route('primaria.primaria.primaria_inscrito_modalidad.getAlumnosMateriasAsignaturas')}}",
                method: "POST",
                dataType: "json",
                data: {
                    "_token": $("meta[name=csrf-token]").attr("content"),
                    primaria_grupo_id: primaria_grupo_id
                },
           
                success: function(data){

                    var grupoInscritos = data.grupo;

                    if(grupoInscritos.length > 0){

                        //creamos la tabla
                        let myTable= "<table class='hoverTable'><tr><th style='display:none'></th>";
                            myTable+="<th><strong>Núm</strong></th>";
                            myTable+="<th><strong>Clave Pago</strong></th>";
                            myTable+="<th><strong>Alumno</strong></th>";
                            myTable+="<th><strong>Modalidad de Estudio</strong></th>";
                            myTable+="<th><strong>Docente asignado</strong></th>";
                            myTable+="<th><strong>Asignar</strong></th>";

                            myTable+="</tr>";


                            for (let i = 0; i < grupoInscritos.length; i++) {
                                    
                                let num = [i+1];
                                let apellido1="";
                                let apellido2="";
                                let nombreEmp = "";
                                
                                //agregamos al array los valores
                                primaria_inscrito_id.push(grupoInscritos[i].id);
                                tipo_asistencia.push(grupoInscritos[i].inscTipoAsistencia);

                                myTable+="<tr><td style='display: none;'><input id='inscrito_id' name='inscrito_id[]' type='text' value='"+ grupoInscritos[i].id +"'></td>";        
                                        
                                myTable+="<td style=''>"+ num +"</td>";        
                                
                                myTable+="<td style=''>" + grupoInscritos[i].aluClave + "</td>";  

                                myTable+="<td style=''>" + grupoInscritos[i].perApellido1 + ' ' + grupoInscritos[i].perApellido2 + ' ' + grupoInscritos[i].perNombre + "</td>"; 

                                myTable+="<td><select style='margin-top:-15px;' id='inscTipoAsistencia_"+grupoInscritos[i].id+"' class='browser-default validate' name='inscTipoAsistencia[]'><option value='P'>PRESENCIAL</option><option value='V'>VIRTUAL</option></select></td>";       
                             
                                if(grupoInscritos[i].empApellido1 == null || grupoInscritos[i].empApellido1 == "null" || grupoInscritos[i].empApellido1 == ""){
                                    apellido1 = "";
                                }else{
                                    apellido1 = grupoInscritos[i].empApellido1
                                }

                                if(grupoInscritos[i].empApellido2 == null || grupoInscritos[i].empApellido2 == "null" || grupoInscritos[i].empApellido2 == ""){
                                    apellido2 = "";
                                }else{
                                    apellido2 = grupoInscritos[i].empApellido2
                                }

                                if(grupoInscritos[i].empNombre == null || grupoInscritos[i].empNombre == "null" || grupoInscritos[i].empNombre == ""){
                                    nombreEmp = "";
                                }else{
                                    nombreEmp = grupoInscritos[i].empNombre;
                                }

                                myTable+="<td style=''>" + apellido1 + ' ' + apellido2 + ' ' + nombreEmp + "</td>"; 

                                myTable+="<td><div  class='form-check checkbox-warning-filled'><input class='micheckbox filled-in' type='checkbox' name='checkID[]' value='"+grupoInscritos[i].id+"' id='empleado_"+grupoInscritos[i].id+"'><label for='empleado_"+grupoInscritos[i].id+"'></label></div></td>";

        
                                myTable+="</tr>";
                                   
                            }

                            myTable+="</table>";
                            //pintamos la tabla 
                            document.getElementById('tablePrint').innerHTML = myTable;
                            $("#boton-guardar").show();
                            $("#divEmpleado").show();

                            

                            //Recorremos los valores para poder seleccionar el campo correspondiente
                            for(var x=0; x < tipo_asistencia.length; x++){
                                for(var i=0; i < primaria_inscrito_id.length; i++){
                                    $("#inscTipoAsistencia_"+primaria_inscrito_id[i]).val(tipo_asistencia[i]);    
                                }
                            }
                            

                        
                    }else{
                        document.getElementById('tablePrint').innerHTML = "<h3>Sin resultados</h3>";
                        $("#boton-guardar").hide();
                        $("#divEmpleado").hide();



                    }

                }
              });
            

        });     
        
     });
</script>

