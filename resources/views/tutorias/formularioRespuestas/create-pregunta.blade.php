@extends('layouts.dashboard')

@section('template_title')
Formulario
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_formulario')}}" class="breadcrumb">Lista de formularios</a>
<a href="{{url('tutorias_formulario/create')}}" class="breadcrumb">Agregar formulario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'tutorias_formulario_preguntas.guardarPregunta', 'method'
        => 'POST']) !!}

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">AGREGAR FORMULARIO</span>

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

                    {{-- <br>
                    <a href="#modalNewCat"  dismissible="false" class="btn-modal-respuestas button button--icon js-button js-ripple-effect modal-trigger" title="Ver respuestas">
                        <i class="material-icons">visibility</i>
                        </a> --}}

                    <input type="hidden" name="FormularioID" id="" value="{{$FormularioID}}">
                    <br>
                    <div class="contenedor-preguntas">
                        <div>
                            <a href="javascript:void(0);" class="agregar-pregunta btn-large waves-effect  darken-3"><i
                                    class="material-icons left">add</i>Agregar pregunta</a>
                        </div>
                    </div>

                    <br>

                    <div id="modalNewCat" class="modal modal-fixed-footer" style="max-width:30%;" >
                        <div class="modal-content">
                            <h4>AGREGAR NUEVA CATEGORIA</h4>   
                            
                            <div class="row">
                                <div class="col s12 m6 l4">
                                    <div class="input-field">
                                        {!! Form::text('NombreCategoria', NULL, array('id' => 'NombreCategoria', 'class' => 'validate')) !!}
                                        {!! Form::label('NombreCategoria', 'Nombre *', array('class' => '')); !!}
                                    </div>
                                </div>
                                <div class="col s12 m6 l8">
                                    <div class="input-field">
                                        {!! Form::text('DescripcionCategoria', NULL, array('id' => 'DescripcionCategoria', 'class' => 'validate')) !!}
                                        {!! Form::label('DescripcionCategoria', 'Descripción *', array('class' => '')); !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m6 l4">
                                    <div class="input-field">
                                        <input type="number" name="orden_visual_categoria" id="orden_visual_categoria" min="1" max="100" class="validate">
                                        {!! Form::label('orden_visual_categoria', 'Orden visual de la categoría *', array('class' => '')); !!}
                                    </div>
                                </div>
                            </div>
                    
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-guardar-cat" class="waves-effect darken-3 btn">Guardar</button>
                            <button type="button" class="modal-close waves-effect waves-green btn-flat">Cerrar</button>
                        </div>
                    </div>
                    
                 
                    
                    <style>
                        .modal {
                            max-height: 60%;
                            max-width:35%;
                          }
                    </style>

                    

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
        var addButton = $('.agregar-pregunta'); // Agregar selector de botón
        var wrapper = $('.contenedor-preguntas'); // Contenedor de campo de entrada
        var fieldHTML = ''+
        '<div class="row">'+
            '<div>' +
                '<div class="col s12 m6 l3">'+
                    '<div class="input-field">'+
                        '<input required type="text" onkeyup="accionarLaCosaEsta(this.value)" class="validate noUpperCase" id="NombrePregunta" name="NombrePregunta[]">'+
                        '<label for="NombrePregunta">Pregunta</label>'+
                    '</div>'+                
                '</div>'+
    
                '<div class="col s12 m6 l3">'+
                    '<label for="CategoriaPreguntaID">Categoría</label>'+  
                    '<select required id="CategoriaPreguntaID" class="browser-default validate select2" name="CategoriaPreguntaID[]" style="width: 100%;">'+
                        '<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>'+
                        '@foreach ($categoriaPregunta as $categoria)'+
                        '<option value="{{$categoria->CategoriaPreguntaID}}">{{$categoria->orden_visual_categoria}}-{{$categoria->Nombre}}</option>'+
                        '@endforeach'+                          
                    '</select>'+                                                    
                '</div>'+
    
                '<div class="col s12 m6 l3">'+
                    '<label for="TipoRespuesta">Tipo de respuesta</label>'+ 
                    '<select required id="TipoRespuesta" class="browser-default validate select2" name="TipoRespuesta[]" style="width: 100%;">'+
                        '<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>'+
                        '<option value="0">Opción múltiple</option>'+
                        '<option value="2">Texto</option>'+      
                        '<option value="4">Fecha</option>'+                                                
                    '</select>'+                                                    
                '</div>'+

                '<div class="col s12 m6 l2">'+
                    '<label for="orden_visual_pregunta">Orden visual pregunta *</label>'+ 
                    '<input type="number" min="0" max="100" name="orden_visual_pregunta[]" id="orden_visual_pregunta" required>'+                                           
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

<script>


    function accionarLaCosaEsta(texto){
        if(sonLetrasSolamente(texto) == false){
            $(".agregar-pregunta").hide();
        }else{
            $(".agregar-pregunta").show();
        }
      }
      
      
      function sonLetrasSolamente(texto){
        var regex = /^[a-zA-Z-0-9-¿?.ÓÍÚÜ,:()/""''*+%=!¡ ]+$/;
        return regex.test(texto);
      }  
</script>


<script>
    $(document).ready(function(){
        $('.modal').modal();
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){

        $(document).on("click", "#btn-guardar-cat", function(e) {

            var NombreCategoria = $("#NombreCategoria").val();
            var DescripcionCategoria = $("#DescripcionCategoria").val();
            var orden_visual_categoria = $("#orden_visual_categoria").val();

            e.preventDefault();


            $.ajax({
                url: "{{route('tutorias_formulario_preguntas.AjaxGuardarCategoria')}}",
                method: "POST",
                dataType: "json",
                data: {
                    "_token": $("meta[name=csrf-token]").attr("content"),
                    NombreCategoria: NombreCategoria,
                    DescripcionCategoria: DescripcionCategoria,
                    orden_visual_categoria: orden_visual_categoria
                },
                success: function(data){
                    
                    if(data.res == "true"){
                        swal("Escuela Modelo", "La nueva categoria se ha creado con éxito", "success");
                        $('#modalNewCat').modal('close');

                        $("#CategoriaPreguntaID").load('');


                    }

                    
         
                },
                error: function(){
                    swal("Escuela Modelo", "Error inesperado, intende nuevamente (verique si ha seleccionado todos los campos)", "error");
                }
              });

        });

    });
</script>

@endsection