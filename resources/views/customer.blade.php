<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer</title>
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
                @if (session('error'))
                <div class="alert alert-primary" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                @if (session('warning'))
                <div class="alert alert-danger" role="alert">
                    {{ session('warning') }}
                </div>
                @endif
                <div class="card w-100">
                    <div class="card-body">
                        <h5>Customer</h5>
                        @if(isset($query))
                        <h6>Hasil Pencarian "{{ $query }}"</h6>
                        @endif
                        <div class="d-grid gap-2 d-md-block mb-3">
                            <a href="/tambah-customer" class="btn btn-primary">Tambah Customer</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Customer</th>
                                        <th scope="col">Sales</th>
                                        <th scope="col">Project</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Dana</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $index => $customer)
                                    <tr>
                                        <td>{{ $index + 1 + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                                        <td>{{ $customer->nama }}</td>
                                        <td>{{ $customer->user->name }}</td>
                                        <td>{{ $customer->project }}</td>
                                        <td>
                                            @if($customer->status == 'diproses')
                                            <button class="btn btn-sm btn-warning">{{ $customer->status }}</button>
                                            @elseif($customer->status == 'selesai')
                                            <button class="btn btn-sm btn-success">{{ $customer->status }}</button>
                                            @else
                                            <button class="btn btn-sm btn-secondary">{{ $customer->status }}</button>
                                            @endif
                                        </td>
                                        <td>{{ number_format($customer->dana) }}</td>
                                        <td>
                                            <div class="d-grid gap-2 d-md-block">
                                                <form action="{{ route('edit-customer', $customer->id) }}" method="GET" style="display:inline;">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-info btn-sm">Edit</button>
                                                </form>
                                                <form action="{{ route('detail-customer', $customer->id) }}" method="GET" style="display:inline;">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-warning btn-sm">Detail</button>
                                                </form>
                                                @if(Auth::user()->hasRole(['superadmin']))
                                                <form action="{{ route('hapus-customer', $customer->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus customer ini?');">Hapus</button>
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
                            {{ $customers->appends(['query' => request('query')])->links('pagination::bootstrap-5') }}
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