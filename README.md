# Travel Belitung Begaye - Sistem E-Tourism

Sistem informasi pariwisata berbasis web (E-Tourism) untuk **Travel Belitung Begaye**, yang memungkinkan wisatawan menjelajahi paket wisata, melakukan pemesanan (booking) secara online, melakukan pembayaran digital melalui Midtrans, serta memberikan ulasan. Sistem ini juga dilengkapi panel admin untuk mengelola paket wisata, berita, galeri, dan moderasi ulasan.

Project ini dikembangkan sebagai **Tugas Akhir** program studi Teknik Rekayasa Perangkat Lunak (TRPL).

## Kontributor

| Nama | NIM | Program Studi |
|---|---|---|
| Hammam Abror Rofif | 4342201054 | Teknik Rekayasa Perangkat Lunak (TRPL) |

## Fitur Utama

### Sisi Wisatawan (Publik & Pengguna Terdaftar)
- Melihat beranda dan daftar paket tour
- Melihat detail paket tour
- Registrasi dan login akun
- Membaca berita/artikel wisata
- Melihat galeri foto
- Melakukan booking/reservasi paket wisata
- Pembayaran online terintegrasi **Midtrans Snap**
- Unduh tiket reservasi
- Mengelola profil akun
- Memberikan ulasan (review) terhadap paket wisata

### Sisi Admin
- Dashboard admin dengan laporan (termasuk cetak laporan)
- CRUD manajemen paket wisata
- CRUD manajemen berita
- CRUD manajemen galeri
- Moderasi ulasan wisatawan (verifikasi status & hapus)

## Tech Stack

- **Backend:** Laravel 10 (PHP 8.1+)
- **Database:** MySQL
- **Payment Gateway:** Midtrans (Snap API)
- **Frontend Build Tool:** Vite
- **CSS Framework:** Tailwind CSS
- **Autentikasi:** Laravel Sanctum

## Instalasi & Setup

### Prasyarat
Pastikan sudah terpasang di komputer kamu:
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL
- Akun [Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/) untuk mendapatkan Client Key & Server Key

### Langkah-langkah

1. **Clone repository**
   ```bash
   git clone https://github.com/Hemeem/etourism.git
   cd etourism
   ```

2. **Install dependency PHP**
   ```bash
   composer install
   ```

3. **Install dependency frontend**
   ```bash
   npm install
   ```

4. **Salin file environment**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi database**

   Buat database baru di MySQL (misalnya `etourism_db`), lalu sesuaikan `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=etourism_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Konfigurasi Midtrans**

   Tambahkan kredensial Midtrans Sandbox kamu ke `.env`:
   ```env
   MIDTRANS_MERCHANT_ID=your-merchant-id
   MIDTRANS_CLIENT_KEY=your-client-key
   MIDTRANS_SERVER_KEY=your-server-key
   MIDTRANS_IS_PRODUCTION=false
   ```

8. **Jalankan migrasi database beserta seeder**
   ```bash
   php artisan migrate --seed
   ```

   Seeder ini akan membuat data awal untuk paket wisata, berita, ulasan, serta 1 akun admin default:
   - **Email:** `admin@belitungbegaye.com`
   - **Password:** `admin123`

   > ⚠️ Segera ganti password admin default ini setelah instalasi, terutama jika aplikasi akan digunakan di lingkungan produksi.

9. **Buat symbolic link storage** (untuk gambar paket/berita/galeri)
   ```bash
   php artisan storage:link
   ```

10. **Build asset frontend**
    ```bash
    npm run dev
    ```
    Atau untuk build produksi:
    ```bash
    npm run build
    ```

11. **Jalankan server lokal**
    ```bash
    php artisan serve
    ```

    Aplikasi dapat diakses di `http://127.0.0.1:8000`.

## Struktur Direktori Penting

```
app/
├── Http/Controllers/          # Controller sisi wisatawan/publik
│   └── Admin/                 # Controller panel admin
├── Models/                    # Package, reservation, Payment, Review, News, Gallery, User
database/
├── migrations/                # Struktur tabel: packages, reservations, payments, reviews, news, bookings, galleries
├── seeders/                   # Data awal (paket, berita, ulasan, admin)
routes/
└── web.php                    # Definisi seluruh rute aplikasi
```

## Lisensi

Project ini dibuat untuk keperluan akademik (Tugas Akhir) dan tidak diperjualbelikan secara komersial.
