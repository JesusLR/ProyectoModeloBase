@extends('layouts.dashboard')

@section('template_title')
    Referencias
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('contabilidad/referencias')}}" class="breadcrumb">Contabilidad de Referencias</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">REFERENCIAS</h4>
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
            <table id="tbl-referencias" class="responsive-table display nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Clave de Alumno</th>
                    <th>Numero</th>
                    <th>Año de periodo</th>
                    <th>Clave Programa</th>
                    <th>Conc Pago</th>
                    <th>Fecha Vencimiento</th>
                    <th>Importe total</th>
                    <th>Importe conc</th>
                    <th>Importe beca</th>
                    <th>Importe PP</th>
                    <th>Importe AntCred</th>
                    <th>Importe Recar</th>
                    <th>Usuario</th>
                    <th>Fecha importe</th>
                    <th>Hora importe</th>
                    <th>Usuario aplico</th>
                    <th>Fecha aplico</th>
                    <th>Hora aplico</th>
                    <th>Estado</th>


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
        load_data();
        function load_data(fecha_inicial = '', fecha_final = ''){
        $('#tbl-referencias').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "processing": true,
            "serverSide": true,

            "pageLength": -1,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    className: 'btn',
                    text: 'Exportar a Excel',
                    filename: function(){
                        var d = new Date();
                        var n = d.getTime();
                        return 'referencias_' + n;
                    },
                    title:'',
                    messageTop: null
                }
            ],

            "order": [
                [13, 'asc']
            ],
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/contabilidad/referencias",
                "data":{fecha_inicial:fecha_inicial, fecha_final:fecha_final},
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "aluClave",name:"aluClave"},
                {data: "refNum",name:"refNum"},
                {data: "refAnioPer",name:"refAnioPer"},
                {data: "progClave",name:"progClave"},
                {data: "refConcPago",name:"refConcPago"},
                {data: "refFechaVenc",name:"refFechaVenc"},
                {data: "refImpTotal",name:"refImpTotal"},
                {data: "refImpConc",name:"refImpConc"},
                {data: "refImpBeca",name:"refImpBeca"},
                {data: "refImpPP",name:"refImpPP"},
                {data: "refImpAntCred",name:"refImpAntCred"},
                {data: "refImpRecar",name:"refImpRecar"},
                {data: "usu_gen_ref",name:"usu_gen_ref"},
                {data: "fecha_imp",name:"fecha_imp"},
                {data: "hora_imp",name:"hora_imp"},
                {data: "refUsuarioAplico",name:"refUsuarioAplico"},
                {data: "refFechaAplico",name:"refFechaAplico"},
                {data: "refHoraAplico",name:"refHoraAplico"},
                {data: "refEstado",name:"refEstado"}
            ],
            //Apply the search
            initComplete: function () {
                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ));


                var index = 0
                this.api().columns().every(function () {
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
    if( fecha_inicial != '' &&  fecha_final != '')
    {
    $('#tbl-referencias').DataTable().destroy();
    load_data(fecha_inicial, fecha_final);
    }
    else
    {
    swal({
        title: "Error",
        text: "Las dos fechas son requeridas",
        type: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: '#3085d6',
    });
    }
    });

    $('#refrescar').on('click',function(){
    $('#fecha_inicial').val('');
    $('#fecha_final').val('');
    $('#tbl-referencias').DataTable().destroy();
    load_data();
    });
    });

</script>


@endsection
