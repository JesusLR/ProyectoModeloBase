<script>
    function getEstadosMadre(paisMadre_Id, targetSelect = 'estadoMadre_id', val = null, dataName = null) {
        var select = $('#' + targetSelect);
        var current_data = dataName || 'estadoMadre-id';
        var current_value = val || select.data(current_data);
        select.empty().append(new Option('SELECCIONE UNA OPCIÓN', ''));
        $.ajax({
            type: 'GET',
            url: base_url + '/api/estados/' + paisMadre_Id,
            dataType: 'json',
            data: { paisMadre_Id: paisMadre_Id },
            success: function(estados) {
                if (estados) {
                    $.each(estados, function(key, value) {
                        select.append(new Option(value.edoNombre, value.id));
                        (value.id == current_value) && select.val(value.id);
                    });
                    select.trigger('change');
                    select.trigger('click');
                }
            },
            error: function(Xhr, textMessage, errorMessage) {
                console.log(errorMessage);
            }
        });
    } //getEstados.

    function getMunicipiosMadre(estadoMadre_id, targetSelect = 'municipioMadre_id', val = null, dataName = null) {
        var select = $('#' + targetSelect);
        var current_data = dataName || 'municipioMadre-id';
        var current_value = val || select.data(current_data);
        select.empty().append(new Option('SELECCIONE UNA OPCIÓN', ''));
        $.ajax({
            type: 'GET',
            url: base_url + '/api/municipios/' + estadoMadre_id,
            dataType: 'json',
            data: { estadoMadre_id: estadoMadre_id },
            success: function(municipios) {
                if (municipios) {
                    $.each(municipios, function(key, value) {
                        select.append(new Option(value.munNombre, value.id));
                        (value.id == current_value) && select.val(value.id);
                    });
                    select.trigger('change');
                    select.trigger('click');
                }
            },
            error: function(Xhr, textMessage, errorMessage) {
                console.log(errorMessage);
            }
        });
    } //getMunicipios.
</script>