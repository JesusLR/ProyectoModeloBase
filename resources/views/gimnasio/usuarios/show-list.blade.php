@extends('layouts.dashboard')

@section('template_title')
    Gimnasio
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('gimnasio_usuario')}}" class="breadcrumb">Lista de Usuarios de Gimnasio</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Usuarios de Gimnasio</h4>
    <a href="{{ url('/gimnasio_usuario/create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    <div class="row">
        <div class="col s12">
            <table id="table-gimnasio-usuarios" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Numero</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Cuota</th>
                    <th>Vigente</th>
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

    {{-- MODAL historial pagos --}}
    <div id="modalHistorialPagosAlu" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="col s12 m6 l6">
                    <h4>Historial de pagos</h4>
                    <span class="modalAluClave" style="font-weight: bold;"></span>
                    <span class="modalNombres"></span>
                    <p>
                        Pagos recibidos hasta: {{$registroUltimoPago}}
                    </p>
                </div>
                <div class="col s12 m6 l6">
                    <p><b>Generar reporte:</b></p>
                    {{-- ambos forms apuntan a HistorialPagosAlumnoController --}}
                    <form action="{{url('reporte/historial_pagos_alumno/imprimir')}}" method="POST" style="display:inline;" target="_blank">
                        @csrf
                        <input type="hidden" name="aluClave" value="" class="modal_aluClave" required>
                        <input type="hidden" name="formatoImpresion" value="PDF">
                        <button type="submit" class="btn waves-effect red darken-3" style="width:100px">PDF</button>
                    </form>

                    {{-- <form action="{{url('reporte/historial_pagos_alumno/imprimir')}}" method="POST" style="display:inline;" target="_blank">
                        @csrf
                        <input type="hidden" name="aluClave" value="" class="modal_aluClave" required>
                        <input type="hidden" name="formatoImpresion" value="EXCEL">
                        <button type="submit" class="btn waves-effect green darken-4" style="width:100px">Excel</button>
                    </form>  --}}

                </div>
            </div>
            <table id="tbl-historial-pagos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Curso</th>
                    <th>Concepto de pago</th>
                    <th>Importe</th>
                    <th>Referencia de pago</th>
                    <th>Fecha de pago</th>
                    <th>Comentario del pago</th>
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
                    </tr>
                </tfoot>
            </table>

            <div class="preloader-modal">
                <div id="preloader-modal"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-close waves-effect waves-green btn-flat">Cerrar</button>
        </div>
    </div>


@endsection

@section('footer_scripts')

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    function modalHistorialPagos(aluClave) {
        //MOSTRAR MODAL
        $('.modal').modal();
        if ($.fn.DataTable.isDataTable("#tbl-historial-pagos")) {
            $('#tbl-historial-pagos').DataTable().clear().destroy();
        }

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-historial-pagos').dataTable({
            "destroy": true,
            "language":{"url":"api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 12,
            "bSort": false,
            "stateSave": false,
            "ajax": {
                "type" : "GET",
                'url': base_url + "/api/gimnasio_alumno/listHistorialPagosAluclave/" + aluClave,
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
                {data: "pagAnioPer"},
                {data: "conpNombre", name:"conpNombre"},
                {data: "pagImpPago", name:"pagImpPago"},
                {data: "pagRefPago"},
                {data: "pagFechaPago", name:"pagFechaPago"},
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
    $(document).on("click", ".btn-modal-historial-pagos", function (e) {
        e.preventDefault()
        var aluClave = $(this).data("aluclave");
        var nombres = $(this).data("nombres");
        var alumno_id = $(this).data('alumno-id');

        $('.modalNombres').html(nombres);
        $('.modalAluClave').html(aluClave);
        $('.modal_aluClave').val(aluClave);
        modalHistorialPagos(aluClave)
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#table-gimnasio-usuarios').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/gimnasio_usuario/list",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
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
                {data: "id"},
                {data: "gimApellidoPaterno"},
                {data: "gimApellidoMaterno"},
                {data: "gimNombre"},
                {data: "gimTipo"},
                {data: "tipo.tugImporte"},
                {data: "tipo.tugVigente"},
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



        /*
        * BOTÓN PARA Generar ficha de pago.
        */
        $('#table-gimnasio-usuarios').on('click', '.btn-generar-ficha', function() {
            var usuariogim_id = $(this).data('id');
            usuariogim_id && generar_ficha(usuariogim_id);
        });

        /*
        * BOTÓN PARA Generar ficha de pago HSBC.
        */
        $('#table-gimnasio-usuarios').on('click', '.btn-generar-ficha_hsbc', function() {
            var usuariogim_id = $(this).data('id');
            usuariogim_id && generar_ficha_hsbc(usuariogim_id);
        });

    });


    function generar_ficha(usuariogim_id) {
        swal({
            type: 'warning',
            title: 'Generar ficha ?',
            text: 'Desea generar la ficha de pago para el usuario #' + usuariogim_id,
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí',
            closeOnConfirm: true
        }, function(){
            $('#generar_ficha_' + usuariogim_id).submit();
        });
    }//borrar_responsable

    function generar_ficha_hsbc(usuariogim_id) {
        swal({
            type: 'warning',
            title: 'Generar ficha ?',
            text: 'Desea generar la ficha de pago para el usuario #' + usuariogim_id,
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí',
            closeOnConfirm: true
        }, function(){
            $('#generar_ficha_hsbc_' + usuariogim_id).submit();
        });
    }//borrar_responsable







</script>


@endsection