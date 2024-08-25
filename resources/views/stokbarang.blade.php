<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stock Barang</title>
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
                        <h5>Laporan Stock Barang</h5>
                        @if(isset($query))
                        <h6>Hasil Pencarian "{{ $query }}"</h6>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Harga Satuan</th>
                                        <th scope="col">Jumlah Pengadaan</th>
                                        <th scope="col">Jumlah Pemesanan</th>
                                        <th scope="col">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataBarangs as $index => $barang)
                                    <tr>
                                        <th scope="row">{{ $index + 1 + ($dataBarangs->currentPage() - 1) * $dataBarangs->perPage() }}</th>
                                        <td>{{ $stokBarangs[$index]['nama_produk'] }}</td>
                                        <td>{{ number_format($stokBarangs[$index]['harga_satuan']) }}</td>
                                        <td>{{ $stokBarangs[$index]['jumlah_pengadaan'] }}</td>
                                        <td>{{ $stokBarangs[$index]['jumlah_pemesanan'] }}</td>
                                        <td>{{ $stokBarangs[$index]['stock'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-grid gap-2 d-md-block mb-3">
                            <a href="{{ route('stok-barang-pdf') }}" class="btn btn-warning">
                                <span>
                                    <i class="ti ti-download"></i>
                                </span>
                                Cetak PDF
                            </a>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $dataBarangs->appends(['query' => request('query')])->links('pagination::bootstrap-5') }}
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