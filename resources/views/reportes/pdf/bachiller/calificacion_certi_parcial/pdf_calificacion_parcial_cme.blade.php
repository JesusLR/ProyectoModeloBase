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
        /*font-family: 'sans-serif';*/
        font-family: 'courier new';
        font-size: 12px;
        margin-top: -10px;
        margin-left: 50px;
        margin-right: 50px;
        margin-bottom: 80px;
      }
      .row {
        width:100%;
        display: block;
        position: relative;
        /* margin-left: -30px; */
        /* margin-right: -30px; */
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
      }
      .inicio-pagina{
        margin-top: 0;
        display: block;
      }
      @page {
        margin-left: 0.5cm;
        margin-right: 0.5cm;
        margin-top: 180px;
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

    @php
    $contarMaterias = 0;
    $contarCalificacion = 0;
    $contarMateriasTotales = 0;
    $contarCalificacionTotales = 0;
    $credAprob = 0;
    $credCur = 0;
    $credAprobTotal = 0;
    $credCurTotal = 0;
    $calificacion_minima = $departamento->depCalMinAprob;
    @endphp

    <div class="row">
      <p style="text-align: center;">CLAVE DEL CENTRO DE TRABAJO: 31PBH0014O</p>
      <br>
      <div class="columns medium-12">
        <p style="font-size: 13px; text-align: center; margin-bottom: 10px;">No: {{$minutario->id}}</p>
        <p style="text-align: right;">Matrícula UADY: {{$alumno['matricula']}}</p>
        <p>A QUIÉN CORRESPONDA:</p>
          <br><br>
        <p align="justify" style="text-indent: 40px;">
          La que suscribe, Lic. en Psic. María Inés Sauri Quintal, Secretaria Administrativa
          de la Preparatoria "ESCUELA MODELO" incorporada a la Universidad
          Autónoma de Yucatán, hago constar que {{$alumno['pronombre']}} joven <b>{{$alumno['nombreCompleto']}}</b> {{$es_fue}}
          {{$alumno['alumnx']}} del
          @if ($leyenda == "SEMESTRE")
          {{$alumno['gradoLetras']}} semestre
          @else
            {{$curso_perteneciente}}
          @endif

          de BACHILLERATO en el ciclo escolar {{$ciclo_escolar}} y ha obtenido las siguientes
          calificaciones{{$mensaje}}
        </p>
        <br>
        <br>

      </div>
    </div>
    <div class="row">
      <div class="columns medium-4">
        <p><b>ASIGNATURAS</b></p>
      </div>
      <div class="columns medium-4">
      </div>
      <div class="columns medium-4">
        <p><span style="float:right;">CALIFICACIONES</span></p>
      </div>
    </div>
    <div class="row">
      <div class="columns medium-12">
        {{--  <p><b>ASIGNATURAS</b> <span style="float:right;">CALIFICACIONES</span></p>  --}}

        @foreach ($semestres as $semestre)
          @php
            $info_semestre = $semestre->first();
            $cicloSemestre = $info_semestre["cicloSemestre"];
          @endphp

          <p align="justify">SEMESTRE {{$info_semestre["grado"]}}: {{$cicloSemestre}}</p>

          @foreach ($semestre as $materia)
            @php
              $esNumerica = $materia['matTipoAcreditacion'] == 'N';
              $esAprobada = $materia['histCalificacion'] >= $calificacion_minima;
              $font_weight = (($esNumerica && $esAprobada) || !$esNumerica) ? 'normal' : 'bold';
            @endphp
            <div style="padding:0 0 0 30px;">
              <span @if ($materia['es_revalidacion'] == "RV") style="position: absolute; left:615px; font-weight:normal;" @else style="position: absolute; left:615px; font-weight:{{$font_weight}};"  @endif>
                @if ($materia['es_revalidacion'] == "RV")
                    Rev
                @else
                {{$materia['histCalificacion']}}
                @endif
              </span>
              {{$materia['matNombre']}}
            </div>
            @php
              if(!in_array($materia['histCalificacion'], ['Apr', 'No Apr', 'S/D', 'Npa'])) {

                $contarMaterias++;
                $contarMateriasTotales++;

                if(intval($materia['histCalificacion'])) {
                  $contarCalificacion += $materia['histCalificacion'];
                  $contarCalificacionTotales+=$materia['histCalificacion'];
                }
              }

              if ($esAprobada) {
                $credAprob+=$materia['matCreditos'];
                $credAprobTotal+=$materia['matCreditos'];
              }
              $credCur+=$materia['matCreditos'];
              $credCurTotal+=$materia['matCreditos'];
            @endphp
          @endforeach {{-- foreach materia --}}
          <div><span style="float:right; font-weight:normal;">CRED.APROB. DEL PERIODO : {{$credAprob}} DE {{$credCur}}</span> PROMEDIO DEL PERIODO : {{number_format($contarCalificacion/$contarMaterias,4)}}  </div>
          @php
            $contarMaterias = 0;
            $contarCalificacion = 0;
            $credAprob = 0;
            $credCur = 0;
          @endphp
          {{-- En la primer página deben haber 3 semestres. A partir de la segunda, 4 semestres por página --}}
          @if($loop->iteration == 1)
            <div class="page_break"></div>
          @elseif($loop->iteration > 4 && $loop->iteration % 3 == 1 && !$loop->last)
            <div class="page_break"></div>
          @endif
          <br>
        @endforeach {{-- foreach semestre --}}
        <div>
          <p style="float:left; font-weight:normal;"> PROMEDIO GENERAL : {{number_format($contarCalificacionTotales/$contarMateriasTotales,4)}}</p><p style="float:right; font-weight:normal;">CRED.APROB. GENERAL : {{$credAprobTotal}} DE {{$credCurTotal}}</p></div>
          <br>
          <p>Calificación mínima para aprobar una asignatura: {{$calificacion_minima}}</p>
          <br>
          <p align="justify">Y para los fines que le sean convenientes, se expide la presente constancia
            en la ciudad de {{$municipio->munNombre}} {{$estado->edoNombre}}, a los {{$fechaDeHoy}}.
          </p>

          <br>
          <p align="center">ATENTAMENTE</p>
          <br><br>
          <p align="center">Lic. en Psic. María Inés Sauri Quintal
          <br>
          Secretaria Administrativa</p>
          <p>{{$alumno['clave']}}</p>
        </div>
      </div>
    </div>
  </body>
</html>
