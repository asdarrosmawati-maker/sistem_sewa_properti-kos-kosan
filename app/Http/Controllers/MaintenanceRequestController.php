<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('maintenance.index', [
            'title' => 'Maintenance Request',
            'maintenances' => MaintenanceRequest::with(['booking.room.property', 'user'])->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('maintenance.create', [
            'title' => 'Buat Pengaduan',
            // Allow tenant to complain for active bookings
            'bookings' => Booking::whereIn('status', ['Active', 'Pending'])->with(['room.property', 'user'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'issue_description' => 'required|string',
        ], [
            'booking_id.required' => 'Pemesanan wajib dipilih',
            'booking_id.exists' => 'Pemesanan tidak ditemukan',
            'issue_description.required' => 'Deskripsi keluhan wajib diisi',
        ]);

        $booking = Booking::findOrFail($validate['booking_id']);
        $validate['user_id'] = $booking->user_id;
        $validate['status'] = 'Pending'; // Default status for new request

        DB::beginTransaction();

        try {
            MaintenanceRequest::create($validate);

            DB::commit();
            return to_route('maintenance.index')->withSuccess('Pengaduan berhasil dikirim');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('maintenance.create')->withError('Gagal mengirim pengaduan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceRequest $maintenance)
    {
        return view('maintenance.show', [
            'title' => 'Detail Pengaduan',
            'maintenance' => $maintenance->load(['booking.room.property', 'user']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceRequest $maintenance)
    {
        return view('maintenance.edit', [
            'title' => 'Update Status Pengaduan',
            'maintenance' => $maintenance,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $validate = $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved',
        ], [
            'status.required' => 'Status penyelesaian wajib dipilih',
        ]);

        DB::beginTransaction();

        try {
            $maintenance->update($validate);

            DB::commit();
            return to_route('maintenance.index')->withSuccess('Status pengaduan berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('maintenance.edit', $maintenance)->withError('Gagal mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceRequest $maintenance)
    {
        DB::beginTransaction();

        try {
            $maintenance->delete();

            DB::commit();
            return to_route('maintenance.index')->withSuccess('Pengaduan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('maintenance.index')->withError('Gagal menghapus pengaduan: ' . $e->getMessage());
        }
    }
}
