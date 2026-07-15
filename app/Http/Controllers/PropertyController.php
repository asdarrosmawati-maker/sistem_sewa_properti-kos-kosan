<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('property.index', [
            'title' => 'Properti',
            'properties' => Property::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('property.create', [
            'title' => 'Tambah Properti',
            'owners' => \App\Models\User::where('role', 'Owner')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'address' => 'required',
            'description' => 'nullable',
        ], [
            'user_id.required' => 'Pemilik wajib dipilih',
            'user_id.exists' => 'Pemilik tidak ditemukan',
            'name.required' => 'Nama properti wajib diisi',
            'address.required' => 'Alamat properti wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            Property::create($validate);

            DB::commit();
            return to_route('property.index')->withSuccess('Data properti berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('property.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return view('property.show', [
            'title' => 'Detail Properti',
            'property' => $property,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        return view('property.edit', [
            'title' => 'Edit Properti',
            'property' => $property,
            'owners' => \App\Models\User::where('role', 'Owner')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'address' => 'required',
            'description' => 'nullable',
        ], [
            'user_id.required' => 'Pemilik wajib dipilih',
            'user_id.exists' => 'Pemilik tidak ditemukan',
            'name.required' => 'Nama properti wajib diisi',
            'address.required' => 'Alamat properti wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            $property->update($validate);

            DB::commit();
            return to_route('property.index')->withSuccess('Data properti berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('property.edit', $property)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        DB::beginTransaction();

        try {
            $property->delete();

            DB::commit();
            return to_route('property.index')->withSuccess('Data properti berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('property.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
