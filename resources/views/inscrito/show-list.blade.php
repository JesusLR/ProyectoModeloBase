@extends('layouts.dashboard')

@section('template_title')
    Inscritos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('inscrito')}}" class="breadcrumb">Lista de inscritos</a>
@endsection

@section('content')
<div id="table-datatables">
    <h4 class="header">INSCRITOS</h4>
    @php use App\Models\User; @endphp
        @if (User::permiso("inscrito") != "D" && User::permiso("inscrito") != "P")
        <a href="{{ url('inscrito/create') }}" class="btn-large waves-effect darken-3" type="button">Por materias
            <i class="material-icons left">add</i>
        </a>
        <a href="{{ url('create/paquete') }}" class="btn-large waves-effect darken-3" type="button">Por paquete
            <i class="material-icons left">add</i>
        </a>
        <a href="{{ url('create/grupo') }}" class="btn-large waves-effect darken-3" type="button">Por grupo
            <i class="material-icons left">add</i>
        </a>
        <a href="{{ url('create/grupoCompleto') }}" class="btn-large waves-effect darken-3" type="button">Por grupo completo
            <i class="material-icons left">add</i>
        </a>

        <br>
        <br>
        {{-- <label style="color: #000;" for="">DESINSCRIBIR ALUMNOS REPROBADOS</label><br>
        <a href="{{ url('desinscribirReprobados') }}" class="btn-large waves-effect darken-3" type="button">Desinscribir 
        </a>
        <br>
        <br> --}}
    @endif
    <div class="row">
        <div class="col s12">
            <table id="tbl-inscrito" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Ubi</th>
                    <th>Depto</th>
                    <th>Esc</th>
                    <th>Prog</th>
                    <th>Plan</th>
                    <th>Período</th>
                    <th>Año</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Clave<br>Materia</th>
                    <th>Materia<br>Nombre</th>
                    <th>Optativa</th>
                    <th>Optativa<br>Nombre</th>
                    <th>Clave Alumno</th>
                    <th>Nombre Alumno</th>
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
        $('#tbl-inscrito').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/inscrito",
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
                {data: "ubiClave",name:"ubicacion.ubiClave"},
                {data: "depClave",name:"departamentos.depClave"},
                {data: "escClave",name:"escuelas.escClave"},
                {data: "progClave",name:"programas.progClave"},
                {data: "planClave",name:"planes.planClave"},
                {data: "perNumero",name:"periodos.perNumero"},
                {data: "perAnio",name:"periodos.perAnio"},
                {data: "cgtGradoSemestre",name:"cgt.cgtGradoSemestre"},
                {data: "gpoClave",name:"grupos.gpoClave"},
                {data: "matClave",name:"materias.matClave"},
                {data: "matNombre",name:"materias.matNombre"},
                {data: "optClaveEspecifica",name:"optativas.optClaveEspecifica"},
                {data: "optNombre",name:"optativas.optNombre"},
                {data: "aluClave",name:"alumnos.aluClave"},
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
    });
</script>
@endsection