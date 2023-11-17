@extends('layouts.dashboard')

@section('template_title')
Portal Configuración
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('portal-configuracion')}}" class="breadcrumb">Lista de Portal Configuración</a>
    <a href="{{url('portal-configuracion/'.$portalConfiguracion->id.'/edit')}}" class="breadcrumb">Editar Portal Configuración</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {{ Form::open(array('method'=>'PUT','route' => ['portal-configuracion.update', $portalConfiguracion->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR PORTAL CONFIGURACIÓN #{{$portalConfiguracion->id}}</span>

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
                <div class="input-field col s6">
                  {!! Form::text('pcClave', $portalConfiguracion->pcClave, array('id' => 'pcClave', 'class' => 'validate','required')) !!}
                  {!! Form::label('pcClave', 'Clave *', array('class' => '')); !!}
                </div>
                <div class="col s6">
                  {!! Form::label('pcPortal', 'Portal', array('class' => '')); !!}
                  <select id="pcPortal" class="browser-default validate select2" required name="pcPortal" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      <option value="A"  @if($portalConfiguracion->pcPortal == 'A') {{ 'selected' }} @endif>Alumno</option>
                      <option value="D"  @if($portalConfiguracion->pcPortal == 'D') {{ 'selected' }} @endif>Docente</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  {!! Form::text('pcDescripcion', $portalConfiguracion->pcDescripcion, array('id' => 'pcDescripcion', 'class' => 'validate')) !!}
                  {!! Form::label('pcDescripcion', 'Descripción *', array('class' => '')); !!}
                </div>
                <div class="col s6">
                  {!! Form::label('pcEstado', 'Estado', array('class' => '')); !!}
                  <select id="pcEstado" class="browser-default validate select2" required name="pcEstado" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      <option value="A"  @if($portalConfiguracion->pcEstado == 'A') {{ 'selected' }} @endif>Activo</option>
                      <option value="I"  @if($portalConfiguracion->pcEstado == 'I') {{ 'selected' }} @endif>Inactivo</option>
                  </select>
                </div>
              </div>
            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect light-blue darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection

@section('footer_scripts')

  @include('scripts.departamentos')
  @include('scripts.escuelas')
  @include('scripts.programas')

  <script>
      $('.btn-confirmar-baja-permiso').on('click', function (e) {
          e.preventDefault();
        
          var permisoProgramaId = ($(this).data("programaid"))

          swal({
                  title: "¿Estás seguro?",
                  text: "¿Estas seguro que deseas eliminar este permiso?",
                  type: "warning",
                  confirmButtonText: "Si",
                  confirmButtonColor: '#3085d6',
                  cancelButtonText: "No",
                  showCancelButton: true
              },
              function() {


                $.ajax({
                    data: {
                      "permisoProgramaId": permisoProgramaId,
                      "_token": $("meta[name=csrf-token]").attr("content")
                    },
                    type: "POST",
                    dataType: "JSON",
                    url: base_url + "/api/users/removePermisoPrograma",
                }).done(function(data) {

                  console.log(data)
                  if (data) {
                        swal({
                            title: "Escuela modelo",
                            text: "Permiso eliminado correctamente",
                            type: "success",
                        });
                    }
                    if (!data) {
                        swal({
                            title: "Escuela modelo",
                            text: "Hubo un error al eliminar el permiso",
                            type: "warning",
                        });
                    }
                 
                });

              });
          });
      </script>


  <script>
    $(document).ready(function() {
        $('input:radio').change(function() {
              if($(this).is(":checked")) {
                  var clase = $(this).val();
                  var array = clase.split("-");
                  var modulo = array[0];
                  var permiso = array[1];
                  $("." + modulo).each(function(){
                    $(this).val(permiso);
                  });
              }
          });
      });
  </script>
@endsection