@extends('layouts.admin')

@section('page_title', 'Manajemen Berita & Artikel')

@section('content')
{{-- TAMBAHKAN openDeleteModal: false dan deleteAction: '' pada x-data --}}
<div x-data="{ 
    openCreateModal: false, 
    openEditModal: false, 
    openDeleteModal: false,
    deleteAction: '',
    editData: {id:'', title:'', category:'', content:''},
    
    // Memuat data edit dari atribut HTML secara aman tanpa merusak JavaScript
    loadEditData(el) {
        this.editData.id = el.getAttribute('data-id');
        this.editData.title = el.getAttribute('data-title');
        this.editData.category = el.getAttribute('data-category');
        this.editData.content = el.getAttribute('data-content');
        this.openEditModal = true;
    }
}">
    
    {{-- HEADER BAR --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Artikel Edukasi Wisata</h2>
            <p class="text-xs text-slate-500 mt-0.5">Tingkatkan visibilitas SEO Travel Begaye melalui artikel informatif terupdate.</p>
        </div>
        <button @click="openCreateModal = true" class="bg-linear-to-b from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white text-xs font-black uppercase tracking-wider px-5 py-3.5 rounded-xl transition-all flex items-center gap-2 shadow-lg shadow-sky-100 cursor-pointer">
            <i class="fas fa-edit text-sm"></i> Tulis Artikel Baru
        </button>
    </div>

    {{-- TABEL DATA MASTER --}}
    <div class="bg-white rounded-2xl border border-slate-400 shadow-xl shadow-slate-1000/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-400 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="py-4 px-6">Thumbnail & Judul Artikel</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Tanggal Rilis</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300 text-sm">
                    @forelse($news as $item)
                    <tr class="hover:bg-slate-70/70 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                {{-- Render gambar dari longblob database --}}
                                <div class="w-14 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                                    @if($item->image)
                                        <img src="data:image/jpeg;base64,{{ $item->image }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-newspaper text-slate-400"></i>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-black text-slate-900 block tracking-tight line-clamp-1">{{ $item->title }}</span>
                                    <span class="text-xs text-slate-400 block mt-0.5">Oleh ID User: <span class="font-mono bg-slate-100 px-1 rounded">{{ $item->user_id }}</span></span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-700 font-bold text-[11px] rounded-md">{{ $item->category ?? 'Umum' }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-500">
                            {{ $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-' }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                {{-- Tombol Edit membawa data kolom teranyar --}}
                                <button type="button" 
                                    @click="loadEditData($el)"
                                    data-id="{{ $item->id }}"
                                    data-title="{{ $item->title }}"
                                    data-category="{{ $item->category }}"
                                    data-content="{{ $item->content }}"
                                    class="p-2 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-all cursor-pointer">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                {{-- GANTI FORM LAMA MENJADI TOMBOL PEMICU MODAL KUSTOM --}}
                                <button @click="openDeleteModal = true; deleteAction = '{{ route('admin.news.destroy', $item->id) }}'"
                                        type="button" 
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all cursor-pointer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Belum ada data artikel atau berita di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TAMBAH DATA (CREATE) --}}
    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-xs shadow-2xl overflow-y-auto" x-transition style="display: none;">
        <div @click.away="openCreateModal = false" class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-100 shadow-2xl">
            <div class="p-6 bg-slate-900 text-white flex justify-between items-center sticky top-0 z-10">
                <h3 class="text-sm font-black uppercase tracking-wider"><i class="fas fa-plus-circle text-sky-400 mr-2"></i> Tulis Artikel Baru</h3>
                <button @click="openCreateModal = false" class="text-slate-400 hover:text-white cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Judul Artikel/Berita</label>
                        <input type="text" name="title" required placeholder="Contoh: 5 Kuliner Wajib Belitung" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-sky-500 shadow-inner">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Kategori Artikel/Berita</label>
                        <input type="text" name="category" placeholder="Contoh: Destinasi, Kuliner, Tips, Budaya" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-sky-500 shadow-inner">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Foto Cover Artikel/Berita</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Isi Konten Artikel/Berita</label>
                    <textarea name="content" rows="10" required placeholder="Tulis isi berita atau edukasi wisata di sini secara lengkap..." class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden resize-none shadow-inner"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-2 sticky bottom-0 bg-white">
                    <button type="button" @click="openCreateModal = false" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-[11px] font-black uppercase tracking-wider px-5 py-3 rounded-lg transition-colors cursor-pointer">Batal</button>
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white text-[11px] font-black uppercase tracking-wider px-5 py-3 rounded-lg transition-colors shadow-inner cursor-pointer">Terbitkan Artikel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EDIT DATA (UPDATE) --}}
    <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-xs overflow-y-auto" x-transition style="display: none;">
        <div @click.away="openEditModal = false" class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-slate-100 shadow-2xl">
            <div class="p-6 bg-slate-800 text-white flex justify-between items-center sticky top-0 z-10">
                <h3 class="text-sm font-black uppercase tracking-wider"><i class="fas fa-edit text-amber-400 mr-2"></i> Edit Artikel Wisata</h3>
                <button @click="openEditModal = false" class="text-slate-400 hover:text-white cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            
            <form :action="'/admin/news/' + editData.id" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Judul Artikel (`title`)</label>
                        <input type="text" name="title" x-model="editData.title" required class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Kategori Wisata (`category`)</label>
                        <input type="text" name="category" x-model="editData.category" class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Ganti Foto Cover (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest block">Isi Konten Artikel (`content`)</label>
                    <textarea name="content" rows="10" x-model="editData.content" required class="w-full text-xs px-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-hidden resize-none"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-2 sticky bottom-0 bg-white">
                    <button type="button" @click="openEditModal = false" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-[11px] font-black uppercase tracking-wider px-5 py-3 rounded-lg transition-colors cursor-pointer">Batal</button>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white text-[11px] font-black uppercase tracking-wider px-5 py-3 rounded-lg transition-colors shadow-md cursor-pointer">Update Artikel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL CUSTOM CONFIRMATION HAPUS ARTIKEL --}}
    <div x-show="openDeleteModal" class="fixed inset-0 bg-slate-950/40 backdrop-blur-xs flex items-center justify-center z-50 p-4" x-transition x-cloak style="display: none;">
        <div @click.away="openDeleteModal = false" class="bg-white rounded-2xl shadow-2xl max-w-sm w-full border border-slate-100 overflow-hidden p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-rose-50 mb-4">
                <i class="fas fa-exclamation-triangle text-rose-600 text-lg"></i>
            </div>
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-2">Konfirmasi Hapus</h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-6">Apakah Anda yakin ingin menghapus artikel ini? Artikel yang terhapus tidak dapat dikembalikan.</p>
            
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