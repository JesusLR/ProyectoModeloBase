@extends('layouts.dashboard')

@section('template_title')
Primaria planeacion docente
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{url('primaria_planeacion_docente')}}" class="breadcrumb">Lista de planeación docente</a>
<label class="breadcrumb">Agregar planeación docente</label>
@endsection

@section('content')

<style type="text/css">
    input[type="radio"] {
        margin-left: 10px;
    }
</style>
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'primaria.primaria_planeacion_docente.store', 'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">AGREGAR PLANEACIÓN DOCENTE</span>

                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#general">General</a></li>
                            <li class="tab"><a href="#temas">Temas</a></li>

                        </ul>
                    </div>
                </nav>

                {{-- GENERAL BAR--}}
                <div id="general">

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                            <select id="ubicacion_id" class="browser-default validate select2" required
                                name="ubicacion_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($ubicaciones as $ubicacion)
                                @php
                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                $selected = '';
                                if($ubicacion->id == $ubicacion_id){
                                $selected = 'selected';
                                }
                                @endphp
                                <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id" class="browser-default validate select2" required
                                name="departamento_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id" class="browser-default validate select2" required name="escuela_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                            <select id="programa_id" class="browser-default validate select2" required
                                name="programa_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id" class="browser-default validate select2" required name="plan_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('gpoGrado', 'Grado *', array('class' => '')); !!}
                            <select id="gpoGrado" class="browser-default validate select2" required name="gpoGrado"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @for ($i = 1; $i < 7; $i++)
                                    <option value="{{$i}}" {{ old('gpoGrado') == $i ? 'selected' : '' }}>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('primaria_grupo_id', 'Grupo *', array('class' => '')); !!}
                            <select id="primaria_grupo_id" data-grupo-id="{{old('primaria_grupo_id')}}" class="browser-default validate select2" required name="primaria_grupo_id"
                                style="width: 100%;">
                                {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('semana_inicio', 'Semana inicio *', array('class' => '')); !!}
                            <input type="date" name="semana_inicio" id="semana_inicio" required value="{{old('semana_inicio')}}">
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('semana_fin', 'Semana fin *', array('class' => '')); !!}
                            <input type="date" name="semana_fin" id="semana_fin" required value="{{old('semana_fin')}}">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col s12 m6 l4">
                        {!! Form::label('mes', 'Mes *', array('class' => '')); !!}
                            <select id="mes" class="browser-default validate select2" required name="mes" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="Septiembre" {{ old('mes') == "Septiembre" ? 'selected' : '' }}>SEPTIEMBRE</option>
                                <option value="Octubre" {{ old('mes') == "Octubre" ? 'selected' : '' }}>OCTUBRE</option>
                                <option value="Noviembre" {{ old('mes') == "Noviembre" ? 'selected' : '' }}>NOVIEMBRE</option>
                                <option value="Diciembre" {{ old('mes') == "Diciembre" ? 'selected' : '' }}>DICIEMBRE</option>
                                <option value="Enero" {{ old('mes') == "Enero" ? 'selected' : '' }}>ENERO</option>
                                <option value="Febrero" {{ old('mes') == "Febrero" ? 'selected' : '' }}>FEBRERO</option>
                                <option value="Marzo" {{ old('mes') == "Marzo" ? 'selected' : '' }}>MARZO</option>
                                <option value="Abril" {{ old('mes') == "Abril" ? 'selected' : '' }}>ABRIL</option>
                                <option value="Mayo" {{ old('mes') == "Mayo" ? 'selected' : '' }}>MAYO</option>
                                <option value="Junio" {{ old('mes') == "Junio" ? 'selected' : '' }}>JUNIO</option>
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            <label for="frase_mes">Frase del mes *</label>
                            {!! Form::textarea('frase_mes', old('frase_mes'), array('id' => 'observacion_contenido', 'class' => 'validate', 'required',
                            'style' => 'resize: none')) !!} 
                        </div>

                        <div class="col s12 m6 l4">
                            <label for="valor_mes">Valor del mes *</label>
                            {!! Form::textarea('valor_mes', old('valor_mes'), array('id' => 'observacion_contenido', 'class' => 'validate', 'required',
                            'style' => 'resize: none')) !!} 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="norma_urbanidad">Norma de urbanidad *</label>
                            {!! Form::textarea('norma_urbanidad', old('norma_urbanidad'), array('id' => 'observacion_contenido', 'class' => 'validate', 'required',
                            'style' => 'resize: none')) !!} 
                        </div>

                        <div class="col s12 m6 l4">
                            <label for="objetivo_general">Objetivo general *</label>
                            {!! Form::textarea('objetivo_general', old('objetivo_general'), array('id' => 'observacion_contenido', 'class' => 'validate', 'required',
                            'style' => 'resize: none')) !!} 
                        </div>

                        <div class="col s12 m6 l4">
                            <label for="objetivo_particular">Objetivo particular *</label>
                            {!! Form::textarea('objetivo_particular', old('objetivo_particular'), array('id' => 'observacion_contenido', 'class' => 'validate', 'notas_observaciones',
                            'style' => 'resize: none')) !!} 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('bloque', old('bloque'), array('id' => 'bloque', 'required')) !!}
                                {!! Form::label('bloque', 'Bloque *', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <label for="notas_observaciones">Notas/Observaciones *</label>
                            {!! Form::textarea('notas_observaciones', old('notas_observaciones'), array('id' => 'observacion_contenido', 'class' => 'validate', 'required',
                            'style' => 'resize: none')) !!} 
                        </div>
                    </div>
                   

                </div>

                <div id="temas">               
                    <br>
                    <div>
                        <a href="javascript:void(0);" class="agregar-pregunta btn-large waves-effect  darken-3"><i
                                class="material-icons left">add</i>Nuevo</a>
                    </div>
                    <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">TEMA</p>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="tema">Conocimientos (Tema) *</label>
                            {!! Form::textarea('tema[]', old('tema'), array('id' => 'observacion_contenido', 'class' => 'validate', 'required',
                            'style' => 'resize: none')) !!}
                        </div>
                    
                        <div class="col s12 m6 l4">
                            <label for="objetivo">Aprendizaje esperado (objetivo) *</label>
                            {!! Form::textarea('objetivo[]', old('objetivo'), array('id' => 'observacion_contenido', 'class' => 'validate', 'required',
                            'style' => 'resize: none')) !!}
                        </div>
                    
                        <div class="col s12 m6 l4">
                            <label for="estrategias">Estrategias y secuencia didáctica *</label>
                            {!! Form::textarea('estrategias[]', old('estrategias'), array('id' => 'observacion_contenido', 'class' => 'validate', 'required', 'style' => 'resize: none')) !!}
                        </div>

                        
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="libro">Libro *</label>
                            {!! Form::textarea('libro[]', old('libro'), array('id' => 'observacion_contenido', 'class' => 'validate', 'required',
                            'style' => 'resize: none')) !!}
                        </div>

                        <div class="col s12 m6 l4">
                            <label for="habilidad">Habilidad o conocimiento aplicado *</label>
                            {!! Form::textarea('habilidad[]', old('habilidad'), array('id' => 'observacion_contenido', 'class' => 'validate',
                            'required',
                            'style' => 'resize: none')) !!}
                        </div>
                    
                        <div class="col s12 m6 l4">
                            <label for="evaluacion">Evaluación *</label>
                            {!! Form::textarea('evaluacion[]', old('evaluacion'), array('id' => 'observacion_contenido', 'class' => 'validate',
                            'required',
                            'style' => 'resize: none')) !!}
                        </div>
                    </div>
                </div>

                <div class="contenedor-temas">
                        
                </div>
                <div class="card-action">
                    {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large
                    waves-effect darken-3 submit-button','type' => 'submit', 'onclick' => 'this.form.submit(); this.disabled=true;']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    
    @endsection

    @section('footer_scripts')
    @include('primaria.scripts.planes')
    @include('primaria.scripts.periodos')
    @include('primaria.scripts.cursos')
    @include('primaria.scripts.programas')
    @include('primaria.scripts.departamentos')
    @include('primaria.scripts.escuelas')
    @include('primaria.planeacion_docente.grupos')

    <script type="text/javascript">
        $(document).ready(function(){
            var addButton = $('.agregar-pregunta'); // Agregar selector de botón
            var wrapper = $('.contenedor-temas'); // Contenedor de campo de entrada
            var fieldHTML = ''+
            '<div>'+
                '<br>'+
                '<div class="row" style="background-color:#ECECEC;">'+
                    '<p style="text-align: center;font-size:1.2em;">TEMA</p>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col s12 m6 l4">'+
                        '<label for="tema">Conocimientos (Tema) *</label>' +                    
                        '{!! Form::textarea("tema[]", NULL, array("id" => "observacion_contenido", "class" => "validate", "required", "style" => "resize: none")) !!}'+                
                    '</div>'+

                    '<div class="col s12 m6 l4">'+
                        '<label for="objetivo">Aprendizaje esperado (objetivo) *</label>'+
                        '{!! Form::textarea("objetivo[]", NULL, array("id" => "observacion_contenido", "class" => "validate", "required", "style" => "resize: none")) !!} '+
                    '</div>'+

                    '<div class="col s12 m6 l4">'+
                        '<label for="estrategias">Estrategias y secuencia didáctica *</label>'+
                        '{!! Form::textarea("estrategias[]", NULL, array("id" => "observacion_contenido", "class" => "validate", "required", "style" => "resize: none")) !!}'+
                    '</div>'+

                    
                '</div>'+
                '<div class="row">'+
                    '<div class="col s12 m6 l4">'+
                        '<label for="libro">Libro *</label>'+
                        '{!! Form::textarea("libro[]", NULL, array("id" => "observacion_contenido", "class" => "validate", "required", "style" => "resize: none")) !!}'+
                    '</div>'+
                    
                    '<div class="col s12 m6 l4">'+
                        '<label for="habilidad">Habilidad o conocimiento aplicado *</label>'+
                        '{!! Form::textarea("habilidad[]", NULL, array("id" => "observacion_contenido", "class" => "validate", "required", "style" => "resize: none")) !!}' +
                    '</div>'+

                    '<div class="col s12 m6 l4">'+
                        '<label for="evaluacion">Evaluación *</label>'+
                        '{!! Form::textarea("evaluacion[]", NULL, array("id" => "observacion_contenido", "class" => "validate", "required", "style" => "resize: none")) !!}' +
                    '</div>'+
                '</div>'+
                '<a style="width:10px; height:60px; " href="javascript:void(0);" class="remove_button btn-large waves-effect  darken-3"><i class="material-icons center">delete</i></a>'+
                '<br>'+
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