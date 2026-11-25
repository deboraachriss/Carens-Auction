# Caren's Auction

Prototipe sistem informasi pelelangan berbasis web menggunakan PHP dan MySQL.

## Fitur
- Login administrator dan pengguna.
- Pengajuan barang dan verifikasi oleh administrator.
- Penawaran harga dan pengakhiran lelang.
- Pengelolaan status pembayaran.

## Teknologi
PHP, MySQL/MariaDB, HTML, CSS, dan PDO.

## Cara menjalankan secara lokal
1. Aktifkan Apache dan MySQL pada XAMPP.
2. Ekstrak folder `Carens-Auction` ke `htdocs`.
3. Buat database `dbauction` melalui phpMyAdmin dan impor `dbauction.sql`.
4. Sesuaikan koneksi lokal di `backend/kelas-auction.php`.
5. Buat akun pengujian lokal sebelum login. Database hanya berisi struktur tabel, tanpa data pengguna.
6. Buka `http://localhost/Carens-Auction/frontend/view-form-login.php`.

## Struktur proyek
- `backend/`: logika aplikasi.
- `frontend/`: halaman pengguna dan administrator.
- `foto/`: aset tampilan.
- `gambar/`: lokasi unggahan barang (data lama tidak disertakan).
- `style/`: CSS.
- `dbauction.sql`: struktur database.

## Batasan
Proyek pembelajaran ini belum siap untuk penggunaan produksi. Kode asli masih menangani kata sandi tanpa hashing dan memerlukan audit autentikasi, otorisasi, serta unggahan file sebelum hosting publik. GitHub Pages tidak menjalankan PHP atau MySQL. Pengujian menyeluruh belum dilakukan.
