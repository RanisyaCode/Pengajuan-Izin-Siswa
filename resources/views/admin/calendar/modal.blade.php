<!-- Modal Catatan -->
<div class="modal fade" id="catatanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="catatanForm" class="modal-content border-0 rounded-3 shadow-lg">
            <div class="modal-header bg-primary text-white border-0 rounded-top" style="background: linear-gradient(135deg, #93c5fd 0%, #6366f1 100%);">
                <h5 class="modal-title fw-bold">Catatan Kalender</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="catatanId">
                
                <div class="mb-3">
                    <label for="catatanTanggal" class="form-label text-muted fw-bold">Tanggal</label>
                    <input type="text" class="form-control form-control-lg rounded-pill" id="catatanTanggal" required>
                </div>

                <div class="mb-3">
                    <label for="catatanText" class="form-label text-muted fw-bold">Catatan</label>
                    <textarea class="form-control form-control-lg rounded-3" id="catatanText" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="kategoriEvent" class="form-label text-muted fw-bold">Kategori</label>
                    <select class="form-select form-control-lg rounded-pill" id="kategoriEvent" required>
                        <option value="Acara Pribadi">Acara Pribadi</option>
                        <option value="Acara Sekolah">Acara Sekolah</option>
                        <option value="Penting">Acara Penting</option>
                        <option value="Acara Lainnya">Acara Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between border-0 p-4 pt-0">
                <button type="button" class="btn btn-outline-danger d-none rounded-pill" id="btnDeleteEvent">
                    <i class="bi bi-trash me-1"></i> Hapus
                </button>
                <div class="ms-auto">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill" style="background: linear-gradient(135deg, #93c5fd 0%, #6366f1 100%); border: none;">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="hapusCatatanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header bg-danger text-white border-0 rounded-top" style="background: linear-gradient(135deg, #fca5a5 0%, #ef4444 100%);">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-trash me-1"></i> Hapus Catatan?
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body p-4 text-center">
                <p class="mb-0 text-muted">Apakah kamu yakin ingin menghapus catatan ini?</p>
            </div>

            <div class="modal-footer border-0 p-3">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-danger btn-sm rounded-pill" id="confirmHapusBtn" style="background: linear-gradient(135deg, #fca5a5 0%, #ef4444 100%); border: none;">
                    <i class="bi bi-trash me-1"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

