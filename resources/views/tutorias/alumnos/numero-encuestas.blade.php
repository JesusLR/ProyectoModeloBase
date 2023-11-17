@extends('layouts.dashboard')

@section('template_title')
Lista de encuetas
@endsection

@section('head')

@endsection

@section('breadcrumbs')
<a href="{{url('/')}}" class="breadcrumb">Inicio</a>
<a href="{{url('tutorias_encuestas')}}" class="breadcrumb">Lista de alumno</a>
<a href="{{url('tutorias_encuestas/encuestas_disponibles/'.$alumno->aluClave.'/'.$alumno->CursoID)}}" class="breadcrumb">Lista de encuestas</a>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">

        <div class="card ">
            <div class="card-content ">
                <span class="card-title">ENCUESTAS DISPONIBLES</span>

                @for ($i = 0; $i < 10; $i++)
    
                         
                
                @endfor
                <div class="row">
                    @foreach ($tutorias_formularios as $itemTutorias_formularios)
                    <div style="text-align: center; background-color: #01579B; border-radius: 10px; margin: 10px;" class="col s6 m6 l11"><br>
                        @if ($itemTutorias_formularios->Tipo == 3)
                        <a style="color: #fff" href="{{url('tutorias_encuestas/encuesta_covid/' . $itemTutorias_formularios->FormularioID . '/' .$alumno->AlumnoID)}}  ">
                            <p>{{$itemTutorias_formularios->Nombre}}</p>
                            <p>{{ \Carbon\Carbon::parse($itemTutorias_formularios->FechaInicioVigencia)->format('d/m/Y')}} - {{ \Carbon\Carbon::parse($itemTutorias_formularios->FechaFinVigencia)->format('d/m/Y')}}</p>
                            <p>{{$itemTutorias_formularios->Descripcion}}</p>
                        </a>
                        @else
                        <a style="color: #fff" href="{{url('tutorias_encuestas/encuesta/' . $itemTutorias_formularios->FormularioID . '/' .$alumno->AlumnoID)}}  ">
                            <p>{{$itemTutorias_formularios->Nombre}}</p>
                            <p>{{ \Carbon\Carbon::parse($itemTutorias_formularios->FechaInicioVigencia)->format('d/m/Y')}} - {{ \Carbon\Carbon::parse($itemTutorias_formularios->FechaFinVigencia)->format('d/m/Y')}}</p>
                            <p>{{$itemTutorias_formularios->Descripcion}}</p>
                        </a>
                        @endif
                        
                        <br>
                    </div>
                    @endforeach
                </div>



            </div>

        </div>

    </div>
</div>



@endsection

@section('footer_scripts')



@endsection