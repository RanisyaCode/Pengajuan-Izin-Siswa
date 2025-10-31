{{-- Modal Detail --}}
<div class="modal fade" id="modalAjukanShow{{ $item->id }}" tabindex="-1" aria-labelledby="modalAjukanShowLabel{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold" id="modalAjukanShowLabel{{ $item->id }}">
          <i class="bx bx-info-circle me-1"></i> Detail Pengajuan Izin
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <ul class="list-unstyled">
          <li><strong>Nama:</strong> {{ $item->user->nama ?? $item->nama_siswa }}</li>
          <li><strong>Kelas:</strong> {{ $item->user->kelas ?? $item->kelas }}</li>
          <li><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tanggal_izin)->format('d-m-Y') }}</li>
          <li><strong>Alasan:</strong> {{ $item->alasan }}</li>
          @if($item->file)
            <li><strong>Bukti:</strong> 
              <a href="{{ asset('storage/'.$item->file) }}" target="_blank" class="btn btn-sm btn-pastel-primary rounded-pill">
                <i class="bx bx-file"></i> Lihat File
              </a>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </div>
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="modalAjukanDestroy{{ $item->id }}" tabindex="-1" aria-labelledby="modalAjukanDestroyLabel{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-light">
        <h6 class="modal-title fw-bold" id="modalAjukanDestroyLabel{{ $item->id }}">
          <i class="bx bx-trash me-1"></i> Konfirmasi Hapus
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body text-center">
        <p>Yakin ingin menghapus izin <strong>{{ $item->user->nama ?? $item->nama_siswa }}</strong>?</p>
      </div>
      <div class="modal-footer justify-content-center">
        <form action="{{ route('siswa.destroy', $item->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-pastel-danger rounded-pill px-3">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
