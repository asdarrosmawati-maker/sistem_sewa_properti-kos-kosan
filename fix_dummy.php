<?php

$mainTenant = App\Models\User::whereNotIn('email', [
    'tenant1@example.com', 
    'tenant2@example.com', 
    'tenant3@example.com', 
    'tenant4@example.com', 
    'tenant5@example.com'
])->where('role', 'Tenant')->first();

if ($mainTenant) {
    $dummyEmails = ['tenant1@example.com', 'tenant2@example.com', 'tenant3@example.com', 'tenant4@example.com', 'tenant5@example.com'];
    $dummyUsers = App\Models\User::whereIn('email', $dummyEmails)->get();
    $dummyIds = $dummyUsers->pluck('id')->toArray();
    
    if (!empty($dummyIds)) {
        // Reassign data
        App\Models\Booking::whereIn('user_id', $dummyIds)->update(['user_id' => $mainTenant->id]);
        App\Models\Review::whereIn('user_id', $dummyIds)->update(['user_id' => $mainTenant->id]);
        App\Models\MaintenanceRequest::whereIn('user_id', $dummyIds)->update(['user_id' => $mainTenant->id]);
        
        // Delete dummy users
        App\Models\User::whereIn('id', $dummyIds)->delete();
        echo "Akun Penyewa 1-5 berhasil dihapus dan datanya dipindahkan ke: " . $mainTenant->name;
    } else {
        echo "Akun Penyewa 1-5 sudah tidak ada di database.";
    }
} else {
    echo "Tenant utama tidak ditemukan.";
}
