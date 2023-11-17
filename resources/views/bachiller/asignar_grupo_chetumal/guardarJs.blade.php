<script>
    $(document).ready(function() {

        if($("#cgt_id2").val() == null || $("#curso_id").val() == null){
            $("#btn_guardar_inscrito").hide();
        }


        $("#curso_id").change(function(){

            if($("#cgt_id2").val() == null || $('select[id=curso_id]').val() == null){
                $("#btn_guardar_inscrito").show();
            }
            
	    });

        $("#cgt_id2").change(function(){

            if($("#curso_id").val() == null || $('select[id=cgt_id2]').val() == null){
                $("#btn_guardar_inscrito").show();
            }
            
	    });
        
        $(document).on("click", "#btn_guardar_inscrito", function(e) {

            
            var info_alumno = $('select[name="curso_id"] option:selected').text();

            //Ahora vamos hacer uso del Prototype de JS para digamos recorrer todo lo que se ha generado desde la variable a y lo devolvemos a la variable ids_ 
            var grupo_id =  $("input[name='grupo_id[]']:checked").map(function () {
                return this.value;
               }).get();

               var curso_id = $("#curso_id").val();
               var cgt_id2 = $("#cgt_id2").val();
               var periodo_id = $("#periodo_id").val();
               var plan_id = $("#plan_id").val();


            //e.preventDefault();

            if(cgt_id2 == null || curso_id == null){
                swal("Escuela Modelo", "Por favor seleccione todos los campos obligatorios", "warning");
            }else{
                swal({
                    title: "IMPORTANTE",
                    text: `Este proceso realiza la inscripción del ALUMNO: [* ${info_alumno} ***] a los GRUPOS MATERIAS SELECCIONADAS DEL LISTADO ANTERIOR y que corresponden a las tipos de materias básicas, optativas, ocupacionales, complementarias y extras. Solamente se realizará la inscripción a los GRUPOS MATERIAS en los cuales NO SE ENCUENTRE INSCRITO EL ALUMNO. ¿Desea continuar con el proceso?`,
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
                            url: "{{route('bachiller.bachiller_asignar_grupo_seq.store_por_grupo')}}",
                            method: "POST",
                            dataType: "json",
                            data: {
                                "_token": $("meta[name=csrf-token]").attr("content"),
                                grupo_id: grupo_id,
                                curso_id: curso_id,
                                periodo_id: periodo_id,
                                plan_id: plan_id,
                                cgt_id2: cgt_id2            
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
    
                                console.log(data.respuesta)
                                if(data.respuesta == "true"){
                                    swal("Escuela Modelo", "El alumno a sido inscrito a los grupos seleccionados éxitosamente", "success");

                                    $("#tablePrint").html("");
                                    $("#tablePrintOptativa").html("");
                                    $("#tablePrintOcupacionales").html("");
                                    $("#tablePrintComplementaria").html("");
                                    $("#tablePrintExtras").html(""); 

                                    $("#basica").hide(""); 
                                    $("#optativa").hide(""); 
                                    $("#ocupacional").hide(""); 
                                    $("#complementaria").hide(""); 
                                    $("#extras").hide(""); 

                                    $("#cgt_id2").val("").trigger( "change" );

                                    //swal.close();
                                }
    
                                if(data.respuesta == "false"){
                                    swal("Escuela Modelo", "No se ha seleccionado ningun grupo", "info");

                                    
                                }
                               
                     
                            }
                          });
                          
                       
                    } else {
                        swal.close()
                    }
                });
            }
            

            
        });
    });
</script>

