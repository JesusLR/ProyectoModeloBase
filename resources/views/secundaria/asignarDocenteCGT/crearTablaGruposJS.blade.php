<script type="text/javascript">
    $(document).ready(function() {

        // OBTENER POR PERIODO
        $("#periodo_id").change(event => {
            var plan_id = $("#plan_id").val();
            $.get(base_url + `/secundaria_asignar_docente/obtenerGrupos/${event.target.value}/${plan_id}`, function(res, sta) {
    
    
                if (res.length > 0) {
                    //creamos la tabla
                    let myTable = "<table><tr><th style='color: #000; '></th>";
    
                    myTable += "<th><strong>Núm</strong></th>";
                    myTable += "<th><strong>Clave</strong></th>";
                    myTable += "<th><strong>Materia</strong></th>";
                    myTable += "<th><strong>Grado y grupo</strong></th>";
                    myTable += "<th><strong>Docente actual</strong></th>";
                    myTable += "<th><strong>Asignar docente</strong></th>";
                    myTable += "</tr>";
    
                    for (let i = 0; i < res.length; i++) {
    
                        let num = [i + 1];
    
    
                        myTable += "<tr><td style=''><input name='materia_id[]' type='hidden' value='" + res[i].secundaria_grupo_id + "'></td>";
    
                        myTable += "<td style=''>" + num + "</td>";
    
                        myTable += "<td style=''>" + res[i].matClave + "</td>";
    
                        myTable += "<td style=''>" + res[i].matNombre + "</td>";
    
                        myTable += "<td style='text-aling:center'>" + res[i].gpoGrado + '-' + res[i].gpoClave + "</td>";
    
                        myTable += "<td style=''>" + res[i].nombre_completo_empleado + "</td>";
    
                        myTable += "<td><input class='micheckbox' type='checkbox' name='secundaria_grupo_id[]' value='" + res[i].secundaria_grupo_id + "' id='" + res[i].secundaria_grupo_id + "'><label for='" + res[i].secundaria_grupo_id + "'></label></td>";
    
                        myTable += "</tr>";
    
    
    
                    }
    
    
                    myTable += "</table>";
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
        });
    
        // OBTENER POR PLAN
        $("#plan_id").change(event => {
            var periodo_id = $("#periodo_id").val();
            $.get(base_url + `/secundaria_asignar_docente/obtenerGrupos/${periodo_id}/${event.target.value}`, function(res, sta) {
    
    
                if (res.length > 0) {
                    //creamos la tabla
                    let myTable = "<table><tr><th></th>";
    
                    myTable += "<th><strong>Núm</strong></th>";
                    myTable += "<th><strong>Clave</strong></th>";
                    myTable += "<th><strong>Materia</strong></th>";
                    myTable += "<th><strong>Grado y grupo</strong></th>";
                    myTable += "<th><strong>Docente actual</strong></th>";
                    myTable += "<th><strong>Asignar docente</strong></th>";
                    myTable += "</tr>";
    
                    for (let i = 0; i < res.length; i++) {
    
                        let num = [i + 1];
    
    
                        myTable += "<tr><td style=''><input name='materia_id[]' type='hidden' value='" + res[i].secundaria_grupo_id + "'></td>";
    
                        myTable += "<td style=''>" + num + "</td>";
    
                        myTable += "<td style=''>" + res[i].matClave + "</td>";
    
                        myTable += "<td style=''>" + res[i].matNombre + "</td>";
    
                        myTable += "<td style='text-aling:center'>" + res[i].gpoGrado + '-' + res[i].gpoClave + "</td>";
    
                        myTable += "<td style=''>" + res[i].nombre_completo_empleado + "</td>";
    
                        myTable += "<td><input class='micheckbox' type='checkbox' name='secundaria_grupo_id[]' value='" + res[i].secundaria_grupo_id + "' id='" + res[i].secundaria_grupo_id + "'><label for='" + res[i].secundaria_grupo_id + "'></label></td>";
    
                        myTable += "</tr>";
    
    
    
                    }
    
    
                    myTable += "</table>";
                    //pintamos la tabla 
                    document.getElementById('tablePrint').innerHTML = myTable;
                    $("#boton-guardar-oculto").show();
                    $("#empleado_visible").show();
                    $("#sinResultado").html("");   
    
                }else{
                    document.getElementById('tablePrint').innerHTML = "";
                    $("#boton-guardar-oculto").hide();
                    $("#empleado_visible").hide();
                    $("#sinResultado").html("<h4>Sin resultados</h4>");
                }
    
            });
        });
    
    
    });
</script>


