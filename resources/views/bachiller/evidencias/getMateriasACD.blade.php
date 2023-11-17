<script type="text/javascript">

    $(document).ready(function() {

        //POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var materia_id = $("#materia_id").val();
            var MateriaSemestre = $("#MateriaSemestre").val();
            var contadorRestantes = $("#contadorRestantes").val();

            
            $.get(base_url+`/bachiller_evidencias/getMateriasACD/${event.target.value}/${plan_id}/${materia_id}`,function(res,sta){
                if(res.length < 1){             
                   
        
                    //validando materias sin ACD
                    $.get(base_url+`/bachiller_evidencias/sinACDgetMateriasEvidenciasPeriodo/${event.target.value}/${materia_id}/${MateriaSemestre}`,function(res,sta){
                        var datos = res.length;
                        var sumarPuntos = 0;
                        var sumarPuntosProceso = 0;
                        var sumarPuntosProducto = 0;
        
        
                        if(datos > 0){
                            res.forEach(function (element, i) {
        
                                sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                $("#contador").val(sumarPuntos);
        
                                if(element.eviTipo == "A"){
                                    sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                    $("#puntosProceso").val(sumarPuntosProceso);
        
                                }
        
                                if(element.eviTipo == "P"){
                                    sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                    $("#puntosProducto").val(sumarPuntosProducto);
        
                                }
        
                                if(sumarPuntos < 100){
                                    $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                    swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
                                }else{
                                    $("#contadorRestantes").val(0);
                                    swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                }
        
                            });
                        }else{
                            $("#contador").val(0);
                            $("#contadorRestantes").val(100);
                            $("#puntosProceso").val(0);
                            $("#puntosProducto").val(0);
        
        
                        }
                    });

                    $("#materia_acd_id_label").html("Materia complementaria");
                    $("#materia_acd_id").empty();
                    $("#materia_acd_id").append(`<option value="NULL">SELECCIONE UNA OPCIÓN</option>`);
                    $("#materia_acd_id").prop('disabled', true);
                    $("#materia_acd_id").prop('required', false);

                }else{
                    $("#materia_acd_id").empty();
                    $("#materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {
                        $("#materia_acd_id_label").html("Materia complementaria");
                        $("#materia_acd_id").prop('disabled', false);
                        $("#materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                        $("#materia_acd_id").prop('required', true);
                    });
                }                
            });
        });

        //POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var materia_id = $("#materia_id").val();

            
            $.get(base_url+`/bachiller_evidencias/getMateriasACD/${periodo_id}/${event.target.value}/${materia_id}`,function(res,sta){
                if(res.length < 1){
                    $("#materia_acd_id_label").html("Materia complementaria");
                    $("#materia_acd_id").empty();
                    $("#materia_acd_id").append(`<option value="NULL">SELECCIONE UNA OPCIÓN</option>`);
                    $("#materia_acd_id").prop('disabled', true);
                    $("#materia_acd_id").prop('required', false);
                }else{
                    $("#materia_acd_id").empty();
                    $("#materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {
                        $("#materia_acd_id_label").html("Materia complementaria");
                        $("#materia_acd_id").prop('disabled', false);
                        $("#materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                        $("#materia_acd_id").prop('required', true);
                    });
                }
            });
        });

        //POR MATERIA
        $("#materia_id").change( event => {
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            var MateriaSemestre = $("#MateriaSemestre").val();
            var contadorRestantes = $("#contadorRestantes").val();

            
            $.get(base_url+`/bachiller_evidencias/getMateriasACD/${periodo_id}/${plan_id}/${event.target.value}`,function(res,sta){
                if(res.length < 1){

                    //validando si la materia sin ACD tieene evidencias 
                    $.get(base_url+`/bachiller_evidencias/sinACDgetMateriasEvidenciasPeriodo/${periodo_id}/${event.target.value}/${MateriaSemestre}`,function(res,sta){
                        var datos = res.length;
                        var sumarPuntos = 0;
                        var sumarPuntosProceso = 0;
                        var sumarPuntosProducto = 0;
        
                        if(datos > 0){
                            res.forEach(function (element, i) {
        
        
                                sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                $("#contador").val(sumarPuntos);
        
                                if(element.eviTipo == "A"){
                                    sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                    $("#puntosProceso").val(sumarPuntosProceso);
        
                                }
        
                                if(element.eviTipo == "P"){
                                    sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                    $("#puntosProducto").val(sumarPuntosProducto);
        
                                }
        
                                if(sumarPuntos < 100){
                                    $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                    swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
        
        
                                }else{
                                    $("#contadorRestantes").val(0);
                                    swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                }
        
                            });
                        }else{
                            $("#contador").val(0);
                            $("#contadorRestantes").val(100);
                            $("#puntosProceso").val(0);
                            $("#puntosProducto").val(0);
        
                        }
        
                    });

                    $("#materia_acd_id_label").html("Materia complementaria");
                    $("#materia_acd_id").prop('disabled', true);
                    $("#materia_acd_id").empty();
                    $("#materia_acd_id").append(`<option value="NULL">SELECCIONE UNA OPCIÓN</option>`);
                    $("#materia_acd_id").prop('required', false);


                    
                }else{
                    $("#materia_acd_id").empty();
                    $("#materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {                        
                        $("#materia_acd_id_label").html("Materia complementaria *");
                        $("#materia_acd_id").prop('disabled', false);
                        $("#materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                        $("#materia_acd_id").prop('required', true);
                    });


                    $("#periodo_id").change( event => {
                        var materia_id = $("#materia_id").val();
                        var MateriaSemestre = $("#MateriaSemestre").val();
                        var materia_acd_id = $("#materia_acd_id").val();
                        var contadorRestantes = $("#contadorRestantes").val();
            
                        $.get(base_url+`/bachiller_evidencias/getMateriasEvidenciasPeriodoACD/${event.target.value}/${materia_id}/${MateriaSemestre}/${materia_acd_id}`,function(res,sta){
                            var datos = res.length;
                            var sumarPuntos = 0;
                            var sumarPuntosProceso = 0;
                            var sumarPuntosProducto = 0;
            
            
                            if(datos > 0){
                                res.forEach(function (element, i) {
            
                                    sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                    $("#contador").val(sumarPuntos);
            
                                    if(element.eviTipo == "A"){
                                        sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                        $("#puntosProceso").val(sumarPuntosProceso);
            
                                    }
            
                                    if(element.eviTipo == "P"){
                                        sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                        $("#puntosProducto").val(sumarPuntosProducto);
            
                                    }
            
                                    if(sumarPuntos < 100){
                                        $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                        swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
                                    }else{
                                        $("#contadorRestantes").val(0);
                                        swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                    }
            
                                });
                            }else{
                                $("#contador").val(0);
                                $("#contadorRestantes").val(100);
                                $("#puntosProceso").val(0);
                                $("#puntosProducto").val(0);
            
            
                            }
                        });
                    });
            
                    $("#materia_id").change( event => {
                        var periodo_id = $("#periodo_id").val();
                        var MateriaSemestre = $("#MateriaSemestre").val();
                        var materia_acd_id = $("#materia_acd_id").val();
            
                        var contadorRestantes = $("#contadorRestantes").val();
                        $.get(base_url+`/bachiller_evidencias/getMateriasEvidenciasPeriodoACD/${periodo_id}/${event.target.value}/${MateriaSemestre}/${materia_acd_id}`,function(res,sta){
                            var datos = res.length;
                            var sumarPuntos = 0;
                            var sumarPuntosProceso = 0;
                            var sumarPuntosProducto = 0;
            
                            if(datos > 0){
                                res.forEach(function (element, i) {
            
            
                                    sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                    $("#contador").val(sumarPuntos);
            
                                    if(element.eviTipo == "A"){
                                        sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                        $("#puntosProceso").val(sumarPuntosProceso);
            
                                    }
            
                                    if(element.eviTipo == "P"){
                                        sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                        $("#puntosProducto").val(sumarPuntosProducto);
            
                                    }
            
                                    if(sumarPuntos < 100){
                                        $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                        swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
            
            
                                    }else{
                                        $("#contadorRestantes").val(0);
                                        swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                    }
            
                                });
                            }else{
                                $("#contador").val(0);
                                $("#contadorRestantes").val(100);
                                $("#puntosProceso").val(0);
                                $("#puntosProducto").val(0);
            
                            }
            
                        });
                    });
            
                    //por grado
                    $("#MateriaSemestre").change( event => {
                        var periodo_id = $("#periodo_id").val();
                        var materia_id = $("#materia_id").val();
                        var materia_acd_id = $("#materia_acd_id").val();
            
                        var contadorRestantes = $("#contadorRestantes").val();
                        $.get(base_url+`/bachiller_evidencias/getMateriasEvidenciasPeriodoACD/${periodo_id}/${materia_id}/${event.target.value}/${materia_acd_id}`,function(res,sta){
                            var datos = res.length;
                            var sumarPuntos = 0;
                            var sumarPuntosProceso = 0;
                            var sumarPuntosProducto = 0;
            
            
            
                            if(datos > 0){
                                res.forEach(element => {
            
                                    sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                    $("#contador").val(sumarPuntos);
            
                                    if(element.eviTipo == "A"){
                                        sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                        $("#puntosProceso").val(sumarPuntosProceso);
            
                                    }
            
                                    if(element.eviTipo == "P"){
                                        sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                        $("#puntosProducto").val(sumarPuntosProducto);
            
                                    }
            
                                    if(sumarPuntos < 100){
                                        $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                        swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
            
                                    }else{
                                        $("#contadorRestantes").val(0);
                                        swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                    }
            
                                });
                            }else{
                                $("#contador").val(0);
                                $("#contadorRestantes").val(100);
                                $("#puntosProceso").val(0);
                                $("#puntosProducto").val(0);
            
                            }
            
                        });
                    });
            
                     //por materia complementaria
                    $("#materia_acd_id").change( event => {
                        var periodo_id = $("#periodo_id").val();
                        var MateriaSemestre = $("#MateriaSemestre").val();
                        var materia_id = $("#materia_id").val();
            
                        
                        var contadorRestantes = $("#contadorRestantes").val();
                        $.get(base_url+`/bachiller_evidencias/getMateriasEvidenciasPeriodoACD/${periodo_id}/${materia_id}/${MateriaSemestre}/${event.target.value}`,function(res,sta){
                            var datos = res.length;
                            var sumarPuntos = 0;
                            var sumarPuntosProceso = 0;
                            var sumarPuntosProducto = 0;
            
            
            
                            if(datos > 0){
                                res.forEach(element => {
            
                                    sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                    $("#contador").val(sumarPuntos);
            
                                    if(element.eviTipo == "A"){
                                        sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                        $("#puntosProceso").val(sumarPuntosProceso);
            
                                    }
            
                                    if(element.eviTipo == "P"){
                                        sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                        $("#puntosProducto").val(sumarPuntosProducto);
            
                                    }
            
                                    if(sumarPuntos < 100){
                                        $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                        swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
            
                                    }else{
                                        $("#contadorRestantes").val(0);
                                        swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                    }
            
                                });
                            }else{
                                $("#contador").val(0);
                                $("#contadorRestantes").val(100);
                                $("#puntosProceso").val(0);
                                $("#puntosProducto").val(0);
            
                            }
            
                        });
                    });
                }
            });
        });
       

        //POR SEMESTRE
        $("#MateriaSemestre").change( event => {
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            var materia_id = $("#materia_id").val();
            var contadorRestantes = $("#contadorRestantes").val();

            
            $.get(base_url+`/bachiller_evidencias/getMateriasACD/${periodo_id}/${plan_id}/${event.target.value}`,function(res,sta){
                if(res.length < 1){

                    //validando si la materia sin ACD tieene evidencias 
                    //por SEMESTRE
                    $.get(base_url+`/bachiller_evidencias/sinACDgetMateriasEvidenciasPeriodo/${periodo_id}/${materia_id}/${event.target.value}`,function(res,sta){
                        var datos = res.length;
                        var sumarPuntos = 0;
                        var sumarPuntosProceso = 0;
                        var sumarPuntosProducto = 0;
        
        
        
                        if(datos > 0){
                            res.forEach(element => {
        
                                sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                $("#contador").val(sumarPuntos);
        
                                if(element.eviTipo == "A"){
                                    sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                    $("#puntosProceso").val(sumarPuntosProceso);
        
                                }
        
                                if(element.eviTipo == "P"){
                                    sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                    $("#puntosProducto").val(sumarPuntosProducto);
        
                                }
        
                                if(sumarPuntos < 100){
                                    $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                    swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
        
                                }else{
                                    $("#contadorRestantes").val(0);
                                    swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                }
        
                            });
                        }else{
                            $("#contador").val(0);
                            $("#contadorRestantes").val(100);
                            $("#puntosProceso").val(0);
                            $("#puntosProducto").val(0);
        
                        }
        
                    });
                   

                    $("#materia_acd_id_label").html("Materia complementaria");
                    $("#materia_acd_id").prop('disabled', true);
                    $("#materia_acd_id").empty();
                    $("#materia_acd_id").append(`<option value="NULL">SELECCIONE UNA OPCIÓN</option>`);
                    $("#materia_acd_id").prop('required', false);


                    
                }else{
                    $("#materia_acd_id").empty();
                    $("#materia_acd_id").append(`<option value="" selected disabled >SELECCIONE UNA OPCIÓN</option>`);

                    res.forEach(element => {                        
                        $("#materia_acd_id_label").html("Materia complementaria *");
                        $("#materia_acd_id").prop('disabled', false);
                        $("#materia_acd_id").append(`<option value=${element.id}>${element.gpoMatComplementaria}</option>`);
                        $("#materia_acd_id").prop('required', true);
                    });


                    $("#periodo_id").change( event => {
                        var materia_id = $("#materia_id").val();
                        var MateriaSemestre = $("#MateriaSemestre").val();
                        var materia_acd_id = $("#materia_acd_id").val();
                        var contadorRestantes = $("#contadorRestantes").val();
            
                        $.get(base_url+`/bachiller_evidencias/getMateriasEvidenciasPeriodoACD/${event.target.value}/${materia_id}/${MateriaSemestre}/${materia_acd_id}`,function(res,sta){
                            var datos = res.length;
                            var sumarPuntos = 0;
                            var sumarPuntosProceso = 0;
                            var sumarPuntosProducto = 0;
            
            
                            if(datos > 0){
                                res.forEach(function (element, i) {
            
                                    sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                    $("#contador").val(sumarPuntos);
            
                                    if(element.eviTipo == "A"){
                                        sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                        $("#puntosProceso").val(sumarPuntosProceso);
            
                                    }
            
                                    if(element.eviTipo == "P"){
                                        sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                        $("#puntosProducto").val(sumarPuntosProducto);
            
                                    }
            
                                    if(sumarPuntos < 100){
                                        $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                        swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
                                    }else{
                                        $("#contadorRestantes").val(0);
                                        swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                    }
            
                                });
                            }else{
                                $("#contador").val(0);
                                $("#contadorRestantes").val(100);
                                $("#puntosProceso").val(0);
                                $("#puntosProducto").val(0);
            
            
                            }
                        });
                    });
            
                    $("#materia_id").change( event => {
                        var periodo_id = $("#periodo_id").val();
                        var MateriaSemestre = $("#MateriaSemestre").val();
                        var materia_acd_id = $("#materia_acd_id").val();
            
                        var contadorRestantes = $("#contadorRestantes").val();
                        $.get(base_url+`/bachiller_evidencias/getMateriasEvidenciasPeriodoACD/${periodo_id}/${event.target.value}/${MateriaSemestre}/${materia_acd_id}`,function(res,sta){
                            var datos = res.length;
                            var sumarPuntos = 0;
                            var sumarPuntosProceso = 0;
                            var sumarPuntosProducto = 0;
            
                            if(datos > 0){
                                res.forEach(function (element, i) {
            
            
                                    sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                    $("#contador").val(sumarPuntos);
            
                                    if(element.eviTipo == "A"){
                                        sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                        $("#puntosProceso").val(sumarPuntosProceso);
            
                                    }
            
                                    if(element.eviTipo == "P"){
                                        sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                        $("#puntosProducto").val(sumarPuntosProducto);
            
                                    }
            
                                    if(sumarPuntos < 100){
                                        $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                        swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
            
            
                                    }else{
                                        $("#contadorRestantes").val(0);
                                        swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                    }
            
                                });
                            }else{
                                $("#contador").val(0);
                                $("#contadorRestantes").val(100);
                                $("#puntosProceso").val(0);
                                $("#puntosProducto").val(0);
            
                            }
            
                        });
                    });
            
                    //por grado
                    $("#MateriaSemestre").change( event => {
                        var periodo_id = $("#periodo_id").val();
                        var materia_id = $("#materia_id").val();
                        var materia_acd_id = $("#materia_acd_id").val();
            
                        var contadorRestantes = $("#contadorRestantes").val();
                        $.get(base_url+`/bachiller_evidencias/getMateriasEvidenciasPeriodoACD/${periodo_id}/${materia_id}/${event.target.value}/${materia_acd_id}`,function(res,sta){
                            var datos = res.length;
                            var sumarPuntos = 0;
                            var sumarPuntosProceso = 0;
                            var sumarPuntosProducto = 0;
            
            
            
                            if(datos > 0){
                                res.forEach(element => {
            
                                    sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                    $("#contador").val(sumarPuntos);
            
                                    if(element.eviTipo == "A"){
                                        sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                        $("#puntosProceso").val(sumarPuntosProceso);
            
                                    }
            
                                    if(element.eviTipo == "P"){
                                        sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                        $("#puntosProducto").val(sumarPuntosProducto);
            
                                    }
            
                                    if(sumarPuntos < 100){
                                        $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                        swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
            
                                    }else{
                                        $("#contadorRestantes").val(0);
                                        swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                    }
            
                                });
                            }else{
                                $("#contador").val(0);
                                $("#contadorRestantes").val(100);
                                $("#puntosProceso").val(0);
                                $("#puntosProducto").val(0);
            
                            }
            
                        });
                    });
            
                     //por materia complementaria
                    $("#materia_acd_id").change( event => {
                        var periodo_id = $("#periodo_id").val();
                        var MateriaSemestre = $("#MateriaSemestre").val();
                        var materia_id = $("#materia_id").val();
            
                        
                        var contadorRestantes = $("#contadorRestantes").val();
                        $.get(base_url+`/bachiller_evidencias/getMateriasEvidenciasPeriodoACD/${periodo_id}/${materia_id}/${MateriaSemestre}/${event.target.value}`,function(res,sta){
                            var datos = res.length;
                            var sumarPuntos = 0;
                            var sumarPuntosProceso = 0;
                            var sumarPuntosProducto = 0;
            
            
            
                            if(datos > 0){
                                res.forEach(element => {
            
                                    sumarPuntos = parseInt(sumarPuntos) + parseInt(element.eviPuntos);
                                    $("#contador").val(sumarPuntos);
            
                                    if(element.eviTipo == "A"){
                                        sumarPuntosProceso = parseInt(sumarPuntosProceso) + parseInt(element.eviPuntos);
                                        $("#puntosProceso").val(sumarPuntosProceso);
            
                                    }
            
                                    if(element.eviTipo == "P"){
                                        sumarPuntosProducto = parseInt(sumarPuntosProducto) + parseInt(element.eviPuntos);
                                        $("#puntosProducto").val(sumarPuntosProducto);
            
                                    }
            
                                    if(sumarPuntos < 100){
                                        $("#contadorRestantes").val(parseInt(contadorRestantes) - sumarPuntos);
                                        swal("Evidencias actuales "+datos+" ", "El período y la materia seleccionada ya tiene evidencias agregadas, se mostrara los puntos evidencias actuales y los puntos restantes por agregar, así como los puntos totales de evidencias tipo Proceso y tipo Producto", "info");
            
                                    }else{
                                        $("#contadorRestantes").val(0);
                                        swal("", "El período y la materia seleccionada ya ha alcanzado el limite de puntaje de evidencia", "info");
                                    }
            
                                });
                            }else{
                                $("#contador").val(0);
                                $("#contadorRestantes").val(100);
                                $("#puntosProceso").val(0);
                                $("#puntosProducto").val(0);
            
                            }
            
                        });
                    });
                }
            });
        });
     });
</script>