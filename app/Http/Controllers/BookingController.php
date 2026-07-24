<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Reservation; 
use Midtrans\Config;
use Midtrans\Snap;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function showBookingForm(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $booking = null;

        if ($request->has('order_id')) {
            $booking = Reservation::where('order_id', $request->order_id)
                                  ->where('user_id', auth()->id())
                                  ->first();
        }

        return view('booking', compact('package', 'booking'));
    }

    // Fungsi handle submit AJAX untuk generate Snap Token
    public function process(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $request->validate([
            'tour_date' => 'required|date|after_or_equal:today',
            'pax'       => 'required|integer|min:' . ($package->min_pax ?? 1),
        ]);
        $totalPrice = $package->price * $request->pax;
        $orderId = 'TBB-' . time() . '-' . rand(100, 999); 
        
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);
        Config::$isSanitized = filter_var(env('MIDTRANS_IS_SANITIZED', true), FILTER_VALIDATE_BOOLEAN);
        Config::$is3ds = filter_var(env('MIDTRANS_IS_3DS', true), FILTER_VALIDATE_BOOLEAN);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $totalPrice,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone ?? auth()->user()->no_hp ?? '',
            ],
            'item_details' => [
                [
                    'id' => (string) $package->id,
                    'price' => (int) $package->price,
                    'quantity' => (int) $request->pax, 
                    'name' => substr($package->title ?? 'Paket Wisata', 0, 50),
                ]
            ],
            'callbacks' => [    
                'finish' => route('booking.form', ['id' => $package->id]) . '?status=success&order_id=' . $orderId,
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            Reservation::create([
                'user_id'     => auth()->id(),        
                'package_id'  => $package->id,
                'order_id'    => $orderId,            
                'travel_date' => $request->tour_date, 
                'quantity'    => $request->pax,       
                'total_price' => $totalPrice,
                'snap_token'  => $snapToken,          
                'status'      => 'unpaid',            
            ]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'total_price' => $totalPrice
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkout($order_id)
    {
        $reservation = Reservation::where('order_id', $order_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // 1. Jika sudah lunas, langsung arahkan ke profil
        if ($reservation->status === 'paid') {
            return redirect()->route('profile')->with('info', 'Pesanan ini sudah dibayar.');
        }

        $createdAt = Carbon::parse($reservation->created_at);
        $expiredTime = $createdAt->addHours(24);

        if (now()->greaterThan($expiredTime) || in_array($reservation->status, ['cancelled', 'expired'])) {
            if ($reservation->status !== 'cancelled') {
                $reservation->update(['status' => 'expired']);
            }

            return redirect()->route('profile')->with('error', 'Waktu pembayaran untuk pesanan ini telah berakhir/kadaluarsa.');
        }

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);
        Config::$isSanitized = filter_var(env('MIDTRANS_IS_SANITIZED', true), FILTER_VALIDATE_BOOLEAN);
        Config::$is3ds = filter_var(env('MIDTRANS_IS_3DS', true), FILTER_VALIDATE_BOOLEAN);

        if (!$reservation->snap_token) {
            $params = [
                'transaction_details' => [
                    'order_id' => $reservation->order_id,
                    'gross_amount' => (int) $reservation->total_price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->phone ?? auth()->user()->no_hp ?? '',
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $reservation->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                return redirect()->route('profile')->with('error', 'Gagal memuat sesi pembayaran: ' . $e->getMessage());
            }
        } else {
            $snapToken = $reservation->snap_token;
        }

        return view('booking_checkout', compact('reservation', 'snapToken', 'expiredTime'));
    }

    // Webhook Handler Notification dari Midtrans
    public function updateStatus(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signatureKey = $request->signature_key;

        $hashedSignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);
        if ($signatureKey && $hashedSignature !== $signatureKey) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Signature Key. Request ditolak!'
            ], 403);
        }
        
        $booking = Reservation::where('order_id', $orderId)->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Data pesanan tidak ditemukan.'
            ], 404);
        }
        
        $transactionStatus = $request->transaction_status ?? $request->status;
        $newStatus = $booking->status;

        if (in_array($transactionStatus, ['capture', 'settlement', 'success', 'paid'])) {
            $newStatus = 'paid';
        } elseif ($transactionStatus == 'pending') {
            $newStatus = 'unpaid';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failed'])) {
            $newStatus = 'cancelled';
        }

        $booking->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui menjadi ' . $newStatus
        ]);
    }

    // Mengunduh / Mencetak E-Ticket
    public function downloadTicket($order_id)
    {
        $query = Reservation::where('order_id', $order_id);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $reservation = $query->first();

        if (!$reservation) {
            abort(404, 'Reservasi tidak ditemukan atau Anda tidak memiliki akses ke tiket ini.');
        }

        if ($reservation->status !== 'paid') {
            return back()->with('error', 'E-Ticket belum dapat diunduh karena pembayaran belum dikonfirmasi.');
        }

        return view('tickets.print', compact('reservation'));
    }
}