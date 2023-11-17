@extends('layouts.dashboard')

@section('template_title')
    Primaria materias
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('primaria_materia')}}" class="breadcrumb">Lista de materias</a>
    <label class="breadcrumb">Lista de materias ACD</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">MATERIA: {{$materias_acd->matClave.'-'.$materias_acd->matNombre}}</h4>
    <p><b>Semestre: </b>{{$materias_acd->matSemestre}}</p>
    <p><b>Ubicación: </b>{{$materias_acd->ubiNombre}}</p>
    <p><b>Departamento: </b>{{$materias_acd->depNombre}}</p>
    <p><b>Plan: </b>{{$materias_acd->planClave}}</p>
    @php use App\Models\User; @endphp
    <a href="{{ route('primaria.primaria_materia_acd.create_acd', ['materia_id' => $materias_acd->primaria_materia_id]) }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    <div class="row">
        <div class="col s12">
            <table id="tbl-materia-primaria-acd" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Año</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
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
        $('#tbl-materia-primaria-acd').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            "order": [
                [2, 'asc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/primaria_materia/listACD/{{$materia_id}}/{{$plan_id}}",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "anio"},
                {data: "materiaComplementaria"},                
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