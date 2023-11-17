@extends('layouts.dashboard')

@section('template_title')
    Primaria materias asignaturas
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de materias asignaturas</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">MATERIAS ASIGNATURAS</h4>
    {{--  @php use App\Models\User; @endphp  --}}
    {{--  @if (User::permiso("materia") != "D" && User::permiso("materia") != "P")  --}}
    <a href="{{ route('primaria.primaria_materias_asignaturas.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    {{--  @endif  --}}
    <div class="row">
        <div class="col s12">
            <table id="tbl-primaria-materia-asignaturas" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Ubicacion</th>
                    <th>Departamento</th>
                    <th>Escuela</th>
                    <th>Programa</th>
                    <th>Materia</th>
                    <th>Plan</th>
                    <th>Año</th>
                    <th>Clave Asignatura</th>
                    <th>Nombre Asignatura</th>
                    <th>Porcentaje</th>
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
        $('#tbl-primaria-materia-asignaturas').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            "order": [
                [6, 'asc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/primaria_materias_asignaturas/list",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "ubicacion_clave"},
                {data: "departamento"},
                {data: "escuela"},
                {data: "programa"},
                {data: "materia"},
                {data: "plan"},
                {data: "anio"},
                {data: "clave_asignatura"},
                {data: "nombre_asignatura"},
                {data: "porcentaje"},
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