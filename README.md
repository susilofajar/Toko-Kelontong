# 🛒 TOKO-KELONTONG

<p align="center">
  <img src="https://res.cloudinary.com/dglqiqnij/image/upload/v1789966468/portfolio_uploads/snwbbhkptcj4jqbxh4hw.png" alt="TOKO-KELONTONG" width="900">
</p>

<p align="center">
  <strong>Aplikasi Manajemen Toko Kelontong Berbasis Laravel</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-Framework-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

## 📖 Tentang Project

**TOKO-KELONTONG** adalah aplikasi berbasis web yang dikembangkan untuk membantu proses pengelolaan toko kelontong secara lebih mudah, terstruktur, dan efisien.

Aplikasi ini dibangun menggunakan **Laravel** sebagai framework utama dan dapat dikembangkan untuk menangani berbagai kebutuhan operasional toko, seperti pengelolaan produk, stok barang, transaksi penjualan, serta data pelanggan.

Project ini cocok digunakan sebagai:

* 🏪 Sistem informasi toko kelontong
* 📦 Manajemen produk dan stok
* 💰 Manajemen transaksi penjualan
* 📊 Monitoring aktivitas toko
* 🎓 Project pembelajaran Laravel
* 💻 Project tugas kuliah atau portfolio

## ✨ Fitur

Beberapa fitur yang dapat tersedia dalam aplikasi:

* 🔐 Autentikasi pengguna
* 👤 Manajemen pengguna
* 📦 Manajemen produk
* 🏷️ Manajemen kategori produk
* 📊 Manajemen stok
* 🛒 Transaksi penjualan
* 💵 Perhitungan total transaksi
* 📋 Riwayat transaksi
* 📈 Dashboard dan statistik
* 🔎 Pencarian data
* ✏️ Tambah, ubah, dan hapus data
* 📱 Tampilan responsif

> Fitur dapat dikembangkan sesuai kebutuhan bisnis dan versi aplikasi yang digunakan.

## 🛠️ Teknologi

Project ini menggunakan beberapa teknologi berikut:

| Teknologi         | Keterangan              |
| ----------------- | ----------------------- |
| **Laravel**       | Framework PHP           |
| **PHP 8.x**       | Bahasa pemrograman      |
| **MySQL**         | Database                |
| **Blade**         | Template engine Laravel |
| **HTML5**         | Struktur halaman        |
| **CSS3**          | Styling                 |
| **JavaScript**    | Interaksi halaman       |
| **Composer**      | Dependency management   |
| **Node.js & NPM** | Asset/build management  |

## 📋 Persyaratan Sistem

Sebelum menjalankan project, pastikan perangkat sudah memiliki:

* PHP **8.x**
* Composer
* MySQL / MariaDB
* Node.js & NPM
* Git
* Web server seperti Apache atau Nginx

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/susilofajar/Toko-Kelontong.git
```

Masuk ke direktori project:

```bash
cd Toko-Kelontong
```

### 2. Install Dependency Laravel

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install
```

### 4. Buat File Environment

Salin file `.env.example` menjadi `.env`.

Linux/macOS:

```bash
cp .env.example .env
```

Windows:

```bash
copy .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Buka file `.env` kemudian sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toko_kelontong
DB_USERNAME=root
DB_PASSWORD=
```

Buat database dengan nama:

```text
toko_kelontong
```

Kemudian jalankan migration:

```bash
php artisan migrate
```

Jika project memiliki seeder:

```bash
php artisan db:seed
```

Atau jalankan migration sekaligus seeder:

```bash
php artisan migrate --seed
```

### 7. Build Asset

Untuk development:

```bash
npm run dev
```

Untuk production:

```bash
npm run build
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

## 📁 Struktur Project

Struktur utama project Laravel:

```text
TOKO-KELONTONG/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   ├── css/
│   ├── js/
│   └── images/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   ├── web.php
│   └── console.php
│
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

## 🗄️ Database

Database digunakan untuk menyimpan berbagai data aplikasi, seperti:

* Data pengguna
* Data kategori
* Data produk
* Data stok
* Data transaksi
* Detail transaksi
* Data pelanggan

Struktur database dapat dikembangkan sesuai kebutuhan sistem.

## 🔐 Keamanan

Beberapa hal yang perlu diperhatikan sebelum aplikasi digunakan pada production:

* Jangan commit file `.env` ke repository.
* Gunakan password database yang aman.
* Gunakan `APP_ENV=production`.
* Gunakan `APP_DEBUG=false` pada production.
* Pastikan konfigurasi `APP_KEY` telah tersedia.
* Gunakan HTTPS pada server production.
* Perbarui dependency Laravel dan PHP secara berkala.

Contoh konfigurasi production:

```env
APP_ENV=production
APP_DEBUG=false
```

## 🌐 Deployment

Untuk melakukan deployment ke hosting/server:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build

php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Pastikan document root web server diarahkan ke:

```text
/public
```

Jangan mengarahkan document root langsung ke folder utama project Laravel.

## 🧪 Testing

Untuk menjalankan testing:

```bash
php artisan test
```

Atau:

```bash
vendor/bin/phpunit
```

## 🔧 Pengembangan

Project ini masih dapat dikembangkan dengan berbagai fitur tambahan, misalnya:

* 📊 Laporan penjualan
* 🧾 Cetak struk
* 📦 Notifikasi stok minimum
* 📈 Grafik penjualan
* 👥 Role & permission pengguna
* 💳 Berbagai metode pembayaran
* 🏷️ Diskon dan promo
* 📱 API untuk aplikasi mobile
* 📤 Export data Excel/PDF
* 🔔 Notifikasi transaksi

## 🤝 Kontribusi

Kontribusi untuk pengembangan project sangat terbuka.

Langkah kontribusi:

1. Fork repository.
2. Buat branch baru.

```bash
git checkout -b feature/nama-fitur
```

3. Lakukan perubahan.
4. Commit perubahan.

```bash
git commit -m "Add: nama fitur"
```

5. Push ke repository.

```bash
git push origin feature/nama-fitur
```

6. Buat Pull Request.

## 📄 Lisensi

Project ini menggunakan lisensi **MIT**.

---

<p align="center">
  Dibuat dengan ❤️ menggunakan Laravel
</p>

<p align="center">
  <strong>TOKO-KELONTONG</strong>
</p>
