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
                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ========= BARIS 1 (2 kolom) ========= --}}
                    <div class="row">
                        {{-- Nama Barang --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Barang<span class="text-danger">* </span></label>
                            <input type="text" name="namaBarang" class="form-control"
                                   placeholder="Nama Barang" required>
                        </div>

                        {{-- Tahun --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tahun<span class="text-danger">* </span></label>
                            <input type="number" name="tahun" class="form-control"
                                   placeholder="Contoh: 2020" required>
                        </div>
                    </div>

                    {{-- ========= BARIS 2 (2 kolom) ========= --}}
                    <div class="row">
                        {{-- Jenis Barang --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Barang<span class="text-danger">* </span></label>
                            <input type="text" name="jenisBarang" class="form-control"
                                   placeholder="Elektronik / Furnitur" required>
                        </div>

                        {{-- Nomor NUP --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nomor NUP<span class="text-danger">* </span></label>
                            <input type="text" name="nomorNUP" class="form-control"
                                   placeholder="Nomor NUP" required>
                        </div>
                    </div>

                    {{-- ========= BARIS 3 (2 kolom) ========= --}}
                    <div class="row">
                        {{-- Kondisi --}}
                          <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            Kondisi Barang <span class="text-danger">*</span>
                        </label>

                        <select name="kondisi" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Kondisi --</option>
                            <option value="Baru">Baru</option>
                            <option value="Berfungsi">Berfungsi</option>
                            <option value="Rusak">Rusak</option>
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
                    {{-- ========= BARIS 5 (Keterangan) ========= --}}
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Keterangan<span class="text-danger">*</span></label>
                            <textarea name="keterangan" class="form-control" rows="3"
                                    placeholder="Masukkan keterangan tambahan mengenai barang..." required></textarea>

                            @error('keterangan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    {{-- ========= BARIS 4 (1 kolom penuh) ========= --}}
                    <div class="row">
                        {{-- Foto Barang --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Foto Barang<span class="text-danger">* </span></label>

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
function setLokasiMode() {
    let mode = document.querySelector('input[name="mode_lokasi"]:checked').value;

    const otomatis = document.getElementById('box_otomatis');
    const manual = document.getElementById('alamat_manual');

    if (mode === "otomatis") {
        otomatis.classList.remove('d-none');
        manual.classList.add('d-none');

        // Reset manual
        manual.value = "";

        // Reset hidden
        document.getElementById("lokasi_hidden").value = "";
        document.getElementById("latitude").value = "";
        document.getElementById("longitude").value = "";

    } else {
        otomatis.classList.add('d-none');
        manual.classList.remove('d-none');

        // Reset otomatis
        document.getElementById("alamat_otomatis").value = "";

        // Reset hidden
        document.getElementById("lokasi_hidden").value = "";
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

document.addEventListener("DOMContentLoaded", ambilLokasiOtomatis);
</script>

<script>
// ===========================
// RESET & MODE SWITCH
// ===========================

function setLokasiMode() {
    const mode = document.querySelector('input[name="mode_lokasi"]:checked').value;

    const otomatisBox = document.getElementById("box_otomatis");
    const manualInput = document.getElementById("alamat_manual");

    if (mode === "otomatis") {
        otomatisBox.classList.remove("d-none");
        manualInput.classList.add("d-none");

        // Reset manual
        manualInput.value = "";

        // Ambil lokasi ulang
        ambilLokasiOtomatis();
    }
    else {
        otomatisBox.classList.add("d-none");
        manualInput.classList.remove("d-none");

        // Reset otomatis
        document.getElementById("alamat_otomatis").value = "";

        // Reset hidden fields
        document.getElementById("lokasi_hidden").value = "";
        document.getElementById("latitude").value = "";
        document.getElementById("longitude").value = "";
    }
}

// ===========================
// AMBIL LOKASI OTOMATIS
// ===========================

function ambilLokasiOtomatis() {
    if (!navigator.geolocation) {
        alert("Browser tidak mendukung GPS.");
        return;
    }

    navigator.geolocation.getCurrentPosition(async function(pos) {
        let lat = pos.coords.latitude;
        let lon = pos.coords.longitude;

        // Simpan ke hidden field
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lon;

        // Ambil alamat dari Nominatim
        let url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;

        let response = await fetch(url);
        let data = await response.json();

        let alamat = data.display_name || "Alamat tidak ditemukan";

        // Tampilkan alamat otomatis
        document.getElementById("alamat_otomatis").value = alamat;

        // Simpan ke hidden lokasi (untuk database)
        document.getElementById("lokasi_hidden").value = alamat;

    }, function() {
        alert("Tidak bisa mengambil lokasi. Pastikan GPS aktif.");
    });
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

    // Jalankan otomatis saat halaman dibuka
    document.addEventListener("DOMContentLoaded", function() {
        ambilLokasiOtomatis();
    });

</script>


@endsection
