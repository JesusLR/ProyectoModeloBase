@extends('layouts.dashboard')

@section('template_title')
Respuestas
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_formulario_preguntas/'.$pregunta_formulario->FormularioID)}}" class="breadcrumb">Lista de preguntas</a>
<a href="{{url('tutorias_formulario_preguntas/'.$pregunta_formulario->PreguntaID . '/edit')}}" class="breadcrumb">Editar pregunta y respuestas</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['tutorias_formulario_preguntas.update', $pregunta_formulario->PreguntaID])) }}

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">EDITAR FORMULARIO #{{$pregunta_formulario->PreguntaID}}</span>

                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#general">General</a></li>
                        </ul>
                    </div>
                </nav>

                {{-- GENERAL BAR--}}
                <div id="general">           
  
                    
                    
                    <div class="row">                           

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('Nombre', $pregunta_formulario->Nombre, array('id' => 'Nombre', 'class' => 'validate noUpperCase')) !!}                            
                                {!! Form::label('Nombre', 'Pregunta *', array('class' => '')); !!}
                            </div>
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <input type="number" min="1" max="100" name="orden_visual_pregunta" id="orden_visual_pregunta" value="{{$pregunta_formulario->orden_visual_pregunta}}">
                                {!! Form::label('orden_visual_pregunta', 'Orden visual pregunta *', array('class' => '')); !!}
                            </div>
                        </div>

                        
                        {{--  <div class="col s12 m6 l4" style="border-width: 1px; border-style: solid; border-color: #D9D6D5; -moz-border-radius: 15px; -webkit-border-radius: 15px;">
                            <label for="">Mostrar respuesta en la encuesta *</label>
                            <br>
                            <div class="col s12 m6 l3">
                                <div style="position:relative;">
                                    <input type="radio" class="noUpperCase"  name="estatusPregunta" id="estatusPreguntaSI" value="1" {{$pregunta_formulario->Estatus == 1 ? 'checked' : '' }} >
                                    <label style="color: #000" for="estatusPreguntaSI">SI</label>
                                </div>
                            </div>
                            <div class="col s12 m6 l3">
                                <div style="position:relative;">
                                    <input type="radio" class="noUpperCase" name="estatusPregunta" id="estatusPreguntaNO" value="0" {{$pregunta_formulario->Estatus == 0 ? 'checked' : '' }} >
                                    <label style="color: #000" for="estatusPreguntaNO">NO</label>
                                </div>
                            </div>
                        </div>  --}}

                        <div class="col s12 m6 l4">                              
                            {!! Form::label('Estatus','Estatus *', array('class' => '')); !!}                                       
                            <div class="switch">
                                <label>                                    
                                    <input  type="checkbox" class="check estatusDelaPregunta">
                                    <span class="lever"></span>
                                    <label for="Estatus" id="txtEstatus">Activo</label>
                                </label>
                            </div>
                        </div>
                        <input id="estatusPregunta" name="estatusPregunta" type="hidden" >

                     
                    </div>

              
                    <input type="hidden" name="FormularioID" value="{{$pregunta_formulario->FormularioID}}">


                    
                    @php
                        $totalRespuestas = count($respuestas);
                    @endphp
                    @if ($pregunta_formulario->TipoRespuesta == 0)
                        @if ($totalRespuestas > 0)
                        <p>Respuestas</p>
                            @foreach ($respuestas as $respuesta)
                            <div class="row">
                                <div> 
                                    <div class="col s12 m6 l6">
                                        <div class="input-field">
                                            <input type="text" class="validate noUpperCase" value="{{$respuesta->Nombre}}" required id="NombreRespuesta" name="NombreRespuesta[]">
                                            <label for="NombrePregunta">Respuesta</label>
                                        </div>   
                                        {{--  <input type="hidden" name="TipoRespuesta[]" value="{{$pregunta_formulario->TipoRespuesta}}">   --}}
                                        <input type="hidden" name="RespuestaID[]" id="RespuestaID" value="{{$respuesta->RespuestaID}}">           
                    
                                    </div>
                    
                                    <div class="col s12 m6 l3">
                                        <label for="TipoRespuesta">Semaforización</label> 
                                        <select required id="TipoRespuesta" class="browser-default validate" name="Semaforizacion[]" style="width: 100%;">
                                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                            <option value="0" {{ 0 == $respuesta->Semaforizacion ? 'selected' : '' }}>No aplica</option>
                                            <option value="1" {{ 1 == $respuesta->Semaforizacion ? 'selected' : '' }}>Verde</option>          
                                            <option value="2" {{ 2 == $respuesta->Semaforizacion ? 'selected' : '' }}>Amarillo</option>                                                   
                                            <option value="3" {{ 3 == $respuesta->Semaforizacion ? 'selected' : '' }}>Rojo</option>                                   
                                        </select>                                                    
                                    </div>


                                    <div class="col s12 m6 l3">                              
                                        {!! Form::label('txt_respuesta','Estatus *', array('class' => '')); !!}                                       
                                        <div class="switch">
                                            <label>                                    
                                                <input  type="checkbox" class="check_respuesta_{{$respuesta->RespuestaID}}">
                                                <span class="lever"></span>
                                                <label for="txt_respuesta" id="estatusSI_{{$respuesta->RespuestaID}}">Activo</label>
                                            </label>
                                        </div>
                                    </div>

                                    @if ($respuesta->estatus == "SI")
                                    <script>
                                        $(".check_respuesta_{{$respuesta->RespuestaID}}").prop("checked", true);
                                        $("#txt_respuesta").html('Activo');
                                        $("#estatus_{{$respuesta->RespuestaID}}").val("SI");

                                    </script>    
                                    @else
                                    <script>
                                        $(".check_respuesta_{{$respuesta->RespuestaID}}").prop("checked", false);
                                        $("#txt_respuesta").html('Inactivo');
                                        $("#estatus_{{$respuesta->RespuestaID}}").val("NO");

                                    </script> 
                                    @endif
                                    <script>
                                        $('.check_respuesta_{{$respuesta->RespuestaID}}').on('change', function() {

                                            if ($(this).is(':checked') ) {
                                                $("#estatus_{{$respuesta->RespuestaID}}").val("SI");
                                                $("#txt_respuesta").html('Activo');
                                    
                                            } else {
                                                $("#txt_respuesta").html('Inactivo');            
                                                $("#estatus_{{$respuesta->RespuestaID}}").val("NO");
                                    
                                            }
                                        });
                                    </script>
                                    <input id="estatus_{{$respuesta->RespuestaID}}" value="{{$respuesta->estatus}}" name="estatus[{{$respuesta->RespuestaID}}]" type="hidden" >

                                    {{--  <div class="col s12 m6 l3" style="border-width: 1px; border-style: solid; border-color: #D9D6D5; -moz-border-radius: 15px; -webkit-border-radius: 15px;">
                                        <label for="">Mostrar respuesta en la encuesta *</label>
                                        <br>
                                        <div class="col s12 m6 l3">
                                            <div style="position:relative;">
                                                <input type="radio" class="noUpperCase"  name="estatus[{{$respuesta->RespuestaID}}]" id="estatusSI_{{$respuesta->RespuestaID}}" value="SI" {{$respuesta->estatus == "SI" ? 'checked' : '' }}>
                                                <label style="color: #000" for="estatusSI_{{$respuesta->RespuestaID}}">SI</label>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l3">
                                            <div style="position:relative;">
                                                <input type="radio" class="noUpperCase" name="estatus[{{$respuesta->RespuestaID}}]" id="estatusNO_{{$respuesta->RespuestaID}}" value="NO" {{$respuesta->estatus == "NO" ? 'checked' : '' }}>
                                                <label style="color: #000" for="estatusNO_{{$respuesta->RespuestaID}}">NO</label>
                                            </div>
                                        </div>
                                    </div>  --}}
                    
                                </div>
                            </div>           
                            @endforeach   
                        @else
                            <label for="">Aun no cuenta con respuestas agregadas para esta pregunta</label>
                        @endif
                    @endif
                                   
                   
                    
                   

                </div>
            </div>
            <div class="card-action">
                {!! Form::button('<i class="material-icons left">save</i> Guardar', [ 'id'=>'btn-guardar','class' =>
                'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>



@endsection

@section('footer_scripts')


@if ($pregunta_formulario->Estatus == 1)
<script>
    $(".check").prop("checked", true);
    $("#txtEstatus").html('Activo');
    $("#estatusPregunta").val(1);

</script>    
@else
<script>
    $(".check").prop("checked", false);
    $("#txtEstatus").html('Inactivo');
    $("#estatusPregunta").val(0);

</script> 
@endif

<script>
    $('.estatusDelaPregunta').on('change', function() {
        if ($(this).is(':checked') ) {
            $("#estatusPregunta").val(1);
            $("#txtEstatus").html('Activo');

        } else {
            $("#txtEstatus").html('Inactivo');            
            $("#estatusPregunta").val(0);

        }
    });
</script>


@endsection