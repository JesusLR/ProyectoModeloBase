<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER CGTS POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var extTipo = $("#extTipo").val();
            $("#bachiller_fecha_regularizacion_id").empty();
            $("#bachiller_fecha_regularizacion_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_calificacion/getFechasRegularizacion/${periodo_id}/${event.target.value}/${extTipo}`,function(res,sta){
                var fechaSeleccionadoOld = $("#bachiller_fecha_regularizacion_id").data("bachiller_fecha_regularizacion-id");

                if(res.extTipo != "null"){
                    if(res.extTipo == "RECURSAMIENTO"){
                        res.bachiller_fechas_regularizacion.forEach(element => {
                            var selected = "";
                            if (element.id === fechaSeleccionadoOld) {
                                selected = "selected";
                            }

                            var posicion = "";
                            var meses = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
                            var fi=element.frFechaInicioCursos;
                            var FI = fi.split("-");
                            var mesI = FI[1];
                            if(mesI == "01"){
                                posicion = 0;
                            }
                            if(mesI == "02"){
                                posicion = 1;
                            }
                            if(mesI == "03"){
                                posicion = 2;
                            }
                            if(mesI == "04"){
                                posicion = 3;
                            }
                            if(mesI == "05"){
                                posicion = 4;
                            }
                            if(mesI == "06"){
                                posicion = 5;
                            }
                            if(mesI == "07"){
                                posicion = 6;
                            }
                            if(mesI == "08"){
                                posicion = 7;
                            }
                            if(mesI == "09"){
                                posicion = 8;
                            }
                            if(mesI == "10"){
                                posicion = 9;
                            }
                            if(mesI == "11"){
                                posicion = 10;
                            }
                            if(mesI == "12"){
                                posicion = 11;
                            }
                            var inicioCurso = FI[2] + '-' + meses[posicion] + '-' + FI[0];

                            var posicion2 = "";
                            var ff=element.frFechaFinCursos;
                            var FF = ff.split("-");
                            var mesF = FF[1];
                            if(mesF == "01"){
                                posicion2 = 0;
                            }
                            if(mesF == "02"){
                                posicion2 = 1;
                            }
                            if(mesF == "03"){
                                posicion2 = 2;
                            }
                            if(mesF == "04"){
                                posicion2 = 3;
                            }
                            if(mesF == "05"){
                                posicion2 = 4;
                            }
                            if(mesF == "06"){
                                posicion2 = 5;
                            }
                            if(mesF == "07"){
                                posicion2 = 6;
                            }
                            if(mesF == "08"){
                                posicion2 = 7;
                            }
                            if(mesF == "09"){
                                posicion2 = 8;
                            }
                            if(mesF == "10"){
                                posicion2 = 9;
                            }
                            if(mesF == "11"){
                                posicion2 = 10;
                            }
                            if(mesF == "12"){
                                posicion2 = 11;
                            }
                            var finCurso = FF[2] + '-' + meses[posicion2] + '-' + FF[0];

                            $("#bachiller_fecha_regularizacion_id").append(`<option value=${element.id} ${selected}>Importe: ${element.frImporteRecursamiento}, Fecha inicio: ${inicioCurso}, Fecha fin: ${finCurso}</option>`);
                        });
                    }else{
                        res.bachiller_fechas_regularizacion.forEach(element => {
                            var selected = "";
                            if (element.id === fechaSeleccionadoOld) {
                                selected = "selected";
                            }

                            var posicion = "";
                            var meses = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
                            var fi=element.frFechaInicioCursos;
                            var FI = fi.split("-");
                            var mesI = FI[1];
                            if(mesI == "01"){
                                posicion = 0;
                            }
                            if(mesI == "02"){
                                posicion = 1;
                            }
                            if(mesI == "03"){
                                posicion = 2;
                            }
                            if(mesI == "04"){
                                posicion = 3;
                            }
                            if(mesI == "05"){
                                posicion = 4;
                            }
                            if(mesI == "06"){
                                posicion = 5;
                            }
                            if(mesI == "07"){
                                posicion = 6;
                            }
                            if(mesI == "08"){
                                posicion = 7;
                            }
                            if(mesI == "09"){
                                posicion = 8;
                            }
                            if(mesI == "10"){
                                posicion = 9;
                            }
                            if(mesI == "11"){
                                posicion = 10;
                            }
                            if(mesI == "12"){
                                posicion = 11;
                            }
                            var inicioCurso = FI[2] + '-' + meses[posicion] + '-' + FI[0];

                            var posicion2 = "";
                            var ff=element.frFechaFinCursos;
                            var FF = ff.split("-");
                            var mesF = FF[1];
                            if(mesF == "01"){
                                posicion2 = 0;
                            }
                            if(mesF == "02"){
                                posicion2 = 1;
                            }
                            if(mesF == "03"){
                                posicion2 = 2;
                            }
                            if(mesF == "04"){
                                posicion2 = 3;
                            }
                            if(mesF == "05"){
                                posicion2 = 4;
                            }
                            if(mesF == "06"){
                                posicion2 = 5;
                            }
                            if(mesF == "07"){
                                posicion2 = 6;
                            }
                            if(mesF == "08"){
                                posicion2 = 7;
                            }
                            if(mesF == "09"){
                                posicion2 = 8;
                            }
                            if(mesF == "10"){
                                posicion2 = 9;
                            }
                            if(mesF == "11"){
                                posicion2 = 10;
                            }
                            if(mesF == "12"){
                                posicion2 = 11;
                            }
                            var finCurso = FF[2] + '-' + meses[posicion2] + '-' + FF[0];
                            $("#bachiller_fecha_regularizacion_id").append(`<option value=${element.id} ${selected}>Importe: ${element.frImporteAcomp}, Fecha inicio: ${inicioCurso}, Fecha fin: ${finCurso}</option>`);
                        });
                    }
                }else{
                    $("#bachiller_fecha_regularizacion_id").empty();
                    $("#bachiller_fecha_regularizacion_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                }
            });
        });

        // OBTENER CGTS POR PERIODO
        $("#periodo_id").change( event => {
            var plan_id = $("#plan_id").val();
            var extTipo = $("#extTipo").val();
            $("#bachiller_fecha_regularizacion_id").empty();
            $("#bachiller_fecha_regularizacion_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_calificacion/getFechasRegularizacion/${event.target.value}/${plan_id}/${extTipo}`,function(res,sta){
                var fechaSeleccionadoOld = $("#bachiller_fecha_regularizacion_id").data("bachiller_fecha_regularizacion-id");

                if(res.extTipo != "null"){
                    if(res.extTipo == "RECURSAMIENTO"){
                        res.bachiller_fechas_regularizacion.forEach(element => {
                            var selected = "";
                            if (element.id === fechaSeleccionadoOld) {
                                selected = "selected";
                            }

                            var posicion = "";
                            var meses = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
                            var fi=element.frFechaInicioCursos;
                            var FI = fi.split("-");
                            var mesI = FI[1];
                            if(mesI == "01"){
                                posicion = 0;
                            }
                            if(mesI == "02"){
                                posicion = 1;
                            }
                            if(mesI == "03"){
                                posicion = 2;
                            }
                            if(mesI == "04"){
                                posicion = 3;
                            }
                            if(mesI == "05"){
                                posicion = 4;
                            }
                            if(mesI == "06"){
                                posicion = 5;
                            }
                            if(mesI == "07"){
                                posicion = 6;
                            }
                            if(mesI == "08"){
                                posicion = 7;
                            }
                            if(mesI == "09"){
                                posicion = 8;
                            }
                            if(mesI == "10"){
                                posicion = 9;
                            }
                            if(mesI == "11"){
                                posicion = 10;
                            }
                            if(mesI == "12"){
                                posicion = 11;
                            }
                            var inicioCurso = FI[2] + '-' + meses[posicion] + '-' + FI[0];

                            var posicion2 = "";
                            var ff=element.frFechaFinCursos;
                            var FF = ff.split("-");
                            var mesF = FF[1];
                            if(mesF == "01"){
                                posicion2 = 0;
                            }
                            if(mesF == "02"){
                                posicion2 = 1;
                            }
                            if(mesF == "03"){
                                posicion2 = 2;
                            }
                            if(mesF == "04"){
                                posicion2 = 3;
                            }
                            if(mesF == "05"){
                                posicion2 = 4;
                            }
                            if(mesF == "06"){
                                posicion2 = 5;
                            }
                            if(mesF == "07"){
                                posicion2 = 6;
                            }
                            if(mesF == "08"){
                                posicion2 = 7;
                            }
                            if(mesF == "09"){
                                posicion2 = 8;
                            }
                            if(mesF == "10"){
                                posicion2 = 9;
                            }
                            if(mesF == "11"){
                                posicion2 = 10;
                            }
                            if(mesF == "12"){
                                posicion2 = 11;
                            }
                            var finCurso = FF[2] + '-' + meses[posicion2] + '-' + FF[0];

                            $("#bachiller_fecha_regularizacion_id").append(`<option value=${element.id} ${selected}>Importe: ${element.frImporteRecursamiento}, Fecha inicio: ${inicioCurso}, Fecha fin: ${finCurso}</option>`);
                        });
                    }else{
                        res.bachiller_fechas_regularizacion.forEach(element => {
                            var selected = "";
                            if (element.id === fechaSeleccionadoOld) {
                                selected = "selected";
                            }

                            var posicion = "";
                            var meses = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
                            var fi=element.frFechaInicioCursos;
                            var FI = fi.split("-");
                            var mesI = FI[1];
                            if(mesI == "01"){
                                posicion = 0;
                            }
                            if(mesI == "02"){
                                posicion = 1;
                            }
                            if(mesI == "03"){
                                posicion = 2;
                            }
                            if(mesI == "04"){
                                posicion = 3;
                            }
                            if(mesI == "05"){
                                posicion = 4;
                            }
                            if(mesI == "06"){
                                posicion = 5;
                            }
                            if(mesI == "07"){
                                posicion = 6;
                            }
                            if(mesI == "08"){
                                posicion = 7;
                            }
                            if(mesI == "09"){
                                posicion = 8;
                            }
                            if(mesI == "10"){
                                posicion = 9;
                            }
                            if(mesI == "11"){
                                posicion = 10;
                            }
                            if(mesI == "12"){
                                posicion = 11;
                            }
                            var inicioCurso = FI[2] + '-' + meses[posicion] + '-' + FI[0];

                            var posicion2 = "";
                            var ff=element.frFechaFinCursos;
                            var FF = ff.split("-");
                            var mesF = FF[1];
                            if(mesF == "01"){
                                posicion2 = 0;
                            }
                            if(mesF == "02"){
                                posicion2 = 1;
                            }
                            if(mesF == "03"){
                                posicion2 = 2;
                            }
                            if(mesF == "04"){
                                posicion2 = 3;
                            }
                            if(mesF == "05"){
                                posicion2 = 4;
                            }
                            if(mesF == "06"){
                                posicion2 = 5;
                            }
                            if(mesF == "07"){
                                posicion2 = 6;
                            }
                            if(mesF == "08"){
                                posicion2 = 7;
                            }
                            if(mesF == "09"){
                                posicion2 = 8;
                            }
                            if(mesF == "10"){
                                posicion2 = 9;
                            }
                            if(mesF == "11"){
                                posicion2 = 10;
                            }
                            if(mesF == "12"){
                                posicion2 = 11;
                            }
                            var finCurso = FF[2] + '-' + meses[posicion2] + '-' + FF[0];
                            $("#bachiller_fecha_regularizacion_id").append(`<option value=${element.id} ${selected}>Importe: ${element.frImporteAcomp}, Fecha inicio: ${inicioCurso}, Fecha fin: ${finCurso}</option>`);
                        });
                    }
                }else{
                    $("#bachiller_fecha_regularizacion_id").empty();
                    $("#bachiller_fecha_regularizacion_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                }
            });
        });

        $("#extTipo").change( event => {
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            $("#bachiller_fecha_regularizacion_id").empty();
            $("#bachiller_fecha_regularizacion_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_calificacion/getFechasRegularizacion/${periodo_id}/${plan_id}/${event.target.value}`,function(res,sta){

                var fechaSeleccionadoOld = $("#bachiller_fecha_regularizacion_id").data("bachiller_fecha_regularizacion-id");

                if(res.extTipo != "null"){
                    if(res.extTipo == "RECURSAMIENTO"){
                        res.bachiller_fechas_regularizacion.forEach(element => {
                            var selected = "";
                            if (element.id === fechaSeleccionadoOld) {
                                selected = "selected";
                            }

                            var posicion = "";
                            var meses = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
                            var fi=element.frFechaInicioCursos;
                            var FI = fi.split("-");
                            var mesI = FI[1];
                            if(mesI == "01"){
                                posicion = 0;
                            }
                            if(mesI == "02"){
                                posicion = 1;
                            }
                            if(mesI == "03"){
                                posicion = 2;
                            }
                            if(mesI == "04"){
                                posicion = 3;
                            }
                            if(mesI == "05"){
                                posicion = 4;
                            }
                            if(mesI == "06"){
                                posicion = 5;
                            }
                            if(mesI == "07"){
                                posicion = 6;
                            }
                            if(mesI == "08"){
                                posicion = 7;
                            }
                            if(mesI == "09"){
                                posicion = 8;
                            }
                            if(mesI == "10"){
                                posicion = 9;
                            }
                            if(mesI == "11"){
                                posicion = 10;
                            }
                            if(mesI == "12"){
                                posicion = 11;
                            }
                            var inicioCurso = FI[2] + '-' + meses[posicion] + '-' + FI[0];

                            var posicion2 = "";
                            var ff=element.frFechaFinCursos;
                            var FF = ff.split("-");
                            var mesF = FF[1];
                            if(mesF == "01"){
                                posicion2 = 0;
                            }
                            if(mesF == "02"){
                                posicion2 = 1;
                            }
                            if(mesF == "03"){
                                posicion2 = 2;
                            }
                            if(mesF == "04"){
                                posicion2 = 3;
                            }
                            if(mesF == "05"){
                                posicion2 = 4;
                            }
                            if(mesF == "06"){
                                posicion2 = 5;
                            }
                            if(mesF == "07"){
                                posicion2 = 6;
                            }
                            if(mesF == "08"){
                                posicion2 = 7;
                            }
                            if(mesF == "09"){
                                posicion2 = 8;
                            }
                            if(mesF == "10"){
                                posicion2 = 9;
                            }
                            if(mesF == "11"){
                                posicion2 = 10;
                            }
                            if(mesF == "12"){
                                posicion2 = 11;
                            }
                            var finCurso = FF[2] + '-' + meses[posicion2] + '-' + FF[0];

                            $("#bachiller_fecha_regularizacion_id").append(`<option value=${element.id} ${selected}>Importe: ${element.frImporteRecursamiento}, Fecha inicio: ${inicioCurso}, Fecha fin: ${finCurso}</option>`);
                            var texto = $('select[name="bachiller_fecha_regularizacion_id"] option:selected').text();
                            var text2 = texto.split(" ");
                            var volverDividir = text2[1];
                            var volverDividir2 = text2[1].split(",");
                            $("#class-input-field").removeClass("class-input");
                            $("#extPago").val(volverDividir2[0]);
                        });
                    }else{
                        res.bachiller_fechas_regularizacion.forEach(element => {
                            var selected = "";
                            if (element.id === fechaSeleccionadoOld) {
                                selected = "selected";
                            }

                            var posicion = "";
                            var meses = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
                            var fi=element.frFechaInicioCursos;
                            var FI = fi.split("-");
                            var mesI = FI[1];
                            if(mesI == "01"){
                                posicion = 0;
                            }
                            if(mesI == "02"){
                                posicion = 1;
                            }
                            if(mesI == "03"){
                                posicion = 2;
                            }
                            if(mesI == "04"){
                                posicion = 3;
                            }
                            if(mesI == "05"){
                                posicion = 4;
                            }
                            if(mesI == "06"){
                                posicion = 5;
                            }
                            if(mesI == "07"){
                                posicion = 6;
                            }
                            if(mesI == "08"){
                                posicion = 7;
                            }
                            if(mesI == "09"){
                                posicion = 8;
                            }
                            if(mesI == "10"){
                                posicion = 9;
                            }
                            if(mesI == "11"){
                                posicion = 10;
                            }
                            if(mesI == "12"){
                                posicion = 11;
                            }
                            var inicioCurso = FI[2] + '-' + meses[posicion] + '-' + FI[0];

                            var posicion2 = "";
                            var ff=element.frFechaFinCursos;
                            var FF = ff.split("-");
                            var mesF = FF[1];
                            if(mesF == "01"){
                                posicion2 = 0;
                            }
                            if(mesF == "02"){
                                posicion2 = 1;
                            }
                            if(mesF == "03"){
                                posicion2 = 2;
                            }
                            if(mesF == "04"){
                                posicion2 = 3;
                            }
                            if(mesF == "05"){
                                posicion2 = 4;
                            }
                            if(mesF == "06"){
                                posicion2 = 5;
                            }
                            if(mesF == "07"){
                                posicion2 = 6;
                            }
                            if(mesF == "08"){
                                posicion2 = 7;
                            }
                            if(mesF == "09"){
                                posicion2 = 8;
                            }
                            if(mesF == "10"){
                                posicion2 = 9;
                            }
                            if(mesF == "11"){
                                posicion2 = 10;
                            }
                            if(mesF == "12"){
                                posicion2 = 11;
                            }
                            var finCurso = FF[2] + '-' + meses[posicion2] + '-' + FF[0];

                            
                            $("#bachiller_fecha_regularizacion_id").append(`<option value=${element.id} ${selected}>Importe: ${element.frImporteAcomp}, Fecha inicio: ${inicioCurso}, Fecha fin: ${finCurso}</option>`);

                            var texto = $('select[name="bachiller_fecha_regularizacion_id"] option:selected').text();
                            var text2 = texto.split(" ");
                            var volverDividir = text2[1];
                            var volverDividir2 = text2[1].split(",");
                            $("#class-input-field").removeClass("class-input");
                            $("#extPago").val(volverDividir2[0]);
                        });
                    }
                }else{
                    $("#bachiller_fecha_regularizacion_id").empty();
                    $("#bachiller_fecha_regularizacion_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                }
                
                
            });
        });


            var extTipo = $("#extTipo").val();
            var plan_id = $("#plan_id").val();
            var periodo_id = $("#periodo_id").val();
            $("#bachiller_fecha_regularizacion_id").empty();
            $("#bachiller_fecha_regularizacion_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/bachiller_calificacion/getFechasRegularizacion/${periodo_id}/${plan_id}/${extTipo}`,function(res,sta){

                var fechaSeleccionadoOld = $("#bachiller_fecha_regularizacion_id").data("bachiller_fecha_regularizacion-id");

                if(res.extTipo != "null"){
                    if(res.extTipo == "RECURSAMIENTO"){
                        res.bachiller_fechas_regularizacion.forEach(element => {
                            var selected = "";
                            if (element.id === fechaSeleccionadoOld) {
                                selected = "selected";
                            }

                            var posicion = "";
                            var meses = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
                            var fi=element.frFechaInicioCursos;
                            var FI = fi.split("-");
                            var mesI = FI[1];
                            if(mesI == "01"){
                                posicion = 0;
                            }
                            if(mesI == "02"){
                                posicion = 1;
                            }
                            if(mesI == "03"){
                                posicion = 2;
                            }
                            if(mesI == "04"){
                                posicion = 3;
                            }
                            if(mesI == "05"){
                                posicion = 4;
                            }
                            if(mesI == "06"){
                                posicion = 5;
                            }
                            if(mesI == "07"){
                                posicion = 6;
                            }
                            if(mesI == "08"){
                                posicion = 7;
                            }
                            if(mesI == "09"){
                                posicion = 8;
                            }
                            if(mesI == "10"){
                                posicion = 9;
                            }
                            if(mesI == "11"){
                                posicion = 10;
                            }
                            if(mesI == "12"){
                                posicion = 11;
                            }
                            var inicioCurso = FI[2] + '-' + meses[posicion] + '-' + FI[0];

                            var posicion2 = "";
                            var ff=element.frFechaFinCursos;
                            var FF = ff.split("-");
                            var mesF = FF[1];
                            if(mesF == "01"){
                                posicion2 = 0;
                            }
                            if(mesF == "02"){
                                posicion2 = 1;
                            }
                            if(mesF == "03"){
                                posicion2 = 2;
                            }
                            if(mesF == "04"){
                                posicion2 = 3;
                            }
                            if(mesF == "05"){
                                posicion2 = 4;
                            }
                            if(mesF == "06"){
                                posicion2 = 5;
                            }
                            if(mesF == "07"){
                                posicion2 = 6;
                            }
                            if(mesF == "08"){
                                posicion2 = 7;
                            }
                            if(mesF == "09"){
                                posicion2 = 8;
                            }
                            if(mesF == "10"){
                                posicion2 = 9;
                            }
                            if(mesF == "11"){
                                posicion2 = 10;
                            }
                            if(mesF == "12"){
                                posicion2 = 11;
                            }
                            var finCurso = FF[2] + '-' + meses[posicion2] + '-' + FF[0];

                            $("#bachiller_fecha_regularizacion_id").append(`<option value=${element.id} ${selected}>Importe: ${element.frImporteRecursamiento}, Fecha inicio: ${inicioCurso}, Fecha fin: ${finCurso}</option>`);
                        });
                    }else{
                        res.bachiller_fechas_regularizacion.forEach(element => {
                            var selected = "";
                            if (element.id === fechaSeleccionadoOld) {
                                selected = "selected";
                            }

                            var posicion = "";
                            var meses = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
                            var fi=element.frFechaInicioCursos;
                            var FI = fi.split("-");
                            var mesI = FI[1];
                            if(mesI == "01"){
                                posicion = 0;
                            }
                            if(mesI == "02"){
                                posicion = 1;
                            }
                            if(mesI == "03"){
                                posicion = 2;
                            }
                            if(mesI == "04"){
                                posicion = 3;
                            }
                            if(mesI == "05"){
                                posicion = 4;
                            }
                            if(mesI == "06"){
                                posicion = 5;
                            }
                            if(mesI == "07"){
                                posicion = 6;
                            }
                            if(mesI == "08"){
                                posicion = 7;
                            }
                            if(mesI == "09"){
                                posicion = 8;
                            }
                            if(mesI == "10"){
                                posicion = 9;
                            }
                            if(mesI == "11"){
                                posicion = 10;
                            }
                            if(mesI == "12"){
                                posicion = 11;
                            }
                            var inicioCurso = FI[2] + '-' + meses[posicion] + '-' + FI[0];

                            var posicion2 = "";
                            var ff=element.frFechaFinCursos;
                            var FF = ff.split("-");
                            var mesF = FF[1];
                            if(mesF == "01"){
                                posicion2 = 0;
                            }
                            if(mesF == "02"){
                                posicion2 = 1;
                            }
                            if(mesF == "03"){
                                posicion2 = 2;
                            }
                            if(mesF == "04"){
                                posicion2 = 3;
                            }
                            if(mesF == "05"){
                                posicion2 = 4;
                            }
                            if(mesF == "06"){
                                posicion2 = 5;
                            }
                            if(mesF == "07"){
                                posicion2 = 6;
                            }
                            if(mesF == "08"){
                                posicion2 = 7;
                            }
                            if(mesF == "09"){
                                posicion2 = 8;
                            }
                            if(mesF == "10"){
                                posicion2 = 9;
                            }
                            if(mesF == "11"){
                                posicion2 = 10;
                            }
                            if(mesF == "12"){
                                posicion2 = 11;
                            }
                            var finCurso = FF[2] + '-' + meses[posicion2] + '-' + FF[0];
                            $("#bachiller_fecha_regularizacion_id").append(`<option value=${element.id} ${selected}>Importe: ${element.frImporteAcomp}, Fecha inicio: ${inicioCurso}, Fecha fin: ${finCurso}</option>`);
                        });
                    }
                }else{
                    $("#bachiller_fecha_regularizacion_id").empty();
                    $("#bachiller_fecha_regularizacion_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
                }
                
            });

            $("#bachiller_fecha_regularizacion_id").change(function(){

                var texto = $('select[name="bachiller_fecha_regularizacion_id"] option:selected').text();
                var text2 = texto.split(" ");
                var volverDividir = text2[1];
                var volverDividir2 = text2[1].split(",");
                $("#class-input-field").removeClass("class-input");
                $("#extPago").val(volverDividir2[0]);
                
                
            });

            

     });
</script>