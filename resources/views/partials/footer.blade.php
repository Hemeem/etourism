<footer class="relative z-10 bg-slate-900 text-slate-400 font-sans mt-32">
    {{-- Ambient Glow --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none rounded-t-4xl">
        <div class="absolute top-0 left-1/4 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-10 w-64 h-64 bg-slate-800/50 rounded-full blur-3xl"></div>
    </div>

    {{-- FLOATING CARD --}}
    <div class="absolute top-0 left-0 right-0 transform -translate-y-1/2 z-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 md:px-8">
            <div class="bg-linear-to-r from-sky-600 to-sky-700 rounded-2xl p-5 md:py-8 md:px-10 shadow-2xl border border-sky-500/30 flex flex-col md:flex-row items-center justify-between gap-4 transition-all duration-300 hover:shadow-sky-600/10">
                <div class="text-center md:text-left">
                    <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-sky-100 block">Rencanakan Liburan Anda</span>
                    <h3 class="text-lg md:text-xl font-black text-white tracking-tight">Siap Menjelajahi Keindahan Belitung?</h3>
                </div>
                <a href="https://wa.me/6281326831796" target="_blank" rel="noopener noreferrer" class="shrink-0 bg-white text-slate-950 font-bold text-[11px] px-5 py-2.5 rounded-lg shadow-md hover:bg-sky-950 hover:text-white transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2 group">
                    <svg class="w-3.5 h-3.5 fill-currentColor text-sky-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.713-1.457L0 24zm6.59-4.846c1.666.988 3.301 1.492 5.361 1.493 5.433 0 9.853-4.386 9.856-9.774.002-2.609-1.014-5.059-2.865-6.915C17.086 2.103 14.643 1.08 12.011 1.08c-5.439 0-9.859 4.388-9.862 9.777-.001 2.087.547 4.129 1.585 5.922l-.993 3.626 3.716-.951zm10.173-6.85c-.297-.15-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    </svg>
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </div>

    {{-- MAIN LAYER --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 md:px-12 lg:px-16 pb-8 pt-20 md:pt-24 relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 pb-8 border-b border-slate-800">
            {{-- KOLOM 1: BRANDING & SOSMED --}}
            <div class="lg:col-span-4 flex flex-col gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-xl font-black text-white tracking-tight">
                        Belitung<span class="text-sky-400 font-serif italic font-normal">Begaye</span>
                    </span>
                </div>
                <p class="text-slate-400 text-xs leading-relaxed max-w-xs">
                    Situs resmi agen pariwisata Travel Belitung Begaye. Menyajikan pilihan destinasi terbaik, akomodasi prima, dan pengalaman liburan yang terencana.
                </p>
                <div class="flex items-center gap-2 mt-1">
                    <a href="#" aria-label="Instagram" class="w-7 h-7 rounded-lg bg-slate-800/60 border border-slate-700/50 flex items-center justify-center text-slate-400 hover:text-white hover:border-sky-500 hover:bg-sky-500 transition-all duration-200">
                        <i class="fab fa-instagram text-xs"></i>
                    </a>
                    <a href="#" aria-label="Facebook" class="w-7 h-7 rounded-lg bg-slate-800/60 border border-slate-700/50 flex items-center justify-center text-slate-400 hover:text-white hover:border-sky-500 hover:bg-sky-500 transition-all duration-200">
                        <i class="fab fa-facebook-f text-xs"></i>
                    </a>
                    <a href="#" aria-label="WhatsApp" class="w-7 h-7 rounded-lg bg-slate-800/60 border border-slate-700/50 flex items-center justify-center text-slate-400 hover:text-white hover:border-sky-500 hover:bg-sky-500 transition-all duration-200">
                        <i class="fab fa-whatsapp text-xs"></i>
                    </a>
                </div>
            </div>

            {{-- KOLOM 2: NAVIGATION TAUTAN 1 
            <div class="lg:col-span-2 lg:col-start-6 flex flex-col gap-3">
                <span class="text-[11px] font-bold text-white uppercase tracking-[0.15em] block relative w-fit">
                    Destinasi
                    <span class="absolute -bottom-0.5 left-0 w-3 h-0.5 bg-sky-500 rounded-full"></span>
                </span>
                <ul class="flex flex-col gap-2 text-xs">
                    <li><a href="#" class="hover:text-sky-400 hover:translate-x-1 transition-all duration-200 block">Paket Hopping Island</a></li>
                    <li><a href="#" class="hover:text-sky-400 hover:translate-x-1 transition-all duration-200 block">Wisata Laskar Pelangi</a></li>
                    <li><a href="#" class="hover:text-sky-400 hover:translate-x-1 transition-all duration-200 block">Rental Mobil Mewah</a></li>
                    <li><a href="#" class="hover:text-sky-400 hover:translate-x-1 transition-all duration-200 block">Custom Itinerary</a></li>
                </ul>
            </div>--}}

            {{-- KOLOM 3: NAVIGATION TAUTAN 2 
            <div class="lg:col-span-2 flex flex-col gap-3">
                <span class="text-[11px] font-bold text-white uppercase tracking-[0.15em] block relative w-fit">
                    Perusahaan
                    <span class="absolute -bottom-0.5 left-0 w-3 h-0.5 bg-sky-500 rounded-full"></span>
                </span>
                <ul class="flex flex-col gap-2 text-xs">
                    <li><a href="#" class="hover:text-sky-400 hover:translate-x-1 transition-all duration-200 block">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-sky-400 hover:translate-x-1 transition-all duration-200 block">Cerita Artikel</a></li>
                    <li><a href="#" class="hover:text-sky-400 hover:translate-x-1 transition-all duration-200 block">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-sky-400 hover:translate-x-1 transition-all duration-200 block">Hubungi Kami</a></li>
                </ul>
            </div>--}}

            {{-- KOLOM 4: INFORMASI KONTAK --}}
            <div class="lg:col-span-4 flex flex-col gap-3">
                <span class="text-[11px] font-bold text-white uppercase tracking-[0.15em] block relative w-fit">
                    Head Office
                    <span class="absolute -bottom-0.5 left-0 w-3 h-0.5 bg-sky-500 rounded-full"></span>
                </span>
                <ul class="flex flex-col gap-2.5 text-xs text-slate-400">
                    <li class="flex items-start gap-2">
                        <div class="w-4 h-4 rounded bg-slate-800 border border-slate-700/40 flex items-center justify-center shrink-0 text-sky-400 mt-0.5 shadow-xs">
                            <i class="fas fa-map-marker-alt text-[9px]"></i>
                        </div>
                        <span class="leading-relaxed">Jl. Kemuning No. 12, Tanjung Pandan, Belitung</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded bg-slate-800 border border-slate-700/40 flex items-center justify-center shrink-0 text-sky-400 shadow-xs">
                            <i class="fas fa-phone-alt text-[9px]"></i>
                        </div>
                        <span>+62 812-3456-7890</span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- BOTTOM LAYER --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-5 text-[10px] font-medium text-slate-500">
            <div class="text-center sm:text-left">
                &copy; {{ date('Y') }} Travel Belitung Begaye. All rights reserved.
            </div>
            
            <div class="flex items-center gap-2 opacity-50 hover:opacity-100 transition-opacity duration-300">
                <span class="px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700/40 text-slate-300 shadow-2xs">IDR</span>
                <span class="px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700/40 text-slate-300 font-black italic shadow-2xs">VISA</span>
                <span class="px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700/40 text-slate-300 font-bold shadow-2xs">Midtrans</span>
            </div>
        </div>

    </div>
</footer>