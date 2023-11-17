@extends('layouts.dashboard')

@section('template_title')
    Actividad inscrito
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('universidad.universidad_actividades_inscritos.index')}}" class="breadcrumb">Lista de actividades inscritos</a>
    <a href="{{url('universidad_actividades_inscritos/'.$actividad_inscrito->id.'/edit')}}" class="breadcrumb">Editar actividad inscrito</a>
@endsection

@section('content')
@php
use App\Models\User;
@endphp

<div class="row">
    <div class="col s12 ">
      {{ Form::open(array('method'=>'PUT','route' => ['universidad.universidad_actividades_inscritos.update', $actividad_inscrito->id])) }}
      <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR ACTIVIDAD INSCRITO #{{$actividad_inscrito->id}}</span>

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
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                            <option value="{{$actividad_inscrito->ubicacion_id}}">{{$actividad_inscrito->ubiClave ."-". $actividad_inscrito->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id"
                            data-departamento-idold="{{old('departamento_id')}}"
                            class="browser-default validate select2"
                            required name="departamento_id" style="width: 100%;">
                            <option value="{{$actividad_inscrito->departamento_id}}">{{$actividad_inscrito->depClave ."-". $actividad_inscrito->depNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id"
                            data-escuela-idold="{{old('escuela_id')}}"
                            class="browser-default validate select2"
                            required name="escuela_id" style="width: 100%;">
                            <option value="{{$actividad_inscrito->escuela_id}}">{{$actividad_inscrito->escClave ."-". $actividad_inscrito->escNombre}}</option>
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
                            <option value="{{$actividad_inscrito->periodo_id}}">{{$actividad_inscrito->perNumero ."-". $actividad_inscrito->perAnioPago}}</option>                           
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaInicial', $actividad_inscrito->perFechaInicial, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('perFechaFinal', $actividad_inscrito->perFechaFinal, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                        {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id"
                            data-programa-idold="{{old('programa_id')}}"
                            class="browser-default validate select2"
                            required name="programa_id" style="width: 100%;">
                            <option value="{{$actividad_inscrito->programa_id}}">{{$actividad_inscrito->progClave.' '.$actividad_inscrito->progNombre}}</option>
                        </select>
                    </div>      
                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('actividad_id', 'Actividad *', array('class' => '')); !!}
                        <input type="hidden" name="actividad_id_id" id="actividad_id_id" value="{{$actividad_inscrito->actividad_id}}">
                        <select id="actividad_id"
                            data-programa-idold="{{old('actividad_id')}}"
                            class="browser-default validate select2"
                            required name="actividad_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                        </select>
                    </div>     
                    
                </div>

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
                    <div class="col s12 m6 l4">
                        {!! Form::label('alumno_id', 'Alumno *', array('class' => '')); !!}
                        <div style="position:relative">
                            <select id="alumno_id" class="browser-default validate select2" required name="alumno_id" style="width: 100%;">
                                <option value="{{$actividad_inscrito->alumno_id}}">{{$actividad_inscrito->aluClave}} - {{$actividad_inscrito->perApellido1.' '.$actividad_inscrito->perApellido2.' '.$actividad_inscrito->perNombre}}</option>
                            </select>                            
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('aeiTipoBeca', 'Beca', array('class' => '')); !!}
                        <select id="aeiTipoBeca"
                            data-programa-idold="{{old('aeiTipoBeca')}}"
                            class="browser-default validate select2"
                            name="aeiTipoBeca" style="width: 100%;">
                            <option value="">SELECCIONE UNA OPCIÓN</option>
                            @foreach ($becas as $beca)
                                <option value="{{$beca->bcaClave}}" {{ $beca->bcaClave == $actividad_inscrito->aeiTipoBeca ? 'selected' : '' }}>{{$beca->bcaNombre}}</option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <input type="number" name="aeiPorcentajeBeca" id="aeiPorcentajeBeca" value="{{$actividad_inscrito->aeiPorcentajeBeca}}" min="0" max="100">
                        {!! Form::label('aeiPorcentajeBeca', 'Porcentaje beca', ['class' => '']); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            <input type="text" maxlength="255" name="aeiObservacionesBeca" id="aeiObservacionesBeca" value="{{$actividad_inscrito->aeiObservacionesBeca}}">
                            {!! Form::label('aeiObservacionesBeca', 'Observación beca', ['class' => '']); !!}
                        </div>
                    </div>
                </div>



            </div>

          </div>
          <div class="card-action"  id="boton-guardar">             
            <button type="submit" class="btn-guardar-cargar-materias btn-large waves-effect  darken-3"><i class="material-icons left">save</i> Guardar</button>
            </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

@include('actividades_inscritos.getActividades')

<script type="text/javascript">
    $(document).ready(function() {
      


      var alumnoIdOld = "{{old("alumno_id")}}";
      if (alumnoIdOld) {
        buscarAlumno()
      }



      $(".btn-buscar-alumno").on("click", function (e) {
        e.preventDefault()


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
            url: base_url+'/api/alumno/ultimo_curso/'+alumno_id,
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
            url: base_url + `/api/getMultipleAlumnosByFilter`,
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
                    $("#alumno_id").append(`<option value=${element.id}>${element.aluClave}-${element.persona.perNombre} ${element.persona.perApellido1} ${element.persona.perApellido2?element.persona.perApellido2:''}</option>`);
                });
                $('#alumno_id').trigger('click');
                $('#alumno_id').trigger('change');
                $("#boton-guardar").show();
            }

        });
      } //buscarAlumno.


        function alumno_precargar_datos(data) {  

            //if(data.curso.curEstado == "R"){
        
                $("#curso_id").val(data.curso.id);
                
                Materialize.updateTextFields();
                
                //Mostrar el boton de guardar
                
            /*}else{
                $("#boton-cargar-materias").hide();

                swal("Sin información", "Verificar si el alumno se encuentra inscrito al período actual y el estado del curso sea REGULAR", "info");
            }*/

        

        }//alumno_precargar_datos.

  </script>



@endsection
