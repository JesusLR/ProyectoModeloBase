<script type="text/javascript">

    $(document).ready(function() {

        // OBTENER ALUMNOS PREINSCRITOS POR PERIODO
        $("#periodo_id").change( event => {
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();
            var cgt_id = $("#cgt_id").val();

            $("#TablaCalificaciones").hide();
            $("#boton-guardar").hide();
            $("#alerta-min-max-calif").hide();

            $("#alumno_id").empty();
            $("#alumno_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/datos/primaria_calificacion_general/lista_de_alumnos/${event.target.value}/${programa_id}/${plan_id}/${cgt_id}`,function(res,sta){
                res.forEach(element => {

                    if(element.apellido_materno == null){
                        var apellido_materno = "";
                    }else{
                        var apellido_materno = element.apellido_materno;
                    }
                    $("#alumno_id").append(`<option value=${element.curso_id}>${element.aluClave}-${element.nombres} ${element.apellido_paterno} ${apellido_materno}</option>`);
                });
            });
        });

        // OBTENER ALUMNOS PREINSCRITOS POR PROGRAMA
        $("#programa_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var plan_id = $("#plan_id").val();
            var cgt_id = $("#cgt_id").val();

            $("#TablaCalificaciones").hide();
            $("#boton-guardar").hide();
            $("#alerta-min-max-calif").hide();

            $("#alumno_id").empty();
            $("#alumno_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/datos/primaria_calificacion_general/lista_de_alumnos/${periodo_id}/${event.target.value}/${plan_id}/${cgt_id}`,function(res,sta){
                res.forEach(element => {
                    if(element.apellido_materno == null){
                        var apellido_materno = "";
                    }else{
                        var apellido_materno = element.apellido_materno;
                    }
                    $("#alumno_id").append(`<option value=${element.curso_id}>${element.aluClave}-${element.nombres} ${element.apellido_paterno} ${apellido_materno}</option>`);
                });
            });
        });

        // OBTENER ALUMNOS PREINSCRITOS POR PLAN
        $("#plan_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var programa_id = $("#programa_id").val();
            var cgt_id = $("#cgt_id").val();

            $("#TablaCalificaciones").hide();
            $("#boton-guardar").hide();
            $("#alerta-min-max-calif").hide();

            $("#alumno_id").empty();
            $("#alumno_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/datos/primaria_calificacion_general/lista_de_alumnos/${periodo_id}/${programa_id}/${event.target.value}/${cgt_id}`,function(res,sta){
                res.forEach(element => {
                    if(element.apellido_materno == null){
                        var apellido_materno = "";
                    }else{
                        var apellido_materno = element.apellido_materno;
                    }
                    $("#alumno_id").append(`<option value=${element.curso_id}>${element.aluClave}-${element.nombres} ${element.apellido_paterno} ${apellido_materno}</option>`);
                });
            });
        });

        // OBTENER ALUMNOS PREINSCRITOS POR CGT
        $("#cgt_id").change( event => {
            var periodo_id = $("#periodo_id").val();
            var programa_id = $("#programa_id").val();
            var plan_id = $("#plan_id").val();

            $("#TablaCalificaciones").hide();
            $("#boton-guardar").hide();
            $("#alerta-min-max-calif").hide();

            $("#alumno_id").empty();
            $("#alumno_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/datos/primaria_calificacion_general/lista_de_alumnos/${periodo_id}/${programa_id}/${plan_id}/${event.target.value}`,function(res,sta){
                res.forEach(element => { 
                    if(element.apellido_materno == null){
                        var apellido_materno = "";
                    }else{
                        var apellido_materno = element.apellido_materno;
                    }                   
                    $("#alumno_id").append(`<option value=${element.curso_id}>${element.aluClave}-${element.nombres} ${element.apellido_paterno} ${apellido_materno}</option>`);
                });
                
            });
        });

        

        //CREAR LA TABLA DE LAS CALIFICACIONES DEL ALUMNO
        $("#alumno_id").change( event => {
            //alert(event.target.value)

            $.get(base_url+`/calificaciones/primaria_calificacion_general/${event.target.value}`,function(res,sta){
                console.log(res)

                const calificaciones = res;

                //Validando si hay datos en el array
                if(calificaciones != ""){

                    $("#TablaCalificaciones").show();
                    $("#boton-guardar").show();
                    $("#alerta-min-max-calif").show();

                    const data = calificaciones;

                    const tableData = data.map(function(element){

                        //validando si tiene asignatura
                        var asignatura = "";
                        if(element.matClaveAsignatura == null && element.matNombreAsignatura == null){
                            asignatura = "";
                        }else{
                            asignatura = element.matClaveAsignatura + '-' + element.matNombreAsignatura;
                        }

                        
                        //<td><input type='number' id='inscCalificacionDic' onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value='${element.inscCalificacionDic}' name='inscCalificacionDic[]' step="0.1" min="5" max="10"></td>

                        return (
                                `<tr>
                                    <td><input name='primaria_inscrito_id[]' id='primaria_inscrito_id' value='${element.id}' style='display:none;'></td>
                                    <td>${element.matClave}-${element.matNombre}</td>
                                    <td>${asignatura}</td>
                                    <td><input type='number' class='noUpperCase' id='inscCalificacionSep' onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value='${element.inscCalificacionSep}' name='inscCalificacionSep[]' step="0.1" min="5" max="10"></td>
                                    <td><input type='number' class='noUpperCase' id='inscCalificacionOct' onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value='${element.inscCalificacionOct}' name='inscCalificacionOct[]' step="0.1" min="5" max="10"></td>
                                    <td><input type='number' class='noUpperCase' id='inscCalificacionNov' onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value='${element.inscCalificacionNov}' name='inscCalificacionNov[]' step="0.1" min="5" max="10"></td>
                                    <td><input type='number' class='noUpperCase' id='inscCalificacionEne' onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value='${element.inscCalificacionEne}' name='inscCalificacionEne[]' step="0.1" min="5" max="10"></td>
                                    <td><input type='number' class='noUpperCase' id='inscCalificacionFeb' onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value='${element.inscCalificacionFeb}' name='inscCalificacionFeb[]' step="0.1" min="5" max="10"></td>
                                    <td><input type='number' class='noUpperCase' id='inscCalificacionMar' onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value='${element.inscCalificacionMar}' name='inscCalificacionMar[]' step="0.1" min="5" max="10"></td>
                                    <td><input type='number' class='noUpperCase' id='inscCalificacionAbr' onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value='${element.inscCalificacionAbr}' name='inscCalificacionAbr[]' step="0.1" min="5" max="10"></td>
                                    <td><input type='number' class='noUpperCase' id='inscCalificacionMay' onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value='${element.inscCalificacionMay}' name='inscCalificacionMay[]' step="0.1" min="5" max="10"></td>
                                    <td><input type='number' class='noUpperCase' id='inscCalificacionJun' onblur="if(this.value>10){this.value='';}else if(this.value<5){this.value='';}" value='${element.inscCalificacionJun}' name='inscCalificacionJun[]' step="0.1" min="5" max="10"></td>

                                </tr>`
                            );
                        }).join('');
                        const tableBody = document.querySelector("#tableBody");
                        tableBody.innerHTML = tableData;

                }else{
                    $("#TablaCalificaciones").hide();
                    $("#boton-guardar").hide();
                    $("#alerta-min-max-calif").hide();
                    swal("Sin resultados", "El alumno seleccionado no se encuentra inscrito en ningun grupo", "info");

                }


            });

            
           
        });



        //Guardar las calificaciones 
        $(document).on("click", "#guardar_calificaciones", function(e) {

            var primaria_inscrito_id = $("input[id='primaria_inscrito_id']") .map(function(){return $(this).val();}).get();
            var inscCalificacionSep = $("input[id='inscCalificacionSep']") .map(function(){return $(this).val();}).get();
            var inscCalificacionOct = $("input[id='inscCalificacionOct']") .map(function(){return $(this).val();}).get();
            var inscCalificacionNov = $("input[id='inscCalificacionNov']") .map(function(){return $(this).val();}).get();
            //var inscCalificacionDic = $("input[id='inscCalificacionDic']") .map(function(){return $(this).val();}).get();
            var inscCalificacionEne = $("input[id='inscCalificacionEne']") .map(function(){return $(this).val();}).get();
            var inscCalificacionFeb = $("input[id='inscCalificacionFeb']") .map(function(){return $(this).val();}).get();
            var inscCalificacionMar = $("input[id='inscCalificacionMar']") .map(function(){return $(this).val();}).get();
            var inscCalificacionAbr = $("input[id='inscCalificacionAbr']") .map(function(){return $(this).val();}).get();
            var inscCalificacionMay = $("input[id='inscCalificacionMay']") .map(function(){return $(this).val();}).get();
            var inscCalificacionJun = $("input[id='inscCalificacionJun']") .map(function(){return $(this).val();}).get();



         
            
           
            e.preventDefault();

            swal({
                title: "Actualizar calificaciones",
                text: "Está seguro que desea continuar",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#0277bd',
                confirmButtonText: 'SI',
                cancelButtonText: "NO",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        url: "{{route('primaria.primaria_calificacion_general.guardarCalificaciones')}}",
                        method: "POST",
                        dataType: "json",
                        data: {
                            "_token": $("meta[name=csrf-token]").attr("content"),
                            primaria_inscrito_id: primaria_inscrito_id,
                            inscCalificacionSep: inscCalificacionSep,
                            inscCalificacionOct: inscCalificacionOct,
                            inscCalificacionNov: inscCalificacionNov,
                            //inscCalificacionDic: inscCalificacionDic,
                            inscCalificacionEne: inscCalificacionEne,
                            inscCalificacionFeb: inscCalificacionFeb,
                            inscCalificacionMar: inscCalificacionMar,
                            inscCalificacionAbr: inscCalificacionAbr,
                            inscCalificacionMay: inscCalificacionMay,
                            inscCalificacionJun: inscCalificacionJun                           
                        },
                        beforeSend: function () {
                                          
                            $("guardar_calificaciones").prop('disabled', true);

                            var html = "";
                            html += "<div class='preloader-wrapper big active'>"+
                                "<div class='spinner-layer spinner-blue-only'>"+
                                  "<div class='circle-clipper left'>"+
                                    "<div class='circle'></div>"+
                                  "</div><div class='gap-patch'>"+
                                    "<div class='circle'></div>"+
                                  "</div><div class='circle-clipper right'>"+
                                    "<div class='circle'></div>"+
                                  "</div>"+
                                "</div>"+
                              "</div>";
                            
                            html += "<p>" + "</p>"

                            swal({
                                html:true,
                                title: "Guardando...",
                                text: html,
                                showConfirmButton: false
                                //confirmButtonText: "Ok",
                            })

                        },
                        success: function(data){
                            
                            console.log(data.res)
                            if(data.res == "true"){
                            
                                $("guardar_calificaciones").prop('disabled', false);


                                swal({
                                    title: "Escuela Modelo!",
                                    text: "Se actualizo las calificaciones con éxito",
                                    type: "success",
                                    timer: 3000
                               }, 
                               function(confimar){
                                  
                                   //location.reload();

                                   if(confimar){
                                        //location.reload();
                                   }
                               })     

                            }

                            if(data.res == "GradoDiferente"){
                                swal("Escuela Modelo", "El grado donde desea cambiar al alumno es difente al grado actual", "info");
                            }

                            if(data.res == "perActualDiferente"){
                                swal("Escuela Modelo", "Solo se puede realizar el tramite en el periodo vigente actual", "info");
                            }

                            if(data.res == "programaIgual"){
                                swal("Escuela Modelo", "Solo se puede realizar el tramite a un programa diferente al actual", "info");
                            }
                 
                        },
                        error: function(){
                            swal("Escuela Modelo", "Error inesperado, intende nuevamente (verique si ha seleccionado todos los campos)", "error");
                        }
                      });

                
                      
                } else {
                    swal.close()
                }
            });
        });

     });
</script>