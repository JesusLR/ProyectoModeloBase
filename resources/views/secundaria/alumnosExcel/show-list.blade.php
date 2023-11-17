@extends('layouts.dashboard')

@section('template_title')
    Secundaria alumnos excel
@endsection


@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('secundaria.secundaria_alumnos_excel.index')}}" class="breadcrumb">Alumnos Excel</a>
    {{--  <a href="{{route('secundaria.secundaria_cambio_programa.index')}}" class="breadcrumb">Cambio de programa</a>  --}}
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">FILTRAR ALUMNOS POR PERIODO</h4>
    <div class="row">
        <div class="row">
            <div class="col s12 m6 l4">
                {!! Form::label('perAnioPago', 'Período *', array('class' => '')); !!}
                <select id="perAnioPago" class="browser-default validate select2" required name="perAnioPago"
                    style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach ($periodos as $periodo)
                        <option value="{{$periodo->perAnioPago}}">{{$periodo->perNumero.'-'.$periodo->perAnioPago}}</option>
                    @endforeach
                </select>
            </div>      
            
            <div class="input-field col s4">
                <div class="row" align="center">
                <button type="button" name="filtrar" id="filtrar" class="btn">Filtrar</button>
                <button type="button" name="refrescar" id="refrescar" class="btn">Refrescar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <table  id="tbl-cursos-alumnos" class="responsive-table display nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Período</th>
                    <th>Ubicación</th>
                    <th>Escuela</th>
                    <th>Clave Programa</th>
                    <th>Programa</th>
                    <th>Clave de Pago</th>
                    <th>Apellidos y Nombre del Alumno</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Telefonos</th>
                    <th>Correo</th>
                   
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
        function load_data(perAnioPago = ''){
        $('#tbl-cursos-alumnos').dataTable({
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
                        return 'secundaria_alumnos_' + n;
                    },
                    title:'',
                    messageTop: null
                }
            ],

            "order": [
                [10, 'asc']
            ],
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/reporte/secundaria_alumnos_excel/getAlumnosCursos",
                "data":{perAnioPago:perAnioPago},
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "perAnioPago",name:"perAnioPago"},
                {data: "ubiClave",name:"ubiClave"},   
                {data: "escClave",name:"escClave"},                
                {data: "progClave",name:"progClave"},                
                {data: "progNombre",name:"progNombre"},                
                {data: "aluClave",name:"aluClave"},                
                {data: "perNombreCompleto",name:"perNombreCompleto"},               
                {data: "cgtGradoSemestre",name:"cgtGradoSemestre"},              
                {data: "cgtGrupo",name:"cgtGrupo"},       
                {data: "telefonos",name:"telefonos"},       
                {data: "perCorreo1",name:"perCorreo1"}        
            
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
    var perAnioPago = $('select[id=perAnioPago]').val()
    
    if( perAnioPago != '')
    {
    $('#tbl-cursos-alumnos').DataTable().destroy();
    load_data(perAnioPago);
    }
    else
    {
    swal({
        title: "Error",
        text: "El período es requerido",
        type: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: '#3085d6',
    });
    }
    });

    $('#refrescar').on('click',function(){
    $("#perAnioPago").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
    $('#tbl-cursos-alumnos').DataTable().destroy();
    load_data();
    });
    });

</script>





@endsection
