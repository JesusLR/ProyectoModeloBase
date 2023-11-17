<script>
    $(document).ready(function() {

        $(document).on("click", ".btn-guardar-cargar-materias", function(e) {

            var curso_id = $("#curso_id").val();
            var cgt_id = $("#cgt_id").val()
             
    
            e.preventDefault();
    
            
    
            swal({
                title: "Cargar materias",
                text: "¿Desea continuar para cargas las materias al alumno seleccionado?",
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
                        url: "{{route('primaria.primaria_materias_inscrito.store')}}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            "_token": $("meta[name=csrf-token]").attr("content"),
                            curso_id: curso_id,
                            cgt_id: cgt_id
                            
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
                                swal("Escuela Modelo", "No se ha seleccionado el CGT correspondiente", "info");
                            } 
                            if(data.res == false){
    
                                swal("Escuela Modelo", "Los grupos que intenta crear ya existen", "error");
    
                            }
                            if(data.res == 'true') {
                                
                                swal({
                                    title: "Escuela Modelo!",
                                    text: "Las materias correspondientes se han agregado con éxito",
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