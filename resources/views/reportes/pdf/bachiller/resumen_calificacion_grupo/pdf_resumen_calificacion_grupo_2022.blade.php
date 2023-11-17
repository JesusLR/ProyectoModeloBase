<!DOCTYPE html>
<html>

<head>
    <title>Res. calificaciones por grupo</title>
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
            margin-top: 80px;
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

    @php
        $posi1 = 1;
    @endphp

    <header>
        <div class="row" style="margin-top: 0px;">
            <div class="columns medium-12">

                {{--  <img class="img-header" src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">  --}}
                <h3 style="margin-top:0px; margin-bottom: 0px;">Preparatoria "ESCUELA MODELO"</h3>
                <h3 style="margin-top:0px; margin-bottom: 0px;">RESUMEN DE CALIFICACIONES POR GRUPO</h3>


                <p>Período: {{ $cicloEscolar }}</p>
                <p>Niv/Carr: {{ $nivel }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $grupo }}</p>
                <p>Ubica.: {{ $ubicacion }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Calif.Min.Aprob:
                    {{ $aprobatorio }}</p>
                <p>Calificaciones finales del período. Inscritos, preinscritos y condicionados </p>

            </div>
        </div>
    </header>

    @php
        $contador1 = 1;
        $contador2 = 1;
        $contador3 = 1;
        $contador4 = 1;
        $contador5 = 1;
        $total = 1;
        $sumaPromedioVerticales = 0;
        $sumaPromedioHorizontal = 0;
        $totalAlumnoVertical = 0;
        $totalMateriasAlumno = 0;
    @endphp

    <div class="row">
        <div class="columns medium-12">
            <table class="table" style="font-size: 8px;">
                <thead>
                    <tr>
                        <td align="center" style="width: 15px;">Num</td>
                        <td align="center" style="width: 50px;">Cva Pago</td>
                        <td>Nombre del alumno</td>
                        @foreach ($bachiller_materias as $bachiller_materia_id => $valores)
                            @foreach ($valores as $item)
                                @if ($bachiller_materia_id == $item->bachiller_materia_id && $contador1++ == 1)
                                    <td align="center" style="width: 50px;">{{ substr($item->matNombre, 0, 7) }}</td>
                                @endif
                            @endforeach
                            @php
                                $contador1 = 1;
                            @endphp
                        @endforeach

                        {{--  materias acd   --}}
                        @foreach ($bachiller_materias_acd as $materias_acd_id => $valoresMateriasACD)
                            @foreach ($valoresMateriasACD as $itemAcd)
                                @if ($materias_acd_id == $itemAcd->bachiller_materia_acd_id && $contador3++ == 1)
                                    <td align="center" style="width: 50px;">
                                        {{ substr($itemAcd->gpoMatComplementaria, 0, 7) }}
                                        {{ substr($itemAcd->gpoMatComplementaria, 9, 7) }}</td>
                                @endif
                            @endforeach
                            @php
                                $contador3 = 1;
                            @endphp
                        @endforeach
                        <td align="center">Promed.</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tablaBody as $itemssss => $value)
                        <tr>
                            <td align="center">{{ $contador2++ }}</td>
                            <td align="center">{{ $value['aluClave'] }}</td>
                            <td align="">{{ $value['alumno'] }}</td>

                            @foreach ($bachiller_materias as $bachiller_materia_id => $valores)
                                <td align="center">
                                    @isset($value[$bachiller_materia_id . '_materia_id'])
                                        @if ($bachiller_materia_id == $value[$bachiller_materia_id . '_materia_id'])
                                            @if ($value[$bachiller_materia_id . '_calif'] < $aprobatorio)
                                                <b>{{ $value[$bachiller_materia_id . '_calif'] }}</b>
                                            @else
                                                {{ $value[$bachiller_materia_id . '_calif'] }}
                                            @endif

                                            @php
                                                $sumaPromedioHorizontal = $sumaPromedioHorizontal + $value[$bachiller_materia_id . '_calif'];
                                                
                                                $totalMateriasAlumno++;
                                            @endphp
                                        @endif
                                    @endisset

                                </td>
                            @endforeach

                            {{--  materias acd   --}}
                            @foreach ($bachiller_materias_acd as $materias_acd_id => $valoresMateriasACD)
                                @foreach ($tablaBodyAcd as $itemACDMat)
                                    @isset($itemACDMat[$materias_acd_id . '_materia_acd_id'])
                                        @if (
                                            $materias_acd_id == $itemACDMat[$materias_acd_id . '_materia_acd_id'] &&
                                                $value['aluClave'] == $itemACDMat['aluClave'] &&
                                                $contador4++ == 1)
                                            @if ($itemACDMat[$materias_acd_id . '_calif'] < $aprobatorio)
                                                <td align="center"><b>{{ $itemACDMat[$materias_acd_id . '_calif'] }}</b></td>
                                            @else
                                                <td align="center">{{ $itemACDMat[$materias_acd_id . '_calif'] }}</td>
                                            @endif
                                            @php
                                                $sumaPromedioHorizontal = $sumaPromedioHorizontal + $itemACDMat[$materias_acd_id . '_calif'];
                                                $totalMateriasAlumno++;
                                            @endphp
                                        @else
                                        @endif
                                    @endisset
                                @endforeach
                                @php
                                    $contador4 = 1;
                                @endphp
                            @endforeach

                            <td align="center">
                                @if ($sumaPromedioHorizontal != 0)
                                    {{ number_format((float) ($sumaPromedioHorizontal / $totalMateriasAlumno), 3, '.', '') }}
                                @else
                                @endif

                            </td>

                            @php
                                $sumaPromedioHorizontal = 0;
                                $totalMateriasAlumno = 0;
                            @endphp

                        </tr>
                    @endforeach


                    <tr>
                        <td align="center" style="width: 15px;"></td>
                        <td align="center" style="width: 50px;"></td>
                        <td>Promedios del grupo</td>
                        @foreach ($bachiller_materias as $materiaIDPromedio => $valoresPromedio)
                            @foreach ($tablaBody as $itemssss => $value)
                                @isset($value[$materiaIDPromedio . '_calif'])
                                    @if ($value[$materiaIDPromedio . '_materia_id'] == $materiaIDPromedio)
                                        @php
                                            $sumaPromedioVerticales = $sumaPromedioVerticales + $value[$materiaIDPromedio . '_calif'];
                                            
                                            $totalAlumnoVertical++;
                                        @endphp
                                    @endif
                                @endisset
                            @endforeach


                            <td align="center" style="width: 50px;">
                                @if ($sumaPromedioVerticales != 0)
                                    {{ number_format((float) ($sumaPromedioVerticales / $totalAlumnoVertical), 3, '.', '') }}
                                @else
                                @endif

                            </td>

                            @php
                                $sumaPromedioVerticales = 0;
                                $totalAlumnoVertical = 0;
                            @endphp
                        @endforeach


                        @foreach ($bachiller_materias_acd as $materias_acd_id => $valoresMateriasACD)
                            @foreach ($tablaBodyAcd as $itemACDMat)
                                @isset($itemACDMat[$materias_acd_id . '_materia_acd_id'])
                                    @if ($materias_acd_id == $itemACDMat[$materias_acd_id . '_materia_acd_id'])
                                        @php
                                            $sumaPromedioVerticales = $sumaPromedioVerticales + $itemACDMat[$materias_acd_id . '_calif'];
                                            
                                            $totalAlumnoVertical++;
                                        @endphp
                                    @endif
                                @endisset
                            @endforeach

                            {{--  materias acd   --}}
                            <td align="center">
                                {{ number_format((float) ($sumaPromedioVerticales / $totalAlumnoVertical), 3, '.', '') }}
                            </td>
                            @php
                                $contador5 = 1;
                                $totalAlumnoVertical = 0;
                                $sumaPromedioVerticales = 0;
                            @endphp
                        @endforeach



                        <td align="center"></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>


</body>

</html>
