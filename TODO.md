# TODO List - Laundry App Feature Implementation

## Phase 1: Core Foundation Enhancements ✅ COMPLETED

### 1.1 Multi-user & Roles ✅

- [x] Buat migration untuk roles table
- [x] Setup Spatie Laravel Permission
- [x] Tambah role column di users table
- [x] Buat RoleSeeder
- [x] Update AuthController untuk role-based redirect
- [x] Tambah middleware untuk role check
- [x] Update navigation berdasarkan role
- [x] Update User model

### 1.2 Service Categories ✅

- [x] Buat migration service_categories table
- [x] Buat ServiceCategory model
- [x] Buat ServiceCategoryController
- [x] Tambah routes untuk CRUD categories
- [x] Update Service model (belongsTo category)
- [x] Buat views untuk category management
- [x] Update Service views untuk dropdown category

### 1.3 Service Management Enhancements ✅

- [x] Tambah fields: category_id, pricing_tier, duration_minutes, is_available
- [x] Update ServiceController
- [x] Update Service views dengan pricing tiers
- [ ] Tambah service packages/bundles (optional - Future)

---

## Phase 2: Payment Features

### 2.1 Multiple Payments

- [ ] Update Payment model (nullable amount, tambahkan is_partial flag)
- [ ] Update PaymentController untuk partial payments
- [ ] Update Order model (computed paid_amount, payment_status)
- [ ] Buat migration tambahkan payment_status di orders
- [ ] Update Order views dengan payment status badge

### 2.2 Payment Methods

- [ ] Tambah enum/const untuk payment methods
- [ ] Update Payment views dengan method selector
- [ ] Update PaymentController validation

### 2.3 Payment Tracking

- [ ] Tampilkan outstanding amount di Order show
- [ ] history view Buat Payment per order
- [ ] Tampilkan payment history per customer

---

## Phase 3: Invoice & Billing

### 3.1 Invoice System

- [ ] Buat invoices table
- [ ] Buat Invoice model
- [ ] Buat InvoiceController
- [ ] Auto-generate invoice number
- [ ] Generate invoice PDF (dompdf)
- [ ] Invoice views (HTML template)

### 3.2 Invoice Features

- [ ] Email invoice ke customer
- [ ] Invoice history view
- [ ] Download invoice PDF
- [ ] Update order status integration

---

## Phase 4: Notifications & Reminders

### 4.1 Email Notifications

- [ ] Setup mail config di .env
- [ ] Buat notification classes
- [ ] Order confirmation email
- [ ] Order completion email
- [ ] Payment confirmation email
- [ ] Payment reminder email

### 4.2 SMS/WhatsApp (Optional)

- [ ] Setup Twilio/WhatsApp API
- [ ] Notification channels
- [ ] SMS templates

---

## Phase 5: Search & Filter

### 5.1 Advanced Search

- [ ] Global search functionality
- [ ] Order search (customer, date, status)
- [ ] Date range picker
- [ ] Multi-column sorting
- [ ] Quick filter buttons

---

## Phase 6: Reports & Analytics

### 6.1 Dashboard

- [ ] Real-time stats cards
- [ ] Sales charts (Chart.js)
- [ ] Top customers widget
- [ ] Popular services widget
- [ ] Orders needing attention

### 6.2 Reports

- [ ] Daily/Monthly/Yearly reports
- [ ] Per customer reports
- [ ] Per service reports
- [ ] Revenue charts
- [ ] Profit margin reports

### 6.3 Export

- [ ] Excel export (Maatwebsite)
- [ ] PDF export untuk reports
- [ ] Backup data feature

---

## Phase 7: Financial Reports

- [ ] Cash flow report
- [ ] Profit & loss statement
- [ ] Accounts receivable
- [ ] Payment reconciliation

---

## Phase 8: Communication

- [ ] SMS/WhatsApp integration
- [ ] Email marketing
- [ ] Broadcast notifications
- [ ] Customer communication history

---

## Commands Reference

```bash
# Create new feature
php artisan make:model Models/FeatureName -mcr
php artisan make:request FeatureNameRequest
php artisan make:mail FeatureNameMail
php artisan make:notification FeatureNameNotification

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed --class=RoleSeeder

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Create storage link
php artisan storage:link
```

---

_Created: 2025-12-27_
_Phase 1 Completed: 2025-12-27_
