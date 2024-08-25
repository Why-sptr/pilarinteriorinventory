<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stock Barang Customer</title>
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
            <!-- Header Start -->
            @include('partials.header')
            <!-- Header End -->
            <div class="container-fluid">
                <div class="card w-100">
                    <div class="card-body">
                        <h5>Laporan Stock Barang Customer</h5>
                        @if(isset($query))
                        <h6>Hasil Pencarian "{{ $query }}"</h6>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Harga Satuan</th>
                                        <th scope="col">Biaya Dipakai</th>
                                        <th scope="col">Barang Dipakai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stokCustomer->groupBy('customer_id') as $customerId => $stoks)
                                    @php
                                    $customer = $stoks->first()->customer;
                                    @endphp
                                    <tr>
                                        <th colspan="6">{{ $customer->nama }}</th>
                                    </tr>
                                    @foreach($stoks as $index => $stok)
                                    @php
                                    $jumlahKeluar = \App\Models\Transaksi::where('customer_id', $customerId)
                                    ->where('data_barang_id', $stok->data_barang_id)
                                    ->where('status', 'keluar')
                                    ->sum('jumlah');
                                    $biayaDipakai = $jumlahKeluar * $stok->dataBarang->harga_barang;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $stok->dataBarang->nama_barang }}</td>
                                        <td>{{ number_format($stok->dataBarang->harga_barang) }}</td>
                                        <td>{{ number_format($biayaDipakai) }}</td>
                                        <td>{{ $jumlahKeluar }}</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $stokCustomer->appends(['query' => request('query')])->links('pagination::bootstrap-5') }}
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