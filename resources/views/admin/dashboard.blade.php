@extends('layouts.admin')

@section('page_title', 'Dashboard & Pusat Kendali Sistem')

@section('content')
<div class="space-y-8">
    
    {{-- BARIS 1: KARTU INDIKATOR UTAMA --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xl shadow-slate-900/5 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Paket Wisata</span>
                <h3 class="text-xl font-black text-slate-900 mt-1">{{ number_format($totalPackages ?? 0) }} Data</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-sm">
                <i class="fas fa-cubes"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xl shadow-slate-900/5 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Artikel/Blog</span>
                <h3 class="text-xl font-black text-slate-900 mt-1">{{ number_format($totalNews ?? 0) }} Konten</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                <i class="fas fa-newspaper"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xl shadow-slate-900/5 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Total Ulasan</span>
                <h3 class="text-xl font-black text-slate-900 mt-1">{{ number_format($totalReviews ?? 0) }} Ulasan</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">
                <i class="fas fa-comments"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xl shadow-slate-900/5 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Rerata Rating</span>
                <h3 class="text-xl font-black text-amber-500 mt-1 flex items-center gap-1">
                    <i class="fas fa-star text-xs"></i> {{ number_format($averageRating ?? 0, 1) }}
                </h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                <i class="fas fa-star-half-alt"></i>
            </div>
        </div>
    </div>

    {{-- BARIS 2: PANEL FILTRASI TANGGAL & TOMBOL EKSPOR --}}
    <div class="bg-slate-900 text-white p-6 rounded-2xl border border-slate-800 shadow-xl shadow-sky-950/10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <span class="text-[11px] font-black text-sky-400 uppercase tracking-widest block">Ekspor Berkas Pembayaran</span>
                <h3 class="text-xl font-black tracking-tight mt-0.5">Cetak Laporan Transaksi Periode</h3>
                <p class="text-[11px] text-slate-400">Tentukan rentang tanggal untuk menyaring log finansial resmi.</p>
            </div>
            
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <input type="date" name="start_date" value="{{ $startDate }}" required class="bg-slate-800 border border-slate-700 text-xs font-bold rounded-xl p-2.5 text-slate-200 focus:outline-none focus:border-sky-500">
                    <span class="text-xs font-bold text-slate-500">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" required class="bg-slate-800 border border-slate-700 text-xs font-bold rounded-xl p-2.5 text-slate-200 focus:outline-none focus:border-sky-500">
                </div>
                
                <button type="submit" class="bg-sky-600 hover:bg-sky-500 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-2 shadow-sm">
                    <i class="fas fa-filter text-xs"></i> Filter Data
                </button>

                @if($startDate && $endDate)
                    <a href="{{ route('admin.dashboard') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs py-2.5 px-3 rounded-xl transition-all border border-slate-700 flex items-center gap-1.5" title="Reset Filter">
                        <i class="fas fa-redo-alt text-xs"></i>
                    </a>

                    <a href="{{ route('admin.dashboard.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs uppercase tracking-wider py-2.5 px-4 rounded-xl transition-all shadow-md flex items-center gap-2 cursor-pointer">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- BARIS 3: KOTAK TOTAL OMSET --}}
    @if($startDate && $endDate)
        <div class="bg-emerald-50/60 border border-emerald-200 p-5 rounded-2xl flex items-center justify-between animate-fadeIn">
            <div>
                <span class="text-[10px] font-black text-emerald-800/70 uppercase tracking-widest block">Total Omset Pendapatan Terfilter (Paid)</span>
                <h3 class="text-xl font-black text-emerald-900 mt-0.5">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
            </div>
            <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-lg border border-emerald-200">
                Periode Aktif
            </span>
        </div>
    @endif

    {{-- BARIS 4: TABEL UTAMA PEMANTAUAN LOG TRANSAKSI --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl shadow-slate-900/5 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">Log Transaksi & Status Pembayaran Wisatawan</h4>
                @if($startDate && $endDate)
                    <p class="text-[10px] text-slate-400 mt-0.5">Menampilkan data tanggal {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                @endif
            </div>
            <span class="text-[10px] text-emerald-500 font-bold uppercase tracking-wider flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Pemantauan Real-Time
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="py-4 px-6">No. Transaksi</th>
                        <th class="py-4 px-6">Waktu Transaksi</th>
                        <th class="py-4 px-6">Wisatawan</th>
                        <th class="py-4 px-6">Paket Tour</th>
                        <th class="py-4 px-6">Nominal</th>
                        <th class="py-4 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($reservations as $res)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                {{ $res->order_id }}
                            </td>
                            <td class="py-4 px-6 text-slate-500 whitespace-nowrap">
                                {{ optional($res->created_at)->format('d/m/Y H:i') ?? '-' }} WIB
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800">
                                {{ $res->user->name ?? 'Wisatawan' }}
                            </td>
                            <td class="py-4 px-6 font-medium text-sky-700">
                                {{ $res->package->title ?? 'Paket Pilihan' }}
                            </td>
                            <td class="py-4 px-6 font-black text-slate-900">
                                Rp {{ number_format($res->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center">
                                    <span @class([
                                        'font-black text-[9px] uppercase px-2.5 py-1 rounded-md tracking-wider border',
                                        'bg-emerald-50 text-emerald-700 border-emerald-200' => $res->status === 'paid',
                                        'bg-amber-50 text-amber-700 border-amber-200 animate-pulse' => $res->status === 'unpaid' || $res->status === 'pending',
                                        'bg-rose-50 text-rose-700 border-rose-200' => $res->status === 'canceled',
                                        'bg-slate-100 text-slate-600 border-slate-200' => !in_array($res->status, ['paid', 'unpaid', 'pending', 'canceled']),
                                    ])>
                                        {{ $res->status === 'paid' ? 'Paid' : ($res->status === 'unpaid' ? 'Unpaid' : ($res->status === 'canceled' ? 'Canceled' : 'Expired')) }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-medium">
                                <i class="fas fa-inbox text-2xl text-slate-300 block mb-2"></i>
                                Tidak ada rekaman log reservasi wisatawan pada sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection