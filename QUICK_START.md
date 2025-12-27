# Quick Start Guide

Panduan cepat untuk menjalankan aplikasi laundry ini.

## Langkah Cepat (5 Menit)

```bash
# 1. Install dependencies
composer install

# 2. Buat file .env (lihat ENV_SETUP.md untuk konten lengkap)
# Edit file .env dan sesuaikan konfigurasi database

# 3. Generate app key
php artisan key:generate

# 4. Buat database
mysql -u root -p -e "CREATE DATABASE laundry_app;"

# 5. Jalankan migrasi
php artisan migrate

# 6. Jalankan aplikasi
php artisan serve
```

Buka browser: http://localhost:8000

## Konfigurasi Database Minimal di .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laundry_app
DB_USERNAME=root
DB_PASSWORD=
```

## Troubleshooting

**Error: "Class not found"**
- Jalankan: `composer install`

**Error: "No application encryption key"**
- Jalankan: `php artisan key:generate`

**Error: "Unknown database"**
- Pastikan database sudah dibuat
- Cek nama database di file `.env`

**Error: "Permission denied" pada storage**
- Jalankan: `chmod -R 775 storage bootstrap/cache`

## Fitur Aplikasi

✅ Kelola Pelanggan (Customers)
✅ Kelola Layanan (Services)  
✅ Buat Pesanan (Orders) dengan multiple services
✅ Catat Pembayaran (Payments)
✅ Lihat Laporan (Reports)

Selamat menggunakan! 🎉

