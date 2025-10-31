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

    <title>Registrasi | E-SiswaIzin</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico') }}" />

    <meta name="description" content="Daftar akun baru e-SiswaIzin" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Halaman CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/pastel.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>

    <!-- Config -->
    <script src="{{ asset('sneat/assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Content -->
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
          <div class="card shadow-lg rounded-3">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <!-- Ikon tetap -->
                    <svg width="25" viewBox="0 0 25 42" xmlns="http://www.w3.org/2000/svg">
                      <defs>
                        <path d="M13.7918663,0.358365126 ... Z" id="path-1"></path>
                        <path d="M5.47320593,6.00457225 ... Z" id="path-3"></path>
                        <path d="M7.50063644,21.2294429 ... Z" id="path-4"></path>
                        <path d="M20.6,7.13333333 ... Z" id="path-5"></path>
                      </defs>
                      <g id="g-app-brand" fill="none" fill-rule="evenodd">
                        <g id="Brand-Logo">
                          <g id="Icon">
                            <g id="Mask" transform="translate(0.000000, 8.000000)">
                              <mask id="mask-2" fill="white">
                                <use xlink:href="#path-1"></use>
                              </mask>
                              <use fill="#696cff" xlink:href="#path-1"></use>
                              <g id="Path-3" mask="url(#mask-2)">
                                <use fill="#696cff" xlink:href="#path-3"></use>
                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                              </g>
                              <g id="Path-4" mask="url(#mask-2)">
                                <use fill="#696cff" xlink:href="#path-4"></use>
                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                              </g>
                            </g>
                            <g id="Triangle" transform="translate(19,11) rotate(-300) translate(-19,-11)">
                              <use fill="#696cff" xlink:href="#path-5"></use>
                              <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                            </g>
                          </g>
                        </g>
                      </g>
                    </svg>
                  </span>
                  <span class="app-brand-text demo text-body fw-bolder">e-SiswaIzin</span>
                </a>
              </div>
              <!-- /Logo -->

              <h4 class="mb-2 text-center">Mulai petualangan Anda 🚀</h4>
              <p class="mb-4 text-center">Daftarkan akun baru Anda di E-SiswaIzin dengan mudah!</p>

              <!-- Form sudah disamakan dengan register1 -->
              <form id="formAuthentication" class="mb-3" action="{{ route('registerProses') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="nama" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" value="{{ old('nama') }}" required />
                  @error('nama')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required />
                  @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="••••••••••••" required />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                  @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Ulangi Password</label>
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" required />
                </div>

                <div class="mb-3">
                  <label for="kelas" class="form-label">Kelas</label>
                  <select name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror" required>
                    <option value="" disabled selected hidden>--Pilih Kelas--</option>
                    <option value="X PPLG 1">X PPLG 1</option>
                    <option value="X PPLG 2">X PPLG 2</option>
                    <option value="X TJKT 1">X TJKT 1</option>
                    <option value="X TJKT 2">X TJKT 2</option>
                    <option value="X MPLB 1">X MPLB 1</option>
                    <option value="X MPLB 2">X MPLB 2</option>
                    <option value="X PMS 1">X PMS 1</option>
                    <option value="X PMS 2">X PMS 2</option>
                    <option value="X PMS 3">X PMS 3</option>
                    <option value="X BS 1">X BS 1</option>
                    <option value="X BS 2">X BS 2</option>
                    <option value="X BS 3">X BS 3</option>
                    <option value="X AKL 1">X AKL 1</option>
                    <option value="X AKL 2">X AKL 2</option>
                    <option value="X AKL 3">X AKL 3</option>
                    <option value="XI RPL 1">XI RPL 1</option>
                    <option value="XI RPL 2">XI RPL 2</option>
                    <option value="XI TKJ 1">XI TKJ 1</option>
                    <option value="XI TKJ 2">XI TKJ 2</option>
                    <option value="XI MP 1">XI MP 1</option>
                    <option value="XI MP 2">XI MP 2</option>
                    <option value="XI BR 1">XI BR 1</option>
                    <option value="XI BR 2">XI BR 2</option>
                    <option value="XI BD 1">XI BD 1</option>
                    <option value="XI DPB 1">XI DPB 1</option>
                    <option value="XI DPB 2">XI DPB 2</option>
                    <option value="XI DPB 3">XI DPB 3</option>
                    <option value="XI AK 1">XI AK 1</option>
                    <option value="XI AK 2">XI AK 2</option>
                    <option value="XII RPL 1">XII RPL 1</option>
                    <option value="XII RPL 2">XII RPL 2</option>
                    <option value="XII TKJ 1">XII TKJ 1</option>
                    <option value="XII TKJ 2">XII TKJ 2</option>
                    <option value="XII MP 1">XII MP 1</option>
                    <option value="XII MP 2">XII MP 2</option>
                    <option value="XII BR 1">XII BR 1</option>
                    <option value="XII BR 2">XII BR 2</option>
                    <option value="XII BD 1">XII BD 1</option>
                    <option value="XII DPB 1">XII DPB 1</option>
                    <option value="XII DPB 2">XII DPB 2</option>
                    <option value="XII DPB 3">XII DPB 3</option>
                    <option value="XII AK 1">XII AK 1</option>
                    <option value="XII AK 2">XII AK 2</option>
                    <option value="XII AK 3">XII AK 3</option>
                  </select>
                  @error('kelas')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <button type="submit" class="btn btn-primary d-grid w-100">Daftar Akun</button>
              </form>

              <p class="text-center">
                <span>Sudah punya akun?</span>
                <a href="{{ route('login') }}"><span>Masuk di sini</span></a>
              </p>
              <p class="text-center">
                <span>Kembali Ke Beranda?</span>
                <a href="{{ route('welcome') }}">
                  <span>Klik Disini</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register Card -->
        </div>
      </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>