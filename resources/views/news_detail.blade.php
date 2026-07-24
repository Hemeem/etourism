@extends('layouts.app')

@section('title', $post->title . ' - Travel Belitung Begaye')

@section('content')
@php
    $getSrcImage = function($img) {
        if (!$img) {
            return 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200';
        }
        if (str_starts_with($img, 'http') || str_starts_with($img, 'data:')) {
            return $img;
        }
        if (str_starts_with($img, 'storage/') || str_starts_with($img, 'uploads/')) {
            return asset($img);
        }
        return 'data:image/jpeg;base64,' . $img;
    };

    $mainImageUrl = $getSrcImage($post->image);
@endphp

<article class="bg-white">
    
    {{-- 1. HERO COVER ARTIKEL IMAGE --}}
    <div class="w-full h-80 md:h-112.5 relative bg-slate-900 overflow-hidden">
        <img src="{{ $mainImageUrl }}" alt="{{ $post->title }}" class="w-full h-full object-cover opacity-80">
        
        <div class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
        
        <div class="absolute inset-x-0 bottom-0 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 text-white z-10">
            <span class="bg-sky-500/90 backdrop-blur-xs text-white font-black text-[9px] uppercase tracking-widest px-3 py-1.5 rounded border border-sky-400/20 shadow-md inline-block mb-4">
                {{ $post->category ?? 'Informasi' }}
            </span>
            <h1 class="text-2xl md:text-4xl font-black tracking-tight leading-tight md:leading-snug text-white mb-4">
                {{ $post->title }}
            </h1>
            <div class="flex items-center gap-4 text-xs text-slate-300 font-medium">
                <span class="flex items-center gap-1.5">
                    <i class="far fa-calendar-alt text-sky-400"></i> 
                    {{ $post->created_at ? $post->created_at->format('d F Y') : 'Baru Saja' }}
                </span>
                <span class="w-1 h-1 rounded-full bg-slate-500"></span>
                <span class="flex items-center gap-1.5">
                    <i class="far fa-user text-sky-400"></i> Tim Redaksi Begaye
                </span>
            </div>
        </div>
    </div>

    {{-- 2. KONTEN UTAMA ARTIKEL --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 lg:gap-12">
            
            <div class="lg:col-span-8 text-slate-700 text-sm md:text-base leading-relaxed font-normal tracking-wide space-y-4">
                
                {{-- KONTEN BERITA --}}
                <div class="prose prose-slate max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>
                
                {{-- FOOTER ARTIKEL & SHARE --}}
                <div class="pt-10 border-t border-slate-100 mt-12 flex flex-wrap items-center justify-between gap-4">
                    <a href="{{ route('news.index') }}" class="text-xs font-black text-slate-500 hover:text-sky-600 flex items-center gap-2 group transition-colors">
                        <i class="fas fa-chevron-left text-[10px] group-hover:-translate-x-1 transition-transform"></i> Kembali ke Berita
                    </a>
                    
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Bagikan:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="w-8 h-8 rounded-full border border-slate-200 text-slate-400 hover:text-sky-600 hover:border-sky-500 flex items-center justify-center text-xs transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . request()->fullUrl()) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="w-8 h-8 rounded-full border border-slate-200 text-slate-400 hover:text-emerald-600 hover:border-emerald-500 flex items-center justify-center text-xs transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- SIDEBAR CALL TO ACTION --}}
            <div class="lg:col-span-4 mt-12 lg:mt-0 space-y-8">
                <div class="sticky top-24 bg-linear-to-b from-slate-950 to-blue-950 p-6 rounded-2xl border border-slate-800 text-white shadow-xl text-center overflow-hidden group">
                    <div class="absolute -right-6 -bottom-6 text-white/5 text-7xl"><i class="fas fa-plane-departure"></i></div>
                    <span class="text-[10px] uppercase tracking-widest font-black text-sky-400 block mb-1">Eksplorasi Sekarang</span>
                    <h4 class="text-sm font-black text-white tracking-tight leading-snug">Tertarik Liburan Langsung ke Belitung?</h4>
                    <p class="text-[11px] text-slate-400 mt-2 mb-5 leading-relaxed">Pesan paket tour premium kami dengan harga terjangkau dan fasilitas lengkap.</p>
                    <a href="{{ route('paket.tour') }}" class="w-full block bg-sky-500 hover:bg-sky-600 text-white font-black text-xs text-center py-3 px-4 rounded-xl shadow-lg shadow-sky-500/20 transition-all">
                        Lihat Katalog Paket
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- 3. REKOMENDASI ARTIKEL LAIN DI BAGIAN BAWAH --}}
    @if(isset($relatedPosts) && $relatedPosts->count() > 0)
        <div class="bg-slate-50/60 border-t border-slate-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-lg font-black text-blue-950 tracking-tight mb-8 border-l-4 border-sky-500 pl-4">Cerita Seru Lainnya</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $relPost)
                        @php
                            $relImageUrl = $getSrcImage($relPost->image);
                        @endphp
                        <a href="{{ route('news.show', $relPost->slug ?? $relPost->id) }}" class="bg-white rounded-xl border border-slate-100 p-4 flex gap-4 items-center shadow-xs hover:shadow-md transition-all group">
                            <div class="w-20 h-20 rounded-lg overflow-hidden bg-slate-100 shrink-0">
                                <img src="{{ $relImageUrl }}" alt="{{ $relPost->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-[9px] text-sky-600 font-bold uppercase tracking-wide">{{ $relPost->category ?? 'Tips Wisata' }}</span>
                                <h4 class="font-bold text-xs text-blue-950 mt-0.5 line-clamp-2 leading-snug group-hover:text-sky-600 transition-colors">
                                    {{ $relPost->title }}
                                </h4>
                                <span class="text-[10px] text-slate-400 block mt-1">
                                    <i class="far fa-calendar-alt"></i> {{ $relPost->created_at ? $relPost->created_at->format('d M Y') : 'Baru' }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</article>
@endsection