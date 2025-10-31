@extends('layouts.app')

@section('content')
<div class="container my-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">

      <div class="card shadow-lg border-0" style="border-radius: 1rem;">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap" 
             style="background: linear-gradient(90deg, #FFD3A5, #FD6585); color: #fff; border-radius: 1rem 1rem 0 0;">
          <h5 class="mb-2 mb-md-0">
            <i class="bx bx-edit-alt me-2"></i> Edit User
          </h5>
          <a href="{{ route('manajemenuser.manajemen') }}" class="btn btn-sm btn-light">
            <i class="bx bx-arrow-back me-1"></i> Kembali
          </a>
        </div>

        <!-- Body -->
        <div class="card-body p-4" style="background-color: #fffdf9;">
          <form action="{{ route('manajemenuser.update', $manajemen->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="mb-3">
              <label class="form-label fw-semibold"><span class="text-danger">*</span> Nama</label>
              <div class="input-group">
                <span class="input-group-text bg-light"><i class="bx bx-user"></i></span>
                <input type="text" name="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       value="{{ $manajemen->nama }}" placeholder="Masukkan nama lengkap">
              </div>
              @error('nama')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label class="form-label fw-semibold"><span class="text-danger">*</span> Email</label>
              <div class="input-group">
                <span class="input-group-text bg-light"><i class="bx bx-envelope"></i></span>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ $manajemen->email }}" placeholder="contoh@email.com">
              </div>
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Role -->
            <div class="mb-3">
              <label class="form-label fw-semibold"><span class="text-danger">*</span> Role</label>
              <div class="input-group">
                <span class="input-group-text bg-light"><i class="bx bx-shield"></i></span>
                <select name="role" class="form-select @error('role') is-invalid @enderror">
                  <option disabled>-- Pilih Role --</option>
                  <option value="Admin" {{ $manajemen->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                  <option value="Siswa" {{ $manajemen->role == 'Siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
              </div>
              @error('role')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label class="form-label fw-semibold"><span class="text-danger">*</span> Password</label>
              <div class="input-group">
                <span class="input-group-text bg-light"><i class="bx bx-lock"></i></span>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Masukkan password baru">
              </div>
              @error('password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
              <label class="form-label fw-semibold"><span class="text-danger">*</span> Konfirmasi Password</label>
              <div class="input-group">
                <span class="input-group-text bg-light"><i class="bx bx-check-shield"></i></span>
                <input type="password" name="password_confirmation"
                       class="form-control" placeholder="Ulangi password baru">
              </div>
            </div>

            <!-- Tombol -->
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-between">
              <a href="{{ route('manajemenuser.manajemen') }}" class="btn btn-outline-secondary w-100 w-sm-auto">
                <i class="bx bx-arrow-back me-1"></i> Kembali
              </a>
              <button type="submit" class="btn btn-warning text-white shadow-sm w-100 w-sm-auto">
                <i class="bx bx-save me-1"></i> Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
