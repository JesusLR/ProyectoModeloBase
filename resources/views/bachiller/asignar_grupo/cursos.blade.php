<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER ALUMNOS PREINSCRITOS POR semestre
        $("#gpoSemestreC").change( event => {          

            $("#cgt_id2").empty();
            $("#cgt_id2").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $("#tablePrint").html("");
            $("#tablePrintOptativa").html("");
            $("#tablePrintOcupacionales").html("");
            $("#tablePrintComplementaria").html("");
            $("#tablePrintExtras").html(""); 
            $("#tablePrintAcd").html("");

            $("#basica").hide(""); 
            $("#optativa").hide(""); 
            $("#ocupacional").hide(""); 
            $("#complementaria").hide(""); 
            $("#extras").hide(""); 

            var periodo_id = $("#periodo_id").val();
            $("#curso_id").empty();
            $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_asignar_grupo/api/cursos/${periodo_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#curso_id").append(`<option value=${element.id}>${element.alumno.aluClave}-${element.alumno.persona.perNombre} ${element.alumno.persona.perApellido1} ${element.alumno.persona.perApellido2}</option>`);
                });
            });
        });


        //por periodo semestre
        $("#periodo_id").change( event => {
            var gpoSemestreC = $("#gpoSemestreC").val();
            $("#curso_id").empty();
            $("#curso_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_asignar_grupo/api/cursos/${event.target.value}/${gpoSemestreC}`,function(res,sta){
                res.forEach(element => {
                    $("#curso_id").append(`<option value=${element.id}>${element.alumno.aluClave}-${element.alumno.persona.perNombre} ${element.alumno.persona.perApellido1} ${element.alumno.persona.perApellido2}</option>`);
                });
            });
        });
        

            
     });
     
</script>