@extends('layouts.dashboard')

@section('template_title')
    Idiomas cuota
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_cuota')}}" class="breadcrumb">Lista de cuotas</a>
    <label class="breadcrumb">Editar cuota</label>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['idiomas.idiomas_cuota.update', $cuota->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR CUOTA #{{$cuota->id}}</span>

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
                        <select id="programa_id" class="browser-default validate select2" data-programa-id="{{old('programa_id') ?: $cuota->programa_id}}" required name="programa_id" style="width: 100%;">
                            @foreach($programas as $programa)
                                <option @if($cuota->programa_id ==  $programa->id) selected @endif value="{{ $programa->id }}">{{ $programa->progClave }} | {{ $programa->progNombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoAnioPago', $cuota->cuoAnioPago, array('id' => 'cuoAnioPago', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('cuoAnioPago', 'Año inicio curso *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoDescuentoMensualidad', $cuota->cuoDescuentoMensualidad, array('id' => 'cuoDescuentoMensualidad', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('cuoDescuentoMensualidad', 'Descuento Mensualidad *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoDescuentoInscripcion', $cuota->cuoDescuentoInscripcion, array('id' => 'cuoDescuentoInscripcion', 'class' => 'validate','required','maxlength'=>'60')) !!}
                            {!! Form::label('cuoDescuentoInscripcion', 'Descuento Inscripción *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoImporteMensualidad', $cuota->cuoImporteMensualidad, array('id' => 'cuoImporteMensualidad', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('cuoImporteMensualidad', 'Importe Mensualidad *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoImporteVencimiento', $cuota->cuoImporteVencimiento, array('id' => 'cuoImporteVencimiento', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('cuoImporteVencimiento', 'Importe Vencimiento *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoNumeroCuenta', $cuota->cuoNumeroCuenta, array('id' => 'cuoNumeroCuenta', 'class' => 'validate','required','maxlength'=>'15')) !!}
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
                            {!! Form::text('cuoImporteInscripcion1', $cuota->cuoImporteInscripcion1, array('id' => 'cuoImporteInscripcion1', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('cuoImporteInscripcion1', 'Primer Plazo *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cuoFechaInscripcion1', 'Fecha Límite *', array('class' => '')); !!}
                        {!! Form::date('cuoFechaInscripcion1', $cuota->cuoFechaInscripcion1, array('id' => 'cuoFechaInscripcion1', 'class' => 'validate','required','maxlength'=>'45')) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoImporteInscripcion2', $cuota->cuoImporteInscripcion2, array('id' => 'cuoImporteInscripcion2', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('cuoImporteInscripcion2', 'Primer Plazo *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cuoFechaInscripcion2', 'Fecha Límite *', array('class' => '')); !!}
                        {!! Form::date('cuoFechaInscripcion2', $cuota->cuoFechaInscripcion2, array('id' => 'cuoFechaInscripcion2', 'class' => 'validate','required','maxlength'=>'45')) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('cuoImporteInscripcion3', $cuota->cuoImporteInscripcion3, array('id' => 'cuoImporteInscripcion3', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('cuoImporteInscripcion3', 'Primer Plazo *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cuoFechaInscripicion3', 'Fecha Límite *', array('class' => '')); !!}
                        {!! Form::date('cuoFechaInscripicion3', $cuota->cuoFechaInscripicion3, array('id' => 'cuoFechaInscripicion3', 'class' => 'validate','required','maxlength'=>'45')) !!}
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
                    Materialize.updateTextFields();
                    $('#matPorcentajeOrdinario').val(calc.res);
                }
            } else {
                Materialize.updateTextFields();
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
                    Materialize.updateTextFields();
                    $('#matPorcentajeParcial').val(calc.res);
                }
            } else {
                Materialize.updateTextFields();
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