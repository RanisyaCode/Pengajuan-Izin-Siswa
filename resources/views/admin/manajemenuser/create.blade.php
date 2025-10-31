@extends('layouts.app')

@section('content')
<style>
  .card-pastel {
    background-color: #fdfdff;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
  }
  .card-pastel .card-header {
    background: linear-gradient(135deg, #3b82f6, #60a5fa, #93c5fd);
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    color: #fff;
  }
  .card-pastel .card-header h5,
  .card-pastel .card-header small {
    color: #fff !important;
  }
  .btn-pastel-primary {
    background: linear-gradient(135deg, #93c5fd, #60a5fa);
    border: none;
    color: #fff;
    transition: 0.3s;
  }
  .btn-pastel-primary:hover {
    background: linear-gradient(135deg, #60a5fa, #3b82f6);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(96,165,250,0.3);
  }
  .btn-pastel-light {
    background: #e0f2fe;
    border: 1px solid #bfdbfe;
    color: #1e40af;
    transition: 0.3s;
  }
  .btn-pastel-light:hover {
    background: #bfdbfe;
    transform: translateY(-1px);
  }
  .input-group-text {
    background-color: #eff6ff;
    color:rgb(114, 150, 229);
    font-weight: bold;
  }
  h4 i {
    color:rgb(100, 134, 206);
  }
  .form-wrapper {
    max-width: 520px;
    width: 100%;
  }
  .text-primary {
    color:rgb(136, 163, 252) !important;
  }
</style>

<div class="d-flex justify-content-center mt-4 mb-5">
  <div class="form-wrapper w-100 px-3">

    <!-- Header sejajar -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
      <h4 class="text-primary fw-bold mb-2 mb-md-0">
        <i class="bx bx-plus-circle me-2"></i> Tambah User
      </h4>
      <a href="{{ route('manajemenuser.manajemen') }}" class="btn btn-sm btn-pastel-light">
        <i class="bx bx-arrow-back me-1"></i> Kembali
      </a>
    </div>

    <div class="card card-pastel mb-5">
      <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <h5 class="mb-0"><i class="bx bx-user-plus me-1"></i> Form Tambah User</h5>
        <small>Lengkapi data dengan benar</small>
      </div>
      <div class="card-body p-4">
        <form action="{{ route('manajemenuser.store') }}" method="POST">
          @csrf

          {{-- Nama --}}
          <div class="mb-3">
            <label class="form-label" for="nama">Nama <span class="text-danger">*</span></label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="bx bx-user"></i></span>
              <input type="text" name="nama" id="nama"
                class="form-control @error('nama') is-invalid @enderror"
                placeholder="John Doe" value="{{ old('nama') }}">
            </div>
            @error('nama')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          {{-- Email --}}
          <div class="mb-3">
            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="bx bx-envelope"></i></span>
              <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="johndoe@gmail.com" value="{{ old('email') }}">
            </div>
            @error('email')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          {{-- Role --}}
          <div class="mb-3">
            <label class="form-label" for="role">Role <span class="text-danger">*</span></label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="bx bx-shield"></i></span>
              <select name="role" id="role"
                class="form-select @error('role') is-invalid @enderror">
                <option disabled selected>-- Pilih Role --</option>
                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Siswa" {{ old('role') == 'Siswa' ? 'selected' : '' }}>Siswa</option>
              </select>
            </div>
            @error('role')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>

          {{-- Password & Konfirmasi --}}
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
              <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="bx bx-lock"></i></span>
                <input type="password" name="password" id="password"
                  class="form-control @error('password') is-invalid @enderror"
                  placeholder="••••••••">
              </div>
              @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label" for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
              <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                <input type="password" name="password_confirmation" id="password_confirmation"
                  class="form-control"
                  placeholder="••••••••">
              </div>
            </div>
          </div>

          <div class="mt-4 d-flex justify-content-between">
            <button type="submit" class="btn btn-pastel-primary">
              <i class="bx bx-save me-1"></i> Simpan
            </button>
            <a href="{{ route('manajemenuser.manajemen') }}" class="btn btn-pastel-light">
              <i class="bx bx-x-circle me-1"></i> Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection