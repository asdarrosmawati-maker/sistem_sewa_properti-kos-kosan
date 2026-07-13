# Task 7: Manajemen Ulasan (Review Management)

## Objektif
Memberikan sarana bagi penyewa (*Tenant*) untuk menuliskan ulasan dan memberikan rating pada kos-kosan/kamar setelah masa penyewaan selesai. Ini membangun sistem reputasi kos di aplikasi.

## Ruang Lingkup Pekerjaan
1. **Database & Migration:**
   - Buat migration untuk tabel `reviews`.
   - Kolom: `id`, `booking_id` (foreign key ke bookings), `user_id` (foreign key ke users penyewa), `rating` (integer, misal: 1-5), `comment` (text), `created_at`, `updated_at`.

2. **Seeder (Data Dummy):**
   - Buat `ReviewSeeder.php`.
   - Siapkan setidaknya 2 ulasan *dummy* untuk data pemesanan yang statusnya sudah `Completed`.

3. **Logika CRUD (ReviewController.php):**
   - Buat Controller dengan fungsi simpan untuk Tenant dan fungsi baca (read-only) untuk Owner.
   - **Aturan Ketat (Coding Style):** Validasi form harus ketat untuk batas angka rating (`min:1|max:5`). Blok simpan dibungkus menggunakan arsitektur bawaan (`DB::beginTransaction()`, `try-catch`, redirect `withSuccess()`/`withError()`).

4. **Model (Review.php):**
   - Definisikan fungsi relasi `booking()` (belongsTo) dan `user()` (belongsTo).

5. **View (UI):**
   - Form penulisan ulasan untuk Tenant setelah tagihan sewa selesai.
   - Menampilkan ulasan tersebut di halaman detail properti publik.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Tabel `reviews` terbuat dengan lancar dan berelasi ke `booking` & `user`.
- [ ] Tersedia setidaknya 2 ulasan dummy yang bisa dimunculkan di halaman antarmuka.
- [ ] Tenant tidak bisa memberikan review dua kali untuk *booking* yang sama (logic controller valid).
