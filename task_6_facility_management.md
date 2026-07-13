# Task 6: Manajemen Fasilitas (Facility Management)

## Objektif
Mengelola daftar fasilitas yang ditawarkan oleh suatu kos-kosan atau properti (misal: AC, WiFi, Dapur Bersama). Fitur ini memperkaya informasi properti saat calon penyewa mencari kos.

## Ruang Lingkup Pekerjaan
1. **Database & Migration:**
   - Buat migration untuk tabel `facilities`.
   - Kolom: `id`, `property_id` (foreign key ke properties), `name` (string), `icon` (string/nullable, untuk icon font-awesome), `description` (text/nullable), `created_at`, `updated_at`.

2. **Seeder (Data Dummy):**
   - Buat `FacilitySeeder.php`.
   - Siapkan setidaknya 3 fasilitas umum untuk masing-masing properti yang dibuat pada property seeder.

3. **Logika CRUD (FacilityController.php):**
   - Buat Controller dengan fungsi CRUD untuk mengelola fasilitas properti milik *Owner*.
   - **Aturan Ketat (Coding Style):** Wajib konsisten dengan pola yang ada pada `UserController`, termasuk penanganan error menggunakan `try-catch` dan `DB::beginTransaction()`.

4. **Model (Facility.php):**
   - Definisikan fungsi relasi `property()` (belongsTo).

5. **View (UI):**
   - Integrasikan ke dalam halaman detail properti milik *Owner* atau buat manajemen terpisah untuk `facilities`.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Tabel `facilities` berhasil bermigrasi.
- [ ] Data dummy fasilitas masuk ke database.
- [ ] Modul penambahan fasilitas bisa digunakan dengan aman.
