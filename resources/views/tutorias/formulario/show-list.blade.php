@extends('layouts.dashboard')

@section('template_title')
    Formulario
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('tutorias_formulario')}}" class="breadcrumb">Lista de formulario</a>
@endsection

@section('content')
    <div id="table-datatables">
        <h4 class="header">FORMULARIO</h4>
         {{-- @php use App\Models\User; @endphp --}}
        {{-- @if (User::permiso("alumno") != "D" && User::permiso("alumno") != "P") --}}
        <a href="{{ route('tutorias_formulario.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
            <i class="material-icons left">add</i>
        </a>
        <br>
        <br>
        {{-- @endif  --}}
        <div class="row">
            <div class="col s12">
                <table id="tbl-formularios-disponibles" class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de vigencia</th>    
                        <th>Estatus</th>     
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
            
            $('#tbl-formularios-disponibles').dataTable({
                "language":{"url":base_url+"/api/lang/javascript/datatables"},
                "serverSide": true,
                "dom": '"top"i',
                "pageLength": 10,
                "stateSave": true,
                "ajax": {
                    "type" : "GET",
                    'url': base_url+"/tutorias_formulario/list",
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
                    {data:'Nombre',name: "Nombre"},
                    {data:'Descripcion',name: "Descripcion"},
                    {data:'FechaInicioVigencia',name: "FechaInicioVigencia"},
                    {data:'FechaFinVigencia',name: "FechaFinVigencia"},
                    {data:'Estatus', name: "Estatus"},
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
