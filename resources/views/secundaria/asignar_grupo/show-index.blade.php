@extends('layouts.dashboard')

@section('template_title')
    Secundaria inscritos materia
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('secundaria.secundaria_asignar_grupo.index')}}" class="breadcrumb">Lista de inscritos materia</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">INSCRITOS MATERIA</h4>
    {{-- @php use App\Models\User; @endphp
        @if (User::permiso("inscrito") != "D" && User::permiso("inscrito") != "P") --}}
        <a href="{{ route('secundaria.secundaria_asignar_grupo.create') }}" class="btn-large waves-effect darken-3" type="button">Por materias
            <i class="material-icons left">add</i>
        </a>
        {{--  <a href="{{ url('create/paquete') }}" class="btn-large waves-effect darken-3" type="button">Por paquete
            <i class="material-icons left">add</i>
        </a>
        <a href="{{ url('create/grupo') }}" class="btn-large waves-effect darken-3" type="button">Por grupo
            <i class="material-icons left">add</i>
        </a>
        <a href="{{ url('create/grupoCompleto') }}" class="btn-large waves-effect darken-3" type="button">Por grupo completo
            <i class="material-icons left">add</i>
        </a>  --}}

        <br>
        <br>
        {{-- <label style="color: #000;" for="">DESINSCRIBIR ALUMNOS REPROBADOS</label><br>
        <a href="{{ url('desinscribirReprobados') }}" class="btn-large waves-effect darken-3" type="button">Desinscribir
        </a>
        <br>
        <br> --}}
    {{-- @endif --}}
    <div class="row">
        <div class="col s12">
            <table id="tbl-inscrito-secundaria" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    {{--  <td>ID</td>  --}}
                    <th>Ubicación</th>
                    {{--  <th>Departamento</th>
                    <th>Escuela</th>  --}}
                    <th>Programa</th>
                    <th>Año</th>
                    <th>Plan</th>                                       
                    <th>Clave Materia</th>
                    <th>Materia</th>
                    <th>Grupo ACD</th>
                    <th>Grado</th>
                    <th>Grupo</th> 
                    <th>Nombre(s) Docente</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Clave Alumno</th>
                    <th>Nombre Alumno</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    {{--  <th></th>  --}}
                    <th></th>
                    {{--  <th></th>
                    <th></th>  --}}
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
        $('#tbl-inscrito-secundaria').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/secundaria_asignar_grupo/list",
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
                //{data: "inscrito_id"},
                {data: "ubiNombre",name:"ubicacion.ubiNombre"},
                /*{data: "depNombre",name:"departamentos.depNombre"},
                {data: "escNombre",name:"escuelas.escNombre"},*/
                {data: "progNombre",name:"programas.progNombre"},
                {data: "perAnio",name:"periodos.perAnio"},
                {data: "planClave",name:"planes.planClave"},                            
                {data: "matClave",name:"secundaria_materias.matClave"},
                {data: "matNombre",name:"secundaria_materias.matNombre"},
                {data: "gpoMatComplementaria",name:"secundaria_grupos.gpoMatComplementaria"},
                {data: "gpoGrado",name:"secundaria_grupos.gpoGrado"},
                {data: "gpoClave",name:"secundaria_grupos.gpoClave"},    
                {data: "NombreDocente"},
                {data: "apellidoPaternoDocente"},
                {data: "apellidoMaternoDocente"},
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
