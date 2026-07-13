<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('room.index', [
            'title' => 'Room',
            'rooms' => Room::with('property')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('room.create', [
            'title' => 'Create Room',
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
            'room_number' => 'required|string|max:255',
            'price_per_month' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Occupied,Maintenance',
        ], [
            'property_id.required' => 'Properti wajib dipilih',
            'property_id.exists' => 'Properti tidak ditemukan',
            'room_number.required' => 'Nomor kamar wajib diisi',
            'price_per_month.required' => 'Harga per bulan wajib diisi',
            'price_per_month.numeric' => 'Harga harus berupa angka',
            'status.required' => 'Status kamar wajib dipilih',
        ]);

        DB::beginTransaction();

        try {
            Room::create($validate);

            DB::commit();
            return to_route('room.index')->withSuccess('Data kamar berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('room.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return view('room.show', [
            'title' => 'Detail Room',
            'room' => $room,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('room.edit', [
            'title' => 'Edit Room',
            'room' => $room,
            'properties' => Property::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validate = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_number' => 'required|string|max:255',
            'price_per_month' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Occupied,Maintenance',
        ], [
            'property_id.required' => 'Properti wajib dipilih',
            'property_id.exists' => 'Properti tidak ditemukan',
            'room_number.required' => 'Nomor kamar wajib diisi',
            'price_per_month.required' => 'Harga per bulan wajib diisi',
            'price_per_month.numeric' => 'Harga harus berupa angka',
            'status.required' => 'Status kamar wajib dipilih',
        ]);

        DB::beginTransaction();

        try {
            $room->update($validate);

            DB::commit();
            return to_route('room.index')->withSuccess('Data kamar berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('room.edit', $room)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        DB::beginTransaction();

        try {
            $room->delete();

            DB::commit();
            return to_route('room.index')->withSuccess('Data kamar berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('room.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
