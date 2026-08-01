<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input tanggal tunggal (default: Hari ini)
        $selectedDate = $request->input('date', Carbon::today()->format('Y-m-d'));
        $targetCarbonDate = Carbon::parse($selectedDate);

        // 2. Hitung Ringkasan Status Booking KHUSUS pada tanggal terpilih
        $pendingCount    = Booking::whereDate('booking_date', $selectedDate)->where('status', 'Pending')->count();
        $prosesCount     = Booking::whereDate('booking_date', $selectedDate)->where('status', 'Proses')->count();
        $rescheduleCount = Booking::whereDate('booking_date', $selectedDate)->where('status', 'Reschedule')->count();
        $finishCount     = Booking::whereDate('booking_date', $selectedDate)->where('status', 'Finish')->count();

        // 3. Buat Data Grafik Harian (7 Hari Terakhir hingga Tanggal Terpilih)
        $chartLabels = [];
        $chartData   = [];

        // Loop 7 hari ke belakang (misal dari H-6 sampai Tanggal Terpilih)
        for ($i = 6; $i >= 0; $i--) {
            $datePoint = $targetCarbonDate->copy()->subDays($i);
            $dateString = $datePoint->format('Y-m-d');

            // Format label tampilan grafik (contoh: "22 Jul" atau "Hari Ini")
            if ($dateString === Carbon::today()->format('Y-m-d')) {
                $chartLabels[] = 'Hari Ini (' . $datePoint->format('d/m') . ')';
            } elseif ($dateString === Carbon::yesterday()->format('Y-m-d')) {
                $chartLabels[] = 'Kemarin (' . $datePoint->format('d/m') . ')';
            } else {
                $chartLabels[] = $datePoint->format('d/m/Y');
            }

            // Hitung total booking pada tanggal tersebut
            $count = Booking::whereDate('booking_date', $dateString)->count();
            $chartData[] = $count;
        }

        return view('dashboard.index', compact(
            'selectedDate',
            'pendingCount',
            'prosesCount',
            'rescheduleCount',
            'finishCount',
            'chartLabels',
            'chartData'
        ));
    }
}