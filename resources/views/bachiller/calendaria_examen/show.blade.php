@extends('layouts.dashboard')

@section('template_title')
    Bachiller fechas calendario examen
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_calendario_examen')}}" class="breadcrumb">Lista de fechas calendario examen</a>
    <label class="breadcrumb">Ver fechas calendario examen</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">FECHAS CALENDARIO EXAMEN #{{$bachiller_calendarioexamen->id}}</span>

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
                            {!! Form::label('ubicacion_id', 'Campus', array('class' => '')); !!}
                            <input type="text" value="{{$bachiller_calendarioexamen->ubiClave.'-'.$bachiller_calendarioexamen->ubiNombre}}" readonly>                            
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                            <input type="text" value="{{$bachiller_calendarioexamen->depClave.'-'.$bachiller_calendarioexamen->depNombre}}" readonly>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                            <input type="text" value="{{$bachiller_calendarioexamen->escClave.'-'.$bachiller_calendarioexamen->escNombre}}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Período', array('class' => '')); !!}
                            <input type="text" value="{{$bachiller_calendarioexamen->perNumero.'-'.$bachiller_calendarioexamen->perAnio}}" readonly>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                            <input type="text" value="{{$bachiller_calendarioexamen->progClave.'-'.$bachiller_calendarioexamen->progNombre}}" readonly>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('plan_id', 'Plan', array('class' => '')); !!}
                            <input type="text" value="{{$bachiller_calendarioexamen->planClave}}" readonly>
                        </div>                  
                        
                    </div>              
    
    
                    <br>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="calexInicioParcial1">Fecha inicio parcial 1</label>  
                            <input type="date" name="calexInicioParcial1" id="calexInicioParcial1" value="{{$bachiller_calendarioexamen->calexInicioParcial1}}}}" readonly>                          
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <label for="calexFinParcial1">Fecha fin parcial 1</label>  
                            <input type="date" name="calexFinParcial1" id="calexFinParcial1" value="{{$bachiller_calendarioexamen->calexFinParcial1}}" readonly>                          
                        </div> 
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="calexInicioParcial2">Fecha inicio parcial 2</label>  
                            <input type="date" name="calexInicioParcial2" id="calexInicioParcial2" value="{{$bachiller_calendarioexamen->calexInicioParcial2}}" readonly>                          
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <label for="calexFinParcial2">Fecha fin parcial 2</label>  
                            <input type="date" name="calexFinParcial2" id="calexFinParcial2" value="{{$bachiller_calendarioexamen->calexFinParcial2}}" readonly>                          
                        </div> 
                    </div>
    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="calexInicioParcial3">Fecha inicio parcial 3</label>  
                            <input type="date" name="calexInicioParcial3" id="calexInicioParcial3" value="{{$bachiller_calendarioexamen->calexInicioParcial3}}" readonly>                          
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <label for="calexFinParcial3">Fecha fin parcial 3</label>  
                            <input type="date" name="calexFinParcial3" id="calexFinParcial3" value="{{$bachiller_calendarioexamen->calexFinParcial3}}" readonly>                          
                        </div> 
                    </div>
                                   
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="calexInicioOrdinario">Fecha inicio Ordinario</label>  
                            <input type="date" name="calexInicioOrdinario" id="calexInicioOrdinario" value="{{$bachiller_calendarioexamen->calexInicioOrdinario}}" readonly>                          
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <label for="calexFinOrdinario">Fecha fin Ordinario</label>  
                            <input type="date" name="calexFinOrdinario" id="calexFinOrdinario" value="{{$bachiller_calendarioexamen->calexFinOrdinario}}" readonly>                          
                        </div> 
                    </div>
    
                    <div class="row" style="display: none;">
                        <div class="col s12 m6 l4">
                            <label for="calexInicioExtraordinario">Fecha inicio Extraordinario</label>  
                            <input type="date" name="calexInicioExtraordinario" id="calexInicioExtraordinario" value="{{$bachiller_calendarioexamen->calexInicioExtraordinario}}" readonly>                          
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <label for="calexFinExtraordinario">Fecha fin Extraordinario</label>  
                            <input type="date" name="calexFinExtraordinario" id="calexFinExtraordinario" value="{{$bachiller_calendarioexamen->calexFinExtraordinario}}" readonly>                          
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="calBoletaPublicacion">Fecha Pubicación Boleta</label>  
                            <input type="date" name="calBoletaPublicacion" id="calBoletaPublicacion" value="{{$bachiller_calendarioexamen->calBoletaPublicacion}}" readonly>                          
                        </div> 
                    </div>


                    @if ($campus_cva == 1)
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="eviIniciaCapturaDocentes1">Fecha inicio captura ADAS</label>  
                            <input type="date" name="eviIniciaCapturaDocentes1" id="eviIniciaCapturaDocentes1" value="{{$bachiller_calendarioexamen->eviIniciaCapturaDocentes1}}" readonly>                          
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <label for="eviFinalizaCapturaDocentes1">Fecha fin captura ADAS</label>  
                            <input type="date" name="eviFinalizaCapturaDocentes1" id="eviFinalizaCapturaDocentes1" value="{{$bachiller_calendarioexamen->eviFinalizaCapturaDocentes1}}" readonly>                          
                        </div> 
                    </div>
                    @endif
    
                </div>           
            </div>
        </div>
    </div>

    @endsection

    @section('footer_scripts')


    @endsection