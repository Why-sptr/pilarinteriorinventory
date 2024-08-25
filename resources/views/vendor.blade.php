<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Vendor</title>
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
                        <h5>Data Vendor</h5>
                        @if(isset($query))
                        <h6>Hasil Pencarian "{{ $query }}"</h6>
                        @endif
                        <div class="d-grid gap-2 d-md-block mb-3">
                            <a href="/tambah-vendor" class="btn btn-primary">Tambah Vendor</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Vendor</th>
                                        <th scope="col">Telepon</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendors as $index => $vendor)
                                    <tr>
                                        <th scope="row">{{ $index + 1 + ($vendors->currentPage() - 1) * $vendors->perPage() }}</th>
                                        <td>{{$vendor->nama}}</td>
                                        <td>{{$vendor->telepon}}</td>
                                        <td>{{$vendor->alamat}}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-block">
                                                <form action="{{ route('edit-vendor', $vendor->id) }}" method="GET" style="display:inline;">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-info btn-sm" onclick="return">Edit</button>
                                                </form>
                                                @if(Auth::user()->hasRole(['superadmin']))
                                                <form action="{{ route('hapus-vendor', $vendor->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus vendor ini?');">Hapus</button>
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
                            {{ $vendors->appends(['query' => request('query')])->links('pagination::bootstrap-5') }}
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