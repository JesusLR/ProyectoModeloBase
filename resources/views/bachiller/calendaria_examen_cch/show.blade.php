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
                            <label for="calexInicioParcial4">Fecha inicio parcial 4</label>  
                            <input type="date" name="calexInicioParcial4" id="calexInicioParcial4" value="{{$bachiller_calendarioexamen->calexInicioParcial4}}" readonly>                          
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <label for="calexFinParcial4">Fecha fin parcial 4</label>  
                            <input type="date" name="calexFinParcial4" id="calexFinParcial4" value="{{$bachiller_calendarioexamen->calexFinParcial4}}" readonly>                          
                        </div> 
                    </div>
                                   
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <label for="calexInicioOrdinario">Fecha inicio Recuperación</label>  
                            <input type="date" name="calexInicioOrdinario" id="calexInicioOrdinario" value="{{$bachiller_calendarioexamen->calexInicioOrdinario}}" readonly>                          
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <label for="calexFinOrdinario">Fecha fin Recuperación</label>  
                            <input type="date" name="calexFinOrdinario" id="calexFinOrdinario" value="{{$bachiller_calendarioexamen->calexFinOrdinario}}" readonly>                          
                        </div> 
                    </div>
    
                    <div class="row">
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
                            <label for="calexInicioEspecial">Fecha inicio Especial</label>  
                            <input type="date" name="calexInicioEspecial" id="calexInicioEspecial" value="{{$bachiller_calendarioexamen->calexInicioEspecial}}" readonly>                          
                        </div>        
                        
                        <div class="col s12 m6 l4">
                            <label for="calexFinEspecial">Fecha fin Especial</label>  
                            <input type="date" name="calexFinEspecial" id="calexFinEspecial" value="{{$bachiller_calendarioexamen->calexFinEspecial}}" readonly>                          
                        </div> 
                    </div>
    
                </div>           
            </div>
        </div>
    </div>

    @endsection

    @section('footer_scripts')


    @endsection