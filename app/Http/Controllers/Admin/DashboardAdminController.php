<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\News;
use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Parameter Filter Tanggal Laporan (FR-13)
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // 2. Rangkuman Konten Utama
        $totalPackages = Package::count();
        $totalNews = News::count();
        $totalReviews = Review::count();
        $averageRating = number_format(Review::avg('rating') ?? 0.0, 1);

        // 3. Query Pemantauan Transaksi Real-Time (FR-11) dari tabel reservations
        $reservationQuery = Reservation::with(['user', 'package'])->latest();

        // Penerapan Filter Rentang Waktu (FR-13)
        if ($startDate && $endDate) {
            $reservationQuery->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $reservations = $reservationQuery->get();
        
        // Hitung total omset dari reservasi yang berstatus 'paid'
        $totalRevenue = $reservationQuery->where('status', 'paid')->sum('total_price');

        // 4. Ambil Ulasan Terbaru
        $latestReviews = Review::with(['user', 'package'])->orderBy('created_at', 'desc')->take(3)->get();

        return view('admin.dashboard', compact(
            'totalPackages', 
            'totalNews', 
            'totalReviews', 
            'averageRating',
            'reservations', // Dioper ke view
            'startDate',
            'endDate',
            'totalRevenue',
            'latestReviews'
        ));
    }

    public function printReport(Request $request)
    {
        // 1. Ambil parameter filter tanggal dari request
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // 2. Ambil data transaksi berdasarkan rentang tanggal yang sama dengan dashboard
        $reservations = Reservation::with(['user', 'package'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // 3. Hitung total omset dari transaksi yang berstatus 'paid'
        $totalRevenue = $reservations->where('status', 'paid')->sum('total_price');

        // 4. Return ke halaman blade baru khusus cetak yang tanpa sidebar/navbar
        return view('admin.print_report', compact('reservations', 'totalRevenue', 'startDate', 'endDate'));
    }
}