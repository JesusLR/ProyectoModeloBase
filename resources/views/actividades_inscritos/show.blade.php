@extends('layouts.dashboard')

@section('template_title')
    Actividad inscrito
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('universidad.universidad_actividades_inscritos.index')}}" class="breadcrumb">Lista de actividades inscritos</a>
    <a href="{{url('universidad_actividades_inscritos/'.$actividad_inscrito->id)}}" class="breadcrumb">Ver actividad inscrito</a>
@endsection

@section('content')
@php
use App\Models\User;
@endphp

<div class="row">
    <div class="col s12 ">
      <div class="card ">
          <div class="card-content ">
            <span class="card-title">ACTIVIDAD INSCRITO #{{$actividad_inscrito->id}}</span>

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
                        {!! Form::label('ubicacion_id', 'Ubicación', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad_inscrito->ubiClave ."-". $actividad_inscrito->ubiNombre}}">
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad_inscrito->depClave ."-". $actividad_inscrito->depNombre}}">                        
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad_inscrito->escClave ."-". $actividad_inscrito->escNombre}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::label('período_id', 'Periodo', array('class' => '')); !!}
                            <input type="text" readonly value="{{$actividad_inscrito->perNumero ."-". $actividad_inscrito->perAnioPago}}">
                        </div>
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
                        {!! Form::label('programa_id', 'Programa', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad_inscrito->progClave.'-'.$actividad_inscrito->progNombre}}">
                    </div>      
                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('actividad_id', 'Actividad', array('class' => '')); !!}
                        @if ($actividad_inscrito->perApellido1 != "")
                            <input type="text" readonly value="{{$actividad_inscrito->actGrupo.' - '.$actividad_inscrito->actDescripcion.' Instructor: '.$actividad_inscrito->empApellido1.' '.$actividad_inscrito->empApellido2. ' '.$actividad_inscrito->empNombre}}">
                        @else
                        <input type="text" readonly value="{{$actividad_inscrito->actGrupo.' - '.$actividad_inscrito->actDescripcion}}">
                        @endif
                        

                      
                    </div>     
                    
                </div>

               

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('alumno_id', 'Alumno', array('class' => '')); !!}
                        <input type="text" readonly value="{{$actividad_inscrito->aluClave}} - {{$actividad_inscrito->perApellido1.' '.$actividad_inscrito->perApellido2.' '.$actividad_inscrito->perNombre}}" name="" id="">
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('aeiTipoBeca', 'Beca', array('class' => '')); !!}
                        @if ($becas != "")
                        <input type="text" readonly value="{{$becas->bcaNombre}}">
                        @else
                        <input type="text" readonly value="">
                        @endif
                    </div> 

                    <div class="col s12 m6 l4">
                        {!! Form::label('aeiPorcentajeBeca', 'Porcentaje beca', ['class' => '']); !!}
                        <input type="number" readonly name="aeiPorcentajeBeca" id="aeiPorcentajeBeca" value="{{$actividad_inscrito->aeiPorcentajeBeca}}" min="0" max="100">                        
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l12">
                        <div class="input-field">
                            {!! Form::label('aeiObservacionesBeca', 'Observación beca', ['class' => '']); !!}
                            <input type="text" readonly maxlength="255" name="aeiObservacionesBeca" id="aeiObservacionesBeca" value="{{$actividad_inscrito->aeiObservacionesBeca}}">                            
                        </div>
                    </div>
                </div>



            </div>

          </div>
         
        </div>
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
            url: base_url+'/universidad_materias_inscrito/ultimo_curso/'+alumno_id,
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
            url: base_url + `/universidad_materias_inscrito/api/getMultipleAlumnosByFilter`,
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
