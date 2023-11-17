@extends('layouts.dashboard')

@section('template_title')
    Revalidaciones
@endsection

@section('head')
  {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!} 
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('revalidaciones')}}" class="breadcrumb">Lista de alumnos</a>
    <label class="breadcrumb">Revalidación</label>
@endsection

@section('content')

@php
  $alumno = $resumen->alumno;
  $departamento = $materia->plan->programa->escuela->departamento;
@endphp

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'POST','route' => ['revalidaciones.revalidar', $resumen->id, $materia->id])) }}
        @csrf
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">REVALIDACIÓN</span>

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
                <div class="col s12 m6 l6">
                  <p><b>Alumno: </b> {{$alumno->aluClave}} {{$alumno->persona->nombreCompleto()}}</p>
                  <p><b>Materia: </b> {{$materia->matClave}} {{$materia->matNombre}}</p>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <label for="periodo_id">Periodo</label>
                  <select class="browser-default validate select2" data-periodo-id="{{old('periodo_id')}}" name="periodo_id" id="periodo_id" style="width:100%;" required>
                    <option value="">SELECCIONE UNA OPCIÓN</option>
                  </select>
                </div>
                <div class="col s12 m6 l4">
                  <div class="col s12 m6 l6">
                    <label for="perFechaInicial">Fecha inicial</label>
                    <input type="date" name="perFechaInicial" id="perFechaInicial" class="validate" readonly>
                  </div>
                  <div class="col s12 m6 l6">
                    <label for="perFechaFinal">Fecha final</label>
                    <input type="date" name="perFechaFinal" id="perFechaFinal" class="validate" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                @if($materia->matClasificacion == 'O')
                  <div class="col s12 m6 l4">
                    <label for="optativa_id">Optativa específica</label>
                    <select class="browser-default validate select2" data-optativa-id="{{old('optativa_id')}}" name="optativa_id" id="optativa_id" style="width:100%;" required>
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      @foreach($materia->optativas as $optativa)
                        <option value="{{$optativa->id}}">{{$optativa->optClaveEspecifica}}-{{$optativa->optNombre}}</option>
                      @endforeach
                    </select>
                  </div>
                @endif
                <div class="col s12 m6 l4">
                  @if($materia->esAlfabetica())
                    <label for="histCalificacion">Calificación</label>
                    <select class="browser-default validate select2" name="histCalificacion" id="histCalificacion" style="width:100%;" required>
                      <option value="0">Aprobado</option>
                    </select>
                  @else
                    <div class="input-field">
                      <input type="number" name="histCalificacion" id="histCalificacion" class="validate" value="{{old('histCalificacion')}}" title="Calificacion mínima aprobatoria es {{$departamento->depCalMinAprob}}" required>
                      <label for="histCalificacion">Calificación</label>
                    </div>
                  @endif
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    <label for="histFechaExamen">Fecha de revalidación</label>
                    <input type="date" name="histFechaExamen" id="histFechaExamen" class="validate" value="{{old('histFechaExamen') ?: $hoy}}" required>
                  </div>
                </div>
              </div>
                
          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Revalidar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

  <script type="text/javascript" src="{{asset('js/funcionesAuxiliares.js')}}"></script>
@endsection

@section('footer_scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      let departamento = {!!json_encode($departamento)!!};
      let materia = {!!json_encode($materia)!!};
      let periodo = $('#periodo_id');
      let calificacion = $('#histCalificacion');

      departamento.id && getPeriodos(departamento.id);
      apply_data_to_select('periodo_id', 'periodo-id');

      periodo.on('change', function() {
        this.value ? periodo_fechasInicioFin(this.value) : emptyElements(['perFechaInicial', 'perFechaFinal']);
      });

      calificacion.on('change', function() {
        console.log(departamento.depCalMinAprob, this.value);
        if(materia.matTipoAcreditacion != 'A' && parseInt(departamento.depCalMinAprob) > parseInt(this.value)) {
          alertCalificacionReprobatoria(departamento);
        }
      });

    });

    function alertCalificacionReprobatoria(departamento) {
      swal({
        'type': 'warning',
        'title': 'Calificación mínima.',
        'text': `Considere que la calificación mínima aprobatoria para esta materia es ${departamento.depCalMinAprob}, ha especificado una calificacion menor.`,
      });
    }
  </script>
@endsection