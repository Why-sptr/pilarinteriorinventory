<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Barang</title>
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
                @if (session('success'))
                <div class="alert alert-primary" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('warning'))
                <div class="alert alert-danger" role="alert">
                    {{ session('warning') }}
                </div>
                @endif
                <div class="card w-100">
                    <div class="card-body">
                        <h5>Data Barang</h5>
                        @if(isset($query))
                        <h6>Hasil Pencarian "{{ $query }}"</h6>
                        @endif
                        <div class="d-grid gap-2 d-md-block mb-3">
                            <a href="/tambah-data-barang" class="btn btn-primary">Tambah Barang</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kategori Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Vendor</th>
                                        <th scope="col">Harga Barang</th>
                                        <th scope="col">Stok Barang</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataBarang as $index => $data)
                                    <tr>
                                        <th scope="row">{{ $index + 1 + ($dataBarang->currentPage() - 1) * $dataBarang->perPage() }}</th>
                                        <td>{{ $data->jenisBarang->jenis }}</td>
                                        <td>{{ $data->nama_barang }}</td>
                                        <td>{{ $data->vendor->nama }}</td>
                                        <td>{{ number_format($data->harga_barang) }}</td>
                                        <td>{{ $data->stok_barang }}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-block">
                                                <form action="{{ route('edit-data-barang', $data->id) }}" method="GET" style="display:inline;">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-info btn-sm" onclick="return">Edit</button>
                                                </form>
                                                @if(Auth::user()->hasRole(['superadmin']))
                                                <form action="{{ route('hapus-data-barang', $data->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data barang ini?');">Hapus</button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $dataBarang->appends(['query' => request('query')])->links('pagination::bootstrap-5') }}
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