<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barang Keluar</title>
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
                        <h5>Transaksi Barang Keluar</h5>
                        @if(isset($query))
                        <h6>Hasil Pencarian "{{ $query }}"</h6>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Harga Barang</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksiKeluar as $index => $transaksi)
                                    <tr>
                                        <th scope="row">{{ $index + 1 + ($transaksiKeluar->currentPage() - 1) * $transaksiKeluar->perPage() }}</th>
                                        <td>{{ $transaksi->tanggal_transaksi }}</td>
                                        <td>{{ $transaksi->dataBarang->nama_barang }}</td>
                                        <td>{{ number_format($transaksi->dataBarang->harga_barang) }}</td>
                                        <td>{{ $transaksi->jumlah }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-grid gap-2 d-md-block mb-3">
                            <a href="{{ route('barang-keluar-pdf') }}" class="btn btn-warning">
                                <span>
                                    <i class="ti ti-download"></i>
                                </span>
                                Cetak PDF
                            </a>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $transaksiKeluar->appends(['query' => request('query')])->links('pagination::bootstrap-5') }}
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