<script type="text/javascript">

    $(document).ready(function() {

        $("#periodo_id").change( event => {
            var programa_id = $("#programa_id").val();
            $("#actividad_id").empty();
            $("#actividad_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/preescolar_actividades_inscritos/getActividades/${event.target.value}/${programa_id}`,function(res,sta){
                res.forEach(element => {
                    if(element.empApellido1 == "" || element.empApellido1 == null){
                        $("#actividad_id").append(`<option value=${element.id}>${element.actGrupo} - ${element.actDescripcion}</option>`);

                    }else{
                        $("#actividad_id").append(`<option value=${element.id}>${element.actGrupo} - ${element.actDescripcion} - Instructor: ${element.empApellido1} ${element.empApellido2} ${element.empNombre}</option>`);


                    }
                });
            });
        });
        

        $("#programa_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            $("#actividad_id").empty();
            $("#actividad_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/preescolar_actividades_inscritos/getActividades/${periodo_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    if(element.empApellido1 == "" || element.empApellido1 == null){
                        $("#actividad_id").append(`<option value=${element.id}>${element.actGrupo} - ${element.actDescripcion}</option>`);

                    }else{
                        $("#actividad_id").append(`<option value=${element.id}>${element.actGrupo} - ${element.actDescripcion} - Instructor: ${element.empApellido1} ${element.empApellido2} ${element.empNombre}</option>`);


                    }                
                });
            });
        });


        var actividad_id_id = $("#actividad_id_id").val();
        var periodo_id = $("#periodo_id").val();
        var programa_id = $("#programa_id").val();

        $("#actividad_id").empty();
        $("#actividad_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
        $.get(base_url+`/preescolar_actividades_inscritos/getActividades/${periodo_id}/${programa_id}`,function(res,sta){
            
            res.forEach(element => {
                if(element.empApellido1 == "" || element.empApellido1 == null){
                    $("#actividad_id").append(`<option value=${element.id} select=${actividad_id_id}>${element.actGrupo} - ${element.actDescripcion}</option>`);                    

                }else{
                    $("#actividad_id").append(`<option value=${element.id} select=${actividad_id_id}>${element.actGrupo} - ${element.actDescripcion} - Instructor: ${element.empApellido1} ${element.empApellido2} ${element.empNombre}</option>`);
                }        
                
                $("#actividad_id option[value="+ actividad_id_id +"]").attr("selected",true);
            });
        });

     });
</script>