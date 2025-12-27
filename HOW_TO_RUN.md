# Cara Menjalankan Aplikasi Laundry

## Status Saat Ini ✅
- **Server sudah berjalan** di background
- **Port:** 8000
- **URL:** http://localhost:8000

## Cara Menjalankan

### 1. Jika Server Belum Berjalan

Buka terminal dan jalankan:

```bash
cd /Users/gavinadlan/Documents/code/laundry_app
php artisan serve
```

Output yang akan muncul:
```
INFO  Server running on [http://127.0.0.1:8000]

  Press Ctrl+C to stop the server
```

### 2. Mengakses Aplikasi

Buka browser dan akses:
- **URL:** http://localhost:8000
- **Atau:** http://127.0.0.1:8000

### 3. Menghentikan Server

**Opsi A:** Di terminal tempat server berjalan, tekan:
```
Ctrl + C
```

**Opsi B:** Dari terminal lain, jalankan:
```bash
pkill -f "php artisan serve"
```

**Opsi C:** Cari PID dan kill:
```bash
ps aux | grep "php artisan serve" | grep -v grep
kill <PID>
```

## Cek Status Server

### Cek apakah server berjalan:
```bash
ps aux | grep "php artisan serve" | grep -v grep
```

### Cek port 8000:
```bash
lsof -i :8000
```

### Test koneksi:
```bash
curl http://localhost:8000
```

## Troubleshooting

### Error: "Port 8000 already in use"
Server sudah berjalan di port 8000. Gunakan port lain:
```bash
php artisan serve --port=8001
```

### Error: "Class not found"
Jalankan:
```bash
composer install
```

### Error: "No application encryption key"
Jalankan:
```bash
php artisan key:generate
```

### Error: "Table not found"
Jalankan migrasi:
```bash
php artisan migrate
```

## Fitur Aplikasi

Setelah aplikasi berjalan, Anda bisa:
- ✅ **Customers** - Kelola data pelanggan
- ✅ **Services** - Kelola layanan laundry
- ✅ **Orders** - Buat dan kelola pesanan
- ✅ **Payments** - Catat pembayaran
- ✅ **Reports** - Lihat laporan

## Catatan

- Server development Laravel hanya untuk development, **bukan untuk production**
- Untuk production, gunakan web server seperti Apache/Nginx dengan PHP-FPM
- Default port adalah 8000, bisa diubah dengan `--port=PORT_NUMBER`

