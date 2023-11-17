<script>
    $(document).ready(function() {

        $(document).on("click", ".btn-guardar-migracion-acd", function(e) {

            var ubicacion_id = $("#ubicacion_id").val();
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            var grupo_origen_id = $("#grupo_origen_id").val();
            var grupo_id_destino = $("#grupo_id_destino").val();

            var inscritoacopiar =  $("input[name='inscritoacopiar[]']:checked").map(function () {
                return this.value;
               }).get();
    
            e.preventDefault();
    
            swal({
                title: "COPIAR HORARIO",
                text: "¿Desea continuar para copiar el horario del grupo(s) seleccionados?",
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

                        swal('Upsss', 'Favor de validar que el grupo de origen y el(los) grupo(s) destino este seleccionado', 'info');

                    }else{
                        $.ajax({
                            url: "{{route('bachiller.bachiller_copiar_horario.store')}}",
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
                                inscritoacopiar: inscritoacopiar                            
                            },
                            beforeSend: function () {

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
                                })
        
                            },
                            success: function(data){
                                $(".btn-guardar-migracion-acd").show();

                                console.log(data.res)
                                /*if(data.res == 'error'){
                                    swal("Escuela Modelo", "No se ha seleccionado un grado", "info");
                                } */
                            
                                if(!data.res) {

                                    swal("Escuela Modelo", "El grupo origen seleccionado no cuenta con horarios disponibles", "info");                              
                                }else{
                                    swal({
                                        title: "Escuela Modelo!",
                                        text: "Se ha realizado la copia de horario con éxito",
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
                    }
                    
                      
                } else {
                    swal.close()
                }
            });
        });

    });
</script>