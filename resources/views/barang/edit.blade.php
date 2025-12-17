@extends('layouts.app', ['activePage' => 'barang'])

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
                        <a href="{{ route('barang.index') }}" class="text-decoration-none">List Data Barang</a>
                        <span class="mx-2">></span> Edit Barang
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

                {{-- Alert Session --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

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
                <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data" id="formEditBarang">
                    @csrf
                    @method('PUT')

                    {{-- ========= BARIS 1 ========= --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Barang<span class="text-danger">*</span></label>
                            <input type="text" name="namaBarang" class="form-control"
                                   value="{{ old('namaBarang', $barang->namaBarang) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tahun<span class="text-danger">*</span></label>
                            <input type="number" name="tahun" class="form-control"
                                   value="{{ old('tahun', $barang->tahun) }}" required>
                        </div>
                    </div>

                    {{-- ========= BARIS 2 ========= --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Barang<span class="text-danger">*</span></label>
                            <input type="text" name="jenisBarang" class="form-control"
                                   value="{{ old('jenisBarang', $barang->jenisBarang) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nomor NUP<span class="text-danger">*</span></label>
                            <input type="text" name="nomorNUP" class="form-control"
                                   value="{{ old('nomorNUP', $barang->nomorNUP) }}" required>
                            <small class="text-muted">NUP saat ini: <strong>{{ $barang->nomorNUP }}</strong></small>
                        </div>
                    </div>

                    {{-- ========= BARIS 3 ========= --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kondisi<span class="text-danger">*</span></label>
                            <select name="kondisi" class="form-select" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="Baru" {{ old('kondisi', $barang->kondisi) == 'Baru' ? 'selected' : '' }}>Baru</option>
                                <option value="Berfungsi" {{ old('kondisi', $barang->kondisi) == 'Berfungsi' ? 'selected' : '' }}>Berfungsi</option>
                                <option value="Rusak" {{ old('kondisi', $barang->kondisi) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                        </div>

                        {{-- Lokasi --}}
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Lokasi Barang <span class="text-danger">*</span></label><br>

                            <label class="me-3">
                                <input type="radio" name="mode_lokasi" value="otomatis" onclick="setLokasiMode()">
                                Otomatis
                            </label>

                            <label>
                                <input type="radio" name="mode_lokasi" value="manual" checked onclick="setLokasiMode()">
                                Manual
                            </label>

                            <div id="box_otomatis" class="input-group mt-2 d-none">
                                <input type="text" id="alamat_otomatis" class="form-control bg-light" readonly placeholder="Mendeteksi lokasi...">
                                <button type="button" class="btn btn-danger" onclick="resetLokasi()">
                                    <i class="mdi mdi-map-marker-off"></i> Reset
                                </button>
                            </div>

                            <div id="box_manual" class="mt-2">
                                <input type="text" name="lokasi" id="alamat_manual" class="form-control"
                                       value="{{ old('lokasi', $barang->lokasi) }}" required>
                            </div>

                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $barang->latitude) }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $barang->longitude) }}">
                        </div>
                    </div>

                    {{-- ========= BARIS 4 KETERANGAN ========= --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $barang->keterangan) }}</textarea>
                    </div>

                    {{-- ==================== FOTO BARANG ==================== --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            Foto Barang (Wajib 4 Foto) <span class="text-danger">*</span>
                        </label>

                        <div class="alert alert-info">
                            <i class="mdi mdi-information"></i>
                            <strong>Perhatian:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Foto yang dihapus harus diganti dengan foto baru</li>
                                <li>Total foto harus tetap 4 (tidak boleh kurang atau lebih)</li>
                                <li>Jika menghapus foto, wajib upload pengganti</li>
                            </ul>
                        </div>

                        {{-- PREVIEW CONTAINER --}}
                        <div id="editPreviewContainer" class="d-flex gap-3 flex-wrap mb-3">
                            @php
                                $existingPhotos = json_decode($barang->fotoBarang, true) ?? [];
                            @endphp

                            @foreach($existingPhotos as $index => $foto)
                                <div class="position-relative photo-existing" data-foto="{{ $foto }}" style="width:120px;">
                                    <img src="{{ asset('storage/' . $foto) }}"
                                         class="rounded border"
                                         width="120" height="120"
                                         style="object-fit:cover;">

                                    <button type="button"
                                            onclick="hapusFotoLama(this, '{{ $foto }}')"
                                            class="btn btn-sm btn-danger"
                                            style="position:absolute; top:5px; right:5px;">
                                        ✕
                                    </button>

                                    <span class="position-absolute bottom-0 start-0 badge bg-dark m-1">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        {{-- COUNTER FOTO --}}
                        <div id="photoCounter" class="mb-3">
                            <span class="badge bg-primary" id="counterBadge">
                                Total Foto: <span id="totalFoto">{{ count($existingPhotos) }}</span> / 4
                            </span>
                        </div>

                        {{-- WARNING --}}
                        <div id="editPhotoAlert" class="alert alert-warning" style="display:none;">
                            <i class="mdi mdi-alert"></i>
                            <strong id="warningText"></strong>
                        </div>

                        {{-- TOMBOL UPLOAD --}}
                        <div id="editUploadArea"
                             class="border rounded p-3 text-center bg-light"
                             style="cursor:pointer; width:160px;"
                             onclick="document.getElementById('editFotoBarang').click();">
                            <i class="fa fa-upload text-primary"></i>
                            <p class="mt-2 mb-0 text-muted">Tambah Foto</p>
                        </div>

                        {{-- INPUT FILE --}}
                        <input type="file" id="editFotoBarang" class="d-none" accept="image/*" multiple onchange="addNewPhotos(event)">

                        {{-- HIDDEN INPUTS --}}
                        <div id="editHiddenInputsContainer"></div>
                        <input type="hidden" name="hapus_foto" id="hapusFotoInput" value="">
                    </div>

                    {{-- Submit --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="mdi mdi-content-save-edit-outline me-1"></i> Update Data
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

{{-- ================= JAVASCRIPT ================= --}}
<script>
// Variabel global
let editPhotos = [];  // Foto baru yang akan diupload
let deletedPhotos = []; // Foto lama yang dihapus
const totalFotoAwal = {{ count($existingPhotos) }};
let currentTotalExisting = totalFotoAwal; // Jumlah foto existing yang belum dihapus

// Update counter
function updateCounter() {
    const total = currentTotalExisting + editPhotos.length;
    document.getElementById('totalFoto').textContent = total;

    const badge = document.getElementById('counterBadge');
    if (total === 4) {
        badge.className = 'badge bg-success';
    } else if (total < 4) {
        badge.className = 'badge bg-danger';
    } else {
        badge.className = 'badge bg-warning';
    }

    checkPhotoValidation();
}

// Validasi foto
function checkPhotoValidation() {
    const total = currentTotalExisting + editPhotos.length;
    const warning = document.getElementById('editPhotoAlert');
    const warningText = document.getElementById('warningText');

    if (total < 4) {
        warning.style.display = 'block';
        warningText.textContent = `Foto kurang ${4 - total}! Wajib upload ${4 - total} foto lagi.`;
        warning.className = 'alert alert-danger';
    } else if (total > 4) {
        warning.style.display = 'block';
        warningText.textContent = `Foto melebihi batas! Hapus ${total - 4} foto.`;
        warning.className = 'alert alert-danger';
    } else {
        warning.style.display = 'none';
    }
}

// Hapus foto lama
function hapusFotoLama(button, foto) {

    Swal.fire({
        title: 'Hapus Foto?',
        text: "Foto ini akan dihapus dan Anda wajib mengupload foto pengganti!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {

            // Hapus dari tampilan
            const photoDiv = button.closest('.photo-existing');
            photoDiv.remove();

            // Tambah ke array deleted
            deletedPhotos.push(foto);
            document.getElementById('hapusFotoInput').value = JSON.stringify(deletedPhotos);

            // Kurangi counter
            currentTotalExisting--;

            updateCounter();

            // Notif sukses
            Swal.fire({
                title: 'Terhapus!',
                text: 'Foto berhasil dihapus.',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}


// Tambah foto baru
function addNewPhotos(event) {
    const files = event.target.files;
    const currentTotal = currentTotalExisting + editPhotos.length;
    const available = 4 - currentTotal;

    if (available <= 0) {
        alert("Foto sudah maksimal 4! Hapus foto lama dulu jika ingin mengganti.");
        event.target.value = '';
        return;
    }

    if (files.length > available) {
        alert(`Hanya bisa upload ${available} foto lagi!`);
        event.target.value = '';
        return;
    }

    [...files].forEach(file => {
        editPhotos.push(file);
    });

    renderNewPhotos();
    createHiddenInputs();
    updateCounter();

    event.target.value = '';
}

// Render preview foto baru
function renderNewPhotos() {
    const container = document.getElementById('editPreviewContainer');

    // Hapus semua foto baru dari preview (foto existing tetap)
    const newPhotoDivs = container.querySelectorAll('.photo-new');
    newPhotoDivs.forEach(div => div.remove());

    // Render ulang foto baru
    editPhotos.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrap = document.createElement("div");
            wrap.className = "position-relative photo-new";
            wrap.style.width = "120px";

            wrap.innerHTML = `
                <img src="${e.target.result}"
                     class="rounded border"
                     width="120" height="120"
                     style="object-fit:cover;">

                <button type="button"
                        onclick="removeNewPhoto(${index})"
                        class="btn btn-sm btn-danger"
                        style="position:absolute; top:5px; right:5px;">
                    ✕
                </button>

                <span class="position-absolute bottom-0 start-0 badge bg-success m-1">
                    Baru ${index + 1}
                </span>
            `;

            container.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });
}

// Hapus foto baru
function removeNewPhoto(index) {
    editPhotos.splice(index, 1);
    renderNewPhotos();
    createHiddenInputs();
    updateCounter();
}

// Buat hidden input untuk foto baru
function createHiddenInputs() {
    const container = document.getElementById("editHiddenInputsContainer");
    container.innerHTML = "";

    const dt = new DataTransfer();
    editPhotos.forEach(f => dt.items.add(f));

    const input = document.createElement("input");
    input.type = "file";
    input.name = "fotoBarang[]";
    input.multiple = true;
    input.style.display = "none";
    input.files = dt.files;

    container.appendChild(input);
}

// Validasi sebelum submit
document.getElementById('formEditBarang').addEventListener('submit', function(e) {
    const total = currentTotalExisting + editPhotos.length;

    if (total !== 4) {
        e.preventDefault();
        alert(`Total foto harus tepat 4! Saat ini: ${total} foto.\n\n${total < 4 ? 'Upload ' + (4 - total) + ' foto lagi!' : 'Hapus ' + (total - 4) + ' foto!'}`);

        // Scroll ke foto section
        document.getElementById('editPreviewContainer').scrollIntoView({ behavior: 'smooth', block: 'center' });

        return false;
    }
});

// ================= LOKASI =================
function get(id) { return document.getElementById(id); }

function setLokasiMode() {
    const mode = document.querySelector('input[name="mode_lokasi"]:checked').value;
    const boxOtomatis = get('box_otomatis');
    const boxManual = get('box_manual');

    if (mode === 'otomatis') {
        boxOtomatis.classList.remove('d-none');
        boxManual.classList.add('d-none');
        ambilLokasiAkurat();
    } else {
        boxOtomatis.classList.add('d-none');
        boxManual.classList.remove('d-none');
    }
}

function resetLokasi() {
    get("alamat_otomatis").value = "Mengambil lokasi...";
    get("latitude").value = "";
    get("longitude").value = "";

    setTimeout(() => {
        ambilLokasiAkurat();
    }, 500);
}

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

            get("latitude").value = lat;
            get("longitude").value = lon;

            let url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;

            try {
                let res = await fetch(url);
                let data = await res.json();
                let alamat = data.display_name || "Alamat tidak ditemukan";

                get("alamat_otomatis").value = alamat;
                get("alamat_manual").value = alamat;
            } catch (e) {
                get("alamat_otomatis").value = "Gagal mengambil alamat";
            }
        },
        function(error) {
            alert("Gagal mengambil lokasi. Gunakan mode Manual.");
        },
        options
    );
}

// Inisialisasi counter saat load
document.addEventListener('DOMContentLoaded', function() {
    updateCounter();
});


// 🔒 LOCK PAGE — User tidak boleh pergi jika foto < 4

function isFotoKurang() {
    return (currentTotalExisting + editPhotos.length) < 4;
}


document.addEventListener('click', function(e) {
    const target = e.target.closest('a');

    if (!target) return;

    // Abaikan link yang bukan pindah halaman
    const href = target.getAttribute('href');
    if (!href || href.startsWith('#')) return;

    // Cegah jika foto kurang
    if (isFotoKurang()) {
        e.preventDefault();

        Swal.fire({
            title: "Tidak Bisa Keluar!",
            text: "Total foto harus tepat 4 sebelum Anda meninggalkan halaman ini.",
            icon: "error",
            confirmButtonColor: "#d33",
        });

        return false;
    }
});

window.addEventListener("beforeunload", function (e) {
    if (isFotoKurang()) {
        e.preventDefault();
        e.returnValue = "";
    }
});

</script>

@endsection
