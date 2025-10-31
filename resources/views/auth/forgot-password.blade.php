<!DOCTYPE html>
<html
  lang="id"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Lupa Password | E-SiswaIzin</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts & Icons & CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/pages/page-auth.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/pastel.css') }}" />

    <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/config.js') }}"></script>
  </head>

  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Forgot Password Card -->
          <div class="card shadow-lg rounded-3">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-3">
                <a href="{{ route('welcome') }}" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <!-- svg tetap sama -->
                  </span>
                  <span class="app-brand-text demo text-body fw-bolder">E-SiswaIzin</span>
                </a>
              </div>

              <h4 class="mb-2 text-center">Lupa Password 🔒</h4>
              <p class="mb-4 text-center">Masukkan email Anda untuk menerima link reset password</p>

              <!-- Notifikasi -->
              @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
              @endif
              @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
              @endif

              <!-- Form -->
              <form action="{{ route('forgotProses') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control form-control-user @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    placeholder="Masukkan email Anda"
                    value="{{ old('email') }}"
                    autofocus
                    required
                  />
                  @error('email')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Kirim Link Reset</button>
                </div>
              </form>

              <p class="text-center">
                <a href="{{ route('login') }}">Kembali ke Login</a>
              </p>
            </div>
          </div>
          <!-- /Forgot Password Card -->
        </div>
      </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>
    <script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

    @if (session('success'))
      <script>
        Swal.fire({ title: "Sukses!", text: "{{ session('success') }}", icon: "success" });
      </script>
    @endif
    @if (session('error'))
      <script>
        Swal.fire({ title: "Gagal", text: "{{ session('error') }}", icon: "error" });
      </script>
    @endif
  </body>
</html>
