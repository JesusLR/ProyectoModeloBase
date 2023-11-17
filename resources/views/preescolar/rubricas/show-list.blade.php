@extends('layouts.dashboard')

@section('template_title')
    Preescolar rúbricas
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de rúbricas</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">RÚBRICAS</h4>
    {{--  @php use App\Models\User; @endphp  --}}
    {{--  @if (User::permiso("periodo") != "D" && User::permiso("periodo") != "P")  --}}
    <a href="{{ route('preescolar.preescolar_rubricas.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    {{--  @endif  --}}
    <div class="row">
        <div class="col s12">
            <table id="tbl-preescolar-rubricas" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Ubicación</th>
                    <!-- <th>Año</th> -->
                    <th>Programa</th>
                    <th>Tipo</th>
                    <th>Grado</th>
                    <th>Trimestre 1</th>
                    <th>Trimestre 2</th>
                    <th>Trimestre 3</th>
                    <th>Rubrica</th>
                    <th>Aplica</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th></th>
                    <!-- <th></th> -->
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
        $('#tbl-preescolar-rubricas').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 25,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/preescolar_rubricas/list",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "ubicacion"},
                // {data: "year"},
                {data: "programa"},
                {data: "tipo",name:"tipo"},
                {data: "grado",name:"grado"},
                {data: "trimestre1"},
                {data: "trimestre2"},
                {data: "trimestre3"},
                {data: "rubrica"},
                {data: "aplica"},
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
