<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Travel Belitung Begaye</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body x-data="{ openAdminLogout: false }" class="bg-slate-50 font-sans text-slate-800 antialiased">

    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col fixed inset-y-0 left-0 z-20 shadow-xl">
            <div class="p-6 border-b border-slate-800 flex items-center gap-3">
                <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center text-white font-black shadow-md">
                    {{ substr(auth()->user()->name ?? 'B', 0, 1) }}
                </div>
                <div>
                    <h1 class="text-sm font-black text-white tracking-wider uppercase">Belitung Begaye</h1>
                    <span class="text-[10px] text-sky-400 font-bold tracking-widest uppercase block">Admin Panel</span>
                </div>
            </div>
            
            <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="fas fa-chart-pie text-sm text-slate-400"></i> Dashboard
                </a>
                <div class="h-px bg-slate-800 my-4"></div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4 block mb-2">Manajemen Konten</span>
                
                {{-- NAVIGASI DINAMIS: PAKET WISATA --}}
                <a href="{{ route('admin.packages.index') }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all 
                   {{ request()->routeIs('admin.packages.*') ? 'bg-sky-600 text-white shadow-lg shadow-sky-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span class="flex items-center gap-3"><i class="fas fa-cubes text-sm"></i> Paket Wisata</span>
                    <span class="{{ request()->routeIs('admin.packages.*') ? 'bg-sky-700 text-sky-100' : 'bg-slate-800 text-slate-400' }} text-[10px] px-2 py-0.5 rounded-full font-bold">
                        {{ $totalPackages ?? 0 }}
                    </span>
                </a>

                {{-- NAVIGASI DINAMIS: BERITA & BLOG --}}
                <a href="{{ route('admin.news.index') }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all 
                   {{ request()->routeIs('admin.news.*') ? 'bg-sky-600 text-white shadow-lg shadow-sky-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span class="flex items-center gap-3"><i class="fas fa-newspaper text-sm"></i> Berita & Blog</span>
                    <span class="{{ request()->routeIs('admin.news.*') ? 'bg-sky-700 text-sky-100' : 'bg-slate-800 text-slate-400' }} text-[10px] px-2 py-0.5 rounded-full font-bold">
                        {{ $totalNews ?? 0 }}
                    </span>
                </a>

                {{-- NAVIGASI DINAMIS: GALERI FOTO --}}
                <a href="{{ route('admin.galleries.index') }}" 
                class="flex items-center justify-between px-4 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all 
                {{ request()->routeIs('admin.galleries.*') ? 'bg-sky-600 text-white shadow-lg shadow-sky-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span class="flex items-center gap-3"><i class="fas fa-images text-sm"></i> Galeri Foto</span>
                    <span class="{{ request()->routeIs('admin.galleries.*') ? 'bg-sky-700 text-sky-100' : 'bg-slate-800 text-slate-400' }} text-[10px] px-2 py-0.5 rounded-full font-bold">
                        {{ $totalGalleries ?? 0 }}
                    </span>
                </a>

                {{-- NAVIGASI DINAMIS: ULASAN / REVIEW --}}
                <a href="{{ route('admin.reviews.index') }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-all 
                   {{ request()->routeIs('admin.reviews.*') ? 'bg-sky-600 text-white shadow-lg shadow-sky-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span class="flex items-center gap-3"><i class="fas fa-star text-sm"></i> Ulasan / Review</span>
                    <span class="{{ request()->routeIs('admin.reviews.*') ? 'bg-sky-700 text-amber-300' : 'bg-amber-500/10 text-amber-500' }} text-[10px] px-2 py-0.5 rounded-full font-bold">
                        {{ $avgRating ?? '0.0' }}
                    </span>
                </a>
            </nav>

            {{-- TOMBOL PEMICU MODAL LOGOUT ADMIN --}}
            <div class="p-4 border-t border-slate-800">
                <button type="button" @click="openAdminLogout = true" class="w-full bg-slate-800 hover:bg-rose-950/40 hover:text-rose-400 border border-slate-700/50 text-xs font-black uppercase tracking-wider py-3.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2.5 cursor-pointer">
                    <i class="fas fa-sign-out-alt"></i> Keluar Sistem
                </button>
            </div>
        </aside>

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="flex-1 pl-64 flex flex-col min-h-screen">
            {{-- TOPBAR --}}
            <header id="topbar" class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-10">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest">
                    <span>Sistem Informasi Pariwisata</span>
                    <i class="fas fa-chevron-right text-[9px] text-slate-300"></i>
                    <span class="text-slate-800 font-black">@yield('page_title', 'Dashboard')</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <span class="text-xs font-black text-slate-900 block">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <span class="text-[10px] text-emerald-500 font-bold uppercase tracking-wider flex items-center justify-end gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Online</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-700 font-black shadow-inner shadow-slate-200/50">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </header>

            {{-- CONTENT INJECTION --}}
            <main class="p-8 flex-1">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex items-center gap-2 shadow-sm shadow-emerald-900/5">
                        <i class="fas fa-check-circle text-sm text-emerald-500"></i> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- STRUCTURE MODAL POP-UP LOGOUT ADMIN --}}
    <div x-show="openAdminLogout" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 w-screen h-screen z-100 flex items-center justify-center bg-slate-950/60 backdrop-blur-xs p-4"
         style="display: none;">
        
        <div @click.outside="openAdminLogout = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl text-center border border-slate-100">
            
            <div class="mx-auto w-12 h-12 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mb-4 border border-rose-100">
                <i class="fas fa-shield-alt text-lg"></i>
            </div>
            
            <h3 class="text-base font-black text-slate-900 tracking-tight">Konfirmasi Keluar Admin</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Apakah Anda yakin ingin mengakhiri sesi pengerjaan dan keluar dari panel admin <span class="font-bold text-slate-700">Belitung Begaye</span>?</p>
            
            <div class="flex gap-3 mt-5">
                <button type="button" @click="openAdminLogout = false"
                        class="flex-1 py-2.5 border border-slate-200 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-50 transition-all cursor-pointer">
                    Batal
                </button>
                
                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-black text-xs rounded-xl transition-all shadow-md shadow-rose-600/10 cursor-pointer">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>