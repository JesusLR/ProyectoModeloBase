<script>
    $(document).ready(function() {

        $(document).on("click", ".btn-guardar-migracion-acd", function(e) {

            var periodo_id = $("#periodo_id").val();
            var gpoGrado = $("#gpoGrado").val()
            var ubicacion_id = $("#ubicacion_id").val()

    
            e.preventDefault();
    
            
    
            swal({
                title: "Cargar materias",
                text: "¿Desea continuar para migrar las materias ACD?",
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
                        url: "{{route('secundaria.secundaria_migrar_inscritos_acd.store')}}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            "_token": $("meta[name=csrf-token]").attr("content"),
                            periodo_id: periodo_id,
                            gpoGrado: gpoGrado,
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
                                swal("Escuela Modelo", "No se ha seleccionado un grado", "info");
                            } 
                        
                            if(data.res == 'true') {
                                
                                swal({
                                    title: "Escuela Modelo!",
                                    text: "Los grupos ACD se han migrado con éxito",
                                    type: "success",
                                    timer: 3000
                               }, 
                               function(confimar){
                                  
                                location.reload();

                                   if(confimar){
                                        location.reload();
                                   }
                               })
                                  
                          
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