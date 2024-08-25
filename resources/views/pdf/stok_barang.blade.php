<!DOCTYPE html>
<html>
<head>
    <title>Stok Barang</title>
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
    <h1>Stok Barang</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga Satuan</th>
                <th>Jumlah Pengadaan</th>
                <th>Jumlah Pemesanan</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stokBarangs as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barang['nama_produk'] }}</td>
                    <td>{{ number_format($barang['harga_satuan'], 2) }}</td>
                    <td>{{ $barang['jumlah_pengadaan'] }}</td>
                    <td>{{ $barang['jumlah_pemesanan'] }}</td>
                    <td>{{ $barang['stock'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
