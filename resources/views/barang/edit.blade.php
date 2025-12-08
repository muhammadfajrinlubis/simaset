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
                    <h4 class="fw-bold text-dark mb-1">Edit Data Barang</h4>
                    <small class="text-muted">
                        Barang <span class="mx-2">></span>
                        <a href="{{ route('barang.edit', $barang->id) }}" class="text-decoration-none">Edit Data Barang</a>
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
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="mdi mdi-pencil-box-outline me-2"></i> Edit Data Barang
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

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- ================= FORM ================= --}}
                <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ========= BARIS 1 (2 kolom) ========= --}}
                    <div class="row">
                        {{-- Nama Barang --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Barang<span class="text-danger">*</span></label>
                            <input type="text" name="namaBarang" class="form-control @error('namaBarang') is-invalid @enderror"
                                   placeholder="Nama Barang"
                                   value="{{ old('namaBarang', $barang->namaBarang) }}"
                                   required>
                            @error('namaBarang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tahun --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tahun<span class="text-danger">*</span></label>
                            <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror"
                                   placeholder="Contoh: 2020"
                                   value="{{ old('tahun', $barang->tahun) }}"
                                   required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ========= BARIS 2 (2 kolom) ========= --}}
                    <div class="row">
                        {{-- Jenis Barang --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Barang<span class="text-danger">*</span></label>
                            <input type="text" name="jenisBarang" class="form-control @error('jenisBarang') is-invalid @enderror"
                                   placeholder="Elektronik / Furnitur"
                                   value="{{ old('jenisBarang', $barang->jenisBarang) }}"
                                   required>
                            @error('jenisBarang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nomor NUP --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nomor NUP<span class="text-danger">*</span></label>
                            <input type="text" name="nomorNUP" class="form-control @error('nomorNUP') is-invalid @enderror"
                                   placeholder="Nomor NUP"
                                   value="{{ old('nomorNUP', $barang->nomorNUP) }}"
                                   required>
                            @error('nomorNUP')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Nomor NUP harus unik</small>
                        </div>
                    </div>

                    {{-- ========= BARIS 3 (2 kolom) ========= --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kondisi Barang <span class="text-danger">*</span></label>
                            <select name="kondisi" class="form-select" required>
                                <option value="" disabled>-- Pilih Kondisi --</option>
                                <option value="Baru" {{ $barang->kondisi == 'Baru' ? 'selected' : '' }}>Baru</option>
                                <option value="Berfungsi" {{ $barang->kondisi == 'Berfungsi' ? 'selected' : '' }}>Berfungsi</option>
                                <option value="Rusak" {{ $barang->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                        </div>

                            {{-- Lokasi Otomatis / Manual --}}
                    <div class="mb-3">
                        <label class="fw-bold">Lokasi Barang <span class="text-danger">*</span></label><br>

                        <label class="me-3">
                            <input type="radio" name="mode_lokasi" value="otomatis" checked onclick="setLokasiMode()"> Otomatis
                        </label>

                        <label>
                            <input type="radio" name="mode_lokasi" value="manual" onclick="setLokasiMode()"> Manual
                        </label>

                        <div id="box_otomatis" class="input-group mt-2">
                            <input type="text" id="alamat_otomatis" class="form-control bg-light" readonly placeholder="Mendeteksi lokasi...">
                           <button type="button" class="btn btn-danger ms-2" onclick="resetLokasi()">
                                <i class="mdi mdi-map-marker-off"></i> Reset Lokasi
                            </button>
                        </div>

                        <input type="hidden" name="lokasi" id="lokasi_hidden">
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <input type="text" id="alamat_manual" class="form-control mt-2 d-none"
                            placeholder="Masukkan lokasi manual...">

                        @error('lokasi') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    </div>
                    {{-- ========= BARIS 5 (Keterangan) - EDIT ========= --}}
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Keterangan <span class="text-danger">*</span></label>

                            <textarea name="keterangan" class="form-control" rows="3" required
                                placeholder="Masukkan keterangan tambahan mengenai barang...">{{ old('keterangan', $barang->keterangan) }}</textarea>

                            @error('keterangan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    {{-- ========= BARIS 4 (Foto Barang) ========= --}}
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Foto Barang</label>

                            {{-- Preview Foto Lama --}}
                            @if($barang->fotoBarang)
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Foto saat ini:</label>
                                    <div class="border rounded p-2 bg-light d-inline-block">
                                        <img src="{{ asset('storage/' . $barang->fotoBarang) }}"
                                             alt="Foto Barang"
                                             class="img-fluid"
                                             style="max-height:150px; border-radius:6px; object-fit:cover;">
                                    </div>
                                </div>
                            @endif

                            <div class="border rounded p-3 text-center bg-light"
                                 style="cursor:pointer;"
                                 onclick="document.getElementById('fotoBarang').click();">

                                <img id="previewImage"
                                     src="{{ $barang->fotoBarang ? asset('storage/' . $barang->fotoBarang) : 'https://via.placeholder.com/150?text=Preview' }}"
                                     class="img-fluid mb-2"
                                     style="max-height:160px; border-radius:6px; object-fit:cover;">

                                <div>
                                    <i class="fa fa-upload text-primary"></i>
                                    <p class="mt-2 mb-0 text-muted">Klik untuk mengganti foto barang (opsional)</p>
                                </div>
                            </div>

                            <input type="file" name="fotoBarang" id="fotoBarang"
                                   class="d-none" accept="image/*"
                                   onchange="previewFoto(this)">

                            <small class="text-muted d-block mt-2">
                                <i class="mdi mdi-information-outline"></i>
                                Biarkan kosong jika tidak ingin mengganti foto
                            </small>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="text-end">
                        <a href="{{ url('/barang') }}" class="btn btn-secondary px-4 me-2">
                            <i class="mdi mdi-close me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="mdi mdi-content-save-outline me-1"></i> Update Data
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

<script>
function setLokasiMode() {
    let mode = document.querySelector('input[name="mode_lokasi"]:checked').value;

    if (mode === "otomatis") {
        document.getElementById("alamat_otomatis").classList.remove("d-none");
        document.getElementById("alamat_manual").classList.add("d-none");

        // aktifkan kembali lokasi otomatis
        ambilLokasiOtomatis();
    } else {
        document.getElementById("alamat_otomatis").classList.add("d-none");
        document.getElementById("alamat_manual").classList.remove("d-none");

        // kosongkan hidden fields
        document.getElementById("latitude").value = "";
        document.getElementById("longitude").value = "";
    }
}

function ambilLokasiOtomatis() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                let lat = pos.coords.latitude;
                let lon = pos.coords.longitude;

                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lon;

                // Reverse geocode untuk mendapatkan alamat
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById("alamat_otomatis").value = data.display_name;
                    })
                    .catch(() => {
                        document.getElementById("alamat_otomatis").value = "Gagal mengambil alamat";
                    });
            },
            function (err) {
                alert("Tidak bisa mengambil lokasi otomatis.");
            }
        );
    }
}

// Jalankan otomatis saat halaman load
document.addEventListener("DOMContentLoaded", ambilLokasiOtomatis);
</script>
<script>
function setLokasiMode() {
    let mode = document.querySelector('input[name="mode_lokasi"]:checked').value;

    if (mode === "otomatis") {
        document.getElementById("box_otomatis").classList.remove("d-none");
        document.getElementById("alamat_manual").classList.add("d-none");
        ambilLokasiOtomatis();
    } else {
        document.getElementById("box_otomatis").classList.add("d-none");
        document.getElementById("alamat_manual").classList.remove("d-none");

        document.getElementById("latitude").value = "";
        document.getElementById("longitude").value = "";
    }
}

function ambilLokasiOtomatis() {
    if (!navigator.geolocation) {
        alert("Browser tidak mendukung GPS.");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        async function(pos) {
            let lat = pos.coords.latitude;
            let lon = pos.coords.longitude;

            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lon;

            let url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;

            let response = await fetch(url);
            let data = await response.json();

            let alamat = data.display_name || "Alamat tidak ditemukan";

            document.getElementById("alamat_otomatis").value = alamat;
            document.getElementById("lokasi_hidden").value = alamat;
        },
        function() {
            alert("Tidak bisa mengambil lokasi. Pastikan GPS aktif.");
        }
    );
}
function resetLokasi() {
    document.getElementById("alamat_otomatis").value = "";
    document.getElementById("lokasi_hidden").value = "";
    document.getElementById("latitude").value = "";
    document.getElementById("longitude").value = "";

    alert("Lokasi telah direset!");

    // Jika mode otomatis → ambil lokasi baru lagi
    let mode = document.querySelector('input[name="mode_lokasi"]:checked').value;
    if (mode === "otomatis") {
        ambilLokasiOtomatis();
    }
}

document.addEventListener("DOMContentLoaded", ambilLokasiOtomatis);
</script>


@endsection
