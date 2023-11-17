@extends('layouts.dashboard')

@section('template_title')
    Puestos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de puestos</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">PUESTOS</h4>
    @if (in_array(auth()->user()->permiso("puestos"), ['A', 'B']))
        <a href="{{ url('/puestos/create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
            <i class="material-icons left">add</i>
        </a>
    <br>
    <br>
    @endif
    <div class="row">
        <div class="col s12">
            <table id="tbl-puestos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Nombre del puesto</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
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
        $('#tbl-puestos').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/puestos",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "puesNombre"},
                {data: "action"}
            ],
            //Apply the search
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if(columnClass != 'non_searchable'){
                        var input = document.createElement("input");
                        $(input).attr("placeholder", "Buscar");
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }
                });
            }
        });

        /*
        * BOTÓN PARA ELIMINAR PUESTO.
        */
        $('#tbl-puestos').on('click', '.btn-borrar', function() {
            var puesto_id = $(this).data('id');
            puesto_id && borrar_puesto(puesto_id);
        });

    });

    function borrar_puesto (puesto_id) {
        swal({
            type: 'warning',
            title: 'Borrar puesto #' + puesto_id,
            text: 'Seguro que deseas eliminar este registro?',
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí',
            closeOnConfirm: false
        }, function(){
            $('#delete_' + puesto_id).submit();
        });
    }//borrar_puesto
</script>


@endsection