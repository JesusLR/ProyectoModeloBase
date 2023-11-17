@extends('layouts.dashboard')

@section('template_title')
    Bachiller recuperativo
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_recuperativos')}}" class="breadcrumb">Lista de recuperativos</a>
    <label class="breadcrumb">Agregar recuperativo</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller_recuperativos.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR RECUPERATIVO</span>

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
                        <select id="departamento_id" data-departamento-id="{{old('departamento_id')}}" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" data-escuela-id="{{old('escuela_id')}}" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('extTipo', 'Tipo *', array('class' => '')); !!}
                        <select id="extTipo" data-extTipo-id="{{old('extTipo')}}" class="browser-default validate select2" required name="extTipo" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="RECURSAMIENTO" {{ old('extTipo') == 'RECURSAMIENTO' ? 'selected' : '' }}>RECURSAMIENTO</option>
                            <option value="ACOMPAÑAMIENTO" {{ old('extTipo') == 'ACOMPAÑAMIENTO' ? 'selected' : '' }}>ACOMPAÑAMIENTO</option>                            
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('bachiller_fecha_regularizacion_id', 'Fecha regularización *', array('class' => '')); !!}
                        <select id="bachiller_fecha_regularizacion_id" data-bachiller_fecha_regularizacion-id="{{old('bachiller_fecha_regularizacion_id')}}" class="browser-default validate select2" required name="bachiller_fecha_regularizacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoSemestre', 'Semestre *', array('class' => '')); !!}
                        <select id="gpoSemestre" data-gpoSemestre-id="{{old('gpoSemestre')}}" class="browser-default validate select2" required name="gpoSemestre" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @for ($i = 1; $i < 7; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('extGrupo', NULL, array('id' => 'extGrupo', 'class' => 'validate','maxlength' => '3')) !!}
                        {!! Form::label('extGrupo', 'Clave grupo', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('materia_id', 'Materia *', array('class' => '')); !!}
                        <select id="materia_id" data-materia-id="{{old('materia_id')}}" class="browser-default validate select2" required name="materia_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    {{--  <div class="col s12 m6">
                        {!! Form::label('aula_id', 'Aula', array('class' => '')); !!}
                        <select id="aula_id" class="browser-default validate select2" name="aula_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>  --}}
                </div>
                <div id="seccion_optativa" class="row" hidden>
                    <div class="col s12 ">
                        {!! Form::label('optativa_id', 'Optativa', array('class' => '')); !!}
                        <select id="optativa_id" class="browser-default validate select2" name="optativa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFecha', 'Fecha examen *', array('class' => '')); !!}
                        {!! Form::date('extFecha', NULL, array('id' => 'extFecha', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHora', 'Hora examen *', array('class' => '')); !!}
                        {!! Form::time('extHora', NULL, array('id' => 'extHora', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="" id="class-input-field">
                        {!! Form::label('extPago', 'Costo Examen *', array('class' => '')); !!}
                        {!! Form::number('extPago', NULL, array('id' => 'extPago', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==8) return false;"', 'readonly')) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroFolio', NULL, array('id' => 'extNumeroFolio', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extNumeroFolio', 'Número de folio', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroActa', NULL, array('id' => 'extNumeroActa', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extNumeroActa', 'Número de acta', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroLibro', NULL, array('id' => 'extNumeroLibro', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extNumeroLibro', 'Número de libro', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extAlumnosInscritos', NULL, array('id' => 'extAlumnosInscritos', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extAlumnosInscritos', 'Alumnos inscritos *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Lunes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioLunes', 'Hora de inicio', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioLunes" id="extHoraInicioLunes">
                        {{--  <select id="extHoraInicioLunes" class="browser-default validate select2" name="extHoraInicioLunes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioLunes') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioLunes') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioLunes') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioLunes') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioLunes') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioLunes') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioLunes') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioLunes') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioLunes') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioLunes') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioLunes') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioLunes') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioLunes') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioLunes') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioLunes') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioLunes') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioLunes') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioLunes') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioLunes') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioLunes') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioLunes') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioLunes') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioLunes') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioLunes') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinLunes', 'Hora de fin', array('class' => '')); !!}
                        <input type="time" name="extHoraFinLunes" id="extHoraFinLunes">

                        {{--  <select id="extHoraFinLunes" class="browser-default validate select2" name="extHoraFinLunes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinLunes') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinLunes') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinLunes') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinLunes') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinLunes') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinLunes') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinLunes') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinLunes') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinLunes') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinLunes') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinLunes') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinLunes') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinLunes') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinLunes') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinLunes') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinLunes') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinLunes') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinLunes') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinLunes') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinLunes') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinLunes') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinLunes') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinLunes') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinLunes') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{--  <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaLunes">Aula *</label>
                            <input type="text" name="extAulaLunes" id="extAulaLunes" maxlength="3" value="{{old('extAulaLunes')}}">
                        </div>
                    </div>  --}}
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Martes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioMartes', 'Hora de inicio', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioMartes" id="extHoraInicioMartes">
                        {{--  <select id="extHoraInicioMartes" class="browser-default validate select2" name="extHoraInicioMartes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioMartes') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioMartes') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioMartes') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioMartes') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioMartes') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioMartes') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioMartes') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioMartes') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioMartes') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioMartes') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioMartes') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioMartes') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioMartes') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioMartes') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioMartes') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioMartes') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioMartes') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioMartes') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioMartes') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioMartes') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioMartes') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioMartes') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioMartes') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioMartes') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinMartes', 'Hora de fin', array('class' => '')); !!}
                        <input type="time" name="extHoraFinMartes" id="extHoraFinMartes">
                        {{--  <select id="extHoraFinMartes" class="browser-default validate select2" name="extHoraFinMartes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinMartes') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinMartes') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinMartes') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinMartes') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinMartes') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinMartes') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinMartes') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinMartes') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinMartes') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinMartes') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinMartes') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinMartes') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinMartes') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinMartes') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinMartes') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinMartes') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinMartes') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinMartes') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinMartes') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinMartes') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinMartes') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinMartes') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinMartes') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinMartes') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{--  <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaMartes">Aula *</label>
                            <input type="text" name="extAulaMartes" id="extAulaMartes" maxlength="3" value="{{old('extAulaMartes')}}">
                        </div>
                    </div>  --}}
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Miércoles</p>
                </div>
                <div class="row">                  
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioMiercoles', 'Hora de inicio', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioMiercoles" id="extHoraInicioMiercoles" value="{{old('extHoraInicioMiercoles')}}">
                        {{--  <select id="extHoraInicioMiercoles" class="browser-default validate select2" name="extHoraInicioMiercoles" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioMiercoles') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioMiercoles') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioMiercoles') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioMiercoles') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioMiercoles') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioMiercoles') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioMiercoles') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioMiercoles') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioMiercoles') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioMiercoles') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioMiercoles') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioMiercoles') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioMiercoles') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioMiercoles') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioMiercoles') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioMiercoles') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioMiercoles') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioMiercoles') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioMiercoles') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioMiercoles') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioMiercoles') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioMiercoles') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioMiercoles') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioMiercoles') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinMiercoles', 'Hora de fin', array('class' => '')); !!}
                        <input type="time" name="extHoraFinMiercoles" id="extHoraFinMiercoles" value="{{old('extHoraFinMiercoles')}}">
                        {{--  <select id="extHoraFinMiercoles" class="browser-default validate select2" name="extHoraFinMiercoles" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinMiercoles') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinMiercoles') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinMiercoles') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinMiercoles') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinMiercoles') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinMiercoles') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinMiercoles') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinMiercoles') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinMiercoles') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinMiercoles') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinMiercoles') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinMiercoles') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinMiercoles') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinMiercoles') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinMiercoles') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinMiercoles') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinMiercoles') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinMiercoles') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinMiercoles') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinMiercoles') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinMiercoles') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinMiercoles') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinMiercoles') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinMiercoles') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{--  <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaMiercoles">Aula *</label>
                            <input type="text" name="extAulaMiercoles" id="extAulaMiercoles" maxlength="3" value="{{old('extAulaMiercoles')}}">
                        </div>
                    </div>  --}}
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Jueves</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioJueves', 'Hora de inicio', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioJueves" id="extHoraInicioJueves" value="{{old('extHoraInicioJueves')}}">
                        {{--  <select id="extHoraInicioJueves" class="browser-default validate select2" name="extHoraInicioJueves" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioJueves') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioJueves') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioJueves') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioJueves') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioJueves') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioJueves') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioJueves') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioJueves') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioJueves') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioJueves') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioJueves') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioJueves') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioJueves') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioJueves') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioJueves') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioJueves') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioJueves') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioJueves') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioJueves') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioJueves') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioJueves') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioJueves') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioJueves') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioJueves') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinJueves', 'Hora de fin', array('class' => '')); !!}
                        <input type="time" name="extHoraFinJueves" id="extHoraFinJueves" value="{{old('extHoraFinJueves')}}">
                        {{--  <select id="extHoraFinJueves" class="browser-default validate select2" name="extHoraFinJueves" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinJueves') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinJueves') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinJueves') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinJueves') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinJueves') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinJueves') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinJueves') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinJueves') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinJueves') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinJueves') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinJueves') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinJueves') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinJueves') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinJueves') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinJueves') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinJueves') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinJueves') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinJueves') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinJueves') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinJueves') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinJueves') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinJueves') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinJueves') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinJueves') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{--  <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaJueves">Aula *</label>
                            <input type="text" name="extAulaJueves" id="extAulaJueves" maxlength="3" value="{{old('extAulaJueves')}}">
                        </div>
                    </div>  --}}
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Viernes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioViernes', 'Hora de inicio', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioViernes" id="extHoraInicioViernes" value="{{old('extHoraInicioViernes')}}">
                        {{--  <select id="extHoraInicioViernes" class="browser-default validate select2" name="extHoraInicioViernes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioViernes') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioViernes') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioViernes') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioViernes') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioViernes') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioViernes') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioViernes') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioViernes') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioViernes') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioViernes') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioViernes') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioViernes') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioViernes') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioViernes') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioViernes') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioViernes') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioViernes') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioViernes') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioViernes') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioViernes') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioViernes') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioViernes') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioViernes') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioViernes') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinViernes', 'Hora de fin', array('class' => '')); !!}
                        <input type="time" name="extHoraFinViernes" id="extHoraFinViernes" value="{{old('extHoraFinViernes')}}">
                        {{--  <select id="extHoraFinViernes" class="browser-default validate select2" name="extHoraFinViernes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinViernes') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinViernes') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinViernes') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinViernes') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinViernes') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinViernes') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinViernes') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinViernes') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinViernes') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinViernes') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinViernes') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinViernes') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinViernes') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinViernes') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinViernes') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinViernes') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinViernes') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinViernes') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinViernes') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinViernes') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinViernes') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinViernes') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinViernes') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinViernes') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{--  <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaViernes">Aula *</label>
                            <input type="text" name="extAulaViernes" id="extAulaViernes" maxlength="3" value="{{old('extAulaViernes')}}">
                        </div>
                    </div>  --}}
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sábado</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSabado', 'Hora de inicio', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSabado" id="extHoraInicioSabado" value="{{old('extHoraInicioSabado')}}">
                        {{--  <select id="extHoraInicioSabado" class="browser-default validate select2" name="extHoraInicioSabado" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSabado') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSabado') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSabado') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSabado') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSabado') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSabado') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSabado') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSabado') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSabado') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSabado') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSabado') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSabado') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSabado') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSabado') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSabado') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSabado') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSabado') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSabado') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSabado') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSabado') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSabado') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSabado') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSabado') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSabado') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinSabado', 'Hora de fin', array('class' => '')); !!}
                        <input type="time" name="extHoraFinSabado" id="extHoraFinSabado" value="{{old('extHoraFinSabado')}}">
                        {{--  <select id="extHoraFinSabado" class="browser-default validate select2" name="extHoraFinSabado" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSabado') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSabado') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSabado') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSabado') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSabado') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSabado') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSabado') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSabado') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSabado') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSabado') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSabado') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSabado') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSabado') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSabado') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSabado') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSabado') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSabado') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSabado') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSabado') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSabado') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSabado') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSabado') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSabado') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSabado') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    {{--  <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaSabado">Aula *</label>
                            <input type="text" name="extAulaSabado" id="extAulaSabado" maxlength="3" value="{{old('extAulaSabado')}}">
                        </div>
                    </div>  --}}
                </div>

                <br>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 1</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion01', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion01', old('extFechaSesion01'), array('id' => 'extFechaSesion01', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion01', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion01" id="extHoraInicioSesion01" value="{{old('extHoraInicioSesion01')}}"> --}}
                        {{--  <select id="extHoraInicioSesion01" class="browser-default validate select2" name="extHoraInicioSesion01" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion01') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion01') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion01') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion01') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion01') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion01') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion01') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion01') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion01') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion01') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion01') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion01') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion01') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion01') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion01') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion01') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion01') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion01') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion01') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion01') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion01') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion01') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion01') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion01') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion01">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion01" id="extHoraFinSesion01" value="{{old('extHoraFinSesion01')}}"> --}}
                        {{--  <select id="extHoraFinSesion01" class="browser-default validate select2" name="extHoraFinSesion01" style="width: 100%;">  --}}
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion01') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion01') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion01') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion01') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion01') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion01') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion01') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion01') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion01') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion01') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion01') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion01') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion01') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion01') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion01') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion01') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion01') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion01') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion01') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion01') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion01') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion01') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion01') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion01') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 2</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion02', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion02', old('extFechaSesion02'), array('id' => 'extFechaSesion02', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion02', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion02" id="extHoraInicioSesion02" value="{{old('extHoraInicioSesion02')}}"> --}}
                        {{--  <select id="extHoraInicioSesion02" class="browser-default validate select2" name="extHoraInicioSesion02" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion02') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion02') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion02') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion02') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion02') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion02') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion02') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion02') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion02') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion02') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion02') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion02') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion02') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion02') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion02') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion02') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion02') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion02') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion02') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion02') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion02') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion02') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion02') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion02') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion02">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion02" id="extHoraFinSesion02" value="{{old('extHoraFinSesion02')}}"> --}}
                        {{--  <select id="extHoraFinSesion02" class="browser-default validate select2" name="extHoraFinSesion02" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion02') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion02') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion02') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion02') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion02') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion02') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion02') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion02') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion02') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion02') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion02') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion02') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion02') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion02') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion02') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion02') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion02') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion02') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion02') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion02') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion02') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion02') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion02') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion02') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 3</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion03', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion03', old('extFechaSesion03'), array('id' => 'extFechaSesion03', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion03', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion03" id="extHoraInicioSesion03" value="{{old('extHoraInicioSesion03')}}"> --}}
                        {{--  <select id="extHoraInicioSesion03" class="browser-default validate select2" name="extHoraInicioSesion03" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion03') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion03') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion03') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion03') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion03') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion03') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion03') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion03') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion03') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion03') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion03') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion03') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion03') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion03') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion03') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion03') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion03') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion03') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion03') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion03') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion03') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion03') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion03') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion03') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion03">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion03" id="extHoraFinSesion03" value="{{old('extHoraFinSesion03')}}"> --}}
                        {{--  <select id="extHoraFinSesion03" class="browser-default validate select2" name="extHoraFinSesion03" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion03') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion03') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion03') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion03') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion03') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion03') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion03') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion03') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion03') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion03') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion03') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion03') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion03') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion03') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion03') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion03') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion03') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion03') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion03') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion03') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion03') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion03') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion03') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion03') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 4</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion04', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion04', old('extFechaSesion04'), array('id' => 'extFechaSesion04', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion04', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion04" id="extHoraInicioSesion04" value="{{old('extHoraInicioSesion04')}}"> --}}
                        {{--  <select id="extHoraInicioSesion04" class="browser-default validate select2" name="extHoraInicioSesion04" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion04') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion04') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion04') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion04') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion04') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion04') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion04') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion04') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion04') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion04') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion04') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion04') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion04') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion04') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion04') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion04') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion04') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion04') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion04') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion04') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion04') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion04') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion04') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion04') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion04">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion04" id="extHoraFinSesion04" value="{{old('extHoraFinSesion04')}}"> --}}
                        {{--  <select id="extHoraFinSesion04" class="browser-default validate select2" name="extHoraFinSesion04" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion04') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion04') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion04') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion04') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion04') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion04') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion04') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion04') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion04') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion04') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion04') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion04') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion04') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion04') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion04') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion04') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion04') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion04') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion04') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion04') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion04') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion04') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion04') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion04') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 5</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion05', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion05', old('extFechaSesion05'), array('id' => 'extFechaSesion05', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion05', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion05" id="extHoraInicioSesion05" value="{{old('extHoraInicioSesion05')}}"> --}}
                        {{--  <select id="extHoraInicioSesion05" class="browser-default validate select2" name="extHoraInicioSesion05" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion05') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion05') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion05') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion05') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion05') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion05') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion05') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion05') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion05') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion05') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion05') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion05') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion05') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion05') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion05') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion05') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion05') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion05') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion05') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion05') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion05') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion05') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion05') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion05') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion05">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion05" id="extHoraFinSesion05" value="{{old('extHoraFinSesion05')}}"> --}}
                        {{--  <select id="extHoraFinSesion05" class="browser-default validate select2" name="extHoraFinSesion05" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion05') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion05') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion05') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion05') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion05') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion05') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion05') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion05') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion05') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion05') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion05') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion05') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion05') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion05') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion05') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion05') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion05') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion05') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion05') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion05') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion05') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion05') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion05') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion05') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 6</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion06', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion06', old('extFechaSesion06'), array('id' => 'extFechaSesion06', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion06', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion06" id="extHoraInicioSesion06" value="{{old('extHoraInicioSesion06')}}"> --}}
                        {{--  <select id="extHoraInicioSesion06" class="browser-default validate select2" name="extHoraInicioSesion06" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion06') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion06') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion06') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion06') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion06') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion06') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion06') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion06') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion06') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion06') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion06') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion06') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion06') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion06') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion06') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion06') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion06') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion06') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion06') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion06') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion06') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion06') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion06') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion06') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion06">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion06" id="extHoraFinSesion06" value="{{old('extHoraFinSesion06')}}"> --}}
                        {{--  <select id="extHoraFinSesion06" class="browser-default validate select2" name="extHoraFinSesion06" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion06') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion06') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion06') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion06') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion06') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion06') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion06') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion06') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion06') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion06') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion06') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion06') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion06') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion06') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion06') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion06') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion06') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion06') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion06') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion06') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion06') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion06') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion06') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion06') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 7</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion07', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion07', old('extFechaSesion07'), array('id' => 'extFechaSesion07', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion07', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion07" id="extHoraInicioSesion07" value="{{old('extHoraInicioSesion07')}}"> --}}
                        {{--  <select id="extHoraInicioSesion07" class="browser-default validate select2" name="extHoraInicioSesion07" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion07') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion07') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion07') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion07') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion07') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion07') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion07') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion07') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion07') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion07') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion07') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion07') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion07') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion07') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion07') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion07') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion07') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion07') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion07') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion07') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion07') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion07') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion07') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion07') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion07">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion07" id="extHoraFinSesion07" value="{{old('extHoraFinSesion07')}}"> --}}
                        {{--  <select id="extHoraFinSesion07" class="browser-default validate select2" name="extHoraFinSesion07" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion07') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion07') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion07') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion07') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion07') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion07') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion07') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion07') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion07') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion07') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion07') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion07') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion07') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion07') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion07') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion07') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion07') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion07') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion07') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion07') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion07') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion07') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion07') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion07') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 8</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion08', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion08', old('extFechaSesion08'), array('id' => 'extFechaSesion08', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion08', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion08" id="extHoraInicioSesion08" value="{{old('extHoraInicioSesion08')}}"> --}}
                        {{--  <select id="extHoraInicioSesion08" class="browser-default validate select2" name="extHoraInicioSesion08" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion08') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion08') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion08') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion08') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion08') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion08') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion08') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion08') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion08') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion08') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion08') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion08') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion08') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion08') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion08') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion08') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion08') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion08') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion08') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion08') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion08') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion08') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion08') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion08') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion08">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion08" id="extHoraFinSesion08" value="{{old('extHoraFinSesion08')}}"> --}}
                        {{--  <select id="extHoraFinSesion08" class="browser-default validate select2" name="extHoraFinSesion08" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion08') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion08') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion08') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion08') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion08') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion08') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion08') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion08') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion08') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion08') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion08') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion08') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion08') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion08') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion08') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion08') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion08') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion08') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion08') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion08') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion08') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion08') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion08') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion08') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 9</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion09', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion09', old('extFechaSesion09'), array('id' => 'extFechaSesion09', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion09', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion09" id="extHoraInicioSesion09" value="{{old('extHoraInicioSesion09')}}"> --}}
                        {{--  <select id="extHoraInicioSesion09" class="browser-default validate select2" name="extHoraInicioSesion09" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion09') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion09') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion09') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion09') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion09') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion09') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion09') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion09') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion09') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion09') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion09') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion09') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion09') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion09') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion09') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion09') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion09') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion09') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion09') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion09') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion09') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion09') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion09') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion09') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion09">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion09" id="extHoraFinSesion09" value="{{old('extHoraFinSesion09')}}"> --}}
                        {{--  <select id="extHoraFinSesion09" class="browser-default validate select2" name="extHoraFinSesion09" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion09') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion09') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion09') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion09') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion09') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion09') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion09') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion09') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion09') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion09') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion09') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion09') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion09') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion09') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion09') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion09') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion09') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion09') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion09') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion09') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion09') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion09') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion09') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion09') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 10</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion10', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion10', old('extFechaSesion10'), array('id' => 'extFechaSesion10', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion10', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion10" id="extHoraInicioSesion10" value="{{old('extHoraInicioSesion10')}}"> --}}
                        {{--  <select id="extHoraInicioSesion10" class="browser-default validate select2" name="extHoraInicioSesion10" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion10') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion10') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion10') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion10') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion10') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion10') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion10') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion10') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion10') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion10') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion10') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion10') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion10') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion10') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion10') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion10') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion10') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion10') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion10') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion10') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion10') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion10') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion10') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion10') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion10">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion10" id="extHoraFinSesion10" value="{{old('extHoraFinSesion10')}}"> --}}
                        {{--  <select id="extHoraFinSesion10" class="browser-default validate select2" name="extHoraFinSesion10" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion10') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion10') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion10') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion10') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion10') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion10') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion10') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion10') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion10') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion10') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion10') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion10') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion10') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion10') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion10') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion10') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion10') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion10') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion10') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion10') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion10') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion10') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion10') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion10') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 11</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion11', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion11', old('extFechaSesion11'), array('id' => 'extFechaSesion11', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion11', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion11" id="extHoraInicioSesion11" value="{{old('extHoraInicioSesion11')}}"> --}}
                        {{--  <select id="extHoraInicioSesion11" class="browser-default validate select2" name="extHoraInicioSesion11" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion11') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion11') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion11') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion11') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion11') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion11') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion11') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion11') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion11') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion11') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion11') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion11') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion11') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion11') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion11') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion11') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion11') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion11') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion11') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion11') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion11') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion11') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion11') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion11') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion11">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion11" id="extHoraFinSesion11" value="{{old('extHoraFinSesion11')}}"> --}}
                        {{--  <select id="extHoraFinSesion11" class="browser-default validate select2" name="extHoraFinSesion11" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion11') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion11') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion11') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion11') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion11') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion11') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion11') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion11') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion11') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion11') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion11') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion11') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion11') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion11') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion11') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion11') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion11') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion11') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion11') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion11') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion11') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion11') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion11') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion11') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 12</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion12', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion12', old('extFechaSesion12'), array('id' => 'extFechaSesion12', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion12', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion12" id="extHoraInicioSesion12" value="{{old('extHoraInicioSesion12')}}"> --}}
                        {{--  <select id="extHoraInicioSesion12" class="browser-default validate select2" name="extHoraInicioSesion12" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion12') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion12') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion12') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion12') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion12') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion12') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion12') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion12') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion12') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion12') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion12') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion12') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion12') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion12') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion12') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion12') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion12') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion12') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion12') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion12') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion12') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion12') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion12') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion12') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion12">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion12" id="extHoraFinSesion12" value="{{old('extHoraFinSesion12')}}"> --}}
                        {{--  <select id="extHoraFinSesion12" class="browser-default validate select2" name="extHoraFinSesion12" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion12') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion12') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion12') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion12') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion12') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion12') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion12') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion12') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion12') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion12') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion12') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion12') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion12') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion12') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion12') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion12') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion12') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion12') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion12') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion12') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion12') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion12') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion12') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion12') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 13</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion13', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion13', old('extFechaSesion13'), array('id' => 'extFechaSesion13', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion13', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion13" id="extHoraInicioSesion13" value="{{old('extHoraInicioSesion13')}}"> --}}
                        {{--  <select id="extHoraInicioSesion13" class="browser-default validate select2" name="extHoraInicioSesion13" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion13') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion13') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion13') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion13') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion13') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion13') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion13') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion13') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion13') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion13') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion13') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion13') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion13') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion13') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion13') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion13') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion13') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion13') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion13') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion13') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion13') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion13') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion13') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion13') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion13">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion13" id="extHoraFinSesion13" value="{{old('extHoraFinSesion13')}}"> --}}
                        {{--  <select id="extHoraFinSesion13" class="browser-default validate select2" name="extHoraFinSesion13" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion13') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion13') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion13') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion13') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion13') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion13') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion13') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion13') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion13') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion13') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion13') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion13') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion13') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion13') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion13') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion13') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion13') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion13') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion13') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion13') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion13') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion13') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion13') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion13') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 14</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion14', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion14', old('extFechaSesion14'), array('id' => 'extFechaSesion14', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion14', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion14" id="extHoraInicioSesion14" value="{{old('extHoraInicioSesion14')}}"> --}}
                        {{--  <select id="extHoraInicioSesion14" class="browser-default validate select2" name="extHoraInicioSesion14" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion14') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion14') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion14') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion14') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion14') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion14') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion14') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion14') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion14') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion14') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion14') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion14') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion14') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion14') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion14') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion14') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion14') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion14') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion14') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion14') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion14') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion14') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion14') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion14') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion14">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion14" id="extHoraFinSesion14" value="{{old('extHoraFinSesion14')}}"> --}}
                        {{--  <select id="extHoraFinSesion14" class="browser-default validate select2" name="extHoraFinSesion14" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion14') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion14') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion14') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion14') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion14') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion14') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion14') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion14') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion14') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion14') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion14') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion14') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion14') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion14') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion14') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion14') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion14') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion14') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion14') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion14') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion14') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion14') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion14') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion14') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 15</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion15', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion15', old('extFechaSesion15'), array('id' => 'extFechaSesion15', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion15', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion15" id="extHoraInicioSesion15" value="{{old('extHoraInicioSesion15')}}"> --}}
                        {{--  {<select id="extHoraInicioSesion15" class="browser-default validate select2" name="extHoraInicioSesion15" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion15') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion15') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion15') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion15') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion15') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion15') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion15') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion15') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion15') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion15') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion15') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion15') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion15') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion15') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion15') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion15') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion15') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion15') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion15') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion15') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion15') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion15') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion15') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion15') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion15">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion15" id="extHoraFinSesion15" value="{{old('extHoraFinSesion15')}}"> --}}
                        {{--  <select id="extHoraFinSesion15" class="browser-default validate select2" name="extHoraFinSesion15" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion15') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion15') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion15') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion15') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion15') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion15') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion15') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion15') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion15') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion15') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion15') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion15') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion15') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion15') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion15') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion15') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion15') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion15') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion15') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion15') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion15') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion15') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion15') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion15') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 16</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion16', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion16', old('extFechaSesion16'), array('id' => 'extFechaSesion16', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion16', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion16" id="extHoraInicioSesion16" value="{{old('extHoraInicioSesion16')}}"> --}}
                        {{--  <select id="extHoraInicioSesion16" class="browser-default validate select2" name="extHoraInicioSesion16" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion16') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion16') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion16') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion16') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion16') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion16') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion16') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion16') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion16') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion16') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion16') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion16') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion16') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion16') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion16') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion16') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion16') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion16') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion16') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion16') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion16') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion16') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion16') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion16') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion16">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion16" id="extHoraFinSesion16" value="{{old('extHoraFinSesion16')}}"> --}}
                        {{--  <select id="extHoraFinSesion16" class="browser-default validate select2" name="extHoraFinSesion16" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion16') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion16') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion16') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion16') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion16') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion16') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion16') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion16') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion16') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion16') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion16') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion16') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion16') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion16') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion16') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion16') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion16') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion16') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion16') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion16') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion16') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion16') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion16') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion16') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 17</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion17', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion17', old('extFechaSesion17'), array('id' => 'extFechaSesion17', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion17', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion17" id="extHoraInicioSesion17" value="{{old('extHoraInicioSesion17')}}"> --}}
                        {{--  <select id="extHoraInicioSesion17" class="browser-default validate select2" name="extHoraInicioSesion17" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion17') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion17') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion17') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion17') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion17') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion17') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion17') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion17') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion17') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion17') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion17') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion17') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion17') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion17') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion17') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion17') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion17') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion17') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion17') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion17') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion17') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion17') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion17') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion17') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion17">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion17" id="extHoraFinSesion17" value="{{old('extHoraFinSesion17')}}"> --}}
                        {{--  <select id="extHoraFinSesion17" class="browser-default validate select2" name="extHoraFinSesion17" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion17') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion17') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion17') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion17') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion17') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion17') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion17') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion17') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion17') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion17') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion17') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion17') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion17') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion17') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion17') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion17') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion17') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion17') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion17') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion17') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion17') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion17') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion17') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion17') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 18</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion18', 'Fecha sesión', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion18', old('extFechaSesion18'), array('id' => 'extFechaSesion18', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {{-- {!! Form::label('extHoraInicioSesion18', 'Hora de inicio *', array('class' => '')); !!}
                        <input type="time" name="extHoraInicioSesion18" id="extHoraInicioSesion18" value="{{old('extHoraInicioSesion18')}}"> --}}
                        {{--  <select id="extHoraInicioSesion18" class="browser-default validate select2" name="extHoraInicioSesion18" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraInicioSesion18') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraInicioSesion18') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraInicioSesion18') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraInicioSesion18') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraInicioSesion18') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraInicioSesion18') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraInicioSesion18') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraInicioSesion18') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraInicioSesion18') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraInicioSesion18') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraInicioSesion18') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraInicioSesion18') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraInicioSesion18') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraInicioSesion18') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraInicioSesion18') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraInicioSesion18') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraInicioSesion18') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraInicioSesion18') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraInicioSesion18') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraInicioSesion18') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraInicioSesion18') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraInicioSesion18') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraInicioSesion18') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraInicioSesion18') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                    <div class="col s12 m6 l4">
                        {{-- <label for="extHoraFinSesion18">Hora fin *</label>
                        <input type="time" name="extHoraFinSesion18" id="extHoraFinSesion18" value="{{old('extHoraFinSesion18')}}"> --}}
                        {{--  <select id="extHoraFinSesion18" class="browser-default validate select2" name="extHoraFinSesion18" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ old('extHoraFinSesion18') == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ old('extHoraFinSesion18') == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ old('extHoraFinSesion18') == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ old('extHoraFinSesion18') == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ old('extHoraFinSesion18') == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ old('extHoraFinSesion18') == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ old('extHoraFinSesion18') == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ old('extHoraFinSesion18') == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ old('extHoraFinSesion18') == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ old('extHoraFinSesion18') == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ old('extHoraFinSesion18') == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ old('extHoraFinSesion18') == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ old('extHoraFinSesion18') == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ old('extHoraFinSesion18') == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ old('extHoraFinSesion18') == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ old('extHoraFinSesion18') == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ old('extHoraFinSesion18') == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ old('extHoraFinSesion18') == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ old('extHoraFinSesion18') == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ old('extHoraFinSesion18') == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ old('extHoraFinSesion18') == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ old('extHoraFinSesion18') == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ old('extHoraFinSesion18') == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ old('extHoraFinSesion18') == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>  --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('empleado_id', 'Docente *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if(old('empleado_id') == $empleado->id) {{ 'selected' }} @endif>{{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6">
                        {!! Form::label('empleado_sinodal_id', 'Sinodal', array('class' => '')); !!}
                        <select id="empleado_sinodal_id" class="browser-default validate select2" name="empleado_sinodal_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" @if(old('empleado_sinodal_id') == $empleado->id) {{ 'selected' }} @endif>{{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}</option>
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

@include('bachiller.scripts.preferencias')
@include('bachiller.scripts.departamentos')
@include('bachiller.scripts.escuelas_periodos')
@include('bachiller.scripts.programas')
@include('bachiller.scripts.planes-espesificos')
@include('bachiller.scripts.periodos')
{{--  @include('bachiller.scripts.semestres')  --}}
@include('bachiller.scripts.materias')
@include('bachiller.scripts.grupos')
@include('bachiller.extraordinario.obtenerFechasRegularizacion')

{{--  @include('bachiller.scripts.optativas')  --}}
{{--  @include('bachiller.scripts.aulas')  --}}

@endsection