<div class="row">
    {{-- septiembre, octubre, noviembre --}}
    @foreach (($pago->slice(0,3)) as $item)
    <div class="columns medium-4">
      <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
        <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">{{$item->titulo}}</p>
        @if ($item->estado == "PAGADO")
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{$item->estado}}</p>
          <p style="text-align:center;margin-bottom: 10px;">${{ number_format($item->importe1, 2, '.', ',')}}</p>
          <p style="text-align:center;margin-bottom: 10px;">{{$item->fecha1Formato}}</p>
        @endif
        @if ($item->estado == "NO APLICA")
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @endif
        @if ($item->estado == "DEBE")
          @if (!is_null($item->importe1))
            <p style="font-size: 14px;">Vence  {{$item->fecha1Formato}} ${{number_format($item->importe1, 2, '.', ',')}}</p>
            <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago1}}</span> </p>
          @endif
          @if (!is_null($item->importe2))
            <p style="font-size: 14px;">Vence  {{$item->fecha2Formato}} ${{number_format($item->importe2, 2, '.', ',')}}</p>
            <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago2}}</span> </p>
          @endif
          @if (!is_null($item->importe3))
            <p style="font-size: 14px;">Vence  {{$item->fecha3Formato}} ${{number_format($item->importe3, 2, '.', ',')}}</p>
            <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago3}}</span> </p>
          @endif
        @endif
      </div>
    </div>
    @endforeach
  </div>
</div>


<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
  {{--
  <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
  --}}
  <p style="text-align: center; font-weight: 700;">* * *  UTILIZAR SIEMPRE LA REFERENCIA CORRESPONDIENTE AL MES * * *</p>
</div>


<div class="row">
  {{-- diciembre, enero, febrero --}}
  @foreach (($pago->slice(3,3)) as $item)
  <div class="columns medium-4">
    <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">{{$item->titulo}}</p>
      @if ($item->estado == "PAGADO")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{$item->estado}}</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($item->importe1, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$item->fecha1Formato}}</p>
      @endif
      @if ($item->estado == "NO APLICA")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
      @endif
      @if ($item->estado == "DEBE")
          @if (!is_null($item->importe1))
            <p style="font-size: 14px;">Vence  {{$item->fecha1Formato}} ${{number_format($item->importe1, 2, '.', ',')}}</p>
            <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago1}}</span> </p>
          @endif
          @if (!is_null($item->importe2))
            <p style="font-size: 14px;">Vence  {{$item->fecha2Formato}} ${{number_format($item->importe2, 2, '.', ',')}}</p>
            <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago2}}</span></p>
          @endif
          @if (!is_null($item->importe3))
            <p style="font-size: 14px;">Vence  {{$item->fecha3Formato}} ${{number_format($item->importe3, 2, '.', ',')}}</p>
            <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago3}}</span> </p>
            @endif
      @endif
    </div>
  </div>
  @endforeach
</div>


<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
  {{--
  <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
  --}}
  <p style="text-align: center; font-weight: 700;">* * *  UTILIZAR SIEMPRE LA REFERENCIA CORRESPONDIENTE AL MES * * *</p>
</div>


<div class="row">
  {{-- marzo, abril, mayo --}}
  @foreach (($pago->slice(6,3)) as $item)
  <div class="columns medium-4">
    <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">{{$item->titulo}}</p>
      @if ($item->estado == "PAGADO")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{$item->estado}}</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($item->importe1, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$item->fecha1Formato}}</p>
      @endif
      @if ($item->estado == "NO APLICA")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
      @endif
      @if ($item->estado == "DEBE")
        @if (!is_null($item->importe1))
          <p style="font-size: 14px;">Vence  {{$item->fecha1Formato}} ${{number_format($item->importe1, 2, '.', ',')}}</p>
          <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago1}}</span> </p>
        @endif
        @if (!is_null($item->importe2))
          <p style="font-size: 14px;">Vence  {{$item->fecha2Formato}} ${{number_format($item->importe2, 2, '.', ',')}}</p>
          <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago2}}</span> </p>
        @endif
        @if (!is_null($item->importe3))
          <p style="font-size: 14px;">Vence  {{$item->fecha3Formato}} ${{number_format($item->importe3, 2, '.', ',')}}</p>
          <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago3}}</span> </p>
        @endif
      @endif
    </div>
  </div>
  @endforeach
</div>



<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
{{--
  <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
--}}
    <p style="text-align: center; font-weight: 700;">* * *  UTILIZAR SIEMPRE LA REFERENCIA CORRESPONDIENTE AL MES * * *</p>
</div>



<div class="row">
  {{-- junio julio --}}
  @foreach (($pago->slice(9,2)) as $item)
  <div class="columns medium-4">
    <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">{{$item->titulo}}</p>
      @if ($item->estado == "PAGADO")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{$item->estado}}</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($item->importe1, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$item->fecha1Formato}}</p>
      @endif
      @if ($item->estado == "NO APLICA")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
      @endif
      @if ($item->estado == "DEBE")
        @if (!is_null($item->importe1))
          <p style="font-size: 14px;">Vence  {{$item->fecha1Formato}} ${{number_format($item->importe1, 2, '.', ',')}}</p>
          <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago1}}</span> </p>
        @endif
        @if (!is_null($item->importe2))
          <p style="font-size: 14px;">Vence  {{$item->fecha2Formato}} ${{number_format($item->importe2, 2, '.', ',')}}</p>
          <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago2}}</span> </p>
        @endif
        @if (!is_null($item->importe3))
          <p style="font-size: 14px;">Vence  {{$item->fecha3Formato}} ${{number_format($item->importe3, 2, '.', ',')}}</p>
          <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$item->referenciaPago3}}</span> </p>
        @endif
      @endif
    </div>
  </div>
  @endforeach


  @php
    $convenio = $pago->where("celda", "=", 12)->first();
  @endphp

  <div class="columns medium-4">
    <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center;margin-bottom: 30px; font-weight: 700;">CONVENIO</p>
      <p style="text-align: center; font-weight: 700; font-size: 14px;">{{$convenio->convenio}}</p>
    </div>
  </div>
</div>


<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
{{--
  <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
--}}
    <p style="text-align: center; font-weight: 700;">* * *  UTILIZAR SIEMPRE LA REFERENCIA CORRESPONDIENTE AL MES * * *</p>
</div>


  @php
    $datosGenerales = $pago->first();
  @endphp

<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
  <div class="columns medium-12">
  <p style="text-align: center; font-weight: 700;">CURSO ESCOLAR {{$datosGenerales->anioCuota}} - {{$datosGenerales->anioCuota + 1}}</p>
  </div>
</div>

<div class="row" style="margin-top: 8px; margin-bottom: 8px; margin-left:0px; margin-right: 0px;">
  <div class="columns medium-6">
    <p><span style="font-weight: 700;">Carrera:</span> {{$datosGenerales->progNombre}}</p>
    <p><span style="font-weight: 700;" for="">Alumno:</span>
      {{$datosGenerales->clavePago}} {{$datosGenerales->nombre}}
    </p>
    <p>
      <span style="font-weight: 700;">Grado:</span> {{$datosGenerales->grado}}° {{$datosGenerales->grupo}}
      <span style="font-weight: 700; margin-left: 30px;">Ubic.</span>
      {{$datosGenerales->ubiClave}}
      {{$datosGenerales->ubiNombre}}
    </p>
  </div>
  <div class="columns medium-6">
    <div style="float:right;">
      <p>
        Plan de 11 pagos.
        @if (!is_null($datosGenerales->curAnioCuotas))
          Gen: {{$datosGenerales->curAnioCuotas}}
        @endif
      </p>
      <p>
        {{$fechaActualFormatoTarjeta}} {{$horaActual}} v19
        @if ($datosGenerales->tipoBeca && $datosGenerales->porcBeca)
          <span style="font-weight: 700;">{{$datosGenerales->tipoBeca}}{{$datosGenerales->porcBeca}}</span>
        @endif
      </p>
    </div>
  </div>
</div>

<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
    <p style="text-align: center; font-weight: 700;">* * *  PARA PAGO EXCLUSIVO EN CAJA O CAJERO EN BBVA  * * *</p>
    <p style="text-align: center; font-weight: 700;">PAGAR USANDO LA CLAVE DE CONVENIO {{$convenio->convenio}}</p>
    <p style="text-align: center; font-weight: 700;">NO EFECTUAR TRANSFERENCIAS EN BBVA YA QUE NO SE REGISTRAN</p>
</div>
