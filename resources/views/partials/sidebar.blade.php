<!-- resources/views/partials/sidebar.blade.php -->
<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logos/logo-pilar-interior.svg') }}" width="150" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Master Data</span>
                </li>
                @if(Auth::user()->hasRole(['sales', 'superadmin', 'operasional', 'finance']))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/jenis-barang') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-package"></i>
                        </span>
                        <span class="hide-menu">Jenis Barang</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/data-barang') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-server"></i>
                        </span>
                        <span class="hide-menu">Data Barang</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasRole(['superadmin', 'operasional']))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/vendor') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-user"></i>
                        </span>
                        <span class="hide-menu">Data Vendor</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasRole(['superadmin']))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/user') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-user"></i>
                        </span>
                        <span class="hide-menu">List User</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasRole(['sales', 'superadmin']))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/transaksi') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-wallet"></i>
                        </span>
                        <span class="hide-menu">Transaksi</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasRole(['superadmin', 'operasional', 'finance']))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/biaya-operasional') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-truck"></i>
                        </span>
                        <span class="hide-menu">Biaya Operasional</span>
                    </a>
                </li>
                @endif
                <!-- <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Klasifikasi</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/kategori') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-list"></i>
                        </span>
                        <span class="hide-menu">Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/klasifikasi') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout"></i>
                        </span>
                        <span class="hide-menu">Klasifikasi</span>
                    </a>
                </li> -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Customer</span>
                </li>
                @if(Auth::user()->hasRole(['sales', 'superadmin']))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/customer') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-list"></i>
                        </span>
                        <span class="hide-menu">Data Customer</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/stok-customer') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-package"></i>
                        </span>
                        <span class="hide-menu">Stok Barang Customer</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->hasRole(['superadmin', 'operasional', 'finance']))
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/pengajuan') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-ticket"></i>
                        </span>
                        <span class="hide-menu">Pengajuan</span>
                    </a>
                </li>
                @endif
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Laporan</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/stok-barang') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-file"></i>
                        </span>
                        <span class="hide-menu">Stok Barang</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/barang-masuk') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-file"></i>
                        </span>
                        <span class="hide-menu">Barang Masuk</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/barang-keluar') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-file"></i>
                        </span>
                        <span class="hide-menu">Barang Keluar</span>
                    </a>
                </li>
                </li>
                <!-- Add other sidebar items here -->
            </ul>
        </nav>
    </div>
</aside>