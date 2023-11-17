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
<a href="{{route('tutorias_categoria_pregunta.index')}}" class="breadcrumb">Lista de categoría pregunta</a>
<a href="{{url('tutorias_categoria_pregunta/'.$categoria_pregunta->CategoriaPreguntaID)}}" class="breadcrumb">Ver categoría pregunta</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
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
                                {!! Form::text('Nombre', $categoria_pregunta->Nombre, array('readonly'=>'true')) !!}
                                {!! Form::label('Nombre', 'Nombre *', array('class' => '')); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l8">
                            <div class="input-field">
                                {!! Form::text('Descripcion', $categoria_pregunta->Descripcion, array('readonly'=>'true')) !!}                                
                                {!! Form::label('Descripcion', 'Descripción *', array('class' => '')); !!}
                            </div>
                        </div>
                    </div>
                </div>


            </div>
           
        </div>
    </div>
</div>



@endsection

@section('footer_scripts')



@endsection