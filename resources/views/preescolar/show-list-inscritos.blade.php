@extends('layouts.dashboard')

@section('template_title')
    Alumnos del Grupo
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('preescolar_grupo.index')}}" class="breadcrumb">Lista de grupos</a>
    <a href="" class="breadcrumb">Alumnos del Grupo</a>
@endsection

@section('content')


<div id="table-datatables">
    <br>
    <a id="listaAsistencia" class="btn-large waves-effect darken-3" target="_blank"  href="{{url('/preescolarinscritos/listaAsistencia/grupo/'.$grupo_id)}}">Lista asistencia
        <i class="material-icons left">picture_as_pdf</i>
    </a>
    <a href="{{route('PreescolarInscritos.create')}}" class="btn-large waves-effect darken-3" type="button">Inscribir
        <i class="material-icons left">add</i>
    </a>
    <h4 class="header">Curso: {{$peraniopago}}, Grupo: {{$grupo->gpoGrado}}{{$grupo->gpoClave}} - {{$materia->matNombre}}</h4>
    <div class="row">
        <div class="col s12">
            <table id="tbl-grupo-inscritos-preescolar" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Clave Alumno</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Nombre(s) Alumno</th>
                    <th>Año Escolar</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Acciones/Registro</th>
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

@endsection

@section('footer_scripts')

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    $(document).ready(function() {

        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-grupo-inscritos-preescolar').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "stateSave": true,
            "pageLength": 10,
            "order": [
                [1, 'desc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/preescolarinscritos/" + {!! json_encode($grupo_id)!!},
                beforeSend: function () {
                    $('.preloader').fadeIn(200, function(){$(this).append('<div id="preloader"></div>');});
                },
                complete: function () {
                    $('.preloader').fadeOut(200, function(){$('#preloader').remove();});
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
                {data: "aluClave",name:"alumnos.aluClave"},
                {data:'perApellido1',name: "personas.perApellido1"},
                {data:'perApellido2',name: "personas.perApellido2"},
                {data:'perNombre',name: "personas.perNombre"},
                {data: "perAnio",name:"periodos.perAnio"},
                {data: "gpoGrado",name:"preescolar_grupos.gpoGrado"},
                {data: "gpoClave",name:"preescolar_grupos.gpoClave"},
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

<script type="text/javascript">
$(document).ready(function() {
    var json =  base_url+"/api/preescolarinscritos/" + {!! json_encode($grupo_id)!!}
        $.ajax({
            type: "GET",
            url: json,
            success: function(data) {
                if(data.recordsTotal > 0){
                    $("#listaAsistencia").show();
                }else{
                    $("#listaAsistencia").hide();
                }
            }
        });
});
</script>
@endsection
