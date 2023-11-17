@extends('layouts.dashboard')

@section('template_title')
    Bachiller grupos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_grupo_uady.index')}}" class="breadcrumb">Lista de grupos</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">GRUPOS</h4>
    <div class="row">
        <div class="col s12">
            <a href="{{ route('bachiller.bachiller_grupo_uady.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
                <i class="material-icons left">add</i>
            </a>
            {{--  <a href="{{ route('bachiller.bachiller_calificacion.create') }}" class="btn-large waves-effect  darken-3" type="button">Calificaciones
                <i class="material-icons left">add</i>
            </a>  --}}

            <table id="tbl-grupo-bachiller" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Ubicación</th>
                        <th>Año Escolar</th>
                        <th>Período</th>
                        <th>Plan</th>
                        <th>Programa</th>
                        <th>Clave-Materia</th>
                        <th>Materia</th>
                        <th>Complementaria</th>
                        <th>Nombre(s) Maestro</th>
                        <th>Apellido paterno</th>
                        <th>Apellido materno</th>
                        <th>Grado</th>
                        <th>Grupo</th>
                        <th>Turno</th>    
                        <th>Estado</th>                    
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

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-grupo-bachiller').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "stateSave": true,
            "pageLength": 15,
            "order": [
                [1, 'desc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/bachiller_grupo_uady/list",
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
                {data: "ubicacion"},
                {data: "peranio"},
                {data: "periodo_numero"},
                {data: "planclave"},
                {data: "programa"},
                {data: "clave"},
                {data: "matName"},
                {data: "materia_complementaria"},
                {data: "nombre"},
                {data: "apellido1"},
                {data: "apellido2"},
                {data: "gpoGrado", name: "gpoGrado"},
                {data: "gpoClave", name: "gpoClave"},
                {data: "gpoTurno", name: "gpoTurno"},         
                {data: "estado_grupo"},        
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

@include('bachiller.grupos_merida.modalEstado')


<script type="text/javascript">
    $(document).ready(function() {
        $('.modal').modal();

        $(document).on("click", ".btn-estado-grupo", function (e) {
            e.preventDefault()
            var grupo_id = $(this).data("grupo-id");

            $(".modalGrupoId").val(grupo_id);
            var estado = '';
            $.get(base_url+'/api/bachiller_grupo_uady/infoEstado/'+grupo_id, function(res,sta) {
                
                $(".modalMateriaClave").html(res.matClave)
                $(".modalMateriaNombre").html(res.matNombre)
                $(".modalProgClave").html(res.progClave)
                $(".modalProgNombre").html(res.progNombre)
                $(".modalPerNumero").html(res.perNumero)
                $(".modalPerAnio").html(res.perAnio)

                if(res.gpoMatComplementaria != null ){
                    $(".modalGpoMatComple").html(` - ${res.gpoMatComplementaria}`)
                }else{
                    $(".modalGpoMatComple").html("")
                }
               

                
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

<script>
    $(document).on('click', '.confirm-ocultar', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
                title: "¿Estás seguro?",
                text: "Deseas ocultar este grupo",
                type: "warning",
                confirmButtonText: "Si",
                confirmButtonColor: '#3085d6',
                cancelButtonText: "No",
                showCancelButton: true
            },
            function(isConfirm) {
                if(isConfirm) {
                    $('#ocultar_'+id).submit();
                }
            });
        });
    </script>

@endsection
