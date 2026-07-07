{{-- resources/views/partials/modal-review.blade.php --}}
<template x-teleport="body">
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
         x-show="openReviewModal" 
         x-cloak>
         
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

        <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-6 shadow-2xl border border-slate-100 relative z-10"
             x-show="openReviewModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center text-xs border border-amber-100">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Bagikan Pengalaman Anda</h3>
                </div>
                <button type="button" @click="openReviewModal = false" class="text-slate-400 hover:text-slate-600 cursor-pointer transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('reviews.storeCustomer') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="package_id" :value="selectedPackageId">
                <input type="hidden" name="reservation_id" :value="selectedReservationId">

                <div class="space-y-2" x-data="{ rating: 5, hoverRating: 0 }">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Berikan Nilai</label>
                    <input type="hidden" name="rating" :value="rating">
                    <div class="flex items-center gap-2 text-2xl">
                        <template x-for="i in 5">
                            <button type="button" 
                                    @click="rating = i" 
                                    @mouseover="hoverRating = i" 
                                    @mouseleave="hoverRating = 0"
                                    class="focus:outline-hidden transition-transform active:scale-95 cursor-pointer">
                                <i class="fas fa-star transition-colors duration-150" 
                                   :class="(hoverRating || rating) >= i ? 'text-amber-400' : 'text-slate-200'"></i>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ulasan / Testimoni</label>
                    <textarea name="comment" rows="4" required 
                              placeholder="Ceritakan keseruan liburan Anda, guide, atau destinasi yang dikunjungi..." 
                              class="w-full text-sm font-medium px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 focus:outline-hidden focus:border-sky-600 focus:ring-4 focus:ring-sky-100 transition-all resize-none placeholder:text-slate-400"></textarea>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="button" @click="openReviewModal = false" class="w-1/3 bg-slate-50 text-slate-600 border border-slate-200 font-bold text-xs py-3.5 rounded-xl hover:bg-slate-100 transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="w-2/3 bg-linear-to-b from-sky-500 to-sky-600 text-white font-black text-xs py-3.5 rounded-xl shadow-md hover:from-sky-600 hover:to-sky-700 transition-all cursor-pointer">
                        Kirim Ulasan Resmi
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>