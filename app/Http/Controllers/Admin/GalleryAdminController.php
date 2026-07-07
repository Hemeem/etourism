<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryAdminController extends Controller
{
    // Menampilkan halaman index gallery di dashboard admin
    public function index()
    {
        $galleries = Gallery::orderBy('created_at', 'desc')->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    // Menyimpan banyak foto baru sekaligus ke dalam SATU baris database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'filter_category' => 'required|in:Destinasi,Kuliner,Tips Liburan,Budaya',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048', 
            'source' => 'nullable|string|max:100'
        ]);

        $uploadedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Membaca file gambar dan mengubahnya ke format Base64
                $binaryData = file_get_contents($file->getRealPath());
                $uploadedImages[] = base64_encode($binaryData); // Tampung semua dalam array
            }
        }

        // Simpan sebagai SATU baris data baru
        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->filter_category = $request->filter_category;
        $gallery->image = json_encode($uploadedImages); // Mengubah array menjadi string JSON
        $gallery->source = $request->source ?? 'Internal';
        $gallery->save();

        return redirect()->back()->with('success', 'Semua foto berhasil digabungkan dalam satu kiriman galeri!');
    }

    // Menghandle pembaruan data/foto dokumentasi
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'filter_category' => 'required|in:Destinasi,Kuliner,Tips Liburan,Budaya',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Ganti foto utama (opsional)
            'source' => 'nullable|string|max:100'
        ]);

        $gallery->title = $request->title;
        $gallery->filter_category = $request->filter_category;
        $gallery->source = $request->source ?? 'Internal';

        // Jika mengunggah foto baru untuk mengganti kumpulan foto lama
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $binaryData = file_get_contents($file->getRealPath());
            
            // Karena sekarang berbasis JSON, kita bungkus foto tunggal pengganti ini ke dalam array JSON
            $newImage = [base64_encode($binaryData)];
            $gallery->image = json_encode($newImage);
        }

        $gallery->save();

        return redirect()->back()->with('success', 'Dokumentasi galeri berhasil diperbarui!');
    }

    // Menghapus foto dari galeri
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus dari sistem.');
    }
}