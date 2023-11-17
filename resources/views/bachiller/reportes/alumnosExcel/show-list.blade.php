@extends('layouts.dashboard')

@section('template_title')
    Bachiller alumnos excel
@endsection


@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_alumnos_excel.index')}}" class="breadcrumb">Alumnos Excel</a>
    {{--  <a href="{{route('secundaria.secundaria_cambio_programa.index')}}" class="breadcrumb">Cambio de programa</a>  --}}
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">FILTRAR ALUMNOS POR PERIODO</h4>
    <div class="row">
        <div class="row">
            <div class="col s12 m6 l4">
                {!! Form::label('perAnio', 'Período *', array('class' => '')); !!}
                <select id="perAnio" class="browser-default validate select2" required name="perAnio"
                    style="width: 100%;">
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                    @foreach ($periodos as $periodo)
                        <option value="{{$periodo->perAnio}}">{{$periodo->perNumero.'-'.$periodo->perAnio}}</option>
                    @endforeach
                </select>
                <input type="hidden" id="perNumero" name="perNumero">
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
            <table  id="tbl-cursos-alumnos-bachiller" class="responsive-table display nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Campus</th>
                    <th>Clave Pago</th>
                    <th>Matricula</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Nombre(s)</th>
                    <th>Curp</th>
                    {{--  <th>Genero</th>  --}}
                    {{--  <th>Fecha Nacimiento</th>  --}}
                    <th>Año</th>
                    <th>Período</th>
                    <th>Semestre</th>
                    <th>Grupo </th>
                    <th>Beca Clave</th>
                    <th>Beca</th>
                    <th>Beca %</th>
                    <th>Beca Observación</th>
                    <th>Teléfono </th>
                    <th>Celular</th>
                    <th>Correo Alumno</th>
                    <th>Nombre Tutor Titular</th>
                    <th>Parentesco Tutor Titular</th>
                    <th>Celular Tutor Titular 1</th>
                    <th>Correo Tutor Titular 1</th>
                    <th>Nombre Tutor 1</th>
                    <th>Celular Tutor 1</th>
                    <th>Correo Tutor 1</th>
                    <th>Nombre Tutor 2</th>
                    <th>Celular Tutor 2</th>
                    <th>Correo Tutor 2</th>
                    <th>Nombre Tutor 3</th>
                    <th>Celular Tutor 3</th>
                    <th>Correo Tutor 3</th>
                    <th>Nombre Tutor 4</th>
                    <th>Celular Tutor 4</th>
                    <th>Correo Tutor 4</th>
                    <th>Estado Curso</th>
                    


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
                    {{--  <th></th>  --}}
                    {{--  <th></th>  --}}
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
{{--  @include('bachiller.alumnosExcel.crearTablaJS')  --}}
<script>
    $(document).ready(function(){
        
        $("#perAnio").change(function(){

            var perNumero = $('select[name="perAnio"] option:selected').text();
            perNumero.split('-') // [ 'free', 'code', 'camp' ]

            $("#perNumero").val(perNumero[0]);
           
        });
     
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        load_data();
        function load_data(perAnio = '', perNumero = ''){
        $('#tbl-cursos-alumnos-bachiller').dataTable({
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
                        return 'alumnos_bachiller_' + n;
                    },
                    title:'',
                    messageTop: null
                }
            ],

            "order": [
                [9, 'asc']
            ],
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/reporte/bachiller_alumnos_excel/getAlumnosCursos",
                "data":{perAnio:perAnio,
                    perNumero:perNumero},
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                {data: "ubiClave"},
                {data: "aluClave"},
                {data: "aluMatricula"},
                {data: "perApellido1"},   
                {data: "perApellido2"},                
                {data: "perNombre"},                
                {data: "perCurp"},  
                //{data: "perSexo"},                
                //{data: "perFechaNac"},             
                {data: "perAnio"}, 
                {data: "perNumero"},               
                {data: "cgtGradoSemestre"},               
                {data: "cgtGrupo"},              
                {data: "curTipoBeca"},       
                {data: "bcaNombre"},       
                {data: "curPorcentajeBeca"}, 
                {data: "curObservacionesBeca"},              
                {data: "perTelefono1"},             
                {data: "perTelefono2"},            
                {data: "perCorreo1"},                  
                {data: "hisTutorOficial"},         
                {data: "hisParentescoTutor"},       
                {data: "hisCelularTutor"},       
                {data: "hisCorreoTutor"},
                {data: "tutNombre1"},                
                {data: "tutTelefono1"},       
                {data: "tutCorreo1"},
                {data: "tutNombre2"},                
                {data: "tutTelefono2"},       
                {data: "tutCorreo2"},
                {data: "tutNombre3"},                
                {data: "tutTelefono3"},       
                {data: "tutCorreo3"},
                {data: "tutNombre4"},                
                {data: "tutTelefono4"},       
                {data: "tutCorreo4"},
                {data: "curEstado"}      
            
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
    var perAnio = $('select[id=perAnio]').val();
    var perNumero = $("#perNumero").val();

    
    if( perAnio != '' && perNumero != '')
    {
    $('#tbl-cursos-alumnos-bachiller').DataTable().destroy();
    load_data(perAnio, perNumero);
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
    $("#perAnio").val("").trigger( "change" );
    $("#perNumero").val("");
    $('#tbl-cursos-alumnos-bachiller').DataTable().destroy();
    load_data();
    });
    });

</script>





@endsection
