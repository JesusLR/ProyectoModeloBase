@extends('layouts.dashboard')

@section('template_title')
    Secundaria porcentajes
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}      
@endsection

@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de porcentajes</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">PORCENTAJES</h4>
    @php use App\Models\User; @endphp
    <a href="{{ route('secundaria.secundaria_porcentaje.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    <div class="row">
        <div class="col s12">
            <table id="tbl-porcentaje-secundaria" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Ubicación</th>
                    <th>Año</th>
                    <th>% Sep</th>
                    <th>% Oct</th>
                    <th>% Nov</th>
                    <th>% Total per 1</th>
                    {{--  <th>% Dic</th>  --}}
                    <th>% Ene</th>
                    <th>% Feb</th>
                    <th>% Mar</th>
                    <th>% Total per 2</th>
                    <th>% Abr</th>
                    <th>% May</th>
                    <th>% Jun</th>
                    <th>% Total per 3</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    {{--  <th></th>  --}}
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
        $('#tbl-porcentaje-secundaria').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "order": [
                [2, 'asc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/secundaria_porcentaje/list",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "ubicacion"},
                {data: "anio"},
                {data:  "porc_septiembre", name: "porc_septiembre"},
                {data:  "porc_octubre", name: "porc_octubre"},
                {data:  "porc_noviembre", name: "porc_noviembre"},
                {data:  "porc_periodo1", name: "porc_periodo1"},
                //{data:  "porc_diciembre", name: "porc_diciembre"},
                {data:  "porc_enero", name: "porc_enero"},
                {data:  "porc_febrero", name: "porc_febrero"},
                {data:  "porc_marzo", name: "porc_marzo"},
                {data:  "porc_periodo2", name: "porc_periodo2"},
                {data:  "porc_abril", name: "porc_abril"},
                {data:  "porc_mayo", name: "porc_mayo"},
                {data:  "porc_junio", name: "porc_junio"},
                {data:  "porc_periodo3", name: "porc_periodo3"},
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