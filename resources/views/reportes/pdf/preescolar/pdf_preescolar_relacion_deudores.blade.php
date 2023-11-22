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
        font-size: 9px;
        margin-top: 60px;
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
        position: fixed;
        top: -10px;
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




      .table {
        width: 100%;
      }

      .table {
        border-collapse: collapse;
      }

      .table th {
        border-bottom: 1px solid #000;
      }

       .table  th {
        padding-top: 0px;
        padding-bottom: 0px;
        padding-right: 5px;
        font-size: 10px;
      }

      .table td {
          padding-top: 5px;
          padding-bottom: 5px;
          padding-right: 5px;
          padding-left: 5px;
          font-size: 10px;
          border-bottom: 1px dotted #000;
          /** border-right: 1px dotted #000; **/
      }

      .page-number:before {
        content: "Pág " counter(page);
      }
      /** row columna triple Nivel o Escuela**/
      .ne-txt{
        width:66px;
      }
      .tcenter{
        text-align:center;
      }
      .tright{
        text-align:right;
      }

      .letraencabezado11{
          font-size:11px;
          margin-bottom: 3px;
      }

      .letraencabezado11bold{
          font-size:11px;
          margin-bottom: 3px;
          font-weight:bold;
      }

      .letraencabezado10{
          font-size:10px;
          margin-bottom: 3px;
      }
      .letraencabezado9{
          font-size:9px;
          margin-bottom: 3px;
      }
      .letraencabezado9bold{
          font-size:9px;
          margin-bottom: 3px;
          font-weight:bold;
      }

      .page-break {
          page-break-after: always;
      }
    </style>
	</head>


  <body>
      <header>
          <div class="row">
              <div class="columns medium-6">
                  <p class="letraencabezado11">ESCUELA MODELO S.C.P.</p>
                  <p class="letraencabezado11bold">{{$elTitulo}}</p>
                  <p class="letraencabezado11">{{$elMes}}</p>
                  <p class="letraencabezado11">{{$elPeriodo}}</p>
              </div>
              <div class="columns medium-6">
                  <div style="text-align: right;">
                      <p>{{ \Carbon\Carbon::parse($fechaActual)->format('d/m/Y') }}</p>
                      <p>{{$horaActual}}</p>
                      <p>{{$nombreArchivo}}</p>
                      <br>
                      <p class="letraencabezado11">{{$laUbicacion}}</p>

                  </div>
              </div>
          </div>
      </header>
<body>
      <div class="row">
            <div class="columns medium-12">
                {{-- dd($pagos) --}}
                <br>
                <p class="letraencabezado9bold">Los importes corresponden a los meses pendientes de pago.</p>
                <br>
                <table class="table">
                      @php
                        $deuNum = 0;
                      @endphp
                      <thead>
                          <tr>
                             <th style="width:10px;">Num</th>
                             <th style="width:10px;">Cve Pago</th>
                             <th style="width:80px;">Nombre del Alumno</th>
                             <th style="width:10px;">Pago</th>
                             <th style="width:10px;">Edo<br>Curso</th>
                             <th style="width:10px;">Prog</th>
                             <th style="width:10px;">Gdo</th>
                             <th style="width:10px;">Gpo</th>
                             <th style="width:10px;">Beca</th>
                             <th style="width:21px;">Insc</th>
                             <th style="width:21px;">Sep</th>
                             <th style="width:21px;">Oct</th>
                             <th style="width:21px;">Nov</th>
                             <th style="width:21px;">Dic</th>
                             <th style="width:21px;">Ene</th>
                             <th style="width:21px;">Feb</th>
                             <th style="width:21px;">Mar</th>
                             <th style="width:21px;">Abr</th>
                             <th style="width:21px;">May</th>
                             <th style="width:21px;">Jun</th>
                             <th style="width:21px;">Jul</th>
                             <th style="width:21px;">Ago</th>
                             <th style="width:10px;">Egre</th>
                          </tr>
                      </thead>

                      <tbody>
                                  @foreach($pagos as $item)
                                            @php
                                                $deuNum++;
                                                //$pago = $item->first();
                                            @endphp
                                             {{-- dd($item) --}}

                                             <tr>
                                                 <td style="width:10px;">{{$deuNum}}</td>
                                                 <td style="width:10px;">{{$item->cve_pago}}</td>
                                                 <td style="width:80px;">{{$item->alumno}}</td>
                                                 <td style="width:10px;">{{$item->plan_pago}}</td>
                                                 <td style="width:10px;">{{$item->cur_estado}}</td>
                                                 <td style="width:10px;">{{$item->cve_programa}}</td>
                                                 <td style="width:10px;">{{$item->grado}}</td>
                                                 <td style="width:10px;">{{$item->grupo}}</td>
                                                 <td style="width:10px;">{{$item->cur_tipo_por_beca}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve99_xcobrar) ? ' ' :number_format((float)$item->cve99_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve01_xcobrar) ? ' ' :number_format((float)$item->cve01_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve02_xcobrar) ? ' ' :number_format((float)$item->cve02_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve03_xcobrar) ? ' ' :number_format((float)$item->cve03_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve04_xcobrar) ? ' ' :number_format((float)$item->cve04_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve05_xcobrar) ? ' ' :number_format((float)$item->cve05_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve06_xcobrar) ? ' ' :number_format((float)$item->cve06_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve07_xcobrar) ? ' ' :number_format((float)$item->cve07_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve08_xcobrar) ? ' ' :number_format((float)$item->cve08_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve09_xcobrar) ? ' ' :number_format((float)$item->cve09_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve10_xcobrar) ? ' ' :number_format((float)$item->cve10_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve11_xcobrar) ? ' ' :number_format((float)$item->cve11_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{ empty($item->cve12_xcobrar) ? ' ' :number_format((float)$item->cve12_xcobrar, 2, '.', ',')}}</td>
                                                 <td style="width:21px;">{{$item->alu_estado}}</td>
                                             </tr>
                                  @endforeach
                                  <!-- FIN foreach -->
                      </tbody>
              </table>

            </div>
          </div>
  </body>
      <footer>
          <div>
              <span class="page-number"></span>
          </div>
      </footer>

    </body>


</html>