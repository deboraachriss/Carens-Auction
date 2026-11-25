<?php
require_once __DIR__."/kelas-auction.php";
post();
role('user'); $a=new Auction(); $id=ident('id_barang'); if (!$a->ajukanBid($id,money('bid_amount'),(int)$_SESSION['uid'])) fail('Penawaran tidak valid atau lelang sudah berakhir.'); go('../frontend/view-page-detail-barang.php?id='.$id);
