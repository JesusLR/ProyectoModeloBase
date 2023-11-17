<script>
    $(document).ready(function() {

        
        $(document).on("click", ".btn-guardar-grupo-cgt", function(e) {            
            

            var a = document.querySelectorAll("input.micheckbox");
            //Ahora vamos hacer uso del Prototype de JS para digamos recorrer todo lo que se ha generado desde la variable a y lo devolvemos a la variable ids_ 
            var bachiller_materia =  $("input[name='bachiller_materia[]']:checked").map(function () {
                return this.value;
               }).get();

            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();
            var cgt_id = $("#cgt_id").val();
            var ubicacion_id = $("#ubicacion_id").val();



            e.preventDefault();

            

            swal({
                title: "Asignar materias",
                text: "¿Desea generar los grupos de las materias seleccionadas e inscribir a los alumnos cargados al CGT ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#0277bd',
                confirmButtonText: 'SI',
                cancelButtonText: "NO",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    
                    $.ajax({
                        url: "{{route('bachiller.bachiller_cgt_materias.store')}}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            "_token": $("meta[name=csrf-token]").attr("content"),
                            periodo_id: periodo_id,
                            plan_id: plan_id,
                            cgt_id: cgt_id,
                            bachiller_materia: bachiller_materia,
                            ubicacion_id: ubicacion_id
                        },
                        beforeSend: function () {
                                              
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
                            })

                        },
                        success: function(data){

                            if(data.res == 'error'){
                                swal("Escuela Modelo", "No se ha seleccionado al menos un grupo", "info");
                            } else if(data.res == false){

                                swal("Escuela Modelo", "Los grupos que intenta crear ya existen", "error");

                            }else{
                                
                                swal("Escuela Modelo", "Los grupos se crearon con éxito", "success");
                                location.reload();
                            }
                       
                 
                        }
                      });
                      
                } else {
                    swal.close()
                }
            });
        });
    });
</script>