@extends('layouts.dashboard')

@section('template_title')
    Inscrito
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('inscrito')}}" class="breadcrumb">Lista de Inscritos</a>
    <a href="{{url('inscrito/create')}}" class="breadcrumb">Agregar Inscrito</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'inscrito.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">INSCRIBIR POR MATERIA</span>

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
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
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
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cgt_id', 'CGT *', array('class' => '')); !!}
                        <select id="cgt_id" class="browser-default validate select2" required name="cgt_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 ">
                        {!! Form::label('curso_id', 'Alumno preinscrito *', array('class' => '')); !!}
                        <select id="curso_id" class="browser-default validate select2" required name="curso_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 ">
                        {!! Form::label('grupo_id', 'Grupo-Materia *', array('class' => '')); !!}
                        <select id="grupo_id" class="browser-default validate select2" required name="grupo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>
            </div>
          </div>


          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['id'=>'btn_grupo', 'class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

@include('scripts.preferencias')
@include('scripts.departamentos')
@include('scripts.escuelas')
@include('scripts.programas')
@include('scripts.planes')
@include('scripts.periodos')
@include('scripts.cgts')
@include('scripts.cursos')
@include('scripts.inscritos')

<script>
    // ajax
    $('#btn_grupo').click(function (e) {
        let btn = this;
        btn.disabled=true;
        btn.innerText="Cargando datos...";
        e.preventDefault();
        if (!$('#curso_id').val()) {
            swal("Campo alumno preinscrito es requerido");
            btn.disabled=false;
            btn.innerHTML="<i class='material-icons left'>save</i> Guardar";
        } else {
            $.ajax({
                type: 'GET',
                url: base_url + '/api/inscrito_validar_grupo/' + $('#curso_id').val(),
                dataType: 'json',
                data: { curso_id:  $('#curso_id').val() },
                success: function(response) {
                    if (response.bandera) {
                        swal({
                            title: "¿Continuar?",
                            text: "Debe mensualidades del semestre anterior. ¿Desea continuar?",
                            type: "warning",
                            showCancelButton: true,
                            cancelButtonColor: '#DD6B55',
                            confirmButtonText: 'Sí, continuar',
                            cancelButtonText: "No, cancelar",
                            closeOnConfirm: false
                        },
                        function() {
                            $('form').submit();
                        });
                        btn.disabled=false;
                        btn.innerHTML="<i class='material-icons left'>save</i> Guardar";
                    } else {
                        $('form').submit();
                    }
                },
                error: function(Xhr, textMessage, errorMessage) {
                    console.log(errorMessage);
                }
            });
        }
    });
</script>

@endsection