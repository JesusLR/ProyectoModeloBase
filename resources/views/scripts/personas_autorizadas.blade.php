<script>
    $(document).on('click', '.confirm-autorizado', function (e) {
        e.preventDefault();
        var curso_id = $(this).data('curso_id');
        var movimiento = $(this).data('movimiento');
        var persona1 = $(this).data('persona1');
        var persona2 = $(this).data('persona2');
        var departamento = $(this).data('departamento');
        var ip_emitente = $(this).data('ip');
        var usuario_at = $(this).data('usuario_at');
        var alumno_id = $(this).data('alumno_id');

        var fechaHoy = new Date();
        var dia = fechaHoy.getDate();
        var mes = fechaHoy.getMonth() + 1;
        var anio = fechaHoy.getFullYear();        

        if(mes < 10){
            mes = '0'+mes;
        }
        if(dia < 10){
            dia = '0'+dia;
        }      

        var hora = fechaHoy.getHours();
        var min = fechaHoy.getMinutes();
        var seg = fechaHoy.getSeconds();
        if(hora < 10){
            hora = '0'+hora;
        }
        if(min < 10){
            min = '0'+min;
        }
        if(seg < 10){
            seg = '0'+seg;
        }

        var hora = hora + ':' + min + ':' + seg;

        var fecha_hora_movimiento = `${anio}-${mes}-${dia} ${hora}`;

        var html = "";
        html += `<p>Estas son las personas autorizadas para tener acceso a la información del alumno</p>`;
        html += `<p>Persona 1: <b style="color: #000">${persona1}</b></p>`;
        if(persona2 != ""){
            html += `<p>Persona 2: <b style="color: #000">${persona2}</b></p>`;
        }
        
        swal({
                html:true,
                title: "¿Desea continuar?",
                text: html,
                type: "warning",
                confirmButtonText: "Si",
                confirmButtonColor: '#3085d6',
                cancelButtonText: "No",
                showCancelButton: true
            },
            function(isConfirm) {
                if(isConfirm) {
                    
                    $.ajax({
                        url: "{{route('guardarResponsables')}}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            "_token": $("meta[name=csrf-token]").attr("content"),
                            curso_id: curso_id,
                            alumno_id: alumno_id,
                            ip_emitente: ip_emitente,
                            tipo_accion: movimiento,
                            fecha_hora_movimiento: fecha_hora_movimiento,
                            usuario_at: usuario_at

                        },                        
                        success: function(data){

                            if(departamento == "MAT" || departamento == "PRE"){

                                if(movimiento == "PREESCOLAR EDITAR PREINSCRITO"){
                                    location.href = `/preescolar_curso/${curso_id}/edit`;
                                }

                                if(movimiento == "PREESCOLAR VER PREINSCRITO"){
                                    location.href = `/preescolar_curso/${curso_id}`;
                                }

                                if(movimiento == "PREESCOLAR TARJETA PAGO BBVA PREINSCRITO"){
                                    //window.open(`tarjetaPagoAlumno/${curso_id}/BBVA`, '_blank');
                                    setTimeout(() => window.open(`tarjetaPagoAlumno/${curso_id}/BBVA`, '_blank'), 1000);
                                }

                                if(movimiento == "PREESCOLAR TARJETA PAGO HSBC PREINSCRITO"){
                                    //window.open(`tarjetaPagoAlumno/${curso_id}/HSBC`, '_blank');
                                    setTimeout(() => window.open(`tarjetaPagoAlumno/${curso_id}/HSBC`, '_blank'), 1000);
                                }

                                if(movimiento == "PREESCOLAR OBSERVACIONES"){
                                    location.href = `/preescolar_curso/observaciones/${curso_id}`;
                                }

                                if(movimiento == "PREESCOLAR VER ALUMNO DETALLE"){
                                    $('#modalAlumnoDetalle-preescolar').modal('open');
                                    
                                }

                                if(movimiento == "PREESCOLAR HISTORIAL PAGOS"){
                                    $('#modalHistorialPagosPreescolar').modal('open');                                    
                                }

                                if(movimiento == "PREESCOLAR FICHA BBVA"){
                                    

                                    var pedirConfirmacion = $(this).data("pedir-confirmacion");
                                    if(pedirConfirmacion == 'SI') {
                                        swal({
                                            title: "Validar Pago Ceneval",
                                            text: "¿El alumno ya pagó su examen Ceneval?",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: '#0277bd',
                                            confirmButtonText: 'SI',
                                            cancelButtonText: "NO",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        }, function(isConfirm) {
                            
                                            if (isConfirm) {                                                

                                                //window.open("preescolar_curso/crearReferencia/" + curso_id + "/" + "si", "_blank");
                                                setTimeout(() => window.open("preescolar_curso/crearReferencia/" + curso_id + "/" + "si", "_blank"), 1000);
                                            } else {
                                                //window.open("preescolar_curso/crearReferencia/" + curso_id + "/" + "no", "_blank");
                                                setTimeout(() => window.open("preescolar_curso/crearReferencia/" + curso_id + "/" + "no", "_blank"), 1000);
                                            }
                                            swal.close()
                                        });
                                    } else {
                                       // window.open("preescolar_curso/crearReferencia/" + curso_id + "/" + "no", "_blank");
                                        setTimeout(() => window.open("preescolar_curso/crearReferencia/" + curso_id + "/" + "no", "_blank"), 1000);
                                    }
                                   
                                }

                                if(movimiento == "PREESCOLAR FICHA HSBC"){
                                    

                                    var pedirConfirmacion = $(this).data("pedir-confirmacion");
                                    if(pedirConfirmacion == 'SI') {
                                        swal({
                                            title: "Validar Pago Ceneval",
                                            text: "¿El alumno ya pagó su examen Ceneval?",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: '#0277bd',
                                            confirmButtonText: 'SI',
                                            cancelButtonText: "NO",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        }, function(isConfirm) {

                                            if (isConfirm) {
                                                //window.open("preescolar_curso/crearReferenciaHSBC/" + curso_id + "/" + "si", "_blank");
                                                setTimeout(() => window.open("preescolar_curso/crearReferenciaHSBC/" + curso_id + "/" + "si", "_blank"), 1000);
                                            } else {
                                                //window.open("preescolar_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank");
                                                setTimeout(() => window.open("preescolar_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank"), 1000);
                                            }
                                            swal.close()
                                        });
                                    } else {
                                        //window.open("preescolar_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank");
                                        setTimeout(() => window.open("preescolar_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank"), 1000);
                                    }
                                   
                                }

                            }
                            
                            if(departamento == "PRI"){

                                if(movimiento == "PRIMARIA VER ALUMNO DETALLE"){
                                    $('#modalAlumnoDetalle-primaria').modal('open');                                    
                                }

                                if(movimiento == "PRIMARIA VER PREINSCRITO"){
                                    location.href = `/primaria_curso/${curso_id}`;
                                }

                                if(movimiento == "PRIMARIA HISTORIAL PAGOS"){
                                    $('#modalHistorialPagosPrimaria').modal('open');                                    
                                }

                                if(movimiento == "PRIMARIA TARJETA PAGO BBVA PREINSCRITO"){
                                    //window.open(`tarjetaPagoAlumno/${curso_id}/BBVA`, '_blank');
                                    setTimeout(() => window.open(`tarjetaPagoAlumno/${curso_id}/BBVA`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA TARJETA PAGO HSBC PREINSCRITO"){
                                    //window.open(`tarjetaPagoAlumno/${curso_id}/HSBC`, '_blank');
                                    setTimeout(() => window.open(`tarjetaPagoAlumno/${curso_id}/HSBC`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA OBSERVACIONES"){
                                    location.href = `/primaria_curso/observaciones/${curso_id}`;
                                }

                                if(movimiento == "PRIMARIA GRUPOS CALIFICACIONES"){
                                    location.href = `/primaria_curso/grupos_alumno/${curso_id}`;
                                }

                                if(movimiento == "PRIMARIA BOLETA"){
                                    //window.open(`/boletaAlumnoCurso/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/boletaAlumnoCurso/${curso_id}`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA BOLETA ACD"){
                                    //window.open(`/reporte/primaria_boleta_de_calificaciones_acd/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/reporte/primaria_boleta_de_calificaciones_acd/${curso_id}`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA CONSTANCIA DE ESTUDIO SIN FOTO"){
                                    //window.open(`/primaria_reporte/constancia_estudio/imprimir/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/primaria_reporte/constancia_estudio/imprimir/${curso_id}/sin_foto`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA CONSTANCIA DE ESTUDIO CON FOTO"){
                                    //window.open(`/primaria_reporte/constancia_estudio/imprimir/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/primaria_reporte/constancia_estudio/imprimir/${curso_id}/con_foto`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA CONSTANCIA DE CUPO"){
                                    //window.open(`/primaria_reporte/constancia_de_cupo/imprimir/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/primaria_reporte/constancia_de_cupo/imprimir/${curso_id}`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA CARTA CONDUCTA SIN FOTO"){
                                    //window.open(`/primaria_reporte/carta_conducta/imprimir/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/primaria_reporte/carta_conducta/imprimir/${curso_id}/sin_foto`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA CARTA CONDUCTA CON FOTO"){
                                    //window.open(`/primaria_reporte/carta_conducta/imprimir/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/primaria_reporte/carta_conducta/imprimir/${curso_id}/con_foto`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA FICHA BBVA"){
                                    var pedirConfirmacion = $(this).data("pedir-confirmacion");
                                    if(pedirConfirmacion == 'SI') {
                                        swal({
                                            title: "Validar Pago Ceneval",
                                            text: "¿El alumno ya pagó su examen Ceneval?",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: '#0277bd',
                                            confirmButtonText: 'SI',
                                            cancelButtonText: "NO",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        }, function(isConfirm) {

                                            if (isConfirm) {
                                                setTimeout(() => window.open("primaria_curso/crearReferencia/" + curso_id + "/" + "si", "_blank"), 1000);
                                                //window.open("primaria_curso/crearReferencia/" + curso_id + "/" + "si", "_blank");
                                            } else {
                                                //window.open("primaria_curso/crearReferencia/" + curso_id + "/" + "no", "_blank");
                                                setTimeout(() => window.open("primaria_curso/crearReferencia/" + curso_id + "/" + "no", "_blank"), 1000);
                                            }
                                            swal.close()
                                        });
                                    } else {
                                        //window.open("primaria_curso/crearReferencia/" + curso_id + "/" + "no", "_blank");
                                        setTimeout(() => window.open("primaria_curso/crearReferencia/" + curso_id + "/" + "no", "_blank"), 1000);
                                    }
                                }

                                if(movimiento == "PRIMARIA FICHA HSBC"){
                                    var pedirConfirmacion = $(this).data("pedir-confirmacion");
                                    if(pedirConfirmacion == 'SI') {
                                        swal({
                                            title: "Validar Pago Ceneval",
                                            text: "¿El alumno ya pagó su examen Ceneval?",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: '#0277bd',
                                            confirmButtonText: 'SI',
                                            cancelButtonText: "NO",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        }, function(isConfirm) {

                                            if (isConfirm) {
                                                //window.open("primaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "si", "_blank");
                                                setTimeout(() => window.open("primaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "si", "_blank"), 1000);
                                            } else {
                                                //window.open("primaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank");
                                                setTimeout(() => window.open("primaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank"), 1000);
                                            }
                                            swal.close()
                                        });
                                    } else {
                                        //window.open("primaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank");
                                        setTimeout(() => window.open("primaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank"), 1000);
                                    }
                                }

                                if(movimiento == "PRIMARIA CONSTANCIA NO ADEUDO CON FOTO"){
                                    //window.open(`/primaria_reporte/constancia_no_adeudo/imprimir/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/primaria_reporte/constancia_no_adeudo/imprimir/${curso_id}/con_foto`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA CONSTANCIA NO ADEUDO SIN FOTO"){
                                    //window.open(`/primaria_reporte/constancia_no_adeudo/imprimir/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/primaria_reporte/constancia_no_adeudo/imprimir/${curso_id}/sin_foto`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA CONSTANCIA PASAPORTE INGLES CON FOTO"){
                                    setTimeout(() => window.open(`/primaria_reporte/constancia_pasaporte_ingles/imprimir/${curso_id}/con_foto`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA CONSTANCIA PASAPORTE INGLES SIN FOTO"){
                                    setTimeout(() => window.open(`/primaria_reporte/constancia_pasaporte_ingles/imprimir/${curso_id}/sin_foto`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA CONSTANCIA PASAPORTE CON FOTO"){
                                    setTimeout(() => window.open(`/primaria_reporte/constancia_pasaporte/imprimir/${curso_id}/con_foto`, '_blank'), 1000);
                                }

                                if(movimiento == "PRIMARIA CONSTANCIA PASAPORTE SIN FOTO"){
                                    setTimeout(() => window.open(`/primaria_reporte/constancia_pasaporte/imprimir/${curso_id}/sin_foto`, '_blank'), 1000);
                                }
                            }

                            if(departamento == "SEC"){

                                if(movimiento == "SECUNDARIA VER ALUMNO DETALLE"){
                                    $('#modalAlumnoDetalle-secundaria').modal('open');                                    
                                }

                                if(movimiento == "SECUNDARIA VER PREINSCRITO"){
                                    location.href = `/secundaria_curso/${curso_id}`;
                                }

                                if(movimiento == "SECUNDARIA HISTORIAL PAGOS"){
                                    $('#modalHistorialPagosAluSecundaria').modal('open');                                    
                                }

                                if(movimiento == "SECUNDARIA TARJETA PAGO BBVA PREINSCRITO"){
                                    //window.open(`tarjetaPagoAlumno/${curso_id}/BBVA`, '_blank');
                                    setTimeout(() => window.open(`tarjetaPagoAlumno/${curso_id}/BBVA`, '_blank'), 1000);

                                }

                                if(movimiento == "SECUNDARIA TARJETA PAGO HSBC PREINSCRITO"){
                                    //window.open(`tarjetaPagoAlumno/${curso_id}/HSBC`, '_blank');
                                    setTimeout(() => window.open(`tarjetaPagoAlumno/${curso_id}/HSBC`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA OBSERVACIONES"){
                                    location.href = `/secundaria_curso/observaciones/${curso_id}`;
                                }

                                if(movimiento == "SECUNDARIA GRUPOS CALIFICACIONES"){
                                    location.href = `/secundaria_curso/grupos_alumno/${curso_id}`;
                                }

                                if(movimiento == "SECUNDARIA BOLETA"){
                                    //window.open(`/secundaria/boletaAlumnoCurso/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/secundaria/boletaAlumnoCurso/${curso_id}`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA BOLETA ACD"){
                                    //window.open(`/reporte/secundaria_boleta_de_calificaciones_acd/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/reporte/secundaria_boleta_de_calificaciones_acd/${curso_id}`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA CONSTANCIA DE ESTUDIO"){
                                    //window.open(`/secundaria_reporte/constancia_estudio/imprimir/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/secundaria_reporte/constancia_estudio/imprimir/${curso_id}`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA CONSTANCIA DE CUPO MEMBRETADA"){
                                    //window.open(`/secundaria_reporte/constancia_de_cupo/imprimir/${curso_id}/membretada`, '_blank');
                                    setTimeout(() => window.open(`/secundaria_reporte/constancia_de_cupo/imprimir/${curso_id}/membretada`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA CONSTANCIA DE CUPO DIGITAL"){
                                    //window.open(`/secundaria_reporte/constancia_de_cupo/imprimir/${curso_id}/digital`, '_blank');
                                    setTimeout(() => window.open(`/secundaria_reporte/constancia_de_cupo/imprimir/${curso_id}/digital`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA CARTA CONDUCTA"){
                                    //window.open(`/secundaria_reporte/carta_conducta/imprimir/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/secundaria_reporte/carta_conducta/imprimir/${curso_id}`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA CONSTANCIA DE PROMEDIO FINAL"){
                                    //window.open(`/secundaria_reporte/constancia_de_promedio_final/imprimir/${curso_id}/digital`, '_blank');
                                    setTimeout(() => window.open(`/secundaria_reporte/constancia_de_promedio_final/imprimir/${curso_id}/digital`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA CONSTANCIA DE ARTES Y TALLERES"){
                                    //window.open(`/secundaria_reporte/constancia_de_artes_talleres/imprimir/${curso_id}/digital`, '_blank');
                                    setTimeout(() => window.open(`/secundaria_reporte/constancia_de_artes_talleres/imprimir/${curso_id}/digital`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA DE INSCRIPCION"){
                                    //window.open(`/secundaria_reporte/constancia_de_inscripcion/imprimir/${curso_id}/membretada`, '_blank');
                                    setTimeout(() => window.open(`/secundaria_reporte/constancia_de_inscripcion/imprimir/${curso_id}/membretada`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA DE ESCOLARIDAD"){
                                    //window.open(`/secundaria_reporte/constancia_de_escolaridad/imprimir/${curso_id}/digital`, '_blank');
                                    setTimeout(() => window.open(`/secundaria_reporte/constancia_de_escolaridad/imprimir/${curso_id}/digital`, '_blank'), 1000);
                                }

                                if(movimiento == "SECUNDARIA FICHA BBVA"){
                                    var pedirConfirmacion = $(this).data("pedir-confirmacion");
                                    if(pedirConfirmacion == 'SI') {
                                        swal({
                                            title: "Validar Pago Ceneval",
                                            text: "¿El alumno ya pagó su examen Ceneval?",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: '#0277bd',
                                            confirmButtonText: 'SI',
                                            cancelButtonText: "NO",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        }, function(isConfirm) {
                            
                                            if (isConfirm) {
                                                //window.open("secundaria_curso/crearReferencia/" + curso_id + "/" + "si", "_blank");
                                                setTimeout(() => window.open("secundaria_curso/crearReferencia/" + curso_id + "/" + "si", "_blank"), 1000);

                                            } else {
                                                //window.open("secundaria_curso/crearReferencia/" + curso_id + "/" + "no", "_blank");
                                                setTimeout(() => window.open("secundaria_curso/crearReferencia/" + curso_id + "/" + "no", "_blank"), 1000);

                                            }
                                            swal.close()
                                        });
                                    } else {
                                        //window.open("secundaria_curso/crearReferencia/" + curso_id + "/" + "no", "_blank");
                                        setTimeout(() => window.open("secundaria_curso/crearReferencia/" + curso_id + "/" + "no", "_blank"), 1000);

                                    }
                                }

                                if(movimiento == "SECUNDARIA FICHA HSBC"){
                                    var pedirConfirmacion = $(this).data("pedir-confirmacion");
                                    if(pedirConfirmacion == 'SI') {
                                        swal({
                                            title: "Validar Pago Ceneval",
                                            text: "¿El alumno ya pagó su examen Ceneval?",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: '#0277bd',
                                            confirmButtonText: 'SI',
                                            cancelButtonText: "NO",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        }, function(isConfirm) {

                                            if (isConfirm) {
                                                //window.open("secundaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "si", "_blank");
                                                setTimeout(() => window.open("secundaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "si", "_blank"), 1000);
                                            } else {
                                                //window.open("secundaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank");
                                                setTimeout(() => window.open("secundaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank"), 1000);
                                            }
                                            swal.close()
                                        });
                                    } else {
                                        //window.open("secundaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank");
                                        setTimeout(() => window.open("secundaria_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank"), 1000);
                                    }
                                }

                                if(movimiento == "SECUNDARIA CONSTANCIA NO ADEUDO"){
                                    //window.open(`/secundaria_reporte/constancia_no_adeudo/imprimir/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/secundaria_reporte/constancia_no_adeudo/imprimir/${curso_id}`, '_blank'), 1000);
                                }
                            }

                            if(departamento == "BAC"){

                                if(movimiento == "BACHILLER VER ALUMNO DETALLE"){
                                    $('#modalAlumnoDetalle-bachiller').modal('open');                                    
                                }

                                if(movimiento == "BACHILLER VER PREINSCRITO"){
                                    location.href = `/bachiller_curso/${curso_id}`;
                                }

                                if(movimiento == "BACHILLER HISTORIAL PAGOS"){
                                    $('#modalHistorialPagosAluBachiller').modal('open');                                    
                                }

                                if(movimiento == "BACHILLER TARJETA PAGO BBVA PREINSCRITO"){
                                    //window.open(`tarjetaPagoAlumno/${curso_id}/BBVA`, '_blank');
                                    setTimeout(() => window.open(`tarjetaPagoAlumno/${curso_id}/BBVA`, '_blank'), 1000);
                                }

                                if(movimiento == "BACHILLER TARJETA PAGO HSBC PREINSCRITO"){
                                    //window.open(`tarjetaPagoAlumno/${curso_id}/HSBC`, '_blank');
                                    setTimeout(() => window.open(`tarjetaPagoAlumno/${curso_id}/HSBC`, '_blank'), 1000);
                                }

                                if(movimiento == "BACHILLER OBSERVACIONES"){
                                    location.href = `/bachiller_curso/observaciones/${curso_id}`;
                                }

                                if(movimiento == "BACHILLER BOLETA"){
                                    //window.open(`/bachiller/boletaAlumnoCurso/${curso_id}`, '_blank');
                                    setTimeout(() => window.open(`/bachiller/boletaAlumnoCurso/${curso_id}`, '_blank'), 1000);
                                }

                                if(movimiento == "BACHILLER FICHA BBVA"){
                                    var pedirConfirmacion = $(this).data("pedir-confirmacion");
                                    if(pedirConfirmacion == 'SI') {
                                        swal({
                                            title: "Validar Pago Ceneval",
                                            text: "¿El alumno ya pagó su examen Ceneval?",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: '#0277bd',
                                            confirmButtonText: 'SI',
                                            cancelButtonText: "NO",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        }, function(isConfirm) {

                                            if (isConfirm) {
                                                //window.open("bachiller_curso/crearReferencia/" + curso_id + "/" + "si", "_blank");
                                                setTimeout(() => window.open("bachiller_curso/crearReferencia/" + curso_id + "/" + "si", "_blank"), 1000);
                                            } else {
                                                //window.open("bachiller_curso/crearReferencia/" + curso_id + "/" + "no", "_blank");
                                                setTimeout(() => window.open("bachiller_curso/crearReferencia/" + curso_id + "/" + "no", "_blank"), 1000);
                                            }
                                            swal.close()
                                        });
                                    } else {
                                        //window.open("bachiller_curso/crearReferencia/" + curso_id + "/" + "no", "_blank");
                                        setTimeout(() => window.open("bachiller_curso/crearReferencia/" + curso_id + "/" + "no", "_blank"), 1000);
                                    }
                                }

                                if(movimiento == "BACHILLER FICHA HSBC"){
                                    var pedirConfirmacion = $(this).data("pedir-confirmacion");
                                    if(pedirConfirmacion == 'SI') {
                                        swal({
                                            title: "Validar Pago Ceneval",
                                            text: "¿El alumno ya pagó su examen Ceneval?",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: '#0277bd',
                                            confirmButtonText: 'SI',
                                            cancelButtonText: "NO",
                                            closeOnConfirm: false,
                                            closeOnCancel: false
                                        }, function(isConfirm) {

                                            if (isConfirm) {
                                                //window.open("bachiller_curso/crearReferenciaHSBC/" + curso_id + "/" + "si", "_blank");
                                                setTimeout(() => window.open("bachiller_curso/crearReferenciaHSBC/" + curso_id + "/" + "si", "_blank"), 1000);
                                            } else {
                                                //window.open("bachiller_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank");
                                                setTimeout(() => window.open("bachiller_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank"), 1000);
                                            }
                                            swal.close()
                                        });
                                    } else {
                                        //window.open("bachiller_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank");
                                        setTimeout(() => window.open("bachiller_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank"), 1000);
                                    }
                                }

                                if(movimiento == "BACHILLER CAMBIAR CGT"){
                                    location.href = `/bachiller_cambiar_cgt_preinscrito/${curso_id}`;
                                }

                            }
                        },
                        error: function(data){
                            swal("Escuela Modelo", "Error inesperado, intende más tarde", "error");
                        }
                    });
                    
                }
            });
    });
</script>
