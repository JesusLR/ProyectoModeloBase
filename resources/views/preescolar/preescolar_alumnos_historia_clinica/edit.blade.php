@extends('layouts.dashboard')

@section('template_title')
Historial clinica
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('preescolar_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{url('clinica')}}" class="breadcrumb">Lista de historial</a>
<a href="{{url('clinica/'.$historia->id.'/edit')}}" class="breadcrumb">Editar historial</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['clinica.update', $historia->id])) }}
        {{--  @if (isset($candidato))
            <input type="hidden" name="candidato_id" value="{{$candidato->id}}" />
        @endif --}}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">EDITAR HISTORIAL CLINICA</span>

                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#general">General</a></li>
                            <li class="tab"><a href="#familiares">Familiares</a></li>
                            <li class="tab"><a href="#embarazo">Embarazo</a></li>
                            <li class="tab"><a href="#medica">Medica</a></li>
                            <li class="tab"><a href="#habitos">Hábitos</a></li>
                            <li class="tab"><a href="#desarrollo">Desarrollo</a></li>
                            <li class="tab"><a href="#heredo">Heredo</a></li>
                            <li class="tab"><a href="#social">Social</a></li>
                            <li class="tab"><a href="#conducta">Conducta</a></li>
                            <li class="tab"><a href="#actividades">Actividades</a></li>
                        </ul>
                    </div>
                </nav>

                @php
                use Carbon\Carbon;
                $fechaActual = Carbon::now('CDT')->format('Y-m-d');
                @endphp

                {{-- GENERAL BAR--}}
                <div id="general">
           <br>
                    <div class="row" style="background-color:#ECECEC;">
                        <p style="text-align: center;font-size:1.2em;">DATOS GENERALES DEL ALUMNO (A)</p>
                    </div>
                    <div class="row">
                        {{--  /* --------------------------- Seleccionar alumno --------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('nombreAlumno', 'Nombre(s)', array('class' =>
                                '')); !!}
                                {!! Form::text('nombreAlumno', $historia->perNombre, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('perApellido1', 'Apellido paterno', array('class' =>
                                '')); !!}
                                {!! Form::text('perApellido1', $historia->perApellido1, array('readonly' => 'true')) !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('perApellido2', 'Apellido materno', array('class' =>
                                '')); !!}
                                {!! Form::text('perApellido2', $historia->perApellido2, array('readonly' => 'true')) !!}
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                                {!! Form::label('perFechaNac', 'Fecha de nacimiento', array('class' =>
                                '')); !!}
                                {!! Form::date('perFechaNac', $historia->perFechaNac, array('readonly' => 'true')) !!}
                      
                        </div>

                        <div class="col s12 m6 l4">
                            {!! Form::label('paisAlumno', 'País', array('class' => '')); !!}
                            <select id="paisAlumno" class="browser-default validate" name="paisAlumno" style="width: 100%; pointer-events: none">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($paises as $pais)
                                <option value="{{$pais->id}}" {{ $historia->pais_id == $pais->id ? 'selected="selected"' : '' }}>
                                    {{$pais->paisNombre}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('estadoAlumno_id', 'Estado', array('class' => '')); !!}
                            <select id="estadoAlumno_id" class="browser-default validate" name="estadoAlumno_id"
                                style="width: 100%; pointer-events: none">
                                <option value="">{{$historia->edoNombre}}</option>
                            </select>
                        </div>   
                        
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('municipioAlumno_id', 'Municipio', ['class' => '']); !!}
                            <select id="municipioAlumno_id" class="browser-default validate" name="municipioAlumno_id"
                                style="width: 100%; pointer-events: none">
                                <option value="">{{$historia->munNombre}}</option>

                            </select>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('perCurp', 'CURP', array('class' =>
                                '')); !!}
                                {!! Form::text('perCurp', $historia->perCurp, array('readonly' => 'true')) !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('hisEdadActualMeses', 'Edad actual (Años y meses)', array('class' => '')); !!}
                                {!! Form::text('hisEdadActualMeses', $historia->hisEdadActualMeses, array('id' => 'hisEdadActualMeses',
                                'class' =>
                                'validate', 'maxlength'=>'40')) !!}
                            </div>
                        </div>                      

                        
                    </div>

                    <div class="row">
                        {{--  /* ----------------------------- tipo de sangre ----------------------------- */  --}}                        
                        <div class="col s12 m6 l4">
                            {!! Form::label('hisTipoSangre', 'Tipo de sangre', array('class' => '')); !!}
                            <select id="hisTipoSangre" class="browser-default validate" name="hisTipoSangre" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="O NEGATIVO" {{ $historia->hisTipoSangre == "O NEGATIVO" ? 'selected="selected"' : '' }}>O negativo</option>
                                <option value="O POSITIVO" {{ $historia->hisTipoSangre == "O POSITIVO" ? 'selected="selected"' : '' }}>O positivo</option>
                                <option value="A NEGATIVO" {{ $historia->hisTipoSangre == "A NEGATIVO" ? 'selected="selected"' : '' }}>A negativo</option>
                                <option value="A POSITIVO" {{ $historia->hisTipoSangre == "A POSITIVO" ? 'selected="selected"' : '' }}>A positivo</option>
                                <option value="B NEGATIVO" {{ $historia->hisTipoSangre == "B NEGATIVO" ? 'selected="selected"' : '' }}>B negativo</option>
                                <option value="B POSITIVO" {{ $historia->hisTipoSangre == "B POSITIVO" ? 'selected="selected"' : '' }}>B positivo</option>
                                <option value="AB NEGATIVO" {{ $historia->hisTipoSangre == "AB NEGATIVO" ? 'selected="selected"' : '' }}>AB negativo</option>
                                <option value="AB POSITIVO" {{ $historia->hisTipoSangre == "AB POSITIVO" ? 'selected="selected"' : '' }}>AB positivo</option>                           
                            </select>
                        </div>

                        {{--  /* -------------------------------- alergias -------------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('hisAlergias', 'Alergias', array('class' => '')); !!}
                                {!! Form::text('hisAlergias', $historia->hisAlergias, array('id' => 'hisAlergias', 'class' => '', 'maxlength'=>'9000')) !!}
                            </div>
                        </div>
                        {{--  /* ------------------------- escuela de procendencia ------------------------ */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('hisEscuelaProcedencia', 'Escuela de procedencia*', array('class' =>
                                '')); !!}
                                {!! Form::text('hisEscuelaProcedencia', $historia->hisEscuelaProcedencia, array('id' => 'hisEscuelaProcedencia',
                                'class' =>
                                'validate', 'maxlength'=>'80')) !!}
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        {{--  /* -------------------------- Último grado cursado -------------------------- */  --}}
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::label('hisUltimoGrado', 'Último grado cursado', array('class' =>
                                '')); !!}
                                {!! Form::text('hisUltimoGrado', $historia->hisUltimoGrado, array('id' => 'hisUltimoGrado',
                                'class' => 'validate', 'maxlength'=>'20')) !!}
                            </div>
                        </div>

                        {{--  /* -------------- ¿Ha recursado algún año o se lo han sugerido? ------------- */  --}}
                        <div class="col s12 m6 l4">
                            {!! Form::label('hisRecursado', '¿Ha recursado algún año o se lo han sugerido?',
                            array('class' =>
                            '')); !!}
                            <select id="hisRecursado" class="browser-default" name="hisRecursado" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UN OPCIÓN</option>
                                <option value="SI" {{ $historia->hisRecursado == "SI" ? 'selected="selected"' : '' }}>SI</option>
                                <option value="NO" {{ $historia->hisRecursado == "NO" ? 'selected="selected"' : '' }}>NO</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l12">
                            <div id="detalleRecursamiento" class="input-field" style="display: none">                         
                                {!! Form::label('hisRecursadoDetalle', 'Detalle de año cursado', array('class' =>
                                '')); !!}
                                {!! Form::text('hisRecursadoDetalle', $historia->hisRecursadoDetalle, array('id' => 'hisRecursadoDetalle',
                                'class' =>
                                'validate')) !!}
                            </div>
                        </div>                       
                    </div>

                </div>

                {{-- FAMILIARES BAR --}}
                @include('preescolar.preescolar_alumnos_historia_clinica.familiares')

                {{--  EMBARAZO Y NACIMIENTO   --}}
                @include('preescolar.preescolar_alumnos_historia_clinica.embarazo')

                {{--  HISTORIA MEDICA   --}}
                @include('preescolar.preescolar_alumnos_historia_clinica.medica')

                {{--  HÁBITOS E HIGIENE  --}}
                @include('preescolar.preescolar_alumnos_historia_clinica.habitos')

                {{--  HISTORIA DEL DESARROLLO  --}}
                @include('preescolar.preescolar_alumnos_historia_clinica.desarrollo')

                {{--  ANTECEDENTES HEREDO FAMILIARES  --}}
                @include('preescolar.preescolar_alumnos_historia_clinica.heredo')

                {{--  RELACIONES SOCIALES  --}}
                @include('preescolar.preescolar_alumnos_historia_clinica.sociales')

                {{-- CONDUCTA  --}}
                @include('preescolar.preescolar_alumnos_historia_clinica.conducta')

                {{-- ACTIVIDADES QUE REALIZA  --}}
                @include('preescolar.preescolar_alumnos_historia_clinica.actividades')


            </div>
            <input type="hidden" name="empleado_id" id="empleado_id" value="">
            <div class="card-action">
                {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}

            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

{{-- Script de funciones auxiliares  --}}
{!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}

@endsection

@section('footer_scripts')

@include('preescolar.scripts.municipios')
@include('preescolar.scripts.estados')

<script>


    if($('select[name=hisRecursado]').val() == "SI"){
        $("#detalleRecursamiento").show(); 
        $("#hisRecursadoDetalle").prop('required', false);
    }else{
        $("#hisRecursadoDetalle").prop('required', false);
        $("#detalleRecursamiento").hide();         
    }

    {{--  muestra el input para agregar detalle de año cursado si la respuesta es SI  --}}
    $("select[name=hisRecursado]").change(function(){
        if($('select[name=hisRecursado]').val() === "SI"){
            $("#detalleRecursamiento").show();            
            $("#hisRecursadoDetalle").prop('required', false);

        }else{
            $("#hisRecursadoDetalle").removeAttr('required'); 
            $("#hisRecursadoDetalle").prop('required', false);
            $("#hisRecursadoDetalle").val("");   

        }
    });

    $("select[name=famRelacionMadre]").change(function(){
        if($('select[name=famRelacionMadre]').val() != ""){
            $("#divFrecuencia").show();            
        }else{
            $("#divFrecuencia").hide();          

        }
    });

    $("select[name=famRelacionPadre]").change(function(){
        if($('select[name=famRelacionPadre]').val() != ""){
            $("#divFrecuenciaPadre").show();            
        }else{
            $("#divFrecuenciaPadre").hide();          

        }
    });

    $("select[name=famEstadoCivilPadres]").change(function(){
        if($('select[name=famEstadoCivilPadres]').val() == "DIVORCIADOS"){
            $("#divSeparado").show(); 
            $("#famSeparado").prop('required', false);
    
           
        }else{
            $("#famSeparado").prop('required', false);
            $("#divSeparado").hide();  
            $("#famSeparado").val("");       

        }
    });
    
    $("select[name=nacComplicacionesEmbarazo]").change(function(){
        if($('select[name=nacComplicacionesEmbarazo]').val() == "SI"){
            $("#divEmbarazo").show(); 
            $("#nacCualesEmbarazo").prop('required', false);

           
        }else{
            $("#nacCualesEmbarazo").prop('required', false);
            $("#divEmbarazo").hide();    
        }
    });

    $("select[name=nacComplicacionesParto]").change(function(){
        if($('select[name=nacComplicacionesParto]').val() == "SI"){
            $("#divParto").show(); 
            $("#nacCualesParto").prop('required', false);
 
           
        }else{
            $("#nacCualesParto").prop('required', false);
            $("#divParto").hide();    
            $("#nacCualesParto").val("");     

        }
    });

    $("select[name=nacComplicacionDespues]").change(function(){
        if($('select[name=nacComplicacionDespues]').val() == "SI"){
            $("#divDespues").show(); 
            $("#nacCualesDespues").prop('required', false);
   
           
        }else{
            $("#nacCualesDespues").removeAttr('required');
            $("#divDespues").hide();      
            $("#nacCualesDespues").prop('required', false);

        }
    });

    

    $("select[name=nacLactancia]").change(function(){
        if($('select[name=nacLactancia]').val() != "MATERNA"){          
                       
            $("#divLactancia").show(); 
            $("#nacActualmente").prop('required', false);
 
        }else{                     
            
            $("#nacActualmente").prop('required', false);
            $("#divLactancia").hide();
            $("#nacActualmente").val("");
        }
    });




        $("select[name=famRelacionMadre]").change(function(){
            if($('select[name=famRelacionMadre]').val() != ""){          
                           
                $("#divFrecuencia").show(); 
            }else{                    
                
                $("#divFrecuencia").hide();
            }
        });
</script>


@endsection