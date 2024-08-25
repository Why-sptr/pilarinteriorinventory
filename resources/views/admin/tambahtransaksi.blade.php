<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Transaksi</title>
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
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                <div class="card w-100">
                    <div class="card-body">
                        <form method="POST" action="/simpan-transaksi" class="row">
                            @csrf
                            <div class="mb-3">
                                <label for="dataBarangSelect" class="form-label">Nama Barang</label>
                                <select id="dataBarangSelect" name="data_barang_id" class="form-select @error('data_barang_id') is-invalid @enderror">
                                    <option selected>Pilih Nama Barang</option>
                                    @foreach($dataBarang as $data)
                                    <option value="{{ $data->id }}" {{ old('data_barang_id') == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama_barang }} - {{ $data->vendor->nama ?? 'Vendor tidak ditemukan' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('data_barang_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jumlahBarangInput" class="form-label">Jumlah Barang</label>
                                <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" id="jumlahBarangInput" placeholder="masukkan jumlah barang" value="{{ old('jumlah') }}">
                                @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="statusBarangSelect" class="form-label">Status Barang</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" id="statusBarangSelect">
                                    <option value="" disabled selected>Pilih Status Barang</option>
                                    <option value="masuk" {{ old('status') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                    <option value="keluar" {{ old('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="customerSelect" class="form-label">Customer</label>
                                <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" id="customerSelect">
                                    <option value="" disabled selected>Pilih Customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tanggalTransaksiInput" class="form-label">Tanggal Transaksi</label>
                                <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggalTransaksiInput" value="{{ old('tanggal_transaksi') }}">
                                @error('tanggal_transaksi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="d-grid gap-2 d-md-block">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
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