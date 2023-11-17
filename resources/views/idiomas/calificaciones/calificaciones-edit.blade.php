@extends('layouts.dashboard')

@section('template_title')
Idiomas calificaciones
@endsection

@section('head')

{!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' =>
'stylesheet')) !!}
@endsection

@section('breadcrumbs')
<a href="{{url('idiomas_grupo')}}" class="breadcrumb">Inicio</a>
<a href="{{route('idiomas.idiomas_grupo.index')}}" class="breadcrumb">Lista de Grupo</a>
<a href="#"
    class="breadcrumb">Editar calificación</a>
@endsection

@section('content')

<div class="row">
    <div class="col s12 ">
        {!! Form::open(['enctype' => 'multipart/form-data', 'onKeypress' => 'return disableEnterKey(event)','route' => 'idiomas_calificacion.calificaciones.update_calificacion', 'method' => 'POST']) !!}

        <div class="card ">
            <div class="card-content ">
                <span class="card-title">CAPTURA DE CALIFICACIONES DEL GRUPO #{{$grupo->id}}</span>

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

                <input type="hidden" name="idiomas_resumen_calificaciones" value="{{ $grupo->idiomas_resumen_calificaciones }}">

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id2', 'Periodo *', ['class' => '']); !!}
                            <select name="periodo_id2" id="periodo_id2" class="browser-default validate select2"
                                style="width: 100%;">
                                <option value="{{$grupo->periodo_id}}">
                                   {{$grupo->perNumero}}-{{\Carbon\Carbon::parse($grupo->perFechaInicial)->format('Y')}}
                                </option>

                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            {!! Form::label('idiomas_grupo_id', 'Grupo *', ['class' => '']); !!}
                            <select name="idiomas_grupo_id" id="idiomas_grupo_id"
                                class="browser-default validate select2" style="width: 100%;">
                                @if ($grupo->matClaveAsignatura != "")
                                <option value="{{$grupo->id}}">
                                    {{$grupo->gpoGrado}}-{{$grupo->gpoClave}}, Prog:
                                    {{$grupo->progClave}}</option>
                                @else
                                <option value="{{$grupo->id}}">
                                    {{$grupo->gpoGrado}}-{{$grupo->gpoClave}}, Prog:
                                    {{$grupo->progClave}}</option>
                                @endif

                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('idiomas_grupo_evidencia_id', 'Clave de evaluación *', array('class' => ''));
                            !!}
                            <select id="idiomas_grupo_evidencia_id" class="browser-default validate select2" required
                                name="idiomas_grupo_evidencia_id" style="width: 100%;"
                                data-mes-idold="idiomas_grupo_evidencia_id">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                <option value="Reporte1">Reporte 1</option>
                                <option value="Reporte2">Reporte 2</option>
                                <option value="MidTerm">MidTerm</option>
                                <option value="Project1">Proyecto 1</option>
                                <option value="Reporte3">Reporte 3</option>
                                <option value="Reporte4">Reporte 4</option>
                                <option value="FinalExam">finalExam</option>
                                <option value="Project2">Proyecto 2</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <table id="Reporte1" class="responsive-table" style="display:none" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">CVE PAGO</th>
                                    <th scope="col">ALUMNO</th>
                                    @foreach($cabecera as $materia)
                                    <th class="classEvi1" scope="col">{{ $materia->matNombre }}</th>
                                    @endforeach
                                    <th class="classEvi5" scope="col">TOTAL</th>
                                    <th class="classEvi6" scope="col">POND.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->aluClave }}</td>
                                    <td>{{ $alumno->perApellido1 }} {{ $alumno->perApellido2 }} {{ $alumno->perNombre }}</td>
                                    @foreach($tbody->where('idiomas_resumen_calificaciones_id',$alumno->idiomas_resumen_calificaciones) as $materia)
                                    <td>
                                        <div class="input-field inline">
                                            @php
                                                $calificaciones_Reporte1 = "calificaciones_Reporte1[$alumno->idiomas_resumen_calificaciones][$materia->id]";
                                                $value = old($calificaciones_Reporte1) ? old($calificaciones_Reporte1): $materia->cmReporte1
                                            @endphp
                                            {!! Form::number($calificaciones_Reporte1, $value, [
                                                'class' => 'cal',
                                                'required',
                                                'min' => '0',
                                                'max' => '25',
                                                'style' => 'text-align:center'
                                            ]) !!}
                                        </div>
                                    </td>
                                    @endforeach
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcReporte1 }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcReporte1Ponderado }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table id="Reporte2" class="responsive-table" style="display:none" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">CVE PAGO</th>
                                    <th scope="col">ALUMNO</th>
                                    @foreach($cabecera as $materia)
                                    <th class="classEvi1" scope="col">{{ $materia->matNombre }}</th>
                                    @endforeach
                                    <th class="classEvi5" scope="col">TOTAL</th>
                                    <th class="classEvi6" scope="col">POND.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->aluClave }}</td>
                                    <td>{{ $alumno->perApellido1 }} {{ $alumno->perApellido2 }} {{ $alumno->perNombre }}</td>
                                    @foreach($tbody->where('idiomas_resumen_calificaciones_id',$alumno->idiomas_resumen_calificaciones) as $materia)
                                    <td>
                                        <div class="input-field inline">
                                            @php
                                                $calificaciones_Reporte2 = "calificaciones_Reporte2[$alumno->idiomas_resumen_calificaciones][$materia->id]";
                                                $value = old($calificaciones_Reporte2) ? old($calificaciones_Reporte2): $materia->cmReporte2;
                                            @endphp
                                            {!! Form::number($calificaciones_Reporte2, $value, [
                                                'class' => 'cal',
                                                'required',
                                                'min' => '0',
                                                'max' => '25',
                                                'style' => 'text-align:center'
                                            ]) !!}
                                        </div>
                                    </td>
                                    @endforeach
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcReporte2 }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcReporte2Ponderado }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table id="MidTerm" class="responsive-table" style="display:none" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">CVE PAGO</th>
                                    <th scope="col">ALUMNO</th>
                                    <th class="classEvi5" scope="col">TOTAL</th>
                                    <th class="classEvi6" scope="col">POND.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->aluClave }}</td>
                                    <td>{{ $alumno->perApellido1 }} {{ $alumno->perApellido2 }} {{ $alumno->perNombre }}</td>
                                    <td>
                                        <div class="input-field inline">
                                            @php
                                                $calificaciones_MidTerm = "calificaciones_MidTerm[$alumno->idiomas_resumen_calificaciones][$materia->id]";
                                                $value = old($calificaciones_MidTerm) ? old($calificaciones_MidTerm): $alumno->rcMidTerm;
                                            @endphp
                                            {!! Form::number($calificaciones_MidTerm, $value, [
                                                'class' => 'cal',
                                                'required',
                                                'min' => '0',
                                                'style' => 'text-align:center'
                                            ]) !!}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcMidTermPonderado }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table id="Project1" class="responsive-table" style="display:none" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">CVE PAGO</th>
                                    <th scope="col">ALUMNO</th>
                                    <th class="classEvi5" scope="col">TOTAL</th>
                                    <th class="classEvi6" scope="col">POND.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->aluClave }}</td>
                                    <td>{{ $alumno->perApellido1 }} {{ $alumno->perApellido2 }} {{ $alumno->perNombre }}</td>
                                    <td>
                                        <div class="input-field inline">
                                            @php
                                                $calificaciones_Project1 = "calificaciones_Project1[$alumno->idiomas_resumen_calificaciones][$materia->id]";
                                                $value = old($calificaciones_Project1) ? old($calificaciones_Project1): $alumno->rcProject1;
                                            @endphp
                                            {!! Form::number($calificaciones_Project1, $value, [
                                                'class' => 'cal',
                                                'required',
                                                'min' => '0',
                                                'style' => 'text-align:center'
                                            ]) !!}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcProject1Ponderado }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table id="Reporte3" class="responsive-table" style="display:none" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">CVE PAGO</th>
                                    <th scope="col">ALUMNO</th>
                                    @foreach($cabecera as $materia)
                                    <th class="classEvi1" scope="col">{{ $materia->matNombre }}</th>
                                    @endforeach
                                    <th class="classEvi5" scope="col">TOTAL</th>
                                    <th class="classEvi6" scope="col">POND.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->aluClave }}</td>
                                    <td>{{ $alumno->perApellido1 }} {{ $alumno->perApellido2 }} {{ $alumno->perNombre }}</td>
                                    @foreach($tbody->where('idiomas_resumen_calificaciones_id',$alumno->idiomas_resumen_calificaciones) as $materia)
                                    <td>
                                        <div class="input-field inline">
                                            @php
                                                $calificaciones_Reporte3 = "calificaciones_Reporte3[$alumno->idiomas_resumen_calificaciones][$materia->id]";
                                                $value = old($calificaciones_Reporte3) ? old($calificaciones_Reporte3): $materia->cmReporte3;
                                            @endphp
                                            {!! Form::number($calificaciones_Reporte3, $value, [
                                                'class' => 'cal',
                                                'required',
                                                'min' => '0',
                                                'max' => '25',
                                                'style' => 'text-align:center'
                                            ]) !!}
                                        </div>
                                    </td>
                                    @endforeach
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcReporte3 }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcReporte3Ponderado }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table id="Reporte4" class="responsive-table" style="display:none" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">CVE PAGO</th>
                                    <th scope="col">ALUMNO</th>
                                    @foreach($cabecera as $materia)
                                    <th class="classEvi1" scope="col">{{ $materia->matNombre }}</th>
                                    @endforeach
                                    <th class="classEvi5" scope="col">TOTAL</th>
                                    <th class="classEvi6" scope="col">POND.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->aluClave }}</td>
                                    <td>{{ $alumno->perApellido1 }} {{ $alumno->perApellido2 }} {{ $alumno->perNombre }}</td>
                                    @foreach($tbody->where('idiomas_resumen_calificaciones_id',$alumno->idiomas_resumen_calificaciones) as $materia)
                                    <td>
                                        <div class="input-field inline">
                                            @php
                                                $calificaciones_Reporte4 = "calificaciones_Reporte4[$alumno->idiomas_resumen_calificaciones][$materia->id]";
                                                $value = old($calificaciones_Reporte4) ? old($calificaciones_Reporte4): $materia->cmReporte4;
                                            @endphp
                                            {!! Form::number($calificaciones_Reporte4, $value, [
                                                'class' => 'cal',
                                                'required',
                                                'min' => '0',
                                                'max' => '25',
                                                'style' => 'text-align:center'
                                            ]) !!}
                                        </div>
                                    </td>
                                    @endforeach
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcReporte4 }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcReporte4Ponderado }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table id="FinalExam" class="responsive-table" style="display:none" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">CVE PAGO</th>
                                    <th scope="col">ALUMNO</th>
                                    <th class="classEvi5" scope="col">TOTAL</th>
                                    <th class="classEvi6" scope="col">POND.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->aluClave }}</td>
                                    <td>{{ $alumno->perApellido1 }} {{ $alumno->perApellido2 }} {{ $alumno->perNombre }}</td>
                                    <td>
                                        <div class="input-field inline">
                                            @php
                                                $calificaciones_FinalExam = "calificaciones_FinalExam[$alumno->idiomas_resumen_calificaciones][$materia->id]";
                                                $value = old($calificaciones_FinalExam) ? old($calificaciones_FinalExam): $alumno->rcFinalExam;
                                            @endphp
                                            {!! Form::number($calificaciones_FinalExam, $value, [
                                                'class' => 'cal',
                                                'required',
                                                'min' => '0',
                                                'style' => 'text-align:center'
                                            ]) !!}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcFinalExamPonderado }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table id="Project2" class="responsive-table" style="display:none" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">CVE PAGO</th>
                                    <th scope="col">ALUMNO</th>
                                    <th class="classEvi5" scope="col">TOTAL</th>
                                    <th class="classEvi6" scope="col">POND.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->aluClave }}</td>
                                    <td>{{ $alumno->perApellido1 }} {{ $alumno->perApellido2 }} {{ $alumno->perNombre }}</td>
                                    <td>
                                        <div class="input-field inline">
                                            @php
                                                $calificaciones_Project2 = "calificaciones_Project2[$alumno->idiomas_resumen_calificaciones][$materia->id]";
                                                $value = old($calificaciones_Project2) ? old($calificaciones_Project2): $alumno->rcProject2;
                                            @endphp
                                            {!! Form::number($calificaciones_Project2, $value, [
                                                'class' => 'cal',
                                                'required',
                                                'min' => '0',
                                                'style' => 'text-align:center'
                                            ]) !!}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field inline">    
                                            <input value="{{ $alumno->rcProject2Ponderado }}" class="cal" readonly tabindex="-1" type="number" min="0" style="text-align:center;">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

            <div class="card-action" id="btn-ocultar-si-es-menor-a-cien" style="display: none">
                <button type="submit" onclick="this.disabled=true;this.form.submit();this.innerText='Guardando datos...';" class="btn-guardar btn-large waves-effect darken-3"><i
                        class="material-icons left">save</i>Guardar</button>
            </div>
        </div>

    </div>
    {!! Form::close() !!}
</div>



<style>
    table tbody tr:nth-child(odd) {
        background: #F7F8F9;
    }
    table tbody tr:nth-child(even) {
        background: #F1F1F1;
    }
    table thead {
      background: #01579B;
      color: #fff;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
</style>


@endsection

@section('footer_scripts')
<script type="text/javascript">
    $(document).ready(function() {
        @if( old('idiomas_grupo_evidencia_id') )
            $('#idiomas_grupo_evidencia_id').val('<?=old('idiomas_grupo_evidencia_id')?>'); // 
            $('#idiomas_grupo_evidencia_id').trigger('change');
            $('#btn-ocultar-si-es-menor-a-cien').show();
            $('table').hide();
            $('#'+$('#idiomas_grupo_evidencia_id').val()).show();
        @endif

        $('#idiomas_grupo_evidencia_id').change(function(){
            $('#btn-ocultar-si-es-menor-a-cien').show();
            $('table').hide();
            $('#'+$('#idiomas_grupo_evidencia_id').val()).show();
        });

        $('.val').change(function () {

        });
    });
</script>
@endsection
