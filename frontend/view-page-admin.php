<?php require_once __DIR__."/../backend/kelas-auction.php"; role('admin'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../style/style-dashboard-admin.css">
</head>

<body>
    <div class="container">

        <?php
         

        

        echo "<div class='sidebar'>";
        echo "<img src='../foto/logoo.png' alt='CARENs Auction' class='logo'>";

        echo "<div class='sidebar-header'>";
        echo "<h2>WELCOME ADMIN</h2>";

        
        echo logout_form(); 
        echo "</div>";


        echo "<ul>";
        echo "<li><a href=''><img src='../foto/icon-dasboard.png' alt='' class='logout-logo'>Dashboard</a></li>";
        echo "<li><a href='view-verif-pengajuan-barang.php'><img src='../foto/yesno.png' alt='Verifikasi Pengajuan' class='logout-logo'>Verifikasi Pengajuan</a></li>";
        echo "<li><a href='view-tampil-data-barang.php'><img src='../foto/icon-data.png' alt='Data Barang' class='logout-logo'>Data Barang</a></li>";
        echo "<li><a href='view-tampil-data-user.php'><img src='../foto/icon-user.png' alt='Data User' class='logout-logo'> Data User</a></li>";
        echo "</ul>";
        

        echo "</div>"; 
        ?>

        <div class="content">
            <h1>DATA BARANG LELANG</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Deskripsi</th>
                        <th>Harga Awal</th>
                        <th>Harga Tertinggi</th>
                        <th>Pemenang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $act = new Auction();
                    $barangList = $act->tampilkanBarang(); 

                    foreach ($barangList as $barang) {
                     
                        $highestBid = $act->getHighestBid($barang['id']); 

                        
                        $highestBidAmount = $highestBid ? number_format($highestBid['bid_amount'], 0, ',', '.') : 'Belum ada bid';
                        $bidderName = $highestBid ? h($highestBid['nama_pengguna']) : 'Belum ada pemenang';

                        echo "<tr>
                                <td>" . h($barang['nama_barang']) . "</td>
                                <td>" . h($barang['deskripsi_barang']) . "</td>
                                <td>Rp " . number_format($barang['harga_awal'], 0, ',', '.') . "</td>
                                <td>Rp " . $highestBidAmount . "</td>
                                <td>" . $bidderName . "</td>
                                <td>
                                    <form method='POST' action='../backend/proses-akhiri-lelang.php'>" . field() . "
                                        <input type='hidden' name='id_barang' value='" . h($barang['id']) . "'>
                                        <button type='submit' class='accept-btn'>Akhiri Lelang</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div> 
</body>
</html>