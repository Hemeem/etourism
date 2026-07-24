<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun - Travel Belitung Begaye</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen w-screen bg-linear-to-tr from-sky-200 via-sky-100 to-indigo-100 flex font-sans antialiased m-0 p-0">

    <div class="w-full min-h-screen flex items-center justify-center p-4 md:p-6 lg:p-8 bg-transparent">
        
        <div class="w-full max-w-5xl bg-white md:rounded-3xl shadow-2xl shadow-sky-950/20 flex overflow-hidden border border-sky-100">
            
            {{-- SIDEBAR HERO/BANNER --}}
            <div class="hidden md:flex md:w-1/2 bg-cover bg-center relative p-12 flex-col justify-between" 
                 style="background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.85)), url('https://images.unsplash.com/photo-1506929562872-bb421503ef21?q=80&w=1200');">
                
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-white no-underline group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain group-hover:scale-105 transition-transform">
                    <span class="font-black text-xs uppercase tracking-widest">Belitung Begaye</span>
                </a>

                <div class="space-y-3 backdrop-blur-md bg-white/10 p-6 rounded-2xl border border-white/10 shadow-xl">
                    <span class="text-[10px] font-black uppercase tracking-widest text-sky-400">Exclusive Travel Services</span>
                    <h3 class="text-xl lg:text-2xl font-black text-white leading-tight tracking-tight">Kembali Rencanakan Liburan Impian Anda</h3>
                    <p class="text-[11px] text-slate-200 leading-relaxed font-medium">Masuk untuk melihat riwayat reservasi paket wisata, tiket destinasi harian, dan promo loyalitas khusus Anda.</p>
                </div>
            </div>

            {{-- FORM SECTION --}}
            <div class="w-full md:w-1/2 p-8 sm:p-12 md:p-10 lg:p-12 flex flex-col justify-center relative bg-white">
                
                <a href="{{ url('/') }}" class="absolute top-6 right-8 text-slate-400 hover:text-slate-600 transition-colors text-xs font-bold flex items-center gap-1">
                    <i class="fas fa-arrow-left text-[10px]"></i> Beranda
                </a>

                <div class="mb-6 mt-4">
                    <h2 class="text-2xl font-black text-slate-950 tracking-tight">Selamat Datang</h2>
                    <p class="text-xs text-slate-400 mt-1">Silakan Masuk Menggunakan Akun Anda.</p>
                </div>

                {{-- NOTIFIKASI SUKSES --}}
                @if (session('success'))
                    <div class="mb-5 p-4 text-xs text-green-700 bg-green-50 border border-green-200 rounded-xl flex items-start gap-2.5 shadow-sm">
                        <i class="fas fa-check-circle mt-0.5 text-green-500 text-sm"></i>
                        <div class="font-medium leading-relaxed">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                {{-- NOTIFIKASI ERROR GLOBAL --}}
                @if ($errors->any())
                    <div class="mb-5 p-4 text-xs text-red-700 bg-red-50 border border-red-200 rounded-xl flex items-start gap-2.5 shadow-sm">
                        <i class="fas fa-exclamation-circle mt-0.5 text-red-500 text-sm"></i>
                        <div class="font-medium leading-relaxed">
                            Email atau password yang Anda masukkan salah.
                        </div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- INPUT EMAIL --}}
                    <div>
                        <label for="email" class="block text-[10px] font-black uppercase tracking-wider text-slate-600 mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"><i class="far fa-envelope"></i></span>
                            <input type="email" 
                                   id="email"
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="username"
                                   placeholder="contoh@email.com"
                                   class="w-full text-xs pl-11 pr-4 py-3.5 bg-slate-50 border {{ $errors->has('email') ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-sky-500' }} rounded-xl focus:outline-none focus:bg-white focus:ring-4 focus:ring-sky-500/5 transition-all">
                        </div>
                    </div>

                    {{-- INPUT PASSWORD --}}
                    <div x-data="{ showPassword: false }">
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-[10px] font-black uppercase tracking-wider text-slate-600">Password</label>
                            
                            {{-- LINK LUPA PASSWORD (OPTIONAL) --}}
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[10px] text-sky-600 font-bold hover:underline">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                                <i class="fas fa-lock"></i>
                            </span>
                            
                            <input :type="showPassword ? 'text' : 'password'" 
                                   id="password"
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="w-full text-xs pl-11 pr-11 py-3.5 bg-slate-50 border {{ $errors->has('email') ? 'border-red-400 focus:border-red-500' : 'border-slate-200 focus:border-sky-500' }} rounded-xl focus:outline-none focus:bg-white focus:ring-4 focus:ring-sky-500/5 transition-all">
                            
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer focus:outline-none">
                                <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    {{-- REMEMBER ME CHECKBOX --}}
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500/20 cursor-pointer">
                            <span class="text-xs text-slate-500 font-medium group-hover:text-slate-700 transition-colors">Ingat Saya di Perangkat Ini</span>
                        </label>
                    </div>

                    {{-- TOMBOL SUBMIT --}}
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-slate-950 hover:bg-slate-900 text-white font-black text-xs py-3.5 px-4 rounded-xl shadow-lg transition-all tracking-wide cursor-pointer">
                            Masuk Ke Akun <i class="fas fa-sign-in-alt ml-1 text-[10px]"></i>
                        </button>
                    </div>
                </form>

                <div class="text-center mt-8 pt-5 border-t border-slate-100 text-xs text-slate-500">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-sky-600 font-bold hover:underline">Daftar perjalanan baru</a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>