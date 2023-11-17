@extends('layouts.dashboard')

@section('template_title')
    Inscritos Educación Continua
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Inscritos educación continua</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">INSCRITOS EDUCACIÓN CONTINUA</h4>
    @php use App\Models\User; @endphp
    {{-- @if (User::permiso("educontinua") != "D" && User::permiso("educontinua") != "P") --}}
    <a href="{{ url('/inscritosEduContinua/create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a>
    <br>
    <br>
    {{-- @endif --}}
    <div class="row">
        <div class="col s12">
            <table id="tbl-insceducontinua" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>Clave de pago</th>
                  <th>Nombre del alumno</th>
                  <th>ID Programa</th>
                  <th>Clave</th>
                  <th>Nombre</th>
                  <th>Grupo</th>
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


{{-- MODAL EQUIVALENTES --}}
<div id="modalHistorialPagos" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12">
                <h4>Historial de pagos</h4>
                <p class="modalNombres"></p>
            </div>
        </div>


        <div class="row">
            <div class="col s12">
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab col s3"><a href="#tab2">Pagos</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div id="tab2" class="col s12">
                <table id="tbl-historial-pagos-alu" class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Concepto de pago</th>
                            <th>Importe</th>
                            <th>Vencimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="non_searchable"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- <div class="preloader-modal">
            <div id="preloader-modal"></div>
        </div> --}}
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
    $(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-insceducontinua').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
              "type" : "GET",
              'url': base_url+"/api/inscritosEduContinua",
              beforeSend: function () {
                $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
              },
              complete: function () {
                $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
              },
            },
            "columns":[
              {data: "alumno.aluClave"},
              {data: "nombreCompleto", name: "nombreCompleto"},
              {data: "educacioncontinua.id"},
              {data: "educacioncontinua.ecClave"},
              {data: "educacioncontinua.ecNombre"},
              {data: "iecGrupo"},
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
        * BOTÓN PARA ELIMINAR INSCRITO.
        */
        $('#tbl-insceducontinua').on('click', '.btn-borrar', function() {
            var inscrito_id = $(this).data('id');
            inscrito_id && borrar_inscrito(inscrito_id);
        });




    });

    function borrar_inscrito(inscrito_id) {
        swal({
            type: 'warning',
            title: 'Borrar inscrito #' + inscrito_id,
            text: 'Seguro que deseas eliminar este registro?',
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí',
            closeOnConfirm: false
        }, function(){
            $('#delete_'+inscrito_id).submit();
        });
    }//borrar_inscrito

</script>


<!-- crearReferencia/'.$query->curso_id.' -->
<script type="text/javascript">
    function modalHistorialPagos(curso_id) {
        
        //MOSTRAR MODAL
        $('.modal').modal();
        //MOSTRAR GRUPOS
        if ($.fn.DataTable.isDataTable("#tbl-historial-pagos-alu")) {
            $('#tbl-historial-pagos-alu').DataTable().clear().destroy();
        }

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-historial-pagos-alu').dataTable({
            "destroy": true, 
            "language":{"url":"api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "stateSave": true,
            "bSort": false,
            "ajax": {
                "type" : "GET",
                'url': base_url + "/api/eduContPagosList/" + curso_id,
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
                {data: "concepto"},
                {data: "importe"},
                {data: "vencimiento"},
                {data: "action"},
            ],
            //Apply the search
            initComplete: function () {
                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))


                var index = 0
                this.api().columns().every(function () {
                    var column = this;
                    // var columnClass = column.footer().className;
                    // if (columnClass != 'non_searchable') {
                    //     var input = document.createElement("input");


                    //     var columnDataOld = searchFill.columns[index].search.search
                    //     $(input).attr("placeholder", "Buscar").addClass("busquedas").val(columnDataOld);


                    //     $(input).appendTo($(column.footer()).empty())
                    //     .on('change', function () {
                    //         column.search($(this).val(), false, false, true).draw();
                    //     });
                    // }

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

        var curso_id = $(this).data("curso-id")
        var nombres = $(this).data("nombres")
        var aluclave = $(this).data("aluclave")

        var id  = $(this).data("id")

        console.log(nombres)
        $('.modalNombres').html(nombres)

        modalHistorialPagos(id)
        
    })
</script>



@endsection