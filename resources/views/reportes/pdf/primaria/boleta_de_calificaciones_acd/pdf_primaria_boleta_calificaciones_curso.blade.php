<!DOCTYPE html>
<html>
	<head>
		<title>Boleta de Calificaciones</title>
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
        line-height: 1.6; /* 1 */
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
        font-size: 10px;
        margin-top: 30px;  /* ALTURA HEADER */
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
        top: -70px;
        right: 0px;
        height: 3px;
        /** Extra personal styles **/

        margin-left: 5px;
        margin-right: 5px;
      }

      #watermark { position: fixed; top: 15%; left: 0;  width: 700px; height: 700px; opacity: .3; }
      .img-header{
        height: 80px;
        float: left;
      }
      .img-foto{
        height: 80px;
        float: right;
        margin-top: -100px;

        padding:2px;
        background-color: #f5f5f5;
        border: 1px solid #999999;


      }
      .inicio-pagina{
        margin-top: 0;
        display: block;
      }
      @page {
        margin-top: 80px;
        margin-bottom: 40px;
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



      .table td, .table  th {
        padding-top: 0px;
        padding-bottom: 0px;
        padding-right: 5px;
        border: 1px solid #000;
      }

      .page-number:before {
        content: "Pág " counter(page);
      }

      .page-break {
          page-break-after: always;
      }

    </style>
	</head>
  <body>

  <header>
      <div class="row" style="margin-top: 0px;">
          <div class="columns medium-12">

              <img class="img-header"  src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">

              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">ESCUELA MODELO</h4>
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">Primaria</h4>
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">Clave 31PPR0097X</h4>
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">{{$cicloEscolar}}</h4>
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">BOLETA ARTE, CULTURA Y DEPORTE</h4>

          </div>
      </div>
  </header>

  @php
  $key = 0;
  $keyMatFA = 0.0;
  $keyMatDESA = 0.0;
  $keyMatPROY = 0.0;
  $keyMatOPTA = 0.0;
  $keyPromedioGeneral = 0;
  $acd = 0;
  $Keynasistencias = 0;


  //hay que declarar mas variables, una por columna diferente y categoria
  //iniciarlas en 0.0
  $promSEPFA = 0.0;
  $promOCTFA = 0.0;
  $promNOVFA = 0.0;
  $promedioGen1FA = 0.0;
  $promedioGen1SEPFA = 0.0;
  $promDicEneFA = 0.0;
  $promFEBFA = 0.0;
  $promMARFA = 0.0;
  $promedioGen2FA = 0.0;
  $promedioGen2SEPFA = 0.0;
  $promABRFA = 0.0;
  $promMAYFA = 0.0;
  $promJUNFA = 0.0;
  $promedioGen3FA = 0.0;
  $promedioGen3SEPFA = 0.0;
  $promedioFinalFA = 0.0;
  $promedioFinalSEPFA = 0.0;

  $promSEPDESA = 0.0;
  $promOCTDESA = 0.0;
  $promNOVDESA = 0.0;
  $PromedioGen1DESA = 0.0;
  $PromedioGen1SEPDESA = 0.0;
  $promDICENEDESA = 0.0;
  $promFEBDESA = 0.0;
  $promMARDESA = 0.0;
  $PromedioGen2DESA = 0.0;
  $PromedioGen2SEPDESA = 0.0;
  $promABRDESA = 0.0;
  $promMAYDESA = 0.0;
  $promJUNDESA = 0.0;
  $PromedioGen3DESA = 0.0;
  $PromedioGen3SEPDESA = 0.0;
  $promedioFinalDESA = 0.0;
  $promedioFinalSEPDESA = 0.0;

  $sepArtis = 0.0;
  $octArtis = 0.0;
  $novArtis = 0.0;
  $genArtis1 = 0.0;
  $diceneArtis = 0.0;
  $febArtis = 0.0;
  $marArtis = 0.0;
  $genArtis2 = 0.0;
  $abrArtis = 0.0;
  $mayArtis = 0.0;
  $junArtis = 0.0;
  $genArtis3 = 0.0;
  $genFinalArtis = 0.0;


  $promSEPPROY = 0.0;
  $promSEPOPTA = 0.0;
  $promSEPGENERAL = 0.0;
  $promOCTGENERAL = 0.0;
  $promNOVGENERAL = 0.0;
  $promGENGENERAL1 = 0.0;
  $promDICENEGENERAL = 0.0;
  $promFEBGENERAL = 0.0;
  $promMARGENERAL = 0.0;
  $promGENGENERAL2 = 0.0;
  $promABRGENERAL = 0.0;
  $promMAYGENERAL = 0.0;
  $promJUNGENERAL = 0.0;
  $promGENGENERAL3 = 0.0;
  $promFINALGENERAL = 0.0;
@endphp

@foreach ($alumnoAgrupado as $clave_pago => $valores)
    @foreach ($calificaciones as $inscrito)
        @if ($inscrito->clave_pago == $clave_pago)

        {{--  llave del 1 hasta donde llege y se sepite el ciclo  --}}
        @php
            $key++;
        @endphp
            @if ($key == 1)
            {{--  Cargar la foto del alumno   --}}
            @if ($inscrito->curPrimariaFoto != "")
            <img class="img-foto" src="{{base_path('storage/app/public/primaria/cursos/fotos/' . $inscrito->perAnioPago . '/' . $inscrito->curPrimariaFoto) }}" alt="">

            @else
            <img class="img-foto"  src="" alt="">
            @endif

            {{--  fin foto   --}}

            <div class="row">
              <div class="columns medium-4">
                  <div style="text-align: left;">
                        <p>Clave:<b> {{$clave_pago}}</b></p>
                        <p>Alumno:<b> {{$inscrito->nombres}} {{$inscrito->ape_paterno}} {{$inscrito->ape_materno}}</b></p>
                  </div>
              </div>
              <div class="columns medium-4">
                  <div style="text-align: center;">
                      <p>Grado:<b> {{$inscrito->gpoGrado}}{{$inscrito->grupo}}</b></p>
                      <p>Curp:<b> {{$inscrito->curp}}</b></p>
                  </div>
              </div>
              <div class="columns medium-4">
                  <div style="text-align: right;">
                      <p>Fecha: {{$fechaActual}}</p>
                      <p>Hora: {{ $horaActual}}</p>
                  </div>
              </div>
            </div>

            <br>

        <div class="row">
          <div class="columns medium-12">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th align="center" style=" width: 200px; border-top: 0px; border-right: 0px; border-bottom: 0px solid; border-left: 0px;"></th>
                          <th align="center" colspan="6" style="border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;">PRIMER PERIODO</th>
                          <th align="center" colspan="6" style="border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;">SEGUNDO PERIODO</th>
                          <th align="center" colspan="6" style="border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;">TERCER PERIODO</th>
                          <th align="center" colspan="3" style="border-top: 1px solid; border-right: 1px solid; border-bottom: 0px; border-left: 1px solid;">FINALES</th>
                      </tr>
                      <tr>
                          <th align="center" style=" width: 200px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"></th>
                          <th align="center" colspan="4" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 1px solid;"></th>
                          <th align="center" colspan="2" style="border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;">SEP</th>
                          <th align="center" colspan="4" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 1px solid;"></th>
                          <th align="center" colspan="2">SEP</th>
                          <th align="center" colspan="4" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 1px solid;"></th>
                          <th align="center" colspan="2">SEP</th>
                          <th align="center" colspan="1" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 1px solid;"></th>
                          <th align="center" colspan="2">SEP</th>
                      </tr>
                      <tr>
                          <th align="center" style=" width: 200px; border-bottom: 0px">ASIGNATURA</th>
                          <th align="center">SEP</th>
                          <th align="center">OCT</th>
                          <th align="center">NOV</th>
                          <th align="center">PROM</th>
                          <th align="center">PROM</th>
                          <th align="center">NIVEL</th>
                          <th align="center">DIC-ENE</th>
                          <th align="center">FEB</th>
                          <th align="center">MAR</th>
                          <th align="center">PROM</th>
                          <th align="center">PROM</th>
                          <th align="center">NIVEL</th>
                          <th align="center">ABR</th>
                          <th align="center">MAY</th>
                          <th align="center">JUN</th>
                          <th align="center">PROM</th>
                          <th align="center">PROM</th>
                          <th align="center">NIVEL</th>
                          <th align="center">PROM</th>
                          <th align="center">PROM</th>
                          <th align="center">NIVEL</th>
                      </tr>
                      <tr>
                        <th></th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($calificaciones as $key => $item)
                      @if ($item->clave_pago == $clave_pago)
                        @if ($item->matNombreEspecialidad == "OPTATIVAS")
                        <tr>
                          @php
                              $keyMatFA++;

                          @endphp
                          <td style="width: 200px;">{{$item->gpoMatComplementaria}}</td>

                          <td align="center">
                            @if ($item->inscCalificacionSep == 1.0 || $item->inscCalificacionSep == 2.0 || $item->inscCalificacionSep == 3.0 || $item->inscCalificacionSep == 4.0 ||
                            $item->inscCalificacionSep == 5.0 || $item->inscCalificacionSep == 6.0 || $item->inscCalificacionSep == 7.0 || $item->inscCalificacionSep == 8.0 ||
                            $item->inscCalificacionSep == 9.0 || $item->inscCalificacionSep == 10.0)

                            {{round($item->inscCalificacionSep)}}

                            @else
                            {{round($item->inscCalificacionSep, 1)}}
                            @endif
                          </td>

                          <td align="center">
                            @if ($item->inscCalificacionOct == 1.0 || $item->inscCalificacionOct == 2.0 || $item->inscCalificacionOct == 3.0 || $item->inscCalificacionOct == 4.0 ||
                            $item->inscCalificacionOct == 5.0 || $item->inscCalificacionOct == 6.0 || $item->inscCalificacionOct == 7.0 || $item->inscCalificacionOct == 8.0 ||
                            $item->inscCalificacionOct == 9.0 || $item->inscCalificacionOct == 10.0)

                            {{round($item->inscCalificacionOct)}}

                            @else
                            {{round($item->inscCalificacionOct, 1)}}
                            @endif
                          </td>

                          <td align="center">
                            @if ($item->inscCalificacionNov == 1.0 || $item->inscCalificacionNov == 2.0 || $item->inscCalificacionNov == 3.0 || $item->inscCalificacionNov == 4.0 ||
                            $item->inscCalificacionNov == 5.0 || $item->inscCalificacionNov == 6.0 || $item->inscCalificacionNov == 7.0 || $item->inscCalificacionNov == 8.0 ||
                            $item->inscCalificacionNov == 9.0 || $item->inscCalificacionNov == 10.0)

                            {{round($item->inscCalificacionNov)}}

                            @else
                            {{round($item->inscCalificacionNov, 1)}}
                            @endif
                          </td>

                          {{--  promedio trimestree 1  --}}
                          <td align="center"><b>{{round($item->inscTrimestre1,1)}}</b></td>
                          <td align="center">{{$item->inscTrimestre1SEP}}</td>


                          <td align="center">{{""}}</td>

                          <td align="center">
                            @if ($item->inscCalificacionDicEnero == 1.0 || $item->inscCalificacionDicEnero == 2.0 || $item->inscCalificacionDicEnero == 3.0 || $item->inscCalificacionDicEnero == 4.0 ||
                            $item->inscCalificacionDicEnero == 5.0 || $item->inscCalificacionDicEnero == 6.0 || $item->inscCalificacionDicEnero == 7.0 || $item->inscCalificacionDicEnero == 8.0 ||
                            $item->inscCalificacionDicEnero == 9.0 || $item->inscCalificacionDicEnero == 10.0)

                            {{round($item->inscCalificacionDicEnero)}}

                            @else
                            {{round($item->inscCalificacionDicEnero, 1)}}
                            @endif
                          </td>

                          <td align="center">
                            @if ($item->inscCalificacionFeb == 1.0 || $item->inscCalificacionFeb == 2.0 || $item->inscCalificacionFeb == 3.0 || $item->inscCalificacionFeb == 4.0 ||
                            $item->inscCalificacionFeb == 5.0 || $item->inscCalificacionFeb == 6.0 || $item->inscCalificacionFeb == 7.0 || $item->inscCalificacionFeb == 8.0 ||
                            $item->inscCalificacionFeb == 9.0 || $item->inscCalificacionFeb == 10.0)

                            {{round($item->inscCalificacionFeb)}}

                            @else
                            {{round($item->inscCalificacionFeb, 1)}}
                            @endif
                          </td>

                          <td align="center">
                            @if ($item->inscCalificacionMar == 1.0 || $item->inscCalificacionMar == 2.0 || $item->inscCalificacionMar == 3.0 || $item->inscCalificacionMar == 4.0 ||
                            $item->inscCalificacionMar == 5.0 || $item->inscCalificacionMar == 6.0 || $item->inscCalificacionMar == 7.0 || $item->inscCalificacionMar == 8.0 ||
                            $item->inscCalificacionMar == 9.0 || $item->inscCalificacionMar == 10.0)

                            {{round($item->inscCalificacionMar)}}

                            @else
                            {{round($item->inscCalificacionMar, 1)}}
                            @endif
                          </td>

                          {{--  promedio trimestre 2   --}}
                          <td align="center"><b>{{round($item->inscTrimestre2,1)}}</b></td>
                          <td align="center">{{$item->inscTrimestre2SEP}}</td>

                          <td align="center">{{""}}</td>
                          <td align="center">{{$item->inscCalificacionAbr}}</td>
                          <td align="center">{{$item->inscCalificacionMay}}</td>
                          <td align="center">{{$item->inscCalificacionJun}}</td>

                          {{--  promedio trimestre 3   --}}
                          <td align="center"><b>{{round($item->inscTrimestre3,1)}}</b></td>
                          <td align="center">{{$item->inscTrimestre3SEP}}</td>


                          <td align="center">{{""}}</td>

                          {{--  promedio final   --}}
                          <td align="center">
                            @if (round($item->inscPromedioTrimCALCULADO, 1) == 1.0 || round($item->inscPromedioTrimCALCULADO, 1) == 2.0 || round($item->inscPromedioTrimCALCULADO, 1) == 3.0 || round($item->inscPromedioTrimCALCULADO, 1) == 4.0 ||
                              round($item->inscPromedioTrimCALCULADO, 1) == 5.0 || round($item->inscPromedioTrimCALCULADO, 1) == 6.0 || round($item->inscPromedioTrimCALCULADO, 1) == 7.0 || round($item->inscPromedioTrimCALCULADO, 1) == 8.0 ||
                              round($item->inscPromedioTrimCALCULADO, 1) == 9.0 || round($item->inscPromedioTrimCALCULADO, 1) == 10.0)

                              <b>{{round($item->inscPromedioTrimCALCULADO)}}</b>

                            @else
                              <b>{{round($item->inscPromedioTrimCALCULADO, 1)}}</b>
                            @endif

                          </td>

                          {{--  promedio final sep   --}}
                          <td align="center">
                            @if (round($item->inscPromedioTrimCALCULADOSEP, 1) == 1.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 2.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 3.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 4.0 ||
                            round($item->inscPromedioTrimCALCULADOSEP, 1) == 5.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 6.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 7.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 8.0 ||
                            round($item->inscPromedioTrimCALCULADOSEP, 1) == 9.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 10.0)

                            {{round($item->inscPromedioTrimCALCULADOSEP)}}

                            @else
                            {{round($item->inscPromedioTrimCALCULADOSEP, 1)}}
                            @endif
                          </td>

                          <td align="center">{{""}}</td>
                        </tr>
                        @endif
                      @endif
                    @endforeach

                    @php

                    @endphp
                    <tr>
                      <td><b>PROM. FORMACIÓN ACADÉMICA</b></td>
                      {{--  promedio septiembree  --}}
                      <td align="center">
                        @if (round($promSEPFA, 1) == 1.0 || round($promSEPFA, 1) == 2.0 || round($promSEPFA, 1) == 3.0 || round($promSEPFA, 1) == 4.0 ||
                        round($promSEPFA, 1) == 5.0 || round($promSEPFA, 1) == 6.0 || round($promSEPFA, 1) == 7.0 || round($promSEPFA, 1) == 8.0 ||
                        round($promSEPFA, 1) == 9.0 || round($promSEPFA, 1) == 10.0)

                        <b>{{round($promSEPFA)}}</b>

                        @else
                        <b>{{round($promSEPFA, 1)}}</b>
                        @endif
                      </td>

                      {{--  promedio octubre   --}}
                      <td align="center">
                        @if (round($promOCTFA, 1) == 1.0 || round($promOCTFA, 1) == 2.0 || round($promOCTFA, 1) == 3.0 || round($promOCTFA, 1) == 4.0 ||
                        round($promOCTFA, 1) == 5.0 || round($promOCTFA, 1) == 6.0 || round($promOCTFA, 1) == 7.0 || round($promOCTFA, 1) == 8.0 ||
                        round($promOCTFA, 1) == 9.0 || round($promOCTFA, 1) == 10.0)

                        <b>{{round($promOCTFA)}}</b>

                        @else
                        <b>{{round($promOCTFA, 1)}}</b>
                        @endif
                      </td>

                      {{--  promedio noviembre   --}}
                      <td align="center">
                        @if (round($promNOVFA, 1) == 1.0 || round($promNOVFA, 1) == 2.0 || round($promNOVFA, 1) == 3.0 || round($promNOVFA, 1) == 4.0 ||
                        round($promNOVFA, 1) == 5.0 || round($promNOVFA, 1) == 6.0 || round($promNOVFA, 1) == 7.0 || round($promNOVFA, 1) == 8.0 ||
                        round($promNOVFA, 1) == 9.0 || round($promNOVFA, 1) == 10.0)

                        <b>{{round($promNOVFA)}}</b>

                        @else
                        <b>{{round($promNOVFA, 1)}}</b>
                        @endif
                      </td>

                      {{--  promedio general primer periodo   --}}
                      <td align="center">
                        @if (round($promedioGen1FA, 1) == 1.0 || round($promedioGen1FA, 1) == 2.0 || round($promedioGen1FA, 1) == 3.0 || round($promedioGen1FA, 1) == 4.0 ||
                        round($promedioGen1FA, 1) == 5.0 || round($promedioGen1FA, 1) == 6.0 || round($promedioGen1FA, 1) == 7.0 || round($promedioGen1FA, 1) == 8.0 ||
                        round($promedioGen1FA, 1) == 9.0 || round($promedioGen1FA, 1) == 10.0)

                        <b>{{round($promedioGen1FA)}}</b>

                        @else
                        <b>{{round($promedioGen1FA, 1)}}</b>
                        @endif
                      </td>
                      {{--  promedio general SEP primer periodo   --}}
                      <td align="center"><b>{{$promedioGen1SEPFA}}</b></td>


                      <td align="center"><b>{{""}}</b></td>

                      {{--  segundo periodo  --}}
                      {{--  promedio dic enero  --}}
                      <td align="center">
                        @if (round($promDicEneFA, 1) == 1.0 || round($promDicEneFA, 1) == 2.0 || round($promDicEneFA, 1) == 3.0 || round($promDicEneFA, 1) == 4.0 ||
                        round($promDicEneFA, 1) == 5.0 || round($promDicEneFA, 1) == 6.0 || round($promDicEneFA, 1) == 7.0 || round($promDicEneFA, 1) == 8.0 ||
                        round($promDicEneFA, 1) == 9.0 || round($promDicEneFA, 1) == 10.0)

                        <b>{{round($promDicEneFA)}}</b>

                        @else
                        <b>{{round($promDicEneFA, 1)}}</b>
                        @endif
                      </td>

                      {{--  promedio febrero  --}}
                      <td align="center">
                        @if (round($promFEBFA, 1) == 1.0 || round($promFEBFA, 1) == 2.0 || round($promFEBFA, 1) == 3.0 || round($promFEBFA, 1) == 4.0 ||
                        round($promFEBFA, 1) == 5.0 || round($promFEBFA, 1) == 6.0 || round($promFEBFA, 1) == 7.0 || round($promFEBFA, 1) == 8.0 ||
                        round($promFEBFA, 1) == 9.0 || round($promFEBFA, 1) == 10.0)

                        <b>{{round($promFEBFA)}}</b>

                        @else
                        <b>{{round($promFEBFA, 1)}}</b>
                        @endif
                      </td>

                      {{--  promedio marzo  --}}
                      <td align="center">
                        @if (round($promMARFA, 1) == 1.0 || round($promMARFA, 1) == 2.0 || round($promMARFA, 1) == 3.0 || round($promMARFA, 1) == 4.0 ||
                        round($promMARFA, 1) == 5.0 || round($promMARFA, 1) == 6.0 || round($promMARFA, 1) == 7.0 || round($promMARFA, 1) == 8.0 ||
                        round($promMARFA, 1) == 9.0 || round($promMARFA, 1) == 10.0)

                        <b>{{round($promMARFA)}}</b>

                        @else
                        <b>{{round($promMARFA, 1)}}</b>
                        @endif
                      </td>

                      {{--  promedio general segundo periodo   --}}
                      <td align="center">
                        @if (round($promedioGen2FA, 1) == 1.0 || round($promedioGen2FA, 1) == 2.0 || round($promedioGen2FA, 1) == 3.0 || round($promedioGen2FA, 1) == 4.0 ||
                        round($promedioGen2FA, 1) == 5.0 || round($promedioGen2FA, 1) == 6.0 || round($promedioGen2FA, 1) == 7.0 || round($promedioGen2FA, 1) == 8.0 ||
                        round($promedioGen2FA, 1) == 9.0 || round($promedioGen2FA, 1) == 10.0)

                        <b>{{round($promedioGen2FA)}}</b>

                        @else
                        <b>{{round($promedioGen2FA,1 )}}</b>
                        @endif
                      </td>
                      {{--  promedio general SEP segundo periodo   --}}
                      <td align="center"><b>{{$promedioGen2SEPFA}}</b></td>
                      <td align="center"><b>{{""}}</b></td>

                      {{--  tercer periodo   --}}
                      {{--  promedio abril  --}}
                      <td align="center">
                        @if (round($promABRFA, 1) == 1.0 || round($promABRFA, 1) == 2.0 || round($promABRFA, 1) == 3.0 || round($promABRFA, 1) == 4.0 ||
                        round($promABRFA, 1) == 5.0 || round($promABRFA, 1) == 6.0 || round($promABRFA, 1) == 7.0 || round($promABRFA, 1) == 8.0 ||
                        round($promABRFA, 1) == 9.0 || round($promABRFA, 1) == 10.0)

                        <b>{{round($promABRFA)}}</b>

                        @else
                        <b>{{round($promABRFA, 1)}}</b>
                        @endif
                      </td>

                      {{--  promedio mayo  --}}
                      <td align="center">
                        @if (round($promMAYFA, 1) == 1.0 || round($promMAYFA, 1) == 2.0 || round($promMAYFA, 1) == 3.0 || round($promMAYFA, 1) == 4.0 ||
                        round($promMAYFA, 1) == 5.0 || round($promMAYFA, 1) == 6.0 || round($promMAYFA, 1) == 7.0 || round($promMAYFA, 1) == 8.0 ||
                        round($promMAYFA, 1) == 9.0 || round($promMAYFA, 1) == 10.0)

                        <b>{{round($promMAYFA)}}</b>

                        @else
                        <b>{{round($promMAYFA, 1)}}</b>
                        @endif
                      </td>

                      {{--  promedio junio  --}}
                      <td align="center">
                        @if (round($promJUNFA, 1) == 1.0 || round($promJUNFA, 1) == 2.0 || round($promJUNFA, 1) == 3.0 || round($promJUNFA, 1) == 4.0 ||
                        round($promJUNFA, 1) == 5.0 || round($promJUNFA, 1) == 6.0 || round($promJUNFA, 1) == 7.0 || round($promJUNFA, 1) == 8.0 ||
                        round($promJUNFA, 1) == 9.0 || round($promJUNFA, 1) == 10.0)

                        <b>{{round($promJUNFA)}}</b>

                        @else
                        <b>{{round($promJUNFA, 1)}}</b>
                        @endif
                      </td>

                      {{--  promedio general tercer periodo   --}}
                      <td align="center">
                        @if (round($promedioGen3FA, 1) == 1.0 || round($promedioGen3FA, 1) == 2.0 || round($promedioGen3FA, 1) == 3.0 || round($promedioGen3FA, 1) == 4.0 ||
                        round($promedioGen3FA, 1) == 5.0 || round($promedioGen3FA, 1) == 6.0 || round($promedioGen3FA, 1) == 7.0 || round($promedioGen3FA, 1) == 8.0 ||
                        round($promedioGen3FA, 1) == 9.0 || round($promedioGen3FA, 1) == 10.0)

                        <b>{{round($promedioGen3FA)}}</b>

                        @else
                        <b>{{round($promedioGen3FA, 1)}}</b>
                        @endif
                      </td>
                      {{--  promedio general SEP tercer periodo   --}}
                      <td align="center"><b>{{$promedioGen3SEPFA}}</b></td>

                      <td align="center"><b>{{""}}</b></td>

                      {{--  promedio final de la sep   --}}
                      <td align="center">
                        @if (round($promedioFinalFA, 1) == 1.0 || round($promedioFinalFA, 1) == 2.0 || round($promedioFinalFA, 1) == 3.0 || round($promedioFinalFA, 1) == 4.0 ||
                        round($promedioFinalFA, 1) == 5.0 || round($promedioFinalFA, 1) == 6.0 || round($promedioFinalFA, 1) == 7.0 || round($promedioFinalFA, 1) == 8.0 ||
                        round($promedioFinalFA, 1) == 9.0 || round($promedioFinalFA, 1) == 10.0)

                        <b>{{round($promedioFinalFA)}}</b>

                        @else
                        <b>{{round($promedioFinalFA, 1)}}</b>
                        @endif
                      </td>
                      <td align="center">
                        @if (round($promedioFinalSEPFA, 1) == 1.0 || round($promedioFinalSEPFA, 1) == 2.0 || round($promedioFinalSEPFA, 1) == 3.0 || round($promedioFinalSEPFA, 1) == 4.0 ||
                        round($promedioFinalSEPFA, 1) == 5.0 || round($promedioFinalSEPFA, 1) == 6.0 || round($promedioFinalSEPFA, 1) == 7.0 || round($promedioFinalSEPFA, 1) == 8.0 ||
                        round($promedioFinalSEPFA, 1) == 9.0 || round($promedioFinalSEPFA, 1) == 10.0)

                        <b>{{round($promedioFinalSEPFA)}}</b>

                        @else
                        <b>{{round($promedioFinalSEPFA, 1)}}</b>
                        @endif
                      </td>


                      <td align="center"><b>{{""}}</b></td>
                    </tr>
              </tbody>
              </table>



              {{--  INASISTENCIAS  --}}
              <br>
              <table class="table table-bordered">
                <thead>

                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $inasistencia)
                    @if ($inasistencia->clave_pago == $clave_pago)
                     @php
                         $Keynasistencias++;
                     @endphp
                     @if ($Keynasistencias == 1)
                     <tr>
                      <td style="width: 200px;">INASISTENCIAS</td>
                      @if ($inasistencia->falTotalSep != "")
                        <td align="center" style="width: 25px;">{{$inasistencia->falTotalSep}}</td>
                      @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                      @endif

                      @if ($inasistencia->falTotalOct != "")
                        <td align="center" style="width: 25px;">{{$inasistencia->falTotalOct}}</td>
                      @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                      @endif

                      @if ($inasistencia->falTotalNov != "")
                        <td align="center" style="width: 25px;">{{$inasistencia->falTotalNov}}</td>
                      @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                      @if ($inasistencia->falTotalEne != "")
                        <td align="center" style="width: 28px;">{{$inasistencia->falTotalEne}}</td>
                      @else
                        <td align="center" style="width: 28px;"><label style="opacity: .01;">0</label></td>
                      @endif

                      @if ($inasistencia->falTotalFeb != "")
                        <td align="center" style="width: 25px;">{{$inasistencia->falTotalFeb}}</td>
                      @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                      @endif

                      @if ($inasistencia->falTotalMar != "")
                        <td align="center" style="width: 25px;">{{$inasistencia->falTotalMar}}</td>
                      @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                      @if ($inasistencia->falTotalAbr != "")
                        <td align="center" style="width: 28px;">{{$inasistencia->falTotalAbr}}</td>
                      @else
                        <td align="center" style="width: 28px;"><label style="opacity: .01;">0</label></td>
                      @endif

                      @if ($inasistencia->falTotalMay != "")
                        <td align="center" style="width: 29px;">{{$inasistencia->falTotalMay}}</td>
                      @else
                        <td align="center" style="width: 29px;"><label style="opacity: .01;">0</label></td>
                      @endif

                      @if ($inasistencia->falTotalJun != "")
                        <td align="center" style="width: 27px;">{{$inasistencia->falTotalJun}}</td>
                      @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      @php
                          $totalFaltas = $inasistencia->falTotalSep+
                          $inasistencia->falTotalOct + $inasistencia->falTotalNov+
                          $inasistencia->falTotalEne + $inasistencia->falTotalFeb +
                          $inasistencia->falTotalMar + $inasistencia->falTotalAbr +
                          $inasistencia->falTotalMay + $inasistencia->falTotalJun;
                      @endphp
                      <td align="center" style="width: 35px;">{{$totalFaltas}}</td> //total faltas
                      <td align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">{{""}}</td>
                      <td align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">{{""}}</td>
                    </tr>
                     @endif
                    @endif
                  @endforeach

                </tbody>
              </table>

          </div>
        </div>

        <br>
        <div class="row">
          <div class="columns medium-12">

          </div>
        </div>
            @endif
        @endif
    @endforeach

    @if ($loop->first)
    <footer id="footer">
      <div class="page-number"></div>
    </footer>
    @endif

    @if (!$loop->last)
      <div class="page_break"></div>
    @endif
    @php
        $key = 0;
        $keyMatFA = 0.0;
        $keyMatDESA = 0.0;
        $keyMatPROY = 0.0;
        $keyMatOPTA = 0.0;
        $keyPromedioGeneral = 0;
        $acd = 0;
        $Keynasistencias = 0;

        //hay que declarar mas variables, una por columna diferente y categoria
        //iniciarlas en 0.0

        $promSEPFA = 0.0;
        $promOCTFA = 0.0;
        $promNOVFA = 0.0;
        $promedioGen1FA = 0.0;
        $promedioGen1SEPFA = 0.0;
        $promDicEneFA = 0.0;
        $promFEBFA = 0.0;
        $promMARFA = 0.0;
        $promedioGen2FA = 0.0;
        $promedioGen2SEPFA = 0.0;
        $promABRFA = 0.0;
        $promMAYFA = 0.0;
        $promJUNFA = 0.0;
        $promedioGen3FA = 0.0;
        $promedioGen3SEPFA = 0.0;
        $promedioFinalFA = 0.0;
        $promedioFinalSEPFA = 0.0;

        $promSEPDESA = 0.0;
        $promOCTDESA = 0.0;
        $promNOVDESA = 0.0;
        $PromedioGen1DESA = 0.0;
        $PromedioGen1SEPDESA = 0.0;
        $promDICENEDESA = 0.0;
        $promFEBDESA = 0.0;
        $promMARDESA = 0.0;
        $PromedioGen2DESA = 0.0;
        $PromedioGen2SEPDESA = 0.0;
        $promABRDESA = 0.0;
        $promMAYDESA = 0.0;
        $promJUNDESA = 0.0;
        $PromedioGen3DESA = 0.0;
        $PromedioGen3SEPDESA = 0.0;
        $promedioFinalDESA = 0.0;
        $promedioFinalSEPDESA = 0.0;

        $sepArtis = 0.0;
        $octArtis = 0.0;
        $novArtis = 0.0;
        $genArtis1 = 0.0;
        $diceneArtis = 0.0;
        $febArtis = 0.0;
        $marArtis = 0.0;
        $genArtis2 = 0.0;
        $abrArtis = 0.0;
        $mayArtis = 0.0;
        $junArtis = 0.0;
        $genArtis3 = 0.0;
        $genFinalArtis = 0.0;

        $promSEPPROY = 0.0;
        $promSEPOPTA = 0.0;
        $promSEPGENERAL = 0.0;
        $promOCTGENERAL = 0.0;
        $promNOVGENERAL = 0.0;
        $promGENGENERAL1 = 0.0;
        $promDICENEGENERAL = 0.0;
        $promFEBGENERAL = 0.0;
        $promMARGENERAL = 0.0;
        $promGENGENERAL2 = 0.0;
        $promABRGENERAL = 0.0;
        $promMAYGENERAL = 0.0;
        $promJUNGENERAL = 0.0;
        $promGENGENERAL3 = 0.0;
        $promFINALGENERAL = 0.0;

    @endphp
@endforeach



  </body>
</html>
