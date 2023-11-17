@extends('layouts.dashboard')

@section('template_title')
Secundaria Alumnos Restringidos
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('secundaria_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('secundaria_alumnos_restringidos')}}" class="breadcrumb">Lista de alumnos restringidos</a>
    <a href="{{url('secundaria_alumnos_restringidos/'.$listaNegra->id.'/edit')}}" class="breadcrumb">Editar alumno restringido</a>
@endsection

@section('content')

<div class="row">
  <div class="col s12 ">
    {{ Form::open(array('method'=>'PUT','route' => ['secundaria.secundaria_alumnos_restringidos.update', $listaNegra->id])) }}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">EDITAR ALUMNO RESTRINGIDO #{{$listaNegra->id}}</span>

          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#general">General</a></li>
                <li class="tab"><a href="#personal">Personal</a></li>
              </ul>
            </div>
          </nav>

          {{-- GENERAL BAR--}}
          <div id="general">          
            <div class="row">
              <input type="hidden" name="curso_id" id="curso_id" value={{old('curso_id')}}>
              <div class="col s12 m4">
                  <input type="text" placeholder="Buscar por: Clave alumno" id="aluClave" value="{{old('aluClave')}}"  name="aluClave" style="width: 100%;" />
              </div>
              {{--  <div class="col s12 m4">
                  <input type="text" placeholder="Buscar por: Nombre(s)" id="nombreAlumno" value="{{old('nombreAlumno')}}" name="nombreAlumno" style="width: 100%;" />
              </div>  --}}

              <div class="col s12 m6 l4">
                  <div class="col s12 m6 l6">
                      <input type="text" placeholder="Buscar por: Primer Apellido" id="perApellido1" value="{{old('perApellido1')}}" name="perApellido1" style="width: 100%;" />
                  </div>
                  <div class="col s12 m6 l6">
                      <input type="text" placeholder="Buscar por: Segundo Apellido" id="perApellido2" value="{{old('perApellido2')}}" name="perApellido2" style="width: 100%;" />
                  </div>
              </div>
              <div class="col s12 m6 l4">
                  <div class="col s12 m6 l6">
                      <input type="text" placeholder="Buscar por: Nombre(s)" id="perNombre" value="{{old('perNombre')}}" name="perNombre" style="width: 100%;" />
                  </div>
              </div>                    
          </div>

          <div class="row">
              <div class="col s12 m4">
                  <button class="btn-large waves-effect darken-3 btn-buscar-alumno">
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
                    </div>
                </div>

                <div class="col s12 m4">
                    {!! Form::label('lnNivel', 'Nivel restricción *', array('class' => '')); !!}
                    <div style="position:relative">
                        <select id="lnNivel" class="browser-default validate select2" required name="lnNivel" style="width: 100%;">
                           <option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
                           @forelse ($NivelListaNegra as $lista)
                            <option value="{{$lista->id}}" {{ $listaNegra->lnNivel == $lista->id ? 'selected' : '' }}>{{$lista->nlnClave}} - {{$lista->nlnDescripcion}}</option>                               
                           @empty
                               
                           @endforelse
                        </select>                        
                    </div>
                </div>


                <div class="col s12 m4">
                    {!! Form::label('lnFecha', 'Fecha restricción *', array('class' => '')); !!}
                    <input type="date" value="{{old('lnFecha', $listaNegra->lnFecha)}}" max="{{$fechaActual}}" id="lnFecha" name="lnFecha" required>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m4 l12">
                    {!! Form::label('lnRazon', 'Razón restricción *', array('class' => '')); !!}
                    <input type="text" name="lnRazon" id="lnRazon" value="{{old('lnRazon', $listaNegra->lnRazon)}}" required maxlength="255">
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



   


  }); //document.ready




  function buscarAlumno()
    {
      var perApellido1 = $("#perApellido1").val();
      var perApellido2 = $("#perApellido2").val();
      var perNombre = $("#perNombre").val();
      var aluClave = $("#aluClave").val()

      $.ajax({
          type: "POST",
          url: base_url + `/secundaria_alumno/api/getMultipleAlumnosByFilter`,
          data: {
              perApellido1: perApellido1,
              perApellido2: perApellido2,
              perNombre: perNombre,
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

                  if(element.persona.perApellido2 != null)
                      var perApellido2 = element.persona.perApellido2;
                  else
                      var perApellido2 = "";

                  $("#alumno_id").append(`<option value=${element.id}>${element.aluClave}-${element.persona.perNombre} ${element.persona.perApellido1} ${perApellido2}</option>`);
              });
              $('#alumno_id').trigger('click');
              $('#alumno_id').trigger('change');
          }else{
              swal("Upss", "Alumno no encontrado", "info");
              $("#alumno_id").append(`<option value='' disabled selected>ALUMNO NO ENCONTRADO</option>`);

          }

      });
    } //buscarAlumno.





</script>


<script>

  function mostrarAlerta(){

      //$("#submit-button").prop('disabled', true);
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

      html += "<p>" + "</p>"

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
