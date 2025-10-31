@extends('layouts.app')

@section('content')
<div class="container-xxl py-4">

    <!-- Judul Halaman -->
    <h4 class="fw-bold mb-4 d-flex align-items-center gap-2 text-pastel-blue">
        <i class="bx bx-user-circle"></i>
        <span>{{ $title }}</span>
    </h4>

    <div class="card shadow-sm border-0 pastel-card">
        <!-- Header -->
        <div class="card-header pastel-card-header d-flex justify-content-between align-items-center py-2 px-3">
            <a href="{{ route('manajemenuser.create') }}" class="btn btn-sm btn-pastel-primary">
                <i class="bx bx-user-plus me-1"></i> Tambah Data
            </a>
            <div class="d-flex gap-1">
                <a href="{{ route('manajemen.export.excel') }}" target="_blank" class="btn btn-sm btn-pastel-success">
                    <i class="bx bx-file me-1"></i> Excel
                </a>
                <a href="{{ route('manajemen.export.pdf') }}" target="_blank" class="btn btn-sm btn-pastel-danger">
                    <i class="bx bx-file me-1"></i> PDF
                </a>
            </div>
        </div>

        <div class="card-body p-3">

            <!-- 🔍 Search & Filter -->
            <form method="GET" action="{{ route('manajemenuser.manajemen') }}" class="row g-2 mb-3 align-items-center">
                <div class="col-md-3">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="form-control form-control-sm pastel-input" placeholder="Cari nama/email...">
                </div>
                <div class="col-md-2">
                    <select name="role" class="form-select form-select-sm pastel-input">
                        <option value="all" {{ request('role')=='all' ? 'selected' : '' }}>Semua Role</option>
                        <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
                        <option value="siswa" {{ request('role')=='siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-pastel-primary w-100">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('manajemenuser.manajemen') }}" class="btn btn-sm btn-secondary w-100">Reset</a>
                </div>
            </form>

            <!-- 🔹 Table -->
            <div class="table-responsive w-100">
                <table class="table table-hover table-striped align-middle pastel-table" style="min-width: 700px;">
                    <thead class="table-light pastel-table-header">
                        <tr class="text-center">
                            <th style="width:5%">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th style="width:10%">Role</th>
                            <th style="width:15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($manajemen as $item)
                        <tr>
                            <td class="text-center">
                                {{ ($manajemen->currentPage() - 1) * $manajemen->perPage() + $loop->iteration }}
                            </td>
                            <td class="fw-semibold">{{ $item->nama }}</td>
                            <td class="text-center">
                                <span class="badge badge-pastel-cyan">{{ $item->email }}</span>
                            </td>
                            <td class="text-center">
                                @if(strtolower($item->role) === 'admin')
                                <span class="badge badge-pastel-purple">{{ ucfirst($item->role) }}</span>
                                @else
                                <span class="badge badge-pastel-green">{{ ucfirst($item->role) }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn p-0 dropdown-toggle hide-arrow" type="button" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('manajemenuser.edit', $item->id) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal1-{{ $item->id }}">
                                                <i class="bx bx-trash me-1"></i> Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        @include('admin.manajemenuser.modal', ['item' => $item, 'title' => $title])
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                @if ($manajemen->hasPages())
                    {{ $manajemen->appends(request()->query())->links('pagination::bootstrap-5') }}
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
.text-pastel-blue { color: #6c9bcf !important; }
.pastel-card { background-color: #fefdfc; border-radius: 12px; }
.pastel-card-header { background-color: #f7f9fc; border-bottom: none; }

.btn-pastel-primary { background-color: #a3c4f3; color: #1d3557; }
.btn-pastel-success { background-color: #b9e1c7; color: #1d3557; }
.btn-pastel-danger { background-color: #f4b6b6; color: #1d3557; }

.pastel-table tbody tr:hover { background-color: #e3f2fd !important; }
.pastel-table-header { background-color: #f0f4f8 !important; }

.badge-pastel-cyan { background-color: #a8dadc !important; color: #1d3557 !important; }
.badge-pastel-green { background-color: #c7f0d4 !important; color: #1d3557 !important; }
.badge-pastel-purple { background-color: #d5c6f1 !important; color: #1d3557 !important; }

.pastel-input { border-radius: 6px; border: 1px solid #d6e4f0; }

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
</style>
@endsection
