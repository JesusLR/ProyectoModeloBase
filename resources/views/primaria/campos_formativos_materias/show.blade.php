@extends('layouts.dashboard')

@section('template_title')
    Primaria campor formativo materia
@endsection


@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_campos_formativos_materias.index')}}" class="breadcrumb">Lista de campos formativos materia</a>
    <label class="breadcrumb">Ver campo formativo materia</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            {{--  <span class="card-title">CAMPO FORMATIVO MATERIA#{{$primaria_campo_formativo_materias->id}}</span>  --}}

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
                        {!! Form::text('ubicacion', $primaria_campo_formativo_materias->ubiClave.'-'.$primaria_campo_formativo_materias->ubiNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('ubicacion', 'Ubicación', array('class' => '')); !!}
                    </div>
                  </div> 
                  <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('departamento', $primaria_campo_formativo_materias->depClave.'-'.$primaria_campo_formativo_materias->depNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('departamento', 'Departamento', array('class' => '')); !!}
                    </div>
                  </div> 
                  <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('escuela', $primaria_campo_formativo_materias->escClave.'-'.$primaria_campo_formativo_materias->escNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('escuela', 'Escuela', array('class' => '')); !!}
                    </div>
                  </div> 
                </div>

                <div class="row">
                  <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('programa', $primaria_campo_formativo_materias->progClave.'-'.$primaria_campo_formativo_materias->progNombre, array('readonly' => 'true')) !!}
                        {!! Form::label('programa', 'Programa', array('class' => '')); !!}
                    </div>
                  </div> 
                  <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('plan', $primaria_campo_formativo_materias->planClave, array('readonly' => 'true')) !!}
                        {!! Form::label('plan', 'Plan', array('class' => '')); !!}
                    </div>
                  </div> 
                  <div class="col s12 m6 l4">
                    <div class="input-field">
                        {!! Form::text('escuela', $primaria_campo_formativo_materias->matSemestre, array('readonly' => 'true')) !!}
                        {!! Form::label('escuela', 'Grado', array('class' => '')); !!}
                    </div>
                  </div> 
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('camFormativos', $primaria_campo_formativo_materias->camFormativos, array('readonly' => 'true')) !!}
                            {!! Form::label('camFormativos', 'Campo Formativo', array('class' => '')); !!}
                        </div>
                    </div>   
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('primaria_campo_formativo_id', $primaria_campo_formativo_materias->matClave.'-'.$primaria_campo_formativo_materias->matNombre, array('readonly' => 'true')) !!}
                            {!! Form::label('primaria_campo_formativo_id', 'Materia', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>

                
            </div>
          </div>
        </div>
    </div>
  </div>

@endsection
