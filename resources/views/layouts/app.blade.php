<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Travel Belitung Begaye')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=1">
    
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
        
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
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
            animation: fadeInUp 1s ease-out forwards;
        }
    </style>
</head>
<body class="bg-slate-50 antialiased flex flex-col min-h-screen">

    @include('partials.navbar')

    <main class="grow page-animate">
        @yield('content')
    </main>

    @include('partials.footer')

    @if(session('success'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2 md:translate-y-0 md:translate-x-4"
             x-transition:enter-end="opacity-100 transform translate-y-0 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="fixed top-6 right-6 z-50 flex items-center w-full max-w-xs p-4 text-slate-800 bg-white rounded-2xl border border-slate-100 shadow-xl shadow-sky-900/5"
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

</body>
</html>