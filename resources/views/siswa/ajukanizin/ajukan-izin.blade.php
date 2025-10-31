@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center mt-4 mb-5">
  <div class="form-wrapper w-100 px-3" style="max-width:520px;">

    <!-- Judul Halaman -->
    <h4 class="fw-bold mb-4 d-flex align-items-center gap-2 text-pastel-blue">
        <style>.text-pastel-blue { color: #6c9bcf !important; }</style>
        <i class="bx bx-edit-alt"></i>
        <span>Tambah Ajukan Izin Siswa</span>
    </h4>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert" style="background-color:#d4f8e8; color:#155724;">
            <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Form Pengajuan Izin (selalu tampil, tanpa pengecekan status disetujui) --}}
    <div class="card border-0 shadow-sm" style="background-color: #f8f9ff;">
        <div class="card-header d-flex justify-content-between align-items-center text-white"
             style="background: linear-gradient(90deg,rgb(85, 155, 234) 0%, #c4b5fd 100%);">
            <h6 class="mb-0 text-white"><i class="bx bx-file me-2"></i> Form Pengajuan Izin</h6>
            <a href="{{ route('siswa.ajukan') }}" class="btn btn-sm text-white shadow-sm"
               style="background: linear-gradient(90deg,rgb(126, 180, 243) 0%,rgb(171, 155, 236) 100%); border:none;">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            <style>
                .readonly-input {
                    background-color: #ffffff !important;
                    border: 1px solid #d0e1ff !important;
                    color: #2b3e5f !important;
                    box-shadow: inset 0 1px 2px rgba(108,155,207,0.1);
                    cursor: not-allowed;
                    transition: 0.2s ease;
                }
                .readonly-input:focus {
                    border-color: #6c9bcf !important;
                    box-shadow: 0 0 0 0.15rem rgba(108,155,207,0.25);
                }
            </style>

            <form action="{{ route('siswa.ajukan-izin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama siswa otomatis --}}
                <div class="mb-3">
                    <label class="form-label"><span class="text-danger">*</span> Nama Siswa</label>
                    <input type="text" 
                           name="nama_siswa" 
                           class="form-control readonly-input" 
                           value="{{ Auth::user()->nama }}" 
                           readonly>
                </div>

                {{-- Kelas otomatis --}}
                <div class="mb-3">
                    <label class="form-label"><span class="text-danger">*</span> Kelas</label>
                    <input type="text" 
                           name="kelas" 
                           class="form-control readonly-input" 
                           value="{{ Auth::user()->kelas }}" 
                           readonly>
                </div>

                {{-- Tanggal izin --}}
                <div class="mt-3">
                    <label class="form-label"><span class="text-danger">*</span> Tanggal Pengajuan Izin</label>
                    <input 
                        type="date" 
                        name="tanggal_izin" 
                        class="form-control @error('tanggal_izin') is-invalid @enderror" 
                        value="{{ old('tanggal_izin') }}"
                        required>
                    @error('tanggal_izin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alasan --}}
                <div class="mt-3">
                    <label class="form-label"><span class="text-danger">*</span> Alasan</label>
                    <textarea name="alasan" 
                              rows="4" 
                              class="form-control @error('alasan') is-invalid @enderror" 
                              placeholder="Tuliskan alasan izin">{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload file --}}
                <div class="mt-3">
                    <label class="form-label">Upload Bukti (PDF / JPG)</label>
                    <input type="file" 
                           name="file" 
                           class="form-control @error('file') is-invalid @enderror" 
                           accept="image/*,application/pdf">
                    <div class="form-text">Bukti pendukung seperti surat dokter, foto kegiatan, dll.</div>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol kirim --}}
                <div class="mt-4 text-end">
                    <button type="submit" class="btn rounded-pill px-4 shadow-sm text-white"
                            style="background: linear-gradient(90deg,rgb(102, 161, 228) 0%,rgb(193, 181, 250) 100%); border:none;">
                        <i class="bx bx-send me-1"></i> Kirim Izin
                    </button>
                </div>
            </form>
        </div>
    </div>

  </div>
</div>
@endsection