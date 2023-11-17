<script>
    $(document).ready(function() {

        $(document).on("click", ".btn-guardar-migracion-acd", function(e) {

            var ubicacion_id = $("#ubicacion_id").val();
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            var grupo_origen_id = $("#grupo_origen_id").val();
            var grupo_id_destino = $("#grupo_id_destino").val();
            var copiarHorario = $("input[name='copiarHorario']:checked").val();

            var inscritoacopiar =  $("input[name='inscritoacopiar[]']:checked").map(function () {
                return this.value;
               }).get();

               var seleccionados = inscritoacopiar.length;

    
            //e.preventDefault();

            
    
            swal({
                title: "Cargar materias",
                text: "¿Desea continuar para realizar el cambio de grupo de los alumnos seleccionados?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#0277bd',
                confirmButtonText: 'SI',
                cancelButtonText: "NO",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {

                    
                    

                    if(grupo_origen_id == "" || grupo_origen_id == null || grupo_id_destino == "" || grupo_id_destino == null){

                        swal('Upsss', 'Favor de validar que el grupo de origen y el grupo destino este seleccionado', 'info');

                    }else{
                        $.ajax({
                            url: "{{route('bachiller.bachiller_copiar_inscritos.store')}}",
                            method: "POST",
                            dataType: "json",
                            data: {
                                "_token": $("meta[name=csrf-token]").attr("content"),
                                ubicacion_id: ubicacion_id,
                                programa_id: programa_id,
                                plan_id: plan_id,
                                periodo_id: periodo_id, 
                                grupo_origen_id: grupo_origen_id,  
                                grupo_id_destino: grupo_id_destino,
                                inscritoacopiar: inscritoacopiar,
                                copiarHorario: copiarHorario                          
                            },
                            beforeSend: function () {

                                if(seleccionados == 0){
                                    swal('Upsss', 'No se ha seleccionado ningun alumno', 'warning');
                                }else{
                                    $(".btn-guardar-migracion-acd").hide();
                                                  
                                    var html = "";
                                    html += "<div class='preloader-wrapper big active'>"+
                                        "<div class='spinner-layer spinner-blue-only'>"+
                                          "<div class='circle-clipper left'>"+
                                            "<div class='circle'></div>"+
                                          "</div><div class='gap-patch'>"+
                                            "<div class='circle'></div>"+
                                          "</div><div class='circle-clipper right'>"+
                                            "<div class='circle'></div>"+
                                          "</div>"+
                                        "</div>"+
                                      "</div>";
                                    
                                    html += "<p>" + "</p>"
            
                                    swal({
                                        html:true,
                                        title: "Guardando datos...",
                                        text: html,
                                        showConfirmButton: false
                                        //confirmButtonText: "Ok",
                                    });
                                }

                                
        
                            },
                            success: function(data){
                                $(".btn-guardar-migracion-acd").show();

                                console.log(data.copiarHorario)
                            
                                if(!data.res) {
                                    
                                    swal("Escuela Modelo", "No se ha seleccionado ningun alumno", "info");                                      
                              
                                }else{
                                    /*swal({
                                        title: "Escuela Modelo!",
                                        text: "Los alumnos seleccionados se han migrado con éxito",
                                        type: "success",
                                        timer: 3000
                                   }, 
                                   function(confimar){
                                      
                                    location.reload();
    
                                       if(confimar){
                                            location.reload();
                                       }
                                   })*/

                                   swal({
                                    title: "Escuela Modelo!",
                                    text: "Los alumnos seleccionados se han migrado con éxito",
                                    type: "success",
                                    timer: 3000
                                    });


                                   //inicio
                                    //Grupos origen
                                    document.getElementById('tablePrint').innerHTML = "";
                                    $("#grupo_id_destino").val("").trigger( "change" );
                                    

                                    var grupo_origen_id = $("#grupo_origen_id").val();
                                                
                                    $.get(base_url+`/bachiller_copiar_inscritos/api/getAlumnosDelGrupo/${grupo_origen_id}`,function(res,sta){                             
                                            
                             

                                        if(res.length > 0){
                                            //creamos la tabla
                                            let myTable= "<table><tr><th style=''><strong>Núm</strong></th>";
                                                //myTable+="<th style=''><strong>Núm</strong></th>";
                                                myTable+="<th style=''><strong>Clave Pago</strong></th>";
                                                myTable+="<th style=''><strong>Alumno</strong></th>";
                                                myTable+="<th style=''><strong>Seleccione</strong></th>";
                                                myTable+="</tr>";
                                    
                                                
                                                res.forEach(function (element, i) {

                                                    myTable+=`<tr><td>${i+1}</td>`; 
                                                    myTable+=`<td>${element.aluClave}</td>`;  
                                                    myTable+=`<td>${element.perApellido1} ${element.perApellido2} ${element.perNombre}</td>`;  
                                                    myTable+=`<td><div class='form-check checkbox-warning-filled' style="position:relative;"><input type="checkbox" class="noUpperCase filled-in" name="inscritoacopiar[]" id="inscritoAcopiar${element.id}" value="${element.id}"><label style="color: #000" for="inscritoAcopiar${element.id}"></label></div></td>`;
                                                        
                                                    myTable+="</tr>";
                                                });

                                                                        
                                                    
                                                myTable+="</table>";
                                                //pintamos la tabla 
                                                document.getElementById('tablePrint').innerHTML = myTable;

                                                //muestra el boton guardar
                                                $("#boton-guardar").show();
                                        }else{
                                            swal("Escuela Modelo", "No se han econtrado alumnos en el grupo de origen seleccionado", "info");                                      

                                            document.getElementById('tablePrint').innerHTML = "<h3 style='color:red'>No se han econtrado alumnos en el grupo de origen seleccionado</h3>";

                                        }
                                    });
                                   //fin
                                   
                                }
                     
                            }
                        });
                    }
                    
                      
                } else {
                    swal.close()
                }
            });
        });

    });
</script>