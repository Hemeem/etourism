@extends('layouts.app')

@section('title', 'Galeri Keindahan Pulau Belitung - Travel Belitung Begaye')

@section('content')
{{-- MENAMBAHKAN X-DATA UNTUK LIGHTBOX POPUP --}}
<div class="min-h-screen bg-linear-to-b from-slate-50 via-white to-sky-50/20 pb-24"
     x-data="{ openLightbox: false, activeSrc: '', activeTitle: '', activeCategory: '' }">
    
    {{-- HEADER SECTION --}}
    <div class="relative overflow-hidden bg-linear-to-r from-slate-950 via-blue-950 to-slate-900 text-white py-20 mb-12 border-b border-white/5 shadow-lg">
        <div class="absolute -right-12 -bottom-12 w-44 h-44 bg-sky-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-flex items-center gap-1.5 bg-sky-500/10 text-sky-400 border border-sky-500/20 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest mb-3">
                <i class="fas fa-camera text-[9px]"></i> Visual Belitung
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight">
                Galeri <span class="text-transparent bg-clip-text bg-linear-to-r from-sky-400 to-sky-200">Laskar Pelangi</span>
            </h1>
            <p class="text-xs md:text-sm text-slate-400 mt-3 max-w-md mx-auto font-medium leading-relaxed">
                Potret otentik keindahan pantai granit, air sejernih kristal, dan warisan budaya yang menanti Anda di Pulau Belitung.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- FILTER KATEGORI --}}
        <div class="flex items-center justify-center gap-2 overflow-x-auto pb-4 mb-12 border-b border-slate-100 scrollbar-none">
            <a href="{{ route('gallery.index', ['category' => 'Semua']) }}" 
               class="px-5 py-2.5 rounded-xl text-xs font-black transition-all tracking-wider whitespace-nowrap {{ !$category || $category === 'Semua' ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/20' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-400' }}">
                Semua Foto
            </a>
            @foreach(['Destinasi', 'Kuliner', 'Tips Liburan', 'Budaya'] as $cat)
                <a href="{{ route('gallery.index', ['category' => $cat]) }}" 
                   class="px-5 py-2.5 rounded-xl text-xs font-black transition-all tracking-wider whitespace-nowrap {{ $category === $cat ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/20' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-400' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
        
        {{-- MASONRY GRID GALLERY --}}
        @if($photos->count() > 0)
            <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-6 space-y-6">
                @foreach($photos as $photo)
                    @php
                        // Persiapkan source image untuk digunakan Alpine.js
                        $imageSrc = $photo->image ? 'data:image/jpeg;base64,' . $photo->image : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80';
                    @endphp

                    {{-- MENAMBAHKAN EVENT CLICK UNTUK MEMICU POPUP --}}
                    <div @click="openLightbox = true; activeSrc = '{{ $imageSrc }}'; activeTitle = '{{ $photo->title }}'; activeCategory = '{{ $photo->filter_category }}'"
                         class="break-inside-avoid bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group relative hover:shadow-xl transition-all duration-300 cursor-pointer">
                        
                        <div class="overflow-hidden bg-slate-900 relative">
                            <img src="{{ $imageSrc }}" 
                                 alt="{{ $photo->title }}" 
                                 class="w-full h-auto object-cover group-hover:scale-104 transition-transform duration-700 opacity-95">
                            
                            {{-- OVERLAY INFORMASI KETIKA KURSOR DIATAS GAMBAR (DESKTOP) --}}
                            <div class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                                <span class="text-[9px] font-black text-sky-400 uppercase tracking-widest block mb-1">
                                    {{ $photo->filter_category }}
                                </span>
                                <h3 class="text-white font-bold text-xs leading-snug tracking-tight line-clamp-2">
                                    {{ $photo->title }}
                                </h3>
                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-white/10 text-[10px] text-slate-400 font-medium">
                                    <span><i class="fas fa-camera text-sky-500 mr-1"></i> {{ $photo->source ?? 'Internal' }}</span>
                                    <span class="bg-white/10 px-2 py-0.5 rounded text-[9px] text-white">Lihat</span>
                                </div>
                            </div>
                        </div>

                        {{-- TAMPILAN TEXT KHUSUS LAYAR KECIL (MOBILE) --}}
                        <div class="p-4 group-hover:hidden block sm:hidden">
                            <span class="text-[9px] font-bold text-sky-600 uppercase tracking-wide">{{ $photo->filter_category }}</span>
                            <h4 class="font-bold text-xs text-slate-950 mt-0.5 truncate">{{ $photo->title }}</h4>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            {{-- TAMPILAN KETIKA DATA KATEGORI KOSONG --}}
            <div class="text-center py-16 bg-white border border-slate-200/60 rounded-3xl max-w-sm mx-auto shadow-sm">
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3 shadow-inner">
                    <i class="fas fa-images text-base"></i>
                </div>
                <h3 class="text-xs font-black text-slate-950">Koleksi Foto Kosong</h3>
                <p class="text-[11px] text-slate-400 mt-1 px-6 leading-relaxed">Belum ada dokumentasi aset gambar untuk kategori ini di database Anda.</p>
            </div>
        @endif

    </div>

    {{-- INTERAKSI MODAL LIGHTBOX POPUP KUSTOM --}}
    <div x-show="openLightbox" 
         class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-950/90 backdrop-blur-md p-4 transition-all"
         x-transition
         x-cloak>
        
        {{-- Tombol Close --}}
        <button @click="openLightbox = false; activeSrc = ''; activeTitle = ''" 
                class="absolute top-6 right-6 text-white/70 hover:text-white text-xl cursor-pointer p-2 transition-colors z-50">
            <i class="fas fa-times"></i>
        </button>

        {{-- Kontainer Gambar Utama --}}
        <div class="relative max-w-4xl max-h-[75vh] flex items-center justify-center overflow-hidden rounded-2xl shadow-2xl border border-white/5"
             @click.away="openLightbox = false; activeSrc = ''; activeTitle = ''">
            <img :src="activeSrc" :alt="activeTitle" class="w-full h-full max-h-[75vh] object-contain">
        </div>

        {{-- Informasi Teks di Bawah Gambar Popup --}}
        <div class="text-center mt-4 max-w-xl space-y-1">
            <span x-text="activeCategory" class="text-[10px] font-black text-sky-400 uppercase tracking-widest block"></span>
            <h3 x-text="activeTitle" class="text-sm md:text-base font-bold text-white tracking-tight leading-snug"></h3>
        </div>
    </div>

</div>
@endsection