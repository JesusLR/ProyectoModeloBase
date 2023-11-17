@extends('layouts.dashboard')

@section('template_title')
    Bachiller calendario examen
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de calendario de examen</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">CALENDARIO DE EXAMEN</h4>
    <a href="{{ route('bachiller.bachiller_calendario_examen.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <div class="row">
        <div class="col s12">
            <table id="tbl-calendario-examen" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Ubicacion</th>
                    <th>Año</th>
                    <th>Período</th>
                    <th>Plan</th>
                    <th>Inicio Parcial 1</th>
                    <th>Fin Parcial 1</th>
                    <th>Inicio Parcial 2</th>
                    <th>Fin Parcial 2</th>
                    <th>Inicio Parcial 3</th>
                    <th>Fin Parcial 3</th>
                    <th>Inicio Ordinario</th>
                    <th>Fin Ordinario</th>
                    <th>Fecha Publicación Boleta</th>
                    {{--  <th>Inicio Extraordinario</th>  --}}
                    {{--  <th>Fin Extraordinario</th>  --}}
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
                    <th></th>
                    {{--  <th></th>  --}}
                    {{--  <th></th>  --}}
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
        $('#tbl-calendario-examen').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            "order": [
                [3, 'asc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/bachiller_calendario_examen/list",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "ubicacion"},
                {data: "anio_periodo"},
                {data: "numero_periodo"},
                {data: "plan"},
                {data: "calexInicioParcial1"},
                {data: "calexFinParcial1"},
                {data: "calexInicioParcial2"},
                {data: "calexFinParcial2"},
                {data: "calexInicioParcial3"},
                {data: "calexFinParcial3"},
                {data: "calexInicioOrdinario"},
                {data: "calexFinOrdinario"},
                {data: "calBoletaPublicacion"},
                //{data: "calexInicioExtraordinario"},
                //{data: "calexFinExtraordinario"},
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