@extends('layouts.app', [
    'activePage' => 'barang',
])

@section('content')

{{-- ================= HEADER ================= --}}
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Tambah Data Barang</h4>
                    <small class="text-muted">
                        Barang <span class="mx-2">></span>
                        <a href="{{ route('barang.create') }}" class="text-decoration-none">Tambah Data Barang</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= FORM CARD ================= --}}
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">

            {{-- Card Header --}}
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="mdi mdi-plus-box-outline me-2"></i> Tambah Data Barang
                </h5>
                <a href="{{ url('/barang') }}" class="btn btn-light btn-sm">
                    <i class="mdi mdi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card-body">

                {{-- Alert Error --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- ================= FORM ================= --}}
                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ========= BARIS 1 (2 kolom) ========= --}}
                    <div class="row">
                        {{-- Nama Barang --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Barang</label>
                            <input type="text" name="namaBarang" class="form-control"
                                   placeholder="Nama Barang" required>
                        </div>

                        {{-- Tahun --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tahun</label>
                            <input type="number" name="tahun" class="form-control"
                                   placeholder="Contoh: 2020" required>
                        </div>
                    </div>

                    {{-- ========= BARIS 2 (2 kolom) ========= --}}
                    <div class="row">
                        {{-- Jenis Barang --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Barang</label>
                            <input type="text" name="jenisBarang" class="form-control"
                                   placeholder="Elektronik / Furnitur" required>
                        </div>

                        {{-- Nomor NUP --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nomor NUP</label>
                            <input type="text" name="nomorNUP" class="form-control"
                                   placeholder="Nomor NUP" required>
                        </div>
                    </div>

                    {{-- ========= BARIS 3 (2 kolom) ========= --}}
                    <div class="row">
                        {{-- Kondisi --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kondisi Barang</label>
                            <input type="text" name="kondisi" class="form-control"
                                   placeholder="Baik / Rusak Ringan / Rusak Berat" required>
                        </div>

                        {{-- Lokasi otomatis --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Lokasi Barang (Otomatis)</label>

                            <input type="text" id="alamat" name="lokasi"
                                class="form-control bg-light" readonly placeholder="Mendeteksi lokasi...">

                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">

                            <small class="text-muted">Lokasi akan terisi otomatis menggunakan GPS browser.</small>
                        </div>
                    </div>

                    {{-- ========= BARIS 4 (1 kolom penuh) ========= --}}
                    <div class="row">
                        {{-- Foto Barang --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Foto Barang</label>

                            <div class="border rounded p-3 text-center bg-light"
                                 style="cursor:pointer;"
                                 onclick="document.getElementById('fotoBarang').click();">

                                <img id="previewImage"
                                     src="https://via.placeholder.com/150?text=Preview"
                                     class="img-fluid mb-2"
                                     style="max-height:160px; border-radius:6px; object-fit:cover;">

                                <div>
                                    <i class="fa fa-upload text-primary"></i>
                                    <p class="mt-2 mb-0 text-muted">Klik untuk memilih foto barang</p>
                                </div>
                            </div>

                            <input type="file" name="fotoBarang" id="fotoBarang"
                                   class="d-none" accept="image/*"
                                   onchange="previewFoto(this)">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="mdi mdi-content-save-outline me-1"></i> Simpan Data
                        </button>
                    </div>

                </form>
                {{-- =============== END FORM =============== --}}

            </div>
        </div>
    </div>
</div>

{{-- ============== SCRIPT PREVIEW FOTO ============== --}}
<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('previewImage').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<script>
// Saat halaman dibuka → ambil lokasi otomatis
document.addEventListener("DOMContentLoaded", function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    } else {
        alert("Browser tidak mendukung GPS.");
    }
});

function successCallback(position) {
    let lat = position.coords.latitude;
    let lon = position.coords.longitude;

    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lon;

    // Ambil alamat dari API Reverse Geocoding (OpenStreetMap)
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("alamat").value = data.display_name;
        })
        .catch(err => {
            console.log(err);
            document.getElementById("alamat").value = "Gagal mengambil alamat";
        });
}

function errorCallback(error) {
    console.log(error);
    alert("Tidak bisa mendeteksi lokasi. Pastikan GPS aktif & izinkan lokasi.");
}
</script>


@endsection
