<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER GRUPOS POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var numeroGrado = $("#numeroGrado").val();

            $("#primaria_grupo_id_select").empty();
            $("#primaria_grupo_id_select").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/primaria_reporte/getGruposGrado/${event.target.value}/${plan_id}/${numeroGrado}`,function(res,sta){
                res.forEach(element => {

                    if(element.matClaveAsignatura == null){
                        $("#primaria_grupo_id_select").append(`<option value=${element.id}>${element.gpoGrado}-${element.gpoClave} Materia: ${element.matClave}-${element.matNombre}</option>`);
                    }else{
                        $("#primaria_grupo_id_select").append(`<option value=${element.id}>${element.gpoGrado}-${element.gpoClave} Materia: ${element.matClave}-${element.matNombre} Asignatura: ${element.matClaveAsignatura}-${element.matNombreAsignatura}</option>`);
                    }
                    
                });
            });
        });

        // OBTENER GRUPOS POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var numeroGrado = $("#numeroGrado").val();

            $("#primaria_grupo_id_select").empty();
            $("#primaria_grupo_id_select").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/primaria_reporte/getGruposGrado/${periodo_id}/${event.target.value}/${numeroGrado}`,function(res,sta){
                res.forEach(element => {
                    if(element.matClaveAsignatura == null){
                        $("#primaria_grupo_id_select").append(`<option value=${element.id}>${element.gpoGrado}-${element.gpoClave} Materia: ${element.matClave}-${element.matNombre}</option>`);
                    }else{
                        $("#primaria_grupo_id_select").append(`<option value=${element.id}>${element.gpoGrado}-${element.gpoClave} Materia: ${element.matClave}-${element.matNombre} Asignatura: ${element.matClaveAsignatura}-${element.matNombreAsignatura}</option>`);
                    }
                });
            });
        });

        // OBTENER GRUPOS POR GRADO
        $("#numeroGrado").change( event => {
            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();

            
            $("#primaria_grupo_id_select").empty();
            $("#primaria_grupo_id_select").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/primaria_reporte/getGruposGrado/${periodo_id}/${plan_id}/${event.target.value}`,function(res,sta){

                console.log(res)
                res.forEach(element => {
                    if(element.matClaveAsignatura == null){
                        $("#primaria_grupo_id_select").append(`<option value=${element.id}>${element.gpoGrado}-${element.gpoClave} Materia: ${element.matClave}-${element.matNombre}</option>`);
                    }else{
                        $("#primaria_grupo_id_select").append(`<option value=${element.id}>${element.gpoGrado}-${element.gpoClave} Materia: ${element.matClave}-${element.matNombre} Asignatura: ${element.matClaveAsignatura}-${element.matNombreAsignatura}</option>`);
                    }
                });
            });
        });
        

     });
</script>