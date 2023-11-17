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
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'tutorias_formulario.store', 'method' => 'POST']) !!}

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
  
                    
                    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('Tipo', 'Tipo *', array('class' => '')); !!}
                            <select required id="Tipo" class="browser-default validate select2" name="Tipo" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="1" {{ old('Tipo') == 1 ? 'selected' : '' }}>FORMATO DE ENTREVISTA INICIAL</option>
                                <option value="2" {{ old('Tipo') == 2 ? 'selected' : '' }}>TUTORÍA</option>
                                <option value="3" {{ old('Tipo') == 2 ? 'selected' : '' }}>SEGUIMIENTO Y EVOLUCION COVID</option>
                                
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('Parcial', 'Parcial *', array('class' => '')); !!}
                            <select required id="Parcial" class="browser-default validate select2" name="Parcial" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="1" {{ old('Parcial') == 1 ? 'selected' : '' }}>Parcial 1</option>
                                <option value="2" {{ old('Parcial') == 2 ? 'selected' : '' }}>Parcial 2</option>
                                <option value="3" {{ old('Parcial') == 3 ? 'selected' : '' }}>Parcial 3</option>
                                <option value="4" {{ old('Parcial') == 4 ? 'selected' : '' }}>Parcial 4</option>
                                <option value="5" {{ old('Parcial') == 5 ? 'selected' : '' }}>Parcial 5</option>
                                <option value="6" {{ old('Parcial') == 6 ? 'selected' : '' }}>Parcial 6</option>                                
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('Nombre', NULL, array('id' => 'Nombre', 'class' => 'validate noUpperCase', 'required')) !!}                            
                                {!! Form::label('Nombre', 'Nombre *', array('class' => '')); !!}
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l6">
                            <div class="input-field">                                
                                {!! Form::textarea('Descripcion', NULL, array('id' => 'Descripcion', 'class' =>
                                'materialize-textarea validate noUpperCase','required', 'rows'=>'5')) !!}                                                         
                                {!! Form::label('Descripcion', 'Descripción *', array('class' => '')); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            <div class="input-field">                                
                                {!! Form::textarea('Instruccion', NULL, array('id' => 'Instruccion', 'class' =>
                                'materialize-textarea validate noUpperCase','required', 'rows'=>'5')) !!}                                                         
                                {!! Form::label('Instruccion', 'Instrucción *', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l6">
                            {!! Form::label('FechaInicioVigencia', 'Fecha inicio de vigencia *', array('class' => '')); !!}
                            {!! Form::date('FechaInicioVigencia', NULL, array('id' => 'FechaInicioVigencia', 'class' => 'validate', 'required')) !!}                            
                        </div>  

                        <div class="col s12 m6 l6">
                            {!! Form::label('FechaFinVigencia', 'Fecha fin de vigencia *', array('class' => '')); !!}
                            {!! Form::date('FechaFinVigencia', NULL, array('id' => 'FechaFinVigencia', 'class' => 'validate', 'required')) !!}                            
                        </div> 
                    </div>


                    <div class="field_wrapper">
                        <div>
                            <a href="javascript:void(0);" class="add_button btn-large waves-effect  darken-3"><i class="material-icons left">add</i>Agregar pregunta</a>
                        </div>
                    </div>       
                   
                    <br>


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
                '<div class="col s12 m6 l3">'+
                    '<div class="input-field">'+
                        '<input required type="text" onkeyup="accionarLaCosaEsta(this.value)" class="validate" id="NombrePregunta" name="NombrePregunta[]">'+
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
                    '<label for="TipoRespuesta">Tipo de respuesta *</label>'+ 
                    '<select required id="TipoRespuesta" class="browser-default validate select2" name="TipoRespuesta[]" style="width: 100%;">'+
                        '<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>'+
                        '<option value="0">Opción múltiple</option>'+
                        '<option value="1">Opción múltiple (varias al mismo tiempo)</option>'+
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
            $(".add_button").hide();
        }else{
            $(".add_button").show();
        }
      }
      
      
      function sonLetrasSolamente(texto){
        var regex = /^[a-zA-Z-0-9-¿?.ÓÍÚÜ,:()/""''*+%=!¡ ]+$/;
        return regex.test(texto);
      }  
</script>

@endsection