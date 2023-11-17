@extends('layouts.dashboard')

@section('template_title')
    Idiomas empleados
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}      
@endsection

@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de empleados</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">EMPLEADOS</h4>
    <a href="{{ route('idiomas.idiomas_empleado.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    <div class="row">
        <div class="col s12">
            <table id="tbl-empleado-idiomas" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                <th>ID</th>
                    <th>Apellido paterno</th>
                    <th>Apellido materno</th>
                    <th>Nombre</th>
                    <th>Escuela</th>
                    <th>Puesto</th>
                    <th>Credencial</th>
                    <!-- <th>Nomina</th> -->
                    <th>Teléfono</th>
                    <th>Estatus</th>
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
                    <!-- <th></th> -->
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
        $('#tbl-empleado-idiomas').dataTable({
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
                'url': base_url+"/idiomas_empleado/list",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "empleado_id"},
                {data: "empApellido1"},
                {data: "empApellido2"},
                {data: "empNombre"},
                {data: "escClave",name:"escuelas.escClave"},
                {data: "puesNombre",name:"puestos.puesNombre"},
                {data: "empCredencial"},
                // {data: "empNomina"},
                {data: "empTelefono",name:"empTelefono"},
                {data: "empEstado"},
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