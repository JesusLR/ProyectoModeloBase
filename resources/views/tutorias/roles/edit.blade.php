@extends('layouts.dashboard')

@section('template_title')
Responsable de registro / Certificación
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_rol')}}" class="breadcrumb">Lista de roles</a>
<a href="{{url('tutorias_rol/edit')}}" class="breadcrumb">Editar rol</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['tutorias_rol.update', $roles->RolID])) }}

        <div class="card ">
            <div class="card-content ">
                <span class="card-title">EDITAR ROL</span>

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
                            <div class="input-field">
                                {!! Form::text('Nombre', $roles->Nombre, array('id' => 'Nombre', 'class' => 'validate','required','maxlength'=>'100')) !!}                            
                                {!! Form::label('Nombre', 'Nombre *', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('Descripcion', $roles->Descripcion, array('id' => 'Descripcion', 'class' => 'validate','required','maxlength'=>'100')) !!}                            
                                {!! Form::label('Descripcion', 'Descripción *', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('Clave', $roles->Clave, array('id' => 'Clave', 'class' => 'validate','required','maxlength'=>'100')) !!}                            
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
                                    <input id="seleccionarTodos" type="checkbox">
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
                                <input type="checkbox" name="PermisoID[]" id="{{$item->PermisoID}}" value="{{$item->PermisoID}}">
                                <label for="{{$item->PermisoID}}"> {{$item->Nombre}} </label>
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
                    {{--  <div class="row">
                        @foreach ($rol_permiso as $item)
                        <div class="col s12 m6 l6" style="margin-top:5px;">
                            <div style="position:relative;">
                                <input type="checkbox" name="PermisoID[]" id="{{$item->PermisoID}}" value="{{$item->PermisoID}}">
                                <label for="{{$item->PermisoID}}"> {{$item->Nombre}} </label>
                            </div>
                            <label> {{$item->Descripcion}}</label>
                        </div>

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

                        
                        
                    </div>  --}}

                   

                </div>
            </div>
            <div class="card-action">
                {!! Form::button('<i class="material-icons left">save</i> Guardar', [ 'id'=>'btn-guardar','class' =>
                'btn-large waves-effect darken-3', 'type' => 'submit']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>



@endsection

@section('footer_scripts')



@endsection