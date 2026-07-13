# Task 8: Manajemen Galeri (Gallery Management)

## Objektif
Membangun fitur manajemen galeri foto untuk setiap properti atau kamar, memungkinkan *Owner* mengunggah beberapa foto yang akan ditampilkan sebagai *slider/carousel* di halaman detail.

## Ruang Lingkup Pekerjaan
1. **Database & Migration:**
   - Buat migration tabel `galleries`.
   - Kolom: `id`, `property_id` (foreign key ke properties), `room_id` (nullable foreign key ke rooms), `image_path` (string), `caption` (nullable string), `created_at`, `updated_at`.

2. **Seeder (Data Dummy):**
   - Buat `GallerySeeder.php`.
   - Siapkan setidaknya 3 data dummy yang merujuk ke gambar placeholder untuk masing-masing properti yang disemai sebelumnya.

3. **Logika CRUD (GalleryController.php):**
   - Fitur *Multiple Upload* gambar di dalam controller.
   - **Aturan Ketat (Coding Style):** File harus disimpan menggunakan metode storage Laravel standar (disk public). Seperti pada Controller lain, operasi *insert* DB harus dibungkus dengan `DB::beginTransaction()`, dan jika terjadi error/gagal simpan, file yang terupload wajib dihapus (`Storage::disk('public')->delete()`).

4. **Model (Gallery.php):**
   - Definisikan fungsi relasi `property()` (belongsTo) dan `room()` (belongsTo).

5. **View (UI):**
   - Form penambahan galeri di dashboard Owner (halaman detail properti).

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Tabel `galleries` berhasil bermigrasi.
- [ ] Upload gambar berfungsi tanpa error, dan path gambar tersimpan dengan benar.
- [ ] File fisik gambar akan otomatis dihapus jika terjadi *rollback* database (simulasi error tersimpan).
