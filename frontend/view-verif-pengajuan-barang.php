<?php require_once __DIR__."/../backend/kelas-auction.php"; role('admin'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Page</title>
    <link rel="stylesheet" href="../style/style-dashboard-admin.css">
</head>
<body>
    <div class="container">

    <?php
 
       

        $act = new Auction();

        $dvb = $act->tampilkanVerifBarang();

  
        echo "<div class='sidebar'>";
        echo "<img src='../foto/logoo.png' alt='CARENs Auction' class='logo'>";

        echo "<div class='sidebar-header'>";
        echo "<h2>WELCOME ADMIN</h2>";
        
        echo logout_form();
        echo "</div>";


        echo "<ul>";
        echo "<li><a href='view-page-admin.php'><img src='../foto/icon-dasboard.png' alt='Dashboard Admin' class='logout-logo'>Dashboard</a></li>";
        echo "<li><a href=''><img src='../foto/yesno.png' alt='Verifikasi Pengajuan' class='logout-logo'>Verifikasi Pengajuan</a></li>";
        echo "<li><a href='view-tampil-data-barang.php'><img src='../foto/icon-data.png' alt='Data Barang' class='logout-logo'>Data Barang</a></li>";
        echo "<li><a href='view-tampil-data-user.php'><img src='../foto/icon-user.png' alt='Data User' class='logout-logo'> Data User</a></li>";
        echo "</ul>";
        

        echo "</div>"; 

    
        echo "<div class='content'>";
        echo "<h1>VERIFIKASI PENGAJUAN BARANG</h1>";
        echo "<table>";
        echo "<tr>";
            echo "<th>Nama Barang</th>";
            echo "<th>Deskripsi Barang</th>";
            echo "<th>Harga Awal</th>";
            echo "<th>Harga Buyout</th>";
            echo "<th>Foto Barang</th>";
            echo "<th>Verifikasi</th>";
        echo "</tr>";

        foreach($dvb as $d){
            echo "<tr>";
                echo "<td>".h($d["nama_barang"])."</td>";
                echo "<td>".h($d["deskripsi_barang"])."</td>";
                echo "<td>".h($d["harga_awal"])."</td>";
                echo "<td>".h($d["harga_buyout"])."</td>";
                echo "<td>".h($d["foto_barang"])."</td>";
                echo "<td>";
                echo "<div class='button-container'>";
                echo action_form("proses-pengajuan-diterima.php", $d["id"], "accept-btn", "Terima");
                echo action_form("proses-tolak-pengajuan.php", $d["id"], "reject-btn", "Tolak");
                echo "</div>";
                echo "</td>";
            echo "</tr>";  
        }
        echo "</table>";
        echo "</div>";

    ?>
    </div> 
</body>
</html>
