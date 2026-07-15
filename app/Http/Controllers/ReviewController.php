<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('review.index', [
            'title' => 'Ulasan',
            'reviews' => Review::with(['booking.room.property', 'user'])->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('review.create', [
            'title' => 'Tambah Ulasan',
            // Only show completed bookings that don't have a review yet
            'bookings' => Booking::where('status', 'Completed')->doesntHave('review')->with('user')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ], [
            'booking_id.required' => 'Pemesanan wajib dipilih',
            'booking_id.exists' => 'Pemesanan tidak ditemukan',
            'rating.required' => 'Rating wajib diisi',
            'rating.integer' => 'Rating harus berupa angka',
            'rating.min' => 'Rating minimal 1',
            'rating.max' => 'Rating maksimal 5',
            'comment.required' => 'Komentar wajib diisi',
        ]);

        $booking = Booking::findOrFail($validate['booking_id']);

        if ($booking->status !== 'Completed') {
            return to_route('review.create')->withError('Hanya pesanan yang sudah selesai yang bisa diulas.');
        }

        if (Review::where('booking_id', $booking->id)->exists()) {
            return to_route('review.create')->withError('Pemesanan ini sudah memiliki ulasan sebelumnya.');
        }

        $validate['user_id'] = $booking->user_id;

        DB::beginTransaction();

        try {
            Review::create($validate);

            DB::commit();
            return to_route('review.index')->withSuccess('Ulasan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('review.create')->withError('Gagal menambahkan ulasan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return view('review.show', [
            'title' => 'Detail Ulasan',
            'review' => $review->load(['booking.room.property', 'user']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        return view('review.edit', [
            'title' => 'Edit Ulasan',
            'review' => $review,
            // Include current booking and any completed bookings without reviews
            'bookings' => Booking::where('id', $review->booking_id)
                                 ->orWhere(function($query) {
                                     $query->where('status', 'Completed')->doesntHave('review');
                                 })
                                 ->with('user')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $validate = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ], [
            'booking_id.required' => 'Pemesanan wajib dipilih',
            'booking_id.exists' => 'Pemesanan tidak ditemukan',
            'rating.required' => 'Rating wajib diisi',
            'rating.integer' => 'Rating harus berupa angka',
            'rating.min' => 'Rating minimal 1',
            'rating.max' => 'Rating maksimal 5',
            'comment.required' => 'Komentar wajib diisi',
        ]);

        $booking = Booking::findOrFail($validate['booking_id']);

        if ($booking->status !== 'Completed') {
            return to_route('review.edit', $review)->withError('Hanya pesanan yang sudah selesai yang bisa diulas.');
        }

        if ($review->booking_id !== $booking->id && Review::where('booking_id', $booking->id)->exists()) {
            return to_route('review.edit', $review)->withError('Pemesanan ini sudah memiliki ulasan sebelumnya.');
        }

        $validate['user_id'] = $booking->user_id;

        DB::beginTransaction();

        try {
            $review->update($validate);

            DB::commit();
            return to_route('review.index')->withSuccess('Ulasan berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('review.edit', $review)->withError('Gagal mengubah ulasan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        DB::beginTransaction();

        try {
            $review->delete();

            DB::commit();
            return to_route('review.index')->withSuccess('Ulasan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('review.index')->withError('Gagal menghapus ulasan: ' . $e->getMessage());
        }
    }
}
