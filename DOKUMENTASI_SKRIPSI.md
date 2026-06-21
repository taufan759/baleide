# DOKUMENTASI SKRIPSI

## Sistem Penjualan E-Book Digital Berbasis Web (Baleide)

---

## 1. JUDUL PENELITIAN

**"Rancang Bangun Sistem Penjualan E-Book Digital Berbasis Web Menggunakan Framework Laravel dengan Integrasi Payment Gateway Midtrans"**

---

## 2. ALASAN PEMILIHAN METODE WATERFALL

### Pengertian

Metode Waterfall atau Model Air Terjun adalah pendekatan pengembangan perangkat lunak yang bersifat sekuensial dan linier. Setiap fase harus diselesaikan secara tuntas sebelum fase berikutnya dimulai, sehingga alur pengembangannya mengalir ke bawah seperti air terjun. Model ini pertama kali diperkenalkan oleh Winston W. Royce pada tahun 1970 dan hingga kini masih banyak digunakan dalam pengembangan sistem berbasis akademik maupun industri.

### Tahapan Waterfall yang Digunakan

```
[1. Requirements] → [2. System Design] → [3. Implementation] → [4. Testing] → [5. Deployment]
```

**1. Requirements Analysis (Analisis Kebutuhan)**

- Mengidentifikasi kebutuhan fungsional: manajemen ebook, transaksi, artikel, voucher diskon
- Mengidentifikasi kebutuhan non-fungsional: keamanan data, performa, kemudahan penggunaan
- Menentukan aktor sistem: Admin, User (Pembeli), Guest (Pengunjung)
- Menganalisis proses bisnis penjualan ebook digital dari pemilihan produk hingga akses konten

**2. System Design (Perancangan Sistem)**

- Perancangan basis data: ERD dan LRS dengan 12 tabel relasional
- Perancangan Use Case Diagram untuk 3 aktor dan 29 use case
- Perancangan Activity Diagram alur transaksi dan pembayaran
- Perancangan antarmuka (UI/UX) halaman publik dan dashboard admin

**3. Implementation (Implementasi)**

- Pengkodean menggunakan Laravel 10 + PHP 8.2 dengan pola arsitektur MVC
- Integrasi Midtrans Snap sebagai payment gateway dengan dukungan kartu kredit, virtual account, dan dompet digital
- Implementasi fitur upload ebook PDF, manajemen artikel dengan rich text editor, dan sistem voucher diskon
- Pengembangan dashboard admin dengan visualisasi grafik Chart.js

**4. Testing (Pengujian)**

- Pengujian Black Box Testing pada seluruh fitur fungsional
- Pengujian integrasi payment gateway menggunakan environment sandbox Midtrans
- Pengujian kompatibilitas antarmuka pada berbagai browser

**5. Deployment (Penerapan)**

- Deploy ke server hosting dengan konfigurasi PHP 8.2
- Konfigurasi domain, SSL, dan environment production

### Alasan Memilih Metode Waterfall

Pemilihan metode Waterfall pada penelitian ini didasarkan pada kesesuaian karakteristik metode dengan kondisi nyata pengembangan sistem Baleide, sebagai berikut:

**1. Kebutuhan Sistem Telah Terdefinisi dengan Jelas Sejak Awal**

Sebelum pengembangan dimulai, seluruh kebutuhan sistem sudah dapat diidentifikasi secara lengkap. Fitur-fitur utama seperti katalog ebook, keranjang belanja, proses checkout, integrasi payment gateway Midtrans, manajemen konten artikel, sistem voucher diskon, dan dashboard admin dengan grafik statistik sudah diketahui sejak tahap perencanaan. Kondisi ini sangat sesuai dengan prinsip dasar Waterfall yang mengharuskan kebutuhan sistem terdefinisi secara lengkap sebelum masuk ke fase desain dan implementasi.

**2. Ruang Lingkup Proyek Terbatas dan Terukur**

Sistem Baleide memiliki batasan yang jelas — merupakan platform penjualan ebook digital dengan fitur yang sudah ditentukan, bukan produk komersial yang terus berkembang secara dinamis. Dengan scope yang terukur, Waterfall memungkinkan perencanaan waktu dan sumber daya yang lebih akurat. Setiap fase dapat diestimasi durasinya sehingga pengembangan dapat diselesaikan sesuai target waktu penelitian.

**3. Perubahan Kebutuhan Sangat Minimal**

Dalam konteks penelitian skripsi, kebutuhan sistem tidak berubah secara signifikan selama proses pengembangan berlangsung. Berbeda dengan proyek komersial yang kebutuhannya bisa berubah sewaktu-waktu mengikuti pasar, sistem ini dikembangkan berdasarkan analisis kebutuhan yang sudah matang di awal. Waterfall sangat efektif dalam kondisi ini karena tidak dirancang untuk mengakomodasi perubahan di tengah proses.

**4. Menghasilkan Dokumentasi yang Terstruktur dan Komprehensif**

Setiap fase Waterfall menghasilkan dokumen yang dapat dijadikan bab dalam laporan skripsi. Fase analisis menghasilkan dokumen kebutuhan fungsional dan non-fungsional, fase desain menghasilkan ERD, LRS, dan Use Case Diagram, fase implementasi menghasilkan kode program, dan fase pengujian menghasilkan tabel Black Box Testing. Keteraturan dokumentasi ini sangat mendukung penulisan laporan penelitian yang sistematis.

**5. Koordinasi Tim yang Efektif dengan Pembagian Tugas Jelas**

Dengan tim yang terdiri dari 3 orang, Waterfall memungkinkan pembagian tugas yang jelas berdasarkan fase pengembangan. Setiap anggota tim dapat bekerja secara paralel pada bagian masing-masing dengan acuan dokumen yang sama dari fase sebelumnya, sehingga tidak terjadi tumpang tindih pekerjaan dan hasil akhir tetap terintegrasi dengan baik.

**6. Cocok untuk Sistem dengan Integrasi Pihak Ketiga yang Sudah Mapan**

Sistem Baleide mengintegrasikan Midtrans sebagai payment gateway yang sudah memiliki dokumentasi API yang lengkap dan stabil. Dalam kondisi ini, Waterfall lebih tepat dibanding metode iteratif karena spesifikasi integrasi sudah diketahui sejak awal dan tidak memerlukan eksplorasi berulang. Alur pembayaran dari pembuatan transaksi, pengambilan snap token, hingga callback status pembayaran dapat dirancang secara menyeluruh di fase desain sebelum diimplementasikan.

**7. Referensi Akademik yang Kuat**

Metode Waterfall memiliki landasan teori yang sangat kuat dalam literatur rekayasa perangkat lunak. Referensi dari Pressman (2010), Sommerville (2011), dan Roger S. Pressman dalam "Software Engineering: A Practitioner's Approach" mendukung penggunaan Waterfall untuk sistem dengan karakteristik seperti Baleide. Hal ini memperkuat validitas metodologi penelitian di hadapan dewan penguji.

### Perbandingan dengan Metode Lain

| Metode        | Kesesuaian       | Alasan                                                                                      |
| ------------- | ---------------- | ------------------------------------------------------------------------------------------- |
| **Waterfall** | ✅ Sangat Sesuai | Kebutuhan jelas, scope tetap, dokumentasi terstruktur, integrasi pihak ketiga sudah mapan   |
| Agile/Scrum   | ❌ Kurang Sesuai | Dirancang untuk tim besar dengan klien aktif dan kebutuhan yang berubah-ubah                |
| Prototype     | ⚠️ Cukup Sesuai  | Bisa digunakan jika ingin menonjolkan proses desain UI, namun dokumentasinya lebih kompleks |
| RAD           | ⚠️ Cukup Sesuai  | Cocok untuk timeline sangat singkat, namun kurang terstruktur untuk keperluan akademik      |
| Spiral        | ❌ Tidak Sesuai  | Terlalu kompleks, dirancang untuk proyek besar dengan risiko tinggi                         |

---

## 3. ENTITY RELATIONSHIP DIAGRAM (ERD)

### Entitas dan Atribut

#### USERS

| Atribut           | Tipe              | Keterangan           |
| ----------------- | ----------------- | -------------------- |
| id                | BIGINT (PK)       | Primary Key          |
| name              | VARCHAR(100)      | Nama pengguna        |
| email             | VARCHAR(100)      | Email unik           |
| password          | VARCHAR(255)      | Password terenkripsi |
| phone             | VARCHAR(20)       | Nomor telepon        |
| address           | TEXT              | Alamat               |
| avatar            | VARCHAR           | Foto profil          |
| role              | ENUM(admin, user) | Peran pengguna       |
| email_verified_at | TIMESTAMP         | Verifikasi email     |
| created_at        | TIMESTAMP         | Waktu dibuat         |
| updated_at        | TIMESTAMP         | Waktu diperbarui     |

#### CATEGORIES

| Atribut     | Tipe         | Keterangan        |
| ----------- | ------------ | ----------------- |
| id          | BIGINT (PK)  | Primary Key       |
| name        | VARCHAR(100) | Nama kategori     |
| slug        | VARCHAR(150) | URL-friendly name |
| description | TEXT         | Deskripsi         |
| created_at  | TIMESTAMP    |                   |
| updated_at  | TIMESTAMP    |                   |

#### EBOOKS

| Atribut     | Tipe          | Keterangan             |
| ----------- | ------------- | ---------------------- |
| id          | BIGINT (PK)   | Primary Key            |
| category_id | BIGINT (FK)   | Relasi ke categories   |
| title       | VARCHAR(150)  | Judul ebook            |
| slug        | VARCHAR(180)  | URL-friendly title     |
| author      | VARCHAR(100)  | Penulis                |
| isbn        | VARCHAR(20)   | Nomor ISBN             |
| description | TEXT          | Deskripsi              |
| price       | DECIMAL(12,2) | Harga                  |
| stock       | INTEGER       | Stok                   |
| total_pages | INTEGER       | Jumlah halaman         |
| file_format | VARCHAR(20)   | Format file (pdf/epub) |
| file        | VARCHAR       | Path file ebook        |
| created_at  | TIMESTAMP     |                        |
| updated_at  | TIMESTAMP     |                        |

#### EBOOK_PHOTOS

| Atribut    | Tipe        | Keterangan       |
| ---------- | ----------- | ---------------- |
| id         | BIGINT (PK) | Primary Key      |
| ebook_id   | BIGINT (FK) | Relasi ke ebooks |
| photo      | VARCHAR     | Path foto sampul |
| created_at | TIMESTAMP   |                  |
| updated_at | TIMESTAMP   |                  |

#### TRANSACTIONS

| Atribut                 | Tipe          | Keterangan                  |
| ----------------------- | ------------- | --------------------------- |
| id                      | BIGINT (PK)   | Primary Key                 |
| user_id                 | BIGINT (FK)   | Relasi ke users             |
| total_amount            | DECIMAL(15,2) | Total pembayaran            |
| voucher_code            | VARCHAR       | Kode voucher dipakai        |
| discount_amount         | DECIMAL(15,2) | Jumlah diskon               |
| payment_status          | ENUM          | pending/paid/failed/expired |
| midtrans_order_id       | VARCHAR(100)  | ID order Midtrans           |
| midtrans_transaction_id | VARCHAR(100)  | ID transaksi Midtrans       |
| notes                   | TEXT          | Catatan                     |
| created_at              | TIMESTAMP     |                             |
| updated_at              | TIMESTAMP     |                             |

#### TRANSACTION_ITEMS

| Atribut        | Tipe          | Keterangan             |
| -------------- | ------------- | ---------------------- |
| id             | BIGINT (PK)   | Primary Key            |
| transaction_id | BIGINT (FK)   | Relasi ke transactions |
| ebook_id       | BIGINT (FK)   | Relasi ke ebooks       |
| qty            | INTEGER       | Jumlah (selalu 1)      |
| price          | DECIMAL(15,2) | Harga saat transaksi   |
| subtotal       | DECIMAL(15,2) | Subtotal               |
| created_at     | TIMESTAMP     |                        |
| updated_at     | TIMESTAMP     |                        |

#### VOUCHERS

| Atribut          | Tipe                   | Keterangan        |
| ---------------- | ---------------------- | ----------------- |
| id               | BIGINT (PK)            | Primary Key       |
| name             | VARCHAR                | Nama voucher      |
| code             | VARCHAR                | Kode unik voucher |
| discount_percent | INTEGER                | Persentase diskon |
| status           | ENUM(active, inactive) | Status voucher    |
| created_at       | TIMESTAMP              |                   |
| updated_at       | TIMESTAMP              |                   |

#### ARTICLES

| Atribut        | Tipe         | Keterangan         |
| -------------- | ------------ | ------------------ |
| id             | BIGINT (PK)  | Primary Key        |
| title          | VARCHAR(255) | Judul artikel      |
| slug           | VARCHAR(255) | URL-friendly title |
| content        | TEXT         | Isi artikel        |
| content_format | VARCHAR      | Format konten      |
| thumbnail      | VARCHAR(255) | Gambar thumbnail   |
| author         | VARCHAR(255) | Penulis            |
| excerpt        | TEXT         | Ringkasan          |
| post_type      | VARCHAR      | Tipe post          |
| created_at     | TIMESTAMP    |                    |
| updated_at     | TIMESTAMP    |                    |

#### ARTICLE_CATEGORIES

| Atribut     | Tipe         | Keterangan        |
| ----------- | ------------ | ----------------- |
| id          | BIGINT (PK)  | Primary Key       |
| name        | VARCHAR(100) | Nama kategori     |
| slug        | VARCHAR(150) | URL-friendly name |
| description | TEXT         | Deskripsi         |
| created_at  | TIMESTAMP    |                   |
| updated_at  | TIMESTAMP    |                   |

#### TAGS

| Atribut    | Tipe         | Keterangan        |
| ---------- | ------------ | ----------------- |
| id         | BIGINT (PK)  | Primary Key       |
| name       | VARCHAR(100) | Nama tag          |
| slug       | VARCHAR(150) | URL-friendly name |
| created_at | TIMESTAMP    |                   |
| updated_at | TIMESTAMP    |                   |

#### ARTICLE_TAG (Pivot)

| Atribut    | Tipe            | Keterangan         |
| ---------- | --------------- | ------------------ |
| article_id | BIGINT (FK, PK) | Relasi ke articles |
| tag_id     | BIGINT (FK, PK) | Relasi ke tags     |

#### ARTICLE_ARTICLE_CATEGORY (Pivot)

| Atribut             | Tipe            | Keterangan                   |
| ------------------- | --------------- | ---------------------------- |
| article_id          | BIGINT (FK, PK) | Relasi ke articles           |
| article_category_id | BIGINT (FK, PK) | Relasi ke article_categories |

### Relasi Antar Entitas (ERD Tekstual)

```
USERS ||--o{ TRANSACTIONS : "melakukan"
TRANSACTIONS ||--|{ TRANSACTION_ITEMS : "memiliki"
TRANSACTION_ITEMS }|--|| EBOOKS : "berisi"
EBOOKS }|--|| CATEGORIES : "termasuk"
EBOOKS ||--o{ EBOOK_PHOTOS : "memiliki"
ARTICLES }o--o{ ARTICLE_CATEGORIES : "article_article_category"
ARTICLES }o--o{ TAGS : "article_tag"
VOUCHERS ..o{ TRANSACTIONS : "digunakan pada"
```

---

## 4. LOGICAL RECORD STRUCTURE (LRS)

LRS menggambarkan struktur tabel setelah transformasi dari ERD ke model relasional.

```
USERS
┌─────────────────────────────────────────────────────┐
│ *id | name | email | password | phone | address |   │
│  avatar | role | email_verified_at | timestamps      │
└─────────────────────────────────────────────────────┘
         │ 1
         │
         │ N
TRANSACTIONS
┌──────────────────────────────────────────────────────────────┐
│ *id | **user_id | total_amount | voucher_code |              │
│  discount_amount | payment_status | midtrans_order_id |      │
│  midtrans_transaction_id | notes | timestamps                │
└──────────────────────────────────────────────────────────────┘
         │ 1
         │
         │ N
TRANSACTION_ITEMS
┌──────────────────────────────────────────────┐
│ *id | **transaction_id | **ebook_id |        │
│  qty | price | subtotal | timestamps         │
└──────────────────────────────────────────────┘
         │ N
         │
         │ 1
EBOOKS
┌──────────────────────────────────────────────────────────────┐
│ *id | **category_id | title | slug | author | isbn |         │
│  description | price | stock | total_pages | file_format |   │
│  file | timestamps                                           │
└──────────────────────────────────────────────────────────────┘
    │ 1                    │ 1
    │                      │
    │ N                    │ N
EBOOK_PHOTOS          CATEGORIES
┌──────────────┐      ┌──────────────────────────────┐
│ *id          │      │ *id | name | slug |           │
│ **ebook_id   │      │  description | timestamps     │
│ photo        │      └──────────────────────────────┘
│ timestamps   │
└──────────────┘

VOUCHERS
┌──────────────────────────────────────────┐
│ *id | name | code | discount_percent |   │
│  status | timestamps                     │
└──────────────────────────────────────────┘

ARTICLES
┌──────────────────────────────────────────────────────────┐
│ *id | title | slug | content | content_format |          │
│  thumbnail | author | excerpt | post_type | timestamps   │
└──────────────────────────────────────────────────────────┘
    │ N                              │ N
    │                                │
    │ N                              │ N
ARTICLE_CATEGORIES              TAGS
┌──────────────────────┐    ┌──────────────────────┐
│ *id | name | slug |  │    │ *id | name | slug |  │
│  description |       │    │  timestamps          │
│  timestamps          │    └──────────────────────┘
└──────────────────────┘

Tabel Pivot:
ARTICLE_ARTICLE_CATEGORY (*article_id, *article_category_id)
ARTICLE_TAG (*article_id, *tag_id)

Keterangan: * = Primary Key, ** = Foreign Key
```

---

## 5. USE CASE DIAGRAM

### Aktor

- **Guest** — Pengunjung yang belum login
- **User** — Pembeli yang sudah terdaftar dan login
- **Admin** — Pengelola sistem

### Use Case per Aktor

#### GUEST

- UC-01: Melihat halaman beranda
- UC-02: Melihat katalog ebook
- UC-03: Melihat detail ebook
- UC-04: Melihat artikel
- UC-05: Mencari ebook
- UC-06: Menambah ebook ke keranjang
- UC-07: Melakukan registrasi
- UC-08: Melakukan login
- UC-09: Menghubungi admin (form kontak)

#### USER (extends Guest)

- UC-10: Melihat dashboard pribadi
- UC-11: Melakukan checkout (keranjang)
- UC-12: Melakukan pembelian langsung (beli cepat)
- UC-13: Menggunakan kode voucher
- UC-14: Melakukan pembayaran via Midtrans
- UC-15: Melihat riwayat transaksi
- UC-16: Mengunduh/membaca ebook yang dibeli
- UC-17: Mengelola profil
- UC-18: Logout

#### ADMIN

- UC-19: Melihat dashboard admin (statistik & grafik)
- UC-20: Mengelola kategori ebook (CRUD)
- UC-21: Mengelola ebook (CRUD + upload file)
- UC-22: Mengelola voucher/diskon (CRUD)
- UC-23: Mengelola pengguna (CRUD)
- UC-24: Mengelola artikel (CRUD)
- UC-25: Mengelola kategori artikel (CRUD)
- UC-26: Mengelola tag artikel (CRUD)
- UC-27: Melihat & memfilter transaksi
- UC-28: Mencetak laporan transaksi
- UC-29: Logout

---

## 6. TEKNOLOGI YANG DIGUNAKAN

### Backend

| Teknologi         | Versi   | Fungsi                         |
| ----------------- | ------- | ------------------------------ |
| PHP               | 8.2     | Bahasa pemrograman server-side |
| Laravel           | 10.x    | Framework PHP MVC              |
| MySQL             | 8.x     | Database relasional            |
| Midtrans          | SDK 2.6 | Payment gateway                |
| Maatwebsite Excel | 3.1     | Export laporan Excel           |
| Yajra DataTables  | 10.x    | Tabel data dinamis server-side |
| Simple QR Code    | 4.2     | Generate QR Code               |

### Frontend

| Teknologi   | Versi | Fungsi                       |
| ----------- | ----- | ---------------------------- |
| Bootstrap   | 4/5   | Framework CSS responsif      |
| jQuery      | 3.7.1 | Manipulasi DOM & AJAX        |
| Chart.js    | 4.4   | Visualisasi grafik dashboard |
| Summernote  | 0.9   | Rich text editor artikel     |
| Swiper.js   | -     | Slider/carousel buku         |
| SweetAlert2 | 11    | Dialog konfirmasi            |
| Toastr.js   | -     | Notifikasi toast             |
| WOW.js      | -     | Animasi scroll               |

### Tools & Infrastruktur

| Tools           | Fungsi                   |
| --------------- | ------------------------ |
| Laravel Herd    | Local development server |
| Git & GitHub    | Version control          |
| Composer        | Dependency manager PHP   |
| Laravel Sanctum | API authentication       |

---

## 7. ARSITEKTUR SISTEM

### Pola Arsitektur: MVC (Model-View-Controller)

```
Browser/Client
      │
      ▼
   Routes (web.php)
      │
      ▼
 Middleware (Auth, Role)
      │
      ▼
  Controller
  ├── GuestController      → Halaman publik, checkout, payment
  ├── AuthController       → Login, register, logout
  ├── VoucherController    → Validasi voucher
  ├── Admin/
  │   ├── DashboardController    → Statistik & grafik
  │   ├── TransactionController  → Manajemen transaksi
  │   └── ManageMaster/
  │       ├── EbookController
  │       ├── CategoryController
  │       ├── VoucherController
  │       ├── UserController
  │       ├── ArticleController
  │       ├── ArticleCategoryController
  │       └── TagController
  └── User/
      ├── DashboardController
      ├── MyBookController
      ├── TransactionController
      └── ProfileController
      │
      ▼
    Model (Eloquent ORM)
      │
      ▼
   Database (MySQL)
```

### Alur Pembayaran Midtrans

```
User pilih ebook
      │
      ▼
POST /checkout
      │
      ▼
GuestController::checkout()
  - Buat record Transaction (status: pending)
  - Hitung diskon voucher
  - Kirim request ke Midtrans API
      │
      ▼
Midtrans mengembalikan snap_token
      │
      ▼
Frontend: window.snap.pay(snap_token)
      │
      ▼
User memilih metode pembayaran
(Kartu Kredit / VA / GoPay / dll)
      │
      ▼
Midtrans callback → POST /midtrans/callback
      │
      ▼
Update Transaction status → 'paid'
      │
      ▼
Redirect ke halaman sukses
User bisa akses ebook
```

---

## 8. KEAMANAN SISTEM

| Mekanisme        | Implementasi                       |
| ---------------- | ---------------------------------- |
| Autentikasi      | Laravel Auth + Session             |
| Otorisasi        | RoleMiddleware (admin/user)        |
| CSRF Protection  | Laravel CSRF Token                 |
| Password Hashing | Bcrypt (Laravel Hash)              |
| Input Validation | Laravel Validator                  |
| SQL Injection    | Eloquent ORM (parameterized query) |
| XSS Prevention   | Blade templating (auto-escape)     |

---

## 9. SPESIFIKASI KEBUTUHAN FUNGSIONAL

| Kode | Kebutuhan                                                          | Prioritas |
| ---- | ------------------------------------------------------------------ | --------- |
| F-01 | Sistem dapat menampilkan katalog ebook dengan pencarian dan filter | Tinggi    |
| F-02 | Sistem dapat memproses registrasi dan login pengguna               | Tinggi    |
| F-03 | Sistem dapat memproses transaksi pembelian ebook                   | Tinggi    |
| F-04 | Sistem terintegrasi dengan Midtrans untuk pembayaran               | Tinggi    |
| F-05 | Sistem dapat menerapkan kode voucher diskon                        | Sedang    |
| F-06 | Sistem dapat menampilkan ebook yang sudah dibeli                   | Tinggi    |
| F-07 | Admin dapat mengelola data ebook (CRUD)                            | Tinggi    |
| F-08 | Admin dapat melihat laporan transaksi dan grafik                   | Sedang    |
| F-09 | Sistem dapat menampilkan artikel/blog                              | Rendah    |
| F-10 | Admin dapat mengelola voucher diskon                               | Sedang    |

## 10. SPESIFIKASI KEBUTUHAN NON-FUNGSIONAL

| Kode  | Kebutuhan            | Keterangan                                          |
| ----- | -------------------- | --------------------------------------------------- |
| NF-01 | Performa             | Halaman load < 3 detik pada koneksi normal          |
| NF-02 | Keamanan             | Data transaksi terenkripsi, password di-hash        |
| NF-03 | Ketersediaan         | Sistem tersedia 24/7                                |
| NF-04 | Kemudahan Penggunaan | Antarmuka intuitif, tidak perlu pelatihan khusus    |
| NF-05 | Skalabilitas         | Dapat menangani penambahan data ebook dan user      |
| NF-06 | Kompatibilitas       | Berjalan di browser modern (Chrome, Firefox, Opera) |

---

## 11. DEPLOYMENT & HOSTING (CPANEL)

### Informasi Hosting

| Item             | Detail                       |
| ---------------- | ---------------------------- |
| Hosting Provider | cPanel Control Panel         |
| Server Location  | /home/baleidem/public_html   |
| Application Root | /home/baleidem/              |
| Domain           | baleide.id                   |
| PHP Version      | 8.2 (via MultiPHP)           |
| Database         | MySQL 8.x                    |
| SSL              | Let's Encrypt (Auto-renewed) |

### Struktur Folder di Server

```
/home/baleidem/
├── public_html/              # Folder publik (DocumentRoot)
│   ├── index.php             # Entry point Laravel
│   ├── .htaccess             # URL rewriting rules
│   ├── assets/               # CSS, JS, images (symlink)
│   ├── storage/              # Symlink ke storage/app/public
│   └── ...
├── app/                      # Kode aplikasi
├── resources/                # Views & asset sources
├── config/                   # Konfigurasi
├── database/                 # Migrations & seeders
├── routes/                   # Route definitions
├── storage/                  # User uploads & logs
├── vendor/                   # Composer dependencies
├── .env                      # Environment variables (JANGAN COMMIT)
├── artisan                   # Laravel CLI
├── composer.json             # Dependencies list
├── composer.lock             # Locked versions
└── .git/                     # Git repository

www/ → symlink ke public_html/
```

### Setup Awal di cPanel

#### 1. Setup Git Repository

```bash
cd /home/baleidem
git clone https://github.com/taufan759/baleide.git .
git fetch origin main
git checkout main
```

#### 2. Install Dependencies

```bash
cd /home/baleidem
composer install --optimize-autoloader --no-dev
```

#### 3. Setup Environment File

```bash
cp .env.example .env
# Edit .env dan sesuaikan dengan konfigurasi server:
# - APP_KEY (generate dengan: php artisan key:generate)
# - DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
# - MAIL_* untuk notifikasi
# - Midtrans credentials
```

#### 4. Setup Database

```bash
php artisan migrate
php artisan db:seed
```

#### 5. Setup Storage Symlink

```bash
php artisan storage:link
# Ini akan membuat symlink dari storage/app/public → public/storage
```

#### 6. Set File Permissions

```bash
chmod -R 755 /home/baleidem/storage
chmod -R 755 /home/baleidem/bootstrap/cache
```

#### 7. Setup .htaccess untuk URL Rewriting

File: `/home/baleidem/public_html/.htaccess`

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Hotlink Protection - Allow empty referer (direct access & internal)
RewriteEngine On
RewriteCond %{HTTP_REFERER} !^$
RewriteCond %{HTTP_REFERER} !^https?://(www\.)?baleide\.id [NC]
RewriteRule .*\.(jpg|jpeg|gif|png|bmp|webp)$ - [F,NC]

# cPanel PHP Configuration
<IfModule php8_module>
   php_flag display_errors Off
   php_value max_execution_time 3000
   php_value max_input_time 6000
   php_value max_input_vars 1000
   php_value memory_limit 512M
   php_value post_max_size 64M
   php_value session.gc_maxlifetime 1440
   php_value upload_max_filesize 64M
   php_flag zlib.output_compression Off
</IfModule>
```

### Update Aplikasi dari GitHub

Setelah push ke GitHub, pull di server dengan:

```bash
cd /home/baleidem
git fetch origin main
git checkout main
git pull origin main
```

Kemudian clear cache Laravel:

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

Jika ada perubahan dependencies:

```bash
composer install --optimize-autoloader --no-dev
```

Jika ada database migration baru:

```bash
php artisan migrate
```

### Environment Configuration (.env)

File `.env` pada production harus memiliki konfigurasi berikut:

```env
APP_NAME=Baleide
APP_ENV=production
APP_KEY=base64:XXX... (generate dengan php artisan key:generate)
APP_DEBUG=false
APP_URL=https://baleide.id

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=baleide_db
DB_USERNAME=baleide_user
DB_PASSWORD=strong_password

# Mail
MAIL_MAILER=smtp
MAIL_HOST=mail.baleide.id
MAIL_PORT=465
MAIL_USERNAME=noreply@baleide.id
MAIL_PASSWORD=mail_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@baleide.id

# Midtrans
MIDTRANS_SERVER_KEY=SB-Mid-server-key-xxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-key-xxx
MIDTRANS_ENVIRONMENT=production

# AI Services
DEEPSEEK_API_KEY=sk-xxxxx
DEEPSEEK_MODEL=deepseek-chat
DEEPSEEK_BASE_URL=https://api.deepseek.com
AI_DEFAULT_PROVIDER=deepseek

OPENAI_API_KEY=sk-proj-xxxxx
OPENAI_MODEL=gpt-4-mini
AI_PREMIUM_PROVIDER=openai
```

### Troubleshooting

#### 1. 500 Internal Server Error

**Penyebab**: APP_KEY belum di-generate atau permissions tidak tepat

```bash
php artisan key:generate
chmod -R 755 storage bootstrap/cache
```

#### 2. Gambar Tidak Muncul di Production

**Fix**: Pastikan symlink sudah dibuat dan .htaccess hotlink protection sudah diset

```bash
php artisan storage:link
# Cek file public/.htaccess sudah benar
```

#### 3. Session Hilang / Login Error

**Penyebab**: Session configuration atau storage permission issue

```bash
# Opsi 1: Clear sessions
rm -rf storage/framework/sessions/*

# Opsi 2: Ganti session driver ke database
php artisan session:table
php artisan migrate

# Di .env: SESSION_DRIVER=database
```

#### 4. Mail tidak terkirim

**Debug**: Test dengan:

```bash
php artisan tinker
Mail::raw('Test email', function ($message) {
    $message->to('test@example.com');
});
```

### Backup Strategy

Backup database secara berkala:

```bash
# Manual backup
mysqldump -u baleide_user -p baleide_db > /home/baleidem/backups/baleide_$(date +%Y%m%d_%H%M%S).sql

# atau via cPanel Backup Wizard
```

Backup file penting:

```bash
tar -czf /home/baleidem/backups/baleide_$(date +%Y%m%d).tar.gz \
  /home/baleidem/storage/app/public \
  /home/baleidem/.env
```

### Monitoring & Logging

Cek logs aplikasi:

```bash
tail -f storage/logs/laravel.log
```

Cek error PHP:

```bash
tail -f /var/log/apache2/domlogs/baleidem
```

Monitor server resources di cPanel Resource Usage
