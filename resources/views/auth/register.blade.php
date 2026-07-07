<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Travel Belitung Begaye</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen w-screen bg-linear-to-tr from-sky-200 via-sky-100 to-indigo-100 flex font-sans antialiased m-0 p-0">

    <div class="w-full min-h-screen flex items-center justify-center p-4 md:p-6 bg-transparent">
        
        <div class="w-full max-w-4xl bg-white md:rounded-3xl shadow-2xl shadow-sky-950/20 flex overflow-hidden border border-sky-100">
            
            {{-- SIDEBAR KIRI --}}
            <div class="hidden md:flex md:w-1/2 bg-cover bg-center relative p-10 flex-col justify-between" 
                 style="background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.85)), url('https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1200');">
                
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-white no-underline group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain group-hover:scale-105 transition-transform">
                    <span class="font-black text-xs uppercase tracking-widest">Belitung Begaye</span>
                </a>

                <div class="space-y-3 backdrop-blur-md bg-white/10 p-5 rounded-2xl border border-white/10 shadow-xl">
                    <span class="text-[10px] font-black uppercase tracking-widest text-sky-400">Premium Travel Experience</span>
                    <h3 class="text-lg lg:text-xl font-black text-white leading-tight tracking-tight">Jelajahi Surga Granit & Pantai Eksotis Laskar Pelangi</h3>
                    <p class="text-[11px] text-slate-200 leading-relaxed font-medium">Dapatkan kemudahan akses pemesanan paket tour custom, armada eksklusif, dan panduan local guide terbaik.</p>
                </div>
            </div>

            {{-- KANAN: FORM REGISTRASI --}}
            <div class="w-full md:w-1/2 p-6 sm:p-10 md:p-8 lg:p-10 flex flex-col justify-center relative bg-white">
                
                <a href="{{ url('/') }}" class="absolute top-6 right-8 text-slate-400 hover:text-slate-600 transition-colors text-xs font-bold flex items-center gap-1">
                    <i class="fas fa-arrow-left text-[10px]"></i> Beranda
                </a>

                <div class="mb-5 mt-2">
                    <h2 class="text-xl font-black text-slate-950 tracking-tight">Buat Akun Wisatawan</h2>
                    <p class="text-xs text-slate-400 mt-1">Daftarkan diri Anda untuk memulai perjalanan premium.</p>
                </div>

                <form action="{{ route('register.store') }}" method="POST" class="space-y-3.5">
                    @csrf

                    {{-- INPUT NAMA LENGKAP --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-600 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"><i class="far fa-user"></i></span>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama sesuai kartu identitas"
                                class="w-full text-xs pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/5 transition-all">
                        </div>
                        @error('name') <span class="text-[10px] text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- INPUT EMAIL (WAJIB @gmail.com) --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-600 mb-1">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"><i class="far fa-envelope"></i></span>
                            <input type="text" name="email" value="{{ old('email') }}" required 
                                pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$"
                                title="Email harus menggunakan domain resmi @gmail.com"
                                placeholder="contoh@gmail.com"
                                class="w-full text-xs pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/5 transition-all">
                        </div>
                        @error('email') <span class="text-[10px] text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- INPUT NOMOR HANDPHONE (HANYA ANGKA) --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-wider text-slate-600 mb-1">Nomor Handphone</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"><i class="fas fa-mobile-alt"></i></span>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required 
                                pattern="[0-9]+" 
                                title="Nomor handphone hanya boleh berisi angka"
                                placeholder="Contoh: 0812345678"
                                class="w-full text-xs pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/5 transition-all">
                        </div>
                        {{-- Menambahkan penangkap error nomor HP di bawah ini --}}
                        @error('no_hp') <span class="text-[10px] text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- GRID PASSWORD & KONFIRMASI --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-600 mb-1">Password</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" required 
                                    pattern="(?=.*[A-Z])(?=.*[^A-Za-z0-9]).{6,}"
                                    title="Password minimal 6 karakter, harus mengandung minimal 1 huruf besar dan 1 karakter unik/simbol"
                                    placeholder="Kombinasi sandi"
                                    class="w-full text-xs pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/5 transition-all">
                            </div>
                            @error('password') <span class="text-[10px] text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        {{-- KONFIRMASI PASSWORD --}}
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-wider text-slate-600 mb-1">Konfirmasi</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"><i class="fas fa-shield-alt"></i></span>
                                <input type="password" name="password_confirmation" required placeholder="Ulangi sandi"
                                    class="w-full text-xs pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/5 transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="pt-1">
                        <button type="submit" class="w-full bg-slate-950 hover:bg-slate-900 text-white font-black text-xs py-3 px-4 rounded-xl shadow-lg transition-all tracking-wide cursor-pointer">
                            Daftar Sekarang <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                        </button>
                    </div>
                </form>

                <div class="text-center mt-5 pt-3 border-t border-slate-100 text-xs text-slate-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-sky-600 font-bold hover:underline">Masuk di sini</a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>