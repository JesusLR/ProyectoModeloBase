@extends('layouts.dashboard')

@section('template_title')
    Cuenta
@endsection

@section('head')

@endsection


@section('breadcrumbs')
    <div class="col s12">
        <p style="color: #000; margin-left: 10px;">

        </p>
    </div>
@endsection

@section('content')


<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    USUARIO
                    {{ Auth::user()->empleado->persona->perNombre }}
                    {{ Auth::user()->empleado->persona->perApellido1 }}
                    {{ Auth::user()->empleado->persona->perApellido2 }}
                </span>
        
                {{-- NAVIGATION BAR--}}
                <nav class="nav-extended">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="active" href="#cambiarPassword">Cambiar Contraseña</a></li>
                        </ul>
                    </div>
                </nav>

                
                {{-- cambiarPassword BAR--}}
                <div id="cambiarPassword">
                    <div class="row">
                        {{ Form::open(['method'=>'POST','route' => ['password.update']]) }}

                            <div class="col s12 m6 l4">
                                <div class="input-field">
                                    <input type="password" id="oldPassword" name="oldPassword" class="validate noUpperCase" maxlength="255">
                                    <label for="oldPassword">Contraseña Actual</label>
                                </div>


                                <div class="input-field">
                                    <input type="password" id="password" name="password" class="validate noUpperCase" maxlength="255">
                                    <label for="password">Nueva Contraseña</label>
                                </div>


                                <div class="input-field">
                                    <input type="password" id="confirmPassword" name="confirmPassword" class="validate noUpperCase" maxlength="255">
                                    <label for="confirmPassword">Confirmar Nueva Contraseña</label>
                                </div>

                                {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
                            </div>
                        {!! Form::close() !!}

                    </div>
                    
                </div>

            </div>
        </div>
    </div>
</div>


@endsection

@section('footer_scripts')
@endsection