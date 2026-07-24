<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Travel Belitung Begaye - Solusi Perjalanan Wisata Anda')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=1">
    
    {{-- Google Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Midtrans Snap JS (Dinamis Sandbox/Production) --}}
    @php
        $isProduction = config('midtrans.is_production', false);
        $snapUrl = $isProduction 
            ? 'https://app.midtrans.com/snap/snap.js' 
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script type="text/javascript"
            src="{{ $snapUrl }}"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
        
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Third Party Icons & Alpine.js --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-animate {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen selection:bg-sky-500 selection:text-white">

    {{-- Navbar Partials --}}
    @include('partials.navbar')

    {{-- Main Content --}}
    <main class="grow page-animate">
        @yield('content')
    </main>

    {{-- Footer Partials --}}
    @include('partials.footer')

    {{-- TOAST NOTIFICATION: SUCCESS --}}
    @if(session('success'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2 md:translate-y-0 md:translate-x-4"
             x-transition:enter-end="opacity-100 transform translate-y-0 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="fixed top-6 right-6 z-50 flex items-center w-full max-w-xs p-4 text-slate-800 bg-white rounded-2xl border border-slate-100 shadow-xl shadow-sky-900/10"
             role="alert">
            
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-emerald-500 bg-emerald-50 rounded-xl">
                <i class="fas fa-check-circle text-sm"></i>
            </div>
            
            <div class="ml-3 text-xs font-black tracking-wide text-slate-800">
                {{ session('success') }}
            </div>
            
            <button type="button" 
                    @click="show = false" 
                    class="ml-auto -mx-1.5 -my-1.5 bg-white text-slate-400 hover:text-slate-900 rounded-lg p-1.5 hover:bg-slate-50 inline-flex items-center justify-center h-7 w-7 cursor-pointer transition-colors">
                <span class="sr-only">Close</span>
                <i class="fas fa-times text-[10px]"></i>
            </button>
        </div>
    @endif

    {{-- TOAST NOTIFICATION: ERROR --}}
    @if(session('error'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 5000)"
             x-show="show"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2 md:translate-y-0 md:translate-x-4"
             x-transition:enter-end="opacity-100 transform translate-y-0 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="fixed top-6 right-6 z-50 flex items-center w-full max-w-xs p-4 text-slate-800 bg-white rounded-2xl border border-slate-100 shadow-xl shadow-rose-900/10"
             role="alert">
            
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-rose-500 bg-rose-50 rounded-xl">
                <i class="fas fa-exclamation-circle text-sm"></i>
            </div>
            
            <div class="ml-3 text-xs font-black tracking-wide text-slate-800">
                {{ session('error') }}
            </div>
            
            <button type="button" 
                    @click="show = false" 
                    class="ml-auto -mx-1.5 -my-1.5 bg-white text-slate-400 hover:text-slate-900 rounded-lg p-1.5 hover:bg-slate-50 inline-flex items-center justify-center h-7 w-7 cursor-pointer transition-colors">
                <span class="sr-only">Close</span>
                <i class="fas fa-times text-[10px]"></i>
            </button>
        </div>
    @endif

    @stack('scripts')
</body>
</html>