<script type="text/javascript">

    $(document).ready(function() {
        // OBTENER PLANES
        $("#plan_id").change( event => {
            $("#nivel_id").empty();

        
            // $("#cgt_id").empty();
            // $("#materia_id").empty();
            $("#nivel_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            // $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            // $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            
            $.get(base_url+`/idiomas_nivel/niveles/${event.target.value}`,function(res,sta){
                //seleccionar el post preservado
                var planSeleccionadoOld = $("#nivel_id").data("plan-idold")
                $("#nivel_id").empty()
                
                res.forEach(element => {
                    var selected = "";
                    if (element.id === planSeleccionadoOld) {
                        selected = "selected";
                    }


                    $("#nivel_id").append(`<option value=${element.nivGrado} ${selected}>${element.nivDescripcion}</option>`);
                });

                $('#nivel_id').trigger('change'); // Notify only Select2 of changes
            });
        });

     });
</script>