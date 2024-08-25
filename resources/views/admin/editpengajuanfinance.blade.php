<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Pengajuan</title>
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
                        <form method="POST" action="{{ route('update-pengajuanfinance', $pengajuan->id) }}" class="row" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="customerSelect" class="form-label">Nama Customer</label>
                                <select id="customerSelect" name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" aria-label="Pilih Nama Customer">
                                    <option value="">Pilih Nama Customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $customer->id == $pengajuan->customer_id ? 'selected' : '' }}>
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
                                <label for="dataBarangSelect" class="form-label">Nama Barang</label>
                                <select id="dataBarangSelect" name="data_barang_id" class="form-select @error('data_barang_id') is-invalid @enderror" aria-label="Pilih Nama Barang">
                                    <option value="">Pilih Nama Barang</option>
                                    @foreach($dataBarang as $barang)
                                    <option value="{{ $barang->id }}" {{ $barang->id == $pengajuan->data_barang_id ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }} - {{ $barang->vendor->nama ?? 'Vendor tidak ditemukan' }}
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
                                <label for="biaya" class="form-label">Biaya</label>
                                <input type="number" name="biaya" class="form-control @error('biaya') is-invalid @enderror" id="biaya" placeholder="Masukkan biaya" value="{{ old('biaya', $pengajuan->biaya) }}">
                                @error('biaya')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Barang</label>
                                <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" placeholder="Masukkan jumlah barang" value="{{ old('jumlah', $pengajuan->jumlah) }}">
                                @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="statusSelect" class="form-label">Status</label>
                                <select id="statusSelect" name="status" class="form-select @error('status') is-invalid @enderror" aria-label="Pilih Status">
                                    <option value="diajukan" {{ $pengajuan->status == 'diajukan' ? 'selected' : '' }}>
                                        diajukan
                                    </option>
                                    <option value="disetujui" {{ $pengajuan->status == 'disetujui' ? 'selected' : '' }}>
                                        disetujui
                                    </option>
                                    <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>
                                        ditolak
                                    </option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                                <input type="date" name="tanggal_pengajuan" class="form-control @error('tanggal_pengajuan') is-invalid @enderror" id="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', $pengajuan->tanggal_pengajuan) }}">
                                @error('tanggal_pengajuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bukti_tf" class="form-label">Bukti Transfer</label>
                                <input type="file" name="bukti_tf" class="form-control @error('bukti_tf') is-invalid @enderror" id="bukti_tf">
                                @error('bukti_tf')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                @if($pengajuan->bukti_tf)
                                <img src="{{ asset('assets/images/bukti_tf/' . $pengajuan->bukti_tf) }}" alt="Bukti Transfer" class="img-thumbnail mt-2" style="max-height: 200px;">
                                @endif
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