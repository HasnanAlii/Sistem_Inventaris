<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Penilaian Aset</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Daftar Penilaian Aset</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Aset</th>
                <th>Kondisi</th>
                <th>Umur (Bulan)</th>
                <th>Perbaikan</th>
                <th>Status</th>
                <th>Tanggal Penilaian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assessments as $index => $assessment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $assessment->aset->nama ?? '-' }}</td>
                    <td>{{ $assessment->condition }}</td>
                    <td>{{ $assessment->usia_bulan }}</td>
                    <td>{{ $assessment->perbaikan }}</td>
                    <td>{{ $assessment->status }}</td>
                    <td>{{ $assessment->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
