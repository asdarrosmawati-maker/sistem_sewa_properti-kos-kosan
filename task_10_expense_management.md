# Task 10: Pencatatan Pengeluaran (Expense Management)

## Objektif
Memberikan fitur khusus bagi *Owner* kos untuk mencatat semua pengeluaran operasional (seperti tagihan listrik, air, gaji penjaga, atau perawatan rutin). Fitur ini penting untuk menghasilkan laporan laba-rugi kotor di masa mendatang.

## Ruang Lingkup Pekerjaan
1. **Database & Migration:**
   - Buat migration tabel `expenses`.
   - Kolom: `id`, `property_id` (foreign key ke properties), `description` (string), `amount` (decimal), `expense_date` (date), `created_at`, `updated_at`.

2. **Seeder (Data Dummy):**
   - Buat `ExpenseSeeder.php`.
   - Masukkan minimal 3 data pengeluaran dummy untuk properti yang telah di-*seed*, dengan tanggal dan deskripsi bervariasi.

3. **Logika CRUD (ExpenseController.php):**
   - Buat Controller CRUD lengkap untuk tabel `expenses`. 
   - Modul ini khusus diakses oleh Owner/Admin.
   - **Aturan Ketat (Coding Style):** Seperti pada modul lainnya, semua proses insert/update/delete wajib dibungkus dengan `DB::beginTransaction()` dan memiliki pesan error bawaan (custom validation array message).

4. **Model (Expense.php):**
   - Definisikan fungsi relasi `property()` (belongsTo).

5. **View (UI):**
   - Tambahkan menu "Pengeluaran" (Expenses) pada *sidebar* dashboard untuk Owner.
   - Buat tampilan tabel dan *form* penginputan biaya.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Tabel `expenses` terhubung dengan benar ke `properties`.
- [ ] Proses *seed* data dummy pengeluaran berfungsi normal.
- [ ] Coding style Controller tidak melenceng dari standar aplikasi.
