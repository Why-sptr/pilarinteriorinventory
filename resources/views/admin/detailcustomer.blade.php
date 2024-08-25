<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Customer</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar Start -->
        @include('partials.sidebar')
        <!-- Sidebar End -->

        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('partials.header')
            <!--  Header End -->
            <div class="container-fluid">
                <div class="card w-100">
                    <div class="card-body">
                        <h5>Detail Customer</h5>
                        <div class="d-flex mb-3">
                            <div class="flex-fill me-2">
                                <label for="nama" class="form-label">Nama Customer</label>
                                <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama', $customer->nama) }}" placeholder="Masukkan nama customer" disabled>
                            </div>
                            <div class="flex-fill ms-2">
                                <label for="project" class="form-label">Project</label>
                                <input type="text" name="project" class="form-control" id="project" value="{{ old('project', $customer->project) }}" placeholder="Masukkan project" disabled>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-fill me-2">
                                <label for="dana" class="form-label">Dana</label>
                                <input type="number" name="dana" class="form-control" id="dana" value="{{ old('dana', $customer->dana) }}" placeholder="Masukkan dana" disabled>
                            </div>
                            <div class="flex-fill ms-2">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control" id="telepon" value="{{ old('telepon', $customer->telepon) }}" placeholder="Masukkan telepon" disabled>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat" rows="3" placeholder="Masukkan alamat customer" disabled>{{ old('alamat', $customer->alamat) }}</textarea>
                        </div>
                        <h5>Laporan Stok Barang Customer</h5>
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
                                    <td>{{ number_format($dataBarang->harga_barang) }}</td>
                                    <td>{{ number_format($biayaDipakaiPerBarang) }}</td>
                                    <td>{{ $jumlahKeluar }}</td>
                                    <td>{{ $stoks->sum('jumlah') }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5"><strong>Total Biaya Dipakai</strong></td>
                                    <td><strong>{{ number_format($biayaDipakai) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="5"><strong>Gross Profit</strong></td>
                                    <td><strong>{{ number_format($grossProfit) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-grid gap-2 d-md-block mb-3">
                            <a href="{{ route('customer.exportPdf', $customer->id) }}" class="btn btn-warning">
                                <span>
                                    <i class="ti ti-download"></i>
                                </span>
                                Cetak PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>

</html>