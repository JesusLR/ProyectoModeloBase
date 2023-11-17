

	function buscarTutor(tutNombre, tutTelefono) {
        $.ajax({
            type: 'GET',
            url: base_url + '/api/alumno/tutores/buscar_tutor/' + tutNombre+ '/' +tutTelefono,
            data: {tutNombre: tutNombre, tutTelefono: tutTelefono},
            dataType: 'json',
            success: function(data) {
                console.log(data);
                data ? fillElements(data) : swal('No existe tutor con estos datos.', 'Puede llenar el formulario para registrar este tutor.');
                data ? $('#vincularTutor').removeAttr('disabled') : $('#vincularTutor').attr('disabled', true);
            },
            error: function () {
                console.log('error');
            }
        });
    }//buscarTutor.

    function addRow_tutor(tutNombre, tutTelefono) {
        var tutor_row = `<tr><input type="hidden" name="tutores[]" value="${tutNombre}~${tutTelefono}"/>` +
                            '<td>'+tutNombre+'</td>'+
                            '<td>'+tutTelefono+'</td>'+
                            '<td><a class="desvincular" style="cursor:pointer;" title="Desvincular">'+
                                '<i class="material-icons">sync_disabled</i>'+
                            '</a></td>'+
                         '</tr>';
        $('#tbl-tutores tbody').append(tutor_row);
    }//addRow_tutor.

    function llenar_tabla_tutores(alumno_id) {

        $.ajax({
            type:'GET',
            url: base_url + '/api/alumno/tutores/' + alumno_id,
            data:{alumno_id: alumno_id},
            dataType: 'json',
            success: function (data) {
                if(data){
                    console.log(data);
                    $.each(data, function (key, value) {
                        console.log(value);
                        (!$.isEmptyObject(value)) && addRow_tutor(value.tutNombre, value.tutTelefono);
                    });
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });
    }//llenar_tabla_tutores.

    