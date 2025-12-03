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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

<!-- JS -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/misc.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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


</body>
</html>

