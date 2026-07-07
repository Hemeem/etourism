<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageAdminController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'duration' => 'required|string',
            'min_pax' => 'required|integer',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $imageData = null;
        if ($request->hasFile('image')) {
            $imageData = file_get_contents($request->file('image')->getRealPath());
        }

        Package::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category' => $request->category,
            'duration' => $request->duration,
            'min_pax' => $request->min_pax,
            'price' => $request->price,
            'description' => $request->description,
            'includes' => $request->includes,
            'excludes' => $request->excludes,
            'itinerary' => $request->itinerary,
            'image' => $imageData
        ]);

        return redirect()->back()->with('success', 'Paket Wisata berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'duration' => 'required|string',
            'min_pax' => 'required|integer',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category' => $request->category,
            'duration' => $request->duration,
            'min_pax' => $request->min_pax,
            'price' => $request->price,
            'description' => $request->description,
            'includes' => $request->includes,
            'excludes' => $request->excludes,
            'itinerary' => $request->itinerary,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = file_get_contents($request->file('image')->getRealPath());
        }

        $package->update($data);
        return redirect()->back()->with('success', 'Paket Wisata berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Package::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Paket Wisata berhasil dihapus!');
    }
}