@extends('layouts.dashboard')

@section('template_title')
    Idiomas cuota
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_cuota')}}" class="breadcrumb">Lista de cuotas</a>
    <label class="breadcrumb">Agregar cuota</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'idiomas.idiomas_cuota.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR CUOTA</span>

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
                        <div class="input-field">
                            {!! Form::number('cuoAnioPago', NULL, array('id' => 'cuoAnioPago', 'class' => 'validate','required','maxlength'=>'4')) !!}
                            {!! Form::label('cuoAnioPago', 'Año inicio curso *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('cuoDescuentoMensualidad', NULL, array('id' => 'cuoDescuentoMensualidad', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('cuoDescuentoMensualidad', 'Descuento Mensualidad *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('cuoDescuentoInscripcion', NULL, array('id' => 'cuoDescuentoInscripcion', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('cuoDescuentoInscripcion', 'Descuento Inscripción *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('cuoImporteMensualidad', NULL, array('id' => 'cuoImporteMensualidad', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('cuoImporteMensualidad', 'Importe Mensualidad *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('cuoImporteVencimiento', NULL, array('id' => 'cuoImporteVencimiento', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('cuoImporteVencimiento', 'Importe Vencimiento *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('cuoNumeroCuenta', NULL, array('id' => 'cuoNumeroCuenta', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('cuoNumeroCuenta', 'Numero de cuenta *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m12 l12">
                        <hr>
                        <h5>Inscripción</h5>
                        <p>Importes</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('cuoImporteInscripcion1', old('cuoImporteInscripcion1'), array('id' => 'cuoImporteInscripcion1', 'class' => 'validate')) !!}
                            {!! Form::label('cuoImporteInscripcion1', 'Primer Plazo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cuoFechaInscripcion1', 'Fecha Límite', array('class' => '')); !!}
                        {!! Form::date('cuoFechaInscripcion1', \Carbon\Carbon::now(), array('id' => 'cuoFechaInscripcion1', 'class' => 'validate')) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('cuoImporteInscripcion2', old('cuoImporteInscripcion2'), array('id' => 'cuoImporteInscripcion2', 'class' => 'validate')) !!}
                            {!! Form::label('cuoImporteInscripcion2', 'Segundo Plazo', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('cuoFechaInscripcion2', 'Fecha Límite', array('class' => '')); !!}
                        {!! Form::date('cuoFechaInscripcion2', \Carbon\Carbon::now(), array('id' => 'cuoFechaInscripcion2', 'class' => 'validate')) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('cuoImporteInscripcion3', old('cuoImporteInscripcion3'), array('id' => 'cuoImporteInscripcion3', 'class' => 'validate')) !!}
                            {!! Form::label('cuoImporteInscripcion3', 'Tercer Plazo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cuoFechaInscripicion3', 'Fecha Límite', array('class' => '')); !!}
                        {!! Form::date('cuoFechaInscripicion3', \Carbon\Carbon::now(), array('id' => 'cuoFechaInscripicion3', 'class' => 'validate')) !!}
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

        const calculateDifference = (number) => {
            // check is a number
            if (number.isNaN) {
                return {
                    err: true,
                    msg: 'No es un número'
                };
            }

            // check range
            if (number >= 101 || number <= -1) {
                return {
                    err: true,
                    msg: 'Rango entre 0 y 100'
                };
            }

            // calculate difference
            return {
                err: false,
                res: (100 - number).toFixed(0)
            }

        }

        $('#matPorcentajeParcial').keyup(function () {
            let thisVal = $(this).val();
            if (thisVal != '') {
                let calc = calculateDifference(thisVal);
                if (calc.err) {
                    // mostrar mensaje de error
                    swal(calc.msg);
                    $(this).val(0);
                    $('#matPorcentajeOrdinario').val(100);
                } else {
                    $('label[for="matPorcentajeOrdinario"]').addClass('active');
                    $('#matPorcentajeOrdinario').val(calc.res);
                }
            } else {
                $('label[for="matPorcentajeOrdinario"]').removeClass('active');
                $('#matPorcentajeOrdinario').val('');
            }
        });

        $('#matPorcentajeOrdinario').keyup(function () {
            let thisVal = $(this).val();
            if (thisVal != '') {
                let calc = calculateDifference(thisVal);
                if (calc.err) {
                    // mostrar mensaje de error
                    swal(calc.msg);
                    $(this).val(0);
                    $('#matPorcentajeParcial').val(100);
                } else {
                    $('label[for="matPorcentajeParcial"]').addClass('active');
                    $('#matPorcentajeParcial').val(calc.res);
                }
            } else {
                $('label[for="matPorcentajeParcial"]').removeClass('active');
                $('#matPorcentajeParcial').val('');
            }
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