@extends('layouts.dashboard')

@section('template_title')
    Bachiller curso recuperativo
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_curso_recuperativo')}}" class="breadcrumb">Lista de cursos recuperativos</a>
    <label class="breadcrumb">Ver curso recuperativo</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EXTRAORDINARIO #{{$extraordinario->id}}</span>

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
                            {!! Form::text('ubiClave', $extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->ubiNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('ubiClave', 'Campus', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('departamento_id',$extraordinario->bachiller_materia->plan->programa->escuela->departamento->depClave . " - " . $extraordinario->bachiller_materia->plan->programa->escuela->departamento->depNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('escuela_id', $extraordinario->bachiller_materia->plan->programa->escuela->escNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('periodo_id', $extraordinario->periodo->perNumero.'-'.$extraordinario->periodo->perAnio, array('readonly' => 'true')) !!}
                            {!! Form::label('periodo_id', 'Periodo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', $extraordinario->periodo->perFechaInicial, array('readonly' => 'true')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', $extraordinario->periodo->perFechaFinal, array('readonly' => 'true')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('programa_id', $extraordinario->bachiller_materia->plan->programa->progNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('plan_id', $extraordinario->bachiller_materia->plan->planClave, array('readonly' => 'true')) !!}
                            {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('gpoSemestre', $extraordinario->bachiller_materia->matSemestre, array('readonly' => 'true')) !!}
                            {!! Form::label('gpoSemestre', 'Semestre', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('extGrupo', $extraordinario->extGrupo, array('readonly' => 'true')) !!}
                        {!! Form::label('extGrupo', 'Clave grupo', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field">
                        {!! Form::text('materia_id', $extraordinario->bachiller_materia->matNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('materia_id', 'Materia', ['class' => '']); !!}
                        </div>
                    </div>
                    {{--  <div class="col s12 m6">
                        <div class="input-field">
                        {!! Form::text('aula_id', $extraordinario->aula->aulaClave, array('readonly' => 'true')) !!}
                        {!! Form::label('aula_id', 'Aula', ['class' => '']); !!}
                        </div>
                    </div>  --}}
                </div>
                {{--  <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                        {!! Form::text('optativa_id', ($extraordinario->optativa) ? $extraordinario->optativa->optNombre : NULL, array('readonly' => 'true')) !!}
                        {!! Form::label('optativa_id', 'Optativa', ['class' => '']); !!}
                        </div>
                    </div>
                </div>  --}}
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('extFecha', $extraordinario->extFecha, array('readonly' => 'true')) !!}
                            {!! Form::label('extFecha', 'Fecha examen', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('extHora', $extraordinario->extHora, array('readonly' => 'true')) !!}
                            {!! Form::label('extHora', 'Hora examen', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('extPago', $extraordinario->extPago, array('readonly' => 'true')) !!}
                            {!! Form::label('extPago', 'Costo Examen', ['class' => '']); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroFolio', $extraordinario->extNumeroFolio, array('readonly' => 'true')) !!}
                        {!! Form::label('extNumeroFolio', 'Número de folio *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroActa', $extraordinario->extNumeroActa, array('readonly' => 'true')) !!}
                        {!! Form::label('extNumeroActa', 'Número de acta *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroLibro', $extraordinario->extNumeroLibro, array('readonly' => 'true')) !!}
                        {!! Form::label('extNumeroLibro', 'Número de libro *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extAlumnosInscritos', $extraordinario->extAlumnosInscritos, array('readonly' => 'true')) !!}
                        {!! Form::label('extAlumnosInscritos', 'Alumnos inscritos *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Lunes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioLunes', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioLunes', $extraordinario->extHoraInicioLunes, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinLunes', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinLunes', $extraordinario->extHoraFinLunes, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaLunes">Aula *</label>
                            <input type="text" name="extAulaLunes" id="extAulaLunes" maxlength="3" value="{{$extraordinario->extAulaLunes}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Martes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioMartes', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioMartes', $extraordinario->extHoraInicioMartes, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinMartes', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinMartes', $extraordinario->extHoraFinMartes, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaMartes">Aula *</label>
                            <input type="text" name="extAulaMartes" id="extAulaMartes" maxlength="3" value="{{$extraordinario->extAulaMartes}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Miércoles</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioMiercoles', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioMiercoles', $extraordinario->extHoraInicioMiercoles, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinMiercoles', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinMiercoles', $extraordinario->extHoraFinMiercoles, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaMiercoles">Aula *</label>
                            <input type="text" name="extAulaMiercoles" id="extAulaMiercoles" maxlength="3" value="{{$extraordinario->extAulaMiercoles}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Jueves</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioJueves', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioJueves', $extraordinario->extHoraInicioJueves, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinJueves', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinJueves', $extraordinario->extHoraFinJueves, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaJueves">Aula *</label>
                            <input type="text" name="extAulaJueves" id="extAulaJueves" maxlength="3" value="{{$extraordinario->extAulaJueves}}" readonly>
                        </div>
                    </div>
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Viernes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioViernes', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioViernes', $extraordinario->extHoraInicioViernes, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinViernes', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinViernes', $extraordinario->extHoraFinViernes, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaViernes">Aula *</label>
                            <input type="text" name="extAulaViernes" id="extAulaViernes" maxlength="3" value="{{$extraordinario->extAulaViernes}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sábado</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSabado', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSabado', $extraordinario->extHoraInicioSabado, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinSabado', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinSabado', $extraordinario->extHoraFinSabado, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaSabado">Aula *</label>
                            <input type="text" name="extAulaSabado" id="extAulaSabado" maxlength="3" value="{{$extraordinario->extAulaSabado}}" readonly>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 1</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion01', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion01', $extraordinario->extFechaSesion01, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion01', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion01', $extraordinario->extHoraInicioSesion01, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion01">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion01" id="extHoraFinSesion01" maxlength="3" value="{{$extraordinario->extHoraFinSesion01}}" readonly> 
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 2</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion02', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion02', $extraordinario->extFechaSesion02, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion02', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion02', $extraordinario->extHoraInicioSesion02, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion02">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion02" id="extHoraFinSesion02" maxlength="3" value="{{$extraordinario->extHoraFinSesion02}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 3</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion03', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion03', $extraordinario->extFechaSesion03, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion03', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion03', $extraordinario->extHoraInicioSesion03, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion03">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion03" id="extHoraFinSesion03" maxlength="3" value="{{$extraordinario->extHoraFinSesion03}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 4</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion04', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion04', $extraordinario->extFechaSesion04, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion04', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion04', $extraordinario->extHoraInicioSesion04, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion04">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion04" id="extHoraFinSesion04" maxlength="3" value="{{$extraordinario->extHoraFinSesion04}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 5</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion05', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion05', $extraordinario->extFechaSesion05, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion05', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion05', $extraordinario->extHoraInicioSesion05, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion05">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion05" id="extHoraFinSesion05" maxlength="3" value="{{$extraordinario->extHoraFinSesion05}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 6</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion06', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion06', $extraordinario->extFechaSesion06, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion06', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion06', $extraordinario->extHoraInicioSesion06, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion06">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion06" id="extHoraFinSesion06" maxlength="3" value="{{$extraordinario->extHoraFinSesion06}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 7</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion07', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion07', $extraordinario->extFechaSesion07, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion07', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion07', $extraordinario->extHoraInicioSesion07, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion07">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion07" id="extHoraFinSesion07" maxlength="3" value="{{$extraordinario->extHoraFinSesion07}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 8</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion08', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion08', $extraordinario->extFechaSesion08, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion08', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion08', $extraordinario->extHoraInicioSesion08, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion08">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion08" id="extHoraFinSesion08" maxlength="3" value="{{$extraordinario->extHoraFinSesion08}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 9</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion09', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion09', $extraordinario->extFechaSesion09, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion09', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion09', $extraordinario->extHoraInicioSesion09, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion09">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion09" id="extHoraFinSesion09" maxlength="3" value="{{$extraordinario->extHoraFinSesion09}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 10</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion10', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion10', $extraordinario->extFechaSesion10, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion10', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion10', $extraordinario->extHoraInicioSesion10, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion10">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion10" id="extHoraFinSesion10" maxlength="3" value="{{$extraordinario->extHoraFinSesion10}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 11</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion11', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion11', $extraordinario->extFechaSesion11, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion11', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion11', $extraordinario->extHoraInicioSesion11, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion11">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion11" id="extHoraFinSesion11" maxlength="3" value="{{$extraordinario->extHoraFinSesion11}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 12</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion12', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion12', $extraordinario->extFechaSesion12, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion12', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion12', $extraordinario->extHoraInicioSesion12, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion12">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion12" id="extHoraFinSesion12" maxlength="3" value="{{$extraordinario->extHoraFinSesion12}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 13</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion13', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion13', $extraordinario->extFechaSesion13, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion13', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion13', $extraordinario->extHoraInicioSesion13, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion13">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion13" id="extHoraFinSesion13" maxlength="3" value="{{$extraordinario->extHoraFinSesion13}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 14</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion14', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion14', $extraordinario->extFechaSesion14, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion14', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion14', $extraordinario->extHoraInicioSesion14, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion14">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion14" id="extHoraFinSesion14" maxlength="3" value="{{$extraordinario->extHoraFinSesion14}}" readonly>
                    </div>
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 15</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion15', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion15', $extraordinario->extFechaSesion15, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion15', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion15', $extraordinario->extHoraInicioSesion15, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion15">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion15" id="extHoraFinSesion15" maxlength="3" value="{{$extraordinario->extHoraFinSesion15}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 16</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion16', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion16', $extraordinario->extFechaSesion16, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion16', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion16', $extraordinario->extHoraInicioSesion16, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion16">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion16" id="extHoraFinSesion16" maxlength="3" value="{{$extraordinario->extHoraFinSesion16}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 17</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion17', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion17', $extraordinario->extFechaSesion17, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion17', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion17', $extraordinario->extHoraInicioSesion17, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion17">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion17" id="extHoraFinSesion17" maxlength="3" value="{{$extraordinario->extHoraFinSesion17}}" readonly>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 18</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion18', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion18', $extraordinario->extFechaSesion18, array('readonly' => 'true')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion18', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion18', $extraordinario->extHoraInicioSesion18, array('readonly' => 'true')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion18">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion18" id="extHoraFinSesion18" maxlength="3" value="{{$extraordinario->extHoraFinSesion18}}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field">
                            {!! Form::text('empleado_id', $extraordinario->bachiller_empleado->empNombre.' '.$extraordinario->bachiller_empleado->empApellido1.''.$extraordinario->bachiller_empleado->empApellido2, array('readonly' => 'true')) !!}
                            {!! Form::label('empleado_id', 'Docente', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="input-field">
                            {!! Form::text('empleado_sinodal_id', (
                                $extraordinario->empleadoSinodal) ?
                                    $extraordinario->empleadoSinodal->persona->perNombre
                                    . ' ' . $extraordinario->empleadoSinodal->persona->perApellido1
                                    . ' ' . $extraordinario->empleadoSinodal->persona->perApellido2
                                : NULL, ['readonly' => 'true']) !!}
                            {!! Form::label('empleado_sinodal_id', 'Sinodal', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
            </div>

          </div>
        </div>
    </div>
  </div>

@endsection
