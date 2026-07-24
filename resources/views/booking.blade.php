@extends('layouts.app')

@section('title', 'Amankan Kursi Wisata Anda - Travel Belitung Begaye')

@section('content')
{{-- Library Midtrans Snap --}}
<script type="text/javascript" 
        src="{{ env('MIDTRANS_IS_PRODUCTION', false) ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" 
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
</script>

<style>
    [x-cloak] { display: none !important; }

    /* CSS CETAK PDF RESI */
    @media print {
        body * {
            visibility: hidden;
        }
        #printable-receipt, #printable-receipt * {
            visibility: visible;
        }
        #printable-receipt {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .no-print {
            display: none !important;
        }
        body {
            background-color: #ffffff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .bg-linear-to-r {
            background: linear-gradient(to right, #020617, #0f172a, #1e3a8a) !important;
        }
    }
</style>

<div class="min-h-screen from-sky-200 via-sky-100 to-indigo-100" 
     x-data="bookingSystem()" 
     x-init="initSystem()">
     
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="bg-white rounded-3xl p-1 border border-slate-200 shadow-xl mt-20">
            <div class="rounded-3xl border border-slate-100 overflow-hidden">
                
                {{-- Header Card --}}
                <div class="p-8 bg-linear-to-r from-slate-950 via-slate-900 to-blue-950 text-white flex flex-wrap justify-between items-center gap-6">
                    <div>
                        <span class="text-[10px] uppercase tracking-widest font-black text-sky-400 block mb-1">Amankan Pesanan Anda</span>
                        <h2 class="text-xl md:text-2xl font-black tracking-tight text-white">{{ $package->title }}</h2>

                        <div class="flex items-center gap-2 text-xs text-slate-300 font-medium mt-1.5">
                            <span class="bg-white/10 px-2.5 py-1 rounded-md border border-white/5 flex items-center gap-1.5">
                                <i class="far fa-clock text-sky-400"></i> Durasi Wisata: <strong class="text-white">{{ $package->duration ?? '3 Hari 2 Malam' }}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="bg-white/5 backdrop-blur-sm px-6 py-4 rounded-xl border border-white/10 text-right">
                        <span class="text-xs text-slate-300 block mb-0.5">Base Price</span>
                        <span class="text-lg font-black text-sky-400">Rp {{ number_format($package->price, 0, ',', '.') }}<span class="text-xs text-slate-400 font-normal"> /pax</span></span>
                    </div>
                </div>

                {{-- INDIKATOR STEP --}}
                <div class="max-w-md mx-auto my-8 px-6 no-print">
                    <div class="flex items-center justify-between relative">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-200 rounded-full -z-10"></div>
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-sky-500 rounded-full -z-10 transition-all duration-500"
                             :style="step === 1 ? 'width: 0%' : (step === 2 ? 'width: 50%' : 'width: 100%')">
                        </div>

                        <div class="flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-black transition-all duration-300 border-2"
                                 :class="step >= 1 ? 'bg-sky-500 text-white border-sky-500 shadow-md' : 'bg-white text-slate-400 border-slate-300'">
                                1
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-wider" :class="step === 1 ? 'text-sky-600' : 'text-slate-500'">Isi Data</span>
                        </div>

                        <div class="flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-black transition-all duration-300 border-2"
                                 :class="step >= 2 ? 'bg-sky-500 text-white border-sky-500 shadow-md' : 'bg-white text-slate-400 border-slate-300'">
                                2
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-wider" :class="step === 2 ? 'text-sky-600' : 'text-slate-500'">Review</span>
                        </div>

                        <div class="flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-black transition-all duration-300 border-2"
                                 :class="step === 3 ? 'bg-sky-500 text-white border-sky-500 shadow-md' : 'bg-white text-slate-400 border-slate-300'">
                                <template x-if="step < 3"><span>3</span></template>
                                <template x-if="step === 3"><i class="fas fa-check text-xs"></i></template>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-wider" :class="step === 3 ? 'text-sky-600' : 'text-slate-500'">Status</span>
                        </div>
                    </div>
                </div>

                <div class="p-8 md:p-10 space-y-8 pt-2">

                    {{-- STEP 1: MENGISI DETAIL --}}
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-100" class="space-y-6">
                        <div class="flex items-center gap-4 border-l-4 border-sky-600 pl-4 mb-8">
                            <i class="fas fa-user-edit text-2xl text-sky-600"></i>
                            <div>
                                <h3 class="text-base font-black text-slate-900 tracking-tight">Detail Kontak & Perjalanan</h3>
                                <p class="text-sm text-slate-600 mt-0.5">Lengkapi data di bawah untuk validasi e-tiket Anda.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-900 uppercase tracking-widest">Nama Lengkap Pemesan</label>
                                <input type="text" x-model="tourName" readonly class="w-full text-sm font-medium px-5 py-4 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 cursor-not-allowed focus:outline-hidden">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-900 uppercase tracking-widest">Alamat Email Aktif</label>
                                <input type="email" x-model="tourEmail" readonly class="w-full text-sm font-medium px-5 py-4 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 cursor-not-allowed focus:outline-hidden">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-900 uppercase tracking-widest">No. WhatsApp</label>
                                <input type="tel" x-model="tourPhone" readonly class="w-full text-sm font-medium px-5 py-4 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 cursor-not-allowed focus:outline-hidden">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-1">
                                        Tanggal Mulai<span class="text-rose-600">*</span>
                                    </label>
                                    <input type="date" 
                                        x-model="tourDate" 
                                        :min="getTodayDate()" 
                                        class="w-full text-sm font-medium px-5 py-4 bg-white border rounded-xl focus:outline-hidden focus:ring-4 transition-all text-slate-900" 
                                        :class="(pencetLanjut && !tourDate) ? 'border-rose-400 focus:border-rose-600 focus:ring-rose-100 bg-rose-50/20' : 'border-slate-300 focus:border-sky-600 focus:ring-sky-100'">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-1">Total Peserta (Pax) <span class="text-rose-600">*</span></label>
                                    <input type="number" x-model.number="totalPax" min="{{ $package->min_pax ?? 2 }}" class="w-full text-sm font-medium px-5 py-4 bg-white border rounded-xl focus:outline-hidden focus:ring-4 transition-all text-slate-900" :class="totalPax ? 'border-slate-300 focus:border-sky-600 focus:ring-sky-100' : 'border-rose-400 focus:border-rose-600 focus:ring-rose-100 bg-rose-50/20'">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-900 uppercase tracking-widest">Permintaan Khusus (Optional)</label>
                            <textarea x-model="specialRequest" rows="3" class="w-full text-sm font-medium px-5 py-4 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-hidden focus:border-sky-600 focus:ring-4 focus:ring-sky-100 transition-all resize-none"></textarea>
                        </div>

                        <div class="pt-8 flex justify-end">
                            <button type="button" 
                                    @click="pencetLanjut = true; if(tourName && tourEmail && tourPhone && tourDate && totalPax) { step = 2 } else { alert('Mohon lengkapi semua data kontak dan perjalanan!') }" 
                                    class="text-sm font-black px-8 py-4 rounded-xl transition-all flex items-center gap-2.5 shadow-md group bg-linear-to-b from-sky-500 to-sky-600 text-white hover:from-sky-600 hover:to-sky-700">
                                Lanjut Langkah 2 <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>

                    {{-- STEP 2: SUMMARY --}}
                    <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-100" class="space-y-8">
                        <div class="flex items-center gap-4 border-l-4 border-sky-600 pl-4 mb-8">
                            <i class="fas fa-file-invoice-dollar text-2xl text-sky-600"></i>
                            <div>
                                <h3 class="text-base font-black text-slate-900 tracking-tight">Review & Konfirmasi Pembayaran</h3>
                                <p class="text-sm text-slate-600 mt-0.5">Periksa kembali data Anda sebelum masuk ke gerbang pembayaran aman Midtrans.</p>
                            </div>
                        </div>

                        {{-- BOX SUMMARY --}}
                        <div class="bg-sky-50/50 border border-sky-200 rounded-2xl p-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                            <div class="border-l border-slate-300 pl-4">
                                <span class="text-[10px] uppercase tracking-widest text-slate-500 block mb-1">Pemesanan Atas Nama</span>
                                <span class="font-black text-slate-900 text-base" x-text="tourName || '-'"></span>
                            </div>
                            <div class="border-l border-slate-300 pl-4">
                                <span class="text-[10px] uppercase tracking-widest text-slate-500 block mb-1">Tanggal Mulai Tour</span>
                                <span class="font-black text-slate-900 text-base" x-text="tourDate ? new Date(tourDate).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : '-'"></span>
                            </div>
                            <div class="border-l border-slate-300 pl-4">
                                <span class="text-[10px] uppercase tracking-widest text-slate-500 block mb-1">Total Peserta</span>
                                <span class="font-black text-slate-900 text-base" x-text="totalPax + ' Pax'"></span>
                            </div>
                            <div class="border-l-4 border-sky-600 pl-4 bg-sky-100/50 rounded">
                                <span class="text-[10px] uppercase tracking-widest text-sky-800 block mb-1">Total Biaya (Lunas)</span>
                                <span class="font-black text-xl text-sky-800" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(basePrice * (totalPax || 0))"></span>
                            </div>
                        </div>

                        <div class="p-6 bg-slate-100 border border-slate-300 rounded-2xl flex items-start gap-4">
                            <i class="fas fa-shield-alt text-2xl text-emerald-600 mt-0.5"></i>
                            <div>
                                <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider">Sistem Pembayaran Instan & Aman</h4>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">Kami bekerja sama dengan <strong>Midtrans</strong>. Anda dapat membayar dengan Kartu Kredit, Virtual Account Bank, atau QRIS.</p>
                            </div>
                        </div>

                        <div class="pt-8 flex justify-between items-center border-t border-slate-200">
                            <button type="button" @click="step = 1" :disabled="isProcessing" class="text-slate-600 hover:text-slate-900 text-sm font-black transition-colors group">
                                <i class="fas fa-chevron-left text-[11px] group-hover:-translate-x-1 transition-transform"></i> Kembali ke Detail
                            </button>
                            
                            <button type="button" @click="dapatkanSnapToken()" :disabled="isProcessing" class="bg-linear-to-b from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white text-sm font-black px-8 py-4 rounded-xl transition-all flex items-center gap-2.5 shadow-md">
                                <template x-if="!isProcessing">
                                    <span class="flex items-center gap-2">Bayar Sekarang <i class="fas fa-external-link-alt text-xs"></i></span>
                                </template>
                                <template x-if="isProcessing">
                                    <span class="flex items-center gap-2"><i class="fas fa-spinner animate-spin"></i> Memproses Jaringan...</span>
                                </template>
                            </button>
                        </div>
                    </div>

                    {{-- STEP 3: STATUS & RESI REAL-TIME --}}
                    <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-100" class="space-y-10">
                        
                        {{-- KONDISI PENDING --}}
                        <div x-show="bookingStatus === 'pending'" class="text-center max-w-md mx-auto space-y-6 py-10">
                            <div class="w-24 h-24 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto shadow-md">
                                <i class="far fa-clock text-5xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Menunggu Pembayaran</h3>
                                <p class="text-sm text-slate-600 mt-2 leading-relaxed">Transaksi Anda telah dicatat dengan Order ID <strong x-text="orderId"></strong>. Silakan selesaikan pembayaran Anda di panel Midtrans.</p>
                            </div>
                        </div>

                        {{-- KONDISI SUCCESS --}}
                        <div x-show="bookingStatus === 'success'" class="space-y-4 -mt-6">
                            <div class="text-center max-w-md mx-auto space-y-4 no-print">
                                <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto shadow-md border-4 border-white">
                                    <i class="fas fa-check-circle text-4xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Pembayaran Anda Lunas!</h3>
                                    <p class="text-sm text-slate-600 mt-1.5">Sistem Midtrans berhasil memverifikasi pembayaran Anda secara aman dan real-time.</p>
                                </div>
                            </div>

                            {{-- DOKUMEN KWITANSI RESMI --}}
                            <div id="printable-receipt" class="border border-slate-200 rounded-2xl p-6 md:p-8 bg-slate-50/50 space-y-6">
                                <div class="flex justify-between items-start border-b border-slate-200 pb-4">
                                    <div>
                                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-wider">Kwitansi Bukti Pembayaran Resmi</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">Travel Belitung Begaye</p>
                                    </div>
                                    <span class="font-black text-emerald-700 bg-emerald-100 border border-emerald-300 px-3 py-1 rounded text-[10px] uppercase tracking-widest">
                                        PAID / LUNAS
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                    <div class="space-y-2">
                                        <div><span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">ID Transaksi</span><strong class="font-mono text-blue-900 text-base" x-text="orderId"></strong></div>
                                        <div><span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Nama Pelanggan</span><span class="font-bold text-slate-800" x-text="tourName"></span></div>
                                        <div><span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Email Kontak</span><span class="font-medium text-slate-700" x-text="tourEmail"></span></div>
                                    </div>
                                    <div class="space-y-2">
                                        <div><span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Tanggal Tour Mulai</span><span class="font-bold text-slate-800" x-text="tourDate ? new Date(tourDate).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : '-'"></span></div>
                                        <div><span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Jumlah Peserta</span><span class="font-bold text-slate-800" x-text="totalPax + ' Pax'"></span></div>
                                        <div><span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total Pembayaran</span><strong class="text-emerald-700 font-extrabold text-lg" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(basePrice * (totalPax || 0))"></strong></div>
                                    </div>
                                </div>

                                <div x-show="specialRequest" class="pt-4 border-t border-slate-200 text-xs text-slate-600">
                                    <span class="font-bold block text-slate-900 mb-1">Permintaan Khusus:</span>
                                    <p class="italic bg-white p-3 rounded-lg border border-slate-200" x-text="specialRequest"></p>
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL NAVIGATION DAN UNDUH --}}
                        <div class="pt-10 border-t border-slate-200 flex flex-wrap justify-center gap-4 no-print">
                            <button type="button" 
                                    @click="const win = window.open('/reservations/' + orderId + '/download-ticket', '_blank'); win.focus();" 
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-4 px-8 rounded-xl transition-all shadow-md flex items-center gap-2 cursor-pointer">
                                <i class="fas fa-ticket-alt text-sm"></i> Download / Cetak E-Ticket
                            </button>
                            
                            <a href="{{ route('paket.tour') }}" class="bg-linear-to-b from-slate-900 to-slate-950 hover:from-slate-800 hover:to-slate-900 text-white font-black text-xs py-4 px-8 rounded-xl transition-all shadow-md flex items-center gap-2">
                                Selesai & Kembali ke Katalog
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</div>

{{-- Logika Alpine JS --}}
<script>
function bookingSystem() {
    return {
        step: {{ request()->has("status") && request()->get("status") === "success" ? 3 : 1 }}, 
        
        tourName: @json(old('name', auth()->user()->name ?? '')),
        tourEmail: @json(old('email', auth()->user()->email ?? '')),
        tourPhone: @json(old('phone', auth()->user()->phone ?? auth()->user()->no_hp ?? '')),
        
        tourDate: @json($booking ? $booking->travel_date : ''), 
        totalPax: {{ (int) ($booking ? $booking->quantity : ($package->min_pax ?? 2)) }},
        basePrice: {{ (float) $package->price }},
        
        snapToken: @json($booking ? $booking->snap_token : ''),
        orderId: @json($booking ? $booking->order_id : ''),
        bookingStatus: @json($booking ? $booking->status : 'pending'),
        
        isProcessing: false,
        specialRequest: '',
        pencetLanjut: false,

        get totalPrice() {
            return this.totalPax * this.basePrice;
        },

        getTodayDate() {
            const today = new Date();
            today.setDate(today.getDate() + 1);
            
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0'); 
            const dd = String(today.getDate()).padStart(2, '0');
            
            return `${yyyy}-${mm}-${dd}`;
        },

        initSystem() {
            const urlParams = new URLSearchParams(window.location.search);
            const urlStatus = urlParams.get('status');
            const urlOrderId = urlParams.get('order_id');

            if (urlStatus === 'success') {
                this.step = 3;
                this.bookingStatus = 'success';
            }
            
            if (urlOrderId) {
                this.orderId = urlOrderId;
            }

            if (urlStatus === 'success' && this.orderId) {
                this.cekStatusUrl();
            }
        },

        async dapatkanSnapToken() {
            if (!this.tourDate) {
                alert('Silakan pilih tanggal tour terlebih dahulu.');
                return;
            }

            if (this.isProcessing) return;
            this.isProcessing = true;

            try {
                let response = await fetch('{{ route("booking.process", $package->id) }}', {
                    method: 'POST', 
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: this.tourName,
                        email: this.tourEmail,
                        phone: this.tourPhone,
                        tour_date: this.tourDate, 
                        pax: this.totalPax,       
                        request: this.specialRequest
                    })
                });

                let data = await response.json();

                if (data.success) {
                    this.snapToken = data.snap_token;
                    this.orderId = data.order_id;
                    this.bukaPopUpMidtrans();
                } else {
                    alert('Gagal memproses pesanan: ' + (data.message || 'Terjadi kesalahan.'));
                    this.isProcessing = false;
                }
            } catch (error) {
                console.error(error);
                alert('Gagal terhubung ke server.');
                this.isProcessing = false;
            }
        },

        cekStatusUrl() {
            fetch('{{ route("booking.update-status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    order_id: this.orderId,
                    status: 'paid'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Pemberitahuan: Sinkronisasi database gagal atau data tidak ditemukan.');
                }
            })
            .catch(err => console.error('Kesalahan Jaringan:', err));
        },

        bukaPopUpMidtrans() {
            let self = this;
            if (typeof window.snap !== 'undefined') {
                window.snap.pay(this.snapToken, {
                    onSuccess: function(result) {
                        self.bookingStatus = 'success';
                        self.step = 3;
                        self.isProcessing = false;
                    },
                    onPending: function(result) {
                        self.bookingStatus = 'pending';
                        self.step = 3;
                        self.isProcessing = false;
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal diproses.');
                        self.isProcessing = false;
                    },
                    onClose: function() {
                        self.isProcessing = false;
                    }
                });
            } else {
                alert('Library Midtrans tidak terdeteksi.');
                self.isProcessing = false;
            }
        }
    }
}
</script>
@endsection