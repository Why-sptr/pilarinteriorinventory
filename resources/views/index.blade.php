<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
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
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <!--  Row 1 -->
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <p>Jumlah Data Barang</p>
                                <h5>{{ $dataBarangCount }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <p>Jumlah Transaksi</p>
                                <h5>{{ $transaksiCount }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <p>Jumlah Customer</p>
                                <h5>{{ $customerCount }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex align-items-stretch w-100">
                        <div class="card w-100">
                            <div class="card-body">
                                <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                                    <div class="mb-3 mb-sm-0">
                                        <h5 class="card-title fw-semibold">Rekap Sales</h5>
                                        <select id="monthYearFilter" class="form-select">
                                            <option value="">Pilih Bulan dan Tahun</option>
                                            @foreach ($months as $month)
                                            <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Omset</th>
                                                <th scope="col">Gross Profit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($overviewData->groupBy('user_name') as $userName => $customers)
                                            @foreach ($customers as $index => $data)
                                            @if ($index === 0)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $data['user_name'] }}</td>
                                                <td>{{ $data['customer_name'] }}</td>
                                                <td>{{ number_format($data['omset']) }}</td>
                                                <td>{{ number_format($data['gross_profit']) }}</td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td colspan="2"></td>
                                                <td>{{ $data['customer_name'] }}</td>
                                                <td>{{ number_format($data['omset']) }}</td>
                                                <td>{{ number_format($data['gross_profit']) }}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            <tr>
                                                <th colspan="4">Net Profit</th>
                                                <td>{{ number_format($netProfit) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 d-flex align-items-stretch">
                        <div class="card w-100" style="overflow: hidden;">
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <h5 class="card-title fw-semibold">Transaksi Terbaru</h5>
                                </div>
                                <ul class="timeline-widget mb-0 position-relative mb-n5">
                                    @foreach ($recentTransactions as $transaction)
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time text-dark flex-shrink-0 text-end">
                                            {{ $transaction->created_at->format('H:i') }}
                                        </div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge border-2 border 
                                        {{ $transaction->status === 'masuk' ? 'border-success' : 'border-warning' }} 
                                        flex-shrink-0 my-8"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1">
                                            {{ $transaction->dataBarang->nama_barang }} -
                                            {{ $transaction->status }}
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-body">
                                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                    <div class="mb-3 mb-sm-0">
                                        <h5 class="card-title fw-semibold">Data Customer Terbaru</h5>
                                    </div>
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Project</th>
                                            <th scope="col">Dana</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer as $index => $data)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $data->nama }}</td>
                                            <td>{{ $data->project }}</td>
                                            <td>{{ number_format($data->dana) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('monthYearFilter').addEventListener('change', function() {
            let selectedMonthYear = this.value;
            window.location.href = `?monthYear=${selectedMonthYear}`;
        });
    </script>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>

</html>