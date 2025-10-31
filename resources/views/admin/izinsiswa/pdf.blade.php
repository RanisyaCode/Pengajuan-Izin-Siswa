<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Izin Siswa | PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f9fafb;
            color: #333;
            font-size: 14px;
        }
        h2 {
            text-align: center;
            color: #3b82f6;
            font-weight: bold;
            margin-bottom: 6px;
            font-size: 26px;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 13px;
            color: #6c757d;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 13px;
        }
        thead {
            background: #dbeafe; /* pastel biru */
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            font-weight: 700;
            color: #1e3a8a;
            text-align: center;
        }

        /* Status Badge */
        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 600;
            color: #fff;
        }
        .status.menunggu { background: #fbbf24; }
        .status.disetujui, .status.approved { background: #4ade80; }
        .status.ditolak, .status.rejected { background: #f87171; }
        .status.default { background: #94a3b8; }

        /* Bukti */
        .bukti-img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            object-fit: contain;
            display: block;
        }
        .bukti-file {
            display: inline-block;
            margin-top: 4px;
            padding: 5px 10px;
            background: #3b82f6;
            color: #fff;
            font-size: 12px;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <h2>Data Izin Siswa</h2>

    <p class="info">
        Dicetak pada: <br>
        @php
            use Carbon\Carbon;
            $waktuWIB = Carbon::now('Asia/Jakarta');
        @endphp
        Tanggal: {{ $waktuWIB->format('d-m-Y') }}<br>
        Pukul: {{ $waktuWIB->format('H.i.s') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Email</th>
                <th>Tanggal Izin</th>
                <th>Alasan</th>
                <th>Status</th>
                <th>Bukti</th>
            </tr>
        </thead>
        <tbody>
            @forelse($izinsiswa as $index => $item)
                @php
                    $status = strtolower(trim($item->status));
                    $statusText = match($status) {
                        'menunggu' => 'menunggu',
                        'approved', 'disetujui' => 'Disetujui',
                        'rejected', 'ditolak' => 'Ditolak',
                        default => ucfirst($item->status),
                    };
                    $statusClass = match($status) {
                        'menunggu' => 'menunggu',
                        'approved', 'disetujui' => 'disetujui',
                        'rejected', 'ditolak' => 'ditolak',
                        default => 'default',
                    };

                    $ext = $item->file ? strtolower(pathinfo($item->file, PATHINFO_EXTENSION)) : null;
                    $imgPath = $item->file ? public_path('storage/bukti_izin/' . $item->file) : null;
                    $fileUrl = $item->file ? asset('storage/bukti_izin/' . $item->file) : null;

                    $imageData = null;
                    if($item->file && in_array($ext, ['jpg','jpeg','png','gif'])){
                        if(file_exists($imgPath)){
                            $imageData = base64_encode(file_get_contents($imgPath));
                            $imageData = "data:image/{$ext};base64,{$imageData}";
                        }
                    }
                @endphp
                <tr>
                    <td style="text-align:center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_siswa }}</td>
                    <td style="text-align:center">{{ $item->kelas }}</td>
                    <td>{{ $item->user->email ?? '-' }}</td>
                    <td style="text-align:center">{{ \Carbon\Carbon::parse($item->tanggal_izin)->format('d-m-Y') }}</td>
                    <td>{{ $item->alasan }}</td>
                    <td style="text-align:center">
                        <span class="status {{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                    <td style="text-align:center">
                        @php
                            $ext = $item->file ? strtolower(pathinfo($item->file, PATHINFO_EXTENSION)) : null;
                            $imgPath = $item->file ? public_path('storage/' . $item->file) : null;
                            $fileUrl = $item->file ? asset('storage/' . $item->file) : null;
                        @endphp

                        @if($item->file)
                            @if(in_array($ext, ['jpg','jpeg','png','gif']))
                                <img src="{{ $imgPath }}" alt="Bukti" style="max-height:170px; max-width:170px;">
                            @elseif($ext === 'pdf')
                                <div>File: <b>PDF</b></div>
                                <a href="{{ $fileUrl }}" target="_blank">Klik file</a>
                            @else
                                <div>File: <b>{{ strtoupper($ext) }}</b></div>
                                <a href="{{ $fileUrl }}" target="_blank">Klik file</a>
                            @endif
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:#94a3b8; font-style:italic;">
                        Belum ada data izin siswa.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>