<nav x-data="{ openLogoutModal: false, openMobileMenu: false }"
    class="flex justify-between items-center px-6 md:px-12 py-4 sticky top-0 bg-white/50 backdrop-blur-md z-50 shadow-md border-b border-sky-100">
    
    {{-- BRAND LOGO & TEXT --}}
    <div class="text-xl sm:text-2xl md:text-3xl font-black text-slate-900 tracking-tight shrink-0 flex items-center gap-2.5">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Belitung Begaye" class="h-10 sm:h-11 md:h-12 w-auto object-contain">
        <span class="hidden sm:inline">
            Belitung<span class="text-sky-700">Begaye</span>
        </span>
    </div>

    {{-- NAVIGATION MENU (DESKTOP) --}}
    <div class="hidden md:flex items-center gap-6">
        <a href="{{ url('/') }}"
            class="text-sm font-medium transition-colors duration-200 {{ request()->is('/') ? 'text-sky-600 font-semibold' : 'text-slate-600 hover:text-sky-600' }}">
            Beranda
        </a>
        <a href="{{ route('paket.tour') }}"
            class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('paket.tour') ? 'text-sky-600 font-semibold' : 'text-slate-600 hover:text-sky-600' }}">
            Paket Tour
        </a>
        <a href="{{ route('news.index') }}"
            class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('news.index') ? 'text-sky-600 font-semibold' : 'text-slate-600 hover:text-sky-600' }}">
            Blog
        </a>
        <a href="{{ route('gallery.index') }}"
            class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('gallery.index') ? 'text-sky-600 font-semibold' : 'text-slate-600 hover:text-sky-600' }}">
            Gallery
        </a>
    </div>

    {{-- AUTHENTICATION MENU (DESKTOP) --}}
    <div class="hidden md:flex items-center space-x-4">
        @auth
            <div class="flex items-center gap-3">
                <a href="{{ route('profile') }}" title="Lihat Profil & Riwayat"
                    class="flex items-center gap-2 px-3 py-1.5 border rounded-xl transition-all duration-200 text-xs shadow-xs
                    {{ request()->routeIs('profile') 
                        ? 'bg-sky-600 text-white border-sky-600 font-black' 
                        : 'bg-sky-50/50 text-sky-700 border-sky-100 hover:bg-sky-600 hover:text-white hover:border-sky-600 font-bold' }}">
                    <i class="far fa-user-circle text-sm"></i>
                    <span>{{ Auth::user()->name }}</span>
                </a>

                <button type="button" @click="openLogoutModal = true" title="Keluar dari Akun"
                    class="w-8 h-8 flex items-center justify-center text-red-500 hover:text-white border border-red-100 hover:border-red-500 bg-red-50/50 hover:bg-red-500 rounded-xl transition-all duration-200 cursor-pointer shadow-xs">
                    <i class="fas fa-sign-out-alt text-xs"></i>
                </button>
            </div>
        @else
            <a href="{{ route('login') }}"
                class="text-xs font-black uppercase tracking-wider text-slate-600 hover:text-sky-600 transition-colors">
                Masuk
            </a>
            <a href="{{ route('register') }}"
                class="bg-linear-to-b from-slate-900 to-slate-950 text-white font-black text-[11px] uppercase tracking-wider py-2.5 px-5 rounded-xl hover:from-slate-800 hover:to-slate-900 transition-all shadow-md">
                Daftar
            </a>
        @endauth
    </div>

    {{-- TOMBOL HAMBURGER MOBILE (HIDDEN DI DESKTOP - FLEX DI MOBILE) --}}
    <div class="items-center" style="display: var(--hamburger-display, none);">
        <style>
            /* Jika layar di bawah 768px (Mobile), tampilkan flex. Jika di atas, biarkan none */
            @media (max-width: 767px) {
                div[style*="--hamburger-display"] { --hamburger-display: flex !important; }
            }
        </style>
        <button @click="openMobileMenu = true" type="button" 
            class="text-slate-700 hover:text-sky-600 focus:outline-none p-2 rounded-xl bg-slate-50 border border-slate-200/80 cursor-pointer transition-colors">
            <i class="fas fa-bars text-sm w-4 text-center"></i>
        </button>
    </div>

    {{-- SIDEBAR DRAWER MOBILE INTERAKTIF --}}
    <div x-show="openMobileMenu" class="fixed inset-0 z-100 md:hidden" style="display: none;">
        
        {{-- BACKDROP OVERLAY --}}
        <div x-show="openMobileMenu"
             x-transition:enter="transition ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="openMobileMenu = false"
             class="fixed inset-0 bg-slate-950/40 backdrop-blur-xs"></div>

        {{-- LACI DRAWER (SLIDE OUT DARI KANAN) --}}
        <div x-show="openMobileMenu"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed top-0 right-0 bottom-0 w-full max-w-xs bg-white h-screen shadow-2xl p-6 flex flex-col justify-between overflow-y-auto border-l border-slate-100">
            
            <div>
                {{-- HEADER DRAWER --}}
                <div class="flex items-center justify-between pb-5 border-b border-slate-100 mb-5">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto object-contain">
                        <span class="font-black text-base text-slate-900 tracking-tight">Belitung<span class="text-sky-700">Begaye</span></span>
                    </div>
                    <button @click="openMobileMenu = false" type="button" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg bg-slate-50 border border-slate-100 cursor-pointer">
                        <i class="fas fa-times text-xs w-3.5 text-center"></i>
                    </button>
                </div>

                {{-- NAV LINK VERTIKAL (Menggunakan Blade Directive @class) --}}
                <div class="flex flex-col gap-1.5">
                    <a href="{{ url('/') }}" @class(['block text-sm font-semibold p-3 rounded-xl transition-colors', 'bg-sky-50 text-sky-700' => request()->is('/') || request()->is('home'), 'text-slate-700 hover:bg-slate-50' => !(request()->is('/') || request()->is('home'))])>
                        <i class="fas fa-home w-5 text-center opacity-70 mr-1.5"></i> Beranda
                    </a>
                    <a href="{{ route('paket.tour') }}" @class(['block text-sm font-semibold p-3 rounded-xl transition-colors', 'bg-sky-50 text-sky-700' => request()->routeIs('*paket.tour*'), 'text-slate-700 hover:bg-slate-50' => !request()->routeIs('*paket.tour*')])>
                        <i class="fas fa-map-marked-alt w-5 text-center opacity-70 mr-1.5"></i> Paket Tour
                    </a>
                    <a href="{{ route('news.index') }}" @class(['block text-sm font-semibold p-3 rounded-xl transition-colors', 'bg-sky-50 text-sky-700' => request()->routeIs('*news*'), 'text-slate-700 hover:bg-slate-50' => !request()->routeIs('*news*')])>
                        <i class="fas fa-newspaper w-5 text-center opacity-70 mr-1.5"></i> Blog
                    </a>
                    <a href="{{ route('gallery.index') }}" @class(['block text-sm font-semibold p-3 rounded-xl transition-colors', 'bg-sky-50 text-sky-700' => request()->routeIs('*gallery*'), 'text-slate-700 hover:bg-slate-50' => !request()->routeIs('*gallery*')])>
                        <i class="fas fa-images w-5 text-center opacity-70 mr-1.5"></i> Gallery
                    </a>
                </div>
            </div>

            {{-- FOOTER DRAWER AUTHENTICATION --}}
            <div class="border-t border-slate-100 pt-5 mt-auto">
                @auth
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200/60 rounded-xl">
                            <i class="far fa-user-circle text-2xl text-sky-600"></i>
                            <div class="flex flex-col min-w-0">
                                <span class="text-xs font-black text-slate-900 truncate">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] font-medium text-slate-400 truncate">Wisatawan Aktif</span>
                            </div>
                        </div>
                        <a href="{{ route('profile') }}" class="flex items-center justify-center gap-2 text-xs font-bold text-sky-700 bg-sky-50 hover:bg-sky-100 py-3 rounded-xl transition-colors">
                            <i class="fas fa-user-cog"></i> Kelola Profil & Riwayat
                        </a>
                        <button type="button" @click="openMobileMenu = false; openLogoutModal = true" class="w-full text-center text-xs font-black uppercase tracking-wider text-red-600 py-3 border border-red-200 bg-red-50/20 hover:bg-red-50 rounded-xl transition-colors cursor-pointer">
                            <i class="fas fa-sign-out-alt mr-1.5"></i> Keluar Akun
                        </button>
                    </div>
                @else
                    <div class="flex flex-col gap-2.5">
                        <a href="{{ route('login') }}" class="block text-center text-xs font-black uppercase tracking-wider text-slate-700 py-3.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="block text-center bg-linear-to-b from-slate-900 to-slate-950 text-white font-black text-[11px] uppercase tracking-wider py-3.5 rounded-xl shadow-md hover:from-slate-800 hover:to-slate-900 transition-all">
                            Daftar Akun Baru
                        </a>
                    </div>
                @endauth
            </div>

        </div>
    </div>

    {{-- CONFIRMATION LOGOUT MODAL --}}
    <div x-show="openLogoutModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 w-screen h-screen z-100 flex items-center justify-center bg-slate-950/50 backdrop-blur-xs p-4"
         style="display: none;">
        
        <div @click.outside="openLogoutModal = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl text-center border border-slate-100 my-auto">
            
            <div class="mx-auto w-12 h-12 bg-red-50 text-red-500 rounded-full flex items-center justify-center mb-4 border border-red-100">
                <i class="fas fa-exclamation-triangle text-lg"></i>
            </div>
            
            <h3 class="text-base font-black text-slate-900 tracking-tight">Konfirmasi Keluar</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Apakah Anda yakin ingin keluar dari akun pariwisata <span class="font-semibold text-slate-700">Belitung Begaye</span>?</p>
            
            <div class="flex gap-3 mt-5">
                <button type="button" @click="openLogoutModal = false"
                        class="flex-1 py-2.5 border border-slate-200 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-50 transition-all cursor-pointer">
                    Kembali
                </button>
                
                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-black text-xs rounded-xl transition-all shadow-md shadow-red-600/10 cursor-pointer">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>