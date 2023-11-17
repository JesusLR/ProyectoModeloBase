@extends('layouts.dashboard')

@section('template_title')
    Horarios administrativos
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('horarios_administrativos')}}" class="breadcrumb">Horarios administrativos</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">HORARIOS ADMINISTRATIVOS</h4>
    @php use App\Models\User; @endphp
    <div class="row">
        <div class="col s12">

            <div class="card ">
                <div class="card-content white-text">
                    <div class="row">

                        <div class="col s3">
                            {!! Form::label('ubicacion_id', 'Ubicación', array('class' => '')); !!}
                            <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%; margin-top: 10px;">
                                <option selected value="">SELECCIONAR</option>
                                @foreach ($ubicaciones as $ubicacion)
                                    <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col s3">
                            
                            {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                            <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%; margin-top: 10px;">
                            </select>
                        </div>
                        <div class="col s3">

                            {!! Form::label('periodoId', 'Periodos', array('class' => '')); !!}
                            <select id="periodoId" class="browser-default validate select2" required name="periodoId" style="width: 100%; margin-top: 10px;">
                            </select>
                        </div>
                        <div class="col s3">

                            {!! Form::label('empleadoId', 'Empleados', array('class' => '')); !!}
                            <select id="empleadoId" class="browser-default validate select2" required name="empleadoId" style="width: 100%; margin-top: 10px;">
                                <option selected value="">SELECCIONAR</option>
                                @foreach ($empleados as $empleado)
                                    <option value="{{$empleado->id}}">{{$empleado->persona->perNombre}} {{$empleado->persona->perApellido1}} {{$empleado->persona->perApellido2}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="card-action">
                    <a href="{{ url('/horarios_administrativos/calendario/create') }}" class="btn-agregar-horario btn-large waves-effect  darken-3" type="button">Agregar
                        <i class="material-icons left">add</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col s12">
            <table id="table-empleados" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Período numero</th>
                        <th>Período año</th>
                        <th>Clave maestro</th>
                        <th>Nombre completo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
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

    $(".btn-agregar-horario").attr( "disabled","" )

    $("#periodoId").on("change", function (e) {
        e.preventDefault()
        if ($("#empleadoId").val() !== "" && $("#periodoId").val() !== "") {
            $(".btn-agregar-horario").attr("href", base_url + "/horarios_administrativos/" + $("#empleadoId").val() + "/" + $("#periodoId").val() + "/calendario")
            $(".btn-agregar-horario").removeAttr("disabled")
        } else {
            $(".btn-agregar-horario").attr( "disabled","" )

        }

    })

    $("#empleadoId").on("change", function (e) {
        e.preventDefault()

        if ($("#empleadoId").val() !== "" && $("#periodoId").val() !== "") {
            $(".btn-agregar-horario").attr("href", base_url + "/horarios_administrativos/" + $("#empleadoId").val() + "/" + $("#periodoId").val() + "/calendario")
            $(".btn-agregar-horario").removeAttr("disabled")
        } else {
            $(".btn-agregar-horario").attr( "disabled","" )
        }
    })





    $(document).ready(function() {

        function obtenerDepartamentos(ubicacionId) {
            console.log(ubicacionId);

            $("#departamento_id").empty();
            $("#departamento_id").append(`<option selected value="">Seleccionar</option>`);
            $.get(base_url+`/api/departamentos/${ubicacionId}`, function(res,sta) {
                //seleccionar el post preservado
                $("#departamento_id").empty()
                $("#departamento_id").append(`<option value="">SELECCIONAR</option>`);
                res.forEach(element => {
                    $("#departamento_id").append(`<option value=${element.id}>${element.depClave}-${element.depNombre}</option>`);
                });
                $('#departamento_id').trigger('change'); // Notify only Select2 of changes
            });
        }
        
        obtenerDepartamentos($("#ubicacion_id").val())
        $("#ubicacion_id").change( event => {
            obtenerDepartamentos(event.target.value)
        });




        function obtenerPeriodos(departamentoId) {
            console.log("departamentoId");
            console.log(departamentoId);

            $("#periodoId").empty();
            $("#periodoId").append(`<option selected value="">SELECCIONAR</option>`);
            $.get(base_url+`/api/periodoByDepartamento/${departamentoId}`, function(res,sta) {
                $("#periodoId").append(`<option selected value="">SELECCIONAR</option>`);
                //seleccionar el post preservado
                $("#periodoId").empty()
                res.forEach(element => {
                    console.log(element)
                    $("#periodoId").append(`<option value=${element.id}>${element.perNumero}-${element.perAnio}</option>`);
                });
                $('#periodoId').trigger('change'); // Notify only Select2 of changes
            });
        }

        obtenerPeriodos($("#departamento_id").val())
        $(document).on("change", '#departamento_id', function(e) {
            obtenerPeriodos(e.target.value)

        })
    });



    $(document).ready(function() {
        $('#table-empleados').dataTable({
            "language":{"url": base_url + "/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 5,
            "ajax": {
                "type" : "GET",
                'url': base_url + "/api/horarios_administrativos",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                },
            },
            "columns":[
                // {data: "ubiNombre"},
                // {data: "escNombre"},
                {data: "perNumero", name:"perNumero"},
                {data: "perAnio", name: "perAnio"},
                {data: "empleado_id", name:"empleado_id"},
                {data: "nombreCompleto"},
                // {data: "empHorasCon"},

                // {data: "empCredencial"},
                // {data: "empNomina"},
                // {data: "perTelefono1",name:"personas.perTelefono1"},
                {data: "action"}
            ],
            //Apply the search
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if(columnClass != 'non_searchable'){
                        var input = document.createElement("input");
                        $(input).attr("placeholder", "Buscar");
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }
                });
            }
        });
    });
</script>


@endsection