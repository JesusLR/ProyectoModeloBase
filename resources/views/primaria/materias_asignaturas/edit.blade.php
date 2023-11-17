
@extends('layouts.dashboard')

@section('template_title')
    Primaria materia asignatura
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('primaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('primaria.primaria_materias_asignaturas.index')}}" class="breadcrumb">Lista de materias asignaturas</a>
    <label class="breadcrumb">Editar materia asignatura</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['primaria.primaria_materias_asignaturas.update', $primaria_materias_asignaturas->id])) }}
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
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            <option value="{{$primaria_materias_asignaturas->ubicacion_id}}">{{$primaria_materias_asignaturas->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-idold="{{old('departamento_id')}}"
                            class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            <option value="{{$primaria_materias_asignaturas->departamento_id}}">{{$primaria_materias_asignaturas->depClave.'-'.$primaria_materias_asignaturas->depNombre}}</option>

                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-idold="{{old('escuela_id')}}"
                            class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            <option value="{{$primaria_materias_asignaturas->escuela_id}}">{{$primaria_materias_asignaturas->escClave.'-'.$primaria_materias_asignaturas->escNombre}}</option>

                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-idold="{{old('programa_id')}}"
                            class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            <option value="{{$primaria_materias_asignaturas->programa_id}}">{{$primaria_materias_asignaturas->progClave.'-'.$primaria_materias_asignaturas->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id"
                            data-plan-idold="{{old('plan_id')}}"
                            class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            <option value="{{$primaria_materias_asignaturas->plan_id}}">{{$primaria_materias_asignaturas->planClave}}</option>

                        </select>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" required name="periodo_id"
                            style="width: 100%;">
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            <option value="{{$primaria_materias_asignaturas->periodo_id}}">{{$primaria_materias_asignaturas->perNumero.'-'.$primaria_materias_asignaturas->perAnioPago}}</option>

                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('matSemestre', 'Grado *', array('class' => '')); !!}
                        <select id="matSemestre" data-gposemestre-idold="{{old('matSemestre')}}" class="browser-default validate select2" required name="matSemestre" style="width: 100%;">
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            <option value="{{$primaria_materias_asignaturas->matSemestre }}">{{$primaria_materias_asignaturas->matSemestre}} </option>
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('primaria_materia_id', 'Materia *', array('class' => '')); !!}
                        <input class="gpoSemestreOld" type="hidden" data-gpoSemestre-idold="{{old('primaria_materia_id')}}">
                        <select id="primaria_materia_id"
                            data-gposemestre-idold="{{old('primaria_materia_id')}}"
                            class="browser-default validate select2" required name="primaria_materia_id" style="width: 100%;">
                            {{--  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>  --}}
                            <option value="{{$primaria_materias_asignaturas->primaria_materia_id}}">{{$primaria_materias_asignaturas->matClave.'-'.$primaria_materias_asignaturas->matNombre}}</option>

                        </select>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matClaveAsignatura', $primaria_materias_asignaturas->matClaveAsignatura, array('id' => 'matClaveAsignatura', 'class' => '','maxlength'=>'4')) !!}
                            {!! Form::label('matClaveAsignatura', 'Clave asignatura *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombreAsignatura', $primaria_materias_asignaturas->matNombreAsignatura, array('id' => 'matNombreAsignatura', 'class' => '','maxlength'=>'150')) !!}
                            {!! Form::label('matNombreAsignatura', 'Nombre asignatura *', array('class' => '')); !!}
                        </div>
                    </div>     
                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" onKeyDown="if(this.value.length==3) return false;" max="100" name="matAsignaturaPorcentaje" id="matAsignaturaPorcentaje" value="{{$primaria_materias_asignaturas->matAsignaturaPorcentaje}}">
                            {!! Form::label('matAsignaturaPorcentaje', 'Porcentaje *', array('class' => '')); !!}
                        </div>
                    </div> 
                </div>


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




@endsection