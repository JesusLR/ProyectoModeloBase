@extends('layouts.dashboard')

@section('template_title')
    Usuario
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('usuario')}}" class="breadcrumb">Lista de usuarios</a>
    <a href="{{url('usuario/'.$user->id.'/edit')}}" class="breadcrumb">Editar usuario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {{ Form::open(array('method'=>'PUT','route' => ['usuario.update', $user->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR USUARIO #{{$user->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  <li class="tab"><a href="#modulos">Permiso Modulos</a></li>
                  <li class="tab"><a href="#acceso">Permiso Carrera</a></li>
                </ul>
              </div>
            </nav>
            {{-- GENERAL BAR--}}
            <div id="general">
              <div class="row">
                <div class="input-field col s6">
                  {!! Form::text('username', $user->username, array('id' => 'username', 'class' => 'validate','required', 'pattern' => '[A-Z,a-z,0-9]*','readonly')) !!}
                  {!! Form::label('username', 'Usuario *', array('class' => '')); !!}
                </div>
                <div class="col s6">
                  {!! Form::label('empleado_id', 'Empleado', array('class' => '')); !!}
                  <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                      <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      @foreach($empleados as $empleado)
                          @if ($empleado->persona)
                          <option value="{{$empleado->id}}" @if($user->empleado_id == $empleado->id) {{ 'selected' }} @endif>{{$empleado->persona->perNombre ." ". $empleado->persona->perApellido1." ".$empleado->persona->perApellido2}}</option>
                          @endif
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <input type="password" name="password" id="password" class="validate noUpperCase">
                  <label for="password">Contraseña</label>
                </div>
                <div class="input-field col s6">
                  <input type="password" name="password_confirmation" id="password_confirmation" class="validate noUpperCase">
                  <label for="password_confirmation">Confirmar contraseña</label>
                </div>
              </div>
            </div>
            {{-- MODULOS BAR--}}
            <div id="modulos" style="padding-bottom:20px">
              <br>
                <?php $clase = "";?>
                <ul class="collapsible popout" data-collapsible="accordion">
                  @php 
                    $permissions_module_user = $permissions_module_user->sortBy("module.class")
                  @endphp
                @foreach($permissions_module_user as $permission_module_user)
                <?php if($clase != $permission_module_user->module->class){
                    if($clase != ""){ ?>
                      </div>
                      </li>
                    <?php }
                      $clase = $permission_module_user->module->class;
                    ?>
                      <li>
                        <div class="collapsible-header active">
                          <p>
                            <span>{{$permission_module_user->module->class}}</span>
                          </p>
                        </div>
                        <div class="collapsible-body">
                          <div class="row">
                              @foreach($permissions as $permission)
                              <div class="col s3">
                                  <p>
                                    <input class="with-gap" name="radio-{{$permission_module_user->module->id}}" type="radio" id="{{$permission_module_user->module->id}}-{{$permission->id}}" value="{{$permission_module_user->module->class}}-{{$permission->id}}" @if($permission->description == $permission_module_user->permission->description) {{ 'checked' }} @endif/>
                                    <label for="{{$permission_module_user->module->id}}-{{$permission->id}}">{{$permission->description}}</label>
                                  </p>
                              </div>
                              @endforeach
                          </div>
                          <div class="row">
                            <div class="col s6"><h5>Modulo</h5></div>
                            <div class="col s6"><h5>Permiso</h5></div>
                          </div>
                  <?php } ?>
                  <div class="row">
                    <div class="col s6">{{$permission_module_user->module->name}}</div>
                    <div class="col s6">
                      <select class="browser-default {{$permission_module_user->module->class}} " name="modulo-{{$permission_module_user->module->id}}"  style="width: 100%;">
                        @foreach($permissions as $permission)
                          <option value="{{$permission->id}}" @if($permission_module_user->permission->id == $permission->id) {{ 'selected' }} @endif>{{$permission->description}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                @endforeach
                </ul>
            </div>
            {{-- ACCESO BAR--}}
            <div id="acceso">
                <div class="row">
                  <div class="col s12 m6 l4">
                      {!! Form::label('ubicacion_id', 'Campus', array('class' => '')); !!}
                      <select id="ubicacion_id" class="browser-default validate select2" name="ubicacion_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                          @foreach($ubicaciones as $ubicacion)
                            <option value="{{$ubicacion->id}}">{{$ubicacion->ubiNombre}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('departamento_id', 'Departamento', array('class' => '')); !!}
                      <select id="departamento_id" class="browser-default validate select2" name="departamento_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
                  <div class="col s12 m6 l4">
                      {!! Form::label('escuela_id', 'Escuela', array('class' => '')); !!}
                      <select id="escuela_id" class="browser-default validate select2" name="escuela_id" style="width: 100%;">
                          <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                      </select>
                  </div>
              </div>
                <div class="row">
                  <div class="col s12 m6 l4">
                    {!! Form::label('programa_id', 'Programas', array('class' => '')); !!}
                    <select id="programa_id" class="browser-default validate select2" name="programa_id" style="width: 100%;">
                        <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                    </select>
                  </div>
                  <div class="col s2">
                      {!! Form::button('<i class="material-icons left">add</i> Agregar', ['id'=>'agregarPrograma','class' => 'btn-large waves-effect  darken-3']) !!}
                  </div>
                </div>
                <br>
                <br>
                <div id="seccion-programas" class="row">
                  <div class="col s12">
                      <table id="tbl-programas" class="responsive-table display" cellspacing="0" width="100%">
                          <thead>
                          <tr>
                              <th>Escuela</th>
                              <th>Clave</th>
                              <th>Nombre carrera</th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach ($permiso_programa_user as $permiso_programa)
                              <tr id="programa{{$permiso_programa->programa_id}}">
                                  <td>{{$permiso_programa->programa->escuela->escNombre}}</td>
                                  <td>{{$permiso_programa->programa->progClave}}</td>
                                  <td>{{$permiso_programa->programa->progNombre}}</td>
                                  <td>
                                      {{$permiso_programa->id}}
                                      
                                      <button
                                        type="button" data-programaid="{{$permiso_programa->id}}"
                                        class="button btn-confirmar-baja-permiso button--icon js-button js-ripple-effect" title="Eliminar">
                                        <i class="material-icons">delete</i>
                                      </button>


                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
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