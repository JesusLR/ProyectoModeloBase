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
        font-size: 11px;
        margin-top: 80px;
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
        /** Extra personal styles **/
        color: #000;
        text-align: center;
      }
      header {
        left: 0px;
        position: fixed;
        top: -30px;
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
      use App\Http\Models\Empleado;
      use App\Http\Models\HorarioAdmivo;
      use App\Http\Models\Horario;
    @endphp

    <header>
      <div class="row">
        <div class="columns medium-6">
          <h5 style="margin-top:0px; margin-bottom: 10px;">UNIVERSIDAD MODELO</h5>
          <h5 style="margin-top:0px; margin-bottom: 10px;">HORARIOS ADMINISTRATIVOS</h5>
        </div>
        <div class="columns medium-6">
          <div style="text-align: right;">
            <p>{{ $fechaActual }}</p>
            <p>{{ $horaActual}}</p>
            <p>horarios_administrativos.pdf</p>
          </div>
        </div>
      </div>

      <div class="row" style="margin-bottom: 2px;">
        <div class="columns medium-12">
          <p>
              Período : {{ $ciclo_escolar }}
          </p>
        </div>
      </div>

      <div class="row" style="margin-bottom: 2px">
        <div class="columns medium-12">
          <p>Departamento : {{ $depar }} </p>
        </div>
      </div>

      <div class="row">
        <div class="columns medium-12">
          <p>Ubicación : {{ $ubic }} </p>
        </div>
      </div>

    </header>

    <footer id="footer">
      <div class="page-number"></div>
    </footer>

    @php
      $contador = 1;
    @endphp
    <div class="row">
      <div class="columns medium-12">
        @foreach ($horarios_admin as $item)
        @php
          $empleado = Empleado::select('personas.*', 'escuelas.escClave', 'empleados.empEstado')
          ->join('personas', 'empleados.persona_id', '=', 'personas.id')
          ->join('escuelas', 'empleados.escuela_id', '=', 'escuelas.id')
          ->where('empleados.id', $item->empleado_id)
          ->first();

          $horarios = HorarioAdmivo::select(
            'horariosadmivos.id',
            'horariosadmivos.hadmDia',
            'horariosadmivos.hadmHoraInicio',
            'horariosadmivos.gMinInicio',
            'horariosadmivos.hadmFinal',
            'horariosadmivos.gMinFinal'
          )
          ->join('periodos', 'horariosadmivos.periodo_id', '=', 'periodos.id')
          ->join('empleados', 'horariosadmivos.empleado_id', '=', 'empleados.id')
          ->join('personas', 'empleados.persona_id', '=', 'personas.id')
          ->join('departamentos', 'periodos.departamento_id', '=', 'departamentos.id')
          ->where('periodos.id', $periodo_id)
          ->where('empleados.id', $item->empleado_id)
          ->whereNull('horariosadmivos.deleted_at')
          ->whereNull('periodos.deleted_at')
          ->whereNull('empleados.deleted_at')
          ->whereNull('departamentos.deleted_at')
          ->orderBy('horariosadmivos.hadmDia', 'ASC')
          ->orderBy('horariosadmivos.hadmHoraInicio', 'ASC')
          ->orderBy('horariosadmivos.gMinInicio', 'ASC')
          ->orderBy('horariosadmivos.hadmFinal', 'ASC')
          ->orderBy('horariosadmivos.gMinFinal', 'ASC')
          ->get();

          $horario_grupos = Horario::select(
            'horarios.id',
            'horarios.ghDia as dia',
            'horarios.ghInicio as hora_inicio',
            'horarios.gMinInicio as minuto_inicio',
            'horarios.ghFinal as hora_fin',
            'horarios.gMinFinal as minuto_final',
            'grupos.empleado_id',
            'materias.matClave',
            'materias.matNombre',
            'optativas.optNombre',
            'aulas.aulaClave',
            'aulas.aulaDescripcion',
            'aulas.aulaUbicacion',
            'aulas.aulaEdificio',
            'grupos.id as grupo_id',
            'grupos.gpoClave',
            'grupos.gpoSemestre'
          )
          ->join('grupos', 'horarios.grupo_id', '=', 'grupos.id')
          ->join('materias', 'grupos.materia_id', '=', 'materias.id')
          ->leftJoin('optativas', 'grupos.optativa_id', '=', 'optativas.id')
          ->leftJoin('aulas', 'horarios.aula_id', '=', 'aulas.id')
          ->where('grupos.periodo_id', $periodo_id)
          ->where('grupos.empleado_id', $item->empleado_id)
          ->whereNull('horarios.deleted_at')
          ->whereNull('grupos.deleted_at')
          ->whereNull('materias.deleted_at')
          ->whereNull('aulas.deleted_at')
          ->whereNull('grupos.grupo_equivalente_id')
          ->orderBy('grupos.gpoSemestre', 'ASC')
          ->orderBy('grupos.gpoClave', 'ASC')
          ->orderBy('materias.matClave', 'ASC')
          ->orderBy('horarios.ghDia', 'ASC')
          ->orderBy('horarios.ghInicio', 'ASC')
          ->orderBy('horarios.gMinInicio', 'ASC')
          ->orderBy('horarios.ghFinal', 'ASC')
          ->orderBy('horarios.gMinFinal', 'ASC')
          ->get();



        @endphp

        <p style="font-size: 13px;"><b>{{ $item->empleado_id }}-{{ $empleado->perApellido1.' '.$empleado->perApellido2.' '.$empleado->perNombre }} - Escuela: {{ $empleado->escClave }} @if($empleado->empEstado == "B") - (Baja) @endif</b></p>
        <br>
        <table class="table">



          {{--  <caption><b>{{ $empleado->perApellido1.' '.$empleado->perApellido2.' '.$empleado->perNombre }}</b></caption>  --}}

          <col style="width:10%;" />
          <col style="width:30%;" />

          <thead>
            <tr>
              <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Lun</th>
              <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Mar</th>
              <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Mier</th>
              <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Jue</th>
              <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Vie</th>
              <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Sab</th>
            </tr>
          </thead>


          <tbody>
            <tr>

              {{--  lunes   --}}
              <td align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                @foreach ($horarios as $horario)
                  @if ($horario->hadmDia == 1)
                    @if ($horario->hadmHoraInicio < 10)
                      @php
                        $hadmHoraInicioL = '0'.$horario->hadmHoraInicio;
                      @endphp
                    @else
                      @php
                        $hadmHoraInicioL = $horario->hadmHoraInicio;
                      @endphp
                    @endif


                    @if ($horario->hadmFinal < 10)
                      @php
                        $hadmFinalL = '0'.$horario->hadmFinal;
                      @endphp
                    @else
                      @php
                        $hadmFinalL = $horario->hadmFinal;
                      @endphp
                    @endif

                    {{ $hadmHoraInicioL.':'.$horario->gMinInicio }} a {{ $hadmFinalL.':'.$horario->gMinFinal }}
                    <br>
                  @endif
                @endforeach
              </td>

              {{--  martes   --}}
              <td align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                @foreach ($horarios as $horario)
                  @if ($horario->hadmDia == 2)
                    @if ($horario->hadmHoraInicio < 10)
                      @php
                        $hadmHoraInicioM = '0'.$horario->hadmHoraInicio;
                      @endphp
                    @else
                      @php
                        $hadmHoraInicioM = $horario->hadmHoraInicio;
                      @endphp
                    @endif


                    @if ($horario->hadmFinal < 10)
                      @php
                        $hadmFinalM = '0'.$horario->hadmFinal;
                      @endphp
                    @else
                      @php
                        $hadmFinalM = $horario->hadmFinal;
                      @endphp
                    @endif
                    {{ $hadmHoraInicioM.':'.$horario->gMinInicio }} a {{ $hadmFinalM.':'.$horario->gMinFinal }}
                    <br>
                  @endif
                @endforeach
              </td>

              {{--  miercoles   --}}
              <td align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                @foreach ($horarios as $horario)
                  @if ($horario->hadmDia == 3)

                      @if ($horario->hadmHoraInicio < 10)
                        @php
                          $hadmHoraInicioMi = '0'.$horario->hadmHoraInicio;
                        @endphp
                      @else
                        @php
                          $hadmHoraInicioMi = $horario->hadmHoraInicio;
                        @endphp
                      @endif


                      @if ($horario->hadmFinal < 10)
                        @php
                          $hadmFinalMi = '0'.$horario->hadmFinal;
                        @endphp
                      @else
                        @php
                          $hadmFinalMi = $horario->hadmFinal;
                        @endphp
                      @endif
                    {{ $hadmHoraInicioMi.':'.$horario->gMinInicio }} a {{ $hadmFinalMi.':'.$horario->gMinFinal }}
                    <br>
                  @endif
                @endforeach
              </td>

              {{--  jueves   --}}
              <td align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                @foreach ($horarios as $horario)
                  @if ($horario->hadmDia == 4)
                      @if ($horario->hadmHoraInicio < 10)
                        @php
                          $hadmHoraInicioJ = '0'.$horario->hadmHoraInicio;
                        @endphp
                      @else
                        @php
                          $hadmHoraInicioJ = $horario->hadmHoraInicio;
                        @endphp
                      @endif


                      @if ($horario->hadmFinal < 10)
                        @php
                          $hadmFinalJ = '0'.$horario->hadmFinal;
                        @endphp
                      @else
                        @php
                          $hadmFinalJ = $horario->hadmFinal;
                        @endphp
                      @endif
                    {{ $hadmHoraInicioJ.':'.$horario->gMinInicio }} a {{ $hadmFinalJ.':'.$horario->gMinFinal }}
                    <br>
                  @endif
                @endforeach
              </td>

              {{--  viernes   --}}
              <td align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                @foreach ($horarios as $horario)
                  @if ($horario->hadmDia == 5)
                  @if ($horario->hadmHoraInicio < 10)
                      @php
                          $hadmHoraInicioV = '0'.$horario->hadmHoraInicio;
                        @endphp
                      @else
                        @php
                          $hadmHoraInicioV = $horario->hadmHoraInicio;
                        @endphp
                      @endif


                      @if ($horario->hadmFinal < 10)
                        @php
                          $hadmFinalV = '0'.$horario->hadmFinal;
                        @endphp
                      @else
                        @php
                          $hadmFinalV = $horario->hadmFinal;
                        @endphp
                      @endif
                    {{ $hadmHoraInicioV.':'.$horario->gMinInicio }} a {{ $hadmFinalV.':'.$horario->gMinFinal }}
                    <br>
                  @endif
                @endforeach
              </td>

              {{--  sabado   --}}
              <td align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                @foreach ($horarios as $horario)
                  @if ($horario->hadmDia == 6)
                    @if ($horario->hadmHoraInicio < 10)
                      @php
                          $hadmHoraInicioS = '0'.$horario->hadmHoraInicio;
                        @endphp
                    @else
                        @php
                          $hadmHoraInicioS = $horario->hadmHoraInicio;
                        @endphp
                    @endif


                      @if ($horario->hadmFinal < 10)
                        @php
                          $hadmFinalS = '0'.$horario->hadmFinal;
                        @endphp
                      @else
                        @php
                          $hadmFinalS = $horario->hadmFinal;
                        @endphp
                      @endif
                    {{ $hadmHoraInicioS.':'.$horario->gMinInicio }} a {{ $hadmFinalS.':'.$horario->gMinFinal }}
                    <br>
                  @endif
                @endforeach
              </td>
            </tr>
          </tbody>
        </table>

        @if ($horario_docente == 'SI')
            @if (count($horario_grupos) > 0)
          @php
            $agrupamosgrupos = $horario_grupos->groupBy('grupo_id');
          @endphp
          <br>
          <table class="table">




            <col style="width:10%;" />
            <col style="width:30%;" />

            <thead>
              <tr>
                <th align="center" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Materia</th>
                <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Lun</th>
                <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Mar</th>
                <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Mier</th>
                <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Jue</th>
                <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Vie</th>
                <th align="center" scope="col" style="width: 100px; border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">Sab</th>
              </tr>
            </thead>


            <tbody>
              @foreach ($agrupamosgrupos as $grupo_id => $los_valores)
                @foreach ($los_valores as $gro)
                  @if ($grupo_id == $gro->grupo_id && $contador++ == 1)
                    <tr>


                      <td style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">{{ $gro->gpoSemestre.''.$gro->gpoClave.'-'.$gro->matNombre }}</td>


                      @php
                        $horario_grupos2 = Horario::select(
                        'horarios.id',
                        'horarios.ghDia as dia',
                        'horarios.ghInicio as hora_inicio',
                        'horarios.gMinInicio as minuto_inicio',
                        'horarios.ghFinal as hora_fin',
                        'horarios.gMinFinal as minuto_final',
                        'grupos.empleado_id',
                        'materias.matClave',
                        'materias.matNombre',
                        'optativas.optNombre',
                        'aulas.aulaClave',
                        'aulas.aulaDescripcion',
                        'aulas.aulaUbicacion',
                        'aulas.aulaEdificio',
                        'grupos.id as grupo_id',
                        'grupos.gpoClave',
                        'grupos.gpoSemestre'
                      )
                      ->join('grupos', 'horarios.grupo_id', '=', 'grupos.id')
                      ->join('materias', 'grupos.materia_id', '=', 'materias.id')
                      ->leftJoin('optativas', 'grupos.optativa_id', '=', 'optativas.id')
                      ->leftJoin('aulas', 'horarios.aula_id', '=', 'aulas.id')
                      ->where('grupos.periodo_id', $periodo_id)
                      ->where('grupos.empleado_id', $gro->empleado_id)
                      ->where('grupos.id', $gro->grupo_id)
                      ->whereNull('horarios.deleted_at')
                      ->whereNull('grupos.deleted_at')
                      ->whereNull('materias.deleted_at')
                      ->whereNull('aulas.deleted_at')
                      ->whereNull('grupos.grupo_equivalente_id')
                      ->orderBy('grupos.gpoSemestre', 'ASC')
                      ->orderBy('grupos.gpoClave', 'ASC')
                      ->orderBy('materias.matClave', 'ASC')
                      ->orderBy('horarios.ghDia', 'ASC')
                      ->orderBy('horarios.ghInicio', 'ASC')
                      ->orderBy('horarios.gMinInicio', 'ASC')
                      ->orderBy('horarios.ghFinal', 'ASC')
                      ->orderBy('horarios.gMinFinal', 'ASC')
                      ->get();
                      @endphp

                      <td style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                        @foreach ($horario_grupos2 as $el_horario)
                          @if ($el_horario->dia == 1)
                            @if ($el_horario->hora_inicio < 10)
                              @php
                                $hora_inicioL = '0'.$el_horario->hora_inicio;
                              @endphp
                            @else
                              @php
                                $hora_inicioL = $el_horario->hora_inicio;
                              @endphp
                            @endif

                            @if ($el_horario->hora_fin < 10)
                              @php
                                $hora_finL = '0'.$el_horario->hora_fin;
                              @endphp
                            @else
                              @php
                                $hora_finL = $el_horario->hora_fin;
                              @endphp
                            @endif

                            {{ $hora_inicioL.':'.$el_horario->minuto_inicio }} a {{ $hora_finL.':'.$el_horario->minuto_final }}


                          @endif
                        @endforeach
                      </td>

                      <td style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                        @foreach ($horario_grupos2 as $el_horario)
                          @if ($el_horario->dia == 2)
                            @if ($el_horario->hora_inicio < 10)
                              @php
                                $hora_inicioM = '0'.$el_horario->hora_inicio;
                              @endphp
                            @else
                              @php
                                $hora_inicioM = $el_horario->hora_inicio;
                              @endphp
                            @endif

                            @if ($el_horario->hora_fin < 10)
                              @php
                                $hora_finM = '0'.$el_horario->hora_fin;
                              @endphp
                            @else
                              @php
                                $hora_finM = $el_horario->hora_fin;
                              @endphp
                            @endif

                            {{ $hora_inicioM.':'.$el_horario->minuto_inicio }} a {{ $hora_finM.':'.$el_horario->minuto_final }}


                          @endif
                        @endforeach
                      </td>

                      <td style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                        @foreach ($horario_grupos2 as $el_horario)
                          @if ($el_horario->dia == 3)
                            @if ($el_horario->hora_inicio < 10)
                              @php
                                $hora_inicioMi = '0'.$el_horario->hora_inicio;
                              @endphp
                            @else
                              @php
                                $hora_inicioMi = $el_horario->hora_inicio;
                              @endphp
                            @endif

                            @if ($el_horario->hora_fin < 10)
                              @php
                                $hora_finMi = '0'.$el_horario->hora_fin;
                              @endphp
                            @else
                              @php
                                $hora_finMi = $el_horario->hora_fin;
                              @endphp
                            @endif

                            {{ $hora_inicioMi.':'.$el_horario->minuto_inicio }} a {{ $hora_finMi.':'.$el_horario->minuto_final }}


                          @endif
                        @endforeach
                      </td>

                      <td style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                        @foreach ($horario_grupos2 as $el_horario)
                          @if ($el_horario->dia == 4)
                            @if ($el_horario->hora_inicio < 10)
                              @php
                                $hora_inicioJ = '0'.$el_horario->hora_inicio;
                              @endphp
                            @else
                              @php
                                $hora_inicioJ = $el_horario->hora_inicio;
                              @endphp
                            @endif

                            @if ($el_horario->hora_fin < 10)
                              @php
                                $hora_finJ = '0'.$el_horario->hora_fin;
                              @endphp
                            @else
                              @php
                                $hora_finJ = $el_horario->hora_fin;
                              @endphp
                            @endif

                            {{ $hora_inicioJ.':'.$el_horario->minuto_inicio }} a {{ $hora_finJ.':'.$el_horario->minuto_final }}


                          @endif
                        @endforeach
                      </td>

                      <td style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                        @foreach ($horario_grupos2 as $el_horario)
                          @if ($el_horario->dia == 5)
                            @if ($el_horario->hora_inicio < 10)
                              @php
                                $hora_inicioV = '0'.$el_horario->hora_inicio;
                              @endphp
                            @else
                              @php
                                $hora_inicioV = $el_horario->hora_inicio;
                              @endphp
                            @endif

                            @if ($el_horario->hora_fin < 10)
                              @php
                                $hora_finV = '0'.$el_horario->hora_fin;
                              @endphp
                            @else
                              @php
                                $hora_finV = $el_horario->hora_fin;
                              @endphp
                            @endif

                            {{ $hora_inicioV.':'.$el_horario->minuto_inicio }} a {{ $hora_finV.':'.$el_horario->minuto_final }}


                          @endif
                        @endforeach
                      </td>

                      {{--  sabado   --}}
                      <td style="border-top: 1px solid; border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
                        @foreach ($horario_grupos2 as $el_horario)
                          @if ($el_horario->dia == 6)
                            @if ($el_horario->hora_inicio < 10)
                              @php
                                $hora_inicioS = '0'.$el_horario->hora_inicio;
                              @endphp
                            @else
                              @php
                                $hora_inicioS = $el_horario->hora_inicio;
                              @endphp
                            @endif

                            @if ($el_horario->hora_fin < 10)
                              @php
                                $hora_finS = '0'.$el_horario->hora_fin;
                              @endphp
                            @else
                              @php
                                $hora_finS = $el_horario->hora_fin;
                              @endphp
                            @endif

                            {{ $hora_inicioS.':'.$el_horario->minuto_inicio }} a {{ $hora_finS.':'.$el_horario->minuto_final }}


                          @endif
                        @endforeach
                      </td>
                    </tr>
                  @endif
                @endforeach
                @php
                    $contador = 1;
                  @endphp
              @endforeach
            </tbody>
          </table>
        @endif
        @endif

        <br>
        <br>
        <br>
        @endforeach
      </div>
    </div>
    {{--  @if ($loop->first)
      <footer id="footer">
        <div class="page-number"></div>
      </footer>
    @endif  --}}



  </body>
</html>
