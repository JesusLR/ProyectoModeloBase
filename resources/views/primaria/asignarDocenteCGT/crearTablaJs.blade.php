<script type="text/javascript">
    $(document).ready(function() {

        function obtenerPrimariaGrupos(periodo_id, plan_id,gpoGrado, gpoGrupo, tipoEmpleado) {
            $.get(base_url+`/primaria_asignar_docente/obtenerGrupos/${periodo_id}/${plan_id}/${gpoGrado}/${gpoGrupo}/${tipoEmpleado}`,
                function(res,sta) {

                console.log(res)
                if(res.length > 0){
                    //creamos la tabla
                    let myTable= "<table class='hoverTable'><tr><th'></th>";

                        myTable+="<th><strong>Núm</strong></th>";
                        myTable+="<th><strong>Clave Materia</strong></th>";
                        myTable+="<th><strong>Materia</strong></th>";
                        myTable+="<th><strong>Clave Asignatura</strong></th>";
                        myTable+="<th><strong>Asignatura</strong></th>";
                        myTable+="<th><strong>Grado y grupo</strong></th>";
                        myTable+="<th><strong>Docente actual</strong></th>";
                        myTable+="<th><strong>Asignar docente</strong></th>";
                        myTable+="</tr>";

                        for (let i = 0; i < res.length; i++) {

                            let num = [i+1];


                            myTable+="<tr><td style='display:none;'><input name='materia_id[]' type='hidden' value='"+res[i].primaria_grupo_id+"'></td>";

                            myTable+="<td style=''>"+num+"</td>";

                            myTable+="<td style=''>"+res[i].matClave+"</td>";

                            myTable+="<td style=''>"+res[i].matNombre+"</td>";

                            //Validamos si esta vacio el campo
                            if(res[i].matClaveAsignatura == null || res[i].matClaveAsignatura == "null" || res[i].matClaveAsignatura == ""){
                                myTable+="<td style=''></td>";
                            }else{
                                myTable+="<td style=''>"+res[i].matClaveAsignatura+"</td>";
                            }

                            //Validamos si esta vacio el campo
                            if(res[i].matNombreAsignatura == null || res[i].matNombreAsignatura == "null" || res[i].matNombreAsignatura == ""){
                                myTable+="<td style=''></td>";
                            }else{
                                myTable+="<td style=''>"+res[i].matNombreAsignatura+"</td>";
                            }

                            myTable+="<td style='text-aling:center'>"+res[i].gpoGrado+'-'+ res[i].gpoClave +"</td>";

                            myTable+="<td style=''>"+res[i].nombre_completo_empleado+"</td>";

                            myTable+="<td><input class='micheckbox' type='checkbox' name='primaria_grupo_id[]' value='"+res[i].primaria_grupo_id+"' id='"+res[i].primaria_grupo_id+"'><label for='"+res[i].primaria_grupo_id+"'></label></td>";

                            myTable+="</tr>";



                        }


                        myTable+="</table>";
                        //pintamos la tabla
                        document.getElementById('tablePrint').innerHTML = myTable;
                        $("#boton-guardar-oculto").show();
                        $("#empleado_visible").show();
                        $("#sinResultado").html("");


                }else{
                    document.getElementById('tablePrint').innerHTML = "";
                    $("#boton-guardar-oculto").hide();
                    $("#empleado_visible").hide();
                    $("#sinResultado").html("Sin resultados");



                }


            });
        }

        obtenerPrimariaGrupos($("#periodo_id").val(),$("#plan_id").val(),$("#gpoGrado").val(),$("#gpoGrupo").val(),$("#tipoEmpleado").val())
        $("#periodo_id").change( eventPerido => {
            $("#plan_id").change( eventPlan => {
                $("#gpoGrado").blur( eventGru => {
                    $("#gpoGrupo").blur( eventGrad => {
                        obtenerPrimariaGrupos(eventPerido.target.value, eventPlan.target.value,
                            eventGru.target.value, eventGrad.target.value, $("#tipoEmpleado").val())
                    });
                });
            });
        });


        $(document).on("click", ".btn-guardar-grupo-buscar", function(e) {

            $(function() {
                $('#gpoGrupo').keydown();
                $('#gpoGrupo').keypress();
                $('#gpoGrupo').keyup();
                $('#gpoGrupo').blur();
            });
        });
     });

</script>


