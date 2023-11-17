@extends('layouts.dashboard')

@section('template_title')
    Cuota Descuento
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url("pagos/registro_cuotas/{$cuota->id}/cuota_descuento")}}" class="breadcrumb">Lista de descuentos</a>
    <label class="breadcrumb">Agregar cuota descuento</label>
@endsection

@section('content')

@php
  use App\Http\Helpers\Utils;
@endphp

<div class="row">
    <div class="col s12 ">
      {!! Form::open(['onKeypress' => 'return disableEnterKey(event)','url' => url('/pagos/cuota_descuento'), 'method' => 'POST']) !!}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">AGREGAR CUOTA DESCUENTO</span>

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
                @if(isset($cuota))
                  @php
                    $clave_relacion = null;
                    $nombre_relacion = null;

                    switch ($cuota->cuoTipo) {
                      case 'D':
                        $clave_relacion = $departamento ? $departamento->depClave : null;
                        $nombre_relacion = $departamento ? $departamento->depNombre : null;
                        break;
                      case 'E':
                        $clave_relacion = $escuela ? $escuela->escClave : null;
                        $nombre_relacion = $escuela ? $escuela->escNombre : null;
                        break;
                      case 'P':
                        $clave_relacion = $programa ? $programa->progClave : null;
                        $nombre_relacion = $programa ? $programa->progNombre : null;
                        break;
                    }
                  @endphp
                  <div class="col s12 m6 l4">
                    <p><b>Ubicacion: </b> {{$ubicacion->ubiClave}} {{$ubicacion->ubiNombre}}</p>
                    <p><b>Cuota Año: </b> {{$cuota->cuoAnio}}</p>
                    <p><b>Tipo: </b> {{$cuota->cuoTipo}}</p>
                    <p><b>Pertenece a: </b> {{$clave_relacion}} - {{$nombre_relacion}}</p>
                  </div>
                  <div class="col s12 m6 l4">
                    <p><b>Importe Inscripción 1: </b> {{ $cuota->cuoImporteInscripcion1 }}</p>
                    <p><b>Fecha límite inscripción 1: </b> {{ Utils::fecha_string($cuota->cuoFechaLimiteInscripcion1, 'mesCorto') }}</p>
                    <hr>
                    <p><b>Importe Inscripción 2: </b> {{ $cuota->cuoImporteInscripcion2 }}</p>
                    <p><b>Fecha límite inscripción 2: </b> {{ Utils::fecha_string($cuota->cuoFechaLimiteInscripcion2, 'mesCorto') }}</p>
                    <hr>
                    <p><b>Importe Inscripción 3: </b> {{ $cuota->cuoImporteInscripcion3 }}</p>
                    <p><b>Fecha límite inscripción 3: </b> {{ Utils::fecha_string($cuota->cuoFechaLimiteInscripcion3, 'mesCorto') }}</p>
                    <hr>
                  </div>
                  <div class="col s12 m6 l4">
                    <p><b>Importe Padres de familia: </b> {{ $cuota->cuoImportePadresFamilia }}</p>
                    <p><b>Importe Ordinario UADY: </b> {{ $cuota->cuoImporteOrdinarioUady }}</p>
                    <p><b>Importe Mensualidad 10: </b> {{ $cuota->cuoImporteMensualidad10 }}</p>
                    <p><b>Importe Mensualidad 11: </b> {{ $cuota->cuoImporteMensualidad11 }}</p>
                    <p><b>Importe Mensualidad 12: </b> {{ $cuota->cuoImporteMensualidad12 }}</p>
                    <p><b>Importe Vencimiento: </b> {{ $cuota->cuoImporteVencimiento }}</p>
                    <p><b>Importe Pronto Pago: </b> {{ $cuota->cuoImporteProntoPago }}</p>
                    <p><b>Días Pronto Pago: </b> {{ $cuota->cuoDiasProntoPago }}</p>
                    <p><b>Número de cuenta: </b> {{ $cuota->cuoNumeroCuenta }}</p>
                  </div>
                  <input type="hidden" name="cuota_id" id="cuota_id" value="{{$cuota->id}}" required>
                @endif
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="">
                    <label for="cudFechaInicio">Fecha inicio *</label>
                    <input type="date" name="cudFechaInicio" id="cudFechaInicio" value="{{old('cudFechaInicio')}}" class="validate" required>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="">
                    <label for="cudFechaFinal">Fecha Final *</label>
                    <input type="date" name="cudFechaFinal" id="cudFechaFinal" value="{{old('cudFechaFinal')}}" class="validate" required>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <input type="number" name="cudGradoInicial" id="cudGradoInicial" value="{{old('cudGradoInicial')}}" class="validate" min="1" max="15" required>
                    <label for="cudGradoInicial">Grado inicial *</label>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    <input type="number" name="cudGradoFinal" id="cudGradoFinal" value="{{old('cudGradoFinal')}}" class="validate" min="1" max="15" required>
                    <label for="cudGradoFinal">Grado final *</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImportePadresFamilia', (old('cuoImportePadresFamilia') ?: (isset($cuota) ? $cuota->cuoImportePadresFamilia : null)), array('id' => 'cuoImportePadresFamilia', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImportePadresFamilia', 'Importe PadFam/Incorpo. UADY', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteOrdinarioUady', (old('cuoImporteOrdinarioUady') ?: (isset($cuota) ? $cuota->cuoImporteOrdinarioUady : null)), array('id' => 'cuoImporteOrdinarioUady', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteOrdinarioUady', 'Importe Exam. Ord. UADY', array('class' => '')); !!}
                  </div>
                </div>
              </div>


              
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteMensualidad10', (old('cuoImporteMensualidad10') ?: (isset($cuota) ? $cuota->cuoImporteMensualidad10 : null)), array('id' => 'cuoImporteMensualidad10', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteMensualidad10', 'Importe Mensualidad 10 Meses', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteMensualidad11', (old('cuoImporteMensualidad11') ?: (isset($cuota) ? $cuota->cuoImporteMensualidad11 : null)), array('id' => 'cuoImporteMensualidad11', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteMensualidad11', 'Importe Mensualidad 11 Meses', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteMensualidad12', (old('cuoImporteMensualidad12') ?: (isset($cuota) ? $cuota->cuoImporteMensualidad12 : null)), array('id' => 'cuoImporteMensualidad12', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteMensualidad12', 'Importe Mensualidad 12 Meses', array('class' => '')); !!}
                  </div>
                </div>
              </div>


                            
              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteVencimiento', (old('cuoImporteVencimiento') ?: (isset($cuota) ? $cuota->cuoImporteVencimiento : null)), array('id' => 'cuoImporteVencimiento', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteVencimiento', 'Importe Cargo Mes Vencido', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteProntoPago', (old('cuoImporteProntoPago') ?: (isset($cuota) ? $cuota->cuoImporteProntoPago : null)), array('id' => 'cuoImporteProntoPago', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteProntoPago', 'Importe Descto Pronto Pago', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoDiasProntoPago', (old('cuoDiasProntoPago') ?: (isset($cuota) ? $cuota->cuoDiasProntoPago : null)), array('id' => 'cuoDiasProntoPago', 'class' => 'validate')) !!}
                    {!! Form::label('cuoDiasProntoPago', 'Num. de Dias Pronto Pago', array('class' => '')); !!}
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoNumeroCuenta', (old('cuoNumeroCuenta') ?: (isset($cuota) ? $cuota->cuoNumeroCuenta : null)), array('id' => 'cuoNumeroCuenta', 'class' => 'validate')) !!}
                    {!! Form::label('cuoNumeroCuenta', 'Número de cuenta o convenio', array('class' => '')); !!}
                  </div>
                </div>

              </div>


              <div class="row">
                <div class="col s12 m12 l12">
                  <hr>
                  <h5>Inscripción</h5>
                  <p>Importes</p>
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteInscripcion1', (old('cuoImporteInscripcion1') ?: (isset($cuota) ? $cuota->cuoImporteInscripcion1 : null)), array('id' => 'cuoImporteInscripcion1', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteInscripcion1', 'Primer Plazo', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('cuoFechaLimiteInscripcion1', 'Fecha Límite', array('class' => '')); !!}
                  {!! Form::date('cuoFechaLimiteInscripcion1', (isset($cuota) ? $cuota->cuoFechaLimiteInscripcion1 : null), array('id' => 'cuoFechaLimiteInscripcion1', 'class' => 'validate')) !!}
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteInscripcion2', (old('cuoImporteInscripcion2') ?: (isset($cuota) ? $cuota->cuoImporteInscripcion2 : null)), array('id' => 'cuoImporteInscripcion2', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteInscripcion2', 'Segundo Plazo', array('class' => '')); !!}
                  </div>
                </div>

                <div class="col s12 m6 l4">
                  {!! Form::label('cuoFechaLimiteInscripcion2', 'Fecha Límite', array('class' => '')); !!}
                  {!! Form::date('cuoFechaLimiteInscripcion2', (isset($cuota) ? $cuota->cuoFechaLimiteInscripcion2 : null), array('id' => 'cuoFechaLimiteInscripcion2', 'class' => 'validate')) !!}
                </div>
              </div>

              <div class="row">
                <div class="col s12 m6 l4">
                  <div class="input-field">
                    {!! Form::number('cuoImporteInscripcion3', (old('cuoImporteInscripcion3') ?: (isset($cuota) ? $cuota->cuoImporteInscripcion3 : null)), array('id' => 'cuoImporteInscripcion3', 'class' => 'validate')) !!}
                    {!! Form::label('cuoImporteInscripcion3', 'Tercer Plazo', array('class' => '')); !!}
                  </div>
                </div>
                <div class="col s12 m6 l4">
                  {!! Form::label('cuoFechaLimiteInscripcion3', 'Fecha Límite', array('class' => '')); !!}
                  {!! Form::date('cuoFechaLimiteInscripcion3', (isset($cuota) ? $cuota->cuoFechaLimiteInscripcion3 : null), array('id' => 'cuoFechaLimiteInscripcion3', 'class' => 'validate')) !!}
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

  <script type="text/javascript" src={{asset('js/funcionesAuxiliares.js')}}></script>

@endsection

@section('footer_scripts')

<script type="text/javascript">
  $(document).ready(function() {
    //
  });
</script>

@endsection