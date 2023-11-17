@extends('layouts.dashboard')

@section('template_title')
    Tutorias Alumnos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('tutorias_encuestas')}}" class="breadcrumb">Lista de alumnos</a>
@endsection

@section('content')
    <div id="table-datatables">
        <h4 class="header">ALUMNOS</h4>
        {{--  @php use App\Models\User; @endphp
        @if (User::permiso("alumno") != "D" && User::permiso("alumno") != "P")
        <a href="{{ route('tutorias_alumnos.radios') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
            <i class="material-icons left">add</i>
        </a>
        <br>
        <br>
        @endif  --}}
        <a href="{{ route('tutorias_encuestas.create_alumnos') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
            <i class="material-icons left">add</i>
        </a>
        <div class="row">
            <div class="col s12">
                <table id="tbl-alumnos" class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Período</th>
                        <th>Escuela</th>
                        <th>Clave Pago</th>
                        <th>Semestre</th>
                        <th>Nombre(s)</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>         
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

    <div id="modalEstatusAlumno-primaria" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <input type="hidden" value="" class="alumnoId">
                    <h4>Modificar Estatus Del Alumno</h4>
                    <select name="aluEstado" class="aluEstado browser-default validate select2" id="" style="width: 100%;">
                        <option value="">Seleccionar</option>
                        <option value="R">Regular</option>
                        <option value="E">Egresado</option>
                        <option value="N">Nuevo ingreso</option>
                        <option value="B">Baja</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l6">
                    <label for="resFechaBaja" class="resFechaBaja">Fecha de baja</label>
                    <input type="date" id="resFechaBaja" name="resFechaBaja" class="resFechaBaja validate" style="width: 100%;" />
                </div>
                <div class="col s12 m6 l6">
                    <label for="conceptosBaja" class="conceptosBaja">Motivo de baja</label>
                    <select id="conceptosBaja" class="browser-default validate conceptosBaja" required name="conceptosBaja" style="width: 100%;" required>
                        <option value="" selected disabled>Seleccionar</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l8">
                    <label for="resObservaciones" class="resObservaciones">Observaciones</label>
                    <input type="text" id="resObservaciones" name="resObservaciones" class="resObservaciones validate" style="width: 100%;" />
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <button type="button" class="guardar-estatus-alumno btn-large waves-effect  darken-3 btn-flat" style="color: #fff;">
                        <i class="material-icons left">add</i>
                        Guardar
                    </button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-close waves-effect waves-green btn-flat">Cerrar</button>
        </div>
    </div>

    {{-- MODAL EQUIVALENTES --}}
    <div id="modalpro" class="modal">
        <div class="modal-content">
            <h4>Historial de pagos</h4>

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
            $('.resFechaBaja').hide();
            $('.resObservaciones').hide();
            $('.conceptosBaja').hide();

            $.get(base_url+`/primaria_alumno/conceptosBaja`, function(data) {

                $.each(data,function(key,value){
                    $("#conceptosBaja").append(`<option value=${value.conbClave}>${value.conbNombre}</option>`);
                });

            });

            $.fn.dataTable.ext.errMode = 'throw';
            $('#tbl-alumnos').dataTable({
                "language":{"url":base_url+"/api/lang/javascript/datatables"},
                "serverSide": true,
                "dom": '"top"i',
                "pageLength": 5,
                "stateSave": true,
                "ajax": {
                    "type" : "GET",
                    'url': base_url+"/tutorias_encuestas/list",
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
                    {data: 'periodo'},
                    {data:'escClave', name: 'escuelas.escClave'},
                    {data:'clave_pago'},
                    {data:'semestre'},
                    {data:'nombre_alumno'},
                    {data:'apellido1'},
                    {data:'apellido2'},
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
