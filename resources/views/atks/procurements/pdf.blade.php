<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Laporan Pengadaan ATK</title>
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

        .kop-surat p {
            margin: 2px 0;
            font-size: 10pt;
        }

        /* Garis ganda */
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
    </style>
</head>
<body>

    <!-- ===== KOP SURAT ===== -->
    <div class="kop-surat">
        <div class="logo">
            <img src="{{ public_path('storage/Logo.png') }}" alt="Logo Dinas">
        </div>
        <div class="text">
            <h1>PEMERINTAH KABUPATEN CIANJUR</h1>
            <h2>DINAS ARSIP DAN PERPUSTAKAAN</h2>
            <p>Jl. Siliwangi No. 40, Cianjur 43211</p>
            <p>Telp. (0263) 261269 | Email: dinas.arpus@cianjurkab.go.id</p>
        </div>
    </div>
    <div class="garis"></div>

    <!-- ===== ISI SURAT ===== -->
    <p style="text-align: right;">Cianjur, {{ now()->format('d F Y') }}</p>

    <div class="info">
        <div><strong>Nomor:</strong> 004/DAP/{{ now()->year }}</div>
        <div><strong>Lampiran:</strong> -</div>
        <div><strong>Hal:</strong> Laporan Pengadaan Alat Tulis Kantor (ATK)</div>
    </div>

    <p>Kepada Yth.<br>
    Kepala Dinas Arsip dan Perpustakaan<br>
    Kabupaten Cianjur<br>
    di Tempat</p>

    <p>Dengan hormat,</p>
    <p>Bersama surat ini kami sampaikan laporan hasil pengadaan alat tulis kantor (ATK) pada Dinas Arsip dan Perpustakaan Kabupaten Cianjur sebagai berikut:</p>

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
                    <td>{{ $atk->tanggal_masuk ? $atk->tanggal_masuk->format('d F Y') : '-' }}</td>
                    <td>{{ $atk->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="info">
        <div><strong>Nama Pengadaan:</strong> {{ $procurement->nama_barang }}</div>
        <div><strong>Jumlah Barang:</strong> {{ $procurement->jumlah }}</div>
        <div><strong>Total Biaya:</strong> Rp {{ number_format($procurement->biaya,0,',','.') }}</div>
        <div><strong>Tanggal Pengadaan:</strong> {{ $procurement->tanggal_pengadaan ? $procurement->tanggal_pengadaan->format('d F Y') : '-' }}</div>
    </div>

    <!-- ===== PENUTUP ===== -->
    <div class="footer">
        <p>Demikian laporan pengadaan ATK ini kami sampaikan untuk dapat digunakan sebagaimana mestinya. Besar harapan kami laporan ini dapat menjadi bahan pertimbangan dalam pengelolaan dan pendataan perlengkapan kantor di lingkungan Dinas Arsip dan Perpustakaan Kabupaten Cianjur.</p>

        <div class="signature">
            <p>Hormat kami,</p>
            <p><strong>Kepala Dinas Arsip dan Perpustakaan</strong></p>
            <p>Kabupaten Cianjur</p>
            <br><br><br>
            <p><strong>{{ $pimpinan ?? 'Drs. H. Sutisna, M.Si' }}</strong><br>
            NIP. 19650110 199003 1 002</p>
        </div>
    </div>

</body>
</html>
