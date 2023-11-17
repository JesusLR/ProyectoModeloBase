@extends('layouts.dashboard')

@section('template_title')
Bachiller inscrito evidencia
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
<a href="{{route('bachiller.bachiller_grupo_uady.index')}}" class="breadcrumb">Lista de grupos</a>
<label class="breadcrumb">Agregar inscrito evidencia</label>
@endsection

@section('content')

<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_evidencias_inscritos.store', 'method' => 'POST']) !!}
    <div class="card ">
      <div class="card-content ">
        <span class="card-title">INSCRITO EVIDENCIA - <b>{{$bachiller_grupo->empApellido1.' '.$bachiller_grupo->empApellido2.' '.$bachiller_grupo->empNombre}}</b></span>

        {{-- NAVIGATION BAR--}}
        <nav class="nav-extended">
          <div class="nav-content">
            <ul class="tabs tabs-transparent">
              <li class="tab"><a class="active" href="#general">General</a></li>
            </ul>
          </div>
        </nav>
        <br>

        {{-- GENERAL BAR--}}
        <div id="general">
@php
use App\Http\Helpers\Utils;
@endphp

          <div class="row">

            <div class="col s12">
              <p><b>Grupo: </b>{{$bachiller_grupo->gpoGrado.' - '.$bachiller_grupo->gpoClave}}</p>
              <p><b>Periodo:</b> {{$bachiller_grupo->perNumero.'-'.$bachiller_grupo->perAnio}}</p>
              <p><b>Materia:</b> 
                @if($bachiller_grupo->gpoMatComplementaria != "")
                {{$bachiller_grupo->matClave.' - '.$bachiller_grupo->matNombre.' - '.$bachiller_grupo->gpoMatComplementaria}}
                @else
                {{$bachiller_grupo->matClave.' - '.$bachiller_grupo->matNombre}}
                @endif
              </p>
            </div>

            <input type="hidden" id="bachiller_grupo_id" name="bachiller_grupo_id" value="{{$bachiller_grupo->id}}"
                  readonly>

            {{-- si estado_act es igual a CA, preguntar mandar mensaje de advertencia por archivos mandados a segey --}}

            <div class="col s12">
                <span>Estado de grupo: <b>{{Utils::estadoGrupo($bachiller_grupo->estado_act)}}</b></span>
                {{-- SOLO SE AGREGA EL BOTÓN ABRIR GRUPO A LOS PERMISOS TIPO A Y B --}}
                @if ($bachiller_grupo->estado_act == 'C')
                    <a href="{{url('bachiller_grupo_uady/cambiarEstado/'.$bachiller_grupo->id.'/B')}}"
                        data-grupo-clave_actv="{{$bachiller_grupo->clave_actv}}"
                        data-grupo-id="{{$bachiller_grupo->id}}"
                        class="btn-abrir-grupo waves-effect waves-light btn">
                        Abrir grupo
                    </a>
                @endif
            </div>
        </div>
          <br>
         
          <div class="row">
            <div class="col s12 m6 l4">
              {!! Form::label('bachiller_evidencia_id', 'Evidencia *', array('class' => '')); !!}
              <select id="bachiller_evidencia_id" name="bachiller_evidencia_id"
                data-plan-idold="{{old('bachiller_evidencia_id')}}" class="browser-default validate select2" required
                style="width: 100%;">
                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                @forelse ($bachiller_evidencias as $item)
                @if ($item->eviFaltas == "N")
                @php
                $faltas = "NO SE REGISTRAN FALTAS"
                @endphp
                @else
                @php
                $faltas = "SE REGISTRAN FALTAS"
                @endphp
                @endif
                <option value="{{$item->id}}">Número: {{$item->eviNumero}} - Descripción: {{$item->eviDescripcion}} -
                  {{$faltas}}</option>
                @empty
                <option value="">NO HAY EVIDENCIAS CREADAS PARA EL GRUPO MATERIA SELECCINADO</option>
                @endforelse
              </select>
            </div>

            <div class="col s12 m6 l4" id="puntos" style="display: none;">
              <br>
              <label style="color: #000">Puntos maximos de evidencia: </label><label id="puntosMaximos"
                style="color: red; font-size: 25px;"></label>
            </div>
          </div>

          <br>



          <div class="row" id="Tabla">
            <div class="col s12">
              <h5 style="display: none;" id="alumno"></h5>

              <div class="responsive-table display" cellspacing="0" width="100%" id="tablePrint">
              </div>
            </div>
          </div>




        </div>

        <div class="card-action">
          {{-- {!! Form::button('<i class="material-icons left">save</i> Guardar',
          ['style' => 'display: none;','onclick'=>'this.disabled=true;this.innerText="Cargando
          datos...";this.form.submit(); mostrarAlerta();','class' =>
          'btn-large btn-save waves-effect darken-3 submit-button','type' => 'submit']) !!} --}}
          {{--  onclick="this.disabled=true;this.innerText='Cargando datos...';this.form.submit(); mostrarAlerta();"  --}}
          <button type="submit" id="submit-button" style="display: none;" onclick="mostrarAlerta();"
            class="btn-large btn-save waves-effect darken-3"><i
              class="material-icons left">save</i>Guardar</button>

        </div>

      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>


  <style>
    table tbody tr:nth-child(odd) {
      background: #F7F8F9;
      font-size: 14px;
    }

    table tbody tr:nth-child(even) {
      background: #F1F1F1;
      font-size: 14px;
    }

    table th {
      background: #01579B;
      color: #fff;
      font-size: 14px;

    }

    table {
      border-collapse: collapse;
      width: 100%;
      font-size: 14px;
    }
  </style>

  @endsection

  @section('footer_scripts')

  @include('bachiller.evidencias_inscritos.getEvidenciasCapturadas')


  <script>
    function mostrarAlerta(){

        $("#submit-button").hide();

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