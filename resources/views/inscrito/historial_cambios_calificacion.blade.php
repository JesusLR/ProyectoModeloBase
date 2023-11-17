@extends('layouts.dashboard')

@section('template_title')
    Inscritos - Calificaciones
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('inscrito')}}" class="breadcrumb">Lista de inscritos</a>
@endsection

@section('content')
@php
    $curso = $inscrito->curso;
    $periodo = $curso->periodo;
    $alumno = $curso->alumno;
    $grupo = $inscrito->grupo;
    $materia = $grupo->materia;
    $plan = $materia->plan;
    $programa = $plan->programa;
@endphp
<div id="table-datatables">
    <h4 class="header">Historial de cambio de calificaciones</h4>

    <div class="row">
        <p><b>Alumno: </b> {{$alumno->aluClave}} {{$alumno->persona->nombreCompleto()}}</p>
        <p><b>Materia: </b> {{$materia->matClave}} {{$materia->matNombreOficial}}</p>
        <p><b>Grupo: </b> {{$grupo->gpoSemestre}}° "{{$grupo->gpoClave}}"</p>
        <p><b>Programa: </b> {{$programa->progClave}} ({{$plan->planClave}}) {{$programa->progNombre}}</p>
        <p><b>Periodo: </b> {{$periodo->perNumero}}/{{$periodo->perAnio}}</p>
        <hr>
    </div>
    
    <div class="row">
        <div class="col s12">
            <table id="tbl-cambios-calificacion" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th rowspan="2">cambio ID</th>
                    <th style="text-align:center; border-bottom:none;" colspan="2">Parcial 1</th>
                    <th style="text-align:center; border-bottom:none;" colspan="2">Parcial 2</th>
                    <th style="text-align:center; border-bottom:none;" colspan="2">Parcial 3</th>
                    <th style="text-align:center; border-bottom:none;" colspan="2">Ordinario</th>
                    <th rowspan="2">Fecha de cambio</th>
                </tr>
                <tr>
                    <th>De</th>
                    <th>A</th>
                    <th>De</th>
                    <th>A</th>
                    <th>De</th>
                    <th>A</th>
                    <th>De</th>
                    <th>A</th>
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
        const calificacion = {!! json_encode($inscrito->calificacion) !!};
        $.fn.dataTable.ext.errMode = 'throw';
        $('#tbl-cambios-calificacion').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/calificaciones_historial",
                "data": { calificacion_id: calificacion.id },
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
                {data: "id"},
                {data: "parcial1_anterior"},
                {data: "parcial1"},
                {data: "parcial2_anterior"},
                {data: "parcial2"},
                {data: "parcial3_anterior"},
                {data: "parcial3"},
                {data: "ordinario_anterior"},
                {data: "ordinario"},
                {data: "fecha_cambio"},
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