<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ url('/') }}">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
            <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo">
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

       <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
    <span class="mdi mdi-menu"></span>
</button>

        <ul class="navbar-nav navbar-nav-right">
            <!-- User -->
        <li class="nav-item dropdown d-none d-xl-inline-block">

            @guest
                <!-- Jika belum login -->
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3">
                    <i class="mdi mdi-login"></i> Login
                </a>
            @endguest

            @auth
                <!-- Jika sudah login -->
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown">
                    <span class="profile-text d-none d-md-inline-flex">
                        {{ Auth::user()->nama }}
                    </span>

                    <img class="img-xs rounded-circle"
                        src="{{ asset('assets/images/faces/face8.jpg') }}"
                        alt="Profile image">
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <a class="dropdown-item mt-2">Manage Accounts</a>
                    <a class="dropdown-item">Change Password</a>
                    <a class="dropdown-item">Check Inbox</a>

                    <a class="dropdown-item"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sign Out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @endauth

        </li>

        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu icon-menu"></span>
        </button>
    </div>
</nav>
