@extends('layouts.dashboard')

@section('template_title')
    Preguntas
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('tutorias_formulario')}}" class="breadcrumb">Lista de formularios</a>
    <a href="{{url('tutorias_formulario_preguntas/'.$formulario->FormularioID)}}" class="breadcrumb">Lista de preguntas</a>
@endsection

@section('content')
    <div id="table-datatables">
        <h4 class="header">PREGUNTAS - {{$formulario->Nombre}}</h4>
         {{-- @php use App\Models\User; @endphp --}}
        {{-- @if (User::permiso("alumno") != "D" && User::permiso("alumno") != "P") --}}
         <a href="{{ url('tutorias_formulario_preguntas/create_pregunta/'.$formulario->FormularioID) }}" class="btn-large waves-effect  darken-3" type="button">Agregar
            <i class="material-icons left">add</i>
        </a> 
        
        <br>
        <br>
        {{-- @endif  --}}
        <div class="row">
            <div class="col s12">
                <table id="tbl-respuestas-formulario" class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Pregunta</th>
                        <th>Categoría</th> 
                        <th>Formulario</th>
                        <th>Total Respuestas</th>
                        <th>Orden visual pregunta</th>
                        <th>Estatus</th>
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

    @include('tutorias.formularioRespuestas.modal-respuestas')
    

@endsection


@section('footer_scripts')
    {!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
    {!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}


    <script type="text/javascript">
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'throw';
            $('#tbl-respuestas-formulario').dataTable({
                "language":{"url":base_url+"/api/lang/javascript/datatables"},
                "serverSide": true,
                "dom": '"top"i',
                "pageLength": 30,
                "stateSave": true,
                "ajax": {
                    "type" : "GET",
                    'url': base_url+"/tutorias_formulario_preguntas/lista_preguntas/{{$formulario->FormularioID}}",
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
                    {data:'Nombre'},
                    {data:'nombre_categoria'},
                    {data:'nombreForumario'},
                    {data:'totalRespuestas'},
                    {data:'orden_visual_pregunta'},
                    {data:'estatusRespuesta'},
                    {data:'action'}
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



    
    <script type="text/javascript">
        $(document).ready(function() {
            $('.modal').modal({
                dismissible: false
            });

            
    
            $(document).on("click", ".btn-modal-respuestas-tuto", function (e) {

                document.getElementById("respuestas").innerHTML = "";

                var PreguntaID = $(this).data("pregunta-id");
                var Nombre = $(this).data("nombre-id");
            

                $("#modalRespuestas").find(".PreguntaID").val(PreguntaID)

                $.get(base_url+`/tutorias_formulario_preguntas/respuesta_pregunta/${PreguntaID}`, function(res,sta) {

                    if(res.length > 0){
                        $("#nombrePregunta").html(res[0].nombrePregunta);
                        $("#notifications").html("Las respuestas que no estan seleccionas no se mostraran en el formulario (inactivas)");


                        res.forEach(element =>{

                            if(element.estatus == "SI"){
                                document.getElementById("respuestas").innerHTML += "<div class='col s12 m6 l4'><input checked type='checkbox'><label style='color: #000000;'>"+element.Nombre+"</label></div>";

                            }else{
                                document.getElementById("respuestas").innerHTML += "<div class='col s12 m6 l4'><input type='checkbox'><label style='color: #000000;'>"+element.Nombre+"</label></div>";

                            }
                        });

                        
                        //res.forEach(element => document.getElementById("respuestas").innerHTML += "<div class='col s12 m6 l4'><input checked type='checkbox'><label style='color: #000000;'>"+element.Nombre+"</label></div>");                                      
                        
          
                        $("#modalRespuestas label").addClass("active")
                    }else{
                        $("#nombrePregunta").html(Nombre);
                        $("#respuestas").html("La pregunta por el momento no cuenta con respuestas disponibles");
                    }


                    
      
                });
               
                $('.modal').modal({
                    dismissible: false
                });
            })
        })
    </script>
    


@endsection
