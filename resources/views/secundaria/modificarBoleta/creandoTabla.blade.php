<script>
    $(document).ready(function() {

        
        $(document).on("click", "#btn-buscar-alumno", function(e) {          
            document.getElementById('tablePrint').innerHTML = "";
            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();
            var programa_id = $("#programa_id").val();
            var gpoGrado = $("#gpoGrado").val();
            var aluClave = $("#aluClave").val();
            var secundaria_mes_evaluacione_id = $("#secundaria_mes_evaluacione_id").val();
           
            e.preventDefault();

            $.ajax({
                url: "{{route('secundaria.secundaria_modificar_boleta.modificarpost')}}",
                method: "POST",
                dataType: "json",
                data: {
                    "_token": $("meta[name=csrf-token]").attr("content"),
                    periodo_id: periodo_id,
                    plan_id: plan_id,
                    programa_id: programa_id,
                    gpoGrado: gpoGrado,
                    aluClave: aluClave,
                    secundaria_mes_evaluacione_id: secundaria_mes_evaluacione_id                   
                },
                success: function(data){
                    
                    var secundaria_mes_evaluaciones = data.secundaria_mes_evaluaciones;
                    var calificaciones = data.calificaciones;

                    if(calificaciones.length > 0){

                        $("#mostrar-save").show();

                        var nombre="";
                            var apellido1="";
                            var apellido2="";
                            
                            if(calificaciones[0].perNombre == null){
                                nombre = "";
                            }else{
                                nombre = calificaciones[0].perNombre;
                            }
        
                            if(calificaciones[0].perApellido1 == null){
                                apellido1 = "";
                            }else{
                                apellido1 = calificaciones[0].perApellido1;
                            }
        
                            if(calificaciones[0].perApellido2 == null){
                                apellido2 = "";
                            }else{
                                apellido2 = calificaciones[0].perApellido2;
                            }

                        $("#alumno_nombre").text(`Alumno: ${apellido1} ${apellido2} ${nombre}`);

                        var myTable = "<table id='tbl-paquetes' cellspacing='0' width='100%'><tr>";
                            myTable += "<th style='display: none;'><strong>id</strong></th>";
                            myTable += "<th style='display: none;'><strong>inscrito id</strong></th>";
                            myTable += "<th style='display: none;'><strong>mes</strong></th>";

                            myTable += "<th><strong>Núm</strong></th>";
                            myTable += "<th><strong>Materia</strong></th>";
                            myTable += "<th><strong>Materia complementaria</strong></th>";
                            myTable += "<th><strong>Grado-Grupo</strong></th>";

                            if(secundaria_mes_evaluaciones.mes == "SEPTIEMBRE"){
                                myTable += "<th><strong>Septiembre</strong></th>";
                            }
                            if(secundaria_mes_evaluaciones.mes == "OCTUBRE"){
                                myTable += "<th><strong>Octubre</strong></th>";
                            }
                            if(secundaria_mes_evaluaciones.mes == "NOVIEMBRE"){
                                myTable += "<th><strong>Noviembre</strong></th>";
                            }
                            if(secundaria_mes_evaluaciones.mes == "ENERO"){
                                myTable += "<th><strong>Diciembre-Enero</strong></th>";
                            }
                            if(secundaria_mes_evaluaciones.mes == "FEBRERO"){
                                myTable += "<th><strong>Febrero</strong></th>";
                            }
                            if(secundaria_mes_evaluaciones.mes == "MARZO"){
                                myTable += "<th><strong>Marzo</strong></th>";
                            }
                            if(secundaria_mes_evaluaciones.mes == "ABRIL"){
                                myTable += "<th><strong>Abril</strong></th>";
                            }
                            if(secundaria_mes_evaluaciones.mes == "MAYO"){
                                myTable += "<th><strong>Mayo</strong></th>";
                            }
                            if(secundaria_mes_evaluaciones.mes == "JUNIO"){
                                myTable += "<th><strong>Junio</strong></th>";
                            }
                            myTable += "</tr>";

                        calificaciones.forEach(function callback(element, index) {
                     
                           
                            var acd="";                                 
        
                            if(element.gpoMatComplementaria == null){
                                acd = "";
                            }else{
                                acd = element.gpoMatComplementaria;
                            }

                            myTable += `<tr">`;
        
                                myTable += `<td style='display: none;'><input name='secundaria_calificacion_id[]' id='secundaria_calificacion_id' value='${element.id}'></td>`;

                                myTable += `<td style='display: none;'><input name='secundaria_inscrito_id[]' id='secundaria_inscrito_id' value='${element.secundaria_inscrito_id}'></td>`;

                                myTable += `<td style='display: none;'><input name='mes_calificacion' id='mes_calificacion' value='${secundaria_mes_evaluaciones.mes}'></td>`;

                                myTable += `<td>${index+1}</td>`;

                                myTable += `<td>${element.matClave}-${element.matNombre}</td>`;

                                if(element.gpoMatComplementaria != null){
                                    myTable += `<td>${element.gpoMatComplementaria}</td>`;
                                }else{
                                    myTable += `<td></td>`;
                                }        
                                
                                myTable += `<td>${element.gpoGrado}-${element.gpoClave}</td>`;

                                if(secundaria_mes_evaluaciones.mes == "SEPTIEMBRE"){
                                    myTable += `<td><input type='number' name='calificacion_alumno[]' id='calificacion_alumno' onKeyUp="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" class='noUpperCase' value='${element.calificacion_evidencia1}'></td>`;
                                }
                                if(secundaria_mes_evaluaciones.mes == "OCTUBRE"){
                                    myTable += `<td><input type='number' name='calificacion_alumno[]' id='calificacion_alumno' onKeyUp="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" class='noUpperCase' value='${element.calificacion_evidencia1}'></td>`;
                                }
                                if(secundaria_mes_evaluaciones.mes == "NOVIEMBRE"){
                                    myTable += `<td><input type='number' name='calificacion_alumno[]' id='calificacion_alumno' onKeyUp="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" class='noUpperCase' value='${element.calificacion_evidencia1}'></td>`;
                                }
                                if(secundaria_mes_evaluaciones.mes == "ENERO"){
                                    myTable += `<td><input type='number' name='calificacion_alumno[]' id='calificacion_alumno' onKeyUp="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" class='noUpperCase' value='${element.calificacion_evidencia1}'></td>`;
                                }
                                if(secundaria_mes_evaluaciones.mes == "FEBRERO"){
                                    myTable += `<td><input type='number' name='calificacion_alumno[]' id='calificacion_alumno' onKeyUp="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" class='noUpperCase' value='${element.calificacion_evidencia1}'></td>`;
                                }
                                if(secundaria_mes_evaluaciones.mes == "MARZO"){
                                    myTable += `<td><input type='number' name='calificacion_alumno[]' id='calificacion_alumno' onKeyUp="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" class='noUpperCase' value='${element.calificacion_evidencia1}'></td>`;
                                }
                                if(secundaria_mes_evaluaciones.mes == "ABRIL"){
                                    myTable += `<td><input type='number' name='calificacion_alumno[]' id='calificacion_alumno' onKeyUp="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" class='noUpperCase' value='${element.calificacion_evidencia1}'></td>`;
                                }
                                if(secundaria_mes_evaluaciones.mes == "MAYO"){
                                    myTable += `<td><input type='number' name='calificacion_alumno[]' id='calificacion_alumno' onKeyUp="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" class='noUpperCase' value='${element.calificacion_evidencia1}'></td>`;
                                }
                                if(secundaria_mes_evaluaciones.mes == "JUNIO"){
                                    myTable += `<td><input type='number' name='calificacion_alumno[]' id='calificacion_alumno' onKeyUp="if(this.value>10){this.value='';}else if(this.value<0){this.value='';}" class='noUpperCase' value='${element.calificacion_evidencia1}'></td>`;
                                }

                                myTable += "</tr>";
                            

                        });

                        myTable += "</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;
                    }else{
                        document.getElementById('tablePrint').innerHTML = "";
                        $("#mostrar-save").hide();
                        $("#alumno_nombre").text("");
                        swal("Upss...", "Sin resultados", "info");
                    }

                    
         
                },
                error: function(){
                    swal("Escuela Modelo", "Error inesperado, intende nuevamente (verique si ha seleccionado todos los campos)", "error");
                }
            });
         
        });
    });
</script>