<!-- Modal Toggle 1 -->
<div class="modal fade" id="deleteModal1-{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pastel-modal-danger">
            <div class="modal-header">
                <h5 class="modal-title">Hapus {{ $title }}?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus <strong>{{ $item->nama }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger" 
                    data-bs-target="#deleteModal2-{{ $item->id }}" 
                    data-bs-toggle="modal" 
                    data-bs-dismiss="modal">
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Toggle 2 -->
<div class="modal fade" id="deleteModal2-{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content pastel-modal-warning">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-5 fw-semibold">Nama</div>
                    <div class="col-7">: {{ $item->nama }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5 fw-semibold">Email</div>
                    <div class="col-7">: <span class="badge badge-pastel-cyan">{{ $item->email }}</span></div>
                </div>
                <div class="row">
                    <div class="col-5 fw-semibold">Role</div>
                    <div class="col-7">
                        :
                        @if(strtolower($item->role) === 'admin')
                            <span class="badge badge-pastel-purple">{{ ucfirst($item->role) }}</span>
                        @else
                            <span class="badge badge-pastel-green">{{ ucfirst($item->role) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" 
                    data-bs-target="#deleteModal1-{{ $item->id }}" 
                    data-bs-toggle="modal" 
                    data-bs-dismiss="modal">
                    Kembali
                </button>
                <form action="{{ route('manajemenuser.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- CSS khusus modal pastel -->
<style>
.pastel-modal-danger .modal-header {
    background-color: #f4b6b6; /* pastel merah */
    color: #1d3557; /* teks biru tua */
}
.pastel-modal-warning .modal-header {
    background-color: #fce8b2; /* pastel kuning */
    color: #1d3557; /* teks biru tua */
}
.pastel-modal-danger .btn-close,
.pastel-modal-warning .btn-close {
    filter: invert(0.2); /* biar close button terlihat */
}
</style>
