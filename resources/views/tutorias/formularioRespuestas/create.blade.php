@extends('layouts.dashboard')

@section('template_title')
Respuestas
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_formulario_preguntas/' .$pregunta_formulario->FormularioID)}}" class="breadcrumb">Lista de preguntas</a>
<a href="{{url('tutorias_formulario_preguntas/'.$pregunta_formulario->PreguntaID.'/crear_respuesta')}}" class="breadcrumb">Agregar respuestas</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['tutorias_formulario_preguntas.store', $pregunta_formulario->PreguntaID])) }}

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">AGREGAR RESPUESTAS</span>

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
                    <input type="hidden" name="FormularioID" value="{{$pregunta_formulario->FormularioID}}">
                
                <div class="row">                        
                    <div class="col s12 m6 l12">
                        <p>{{$pregunta_formulario->Nombre}}</p>    
                        <input type="hidden" name="PreguntaID" id="PreguntaID" value="{{$pregunta_formulario->PreguntaID}}">           
                    </div>                    
                </div>
  
                <br>
                @php
                $totalRespuestasActivas = count($respuestas);
                @endphp
                @if ($totalRespuestasActivas > 0)
                <p>Respuestas agregadas</p>
                @foreach ($respuestas as $respuesta)
                <div class="row">
                    <div> 
                        <div class="col s12 m6 l6">
                            <div class="input-field">
                                <input type="text" class="validate" value="{{$respuesta->Nombre}}" readonly="true">
                                <label for="NombrePregunta">Respuesta</label>
                            </div>   
                            {{--  <input type="hidden" name="TipoRespuesta[]" value="{{$pregunta_formulario->TipoRespuesta}}">   --}}
                            {{--  <input type="hidden" name="RespuestaID[]" id="RespuestaID" value="{{$respuesta->RespuestaID}}">             --}}
                            <input type="hidden" class="validate" name="totalRespuestasActivas" value="{{$totalRespuestasActivas}}" readonly="true">

                            
        
                        </div>
        
                        <div class="col s12 m6 l3">
                            <label for="TipoRespuesta">Semaforización</label> 
                            <select required class="browser-default validate" style="width: 100%;pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="0" {{ 0 == $respuesta->Semaforizacion ? 'selected' : '' }}>No aplica</option>
                                <option value="1" {{ 1 == $respuesta->Semaforizacion ? 'selected' : '' }}>Verde</option>          
                                <option value="2" {{ 2 == $respuesta->Semaforizacion ? 'selected' : '' }}>Amarillo</option>                                                   
                                <option value="3" {{ 3 == $respuesta->Semaforizacion ? 'selected' : '' }}>Rojo</option>                                   
                            </select>                                                    
                        </div>
        
                    </div>
                </div>           
                @endforeach   
                @else
                    <label for="">Aun no cuenta con respuestas agregadas para esta pregunta</label>
                @endif
                <br>
  
                <br>
                <div class="field_wrapper">
                    <div>
                        <a href="javascript:void(0);" class="add_button btn-large waves-effect  darken-3"><i class="material-icons left">add</i>Agregar respuesta</a>
                    </div>
                </div> 
                    
                   

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
<script type="text/javascript">
    $(document).ready(function(){
        var addButton = $('.add_button'); // Agregar selector de botón
        var wrapper = $('.field_wrapper'); // Contenedor de campo de entrada
        var fieldHTML = ''+
        '<div class="row">'+
            '<div>' +
                '<div class="col s12 m6 l6">'+
                    '<div class="input-field">'+                        
                        '<input type="text" class="validate noUpperCase" required id="NombreRespuesta" name="NombreRespuesta[]">'+
                        '<label for="NombrePregunta">Respuesta</label>'+
                    '</div>'+   
                    '<input type="hidden" name="TipoRespuesta[]" value="{{$pregunta_formulario->TipoRespuesta}}">'+               
                '</div>'+

                '<div class="col s12 m6 l3">'+
                    '<label for="TipoRespuesta">Semaforización</label>'+ 
                    '<select required id="TipoRespuesta" class="browser-default validate select2" name="Semaforizacion[]" style="width: 100%;">'+
                        '<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>'+
                        '<option value="0">No aplica</option>'+
                        '<option value="1">Verde</option>'+          
                        '<option value="2">Amarillo</option>'+                                                   
                        '<option value="3">Rojo</option>'+                                   
                    '</select>'+                                                    
                '</div>'+

                '<a style="width:10px; height:60px; " href="javascript:void(0);" class="remove_button btn-large waves-effect  darken-3"><i class="material-icons center">delete</i></a>'+
            '</div>' +
        '</div>';
        var x = 1; // El contador de campo inicial es 1
        $(addButton).click(function(){  // Una vez que se hace clic en el botón Agregar
                x++; // Incremento del contador de campo
                $(wrapper).append(fieldHTML); // Agregar campo html            
        });
        $(wrapper).on('click', '.remove_button', function(e){// Una vez que se hace clic en el botón Eliminar
            e.preventDefault();
            $(this).parent('div').remove(); // Eliminar el campo html
            x--; // Disminuir el contador de campo
        });
    });



</script>
@endsection