<script type="text/javascript">
    $(document).ready(function() {

        //por periodo
        $("#periodo_id").change(event => {
            var plan_id = $("#plan_id").val();
            var cgt_id = $("#cgt_id").val();
            var programa_id = $("#programa_id").val();
    
    
            $.get(base_url + `/bachiller_cgt_materias/obtenerMaterias/${event.target.value}/${programa_id}/${plan_id}/${cgt_id}`, function(res, sta) {
    
                var materias = res.materias;
                if (materias.length > 0) {

                    //creamos la tabla
                    let myTable = "<table><tr><td style='color: #000; '></td>";
                        myTable += "<td style='color: #000;'></td>";
                        myTable += "<td style='color: #000;'></td>";
                        myTable += "<td style='color: #000;'></td>";
                        myTable += "<td style='color: #000;'><strong>Núm</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Clave</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Materia</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Asignar</strong></td>";
                        myTable += "</tr>";
    
                        for (let i = 0; i < materias.length; i++) {
    
                            let num = [i + 1];
    
    
                            myTable += "<tr><td style=''><input name='materia_id[]' type='hidden' value='" + materias[i].id + "'></td>";
    
                            myTable += "<td style=''><input name='cgtGrupo' id='cgtGrupo' type='hidden' value='" + materias[i].cgtGrupo + "'></td>";
    
                            myTable += "<td style=''><input name='cgtTurno' id='cgtTurno' type='hidden' value='" + materias[i].cgtTurno + "'></td>";
    
                            myTable += "<td style=''><input name='matSemestre' id='matSemestre' type='hidden' value='" + materias[i].matSemestre + "'></td>";
    
    
                            myTable += "<td style=''>" + num + "</td>";
    
                            myTable += "<td style=''>" + materias[i].matClave + "</td>";
    
                            myTable += "<td style=''>" + materias[i].matNombre + "</td>";
    
                            myTable += "<td><input class='micheckbox' type='checkbox' checked name='bachiller_materia[]' value='" + materias[i].id + "' id='" + materias[i].id + "'><label for='" + materias[i].id + "'></label></td>";
    
                            myTable += "</tr>";  
    
    
                        }
    
    
                        myTable += "</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;
    
                        $("#boton-guardar").show();
    
                        //muestra el boton guardar
                        //$("#boton-guardar").show();
                    
                } else {
                    document.getElementById('tablePrint').innerHTML = "<h4>Sin Resultados</h4>";
                    $("#boton-guardar").hide();
    
    
                }
    
            });
        });
        //por programa
        $("#programa_id").change(event => {
            var plan_id = $("#plan_id").val();
            var cgt_id = $("#cgt_id").val();
            var periodo_id = $("#periodo_id").val();
    
    
            $.get(base_url + `/bachiller_cgt_materias/obtenerMaterias/${periodo_id}/${event.target.value}/${plan_id}/${cgt_id}`, function(res, sta) {
    
                var materias = res.materias;
                if (materias.length > 0) {

                    //creamos la tabla
                    let myTable = "<table><tr><td style='color: #000; '></td>";
                        myTable += "<td style='color: #000;'></td>";
                        myTable += "<td style='color: #000;'></td>";
                        myTable += "<td style='color: #000;'></td>";
                        myTable += "<td style='color: #000;'><strong>Núm</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Clave</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Materia</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Asignar</strong></td>";
                        myTable += "</tr>";
    
                        for (let i = 0; i < materias.length; i++) {
    
                            let num = [i + 1];
    
    
                            myTable += "<tr><td style=''><input name='materia_id[]' type='hidden' value='" + materias[i].id + "'></td>";
    
                            myTable += "<td style=''><input name='cgtGrupo' id='cgtGrupo' type='hidden' value='" + materias[i].cgtGrupo + "'></td>";
    
                            myTable += "<td style=''><input name='cgtTurno' id='cgtTurno' type='hidden' value='" + materias[i].cgtTurno + "'></td>";
    
                            myTable += "<td style=''><input name='matSemestre' id='matSemestre' type='hidden' value='" + materias[i].matSemestre + "'></td>";
    
    
                            myTable += "<td style=''>" + num + "</td>";
    
                            myTable += "<td style=''>" + materias[i].matClave + "</td>";
    
                            myTable += "<td style=''>" + materias[i].matNombre + "</td>";
    
                            myTable += "<td><input class='micheckbox' type='checkbox' checked name='bachiller_materia[]' value='" + materias[i].id + "' id='" + materias[i].id + "'><label for='" + materias[i].id + "'></label></td>";
    
                            myTable += "</tr>";  
    
    
                        }
    
    
                        myTable += "</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;
    
                        $("#boton-guardar").show();
    
                        //muestra el boton guardar
                        //$("#boton-guardar").show();
                    
                } else {
                    document.getElementById('tablePrint').innerHTML = "<h4>Sin Resultados</h4>";
                    $("#boton-guardar").hide();
    
    
                }
    
            });
        });

        //por plan
        $("#plan_id").change(event => {
            var periodo_id = $("#periodo_id").val();
            var programa_id = $("#programa_id").val();
            var cgt_id = $("#cgt_id").val();
    
    
            $.get(base_url + `/bachiller_cgt_materias/obtenerMaterias/${periodo_id}/${programa_id}/${event.target.value}/${cgt_id}`, function(res, sta) {
    
                var materias = res.materias;
                if (materias.length > 0) {

                    //creamos la tabla
                    let myTable = "<table><tr><td style='color: #000; '></td>";
                        myTable += "<td style='color: #000;'></td>";
                        myTable += "<td style='color: #000;'></td>";
                        myTable += "<td style='color: #000;'></td>";
                        myTable += "<td style='color: #000;'><strong>Núm</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Clave</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Materia</strong></td>";
                        myTable += "<td style='color: #000;'><strong>Asignar</strong></td>";
                        myTable += "</tr>";
    
                        for (let i = 0; i < materias.length; i++) {
    
                            let num = [i + 1];
    
    
                            myTable += "<tr><td style=''><input name='materia_id[]' type='hidden' value='" + materias[i].id + "'></td>";
    
                            myTable += "<td style=''><input name='cgtGrupo' id='cgtGrupo' type='hidden' value='" + materias[i].cgtGrupo + "'></td>";
    
                            myTable += "<td style=''><input name='cgtTurno' id='cgtTurno' type='hidden' value='" + materias[i].cgtTurno + "'></td>";
    
                            myTable += "<td style=''><input name='matSemestre' id='matSemestre' type='hidden' value='" + materias[i].matSemestre + "'></td>";
    
    
                            myTable += "<td style=''>" + num + "</td>";
    
                            myTable += "<td style=''>" + materias[i].matClave + "</td>";
    
                            myTable += "<td style=''>" + materias[i].matNombre + "</td>";
    
                            myTable += "<td><input class='micheckbox' type='checkbox' checked name='bachiller_materia[]' value='" + materias[i].id + "' id='" + materias[i].id + "'><label for='" + materias[i].id + "'></label></td>";
    
                            myTable += "</tr>";  
    
    
                        }
    
    
                        myTable += "</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;
    
                        $("#boton-guardar").show();
    
                        //muestra el boton guardar
                        //$("#boton-guardar").show();
                    
                } else {
                    document.getElementById('tablePrint').innerHTML = "<h4>Sin Resultados</h4>";
                    $("#boton-guardar").hide();
    
    
                }
    
            });
        });

        //por plan
        $("#cgt_id").change(event => {
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
    
    
            $.get(base_url + `/bachiller_cgt_materias/obtenerMaterias/${periodo_id}/${programa_id}/${plan_id}/${event.target.value}`, function(res, sta) {
    
                var materias = res.materias;
                if (materias.length > 0) {

                    //creamos la tabla
                    let myTable = "<table><tr>";
                        myTable += "<th style='display: none;'></th>";
                        myTable += "<th><strong>Núm</strong></th>";
                        myTable += "<th><strong>Clave</strong></th>";
                        myTable += "<th><strong>Materia</strong></th>";
                        myTable += "<th><strong>Complemento</strong></th>";
                        myTable += "<th><strong>Asignar</strong></th>";
                        myTable += "</tr>";
    
                        for (let i = 0; i < materias.length; i++) {
    
                            let num = [i + 1];
    
    
                            myTable += "<tr><td style='display: none;'><input name='materia_id[]' type='hidden' value='" + materias[i].id + "'></td>";
          
                            myTable += "<td style=''>" + num + "</td>";
    
                            myTable += "<td style=''>" + materias[i].matClave + "</td>";
    
                            myTable += "<td style=''>" + materias[i].matNombre + "</td>";

                            if(materias[i].gpoMatComplementaria == null){
                                var gpoMatComplementaria = "";
                            }else{
                                var gpoMatComplementaria = materias[i].gpoMatComplementaria;
                            }
                            myTable += "<td style=''>" + gpoMatComplementaria + "</td>";

                            myTable += "<td><div class='form-check checkbox-warning-filled'><input class='micheckbox form-check-input filled-in' type='checkbox' checked name='bachiller_materia[]' value='" + materias[i].id + "' id='" + materias[i].id + "'><label for='" + materias[i].id + "'></label></div></td>";
    
                            myTable += "</tr>";  
    
    
                        }
    
    
                        myTable += "</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;
    
                        $("#boton-guardar").show();
    
                        //muestra el boton guardar
                        //$("#boton-guardar").show();
                    
                } else {
                    document.getElementById('tablePrint').innerHTML = "<h4>Sin Resultados</h4>";
                    $("#boton-guardar").hide();
    
    
                }
    
            });
        });
    
    });
</script>


