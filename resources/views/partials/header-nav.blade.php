<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
      <nav class="navbar-color   darken-4">
        @php
            use App\Models\User;
            $userClave = Auth::user()->username;
        @endphp
        <div class="nav-wrapper">
              <a href="javascript:void(0);" style="color:white; float:left;" class="sidenav-trigger-show">
                  <i class="material-icons waves-effect waves-light hide-on-small-only-new" style="font-size:40px; margin: -4px 0 0 20px; position: fixed;">menu</i>
              </a>

              <div class="header-search-wrapper hide-on-med-and-down sideNav-lock">

                  <select id="menu-navegacion" class="browser-default validate select2" required name="menu-navegacion" style="width: 30%; position: relative!important; margin-top: -30px;">
                  @if (Auth::user()->idiomas == 1)
                      @include('partials.idiomas.header-idiomas')
                  @endif
                  @if (Auth::user()->departamento_sistemas == 1)
                      <!-- MATERNAL Y PREESCOLAR -->
                      @include('partials.sistemas.header-preescolar')

                      <!-- PRIMARIA -->
                      @include('partials.sistemas.header-primaria')

                      <!-- SECUNDARIA -->
                      @include('partials.sistemas.header-secundaria')

                      <!-- BACHILLER -->
                      @include('partials.sistemas.header-bachiller')


                          <!-- UNIVERSIDAD -->
                      @include('partials.sistemas.header-universidad')
                  @endif

                  @if (Auth::user()->departamento_cobranza == 1)
                      <!-- MATERNAL Y PREESCOLAR -->
                      @include('partials.cobranza.header-preescolar')

                      <!-- PRIMARIA -->
                      @include('partials.cobranza.header-primaria')

                      <!-- SECUNDARIA -->
                      @include('partials.cobranza.header-secundaria')

                      <!-- BACHILLER -->
                      @if ($userClave == "JIMENARIVERO")
                              <!-- BACHILLER -->
                              @include('partials.bachiller.header-control-escolar')
                              <!-- BACHILLER -->
                              @include('partials.bachiller.header-bachiller')
                              <!-- BACHILLER -->
                              @include('partials.bachiller.header-catalogos')
                              <!-- BACHILLER -->
                              @include('partials.bachiller.header-reportes')
                              <!-- BACHILLER -->
                              @include('partials.bachiller.header-pagos')
                      @else
                              @include('partials.cobranza.header-bachiller')
                      @endif
                          <!-- UNIVERSIDAD -->
                      @include('partials.cobranza.header-universidad')
                  @endif

                  @if (Auth::user()->departamento_control_escolar == 1)

                            <!--********* CONTROL ESCOLAR ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->
                            @include('partials.preescolar.header-control-escolar')

                            <!-- PRIMARIA -->
                            @include('partials.primaria.header-control-escolar')

                            <!-- SECUNDARIA -->
                            @include('partials.secundaria.header-control-escolar')

                            <!-- BACHILLER -->
                            @include('partials.bachiller.header-control-escolar')

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-control-escolar')


                            <!--********* MENU PARTICULAR DEL NIVEL ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->
                            @include('partials.preescolar.header-preescolar')

                            <!-- PRIMARIA -->
                            @include('partials.primaria.header-primaria')

                            <!-- SECUNDARIA -->
                            @include('partials.secundaria.header-secundaria')

                            <!-- BACHILLER -->
                            @include('partials.bachiller.header-bachiller')


                            <!--********* CATALOGOS ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->
                            @include('partials.preescolar.header-catalogos')

                            <!-- PRIMARIA -->
                            @include('partials.primaria.header-catalogos')

                            <!-- SECUNDARIA -->
                            @include('partials.secundaria.header-catalogos')

                            <!-- BACHILLER -->
                            @include('partials.bachiller.header-catalogos')

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-catalogos')

                            {{--  Extra escolares  --}}
                            @include('partials.universidad.header-extraescolares')
                            {{--  Extra escolares  --}}
                           @include('partials.preescolar.header-preescolar-extraescolares')

                           @include('partials.primaria.header-primaria-extraescolares')

                           @include('partials.secundaria.header-secundaria-extraescolares')

                            <!--********* REPORTES ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->
                            @include('partials.preescolar.header-reportes')

                            <!-- PRIMARIA -->
                            @include('partials.primaria.header-reportes')

                            <!-- SECUNDARIA -->
                            @include('partials.secundaria.header-reportes')

                            <!-- BACHILLER -->
                            @include('partials.bachiller.header-reportes')

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-reportes')

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-reportes-z-federal')


                            <!--********* PROCESOS ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->

                            <!-- PRIMARIA -->

                            <!-- SECUNDARIA -->

                            <!-- BACHILLER -->

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-procesos')


                            <!--********* PAGOS ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->
                            @include('partials.preescolar.header-pagos')

                            <!-- PRIMARIA -->
                            @include('partials.primaria.header-pagos')

                            <!-- SECUNDARIA -->
                            @include('partials.secundaria.header-pagos')

                            <!-- BACHILLER -->
                            @include('partials.bachiller.header-pagos')

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-pagos')



                            <!--********* ARCHIVOS SEP ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->

                            <!-- PRIMARIA -->

                            <!-- SECUNDARIA -->

                            <!-- BACHILLER -->

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-archivos-sep')


                            <!--********* ADMINISTRACION ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->

                            <!-- PRIMARIA -->

                            <!-- SECUNDARIA -->

                            <!-- BACHILLER -->

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-administracion')


                            <!--********* PREFECTEO ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->

                            <!-- PRIMARIA -->

                            <!-- SECUNDARIA -->

                            <!-- BACHILLER -->

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-prefecteo')


                            <!--********* GIMNASIO ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->

                            <!-- PRIMARIA -->

                            <!-- SECUNDARIA -->

                            <!-- BACHILLER -->

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-gimnasio')


                            <!--********* EDUCACION CONTINUA ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->

                            <!-- PRIMARIA -->

                            <!-- SECUNDARIA -->

                            <!-- BACHILLER -->

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-educacion-continua')

                            <!--********* TUTORIAS ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->

                            <!-- PRIMARIA -->

                            <!-- SECUNDARIA -->

                            <!-- BACHILLER -->

                            <!-- UNIVERSIDAD -->
                            @include('partials.universidad.header-servicios-externos')


                            <!--********* TUTORIAS ********************-->
                            <!-- MATERNAL Y PREESCOLAR -->

                            <!-- PRIMARIA -->

                            <!-- SECUNDARIA -->

                            <!-- BACHILLER -->

                            <!-- UNIVERSIDAD -->
                            @include('partials.tutorias.header-tutorias')
                            @include('partials.universidad.header-manual')

                      @endif

                  </select>

                  <span style="font-size: 24px; position: relative; top: 5px; text-align:center; left: 3em;">
                        Control Escolar Modelo
                        <span style="font-size:11px;">
                            (Pagos aplicados por el banco: {{UltimoPago::ultimoPago()}})
                        </span>
                  </span>

              </div>

              <ul class="right hide-on-med-and-down">
                    @php
                          $primerNombre = (explode(' ',Auth::user()->empleado->persona->perNombre));
                    @endphp
                    <li>{{ $primerNombre[0] }} {{ Auth::user()->empleado->persona->perApellido1 }} {{ Auth::user()->empleado->persona->perApellido2 }}</li>
                    <!--
                    <li>{{ Auth::user()->empleado->persona->perNombre }} {{ Auth::user()->empleado->persona->perApellido1 }} {{ Auth::user()->empleado->persona->perApellido2 }}</li>
                    -->
                    <li>
                      <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                        <i class="material-icons">more_vert</i>
                      </a>
                    </li>
              </ul>

              <!-- profile-dropdown -->
              <ul id="profile-dropdown" class="dropdown-content">
                    <!--
                    <li>
                      <a href="#" class="grey-text text-darken-1">
                        <i class="material-icons">face</i> Mi cuenta</a>
                    </li>
                    -->
                    <li>
                     {!! HTML::decode(link_to_route('cambiar_contraseña', '<i class="material-icons">account_box</i>Mi cuenta', array(), ['class' => 'grey-text text-darken-1'])) !!}
                    <li>
                     {!! HTML::decode(link_to_route('logout', '<i class="material-icons">keyboard_tab</i>Salir', array(), ['class' => 'grey-text text-darken-1'])) !!}
                    </li>
              </ul>
        </div>
      </nav>
    </div>
</header>

  <script>
    $(document).ready(function(){
      $('#main').addClass('mainPaddingSidebar');
      $('.sidenav-trigger-show').on('click',function(e){
        e.preventDefault();
        $('#left-sidebar-nav').show('slide');
        $('#main').removeClass('mainPaddingLeft');
        $('#main').addClass('mainPaddingSidebar');
      });
    });
</script>
