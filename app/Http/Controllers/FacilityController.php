<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('facility.index', [
            'title' => 'Fasilitas',
            'facilities' => Facility::with('property')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('facility.create', [
            'title' => 'Tambah Fasilitas',
            'properties' => Property::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'property_id.required' => 'Properti wajib dipilih',
            'property_id.exists' => 'Properti tidak ditemukan',
            'name.required' => 'Nama fasilitas wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            Facility::create($validate);

            DB::commit();
            return to_route('facility.index')->withSuccess('Data fasilitas berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('facility.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        return view('facility.show', [
            'title' => 'Detail Fasilitas',
            'facility' => $facility->load('property'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        return view('facility.edit', [
            'title' => 'Edit Fasilitas',
            'facility' => $facility,
            'properties' => Property::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validate = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'property_id.required' => 'Properti wajib dipilih',
            'property_id.exists' => 'Properti tidak ditemukan',
            'name.required' => 'Nama fasilitas wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            $facility->update($validate);

            DB::commit();
            return to_route('facility.index')->withSuccess('Data fasilitas berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('facility.edit', $facility)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        DB::beginTransaction();

        try {
            $facility->delete();

            DB::commit();
            return to_route('facility.index')->withSuccess('Data fasilitas berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('facility.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
