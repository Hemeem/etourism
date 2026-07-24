<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Menampilkan Halaman Profil & Riwayat Reservasi Wisatawan
     */
    public function profile(): View
    {
        $user = Auth::user();
        
        /** @var \Illuminate\Pagination\LengthAwarePaginator $reservations */
        $reservations = Reservation::with('package')
                                    ->where('user_id', $user->id)
                                    ->latest()
                                    ->paginate(5);

        $reviewedReservationIds = Review::where('user_id', $user->id)
                                        ->whereNotNull('reservation_id')
                                        ->pluck('reservation_id')
                                        ->toArray();

        return view('profile', compact('user', 'reservations', 'reviewedReservationIds'));
    }

    /**
     * Menyimpan Ulasan / Review Baru dari Form Wisatawan
     */
    public function storeReview(Request $request): RedirectResponse
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'package_id'     => 'required|exists:packages,id',
            'rating'         => 'required|integer|min:1|max:5',
            'comment'        => 'required|string|max:1000',
        ]);

        $reservation = Reservation::where('id', $request->reservation_id)
                                   ->where('user_id', Auth::id())
                                   ->first();

        if (!$reservation) {
            return redirect()->back()->with('error', 'Data reservasi tidak valid atau Anda tidak memiliki akses ke pesanan ini!');
        }
        if ($reservation->status !== 'paid') {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan ulasan pada pesanan yang sudah lunas.');
        }

        $alreadyReviewed = Review::where('user_id', Auth::id())
                                 ->where('reservation_id', $request->reservation_id)
                                 ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'Anda sudah pernah memberikan ulasan untuk riwayat perjalanan ini!');
        }

        Review::create([
            'user_id'        => Auth::id(),
            'reservation_id' => $reservation->id,
            'package_id'     => $reservation->package_id, 
            'rating'         => $request->rating,
            'comment'        => $request->comment,
            'status'         => 'pending',
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih telah berbagi pengalaman.');
    }
}