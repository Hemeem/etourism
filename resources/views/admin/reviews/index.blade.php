@extends('layouts.admin')

@section('page_title', 'Manajemen & Analisis Ulasan')

@section('content')
<div>
    <div class="mb-8">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Manajemen & Analisis Ulasan Wisatawan</h2>
        <p class="text-xs text-slate-500 mt-0.5">Kelola visibilitas ulasan di halaman publik. Semua ulasan tetap tersimpan untuk kebutuhan analisis sistem.</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-400 shadow-xl shadow-slate-1000/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-400 text-[10px] font-black text-slate-400 uppercase tracking-widest">
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
                            <td class="py-4 px-6">
                                <div>
                                    <span class="font-black text-slate-900 block tracking-tight">{{ $review->user->name ?? 'User Terhapus' }}</span>
                                    <span class="text-xs text-sky-600 font-bold block mt-0.5">{{ $review->package->title ?? 'Paket Wisata Terhapus' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-0.5 text-amber-400 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star text-slate-200"></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-600 max-w-xs wrap-break-word">
                                {{ $review->comment }}
                            </td>
                            <td class="py-4 px-6">
                                @if($review->status == 'published')
                                    <span class="inline-block bg-emerald-50 text-emerald-700 border border-emerald-100 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider">
                                        Tampil di Publik
                                    </span>
                                @elseif($review->status == 'archived')
                                    <span class="inline-block bg-amber-50 text-amber-700 border border-amber-100 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider">
                                        Arsip / Internal Saja
                                    </span>
                                @else
                                    <span class="inline-block bg-slate-50 text-slate-600 border border-slate-100 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider">
                                        Menunggu Review
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Tombol Tampilkan ke Publik --}}
                                    @if($review->status !== 'published')
                                        <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="published">
                                            <button type="submit" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 text-[10px] font-black uppercase tracking-wider px-3 py-2 rounded-lg border border-emerald-200 transition-colors cursor-pointer">
                                                <i class="fas fa-globe mr-1"></i> Tampilkan
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Arsipkan / Masuk Evaluasi Internal --}}
                                    @if($review->status !== 'archived')
                                        <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="archived">
                                            <button type="submit" class="bg-amber-50 hover:bg-amber-100 text-amber-600 text-[10px] font-black uppercase tracking-wider px-3 py-2 rounded-lg border border-amber-200 transition-colors cursor-pointer">
                                                <i class="fas fa-archive mr-1"></i> Arsipkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- PERBAIKAN: Mengubah colspan dari 5 menjadi 5 kolom isi (Total sesuai jumlah th) --}}
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                Belum ada ulasan masuk dari wisatawan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection