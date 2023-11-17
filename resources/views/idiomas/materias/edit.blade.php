@extends('layouts.dashboard')

@section('template_title')
    Idiomas materia
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('idiomas_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('idiomas_materia')}}" class="breadcrumb">Lista de materias</a>
    <label class="breadcrumb">Editar materia</label>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['idiomas.idiomas_materia.update', $materia->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR MATERIA #{{$materia->id}}</span>

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
                        <select id="programa_id" class="browser-default validate select2" data-programa-id="{{old('programa_id') ?: $materia->programa_id}}" required name="programa_id" style="width: 100%;">
                            @foreach($programas as $programa)
                                <option @if($materia->programa_id ==  $programa->id) selected @endif value="{{ $programa->id }}">{{ $programa->progClave }} | {{ $programa->progNombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Clave del plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" data-plan-id="{{old('plan_id') ?: $materia->plan_id}}" required name="plan_id" style="width: 100%;">
                            @foreach($planes as $plan)
                                <option @if($materia->plan_id ==  $plan->id) selected @endif value="{{ $plan->id }}">{{ $plan->planClave }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matClave', $materia->matClave, array('id' => 'matClave', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('matClave', 'Clave de la materia *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombre', $materia->matNombre, array('id' => 'matNombre', 'class' => 'validate','required','maxlength'=>'60')) !!}
                            {!! Form::label('matNombre', 'Nombre de la materia *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matNombreCorto', $materia->matNombreCorto, array('id' => 'matNombreCorto', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('matNombreCorto', 'Nombre corto de la materia *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('matSemestre', 'Semestre *', array('class' => '')); !!}
                        <select id="matSemestre" class="browser-default validate select2" required name="matSemestre" style="width: 100%;">
                            <option @if($materia->matSemestre == '0') selected @endif value="INTRO">INTRO</option>
                            <option @if($materia->matSemestre == '1') selected @endif value="1">1</option>
                            <option @if($materia->matSemestre == '2') selected @endif value="2">2</option>
                            <option @if($materia->matSemestre == '3') selected @endif value="3">3</option>
                            <option @if($materia->matSemestre == '4') selected @endif value="4">4</option>
                            <option @if($materia->matSemestre == '5') selected @endif value="5">5</option>
                        </select>
                    </div>
                    
                    
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('matCreditos', 'Créditos *', array('class' => '')); !!}
                        <select id="matCreditos" class="browser-default validate select2" required name="matCreditos" style="width: 100%;">
                            <option @if($materia->matCreditos == '0') selected @endif value="INTRO">INTRO</option>
                            <option @if($materia->matCreditos == '1') selected @endif value="1">1</option>
                            <option @if($materia->matCreditos == '2') selected @endif value="2">2</option>
                            <option @if($materia->matCreditos == '3') selected @endif value="3">3</option>
                            <option @if($materia->matCreditos == '4') selected @endif value="4">4</option>
                            <option @if($materia->matCreditos == '5') selected @endif value="5">5</option>
                            <option @if($materia->matCreditos == '6') selected @endif value="6">6</option>
                            <option @if($materia->matCreditos == '7') selected @endif value="7">7</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('matClasificacion', 'Clasificación *', array('class' => '')); !!}
                        <select id="matClasificacion" class="browser-default validate select2" required name="matClasificacion" style="width: 100%;">
                            <option value="B" {{$materia->matClasificacion == "B" ? "selected": ""}}>BÁSICA</option>
                            <option value="O" {{$materia->matClasificacion == "O" ? "selected": ""}}>OPTATIVA</option>
                            <option value="U" {{$materia->matClasificacion == "U" ? "selected": ""}}>OCUPA</option>
                            <option value="X" {{$materia->matClasificacion == "X" ? "selected": ""}}>EXTRAOFICIAL</option>
                            <option value="C" {{$materia->matClasificacion == "C" ? "selected": ""}}>COMPLEMENTARIA</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('matTipoAcreditacion', 'Tipo de acreditación *', array('class' => '')); !!}
                        <select id="matTipoAcreditacion" class="browser-default validate select2" required name="matTipoAcreditacion" style="width: 100%;">
                            <option @if($materia->matTipoAcreditacion == 'N') selected @endif value="N">NUMÉRICO</option>
                            <option @if($materia->matTipoAcreditacion == 'A') selected @endif value="A">ALFABÉTICO</option>
                            <option @if($materia->matTipoAcreditacion == 'M') selected @endif value="M">MIXTO</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matPorcentajeParcial', $materia->matPorcentajeParcial, array('id' => 'matPorcentajeParcial', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('matPorcentajeParcial', 'Parcial % *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('matPorcentajeOrdinario', $materia->matPorcentajeOrdinario, array('id' => 'matPorcentajeOrdinario', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('matPorcentajeOrdinario', 'Ordinario % *', array('class' => '')); !!}
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