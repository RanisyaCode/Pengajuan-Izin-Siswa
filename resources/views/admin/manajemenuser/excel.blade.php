<div class="container py-4">
    <!-- Header Judul dan Tanggal Cetak -->
    <div class="mb-4">
        <h2 class="fw-bold text-primary">Manajemen User</h2>
        <p class="text-muted mb-1">
            Dicetak pada: <br>
            Tanggal : <span id="tanggal-cetak">dd-mm-yyyy</span><br>
            Pukul : <span id="waktu-cetak">H.i.s</span>
        </p>
    </div>

    <!-- Tabel Manajemen User -->
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-light text-uppercase">
                <tr>
                    <th scope="col" class="text-center" style="width: 5%;">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col" style="max-width: 300px;">Email</th>
                    <th scope="col" class="text-center" style="width: 10%;">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($manajemen as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="fw-semibold">{{ $item->nama }}</td>
                    <td style="max-width: 300px; word-break: break-word; text-transform: lowercase;">{{ $item->email }}</td>
                    <td class="text-center">
                        @if(strtolower($item->role) === 'admin')
                            <span class="badge bg-primary text-uppercase">Admin</span>
                        @else
                            <span class="badge bg-success text-uppercase">Siswa</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Script untuk Update Tanggal dan Waktu Otomatis -->
<script>
    const tanggalElement = document.getElementById('tanggal-cetak');
    const waktuElement = document.getElementById('waktu-cetak');
    const now = new Date();

    const tanggal = now.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });

    const waktu = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    }).replace(/:/g, '.');

    tanggalElement.textContent = tanggal;
    waktuElement.textContent = waktu;
</script>