# Tes Junior Programmer - Fast Print

Halo! 👋 repository ini berisi hasil pengerjaan saya untuk Tes Junior Programmer di Fast Print. Proyek ini dibangun menggunakan **Laravel 11** dan **PostgreSQL**, dengan tampilan yang modern dan responsif.

## 📋 Persyaratan Sistem
Pastikan komputer kamu sudah terinstall software berikut ya:
- **PHP 8.2** atau yang lebih baru
- **PostgreSQL** (Database)
- **Composer** (untuk install dependensi PHP)
- **Node.js & NPM** (untuk build assets frontend)

## 🚀 Cara Install dan Menjalankan Aplikasi

Ikuti langkah-langkah mudah di bawah ini untuk menjalankan aplikasi di komputer lokal kamu:

1. **Clone Repository**
   Download kodingan ini ke komputer kamu:
   ```bash
   git clone <repository_url>
   cd fastprint
   ```

2. **Install Dependensi**
   Install semua library yang dibutuhkan oleh Laravel dan frontend:
   ```bash
   composer install
   npm install
   ```

3. **Setting Environment**
   Duplicate file contoh environment, lalu sesuaikan dengan database kamu:
   - Copy file `.env.example` lalu ubah namanya menjadi `.env`.
   - Buka file `.env` dan atur bagian database seperti ini (sesuaikan passwordnya ya):
     ```env
     DB_CONNECTION=pgsql
     DB_HOST=127.0.0.1
     DB_PORT=5432
     DB_DATABASE=fastprint
     DB_USERNAME=postgres
     DB_PASSWORD=password_postgres_kamu
     ```

4. **Generate App Key**
   Buat kunci enkripsi aplikasi:
   ```bash
   php artisan key:generate
   ```

5. **Siapkan Database**
   Jalankan migrasi untuk membuat tabel-tabel di database:
   ```bash
   php artisan migrate
   ```

6. **Tarik Data dari API** 🔄
   Jalankan perintah khusus yang sudah saya buat untuk mengambil data produk dari API Fast Print. Script ini otomatis menghitung username dan password dinamis sesuai tanggal dan jam server (WIB).
   ```bash
   php artisan app:fetch-products
   ```
   _Tunggu sebentar sampai proses download data selesai._

7. **Build Assets Frontend**
   Untuk merapikan tampilan menggunakan Tailwind CSS:
   ```bash
   npm run build
   ```
   *(Atau gunakan `npm run dev` jika ingin mode development)*

8. **Jalankan Aplikasi** 🎉
   Nyalakan server lokal Laravel:
   ```bash
   php artisan serve
   ```
   Sekarang buka browser dan akses alamat: `http://localhost:8000`

---

## ✨ Fitur-Fitur
- **Sinkronisasi Data**: Script otomatis yang menarik data produk dari API eksternal.
- **Manajemen Produk**: Menampilkan daftar produk yang statusnya "bisa dijual".
- **CRUD Lengkap**: Bisa Tambah, Edit, dan Hapus produk dengan mudah.
- **Validasi Input**: Mencegah data kosong atau format harga yang salah (harus angka).
- **Konfirmasi Hapus**: Ada alert peringatan (SweetAlert) sebelum menghapus data supaya tidak salah klik.
- **Tampilan Premium**: Desain antarmuka yang bersih dan modern menggunakan Tailwind CSS.

## 🛠 Detail Teknis
- **Backend Framework**: Laravel 11.
- **Database**: PostgreSQL (Relational DB).
- **Frontend**: Blade Templating + Tailwind CSS.
- **Logika API**:
  Di file `app/Console/Commands/FetchProducts.php`, saya membuat logika untuk menembus autentikasi dinamis API Fast Print:
  1.  Generate **Username** dinamis: `tesprogrammer` + `TglBlnThn` + `C` + `Jam (WIB)`.
  2.  Generate **Password** dinamis (MD5): `bisacoding-Tgl-Bln-Thn`.
  3.  Data yang ditarik disimpan ke database, di mana Kategori dan Status otomatis dibuat jika belum ada.

---

Semoga hasil pengerjaan ini sesuai dengan ekspektasi. Terima kasih! 🙏
# junior-programmer-test-fast-print
