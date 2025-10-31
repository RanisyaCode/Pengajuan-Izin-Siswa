<table style="border-collapse:collapse; width:100%; font-family:Arial, sans-serif; font-size:11pt;">
    <thead>
        <tr>
            <th colspan="8" style="font-size:18px; font-weight:bold; padding:12px; background-color:#c8e6c9; color:#1b5e20; text-align:center;">
                Data Izin Siswa
            </th>
        </tr>
        <tr>
            <th colspan="8" style="padding:8px; font-style:italic; text-align:center; background-color:#e0f7fa; color:#006064;">
                Tanggal : {{ $tanggal }}
            </th>
        </tr>
        <tr>
            <th colspan="8" style="padding:8px; font-style:italic; text-align:center; background-color:#e0f7fa; color:#006064;">
                Pukul : {{ $jam }}
            </th>
        </tr>
        <tr style="font-weight:bold; background-color:#ffd54f; color:#5d4037;">
            <th style="padding:6px; text-align:center;" width="5">No</th>
            <th style="padding:6px; text-align:center;">Nama Siswa</th>
            <th style="padding:6px; text-align:center;">Kelas</th>
            <th style="padding:6px; text-align:center;">Email</th>
            <th style="padding:6px; text-align:center;">Tanggal Izin</th>
            <th style="padding:6px; text-align:center;">Alasan</th>
            <th style="padding:6px; text-align:center;">Status</th>
            <th style="padding:6px; text-align:center;">Bukti</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($IzinSiswa as $item)
        @php
            // Tentukan warna baris ganjil-genap biar tidak error di CSS linter
            $rowColor = $loop->even ? '#fff9c4' : '#fce4ec';

            // Tentukan warna status
            $statusColor = match(strtolower($item->status)) {
                'menunggu' => '#fbc02d',
                'approved', 'disetujui' => '#43a047',
                'rejected', 'ditolak' => '#e53935',
                default => '#757575'
            };

            // Ekstensi file bukti
            $ext = strtolower(pathinfo($item->file ?? '', PATHINFO_EXTENSION));
        @endphp

        <tr>
            <td align="center" style="padding:6px;">{{ $loop->iteration }}</td>
            <td align="center" style="padding:6px;">{{ $item->nama_siswa }}</td>
            <td align="center" style="padding:6px;">{{ $item->kelas }}</td>
            <td align="center" style="padding:6px;">{{ $item->user->email }}</td>
            <td align="center" style="padding:6px;">{{ $item->tanggal_izin->format('d-m-Y') }}</td>
            <td align="center" style="padding:6px;">{{ $item->alasan }}</td>
            <td align="center" style="padding:6px;">
                <span style="display:inline-block; padding:3px 8px; border-radius:12px; color:white; font-weight:bold; font-size:10pt;">
                    {{ ucfirst($item->status) }}
                </span>
            </td>
            <td align="center" style="padding:6px;">
                @if($item->file && in_array($ext, ['jpg','jpeg','png','gif','webp']))
                    <div style="max-width:60px; max-height:60px; overflow:hidden; border:1px solid #ccc; border-radius:6px; margin:auto;">
                        <img src="{{ asset('storage/' . $item->file) }}" 
                             style="width:100%; height:100%; object-fit:cover;" alt="Bukti Izin">
                    </div>
                @elseif($item->file)
                    <span style="font-size:10px; font-style:italic; color:#d32f2f;">
                        File tidak bisa ditampilkan ({{ strtoupper($ext) }})
                    </span>
                @else
                    <span style="font-size:10px; font-style:italic; color:#616161;">
                        Tidak ada file
                    </span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>