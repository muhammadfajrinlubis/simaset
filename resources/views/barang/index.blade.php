@extends('layouts.app', [
    'activePage' => 'barang',
])

@section('content')

{{-- ========================== HEADER ========================== --}}
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

                @auth
                <div class="d-flex align-items-center gap-2">

                   <a href="{{ route('barang.export.excel') }}"
                    class="btn btn-success btn-sm px-3 d-flex align-items-center">
                        <i class="fa fa-download me-2"></i> Download Data
                    </a>


                    {{-- Button Tambah --}}
                    <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm px-3 d-flex align-items-center">
                        <i class="fa fa-plus-circle me-2"></i> Tambah Barang
                    </a>

                </div>
                @endauth

            </div>
        </div>
    </div>
</div>
{{-- ========================== TABLE WRAPPER ========================== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- ALERT --}}
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif


                {{-- ========================== SEARCH BAR ========================== --}}
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
                        <div class="col-md-2">
                        <select name="per_page" class="form-select" onchange="this.form.submit()">
                            <option value="5"  {{ request('per_page') == 1  ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    </div>
                </form>
                {{-- ========================== TABLE ========================== --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Tahun</th>
                                <th>Jenis Barang</th>
                                <th>Nomor NUP</th>
                                <th>Kondisi</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($barang as $i => $b)
                        <tr class="text-center">

                            <td>{{ $barang->firstItem() + $i }}</td>
                            <td>{{ $b->namaBarang }}</td>
                            <td>{{ $b->tahun }}</td>
                            <td>{{ $b->jenisBarang }}</td>
                            <td>{{ $b->nomorNUP }}</td>
                            <td class="text-center">
                                @php
                                    $warna = 'secondary';

                                    if ($b->kondisi === 'Baru') {
                                        $warna = 'success';   // hijau
                                    } elseif ($b->kondisi === 'Berfungsi') {
                                        $warna = 'warning';   // kuning
                                    } elseif ($b->kondisi === 'Rusak') {
                                        $warna = 'danger';    // merah
                                    }
                                @endphp

                                <span class="badge bg-{{ $warna }} px-3 py-2" style="font-size: 0.85rem;">
                                    {{ $b->kondisi }}
                                </span>

                            </td>
                            <td class="text-center align-middle">

                                {{-- Lokasi: tampil turun ke bawah dan tidak melewati tabel --}}
                                <div class="fw-bold text-dark mb-1"
                                    title="{{ $b->lokasi }}"
                                    style="
                                        max-width: 180px;
                                        max-height: 70px;
                                        white-space: normal;
                                        word-break: break-word;
                                        overflow-y: auto;
                                        padding: 3px;
                                        margin: 0 auto;
                                        line-height: 1.4;
                                    ">
                                    {{ $b->lokasi }}
                                </div>

                                @if ($b->latitude && $b->longitude)

                                    {{-- Tombol buka peta --}}
                                    <a href="https://www.openstreetmap.org/?mlat={{ $b->latitude }}&mlon={{ $b->longitude }}#map=18/{{ $b->latitude }}/{{ $b->longitude }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary mt-1">
                                        <i class="mdi mdi-map-marker"></i> Peta
                                    </a>

                                    {{-- Mini Map --}}
                                    <div class="rounded overflow-hidden mt-2 shadow-sm"
                                        style="
                                            width: 150px;
                                            height: 100px;
                                            border: 1px solid #ddd;
                                            margin: auto;
                                        ">
                                        <iframe
                                            width="100%"
                                            height="100%"
                                            style="border:0;"
                                            loading="lazy"
                                            src="https://www.openstreetmap.org/export/embed.html?bbox={{ $b->longitude - 0.0005 }},{{ $b->latitude - 0.0005 }},{{ $b->longitude + 0.0005 }},{{ $b->latitude + 0.0005 }}&layer=mapnik&marker={{ $b->latitude }},{{ $b->longitude }}">
                                        </iframe>
                                    </div>

                                @else
                                    <small class="text-muted">Tidak ada koordinat</small>
                                @endif

                                </td>
                                 {{-- AKSI --}}
                                <td class="text-center">
                                    {{-- Detail --}}
                                    <a href="{{ route('barang.show', $b->id) }}"
                                        class="btn btn-info btn-sm"
                                        title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>

                                    @auth
                                    {{-- Edit --}}
                                    <a href="{{ route('barang.edit', $b->id) }}"
                                        class="btn btn-warning btn-sm"
                                        title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#hapusModal{{ $b->id }}"
                                        title="Hapus">
                                        <i class="mdi mdi-trash-can"></i>
                                    </button>

                                    {{-- Modal Hapus --}}
                                    <div class="modal fade" id="hapusModal{{ $b->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <p>Yakin ingin menghapus <b>{{ $b->namaBarang }}</b> ?</p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                                                    <form action="{{ route('barang.destroy', $b->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @endauth
                                </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- PAGINATION --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $barang->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
