<script type="text/javascript">

    $("#tipoReporte").change(function() {

        //Solo por grado
        if ($('select[id=tipoReporte]').val() == "1") {
            $("#divGpoGrado").show();
            $("#divGpoGrupo").hide();
            $("#divGpoMatComplementaria").hide();
            $("#gpoGrado").prop('required', true);
            $("#gpoGrupo").prop('required', false);
            $("#gpoMatComplementaria").prop('required', false);

    
            $("#gpoGrado").empty();
            $("#gpoGrado").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
            var gpoGradoSeleccionadoOld = $("#gpoGrado").data("gpoGrado-id")

            for (var i = 1; i < 4; i++) {
                
                var selected = "";
                        if (i === gpoGradoSeleccionadoOld) {
                            console.log("entra")
                            console.log(element.id)
                            selected = "selected";
                        }
    
                $("#gpoGrado").append(`<option value=${i} ${selected}>${i}</option>`);
    
            }
    
    
        }
    
        //Solo por nombre de grupo
        if ($('select[id=tipoReporte]').val() == "2") {
            $("#divGpoGrado").hide();
            $("#divGpoGrupo").hide();
            $("#divGpoMatComplementaria").show();
            $("#gpoGrado").prop('required', false);
            $("#gpoMatComplementaria").prop('required', true);

    
    
            /* ----------------------- Aqui los metodos de select ----------------------- */
    
            //por Programa
            $("#programa_id").change(event => {

                $("#gpoGrado").prop('required', false);
                $("#gpoGrupo").prop('required', false);
                $("#gpoMatComplementaria").prop('required', false);

                var plan_id = $("#plan_id").val();
                var periodo_id = $("#periodo_id").val();
                $("#gpoMatComplementaria").empty();
                $("#gpoMatComplementaria").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
                $.get(base_url + `/secundaria_reporte/lista_de_asistencia_ACD/getMateriasComplementarias/${event.target.value}/${plan_id}/${periodo_id}`, function(res, sta) {
                    res.forEach(element => {
                        $("#gpoMatComplementaria").append(`<option value="${element.gpoMatComplementaria}">${element.gpoMatComplementaria}</option>`);
                    });
                });
            });
    
            //Por plan
            $("#plan_id").change(event => {

                $("#gpoGrado").prop('required', false);
                $("#gpoGrupo").prop('required', false);
                $("#gpoMatComplementaria").prop('required', false);

                var programa_id = $("#programa_id").val();
                var periodo_id = $("#periodo_id").val();
                $("#gpoMatComplementaria").empty();
                $("#gpoMatComplementaria").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
                $.get(base_url + `/secundaria_reporte/lista_de_asistencia_ACD/getMateriasComplementarias/${programa_id}/${event.target.value}/${periodo_id}`, function(res, sta) {
                    res.forEach(element => {
                        $("#gpoMatComplementaria").append(`<option value="${element.gpoMatComplementaria}">${element.gpoMatComplementaria}</option>`);
                    });
                });
            });
    
            //por periodo
            $("#periodo_id").change(event => {

                $("#gpoGrado").prop('required', false);
                $("#gpoGrupo").prop('required', false);
                $("#gpoMatComplementaria").prop('required', false);

                var programa_id = $("#programa_id").val();
                var plan_id = $("#plan_id").val();
                $("#gpoMatComplementaria").empty();
                $("#gpoMatComplementaria").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
                $.get(base_url + `/secundaria_reporte/lista_de_asistencia_ACD/getMateriasComplementarias/${programa_id}/${plan_id}/${event.target.value}`, function(res, sta) {
                    res.forEach(element => {
                        $("#gpoMatComplementaria").append(`<option value="${element.gpoMatComplementaria}">${element.gpoMatComplementaria}</option>`);
                    });
                });
            });
    
    
            $("#gpoGrado").prop('required', false);
                $("#gpoGrupo").prop('required', false);
                $("#gpoMatComplementaria").prop('required', false);
            //Carga cuando ya ests seleccinado los datos del filtro 
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
    
            $("#gpoMatComplementaria").empty();
            $("#gpoMatComplementaria").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url + `/secundaria_reporte/lista_de_asistencia_ACD/getMateriasComplementarias/${programa_id}/${plan_id}/${periodo_id}`, function(res, sta) {
                res.forEach(element => {
                    $("#gpoMatComplementaria").append(`<option value="${element.gpoMatComplementaria}">${element.gpoMatComplementaria}</option>`);
                });
            });
    
            /* ------------------------ Fin de los metodos select ----------------------- */
    
        }
    
        //solo por Grado y grupo
        if ($('select[id=tipoReporte]').val() == "3") {
            $("#divGpoGrado").show();
            $("#divGpoGrupo").show();
            $("#divGpoMatComplementaria").hide();
            $("#gpoGrado").prop('required', true);
            $("#gpoGrupo").prop('required', true);
            $("#gpoMatComplementaria").prop('required', false);

            $("#gpoGrado").empty();
            $("#gpoGrado").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
        
            var gpoGradoSeleccionadoOld = $("#gpoGrado").data("gpoGrado-id")

            for (var i = 1; i < 4; i++) {
                
                var selected = "";
                        if (i === gpoGradoSeleccionadoOld) {
                            console.log("entra")
                            console.log(element.id)
                            selected = "selected";
                        }
    
                $("#gpoGrado").append(`<option value=${i} ${selected}>${i}</option>`);
    
            }
    
            /* ---------------------------------- Aqui ---------------------------------- */
    
            $("#plan_id").change(event => {
                var programa_id = $("#programa_id").val();
                var periodo_id = $("#periodo_id").val();
                var gpoGrado = $('select[id=gpoGrado]').val()
    
                
                $.get(base_url + `/secundaria_reporte/lista_de_asistencia_ACD/getGruposACD/${programa_id}/${event.target.value}/${periodo_id}/${gpoGrado}`, function(res, sta) {
                    $("#gpoGrupo").empty();
                    $("#gpoGrupo").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);

                    var gpoGrupoSeleccionadoOld = $("#gpoGrupo").data("gpoGrupo-id")

                    res.forEach(element => {

                        /*var selected = "";
                        if (element.id === gpoGrupoSeleccionadoOld) {
                            console.log("entra")
                            console.log(element.id)
                            selected = "selected";
                        }*/
                        $("#gpoGrupo").append(`<option value=${element.id}>Clave: ${element.gpoClave} -- Nombre: ${element.gpoMatComplementaria}</option>`);
                    });
                });
            });
    
            $("#periodo_id").change(event => {
                var programa_id = $("#programa_id").val();
                var plan_id = $("#plan_id").val();
                var gpoGrado = $('select[id=gpoGrado]').val()
    
                
                $.get(base_url + `/secundaria_reporte/lista_de_asistencia_ACD/getGruposACD/${programa_id}/${plan_id}/${event.target.value}/${gpoGrado}`, function(res, sta) {
                    $("#gpoGrupo").empty();
                    $("#gpoGrupo").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
                    var gpoGrupoSeleccionadoOld = $("#gpoGrupo").data("gpoGrupo-id")

                    res.forEach(element => {

                        /*var selected = "";
                        if (element.id === gpoGrupoSeleccionadoOld) {
                            console.log("entra")
                            console.log(element.id)
                            selected = "selected";
                        }*/
                        $("#gpoGrupo").append(`<option value=${element.id}>Clave: ${element.gpoClave} -- Nombre: ${element.gpoMatComplementaria}</option>`);
                    });
                });
            });
    
            $("#gpoGrado").change(event => {
                var programa_id = $("#programa_id").val();
                var plan_id = $("#plan_id").val();
                var periodo_id = $('#periodo_id').val()
    
                
                $.get(base_url + `/secundaria_reporte/lista_de_asistencia_ACD/getGruposACD/${programa_id}/${plan_id}/${periodo_id}/${event.target.value}`, function(res, sta) {
                    $("#gpoGrupo").empty();
                    $("#gpoGrupo").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
                    var gpoGrupoSeleccionadoOld = $("#gpoGrupo").data("gpoGrupo-id")

                    res.forEach(element => {

                        /*var selected = "";
                        if (element.id === gpoGrupoSeleccionadoOld) {
                            console.log("entra")
                            console.log(element.id)
                            selected = "selected";
                        }*/
                        $("#gpoGrupo").append(`<option value=${element.id}>Clave: ${element.gpoClave} -- Nombre: ${element.gpoMatComplementaria}</option>`);
                    });
                });
            });
    
            var gpoGrado = $('select[id=gpoGrado]').val();
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
    
           
            $.get(base_url + `/secundaria_reporte/lista_de_asistencia_ACD/getGruposACD/${programa_id}/${plan_id}/${periodo_id}/${gpoGrado}`, function(res, sta) {
                $("#gpoGrupo").empty();
                $("#gpoGrupo").append(`<option value="">SELECCIONE UNA OPCIÓN</option>`);
                var gpoGrupoSeleccionadoOld = $("#gpoGrupo").data("gpoGrupo-id")

                    res.forEach(element => {
                        $("#gpoGrupo").append(`<option value=${element.id}>Clave: ${element.gpoClave} -- Nombre: ${element.gpoMatComplementaria}</option>`);
                    });
            });
    
            /* ----------------------------------- fin ---------------------------------- */
    
    
        }
    });
   
</script>