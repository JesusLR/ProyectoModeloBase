<!DOCTYPE html>
<html>
	<head>
		<title>Lista de faltas</title>
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
        margin-top: 105px;
        margin-left: 8px;
        margin-right: 8px;
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
        left: 0px;
        position: fixed;
        top: 15px;
        right: 0px;
        height: 3px;
        /** Extra personal styles **/

        margin-left: 8px;
        margin-right: 8px;
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
        margin-left: 0px!important;
        padding-left: 0!important;
        text-align: center;
      }
      .listas-asistencia li {
        display: inline;
        list-style-type: none;
				border: .5px solid #000;
				width: 4.5%;
				/* display: inline-block; */
      }
			.listas-asistencia li div {
				display: inline-block;
				width: 13px;
				height: 12px;
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

      .table td, .table  th {
        padding-top: 0px;
        padding-bottom: 0px;
        padding-right: 5px;
      }

      .page-number:before {
        content: "Pág " counter(page);
      }

      .punteado{

        border-top: 1px dotted;
        border-bottom: 1px dotted;
        border-right: 1px dotted;
        border-left: 1px dotted;
     }
    </style>
	</head>
  @php
      $posicion = 1;
      $posicion2 = 1;
  @endphp
  <body>
    <header>
        <div class="row">
          <div class="columns medium-4">

              <h3 style="margin-top:0px; margin-bottom: 10px;">ESCUELA PRIM. PART. INC. MODELO</h3>
              <h3 style="margin-top:0px; margin-bottom: 10px;">LISTA DE FALTAS POR GRUPO-MATERIA</h3>
              <p><b>Perído: </b> {{ $parametro_periodo }}</p>
              <p><b>Niv/Carr: </b> {{$parametro_escuela}}</p>
              <p><b>Ubicación: </b> {{$parametro_ubicacion}}</p>

              {{--  <p><b>Materia: </b> {{$parametro_materia}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Grado : {{$primaria_inscritos[0]->gpoGrado}}° Grupo: {{$primaria_inscritos[0]->gpoClave}}</p>

              @if ($primaria_inscritos[0]->matClaveAsignatura != "")
              <p><b>Asignatura: </b> {{$parametro_asignatura}}</p>
              @endif
              <br>

              <p><b>Búsqueda: </b>{{$parametro_rango_busqueda}}</p>  --}}

          </div>
          <div class="columns medium-4">
          </div>
          <div class="columns medium-4" style="text-align: right">
            <p></p>
            <p></p>
            <p>{{$fechaActual}}</p>
            <p>{{$horaActual}}</p>
            <p></p>
            <p><b>Modalidad: </b> @if ($modalidad == "P") PRESENCIAL @else VIRTUAL @endif</p>

          </div>

        </div>
      </header>

      @foreach ($agrupados as $grupos => $valores)
        @foreach ($valores as $value)
          @if ($grupos == $value->primaria_grupo_id && $posicion++ == 1)

            <div class="row">
              <div class="columns medium-8">



                  <p><b>Materia: </b> {{$value->matClave.'-'.$value->matNombre}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Grado : {{$value->gpoGrado}}° Grupo: {{$value->gpoClave}}</p>

                  @if ($value->matClaveAsignatura != "")
                  <p><b>Asignatura: </b> {{$value->matClaveAsignatura.'-'.$value->matNombreAsignatura}}</p>
                  @endif
                  <p><b>Docente: </b>{{$value->empApellido1.' '.$value->empApellido2.' '.$value->empNombre}}</p>
                  <br>

                  <p><b>Consulta: </b>{{$parametro_rango_busqueda}}</p>

              </div>

            </div>

            <br>

            <div class="row">
              <div class="columns medium-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="punteado" align="center" style="font-weight: 400; width: 20px; padding-top: 7px;"><b>Núm</b></th>
                      <th class="punteado" align="center" style="font-weight: 400; width: 50; padding-top: 7px;"><b>Clave Pago</b></th>
                      <th class="punteado" style="font-weight: 400;width: 265px; padding-top: 7px;"><b>Nombre del Alumno</b></th>
                      <th class="punteado" align="center" style="font-weight: 400;width: 60px; padding-top: 7px;"><b>Total Faltas</b></th>

                    </tr>
                  </thead>
                  <tbody>

                    @php
                    $primaria_inscritos = DB::select("SELECT
                    pi.id,
                    pg.id AS primaria_grupo_id,
                    pg.gpoGrado,
                    pg.gpoClave,
                    a.aluClave,
                    pe.perApellido1,
                    pe.perApellido2,
                    pe.perNombre,
                    p.perAnio,
                    p.perNumero,
                    p.perFechaInicial,
                    p.perFechaFinal,
                    d.depClave,
                    d.depNombre,
                    u.ubiClave,
                    u.ubiNombre,
                    pl.planClave,
                    pro.progClave,
                    pro.progNombre,
                    es.escClave,
                    es.escNombre,
                    pm.matClave,
                    pm.matNombre,
                    pma.matClaveAsignatura,
                    pma.matNombreAsignatura
                    FROM primaria_inscritos AS pi
                    INNER JOIN primaria_grupos AS pg ON pg.id = pi.primaria_grupo_id
                    AND pg.deleted_at IS NULL
                    INNER JOIN cursos AS c ON c.id = pi.curso_id
                    AND c.deleted_at IS NULL
                    INNER JOIN alumnos AS a ON a.id = c.alumno_id
                    AND a.deleted_at IS NULL
                    INNER JOIN personas AS pe ON pe.id = a.persona_id
                    AND pe.deleted_at IS NULL
                    INNER JOIN periodos AS p ON p.id = pg.periodo_id
                    AND p.deleted_at IS NULL
                    INNER JOIN departamentos AS d ON d.id = p.departamento_id
                    AND d.deleted_at IS NULL
                    INNER JOIN ubicacion AS u ON u.id = d.ubicacion_id
                    AND u.deleted_at IS NULL
                    INNER JOIN planes AS pl ON pl.id = pg.plan_id
                    AND pl.deleted_at IS NULL
                    INNER JOIN programas AS pro ON pro.id = pl.programa_id
                    AND pro.deleted_at IS NULL
                    INNER JOIN escuelas AS es ON es.id = pro.escuela_id
                    AND es.deleted_at IS NULL
                    INNER JOIN primaria_materias_asignaturas AS pma ON pma.id = pg.primaria_materia_asignatura_id
                    AND pma.deleted_at IS NULL
                    INNER JOIN primaria_materias AS pm ON pm.id = pg.primaria_materia_id
                    AND pm.deleted_at IS NULL
                    WHERE pg.id = $value->primaria_grupo_id
                    AND pi.inscTipoAsistencia = '".$modalidad."'
                    AND pi.deleted_at IS NULL
                    ORDER BY pe.perApellido1 ASC, pe.perApellido2 ASC, pe.perNombre ASC");
                    @endphp

                    @foreach ($primaria_inscritos as $primaria_inscrito)
                    <tr>
                      <td style="height: 20px;" class="punteado" align="center">{{$posicion2++}}</td>
                      <td class="punteado" align="center">{{$primaria_inscrito->aluClave}}</td>
                      <td class="punteado">{{$primaria_inscrito->perApellido1.' '.$primaria_inscrito->perApellido2.' '.$primaria_inscrito->perNombre}}</td>

                      @php
                          $cuenta_faltas = DB::select("SELECT
                          COUNT(pa.estado) AS total_faltas
                          FROM primaria_asistencia AS pa
                          INNER JOIN primaria_inscritos pi ON pi.id = pa.asistencia_inscrito_id
                          AND pi.deleted_at IS NULL
                          INNER JOIN primaria_grupos AS pg ON pg.id = pi.primaria_grupo_id
                          AND pg.deleted_at IS NULL
                          INNER JOIN cursos AS c ON c.id = pi.curso_id
                          AND c.deleted_at IS NULL
                          INNER JOIN alumnos AS a ON a.id = c.alumno_id
                          AND a.deleted_at IS NULL
                          INNER JOIN personas AS pe ON pe.id = a.persona_id
                          WHERE pg.id = $primaria_inscrito->primaria_grupo_id
                          AND a.aluClave = $primaria_inscrito->aluClave
                          AND pa.fecha_asistencia >= '".$fechaInicio."'
                          AND pa.fecha_asistencia <= '".$fechaFin."'
                          AND pa.estado = 'F'
                          AND pe.deleted_at IS NULL");
                      @endphp

                      <td class="punteado" align="center">
                        @if ($cuenta_faltas[0]->total_faltas != 0)
                          {{$cuenta_faltas[0]->total_faltas}}
                        @else

                        @endif

                      </td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

          @endif




        @endforeach
        @php
          $posicion = 1;
          $posicion2 = 1;
        @endphp
        @if ($loop->first)
        <footer id="footer">
          <div class="page-number"></div>
        </footer>
        @endif
        @if (!$loop->last)
          <div class="page_break"></div>
        @endif
      @endforeach



  </body>
</html>
