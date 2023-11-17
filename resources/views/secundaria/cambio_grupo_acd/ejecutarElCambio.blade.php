<script>
    $(document).ready(function() {

        
        $(document).on("click", "#ejecutar_el_cambio", function(e) {


            var curso_id = $("#curso_id").val();
            var grupo_id_origen = $("#grupo_id_origen").val();
            var grupo_id_destino = $("#grupo_id_destino").val();

            
            e.preventDefault();
            

            swal({
                title: "Cambiar grupo ACD",
                text: "¿Seguro que desea continuar con el cambio de grupo ACD?",
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
                        url: "{{route('secundaria.secundaria_cambio_grupo_acd.cambiar_grupo_acd')}}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            "_token": $("meta[name=csrf-token]").attr("content"),
                            curso_id: curso_id,
                            grupo_id_origen: grupo_id_origen,
                            grupo_id_destino: grupo_id_destino                           
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
                               
                          console.log(data.resultado)
                          if(data.resultado == "no_es_igual"){
                            swal("Escuela Modelo", "No se ha podido realizar el cambio de grupo ACD. Debe seleccionar un grupo con la misma materia ACD a cambiar", "info");
                          }

                          if(data.resultado == "true"){
                            swal("Escuela Modelo", "El cambio de grupo ACD se a realizado correctamente", "success");

                            location.reload();
                          }

                          if(data.resultado == "mismo_grupo"){
                            swal("Escuela Modelo", "El grupo destino seleccionado es el mismo donde actualmente se encuentra el alumno", "info");

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

