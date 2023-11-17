@extends('layouts.dashboard')

@section('template_title')
    Bachiller recuperativo
@endsection

@section('head')
    {!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_recuperativos')}}" class="breadcrumb">Lista de recuperativo</a>
    <label class="breadcrumb">Editar recuperativo</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['bachiller.bachiller_recuperativos.update_docente', $extraordinario->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR RECUPERATIVO #{{$extraordinario->id}}</span>

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
                             <option value="{{$extraordinario->ubicacion_id}}">{{$extraordinario->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$extraordinario->departamento_id}}">
                                {{$extraordinario->depClave}}
                                {{"-"}}
                                {{$extraordinario->depNombre}}
                            </option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$extraordinario->escuela_id}}">{{$extraordinario->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                                <option value="{{$extraordinario->periodo_id}}">{{$extraordinario->perNumero}}-{{$extraordinario->perAnio}}</option>
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
                            <option value="{{$extraordinario->programa_id}}">{{$extraordinario->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$extraordinario->plan_id}}">{{$extraordinario->planClave}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoSemestre', 'Semestre *', array('class' => '')); !!}
                        <input type="text" value="{{$extraordinario->matSemestre}}" readonly>                        
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('extGrupo', $extraordinario->extGrupo, array('id' => 'extGrupo', 'class' => 'validate','maxlength' => '3', 'readonly')) !!}
                        {!! Form::label('extGrupo', 'Clave grupo', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m4">
                        {!! Form::label('materia_id', 'Materia *', array('class' => '')); !!}
                        <input type="text" value="{{$extraordinario->matClave}}-{{$extraordinario->matNombre}}" readonly>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extFecha', 'Fecha examen *', array('class' => '')); !!}
                        {!! Form::date('extFecha', $extraordinario->extFecha, array('id' => 'extFecha', 'class' => 'validate', 'required')) !!}
                    </div>


                    <div class="col s12 m6 l4">
                        {!! Form::label('extHora', 'Hora examen *', array('class' => '')); !!}
                        {!! Form::time('extHora', $extraordinario->extHora, array('id' => 'extHora', 'class' => 'validate')) !!}
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

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Lunes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioLunes', 'Hora de inicio', array('class' => '')); !!}
                        @if ($extraordinario->extHoraInicioLunes < 10)
                            @php
                                $extHoraInicioLunes = '0'.$extraordinario->extHoraInicioLunes;
                            @endphp
                        @else
                            @php
                            $extHoraInicioLunes = $extraordinario->extHoraInicioLunes;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoInicioLunes < 10)
                            @php
                                $extMinutoInicioLunes = '0'.$extraordinario->extMinutoInicioLunes;
                            @endphp
                        @else
                            @php
                            $extMinutoInicioLunes = $extraordinario->extMinutoInicioLunes;
                            @endphp
                        @endif
                        <input type="time" name="extHoraInicioLunes" id="extHoraInicioLunes" value="{{$extHoraInicioLunes.':'.$extMinutoInicioLunes}}">

                        {{--  <select id="extHoraInicioLunes" class="browser-default validate select2" name="extHoraInicioLunes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioLunes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioLunes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioLunes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioLunes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioLunes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioLunes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioLunes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioLunes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioLunes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioLunes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioLunes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioLunes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioLunes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioLunes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioLunes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioLunes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioLunes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioLunes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioLunes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioLunes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioLunes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioLunes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioLunes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioLunes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinLunes', 'Hora de fin', array('class' => '')); !!}
                        @if ($extraordinario->extHoraFinLunes < 10)
                            @php
                                $extHoraFinLunes = '0'.$extraordinario->extHoraFinLunes;
                            @endphp
                        @else
                            @php
                            $extHoraFinLunes = $extraordinario->extHoraFinLunes;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoFinLunes < 10)
                            @php
                                $extMinutoFinLunes = '0'.$extraordinario->extMinutoFinLunes;
                            @endphp
                        @else
                            @php
                            $extMinutoFinLunes = $extraordinario->extMinutoFinLunes;
                            @endphp
                        @endif
                        <input type="time" name="extHoraFinLunes" id="extHoraFinLunes" value="{{$extHoraFinLunes.':'.$extMinutoFinLunes}}">
                        {{--  <select id="extHoraFinLunes" class="browser-default validate select2" name="extHoraFinLunes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinLunes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinLunes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinLunes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinLunes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinLunes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinLunes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinLunes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinLunes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinLunes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinLunes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinLunes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinLunes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinLunes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinLunes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinLunes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinLunes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinLunes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinLunes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinLunes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinLunes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinLunes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinLunes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinLunes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinLunes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{-- <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaLunes">Aula *</label>
                            <input type="text" name="extAulaLunes" id="extAulaLunes" maxlength="3" value="{{$extraordinario->extAulaLunes}}">
                        </div>
                    </div> --}}
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Martes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioMartes', 'Hora de inicio', array('class' => '')); !!}
                        @if ($extraordinario->extHoraInicioMartes < 10)
                            @php
                                $extHoraInicioMartes = '0'.$extraordinario->extHoraInicioMartes;
                            @endphp
                        @else
                            @php
                            $extHoraInicioMartes = $extraordinario->extHoraInicioMartes;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoInicioMartes < 10)
                            @php
                                $extMinutoInicioMartes = '0'.$extraordinario->extMinutoInicioMartes;
                            @endphp
                        @else
                            @php
                            $extMinutoInicioMartes = $extraordinario->extMinutoInicioMartes;
                            @endphp
                        @endif
                        <input type="time" name="extHoraInicioMartes" id="extHoraInicioMartes" value="{{$extHoraInicioMartes.':'.$extMinutoInicioMartes}}">

                        {{--  <select id="extHoraInicioMartes" class="browser-default validate select2" name="extHoraInicioMartes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioMartes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioMartes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioMartes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioMartes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioMartes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioMartes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioMartes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioMartes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioMartes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioMartes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioMartes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioMartes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioMartes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioMartes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioMartes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioMartes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioMartes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioMartes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioMartes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioMartes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioMartes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioMartes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioMartes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioMartes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>                      --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinMartes', 'Hora de fin', array('class' => '')); !!}
                        @if ($extraordinario->extHoraFinMartes < 10)
                            @php
                                $extHoraFinMartes = '0'.$extraordinario->extHoraFinMartes;
                            @endphp
                        @else
                            @php
                            $extHoraFinMartes = $extraordinario->extHoraFinMartes;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoFinMartes < 10)
                            @php
                                $extMinutoFinMartes = '0'.$extraordinario->extMinutoFinMartes;
                            @endphp
                        @else
                            @php
                            $extMinutoFinMartes = $extraordinario->extMinutoFinMartes;
                            @endphp
                        @endif
                        <input type="time" name="extHoraFinMartes" id="extHoraFinMartes" value="{{$extHoraFinMartes.':'.$extMinutoFinMartes}}">
                        {{--  <select id="extHoraFinMartes" class="browser-default validate select2" name="extHoraFinMartes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinMartes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinMartes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinMartes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinMartes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinMartes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinMartes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinMartes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinMartes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinMartes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinMartes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinMartes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinMartes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinMartes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinMartes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinMartes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinMartes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinMartes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinMartes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinMartes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinMartes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinMartes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinMartes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinMartes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinMartes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>     --}}
                    </div>
                    {{-- <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaMartes">Aula *</label>
                            <input type="text" name="extAulaMartes" id="extAulaMartes" maxlength="3" value="{{$extraordinario->extAulaMartes}}">
                        </div>
                    </div> --}}
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Miércoles</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioMiercoles', 'Hora de inicio', array('class' => '')); !!}
                         @if ($extraordinario->extHoraInicioMiercoles < 10)
                            @php
                                $extHoraInicioMiercoles = '0'.$extraordinario->extHoraInicioMiercoles;
                            @endphp
                        @else
                            @php
                            $extHoraInicioMiercoles = $extraordinario->extHoraInicioMiercoles;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoInicioMiercoles < 10)
                            @php
                                $extMinutoInicioMiercoles = '0'.$extraordinario->extMinutoInicioMiercoles;
                            @endphp
                        @else
                            @php
                            $extMinutoInicioMiercoles = $extraordinario->extMinutoInicioMiercoles;
                            @endphp
                        @endif
                        <input type="time" name="extHoraInicioMiercoles" id="extHoraInicioMiercoles" value="{{$extHoraInicioMiercoles.':'.$extMinutoInicioMiercoles}}">
                        {{--  <select id="extHoraInicioMiercoles" class="browser-default validate select2" name="extHoraInicioMiercoles" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioMiercoles == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioMiercoles == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioMiercoles == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioMiercoles == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioMiercoles == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioMiercoles == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioMiercoles == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioMiercoles == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioMiercoles == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioMiercoles == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioMiercoles == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioMiercoles == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioMiercoles == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioMiercoles == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioMiercoles == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioMiercoles == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioMiercoles == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioMiercoles == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioMiercoles == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioMiercoles == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioMiercoles == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioMiercoles == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioMiercoles == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioMiercoles == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinMiercoles', 'Hora de fin', array('class' => '')); !!}
                        @if ($extraordinario->extHoraFinMiercoles < 10)
                            @php
                                $extHoraFinMiercoles = '0'.$extraordinario->extHoraFinMiercoles;
                            @endphp
                        @else
                            @php
                            $extHoraFinMiercoles = $extraordinario->extHoraFinMiercoles;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoFinMiercoles < 10)
                            @php
                                $extMinutoFinMiercoles = '0'.$extraordinario->extMinutoFinMiercoles;
                            @endphp
                        @else
                            @php
                            $extMinutoFinMiercoles = $extraordinario->extMinutoFinMiercoles;
                            @endphp
                        @endif
                        <input type="time" name="extHoraFinMiercoles" id="extHoraFinMiercoles" value="{{$extHoraFinMiercoles.':'.$extMinutoFinMiercoles}}">
                        {{--  <select id="extHoraFinMiercoles" class="browser-default validate select2" name="extHoraFinMiercoles" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinMiercoles == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinMiercoles == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinMiercoles == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinMiercoles == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinMiercoles == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinMiercoles == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinMiercoles == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinMiercoles == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinMiercoles == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinMiercoles == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinMiercoles == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinMiercoles == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinMiercoles == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinMiercoles == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinMiercoles == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinMiercoles == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinMiercoles == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinMiercoles == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinMiercoles == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinMiercoles == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinMiercoles == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinMiercoles == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinMiercoles == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinMiercoles == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{-- <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaMiercoles">Aula *</label>
                            <input type="text" name="extAulaMiercoles" id="extAulaMiercoles" maxlength="3" value="{{$extraordinario->extAulaMiercoles}}">
                        </div>
                    </div> --}}
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Jueves</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioJueves', 'Hora de inicio', array('class' => '')); !!}
                        @if ($extraordinario->extHoraInicioJueves < 10)
                            @php
                                $extHoraInicioJueves = '0'.$extraordinario->extHoraInicioJueves;
                            @endphp
                        @else
                            @php
                            $extHoraInicioJueves = $extraordinario->extHoraInicioJueves;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoInicioJueves < 10)
                            @php
                                $extMinutoInicioJueves = '0'.$extraordinario->extMinutoInicioJueves;
                            @endphp
                        @else
                            @php
                            $extMinutoInicioJueves = $extraordinario->extMinutoInicioJueves;
                            @endphp
                        @endif
                        <input type="time" name="extHoraInicioJueves" id="extHoraInicioJueves" value="{{$extHoraInicioJueves.':'.$extMinutoInicioJueves}}">
                        {{--  <select id="extHoraInicioJueves" class="browser-default validate select2" name="extHoraInicioJueves" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioJueves == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioJueves == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioJueves == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioJueves == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioJueves == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioJueves == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioJueves == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioJueves == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioJueves == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioJueves == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioJueves == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioJueves == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioJueves == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioJueves == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioJueves == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioJueves == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioJueves == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioJueves == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioJueves == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioJueves == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioJueves == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioJueves == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioJueves == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioJueves == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinJueves', 'Hora de fin', array('class' => '')); !!}
                        @if ($extraordinario->extHoraFinJueves < 10)
                            @php
                                $extHoraFinJueves = '0'.$extraordinario->extHoraFinJueves;
                            @endphp
                        @else
                            @php
                            $extHoraFinJueves = $extraordinario->extHoraFinJueves;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoFinJueves < 10)
                            @php
                                $extMinutoFinJueves = '0'.$extraordinario->extMinutoFinJueves;
                            @endphp
                        @else
                            @php
                            $extMinutoFinJueves = $extraordinario->extMinutoFinJueves;
                            @endphp
                        @endif
                        <input type="time" name="extHoraFinJueves" id="extHoraFinJueves" value="{{$extHoraFinJueves.':'.$extMinutoFinJueves}}">
                        {{--  <select id="extHoraFinJueves" class="browser-default validate select2" name="extHoraFinJueves" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinJueves == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinJueves == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinJueves == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinJueves == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinJueves == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinJueves == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinJueves == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinJueves == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinJueves == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinJueves == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinJueves == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinJueves == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinJueves == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinJueves == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinJueves == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinJueves == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinJueves == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinJueves == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinJueves == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinJueves == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinJueves == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinJueves == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinJueves == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinJueves == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{-- <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaJueves">Aula *</label>
                            <input type="text" name="extAulaJueves" id="extAulaJueves" maxlength="3" value="{{$extraordinario->extAulaJueves}}">
                        </div>
                    </div> --}}
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Viernes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioViernes', 'Hora de inicio', array('class' => '')); !!}
                        @if ($extraordinario->extHoraInicioViernes < 10)
                            @php
                                $extHoraInicioViernes = '0'.$extraordinario->extHoraInicioViernes;
                            @endphp
                        @else
                            @php
                            $extHoraInicioViernes = $extraordinario->extHoraInicioViernes;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoInicioViernes < 10)
                            @php
                                $extMinutoInicioViernes = '0'.$extraordinario->extMinutoInicioViernes;
                            @endphp
                        @else
                            @php
                            $extMinutoInicioViernes = $extraordinario->extMinutoInicioViernes;
                            @endphp
                        @endif
                        <input type="time" name="extHoraInicioViernes" id="extHoraInicioViernes" value="{{$extHoraInicioViernes.':'.$extMinutoInicioViernes}}">
                        {{--  <select id="extHoraInicioViernes" class="browser-default validate select2" name="extHoraInicioViernes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioViernes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioViernes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioViernes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioViernes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioViernes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioViernes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioViernes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioViernes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioViernes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioViernes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioViernes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioViernes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioViernes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioViernes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioViernes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioViernes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioViernes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioViernes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioViernes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioViernes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioViernes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioViernes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioViernes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioViernes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinViernes', 'Hora de fin', array('class' => '')); !!}
                        @if ($extraordinario->extHoraFinViernes < 10)
                            @php
                                $extHoraFinViernes = '0'.$extraordinario->extHoraFinViernes;
                            @endphp
                        @else
                            @php
                            $extHoraFinViernes = $extraordinario->extHoraFinViernes;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoFinViernes < 10)
                            @php
                                $extMinutoFinViernes = '0'.$extraordinario->extMinutoFinViernes;
                            @endphp
                        @else
                            @php
                            $extMinutoFinViernes = $extraordinario->extMinutoFinViernes;
                            @endphp
                        @endif
                        <input type="time" name="extHoraFinViernes" id="extHoraFinViernes" value="{{$extHoraFinViernes.':'.$extMinutoFinViernes}}">
                        {{--  <select id="extHoraFinViernes" class="browser-default validate select2" name="extHoraFinViernes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinViernes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinViernes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinViernes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinViernes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinViernes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinViernes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinViernes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinViernes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinViernes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinViernes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinViernes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinViernes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinViernes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinViernes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinViernes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinViernes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinViernes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinViernes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinViernes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinViernes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinViernes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinViernes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinViernes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinViernes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{-- <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaViernes">Aula *</label>
                            <input type="text" name="extAulaViernes" id="extAulaViernes" maxlength="3" value="{{$extraordinario->extAulaViernes}}">
                        </div>
                    </div> --}}
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sábado</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSabado', 'Hora de inicio', array('class' => '')); !!}
                        @if ($extraordinario->extHoraInicioSabado < 10)
                            @php
                                $extHoraInicioSabado = '0'.$extraordinario->extHoraInicioSabado;
                            @endphp
                        @else
                            @php
                            $extHoraInicioSabado = $extraordinario->extHoraInicioSabado;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoInicioSabado < 10)
                            @php
                                $extMinutoInicioSabado = '0'.$extraordinario->extMinutoInicioSabado;
                            @endphp
                        @else
                            @php
                            $extMinutoInicioSabado = $extraordinario->extMinutoInicioSabado;
                            @endphp
                        @endif
                        <input type="time" name="extHoraInicioSabado" id="extHoraInicioSabado" value="{{$extHoraInicioSabado.':'.$extMinutoInicioSabado}}">
                        {{--  <select id="extHoraInicioSabado" class="browser-default validate select2" name="extHoraInicioSabado" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSabado == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSabado == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSabado == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSabado == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSabado == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSabado == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSabado == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSabado == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSabado == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSabado == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSabado == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSabado == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSabado == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSabado == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSabado == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSabado == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSabado == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSabado == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSabado == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSabado == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSabado == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSabado == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSabado == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSabado == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinSabado', 'Hora de fin', array('class' => '')); !!}
                        @if ($extraordinario->extHoraFinSabado < 10)
                            @php
                                $extHoraFinSabado = '0'.$extraordinario->extHoraFinSabado;
                            @endphp
                        @else
                            @php
                            $extHoraFinSabado = $extraordinario->extHoraFinSabado;
                            @endphp
                        @endif

                        @if ($extraordinario->extMinutoFinSabado < 10)
                            @php
                                $extMinutoFinSabado = '0'.$extraordinario->extMinutoFinSabado;
                            @endphp
                        @else
                            @php
                            $extMinutoFinSabado = $extraordinario->extMinutoFinSabado;
                            @endphp
                        @endif
                        <input type="time" name="extHoraFinSabado" id="extHoraFinSabado" value="{{$extHoraFinSabado.':'.$extMinutoFinSabado}}">
                        {{--  <select id="extHoraFinSabado" class="browser-default validate select2" name="extHoraFinSabado" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSabado == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSabado == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSabado == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSabado == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSabado == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSabado == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSabado == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSabado == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSabado == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSabado == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSabado == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSabado == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSabado == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSabado == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSabado == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSabado == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSabado == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSabado == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSabado == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSabado == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSabado == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSabado == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSabado == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSabado == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{-- <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaSabado">Aula *</label>
                            <input type="text" name="extAulaSabado" id="extAulaSabado" maxlength="3" value="{{$extraordinario->extAulaSabado}}">
                        </div>
                    </div> --}}
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
                    <div class="col s12 m6">
                        {!! Form::label('empleado_id', 'Docente *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" {{ $empleado->id == $extraordinario->bachiller_empleado_id ? 'selected' : '' }}>{{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col s12 m6">
                        {!! Form::label('empleado_sinodal_id', 'Sinodal', array('class' => '')); !!}
                        <select id="empleado_sinodal_id" class="browser-default validate select2" name="empleado_sinodal_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" {{ $empleado->id == $extraordinario->bachiller_empleado_sinodal_id ? 'selected' : '' }}>{{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}</option>
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