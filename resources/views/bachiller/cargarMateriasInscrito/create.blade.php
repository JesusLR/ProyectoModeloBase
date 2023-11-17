@extends('layouts.dashboard')

@section('template_title')
    Bachiller cargar materias
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('bachiller.bachiller_materias_inscrito.index')}}" class="breadcrumb">Cargar materias a alumno</a>
@endsection

@section('content')
@php
use App\Models\User;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['enctype' => 'multipart/form-data', 'onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_materias_inscrito.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">CARGAR MATERIAS A ALUMNO</span>

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

                <br>

                <div class="row">
                    <input type="hidden" name="curso_id" id="curso_id" value={{old('curso_id')}}>
                    <div class="col s12 m4">
                        <input type="text" placeholder="Buscar por: Clave alumno" id="aluClave" value="{{old('aluClave')}}"  name="aluClave" style="width: 100%;" />
                    </div>
                    {{--  <div class="col s12 m4">
                        <input type="text" placeholder="Buscar por: Nombre(s)" id="nombreAlumno" value="{{old('nombreAlumno')}}" name="nombreAlumno" style="width: 100%;" />
                    </div>  --}}
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
                            <select id="ubicacion_id" data-ubicacion-id="{{old('ubicacion_id')}}" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                               
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
                        <select id="periodo_id" data-periodo-id="{{old('periodo_id')}}" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
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
                            <select id="programa_id" data-programa-id="{{old('programa_id')}}" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            </select>
                            @if (isset($candidato))
                                <div style="width: 100%; height: 35px; position: absolute; top: 0;"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" data-plan-id="{{old('plan_id')}}" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('cgt_id', 'CGT *', array('class' => '')); !!}
                        <select id="cgt_id" data-cgt-id="{{old('cgt_id')}}" class="browser-default validate select2" required name="cgt_id" style="width: 100%;">
                        </select>
                    </div>
                </div>


            </div>

          </div>
          <div class="card-action"  id="boton-cargar-materias" style="display: none;">             
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-guardar-cargar-materias btn-large waves-effect  darken-3']) !!}
            </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')



<script type="text/javascript">
    $(document).ready(function() {

        $("#ubicacion_id").empty();
        $("#ubicacion_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#departamento_id").empty();
        $("#departamento_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#escuela_id").empty();
        $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#periodo_id").empty();
        $("#periodo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#programa_id").empty();
        $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#plan_id").empty();
        $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#cgt_id").empty();
        $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

      var alumnoIdOld = "{{old("alumno_id")}}";
      if (alumnoIdOld) {
        buscarAlumno()
      }



      $(".btn-buscar-alumno").on("click", function (e) {
        e.preventDefault()

        $("#ubicacion_id").empty();
        $("#ubicacion_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#departamento_id").empty();
        $("#departamento_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#escuela_id").empty();
        $("#escuela_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#periodo_id").empty();
        $("#periodo_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#programa_id").empty();
        $("#programa_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#plan_id").empty();
        $("#plan_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#cgt_id").empty();
        $("#cgt_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);

        $("#perFechaInicial").val("");
        $("#perFechaFinal").val("");

        var aluClave = $("#aluClave").val()
        //var nombreAlumno = $("#nombreAlumno").val()

        if (aluClave === "") {
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
            url: base_url+'/bachiller_materias_inscrito/ultimo_curso/'+alumno_id,
            dataType: 'json',
            data: {alumno_id: alumno_id},
            success: function(data) {
                data['curso'] && alumno_precargar_datos(data);
            },
            error: function(Xhr, textMessage, errorMessage){
                console.log(errorMessage);
            }
        });
      });

      

    }); //document.ready


    function buscarAlumno()
      {
        //var nombreAlumno = $("#nombreAlumno").val()
        var aluClave = $("#aluClave").val()

        $.ajax({
            type: "POST",
            url: base_url + `/bachiller_materias_inscrito/api/getMultipleAlumnosByFilter`,
            data: {
                aluClave: aluClave,
                _token: $("meta[name=csrf-token]").attr("content")
            },
            dataType: "json"
        })
        .done(function(res) {
            console.log("res")
            console.log(res)
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

        //if(data.curso.curEstado == "R"){
            $("#ubicacion_id option[value='']").remove();
            $("#departamento_id option[value='']").remove();
            $("#escuela_id option[value='']").remove();
            $("#periodo_id option[value='']").remove();
            $("#programa_id option[value='']").remove();
            $("#plan_id option[value='']").remove();
            $("#cgt_id option[value='']").remove();
            
            data.cgt && $('#cgt_id').data('cgt-id', data.cgt.id);
            $('#plan_id').data('plan-id', data.plan.id);
            $('#programa_id').data('programa-id', data.programa.id);
            $('#escuela_id').data('escuela-id', data.escuela.id);
            $('#departamento_id').data('departamento-id', data.departamento.id);
            $('#periodo_id').data('periodo-id', data.periodo.id);
            $("#ubicacion_id").append(`<option value=${data.ubicacion.id}>${data.ubicacion.ubiNombre}</option>`);
            $("#departamento_id").append(`<option value=${data.departamento.id}>${data.departamento.depNombre}</option>`);
            $("#escuela_id").append(`<option value=${data.escuela.id}>${data.escuela.escClave}-${data.escuela.escNombre}</option>`);
            $("#periodo_id").append(`<option value=${data.periodo.id}>${data.periodo.perNumero}-${data.periodo.perAnioPago}</option>`);
            $("#perFechaInicial").val(data.periodo.perFechaInicial);
            $("#perFechaFinal").val(data.periodo.perFechaFinal);
            $("#programa_id").append(`<option value=${data.programa.id}>${data.programa.progClave}-${data.programa.progNombre}</option>`);
            $("#plan_id").append(`<option value=${data.plan.id}>${data.plan.planClave}</option>`);
            $("#cgt_id").append(`<option value=${data.cgt.id}>${data.cgt.cgtGradoSemestre}-${data.cgt.cgtGrupo}-${data.cgt.cgtTurno}</option>`);       
            $("#curso_id").val(data.curso.id);
            
            Materialize.updateTextFields();
            
            //Mostrar el boton de guardar
            $("#boton-cargar-materias").show();
        /*}else{
            $("#boton-cargar-materias").hide();

            swal("Sin información", "Verificar si el alumno se encuentra inscrito al período actual y el estado del curso sea REGULAR", "info");
        }*/

       

    }//alumno_precargar_datos.

  </script>


  @include('bachiller.cargarMateriasInscrito.ajaxCargarMaterias')

@endsection
