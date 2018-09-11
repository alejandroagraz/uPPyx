<!-- Main Header -->
<header class="main-header">

    <!-- Header Navbar -->
    <nav class="navbar banner-uppyx navbar-static-top" role="navigation">
        <div class="navbar-inner">
            <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo@1x.png') }}" alt="uPPyx">
                </a>
            </div>

            <div class="navbar-collapse collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-left">

                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())

                    @elseif(\Entrust::hasRole('super-admin'))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle drop-admin-actions font-bold" data-toggle="dropdown" role="button" aria-expanded="false">
                                Acciones <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/list-admin-rental') }}">Car Rentals</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ url('/list-user-rental') }}">Usuarios</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ url('/rental-request-list') }}">Histórico de Request</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ url('/rental-request-pending') }}">Rentas por Finalizar</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle drop-admin-actions font-bold" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if (isset(Auth::user()->profile_picture))
                                    @php
                                        $url = Storage::disk('s3')->url('userProfile/' . Auth::user()->profile_picture);
                                    @endphp
                                    <img src="{{ $url }}" class="user-image" alt="User Image"> {{ Auth::user()->name }} <span class="caret"></span>
                                @else
                                    <img src="{{ asset('images/default-300x300.png') }}" class="user-image" alt="User Image"> {{ Auth::user()->name }} <span class="caret"></span>
                                @endif
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/user-profile') }}">Perfil</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ route('configurations.index') }}">Configuraciones</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ route('rates.index') }}">Tarifas de Vehículos</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ url('/list-charges') }}">Cargos por Vehículo</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ url('/list-log') }}">Logs</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Salir
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                    @elseif(\Entrust::hasRole('rent-admin'))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle drop-agent-actions font-bold" data-toggle="dropdown" role="button" aria-expanded="false">
                                Acciones <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/list-agent') }}">Agentes</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ url('/list-rental-request') }}">Histórico de Request</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ url('/rental-request-pending') }}">Rentas por Finalizar</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle drop-agent-actions font-bold" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if (isset(Auth::user()->profile_picture))
                                    @php
                                        $url = Storage::disk('s3')->url('userProfile/' . Auth::user()->profile_picture);
                                    @endphp
                                    <img src="{{ $url }}" class="user-image" alt="User Image"> {{ Auth::user()->name }} <span class="caret"></span>
                                @else
                                    <img src="{{ asset('images/default-300x300.png') }}" class="user-image" alt="User Image"> {{ Auth::user()->name }} <span class="caret"></span>
                                @endif
                                    @if (isset(Auth::user()->rentalAgencies->name))
                                        <span class="text-rental">{{Auth::user()->rentalAgencies->name}}</span>
                                    @else
                                        <span class="text-rental">&nbsp;</span>
                                    @endif
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/user-profile') }}">Perfil</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        Salir
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                    @elseif(\Entrust::hasRole('user'))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle drop-admin-actions font-bold" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if (isset(Auth::user()->profile_picture))
                                    @php
                                        $url = Storage::disk('s3')->url('userProfile/' . Auth::user()->profile_picture);
                                    @endphp
                                    <img src="{{ $url }}" class="user-image" alt="User Image"> {{ Auth::user()->name }} <span class="caret"></span>
                                @else
                                    <img src="{{ asset('images/default-300x300.png') }}" class="user-image" alt="User Image"> {{ Auth::user()->name }} <span class="caret"></span>
                                @endif
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                    @elseif(\Entrust::hasRole('agent'))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle drop-admin-actions font-bold" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if (isset(Auth::user()->profile_picture))
                                    @php
                                        $url = Storage::disk('s3')->url('userProfile/' . Auth::user()->profile_picture);
                                    @endphp
                                    <img src="{{ $url }}" class="user-image" alt="User Image"> {{ Auth::user()->name }} <span class="caret"></span>
                                @else
                                    <img src="{{ asset('images/default-300x300.png') }}" class="user-image" alt="User Image"> {{ Auth::user()->name }} <span class="caret"></span>
                                @endif
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        </div>
    </nav>

</header>