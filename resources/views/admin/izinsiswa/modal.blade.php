<!-- Modal Delete -->
<div class="modal fade" id="modalDataIzinDestroy{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pastel-modal-danger">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Izin Siswa?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-start">
                <div class="row mb-2">
                    <div class="col-5 fw-semibold">Nama</div>
                    <div class="col-7">: {{ $item->user?->nama ?? $item->nama_siswa ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5 fw-semibold">Kelas</div>
                    <div class="col-7">: {{ $item->kelas }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5 fw-semibold">Tanggal Izin</div>
                    <div class="col-7">: {{ \Carbon\Carbon::parse($item->tanggal_izin)->format('d-m-Y') }}</div>
                </div>
                <div class="row">
                    <div class="col-5 fw-semibold">Alasan</div>
                    <div class="col-7">: {{ $item->alasan }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('izin.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show -->
<div class="modal fade" id="modalDataIzinShow{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content pastel-modal-info">
            <div class="modal-header">
                <h5 class="modal-title">Detail Izin Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-start">

                <div class="row mb-2">
                    <div class="col-5 fw-semibold">Nama</div>
                    <div class="col-7">: {{ $item->user?->nama ?? $item->nama_siswa ?? '-' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 fw-semibold">Kelas</div>
                    <div class="col-7">: {{ $item->kelas }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 fw-semibold">Tanggal Izin</div>
                    <div class="col-7">: {{ \Carbon\Carbon::parse($item->tanggal_izin)->format('d-m-Y') }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 fw-semibold">Alasan</div>
                    <div class="col-7">: {{ $item->alasan }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-5 fw-semibold">Status</div>
                    <div class="col-7">
                        :
                        @if($item->status == 'menunggu')
                            <span class="badge badge-pastel-yellow text-dark">Menunggu</span>
                        @elseif($item->status == 'disetujui')
                            <span class="badge badge-pastel-green">Disetujui</span>
                        @else
                            <span class="badge badge-pastel-red">Ditolak</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-5 fw-semibold">Bukti</div>
                    <div class="col-7">
                        @if($item->file)
                            @if(in_array(strtolower(pathinfo($item->file, PATHINFO_EXTENSION)), ['jpg','jpeg','png','gif']))
                                <img src="{{ asset('storage/'.$item->file) }}" class="img-fluid rounded" style="max-width: 200px; height: auto;">
                            @else
                                <a href="{{ route('izin.download', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            @endif
                        @else
                            Tidak ada
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- CSS Pastel Modal -->
<style>
.pastel-modal-danger .modal-header {
    background-color: #f4b6b6; /* pastel merah */
    color: #1d3557;
}
.pastel-modal-info .modal-header {
    background-color: #b5d6f7; /* pastel biru */
    color: #1d3557;
}
.badge-pastel-yellow {
    background-color: #fce8b2;
    color: #1d3557;
}
.badge-pastel-green {
    background-color: #b6f2c1;
    color: #1d3557;
}
.badge-pastel-red {
    background-color: #f4b6b6;
    color: #1d3557;
}
</style>