
@extends('layouts.dashboard')

@section('template_title')
    Primaria materia asignatura
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_materias_asignaturas.index')}}" class="breadcrumb">Lista de materias asignaturas</a>
    <label class="breadcrumb">Ver materia asignatura</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR MATERIA ASIGNATURA #{{$primaria_materias_asignaturas->id}}</span>

            <input type="hidden" name="asignatura_id" id="" value="{{$primaria_materias_asignaturas->id}}">
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
                        <input type="text" name="" id="" value="{{$primaria_materias_asignaturas->ubiNombre}}" readonly>                    
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <input type="text" name="" id="" value="{{$primaria_materias_asignaturas->depClave.'-'.$primaria_materias_asignaturas->depNombre}}" readonly>                   
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <input type="text" name="" id="" value="{{$primaria_materias_asignaturas->escClave.'-'.$primaria_materias_asignaturas->escNombre}}" readonly>                 
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <input type="text" name="" id="" value="{{$primaria_materias_asignaturas->progClave.'-'.$primaria_materias_asignaturas->progNombre}}" readonly>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <input type="text" name="" id="" value="{{$primaria_materias_asignaturas->planClave}}" readonly>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <input type="text" name="" id="" value="{{$primaria_materias_asignaturas->perNumero.'-'.$primaria_materias_asignaturas->perAnioPago}}" readonly>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('matSemestre', 'Grado *', array('class' => '')); !!}
                        <input type="text" name="" id="" value="{{$primaria_materias_asignaturas->matSemestre}}" readonly>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('primaria_materia_id', 'Materia *', array('class' => '')); !!}
                        <input class="gpoSemestreOld" type="hidden" data-gpoSemestre-idold="{{old('primaria_materia_id')}}">
                        <input type="text" name="" id="" value="{{$primaria_materias_asignaturas->matClave.'-'.$primaria_materias_asignaturas->matNombre}}" readonly>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matClaveAsignatura', $primaria_materias_asignaturas->matClaveAsignatura, array('id' => 'matClaveAsignatura', 'class' => '','maxlength'=>'4', 'readonly')) !!}
                            {!! Form::label('matClaveAsignatura', 'Clave asignatura *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombreAsignatura', $primaria_materias_asignaturas->matNombreAsignatura, array('id' => 'matNombreAsignatura', 'class' => '','maxlength'=>'150', 'readonly')) !!}
                            {!! Form::label('matNombreAsignatura', 'Nombre asignatura *', array('class' => '')); !!}
                        </div>
                    </div>     
                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" readonly onKeyDown="if(this.value.length==3) return false;" max="100" name="matAsignaturaPorcentaje" id="matAsignaturaPorcentaje" value="{{$primaria_materias_asignaturas->matAsignaturaPorcentaje}}">
                            {!! Form::label('matAsignaturaPorcentaje', 'Porcentaje *', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>


          </div>
         
        </div>
    </div>
  </div>

@endsection

@section('footer_scripts')




@endsection