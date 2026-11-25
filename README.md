# Caren's Auction

### Sistem Informasi Pelelangan Berbasis Web

![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white)

## Demo Website

**[Kunjungi Website Caren's Auction](https://carens-auction.gamer.gd/)**

## Deskripsi Proyek

Caren's Auction merupakan sistem informasi pelelangan berbasis web yang dikembangkan untuk memfasilitasi proses pengajuan barang, verifikasi, penawaran harga, penentuan pemenang, dan simulasi pembayaran secara digital.

Aplikasi ini memiliki dua peran utama, yaitu pengguna (User) dan administrator (Admin), dengan hak akses dan fungsi yang berbeda.

Proyek ini dikembangkan sebagai portofolio Full Stack Web Development dengan mengintegrasikan antarmuka pengguna, logika aplikasi, dan pengelolaan basis data.

## Fitur Utama

### Pengguna (User)

- Registrasi dan login akun.
- Pencarian dan katalog barang lelang.
- Pengajuan barang beserta foto dan deskripsi.
- Penentuan harga awal dan harga buyout.
- Penawaran harga barang lelang.
- Simulasi pembayaran barang yang dimenangkan.
- Logout akun.

### Administrator (Admin)

- Login administrator.
- Dashboard pengelolaan pelelangan.
- Verifikasi dan persetujuan pengajuan barang.
- Pemantauan harga penawaran tertinggi.
- Pengakhiran lelang dan penentuan pemenang.
- Pengelolaan data barang dan pengguna.

## Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| HTML | Struktur halaman website |
| CSS | Desain antarmuka pengguna |
| PHP | Logika aplikasi dan pemrosesan data |
| MySQL | Pengelolaan basis data |
| PDO | Koneksi dan pemrosesan kueri database |
| XAMPP | Lingkungan pengembangan lokal |
| InfinityFree | Hosting website |
| GitHub | Dokumentasi dan pengelolaan kode sumber |

## Keamanan Aplikasi

Peningkatan keamanan yang diterapkan meliputi:

- Penyimpanan password menggunakan password hashing.
- Penggunaan PDO prepared statements.
- Validasi sesi dan hak akses pengguna.
- Perlindungan CSRF pada formulir.
- Validasi data masukan pengguna.
- Validasi format dan ukuran unggahan gambar.
- Pemisahan konfigurasi koneksi database.
- Pembatasan akses langsung terhadap file konfigurasi.

## Alur Sistem Pelelangan

1. Pengguna melakukan registrasi dan login.
2. Pengguna mengajukan barang untuk dilelang.
3. Administrator melakukan verifikasi pengajuan.
4. Barang yang disetujui ditampilkan pada katalog.
5. Pengguna lain mengajukan penawaran harga.
6. Administrator mengakhiri proses pelelangan.
7. Pemenang melakukan pembayaran simulasi.

## Dokumentasi Tampilan Website

### 1. Halaman Pemilihan Peran
Halaman awal untuk memilih akses sebagai pengguna atau administrator.

![Pemilihan Peran](./dokumentasi%20website/pilih-peran.png)

### 2. Halaman Login Pengguna
Halaman autentikasi pengguna untuk mengakses sistem pelelangan.

![Login Pengguna](./dokumentasi%20website/login.png)

### 3. Katalog Barang Lelang
Menampilkan daftar barang yang tersedia beserta informasi harga dan status pelelangan.

![Katalog Barang Lelang](./dokumentasi%20website/daftar-lelang.png)

### 4. Pengajuan Barang Lelang
Formulir pengajuan barang yang mencakup nama, deskripsi, harga awal, harga buyout, dan foto barang.

![Pengajuan Barang](./dokumentasi%20website/pengajuan.png)

### 5. Dashboard Administrator
Halaman pengelolaan aktivitas pelelangan, penawaran tertinggi, dan penentuan pemenang.

![Dashboard Admin](./dokumentasi%20website/dashboard-admin.png)

### 6. Verifikasi Pengajuan Barang
Halaman administrator untuk menerima atau menolak pengajuan barang lelang.

![Verifikasi Pengajuan](./dokumentasi%20website/verifikasi.png)

### 7. Pengelolaan Data Barang
Halaman administrator untuk memantau informasi dan status barang lelang.

![Data Barang](./dokumentasi%20website/data-barang.png)

### 8. Pengelolaan Data Pengguna
Halaman administrator untuk mengelola data pengguna yang terdaftar dalam sistem.

![Data Pengguna](./dokumentasi%20website/data-user.png)

## Struktur Proyek

    Carens-Auction/
    ├── backend/
    ├── frontend/
    ├── foto/
    ├── gambar/
    ├── style/
    ├── dokumentasi website/
    ├── dbauction.sql
    ├── .gitignore
    └── README.md

## Cara Menjalankan Secara Lokal

1. Unduh atau clone repositori ini.
2. Simpan folder proyek ke direktori htdocs pada XAMPP.
3. Aktifkan Apache dan MySQL.
4. Buat database baru melalui phpMyAdmin.
5. Impor file dbauction.sql.
6. Buat file backend/config.local.php dan sesuaikan konfigurasi host, nama database, username, serta password MySQL lokal.
7. Registrasikan akun pengguna untuk pengujian.
8. Buat akun administrator dengan password yang telah di-hash menggunakan PHP.
9. Buka alamat berikut melalui browser:

   http://localhost/Carens-Auction/frontend/view-form-login.php

## Catatan

Website ini merupakan proyek pembelajaran dan demonstrasi portofolio. Seluruh transaksi pembayaran bersifat simulasi dan tidak menggunakan payment gateway atau transaksi keuangan sungguhan.

Pengujian keamanan secara menyeluruh masih diperlukan sebelum aplikasi digunakan sebagai layanan komersial.

## Pengembang

**GitHub:** [deboraachriss](https://github.com/deboraachriss)

---

Caren's Auction | Full Stack Web Development Portfolio
