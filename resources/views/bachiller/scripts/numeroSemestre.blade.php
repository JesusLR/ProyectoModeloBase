<script type="text/javascript">
    $(document).ready(function() {
        // OBTENER PLANES
        $("#periodo_id").change(event => {
    
            $("#matSemestre").empty();
            $("#matSemestre").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
    
    
            $.get(base_url + `/bachiller_api/obtenerNumerosSemestre/${event.target.value}`, function(res, sta) {
                //seleccionar el post preservado
                var semestreOld = $("#matSemestre").data("gposemestre-id")
    
                res.forEach(element => {
                    var selected = "";
                    if (element.semestre === semestreOld) {
                        selected = "selected";
                    }
    
    
                    $("#matSemestre").append(`<option value=${element.semestre} ${selected}>${element.semestre}</option>`);
                });
    
            });
        });
    
        /*var periodo_id = $("#periodo_id").val();
        $("#matSemestre").empty();
        $("#matSemestre").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
    
    
        $.get(base_url + `/bachiller_api/obtenerNumerosSemestre/${periodo_id}`, function(res, sta) {
            //seleccionar el post preservado
            var semestreOld = $("#matSemestre").data("gposemestre-id")
    
            res.forEach(element => {
                var selected = "";
                if (element.semestre === semestreOld) {
                    selected = "selected";
                }
    
    
                $("#matSemestre").append(`<option value=${element.semestre} ${selected}>${element.semestre}</option>`);
            });
    
        });*/
    
    });
</script>