<!DOCTYPE html>
<html>
<head>
    <title>Klasifikasi Barang</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Klasifikasi Barang</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah Barang</th>
                <th>Harga Barang</th>
                <th>Total Harga Per Barang</th>
                <th>Presentase Barang (%)</th>
                <th>Presentase Kumulatif (%)</th>
                <th>Golongan Barang ABC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($klasifikasi as $index => $barang)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $barang['nama_barang'] }}</td>
                <td>{{ $barang['jumlah_barang'] }}</td>
                <td>{{ number_format($barang['harga_barang'], 2) }}</td>
                <td>{{ number_format($barang['total_harga_per_barang'], 2) }}</td>
                <td>{{ number_format($barang['presentase_barang'], 2) }}</td>
                <td>{{ number_format($barang['presentase_kumulatif'], 2) }}</td>
                <td>{{ $barang['golongan_barang'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
