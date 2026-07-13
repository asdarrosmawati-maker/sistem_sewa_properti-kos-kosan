<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'Tenant') {
            // Get active or pending booking for the tenant
            $booking = \App\Models\Booking::where('user_id', $user->id)
                ->whereIn('status', ['Active', 'Pending'])
                ->latest()
                ->first();

            $latestPayment = null;
            if ($booking) {
                // Get payment for current month
                $latestPayment = \App\Models\Payment::where('booking_id', $booking->id)
                    ->whereMonth('payment_date', date('m'))
                    ->whereYear('payment_date', date('Y'))
                    ->latest()
                    ->first();
            }

            return view('dashboard.index', [
                'title' => 'Dashboard',
                'booking' => $booking,
                'latestPayment' => $latestPayment,
            ]);
        }

        // Logic for Superadmin & Admin
        $totalUsers = \App\Models\User::count();
        $superadminCount = \App\Models\User::where('role', 'Superadmin')->count();
        $adminCount = \App\Models\User::where('role', 'Admin')->count();

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'totalUsers' => $totalUsers,
            'superadminCount' => $superadminCount,
            'adminCount' => $adminCount,
        ]);
    }

    public function show()
    {
        return view('dashboard.show', [
            'title' => 'My Profile',
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('dashboard.edit', [
            'title' => 'Edit Profile',
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $validate = $request->validate([
                'name' => 'required',
                'password' => 'nullable|min:8',
                'passwordconfirm' => 'nullable|same:password',
                'email' => 'required|email|lowercase|unique:users,email,' . $user->id,
                'avatar' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:512'
            ], [
                'name.required' => 'Nama wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'passwordconfirm.same' => 'Konfirmasi password tidak cocok',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'avatar.image' => 'File avatar harus berupa gambar',
                'avatar.mimes' => 'Format avatar harus png, jpg, jpeg, atau svg',
                'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 512 KB',
            ]);

            if ($request->file('avatar')) {
                $validate['avatar'] = $request->file('avatar')->store('img', 'public');
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            if ($request->password) {
                $validate['password'] = bcrypt($request->password);
            } else {
                unset($validate['password']);
            }
            $user->update($validate);

            DB::commit();
            return to_route('dashboard.show')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('dashboard.edit')->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function announcement()
    {
        return view('dashboard.announcement', [
            'title' => 'Pengumuman Kos'
        ]);
    }
}
