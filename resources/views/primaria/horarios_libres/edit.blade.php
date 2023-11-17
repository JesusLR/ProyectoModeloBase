@extends('layouts.dashboard')

@section('template_title')
    Primaria horarios libres
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_horarios_libres.index')}}" class="breadcrumb">Lista de horarios libres</a>
    <a href="{{url('primaria_horarios_libres/'.$primaria_empleados_horarios->id.'/edit')}}" class="breadcrumb">Editar horario libre</a>
@endsection

@section('content')
<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['primaria.primaria_horarios_libres.update', $primaria_empleados_horarios->id])) }}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">EDITAR HORARIO LIBRE #{{$primaria_empleados_horarios->id}}</span>

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
                            <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;" data-ubicacion-id="{{old('ubicacion_id')}}">
                                <option value="{{$primaria_empleados_horarios->periodo->departamento->ubicacion->id}}">{{$primaria_empleados_horarios->periodo->departamento->ubicacion->ubiClave.'-'.$primaria_empleados_horarios->periodo->departamento->ubicacion->ubiNombre}}</option>
                                
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                            <select id="departamento_id" class="browser-default validate select2" required
                                name="departamento_id" style="width: 100%;" data-departamento-id="{{old('departamento_id')}}">
                                <option value="{{$primaria_empleados_horarios->periodo->departamento->id}}">{{$primaria_empleados_horarios->periodo->departamento->depClave.'-'.$primaria_empleados_horarios->periodo->departamento->depNombre}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                            <select id="escuela_id" class="browser-default validate select2" required name="escuela_id"
                                style="width: 100%;" data-escuela-id="{{old('escuela_id')}}">
                                <option value="{{$primaria_empleados_horarios->primaria_empleado->escuela->id}}">{{$primaria_empleados_horarios->primaria_empleado->escuela->escClave.'-'.$primaria_empleados_horarios->primaria_empleado->escuela->escNombre}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id"
                                style="width: 100%;" data-periodo-id="{{old('periodo_id')}}">
                                <option value="{{$primaria_empleados_horarios->periodo->id}}">{{$primaria_empleados_horarios->periodo->perNumero.'-'.$primaria_empleados_horarios->periodo->perAnioPago}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaInicial', $primaria_empleados_horarios->periodo->perFechaInicial, array('id' => 'perFechaInicial', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('perFechaFinal', $primaria_empleados_horarios->periodo->perFechaFinal, array('id' => 'perFechaFinal', 'class' =>
                                'validate','readonly')) !!}
                                {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('primaria_empleado_id', 'Docente *', array('class' => '')); !!}
                            <select id="primaria_empleado_id" class="browser-default validate select2" required name="primaria_empleado_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach ($primaria_empleados as $empleado)
                                    <option value="{{$empleado->id}}" {{ $primaria_empleados_horarios->primaria_empleado_id == $empleado->id ? 'selected' : '' }}>{{$empleado->empApellido1.' '.$empleado->empApellido2.' '.$empleado->empNombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('primaria_horario_categoria_id', 'Categoría *', array('class' => '')); !!}
                            <select id="primaria_horario_categoria_id" class="browser-default validate select2" required name="primaria_horario_categoria_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach ($horario_categorias as $categoria)
                                    <option value="{{$categoria->id}}" {{ $primaria_empleados_horarios->primaria_horario_categoria_id == $categoria->id ? 'selected' : '' }}>{{$categoria->categoria}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('hDia', 'Día *', array('class' => '')); !!}
                            <select id="hDia" class="browser-default validate select2" required name="hDia" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="1" {{ $primaria_empleados_horarios->hDia == 1 ? 'selected' : '' }}>LUNES</option>
                                <option value="2" {{ $primaria_empleados_horarios->hDia == 2 ? 'selected' : '' }}>MARTES</option>
                                <option value="3" {{ $primaria_empleados_horarios->hDia == 3 ? 'selected' : '' }}>MIERCOLES</option>
                                <option value="4" {{ $primaria_empleados_horarios->hDia == 4 ? 'selected' : '' }}>JUEVES</option>
                                <option value="5" {{ $primaria_empleados_horarios->hDia == 5 ? 'selected' : '' }}>VIERNES</option>
                                <option value="6" {{ $primaria_empleados_horarios->hDia == 6 ? 'selected' : '' }}>SÁBADO</option>
                                <option value="7" {{ $primaria_empleados_horarios->hDia == 7 ? 'selected' : '' }}>DOMIMNO</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field col s12 m6 l6">
                                {!! Form::label('hHoraInicio', 'Hora de inicio *', array('class' => '')); !!}
                                <input type="number" name="hHoraInicio" id="hHoraInicio" @if ($primaria_empleados_horarios->hHoraInicio < 10) value="0{{$primaria_empleados_horarios->hHoraInicio}}" @else value="{{$primaria_empleados_horarios->hHoraInicio}}" @endif  min="0" max="23"
                                    required>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                {!! Form::label('gMinInicio', 'Minuto de inicio *', array('class' => '')); !!}
                                <input type="number" name="gMinInicio" id="gMinInicio" value="{{$primaria_empleados_horarios->gMinInicio, old('gMinInicio')}}" min="0" max="59"
                                    required>
                            </div>
                        </div>
                    
                        <div class="col s12 m6 l4">
                            <div class="input-field col s12 m6 l6">
                                {!! Form::label('hFinal', 'Hora de fin *', array('class' => '')); !!}
                                <input type="number" name="hFinal" id="hFinal" @if ($primaria_empleados_horarios->hFinal < 10) value="0{{$primaria_empleados_horarios->hFinal}}" @else value="{{$primaria_empleados_horarios->hFinal}}" @endif min="0" max="23" required>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                {!! Form::label('gMinFinal', 'Minuto de fin *', array('class' => '')); !!}
                                <input type="number" name="gMinFinal" id="gMinFinal" value="{{$primaria_empleados_horarios->gMinFinal, old('gMinFinal')}}" min="0" max="59" required>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>           

            <div class="card-action">
                <button class="btn-large waves-effect darken-3" type="submit" onclick="this.form.submit(); this.disabled=true;">Guardar<i class="material-icons left">save</i></button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('footer_scripts')


<script>
    document.querySelectorAll('input[type=number]')
    .forEach(e => e.oninput = () => {
        // Always 2 digits
        if (e.value.length >= 2) e.value = e.value.slice(0, 2);
       
    });
</script>


@endsection
