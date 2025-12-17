<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

    {{-- BRAND LOGO --}}
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="logo">
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
            <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo">
        </a>
    </div>

    {{-- NAVBAR RIGHT --}}
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

        {{-- TOGGLE SIDEBAR --}}
        <button class="navbar-toggler align-self-center" type="button" id="toggleSidebar">
            <span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">

            {{-- IF NOT LOGIN --}}
            <div class="d-flex justify-content-center align-items-center">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endguest
            </div>

            {{-- IF LOGIN --}}
            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-bs-toggle="dropdown">
                        <span class="profile-text d-none d-md-inline-flex">{{ Auth::user()->nama }}</span>
                        <img class="img-xs rounded-circle"
                             src="{{ Auth::user()->avatar ?? asset('assets/images/faces/profil.png') }}">
                    </a>

                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown">
                        <div class="dropdown-header">
                            <i class="mdi mdi-account-circle me-2"></i>
                            {{ Auth::user()->nama }}
                            <small class="d-block">{{ Auth::user()->email }}</small>
                        </div>

                        <a class="dropdown-item"><i class="mdi mdi-account"></i> Profil Saya</a>
                        <a class="dropdown-item"><i class="mdi mdi-account-edit"></i> Edit Profil</a>
                        <a href="{{ route('admin.editPassword', auth()->user()->id) }}" class="dropdown-item">
                            <i class="mdi mdi-lock-reset"></i> Ubah Password
                        </a>


                        <a class="dropdown-item"><i class="mdi mdi-cog"></i> Pengaturan</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item text-danger"
                           href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-logout"></i> Keluar
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>@csrf</form>
                    </div>
                </li>
            @endauth
        </ul>

        {{-- MOBILE MENU --}}
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                id="toggleMobileSidebar">
            <span class="mdi mdi-menu"></span>
        </button>

    </div>
</nav>
