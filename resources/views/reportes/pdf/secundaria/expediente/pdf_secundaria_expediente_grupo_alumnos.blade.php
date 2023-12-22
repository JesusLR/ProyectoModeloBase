<!DOCTYPE html>
<html>

<head>
    <title>Expediente de alumno</title>
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
            margin-top: 30px;
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
            top: -70px;
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
            width: 100%;
        }

        .table {
            border-collapse: collapse;
        }

        .table th {
            border: 1px solid #000;
        }

        .table td,
        .table th {
            padding-top: 0px;
            padding-bottom: 0px;
            padding-right: 5px;
            border: 0px solid #000;
        }

        .page-number:before {
            content: "Pág "counter(page);
        }

        .page-break {
            page-break-after: always;
        }


    </style>
</head>
@if ($tipoReporte == 1)

<body>

    <header>
        <div class="row" style="margin-top: 0px;">
            <div class="columns medium-12">
                <img class="img-header" src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">

                <h1 style="margin-top:0px; margin-bottom: 0px; text-align: center;">ESCUELA MODELO, S.C.P.</h1>
                <h3 style="margin-top:0px; margin-bottom: 0px; text-align: center;">HOJA DE DATOS GENERALES</h3>
            </div>
        </div>
    </header>
    @for ($i = 0; $i < count($alumnogrupo_collection); $i++)

        @php
            $grupoAlumnos = DB::select("call procPrimariaDatosHistoria(". $alumno_id[$i] . ")");

            $alumnogrupo_collectiosn = collect($grupoAlumnos);

            $unicoAlumnoTutores =  DB::select("call procPrimariaDatosTutores(".$alumno_id[$i].")");
            $alumnoTutor_collection = collect($unicoAlumnoTutores);
        @endphp

        @foreach ($alumnogrupo_collectiosn as $alumno)
            @foreach ($alumnogrupo_collection as $itemGrupo)
                @if ($alumno->alumno_id == $itemGrupo->alumno_id)


                    <div style="text-align: right; margin-top: -100px;">
                        <div class="cuadrado img-foto">

                        </div>
                    </div>

                    <style>
                        .cuadrado {
                            width: 70px;
                            height: 90px;
                            border: solid;
                            border-style: dotted;
                            border-width: 1px;
                            border-color: 660033;
                            background-color: cc3366;
                            font-family: verdana, arial;
                            font-size: 10pt;
                    }
                    </style>

                    <div class="row">
                        <div class="right">
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Clave: </strong>{{$alumno->aluClave}}</label>
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Curp: </strong>{{$alumno->perCurp}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Alumno: </strong>{{$alumno->perApellido1}} {{$alumno->perApellido2}} {{$alumno->perNombre}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Grado: </strong>{{$itemGrupo->grado}}° {{$itemGrupo->grupo}} DE {{$itemGrupo->progNombre}}</label>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="columns medium-12">
                            <p style="width:100%; text-align: left; border: 1px solid;"><i></i></p>
                            <br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="right">
                            <div class="l6">
                                 <p style="margin-top:0px; margin-bottom: 10px;"><strong>Apellido Parterno: </strong>{{$alumno->perApellido1}}</p>
                            </div>
                            <div class="l6">
                                 <p style="margin-top:0px; margin-bottom: 10px;"><strong>Apellido Materno: </strong>{{$alumno->perApellido2}}</p>
                            </div>
                            <div class="l6">
                                 <p style="margin-top:0px; margin-bottom: 10px;"><strong>Nombre(s): </strong>{{$alumno->perNombre}}</p>
                            </div>
                            <div class="l6">
                                <p style="margin-top:0px; margin-bottom: 10px;"><strong>Sexo (Masculino/Femenino): </strong>{{$alumno->sexo}}</p>
                            </div>
                            <div class="l6">
                                 <p style="margin-top:0px; margin-bottom: 10px;"><strong>Fecha Ingreso a la Modelo: </strong>{{$itemGrupo->fecha_registro}}</p>
                            </div>
                            <div class="l6">
                                 <p style="margin-top:0px; margin-bottom: 10px;"><strong>Grado Ingreso a la Modelo </strong>{{$itemGrupo->grado}}°</p>
                            </div>
                            <div class="l6">
                                <p style="margin-top:0px; margin-bottom: 10px;"><strong>Nivel Ingreso a la Modelo: </strong>{{$itemGrupo->progClave}}-{{$itemGrupo->progNombre}}</p>
                            </div>
                            <div class="l6">
                                 <p style="margin-top:0px; margin-bottom: 10px;"><strong>Fecha de Nacimiento: </strong>{{$alumno->perFechaNac}}</p>
                            </div>
                            <div class="l6">
                                <p style="margin-top:0px; margin-bottom: 10px;"><strong>Lugar de Nacimiento: </strong>{{$alumno->lugar_nacimiento}}</p>
                            </div>
                            <div class="l6">
                                <p style="margin-top:0px; margin-bottom: 10px;"><strong>Escuela de Procedencia: </strong>{{$alumno->escuelaProcedencia}} </p>
                            </div>
                            <div class="l6">
                                <p style="margin-top:0px; margin-bottom: 10px;"><strong>Lugar de Escuela de Proce: </strong> X </p>
                            </div>
                            <div class="l6">
                                 <p><strong>Correo del Alumno: </strong>{{$alumno->correo_escolar}}</p>
                            </div>


                        </div>
                    </div>

                    <h3 style="text-align: center">Tutores</h3>

                    <div class="row">
                        <div class="right2">
                            @forelse ($alumnoTutor_collection as $key => $itemTutor)
                            <p> <strong>Tutor {{$key+1}}: </strong> {{$itemTutor->tutNombre}} <strong>Correo: </strong>{{$itemTutor->tutCorreo}}</p>
                            @empty
                               <p>El alumno no cuenta con tutor(s) asignados</p>
                           @endforelse
                        </div>
                    </div>

                    <h3 style="text-align: center">Padres</h3>

                    <div class="row">
                        <div class="right3">
                            <label><strong>Padre: </strong>{{$alumno->nombresPadre}} {{$alumno->apellido1Padre}} {{$alumno->apellido2Padre}}</label>

                            <br>
                            <label><strong>Madre: </strong>{{$alumno->nombresMadre}} {{$alumno->apellido1Madre}} {{$alumno->apellido2Madre}}</label>

                        </div>
                    </div>


                    <br>
                    <h3 style="text-align: center">Datos generales</h3>
                    <div class="row">
                        <div class="columns medium-12">
                        <table class="table">
                            <tr>
                            <th></th>
                            <th align="center"><label>Calle/Núm:</label></th>
                            <th align="center"><label>Colonia</label></th>
                            <th align="center"><label>Cód.Post.</label></th>
                            <th align="center"><label>Población</label></th>
                            <th align="center"><label>Estado</label></th>
                            <th align="center"><label>Teléfono</label></th>
                            </tr>

                            <tr>
                                <td>
                                    <br>
                                    <p>Alumno</p>
                                    <br>
                                    <p>Padre</p>
                                    <br>
                                    <p>Madre</p>
                                </td>

                                <td align="center">
                                    @forelse ($alumnoTutor_collection as $key => $itemTutor)

                                    {{--  alumno  --}}
                                    @if ($key == 0)
                                    <br>
                                    <p>{{$itemTutor->tutCalle}}</p>
                                    @endif


                                    {{--  padre   --}}
                                    @if ($key == 0)
                                    <br>
                                    <p>{{$itemTutor->tutCalle}}</p>
                                    @endif

                                    {{--  madre   --}}
                                    @if ($key == 0)
                                    <br>
                                    <p>{{$itemTutor->tutCalle}}</p>
                                    @endif

                                    @empty
                                        <br>
                                        <p>___________________</p>
                                        <br>
                                        <p>___________________</p>
                                        <br>
                                        <p>___________________</p>
                                    @endforelse


                                </td>
                                <td align="center">

                                    <br>
                                    {{--  alumno   --}}
                                     <p>{{$alumno->perDirColonia}}</p>
                                    <br>
                                    {{--  padre   --}}
                                     <p>{{$alumno->perDirColonia}}</p>
                                    <br>
                                    {{--  madre   --}}
                                     <p>{{$alumno->perDirColonia}}</p>

                                </td>

                                <td align="center">

                                    <br>
                                    {{--  alumno   --}}
                                     <p>{{$alumno->perDirCP}}</p>
                                    <br>
                                    {{--  padre   --}}
                                     <p>{{$alumno->perDirCP}}</p>
                                    <br>
                                    {{--  madre   --}}
                                     <p>{{$alumno->perDirCP}}</p>

                                </td>


                                {{--  columna población   --}}
                                <td align="center">

                                    @forelse ($alumnoTutor_collection as $key => $itemTutor)

                                    {{--  alumno  --}}
                                    @if ($key == 0)
                                    <br>
                                    <p>{{$itemTutor->tutPoblacion}}</p>
                                    @endif


                                    {{--  padre   --}}
                                    @if ($key == 0)
                                    <br>
                                    <p>{{$itemTutor->tutPoblacion}}</p>
                                    @endif

                                    {{--  madre   --}}
                                    @if ($key == 0)
                                    <br>
                                    <p>{{$itemTutor->tutPoblacion}}</p>
                                    @endif

                                    @empty
                                        <br>
                                        <p>___________________</p>
                                        <br>
                                        <p>___________________</p>
                                        <br>
                                        <p>___________________</p>
                                    @endforelse

                                </td>

                                {{--  estado   --}}
                                <td align="center">


                                    @forelse ($alumnoTutor_collection as $key => $itemTutor)

                                    {{--  alumno  --}}
                                    @if ($key == 0)
                                    <br>
                                    <p>{{$itemTutor->tutEstado}}</p>
                                    @endif


                                    {{--  padre   --}}
                                    @if ($key == 0)
                                    <br>
                                    <p>{{$itemTutor->tutEstado}}</p>
                                    @endif

                                    {{--  madre   --}}
                                    @if ($key == 0)
                                    <br>
                                    <p>{{$itemTutor->tutEstado}}</p>
                                    @endif

                                    @empty
                                        <br>
                                        <p>___________________</p>
                                        <br>
                                        <p>___________________</p>
                                        <br>
                                        <p>___________________</p>
                                    @endforelse
                                </td>

                                <td align="center">
                                    <br>
                                    {{--  alumno   --}}
                                    <p>___________________</p>

                                    {{--  padre   --}}
                                    @if ($alumno->celularPadre != "")
                                    <br>
                                    <p>{{$alumno->celularPadre}}</p>
                                    @else
                                    <br>
                                    <p>___________________</p>
                                    @endif

                                    {{--  madre   --}}
                                    @if ($alumno->celularMadre != "")
                                    <br>
                                    <p>{{$alumno->celularMadre}}</p>
                                    @else
                                    <br>
                                    <p>___________________</p>
                                    @endif

                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>

                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="columns medium-12">
                            <p><strong>Observ/Alergias: </strong> _______________________________________________________________________________________________________________________________________ </p>
                        </div>
                    </div>


                    @if ($loop->first)
                    <footer id="footer">
                        <div class="page-number">

                        </div>
                    </footer>
                    @endif

                    @if (!$loop->last)
                        <div class="page_break"></div>
                    @endif
                @endif
            @endforeach
        @endforeach


        <style>
            .right {
                float: right;
                width: 63%;
            }
            .right2 {
                float: right;
                width: 76%;
            }

            .right3 {
                float: right;
                width: 65%;
            }
        </style>

    @endfor



</body>

@endif


{{--  formato de revision de datos   --}}
@if ($tipoReporte == 2)

<body>

    <header>
        <div class="row" style="margin-top: 0px;">
            <div class="columns medium-12">
                <img class="img-header" src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">

                <h1 style="margin-top:0px; margin-bottom: 0px; text-align: center;">ESCUELA MODELO, S.C.P.</h1>
                <h3 style="margin-top:0px; margin-bottom: 0px; text-align: center;">HOJA DE DATOS GENERALES</h3>
            </div>
        </div>
    </header>
    @for ($i = 0; $i < count($alumnogrupo_collection); $i++)

        @php
            $grupoAlumnos = DB::select("call procPrimariaDatosHistoria(". $alumno_id[$i] . ")");

            $alumnogrupo_collectiosn = collect($grupoAlumnos);

            $unicoAlumnoTutores =  DB::select("call procPrimariaDatosTutores(".$alumno_id[$i].")");
            $alumnoTutor_collection = collect($unicoAlumnoTutores);
        @endphp

        @foreach ($alumnogrupo_collectiosn as $alumno)
            @foreach ($alumnogrupo_collection as $itemGrupo)
                @if ($alumno->alumno_id == $itemGrupo->alumno_id)


                    <div style="text-align: right; margin-top: -100px;">
                        <div class="cuadrado img-foto">

                        </div>
                    </div>

                    <style>
                        .cuadrado {
                            width: 70px;
                            height: 90px;
                            border: solid;
                            border-style: dotted;
                            border-width: 1px;
                            border-color: 660033;
                            background-color: cc3366;
                            font-family: verdana, arial;
                            font-size: 10pt;
                    }
                    </style>

                    <div class="row">
                        <div class="right">
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Clave: </strong>{{$alumno->aluClave}}</label>
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Curp: </strong>{{$alumno->perCurp}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Alumno: </strong>{{$alumno->perApellido1}} {{$alumno->perApellido2}} {{$alumno->perNombre}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Grado: </strong>{{$itemGrupo->grado}}° {{$itemGrupo->grupo}} DE {{$itemGrupo->progNombre}}</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="columns medium-12">
                            <p style="width:100%; text-align: left; border: 1px solid;"><i></i></p>
                            <br>
                        </div>
                    </div>

                    <h3 style="text-align: center">Proporcione o Actualice los datos siguientes (En negritas los datos actuales).</h3>

                    <div class="row">
                        <div class="right">
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Apellido Parterno: </strong>____________________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->perApellido1}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Apellido Materno: </strong>_____________________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->perApellido2}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Nombre(s): </strong>___________________________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->perNombre}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Sexo (Masculino/Femenino): </strong>_____________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->sexo}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Fecha Ingreso a la Modelo: </strong>______________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;
                                <label>{{$itemGrupo->fecha_registro}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Grado Ingreso a la Modelo </strong>______________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;
                                <label>{{$itemGrupo->grado}}°</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Nivel Ingreso a la Modelo: </strong>_______________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$itemGrupo->progClave}}-{{$itemGrupo->progNombre}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Fecha de Nacimiento: </strong>___________________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->perFechaNac}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Lugar de Nacimiento: </strong>___________________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->lugar_nacimiento}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Escuela de Procedencia: </strong>_________________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->escuelaProcedencia}}</label>
                            </div>
                            <div class="l6">
                                <label style="margin-top:0px; margin-bottom: 10px;"><strong>Lugar de Escuela de Proce: </strong> ______________________ </label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->escuelaProcedencia}}</label>
                            </div>
                            <div class="l6">
                                <label><strong>Correo del Alumno: </strong>_____________________________</label>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->correo_escolar}}</label>
                            </div>


                        </div>
                    </div>

                    <br>
                    <h3 style="text-align: center">Tutores</h3>

                    <div class="row">
                        <div class="right2">
                            @forelse ($alumnoTutor_collection as $key => $itemTutor)
                            <label> <strong>Tutor {{$key+1}}: </strong>___________________________________ <strong>Correo: </strong>_________________</label>


                            <br><label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                {{$itemTutor->tutNombre}}
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                {{$itemTutor->tutCorreo}}</label>
                            <br>
                            @empty
                               <p class="right2">____________________________________________________</p>
                           @endforelse
                        </div>
                    </div>

                    <h3 style="text-align: center">Padres</h3>

                    <div class="row">
                        <div class="right3">
                            <label><strong>Padre: </strong>_________________________________________</label>
                            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->nombresPadre}} {{$alumno->apellido1Padre}} {{$alumno->apellido2Padre}}</label>

                            <br>
                            <label><strong>Madre: </strong>_________________________________________</label>
                            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label>{{$alumno->nombresMadre}} {{$alumno->apellido1Madre}} {{$alumno->apellido2Madre}}</label>
                        </div>
                    </div>


                    <div>
                        <h3 style="text-align: center">Datos generales</h3>
                        <div class="row">
                            <div class="columns medium-12">
                            <table class="table">
                                <tr>
                                <th></th>
                                <th align="center"><label>Calle/Núm:</label></th>
                                <th align="center"><label>Colonia</label></th>
                                <th align="center"><label>Cód.Post.</label></th>
                                <th align="center"><label>Población</label></th>
                                <th align="center"><label>Estado</label></th>
                                <th align="center"><label>Teléfono</label></th>
                                </tr>

                                <tr>
                                    <td>
                                        <br>
                                        <p>Alumno</p>
                                        <br>
                                        <br>
                                        <p>Padre</p>
                                        <br>
                                        <br>
                                        <p>Madre</p>
                                    </td>


                                    {{--  columna calle   --}}
                                    <td align="center">
                                        @forelse ($alumnoTutor_collection as $key => $itemTutor)

                                        {{--  alumno  --}}
                                        @if ($key == 0)
                                        <br>
                                        <label>___________________</label>
                                        <br><label>{{$itemTutor->tutCalle}}</label>
                                        @endif


                                        {{--  padre   --}}
                                        @if ($key == 0)
                                        <br>
                                        <br>
                                        <label>___________________</label>
                                        <br><label>{{$itemTutor->tutCalle}}</label>
                                        @endif

                                        {{--  madre   --}}
                                        @if ($key == 0)
                                        <br>
                                        <br>
                                        <label>___________________</label>
                                        <br><label>{{$itemTutor->tutCalle}}</label>
                                        @endif

                                        @empty
                                            <br>
                                            <label>___________________</label>
                                            <br>
                                            <br>
                                            <label>___________________</label>
                                            <br>
                                            <br>
                                            <label>___________________</label>
                                        @endforelse

                                    </td>

                                    {{--  columna colonia   --}}
                                    <td align="center">

                                        <br>

                                        {{--  alumno   --}}
                                        <label>___________________</label>
                                        <br><label>{{$alumno->perDirColonia}}</label>
                                        <br>
                                        <br>
                                        {{--  padre   --}}
                                        <label>___________________</label>
                                        <br><label>{{$alumno->perDirColonia}}</label>
                                        <br>
                                        <br>
                                        {{--  madre   --}}
                                        <label>___________________</label>
                                        <br><label>{{$alumno->perDirColonia}}</label>

                                    </td>

                                    {{--  columna CP   --}}
                                    <td align="center">

                                        <br>
                                        {{--  alumno   --}}
                                        <label>___________</label>
                                        <br><label>{{$alumno->perDirCP}}</label>
                                        <br>
                                        <br>
                                        {{--  padre   --}}
                                        <label>___________</label>
                                        <br><label>{{$alumno->perDirCP}}</label>
                                        <br>
                                        <br>
                                        {{--  madre   --}}
                                        <label>___________</label>
                                        <br><label>{{$alumno->perDirCP}}</label>
                                    </td>

                                    {{--  columna población   --}}
                                    <td align="center">

                                        @forelse ($alumnoTutor_collection as $key => $itemTutor)

                                        {{--  alumno  --}}
                                        @if ($key == 0)
                                        <br>
                                        <label>____________</label>
                                        <br><label>{{$itemTutor->tutPoblacion}}</label>
                                        @endif


                                        {{--  padre   --}}
                                        @if ($key == 0)
                                        <br>
                                        <br>
                                        <label>____________</label>
                                        <br><label>{{$itemTutor->tutPoblacion}}</label>
                                        @endif

                                        {{--  madre   --}}
                                        @if ($key == 0)
                                        <br>
                                        <br>
                                        <label>____________</label>
                                        <br><label>{{$itemTutor->tutPoblacion}}</label>
                                        @endif

                                        @empty
                                            <br>
                                            <p>___________________</p>
                                            <br>
                                            <p>___________________</p>
                                            <br>
                                            <p>___________________</p>
                                        @endforelse
                                    </td>

                                    {{--  estado   --}}
                                    <td align="center">
                                        @forelse ($alumnoTutor_collection as $key => $itemTutor)

                                        {{--  alumno  --}}
                                        @if ($key == 0)
                                        <br>
                                        <label>____________</label>
                                        <br><label>{{$itemTutor->tutEstado}}</label>
                                        @endif


                                        {{--  padre   --}}
                                        @if ($key == 0)
                                        <br>
                                        <br>
                                        <label>____________</label>
                                        <br><label>{{$itemTutor->tutEstado}}</label>
                                        @endif

                                        {{--  madre   --}}
                                        @if ($key == 0)
                                        <br>
                                        <br>
                                        <label>____________</label>
                                        <br><label>{{$itemTutor->tutEstado}}</label>
                                        @endif

                                        @empty
                                            <br>
                                            <label>___________________</label>
                                            <br>
                                            <br>
                                            <label>___________________</label>
                                            <br>
                                            <br>
                                            <label>___________________</label>
                                        @endforelse
                                    </td>

                                    <td align="center">
                                        <br>
                                        {{--  alumno   --}}
                                        <label>___________________</label>
                                        <br><label>{{$alumno->celularPadre}}</label>

                                        {{--  padre   --}}
                                        @if ($alumno->celularPadre != "")
                                        <br>
                                        <br>
                                        <label>___________________</label>
                                        <br><label>{{$alumno->celularPadre}}</label>
                                        @else
                                        <br>
                                        <label>___________________</label>
                                        @endif

                                        {{--  madre   --}}
                                        @if ($alumno->celularMadre != "")
                                        <br>
                                        <br>
                                        <label>___________________</label>
                                        <br><label>{{$alumno->celularMadre}}</label>
                                        @else
                                        <br>
                                        <br>
                                        <label>___________________</label>
                                        @endif

                                    </td>
                                </tr>
                            </table>
                            </div>
                        </div>
                    </div>



                    <br>

                    <div class="row">
                        <div class="columns medium-12">
                            <p><strong>Observ/Alergias: </strong> _______________________________________________________________________________________________________________________________________ </p>
                        </div>
                    </div>


                    @if ($loop->first)
                    <footer id="footer">
                        <div class="page-number">

                        </div>
                    </footer>
                    @endif

                    @if (!$loop->last)
                        <div class="page_break"></div>
                    @endif
                @endif
            @endforeach
        @endforeach


        <style>
            .right {
                float: right;
                width: 63%;
            }
            .right2 {
                float: right;
                width: 76%;
            }

            .right3 {
                float: right;
                width: 65%;
            }
        </style>

    @endfor



</body>

@endif

</html>
