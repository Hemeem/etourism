@extends('layouts.app')

@section('title', 'Cerita & Panduan Wisata Belitung - Travel Belitung Begaye')

@section('content')
@php
    $getSrcImage = function($img) {
        if (!$img) {
            return 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';
        }
        if (str_starts_with($img, 'http') || str_starts_with($img, 'data:')) {
            return $img;
        }
        if (str_starts_with($img, 'storage/') || str_starts_with($img, 'uploads/')) {
            return asset($img);
        }
        return 'data:image/jpeg;base64,' . $img;
    };
@endphp

<div class="min-h-screen bg-linear-to-b from-sky-50 via-slate-50/50 to-white pb-24">
    
    {{-- HEADER SECTION & SEARCH BAR --}}
    <div class="relative overflow-hidden bg-linear-to-r from-slate-950 via-blue-950 to-slate-900 text-white py-20 mb-16 border-b border-white/5 shadow-xl shadow-blue-950/10">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-sky-500/10 rounded-full blur-3xl"></div>
        <div class="absolute left-1/4 bottom-0 w-60 h-20 bg-sky-600/5 rounded-full blur-2xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-flex items-center gap-1.5 bg-sky-500/10 text-sky-400 border border-sky-500/20 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">
                <i class="fas fa-sparkles text-[8px]"></i> Jurnal Begaye
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight leading-none">
                Arsip Cerita & <span class="text-transparent bg-clip-text bg-linear-to-r from-sky-400 to-sky-200">Tips Wisata</span>
            </h1>
            <p class="text-xs md:text-sm text-slate-400 mt-3 max-w-xl mx-auto font-medium leading-relaxed">
                Temukan rekomendasi kuliner tersembunyi, protokol perjalanan, dan rute <em>island hopping</em> terbaik langsung dari pemandu lokal kami.
            </p>

            <div class="max-w-md mx-auto mt-8">
                <form action="{{ route('news.index') }}" method="GET" class="relative group">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari panduan atau tips liburan..." 
                           class="w-full text-xs text-slate-900 px-6 py-4 bg-white/95 backdrop-blur-md border border-slate-200 rounded-2xl focus:outline-none focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10 transition-all shadow-xl shadow-black/10 placeholder-slate-400 font-medium">
                    <button type="submit" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-sky-600 transition-colors">
                        <i class="fas fa-search text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- FILTER KATEGORI --}}
        <div class="flex items-center justify-center gap-2.5 overflow-x-auto pb-4 mb-14 border-b border-slate-200/60 scrollbar-none">
            <a href="{{ route('news.index', array_filter(['search' => request('search')])) }}" 
               class="px-6 py-2.5 rounded-xl text-xs font-black transition-all tracking-wider whitespace-nowrap {{ !request('category') ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/20' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-400 hover:text-slate-900' }}">
                Semua Cerita
            </a>
            @foreach(['Destinasi', 'Kuliner', 'Tips', 'Budaya'] as $cat)
                <a href="{{ route('news.index', array_filter(['category' => $cat, 'search' => request('search')])) }}" 
                   class="px-6 py-2.5 rounded-xl text-xs font-black transition-all tracking-wider whitespace-nowrap {{ request('category') === $cat ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/20' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-400 hover:text-slate-900' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center gap-4 mb-8">
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Daftar Liputan Terbaru</h3>
            <div class="h-px bg-slate-200 flex-1"></div>
        </div>

        {{-- BAGIAN 1: FEATURED POST (SOROTAN) --}}
        @if(isset($featuredPost) && $featuredPost && !request('search') && !request('category'))
            @php
                $featuredImgUrl = $getSrcImage($featuredPost->image);
            @endphp
            <div class="max-w-5xl mx-auto bg-white rounded-3xl border border-slate-100 shadow-xl shadow-sky-900/5 overflow-hidden mb-20 group hover:shadow-2xl hover:shadow-sky-900/10 transition-all duration-500">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
                    <div class="md:col-span-5 h-64 md:h-80 overflow-hidden relative bg-slate-900">
                        <img src="{{ $featuredImgUrl }}" 
                             alt="{{ $featuredPost->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-95">
                        <div class="absolute inset-0 bg-linear-to-t from-black/20 via-transparent to-transparent"></div>
                    </div>
                    
                    <div class="md:col-span-7 p-8 md:p-10 flex flex-col justify-center bg-linear-to-br from-white to-slate-50/50">
                        <div class="flex items-center gap-3">
                            <span class="bg-sky-50 text-sky-700 border border-sky-100 font-black text-[9px] uppercase tracking-widest px-2.5 py-1 rounded-md">
                                {{ $featuredPost->category ?? 'Sorotan Utama' }}
                            </span>
                            <span class="text-slate-400 text-[11px] font-bold">
                                <i class="far fa-calendar-alt mr-1.5"></i>{{ $featuredPost->created_at ? $featuredPost->created_at->format('d M Y') : 'Baru Saja' }}
                            </span>
                        </div>
                        
                        <h2 class="text-lg md:text-xl font-black text-slate-950 tracking-tight mt-4 mb-3 leading-snug group-hover:text-sky-600 transition-colors">
                            <a href="{{ route('news.show', $featuredPost->slug ?? $featuredPost->id) }}">{{ $featuredPost->title }}</a>
                        </h2>
                        
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-6">
                            {{ Str::limit(strip_tags($featuredPost->content), 140) }}
                        </p>
                        
                        <div>
                            <a href="{{ route('news.show', $featuredPost->slug ?? $featuredPost->id) }}" class="inline-flex items-center gap-2 text-xs font-black text-sky-600 hover:text-sky-700 group/btn">
                                Baca Artikel Esensial <i class="fas fa-arrow-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- BAGIAN 2: REGULAR POSTS (GRID DAFTAR ARTIKEL) --}}
        @php
            $displayPosts = (request('category') || request('search')) ? $posts : ($regularPosts ?? $posts);
        @endphp

        @if(isset($displayPosts) && $displayPosts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($displayPosts as $post)
                    @php
                        $postImgUrl = $getSrcImage($post->image);
                    @endphp
                    <article class="bg-white rounded-2xl border border-slate-100 shadow-xl shadow-sky-900/5 overflow-hidden flex flex-col group hover:shadow-2xl hover:shadow-sky-900/10 transition-all duration-300">
                        <div class="h-48 overflow-hidden relative bg-slate-950">
                            <img src="{{ $postImgUrl }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90">
                            <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-md text-slate-900 font-black text-[9px] uppercase tracking-widest px-2.5 py-1 rounded shadow-xs border border-slate-100">
                                {{ $post->category ?? 'Tips Wisata' }}
                            </span>
                        </div>
                        <div class="p-6 flex flex-col flex-1 bg-white">
                            <span class="text-slate-400 text-[10px] font-bold"><i class="far fa-calendar-alt mr-1"></i> {{ $post->created_at ? $post->created_at->format('d M Y') : 'Baru Saja' }}</span>
                            <h4 class="font-black text-sm text-slate-950 tracking-tight mt-2.5 mb-2.5 leading-snug group-hover:text-sky-600 transition-colors line-clamp-2">
                                <a href="{{ route('news.show', $post->slug ?? $post->id) }}">{{ $post->title }}</a>
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-5 flex-1">
                                {{ Str::limit(strip_tags($post->content), 90) }}
                            </p>
                            <div class="pt-4 border-t border-slate-100/80">
                                <a href="{{ route('news.show', $post->slug ?? $post->id) }}" class="inline-flex items-center gap-1.5 text-xs font-black text-sky-600 hover:text-sky-700 group/btn">
                                    Baca Selengkapnya <i class="fas fa-chevron-right text-[9px] group-hover/btn:translate-x-0.5 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            @if(method_exists($displayPosts, 'links'))
                <div class="mt-12">
                    {{ $displayPosts->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16 bg-white border border-slate-200/60 rounded-3xl max-w-sm mx-auto shadow-xs">
                <div class="w-14 h-14 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <i class="fas fa-filter text-lg"></i>
                </div>
                <h3 class="text-sm font-black text-slate-950">Hasil Tidak Ditemukan</h3>
                <p class="text-xs text-slate-400 mt-1 px-6 leading-relaxed">Tidak ada tulisan atau artikel yang cocok dengan pencarian Anda saat ini.</p>
                <div class="pt-5">
                    <a href="{{ route('news.index') }}" class="inline-block bg-slate-950 text-white text-xs font-bold py-2.5 px-5 rounded-xl hover:bg-slate-800 transition-all shadow-md">Reset Filter</a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection