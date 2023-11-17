@extends('layouts.dashboard')

@section('template_title')
    Consulta de fichas
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('pagos/consulta_fichas')}}" class="breadcrumb">Lista de Fichas</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Consulta de fichas</h4>
    <div class="row">
        <div class="col s12">
            <table id="tbl-fichas" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Clave Pago</th>
                    <th>Alumno</th>
                    <th>Per</th>
                    <th>Anio</th>
                    <th>Grado</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Conc.</th>
                    <th>Referencia 1</th>
                    <th>Venc.</th>
                    <th>Imp. 1</th>
                    <th>Edo.</th>
                    <th>Usuario</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>{{-- fchFechaImpr --}}
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th> {{-- fchFechaVenc1 --}}
                    <th></th>
                    <th></th>
                    <th></th>
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
        $('#tbl-fichas').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/consulta_fichas",
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
                {data: "fchClaveAlu", name:"fchClaveAlu"},
                {data: "nombreAlumno", name:"nombreAlumno"},
                {data: "fchNumPer", name: "fchNumPer"},
                {data: "fchAnioPer", name: "fchAnioPer"},
                {data: "grado", name: "grado"},
                {data: "fchFechaImpr", name: "fchFechaImpr"},
                {data: "fchTipo", name:"fchTipo"},
                {data: "fchConc", name:"fchConc"},
                {data: "fhcRef1", name: "fhcRef1"},
                {data: "fchFechaVenc1", name:"fchFechaVenc1"},
                {data: "fhcImp1", name:"fhcImp1"},
                {data: "fchEstado", name:"fchEstado"},
                {data: "username", name:"username"},
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
        * BOTÓN PARA ELIMINAR CALENDARIO.
        */
        $('#tbl-responsables').on('click', '.btn-borrar', function() {
            var responsable_id = $(this).data('id');
            responsable_id && borrar_responsable(responsable_id);
        });





    });


    function borrar_responsable(responsable_id) {
        swal({
            type: 'warning',
            title: 'Borrar registro #'+responsable_id,
            text: 'Seguro que deseas eliminar este registro?',
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí',
            closeOnConfirm: false
        }, function(){
            $('#delete_'+responsable_id).submit();
        });
    }//borrar_responsable







</script>


@endsection