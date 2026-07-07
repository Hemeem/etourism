@extends('layouts.admin')

@section('page_title', 'Manajemen Paket Wisata')

@section('content')
<div x-data="{ 
    openCreateModal: false, 
    openEditModal: false, 
    openDeleteModal: false,
    deleteAction: '',
    editData: {id:'', title:'', category:'', duration:'', min_pax:'', price:'', description:'', includes:'', excludes:'', itinerary:''},
    
    loadEditData(el) {
        this.editData.id = el.getAttribute('data-id');
        this.editData.title = el.getAttribute('data-title');
        this.editData.category = el.getAttribute('data-category');
        this.editData.duration = el.getAttribute('data-duration');
        this.editData.min_pax = el.getAttribute('data-min_pax');
        this.editData.price = el.getAttribute('data-price');
        this.editData.description = el.getAttribute('data-description');
        this.editData.includes = el.getAttribute('data-includes');
        this.editData.excludes = el.getAttribute('data-excludes');
        this.editData.itinerary = el.getAttribute('data-itinerary');
        this.openEditModal = true;
    }
}">
    
    {{-- HEADER BAR --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Katalog Paket Tour Resmi</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola penawaran destinasi, kuota minimal, kategori, dan detail itinerary.</p>
        </div>
        <button @click="openCreateModal = true" class="bg-linear-to-b from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white text-xs font-black uppercase tracking-wider px-5 py-3.5 rounded-xl transition-all flex items-center gap-2 shadow-lg shadow-sky-100 cursor-pointer">
            <i class="fas fa-plus-circle text-sm"></i> Tambah Paket Baru
        </button>
    </div>

    {{-- TABEL DATA MASTER --}}
    <div class="bg-white rounded-2xl border border-slate-400 shadow-xl shadow-slate-1000/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-400 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="py-4 px-6">Informasi Paket</th>
                        <th class="py-4 px-6">Kategori / Durasi</th>
                        <th class="py-4 px-6">Harga Per Pax</th>
                        <th class="py-4 px-6 text-center">Min. Pax</th>
                        <th class="py-4 px-6 text-right">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300 text-sm">
                    @forelse($packages as $package)
                    <tr class="hover:bg-slate-70/70 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden">
                                    @if($package->image)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($package->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-map-marked-alt text-lg text-sky-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-black text-slate-900 block tracking-tight">{{ $package->title }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 bg-sky-50 text-sky-700 font-bold text-[11px] rounded-md block w-max mb-1">{{ $package->category }}</span>
                            <span class="text-xs text-slate-500 block"><i class="far fa-clock mr-1"></i>{{ $package->duration }}</span>
                        </td>
                        <td class="py-4 px-6 font-bold text-slate-900">Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-center font-bold text-slate-600">{{ $package->min_pax }} Pax</td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button type="button"
                                    @click="loadEditData($el)"
                                    data-id="{{ $package->id }}" 
                                    data-title="{{ $package->title }}" 
                                    data-category="{{ $package->category }}" 
                                    data-duration="{{ $package->duration }}" 
                                    data-min_pax="{{ $package->min_pax }}" 
                                    data-price="{{ $package->price }}" 
                                    data-description="{{ $package->description }}"
                                    data-includes="{{ $package->includes }}"
                                    data-excludes="{{ $package->excludes }}"
                                    data-itinerary="{{ $package->itinerary }}"
                                    class="p-2 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-all cursor-pointer">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                {{-- BUTTON PEMICU MODAL KUSTOM HAPUS --}}
                                <button type="button" 
                                    @click="openDeleteModal = true; deleteAction = '{{ route('admin.packages.destroy', $package->id) }}'"
                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all cursor-pointer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Belum ada data paket wisata di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TAMBAH DATA (CREATE) --}}
    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-xs shadow-2xl overflow-y-auto" x-transition x-cloak style="display: none;">
        <div @click.away="openCreateModal = false" class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-100 shadow-2xl">
            <div class="p-6 bg-slate-900 text-white flex justify-between items-center sticky top-0 z-10">
                <h3 class="text-sm font-black uppercase tracking-wider"><i class="fas fa-plus-circle text-sky-400 mr-2"></i> Form Input Paket Tour Lengkap</h3>
                <button @click="openCreateModal = false" class="text-slate-400 hover:text-white cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Nama Paket Wisata</label>
                        <input type="text" name="title" required placeholder="Contoh: Paket Island Hopping Leebong" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-sky-500 shadow-inner">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Kategori Paket</label>
                        <input type="text" name="category" required placeholder="Contoh: Reguler / Honeymoon / Corporate" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-sky-500 shadow-inner">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Durasi Wisata</label>
                        <input type="text" name="duration" required placeholder="Contoh: 3 Hari 2 Malam" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-sky-500 shadow-inner">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Minimal Peserta (Pax)</label>
                        <input type="number" name="min_pax" value="2" required class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-sky-500 shadow-inner">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Harga Per Pax (Rp)</label>
                        <input type="number" name="price" required placeholder="1500000" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-sky-500 shadow-inner">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Foto Destinasi Utama (Upload)</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" placeholder="Tulis deskripsi umum di sini..." class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden resize-none shadow-inner"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Fasilitas Termasuk (Includes)</label>
                        <textarea name="includes" rows="3" placeholder="Hotel, Transportasi laut, Makan siang, Tiket masuk..." class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden resize-none shadow-inner"></textarea>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Tidak Termasuk (Excludes)</label>
                        <textarea name="excludes" rows="3" placeholder="Tiket pesawat PP, Keperluan pribadi, Tips driver..." class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden resize-none shadow-inner"></textarea>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Rencana Perjalanan (Itinerary)</label>
                    <textarea name="itinerary" rows="4" placeholder="Hari 1: Penjemputan ke hotel... Hari 2: Penjelajahan pantai..." class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden resize-none shadow-inner"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-2 sticky bottom-0 bg-white">
                    <button type="button" @click="openCreateModal = false" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-[11px] font-black uppercase tracking-wider px-5 py-3 rounded-lg transition-colors cursor-pointer">Batal</button>
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white text-[11px] font-black uppercase tracking-wider px-5 py-3 rounded-lg transition-colors shadow-inner cursor-pointer">Simpan Ke Database</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EDIT DATA (UPDATE) --}}
    <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-xs overflow-y-auto" x-transition x-cloak style="display: none;">
        <div @click.away="openEditModal = false" class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-100 shadow-2xl">
            <div class="p-6 bg-slate-800 text-white flex justify-between items-center sticky top-0 z-10">
                <h3 class="text-sm font-black uppercase tracking-wider"><i class="fas fa-edit text-amber-400 mr-2"></i> Edit Data Paket Wisata Resmi</h3>
                <button @click="openEditModal = false" class="text-slate-400 hover:text-white cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            
            <form :action="'/admin/packages/' + editData.id" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Nama Paket Wisata</label>
                        <input type="text" name="title" x-model="editData.title" required class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Kategori Paket</label>
                        <input type="text" name="category" x-model="editData.category" required class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Durasi Wisata</label>
                        <input type="text" name="duration" x-model="editData.duration" required class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Minimal Peserta</label>
                        <input type="number" name="min_pax" x-model="editData.min_pax" required class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Harga Jual (Rp)</label>
                        <input type="number" name="price" x-model="editData.price" required class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Ganti Foto Destinasi (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Deskripsi</label>
                    <textarea name="description" rows="3" x-model="editData.description" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden resize-none"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Includes</label>
                        <textarea name="includes" rows="3" x-model="editData.includes" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden resize-none"></textarea>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Excludes</label>
                        <textarea name="excludes" rows="3" x-model="editData.excludes" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden resize-none"></textarea>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Itinerary</label>
                    <textarea name="itinerary" rows="4" x-model="editData.itinerary" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden resize-none"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-2 sticky bottom-0 bg-white">
                    <button type="button" @click="openEditModal = false" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-[11px] font-black uppercase tracking-wider px-5 py-3 rounded-lg transition-colors cursor-pointer">Batal</button>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white text-[11px] font-black uppercase tracking-wider px-5 py-3 rounded-lg transition-colors shadow-md cursor-pointer">Update Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL CUSTOM CONFIRMATION HAPUS --}}
    <div x-show="openDeleteModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-xs flex items-center justify-center z-50 p-4" x-transition x-cloak style="display: none;">
        <div @click.away="openDeleteModal = false" class="bg-white rounded-2xl shadow-2xl max-w-sm w-full border border-slate-100 overflow-hidden p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-rose-50 mb-4">
                <i class="fas fa-exclamation-triangle text-rose-600 text-lg"></i>
            </div>
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-2">Konfirmasi Hapus</h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-6">Apakah Anda yakin ingin menghapus paket wisata ini? Data yang terhapus akan memengaruhi riwayat reservasi terkait.</p>
            
            <form :action="deleteAction" method="POST" class="flex items-center justify-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" @click="openDeleteModal = false" class="w-full py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-black uppercase tracking-wider hover:bg-slate-50 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-black uppercase tracking-wider shadow-lg shadow-rose-600/20 transition-colors cursor-pointer">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

</div>
@endsection