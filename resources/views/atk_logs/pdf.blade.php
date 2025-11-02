<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Permintaan ATK</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: center; }
        th { background-color: #f4f4f4; font-weight: bold; }
        .status {
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: bold;
        }
        .Menunggu\ Konfirmasi { background-color: #fef3c7; color: #ca8a04; }
        .Disetujui { background-color: #bbf7d0; color: #16a34a; }
        .Ditolak { background-color: #fecaca; color: #b91c1c; }
        .Selesai { background-color: #bfdbfe; color: #1d4ed8; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">📋 Riwayat Permintaan ATK</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Pemohon</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal Permintaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $log->atk->nama_barang ?? '-' }}</td>
                <td>{{ $log->user->name ?? 'Tidak diketahui' }}</td>
                <td>{{ $log->jumlah }}</td>
                <td>
                    <span class="status {{ $log->status }}">{{ $log->status }}</span>
                </td>
                <td>{{ $log->tanggal_permintaan ? $log->tanggal_permintaan->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
