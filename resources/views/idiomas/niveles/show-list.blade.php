@extends('layouts.dashboard')

@section('template_title')
    Idiomas niveles
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}      
@endsection

@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de niveles</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">NIVELES</h4>
    
    <a href="{{ route('idiomas.idiomas_nivel.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    
    <div class="row">
        <div class="col s12">
            <table id="tbl-nivel-idiomas" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Programa</th>
                    <th>Plan</th>
                    <th>Nivel</th>
                    <th>Descripción</th>
                    <th>Reporte 1</th>
                    <th>Reporte 2</th>
                    <th>Ex.Mid.Term.</th>
                    <th>Proyecto 1</th>
                    <th>Reporte 3</th>
                    <th>Reporte 4</th>
                    <th>Final Ex.</th>
                    <th>Proyecto 2</th>
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
        $('#tbl-nivel-idiomas').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            // "order": [
            //     [2, 'asc']
            // ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/idiomas_nivel/list",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "progClave", name: 'programas.progClave'},
                {data: "planClave", name: 'planes.planClave'},
                {data: "nivGrado"},
                {data: "nivDescripcion"},
                {data: "nivPorcentajeReporte1"},
                {data: "nivPorcentajeReporte2"},
                {data: "nivPorcentajeMidterm"},
                {data: "nivPorcentajeProyecto1"},
                {data: "nivPorcentajeReporte3"},
                {data: "nivPorcentajeReporte4"},
                {data: "nivPorcentajeFinal"},
                {data: "nivPorcentajeProyecto2"},
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