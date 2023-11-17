@extends('layouts.dashboard')

@section('template_title')
Encuesta
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_encuestas/encuestas_disponibles/'.$alumno->aluClave.'/'.$alumno->CursoID)}}" class="breadcrumb">Lista de encuestas</a>
@endsection

@section('content')



<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'tutorias_encuestas.storeCovid', 'method' => 'POST']) !!}

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">RESPONDER ENCUESTA - {{$tutorias_preguntas[0]->nombreFormulario}}</span>

                <div class="row personalizado" style="border-radius: 2px;">
                    <div class="col s12 m6 l6 personalizado">
                        <p><strong>Fecha inicio de vigencia:</strong> {{ \Carbon\Carbon::parse($tutorias_preguntas[0]->FechaInicioVigencia)->format('d/m/Y')}}</p>
                    </div>
                    <div class="col s12 m6 l6 personalizado">
                        <p><strong>Fecha fin de vigencia:</strong> {{ \Carbon\Carbon::parse($tutorias_preguntas[0]->FechaFinVigencia)->format('d/m/Y')}}</p>
                    </div>
                </div>

                <br>

                <input type="hidden" class="noUpperCase" name="AlumnoID" id="AlumnoID" value="{{$alumno->AlumnoID}}">
                <input type="hidden" class="noUpperCase" name="FormularioID" id="FormularioID" value="{{$FormularioID}}">
                <input type="hidden" class="noUpperCase" name="ACCION" id="ACCION" value="GUARDAR">


                @php
                    $vuelta = 1;

                    $vueltas2 = 0;
                @endphp


                {{-- GENERAL BAR--}}
                <div id="general">
                    <div class="row">
                        <ul class="collapsible popout" data-collapsible="accordion">
                            @foreach ($agrupar_categoria_preguntas as $categoriaRespuesta => $cicloCategoria)
                                @foreach ($cicloCategoria as $key => $itemCategoria)

                                @endforeach
                                <li>
                                    <div class="active collapsible-header" id="{{$itemCategoria->CategoriaID}}">
                                        <i class="material-icons">question_answer</i><b>CATEGORÍA - {{$itemCategoria->NombreCategoria}}</b></div>
                                    <div class="collapsible-body">
                                        <div class="row">
                                            @foreach ($tutorias_preguntas as $itemPreguntas)
                                                @if ($itemPreguntas->CategoriaPreguntaID == $itemCategoria->CategoriaPreguntaID)

                                                    @if ($itemPreguntas->TipoRespuesta == 0)
                                                        <p><b style="font-style: italic;">{{$itemPreguntas->Nombre}}</b></p>


                                                        @foreach ($tutorias_respuesta_agrupada as $tutRespuestaAgrupada)
                                                            @if ($tutRespuestaAgrupada->PreguntaID == $itemPreguntas->PreguntaID)
                                                                @foreach ($tutRespuestas as $itemRespuesta)
                                                                    @if ($itemRespuesta->PreguntaID == $tutRespuestaAgrupada->PreguntaID)
                                                                        <input type="hidden" class="noUpperCase" value="{{$itemRespuesta->Parcial}}" name="Parcial">
                                                                        <input type="hidden" class="noUpperCase" value="{{$itemRespuesta->RespuestaID}}" name="respuestaID[{{$tutRespuestaAgrupada->PreguntaID}}]">

                                                                        <div class="col s12 m12 l4">
                                                                            <div style="position:relative;">
                                                                                <input type="radio" class="noUpperCase"  checked name="Respuesta[{{$tutRespuestaAgrupada->PreguntaID}}]" data-semafor="{{$itemRespuesta->Semaforizacion}}" data-respuesta="{{$itemRespuesta->RespuestaID}}" id="{{$itemRespuesta->RespuestaID}}" value="{{$itemRespuesta->Nombre}}">
                                                                                <label for="{{$itemRespuesta->RespuestaID}}"> {{$itemRespuesta->Nombre}}</label>
                                                                            </div>

                                                                        </div>



                                                                        <script>
                                                                            $(document).ready(function(){

                                                                                //$("#{{$itemRespuesta->RespuestaID}}").prop("checked", true);

                                                                                if($("#{{$itemRespuesta->RespuestaID}}").is(':checked')) {
                                                                                        var semafor = $("#{{$itemRespuesta->RespuestaID}}").data("semafor");
                                                                                        var respuestaID = $("#{{$itemRespuesta->RespuestaID}}").data("respuesta");


                                                                                        $("#Semaforo_{{$tutRespuestaAgrupada->PreguntaID}}").val(semafor);
                                                                                        $("#respuestaData_{{$tutRespuestaAgrupada->PreguntaID}}").val(respuestaID);
                                                                                } else {
                                                                                    $("#Semaforo_{{$tutRespuestaAgrupada->PreguntaID}}").val("");
                                                                                    $("#respuestaData_{{$tutRespuestaAgrupada->PreguntaID}}").val("0");

                                                                                    $("#dibuja_{{$tutRespuestaAgrupada->PreguntaID}}").html("<input type='hidden' class='noUpperCase' name='Respuesta[{{$tutRespuestaAgrupada->PreguntaID}}]' value='Pendiente por responder'>")

                                                                                }


                                                                                $("#{{$itemRespuesta->RespuestaID}}").click(function() {
                                                                                    if($("#{{$itemRespuesta->RespuestaID}}").is(':checked')) {

                                                                                        var semafor = $("#{{$itemRespuesta->RespuestaID}}").data("semafor");
                                                                                        var respuestaID = $("#{{$itemRespuesta->RespuestaID}}").data("respuesta");


                                                                                        $("#Semaforo_{{$tutRespuestaAgrupada->PreguntaID}}").val(semafor);
                                                                                        $("#respuestaData_{{$tutRespuestaAgrupada->PreguntaID}}").val(respuestaID);

                                                                                        $("#dibuja_{{$tutRespuestaAgrupada->PreguntaID}}").html("")

                                                                                    }else{
                                                                                        $("#Semaforo_{{$tutRespuestaAgrupada->PreguntaID}}").val("");
                                                                                        $("#respuestaData_{{$tutRespuestaAgrupada->PreguntaID}}").val("");
                                                                                        $("#dibuja_{{$tutRespuestaAgrupada->PreguntaID}}").html("")


                                                                                    }
                                                                                });

                                                                            });
                                                                        </script>

                                                                        @if ($vuelta++ == 1)

                                                                        <div id="dibuja_{{$tutRespuestaAgrupada->PreguntaID}}"></div>

                                                                        <input type="hidden" value="" class="noUpperCase" id="Semaforo_{{$tutRespuestaAgrupada->PreguntaID}}" name="Semaforizacion[{{$tutRespuestaAgrupada->PreguntaID}}]">
                                                                        <input type="hidden" value="" class="noUpperCase" id="respuestaData_{{$tutRespuestaAgrupada->PreguntaID}}" name="respuestaData[{{$tutRespuestaAgrupada->PreguntaID}}]">

                                                                        <input type="hidden" name="PreguntaID[]" id="PreguntaID" class="noUpperCase" value="{{$itemPreguntas->PreguntaID}}">
                                                                        <input type="hidden" name="Tipo[]" class="noUpperCase" id="Tipo" value="{{$itemPreguntas->TipoRespuesta}}">
                                                                        <input type="hidden" class="noUpperCase" value="{{$itemCategoria->CategoriaPreguntaID}}" id="CategoriaPreguntaID" name="CategoriaPreguntaID[]">
                                                                        <input type="hidden" class="noUpperCase" value="{{$itemCategoria->NombreCategoria}}" id="NombreCategoria" name="NombreCategoria[]">
                                                                        <input type="hidden" class="noUpperCase" value="{{$itemPreguntas->Descripcion}}" id="DescripcionCategoria" name="DescripcionCategoria[]">

                                                                        @endif

                                                                    @endif

                                                                @endforeach
                                                                @php
                                                                    $vuelta = 1;
                                                                @endphp

                                                                <br>
                                                            @endif
                                                        @endforeach
                                                    @endif


                                                    @if ($itemPreguntas->TipoRespuesta == 1)
                                                        <p><b style="font-style: italic;">{{$itemPreguntas->Nombre}}</b></p>


                                                        @foreach ($tutorias_respuesta_agrupada as $tutRespuestaAgrupada)
                                                            @if ($tutRespuestaAgrupada->PreguntaID == $itemPreguntas->PreguntaID)
                                                                @foreach ($tutRespuestas as $itemRespuesta)
                                                                    @if ($itemRespuesta->PreguntaID == $tutRespuestaAgrupada->PreguntaID)
                                                                        <input type="hidden" class="noUpperCase" value="{{$itemRespuesta->Parcial}}" name="Parcial">
                                                                        <input type="hidden" class="noUpperCase" value="{{$itemRespuesta->RespuestaID}}" name="respuestaID[{{$tutRespuestaAgrupada->PreguntaID}}]">

                                                                        <div class="col s12 m12 l4">
                                                                            <div style="position:relative;">
                                                                                <input type="checkbox" class="noUpperCase"  name="Respuesta[{{$itemRespuesta->RespuestaID}}]" data-semafor="{{$itemRespuesta->Semaforizacion}}" data-respuesta2="{{$itemRespuesta->RespuestaID}}" id="{{$itemRespuesta->RespuestaID}}" value="{{$itemRespuesta->Nombre}}">
                                                                                <label for="{{$itemRespuesta->RespuestaID}}"> {{$itemRespuesta->Nombre}}</label>
                                                                            </div>

                                                                        </div>

                                                                                                                                 


                                                                        <script>
                                                                            $(document).ready(function() {


                                                                                // JS para crear rutinas estilo POWER
                                                                                var valores = []; //Declaramos el Array
                                                                                var checked = [];

                                                                                $("#{{$itemRespuesta->RespuestaID}}").click(function() {

                                                                                    if( $(this).is(':checked') ){

                                                                                        var respuestaIDs = $("#{{$itemRespuesta->RespuestaID}}").data("respuesta2");


                                                                                        var titulo1 = '<input type="hidden" placeholder="'+this.id+'" id="respuestaData'+this.id+'" name="respuestaData[]" value="'+this.id+'" class="form-control"/>';
                                                                                
                                                                                        $('#Modal-Escribir-Rutina').append(titulo1);
                                                                                
                                                                                
                                                                                            
                                                                                    } else {

                                                                                        $("#respuestaData"+this.id).remove();

                                                                                    }

                                                                                    
                                                                                });

                                                                                
                                                                              
                                                                            
                                                                              
                                                                            });                                                                        
                                                                        </script>

                                                                        {{--  @if ($vuelta++ == 1)  --}}

                                                                        <div id="Modal-Escribir-Rutina"></div>

                                                                        <div id="dibuja_{{$tutRespuestaAgrupada->PreguntaID}}"></div>

                                                                        <input type="hidden" value="" class="noUpperCase" id="Semaforo_{{$tutRespuestaAgrupada->PreguntaID}}" name="Semaforizacion[{{$tutRespuestaAgrupada->PreguntaID}}]">
                                                                        {{--  <input type="text" value="" class="noUpperCase" id="respuestaData2_{{$tutRespuestaAgrupada->PreguntaID}}" name="respuestaData[]">  --}}

                                                                        <input type="hidden" name="PreguntaID[]" id="PreguntaID" class="noUpperCase" value="{{$itemPreguntas->PreguntaID}}">
                                                                        <input type="hidden" name="Tipo[]" class="noUpperCase" id="Tipo" value="{{$itemPreguntas->TipoRespuesta}}">
                                                                        <input type="hidden" class="noUpperCase" value="{{$itemCategoria->CategoriaPreguntaID}}" id="CategoriaPreguntaID" name="CategoriaPreguntaID[]">
                                                                        <input type="hidden" class="noUpperCase" value="{{$itemCategoria->NombreCategoria}}" id="NombreCategoria" name="NombreCategoria[]">
                                                                        <input type="hidden" class="noUpperCase" value="{{$itemPreguntas->Descripcion}}" id="DescripcionCategoria" name="DescripcionCategoria[]">

                                                                        {{--  @endif  --}}

                                                                    @endif

                                                                @endforeach
                                                                @php
                                                                    $vuelta = 1;
                                                                @endphp

                                                                <br>
                                                            @endif
                                                        @endforeach
                                                                        
                                                    @endif

                                                    <div class="row"></div>

                                                    @if ($itemPreguntas->TipoRespuesta == 2)
                                                        <p><b style="font-style: italic;">{{$itemPreguntas->Nombre}}</b></p>



                                                        @foreach ($tutorias_respuesta_agrupada as $tutRespuestaAgrupada)
                                                            @if ($tutRespuestaAgrupada->PreguntaID == $itemPreguntas->PreguntaID)
                                                                @foreach ($tutRespuestas as $itemRespuesta)
                                                                    @if ($itemRespuesta->PreguntaID == $tutRespuestaAgrupada->PreguntaID)
                                                                    <input type="hidden" class="noUpperCase" value="{{$itemRespuesta->RespuestaID}}" name="respuestaID[{{$tutRespuestaAgrupada->PreguntaID}}]">


                                                                    <div class="col s12 m12 l12">
                                                                        <input type="text" name="Respuesta[{{$tutRespuestaAgrupada->PreguntaID}}]" id="Respuesta" class="validate noUpperCase">
                                                                    </div>

                                                                    <input type="hidden" value="{{$itemRespuesta->Semaforizacion}} " class="noUpperCase" name="Semaforizacion[{{$tutRespuestaAgrupada->PreguntaID}}]">
                                                                    <input type="hidden" value="{{$itemRespuesta->RespuestaID}}" class="noUpperCase"  name="respuestaData[{{$tutRespuestaAgrupada->PreguntaID}}]">
                                                                    <input type="hidden" name="PreguntaID[]" id="PreguntaID" class="noUpperCase" value="{{$itemPreguntas->PreguntaID}}">
                                                                    <input type="hidden" name="Tipo[]" id="Tipo" class="noUpperCase" value="{{$itemPreguntas->TipoRespuesta}}">
                                                                    <input type="hidden" value="{{$itemCategoria->CategoriaPreguntaID}}" class="noUpperCase" id="CategoriaPreguntaID" name="CategoriaPreguntaID[]">
                                                                    <input type="hidden" value="{{$itemCategoria->NombreCategoria}}" class="noUpperCase" id="NombreCategoria" name="NombreCategoria[]">
                                                                    <input type="hidden" value="{{$itemPreguntas->Descripcion}}" class="noUpperCase" id="DescripcionCategoria" name="DescripcionCategoria[]">

                                                                    @endif
                                                                @endforeach

                                                            <br>
                                                            @endif

                                                        @endforeach
                                                        <br><br>

                                                    @endif

                                                    @if ($itemPreguntas->TipoRespuesta == 3)
                                                        <p><b style="font-style: italic;">{{$itemPreguntas->Nombre}}</b></p>



                                                        @foreach ($tutorias_respuesta_agrupada as $tutRespuestaAgrupada)


                                                            @if ($tutRespuestaAgrupada->PreguntaID == $itemPreguntas->PreguntaID)
                                                                @foreach ($tutRespuestas as $itemRespuesta)
                                                                    @if ($itemRespuesta->PreguntaID == $tutRespuestaAgrupada->PreguntaID)
                                                                        <div class="col s12 m12 l12">
                                                                            <select id="Respuesta" class="browser-default validate select2" name="Respuesta{{$tutRespuestaAgrupada->PreguntaID}}[]" style="width: 100%;">
                                                                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                                                                <option value="{{$itemRespuesta->Nombre}}">{{$itemRespuesta->Nombre}}</option>
                                                                            </select>
                                                                        </div>
                                                                        <input type="hidden" value="{{$itemRespuesta->Semaforizacion}}" class="noUpperCase" name="Semaforizacion[{{$tutRespuestaAgrupada->PreguntaID}}]">
                                                                        <input type="hidden" value="{{$itemRespuesta->RespuestaID}}" class="noUpperCase" name="respuestaData[{{$tutRespuestaAgrupada->PreguntaID}}]">
                                                                        <input type="hidden" name="PreguntaID[]" id="PreguntaID" class="noUpperCase" value="{{$itemPreguntas->PreguntaID}}">
                                                                        <input type="hidden" name="Tipo[]" id="Tipo" class="noUpperCase" value="{{$itemPreguntas->TipoRespuesta}}">
                                                                        <input type="hidden" value="{{$itemCategoria->CategoriaPreguntaID}}" class="noUpperCase" id="CategoriaPreguntaID" name="CategoriaPreguntaID[]">
                                                                        <input type="hidden" value="{{$itemCategoria->NombreCategoria}}" class="noUpperCase" id="NombreCategoria" name="NombreCategoria[]">
                                                                        <input type="hidden" value="{{$itemPreguntas->Descripcion}}" class="noUpperCase" id="DescripcionCategoria" name="DescripcionCategoria[]">


                                                                    @endif
                                                                @endforeach

                                                            <br>
                                                            @endif

                                                        @endforeach
                                                        <br><br>
                                                    @endif


                                                    @if ($itemPreguntas->TipoRespuesta == 4)
                                                        <p><b style="font-style: italic;">{{$itemPreguntas->Nombre}}</b></p>

                                                        @foreach ($tutorias_respuesta_agrupada as $tutRespuestaAgrupada)
                                                        @if ($tutRespuestaAgrupada->PreguntaID == $itemPreguntas->PreguntaID)
                                                            @foreach ($tutRespuestas as $itemRespuesta)
                                                                @if ($itemRespuesta->PreguntaID == $tutRespuestaAgrupada->PreguntaID)
                                                                <input type="hidden" class="noUpperCase" value="{{$itemRespuesta->RespuestaID}}" name="respuestaID[{{$tutRespuestaAgrupada->PreguntaID}}]">


                                                                <div class="col s12 m12 l12">
                                                                    <input type="date" name="Respuesta[{{$tutRespuestaAgrupada->PreguntaID}}]" id="Respuesta" class="validate noUpperCase">
                                                                </div>

                                                                <input type="hidden" value="{{$itemRespuesta->Semaforizacion}} " class="noUpperCase" name="Semaforizacion[{{$tutRespuestaAgrupada->PreguntaID}}]">
                                                                <input type="hidden" value="{{$itemRespuesta->RespuestaID}}" class="noUpperCase"  name="respuestaData[{{$tutRespuestaAgrupada->PreguntaID}}]">
                                                                <input type="hidden" name="PreguntaID[]" id="PreguntaID" class="noUpperCase" value="{{$itemPreguntas->PreguntaID}}">
                                                                <input type="hidden" name="Tipo[]" id="Tipo" class="noUpperCase" value="{{$itemPreguntas->TipoRespuesta}}">
                                                                <input type="hidden" value="{{$itemCategoria->CategoriaPreguntaID}}" class="noUpperCase" id="CategoriaPreguntaID" name="CategoriaPreguntaID[]">
                                                                <input type="hidden" value="{{$itemCategoria->NombreCategoria}}" class="noUpperCase" id="NombreCategoria" name="NombreCategoria[]">
                                                                <input type="hidden" value="{{$itemPreguntas->Descripcion}}" class="noUpperCase" id="DescripcionCategoria" name="DescripcionCategoria[]">

                                                                @endif
                                                            @endforeach

                                                        <br>
                                                        @endif

                                                    @endforeach
                                                        <br><br>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <input type="hidden" class="noUpperCase" name="AlumnoID" id="AlumnoID" value="{{$alumno->AlumnoID}}">
                    <input type="hidden" class="noUpperCase" name="FormularioID" id="FormularioID" value="{{$FormularioID}}">
                    <input type="hidden" class="noUpperCase" name="CarreraID" id="CarreraID" value="{{$alumno->CarreraID}}">
                    <input type="hidden" class="noUpperCase" name="ClaveCarrera" id="ClaveCarrera" value="{{$alumno->ClaveCarrera}}">
                    <input type="hidden" class="noUpperCase" name="Carrera" id="Carrera" value="{{$alumno->Carrera}}">
                    <input type="hidden" class="noUpperCase" name="EscuelaID" id="EscuelaID" value="{{$alumno->EscuelaID}}">
                    <input type="hidden" class="noUpperCase" name="ClaveEscuela" id="ClaveEscuela" value="{{$alumno->ClaveEscuela}}">
                    <input type="hidden" class="noUpperCase" name="Escuela" id="Escuela" value="{{$alumno->Escuela}}">
                    <input type="hidden" class="noUpperCase" name="UniversidadID" id="UniversidadID" value="{{$alumno->UniversidadID}}">
                    <input type="hidden" class="noUpperCase" name="ClaveUniversidad" id="ClaveUniversidad" value="{{$alumno->ClaveUniversidad}}">
                    <input type="hidden" class="noUpperCase" name="Universidad" id="Universidad" value="{{$alumno->Universidad}}">

                </div>
            </div>
            
            <div class="card-action">
                <div>
                    LA UNIVERSIDAD MODELO GARANTIZA QUE DICHA INFORMACIÓN SERÁ RESGUARDADA Y UTILIZADA EXCLUSIVAMENTE PARA LOS FINES QUE EL PROYECTO DE TUTORÍAS 
                    Y ACOMPAÑAMIENTO ESTUDIANTIL PLANTEAN, 
                    LO ANTERIOR CON BASE EN TODOS LOS TÉRMINOS LEGALES QUE LA LEY DE PRIVACIDAD Y DATOS PERSONALES SUGIEREN.
                </div>
                <div>
                    {!! Form::button('<i class="material-icons left">save</i> Guardar', [ 'id'=>'btn-guardar','class' =>
                'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<style>
    #modded {
        .progress {
            min-height: 36px;
            overflow: hidden;
            position: relative;

            span {
                position: relative;
                float: left;
                color: #fff;
                padding: 8px;
                z-index: 99999;

                i {
                    width: inherit;
                    font-size: inherit;
                    position: relative;
                    top: 2px;
                    margin-left: 8px;
                }
            }

            .determinate {
                width: 0;
                transition: width 1s ease-in-out;
                padding: 8px;
                position: relative;
                color: #fff;
                text-align: right;
                white-space: nowrap;
            }
        }

    }

    @keyframes grow {
        from {
            width: 0;
        }
    }
</style>
@endsection

@section('footer_scripts')




@endsection