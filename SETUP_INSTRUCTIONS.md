# Instruksi Setup Aplikasi Laundry

Aplikasi ini sekarang sudah dilengkapi dengan file-file penting untuk menjalankan Laravel. Ikuti langkah-langkah berikut:

## 1. Install Dependencies

Jalankan perintah berikut untuk menginstall semua package yang diperlukan:

```bash
composer install
```

## 2. Setup Environment File

Buat file `.env` di root direktori proyek. Anda bisa:
- Salin dari file `ENV_SETUP.md` (lihat konten di file tersebut)
- Atau buat manual dengan konfigurasi database Anda

**Penting:** Sesuaikan konfigurasi database:
- `DB_DATABASE=laundry_app` (nama database Anda)
- `DB_USERNAME=root` (username MySQL Anda)
- `DB_PASSWORD=` (password MySQL Anda, kosongkan jika tidak ada)

## 3. Generate Application Key

Setelah membuat file `.env`, generate application key:

```bash
php artisan key:generate
```

## 4. Buat Database

Buat database MySQL dengan nama sesuai yang ada di file `.env` (default: `laundry_app`):

```sql
CREATE DATABASE laundry_app;
```

Atau melalui command line:
```bash
mysql -u root -p -e "CREATE DATABASE laundry_app;"
```

## 5. Jalankan Migrations

Jalankan migrasi untuk membuat tabel-tabel di database:

```bash
php artisan migrate
```

Ini akan membuat tabel:
- `customers`
- `services`
- `orders`
- `order_service` (pivot table)
- `payments`
- `sessions` (untuk session storage)
- `migrations` (untuk tracking migrasi)

## 6. Buat Folder Storage (jika belum ada)

Pastikan folder storage ada dan memiliki permission yang benar:

```bash
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## 7. Jalankan Aplikasi

Jalankan server development:

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 8. Akses Aplikasi

Buka browser dan akses:
- **URL:** http://localhost:8000
- **Dashboard:** Otomatis redirect ke halaman Orders
- **Menu Navigasi:**
  - Customers (Pelanggan)
  - Services (Layanan)
  - Orders (Pesanan)
  - Payments (Pembayaran)
  - Reports (Laporan)

## Troubleshooting

### Error: "Class 'App\Http\Kernel' not found"
- Pastikan sudah menjalankan `composer install`

### Error: "No application encryption key has been specified"
- Jalankan `php artisan key:generate`

### Error: "SQLSTATE[HY000] [1049] Unknown database"
- Pastikan database sudah dibuat dan nama di `.env` sesuai

### Error: "The stream or file could not be opened"
- Pastikan folder `storage` dan `bootstrap/cache` ada dan memiliki permission write

### Error: "Route [login] not defined"
- Ini normal, aplikasi ini tidak menggunakan authentication. Error ini hanya muncul jika middleware auth dipanggil.

## Fitur Aplikasi

✅ **Customers** - Kelola data pelanggan
✅ **Services** - Kelola layanan laundry (cuci, setrika, dry cleaning, dll)
✅ **Orders** - Buat dan kelola pesanan dengan multiple services
✅ **Payments** - Catat pembayaran untuk setiap pesanan
✅ **Reports** - Lihat laporan pesanan dan pendapatan

## Catatan

- Aplikasi ini menggunakan Bootstrap 5 untuk UI
- Session disimpan di database (sesuai konfigurasi default)
- Tidak ada sistem authentication (semua fitur bisa diakses langsung)

