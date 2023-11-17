@extends('layouts.dashboard')

@section('template_title')
    Primaria alumnos excel
@endsection


@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_datos_completos_alumno.reporteAlumnos')}}" class="breadcrumb">Alumnos Excel</a>
    {{--  <a href="{{route('secundaria.secundaria_cambio_programa.index')}}" class="breadcrumb">Cambio de programa</a>  --}}
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">FILTRAR ALUMNOS POR PERIODO</h4>
    <div class="row">

        <div class="row">
            <div class="col s12 m6 l4">
                {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                <select id="ubicacion_id" class="browser-default validate select2" required
                    name="ubicacion_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach($ubicaciones as $ubicacion)
                    @php
                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                    $selected = '';
                    if($ubicacion->id == $ubicacion_id){
                    $selected = 'selected';
                    }
                    @endphp
                    <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col s12 m6 l4">
                {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                <select id="departamento_id" class="browser-default validate select2" required
                    name="departamento_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
            </div>
            <div class="col s12 m6 l4">
                {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                <select id="escuela_id" class="browser-default validate select2" required name="escuela_id"
                    style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m6 l4">
                {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                <select id="periodo_id" class="browser-default validate select2" required name="periodo_id"
                    style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
            </div>
            <div class="col s12 m6 l4" style="display: none;">
                <div class="input-field">
                    {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' =>
                    'validate','readonly')) !!}
                    {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                </div>
            </div>
            <div class="col s12 m6 l4" style="display: none;">
                <div class="input-field">
                    {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' =>
                    'validate','readonly')) !!}
                    {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                </div>
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
            <table  id="tbl-cursos-alumnos-primaria" class="responsive-table display nowrap" cellspacing="0" width="100%">
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
@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas')
@include('primaria.scripts.periodos')
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
        function load_data(periodo_id = ''){
        $('#tbl-cursos-alumnos-primaria').dataTable({
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
                        return 'primaria_alumnos_' + n;
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
                'url': base_url+"/reporte/primaria_datos_completos_alumno/getAlumnosCursosEduardo/primaria",
                "data":{periodo_id:periodo_id},
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
    var periodo_id = $('select[id=periodo_id]').val()
    
    if( periodo_id != '')
    {
    $('#tbl-cursos-alumnos-primaria').DataTable().destroy();
    load_data(periodo_id);
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
    $("#periodo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
    $('#tbl-cursos-alumnos-primaria').DataTable().destroy();
    load_data();
    });
    });

</script>





@endsection
