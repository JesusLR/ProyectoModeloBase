@extends('layouts.dashboard')

@section('template_title')
    Preescolar actividades
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('preescolar.preescolar_actividades.index')}}" class="breadcrumb">Lista de actividades</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">ACTIVIDADES</h4>
    <div class="row">
        <div class="col s12">
            <a href="{{ route('preescolar.preescolar_actividades.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
                <i class="material-icons left">add</i>
            </a>
            {{--  <a href="{{ route('preescolar.preescolar_calificacion.create') }}" class="btn-large waves-effect  darken-3" type="button">Calificaciones
                <i class="material-icons left">add</i>
            </a>  --}}

            <table id="tbl-actividades-preescolar" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Año Escolar</th>
                        <th>Período</th>
                        <th>Ubicación</th>
                        <th>Departamento</th>
                        <th>Escuela</th>
                        <th>Programa</th>
                        <th>Clave Grupo</th>
                        <th>Descripción</th>
                        <th>Instructor</th>
                        <th>Importe Pagos</th>
                        <th>Cantidad Pagos</th>
                        <th>Estado</th>
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

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    $(document).ready(function() {

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-actividades-preescolar').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "stateSave": true,
            "pageLength": 15,
            "order": [
                [1, 'desc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/preescolar_actividades/list",
                beforeSend: function () {
                    $('.preloader').fadeIn(200, function(){$(this).append('<div id="preloader"></div>');});
                },
                complete: function () {
                    $('.preloader').fadeOut(200, function(){$('#preloader').remove();});
                }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if (errorThrown === "Unauthorized") {
                        swal({
                            title: "Ups...",
                            text: "La sesion ha expirado",
                            type: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            showCancelButton: false
                        }, function(isConfirm) {
                            if (isConfirm) {
                                window.location.href = 'login';
                            } else {
                                window.location.href = 'login';
                            }
                        });
                    }
                }
            },
            "columns":[
                {data: "periodo_pago"},
                {data: "periodo_numero"},
                {data: "ubicacion_nombre"},
                {data: "departamento_clave"},
                {data: "escuela_clave"},
                {data: "programa_clave"},
                {data: "actGrupo", name: "actGrupo"},
                {data: "actDescripcion", name: "actDescripcion"},
                {data: "nombreCompletoDocente"},
                {data: "actImporte", name: "actImporte"},
                {data: "actNumeroPagos", name: "actNumeroPagos"},
                {data: "actEstado", name: "actEstado"},
                {data: "action"}
            ],
            //Apply the search
            initComplete: function () {

                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))

                var index = 0
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if(columnClass != 'non_searchable'){
                        var input = document.createElement("input");


                        var columnDataOld = searchFill.columns[index].search.search
                        $(input).attr("placeholder", "Buscar").addClass("busquedas").val(columnDataOld);


                        $(input).appendTo($(column.footer()).empty())
                            .on('change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                    }

                    index ++
                });
            },

            stateSaveCallback: function(settings,data) {
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                return JSON.parse(localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            }
        });
    });
</script>


@endsection
