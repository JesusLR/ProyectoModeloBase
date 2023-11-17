@extends('layouts.dashboard')

@section('template_title')
Responsable de registro / Certificación
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_usuario')}}" class="breadcrumb">Lista de usuarios</a>
<a href="{{url('tutorias_usuario/'.$usuarios->UsuarioID)}}" class="breadcrumb">Ver usuario</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">USUARIO #{{$usuarios->UsuarioID}}</span>

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
                                {!! Form::text('Nombre', $usuarios->Nombre, array('readonly' => 'true')) !!}                              
                                {!! Form::label('Nombre', 'Nombre(s) *', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('ApellidoPaterno', $usuarios->ApellidoPaterno, array('readonly' => 'true')) !!}    
                                {!! Form::label('ApellidoPaterno', 'Apellido paterno*', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('ApellidoMaterno', $usuarios->ApellidoMaterno, array('readonly' => 'true')) !!}                                
                                {!! Form::label('ApellidoMaterno', 'Apellido materno *', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('Correo', $usuarios->Correo, array('readonly' => 'true')) !!}                                
                                {!! Form::label('Correo', 'Correo', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('NombreUsuario', $usuarios->NombreUsuario, array('readonly' => 'true')) !!}                              
                                {!! Form::label('NombreUsuario', 'Nombre de usuario', array('class' => '')); !!}
                            </div>
                        </div>

                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                {!! Form::text('RolID', $usuarios->NombreRol, array('readonly' => 'true')) !!}                              
                                {!! Form::label('RolID', 'Rol', array('class' => '')); !!}
                            </div>
                        </div>
                        
                    </div>


                    
                    <p><strong>Permisos asignados</strong></p>


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
                    

                    <div class="row">
                        @foreach ($permiso_rol as $item)  
                            <div class="col s12 m6 l4" style="margin-top:5px;">
                                <div style="position:relative;">
                                    <input type="checkbox" checked>
                                    <label style="color: black"> {{$item->nombrePermiso}} </label>
                                </div>
                            </div>                                     
                        @endforeach                        
                    </div>

                </div>
            </div>
           
        </div>
  
    </div>
</div>


@endsection

@section('footer_scripts')



@endsection