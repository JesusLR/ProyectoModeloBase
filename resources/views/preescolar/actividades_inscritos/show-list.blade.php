@extends('layouts.dashboard')

@section('template_title')
    Preescolar actividades inscritos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('preescolar.preescolar_actividades_inscritos.index')}}" class="breadcrumb">Lista de actividades inscritos</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">ACTIVIDADES INSCRITOS</h4>
    <div class="row">
        <div class="col s12">
            <a href="{{ route('preescolar.preescolar_actividades_inscritos.create') }}" class="btn-large waves-effect  darken-3" type="button"> Inscribir en Actividad (Grupo)
                <i class="material-icons left">add</i>
            </a>
            {{--  <a href="{{ route('preescolar.preescolar_calificacion.create') }}" class="btn-large waves-effect  darken-3" type="button">Calificaciones
                <i class="material-icons left">add</i>
            </a>  --}}

            <table id="tbl-actividades-inscritos-preescolar" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Año Escolar</th>
                        <th>Período</th>
                        <th>Ubicación</th>
                        <th>Departamento</th>
                        <th>Escuela</th>
                        <th>Programa</th>
                        <th>Clave Grupo</th>
                        <th>Descripción</th>
                        <th>Clave Pago</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombre(s)</th>
                        <th>Estado Actividad</th>
                        <th>Fecha Baja</th>
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

@include('preescolar.actividades_inscritos.modaHistorialPagos-preescolar')

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    $(document).ready(function() {

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-actividades-inscritos-preescolar').dataTable({
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
                'url': base_url+"/preescolar_actividades_inscritos/list",
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
                {data: "periodo_pago"},
                {data: "periodo_numero"},
                {data: "ubicacion_nombre"},
                {data: "departamento_clave"},
                {data: "escuela_clave"},
                {data: "programa_clave"},
                {data: "actividad_grupo"},
                {data: "actividad_descrip"},
                {data: "alumno_clave"},
                {data: "alumno_apellido1"},
                {data: "alumno_apellido2"},
                {data: "alumno_nombre"},
                {data: "aeiEstado"},
                {data: "aeiFechaBaja"},
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

<script>
    $(document).on('click', '.confirm-baja', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
                title: "¿Estás seguro?",
                text: "Deseas realizar baja de este registro",
                type: "warning",
                confirmButtonText: "Si",
                confirmButtonColor: '#3085d6',
                cancelButtonText: "No",
                showCancelButton: true
            },
            function(isConfirm) {
                if(isConfirm) {
                    $('#delete_'+id).submit();
                }
            });
        });
    </script>


    <script type="text/javascript">
        function modalHistorialPagos(curso_id) {
            //MOSTRAR MODAL
            $('.modal').modal();
            //MOSTRAR GRUPOS
            if ($.fn.DataTable.isDataTable("#tbl-historial-pagos-preescolar")) {
                $('#tbl-historial-pagos-preescolar').DataTable().clear().destroy();
            }
    
            $.fn.dataTable.ext.errMode = 'throw';
            $('#tbl-historial-pagos-preescolar').dataTable({
                "destroy": true,
                "language":{"url":"api/lang/javascript/datatables"},
                "serverSide": true,
                "dom": '"top"i',
                "pageLength": 5,
                "stateSave": true,
                "bSort": false,
                "ajax": {
                    "type" : "GET",
                    'url': base_url + "/preescolar_curso/listHistorialPagos/" + curso_id,
                    beforeSend: function () {
                        $('.preloader-modal').fadeIn(200, function() {
                            $(this).append('<div id="preloader-modal"></div>');
                        });
                    },
                    complete: function (data) {
                        if (data.responseJSON.data) {
                            var obj = data.responseJSON.data[0];
                        }
    
                        $('.preloader-modal').fadeOut(200, function() {
                            $('#preloader-modal').remove();
                        });
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
                                    window.location.href = 'login';
                            });
                        }
                    }
                },
                "columns": [
                    {data: "concepto.conpNombre"},
                    {data: "pagImpPago"},
                    {data: "pagRefPago"},
                    {data: "pagFechaPago"},
                    {data: "pagAnioPer"},
                    {data: "pagComentario"},
                ],
                //Apply the search
                initComplete: function () {
                    var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))
    
    
                    var index = 0
                    this.api().columns().every(function () {
                        var column = this;
                        var columnClass = column.footer().className;
                        if (columnClass != 'non_searchable') {
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
        }
    
        function modalHistorialPagosAluClave(aluClave) {
            //MOSTRAR MODAL
            $('.modal').modal();
            //MOSTRAR GRUPOS
            if ($.fn.DataTable.isDataTable("#tbl-historial-pagos-alu-preescolar")) {
                $('#tbl-historial-pagos-alu-preescolar').DataTable().clear().destroy();
            }
    
            $.fn.dataTable.ext.errMode = 'throw';
            $('#tbl-historial-pagos-alu-preescolar').dataTable({
                "destroy": true,
                "language":{"url":"api/lang/javascript/datatables"},
                "serverSide": true,
                "dom": '"top"i',
                "pageLength": 5,
                "stateSave": true,
                "bSort": false,
                "ajax": {
                    "type" : "GET",
                    'url': base_url + "/preescolar_alumno/listHistorialPagosAluclave/" + aluClave,
                    beforeSend: function () {
                        $('.preloader-modal').fadeIn(200, function() {
                            $(this).append('<div id="preloader-modal"></div>');
                        });
                    },
                    complete: function (data) {
                        if (data.responseJSON.data) {
                            var obj = data.responseJSON.data[0];
    
                            console.log(data.responseJSON);
    
                            // $(".modal-titulo-periodo").html(obj.periodo.perNumero)
                            // $(".modal-periodo-anio").html(obj.periodo.perAnio)
                        }
    
                        $('.preloader-modal').fadeOut(200, function() {
                            $('#preloader-modal').remove();
                        });
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
                "columns": [
                    {data: "conpNombre"},
                    {data: "pagImpPago"},
                    {data: "pagRefPago"},
                    {data: "pagFechaPago"},
                    {data: "pagAnioPer"},
                    {data: "pagComentario"},
                ],
                //Apply the search
                initComplete: function () {
                    var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))
    
    
                    var index = 0
                    this.api().columns().every(function () {
                        var column = this;
                        var columnClass = column.footer().className;
                        if (columnClass != 'non_searchable') {
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
        }
    
        $(document).on("click", ".btn-modal-historial-pagos-preescolar", function (e) {
            e.preventDefault()
    
            var curso_id = $(this).data("curso-id")
            var nombres = $(this).data("nombres")
            var aluclave = $(this).data("aluclave")
            console.log("aluclave")
            console.log(aluclave)
    
            console.log(nombres)
            $('.modalNombres').html(nombres)
    
            modalHistorialPagos(curso_id)
            modalHistorialPagosAluClave(aluclave)
    
        })
    </script>


    <script type="text/javascript">
        $(document).on("click", ".btn-modal-ficha-pago", function(e) {
            e.preventDefault()
    
            var curso_id = $(this).data("curso-id");
            var pedirConfirmacion = $(this).data("pedir-confirmacion");
            if(pedirConfirmacion == 'SI') {
                swal({
                    title: "Validar Pago Ceneval",
                    text: "¿El alumno ya pagó su examen Ceneval?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#0277bd',
                    confirmButtonText: 'SI',
                    cancelButtonText: "NO",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {
    
                    if (isConfirm) {
                        window.open("preescolar_curso/crearReferencia/" + curso_id + "/" + "si", "_blank");
                    } else {
                        window.open("preescolar_curso/crearReferencia/" + curso_id + "/" + "no", "_blank");
                    }
                    swal.close()
                });
            } else {
                window.open("preescolar_curso/crearReferencia/" + curso_id + "/" + "no", "_blank");
            }
    
    
        });
    
    
    </script>
    
    
    <script type="text/javascript">
        $(document).on("click", ".btn-modal-ficha-pago-hsbc", function(e) {
            e.preventDefault()
    
            var curso_id = $(this).data("curso-id");
            var pedirConfirmacion = $(this).data("pedir-confirmacion");
            if(pedirConfirmacion == 'SI') {
                swal({
                    title: "Validar Pago Ceneval",
                    text: "¿El alumno ya pagó su examen Ceneval?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#0277bd',
                    confirmButtonText: 'SI',
                    cancelButtonText: "NO",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {
    
                    if (isConfirm) {
                        window.open("preescolar_curso/crearReferenciaHSBC/" + curso_id + "/" + "si", "_blank");
                    } else {
                        window.open("preescolar_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank");
                    }
                    swal.close()
                });
            } else {
                window.open("preescolar_curso/crearReferenciaHSBC/" + curso_id + "/" + "no", "_blank");
            }
    
    
        })
    </script>
@endsection
