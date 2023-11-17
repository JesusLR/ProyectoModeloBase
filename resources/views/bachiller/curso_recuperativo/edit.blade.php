@extends('layouts.dashboard')

@section('template_title')
    Bachiller extraordinario
@endsection

@section('head')
    {!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_extraordinario')}}" class="breadcrumb">Lista de extraordinario</a>
    <label class="breadcrumb">Editar extraordinario</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['bachiller_extraordinario.update', $extraordinario->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR EXTRAORDINARIO #{{$extraordinario->id}}</span>

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
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                             <option value="{{$extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->id}}">{{$extraordinario->bachiller_materia->plan->programa->escuela->departamento->ubicacion->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->plan->programa->escuela->departamento->id}}">
                                {{$extraordinario->bachiller_materia->plan->programa->escuela->departamento->depClave}}
                                {{"-"}}
                                {{$extraordinario->bachiller_materia->plan->programa->escuela->departamento->depNombre}}
                            </option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->plan->programa->escuela->id}}">{{$extraordinario->bachiller_materia->plan->programa->escuela->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                                <option value="{{$extraordinario->periodo->id}}">{{$extraordinario->periodo->perNumero}}-{{$extraordinario->periodo->perAnio}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perFechaInicial', $extraordinario->periodo->perFechaInicial, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perFechaFinal', $extraordinario->periodo->perFechaFinal, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->plan->programa->id}}">{{$extraordinario->bachiller_materia->plan->programa->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->plan->id}}">{{$extraordinario->bachiller_materia->plan->planClave}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoSemestre', 'Semestre *', array('class' => '')); !!}
                        <select id="gpoSemestre" class="browser-default validate select2" required name="gpoSemestre" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->matSemestre}}">{{$extraordinario->bachiller_materia->matSemestre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('extGrupo', $extraordinario->extGrupo, array('id' => 'extGrupo', 'class' => 'validate','maxlength' => '3')) !!}
                        {!! Form::label('extGrupo', 'Clave grupo', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('materia_id', 'Materia *', array('class' => '')); !!}
                        <select id="materia_id" class="browser-default validate select2" required name="materia_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia->id}}">{{$extraordinario->bachiller_materia->matClave}}-{{$extraordinario->bachiller_materia->matNombre}}</option>
                        </select>
                    </div>
                    {{--  <div class="col s12 m6">
                            {!! Form::label('aula_id', 'Aula', array('class' => '')); !!}
                            <select id="aula_id" class="browser-default validate select2" name="aula_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($aulas as $aula)
                                    <option value="{{$aula->id}}" @if($extraordinario->aula_id == $aula->id) {{ 'selected' }} @endif>{{$aula->aulaClave}}</option>
                                @endforeach
                            </select>
                        </div>  --}}
                </div>
                {{--  <div id="seccion_optativa" class="row">
                    <div class="col s12 ">
                        {!! Form::label('optativa_id', 'Optativa', array('class' => '')); !!}
                        <select id="optativa_id" class="browser-default validate select2" name="optativa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @if($extraordinario->optativa)
                                <option value="{{$extraordinario->optativa->id}}" selected>{{$extraordinario->optativa->optNombre}}</option>
                            @endif
                        </select>
                    </div>
                </div>  --}}
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFecha', 'Fecha examen', array('class' => '')); !!}
                        {!! Form::date('extFecha', $extraordinario->extFecha, array('id' => 'extFecha', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHora', 'Hora examen', array('class' => '')); !!}
                        {!! Form::time('extHora', $extraordinario->extHora, array('id' => 'extHora', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extPago', $extraordinario->extPago, array('id' => 'extPago', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==8) return false;"')) !!}
                        {!! Form::label('extPago', 'Costo Examen', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroFolio', $extraordinario->extNumeroFolio, array('id' => 'extNumeroFolio', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extNumeroFolio', 'Número de folio *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroActa', $extraordinario->extNumeroActa, array('id' => 'extNumeroActa', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extNumeroActa', 'Número de acta *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroLibro', $extraordinario->extNumeroLibro, array('id' => 'extNumeroLibro', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extNumeroLibro', 'Número de libro *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extAlumnosInscritos', $extraordinario->extAlumnosInscritos, array('id' => 'extAlumnosInscritos', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
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
                        {!! Form::time('extHoraInicioLunes', $extraordinario->extHoraInicioLunes, array('id' => 'extHoraInicioLunes', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinLunes', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinLunes', $extraordinario->extHoraFinLunes, array('id' => 'extHoraFinLunes', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaLunes">Aula *</label>
                            <input type="text" name="extAulaLunes" id="extAulaLunes" maxlength="3" value="{{$extraordinario->extAulaLunes}}">
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Martes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioMartes', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioMartes', $extraordinario->extHoraInicioMartes, array('id' => 'extHoraInicioMartes', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinMartes', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinMartes', $extraordinario->extHoraFinMartes, array('id' => 'extHoraFinMartes', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaMartes">Aula *</label>
                            <input type="text" name="extAulaMartes" id="extAulaMartes" maxlength="3" value="{{$extraordinario->extAulaMartes}}">
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Miércoles</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioMiercoles', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioMiercoles', $extraordinario->extHoraInicioMiercoles, array('id' => 'extHoraInicioMiercoles', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinMiercoles', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinMiercoles', $extraordinario->extHoraFinMiercoles, array('id' => 'extHoraFinMiercoles', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaMiercoles">Aula *</label>
                            <input type="text" name="extAulaMiercoles" id="extAulaMiercoles" maxlength="3" value="{{$extraordinario->extAulaMiercoles}}">
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Jueves</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioJueves', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioJueves', $extraordinario->extHoraInicioJueves, array('id' => 'extHoraInicioJueves', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinJueves', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinJueves', $extraordinario->extHoraFinJueves, array('id' => 'extHoraFinJueves', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaJueves">Aula *</label>
                            <input type="text" name="extAulaJueves" id="extAulaJueves" maxlength="3" value="{{$extraordinario->extAulaJueves}}">
                        </div>
                    </div>
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Viernes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioViernes', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioViernes', $extraordinario->extHoraInicioViernes, array('id' => 'extHoraInicioViernes', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinViernes', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinViernes', $extraordinario->extHoraFinViernes, array('id' => 'extHoraFinViernes', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaViernes">Aula *</label>
                            <input type="text" name="extAulaViernes" id="extAulaViernes" maxlength="3" value="{{$extraordinario->extAulaViernes}}">
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sábado</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSabado', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSabado', $extraordinario->extHoraInicioSabado, array('id' => 'extHoraInicioSabado', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinSabado', 'Hora de fin *', array('class' => '')); !!}
                        {!! Form::time('extHoraFinSabado', $extraordinario->extHoraFinSabado, array('id' => 'extHoraFinSabado', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaSabado">Aula *</label>
                            <input type="text" name="extAulaSabado" id="extAulaSabado" maxlength="3" value="{{$extraordinario->extAulaSabado}}">
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
                        {!! Form::date('extFechaSesion01', $extraordinario->extFechaSesion01, array('id' => 'extFechaSesion01', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion01', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion01', $extraordinario->extHoraInicioSesion01, array('id' => 'extHoraInicioSesion01', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion01">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion01" id="extHoraFinSesion01" maxlength="3" value="{{$extraordinario->extHoraFinSesion01}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 2</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion02', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion02', $extraordinario->extFechaSesion02, array('id' => 'extFechaSesion02', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion02', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion02', $extraordinario->extHoraInicioSesion02, array('id' => 'extHoraInicioSesion02', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion02">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion02" id="extHoraFinSesion02" maxlength="3" value="{{$extraordinario->extHoraFinSesion02}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 3</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion03', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion03', $extraordinario->extFechaSesion03, array('id' => 'extFechaSesion03', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion03', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion03', $extraordinario->extHoraInicioSesion03, array('id' => 'extHoraInicioSesion03', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion03">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion03" id="extHoraFinSesion03" maxlength="3" value="{{$extraordinario->extHoraFinSesion03}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 4</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion04', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion04', $extraordinario->extFechaSesion04, array('id' => 'extFechaSesion04', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion04', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion04', $extraordinario->extHoraInicioSesion04, array('id' => 'extHoraInicioSesion04', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion04">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion04" id="extHoraFinSesion04" maxlength="3" value="{{$extraordinario->extHoraFinSesion04}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 5</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion05', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion05', $extraordinario->extFechaSesion05, array('id' => 'extFechaSesion05', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion05', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion05', $extraordinario->extHoraInicioSesion05, array('id' => 'extHoraInicioSesion05', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion05">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion05" id="extHoraFinSesion05" maxlength="3" value="{{$extraordinario->extHoraFinSesion05}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 6</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion06', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion06', $extraordinario->extFechaSesion06, array('id' => 'extFechaSesion06', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion06', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion06', $extraordinario->extHoraInicioSesion06, array('id' => 'extHoraInicioSesion06', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion06">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion06" id="extHoraFinSesion06" maxlength="3" value="{{$extraordinario->extHoraFinSesion06}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 7</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion07', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion07', $extraordinario->extFechaSesion07, array('id' => 'extFechaSesion07', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion07', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion07', $extraordinario->extHoraInicioSesion07, array('id' => 'extHoraInicioSesion07', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion07">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion07" id="extHoraFinSesion07" maxlength="3" value="{{$extraordinario->extHoraFinSesion07}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 8</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion08', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion08', $extraordinario->extFechaSesion08, array('id' => 'extFechaSesion08', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion08', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion08', $extraordinario->extHoraInicioSesion08, array('id' => 'extHoraInicioSesion08', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion08">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion08" id="extHoraFinSesion08" maxlength="3" value="{{$extraordinario->extHoraFinSesion08}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 9</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion09', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion09', $extraordinario->extFechaSesion09, array('id' => 'extFechaSesion09', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion09', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion09', $extraordinario->extHoraInicioSesion09, array('id' => 'extHoraInicioSesion09', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion09">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion09" id="extHoraFinSesion09" maxlength="3" value="{{$extraordinario->extHoraFinSesion09}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 10</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion10', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion10', $extraordinario->extFechaSesion10, array('id' => 'extFechaSesion10', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion10', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion10', $extraordinario->extHoraInicioSesion10, array('id' => 'extHoraInicioSesion10', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion10">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion10" id="extHoraFinSesion10" maxlength="3" value="{{$extraordinario->extHoraFinSesion10}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 11</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion11', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion11', $extraordinario->extFechaSesion11, array('id' => 'extFechaSesion11', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion11', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion11', $extraordinario->extHoraInicioSesion11, array('id' => 'extHoraInicioSesion11', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion11">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion11" id="extHoraFinSesion11" maxlength="3" value="{{$extraordinario->extHoraFinSesion11}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 12</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion12', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion12', $extraordinario->extFechaSesion12, array('id' => 'extFechaSesion12', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion12', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion12', $extraordinario->extHoraInicioSesion12, array('id' => 'extHoraInicioSesion12', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion12">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion12" id="extHoraFinSesion12" maxlength="3" value="{{$extraordinario->extHoraFinSesion12}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 13</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion13', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion13', $extraordinario->extFechaSesion13, array('id' => 'extFechaSesion13', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion13', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion13', $extraordinario->extHoraInicioSesion13, array('id' => 'extHoraInicioSesion13', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion13">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion13" id="extHoraFinSesion13" maxlength="3" value="{{$extraordinario->extHoraFinSesion13}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 14</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion14', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion14', $extraordinario->extFechaSesion14, array('id' => 'extFechaSesion14', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion14', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion14', $extraordinario->extHoraInicioSesion14, array('id' => 'extHoraInicioSesion14', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion14">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion14" id="extHoraFinSesion14" maxlength="3" value="{{$extraordinario->extHoraFinSesion14}}">
                    </div>
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 15</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion15', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion15', $extraordinario->extFechaSesion15, array('id' => 'extFechaSesion15', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion15', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion15', $extraordinario->extHoraInicioSesion15, array('id' => 'extHoraInicioSesion15', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion15">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion15" id="extHoraFinSesion15" maxlength="3" value="{{$extraordinario->extHoraFinSesion15}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 16</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion16', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion16', $extraordinario->extFechaSesion16, array('id' => 'extFechaSesion16', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion16', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion16', $extraordinario->extHoraInicioSesion16, array('id' => 'extHoraInicioSesion16', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion16">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion16" id="extHoraFinSesion16" maxlength="3" value="{{$extraordinario->extHoraFinSesion16}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 17</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion17', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion17', $extraordinario->extFechaSesion17, array('id' => 'extFechaSesion17', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion17', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion17', $extraordinario->extHoraInicioSesion17, array('id' => 'extHoraInicioSesion17', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion17">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion17" id="extHoraFinSesion17" maxlength="3" value="{{$extraordinario->extHoraFinSesion17}}">
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 18</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion18', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion18', $extraordinario->extFechaSesion18, array('id' => 'extFechaSesion18', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion18', 'Hora de inicio *', array('class' => '')); !!}
                        {!! Form::time('extHoraInicioSesion18', $extraordinario->extHoraInicioSesion18, array('id' => 'extHoraInicioSesion18', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion18">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion18" id="extHoraFinSesion18" maxlength="3" value="{{$extraordinario->extHoraFinSesion18}}">
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('empleado_id', 'Docente *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if($extraordinario->bachiller_empleado_id == $empleado->id) {{ 'selected' }} @endif>{{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col s12 m6">
                        {!! Form::label('empleado_sinodal_id', 'Sinodal', array('class' => '')); !!}
                        <select id="empleado_sinodal_id" class="browser-default validate select2" name="empleado_sinodal_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if($extraordinario->bachiller_empleado_sinodal != $extraordinario->extHoraFinLunes && $extraordinario->bachiller_empleado_sinodal->id == $empleado->id) {{ 'selected' }} @endif>
                                    {{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

{{--  @include('scripts.aulas')  --}}

@endsection