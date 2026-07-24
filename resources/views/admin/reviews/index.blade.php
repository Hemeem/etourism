@extends('layouts.admin')

@section('page_title', 'Manajemen & Analisis Ulasan')

@section('content')
<div>
    {{-- Header Section --}}
    <div class="mb-8">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Manajemen & Analisis Ulasan Wisatawan</h2>
        <p class="text-xs text-slate-500 mt-0.5">Kelola visibilitas ulasan di halaman publik. Semua ulasan tetap tersimpan untuk kebutuhan analisis sistem.</p>
    </div>

    {{-- Alert Success / Error --}}
    @if(session('success'))
        <div class="mb-4 p-4 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-2">
            <i class="fas fa-check-circle text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Main Table Container --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl shadow-slate-900/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="py-4 px-6">Wisatawan & Paket</th>
                        <th class="py-4 px-6">Rating</th>
                        <th class="py-4 px-6">Isi Ulasan/Komentar</th>
                        <th class="py-4 px-6">Status Publikasi</th>
                        <th class="py-4 px-6 text-right">Aksi Visibilitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            {{-- Info Wisatawan & Paket --}}
                            <td class="py-4 px-6">
                                <div>
                                    <span class="font-black text-slate-900 block tracking-tight">
                                        {{ $review->user->name ?? 'User Terhapus' }}
                                    </span>
                                    <span class="text-xs text-sky-600 font-bold block mt-0.5">
                                        {{ $review->package->title ?? 'Paket Wisata Terhapus' }}
                                    </span>
                                    @if($review->created_at)
                                        <span class="text-[10px] text-slate-400 block mt-1">
                                            <i class="far fa-clock mr-1"></i>{{ $review->created_at->format('d M Y, H:i') }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Rating Stars --}}
                            <td class="py-4 px-6 align-top whitespace-nowrap">
                                <div class="flex items-center gap-0.5 text-amber-400 text-xs mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star text-slate-200"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-[10px] text-slate-400 font-semibold mt-1 block">
                                    {{ $review->rating }} dari 5
                                </span>
                            </td>

                            {{-- Isi Komentar --}}
                            <td class="py-4 px-6 text-slate-600 max-w-xs wrap-break-word align-top">
                                <p class="leading-relaxed text-xs">
                                    {{ $review->comment ?? '-' }}
                                </p>
                            </td>

                            {{-- Status Badge --}}
                            <td class="py-4 px-6 align-top whitespace-nowrap">
                                @if($review->status == 'published')
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-100 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Tampil di Publik
                                    </span>
                                @elseif($review->status == 'archived')
                                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-100 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Arsip / Internal Saja
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 border border-slate-200 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Menunggu Review
                                    </span>
                                @endif
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="py-4 px-6 text-right align-top whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Tombol Tampilkan ke Publik --}}
                                    @if($review->status !== 'published')
                                        <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST" class="inline" onsubmit="return confirm('Tampilkan ulasan ini di halaman publik?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="published">
                                            <button type="submit" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 text-[10px] font-black uppercase tracking-wider px-3 py-2 rounded-lg border border-emerald-200 transition-colors cursor-pointer flex items-center gap-1">
                                                <i class="fas fa-globe"></i> Tampilkan
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Arsipkan / Masuk Evaluasi Internal --}}
                                    @if($review->status !== 'archived')
                                        <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST" class="inline" onsubmit="return confirm('Arsipkan ulasan ini agar hanya terlihat secara internal?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="archived">
                                            <button type="submit" class="bg-amber-50 hover:bg-amber-100 text-amber-600 text-[10px] font-black uppercase tracking-wider px-3 py-2 rounded-lg border border-amber-200 transition-colors cursor-pointer flex items-center gap-1">
                                                <i class="fas fa-archive"></i> Arsipkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                <i class="fas fa-comment-slash text-2xl mb-2 block text-slate-300"></i>
                                Belum ada ulasan masuk dari wisatawan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($reviews, 'hasPages') && $reviews->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection