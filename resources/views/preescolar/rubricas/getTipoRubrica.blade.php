<script type="text/javascript">
    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        $("#programa_id").change( event => {
            
            $("#preescolar_rubricas_tipo_id").empty();
            $("#preescolar_rubricas_tipo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/preescolar_rubricas/getRubrica/${event.target.value}`,function(res,sta){

                var programa_ipreescolar_rubricas_tipo_id = $("#preescolar_rubricas_tipo").data("preescolar_rubricas_tipo")

                res.forEach(element => {
                    var selected = "";
                    if (element.id === programa_ipreescolar_rubricas_tipo_id) {
                        console.log("entra")
                        console.log(element.id)
                        selected = "selected";
                    }
                    $("#preescolar_rubricas_tipo_id").append(`<option value='${element.id}' ${selected}>${element.tipo}</option>`);
                });
            });
        });


            var programa_id = $("#programa_id").val();
        
            $("#preescolar_rubricas_tipo_id").empty();
            $("#preescolar_rubricas_tipo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/preescolar_rubricas/getRubrica/${programa_id}`,function(res,sta){

                var programa_ipreescolar_rubricas_tipo_id = $("#preescolar_rubricas_tipo_id").data("preescolar_rubricas_tipo")

                res.forEach(element => {
                    var selected = "";
                    if (element.id === programa_ipreescolar_rubricas_tipo_id) {
                        console.log("entra")
                        console.log(element.id)
                        selected = "selected";
                    }
                    $("#preescolar_rubricas_tipo_id").append(`<option value='${element.id}' ${selected}>${element.tipo}</option>`);
                });
            });

     });
</script>