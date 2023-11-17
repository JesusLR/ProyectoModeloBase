<div class="row">
  <div class="columns medium-4">
    <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">SEPTIEMBRE</p>
      @if ($septiembre->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($septiembre->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$septiembre->fechaMensualidadPagadaFormato}}</p>
      @endif
      @if (!$septiembre->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($septiembre->espagoAtraso1 || $septiembre->espagoAtraso2)
            @if ($septiembre->espagoAtraso1)
              <p style="font-size: 14px;">Vence  {{$septiembre->fechaAtrasoPago1Meses}} ${{$septiembre->cuotaAtrasoPorMeses1}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$septiembre->referenciaAtrasoMes1}}</span></p>
            @endif
            @if ($septiembre->espagoAtraso2)
              <p style="font-size: 14px;">Vence  {{$septiembre->fechaAtrasoPago2Meses}} ${{$septiembre->cuotaAtrasoPorMeses2}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$septiembre->referenciaAtrasoMes2}}</span></p>
            @endif
          @else
            @if (!$septiembre->esFechaProntoPagoVencida)
              <p style="font-size: 14px;">Vence  {{$septiembre->fechaProntoPago}} ${{$septiembre->cuotaProntoPago}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$septiembre->referenciaProntoPago}}</span></p>
            @endif
            @if (!$septiembre->esFechaNormalPagoVencida)
              <p style="font-size: 14px;">Vence  {{$septiembre->fechaNormalPagoCorto}} ${{$septiembre->cuotaNormal}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$septiembre->referenciaNormal}}</span></p>
            @endif
              
            <p style="font-size: 14px;">Vence  {{$septiembre->fechaAtrasoPagoCorto}} ${{$septiembre->cuotaAtraso}}</p>
            <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$septiembre->referenciaAtraso}}</span></p>
          @endif
        @endif
      @endif
    </div>
  </div>

  <div class="columns medium-4">
    <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">OCTUBRE</p>
      @if ($octubre->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($octubre->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$octubre->fechaMensualidadPagadaFormato}}</p>
      @endif
      @if (!$octubre->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($octubre->espagoAtraso1 || $octubre->espagoAtraso2)
            @if ($octubre->espagoAtraso1)
              <p style="font-size: 14px;">Vence  {{$octubre->fechaAtrasoPago1Meses}} ${{$octubre->cuotaAtrasoPorMeses1}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$octubre->referenciaAtrasoMes1}}</span></p>
            @endif
            @if ($octubre->espagoAtraso2)
              <p style="font-size: 14px;">Vence  {{$octubre->fechaAtrasoPago2Meses}} ${{$octubre->cuotaAtrasoPorMeses2}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$octubre->referenciaAtrasoMes2}}</span></p>
            @endif
          @else
            @if (!$octubre->esFechaProntoPagoVencida)
              <p style="font-size: 14px;">Vence  {{$octubre->fechaProntoPago}} ${{$octubre->cuotaProntoPago}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$octubre->referenciaProntoPago}}</span></p>
            @endif
            @if (!$octubre->esFechaNormalPagoVencida)
              <p style="font-size: 14px;">Vence  {{$octubre->fechaNormalPagoCorto}} ${{$octubre->cuotaNormal}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$octubre->referenciaNormal}}</span></p>
            @endif

            <p style="font-size: 14px;">Vence  {{$octubre->fechaAtrasoPagoCorto}} ${{$octubre->cuotaAtraso}}</p>
            <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$octubre->referenciaAtraso}}</span></p>
          @endif
        @endif
      @endif
    </div>
  </div>

  <div class="columns medium-4">
    <div style="height:  145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">NOVIEMBRE</p>
      @if ($noviembre->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($noviembre->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$noviembre->fechaMensualidadPagadaFormato}}</p>
      @endif

      @if (!$noviembre->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($noviembre->espagoAtraso1 || $noviembre->espagoAtraso2)
            @if ($noviembre->espagoAtraso1)
              <p style="font-size: 14px;">Vence  {{$noviembre->fechaAtrasoPago1Meses}} ${{$noviembre->cuotaAtrasoPorMeses1}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$noviembre->referenciaAtrasoMes1}}</span></p>
            @endif
            @if ($noviembre->espagoAtraso2)
              <p style="font-size: 14px;">Vence  {{$noviembre->fechaAtrasoPago2Meses}} ${{$noviembre->cuotaAtrasoPorMeses2}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$noviembre->referenciaAtrasoMes2}}</span></p>
            @endif
          @else
            @if (!$noviembre->esFechaProntoPagoVencida)
              <p style="font-size: 14px;">Vence  {{$noviembre->fechaProntoPago}} ${{$noviembre->cuotaProntoPago}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$noviembre->referenciaProntoPago}}</span></p>
            @endif
            @if (!$noviembre->esFechaNormalPagoVencida)
              <p style="font-size: 14px;">Vence  {{$noviembre->fechaNormalPagoCorto}} ${{$noviembre->cuotaNormal}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$noviembre->referenciaNormal}}</span></p>
            @endif
            
            <p style="font-size: 14px;">Vence  {{$noviembre->fechaAtrasoPagoCorto}} ${{$noviembre->cuotaAtraso}}</p>
            <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$noviembre->referenciaAtraso}}</span></p>
          @endif
        @endif
      @endif
    </div>
  </div>
</div>

<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
  <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
</div>

<div class="row">
  <div class="columns medium-4">
    <div style="height:  145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">DICIEMBRE</p>
      @if ($diciembre->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($diciembre->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$diciembre->fechaMensualidadPagadaFormato}}</p>
      @endif

      @if (!$diciembre->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($diciembre->espagoAtraso1 || $diciembre->espagoAtraso2)
            @if ($diciembre->espagoAtraso1)
              <p style="font-size: 14px;">Vence  {{$diciembre->fechaAtrasoPago1Meses}} ${{$diciembre->cuotaAtrasoPorMeses1}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$diciembre->referenciaAtrasoMes1}}</span></p>
            @endif
            @if ($diciembre->espagoAtraso2)
              <p style="font-size: 14px;">Vence  {{$diciembre->fechaAtrasoPago2Meses}} ${{$diciembre->cuotaAtrasoPorMeses2}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$diciembre->referenciaAtrasoMes2}}</span></p>
            @endif
          @else
            @if (!$diciembre->esFechaProntoPagoVencida)
              <p style="font-size: 14px;">Vence  {{$diciembre->fechaProntoPago}} ${{$diciembre->cuotaProntoPago}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$diciembre->referenciaProntoPago}}</span></p>
            @endif
            @if (!$diciembre->esFechaNormalPagoVencida)
              <p style="font-size: 14px;">Vence  {{$diciembre->fechaNormalPagoCorto}} ${{$diciembre->cuotaNormal}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$diciembre->referenciaNormal}}</span></p>
            @endif
            
            <p style="font-size: 14px;">Vence  {{$diciembre->fechaAtrasoPagoCorto}} ${{$diciembre->cuotaAtraso}}</p>
            <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$diciembre->referenciaAtraso}}</span></p>
          @endif
        @endif
      @endif
    </div>
  </div>

  <div class="columns medium-4">
    <div style="height:  145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">ENERO</p>
      @if ($enero->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($enero->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$enero->fechaMensualidadPagadaFormato}}</p>
      @endif
      @if (!$enero->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($enero->espagoAtraso1 || $enero->espagoAtraso2)
            @if ($enero->espagoAtraso1)
              <p style="font-size: 14px;">Vence  {{$enero->fechaAtrasoPago1Meses}} ${{$enero->cuotaAtrasoPorMeses1}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$enero->referenciaAtrasoMes1}}</span></p>
            @endif
            @if ($enero->espagoAtraso2)
              <p style="font-size: 14px;">Vence  {{$enero->fechaAtrasoPago2Meses}} ${{$enero->cuotaAtrasoPorMeses2}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$enero->referenciaAtrasoMes2}}</span></p>
            @endif
          @else
            @if (!$enero->esFechaProntoPagoVencida)
              <p style="font-size: 14px;">Vence  {{$enero->fechaProntoPago}} ${{$enero->cuotaProntoPago}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$enero->referenciaProntoPago}}</span></p>
            @endif
            @if (!$enero->esFechaNormalPagoVencida)
              <p style="font-size: 14px;">Vence  {{$enero->fechaNormalPagoCorto}} ${{$enero->cuotaNormal}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$enero->referenciaNormal}}</span></p>
            @endif
            
            <p style="font-size: 14px;">Vence  {{$enero->fechaAtrasoPagoCorto}} ${{$enero->cuotaAtraso}}</p>
            <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$enero->referenciaAtraso}}</span></p>
          @endif
        @endif
      @endif
    </div>
  </div>

  <div class="columns medium-4">
    <div style="height:  145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">FEBRERO</p>
      @if ($febrero->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($febrero->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$febrero->fechaMensualidadPagadaFormato}}</p>
      @endif
      @if (!$febrero->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($febrero->espagoAtraso1 || $febrero->espagoAtraso2)
            @if ($febrero->espagoAtraso1)
              <p style="font-size: 14px;">Vence  {{$febrero->fechaAtrasoPago1Meses}} ${{$febrero->cuotaAtrasoPorMeses1}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$febrero->referenciaAtrasoMes1}}</span></p>
            @endif
            @if ($febrero->espagoAtraso2)
              <p style="font-size: 14px;">Vence  {{$febrero->fechaAtrasoPago2Meses}} ${{$febrero->cuotaAtrasoPorMeses2}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$febrero->referenciaAtrasoMes2}}</span></p>
            @endif
          @else
            @if (!$febrero->esFechaProntoPagoVencida)
              <p style="font-size: 14px;">Vence  {{$febrero->fechaProntoPago}} ${{$febrero->cuotaProntoPago}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$febrero->referenciaProntoPago}}</span></p>
            @endif
            @if (!$febrero->esFechaNormalPagoVencida && $febrero->curTipoBeca != "S")
              <p style="font-size: 14px;">Vence  {{$febrero->fechaNormalPagoCorto}} ${{$febrero->cuotaNormal}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$febrero->referenciaNormal}}</span></p>
            @endif
              
            <p style="font-size: 14px;">Vence  {{$febrero->fechaAtrasoPagoCorto}} ${{$febrero->cuotaAtraso}}</p>
            <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$febrero->referenciaAtraso}}</span></p>
          @endif
        @endif
      @endif
    </div>
  </div>
</div>


<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
  <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
</div>

<div class="row">
  <div class="columns medium-4">
    <div style="height:  145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">MARZO</p>
      @if ($marzo->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($marzo->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$marzo->fechaMensualidadPagadaFormato}}</p>
      @endif
      @if (!$marzo->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($noAplicoPago)
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
          @endif

          @if (!$noAplicoPago)
            @if ($marzo->espagoAtraso1 || $marzo->espagoAtraso2)
              @if ($marzo->espagoAtraso1)
                <p style="font-size: 14px;">Vence  {{$marzo->fechaAtrasoPago1Meses}} ${{$marzo->cuotaAtrasoPorMeses1}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$marzo->referenciaAtrasoMes1}}</span></p>
              @endif
              @if ($marzo->espagoAtraso2)
                <p style="font-size: 14px;">Vence  {{$marzo->fechaAtrasoPago2Meses}} ${{$marzo->cuotaAtrasoPorMeses2}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$marzo->referenciaAtrasoMes2}}</span></p>
              @endif
            @else
              @if (!$marzo->esFechaProntoPagoVencida)
                <p style="font-size: 14px;">Vence  {{$marzo->fechaProntoPago}} ${{$marzo->cuotaProntoPago}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$marzo->referenciaProntoPago}}</span></p>
              @endif
              @if (!$marzo->esFechaNormalPagoVencida)
                <p style="font-size: 14px;">Vence  {{$marzo->fechaNormalPagoCorto}} ${{$marzo->cuotaNormal}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$marzo->referenciaNormal}}</span></p>
              @endif

              <p style="font-size: 14px;">Vence  {{$marzo->fechaAtrasoPagoCorto}} ${{$marzo->cuotaAtraso}}</p>
              <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$marzo->referenciaAtraso}}</span></p>
            @endif
          @endif
        @endif
      @endif
    </div>
  </div>

  <div class="columns medium-4">
    <div style="height:  145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">ABRIL</p>
      @if ($abril->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($abril->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$abril->fechaMensualidadPagadaFormato}}</p>
      @endif
      @if (!$abril->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($noAplicoPago)
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
          @endif
          @if (!$noAplicoPago)
            @if ($abril->espagoAtraso1 || $abril->espagoAtraso2)
              @if ($abril->espagoAtraso1)
                <p style="font-size: 14px;">Vence  {{$abril->fechaAtrasoPago1Meses}} ${{$abril->cuotaAtrasoPorMeses1}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$abril->referenciaAtrasoMes1}}</span></p>
              @endif
              @if ($abril->espagoAtraso2)
                <p style="font-size: 14px;">Vence  {{$abril->fechaAtrasoPago2Meses}} ${{$abril->cuotaAtrasoPorMeses2}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$abril->referenciaAtrasoMes2}}</span></p>
              @endif
            @else
              @if (!$abril->esFechaProntoPagoVencida)
                <p style="font-size: 14px;">Vence  {{$abril->fechaProntoPago}} ${{$abril->cuotaProntoPago}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$abril->referenciaProntoPago}}</span></p>
              @endif
              @if (!$abril->esFechaNormalPagoVencida)
                <p style="font-size: 14px;">Vence  {{$abril->fechaNormalPagoCorto}} ${{$abril->cuotaNormal}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$abril->referenciaNormal}}</span></p>
              @endif
              
              <p style="font-size: 14px;">Vence  {{$abril->fechaAtrasoPagoCorto}} ${{$abril->cuotaAtraso}}</p>
              <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$abril->referenciaAtraso}}</span></p>
            @endif
          @endif
        @endif
      @endif
    </div>
  </div>

  <div class="columns medium-4">
    <div style="height:  145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">MAYO</p>
      @if ($mayo->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($mayo->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$mayo->fechaMensualidadPagadaFormato}}</p>
      @endif
      @if (!$mayo->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($noAplicoPago)
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
          @endif

          @if (!$noAplicoPago)
            @if ($mayo->espagoAtraso1 || $mayo->espagoAtraso2)
              @if ($mayo->espagoAtraso1)
                <p style="font-size: 14px;">Vence  {{$mayo->fechaAtrasoPago1Meses}} ${{$mayo->cuotaAtrasoPorMeses1}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$mayo->referenciaAtrasoMes1}}</span></p>
              @endif
              @if ($mayo->espagoAtraso2)
                <p style="font-size: 14px;">Vence  {{$mayo->fechaAtrasoPago2Meses}} ${{$mayo->cuotaAtrasoPorMeses2}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$mayo->referenciaAtrasoMes2}}</span></p>
              @endif
            @else
              @if (!$mayo->esFechaProntoPagoVencida)
                <p style="font-size: 14px;">Vence  {{$mayo->fechaProntoPago}} ${{$mayo->cuotaProntoPago}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$mayo->referenciaProntoPago}}</span></p>
              @endif
              @if (!$mayo->esFechaNormalPagoVencida)
                <p style="font-size: 14px;">Vence  {{$mayo->fechaNormalPagoCorto}} ${{$mayo->cuotaNormal}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$mayo->referenciaNormal}}</span></p>
              @endif
              
              <p style="font-size: 14px;">Vence  {{$mayo->fechaAtrasoPagoCorto}} ${{$mayo->cuotaAtraso}}</p>
              <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$mayo->referenciaAtraso}}</span></p>
            @endif
          @endif
        @endif
      @endif
    </div>
  </div>
</div>

<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
  <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
</div>

<div class="row">
  <div class="columns medium-4">
    <div style="height:  145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">JUNIO</p>
      @if ($junio->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($junio->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$junio->fechaMensualidadPagadaFormato}}</p>
      @endif
      @if (!$junio->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($noAplicoPago)
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
          @endif

          @if (!$noAplicoPago)
            @if ($junio->espagoAtraso1 || $junio->espagoAtraso2)
              @if ($junio->espagoAtraso1)
                <p style="font-size: 14px;">Vence  {{$junio->fechaAtrasoPago1Meses}} ${{$junio->cuotaAtrasoPorMeses1}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$junio->referenciaAtrasoMes1}}</span></p>
              @endif
              @if ($junio->espagoAtraso2)
                <p style="font-size: 14px;">Vence  {{$junio->fechaAtrasoPago2Meses}} ${{$junio->cuotaAtrasoPorMeses2}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$junio->referenciaAtrasoMes2}}</span></p>
              @endif
            @else
              @if (!$junio->esFechaProntoPagoVencida)
                <p style="font-size: 14px;">Vence  {{$junio->fechaProntoPago}} ${{$junio->cuotaProntoPago}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$junio->referenciaProntoPago}}</span></p>
              @endif
              @if (!$junio->esFechaNormalPagoVencida)
                <p style="font-size: 14px;">Vence  {{$junio->fechaNormalPagoCorto}} ${{$junio->cuotaNormal}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$junio->referenciaNormal}}</span></p>
              @endif
              
              <p style="font-size: 14px;">Vence  {{$junio->fechaAtrasoPagoCorto}} ${{$junio->cuotaAtraso}}</p>
              <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$junio->referenciaAtraso}}</span></p>
            @endif
          @endif
        @endif
      @endif
    </div>
  </div>

  <div class="columns medium-4">
    <div style="height:  145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">JULIO</p>
      @if ($julio->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($julio->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$julio->fechaMensualidadPagadaFormato}}</p>
      @endif
      @if (!$julio->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($noAplicoPago)
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
          @endif
          @if (!$noAplicoPago)
            @if ($julio->espagoAtraso1 || $julio->espagoAtraso2)
              @if ($julio->espagoAtraso1)
                <p style="font-size: 14px;">Vence  {{$julio->fechaAtrasoPago1Meses}} ${{$julio->cuotaAtrasoPorMeses1}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$julio->referenciaAtrasoMes1}}</span></p>
              @endif
              @if ($julio->espagoAtraso2)
                <p style="font-size: 14px;">Vence  {{$julio->fechaAtrasoPago2Meses}} ${{$julio->cuotaAtrasoPorMeses2}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$julio->referenciaAtrasoMes2}}</span></p>
              @endif
            @else
              @if (!$julio->esFechaProntoPagoVencida)
                <p style="font-size: 14px;">Vence  {{$julio->fechaProntoPago}} ${{$julio->cuotaProntoPago}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$julio->referenciaProntoPago}}</span></p>
              @endif
              @if (!$julio->esFechaNormalPagoVencida)
                <p style="font-size: 14px;">Vence  {{$julio->fechaNormalPagoCorto}} ${{$julio->cuotaNormal}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$julio->referenciaNormal}}</span></p>
              @endif
              <p style="font-size: 14px;">Vence  {{$julio->fechaAtrasoPagoCorto}} ${{$julio->cuotaAtraso}}</p>
              <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$julio->referenciaAtraso}}</span></p>
            @endif
          @endif
        @endif
      @endif
    </div>
  </div>

  <div class="columns medium-4">
    <div style="height:  145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">AGOSTO</p>
      @if ($agosto->esMensualidadPagada)
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($agosto->mensualidadPagada->pagImpPago, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$agosto->fechaMensualidadPagadaFormato}}</p>
      @endif

      @if (!$agosto->esMensualidadPagada)
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
          @if ($noAplicoPago)
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
          @endif

          @if (!$noAplicoPago)
            @if ($agosto->espagoAtraso1 || $agosto->espagoAtraso2)
              @if ($agosto->espagoAtraso1)
                <p style="font-size: 14px;">Vence  {{$agosto->fechaAtrasoPago1Meses}} ${{$agosto->cuotaAtrasoPorMeses1}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$agosto->referenciaAtrasoMes1}}</span></p>
              @endif

              @if ($agosto->espagoAtraso2)
                <p style="font-size: 14px;">Vence  {{$agosto->fechaAtrasoPago2Meses}} ${{$agosto->cuotaAtrasoPorMeses2}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$agosto->referenciaAtrasoMes2}}</span></p>
              @endif
            @else
              @if (!$agosto->esFechaProntoPagoVencida)
                <p style="font-size: 14px;">Vence  {{$agosto->fechaProntoPago}} ${{$agosto->cuotaProntoPago}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$agosto->referenciaProntoPago}}</span></p>
              @endif
              @if (!$agosto->esFechaNormalPagoVencida)
                <p style="font-size: 14px;">Vence  {{$agosto->fechaNormalPagoCorto}} ${{$agosto->cuotaNormal}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$agosto->referenciaNormal}}</span></p>
              @endif

              <p style="font-size: 14px;">Vence  {{$agosto->fechaAtrasoPagoCorto}} ${{$agosto->cuotaAtraso}}</p>
              <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$agosto->referenciaAtraso}}</span></p>
            @endif
          @endif
        @endif
      @endif
    </div>
  </div>
</div>
<div class="row">
  <div class="columns medium-4"></div>
  <div class="columns medium-4"></div>
  <div class="columns medium-4">
    <div style="width: 75%; position: relative; padding-left: 10px; padding-right: 10px;">
      <p style="font-weight: 700; margin-left: 5px; font-size: 14px;">CONVENIO: {{sprintf('%07d', $convenio)}}</p>
    </div>
  </div>
</div>

<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
  <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
</div>



<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
  <div class="columns medium-12">
  <p style="text-align: center; font-weight: 700;">CURSO ESCOLAR {{$curso->periodo->perAnioPago}} - {{$curso->periodo->perAnioPago + 1}}</p>
  </div>
</div>

<div class="row" style="margin-top: 8px; margin-bottom: 8px; margin-left: 0px; margin-right: 0px;">
  <div class="columns medium-6">
    <p><span style="font-weight: 700;">Carrera:</span> {{$curso->cgt->plan->programa->progNombre}}</p>
    <p><span style="font-weight: 700;" for="">Alumno:</span>
      {{$curso->alumno->aluClave}} {{$curso->alumno->persona->perApellido1}} {{$curso->alumno->persona->perApellido2}} {{$curso->alumno->persona->perNombre}}
    </p>
    <p>
      <span style="font-weight: 700;" for="">Grado:</span> {{$curso->cgt->cgtGradoSemestre}}° {{$curso->cgt->cgtGrupo}}
      <span style="font-weight: 700;" for="">Ubic.</span>
      {{$curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave}}
      {{$curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiNombre}}
    </p>
  </div>
  <div class="columns medium-6">
    <div style="float:right;">
      <p>
        Plan de 12 pagos.
        @if ($curso->curAnioCuotas)
          Gen: {{$curso->curAnioCuotas}}
        @endif
      </p>
      <p>
        {{$fechaActualFormatoTarjeta}} {{$horaActual}} v19
        @if ($curso->curTipoBeca && $curso->curPorcentajeBeca)
          <span style="font-weight: 700;">{{$curso->curTipoBeca}}{{$curso->curPorcentajeBeca}}</span>
        @endif
      </p>
    </div>
  </div>
</div>




