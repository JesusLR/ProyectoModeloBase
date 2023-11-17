@extends('layouts.dashboard')

@section('template_title')
    Asignar docente
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    {{--  <a href="{{route('primaria_asignar_grupo.index')}}" class="breadcrumb">Lista de Inscritos</a>  --}}
    <a href="{{route('primaria_asignar_cgt.edit')}}" class="breadcrumb">Asignar docente</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'primaria.primaria_asignar_docente.store',
        'method' => 'POST']) !!}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">ASIGNAR DOCENTE A GRUPOS
                    @if ($tipoEmpleado == 'P')
                        , MODALIDAD: PRESENCIAL
                    @endif
                    @if ($tipoEmpleado == 'V')
                        , MODALIDAD: VIRTUAL
                    @endif
                    @if ($tipoEmpleado == 'H')
                        , MODALIDAD: HÍBRIDO
                    @endif
                    @if ($tipoEmpleado == 'M')
                        , MODALIDAD: MIXTO
                    @endif
                    </span>

                {!! Form::hidden('tipoEmpleado', $tipoEmpleado, ['id' => 'tipoEmpleado']) !!}
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

                        {{-- <div class="col s12 m6 l4">
                            {!! Form::label('primaria_grupo_id', 'Grupos *', array('class' => '')); !!}
                            <select id="primaria_grupo_id" class="browser-default validate select2" required name="primaria_grupo_id"
                                style="width: 100%;">
                            </select>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::number('gpoGrado', NULL, array('id' => 'gpoGrado', 'class' => 'validate','required','maxlength'=>'1', 'min' => '1')) !!}
                            {!! Form::label('gpoGrado', 'Grado *', array('class' => '')); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('gpoGrupo', NULL, array('id' => 'gpoGrupo', 'class' => 'validate','required','maxlength'=>'3')) !!}
                            {!! Form::label('gpoGrupo', 'Grupo *', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    {!! Form::button('<i class="material-icons left">search</i> Buscar', ['class' => 'btn-guardar-grupo-buscar btn-large waves-effect  darken-3']) !!}
                </div>

                <div class="row" id="Tabla">
                    <div class="col s12">
                        <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
                        </div>
                    </div>
                    <div id="sinResultado"></div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l6" style="display: none" id="empleado_visible">
                        {!! Form::label('empleado_id', 'Docente *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @forelse ($empleados as $empleado)
                                <option value="{{$empleado->id}}">{{$empleado->empNombre}} {{$empleado->empApellido1}} {{$empleado->empApellido2}}</option>
                            @empty
                                <option value="" selected disabled>NO HAY DATOS PARA MOSTRAR</option>
                            @endforelse

                        </select>
                    </div>
                </div>

            </div>


            <div class="card-action"  id="boton-guardar-oculto" style="display: none">


                {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-guardar-grupo-cgt btn-large waves-effect  darken-3']) !!}

                {{--  {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Cargando datos...";this.form.submit();','class' =>
                'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}  --}}

            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<style>
    table tbody tr:nth-child(odd) {
        background: #F7F8F9;
    }
    table tbody tr:nth-child(even) {
        background: #F1F1F1;
    }
    table th {
      background: #01579B;
      color: #fff;

    }
    table {
      border-collapse: collapse;
      width: 100%;
    }

      .hoverTable{
        width:100%; 
        border-collapse:collapse; 
    }
  
  
    /* Define the hover highlight color for the table row */
    .hoverTable tr:hover {
          background-color: #BFC2C3;
    }
</style>
@endsection

@section('footer_scripts')

@include('primaria.scripts.preferencias')
@include('primaria.scripts.departamentos')
@include('primaria.scripts.escuelas')
@include('primaria.scripts.planes')
@include('primaria.scripts.periodos')
{{--  @include('scripts.cgts')  --}}
@include('primaria.scripts.cursos')
{{--  @include('scripts.inscritos')  --}}
@include('primaria.asignarDocenteCGT.crearTablaJs')
@include('primaria.scripts.programas')



@include('primaria.asignarDocenteCGT.guardarJs')

@endsection
