@extends('layouts.dashboard')

@section('template_title')
    Primaria horarios libres
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_horarios_libres.index')}}" class="breadcrumb">Lista de horarios libres</a>
    <a href="{{url('primaria_horarios_libres/'.$primaria_empleados_horarios->id)}}" class="breadcrumb">Ver horario libre</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">HORARIO LIBRE #{{$primaria_empleados_horarios->id}}</span>

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
                                {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                                <input type="text" value="{{$primaria_empleados_horarios->periodo->departamento->ubicacion->ubiClave.'-'.$primaria_empleados_horarios->periodo->departamento->ubicacion->ubiNombre}}" readonly>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                                <input type="text" value="{{$primaria_empleados_horarios->periodo->departamento->depClave.'-'.$primaria_empleados_horarios->periodo->departamento->depNombre}}" readonly>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                                <input type="text" value="{{$primaria_empleados_horarios->primaria_empleado->escuela->escClave.'-'.$primaria_empleados_horarios->primaria_empleado->escuela->escNombre}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                                <input type="text" value="{{$primaria_empleados_horarios->periodo->perNumero.'-'.$primaria_empleados_horarios->periodo->perAnioPago}}" readonly>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaInicial', $primaria_empleados_horarios->periodo->perFechaInicial, array('id' => 'perFechaInicial', 'readonly')) !!}
                                {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaFinal', $primaria_empleados_horarios->periodo->perFechaFinal, array('id' => 'perFechaFinal', 'readonly')) !!}
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('primaria_empleado_id', 'Docente *', array('class' => '')); !!}
                                <input type="text" value="{{$primaria_empleados_horarios->primaria_empleado->empApellido1.' '.$primaria_empleados_horarios->primaria_empleado->empApellido2.' '.$primaria_empleados_horarios->primaria_empleado->empNombre}}" readonly>
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('primaria_horario_categoria_id', 'Categoría *', array('class' => '')); !!}
                                <input type="text" value="{{$primaria_empleados_horarios->primaria_horario_categoria->categoria}}" readonly>
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('hDia', 'Día *', array('class' => '')); !!}
                                @if ($primaria_empleados_horarios->hDia == 1)
                                    <input type="text" value="LUNES" readonly>
                                @endif       
                                @if ($primaria_empleados_horarios->hDia == 2)
                                    <input type="text" value="MARTES" readonly>
                                @endif
                                @if ($primaria_empleados_horarios->hDia == 3)
                                    <input type="text" value="MIERCOLES" readonly>
                                @endif
                                @if ($primaria_empleados_horarios->hDia == 4)
                                    <input type="text" value="JUEVES" readonly>
                                @endif
                                @if ($primaria_empleados_horarios->hDia == 5)
                                    <input type="text" value="VIERNES" readonly>
                                @endif
                                @if ($primaria_empleados_horarios->hDia == 6)
                                    <input type="text" value="SÁBADO" readonly>
                                @endif
                                @if ($primaria_empleados_horarios->hDia == 7)
                                    <input type="text" value="DOMINGO" readonly>
                                @endif
                            </div>                     
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field col s12 m6 l6">
                                {!! Form::label('hHoraInicio', 'Hora de inicio *', array('class' => '')); !!}
                                <input type="number" name="hHoraInicio" id="hHoraInicio" @if ($primaria_empleados_horarios->hHoraInicio < 10) value="0{{$primaria_empleados_horarios->hHoraInicio}}" @else value="{{$primaria_empleados_horarios->hHoraInicio}}" @endif  min="0" max="23"
                                    required readonly>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                {!! Form::label('gMinInicio', 'Minuto de inicio *', array('class' => '')); !!}
                                <input type="number" name="gMinInicio" id="gMinInicio" value="{{$primaria_empleados_horarios->gMinInicio, old('gMinInicio')}}" min="0" max="59"
                                    required readonly>
                            </div>
                        </div>
                    
                        <div class="col s12 m6 l4">
                            <div class="input-field col s12 m6 l6">
                                {!! Form::label('hFinal', 'Hora de fin *', array('class' => '')); !!}
                                <input readonly type="number" name="hFinal" id="hFinal" @if ($primaria_empleados_horarios->hFinal < 10) value="0{{$primaria_empleados_horarios->hFinal}}" @else value="{{$primaria_empleados_horarios->hFinal}}" @endif min="0" max="23" required>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                {!! Form::label('gMinFinal', 'Minuto de fin *', array('class' => '')); !!}
                                <input readonly type="number" name="gMinFinal" id="gMinFinal" value="{{$primaria_empleados_horarios->gMinFinal, old('gMinFinal')}}" min="0" max="59" required>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')


@endsection
