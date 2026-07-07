@extends('layouts.app')

@section('title', 'Profil Wisatawan - Travel Belitung Begaye')

@section('content')
<div class="min-h-screen bg-slate-50/50 py-12 md:py-20" x-data="{ openReviewModal: false, selectedPackageId: '', selectedReservationId: ''}">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-semibold flex items-center gap-3 shadow-xs">
                <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs shrink-0">
                    <i class="fas fa-check"></i>
                </div>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-semibold flex items-center gap-3 shadow-xs">
                <div class="w-6 h-6 rounded-full bg-rose-500 text-white flex items-center justify-center text-xs shrink-0">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- KARTU PROFIL UTAMA --}}
            <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden lg:sticky lg:top-28">
                <div class="h-24 bg-linear-to-r from-sky-500 to-sky-700 relative"></div>
                <div class="px-6 pb-8 relative text-center">
                    <div class="w-24 h-24 bg-linear-to-b from-sky-100 to-white text-sky-700 rounded-full flex items-center justify-center mx-auto -mt-12 border-4 border-white shadow-md text-3xl font-black tracking-wider">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mt-4 tracking-tight">{{ $user->name }}</h3>
                    <span class="inline-block mt-1.5 bg-sky-50 text-sky-700 border border-sky-100 px-3 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider">
                        <i class="fas fa-map-marked-alt mr-1"></i> {{ $user->role }}
                    </span>
                    <div class="mt-8 pt-6 border-t border-slate-100 space-y-4 text-left text-sm text-slate-600">
                        <div class="flex items-center gap-3.5 px-2 py-1 hover:bg-slate-50 rounded-xl transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center text-xs">
                                <i class="far fa-envelope text-sm"></i>
                            </div>
                            <div class="truncate">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Alamat Email</p>
                                <p class="font-medium text-slate-800 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3.5 px-2 py-1 hover:bg-slate-50 rounded-xl transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center text-xs">
                                <i class="fas fa-phone-alt text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nomor Handphone</p>
                                <p class="font-medium text-slate-800">{{ $user->no_hp ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- LIST RIWAYAT RESERVASI --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-xs">
                            <i class="fas fa-suitcase-rolling text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 tracking-tight">Riwayat Perjalanan</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Kelola pesanan paket wisata dan berikan ulasan Anda.</p>
                        </div>
                    </div>
                    <span class="bg-slate-100 text-slate-800 px-3 py-1 rounded-full text-xs font-bold border border-slate-200">
                        {{ $reservations->count() }} Total
                    </span>
                </div>

                @forelse($reservations as $reservation)
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs hover:shadow-md hover:border-slate-300 transition-all duration-300">
                        <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                            <div class="space-y-2.5 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-mono text-xs text-slate-400 font-bold tracking-wider">#{{ $reservation->order_id }}</span>
                                    <span class="text-slate-300 text-xs">•</span>
                                    @if($reservation->status == 'paid')
                                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider">
                                            <i class="fas fa-check-circle mr-1"></i> Paid / Lunas
                                        </span>
                                    @elseif($reservation->status == 'unpaid')
                                        <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider">
                                            <i class="fas fa-clock mr-1"></i> Menunggu Pembayaran
                                        </span>
                                    @else
                                        <span class="bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider">
                                            {{ $reservation->status }}
                                        </span>
                                    @endif
                                </div>
                                <h4 class="text-lg font-black text-slate-900 tracking-tight leading-snug">
                                    {{ $reservation->package->title }}
                                </h4>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 pt-1 text-xs text-slate-500 font-medium">
                                    <span class="flex items-center gap-1.5">
                                        <i class="far fa-calendar-alt text-slate-400"></i>
                                        Jadwal Tour: <strong class="text-slate-700">{{ \Carbon\Carbon::parse($reservation->travel_date)->format('d M Y') }}</strong>
                                    </span>
                                    <span class="hidden sm:inline text-slate-300">|</span>
                                    <span class="flex items-center gap-1.5">
                                        <i class="fas fa-users text-slate-400"></i>
                                        Jumlah: <strong class="text-slate-700">{{ $reservation->quantity }} Pax</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="flex sm:flex-col justify-between sm:justify-center items-center sm:items-end gap-3 w-full sm:w-auto border-t sm:border-t-0 pt-4 sm:pt-0 border-slate-100">
                                <div class="text-left sm:text-right">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Bayar</p>
                                    <p class="text-base font-black text-slate-900">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
                                </div>
                                
                                {{-- PERBAIKAN: Tombol Aksi khusus untuk status PAID --}}
                                @if($reservation->status == 'paid')
                                    <div class="flex items-center gap-2">
                                        {{-- Tombol Unduh E-Ticket --}}
                                        <a href="{{ route('reservations.downloadTicket', $reservation->order_id) }}" 
                                            target="_blank"
                                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 shadow-xs cursor-pointer"
                                            title="Unduh E-Ticket PDF">
                                                <i class="fas fa-ticket-alt text-sm"></i> E-Ticket
                                        </a>

                                        @if(in_array($reservation->id, $reviewedReservationIds))
                                            <span class="bg-slate-100 text-slate-500 border border-slate-200 font-medium text-xs px-3.5 py-2.5 rounded-xl flex items-center gap-2 select-none">
                                                <i class="fas fa-check text-xs text-slate-400"></i> Sudah Diulas
                                            </span>
                                        @else
                                            <button type="button" 
                                                    @click="selectedPackageId = '{{ $reservation->package_id }}'; selectedReservationId = '{{ $reservation->id }}'; openReviewModal = true"
                                                    class="bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white border border-sky-100 hover:border-sky-600 font-bold text-xs px-3.5 py-2.5 rounded-xl transition-all duration-200 flex items-center gap-2 cursor-pointer shadow-xs">
                                                <i class="far fa-star text-sm"></i> Beri Ulasan
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 border-dashed rounded-3xl p-16 text-center text-slate-500 shadow-xs">
                        <div class="w-16 h-16 bg-slate-50 border border-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl shadow-xs">
                            <i class="fas fa-compass"></i>
                        </div>
                        <h5 class="text-base font-black text-slate-900 tracking-tight">Belum Ada Riwayat Perjalanan</h5>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Jelajahi keindahan Pulau Belitung bersama kami.</p>
                    </div>
                @endforelse

                {{-- Navigasi Pagination Custom --}}
                @if ($reservations->hasPages())
                    <div class="mt-8 p-4 bg-white border border-slate-200 rounded-2xl shadow-xs flex items-center justify-between">
                        <div class="flex flex-1 justify-between sm:hidden">
                            @if ($reservations->onFirstPage())
                                <span class="relative inline-flex items-center rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold text-slate-400 cursor-not-allowed">Previous</span>
                            @else
                                <a href="{{ $reservations->previousPageUrl() }}" class="relative inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Previous</a>
                            @endif

                            @if ($reservations->hasMorePages())
                                <a href="{{ $reservations->nextPageUrl() }}" class="relative inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Next</a>
                            @else
                                <span class="relative inline-flex items-center rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold text-slate-400 cursor-not-allowed">Next</span>
                            @endif
                        </div>
                        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                            <div>
                                <p class="text-xs text-slate-500 font-medium">
                                    Menampilkan <span class="font-bold text-slate-800">{{ $reservations->firstItem() }}</span> sampai <span class="font-bold text-slate-800">{{ $reservations->lastItem() }}</span> dari <span class="font-bold text-slate-800">{{ $reservations->total() }}</span> riwayat
                                </p>
                            </div>
                            <div>
                                <nav class="isolate inline-flex -space-x-px rounded-xl shadow-xs gap-1" aria-label="Pagination">
                                    {{-- Tombol Previous --}}
                                    @if ($reservations->onFirstPage())
                                        <span class="relative inline-flex items-center rounded-lg p-2 text-slate-400 bg-slate-50 border border-slate-200 cursor-not-allowed text-xs"><i class="fas fa-chevron-left"></i></span>
                                    @else
                                        <a href="{{ $reservations->previousPageUrl() }}" class="relative inline-flex items-center rounded-lg p-2 text-slate-500 bg-white border border-slate-200 hover:bg-slate-50 text-xs"><i class="fas fa-chevron-left"></i></a>
                                    @endif

                                    {{-- Element Angka Halaman --}}
                                    @foreach ($reservations->getUrlRange(1, $reservations->lastPage()) as $page => $url)
                                        @if ($page == $reservations->currentPage())
                                            <span aria-current="page" class="relative z-10 inline-flex items-center bg-sky-600 px-3 py-1.5 text-xs font-black text-white rounded-lg">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}" class="relative inline-flex items-center bg-white px-3 py-1.5 text-xs font-bold text-slate-700 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">{{ $page }}</a>
                                        @endif
                                    @endforeach

                                    {{-- Tombol Next --}}
                                    @if ($reservations->hasMorePages())
                                        <a href="{{ $reservations->nextPageUrl() }}" class="relative inline-flex items-center rounded-lg p-2 text-slate-500 bg-white border border-slate-200 hover:bg-slate-50 text-xs"><i class="fas fa-chevron-right"></i></a>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL REVIEW --}}
    @include('partials.modal-review')
</div>
@endsection