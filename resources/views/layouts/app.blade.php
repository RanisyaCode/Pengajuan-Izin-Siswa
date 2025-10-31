@include('layouts.header')

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      @include('layouts.sidebar')

      <div class="layout-page">

        {{-- KUNCI 1: Mengembalikan container-xxl pada <nav> untuk menjaga jarak kanan/kiri konten. --}}
        {{-- KUNCI 2: Menghapus style inline yang menyebabkan 'boxy' (shadow, radius) di sini dan memindahkannya ke CSS agar bisa di-override saat sidebar tertutup. --}}
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" style="transition: all 0.3s ease;">
              <i class="bx bx-menu bx-sm" style="color: #6c757d;"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">
            
            <div class="d-none d-xl-flex align-items-center me-auto">
              <a class="nav-link px-0" href="javascript:void(0)" id="desktop-menu-toggle" style="cursor: pointer;">
                  <i class="bx bx-menu" style="color: #6c757d; font-size: 1.6rem; transition: color 0.3s ease;"></i>
              </a>
            </div>

            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="d-flex align-items-center gap-2" style="padding: 0.35rem 0.65rem; border-radius: 50px; transition: all 0.3s ease; background: linear-gradient(135deg, rgba(103, 126, 234, 0.06) 0%, rgba(118, 75, 162, 0.06) 100%); border: 1px solid rgba(103, 126, 234, 0.1);">
                    <div class="d-none d-md-flex flex-column align-items-end" style="line-height: 1.2;">
                      <span class="fw-bold" style="font-size: 0.8rem; color: #2c3e50;">{{ auth()->user()->nama }}</span>
                      <small style="font-size: 0.7rem;">
                        @if(auth()->user()->role === 'Admin')
                            <span style="color: #7c3aed; font-weight: 600;">
                                <i class="bx bxs-shield-alt-2" style="font-size: 0.65rem;"></i>
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        @elseif(auth()->user()->role === 'Siswa')
                            <span style="color: #059669; font-weight: 600;">
                                <i class="bx bxs-user-circle" style="font-size: 0.65rem;"></i>
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        @else
                            <span style="color: #64748b; font-weight: 600;">
                                <i class="bx bxs-user" style="font-size: 0.65rem;"></i>
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        @endif
                      </small>
                    </div>
                    <div style="position: relative;">
                      <img src="{{ auth()->user()->profile && auth()->user()->profile->profile_photo ? asset('storage/profile_photos/'.auth()->user()->profile->profile_photo) : asset('sneat/assets/img/avatars/1.png') }}" alt="Foto Profil" class="rounded-circle" width="36" height="36" style="border: 2px solid #fff; box-shadow: 0 3px 10px rgba(103, 126, 234, 0.2); object-fit: cover;" />
                      <span style="position: absolute; bottom: 0px; right: 0px; width: 10px; height: 10px; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); border: 2px solid #fff; border-radius: 50%; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.4);"></span>
                    </div>
                    <i class="bx bx-chevron-down" style="color: #667eea; font-size: 1rem;"></i>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width: 340px; border-radius: 1.25rem; box-shadow: 0 10px 40px rgba(0,0,0,0.15); border: 1px solid rgba(103, 126, 234, 0.08); padding: 1rem; margin-top: 0.75rem;">
                  <li>
                    <div style="padding: 1.5rem; border-radius: 1rem; background: linear-gradient(135deg, rgba(103, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); margin-bottom: 0.75rem; text-align: center;">
                      <div class="mb-3">
                        <div style="position: relative; width: 80px; height: 80px; margin: 0 auto;">
                          <img src="{{ auth()->user()->profile && auth()->user()->profile->profile_photo ? asset('storage/profile_photos/'.auth()->user()->profile->profile_photo) : asset('sneat/assets/img/avatars/1.png') }}" alt="Foto Profil" class="rounded-circle" width="80" height="80" style="border: 4px solid #fff; object-fit: cover; box-shadow: 0 6px 20px rgba(0,0,0,0.15);" />
                          <span style="position: absolute; bottom: 4px; right: 4px; width: 18px; height: 18px; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); border: 3.5px solid #fff; border-radius: 50%; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.5);"></span>
                        </div>
                      </div>
                      <div>
                        <h6 class="mb-2" style="font-size: 1.1rem; color: #1e293b; font-weight: 700;">
                          {{ auth()->user()->nama }}
                        </h6>
                        @if(auth()->user()->role === 'Admin')
                            <span class="badge" style="background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%); color:#6b21a8; padding: 0.45rem 1rem; font-size: 0.72rem; font-weight: 700; border-radius: 50px; box-shadow: 0 3px 10px rgba(216,180,254,0.4); letter-spacing: 0.5px;">
                                <i class="bx bxs-shield-alt-2" style="font-size: 0.85rem; margin-right: 0.3rem;"></i>
                                {{ strtoupper(auth()->user()->role) }}
                            </span>
                        @elseif(auth()->user()->role === 'Siswa')
                            <span class="badge" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color:#065f46; padding: 0.45rem 1rem; font-size: 0.72rem; font-weight: 700; border-radius: 50px; box-shadow: 0 3px 10px rgba(167,243,208,0.4); letter-spacing: 0.5px;">
                                <i class="bx bxs-user-circle" style="font-size: 0.85rem; margin-right: 0.3rem;"></i>
                                {{ strtoupper(auth()->user()->role) }}
                            </span>
                        @else
                            <span class="badge" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color:#475569; padding: 0.45rem 1rem; font-size: 0.72rem; font-weight: 700; border-radius: 50px; letter-spacing: 0.5px;">
                                <i class="bx bxs-user" style="font-size: 0.85rem; margin-right: 0.3rem;"></i>
                                {{ strtoupper(auth()->user()->role) }}
                            </span>
                        @endif
                      </div>
                    </div>
                  </li>
                  
                  <li><div class="dropdown-divider" style="margin: 0.75rem 0; opacity: 0.08;"></div></li>
                  
                  <li>
                    <a class="dropdown-item" href="{{ route('profile.index') }}" style="padding: 1rem 1.25rem; border-radius: 0.85rem; transition: all 0.3s ease; display: flex; align-items: center; margin-bottom: 0.5rem; border: 1px solid transparent;">
                      <div style="width: 46px; height: 46px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 0.85rem; display: flex; align-items: center; justify-content: center; margin-right: 1rem; box-shadow: 0 4px 14px rgba(102, 126, 234, 0.35); flex-shrink: 0;">
                        <i class="bx bx-user" style="color: #fff; font-size: 1.3rem;"></i>
                      </div>
                      <div style="flex-grow: 1;">
                        <div class="fw-bold" style="color: #2c3e50; font-size: 0.9rem; margin-bottom: 0.15rem;">My Profile</div>
                        <small style="color: #64748b; font-size: 0.75rem;">Lihat dan edit profil Anda</small>
                      </div>
                      <i class="bx bx-chevron-right" style="color: #cbd5e1; font-size: 1.2rem;"></i>
                    </a>
                  </li>
                  
                  <li><div class="dropdown-divider" style="margin: 0.75rem 0; opacity: 0.08;"></div></li>
                  
                  <li>
                    <form action="{{ route('logout') }}" method="POST">
                      @csrf
                      <button type="submit" class="dropdown-item" style="padding: 1rem 1.25rem; border-radius: 0.85rem; transition: all 0.3s ease; display: flex; align-items: center; border: 1px solid transparent; background: none; width: 100%; text-align: left; cursor: pointer;">
                        <div style="width: 46px; height: 46px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 0.85rem; display: flex; align-items: center; justify-content: center; margin-right: 1rem; box-shadow: 0 4px 14px rgba(245, 87, 108, 0.35); flex-shrink: 0;">
                          <i class="bx bx-log-out" style="color: #fff; font-size: 1.3rem;"></i>
                        </div>
                        <div style="flex-grow: 1;">
                          <div class="fw-bold" style="color: #2c3e50; font-size: 0.9rem; margin-bottom: 0.15rem;">Log Out</div>
                          <small style="color: #64748b; font-size: 0.75rem;">Keluar dari akun Anda</small>
                        </div>
                        <i class="bx bx-chevron-right" style="color: #cbd5e1; font-size: 1.2rem;"></i>
                      </button>
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <style>
          /* Default (Sidebar Terbuka) - Boxy look */
          .layout-navbar {
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            padding: 1rem 1.5rem;
            margin-top: 1.2rem;
          }

          /* ========================================
             SMOOTH TRANSITION UNTUK SIDEBAR TOGGLE
             ======================================== */
          
          /* Transisi untuk sidebar slide */
          .layout-menu {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
          }

          /* Transisi untuk content expand */
          .layout-wrapper.layout-menu-collapsed .layout-page {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
          }

          /* Transisi untuk navbar transform */
          .layout-wrapper.layout-menu-collapsed .layout-navbar {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
          }
          
          /* Navbar ketika Sidebar Tertutup (Full Width) */
          @media (min-width: 1200px) {
  
            /* Sidebar TERTUTUP - HILANG TOTAL */
            .layout-wrapper.layout-menu-collapsed .layout-menu {
              transform: translateX(-260px) !important;
            }

            /* Layout Page - Wrapper utama dengan padding */
            .layout-wrapper.layout-menu-collapsed .layout-page {
              margin-left: auto !important;
              margin-right: auto !important;
              width: 100% !important;
              padding-left: 2rem !important;
              padding-right: 2rem !important;
            }

            /* Navbar - Compact dan sejajar dengan konten */
            .layout-wrapper.layout-menu-collapsed .layout-navbar {
              width: 100% !important; 
              max-width: 100% !important;
              margin-left: auto !important;
              margin-right: auto !important;
              margin-top: 1rem !important;
              margin-bottom: 1rem !important;
              border-radius: 0.75rem !important; 
              box-shadow: 0 2px 12px rgba(0,0,0,0.06) !important;
              padding: 0.75rem 1.5rem !important;
            }

            /* Content wrapper - Minimal padding */
            .layout-wrapper.layout-menu-collapsed .content-wrapper {
              padding-left: 0.25rem !important;
              padding-right: 0.25rem !important;
              padding-top: 0.5rem !important;
            }

            /* Container konten - Sejajar dengan navbar */
            .layout-wrapper.layout-menu-collapsed .container-xxl,
            .layout-wrapper.layout-menu-collapsed .container-fluid {
              max-width: 100% !important;
              width: 100% !important;
              margin-left: auto !important;
              margin-right: auto !important;
              padding-left: 1.5rem !important;
              padding-right: 1.5rem !important;
            }
          }

          /* Mobile tetap normal */
          @media (max-width: 1199.98px) {
            .layout-menu {
              transform: translateX(-100%);
            }
            
            .layout-menu-expanded .layout-menu {
              transform: translateX(0);
            }
          }
        </style>

        @yield('content')

        @include('layouts.footer')

        <script>
            document.addEventListener('DOMContentLoaded', function() {
              const desktopToggle = document.getElementById('desktop-menu-toggle');
              const layoutWrapper = document.querySelector('.layout-wrapper');
              
              if (desktopToggle && layoutWrapper) {
                desktopToggle.addEventListener('click', function(e) {
                  e.preventDefault();
                  
                  // Toggle class untuk show/hide sidebar
                  layoutWrapper.classList.toggle('layout-menu-collapsed');
                  
                  // Simpan state ke localStorage
                  if (layoutWrapper.classList.contains('layout-menu-collapsed')) {
                    localStorage.setItem('sidebarState', 'collapsed');
                  } else {
                    localStorage.setItem('sidebarState', 'expanded');
                  }
                });
                
                // Load saved state dari localStorage
                const savedState = localStorage.getItem('sidebarState');
                if (savedState === 'collapsed') {
                  layoutWrapper.classList.add('layout-menu-collapsed');
                }
              }
            });
        </script>

</body>
</html>