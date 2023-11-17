@extends('layouts.dashboard')

@section('template_title')
    Curso
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{route('curso_idiomas.index')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('curso_idiomas.index')}}" class="breadcrumb">Lista de Preinscripción</a>
    <a href="{{route('curso_idiomas.create')}}" class="breadcrumb">Agregar Preinscripción</a>
@endsection

@section('content')
@php
use App\Models\User;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['enctype' => 'multipart/form-data', 'onKeypress' => 'return disableEnterKey(event)','route' => 'curso_idiomas.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">PREINSCRIBIR</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                    <li class="tab"><a class="active" href="#general">General</a></li>
                    <li class="tab"><a href="#cuotas">Cuotas</a></li>
                </ul>
              </div>
            </nav>
            @if (User::permiso("curso") != "P")
            {{-- GENERAL BAR--}}
            <div id="general">

                {{-- <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('curTipoIngreso', 'Tipo de ingreso *', ['class' => '']); !!}
                        <div style="position:relative;">
                            <select name="curTipoIngreso" id="curTipoIngreso" required class="browser-default validate select2" style="width: 100%;">
                                @foreach($tiposIngreso as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                </div>--}}

                <div class="row">
                    <input type="hidden" name="curso_id" id="curso_id" value={{old('curso_id')}}>
                    <div class="col s12 m4">
                        <input type="text" placeholder="Buscar por: Clave alumno" id="aluClave" value="{{old('aluClave')}}" type="text" name="aluClave" style="width: 100%;" />
                    </div>
                    <div class="col s12 m4">
                        <input type="text" placeholder="Buscar por: Nombre(s)" id="nombreAlumno" value="{{old('nombreAlumno')}}" type="text" name="nombreAlumno" style="width: 100%;" />
                    </div>
                    <div class="col s12 m4">
                            <button class="btn-large waves-effect darken-3 btn-buscar-alumno" {{isset($candidato) ? "disabled": ""}}>
                                <i class="material-icons left">search</i>
                                Buscar
                            </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m4">
                        {!! Form::label('alumno_id', 'Alumno *', array('class' => '')); !!}
                        <div style="position:relative">
                            <select id="alumno_id" class="browser-default validate select2" required name="alumno_id" style="width: 100%;">
                                @if($alumno)
                                    @php
                                        $persona = $alumno->persona;
                                        $nombreCompleto = $persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2;
                                    @endphp
                                    <option value="{{$alumno->id}}" selected>{{$alumno->aluClave}}-{{$nombreCompleto}}</option>
                                @else
                                    <option value="" selected disabled>RESULTADOS DE BUSQUEDA</option>
                                @endif
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <div style="position:relative">
                            <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($ubicaciones as $ubicacion)
                                    @php
                                    $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                    $selected = '';
                                    if (!isset($campus)) {
                                        if($ubicacion->id == $ubicacion_id){
                                            $selected = 'selected';
                                        }
                                    }
                                    $selected = (isset($campus) && $campus == $ubicacion->id) ? "selected": "";

                                    @endphp
                                    <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiNombre}}</option>
                                @endforeach
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <div style="position:relative">
                            <select id="departamento_id" data-departamento-id="{{(isset($departamento)) ? $departamento:""}}" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <div style="position: relative;">
                            <select id="escuela_id" data-escuela-id="{{(isset($escuela)) ? $escuela:""}}" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                        <select id="periodo_id" data-periodo-id="" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="">
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        {!! Form::date('perFechaInicial', NULL, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="">
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        {!! Form::date('perFechaFinal', NULL, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <div style="position:relative">
                            <select id="programa_id" data-programa-id="{{(isset($programa)) ? $programa:""}}" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" data-plan-id="" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('grupo_id', 'Grupos *', array('class' => '')); !!}
                        <select id="grupo_id" data-grupo-id="" class="browser-default validate select2" required name="grupo_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>
                </div>

            </div>
            @endif
            {{-- CUOTAS BAR--}}
            <div id="cuotas">
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('curImporteInscripcion', NULL, array('id' => 'curImporteInscripcion', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==8) return false;"')) !!}
                        {!! Form::label('curImporteInscripcion', 'Importe inscripción', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('curImporteMensualidad', NULL, array('id' => 'curImporteMensualidad', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==8) return false;"')) !!}
                        {!! Form::label('curImporteMensualidad', 'Importe mensual', ['class' => '']); !!}
                        </div>
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


  {{-- Script de funciones auxiliares  --}}
  {{--
  {!! HTML::script(asset('js/funcionesAuxiliares.js'), array('type' => 'text/javascript')) !!}
  --}}

@endsection

@section('footer_scripts')


@include('idiomas.curso_preinscrito.funcionesAuxiliares')

<script type="text/javascript">
    $(document).ready(function() {

      var alumnoIdOld = "{{old("alumno_id")}}";
      if (alumnoIdOld) {
        buscarAlumno()
      }



      $(".btn-buscar-alumno").on("click", function (e) {
        e.preventDefault()

        var aluClave = $("#aluClave").val()
        var nombreAlumno = $("#nombreAlumno").val()
        if (aluClave === "" && nombreAlumno === "") {
            swal({
                title: "Busqueda de alumnos",
                text: "Debes de tener al menos un dato de alumnos capturados",
                type: "warning",
                showCancelButton: false,
                confirmButtonColor: '#0277bd',
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                swal.close()
            });

        } else {
            buscarAlumno()
        }

      });

      $('#alumno_id').on('change', function() {
        var alumno_id = $('#alumno_id').val();
        $.ajax({
            type: 'GET',
            url: base_url+'/api/idiomasUltimo_curso/'+alumno_id,
            dataType: 'json',
            data: {alumno_id: alumno_id},
            success: function(data) {
                data && alumno_precargar_datos(data);
            },
            error: function(Xhr, textMessage, errorMessage){
                console.log(errorMessage);
            }
        });
      });

      var ubicacion_id = $('#ubicacion_id').val();
      var departamento_id = $('#departamento_id').val();
      var escuela_id = $('#escuela_id').val();
      var programa_id = $('#programa_id').val();
      var periodo_id = $('#periodo_id').val();
      var plan_id = $('#plan_id').val();


      ubicacion_id && getDepartamentos(ubicacion_id, 'departamento_id');
      $('#ubicacion_id').on('change', function() {
        ubicacion_id = $(this).val();
        ubicacion_id && getDepartamentos(ubicacion_id, 'departamento_id');
      });

      if(departamento_id) {
        obtenerEscuelas(departamento_id, 'escuela_id');
        getPeriodos(departamento_id);
      }
      $('#departamento_id').on('change', function() {
        departamento_id = $(this).val();
        if(departamento_id) {
            obtenerEscuelas(departamento_id, 'escuela_id');
            getPeriodos(departamento_id);
        }
      });

      escuela_id && getProgramas(escuela_id, 'programa_id');
      $('#escuela_id').on('change', function() {
        escuela_id = $(this).val();
        escuela_id && getProgramas(escuela_id, 'programa_id');
      });

      programa_id && getPlanes(programa_id, 'plan_id');
      $('#programa_id').on('change', function() {
        programa_id = $(this).val();
        programa_id && getPlanes(programa_id, 'plan_id');
      });

      periodo_id && periodo_fechasInicioFin(periodo_id);
      $('#periodo_id').on('change', function() {
        periodo_id = $(this).val();
        periodo_id && periodo_fechasInicioFin(periodo_id);
        (periodo_id && plan_id) && getGrupos_plan_periodo_preinscripcion_create(plan_id, periodo_id, 'grupo_id');
      });

      (periodo_id && plan_id) && getGrupos_plan_periodo_preinscripcion_create(plan_id, periodo_id, 'grupo_id');
      $('#plan_id').on('change', function() {
        plan_id = $(this).val();
        (periodo_id && plan_id) && getGrupos_plan_periodo_preinscripcion_create(plan_id, periodo_id, 'grupo_id');
      });




    }); //document.ready




    function buscarAlumno()
      {
        var nombreAlumno = $("#nombreAlumno").val()
        var aluClave = $("#aluClave").val()

        $.ajax({
            type: "POST",
            url: base_url + `/api/idiomasGetMultipleAlumnosByFilter`,
            data: {
                nombreAlumno: nombreAlumno,
                aluClave: aluClave,
                _token: $("meta[name=csrf-token]").attr("content")
            },
            dataType: "json"
        })
        .done(function(res) {
            $("#alumno_id").empty()

            if (res.length > 0) {
                res.forEach(element => {
                    $("#alumno_id").append(`<option value=${element.id}>${element.aluClave}-${element.persona.perNombre} ${element.persona.perApellido1} ${element.persona.perApellido2}</option>`);
                });
                $('#alumno_id').trigger('click');
                $('#alumno_id').trigger('change');
            }

        });
      } //buscarAlumno.


      function alumno_precargar_datos(data) {
        // data.grupo_siguiente && $('#grupo_id').val(data.grupo_siguiente).trigger('change');
        data.grupo_siguiente && $('#grupo_id').data('grupo-id', data.grupo_siguiente);
        $('#plan_id').data('plan-id', data.plan_id);
        $('#programa_id').data('programa-id', data.programa_id);
        $('#escuela_id').data('escuela-id', data.escuela_id);
        $('#departamento_id').data('departamento-id', data.departamento_id);
        $('#periodo_id').data('periodo-id', data.periodoSiguiente);
        $('#ubicacion_id').val(data.ubicacion_id).trigger('change');
        $('#curTipoIngreso').val('RI').select2();

        $('#curso_id').val(data.idiomas_curso_id);
        // $('#curAnioCuotas').val(data.curso.curAnioCuotas);
        $('#curImporteInscripcion').val(data.curso.curImporteInscripcion);
        $('#curImporteMensualidad').val(data.curso.curImporteMensualidad);
        // $('#curImporteVencimiento').val(data.curso.curImporteVencimiento);
        // $('#curImporteDescuento').val(data.curso.curImporteDescuento);
        // $('#curDiasProntoPago').val(data.curso.curDiasProntoPago);
        // $('#curPorcentajeBeca').val(data.curso.curPorcentajeBeca);
        // $('#curObservacionesBeca').val(data.curso.curObservacionesBeca);
        // $('#curTipoBeca').val(data.curso.curTipoBeca).select2();
        Materialize.updateTextFields();
      }//alumno_precargar_datos.




  </script>

@include('scripts.materias')

@endsection
