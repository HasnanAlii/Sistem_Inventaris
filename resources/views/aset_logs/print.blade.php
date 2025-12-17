<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengadaan Aset</title>
    <style>
        body { 
            font-family: "Times New Roman", serif; 
            color: #000; 
            font-size: 12pt; 
            line-height: 1.5; 
            margin: 40px;
        }

        /* ===== KOP SURAT ===== */
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 5px;
            position: relative;
        }

        .kop-surat .logo {
            position: absolute;
            left: 0;
        }

        .kop-surat .logo img {
            width: 130px;
            height: auto;
        }

        .kop-surat .text {
            flex: 1;
        }

        .kop-surat h1 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-surat h2 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-surat h3 {
            margin: 0;
            font-size: 11pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-surat p {
            margin: 2px 0;
            font-size: 10pt;
        }

        /* Garis ganda bawah header */
        .garis {
            border-bottom: 2px solid #000;
            margin-top: 4px;
            margin-bottom: 15px;
        }
        .garis::after {
            content: "";
            display: block;
            border-bottom: 1px solid #000;
            margin-top: 1px;
        }

        /* ===== ISI SURAT ===== */
        .info { margin-bottom: 20px; }
        .info div { margin: 3px 0; }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
        }

        th, td { 
            border: 1px solid #444; 
            padding: 8px; 
            text-align: left; 
            font-size: 10pt;
        }

        th { 
            background-color: #f5f5f5; 
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            font-size: 11pt;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
        }

        .signature p {
            margin: 3px 0;
        }

        a {
            color: #000;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- ===== KOP SURAT ===== -->
    <div class="kop-surat">
        <div class="logo">
        <img src="{{ public_path('storage/logo.png') }}"alt="logo Dinas"style="width: 90px; height: auto;">
        </div>
        <div class="text">
            <h1>PEMERINTAH KABUPATEN CIANJUR</h1>
            <h2>DINAS ARSIP DAN PERPUSTAKAAN</h2>
            <p>Jalan : Selamet Riyadi No. 01 Kel. Pamoyanan Kec. Cianjur (43211) </p>
            <p>Laman https://disarpus.cianjurkab.go.id e-mail disarpus@cianjurkab.go.id</p>
        </div>
    </div>
    <div class="garis"></div>

    <!-- ===== ISI SURAT ===== -->
    <p style="text-align: right;">Cianjur, {{ now()->format('d F Y') }}</p>

    <div class="info">
        <div><strong>Nomor:</strong> 004/DAP/{{ now()->year }}</div>
        <div><strong>Lampiran:</strong> -</div>
        <div><strong>Hal:</strong> Laporan Pengadaan Aset</div>
    </div>

    <p>Kepada Yth.<br>
    Kepala Dinas Arsip dan Perpustakaan<br>
    Kabupaten Cianjur<br>
    di Tempat</p>

    <p>Dengan hormat,</p>
    <p>Bersama surat ini kami sampaikan laporan hasil pengadaan aset pada Dinas Arsip dan Perpustakaan Kabupaten Cianjur sebagai berikut:</p>

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

    <div class="info">
        <div><strong>Nama Pengadaan:</strong> {{ $asetLog->nama_barang }}</div>
        <div><strong>Jumlah Barang:</strong> {{ $asetLog->jumlah }}</div>
        <div><strong>Biaya:</strong> Rp {{ number_format($asetLog->biaya, 0, ',', '.') }}</div>
        <div><strong>Tanggal Pengadaan:</strong> {{ $asetLog->tanggal_pengadaan ? $asetLog->tanggal_pengadaan->format('d F Y') : '-' }}</div>
    </div>

    <!-- ===== PENUTUP ===== -->
    <div class="footer">
        <p>Demikian laporan pengadaan aset ini kami sampaikan untuk dapat digunakan sebagaimana mestinya. Besar harapan kami laporan ini dapat menjadi acuan dalam pengelolaan dan pendataan aset di lingkungan Dinas Arsip dan Perpustakaan Kabupaten Cianjur.</p>

        <div class="signature">
            <p><strong>Kepala Dinas Arsip dan Perpustakaan</strong></p>
            <br><br><br>
            <p><strong>{{ $pimpinan ?? 'Asep Suparman, S.Sos.M.Si.' }}</strong><br>
            NIP. 196806101994031012
            </p>
        </div>
    </div>

</body>
</html>
