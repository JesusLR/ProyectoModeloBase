@extends('layouts.dashboard')

@section('template_title')
    Departamento
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('preescolar_departamento')}}" class="breadcrumb">Lista de departamentos</a>
    <label class="breadcrumb">Agregar departamento</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'preescolar.preescolar_departamento.store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR DEPARTAMENTO</span>

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
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($ubicaciones as $ubicacion)
                                @php
                                $ubicacion_id = Auth::user()->empleado->escuela->departamento->ubicacion->id;
                                if($ubicacion->id == $ubicacion_id){
                                    echo '<option value="'.$ubicacion->id.'" selected>'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                }else{
                                    echo '<option value="'.$ubicacion->id.'">'.$ubicacion->ubiClave.'-'.$ubicacion->ubiNombre.'</option>';
                                }
                                @endphp
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depClave', NULL, array('id' => 'depClave', 'class' => 'validate','required','maxlength'=>'3')) !!}
                            {!! Form::label('depClave', 'Clave departamento *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombre', NULL, array('id' => 'depNombre', 'class' => 'validate','required','maxlength'=>'45')) !!}
                            {!! Form::label('depNombre', 'Nombre departamento *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombreCorto', NULL, array('id' => 'depNombreCorto', 'class' => 'validate','required','maxlength'=>'15')) !!}
                            {!! Form::label('depNombreCorto', 'Nombre corto * (15 carateres)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('depNivel', NULL, array('id' => 'depNivel', 'class' => 'validate','required','min'=>'0','max'=>'9999999999','onKeyPress="if(this.value.length==10) return false;"')) !!}
                            {!! Form::label('depNivel', 'Identificador * (Prefijo nivel)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depClaveOficial', NULL, array('id' => 'depClaveOficial', 'class' => 'validate','maxlength'=>'20')) !!}
                            {!! Form::label('depClaveOficial', 'Clave oficial (SEP)', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombreOficial', NULL, array('id' => 'depNombreOficial', 'class' => 'validate','maxlength'=>'50')) !!}
                            {!! Form::label('depNombreOficial', 'Nombre oficial (SEP)', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('depCalMinAprob', NULL, array('id' => 'depCalMinAprob', 'class' => 'validate','min'=>'0','max'=>'999','onKeyPress="if(this.value.length==3) return false;"')) !!}
                            {!! Form::label('depCalMinAprob', 'Calif. Mínima', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::number('depCupoGpo', NULL, array('id' => 'depCupoGpo', 'class' => 'validate','min'=>'0','max'=>'999','onKeyPress="if(this.value.length==3) return false;"')) !!}
                            {!! Form::label('depCupoGpo', 'Cupo de grupo', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depIncorporadoA', NULL, array('id' => 'depIncorporadoA', 'class' => 'validate','maxlength'=>'70')) !!}
                            {!! Form::label('depIncorporadoA', 'Incorporado a:', array('class' => '')); !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depTituloDoc', NULL, array('id' => 'depTituloDoc', 'class' => 'validate','maxlength'=>'60')) !!}
                            {!! Form::label('depTituloDoc', 'Titulo firma', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depNombreDoc', NULL, array('id' => 'depNombreDoc', 'class' => 'validate','maxlength'=>'60')) !!}
                            {!! Form::label('depNombreDoc', 'Nombre firma', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            {!! Form::text('depPuestoDoc', NULL, array('id' => 'depPuestoDoc', 'class' => 'validate','maxlength'=>'60')) !!}
                            {!! Form::label('depPuestoDoc', 'Puesto de quien firma', array('class' => '')); !!}
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
@include('scripts.preferencias')

@endsection