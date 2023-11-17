@extends('layouts.dashboard')

@section('template_title')
  Bachiller historico
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_historial_academico')}}" class="breadcrumb">Listado historico de calificaciones</a>
    <label class="breadcrumb">Editar historico</label>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {{ Form::open(array('method'=>'PUT','route' => ['bachiller.bachiller_historial_academico.update', $historico->id])) }}
      
        {!! Form::hidden('alumno_id', $historico->alumno_id, ['id' => 'alumno_id']) !!}
        {!! Form::hidden('plan_id', $historico->plan_id, ['id' => 'plan_id']) !!}
        {{--  {!! Form::hidden('periodo_id', $historico->periodo_id, ['id' => 'periodo_id']) !!}  --}}


        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR HISTORICO #{{$historico->id}}</span>
            
            <p>
              ({{$historico->aluClave}})
              {{$historico->perNombre}}
              {{$historico->perApellido1}}
              {{$historico->perApellido2}}
            </p>
            <p>
              Período: {{$historico->perNumero}}-{{$historico->perAnio}}
            </p>
            <p>
              ({{$historico->planClave}}) {{$historico->progClave}} {{$historico->progNombre}}
            </p>

            <p>
              Materia: ({{$historico->matClave}}) {{$historico->matNombre}}
            </p>



            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended" style="margin-top: 20px;">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>


            {{-- GENERAL BAR--}}
            <div id="general">

              @if ($historico->histTipoAcreditacion == "CP" || $historico->histTipoAcreditacion == "RV" || $historico->histTipoAcreditacion == "RC")
              <div class="row">
                <div class="col s12 m6 l4">
                  {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                  <select id="periodo_id"
                    data-periodo-id="{{old('periodo_id')}}"
                    class="browser-default validate select2"
                    required name="periodo_id" style="width: 100%;">
                    <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    @foreach ($periodos as $item)
                        <option value="{{$item->id}}" {{ $item->id == $historico->periodo_id ? 'selected' : '' }}>{{$item->perNumero.'-'.$item->perAnio}}</option>
                    @endforeach
                    
                  </select>
                </div>
              </div>
              @else
              <div class="row">
                <div class="col s12 m6 l4" style="display: none;">
                  {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                  <select id="periodo_id"
                    data-periodo-id="{{old('periodo_id')}}"
                    class="browser-default validate select2"
                    required name="periodo_id" style="width: 100%;">
                    <option value="{{$historico->periodo_id}}">{{$historico->perNumero.'-'.$historico->perAnio}}</option>
                    
                  </select>
                </div>
              </div>
              @endif
              
               <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('histComplementoNombre', $historico->histComplementoNombre, ['id' => 'histComplementoNombre', 'class' => 'validate']) !!}
                    {!! Form::label('histComplementoNombre', 'Complemento de nombre', ['class' => '']); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                    {!! Form::label('histPeriodoAcreditacion', 'Período acreditación *', ['class' => '']); !!}
                    {{--  <input type="text" readonly name="histPeriodoAcreditacion" id="histPeriodoAcreditacion"
                    @if ($historico->histPeriodoAcreditacion == "PN")
                        value="Período normal"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "CV")
                        value="Curso de Verano"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "AC")
                        value="Examen Extraordinario (Acompañamiento)"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "RE")
                        value="Examen Extraordinario (Recursamiento)"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "CE")
                        value="Curso Especial"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "EG")
                        value="Examen Global"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "RV")
                        value="Revalidación"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "RC")
                        value="Recursamiento"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "CP")
                        value="Certificado Parcial"
                    @endif
                    >  --}}
                    <select name="histPeriodoAcreditacion" id="histPeriodoAcreditacion" disabled class="browser-default validate select2" style="width: 100%;" required>
                      <option value="PN" {{$historico->histPeriodoAcreditacion == "PN" ? "selected": "" }}>Período normal</option>
                      <option value="CV" {{$historico->histPeriodoAcreditacion == "CV" ? "selected": "" }}>Curso de Verano</option>
                      <option value="EX" {{$historico->histPeriodoAcreditacion == "EX" ? "selected": "" }}>Examen Extraordinario</option>
                      <option value="CE" {{$historico->histPeriodoAcreditacion == "CE" ? "selected": "" }}>Curso Especial</option>
                      <option value="EG" {{$historico->histPeriodoAcreditacion == "EG" ? "selected": "" }}>Examen Global</option>
                      <option value="RV" {{$historico->histPeriodoAcreditacion == "RV" ? "selected": "" }}>Revalidación</option>
                      <option value="RC" {{$historico->histPeriodoAcreditacion == "RC" ? "selected": "" }}>Recursamiento</option>
                      <option value="CP" {{$historico->histPeriodoAcreditacion == "CP" ? "selected": "" }}>Certificado Parcial</option>
                    </select>
                    {{-- $historico->histPeriodoAcreditacion --}}

                </div>
      
                <div class="col s12 m6 l4">
                    {!! Form::label('histTipoAcreditacion', 'Tipo acreditación *', ['class' => '']); !!}
                    <select name="histTipoAcreditacion" disabled id="histTipoAcreditacion" class="browser-default validate select2" style="width: 100%;" required>
                      <option value="CI" {{$historico->histTipoAcreditacion == "CI" ? "selected": ""}}>Curso Inicial</option>
                      <option value="CR" {{$historico->histTipoAcreditacion == "CR" ? "selected": ""}}>Curso Repetición</option>
                      <option value="X1" {{$historico->histTipoAcreditacion == "C1" ? "selected": ""}}>Extraordinario 1</option>
                      <option value="X2" {{$historico->histTipoAcreditacion == "C2" ? "selected": ""}}>Extraordinario 2</option>
                      <option value="X3" {{$historico->histTipoAcreditacion == "C3" ? "selected": ""}}>Extraordinario 3</option>
                      <option value="X4" {{$historico->histTipoAcreditacion == "C4" ? "selected": ""}}>Extraordinario 4</option>
                      <option value="X5" {{$historico->histTipoAcreditacion == "C5" ? "selected": ""}}>Extraordinario 5</option>
                      <option value="EE" {{$historico->histTipoAcreditacion == "EE" ? "selected": ""}}>Curso Especial</option>
                      <option value="RV" {{$historico->histTipoAcreditacion == "RV" ? "selected": ""}}>Revalidación</option>
                      <option value="RC" {{$historico->histTipoAcreditacion == "RC" ? "selected": ""}}>Recursamiento</option>
                      <option value="CP" {{$historico->histTipoAcreditacion == "CP" ? "selected": ""}}>Certificado Parcial</option>
                    </select>
                    <input type="text" readonly name="histPeriodoAcreditacion" id="histPeriodoAcreditacion"
                    @if ($historico->histPeriodoAcreditacion == "CI")
                        value="Curso Inicial"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "CR")
                        value="Curso Repetición"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "X1")
                        value="Extraordinario 1"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "X2")
                        value="Extraordinario 2"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "X3")
                        value="Extraordinario 3"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "X4")
                        value="Extraordinario 4"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "X5")
                        value="Extraordinario 5"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "EE")
                        value="Curso Especial"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "RV")
                        value="Revalidación"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "RC")
                        value="Recursamiento"
                    @endif
                    @if ($historico->histPeriodoAcreditacion == "CP")
                        value="Certificado Parcial"
                    @endif
                    >
                </div>

                <div class="col s12 m6 l4">
                  {{--  <div class="input-field">  --}}
                    {!! Form::label('histFechaExamen', 'Fecha de examen', ['class' => '']); !!}
                    {!! Form::date('histFechaExamen', $historico->histFechaExamen, ['id' => 'histFechaExamen', 'class' => 'validate', 'required']) !!}
                  {{--  </div>  --}}
                </div>
                
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('histCalificacion', $historico->histCalificacion, ['id' => 'histCalificacion', 'class' => 'validate']) !!}
                    {!! Form::label('histCalificacion', 'Calificación', ['class' => '']); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::text('histNombreOficial', $historico->histNombreOficial, ['id' => 'histNombreOficial', 'class' => 'validate']) !!}
                    {!! Form::label('histNombreOficial', 'Nombre oficial', ['class' => '']); !!}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar',
                ['onclick'=>'this.disabled=true;this.innerText="Guardando datos...";this.form.submit(); mostrarAlerta();','class' =>
                'btn-large btn-save waves-effect darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>




@endsection

@section('footer_scripts')
<script>
  
  function mostrarAlerta(){

      //$("#submit-button").prop('disabled', true);
      var html = "";
      html += "<div class='preloader-wrapper big active'>"+
          "<div class='spinner-layer spinner-blue-only'>"+
            "<div class='circle-clipper left'>"+
              "<div class='circle'></div>"+
            "</div><div class='gap-patch'>"+
              "<div class='circle'></div>"+
            "</div><div class='circle-clipper right'>"+
              "<div class='circle'></div>"+
            "</div>"+
          "</div>"+
        "</div>";

      html += "<p>" + "</p>"

      swal({
          html:true,
          title: "Guardando...",
          text: html,
          showConfirmButton: false
          //confirmButtonText: "Ok",
      })

     
  }

</script>
@endsection