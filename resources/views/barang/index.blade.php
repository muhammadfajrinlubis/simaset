@extends('layouts.app')

@section('content')

{{-- Header Card --}}
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-1">List Data Barang</h4>
                    <small class="text-muted">
                        Barang <span class="mx-2">></span>
                        <a href="{{ route('barang.index') }}" class="text-decoration-none">List Data Barang</a>
                    </small>
                </div>

                <div class="d-flex align-items-center" style="gap: 10px;">
                {{-- Button Download --}}
                <a href="#" class="btn btn-success btn-sm px-3 d-flex align-items-center">
                    <i class="fa fa-download me-2"></i>
                    Download Data
                </a>

                {{-- Button Tambah Barang --}}
                <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm px-3 d-flex align-items-center">
                    <i class="fa fa-plus-circle me-2"></i>
                    Tambah Barang
                </a>
            </div>

            </div>
        </div>
    </div>
</div>


{{-- Table Card --}}
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- Alert --}}
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif


                {{-- ============================ --}}
                {{-- SEARCH BAR - DITAMBAHKAN DI SINI --}}
                {{-- ============================ --}}
                <form action="{{ route('barang.index') }}" method="GET" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control" placeholder="Cari nama barang / lokasi / kondisi...">
                        </div>

                        <div class="col-md-auto">
                            <button class="btn btn-success">
                                <i class="fa fa-search"></i> Cari
                            </button>
                        </div>

                        <div class="col-md-auto">
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                                <i class="fa fa-refresh"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
                {{-- ============================ --}}
                {{-- END SEARCH BAR --}}
                {{-- ============================ --}}


                {{-- Data Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Barang</th>
                                <th>Tahun</th>
                                <th>Jenis Barang</th>
                                <th>Nomor NUP</th>
                                <th>Kondisi</th>
                                <th>Lokasi</th>
                                {{-- <th>Dibuat Oleh</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
@foreach ($barang as $i => $b)
<tr class="text-center">

    {{-- No --}}
    <td>{{ $i + 1 }}</td>

    {{-- Foto --}}
    <td>
        @if ($b->fotoBarang)
            <img src="{{ asset('storage/' . $b->fotoBarang) }}" width="60" class="rounded">
        @else
            <small class="text-muted">Tidak ada</small>
        @endif
    </td>

    {{-- Nama --}}
    <td>{{ $b->namaBarang }}</td>

    {{-- Tahun --}}
    <td>{{ $b->tahun }}</td>

    {{-- Jenis --}}
    <td>{{ $b->jenisBarang }}</td>

    {{-- NUP --}}
    <td>{{ $b->nomorNUP }}</td>

    {{-- Kondisi --}}
    <td>{{ $b->kondisi }}</td>

    {{-- Lokasi + Google Maps --}}
    <td>
        <strong>{{ $b->lokasi }}</strong><br>

        @if ($b->latitude && $b->longitude)
            <a href="https://www.google.com/maps/place/{{ $b->latitude }},{{ $b->longitude }}"
               target="_blank" class="btn btn-sm btn-outline-primary mt-1">
               Lihat di Google Maps
            </a>
            <br>

            {{-- embed map --}}
            <iframe
                width="200"
                height="120"
                style="border:0; margin-top:5px;"
                loading="lazy"
                allowfullscreen
                src="https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={{ $b->latitude }},{{ $b->longitude }}&zoom=17">
            </iframe>
        @else
            <small class="text-muted">Tidak ada koordinat</small>
        @endif

    </td>

    {{-- Nama Admin --}}
    {{-- <td>{{ $b->admin_nama ?? 'Tidak tersedia' }}</td> --}}

    {{-- Aksi --}}
    <td>
        <a href="#" class="btn btn-warning btn-sm">
            Edit
        </a>
        <a href="#" class="btn btn-danger btn-sm">
            Hapus
        </a>
    </td>
</tr>
@endforeach
</tbody>

                        {{-- tempat data nanti --}}
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
