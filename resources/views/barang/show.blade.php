@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="fw-bold mb-1 text-dark">Detail Barang</h4>
                    <small class="text-muted">
                        Barang <span class="mx-2">></span>
                        <a href="{{ route('barang.index') }}" class="text-decoration-none">List Data Barang</a>
                        <span class="mx-2">></span> Detail Barang
                    </small>
                </div>

                <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm px-3">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>

            </div>
        </div>
    </div>
</div>
<div class="row">
    {{-- ======================= FOTO BARANG ======================= --}}
    <div class="col-md-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            Foto Barang
        </div>

        <div class="card-body text-center">

            @if ($barang->fotoBarang)
                <a href="{{ asset('storage/' . $barang->fotoBarang) }}" target="_blank">
                    <img src="{{ asset('storage/' . $barang->fotoBarang) }}"
                         class="img-fluid rounded shadow-sm"
                         style="width: 100%; height: 300px; object-fit: cover; cursor: pointer;">
                </a>
            @else
                <p class="text-muted">Tidak ada foto</p>
            @endif

        </div>
    </div>
</div>
    {{-- ======================= DETAIL INFORMASI ======================= --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white fw-bold">
                Informasi Barang
            </div>

            <div class="card-body">

                <table class="table table-borderless">

                    <tr>
                        <th class="text-muted" style="width: 180px;">Nama Barang</th>
                        <td class="fw-bold">{{ $barang->namaBarang }}</td>
                    </tr>

                    <tr>
                        <th class="text-muted">Tahun</th>
                        <td>{{ $barang->tahun }}</td>
                    </tr>

                    <tr>
                        <th class="text-muted">Jenis Barang</th>
                        <td>{{ $barang->jenisBarang }}</td>
                    </tr>

                    <tr>
                        <th class="text-muted">Nomor NUP</th>
                        <td>{{ $barang->nomorNUP }}</td>
                    </tr>

                    <tr>
                        <th class="text-muted">Kondisi</th>
                        <td>
                            <span class="badge bg-primary px-3 py-2">
                                {{ $barang->kondisi }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th class="text-muted">Lokasi</th>
                       <td style="white-space: normal; word-wrap: break-word; max-width: 250px;">
                            {{ $barang->lokasi ?? '-' }}
                        </td>

                    </tr>

                    <tr>
                        <th class="text-muted">Koordinat</th>
                        <td>
                            @if ($barang->latitude && $barang->longitude)
                                <span class="d-block"><b>Lat:</b> {{ $barang->latitude }}</span>
                                <span class="d-block"><b>Long:</b> {{ $barang->longitude }}</span>

                                <a href="https://www.openstreetmap.org/?mlat={{ $barang->latitude }}&mlon={{ $barang->longitude }}#map=18/{{ $barang->latitude }}/{{ $barang->longitude }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="fa fa-map-marker me-1"></i> Lihat di Peta
                                </a>
                            @else
                                <span class="text-muted">Tidak ada koordinat</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">Dibuat Oleh</th>
                        <td>
                            {{ $barang->admin ? $barang->admin->nama : '-' }}
                        </td>
                    </tr>
                    <tr>
                    <th class="text-muted">Keterangan</th>
                    <td style="white-space: normal; word-wrap: break-word; max-width: 350px;">
                        {{ $barang->keterangan ?? '-' }}
                    </td>
                </tr>
                    <tr>
                        <th class="text-muted">Dibuat Pada</th>
                        <td>
                            {{ $barang->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">Terakhir Diupdate</th>
                        <td>
                            {{ $barang->updated_at->format('d M Y, H:i') }}
                        </td>
                    </tr>

                </table>

            </div>
        </div>
    </div>
</div>


{{-- ======================= MAPS PREVIEW (Opsional) ======================= --}}
@if ($barang->latitude && $barang->longitude)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-info text-white fw-bold">
                Peta Lokasi Barang
            </div>

            <div class="card-body p-0">
                <iframe
                    width="100%" height="350" style="border:0;"
                    src="https://www.openstreetmap.org/export/embed.html?bbox={{ $barang->longitude - 0.0007 }},{{ $barang->latitude - 0.0007 }},{{ $barang->longitude + 0.0007 }},{{ $barang->latitude + 0.0007 }}&layer=mapnik&marker={{ $barang->latitude }},{{ $barang->longitude }}">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
