# Caren's Auction

Caren's Auction merupakan prototipe sistem informasi pelelangan berbasis web yang mempertemukan pengguna dan administrator dalam proses pengajuan, verifikasi, dan penawaran barang lelang. Proyek ini dikembangkan menggunakan PHP dan MySQL sebagai sarana pembelajaran pengembangan aplikasi web berbasis database.

## Fitur
- Login administrator dan pengguna.
- Pengajuan barang dan verifikasi oleh administrator.
- Penawaran harga dan pengakhiran lelang.
- Pengelolaan status pembayaran.
- Katalog dan pencarian barang lelang.
- Pengelolaan data barang dan pengguna oleh administrator.
- Pengajuan harga awal, harga buyout, dan foto barang.

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

## Dokumentasi tampilan website

Tangkapan layar berasal dari versi lokal aplikasi. Sebagian data dan jalur berkas disamarkan untuk menjaga privasi.

### Pemilihan peran pengguna dan administrator

![Pemilihan peran pengguna dan administrator](screenshots/pilih-peran.png)

### Halaman login pengguna

![Halaman login pengguna](screenshots/login.png)

### Katalog barang lelang

![Katalog barang lelang](screenshots/daftar-lelang.png)

### Pengelolaan data barang

![Pengelolaan data barang](screenshots/data-barang.png)

### Verifikasi pengajuan barang

![Verifikasi pengajuan barang](screenshots/verifikasi.png)

### Dashboard administrator

![Dashboard administrator](screenshots/dashboard-admin.png)

### Pengelolaan data pengguna (disamarkan)

![Pengelolaan data pengguna (disamarkan)](screenshots/data-user.png)

### Formulir pengajuan barang

![Formulir pengajuan barang](screenshots/pengajuan.png)

## Batasan
Proyek pembelajaran ini belum siap untuk penggunaan produksi. Kode asli masih menangani kata sandi tanpa hashing dan memerlukan audit autentikasi, otorisasi, serta unggahan file sebelum hosting publik. GitHub Pages tidak menjalankan PHP atau MySQL. Pengujian menyeluruh belum dilakukan.
