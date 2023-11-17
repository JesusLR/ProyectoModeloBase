@extends('layouts.dashboard')

@section('template_title')
  Inscrito edu. continua
@endsection

@section('head')

@endsection

@section('breadcrumbs')
  <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
  <a href="{{url('inscritosEduContinua')}}" class="breadcrumb">Lista de Inscritos</a>
  <label class="breadcrumb">Realizar Pago</label>
@endsection

@section('content')

@php
  use App\Http\Helpers\Utils;
  use App\clases\personas\MetodosPersonas;

  $programa = $inscrito->educacioncontinua;
  $alumno = $inscrito->alumno;
  $clases_btn = 'btn waves-effect btn-ficha-pago';
  $esUsuarioEspecial = in_array(auth()->user()->username, ['DESARROLLO', 'LLARA', 'ALDRYN', 'EAIL', 'FLOPEZH']);

  function existePagoConcepto($pagos, $concepto) {
    $pago = $pagos->where('pagConcPago', $concepto)->first();
    return $pago;
  }

  function mostrarFechaPago($pagos, $concepto) {
    $pago = $pagos->where('pagConcPago', $concepto)->first();
    $fecha = $pago ? $pago->pagFechaPago : null;
    return Utils::fecha_string($fecha, 'mesCorto');
  }
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['id' => 'form_ficha_pago', 'onKeypress' => 'return disableEnterKey(event)', 'method' => 'POST', 'target' => '_blank']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">REALIZAR PAGO</span>

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
                <div class="col s12 m6 l6">
                  <h5>Alumno</h5>
                  <p><b>Clave: </b> {{$alumno->aluClave}}</p>
                  <p><b>Nombre: </b> {{MetodosPersonas::nombreCompleto($alumno->persona)}}</p>
                  <p><b>Ubicación: </b> {{$programa->ubicacion->ubiNombre}}</p>
                </div>
                <div class="col s12 m6 l6">
                  <h5>Programa</h5>
                  <p><b>ID: </b> {{$programa->id}}</p>
                  <p><b>Clave: </b> {{$programa->ecClave}}</p>
                  <p><b>Nombre: </b> {{$programa->ecNombre}}</p>
                </div>
              </div>
      
              <div class="row">
                <div class="col s12">
                  <table id="tbl-pagos" class="responsive-table display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Concepto</th>
                        <th>Tipo</th>
                        <th>Importe</th>
                        <th>fecha vencimiento</th>
                        <th>Importe Especial</th>
                        <th>Fecha vencimiento Especial</th>
                        <th>Imprimir fichas de pago</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        @if($programa->ecImporteInscripcion && $programa->ecVencimientoInscripcion)
                          @php
                            $pago90 = existePagoConcepto($pagos, '90');
                            $importe90 = $pago90 ? $pago90->pagImpPago : $programa->ecImporteInscripcion;
                            $hide_especiales90 = $pago90 ? 'hidden' : '';
                          @endphp
                          <td>90</td>
                          <td>Inscripción</td>
                          <td>${{number_format($importe90, 2, '.', ',')}}</td>
                          <td>{{Utils::fecha_string($programa->ecVencimientoInscripcion, 'mesCorto')}}</td>

                          @if($esUsuarioEspecial)
                            <td><input type="number" name="custom_importe_90" step="0.01" value="{{old('custom_importe_90')}}" {{$hide_especiales90}}></td>
                            <td><input type="date" name="custom_fechaVencimiento_90" value="{{old('custom_fechaVencimiento_90')}}" {{$hide_especiales90}}></td>
                            <td>
                              <div id="aplicar_custom90" {{$hide_especiales90}}>
                                <input type="checkbox" id="checkbox_90" name="checkbox_90">
                                <label for="checkbox_90">Aplicar</label>
                              </div>
                            </td>
                          @endif

                          <td>
                            @if($pago90)
                              <a class="{{$clases_btn}}" disabled>PAGADO: {{ mostrarFechaPago($pagos, '90') }}</a>
                            @else
                              <a data-concepto="90" data-banco="BBVA" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>BBVA</a>
                              <a data-concepto="90" data-banco="HSBC" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>HSBC</a>
                            @endif
                          </td>
                        @endif
                      </tr>
                      <tr>
                        @if($programa->ecImportePago8 && $programa->ecVencimientoPago8)
                          @php
                            $pago98 = existePagoConcepto($pagos, '98');
                            $importe98 = $pago98 ? $pago98->pagImpPago : $programa->ecImportePago8;
                            $hide_especiales98 = $pago98 ? 'hidden' : '';
                          @endphp
                          <td>98</td>
                          <td>Inscripción 2</td>
                          <td>${{number_format($importe98, 2, '.', ',')}}</td>
                          <td>{{Utils::fecha_string($programa->ecVencimientoPago8, 'mesCorto')}}</td>
                          @if($esUsuarioEspecial)
                            <td><input type="number" name="custom_importe_98" step="0.01" value="{{old('custom_importe_98')}}" {{$hide_especiales98}}></td>
                            <td><input type="date" name="custom_fechaVencimiento_98" value="{{old('custom_fechaVencimiento_98')}}" {{$hide_especiales98}}></td>
                            <td>
                              <div id="aplicar_custom98" {{$hide_especiales98}}>
                                <input type="checkbox" id="checkbox_98" name="checkbox_98">
                                <label for="checkbox_98">Aplicar</label>
                              </div>
                            </td>
                          @endif
                          <td>
                            @if($pago98)
                              <a class="{{$clases_btn}}" disabled>PAGADO: {{ mostrarFechaPago($pagos, '98') }}</a>
                            @else
                              <a data-concepto="98" data-banco="BBVA" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>BBVA</a>
                              <a data-concepto="98" data-banco="HSBC" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>HSBC</a>
                            @endif
                          </td>
                        @endif
                      </tr>
                      <tr>
                        @if($programa->ecImportePago1 && $programa->ecVencimientoPago1)
                          @php
                            $pago91 = existePagoConcepto($pagos, '91');
                            $importe91 = $pago91 ? $pago91->pagImpPago : $programa->ecImportePago1;
                            $hide_especiales91 = $pago91 ? 'hidden' : '';
                          @endphp
                          <td>91</td>
                          <td>Colegiatura</td>
                          <td>${{number_format($importe91, 2, '.', ',')}}</td>
                          <td>{{Utils::fecha_string($programa->ecVencimientoPago1, 'mesCorto')}}</td>
                          @if($esUsuarioEspecial)
                            <td><input type="number" name="custom_importe_91" step="0.01" value="{{old('custom_importe_91')}}" {{$hide_especiales91}}></td>
                            <td><input type="date" name="custom_fechaVencimiento_91" value="{{old('custom_fechaVencimiento_91')}}" {{$hide_especiales91}}></td>
                            <td>
                              <div id="aplicar_custom91" {{$hide_especiales91}}>
                                <input type="checkbox" id="checkbox_91" name="checkbox_91">
                                <label for="checkbox_91">Aplicar</label>
                              </div>
                            </td>
                          @endif
                          <td>
                            @if($pago91)
                              <a class="{{$clases_btn}}" disabled>PAGADO: {{ mostrarFechaPago($pagos, '91') }}</a>
                            @else
                              <a data-concepto="91" data-banco="BBVA" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>BBVA</a>
                              <a data-concepto="91" data-banco="HSBC" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>HSBC</a>
                            @endif
                          </td>
                        @endif
                      </tr>
                      <tr>
                        @if($programa->ecImportePago2 && $programa->ecVencimientoPago2)
                          @php
                            $pago92 = existePagoConcepto($pagos, '92');
                            $importe92 = $pago92 ? $pago92->pagImpPago : $programa->ecImportePago2;
                            $hide_especiales92 = $pago92 ? 'hidden' : '';
                          @endphp
                          <td>92</td>
                          <td>Colegiatura</td>
                          <td>${{number_format($importe92, 2, '.', ',')}}</td>
                          <td>{{Utils::fecha_string($programa->ecVencimientoPago2, 'mesCorto')}}</td>
                          @if($esUsuarioEspecial)
                            <td><input type="number" name="custom_importe_92" step="0.01" value="{{old('custom_importe_92')}}" {{$hide_especiales92}}></td>
                            <td><input type="date" name="custom_fechaVencimiento_92" value="{{old('custom_fechaVencimiento_92')}}" {{$hide_especiales92}}></td>
                            <td>
                              <div id="aplicar_custom92" {{$hide_especiales92}}>
                                <input type="checkbox" id="checkbox_92" name="checkbox_92">
                                <label for="checkbox_92">Aplicar</label>
                              </div>
                            </td>
                          @endif
                          <td>
                            @if($pago92)
                              <a class="{{$clases_btn}}" disabled>PAGADO: {{ mostrarFechaPago($pagos, '92') }}</a>
                            @else
                              <a data-concepto="92" data-banco="BBVA" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>BBVA</a>
                              <a data-concepto="92" data-banco="HSBC" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>HSBC</a>
                            @endif
                          </td>
                        @endif
                      </tr>
                      <tr>
                        @if($programa->ecImportePago3 && $programa->ecVencimientoPago3)
                          @php
                            $pago93 = existePagoConcepto($pagos, '93');
                            $importe93 = $pago93 ? $pago93->pagImpPago : $programa->ecImportePago3;
                            $hide_especiales93 = $pago93 ? 'hidden' : '';
                          @endphp
                          <td>93</td>
                          <td>Colegiatura</td>
                          <td>${{number_format($importe93, 2, '.', ',')}}</td>
                          <td>{{Utils::fecha_string($programa->ecVencimientoPago3, 'mesCorto')}}</td>
                          @if($esUsuarioEspecial)
                            <td><input type="number" name="custom_importe_93" step="0.01" value="{{old('custom_importe_93')}}" {{$hide_especiales93}}></td>
                            <td><input type="date" name="custom_fechaVencimiento_93" value="{{old('custom_fechaVencimiento_93')}}" {{$hide_especiales93}}></td>
                            <td>
                              <div id="aplicar_custom93" {{$hide_especiales93}}>
                                <input type="checkbox" id="checkbox_93" name="checkbox_93">
                                <label for="checkbox_93">Aplicar</label>
                              </div>
                            </td>
                          @endif
                          <td>
                            @if($pago93)
                              <a class="{{$clases_btn}}" disabled>PAGADO: {{ mostrarFechaPago($pagos, '93') }}</a>
                            @else
                              <a data-concepto="93" data-banco="BBVA" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>BBVA</a>
                              <a data-concepto="93" data-banco="HSBC" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>HSBC</a>
                            @endif
                          </td>
                        @endif
                      </tr>
                      <tr>
                        @if($programa->ecImportePago4 && $programa->ecVencimientoPago4)
                          @php
                            $pago94 = existePagoConcepto($pagos, '94');
                            $importe94 = $pago94 ? $pago94->pagImpPago : $programa->ecImportePago4;
                            $hide_especiales94 = $pago94 ? 'hidden' : '';
                          @endphp
                          <td>94</td>
                          <td>Colegiatura</td>
                          <td>${{number_format($importe94, 2, '.', ',')}}</td>
                          <td>{{Utils::fecha_string($programa->ecVencimientoPago4, 'mesCorto')}}</td>
                          @if($esUsuarioEspecial)
                            <td><input type="number" name="custom_importe_94" step="0.01" value="{{old('custom_importe_94')}}" {{$hide_especiales94}}></td>
                            <td><input type="date" name="custom_fechaVencimiento_94" value="{{old('custom_fechaVencimiento_94')}}" {{$hide_especiales94}}></td>
                            <td>
                              <div id="aplicar_custom94" {{$hide_especiales94}}>
                                <input type="checkbox" id="checkbox_94" name="checkbox_94">
                                <label for="checkbox_94">Aplicar</label>
                              </div>
                            </td>
                          @endif
                          <td>
                            @if($pago94)
                              <a class="{{$clases_btn}}" disabled>PAGADO: {{ mostrarFechaPago($pagos, '94') }}</a>
                            @else
                              <a data-concepto="94" data-banco="BBVA" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>BBVA</a>
                              <a data-concepto="94" data-banco="HSBC" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>HSBC</a>
                            @endif
                          </td>
                        @endif
                      </tr>
                      <tr>
                        @if($programa->ecImportePago5 && $programa->ecVencimientoPago5)
                          @php
                            $pago95 = existePagoConcepto($pagos, '95');
                            $importe95 = $pago95 ? $pago95->pagImpPago : $programa->ecImportePago5;
                            $hide_especiales95 = $pago95 ? 'hidden' : '';
                          @endphp
                          <td>95</td>
                          <td>Colegiatura</td>
                          <td>${{number_format($importe95, 2, '.', ',')}}</td>
                          <td>{{Utils::fecha_string($programa->ecVencimientoPago5, 'mesCorto')}}</td>
                          @if($esUsuarioEspecial)
                            <td><input type="number" name="custom_importe_95" step="0.01" value="{{old('custom_importe_95')}}" {{$hide_especiales95}}></td>
                            <td><input type="date" name="custom_fechaVencimiento_95" value="{{old('custom_fechaVencimiento_95')}}" {{$hide_especiales95}}></td>
                            <td>
                              <div id="aplicar_custom95" {{$hide_especiales95}}>
                                <input type="checkbox" id="checkbox_95" name="checkbox_95">
                                <label for="checkbox_95">Aplicar</label>
                              </div>
                            </td>
                          @endif
                          <td>
                            @if($pago95)
                              <a class="{{$clases_btn}}" disabled>PAGADO: {{ mostrarFechaPago($pagos, '95') }}</a>
                            @else
                              <a data-concepto="95" data-banco="BBVA" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>BBVA</a>
                              <a data-concepto="95" data-banco="HSBC" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>HSBC</a>
                            @endif
                          </td>
                        @endif
                      </tr>

                      <tr>
                        @if($programa->ecImportePago6 && $programa->ecVencimientoPago6)
                          @php
                            $pago96 = existePagoConcepto($pagos, '96');
                            $importe96 = $pago96 ? $pago96->pagImpPago : $programa->ecImportePago6;
                            $hide_especiales96 = $pago96 ? 'hidden' : '';
                          @endphp
                          <td>96</td>
                          <td>Colegiatura</td>
                          <td>${{number_format($importe96, 2, '.', ',')}}</td>
                          <td>{{Utils::fecha_string($programa->ecVencimientoPago6, 'mesCorto')}}</td>
                          @if($esUsuarioEspecial)
                            <td><input type="number" name="custom_importe_96" step="0.01" value="{{old('custom_importe_96')}}" {{$hide_especiales96}}></td>
                            <td><input type="date" name="custom_fechaVencimiento_96" value="{{old('custom_fechaVencimiento_96')}}" {{$hide_especiales96}}></td>
                            <td>
                              <div id="aplicar_custom96" {{$hide_especiales96}}>
                                <input type="checkbox" id="checkbox_96" name="checkbox_96">
                                <label for="checkbox_96">Aplicar</label>
                              </div>
                            </td>
                          @endif
                          <td>
                            @if($pago96)
                              <a class="{{$clases_btn}}" disabled>PAGADO: {{ mostrarFechaPago($pagos, '96') }}</a>
                            @else
                              <a data-concepto="96" data-banco="BBVA" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>BBVA</a>
                              <a data-concepto="96" data-banco="HSBC" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>HSBC</a>
                            @endif
                          </td>
                        @endif
                      </tr>
                      <tr>
                        @if($programa->ecImportePago7 && $programa->ecVencimientoPago7)
                          @php
                            $pago97 = existePagoConcepto($pagos, '97');
                            $importe97 = $pago97 ? $pago97->pagImpPago : $programa->ecImportePago7;
                            $hide_especiales97 = $pago97 ? 'hidden' : '';
                          @endphp
                          <td>95</td>
                          <td>Colegiatura</td>
                          <td>${{number_format($importe97, 2, '.', ',')}}</td>
                          <td>{{Utils::fecha_string($programa->ecVencimientoPago7, 'mesCorto')}}</td>
                          @if($esUsuarioEspecial)
                            <td><input type="number" name="custom_importe_97" step="0.01" value="{{old('custom_importe_97')}}" {{$hide_especiales97}}></td>
                            <td><input type="date" name="custom_fechaVencimiento_97" value="{{old('custom_fechaVencimiento_97')}}" {{$hide_especiales97}}></td>
                            <td>
                              <div id="aplicar_custom97" {{$hide_especiales97}}>
                                <input type="checkbox" id="checkbox_97" name="checkbox_97">
                                <label for="checkbox_97">Aplicar</label>
                              </div>
                            </td>
                          @endif
                          <td>
                            @if($pago97)
                              <a class="{{$clases_btn}}" disabled>PAGADO: {{ mostrarFechaPago($pagos, '97') }}</a>
                            @else
                              <a data-concepto="97" data-banco="BBVA" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>BBVA</a>
                              <a data-concepto="97" data-banco="HSBC" class="{{$clases_btn}}"><i class="material-icons left">picture_as_pdf</i>HSBC</a>
                            @endif
                          </td>
                        @endif
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>


            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

<script type="text/javascript">
  $(document).ready(function() {
    let inscrito_id = {!! json_encode($inscrito->id) !!};
    let form_ficha = $('#form_ficha_pago');

    $('.btn-ficha-pago').on('click', function() {
      let concepto = $(this).data('concepto');
      let banco = $(this).data('banco');
      let url_ficha_pago = `${base_url}/inscritosEduContinua/${inscrito_id}/ficha_pago/${concepto}/${banco}`;

      form_ficha.attr('action', url_ficha_pago).submit();
    });

  });
</script>

@endsection