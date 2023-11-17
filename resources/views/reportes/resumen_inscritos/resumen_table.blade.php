@extends('layouts.dashboard')

@section('template_title')
  Reportes
@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="{{url('reporte/resumen_inscritos')}}" class="breadcrumb">Resumen de inscritos</a>
@endsection

@section('content')
<div class="row">
  <div class="col s12 ">
    {{-- {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => 'reporte/resumen_inscritos/exportarExcel', 'method' => 'POST']) !!} --}}
      <div class="card ">
        <div class="card-content ">
          <span class="card-title">Resumen de inscritos</span>
          {{-- NAVIGATION BAR--}}
          <nav class="nav-extended">
            <div class="nav-content">
              <ul class="tabs tabs-transparent">
                <li class="tab"><a class="active" href="#filtros">ESCUELA MODELO, S.C.P.</a></li>
              </ul>
            </div>
          </nav>

          {{-- GENERAL BAR--}}
          
        
          <div class="row">
            <div class="col s12 m12 l12">
              <table class="responsive-table display" cellspacing="0" width="100%">
                
                  <div align="right">
                  <a href="{{url('reporte/resumen_inscritos/exportarExcel')}}" class="btn teal darken-1"><i class="material-icons left">open_in_browser</i>Exportar a Excel</a>
                    {{-- {!! Form::button('<i class="material-icons left">open_in_browser</i>EXPORTAR A EXCEL', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!} --}}
                  </div>
              
                <thead>
                <tr>
                  <th colspan="15">Fecha de último pago recibido: {{$ultimoPago}}</th>
                </tr>
                <tr>
                  <th colspan="15">{{$ubicacionNombre}}</th>
                </tr>
                <tr>
                  <th colspan="15">{{$periodo}}</th>
                </tr>
                <tr>
                  <th align="center">Nivel o carrera</th>
                  <th align="center">Gdo</th>
                  <th align="center">1</th>
                  <th align="center">2</th>
                  <th align="center">3</th>
                  <th align="center">4</th>
                  <th align="center">5</th>
                  <th align="center">6</th>
                  <th align="center">7</th>
                  <th align="center">8</th>
                  <th align="center">9</th>
                  <th align="center">10+</th>
                  <th align="center">TotalN</th>
                  <th align="center">TotalR</th>
                  <th align="center">Total</th>
                </tr>
              </thead>
                @php
                $sumaTotal01 = 0;
                $sumaTotal02 = 0;
                $sumaTotal03 = 0;
                $sumaTotal04 = 0;
                $sumaTotal05 = 0;
                $sumaTotal06 = 0;
                $sumaTotal07 = 0;
                $sumaTotal08 = 0;
                $sumaTotal09 = 0;
                $sumaTotal10 = 0;
                $sumaTotalN = 0;
                $sumaTotalR = 0;
                $sumaTotal = 0;
                @endphp
                @foreach ($datos as $item)
                @php
                $sumaTotal01 += $item['total01'];
                $sumaTotal02 += $item['total02'];
                $sumaTotal03 += $item['total03'];
                $sumaTotal04 += $item['total04'];
                $sumaTotal05 += $item['total05'];
                $sumaTotal06 += $item['total06'];
                $sumaTotal07 += $item['total07'];
                $sumaTotal08 += $item['total08'];
                $sumaTotal09 += $item['total09'];
                $sumaTotal10 += $item['total10'];
                $sumaTotalN += $item['totalN'];
                $sumaTotalR += $item['totalR'];
                $sumaTotal += $item['total'];
                @endphp
               <tbody>
                <tr>
                  <td colspan="2">{{$item['progNombre']}}</td>
                  <td align="center">{{$item['total01'] ?: ''}}</td>
                  <td align="center">{{$item['total02'] ?: ''}}</td>
                  <td align="center">{{$item['total03'] ?: ''}}</td>
                  <td align="center">{{$item['total04'] ?: ''}}</td>
                  <td align="center">{{$item['total05'] ?: ''}}</td>
                  <td align="center">{{$item['total06'] ?: ''}}</td>
                  <td align="center">{{$item['total07'] ?: ''}}</td>
                  <td align="center">{{$item['total08'] ?: ''}}</td>
                  <td align="center">{{$item['total09'] ?: ''}}</td>
                  <td align="center">{{$item['total10'] ?: ''}}</td>
                  <td align="center">{{$item['totalN'] ?: ''}}</td>
                  <td align="center">{{$item['totalR'] ?: ''}}</td>
                  <td align="center">{{$item['total'] ?: ''}}</td>
                </tr>  

                @if ($loop->last)
                <tr>
                  <td colspan="2" align="center">TOTAL ACUMULADO:</td>
                  <td align="center">{{$sumaTotal01 ?: ''}}</td>
                  <td align="center">{{$sumaTotal02 ?: ''}}</td>
                  <td align="center">{{$sumaTotal03 ?: ''}}</td>
                  <td align="center">{{$sumaTotal04 ?: ''}}</td>
                  <td align="center">{{$sumaTotal05 ?: ''}}</td>
                  <td align="center">{{$sumaTotal06 ?: ''}}</td>
                  <td align="center">{{$sumaTotal07 ?: ''}}</td>
                  <td align="center">{{$sumaTotal08 ?: ''}}</td>
                  <td align="center">{{$sumaTotal09 ?: ''}}</td>
                  <td align="center">{{$sumaTotal10 ?: ''}}</td>
                  <td align="center">{{$sumaTotalN ?: ''}}</td>
                  <td align="center">{{$sumaTotalR ?: ''}}</td>
                  <td align="center">{{$sumaTotal ?: ''}}</td>                 
                </tr> 
                @endif
                </tbody>
                @endforeach
              </table>
            </div>
          </div>
           
            
        
      
    {{-- {!! Form::close() !!} --}}
  </div>
</div>
</div>
</div>
@endsection


@section('footer_scripts')


@endsection