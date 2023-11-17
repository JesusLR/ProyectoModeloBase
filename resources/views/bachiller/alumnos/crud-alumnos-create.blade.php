<script>
    

	function buscarTutor(tutNombre, tutTelefono) {
        $.ajax({
            type: 'GET',
            url: base_url + '/api/bachiller_alumno/tutores/buscar_tutor/' + tutNombre+ '/' +tutTelefono,
            data: {tutNombre: tutNombre, tutTelefono: tutTelefono},
            dataType: 'json',
            success: function(data) {
                console.log(data);
                data ? fillElements(data) : swal('No existe tutor con estos datos.', 'Puede llenar el formulario para registrar este tutor.');
                data ? $('#vincularTutor').removeAttr('disabled') : $('#vincularTutor').attr('disabled', true);

                data ? $("#id").val(data.id) : $("#id").val("");

                
            },
            error: function () {
                console.log('error');
            }
        });
    }//buscarTutor.

    function addRow_tutor(tutNombre, tutTelefono, tutCalle, tutColonia, tutCodigoPostal, tutPoblacion, tutEstado, id, tutCorreo) {

        if(tutCorreo == null){
            tutCalle = "";
        }else{
            tutCalle = tutCalle;
        }

        if(tutColonia == null){
            tutColonia = "";
        }else{
            tutColonia = tutColonia;
        }

        if(tutCodigoPostal == null){
            tutCodigoPostal = "";
        }else{
            tutCodigoPostal = tutCodigoPostal;
        }

        if(tutPoblacion == null){
            tutPoblacion = "";
        }else{
            tutPoblacion = tutPoblacion;
        }

        if(tutEstado == null){
            tutEstado = "";
        }else{
            tutEstado = tutEstado;
        }
        if(tutCorreo == null){
            tutCorreo = "";
        }else{
            tutCorreo = tutCorreo;
        }

        var tutor_row = `<tr><input type="hidden" name="tutores[]" value="${tutNombre}~${tutTelefono}~${tutCalle}~${tutColonia}~${tutCodigoPostal}~${tutPoblacion}~${tutEstado}~${id}~${tutCorreo}"/>` +
            `<td><input value="${tutNombre}" id="tutNombreEdit" name="tutNombreEdit[]"></td>`+
            `<td><input value="${tutTelefono}" id="tutTelefonoEdit" name="tutTelefonoEdit[]"></td>`+
            `<td><input value="${tutCalle}" id="tutCalleEdit" name="tutCalleEdit[]"></td>`+
            `<td><input value="${tutColonia}" id="tutColoniaEdit" name="tutColoniaEdit[]"></td>`+
            `<td><input value="${tutCodigoPostal}" id="tutCodigoPostalEdit" name="tutCodigoPostalEdit[]"></td>`+
            `<td><input value="${tutPoblacion}" id="tutPoblacionEdit" name="tutPoblacionEdit[]"></td>`+
            `<td><input value="${tutEstado}" id="tutEstadoEdit" name="tutEstadoEdit[]"></td>`+
            `<td style='display:none;'><input value="${id}" id="tutor_id_edit" name="tutor_id_edit[]"></td>`+
            `<td><input class="noUpperCase" value="${tutCorreo}" id="tutCorreoEdit" name="tutCorreoEdit[]"></td>`+
            `<td><a class="desvincular" style="cursor:pointer;" title="Desvincular">
                <i class="material-icons">sync_disabled</i>
            </a></td>`+
         '</tr>';

 
        $('#tbl-tutores tbody').append(tutor_row);
    }//addRow_tutor.

    function llenar_tabla_tutores(alumno_id) {

        $.ajax({
            type:'GET',
            url: base_url + '/api/bachiller_alumno/tutores/' + alumno_id,
            data:{alumno_id: alumno_id},
            dataType: 'json',
            success: function (data) {
                if(data){
                    console.log(data);
                    $.each(data, function (key, value) {
                        console.log(value);
                        (!$.isEmptyObject(value)) && addRow_tutor(value.tutNombre, value.tutTelefono, value.tutCalle, value.tutColonia, value.tutCodigoPostal, value.tutPoblacion, value.tutEstado, value.id, value.tutCorreo);
                    });
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });
    }//llenar_tabla_tutores.

    
</script>