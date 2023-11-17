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
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">Secundaria</h4>
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">Clave 31PES0012T</h4>
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">{{$cicloEscolar}}</h4>

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
            @if ($inscrito->cursecundariaFoto != "")
            <img class="img-foto" src="{{base_path('storage/app/public/secundaria/cursos/fotos/' . $inscrito->perAnioPago . '/' . $inscrito->cursecundariaFoto) }}" alt="">
    
            @else
            <img class="img-foto"  src="" alt="">    
            @endif
            {{--  fin foto   --}}
            <div class="row">
              <div class="columns medium-4">
                  <div style="text-align: left;">
                        <p >Clave:<b> {{$clave_pago}}</b></p>
                        <p >Alumno:<b> {{$inscrito->nombres}} {{$inscrito->ape_paterno}} {{$inscrito->ape_materno}}</b></p>
                  </div>
              </div>
              <div class="columns medium-4">
                  <div style="text-align: center;">
                      <p >Grupo:<b> {{$inscrito->gpoGrado}}{{$inscrito->gpoClave}}</b></p>
                      <p >Curp:<b> {{$inscrito->curp}}</b></p>
                  </div>
              </div>
              <div class="columns medium-4">
                  <div style="text-align: right;">
                      <p >Fecha: {{$fechaActual}}</p>
                      <p >Hora: {{ $horaActual}}</p>
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
                          @endphp
                          <td style="width: 200px;">{{$item->matNombreOficial}}</td>

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
                                      $niv = "1";
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
    
                          <td align="center">{{$niv}}</td>

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
                                      $nivPerido2 = "1";
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
                          <td align="center">{{$nivPerido2}}</td>
                          <td align="center">{{$item->inscCalificacionAbr}}</td>
                          <td align="center">{{$item->inscCalificacionMay}}</td>
                          <td align="center">{{$item->inscCalificacionJun}}</td>

                          {{--  promedio trimestre 3   --}}
                          <td align="center">
                            @if ($item->inscTrimestre3 == "")
                                <b></b>
                            @else
                              <b>{{round($item->inscTrimestre3,1)}}</b>
                            @endif                            
                          </td>

                          <td align="center">{{$item->inscTrimestre3SEP}}</td>

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
                                                                $nivPerido3 = "1";
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
                          <td align="center">{{$nivPerido3}}</td>

                          {{--  promedio final   --}}
                          <td align="center">
                            @if (round($item->inscPromedioTrimCALCULADO, 1) == 1.0 || round($item->inscPromedioTrimCALCULADO, 1) == 2.0 || round($item->inscPromedioTrimCALCULADO, 1) == 3.0 || round($item->inscPromedioTrimCALCULADO, 1) == 4.0 || 
                              round($item->inscPromedioTrimCALCULADO, 1) == 5.0 || round($item->inscPromedioTrimCALCULADO, 1) == 6.0 || round($item->inscPromedioTrimCALCULADO, 1) == 7.0 || round($item->inscPromedioTrimCALCULADO, 1) == 8.0 || 
                              round($item->inscPromedioTrimCALCULADO, 1) == 9.0 || round($item->inscPromedioTrimCALCULADO, 1) == 10.0) 

                              {{round($item->inscPromedioTrimCALCULADO)}}

                            @else
                              {{round($item->inscPromedioTrimCALCULADO, 1)}}
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

                                                                              {{--  sacar el nivel perido 2  --}}
                                                                              @php
                                                                              $nivSEp = "";
                                                                              if ($item->matEspecialidad == "1FA") {
                                                                                  switch (round($item->inscPromedioTrimCALCULADOSEP, 1)) {
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
                                                                                          $nivSEp = "1";
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
                          <td align="center">{{$nivSEp}}</td>
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
                                                            $nivSEPPe1 = "1";
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

                      <td align="center"><b>{{$nivSEPPe1}}</b></td>

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
                                                                               $nivSEPPe2 = "1";
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

                      <td align="center"><b>{{$nivSEPPe2}}</b></td>

                      {{--  tercer periodo   --}}
                      {{--  promedio abril  --}}
                      <td align="center">
                        @if ($promABRFA == "")
                        <b></b>
                        @else
                          @if (round($promABRFA, 1) == 1.0 || round($promABRFA, 1) == 2.0 || round($promABRFA, 1) == 3.0 || round($promABRFA, 1) == 4.0 || 
                          round($promABRFA, 1) == 5.0 || round($promABRFA, 1) == 6.0 || round($promABRFA, 1) == 7.0 || round($promABRFA, 1) == 8.0 || 
                          round($promABRFA, 1) == 9.0 || round($promABRFA, 1) == 10.0) 

                          <b>{{round($promABRFA)}}</b>

                          @else
                          <b>{{round($promABRFA, 1)}}</b>
                          @endif
                        @endif
                       
                      </td>

                      {{--  promedio mayo  --}}
                      <td align="center">
                        @if ($promMAYFA == "")
                            <b></b>
                        @else
                          @if (round($promMAYFA, 1) == 1.0 || round($promMAYFA, 1) == 2.0 || round($promMAYFA, 1) == 3.0 || round($promMAYFA, 1) == 4.0 || 
                          round($promMAYFA, 1) == 5.0 || round($promMAYFA, 1) == 6.0 || round($promMAYFA, 1) == 7.0 || round($promMAYFA, 1) == 8.0 || 
                          round($promMAYFA, 1) == 9.0 || round($promMAYFA, 1) == 10.0) 

                          <b>{{round($promMAYFA)}}</b>

                          @else
                          <b>{{round($promMAYFA, 1)}}</b>
                          @endif
                        @endif
                       
                      </td>

                      {{--  promedio junio  --}}
                      <td align="center">
                        @if ($promJUNFA == "")
                            <b></b>
                        @else
                          @if (round($promJUNFA, 1) == 1.0 || round($promJUNFA, 1) == 2.0 || round($promJUNFA, 1) == 3.0 || round($promJUNFA, 1) == 4.0 || 
                          round($promJUNFA, 1) == 5.0 || round($promJUNFA, 1) == 6.0 || round($promJUNFA, 1) == 7.0 || round($promJUNFA, 1) == 8.0 || 
                          round($promJUNFA, 1) == 9.0 || round($promJUNFA, 1) == 10.0) 

                          <b>{{round($promJUNFA)}}</b>

                          @else
                          <b>{{round($promJUNFA, 1)}}</b>
                          @endif
                        @endif
                       
                      </td>

                      {{--  promedio general tercer periodo   --}}
                      <td align="center">
                        @if ($promedioGen3FA == "")
                            <b></b>
                        @else
                          @if (round($promedioGen3FA, 1) == 1.0 || round($promedioGen3FA, 1) == 2.0 || round($promedioGen3FA, 1) == 3.0 || round($promedioGen3FA, 1) == 4.0 || 
                          round($promedioGen3FA, 1) == 5.0 || round($promedioGen3FA, 1) == 6.0 || round($promedioGen3FA, 1) == 7.0 || round($promedioGen3FA, 1) == 8.0 || 
                          round($promedioGen3FA, 1) == 9.0 || round($promedioGen3FA, 1) == 10.0) 

                          <b>{{round($promedioGen3FA)}}</b>

                          @else
                          <b>{{round($promedioGen3FA, 1)}}</b>
                          @endif
                        @endif                        
                      </td>
                      {{--  promedio general SEP tercer periodo   --}}
                      <td align="center">
                        @if ($promedioGen3SEPFA == "")
                            <b></b>
                        @else
                          <b>{{$promedioGen3SEPFA}}</b>
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
                                                                                                       $nivSEPPerido3 = "1";
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

                      <td align="center"><b>{{$nivSEPPerido3}}</b></td>

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
                                                                                 $nivSEPFinal = "1";
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
                      <td align="center"><b>{{$nivSEPFinal}}</b></td>
                    </tr>        
              </tbody>
              </table>


              <br>
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
                        @endphp
                       
                        <td style="width: 200px;">{{$item->matNombreOficial}}</td>                 
                        

                        @if ($item->inscCalificacionSep != "")
                          <td align="center" style="width: 25px;">
                            @if ($item->inscCalificacionSep == 1.0 || $item->inscCalificacionSep == 2.0 || $item->inscCalificacionSep == 3.0
                            || $item->inscCalificacionSep == 4.0 ||
                            $item->inscCalificacionSep == 5.0 || $item->inscCalificacionSep == 6.0 || $item->inscCalificacionSep == 7.0 ||
                            $item->inscCalificacionSep == 8.0 ||
                            $item->inscCalificacionSep == 9.0 || $item->inscCalificacionSep == 10.0)
                    
                            {{round($item->inscCalificacionSep)}}
                    
                            @else
                            {{round($item->inscCalificacionSep, 1)}}
                            @endif
                          </td>                        
                        @else
                          <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                  

                        @if ($item->inscCalificacionOct != "")
                          <td align="center" style="width: 25px;">
                            @if ($item->inscCalificacionOct == 1.0 || $item->inscCalificacionOct == 2.0 || $item->inscCalificacionOct == 3.0
                            || $item->inscCalificacionOct == 4.0 ||
                            $item->inscCalificacionOct == 5.0 || $item->inscCalificacionOct == 6.0 || $item->inscCalificacionOct == 7.0 ||
                            $item->inscCalificacionOct == 8.0 ||
                            $item->inscCalificacionOct == 9.0 || $item->inscCalificacionOct == 10.0)
                    
                            {{round($item->inscCalificacionOct)}}
                    
                            @else
                            {{round($item->inscCalificacionOct, 1)}}
                            @endif
                          </td>
                        @else
                          <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionNov != "")
                          <td align="center" style="width: 26px;">
                            @if ($item->inscCalificacionNov == 1.0 || $item->inscCalificacionNov == 2.0 || $item->inscCalificacionNov == 3.0
                            || $item->inscCalificacionNov == 4.0 ||
                            $item->inscCalificacionNov == 5.0 || $item->inscCalificacionNov == 6.0 || $item->inscCalificacionNov == 7.0 ||
                            $item->inscCalificacionNov == 8.0 ||
                            $item->inscCalificacionNov == 9.0 || $item->inscCalificacionNov == 10.0)
                    
                            {{round($item->inscCalificacionNov)}}
                    
                            @else
                            {{round($item->inscCalificacionNov, 1)}}
                            @endif
                          </td>
                        @else
                          <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestree 1  --}}
                        @if ($item->inscTrimestre1 != "")
                        <td align="center" style="width: 35px;"><b>{{round($item->inscTrimestre1,1)}}</b></td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscTrimestre1 != "")
                        <td align="center" style="width: 36px;">{{$item->inscTrimestre1SEP}}</td>
                        @else
                        <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
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
                                    $nivSEPPe1 = "1";
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

                                                                        

                        @if ($nivSEPPe1 != "")
                          <td align="center" style="width: 36px;">{{$nivSEPPe1}}</td>
                        @else
                          <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
                        @endif
                  
                        @if ($item->inscCalificacionDicEnero != "")
                        <td align="center" style="width: 26px;">
                          @if ($item->inscCalificacionDicEnero == 1.0 || $item->inscCalificacionDicEnero == 2.0 ||
                          $item->inscCalificacionDicEnero == 3.0 || $item->inscCalificacionDicEnero == 4.0 ||
                          $item->inscCalificacionDicEnero == 5.0 || $item->inscCalificacionDicEnero == 6.0 ||
                          $item->inscCalificacionDicEnero == 7.0 || $item->inscCalificacionDicEnero == 8.0 ||
                          $item->inscCalificacionDicEnero == 9.0 || $item->inscCalificacionDicEnero == 10.0)
                  
                          {{round($item->inscCalificacionDicEnero)}}
                  
                          @else
                          {{round($item->inscCalificacionDicEnero, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionFeb != "")
                        <td align="center" style="width: 24px;">
                          @if ($item->inscCalificacionFeb == 1.0 || $item->inscCalificacionFeb == 2.0 || $item->inscCalificacionFeb == 3.0
                          || $item->inscCalificacionFeb == 4.0 ||
                          $item->inscCalificacionFeb == 5.0 || $item->inscCalificacionFeb == 6.0 || $item->inscCalificacionFeb == 7.0 ||
                          $item->inscCalificacionFeb == 8.0 ||
                          $item->inscCalificacionFeb == 9.0 || $item->inscCalificacionFeb == 10.0)
                  
                          {{round($item->inscCalificacionFeb)}}
                  
                          @else
                          {{round($item->inscCalificacionFeb, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 24px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionMar != "")
                        <td align="center" style="width: 27px;">
                          @if ($item->inscCalificacionMar == 1.0 || $item->inscCalificacionMar == 2.0 || $item->inscCalificacionMar == 3.0
                          || $item->inscCalificacionMar == 4.0 ||
                          $item->inscCalificacionMar == 5.0 || $item->inscCalificacionMar == 6.0 || $item->inscCalificacionMar == 7.0 ||
                          $item->inscCalificacionMar == 8.0 ||
                          $item->inscCalificacionMar == 9.0 || $item->inscCalificacionMar == 10.0)
                  
                          {{round($item->inscCalificacionMar)}}
                  
                          @else
                          {{round($item->inscCalificacionMar, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestre 2   --}}
                        @if ($item->inscTrimestre2 != "")
                        <td align="center" style="width: 38px;"><b>{{round($item->inscTrimestre2,1)}}</b></td>
                        @else
                        <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td>
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
                                    $nivSEPPe2 = "1";
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
                        @if ($nivSEPPe2 != "")
                        <td align="center" style="width: 35px;">{{$nivSEPPe2}}</td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionAbr != "")
                        <td align="center" style="width: 25px;">{{$item->inscCalificacionAbr}}</td>
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionMay != "")
                        <td align="center" style="width: 31px;">{{$item->inscCalificacionMay}}</td>
                        @else
                        <td align="center" style="width: 31px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        

                        @if ($item->inscCalificacionJun != "")
                        <td align="center" style="width: 24px;">{{$item->inscCalificacionJun}}</td>
                        @else
                        <td align="center" style="width: 24px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestre 3   --}}
                        @if ($item->inscTrimestre3 != "")
                        <td align="center" style="width: 38px;"><b>{{round($item->inscTrimestre3,1)}}</b></td>
                        @else
                        <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($item->inscTrimestre3SEP != "")
                        <td align="center" style="width: 32px;">{{$item->inscTrimestre3SEP}}</td>
                        @else
                        <td align="center" style="width: 32px;"><label style="opacity: .01;">0</label></td>
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
                                    $nivSEPPe3 = "1";
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
                        

                                                

                        @if ($nivSEPPe3 != "")
                          <td align="center" style="width: 38px;">{{$nivSEPPe3}}</td>
                        @else
                          <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td>
                        @endif
                  
                        {{--  promedio final   --}}
                        @if ($item->inscPromedioTrimCALCULADO != "")
                        <td align="center" style="width: 35px;">
                          @if (round($item->inscPromedioTrimCALCULADO, 1) == 1.0 || round($item->inscPromedioTrimCALCULADO, 1) == 2.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 3.0 || round($item->inscPromedioTrimCALCULADO, 1) == 4.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 5.0 || round($item->inscPromedioTrimCALCULADO, 1) == 6.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 7.0 || round($item->inscPromedioTrimCALCULADO, 1) == 8.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 9.0 || round($item->inscPromedioTrimCALCULADO, 1) == 10.0)
                  
                          {{round($item->inscPromedioTrimCALCULADO)}}
                  
                          @else
                          {{round($item->inscPromedioTrimCALCULADO, 1)}}
                          @endif                  
                        </td>
                        @else
                          <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>                            
                        @endif
                        
                  
                        {{--  promedio final sep   --}}
                        @if ($item->inscPromedioTrimCALCULADOSEP != "")
                        <td align="center" style="width: 35px;">
                          @if (round($item->inscPromedioTrimCALCULADOSEP, 1) == 1.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) ==
                          2.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 3.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) ==
                          4.0 ||
                          round($item->inscPromedioTrimCALCULADOSEP, 1) == 5.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 6.0 ||
                          round($item->inscPromedioTrimCALCULADOSEP, 1) == 7.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 8.0 ||
                          round($item->inscPromedioTrimCALCULADOSEP, 1) == 9.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 10.0)
                  
                          {{round($item->inscPromedioTrimCALCULADOSEP)}}
                  
                          @else
                          {{round($item->inscPromedioTrimCALCULADOSEP, 1)}}
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
                                    $nivSEPFinall = "1";
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
                                                

                        @if ($nivSEPFinall != "")
                          <td align="center" style="width: 35px;">{{$nivSEPFinall}}</td>
                        @else
                          <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif
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
                      @if (round($promSEPDESA, 1) == 1.0 || round($promSEPDESA, 1) == 2.0 || round($promSEPDESA, 1) == 3.0 || round($promSEPDESA, 1) == 4.0 || 
                      round($promSEPDESA, 1) == 5.0 || round($promSEPDESA, 1) == 6.0 || round($promSEPDESA, 1) == 7.0 || round($promSEPDESA, 1) == 8.0 || 
                      round($promSEPDESA, 1) == 9.0 || round($promSEPDESA, 1) == 10.0) 

                      <b>{{round($promSEPDESA)}}</b>

                      @else
                      <b>{{round($promSEPDESA, 1)}}</b>
                      @endif
                    </td>

                    {{--  promedio octubre   --}}
                    <td align="center">
                      @if (round($promOCTDESA, 1) == 1.0 || round($promOCTDESA, 1) == 2.0 || round($promOCTDESA, 1) == 3.0 || round($promOCTDESA, 1) == 4.0 || 
                      round($promOCTDESA, 1) == 5.0 || round($promOCTDESA, 1) == 6.0 || round($promOCTDESA, 1) == 7.0 || round($promOCTDESA, 1) == 8.0 || 
                      round($promOCTDESA, 1) == 9.0 || round($promOCTDESA, 1) == 10.0) 

                      <b>{{round($promOCTDESA)}}</b>

                      @else
                      <b>{{round($promOCTDESA, 1)}}</b>
                      @endif
                    </td>

                    {{--  promedio noviembre   --}}
                    <td align="center">
                      @if (round($promNOVDESA, 1) == 1.0 || round($promNOVDESA, 1) == 2.0 || round($promNOVDESA, 1) == 3.0 || round($promNOVDESA, 1) == 4.0 || 
                      round($promNOVDESA, 1) == 5.0 || round($promNOVDESA, 1) == 6.0 || round($promNOVDESA, 1) == 7.0 || round($promNOVDESA, 1) == 8.0 || 
                      round($promNOVDESA, 1) == 9.0 || round($promNOVDESA, 1) == 10.0) 

                      <b>{{round($promNOVDESA)}}</b>

                      @else
                      <b>{{round($promNOVDESA, 1)}}</b>
                      @endif
                    </td>

                    {{--  promedio general primer periodo   --}}
                    <td align="center">
                      @if (round($PromedioGen1DESA, 1) == 1.0 || round($PromedioGen1DESA, 1) == 2.0 || round($PromedioGen1DESA, 1) == 3.0 || round($PromedioGen1DESA, 1) == 4.0 || 
                      round($PromedioGen1DESA, 1) == 5.0 || round($PromedioGen1DESA, 1) == 6.0 || round($PromedioGen1DESA, 1) == 7.0 || round($PromedioGen1DESA, 1) == 8.0 || 
                      round($PromedioGen1DESA, 1) == 9.0 || round($PromedioGen1DESA, 1) == 10.0) 

                      <b>{{round($PromedioGen1DESA)}}</b>

                      @else
                      <b>{{round($PromedioGen1DESA, 1)}}</b>
                      @endif
                    </td>
                    {{--  promedio general SEP primer periodo   --}}
                    <td align="center"><b>{{$PromedioGen1SEPDESA}}</b></td>

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
                                $nivSEPGenPe1 = "1";
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

                    @if ($nivSEPGenPe1 != "")
                      <td align="center"><b>{{$nivSEPGenPe1}}</b></td>
                    @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                    @endif

                    {{--  segundo periodo  --}}
                    {{--  promedio dic enero  --}}
                    <td align="center">
                      @if (round($promDICENEDESA, 1) == 1.0 || round($promDICENEDESA, 1) == 2.0 || round($promDICENEDESA, 1) == 3.0 || round($promDICENEDESA, 1) == 4.0 || 
                      round($promDICENEDESA, 1) == 5.0 || round($promDICENEDESA, 1) == 6.0 || round($promDICENEDESA, 1) == 7.0 || round($promDICENEDESA, 1) == 8.0 || 
                      round($promDICENEDESA, 1) == 9.0 || round($promDICENEDESA, 1) == 10.0) 

                      <b>{{round($promDICENEDESA)}}</b>

                      @else
                      <b>{{round($promDICENEDESA, 1)}}</b>
                      @endif
                    </td>

                    {{--  promedio febrero  --}}
                    <td align="center">
                      @if (round($promFEBDESA, 1) == 1.0 || round($promFEBDESA, 1) == 2.0 || round($promFEBDESA, 1) == 3.0 || round($promFEBDESA, 1) == 4.0 || 
                      round($promFEBDESA, 1) == 5.0 || round($promFEBDESA, 1) == 6.0 || round($promFEBDESA, 1) == 7.0 || round($promFEBDESA, 1) == 8.0 || 
                      round($promFEBDESA, 1) == 9.0 || round($promFEBDESA, 1) == 10.0) 

                      <b>{{round($promFEBDESA)}}</b>

                      @else
                      <b>{{round($promFEBDESA, 1)}}</b>
                      @endif
                    </td>

                    {{--  promedio marzo  --}}
                    <td align="center">
                      @if (round($promMARDESA, 1) == 1.0 || round($promMARDESA, 1) == 2.0 || round($promMARDESA, 1) == 3.0 || round($promMARDESA, 1) == 4.0 || 
                      round($promMARDESA, 1) == 5.0 || round($promMARDESA, 1) == 6.0 || round($promMARDESA, 1) == 7.0 || round($promMARDESA, 1) == 8.0 || 
                      round($promMARDESA, 1) == 9.0 || round($promMARDESA, 1) == 10.0) 

                      <b>{{round($promMARDESA)}}</b>

                      @else
                      <b>{{round($promMARDESA, 1)}}</b>
                      @endif
                    </td>

                    {{--  promedio general segundo periodo   --}}
                    <td align="center">
                      @if (round($PromedioGen2DESA, 1) == 1.0 || round($PromedioGen2DESA, 1) == 2.0 || round($PromedioGen2DESA, 1) == 3.0 || round($PromedioGen2DESA, 1) == 4.0 || 
                      round($PromedioGen2DESA, 1) == 5.0 || round($PromedioGen2DESA, 1) == 6.0 || round($PromedioGen2DESA, 1) == 7.0 || round($PromedioGen2DESA, 1) == 8.0 || 
                      round($PromedioGen2DESA, 1) == 9.0 || round($PromedioGen2DESA, 1) == 10.0) 

                      <b>{{round($PromedioGen2DESA)}}</b>

                      @else
                      <b>{{round($PromedioGen2DESA,1 )}}</b>
                      @endif
                    </td>
                    {{--  promedio general SEP segundo periodo   --}}
                    <td align="center"><b>{{$PromedioGen2SEPDESA}}</b></td>

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
                                                    $nivSEPGenPe2 = "1";
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

                    @if ($nivSEPGenPe2 != "")
                      <td align="center"><b>{{$nivSEPGenPe2}}</b></td>
                    @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                    @endif

                    {{--  tercer periodo   --}}
                    {{--  promedio abril  --}}
                    <td align="center">
                      @if ($promABRDESA == "")
                          <b></b>
                      @else
                        @if (round($promABRDESA, 1) == 1.0 || round($promABRDESA, 1) == 2.0 || round($promABRDESA, 1) == 3.0 || round($promABRDESA, 1) == 4.0 || 
                        round($promABRDESA, 1) == 5.0 || round($promABRDESA, 1) == 6.0 || round($promABRDESA, 1) == 7.0 || round($promABRDESA, 1) == 8.0 || 
                        round($promABRDESA, 1) == 9.0 || round($promABRDESA, 1) == 10.0) 

                        <b>{{round($promABRDESA)}}</b>

                        @else
                        <b>{{round($promABRDESA, 1)}}</b>
                        @endif
                      @endif                      
                    </td>

                    {{--  promedio mayo  --}}
                    <td align="center">
                      @if ($promMAYDESA == "")
                          <b></b>
                      @else
                        @if (round($promMAYDESA, 1) == 1.0 || round($promMAYDESA, 1) == 2.0 || round($promMAYDESA, 1) == 3.0 || round($promMAYDESA, 1) == 4.0 || 
                        round($promMAYDESA, 1) == 5.0 || round($promMAYDESA, 1) == 6.0 || round($promMAYDESA, 1) == 7.0 || round($promMAYDESA, 1) == 8.0 || 
                        round($promMAYDESA, 1) == 9.0 || round($promMAYDESA, 1) == 10.0) 

                        <b>{{round($promMAYDESA)}}</b>

                        @else
                        <b>{{round($promMAYDESA, 1)}}</b>
                        @endif
                      @endif
                      
                    </td>

                    {{--  promedio junio  --}}
                    <td align="center">
                      @if ($promJUNDESA == "")
                          <b></b>
                      @else
                        @if (round($promJUNDESA, 1) == 1.0 || round($promJUNDESA, 1) == 2.0 || round($promJUNDESA, 1) == 3.0 || round($promJUNDESA, 1) == 4.0 || 
                        round($promJUNDESA, 1) == 5.0 || round($promJUNDESA, 1) == 6.0 || round($promJUNDESA, 1) == 7.0 || round($promJUNDESA, 1) == 8.0 || 
                        round($promJUNDESA, 1) == 9.0 || round($promJUNDESA, 1) == 10.0) 

                        <b>{{round($promJUNDESA)}}</b>

                        @else
                        <b>{{round($promJUNDESA, 1)}}</b>
                        @endif
                      @endif                      
                    </td>

                    {{--  promedio general tercer periodo   --}}
                    <td align="center">
                      @if ($PromedioGen3DESA == "")
                          <b></b>
                      @else
                        @if (round($PromedioGen3DESA, 1) == 1.0 || round($PromedioGen3DESA, 1) == 2.0 || round($PromedioGen3DESA, 1) == 3.0 || round($PromedioGen3DESA, 1) == 4.0 || 
                        round($PromedioGen3DESA, 1) == 5.0 || round($PromedioGen3DESA, 1) == 6.0 || round($PromedioGen3DESA, 1) == 7.0 || round($PromedioGen3DESA, 1) == 8.0 || 
                        round($PromedioGen3DESA, 1) == 9.0 || round($PromedioGen3DESA, 1) == 10.0) 

                        <b>{{round($PromedioGen3DESA)}}</b>

                        @else
                        <b>{{round($PromedioGen3DESA, 1)}}</b>
                        @endif
                      @endif                      
                    </td>
                    {{--  promedio general SEP tercer periodo   --}}
                    <td align="center">
                      @if ($PromedioGen3SEPDESA == "")
                          <b></b>
                      @else
                        <b>{{$PromedioGen3SEPDESA}}</b>
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
                                                    $nivSEPGenPe3 = "1";
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

                    @if ($nivSEPGenPe3 != "")
                      <td align="center"><b>{{$nivSEPGenPe3}}</b></td>
                    @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                    @endif

                    {{--  promedio final de la sep   --}}
                    <td align="center">
                      @if (round($promedioFinalDESA, 1) == 1.0 || round($promedioFinalDESA, 1) == 2.0 || round($promedioFinalDESA, 1) == 3.0 || round($promedioFinalDESA, 1) == 4.0 || 
                      round($promedioFinalDESA, 1) == 5.0 || round($promedioFinalDESA, 1) == 6.0 || round($promedioFinalDESA, 1) == 7.0 || round($promedioFinalDESA, 1) == 8.0 || 
                      round($promedioFinalDESA, 1) == 9.0 || round($promedioFinalDESA, 1) == 10.0) 

                      <b>{{round($promedioFinalDESA)}}</b>

                      @else
                      <b>{{round($promedioFinalDESA, 1)}}</b>
                      @endif
                    </td>
                    <td align="center">
                      @if (round($promedioFinalSEPDESA, 1) == 1.0 || round($promedioFinalSEPDESA, 1) == 2.0 || round($promedioFinalSEPDESA, 1) == 3.0 || round($promedioFinalSEPDESA, 1) == 4.0 || 
                      round($promedioFinalSEPDESA, 1) == 5.0 || round($promedioFinalSEPDESA, 1) == 6.0 || round($promedioFinalSEPDESA, 1) == 7.0 || round($promedioFinalSEPDESA, 1) == 8.0 || 
                      round($promedioFinalSEPDESA, 1) == 9.0 || round($promedioFinalSEPDESA, 1) == 10.0) 

                      <b>{{round($promedioFinalSEPDESA)}}</b>

                      @else
                      <b>{{round($promedioFinalSEPDESA, 1)}}</b>
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
                                                                        $nivSEPGenFinal = "1";
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

                    @if ($nivSEPGenFinal != "")
                      <td align="center"><b>{{$nivSEPGenFinal}}</b></td>
                    @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                    @endif
                  </tr> 
              
                </tbody>
              </table>

              {{--  PROYECTO ARTÍSTICO  --}}
              <br>
              <table class="table table-bordered">
                <thead>
                  
                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)
                      @if ($item->matNombreEspecialidad == "DESARROLLO PERSONAL Y SOCIAL" && $item->matNombreOficial == "ARTES")
                      <tr>
                        @php
                          $keyMatPROY++;

                          $sepArtis = $sepArtis + $item->inscCalificacionSep;
                          $octArtis = $octArtis + $item->inscCalificacionOct;
                          $novArtis = $novArtis + $item->inscCalificacionNov;
                          $genArtis1 = $genArtis1 + $item->inscTrimestre1;
                          $diceneArtis = $diceneArtis + $item->inscCalificacionDicEnero;
                          $febArtis = $febArtis + $item->inscCalificacionFeb;
                          $marArtis = $marArtis + $item->inscCalificacionMar;
                          $genArtis2 = $genArtis2 + $item->inscTrimestre2;
                          $abrArtis = $abrArtis + $item->inscCalificacionAbr;
                          $mayArtis = $mayArtis + $item->inscCalificacionMay;
                          $junArtis = $junArtis + $item->inscCalificacionJun;
                          $genArtis3 = $genArtis3 + $item->inscTrimestre3;
                          $genFinalArtis = $genFinalArtis + $item->inscPromedioTrimCALCULADO;

                          $matEspecialidad = $item->matEspecialidad;
                        @endphp
                        <td style="width: 200px;">PROYECTO ARTÍSTICO</td>
                  
                        @if ($item->inscCalificacionSep != "")
                        <td align="center" style="width: 25px;">
                          @if ($item->inscCalificacionSep == 1.0 || $item->inscCalificacionSep == 2.0 || $item->inscCalificacionSep == 3.0
                          || $item->inscCalificacionSep == 4.0 ||
                          $item->inscCalificacionSep == 5.0 || $item->inscCalificacionSep == 6.0 || $item->inscCalificacionSep == 7.0 ||
                          $item->inscCalificacionSep == 8.0 ||
                          $item->inscCalificacionSep == 9.0 || $item->inscCalificacionSep == 10.0)
                  
                          {{round($item->inscCalificacionSep)}}
                  
                          @else
                          {{round($item->inscCalificacionSep, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionOct != "")
                        <td align="center" style="width: 25px;">
                          @if ($item->inscCalificacionOct == 1.0 || $item->inscCalificacionOct == 2.0 || $item->inscCalificacionOct == 3.0
                          || $item->inscCalificacionOct == 4.0 ||
                          $item->inscCalificacionOct == 5.0 || $item->inscCalificacionOct == 6.0 || $item->inscCalificacionOct == 7.0 ||
                          $item->inscCalificacionOct == 8.0 ||
                          $item->inscCalificacionOct == 9.0 || $item->inscCalificacionOct == 10.0)
                  
                          {{round($item->inscCalificacionOct)}}
                  
                          @else
                          {{round($item->inscCalificacionOct, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionNov != "")
                        <td align="center" style="width: 26px;">
                          @if ($item->inscCalificacionNov == 1.0 || $item->inscCalificacionNov == 2.0 || $item->inscCalificacionNov == 3.0
                          || $item->inscCalificacionNov == 4.0 ||
                          $item->inscCalificacionNov == 5.0 || $item->inscCalificacionNov == 6.0 || $item->inscCalificacionNov == 7.0 ||
                          $item->inscCalificacionNov == 8.0 ||
                          $item->inscCalificacionNov == 9.0 || $item->inscCalificacionNov == 10.0)
                  
                          {{round($item->inscCalificacionNov)}}
                  
                          @else
                          {{round($item->inscCalificacionNov, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestree 1  --}}
                        @if ($item->inscTrimestre1 != "")
                        <td align="center" style="width: 35px;"><b>{{round($item->inscTrimestre1,1)}}</b></td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($item->inscTrimestre1SEP != "")
                        <td align="center" style="width: 37px;">{{$item->inscTrimestre1SEP}}</td>
                        @else
                        <td align="center" style="width: 37px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        {{--  sacar el nivel   --}}
                        @php
                        $nivSEPperido1 = "";
                        if ($item->matEspecialidad == "1FA") {
                            switch ($item->inscTrimestre1SEP) {
                                case 1:
                                    $nivSEPperido1 = "I";
                                    break;
                                case 2:
                                    $nivSEPperido1 = "II";
                                    break;
                                case 3:
                                    $nivSEPperido1 = "III";
                                    break;
                                case 4:
                                    $nivSEPperido1 = "IV";
                                    break;
                                case 5:
                                    $nivSEPperido1 = "I";
                                    break;
                                case 6:
                                    $nivSEPperido1 = "II";
                                    break;
                                case 7:
                                    $nivSEPperido1 = "II";
                                    break;
                                case 8:
                                    $nivSEPperido1 = "III";
                                    break;
                                case 9:
                                    $nivSEPperido1 = "III";
                                    break;
                                case 10:
                                    $nivSEPperido1 = "IV";
                            }
                        } else {
                            switch ($item->inscTrimestre1SEP) {
                                case 0:
                                    $nivSEPperido1 = "1";
                                    break;
                                case 1:
                                    $nivSEPperido1 = "1";
                                    break;
                                case 2:
                                    $nivSEPperido1 = "1";
                                    break;
                                case 3:
                                    $nivSEPperido1 = "1";
                                    break;
                                case 4:
                                    $nivSEPperido1 = "1";
                                    break;
                                case 5:
                                    $nivSEPperido1 = "1";
                                    break;
                                case 6:
                                    $nivSEPperido1 = "2";
                                    break;
                                case 7:
                                    $nivSEPperido1 = "2";
                                    break;
                                case 8:
                                    $nivSEPperido1 = "3";
                                    break;
                                case 9:
                                    $nivSEPperido1 = "3";
                                    break;
                                case 10:
                                    $nivSEPperido1 = "4";
                            }
                        }
                      
                        @endphp

                                                                        
                        @if ($nivSEPperido1 != "")
                          <td align="center" style="width: 35px;">{{$nivSEPperido1}}</td>
                        @else
                          <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif
                  
                        @if ($item->inscCalificacionDicEnero != "")
                        <td align="center" style="width: 26px;">
                          @if ($item->inscCalificacionDicEnero == 1.0 || $item->inscCalificacionDicEnero == 2.0 ||
                          $item->inscCalificacionDicEnero == 3.0 || $item->inscCalificacionDicEnero == 4.0 ||
                          $item->inscCalificacionDicEnero == 5.0 || $item->inscCalificacionDicEnero == 6.0 ||
                          $item->inscCalificacionDicEnero == 7.0 || $item->inscCalificacionDicEnero == 8.0 ||
                          $item->inscCalificacionDicEnero == 9.0 || $item->inscCalificacionDicEnero == 10.0)
                  
                          {{round($item->inscCalificacionDicEnero)}}
                  
                          @else
                          {{round($item->inscCalificacionDicEnero, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionFeb != "")
                        <td align="center" style="width: 24.5px;">
                          @if ($item->inscCalificacionFeb == 1.0 || $item->inscCalificacionFeb == 2.0 || $item->inscCalificacionFeb == 3.0
                          || $item->inscCalificacionFeb == 4.0 ||
                          $item->inscCalificacionFeb == 5.0 || $item->inscCalificacionFeb == 6.0 || $item->inscCalificacionFeb == 7.0 ||
                          $item->inscCalificacionFeb == 8.0 ||
                          $item->inscCalificacionFeb == 9.0 || $item->inscCalificacionFeb == 10.0)
                  
                          {{round($item->inscCalificacionFeb)}}
                  
                          @else
                          {{round($item->inscCalificacionFeb, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 24.5px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionMar != "")
                        <td align="center" style="width: 27px;">
                          @if ($item->inscCalificacionMar == 1.0 || $item->inscCalificacionMar == 2.0 || $item->inscCalificacionMar == 3.0
                          || $item->inscCalificacionMar == 4.0 ||
                          $item->inscCalificacionMar == 5.0 || $item->inscCalificacionMar == 6.0 || $item->inscCalificacionMar == 7.0 ||
                          $item->inscCalificacionMar == 8.0 ||
                          $item->inscCalificacionMar == 9.0 || $item->inscCalificacionMar == 10.0)
                  
                          {{round($item->inscCalificacionMar)}}
                  
                          @else
                          {{round($item->inscCalificacionMar, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestre 2   --}}
                        @if ($item->inscTrimestre2 != "")
                        <td align="center" style="width: 38px;"><b>{{round($item->inscTrimestre2,1)}}</b></td>
                        @else
                        <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($item->inscTrimestre2 != "")
                        <td align="center" style="width: 35px;">{{round($item->inscTrimestre2)}}</td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        

                        {{--  sacar el nivel   --}}
                        @php
                        $nivSEPperido2 = "";
                        if ($item->matEspecialidad == "1FA") {
                            switch ($item->inscTrimestre2) {
                                case 1:
                                    $nivSEPperido2 = "I";
                                    break;
                                case 2:
                                    $nivSEPperido2 = "II";
                                    break;
                                case 3:
                                    $nivSEPperido2 = "III";
                                    break;
                                case 4:
                                    $nivSEPperido2 = "IV";
                                    break;
                                case 5:
                                    $nivSEPperido2 = "I";
                                    break;
                                case 6:
                                    $nivSEPperido2 = "II";
                                    break;
                                case 7:
                                    $nivSEPperido2 = "II";
                                    break;
                                case 8:
                                    $nivSEPperido2 = "III";
                                    break;
                                case 9:
                                    $nivSEPperido2 = "III";
                                    break;
                                case 10:
                                    $nivSEPperido2 = "IV";
                            }
                        } else {
                            switch ($item->inscTrimestre2) {
                                case 0:
                                    $nivSEPperido2 = "1";
                                    break;
                                case 1:
                                    $nivSEPperido2 = "1";
                                    break;
                                case 2:
                                    $nivSEPperido2 = "1";
                                    break;
                                case 3:
                                    $nivSEPperido2 = "1";
                                    break;
                                case 4:
                                    $nivSEPperido2 = "1";
                                    break;
                                case 5:
                                    $nivSEPperido2 = "1";
                                    break;
                                case 6:
                                    $nivSEPperido2 = "2";
                                    break;
                                case 7:
                                    $nivSEPperido2 = "2";
                                    break;
                                case 8:
                                    $nivSEPperido2 = "3";
                                    break;
                                case 9:
                                    $nivSEPperido2 = "3";
                                    break;
                                case 10:
                                    $nivSEPperido2 = "4";
                            }
                        }
                      
                        @endphp
                        @if ($nivSEPperido2 != "")
                          <td align="center" style="width: 35px;">{{$nivSEPperido2}}</td>
                        @else
                          <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionAbr != "")
                        <td align="center" style="width: 26px;">{{$item->inscCalificacionAbr}}</td>
                        @else
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionMay != "")
                        <td align="center" style="width: 29px;">{{$item->inscCalificacionMay}}</td>
                        @else
                        <td align="center" style="width: 29px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($item->inscCalificacionJun != "")
                        <td align="center" style="width: 25px;">{{$item->inscCalificacionJun}}</td>
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestre 3   --}}
                        @if ($item->inscTrimestre3 != "")
                        <td align="center" style="width: 38px;"><b>{{round($item->inscTrimestre3,1)}}</b></td>
                        @else
                        <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($item->inscTrimestre3 != "")
                        <td align="center" style="width: 33px;">{{round($item->inscTrimestre3)}}</td>
                        @else
                        <td align="center" style="width: 33px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        {{--  sacar el nivel   --}}
                        @php
                        $nivSEPperido3 = "";
                        if ($item->matEspecialidad == "1FA") {
                            switch ($item->inscTrimestre3) {
                                case 1:
                                    $nivSEPperido3 = "I";
                                    break;
                                case 2:
                                    $nivSEPperido3 = "II";
                                    break;
                                case 3:
                                    $nivSEPperido3 = "III";
                                    break;
                                case 4:
                                    $nivSEPperido3 = "IV";
                                    break;
                                case 5:
                                    $nivSEPperido3 = "I";
                                    break;
                                case 6:
                                    $nivSEPperido3 = "II";
                                    break;
                                case 7:
                                    $nivSEPperido3 = "II";
                                    break;
                                case 8:
                                    $nivSEPperido3 = "III";
                                    break;
                                case 9:
                                    $nivSEPperido3 = "III";
                                    break;
                                case 10:
                                    $nivSEPperido3 = "IV";
                            }
                        } else {
                            switch ($item->inscTrimestre3) {
                                case 0:
                                    $nivSEPperido3 = "1";
                                    break;
                                case 1:
                                    $nivSEPperido3 = "1";
                                    break;
                                case 2:
                                    $nivSEPperido3 = "1";
                                    break;
                                case 3:
                                    $nivSEPperido3 = "1";
                                    break;
                                case 4:
                                    $nivSEPperido3 = "1";
                                    break;
                                case 5:
                                    $nivSEPperido3 = "1";
                                    break;
                                case 6:
                                    $nivSEPperido3 = "2";
                                    break;
                                case 7:
                                    $nivSEPperido3 = "2";
                                    break;
                                case 8:
                                    $nivSEPperido3 = "3";
                                    break;
                                case 9:
                                    $nivSEPperido3 = "3";
                                    break;
                                case 10:
                                    $nivSEPperido3 = "4";
                            }
                        }
                      
                        @endphp

                        @if ($nivSEPperido3 != "")
                        <td align="center" style="width: 38px;">{{$nivSEPperido3}}</td>
                        @else
                        <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio final   --}}
                        @if ($item->inscPromedioTrimCALCULADO != "")
                        <td align="center" style="width: 35px;">
                          @if (round($item->inscPromedioTrimCALCULADO, 1) == 1.0 || round($item->inscPromedioTrimCALCULADO, 1) == 2.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 3.0 || round($item->inscPromedioTrimCALCULADO, 1) == 4.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 5.0 || round($item->inscPromedioTrimCALCULADO, 1) == 6.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 7.0 || round($item->inscPromedioTrimCALCULADO, 1) == 8.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 9.0 || round($item->inscPromedioTrimCALCULADO, 1) == 10.0)
                  
                          {{round($item->inscPromedioTrimCALCULADO)}}
                  
                          @else
                          {{round($item->inscPromedioTrimCALCULADO, 1)}}
                          @endif                  
                        </td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio final sep   --}}
                        @if ($item->inscPromedioTrimCALCULADOSEP != "")
                        <td align="center" style="width: 35px;">
                          @if (round($item->inscPromedioTrimCALCULADOSEP, 1) == 1.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) ==
                          2.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 3.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) ==
                          4.0 ||
                          round($item->inscPromedioTrimCALCULADOSEP, 1) == 5.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 6.0 ||
                          round($item->inscPromedioTrimCALCULADOSEP, 1) == 7.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 8.0 ||
                          round($item->inscPromedioTrimCALCULADOSEP, 1) == 9.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 10.0)
                  
                          {{round($item->inscPromedioTrimCALCULADOSEP)}}
                  
                          @else
                          {{round($item->inscPromedioTrimCALCULADOSEP, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        

                        {{--  sacar el nivel   --}}
                        @php
                        $nivSEPperFinal = "";
                        if ($item->matEspecialidad == "1FA") {
                            switch ($item->inscPromedioTrimCALCULADOSEP) {
                                case 1:
                                    $nivSEPperFinal = "I";
                                    break;
                                case 2:
                                    $nivSEPperFinal = "II";
                                    break;
                                case 3:
                                    $nivSEPperFinal = "III";
                                    break;
                                case 4:
                                    $nivSEPperFinal = "IV";
                                    break;
                                case 5:
                                    $nivSEPperFinal = "I";
                                    break;
                                case 6:
                                    $nivSEPperFinal = "II";
                                    break;
                                case 7:
                                    $nivSEPperFinal = "II";
                                    break;
                                case 8:
                                    $nivSEPperFinal = "III";
                                    break;
                                case 9:
                                    $nivSEPperFinal = "III";
                                    break;
                                case 10:
                                    $nivSEPperFinal = "IV";
                            }
                        } else {
                            switch ($item->inscPromedioTrimCALCULADOSEP) {
                                case 0:
                                    $nivSEPperFinal = "1";
                                    break;
                                case 1:
                                    $nivSEPperFinal = "1";
                                    break;
                                case 2:
                                    $nivSEPperFinal = "1";
                                    break;
                                case 3:
                                    $nivSEPperFinal = "1";
                                    break;
                                case 4:
                                    $nivSEPperFinal = "1";
                                    break;
                                case 5:
                                    $nivSEPperFinal = "1";
                                    break;
                                case 6:
                                    $nivSEPperFinal = "2";
                                    break;
                                case 7:
                                    $nivSEPperFinal = "2";
                                    break;
                                case 8:
                                    $nivSEPperFinal = "3";
                                    break;
                                case 9:
                                    $nivSEPperFinal = "3";
                                    break;
                                case 10:
                                    $nivSEPperFinal = "4";
                            }
                        }
                      
                        @endphp
                        @if ($nivSEPperFinal != "")
                          <td align="center" style="width: 35px;">{{$nivSEPperFinal}}</td>
                        @else
                          <td align="center" style="width: 35px;"><label style="opacity: .01;">0</label></td>
                        @endif
                      </tr>
                      <tr>
                        @php
                          // $keyMatFA++; Aqui ya no es necesario
                        @endphp
                        <td style="width: 200px;"><b>PROM. AUTONOMÍA CURRICUL.</b></td>
                  
                        <td align="center">
                          @if ($item->inscCalificacionSep == 1.0 || $item->inscCalificacionSep == 2.0 || $item->inscCalificacionSep == 3.0
                          || $item->inscCalificacionSep == 4.0 ||
                          $item->inscCalificacionSep == 5.0 || $item->inscCalificacionSep == 6.0 || $item->inscCalificacionSep == 7.0 ||
                          $item->inscCalificacionSep == 8.0 ||
                          $item->inscCalificacionSep == 9.0 || $item->inscCalificacionSep == 10.0)
                  
                          <b>{{round($item->inscCalificacionSep)}}</b>
                  
                          @else
                          <b>{{round($item->inscCalificacionSep, 1)}}</b>
                          @endif
                        </td>
                  
                        <td align="center">
                          @if ($item->inscCalificacionOct == 1.0 || $item->inscCalificacionOct == 2.0 || $item->inscCalificacionOct == 3.0
                          || $item->inscCalificacionOct == 4.0 ||
                          $item->inscCalificacionOct == 5.0 || $item->inscCalificacionOct == 6.0 || $item->inscCalificacionOct == 7.0 ||
                          $item->inscCalificacionOct == 8.0 ||
                          $item->inscCalificacionOct == 9.0 || $item->inscCalificacionOct == 10.0)
                  
                          <b>{{round($item->inscCalificacionOct)}}</b>
                  
                          @else
                          <b>{{round($item->inscCalificacionOct, 1)}}</b>
                          @endif
                        </td>
                  
                        <td align="center">
                          @if ($item->inscCalificacionNov == 1.0 || $item->inscCalificacionNov == 2.0 || $item->inscCalificacionNov == 3.0
                          || $item->inscCalificacionNov == 4.0 ||
                          $item->inscCalificacionNov == 5.0 || $item->inscCalificacionNov == 6.0 || $item->inscCalificacionNov == 7.0 ||
                          $item->inscCalificacionNov == 8.0 ||
                          $item->inscCalificacionNov == 9.0 || $item->inscCalificacionNov == 10.0)
                  
                          <b>{{round($item->inscCalificacionNov)}}</b>
                  
                          @else
                          <b>{{round($item->inscCalificacionNov, 1)}}</b>
                          @endif
                        </td>
                  
                        {{--  promedio trimestree 1  --}}
                        <td align="center">{{round($item->inscTrimestre1,1)}}</td>
                        <td align="center">{{$item->inscTrimestre1SEP}}</td>
                        <td align="center">{{$nivSEPperido1}}</td>
                  
                        <td align="center">
                          @if ($item->inscCalificacionDicEnero == 1.0 || $item->inscCalificacionDicEnero == 2.0 ||
                          $item->inscCalificacionDicEnero == 3.0 || $item->inscCalificacionDicEnero == 4.0 ||
                          $item->inscCalificacionDicEnero == 5.0 || $item->inscCalificacionDicEnero == 6.0 ||
                          $item->inscCalificacionDicEnero == 7.0 || $item->inscCalificacionDicEnero == 8.0 ||
                          $item->inscCalificacionDicEnero == 9.0 || $item->inscCalificacionDicEnero == 10.0)
                  
                          <b>{{round($item->inscCalificacionDicEnero)}}</b>
                  
                          @else
                          <b>{{round($item->inscCalificacionDicEnero, 1)}}</b>
                          @endif
                        </td>
                  
                        <td align="center">
                          @if ($item->inscCalificacionFeb == 1.0 || $item->inscCalificacionFeb == 2.0 || $item->inscCalificacionFeb == 3.0
                          || $item->inscCalificacionFeb == 4.0 ||
                          $item->inscCalificacionFeb == 5.0 || $item->inscCalificacionFeb == 6.0 || $item->inscCalificacionFeb == 7.0 ||
                          $item->inscCalificacionFeb == 8.0 ||
                          $item->inscCalificacionFeb == 9.0 || $item->inscCalificacionFeb == 10.0)
                  
                          <b>{{round($item->inscCalificacionFeb)}}</b>
                  
                          @else
                          <b>{{round($item->inscCalificacionFeb, 1)}}</b>
                          @endif
                        </td>
                  
                        <td align="center">
                          @if ($item->inscCalificacionMar == 1.0 || $item->inscCalificacionMar == 2.0 || $item->inscCalificacionMar == 3.0
                          || $item->inscCalificacionMar == 4.0 ||
                          $item->inscCalificacionMar == 5.0 || $item->inscCalificacionMar == 6.0 || $item->inscCalificacionMar == 7.0 ||
                          $item->inscCalificacionMar == 8.0 ||
                          $item->inscCalificacionMar == 9.0 || $item->inscCalificacionMar == 10.0)
                  
                          <b>{{round($item->inscCalificacionMar)}}</b>
                  
                          @else
                          <b>{{round($item->inscCalificacionMar, 1)}}</b>
                          @endif
                        </td>
                  
                        {{--  promedio trimestre 2   --}}
                        <td align="center"><b>{{round($item->inscTrimestre2,1)}}</b></td>
                        <td align="center"><b>{{$item->inscTrimestre2SEP}}</b></td>
                        <td align="center"><b>{{$nivSEPperido2}}</b></td>
                        <td align="center"><b>{{$item->inscCalificacionAbr}}</b></td>
                        <td align="center"><b>{{$item->inscCalificacionMay}}</b></td>
                        <td align="center"><b>{{$item->inscCalificacionJun}}</b></td>
                  
                        {{--  promedio trimestre 3   --}}
                        <td align="center">
                          @if ($item->inscTrimestre3 == "")
                              <b></b>
                          @else
                            <b>{{round($item->inscTrimestre3,1)}}</b>
                          @endif                          
                        </td>
                        <td align="center"><b>{{$item->inscTrimestre3SEP}}</b></td>
                        <td align="center"><b>{{$nivSEPperido3}}</b></td>
                  
                        {{--  promedio final   --}}
                        <td align="center">
                          @if (round($item->inscPromedioTrimCALCULADO, 1) == 1.0 || round($item->inscPromedioTrimCALCULADO, 1) == 2.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 3.0 || round($item->inscPromedioTrimCALCULADO, 1) == 4.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 5.0 || round($item->inscPromedioTrimCALCULADO, 1) == 6.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 7.0 || round($item->inscPromedioTrimCALCULADO, 1) == 8.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 9.0 || round($item->inscPromedioTrimCALCULADO, 1) == 10.0)
                  
                          <b>{{round($item->inscPromedioTrimCALCULADO)}}</b>
                  
                          @else
                          <b>{{round($item->inscPromedioTrimCALCULADO, 1)}}</b>
                          @endif
                  
                        </td>
                  
                        {{--  promedio final sep   --}}
                        <td align="center">
                          @if (round($item->inscPromedioTrimCALCULADOSEP, 1) == 1.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) ==
                          2.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 3.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) ==
                          4.0 ||
                          round($item->inscPromedioTrimCALCULADOSEP, 1) == 5.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 6.0 ||
                          round($item->inscPromedioTrimCALCULADOSEP, 1) == 7.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 8.0 ||
                          round($item->inscPromedioTrimCALCULADOSEP, 1) == 9.0 || round($item->inscPromedioTrimCALCULADOSEP, 1) == 10.0)
                  
                          <b>{{round($item->inscPromedioTrimCALCULADOSEP)}}</b>
                  
                          @else
                          <b>{{round($item->inscPromedioTrimCALCULADOSEP, 1)}}</b>
                          @endif
                        </td>
                        <td align="center"><b>{{$nivSEPperFinal}}</b></td>
                      </tr>
                      @endif
                    @endif
                  @endforeach
              
                </tbody>
              </table>

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
                        @endphp
                        <td style="width: 200px;">{{$item->matNombreOficial}}</td>
                  
                        @if ($item->inscCalificacionSep != "")
                        <td align="center" style="width: 25px;">
                          @if ($item->inscCalificacionSep == 1.0 || $item->inscCalificacionSep == 2.0 || $item->inscCalificacionSep == 3.0
                          || $item->inscCalificacionSep == 4.0 ||
                          $item->inscCalificacionSep == 5.0 || $item->inscCalificacionSep == 6.0 || $item->inscCalificacionSep == 7.0 ||
                          $item->inscCalificacionSep == 8.0 ||
                          $item->inscCalificacionSep == 9.0 || $item->inscCalificacionSep == 10.0)
                  
                          {{round($item->inscCalificacionSep)}}
                  
                          @else
                          {{round($item->inscCalificacionSep, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($item->inscCalificacionOct != "")
                        <td align="center" style="width: 25px;">
                          @if ($item->inscCalificacionOct == 1.0 || $item->inscCalificacionOct == 2.0 || $item->inscCalificacionOct == 3.0
                          || $item->inscCalificacionOct == 4.0 ||
                          $item->inscCalificacionOct == 5.0 || $item->inscCalificacionOct == 6.0 || $item->inscCalificacionOct == 7.0 ||
                          $item->inscCalificacionOct == 8.0 ||
                          $item->inscCalificacionOct == 9.0 || $item->inscCalificacionOct == 10.0)
                  
                          {{round($item->inscCalificacionOct)}}
                  
                          @else
                          {{round($item->inscCalificacionOct, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                  
                        @if ($item->inscCalificacionNov != "")
                        <td align="center" style="width: 24px;">
                          @if ($item->inscCalificacionNov == 1.0 || $item->inscCalificacionNov == 2.0 || $item->inscCalificacionNov == 3.0
                          || $item->inscCalificacionNov == 4.0 ||
                          $item->inscCalificacionNov == 5.0 || $item->inscCalificacionNov == 6.0 || $item->inscCalificacionNov == 7.0 ||
                          $item->inscCalificacionNov == 8.0 ||
                          $item->inscCalificacionNov == 9.0 || $item->inscCalificacionNov == 10.0)
                  
                          {{round($item->inscCalificacionNov)}}
                  
                          @else
                          {{round($item->inscCalificacionNov, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 24px;"><label style="opacity: .01;">0</label></td>
                        @endif
                  
                        
                  
                        {{--  promedio trimestree 1  --}}
                        @if ($item->inscTrimestre1 != "")
                        <td align="center" style="width: 36px;"><b>{{round($item->inscTrimestre1,1)}}</b></td>
                        @else
                        <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        <td style="width: 38px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                  
                        @if ($item->inscCalificacionDicEnero != "")
                        <td align="center" style="width: 27px;">
                          @if ($item->inscCalificacionDicEnero == 1.0 || $item->inscCalificacionDicEnero == 2.0 ||
                          $item->inscCalificacionDicEnero == 3.0 || $item->inscCalificacionDicEnero == 4.0 ||
                          $item->inscCalificacionDicEnero == 5.0 || $item->inscCalificacionDicEnero == 6.0 ||
                          $item->inscCalificacionDicEnero == 7.0 || $item->inscCalificacionDicEnero == 8.0 ||
                          $item->inscCalificacionDicEnero == 9.0 || $item->inscCalificacionDicEnero == 10.0)
                  
                          {{round($item->inscCalificacionDicEnero)}}
                  
                          @else
                          {{round($item->inscCalificacionDicEnero, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionFeb != "")
                        <td align="center" style="width: 25px;">
                          @if ($item->inscCalificacionFeb == 1.0 || $item->inscCalificacionFeb == 2.0 || $item->inscCalificacionFeb == 3.0
                          || $item->inscCalificacionFeb == 4.0 ||
                          $item->inscCalificacionFeb == 5.0 || $item->inscCalificacionFeb == 6.0 || $item->inscCalificacionFeb == 7.0 ||
                          $item->inscCalificacionFeb == 8.0 ||
                          $item->inscCalificacionFeb == 9.0 || $item->inscCalificacionFeb == 10.0)
                  
                          {{round($item->inscCalificacionFeb)}}
                  
                          @else
                          {{round($item->inscCalificacionFeb, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($item->inscCalificacionMar != "")
                        <td align="center" style="width: 26px;">
                          @if ($item->inscCalificacionMar == 1.0 || $item->inscCalificacionMar == 2.0 || $item->inscCalificacionMar == 3.0
                          || $item->inscCalificacionMar == 4.0 ||
                          $item->inscCalificacionMar == 5.0 || $item->inscCalificacionMar == 6.0 || $item->inscCalificacionMar == 7.0 ||
                          $item->inscCalificacionMar == 8.0 ||
                          $item->inscCalificacionMar == 9.0 || $item->inscCalificacionMar == 10.0)
                  
                          {{round($item->inscCalificacionMar)}}
                  
                          @else
                          {{round($item->inscCalificacionMar, 1)}}
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        @endif
                  
                        {{--  promedio trimestre 2   --}}
                        @if ($item->inscTrimestre2 != "")                            
                        <td align="center" style="width: 38px;"><b>{{round($item->inscTrimestre2,1)}}</b></td>
                        @else
                        <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td>
                        @endif
                  
                        
                        <td style="width: 35px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>


                        @if ($item->inscCalificacionAbr != "")
                        <td align="center" style="width: 27px;">{{$item->inscCalificacionAbr}}</td>
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($item->inscCalificacionMay != "")
                        <td align="center" style="width: 28px;">{{$item->inscCalificacionMay}}</td>
                        @else
                        <td align="center" style="width: 28px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($item->inscCalificacionJun != "")
                        <td align="center" style="width: 26px;">{{$item->inscCalificacionJun}}</td>
                        @else
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestre 3   --}}
                        @if ($item->inscTrimestre3 != "")
                        <td align="center" style="width: 37px;">
                          @if (round($item->inscTrimestre3, 1) == 1.0 || round($item->inscTrimestre3, 1) == 2.0 ||
                          round($item->inscTrimestre3, 1) == 3.0 || round($item->inscTrimestre3, 1) == 4.0 ||
                          round($item->inscTrimestre3, 1) == 5.0 || round($item->inscTrimestre3, 1) == 6.0 ||
                          round($item->inscTrimestre3, 1) == 7.0 || round($item->inscTrimestre3, 1) == 8.0 ||
                          round($item->inscTrimestre3, 1) == 9.0 || round($item->inscTrimestre3, 1) == 10.0)
                  
                          <b>{{round($item->inscTrimestre3)}}</b>
                  
                          @else
                          <b>{{round($item->inscTrimestre3, 1)}}</b>
                          @endif
                        </td>
                        @else
                        <td style="width: 37px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        <td style="width: 33px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td style="width: 40px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                  
                        {{--  promedio final   --}}
                        @if ($item->inscPromedioTrimCALCULADO != "")
                        <td align="center" style="width: 36px;">
                          @if (round($item->inscPromedioTrimCALCULADO, 1) == 1.0 || round($item->inscPromedioTrimCALCULADO, 1) == 2.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 3.0 || round($item->inscPromedioTrimCALCULADO, 1) == 4.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 5.0 || round($item->inscPromedioTrimCALCULADO, 1) == 6.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 7.0 || round($item->inscPromedioTrimCALCULADO, 1) == 8.0 ||
                          round($item->inscPromedioTrimCALCULADO, 1) == 9.0 || round($item->inscPromedioTrimCALCULADO, 1) == 10.0)
                  
                          <b>{{round($item->inscPromedioTrimCALCULADO)}}</b>
                  
                          @else
                          <b>{{round($item->inscPromedioTrimCALCULADO, 1)}}</b>
                          @endif                  
                        </td>
                        @else
                        <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio final sep   --}}
                        <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">{{""}}</td>
                        <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">{{""}}</td>
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
                       $promSEPGENERAL = ($promSEPFA + $promSEPDESA + $sepArtis) / 3;
                       $promOCTGENERAL = ($promOCTFA + $promOCTDESA + $octArtis) / 3;
                        $promNOVGENERAL = ($promNOVFA + $promNOVDESA + $novArtis) / 3;
                        $promGENGENERAL1 = ($promedioGen1FA + $PromedioGen1DESA + $genArtis1) / 3;
                        $promDICENEGENERAL = ($promDicEneFA + $promDICENEDESA + $diceneArtis) / 3;
                        $promFEBGENERAL = ($promFEBFA + $promFEBDESA + $febArtis) / 3;
                        $promMARGENERAL = ($promMARFA + $promMARDESA + $marArtis) / 3;
                        $promGENGENERAL2 = ($promedioGen2FA + $PromedioGen2DESA + $genArtis2) / 3;
                        $promABRGENERAL = ($promABRFA + $promABRDESA + $abrArtis) / 3;
                        $promMAYGENERAL = ($mayArtis + $promMAYFA + $promMAYDESA) / 3;
                        $promJUNGENERAL = ($promJUNFA + $promJUNDESA + $junArtis) / 3;
                        $promGENGENERAL3 = ($promedioGen3FA + $PromedioGen3DESA + $genArtis3) / 3;
                        $promFINALGENERAL = ($promedioFinalFA + $promedioFinalDESA + $genFinalArtis) / 3;
                   @endphp

                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)
                     @php
                         $keyPromedioGeneral++;
                     @endphp
                     @if ($keyPromedioGeneral == 1)
                      <tr>                      
                        <td style="width: 200px;"><b>PROMEDIO GENERAL</b></td>

                        @if ($promSEPGENERAL != "")
                        <td align="center" style="width: 25px;">
                          @if (round($promSEPGENERAL, 1) == 1.0 || round($promSEPGENERAL, 1) ==
                          2.0 || round($promSEPGENERAL, 1) == 3.0 || round($promSEPGENERAL, 1) ==
                          4.0 ||
                          round($promSEPGENERAL, 1) == 5.0 || round($promSEPGENERAL, 1) == 6.0 ||
                          round($promSEPGENERAL, 1) == 7.0 || round($promSEPGENERAL, 1) == 8.0 ||
                          round($promSEPGENERAL, 1) == 9.0 || round($promSEPGENERAL, 1) == 10.0)
                  
                          <b>{{round($promSEPGENERAL)}}</b>
                  
                          @else
                          <b>{{round($promSEPGENERAL, 1)}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($promOCTGENERAL != "")
                        <td align="center" style="width: 25px;">
                          @if (round($promOCTGENERAL, 1) == 1.0 || round($promOCTGENERAL, 1) ==
                          2.0 || round($promOCTGENERAL, 1) == 3.0 || round($promOCTGENERAL, 1) ==
                          4.0 ||
                          round($promOCTGENERAL, 1) == 5.0 || round($promOCTGENERAL, 1) == 6.0 ||
                          round($promOCTGENERAL, 1) == 7.0 || round($promOCTGENERAL, 1) == 8.0 ||
                          round($promOCTGENERAL, 1) == 9.0 || round($promOCTGENERAL, 1) == 10.0)
                  
                          <b>{{round($promOCTGENERAL)}}</b>
                  
                          @else
                          <b>{{round($promOCTGENERAL, 1)}}</b>
                          @endif
                        </td> 
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                              
                        @if ($promNOVGENERAL != "")
                        <td align="center" style="width: 25px;">
                          @if (round($promNOVGENERAL, 1) == 1.0 || round($promNOVGENERAL, 1) ==
                          2.0 || round($promNOVGENERAL, 1) == 3.0 || round($promNOVGENERAL, 1) ==
                          4.0 ||
                          round($promNOVGENERAL, 1) == 5.0 || round($promNOVGENERAL, 1) == 6.0 ||
                          round($promNOVGENERAL, 1) == 7.0 || round($promNOVGENERAL, 1) == 8.0 ||
                          round($promNOVGENERAL, 1) == 9.0 || round($promNOVGENERAL, 1) == 10.0)
                  
                          <b>{{round($promNOVGENERAL)}}</b>
                  
                          @else
                          <b>{{round($promNOVGENERAL, 1)}}</b>
                          @endif
                        </td> 
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                                        
                         {{--  promedio trimestree 1  --}}
                         @if ($promGENGENERAL1 != "")
                         <td align="center" style="width: 37px;">
                          @if (round($promGENGENERAL1, 1) == 1.0 || round($promGENGENERAL1, 1) ==
                          2.0 || round($promGENGENERAL1, 1) == 3.0 || round($promGENGENERAL1, 1) ==
                          4.0 ||
                          round($promGENGENERAL1, 1) == 5.0 || round($promGENGENERAL1, 1) == 6.0 ||
                          round($promGENGENERAL1, 1) == 7.0 || round($promGENGENERAL1, 1) == 8.0 ||
                          round($promGENGENERAL1, 1) == 9.0 || round($promGENGENERAL1, 1) == 10.0)
                  
                          <b>{{round($promGENGENERAL1)}}</b>
                  
                          @else
                          <b>{{round($promGENGENERAL1, 1)}}</b>
                          @endif
                        </td>
                         @else
                         <td align="center" style="width: 37px;"><label style="opacity: .01;">0</label></td>
                         @endif
                               
                        <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 35px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        
                        @if ($promDICENEGENERAL != "")
                        <td align="center" style="width: 28px">
                          @if (round($promDICENEGENERAL, 1) == 1.0 || round($promDICENEGENERAL, 1) ==
                          2.0 || round($promDICENEGENERAL, 1) == 3.0 || round($promDICENEGENERAL, 1) ==
                          4.0 ||
                          round($promDICENEGENERAL, 1) == 5.0 || round($promDICENEGENERAL, 1) == 6.0 ||
                          round($promDICENEGENERAL, 1) == 7.0 || round($promDICENEGENERAL, 1) == 8.0 ||
                          round($promDICENEGENERAL, 1) == 9.0 || round($promDICENEGENERAL, 1) == 10.0)
                  
                          <b>{{round($promDICENEGENERAL)}}</b>
                  
                          @else
                          <b>{{round($promDICENEGENERAL, 1)}}</b>
                          @endif
                        </td>  
                        @else
                        <td align="center" style="width: 28px;"><label style="opacity: .01;">0</label></td>
                        @endif
                           
                        @if ($promFEBGENERAL != "")
                        <td align="center" style="width: 25px">
                          @if (round($promFEBGENERAL, 1) == 1.0 || round($promFEBGENERAL, 1) ==
                          2.0 || round($promFEBGENERAL, 1) == 3.0 || round($promFEBGENERAL, 1) ==
                          4.0 ||
                          round($promFEBGENERAL, 1) == 5.0 || round($promFEBGENERAL, 1) == 6.0 ||
                          round($promFEBGENERAL, 1) == 7.0 || round($promFEBGENERAL, 1) == 8.0 ||
                          round($promFEBGENERAL, 1) == 9.0 || round($promFEBGENERAL, 1) == 10.0)
                  
                          <b>{{round($promFEBGENERAL)}}</b>
                  
                          @else
                          <b>{{round($promFEBGENERAL, 1)}}</b>
                          @endif
                        </td> 
                        @else
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        @endif
                         
                        @if ($promMARGENERAL != "")
                        <td align="center" style="width: 26px">
                          @if (round($promMARGENERAL, 1) == 1.0 || round($promMARGENERAL, 1) ==
                          2.0 || round($promMARGENERAL, 1) == 3.0 || round($promMARGENERAL, 1) ==
                          4.0 ||
                          round($promMARGENERAL, 1) == 5.0 || round($promMARGENERAL, 1) == 6.0 ||
                          round($promMARGENERAL, 1) == 7.0 || round($promMARGENERAL, 1) == 8.0 ||
                          round($promMARGENERAL, 1) == 9.0 || round($promMARGENERAL, 1) == 10.0)
                  
                          <b>{{round($promMARGENERAL)}}</b>
                  
                          @else
                          <b>{{round($promMARGENERAL, 1)}}</b>
                          @endif
                        </td> 
                        @else
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        {{--  promedio trimestre 2   --}}
                        @if ($promGENGENERAL2 != "")
                        <td align="center" style="width: 38px">
                          @if (round($promGENGENERAL2, 1) == 1.0 || round($promGENGENERAL2, 1) ==
                          2.0 || round($promGENGENERAL2, 1) == 3.0 || round($promGENGENERAL2, 1) ==
                          4.0 ||
                          round($promGENGENERAL2, 1) == 5.0 || round($promGENGENERAL2, 1) == 6.0 ||
                          round($promGENGENERAL2, 1) == 7.0 || round($promGENGENERAL2, 1) == 8.0 ||
                          round($promGENGENERAL2, 1) == 9.0 || round($promGENGENERAL2, 1) == 10.0)
                  
                          <b>{{round($promGENGENERAL2)}}</b>
                  
                          @else
                          <b>{{round($promGENGENERAL2, 1)}}</b>
                          @endif
                        </td> 
                        @else
                        <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td> 
                        @endif
                        
                        <td style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td style="width: 35px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        
                        @if ($promABRGENERAL != "")
                        <td align="center" style="width: 27px;">
                          @if (round($promABRGENERAL, 1) == 1.0 || round($promABRGENERAL, 1) ==
                          2.0 || round($promABRGENERAL, 1) == 3.0 || round($promABRGENERAL, 1) ==
                          4.0 ||
                          round($promABRGENERAL, 1) == 5.0 || round($promABRGENERAL, 1) == 6.0 ||
                          round($promABRGENERAL, 1) == 7.0 || round($promABRGENERAL, 1) == 8.0 ||
                          round($promABRGENERAL, 1) == 9.0 || round($promABRGENERAL, 1) == 10.0)
                  
                          <b>{{round($promABRGENERAL)}}</b>
                  
                          @else
                          <b>{{round($promABRGENERAL, 1)}}</b>
                          @endif
                        </td> 
                        @else
                        <td align="center" style="width: 27px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($promMAYGENERAL != "")
                        <td align="center" style="width: 29px;">
                          @if (round($promMAYGENERAL, 1) == 1.0 || round($promMAYGENERAL, 1) ==
                          2.0 || round($promMAYGENERAL, 1) == 3.0 || round($promMAYGENERAL, 1) ==
                          4.0 ||
                          round($promMAYGENERAL, 1) == 5.0 || round($promMAYGENERAL, 1) == 6.0 ||
                          round($promMAYGENERAL, 1) == 7.0 || round($promMAYGENERAL, 1) == 8.0 ||
                          round($promMAYGENERAL, 1) == 9.0 || round($promMAYGENERAL, 1) == 10.0)
                  
                          <b>{{round($promMAYGENERAL)}}</b>
                  
                          @else
                          <b>{{round($promMAYGENERAL, 1)}}</b>
                          @endif
                        </td> 
                        @else
                        <td align="center" style="width: 29px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                        @if ($promJUNGENERAL != "")
                        <td align="center" style="width: 26px;">
                          @if (round($promJUNGENERAL, 1) == 1.0 || round($promJUNGENERAL, 1) ==
                          2.0 || round($promJUNGENERAL, 1) == 3.0 || round($promJUNGENERAL, 1) ==
                          4.0 ||
                          round($promJUNGENERAL, 1) == 5.0 || round($promJUNGENERAL, 1) == 6.0 ||
                          round($promJUNGENERAL, 1) == 7.0 || round($promJUNGENERAL, 1) == 8.0 ||
                          round($promJUNGENERAL, 1) == 9.0 || round($promJUNGENERAL, 1) == 10.0)
                  
                          <b>{{round($promJUNGENERAL)}}</b>
                  
                          @else
                          <b>{{round($promJUNGENERAL, 1)}}</b>
                          @endif
                        </td> 
                        @else
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td> 
                        @endif
                         
                        {{--  promedio trimestre 3   --}}
                        @if ($promGENGENERAL3 != "")
                        <td align="center" style="width: 36px;">
                          @if (round($promGENGENERAL3, 1) == 1.0 || round($promGENGENERAL3, 1) ==
                          2.0 || round($promGENGENERAL3, 1) == 3.0 || round($promGENGENERAL3, 1) ==
                          4.0 ||
                          round($promGENGENERAL3, 1) == 5.0 || round($promGENGENERAL3, 1) == 6.0 ||
                          round($promGENGENERAL3, 1) == 7.0 || round($promGENGENERAL3, 1) == 8.0 ||
                          round($promGENGENERAL3, 1) == 9.0 || round($promGENGENERAL3, 1) == 10.0)
                  
                          <b>{{round($promGENGENERAL3)}}</b>
                  
                          @else
                          <b>{{round($promGENGENERAL3, 1)}}</b>
                          @endif
                        </td> 
                        @else
                        <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td> 
                        @endif
                        
                        <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        {{--  promedio final   --}}
                        @if ($promFINALGENERAL != "")
                        <td align="center" style="width: 36px;">
                          @if (round($promFINALGENERAL, 1) == 1.0 || round($promFINALGENERAL, 1) ==
                          2.0 || round($promFINALGENERAL, 1) == 3.0 || round($promFINALGENERAL, 1) ==
                          4.0 ||
                          round($promFINALGENERAL, 1) == 5.0 || round($promFINALGENERAL, 1) == 6.0 ||
                          round($promFINALGENERAL, 1) == 7.0 || round($promFINALGENERAL, 1) == 8.0 ||
                          round($promFINALGENERAL, 1) == 9.0 || round($promFINALGENERAL, 1) == 10.0)
                  
                          <b>{{round($promFINALGENERAL)}}</b>
                  
                          @else
                          <b>{{round($promFINALGENERAL, 1)}}</b>
                          @endif
                        </td>
                        @else
                        <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
                        @endif
                         
                        {{--  promedio final sep   --}}
                        <td style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      </tr>                    
                     @endif
                    @endif
                  @endforeach
              
                </tbody>
              </table>

              {{--  ARTE, CULTURA, DEPORTE  --}}
              <br>
              <table class="table table-bordered">
                <thead>
                
                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)
                     @php
                         $acd++;
                     @endphp
                     @if ($acd == 1)
                      <tr>                      
                        <td style="width: 200px;">ARTE, CULTURA, DEPORTE</td>
                        <td align="center" style="width: 25px; "><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 25px; "><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 25px; "><label style="opacity: .01;">0</label></td>
                        {{--  promedio trimestree 1  --}}
                        <td align="center" style="width: 37px; "><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 35px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 28px;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 25px;"><label style="opacity: .01;">0</label></td>
                        {{--  promedio trimestre 2   --}}
                        <td align="center" style="width: 39px;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 35px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 35px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 28px;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 29px;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 26px;"><label style="opacity: .01;">0</label></td>
                        {{--  promedio trimestre 3   --}}
                        <td align="center" style="width: 36px;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 36px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        {{--  promedio final   --}}
                        <td align="center" style="width: 37px;"><label style="opacity: .01;">0</label></td>
                        {{--  promedio final sep   --}}
                        <td align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">{{""}}</td>
                        <td align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">{{""}}</td>
                      </tr>                    
                     @endif
                    @endif
                  @endforeach
              
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
                      <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      @php
                          $totalFaltas = $inasistencia->falTotalSep+
                          $inasistencia->falTotalOct + $inasistencia->falTotalNov+
                          $inasistencia->falTotalEne + $inasistencia->falTotalFeb +
                          $inasistencia->falTotalMar + $inasistencia->falTotalAbr +
                          $inasistencia->falTotalMay + $inasistencia->falTotalJun;
                      @endphp
                      <td align="center" style="width: 37px;">{{$totalFaltas}}</td> //total faltas
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

    @endphp
@endforeach



  </body>
</html>
