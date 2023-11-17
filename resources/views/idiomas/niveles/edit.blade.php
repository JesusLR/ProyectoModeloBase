@extends('layouts.dashboard')

@section('template_title')
    Idiomas nivel
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_nivel')}}" class="breadcrumb">Lista de niveles</a>
    <label class="breadcrumb">Editar nivel</label>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['idiomas.idiomas_nivel.update', $nivel->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR NIVEL #{{$nivel->id}}</span>

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
                        {!! Form::label('programa_id', 'Clave de programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" data-programa-id="{{old('programa_id') ?: $nivel->programa_id}}" required name="programa_id" style="width: 100%;">
                            @foreach($programas as $programa)
                                <option @if($nivel->programa_id ==  $programa->id) selected @endif value="{{ $programa->id }}">{{ $programa->progClave }} | {{ $programa->progNombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Clave del plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" data-plan-id="{{old('plan_id') ?: $nivel->plan_id}}" required name="plan_id" style="width: 100%;">
                            @foreach($planes as $plan)
                                <option @if($nivel->plan_id ==  $plan->id) selected @endif value="{{ $plan->id }}">{{ $plan->planClave }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('nivGrado', $nivel->nivGrado, array('id' => 'nivGrado', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('nivGrado', 'Número de nivel *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivDescripcion', $nivel->nivDescripcion, array('id' => 'nivDescripcion', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('nivDescripcion', 'Descripción de nivel *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte1', $nivel->nivPorcentajeReporte1, array('id' => 'nivPorcentajeReporte1', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeReporte1', 'Reporte 1 *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte2', $nivel->nivPorcentajeReporte2, array('id' => 'nivPorcentajeReporte2', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeReporte2', 'Reporte 2 *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeMidterm', $nivel->nivPorcentajeMidterm, array('id' => 'nivPorcentajeMidterm', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeMidterm', 'Ex.Mid.Term. *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeProyecto1', $nivel->nivPorcentajeProyecto1, array('id' => 'nivPorcentajeProyecto1', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeProyecto1', 'Proyecto 1 *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte3', $nivel->nivPorcentajeReporte3, array('id' => 'nivPorcentajeReporte3', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeReporte3', 'Reporte 3 *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeReporte4', $nivel->nivPorcentajeReporte4, array('id' => 'nivPorcentajeReporte4', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeReporte4', 'Reporte 4 *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeFinal', $nivel->nivPorcentajeFinal, array('id' => 'nivPorcentajeFinal', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeFinal', 'Final Ex. *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('nivPorcentajeProyecto2', $nivel->nivPorcentajeProyecto2, array('id' => 'nivPorcentajeProyecto2', 'class' => 'validate underAhundred','required','maxlength'=>'3')) !!}
                            {!! Form::label('nivPorcentajeProyecto2', 'Proyecto 2 *', array('class' => '')); !!}
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