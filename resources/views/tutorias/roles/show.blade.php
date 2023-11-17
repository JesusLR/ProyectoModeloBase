@extends('layouts.dashboard')

@section('template_title')
    Grupo
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{route('tutorias_rol.index')}}" class="breadcrumb">Lista de roles</a>
    <a href="{{url('tutorias_rol/'.$roles->RolID)}}" class="breadcrumb">Ver rol</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">GRUPO #{{$roles->RolID}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                  {{-- <li class="tab"><a href="#equivalente">Equivalente</a></li> --}}
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">           
  
                    
                    
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('Nombre', $roles->Nombre, array('readonly' => 'true')) !!}                           
                            {!! Form::label('Nombre', 'Nombre *', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('Descripcion', $roles->Descripcion, array('readonly' => 'true')) !!}     
                            {!! Form::label('Descripcion', 'Descripción *', array('class' => '')); !!}
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('Clave', $roles->Clave, array('readonly' => 'true')) !!}                          
                            {!! Form::label('Clave', 'Clave *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

               <p><strong> Indique los permisos del rol *</strong></p>
                
                <div class="row">
                    <div class="col s12 m6 l4">                    
                        <div class="switch">
                            <label>Seleccionar todos</label>
                            <label>                                    
                                <input id="seleccionarTodos" type="checkbox" disabled>
                                <span class="lever"></span>
                                <label id="opcion">NO</label>
                            </label>
                        </div>
                    </div>
                </div>
                

                <div class="row">
                    @foreach ($rol_permiso as $item)
                    <div class="col s12 m6 l6" style="margin-top:5px;">
                        <div style="position:relative;">
                            <input type="checkbox" name="PermisoID[]" id="{{$item->PermisoID}}" value="{{$item->PermisoID}}" readonly tabindex=-1>
                            <label > {{$item->Nombre}} </label>
                        </div>
                        <label> {{$item->Descripcion}}</label>
                    </div>
                    @foreach ($permisoRoles as $itemPermisoRoles)

                    @if ($itemPermisoRoles->PermisoID == $item->PermisoID)
                        <script>
                            $("#{{$item->PermisoID}}").prop("checked", true);
                        </script>      
                    @endif
                    
                    @endforeach
                    <script>
                        $( '#seleccionarTodos' ).on( 'click', function() {
                            if( $(this).is(':checked') ){
                                // Hacer algo si el checkbox ha sido seleccionado
                                $("#opcion").html('SI'); 
                                $("#{{$item->PermisoID}}").prop("checked", true);
                              
                            
                            } else {
                                // Hacer algo si el checkbox ha sido deseleccionado
                                $("#opcion").html('NO');
                                $("#{{$item->PermisoID}}").prop("checked", false);

                            }
                        });
                    </script>                     
                    
                    @endforeach

                    
                    
                </div>
          
               

            </div>

           
          </div>
        </div>
    </div>
  </div>

@endsection

<style>
    input[type="checkbox"][readonly] {
        pointer-events: none !important;
      }                             
    
</style>