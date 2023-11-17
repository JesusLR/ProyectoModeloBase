<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">

        <title>@yield('template_title') | SCEM</title>
        {{-- CSRF TOKEN --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="SCEM">
        <meta name="author" content="Escuela Modelo">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

        {{-- FONTS-ICONS --}}
        {!! HTML::style(asset('css/material_icons.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {{-- CSS CORE --}}
        {!! HTML::style(asset('css/materialize.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {!! HTML::style(asset('css/style.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {{-- CSS PLUGINS --}}
        {!! HTML::style(asset('vendors/perfect-scrollbar/perfect-scrollbar.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {!! HTML::style(asset('vendors/jvectormap/jquery-jvectormap.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {!! HTML::style(asset('vendors/flag-icon/css/flag-icon.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {!! HTML::style(asset('vendors/sweetalert/dist/sweetalert.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {{-- CSS CUSTOM --}}
        {!! HTML::style(asset('css/select2.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {!! HTML::style(asset('css/app.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
        {{-- JS CORE --}}
        {!! HTML::script(asset('js/jquery-3.2.1.min.js'), array('type' => 'text/javascript')) !!}
        {!! HTML::script(asset('js/materialize.min.js'), array('type' => 'text/javascript')) !!}
        {{-- JS PRISM --}}
        {!! HTML::script(asset('vendors/prism/prism.js'), array('type' => 'text/javascript')) !!}
        {{-- JS SCROLLBAR --}}
        {!! HTML::script(asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js'), array('type' => 'text/javascript')) !!}
        {{-- JS CHART --}}
        {!! HTML::script(asset('vendors/chartjs/chart.min.js'), array('type' => 'text/javascript')) !!}
        {{-- JS PLUGINS --}}
        {!! HTML::script(asset('js/plugins.js'), array('type' => 'text/javascript')) !!}
        {{-- JS SWEETALERT 2 --}}
        {!! HTML::script(asset('vendors/sweetalert/dist/sweetalert.min.js'), array('type' => 'text/javascript')) !!}
        {!! HTML::script(asset('js/select2.min.js'), array('type' => 'text/javascript')) !!}
        {{-- CSS LAYOUT --}}
        
        @yield('head')

        {{-- Head Scripts --}}
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
            var base_url = '{!! url("") !!}';
            var ubicacion_id = {!! Auth::user()->empleado->escuela->departamento->ubicacion->id !!};
            var departamento_id = {!! Auth::user()->empleado->escuela->departamento->id !!};
            var escuela_id = {!! Auth::user()->empleado->escuela->id !!};
        </script>
        {{-- Clases para el menu main --}}
        <style>
            .mainPaddingSidebar{
                padding-left:240px;
            }
            .mainPaddingLeft{
                padding-left:0px;
            }
        </style>


        <style>
            @media only screen and (max-width: 992px) {
                .hide-on-small-only-new, .hide-on-small-and-down {
                  display: none !important;
                }
              }
        </style>
    </head>
    <body>
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>

        @include('partials.header-nav')

        <div id="main">
            <div class="wrapper">
                @include('partials.drawer-nav')
                <section id="content">
                    <div class="container">
                        <nav id="nav-breadcrumb">
                            <div class="nav-wrapper">
                                <div class="col s12">
                                    @yield('breadcrumbs')
                                </div>
                            </div>
                        </nav>
                        <div class="container">
                            @yield('content')
                        </div>
                    </div>
                </section>
            </div>
        </div>

        {{-- PONER EN MAYUSCULAS --}}
        <script type="text/javascript">
            document.addEventListener('input', function (e) {
                var input_type = e.target.type;
                var id = e.target.id
                var ids = ["depTituloDoc", "depNombreDoc", "depPuestoDoc","depIncorporadoA","perCorreo1","progTituloOficial","progClaveEgre","matNombreOficial","edoNombre"
                ,"edoAbrevia","paisNombre","paisAbrevia","munNombre","contNombre","conbNombre","conbAbreviatura","tutCorreo", "avisoprivacidad", "observacion_contenido", "observacionAlumno"];
                if(input_type != "radio" && ids.indexOf(id) == -1){
                    if(!e.target.classList.contains("noUpperCase")){
                        e.target.value = e.target.value.toUpperCase();
                    }
                }//if
            });
            document.addEventListener('textarea', function (e) {
                e.target.value = e.target.value.toUpperCase();
            });
        </script>
        {{-- DESHABILITAR ENTER EN FORMULARIOS --}}
        <script>
            function disableEnterKey(e){
                var key;
                if(window.event){
                    key = window.event.keyCode; //IE
                }else{
                    key = e.which; //firefox
                }
                if(key==13){
                    return false;
                }else{
                    return true;
                }
            }
        </script>

        <script>
        var search = $("#menu-navegacion");
            search.select2({
                allowClear: true,
                minimumInputLength: 3,
                maximumSelectionSize: 1,
                escapeMarkup: function(m) { return m; },
            });



            $("#menu-navegacion").on("change", function (e) {
                e.preventDefault()
                window.location = e.target.value;
            })
        </script>


        @include('partials.alerts')
        @include('scripts.confirm-delete')
        @include('scripts.personas_autorizadas')
        @include('scripts.close-message')
        @include('scripts.select')
        {{-- JS LAYOUT --}}
        @yield('footer_scripts')
    </body>
</html>