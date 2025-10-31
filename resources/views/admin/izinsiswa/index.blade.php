@extends('layouts.app')

@section('content')
<div class="container-xxl py-4">

    <!-- Judul Halaman -->
    <h4 class="fw-bold d-flex align-items-center gap-2 text-pastel-blue mb-2">
        <i class="bx bx-folder-open"></i>
        <span>Data Izin Siswa</span>
    </h4>

    <!-- Export Button di bawah judul -->
    <div class="d-flex justify-content-end mb-3">
        <div class="d-flex gap-2">
            <a href="{{ route('dataizinExcel') }}" 
               class="btn btn-sm btn-pastel-success rounded-pill px-3 shadow-sm">
                <i class="bx bx-file me-1"></i> Excel
            </a>
            <a href="{{ route('dataizinPdf') }}" target="_blank" 
               class="btn btn-sm btn-pastel-danger rounded-pill px-3 shadow-sm">
                <i class="bx bx-file me-1"></i> PDF
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm border-0 mb-3 pastel-card">
        <div class="card-body py-3">
            <form method="GET" class="d-flex flex-wrap gap-2">
                <input type="text" name="nama" class="form-control form-control-sm rounded-pill"
                    placeholder="Cari nama siswa" value="{{ request('nama') }}">
                <input type="text" name="kelas" class="form-control form-control-sm rounded-pill"
                    placeholder="Cari kelas" value="{{ request('kelas') }}">
                <input type="date" name="tanggal" class="form-control form-control-sm rounded-pill"
                    value="{{ request('tanggal') }}">
                <select name="status" class="form-select form-select-sm rounded-pill">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button class="btn btn-sm btn-pastel-primary rounded-pill px-3">
                    <i class="bx bx-filter-alt me-1"></i> Filter
                </button>
                @if(request()->hasAny(['nama','kelas','tanggal','status']))
                    <a href="{{ route('izinsiswa') }}" class="btn btn-sm btn-secondary rounded-pill px-3">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm border-0 pastel-card">
        <div class="card-body p-3">
            <div class="table-responsive w-100">
                <table class="table table-hover table-striped align-middle pastel-table" style="min-width: 950px;">
                    <thead class="table-light pastel-table-header">
                        <tr class="text-center">
                            <th style="width:5%">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tanggal Izin</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Catatan</th> 
                            <th style="width:10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($izin as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->user?->nama ?? $item->nama_siswa ?? '-' }}</td>
                            <td class="text-center">{{ $item->kelas }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_izin)->format('d-m-Y') }}</td>
                            <td>{{ $item->alasan }}</td>
                            <td class="text-center">
                                <form action="{{ route('izin.updateStatus', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" 
                                        class="form-select form-select-sm text-center rounded-pill pastel-status 
                                            {{ $item->status == 'menunggu' ? 'bg-warning text-dark' : 
                                                ($item->status == 'disetujui' ? 'bg-success text-white' : 'bg-danger text-white') }}" 
                                        onchange="this.form.submit()">

                                        <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>
                                            Menunggu
                                        </option>
                                        <option value="disetujui" {{ $item->status == 'disetujui' ? 'selected' : '' }}>
                                            Disetujui
                                        </option>
                                        <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-center">
                                @if($item->file)
                                    @php $ext = strtolower(pathinfo($item->file, PATHINFO_EXTENSION)); @endphp
                                    @if(in_array($ext, ['jpg','jpeg','png','gif']))
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $item->id }}">
                                            <img src="{{ asset('storage/'.$item->file) }}" class="rounded shadow-sm" style="width:60px; height:60px; object-fit:cover;">
                                        </a>
                                        <!-- Modal Gambar -->
                                        <div class="modal fade" id="buktiModal{{ $item->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Bukti Izin</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/'.$item->file) }}" class="img-fluid rounded">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($ext === 'pdf')
                                        <a href="{{ asset('storage/'.$item->file) }}" target="_blank" class="btn btn-sm btn-pastel-danger rounded-pill">
                                            <i class="bx bx-file"></i> Lihat PDF
                                        </a>
                                    @else
                                        <a href="{{ route('izin.download', $item->id) }}" class="btn btn-sm btn-secondary rounded-pill">
                                            <i class="bx bx-download"></i> Download
                                        </a>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Tidak ada</span>
                                @endif
                            </td>

                            <!-- Catatan Guru di kolom tabel -->
                            <td class="text-center">
                                {{ $item->catatan ?? '' }}

                                <!-- Tombol Edit Catatan -->
                                <button class="btn btn-sm btn-outline-primary rounded-pill ms-2" 
                                        data-bs-toggle="modal" data-bs-target="#catatanModal{{ $item->id }}">
                                    <i class="bx bx-edit"></i>
                                </button>

                                <!-- Modal Edit Catatan -->
                                <div class="modal fade" id="catatanModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="{{ route('izin.updateCatatan', $item->id) }}" method="POST" class="modal-content">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Catatan Guru</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea name="catatan" rows="3" class="form-control rounded">{{ $item->catatan }}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary rounded-pill">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn p-0 dropdown-toggle hide-arrow" type="button" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalDataIzinShow{{ $item->id }}">
                                                <i class="bx bx-show me-1"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#modalDataIzinDestroy{{ $item->id }}">
                                                <i class="bx bx-trash me-1"></i> Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                @include('admin.izinsiswa.modal')
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data izin</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

           <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                @if ($izin->hasPages())
                    {{ $izin->appends(request()->query())->links('pagination::bootstrap-5') }}
                @else
                    <nav>
                        <ul class="pagination mb-0">
                            <li class="page-item active">
                                <a class="page-link rounded-pill pastel-page" href="#">1</a>
                            </li>
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Pastel Colors CSS -->
<style>
.pagination .page-link {
    border: none;
    color: #1d3557;
    padding: 6px 12px;
    margin: 0 3px;
    border-radius: 20px;
}
.pagination .page-item.active .page-link {
    background-color: #a3c4f3;
    color: #1d3557;
    font-weight: bold;
}
.pagination .page-link:hover {
    background-color: #e3f2fd;
    color: #1d3557;
}

.text-pastel-blue { color: #6c9bcf !important; }
.pastel-card { background-color: #fefdfc; border-radius: 12px; }
.btn-pastel-primary { background-color: #a3c4f3; color: #1d3557; }
.btn-pastel-success { background-color: #b9e1c7; color: #1d3557; }
.btn-pastel-danger { background-color: #f4b6b6; color: #1d3557; }
.pastel-table tbody tr:hover { background-color: #e3f2fd !important; }
.pastel-table-header { background-color: #f0f4f8 !important; }
.badge-pastel-green { background-color: #c7f0d4 !important; color: #1d3557 !important; }
.badge-pastel-danger { background-color: #f4b6b6 !important; color: #1d3557 !important; }
.badge-pastel-purple { background-color: #d5c6f1 !important; color: #1d3557 !important; }
</style>
@endsection