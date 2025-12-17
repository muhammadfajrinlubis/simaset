@extends('layouts.app',
 ['activePage' => 'admin'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                {{-- Card Header --}}
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ubah Password Admin</h5>
                </div>

                <div class="card-body">
                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Password Update Form --}}
                    <form action="{{ route('admin.updatePassword', $admin->id) }}" method="POST">
                        @csrf

                        {{-- Old Password Field --}}
                        <div class="form-group mb-3">
                            <label class="label fw-bold">Password Lama</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    id="password_lama"
                                    name="password_lama"
                                    class="form-control @error('password_lama') is-invalid @enderror"
                                    placeholder="*********"
                                    required
                                >
                                <div class="input-group-append">
                                    <span
                                        class="input-group-text"
                                        onclick="togglePasswordField('password_lama', 'toggleIcon1')"
                                        style="cursor: pointer;"
                                    >
                                        <i class="mdi mdi-eye-off" id="toggleIcon1"></i>
                                    </span>
                                </div>
                                @error('password_lama')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- New Password Field --}}
                        <div class="form-group mb-3">
                            <label class="label fw-bold">Password Baru</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    id="password_baru"
                                    name="password_baru"
                                    class="form-control @error('password_baru') is-invalid @enderror"
                                    placeholder="*********"
                                    required
                                >
                                <div class="input-group-append">
                                    <span
                                        class="input-group-text"
                                        onclick="togglePasswordField('password_baru', 'toggleIcon2')"
                                        style="cursor: pointer;"
                                    >
                                        <i class="mdi mdi-eye-off" id="toggleIcon2"></i>
                                    </span>
                                </div>
                                @error('password_baru')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Password Confirmation Field --}}
                        <div class="form-group mb-3">
                            <label class="label fw-bold">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    id="konfirmasi_password"
                                    name="konfirmasi_password"
                                    class="form-control @error('konfirmasi_password') is-invalid @enderror"
                                    placeholder="*********"
                                    required
                                >
                                <div class="input-group-append">
                                    <span
                                        class="input-group-text"
                                        onclick="togglePasswordField('konfirmasi_password', 'toggleIcon3')"
                                        style="cursor: pointer;"
                                    >
                                        <i class="mdi mdi-eye-off" id="toggleIcon3"></i>
                                    </span>
                                </div>
                                @error('konfirmasi_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="btn btn-primary w-100">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Toggle Password Visibility Script --}}
    <script>
        function togglePasswordField(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('mdi-eye-off');
                icon.classList.add('mdi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('mdi-eye');
                icon.classList.add('mdi-eye-off');
            }
        }
    </script>
@endsection
@push('scripts')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error_swal'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error_swal') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@endpush

