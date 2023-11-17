@extends('layouts.dashboard')

@section('template_title')
    Candidatos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de candidatos</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">CANDIDATOS</h4>
    {{-- <a href="{{ url('candidatos_primer_ingreso/create') }}" class="btn-large waves-effect  darken-3" type="button">
        Agregar <i class="material-icons left">add</i>
    </a> --}}
    <br>
    <br>
    <div class="row">
        <div class="col s12">
            <table id="tbl-candidatos" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>CURP</th>
                    <th>Apellido paterno</th>
                    <th>Apellido materno</th>
                    <th>Nombre(s)</th>
                    <th>Email</th>
                    <th>Clave campus</th>
                    <th>Clave carrera interesada</th>
                    <th>Email coordinador</th>
                    <th>Preinscrito</th>
                    <th>Fecha</th>
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

        $('#tbl-candidatos').dataTable({
            "language":{"url":base_url + "/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 10,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url + "/api/candidatos_primer_ingreso",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: 'perCurp', name: "candidatos.perCurp"},
                {data: 'perApellido1', name: "candidatos.perApellido1"},
                {data: 'perApellido2', name: "candidatos.perApellido2"},
                {data: 'perNombre', name: "candidatos.perNombre"},
                {data: 'perCorreo1', name: "candidatos.perCorreo1"},
                {data: 'ubiClave', name: "candidatos.ubiClave"},
                {data: 'progClave', name: "candidatos.progClave"},
                {data: 'coordinador_correo', name: "candidatos.coordinador_correo"},
                {data: 'candidatoPreinscrito', name: "candidatos.candidatoPreinscrito"},
                {data: 'created_at'},
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
