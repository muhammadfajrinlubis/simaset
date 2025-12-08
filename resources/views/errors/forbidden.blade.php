@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="alert alert-danger text-center p-4 shadow-sm">
        <h3 class="fw-bold"><i class="mdi mdi-alert-circle-outline"></i> Akses Ditolak</h3>
        <p class="mt-2">
            Anda harus <strong>login terlebih dahulu</strong> untuk mengakses halaman ini.
        </p>

        <a href="{{ route('login') }}" class="btn btn-primary mt-3">
            <i class="mdi mdi-login"></i> Login Sekarang
        </a>
    </div>
</div>
@endsection
