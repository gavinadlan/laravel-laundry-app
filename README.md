# Laundry Application

This project contains a simple laundry management system built on top of the
Laravel PHP framework. It demonstrates how to manage customers, services,
orders, payments and basic reporting within a typical Laravel application.

## Features

* **Customers**: Add, edit, view and delete customers. Each customer has a
  name, email, phone number and address. Customers can place multiple orders.
* **Services**: Define the services offered by your laundry business such as
  washing, dry‐cleaning or ironing. Each service has a name, price and
  optional description.
* **Orders**: Create orders for a customer by selecting one or more services
  and specifying quantities. Orders track the order and delivery dates,
  status (`pending`, `in_progress`, `completed` or `delivered`) and optional
  notes. The total cost of an order is automatically calculated from the
  selected services and quantities.
* **Payments**: Record payments against orders including the amount, payment
  date, method and an optional reference. Payments are linked directly to an
  order and can be viewed or deleted.
* **Reports**: A simple report summarises the number of orders in each state
  and the total revenue from recorded payments.

## Installation

Aplikasi ini sudah dilengkapi dengan semua file yang diperlukan untuk menjalankan Laravel. Ikuti langkah-langkah berikut:

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Extension PHP: PDO, mbstring, openssl, tokenizer, xml, ctype, json

### Setup Steps

1. **Install dependencies**:

   ```bash
   composer install
   ```

2. **Setup environment file**:

   Buat file `.env` di root direktori. Anda bisa:
   - Salin konten dari file `ENV_SETUP.md`
   - Atau buat manual dengan konfigurasi berikut:
   
   ```env
   APP_NAME=LaundryApp
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laundry_app
   DB_USERNAME=root
   DB_PASSWORD=
   
   SESSION_DRIVER=database
   ```

3. **Generate application key**:

   ```bash
   php artisan key:generate
   ```

4. **Create database**:

   Buat database MySQL:
   ```sql
   CREATE DATABASE laundry_app;
   ```
   
   Atau via command line:
   ```bash
   mysql -u root -p -e "CREATE DATABASE laundry_app;"
   ```

5. **Run migrations**:

   ```bash
   php artisan migrate
   ```

   Ini akan membuat tabel:
   - `customers` - Data pelanggan
   - `services` - Layanan laundry
   - `orders` - Pesanan
   - `order_service` - Relasi pesanan dan layanan
   - `payments` - Pembayaran
   - `sessions` - Session storage
   - `cache` - Cache storage
   - `jobs` - Queue jobs (jika diperlukan)
   - `migrations` - Tracking migrasi

6. **Setup storage permissions** (jika diperlukan):

   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

7. **Serve the application**:

   ```bash
   php artisan serve
   ```

Aplikasi akan berjalan di `http://localhost:8000`

**Catatan:** Untuk instruksi lebih detail, lihat file `SETUP_INSTRUCTIONS.md`

## Usage

Once running, use the navigation bar to manage customers, services, orders,
payments and view reports. Orders can include multiple services. Payments are
recorded separately and linked to an order.

## License

This project is provided for educational purposes and does not carry a
specific software license. You may use and modify it for your own projects.