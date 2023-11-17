<script type="text/javascript">

$(document).ready(function() {
    $.get(base_url+`/api/alumnos`,function(res,sta) {

        res.forEach(element => {
            $("#alumno_id").append(`<option value=${element.alumno_id}>${element.aluClave}-${element.perNombre} ${element.perApellido1} ${element.perApellido2}</option>`);
        });
    });
});
</script>