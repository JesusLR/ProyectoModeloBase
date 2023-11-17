<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <title>@yield('template_title') | SCEM</title>
        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="SCEM">
        <meta name="author" content="Escuela Modelo">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

        {{-- FONTS-ICONS --}}
        {!! HTML::style(asset('css/material_icons.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        <!-- CORE CSS-->
        {!! HTML::style(asset('vendors/sweetalert/dist/sweetalert.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {!! HTML::style(asset('css/materialize.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {!! HTML::style(asset('css/style.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {!! HTML::style(asset('css/app.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}

        @yield('head')

        {{-- Head Scripts --}}
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>

    </head>
    <body class="mdl-color--grey-100">
        <div id="app">

            @yield('content')

        </div>
        {{-- PONER EN MAYUSCULAS --}}
        <script type="text/javascript">
            document.addEventListener('input', function (e) {
                if(!e.target.classList.contains("noUpperCase")){   
                    e.target.value = e.target.value.toUpperCase();
                }
            });
        </script>
        {{-- Scripts --}}
        {!! HTML::script(asset('js/jquery-3.2.1.min.js'), array('type' => 'text/javascript')) !!}
        {!! HTML::script(asset('js/materialize.min.js'), array('type' => 'text/javascript')) !!}
        {!! HTML::script(asset('vendors/sweetalert/dist/sweetalert.min.js'), array('type' => 'text/javascript')) !!}
        @include('partials.alerts')
        @include('scripts.close-message')

    </body>
</html>