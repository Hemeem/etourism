@extends('layouts.app')

@section('title', 'Daftar Paket Wisata - Travel Belitung Begaye')

@section('content')

    {{-- HERO SECTION --}}
    <section class="relative bg-slate-900 text-white py-16 md:py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-70 bg-[url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80')] bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-linear-to-b from-slate-900/60 to-slate-900"></div>
        <div class="relative max-w-4xl mx-auto text-center px-4">
            <span class="text-xs font-bold uppercase tracking-[0.2em] text-sky-400 block mb-2">Pilihan Terbaik Untuk Liburan Anda</span>
            <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">Paket Wisata Eksklusif Belitung</h1>
            <p class="text-slate-300 text-sm md:text-base mt-4 max-w-xl mx-auto leading-relaxed">
                Jelajahi keindahan pantai berpasir putih, gugusan batu granit Line-up eksotis, hingga napak tilas budaya Laskar Pelangi bersama pemandu lokal profesional.
            </p>

            {{-- KOTAK PENCARIAN (Utama & Selaras Dengan Halaman News) --}}
            <div class="max-w-md mx-auto mt-8">
                <form action="{{ route('paket.tour') }}" method="GET" class="relative group">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif

                    <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Cari nama paket wisata Belitung..." 
                           class="w-full text-xs text-slate-900 px-6 py-4 bg-white/95 backdrop-blur-md border border-slate-200 rounded-2xl focus:outline-hidden focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10 transition-all shadow-xl shadow-black/10 placeholder-slate-400 font-medium">
                    <button type="submit" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-sky-600 transition-colors">
                        <i class="fas fa-search text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- FILTER & GRID PAKET TOUR --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Kategori Filter Paket Tour (Menggunakan Perulangan Seperti Halaman News) --}}
        <div class="flex items-center justify-center gap-2.5 overflow-x-auto pb-4 mb-14 border-b border-slate-200/60 scrollbar-none">
            {{-- Tombol Semua Paket --}}
            <a href="{{ route('paket.tour', request()->only('search')) }}" 
               class="px-6 py-2.5 rounded-xl text-xs font-black transition-all tracking-wider whitespace-nowrap {{ !request('category') ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/20' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-400 hover:text-slate-900' }}">
                Semua Paket
            </a>
            
            {{-- Perulangan Kategori Paket Tour --}}
            @foreach(['Pantai', 'Budaya & Sejarah', 'Honeymoon'] as $cat)
                <a href="{{ route('paket.tour', array_merge(request()->only('search'), ['category' => $cat])) }}" 
                   class="px-6 py-2.5 rounded-xl text-xs font-black transition-all tracking-wider whitespace-nowrap {{ request('category') === $cat ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/20' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-400 hover:text-slate-900' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        @if(request('search'))
            <div class="text-center mb-12 text-xs text-slate-500 font-medium">
                Menampilkan hasil pencarian untuk: <strong class="text-slate-800">"{{ request('search') }}"</strong>
                <a href="{{ route('paket.tour', request()->except('search')) }}" class="text-rose-500 hover:underline ml-2 font-bold">
                    <i class="fas fa-times-circle"></i> Hapus Pencarian
                </a>
            </div>
        @endif

        {{-- GRID UTAMA PAKET --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @forelse($packages as $package)
                {{-- KARTU PAKET --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col group">
                    <div class="relative aspect-video w-full bg-slate-200 overflow-hidden">
                        
                        @if($package->image)
                            <img src="data:image/jpeg;base64,{{ base64_encode($package->image) }}" 
                                 alt="{{ $package->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                <i class="fas fa-map-marked-alt text-2xl"></i>
                            </div>
                        @endif
                        
                        @if(isset($package->badge) && $package->badge)
                            <span class="absolute top-3 left-3 {{ $package->badge == 'Romantic' ? 'bg-purple-600 text-white' : 'bg-sky-500 text-slate-950' }} font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-md shadow-xs">
                                {{ $package->badge }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 text-slate-400 text-[11px] font-medium mb-2">
                                <span class="flex items-center gap-1"><i class="far fa-clock"></i> {{ $package->duration ?? '3 Hari 2 Malam' }}</span>
                                <span class="flex items-center gap-1"><i class="far fa-user"></i> {{ $package->min_pax ?? 'Min. 2 Pax' }}</span>
                            </div>
                            <h2 class="text-base font-bold text-slate-900 tracking-tight line-clamp-1 group-hover:text-sky-600 transition-colors">
                                {{ $package->title }}
                            </h2>
                            <p class="text-slate-400 text-xs mt-1.5 line-clamp-2 leading-relaxed">
                                {{ $package->description }}
                            </p>
                        </div>
                        
                        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[9px] text-slate-400 block uppercase font-bold tracking-wider">Mulai Dari</span>
                                <span class="text-base font-extrabold text-slate-900">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}<span class="text-[10px] font-normal text-slate-400">/pax</span>
                                </span>
                            </div>
                            <a href="{{ route('paket.detail', $package->slug ?? $package->id) }}" 
                                class="bg-slate-100 hover:bg-sky-500 text-slate-800 hover:text-white text-xs font-bold px-4 py-2 rounded-xl transition-all cursor-pointer">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 bg-white border border-slate-200/60 rounded-3xl max-w-sm mx-auto shadow-xs my-8">
                    <div class="w-14 h-14 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                        <i class="fas fa-search text-lg"></i>
                    </div>
                    <h3 class="text-sm font-black text-slate-950">Paket Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-400 mt-1 px-6 leading-relaxed">Maaf, kami tidak dapat menemukan paket wisata yang cocok dengan kriteria Anda.</p>
                    <div class="pt-5">
                        <a href="{{ route('paket.tour') }}" class="inline-block bg-slate-950 text-white text-xs font-bold py-2.5 px-5 rounded-xl hover:bg-slate-800 transition-all shadow-md">Reset Pencarian</a>
                    </div>
                </div>
            @endforelse
        </div>
    </main>

@endsection