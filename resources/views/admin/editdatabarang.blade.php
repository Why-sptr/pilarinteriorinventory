<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Barang</title>
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
                        <form method="POST" action="{{ route('update-data-barang', $dataBarang->id) }}" class="row">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="jenisBarangSelect" class="form-label">Jenis Barang</label>
                                <select id="jenisBarangSelect" name="jenis_barang_id" class="form-select @error('jenis_barang_id') is-invalid @enderror">
                                    <option value="">Pilih Jenis Barang</option>
                                    @foreach($jenisBarang as $jenis)
                                    <option value="{{ $jenis->id }}" {{ old('jenis_barang_id', $dataBarang->jenis_barang_id) == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->jenis }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('jenis_barang_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" placeholder="Masukkan nama barang" value="{{ old('nama_barang', $dataBarang->nama_barang) }}">
                                @error('nama_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="vendorSelect" class="form-label">Vendor</label>
                                <select id="vendorSelect" name="vendor_id" class="form-select @error('vendor_id') is-invalid @enderror">
                                    <option value="">Pilih Jenis Barang</option>
                                    @foreach($vendors as $vndr)
                                    <option value="{{ $jenis->id }}" {{ old('vendor_id', $dataBarang->vendor_id) == $vndr->id ? 'selected' : '' }}>
                                        {{ $vndr->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('vendor_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="harga_barang" class="form-label">Harga Barang</label>
                                <input type="number" name="harga_barang" class="form-control @error('harga_barang') is-invalid @enderror" id="harga_barang" placeholder="Masukkan harga barang Rp." value="{{ old('harga_barang', $dataBarang->harga_barang) }}">
                                @error('harga_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="stok_barang" class="form-label">Jumlah Barang</label>
                                <input type="number" name="stok_barang" class="form-control @error('stok_barang') is-invalid @enderror" id="stok_barang" placeholder="Masukkan jumlah barang" value="{{ old('stok_barang', $dataBarang->stok_barang) }}">
                                @error('stok_barang')
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