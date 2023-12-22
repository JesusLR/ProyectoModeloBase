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
            font-family: sans-serif;
            font-size: 10px;
            margin-top: 40px;
            margin-left: 5px;
            margin-right: 5px;
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
      .float-right {
        float: right;
      }
      .logo {
        width: 100%;
      }
      .box-solicitud {
        border: 1px solid #000;
        padding: 5px;
        border-radius: 2px;
      }

      .estilos-tabla {
        width: 100%;
      }
      .estilos-tabla tr td{
        font-size: 10px;
        background-color: #000;
        color: #fff;
        height: 30px;
        padding-left:5px;
        padding-right:5px;
        box-sizing: border-box;
        text-align: center;
      }
      .estilos-tabla tr td{
        font-size: 10px;
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
        top: -20px;
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
        margin-top: 30px;
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

      .table td, .table  td {
        padding-top: 0px;
        padding-bottom: 0px;
        padding-right: 5px;
      }

      .fila {
          border-bottom: 1px solid #000;
      }

      .page-number:before {
        content: "Pág " counter(page);
      }
      .letraencabezado{
        font-size:12px;
      }
      .letrapietotales{
          font-size:12px;
      }
    </style>

        <style type="text/css">
            dummydeclaration { padding-left: 4em; } /* Firefox ignores first declaration for some reason */
            tab1 { padding-left: 4em; }
            tab2 { padding-left: 8em; }
            tab3 { padding-left: 12em; }
            tab4 { padding-left: 16em; }
            tab5 { padding-left: 20em; }
            tab6 { padding-left: 24em; }
            tab7 { padding-left: 28em; }
            tab8 { padding-left: 32em; }
            tab9 { padding-left: 36em; }
            tab10 { padding-left: 40em; }
            tab11 { padding-left: 44em; }
            tab12 { padding-left: 48em; }
            tab13 { padding-left: 52em; }
            tab14 { padding-left: 56em; }
            tab15 { padding-left: 60em; }
            tab16 { padding-left: 64em; }
            tab6em { padding-left: 6em; }
        </style>
	</head>
  <body>
      <header>
          <div class="row">
            <div class="columns medium-6">
              <p class="letraencabezado">ESCUELA MODELO S.C.P.</p>
              <p class="letraencabezado">Importe total de becas del curso: {{$perAnio}} - {{$perAnio + 1}}</p>
              <p class="letraencabezado">Tipo de Alumno : {{$aluEstado}}</p>
            </div>
            <div class="columns medium-6">
              <div style="text-align: right;">
                <p>{{ \Carbon\Carbon::parse($fechaActual)->format('d/m/Y') }}</p>
                <p>{{$horaActual}}</p>
                <p>{{$nombreArchivo}}</p>
              </div>
            </div>
          </div>


      </header>
      <div class="row">
        <div class="columns medium-12">
          <table class="table" border="0">
            <thead>
                <tr>
                  <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Campus</b></td>
                  <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Nivel Escuela Programa</b></td>
                  <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>&nbsp;</b></td>
                  <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>&nbsp;</b></td>
                  <td align="center" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>&nbsp;</b></td>
                  <td align="right" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Periodo Año</b></td>
                  <td align="right" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Mes</b></td>
                  <td align="right" style="font-weight: 400; font-size:12px; border-bottom: 1px solid #000;"><b>Acumulado Año</b></td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;</td>
                </tr>
            </thead>
           <tbody>
              {{--dd($pagos)--}}
             {{$equival = 0}}
             {{$escClave = ''}}
             {{$escNombre = ''}}
             {{$mensualidad = 0}}
             {{$tituloCampus = ''}}
             {{$tituloNivel = ''}}
             {{$nivelAlumnos = 0}}
             {{$nivelEquivalente = 0}}
             {{$nivelacumuladoMes = 0}}
             {{$nivelacumuladoAnio = 0}}
             {{$totalAlumnos = 0}}
             {{$totalEquivalente  = 0}}
             {{$totalacumuladoMes = 0}}
             {{$totalacumuladoAnio = 0}}
             {{ $total = 0 }}

              @foreach($pagos as $item)


                  @php
                    $cuenta = $item->count();
                    $total += $cuenta;
                    $escClave = '';
                    $escNombre = '';
                    $mensualidad = 0;

                    $primerRegistroCampus = $item->first();
                    $porcentajeBecas = $primerRegistroCampus['beca'];
                    $campCVE = $primerRegistroCampus['ubicacionClave'];
                    $campNombre = $primerRegistroCampus['ubicacionNombre'];
                    $depCN = $primerRegistroCampus["depClave"].' - '.$primerRegistroCampus['depNombre'];
                    $escuelaPrograma = $primerRegistroCampus["depClave"].' - '.$primerRegistroCampus['escNombre'].' - '.$primerRegistroCampus['progNombre'];
                    $nivelEscuela = $primerRegistroCampus["depClave"].' - '.$primerRegistroCampus['escNombre'];
                    $mensualidadBase = $primerRegistroCampus["mensualidad"];
                    $numeromesesBase = $primerRegistroCampus["numMeses"];
                    $acumuladoMes = 0;
                    $acumuladoAnio = 0;
                    $acumuladoEquivalente = 0;
                  @endphp


                  @if ($tituloCampus != $campCVE)
                      @if ($nivelAlumnos > 0)
                          <tr>
                              <td colspan="8">&nbsp;</td>
                          </tr>
                          <tr>
                              <td align="left" colspan="5" style="border-bottom: 1px solid #000;">&nbsp;&nbsp;&nbsp;<b>{{$tituloCampus}} {{strtoupper($tituloNivel)}}</b></td>
                              <td align="right" style="border-bottom: 1px solid #000;"><b>{{$perNumero}}&nbsp;&nbsp;&nbsp;{{$perAnio}}</b></td>
                              <td align="right" style="border-bottom: 1px solid #000;"><b>${{number_format($nivelacumuladoMes, 2, '.', ',')}}</b></td>
                              <td align="right" style="border-bottom: 1px solid #000;"><b>${{number_format($nivelacumuladoAnio, 2, '.', ',')}}</b></td>
                              {{$totalAlumnos = $totalAlumnos + $nivelAlumnos}}
                              {{$totalEquivalente = $totalEquivalente + $nivelEquivalente}}
                              {{$totalacumuladoMes = $totalacumuladoMes + $nivelacumuladoMes}}
                              {{$totalacumuladoAnio = $totalacumuladoAnio + $nivelacumuladoAnio}}
                              {{$nivelAlumnos = 0}}
                              {{$nivelEquivalente = 0}}
                              {{$nivelacumuladoMes = 0}}
                              {{$nivelacumuladoAnio = 0}}
                          </tr>
                          <tr>
                              <td colspan="8">&nbsp;</td>
                          </tr>

                      @endif
                      <tr>
                          <td colspan="3">
                              <b>{{$campCVE}} {{$campNombre}}</b>
                          </td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>
                      <tr>
                          <td colspan="8">&nbsp;</td>
                      </tr>
                      <tr>
                          <td align="left" colspan="6" ><b>&nbsp;&nbsp;&nbsp;{{$campCVE}} {{strtoupper($nivelEscuela)}}</b></td>
                          <td align="left" colspan="2" ><b>Cuota Mensual Estimada: ${{number_format($mensualidadBase, 2, '.', ',')}}</b></td>
                      </tr>
                      <tr>
                          <td align="left" colspan="5"><b><tab1>Número de Alumnos</tab1><tab1>% Beca</tab1><tab6em>Importe Total</tab6em></b></td>
                          <td align="center" colspan="3"></td>
                      </tr>
                      {{$tituloCampus = $campCVE}}
                      {{$tituloNivel = $nivelEscuela}}
                  @else
                      @if ($tituloNivel != $nivelEscuela)
                          @if ($nivelAlumnos > 0)

                              <tr>
                                  <td align="left" colspan="5"><tab2>Total: {{$total}}</tab2></td>
                                  <td align="center"></td>
                                  <td align="right"></td>
                                  <td align="right"></td>
                                  {{$total = 0}}
                              </tr>
                              <tr>
                                  <td colspan="8">&nbsp;</td>
                              </tr>

                              <tr>
                                  <td align="left" colspan="5">&nbsp;&nbsp;&nbsp;<b>{{$tituloCampus}} {{strtoupper($tituloNivel)}}</b></td>
                                  <td align="right"><b>{{$perNumero}}&nbsp;&nbsp;&nbsp;{{$perAnio}} </b></td>
                                  <td align="right"><b>${{number_format($nivelacumuladoMes, 2, '.', ',')}}</b></td>
                                  <td align="right"><b>${{number_format($nivelacumuladoAnio, 2, '.', ',')}}</b></td>
                                  {{$totalAlumnos = $totalAlumnos + $nivelAlumnos}}
                                  {{$totalEquivalente = $totalEquivalente + $nivelEquivalente}}
                                  {{$totalacumuladoMes = $totalacumuladoMes + $nivelacumuladoMes}}
                                  {{$totalacumuladoAnio = $totalacumuladoAnio + $nivelacumuladoAnio}}
                                  {{$nivelAlumnos = 0}}
                                  {{$nivelEquivalente = 0}}
                                  {{$nivelacumuladoMes = 0}}
                                  {{$nivelacumuladoAnio = 0}}
                              </tr>

                              <tr>
                                  <td colspan="8">&nbsp;</td>
                              </tr>

                              <tr>
                                  <td colspan="8">&nbsp;</td>
                              </tr>

                          @endif
                          <tr>
                              <td align="left" colspan="6">&nbsp;&nbsp;&nbsp;<b>{{$tituloCampus}} {{strtoupper($nivelEscuela)}}</b></td>
                              <td align="left" colspan="2"><b>Cuota Mensual Estimada: ${{number_format($mensualidadBase, 2, '.', ',')}}</b></td>
                          </tr>
                          {{$tituloNivel = $nivelEscuela}}

                          <tr>
                              <td align="left" colspan="5"><b><tab1>Número de Alumnos</tab1><tab1>% Beca</tab1><tab6em>Importe Total</tab6em></b></td>
                              <td align="center" colspan="3"></td>
                          </tr>

                      @endif
                  @endif


                  @foreach ($item as $campus)
                      @php
                          $equivalente = $campus["porBeca"];
                          $mensualidad = $campus['mensualidad'];
                          $numdeMeses = $campus["numMeses"];

                          $acumuladoMes = $acumuladoMes + ($equivalente * $mensualidad);
                          $acumuladoAnio = $acumuladoAnio + (($equivalente * $mensualidad) * $numdeMeses);
                          $acumuladoEquivalente += $equivalente;

                          //ESTIMAMOS POR TIPO DE MENSUALIDAD
                          if ( $mensualidadBase < 3000 )
                          {
                                $mensualidadBase = $mensualidad;
                                $numeromesesBase = $numdeMeses;
                          }
                          else
                          {
                              if ( $mensualidad != $mensualidadBase )
                              {
                                if ($numdeMeses == 10)
                                {
                                    $mensualidadBase = $mensualidad;
                                    $numeromesesBase = $numdeMeses;
                                }
                              }
                          }


                      @endphp

                  @endforeach


                  <tr>
                      <td align="left" colspan="5"><tab2>{{$cuenta}}</tab2><tab1>de</tab1><tab1>{{$porcentajeBecas}}%</tab1><tab1>=</tab1><tab1>${{number_format($acumuladoMes, 2, '.', ',')}}</tab1></td>
                      <td align="center"></td>
                      <td align="right">${{number_format($acumuladoMes, 2, '.', ',')}}</td>
                      <td align="right">${{number_format($acumuladoAnio, 2, '.', ',')}}</td>
                  </tr>

                  {{$nivelAlumnos = $nivelAlumnos + $cuenta}}
                  {{$nivelacumuladoMes = $nivelacumuladoMes + $acumuladoMes}}
                  {{$nivelacumuladoAnio = $nivelacumuladoAnio + $acumuladoAnio}}
                  {{$nivelEquivalente = $nivelEquivalente + $acumuladoEquivalente}}
                  {{$acumuladoEquivalente = 0}}
                  {{$acumuladoMes = 0}}
                  {{$acumuladoAnio = 0}}

            @endforeach
            <tr>
                    <td colspan="8">&nbsp;</td>
            </tr>
            <tr>
                    <td align="left" colspan="5" style="border-bottom: 1px solid #000;">&nbsp;&nbsp;&nbsp;<b>{{$tituloCampus}} {{strtoupper($tituloNivel)}}</b></td>
                    <td align="right" style="border-bottom: 1px solid #000;"><b>{{$perNumero}}&nbsp;&nbsp;&nbsp;{{$perAnio}}</b></td>
                    <td align="right" style="border-bottom: 1px solid #000;"><b>${{number_format($nivelacumuladoMes, 2, '.', ',')}}</b></td>
                    <td align="right" style="border-bottom: 1px solid #000;"><b>${{number_format($nivelacumuladoAnio, 2, '.', ',')}}</b></td>
                    {{$totalAlumnos = $totalAlumnos + $nivelAlumnos}}
                    {{$totalEquivalente = $totalEquivalente + $nivelEquivalente}}
                    {{$totalacumuladoMes = $totalacumuladoMes + $nivelacumuladoMes}}
                    {{$totalacumuladoAnio = $totalacumuladoAnio + $nivelacumuladoAnio}}
            </tr>
            <tr>
                    <td colspan="8">&nbsp;</td>
            </tr>
            <tr>
                    <td colspan="5">&nbsp;</td>
                    <td class="letraencabezado" align="right"><b>Totales:</b></td>
                    <td align="right"><b>${{number_format($totalacumuladoMes, 2, '.', ',')}}</b></td>
                    <td align="right"><b>${{number_format($totalacumuladoAnio, 2, '.', ',')}}</b></td>
            </tr>

           </tbody>
          </table>
        </div>
      </div>

  </body>
</html>
