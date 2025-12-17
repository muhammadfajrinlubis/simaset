@extends('layouts.master-mini')
@section('content')

<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one"
     style="background-image: url({{ url('assets/images/dashboard/progress-card-bg.jpg') }}); background-size: cover;">
  <div class="row w-100">
    <div class="col-lg-4 mx-auto">

      <div class="auto-form-wrapper">

        {{-- ALERT ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <!-- EMAIL -->
          <div class="form-group">
            <label class="label">Email</label>
            <div class="input-group">
              <input type="email"
                     name="email"
                     class="form-control @error('email') is-invalid @enderror"
                     placeholder="Email"
                     value="{{ old('email') }}"
                     required>
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-email"></i>
                </span>
              </div>
            </div>
          </div>

          <!-- PASSWORD + SHOW/HIDE -->
          <div class="form-group">
            <label class="label">Password</label>
            <div class="input-group">
              <input type="password"
                     id="password"
                     name="password"
                     class="form-control @error('password') is-invalid @enderror"
                     placeholder="*********"
                     required>

              <div class="input-group-append">
                <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                  <i class="mdi mdi-eye" id="toggleIcon"></i>
                </span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <button class="btn btn-primary submit-btn btn-block">Login</button>
          </div>
        </form>
      </div>

      <ul class="auth-footer">
        <li><a href="#">Conditions</a></li>
        <li><a href="#">Help</a></li>
        <li><a href="#">Terms</a></li>
      </ul>

      <span class="text-muted">
        Copyright &copy; {{ date('Y') }}
        <a href="https://kkp.go.id/unit-kerja/bppsdmkp/upt/sekolah-usaha-perikanan-menengah-negeri-pariaman.html"
           target="_blank"
           class="text-decoration-none fw-bold">
            SUPM Pariaman
        </a>
      </span>

    </div>
  </div>
</div>

<!-- SCRIPT UNTUK SHOW/HIDE PASSWORD -->
<script>
function togglePassword() {
  const input = document.getElementById('password');
  const icon = document.getElementById('toggleIcon');

  if (input.type === "password") {
    input.type = "text";
    icon.classList.remove('mdi-eye');
    icon.classList.add('mdi-eye-off');
  } else {
    input.type = "password";
    icon.classList.remove('mdi-eye-off');
    icon.classList.add('mdi-eye');
  }
}
</script>

@endsection
