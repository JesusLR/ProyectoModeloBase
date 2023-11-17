@extends('layouts.dashboard')

@section('template_title')
    Empleado
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('empleado')}}" class="breadcrumb">Lista de empleados</a>
    <a href="{{url('empleados/cambio-estado')}}" class="breadcrumb">Cambio horas de empleados</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">EMPLEADOS</h4>
    @if($mostrarEtiqueta)
    <div class="header teal-text">{{$etiqueta}}</div>
    @endif
    @if($mostrarFiltro)
    <div class="row">
        <div class="col s12 m6 l3">
            {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
            <select id="ubicacion_id" class="browser-default validate select2" data-ubicacion-id="{{old('ubicacion_id') ?: $ubicacion_id}}" required name="ubicacion_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                @foreach($ubicaciones as $ubicacion)
                    <option value="{{$ubicacion->id}}">{{$ubicacion->ubiClave}}-{{$ubicacion->ubiNombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col s12 m6 l3">
            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
            <select id="departamento_id" class="browser-default validate select2" data-departamento-id="{{old('departamento_id')}}" required name="departamento_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
            </select>
        </div>
        <div class="col s12 m6 l3">
            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
            <select id="escuela_id" class="browser-default validate select2" data-escuela-id="{{old('escuela_id')}}" required name="escuela_id" style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
            </select>
        </div>
        <div class="col s12 m6 l3">
            {!! Form::label('selectSearch', 'Estado del empleado', array('class' => '')); !!}
            <select name="estado_empleado" id="selectSearch" class="browser-default validate select2" style="width: 100%;">
                <option value="">Todos</option>
                <option value="A">A</option>
                <option value="B">B</option>
            </select>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col s12">
            <table id="table-empleados-cambio-horas" class="responsive-table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Apellido paterno</th>
                    <th>Apellido materno</th>
                    <th>Nombre</th>
                    <th>Puesto</th>
                    <th>Estado</th>
                    <th>Credencial</th>
                    <th>Horas Contratadas</th>
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
                    <th class="non_searchable"></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m6 l4">
            <a name="btn_cambiar_multiples" id="btn_cambiar_multiples" class="waves-effect btn-large tooltipped" 
                data-position="right" data-tooltip="Actualizar/cambiar horas contratadas del empleado">
                <i class="material-icons left">sync</i> Actualizar Listado
            </a>
        </div>
    </div>

</div>

<div class="preloader">
    <div id="preloader"></div>
</div>

@endsection
{!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}
@section('footer_scripts')

{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}

<script type="text/javascript">
    $(document).on('click', '.button-edit', function (e) {
        e.preventDefault();
        localStorage.setItem('scrollTo_id', $(this).data('id'));
        window.location.href = $(this).attr('href');
    });
    $('#selectSearch').on('change', function() {
        $('#table-empleados-cambio-horas')
            .DataTable()
            .columns( 5 )
            .search($('#selectSearch').val(), false, true)
            .draw();
    });
    $(document).ready(function() {
        @if($escuela_id)
        let escuela_id = '/'+{{ $escuela_id }};
        @else
        let escuela_id = '';
        @endif
        
        let ubicacion = $('#ubicacion_id');
        let departamento = $('#departamento_id');
        let escuela = $('#escuela_id');

        apply_data_to_select('ubicacion_id', 'ubicacion-id');
        apply_data_to_select('pais_id', 'pais-id');

        ubicacion.val() ? getDepartamentosListaCompleta(ubicacion.val()) : resetSelect('departamento_id');
        ubicacion.on('change', function() {
            this.value ? getDepartamentosListaCompleta(this.value) : resetSelect('departamento_id');
        });

        departamento.on('change', function() {
            this.value ? getEscuelasListaCompleta(this.value) : resetSelect('escuela_id');
        });

        escuela.on('change', function() {
            if (this.value) {

                $('#table-empleados-cambio-horas').dataTable({
                    "language":{"url":base_url + "/api/lang/javascript/datatables"},
                    "serverSide": true,
                    "dom": '"top"i',
                    "paging": false,
                    destroy: true,
                    "pageLength": 5,
                    "stateSave": true,
                    "ajax": {
                        "type" : "GET",
                        'url': base_url+"/api/empleadosHoras/"+this.value,
                        beforeSend: function () {
                            $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                        },
                        complete: function () {
                            $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                            $('#btn_cambiar_multiples').show();

                            if ( localStorage.getItem('scrollTo_id') ) {
                                $('html, body').animate({
                                    scrollTop: $("#"+localStorage.getItem('scrollTo_id')).offset().top - 64
                                }, 2000);

                                localStorage.removeItem('scrollTo_id')
                            }

                        }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                            if (errorThrown === "Unauthorized") {
                                swal({
                                    title: "Ups...",
                                    text: "La sesion ha expirado",
                                    type: "warning",
                                    confirmButtonText: "Ok",
                                    confirmButtonColor: '#3085d6',
                                    showCancelButton: false
                                    }, function(isConfirm) {
                                    if (isConfirm) {
                                        window.location.href = 'login';
                                    } else {
                                        window.location.href = 'login';
                                    }
                                });
                            }
                        }
                    },
                    "columns":[
                        {data: "empleado_id",name:"empleados.id"},
                        {data: "perApellido1", name: "personas.perApellido1"},
                        {data: "perApellido2", name: "personas.perApellido2"},
                        {data: "perNombre", name: "personas.perNombre"},
                        {data: "puesNombre",name:"puestos.puesNombre"},
                        {data: "empEstado"},
                        {data: "empCredencial"},
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
            }
        });

        $.fn.dataTable.ext.errMode = 'throw';
        $('#table-empleados-cambio-horas').dataTable({
            "language":{"url":base_url + "/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "paging": false,
            destroy: true,
            "pageLength": 5,
            "stateSave": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/empleadosHoras"+escuela_id,
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                    $('#btn_cambiar_multiples').hide();
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                    $('#btn_cambiar_multiples').show();

                    if ( localStorage.getItem('scrollTo_id') ) {
                        $('html, body').animate({
                            scrollTop: $("#"+localStorage.getItem('scrollTo_id')).offset().top - 64
                        }, 2000);

                        localStorage.removeItem('scrollTo_id')
                    }

                }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if (errorThrown === "Unauthorized") {
                        swal({
                            title: "Ups...",
                            text: "La sesion ha expirado",
                            type: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            showCancelButton: false
                            }, function(isConfirm) {
                            if (isConfirm) {
                                window.location.href = 'login';
                            } else {
                                window.location.href = 'login';
                            }
                        });
                    }
                }
            },
            "columns":[
                {data: "empleado_id",name:"empleados.id"},
                {data: "perApellido1", name: "personas.perApellido1"},
                {data: "perApellido2", name: "personas.perApellido2"},
                {data: "perNombre", name: "personas.perNombre"},
                {data: "puesNombre",name:"puestos.puesNombre"},
                {data: "empEstado"},
                {data: "empCredencial"},
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

        $('#btn_cambiar_multiples').on('click', function() {
            this.disabled=true;
            this.innerText="Guardando datos...";
            let listado = recolectarDatosDeListado();
            console.log('listado', listado);
            cambiarMultiplesStatusEmpleados(listado);
        });

    });

    function recolectarDatosDeListado() {
        let inputs = $('.horas_empleado_input');
        let listado = {};
        $.each(inputs, function(key, element) {
            let empleado_id = $(element).data('empleado-id');
            listado[empleado_id] = {
                'empleado_id': empleado_id,
                'nuevas_horas': $(element).val(),
            };
        });

        return listado;
    }

    function cambiarMultiplesStatusEmpleados(listado) {
        $.ajax({
            type: 'POST',
            url: `${base_url}/cambiar_horas_empleado/actualizar_lista`,
            dataType: 'json',
            data: {'listado': listado, "_token": "{!! csrf_token() !!}" },
            success: function(data) {

                swal({
                    title: data.title,
                    text: data.msg,
                    type: data.status,
                });
                location.reload();

            },
            error: function(Xhr, textMessage, errorMessage) {
                console.log(errorMessage);
            }
        });
    }

</script>


@endsection