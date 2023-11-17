@extends('layouts.dashboard')

@section('template_title')
Secundaria Alumnos Restringidos
@endsection

@section('breadcrumbs')
<a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{url('secundaria_alumnos_restringidos')}}" class="breadcrumb">Lista de alumnos restringidos</a>
<a href="{{url('secundaria_alumnos_restringidos/'.$listaNegra->id)}}" class="breadcrumb">Ver alumno restringido</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">ALUMNO RESTRINGIDO #{{$listaNegra->id}}</span>

                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#general">General</a></li>
                            <li class="tab"><a href="#personal">Personal</a></li>
                        </ul>
                    </div>
                </nav>

                {{-- GENERAL BAR--}}
                <div id="general">

                    <div class="row">
                        <div class="col s12 m4">
                            {!! Form::label('alumno_id', 'Alumno *', array('class' => '')); !!}
                            @if($alumno)
                                @php
                                $persona = $alumno->persona;
                                $nombreCompleto = $alumno->aluClave.' - '.$persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2;
                                @endphp
                                <input type="text" value="{{$nombreCompleto}}" readonly>
                            @endif
                        </div>

                        <div class="col s12 m4">
                            {!! Form::label('lnNivel', 'Nivel restricción *', array('class' => '')); !!}
                            <input type="text" value="{{$NivelListaNegra->nlnClave.' '.$NivelListaNegra->nlnDescripcion}}">
                        </div>


                        <div class="col s12 m4">
                            {!! Form::label('lnFecha', 'Fecha restricción *', array('class' => '')); !!}
                            <input type="text" value="{{$fecha}}" readonly id="lnFecha" name="lnFecha" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m4 l12">
                            {!! Form::label('lnRazon', 'Razón restricción *', array('class' => '')); !!}
                            <input type="text" name="lnRazon" id="lnRazon"
                                value="{{old('lnRazon', $listaNegra->lnRazon)}}" readonly required maxlength="255">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection