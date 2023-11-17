<!DOCTYPE html>
<html>

<head>
  <title>Resumen de inasistenciaTotalPoralumnos</title>
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
      line-height: 1.15;
      /* 1 */
      -webkit-text-size-adjust: 100%;
      /* 2 */
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
      box-sizing: content-box;
      /* 1 */
      height: 0;
      /* 1 */
      overflow: visible;
      /* 2 */
    }

    /**
      * 1. Correct the inheritance and scaling of font size in all browsers.
      * 2. Correct the odd `em` font sizing in all browsers.
      */
    pre {
      font-family: monospace, monospace;
      /* 1 */
      font-size: 1em;
      /* 2 */
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
      border-bottom: none;
      /* 1 */
      text-decoration: underline;
      /* 2 */
      text-decoration: underline dotted;
      /* 2 */
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
      font-family: monospace, monospace;
      /* 1 */
      font-size: 1em;
      /* 2 */
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
      font-family: inherit;
      /* 1 */
      font-size: 100%;
      /* 1 */
      line-height: 1.15;
      /* 1 */
      margin: 0;
      /* 2 */
    }

    /**
      * Show the overflow in IE.
      * 1. Show the overflow in Edge.
      */
    button,
    input {
      /* 1 */
      overflow: visible;
    }

    /**
      * Remove the inheritance of text transform in Edge, Firefox, and IE.
      * 1. Remove the inheritance of text transform in Firefox.
      */
    button,
    select {
      /* 1 */
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
      box-sizing: border-box;
      /* 1 */
      color: inherit;
      /* 2 */
      display: table;
      /* 1 */
      max-width: 100%;
      /* 1 */
      padding: 0;
      /* 3 */
      white-space: normal;
      /* 1 */
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
      box-sizing: border-box;
      /* 1 */
      padding: 0;
      /* 2 */
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
      -webkit-appearance: textfield;
      /* 1 */
      outline-offset: -2px;
      /* 2 */
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
      -webkit-appearance: button;
      /* 1 */
      font: inherit;
      /* 2 */
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

    body {
      font-family: 'sans-serif';
      font-size: 10px;
      margin-top: 40px;
      margin-left: 5px;
      margin-right: 5px;
    }

    .row {
      width: 100%;
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
      box-sizing: border-box !important;
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

    span {
      font-weight: bold;
    }

    p {
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

    .estilos-tabla tr th {
      font-size: 12px;
      background-color: #000;
      color: #fff;
      height: 30px;
      padding-left: 5px;
      padding-right: 5px;
      box-sizing: border-box;
      text-align: center;
    }

    .estilos-tabla tr td {
      font-size: 12px;
      padding-left: 2px;
      padding-right: 2px;
      box-sizing: border-box;
      color: #000;
    }

    .page_break {
      page-break-before: always;
    }

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

    #watermark {
      position: fixed;
      top: 15%;
      left: 0;
      width: 700px;
      height: 700px;
      opacity: .3;
    }

    .img-header {
      height: 80px;
    }

    .inicio-pagina {
      margin-top: 0;
      display: block;
    }

    @page {
      margin-top: 20px;
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
      margin-left: 0px !important;
      padding-left: 0 !important;
      text-align: center;
    }

    .listas-asistencia li {
      display: inline;
      list-style-type: none;
      border: 1px solid #000;
      width: 4.5%;
      /* display: inline-block; */
    }

    .listas-asistencia li div {
      display: inline-block;
      width: 47px;
      height: 15px;
    }

    .listas-asistencia li div span {
      font-size: 8px;
      margin-top: 2px;
      display: block;
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

    .table td,
    .table th {
      padding-top: 0px;
      padding-bottom: 0px;
      padding-right: 5px;
    }

    .page-number:before {
      content: "Pág "counter(page);
    }
  </style>
</head>

<body>
  <header>
    <div class="row">
      <div class="columns medium-6">
        <h5 style="margin-top:0px; margin-bottom: 10px;">SECUNDARIA "MODELO"</h5>
        <h5 style="margin-top:0px; margin-bottom: 10px;">{{$parametro_Titulo}}</h5>
      </div>
      <div class="columns medium-6">
        <div style="text-align: right;">
          <p>{{$fechaActual}}</p>
          <p>{{$horaActual}}</p>
          <p>{{$parametro_NombreArchivo}}</p>
        </div>
      </div>
    </div>
  </header>

  {{--  @php  --}}
  {{--  $inscritos = $grupo['inscritos'];  --}}

  // dd($grupos, $grupo, $inscritos);
  {{--  @endphp
      @if (!is_null($inscritos))  --}}

  <div class="row" style="margin-bottom: 2px;">
    <div class="columns medium-12">
      <p>Ubicación: {{$datos_cabecera[0]->ubiClave}} {{$datos_cabecera[0]->ubiNombre}}</p>

      <p>
        Período : {{$cicloEscolar}}
      </p>

      <p>
        Nivel: {{$parametro_progClave}} ({{$parametro_planClave}}) {{$parametro_progNombre}} Grado: {{$grado}} Grupo:
        {{$grupo}}
      </p>

      <p>Docente : {{$datos_cabecera[0]->empNombre}} {{$datos_cabecera[0]->empApellido1}}
        {{$datos_cabecera[0]->empApellido2}}</p>

      {{-- Muestra si es por mes  --}}
      @if ($tipoReporte == "porMes")
      <p>Mes : {{$mesEvaluar}} Incluye insc,
        @if ($conceptos == "R")
        regular ({{$conceptos}})
        @endif
        @if ($conceptos == "B")
        baja curso ({{$conceptos}})
        @endif
        @if ($conceptos == "P")
        preinscrito ({{$conceptos}})
        @endif
        @if ($conceptos == "C")
        condicionado ({{$conceptos}})
        @endif
        @if ($conceptos == "X")
        otro ({{$conceptos}})
        @endif
        @if ($conceptos == "A")
        condicionado 2 ({{$conceptos}})
        @endif
        @if ($conceptos == "R+P")
        salon ({{$conceptos}})
        @endif
      </p>
      @endif

      {{-- Muestra si es por bimestre --}}
      @if ($tipoReporte == "porBimestre")
      <p>Bimestre :
        @if ($bimestreEvaluar == "BIMESTRE1")
        1
        @endif
        @if ($bimestreEvaluar == "BIMESTRE2")
        2
        @endif
        @if ($bimestreEvaluar == "BIMESTRE3")
        3
        @endif
        @if ($bimestreEvaluar == "BIMESTRE4")
        4
        @endif
        @if ($bimestreEvaluar == "BIMESTRE5")
        5
        @endif
        Incluye insc,
        @if ($conceptos == "R")
        regular ({{$conceptos}})
        @endif
        @if ($conceptos == "B")
        baja curso ({{$conceptos}})
        @endif
        @if ($conceptos == "P")
        preinscrito ({{$conceptos}})
        @endif
        @if ($conceptos == "C")
        condicionado ({{$conceptos}})
        @endif
        @if ($conceptos == "X")
        otro ({{$conceptos}})
        @endif
        @if ($conceptos == "A")
        condicionado 2 ({{$conceptos}})
        @endif
        @if ($conceptos == "R+P")
        salon ({{$conceptos}})
        @endif
      </p>
      @endif

      {{-- Muestra si es por trimestre  --}}
      @if ($tipoReporte == "porTrimestre")
      <p>Trimestre :
        @if ($trimestreEvaluar == "TRIMESTRE1")
        1
        @endif
        @if ($trimestreEvaluar == "TRIMESTRE2")
        2
        @endif
        @if ($trimestreEvaluar == "TRIMESTRE3")
        3
        @endif

        Incluye insc,
        @if ($conceptos == "R")
        regular ({{$conceptos}})
        @endif
        @if ($conceptos == "B")
        baja curso ({{$conceptos}})
        @endif
        @if ($conceptos == "P")
        preinscrito ({{$conceptos}})
        @endif
        @if ($conceptos == "C")
        condicionado ({{$conceptos}})
        @endif
        @if ($conceptos == "X")
        otro ({{$conceptos}})
        @endif
        @if ($conceptos == "A")
        condicionado 2 ({{$conceptos}})
        @endif
        @if ($conceptos == "R+P")
        salon ({{$conceptos}})
        @endif
      </p>
      @endif

      @if ($tipoReporte == "porMes")
      @if ($modoCalificacion == "BASEPORCENTAJE")
      @if ($mesEvaluar == "Septiembre")
      <p>Calificación en Puntos obtenidos en el Mes de {{$mesEvaluar}} - Puntuación Máxima del %
        {{$porcentajeSeptiembre}}</p>
      @endif

      @if ($mesEvaluar == "Octubre")
      <p>Calificación en Puntos obtenidos en el Mes de {{$mesEvaluar}} - Puntuación Máxima del % {{$porcentajeOctubre}}
      </p>
      @endif

      @if ($mesEvaluar == "Noviembre")
      <p>Calificación en Puntos obtenidos en el Mes de {{$mesEvaluar}} - Puntuación Máxima del %
        {{$porcentajeNoviembre}}</p>
      @endif

      @if ($mesEvaluar == "Diciembre")
      <p>Calificación en Puntos obtenidos en el Mes de {{$mesEvaluar}} - Puntuación Máxima del %
        {{$porcentajeDiciembre}}</p>
      @endif

      @if ($mesEvaluar == "Enero")
      <p>Calificación en Puntos obtenidos en el Mes de {{$mesEvaluar}} - Puntuación Máxima del % {{$porcentajeEnero}}
      </p>
      @endif

      @if ($mesEvaluar == "Febrero")
      <p>Calificación en Puntos obtenidos en el Mes de {{$mesEvaluar}} - Puntuación Máxima del % {{$porcentajeFebrero}}
      </p>
      @endif

      @if ($mesEvaluar == "Marzo")
      <p>Calificación en Puntos obtenidos en el Mes de {{$mesEvaluar}} - Puntuación Máxima del % {{$porcentajeMarzo}}
      </p>
      @endif

      @if ($mesEvaluar == "Abril")
      <p>Calificación en Puntos obtenidos en el Mes de {{$mesEvaluar}} - Puntuación Máxima del % {{$porcentajeAbril}}
      </p>
      @endif

      @if ($mesEvaluar == "Mayo")
      <p>Calificación en Puntos obtenidos en el Mes de {{$mesEvaluar}} - Puntuación Máxima del % {{$porcentajeMayo}}</p>
      @endif

      @if ($mesEvaluar == "Junio")
      <p>Calificación en Puntos obtenidos en el Mes de {{$mesEvaluar}} - Puntuación Máxima del % {{$porcentajeJunio}}
      </p>
      @endif
      @endif
      @endif


    </div>
  </div>
  <br>




  @php
  $inasistenciaTotalPoralumno = 0;
  $inasistenciaTotal = 0;
  $totalFaltasXmateria = 0;
  $totalVueltas = -1;
  @endphp

  <div class="row">
    <div class="columns medium-12">
      <table class="table">
        <tr>
          <th style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></th>
          <th style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></th>
          <th style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></th>
          @php
          $stilo = "border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;";
          $stilo2 = "border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;";
          @endphp
          @for ($i = 0; $i < count($materia_alumos); $i++) <th align="center"
            style="font-weight: 400; @if ($i == 0){{$stilo}} @endif @if ($i != 0){{$stilo2}} @endif">
            @if ($i == 2)
            ASIGNATURAS
            @endif
            </th>
            @endfor
            <th align="center"
              style="font-weight: 400; border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;">
              Totales</th>
            <th style="border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></th>



        </tr>
        <tr>
          <th align="center"
            style="font-weight: 400; border-top: 0px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
            Num</th>
          <th align="center"
            style="font-weight: 400; border-top: 0px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
            Cve Pago</th>
          <th
            style="font-weight: 400; border-top: 0px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
            Nombre del alumno</th>

          {{--  recorremos array para mostrar materias   --}}
          @foreach ($materia_alumos as $mat)
          <th align="center"
            style="font-weight: 400; width:40px; border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;">
            {{$mat->matClave}}</th>
          @endforeach

          <th align="center"
            style="font-weight: 400; border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;">
            Período</th>
          <th align="center"
            style="font-weight: 400; border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;">
          </th>


        </tr>


        @foreach ($calificacionesInscritos as $key => $inscrito)
          <tr>
            <td align="center"
              style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">{{$key+1}}
            </td>
            <td align="center"
              style="width: 40px; border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
              {{$inscrito->aluClave}}</td>
            <td
              style="width: 219px; border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
              {{$inscrito->perApellido1}} {{$inscrito->perApellido2}} {{$inscrito->perNombre}}
            </td>


            @foreach ($materia_alumos as $keyMat => $matAlumnos)
            @php
            $totalVueltas++;

            @endphp
              @foreach ($calificaciones as $keyCalif => $item)

                @if ($tipoReporte == "porMes")
                    @if ($mesEvaluar == "Septiembre")                    
                      @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                        <td align="center"
                          style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                          @if ($item->inscFaltasInjSep != null)
                            {{$item->inscFaltasInjSep}}
                          @php
                            $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjSep;
                            $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjSep;
                          @endphp
                          @else

                          @endif
                        </td>
                      @endif
                    @endif

                    @if ($mesEvaluar == "Octubre")
                      @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                      <td align="center"
                        style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                        @if ($item->inscFaltasInjOct != null)
                        {{$item->inscFaltasInjOct}}
                        @php
                            $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjOct;
                            $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjOct;
                          @endphp
                        @else

                        @endif
                      </td>
                      @endif
                    @endif

                    @if ($mesEvaluar == "Noviembre")
                      @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                      <td align="center"
                        style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                        @if ($item->inscFaltasInjNov != null)
                        {{$item->inscFaltasInjNov}}
                        @php
                            $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjNov;
                            $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjNov;
                          @endphp
                        @else

                        @endif
                      </td>
                      @endif
                    @endif


                    @if ($mesEvaluar == "Diciembre")
                      @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                      <td align="center"
                        style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                        @if ($item->inscFaltasInjDic != null)
                        {{$item->inscFaltasInjDic}}
                        @php
                            $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjDic;
                            $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjDic;
                          @endphp
                        @else

                        @endif
                      </td>
                      @endif
                    @endif

                    @if ($mesEvaluar == "Enero")
                      @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                      <td align="center"
                        style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                        @if ($item->inscFaltasInjEne != null)
                        {{$item->inscFaltasInjEne}}
                        @php
                            $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjEne;
                            $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjEne;
                          @endphp
                        @else

                        @endif
                      </td>
                      @endif
                    @endif

                    @if ($mesEvaluar == "Febrero")
                      @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                      <td align="center"
                        style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                        @if ($item->inscFaltasInjFeb != null)
                        {{$item->inscFaltasInjFeb}}
                        @php
                            $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjFeb;
                            $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjFeb;
                          @endphp
                        @else

                        @endif
                      </td>
                      @endif
                    @endif

                    @if ($mesEvaluar == "Marzo")
                      @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                      <td align="center"
                        style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                        @if ($item->inscFaltasInjMar != null)
                        {{$item->inscFaltasInjMar}}
                        @php
                            $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjMar;
                            $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjMar;
                          @endphp
                        @else

                        @endif
                      </td>
                      @endif
                    @endif

                    @if ($mesEvaluar == "Abril")
                      @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                      <td align="center"
                        style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                        @if ($item->inscFaltasInjAbr != null)
                        {{$item->inscFaltasInjAbr}}
                        @php
                            $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjAbr;
                            $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjAbr;
                          @endphp
                        @else

                        @endif
                      </td>
                      @endif
                    @endif

                    @if ($mesEvaluar == "Mayo")
                      @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                      <td align="center"
                        style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                        @if ($item->inscFaltasInjMay != null)
                        {{$item->inscFaltasInjMay}}
                        @php
                            $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjMay;
                            $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjMay;
                          @endphp
                        @else

                        @endif
                      </td>
                      @endif
                    @endif

                    @if ($mesEvaluar == "Junio")
                      @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                      <td align="center"
                        style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                        @if ($item->inscFaltasInjJun != null)
                        {{$item->inscFaltasInjJun}}
                        @php
                            $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjJun;
                            $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjJun;
                          @endphp
                        @else

                        @endif
                      </td>
                      @endif
                    @endif
                @endif

                {{-- mostrar por bimestre  --}}
                @if ($tipoReporte == "porBimestre")

                  {{-- bimestre 1 --}}
                  @if ($bimestreEvaluar == "BIMESTRE1")
                    @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                    <td align="center"
                      style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                      {{$item->inscFaltasInjSep + $item->inscFaltasInjOct}}

                      @php
                          $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjSep + $item->inscFaltasInjOct;
                          $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjSep + $item->inscFaltasInjOct;
                      @endphp
                    </td>
                    @endif
                  @endif

                  {{-- bimestre 2 --}}
                  @if ($bimestreEvaluar == "BIMESTRE2")
                    @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                    <td align="center"
                      style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                      {{$item->inscFaltasInjNov + $item->inscFaltasInjDic}}
                      @php
                          $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjNov + $item->inscFaltasInjDic;
                          $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjNov + $item->inscFaltasInjDic;
                      @endphp
                    </td>
                    @endif
                  @endif

                  {{-- bimestre 3 --}}
                  @if ($bimestreEvaluar == "BIMESTRE3")
                    @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                    <td align="center"
                      style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                      {{$item->inscFaltasInjEne + $item->inscFaltasInjFeb}}

                      @php
                          $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjEne + $item->inscFaltasInjFeb;
                          $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjEne + $item->inscFaltasInjFeb;
                      @endphp
                    </td>
                    @endif
                  @endif

                  {{-- bimestre 4 --}}
                  @if ($bimestreEvaluar == "BIMESTRE4")
                    @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                    <td align="center"
                      style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                      {{$item->inscFaltasInjMar + $item->inscFaltasInjAbr}}

                      @php
                        $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjMar + $item->inscFaltasInjAbr;
                        $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjMar + $item->inscFaltasInjAbr;
                      @endphp

                    </td>
                    @endif
                  @endif

                  {{-- bimestre 5 --}}
                  @if ($bimestreEvaluar == "BIMESTRE5")
                    @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                    <td align="center"
                      style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                      {{$item->inscFaltasInjMay + $item->inscFaltasInjJun}}

                      @php
                        $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjMay + $item->inscFaltasInjJun;
                        $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjMay + $item->inscFaltasInjJun;
                      @endphp
                    </td>
                    @endif
                  @endif

                @endif

                {{-- mostrar por trimestre --}}
                @if ($tipoReporte == "porTrimestre")

                  {{-- trimestre 1 --}}
                  @if ($trimestreEvaluar == "TRIMESTRE1")
                    @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                    <td align="center"
                      style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                      {{$item->inscFaltasInjSep + $item->inscFaltasInjOct + $item->inscFaltasInjNov}}

                      @php
                        $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjSep + $item->inscFaltasInjOct + $item->inscFaltasInjNov;
                        $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjSep + $item->inscFaltasInjOct + $item->inscFaltasInjNov;
                      @endphp
                    </td>
                    @endif
                  @endif

                  {{-- trimestre 2 --}}
                  @if ($trimestreEvaluar == "TRIMESTRE2")
                    @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                    <td align="center"
                      style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                      {{$item->inscFaltasInjDic + $item->inscFaltasInjEne + $item->inscFaltasInjFeb + $item->inscFaltasInjMar}}

                      @php
                        $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjDic + $item->inscFaltasInjEne + $item->inscFaltasInjFeb + $item->inscFaltasInjMar;
                        $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjDic + $item->inscFaltasInjEne + $item->inscFaltasInjFeb + $item->inscFaltasInjMar;
                      @endphp

                    </td>
                    @endif
                  @endif

                  {{-- trimestre 3 --}}
                  @if ($trimestreEvaluar == "TRIMESTRE3")
                    @if ($matAlumnos->matClave == $item->matClave && $item->clave_pago == $inscrito->aluClave)
                    <td align="center"
                      style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">
                      {{$item->inscFaltasInjAbr + $item->inscFaltasInjMay + $item->inscFaltasInjJun}}

                      @php
                        $inasistenciaTotalPoralumno = $inasistenciaTotalPoralumno + $item->inscFaltasInjAbr + $item->inscFaltasInjMay + $item->inscFaltasInjJun;
                        $inasistenciaTotal = $inasistenciaTotal + $item->inscFaltasInjAbr + $item->inscFaltasInjMay + $item->inscFaltasInjJun;
                      @endphp

                    </td>
                    @endif
                  @endif
                @endif
              @endforeach
            @endforeach


            <td align="center" style="border-top: 1px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;">{{$inasistenciaTotalPoralumno}}</td>

            <td align="center"
              style="border-top: 0px solid; border-right: 1px; border-bottom: 1px; border-left: 1px solid;"></td>


          </tr>

          @if ($loop->last)
          <tr>
            <td style="border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
            <td style="border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
            <td style="border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
            @for ($i = 0; $i < count($materia_alumos); $i++) <td align="center"
              style="border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;">
              </td>
              @endfor
              <td style="border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
              <td style="border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
  
          </tr>
  
          <tr>
            <td style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
            <td style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
            <td style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;">
              <p style="text-align: right">TOTALES:</p>
            </td>
            @for ($i = 0; $i < count($materia_alumos); $i++) 
              @for ($x = 0; $x < count($calificaciones); $x++)
                @if ($tipoReporte == "porMes")
                      @if ($mesEvaluar == "Septiembre")
                        @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                          @php
                            $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjSep;
                          @endphp
                        @endif                        
                      @endif

                      @if ($mesEvaluar == "Octubre")
                        @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                          @php
                            $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjOct;
                          @endphp
                        @endif                        
                      @endif

                      @if ($mesEvaluar == "Noviembre")
                        @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                          @php
                            $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjNov;
                          @endphp
                        @endif                        
                      @endif

                      @if ($mesEvaluar == "Diciembre")
                        @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                          @php
                            $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjDic;
                          @endphp
                        @endif                        
                      @endif

                      @if ($mesEvaluar == "Enero")
                        @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                          @php
                            $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjEne;
                          @endphp
                        @endif                        
                      @endif


                      @if ($mesEvaluar == "Febrero")
                        @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                          @php
                            $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjFeb;
                          @endphp
                        @endif                        
                      @endif

                      @if ($mesEvaluar == "Marzo")
                        @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                          @php
                            $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjMar;
                          @endphp
                        @endif                        
                      @endif

                      @if ($mesEvaluar == "Abril")
                        @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                          @php
                            $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjAbr;
                          @endphp
                        @endif                        
                      @endif


                      @if ($mesEvaluar == "Mayo")
                        @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                          @php
                            $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjMay;
                          @endphp
                        @endif                        
                      @endif

                      @if ($mesEvaluar == "Junio")
                        @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                          @php
                            $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjJun;
                          @endphp
                        @endif                        
                      @endif
                      
                @endif        
                
                {{-- mostrar por bimestre  --}}
                @if ($tipoReporte == "porBimestre")
                  @if ($bimestreEvaluar == "BIMESTRE1")
                    @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                      @php
                        $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjSep + $calificaciones[$x]->inscFaltasInjOct;
                      @endphp
                    @endif
                  @endif

                  @if ($bimestreEvaluar == "BIMESTRE2")
                    @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                      @php
                        $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjNov + $calificaciones[$x]->inscFaltasInjDic;
                      @endphp
                    @endif
                  @endif

                  @if ($bimestreEvaluar == "BIMESTRE3")
                    @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                      @php
                        $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjEne + $calificaciones[$x]->inscFaltasInjFeb;
                      @endphp
                    @endif
                  @endif

                  @if ($bimestreEvaluar == "BIMESTRE4")
                    @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                      @php
                        $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjMar + $calificaciones[$x]->inscFaltasInjMar;
                      @endphp
                    @endif
                  @endif

                  @if ($bimestreEvaluar == "BIMESTRE5")
                    @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                      @php
                        $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjAbr + $calificaciones[$x]->inscFaltasInjMay;
                      @endphp
                    @endif
                  @endif
                @endif

                {{-- mostrar por trimestre --}}
                @if ($tipoReporte == "porTrimestre")

                  {{-- trimestre 1 --}}
                  @if ($trimestreEvaluar == "TRIMESTRE1")
                    @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                    @php
                        $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjSep + $calificaciones[$x]->inscFaltasInjOct + $calificaciones[$x]->inscFaltasInjNov;
                    @endphp                    
                    @endif
                  @endif

                  {{-- trimestre 2 --}}
                  @if ($trimestreEvaluar == "TRIMESTRE2")
                    @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                    @php
                        $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjDic + $calificaciones[$x]->inscFaltasInjEne + $calificaciones[$x]->inscFaltasInjFeb + $calificaciones[$x]->inscFaltasInjMar;
                    @endphp 
                    
                    @endif
                  @endif

                  {{-- trimestre 3 --}}
                  @if ($trimestreEvaluar == "TRIMESTRE3")
                    @if ($materia_alumos[$i]->matClave == $calificaciones[$x]->matClave)
                    @php
                        $totalFaltasXmateria = $totalFaltasXmateria +  $calificaciones[$x]->inscFaltasInjAbr + $calificaciones[$x]->inscFaltasInjMay + $calificaciones[$x]->inscFaltasInjJun;
                    @endphp                      
                    @endif
                  @endif
                @endif
                
              @endfor
              <td align="center"
                style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;">{{$totalFaltasXmateria}}
                </td>
                @php
                $totalFaltasXmateria = 0;
                @endphp
            @endfor
              
              <td align="center"
                style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;">
                {{$inasistenciaTotal}}</td>
              <td style="border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
          </tr>
  
          <tr>
            <td style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
            <td style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
            <td style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
            @for ($i = 0; $i < count($materia_alumos); $i++) <td align="center"
              style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;">
              </td>
              @endfor
              <td style="border-top: 1px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
              <td style="border-top: 0px solid; border-right: 1px; border-bottom: 0px; border-left: 1px solid;"></td>
          </tr>
          @endif

          @php
              $inasistenciaTotalPoralumno = 0;
              $totalVueltas = -1;

          @endphp
        @endforeach
        

      </table>
    </div>
  </div>
  {{--  @if ($loop->first)  --}}
  <footer id="footer">
    <div class="page-number"></div>
  </footer>
  {{--  @endif  --}}
  {{--  @if (!$loop->last)  --}}
  {{--  <div class="page_break"></div>  --}}
  {{--  @endif  --}}
  {{--  @endif  --}}


  <footer id="footer">
    <div class="page-number"></div>
  </footer>
</body>

</html>