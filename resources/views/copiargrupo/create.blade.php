@extends('layouts.dashboard')

@section('template_title')
    Copiar grupo
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="" class="breadcrumb">Copiar grupo</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'copiar_grupo', 'method' => 'POST']) !!}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">INSCRIPCION DE ALUMNOS DE UN GRUPO A OTRO</span>
          {{-- NAVIGATION BAR--}}


          {{-- GENERAL BAR--}}
          <div id="filtros">
            <div class="row">
              <div class="col s6 m6 l6">
                <p>DATOS DEL GRUPO DE ORIGEN</p>
              </div>
              <div class="col s6 m6 l6">
                <p>DATOS DEL GRUPO DE DESTINO</p>
              </div>
              <div class="col s6 m6 l6">
                <div class="input-field">
                  {!! Form::text('ubiClave', NULL, array('id' => 'ubiClave', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('ubiClave', 'Ubicación', array('class' => '')); !!}
                </div>
                <div class="input-field">
                  {!! Form::number('perNumero', NULL, array('id' => 'perNumero', 'class' => 'validate','min'=>'0','max'=>'3', "required")) !!}
                  {!! Form::label('perNumero', 'Número de periodo', array('class' => '')); !!}
                </div>
                <div class="input-field">
                  {!! Form::number('perAnio', NULL, array('id' => 'perAnio', 'class' => 'validate','min'=>'0', "required")) !!}
                  {!! Form::label('perAnio', 'Año de periodo', array('class' => '')); !!}
                </div>
                <div class="input-field">
                  {!! Form::text('progClave', NULL, array('id' => 'progClave', 'class' => 'validate')) !!}
                  {!! Form::label('progClave', 'Clave programa', array('class' => '')); !!}
                </div>
                <div class="input-field">
                  {!! Form::number('planClave', NULL, array('id' => 'planClave', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('planClave', 'Clave del plan', array('class' => '')); !!}
                </div>
                <div class="input-field">
                  {!! Form::text('matClave', NULL, array('id' => 'matClave', 'class' => 'validate', "")) !!}
                  {!! Form::label('matClave', 'Clave de la materia', array('class' => '')); !!}
                </div>
                <div class="input-field">
                  {!! Form::text('gpoClave', NULL, array('id' => 'gpoClave', 'class' => 'validate')) !!}
                  {!! Form::label('gpoClave', 'Grupo', array('class' => '')); !!}
                </div>
                <div class="input-field">
                  {!! Form::text('matNombre', NULL, array('id' => 'matNombre', 'class' => '','maxlength'=>'255')) !!}
                  {!! Form::label('matNombre', 'Nombre materia *', array('class' => '')); !!}
                </div>
                <div class="input-field">
                  {!! Form::number('numAlumnos', NULL, array('id' => 'numAlumnos', 'class' => 'validate','min'=>'0')) !!}
                  {!! Form::label('numAlumnos', 'Número de alumnos', array('class' => '')); !!}
                </div>
              </div>
        
              <div class="col s6 m6 l6">
                {!! Form::label('list_grupos', 'Seleccionar grupo origen', array('class' => '')); !!}
                <select id="list_grupos" class="browser-default validate select2" name="list_grupos" style="width: 100%;">
                  <option value="" selected>SELECCIONE UNA OPCIÓN</option>
                </select>

                {!! Form::label('list_grupos_copia', 'Seleccionar grupo destino', array('class' => '')); !!}
                <select id="list_grupos_copia" class="browser-default validate select2" name="list_grupos_copia" style="width: 100%;">
                  <option value="" selected>SELECCIONE UNA OPCIÓN</option>
                </select>
                {!! Form::button('<i class="material-icons left">save</i> GUARDAR', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit', 'style' => 'margin-top:20px;']) !!}

              </div>
            </div>
          </div>
        </div>
        <div class="card-action" >
          {!! Form::button('<i class="material-icons left">search</i> Buscar', ['class' => 'btn-buscar-grupos btn-large waves-effect  darken-3','type' => 'submit']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection


@section('footer_scripts')
<script type="text/javascript">

  $(document).ready(function() {
    $(".btn-buscar-grupos").on("click", function (e) {
      e.preventDefault();

      $.ajax({
        data: {
          ubiClave: $("#ubiClave").val(),
          perNumero: $("#perNumero").val(),
          perAnio: $("#perAnio").val(),
          progClave: $("#progClave").val(),
          planClave: $("#planClave").val(),
          gpoClave: $("#gpoClave").val(),
          matNombre: $("#matNombre").val(),
          numAlumnos: $("#numAlumnos").val(),
          _token: $("meta[name=csrf-token]").attr("content")
        },
        type: "POST",
        dataType: "JSON",
        url: base_url + "/api/list_grupos_copiar",
      })
      .done(function( data, textStatus, jqXHR ) {

        console.log("copiar alumnos a grupos")
        console.log(data)

        data.forEach(element => {
          $("#list_grupos").append(`<option value=${element.id}>${element.gpoSemestre}-${element.gpoClave}-${element.gpoTurno} ${element.materia.matNombre}</option>`);
        });
      })
      .fail(function( jqXHR, textStatus, errorThrown ) {
        console.log(textStatus)
        console.log(jqXHR)
      });
    })



    // OBTENER ALUMNOS PREINSCRITOS POR CGT
    $("#list_grupos").change( event => {


        $("#list_grupos_copia").empty();
        $("#list_grupos_copia").append(`<option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>`);
        $.get(base_url+`/api/list_grupos_copia/${event.target.value}`,function(res,sta){

            console.log("res")
            console.log(res)
            res.forEach(element => {
                $("#list_grupos_copia").append(`<option value=${element.id}>${element.gpoSemestre}-${element.gpoClave}-${element.gpoTurno} ${element.materia.matNombre}</option>`);
            });
        });
    });

  });
  </script>
@endsection