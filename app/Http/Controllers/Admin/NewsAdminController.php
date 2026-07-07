<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsAdminController extends Controller
{
    public function index()
    {
        $news = News::with('user')->latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:50',
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        // 2. Pastikan Admin Sudah Login
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->back()->withErrors(['error' => 'Sesi Anda telah habis, silakan login kembali.']);
        }

        // 3. Proses Gambar Menjadi Base64 (Aman dari QueryException & Max Packet)
        $imageData = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // Variabel $file didefinisikan terlebih dahulu
            $imageData = base64_encode(file_get_contents($file->getRealPath()));
        }

        // 4. Simpan ke Database
        $news = new \App\Models\News();
        $news->user_id = $userId;
        $news->title = $request->title;
        $news->category = $request->category;
        $news->content = $request->content;
        $news->image = $imageData; 
        $news->published_at = now();
        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi Input Edit
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:50',
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        // 2. Cari Data Artikel Berdasarkan ID
        $news = \App\Models\News::findOrFail($id);

        // 3. Proses Gambar Baru (Jika ada gambar baru yang diunggah)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $news->image = base64_encode(file_get_contents($file->getRealPath()));
        }

        // 4. Update Kolom Lainnya
        $news->title = $request->title;
        $news->category = $request->category;
        $news->content = $request->content;
        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        News::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Berita berhasil dihapus!');
    }
}