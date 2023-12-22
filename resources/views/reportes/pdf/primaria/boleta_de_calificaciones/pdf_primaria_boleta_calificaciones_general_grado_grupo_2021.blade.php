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
        margin-top: 80px;  /* ALTURA HEADER */
        margin-left: 14px;
        margin-right: 14px;
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
        top: -35px;
        right: 0px;
        height: 3px;
        /** Extra personal styles **/

        margin-left: 5px;
        margin-right: 5px;
      }

      #watermark { position: fixed; top: 15%; left: 0;  width: 700px; height: 700px; opacity: .3; }
      .img-header{
        height: 90px;
        float: left;
      }

      .img-foto{
        height: 110px;
        float: right;
        margin-top: -100px;
        border: 2px solid #0e2e42;


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
  @php
  use App\Http\Helpers\TruncarDecimales;
  @endphp
  <body>

  <header>
      <div class="row" style="margin-top: 0px;">
          <div class="columns medium-12">

            <img class="img-header"  src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">

            <h1 style="margin-top:0px; margin-bottom: 0px; text-align: center;">ESCUELA MODELO</h1>
            <h1 style="margin-top:0px; margin-bottom: 0px; text-align: center;">
              @if ($parametro_tipo == "PRB")
              Primaria (Bilingüe)
              @else
              Primaria
              @endif

            </h1>
            <h2 style="margin-top:0px; margin-bottom: 0px; text-align: center;">Clave 31PPR0097X</h2>
            <h2 style="margin-top:0px; margin-bottom: 0px; text-align: center;">{{$cicloEscolar}}</h2>

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

  $faltasSep = 0;
  $faltasOct = 0;
  $faltasNov = 0;
  $faltasEne = 0;
  $faltasFeb = 0;
  $faltasMar = 0;
  $faltasAbr = 0;
  $faltasMay = 0;
  $faltasJun = 0;

  $sumaComputacionConductaSep  = 0.0;
  $sumaComputacionConductaOct  = 0.0;
  $sumaComputacionConductaNov  = 0.0;
  $sumaComputacionConductaEne  = 0.0;
  $sumaComputacionConductaFeb  = 0.0;
  $sumaComputacionConductaMar  = 0.0;
  $sumaComputacionConductaAbr  = 0.0;
  $sumaComputacionConductaMay  = 0.0;
  $sumaComputacionConductaJun  = 0.0;

  $totalMaterias = 0;
  $sumaPromediosFASep = 0.0;
  $sumaPromediosFAOct = 0.0;
  $sumaPromediosFANov = 0.0;
  $sumaPromediosFADic = 0.0;
  $sumaPromediosFAEne = 0.0;
  $sumaPromediosFAFeb = 0.0;
  $sumaPromediosFAMar = 0.0;
  $sumaPromediosFAAbr = 0.0;
  $sumaPromediosFAMay = 0.0;
  $sumaPromediosFAJun = 0.0;

  $sumaPromediosDESASep = 0.0;
  $sumaPromediosDESAOct = 0.0;
  $sumaPromediosDESANov = 0.0;
  $sumaPromediosDESADic = 0.0;
  $sumaPromediosDESAEne = 0.0;
  $sumaPromediosDESAFeb = 0.0;
  $sumaPromediosDESAMar = 0.0;
  $sumaPromediosDESAAbr = 0.0;
  $sumaPromediosDESAMay = 0.0;
  $sumaPromediosDESAJun = 0.0;


  $sumaPromediosOPTASep = 0.0;
  $sumaPromediosOPTAOct = 0.0;
  $sumaPromediosOPTANov = 0.0;
  $sumaPromediosOPTADic = 0.0;
  $sumaPromediosOPTAEne = 0.0;
  $sumaPromediosOPTAFeb = 0.0;
  $sumaPromediosOPTAMar = 0.0;
  $sumaPromediosOPTAAbr = 0.0;
  $sumaPromediosOPTAMay = 0.0;
  $sumaPromediosOPTAJun = 0.0;

  $sumaPromedio1FA = 0.0;
  $sumaPromedio2FA = 0.0;
  $sumaPromedio3FA = 0.0;
  $sumaPromedioFinalFA = 0.0;

  $sumaPromedio1DESA = 0.0;
  $sumaPromedio2DESA = 0.0;
  $sumaPromedio3DESA = 0.0;
  $sumaPromedioFinalDESA = 0.0;

  $sumaPromedio1OPTA = 0.0;
  $sumaPromedio2OPTA = 0.0;
  $sumaPromedio3OPTA = 0.0;
  $sumaPromedioFinalOPTA = 0.0;
@endphp

@foreach ($alumnoAgrupado as $clave_pago => $valores)
    @foreach ($calificaciones as $inscrito)
        @if ($inscrito->clave_pago == $clave_pago)


        {{--  llave del 1 hasta donde llege y se sepite el ciclo  --}}
        @php
            $key++;
        @endphp
            @if ($key == 1)

            <br>
            <div class="row">
              <div class="columns medium-4">
                  <div style="text-align: left; font-size: 11px;">
                        <p >Clave:<b> {{$clave_pago}}</b></p>
                        <p >Alumno:<b> {{$inscrito->nombres}} {{$inscrito->ape_paterno}} {{$inscrito->ape_materno}}</b></p>
                  </div>
              </div>
              <div class="columns medium-4">
                  <div style="text-align: center; font-size: 11px;">
                      <p >Grupo:<b> {{$inscrito->gpoGrado}}{{$inscrito->gpoClave}}</b></p>
                      <p >Curp:<b> {{$inscrito->curp}}</b></p>
                  </div>
              </div>
              <div class="columns medium-4">
                  <div style="text-align: right; font-size: 11px;">
                      <p >Fecha: {{$fechaActual}}</p>
                      <p >Hora: {{ $horaActual}}</p>
                  </div>

                  @if ($inscrito->curPrimariaFoto != "")

                        @if (file_exists(base_path('storage/app/public/primaria/cursos/fotos/' . $inscrito->perAnioPago . '/' . $inscrito->curPrimariaFoto)))
                        <img class="img-foto" style="margin-top: -175px;text-aling:rigth" src="{{base_path('storage/app/public/primaria/cursos/fotos/' . $inscrito->perAnioPago . '/' . $inscrito->curPrimariaFoto) }}" alt="">

                        @else
                        <img class="img-foto"  src="" alt="">
                        @endif
              {{--  <br>
              <br>  --}}

              @else
              <img class="img-foto"  src="" alt="">
              @endif
              </div>

            </div>


            <br>
        <div class="row">
          <div class="columns medium-12">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th align="center" style=" width: 200px; border-top: 0px; border-right: 0px; border-bottom: 0px solid; border-left: 0px;"></th>
                          <th align="center" colspan="5" style="border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;">PRIMER PERIODO</th>
                          <th align="center" colspan="5" style="border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;">SEGUNDO PERIODO</th>
                          <th align="center" colspan="5" style="border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;">TERCER PERIODO</th>
                          <th align="center" colspan="2" style="border-top: 1px solid; border-right: 1px solid; border-bottom: 0px; border-left: 1px solid;">FINALES</th>
                      </tr>
                      <tr>
                          <th align="center" style=" width: 200px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"></th>
                          <th align="center" colspan="4" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 1px solid;"></th>
                          <th align="center" colspan="1" style="border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;">SEP</th>
                          <th align="center" colspan="4" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 1px solid;"></th>
                          <th align="center" colspan="1">SEP</th>
                          <th align="center" colspan="4" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 1px solid;"></th>
                          <th align="center" colspan="1">SEP</th>
                          <th align="center" colspan="1" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 1px solid;"></th>
                          <th align="center" colspan="1">SEP</th>
                      </tr>
                      <tr>
                          <th align="center" style=" width: 200px; border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;">ASIGNATURA</th>
                          <th align="center">SEP</th>
                          <th align="center">OCT</th>
                          <th align="center">NOV</th>
                          <th align="center">PROM</th>
                          <th align="center">PROM</th>
                          {{-- <th align="center">NIVEL</th> --}}
                          <th align="center">DIC-ENE</th>
                          <th align="center">FEB</th>
                          <th align="center">MAR</th>
                          <th align="center">PROM</th>
                          <th align="center">PROM</th>
                          {{-- <th align="center">NIVEL</th> --}}
                          <th align="center">ABR</th>
                          <th align="center">MAY</th>
                          <th align="center">JUN</th>
                          <th align="center">PROM</th>
                          <th align="center">PROM</th>
                          {{-- <th align="center">NIVEL</th> --}}
                          <th align="center">PROM</th>
                          <th align="center">PROM</th>
                          {{-- <th align="center">NIVEL</th> --}}
                      </tr>
                      <tr>
                        <th></th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($calificaciones as $key => $item)
                      @if ($item->clave_pago == $clave_pago)
                        @if ($item->matNombreEspecialidad == "FORMACIÓN ACADÉMICA")
                        <tr>
                          @php
                          $keyMatFA++;
                          $promSEPFA = $promSEPFA + $item->inscCalificacionSep;
                          $promOCTFA = $promOCTFA + $item->inscCalificacionOct;
                          $promNOVFA = $promNOVFA + $item->inscCalificacionNov;
                          $promedioGen1FA = $promedioGen1FA + $item->inscTrimestre1;
                          $promedioGen1SEPFA = $promedioGen1SEPFA + $item->inscTrimestre1SEP;
                          $promDicEneFA = $promDicEneFA + $item->inscCalificacionDicEnero;
                          $promFEBFA = $promFEBFA + $item->inscCalificacionFeb;
                          $promMARFA = $promMARFA + $item->inscCalificacionMar;
                          $promedioGen2FA = $promedioGen2FA + $item->inscTrimestre2;
                          $promedioGen2SEPFA = $promedioGen2SEPFA + $item->inscTrimestre2SEP;

                          $promABRFA = $promABRFA + $item->inscCalificacionAbr;
                          $promMAYFA = $promMAYFA + $item->inscCalificacionMay;
                          $promJUNFA = $promJUNFA + $item->inscCalificacionJun;
                          $promedioGen3FA = $promedioGen3FA + $item->inscTrimestre3;
                          $promedioGen3SEPFA = $promedioGen3SEPFA + $item->inscTrimestre3SEP;
                          $promedioFinalFA = $promedioFinalFA + $item->inscPromedioTrimCALCULADO;
                          $promedioFinalSEPFA = $promedioFinalSEPFA + $item->inscPromedioTrimCALCULADOSEP;

                          $matEspecialidad = $item->matEspecialidad;

                          #sumar los promedios para usarlo en la tabla de PROMEDIO GENERAL
                          $sumaPromediosFASep = $sumaPromediosFASep + $item->inscCalificacionSep;
                          $sumaPromediosFAOct = $sumaPromediosFAOct + $item->inscCalificacionOct;
                          $sumaPromediosFANov = $sumaPromediosFANov + $item->inscCalificacionNov;
                          $sumaPromediosFAEne = $sumaPromediosFAEne + $item->inscCalificacionDicEnero;
                          $sumaPromediosFAFeb = $sumaPromediosFAFeb + $item->inscCalificacionFeb;
                          $sumaPromediosFAMar = $sumaPromediosFAMar + $item->inscCalificacionMar;
                          $sumaPromediosFAAbr = $sumaPromediosFAAbr + $item->inscCalificacionAbr;
                          $sumaPromediosFAMay = $sumaPromediosFAMay + $item->inscCalificacionMay;
                          $sumaPromediosFAJun = $sumaPromediosFAJun + $item->inscCalificacionJun;

                          $sumaPromedio1FA  = $sumaPromedio1FA  + $item->inscTrimestre1;
                          $sumaPromedio2FA  = $sumaPromedio2FA  + $item->inscTrimestre2;
                          $sumaPromedio3FA  = $sumaPromedio3FA  + $item->inscTrimestre3;
                          $sumaPromedioFinalFA = $sumaPromedioFinalFA + $item->inscPromedioTrimCALCULADO;

                          @endphp
                          <td style="width: 200px;">{{$item->matNombreOficial}}</td>

                          <td align="center">
                            @if ($item->inscCalificacionSep != "")
                              @if ($item->inscCalificacionSep == 1.0 || $item->inscCalificacionSep == 2.0 || $item->inscCalificacionSep == 3.0
                              || $item->inscCalificacionSep == 4.0 ||
                              $item->inscCalificacionSep == 5.0 || $item->inscCalificacionSep == 6.0 || $item->inscCalificacionSep == 7.0 ||
                              $item->inscCalificacionSep == 8.0 ||
                              $item->inscCalificacionSep == 9.0 || $item->inscCalificacionSep == 10.0)

                              {{number_format((float)$item->inscCalificacionSep, 0, '.', '')}}

                              @else
                              {{$item->inscCalificacionSep}}
                              @endif
                            @else

                            @endif
                          </td>

                          <td align="center">
                            @if ($item->inscCalificacionOct != "")
                              @if ($item->inscCalificacionOct == 1.0 || $item->inscCalificacionOct == 2.0 || $item->inscCalificacionOct == 3.0
                                || $item->inscCalificacionOct == 4.0 ||
                                $item->inscCalificacionOct == 5.0 || $item->inscCalificacionOct == 6.0 || $item->inscCalificacionOct == 7.0 ||
                                $item->inscCalificacionOct == 8.0 ||
                                $item->inscCalificacionOct == 9.0 || $item->inscCalificacionOct == 10.0)

                                {{number_format((float)$item->inscCalificacionOct, 0, '.', '')}}

                                @else
                                {{--  {{number_format((float)$item->inscCalificacionOct, 1, '.', '')}}  --}}
                                {{$item->inscCalificacionOct}}
                                @endif
                            @else

                            @endif
                          </td>

                          <td align="center">
                            @if ($item->inscCalificacionNov != "")
                                @if ($item->inscCalificacionNov == 1.0 || $item->inscCalificacionNov == 2.0 || $item->inscCalificacionNov == 3.0
                                || $item->inscCalificacionNov == 4.0 ||
                                $item->inscCalificacionNov == 5.0 || $item->inscCalificacionNov == 6.0 || $item->inscCalificacionNov == 7.0 ||
                                $item->inscCalificacionNov == 8.0 ||
                                $item->inscCalificacionNov == 9.0 || $item->inscCalificacionNov == 10.0)

                                {{number_format((float)$item->inscCalificacionNov, 0, '.', '')}}

                                @else
                                {{--  {{number_format((float)$item->inscCalificacionNov, 1, '.', '')}}  --}}
                                {{$item->inscCalificacionNov}}
                                @endif
                            @else

                            @endif
                          </td>

                          {{--  promedio trimestree 1  --}}
                          <td align="center">
                            @if ($item->inscTrimestre1 != "")
                                {{$item->inscTrimestre1}}
                            @else

                            @endif
                          </td>
                          <td align="center">
                            @if ($item->inscTrimestre1SEP != "")
                                {{$item->inscTrimestre1SEP}}
                            @else

                            @endif
                          </td>

                          {{--  sacar el nivel   --}}
                          @php
                          $niv = "";
                          if ($item->matEspecialidad == "1FA") {
                              switch ($item->inscTrimestre1SEP) {
                                  case 1:
                                      $niv = "I";
                                      break;
                                  case 2:
                                      $niv = "II";
                                      break;
                                  case 3:
                                      $niv = "III";
                                      break;
                                  case 4:
                                      $niv = "IV";
                                      break;
                                  case 5:
                                      $niv = "I";
                                      break;
                                  case 6:
                                      $niv = "II";
                                      break;
                                  case 7:
                                      $niv = "II";
                                      break;
                                  case 8:
                                      $niv = "III";
                                      break;
                                  case 9:
                                      $niv = "III";
                                      break;
                                  case 10:
                                      $niv = "IV";
                              }
                          } else {
                              switch ($cal) {
                                  case 0:
                                      $niv = "";
                                      break;
                                  case 1:
                                      $niv = "1";
                                      break;
                                  case 2:
                                      $niv = "1";
                                      break;
                                  case 3:
                                      $niv = "1";
                                      break;
                                  case 4:
                                      $niv = "1";
                                      break;
                                  case 5:
                                      $niv = "1";
                                      break;
                                  case 6:
                                      $niv = "2";
                                      break;
                                  case 7:
                                      $niv = "2";
                                      break;
                                  case 8:
                                      $niv = "3";
                                      break;
                                  case 9:
                                      $niv = "3";
                                      break;
                                  case 10:
                                      $niv = "4";
                              }
                          }

                          @endphp

                          {{-- <td align="center">{{$niv}}</td> --}}

                          <td align="center">
                            @if ($item->inscCalificacionDicEnero)
                                @if ($item->inscCalificacionDicEnero == 1.0 || $item->inscCalificacionDicEnero == 2.0 || $item->inscCalificacionDicEnero == 3.0
                                || $item->inscCalificacionDicEnero == 4.0 ||
                                $item->inscCalificacionDicEnero == 5.0 || $item->inscCalificacionDicEnero == 6.0 || $item->inscCalificacionDicEnero == 7.0 ||
                                $item->inscCalificacionDicEnero == 8.0 ||
                                $item->inscCalificacionDicEnero == 9.0 || $item->inscCalificacionDicEnero == 10.0)

                                {{number_format((float)$item->inscCalificacionDicEnero, 0, '.', '')}}

                                @else
                                {{--  {{number_format((float)$item->inscCalificacionDicEnero, 1, '.', '')}}  --}}
                                {{$item->inscCalificacionDicEnero}}
                                @endif
                            @else

                            @endif
                          </td>

                          <td align="center">
                            @if ($item->inscCalificacionFeb)
                                @if ($item->inscCalificacionFeb == 1.0 || $item->inscCalificacionFeb == 2.0 || $item->inscCalificacionFeb == 3.0
                                || $item->inscCalificacionFeb == 4.0 ||
                                $item->inscCalificacionFeb == 5.0 || $item->inscCalificacionFeb == 6.0 || $item->inscCalificacionFeb == 7.0 ||
                                $item->inscCalificacionFeb == 8.0 ||
                                $item->inscCalificacionFeb == 9.0 || $item->inscCalificacionFeb == 10.0)

                                {{number_format((float)$item->inscCalificacionFeb, 0, '.', '')}}

                                @else
                                {{--  {{number_format((float)$item->inscCalificacionFeb, 1, '.', '')}}  --}}
                                {{$item->inscCalificacionFeb}}
                                @endif
                            @else

                            @endif
                          </td>

                          <td align="center">
                            @if ($item->inscCalificacionMar)
                                @if ($item->inscCalificacionMar == 1.0 || $item->inscCalificacionMar == 2.0 || $item->inscCalificacionMar == 3.0
                                || $item->inscCalificacionMar == 4.0 ||
                                $item->inscCalificacionMar == 5.0 || $item->inscCalificacionMar == 6.0 || $item->inscCalificacionMar == 7.0 ||
                                $item->inscCalificacionMar == 8.0 ||
                                $item->inscCalificacionMar == 9.0 || $item->inscCalificacionMar == 10.0)

                                {{number_format((float)$item->inscCalificacionMar, 0, '.', '')}}

                                @else
                                {{--  {{number_format((float)$item->inscCalificacionMar, 1, '.', '')}}  --}}
                                {{$item->inscCalificacionMar}}
                                @endif
                            @else

                            @endif
                          </td>

                          {{--  promedio trimestre 2   --}}
                          <td align="center">
                            <b>
                              @if ($item->inscTrimestre2 != "")
                                  {{$item->inscTrimestre2}}
                              @else

                              @endif

                              </b>
                          </td>
                          <td align="center">
                            @if ($item->inscTrimestre2SEP != "")
                                {{$item->inscTrimestre2SEP}}
                            @else

                            @endif
                          </td>

                          {{--  sacar el nivel perido 2  --}}
                          @php
                          $nivPerido2 = "";
                          if ($item->matEspecialidad == "1FA") {
                              switch ($item->inscTrimestre2SEP) {
                                  case 1:
                                      $nivPerido2 = "I";
                                      break;
                                  case 2:
                                      $nivPerido2 = "II";
                                      break;
                                  case 3:
                                      $nivPerido2 = "III";
                                      break;
                                  case 4:
                                      $nivPerido2 = "IV";
                                      break;
                                  case 5:
                                      $nivPerido2 = "I";
                                      break;
                                  case 6:
                                      $nivPerido2 = "II";
                                      break;
                                  case 7:
                                      $nivPerido2 = "II";
                                      break;
                                  case 8:
                                      $nivPerido2 = "III";
                                      break;
                                  case 9:
                                      $nivPerido2 = "III";
                                      break;
                                  case 10:
                                      $nivPerido2 = "IV";
                              }
                          } else {
                              switch ($cal) {
                                  case 0:
                                      $nivPerido2 = "";
                                      break;
                                  case 1:
                                      $nivPerido2 = "1";
                                      break;
                                  case 2:
                                      $nivPerido2 = "1";
                                      break;
                                  case 3:
                                      $nivPerido2 = "1";
                                      break;
                                  case 4:
                                      $nivPerido2 = "1";
                                      break;
                                  case 5:
                                      $nivPerido2 = "1";
                                      break;
                                  case 6:
                                      $nivPerido2 = "2";
                                      break;
                                  case 7:
                                      $nivPerido2 = "2";
                                      break;
                                  case 8:
                                      $nivPerido2 = "3";
                                      break;
                                  case 9:
                                      $nivPerido2 = "3";
                                      break;
                                  case 10:
                                      $nivPerido2 = "4";
                              }
                          }
                          @endphp
                          {{-- <td align="center">{{$nivPerido2}}</td> --}}
                          <td align="center">
                            @if ($item->inscCalificacionAbr != "")
                                @if ($item->inscCalificacionAbr == 1.0 || $item->inscCalificacionAbr == 2.0 || $item->inscCalificacionAbr == 3.0
                                || $item->inscCalificacionAbr == 4.0 ||
                                $item->inscCalificacionAbr == 5.0 || $item->inscCalificacionAbr == 6.0 || $item->inscCalificacionAbr == 7.0 ||
                                $item->inscCalificacionAbr == 8.0 ||
                                $item->inscCalificacionAbr == 9.0 || $item->inscCalificacionAbr == 10.0)

                                {{number_format((float)$item->inscCalificacionAbr, 0, '.', '')}}

                                @else
                                {{--  {{number_format((float)$item->inscCalificacionAbr, 1, '.', '')}}  --}}
                                {{$item->inscCalificacionAbr}}
                                @endif
                            @else

                            @endif
                          </td>
                          <td align="center">
                            @if ($item->inscCalificacionMay != "")
                              @if ($item->inscCalificacionMay == 1.0 || $item->inscCalificacionMay == 2.0 || $item->inscCalificacionMay == 3.0
                                || $item->inscCalificacionMay == 4.0 ||
                                $item->inscCalificacionMay == 5.0 || $item->inscCalificacionMay == 6.0 || $item->inscCalificacionMay == 7.0 ||
                                $item->inscCalificacionMay == 8.0 ||
                                $item->inscCalificacionMay == 9.0 || $item->inscCalificacionMay == 10.0)

                                {{number_format((float)$item->inscCalificacionMay, 0, '.', '')}}

                                @else
                                {{--  {{number_format((float)$item->inscCalificacionMay, 1, '.', '')}}  --}}
                                {{$item->inscCalificacionMay}}
                                @endif
                            @else

                            @endif
                          </td>
                          <td align="center">
                            @if ($item->inscCalificacionJun != "")
                              @if ($item->inscCalificacionJun == 1.0 || $item->inscCalificacionJun == 2.0 || $item->inscCalificacionJun == 3.0
                                || $item->inscCalificacionJun == 4.0 ||
                                $item->inscCalificacionJun == 5.0 || $item->inscCalificacionJun == 6.0 || $item->inscCalificacionJun == 7.0 ||
                                $item->inscCalificacionJun == 8.0 ||
                                $item->inscCalificacionJun == 9.0 || $item->inscCalificacionJun == 10.0)

                                {{number_format((float)$item->inscCalificacionJun, 0, '.', '')}}

                                @else
                                {{--  {{number_format((float)$item->inscCalificacionJun, 1, '.', '')}}  --}}
                                {{$item->inscCalificacionJun}}
                                @endif
                            @else

                            @endif
                          </td>

                          {{--  promedio trimestre 3   --}}
                          <td align="center">
                            @if ($item->inscTrimestre3 != "")
                                {{$item->inscTrimestre3}}
                            @else

                            @endif
                          </td>
                          <td align="center">
                            @if ($item->inscTrimestre3SEP != "")
                                {{$item->inscTrimestre3SEP}}
                            @else

                            @endif
                          </td>
                          {{--  sacar el nivel perido 2  --}}
                          @php
                          $nivPerido3 = "";
                          if ($item->matEspecialidad == "1FA") {
                              switch ($item->inscTrimestre3SEP) {
                                  case 1:
                                      $nivPerido3 = "I";
                                      break;
                                  case 2:
                                      $nivPerido3 = "II";
                                      break;
                                  case 3:
                                      $nivPerido3 = "III";
                                      break;
                                  case 4:
                                      $nivPerido3 = "IV";
                                      break;
                                  case 5:
                                      $nivPerido3 = "I";
                                      break;
                                  case 6:
                                      $nivPerido3 = "II";
                                      break;
                                  case 7:
                                      $nivPerido3 = "II";
                                      break;
                                  case 8:
                                      $nivPerido3 = "III";
                                      break;
                                  case 9:
                                      $nivPerido3 = "III";
                                      break;
                                  case 10:
                                      $nivPerido3 = "IV";
                              }
                          } else {
                              switch ($cal) {
                                  case 0:
                                      $nivPerido3 = "";
                                      break;
                                  case 1:
                                      $nivPerido3 = "1";
                                      break;
                                  case 2:
                                      $nivPerido3 = "1";
                                      break;
                                  case 3:
                                      $nivPerido3 = "1";
                                      break;
                                  case 4:
                                      $nivPerido3 = "1";
                                      break;
                                  case 5:
                                      $nivPerido3 = "1";
                                      break;
                                  case 6:
                                      $nivPerido3 = "2";
                                      break;
                                  case 7:
                                      $nivPerido3 = "2";
                                      break;
                                  case 8:
                                      $nivPerido3 = "3";
                                      break;
                                  case 9:
                                      $nivPerido3 = "3";
                                      break;
                                  case 10:
                                      $nivPerido3 = "4";
                              }
                          }
                          @endphp


                          {{-- <td align="center">{{$nivPerido3}}</td> --}}

                          {{--  promedio final   --}}
                          <td align="center">

                            @if ($item->inscTrimestre1 != "" && $item->inscTrimestre2 != "" && $item->inscTrimestre3 != "")
                              @if ($item->inscPromedioTrimCALCULADO != "")
                                {{$item->inscPromedioTrimCALCULADO}}
                              @else

                              @endif
                            @endif

                          </td>

                          {{--  promedio final sep   --}}
                          <td align="center">
                            @if ($item->inscTrimestre1 != "" && $item->inscTrimestre2 != "" && $item->inscTrimestre3 != "")
                              @if ($item->inscPromedioTrimCALCULADOSEP != "")
                                  {{$item->inscPromedioTrimCALCULADOSEP}}
                              @else

                              @endif
                            @endif
                          </td>
                          {{--  sacar el nivel perido 2  --}}
                          @php
                          $nivSEp = "";
                          if ($item->matEspecialidad == "1FA") {
                              switch ($item->inscPromedioTrimCALCULADOSEP) {
                                  case 1:
                                      $nivSEp = "I";
                                      break;
                                  case 2:
                                      $nivSEp = "II";
                                      break;
                                  case 3:
                                      $nivSEp = "III";
                                      break;
                                  case 4:
                                      $nivSEp = "IV";
                                      break;
                                  case 5:
                                      $nivSEp = "I";
                                      break;
                                  case 6:
                                      $nivSEp = "II";
                                      break;
                                  case 7:
                                      $nivSEp = "II";
                                      break;
                                  case 8:
                                      $nivSEp = "III";
                                      break;
                                  case 9:
                                      $nivSEp = "III";
                                      break;
                                  case 10:
                                      $nivSEp = "IV";
                              }
                          } else {
                              switch ($cal) {
                                  case 0:
                                      $nivSEp = "";
                                      break;
                                  case 1:
                                      $nivSEp = "1";
                                      break;
                                  case 2:
                                      $nivSEp = "1";
                                      break;
                                  case 3:
                                      $nivSEp = "1";
                                      break;
                                  case 4:
                                      $nivSEp = "1";
                                      break;
                                  case 5:
                                      $nivSEp = "1";
                                      break;
                                  case 6:
                                      $nivSEp = "2";
                                      break;
                                  case 7:
                                      $nivSEp = "2";
                                      break;
                                  case 8:
                                      $nivSEp = "3";
                                      break;
                                  case 9:
                                      $nivSEp = "3";
                                      break;
                                  case 10:
                                      $nivSEp = "4";
                              }
                          }
                          @endphp


                          {{-- <td align="center">{{$nivSEp}}</td> --}}
                        </tr>
                        @endif
                      @endif
                    @endforeach

                    @php

                            $promSEPFA = $promSEPFA/$keyMatFA;
                            $promOCTFA = $promOCTFA/$keyMatFA;
                            $promNOVFA = $promNOVFA/$keyMatFA;
                            $promedioGen1FA  = $promedioGen1FA/$keyMatFA;
                            $promedioGen1SEPFA = round($promedioGen1SEPFA/$keyMatFA, 1);
                            $promDicEneFA = $promDicEneFA/$keyMatFA;
                            $promFEBFA = $promFEBFA/$keyMatFA;
                            $promMARFA = $promMARFA/$keyMatFA;
                            $promedioGen2FA = $promedioGen2FA/$keyMatFA;
                            $promedioGen2SEPFA = round($promedioGen2SEPFA/$keyMatFA, 1);
                            $promABRFA = $promABRFA/$keyMatFA;
                            $promMAYFA = $promMAYFA/$keyMatFA;
                            $promJUNFA = $promJUNFA/$keyMatFA;
                            $promedioGen3FA = $promedioGen3FA/$keyMatFA;
                            $promedioGen3SEPFA = round($promedioGen3SEPFA/$keyMatFA, 1);
                            $promedioFinalFA = $promedioFinalFA/$keyMatFA;
                            $promedioFinalSEPFA = $promedioFinalSEPFA/$keyMatFA;
                    @endphp
                    <tr>
                      <td><b>PROM. FORMACIÓN ACADÉMICA</b></td>
                      {{--  promedio septiembree  --}}
                      <td align="center">
                        @if ($promSEPFA != "")
                            @if ($promSEPFA == 1.0 || $promSEPFA == 2.0 || $promSEPFA == 3.0
                                || $promSEPFA == 4.0 ||
                                $promSEPFA == 5.0 || $promSEPFA == 6.0 || $promSEPFA == 7.0 ||
                                $promSEPFA == 8.0 ||
                                $promSEPFA == 9.0 || $promSEPFA == 10.0)

                                <b>{{number_format((float)$promSEPFA, 0, '.', '')}}</b>

                                @else
                                <b>{{number_format((float)$promSEPFA, 1, '.', '')}}</b>
                                @endif
                        @else

                        @endif
                      </td>

                      {{--  promedio octubre   --}}
                      <td align="center">
                        @if ($promOCTFA != "")
                        @if ($promOCTFA == 1.0 || $promOCTFA == 2.0 || $promOCTFA == 3.0
                                || $promOCTFA == 4.0 ||
                                $promOCTFA == 5.0 || $promOCTFA == 6.0 || $promOCTFA == 7.0 ||
                                $promOCTFA == 8.0 ||
                                $promOCTFA == 9.0 || $promOCTFA == 10.0)

                                <b>{{number_format((float)$promOCTFA, 0, '.', '')}}</b>

                                @else
                                <b>{{number_format((float)$promOCTFA, 1, '.', '')}}</b>
                                @endif
                        @else

                        @endif
                      </td>

                      {{--  promedio noviembre   --}}
                      <td align="center">
                        @if ($promNOVFA != "")
                        @if ($promNOVFA == 1.0 || $promNOVFA == 2.0 || $promNOVFA == 3.0
                                || $promNOVFA == 4.0 ||
                                $promNOVFA == 5.0 || $promNOVFA == 6.0 || $promNOVFA == 7.0 ||
                                $promNOVFA == 8.0 ||
                                $promNOVFA == 9.0 || $promNOVFA == 10.0)

                                <b>{{number_format((float)$promNOVFA, 0, '.', '')}}</b>

                                @else
                                <b>{{number_format((float)$promNOVFA, 1, '.', '')}}</b>
                                @endif
                        @else

                        @endif
                      </td>

                      {{--  promedio general primer periodo   --}}
                      <td align="center">
                        @if ($promedioGen1FA != "")
                        {{--  <b>{{number_format((float)$promedioGen1FA, 1, '.', '')}}</b>  --}}
                        <b>{{TruncarDecimales::truncateFloat($promedioGen1FA, 1)}}</b>
                        {{--  hola aqui  --}}
                        @else

                        @endif
                      </td>
                      {{--  promedio general SEP primer periodo   --}}
                      <td align="center"><b>
                        @if ($promedioGen1SEPFA != "")
                        {{--  <b>{{$promedioGen1SEPFA}}</b>  --}}
                        <b>{{round($promedioGen1SEPFA)}}</b>
                        @else

                        @endif

                      </td>

                      {{--  sacar el nivel   --}}
                      @php
                      $nivSEPPe1 = "";
                      if ($matEspecialidad == "1FA") {
                          switch ($promedioGen1SEPFA) {
                              case 1:
                                  $nivSEPPe1 = "I";
                                  break;
                              case 2:
                                  $nivSEPPe1 = "II";
                                  break;
                              case 3:
                                  $nivSEPPe1 = "III";
                                  break;
                              case 4:
                                  $nivSEPPe1 = "IV";
                                  break;
                              case 5:
                                  $nivSEPPe1 = "I";
                                  break;
                              case 6:
                                  $nivSEPPe1 = "II";
                                  break;
                              case 7:
                                  $nivSEPPe1 = "II";
                                  break;
                              case 8:
                                  $nivSEPPe1 = "III";
                                  break;
                              case 9:
                                  $nivSEPPe1 = "III";
                                  break;
                              case 10:
                                  $nivSEPPe1 = "IV";
                          }
                      } else {
                          switch ($promedioGen1SEPFA) {
                              case 0:
                                  $nivSEPPe1 = "";
                                  break;
                              case 1:
                                  $nivSEPPe1 = "1";
                                  break;
                              case 2:
                                  $nivSEPPe1 = "1";
                                  break;
                              case 3:
                                  $nivSEPPe1 = "1";
                                  break;
                              case 4:
                                  $nivSEPPe1 = "1";
                                  break;
                              case 5:
                                  $nivSEPPe1 = "1";
                                  break;
                              case 6:
                                  $nivSEPPe1 = "2";
                                  break;
                              case 7:
                                  $nivSEPPe1 = "2";
                                  break;
                              case 8:
                                  $nivSEPPe1 = "3";
                                  break;
                              case 9:
                                  $nivSEPPe1 = "3";
                                  break;
                              case 10:
                                  $nivSEPPe1 = "4";
                          }
                      }

                      @endphp



                      {{-- <td align="center"><b>{{$nivSEPPe1}}</b></td> --}}

                      {{--  segundo periodo  --}}
                      {{--  promedio dic enero  --}}
                      <td align="center">
                        @if ($promDicEneFA != "")
                         @if ($promDicEneFA == 1.0 || $promDicEneFA == 2.0 || $promDicEneFA == 3.0
                                || $promDicEneFA == 4.0 ||
                                $promDicEneFA == 5.0 || $promDicEneFA == 6.0 || $promDicEneFA == 7.0 ||
                                $promDicEneFA == 8.0 ||
                                $promDicEneFA == 9.0 || $promDicEneFA == 10.0)

                                <b>{{number_format((float)$promDicEneFA, 0, '.', '')}}</b>

                                @else
                                <b>{{number_format((float)$promDicEneFA, 1, '.', '')}}</b>
                                @endif
                        @else

                        @endif
                      </td>

                      {{--  promedio febrero  --}}
                      <td align="center">
                        @if ($promFEBFA != "")
                        @if ($promFEBFA == 1.0 || $promFEBFA == 2.0 || $promFEBFA == 3.0
                                || $promFEBFA == 4.0 ||
                                $promFEBFA == 5.0 || $promFEBFA == 6.0 || $promFEBFA == 7.0 ||
                                $promFEBFA == 8.0 ||
                                $promFEBFA == 9.0 || $promFEBFA == 10.0)

                                <b>{{number_format((float)$promFEBFA, 0, '.', '')}}</b>

                                @else
                                <b>{{number_format((float)$promFEBFA, 1, '.', '')}}</b>
                                @endif
                        @else

                        @endif
                      </td>

                      {{--  promedio marzo  --}}
                      <td align="center">
                        @if ($promMARFA != "")

                        @if ($promMARFA == 1.0 || $promMARFA == 2.0 || $promMARFA == 3.0
                                || $promMARFA == 4.0 ||
                                $promMARFA == 5.0 || $promMARFA == 6.0 || $promMARFA == 7.0 ||
                                $promMARFA == 8.0 ||
                                $promMARFA == 9.0 || $promMARFA == 10.0)

                                <b>{{number_format((float)$promMARFA, 0, '.', '')}}</b>

                                @else
                                <b>{{number_format((float)$promMARFA, 1, '.', '')}}</b>
                                @endif
                        @else

                        @endif
                      </td>

                      {{--  promedio general segundo periodo   --}}
                      <td align="center">
                        @if ($promedioGen2FA != "")
                        {{--  <b>{{number_format((float)$promedioGen2FA, 1, '.', '')}}</b>  --}}
                        <b>{{TruncarDecimales::truncateFloat($promedioGen2FA, 1)}}</b>
                        @else

                        @endif
                      </td>
                      {{--  promedio general SEP segundo periodo   --}}
                      <td align="center"><b>
                        @if ($promedioGen2SEPFA != "")
                        {{--  <b>{{$promedioGen2SEPFA}}</b>  --}}
                        <b>{{round($promedioGen2SEPFA)}}</b>
                        @else

                        @endif

                      </b></td>
                       {{--  sacar el nivel   --}}
                       @php
                       $nivSEPPe2 = "";
                       if ($matEspecialidad == "1FA") {
                           switch ($promedioGen2SEPFA) {
                               case 1:
                                   $nivSEPPe2 = "I";
                                   break;
                               case 2:
                                   $nivSEPPe2 = "II";
                                   break;
                               case 3:
                                   $nivSEPPe2 = "III";
                                   break;
                               case 4:
                                   $nivSEPPe2 = "IV";
                                   break;
                               case 5:
                                   $nivSEPPe2 = "I";
                                   break;
                               case 6:
                                   $nivSEPPe2 = "II";
                                   break;
                               case 7:
                                   $nivSEPPe2 = "II";
                                   break;
                               case 8:
                                   $nivSEPPe2 = "III";
                                   break;
                               case 9:
                                   $nivSEPPe2 = "III";
                                   break;
                               case 10:
                                   $nivSEPPe2 = "IV";
                           }
                       } else {
                           switch ($promedioGen1SEPFA) {
                               case 0:
                                   $nivSEPPe2 = "";
                                   break;
                               case 1:
                                   $nivSEPPe2 = "1";
                                   break;
                               case 2:
                                   $nivSEPPe2 = "1";
                                   break;
                               case 3:
                                   $nivSEPPe2 = "1";
                                   break;
                               case 4:
                                   $nivSEPPe2 = "1";
                                   break;
                               case 5:
                                   $nivSEPPe2 = "1";
                                   break;
                               case 6:
                                   $nivSEPPe2 = "2";
                                   break;
                               case 7:
                                   $nivSEPPe2 = "2";
                                   break;
                               case 8:
                                   $nivSEPPe2 = "3";
                                   break;
                               case 9:
                                   $nivSEPPe2 = "3";
                                   break;
                               case 10:
                                   $nivSEPPe2 = "4";
                           }
                       }

                       @endphp



                      {{-- <td align="center"><b>{{$nivSEPPe2}}</b></td> --}}

                      {{--  tercer periodo   --}}
                      {{--  promedio abril  --}}
                      <td align="center">
                        @if ($promABRFA != "")
                        @if ($promABRFA == 1.0 || $promABRFA == 2.0 || $promABRFA == 3.0
                                || $promABRFA == 4.0 ||
                                $promABRFA == 5.0 || $promABRFA == 6.0 || $promABRFA == 7.0 ||
                                $promABRFA == 8.0 ||
                                $promABRFA == 9.0 || $promABRFA == 10.0)

                                <b>{{number_format((float)$promABRFA, 0, '.', '')}}</b>

                                @else
                                <b>{{number_format((float)$promABRFA, 1, '.', '')}}</b>
                                @endif

                        @else

                        @endif
                      </td>

                      {{--  promedio mayo  --}}
                      <td align="center">
                        @if ($promMAYFA != "")

                        @if ($promMAYFA == 1.0 || $promMAYFA == 2.0 || $promMAYFA == 3.0
                                || $promMAYFA == 4.0 ||
                                $promMAYFA == 5.0 || $promMAYFA == 6.0 || $promMAYFA == 7.0 ||
                                $promMAYFA == 8.0 ||
                                $promMAYFA == 9.0 || $promMAYFA == 10.0)

                                <b>{{number_format((float)$promMAYFA, 0, '.', '')}}</b>

                                @else
                                <b>{{number_format((float)$promMAYFA, 1, '.', '')}}</b>
                                @endif
                        @else

                        @endif
                      </td>

                      {{--  promedio junio  --}}
                      <td align="center">
                        @if ($promJUNFA != "")

                          @if ($promJUNFA == 1.0 || $promJUNFA == 2.0 || $promJUNFA == 3.0
                          || $promJUNFA == 4.0 ||
                          $promJUNFA == 5.0 || $promJUNFA == 6.0 || $promJUNFA == 7.0 ||
                          $promJUNFA == 8.0 ||
                          $promJUNFA == 9.0 || $promJUNFA == 10.0)

                          <b>{{number_format((float)$promJUNFA, 0, '.', '')}}</b>

                          @else
                          <b>{{number_format((float)$promJUNFA, 1, '.', '')}}</b>
                          @endif
                        @else

                        @endif
                      </td>

                      {{--  promedio general tercer periodo   --}}
                      <td align="center">
                        @if ($promedioGen3FA != "")
                        {{--  <b>{{number_format((float)$promedioGen3FA, 1, '.', '')}}</b>  --}}
                        <b>{{TruncarDecimales::truncateFloat($promedioGen3FA, 1)}}</b>
                        @else

                        @endif
                      </td>
                      {{--  promedio general SEP tercer periodo   --}}
                      <td align="center">
                        @if ($promedioGen3SEPFA != "")
                        {{--  <b>{{$promedioGen3SEPFA}}</b>  --}}
                        <b>{{round($promedioGen3SEPFA)}}</b>
                        @else

                        @endif
                      </td>
                       {{--  sacar el nivel   --}}
                       @php
                       $nivSEPPerido3 = "";
                       if ($matEspecialidad == "1FA") {
                           switch ($promedioGen3SEPFA) {
                               case 1:
                                   $nivSEPPerido3 = "I";
                                   break;
                               case 2:
                                   $nivSEPPerido3 = "II";
                                   break;
                               case 3:
                                   $nivSEPPerido3 = "III";
                                   break;
                               case 4:
                                   $nivSEPPerido3 = "IV";
                                   break;
                               case 5:
                                   $nivSEPPerido3 = "I";
                                   break;
                               case 6:
                                   $nivSEPPerido3 = "II";
                                   break;
                               case 7:
                                   $nivSEPPerido3 = "II";
                                   break;
                               case 8:
                                   $nivSEPPerido3 = "III";
                                   break;
                               case 9:
                                   $nivSEPPerido3 = "III";
                                   break;
                               case 10:
                                   $nivSEPPerido3 = "IV";
                           }
                       } else {
                           switch ($promedioGen3SEPFA) {
                               case 0:
                                   $nivSEPPerido3 = "";
                                   break;
                               case 1:
                                   $nivSEPPerido3 = "1";
                                   break;
                               case 2:
                                   $nivSEPPerido3 = "1";
                                   break;
                               case 3:
                                   $nivSEPPerido3 = "1";
                                   break;
                               case 4:
                                   $nivSEPPerido3 = "1";
                                   break;
                               case 5:
                                   $nivSEPPerido3 = "1";
                                   break;
                               case 6:
                                   $nivSEPPerido3 = "2";
                                   break;
                               case 7:
                                   $nivSEPPerido3 = "2";
                                   break;
                               case 8:
                                   $nivSEPPerido3 = "3";
                                   break;
                               case 9:
                                   $nivSEPPerido3 = "3";
                                   break;
                               case 10:
                                   $nivSEPPerido3 = "4";
                           }
                       }

                       @endphp



                      {{-- <td align="center"><b>{{$nivSEPPerido3}}</b></td> --}}

                      {{--  promedio final de la sep   --}}
                      <td align="center">
                        @if ($promedioFinalFA != "")
                        {{--  <b>{{number_format((float)$promedioFinalFA, 1, '.', '')}}</b>  --}}
                          @if ($promedioGen1FA != "" && $promedioGen2FA != "" && $promedioGen3FA != "")
                          <b>{{TruncarDecimales::truncateFloat($promedioFinalFA, 1)}}</b>
                          @endif
                        @else

                        @endif
                      </td>
                      <td align="center">
                        @if ($promedioFinalSEPFA != "")
                        {{--  <b>{{number_format((float)$promedioFinalSEPFA, 1, '.', '')}}</b>  --}}
                          @if ($promedioGen1FA != "" && $promedioGen2FA != "" && $promedioGen3FA != "")
                          <b>{{round($promedioFinalSEPFA)}}</b>
                          @endif
                        @else

                        @endif
                      </td>
                      {{--  sacar el nivel   --}}
                      @php
                      $nivSEPFinal = "";
                      if ($matEspecialidad == "1FA") {
                          switch ($promedioGen1SEPFA) {
                              case 1:
                                  $nivSEPFinal = "I";
                                  break;
                              case 2:
                                  $nivSEPFinal = "II";
                                  break;
                              case 3:
                                  $nivSEPFinal = "III";
                                  break;
                              case 4:
                                  $nivSEPFinal = "IV";
                                  break;
                              case 5:
                                  $nivSEPFinal = "I";
                                  break;
                              case 6:
                                  $nivSEPFinal = "II";
                                  break;
                              case 7:
                                  $nivSEPFinal = "II";
                                  break;
                              case 8:
                                  $nivSEPFinal = "III";
                                  break;
                              case 9:
                                  $nivSEPFinal = "III";
                                  break;
                              case 10:
                                  $nivSEPFinal = "IV";
                          }
                      } else {
                          switch ($promedioGen1SEPFA) {
                              case 0:
                                  $nivSEPFinal = "";
                                  break;
                              case 1:
                                  $nivSEPFinal = "1";
                                  break;
                              case 2:
                                  $nivSEPFinal = "1";
                                  break;
                              case 3:
                                  $nivSEPFinal = "1";
                                  break;
                              case 4:
                                  $nivSEPFinal = "1";
                                  break;
                              case 5:
                                  $nivSEPFinal = "1";
                                  break;
                              case 6:
                                  $nivSEPFinal = "2";
                                  break;
                              case 7:
                                  $nivSEPFinal = "2";
                                  break;
                              case 8:
                                  $nivSEPFinal = "3";
                                  break;
                              case 9:
                                  $nivSEPFinal = "3";
                                  break;
                              case 10:
                                  $nivSEPFinal = "4";
                          }
                      }

                      @endphp


                      {{-- <td align="center"><b>{{$nivSEPFinal}}</b></td> --}}
                    </tr>
              </tbody>
              </table>


              {{--  DESARROLLO PERSONAL Y SOCIAL  --}}
              <br>
              <table class="table table-bordered">
                <thead>

                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)
                      @if ($item->matNombreEspecialidad == "DESARROLLO PERSONAL Y SOCIAL")
                      <tr>
                        @php
                          $keyMatDESA++;
                          $promSEPDESA = $promSEPDESA + $item->inscCalificacionSep;
                          $promOCTDESA = $promOCTDESA + $item->inscCalificacionOct;
                          $promNOVDESA = $promNOVDESA + $item->inscCalificacionNov;
                          $PromedioGen1DESA = $PromedioGen1DESA + $item->inscTrimestre1;
                          $PromedioGen1SEPDESA = $PromedioGen1SEPDESA + $item->inscTrimestre1SEP;
                          $promDICENEDESA = $promDICENEDESA + $item->inscCalificacionDicEnero;
                          $promFEBDESA = $promFEBDESA + $item->inscCalificacionFeb;
                          $promMARDESA = $promMARDESA + $item->inscCalificacionMar;
                          $PromedioGen2DESA = $PromedioGen2DESA + $item->inscTrimestre2;
                          $PromedioGen2SEPDESA = $PromedioGen2SEPDESA + $item->inscTrimestre2SEP;
                          $promABRDESA = $promABRDESA + $item->inscCalificacionAbr;
                          $promMAYDESA = $promMAYDESA + $item->inscCalificacionMay;
                          $promJUNDESA = $promJUNDESA + $item->inscCalificacionJun;
                          $PromedioGen3DESA = $PromedioGen3DESA + $item->inscTrimestre3;
                          $PromedioGen3SEPDESA = $PromedioGen3SEPDESA + $item->inscTrimestre3SEP;
                          $promedioFinalDESA = $promedioFinalDESA + $item->inscPromedioTrimCALCULADO;
                          $promedioFinalSEPDESA = $promedioFinalSEPDESA + $item->inscPromedioTrimCALCULADOSEP;

                          $matEspecialidad = $item->matEspecialidad;

                          #VARIBALES PARA USAR EN LA SUMA DE PROMEDIO GENERAL
                          $sumaPromediosDESASep = $sumaPromediosDESASep + $item->inscCalificacionSep;
                          $sumaPromediosDESAOct = $sumaPromediosDESAOct + $item->inscCalificacionOct;
                          $sumaPromediosDESANov = $sumaPromediosDESANov + $item->inscCalificacionNov;
                          $sumaPromediosDESAEne = $sumaPromediosDESAEne + $item->inscCalificacionDicEnero;
                          $sumaPromediosDESAFeb = $sumaPromediosDESAFeb + $item->inscCalificacionFeb;
                          $sumaPromediosDESAMar = $sumaPromediosDESAMar + $item->inscCalificacionMar;
                          $sumaPromediosDESAAbr = $sumaPromediosDESAAbr + $item->inscCalificacionAbr;
                          $sumaPromediosDESAMay = $sumaPromediosDESAMay + $item->inscCalificacionMay;
                          $sumaPromediosDESAJun = $sumaPromediosDESAJun + $item->inscCalificacionJun;

                          $sumaPromedio1DESA  = $sumaPromedio1DESA  + $item->inscTrimestre1;
                          $sumaPromedio2DESA  = $sumaPromedio2DESA  + $item->inscTrimestre2;
                          $sumaPromedio3DESA  = $sumaPromedio3DESA  + $item->inscTrimestre3;
                          $sumaPromedioFinalDESA = $sumaPromedioFinalDESA + $item->inscPromedioTrimCALCULADO;
                        @endphp

                        <td style="width: 160px;">{{$item->matNombreOficial}}</td>


                        @if ($item->inscCalificacionSep != "")
                          <td align="center" style="width: 25px;">
                            @if ($item->inscCalificacionSep == 1.0 || $item->inscCalificacionSep == 2.0 || $item->inscCalificacionSep == 3.0
                            || $item->inscCalificacionSep == 4.0 ||
                            $item->inscCalificacionSep == 5.0 || $item->inscCalificacionSep == 6.0 || $item->inscCalificacionSep == 7.0 ||
                            $item->inscCalificacionSep == 8.0 ||
                            $item->inscCalificacionSep == 9.0 || $item->inscCalificacionSep == 10.0)

                            {{number_format((float)$item->inscCalificacionSep, 0, '.', '')}}

                            @else
                            {{--  {{number_format((float)$item->inscCalificacionSep, 1, '.', '')}}  --}}
                            {{$item->inscCalificacionSep}}
                            @endif
                          </td>
                        @else
                          <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        @if ($item->inscCalificacionOct != "")
                          <td align="center" style="width: 27px;">
                              @if ($item->inscCalificacionOct == 1.0 || $item->inscCalificacionOct == 2.0 || $item->inscCalificacionOct == 3.0
                              || $item->inscCalificacionOct == 4.0 ||
                              $item->inscCalificacionOct == 5.0 || $item->inscCalificacionOct == 6.0 || $item->inscCalificacionOct == 7.0 ||
                              $item->inscCalificacionOct == 8.0 ||
                              $item->inscCalificacionOct == 9.0 || $item->inscCalificacionOct == 10.0)

                              {{number_format((float)$item->inscCalificacionOct, 0, '.', '')}}

                              @else
                              {{--  {{number_format((float)$item->inscCalificacionOct, 1, '.', '')}}  --}}
                              {{$item->inscCalificacionOct}}
                              @endif
                          </td>
                        @else
                          <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        @if ($item->inscCalificacionNov != "")
                          <td align="center" style="width: 28px;">
                            @if ($item->inscCalificacionNov == 1.0 || $item->inscCalificacionNov == 2.0 || $item->inscCalificacionNov == 3.0
                            || $item->inscCalificacionNov == 4.0 ||
                            $item->inscCalificacionNov == 5.0 || $item->inscCalificacionNov == 6.0 || $item->inscCalificacionNov == 7.0 ||
                            $item->inscCalificacionNov == 8.0 ||
                            $item->inscCalificacionNov == 9.0 || $item->inscCalificacionNov == 10.0)

                            {{number_format((float)$item->inscCalificacionNov, 0, '.', '')}}

                            @else
                            {{--  {{number_format((float)$item->inscCalificacionNov, 1, '.', '')}}  --}}
                            {{$item->inscCalificacionNov}}
                            @endif
                          </td>
                        @else
                          <td align="center" style="width: 28px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        {{--  promedio trimestree 1  --}}
                        @if ($item->inscTrimestre1 != "")
                        <td align="center" style="width: 33px;">
                          @if ($item->inscTrimestre1 == 1.0 || $item->inscTrimestre1 == 2.0 || $item->inscTrimestre1 == 3.0
                          || $item->inscTrimestre1 == 4.0 ||
                          $item->inscTrimestre1 == 5.0 || $item->inscTrimestre1 == 6.0 || $item->inscTrimestre1 == 7.0 ||
                          $item->inscTrimestre1 == 8.0 ||
                          $item->inscTrimestre1 == 9.0 || $item->inscTrimestre1 == 10.0)

                          <b>{{number_format((float)$item->inscTrimestre1, 0, '.', '')}}</b>

                          @else
                          {{--  <b>{{number_format((float)$item->inscTrimestre1, 1, '.', '')}}</b>  --}}
                          <b>{{$item->inscTrimestre1}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 33px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscTrimestre1SEP != "")
                        <td align="center" style="width: 35px;">

                          @if ($item->inscTrimestre1SEP == 1.0 || $item->inscTrimestre1SEP == 2.0 || $item->inscTrimestre1SEP == 3.0
                          || $item->inscTrimestre1SEP == 4.0 ||
                          $item->inscTrimestre1SEP == 5.0 || $item->inscTrimestre1SEP == 6.0 || $item->inscTrimestre1SEP == 7.0 ||
                          $item->inscTrimestre1SEP == 8.0 ||
                          $item->inscTrimestre1SEP == 9.0 || $item->inscTrimestre1SEP == 10.0)

                          {{number_format((float)$item->inscTrimestre1SEP, 0, '.', '')}}

                          @else
                          {{--  {{number_format((float)$item->inscTrimestre1SEP, 1, '.', '')}}  --}}
                          {{$item->inscTrimestre1SEP}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  sacar el nivel   --}}
                        @php
                        $nivSEPPe1 = "";
                        if ($item->matEspecialidad == "1FA") {
                            switch ($item->inscTrimestre1SEP) {
                                case 1:
                                    $nivSEPPe1 = "I";
                                    break;
                                case 2:
                                    $nivSEPPe1 = "II";
                                    break;
                                case 3:
                                    $nivSEPPe1 = "III";
                                    break;
                                case 4:
                                    $nivSEPPe1 = "IV";
                                    break;
                                case 5:
                                    $nivSEPPe1 = "I";
                                    break;
                                case 6:
                                    $nivSEPPe1 = "II";
                                    break;
                                case 7:
                                    $nivSEPPe1 = "II";
                                    break;
                                case 8:
                                    $nivSEPPe1 = "III";
                                    break;
                                case 9:
                                    $nivSEPPe1 = "III";
                                    break;
                                case 10:
                                    $nivSEPPe1 = "IV";
                            }
                        } else {
                            switch ($item->inscTrimestre1SEP) {
                                case 0:
                                    $nivSEPPe1 = "";
                                    break;
                                case 1:
                                    $nivSEPPe1 = "1";
                                    break;
                                case 2:
                                    $nivSEPPe1 = "1";
                                    break;
                                case 3:
                                    $nivSEPPe1 = "1";
                                    break;
                                case 4:
                                    $nivSEPPe1 = "1";
                                    break;
                                case 5:
                                    $nivSEPPe1 = "1";
                                    break;
                                case 6:
                                    $nivSEPPe1 = "2";
                                    break;
                                case 7:
                                    $nivSEPPe1 = "2";
                                    break;
                                case 8:
                                    $nivSEPPe1 = "3";
                                    break;
                                case 9:
                                    $nivSEPPe1 = "3";
                                    break;
                                case 10:
                                    $nivSEPPe1 = "4";
                            }
                        }

                        @endphp



                        {{-- @if ($nivSEPPe1 != "")
                          <td align="center" style="width: 36px;">{{$nivSEPPe1}}</td>
                        @else
                          <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
                        @endif --}}

                        @if ($item->inscCalificacionDicEnero != "")
                        <td align="center" style="width: 27px;">
                          @if ($item->inscCalificacionDicEnero == 1.0 || $item->inscCalificacionDicEnero == 2.0 ||
                          $item->inscCalificacionDicEnero == 3.0 || $item->inscCalificacionDicEnero == 4.0 ||
                          $item->inscCalificacionDicEnero == 5.0 || $item->inscCalificacionDicEnero == 6.0 ||
                          $item->inscCalificacionDicEnero == 7.0 || $item->inscCalificacionDicEnero == 8.0 ||
                          $item->inscCalificacionDicEnero == 9.0 || $item->inscCalificacionDicEnero == 10.0)

                          {{number_format((float)$item->inscCalificacionDicEnero, 0, '.', '')}}

                          @else
                          {{--  {{number_format((float)$item->inscCalificacionDicEnero, 1, '.', '')}}  --}}
                          {{$item->inscCalificacionDicEnero}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        @if ($item->inscCalificacionFeb != "")
                        <td align="center" style="width: 26px;">
                          @if ($item->inscCalificacionFeb == 1.0 || $item->inscCalificacionFeb == 2.0 ||
                          $item->inscCalificacionFeb == 3.0 || $item->inscCalificacionFeb == 4.0 ||
                          $item->inscCalificacionFeb == 5.0 || $item->inscCalificacionFeb == 6.0 ||
                          $item->inscCalificacionFeb == 7.0 || $item->inscCalificacionFeb == 8.0 ||
                          $item->inscCalificacionFeb == 9.0 || $item->inscCalificacionFeb == 10.0)

                          {{number_format((float)$item->inscCalificacionFeb, 0, '.', '')}}

                          @else
                          {{--  {{number_format((float)$item->inscCalificacionFeb, 1, '.', '')}}  --}}
                          {{$item->inscCalificacionFeb}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        @if ($item->inscCalificacionMar != "")
                        <td align="center" style="width: 30px;">
                          @if ($item->inscCalificacionMar == 1.0 || $item->inscCalificacionMar == 2.0 ||
                          $item->inscCalificacionMar == 3.0 || $item->inscCalificacionMar == 4.0 ||
                          $item->inscCalificacionMar == 5.0 || $item->inscCalificacionMar == 6.0 ||
                          $item->inscCalificacionMar == 7.0 || $item->inscCalificacionMar == 8.0 ||
                          $item->inscCalificacionMar == 9.0 || $item->inscCalificacionMar == 10.0)

                          {{number_format((float)$item->inscCalificacionMar, 0, '.', '')}}

                          @else
                          {{--  {{number_format((float)$item->inscCalificacionMar, 1, '.', '')}}  --}}
                          {{$item->inscCalificacionMar}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 30px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        {{--  promedio trimestre 2   --}}
                        @if ($item->inscTrimestre2 != "")
                        <td align="center" style="width: 33px;">
                          {{--  <b>{{number_format((float)$item->inscTrimestre2, 1, '.', '')}}</b>  --}}
                          <b>{{$item->inscTrimestre2}}</b>
                        </td>
                        @else
                        <td align="center" style="width: 33px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscTrimestre2SEP != "")
                        <td align="center" style="width: 35px;">{{$item->inscTrimestre2SEP}}</td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  sacar el nivel   --}}
                        @php
                        $nivSEPPe2 = "";
                        if ($item->matEspecialidad == "1FA") {
                            switch ($item->inscTrimestre2SEP) {
                                case 1:
                                    $nivSEPPe2 = "I";
                                    break;
                                case 2:
                                    $nivSEPPe2 = "II";
                                    break;
                                case 3:
                                    $nivSEPPe2 = "III";
                                    break;
                                case 4:
                                    $nivSEPPe2 = "IV";
                                    break;
                                case 5:
                                    $nivSEPPe2 = "I";
                                    break;
                                case 6:
                                    $nivSEPPe2 = "II";
                                    break;
                                case 7:
                                    $nivSEPPe2 = "II";
                                    break;
                                case 8:
                                    $nivSEPPe2 = "III";
                                    break;
                                case 9:
                                    $nivSEPPe2 = "III";
                                    break;
                                case 10:
                                    $nivSEPPe2 = "IV";
                            }
                        } else {
                            switch ($item->inscTrimestre2SEP) {
                                case 0:
                                    $nivSEPPe2 = "";
                                    break;
                                case 1:
                                    $nivSEPPe2 = "1";
                                    break;
                                case 2:
                                    $nivSEPPe2 = "1";
                                    break;
                                case 3:
                                    $nivSEPPe2 = "1";
                                    break;
                                case 4:
                                    $nivSEPPe2 = "1";
                                    break;
                                case 5:
                                    $nivSEPPe2 = "1";
                                    break;
                                case 6:
                                    $nivSEPPe2 = "2";
                                    break;
                                case 7:
                                    $nivSEPPe2 = "2";
                                    break;
                                case 8:
                                    $nivSEPPe2 = "3";
                                    break;
                                case 9:
                                    $nivSEPPe2 = "3";
                                    break;
                                case 10:
                                    $nivSEPPe2 = "4";
                            }
                        }

                        @endphp
                        {{-- @if ($nivSEPPe2 != "")
                        <td align="center" style="width: 35px;">{{$nivSEPPe2}}</td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif --}}

                        @if ($item->inscCalificacionAbr != "")
                        <td align="center" style="width: 27px;">
                          @if ($item->inscCalificacionAbr == 1.0 || $item->inscCalificacionAbr == 2.0 ||
                          $item->inscCalificacionAbr == 3.0 || $item->inscCalificacionAbr == 4.0 ||
                          $item->inscCalificacionAbr == 5.0 || $item->inscCalificacionAbr == 6.0 ||
                          $item->inscCalificacionAbr == 7.0 || $item->inscCalificacionAbr == 8.0 ||
                          $item->inscCalificacionAbr == 9.0 || $item->inscCalificacionAbr == 10.0)

                          {{number_format((float)$item->inscCalificacionAbr, 0, '.', '')}}

                          @else
                          {{--  {{number_format((float)$item->inscCalificacionAbr, 1, '.', '')}}  --}}
                          {{$item->inscCalificacionAbr}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionMay != "")
                        <td align="center" style="width: 28px;">
                          @if ($item->inscCalificacionMay == 1.0 || $item->inscCalificacionMay == 2.0 ||
                          $item->inscCalificacionMay == 3.0 || $item->inscCalificacionMay == 4.0 ||
                          $item->inscCalificacionMay == 5.0 || $item->inscCalificacionMay == 6.0 ||
                          $item->inscCalificacionMay == 7.0 || $item->inscCalificacionMay == 8.0 ||
                          $item->inscCalificacionMay == 9.0 || $item->inscCalificacionMay == 10.0)

                          {{number_format((float)$item->inscCalificacionMay, 0, '.', '')}}

                          @else
                          {{--  {{number_format((float)$item->inscCalificacionMay, 1, '.', '')}}  --}}
                          {{$item->inscCalificacionMay}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 28px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        @if ($item->inscCalificacionJun != "")
                        <td align="center" style="width: 26px;">
                          @if ($item->inscCalificacionJun == 1.0 || $item->inscCalificacionJun == 2.0 ||
                          $item->inscCalificacionJun == 3.0 || $item->inscCalificacionJun == 4.0 ||
                          $item->inscCalificacionJun == 5.0 || $item->inscCalificacionJun == 6.0 ||
                          $item->inscCalificacionJun == 7.0 || $item->inscCalificacionJun == 8.0 ||
                          $item->inscCalificacionJun == 9.0 || $item->inscCalificacionJun == 10.0)

                          {{number_format((float)$item->inscCalificacionJun, 0, '.', '')}}

                          @else
                          {{--  {{number_format((float)$item->inscCalificacionJun, 1, '.', '')}}  --}}
                          {{$item->inscCalificacionJun}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        {{--  promedio trimestre 3   --}}
                        @if ($item->inscTrimestre3 != "")
                        <td align="center" style="width: 33px;">
                          {{--  <b>{{number_format((float)$item->inscTrimestre3, 1, '.', '')}}</b>  --}}
                          {{$item->inscTrimestre3}}
                        </td>
                        @else
                        <td align="center" style="width: 33px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscTrimestre3SEP != "")
                        <td align="center" style="width: 34px;">{{$item->inscTrimestre3SEP}}</td>
                        @else
                        <td align="center" style="width: 34px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        {{--  sacar el nivel   --}}
                        @php
                        $nivSEPPe3 = "";
                        if ($item->matEspecialidad == "1FA") {
                            switch ($item->inscTrimestre3SEP) {
                                case 1:
                                    $nivSEPPe3 = "I";
                                    break;
                                case 2:
                                    $nivSEPPe3 = "II";
                                    break;
                                case 3:
                                    $nivSEPPe3 = "III";
                                    break;
                                case 4:
                                    $nivSEPPe3 = "IV";
                                    break;
                                case 5:
                                    $nivSEPPe3 = "I";
                                    break;
                                case 6:
                                    $nivSEPPe3 = "II";
                                    break;
                                case 7:
                                    $nivSEPPe3 = "II";
                                    break;
                                case 8:
                                    $nivSEPPe3 = "III";
                                    break;
                                case 9:
                                    $nivSEPPe3 = "III";
                                    break;
                                case 10:
                                    $nivSEPPe3 = "IV";
                            }
                        } else {
                            switch ($item->inscTrimestre3SEP) {
                                case 0:
                                    $nivSEPPe3 = "";
                                    break;
                                case 1:
                                    $nivSEPPe3 = "1";
                                    break;
                                case 2:
                                    $nivSEPPe3 = "1";
                                    break;
                                case 3:
                                    $nivSEPPe3 = "1";
                                    break;
                                case 4:
                                    $nivSEPPe3 = "1";
                                    break;
                                case 5:
                                    $nivSEPPe3 = "1";
                                    break;
                                case 6:
                                    $nivSEPPe3 = "2";
                                    break;
                                case 7:
                                    $nivSEPPe3 = "2";
                                    break;
                                case 8:
                                    $nivSEPPe3 = "3";
                                    break;
                                case 9:
                                    $nivSEPPe3 = "3";
                                    break;
                                case 10:
                                    $nivSEPPe3 = "4";
                            }
                        }

                        @endphp




                        {{-- @if ($nivSEPPe3 != "")
                          <td align="center" style="width: 38px;">{{$nivSEPPe3}}</td>
                        @else
                          <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td>
                        @endif --}}

                        {{--  promedio final   --}}
                        @if ($item->inscPromedioTrimCALCULADO != "")
                        <td align="center" style="width: 35px;">
                          @if ($item->inscTrimestre3 != "" && $item->inscTrimestre2 != "" && $item->inscTrimestre3 != "")
                            @if ($item->inscPromedioTrimCALCULADO == 1.0 || $item->inscPromedioTrimCALCULADO == 2.0 ||
                            $item->inscPromedioTrimCALCULADO == 3.0 || $item->inscPromedioTrimCALCULADO == 4.0 ||
                            $item->inscPromedioTrimCALCULADO == 5.0 || $item->inscPromedioTrimCALCULADO == 6.0 ||
                            $item->inscPromedioTrimCALCULADO == 7.0 || $item->inscPromedioTrimCALCULADO == 8.0 ||
                            $item->inscPromedioTrimCALCULADO == 9.0 || $item->inscPromedioTrimCALCULADO == 10.0)

                            {{number_format((float)$item->inscPromedioTrimCALCULADO, 0, '.', '')}}

                            @else
                            {{number_format((float)$item->inscPromedioTrimCALCULADO, 1, '.', '')}}
                            @endif
                          @endif
                        </td>
                        @else
                          <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        {{--  promedio final sep   --}}
                        @if ($item->inscPromedioTrimCALCULADOSEP != "")
                        <td align="center" style="width: 35px;">
                          @if ($item->inscTrimestre3 != "" && $item->inscTrimestre2 != "" && $item->inscTrimestre3 != "")
                            @if ($item->inscPromedioTrimCALCULADOSEP == 1.0 || $item->inscPromedioTrimCALCULADOSEP == 2.0 ||
                            $item->inscPromedioTrimCALCULADOSEP == 3.0 || $item->inscPromedioTrimCALCULADOSEP == 4.0 ||
                            $item->inscPromedioTrimCALCULADOSEP == 5.0 || $item->inscPromedioTrimCALCULADOSEP == 6.0 ||
                            $item->inscPromedioTrimCALCULADOSEP == 7.0 || $item->inscPromedioTrimCALCULADOSEP == 8.0 ||
                            $item->inscPromedioTrimCALCULADOSEP == 9.0 || $item->inscPromedioTrimCALCULADOSEP == 10.0)

                            {{number_format((float)$item->inscPromedioTrimCALCULADOSEP, 0, '.', '')}}

                            @else
                            {{number_format((float)$item->inscPromedioTrimCALCULADOSEP, 1, '.', '')}}
                            @endif
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  sacar el nivel   --}}
                        @php
                        $nivSEPFinall = "";
                        if ($item->matEspecialidad == "1FA") {
                            switch ($item->inscPromedioTrimCALCULADOSEP) {
                                case 1:
                                    $nivSEPFinall = "I";
                                    break;
                                case 2:
                                    $nivSEPFinall = "II";
                                    break;
                                case 3:
                                    $nivSEPFinall = "III";
                                    break;
                                case 4:
                                    $nivSEPFinall = "IV";
                                    break;
                                case 5:
                                    $nivSEPFinall = "I";
                                    break;
                                case 6:
                                    $nivSEPFinall = "II";
                                    break;
                                case 7:
                                    $nivSEPFinall = "II";
                                    break;
                                case 8:
                                    $nivSEPFinall = "III";
                                    break;
                                case 9:
                                    $nivSEPFinall = "III";
                                    break;
                                case 10:
                                    $nivSEPFinall = "IV";
                            }
                        } else {
                            switch ($item->inscPromedioTrimCALCULADOSEP) {
                                case 0:
                                    $nivSEPFinall = "";
                                    break;
                                case 1:
                                    $nivSEPFinall = "1";
                                    break;
                                case 2:
                                    $nivSEPFinall = "1";
                                    break;
                                case 3:
                                    $nivSEPFinall = "1";
                                    break;
                                case 4:
                                    $nivSEPFinall = "1";
                                    break;
                                case 5:
                                    $nivSEPFinall = "1";
                                    break;
                                case 6:
                                    $nivSEPFinall = "2";
                                    break;
                                case 7:
                                    $nivSEPFinall = "2";
                                    break;
                                case 8:
                                    $nivSEPFinall = "3";
                                    break;
                                case 9:
                                    $nivSEPFinall = "3";
                                    break;
                                case 10:
                                    $nivSEPFinall = "4";
                            }
                        }

                        @endphp


                        {{-- @if ($nivSEPFinall != "")
                          <td align="center" style="width: 35px;">{{$nivSEPFinall}}</td>
                        @else
                          <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif --}}
                      </tr>
                      @endif
                    @endif
                  @endforeach

                  @php

                          $promSEPDESA = $promSEPDESA/$keyMatDESA;
                          $promOCTDESA = $promOCTDESA/$keyMatDESA;
                          $promNOVDESA = $promNOVDESA/$keyMatDESA;
                          $PromedioGen1DESA = $PromedioGen1DESA/$keyMatDESA;
                          $PromedioGen1SEPDESA = round($PromedioGen1SEPDESA/$keyMatDESA, 1);
                          $promDICENEDESA = $promDICENEDESA/$keyMatDESA;
                          $promFEBDESA = $promFEBDESA/$keyMatDESA;
                          $promMARDESA = $promMARDESA/$keyMatDESA;
                          $PromedioGen2DESA = $PromedioGen2DESA/$keyMatDESA;
                          $PromedioGen2SEPDESA = round($PromedioGen2SEPDESA/$keyMatDESA, 1);
                          $promABRDESA = $promABRDESA/$keyMatDESA;
                          $promMAYDESA = $promMAYDESA/$keyMatDESA;
                          $promJUNDESA = $promJUNDESA/$keyMatDESA;
                          $PromedioGen3DESA = $PromedioGen3DESA/$keyMatDESA;
                          $PromedioGen3SEPDESA = round($PromedioGen3SEPDESA/$keyMatDESA, 1);
                          $promedioFinalDESA = $promedioFinalDESA/$keyMatDESA;
                          $promedioFinalSEPDESA = $promedioFinalSEPDESA/$keyMatDESA;
                  @endphp

                  <tr>
                    <td><b>PROM. DESARR.PERSON. Y SOCI.</b></td>
                    {{--  promedio septiembree  --}}
                    <td align="center">
                      @if ($promSEPDESA != "")
                        @if ($promSEPDESA == 1.0 || $promSEPDESA == 2.0 || $promSEPDESA == 3.0 || $promSEPDESA == 4.0 ||
                        $promSEPDESA == 5.0 || $promSEPDESA == 6.0 || $promSEPDESA == 7.0 || $promSEPDESA == 8.0 ||
                        $promSEPDESA == 9.0 || $promSEPDESA == 10.0)

                        <b>{{number_format((float)$promSEPDESA, 0, '.', '')}}</b>

                        @else
                        <b>{{number_format((float)$promSEPDESA, 1, '.', '')}}</b>
                        @endif
                      @else

                      @endif
                    </td>

                    {{--  promedio octubre   --}}
                    <td align="center">

                      @if ($promOCTDESA != "")
                        @if ($promOCTDESA == 1.0 || $promOCTDESA == 2.0 || $promOCTDESA == 3.0 || $promOCTDESA == 4.0 ||
                        $promOCTDESA == 5.0 || $promOCTDESA == 6.0 || $promOCTDESA == 7.0 || $promOCTDESA == 8.0 ||
                        $promOCTDESA == 9.0 || $promOCTDESA == 10.0)

                        <b>{{number_format((float)$promOCTDESA, 0, '.', '')}}</b>

                        @else
                        <b>{{number_format((float)$promOCTDESA, 1, '.', '')}}</b>
                        @endif
                      @else

                      @endif
                    </td>

                    {{--  promedio noviembre   --}}
                    <td align="center">
                      @if ($promNOVDESA != "")
                        @if ($promNOVDESA == 1.0 || $promNOVDESA == 2.0 || $promNOVDESA == 3.0 || $promNOVDESA == 4.0 ||
                        $promNOVDESA == 5.0 || $promNOVDESA == 6.0 || $promNOVDESA == 7.0 || $promNOVDESA == 8.0 ||
                        $promNOVDESA == 9.0 || $promNOVDESA == 10.0)

                        <b>{{number_format((float)$promNOVDESA, 0, '.', '')}}</b>

                        @else
                        <b>{{number_format((float)$promNOVDESA, 1, '.', '')}}</b>
                        @endif
                      @else

                      @endif
                    </td>

                    {{--  promedio general primer periodo   --}}
                    <td align="center">
                      @if ($PromedioGen1DESA != "")
                        @if ($PromedioGen1DESA == 1.0 || $PromedioGen1DESA == 2.0 || $PromedioGen1DESA == 3.0 || $PromedioGen1DESA == 4.0 ||
                        $PromedioGen1DESA == 5.0 || $PromedioGen1DESA == 6.0 || $PromedioGen1DESA == 7.0 || $PromedioGen1DESA == 8.0 ||
                        $PromedioGen1DESA == 9.0 || $PromedioGen1DESA == 10.0)

                        <b>{{number_format((float)$PromedioGen1DESA, 0, '.', '')}}</b>

                        @else
                        {{--  <b>{{number_format((float)$PromedioGen1DESA, 1, '.', '')}}</b>  --}}
                        <b>{{TruncarDecimales::truncateFloat($PromedioGen1DESA, 1)}}</b>
                        @endif
                      @else

                      @endif
                    </td>
                    {{--  promedio general SEP primer periodo   --}}
                    <td align="center">
                      @if ($PromedioGen1SEPDESA != "")
                      {{--  <b>{{$PromedioGen1SEPDESA}}</b>  --}}
                      <b>{{round($PromedioGen1SEPDESA)}}</b>
                      @else

                      @endif

                    </td>

                    {{--  sacar el nivel   --}}
                    @php
                    $nivSEPGenPe1 = "";
                    if ($matEspecialidad == "1FA") {
                        switch ($PromedioGen1SEPDESA) {
                            case 1:
                                $nivSEPGenPe1 = "I";
                                break;
                            case 2:
                                $nivSEPGenPe1 = "II";
                                break;
                            case 3:
                                $nivSEPGenPe1 = "III";
                                break;
                            case 4:
                                $nivSEPGenPe1 = "IV";
                                break;
                            case 5:
                                $nivSEPGenPe1 = "I";
                                break;
                            case 6:
                                $nivSEPGenPe1 = "II";
                                break;
                            case 7:
                                $nivSEPGenPe1 = "II";
                                break;
                            case 8:
                                $nivSEPGenPe1 = "III";
                                break;
                            case 9:
                                $nivSEPGenPe1 = "III";
                                break;
                            case 10:
                                $nivSEPGenPe1 = "IV";
                        }
                    } else {
                        switch ($PromedioGen1SEPDESA) {
                            case 0:
                                $nivSEPGenPe1 = "";
                                break;
                            case 1:
                                $nivSEPGenPe1 = "1";
                                break;
                            case 2:
                                $nivSEPGenPe1 = "1";
                                break;
                            case 3:
                                $nivSEPGenPe1 = "1";
                                break;
                            case 4:
                                $nivSEPGenPe1 = "1";
                                break;
                            case 5:
                                $nivSEPGenPe1 = "1";
                                break;
                            case 6:
                                $nivSEPGenPe1 = "2";
                                break;
                            case 7:
                                $nivSEPGenPe1 = "2";
                                break;
                            case 8:
                                $nivSEPGenPe1 = "3";
                                break;
                            case 9:
                                $nivSEPGenPe1 = "3";
                                break;
                            case 10:
                                $nivSEPGenPe1 = "4";
                        }
                    }

                    @endphp

                    {{-- @if ($nivSEPGenPe1 != "")
                      <td align="center"><b>{{$nivSEPGenPe1}}</b></td>
                    @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                    @endif --}}

                    {{--  segundo periodo  --}}
                    {{--  promedio dic enero  --}}
                    <td align="center">

                      @if ($promDICENEDESA != "")
                        @if ($promDICENEDESA == 1.0 || $promDICENEDESA == 2.0 || $promDICENEDESA == 3.0 || $promDICENEDESA == 4.0 ||
                        $promDICENEDESA == 5.0 || $promDICENEDESA == 6.0 || $promDICENEDESA == 7.0 || $promDICENEDESA == 8.0 ||
                        $promDICENEDESA == 9.0 || $promDICENEDESA == 10.0)

                        <b>{{number_format((float)$promDICENEDESA, 0, '.', '')}}</b>

                        @else
                        <b>{{number_format((float)$promDICENEDESA, 1, '.', '')}}</b>
                        @endif
                      @else

                      @endif
                    </td>

                    {{--  promedio febrero  --}}
                    <td align="center">
                      @if ($promFEBDESA != "")
                        @if ($promFEBDESA == 1.0 || $promFEBDESA == 2.0 || $promFEBDESA == 3.0 || $promFEBDESA == 4.0 ||
                        $promFEBDESA == 5.0 || $promFEBDESA == 6.0 || $promFEBDESA == 7.0 || $promFEBDESA == 8.0 ||
                        $promFEBDESA == 9.0 || $promFEBDESA == 10.0)

                        <b>{{number_format((float)$promFEBDESA, 0, '.', '')}}</b>

                        @else
                        <b>{{number_format((float)$promFEBDESA, 1, '.', '')}}</b>
                        @endif
                      @else

                      @endif
                    </td>

                    {{--  promedio marzo  --}}
                    <td align="center">
                      @if ($promMARDESA != "")
                        @if ($promMARDESA == 1.0 || $promMARDESA == 2.0 || $promMARDESA == 3.0 || $promMARDESA == 4.0 ||
                        $promMARDESA == 5.0 || $promMARDESA == 6.0 || $promMARDESA == 7.0 || $promMARDESA == 8.0 ||
                        $promMARDESA == 9.0 || $promMARDESA == 10.0)

                        <b>{{number_format((float)$promMARDESA, 0, '.', '')}}</b>

                        @else
                        <b>{{number_format((float)$promMARDESA, 1, '.', '')}}</b>
                        @endif
                      @else

                      @endif
                    </td>

                    {{--  promedio general segundo periodo   --}}
                    <td align="center">
                      @if ($PromedioGen2DESA != "")
                        @if ($PromedioGen2DESA == 1.0 || $PromedioGen2DESA == 2.0 || $PromedioGen2DESA == 3.0 || $PromedioGen2DESA == 4.0 ||
                        $PromedioGen2DESA == 5.0 || $PromedioGen2DESA == 6.0 || $PromedioGen2DESA == 7.0 || $PromedioGen2DESA == 8.0 ||
                        $PromedioGen2DESA == 9.0 || $PromedioGen2DESA == 10.0)

                        <b>{{number_format((float)$PromedioGen2DESA, 0, '.', '')}}</b>

                        @else
                        {{--  <b>{{number_format((float)$PromedioGen2DESA, 1, '.', '')}}</b>  --}}
                        <b>{{TruncarDecimales::truncateFloat($PromedioGen2DESA, 1)}}</b>
                        @endif
                      @else

                      @endif
                    </td>
                    {{--  promedio general SEP segundo periodo   --}}
                    <td align="center">
                      @if ($PromedioGen2SEPDESA != "")
                      {{--  <b>{{$PromedioGen2SEPDESA}}</b>  --}}
                      <b>{{round($PromedioGen2SEPDESA)}}</b>
                      @else

                      @endif

                    </td>
                    {{--  sacar el nivel   --}}
                    @php
                    $nivSEPGenPe2 = "";
                    if ($matEspecialidad == "1FA") {
                        switch ($PromedioGen2SEPDESA) {
                            case 1:
                                $nivSEPGenPe2 = "I";
                                break;
                            case 2:
                                $nivSEPGenPe2 = "II";
                                break;
                            case 3:
                                $nivSEPGenPe2 = "III";
                                break;
                            case 4:
                                $nivSEPGenPe2 = "IV";
                                break;
                            case 5:
                                $nivSEPGenPe2 = "I";
                                break;
                            case 6:
                                $nivSEPGenPe2 = "II";
                                break;
                            case 7:
                                $nivSEPGenPe2 = "II";
                                break;
                            case 8:
                                $nivSEPGenPe2 = "III";
                                break;
                            case 9:
                                $nivSEPGenPe2 = "III";
                                break;
                            case 10:
                                $nivSEPGenPe2 = "IV";
                        }
                    } else {
                        switch ($PromedioGen2SEPDESA) {
                            case 0:
                                $nivSEPGenPe2 = "";
                                break;
                            case 1:
                                $nivSEPGenPe2 = "1";
                                break;
                            case 2:
                                $nivSEPGenPe2 = "1";
                                break;
                            case 3:
                                $nivSEPGenPe2 = "1";
                                break;
                            case 4:
                                $nivSEPGenPe2 = "1";
                                break;
                            case 5:
                                $nivSEPGenPe2 = "1";
                                break;
                            case 6:
                                $nivSEPGenPe2 = "2";
                                break;
                            case 7:
                                $nivSEPGenPe2 = "2";
                                break;
                            case 8:
                                $nivSEPGenPe2 = "3";
                                break;
                            case 9:
                                $nivSEPGenPe2 = "3";
                                break;
                            case 10:
                                $nivSEPGenPe2 = "4";
                        }
                    }

                    @endphp



                    {{-- @if ($nivSEPGenPe2 != "")
                      <td align="center"><b>{{$nivSEPGenPe2}}</b></td>
                    @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                    @endif --}}

                    {{--  tercer periodo   --}}
                    {{--  promedio abril  --}}
                    <td align="center">

                      @if ($promABRDESA != "")
                        @if ($promABRDESA == 1.0 || $promABRDESA == 2.0 || $promABRDESA == 3.0 || $promABRDESA == 4.0 ||
                        $promABRDESA == 5.0 || $promABRDESA == 6.0 || $promABRDESA == 7.0 || $promABRDESA == 8.0 ||
                        $promABRDESA == 9.0 || $promABRDESA == 10.0)

                        <b>{{number_format((float)$promABRDESA, 0, '.', '')}}</b>

                        @else
                        <b>{{number_format((float)$promABRDESA, 1, '.', '')}}</b>
                        @endif
                      @else

                      @endif
                    </td>

                    {{--  promedio mayo  --}}
                    <td align="center">

                      @if ($promMAYDESA != "")
                        @if ($promMAYDESA == 1.0 || $promMAYDESA == 2.0 || $promMAYDESA == 3.0 || $promMAYDESA == 4.0 ||
                        $promMAYDESA == 5.0 || $promMAYDESA == 6.0 || $promMAYDESA == 7.0 || $promMAYDESA == 8.0 ||
                        $promMAYDESA == 9.0 || $promMAYDESA == 10.0)

                        <b>{{number_format((float)$promMAYDESA, 0, '.', '')}}</b>

                        @else
                        <b>{{number_format((float)$promMAYDESA, 1, '.', '')}}</b>
                        @endif
                      @else

                      @endif

                    </td>

                    {{--  promedio junio  --}}
                    <td align="center">

                      @if ($promJUNDESA != "")
                        @if ($promJUNDESA == 1.0 || $promJUNDESA == 2.0 || $promJUNDESA == 3.0 || $promJUNDESA == 4.0 ||
                        $promJUNDESA == 5.0 || $promJUNDESA == 6.0 || $promJUNDESA == 7.0 || $promJUNDESA == 8.0 ||
                        $promJUNDESA == 9.0 || $promJUNDESA == 10.0)

                        <b>{{number_format((float)$promJUNDESA, 0, '.', '')}}</b>

                        @else
                        <b>{{number_format((float)$promJUNDESA, 1, '.', '')}}</b>
                        @endif
                      @else

                      @endif
                    </td>

                    {{--  promedio general tercer periodo   --}}
                    <td align="center">

                      @if ($PromedioGen3DESA != "")
                        @if ($PromedioGen3DESA == 1.0 || $PromedioGen3DESA == 2.0 || $PromedioGen3DESA == 3.0 || $PromedioGen3DESA == 4.0 ||
                        $PromedioGen3DESA == 5.0 || $PromedioGen3DESA == 6.0 || $PromedioGen3DESA == 7.0 || $PromedioGen3DESA == 8.0 ||
                        $PromedioGen3DESA == 9.0 || $PromedioGen3DESA == 10.0)

                        <b>{{number_format((float)$PromedioGen3DESA, 0, '.', '')}}</b>

                        @else
                        {{--  <b>{{number_format((float)$PromedioGen3DESA, 1, '.', '')}}</b>  --}}
                        <b>{{TruncarDecimales::truncateFloat($PromedioGen3DESA, 1)}}</b>
                        @endif
                      @else

                      @endif
                    </td>
                    {{--  promedio general SEP tercer periodo   --}}
                    <td align="center">
                      @if ($PromedioGen3SEPDESA == "")
                          <b></b>
                      @else
                        {{--  <b>{{$PromedioGen3SEPDESA}}</b>  --}}
                        {{round($PromedioGen3SEPDESA)}}
                      @endif
                    </td>

                    {{--  sacar el nivel   --}}
                    @php
                    $nivSEPGenPe3 = "";
                    if ($matEspecialidad == "1FA") {
                        switch ($PromedioGen3SEPDESA) {
                            case 1:
                                $nivSEPGenPe3 = "I";
                                break;
                            case 2:
                                $nivSEPGenPe3 = "II";
                                break;
                            case 3:
                                $nivSEPGenPe3 = "III";
                                break;
                            case 4:
                                $nivSEPGenPe3 = "IV";
                                break;
                            case 5:
                                $nivSEPGenPe3 = "I";
                                break;
                            case 6:
                                $nivSEPGenPe3 = "II";
                                break;
                            case 7:
                                $nivSEPGenPe3 = "II";
                                break;
                            case 8:
                                $nivSEPGenPe3 = "III";
                                break;
                            case 9:
                                $nivSEPGenPe3 = "III";
                                break;
                            case 10:
                                $nivSEPGenPe3 = "IV";
                        }
                    } else {
                        switch ($PromedioGen3SEPDESA) {
                            case 0:
                                $nivSEPGenPe3 = "";
                                break;
                            case 1:
                                $nivSEPGenPe3 = "1";
                                break;
                            case 2:
                                $nivSEPGenPe3 = "1";
                                break;
                            case 3:
                                $nivSEPGenPe3 = "1";
                                break;
                            case 4:
                                $nivSEPGenPe3 = "1";
                                break;
                            case 5:
                                $nivSEPGenPe3 = "1";
                                break;
                            case 6:
                                $nivSEPGenPe3 = "2";
                                break;
                            case 7:
                                $nivSEPGenPe3 = "2";
                                break;
                            case 8:
                                $nivSEPGenPe3 = "3";
                                break;
                            case 9:
                                $nivSEPGenPe3 = "3";
                                break;
                            case 10:
                                $nivSEPGenPe3 = "4";
                        }
                    }

                    @endphp




                    {{-- @if ($nivSEPGenPe3 != "")
                      <td align="center"><b>{{$nivSEPGenPe3}}</b></td>
                    @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                    @endif --}}

                    {{--  promedio final de la sep   --}}
                    <td align="center">

                      @if ($promedioFinalDESA != "")
                        @if($PromedioGen1DESA != "" && $promedioGen1FA != "" && $PromedioGen3DESA != "")
                          @if ($promedioFinalDESA == 1.0 || $promedioFinalDESA == 2.0 || $promedioFinalDESA == 3.0 || $promedioFinalDESA == 4.0 ||
                          $promedioFinalDESA == 5.0 || $promedioFinalDESA == 6.0 || $promedioFinalDESA == 7.0 || $promedioFinalDESA == 8.0 ||
                          $promedioFinalDESA == 9.0 || $promedioFinalDESA == 10.0)

                          <b>{{number_format((float)$promedioFinalDESA, 0, '.', '')}}</b>

                          @else
                          <b>{{number_format((float)$promedioFinalDESA, 1, '.', '')}}</b>
                          @endif
                        @endif
                      @else

                      @endif
                    </td>
                    <td align="center">
                      @if ($promedioFinalSEPDESA != "")
                        @if($PromedioGen1DESA != "" && $promedioGen1FA != "" && $PromedioGen3DESA != "")
                          @if ($promedioFinalSEPDESA == 1.0 || $promedioFinalSEPDESA == 2.0 || $promedioFinalSEPDESA == 3.0 || $promedioFinalSEPDESA == 4.0 ||
                          $promedioFinalSEPDESA == 5.0 || $promedioFinalSEPDESA == 6.0 || $promedioFinalSEPDESA == 7.0 || $promedioFinalSEPDESA == 8.0 ||
                          $promedioFinalSEPDESA == 9.0 || $promedioFinalSEPDESA == 10.0)

                          <b>{{number_format((float)$promedioFinalSEPDESA, 0, '.', '')}}</b>

                          @else
                          <b>{{number_format((float)$promedioFinalSEPDESA, 1, '.', '')}}</b>
                          @endif
                        @endif
                      @else

                      @endif
                    </td>

                    {{--  sacar el nivel   --}}
                    @php
                    $nivSEPGenFinal = "";
                    if ($matEspecialidad == "1FA") {
                        switch ($promedioFinalSEPDESA) {
                            case 1:
                                $nivSEPGenFinal = "I";
                                break;
                            case 2:
                                $nivSEPGenFinal = "II";
                                break;
                            case 3:
                                $nivSEPGenFinal = "III";
                                break;
                            case 4:
                                $nivSEPGenFinal = "IV";
                                break;
                            case 5:
                                $nivSEPGenFinal = "I";
                                break;
                            case 6:
                                $nivSEPGenFinal = "II";
                                break;
                            case 7:
                                $nivSEPGenFinal = "II";
                                break;
                            case 8:
                                $nivSEPGenFinal = "III";
                                break;
                            case 9:
                                $nivSEPGenFinal = "III";
                                break;
                            case 10:
                                $nivSEPGenFinal = "IV";
                        }
                    } else {
                        switch ($promedioFinalSEPDESA) {
                            case 0:
                                $nivSEPGenFinal = "";
                                break;
                            case 1:
                                $nivSEPGenFinal = "1";
                                break;
                            case 2:
                                $nivSEPGenFinal = "1";
                                break;
                            case 3:
                                $nivSEPGenFinal = "1";
                                break;
                            case 4:
                                $nivSEPGenFinal = "1";
                                break;
                            case 5:
                                $nivSEPGenFinal = "1";
                                break;
                            case 6:
                                $nivSEPGenFinal = "2";
                                break;
                            case 7:
                                $nivSEPGenFinal = "2";
                                break;
                            case 8:
                                $nivSEPGenFinal = "3";
                                break;
                            case 9:
                                $nivSEPGenFinal = "3";
                                break;
                            case 10:
                                $nivSEPGenFinal = "4";
                        }
                    }

                    @endphp



                    {{-- @if ($nivSEPGenFinal != "")
                      <td align="center"><b>{{$nivSEPGenFinal}}</b></td>
                    @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                    @endif --}}
                  </tr>

                </tbody>
              </table>

              {{--  PROYECTO ARTÍSTICO  --}}


              {{--  OPTATIVAS  --}}
              <br>
              <table class="table table-bordered">
                <thead>

                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)
                      @if ($item->matNombreEspecialidad == "OPTATIVAS")
                      <tr>
                        @php
                            $keyMatOPTA++;

                            $sumaComputacionConductaSep = $sumaComputacionConductaSep + $item->inscCalificacionSep;
                            $sumaComputacionConductaOct = $sumaComputacionConductaOct + $item->inscCalificacionOct;
                            $sumaComputacionConductaNov = $sumaComputacionConductaNov + $item->inscCalificacionNov;
                            $sumaComputacionConductaEne = $sumaComputacionConductaEne + $item->inscCalificacionDicEnero;
                            $sumaComputacionConductaFeb = $sumaComputacionConductaFeb + $item->inscCalificacionFeb;
                            $sumaComputacionConductaMar = $sumaComputacionConductaMar + $item->inscCalificacionMar;
                            $sumaComputacionConductaAbr = $sumaComputacionConductaAbr + $item->inscCalificacionAbr;
                            $sumaComputacionConductaMay = $sumaComputacionConductaMay + $item->inscCalificacionMay;
                            $sumaComputacionConductaJun = $sumaComputacionConductaJun + $item->inscCalificacionJun;

                            $sumaPromedio1OPTA = $sumaPromedio1OPTA + $item->inscTrimestre1;
                            $sumaPromedio2OPTA = $sumaPromedio2OPTA + $item->inscTrimestre2;
                            $sumaPromedio3OPTA = $sumaPromedio3OPTA + $item->inscTrimestre3;
                            $sumaPromedioFinalOPTA = $sumaPromedioFinalOPTA + $item->inscPromedioTrimCALCULADO;
                        @endphp
                        <td style="width: 200px;">{{$item->matNombreOficial}}</td>

                        @if ($item->inscCalificacionSep != "")
                        <td align="center" style="width: 34px;">
                              @if ($item->inscCalificacionSep == 1.0 || $item->inscCalificacionSep == 2.0 || $item->inscCalificacionSep == 3.0 || $item->inscCalificacionSep == 4.0 ||
                              $item->inscCalificacionSep == 5.0 || $item->inscCalificacionSep == 6.0 || $item->inscCalificacionSep == 7.0 || $item->inscCalificacionSep == 8.0 ||
                              $item->inscCalificacionSep == 9.0 || $item->inscCalificacionSep == 10.0)

                              <b>{{number_format((float)$item->inscCalificacionSep, 0, '.', '')}}</b>

                              @else
                              <b>{{number_format((float)$item->inscCalificacionSep, 1, '.', '')}}</b>
                              @endif
                        </td>
                        @else
                        <td align="center" style="width: 34px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionOct != "")
                        <td align="center" style="width: 34px;">

                          @if ($item->inscCalificacionOct == 1.0 || $item->inscCalificacionOct == 2.0 || $item->inscCalificacionOct == 3.0 || $item->inscCalificacionOct == 4.0 ||
                            $item->inscCalificacionOct == 5.0 || $item->inscCalificacionOct == 6.0 || $item->inscCalificacionOct == 7.0 || $item->inscCalificacionOct == 8.0 ||
                            $item->inscCalificacionOct == 9.0 || $item->inscCalificacionOct == 10.0)

                            <b>{{number_format((float)$item->inscCalificacionOct, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$item->inscCalificacionOct, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 34px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionNov != "")
                        <td align="center" style="width: 37px;">
                         @if ($item->inscCalificacionNov == 1.0 || $item->inscCalificacionNov == 2.0 || $item->inscCalificacionNov == 3.0 || $item->inscCalificacionNov == 4.0 ||
                            $item->inscCalificacionNov == 5.0 || $item->inscCalificacionNov == 6.0 || $item->inscCalificacionNov == 7.0 || $item->inscCalificacionNov == 8.0 ||
                            $item->inscCalificacionNov == 9.0 || $item->inscCalificacionNov == 10.0)

                            <b>{{number_format((float)$item->inscCalificacionNov, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$item->inscCalificacionNov, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 37px;"><label style="opacity: .01;">0</label></td>
                        @endif



                        {{--  promedio trimestree 1  --}}
                        @if ($item->inscTrimestre1 != "")
                        <td align="center" style="width: 43px;">
                          @if ($item->inscTrimestre1 == 1.0 || $item->inscTrimestre1 == 2.0 ||
                          $item->inscTrimestre1 == 3.0 || $item->inscTrimestre1 == 4.0 ||
                          $item->inscTrimestre1 == 5.0 || $item->inscTrimestre1 == 6.0 ||
                          $item->inscTrimestre1 == 7.0 || $item->inscTrimestre1 == 8.0 ||
                          $item->inscTrimestre1 == 9.0 || $item->inscTrimestre1 == 10.0)

                          <b>{{number_format((float)$item->inscTrimestre1, 0, '.', '')}}</b>

                          @else
                          <b>{{number_format((float)$item->inscTrimestre1, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 43px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{-- <td style="width: 38px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td> --}}
                        <td style="width: 46px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        @if ($item->inscCalificacionDicEnero != "")
                        <td align="center" style="width: 35px;">
                          @if ($item->inscCalificacionDicEnero == 1.0 || $item->inscCalificacionDicEnero == 2.0 || $item->inscCalificacionDicEnero == 3.0 || $item->inscCalificacionDicEnero == 4.0 ||
                            $item->inscCalificacionDicEnero == 5.0 || $item->inscCalificacionDicEnero == 6.0 || $item->inscCalificacionDicEnero == 7.0 || $item->inscCalificacionDicEnero == 8.0 ||
                            $item->inscCalificacionDicEnero == 9.0 || $item->inscCalificacionDicEnero == 10.0)

                            <b>{{number_format((float)$item->inscCalificacionDicEnero, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$item->inscCalificacionDicEnero, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        @if ($item->inscCalificacionFeb != "")
                        <td align="center" style="width: 34px;">


                          @if ($item->inscCalificacionFeb == 1.0 || $item->inscCalificacionFeb == 2.0 || $item->inscCalificacionFeb == 3.0 || $item->inscCalificacionFeb == 4.0 ||
                            $item->inscCalificacionFeb == 5.0 || $item->inscCalificacionFeb == 6.0 || $item->inscCalificacionFeb == 7.0 || $item->inscCalificacionFeb == 8.0 ||
                            $item->inscCalificacionFeb == 9.0 || $item->inscCalificacionFeb == 10.0)

                            <b>{{number_format((float)$item->inscCalificacionFeb, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$item->inscCalificacionFeb, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 34px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionMar != "")
                        <td align="center" style="width: 39px;">
                          @if ($item->inscCalificacionMar == 1.0 || $item->inscCalificacionMar == 2.0 || $item->inscCalificacionMar == 3.0 || $item->inscCalificacionMar == 4.0 ||
                            $item->inscCalificacionMar == 5.0 || $item->inscCalificacionMar == 6.0 || $item->inscCalificacionMar == 7.0 || $item->inscCalificacionMar == 8.0 ||
                            $item->inscCalificacionMar == 9.0 || $item->inscCalificacionMar == 10.0)

                            <b>{{number_format((float)$item->inscCalificacionMar, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$item->inscCalificacionMar, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 39px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  promedio trimestre 2   --}}
                        @if ($item->inscTrimestre2 != "")
                        <td align="center" style="width: 43px;"><b>{{number_format((float)$item->inscTrimestre2, 1, '.', '')}}</b></td>
                        @else
                        <td align="center" style="width: 43px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        {{-- <td style="width: 35px; border-top: 0px s}olid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td> --}}
                        <td style="width: 46px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>


                        @if ($item->inscCalificacionAbr != "")
                        <td align="center" style="width: 35px;">

                          @if ($item->inscCalificacionAbr == 1.0 || $item->inscCalificacionAbr == 2.0 || $item->inscCalificacionAbr == 3.0 || $item->inscCalificacionAbr == 4.0 ||
                            $item->inscCalificacionAbr == 5.0 || $item->inscCalificacionAbr == 6.0 || $item->inscCalificacionAbr == 7.0 || $item->inscCalificacionAbr == 8.0 ||
                            $item->inscCalificacionAbr == 9.0 || $item->inscCalificacionAbr == 10.0)

                            <b>{{number_format((float)$item->inscCalificacionAbr, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$item->inscCalificacionAbr, 1, '.', '')}}</b>
                          @endif

                        </td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionMay != "")
                        <td align="center" style="width: 36px;">

                          @if ($item->inscCalificacionMay == 1.0 || $item->inscCalificacionMay == 2.0 || $item->inscCalificacionMay == 3.0 || $item->inscCalificacionMay == 4.0 ||
                            $item->inscCalificacionMay == 5.0 || $item->inscCalificacionMay == 6.0 || $item->inscCalificacionMay == 7.0 || $item->inscCalificacionMay == 8.0 ||
                            $item->inscCalificacionMay == 9.0 || $item->inscCalificacionMay == 10.0)

                            <b>{{number_format((float)$item->inscCalificacionMay, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$item->inscCalificacionMay, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionJun != "")
                        <td align="center" style="width: 34px;">

                          @if ($item->inscCalificacionJun == 1.0 || $item->inscCalificacionJun == 2.0 || $item->inscCalificacionJun == 3.0 || $item->inscCalificacionJun == 4.0 ||
                            $item->inscCalificacionJun == 5.0 || $item->inscCalificacionJun == 6.0 || $item->inscCalificacionJun == 7.0 || $item->inscCalificacionJun == 8.0 ||
                            $item->inscCalificacionJun == 9.0 || $item->inscCalificacionJun == 10.0)

                            <b>{{number_format((float)$item->inscCalificacionJun, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$item->inscCalificacionJun, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 34px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        {{--  promedio trimestre 3   --}}
                        @if ($item->inscTrimestre3 != "")
                        <td align="center" style="width: 43px;">

                          @if ($item->inscTrimestre3 == 1.0 || $item->inscTrimestre3 == 2.0 || $item->inscTrimestre3 == 3.0 || $item->inscTrimestre3 == 4.0 ||
                            $item->inscTrimestre3 == 5.0 || $item->inscTrimestre3 == 6.0 || $item->inscTrimestre3 == 7.0 || $item->inscTrimestre3 == 8.0 ||
                            $item->inscTrimestre3 == 9.0 || $item->inscTrimestre3 == 10.0)

                            <b>{{number_format((float)$item->inscTrimestre3, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$item->inscTrimestre3, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td style="width: 43px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{-- <td style="width: 33px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td> --}}
                        <td style="width: 45px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        {{--  promedio final   --}}
                        @if ($item->inscPromedioTrimCALCULADO != "")
                        <td align="center" style="width: 44px;">
                          @if($item->inscTrimestre1 != "" && $item->inscTrimestre2 != "" && $item->inscTrimestre3 != "")
                            @if ($item->inscPromedioTrimCALCULADO == 1.0 || $item->inscPromedioTrimCALCULADO == 2.0 || $item->inscPromedioTrimCALCULADO == 3.0 || $item->inscPromedioTrimCALCULADO == 4.0 ||
                              $item->inscPromedioTrimCALCULADO == 5.0 || $item->inscPromedioTrimCALCULADO == 6.0 || $item->inscPromedioTrimCALCULADO == 7.0 || $item->inscPromedioTrimCALCULADO == 8.0 ||
                              $item->inscPromedioTrimCALCULADO == 9.0 || $item->inscPromedioTrimCALCULADO == 10.0)

                              <b>{{number_format((float)$item->inscPromedioTrimCALCULADO, 0, '.', '')}}</b>

                            @else
                              <b>{{number_format((float)$item->inscPromedioTrimCALCULADO, 1, '.', '')}}</b>
                            @endif
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 44px;"><label style="opacity: .01;">0</label></td>
                        @endif


                        {{--  promedio final sep   --}}
                        <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">{{""}}</td>
                        {{-- <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">{{""}}</td> --}}
                      </tr>
                      @endif
                    @endif
                  @endforeach



                </tbody>
              </table>


              {{--  PROMEDIO GENERAL   --}}
              <br>
              <table class="table table-bordered">
                <thead>

                </thead>
                <tbody>
                  @php
                  $totalMaterias = $totalMaterias + $keyMatFA + $keyMatDESA + $keyMatOPTA;

                       $promSEPGENERAL = ($sumaPromediosFASep + $sumaPromediosDESASep + $sumaComputacionConductaSep) / $totalMaterias;
                       $promOCTGENERAL = ($sumaPromediosFAOct + $sumaPromediosDESAOct + $sumaComputacionConductaOct) / $totalMaterias;
                        $promNOVGENERAL = ($sumaPromediosFANov + $sumaPromediosDESANov + $sumaComputacionConductaNov) / $totalMaterias;
                        $promGENGENERAL1 = ($sumaPromedio1FA + $sumaPromedio1DESA + $sumaPromedio1OPTA) / $totalMaterias;
                        $promDICENEGENERAL = ($sumaPromediosFAEne + $sumaPromediosDESAEne + $sumaComputacionConductaEne) / $totalMaterias;
                        $promFEBGENERAL = ($sumaPromediosFAFeb + $sumaPromediosDESAFeb + $sumaComputacionConductaFeb) / $totalMaterias;
                        $promMARGENERAL = ($sumaPromediosFAMar + $sumaPromediosDESAMar + $sumaComputacionConductaMar) / $totalMaterias;
                        $promGENGENERAL2 = ($sumaPromedio2FA + $sumaPromedio2DESA + $sumaPromedio2OPTA) / $totalMaterias;
                        $promABRGENERAL = ($sumaPromediosFAAbr + $sumaPromediosDESAAbr + $sumaComputacionConductaAbr) / $totalMaterias;
                        $promMAYGENERAL = ($sumaPromediosFAMay + $sumaPromediosDESAMay + $sumaComputacionConductaMay) / $totalMaterias;
                        $promJUNGENERAL = ($sumaPromediosFAJun + $sumaPromediosDESAJun + $sumaComputacionConductaJun) / $totalMaterias;
                        $promGENGENERAL3 = ($sumaPromedio3FA + $sumaPromedio3DESA + $sumaPromedio3OPTA) / $totalMaterias;
                        $promFINALGENERAL = ($sumaPromedioFinalFA + $sumaPromedioFinalDESA + $sumaPromedioFinalOPTA) / $totalMaterias;
                   @endphp

                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)
                     @php
                         $keyPromedioGeneral++;

                     @endphp
                     @if ($keyPromedioGeneral == 1)
                      <tr>
                        <td style="width: 165px;"><b>PROMEDIO GENERAL</b></td>

                        @if ($promSEPGENERAL != "")
                        <td align="center" style="width: 27px;">
                          @if ($promSEPGENERAL == 1.0 || $promSEPGENERAL == 2.0 || $promSEPGENERAL == 3.0 || $promSEPGENERAL == 4.0 ||
                            $promSEPGENERAL == 5.0 || $promSEPGENERAL == 6.0 || $promSEPGENERAL == 7.0 || $promSEPGENERAL == 8.0 ||
                            $promSEPGENERAL == 9.0 || $promSEPGENERAL == 10.0)

                            <b>{{number_format((float)$promSEPGENERAL, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promSEPGENERAL, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($promOCTGENERAL != "")
                        <td align="center" style="width: 27px;">

                          @if ($promOCTGENERAL == 1.0 || $promOCTGENERAL == 2.0 || $promOCTGENERAL == 3.0 || $promOCTGENERAL == 4.0 ||
                            $promOCTGENERAL == 5.0 || $promOCTGENERAL == 6.0 || $promOCTGENERAL == 7.0 || $promOCTGENERAL == 8.0 ||
                            $promOCTGENERAL == 9.0 || $promOCTGENERAL == 10.0)

                            <b>{{number_format((float)$promOCTGENERAL, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promOCTGENERAL, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($promNOVGENERAL != "")
                        <td align="center" style="width: 30px;">

                          @if ($promNOVGENERAL == 1.0 || $promNOVGENERAL == 2.0 || $promNOVGENERAL == 3.0 || $promNOVGENERAL == 4.0 ||
                            $promNOVGENERAL == 5.0 || $promNOVGENERAL == 6.0 || $promNOVGENERAL == 7.0 || $promNOVGENERAL == 8.0 ||
                            $promNOVGENERAL == 9.0 || $promNOVGENERAL == 10.0)

                            <b>{{number_format((float)$promNOVGENERAL, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promNOVGENERAL, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 30px;"><label style="opacity: .01;">0</label></td>
                        @endif

                         {{--  promedio trimestree 1  --}}
                         @if ($promGENGENERAL1 != "")
                         <td align="center" style="width: 34px;">

                          @if ($promGENGENERAL1 == 1.0 || $promGENGENERAL1 == 2.0 || $promGENGENERAL1 == 3.0 || $promGENGENERAL1 == 4.0 ||
                            $promGENGENERAL1 == 5.0 || $promGENGENERAL1 == 6.0 || $promGENGENERAL1 == 7.0 || $promGENGENERAL1 == 8.0 ||
                            $promGENGENERAL1 == 9.0 || $promGENGENERAL1 == 10.0)

                            <b>{{number_format((float)$promGENGENERAL1, 0, '.', '')}}</b>
                            {{--  aqui   --}}

                          @else
                            <b>{{number_format((float)$promGENGENERAL1, 1, '.', '')}}</b>
                          @endif
                        </td>
                         @else
                         <td align="center" style="width: 34px;"><label style="opacity: .01;">0</label></td>
                         @endif

                        <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        {{-- <td align="center" style="width: 35px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td> --}}

                        @if ($promDICENEGENERAL != "")
                        <td align="center" style="width: 29px">
                          @if ($promDICENEGENERAL == 1.0 || $promDICENEGENERAL == 2.0 || $promDICENEGENERAL == 3.0 || $promDICENEGENERAL == 4.0 ||
                            $promDICENEGENERAL == 5.0 || $promDICENEGENERAL == 6.0 || $promDICENEGENERAL == 7.0 || $promDICENEGENERAL == 8.0 ||
                            $promDICENEGENERAL == 9.0 || $promDICENEGENERAL == 10.0)

                            <b>{{number_format((float)$promDICENEGENERAL, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promDICENEGENERAL, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 29px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($promFEBGENERAL != "")
                        <td align="center" style="width: 27px">

                          @if ($promFEBGENERAL == 1.0 || $promFEBGENERAL == 2.0 || $promFEBGENERAL == 3.0 || $promFEBGENERAL == 4.0 ||
                            $promFEBGENERAL == 5.0 || $promFEBGENERAL == 6.0 || $promFEBGENERAL == 7.0 || $promFEBGENERAL == 8.0 ||
                            $promFEBGENERAL == 9.0 || $promFEBGENERAL == 10.0)

                            <b>{{number_format((float)$promFEBGENERAL, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promFEBGENERAL, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($promMARGENERAL != "")
                        <td align="center" style="width: 31px">

                          @if ($promMARGENERAL == 1.0 || $promMARGENERAL == 2.0 || $promMARGENERAL == 3.0 || $promMARGENERAL == 4.0 ||
                            $promMARGENERAL == 5.0 || $promMARGENERAL == 6.0 || $promMARGENERAL == 7.0 || $promMARGENERAL == 8.0 ||
                            $promMARGENERAL == 9.0 || $promMARGENERAL == 10.0)

                            <b>{{number_format((float)$promMARGENERAL, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promMARGENERAL, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 31px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  promedio trimestre 2   --}}
                        @if ($promGENGENERAL2 != "")
                        <td align="center" style="width: 35px">

                          @if ($promGENGENERAL2 == 1.0 || $promGENGENERAL2 == 2.0 || $promGENGENERAL2 == 3.0 || $promGENGENERAL2 == 4.0 ||
                            $promGENGENERAL2 == 5.0 || $promGENGENERAL2 == 6.0 || $promGENGENERAL2 == 7.0 || $promGENGENERAL2 == 8.0 ||
                            $promGENGENERAL2 == 9.0 || $promGENGENERAL2 == 10.0)

                            <b>{{number_format((float)$promGENGENERAL2, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promGENGENERAL2, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        <td style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        {{-- <td style="width: 35px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td> --}}

                        @if ($promABRGENERAL != "")
                        <td align="center" style="width: 28px;">
                          @if ($promABRGENERAL == 1.0 || $promABRGENERAL == 2.0 || $promABRGENERAL == 3.0 || $promABRGENERAL == 4.0 ||
                            $promABRGENERAL == 5.0 || $promABRGENERAL == 6.0 || $promABRGENERAL == 7.0 || $promABRGENERAL == 8.0 ||
                            $promABRGENERAL == 9.0 || $promABRGENERAL == 10.0)

                            <b>{{number_format((float)$promABRGENERAL, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promABRGENERAL, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 28px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($promMAYGENERAL != "")
                        <td align="center" style="width: 29px;">

                          @if ($promMAYGENERAL == 1.0 || $promMAYGENERAL == 2.0 || $promMAYGENERAL == 3.0 || $promMAYGENERAL == 4.0 ||
                            $promMAYGENERAL == 5.0 || $promMAYGENERAL == 6.0 || $promMAYGENERAL == 7.0 || $promMAYGENERAL == 8.0 ||
                            $promMAYGENERAL == 9.0 || $promMAYGENERAL == 10.0)

                            <b>{{number_format((float)$promMAYGENERAL, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promMAYGENERAL, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 29px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($promJUNGENERAL != "")
                        <td align="center" style="width: 27px;">

                          @if ($promJUNGENERAL == 1.0 || $promJUNGENERAL == 2.0 || $promJUNGENERAL == 3.0 || $promJUNGENERAL == 4.0 ||
                            $promJUNGENERAL == 5.0 || $promJUNGENERAL == 6.0 || $promJUNGENERAL == 7.0 || $promJUNGENERAL == 8.0 ||
                            $promJUNGENERAL == 9.0 || $promJUNGENERAL == 10.0)

                            <b>{{number_format((float)$promJUNGENERAL, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promJUNGENERAL, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  promedio trimestre 3   --}}
                        @if ($promGENGENERAL3 != "")
                        <td align="center" style="width: 35px;">

                          @if ($promGENGENERAL3 == 1.0 || $promGENGENERAL3 == 2.0 || $promGENGENERAL3 == 3.0 || $promGENGENERAL3 == 4.0 ||
                            $promGENGENERAL3 == 5.0 || $promGENGENERAL3 == 6.0 || $promGENGENERAL3 == 7.0 || $promGENGENERAL3 == 8.0 ||
                            $promGENGENERAL3 == 9.0 || $promGENGENERAL3 == 10.0)

                            <b>{{number_format((float)$promGENGENERAL3, 0, '.', '')}}</b>

                          @else
                            <b>{{number_format((float)$promGENGENERAL3, 1, '.', '')}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        {{-- <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td> --}}

                        {{--  promedio final   --}}
                        @if ($promFINALGENERAL != "")
                        <td align="center" style="width: 36px;">
                          @if($promGENGENERAL1 != "" && $promGENGENERAL2 != "" && $promGENGENERAL3 != "")
                            @if ($promFINALGENERAL == 1.0 || $promFINALGENERAL == 2.0 || $promFINALGENERAL == 3.0 || $promFINALGENERAL == 4.0 ||
                              $promFINALGENERAL == 5.0 || $promFINALGENERAL == 6.0 || $promFINALGENERAL == 7.0 || $promFINALGENERAL == 8.0 ||
                              $promFINALGENERAL == 9.0 || $promFINALGENERAL == 10.0)

                              <b>{{number_format((float)$promFINALGENERAL, 0, '.', '')}}</b>

                            @else
                              <b>{{number_format((float)$promFINALGENERAL, 1, '.', '')}}</b>
                            @endif
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  promedio final sep   --}}
                        <td style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        {{-- <td style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td> --}}
                      </tr>
                     @endif
                    @endif
                  @endforeach

                </tbody>
              </table>

              {{--  ARTE, CULTURA, DEPORTE  --}}
              <br>


              {{--  INASISTENCIAS  --}}
              @foreach($calificaciones as $key => $inasistencia)
                @if ($inasistencia->clave_pago == $clave_pago)
                @php
                    $Keynasistencias++;

                    #$faltasSep = $faltasSep + $inasistencia->falTotalSep;
                    #$faltasOct = $faltasOct + $inasistencia->falTotalOct;
                    #$faltasNov = $faltasNov + $inasistencia->falTotalNov;
                    #$faltasEne = $faltasEne + $inasistencia->falTotalEne;
                    #$faltasFeb = $faltasFeb + $inasistencia->falTotalFeb;
                    #$faltasMar = $faltasMar + $inasistencia->falTotalMar;
                    #$faltasAbr = $faltasAbr + $inasistencia->falTotalAbr;
                    #$faltasMay = $faltasMay + $inasistencia->falTotalMay;
                    #$faltasJun = $faltasJun + $inasistencia->falTotalJun;

                    #$totalFaltas = $faltasSep + $faltasOct + $faltasNov + $faltasEne + $faltasFeb + $faltasMar + $faltasAbr + $faltasMay + $faltasJun;

                    $faltaAlumno = DB::select("SELECT * FROM primaria_faltas WHERE curso_id = $inasistencia->cursos_id");

                @endphp

                @endif
              @endforeach

              @forelse ($faltaAlumno as $item)
                @php
                $faltasSep = $item->falTotalSep;
                $faltasOct = $item->falTotalOct;
                $faltasNov = $item->falTotalNov;
                $faltasEne = $item->falTotalEne;
                $faltasFeb = $item->falTotalFeb;
                $faltasMar = $item->falTotalMar;
                $faltasAbr = $item->falTotalAbr;
                $faltasMay = $item->falTotalMay;
                $faltasJun = $item->falTotalJun;
                $totalFaltas = $faltasSep + $faltasOct + $faltasNov + $faltasEne + $faltasFeb + $faltasMar + $faltasAbr + $faltasMay + $faltasJun;
                @endphp
              @empty
                @php
                $faltasSep = 0;
                $faltasOct = 0;
                $faltasNov = 0;
                $faltasEne = 0;
                $faltasFeb = 0;
                $faltasMar = 0;
                $faltasAbr = 0;
                $faltasMay = 0;
                $faltasJun = 0;
                $totalFaltas = 0;
                @endphp
              @endforelse
              {{-- <br> --}}
              <table class="table table-bordered">
                <thead>

                </thead>
                <tbody>
                  <tr>
                    <td style="width: 200px;">INASISTENCIAS</td>
                    @if ($faltasSep == "" || $faltasSep == 0)
                      <td align="center" style="width: 34px;"><label style="opacity: .01;">0</label></td>
                    @else
                      <td align="center" style="width: 34px;">{{$faltasSep}}</td>
                    @endif

                    @if ($faltasOct == "" || $faltasOct == 0)
                      <td align="center" style="width: 34px;"><label style="opacity: .01;">0</label></td>
                    @else
                      <td align="center" style="width: 34px;">{{$faltasOct}}</td>
                    @endif

                    @if ($faltasNov == "" || $faltasNov == 0)
                      <td align="center" style="width: 37px;"><label style="opacity: .01;">0</label></td>
                    @else
                      <td align="center" style="width: 37px;">{{$faltasNov}}</td>
                    @endif
                    <td align="center" style="width: 45px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                    <td align="center" style="width: 46px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                    {{-- <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td> --}}

                    @if ($faltasEne == "" || $faltasEne == 0)
                      <td align="center" style="width: 34px;"><label style="opacity: .01;">0</label></td>
                    @else
                      <td align="center" style="width: 34px;">{{$faltasEne}}</td>
                    @endif

                    @if ($faltasFeb == "" || $faltasFeb == 0)
                      <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
                    @else
                      <td align="center" style="width: 36px;">{{$faltasFeb}}</td>
                    @endif

                    @if ($faltasMar == "" || $faltasMar == 0)
                      <td align="center" style="width: 39px;"><label style="opacity: .01;">0</label></td>
                    @else
                      <td align="center" style="width: 39px;">{{$faltasMar}}</td>
                    @endif
                    <td align="center" style="width: 44px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                    <td align="center" style="width: 44px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                    {{-- <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td> --}}

                    @if ($faltasAbr == "" || $faltasAbr == 0)
                      <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                    @else
                      <td align="center" style="width: 35px;">{{$faltasAbr}}</td>
                    @endif

                    @if ($faltasMay == "" || $faltasMay == 0)
                      <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
                    @else
                      <td align="center" style="width: 36px;">{{$faltasMay}}</td>
                    @endif

                    @if ($faltasJun == "" || $faltasJun == 0)
                      <td align="center" style="width: 34px;"><label style="opacity: .01;">0</label></td>
                    @else
                      <td align="center" style="width: 34px;">{{$faltasJun}}</td>
                    @endif
                    <td align="center" style="width: 45px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                    <td align="center" style="width: 44px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                    {{-- <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td> --}}

                    <td align="center" style="width: 43px;">
                      @if ($totalFaltas == "" || $totalFaltas == 0)

                      @else
                      {{$totalFaltas}}
                      @endif
                    </td> //total faltas
                    <td align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">{{""}}</td>
                    {{-- <td align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">{{""}}</td> --}}
                  </tr>
                </tbody>
              </table>

          </div>
        </div>

        <br>
        <div class="row">
          <div class="columns medium-12">
            @if ($observaciones == "NINGUNA")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;"></h3>
            @endif

            @if ($observaciones == "SEPTIEMBRE")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;">Observaciones</h3>
              <p>{{$inscrito->observacionSep}}</p>
            @endif

            @if ($observaciones == "OCTUBRE")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;">Observaciones</h3>
              <p>{{$inscrito->observacionOct}}</p>
            @endif

            @if ($observaciones == "NOVIEMBRE")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;">Observaciones</h3>
              <p>{{$inscrito->observacionNov}}</p>
            @endif

            @if ($observaciones == "DICIEMBRE")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;">Observaciones</h3>
              <p>{{$inscrito->observacionDic}}</p>
            @endif

            @if ($observaciones == "ENERO")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;">Observaciones</h3>
              <p>{{$inscrito->observacionEne}}</p>
            @endif

            @if ($observaciones == "FEBRERO")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;">Observaciones</h3>
              <p>{{$inscrito->observacionFeb}}</p>
            @endif

            @if ($observaciones == "MARZO")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;">Observaciones</h3>
              <p>{{$inscrito->observacionMar}}</p>
            @endif

            @if ($observaciones == "ABRIL")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;">Observaciones</h3>
              <p>{{$inscrito->observacionAbr}}</p>
            @endif

            @if ($observaciones == "MAYO")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;">Observaciones</h3>
              <p>{{$inscrito->observacionMay}}</p>
            @endif

            @if ($observaciones == "JUNIO")
              <h3 style="margin-top:0px; margin-bottom: 5px; text-align: left;">Observaciones</h3>
              <p>{{$inscrito->observacionJun}}</p>
            @endif
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

        $faltasSep = 0;
        $faltasOct = 0;
        $faltasNov = 0;
        $faltasEne = 0;
        $faltasFeb = 0;
        $faltasMar = 0;
        $faltasAbr = 0;
        $faltasMay = 0;
        $faltasJun = 0;

        $sumaComputacionConductaSep  = 0.0;
        $sumaComputacionConductaOct  = 0.0;
        $sumaComputacionConductaNov  = 0.0;
        $sumaComputacionConductaEne  = 0.0;
        $sumaComputacionConductaFeb  = 0.0;
        $sumaComputacionConductaMar  = 0.0;
        $sumaComputacionConductaAbr  = 0.0;
        $sumaComputacionConductaMay  = 0.0;
        $sumaComputacionConductaJun  = 0.0;

        $totalMaterias = 0;
        $sumaPromediosFASep = 0.0;
        $sumaPromediosFAOct = 0.0;
        $sumaPromediosFANov = 0.0;
        $sumaPromediosFADic = 0.0;
        $sumaPromediosFAEne = 0.0;
        $sumaPromediosFAFeb = 0.0;
        $sumaPromediosFAMar = 0.0;
        $sumaPromediosFAAbr = 0.0;
        $sumaPromediosFAMay = 0.0;
        $sumaPromediosFAJun = 0.0;

        $sumaPromediosDESASep = 0.0;
        $sumaPromediosDESAOct = 0.0;
        $sumaPromediosDESANov = 0.0;
        $sumaPromediosDESADic = 0.0;
        $sumaPromediosDESAEne = 0.0;
        $sumaPromediosDESAFeb = 0.0;
        $sumaPromediosDESAMar = 0.0;
        $sumaPromediosDESAAbr = 0.0;
        $sumaPromediosDESAMay = 0.0;
        $sumaPromediosDESAJun = 0.0;


        $sumaPromediosOPTASep = 0.0;
        $sumaPromediosOPTAOct = 0.0;
        $sumaPromediosOPTANov = 0.0;
        $sumaPromediosOPTADic = 0.0;
        $sumaPromediosOPTAEne = 0.0;
        $sumaPromediosOPTAFeb = 0.0;
        $sumaPromediosOPTAMar = 0.0;
        $sumaPromediosOPTAAbr = 0.0;
        $sumaPromediosOPTAMay = 0.0;
        $sumaPromediosOPTAJun = 0.0;

        $sumaPromedio1FA = 0.0;
        $sumaPromedio2FA = 0.0;
        $sumaPromedio3FA = 0.0;
        $sumaPromedioFinalFA = 0.0;

        $sumaPromedio1DESA = 0.0;
        $sumaPromedio2DESA = 0.0;
        $sumaPromedio3DESA = 0.0;
        $sumaPromedioFinalDESA = 0.0;

        $sumaPromedio1OPTA = 0.0;
        $sumaPromedio2OPTA = 0.0;
        $sumaPromedio3OPTA = 0.0;
        $sumaPromedioFinalOPTA = 0.0;
    @endphp
@endforeach



  </body>
</html>
