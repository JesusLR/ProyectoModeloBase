@extends('layouts.dashboard')

@section('template_title')
    Bachiller fecha de captura calificaciones
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_fecha_publicacion_calificacion_alumno.index')}}" class="breadcrumb">Lista fechas de captura calificaciones</a>
    <a href="{{url('bachiller_fecha_publicacion_calificacion_alumno/'.$bachiller_calendario_calificaciones_alumnos->id.'/edit')}}" class="breadcrumb">Editar fecha de captura calificacion alumno</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {{ Form::open(['enctype' => 'multipart/form-data', 'method'=>'PUT','route' => ['bachiller.bachiller_fecha_publicacion_calificacion_alumno.update', $bachiller_calendario_calificaciones_alumnos->id]]) }}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">EDITAR FECHA DE CAPTURA DE CALIFICACION ALUMNO</span>

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
                                <option value="{{$ubicaciones->id}}">{{$ubicaciones->ubiClave.'-'.$ubicaciones->ubiNombre}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id" class="browser-default validate select2" required
                                name="departamento_id" style="width: 100%;">
                                <option value="{{$departamento->id}}">{{$departamento->depClave.'-'.$departamento->depNombre}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id" class="browser-default validate select2" required name="escuela_id"
                                style="width: 100%;">
                                <option value="{{$escuela->id}}">{{$escuela->escClave.'-'.$escuela->escNombre}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" required name="periodo_id"
                                style="width: 100%;">
                                <option value="{{$periodo->id}}">{{$periodo->perNumero.'-'.$periodo->perAnioPago}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaInicial', $periodo->perFechaInicial, array('id' => 'perFechaInicial', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaFinal', $periodo->perFechaFinal, array('id' => 'perFechaFinal', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                            <select id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" required
                                name="programa_id" style="width: 100%;">
                                <option value="{{$programa->id}}">{{$programa->progClave.'-'.$programa->progNombre}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                            <select id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" required name="plan_id"
                                style="width: 100%;">
                                <option value="{{$planes->id}}">{{$planes->planClave}}</option>
                            </select>
                        </div>          

                        <div class="col s12 m6 l4">
                            {!! Form::label('bachiller_mes_evaluaciones_id', 'Mes evaluación *', array('class' => '')); !!}
                            <select id="bachiller_mes_evaluaciones_id" data-plan-id="{{old('bachiller_mes_evaluaciones_id')}}" class="browser-default validate select2" required name="bachiller_mes_evaluaciones_id"
                                style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach ($bachiller_mes_evaluaciones as $mes_evaluacion)
                                    <option value="{{$mes_evaluacion->id}}" {{ $mes_evaluacion->id == $bachiller_calendario_calificaciones_alumnos->bachiller_mes_evaluaciones_id ? 'selected' : '' }}>{{$mes_evaluacion->mes}}</option>
                                @endforeach
                            </select>
                        </div>                
                    </div>

                    <br>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('calPublicacion', 'Fecha publicación calificación *', ['class' => '']); !!}
                            {!! Form::date('calPublicacion', \Carbon\Carbon::parse($bachiller_calendario_calificaciones_alumnos->calPublicacion)->format('Y-m-d'), array('id' => 'calPublicacion', 'class' => 'validate')) !!}
                        </div>

                    </div>

                </div>

                
            </div>

            

            <div class="card-action">
                {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Actualizando datos...";this.form.submit();','class' =>
                'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('footer_scripts')


@endsection
