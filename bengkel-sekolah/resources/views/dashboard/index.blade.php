@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">Dashboard & Summary Booking</h3>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('dashboard.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label font-semibold">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label font-semibold">Tanggal Selesai</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-filter me-1"></i> Filter Summary
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">Pending</h6>
                    <h2 class="fw-bold mb-0">{{ $countPending }}</h2>
                </div>
                <i class="fa-solid fa-clock fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">Proses</h6>
                    <h2 class="fw-bold mb-0">{{ $countProses }}</h2>
                </div>
                <i class="fa-solid fa-gears fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-secondary text-white p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">Reschedule</h6>
                    <h2 class="fw-bold mb-0">{{ $countReschedule }}</h2>
                </div>
                <i class="fa-solid fa-calendar-day fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">Finish</h6>
                    <h2 class="fw-bold mb-0">{{ $countFinish }}</h2>
                </div>
                <i class="fa-solid fa-circle-check fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm p-3">
    <h5 class="fw-bold mb-3">Pareto Chart (Jumlah & Persentase Akumulatif)</h5>
    <div style="position: relative; height: 350px; width: 100%;">
        <canvas id="paretoChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const labels      = {!! json_encode($labels) !!};
        const totals      = {!! json_encode($totals) !!};
        const cumulatives = {!! json_encode($cumulatives) !!};

        const ctx = document.getElementById('paretoChart').getContext('2d');

        new Chart(ctx, {
            data: {
                labels: labels,
                datasets: [
                    // Garis Persentase Kumulatif (%)
                    {
                        type: 'line',
                        label: 'Cumulative Frequency %',
                        data: cumulatives,
                        borderColor: '#ff4d4f',
                        backgroundColor: '#ff4d4f',
                        borderWidth: 2,
                        tension: 0.1,
                        yAxisID: 'y1',
                        order: 1
                    },
                    // Batang Frekuensi
                    {
                        type: 'bar',
                        label: 'Measure of Request',
                        data: totals,
                        backgroundColor: '#0d6efd',
                        borderRadius: 4,
                        barPercentage: 0.4,
                        yAxisID: 'y',
                        order: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        type: 'linear',
                        position: 'left',
                        title: { display: true, text: 'Measure of request' },
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        title: { display: true, text: 'Cumulative Frequency, %' },
                        min: 0,
                        max: 100,
                        ticks: {
                            callback: function(value) { return value + '%'; }
                        },
                        grid: { drawOnChartArea: false }
                    },
                    x: {
                        title: { display: true, text: 'Categories' }
                    }
                }
            }
        });
    });
</script>
@endpush