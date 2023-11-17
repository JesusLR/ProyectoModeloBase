@extends('layouts.dashboard')

@section('template_title')
Responsable de registro / Certificación
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_usuario')}}" class="breadcrumb">Lista de usuarios</a>
<a href="{{url('tutorias_usuario/'.$usuarios->UsuarioID.'/edit')}}" class="breadcrumb">Editar usuario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {!! Form::open(['enctype' => 'multipart/form-data', 'onKeypress' => 'return disableEnterKey(event)','route' => 'tutorias_usuario.store', 'method' => 'POST']) !!}

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">EDITAR USUARIO</span>

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
                        <div class="col s12 m6 l12">
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Foto usuario</span>
                                    <input value="" type="file" name="curExaniFoto">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate"  type="text">
                                </div>
                            </div>                      
                            <input type="hidden" value="true" name="Foto">     
                        </div>                 
                    </div>      
                    
                    
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('Nombre', $usuarios->Nombre, array('id' => 'Nombre', 'class' => 'validate','required','maxlength'=>'100')) !!}                            
                                {!! Form::label('Nombre', 'Nombre(s) *', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('ApellidoPaterno', $usuarios->ApellidoPaterno, array('id' => 'ApellidoPaterno', 'class' => 'validate','required','maxlength'=>'100')) !!}                            
                                {!! Form::label('ApellidoPaterno', 'Apellido paterno*', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('ApellidoMaterno', $usuarios->ApellidoMaterno, array('id' => 'ApellidoMaterno', 'class' => 'validate','required','maxlength'=>'100')) !!}                            
                                {!! Form::label('ApellidoMaterno', 'Apellido materno *', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('Correo', $usuarios->Correo, array('id' => 'Correo', 'class' => 'validate','maxlength'=>'100')) !!}                            
                                {!! Form::label('Correo', 'Correo', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('NombreUsuario', $usuarios->NombreUsuario, array('id' => 'NombreUsuario', 'class' => 'validate','maxlength'=>'100')) !!}                            
                                {!! Form::label('NombreUsuario', 'Nombre de usuario', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('Contrasena', NULL, array('id' => 'Contrasena', 'class' => 'validate','maxlength'=>'100')) !!}                            
                                {!! Form::label('Contrasena', 'Contraseña *', array('class' => '')); !!}
                            </div>
                        </div>

                        
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('ContrasenaDes', NULL, array('id' => 'ContrasenaDes', 'class' => 'validate','maxlength'=>'100')) !!}                            
                                {!! Form::label('ContrasenaDes', 'Confirmar contraseña *', array('class' => '')); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('RolID', 'Rol *', array('class' => '')); !!}
                            <select id="RolID" class="browser-default validate select2" required onchange="valdia();" name="RolID" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach ($rol as $itemRol)
                                    <option value="$itemRol->RolID" {{ $itemRol->RolID == $usuarios->RolID ? 'selected="selected"' : '' }}>{{$itemRol->Nombre}}</option>                                   
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{--  <p><strong>Seleccione un Rol o seleccione los permisos que tendrá
                        este usuario.</strong></p>
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
                    </div>  --}}
                    

                    {{--  <div class="row">
                        @foreach ($permisos as $item)
  
                            <div class="col s12 m6 l6" style="margin-top:5px;">
                                <div style="position:relative;">
                                    <input type="checkbox" name="PermisoID[]" id="{{$item->PermisoID}}" value="{{$item->PermisoID}}">
                                    <label style="color: black" for="{{$item->PermisoID}}"> {{$item->Nombre}} </label>
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