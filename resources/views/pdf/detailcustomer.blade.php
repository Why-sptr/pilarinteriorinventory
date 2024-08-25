<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Detail Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container-fluid {
            width: 100%;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
        }

        .form-label {
            font-weight: bold;
            font-size: 14px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 10px;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            font-size: 14px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="card w-100">
            <div class="card-body" style="padding-right: 20px;">
                <h4>Detail Customer</h4>
                <div class="d-flex mb-3">
                    <div class="flex-fill me-2">
                        <label for="nama" class="form-label">Nama Customer</label>
                        <input type="text" name="nama" class="form-control" id="nama" value="{{ $customer->nama }}" disabled>
                    </div>
                    <div class="flex-fill ms-2">
                        <label for="project" class="form-label">Project</label>
                        <input type="text" name="project" class="form-control" id="project" value="{{ $customer->project }}" disabled>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="flex-fill ms-2">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control" id="telepon" value="{{ $customer->telepon }}" disabled>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" id="alamat" rows="3" disabled>{{ $customer->alamat }}</textarea>
                </div>
                
            </div>
            <h4>Laporan Stok Barang Customer</h4>
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Biaya Dipakai</th>
                            <th scope="col">Barang Dipakai</th>
                            <th scope="col">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stokCustomer->groupBy('data_barang_id') as $dataBarangId => $stoks)
                        @php
                        $dataBarang = $stoks->first()->dataBarang;
                        $jumlahKeluar = \App\Models\Transaksi::where('customer_id', $customer->id)
                        ->where('data_barang_id', $dataBarangId)
                        ->where('status', 'keluar')
                        ->sum('jumlah');
                        $biayaDipakaiPerBarang = $jumlahKeluar * $dataBarang->harga_barang;
                        @endphp
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $dataBarang->nama_barang }}</td>
                            <td>{{ number_format($dataBarang->harga_barang, 0, ',', '.') }}</td>
                            <td>{{ number_format($biayaDipakaiPerBarang, 2, ',', '.') }}</td>
                            <td>{{ $jumlahKeluar }}</td>
                            <td>{{ $stoks->sum('jumlah') }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5"><strong>Total Dana</strong></td>
                            <td><strong>{{ number_format($dana, 2, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong>Total Biaya Dipakai</strong></td>
                            <td><strong>{{ number_format($biayaDipakai, 2, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong>Gross Profit</strong></td>
                            <td><strong>{{ number_format($grossProfit, 2, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</body>

</html>