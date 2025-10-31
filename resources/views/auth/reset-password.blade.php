<!DOCTYPE html>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password | E-SiswaIzin</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/pages/page-auth.css') }}" />
</head>
<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card shadow-lg rounded-3">
                    <div class="card-body">
                        <h4 class="mb-2 text-center">Reset Password 🔑</h4>
                        <p class="mb-4 text-center">Masukkan password baru Anda.</p>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <!-- Token dari link email -->
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email', $email ?? '') }}" required>
                                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label>Password Baru</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password" required>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label>Konfirmasi Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary d-grid w-100">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
</body>
</html>
