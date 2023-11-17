<script type="text/javascript">

    $(document).ready(function() {
   
        
      
        //Grupos origen
        $("#grupo_origen_id").change( event => {

            document.getElementById('tablePrint').innerHTML = "";
                      
            $.get(base_url+`/bachiller_copiar_inscritos/api/getAlumnosDelGrupo/${event.target.value}`,function(res,sta){
                           
                
             
                if(res.length > 0){
                    //creamos la tabla
                    let myTable= "<table><tr><th style=''><strong>Núm</strong></th>";
                        myTable+="<th style=''><strong>Clave Pago</strong></th>";
                        myTable+="<th style=''><strong>Alumno</strong></th>";
                        myTable+="<th style=''><strong>alumno_id</strong></th>";
                        myTable+="</tr>";
        
                     
                        res.forEach(function (element, i) {

                            myTable+=`<tr><td>${i+1}</td>`; 
                            myTable+=`<td>${element.aluClave}</td>`;  
                            myTable+=`<td>${element.perApellido1} ${element.perApellido2} ${element.perNombre}</td>`;  
                            myTable += `<td><input class='micheckbox' type='checkbox' checked name='alumno_id[]' value='${element.alumno_id}' id='${element.alumno_id}'><label for='${element.alumno_id}'></label></td>`;
                            
                            myTable+="</tr>";
                        });

                                             
                        
                        myTable+="</table>";
                        //pintamos la tabla 
                        document.getElementById('tablePrint').innerHTML = myTable;

                        //muestra el boton guardar
                        $("#boton-guardar").show();
                }else{
                    document.getElementById('tablePrint').innerHTML = "<h3>Sin resultados</h3>";

                }
            });
        });


     });
</script>