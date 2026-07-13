<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('booking.index', [
            'title' => 'Booking',
            'bookings' => Booking::with(['user', 'room.property'])->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('booking.create', [
            'title' => 'Create Booking',
            'users' => User::where('role', 'Tenant')->get(),
            'rooms' => Room::with('property')->where('status', 'Available')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Active,Completed,Rejected',
        ], [
            'user_id.required' => 'Penyewa wajib dipilih',
            'room_id.required' => 'Kamar wajib dipilih',
            'start_date.required' => 'Tanggal mulai wajib diisi',
            'end_date.required' => 'Tanggal selesai wajib diisi',
            'total_price.required' => 'Total harga wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            $booking = Booking::create($validate);

            // Update room status if booking is Active
            if ($booking->status == 'Active') {
                $room = Room::find($booking->room_id);
                if ($room) {
                    $room->update(['status' => 'Occupied']);
                }
            }

            DB::commit();
            return to_route('booking.index')->withSuccess('Data pesanan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('booking.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return view('booking.show', [
            'title' => 'Detail Booking',
            'booking' => $booking->load(['user', 'room.property']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        return view('booking.edit', [
            'title' => 'Edit Booking',
            'booking' => $booking,
            'users' => User::where('role', 'Tenant')->get(),
            'rooms' => Room::with('property')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Active,Completed,Rejected',
        ], [
            'user_id.required' => 'Penyewa wajib dipilih',
            'room_id.required' => 'Kamar wajib dipilih',
            'start_date.required' => 'Tanggal mulai wajib diisi',
            'end_date.required' => 'Tanggal selesai wajib diisi',
            'total_price.required' => 'Total harga wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            $oldStatus = $booking->status;
            $oldRoomId = $booking->room_id;
            
            $booking->update($validate);

            // Handle Room status change logic
            // If the booking is now Active, set the new room to Occupied
            if ($booking->status == 'Active' && $oldStatus != 'Active') {
                Room::where('id', $booking->room_id)->update(['status' => 'Occupied']);
            } 
            // If the booking was Active but now is not (Completed, Rejected, Pending), set room to Available
            elseif ($oldStatus == 'Active' && $booking->status != 'Active') {
                Room::where('id', $oldRoomId)->update(['status' => 'Available']);
            }

            DB::commit();
            return to_route('booking.index')->withSuccess('Data pesanan berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('booking.edit', $booking)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        DB::beginTransaction();

        try {
            if ($booking->status == 'Active') {
                Room::where('id', $booking->room_id)->update(['status' => 'Available']);
            }
            
            $booking->delete();

            DB::commit();
            return to_route('booking.index')->withSuccess('Data pesanan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('booking.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
