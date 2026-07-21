<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Set default filter tanggal (misal 30 hari terakhir jika tidak diisi)
        $startDate = $request->input('start_date', now()->subDays(30)->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        // Base query dengan filter rentang tanggal
        $query = Booking::whereBetween('booking_date', [$startDate, $endDate]);

        // Hitung Summary Status untuk Card Dashboard
        $countPending    = (clone $query)->where('status', 'Pending')->count();
        $countProses     = (clone $query)->where('status', 'Proses')->count();
        $countReschedule = (clone $query)->where('status', 'Reschedule')->count();
        $countFinish     = (clone $query)->where('status', 'Finish')->count();

        // ----------------------------------------------------
        // DATA PARETO CHART (Diurutkan dari terbanyak)
        // ----------------------------------------------------
        $paretoData = (clone $query)
            ->select('status as category', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderBy('total', 'desc')
            ->get();

        $labels      = [];
        $totals      = [];
        $cumulatives = [];

        $totalAllAll  = $paretoData->sum('total');
        $runningTotal = 0;

        foreach ($paretoData as $item) {
            $labels[] = $item->category;
            $totals[] = $item->total;

            $runningTotal += $item->total;
            $percent       = $totalAllAll > 0 ? round(($runningTotal / $totalAllAll) * 100, 2) : 0;
            $cumulatives[] = $percent;
        }

        return view('dashboard.index', compact(
            'startDate',
            'endDate',
            'countPending',
            'countProses',
            'countReschedule',
            'countFinish',
            'labels',
            'totals',
            'cumulatives'
        ));
    }
}