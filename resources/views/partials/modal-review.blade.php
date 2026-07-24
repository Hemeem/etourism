{{-- resources/views/partials/modal-review.blade.php --}}
<template x-teleport="body">
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
         x-show="openReviewModal" 
         x-cloak
         @keydown.window.escape="openReviewModal = false">
         
        {{-- BACKDROP --}}
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
             @click="openReviewModal = false"
             x-show="openReviewModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        {{-- MODAL BOX --}}
        <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-6 shadow-2xl border border-slate-100 relative z-10"
             x-show="openReviewModal"
             x-data="{ rating: 5, hoverRating: 0 }"
             x-init="$watch('openReviewModal', value => { if(!value) { rating = 5; hoverRating = 0; } })"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            {{-- HEADER MODAL --}}
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center text-xs border border-amber-100 shadow-xs">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 tracking-tight">Bagikan Pengalaman Anda</h3>
                        <p class="text-[11px] text-slate-400 font-medium">Ulasan Anda membantu wisatawan lain memilih paket terbaik.</p>
                    </div>
                </div>
                <button type="button" 
                        @click="openReviewModal = false" 
                        class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            {{-- FORM ULASAN --}}
            <form action="{{ route('reviews.storeCustomer') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="package_id" :value="selectedPackageId">
                <input type="hidden" name="reservation_id" :value="selectedReservationId">

                {{-- RATING BINTANG INTERAKTIF --}}
                <div class="space-y-2 bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100 text-center">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Berikan Nilai Kepuasan</label>
                    <input type="hidden" name="rating" :value="rating">
                    
                    <div class="flex items-center justify-center gap-2 text-2xl py-1">
                        <template x-for="i in 5" :key="i">
                            <button type="button" 
                                    @click="rating = i" 
                                    @mouseover="hoverRating = i" 
                                    @mouseleave="hoverRating = 0"
                                    class="focus:outline-hidden transition-transform active:scale-125 cursor-pointer">
                                <i class="fas fa-star transition-colors duration-150" 
                                   :class="(hoverRating || rating) >= i ? 'text-amber-400 drop-shadow-xs' : 'text-slate-200'"></i>
                            </button>
                        </template>
                    </div>
                    
                    <span class="text-[11px] font-bold text-amber-600 block h-4">
                        <span x-show="(hoverRating || rating) == 5">Sangat Memuaskan! 🌟</span>
                        <span x-show="(hoverRating || rating) == 4">Bagus & Menyenangkan 👍</span>
                        <span x-show="(hoverRating || rating) == 3">Cukup Baik 🙂</span>
                        <span x-show="(hoverRating || rating) == 2">Kurang Memuaskan 😐</span>
                        <span x-show="(hoverRating || rating) == 1">Kecewa / Perlu Perbaikan 🙁</span>
                    </span>
                </div>

                {{-- INPUT TESTIMONI --}}
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Ulasan / Testimoni</label>
                    <textarea name="comment" rows="4" required 
                              placeholder="Ceritakan keseruan liburan Anda di Belitung, pelayanan guide, atau destinasi favorit yang dikunjungi..." 
                              class="w-full text-xs font-medium px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 focus:outline-hidden focus:border-sky-600 focus:ring-4 focus:ring-sky-100 transition-all resize-none placeholder:text-slate-400 leading-relaxed"></textarea>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" 
                            @click="openReviewModal = false" 
                            class="w-1/3 bg-slate-50 text-slate-600 border border-slate-200 font-bold text-xs py-3.5 rounded-xl hover:bg-slate-100 transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" 
                            class="w-2/3 bg-linear-to-b from-sky-500 to-sky-600 text-white font-black text-xs py-3.5 rounded-xl shadow-md shadow-sky-600/20 hover:from-sky-600 hover:to-sky-700 transition-all cursor-pointer flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane text-[10px]"></i> Kirim Ulasan Resmi
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>