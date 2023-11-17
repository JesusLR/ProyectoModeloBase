<!DOCTYPE html>
<html>
	<head>
		<title>Boleta</title>
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
        margin-top: 40px;  /* ALTURA HEADER */
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
        top: -50px;
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

    @php
        $pos0 = 1;
    @endphp
  <header>
      <div class="row" style="margin-top: 0px;">
          <div class="columns medium-12">

            <img class="img-header"  src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">
              @if ($secundaria_porcentajes->departamento_id == "15")
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">SECUNDARIA ESCUELA MODELO</h4>
              @endif
              @if ($secundaria_porcentajes->departamento_id == "19")
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">SECUNDARIA ESCUELA MODELO VALLADOLID</h4>
              @endif
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">
                @if ($secundaria_porcentajes->departamento_id == "15")
                31PES0012T 
                @endif

                @if ($secundaria_porcentajes->departamento_id == "19")
                31PES0143L 
                @endif
                
              </h4>
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">BOLETA DE CALIFICACIONES</h4>
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">CURSO ESCOLAR: {{$cicloEscolar}}</h4>
              @foreach ($calificaciones as $inscrito)
                @if ($pos0++ == 1)
                  <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">Grado: {{$inscrito->gpoGrado}} Grupo:{{$inscrito->gpoClave}}</h4>
                @endif
              @endforeach

          </div>
      </div>
  </header>

  @php
  $pos0 = 1;
  $key = 0;
  $keyMatFA = 0.0;
  $keyMatDESA = 0.0;
  $keyMatPROY = 0.0;
  $keyMatOPTA = 0.0;
  $keyPromedioGeneral = 0;
  $acd = 0;
  $Keynasistencias = 0;

  #Varibles indispensables para la categoria formación academica
  $keyPromedioGeneralFormacionAcademica = 0;
  $promedioGenFormacionAcadeSep = 0.0;
  $promedioGenFormacionAcadeOct = 0.0;
  $promedioGenFormacionAcadeNov = 0.0;
  $promedioGenFormacionAcadePeriodo1 = 0.0;
  $promedioGenFormacionAcadeEne = 0.0;
  $promedioGenFormacionAcadeFeb = 0.0;
  $promedioGenFormacionAcadeMar = 0.0;
  $promedioGenFormacionAcadePeriodo2 = 0.0;
  $promedioGenFormacionAcadeAbr = 0.0;
  $promedioGenFormacionAcadeMay = 0.0;
  $promedioGenFormacionAcadeJun = 0.0;
  $promedioGenFormacionAcadePeriodo3 = 0.0;



  
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
  $PromedioDesaPerido1 = 0.0;
  $PromedioGen1SEPDESA = 0.0;
  $promDICENEDESA = 0.0;
  $promFEBDESA = 0.0;
  $promMARDESA = 0.0;
  $PromedioDesaPerido2 = 0.0;
  $PromedioGen2SEPDESA = 0.0;
  $promABRDESA = 0.0;
  $promMAYDESA = 0.0;
  $promJUNDESA = 0.0;
  $PromedioDesaPerido3 = 0.0;
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


  $posicion1 = 1;
  $posicion2 = 1;
  $posicion9 = 1;
  $posicion10 = 1;
  $posicion3 = 1;
  $posicionFA = 0;
  $posicion3Fisi = 0;
  $posicion3ArtTut = 0;
  $posicionTec = 0;

  $keyMatOptativas = 0.0;
  $promSepOpta = 0.0;
  $promOctOpta = 0.0;
  $promNovOpta = 0.0;
  $PromedioOptaPerido1 = 0.0;
  $promDicEneOpta = 0.0;
  $promFebOpta = 0.0;
  $promMarOpta = 0.0;
  $PromedioOptaPerido2 = 0.0;
  $promAbrOpta = 0.0;
  $promMayOpta = 0.0;
  $promJunOpta = 0.0;
  $PromedioOptaPerido3 = 0.0;
  $promedioFinalOpta = 0.0;


  #parametros de promedio general 
  $promedioGeneralPer1FA = 0;
  $promedioGenralPer1ArTu = 0;
  $promedioGeneralFinalPer1 = 0;
  $totalEnDividir = 0;
  $resultadoPeriodo1 = 0;

  $promedioGeneralPer2FA = 0;
  $promedioGenralPer2ArTu = 0;
  $promedioGeneralFinalPer2 = 0;
  $resultadoPeriodo2 = 0;

  $promedioGeneralPer3FA = 0;
  $promedioGenralPer3ArTu = 0;
  $promedioGeneralFinalPer3 = 0;
  $resultadoPeriodo3 = 0;


  $promedioGeneralTrimestreFA = 0.0;
  $promedioGenralTrimestreArTu = 0.0;
  $promedioGeneralFinalTrimestre = 0.0;
  $resultadoTrimestreFin = 0.0;

  $promedioGeneralTrimestreFASEP = 0.0;



  $faltasSep = 0;
  $faltasOct = 0;
  $faltasNov = 0;
  $faltasEne = 0;
  $faltasFeb = 0;
  $faltasMar = 0;
  $faltasAbr = 0;
  $faltasMay = 0;
  $faltasJun = 0;
  
  $promedioParcial1EduFis = 0.0;
  $promedioParcial2EduFis = 0.0;
  $promedioParcial3EduFis = 0.0;
  $promedioDelPromedio1EduFis = 0.0;
  $promedioDelPromedio2EduFis = 0.0;
  $promedioDelPromedio3EduFis = 0.0;
  $promedioFinalDelPromedio = 0.0;
  $promedioFinalEducacionFisSep = 0.0;



  $promedioFisDivSep = 0.0;
  $promedioFisDivOct = 0.0;
  $promedioFisDivNov = 0.0;
  $promedioFisDivPeri1 = 0.0;
  $promedioFisDivEne = 0.0;
  $promedioFisDivFeb = 0.0;
  $promedioFisDivMar = 0.0;
  $promedioFisDivPeri2 = 0.0;
  $promedioFisDivAbr = 0.0;
  $promedioFisDivMay = 0.0;
  $promedioFisDivJun = 0.0;
  $promedioFisDivPeri3 = 0.0;
  $promedioFisDivFinal = 0.0;

  $porSep = 0.0;
  $porOct = 0.0;
  $porNov  = 0.0;

 

  $posicionPromedioGenParte1Periodo1 = 0.0;
  $poscicionDesarrolloSocialPersonal = 0.0;
  $poscicionDesarrolloSocialPersonal2 = 0.0;
  $posicionFisica = 0;
  $posicionTecnologia = 0;

  $promedioPeriodo1Tecnologia = 0.0;
  $promedioPeriodo2Tecnologia = 0.0;
  $promedioPeriodo3Tecnologia = 0.0;
  $promedioTecnologiaFinal = 0.0;

  $promedioPeriodo1Artes = 0.0;
  $promedioPeriodo2Artes = 0.0;
  $promedioPeriodo3Artes = 0.0;
  $promedioGenralTrimestreArtes = 0.0;

  $promedioPeriodo1Tutorias = 0.0;
        $promedioPeriodo2Tutorias = 0.0;
        $promedioPeriodo3Tutorias = 0.0;
        $promedioGenralTrimestreTutorias = 0.0;

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
    
              @if (file_exists(base_path('storage/app/public/secundaria/cursos/fotos/' . $inscrito->perAnioPago . '/' . $campus .'/'. $inscrito->cursecundariaFoto)))
              <img class="img-foto" style="margin-top: -175px;text-aling:rigth" src="{{base_path('storage/app/public/secundaria/cursos/fotos/' . $inscrito->perAnioPago . '/' . $campus .'/'. $inscrito->cursecundariaFoto) }}" alt="">

              @else
                <img class="img-foto"  src="" alt="">    
              @endif

            @else
            <img class="img-foto"  src="" alt="">    
            @endif
            {{--  fin foto   --}}
            <div class="row">
              <div class="columns medium-4">
                  <div style="text-align: left;">
                        <p><b> Clave: {{$clave_pago}}</b></p>
                        <p><b> Alumno: {{$inscrito->ape_paterno}} {{$inscrito->ape_materno}} {{$inscrito->nombres}}</b></p>
                  </div>
              </div>
              {{-- <div class="columns medium-4">
                  <div style="text-align: center;">
                      <p >Grupo:<b> {{$inscrito->gpoGrado}}{{$inscrito->gpoClave}}</b></p>
                      <p >Curp:<b> {{$inscrito->curp}}</b></p>
                  </div>
              </div> --}}
              <div class="columns medium-3"></div>
              <div class="columns medium-3"></div>

              <div class="columns medium-4">
                  <div style="">
                      <p ><b>Fecha: {{$fechaActual}}</b></p>
                      {{-- <p >Hora: {{ $horaActual}}</p> --}}
                      <p><b>Curp: {{$inscrito->curp}}</b></p>
                  </div>
              </div>
            </div>

               
            <br>
        <div class="row">
          <div class="columns medium-12">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                        <th align="center" style="width: 227px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_septiembre/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_octubre/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_noviembre/10}}</th>
                        <th align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>
                        <th align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>

                        <th align="center">Máx {{$secundaria_porcentajes->porc_enero/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_febrero/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_marzo/10}}</th>
                        <th align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>
                        <th align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_abril/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_mayo/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_junio/10}}</th>
                        <th align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>
                        {{--  <th align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>  --}}
                        {{--  <th align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>  --}}


                      </tr>
                      <tr>
                          <th align="center" style="width: 227px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;">Asignaturas</th>
                          <th align="center">Sep</th>
                          <th align="center">Oct</th>
                          <th align="center">Nov</th>
                          <th align="center">Per1</th>
                          <th align="center">Rec1</th>
                          <th align="center">Ene</th>
                          <th align="center">Feb</th>
                          <th align="center">Mar</th>
                          <th align="center">Per2</th>
                          <th align="center">Rec2</th>
                          <th align="center">Abr</th>
                          <th align="center">May</th>
                          <th align="center">Jun</th>
                          <th align="center">Per3</th>
                          {{--  <th align="center">Rec3</th>  --}}
                          <th align="center">Prom</th>
                          {{--  <th align="center">PromSep</th>  --}}

                      </tr>

                      <tr>
                        <th style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        {{--  <th></th>  --}}
                        {{--  <th></th>  --}}
                      </tr>
                      
                  </thead>
                  <tbody>
                    @foreach($calificaciones as $key => $item)
                      @if ($item->clave_pago == $clave_pago)
                        @if ($item->matNombreEspecialidad == "FORMACIÓN ACADÉMICA")
                        @if ($posicion1++ == 1)
                        <tr>
                          <td style="width: 227px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><b>FORMACIÓN ACADÉMICA</b></td>
                        </tr>
                        @endif
                        @php
                            $inscTrimestre1SEP = 0.0;
                            $inscTrimestre2SEP = 0.0;
                            $inscTrimestre3SEP = 0.0;

                        @endphp
                        @if ($item->inscTrimestre1SEP == null)
                          $inscTrimestre1SEP = 0.0;
                        @else
                          $inscTrimestre1SEP = $item->inscTrimestre1SEP;
                        @endif

                        @if ($item->inscTrimestre2SEP == null)
                          $inscTrimestre2SEP = 0.0;
                        @else
                          $inscTrimestre2SEP = $item->inscTrimestre2SEP;
                        @endif

                        @if ($item->inscTrimestre3SEP == null)
                          $inscTrimestre3SEP = 0.0;
                        @else
                          $inscTrimestre3SEP = $item->inscTrimestre3SEP;
                        @endif
                        @php 

                            $promedioGenFormacionAcadePeriodo1 = $promedioGenFormacionAcadePeriodo1 + $item->inscTrimestre1SEP;
                            $promedioGenFormacionAcadePeriodo2 = $promedioGenFormacionAcadePeriodo2 + $item->inscTrimestre2SEP;
                            $promedioGenFormacionAcadePeriodo3 = $promedioGenFormacionAcadePeriodo3 + $item->inscTrimestre3SEP;
                            #$promedioGeneralTrimestreFA = $promedioGeneralTrimestreFA + $item->inscPromedioTrimCALCULADOSEP;
                            $promedioGeneralTrimestreFA = $promedioGeneralTrimestreFA + $item->inscCalificacionFinalModelo;

                            $promedioGeneralTrimestreFASEP = $promedioGeneralTrimestreFASEP + $item->inscCalificacionFinalSEP;


                            # sacar promedios
                            $posicionFA++;
                            $promedioGenFormacionAcadeSep = $promedioGenFormacionAcadeSep + $item->inscCalificacionPorcentajeSep;
                            $promedioGenFormacionAcadeOct = $promedioGenFormacionAcadeOct + $item->inscCalificacionPorcentajeOct;
                            $promedioGenFormacionAcadeNov = $promedioGenFormacionAcadeNov + $item->inscCalificacionPorcentajeNov;
                            $promedioGenFormacionAcadeEne = $promedioGenFormacionAcadeEne + $item->inscCalificacionPorcentajeEne;
                            $promedioGenFormacionAcadeFeb = $promedioGenFormacionAcadeFeb + $item->inscCalificacionPorcentajeFeb;
                            $promedioGenFormacionAcadeMar = $promedioGenFormacionAcadeMar + $item->inscCalificacionPorcentajeMar;
                            $promedioGenFormacionAcadeAbr = $promedioGenFormacionAcadeAbr + $item->inscCalificacionPorcentajeAbr;
                            $promedioGenFormacionAcadeMay = $promedioGenFormacionAcadeMay + $item->inscCalificacionPorcentajeMay;
                            $promedioGenFormacionAcadeJun = $promedioGenFormacionAcadeJun + $item->inscCalificacionPorcentajeJun;

                            #Sacando resultado del promedio
                            $PromedioSepForAcademi = $promedioGenFormacionAcadeSep/$posicionFA;
                            $PromedioOctForAcademi = $promedioGenFormacionAcadeOct/$posicionFA;
                            $PromedioNovForAcademi = $promedioGenFormacionAcadeNov/$posicionFA;
                            $PromForAcademiPeriodo1 = $promedioGenFormacionAcadePeriodo1/$posicionFA;
                            $PromedioEneForAcademi = $promedioGenFormacionAcadeEne/$posicionFA;
                            $PromedioFebForAcademi = $promedioGenFormacionAcadeFeb/$posicionFA;
                            $PromedioMarForAcademi = $promedioGenFormacionAcadeMar/$posicionFA;
                            $PromForAcademiPeriodo2 = $promedioGenFormacionAcadePeriodo2/$posicionFA;
                            $PromedioAbrForAcademi = $promedioGenFormacionAcadeAbr/$posicionFA;
                            $PromedioMayForAcademi = $promedioGenFormacionAcadeMay/$posicionFA;
                            $PromedioJunForAcademi = $promedioGenFormacionAcadeJun/$posicionFA;
                            $PromForAcademiPeriodo3 = $promedioGenFormacionAcadePeriodo3/$posicionFA;
                            $PromForAcademiGeneralModelo = $promedioGeneralTrimestreFA/$posicionFA;

                            #para promedio SEP
                            $PromForAcademiGeneralSep = $promedioGeneralTrimestreFASEP/$posicionFA;


                        @endphp
                        <tr>
                  
                          <td style="width: 200px;">{{$item->matNombreOficial}}</td>

                          <td align="center">
                            {{$item->inscCalificacionPorcentajeSep}}
                          </td>

                          <td align="center">
                            {{$item->inscCalificacionPorcentajeOct}}
                          </td>

                          <td align="center">
                            {{$item->inscCalificacionPorcentajeNov}}
                          </td>

                          <td align="center">
                            <b>{{$item->inscTrimestre1SEP}}</b>
                          </td>

                          <td align="center">
                            @if ($item->inscRecuperativoTrimestre1 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre1))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre1, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre1}}</b>
                              @endif                              
                            @endif   
                          </td>

                          <td align="center">
                            {{$item->inscCalificacionPorcentajeEne}}
                          </td>

                          <td align="center">
                            {{$item->inscCalificacionPorcentajeFeb}}
                          </td>

                          <td align="center">
                            {{$item->inscCalificacionPorcentajeMar}}
                          </td>

                          <td align="center">
                            <b>{{$item->inscTrimestre2SEP}}</b>
                          </td>

                          <td align="center">
                            @if ($item->inscRecuperativoTrimestre2 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre2))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre2, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre2}}</b>
                              @endif                              
                            @endif   
                          </td>

                          <td align="center">{{$item->inscCalificacionPorcentajeAbr}}</td>
                          <td align="center">{{$item->inscCalificacionPorcentajeMay}}</td>
                          <td align="center">{{$item->inscCalificacionPorcentajeJun}}</td>

                      
                          <td align="center">
                            <b>{{$item->inscTrimestre3SEP}}</b>
                          </td>


                          {{--  <td align="center">                            
                            @if ($item->inscRecuperativoTrimestre3 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre3))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre3, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre3}}</b>
                              @endif                              
                            @endif 
                          </td>  --}}
                          

                          {{--  promedio final   --}}
                          <td align="center">
                            {{--  inscPromedioTrimCALCULADOSEP  --}}
                            @if ($item->inscTrimestre1SEP != "" && $item->inscTrimestre2SEP != "" && $item->inscTrimestre3SEP != "")
                              @if ($item->inscCalificacionFinalModelo != "")
                              <b>{{$item->inscCalificacionFinalModelo}}</b> 
                              @else
                                  
                              @endif
                            @endif                            
                                                       
                          </td>

                          {{--  <td align="center">
                            @if ($item->inscTrimestre1SEP != "" && $item->inscTrimestre2SEP != "" && $item->inscTrimestre3SEP != "")
                              @if ($item->inscCalificacionFinalSEP != "")
                              <b>{{$item->inscCalificacionFinalSEP}}</b> 
                              @else
                                  
                              @endif
                            @endif                           
                                                       
                          </td>  --}}

                          
                        </tr>
                        @endif                           
                      @endif                          
                    @endforeach
                    
                
                       
              </tbody>
              </table>
              <table class="table table-bordered">
                <thead>                
                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)
                     @php
                         $keyPromedioGeneralFormacionAcademica++;

                         
                     @endphp
                     @if ($keyPromedioGeneralFormacionAcademica == 1)
                     @php
                     $posicionPromedioGenParte1Periodo1 = $keyPromedioGeneralFormacionAcademica;
                     @endphp
                      <tr>                      
                        <td style="width: 196.5px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;"><b>PROM. FORMACIÓN ACADÉMICA</b></td>                 
                        

                        <td align="center" style="width: 38.5px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          <b>{{number_format((float)$PromedioSepForAcademi, 1, '.', '')}}</b>
                        </td>                  

                        
                        <td align="center" style="width: 38.5px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">                          
                          @if ($item->inscCalificacionPorcentajeOct != "")
                          <b>{{number_format((float)$PromedioOctForAcademi, 1, '.', '')}}</b>  
                          @else
                          @endif
                        </td>                        
                  
                        <td align="center" style="width: 38.4px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->inscCalificacionPorcentajeNov != "")
                          <b>{{number_format((float)$PromedioNovForAcademi, 1, '.', '')}}</b>
                          @else
                          @endif
                        </td>

                        
                  
                        {{--  promedio trimestree 1  --}}
                        @if ($PromForAcademiPeriodo1 != "")
                        <td align="center" style="width: 38.6px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          <b>{{number_format((float)$PromForAcademiPeriodo1, 0, '.', '')}}</b>
                        </td>
                        @else
                        <td align="center" style="width: 38.6px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  columna recuperativo1  --}}
                        <td align="center" style="width: 39px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>

                      
                  
                        <td align="center" style="width: 37.5px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->inscCalificacionPorcentajeEne != "")
                          <b>{{number_format((float)$PromedioEneForAcademi, 1, '.', '')}}</b>  
                          @else
                          @endif
                        </td>

                        <td align="center" style="width: 37.9px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->inscCalificacionPorcentajeFeb != "")
                          <b>{{number_format((float)$PromedioFebForAcademi, 1, '.', '')}}</b>  
                          @else
                          
                          @endif
                        </td>
                        
                        <td align="center" style="width: 38px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->inscCalificacionPorcentajeMar != "")
                          <b>{{number_format((float)$PromedioMarForAcademi, 1, '.', '')}}</b>  
                          @else
                          
                          @endif
                        </td>

                        
                  
                        {{--  promedio trimestre 2   --}}
                        @if ($PromForAcademiPeriodo2 != "")
                        <td align="center" style="width: 39px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          <b>{{number_format((float)$PromForAcademiPeriodo2, 0, '.', '')}}</b>                     
                        </td>
                        @else
                        <td align="center" style="width: 39px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  columna recuperativo2  --}}
                        <td align="center" style="width: 39.7px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>

                        <td align="center" style="width: 38.5px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->inscCalificacionPorcentajeAbr != "")
                          <b>{{number_format((float)$PromedioAbrForAcademi, 1, '.', '')}}</b>  
                          @else
                          
                          @endif
                        </td>

                        <td align="center" style="width: 38.2px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->inscCalificacionPorcentajeMay != "")
                          <b>{{number_format((float)$PromedioMayForAcademi, 1, '.', '')}}</b>  
                          @else
                          
                          @endif
                        </td>

                        <td align="center" style="width: 37.9px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->inscCalificacionPorcentajeJun != "")
                          <b>{{number_format((float)$PromedioJunForAcademi, 1, '.', '')}}</b>  
                          @else
                          
                          @endif
                        </td>

                        
                  
                        {{--  promedio trimestre 3   --}}
                        @if ($PromForAcademiPeriodo3 != "")
                        <td align="center" style="width: 39px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          <b>{{number_format((float)$PromForAcademiPeriodo3, 0, '.', '')}}</b>                     
                        </td>
                        @else
                        <td align="center" style="width: 39px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>
                        @endif
                                      
                        {{--  columna recuperativo3  --}}
                        {{--  <td align="center" style="width: 39.4px; border-top: 0px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>  --}}
                  
                        {{--  columna final modelo   --}}
                        <td align="center" style="width: 42.4px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">                          
                          @if ($PromForAcademiGeneralModelo != "")
                            @if ($PromForAcademiGeneralModelo == 10)
                            <b>{{number_format((float)$PromForAcademiGeneralModelo, 0, '.', '')}}</b>
                            @else
                            <b>{{number_format((float)$PromForAcademiGeneralModelo, 1, '.', '')}}</b>
                            @endif                          
                          @else
                              
                          @endif
                                                 
                        </td>

                        {{--  columna final sep  --}}
                        {{--  <td align="center" style="width: 57px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($PromForAcademiGeneralSep != "")
                            @if ($PromForAcademiGeneralSep == 10)
                            <b>{{number_format((float)$PromForAcademiGeneralSep, 0, '.', '')}}</b>
                            @else
                            <b>{{number_format((float)$PromForAcademiGeneralSep, 1, '.', '')}}</b>
                            @endif                          
                          @else
                              
                          @endif
                        </td>  --}}
                      </tr>                    
                     @endif
                    @endif
                  @endforeach
              
                </tbody>
              </table>


              
              {{--  DESARROLLO PERSONAL Y SOCIAL EDUCACION FISICA --}}
              <br>
              <table class="table table-bordered">
                <thead>
                 
                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)

                    @if ($posicion2++ == 1)
                        <tr>
                          <td style="width: 190px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><b>DESARROLLO PERSONAL Y SOCIAL</b></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          {{--  <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>  --}}
                          {{--  <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>  --}}
                        </tr>
                        @endif

                      @if ($item->matNombreEspecialidad == "DESARROLLO PERSONAL Y SOCIAL" && $item->matNombre == "ARTES")
                      @php
                          $poscicionDesarrolloSocialPersonal++;
                          $promedioPeriodo1Artes = $promedioPeriodo1Artes + $item->inscTrimestre1SEP;
                          $promedioPeriodo2Artes = $promedioPeriodo2Artes + $item->inscTrimestre2SEP;
                          $promedioPeriodo3Artes = $promedioPeriodo3Artes + $item->inscTrimestre3SEP;
                          #$promedioGenralTrimestreArtes = $promedioGenralTrimestreArtes + $item->inscPromedioTrimCALCULADOSEP;
                          $promedioGenralTrimestreArtes = $promedioGenralTrimestreArtes + $item->inscCalificacionFinalModelo;

                      @endphp
                        <tr>
                                               
                          <td style="width: 190px;">
                            @if ($item->gpoMatComplementaria != "")
                            {{$item->matNombreOficial}} ({{$item->gpoMatComplementaria}})
                            @else     
                            {{$item->matNombreOficial}}                           
                            @endif                            
                          </td>                 
                          

                          @if ($item->inscCalificacionPorcentajeSep != "")
                            <td align="center" style="width: 37.4px;">
                              {{$item->inscCalificacionPorcentajeSep}}
                            </td>                        
                          @else
                            <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                          @endif
                    

                          @if ($item->inscCalificacionPorcentajeOct != "")
                            <td align="center" style="width: 37.4px;">
                              {{$item->inscCalificacionPorcentajeOct}}
                            </td>
                          @else
                            <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->inscCalificacionPorcentajeNov != "")
                            <td align="center" style="width: 37.4px;">
                              {{$item->inscCalificacionPorcentajeNov}}
                            </td>
                          @else
                            <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestree 1  --}}
                          @if ($item->inscTrimestre1SEP != "")
                          <td align="center" style="width: 37.4px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px; border-left: 1px solid;">
                            <b>{{$item->inscTrimestre1SEP}}</b>
                          </td>
                          @else
                          <td align="center" style="width: 37.4px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>
                          @endif

                          {{--  aqui  --}}
                          <td align="center" style="width: 38.8px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                         
                            @if ($item->inscRecuperativoTrimestre1 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre1))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre1, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre1}}</b>
                              @endif                              
                            @endif 
                          </td>

                        
                    
                          @if ($item->inscCalificacionPorcentajeEne != "")
                          <td align="center" style="width: 37.1px;">
                            {{$item->inscCalificacionPorcentajeEne}}
                          </td>
                          @else
                          <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->inscCalificacionPorcentajeFeb != "")
                          <td align="center" style="width: 37px;">
                            {{$item->inscCalificacionPorcentajeFeb}}
                          </td>
                          @else
                          <td align="center" style="width: 37px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->inscCalificacionPorcentajeMar != "")
                          <td align="center" style="width: 37.4px;">
                            {{$item->inscCalificacionPorcentajeMar}}
                          </td>
                          @else
                          <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestre 2   --}}
                          @if ($item->inscTrimestre2SEP != "")
                          <td align="center" style="width: 37.8px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                            <b>{{$item->inscTrimestre2SEP}}</b>
                          </td>
                          @else
                          <td align="center" style="width: 37.8px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif

                          <td align="center" style="width: 38.8px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                              
                            @if ($item->inscRecuperativoTrimestre2 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre2))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre2, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre2}}</b>
                              @endif                              
                            @endif 
                          </td>
                      
                          @if ($item->inscCalificacionPorcentajeAbr != "")
                          <td align="center" style="width: 37.1px;">{{$item->inscCalificacionPorcentajeAbr}}</td>
                          @else
                          <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                          @endif

                          @if ($item->inscCalificacionPorcentajeMay != "")
                          <td align="center" style="width: 37.1px;">{{$item->inscCalificacionPorcentajeMay}}</td>
                          @else
                          <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          

                          @if ($item->inscCalificacionPorcentajeJun != "")
                          <td align="center" style="width: 37.1px;">{{$item->inscCalificacionPorcentajeJun}}</td>
                          @else
                          <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestre 3   --}}
                          @if ($item->inscTrimestre3SEP != "")
                          <td align="center" style="width: 38px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                            <b>{{$item->inscTrimestre3SEP}}</b>
                          </td>
                          @else
                          <td align="center" style="width: 38px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif

                          {{--  <td align="center" style="width: 39px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                           
                            @if ($item->inscRecuperativoTrimestre3 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre3))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre3, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre3}}</b>
                              @endif                              
                            @endif 
                          </td>  --}}
                                                                    
                    
                          <td align="center" style="width: 42.4px;">
                            @if ($item->inscCalificacionFinalModelo != "")
                              @if ($item->inscCalificacionFinalModelo == 10)
                              <b>{{number_format((float)$item->inscCalificacionFinalModelo, 0, '.', '')}}</b>
                              @else
                              <b>{{number_format((float)$item->inscCalificacionFinalModelo, 1, '.', '')}}</b>
                              @endif                              
                            @else
                                  
                            @endif   
                          </td>
  
                          {{--  <td align="center" style="width: 57px;">
                            @if ($item->inscCalificacionFinalSEP != "")
                              @if ($item->inscCalificacionFinalSEP == 10)
                              <b>{{number_format((float)$item->inscCalificacionFinalSEP, 0, '.', '')}}</b>
                              @else
                              <b>{{number_format((float)$item->inscCalificacionFinalSEP, 1, '.', '')}}</b>
                              @endif                              
                            @else
                                  
                            @endif   
                          </td>  --}}

                        </tr>
                      @endif

                      @if ($item->matNombreEspecialidad == "DESARROLLO PERSONAL Y SOCIAL" && $item->matNombre == "TUTORIA Y EDUCACION SOCIOEMOCIONAL")
                      @php
                          $poscicionDesarrolloSocialPersonal2++;
                          $promedioPeriodo1Tutorias = $promedioPeriodo1Tutorias + $item->inscTrimestre1SEP;
                          $promedioPeriodo2Tutorias = $promedioPeriodo2Tutorias + $item->inscTrimestre2SEP;
                          $promedioPeriodo3Tutorias = $promedioPeriodo3Tutorias + $item->inscTrimestre3SEP;
                          #$promedioGenralTrimestreTutorias = $promedioGenralTrimestreTutorias + $item->inscPromedioTrimCALCULADOSEP;
                          $promedioGenralTrimestreTutorias = $promedioGenralTrimestreTutorias + $item->inscCalificacionFinalModelo;

                      @endphp
                     
                      <tr>
                                           
                        <td style="width: 194px;">{{$item->matNombreOficial}}</td>                 
                        

                        @if ($item->inscCalificacionPorcentajeSep != "")
                          <td align="center" style="width: 37.4px;">
                            {{$item->inscCalificacionPorcentajeSep}}
                          </td>                        
                        @else
                          <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                        @endif
                  

                        @if ($item->inscCalificacionPorcentajeOct != "")
                          <td align="center" style="width: 37.4px;">
                            {{$item->inscCalificacionPorcentajeOct}}
                          </td>
                        @else
                          <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionPorcentajeNov != "")
                          <td align="center" style="width: 37.4px;">
                            {{$item->inscCalificacionPorcentajeNov}}
                          </td>
                        @else
                          <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestree 1  --}}
                        @if ($item->inscTrimestre1SEP != "")
                        <td align="center" style="width: 38px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          <b>{{$item->inscTrimestre1SEP}}</b>
                        </td>
                        @else
                        <td align="center" style="width: 38px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>
                        @endif


                        {{--  aqui  --}}
                        <td align="center" style="width: 39px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                        
                          @if ($item->inscRecuperativoTrimestre1 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre1))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre1, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre1}}</b>
                              @endif                              
                            @endif 
                        </td>
                      
                  
                        @if ($item->inscCalificacionPorcentajeEne != "")
                        <td align="center" style="width: 37.1px;">
                          {{$item->inscCalificacionPorcentajeEne}}
                        </td>
                        @else
                        <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionPorcentajeFeb != "")
                        <td align="center" style="width: 37.5px;">
                          {{$item->inscCalificacionPorcentajeFeb}}
                        </td>
                        @else
                        <td align="center" style="width: 37.5px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->inscCalificacionPorcentajeMar != "")
                        <td align="center" style="width: 37.4px;">
                          {{$item->inscCalificacionPorcentajeMar}}
                        </td>
                        @else
                        <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestre 2   --}}
                        @if ($item->inscTrimestre2SEP != "")
                        <td align="center" style="width: 37.8px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                          <b>{{$item->inscTrimestre2SEP}}</b>
                        </td>
                        @else
                        <td align="center" style="width: 37.8px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  aqui   --}}
                        <td align="center" style="width: 38.8px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                          @if ($item->inscRecuperativoTrimestre2 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre2))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre2, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre2}}</b>
                              @endif                              
                            @endif  
                        </td>
                    
                        @if ($item->inscCalificacionPorcentajeAbr != "")
                        <td align="center" style="width: 37.1px;">{{$item->inscCalificacionPorcentajeAbr}}</td>
                        @else
                        <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->inscCalificacionPorcentajeMay != "")
                        <td align="center" style="width: 37.1px;">{{$item->inscCalificacionPorcentajeMay}}</td>
                        @else
                        <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        

                        @if ($item->inscCalificacionPorcentajeJun != "")
                        <td align="center" style="width: 37.1px;">{{$item->inscCalificacionPorcentajeJun}}</td>
                        @else
                        <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestre 3   --}}
                        @if ($item->inscTrimestre3SEP != "")
                        <td align="center" style="width: 38px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                          <b>{{$item->inscTrimestre3SEP}}</b>
                        </td>
                        @else
                        <td align="center" style="width: 38px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        @endif
                                        
                        
                        {{--  <td align="center" style="width: 39px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                      
                          @if ($item->inscRecuperativoTrimestre3 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre3))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre3, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre3}}</b>
                              @endif                              
                            @endif 
                        </td>  --}}
                  
                        <td align="center" style="width: 42.4px;">
                          @if ($item->inscCalificacionFinalModelo != "")
                            @if ($item->inscCalificacionFinalModelo == 10)
                            <b>{{number_format((float)$item->inscCalificacionFinalModelo, 0, '.', '')}}</b>
                            @else
                            <b>{{number_format((float)$item->inscCalificacionFinalModelo, 1, '.', '')}}</b>
                            @endif                              
                          @else
                                
                          @endif   
                        </td>

                        {{--  <td align="center" style="width: 57px;">
                          @if ($item->inscCalificacionFinalSEP != "")
                            @if ($item->inscCalificacionFinalSEP == 10)
                            <b>{{number_format((float)$item->inscCalificacionFinalSEP, 0, '.', '')}}</b>
                            @else
                            <b>{{number_format((float)$item->inscCalificacionFinalSEP, 1, '.', '')}}</b>
                            @endif                              
                          @else
                                
                          @endif   
                        </td>  --}}

                      </tr>
                      @endif

                                         
                    @endif
                  @endforeach            

              
                </tbody>
              </table>

              <br> 
              {{--  educacion fisica   --}}
              <table class="table table-bordered">
                <thead>
                 
                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)

                    @if ($posicion10++ == 1)
                        <tr>
                          <td style="width: 193px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><b></b></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          {{--  <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>  --}}
                          {{--  <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>  --}}

                        </tr>
                        @endif

                     

                      @if ($item->matNombreEspecialidad == "DESARROLLO PERSONAL Y SOCIAL" && $item->matNombre == "EDUCACION FISICA" || $item->matNombre == "EDUCACION FISICA VESP") 
                      {{--  @if ($item->matNombreEspecialidad == "DESARROLLO PERSONAL Y SOCIAL" && $item->matNombre == "EDUCACION FISICA")                        --}}
                     
                        @php
                            $keyMatDESA++;
                            $promSEPDESA = $promSEPDESA + $item->inscCalificacionPorcentajeSep; 
                            $promOCTDESA = $promOCTDESA + $item->inscCalificacionPorcentajeOct;
                            $promNOVDESA = $promNOVDESA + $item->inscCalificacionPorcentajeNov;
                            $PromedioDesaPerido1 = $PromedioDesaPerido1 + $item->inscTrimestre1SEP;
                            $promDICENEDESA = $promDICENEDESA + $item->inscCalificacionPorcentajeEne; 
                            $promFEBDESA = $promFEBDESA + $item->inscCalificacionPorcentajeFeb;
                            $promMARDESA = $promMARDESA + $item->inscCalificacionPorcentajeMar;
                            $PromedioDesaPerido2 = $PromedioDesaPerido2 + $item->inscTrimestre2SEP;
                            $promABRDESA = $promABRDESA + $item->inscCalificacionPorcentajeAbr; 
                            $promMAYDESA = $promMAYDESA + $item->inscCalificacionPorcentajeMay; 
                            $promJUNDESA = $promJUNDESA + $item->inscCalificacionPorcentajeJun; 
                            $PromedioDesaPerido3 = $PromedioDesaPerido3 + $item->inscTrimestre3SEP;
                            #$promedioFinalDESA = $promedioFinalDESA + $item->inscPromedioTrimCALCULADOSEP; 
                            $promedioFinalDESA = $promedioFinalDESA + $item->inscCalificacionFinalModelo; 


                            $posicion3Fisi++;
                            
                            ##Sacamos el calculo de la aprobacion minima
                            $porSep = $secundaria_porcentajes->porc_septiembre/100;
                            $porOct = $secundaria_porcentajes->porc_octubre/100;
                            $porNov = $secundaria_porcentajes->porc_noviembre/100;

                            $porEne = $secundaria_porcentajes->porc_enero/100;
                            $porFeb = $secundaria_porcentajes->porc_febrero/100;
                            $porMar = $secundaria_porcentajes->porc_marzo/100;

                            $porAbr = $secundaria_porcentajes->porc_abril/100;
                            $porMay = $secundaria_porcentajes->porc_mayo/100;
                            $porJun = $secundaria_porcentajes->porc_junio/100;

                            $calculoAproSep = 6 * $porSep;
                            $calculoAproOct = 6 * $porOct;
                            $calculoAproNov = 6 * $porNov;
                            $calculoAproEne = 6 * $porEne;
                            $calculoAproFeb = 6 * $porFeb;
                            $calculoAproMar = 6 * $porMar;
                            $calculoAproAbr = 6 * $porAbr;
                            $calculoAproMay = 6 * $porMay;
                            $calculoAproJun = 6 * $porJun;

                            if($item->inscCalificacionPorcentajeSep != ""){
                              if($item->inscCalificacionPorcentajeSep >= $calculoAproSep){
                                $promedioFisDivSep = $promSEPDESA/$posicion3Fisi;
                              }else{
                                $promedioFisDivSep = 5 * $porSep;
                              }
                            }
                            

                            if($item->inscCalificacionPorcentajeOct != ""){
                              if($item->inscCalificacionPorcentajeOct >= $calculoAproOct){
                                $promedioFisDivOct = $promOCTDESA/$posicion3Fisi;
                              }else{
                                $promedioFisDivOct = 5 * $porOct;
                              }
                            }
                            

                            if($item->inscCalificacionPorcentajeNov !=  ""){
                              if($item->inscCalificacionPorcentajeNov >= $calculoAproNov){
                                $promedioFisDivNov = $promNOVDESA/$posicion3Fisi;
                              }else{
                                $promedioFisDivNov = 5 * $porNov;
                              }
                            }
                            

                            if($item->inscCalificacionPorcentajeEne != ""){
                              if($item->inscCalificacionPorcentajeEne >= $calculoAproEne){
                                $promedioFisDivEne = $promDICENEDESA/$posicion3Fisi;
                              }else{
                                $promedioFisDivEne = 5 * $porEne;
                              }
                            }
                            

                            if($item->inscCalificacionPorcentajeFeb != ""){
                              if($item->inscCalificacionPorcentajeFeb >= $calculoAproFeb){
                                $promedioFisDivFeb = $promFEBDESA/$posicion3Fisi;
                              }else{
                                $promedioFisDivFeb = 5 * $porFeb;
                              }
                            }
                            

                            if($item->inscCalificacionPorcentajeMar != ""){
                              if($item->inscCalificacionPorcentajeMar >= $calculoAproMar){
                                $promedioFisDivMar = $promMARDESA/$posicion3Fisi;
                              }else{
                                $promedioFisDivMar = 5 * $porMar;
                              }
                            }
                            

                            if($item->inscCalificacionPorcentajeAbr != ""){
                              if($item->inscCalificacionPorcentajeAbr >= $calculoAproAbr){
                                $promedioFisDivAbr = $promABRDESA/$posicion3Fisi;
                              }else{
                                $promedioFisDivAbr = 5 * $porAbr;
                              }
                            }
                            

                            if($item->inscCalificacionPorcentajeMay != ""){
                              if($item->inscCalificacionPorcentajeMay >= $calculoAproMay){
                                $promedioFisDivMay = $promMAYDESA/$posicion3Fisi;
                              }else{
                                $promedioFisDivMay = 5 * $porMay;
                              }
                            }
                            

                            if($item->inscCalificacionPorcentajeJun != ""){
                              if($item->inscCalificacionPorcentajeJun >= $calculoAproJun){
                                $promedioFisDivJun = $promJUNDESA/$posicion3Fisi;
                              }else{
                                $promedioFisDivJun = 5 * $porJun;
                              }
                            }
                            

                            $promedioFisDivPeri1 = $PromedioDesaPerido1/$posicion3Fisi;
                            $promedioFisDivPeri2 = $PromedioDesaPerido2/$posicion3Fisi;
                            $promedioFisDivPeri3 = $PromedioDesaPerido3/$posicion3Fisi;
                            $promedioFisDivFinal = $promedioFinalDESA/$posicion3Fisi;

                            $promedioParcial1EduFis = $promedioParcial1EduFis + $item->inscCalificacionPorcentajeSep + $item->inscCalificacionPorcentajeOct + $item->inscCalificacionPorcentajeNov;
                            $promedioParcial2EduFis = $promedioParcial2EduFis + $item->inscCalificacionPorcentajeEne + $item->inscCalificacionPorcentajeFeb + $item->inscCalificacionPorcentajeMar;
                            $promedioParcial3EduFis = $promedioParcial3EduFis + $item->inscCalificacionPorcentajeAbr + $item->inscCalificacionPorcentajeMay + $item->inscCalificacionPorcentajeJun;

                           


                        @endphp
                       
                        <tr>
                      
                        
                          <td style="width: 194px;">{{$item->matNombreOficial}}</td>                 
                          

                          @if ($item->inscCalificacionPorcentajeSep != "")
                            <td align="center" style="width: 37.4px;">
                              @if ($item->inscCalificacionPorcentajeSep >= $calculoAproSep)
                                  <label>{{$item->inscCalificacionPorcentajeSep}}</label>
                              @else
                              {{--  rojo   --}}
                                <label>{{$item->inscCalificacionPorcentajeSep}}</label>
                              @endif                              
                            </td>                        
                          @else
                            <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                          @endif
                    

                          @if ($item->inscCalificacionPorcentajeOct != "")
                            <td align="center" style="width: 37.4px;">
                              @if ($item->inscCalificacionPorcentajeOct >= $calculoAproOct)
                                  <label>{{$item->inscCalificacionPorcentajeOct}}</label>
                              @else
                              {{--  rojo   --}}
                                <label>{{$item->inscCalificacionPorcentajeOct}}</label>
                              @endif                              
                            </td>
                          @else
                            <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->inscCalificacionPorcentajeNov != "")
                            <td align="center" style="width: 37.4px;">
                              @if ($item->inscCalificacionPorcentajeNov >= $calculoAproNov)
                                  <label>{{$item->inscCalificacionPorcentajeNov}}</label>
                              @else
                              {{--  rojo   --}}
                                <label>{{$item->inscCalificacionPorcentajeNov}}</label>
                              @endif                              
                            </td>
                          @else
                            <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestree 1  --}}
                          @if ($promedioParcial1EduFis != "")
                          <td align="center" style="width: 37.4px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">
                            {{--  @if ($promedioParcial1EduFis > 5)
                                <b>{{number_format((float)$promedioParcial1EduFis, 0, '.', '')}}</b>
                            @else
                                <b>5</b>
                            @endif  --}}
                          </td>
                          @else
                          <td align="center" style="width: 37.4px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif


                          {{--  recu1 educa  --}}
                          <td align="center" style="width: 38.8px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          
                            @if ($item->inscRecuperativoTrimestre1 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre1))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre1, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre1}}</b>
                              @endif                              
                            @endif 
                          </td>

                        
                    
                          @if ($item->inscCalificacionPorcentajeEne != "")
                          <td align="center" style="width: 37.1px;">
                            @if ($item->inscCalificacionPorcentajeEne >= $calculoAproEne)
                                  <label>{{$item->inscCalificacionPorcentajeEne}}</label>
                              @else
                              {{--  rojo   --}}
                                <label>{{$item->inscCalificacionPorcentajeEne}}</label>
                              @endif  
                          </td>
                          @else
                          <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->inscCalificacionPorcentajeFeb != "")
                          <td align="center" style="width: 37px;">
                            @if ($item->inscCalificacionPorcentajeFeb >= $calculoAproFeb)
                                  <label>{{$item->inscCalificacionPorcentajeFeb}}</label>
                              @else
                              {{--  rojo   --}}
                                <label>{{$item->inscCalificacionPorcentajeFeb}}</label>
                              @endif  
                          </td>
                          @else
                          <td align="center" style="width: 37px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->inscCalificacionPorcentajeMar != "")
                          <td align="center" style="width: 37.4px;">
                            @if ($item->inscCalificacionPorcentajeMar >= $calculoAproMar)
                                  <label>{{$item->inscCalificacionPorcentajeMar}}</label>
                              @else
                              {{--  rojo   --}}
                                <label>{{$item->inscCalificacionPorcentajeMar}}</label>
                              @endif  
                          </td>
                          @else
                          <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestre 2   --}}
                          @if ($promedioParcial2EduFis != "")
                          <td align="center" style="width: 37.8px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">
                            {{--  @if ($promedioParcial2EduFis > 5)
                                <b>{{number_format((float)$promedioParcial2EduFis, 0, '.', '')}}</b>
                            @else
                                <b>5</b>
                            @endif  --}}
                          </td>
                          @else
                          <td align="center" style="width: 37.8px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif

                          {{--  recu2 educa  --}}
                          <td align="center" style="width: 38.8px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">
                           
                            @if ($item->inscRecuperativoTrimestre2 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre2))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre2, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre2}}</b>
                              @endif                              
                            @endif  
                          </td>
                      
                          @if ($item->inscCalificacionPorcentajeAbr != "")
                          <td align="center" style="width: 37.1px;">
                            @if ($item->inscCalificacionPorcentajeAbr >= $calculoAproAbr)
                                <label>{{$item->inscCalificacionPorcentajeAbr}}</label>
                            @else
                            {{--  rojo   --}}
                              <label>{{$item->inscCalificacionPorcentajeAbr}}</label>
                            @endif  
                          </td>
                          @else
                          <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                          @endif

                          @if ($item->inscCalificacionPorcentajeMay != "")
                          <td align="center" style="width: 37.1px;">
                            @if ($item->inscCalificacionPorcentajeMay >= $calculoAproMay)
                                <label>{{$item->inscCalificacionPorcentajeMay}}</label>
                            @else
                            {{--  rojo   --}}
                              <label>{{$item->inscCalificacionPorcentajeMay}}</label>
                            @endif
                          </td>
                          @else
                          <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          

                          @if ($item->inscCalificacionPorcentajeJun != "")
                          <td align="center" style="width: 37.1px;">
                            @if ($item->inscCalificacionPorcentajeJun >= $calculoAproJun)
                                <label>{{$item->inscCalificacionPorcentajeJun}}</label>
                            @else
                            {{--  rojo   --}}
                              <label>{{$item->inscCalificacionPorcentajeJun}}</label>
                            @endif
                          </td>
                          @else
                          <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestre 3   --}}
                          @if ($promedioParcial3EduFis != "")
                          <td align="center" style="width: 38px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">
                            {{--  @if ($promedioParcial3EduFis > 5)
                            <b>{{number_format((float)$promedioParcial3EduFis, 0, '.', '')}}</b>
                            @else
                                <b>5</b>
                            @endif  --}}
                          </td>
                          @else
                          <td align="center" style="width: 38px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif
                                          
                          
                          {{--  recu1 educa  --}}
                          {{--  <td align="center" style="width: 39px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                         
                            @if ($item->inscRecuperativoTrimestre3 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre3))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre3, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre3}}</b>
                              @endif                              
                            @endif 
                          </td>  --}}
                    
                          <td align="center" style="width: 42.4px;"><label style="opacity: .01;">0</label></td>

                          {{--  <td align="center" style="width: 57px;"><label style="opacity: .01;">0</label></td>  --}}

                        </tr>
                        {{--  Solo para mostrar fila ves y para merida  --}}
                        
                      @endif                      
                    @endif

                    @php
                        $promedioParcial1EduFis = 0.0;
                        $promedioParcial2EduFis = 0.0;
                        $promedioParcial3EduFis = 0.0;
        
                    @endphp
                  @endforeach      
                  
                    {{--  Solo para mostrar fila ves y para merida  --}}
                    {{--  @if ($secundaria_porcentajes->departamento_id == "15")  --}}

                    {{--  <tr>
                        
                        
                      <td style="width: 227%;">EDUCACION FISICA VESP</td>                 
                      
  
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                
  
                      <td align="center" style="width: 50px;"><label style="opacity: .01;">0</label></td>
                      
                
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>  --}}
                      
                
                      {{--  promedio trimestree 1  --}}
                      {{--  <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>  --}}
  
  
                    
                
                      {{--  <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>  --}}
  
                      {{--  <td align="center" style="width: 51px;"><label style="opacity: .01;">0</label></td>  --}}
  
                      {{--  <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>  --}}
  
                
                      {{--  promedio trimestre 2   --}}
                      {{--  <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
  
  
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
  
                      <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
  
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>  --}}
  
                      
                
                      {{--  promedio trimestre 3   --}}
                      {{--  <td align="center" style="width: 54px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>  --}}
  
                                                                
                
                      {{--  <td align="center" style="width: 60px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>  --}}
  
                      
                    {{--  </tr>  --}}
                    
                    {{--  @endif  --}}
                  

                    <tr>
                      <td><b>PROMEDIO EDUCACIÓN FÍSICA</b></td> 
                      @php

                        if($promedioFisDivSep != "" && $promedioFisDivOct != "" && $promedioFisDivNov != ""){
                          ##Promedio del promedio
                          $promedioDelPromedio1EduFis = $promedioDelPromedio1EduFis +  $promedioFisDivSep + $promedioFisDivOct + $promedioFisDivNov;
                        }else{
                          $promedioDelPromedio1EduFis = $promedioDelPromedio1EduFis;
                        }
                           

                        
                           
  
                           $promedioFinalEducacionFisSep = ($promedioDelPromedio1EduFis + $promedioDelPromedio2EduFis+ $promedioDelPromedio3EduFis) /3;
  
                           if($promedioFisDivEne == "" || $promedioFisDivFeb == "" || $promedioFisDivMar == ""){
                            $promedioDelPromedio2EduFis = 0;
                           }else{
                            $promedioDelPromedio2EduFis = $promedioDelPromedio2EduFis +  $promedioFisDivEne + $promedioFisDivFeb + $promedioFisDivMar;
                           }
  
                           if($promedioFisDivAbr == "" && $promedioFisDivMay == "" && $promedioFisDivJun == ""){
                            $promedioDelPromedio3EduFis = 0;
                           }else{
                            $promedioDelPromedio3EduFis = $promedioDelPromedio3EduFis +  $promedioFisDivAbr + $promedioFisDivMay + $promedioFisDivJun;
                           }
  
                           #aqui es
                           if($promedioDelPromedio1EduFis == "" || $promedioDelPromedio2EduFis == "" || $promedioDelPromedio3EduFis == ""){
                            $promedioFinalDelPromedio = "";
                           }else{
                            $promedioFinalDelPromedio = ($promedioFinalDelPromedio + number_format((float)$promedioDelPromedio1EduFis, 0, '.', '') + number_format((float)$promedioDelPromedio2EduFis, 0, '.', '') + number_format((float)$promedioDelPromedio3EduFis, 0, '.', '')) / 3;
                           }
  
                           
                           
                           $posicionFisica++;
                           
                      @endphp
                      {{--  promedio septiembree  --}}
                      @if ($promedioFisDivSep != "")
                        <td align="center">
                          {{number_format((float)$promedioFisDivSep, 1, '.', '')}}
                          {{--  {{$promedioFisDivSep}}  --}}
                        </td>
                      @else
                        <td align="center"><label style="opacity: .01;">0</label></td>
                      @endif
  
                      {{--  promedio octubre   --}}
                      @if ($promedioFisDivOct != "")
                        <td align="center">
                          {{number_format((float)$promedioFisDivOct, 1, '.', '')}}
                          {{--  {{$promedioFisDivOct}}  --}}
                        </td>
                      @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                      @endif
                      
  
  
                      {{--  promedio noviembre   --}}
                      @if ($promedioFisDivNov != "")
                        <td align="center">
                          {{number_format((float)$promedioFisDivNov, 1, '.', '')}}
                          {{--  {{$promedioFisDivNov}}  --}}
                        </td>
                      @else
                        <td align="center"><label style="opacity: .01;">0</label></td>
                      @endif
                      
  
                      {{--  promedio general primer periodo   --}}
                      <td align="center">
                        @if ($promedioDelPromedio1EduFis != "")
                          @if ($promedioDelPromedio1EduFis > 5)
                            <b>{{number_format((float)$promedioDelPromedio1EduFis, 0, '.', '')}}</b>
                          @else
                              <b>5</b>
                          @endif
                        
                        @else
                            
                        @endif
                                       
                      </td>

                      <td></td>
                   
                      {{--  segundo periodo  --}}
                      {{--  promedio dic enero  --}}
                      <td align="center">
                        @if ($promedioFisDivEne != "")
                          {{number_format((float)$promedioFisDivEne, 1, '.', '')}}
                          {{--  {{$promedioFisDivEne}}  --}}
                        @else
                            
                        @endif
                        
                      </td>
  
                      {{--  promedio febrero  --}}
                      <td align="center">
                        @if ($promedioFisDivFeb != "")
                          {{number_format((float)$promedioFisDivFeb, 1, '.', '')}}
                          {{--  {{$promedioFisDivFeb}}  --}}
                        @else
                            
                        @endif
                        
                      </td>
  
                      {{--  promedio marzo  --}}
                      <td align="center">
                        @if ($promedioFisDivMar != "")
                        {{number_format((float)$promedioFisDivMar, 1, '.', '')}}
                        {{--  {{$promedioFisDivMar}}  --}}
                      @else
                            
                        @endif
                       
                      </td>
  
                      {{--  promedio general segundo periodo   --}}aquio
                      <td align="center">
                        @if ($promedioDelPromedio2EduFis != "")
                          @if ($promedioDelPromedio2EduFis > 5)
                          <b>{{number_format((float)$promedioDelPromedio2EduFis, 0, '.', '')}}</b>
                              
                          @else
                              <b>5</b>
                          @endif
                        @else
                        
                        @endif
                        
                      </td>
                  
                      <td></td>
  
  
                      {{--  tercer periodo   --}}
                      {{--  promedio abril  --}}
                      <td align="center">
                        @if ($promedioFisDivAbr == "")
                            <b></b>
                        @else
                          {{number_format((float)$promedioFisDivAbr, 1, '.', '')}}
                          {{--  {{$promedioFisDivAbr}}  --}}
                        @endif                      
                      </td>
  
                      {{--  promedio mayo  --}}
                      <td align="center">
                        @if ($promedioFisDivMay == "")
                            <b></b>
                        @else
                        {{number_format((float)$promedioFisDivMay, 1, '.', '')}}
                        {{--  {{$promedioFisDivMay}}  --}}
                        @endif
                        
                      </td>
  
                      {{--  promedio junio  --}}
                      <td align="center">
                        @if ($promedioFisDivJun == "")
                            <b></b>
                        @else
                        {{number_format((float)$promedioFisDivJun, 1, '.', '')}}
                        {{--  {{$promedioFisDivJun}}  --}}
                        @endif                      
                      </td>
  
                      {{--  promedio general tercer periodo   --}}
                      <td align="center">
                        @if ($promedioDelPromedio3EduFis != "")
                          @if ($promedioDelPromedio3EduFis > 5)
                          <b>{{number_format((float)$promedioDelPromedio3EduFis, 0, '.', '')}}</b>
                          @else
                              <b>5</b>
                          @endif
                          
                        @else
                        {{-- <b>{{bcdiv($PromedioDesaPerido3, '1')}}</b> --}}
                        @endif                      
                      </td>
                    
                      {{--  <td></td>  --}}


                      <td align="center" style="border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                        @if ($promedioFinalDelPromedio == "")
                            <b></b>
                        @else
                        <b>{{number_format((float)$promedioFinalDelPromedio, 1, '.', '')}}</b>
                        @endif                      
                      </td>
  
                      {{--  <td></td>  --}}
                      {{--  <td align="center" style="border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                                             
                      </td>  --}}
  
                    </tr> 

                 
              
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
                       @if ($item->matNombreEspecialidad == "AUTONOMIA CURRICULAR (TECNOLOGICAS)")   
                       @if ($posicion3++ == 1)
                       <tr>
                         <td style="width: 193px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><b>AUTONOMIA CURRICULAR (TECNOLÓGICAS)</b></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         {{--  <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>  --}}
                         {{--  <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>  --}}

                       </tr>
                       @endif                  
                       
                       <tr>
                         @php
                        
 
                           $keyMatOptativas++;
                           $promSepOpta = $promSepOpta + $item->inscCalificacionPorcentajeSep;
                           $promOctOpta = $promOctOpta + $item->inscCalificacionPorcentajeOct;
                           $promNovOpta = $promNovOpta + $item->inscCalificacionPorcentajeNov;
                           $PromedioOptaPerido1 = $PromedioOptaPerido1 + $item->inscTrimestre1SEP;
                           $promDicEneOpta = $promDicEneOpta + $item->inscCalificacionPorcentajeEne; 
                           $promFebOpta =  $promFebOpta + $item->inscCalificacionPorcentajeFeb;
                           $promMarOpta = $promMarOpta + $item->inscCalificacionPorcentajeMar;
                           $PromedioOptaPerido2 = $PromedioOptaPerido2 + $item->inscTrimestre2SEP;
                           $promAbrOpta = $promAbrOpta + $item->inscCalificacionPorcentajeAbr; 
                           $promMayOpta = $promMayOpta + $item->inscCalificacionPorcentajeMay;
                           $promJunOpta = $promJunOpta + $item->inscCalificacionPorcentajeJun; 
                           $PromedioOptaPerido3 = $PromedioOptaPerido3 + $item->inscTrimestre3SEP;
                           #$promedioFinalOpta = $promedioFinalOpta + $item->inscPromedioTrimCALCULADOSEP;
                           $promedioFinalOpta = $promedioFinalOpta + $item->inscCalificacionFinalModelo;

 
                           $posicionTecnologia++;
                           $promedioPeriodo1Tecnologia = $promedioPeriodo1Tecnologia + $item->inscTrimestre1SEP;
                           $promedioPeriodo2Tecnologia = $promedioPeriodo2Tecnologia + $item->inscTrimestre2SEP;
                           $promedioPeriodo3Tecnologia = $promedioPeriodo3Tecnologia + $item->inscTrimestre3SEP;
                           #$promedioTecnologiaFinal = $promedioTecnologiaFinal + $item->inscPromedioTrimCALCULADOSEP;
                           $promedioTecnologiaFinal = $promedioTecnologiaFinal + $item->inscCalificacionFinalModelo;

                           
                           
                         @endphp
                        
                         <td style="width: 193px;">
                           @if ($item->gpoMatComplementaria != "")
                           {{$item->matNombreOficial}} ({{$item->gpoMatComplementaria}})
                           @else
                           {{$item->matNombreOficial}}
                           @endif
                          </td>                 
                         
 
                         @if ($item->inscCalificacionPorcentajeSep != "")
                           <td align="center" style="width: 37.4px;">
                             {{$item->inscCalificacionPorcentajeSep}}
                           </td>                        
                         @else
                           <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                         @endif
                   
 
                         @if ($item->inscCalificacionPorcentajeOct != "")
                           <td align="center" style="width: 37.4px;">
                             {{$item->inscCalificacionPorcentajeOct}}
                           </td>
                         @else
                           <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         @if ($item->inscCalificacionPorcentajeNov != "")
                           <td align="center" style="width: 37.4px;">
                             {{$item->inscCalificacionPorcentajeNov}}
                           </td>
                         @else
                           <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         {{--  promedio trimestree 1  --}}
                         {{--  <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>  --}}
                         <td align="center" style="width: 37.4px;">
                           @if ($item->inscTrimestre1SEP != "")
                            @if ($item->inscTrimestre1SEP <= 5)
                              <b>5</b>
                            @else
                              <b>{{$item->inscTrimestre1SEP}}</b>
                            @endif    
                           @else
                               
                           @endif                                                  
                          </td>
 

                          {{--  recu1 curri   --}}                      
                       
                          <td align="center" style="width: 38.8px;">
                            @if ($item->inscRecuperativoTrimestre1 != "")
                              @if (is_numeric($item->inscRecuperativoTrimestre1))
                                <b>{{number_format((float)$item->inscRecuperativoTrimestre1, 0, '.', '')}}</b>
                              @else
                                <b>{{$item->inscRecuperativoTrimestre1}}</b>
                              @endif                              
                            @endif   
                          </td>

                   
                         @if ($item->inscCalificacionPorcentajeEne != "")
                         <td align="center" style="width: 37.1px;">
                           {{$item->inscCalificacionPorcentajeEne}}
                         </td>
                         @else
                         <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         @if ($item->inscCalificacionPorcentajeFeb != "")
                         <td align="center" style="width: 37px;">
                           {{$item->inscCalificacionPorcentajeFeb}}
                         </td>
                         @else
                         <td align="center" style="width: 37px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         @if ($item->inscCalificacionPorcentajeMar != "")
                         <td align="center" style="width: 37.4px;">
                           {{$item->inscCalificacionPorcentajeMar}}
                         </td>
                         @else
                         <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         {{--  promedio trimestre 2   --}}
                         {{--  <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>  --}}
                        <td align="center" style="width: 37.8px;">
                          @if ($item->inscTrimestre2SEP != "")
                            @if ($item->inscTrimestre2SEP <= 5)
                              <b>5</b>
                            @else
                              <b>{{$item->inscTrimestre2SEP}}</b>
                            @endif 
                          @else
                              
                          @endif                         
                        </td>
                     
                        {{--  recu2 curri   --}}
                        <td align="center" style="width: 38.8px;">
                          @if ($item->inscRecuperativoTrimestre2 != "")
                            @if (is_numeric($item->inscRecuperativoTrimestre2))
                              <b>{{number_format((float)$item->inscRecuperativoTrimestre2, 0, '.', '')}}</b>
                            @else
                              <b>{{$item->inscRecuperativoTrimestre2}}</b>
                            @endif                              
                          @endif   
                        </td>

                         @if ($item->inscCalificacionPorcentajeAbr != "")
                         <td align="center" style="width: 37.1px;">{{$item->inscCalificacionPorcentajeAbr}}</td>
                         @else
                         <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                         @endif
 
                         @if ($item->inscCalificacionPorcentajeMay != "")
                         <td align="center" style="width: 37.1px;">{{$item->inscCalificacionPorcentajeMay}}</td>
                         @else
                         <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
 
                         @if ($item->inscCalificacionPorcentajeJun != "")
                         <td align="center" style="width: 37.1px;">{{$item->inscCalificacionPorcentajeJun}}</td>
                         @else
                         <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         {{--  promedio trimestre 3   --}}
                         {{--  <td align="center" style="width: 54px; border-top: 1px solid; border-right: 0px; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>  --}}
                         <td align="center" style="width: 38px;">
                           @if ($item->inscTrimestre3SEP != "")
                            @if ($item->inscTrimestre3SEP <= 5)
                              <b>5</b>
                            @else
                              <b>{{$item->inscTrimestre3SEP}}</b>
                            @endif 
                           @else
                               
                           @endif
                          
                        </td>              
                        

                        {{--  <td align="center" style="width: 39px;">
                          @if ($item->inscRecuperativoTrimestre3 != "")
                            @if (is_numeric($item->inscRecuperativoTrimestre3))
                              <b>{{number_format((float)$item->inscRecuperativoTrimestre3, 0, '.', '')}}</b>
                            @else
                              <b>{{$item->inscRecuperativoTrimestre3}}</b>
                            @endif                              
                          @endif   
                        </td>  --}}

                        <td align="center" style="width: 42.4px;"><b>{{$item->inscCalificacionFinalModelo}}</b></td>
                         {{--  <td align="center" style="width: 42.4px;"><label style="opacity: .01;">0</label></td>  --}}

                         {{--  <td align="center" style="width: 57px;"><label style="opacity: .01;">0</label></td>  --}}

 
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

                  #para periodo 1
                  $promedioGeneralFinalPer1 = number_format((float)$PromForAcademiPeriodo1, 0, '.', '') + number_format((float)$promedioPeriodo1Artes, 0, '.', '') + 
                  number_format((float)$promedioPeriodo1Tutorias, 0, '.', '') + number_format((float)$promedioDelPromedio1EduFis, 0, '.', '') + number_format((float)$promedioPeriodo1Tecnologia, 0, '.', '');
                  ##$totalEnDividir = $posicionFA + $posicion3Fisi + $posicion3ArtTut + $posicionTec;
                  $totalEnDividir = $posicionPromedioGenParte1Periodo1 + $poscicionDesarrolloSocialPersonal + $poscicionDesarrolloSocialPersonal2 + $posicionFisica + $posicionTecnologia;

                  $resultadoPeriodo1 = $promedioGeneralFinalPer1 / $totalEnDividir;

                  #para periodo 2
                  $promedioGeneralFinalPer2 = number_format((float)$PromForAcademiPeriodo2, 0, '.', '') + number_format((float)$promedioPeriodo2Artes, 0, '.', '') + 
                  number_format((float)$promedioPeriodo2Tutorias, 0, '.', '') + number_format((float)$promedioDelPromedio2EduFis, 0, '.', '') + number_format((float)$promedioPeriodo2Tecnologia, 0, '.', '');

                  $resultadoPeriodo2 = $promedioGeneralFinalPer2 / $totalEnDividir;

                  #para periodo 3
                  $promedioGeneralFinalPer3 = number_format((float)$PromForAcademiPeriodo3, 0, '.', '') + number_format((float)$promedioPeriodo3Artes, 0, '.', '') + 
                  number_format((float)$promedioPeriodo3Tutorias, 0, '.', '') + number_format((float)$promedioDelPromedio3EduFis, 0, '.', '') + number_format((float)$promedioPeriodo3Tecnologia, 0, '.', '');

                  $resultadoPeriodo3 = $promedioGeneralFinalPer3 / $totalEnDividir;


                  $promedioGeneralFinalTrimestre = $promedioGeneralTrimestreFA + $promedioGenralTrimestreArtes + $promedioGenralTrimestreTutorias + $promedioFinalEducacionFisSep + $promedioTecnologiaFinal;
                  $resultadoTrimestreFin = $promedioGeneralFinalTrimestre; 

                   @endphp

                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)
                     @php
                         $keyPromedioGeneral++;
                     @endphp
                     @if ($keyPromedioGeneral == 1)
                     {{--  aqui promedio general  --}}
                      <tr>                      
                        <td style="width: 193px;"><b>PROMEDIO GENERAL</b></td>                 
                        

                        <td align="center" style="width: 38.8px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>                  

                        <td align="center" style="width: 38.8px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>                        
                  
                        <td align="center" style="width: 38.8px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        
                  
                        {{--  promedio trimestree 1  --}}
                        @if ($resultadoPeriodo1 != "")
                        <td align="center" style="width: 37.4px;">
                          @if ($resultadoPeriodo1 < 6)
                          <b>5</b>
                          @else
                          <b>{{number_format((float)$resultadoPeriodo1, 0, '.', '')}}</b>
                          @endif                          
                        </td>
                        @else
                        <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  recu1 prome gen   --}}
                        <td align="center" style="width: 38.8px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                      

                  
                        <td align="center" style="width: 37.1px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        
                        <td align="center" style="width: 40px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        
                  
                        {{--  promedio trimestre 2   --}}
                        @if ($resultadoPeriodo2 != "")
                        <td align="center" style="width: 37.8px;">
                          @if ($resultadoPeriodo2 < 6)
                          <b>5</b>
                          @else
                          <b>{{number_format((float)$resultadoPeriodo2, 0, '.', '')}}</b>
                          @endif                          
                        </td>
                        @else
                        <td align="center" style="width: 37.8px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        {{--  recu2 prome gen   --}}
                        <td align="center" style="width: 38.8px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        <td align="center" style="width: 39px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        <td align="center" style="width: 39px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        <td align="center" style="width: 37px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        
                  
                        {{--  promedio trimestre 3   --}}
                        @if ($resultadoPeriodo3 != "")
                        <td align="center" style="width: 38px;">
                          @if ($resultadoPeriodo3 < 6)
                          <b>5</b>
                          @else
                          <b>{{number_format((float)$resultadoPeriodo3, 0, '.', '')}}</b>
                          @endif                          
                        </td>
                        @else
                        <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td>
                        @endif
                                               
                        {{--  <td align="center" style="width: 39px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>  --}}

                  
                        <td align="center" style="width: 44px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        
                        {{--  <td align="center" style="width: 57px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>  --}}
                      </tr>                    
                     @endif
                    @endif
                  @endforeach
              
                </tbody>
              </table>

              {{--  INASISTENCIAS  --}}
              @foreach($calificaciones as $key => $inasistencia)
                    @if ($inasistencia->clave_pago == $clave_pago)
                      @php
                          $Keynasistencias++;

                          if($inasistencia->matNombre != "EDUCACION FISICA VESP"){
                            $faltasSep = $faltasSep + $inasistencia->inscFaltasInjSep;
                            $faltasOct = $faltasOct + $inasistencia->inscFaltasInjOct;
                            $faltasNov = $faltasNov + $inasistencia->inscFaltasInjNov;
                            $faltasEne = $faltasEne + $inasistencia->inscFaltasInjEne;
                            $faltasFeb = $faltasFeb + $inasistencia->inscFaltasInjFeb;
                            $faltasMar = $faltasMar + $inasistencia->inscFaltasInjMar;
                            $faltasAbr = $faltasAbr + $inasistencia->inscFaltasInjAbr;
                            $faltasMay = $faltasMay + $inasistencia->inscFaltasInjMay;
                            $faltasJun = $faltasJun + $inasistencia->inscFaltasInjJun;
                          }
                          

                      @endphp                      
                    @endif
              @endforeach

              <br>
              <table class="table table-bordered">
                <thead>
                
                </thead>
                <tbody>
                  <tr>                      
                    <td style="width: 193px;"><b>INASISTENCIAS INJUSTIFICADAS</b></td>
                      

                      @if ($faltasSep != "")
                        <td align="center" style="width: 37.4px;">
                          {{$faltasSep}}
                        </td>                        
                      @else
                        <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                      @endif
                

                      @if ($faltasOct != "")
                        <td align="center" style="width: 37.4px;">
                          {{$faltasOct}}
                        </td>
                      @else
                        <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      @if ($faltasNov != "")
                        <td align="center" style="width: 37.4px;">
                          {{$faltasNov}}
                        </td>
                      @else
                        <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      {{--  promedio trimestree 1  --}}
                      <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>

                      <td align="center" style="width: 38.8px;"><label style="opacity: .01;">0</label></td>

                    
                
                      @if ($faltasEne != "")
                      <td align="center" style="width: 37.1px;">
                        {{$faltasEne}}
                      </td>
                      @else
                      <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      @if ($faltasFeb != "")
                      <td align="center" style="width: 37px;">
                        {{$faltasFeb}}
                      </td>
                      @else
                      <td align="center" style="width: 37px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      @if ($faltasMar != "")
                      <td align="center" style="width: 37.4px;">
                        {{$faltasMar}}
                      </td>
                      @else
                      <td align="center" style="width: 37.4px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      {{--  promedio trimestre 2   --}}                        
                      <td align="center" style="width: 37.8px;"><label style="opacity: .01;">0</label></td>

                  
                      <td align="center" style="width: 38.8px;"><label style="opacity: .01;">0</label></td>

                      @if ($faltasAbr != "")
                      <td align="center" style="width: 37.1px;">{{$faltasAbr}}</td>
                      @else
                      <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                      @endif

                      @if ($faltasMay != "")
                      <td align="center" style="width: 37.1px;">{{$faltasMay}}</td>
                      @else
                      <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      

                      @if ($faltasJun != "")
                      <td align="center" style="width: 37.1px;">{{$faltasJun}}</td>
                      @else
                      <td align="center" style="width: 37.1px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      {{--  promedio trimestre 3   --}}                       
                      <td align="center" style="width: 38px;"><label style="opacity: .01;">0</label></td>
                      
                      {{--  <td align="center" style="width: 39px;"><label style="opacity: .01;">0</label></td>  --}}

                      <td align="center" style="width: 42.4px;"><label style="opacity: .01;">0</label></td>

                      {{--  <td align="center" style="width: 57px;"><label style="opacity: .01;">0</label></td>  --}}


                  </tr>                
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
        $keyMatOptativas = 0.0;
  
        #Varibles indispensables para la categoria formación academica
        $keyPromedioGeneralFormacionAcademica = 0;
        $promedioGenFormacionAcadeSep = 0.0;
        $promedioGenFormacionAcadeOct = 0.0;
        $promedioGenFormacionAcadeNov = 0.0;
        $promedioGenFormacionAcadePeriodo1 = 0.0;
        $promedioGenFormacionAcadeEne = 0.0;
        $promedioGenFormacionAcadeFeb = 0.0;
        $promedioGenFormacionAcadeMar = 0.0;
        $promedioGenFormacionAcadePeriodo2 = 0.0;
        $promedioGenFormacionAcadeAbr = 0.0;
        $promedioGenFormacionAcadeMay = 0.0;
        $promedioGenFormacionAcadeJun = 0.0;
        $promedioGenFormacionAcadePeriodo3 = 0.0;

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
        $PromedioDesaPerido1 = 0.0;
        $PromedioGen1SEPDESA = 0.0;
        $promDICENEDESA = 0.0;
        $promFEBDESA = 0.0;
        $promMARDESA = 0.0;
        $PromedioDesaPerido2 = 0.0;
        $PromedioGen2SEPDESA = 0.0;
        $promABRDESA = 0.0;
        $promMAYDESA = 0.0;
        $promJUNDESA = 0.0;
        $PromedioDesaPerido3 = 0.0;
        $PromedioGen3SEPDESA = 0.0;
        $promedioFinalDESA = 0.0;
        $promedioFinalSEPDESA = 0.0;

       



        $posicion1 = 1;
        $posicion2 = 1;
        $posicion9 = 1;
        $posicion10 = 1;
        $posicion3 = 1;
        $posicionFA = 0;
        $posicion3Fisi = 0;
        $posicion3ArtTut = 0;
        $posicionTec = 0;


        $promSepOpta = 0.0;
        $promOctOpta = 0.0;
        $promNovOpta = 0.0;
        $PromedioOptaPerido1 = 0.0;
        $promDicEneOpta = 0.0;
        $promFebOpta = 0.0;
        $promMarOpta = 0.0;
        $PromedioOptaPerido2 = 0.0;
        $promAbrOpta = 0.0;
        $promMayOpta = 0.0;
        $promJunOpta = 0.0;
        $PromedioOptaPerido3 = 0.0;
        $promedioFinalOpta = 0.0;

        $promedioGeneralPer1FA = 0;
        $promedioGenralPer1ArTu = 0;
        $promedioGeneralFinalPer1 = 0;
        $totalEnDividir = 0;
        $resultadoPeriodo1 = 0;


        $promedioGeneralPer2FA = 0;
        $promedioGenralPer2ArTu = 0;
        $promedioGeneralFinalPer2 = 0;
        $resultadoPeriodo2 = 0;

        $promedioGeneralPer3FA = 0;
        $promedioGenralPer3ArTu = 0;
        $promedioGeneralFinalPer3 = 0;
        $resultadoPeriodo3 = 0;


        $promedioGeneralTrimestreFA = 0.0;
        $promedioGenralTrimestreArTu = 0.0;
        $promedioGeneralFinalTrimestre = 0.0;
        $resultadoTrimestreFin = 0.0;

        $promedioGeneralTrimestreFASEP = 0.0;

        $faltasSep = 0;
        $faltasOct = 0;
        $faltasNov = 0;
        $faltasEne = 0;
        $faltasFeb = 0;
        $faltasMar = 0;
        $faltasAbr = 0;
        $faltasMay = 0;
        $faltasJun = 0;

        $promedioDelPromedio1EduFis = 0.0;
        $promedioDelPromedio2EduFis = 0.0;
        $promedioDelPromedio3EduFis = 0.0;
        $promedioFinalEducacionFisSep = 0.0;

        $promedioFinalDelPromedio = 0.0;

        $promedioFisDivSep = 0.0;
        $promedioFisDivOct = 0.0;
        $promedioFisDivNov = 0.0;
        $promedioFisDivPeri1 = 0.0;
        $promedioFisDivEne = 0.0;
        $promedioFisDivFeb = 0.0;
        $promedioFisDivMar = 0.0;
        $promedioFisDivPeri2 = 0.0;
        $promedioFisDivAbr = 0.0;
        $promedioFisDivMay = 0.0;
        $promedioFisDivJun = 0.0;
        $promedioFisDivPeri3 = 0.0;
        $promedioFisDivFinal = 0.0;

        $porSep = 0.0;
        $porOct = 0.0;
        $porNov  = 0.0;

        $poscicionDesarrolloSocialPersonal = 0;
        $poscicionDesarrolloSocialPersonal2 = 0;
        $posicionPromedioGenParte1Periodo1 = 0.0;
        $posicionFisica = 0;
        $posicionTecnologia = 0;

        $promedioPeriodo1Tecnologia = 0.0;
        $promedioPeriodo2Tecnologia = 0.0;
        $promedioPeriodo3Tecnologia = 0.0;
        $promedioTecnologiaFinal = 0.0;

        $promedioPeriodo1Artes = 0.0;
        $promedioPeriodo2Artes = 0.0;
        $promedioPeriodo3Artes = 0.0;
        $promedioGenralTrimestreArtes = 0.0;
        

        $promedioPeriodo1Tutorias = 0.0;
        $promedioPeriodo2Tutorias = 0.0;
        $promedioPeriodo3Tutorias = 0.0;
        $promedioGenralTrimestreTutorias = 0.0;
    @endphp
@endforeach



  </body>
</html>