<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket_{{ $reservation->order_id }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: white !important;
                /* Mengatur margin fisik kertas cetak: 1.5cm atas, memberikan nafas agar tidak mepet */
                padding: 1.5cm 0 0 0 !important; 
            }
            .ticket-card {
                border: 1px solid #e2e8f0 !important;
                box-shadow: none !important;
                /* Jarak cadangan tambahan antar komponen internal saat dicetak */
                margin-top: 0.5cm !important; 
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 py-12 antialiased">

    {{-- BAR TOMBOL NAVIGASI --}}
    <div class="max-w-2xl mx-auto mb-6 flex justify-between items-center px-4 no-print">
        <a href="{{ url()->previous() }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1 transition-colors">
            &larr; Kembali
        </a>
        <button onclick="window.print()" class="bg-sky-600 text-white text-xs px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-sky-600/20 hover:bg-sky-700 transition-all transform hover:-translate-y-0.5">
            Cetak / Simpan PDF
        </button>
    </div>

    {{-- KONTEN UTAMA E-TIKET --}}
    <div class="max-w-2xl mx-auto bg-white border border-slate-200/80 rounded-3xl shadow-xl overflow-hidden relative ticket-card">
        
        {{-- Header --}}
        <div class="bg-linear-to-r from-slate-900 to-sky-950 p-8 text-white relative flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,var(--tw-gradient-stops))] from-sky-700/20 via-transparent to-transparent pointer-events-none"></div>
            
            {{-- Logo & Brand --}}
            <div class="flex items-center gap-3 relative z-10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Belitung Begaye" class="w-10 h-10 object-contain rounded-xl bg-white/10 p-1.5 border border-white/20">
                <div>
                    <h2 class="text-lg font-black tracking-tight leading-none">BELITUNG <span class="text-sky-400 font-serif italic font-normal">BEGAYE</span></h2>
                    <p class="text-[9px] text-sky-300/80 uppercase tracking-widest mt-1 font-medium">Official Travel E-Ticket</p>
                </div>
            </div>

            {{-- Order ID --}}
            <div class="text-center sm:text-right relative z-10 shrink-0">
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Nomor Order</span>
                <span class="font-mono text-sm font-bold bg-white/10 px-3 py-1 rounded-lg border border-white/10 tracking-wide">
                    {{ $reservation->order_id }}
                </span>
            </div>
        </div>

        {{-- Batas Lipatan Atas --}}
        <div class="relative flex items-center justify-between px-1 no-print">
            <div class="w-3 h-6 bg-slate-100 rounded-r-full -left-px relative z-10 border-y border-r border-slate-200/80"></div>
            <div class="w-full border-b border-dashed border-slate-200 mx-1"></div>
            <div class="w-3 h-6 bg-slate-100 rounded-l-full -right-px relative z-10 border-y border-l border-slate-200/80"></div>
        </div>

        {{-- Badan Utama Informasi Tiket --}}
        <div class="p-8 grid grid-cols-1 md:grid-cols-12 gap-6 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] bg-size-[16px_16px]">
            
            {{-- Kolom Kiri: Detail Utama Perjalanan --}}
            <div class="md:col-span-8 space-y-5">
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Paket Wisata / Tour</span>
                    <span class="text-base font-extrabold text-slate-900 tracking-tight leading-snug block">
                        {{ $reservation->package->title }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-0.5">Nama Utama Wisatawan</span>
                        <span class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-0.5">Jumlah Peserta</span>
                        <span class="text-xs font-extrabold text-sky-600">{{ $reservation->quantity }} Orang (Pax)</span>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-0.5">Tanggal Keberangkatan</span>
                        <span class="text-xs font-bold text-slate-800">
                            {{ \Carbon\Carbon::parse($reservation->travel_date)->format('d M Y') }}
                        </span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-0.5">Waktu Penjemputan</span>
                        <span class="text-xs font-medium text-slate-500">08:00 WIB (Sesuai Itinerary)</span>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Ringkasan Biaya --}}
            <div class="md:col-span-4 flex flex-col justify-center p-6 bg-slate-50 rounded-2xl border border-slate-100 text-center gap-2">
                <div>
                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Total Pembayaran</span>
                    <span class="text-base font-black text-slate-900 block">
                        Rp{{ number_format($reservation->total_price, 0, ',', '.') }}
                    </span>
                </div>
                <div class="mt-1">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-md text-[10px] font-black tracking-wide bg-emerald-50 text-emerald-700 border border-emerald-200/60 uppercase mx-auto">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        LUNAS
                    </span>
                </div>
            </div>

        </div>

        {{-- Footer Nota Kecil --}}
        <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-2 text-[9px] text-slate-400 font-medium">
            <p>*Tunjukkan E-Tiket smartphone atau cetak ini saat penjemputan di Bandara/Hotel.</p>
            <p class="font-bold text-slate-500">CS: +62 812-3456-7890</p>
        </div>
    </div>

    {{-- DIALOG PRINT OTOMATIS --}}
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 600);
        });

        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>
</html>