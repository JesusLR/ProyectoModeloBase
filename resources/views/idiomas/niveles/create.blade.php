@extends('layouts.dashboard')

@section('template_title')
    Idiomas nivel
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_nivel')}}" class="breadcrumb">Lista de niveles</a>
    <label class="breadcrumb">Agregar nivel</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'idiomas.idiomas_nivel.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR NIVEL</span>

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
                        {!! Form::label('programa_id', 'Clave del programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($programas as $programa)
                            <option value="{{ $programa->id }}">{{ $programa->progClave }} | {{ $programa->progNombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Clave del plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('nivGrado', NULL, array('id' => 'nivGrado', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('nivGrado', 'Número de nivel *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivDescripcion', NULL, array('id' => 'nivDescripcion', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('nivDescripcion', 'Descripción de nivel *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte1', NULL, array('id' => 'nivPorcentajeReporte1', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeReporte1', 'Reporte 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte2', NULL, array('id' => 'nivPorcentajeReporte2', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeReporte2', 'Reporte 2', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeMidterm', NULL, array('id' => 'nivPorcentajeMidterm', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeMidterm', 'Ex.Mid.Term.', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeProyecto1', NULL, array('id' => 'nivPorcentajeProyecto1', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeProyecto1', 'Proyecto 1', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte3', NULL, array('id' => 'nivPorcentajeReporte3', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeReporte3', 'Reporte 3', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte4', NULL, array('id' => 'nivPorcentajeReporte4', 'class' => 'validate underAhundred','required','maxlength'=>'45')) !!}
                            {!! Form::label('nivPorcentajeReporte4', 'Reporte 4', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeFinal', NULL, array('id' => 'nivPorcentajeFinal', 'class' => 'validate underAhundred','required','maxlength'=>'45')) !!}
                            {!! Form::label('nivPorcentajeFinal', 'Final Ex.', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeProyecto2', NULL, array('id' => 'nivPorcentajeProyecto2', 'class' => 'validate underAhundred','required','maxlength'=>'45')) !!}
                            {!! Form::label('nivPorcentajeProyecto2', 'Proyecto 2', array('class' => '')); !!}
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
<script>
    (function () {

        // Metodo que devuelve la sumatoria de todos los valores de los campos cuya clase es .underAhundred
        const sum = () => $('.underAhundred').toArray().reduce( (sum,el) => sum + Number(el.value), 0 );

        // Cada vez que el usuario escriba se evalua la sumatoria. Si es mayor a 100 lanza un mensaje.
        $('.underAhundred').keyup(function () {
            const total = sum();
            if (total > 100) swal({
                type: 'warning',
                title: 'Checar porcentajes',
                text: 'La suma de los campos debe ser menor a 100'
            });
        });

        $("#programa_id").change( event => {
            $("#plan_id").empty();
            $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
            $.get(base_url+`/idiomas_nivel/planes/${event.target.value}`,function(res,sta){
                res.forEach(element => {
                    $("#plan_id").append(`<option value=${element.id}>${element.planClave}</option>`);             
                });
            });
        });

    })();
</script>
@endsection