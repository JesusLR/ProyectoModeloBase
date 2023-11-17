<script type="text/javascript">
    $(document).ready(function() {

        //variables globales
        var primaria_inscrito_id = [];
        var tipo_asistencia = [];
        var docente_asignado = [];



        $(document).on("click", "#buscarInscritosMaterias", function(e) {

            var periodo_id = $("#periodo_id").val();
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var aluClave = $("#aluClave").val();
            
            
            $.ajax({
                url: "{{route('primaria.primaria_docente_inscrito_modalidad.getAlumnoMateriasAsignaturas')}}",
                //url: "https://webhook.site/bcf44546-f263-4b61-a782-9c09e70d62b9",
                method: "POST",
                dataType: "json",
                data: {
                    "_token": $("meta[name=csrf-token]").attr("content"),
                    periodo_id: periodo_id,
                    programa_id: programa_id,
                    plan_id: plan_id,
                    aluClave: aluClave
                },
           
                success: function(data){

                    var grupoInscritos = data.grupo;
                    var empleados = data.empleados;


                    if(grupoInscritos.length > 0){

                        $("#alumno").show();
                        $("#alumno").html(`<b>Alumno:</b> ${grupoInscritos[0].perApellido1} ${grupoInscritos[0].perApellido2} ${grupoInscritos[0].perNombre}  &nbsp;&nbsp;&nbsp;      <b>Clave Pago:</b> ${grupoInscritos[0].aluClave}`);
                        //creamos la tabla
                        let myTable= "<table class='hoverTable'><tr>"
                            myTable+="<th><strong></strong></th>";
                            myTable+="<th><strong>Núm</strong></th>";
                            //myTable+="<th><strong>Clave Pago</strong></th>";
                            myTable+="<th><strong>Materia</strong></th>";
                            myTable+="<th><strong>Asignatura</strong></th>";
                            myTable+="<th><strong>Modalidad de Estudio</strong></th>";
                            myTable+="<th><strong>Docente asignado</strong></th>";
                            myTable+="</tr>";


                            grupoInscritos.forEach(function (element_alumno, i) {        

                                //agregamos al array los valores
                                primaria_inscrito_id.push(element_alumno.id);
                                tipo_asistencia.push(element_alumno.inscTipoAsistencia);
                                docente_asignado.push(element_alumno.inscEmpleadoIdDocente);


                                if(element_alumno.matClaveAsignatura == null){
                                    var claveAsignatura = "";
                                    var nombreAsinatura = "";
                                }else{
                                    var claveAsignatura = element_alumno.matClaveAsignatura;
                                    var nombreAsinatura = element_alumno.matNombreAsignatura;
                                }

                                myTable += "<tr>";
                                myTable += `<td><input id='primaria_inscrito_id' name='primaria_inscrito_id[]' type='hidden' value='${element_alumno.id}'></td>`;
                                myTable += `<td>${i+1}</td>`;
                                //myTable += `<td>${element_alumno.aluClave}</td>`;
                                myTable += `<td>${element_alumno.matClave}-${element_alumno.matNombre}</td>`;
                                myTable += `<td>${claveAsignatura}-${nombreAsinatura}</td>`;
                                myTable += `<td><select style='margin-top:-15px;' id='inscTipoAsistencia_${element_alumno.id}' class='browser-default validate' name='inscTipoAsistencia[${element_alumno.id}]'><option value='P'>PRESENCIAL</option><option value='V'>VIRTUAL</option></select></td>`; 
                                myTable += `<td><select style='margin-top:-15px;' id='docente_${element_alumno.id}' class='browser-default validate' name='docente_asignado[${element_alumno.id}]'>`;
                                    empleados.forEach(function (element_empleado, i) {

                                        if(element_empleado.empApellido1 == null){
                                            var apellido1 = "";
                                        }else{
                                            var apellido1 = element_empleado.empApellido1;
                                        }

                                        if(element_empleado.empApellido2 == null){
                                            var apellido2 = "";
                                        }else{
                                            var apellido2 = element_empleado.empApellido2;
                                        }

                                        if(element_empleado.empNombre == null){
                                            var nombreD = "";
                                        }else{
                                            var nombreD = element_empleado.empNombre;
                                        }
                                        myTable += `<option value='${element_empleado.id}'>${apellido1} ${apellido2} ${nombreD}</option>`;
                                    });
                                myTable +=  `</select></td>`; 
                            

                                                        

                                myTable += "</tr>";
                            });

                            myTable+="</table>";
                                                      
                            document.getElementById('tablePrint').innerHTML = myTable;
                            $("#boton-guardar").show();


                            //Recorremos los valores para poder seleccionar el campo correspondiente
                            for(var x=0; x < tipo_asistencia.length; x++){
                                for(var i=0; i < primaria_inscrito_id.length; i++){
                                    $("#inscTipoAsistencia_"+primaria_inscrito_id[i]).val(tipo_asistencia[i]);    
                                }
                            }

                            for(var c=0; c < docente_asignado.length; c++){
                                for(var t=0; t < primaria_inscrito_id.length; t++){
                                    $("#docente_"+primaria_inscrito_id[t]).val(docente_asignado[t]);    
                                }
                            }

                        
                    }else{
                        document.getElementById('tablePrint').innerHTML = "";
                        $("#boton-guardar").hide();
                        $("#alumno").hide();
                        $("#alumno").html("");

                        swal("Escuela Modelo", "No se han encontrado registros con la información proporcionada", "info");
                    }

                   

                }
              });
            

        });     
        
     });
</script>

