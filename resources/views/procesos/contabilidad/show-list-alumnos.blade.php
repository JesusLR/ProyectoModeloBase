@extends('layouts.dashboard')

@section('template_title')
    Alumnos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('contabilidad/alumnos')}}" class="breadcrumb">Contabilidad de Alumnos</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">ALUMNOS</h4>
    <div class="row">
        <h5>Filtrar por rango de fechas</h5>
        <div class="input-field col s4">
            <label for="fecha_inicial">Fecha Inicial</label>
            <br>
            <input id="fecha_inicial" type="date" class="validate">
        </div>
        <div class="input-field col s4">
            <label for="fecha_final">Fecha Final</label>
            <br>
            <input id="fecha_final" type="date" class="validate">
        </div>
        <div class="input-field col s4">
            <div class="row" align="center">
            <button type="button" name="filtrar" id="filtrar" class="btn">Filtrar</button>
            <button type="button" name="refrescar" id="refrescar" class="btn">Refrescar</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <table id="tbl-alumnos" class="responsive-table display nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Clave Alumno</th>
                    <th>Nombre Completo</th>
                    <th>Ubicacion</th>
                    <th>Programa</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
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

<style>
.dataTables_filter{
    display:none;
}
</style>





{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{{-- {!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!} --}}
{!! HTML::script(asset('/js/datatables1.10.20/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/datatables1.10.20/dataTables.buttons.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/datatables1.10.20/buttons.flash.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/datatables1.10.20/jszip.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/datatables1.10.20/pdfmake.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/datatables1.10.20/vfs_fonts.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/datatables1.10.20/buttons.html5.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/datatables1.10.20/buttons.print.min.js'), array('type' => 'text/javascript')) !!}

<script type="text/javascript">
$(document).ready(function() {
    let ultimaFechaPago = {!! json_encode($ultimaFechaPago) !!};
    load_data(ultimaFechaPago, ultimaFechaPago);
    function load_data(fecha_inicial = ultimaFechaPago, fecha_final = ultimaFechaPago){
        $('#tbl-alumnos').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "processing": true,
            "serverSide": true,
            "pageLength": -1,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'btn',
                    text: 'Exportar a Excel',
                    filename: function(){
                        var d = new Date();
                        var n = d.getTime();
                        return 'alumnos_' + n;
                    },
                    title:'',
                    messageTop: null,
                    exportOptions: {
                        orthogonal: 'sort'
                    }
                }
            ],
            "order": [
                [1, 'asc']
            ],
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/contabilidad/alumnos",
                "data":{fecha_inicial:fecha_inicial, fecha_final:fecha_final},
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "aluClave",name:"aluClave"},
                {data: "Nombre",name:"Nombre"},
                {data: "ubiClave",name:"ubiClave"},
                {data: "progClave",name:"progClave"}
            ],
            //Apply the search
            initComplete: function () {
                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ));

                var index = 0;
                this.api().columns().every(function ()
                {
                    var column = this;
                    var columnClass = column.footer().className;
                    if(columnClass != 'non_searchable')
                    {
                        var input = document.createElement("input");



                        var columnDataOld = searchFill.columns[index].search.search
                        $(input).attr("placeholder", "Buscar").addClass("busquedas").val(columnDataOld);



                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }

                    index ++;
                });
            },
            stateSaveCallback: function(settings,data) {
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                return JSON.parse(localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            }
        });
    }
        // Finaliza el datatable
    $('#filtrar').on('click',function(){
    var fecha_inicial = $('#fecha_inicial').val();
    var fecha_final = $('#fecha_final').val();
    if( fecha_inicial != '' &&  fecha_final != '' && monthDiff(fecha_inicial, fecha_final) < 1)
    {
    $('#tbl-alumnos').DataTable().destroy();
    load_data(fecha_inicial, fecha_final);
    }
    else
    {
    swal({
        title: "Error",
        text: "Las dos fechas son requeridas, y asegúrese de que su rango de búsqueda no exceda un mes de diferencia entre estas dos fechas.",
        type: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: '#3085d6',
    });
    }
    });

    $('#refrescar').on('click',function(){
    $('#fecha_inicial').val('');
    $('#fecha_final').val('');
    $('#tbl-alumnos').DataTable().destroy();
    load_data();
    });
});

function monthDiff(d1 = '', d2 = '') {
    if(!d1 || !d2) {
        return 100;
    }
    d1 = d1.split("-").map((value) => parseInt(value));
    d2 = d2.split("-").map((value) => parseInt(value));
    d1 = new Date(d1[0], d1[1] - 1, d1[2]);
    d2 = new Date(d2[0], d2[1] - 1, d2[2]);
    let months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months -= d1.getMonth();
    months += d2.getMonth();
    return months <= 0 ? 0 : months;
}

</script>


@endsection
