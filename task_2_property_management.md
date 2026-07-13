# Task 2: Manajemen Properti / Kos-kosan (Property Management)

## Objektif
Membangun fitur pengelolaan data properti (Kos-kosan) untuk peran *Owner* dan *Admin*. Fitur ini memungkinan penambahan informasi bangunan kos sebelum kamar-kamarnya didefinisikan.

## Ruang Lingkup Pekerjaan
1. **Database & Migration:**
   - Buat migration untuk tabel `properties`.
   - Kolom: `id`, `user_id` (foreign key ke users), `name`, `description`, `address`, `created_at`, `updated_at`.
   - Setup relasi *One-to-Many* antara tabel `users` (Owner) dan `properties`.

2. **Seeder (Data Dummy):**
   - Buat `PropertySeeder.php`.
   - Wajib membuat minimal 3 data dummy properti yang terhubung secara valid ke `user_id` yang memiliki role `Owner`. Hal ini berguna untuk memvisualisasikan data pada dashboard atau halaman listing.

3. **Logika CRUD (PropertyController.php):**
   - Buat Controller dengan fungsi CRUD standar.
   - **Aturan Ketat (Coding Style):** Wajib mereplikasi arsitektur dari modul `UserController`. 
     - Penanganan request form harus menggunakan validasi array yang sama lengkap dengan pesan kustomnya.
     - Blok kode simpan/ubah/hapus database harus dibungkus dengan `DB::beginTransaction()`, `try-catch`, `DB::commit()`, dan `DB::rollBack()`.
     - Gunakan penamaan route resourse (`property.index`, `property.create`, dll).

4. **Model (Property.php):**
   - Definisikan fungsi relasi `user()` (belongsTo).

5. **View (UI):**
   - Siapkan view `index`, `create`, `edit`, `show` di dalam folder `resources/views/property/`.
   - Pastikan layout HTML konsisten dengan template yang ada saat ini.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Tabel `properties` terbentuk tanpa eror saat migrasi.
- [ ] Menjalankan seeder langsung memunculkan dummy data di tabel `properties`.
- [ ] User dengan role Owner/Admin dapat melakukan CRUD properti tanpa error database.
- [ ] Coding style Controller persis dan konsisten dengan pola `UserController`.
