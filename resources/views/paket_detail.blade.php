@extends('layouts.app')

@section('title', $package->title . ' - Travel Belitung Begaye')

@section('content')

    {{-- HERO BANNER UTAMA DINAMIS --}}
    <section class="relative h-[50vh] md:h-[60vh] bg-blue-950 text-white overflow-hidden">
        @if($package->image)
            @php
                $bannerImage = is_resource($package->image) ? stream_get_contents($package->image) : $package->image;
            @endphp
            <img src="data:image/jpeg;base64,{{ base64_encode($bannerImage) }}" 
                 alt="{{ $package->title }}" 
                 class="absolute inset-0 w-full h-full object-cover opacity-50">
        @else
            <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80" 
                 alt="{{ $package->title }}" 
                 class="absolute inset-0 w-full h-full object-cover opacity-40">
        @endif

        <div class="absolute inset-0 bg-linear-to-t from-blue-950 via-blue-900/40 to-transparent"></div>
        
        <div class="absolute bottom-0 inset-x-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight max-w-4xl text-white">
                {{ $package->title }}
            </h1>
            <div class="flex flex-wrap gap-6 items-center text-blue-100 text-xs md:text-sm mt-4 font-medium">
                <span class="flex items-center gap-2 text-sky-400"><i class="far fa-clock"></i> {{ $package->duration ?? '3 Hari 2 Malam' }}</span>
                <span class="flex items-center gap-2"><i class="far fa-user"></i> Min. {{ $package->min_pax ?? '2' }} Pax</span>
                <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt"></i> Belitung, Indonesia</span>
            </div>
        </div>
    </section>

    <main class="min-h-screen bg-slate-50/70 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative">
        {{-- Ornamen Latar Belakang Estetik --}}
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-sky-200/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/3 right-10 w-96 h-96 bg-blue-200/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start relative z-10">
            
            {{-- KOLOM KIRI: DETAIL INFORMASI --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- 1. KARTU DESKRIPSI PAKET --}}
                <section class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200/60 shadow-md shadow-slate-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-linear-to-tr from-blue-600 to-sky-400 text-white flex items-center justify-center shadow-md shadow-sky-100">
                            <i class="fas fa-file-alt text-sm"></i>
                        </div>
                        <h2 class="text-xl font-black text-blue-950 tracking-tight">Deskripsi Paket</h2>
                    </div>
                    <p class="text-slate-600 text-sm md:text-base leading-relaxed whitespace-pre-line bg-slate-50 p-5 rounded-2xl border border-slate-100">
                        {{ $package->description }}
                    </p>
                </section>

                {{-- 2. KARTU RENCANA PERJALANAN (TIMELINE ELEGAN) --}}
                <section class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200/60 shadow-md shadow-slate-100 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-5 bg-[linear-gradient(to_right,#808080_1px,transparent_1px),linear-gradient(to_bottom,#808080_1px,transparent_1px)] bg-size-[24px_24px]"></div>

                    <div class="flex items-center gap-3 mb-8 relative z-10">
                        <div class="w-10 h-10 rounded-xl bg-linear-to-tr from-blue-600 to-sky-400 text-white flex items-center justify-center shadow-md shadow-sky-100">
                            <i class="fas fa-route text-sm"></i>
                        </div>
                        <h2 class="text-xl font-black text-blue-950 tracking-tight">Rencana Perjalanan</h2>
                    </div>
                    
                    @if($package->itinerary)
                        <div class="relative border-l-2 border-dashed border-sky-200 pl-8 ml-4 space-y-10 z-10">
                            @php
                                // Pecah teks berdasarkan kata "Hari [angka]:" atau "Hari [angka] "
                                $rawDays = preg_split('/(?=Hari\s*\d+)/i', $package->itinerary);
                                $dayCounter = 1;
                            @endphp

                            @foreach($rawDays as $dayText)
                                @php $dayText = trim($dayText); @endphp
                                
                                @if(!empty($dayText))
                                    @php
                                        // Ambil baris pertama sebagai Judul Hari
                                        $lines = preg_split('/\r\n|\r|\n/', $dayText);
                                        $judulHariRaw = trim($lines[0]);
                                        $judulHari = preg_replace('/^Hari\s*\d+\s*:?\s*/i', '', $judulHariRaw);

                                        // Gabungkan sisa baris lalu split murni hanya berdasarkan tanda titik (.)
                                        $sisaTeks = implode(' ', array_slice($lines, 1));
                                        $subActivitiesRaw = preg_split('/\.(\s+|$)/', $sisaTeks);
                                        
                                        $subActivities = [];
                                        foreach ($subActivitiesRaw as $activity) {
                                            $trimmed = trim($activity);
                                            if (!empty($trimmed)) {
                                                $subActivities[] = $trimmed;
                                            }
                                        }
                                    @endphp
                                    
                                    <div class="relative group">
                                        <div class="absolute -left-12.5 top-0 bg-linear-to-br from-sky-400 to-blue-600 text-white w-9 h-9 rounded-xl flex items-center justify-center text-xs font-black shadow-lg shadow-sky-200 group-hover:scale-110 transition-transform duration-300">
                                            {{ $dayCounter }}
                                        </div>
                                        
                                        <div class="bg-slate-50/80 p-5 md:p-6 rounded-2xl border border-slate-200/60 transition-all hover:bg-sky-50/40 hover:border-sky-300/60">
                                            <h3 class="text-base font-black text-blue-950">
                                                Hari {{ $dayCounter }}: <span class="text-slate-800 font-bold">{{ $judulHari }}</span>
                                            </h3>
                                            
                                            @if(count($subActivities) > 0)
                                                <ul class="mt-4 space-y-3 text-slate-600 text-sm leading-relaxed">
                                                    @foreach($subActivities as $activity)
                                                        <li class="flex items-start gap-3 bg-white px-4 py-2.5 rounded-xl border border-slate-100 shadow-2xs">
                                                            <i class="fas fa-map-pin text-sky-500 text-xs mt-1.5 shrink-0"></i>
                                                            <span class="font-medium text-slate-700">{{ $activity }}.</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @php $dayCounter++; @endphp
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="relative p-6 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <p class="text-slate-400 text-sm italic">Detail rencana perjalanan belum diinput oleh admin.</p>
                        </div>
                    @endif
                </section>

                {{-- 3. INCLUDE & EXCLUDE (DIUBAH KE SYSTEM TITIK) --}}
                <section class="grid grid-cols-1 md:grid-cols-2 gap-6 relative">
                    @php
                        // Memastikan pemrosesan string mentah murni dipecah berdasarkan tanda titik (.) saja
                        $rawIncludes = is_string($package->includes) ? $package->includes : json_encode($package->includes);
                        $includesListRaw = preg_split('/\.(\s+|$)/', $rawIncludes);
                        $includesList = array_filter(array_map('trim', $includesListRaw));

                        $rawExcludes = is_string($package->excludes) ? $package->excludes : json_encode($package->excludes);
                        $excludesListRaw = preg_split('/\.(\s+|$)/', $rawExcludes);
                        $excludesList = array_filter(array_map('trim', $excludesListRaw));
                    @endphp

                    {{-- Card Include (Emerald) --}}
                    <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200/60 shadow-md shadow-slate-100 border-t-4 border-t-emerald-500">
                        <h3 class="text-sm font-black uppercase tracking-wider text-emerald-700 flex items-center gap-3 mb-5">
                            <span class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs shadow-xs"><i class="fas fa-check"></i></span>
                            Harga Termasuk
                        </h3>
                        <ul class="space-y-3 text-slate-600 text-xs md:text-sm">
                            @forelse($includesList as $include)
                                <li class="flex items-start gap-3 bg-emerald-50/40 p-3 rounded-xl border border-emerald-100/50">
                                    <i class="fas fa-check-circle text-emerald-500 text-sm mt-0.5 shrink-0"></i> 
                                    <span class="font-bold text-slate-700">{{ $include }}.</span>
                                </li>
                            @empty
                                <li class="text-slate-400 italic text-xs px-2">Standard service travel</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Card Exclude (Rose) --}}
                    <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200/60 shadow-md shadow-slate-100 border-t-4 border-t-rose-500">
                        <h3 class="text-sm font-black uppercase tracking-wider text-rose-700 flex items-center gap-3 mb-5">
                            <span class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center text-xs shadow-xs"><i class="fas fa-times"></i></span>
                            Belum Termasuk
                        </h3>
                        <ul class="space-y-3 text-slate-600 text-xs md:text-sm">
                            @forelse($excludesList as $exclude)
                                <li class="flex items-start gap-3 bg-rose-50/40 p-3 rounded-xl border border-rose-100/50">
                                    <i class="fas fa-minus-circle text-rose-400 text-sm mt-0.5 shrink-0"></i> 
                                    <span class="font-bold text-slate-700">{{ $exclude }}.</span>
                                </li>
                            @empty
                                <li class="text-slate-400 italic text-xs px-2">Pengeluaran pribadi diluar paket</li>
                            @endforelse
                        </ul>
                    </div>
                </section>

                {{-- 4. SECTION ULASAN WISATAWAN --}}
                <section class="space-y-4">
                    <div class="flex items-center justify-between bg-blue-950 p-4 md:p-5 rounded-2xl text-white shadow-md">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-comments text-sky-400 text-lg"></i>
                            <h2 class="text-base md:text-lg font-black tracking-tight">
                                Ulasan Wisatawan ({{ $package->reviews->count() }})
                            </h2>
                        </div>
                        @if($package->reviews->count() > 0)
                            <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/10">
                                <i class="fas fa-star text-amber-400 text-sm"></i>
                                <span class="text-xs font-black text-amber-300">
                                    {{ number_format($package->reviews->avg('rating'), 1) }} / 5.0
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($package->reviews as $review)
                            <div class="p-5 rounded-2xl border border-slate-200/60 bg-white shadow-xs space-y-4 transition-all hover:-translate-y-1 hover:border-sky-300 hover:shadow-md flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-linear-to-tr from-sky-400 to-blue-600 text-white font-black text-xs flex items-center justify-center uppercase tracking-wider shadow-sm">
                                                {{ substr($review->user->name ?? 'W', 0, 2) }}
                                            </div>
                                            <div>
                                                <h4 class="text-xs font-black text-slate-900 leading-tight">{{ $review->user->name ?? 'Wisatawan Belitung' }}</h4>
                                                <p class="text-[10px] text-slate-400 mt-0.5 font-medium">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-0.5 text-amber-400 text-[10px] bg-amber-50 px-2 py-1 rounded-lg border border-amber-100">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    <p class="text-slate-600 text-xs md:text-sm leading-relaxed italic font-medium">
                                        "{{ $review->comment }}"
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-1 md:col-span-2 text-center py-12 bg-white border-2 border-dashed border-slate-200 rounded-3xl shadow-xs">
                                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="far fa-comment-dots text-xl"></i>
                                </div>
                                <p class="text-xs text-slate-400 font-medium italic">Belum ada ulasan untuk paket tour ini. Jadilah yang pertama memberikan ulasan!</p>
                            </div>
                        @endforelse
                    </div>
                </section>

            </div>

            {{-- KOLOM KANAN: HARGA & AKSI --}}
            <div class="lg:sticky lg:top-24 space-y-6 relative z-10">
                <div class="bg-white rounded-3xl border border-slate-200/60 shadow-xl shadow-slate-200/50 overflow-hidden">
                    <div class="p-6 bg-blue-950 text-white relative">
                        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] bg-size-[16px_16px]"></div>
                        <span class="text-[10px] uppercase tracking-widest font-bold text-sky-400 block mb-1">Daftar Tarif</span>
                        <h3 class="text-lg font-black tracking-tight text-white">Harga Per Orang</h3>
                    </div>
                    
                    <div class="divide-y divide-slate-100 text-sm">
                        <div class="p-4 flex justify-between items-center bg-slate-50">
                            <span class="font-bold text-blue-950">Peserta</span>
                            <span class="font-bold text-blue-950">Tarif / Pax</span>
                        </div>
                        <div class="p-4 flex justify-between items-center hover:bg-slate-50 transition-colors">
                            <span class="text-slate-600 font-medium">2 - 3 Orang</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($package->price * 1.2, 0, ',', '.') }}</span>
                        </div>
                        <div class="p-4 flex justify-between items-center bg-sky-50/50">
                            <span class="font-bold text-blue-950 flex items-center gap-1.5">
                                4 - 6 Orang <span class="bg-linear-to-r from-sky-400 to-blue-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded-sm uppercase tracking-wider">Best Value</span>
                            </span>
                            <span class="font-black text-sky-600 text-base">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="p-4 flex justify-between items-center hover:bg-slate-50 transition-colors">
                            <span class="text-slate-600 font-medium">7+ Orang (Grup)</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($package->price * 0.9, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 border-t border-slate-100 space-y-4">
                        <form action="{{ route('booking.form', ['id' => $package->id]) }}" method="GET">
                            <button type="submit" class="w-full bg-linear-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-black text-sm text-center py-4 px-4 rounded-xl shadow-lg shadow-sky-200 transition-all flex items-center justify-center gap-3 cursor-pointer tracking-wider">
                                PESAN SEKARANG
                            </button>
                        </form>
                        <p class="text-[10px] text-slate-400 text-center leading-relaxed font-medium italic">
                            * Harga dapat berubah sewaktu-waktu mengikuti ketersediaan hotel dan periode liburan.
                        </p>
                    </div>
                </div>
                
                <div class="p-5 rounded-2xl border border-slate-200/60 bg-white flex items-center gap-4 shadow-xs">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-500 flex items-center justify-center text-xl shrink-0">
                        <i class="fas fa-umbrella-beach"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-blue-950">Paket Kustom Tersedia</h4>
                        <p class="text-[10px] text-slate-500 mt-0.5 leading-tight font-medium">Punya rencana sendiri? Chat kami untuk penawaran spesial.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

@endsection