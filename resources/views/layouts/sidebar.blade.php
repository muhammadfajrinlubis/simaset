<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">

    <!-- Profile -->
    <li class="nav-item nav-profile not-navigation-link">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
           <img src="{{ asset('assets/images/faces/logosupm.png') }}"
     alt="profile image"
     style="width: 50px; height: 50px; object-fit: cover;">
          </div>

          <div class="text-wrapper">
            <p class="profile-name">
                {{ Auth::check() ? Auth::user()->nama : 'Tamu' }}
            </p>


            <div class="dropdown" data-display="static">
              <a href="#" class="nav-link d-flex user-switch-dropdown-toggler"
                 id="UsersettingsDropdown" data-toggle="dropdown" aria-expanded="false">
                <small class="designation text-muted">Admin</small>
                <span class="status-indicator online"></span>
              </a>

              <div class="dropdown-menu" aria-labelledby="UsersettingsDropdown">
                <a class="dropdown-item">Manage Accounts</a>
                <a class="dropdown-item">Change Password</a>
                <a class="dropdown-item">Check Inbox</a>
                <a class="dropdown-item">Sign Out</a>
              </div>
            </div>
          </div>
        </div>
    </li>

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
      <a class="nav-link" href="{{ url('/') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <!--        BARANG           -->
   <li class="nav-item {{ request()->is('barang*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('barang.index') }}">
        <i class="menu-icon mdi mdi-package-variant"></i>
        <span class="menu-title">Barang</span>
    </a>
</li>

    <!-- END MENU BARANG -->
  </ul>
</nav>
