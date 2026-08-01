<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengkel App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h4 class="fw-bold text-primary mb-0">Bengkel App</h4>
        </div>

        <div class="px-3 py-3 border-bottom bg-light">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px; font-weight: bold;">
                    {{ strtoupper(substr(Auth::user()->full_name ?? Auth::user()->username ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <h6 class="mb-0 fw-bold text-truncate">{{ Auth::user()->full_name ?? Auth::user()->username ?? 'User' }}</h6>
                    <small class="text-muted d-block text-truncate">{{ Auth::user()->role->role_name ?? 'Guest' }}</small>
                </div>
            </div>
        </div>

        <ul class="list-unstyled components">
            {{-- Dashboard (Semua Role) --}}
            <li class="{{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-chart-line me-2"></i> Dashboard</a>
            </li>

            {{-- Booking (Semua Role) --}}
            <li class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                <a href="{{ route('bookings.index') }}"><i class="fa-solid fa-calendar-check me-2"></i> Booking</a>
            </li>

            {{-- Customer & Vehicle (Khusus Manager & Admin) --}}
            @can('manage-master-data')
            <li class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <a href="{{ route('customers.index') }}"><i class="fa-solid fa-users me-2"></i> Customer</a>
            </li>
            <li class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                <a href="{{ route('vehicles.index') }}"><i class="fa-solid fa-car me-2"></i> Vehicle</a>
            </li>
            @endcan

            {{-- Brand & Users (Khusus Admin) --}}
            @can('isAdmin')
            <li class="{{ request()->routeIs('brands.*') ? 'active' : '' }}">
                <a href="{{ route('brands.index') }}"><i class="fa-solid fa-tags me-2"></i> Brand</a>
            </li>
            <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}"><i class="fa-solid fa-user-gear me-2"></i> Users</a>
            </li>
            @endcan
        </ul>

        <div class="p-3 mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 fw-bold">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3">
            <div class="container-fluid p-0">
                <span class="navbar-text fw-bold text-dark fs-5">
                    @yield('title', 'Dashboard')
                </span>
            </div>
        </nav>

        <div class="p-4">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>