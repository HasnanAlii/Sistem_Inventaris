<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengadaan ATK</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            margin: 0; 
            padding: 0; 
            color: #333;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #333;
            padding: 10px 0;
        }

        header img {
            max-height: 50px;
        }

        header h1 {
            font-size: 18px;
            margin: 0;
        }

        .info {
            margin: 15px 0;
        }

        .info p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px 6px;
            text-align: left;
        }

        th {
            background-color: #f7b733; /* Amber header */
            color: #fff;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f3f3f3;
        }

        tfoot td {
            font-weight: bold;
            background-color: #ffe8b0;
        }
    </style>
</head>
<body>

<header>
    <img src="{{ public_path('storage/Logo.png') }}" alt="Logo Perusahaan">
    
    <h1>Laporan Pengadaan ATK</h1>
</header>

<div class="info">
    <p><strong>Nama Pengadaan:</strong> {{ $procurement->nama_barang }}</p>
    <p><strong>Jumlah Barang:</strong> {{ $procurement->jumlah }}</p>
    <p><strong>Total Biaya:</strong> Rp {{ number_format($procurement->biaya,0,',','.') }}</p>
    <p><strong>Tanggal Pengadaan:</strong> {{ $procurement->tanggal_pengadaan ? $procurement->tanggal_pengadaan->format('d/m/Y') : '-' }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Satuan</th>
            <th>Total Harga</th>
            <th>Tanggal Masuk</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procurement->atks as $atk)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $atk->kode_barang }}</td>
                <td>{{ $atk->nama_barang }}</td>
                <td>Rp {{ number_format($atk->harga_satuan ?? 0,0,',','.') }}</td>
                <td>Rp {{ number_format($atk->total_harga ?? 0,0,',','.') }}</td>
                <td>{{ $atk->tanggal_masuk ? $atk->tanggal_masuk->format('d/m/Y') : '-' }}</td>
                <td>{{ $atk->keterangan ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
