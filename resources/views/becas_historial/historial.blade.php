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
    @php
        $alumno = $curso->alumno;
        $cgt = $curso->cgt;
        $plan = $cgt->plan;
        $programa = $plan->programa;
        $periodo = $curso->periodo;
        $departamento = $periodo->departamento;
        $ubicacion = $departamento->ubicacion;
    @endphp
    <h4 class="header">Historial de Becas</h4>
    <div class="row">
        <p><b>{{$ubicacion->ubiNombre}} {{$departamento->depNombre}} </b></p>
        <hr>
        <p><b>Clave de pago:</b> {{$alumno->aluClave}}</p>
        <p><b>Alumno:</b> {{$alumno->persona->nombreCompleto()}}</p>
        <p><b>Grupo:</b> {{$cgt->cgtGradoSemestre}}° {{$cgt->cgtGrupo}}</p>
        <p><b>Programa:</b> {{$programa->progClave}} ({{$plan->planClave}}) {{$programa->progNombre}}</p>
        <p><b>Periodo:</b> {{$periodo->perNumero}}/{{$periodo->perAnio}}</p>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col s12">
            <table id="tbl-cursos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Porcentaje</th>
                    <th>Tipo</th>
                    <th>Observaciones</th>
                    <th>Fecha cambio</th>
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
                    {{-- <th class="non_searchable"></th> --}}
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

        const curso = {!! json_encode($curso) !!};
        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-cursos').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/becas_historial",
                data: {
                    curso_id: curso.id
                },
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
                {data: "porcentaje"},
                {data: "tipo"},
                {data: "observaciones"},
                {data: "fecha_cambio"},
                {data: "usuario", name: "usuario"}
                // {data: "action"}
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