@extends('layouts.dashboard')

@section('template_title')
    Historial de Becas
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('becas_historial')}}" class="breadcrumb">Lista de Cursos</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Historial de Becas</h4>
    {{-- <a href="{{ url('becas_historial/create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a> --}}
    <br>
    <br>
    <div class="row">
        <div class="col s12">
            <table id="tbl-cursos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Ubicacion</th>
                    <th>Departamento</th>
                    <th>Periodo</th>
                    <th>Año</th>
                    <th>Programa</th>
                    <th>Plan</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Clave pago</th>
                    <th>Nombre</th>
                    <th>Acción</th>
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
        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-cursos').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/becas_historial/cursos",
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
                {data: "ubiClave"},
                {data: "depClave"},
                {data: "perNumero"},
                {data: "perAnio"},
                {data: "progClave"},
                {data: "planClave"},
                {data: "cgtGradoSemestre"},
                {data: "cgtGrupo"},
                {data: "aluClave"},
                {data: "nombreCompleto"},
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
        * BOTÓN PARA ELIMINAR CALENDARIO.
        */
        // $('#tbl-conceptos').on('click', '.btn-borrar', function() {
        //     var concepto_id = $(this).data('id');
        //     concepto_id && borrar_concepto(concepto_id);
        // });





    });


    // function borrar_concepto(concepto_id) {
    //     swal({
    //         type: 'warning',
    //         title: 'Borrar concepto #'+concepto_id,
    //         text: 'Seguro que deseas eliminar este registro?',
    //         showCancelButton: true,
    //         cancelButtonText: 'No',
    //         confirmButtonText: 'Sí',
    //         closeOnConfirm: false
    //     }, function(){
    //         $('#delete_'+concepto_id).submit();
    //     });
    // }//borrar_concepto







</script>


@endsection