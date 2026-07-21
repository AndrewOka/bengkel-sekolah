<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Booking Bengkel Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #2c3e50; color: #fff; }
        .sidebar a { color: #bdc3c7; text-decoration: none; padding: 12px 20px; display: block; border-radius: 6px; margin-bottom: 4px; }
        .sidebar a:hover, .sidebar a.active { background-color: #34495e; color: #fff; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar p-3">
            <h4 class="text-center fw-bold text-white mb-4"><i class="fa-solid fa-wrench me-2"></i>Bengkel App</h4>
            <div class="small text-muted mb-2 px-2 text-uppercase fw-bold">Menu Utama</div>
            <a href="{{ route('dashboard.index') }}" class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a>
            <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}"><i class="fa-solid fa-calendar-check me-2"></i>Booking Servis</a>
            
            <div class="small text-muted mt-4 mb-2 px-2 text-uppercase fw-bold">Master Data</div>
            <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}"><i class="fa-solid fa-users me-2"></i>Pelanggan</a>
            <a href="{{ route('vehicles.index') }}" class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}"><i class="fa-solid fa-motorcycle me-2"></i>Kendaraan</a>
            <a href="{{ route('brands.index') }}" class="{{ request()->routeIs('brands.*') ? 'active' : '' }}"><i class="fa-solid fa-tags me-2"></i>Merek</a>

            @if(Auth::check() && in_array(Auth::user()->role->role_name ?? '', ['Manager', 'Admin']))
                <div class="small text-muted mt-4 mb-2 px-2 text-uppercase fw-bold">Pengaturan</div>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}"><i class="fa-solid fa-user-gear me-2"></i>User Bengkel</a>
            @endif

            <hr class="my-4 border-secondary">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
            </form>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
                <h4 class="fw-bold m-0">Sistem Booking Bengkel Sekolah</h4>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary px-3 py-2 fs-6">{{ Auth::user()->role->role_name ?? 'User' }}</span>
                    <span class="fw-bold">{{ Auth::user()->full_name ?? 'Pengguna' }}</span>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')

</body>
</html>