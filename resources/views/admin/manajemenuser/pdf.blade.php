<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen User PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #fff;
        }
        h2 {
            text-align: center;
            color:rgb(106, 162, 247); /* biru */
            font-weight: bold;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #6c757d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }
        th {
            background-color: #b0c4de; /* heading pastel light blue */
            text-transform: uppercase;
            text-align: center;
        }
        td.email {
            background-color: #b2ebf2; /* pastel cyan */
            word-break: break-word;
        }
        td.role {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        td.role.admin {
            background-color: #d6c1ff; /* pastel ungu */
        }
        td.role.siswa {
            background-color: #bffcc6; /* pastel green */
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Data Manajemen User</h2>

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
                <th style="width:5%;">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th style="width:10%;">Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($manajemen as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td class="email">{{ strtolower($item->email) }}</td>
                <td class="role {{ strtolower($item->role) }}">
                    {{ ucfirst($item->role) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
