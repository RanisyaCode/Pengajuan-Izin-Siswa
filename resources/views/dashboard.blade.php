@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-2 mx-4" role="alert">
    <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<style>
/* 🎨 Custom Styles */
:root {
    --bg-light: #f5f7fa;
    --card-bg: #ffffff;
    --border-color: #e0e6ed;
    --text-color: #333333;
    --primary-color: #4a5c9f;
    --secondary-color: #7b88a8;
    --success-color: #4CAF50;
    --warning-color: #FFC107;
    --danger-color: #F44336;
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

body {
    background-color: var(--bg-light);
}

.card {
    border-radius: 1.25rem !important;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}

.card-body {
    padding: 1.5rem !important;
}

.card-header {
    border-top-left-radius: 1.25rem !important;
    border-top-right-radius: 1.25rem !important;
}

.btn-rounded-pill-custom {
    border-radius: 2rem !important;
    padding: 0.75rem 1.5rem !important;
}

.badge-custom {
    border-radius: 1rem !important;
    padding: 0.5rem 1rem !important;
    font-weight: 600 !important;
}

.text-muted    { color: var(--secondary-color) !important; }
.text-dark     { color: var(--text-color) !important; }
.text-primary  { color: var(--primary-color) !important; }
.text-success  { color: var(--success-color) !important; }
.text-warning  { color: var(--warning-color) !important; }
.text-danger   { color: var(--danger-color) !important; }

.stat-card .icon-box {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(74, 92, 159, 0.1);
    font-size: 2rem;
}
.stat-card .bx {
    color: var(--primary-color);
}

/* Biar teks dan gambar tetap sejajar di HP */
.welcome-flex {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.welcome-text {
    flex: 1;
}
.welcome-img {
    flex-shrink: 0;
    max-width: 250px;
}
@media (max-width: 576px) {
    .welcome-flex {
        flex-direction: row; /* tetap horizontal */
        align-items: flex-start;
    }
    .welcome-img {
        max-width: 150px;
    }
}

/* Table hover style */
.table-hover tbody tr:hover {
    background-color: rgba(74, 92, 159, 0.05);
    transition: background-color 0.2s ease;
}
</style>

<!-- Judul Halaman -->
<h2 class="fw-bold pt-3 px-4 mb-1">
    <i class="bx bx-home-circle"></i>
    {{ $title }}
</h2>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <!-- Welcome Card -->
            <div class="col-lg-12 mb-4 order-0">
                <div class="card bg-white">
                    <div class="card-body welcome-flex">

                        <!-- Tulisan Sambutan -->
                        <div class="welcome-text">
                            @if(Auth::user()->role === 'Admin')
                                <h5 class="card-title text-primary">
                                    Selamat Datang, {{ Auth::user()->nama }} 👋
                                </h5>
                                <p class="mb-4 text-muted">
                                    Anda adalah <span class="fw-bold text-dark">Admin</span>. 
                                    Kelola data user dan izin siswa dengan mudah di dashboard ini.
                                </p>
                                <a href="{{ route('izinsiswa') }}" 
                                   class="btn btn-sm btn-primary btn-rounded-pill-custom">
                                   Kelola Izin Siswa
                                </a>

                            @elseif(Auth::user()->role === 'Siswa')
                                <h5 class="card-title text-primary">
                                    Selamat Datang, {{ Auth::user()->nama }} 👋
                                </h5>

                                @if(empty($izinTerbaru))
                                    <p class="mb-4 text-muted">
                                        Kamu <span class="fw-bold text-dark">belum pernah</span> mengajukan izin. 
                                        Ajukan izin sekarang jika diperlukan.
                                    </p>
                                    <a href="{{ route('siswa.ajukan-izin.form') }}" 
                                        class="btn btn-sm btn-primary btn-rounded-pill-custom">
                                        Ajukan Izin
                                    </a>

                                @elseif($izinTerbaru->status === 'menunggu')
                                    <p class="mb-4 text-muted">
                                        Anda memiliki <span class="fw-bold text-dark">{{ $jumlahMenunggu ?? 0 }} izin</span> 
                                        menunggu persetujuan. Cek status terbaru atau tunggu konfirmasi dari wali kelas.
                                    </p>
                                    <a href="{{ route('siswa.ajukan-izin.form') }}" 
                                       class="btn btn-sm btn-primary btn-rounded-pill-custom">
                                       Ajukan Izin
                                    </a>

                                @elseif($izinTerbaru->status === 'disetujui')
                                    <p class="mb-4 text-muted">
                                        Izin terakhir Anda telah 
                                        <span class="fw-bold text-success">DISETUJUI</span>. 
                                        Semoga lancar dan jangan lupa ajukan izin lagi bila diperlukan.
                                    </p>
                                    <a href="{{ route('siswa.ajukan-izin.form') }}" 
                                       class="btn btn-sm btn-primary btn-rounded-pill-custom">
                                       Ajukan Izin
                                    </a>

                                @elseif($izinTerbaru->status === 'ditolak')
                                    <p class="mb-4 text-muted">
                                        Izin terakhir Anda <span class="fw-bold text-danger">DITOLAK</span>. 
                                        Silakan ajukan kembali dengan keterangan yang lebih jelas.
                                    </p>
                                    <a href="{{ route('siswa.ajukan-izin.form') }}" 
                                       class="btn btn-sm btn-primary btn-rounded-pill-custom">
                                       Ajukan Izin
                                    </a>
                                @endif
                            @endif
                        </div>

                        <!-- Ilustrasi Animasi -->
                        <div class="welcome-img text-center">
                            <img src="{{ asset('arsha/assets/img/izin-siswa.png') }}" 
                                 alt="Ilustrasi Pengajuan Izin Siswa" 
                                 class="img-fluid">
                        </div>

                    </div>
                </div>
            </div>

            <!-- Statistik Ringkas -->
            <div class="col-lg-12 order-1">
                <div class="row g-3">

                    {{-- Statistik untuk Admin --}}
                    @if(Auth::user()->role == 'Admin')
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fw-semibold d-block text-muted text-uppercase small">TOTAL USER</span>
                                        <h5 class="mb-0 fw-bold text-dark">{{ $jumlahUser }}</h5>
                                    </div>
                                    <div><i class="bx bx-user fs-1 text-primary"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fw-semibold d-block text-muted text-uppercase small">TOTAL ADMIN</span>
                                        <h5 class="mb-0 fw-bold text-dark">{{ $jumlahAdmin }}</h5>
                                    </div>
                                    <div><i class="bx bx-shield fs-1 text-secondary"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fw-semibold d-block text-muted text-uppercase small">TOTAL SISWA</span>
                                        <h5 class="mb-0 fw-bold text-dark">{{ $jumlahSiswa }}</h5>
                                    </div>
                                    <div><i class="bx bx-user-pin fs-1 text-info"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fw-semibold d-block text-muted text-uppercase small">TOTAL MENUNGGU</span>
                                        <h5 class="mb-0 fw-bold text-dark">{{ $jumlahMenunggu }}</h5>
                                    </div>
                                    <div><i class="bx bx-time-five fs-1 text-warning"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fw-semibold d-block text-muted text-uppercase small">TOTAL DISETUJUI</span>
                                        <h5 class="mb-0 fw-bold text-dark">{{ $jumlahDisetujui }}</h5>
                                    </div>
                                    <div><i class="bx bx-check-circle fs-1 text-success"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fw-semibold d-block text-muted text-uppercase small">TOTAL DITOLAK</span>
                                        <h5 class="mb-0 fw-bold text-dark">{{ $jumlahDitolak }}</h5>
                                    </div>
                                    <div><i class="bx bx-x-circle fs-1 text-danger"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fw-semibold d-block text-muted text-uppercase small">BELUM MENGAJUKAN</span>
                                        <h5 class="mb-0 fw-bold text-dark">{{ $belumMengajukan }}</h5>
                                    </div>
                                    <div><i class="bx bx-user-clock fs-1 text-secondary"></i></div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Statistik untuk Admin --}}
                    @if(Auth::user()->role == 'Admin')
                        {{-- statistik tetap sama --}}

                        {{-- 🕓 Tambahan: Riwayat Izin Terbaru untuk Admin --}}
                        <div class="col-lg-12 mt-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-primary text-white fw-bold">
                                    <i class="bx bx-history me-1"></i> Riwayat Izin Keseluruhan
                                </div>
                                <div class="card-body p-0">
                                    @if(isset($riwayatIzinAdmin) && $riwayatIzinAdmin->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0 align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Nama Siswa</th>
                                                        <th>Tanggal Izin</th>
                                                        <th>Alasan</th>
                                                        <th>Catatan Guru</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($riwayatIzinAdmin as $izin)
                                                        <tr>
                                                            <td>{{ $izin->siswa->nama ?? '-' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</td>
                                                            <td>{{ $izin->alasan ?? '-' }}</td>
                                                            <td>{{ $izin->catatan ?? '-' }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ 
                                                                    $izin->status == 'menunggu' ? 'warning' : 
                                                                    ($izin->status == 'disetujui' ? 'success' : 'danger') }}">
                                                                    {{ strtoupper($izin->status) }}
                                                                </span>
                                                            </td>
                                                            <td class="text-end">
                                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#hapusModalAdmin{{ $izin->id }}">
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="p-4 text-center text-muted">
                                            Belum ada data izin yang tercatat.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Statistik + Riwayat untuk Siswa --}}
                    @if(Auth::user()->role == 'Siswa')
                        @if(!empty($izinTerbaru))
                            <div class="col-lg-12 mb-4 order-0">
                                <div class="card bg-white">
                                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                                        <div>
                                            <span class="fw-semibold d-block text-muted text-uppercase mb-1">
                                                STATUS IZIN TERBARU
                                            </span>
                                            <h4 class="mb-0 fw-bold text-dark">
                                                <span class="badge badge-custom bg-{{ 
                                                    $izinTerbaru->status == 'menunggu' ? 'warning' : ($izinTerbaru->status == 'disetujui' ? 'success' : 'danger') }}">
                                                    {{ strtoupper($izinTerbaru->status) }}
                                                </span>
                                            </h4>
                                        </div>
                                        <div>
                                            <i class="bx bx-{{ 
                                                $izinTerbaru->status == 'menunggu' ? 'time-five text-warning' : ($izinTerbaru->status == 'disetujui' ? 'check-circle text-success' : 'x-circle text-danger') 
                                            }} fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 🕓 Riwayat Izin Terakhir --}}
                            <div class="col-lg-12">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-primary text-white fw-bold">
                                        <i class="bx bx-history me-1"></i> Riwayat Izin Terakhir
                                    </div>
                                    <div class="card-body p-0">
                                        @if($riwayatIzin->isNotEmpty())
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0 align-middle">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Tanggal Pengajuan Izin</th>
                                                            <th>Alasan Siswa</th>
                                                            <th>Catatan Guru</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($riwayatIzin as $izin)
                                                            <tr>
                                                                <td>{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</td>
                                                                <td>{{ $izin->alasan ?? '-' }}</td>
                                                                <td>{{ $izin->catatan ?? '-' }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ 
                                                                        $izin->status == 'menunggu' ? 'warning' : 
                                                                        ($izin->status == 'disetujui' ? 'success' : 'danger') }}">
                                                                        {{ strtoupper($izin->status) }}
                                                                    </span>
                                                                </td>
                                                                <td class="text-end">
                                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                                        data-bs-target="#hapusModal{{ $izin->id }}">
                                                                        <i class="bx bx-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>                        
                                        @else
                                            <div class="p-4 text-center text-muted">
                                                Belum ada riwayat izin.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-xl-6 col-md-12 mb-4 mx-auto">
                                <div class="alert bg-white shadow-sm rounded-3 mb-0 text-center text-dark">
                                    Kamu belum pernah mengajukan izin.
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Modal Konfirmasi Hapus (di luar tabel) --}}
            @if(Auth::user()->role == 'Siswa' && isset($riwayatIzin))
                @foreach($riwayatIzin as $izin)
                <div class="modal fade" id="hapusModal{{ $izin->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">
                                    <i class="bx bx-trash me-2"></i> Hapus Riwayat Izin
                                </h5>
                                <button type="button" class="btn-close btn-close-white" 
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Apakah kamu yakin ingin menghapus izin tanggal 
                                    <strong>{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</strong>?
                                </p>
                                <form action="{{ route('siswa.riwayat.hapus', $izin->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            {{-- 🔴 Modal Konfirmasi Hapus untuk Admin --}}
            @if(Auth::user()->role == 'Admin' && isset($riwayatIzinAdmin))
                @foreach($riwayatIzinAdmin as $izin)
                <div class="modal fade" id="hapusModalAdmin{{ $izin->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">
                                    <i class="bx bx-trash me-2"></i> Hapus Data Izin
                                </h5>
                                <button type="button" class="btn-close btn-close-white" 
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Apakah Anda yakin ingin menghapus izin milik 
                                    <strong>{{ $izin->siswa->nama ?? 'Siswa' }}</strong> 
                                    pada tanggal 
                                    <strong>{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</strong>?
                                </p>
                                <form action="{{ route('admin.riwayat.hapus', $izin->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

        </div>
    </div>
</div>

@endsection