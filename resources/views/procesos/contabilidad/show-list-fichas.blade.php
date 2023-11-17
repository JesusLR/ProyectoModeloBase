@extends('layouts.dashboard')


@section('template_title')
    Fichas
@endsection


@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('contabilidad/fichas')}}" class="breadcrumb">Contabilidad de Fichas</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">FICHAS</h4>
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
            <table id="tbl-fichas" class="responsive-table display nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Número Periodo</th>
                    <th>Año Periodo</th>
                    <th>Clave Alumno</th>
                    <th>Clave Carrera</th>
                    <th>Clave Programa</th>
                    <th>Grado/Semestre</th>
                    <th>Grupo</th>
                    <th>Fecha de impresión</th>
                    <th>Hora de impresión</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                    <th>Conc</th>
                    <th>Fecha de vencimiento 1</th>
                    <th>Imp 1</th>
                    <th>Referencia 1</th>
                    <th>Fecha de vencimiento 2</th>
                    <th>Imp 2</th>
                    <th>Referencia 2</th>
                    <th>Estado</th>
                    <th>Id</th>

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





{{-- {!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!} --}}
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
        $('#tbl-fichas').dataTable({
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
                        return 'fichas_' + n;
                    },
                    title:'',
                    messageTop: null,
                    /*
                    customize: function( xlsx )
                    {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row c[r^="O"]', sheet).attr('s', '50');
                        $('c[r="O1"]', sheet).attr('s', '2');
                    },
                    */
                    exportOptions: {
                        orthogonal: 'sort'
                    }
                }
            ],
            columnDefs: [
                {
                    //COLUMNA A AFECTAR , INICIA EN COL#0
                    //FORZOMETRIA: CAMBIARLO A TEXTO
                    targets:[14],
                    render: function(data, type, row, meta)
                    {
                        if(type === 'sort'){
                            //data = ' ' + data ;
                            return "\u200C" + data ;
                        }

                        return data ;

                    }
                }
            ],
            "order": [
                [12, 'asc']
            ],
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/contabilidad/fichas",
                "data":{fecha_inicial:fecha_inicial, fecha_final:fecha_final},
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "fchNumPer",name:"fchNumPer"},
                {data: "fchAnioPer",name:"fchAnioPer"},
                {data: "fchClaveAlu",name:"fchClaveAlu"},
                {data: "fchClaveCarr",name:"fchClaveCarr"},
                {data: "fchClaveProgAct",name:"fchClaveProgAct"},
                {data: "fchGradoSem",name:"fchGradoSem"},
                {data: "fchGrupo",name:"fchGrupo"},
                {data: "fchFechaImpr",name:"fchFechaImpr"},
                {data: "fchHoraImpr",name:"fchHoraImpr"},
                {data: "username",name:"username"},
                {data: "fchTipo",name:"fchTipo"},
                {data: "fchConc",name:"fchConc"},
                {data: "fchFechaVenc1",name:"fchFechaVenc1"},
                {data: "fhcImp1",name:"fhcImp1"},
                {data: "fhcRef1",name:"fhcRef1"},
                {data: "fchFechaVenc2",name:"fchFechaVenc2"},
                {data: "fhcImp2",name:"fhcImp2"},
                {data: "fhcRef2",name:"fhcRef2"},
                {data: "fchEstado",name:"fchEstado"},
                {data: "id",name:"id"}
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
    if( fecha_inicial != '' &&  fecha_final != '')
    {
    $('#tbl-fichas').DataTable().destroy();
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
    $('#tbl-fichas').DataTable().destroy();
    load_data();
    });
});
</script>


@endsection
