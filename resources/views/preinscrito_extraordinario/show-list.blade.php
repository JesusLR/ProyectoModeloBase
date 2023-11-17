@extends('layouts.dashboard')

@section('template_title')
    Preinscritos a Extraordinarios
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preinscrito_extraordinario')}}" class="breadcrumb">Lista de Preinscritos a Extraordinarios</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Preinscritos a Extraordinarios</h4>
    {{-- <a href="{{ url('/preinscrito_extraordinario/create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a> --}}
    <br>
    <br>
    <div class="row">
        <div class="col s12">
            <table id="tbl-preinscritos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Referencia ficha de pago</th>
                    <th>Fecha <br> Extraordinario</th>
                    <th>Clave de<br>Alumno</th>
                    <th>Nombre</th>
                    <th>Periodo</th>
                    <th>Año</th>
                    <th>Ubicación</th>
                    <th>Programa</th>
                    <th>Plan</th>
                    <th>Extraordinario</th>
                    <th>Materia</th>
                    <th>Docente</th>
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
        $('#tbl-preinscritos').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/preinscrito_extraordinario",
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
                {data: "folioFichaPago", name:"folioFichaPago"},
                {data: "extFecha", name:"extFecha"},
                {data: "aluClave", name:"aluClave"},
                {data: "aluNombre", name:"aluNombre"},
                {data: "extraordinario.periodo.perNumero", name:"extraordinario.periodo.perNumero"},
                {data: "extraordinario.periodo.perAnio", name:"extraordinario.periodo.perAnio"},
                {data: "ubiClave", name:"ubiClave"},
                {data: "progClave", name:"progClave"},
                {data: "materia.plan.planClave", name:"materia.plan.planClave"},
                {data: "extraordinario_id", name:"extraordinario_id"},
                {data: "matNombre", name:"matNombre"},
                {data: "empNombre", name:"empNombre"},
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
        * BOTÓN PARA INSCRIBIR PREINSCRITO.
        */
        $('#tbl-preinscritos').on('click', '.btn-inscribir', function() {
            let preinscrito_id = $(this).data('id');
            preinscrito_id && inscribir_preinscrito(preinscrito_id);
        });

        /*
        * BOTÓN PARA CANCELAR PREINSCRITO.
        */
        $('#tbl-preinscritos').on('click', '.btn-cancelar', function() {
            let preinscrito_id = $(this).data('id');
            preinscrito_id && cancelar_preinscrito(preinscrito_id);
        });





    });


    function inscribir_preinscrito(preinscrito_id) {
        swal({
            type: 'warning',
            title: 'inscribir alumno ?',
            text: 'Seguro que deseas proceder con la acción?',
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí',
            closeOnConfirm: false
        }, function(isConfirm){
            isConfirm && $('#inscribir_'+preinscrito_id).submit();
        });
    }//inscribir_preinscrito

    function cancelar_preinscrito(preinscrito_id) {
        swal({
            type: 'warning',
            title: 'Cancelar preinscripción ?',
            text: 'Seguro que deseas proceder con la acción?',
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí',
            closeOnConfirm: false
        }, function(isConfirm){
            isConfirm && $('#cancelar_'+preinscrito_id).submit();
        });
    }//cancelar_preinscrito







</script>


@endsection