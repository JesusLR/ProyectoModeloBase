@extends('layouts.dashboard')

@section('template_title')
Respuestas
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_factores_riesgo/')}}" class="breadcrumb">Lista de preguntas</a>
<a href="{{url('tutorias_tutorias/'.$alumno->AlumnoID.'/create')}}" class="breadcrumb">Agregar respuestas</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'tutorias_tutorias.store', 'method' => 'POST']) !!}

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">AGREGAR TUTOR</span>

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
                        <div class="col s6 m6 l4">
                            <p id="Alumnoseleccionado"><strong>Alumno(a)</strong> {{$alumno->Nombre}} {{$alumno->ApellidoPaterno}} {{$alumno->ApellidoMaterno}}</p>
                            <input type="hidden" name="AlumnoID" id="AlumnoID" value="{{$alumno->AlumnoID}}">
                            <br>
                            <input type="hidden" name="FormularioID" id="FormularioID" value="{{$alumno->FormularioID}}">
                            <p><strong>Formulario:</strong> {{$alumno->nombreFormulario}}</p>
                            <p id="nombreFormulario"></p>
                        </div>
                        <div class="col s6 m6 l8">
                            <div class="row">
                                <h6>LLene los campos para poder crear la tutoría, es necesario seleccionar un tutor. </h6>
                                <div class="col s12 m12 l12">
                                    <div class="input-field">
                                        <input type="text" class="validate" name="Titulo" value="{{old('Titulo')}}">
                                        <label for="NombrePregunta">Título para la tutoría *</label>
                                    </div> 
                                </div>
                                <div class="col s12 m12 l12">
                                    <label for="TutorID">Tutor *</label> 
                                    <select required name="TutorID" class="browser-default select2" style="width: 100%;">
                                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                        @foreach ($tutores as $tutor)
                                            <option value="{{$tutor->TutorID}}" {{ old('TutorID') == $tutor->TutorID ? 'selected' : '' }}>{{$tutor->Nombre}} {{$tutor->ApellidoPaterno}} {{$tutor->ApellidoMaterno}}</option>
                                        @endforeach                                                 
                                    </select>   
                                    <br><br>
                                </div>
                                
                                <div class="col s12 m12 l12">
                                    <label for="FechaInicio">Fecha de inicio *</label> 
                                    <input type="date" class="validate" name="FechaInicio" value="{{old('FechaInicio')}}">
                                </div>
            
                                <div class="col s12 m12 l12">
                                    <label for="FechaFin">Fecha de fin *</label> 
                                    <input type="date" class="validate" name="FechaFin" value="{{old('FechaFin')}}">
                                </div>
                            </div>
                        </div>

                        @foreach ($categorias as $categoria)
                            <input type="hidden" name="CategoriaID[]" value="{{$categoria->CategoriaID}}" id="">
                            <input type="hidden" name="NombreCategoria[]" value="{{$categoria->NombreCategoria}}" id="">
                            <input type="hidden" name="DescripcionCategoria[]" value="{{$categoria->DescripcionCategoria}}" id="">
                        @endforeach
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

@endsection