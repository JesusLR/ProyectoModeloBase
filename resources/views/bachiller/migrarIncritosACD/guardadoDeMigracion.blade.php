<script>
    $(document).ready(function() {

        $(document).on("click", ".btn-guardar-migracion-acd", function(e) {

            var ubicacion_id = $("#ubicacion_id").val();
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            var grupo_origen_id = $("#grupo_origen_id").val();
            var periodo_id_destino = $("#periodo_id_destino").val();
            var gpoGrado_destino = $("#gpoGrado_destino").val();
            var grupo_id_destino = $("#grupo_id_destino").val();
            //var alumno_id = $("#alumno_id").val();
            var alumno_id =  $("input[name='alumno_id[]']:checked").map(function () {
                return this.value;
               }).get();
            e.preventDefault();

    
            swal({
                title: "Cargar materias",
                text: "¿Desea continuar para copiar los alumnos de esta materia?",
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
                            url: "{{route('bachiller.bachiller_migrar_inscritos_acd.store')}}",
                            method: "POST",
                            dataType: "json",
                            data: {
                                "_token": $("meta[name=csrf-token]").attr("content"),
                                ubicacion_id: ubicacion_id,
                                programa_id: programa_id,
                                plan_id: plan_id,
                                periodo_id: periodo_id, 
                                grupo_origen_id: grupo_origen_id,  
                                periodo_id_destino: periodo_id_destino,
                                gpoGrado_destino: gpoGrado_destino,  
                                grupo_id_destino: grupo_id_destino,
                                alumno_id: alumno_id                               
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

                                if(data.res == 'error'){
                                    swal("Escuela Modelo", "No se ha seleccionado un grado", "info");
                                } 
                            
                                if(data.res) {

                                    
                                   swal({
                                        title: "Escuela Modelo!",
                                        text: "Los alumnos inscritos del grupo seleccionado se han copiado con éxito",
                                        type: "success",
                                        timer: 3000
                                   }, 
                                   function(confimar){
                                      
                                    //location.reload();

                                    $("#grupo_id_destino").val("").trigger( "change" );
    
                                       if(confimar){
                                            //location.reload();
                                            $("#grupo_id_destino").val("").trigger( "change" );
                                       }
                                   })

                                   
                                      
                              
                                }else{
                                    swal("Escuela Modelo!", "No sea procesado la solitud debido que grupo origen seleccionado no contiene alumnos", "warning");
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