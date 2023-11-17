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
        margin-top: 70px;
        margin-bottom: 70px;
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
    @php
      $grupo = $grupo = ($grupos)->first();
      $grupo = $grupo ? $grupo->first(): []
    @endphp
    <header>
      <div class="row">
        <div class="columns medium-6">
          <h5 style="margin-top:0px; margin-bottom: 10px;">SECUNDARIA "MODELO"</h5>
          <h5 style="margin-top:0px; margin-bottom: 10px;">GRUPOS POR GRADO (HORARIOS)</h5>
        </div>
        <div class="columns medium-6">
          <div style="text-align: right;">
            <p>{{ \Carbon\Carbon::parse($fechaActual)->format('d/m/Y') }}</p>
            <p>{{$horaActual}}</p>
            <p>{{$nombreArchivo}}</p>
          </div>
        </div>
      </div>

      <div class="row" style="margin-bottom: 2px;">
        <div class="columns medium-12">
          <p>
            @if ($grupo)
              Período : {{\Carbon\Carbon::parse($grupo["secundaria_grupo"]["periodo"]["perFechaInicial"])->day
                .'/'. \Carbon\Carbon::parse($grupo["secundaria_grupo"]["periodo"]["perFechaInicial"])->formatLocalized('%b')
                .'/'. \Carbon\Carbon::parse($grupo["secundaria_grupo"]["periodo"]["perFechaInicial"])->year
                .'-'. \Carbon\Carbon::parse($grupo["secundaria_grupo"]["periodo"]["perFechaFinal"])->day
                .'/'. \Carbon\Carbon::parse($grupo["secundaria_grupo"]["periodo"]["perFechaFinal"])->formatLocalized('%b')
                .'/'. \Carbon\Carbon::parse($grupo["secundaria_grupo"]["periodo"]["perFechaFinal"])->year}}
            @endif
          </p>
        </div>
      </div>

      <div class="row" style="margin-bottom: 2px">
        <div class="columns medium-12">
          @if($grupo)
            <p>Nivel : {{$grupo["secundaria_grupo"]["plan"]["programa"]["progClave"]}} {{strtoupper($grupo["secundaria_grupo"]["plan"]["programa"]["progNombre"])}}</p>
          @endif
        </div>
      </div>

      <div class="row">
        <div class="columns medium-12">
          @if($grupo)
            <p>Ubicac. : {{$grupo["secundaria_grupo"]["plan"]["programa"]["escuela"]["departamento"]["ubicacion"]["ubiClave"] ?
                $grupo["secundaria_grupo"]["plan"]["programa"]["escuela"]["departamento"]["ubicacion"]["ubiClave"]: "" }} 
              {{$grupo["secundaria_grupo"]["plan"]["programa"]["escuela"]["departamento"]["ubicacion"]["ubiNombre"] ?
                $grupo["secundaria_grupo"]["plan"]["programa"]["escuela"]["departamento"]["ubicacion"]["ubiNombre"]: ""}}
            </p>
          @endif
        </div>
      </div>
    </header>
   
    @foreach ($grupos as $grupo)
      @php
        $grupo = $grupo->sortBy('sortGrupoClaveMat');
      @endphp
      <div class="row" style="margin-top: 20px;">
        <div class="columns medium-12">
          <p>Grado : {{App\Http\Helpers\Utils::semestres_numeracion_ordinal($grupo->first()["secundaria_grupo"]['gpoGrado'])}}</p>
        </div>
      </div>
      <div class="row">
        <div class="columns medium-12">
          <table class="table">
            <tr>
              <th style="font-weight: 400;">Cve. Mat</th>
              <th align="center" style="font-weight: 400;">Nombre Materia</th>
              <th align="center" style="font-weight: 400;">Gpo</th>
              <th align="center" style="font-weight: 400;">Tur</th>
              <th align="center" style="font-weight: 400;">Fech.Ex.Ord</th>
              <th style="font-weight: 400; width: 35px;">Lun</th>
              <th style="font-weight: 400; width: 20px;">Aul</th>
              <th style="font-weight: 400; width: 35px;">Mar</th>
              <th style="font-weight: 400; width: 20px;">Aul</th>
              <th style="font-weight: 400; width: 35px;">Mie</th>
              <th style="font-weight: 400; width: 20px;">Aul</th>
              <th style="font-weight: 400; width: 35px;">Jue</th>
              <th style="font-weight: 400; width: 20px;">Aul</th>
              <th style="font-weight: 400; width: 35px;">Vie</th>
              <th style="font-weight: 400; width: 20px;">Aul</th>
              <th style="font-weight: 400; width: 35px;">Sab</th>
              <th style="font-weight: 400; width: 20px;">Aul</th>
              <th align="center" style="font-weight: 400; width: 35px;">Ins</th>
            </tr>

            @php
              $grupo = collect($grupo)->groupBy("grupo_id");
            @endphp
            @foreach ($grupo as $materia)
              <tr>
                <td style="width: 50px;">{{$materia->first()["secundaria_grupo"]["secundaria_materia"]["matClave"]}}</td>
                <td style="width: 150px;">{{$materia->first()["secundaria_grupo"]["secundaria_materia"]["matNombre"]}}</td>
                <td align="center" style="width: 20px;">{{$materia->first()["secundaria_grupo"]["gpoClave"]}}</td>

                @if ($materia->first()["secundaria_grupo"]["gpoTurno"] != "")
                <td align="center" style="width: 20px;">{{$materia->first()["secundaria_grupo"]["gpoTurno"]}}</td>
                @else
                <td style="width: 20px;"><label style="opacity: .01;">0</label></td>
                @endif

                <td style="width: 30px;">
                  {{\Carbon\Carbon::parse($materia->first()["secundaria_grupo"]["gpoFechaExamenOrdinario"])->day
                  .'/'. \Carbon\Carbon::parse($materia->first()["secundaria_grupo"]["gpoFechaExamenOrdinario"])->formatLocalized('%b')
                  .'/'. \Carbon\Carbon::parse($materia->first()["secundaria_grupo"]["gpoFechaExamenOrdinario"])->year}}
                </td>

                @php
                  $lunes = $materia->where('ghDia', 1)->first();
                  $martes = $materia->where('ghDia', 2)->first();
                  $miercoles = $materia->where('ghDia', 3)->first();
                  $jueves = $materia->where('ghDia', 4)->first();
                  $viernes = $materia->where('ghDia', 5)->first();
                  $sabado = $materia->where('ghDia', 6)->first();
                @endphp
                <td style="width: 35px;">{{$lunes ? $lunes["ghInicio"]."-".$lunes["ghFinal"]: "" }}</td>
                <td style="width: 20px; font-size: 10px;">{{$lunes ? $lunes["aula"]["aulaClave"]: ""}}</td>
                <td style="width: 35px;">{{$martes ? $martes["ghInicio"]."-".$martes["ghFinal"]: "" }}</td>
                <td style="width: 20px; font-size: 10px;">{{$martes ? $martes["aula"]["aulaClave"]: ""}}</td>
                <td style="width: 35px;">{{$miercoles ? $miercoles["ghInicio"]."-".$miercoles["ghFinal"]: "" }}</td>
                <td style="width: 20px; font-size: 10px;">{{$miercoles ? $miercoles["aula"]["aulaClave"]: ""}}</td>
                <td style="width: 35px;">{{$jueves ? $jueves["ghInicio"]."-".$jueves["ghFinal"]: "" }}</td>
                <td style="width: 20px; font-size: 10px;">{{$jueves ? $jueves["aula"]["aulaClave"]: ""}}</td>
                <td style="width: 35px;">{{$viernes ? $viernes["ghInicio"]."-".$viernes["ghFinal"]: "" }}</td>
                <td style="width: 20px; font-size: 10px;">{{$viernes ? $viernes["aula"]["aulaClave"]: ""}}</td>
                <td style="width: 35px;">{{$sabado ? $sabado["ghInicio"]."-".$sabado["ghFinal"]: "" }}</td>
                <td style="width: 20px; font-size: 10px;">{{$sabado ? $sabado["aula"]["aulaClave"]: ""}}</td>
                <td align="center">{{$materia->first()["cantidadAlumnos"]}}</td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
      @if ($loop->first)
        <footer id="footer">
          <div class="page-number"></div>
        </footer>
      @endif
    @endforeach

    <footer id="footer">
      <div class="page-number"></div>
    </footer>
  </body>
</html>