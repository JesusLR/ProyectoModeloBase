@extends('layouts.dashboard')

@section('template_title')
    Idiomas materia
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_materia')}}" class="breadcrumb">Lista de materias</a>
    <label class="breadcrumb">Agregar materia</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'idiomas.idiomas_materia.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR MATERIA</span>

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
                            {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('matClave', 'Clave de la materia *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombre', NULL, array('id' => 'matNombre', 'class' => 'validate','required','maxlength'=>'60')) !!}
                            {!! Form::label('matNombre', 'Nombre de la materia *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombreCorto', NULL, array('id' => 'matNombreCorto', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('matNombreCorto', 'Nombre corto de la materia *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('matSemestre', 'Semestre *', array('class' => '')); !!}
                        <select id="matSemestre" class="browser-default validate select2" required name="matSemestre" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('matCreditos', 'Créditos *', array('class' => '')); !!}
                        <select id="matCreditos" class="browser-default validate select2" required name="matCreditos" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('matClasificacion', 'Clasificación', array('class' => '')); !!}
                        <select id="matClasificacion" class="browser-default validate select2" name="matClasificacion" style="width: 100%;">
                            <option value="B" {{old('matClasificacion') == "B" ? "selected": ""}}>BÁSICA</option>
                            <option value="O" {{old('matClasificacion') == "O" ? "selected": ""}}>OPTATIVA</option>
                            <option value="U" {{old('matClasificacion') == "U" ? "selected": ""}}>OCUPA</option>
                            <option value="X" {{old('matClasificacion') == "X" ? "selected": ""}}>EXTRAOFICIAL</option>
                            <option value="C" {{old('matClasificacion') == "C" ? "selected": ""}}>COMPLEMENTARIA</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('matTipoAcreditacion', 'Tipo de acreditación', array('class' => '')); !!}
                        <select id="matTipoAcreditacion" class="browser-default validate select2" name="matTipoAcreditacion" style="width: 100%;">
                            <option value="N" {{old('matTipoAcreditacion') == "N" ? "selected": ""}}>NUMÉRICO</option>
                            <option value="A" {{old('matTipoAcreditacion') == "A" ? "selected": ""}}>ALFABÉTICO</option>
                            <option value="M" {{old('matTipoAcreditacion') == "M" ? "selected": ""}}>MIXTO</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matPorcentajeParcial', NULL, array('id' => 'matPorcentajeParcial', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('matPorcentajeParcial', 'Parcial %', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matPorcentajeOrdinario', NULL, array('id' => 'matPorcentajeOrdinario', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('matPorcentajeOrdinario', 'Ordinario %', array('class' => '')); !!}
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