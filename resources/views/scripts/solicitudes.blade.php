<script type="text/javascript">
    $(document).on('click', '#btnBuscarExtra', function (e) {
        resetSelect('alumno_id');
        var extraordinario_id = $('#extraordinario_id').val();
        if(extraordinario_id != ""){
            $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');});
            $.get(base_url + `/api/extraordinario/${extraordinario_id}`,function(res,sta) {
                $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                if(jQuery.isEmptyObject(res)){
                    swal({
                        title: "Ups...",
                        text: "No se encontro el extraordinario",
                        type: "warning",
                        confirmButtonText: "Ok",
                        confirmButtonColor: '#3085d6',
                        showCancelButton: false
                    });
                }else{
                    let optativa = res.optativa;
                    let aula = res.aula;
                    $('#ubiClave').val(res.materia.plan.programa.escuela.departamento.ubicacion.ubiNombre);
                    Materialize.updateTextFields();
                    $('#departamento_id').val(res.materia.plan.programa.escuela.departamento.depNombre);
                    Materialize.updateTextFields();
                    $('#escuela_id').val(res.materia.plan.programa.escuela.escNombre);
                    Materialize.updateTextFields();
                    $('#periodo_id').val(res.periodo.perNumero +'-'+ res.periodo.perAnio);
                    Materialize.updateTextFields();
                    $('#perFechaInicial').val(res.periodo.perFechaInicial);
                    Materialize.updateTextFields();
                    $('#perFechaFinal').val(res.periodo.perFechaFinal);
                    Materialize.updateTextFields();
                    $('#programa_id').val(res.materia.plan.programa.progNombre);
                    Materialize.updateTextFields();
                    $('#plan_id').val(res.materia.plan.planClave);
                    Materialize.updateTextFields();
                    $('#matSemestre').val(res.materia.matSemestre);
                    Materialize.updateTextFields();
                    $('#extGrupo').val(res.extGrupo);
                    Materialize.updateTextFields();
                    $('#extFecha').val(res.extFecha);
                    Materialize.updateTextFields();
                    $('#extHora').val(res.extHora);
                    Materialize.updateTextFields();
                    $('#extPago').val(res.extPago);
                    Materialize.updateTextFields();
                    $('#materia_id').val(res.materia.matNombre);
                    Materialize.updateTextFields();
                    $('#aula_id').val(aula ? aula.aulaClave : '');
                    Materialize.updateTextFields();
                    $('#empleado_id').val(res.empleado.persona.perNombre + ' ' + res.empleado.persona.perApellido1 + ' ' + res.empleado.persona.perApellido2);
                    Materialize.updateTextFields();
                    $('#empleado_sinodal_id').val(res.empleado_sinodal.persona.perNombre + ' ' + res.empleado_sinodal.persona.perApellido1 + ' ' + res.empleado_sinodal.persona.perApellido2);
                    Materialize.updateTextFields();
                    $('#optativa_id').val(optativa ? optativa.materia.matNombre : '');
                    Materialize.updateTextFields();
                }
            });
    
    
    
            $.get(base_url + `/api/extraordinario/getAlumnosByFolioExtraordinario/` + extraordinario_id,function(res,sta) {
                res.forEach(element => {
                    if(element.alumno) {
                    $("#alumno_id").append(`<option value=${element.alumno.id}>${element.alumno.aluClave}-${element.alumno.persona.perNombre} ${element.alumno.persona.perApellido1} ${element.alumno.persona.perApellido2}</option>`);
                    }
                });
            });
    
        } else {
            swal({
                title: "Ups...",
                text: "El campo clave de examen es requerido",
                type: "warning",
                confirmButtonText: "Ok",
                confirmButtonColor: '#3085d6',
                showCancelButton: false
            });
        }
     });
    
    </script>