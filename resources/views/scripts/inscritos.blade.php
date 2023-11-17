<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER GRUPOS POR ALUMNO PREINSCRITO SELECCIONADO
        $("#curso_id").change( event => {
            $("#grupo_id").empty();
            $("#grupo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/api/grupos/${event.target.value}`, function(res, sta) {

                res.forEach(element => {
                    if (!element.optNombre) {
                        $("#grupo_id").append(`<option value=${element.id}>
                            Grupo: ${element.gpoSemestre}-${element.gpoClave}-${element.gpoTurno}
                            Materia: ${element.matClave}-${element.matNombre}
                            Maestro:${element.empleadoId}-${element.perNombre} ${element.perApellido1} ${element.perApellido2}
                        </option>`);
                    }

                    if (element.optNombre) {
                        $("#grupo_id").append(`<option value=${element.id}>
                            Grupo: ${element.gpoSemestre}-${element.gpoClave}-${element.gpoTurno}
                            Materia: ${element.matClave}-${element.matNombre}-${element.optNombre}
                            Maestro:${element.empleadoId}-${element.perNombre} ${element.perApellido1} ${element.perApellido2}
                        </option>`);
                    }

                });
            });
        });

     });
</script>