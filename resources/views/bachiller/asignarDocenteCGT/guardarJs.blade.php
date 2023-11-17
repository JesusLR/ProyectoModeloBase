<script>
    $(document).ready(function() {

        
        $(document).on("click", ".btn-guardar-grupo-cgt", function(e) {


            var a = document.querySelectorAll("input.micheckbox");
            //Ahora vamos hacer uso del Prototype de JS para digamos recorrer todo lo que se ha generado desde la variable a y lo devolvemos a la variable ids_ 
            var bachiller_grupo_id =  $("input[name='bachiller_grupo_id[]']:checked").map(function () {
                return this.value;
               }).get();

            var empleado_id = $("#empleado_id").val();
            var ubicacion_id = $("#ubicacion_id").val();

            
            e.preventDefault();

            

            swal({
                title: "Asignar docente",
                text: "¿Asignar Docente a Grupos Materias Seleccionados?",
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
                        url: "{{route('bachiller.bachiller_asignar_docente.store')}}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            "_token": $("meta[name=csrf-token]").attr("content"),
                            bachiller_grupo_id: bachiller_grupo_id,
                            empleado_id: empleado_id,
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
                                title: "Actualizando...",
                                text: html,
                                showConfirmButton: false
                                //confirmButtonText: "Ok",
                            })

                        },
                        success: function(data){

                            if(data.res == 'error'){
                                swal("Escuela Modelo", "No se ha seleccionado al menos una materia", "info");
                            } else if(data.res == "sinEmpleado"){

                                swal("Escuela Modelo", "No se ha seleccioando algun docente", "info");

                            }else{                                
                                swal("Escuela Modelo", "Se ha asignado docente éxitosamente a los grupos seleccionados", "success");
                                location.reload();
                            }
                 
                        }
                      });
                      
                    swal.close()
                } else {
                    swal.close()
                }
            });
        });
    });
</script>

