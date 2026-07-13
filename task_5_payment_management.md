# Task 5: Manajemen Pembayaran (Payment Management)

## Objektif
Mencatat riwayat pembayaran dan bukti bayar (struk/resi) untuk tagihan-tagihan penyewaan. Mengizinkan tenant untuk mengirimkan bukti transfer dan owner untuk memverifikasi pembayaran.

## Ruang Lingkup Pekerjaan
1. **Database & Migration:**
   - Buat migration untuk tabel `payments`.
   - Kolom: `id`, `booking_id` (foreign key ke bookings), `amount` (decimal), `payment_date` (date), `proof_of_payment` (string/text, untuk path gambar resi), `status` (enum: Pending, Verified, Rejected), `created_at`, `updated_at`.

2. **Seeder (Data Dummy):**
   - Buat `PaymentSeeder.php`.
   - Wajib membuat minimal 3 data dummy pembayaran untuk proses visualisasi laporan pada profil Owner maupun Tenant.

3. **Logika CRUD (PaymentController.php):**
   - Buat Controller transaksi pembayaran.
   - **Aturan Ketat (Coding Style):** Seperti pola pada `UserController`, logika penyimpanan berkas (upload file resi) harus di-handle dengan menggunakan `Storage::disk('public')->put()` atau fungsi bawaan Laravel di dalam blok transaction. Jika proses insert gagal (throw exception), maka berkas gambar yang telanjur terupload harus dihapus dengan `Storage::disk('public')->delete()` untuk menghindari penumpukan file "*orphan/junk*".
   
4. **Model (Payment.php):**
   - Definisikan fungsi relasi `booking()` (belongsTo).

5. **View (UI):**
   - Form upload file bukti bayar untuk Tenant.
   - Tabel validasi bukti bayar untuk Owner (menyetujui / menolak).

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Tabel `payments` berhasil di-*migrate* beserta *foreign key constraint* yang relevan.
- [ ] Data dummy pembayaran berhasil masuk via *seeder*.
- [ ] Validasi file tipe dan ukuran gambar (mime:png,jpg) diaplikasikan persis seperti validasi `avatar` pada UserController.
- [ ] Implementasi rollback file storage berfungsi dengan baik jika simulasi database eror dilakukan.
