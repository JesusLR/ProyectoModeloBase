@extends('layouts.dashboard')

@section('template_title')
    Historico
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('historico')}}" class="breadcrumb">Listado historico de calificaciones</a>
    <label class="breadcrumb">Agregar historico</label>
@endsection

@section('content')


<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'historico.store', 'method' => 'POST', "class" => "form-historico"]) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">AGREGAR HISTORICO</span>

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
                {!! Form::label('alumno_id', 'Alumno *', array('class' => '')); !!}
                <input type="text" placeholder="Buscar por: Clave Nombre(s)" id="nombreAlumno" value="{{old('nombreAlumno')}}" type="text" name="nombreAlumno" style="width: 100%;" />
                
                <button class="btn-large waves-effect darken-3 btn-buscar-alumno">
                  <i class="material-icons left">search</i>
                  Buscar
                </button>
           
              </div>
              <div class="col s12 m6 l4">
                <label for="">Resultado Busqueda:</label>
                <div class="resultado-busqueda">
                </div>
              </div>
            </div>



            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('ubicacion_id', 'Campus *', array('class' => '')); !!}
                <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                  @foreach($ubicaciones as $ubicacion)
                    @php
                      $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;

                      $selected = '';
                      if ($ubicacion->id == $ubicacion_id) {
                          $selected = 'selected';
                      }
                  
                      if ($ubicacion->id == old("ubicacion_id")) {
                          $selected = 'selected';
                      }
                    @endphp
                    <option value="{{$ubicacion->id}}" {{$selected}}>{{$ubicacion->ubiClave."-".$ubicacion->ubiNombre}}</option>

                  @endforeach
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                <select id="departamento_id"
                  data-departamento-idold="{{old('departamento_id')}}"
                  class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                <select id="escuela_id"
                  data-escuela-idold="{{old('escuela_id')}}"
                  class="browser-default validate select2"
                  required name="escuela_id" style="width: 100%;">
                  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                <select id="programa_id"
                  data-programa-idold="{{old('programa_id')}}"
                  class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                <select id="plan_id"
                  data-plan-idold="{{old('plan_id')}}"
                  class="browser-default validate select2"
                  required name="plan_id" style="width: 100%;">
                  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
              <div class="col s12 m6 l4">
                {!! Form::label('materia_id', 'Materia *', array('class' => '')); !!}
                <select id="materia_id" class="browser-default validate select2" required name="materia_id" style="width: 100%;">
                  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m6 l4">
                {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                <select id="periodo_id"
                  data-periodo-idold="{{old('periodo_id')}}"
                  class="browser-default validate select2"
                  required name="periodo_id" style="width: 100%;">
                  <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                </select>
              </div>
            </div>







            <div class="row">
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('histComplementoNombre', null, ['id' => 'histComplementoNombre', 'class' => 'validate']) !!}
                  {!! Form::label('histComplementoNombre', 'Complemento de nombre', ['class' => '']); !!}
                </div>
              </div>
              <div class="col s12 m6 l4">
                  {!! Form::label('histPeriodoAcreditacion', 'Período acreditación *', ['class' => '']); !!}
                  <select name="histPeriodoAcreditacion" id="histPeriodoAcreditacion" class="browser-default validate select2" style="width: 100%;" required>
                    <option value="" selected>SELECCIONE UNA OPCIÓN</option>
                    <option value="PN" {{old("histPeriodoAcreditacion") == "PN" ? "selected": ""}}>Período normal</option>
                    <option value="CV" {{old("histPeriodoAcreditacion") == "CV" ? "selected": ""}}>Curso de Verano</option>
                    <option value="EX" {{old("histPeriodoAcreditacion") == "EX" ? "selected": ""}}>Examen Extraordinario</option>
                    <option value="CE" {{old("histPeriodoAcreditacion") == "CE" ? "selected": ""}}>Curso Especial</option>
                    <option value="EG" {{old("histPeriodoAcreditacion") == "EG" ? "selected": ""}}>Examen Global</option>
                    <option value="RV" {{old("histPeriodoAcreditacion") == "RV" ? "selected": ""}}>Revalidación</option>
                    <option value="RC" {{old("histPeriodoAcreditacion") == "RC" ? "selected": ""}}>Recursamiento</option>
                    <option value="CP" {{old("histPeriodoAcreditacion") == "CP" ? "selected": ""}}>Certificado Parcial</option>
                  </select>
              </div>
    
              <div class="col s12 m6 l4">
                  {!! Form::label('histTipoAcreditacion', 'Tipo acreditación *', ['class' => '']); !!}
                  <select name="histTipoAcreditacion" id="histTipoAcreditacion" class="browser-default validate select2" style="width: 100%;" required>
                    {{-- <option value="CI">Curso Inicial</option>
                    <option value="CR">Curso Repetición</option>
                    <option value="X1">Extraordinario 1</option>
                    <option value="X2">Extraordinario 2</option>
                    <option value="X3">Extraordinario 3</option>
                    <option value="X4">Extraordinario 4</option>
                    <option value="X5">Extraordinario 5</option>
                    <option value="EE">Curso Especial</option>
                    <option value="RV">Revalidación</option>
                    <option value="RC">Recursamiento</option>
                    <option value="CP">Certificado Parcial</option> --}}
                  </select>
              </div>

              <div class="col s12 m6 l4">
                  {!! Form::label('histFechaExamen', 'Fecha de examen *', array('class' => '')); !!}
                  {!! Form::date('histFechaExamen', NULL, array('id' => 'histFechaExamen', 'class' => ' validate','required')) !!}
              </div>
              
              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('histCalificacion', null, ['id' => 'histCalificacion', 'class' => 'validate']) !!}
                  {!! Form::label('histCalificacion', 'Calificación', ['class' => '']); !!}
                </div>
              </div>

              <div class="col s12 m6 l4">
                <div class="input-field">
                  {!! Form::text('histNombreOficial', null, ['id' => 'histNombreOficial', 'class' => 'validate']) !!}
                  {!! Form::label('histNombreOficial', 'Nombre oficial', ['class' => '']); !!}
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
@endsection



@section('footer_scripts')


  {{-- <script type="text/javascript">

    $(document).ready(function() {
        $.get(base_url+`/api/alumnos`,function(res,sta) {
    
            res.forEach(element => {
                $("#alumno_id").append(`<option value=${element.alumno_id}>${element.aluClave}-${element.perNombre} ${element.perApellido1} ${element.perApellido2}</option>`);
            });
        });
    });
  </script> --}}





  <script type="text/javascript">
    $(document).ready(function() {

      var alumnoIdOld = "{{old("alumno_id")}}";


      if (alumnoIdOld) {
        buscarAlumno()
      }
      function buscarAlumno()
      {
        var nombreAlumno = $("#nombreAlumno").val()

        $.get(base_url + `/api/getAlumnosByFilter/${nombreAlumno}`,function(res,sta){

          console.log("res")
          console.log(res)

          if (Object.keys(res).length > 0) {
            $(".form-historico").find(".resultado-busqueda").empty();
            $(".form-historico").find(".resultado-busqueda").append('<input id="alumno_busqueda" name="alumno_busqueda" value="" type="text" disabled>')
            $(".form-historico").find(".resultado-busqueda").append('<input id="alumno_id" name="alumno_id" value="" type="hidden"  />')

            $("#alumno_busqueda").val(res.aluClave + "-" + res.perApellido1 + " " + res.perApellido2 + " " + res.perNombre)
            $("#alumno_id").attr("value", res.alumno_id)
          }
          
        });
      }


      
      $(".btn-buscar-alumno").on("click", function (e) {
        e.preventDefault()
        buscarAlumno()
      })

    });
  </script>






  @include('scripts.departamentos')
  @include('scripts.escuelas')
  @include('scripts.programas')
  @include('scripts.planes')
  <script type="text/javascript">
    $(document).ready(function() {
      // OBTENER MATERIAS POR SEMESTRE SELECCIONADO
      $("#plan_id").change( event => {
        var plan_id = $("#plan_id").val();

        $("#materia_id").empty();
        $("#materia_id").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
        $.get(base_url + `/api/getMateriasByPlan/${plan_id}`,function(res, sta) {
          res.forEach(element => {
            $("#materia_id").append(`<option value=${element.id}>${element.matClave}-${element.matNombre}</option>`);
          });
        });
      });
    });
</script>


<script type="text/javascript">
  $(document).ready(function() {
    // OBTENER MATERIAS POR SEMESTRE SELECCIONADO

    llenarHistPeriodoAcr()
    function llenarHistPeriodoAcr () {
      var histPeriodoAcreditacion = $("#histPeriodoAcreditacion").val();

      var tipoAcreditacion = [
        {
          "clave": "CI",
          "nombre": "Curso Inicial"
        },
        {
          "clave": "CR",
          "nombre": "Curso Repetición"
        },
        {
          "clave": "X1",
          "nombre": "Extraordinario 1"
        },
        {
          "clave": "X2",
          "nombre": "Extraordinario 2"
        },
        {
          "clave": "X3",
          "nombre": "Extraordinario 3"
        },
        {
          "clave": "X4",
          "nombre": "Extraordinario 4"
        },
        {
          "clave": "X5",
          "nombre": "Extraordinario 5"
        },
        {
          "clave": "EE",
          "nombre": "Curso Especial"
        },
        {
          "clave": "RV",
          "nombre": "Revalidación"
        },
        {
          "clave": "RC",
          "nombre": "Recursamiento"
        },
        {
          "clave": "CP",
          "nombre": "Certificado Parcial"
        }
      ]


      if (histPeriodoAcreditacion === "PN") {
        tipoAcreditacion = [
          {
            "clave": "CI",
            "nombre": "Curso Inicial"
          },
          {
            "clave": "CR",
            "nombre": "Curso Repetición"
          },
          
        ]
      }

      if (histPeriodoAcreditacion === "EX") {
        tipoAcreditacion = [
          {
            "clave": "X1",
            "nombre": "Extraordinario 1"
          },
          {
            "clave": "X2",
            "nombre": "Extraordinario 2"
          },
          {
            "clave": "X3",
            "nombre": "Extraordinario 3"
          },
          {
            "clave": "X4",
            "nombre": "Extraordinario 4"
          },
          {
            "clave": "X5",
            "nombre": "Extraordinario 5"
          }
        ]
      }

      if (histPeriodoAcreditacion === "CE") {
        tipoAcreditacion = [
          {
            "clave": "EE",
            "nombre": "Curso Especial"
          }
        ]
      }

      if (histPeriodoAcreditacion === "RV") {
        tipoAcreditacion = [
          {
            "clave": "RV",
            "nombre": "Revalidación"
          }
        ]
      }


      if (histPeriodoAcreditacion === "RC") {
        tipoAcreditacion = [
          {
            "clave": "RC",
            "nombre": "Recursamiento"
          }
        ]
      }

      if (histPeriodoAcreditacion === "CP") {
        tipoAcreditacion = [
          {
            "clave": "CP",
            "nombre": "Certificado Parcial"
          }
        ]
      }

      $("#histTipoAcreditacion").empty();
      $("#histTipoAcreditacion").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
        tipoAcreditacion.forEach((element, index) => {
          $("#histTipoAcreditacion").append(`<option value=${element.clave}>${element.nombre}</option>`);
        });
    }



    $("#histPeriodoAcreditacion").change( event => {
      llenarHistPeriodoAcr()
    });





  });
</script>

@endsection