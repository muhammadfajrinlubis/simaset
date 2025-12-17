<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

<li class="nav-item nav-profile not-navigation-link">
    <div class="nav-link profile-container">
        <div class="user-wrapper d-flex align-items-center">

            <!-- PROFILE IMAGE -->
            <div class="profile-image">
                <img src="{{ asset('/images/logo.png') }}" alt="Profile">
            </div>

            <!-- USER TEXT -->
            <div class="text-wrapper ms-2">
                <p class="profile-name mb-0">
                    {{ Auth::check() ? Auth::user()->nama : 'Tamu' }}
                </p>
                <small class="designation text-muted">
                    Sistem Informasi Aset
                </small>
            </div>

        </div>
    </div>
</li>

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="menu-icon mdi mdi-television"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>


    <li class="nav-item {{ request()->is('barang*') ? 'active' : 'barang' }}">
      <a class="nav-link" href="{{ route('barang.index') }}">
        <i class="menu-icon mdi mdi-package-variant"></i>
        <span class="menu-title">Barang</span>
      </a>
    </li>

  </ul>
</nav>
