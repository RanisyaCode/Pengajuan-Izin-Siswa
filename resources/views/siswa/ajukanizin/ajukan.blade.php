@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-wrapper">
                        <i class="bx bx-send fs-4 text-dark"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">{{ $title }}</h4>
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('siswa.ajukan-izin.form') }}" class="btn btn-primary-soft btn-sm d-flex align-items-center gap-2 px-3 py-2">
                        <i class="bx bx-plus fs-6"></i>
                        <span>Ajukan Izin</span>
                    </a>
                    <a href="{{ route('siswa.ajukanizinPdf') }}" target="_blank" class="btn btn-danger-soft btn-sm d-flex align-items-center gap-2 px-3 py-2">
                        <i class="bx bxs-file-pdf fs-6"></i>
                        <span>PDF</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Success & Error Alerts --}}
    @if(session('success'))
      <script>
        Swal.fire({
          title: "Sukses!",
          text: "{{ session('success') }}",
          icon: "success",
          confirmButtonText: "OK",
          confirmButtonColor: "#3085d6"
        });
      </script>
    @endif

    @if(session('error'))
      <script>
        Swal.fire({
          title: "Gagal!",
          text: "{{ session('error') }}",
          icon: "error",
          confirmButtonText: "OK",
          confirmButtonColor: "#d33"
        });
      </script>
    @endif

    {{-- Content Section --}}
    @if($ajukanizin->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card card-modern border-0">
                    <div class="card-body text-center py-5">
                        <div class="empty-state">
                            <div class="empty-icon mb-4">
                                <i class="bx bx-inbox fs-1 text-muted-light"></i>
                            </div>
                            <h5 class="fw-semibold text-dark mb-2">Belum Ada Pengajuan Izin</h5>
                            <p class="text-muted mb-4">Mulai ajukan izin pertama Anda untuk mencatat kehadiran dengan baik</p>
                            <a href="{{ route('siswa.ajukan-izin.form') }}" class="btn btn-primary-soft px-4">
                                <i class="bx bx-plus me-2"></i>Ajukan Izin Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($ajukanizin as $item)
            <div class="col-12">
                <div class="card card-modern border-0 h-100">
                    {{-- Card Header --}}
                    <div class="card-header-modern d-flex align-items-center justify-content-between p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-wrapper">
                                <div class="avatar-circle">
                                    <i class="bx bx-user fs-5 text-dark"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">
                                    {{ $item->user->nama ?? $item->nama_siswa ?? '-' }}
                                </h6>
                                <span class="badge badge-light-soft fs-7 fw-medium">
                                    {{ $item->user->kelas ?? $item->kelas ?? '-' }}
                                </span>
                            </div>
                        </div>
                        
                        {{-- Status Badge --}}
                        <div>
                            @php $status = strtolower($item->status); @endphp
                            @if ($status === 'menunggu')
                                <span class="badge badge-warning-soft fs-7 fw-medium px-3 py-2">
                                    <i class="bx bx-time me-1"></i>Menunggu
                                </span>
                            @elseif ($status === 'disetujui')
                                <span class="badge badge-success-soft fs-7 fw-medium px-3 py-2">
                                    <i class="bx bx-check-circle me-1"></i>Disetujui
                                </span>
                            @elseif ($status === 'ditolak')
                                <span class="badge badge-danger-soft fs-7 fw-medium px-3 py-2">
                                    <i class="bx bx-x-circle me-1"></i>Ditolak
                                </span>
                            @else
                                <span class="badge badge-secondary-soft fs-7 fw-medium px-3 py-2">
                                    <i class="bx bx-help-circle me-1"></i>{{ $item->status }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body p-4 pt-0">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-icon"><i class="bx bx-calendar text-primary-soft"></i></div>
                                <div class="info-content">
                                    <span class="info-label">Tanggal Izin</span>
                                    <span class="info-value">{{ \Carbon\Carbon::parse($item->tanggal_izin)->format('d F Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon"><i class="bx bx-detail text-info-soft"></i></div>
                                <div class="info-content">
                                    <span class="info-label">Alasan</span>
                                    <span class="info-value">{{ \Illuminate\Support\Str::limit($item->alasan, 100) }}</span>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon"><i class="bx bx-message-rounded text-warning-soft"></i></div>
                                <div class="info-content">
                                    <span class="info-label">Catatan Guru</span>
                                    <span class="info-value fst-italic text-muted">
                                        {{ $item->catatan ? $item->catatan : '— Tidak ada catatan dari guru —' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Bukti Lampiran --}}
                            @if($item->file)
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="bx bx-paperclip text-success-soft"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Bukti Lampiran</span>
                                    <button class="btn btn-light-soft btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#modalLampiran{{ $item->id }}">
                                        <i class="bx bx-file me-1"></i>Lihat File
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Action Buttons --}}
                        <div class="action-buttons mt-4 pt-3 border-top border-light">
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-primary-soft btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#modalAjukanShow{{ $item->id }}">
                                    <i class="bx bx-show me-1"></i>Detail
                                </button>
                                <button type="button" 
                                        class="btn btn-warning-soft btn-sm flex-fill"
                                        data-status="{{ strtolower($item->status) }}"
                                        data-edit-url="{{ route('siswa.edit', $item->id) }}"
                                        onclick="handleEditClick(event)">
                                    <i class="bx bx-edit me-1"></i>Edit
                                </button>
                                <button class="btn btn-danger-soft btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#modalAjukanDestroy{{ $item->id }}">
                                    <i class="bx bx-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('siswa.ajukanizin.modal', ['item' => $item])
            {{-- Modal Lampiran --}}
            <div class="modal fade" id="modalLampiran{{ $item->id }}" tabindex="-1" aria-labelledby="modalLampiranLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold" id="modalLampiranLabel{{ $item->id }}">Bukti Lampiran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            @php
                                $filePath = asset('storage/' . $item->file);
                                $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $item->file);
                                $isPdf = preg_match('/\.pdf$/i', $item->file);
                            @endphp

                            @if($isImage)
                                <img src="{{ $filePath }}" alt="Bukti Izin" class="img-fluid rounded-3 shadow-sm" style="max-height: 500px; object-fit: contain;">
                            @elseif($isPdf)
                                <iframe src="{{ $filePath }}" class="w-100 rounded-3" style="height: 500px; border: none;"></iframe>
                            @else
                                <p class="text-muted fst-italic">File tidak dapat ditampilkan, silakan unduh secara manual.</p>
                                <a href="{{ $filePath }}" target="_blank" class="btn btn-primary-soft mt-2">
                                    <i class="bx bx-download me-1"></i>Unduh File
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $ajukanizin->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    @endif
</div>

{{-- SweetAlert --}}
<script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

<script>
function handleEditClick(event) {
    event.preventDefault();
    const button = event.currentTarget;
    const status = button.dataset.status;
    const editUrl = button.dataset.editUrl;

    if (status === 'disetujui' || status === 'ditolak') {
        showStatusAlert(status);
        return;
    }
    window.location.href = editUrl;
}

function showStatusAlert(status) {
    const s = status.toLowerCase().trim();
    Swal.fire({
        title: s === 'disetujui' ? 'Izin Sudah Disetujui' : 'Izin Sudah Ditolak',
        text: s === 'disetujui' ? 'Pengajuan izin ini sudah disetujui, tidak dapat diedit lagi.' : 'Pengajuan izin ini sudah ditolak, tidak dapat diedit lagi.',
        icon: s === 'disetujui' ? 'success' : 'error',
        confirmButtonText: "OK",
        confirmButtonColor: s === 'disetujui' ? "#3085d6" : "#d33"
    });
}

// Fix backdrop bug on modal close
document.addEventListener('hidden.bs.modal', () => {
  document.body.classList.remove('modal-open');
  document.body.style.overflow = 'auto';
  document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
});
</script>

{{-- Enhanced Pastel Styles --}}
<style>
    .modal-backdrop.show {
    opacity: 0.5 !important;
    background-color: rgba(0, 0, 0, 0.5) !important;
    z-index: 1040 !important;
    }
    .modal { z-index: 1050 !important; }
    .modal iframe { z-index: 1051; }

    .modal-fade-smooth .modal-dialog {
    transform: translateY(-10px);
    opacity: 0;
    transition: all 0.25s ease-in-out;
    }
    .modal-fade-smooth.show .modal-dialog {
    transform: translateY(0);
    opacity: 1;
    }

:root {
    --primary-soft: rgb(90, 158, 235);
    --primary-soft-hover: #7aa5d9;
    --success-soft: #a8d5ba;
    --danger-soft: #f5b7b1;
    --warning-soft: #fff4b3; 
    --info-soft: #aed6f1;
    --secondary-soft: #d5d6da;
    --light-soft: #f8f9fa;
    --muted-light: #9ca3af;
}


/* Header Enhancements */
.icon-wrapper {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-soft), var(--info-soft));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(141, 180, 226, 0.3);
}

/* Button Styles */
.btn-primary-soft {
    background-color: var(--primary-soft);
    border-color: var(--primary-soft);
    color: #2c3e50;
    font-weight: 500;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-primary-soft:hover {
    background-color: var(--primary-soft-hover);
    border-color: var(--primary-soft-hover);
    color: #2c3e50;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(141, 180, 226, 0.4);
}

.btn-danger-soft {
    background-color: var(--danger-soft);
    border-color: var(--danger-soft);
    color: #2c3e50;
    font-weight: 500;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-danger-soft:hover {
    background-color: #f1a7a0;
    border-color: #f1a7a0;
    color: #2c3e50;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(245, 183, 177, 0.4);
}

.btn-warning-soft {
    background-color: var(--warning-soft);
    border-color: var(--warning-soft);
    color: #2c3e50;
    font-weight: 500;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-warning-soft:hover {
    background-color: #f7dc6f;
    border-color: #f7dc6f;
    color: #2c3e50;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(249, 231, 159, 0.4);
}

.btn-light-soft {
    background-color: var(--light-soft);
    border-color: var(--light-soft);
    color: #6c757d;
    font-weight: 500;
    border-radius: 8px;
}

.btn-light-soft:hover {
    background-color: #e9ecef;
    border-color: #e9ecef;
    color: #495057;
}

/* Card Styles */
.card-modern {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.card-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.card-header-modern {
    background: linear-gradient(135deg, #f8fbff 0%, #f0f7ff 100%);
    border-bottom: 1px solid #e3f2fd;
}

/* Avatar Styles */
.avatar-wrapper .avatar-circle {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary-soft), var(--info-soft));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(141, 180, 226, 0.3);
}

/* Badge Styles */
.badge-success-soft {
    background-color: var(--success-soft) !important;
    color: #2c3e50 !important;
    border-radius: 20px;
}

.badge-danger-soft {
    background-color: var(--danger-soft) !important;
    color: #2c3e50 !important;
    border-radius: 20px;
}

.badge-warning-soft {
    background-color: var(--warning-soft) !important;
    color: #2c3e50 !important;
    border-radius: 20px;
    border: 1px solid #f6e58d; 
}


.badge-secondary-soft {
    background-color: var(--secondary-soft) !important;
    color: #2c3e50 !important;
    border-radius: 20px;
}

.badge-light-soft {
    background-color: var(--light-soft) !important;
    color: #6c757d !important;
    border-radius: 15px;
    border: 1px solid #e9ecef;
}

/* Info Grid */
.info-grid {
    display: grid;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.info-icon {
    width: 32px;
    height: 32px;
    background: rgba(141, 180, 226, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6c757d;
}

.info-value {
    font-size: 0.95rem;
    color: #2c3e50;
    line-height: 1.4;
}

/* Alert Styles */
.alert-success-soft {
    background: linear-gradient(135deg, #f0fff4 0%, #e6ffed 100%);
    border: 1px solid #c6f6d5;
    color: #2f855a;
    border-radius: 12px;
}

.alert-icon {
    width: 40px;
    height: 40px;
    background: var(--success-soft);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Empty State */
.empty-state .empty-icon {
    width: 80px;
    height: 80px;
    background: rgba(156, 163, 175, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

/* Action Buttons */
.action-buttons .btn {
    min-width: 80px;
}

/* Color Utilities */
.text-primary-soft { color: var(--primary-soft) !important; }
.text-success-soft { color: var(--success-soft) !important; }
.text-info-soft { color: var(--info-soft) !important; }
.text-muted-light { color: var(--muted-light) !important; }

/* Responsive Design */
@media (max-width: 768px) {
    .card-header-modern {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }
    
    .action-buttons .btn {
        min-width: unset;
    }
    
    .d-flex.align-items-center.justify-content-between.flex-wrap {
        flex-direction: column;
        align-items: flex-start !important;
    }
}

/* Smooth Animations */
* {
    transition: color 0.2s ease, background-color 0.2s ease;
}

.card-modern,
.btn,
.badge {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
@endsection