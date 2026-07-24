@extends('layouts.app')

@section('title', 'Travel Belitung Begaye - Agen Pariwisata Terbaik di Belitung')

@section('content')

{{-- HERO SECTION --}}
    <section class="relative w-full min-h-[90vh] flex items-center bg-white px-6 md:px-12 lg:px-16 py-12">
        <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center relative z-10">

            <div class="lg:col-span-5 order-2 lg:order-1 flex flex-col justify-center w-full">
                <div class="flex justify-start">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-sky-20 text-sky-700 rounded-full text-xs md:text-sm font-bold mb-6 shadow-sm border border-sky-100">
                        Solusi Perjalanan Digital Travel Belitung Begaye
                    </span>
                </div>

                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black leading-[1.1] text-slate-900 tracking-tight">
                    Nikmati Liburan <br>
                    <span class="text-sky-700 italic font-serif font-normal">Terbaik</span> di Belitung
                </h1>

                <p class="mt-6 text-slate-600 text-sm md:text-base lg:text-lg leading-relaxed max-w-xl">
                    Sistem informasi e-tourism terintegrasi. Memudahkan Anda memesan tiket, menjelajahi destinasi Laskar
                    Pelangi, dan bertransaksi secara mandiri dan aman.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row justify-start items-center gap-4 w-full">
                    <a href="{{ route('paket.tour') }}"
                    class="w-full sm:w-auto bg-sky-700 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-sky-700/20 hover:bg-sky-800 transition transform hover:-translate-y-1 text-center">
                        Booking Sekarang
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7 order-1 lg:order-2 w-full relative">
                <div class="grid grid-cols-3 gap-3 sm:gap-4 md:gap-5 items-center w-full">
                    @php
                        $getPhotoSrc = function($index) use ($photos) {
                            if (isset($photos[$index])) {
                                $imagesArray = json_decode($photos[$index]->image, true) ?? [];
                                if (!empty($imagesArray)) {
                                    return 'data:image/jpeg;base64,' . $imagesArray[0];
                                }   
                            }
                            // Fallback default image jika index belum ada data
                            return 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=600&q=80';
                        };

                        $getPhotoTitle = function($index) use ($photos) {
                            return isset($photos[$index]) ? $photos[$index]->title : 'Wisata Belitung';
                        };
                    @endphp

                    {{-- Kolom 1 --}}
                    <div class="space-y-3 sm:space-y-4 md:space-y-5">
                        <div class="rounded-3xl sm:rounded-4xl overflow-hidden shadow-xl aspect-3/4 w-full bg-slate-100">
                            <img src="{{ $getPhotoSrc(0) }}" class="w-full h-full object-cover" alt="{{ $getPhotoTitle(0) }}">
                        </div>
                        <div class="rounded-3xl sm:rounded-4xl overflow-hidden shadow-xl aspect-square w-full bg-slate-100">
                            <img src="{{ $getPhotoSrc(1) }}" class="w-full h-full object-cover" alt="{{ $getPhotoTitle(1) }}">
                        </div>
                    </div>

                    {{-- Kolom 2 --}}
                    <div class="space-y-3 sm:space-y-4 md:space-y-5 pt-6 sm:pt-10 lg:pt-12">
                        <div class="rounded-3xl sm:rounded-4xl overflow-hidden shadow-xl aspect-square w-full bg-slate-100">
                            <img src="{{ $getPhotoSrc(2) }}" class="w-full h-full object-cover" alt="{{ $getPhotoTitle(2) }}">
                        </div>
                        <div class="rounded-3xl sm:rounded-4xl overflow-hidden shadow-xl aspect-3/4 w-full bg-slate-100">
                            <img src="{{ $getPhotoSrc(3) }}" class="w-full h-full object-cover" alt="{{ $getPhotoTitle(3) }}">
                        </div>
                    </div>

                    {{-- Kolom 3 --}}
                    <div class="self-center">
                        <div class="rounded-3xl sm:rounded-4xl overflow-hidden shadow-xl aspect-9/16 w-full bg-slate-100">
                            <img src="{{ $getPhotoSrc(4) }}" class="w-full h-full object-cover" alt="{{ $getPhotoTitle(4) }}">
                        </div>
                    </div>

                </div>

                <div
                    class="absolute -bottom-4 right-2 sm:right-4 bg-white/95 backdrop-blur p-3 sm:p-4 rounded-2xl shadow-2xl z-20 flex items-center space-x-3 sm:space-x-4 border border-sky-100">
                    <div
                        class="bg-sky-100 w-9 h-9 sm:w-10 sm:h-10 rounded-xl text-sky-600 text-base sm:text-lg flex items-center justify-center">
                        ⭐
                    </div>
                    <div>
                        <div class="text-2xl font-black text-sky-700 bg-sky-50/70 w-10 h-8 rounded-xl flex items-center justify-center">
                            {{ $averageRating > 0 ? $averageRating : '0.0' }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-1">
                                Rating Kepuasan
                            </span>
                            <span class="text-xs font-bold text-slate-800">
                                {{ $totalReviews }} Ulasan Mitra
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- FEATURE SECTION --}}
    <div class="px-4 md:px-12 lg:px-16 py-3">
        <div
            class="max-w-7xl mx-auto bg-stone-100/70 border border-stone-200 py-10 rounded-3xl relative z-30 shadow-sm">
            <section class="w-full px-6 md:px-12 flex flex-col lg:flex-row items-center gap-8 lg:gap-12 relative z-40">

                <div
                    class="w-full lg:w-1/4 shrink-0 border-b lg:border-b-0 lg:border-r border-stone-300 pb-4 lg:pb-0 lg:pr-6 text-center lg:text-left">
                    <span
                        class="text-[10px] font-black uppercase tracking-widest text-sky-700 bg-sky-700/10 px-2.5 py-1 rounded-md mb-2 inline-block">
                        TRAVEL BELITUNG BEGAYE
                    </span>
                    <h2 class="text-base md:text-lg font-black text-slate-950 leading-tight">
                        Apa yang Membuat Kami Menjadi Pilihan yang Tepat?
                    </h2>
                </div>

                <div class="w-full lg:w-3/4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-center">
                    <div
                        class="flex items-center gap-3 p-3 rounded-2xl bg-white/60 border border-transparent hover:border-sky-700/30 hover:bg-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md group cursor-pointer">
                        <div
                            class="w-10 h-10 rounded-xl bg-white text-sky-700 flex items-center justify-center shrink-0 group-hover:bg-sky-700 group-hover:text-white transition-all duration-300 shadow-sm border border-stone-200 group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-slate-900 group-hover:text-sky-700 transition-colors">
                                Secure Payment</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-tight">Transaksi otomatis & aman.</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-3 p-3 rounded-2xl bg-white/60 border border-transparent hover:border-sky-700/30 hover:bg-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md group cursor-pointer">
                        <div
                            class="w-10 h-10 rounded-xl bg-white text-sky-700 flex items-center justify-center shrink-0 group-hover:bg-sky-700 group-hover:text-white transition-all duration-300 shadow-sm border border-stone-200 group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-slate-900 group-hover:text-sky-700 transition-colors">
                                Rute Laskar Pelangi</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-tight">Destinasi wisata terkurasi
                                lengkap.</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-3 p-3 rounded-2xl bg-white/60 border border-transparent hover:border-sky-700/30 hover:bg-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md group cursor-pointer">
                        <div
                            class="w-10 h-10 rounded-xl bg-white text-sky-700 flex items-center justify-center shrink-0 group-hover:bg-sky-700 group-hover:text-white transition-all duration-300 shadow-sm border border-stone-200 group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-slate-900 group-hover:text-sky-700 transition-colors">
                                Atur Paket</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-tight">Kelola kuota pax mandiri.</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-3 p-3 rounded-2xl bg-white/60 border border-transparent hover:border-sky-700/30 hover:bg-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md group cursor-pointer">
                        <div
                            class="w-10 h-10 rounded-xl bg-white text-sky-700 flex items-center justify-center shrink-0 group-hover:bg-sky-700 group-hover:text-white transition-all duration-300 shadow-sm border border-stone-200 group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-slate-900 group-hover:text-sky-700 transition-colors">
                                Pemandu Lokal</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5 leading-tight">Mitra lokal berlisensi resmi.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- DESTINASI SECTION --}}
    <section class="px-6 md:px-12 lg:px-16 py-10 bg-white">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-12 gap-4">
                <div class="w-full md:w-1/2">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                        Destinasi <span
                            class="font-serif italic font-normal text-sky-700 ml-1 tracking-normal">Terpopuler</span>
                    </h2>
                </div>
                <div class="w-full md:w-1/2 md:text-right">
                    <p class="text-slate-500 text-[13px] sm:text-sm max-w-md md:ml-auto">
                        Pilihan terbaik untuk petualangan dan liburan tak terlupakan Anda di Belitung bersama Travel
                        Belitung Begaye.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-6 mb-12 w-full">

                @foreach(($daftarWisata ?? $packages)->take(4) as $item)
                    <div
                        class="relative rounded-4xl overflow-hidden aspect-4/5 shadow-lg group cursor-pointer bg-slate-100 w-full sm:w-[calc(50%-12px)] lg:w-[calc(25%-18px)] max-w-75 sm:max-w-none">

                        {{-- Image Background --}}
                        @if($item->image)
                            <img src="data:image/jpeg;base64,{{ base64_encode($item->image) }}"
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-out"
                                alt="{{ $item->title }}">
                        @else
                            <img src="https://via.placeholder.com/400x500?text=No+Image"
                                class="absolute inset-0 w-full h-full object-cover"
                                alt="No Image Available">
                        @endif

                        {{-- Gradient Overlay --}}
                        <div
                            class="absolute inset-0 bg-linear-to-t from-slate-950 via-slate-950/40 to-transparent opacity-90 group-hover:opacity-95 transition-opacity duration-300">
                        </div>

                        {{-- Content Container --}}
                        <div class="absolute bottom-0 inset-x-0 p-6 flex flex-col justify-end items-center text-center">

                            {{-- Judul Destinasi --}}
                            <h3
                                class="text-lg font-black text-white tracking-tight leading-tight group-hover:text-sky-400 transition-colors duration-300">
                                {{ $item->title }}
                            </h3>

                            {{-- Deskripsi --}}
                            <p class="text-slate-200/90 text-xs mt-2 line-clamp-2 leading-relaxed">
                                {{ $item->description ?? 'Jelajahi keindahan tersembunyi pulau laskar pelangi dengan pemandangan batuan granit yang ikonik.' }}
                            </p>

                            {{-- Badge Lokasi --}}
                            <div
                                class="mt-4 pt-3 border-t border-white/10 flex items-center justify-center gap-1.5 text-slate-300 text-xs font-semibold w-full">
                                <svg class="w-3.5 h-3.5 text-sky-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span
                                    class="truncate">{{ $item->lokasi ?? 'Belitung' }}</span>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>  

    {{-- PAKET WISATA --}}
    <section class="py-5 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">

            {{-- OUTER BOX WRAPPER --}}
            <div
                class="bg-sky-50  p-8 md:p-12 rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/60 relative">

                <div class="absolute -top-10 -right-10 w-40 h-40 bg-sky-200/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-sky-200/30 rounded-full blur-3xl"></div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 relative z-10">

                    {{-- CARD 1: HEADER (STATIS) --}}
                    <div
                        class="bg-slate-900 p-10 rounded-[2.5rem] flex flex-col justify-between shadow-xl transform hover:-rotate-2 transition-transform duration-500">
                        <div>
                            <div class="h-1 w-full bg-sky-500 mb-6 rounded-full"></div>
                            <h2 class="text-4xl font-black text-white leading-tight mb-6">
                                Paket <br> <span class="text-sky-500">Tour</span>
                            </h2>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Pilihan paket perjalanan Belitung yang terjangkau, fleksibel, dan tak terlupakan.
                            </p>
                        </div>
                        <div class="mt-12">
                            <a href="{{ route('paket.tour') }}"
                                class="group inline-flex items-center gap-3 text-white font-bold text-sm hover:text-sky-500 transition-colors">
                                Lihat Semua Paket
                                <span class="p-2 bg-white/10 rounded-full group-hover:bg-sky-500 group-hover:text-slate-900 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>

                    {{-- CARD 2-4: DYNAMIC DATA DARI DATABASE --}}
                    @foreach($packages as $index => $item)
                        <div class="group relative bg-white rounded-4xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-2 flex flex-col w-full h-97.5"
                            style="transition-delay: {{ $index * 100 }}ms;">

                            {{-- Image Container --}}
                            <div class="relative h-42.5 w-full overflow-hidden shrink-0">
                                @if($item->image)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($item->image) }}" 
                                        alt="{{ $item->title }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <img src="https://via.placeholder.com/400x300?text=No+Image" 
                                        alt="No Image Available"
                                        class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="p-5 bg-white border-t border-slate-50 h-55 flex flex-col justify-between">

                                <div>
                                    {{-- Kategori --}}
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <div class="w-2 h-0.5 bg-sky-600 rounded-full"></div>
                                        <span
                                            class="text-[9px] font-bold uppercase tracking-[0.2em] text-slate-400">Belitung
                                            Tour</span>
                                    </div>

                                    {{-- Judul --}}
                                    <h3
                                        class="text-base font-black text-slate-900 group-hover:text-sky-700 transition-colors leading-tight mb-1.5">
                                        {{ $item->title }}
                                    </h3>

                                    {{-- Deskripsi --}}
                                    <p class="text-slate-500 text-[11px] leading-relaxed line-clamp-2 mb-2">
                                        {{ $item->description }}
                                    </p>

                                    {{-- Teks Harga --}}
                                    <div class="flex flex-col gap-0.5">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Mulai
                                            dari:</span>
                                        <span
                                            class="text-slate-900 font-black text-sm group-hover:text-sky-700 transition-colors">
                                            Rp
                                            {{ number_format($item->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="border-t border-slate-100 pt-2.5 mt-2 mb-6 invisible opacity-0 pointer-events-none translate-y-1 transition-all duration-500 ease-in-out group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto">
                                    <a href="{{ route('booking.form', $item->id) }}"
                                        class="inline-flex items-center gap-1.5 text-[11px] font-bold text-sky-700 hover:text-sky-800">
                                        Pesan Sekarang
                                        <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    {{-- CSS ANIMASI --}}
    <style>
        <blade keyframes|%20fadeInUp%20%7B>from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
        }

        .group {
            animation: fadeInUp 0.8s ease backwards;
        }

    </style>

    {{-- news & ARTIKEL TERKINI --}}
    <section class="px-6 md:px-12 lg:px-16 py-10 bg-slate-50">
        <div class="max-w-7xl mx-auto">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-12 gap-4">
                <div class="w-full md:w-1/2">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-sky-700 block mb-2">Informasi &
                        Tips</span>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                        Artikel & <span class="font-serif italic font-normal text-sky-700 ml-1 tracking-normal">news
                            Terbaru</span>
                    </h2>
                </div>
                <div class="w-full md:w-1/2 md:text-right">
                    <p class="text-slate-500 text-[13px] sm:text-sm max-w-md md:ml-auto">
                        Temukan panduan wisata, tips perjalanan, dan cerita menarik seputar keindahan Pulau Belitung
                        langsung dari rangkuman kami.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap justify-center gap-8 mb-12 w-full">

                @foreach($posts as $index => $post)
                    <div class="group bg-white rounded-[1.8rem] overflow-hidden shadow-sm hover:shadow-md transition-all duration-500 hover:-translate-y-2 flex flex-col w-full sm:w-[calc(50%-16px)] lg:w-[calc(33.333%-22px)] max-w-77.5 sm:max-w-none border border-slate-100"
                        style="transition-delay: {{ $index * 100 }}ms;">

                        {{-- 1. Gambar Artikel --}}
                        <div class="relative h-41.25 w-full overflow-hidden shrink-0">
                            @if($post->image)
                                @php
                                    // Validasi otomatis: Cek apakah data sudah teks Base64 atau masih biner BLOB lama
                                    $isBase64 = base64_encode(base64_decode($post->image, true)) === $post->image;
                                    $displayImage = $isBase64 ? $post->image : base64_encode($post->image);
                                @endphp
                                <img src="data:image/jpeg;base64,{{ $displayImage }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @endif

                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-slate-900 text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full shadow-xs">
                                {{ $post->category ?? 'Tips Wisata' }}
                            </span>
                        </div>

                        <div class="p-5 flex flex-col justify-between grow">

                            <div>
                                {{-- 2. Tanggal Artikel --}}
                                <div class="flex items-center gap-1.5 mb-2">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-[10px] font-medium text-slate-400">
                                        {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d M Y') : $post->created_at->format('d M Y') }}
                                    </span>
                                </div>

                                {{-- 3. Judul Artikel (Ukuran teks diubah ke text-sm & font-extrabold) --}}
                                <h3
                                    class="text-sm font-extrabold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug line-clamp-2 mb-2">
                                    <a href="{{ route('news.show', $post->slug ?? $post->id) }}">{{ $post->title }}</a>
                                </h3>

                                {{-- 4. Deskripsi Pendek --}}
                                <p class="text-slate-500 text-[11px] leading-relaxed line-clamp-2 mb-4">
                                    {{ $post->content }}
                                </p>
                            </div>

                            {{-- 5. Baca Selengkapnya --}}
                            <div class="border-t border-slate-100 pt-3.5 mt-auto">
                                <a href="{{ route('news.show', $post->slug ?? $post->id) }}"
                                    class="inline-flex items-center gap-1.5 text-[11px] font-bold text-slate-900 group-hover:text-sky-700 transition-colors">
                                    Baca Selengkapnya
                                    <svg class="w-3.5 h-3.5 text-sky-600 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- Tombol Lihat Semua Artikel (Rata Tengah) --}}
            <div class="flex justify-center">
                <a href="{{ route('news.index') }}"
                    class="bg-slate-900 text-white px-7 py-3.5 rounded-full font-bold text-sm hover:bg-sky-800 transition duration-200 shadow-sm transform hover:-translate-y-0.5">
                    Lihat Semua Artikel
                </a>
            </div>

        </div>
    </section>

    {{-- TESTIMONI / CUSTOMER REVIEW --}}
    <section class="px-4 sm:px-6 md:px-12 lg:px-16 py-6 bg-white">
        <div class="max-w-5xl mx-auto bg-sky-50 rounded-4xl p-6 md:p-8 border border-slate-100/70 shadow-2xs">

            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-stretch">

                {{-- SISI KIRI --}}
                <div class="w-full lg:w-[38%] flex flex-col justify-between bg-white rounded-3xl p-6 md:p-8 shadow-xs border border-slate-100 lg:sticky lg:top-8">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-sky-700 block mb-3">
                            Cerita Perjalanan
                        </span>

                        <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                            Apa Kata <br>
                            <span class="font-serif italic font-normal text-sky-700 tracking-normal">Pelanggan Kami</span>
                        </h2>
                        <div class="w-12 h-1 bg-sky-600 rounded-full mb-5"></div>

                        <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                            Pengalaman nyata dan jujur dari mereka yang telah menjelajahi Belitung bersama Travel Belitung Begaye.
                        </p>
                    </div>

                    {{-- Badge Kepuasan --}}
                    <div class="mt-8 pt-6 border-t border-slate-50 flex items-center gap-3 w-fit">
                        <div class="text-2xl font-black text-sky-700 bg-sky-50/70 w-12 h-12 rounded-xl flex items-center justify-center">
                            {{ $averageRating > 0 ? $averageRating : '0.0' }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none mb-1">
                                Rating Kepuasan
                            </span>
                            <span class="text-xs font-bold text-slate-800">
                                {{ $totalReviews }} Wisatawan
                            </span>
                        </div>
                    </div>
                </div>

                {{-- SISI KANAN --}}
                <div class="w-full lg:w-[62%] flex flex-col gap-4">
                    @forelse($reviews as $index => $review)
                        <div class="group bg-white rounded-2xl p-5 shadow-xs hover:shadow-md transition-all duration-300 border border-slate-100 flex flex-col sm:flex-row gap-4 relative overflow-hidden">
                            
                            <span class="absolute right-4 top-1 text-5xl font-serif text-slate-100 group-hover:text-sky-50 transition-colors pointer-events-none select-none font-normal">“</span>

                            {{-- Profil Customer --}}
                            <div class="flex sm:flex-col items-center sm:items-start gap-2.5 shrink-0 sm:w-24">
                                <div class="w-8 h-8 rounded-xl bg-slate-900 text-white flex items-center justify-center text-[11px] font-black tracking-wider shadow-xs uppercase">
                                    {{ substr($review->user->name ?? 'U', 0, 2) }}
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-xs font-bold text-slate-900 truncate w-full sm:max-w-22.5">
                                        {{ $review->user->name ?? 'Pelanggan' }}
                                    </span>
                                    <span class="text-[9px] font-medium text-sky-700">Verified Buyer</span>
                                </div>
                            </div>

                            {{-- Isi Review --}}
                            <div class="flex flex-col justify-between grow">
                                <p class="text-slate-600 text-[11px] leading-relaxed">
                                    "{!! $review->comment !!}"
                                </p>

                                <div class="flex items-center gap-0.5 mt-2 pt-2 border-t border-slate-50">
                                    @for($i = 0; $i < ($review->rating ?? 5); $i++)
                                        <svg class="w-3 h-3 text-amber-400 fill-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="bg-white rounded-2xl p-8 text-center border border-slate-100 text-xs text-slate-400">
                            Belum ada ulasan dari pelanggan saat ini.
                        </div>
                    @endforelse
                    
                </div>

            </div>

        </div>
    </section>
@endsection