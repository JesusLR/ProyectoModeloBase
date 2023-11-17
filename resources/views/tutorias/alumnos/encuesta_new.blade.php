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

@php
use App\Http\Helpers\Utils;

$contador1 = 1;
$contador2 = 1;
$contador3 = 1;
$contador4 = 1;
$contador5 = 1;
$contador6 = 1;
$contador7 = 1;
$contador8 = 1;
$contador9 = 1;
$contador10 = 1;
$contador11 = 1;
@endphp

<div class="row">
    @if(count($categoria_respuestas_alumnos) <= 0)
        <div class="col s12 ">
            {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'tutorias_encuestas.store', 'method' => 'POST']) !!}

            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">RESPONDER ENCUESTA - {{$tutorias_formulario->Nombre}}</span>

                    <div class="row personalizado" style="border-radius: 2px;">
                        <div class="col s12 m6 l6 personalizado">
                            <p><strong>Fecha inicio de vigencia:</strong> {{Utils::fecha_string($tutorias_formulario->FechaInicioVigencia, $tutorias_formulario->FechaInicioVigencia)}}</p>
                        </div>
                        <div class="col s12 m6 l6 personalizado">
                            <p><strong>Fecha fin de vigencia:</strong> {{Utils::fecha_string($tutorias_formulario->FechaFinVigencia, $tutorias_formulario->FechaFinVigencia)}}</p>
                        </div>
                    </div>

                    <br>

                    <input type="hidden" class="noUpperCase" name="AlumnoID" id="AlumnoID" value="{{$alumno->AlumnoID}}">
                    <input type="hidden" class="noUpperCase" name="FormularioID" id="FormularioID" value="{{$tutorias_formulario->FormularioID}}">
                    <input type="hidden" class="noUpperCase" value="{{$tutorias_formulario->Parcial}}" name="Parcial">
                    <input type="hidden" class="noUpperCase" name="CarreraID" id="CarreraID" value="{{$alumno->CarreraID}}">
                    <input type="hidden" class="noUpperCase" name="ClaveCarrera" id="ClaveCarrera" value="{{$alumno->ClaveCarrera}}">
                    <input type="hidden" class="noUpperCase" name="Carrera" id="Carrera" value="{{$alumno->Carrera}}">
                    <input type="hidden" class="noUpperCase" name="EscuelaID" id="EscuelaID" value="{{$alumno->EscuelaID}}">
                    <input type="hidden" class="noUpperCase" name="ClaveEscuela" id="ClaveEscuela" value="{{$alumno->ClaveEscuela}}">
                    <input type="hidden" class="noUpperCase" name="Escuela" id="Escuela" value="{{$alumno->Escuela}}">
                    <input type="hidden" class="noUpperCase" name="UniversidadID" id="UniversidadID" value="{{$alumno->UniversidadID}}">
                    <input type="hidden" class="noUpperCase" name="ClaveUniversidad" id="ClaveUniversidad" value="{{$alumno->ClaveUniversidad}}">
                    <input type="hidden" class="noUpperCase" name="Universidad" id="Universidad" value="{{$alumno->Universidad}}">

                    <input type="hidden" class="noUpperCase" name="ACCION" id="ACCION" value="GUARDAR">


                    {{-- GENERAL BAR--}}
                    <div id="general">
                        
                        <div class="row">
                        

                            <ul class="collapsible popout" data-collapsible="accordion">
                                @forelse ($categorias_grupo as $CategoriaPreguntaID => $valores_categoria)
                                    @foreach ($valores_categoria as $categoria)
                                        @if ($CategoriaPreguntaID == $categoria->CategoriaPreguntaID && $contador1++ == 1)
                                            <li>
                                                <div class="active collapsible-header" id="">
                                                    <i class="material-icons">question_answer</i><b>CATEGORÍA - {{$categoria->Nombre_Categoria}}</b>
                                                </div>
                                                <div class="collapsible-body">                                                
                                                    @forelse ($pregunta_grupo as $PreguntaID => $valores_preguntas)
                                                        @foreach ($valores_preguntas as $pregunta)
                                                            @if ($PreguntaID == $pregunta->PreguntaID && $CategoriaPreguntaID == $pregunta->CategoriaPreguntaID && $contador2++ == 1)
                                                                <div class="row">
                                                                    <p style="text-align: left;"><b style="font-style: italic;">{{$pregunta->Nombre_Pregunta}}</b></p>

                                                                    @forelse ($tutorias_respuestas_grupo as $RespuestaID => $valores_Respuesta)
                                                                        @foreach ($valores_Respuesta as $respuesta)
                                                                            @if ($RespuestaID == $respuesta->RespuestaID && $CategoriaPreguntaID == $respuesta->CategoriaPreguntaID && $PreguntaID == $respuesta->PreguntaID)
                                                                                <br>

                                                                                {{--  respuestas tipo opción multiple   --}}                                                                          
                                                                                @if ($respuesta->Tipo_Respuesta == 0)                                                                            
                                                                                    <div class="col s12 m12 l12">
                                                                                        <div style="position:relative;">
                                                                                            <input type="radio" class="noUpperCase" checked name="Respuesta[{{$PreguntaID}}]" data-semafor="{{$respuesta->Semaforizacion_Respuesta}}" data-respuesta="{{$respuesta->RespuestaID}}" id="{{$respuesta->RespuestaID}}" value="{{$respuesta->Nombre_Respuesta}}">
                                                                                            <label for="{{$respuesta->RespuestaID}}"> {{$respuesta->Nombre_Respuesta}}</label>
                                                                                        </div>        
                                                                                    </div>


                                                                                    <script>
                                                                                        $(document).ready(function(){
            
            
                                                                                            if($("#{{$respuesta->RespuestaID}}").is(':checked')) {
                                                                                                    var semafor = $("#{{$respuesta->RespuestaID}}").data("semafor");
                                                                                                    var respuestaID = $("#{{$respuesta->RespuestaID}}").data("respuesta");
            
            
                                                                                                    $("#Semaforo_{{$respuesta->PreguntaID}}").val(semafor);
                                                                                                    $("#respuestaData_{{$respuesta->PreguntaID}}").val(respuestaID);
                                                                                            } else {
                                                                                                $("#Semaforo_{{$respuesta->PreguntaID}}").val("");
                                                                                                $("#respuestaData_{{$respuesta->PreguntaID}}").val("0");
            
                                                                                                $("#dibuja_{{$respuesta->PreguntaID}}").html("<input type='hidden' class='noUpperCase' name='Respuesta[{{$respuesta->PreguntaID}}]' value='Pendiente por responder'>")
            
                                                                                            }
            
            
                                                                                            $("#{{$respuesta->RespuestaID}}").click(function() {
                                                                                                if($("#{{$respuesta->RespuestaID}}").is(':checked')) {
            
                                                                                                    var semafor = $("#{{$respuesta->RespuestaID}}").data("semafor");
                                                                                                    var respuestaID = $("#{{$respuesta->RespuestaID}}").data("respuesta");
            
            
                                                                                                    $("#Semaforo_{{$respuesta->PreguntaID}}").val(semafor);
                                                                                                    $("#respuestaData_{{$respuesta->PreguntaID}}").val(respuestaID);
            
                                                                                                    $("#dibuja_{{$respuesta->PreguntaID}}").html("")
            
                                                                                                }else{
                                                                                                    $("#Semaforo_{{$respuesta->PreguntaID}}").val("");
                                                                                                    $("#respuestaData_{{$respuesta->PreguntaID}}").val("");
                                                                                                    $("#dibuja_{{$respuesta->PreguntaID}}").html("")
            
            
                                                                                                }
                                                                                            });
            
                                                                                        });
                                                                                    </script>

                                                                                    @if ($contador3++ == 1)
                                                                                        <input type="hidden" class="noUpperCase" value="hola" id="Semaforo_{{$respuesta->PreguntaID}}" name="Semaforizacion[{{$respuesta->PreguntaID}}]">
                                                                                        <input type="hidden" value="" class="noUpperCase" id="respuestaData_{{$respuesta->PreguntaID}}" name="respuestaData[{{$respuesta->PreguntaID}}]">
                                                                                        <input type="hidden" name="Tipo_Respuesta[]" class="noUpperCase" id="Tipo_Respuesta" value="{{$respuesta->Tipo_Respuesta}}">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$CategoriaPreguntaID}}" id="CategoriaPreguntaID" name="CategoriaPreguntaID[]">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Nombre_Categoria}}" id="NombreCategoria" name="NombreCategoria[]">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Descripcion_Categoria}}" id="DescripcionCategoria" name="DescripcionCategoria[]">

                                                                                    @endif
                                                                                @endif


                                                                                @if ($respuesta->Tipo_Respuesta == 1)
                                                                                {{-- en validacion  --}}
                                                                                @endif

                                                                                {{--  Tipo de respuesta campo abierto   --}}
                                                                                @if ($respuesta->Tipo_Respuesta == 2)
                                                                                    <div class="col s12 m12 l12">
                                                                                        <input type="text" name="Respuesta[{{$respuesta->PreguntaID}}]" id="Respuesta" class="validate noUpperCase">
                                                                                    </div>

                                                                                    @if ($contador4++ == 1)
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Semaforizacion_Respuesta}}" id="Semaforo_{{$respuesta->PreguntaID}}" name="Semaforizacion[{{$respuesta->PreguntaID}}]">
                                                                                        <input type="hidden" value="{{$respuesta->RespuestaID}}" class="noUpperCase" id="respuestaData_{{$respuesta->PreguntaID}}" name="respuestaData[{{$respuesta->PreguntaID}}]">
                                                                                        <input type="hidden" name="Tipo_Respuesta[]" class="noUpperCase" id="Tipo_Respuesta" value="{{$respuesta->Tipo_Respuesta}}">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$CategoriaPreguntaID}}" id="CategoriaPreguntaID" name="CategoriaPreguntaID[]">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Nombre_Categoria}}" id="NombreCategoria" name="NombreCategoria[]">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Descripcion_Categoria}}" id="DescripcionCategoria" name="DescripcionCategoria[]">

                                                                                    @endif
                                                                                @endif


                                                                                {{--  tipo respuesta select  --}}
                                                                                @if ($respuesta->Tipo_Respuesta == 3)
                                                                                    <div class="col s12 m12 l12">
                                                                                        <select id="Respuesta" class="browser-default validate select2" name="Respuesta{{$respuesta->PreguntaID}}[]" style="width: 100%;">
                                                                                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                                                                            <option value="{{$respuesta->Nombre}}">{{$respuesta->Nombre}}</option>
                                                                                        </select>
                                                                                    </div>

                                                                                    @if ($contador5++ == 1)
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Semaforizacion_Respuesta}}" id="Semaforo_{{$respuesta->PreguntaID}}" name="Semaforizacion[{{$respuesta->PreguntaID}}]">
                                                                                        <input type="hidden" value="{{$respuesta->RespuestaID}}" class="noUpperCase" id="respuestaData_{{$respuesta->PreguntaID}}" name="respuestaData[{{$respuesta->PreguntaID}}]">
                                                                                        <input type="hidden" name="Tipo_Respuesta[]" class="noUpperCase" id="Tipo_Respuesta" value="{{$respuesta->Tipo_Respuesta}}">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$CategoriaPreguntaID}}" id="CategoriaPreguntaID" name="CategoriaPreguntaID[]">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Nombre_Categoria}}" id="NombreCategoria" name="NombreCategoria[]">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Descripcion_Categoria}}" id="DescripcionCategoria" name="DescripcionCategoria[]">

                                                                                    @endif
                                                                                @endif
                                                                            

                                                                                {{--  tipo fecha   --}}
                                                                                @if ($respuesta->Tipo_Respuesta == 4)
                                                                                    <div class="col s12 m12 l12">
                                                                                        <input type="date" name="Respuesta[{{$respuesta->PreguntaID}}]" id="Respuesta" class="validate noUpperCase">
                                                                                    </div>
                                                                                

                                                                                    @if ($contador6++ == 1)
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Semaforizacion_Respuesta}}" id="Semaforo_{{$respuesta->PreguntaID}}" name="Semaforizacion[{{$respuesta->PreguntaID}}]">
                                                                                        <input type="hidden" value="{{$respuesta->RespuestaID}}" class="noUpperCase" id="respuestaData_{{$respuesta->PreguntaID}}" name="respuestaData[{{$respuesta->PreguntaID}}]">
                                                                                        <input type="hidden" name="Tipo_Respuesta[]" class="noUpperCase" id="Tipo_Respuesta" value="{{$respuesta->Tipo_Respuesta}}">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$CategoriaPreguntaID}}" id="CategoriaPreguntaID" name="CategoriaPreguntaID[]">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Nombre_Categoria}}" id="NombreCategoria" name="NombreCategoria[]">
                                                                                        <input type="hidden" class="noUpperCase" value="{{$respuesta->Descripcion_Categoria}}" id="DescripcionCategoria" name="DescripcionCategoria[]">

                                                                                    @endif
                                                                                @endif
                                                                            @endif                                                                                                                                          
                                                                        @endforeach  
                                                                                                                                
                                                                    @empty
                                                                        
                                                                    @endforelse
                                                                </div>
                                                            @endif    
                                                            @php
                                                                $contador3 = 1;
                                                                $contador4 = 1;
                                                                $contador5 = 1;
                                                                $contador6 = 1;
                                                            @endphp                                                    
                                                        @endforeach
                                                        @php
                                                            $contador2 = 1;
                                                        @endphp  
                                                    @empty
                                                        
                                                    @endforelse
                                                </div>
                                            </li>
                                            <br> {{-- Separamos acordion--}}
                                        @endif
                                    @endforeach       
                                    @php
                                        $contador1 = 1;
                                    @endphp                          
                                @empty
                                    
                                @endforelse
                            </ul>
                        </div>

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
    @else
        <div class="col s12 ">
            {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'tutorias_encuestas.store', 'method' => 'POST']) !!}

            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="card ">
                <div class="card-content ">
                    <span class="card-title">EDITAR ENCUESTA - {{$tutorias_formulario->Nombre}}</span>

                    <div class="row personalizado" style="border-radius: 2px;">
                        <div class="col s12 m6 l6 personalizado">
                            <p><strong>Fecha inicio de vigencia:</strong> {{Utils::fecha_string($tutorias_formulario->FechaInicioVigencia, $tutorias_formulario->FechaInicioVigencia)}}</p>
                        </div>
                        <div class="col s12 m6 l6 personalizado">
                            <p><strong>Fecha fin de vigencia:</strong> {{Utils::fecha_string($tutorias_formulario->FechaFinVigencia, $tutorias_formulario->FechaFinVigencia)}}</p>
                        </div>
                    </div>

                    <br>

                    <input type="hidden" class="noUpperCase" name="AlumnoID" id="AlumnoID" value="{{$alumno->AlumnoID}}">
                    <input type="hidden" class="noUpperCase" name="FormularioID" id="FormularioID" value="{{$tutorias_formulario->FormularioID}}">
                    <input type="hidden" class="noUpperCase" value="{{$tutorias_formulario->Parcial}}" name="Parcial">
                    <input type="hidden" class="noUpperCase" name="CarreraID" id="CarreraID" value="{{$alumno->CarreraID}}">
                    <input type="hidden" class="noUpperCase" name="ClaveCarrera" id="ClaveCarrera" value="{{$alumno->ClaveCarrera}}">
                    <input type="hidden" class="noUpperCase" name="Carrera" id="Carrera" value="{{$alumno->Carrera}}">
                    <input type="hidden" class="noUpperCase" name="EscuelaID" id="EscuelaID" value="{{$alumno->EscuelaID}}">
                    <input type="hidden" class="noUpperCase" name="ClaveEscuela" id="ClaveEscuela" value="{{$alumno->ClaveEscuela}}">
                    <input type="hidden" class="noUpperCase" name="Escuela" id="Escuela" value="{{$alumno->Escuela}}">
                    <input type="hidden" class="noUpperCase" name="UniversidadID" id="UniversidadID" value="{{$alumno->UniversidadID}}">
                    <input type="hidden" class="noUpperCase" name="ClaveUniversidad" id="ClaveUniversidad" value="{{$alumno->ClaveUniversidad}}">
                    <input type="hidden" class="noUpperCase" name="Universidad" id="Universidad" value="{{$alumno->Universidad}}">

                    <input type="hidden" name="ACCION" id="ACCION" value="ACTUALIZAR">


                    {{-- GENERAL BAR--}}
                    <div id="general">

                        <div class="row">                        

                            <ul class="collapsible popout" data-collapsible="accordion">
                                @forelse ($categorias_grupo_respondido as $CategoriaPreguntaID => $valores_categoria)
                                    @foreach ($valores_categoria as $categoria)
                                        @if ($CategoriaPreguntaID == $categoria->CategoriaPreguntaID && $contador1++ == 1)

                                        <li>
                                            <div class="active collapsible-header" id="">
                                                <i class="material-icons">question_answer</i><b>CATEGORÍA - {{$categoria->NombreCategoria_Respondido}}</b>
                                            </div>
                                            <div class="collapsible-body">                                                
                                                @foreach ($pregunta_grupo_respondido as $PreguntaID => $valores_pregunta)
                                                    @foreach ($valores_pregunta as $pregunta)
                                                        @if ($PreguntaID == $pregunta->PreguntaID_Respondido && $CategoriaPreguntaID == $pregunta->CategoriaPreguntaID)
                                                            <p style="text-align: left;"><b style="font-style: italic;">{{$pregunta->Nombre_Pregunta}}</b></p>

                                                            @if ($pregunta->Tipo_Respondido == 2)
                                                            <input class="noUpperCase" type="text" value="{{$pregunta->Respuesta_Respondido}}" name="Respuesta[{{$pregunta->PreguntaRespuestaID}}]" id="">
                                                            {{--  <input class="noUpperCase" type="hidden" name="Tipo[]" id="Tipo" value="{{$respuestas->TipoRespuesta}}">  --}}
                                                            {{--  <input class="noUpperCase" type="hidden" value="{{$respuestas->PreguntaRespuestaID}}" name="PreguntaRespuestaID[]">  --}}
                                                            {{--  <input class="noUpperCase" type="hidden" value="{{$respuestas->NombreCategoria}}" id="NombreCategoria" name="NombreCategoria[]">  --}}
                                                            {{--  <input class="noUpperCase" type="hidden" value="{{$respuestas->RespuestaID}}" id="RespuestaID" name="RespuestaID[{{$respuestas->PreguntaRespuestaID}}]">  --}}
                                                            {{--  <input class="noUpperCase" type="hidden" name="PreguntaID[]" id="PreguntaID" value="{{$respuestas->PreguntaID}}">  --}}
                                                            {{--  <input class="noUpperCase" type="hidden" value="{{$respuestas->CategoriaID}}" id="CategoriaID" name="CategoriaID[]">  --}}
                                                            {{--  <input class="noUpperCase" type="hidden" value="{{$respuestas->DescripcionCategoria}}" id="DescripcionCategoria" name="DescripcionCategoria[]">  --}}
                                                            {{--  <input class="noUpperCase" type="hidden" value="{{$respuestas->Semaforizacion}}" name="Semaforizacion[{{$respuestas->PreguntaID}}]">  --}}
                                                            {{--  <input class="noUpperCase" type="hidden" value="{{$respuestas->RespuestaID}}" id="respuestaData_{{$respuestas->PreguntaID}}" name="respuestaData[{{$respuestas->PreguntaID}}]">  --}}
                                                            @endif

                                                            @if ($pregunta->Tipo_Respondido == 4)

                                                                <input class="noUpperCase" type="date" value="{{$pregunta->Respuesta_Respondido}}" name="Respuesta[{{$pregunta->PreguntaRespuestaID}}]" id="">
                                                                


                                                            @endif


                                                            @if ($pregunta->Tipo_Respondido == 0)
                                                                @forelse ($tutorias_respuestas_grupo as $RespuestaID => $valores_Respuesta)
                                                                    @foreach ($valores_Respuesta as $respuesta)
                                                                        @if ($RespuestaID == $respuesta->RespuestaID && $CategoriaPreguntaID == $respuesta->CategoriaPreguntaID && $PreguntaID == $respuesta->PreguntaID)
                                                                            {{--  <br>  --}}
                                                                            <div class="col s12 m12 l12">
                                                                                <div style="position:relative;">
                                                                                    <input type="radio" class="noUpperCase" checked name="Respuesta[{{$PreguntaID}}]" data-semafor="{{$respuesta->Semaforizacion_Respuesta}}" data-respuesta="{{$respuesta->RespuestaID}}" id="{{$respuesta->RespuestaID}}" value="{{$respuesta->Nombre_Respuesta}}">
                                                                                    <label for="{{$respuesta->RespuestaID}}"> {{$respuesta->Nombre_Respuesta}} -- {{$respuesta->Semaforizacion_Respuesta}}</label>
                                                                                </div>        
                                                                            </div>  
                                                                            <br>                                                                          
                                                                        @endif          
                                                                        
                                                                        
                                                                        @if ($pregunta->RespuestaID_Respondido == $respuesta->RespuestaID)
                                                                            {{-- esta script es cuando se carga la pagina y valida los ID de las respuestas guardadas --}}
                                                                            <script>
                                                                                $(document).ready(function(){

                                                                                    $("#{{$pregunta->RespuestaID_Respondido}}").prop("checked", true);


                                                                                    if($("#{{$pregunta->RespuestaID_Respondido}}").is(':checked')) {
                                                                                            var semaforo = $("#{{$pregunta->RespuestaID_Respondido}}").data("semaforo");
                                                                                            var respuestaID = $("#{{$pregunta->RespuestaID_Respondido}}").data("respuesta");



                                                                                            //Dibujamos los inputs donde hay Id guardados
                                                                                        $("#dibuja_sema{{$respuesta->PreguntaID}}").html('<input class="noUpperCase" type="hidden" value="'+semaforo+'" id="Semaforo_{{$respuesta->PreguntaID}}" name="Semaforizacion[{{$pregunta->PreguntaID}}]">');
                                                                                        $("#dibuja_{{$respuesta->PreguntaID}}").html('<input class="noUpperCase" type="hidden" value="'+respuestaID+'" id="respuestaData_{{$respuesta->PreguntaID}}" name="respuestaData[{{$pregunta->PreguntaID}}]">');
                                                                                    } else {
                                                                                        $("#Semaforo_{{$respuesta->PreguntaID}}").val("0");
                                                                                        $("#respuestaData_{{$respuesta->PreguntaID}}").val("0");
                                                                                    }


                                                                                });
                                                                            </script>
                                                                        @endif
                                                                    @endforeach  
                                                                                                                        
                                                                @empty                                                           
                                                                
                                                                    
                                                                @endforelse
                                                                {{--  <div style="position:relative;">
                                                                    <input type="radio" class="noUpperCase" name="Respuesta[{{$pregunta->PreguntaRespuestaID}}]" data-semaforo="{{$pregunta->Semaforizacion_Respondido}}" data-respuesta="{{$pregunta->RespuestaID_Respondido}}"
                                                                     id="{{$pregunta->RespuestaID_Respondido}}" value="{{$pregunta->Respuesta_Respondido}}">
                                                                    <label for="{{$pregunta->RespuestaID_Respondido}}"> {{$pregunta->Respuesta_Respondido}}</label>
                                                                </div>  --}}

                                                            @endif
                                                        @endif
                                                    @endforeach                                                    
                                                @endforeach
                                            </div>
                                        </li>
                                        <br> {{-- Separamos acordion--}}           

                                            
                                            
                                                                                        
                                        @endif
                                    @endforeach
                                    @php
                                        $contador1 = 1;
                                    @endphp
                                @empty
                                    
                                @endforelse
                            </ul>

                        </div>
                        

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
    @endif
   
</div>

@endsection

@section('footer_scripts')

<script>
    $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
          // the name of the box is retrieved using the .attr() method
          // as it is assumed and expected to be immutable
          var group = "input:checkbox[name='" + $box.attr("name") + "']";
          // the checked state of the group/box on the other hand will change
          // and the current value is retrieved using .prop() method
          $(group).prop("checked", false);
          $box.prop("checked", true);

        } else {
          $box.prop("checked", false);
        }
      });
</script>




@endsection
