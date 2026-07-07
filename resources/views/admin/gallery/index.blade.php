@extends('layouts.admin')

@section('page_title', 'Dokumentasi Galeri Foto')

@section('content')
{{-- TAMBAHKAN openDeleteModal: false dan deleteAction: '' pada x-data --}}
<div x-data="{ openAddModal: false, openEditModal: false, openDeleteModal: false, editId: '', editTitle: '', editCategory: '', editSource: '', editAction: '', deleteAction: '' }">
    
    {{-- Header Menu --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Dokumentasi Foto Pariwisata</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola aset dokumentasi foto perjalanan liburan destinasi Belitung Begaye.</p>
        </div>
        <button @click="openAddModal = true" class="bg-sky-600 hover:bg-sky-700 text-white text-xs font-black uppercase tracking-wider px-4 py-2.5 rounded-xl shadow-lg shadow-sky-600/20 transition-all flex items-center gap-2 cursor-pointer">
            <i class="fas fa-plus"></i> Tambah Foto
        </button>
    </div>

    {{-- Grid Dokumentasi Foto --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($galleries as $gallery)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl transition-all duration-300">
                <div class="relative aspect-video bg-slate-100 overflow-hidden">
                    {{-- Render Gambar dari BLOB --}}
                    <img src="data:image/jpeg;base64,{{ $gallery->image }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    <div class="absolute inset-0 bg-linear-to-t from-slate-950/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4 gap-2 justify-end">
                        
                        {{-- Tombol Edit --}}
                        <button @click="openEditModal = true; editId = '{{ $gallery->id }}'; editTitle = '{{ $gallery->title }}'; editCategory = '{{ $gallery->filter_category }}'; editSource = '{{ $gallery->source }}'; editAction = '{{ route('admin.galleries.update', $gallery->id) }}'" 
                                class="w-8 h-8 bg-white/90 hover:bg-white text-slate-700 rounded-lg flex items-center justify-center text-xs shadow transition-colors cursor-pointer">
                            <i class="fas fa-edit"></i>
                        </button>

                        {{-- Tombol Pemicu Modal Hapus Custom --}}
                        <button @click="openDeleteModal = true; deleteAction = '{{ route('admin.galleries.destroy', $gallery->id) }}'"
                                type="button" 
                                class="w-8 h-8 bg-rose-600 hover:bg-rose-700 text-white rounded-lg flex items-center justify-center text-xs shadow transition-colors cursor-pointer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <span class="px-2 py-0.5 bg-sky-50 text-sky-600 font-bold text-[9px] uppercase tracking-wider rounded-md">{{ $gallery->filter_category }}</span>
                        <span class="text-[9px] text-slate-400 font-medium truncate">Source: {{ $gallery->source }}</span>
                    </div>
                    <h3 class="font-black text-slate-800 text-xs uppercase tracking-wide truncate mt-1.5">{{ $gallery->title }}</h3>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-slate-100 rounded-2xl py-16 text-center text-slate-400 font-medium text-sm shadow-xl shadow-slate-900/5">
                <i class="fas fa-images text-3xl text-slate-200 block mb-3"></i>
                Belum ada dokumentasi foto yang diunggah.
            </div>
        @endforelse
    </div>

    {{-- MODAL TAMBAH FOTO --}}
    <div x-show="openAddModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center z-50 p-4" x-transition x-cloak>
        <div @click.away="openAddModal = false" class="bg-white rounded-2xl shadow-2xl max-w-md w-full border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-black text-slate-900 text-xs uppercase tracking-wider">Unggah Foto Baru</h3>
                <button @click="openAddModal = false" class="text-slate-400 hover:text-slate-600 text-sm cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Judul / Keterangan Foto</label>
                    <input type="text" name="title" required placeholder="Contoh: Sunset di Pantai Tanjung Tinggi" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 font-medium">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Kategori Filter</label>
                        <select name="filter_category" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 font-bold text-slate-700">
                            <option value="Destinasi">Destinasi</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Tips Liburan">Tips Liburan</option>
                            <option value="Budaya">Budaya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Sumber Foto</label>
                        <input type="text" name="source" placeholder="Internal / Nama Fotografer" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 font-medium">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Pilih File Gambar</label>
                    <input type="file" name="image" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-wider file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                </div>
                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="openAddModal = false" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-black uppercase tracking-wider hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-black uppercase tracking-wider shadow-lg shadow-sky-600/20 cursor-pointer">Simpan Foto</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT FOTO --}}
    <div x-show="openEditModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center z-50 p-4" x-transition x-cloak>
        <div @click.away="openEditModal = false" class="bg-white rounded-2xl shadow-2xl max-w-md w-full border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-black text-slate-900 text-xs uppercase tracking-wider">Edit Dokumentasi Foto</h3>
                <button @click="openEditModal = false" class="text-slate-400 hover:text-slate-600 text-sm cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            <form :action="editAction" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Judul / Keterangan Foto</label>
                    <input type="text" name="title" x-model="editTitle" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 font-medium">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Kategori Filter</label>
                        <select name="filter_category" x-model="editCategory" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 font-bold text-slate-700">
                            <option value="Destinasi">Destinasi</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Tips Liburan">Tips Liburan</option>
                            <option value="Budaya">Budaya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Sumber Foto</label>
                        <input type="text" name="source" x-model="editSource" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 font-medium">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">Ganti Gambar (Opsional)</label>
                    <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-wider file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                    <span class="text-[10px] text-slate-400 mt-1 block">*Kosongkan jika tidak ingin mengganti file gambar lama</span>
                </div>
                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="openEditModal = false" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-black uppercase tracking-wider hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-black uppercase tracking-wider shadow-lg shadow-sky-600/20 cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL CUSTOM CONFIRMATION HAPUS FOTO --}}
    <div x-show="openDeleteModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center z-50 p-4" x-transition x-cloak>
        <div @click.away="openDeleteModal = false" class="bg-white rounded-2xl shadow-2xl max-w-sm w-full border border-slate-100 overflow-hidden p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-rose-50 mb-4">
                <i class="fas fa-exclamation-triangle text-rose-600 text-lg"></i>
            </div>
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-2">Konfirmasi Hapus</h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-6">Apakah Anda yakin ingin menghapus foto dokumentasi ini? Tindakan ini tidak dapat dibatalkan.</p>
            
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