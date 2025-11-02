<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Aset - {{ $aset->nama }}</title>
    <style>
        @media print {
            body {
                margin: 0;
                -webkit-print-color-adjust: exact;
            }
            .label {
                page-break-inside: avoid;
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .labels-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: flex-start;
        }

        .label {
            width: 300px;  /* Lebar label */
            height: 180px; /* Tinggi label lebih besar */
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
        }

        .label-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .label-header h4 {
            font-size: 18px;
            font-weight: 900; /* lebih tegas */
            margin: 0;
            color: #1e3a8a; /* biru profesional */
        }

        .label-header img {
            height: 40px;
        }

        .label-body p {
            margin: 3px 0;
            font-size: 13px;
            color: #333;
        }

        .label-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .label-condition {
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
            text-transform: capitalize;
        }

        .condition-baru { background-color: #bfdbfe; color: #1d4ed8; }
        .condition-baik { background-color: #bbf7d0; color: #16a34a; }
        .condition-rusak_ringan { background-color: #fef3c7; color: #ca8a04; }
        .condition-rusak_berat { background-color: #fecaca; color: #b91c1c; }

        .barcode {
            text-align: center;
            margin-top: 6px;
        }
    </style>
</head>
<body>
   <div class="labels-container">
        <div class="label">
            <div class="label-header">
                <h4>{{ $aset->nama }}</h4>
                <img src="{{ asset('storage/Logo.png') }}" alt="Logo" class="h-16 w-auto rounded-full shadow-md p-1 px-2">
            </div>

            <div class="label-body">
                <p><strong>No. Inventaris:</strong> {{ $aset->nomor_inventaris ?? '-' }}</p>
                <p><strong>Kategori:</strong> {{ $aset->kategori->nama ?? '-' }}</p>
                <p><strong>Lokasi:</strong> {{ $aset->lokasi->nama ?? '-' }}</p>
            </div>


            <div class="barcode">
                {{-- QR Code / Barcode --}}
                {{-- {!! QrCode::size(80)->generate(route('asets.show', $aset->id)) !!} --}}
            </div>
        </div>
   </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
