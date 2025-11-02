<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pengadaan Aset</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; font-size: 12pt; }
        h2 { text-align: center; color: #1d4ed8; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #e0e7ff; color: #111; }
        .info { margin-bottom: 20px; }
        .info div { margin: 5px 0; }
    </style>
</head>
<body>
    <h2>📄 Detail Pengadaan Aset</h2>

    <div class="info">
        <div><strong>Nama Pengadaan:</strong> {{ $asetLog->nama_barang }}</div>
        <div><strong>Jumlah Barang:</strong> {{ $asetLog->jumlah }}</div>
        <div><strong>Biaya:</strong> Rp {{ number_format($asetLog->biaya, 0, ',', '.') }}</div>
        <div><strong>Tanggal Pengadaan:</strong> {{ $asetLog->tanggal_pengadaan ? $asetLog->tanggal_pengadaan->format('d F Y') : '-' }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Aset</th>
                <th>Nomor Inventaris</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Tanggal Perolehan</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asetLog->asets as $aset)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $aset->nama }}</td>
                    <td>{{ $aset->nomor_inventaris }}</td>
                    <td>{{ $aset->kategori->nama ?? '-' }}</td>
                    <td>Rp {{ number_format($aset->harga, 0, ',', '.') }}</td>
                    <td>{{ $aset->tanggal_perolehan ? \Carbon\Carbon::parse($aset->tanggal_perolehan)->format('d F Y') : '-' }}</td>
                    <td>{{ $aset->lokasi->nama ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>  