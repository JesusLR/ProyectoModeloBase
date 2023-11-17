@extends('layouts.dashboard')

@section('template_title')
    Primaria Cambiar Matrículas
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Cambiar Matrículas</a>
@endsection

@section('content')

  @php
      use App\clases\personas\MetodosPersonas as Personas;
      $plan = $cgt->plan;
      $programa = $plan->programa;
      $escuela = $programa->escuela;
      $periodo = $cgt->periodo;
      $cursos = $cgt->cursosRegulares;
  @endphp

<div class="row">
  <div class="col s12 ">
    {{-- {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'url' => 'cambiar_matriculas_cgt', 'method' => 'POST', 'target' => '_blank']) !!} --}}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Cambiar Matrículas</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">Filtros de búsqueda</a></li>
              </ul>
            </div>
          </nav>

          {{-- GENERAL BAR--}}
          <div id="filtros">

            <div class="row">
              <div class="col s12 m6 l4">
                <p><b>Escuela:</b> {{$escuela->escClave}} {{$escuela->escNombre}}</p>
                <p><b>Carrera:</b> {{$programa->progClave}} {{$programa->progNombre}}</p>
                <p><b>Plan:</b> {{$plan->planClave}}</p>
              </div>
              <div class="col s12 m6 l4">
                <p><b>Grado:</b> {{$cgt->cgtGradoSemestre}} <b>Grupo:</b> {{$cgt->cgtGrupo}}</p>
                <p><b>Periodo:</b> {{$periodo->perNumero}} / {{$periodo->perAnio}}</p>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l6">
                <label for="lista_alumnos">Lista de alumnos</label>
                <select name="lista_alumnos" id="lista_alumnos" class="browser-default validate select2" style="width:100%;">
                  <option value="">Seleccione un alumno</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s12 m3 l2">
                <input type="text" name="aluMatricula" id="aluMatricula" class="validate" value="">
                <label for="aluMatricula">Matrícula Actual</label>
              </div>
              <div class="col s12 m6 l4">
                <a name="btn_cambiar" id="btn_cambiar" class="waves-effect btn-large tooltipped" 
                data-position="right" data-tooltip="Actualizar/cambiar Matrícula del alumno">
                    <i class=material-icons>sync</i>
                </a>
              </div>
            </div>

            <hr>

            <div class="row" style="max-width: 900px;">
              <div class="col s12 m12 l12">
                <table class="striped">
                  <thead>
                    <tr>
                      <td class="center-align"><b>Clave de pago</b></td>
                      <td class="center-align"><b>Nombre</b></td>
                      <td class="center-align"><b>Matrícula</b></td>
                      {{-- <td class="center-align"><b>Actualizar</b></td> --}}
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($cursos as $curso)
                      @php
                        $alumno = $curso->alumno;
                      @endphp
                      <tr>
                        <td>{{$alumno->aluClave}}</td>
                        <td>{{$alumno->persona->nombreCompleto}}</td>
                        <td>
                          <input type="text" 
                              name="matricula-{{$alumno->id}}" 
                              id="matricula-{{$alumno->id}}" 
                              maxlength="15"
                              class="matricula_input"
                              data-alumno-id="{{$alumno->id}}"
                              data-matricula-actual="{{$alumno->aluMatricula}}"
                              value="{{$alumno->aluMatricula}}">
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                <a name="btn_cambiar_multiples" id="btn_cambiar_multiples" class="waves-effect btn-large tooltipped" 
                data-position="right" data-tooltip="Actualizar/cambiar Matrícula del alumno">
                    <i class=material-icons>sync</i> Actualizar Listado
                </a>
              </div>
            </div>
          
          </div>
        </div>
      </div>
  </div>
</div>



@endsection


@section('footer_scripts')

@include('primaria.scripts.funcionesAuxiliares')

<script type="text/javascript">
    $(document).ready(function() {
      const lista_alumnos =  $('#lista_alumnos');
      const cgt_id = {!! json_encode($cgt->id) !!};
      let cursos = {!! json_encode($cursos) !!};
      let matricula = $('#aluMatricula');

      if(!jQuery.isEmptyObject(cursos)) {
        llenar_select(cursos, lista_alumnos);
      }

      lista_alumnos.on('change', function() {
        this.value ? buscarCurso(cgt_id, this.value) : emptyFields(['aluMatricula']);
      });

      $('#btn_cambiar').on('click', function() {
        lista_alumnos.val() ? cambiarMatricula(cgt_id, lista_alumnos.val(), matricula.val()) : alert_sin_seleccion();
      });

      $('#btn_cambiar_multiples').on('click', function() {
        let listado = recolectarDatosDeListado();
        cambiarMultiplesMatriculas(cgt_id, listado);
      });

    }); // $(document).ready();


    function llenar_select(cursos, select) {
      let ordenados = Object.values(cursos).sort(function(key, value) {
        return key.alumno.persona.nombreCompleto > value.alumno.persona.nombreCompleto ? 1 : -1;
      });
      $.each(ordenados, function(key, curso) {
        let alumno = curso.alumno;
        let persona = alumno.persona;

        select.append(new Option(`${alumno.aluClave} - ${persona.nombreCompleto}`, alumno.id));

      });
    }

    function buscarCurso(cgt_id, alumno_id) {
      $.ajax({
        type: 'GET',
        url: `${base_url}/primaria_cambiar_matriculas_cgt/${cgt_id}/buscar_alumno/${alumno_id}`,
        dataType: 'json',
        data: {cgt_id: cgt_id, alumno_id: alumno_id},
        success: function(curso) {
          llenar_campos(curso);
        },
        error: function(Xhr, textMessage, errorMessage) {
          console.log(errorMessage);
        }
      });
    }

    function llenar_campos(curso) {
      curso && fillElements({'aluMatricula': curso.alumno.aluMatricula});
    }

    function cambiarMatricula(cgt_id, alumno_id, nueva_matricula) {
      $.ajax({
        type: 'POST', 
        url: `${base_url}/primaria_cambiar_matriculas_cgt/${cgt_id}/actualizar/${alumno_id}`,
        dataType: 'json',
        data: {aluMatricula: nueva_matricula, cgt_id: cgt_id, "_token": "{!! csrf_token() !!}" },
        success: function(data) {

          if(data.status == 'success') {
            let element = `matricula-${data.alumno.id}`;
            $('#' + element).val(data.alumno.aluMatricula);
            Materialize.updateTextFields();
          }

          swal({
            title: data.title, 
            text: data.msg,
            type: data.status,
          });
        },
        error: function(Xhr, textMessage, errorMessage) {
          console.log(errorMessage);
        }
      });
    } // cambiarMatricula

    function cambiarMultiplesMatriculas(cgt_id, listado) {
      $.ajax({
        type: 'POST',
        url: `${base_url}/primaria_cambiar_matriculas_cgt/${cgt_id}/actualizar_lista`,
        dataType: 'json',
        data: {'listado': listado, 'cgt_id': cgt_id, "_token": "{!! csrf_token() !!}" },
        success: function(data) {

          swal({
            title: data.title,
            text: data.msg,
            type: data.status,
          });
          location.reload();

        },
        error: function(Xhr, textMessage, errorMessage) {
          console.log(errorMessage);
        }
      });
    } // cambiarMultiplesMatriculas.

    function alert_sin_seleccion() {
      swal({
        title: 'Sin selección',
        text: 'No ha seleccionado ningún alumno para realizar el proceso de cambio.',
        type: 'info'
      });
    }

    function recolectarDatosDeListado() {
      let inputs = $('.matricula_input');
      let listado = {};
      $.each(inputs, function(key, element) {
        let alumno_id = $(element).data('alumno-id');
        listado[alumno_id] = {
          'alumno_id': alumno_id,
          'nueva_matricula': $(element).val(),
        };
      });

      return listado;
    }

</script>

@endsection