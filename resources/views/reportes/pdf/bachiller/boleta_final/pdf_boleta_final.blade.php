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
      font-size: 10px;
      margin-top: 40px;
      /* ALTURA HEADER */
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
      width: 97%;
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

  @php
      $posi1 = 1;
      use Illuminate\Support\Arr;
      use App\Http\Helpers\Utils;
  @endphp

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

  @php
      $eviProcesoObte = 0;
      $eviProcesoMax = 0;
      $eviProductoObte = 0;
      $eviProductoMax = 0;
      $eviFinalObte = 0;
      $eviFinalMax = 0;
      $faltas = 0;
      $NombreAlumno = "";
      $fechaBoleta = "";
      $gradoGrupo = "";
      $vueltas = 1;
      
  @endphp

  @foreach ($alumno as $aluClave => $valoresAlu)
    @foreach ($valoresAlu as $item)
        @if ($aluClave == $item->aluClave && $posi1++ == 1)
          <div class="row">
            <div class="columns medium-4">
              <p><b>Clave: {{$item->aluClave}} </b></p>
              <p><b>Alumno: {{$item->perApellido1.' '.$item->perApellido2.' '.$item->perNombre}}</b></p>         
              @php
                $NombreAlumno = $item->perApellido1.' '.$item->perApellido2.' '.$item->perNombre;
              @endphp   
            </div>
            {{--  <div class="columns medium-2">
              
            </div>  --}}
            <div class="columns medium-4" style="text-align: center">
              <p><b>Clav.Plan: {{$item->planClave}} </b></p>
              <p><b>Ubicación: {{$item->ubiClave}} </b></p>
            </div>
            {{--  <div class="columns medium-2">
              
            </div>  --}}
            <div class="columns medium-4" style="text-align: right">
              <p><b>Fecha: {{$fechaActual}} </b></p>
              <p><b>Grupo: {{$item->semestre.' '.$item->grupo}} 
                @if($item->curEstado == "P") (Pre) @endif
                @if($item->curEstado == "C" || $item->curEstado == "A") (Con) @endif
              </b></p>

              @php
              $fechaBoleta = $fechaActual;
              $gradoGrupo = $item->semestre.' '.$item->grupo;
              @endphp
            </div>
          </div>

          <br>
          <div class="row">
            <div class="columns medium-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="border-top: 1px solid; border-bottom: 0px solid; border-right: 0px solid; border-left: 0px solid;"></th>
                    <th colspan="2" style="border-top: 1px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></th>
                    {{--  <th style="border-top: 1px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></th>  --}}
                    <th align="center" colspan="2" style="width: 25px; border-top: 1px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">Ev. Proces</th>
                    <th style="border-top: 1px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></th>
                    <th align="center" colspan="2" style="width: 48px; border-top: 1px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">Ev. Produc</th>
                    <th style="border-top: 1px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></th>
                    <th align="center" colspan="2" style="width: 49px; border-top: 1px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">Calif. Final</th>
                    <th style="border-top: 1px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></th>
                    <th align="center" style="width: 10px; border-top: 1px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">Tot</th>
                  </tr>

                  <tr>
                    <th style="border-top: 0px solid; border-bottom: 1px solid; border-right: 0px solid; border-left: 0px solid;"></th>
                    <th align="center" style="border-top: 0px solid; border-bottom: 1px solid; border-left: 0px solid; border-right: 0px solid;">ASIGNATURAS</th>
                    <th align="right"  style="border-top: 0px solid; border-bottom: 1px solid; border-left: 0px solid; border-right: 0px solid;">Puntos =></th>
                    <th align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 0px solid; border-right: 0px solid;">Obte</th>
                    <th align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 0px solid; border-right: 0px solid;">Max</th>
                    <td align="center" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></td>
                    <th align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 0px solid; border-right: 0px solid;">Obte</th>
                    <th align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 0px solid; border-right: 0px solid;">Max</th>
                    <td align="center" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></td>
                    <th align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 0px solid; border-right: 0px solid;">Obte</th>
                    <th align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 0px solid; border-right: 0px solid;">Max</th>
                    <td align="center" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></td>
                    <th align="center" style="border-top: 1px solid; border-bottom: 1px solid; border-left: 0px solid; border-right: 0px solid;">Falt</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                      $agrupamosPorIdMateria = $valoresAlu->groupBy('bachiller_materia_id');
                  @endphp                              
                  @foreach ($agrupamosPorIdMateria as $mater_id => $valoresMateria )
                    @foreach ($valoresMateria as $itemMateria)
                      @php
                        $puntos = DB::select("SELECT 
                        bachiller_inscritos_evidencias.id,
                        bachiller_inscritos_evidencias.ievPuntos AS puntosObtenidos,
                        bachiller_inscritos_evidencias.ievFaltas AS faltas,
                        bachiller_evidencias.eviNumero,
                        bachiller_evidencias.eviPuntos as puntosMaximos,
                        bachiller_evidencias.eviTipo,
                        bachiller_inscritos.id AS bachiller_inscrito_id,
                        bachiller_inscritos.curso_id,
                        bachiller_inscritos.bachiller_grupo_id,
                        bachiller_inscritos.insCalificacionParcial1,
                        bachiller_inscritos.insFaltasParcial1,
                        bachiller_inscritos.insCalificacionParcial2,
                        bachiller_inscritos.insFaltasParcial2,
                        bachiller_inscritos.insCalificacionParcial3,
                        bachiller_inscritos.insFaltasParcial3,
                        bachiller_inscritos.insCalificacionFinal,
                        bachiller_inscritos.insPromedioParcial,
                        bachiller_inscritos.insPuntosObtenidosCorte1,
                        bachiller_inscritos.insPuntosObtenidosCorte2,
                        bachiller_inscritos.insPuntosObtenidosCorte3,
                        bachiller_inscritos.insPuntosMaximosCorte1,
                        bachiller_inscritos.insPuntosMaximosCorte2,
                        bachiller_inscritos.insPuntosMaximosCorte3,
                        bachiller_inscritos.insPuntosObtenidosAcumulados,
                        bachiller_inscritos.insPuntosMaximosAcumulados,
                        alumnos.id AS alumno_id,
                        alumnos.aluClave,
                        personas.perApellido1,
                        personas.perApellido2,
                        personas.perNombre,
                        bachiller_grupos.gpoClave,
                        bachiller_grupos.gpoGrado,
                        bachiller_grupos.gpoMatComplementaria,
                        bachiller_grupos.bachiller_materia_acd_id,
                        bachiller_grupos.bachiller_materia_id,
                        bachiller_materias.matClave,
                        bachiller_materias.matNombre,
                        periodos.perAnio,
                        periodos.perNumero,
                        periodos.perFechaInicial,
                        periodos.perFechaFinal,
                        bachiller_empleados.empApellido1,
                        bachiller_empleados.empApellido2,
                        bachiller_empleados.empNombre,
                        planes.planClave,
                        ubicacion.ubiClave,
                        cgt.cgtGradoSemestre as semestre,
                        cgt.cgtGrupo as grupo            
                        FROM bachiller_inscritos_evidencias AS bachiller_inscritos_evidencias
                        INNER JOIN bachiller_inscritos ON bachiller_inscritos.id = bachiller_inscritos_evidencias.bachiller_inscrito_id
                        INNER JOIN bachiller_evidencias ON bachiller_evidencias.id = bachiller_inscritos_evidencias.evidencia_id
                        INNER JOIN cursos ON cursos.id = bachiller_inscritos.curso_id
                        INNER JOIN alumnos ON alumnos.id = cursos.alumno_id
                        INNER JOIN personas ON personas.id = alumnos.persona_id
                        INNER JOIN bachiller_grupos ON bachiller_grupos.id = bachiller_inscritos.bachiller_grupo_id
                        INNER JOIN bachiller_materias ON bachiller_materias.id = bachiller_grupos.bachiller_materia_id
                        LEFT JOIN bachiller_materias_acd ON bachiller_materias_acd.id = bachiller_grupos.bachiller_materia_acd_id
                        INNER JOIN periodos ON periodos.id = bachiller_grupos.periodo_id
                        LEFT JOIN bachiller_empleados ON bachiller_empleados.id = bachiller_grupos.empleado_id_docente
                        INNER JOIN departamentos ON departamentos.id = periodos.departamento_id
                        INNER JOIN planes ON planes.id = bachiller_grupos.plan_id
                        INNER JOIN programas ON programas.id = planes.programa_id
                        INNER JOIN cgt ON cgt.id = cursos.cgt_id
                        INNER JOIN ubicacion ON ubicacion.id = departamentos.ubicacion_id                        
                        WHERE bachiller_inscritos_evidencias.bachiller_inscrito_id = $itemMateria->id
                        AND bachiller_inscritos.deleted_at IS NULL
                        AND bachiller_evidencias.deleted_at IS NULL
                        AND cursos.deleted_at IS NULL
                        AND alumnos.deleted_at IS NULL
                        AND personas.deleted_at IS NULL
                        AND bachiller_grupos.deleted_at IS NULL
                        AND periodos.deleted_at IS NULL
                        AND departamentos.deleted_at IS NULL
                        AND planes.deleted_at IS NULL
                        AND bachiller_inscritos_evidencias.deleted_at IS NULL
                        AND programas.deleted_at IS NULL");
                    

                        foreach($puntos as $punto){
                          if($punto->bachiller_materia_id = $itemMateria->bachiller_materia_id && $punto->eviTipo == "A"){
                            $eviProcesoObte = $eviProcesoObte + $punto->puntosObtenidos;
                          }
                          
                          if($punto->bachiller_materia_id = $itemMateria->bachiller_materia_id && $punto->eviTipo == "P"){
                            $eviProductoObte = $eviProductoObte + $punto->puntosObtenidos;
                          }

                          if($punto->bachiller_materia_id = $itemMateria->bachiller_materia_id && $punto->eviTipo == "A"){
                            $eviProcesoMax = $eviProcesoMax + $punto->puntosMaximos;
                          }

                          if($punto->bachiller_materia_id = $itemMateria->bachiller_materia_id && $punto->eviTipo == "P"){
                            $eviProductoMax = $eviProductoMax + $punto->puntosMaximos;
                          }
                          #Obteber las faltas del alumno por materia
                          $faltas = $faltas + $punto->faltas;
                        }

                        

                     


                        #Obteber los puntos finales sumados 

                        $eviFinalObte = $eviProcesoObte + $eviProductoObte;

                        $eviFinalMax = $eviProcesoMax + $eviProductoMax;
                      @endphp
                    @endforeach
                    @foreach ($valoresMateria->unique('bachiller_materia_id') as $ico)
                      @if ($mater_id == $ico->bachiller_materia_id && $ico->aluClave == $aluClave)
                      <tr>
                        <td style="width:50px; border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">{{$ico->matClave}}</td>
                        <td style="width: 300px; border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">{{$ico->matNombre}}</td>
                        <td style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></td>
                        
                        <td align="right" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">{{number_format((float)$eviProcesoObte, 1, '.', '')}}</td>

                        <td align="right" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">{{number_format((float)$eviProcesoMax, 1, '.', '')}}</td>

                        <td align="center" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></td>

                        <td align="right" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">{{number_format((float)$eviProductoObte, 1, '.', '')}}</td>

                        <td align="right" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">{{number_format((float)$eviProductoMax, 1, '.', '')}}</td>

                        <td align="center" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></td>

                        <td align="right" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">{{number_format((float)$eviFinalObte, 0, '.', '')}}</td>

                        <td align="right" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">{{number_format((float)$eviFinalMax, 0, '.', '')}}</td>

                        <td align="center" style="width 1px;border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;"></td>

                        <td align="right" style="border-top: 0px solid; border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid;">
                          @if ($faltas != 0)
                            {{$faltas}}
                          @else
                              
                          @endif
                        </td>
                      </tr>
                      @php
                          $eviProcesoObte = 0;
                          $eviProcesoMax = 0;
                          $eviProductoObte = 0;
                          $eviProductoMax = 0;
                          $eviFinalObte = 0;
                          $eviFinalMax = 0;
                          $faltas = 0;
                      @endphp
                      @endif                      
                    @endforeach                  
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          

          <br><br>
          <div class="row">
            <div class="columns medium-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <td style="width: 20px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 0px solid;"></td>
                    <th style="width: 325px;border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 0px solid;">ASIGNATURAS NO ACREDITADAS</th>
                    <th align="center" style="border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 0px solid;">Sem</th>
                    <th style="width: 71px; border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 0px solid;" align="center">C.F.</th>                    
                    <th align="center" style="border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 0px solid;">Opor1</th>
                    <th align="center" style="border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 0px solid;">Opor2</th>
                    <th align="center" style="border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 0px solid;">Opor3</th>
                    <th align="center" style="border-top: 1px solid; border-right: 0px solid; border-bottom: 1px solid; border-left: 0px solid;">Ult. Examen</th>
                  </tr>          
                </thead>
                <tbody>
                  @php

                              
                  $ubiClave = $item->ubiClave;
                  $aluClave = $item->aluClave;
                  $plan_id = $item->plan_id;
                  $alumno_id = $item->alumno_id;


                 

                  $matNoaprobadas = DB::select("SELECT
                  ordi.periodo_id,
                  ordi.bachiller_materia_id,
                  ubiClave 'clave_ubi',
                  depClave 'clave_depto',
                  escClave 'clave_esc',
                  progClave 'carrera',
                  planClave 'clave_plan',
                  aluClave 'cvePago',
                  perApellido1 'apepat',
                  perApellido2 'apemat',
                  perNombre 'nombres',
                  matSemestre 'matSem',
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
                  AND extra1.histTipoAcreditacion IN ('X1', 'O1')
                  AND extra1.deleted_at IS NULL
                  LEFT JOIN bachiller_historico AS extra2 ON ordi.alumno_id = extra2.alumno_id
                  AND ordi.bachiller_materia_id = extra2.bachiller_materia_id
                  AND extra2.histTipoAcreditacion IN ('X2', 'O2')
                  AND extra2.deleted_at IS NULL
                  LEFT JOIN bachiller_historico AS extra3 ON ordi.alumno_id = extra3.alumno_id
                  AND ordi.bachiller_materia_id = extra3.bachiller_materia_id
                  AND extra3.histTipoAcreditacion IN ('X3', 'O3')
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
                  AND ubicacion.ubiClave = '".$ubiClave."'
                  AND departamentos.depClave = 'BAC'
                  AND escuelas.escClave = 'BAC'
                  AND programas.progClave = 'BAC'
                  AND ordi.plan_id = $plan_id
                  AND ordi.alumno_id = $alumno_id
                  AND ordi.bachiller_materia_id NOT IN(1077, 998, 1067, 1075, 1076, 1012, 1712, 1069, 1286, 1769, 1986, 1288, 1070, 1770, 1988,
                  1770, 1959, 1259, 1024, 1078, 1778, 1781, 1081, 1080, 1780, 1943, 1702, 1243, 1002, 1253, 1016, 1953, 1716, 1088, 1251, 1304, 1073, 
                  1317, 1292, 1080, 1324, 1077, 1096, 1299, 1051, 1083, 1072, 1011, 1047, 1079, 1025, 1086, 1082, 1073, 1096, 1087, 1094, 1085, 1092, 
                  1083, 1058, 1025, 1090, 1088, 1002, 1095, 1086, 1028, 1028, 1084, 1091, 1082, 1057, 1089, 999, 1087, 1085, 1792, 1767, 1732, 1767, 
                  1774, 1725, 1770, 1721, 1795, 1795, 1728, 1770, 1735, 1759, 1791, 1766, 1724, 1759, 1699, 1773, 1787, 1762, 1713, 1713, 1794, 1769, 
                  1794, 1762, 1769, 1702, 1758, 1709, 1790, 1765, 1716, 1758, 1698, 1765, 1772, 1786, 1712, 1726, 1757, 1796, 1757, 1796, 1736)");

                    $buscar_alumno3 = collect($matNoaprobadas);
                    $buscar_alumno4 = $buscar_alumno3->groupBy('bachiller_materia_id');
                 
                  @endphp

                  @forelse ($buscar_alumno4 as $bachiller_materia_id => $valores)
                    @foreach ($valores as $item)
                        @if ($bachiller_materia_id == $item->bachiller_materia_id && $vueltas++ == 1)
                        <tr>
                          <td style="width: 20px;">{{$item->cvemateria}}</td>
                          <td style="width: 325px;">{{$item->materia}}</td>
                          <td align="center">{{$item->matSem}}</td>
                          <td style="width: 71px;" align="center">{{$item->califinal}}</td>                          
                          <td align="center">{{$item->extra1}}</td>
                          <td align="center">{{$item->extra2}}</td>
                          <td align="center">{{$item->extra3}}</td>
                          <td align="center">{{Utils::fecha_string($item->ultimoexa, 'mesCorto')}}</td>
                        </tr>
                        @endif                        
                    @endforeach
                    @php
                            $vueltas = 1;
                        @endphp
                  @empty
                  <tr>
                    <td style="width: 20px; border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;"></td>
                    <td style="width: 325px; border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;"></td>
                    <td align="center" style="border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;"></td>
                    <td style="width: 71px; border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;" align="center"></td>
                    <td align="center" style="border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;"></td>
                    <td align="center" style="border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;"></td>
                    <td align="center" style="border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;"></td>
                    <td align="center" style="border-top: 0px solid; border-right: 0px solid; border-bottom: 0px solid; border-left: 0px solid;"></td>
                  </tr>
                  
                                  
                  @endforelse   
                  @php
                    $plan_id = "";
                  @endphp     
                    
                </tbody>
              </table>
            </div>
          </div>

          <br><br>

             

          @php
          $plan_id = "";
          @endphp
          <div class="row">
            <div class="columns medium-6">
              <p>Termina información de:</p>
              <p>Clave: {{$aluClave}}</p>
              <p>Alumno: {{$NombreAlumno}}</p>
            </div>
            <div class="columns medium-6">
              
            </div>
            <div class="columns medium-6" style="text-align: right;">
              <p>Fecha: {{$fechaBoleta}}</p>
              <p>Grupo: {{$gradoGrupo}}
            </div>
          </div>
        @endif
    @endforeach  
    @php
        $posi1 = 1;
        $NombreAlumno = "";
        $fechaBoleta = "";
        $gradoGrupo = "";
    @endphp    
    @if (!$loop->last)
      <div class="page_break"></div>
    @endif
  @endforeach
</body>

</html>