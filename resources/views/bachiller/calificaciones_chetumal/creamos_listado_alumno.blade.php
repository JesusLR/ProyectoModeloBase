<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        //$("#que_se_va_a_calificar").change( event => {
            var bachiller_cch_grupo_id = $("#bachiller_cch_grupo_id").val();
            //${event.target.value}
            
            $.get(base_url+`/bachiller_calificacion_seq/getCalificacionesAlumnosCCH/${bachiller_cch_grupo_id}`,function(res,sta){

                console.log(res)

                /*res.forEach(element => {
                    $("#cgt_id").append(`<option value=${element.id}>${element.cgtGradoSemestre}-${element.cgtGrupo}-${element.cgtTurno}</option>`);
                });*/
            });
        //});       

     });
</script>