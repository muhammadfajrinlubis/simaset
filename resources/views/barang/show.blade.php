@extends('layouts.app', [
    'activePage' => 'barang',
])

@section('content')

{{-- BREADCRUMB --}}
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
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="fa fa-images me-2"></i> Foto Barang
            </div>

            <div class="card-body">
                @php
                    $fotos = json_decode($barang->fotoBarang, true);
                @endphp

                @if ($fotos && is_array($fotos) && count($fotos) > 0)
                    <div class="row g-2">
                        @foreach ($fotos as $index => $foto)
                            <div class="col-6">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $foto) }}"
                                         alt="Foto {{ $index + 1 }}"
                                         class="img-fluid rounded shadow-sm border"
                                         style="width: 100%; height: 120px; object-fit: cover; cursor: pointer;"
                                         data-bs-toggle="modal"
                                         data-bs-target="#modalFoto{{ $index }}"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/120?text=No+Image';">

                                    <span class="position-absolute top-0 end-0 badge bg-dark m-1">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fa fa-info-circle me-1"></i>
                            Klik foto untuk memperbesar
                        </small>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fa fa-image text-muted" style="font-size: 48px;"></i>
                        <p class="text-muted mt-2 mb-0">Tidak ada foto</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ======================= INFORMASI BARANG ======================= --}}
    <div class="col-lg-8 col-md-12 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-success text-white fw-bold">
                <i class="fa fa-info-circle me-2"></i> Informasi Barang
            </div>


            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th class="text-muted" style="width: 180px;">Nama Barang</th>
                            <td class="fw-bold text-dark">{{ $barang->namaBarang }}</td>
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
                            <td><span class="badge bg-secondary">{{ $barang->nomorNUP }}</span></td>
                        </tr>

                        <tr>
                            <th class="text-muted">Kondisi</th>
                            <td>
                                @php
                                    $kondisiBadge = match($barang->kondisi) {
                                        'Baik' => 'success',
                                        'Rusak Ringan' => 'warning',
                                        'Rusak Berat' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $kondisiBadge }} px-3 py-2">
                                    {{ $barang->kondisi }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th class="text-muted">Lokasi</th>
                            <td style="white-space: normal; word-wrap: break-word; max-width: 400px;">
                                <i class="fa fa-map-marker-alt text-danger me-1"></i>
                                {{ $barang->lokasi ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th class="text-muted">Koordinat</th>
                            <td>
                                @if ($barang->latitude && $barang->longitude)
                                    <div class="mb-2">
                                        <span class="d-block"><b>Latitude:</b> {{ $barang->latitude }}</span>
                                        <span class="d-block"><b>Longitude:</b> {{ $barang->longitude }}</span>
                                    </div>
                                    <a href="https://www.openstreetmap.org/?mlat={{ $barang->latitude }}&mlon={{ $barang->longitude }}#map=18/{{ $barang->latitude }}/{{ $barang->longitude }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-map-marker me-1"></i> Lihat di Peta
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada koordinat</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="text-muted">Keterangan</th>
                            <td style="white-space: normal; word-wrap: break-word; max-width: 400px;">
                                {{ $barang->keterangan ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th class="text-muted">Dibuat Oleh</th>
                            <td>
                                <i class="fa fa-user me-1"></i>
                                {{ $barang->admin ? $barang->admin->nama : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th class="text-muted">Dibuat Pada</th>
                            <td>
                                <i class="fa fa-clock me-1"></i>
                                {{ $barang->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>

                        <tr>
                            <th class="text-muted">Terakhir Diupdate</th>
                            <td>
                                <i class="fa fa-edit me-1"></i>
                                {{ $barang->updated_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</div>

{{-- ======================= PETA LOKASI ======================= --}}
@if ($barang->latitude && $barang->longitude)
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-info text-white fw-bold">
                <i class="fa fa-map me-2"></i> Peta Lokasi Barang
            </div>

            <div class="card-body p-0">
                <iframe
                    width="100%"
                    height="400"
                    style="border:0;"
                    loading="lazy"
                    src="https://www.openstreetmap.org/export/embed.html?bbox={{ $barang->longitude - 0.001 }},{{ $barang->latitude - 0.001 }},{{ $barang->longitude + 0.001 }},{{ $barang->latitude + 0.001 }}&layer=mapnik&marker={{ $barang->latitude }},{{ $barang->longitude }}">
                </iframe>

                <div class="p-3 bg-light border-top">
                    <small class="text-muted">
                        <i class="fa fa-map-pin me-1"></i>
                        <strong>Koordinat:</strong> {{ $barang->latitude }}, {{ $barang->longitude }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ================= MODAL FOTO BESAR ================ --}}
@if ($fotos && is_array($fotos))
    @foreach ($fotos as $index => $foto)
        <div class="modal fade" id="modalFoto{{ $index }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">
                            <i class="fa fa-image me-2"></i>
                            Foto Barang {{ $index + 1 }} / {{ count($fotos) }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center p-4">
                        <img src="{{ asset('storage/' . $foto) }}"
                             alt="Foto {{ $index + 1 }}"
                             class="img-fluid rounded border shadow"
                             style="max-height: 70vh; object-fit: contain;"
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400?text=Foto+Tidak+Tersedia';">
                    </div>

                    <div class="modal-footer bg-light">
                        <a href="{{ asset('storage/' . $foto) }}"
                           target="_blank"
                           class="btn btn-sm btn-primary">
                            <i class="fa fa-external-link-alt me-1"></i> Buka di Tab Baru
                        </a>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

@endsection

{{-- CUSTOM STYLES --}}
@push('styles')
<style>
    .table th {
        font-weight: 600;
        padding: 0.75rem 0.5rem;
    }

    .table td {
        padding: 0.75rem 0.5rem;
    }

    .card-header {
        font-size: 1rem;
        padding: 1rem 1.25rem;
    }

    .badge {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .img-fluid:hover {
        transform: scale(1.05);
        transition: transform 0.2s ease;
    }

    iframe {
        border-radius: 0;
    }
</style>
@endpush
