@extends('layouts.dashboard')

@php use App\Http\Helpers\Utils; @endphp

@section('template_title')
    Matrículas
@endsection

@section('head')
{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('grupo')}}" class="breadcrumb">Lista de Grupos</a>
    <a href="" class="breadcrumb">Matrículas del Grupo</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'matricula/store', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
          <span class="card-title">MATRÍCULAS DEL GRUPO #{{$grupo->id}}</span>
            {{-- NAVIGATION BAR--}}

     
            <input id="grupo_id" name="grupo_id" type="hidden" value="{{$grupo->id}}">
            <div class="row">
                <div class="col s12">
                    <span>Grupo y Clave: <b>{{$grupo->gpoSemestre}} - {{$grupo->gpoClave}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>Materia: <b>{{$grupo->materia->matClave}}-{{$grupo->materia->matNombre}}</b></span>
                </div>
            </div>
            @if($optativa)
            <div class="row">
                <div class="col s12">
                    <span>Optativa: <b>{{$optativa->optNombre}}</b></span>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col s12">
                    <span>Plan: <b>{{$grupo->materia->plan->planClave}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>Periodo: <b>{{Utils::fecha_string($grupo->periodo->perFechaInicial)}} al
                        {{Utils::fecha_string($grupo->periodo->perFechaFinal)}}
                        ({{$grupo->periodo->perNumero}}/{{$grupo->periodo->perAnio}})</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>Programa: <b>{{$grupo->plan->programa->progClave}} - {{$grupo->plan->programa->progNombre}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>
                        Docente: <b>{{$grupo->empleado->persona->perNombre}}
                        {{$grupo->empleado->persona->perApellido1}}
                        {{$grupo->empleado->persona->perApellido2}}</b>
                    </span>
                </div>
            </div>
            
            {{-- GENERAL BAR--}}
         
                <div class="row">
                    <div class="col s12">
                        <table id="tbl-alumnos" class="responsive-table display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Clave alumno</th>
                                <th>Nombre alumno</th>
                                <th>Matrícula Actual</th>
                                <th>Nueva Matrícula</th>
                            </tr>
                            </thead>
                            <tbody>
                    
                                @foreach ($inscritos as $inscrito)
                               
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$inscrito->curso->alumno->aluClave}}</td>
                                    <td>
                                        {{$inscrito->curso->alumno->persona->perApellido1 . ' ' .
                                        $inscrito->curso->alumno->persona->perApellido2  . ' ' .
                                        $inscrito->curso->alumno->persona->perNombre}}
                                    </td>
                                    <td>{{$inscrito->curso->alumno->aluMatricula}}</td>
                                 
                                        <td>
                                            
                                            <input 
                                                name="matricula[insc][{{$inscrito->id}}]"
                                                type="text" class="matricula"
                                               
                                                value=""
                                                data-inscritoid="{{$inscrito->id}}">
                                        </td>
                                        
                                </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            

            {{-- GENERAL BAR--}}
            

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

@include('scripts.calificacion')
{!! HTML::script(asset('/vendors/data-tables/js/jquery.dataTables.min.js'), array('type' => 'text/javascript')) !!}
{!! HTML::script(asset('/js/scripts/data-tables.js'), array('type' => 'text/javascript')) !!}
<script type="text/javascript">
    $(document).ready(function() {
        $('#tbl-alumnos').dataTable({
            "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "dom": '"top"i',
            "ordering": false,
            "bPaginate": false,
            "order": [
                [2, 'asc']
            ]
        });
    });
</script>

@endsection