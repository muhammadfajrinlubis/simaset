<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
    Simaset - {{ Auth::check() ? Auth::user()->nama : 'Guest' }}
    </title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Plugin CSS -->
    <style>
        /* Container */
    .profile-container {
        padding: 8px 12px;
    }

    /* Wrapper */
    .user-wrapper {
        display: flex;
        align-items: center;
    }

    /* Profile Image */
    .profile-image img {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;   /* agar tidak gepeng */
        box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        border: 2px solid #fff;
    }

    /* Username */
    .profile-name {
        font-size: 15px;
        font-weight: 600;
        color: #2c2c2c;
    }

    /* Small text */
    .designation {
        font-size: 12px;
    }

    </style>

    <link rel="stylesheet" href="{{ asset('assets/plugins/@mdi/font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Additional Plugin Styles -->
    @stack('plugin-styles')

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('style')
</head>

<body data-base-url="{{ url('/') }}">
<div id="app" class="container-scroller">

    {{-- Header --}}
    @include('layouts.header')

    <div class="container-fluid page-body-wrapper">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Panel --}}
        <div class="main-panel">
            <div class="content-wrapper">

                {{-- Page Content --}}
                @yield('content')

            </div>

            {{-- Footer --}}
            @include('layouts.footer')

        </div>
    </div>

</div>

<!-- JS Core -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/misc.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- TAMBAHKAN INI - Untuk memuat Chart.js dan plugin lainnya --}}
@stack('plugin-scripts')

{{-- TAMBAHKAN INI - Untuk memuat custom scripts dari page --}}
@stack('custom-scripts')

<script>
document.addEventListener("DOMContentLoaded", function () {

    // DESKTOP MINIMIZE
    document.getElementById("toggleSidebar").addEventListener("click", function () {
        document.body.classList.toggle("sidebar-icon-only");
    });

    // MOBILE TOGGLE
    document.getElementById("toggleMobileSidebar").addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("active");
    });

});
</script>


{{-- Login Success Alert --}}
@if (session('login_success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Login Berhasil!',
        text: "{{ session('login_success') }}",
        timer: 1800,
        showConfirmButton: false
    });
</script>
@endif

{{-- Logout Success Alert --}}
@if (session('logout_success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Logout Berhasil!',
        text: "{{ session('logout_success') }}",
        timer: 1800,
        showConfirmButton: false
    });
</script>
@endif

@stack('scripts')

</body>
</html>
