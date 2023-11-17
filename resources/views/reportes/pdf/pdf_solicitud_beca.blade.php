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
        font-family: 'sans-serif';
        font-size: 12px;
        margin:3.5cm 1cm .5cm 1.5cm;
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
    </style>
	</head>
  
  <header>
    @php
      use App\Http\Helpers\Utils;
      use App\clases\historicos\MetodosHistoricos;
      $totalPeriodos = count($historicos);
      $introduccion = 'Quien suscribe';
      switch ($firmante->firSexo) {
        case 'F':
          $introduccion = 'La que suscribe';
          break;
        case 'M':
          $introduccion = 'El que suscribe';
          break;
        default:
          $introduccion = 'Quien suscribe';
          break;
      }
    @endphp
    
  </header>
  <body>
    @php
      $el_la = ($persona->perSexo == 'M') ? 'El' : 'La';
      $alumnx = ($persona->perSexo == 'M') ? 'alumno' : 'alumna';
    @endphp
    
      <div class="row">
        <p align="center">No. {{$minutario->id}}</p>
      </div>
      <div class="row">
        <br></br>
        <br></br>
        <p>
          A QUIEN CORRESPONDA:
        </p>
        <br>
        <p>
          {{$introduccion}}, {{$firmante->firNombre}}, {{$firmante->firPuesto}}
          de la UNIVERSIDAD MODELO con clave de incorporación {{$depClaveOficial}} hace constar
          que:
        </p>
        <br>
        <p>
          {{$el_la}} Joven {{$nombreCompleto}} es {{$alumnx}} de {{$semestre}} semestre de {{$progNombre}}
          en el ciclo escolar de {{Utils::fecha_string($periodo->perFechaInicial)}} al 
          {{Utils::fecha_string($periodo->perFechaFinal)}}
          @if($totalPeriodos == 1)
              y ha obtenido en el último semestre las siguientes calificaciones.
          @endif
          @if($totalPeriodos > 1)
              y ha obtenido en los últimos semestres las siguientes calificaciones.
          @endif
        </p>

        @if($totalPeriodos > 0)
          @php 
            $sumaTotal = 0;
            $promTotal = 0;
            $numeroPromedios = 0;
          @endphp
          <table style="font-size:11px;">
            <thead>
              <tr>
                <th colspan="2" style="text-align:center;">ASIGNATURAS</th>
                <th style="text-align:center;">CALIFICACIONES</th>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
            </thead>
            <tbody>
              @foreach($historicos as $perAnterior)
               @php
               $dato1 = $perAnterior->first();
               $p1 = $dato1->periodo;
               $perFechaInicial = Utils::fecha_string($p1->perFechaInicial);
               $perFechaFinal = Utils::fecha_string($p1->perFechaFinal);
               $periodoSuma = 0;
               $numeroMaterias = 0;
               $promPeriodo = 0;
               @endphp
               <tr>
                 <td>PERIODO:</td>
                 <td style="width:200px;">
                   {{$perFechaInicial}} al {{$perFechaFinal}}
                 </td>
                 <td></td>
               </tr>
               @foreach($perAnterior as $historico)
                @php
                  $materia = $historico->materia;
                  $histCalificacion = MetodosHistoricos::definirCalificacion($historico, $materia);
                  $matNombre = $materia->matNombre;
                  $matComplementoNombre = null;
                  if($historico->histComplementoNombre){
                    $matComplementoNombre = ' - '.$historico->histComplementoNombre;
                  }
                  $materiaNombre = $matNombre.$matComplementoNombre;
                @endphp
                <tr>
                  <td></td>
                  <td>{{$materiaNombre}}</td>
                  <td style="text-align:center;">{{$histCalificacion}}</td>
                  @if($materia->esNumerica())
                    @php
                      $periodoSuma = $periodoSuma + $histCalificacion;
                      $numeroMaterias++;
                    @endphp
                  @endif
                </tr>
               @endforeach<!-- historico -->
               @php
                  $promPeriodo = $periodoSuma / $numeroMaterias;
               @endphp
               <tr>
                 <td colspan="2">PROMEDIO DEL PERIODO:</td>
                 <td style="text-align:center;">{{number_format($promPeriodo,4)}}</td>
               </tr>
               <tr>
                 <td colspan="3">&nbsp;</td>
               </tr>
               @php
                $sumaTotal = $sumaTotal + $promPeriodo;
                $numeroPromedios++;
               @endphp
              @endforeach <!-- perAnterior -->
              @if($totalPeriodos > 1)
                @php
                  $promTotal = $sumaTotal / $numeroPromedios;
                @endphp
                <tr>
                  <td colspan="3"></td>
                </tr>
                <tr>
                  <td colspan="2">PROMEDIO DOS PERIODOS</td>
                  <td style="text-align:center;">{{number_format($promTotal,4)}}</td>
                </tr>
              @endif
            </tbody>
          </table>
        @endif

        <br>
        <p>
          Y para los fines que le sean convenientes, se expide la presente constancia
          en la ciudad de {{$municipio->munNombre}}, {{$municipio->estado->edoNombre}}, 
          a los {{$fechaActual->day}} dias del mes de 
          {{ucwords(Utils::num_meses_string($fechaActual->month))}} de 
          {{$fechaActual->year}}.
        </p>
        <br>
        <br>
        <p align="center">ATENTAMENTE</p>
        <br>
        <br>
         <p align="center">______________________________________________</p>
         <p align="center">{{$firmante->firNombre}}</p>
         <p align="center">{{$firmante->firPuesto}}</p>
         <p>{{$alumno->aluClave}}</p>
      </div>
  </body>
  <footer>
  </footer>
    
</html>