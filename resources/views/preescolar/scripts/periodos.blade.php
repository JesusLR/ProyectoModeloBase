<script type="text/javascript">

    $(document).ready(function() {

        //OBTENER FECHA PERIODO
        $("#periodo_id").change( event => {
            $("#perFechaInicial").val('');
            $("#perFechaFinal").val('');
            //INSCRITOS
            $("#curso_id").empty();
            $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#grupo_id").empty();
            $("#grupo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            Materialize.updateTextFields();
            $.get(base_url+`/preescolar_periodo/periodo/${event.target.value}`,function(res,sta){
                $("#perFechaInicial").val(res.perFechaInicial);
                $("#perFechaFinal").val(res.perFechaFinal);
                Materialize.updateTextFields();
            });
        });

        var periodo_id = $("#periodo_id").val();
        $("#perFechaInicial").val('');
            $("#perFechaFinal").val('');
            //INSCRITOS
            $("#curso_id").empty();
            $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#grupo_id").empty();
            $("#grupo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            Materialize.updateTextFields();
            $.get(base_url+`/preescolar_periodo/periodo/${periodo_id}`,function(res,sta){
                $("#perFechaInicial").val(res.perFechaInicial);
                $("#perFechaFinal").val(res.perFechaFinal);
                Materialize.updateTextFields();
            });
     });
</script>