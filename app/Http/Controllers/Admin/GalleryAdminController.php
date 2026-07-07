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

    // Menyimpan foto baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'filter_category' => 'required|in:Destinasi,Kuliner,Tips Liburan,Budaya',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Maksimal 2MB
            'source' => 'nullable|string|max:100'
        ]);

        // Membaca file gambar
        $file = $request->file('image');

        $binaryData = file_get_contents($file->getRealPath());
        $base64Data = base64_encode($binaryData);

        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->filter_category = $request->filter_category;
        $gallery->image = $base64Data;
        $gallery->source = $request->source ?? 'Internal';
        $gallery->save();

        return redirect()->back()->with('success', 'Foto keindahan Belitung berhasil ditambahkan ke Galeri!');
    }

    // Menghandle pembaruan data/foto dokumentasi
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'filter_category' => 'required|in:Destinasi,Kuliner,Tips Liburan,Budaya',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'source' => 'nullable|string|max:100'
        ]);

        $data = [
            'title' => $request->title,
            'filter_category' => $request->filter_category,
            'source' => $request->source ?? 'Internal',
        ];

        // Jika admin mengunggah foto baru untuk mengganti foto lama
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = file_get_contents($file->getRealPath());
        }

        $gallery->update($data);

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