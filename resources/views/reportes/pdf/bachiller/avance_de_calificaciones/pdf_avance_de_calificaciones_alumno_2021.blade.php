<!DOCTYPE html>
<html>

<head>
  <title>Resumen de calificaciones</title>
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
      line-height: 1.6;
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
      font-family: 'times sans-serif';
      font-size: 11px;
      margin-top: 40px;
      /* ALTURA HEADER */
      margin-left: 5px;
      margin-right: 5px;
    }

    .row {
      width: 100%;
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
      box-sizing: border-box !important;
    }

    .medium-1 {
      width: 8.33333333333%;
    }

    .medium-4 {
      width: 16.6666666667%;
    }

    .medium-2 {
      width: 21%;
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
        left: 0px;
      position: fixed;
      top: -50px;
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
      float: left;
    }

    .img-foto {
      height: 80px;
      float: right;
      margin-top: -100px;

      padding: 2px;
      background-color: #f5f5f5;
      border: 1px solid #999999;


    }

    .inicio-pagina {
      margin-top: 0;
      display: block;
    }

    @page {
        margin-left: 0.5cm;
        margin-right: 0.5cm;
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
      margin-left: 0px !important;
      padding-left: 0 !important;
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



    .table td,
    .table th {
      padding-top: 0px;
      padding-bottom: 0px;
      padding-right: 5px;
      border: 1px solid #000;
    }

    .page-number:before {
      content: "Pág "counter(page);
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

        {{--  <img class="img-header" src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">  --}}
        <h1 style="margin-top:0px; margin-bottom: 0px; text-align: center;">Preparatoria "ESCUELA MODELO"</h1>
        <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">INCORPORADA A LA UNIVERSIDAD AUTONOMA DE YUCATAN</h4>
        <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">PERIODO ESCOLAR: {{$cicloEscolar}}</h4>

      </div>
    </div>
  </header>

  <div class="row">
    <div class="columns medium-3">
      <p><b>Clave:</b> {{$alumno[0]->clave_pago}}</p>
      <p><b>Alumno:</b> {{$alumno[0]->ape_paterno.' '.$alumno[0]->ape_materno.' '.$alumno[0]->nombres}}</p>
    </div>
    <div class="columns medium-2">

    </div>
    <div class="columns medium-3">
      <p><b>Clav.Plan:</b> {{$alumno[0]->planClave}}</p>
      <p><b>Ubicación:</b> {{$alumno[0]->ubiClave}}</p>
    </div>
    <div class="columns medium-2">

    </div>
    <div class="columns medium-3">
      <p><b>Fecha:</b> {{$fechaActual}}</p>
      <p><b>Grupo:</b> {{$alumno[0]->semestre.' '.$alumno[0]->grupo}}</p>
    </div>
  </div>

  <br>
  @php
      $pos = 1;
  @endphp
  <div class="row">
    <div class="columns medium-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td style="border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;"></td>
            <td style="border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;"></td>
            <td style="border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;"></td>
            <th align="center" colspan="2">1er Corte</th>
            <th align="center" colspan="2">2do Corte</th>
            <th align="center" colspan="2">3er Corte</th>
            <th align="center" colspan="2">Acumulado</th>
          </tr>
          <tr>
            <th style="border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;"></th>
            <th style="border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;" align="center">ASIGNATURAS</th>
            <th style="width: 50px; border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;" align="center">Puntos =></th>
            <th align="center">Obte</th>
            <th align="center">Maxi</th>
            <th align="center">Obte</th>
            <th align="center">Maxi</th>
            <th align="center">Obte</th>
            <th align="center">Maxi</th>
            <th align="center">Obten</th>
            <th align="center">Maxim</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($materias_alumno as $matClave => $valoresObtenidos)
            @foreach ($valoresObtenidos as $item)
                @if ($matClave == $item->matClave && $pos++ == 1)
                  @php
                    $bachiller_inscritos_evidencias =  DB::select("SELECT
                    bachiller_inscritos_evidencias.id,
                    bachiller_inscritos_evidencias.evidencia_id,
                    bachiller_inscritos_evidencias.bachiller_inscrito_id,
                    bachiller_inscritos_evidencias.ievPuntos AS puntosObtenidos,
                    bachiller_evidencias.periodo_id,
                    bachiller_evidencias.bachiller_materia_id,
                    bachiller_evidencias.eviNumero,
                    bachiller_evidencias.eviDescripcion,
                    bachiller_evidencias.eviFechaEntrega,
                    bachiller_evidencias.eviPuntos AS puntosMaximos,
                    bachiller_evidencias.eviTipo,
                    bachiller_evidencias.eviFaltas,
                    bachiller_materias.matClave,
                    bachiller_materias.matNombre
                    FROM bachiller_inscritos_evidencias AS bachiller_inscritos_evidencias
                    INNER JOIN bachiller_evidencias AS bachiller_evidencias ON bachiller_evidencias.id = bachiller_inscritos_evidencias.evidencia_id
                    INNER JOIN bachiller_materias AS bachiller_materias ON bachiller_materias.id = bachiller_evidencias.bachiller_materia_id
                    WHERE bachiller_inscrito_id=$item->bachiller_inscrito_id
                    AND bachiller_evidencias.periodo_id = $item->periodo_id
                    AND bachiller_evidencias.bachiller_materia_id = $item->bachiller_materia_id
                    AND bachiller_evidencias.deleted_at IS NULL
                    AND bachiller_inscritos_evidencias.deleted_at IS NULL
                    AND bachiller_materias.deleted_at IS NULL");

                    $sumaEvidenciaObteCorte1 = 0;
                    $sumaEvidenciaMaxCorte1 = 0;

                    $sumaEvidenciaObteCorte2 = 0;
                    $sumaEvidenciaMaxCorte2 = 0;

                    $sumaEvidenciaObteCorte3 = 0;
                    $sumaEvidenciaMaxCorte3 = 0;

                    $sumaEvidenciaObteCorteBueno = 0;
                    $sumaEvidenciaMaxCorteBueno = 0;


                    foreach($bachiller_inscritos_evidencias as $inscrito_evidencia){

                      if($inscrito_evidencia->eviFechaEntrega >= $bachiller_calendario_examenes->calexInicioParcial1 && $inscrito_evidencia->eviFechaEntrega <= $bachiller_calendario_examenes->calexFinParcial1){
                        $sumaEvidenciaObteCorte1 = $sumaEvidenciaObteCorte1 + $inscrito_evidencia->puntosObtenidos;

                      }

                      if($inscrito_evidencia->eviFechaEntrega >= $bachiller_calendario_examenes->calexInicioParcial2 && $inscrito_evidencia->eviFechaEntrega <= $bachiller_calendario_examenes->calexFinParcial2){
                        $sumaEvidenciaObteCorte2 = $sumaEvidenciaObteCorte2 + $inscrito_evidencia->puntosObtenidos;

                      }

                      if($inscrito_evidencia->eviFechaEntrega >= $bachiller_calendario_examenes->calexInicioParcial3 && $inscrito_evidencia->eviFechaEntrega <= $bachiller_calendario_examenes->calexFinParcial3){
                        $sumaEvidenciaObteCorte3 = $sumaEvidenciaObteCorte3 + $inscrito_evidencia->puntosObtenidos;

                      }

                      $sumaEvidenciaObteCorteBueno = $sumaEvidenciaObteCorteBueno + $inscrito_evidencia->puntosObtenidos;


                    }


                    $bachiller_evidencias =  DB::select("SELECT
                    bachiller_evidencias.id,
                    bachiller_evidencias.periodo_id,
                    bachiller_evidencias.bachiller_materia_id,
                    bachiller_evidencias.eviNumero,
                    bachiller_evidencias.eviDescripcion,
                    bachiller_evidencias.eviFechaEntrega,
                    bachiller_evidencias.eviPuntos AS puntosMaximos,
                    bachiller_evidencias.eviTipo,
                    bachiller_evidencias.eviFaltas,
                    bachiller_materias.matClave,
                    bachiller_materias.matNombre,
                    bachiller_evidencias.deleted_at
                    FROM bachiller_evidencias AS bachiller_evidencias
                    INNER JOIN bachiller_materias AS bachiller_materias ON bachiller_materias.id = bachiller_evidencias.bachiller_materia_id
                    WHERE bachiller_evidencias.periodo_id = $item->periodo_id
                    AND bachiller_evidencias.bachiller_materia_id = $item->bachiller_materia_id
                    AND bachiller_evidencias.deleted_at IS NULL
                    AND bachiller_materias.deleted_at IS NULL");

                    foreach($bachiller_evidencias as $evidencia){
                      if($evidencia->eviFechaEntrega >= $bachiller_calendario_examenes->calexInicioParcial1 && $evidencia->eviFechaEntrega <= $bachiller_calendario_examenes->calexFinParcial1){

                        $sumaEvidenciaMaxCorte1 = $sumaEvidenciaMaxCorte1 + $evidencia->puntosMaximos;
                      }

                      if($evidencia->eviFechaEntrega >= $bachiller_calendario_examenes->calexInicioParcial2 && $evidencia->eviFechaEntrega <= $bachiller_calendario_examenes->calexFinParcial2){

                        $sumaEvidenciaMaxCorte2 = $sumaEvidenciaMaxCorte2 + $evidencia->puntosMaximos;
                      }

                      if($evidencia->eviFechaEntrega >= $bachiller_calendario_examenes->calexInicioParcial3 && $evidencia->eviFechaEntrega <= $bachiller_calendario_examenes->calexFinParcial3){

                        $sumaEvidenciaMaxCorte3 = $sumaEvidenciaMaxCorte3 + $evidencia->puntosMaximos;
                      }

                      $sumaEvidenciaMaxCorteBueno = $sumaEvidenciaMaxCorteBueno + $evidencia->puntosMaximos;
                    }

                  @endphp
                  <tr>
                    <td style="width: 20px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">{{$matClave}}</td>
                    <td style="width: 270px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 1px solid;">{{$item->matNombre}}</td>
                    <td style="border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 0px solid;" align="center"></td>
                    <td align="center">
                      {{$sumaEvidenciaObteCorte1}}
                    </td>
                    <td align="center">
                      {{$sumaEvidenciaMaxCorte1}}
                    </td>

                    <td align="center">
                      {{$sumaEvidenciaObteCorte2}}
                    </td>

                    <td align="center">
                      {{$sumaEvidenciaMaxCorte2}}
                    </td>

                    <td align="center">
                      {{$sumaEvidenciaObteCorte3}}
                    </td>

                    <td align="center">
                      {{$sumaEvidenciaMaxCorte3}}
                    </td>

                    <td align="center">
                      {{$sumaEvidenciaObteCorteBueno}}
                    </td>
                    <td align="center">
                      {{$sumaEvidenciaMaxCorteBueno}}
                    </td>
                  </tr>
                @endif
            @endforeach
            @php
              $pos = 1;
            @endphp
          @endforeach
          @php
          $sumaEvidenciaObteCorte1 = 0;
          $sumaEvidenciaMaxCorte1 = 0;

          $sumaEvidenciaObteCorte2 = 0;
          $sumaEvidenciaMaxCorte2 = 0;

          $sumaEvidenciaObteCorte3 = 0;
          $sumaEvidenciaMaxCorte3 = 0;
          @endphp

        </tbody>
      </table>

    </div>
  </div>

  <br>
  <div class="row">
    <div class="columns medium-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td style="width: 20px; border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;"></td>
            <th style="width: 325px;border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;">ASIGNATURAS NO ACREDITADAS</th>
            <th style="width: 71px;" align="center">C.F.</th>
            <th align="center">Opor1</th>
            <th align="center">Opor2</th>
            <th align="center">Opor3</th>
            <th align="center">Ult. Examen</th>
          </tr>
        </thead>
        <tbody>
          @php
            $aluClave = $alumno[0]->clave_pago;
            $periodo_id = $alumno[0]->periodo_id;
            $matNoaprobadas =  DB::select("SELECT
            ordi.periodo_id,
            ubiClave 'clave_ubi',
            depClave 'clave_depto',
            escClave 'clave_esc',
            progClave 'carrera',
            planClave 'clave_plan',
            aluClave 'cvePago',
            perApellido1 'apepat',
            perApellido2 'apemat',
            perNombre 'nombres',
            matClave 'cvemateria',
            matNombre 'materia',
            ordi.histCalificacion 'califinal',
            extra1.histCalificacion 'extra1',
            extra2.histCalificacion 'extra2',
            extra3.histCalificacion 'extra3',
            IFNULL(
              extra3.histFechaExamen,
              IFNULL(
                extra2.histFechaExamen,
                IFNULL(
                  extra1.histFechaExamen,
                  ordi.histFechaExamen
                )
              )
            ) 'ultimoexa'
            FROM
              bachiller_historico AS ordi
            LEFT JOIN bachiller_historico AS extra1 ON ordi.alumno_id = extra1.alumno_id
            AND ordi.bachiller_materia_id = extra1.bachiller_materia_id
            AND extra1.histTipoAcreditacion = 'X1'
            AND extra1.deleted_at IS NULL
            LEFT JOIN bachiller_historico AS extra2 ON ordi.alumno_id = extra2.alumno_id
            AND ordi.bachiller_materia_id = extra2.bachiller_materia_id
            AND extra2.histTipoAcreditacion = 'X2'
            AND extra2.deleted_at IS NULL
            LEFT JOIN bachiller_historico AS extra3 ON ordi.alumno_id = extra3.alumno_id
            AND ordi.bachiller_materia_id = extra3.bachiller_materia_id
            AND extra3.histTipoAcreditacion = 'X3'
            AND extra3.deleted_at IS NULL
            INNER JOIN alumnos ON ordi.alumno_id = alumnos.id
            INNER JOIN personas ON alumnos.persona_id = personas.id
            INNER JOIN periodos ON ordi.periodo_id = periodos.id
            INNER JOIN bachiller_materias ON ordi.bachiller_materia_id = bachiller_materias.id
            INNER JOIN planes ON bachiller_materias.plan_id = planes.id
            INNER JOIN programas ON planes.programa_id = programas.id
            INNER JOIN escuelas ON programas.escuela_id = escuelas.id
            INNER JOIN departamentos ON escuelas.departamento_id = departamentos.id
            INNER JOIN ubicacion ON departamentos.ubicacion_id = ubicacion.id
            WHERE
              ordi.deleted_at IS NULL
            AND ordi.histCalificacion < departamentos.depCalMinAprob
            AND ubicacion.ubiClave = 'CME'
            AND departamentos.depClave = 'BAC'
            AND escuelas.escClave = 'BAC'
            AND programas.progClave = 'BAC'
            AND alumnos.aluClave = $aluClave
            AND ordi.periodo_id = $periodo_id");
          @endphp
          @forelse ($matNoaprobadas as $item)
          <tr>
            <td style="width: 20px;">{{$item->cvemateria}}</td>
            <td style="width: 325px;">{{$item->materia}}</td>
            <td style="width: 71px;" align="center">{{$item->califinal}}</td>
            <td align="center">{{$item->extra1}}</td>
            <td align="center">{{$item->extra2}}</td>
            <td align="center">{{$item->extra3}}</td>
            <td align="center">{{$item->ultimoexa}}</td>
          </tr>
          @empty
          <tr>
            <td style="width: 20px; border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;"></td>
            <td style="width: 325px; border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;"></td>
            <td style="width: 71px; border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;" align="center"></td>
            <td align="center" style="border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;"></td>
            <td align="center" style="border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;"></td>
            <td align="center" style="border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;"></td>
            <td align="center" style="border-top: 1px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 1px solid;"></td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>



</body>

</html>
