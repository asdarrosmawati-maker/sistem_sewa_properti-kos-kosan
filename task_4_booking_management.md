# Task 4: Manajemen Pemesanan/Sewa (Booking Management)

## Objektif
Mengelola proses bisnis inti, yaitu pemesanan kamar (Booking) oleh Penyewa (*Tenant*) kepada *Owner*. Menangani siklus penyewaan dari mulai Pending, Active, hingga Completed.

## Ruang Lingkup Pekerjaan
1. **Database & Migration:**
   - Buat migration untuk tabel `bookings`.
   - Kolom: `id`, `user_id` (foreign key ke penyewa/tenant), `room_id` (foreign key ke rooms), `start_date` (date), `end_date` (date), `total_price` (decimal), `status` (enum: Pending, Active, Completed, Rejected, dll), `created_at`, `updated_at`.

2. **Seeder (Data Dummy):**
   - Buat `BookingSeeder.php`.
   - Wajib membuat minimal 5 riwayat data pemesanan (kombinasi status Pending dan Active) dengan memasangkan data dummy `Tenant` dan `Rooms` yang tersedia. Ini penting untuk visualisasi *history* pada *Dashboard*.

3. **Logika CRUD (BookingController.php):**
   - Buat Controller transaksi pemesanan.
   - **Aturan Ketat (Coding Style):** Sesuai konvensi `UserController`. Terutama, simpan data menggunakan `DB::beginTransaction()`. Pada saat insert data `booking` berhasil disetujui (status -> Active), sistem juga harus mengubah status kamar di tabel `rooms` menjadi *Occupied*. Ini memerlukan penanganan multiple-table update dalam satu *database transaction* agar aman (ACID compliance).

4. **Model (Booking.php):**
   - Definisikan fungsi relasi `user()` (belongsTo), `room()` (belongsTo), dan `payments()` (hasMany).

5. **View (UI):**
   - Halaman `index` khusus untuk Owner (melihat pemesanan masuk) dan Tenant (melihat riwayat pesanan sendiri).
   - Halaman persetujuan form (*approval* status).

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Tabel `bookings` terbentuk di database dan memiliki relasi ke User (Tenant) dan Room.
- [ ] Data dummy `bookings` bisa dimuat via Artisan db:seed tanpa konfilk *foreign key*.
- [ ] Jika terjadi *exception* saat memproses booking, status kamar (`rooms`) dan riwayat `bookings` akan di-rollback kembali utuh (Transaction Pattern Terverifikasi).
