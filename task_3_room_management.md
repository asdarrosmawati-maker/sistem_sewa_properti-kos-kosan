# Task 3: Manajemen Kamar (Room Management)

## Objektif
Membangun fitur pengelolaan data kamar yang menempel pada sebuah properti (Kos-kosan). Fitur ini mengatur detail kamar beserta harga dan status ketersediaannya.

## Ruang Lingkup Pekerjaan
1. **Database & Migration:**
   - Buat migration untuk tabel `rooms`.
   - Kolom: `id`, `property_id` (foreign key ke properties), `room_number`, `price_per_month` (decimal), `status` (string/enum: Available, Occupied, Maintenance), `created_at`, `updated_at`.
   - Setup relasi *One-to-Many* antara `properties` dan `rooms`.

2. **Seeder (Data Dummy):**
   - Buat `RoomSeeder.php`.
   - Wajib membuat minimal 5 data dummy kamar yang terhubung secara acak dan valid ke `property_id` yang telah dibuat di Seeder Properti. Pastikan status ketersediaan (*Available* dan *Occupied*) bervariasi untuk visualisasi katalog.

3. **Logika CRUD (RoomController.php):**
   - Buat Controller dengan fungsi CRUD kamar.
   - **Aturan Ketat (Coding Style):** Seperti pada Task 1 dan 2, controller ini harus mewarisi pola `UserController`. Gunakan validasi yang *verbose* dengan pesan kustom bahasa Indonesia. Bungkus semua instruksi modifikasi DB dalam blok `DB::beginTransaction()` dan `try-catch`.

4. **Model (Room.php):**
   - Definisikan fungsi relasi `property()` (belongsTo) dan (nantinya) `bookings()` (hasMany).

5. **View (UI):**
   - Siapkan view `index`, `create`, `edit`, `show` di dalam folder `resources/views/room/`.
   - Fitur pilihan relasi (Select) untuk memilih `property_id` wajib ada dalam view form `create` dan `edit`.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Tabel `rooms` terbentuk di database dengan relasi yang benar terhadap `properties`.
- [ ] Data dummy kamar berhasil disuntikkan (seeded) ke dalam database.
- [ ] Halaman manajemen kamar dapat diakses dan dioperasikan sesuai pola aplikasi yang ada tanpa error arsitektur (transaction rollback berfungsi jika simulasi error).
