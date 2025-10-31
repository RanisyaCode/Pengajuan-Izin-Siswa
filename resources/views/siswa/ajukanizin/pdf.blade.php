<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Izin | PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f9fafb;
            color: #333;
            font-size: 16px;
        }
        h2 {
            text-align: center;
            color: #3b82f6;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .info {
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
            color: #6c757d;
            line-height: 1.5;
        }

        .container {
            display: flex;
            flex-direction: column;
        }

        .card {
            background: rgb(205, 232, 249);
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 24px 28px;
            border-left: 7px solid #3b82f6;
            position: relative;
            min-height: 80vh;
            page-break-after: always;
        }
        .card:last-child { page-break-after: auto; }

        .card h3 {
            margin: 0;
            font-size: 20px;
            color: #0f172a;
            font-weight: bold;
        }
        .kelas {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 16px;
        }

        .status {
            position: absolute;
            top: 20px;
            right: 24px;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .status.menunggu { background: #fbbf24; }
        .status.disetujui, .status.approved { background: #4ade80; }
        .status.ditolak, .status.rejected { background: #f87171; }
        .status.default { background: #94a3b8; }

        .row {
            display: flex;
            align-items: flex-start;
            margin: 10px 0;
            font-size: 15px;
        }
        .row strong {
            flex: 0 0 150px;
            color: #334155;
            font-weight: 600;
        }
        .row span {
            flex: 1;
            color: #475569;
        }

        /* Catatan Guru */
        .catatan-box {
            background: #e0f2fe;
            border-left: 5px solid #3b82f6;
            border-radius: 10px;
            padding: 12px 16px;
            margin: 16px 0;
        }
        .catatan-box .label {
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 6px;
            display: block;
        }
        .catatan-box .value {
            font-style: italic;
            color: #475569;
            font-size: 15px;
        }

        .row-bukti {
            display: flex;
            margin: 12px 0;
            font-size: 15px;
            align-items: flex-start;
        }
        .row-bukti strong {
            flex: 0 0 150px;
            color: #334155;
            font-weight: 600;
            margin-top: 6px;
        }
        .row-bukti .content {
            flex: 1;
        }

        .bukti-img {
            max-width: 100%;
            max-height: 250px;
            border-radius: 10px;
            margin-top: 6px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.12);
            object-fit: contain;
        }

        .bukti-file {
            display: inline-block;
            margin-top: 8px;
            padding: 8px 16px;
            background: #3b82f6;
            color: #fff;
            font-size: 13px;
            border-radius: 8px;
            text-decoration: none;
        }
        .bukti-file:hover { background: #2563eb; }
    </style>
</head>
<body>

    <h2>Data Ajukan Izin</h2>

    <p class="info">
        Dicetak pada: <br>
        @php
            use Carbon\Carbon;
            $waktuWIB = Carbon::now('Asia/Jakarta');
        @endphp
        Tanggal: {{ $waktuWIB->format('d-m-Y') }}<br>
        Pukul: {{ $waktuWIB->format('H.i.s') }}
    </p>

    <div class="container">
        @forelse($ajukanizin as $item)
            @php
                $status = strtolower(trim($item->status));
                $statusText = match($status) {
                    'menunggu' => 'Menunggu',
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
                $imgPath = $item->file ? public_path('storage/' . $item->file) : null;
                $fileUrl = $item->file ? asset('storage/' . $item->file) : null;
            @endphp

            <div class="card">
                <h3>{{ $item->user->nama }}</h3>
                <div class="kelas">{{ $item->kelas ?? '-' }}</div>

                <span class="status {{ $statusClass }}">{{ $statusText }}</span>

                <div class="row"><strong>Tanggal Izin :</strong> <span>{{ \Carbon\Carbon::parse($item->tanggal_izin)->format('d-m-Y') }}</span></div>
                <div class="row"><strong>Alasan :</strong> <span>{{ $item->alasan }}</span></div>

                <!-- Catatan Guru -->
                <div class="catatan-box">
                    <span class="label">Catatan Guru</span>
                    <span class="value">
                        {{ $item->catatan ? $item->catatan : '— Tidak ada catatan dari guru —' }}
                    </span>
                </div>

                @if($item->file)
                    @if(in_array($ext, ['jpg','jpeg','png','gif']))
                        <div class="row-bukti">
                            <strong>Bukti :</strong>
                            <div class="content">
                                <img src="{{ $imgPath }}" class="bukti-img" alt="Bukti">
                            </div>
                        </div>
                    @elseif($ext === 'pdf')
                        <div class="row-bukti">
                            <strong>Bukti :</strong>
                            <div class="content">
                                <div>File ini berupa <b>PDF</b>.</div>
                                <a href="{{ $fileUrl }}" target="_blank" class="bukti-file">Lihat PDF</a>
                            </div>
                        </div>
                    @else
                        <div class="row-bukti">
                            <strong>Bukti :</strong>
                            <div class="content">
                                <div>File ini berupa <b>{{ strtoupper($ext) }}</b>.</div>
                                <a href="{{ $fileUrl }}" target="_blank" class="bukti-file">Lihat file</a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        @empty
            <p style="text-align:center; color:#94a3b8; font-style:italic;">Belum ada pengajuan izin.</p>
        @endforelse
    </div>

</body>
</html>
