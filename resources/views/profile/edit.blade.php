@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            
            {{-- Header --}}
            <div class="text-center mb-5">
                <div class="d-inline-block position-relative mb-3">
                    <div style="position: absolute; inset: -10px; background: linear-gradient(135deg,#e0e7ff 0%,#fce7f3 100%); border-radius: 50%; opacity: 0.4; filter: blur(15px);"></div>
                    <div class="position-relative p-4 rounded-circle shadow-sm" style="background: linear-gradient(135deg,#f0f9ff 0%,#faf5ff 100%);">
                        <i class="bx bx-edit-alt"
                            style="font-size:2.5rem;
                                    background:linear-gradient(135deg,#8b5cf6 0%,#ec4899 100%);
                                    background-clip:text;              
                                    -webkit-background-clip:text;
                                    -webkit-text-fill-color:transparent;">
                        </i>
                    </div>
                </div>
                <h2 class="fw-bold mb-2"
                    style="background:linear-gradient(135deg,#8b5cf6 0%,#ec4899 100%);
                        background-clip:text;
                        -webkit-background-clip:text;
                        -webkit-text-fill-color:transparent;">
                    Edit Profil Saya
                </h2>
                <p class="text-muted">Perbarui informasi profil dan foto Anda dengan mudah</p>
            </div>

            {{-- Error Validation --}}
            @if($errors->any())
                <div class="alert border-0 shadow-sm mb-4" style="border-radius:16px;background:linear-gradient(135deg,#fef2f2 0%,#fee2e2 100%);">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0 me-3">
                            <div class="p-2 rounded-circle" style="background:rgba(239,68,68,0.1);">
                                <i class="bx bx-error-circle" style="font-size:1.5rem;color:#dc2626;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-2" style="color:#991b1b;">Terdapat Kesalahan</h6>
                            <ul class="mb-0 small" style="color:#7f1d1d;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form Utama Update Profil --}}
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    {{-- Kiri: Foto Profil --}}
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius:20px;background:linear-gradient(135deg,#fefce8 0%,#fef3c7 100%);">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4" style="color:#854d0e;">
                                    <i class="bx bx-camera me-2"></i>Foto Profil
                                </h5>

                                {{-- Foto Saat Ini --}}
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <div style="position:absolute;inset:-8px;background:linear-gradient(135deg,#fbbf24 0%,#f59e0b 100%);border-radius:50%;opacity:0.15;filter:blur(12px);"></div>
                                        <div style="position:relative;">
                                            <div style="padding:5px;background:linear-gradient(135deg,#fef3c7 0%,#fde68a 100%);border-radius:50%;">
                                                <img src="{{ $profile && $profile->profile_photo ? asset('storage/profile_photos/'.$profile->profile_photo) : asset('sneat/assets/img/avatars/1.png') }}"
                                                    id="currentPhoto"
                                                    class="rounded-circle shadow"
                                                    width="160" height="160"
                                                    style="object-fit:cover;border:5px solid white;"
                                                    alt="Current Photo">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tombol Pilih Foto --}}
                                <div class="text-center mb-3">
                                    <label for="photoInput" class="btn rounded-pill shadow-sm px-4 py-2 w-100 mb-2"
                                        style="background:linear-gradient(135deg,#fbbf24 0%,#f59e0b 100%);color:white;border:none;cursor:pointer;font-weight:600;">
                                        <i class="bx bx-upload me-2"></i>Pilih Foto Baru
                                    </label>
                                    <input type="file" name="profile_photo" id="photoInput" class="d-none" accept="image/*">

                                    {{-- Tombol Hapus Foto (Form Terpisah) --}}
                                    @if($profile && $profile->profile_photo)
                                        <button type="button" onclick="confirmDeletePhoto(event)"
                                            class="btn rounded-pill shadow-sm w-100 fw-semibold"
                                            style="background:#fee2e2;color:#991b1b;border:none;">
                                            <i class="bx bx-trash me-2"></i>Hapus Foto Profil
                                        </button>
                                    @endif
                                </div>

                                <div class="alert border-0 mb-0" style="background:rgba(255,255,255,0.5);border-radius:12px;">
                                    <small class="text-muted d-block text-center">
                                        <i class="bx bx-info-circle me-1"></i>
                                        JPG, PNG atau JPEG<br>Maksimal 2MB
                                    </small>
                                </div>

                                {{-- Preview --}}
                                <div id="previewArea" style="display:none;" class="mt-3">
                                    <div class="alert border-0 shadow-sm" style="background:rgba(255,255,255,0.7);border-radius:12px;">
                                        <p class="text-center small fw-semibold mb-2" style="color:#854d0e;">
                                            <i class="bx bx-check-circle"></i> Foto Baru Dipilih
                                        </p>
                                        <div class="text-center">
                                            <img id="croppedPreview" class="rounded-circle shadow-sm" width="80" height="80" style="object-fit:cover;border:3px solid white;">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="cropped_image" id="croppedImageData">
                            </div>
                        </div>
                    </div>

                    {{-- Kanan: Informasi --}}
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm h-100" style="border-radius:20px;background:white;">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4" style="color:#6b7280;">
                                    <i class="bx bx-user-circle me-2"></i>Informasi Pribadi
                                </h5>

                                {{-- Nama --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold small mb-2">Nama Lengkap</label>
                                    <div class="input-group shadow-sm" style="border-radius:14px;overflow:hidden;">
                                        <span class="input-group-text border-0 px-4" style="background:linear-gradient(135deg,#e0f2fe 0%,#dbeafe 100%);">
                                            <i class="bx bx-user" style="color:#0284c7;font-size:1.2rem;"></i>
                                        </span>
                                        <input type="text" name="nama" class="form-control border-0 py-3 px-3" style="background:#f9fafb;"
                                               value="{{ old('nama',$user->nama) }}" required>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold small mb-2">Alamat Email</label>
                                    <div class="input-group shadow-sm" style="border-radius:14px;overflow:hidden;">
                                        <span class="input-group-text border-0 px-4" style="background:linear-gradient(135deg,#e0f2fe 0%,#dbeafe 100%);">
                                            <i class="bx bx-envelope" style="color:#0284c7;font-size:1.2rem;"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control border-0 py-3 px-3" style="background:#f9fafb;"
                                               value="{{ old('email',$user->email) }}" required>
                                    </div>
                                </div>

                                {{-- Password (Opsional) --}}
                                <div class="my-4 position-relative">
                                    <hr style="border:none;height:1px;background:#e5e7eb;margin:0;">
                                    <span class="position-absolute top-50 start-50 translate-middle px-3 small fw-semibold" style="background:white;color:#9ca3af;">
                                        Keamanan
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold small mb-2">Ubah Password 
                                        <span class="badge rounded-pill ms-2" style="background:#fef3c7;color:#78350f;">OPSIONAL</span>
                                    </label>
                                    <p class="small text-muted mb-3">Kosongkan jika tidak ingin mengubah password</p>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="password" name="password" class="form-control shadow-sm" placeholder="Password baru">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="password" name="password_confirmation" class="form-control shadow-sm" placeholder="Konfirmasi password">
                                        </div>
                                    </div>
                                </div>

                                {{-- Tombol --}}
                                <div class="d-flex gap-3 mt-5 flex-wrap">
                                    <button type="submit" class="btn flex-fill px-4 py-3 rounded-pill text-white shadow-sm fw-semibold"
                                            style="background:linear-gradient(135deg,#0ea5e9 0%,#8b5cf6 100%);border:none;">
                                        <i class="bx bx-check-circle me-2"></i>Simpan Perubahan
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="btn flex-fill px-4 py-3 rounded-pill shadow-sm fw-semibold"
                                       style="background:#f3f4f6;color:#6b7280;border:none;">
                                        <i class="bx bx-x-circle me-2"></i>Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Area Cropper --}}
                <div id="cropperArea" style="display:none;" class="mt-4">
                    <div class="card border-0 shadow-lg" style="border-radius:20px;background:white;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0" style="color:#374151;">
                                    <i class="bx bx-crop me-2" style="color:#8b5cf6;"></i>Pangkas Foto
                                </h5>
                            </div>
                            <div style="max-height:450px;overflow:hidden;border-radius:16px;background:#f9fafb;">
                                <img id="imageToCrop" style="max-width:100%;display:block;">
                            </div>
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" id="cropButton" class="btn px-5 py-3 rounded-pill shadow-sm fw-semibold text-white"
                                        style="background:linear-gradient(135deg,#10b981 0%,#34d399 100%);">
                                    <i class="bx bx-check me-2"></i>Pangkas & Simpan
                                </button>
                                <button type="button" id="cancelCrop" class="btn px-5 py-3 rounded-pill shadow-sm fw-semibold"
                                        style="background:#f3f4f6;color:#6b7280;">
                                    <i class="bx bx-x me-2"></i>Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Cropper --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<script>
let cropper;
const photoInput=document.getElementById('photoInput');
const imageToCrop=document.getElementById('imageToCrop');
const cropperArea=document.getElementById('cropperArea');
const previewArea=document.getElementById('previewArea');
const croppedPreview=document.getElementById('croppedPreview');
const currentPhoto=document.getElementById('currentPhoto');
const croppedImageData=document.getElementById('croppedImageData');
const cropButton=document.getElementById('cropButton');
const cancelCrop=document.getElementById('cancelCrop');

photoInput.addEventListener('change',function(e){
    const file=e.target.files[0];
    if(!file)return;
    if(!file.type.match('image.*')){
        Swal.fire({icon:'error',title:'Format Salah',text:'Pilih JPG/PNG/JPEG'}); photoInput.value=''; return;
    }
    if(file.size>2*1024*1024){
        Swal.fire({icon:'warning',title:'Terlalu Besar',text:'Maks 2MB'}); photoInput.value=''; return;
    }
    const reader=new FileReader();
    reader.onload=function(evt){
        imageToCrop.src=evt.target.result;
        cropperArea.style.display='block';
        previewArea.style.display='none';
        if(cropper)cropper.destroy();
        cropper=new Cropper(imageToCrop,{aspectRatio:1,viewMode:2,autoCropArea:0.85});
    };
    reader.readAsDataURL(file);
});

cropButton.addEventListener('click',()=>{
    if(!cropper)return;
    const canvas=cropper.getCroppedCanvas({width:500,height:500});
    const data=canvas.toDataURL('image/jpeg',0.9);
    croppedImageData.value=data;
    croppedPreview.src=data;
    currentPhoto.src=data;
    previewArea.style.display='block';
    cropperArea.style.display='none';
    cropper.destroy();
    Swal.fire({icon:'success',title:'Foto siap disimpan!',text:'Klik Simpan Perubahan untuk menyimpan.'});
});

cancelCrop.addEventListener('click',()=>{
    if(cropper)cropper.destroy();
    cropperArea.style.display='none';
    previewArea.style.display='none';
    photoInput.value='';
});

function confirmDeletePhoto(e){
    e.preventDefault();
    Swal.fire({
        icon: 'warning',
        title: 'Hapus Foto Profil?',
        text: 'Foto Anda akan diganti dengan avatar default.',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((res) => {
        if (res.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('profile.deletePhoto') }}";
            form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection