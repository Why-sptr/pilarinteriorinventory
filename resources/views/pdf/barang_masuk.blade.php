<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Barang Masuk</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Transaksi Barang Masuk</h1>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Produk</th>
                <th>Harga Barang</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksiData as $transaksi)
                <tr>
                    <td>{{ $transaksi['tanggal'] }}</td>
                    <td>{{ $transaksi['nama_produk'] }}</td>
                    <td>{{ number_format($transaksi['harga_barang'], 2) }}</td>
                    <td>{{ $transaksi['jumlah'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
