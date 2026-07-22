@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">Dashboard & Summary Booking</h3>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('dashboard.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label font-semibold">Pilih Tanggal</label>
                <input type="date" name="date" class="form-control" value="{{ $selectedDate }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    <i class="fa-solid fa-filter me-1"></i> Filter Summary
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 fw-semibold">Pending</h6>
                    <h2 class="fw-bold mb-0">{{ $pendingCount }}</h2>
                </div>
                <i class="fa-solid fa-clock fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 fw-semibold">Proses</h6>
                    <h2 class="fw-bold mb-0">{{ $prosesCount }}</h2>
                </div>
                <i class="fa-solid fa-gears fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-secondary text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 fw-semibold">Reschedule</h6>
                    <h2 class="fw-bold mb-0">{{ $rescheduleCount }}</h2>
                </div>
                <i class="fa-solid fa-calendar-days fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 fw-semibold">Finish</h6>
                    <h2 class="fw-bold mb-0">{{ $finishCount }}</h2>
                </div>
                <i class="fa-solid fa-circle-check fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Grafik Jumlah Booking Harian</h5>
        <div style="height: 320px;">
            <canvas id="dailyBookingChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('dailyBookingChart').getContext('2d');
        
        const labels = {!! json_encode($chartLabels) !!};
        const dataValues = {!! json_encode($chartData) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Booking',
                    data: dataValues,
                    backgroundColor: '#0d6efd',
                    borderColor: '#0b5ed7',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    });
</script>
@endsection