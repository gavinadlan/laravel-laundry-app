# Setup Database dengan MAMP

Karena MySQL dari MAMP tidak ada di PATH sistem, ada beberapa cara untuk membuat database:

## Opsi 1: Menggunakan phpMyAdmin (Paling Mudah) ✅

1. Pastikan MAMP sudah running
2. Buka browser dan akses: **http://localhost/phpMyAdmin** (atau http://localhost:8888/phpMyAdmin jika port berbeda)
3. Login dengan:
   - Username: `root`
   - Password: `root` (atau password yang Anda set di MAMP)
4. Klik tab **"SQL"** di bagian atas
5. Jalankan query berikut:
   ```sql
   CREATE DATABASE laundry_app;
   ```
6. Klik **"Go"** atau tekan Enter

## Opsi 2: Menggunakan Path Lengkap MySQL MAMP

Jika MAMP terinstall di lokasi default, gunakan:

```bash
/Applications/MAMP/Library/bin/mysql -u root -proot -e "CREATE DATABASE laundry_app;"
```

**Catatan:** Ganti `-proot` dengan password MySQL Anda jika berbeda. Formatnya adalah `-p` diikuti langsung password tanpa spasi.

## Opsi 3: Menambahkan MAMP ke PATH (Permanen)

Tambahkan ke file `~/.zshrc`:

```bash
echo 'export PATH="/Applications/MAMP/Library/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc
```

Setelah itu, Anda bisa menggunakan `mysql` langsung.

## Opsi 4: Menggunakan SQLite (Alternatif Mudah)

Jika tidak ingin repot dengan MySQL, Anda bisa menggunakan SQLite:

1. Edit file `.env` dan ubah:
   ```env
   DB_CONNECTION=sqlite
   # Hapus atau comment baris DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
   ```

2. Buat file database SQLite:
   ```bash
   touch database/database.sqlite
   ```

3. Jalankan migrasi:
   ```bash
   php artisan migrate
   ```

## Konfigurasi .env untuk MAMP

Pastikan file `.env` Anda memiliki konfigurasi berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=laundry_app
DB_USERNAME=root
DB_PASSWORD=root
```

**Catatan:** 
- Port default MAMP untuk MySQL adalah `8889` (bukan 3306)
- Password default MAMP biasanya `root`, tapi bisa berbeda tergantung konfigurasi Anda

## Verifikasi Koneksi

Setelah membuat database, test koneksi dengan:

```bash
php artisan migrate
```

Jika berhasil, tabel-tabel akan dibuat. Jika ada error, cek:
- Apakah MAMP sudah running?
- Apakah port MySQL benar (biasanya 8889)?
- Apakah username dan password benar?

