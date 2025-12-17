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
                    {{-- ========= BARIS FOTO (upload 4 foto saja) ========= --}}
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">
                                Foto Barang (wajib 4 foto)
                                <span class="text-danger">*</span>
                            </label>

                            <div class="col-md-12 mb-3">

                                <!-- PREVIEW FOTO -->
                                <div id="previewContainer" class="d-flex gap-3 flex-wrap mb-3"></div>

                                <!-- WARNING -->
                                <div id="photoAlert"
                                    class="text-danger fw-bold mb-2"
                                    style="display:none;">
                                    Anda wajib mengupload tepat 4 foto!
                                </div>

                                <!-- TOMBOL UPLOAD -->
                                <div id="uploadArea"
                                    class="border rounded p-3 text-center bg-light"
                                    style="cursor:pointer; width:160px;"
                                    onclick="document.getElementById('fotoBarang').click();">

                                    <i class="fa fa-upload text-primary"></i>
                                    <p class="mt-2 mb-0 text-muted">Tambah Foto</p>
                                </div>

                                <!-- INPUT FILE (MULTIPLE) -->
                                <input type="file" id="fotoBarang" class="d-none" accept="image/*" multiple onchange="addPhotos(event)">

                                <!-- INPUT HIDDEN UNTUK SETIAP FOTO -->
                                <div id="hiddenInputsContainer"></div>
                            </div>
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

<script>
// Penampung foto dalam bentuk File objects
let photos = [];

// Tambah foto
function addPhotos(event) {
    const files = event.target.files;

    if (photos.length + files.length > 4) {
        alert("Maksimal 4 foto!");
        event.target.value = '';
        return;
    }

    [...files].forEach(file => {
        photos.push(file);
    });

    renderPreview();
    createHiddenInputs();
    checkPhotoWarning();

    event.target.value = '';
}

// Tampilkan preview
function renderPreview() {
    const container = document.getElementById("previewContainer");
    container.innerHTML = "";

    photos.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement("div");
            wrapper.style.position = "relative";

            wrapper.innerHTML = `
                <img src="${e.target.result}"
                     class="rounded border"
                     width="120" height="120"
                     style="object-fit:cover;">

                <button type="button"
                        onclick="removePhoto(${index})"
                        class="btn btn-sm btn-danger"
                        style="position:absolute; top:5px; right:5px;">
                    ✕
                </button>
            `;

            container.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

// Buat input hidden untuk setiap foto
function createHiddenInputs() {
    const container = document.getElementById("hiddenInputsContainer");
    container.innerHTML = "";

    const dataTransfer = new DataTransfer();

    photos.forEach(file => {
        dataTransfer.items.add(file);
    });

    const newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.name = 'fotoBarang[]';
    newInput.multiple = true;
    newInput.style.display = 'none';
    newInput.files = dataTransfer.files;

    container.appendChild(newInput);
}

// Hapus foto
function removePhoto(index) {
    photos.splice(index, 1);
    renderPreview();
    createHiddenInputs();
    checkPhotoWarning();
}

// Tampilkan / hilangkan warning
function checkPhotoWarning() {
    const alertBox = document.getElementById("photoAlert");

    if (photos.length < 4) {
        alertBox.style.display = "block";
        alertBox.textContent = "Foto belum 4, silakan upload 4 foto!";
    } else {
        alertBox.style.display = "none";
    }
}

// Cegah submit jika foto belum 4
document.addEventListener('submit', function(e) {
    if (e.target.id === 'formBarang') {
        if (photos.length !== 4) {
            e.preventDefault();
            checkPhotoWarning();
            return false;
        }
    }
});
</script>

<script>

// Helper aman
function get(id) { return document.getElementById(id); }

// Reset lokasi otomatis
function resetLokasi() {

    // Kosongkan input
    get("alamat_otomatis").value = "Lokasi telah di-reset. Silakan ambil ulang.";
    get("lokasi_hidden").value = "";
    get("latitude").value = "";
    get("longitude").value = "";

    // Tambahkan warna merah sebentar sebagai efek visual
    get("alamat_otomatis").classList.add("bg-warning");

    setTimeout(() => {
        get("alamat_otomatis").classList.remove("bg-warning");
    }, 1000);

    // Ambil ulang lokasi GPS setelah reset
    setTimeout(() => {
        ambilLokasiAkurat();
    }, 800);
}


// =========== FUNGSI AMBIL LOKASI AKURAT (PUNYAMU) ===========
function ambilLokasiAkurat() {

    if (!navigator.geolocation) {
        alert("Browser tidak mendukung GPS.");
        return;
    }

    const options = {
        enableHighAccuracy: true,
        timeout: 15000,
        maximumAge: 0
    };

    navigator.geolocation.getCurrentPosition(
        async function(pos) {

            let lat = pos.coords.latitude;
            let lon = pos.coords.longitude;
            let accuracy = pos.coords.accuracy;

            console.log("Akurasi GPS: " + accuracy + " meter");

            get("latitude").value = lat;
            get("longitude").value = lon;

            if (accuracy > 50) {
                console.warn("Akurasi buruk, mencoba lagi...");
                setTimeout(ambilLokasiAkurat, 2000);
            }

            let url =
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;

            try {
                let res = await fetch(url);
                let data = await res.json();

                let alamat = data.display_name || "Alamat tidak ditemukan";

                get("alamat_otomatis").value = alamat;
                get("lokasi_hidden").value = alamat;

            } catch (e) {
                get("alamat_otomatis").value = "Gagal mengambil alamat";
            }
        },

        function(error) {
            console.error(error);

            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("Izin lokasi ditolak. Aktifkan GPS & izinkan lokasi.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Lokasi tidak tersedia.");
                    break;
                case error.TIMEOUT:
                    alert("Timeout pengambilan lokasi.");
                    break;
                default:
                    alert("Terjadi kesalahan mengambil lokasi.");
            }
        },

        options
    );
}

function setLokasiMode() {
    let mode = document.querySelector('input[name="mode_lokasi"]:checked').value;

    if (mode === "manual") {
        // Tampilkan input manual
        get("alamat_manual").classList.remove("d-none");
        get("alamat_manual").required = true;

        // Sembunyikan lokasi otomatis
        get("box_otomatis").classList.add("d-none");

        // Kosongkan lokasi otomatis
        get("lokasi_hidden").value = "";
        get("latitude").value = "";
        get("longitude").value = "";

        // Saat mengetik manual → kirim ke hidden
        get("alamat_manual").addEventListener("input", function() {
            get("lokasi_hidden").value = this.value;
        });

    } else {
        // Mode otomatis
        get("alamat_manual").classList.add("d-none");
        get("alamat_manual").required = false;

        get("box_otomatis").classList.remove("d-none");

        // Ambil ulang lokasi otomatis
        ambilLokasiAkurat();
    }
}


// Jalankan saat halaman dibuka
document.addEventListener("DOMContentLoaded", function () {
    ambilLokasiAkurat();
});

</script>


@endsection
