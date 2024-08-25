<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klasifikasi</title>
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
                        <h5>Klasifikasi Barang</h5>
                        <div class="d-grid gap-2 d-md-block mb-3">
                            <button id="generateKlasifikasi" class="btn btn-warning">
                                <span>
                                    <i class="ti ti-receipt"></i>
                                </span>
                                Generate Klasifikasi</button>
                        </div>
                        <table class="table table-hover" id="barangKlasifikasiTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Jumlah Barang</th>
                                    <th scope="col">Harga Barang</th>
                                    <th scope="col">Total Harga Per Barang</th>
                                    <th scope="col">Presentase Barang (%)</th>
                                    <th scope="col">Presentase Kumulatif (%)</th>
                                    <th scope="col">Golongan Barang ABC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi Otomatis -->
                            </tbody>
                        </table>
                        <div class="d-grid gap-2 d-md-block mb-3">
                            <a href="{{ route('export-klasifikasi-pdf') }}" class="btn btn-warning">
                                <span>
                                    <i class="ti ti-download"></i>
                                </span>
                                Cetak PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @section('scripts')
            <script>
                document.getElementById('generateKlasifikasi').addEventListener('click', function() {
                    fetch('{{ route('generate_klasifikasi') }}')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Data received:', data); 
                            if (!Array.isArray(data)) {
                                throw new Error('Data is not an array');
                            }

                            const tbody = document.querySelector('#barangKlasifikasiTable tbody');
                            tbody.innerHTML = ''; 

                            data.forEach((barang, index) => {
                                const row = `
                    <tr>
                        <th scope="row">${index + 1}</th>
                        <td>${barang.nama_barang}</td>
                        <td>${barang.jumlah_barang}</td>
                        <td>${parseFloat(barang.harga_barang).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td>${parseFloat(barang.total_harga_per_barang).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td>${parseFloat(barang.presentase_barang).toFixed()}%</td>
                        <td>${parseFloat(barang.presentase_kumulatif).toFixed()}%</td>
                        <td>${barang.golongan_barang}</td>
                    </tr>
                `;
                                tbody.innerHTML += row;
                            });
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                });
            </script>
            <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
            <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
            <script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>

</html>