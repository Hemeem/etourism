@extends('layouts.app')

@section('title', 'Galeri Keindahan Pulau Belitung - Travel Belitung Begaye')

@section('content')
{{-- MENAMBAHKAN GLOBAL X-DATA UNTUK LIGHTBOX DAN NAVIGASI INTERAKTIF --}}
<div class="min-h-screen bg-linear-to-b from-slate-50 via-white to-sky-50/20 pb-24"
     x-data="{ 
        openLightbox: false, 
        activeImages: [], 
        activeIndex: 0, 
        activeTitle: '', 
        activeCategory: '',
        next() {
            if (this.activeIndex < this.activeImages.length - 1) {
                this.activeIndex++;
            } else {
                this.activeIndex = 0; // Kembali ke foto pertama jika sudah di ujung
            }
        },
        prev() {
            if (this.activeIndex > 0) {
                this.activeIndex--;
            } else {
                this.activeIndex = this.activeImages.length - 1; // Ke foto terakhir jika mundur dari awal
            }
        }
     }">
    
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
                        // Decode JSON gambar dari database menjadi array PHP
                        $imagesArray = json_decode($photo->image, true) ?? [];
                        
                        // Siapkan array baru berisikan format string data URI base64 lengkap untuk dibaca JavaScript/Alpine
                        $formattedImages = array_map(function($img) {
                            return 'data:image/jpeg;base64,' . $img;
                        }, $imagesArray);

                        $coverImage = !empty($formattedImages) ? $formattedImages[0] : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80';
                    @endphp

                    {{-- KARTU UTAMA ALBUM --}}
                    {{-- JSON_HEX_APOS digunakan agar string base64 aman saat di-convert menjadi parameter Alpine.js --}}
                    <div @click="openLightbox = true; activeImages = {{ json_encode($formattedImages, JSON_HEX_APOS) }}; activeIndex = 0; activeTitle = '{{ $photo->title }}'; activeCategory = '{{ $photo->filter_category }}'"
                         class="break-inside-avoid bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group relative hover:shadow-xl transition-all duration-300 cursor-pointer">
                        
                        <div class="overflow-hidden bg-slate-900 relative">
                            {{-- Render Cover --}}
                            <img src="{{ $coverImage }}" 
                                 alt="{{ $photo->title }}" 
                                 class="w-full h-auto object-cover group-hover:scale-104 transition-transform duration-700 opacity-95">
                            
                            {{-- INDIKATOR TOTAL FOTO --}}
                            @if(count($formattedImages) > 1)
                                <span class="absolute top-3 left-3 bg-slate-900/75 backdrop-blur-md text-white text-[9px] font-black px-2.5 py-1 rounded-lg uppercase tracking-wider z-10 shadow-sm">
                                    <i class="fas fa-images mr-1 text-sky-400"></i> {{ count($formattedImages) }} Foto
                                </span>
                            @endif

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
                                    <span class="bg-sky-600 px-2.5 py-1 rounded-md text-[9px] font-black text-white uppercase tracking-wider">Buka Album</span>
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
            <div class="text-center py-16 bg-white border border-slate-200/60 rounded-3xl max-w-sm mx-auto shadow-sm">
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3 shadow-inner">
                    <i class="fas fa-images text-base"></i>
                </div>
                <h3 class="text-xs font-black text-slate-950">Koleksi Foto Kosong</h3>
                <p class="text-[11px] text-slate-400 mt-1 px-6 leading-relaxed">Belum ada dokumentasi aset gambar untuk kategori ini di database Anda.</p>
            </div>
        @endif

    </div>

    {{-- INTERAKSI MODAL LIGHTBOX POPUP DENGAN TOMBOL NAVIGASI NEXT & PREV --}}
    <div x-show="openLightbox" 
         class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-950/95 backdrop-blur-md p-4 transition-all"
         @keydown.window.escape="openLightbox = false"
         @keydown.window.arrow-right="next()"
         @keydown.window.arrow-left="prev()"
         x-transition
         x-cloak>
        
        {{-- Tombol Close --}}
        <button @click="openLightbox = false; activeImages = []; activeIndex = 0;" 
                class="absolute top-6 right-6 text-white/60 hover:text-white text-xl cursor-pointer p-2 transition-colors z-50">
            <i class="fas fa-times"></i>
        </button>

        {{-- AREA UTAMA GAMBAR DAN TOMBOL GESER --}}
        <div class="relative w-full max-w-4xl max-h-[75vh] flex items-center justify-center group/modal">
            
            {{-- TOMBOL GESER KIRI (PREV) - Muncul jika foto dalam album lebih dari 1 --}}
            <template x-if="activeImages.length > 1">
                <button @click="prev()" 
                        class="absolute left-4 z-50 bg-slate-900/50 hover:bg-slate-900 text-white w-10 h-10 rounded-full flex items-center justify-center border border-white/10 transition-all cursor-pointer shadow-lg">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
            </template>

            {{-- ELEMEN GAMBAR AKTIF BERDASARKAN INDEX --}}
            <div class="overflow-hidden rounded-2xl shadow-2xl border border-white/5 bg-slate-900/40">
                <img :src="activeImages[activeIndex]" :alt="activeTitle" class="w-full h-full max-h-[75vh] object-contain transition-all duration-300">
            </div>

            {{-- TOMBOL GESER KANAN (NEXT) - Muncul jika foto dalam album lebih dari 1 --}}
            <template x-if="activeImages.length > 1">
                <button @click="next()" 
                        class="absolute right-4 z-50 bg-slate-900/50 hover:bg-slate-900 text-white w-10 h-10 rounded-full flex items-center justify-center border border-white/10 transition-all cursor-pointer shadow-lg">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </template>
        </div>

        {{-- INFORMASI METADATA & INDIKATOR HALAMAN (MISAL: 1 / 3) --}}
        <div class="text-center mt-6 max-w-xl space-y-1">
            <span x-text="activeCategory" class="text-[10px] font-black text-sky-400 uppercase tracking-widest block"></span>
            <h3 x-text="activeTitle" class="text-sm md:text-base font-bold text-white tracking-tight leading-snug"></h3>
            
            {{-- Angka Indikator Posisi Gambar --}}
            <template x-if="activeImages.length > 1">
                <p class="text-[10px] text-slate-400/80 font-bold tracking-wider pt-1 uppercase">
                    Foto <span x-text="activeIndex + 1" class="text-sky-400"></span> dari <span x-text="activeImages.length"></span>
                </p>
            </template>
        </div>
    </div>

</div>
@endsection