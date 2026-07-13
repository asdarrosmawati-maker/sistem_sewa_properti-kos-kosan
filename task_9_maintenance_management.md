# Task 9: Pengaduan Perbaikan (Maintenance Request)

## Objektif
Memfasilitasi penyewa (*Tenant*) untuk dapat melaporkan keluhan atau kerusakan fasilitas kamar/kos (misalnya AC bocor, kran rusak) langsung kepada *Owner*.

## Ruang Lingkup Pekerjaan
1. **Database & Migration:**
   - Buat migration tabel `maintenance_requests`.
   - Kolom: `id`, `booking_id` (foreign key ke bookings), `user_id` (foreign key ke users penyewa), `issue_description` (text), `status` (enum: Pending, In Progress, Resolved), `created_at`, `updated_at`.

2. **Seeder (Data Dummy):**
   - Buat `MaintenanceSeeder.php`.
   - Siapkan setidaknya 2 pengaduan dummy dengan status yang berbeda untuk pengujian tabel di dashboard Owner.

3. **Logika CRUD (MaintenanceController.php):**
   - Tenant dapat melakukan operasi *Create* (mengirim laporan) dan *Read* (melihat laporan miliknya sendiri).
   - Owner dapat melakukan operasi *Update* untuk mengganti status penyelesaian (dari Pending ke Resolved).
   - **Aturan Ketat (Coding Style):** Penulisan array validasi (message Indonesia), penggunaan *Transaction Database* pada saat *Create* atau *Update*, wajib meniru struktur yang sama dengan modul bawaan.

4. **Model (MaintenanceRequest.php):**
   - Definisikan fungsi relasi `booking()` dan `user()`.

5. **View (UI):**
   - Buat form pengaduan di panel dashboard penyewa.
   - Buat tabel keluhan pada panel dashboard Owner.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Laporan pengaduan bisa disimpan dan muncul pada dashboard Owner yang bersangkutan.
- [ ] Data dummy `maintenance_requests` dapat dimasukkan tanpa masalah constraint foreign key.
