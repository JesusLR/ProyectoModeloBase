@extends('layouts.dashboard')

@section('template_title')
    Bachiller evidencias
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de evidencias</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">EVIDENCIAS</h4>
    <a href="{{ route('bachiller.bachiller_evidencias.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    @if (auth()->user()->departamento_sistemas == 1)
    <a href="{{ route('bachiller.bachiller_evidencias.copiar') }}" class="btn-large waves-effect  darken-3" type="button">Copiar
        <i class="material-icons left">content_copy</i>
    </a>
    @endif

    @if (auth()->user()->campus_cme == 1)
    <a href="{{ route('bachiller.bachiller_evidencias.copiarPorSemestre') }}" class="btn-large waves-effect  darken-3" type="button">Copiar por semestre
        <i class="material-icons left">content_copy</i>
    </a>
    @endif
    
    <div class="row">
        <div class="col s12">
            <table id="tbl-materia-bachiller" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Ubicacion</th>
                    <th>Año</th>
                    <th>Período</th>
                    <th>Plan</th>
                    <th>Clave Materia</th>
                    <th>Nombre Materia</th>
                    <th>Materia complementaria</th>
                    <th>Grado</th>
                    <th>Número Evidencia</th>
                    <th>Descripción Evidencia</th>
                    <th>Fecha Entrega</th>
                    <th>Puntos Evidencia</th>
                    <th>Tipo Evidencia</th>
                    <th>Faltas Evidencias</th>
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
        $('#tbl-materia-bachiller').dataTable({
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
                'url': base_url+"/bachiller_evidencias/list",
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
                {data: "clave_materia"},
                {data: "nombre_materia"},
                {data: "materia_acd"},
                {data: "grado_materia"},
                {data: "eviNumero"},
                {data: "eviDescripcion"},
                {data: "fecha_entrega"},
                {data: "eviPuntos"},
                {data: "eviTipo"},
                {data: "eviFaltas"},
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