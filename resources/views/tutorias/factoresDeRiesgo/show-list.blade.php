@extends('layouts.dashboard')

@section('template_title')
Factores de riesgo
@endsection

@section('head')
{!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' =>
'stylesheet')) !!}
@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_factores_riesgo')}}" class="breadcrumb">Lista de alumno</a>
@endsection

@section('content')
    <div id="table-datatables">
        <h4 class="header">FACTORES DE RIESGO</h4>
         {{-- @php use App\Models\User; @endphp --}}
        {{-- @if (User::permiso("alumno") != "D" && User::permiso("alumno") != "P") --}}
        {{--  <a href="{{ route('tutorias_formulario.create') }}" class="btn-large waves-effect  darken-3" type="button">Agregar
            <i class="material-icons left">add</i>
        </a>  --}}


        <br>
        <br>
        {{-- @endif  --}}
        <div class="row">
            <div class="col s12">
                <table id="tbl-factores" class="responsive-table display" cellspacing="0" width="100%">
                    
                    <thead>
                        <tr>
                            <th>Año</th>
                            <th>Matrícula</th>
                            <th>Nombre</th>
                            <th>Apellido paterno</th>
                            <th>Apellido Materno</th>
                            <th>Universidad</th>
                            <th>Escuela</th>
                            <th>Carrera</th>
                            <th>Parcial</th>
                            <th>Semaforización</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
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
       
        
        $('#tbl-factores').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 30,
            "stateSave": true,
            "scrollCollapse": true,
            "ajax": {
                "type" : "GET",
                'url': base_url+"/tutorias_factores_riesgo/list",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
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
                {data: "periodo"},    
                {data:'Matricula'},
                {data:'NombreAlumno'},
                {data:'ApellidoPaterno'},
                {data:'ApellidoMaterno'},
                {data:'Universidad'},
                {data:'Escuela'},
                {data:'carrera'},
                {data:'Parcial'},
                {data:'semaforo'},
                {data: 'action'}

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


<script>
    $(document).ready(function(){
        $('.modal').modal();
    });
</script>


<script type="text/javascript">

    $(document).on("click", ".btn-modal-asignar-tutor", function (e) {
        e.preventDefault()
        var AlumnoID = $(this).data("alumno-id");
        $("#modalAlumno").find(".AlumnoID").val(AlumnoID)



    })

    $(document).ready(function() {
   
        $(document).on("click", ".btn-modal-asignar-tutor", function (e) {
            e.preventDefault()
            var AlumnoID = $(this).data("alumno-id");

            $.get(base_url+`/tutorias_factores_riesgo/alumnoById/${AlumnoID}`, function(res,sta) {
                console.log("res", res)
                $("#AlumnoID").val(res.AlumnoID);
                $("#Alumnoseleccionado").html('Alumno(a): ' + res.Nombre + ' ' + res.ApellidoPaterno + ' ' + res.ApellidoMaterno);
                $("#FormularioID").val(res.FormularioID);
                $("#nombreFormulario").html(res.nombreFormulario);
                
  
                //$("#modalAlumnoDetalle-preescolar label").addClass("active")
  
            });
            $('.modal').modal();
        })
     
    })
  </script>
@endsection
