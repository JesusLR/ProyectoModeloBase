@extends('layouts.dashboard')

@section('template_title')
Grupo
@endsection

@section('head')
{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' =>
'stylesheet')) !!}
@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{route('primaria_grupo.index')}}" class="breadcrumb">Lista de Grupo</a>
<a href="{{url('primaria_grupo/'.$categoria_pregunta->CategoriaPreguntaID.'/edit')}}" class="breadcrumb">Editar grupo</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['tutorias_categoria_pregunta.update', $categoria_pregunta->CategoriaPreguntaID])) }}
        <div class="card ">
            <div class="card-content ">
                <span class="card-title">EDITAR CATEGORÍA PREGUNTA #{{$categoria_pregunta->CategoriaPreguntaID}}</span>

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
                                {!! Form::text('Nombre', $categoria_pregunta->Nombre, array('id' => 'Nombre', 'class' => 'validate')) !!}
                                {!! Form::label('Nombre', 'Nombre *', array('class' => '')); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l8">
                            <div class="input-field">
                                {!! Form::text('Descripcion', $categoria_pregunta->Descripcion, array('id' => 'Descripcion', 'class' => 'validate'))
                                !!}
                                {!! Form::label('Descripcion', 'Descripción *', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                                <input type="number" name="orden_visual_categoria" id="orden_visual_categoria" min="1" max="100" class="validate" value="{{$categoria_pregunta->orden_visual_categoria}}">
                                {!! Form::label('orden_visual_categoria', 'Orden visual de la categoría *', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card-action">
                        {!! Form::button('<i class="material-icons left">save</i> Guardar', ['display' =>
                        'inline-block', 'class' => 'btn-large waves-effect darken-3','type' => 'submit']) !!}

                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>



@endsection

@section('footer_scripts')



@endsection