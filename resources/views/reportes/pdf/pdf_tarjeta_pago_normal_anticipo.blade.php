<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<!-- <link rel="stylesheet" href="sass/main.css" media="screen" charset="utf-8"/> -->
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<meta http-equiv="content-type" content="text-html; charset=utf-8">
		<style type="text/css">
      /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
      /* Document
        ========================================================================== */
      /**
      * 1. Correct the line height in all browsers.
      * 2. Prevent adjustments of font size after orientation changes in iOS.
      */
      html {
        line-height: 1.15; /* 1 */
        -webkit-text-size-adjust: 100%; /* 2 */
      }
      /* Sections
        ========================================================================== */
      /**
      * Remove the margin in all browsers.
      */
      body {
        margin: 0;
      }
      /**
      * Render the `main` element consistently in IE.
      */
      main {
        display: block;
      }
      /**
      * Correct the font size and margin on `h1` elements within `section` and
      * `article` contexts in Chrome, Firefox, and Safari.
      */
      h1 {
        font-size: 2em;
        margin: 0.67em 0;
      }
      /* Grouping content
        ========================================================================== */
      /**
      * 1. Add the correct box sizing in Firefox.
      * 2. Show the overflow in Edge and IE.
      */
      hr {
        box-sizing: content-box; /* 1 */
        height: 0; /* 1 */
        overflow: visible; /* 2 */
      }
      /**
      * 1. Correct the inheritance and scaling of font size in all browsers.
      * 2. Correct the odd `em` font sizing in all browsers.
      */
      pre {
        font-family: monospace, monospace; /* 1 */
        font-size: 1em; /* 2 */
      }
      /* Text-level semantics
        ========================================================================== */
      /**
      * Remove the gray background on active links in IE 10.
      */
      a {
        background-color: transparent;
      }
      /**
      * 1. Remove the bottom border in Chrome 57-
      * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
      */
      abbr[title] {
        border-bottom: none; /* 1 */
        text-decoration: underline; /* 2 */
        text-decoration: underline dotted; /* 2 */
      }
      /**
      * Add the correct font weight in Chrome, Edge, and Safari.
      */
      b,
      strong {
        font-weight: bolder;
      }
      /**
      * 1. Correct the inheritance and scaling of font size in all browsers.
      * 2. Correct the odd `em` font sizing in all browsers.
      */
      code,
      kbd,
      samp {
        font-family: monospace, monospace; /* 1 */
        font-size: 1em; /* 2 */
      }
      /**
      * Add the correct font size in all browsers.
      */
      small {
        font-size: 80%;
      }
      /**
      * Prevent `sub` and `sup` elements from affecting the line height in
      * all browsers.
      */
      sub,
      sup {
        font-size: 75%;
        line-height: 0;
        position: relative;
        vertical-align: baseline;
      }
      sub {
        bottom: -0.25em;
      }
      sup {
        top: -0.5em;
      }
      /* Embedded content
        ========================================================================== */
      /**
      * Remove the border on images inside links in IE 10.
      */
      img {
        border-style: none;
      }
      /* Forms
        ========================================================================== */
      /**
      * 1. Change the font styles in all browsers.
      * 2. Remove the margin in Firefox and Safari.
      */
      button,
      input,
      optgroup,
      select,
      textarea {
        font-family: inherit; /* 1 */
        font-size: 100%; /* 1 */
        line-height: 1.15; /* 1 */
        margin: 0; /* 2 */
      }
      /**
      * Show the overflow in IE.
      * 1. Show the overflow in Edge.
      */
      button,
      input { /* 1 */
        overflow: visible;
      }
      /**
      * Remove the inheritance of text transform in Edge, Firefox, and IE.
      * 1. Remove the inheritance of text transform in Firefox.
      */
      button,
      select { /* 1 */
        text-transform: none;
      }
      /**
      * Correct the inability to style clickable types in iOS and Safari.
      */
      button,
      [type="button"],
      [type="reset"],
      [type="submit"] {
        -webkit-appearance: button;
      }
      /**
      * Remove the inner border and padding in Firefox.
      */
      button::-moz-focus-inner,
      [type="button"]::-moz-focus-inner,
      [type="reset"]::-moz-focus-inner,
      [type="submit"]::-moz-focus-inner {
        border-style: none;
        padding: 0;
      }
      /**
      * Restore the focus styles unset by the previous rule.
      */
      button:-moz-focusring,
      [type="button"]:-moz-focusring,
      [type="reset"]:-moz-focusring,
      [type="submit"]:-moz-focusring {
        outline: 1px dotted ButtonText;
      }
      /**
      * Correct the padding in Firefox.
      */
      fieldset {
        padding: 0.35em 0.75em 0.625em;
      }
      /**
      * 1. Correct the text wrapping in Edge and IE.
      * 2. Correct the color inheritance from `fieldset` elements in IE.
      * 3. Remove the padding so developers are not caught out when they zero out
      *    `fieldset` elements in all browsers.
      */
      legend {
        box-sizing: border-box; /* 1 */
        color: inherit; /* 2 */
        display: table; /* 1 */
        max-width: 100%; /* 1 */
        padding: 0; /* 3 */
        white-space: normal; /* 1 */
      }
      /**
      * Add the correct vertical alignment in Chrome, Firefox, and Opera.
      */
      progress {
        vertical-align: baseline;
      }
      /**
      * Remove the default vertical scrollbar in IE 10+.
      */
      textarea {
        overflow: auto;
      }
      /**
      * 1. Add the correct box sizing in IE 10.
      * 2. Remove the padding in IE 10.
      */
      [type="checkbox"],
      [type="radio"] {
        box-sizing: border-box; /* 1 */
        padding: 0; /* 2 */
      }
      /**
      * Correct the cursor style of increment and decrement buttons in Chrome.
      */
      [type="number"]::-webkit-inner-spin-button,
      [type="number"]::-webkit-outer-spin-button {
        height: auto;
      }
      /**
      * 1. Correct the odd appearance in Chrome and Safari.
      * 2. Correct the outline style in Safari.
      */
      [type="search"] {
        -webkit-appearance: textfield; /* 1 */
        outline-offset: -2px; /* 2 */
      }
      /**
      * Remove the inner padding in Chrome and Safari on macOS.
      */
      [type="search"]::-webkit-search-decoration {
        -webkit-appearance: none;
      }
      /**
      * 1. Correct the inability to style clickable types in iOS and Safari.
      * 2. Change font properties to `inherit` in Safari.
      */
      ::-webkit-file-upload-button {
        -webkit-appearance: button; /* 1 */
        font: inherit; /* 2 */
      }
      /* Interactive
        ========================================================================== */
      /*
      * Add the correct display in Edge, IE 10+, and Firefox.
      */
      details {
        display: block;
      }
      /*
      * Add the correct display in all browsers.
      */
      summary {
        display: list-item;
      }
      /* Misc
        ========================================================================== */
      /**
      * Add the correct display in IE 10+.
      */
      template {
        display: none;
      }
      /**
      * Add the correct display in IE 10.
      */
      [hidden] {
        display: none;
      }
      body{
        font-family: 'times sans-serif';
        font-size: 12px;
        margin-top: 40px;
        margin-left: 0px;
        margin-right: 0px;
      }
      .row {
        width:100%;
        display: block;
        position: relative;
        margin-left: -30px;
        margin-right: -30px;
      }
      .row::after {
          content: "";
        clear: both;
        display: table;
      }
      .column,
      .columns {
        width: 100%;
        float: left;
        box-sizing: border-box!important;
      }
      .medium-1 {
        width: 8.33333333333%;
      }
      .medium-4 {
        width: 16.6666666667%;
      }
      .medium-3 {
        width: 25%;
      }
      .medium-4 {
        width: 33.3333333333%;
      }
      .medium-5 {
        width: 41.6666666667%;
      }
      .medium-6 {
        width: 50%;
      }
      .medium-7 {
        width: 58.3333333333%;
      }
      .medium-8 {
        width: 66.6666666667%;
      }
      .medium-9 {
        width: 75%;
      }
      .medium-10 {
        width: 83.3333333333%;
      }
      .medium-11 {
        width: 91.6666666667%;
      }
      .medium-12 {
        width: 100%;
      }
      .clearfix::after {
        content: "";
        clear: both;
        display: table;
      }
      span{
        font-weight: bold;
      }
      p{
        margin: 0;
      }
      .left {
        float: left;
      }
      .float-right: {
        float: right;
      }
      .logo {
        width: 100%;
      }
      .box-solicitud {
        border: 1px solid "black";
        padding: 5px;
        border-radius: 2px;
      }

      .estilos-tabla {
        width: 100%;
      }
      .estilos-tabla tr th{
        font-size: 12px;
        background-color: #000;
        color: #fff;
        height: 30px;
        padding-left:5px;
        padding-right:5px;
        box-sizing: border-box;
        text-align: center;
      }
      .estilos-tabla tr td{
        font-size: 12px;
        padding-left:2px;
        padding-right:2px;
        box-sizing: border-box;
        color: #000;
      }
      .page_break { page-break-before: always; }
      /** Define the footer rules **/
      footer {
        position: fixed;
        bottom: 0px;
        left: 0cm;
        right: 0cm;
        /** Extra personal styles **/
        color: #000;
        text-align: center;
      }
      header {
        left: 0px;
        position: fixed;
        top: -60px;
        right: 0px;
        height: 3px;
        /** Extra personal styles **/

        margin-left: 5px;
        margin-right: 5px;
      }

      #watermark { position: fixed; top: 15%; left: 0;  width: 700px; height: 700px; opacity: .3; }
      .img-header{
        height: 80px;
      }
      .inicio-pagina{
        margin-top: 0;
        display: block;
      }
      @page {
        margin-top: -20px;
        margin-bottom: 30px;
      }

      .listas-info {
        margin-top: 0px;
        margin-bottom: 0px;
      }
      .listas-info li {
        display: inline;
        list-style-type: none;
        margin-left: 40px;

      }
      .listas-info li:first-child {
        margin-left: 0px;
      }

      .listas-asistencia {
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 0px!important;
        padding-left: 0!important;
      }
      .listas-asistencia li {
        display: inline;
        list-style-type: none;
      }

      .table {
        width: 100%;
      }

      .table {
        border-collapse: collapse;
      }

      .table th {
        border-bottom: 1px solid #000;
      }

      .table td, .table  th {
        padding-top: 0px;
        padding-bottom: 0px;
        padding-right: 5px;
      }

      .page-number:before {
        content: "Pág " counter(page);
      }
    </style>
	</head>
  <body>
    <header>
    </header>

    <div class="row">
      <div class="columns medium-4">
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
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
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
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
                <p>Refer. <span style="font-weight:700; font-size: 14px;">{{$octubre->referenciaAtraso}}</span></p>
              @endif
            @endif
          @endif
        </div>
      </div>

      <div class="columns medium-4">
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
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
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
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
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
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
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
          <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">INSCRIPCION</p>


          @if ($noAplicoPago)
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
          @endif

          @if (!$noAplicoPago)
            @if ($curPlanPago == "A" || $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave == "CVA")
              <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
            @endif

            @if ($curPlanPago == "N" && $curso->cgt->plan->programa->escuela->departamento->ubicacion->ubiClave != "CVA")
              @if ($inscripcion->estadoPagoInscripcion)
                <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
                <p style="text-align:center;margin-bottom: 10px;">${{$inscripcion->estadoPagoInscripcion->pagImpPago}}</p>
                <p style="text-align:center;margin-bottom: 10px;">
                  @php
                    $fecha = Carbon\Carbon::parse($inscripcion->estadoPagoInscripcion->pagFechaPago);
                    $fecha = sprintf('%02d', $fecha->day) . "/" . App\Http\Helpers\Utils::num_meses_corto_string($fecha->month) . "/" . $fecha->year;
                  @endphp
                  {{$fecha}}
                </p>
              @endif

              @if (!$inscripcion->estadoPagoInscripcion)
                @if (!$inscripcion->esFechaInscripcion1Vencida)
                  <p style="font-size: 14px;">Vence  {{$inscripcion->fechaInscripcion1}} ${{number_format($inscripcion->importeInscripcion, 2, '.', ',')}}</p>
                  <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$inscripcion->referenciaInscripcion1}}</span></p>
                @endif

                @if (!$inscripcion->esFechaInscripcion2Vencida)
                  <p style="font-size: 14px;">Vence  {{$inscripcion->fechaInscripcion2}} ${{number_format($inscripcion->importeInscripcion, 2, '.', ',')}}</p>
                  <p style="margin-bottom: 10px; font-size: 14px;">Refer. <span style="font-weight:700;">{{$inscripcion->referenciaInscripcion2}}</span></p>
                @endif

                @if (!$inscripcion->esFechaInscripcion3Vencida)
                  <p style="font-size: 14px;">Vence  {{$inscripcion->fechaInscripcion3}} ${{number_format($inscripcion->importeInscripcion, 2, '.', ',')}}</p>
                  <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$inscripcion->referenciaInscripcion3}}</span></p>
                @endif

                @if ($inscripcion->esFechaInscripcion3Vencida)
                  <p style="font-size: 14px;">Vence  {{$inscripcion->fechaInscripcionUltimoAtraso}} ${{number_format($inscripcion->importeInscripcion, 2, '.', ',')}}</p>
                  <p style="font-size: 14px;">Refer. <span style="font-weight:700;">{{$inscripcion->referenciaInscripcionUltimoAtraso}}</span></p>
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
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
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
              @if ($noAplicoPago)
                <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
              @endif
              @if (!$noAplicoPago)
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
          @endif
        </div>
      </div>

      <div class="columns medium-4">
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
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

      <div class="columns medium-4" style="height: 180px;">
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
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
    </div>



    <div class="row" style="margin-top: 8px; margin-bottom: 8px;">
      <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
    </div>



    <div class="row">
      <div class="columns medium-4">
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
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

      <div class="columns medium-4">
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
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
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
          <p style="text-align: center;margin-bottom: 30px; font-weight: 700;">CONVENIO</p>
          <p style="text-align: center; font-weight: 700; font-size: 14px;">{{sprintf('%07d', $convenio)}}</p>
        </div>
      </div>
    </div>


    <div class="row" style="margin-top: 8px; margin-bottom: 8px;">
      <div class="columns medium-12">
        <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
      </div>
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
      @if ($curPlanPago == "N")
        <div class="columns medium-6">
          <div style="float:right;">
            <p>
              Plan de 10 pagos.
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
      @endif

      @if ($curPlanPago == "A")
        <div class="columns medium-6">
          <div style="float:right;">
            <p>
              Aplica Ant/Cred:
              @php
                $inscripcionAnticipoCredito = (Double) $inscripcion->importeInscripcion / 10;
                $inscripcionAnticipoCredito = (string) number_format($inscripcionAnticipoCredito, 2, ".", "");
              @endphp
              ${{$inscripcionAnticipoCredito}}
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
      @endif
    </div>
  </body>
</html>
