{{-- MODAL EQUIVALENTES --}}
<div id="modalEquivalente" class="modal">
    <div class="modal-content">
        <h4>Grupo equivalente</h4>
        <p><span style="font-weight: bold;">PERIODO:</span> <span class="modal-titulo-periodo"></span> / <span style="font-weight: bold;">AÑO:</span> <span class="modal-periodo-anio"></span> </p>
        <table id="tbl-grupo-equivalente-bachiller" class="responsive-table display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Plan</th>
                <th>Programa</th>
                <th>Clave-Materia</th>
                <th>Materia</th>
                <th>Nombre optativa</th>
                <th>Grado-Grupo-Turno</th>
                <th>Seleccionar</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="non_searchable"></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="modal-close waves-effect waves-green btn-flat">Cerrar</button>
    </div>
</div>


<script>
//OBTENER GRUPO SELECCIONADO
function seleccionarGrupo(grupo_id){
    $.get(base_url+`/bachiller_grupo_uady/getGrupo/${grupo_id}`,function(res,sta) {
        console.log("grupo equivalente", res)

        $('#empleado_id').val(res.empleado_id_docente);
        $('#empleado_id').trigger('change'); // Notify only Select2 of changes
        $("#empleado_id").closest(".empleadoinput").find(".block").toggle();


        $('#gpoFechaExamenOrdinario').val(res.gpoFechaExamenOrdinario);
        $("#gpoFechaExamenOrdinario").prop("disabled", true);

        $('#gpoHoraExamenOrdinario').val(res.gpoHoraExamenOrdinario);
        $("#gpoHoraExamenOrdinario").prop("disabled", true);

        $('#empleado_sinodal_id').val(res.empleado_id_auxiliar);
        $('#empleado_sinodal_id').trigger('change'); // Notify only Select2 of changes
        $("#empleado_sinodal_id").closest(".sinodalinput").find(".block").toggle();


        $('#grupo_equivalente_id').attr('value', res.id);
        
        $('#programa_equivalente').val(res.plan.programa.progClave+'-'+res.plan.programa.progNombre);
        $('#plan_equivalente').val(res.plan.planClave);
        $('#materia_equivalente').val(res.bachiller_materia.matClave+'-'+res.bachiller_materia.matNombre);
        $('#cgt_equivalente').val(res.gpoGrado+'-'+res.gpoClave+'-'+res.gpoTurno);
        $('#cancelar_seleccionado').attr("style", "display:inline");
        Materialize.updateTextFields();
    });
}
//CANCELAR GRUPO SELECCIONADO
function cancelarSeleccionado(){
    $('#grupo_equivalente_id').val('');
    $('#programa_equivalente').val('');
    $('#plan_equivalente').val('');
    $('#materia_equivalente').val('');
    $('#cgt_equivalente').val('');

    //$('#empleado_id').val('');
    //$('#empleado_id').trigger('change'); // Notify only Select2 of changes
    //$("#empleado_id").closest(".empleadoinput").find(".block").toggle();


    $('#gpoFechaExamenOrdinario').val('');
    $("#gpoFechaExamenOrdinario").prop("disabled", false);
    $('#gpoHoraExamenOrdinario').val('');
    $("#gpoHoraExamenOrdinario").prop("disabled", false);


    $('#empleado_sinodal_id').val('');
    $('#empleado_sinodal_id').trigger('change'); // Notify only Select2 of changes
    $("#empleado_sinodal_id").closest(".sinodalinput").find(".block").toggle();
    
    $('#cancelar_seleccionado').attr("style", "display:none");
    Materialize.updateTextFields();
}
</script>