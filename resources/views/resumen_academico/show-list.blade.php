@extends('layouts.dashboard')

@section('template_title')
    Resúmenes Académicos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}      
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de Resúmenes académicos</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Resúmenes académicos</h4>
    {{-- @if (User::permiso("municipios") != "D" || User::permiso("municipios") != "P") --}}
    {{-- <a href="{{ url('/resumen_academico/create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
        <i class="material-icons left">add</i>
    </a> --}}
    <br>
    <br>
     {{-- @endif     --}}
    <div class="row">
        <div class="col s12">
            <table id="tbl-resumenes" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Clave <br> Pago</th>
                    <th>Nombre <br> Alumno</th>
                    <th>Ubic.</th>
                    <th>Depto.</th>
                    <th>Esc.</th>
                    <th>Prog.</th>
                    <th>Plan</th>
                    <th>Periodo <br> Ingreso</th>
                    <th>Año</th>
                    <th>Últ. <br> Grado</th>
                    <th>Cred. <br> Cursados</th>
                    <th>Cred. <br> Aprob</th>
                    <th>Plan<br> Créditos</th>
                    <th>Avance</th>
                    <th>Prom.</th>
                    <th>Edo.</th>
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
        $('#tbl-resumenes').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "order": [
                [1, 'asc']
            ],
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/resumen_academico",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "resumen_id", name:'resumenacademico.id'},
                {data: "aluClave", name: "alumnos.aluClave"},
                {data: "nombreCompleto", name:"nombreCompleto"},
                {data: "ubiClave", name:"ubicacion.ubiClave"},
                {data: "depClave", name:"departamentos.depClave"},
                {data: "escClave", name:"escuelas.escClave"},
                {data: "progClave", name:"programas.progClave"},
                {data: "planClave", name:"planes.planClave"},
                {data: "perNumero", name:"periodos.perNumero"},
                {data: "perAnio", name:"periodos.perAnio"},
                {data: "resUltimoGrado", name:"resUltimoGrado"},
                {data: "resCreditosCursados", name:"resCreditosCursados"},
                {data: "resCreditosAprobados", name:"resCreditosAprobados"},
                {data: "planNumCreditos", name:"planNumCreditos"},
                {data: "resAvanceAcumulado", name:"resAvanceAcumulado"},
                {data: "resPromedioAcumulado", name:"resPromedioAcumulado"},
                {data: "resEstado", name:"resEstado"},
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