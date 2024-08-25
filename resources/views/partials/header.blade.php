<!-- resources/views/partials/navbar.blade.php -->
<header class="app-header">
<nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
            </a>
        </li>
        <li class="nav-item d-none d-xl-block">
            <div class="container-fluid">
                <form class="d-flex" method="GET" action="{{ url()->current() }}">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>
        </li>
    </ul>
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            <a href="#" class="btn btn-primary">@php
                $user = Auth::user();
                @endphp
                Hallo {{ $user->name ?? 'Guest' }} </a>
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                    @php
                    $user = Auth::user();
                    @endphp
                    @if($user && $user->photo)
                    <img src="{{ asset('assets/images/profile/' . $user->photo) }}" alt="User Profile Picture" width="35" height="35" class="rounded-circle">
                    @else
                    <img src="{{ asset('assets/images/profile/default.jpg') }}" alt="Default Photo" width="35" height="35" class="rounded-circle">
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                <a href="{{ route('edit-profile') }}" class="d-flex align-items-center gap-2 dropdown-item">
                        <i class="ti ti-user fs-6"></i>
                        <p class="mb-0 fs-3">Profile Saya</p>
                    </a>
                    <div class="dropdown-header d-block d-xl-none">
                        <form class="d-flex" method="GET" action="{{ url()->current() }}">
                            <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </form>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST" class="d-inline mt-2">
                        @csrf
                        <!-- Desktop and tablet logout button -->
                        <button type="submit" class="btn btn-outline-primary d-none mx-3 mt-2 d-block d-md-block">Logout</button>
                        <!-- Mobile logout button with padding -->
                        <button type="submit" class="btn btn-primary p-2 w-100 d-md-none">Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>

</header>