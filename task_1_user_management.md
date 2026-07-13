# Task 1: Manajemen Pengguna & Autentikasi (User Management)

## Objektif
Menyesuaikan sistem autentikasi dan manajemen pengguna yang sudah ada di Laravel agar selaras dengan spesifikasi peran (role) pada PRD, yaitu: **Admin**, **Owner**, dan **Tenant**.

## Ruang Lingkup Pekerjaan
1. **Database & Migration:**
   - Sesuaikan migration tabel `users` yang sudah ada. 
   - Pastikan kolom `role` menggunakan tipe data `enum` atau `string` dengan validasi constraint (Admin, Owner, Tenant).

2. **Seeder (Data Dummy):**
   - Perbarui `UserSeeder.php` dan/atau `UserFactory.php`.
   - Wajib membuat data dummy minimal 1 untuk masing-masing role (1 Admin, 1 Owner, 1 Tenant) agar visualisasi data role dapat langsung terlihat pada halaman manajemen user.

3. **Logika CRUD (UserController.php):**
   - Sesuaikan logika *Create, Read, Update, Delete* pada `UserController` agar memproses field `role` secara benar berdasarkan PRD.
   - **Aturan Ketat (Coding Style):** Wajib menggunakan pola struktur yang sudah ada pada modul user saat ini. 
     - Gunakan `DB::beginTransaction()`, `DB::commit()`, dan `DB::rollBack()` di dalam blok `try...catch`.
     - Pertahankan penulisan array pesan error kustom pada fungsi `validate()`.
     - Pertahankan penggunaan return redirect `to_route(...)->withSuccess(...)` atau `withError(...)`.
     - *Dilarang membuat pola routing atau respon baru yang tidak konsisten dengan gaya kode yang sudah berjalan.*

4. **View (UI):**
   - Sesuaikan *form select* input untuk `role` pada view `create` dan `edit` agar memunculkan pilihan Admin, Owner, dan Tenant.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Migration tabel user berhasil dijalankan tanpa membuang tabel yang sudah ada secara paksa (buat migration update/modify jika perlu).
- [ ] Seeder berhasil berjalan dan mengisi database dengan 3 tipe role pengguna.
- [ ] Admin dapat menambahkan, mengedit, melihat, dan menghapus *Owner* dan *Tenant* melalui antarmuka web.
- [ ] Gaya penulisan kode (`UserController`) tetap konsisten 100% dengan kondisi aslinya.
