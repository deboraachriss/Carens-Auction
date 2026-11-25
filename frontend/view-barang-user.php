<?php require_once __DIR__."/../backend/kelas-auction.php"; role('user'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Daftar Barang User</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Deskripsi</th>
                    <th>Harga Awal</th>
                    <th>Harga Buyout</th>
                    <th>Status</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $act = new Auction();
                $barangList = $act->tampilkanBarangFull();

                foreach ($barangList as $barang) {
                    echo "<tr>
                            <td>".h($barang['nama_barang'])."</td>
                            <td>".h($barang['deskripsi_barang'])."</td>
                            <td>".h($barang['harga_awal'])."</td>
                            <td>".h($barang['harga_buyout'])."</td>
                            <td>".h($barang['status_lelang'])."</td>
                            <td><img src='".h(photo($barang['foto_barang']))."' alt='Foto Barang' style='width: 100px;'></td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>