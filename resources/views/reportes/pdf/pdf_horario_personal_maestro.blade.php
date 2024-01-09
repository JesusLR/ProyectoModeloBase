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
        height: 240px;
        /** Extra personal styles **/
        color: #000;
        text-align: center;
      }
      header {
        left: 0px;
        position: fixed;
        top: -90px;
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
        margin-top: 70px;
        margin-bottom: 0px;
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

      .table th, .table td {
        border: 1px solid #000;
      }

      .table td, .table  th {
        padding-top: 0px;
        padding-bottom: 0px;
      }

      .page-number:before {
        content: "Pág " counter(page);
      }
    </style>
	</head>
  <body>
    {{-- Controlador: HorarioPersonalMaestrosController.php --}}
    <header>
      <div class="row" style=" margin-top: 30px;">
        <div class="columns medium-12">
          <img class="img-header" style="float:left;" src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">
          <h2 style="margin-top:0px; margin-bottom: 10px; text-align: center; margin-bottom: 40px;">UNIVERSIDAD MODELO</h2>
          <h2 style="margin-top:0px; margin-bottom: 10px; text-align: center;">HORARIO PERSONAL</h2>

        </div>
      </div>
    </header>
    <br><br>


    @foreach ($datos as $empleado)
      @php
        $horarios_empleado = $empleado['horarios_empleado'];
        $materias_empleado = $empleado['materias_empleado'];
      @endphp
      <div class="row">
        <div class="columns medium-12">
          <table class="table">
            <tr>
              <td style="width: 500px; font-weight: 700;">
                NOMBRE: {{$empleado['nombreCompleto']}}
              </td>
              <td style="font-weight: 700;">NUM. CONTROL</td>
            </tr>
            <tr>
              <td  style="width: 500px; font-weight: 700;">
                <p>ESCUELA: {{$escuela->escNombre}}</p>
              </td>
              <td style="font-weight: 700;">{{sprintf('%04d', $empleado['empleado_id'])}}</td>
            </tr>

            <tr>
              <td style="width: 500px; font-weight: 700;">
                <p>
                  PERIODO: {{$perFechaInicial}} - {{$perFechaFinal}}
                </p>
              </td>
              <td style="font-weight: 700;">
                DOC: {{$empleado['totalHorasDocentes']}}
                ADM: {{$empleado['totalHorasAdministrativas']}}
                TOT: {{$empleado['totalHoras']}}
              </td>
            </tr>
          </table>
        </div>
      </div>


      <br><br>
      <div class="row">
        <div class="columns medium-12">
          <h3 style="text-align:center; margin-bottom: 0px;"><b>MATUTINO</b></h3>


          <table class="table">
            <tr>
              <th align="center" style="width: 15px; font-size: 10px;">HORA</th>
              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px;"> <div style="width: 100%;"> LUNES</div></th>
              <th align="center" style="width: 20px; border-left: 0px;"></th>

              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px;">MARTES</th>
              <th align="center" style="width: 20px; border-left: 0px;"></th>

              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px;">
                <div style="width: 50px; left: 43px; position: relative;">MIERCOLES</div>
              </th>
              <th align="center" style="width: 20px; border-left: 0px;"></th>

              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px;">JUEVES</th>
              <th align="center" style="width: 20px; border-left: 0px;"></th>

              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px;">VIERNES</th>
              <th align="center" style="width: 20px; border-left: 0px;"></th>

              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px; ">SÁBADO</th>
              <th align="center" style="width: 20px; border-left: 0px;"></th>

            </tr>

            <tr>
              <td align="center" style="width: 15px;"></td>
              @php
                $l = 1;
              @endphp
              @while ($l <= 6)
                <td style="width: 20px; padding-right: 0px; padding-left: 0px; text-align:center;">
                  clave
                </td>
                <td style="width: 30px; padding-right: 0px; padding-left: 0px; text-align:center;">
                  aula
                </td>
                @php
                  $l++;
                @endphp
              @endwhile
            </tr>

            @php
            $i = 1;
            @endphp
            <!-- HORAS LABORES -->
            @while ($i <= 8)
            <tr>
              <td align="center" style="width: 15px;">
                @php
                  $hrInicio = 0;
                  $hrFinal = 0;
                  $hrInicioFinal = "";
                  $width = 20;
                  if ($i == 1) {
                    $hrInicio = 7; $hrFinal = 8;
                    $hrInicioFinal = "07-08";
                  }
                  if ($i == 2) {
                    $hrInicio = 8; $hrFinal = 9;
                    $hrInicioFinal = "08-09";
                  }
                  if ($i == 3) {
                    $hrInicio = 9; $hrFinal = 10;
                    $hrInicioFinal = "09-10";
                    $width = 60;
                  }
                  if ($i == 4) {
                    $hrInicio = 10; $hrFinal = 11;
                    $hrInicioFinal = "10-11";
                  }
                  if ($i == 5) {
                    $hrInicio = 11; $hrFinal = 12;
                    $hrInicioFinal = "11-12";
                  }
                  if ($i == 6) {
                    $hrInicio = 12; $hrFinal = 13;
                    $hrInicioFinal = "12-13";
                  }
                  if ($i == 7) {
                    $hrInicio = 13; $hrFinal = 14;
                    $hrInicioFinal = "13-14";
                  }
                  if ($i == 8) {
                    $hrInicio = 14; $hrFinal = 15;
                    $hrInicioFinal = "14-15";
                  }
                @endphp
                {{$hrInicioFinal}}
              </td>

              <!-- DIAS (LUNES A SABADO) -->
              @php
                $dia = 1;
              @endphp
              @while ($dia <= 6)
                @php
                  $horarios_dia_hora = $horarios_empleado->where('dia', $dia)
                  ->where('hrInicio', '<=', $hrInicio)
                  ->where('hrFinal', '>=', $hrFinal);
                  $horarioAdmivo = $horarios_dia_hora->firstWhere('tipoHorario', 'ADM');
                  $horariosDocente = $horarios_dia_hora->where('tipoHorario', 'DOC');
                  // $horarioDocente1 = $horariosDocente->first();
                @endphp

                  <td align="center" style="width: {{$width}}px; padding-right: 0px; padding-left: 0px; position: relative;">
                    <div>
                      {!!$horarioAdmivo ? "ADMIN": ""!!}
                      @if ($horariosDocente->isNotEmpty())
                        @foreach($horariosDocente as $horarioDocente)
                          {{$horarioDocente['matClave']}}<br>
                        @endforeach
                      @endif
                    </div>
                  </td>

                <td align="center" style="width: 35px; padding-right: 0px; padding-left: 0px; position: relative;">
                  {{-- {{$horarioDocente1 ? $horarioDocente1['aulaClave']: " "}} --}}
                  @foreach($horariosDocente as $horarioDocente)
                    {{$horarioDocente['aulaClave']}}<br>
                  @endforeach
                </td>
              @php
                $dia++;
              @endphp
              @endwhile
            </tr>
            @php
              $i++;
            @endphp
            @endwhile
          </table>
        </div>
      </div>


      <br><br>
      <div class="row">
        <div class="columns medium-12">
          <h3 style="text-align:center; margin-bottom: 0px;"><b>VESPERTINO</b></h3>


          <table class="table">
            <tr>
              <th align="center" style="width: 15px; font-size: 10px;">HORA</th>
              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px;"> <div style="width: 100%;"> LUNES</div></th>
              <th align="center" style="width: 20px; border-left: 0px; "></th>

              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px;">MARTES</th>
              <th align="center" style="width: 20px; border-left: 0px; "></th>

              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px;">
                <div style="width: 50px; left: 43px; position: relative;">MIERCOLES</div>
              </th>
              <th align="center" style="width: 20px; border-left: 0px; "></th>

              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px;">JUEVES</th>
              <th align="center" style="width: 20px; border-left: 0px; "></th>

              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px;">VIERNES</th>
              <th align="center" style="width: 20px; border-left: 0px; "></th>

              <th align="right" style="width: 20px; border-right: 0px; font-size: 10px; ">SÁBADO</th>
              <th align="center" style="width: 20px; border-left: 0px;  "></th>

            </tr>

            <tr>
              <td align="center" style="width: 15px;"></td>
              @php
                $l = 1;
              @endphp
              @while ($l <= 6)
                <td style="width: 20px; padding-right: 0px; padding-left: 0px; text-align:center;">
                  clave
                </td>
                <td style="width: 30px; padding-right: 0px; padding-left: 0px; text-align:center;">
                  aula
                </td>
                @php
                  $l++;
                @endphp
              @endwhile
            </tr>

            @php
            $i = 1;
            @endphp
            <!-- HORAS LABORES -->
            @while ($i <= 7)
            <tr>
              <td align="center" style="width: 15px;">
                @php
                  $hrInicio = 0;
                  $hrFinal = 0;
                  $hrInicioFinal = "";
                  $width = 20;
                  if ($i == 1) {
                    $hrInicio = 15; $hrFinal = 16;
                    $hrInicioFinal = "15-16";
                  }
                  if ($i == 2) {
                    $hrInicio = 16; $hrFinal = 17;
                    $hrInicioFinal = "16-17";
                  }
                  if ($i == 3) {
                    $hrInicio = 17; $hrFinal = 18;
                    $hrInicioFinal = "17-18";
                    $width = 60;
                  }
                  if ($i == 4) {
                    $hrInicio = 18; $hrFinal = 19;
                    $hrInicioFinal = "18-19";
                  }
                  if ($i == 5) {
                    $hrInicio = 19; $hrFinal = 20;
                    $hrInicioFinal = "19-20";
                  }
                  if ($i == 6) {
                    $hrInicio = 20; $hrFinal = 21;
                    $hrInicioFinal = "20-21";
                  }
                  if ($i == 7) {
                    $hrInicio = 21; $hrFinal = 22;
                    $hrInicioFinal = "21-22";

                  }
                @endphp
                {{$hrInicioFinal}}
              </td>

              <!-- DIAS (LUNES A SABADO) -->
              @php
                $dia = 1;
              @endphp
              @while ($dia <= 6)
                @php
                  $horarios_dia_hora = $horarios_empleado->where('dia', $dia)
                  ->where('hrInicio', '<=', $hrInicio)
                  ->where('hrFinal', '>=', $hrFinal);
                  $horarioAdmivo = $horarios_dia_hora->firstWhere('tipoHorario', 'ADM');
                  $horariosDocente = $horarios_dia_hora->where('tipoHorario', 'DOC');
                  $horarioDocente1 = $horariosDocente->first();
                @endphp

                  <td align="center" style="width: {{$width}}px; padding-right: 0px; padding-left: 0px; position: relative;">
                    <div>
                      {!!$horarioAdmivo ? "ADMIN": ""!!}
                      @if ($horariosDocente->isNotEmpty())
                        @foreach($horariosDocente as $horarioDocente)
                          {{$horarioDocente['matClave']}}
                        @endforeach
                      @endif
                    </div>
                  </td>

                <td align="center" style="width: 35px; padding-right: 0px; padding-left: 0px; position: relative;">
                  {{$horarioDocente1 ? $horarioDocente1['aulaClave'] : " "}}
                </td>
              @php
                $dia++;
              @endphp
              @endwhile
            </tr>
            @php
              $i++;
            @endphp
            @endwhile
          </table>
        </div>
      </div>



      <br><br>
      <div class="row">
        <div class="columns medium-12">
          <table class="table">
            <tr>
              <th align="center" style="width: 10px; font-size: 10px;">CLAVE</th>
              <th align="center" style="width: 300px; font-size: 10px;">DESCRIPCIÓN</th>
              <th align="center" style="width: 15px; font-size: 10px;">CARRERA</th>
              <th align="center" style="width: 15px; font-size: 10px;">ORDINARIO</th>
            </tr>

            @foreach($materias_empleado as $materia)
              <tr>
                <td align="center" style="width: 10px;">
                    {{$materia['matClave']}}
                </td>
                <td style="width: 300px;">
                  {{-- Si tiene optativa, se agregará el nombre --}}
                  {{$materia['matNombre']}} {{$materia['optNombre']}}
                </td>
                <td align="center" style="width: 15px;">
                    {{$materia['progClave']}}
                </td>
                <td align="center" style="width: 15px;">
                  {{$materia['fechaOrdinario']}}
                </td>
              </tr>
            @endforeach {{-- foreach materia --}}

          </table>
        </div>
      </div>


      <div class="row" style="margin-top: 30px;">
          <div class="columns medium-12">
            <div style="text-align: center;">
              <p style="font-weight: 700; font-size: 18px; margin-bottom: 20px;">Autorizó</p>
              <img style="height: 120px;"  src="{{base_path('resources/assets/img/firma-silvia.jpeg')}}" alt="" />
              <p style="font-weight: 700; font-size: 18px;">M.G.E. SILVIA CANDELARIA BARAHONA RAMÍREZ</p>
              <p style="font-weight: 700; font-size: 18px;">Secretaria administrativa</p>
            </div>
          </div>
        </div>

        <div class="row" style="margin-top: -150px; margin-right: 20px;">
          <div class="columns medium-12">
            <div style="margin: 0 auto;">
              <div style="text-align: right; margin-top: -70px;">
                @if ($ubicacion->ubiClave == "CME")
                  <img style="width: 150px;" src="{{base_path('resources/assets/img/merida.jpeg')}}" alt="" />
                @endif

                @if ($ubicacion->ubiClave == "CVA")
                  <!-- <img style="width: 150px;" src="{{base_path('resources/assets/img/valladolid.jpg')}}" alt="" /> -->
                @endif
              </div>
            </div>
          </div>
        </div>

      @if (!$loop->last)
        <div class="page_break"></div>
      @endif
    @endforeach {{-- foreach empleado --}}


    <footer id="footer">

    </footer>
  </body>
</html>
