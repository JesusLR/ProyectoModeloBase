@extends('layouts.dashboard')

@section('template_title')
    Grupos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('grupo')}}" class="breadcrumb">Lista de grupos</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">GRUPOS</h4>
    @php use App\Models\User; @endphp
    @if (User::permiso("grupo") != "D" && User::permiso("grupo") != "P")
    <a href="{{ url('/grupo/create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    @endif
    <div class="row">
        <div class="col s12">
            <table id="tbl-grupo" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Ubicación</th>
                    <th>Periodo</th>
                    <th>Año</th>
                    <th>Programa</th>
                    <th>Plan</th>
                    <th>Clave Materia</th>
                    <th>Materia</th>
                    <th>Nombre Optativa</th>
                    <th>Fecha Ordinario</th>
                    <th>Hora Ordinario</th>
                    <th>Num. Emp.</th>
                    <th>Nombre(s) Maestro</th>
                    <th>A. paterno</th>
                    <th>A. materno</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Turno</th>
                    <th>Estado actual</th>
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

@include('modales.modalGrupoEstado')




@endsection

@section('footer_scripts')

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}

<script type="text/javascript">

</script>
<script type="text/javascript">
    $(document).ready(function() {

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-grupo').dataTable({
            "language":{"url":base_url + "/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 25,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url + "/api/grupo",
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
                {data: "ubiClave",name:"ubicacion.ubiClave"},
                {data: "perNumero",name:"periodos.perNumero"},
                {data: "perAnio",name:"periodos.perAnio"},
                {data: "progClave",name:"programas.progClave"},
                {data: "planClave",name:"planes.planClave"},
                {data: "matClave",name:"materias.matClave"},
                {data: "matNombre",name:"materias.matNombre"},
                {data: "optNombre",name:"optativas.optNombre"},
                {data: "gpoFechaExamenOrdinario"},
                {data: "gpoHoraExamenOrdinario"},
                {data: "empleado_id"},
                {data: "nombre"},
                {data: "apellido1"},
                {data: "apellido2"},
                {data: "gpoSemestre"},
                {data: "gpoClave"},
                {data: "gpoTurno"},
                {data: "estado_act"},
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

<script type="text/javascript">
    $(document).ready(function() {
        $('.modal').modal();

        $(document).on("click", ".btn-estado-grupo", function (e) {
            e.preventDefault()
            var grupo_id = $(this).data("grupo-id");
            $(".modalGrupoId").val(grupo_id);
            var estado = '';
            $.get(base_url+'/api/grupo/infoEstado/'+grupo_id, function(res,sta) {
                
                $(".modalMateriaClave").html(res.matClave)
                $(".modalMateriaNombre").html(res.matNombre)
                $(".modalProgClave").html(res.progClave)
                $(".modalProgNombre").html(res.progNombre)
                $(".modalPerNumero").html(res.perNumero)
                $(".modalPerAnio").html(res.perAnio)
                if (res.estado_act == 'A') {
                estado = 'Abierto';
                }
                if (res.estado_act == 'B') {
                estado = 'Abierto con calificación';
                }
                if (res.estado_act == 'C') {
                estado = 'Cerrado';
                }
                $(".modalEstado").html(estado)
            });
            $('.modal').modal();
        })
     
    })
</script>
@endsection