<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan</title>
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
                        <h5>Pengajuan</h5>
                        @if(isset($query))
                        <h6>Hasil Pencarian "{{ $query }}"</h6>
                        @endif
                        <div class="d-grid gap-2 d-md-block mb-3">
                            <a href="/tambah-pengajuan" class="btn btn-primary">Tambah Pengajuan</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Biaya</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Bukti TF</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengajuan as $index => $pj)
                                    <tr>
                                        <th scope="row">{{ $index + 1 + ($pengajuan->currentPage() - 1) * $pengajuan->perPage() }}</th>
                                        <td>{{ $pj->customer->nama }}</td>
                                        <td>{{ $pj->dataBarang->nama_barang }}</td>
                                        <td>{{ number_format($pj->biaya, 0, '.', ',') }}</td>
                                        <td>{{ $pj->jumlah }}</td>
                                        <td>
                                            @if($pj->status == 'diajukan')
                                            <button class="btn btn-sm btn-warning">{{ $pj->status }}</button>
                                            @elseif($pj->status == 'disetujui')
                                            <button class="btn btn-sm btn-success">{{ $pj->status }}</button>
                                            @elseif($pj->status == 'ditolak')
                                            <button class="btn btn-sm btn-danger">{{ $pj->status }}</button>
                                            @else
                                            <button class="btn btn-sm btn-secondary">{{ $pj->status }}</button>
                                            @endif
                                        </td>

                                        <td><img src="{{ asset('assets/images/bukti_tf/' . $pj->bukti_tf) }}" alt="Bukti Transfer" class="img-thumbnail mt-2" style="max-height: 200px;"></td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-block">
                                                @if(Auth::user()->hasRole(['superadmin', 'finance']))
                                                <form action="{{ route('edit-pengajuanfinance', $pj->id) }}" method="GET" style="display:inline;">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-info btn-sm">Edit</button>
                                                </form>
                                                @endif
                                                @if(Auth::user()->hasRole(['operasional']))
                                                <form action="{{ route('edit-pengajuan', $pj->id) }}" method="GET" style="display:inline;">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-info btn-sm">Edit</button>
                                                </form>
                                                @endif
                                                @if(Auth::user()->hasRole(['superadmin']))
                                                <form action="{{ route('hapus-pengajuan', $pj->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?');">Hapus</button>
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
                            {{ $pengajuan->appends(['query' => request('query')])->links('pagination::bootstrap-5') }}
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