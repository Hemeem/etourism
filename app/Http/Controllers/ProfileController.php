<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // 1. Menampilkan Halaman Profil & Riwayat Reservasi Wisatawan
    public function profile()
    {
        $user = Auth::user();
        
        // Mengambil data riwayat dengan batasan 5 data per halaman
        $reservations = Reservation::with('package')
                                    ->where('user_id', $user->id)
                                    ->latest()
                                    ->paginate(5);

        // Ambil reservation_id dari ulasan yang sudah dibuat
        $reviewedReservationIds = Review::where('user_id', $user->id)
                                        ->whereNotNull('reservation_id')
                                        ->pluck('reservation_id')
                                        ->toArray();

        return view('profile', compact('user', 'reservations', 'reviewedReservationIds'));
    }

    // 2. Menyimpan Ulasan / Review Baru dari Form Wisatawan
    public function storeReview(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'package_id'     => 'required|exists:packages,id',
            'rating'         => 'required|integer|min:1|max:5',
            'comment'        => 'required|string|max:1000',
        ]);

        $alreadyReviewed = Review::where('user_id', Auth::id())
                                 ->where('reservation_id', $request->reservation_id)
                                 ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'Anda sudah pernah memberikan ulasan untuk riwayat perjalanan ini!');
        }

        Review::create([
            'user_id'        => Auth::id(),
            'reservation_id' => $request->reservation_id,
            'package_id'     => $request->package_id,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
            'status'         => 'pending',
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih telah berbagi pengalaman.');
    }
}