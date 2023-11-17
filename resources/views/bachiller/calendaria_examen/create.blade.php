@extends('layouts.dashboard')

@section('template_title')
    Bachiller fechas calendario examen
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_calendario_examen')}}" class="breadcrumb">Lista de fechas calendario examen</a>
    <label class="breadcrumb">Agregar fechas calendario examen</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_calendario_examen.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR FECHAS CALENDARIO EXAMEN</span>

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
                        {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @php
                                    $selected = '';

                                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                    if ($ubicacion->id == $ubicacion_id && !old("ubicacion_id")) {
                                        echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                    } else {
                                        if ($ubicacion->id == old("ubicacion_id")) {
                                            $selected = 'selected';
                                        }

                                        echo '<option value="'.$ubicacion->id.'" '. $selected .'>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                    }
                                @endphp
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-idold="{{old('departamento_id')}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-idold="{{old('escuela_id')}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Período *', array('class' => '')); !!}
                        <select id="periodo_id"
                            data-plan-idold="{{old('periodo_id')}}"
                            class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-idold="{{old('programa_id')}}"
                            class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-idold="{{old('plan_id')}}"
                            class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>                  
                    
                </div>              


                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="calexInicioParcial1">Fecha inicio parcial 1 *</label>  
                        <input type="date" name="calexInicioParcial1" id="calexInicioParcial1" value="{{old('calexInicioParcial1')}}" required>                          
                    </div>        
                    
                    <div class="col s12 m6 l4">
                        <label for="calexFinParcial1">Fecha fin parcial 1 *</label>  
                        <input type="date" name="calexFinParcial1" id="calexFinParcial1" value="{{old('calexFinParcial1')}}" required>                          
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="calexInicioParcial2">Fecha inicio parcial 2 *</label>  
                        <input type="date" name="calexInicioParcial2" id="calexInicioParcial2" value="{{old('calexInicioParcial2')}}" required>                          
                    </div>        
                    
                    <div class="col s12 m6 l4">
                        <label for="calexFinParcial2">Fecha fin parcial 2 *</label>  
                        <input type="date" name="calexFinParcial2" id="calexFinParcial2" value="{{old('calexFinParcial2')}}" required>                          
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="calexInicioParcial3">Fecha inicio parcial 3* </label>  
                        <input type="date" name="calexInicioParcial3" id="calexInicioParcial3" value="{{old('calexInicioParcial3')}}" required>                          
                    </div>        
                    
                    <div class="col s12 m6 l4">
                        <label for="calexFinParcial3">Fecha fin parcial 3 *</label>  
                        <input type="date" name="calexFinParcial3" id="calexFinParcial3" value="{{old('calexFinParcial3')}}" required>                          
                    </div> 
                </div>
                               
                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="calexInicioOrdinario">Fecha inicio Ordinario *</label>  
                        <input type="date" name="calexInicioOrdinario" id="calexInicioOrdinario" value="{{old('calexInicioOrdinario')}}" required>                          
                    </div>        
                    
                    <div class="col s12 m6 l4">
                        <label for="calexFinOrdinario">Fecha fin Ordinario *</label>  
                        <input type="date" name="calexFinOrdinario" id="calexFinOrdinario" value="{{old('calexFinOrdinario')}}" required>                          
                    </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="calBoletaPublicacion">Fecha Pubicación Boleta *</label>  
                        <input type="date" name="calBoletaPublicacion" id="calBoletaPublicacion" value="{{old('calBoletaPublicacion')}}" required>                          
                    </div> 
                </div>
                <div class="row" style="display: none;">
                    <div class="col s12 m6 l4">
                        <label for="calexInicioExtraordinario">Fecha inicio Extraordinario</label>  
                        <input type="date" name="calexInicioExtraordinario" id="calexInicioExtraordinario" value="{{old('calexInicioExtraordinario')}}">                          
                    </div>        
                    
                    <div class="col s12 m6 l4">
                        <label for="calexFinExtraordinario">Fecha fin Extraordinario</label>  
                        <input type="date" name="calexFinExtraordinario" id="calexFinExtraordinario" value="{{old('calexFinExtraordinario')}}">                          
                    </div> 
                </div>

                @if ($campus_cva == 1)
                <div class="row">
                    <div class="col s12 m6 l4">
                        <label for="eviIniciaCapturaDocentes1">Fecha inicio captura ADAS</label>  
                        <input type="date" name="eviIniciaCapturaDocentes1" id="eviIniciaCapturaDocentes1" value="{{old('eviIniciaCapturaDocentes1')}}">                          
                    </div>        
                    
                    <div class="col s12 m6 l4">
                        <label for="eviFinalizaCapturaDocentes1">Fecha fin captura ADAS</label>  
                        <input type="date" name="eviFinalizaCapturaDocentes1" id="eviFinalizaCapturaDocentes1" value="{{old('eviFinalizaCapturaDocentes1')}}">                          
                    </div> 
                </div>
                @endif

            </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
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




@endsection