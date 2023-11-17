@extends('layouts.dashboard')

@section('template_title')
    Bachiller pago certificado
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), [
        'type' => 'text/css',
        'rel' => 'stylesheet',
    ]) !!}
@endsection

@section('breadcrumbs')
    <a href="{{ url('bachiller_curso') }}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de certificados pagados</label>
@endsection

@section('content')
    <div id="table-datatables">
        <h4 class="header">PAGO DE CERTIFICADO</h4>
        <a href="{{ route('bachiller.bachiller_pago_certificado.create') }}" class="btn-large waves-effect  darken-3"
            type="button">Agregar
            <i class="material-icons left">add</i>
        </a>


        <div class="row">
            <div class="col s12">
                <table id="tbl-pago-certificado" class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Ubicacion</th>
                            <th>Año</th>
                            <th>Período</th>
                            <th>Clave Pago</th>
                            <th>Primer Apellido</th>
                            <th>Segundo Apellido</th>
                            <th>Nombre(s)</th>
                            <th>Fecha Pago</th>
                            <th>Monto Pago</th>
                            <th>Acciones</th>
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
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="non_searchable"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="preloader">
        <div id="preloader"></div>
    </div>
@endsection

@section('footer_scripts')
    {!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), ['type' => 'text/javascript']) !!}
    {!! HTML::script(asset('/js/scripts/data-tables.js'), ['type' => 'text/javascript']) !!}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl-pago-certificado').dataTable({
                "language": {
                    "url": base_url + "/api/lang/javascript/datatables"
                },
                "serverSide": true,
                "dom": '"top"i',
                "pageLength": 15,
                "stateSave": true,
                "order": [
                    [3, 'asc']
                ],
                "ajax": {
                    "type": "GET",
                    'url': base_url + "/bachiller_pago_certificado/list",
                    beforeSend: function() {
                        $('.preloader').fadeIn(200, function() {
                            $(this).append('<div id="preloader"></div>');;
                        });
                    },
                    complete: function() {
                        $('.preloader').fadeOut(200, function() {
                            $('#preloader').remove();
                        });
                    },
                },
                "columns": [{
                        data: "ubicacion"
                    },
                    {
                        data: "anio_periodo"
                    },
                    {
                        data: "numero_periodo"
                    },
                    {
                        data: "clave_pago"
                    },
                    {
                        data: "apellido1"
                    },
                    {
                        data: "apellido2"
                    },
                    {
                        data: "nombre_alumno"
                    },
                    {
                        data: "date_pago"
                    },
                    {
                        data: "monto_pago"
                    },
                    {
                        data: "action"
                    }
                ],
                //Apply the search
                initComplete: function() {
                    var searchFill = JSON.parse(localStorage.getItem('DataTables_' + this.api().context[
                        0].sInstance))

                    var index = 0
                    this.api().columns().every(function() {
                        var column = this;
                        var columnClass = column.footer().className;
                        if (columnClass != 'non_searchable') {
                            var input = document.createElement("input");


                            var columnDataOld = searchFill.columns[index].search.search
                            $(input).attr("placeholder", "Buscar").addClass("busquedas").val(
                                columnDataOld);


                            $(input).appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                        }

                        index++
                    });
                },
                stateSaveCallback: function(settings, data) {
                    localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
                },
                stateLoadCallback: function(settings) {
                    return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
                }
            });
        });
    </script>
@endsection
