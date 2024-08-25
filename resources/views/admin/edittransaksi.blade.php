<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Transaksi</title>
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
                        <form method="POST" action="{{ route('update-transaksi', $transaksi->id) }}" class="row">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="dataBarangSelect" class="form-label">Nama Barang</label>
                                <select id="dataBarangSelect" name="data_barang_id" class="form-select @error('data_barang_id') is-invalid @enderror" aria-label="Pilih Nama Barang">
                                    <option value="">Pilih Nama Barang</option>
                                    @foreach($dataBarang as $data)
                                    <option value="{{ $data->id }}" {{ $data->id == $transaksi->data_barang_id ? 'selected' : '' }}>
                                        {{ $data->nama_barang }} - {{ $data->vendor->nama ?? 'Vendor tidak ditemukan' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="customerSelect" class="form-label">Nama Customer</label>
                                <select id="customerSelect" name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" aria-label="Pilih Customer">
                                    <option value="">Pilih Nama Customer</option>
                                    @foreach($customers as $cust)
                                    <option value="{{ $cust->id }}" {{ $cust->id == $transaksi->customer_id ? 'selected' : '' }}>
                                        {{ $cust->nama }}
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
                                <label for="jumlah" class="form-label">Jumlah Barang</label>
                                <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" placeholder="Masukkan jumlah barang" value="{{ old('jumlah', $transaksi->jumlah) }}">
                                @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Barang</label>
                                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" aria-label="Pilih Status Barang">
                                    <option value="">Pilih Status Barang</option>
                                    <option value="masuk" {{ $transaksi->status == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                    <option value="keluar" {{ $transaksi->status == 'keluar' ? 'selected' : '' }}>Keluar</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                                <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi) }}">
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