<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('gallery.index', [
            'title' => 'Galeri',
            'galleries' => Gallery::with(['property', 'room'])->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create', [
            'title' => 'Tambah Galeri',
            'properties' => Property::all(),
            'rooms' => Room::with('property')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'nullable|exists:rooms,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ], [
            'property_id.required' => 'Properti wajib dipilih',
            'images.required' => 'Minimal 1 gambar wajib diunggah',
            'images.*.image' => 'File harus berupa gambar',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'images.*.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $uploadedPaths = [];
        DB::beginTransaction();

        try {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('galleries', 'public');
                    $uploadedPaths[] = $path;

                    Gallery::create([
                        'property_id' => $validate['property_id'],
                        'room_id' => $validate['room_id'] ?? null,
                        'image_path' => $path,
                        'caption' => $validate['caption'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return to_route('gallery.index')->withSuccess('Galeri berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            // Delete all uploaded files
            foreach ($uploadedPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            return to_route('gallery.create')->withError('Gagal menambahkan galeri: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('gallery.show', [
            'title' => 'Detail Galeri',
            'gallery' => $gallery->load(['property', 'room']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('gallery.edit', [
            'title' => 'Edit Galeri',
            'gallery' => $gallery,
            'properties' => Property::all(),
            'rooms' => Room::with('property')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validate = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'nullable|exists:rooms,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ], [
            'property_id.required' => 'Properti wajib dipilih',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $newFilePath = null;
        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                // Delete old file if it is stored locally (not dummy)
                if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                    Storage::disk('public')->delete($gallery->image_path);
                }
                
                $newFilePath = $request->file('image')->store('galleries', 'public');
                $gallery->image_path = $newFilePath;
            }

            $gallery->property_id = $validate['property_id'];
            $gallery->room_id = $validate['room_id'] ?? null;
            $gallery->caption = $validate['caption'] ?? null;
            $gallery->save();

            DB::commit();
            return to_route('gallery.index')->withSuccess('Galeri berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($newFilePath) {
                Storage::disk('public')->delete($newFilePath);
            }
            return to_route('gallery.edit', $gallery)->withError('Gagal mengubah galeri: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        DB::beginTransaction();

        try {
            $filePath = $gallery->image_path;
            
            $gallery->delete();

            // Only delete if it exists in local storage
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            DB::commit();
            return to_route('gallery.index')->withSuccess('Galeri berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('gallery.index')->withError('Gagal menghapus galeri: ' . $e->getMessage());
        }
    }
}
