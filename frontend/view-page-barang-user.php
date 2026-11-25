<?php require_once __DIR__."/../backend/kelas-auction.php"; role('user'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>CAREN's Auction</title>
    <link rel="stylesheet" href="../style/style-page-user.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <img src='../foto/logoo.png' alt='Shopping Cart' class='logo'>
            <div class="search-bar-container">
                <form method="GET" action="view-page-barang-user.php" style="display: flex; align-items: center;">
                    <input type="text" name="search" placeholder="Search" class="search-input"
                        value="<?php echo is_string($_GET['search']??null) ? h($_GET['search']) : ''; ?>">
                    <button type="submit" class="search-button">
                        <img src='../foto/search.png' alt='Search'>
                    </button>
                </form>
            </div>

            <ul class="navbar-links">
                <li><a href="view-pengajuan-barang.php?aksi=ajukan" class="bb-btn">Ajukan Barang</a></li>
                <li><a href="view-pembayaran-user.php" class='logout-btn'><img src='../foto/cart.png'
                            alt='Shopping Cart' class='logout-logo'></a></li>
                <li><a href="view-login-user.php" class='logout-btn'><img src='../foto/icon-user.png' alt='User'
                            class='logout-logo'></a></li>
                <li><?php echo logout_form(); ?></li>
            </ul>
        </div>
    </nav>

    <div class="grid-container">
        <?php
        

        $act = new Auction();
        $db = $act->tampilkanBarangFull();

        $search = is_string($_GET['search']??null) ? substr($_GET['search'],0,200) : '';

        if ($search) {
            $db = array_filter($db, function ($barang) use ($search) {
                return stripos($barang['nama_barang'], $search) !== false; 
            });
        }

        foreach ($db as $barang) {
            echo '<div class="grid-item">';
            echo '<a href="view-page-detail-barang.php?id=' . $barang['id'] . '">';
            $gambar = base64_encode($barang['foto_barang']);
            echo '<img src="' . h(photo($barang['foto_barang'])) . '" alt="Gambar ' . h($barang['nama_barang']) . '">';
            echo '</a>';
            echo '<div class="item-name">' . h($barang['nama_barang']) . '</div>';
            echo '<div class="item-description">' . h($barang['deskripsi_barang']) . '</div>';
            echo '<div class="item-price">Rp ' . number_format($barang['harga_awal'], 0, ',', '.') . '</div>';

            $highestBid = $act->getHighestBid($barang['id']);
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            if ($barang['status_lelang'] === 'sold' && $highestBid && $highestBid['user_id'] == $user_id) {
                echo '<form method="post" action="../backend/proses-bayar.php">'; echo field();
                echo '<input type="hidden" name="id_barang" value="' . $barang['id'] . '">';
                echo '<button type="submit" class="btn bayar-btn">Bayar</button>';
                echo '</form>';
            } else {
                echo '<div class="item-status">Status: ' . h($barang['status_lelang']) . '</div>';
                if ($highestBid) {
                    echo '<div class="item-status">Tawaran Tertinggi: Rp ' . number_format($highestBid['bid_amount'], 0, ',', '.') . ' oleh ' . h($highestBid['nama_pengguna']) . '</div>';
                }
            }

            echo '</div>';
        }
        ?>
    </div>
</body>

</html>