@extends('layouts.dashboard')

@section('template_title')
    Candidato
@endsection


@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('candidatos_primer_ingreso')}}" class="breadcrumb">Lista de candidatos</a>
    <label class="breadcrumb">Ver candidato</label>
@endsection

@section('content')


<div class="row">
  <div class="col s12 ">
    <div class="card" style="padding-bottom: 20px;">
      <div class="card-content">
        <span class="card-title">
          Candidato
          {{$candidato->perNombre}}
          {{$candidato->perApellido1}}
          {{$candidato->perApellido2}}
        </span>
        @if( isset($mensaje) )
        <div class="col s12">
          <div class="card-panel light-blue darken-1 white-text">
            <i class="material-icons left">info_outline</i>
            {{ $mensaje }}
          </div>
        </div>
        @endif
        <div class="col s12 m8 l8">
          @if ($candidato->perFoto && !strpos($candidato->perFoto, '.pdf'))
            <label>Imagen</label> 
            <div style="width:100%; margin: 0 auto; height: 600px;">
              <div style="width:100%; height:100%;
                background-repeat: no-repeat;
                display:block; background-size:contain;
                background-position:left;
                background-image: url('/exani_images/{{$candidato->perFoto}}')">
              </div>
            </div>
          @endif
          <ul>
            <li>
              <label>CURP:</label> {{$candidato->perCurp}}
              <hr>
            </li>
            <li>
              <label for="">Fecha de nacimiento:</label>
              {{Carbon\Carbon::parse($candidato->perFechaNac)->format("d-m-Y")}}
              <hr>
            </li>
            <li>
              <label for="">Lugar de nacimiento:</label>
              {{$municipio ? $municipio->munNombre: ""}}
              <hr>
            </li>
            <li>
              <label>Sexo:</label>
              {{$candidato->perSexo == "M" ? "Masculino":""}}
              {{$candidato->perSexo == "F" ? "Femenino":""}}
              <hr>
            </li>
  
            <li>
              <label>Correo:</label> {{$candidato->perCorreo1}}
              <hr>
            </li>
            <li>
              <label>Teléfono:</label> {{$candidato->perTelefono1}}
              <hr>
            </li>
            <li>
              <label>Calificación exani:</label> {{$candidato->curExani}}
              <hr>
            </li>
  
            <li>
              <label>Preparatoria procedencia:</label> {{$preparatoriaProcedencia->prepNombre}}
              <hr>
            </li>
            <li>
              <label>Campus:</label> {{$candidato->ubiClave}}-{{$candidato->ubiNombre}}
              <hr>
            </li>
  
            <li>
              <label>Programa de interes:</label> {{$candidato->progClave}}-{{$candidato->progNombre}}
              <hr>
            </li>
          </ul>
        </div>

        <div class="col s6 m6 l6">
          @if($candidato->perFoto && strpos($candidato->perFoto, '.pdf'))
            <label>Imagen</label>
            <embed src="/exani_images/{{$candidato->perFoto}}"
              type="application/pdf"
              width="100%"
              height="600px" /> 
          @endif
        </div>
        @php use App\Models\User; @endphp

        
        @if (User::permiso("CandidatosPrimerIngreso") != "D" && User::permiso("CandidatosPrimerIngreso") != "P")
          @if ($candidato->candidatoPreinscrito == "NO")
            <div class="col s12 m12 l12">
              <a id="btn-guardar" href="{{url('candidatos_primer_ingreso/preregistro/'.$candidato->id)}}" class="btn-guardar btn-large waves-effect {{ $disabled }} darken-3">
                <i class=" material-icons left validar-campos">save</i> Registrar como alumno
              </a>
            </div>
          @endif
        @endif
        @if ($candidato->candidatoPreinscrito == "SI")
          <div class="col s12 m12 l12">
            <a href="{{url('candidatos_primer_ingreso')}}">
              {!! Form::button('CERRAR', [
                'class' => 'btn-guardar btn-large waves-effect  darken-3','id'=>'btn-guardar']) !!}
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection
