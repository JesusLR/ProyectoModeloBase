<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            $("#primaria_grupo_id").empty();
            $("#primaria_grupo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/primaria_inscrito_modalidad/getMateriasAsignaturas/${periodo_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
             
                    if(element.matClaveAsignatura == "" || element.matClaveAsignatura == null || element.matClaveAsignatura == "null"){
                        $("#primaria_grupo_id").append(`<option value=${element.id}>Grupo: ${element.gpoGrado}${element.gpoClave}, Materia: ${element.matClave}-${element.matNombre} 
                        </option>`);
                    }else{                      

                        $("#primaria_grupo_id").append(`<option value=${element.id}>Grupo: ${element.gpoGrado}${element.gpoClave}, Materia: ${element.matClave}-${element.matNombre}, 
                            Asignatura: ${element.matClaveAsignatura}-${element.matNombreAsignatura}</option>`);
                    }
                });
            });
        });

        // OBTENER POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            $("#primaria_grupo_id").empty();
            $("#primaria_grupo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/primaria_inscrito_modalidad/getMateriasAsignaturas/${event.target.value}/${plan_id}`,function(res,sta){
                res.forEach(element => {
                    if(element.matClaveAsignatura == "" || element.matClaveAsignatura == null || element.matClaveAsignatura == "null"){
                        $("#primaria_grupo_id").append(`<option value=${element.id}>Grupo: ${element.gpoGrado}${element.gpoClave}, Materia: ${element.matClave}-${element.matNombre} 
                        </option>`);
                    }else{                        
                        $("#primaria_grupo_id").append(`<option value=${element.id}>Grupo: ${element.gpoGrado}${element.gpoClave}, Materia: ${element.matClave}-${element.matNombre}, 
                            Asignatura: ${element.matClaveAsignatura}-${element.matNombreAsignatura}</option>`);
                    }

                });
            });
        });

     });
</script>