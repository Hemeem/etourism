<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Reservation; 
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{
    // Mengambil data reservasi dari database jika proses payment redirect berhasil
    public function showBookingForm(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $booking = null;

        if ($request->has('order_id')) {
            $booking = Reservation::where('order_id', $request->order_id)
                                  ->where('user_id', auth()->id()) // Validasi keamanan agar user hanya bisa melihat pesanan miliknya
                                  ->first();
        }

        // Kirim $booking ke view (akan bernilai null jika user baru pertama kali buka form)
        return view('booking', compact('package', 'booking'));
    }

    // Fungsi handle submit AJAX untuk generate Snap Token
    public function process(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        
        // 1. Validasi Input Form
        $request->validate([
            'tour_date' => 'required|date',
            'pax' => 'required|integer|min:' . ($package->min_pax ?? 1),
        ]);

        // 2. Kalkulasi Total Harga & Generate Order ID
        $totalPrice = $package->price * $request->pax;
        $orderId = 'TBB-' . time() . '-' . rand(100, 999); 

        // 3. Konfigurasi Midtrans SDK
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);
        Config::$isSanitized = filter_var(env('MIDTRANS_IS_SANITIZED', true), FILTER_VALIDATE_BOOLEAN);
        Config::$is3ds = filter_var(env('MIDTRANS_IS_3DS', true), FILTER_VALIDATE_BOOLEAN);

        // 4. Buat parameter untuk dikirim ke Midtrans
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
            // 5. Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // 6. Menyimpan data menggunakan model Reservation
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

            // 7. Berikan respons sukses dalam bentuk JSON ke Frontend
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

    // Mengubah status pembayaran via request AJAX
    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|string'
        ]);

        // 8. Pencarian data menggunakan model Reservation
        $booking = Reservation::where('order_id', $request->order_id)->first();

        if ($booking) {
            $booking->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui menjadi ' . $request->status
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data pesanan tidak ditemukan.'
        ], 404);
    }

    public function downloadTicket($order_id)
    {
        // Cari data berdasarkan string order_id yang dikirim dari URL
        $reservation = Reservation::where('order_id', $order_id)->first();

        // Jika data tidak ditemukan, tampilkan error 404 agar tidak merusak layout
        if (!$reservation) {
            abort(404, 'Reservasi tidak ditemukan.');
        }

        // Return ke view e-ticket Anda
        return view('tickets.print', compact('reservation'));
    }
}