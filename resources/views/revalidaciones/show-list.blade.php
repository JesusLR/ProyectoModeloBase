@extends('layouts.dashboard')

@section('template_title')
    Revalidaciones
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}      
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Lista de Revalidaciones</label>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Revalidaciones</h4>
    <br>
    <br>
    <div class="row">
        <div class="col s12">
            <table id="tbl-revalidaciones" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Folio</th>
                    <th>Ubic.</th>
                    <th>Depto.</th>
                    <th>Prog.</th>
                    <th>Plan</th>
                    <th>Clave <br> Pago</th>
                    <th>Matrícula</th>
                    <th>Apellido <br> Paterno</th>
                    <th>Apellido <br> Materno</th>
                    <th>Nombre</th>
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
        $('#tbl-revalidaciones').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/revalidaciones",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "id", data: "id"},
                {data: "plan.programa.escuela.departamento.ubicacion.ubiClave", name:'plan.programa.escuela.departamento.ubicacion.ubiClave'},
                {data: "plan.programa.escuela.departamento.depClave", name: "plan.programa.escuela.departamento.depClave"},
                {data: "plan.programa.progClave", name:"plan.programa.progClave"},
                {data: "plan.planClave", name:"plan.planClave"},
                {data: "alumno.aluClave", name:"alumno.aluClave"},
                {data: "alumno.aluMatricula", name:"alumno.aluMatricula"},
                {data: "alumno.persona.perApellido1", name:"alumno.persona.perApellido1"},
                {data: "alumno.persona.perApellido2", name:"alumno.persona.perApellido2"},
                {data: "alumno.persona.perNombre", name:"alumno.persona.perNombre"},
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