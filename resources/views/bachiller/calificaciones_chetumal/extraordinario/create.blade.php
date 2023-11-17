@extends('layouts.dashboard')

@php use App\Http\Helpers\Utils; @endphp

@section('template_title')
    Bachiller calificación recuperativo
@endsection

@section('head')
{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('bachiller_curso')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_recuperativos')}}" class="breadcrumb">Lista de recuperativos</a>
    <a href="" class="breadcrumb">Calificaciones de los recuperativos</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','route' => 'bachiller.bachiller_recuperativos.extraStore', 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
          <span class="card-title">CALIFICACIONES DEL EXTRAORDINARIO #{{$extraordinario->id}} @if ($grupoCerrado) <b style="color: red">LAS ACTAS DE ESTE GRUPO YA SE ENCUENTRAN CERRADAS</b> @endif</span>
            {{-- NAVIGATION BAR--}}

     
            <input id="extraordinario_id" name="extraordinario_id" type="hidden" value="{{$extraordinario->id}}">
            <div class="row">
                <div class="col s12">
                    <span>Programa: <b>{{$extraordinario->bachiller_materia->plan->programa->progNombre}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>Plan: <b>{{$extraordinario->bachiller_materia->plan->planClave}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>Materia: <b>{{$extraordinario->bachiller_materia->matClave}}-{{$extraordinario->bachiller_materia->matNombre}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>Fecha y hora: <b>{{$extraordinario->extFecha}} - {{$extraordinario->extHora}}</b></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <span>
                        Docente: <b>{{$extraordinario->bachiller_empleado->empNombre}}
                        {{$extraordinario->bachiller_empleado->empApellido1}}
                        {{$extraordinario->bachiller_empleado->empApellido2}}</b>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col s12">

                    {{--  @if ($grupoCerrado)
                        <a href="{{url('bachiller_recuperativos/abrirElActaRecuperativo/'.$extraordinario->id)}}" class="btn-abrir-grupo waves-effect waves-light btn">
                            <i class="material-icons left">lock_open</i>Abrir grupo (ACTAS CERRADAS)
                        </a>
                    @endif                     --}}
                    {{--  @if ($grupoCerrado)
                    <span style="color:red">
                        <b>LAS ACTAS DE ESTE GRUPO YA SE ENCUENTRAN CERRADAS</b>
                    </span>
                    @endif    --}}
                   
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
                                <th>iex Estado</th>
                                <th>Calificación</th>
                                <th>Inasistencia</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                    $consecutivo=1;
                               
                                @endphp
                    
                                @foreach ($inscritos as $inscritoEx)
                               
                                <tr>
                                    <td>{{$consecutivo}}</td>
                                    <td>{{$inscritoEx->alumno->aluClave}}</td>
                                    <td>
                                        {{$inscritoEx->alumno->persona->perApellido1 . ' ' .
                                        $inscritoEx->alumno->persona->perApellido2  . ' ' .
                                        $inscritoEx->alumno->persona->perNombre}}
                                    </td>
                                    
                                    <td>
                                        @php
                                        $clave_pago = $inscritoEx->alumno->aluClave;
                                        $inscritos_a_recuperativo = DB::select("SELECT bie.id, bie.alumno_id, bie.iexEstado, alu.aluClave FROM bachiller_inscritosextraordinarios AS bie
                                        INNER JOIN alumnos AS alu ON alu.id = bie.alumno_id
                                        WHERE bie.extraordinario_id =$extraordinario->id
                                        AND alu.aluClave=$clave_pago");
                                        @endphp

                                        @foreach ($inscritos_a_recuperativo as $value)
                                            @if ($clave_pago == $value->aluClave)
                                                @if ($value->iexEstado == "P")
                                                    PAGADO
                                                @else
                                                    PENDIENTE PAGO
                                                @endif  
                                            @endif                    
                                        @endforeach                             
                                    </td>
                                    <td>
                                        
                                        <input @if($grupoCerrado)  @endif
                                            name="calificacion[inscEx][{{$inscritoEx->id}}]"
                                            type="number" class="calif" min="0" max="100"
                                            
                                            value="{{$inscritoEx->iexCalificacion}}"
                                            data-inscritoid="{{$inscritoEx->id}}">
                                    </td>
                                    <td>
                                        <select @if($grupoCerrado) @endif name="calificacion[asistencia][{{$inscritoEx->id}}]">
                                            @foreach ($motivosFalta as $item)
                                                <option value="{{$item->id}}" {{$inscritoEx->motivofalta_id == $item->id ? "selected": ""}}>{{$item->mfDescripcion}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                    @php
                                        $consecutivo++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            

            {{-- GENERAL BAR--}}
            

          </div>
          <div class="card-action">
        
            {{--  @if(!$grupoCerrado)   --}}
                {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
            {{--  @endif  --}}
        
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

               // disable mousewheel on a input number field when in focus
    // (to prevent Cromium browsers change the value when scrolling)
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('wheel.disableScroll', function (e) {
            e.preventDefault()
        })
    })
    $('form').on('blur', 'input[type=number]', function (e) {
        $(this).off('wheel.disableScroll')
    })
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