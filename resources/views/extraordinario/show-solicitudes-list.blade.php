@extends('layouts.dashboard')

@section('template_title')
    Solicitud extraordinario
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('extraordinario')}}" class="breadcrumb">Lista de extraordinarios</a>
    <label class="breadcrumb">Lista de solicitudes</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">SOLICITUDES EXTRAORDINARIOS</h4>
    @php use App\Models\User; @endphp
    @if (User::permiso("solicitud_extraordinario") != "D" && User::permiso("solicitud_extraordinario") != "P")
    <a href="{{ url('create/solicitud') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    @endif
    <div class="row">
        <div class="col s12">
            <table id="tbl-extra-solic" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Folio</th>
                    <th>Ubicación</th>
                    <th>Programa</th>
                    <th>Plan</th>
                    <th>Periodo</th>
                    <th>Año</th>
                    <th>Clave materia</th>
                    <th>Materia</th>
                    <th>Optativa</th>
                    <th>Clave Pago</th>
                    <th>Alumno</th>
                    <th>Fecha</th>
                    <th>Calificación</th>
                    <th>Estado</th>
                    <th>Registro</th>
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
        $('#tbl-extra-solic').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "stateSave": true,
            "dom": '"top"i',
            "pageLength": 5,
            "order": [
                [0, 'desc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/solicitud/extraordinario",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "inscritoExtraordinario_id",name: "inscritosextraordinarios.id"},
                {data: "extraordinario_id",name:"extraordinarios.id"},
                {data: "ubiClave",name:"ubicacion.ubiClave"},
                {data: "progClave",name:"programas.progClave"},
                {data: "planClave",name:"planes.planClave"},
                {data: "perNumero",name:"periodos.perNumero"},
                {data: "perAnio",name:"periodos.perAnio"},
                {data: "matClave",name:"materias.matClave"},
                {data: "matNombre",name:"materias.matNombre"},
                {data: "optNombre",name:"optativas.matNombre"},
                {data: "aluClave",name:"alumnos.aluClave"},
                {data: "nombreCompleto"},
                {data: "extFecha", name:"extraordinarios.extFecha"},
                {data: "iexCalificacion"},
                {data: "iexEstado"},
                {data: "iexModoRegistro", name:"inscritosextraordinarios.iexModoRegistro"},
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