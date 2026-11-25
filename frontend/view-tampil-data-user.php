<?php require_once __DIR__."/../backend/kelas-auction.php"; role('admin'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang Page</title>
    <link rel="stylesheet" href="../style/style-dashboard-admin.css">
</head>
<body>
    <div class="container">

<?php
 


$act = new Auction();

$dtu = $act->tampilkanDataUser();

echo "<div class='sidebar'>";
echo "<img src='../foto/logoo.png' alt='CARENs Auction' class='logo'>";

echo "<div class='sidebar-header'>";
echo "<h2>WELCOME ADMIN</h2>";

echo logout_form(); 

echo "</div>";


echo "<ul>";
echo "<li><a href='view-page-admin.php'><img src='../foto/icon-dasboard.png' alt='' class='logout-logo'>Dashboard</a></li>";
echo "<li><a href='view-verif-pengajuan-barang.php'><img src='../foto/yesno.png' alt='Verifikasi Pengajuan' class='logout-logo'>Verifikasi Pengajuan</a></li>";
echo "<li><a href='view-tampil-data-barang.php'><img src='../foto/icon-data.png' alt='Data Barang' class='logout-logo'>Data Barang</a></li>";
echo "<li><a href=''><img src='../foto/icon-user.png' alt='Data User' class='logout-logo'> Data User</a></li>";
echo "</ul>";


echo "</div>"; 

echo "<div class='content'>";
echo "<h1>DATA USER CAREN's AUCTION</h1>";

echo "<table border='1'>";
echo "<tr>";
    echo "<th>Id</th>";
    echo "<th>Nama</th>";
    echo "<th>Nomor Rekening</th>";
    echo "<th>Aksi</th>";
echo "</tr>";

foreach($dtu as $d){
    echo "<tr>";
        echo "<td>".h($d["id"])."</td>";
        echo "<td>".h($d["nama"])."</td>";
        echo "<td>".h(str_repeat("*", max(0, strlen($d["no_rekening"])-2)).substr($d["no_rekening"],-2))."</td>";
        echo "<td>";
            echo action_form("proses-hapus-data-user.php", $d["id"], "delete-btn", "Hapus");
          
        echo "</td>";
    echo "</tr>";  
}
echo "</table>";

?>

</div> 
</body>
</html>