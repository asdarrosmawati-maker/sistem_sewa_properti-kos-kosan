<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('payment.index', [
            'title' => 'Payment',
            'payments' => Payment::with('booking.user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment.create', [
            'title' => 'Create Payment',
            'bookings' => Booking::with('user')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Pending,Verified,Rejected',
        ], [
            'booking_id.required' => 'Pesanan wajib dipilih',
            'amount.required' => 'Jumlah bayar wajib diisi',
            'payment_date.required' => 'Tanggal bayar wajib diisi',
            'proof_of_payment.required' => 'Bukti pembayaran wajib diunggah',
            'proof_of_payment.image' => 'File harus berupa gambar',
            'proof_of_payment.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'proof_of_payment.max' => 'Ukuran gambar maksimal 2MB',
            'status.required' => 'Status wajib dipilih',
        ]);

        $filePath = null;
        DB::beginTransaction();

        try {
            if ($request->hasFile('proof_of_payment')) {
                $filePath = $request->file('proof_of_payment')->store('payments', 'public');
                $validate['proof_of_payment'] = $filePath;
            }

            Payment::create($validate);

            DB::commit();
            return to_route('payment.index')->withSuccess('Data pembayaran berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            return to_route('payment.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return view('payment.show', [
            'title' => 'Detail Payment',
            'payment' => $payment->load('booking.user'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        return view('payment.edit', [
            'title' => 'Edit Payment',
            'payment' => $payment,
            'bookings' => Booking::with('user')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validate = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'proof_of_payment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Pending,Verified,Rejected',
        ], [
            'booking_id.required' => 'Pesanan wajib dipilih',
            'amount.required' => 'Jumlah bayar wajib diisi',
            'payment_date.required' => 'Tanggal bayar wajib diisi',
            'proof_of_payment.image' => 'File harus berupa gambar',
            'proof_of_payment.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'proof_of_payment.max' => 'Ukuran gambar maksimal 2MB',
            'status.required' => 'Status wajib dipilih',
        ]);

        $newFilePath = null;
        DB::beginTransaction();

        try {
            if ($request->hasFile('proof_of_payment')) {
                // Delete old file if exists
                if ($payment->proof_of_payment) {
                    Storage::disk('public')->delete($payment->proof_of_payment);
                }
                
                $newFilePath = $request->file('proof_of_payment')->store('payments', 'public');
                $validate['proof_of_payment'] = $newFilePath;
            }

            $payment->update($validate);

            DB::commit();
            return to_route('payment.index')->withSuccess('Data pembayaran berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($newFilePath) {
                Storage::disk('public')->delete($newFilePath);
            }
            return to_route('payment.edit', $payment)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        DB::beginTransaction();

        try {
            $filePath = $payment->proof_of_payment;
            
            $payment->delete();

            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }

            DB::commit();
            return to_route('payment.index')->withSuccess('Data pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('payment.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
