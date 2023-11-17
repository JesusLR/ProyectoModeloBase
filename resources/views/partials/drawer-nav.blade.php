<aside id="left-sidebar-nav" class="nav-expanded nav-lock nav-collapsible navbar-fixed">
    <div class="brand-sidebar">
        <center>
            <img src="{{ asset('images/logo-blanco.png') }}" width="25%" height="25%">
            <a href="javascript:void(0);" style="color:white; float:left;" class="sidenav-trigger-hide hide-on-small-only-new">
                <i class="material-icons waves-effect waves-light" style="font-size:40px; margin: 8px 0 0 20px; position: fixed;">menu</i>
            </a>
        </center>
    </div>
    @php
        use App\Models\User;
        use App\Http\Helpers\ClubdePanchito;
        use App\Http\Helpers\SuperUsuario;

        $userMaternal = Auth::user()->maternal;
        $userPreescolar = Auth::user()->preescolar;
        $userPrimaria = Auth::user()->primaria;
        $userSecundaria = Auth::user()->secundaria;
        $userBachiller = Auth::user()->bachiller;
        $userSuperior = Auth::user()->superior;
        $userPosgrado = Auth::user()->posgrado;
        $userEduContinua = Auth::user()->educontinua;
        $userCobranza = Auth::user()->departamento_cobranza;
        $userCME = Auth::user()->campus_cme;
        $userCVA = Auth::user()->campus_cva;
        $userCCH = Auth::user()->campus_cch;
        $userSistemas = Auth::user()->departamento_sistemas;
        $userCobranza = Auth::user()->departamento_cobranza;
        $userControlEscolar = Auth::user()->departamento_control_escolar;
        $userClave = Auth::user()->username;
    @endphp

    <ul id="slide-out" class="side-nav fixed leftside-navigation sidenav">
        <li class="no-padding">
            <ul class="collapsible" data-collapsible="accordion">

                @if (Auth::user()->departamento_sistemas == 1)
                    {{--  maternal y preescolar --}}
                    @include('partials.sistemas.menu-preescolar')

                    {{--  primaria --}}
                    @include('partials.sistemas.menu-primaria')

                    {{--  secundaria   --}}
                    @include('partials.sistemas.menu-secundaria')

                    {{--  bachiller   --}}
                    @include('partials.sistemas.menu-bachiller')


                    {{--  universidad   --}}
                    @include('partials.sistemas.menu-universidad')

                @endif

                @if (Auth::user()->departamento_cobranza == 1)
                        {{--  maternal y preescolar --}}
                        @include('partials.cobranza.menu-preescolar')

                        {{--  primaria --}}
                        @include('partials.cobranza.menu-primaria')

                        {{--  secundaria   --}}
                        @include('partials.cobranza.menu-secundaria')


                        @if ($userClave == "JIMENARIVERO")
                                {{--  Control Escolar para bachiller   --}}
                                @include('partials.bachiller.menu-control-escolar')
                                {{-- menu para bachiller  --}}
                                @include('partials.bachiller.menu-bachiller')
                                {{-- fin menu bachiller  --}}
                                @include('partials.bachiller.menu-reportes')
                        @else
                                {{--  bachiller   --}}
                                @include('partials.cobranza.menu-bachiller')
                        @endif


                        {{--  universidad   --}}
                        @include('partials.cobranza.menu-universidad')

                        @include('partials.universidad.menu-extraescolares')

                @endif

                @if (Auth::user()->departamento_control_escolar == 1)

                        {{--  Control Escolar para preescolar --}}
                        {{-- @include('partials.preescolar.menu-control-escolar')--}}
                        {{--  Catalogos --}}
                        @include('partials.preescolar.menu-catalogos')
                        {{--  Fin Catalogos  --}}
                        {{--  Menú para preescolar   --}}
                        @include('partials.preescolar.menu-preescolar')
                        {{--  Fin Menú para preescolar   --}}
                        {{--  Reportes  --}}
                        @include('partials.preescolar.menu-reportes')


                        {{--  Control Escolar para primaria --}}
                        @include('partials.primaria.menu-control-escolar')
                        {{--  Menú para primaria   --}}
                        @include('partials.primaria.menu-primaria')
                        {{--  Fin Menú para primaria   --}}
                        @include('partials.primaria.menu-reportes')

                        {{--  Control Escolar para secundaria   --}}
                        @include('partials.secundaria.menu-control-escolar')
                        {{-- menu para secundaria  --}}
                        @include('partials.secundaria.menu-secundaria')
                        {{-- fin menu secundaria  --}}
                        @include('partials.secundaria.menu-reportes')


                        {{--  Control Escolar para bachiller   --}}
                        @include('partials.bachiller.menu-control-escolar')
                        {{-- menu para bachiller  --}}
                        @include('partials.bachiller.menu-bachiller')
                        {{-- fin menu bachiller  --}}
                        @include('partials.bachiller.menu-reportes')


                        {{--  Control Escolar para universidad   --}}
                        {{--  Catalogos --}}
                        @include('partials.universidad.menu-catalogos')
                        {{--  Fin Catalogos  --}}
                        @include('partials.universidad.menu-control-escolar')
                        {{--  Fin Control Escolar  --}}
                        @include('partials.universidad.menu-reportes')
                        {{--  Fin Reportes   --}}
                        @include('partials.universidad.menu-reportes-z-federal')
                        {{--  Fin Reportes federal   --}}
                        {{--  Procesos  --}}
                        @include('partials.universidad.menu-procesos')
                        {{--  Fin Procesos --}}
                        {{--  Pagos  --}}
                        @include('partials.universidad.menu-pagos')
                        {{--  Fin Pagos --}}
                        {{--  Archivos SEP  --}}
                        @include('partials.universidad.menu-archivos-sep')
                        {{--  Fin Archivos SEP --}}
                        {{--  Administración  --}}
                        @include('partials.universidad.menu-administracion')
                        {{--  Fin Administración --}}
                        {{--  Prefecteo  --}}
                        @include('partials.universidad.menu-prefecteo')
                        {{--  Fin Prefecteo --}}
                        {{--  Gimnasio  --}}
                        @include('partials.universidad.menu-gimnasio')
                        {{--  Fin Gimnasio --}}
                        {{-- Educacion Continua --}}
                        @include('partials.universidad.menu-educacion-continua')
                        {{--  Fin Educacion Continua --}}
                        {{-- Reprobados / Opciones por terminar --}}
                        {{--
                            @include('partials.universidad.menu-reprobados')
                        --}}
                        {{-- Servicios Externos --}}
                        @include('partials.universidad.menu-servicios-externos')
                        {{-- menu de tutorias  --}}
                        @include('partials.tutorias.menu-tutorias')

                        {{--  Extra escolares  --}}
                        {{--  Extra escolares  --}}
                        {{--  @include('partials.preescolar.menu-preescolar-extraescolares')  --}}
                        {{--  @include('partials.primaria.menu-primaria-extraescolares')  --}}
                        {{--  @include('partials.secundaria.menu-secundaria-extraescolares')  --}}
                        {{--  @include('partials.universidad.menu-extraescolares')  --}}
                        @include('partials.universidad.menu-manual')



                @endif

                @if (Auth::user()->idiomas == 1)
                    {{--  idiomas   --}}
                    @include('partials.sistemas.menu-idiomas')
                @endif

                @if (Auth::user()->gimnasio == 1)
                    {{--  gimnasio   --}}
                    @include('partials.sistemas.menu-gimnasio')
                @endif

                @if (Auth::user()->natacion == 1)
                    {{--  gimnasio   --}}
                    @include('partials.sistemas.menu-natacion')
                @endif

            </ul>
        </li>
    </ul>

    {{-- <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only gradient-45deg--cyan gradient-shadow">
        <i class="material-icons">menu</i>
    </a> --}}
    <a href="#" data-activates="slide-out" style="margin-top: -12px; background-color: #01579E " class="sidebar-collapse btn-floating btn-medium waves-effect waves-light gradient-45deg--cyan gradient-shadow hide-on-large-only">
        <i class="material-icons">menu</i>
        </a>
</aside>

<script>
    $(document).ready(function(){
      $('.sidenav-trigger-hide').on('click',function(e){
        e.preventDefault();
        $('#left-sidebar-nav').hide('slide');
        $('#main').removeClass('mainPaddingSidebar');
        $('#main').addClass('mainPaddingLeft');
      });
    });
</script>
