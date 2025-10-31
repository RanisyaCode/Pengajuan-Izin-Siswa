@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center mt-4 mb-5">
  <div class="form-wrapper w-100 px-3" style="max-width:520px;">

    {{-- Judul Halaman --}}
    <h4 class="fw-bold mb-4 d-flex align-items-center gap-2 text-pastel-blue text-center">
        <i class="bx bx-edit"></i>
        <span>{{ $title }}</span>
    </h4>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert pastel-alert-success alert-dismissible fade show d-flex align-items-center shadow-sm mb-4 rounded-3" role="alert">
            <i class="bx bx-check-circle me-2 fs-5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm pastel-card">
        <div class="card-header d-flex justify-content-between align-items-center text-white"
             style="background: linear-gradient(90deg,rgb(128, 168, 224) 0%, #cddbf9 100%);">
            <h6 class="mb-0 text-white">
                <i class="bx bx-edit-alt me-2"></i> Form Pengajuan Izin
            </h6>
            <a href="{{ route('siswa.ajukan') }}" class="btn btn-sm text-white shadow-sm"
               style="background: linear-gradient(90deg,rgb(126, 180, 243) 0%,rgb(171, 155, 236) 100%); border:none;">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            {{-- Alert status izin --}}
            @if($izin->status === 'disetujui')
                <div class="alert pastel-alert-success d-flex align-items-center">
                    <i class="bx bx-check-circle me-2 fs-5"></i>
                    <span>Izin ini sudah <b>disetujui</b>, tidak bisa diubah lagi.</span>
                </div>
            @elseif($izin->status === 'ditolak')
                <div class="alert pastel-alert-danger d-flex align-items-center">
                    <i class="bx bx-x-circle me-2 fs-5"></i>
                    <span>Izin ini sudah <b>ditolak</b>, tidak bisa diubah lagi.</span>
                </div>
            @endif

            <form action="{{ route('siswa.update', $izin->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="nama_siswa" value="{{ $izin->nama_siswa }}">

                {{-- 🔹 Disamakan dengan ajukan-izin.blade --}}
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

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">
                            <span class="text-danger">*</span> Nama Siswa
                        </label>
                        <input type="text"
                               class="form-control readonly-input"
                               value="{{ $izin->user->nama }}"
                               readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><span class="text-danger">*</span> Kelas</label>
                        <input type="text"
                               class="form-control readonly-input"
                               value="{{ $izin->kelas ?? Auth::user()->kelas }}"
                               readonly>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label"><span class="text-danger">*</span> Tanggal Pengajuan Izin</label>
                    <input type="date" name="tanggal_izin"
                           class="form-control @error('tanggal_izin') is-invalid @enderror"
                           value="{{ $izin->tanggal_izin }}"
                           @if($izin->status !== 'menunggu') disabled @endif>
                    @error('tanggal_izin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <label class="form-label"><span class="text-danger">*</span> Alasan</label>
                    <textarea name="alasan" rows="4"
                              class="form-control @error('alasan') is-invalid @enderror"
                              placeholder="Tuliskan alasan izin"
                              @if($izin->status !== 'menunggu') disabled @endif>{{ $izin->alasan }}</textarea>
                    @error('alasan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <label class="form-label"><span class="text-danger">*</span> Bukti (PDF / JPG)</label>
                    <input type="file" name="file"
                           class="form-control @error('file') is-invalid @enderror"
                           accept="application/pdf,image/jpeg,image/jpg,image/png"
                           @if($izin->status !== 'menunggu') disabled @endif>
                    <div class="form-text">Bukti pendukung seperti surat dokter, foto kegiatan, dll.</div>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-pastel-primary rounded-pill px-4 shadow-sm text-white"
                            @if($izin->status !== 'menunggu') disabled @endif
                            style="background: linear-gradient(90deg,rgb(102, 161, 228) 0%,rgb(193, 181, 250) 100%); border:none;">
                        <i class="bx bx-send me-1"></i> Edit Izin
                    </button>
                </div>
            </form>
        </div>
    </div>

  </div>
</div>

{{-- Pastel Sneat Custom --}}
<style>
.text-pastel-blue { color: #6c9bcf !important; }
.pastel-card { background-color: #fdfdfd; }
.pastel-alert-success { background-color: #d4f8e8; color: #155d42; border: none; }
.pastel-alert-danger { background-color: #f8d4d4; color: #721c24; border: none; }
.btn-pastel-primary { background-color: #a3c4f3; color: #1d3557; border: none; }
.btn-pastel-primary:hover { background-color: #91b7f1; color: #1d3557; }
</style>
@endsection
