<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            

            $.get(base_url+`/get/reporte/bachiller_grupo_materia/${periodo_id}/${event.target.value}`,function(res,sta){

                if(res.length > 0){
                    $("#matClave").empty();
                    $("#matClave").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {
                        $("#matClave").append(`<option value=${element.matClave}>${element.matClave}-${element.matNombre}</option>`);
                    });
                }else{
                    $("#matClave").empty();
                    $("#matClave").append(`<option value="">AUN NO HAY MATERIAS CARGADAS PARA EL PERIODO SELECCIONADO</option>`);
                }
                
            });
        });

        // OBTENER CGTS POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            
            $.get(base_url+`/get/reporte/bachiller_grupo_materia/${event.target.value}/${plan_id}`,function(res,sta){
                if(res.length > 0){
                    $("#matClave").empty();
                    $("#matClave").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {
                        $("#matClave").append(`<option value=${element.matClave}>${element.matClave}-${element.matNombre}</option>`);
                    });
                }else{
                    $("#matClave").empty();
                    $("#matClave").append(`<option value="">AUN NO HAY MATERIAS CARGADAS PARA EL PERIODO SELECCIONADO</option>`);
                }
            });
        });

     });
</script>